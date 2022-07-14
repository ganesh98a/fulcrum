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
 * DiscussionItemRelationship.
 *
 * @category   Framework
 * @package    DiscussionItemRelationship
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class DiscussionItemRelationship extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'DiscussionItemRelationship';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'discussion_item_relationships';

	/**
	 * primary key (`discussion_item_id`,`related_discussion_item_id`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrPrimaryKey = array(
		'discussion_item_id' => 'int',
		'related_discussion_item_id' => 'int'
	);

	/**
	 * No Unique Indexes, Just a Primary Key
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_discussion_item_relationship_via_primary_key' => array(
			'discussion_item_id' => 'int',
			'related_discussion_item_id' => 'int'
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
		'related_discussion_item_id' => 'related_discussion_item_id'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $discussion_item_id;
	public $related_discussion_item_id;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties

	// HTML ENTITY ENCODED NL2BR ORM string properties

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)
	protected static $_arrDiscussionItemRelationshipsByDiscussionItemId;
	protected static $_arrDiscussionItemRelationshipsByRelatedDiscussionItemId;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllDiscussionItemRelationships;

	// Foreign Key Objects
	private $_discussionItem;
	private $_relatedDiscussionItem;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='discussion_item_relationships')
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

	public function getRelatedDiscussionItem()
	{
		if (isset($this->_relatedDiscussionItem)) {
			return $this->_relatedDiscussionItem;
		} else {
			return null;
		}
	}

	public function setRelatedDiscussionItem($relatedDiscussionItem)
	{
		$this->_relatedDiscussionItem = $relatedDiscussionItem;
	}

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)
	public static function getArrDiscussionItemRelationshipsByDiscussionItemId()
	{
		if (isset(self::$_arrDiscussionItemRelationshipsByDiscussionItemId)) {
			return self::$_arrDiscussionItemRelationshipsByDiscussionItemId;
		} else {
			return null;
		}
	}

	public static function setArrDiscussionItemRelationshipsByDiscussionItemId($arrDiscussionItemRelationshipsByDiscussionItemId)
	{
		self::$_arrDiscussionItemRelationshipsByDiscussionItemId = $arrDiscussionItemRelationshipsByDiscussionItemId;
	}

	public static function getArrDiscussionItemRelationshipsByRelatedDiscussionItemId()
	{
		if (isset(self::$_arrDiscussionItemRelationshipsByRelatedDiscussionItemId)) {
			return self::$_arrDiscussionItemRelationshipsByRelatedDiscussionItemId;
		} else {
			return null;
		}
	}

	public static function setArrDiscussionItemRelationshipsByRelatedDiscussionItemId($arrDiscussionItemRelationshipsByRelatedDiscussionItemId)
	{
		self::$_arrDiscussionItemRelationshipsByRelatedDiscussionItemId = $arrDiscussionItemRelationshipsByRelatedDiscussionItemId;
	}

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllDiscussionItemRelationships()
	{
		if (isset(self::$_arrAllDiscussionItemRelationships)) {
			return self::$_arrAllDiscussionItemRelationships;
		} else {
			return null;
		}
	}

	public static function setArrAllDiscussionItemRelationships($arrAllDiscussionItemRelationships)
	{
		self::$_arrAllDiscussionItemRelationships = $arrAllDiscussionItemRelationships;
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
	 * Find by primary key (`discussion_item_id`,`related_discussion_item_id`).
	 *
	 * @param string $database
	 * @param int $discussion_item_id
	 * @param int $related_discussion_item_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findByDiscussionItemIdAndRelatedDiscussionItemId($database, $discussion_item_id, $related_discussion_item_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	dir.*

FROM `discussion_item_relationships` dir
WHERE dir.`discussion_item_id` = ?
AND dir.`related_discussion_item_id` = ?
";
		$arrValues = array($discussion_item_id, $related_discussion_item_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row && !empty($row)) {
			$discussionItemRelationship = self::instantiateOrm($database, 'DiscussionItemRelationship', $row);
			/* @var $discussionItemRelationship DiscussionItemRelationship */
			return $discussionItemRelationship;
		} else {
			return false;
		}
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Find by primary key (`discussion_item_id`,`related_discussion_item_id`) Extended.
	 *
	 * @param string $database
	 * @param int $discussion_item_id
	 * @param int $related_discussion_item_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findByDiscussionItemIdAndRelatedDiscussionItemIdExtended($database, $discussion_item_id, $related_discussion_item_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	dir_fk_di.`id` AS 'dir_fk_di__discussion_item_id',
	dir_fk_di.`meeting_id` AS 'dir_fk_di__meeting_id',
	dir_fk_di.`discussion_item_sequence_number` AS 'dir_fk_di__discussion_item_sequence_number',
	dir_fk_di.`discussion_item_status_id` AS 'dir_fk_di__discussion_item_status_id',
	dir_fk_di.`discussion_item_priority_id` AS 'dir_fk_di__discussion_item_priority_id',
	dir_fk_di.`discussion_item_cost_code_id` AS 'dir_fk_di__discussion_item_cost_code_id',
	dir_fk_di.`created_by_contact_id` AS 'dir_fk_di__created_by_contact_id',
	dir_fk_di.`discussion_item_title` AS 'dir_fk_di__discussion_item_title',
	dir_fk_di.`discussion_item` AS 'dir_fk_di__discussion_item',
	dir_fk_di.`created` AS 'dir_fk_di__created',
	dir_fk_di.`discussion_item_closed_date` AS 'dir_fk_di__discussion_item_closed_date',
	dir_fk_di.`sort_order` AS 'dir_fk_di__sort_order',

	dir_fk_related_di.`id` AS 'dir_fk_related_di__discussion_item_id',
	dir_fk_related_di.`meeting_id` AS 'dir_fk_related_di__meeting_id',
	dir_fk_related_di.`discussion_item_sequence_number` AS 'dir_fk_related_di__discussion_item_sequence_number',
	dir_fk_related_di.`discussion_item_status_id` AS 'dir_fk_related_di__discussion_item_status_id',
	dir_fk_related_di.`discussion_item_priority_id` AS 'dir_fk_related_di__discussion_item_priority_id',
	dir_fk_related_di.`discussion_item_cost_code_id` AS 'dir_fk_related_di__discussion_item_cost_code_id',
	dir_fk_related_di.`created_by_contact_id` AS 'dir_fk_related_di__created_by_contact_id',
	dir_fk_related_di.`discussion_item_title` AS 'dir_fk_related_di__discussion_item_title',
	dir_fk_related_di.`discussion_item` AS 'dir_fk_related_di__discussion_item',
	dir_fk_related_di.`created` AS 'dir_fk_related_di__created',
	dir_fk_related_di.`discussion_item_closed_date` AS 'dir_fk_related_di__discussion_item_closed_date',
	dir_fk_related_di.`sort_order` AS 'dir_fk_related_di__sort_order',

	dir.*

FROM `discussion_item_relationships` dir
	INNER JOIN `discussion_items` dir_fk_di ON dir.`discussion_item_id` = dir_fk_di.`id`
	INNER JOIN `discussion_items` dir_fk_related_di ON dir.`related_discussion_item_id` = dir_fk_related_di.`id`
WHERE dir.`discussion_item_id` = ?
AND dir.`related_discussion_item_id` = ?
";
		$arrValues = array($discussion_item_id, $related_discussion_item_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row && !empty($row)) {
			$discussionItemRelationship = self::instantiateOrm($database, 'DiscussionItemRelationship', $row);
			/* @var $discussionItemRelationship DiscussionItemRelationship */
			$discussionItemRelationship->convertPropertiesToData();

			if (isset($row['discussion_item_id'])) {
				$discussion_item_id = $row['discussion_item_id'];
				$row['dir_fk_di__id'] = $discussion_item_id;
				$discussionItem = self::instantiateOrm($database, 'DiscussionItem', $row, null, $discussion_item_id, 'dir_fk_di__');
				/* @var $discussionItem DiscussionItem */
				$discussionItem->convertPropertiesToData();
			} else {
				$discussionItem = false;
			}
			$discussionItemRelationship->setDiscussionItem($discussionItem);

			if (isset($row['related_discussion_item_id'])) {
				$related_discussion_item_id = $row['related_discussion_item_id'];
				$row['dir_fk_related_di__id'] = $related_discussion_item_id;
				$relatedDiscussionItem = self::instantiateOrm($database, 'DiscussionItem', $row, null, $related_discussion_item_id, 'dir_fk_related_di__');
				/* @var $relatedDiscussionItem DiscussionItem */
				$relatedDiscussionItem->convertPropertiesToData();
			} else {
				$relatedDiscussionItem = false;
			}
			$discussionItemRelationship->setRelatedDiscussionItem($relatedDiscussionItem);

			return $discussionItemRelationship;
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
	 * @param array $arrDiscussionItemIdAndRelatedDiscussionItemIdList
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadDiscussionItemRelationshipsByArrDiscussionItemIdAndRelatedDiscussionItemIdList($database, $arrDiscussionItemIdAndRelatedDiscussionItemIdList, Input $options=null)
	{
		if (empty($arrDiscussionItemIdAndRelatedDiscussionItemIdList)) {
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
		// ORDER BY `discussion_item_id` ASC, `related_discussion_item_id` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpDiscussionItemRelationship = new DiscussionItemRelationship($database);
			$sqlOrderByColumns = $tmpDiscussionItemRelationship->constructSqlOrderByColumns($arrOrderByAttributes);

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
		foreach ($arrDiscussionItemIdAndRelatedDiscussionItemIdList as $k => $arrTmp) {
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
		if (count($arrDiscussionItemIdAndRelatedDiscussionItemIdList) > 1) {
			$sqlWhere = join($arrSqlWhere, ' OR ');
			$sqlWhere = "WHERE ($sqlWhere)";
		} else {
			$sqlWhere = "WHERE $tmpInnerAnd";
		}

		$query =
"
SELECT

	dir.*

FROM `discussion_item_relationships` dir
{$sqlWhere}{$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrDiscussionItemRelationshipsByArrDiscussionItemIdAndRelatedDiscussionItemIdList = array();
		while ($row = $db->fetch()) {
			$discussionItemRelationship = self::instantiateOrm($database, 'DiscussionItemRelationship', $row);
			/* @var $discussionItemRelationship DiscussionItemRelationship */
			$arrDiscussionItemRelationshipsByArrDiscussionItemIdAndRelatedDiscussionItemIdList[] = $discussionItemRelationship;
		}

		$db->free_result();

		return $arrDiscussionItemRelationshipsByArrDiscussionItemIdAndRelatedDiscussionItemIdList;
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `discussion_item_relationships_fk_di` foreign key (`discussion_item_id`) references `discussion_items` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $discussion_item_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadDiscussionItemRelationshipsByDiscussionItemId($database, $discussion_item_id, Input $options=null)
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
			self::$_arrDiscussionItemRelationshipsByDiscussionItemId = null;
		}

		$arrDiscussionItemRelationshipsByDiscussionItemId = self::$_arrDiscussionItemRelationshipsByDiscussionItemId;
		if (isset($arrDiscussionItemRelationshipsByDiscussionItemId) && !empty($arrDiscussionItemRelationshipsByDiscussionItemId)) {
			return $arrDiscussionItemRelationshipsByDiscussionItemId;
		}

		$discussion_item_id = (int) $discussion_item_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `discussion_item_id` ASC, `related_discussion_item_id` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpDiscussionItemRelationship = new DiscussionItemRelationship($database);
			$sqlOrderByColumns = $tmpDiscussionItemRelationship->constructSqlOrderByColumns($arrOrderByAttributes);

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
	dir.*

FROM `discussion_item_relationships` dir
WHERE dir.`discussion_item_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `discussion_item_id` ASC, `related_discussion_item_id` ASC
		$arrValues = array($discussion_item_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrDiscussionItemRelationshipsByDiscussionItemId = array();
		while ($row = $db->fetch()) {
			$discussionItemRelationship = self::instantiateOrm($database, 'DiscussionItemRelationship', $row);
			/* @var $discussionItemRelationship DiscussionItemRelationship */
			$arrDiscussionItemRelationshipsByDiscussionItemId[] = $discussionItemRelationship;
		}

		$db->free_result();

		self::$_arrDiscussionItemRelationshipsByDiscussionItemId = $arrDiscussionItemRelationshipsByDiscussionItemId;

		return $arrDiscussionItemRelationshipsByDiscussionItemId;
	}

	/**
	 * Load by constraint `discussion_item_relationships_fk_related_di` foreign key (`related_discussion_item_id`) references `discussion_items` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $related_discussion_item_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadDiscussionItemRelationshipsByRelatedDiscussionItemId($database, $related_discussion_item_id, Input $options=null)
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
			self::$_arrDiscussionItemRelationshipsByRelatedDiscussionItemId = null;
		}

		$arrDiscussionItemRelationshipsByRelatedDiscussionItemId = self::$_arrDiscussionItemRelationshipsByRelatedDiscussionItemId;
		if (isset($arrDiscussionItemRelationshipsByRelatedDiscussionItemId) && !empty($arrDiscussionItemRelationshipsByRelatedDiscussionItemId)) {
			return $arrDiscussionItemRelationshipsByRelatedDiscussionItemId;
		}

		$related_discussion_item_id = (int) $related_discussion_item_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `discussion_item_id` ASC, `related_discussion_item_id` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpDiscussionItemRelationship = new DiscussionItemRelationship($database);
			$sqlOrderByColumns = $tmpDiscussionItemRelationship->constructSqlOrderByColumns($arrOrderByAttributes);

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
	dir.*

FROM `discussion_item_relationships` dir
WHERE dir.`related_discussion_item_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `discussion_item_id` ASC, `related_discussion_item_id` ASC
		$arrValues = array($related_discussion_item_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrDiscussionItemRelationshipsByRelatedDiscussionItemId = array();
		while ($row = $db->fetch()) {
			$discussionItemRelationship = self::instantiateOrm($database, 'DiscussionItemRelationship', $row);
			/* @var $discussionItemRelationship DiscussionItemRelationship */
			$arrDiscussionItemRelationshipsByRelatedDiscussionItemId[] = $discussionItemRelationship;
		}

		$db->free_result();

		self::$_arrDiscussionItemRelationshipsByRelatedDiscussionItemId = $arrDiscussionItemRelationshipsByRelatedDiscussionItemId;

		return $arrDiscussionItemRelationshipsByRelatedDiscussionItemId;
	}

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all discussion_item_relationships records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllDiscussionItemRelationships($database, Input $options=null)
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
			self::$_arrAllDiscussionItemRelationships = null;
		}

		$arrAllDiscussionItemRelationships = self::$_arrAllDiscussionItemRelationships;
		if (isset($arrAllDiscussionItemRelationships) && !empty($arrAllDiscussionItemRelationships)) {
			return $arrAllDiscussionItemRelationships;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `discussion_item_id` ASC, `related_discussion_item_id` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpDiscussionItemRelationship = new DiscussionItemRelationship($database);
			$sqlOrderByColumns = $tmpDiscussionItemRelationship->constructSqlOrderByColumns($arrOrderByAttributes);

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
	dir.*

FROM `discussion_item_relationships` dir{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `discussion_item_id` ASC, `related_discussion_item_id` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllDiscussionItemRelationships = array();
		while ($row = $db->fetch()) {
			$discussionItemRelationship = self::instantiateOrm($database, 'DiscussionItemRelationship', $row);
			/* @var $discussionItemRelationship DiscussionItemRelationship */
			$arrAllDiscussionItemRelationships[] = $discussionItemRelationship;
		}

		$db->free_result();

		self::$_arrAllDiscussionItemRelationships = $arrAllDiscussionItemRelationships;

		return $arrAllDiscussionItemRelationships;
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
INTO `discussion_item_relationships`
(`discussion_item_id`, `related_discussion_item_id`)
VALUES (?, ?)
";
		$arrValues = array($this->discussion_item_id, $this->related_discussion_item_id);
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

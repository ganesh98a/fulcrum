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
 * SubcontractorBidStatusGroupToSubcontractorBidStatus.
 *
 * @category   Framework
 * @package    SubcontractorBidStatusGroupToSubcontractorBidStatus
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class SubcontractorBidStatusGroupToSubcontractorBidStatus extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'SubcontractorBidStatusGroupToSubcontractorBidStatus';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'subcontractor_bid_status_groups_to_subcontractor_bid_statuses';

	/**
	 * primary key (`subcontractor_bid_status_group_id`,`subcontractor_bid_status_id`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrPrimaryKey = array(
		'subcontractor_bid_status_group_id' => 'int',
		'subcontractor_bid_status_id' => 'int'
	);

	/**
	 * No Unique Indexes, Just a Primary Key
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_subcontractor_bid_status_group_to_subcontractor_bid_status_via_primary_key' => array(
			'subcontractor_bid_status_group_id' => 'int',
			'subcontractor_bid_status_id' => 'int'
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
		'subcontractor_bid_status_group_id' => 'subcontractor_bid_status_group_id',
		'subcontractor_bid_status_id' => 'subcontractor_bid_status_id',

		'subcontractor_bid_status_alias' => 'subcontractor_bid_status_alias',
		'sort_order' => 'sort_order'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $subcontractor_bid_status_group_id;
	public $subcontractor_bid_status_id;

	public $subcontractor_bid_status_alias;
	public $sort_order;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties
	public $escaped_subcontractor_bid_status_alias;

	// HTML ENTITY ENCODED NL2BR ORM string properties
	public $escaped_subcontractor_bid_status_alias_nl2br;

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)
	protected static $_arrSubcontractorBidStatusGroupsToSubcontractorBidStatusesBySubcontractorBidStatusGroupId;
	protected static $_arrSubcontractorBidStatusGroupsToSubcontractorBidStatusesBySubcontractorBidStatusId;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllSubcontractorBidStatusGroupsToSubcontractorBidStatuses;

	// Foreign Key Objects
	private $_subcontractorBidStatusGroup;
	private $_subcontractorBidStatus;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='subcontractor_bid_status_groups_to_subcontractor_bid_statuses')
	{
		parent::__construct($table);
		$this->setDatabase($database);
	}

	// Foreign Key Object Accessor Methods
	public function getSubcontractorBidStatusGroup()
	{
		if (isset($this->_subcontractorBidStatusGroup)) {
			return $this->_subcontractorBidStatusGroup;
		} else {
			return null;
		}
	}

	public function setSubcontractorBidStatusGroup($subcontractorBidStatusGroup)
	{
		$this->_subcontractorBidStatusGroup = $subcontractorBidStatusGroup;
	}

	public function getSubcontractorBidStatus()
	{
		if (isset($this->_subcontractorBidStatus)) {
			return $this->_subcontractorBidStatus;
		} else {
			return null;
		}
	}

	public function setSubcontractorBidStatus($subcontractorBidStatus)
	{
		$this->_subcontractorBidStatus = $subcontractorBidStatus;
	}

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)
	public static function getArrSubcontractorBidStatusGroupsToSubcontractorBidStatusesBySubcontractorBidStatusGroupId()
	{
		if (isset(self::$_arrSubcontractorBidStatusGroupsToSubcontractorBidStatusesBySubcontractorBidStatusGroupId)) {
			return self::$_arrSubcontractorBidStatusGroupsToSubcontractorBidStatusesBySubcontractorBidStatusGroupId;
		} else {
			return null;
		}
	}

	public static function setArrSubcontractorBidStatusGroupsToSubcontractorBidStatusesBySubcontractorBidStatusGroupId($arrSubcontractorBidStatusGroupsToSubcontractorBidStatusesBySubcontractorBidStatusGroupId)
	{
		self::$_arrSubcontractorBidStatusGroupsToSubcontractorBidStatusesBySubcontractorBidStatusGroupId = $arrSubcontractorBidStatusGroupsToSubcontractorBidStatusesBySubcontractorBidStatusGroupId;
	}

	public static function getArrSubcontractorBidStatusGroupsToSubcontractorBidStatusesBySubcontractorBidStatusId()
	{
		if (isset(self::$_arrSubcontractorBidStatusGroupsToSubcontractorBidStatusesBySubcontractorBidStatusId)) {
			return self::$_arrSubcontractorBidStatusGroupsToSubcontractorBidStatusesBySubcontractorBidStatusId;
		} else {
			return null;
		}
	}

	public static function setArrSubcontractorBidStatusGroupsToSubcontractorBidStatusesBySubcontractorBidStatusId($arrSubcontractorBidStatusGroupsToSubcontractorBidStatusesBySubcontractorBidStatusId)
	{
		self::$_arrSubcontractorBidStatusGroupsToSubcontractorBidStatusesBySubcontractorBidStatusId = $arrSubcontractorBidStatusGroupsToSubcontractorBidStatusesBySubcontractorBidStatusId;
	}

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllSubcontractorBidStatusGroupsToSubcontractorBidStatuses()
	{
		if (isset(self::$_arrAllSubcontractorBidStatusGroupsToSubcontractorBidStatuses)) {
			return self::$_arrAllSubcontractorBidStatusGroupsToSubcontractorBidStatuses;
		} else {
			return null;
		}
	}

	public static function setArrAllSubcontractorBidStatusGroupsToSubcontractorBidStatuses($arrAllSubcontractorBidStatusGroupsToSubcontractorBidStatuses)
	{
		self::$_arrAllSubcontractorBidStatusGroupsToSubcontractorBidStatuses = $arrAllSubcontractorBidStatusGroupsToSubcontractorBidStatuses;
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
	 * Find by primary key (`subcontractor_bid_status_group_id`,`subcontractor_bid_status_id`).
	 *
	 * @param string $database
	 * @param int $subcontractor_bid_status_group_id
	 * @param int $subcontractor_bid_status_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findBySubcontractorBidStatusGroupIdAndSubcontractorBidStatusId($database, $subcontractor_bid_status_group_id, $subcontractor_bid_status_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	sbsg2sbs.*

FROM `subcontractor_bid_status_groups_to_subcontractor_bid_statuses` sbsg2sbs
WHERE sbsg2sbs.`subcontractor_bid_status_group_id` = ?
AND sbsg2sbs.`subcontractor_bid_status_id` = ?
";
		$arrValues = array($subcontractor_bid_status_group_id, $subcontractor_bid_status_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row && !empty($row)) {
			$subcontractorBidStatusGroupToSubcontractorBidStatus = self::instantiateOrm($database, 'SubcontractorBidStatusGroupToSubcontractorBidStatus', $row);
			/* @var $subcontractorBidStatusGroupToSubcontractorBidStatus SubcontractorBidStatusGroupToSubcontractorBidStatus */
			return $subcontractorBidStatusGroupToSubcontractorBidStatus;
		} else {
			return false;
		}
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Find by primary key (`subcontractor_bid_status_group_id`,`subcontractor_bid_status_id`) Extended.
	 *
	 * @param string $database
	 * @param int $subcontractor_bid_status_group_id
	 * @param int $subcontractor_bid_status_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findBySubcontractorBidStatusGroupIdAndSubcontractorBidStatusIdExtended($database, $subcontractor_bid_status_group_id, $subcontractor_bid_status_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	sbsg2sbs_fk_sbsg.`id` AS 'sbsg2sbs_fk_sbsg__subcontractor_bid_status_group_id',
	sbsg2sbs_fk_sbsg.`subcontractor_bid_status_group` AS 'sbsg2sbs_fk_sbsg__subcontractor_bid_status_group',
	sbsg2sbs_fk_sbsg.`description` AS 'sbsg2sbs_fk_sbsg__description',
	sbsg2sbs_fk_sbsg.`sort_order` AS 'sbsg2sbs_fk_sbsg__sort_order',

	sbsg2sbs_fk_sbs.`id` AS 'sbsg2sbs_fk_sbs__subcontractor_bid_status_id',
	sbsg2sbs_fk_sbs.`subcontractor_bid_status` AS 'sbsg2sbs_fk_sbs__subcontractor_bid_status',
	sbsg2sbs_fk_sbs.`sort_order` AS 'sbsg2sbs_fk_sbs__sort_order',
	sbsg2sbs_fk_sbs.`disabled_flag` AS 'sbsg2sbs_fk_sbs__disabled_flag',

	sbsg2sbs.*

FROM `subcontractor_bid_status_groups_to_subcontractor_bid_statuses` sbsg2sbs
	INNER JOIN `subcontractor_bid_status_groups` sbsg2sbs_fk_sbsg ON sbsg2sbs.`subcontractor_bid_status_group_id` = sbsg2sbs_fk_sbsg.`id`
	INNER JOIN `subcontractor_bid_statuses` sbsg2sbs_fk_sbs ON sbsg2sbs.`subcontractor_bid_status_id` = sbsg2sbs_fk_sbs.`id`
WHERE sbsg2sbs.`subcontractor_bid_status_group_id` = ?
AND sbsg2sbs.`subcontractor_bid_status_id` = ?
";
		$arrValues = array($subcontractor_bid_status_group_id, $subcontractor_bid_status_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row && !empty($row)) {
			$subcontractorBidStatusGroupToSubcontractorBidStatus = self::instantiateOrm($database, 'SubcontractorBidStatusGroupToSubcontractorBidStatus', $row);
			/* @var $subcontractorBidStatusGroupToSubcontractorBidStatus SubcontractorBidStatusGroupToSubcontractorBidStatus */
			$subcontractorBidStatusGroupToSubcontractorBidStatus->convertPropertiesToData();

			if (isset($row['subcontractor_bid_status_group_id'])) {
				$subcontractor_bid_status_group_id = $row['subcontractor_bid_status_group_id'];
				$row['sbsg2sbs_fk_sbsg__id'] = $subcontractor_bid_status_group_id;
				$subcontractorBidStatusGroup = self::instantiateOrm($database, 'SubcontractorBidStatusGroup', $row, null, $subcontractor_bid_status_group_id, 'sbsg2sbs_fk_sbsg__');
				/* @var $subcontractorBidStatusGroup SubcontractorBidStatusGroup */
				$subcontractorBidStatusGroup->convertPropertiesToData();
			} else {
				$subcontractorBidStatusGroup = false;
			}
			$subcontractorBidStatusGroupToSubcontractorBidStatus->setSubcontractorBidStatusGroup($subcontractorBidStatusGroup);

			if (isset($row['subcontractor_bid_status_id'])) {
				$subcontractor_bid_status_id = $row['subcontractor_bid_status_id'];
				$row['sbsg2sbs_fk_sbs__id'] = $subcontractor_bid_status_id;
				$subcontractorBidStatus = self::instantiateOrm($database, 'SubcontractorBidStatus', $row, null, $subcontractor_bid_status_id, 'sbsg2sbs_fk_sbs__');
				/* @var $subcontractorBidStatus SubcontractorBidStatus */
				$subcontractorBidStatus->convertPropertiesToData();
			} else {
				$subcontractorBidStatus = false;
			}
			$subcontractorBidStatusGroupToSubcontractorBidStatus->setSubcontractorBidStatus($subcontractorBidStatus);

			return $subcontractorBidStatusGroupToSubcontractorBidStatus;
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
	 * @param array $arrSubcontractorBidStatusGroupIdAndSubcontractorBidStatusIdList
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubcontractorBidStatusGroupsToSubcontractorBidStatusesByArrSubcontractorBidStatusGroupIdAndSubcontractorBidStatusIdList($database, $arrSubcontractorBidStatusGroupIdAndSubcontractorBidStatusIdList, Input $options=null)
	{
		if (empty($arrSubcontractorBidStatusGroupIdAndSubcontractorBidStatusIdList)) {
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
		// ORDER BY `subcontractor_bid_status_group_id` ASC, `subcontractor_bid_status_id` ASC, `subcontractor_bid_status_alias` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY sbsg2sbs.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubcontractorBidStatusGroupToSubcontractorBidStatus = new SubcontractorBidStatusGroupToSubcontractorBidStatus($database);
			$sqlOrderByColumns = $tmpSubcontractorBidStatusGroupToSubcontractorBidStatus->constructSqlOrderByColumns($arrOrderByAttributes);

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
		foreach ($arrSubcontractorBidStatusGroupIdAndSubcontractorBidStatusIdList as $k => $arrTmp) {
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
		if (count($arrSubcontractorBidStatusGroupIdAndSubcontractorBidStatusIdList) > 1) {
			$sqlWhere = join($arrSqlWhere, ' OR ');
			$sqlWhere = "WHERE ($sqlWhere)";
		} else {
			$sqlWhere = "WHERE $tmpInnerAnd";
		}

		$query =
"
SELECT

	sbsg2sbs.*

FROM `subcontractor_bid_status_groups_to_subcontractor_bid_statuses` sbsg2sbs
{$sqlWhere}{$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubcontractorBidStatusGroupsToSubcontractorBidStatusesByArrSubcontractorBidStatusGroupIdAndSubcontractorBidStatusIdList = array();
		while ($row = $db->fetch()) {
			$subcontractorBidStatusGroupToSubcontractorBidStatus = self::instantiateOrm($database, 'SubcontractorBidStatusGroupToSubcontractorBidStatus', $row);
			/* @var $subcontractorBidStatusGroupToSubcontractorBidStatus SubcontractorBidStatusGroupToSubcontractorBidStatus */
			$arrSubcontractorBidStatusGroupsToSubcontractorBidStatusesByArrSubcontractorBidStatusGroupIdAndSubcontractorBidStatusIdList[] = $subcontractorBidStatusGroupToSubcontractorBidStatus;
		}

		$db->free_result();

		return $arrSubcontractorBidStatusGroupsToSubcontractorBidStatusesByArrSubcontractorBidStatusGroupIdAndSubcontractorBidStatusIdList;
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `sbsg2sbs_fk_sbsg` foreign key (`subcontractor_bid_status_group_id`) references `subcontractor_bid_status_groups` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $subcontractor_bid_status_group_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubcontractorBidStatusGroupsToSubcontractorBidStatusesBySubcontractorBidStatusGroupId($database, $subcontractor_bid_status_group_id, Input $options=null)
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
			self::$_arrSubcontractorBidStatusGroupsToSubcontractorBidStatusesBySubcontractorBidStatusGroupId = null;
		}

		$arrSubcontractorBidStatusGroupsToSubcontractorBidStatusesBySubcontractorBidStatusGroupId = self::$_arrSubcontractorBidStatusGroupsToSubcontractorBidStatusesBySubcontractorBidStatusGroupId;
		if (isset($arrSubcontractorBidStatusGroupsToSubcontractorBidStatusesBySubcontractorBidStatusGroupId) && !empty($arrSubcontractorBidStatusGroupsToSubcontractorBidStatusesBySubcontractorBidStatusGroupId)) {
			return $arrSubcontractorBidStatusGroupsToSubcontractorBidStatusesBySubcontractorBidStatusGroupId;
		}

		$subcontractor_bid_status_group_id = (int) $subcontractor_bid_status_group_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `subcontractor_bid_status_group_id` ASC, `subcontractor_bid_status_id` ASC, `subcontractor_bid_status_alias` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY sbsg2sbs.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubcontractorBidStatusGroupToSubcontractorBidStatus = new SubcontractorBidStatusGroupToSubcontractorBidStatus($database);
			$sqlOrderByColumns = $tmpSubcontractorBidStatusGroupToSubcontractorBidStatus->constructSqlOrderByColumns($arrOrderByAttributes);

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
	sbsg2sbs.*

FROM `subcontractor_bid_status_groups_to_subcontractor_bid_statuses` sbsg2sbs
WHERE sbsg2sbs.`subcontractor_bid_status_group_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `subcontractor_bid_status_group_id` ASC, `subcontractor_bid_status_id` ASC, `subcontractor_bid_status_alias` ASC, `sort_order` ASC
		$arrValues = array($subcontractor_bid_status_group_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubcontractorBidStatusGroupsToSubcontractorBidStatusesBySubcontractorBidStatusGroupId = array();
		while ($row = $db->fetch()) {
			$subcontractorBidStatusGroupToSubcontractorBidStatus = self::instantiateOrm($database, 'SubcontractorBidStatusGroupToSubcontractorBidStatus', $row);
			/* @var $subcontractorBidStatusGroupToSubcontractorBidStatus SubcontractorBidStatusGroupToSubcontractorBidStatus */
			$arrSubcontractorBidStatusGroupsToSubcontractorBidStatusesBySubcontractorBidStatusGroupId[] = $subcontractorBidStatusGroupToSubcontractorBidStatus;
		}

		$db->free_result();

		self::$_arrSubcontractorBidStatusGroupsToSubcontractorBidStatusesBySubcontractorBidStatusGroupId = $arrSubcontractorBidStatusGroupsToSubcontractorBidStatusesBySubcontractorBidStatusGroupId;

		return $arrSubcontractorBidStatusGroupsToSubcontractorBidStatusesBySubcontractorBidStatusGroupId;
	}

	/**
	 * Load by constraint `sbsg2sbs_fk_sbs` foreign key (`subcontractor_bid_status_id`) references `subcontractor_bid_statuses` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $subcontractor_bid_status_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubcontractorBidStatusGroupsToSubcontractorBidStatusesBySubcontractorBidStatusId($database, $subcontractor_bid_status_id, Input $options=null)
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
			self::$_arrSubcontractorBidStatusGroupsToSubcontractorBidStatusesBySubcontractorBidStatusId = null;
		}

		$arrSubcontractorBidStatusGroupsToSubcontractorBidStatusesBySubcontractorBidStatusId = self::$_arrSubcontractorBidStatusGroupsToSubcontractorBidStatusesBySubcontractorBidStatusId;
		if (isset($arrSubcontractorBidStatusGroupsToSubcontractorBidStatusesBySubcontractorBidStatusId) && !empty($arrSubcontractorBidStatusGroupsToSubcontractorBidStatusesBySubcontractorBidStatusId)) {
			return $arrSubcontractorBidStatusGroupsToSubcontractorBidStatusesBySubcontractorBidStatusId;
		}

		$subcontractor_bid_status_id = (int) $subcontractor_bid_status_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `subcontractor_bid_status_group_id` ASC, `subcontractor_bid_status_id` ASC, `subcontractor_bid_status_alias` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY sbsg2sbs.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubcontractorBidStatusGroupToSubcontractorBidStatus = new SubcontractorBidStatusGroupToSubcontractorBidStatus($database);
			$sqlOrderByColumns = $tmpSubcontractorBidStatusGroupToSubcontractorBidStatus->constructSqlOrderByColumns($arrOrderByAttributes);

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
	sbsg2sbs.*

FROM `subcontractor_bid_status_groups_to_subcontractor_bid_statuses` sbsg2sbs
WHERE sbsg2sbs.`subcontractor_bid_status_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `subcontractor_bid_status_group_id` ASC, `subcontractor_bid_status_id` ASC, `subcontractor_bid_status_alias` ASC, `sort_order` ASC
		$arrValues = array($subcontractor_bid_status_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubcontractorBidStatusGroupsToSubcontractorBidStatusesBySubcontractorBidStatusId = array();
		while ($row = $db->fetch()) {
			$subcontractorBidStatusGroupToSubcontractorBidStatus = self::instantiateOrm($database, 'SubcontractorBidStatusGroupToSubcontractorBidStatus', $row);
			/* @var $subcontractorBidStatusGroupToSubcontractorBidStatus SubcontractorBidStatusGroupToSubcontractorBidStatus */
			$arrSubcontractorBidStatusGroupsToSubcontractorBidStatusesBySubcontractorBidStatusId[] = $subcontractorBidStatusGroupToSubcontractorBidStatus;
		}

		$db->free_result();

		self::$_arrSubcontractorBidStatusGroupsToSubcontractorBidStatusesBySubcontractorBidStatusId = $arrSubcontractorBidStatusGroupsToSubcontractorBidStatusesBySubcontractorBidStatusId;

		return $arrSubcontractorBidStatusGroupsToSubcontractorBidStatusesBySubcontractorBidStatusId;
	}

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all subcontractor_bid_status_groups_to_subcontractor_bid_statuses records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllSubcontractorBidStatusGroupsToSubcontractorBidStatuses($database, Input $options=null)
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
			self::$_arrAllSubcontractorBidStatusGroupsToSubcontractorBidStatuses = null;
		}

		$arrAllSubcontractorBidStatusGroupsToSubcontractorBidStatuses = self::$_arrAllSubcontractorBidStatusGroupsToSubcontractorBidStatuses;
		if (isset($arrAllSubcontractorBidStatusGroupsToSubcontractorBidStatuses) && !empty($arrAllSubcontractorBidStatusGroupsToSubcontractorBidStatuses)) {
			return $arrAllSubcontractorBidStatusGroupsToSubcontractorBidStatuses;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `subcontractor_bid_status_group_id` ASC, `subcontractor_bid_status_id` ASC, `subcontractor_bid_status_alias` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY sbsg2sbs.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubcontractorBidStatusGroupToSubcontractorBidStatus = new SubcontractorBidStatusGroupToSubcontractorBidStatus($database);
			$sqlOrderByColumns = $tmpSubcontractorBidStatusGroupToSubcontractorBidStatus->constructSqlOrderByColumns($arrOrderByAttributes);

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
	sbsg2sbs.*

FROM `subcontractor_bid_status_groups_to_subcontractor_bid_statuses` sbsg2sbs{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `subcontractor_bid_status_group_id` ASC, `subcontractor_bid_status_id` ASC, `subcontractor_bid_status_alias` ASC, `sort_order` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllSubcontractorBidStatusGroupsToSubcontractorBidStatuses = array();
		while ($row = $db->fetch()) {
			$subcontractorBidStatusGroupToSubcontractorBidStatus = self::instantiateOrm($database, 'SubcontractorBidStatusGroupToSubcontractorBidStatus', $row);
			/* @var $subcontractorBidStatusGroupToSubcontractorBidStatus SubcontractorBidStatusGroupToSubcontractorBidStatus */
			$arrAllSubcontractorBidStatusGroupsToSubcontractorBidStatuses[] = $subcontractorBidStatusGroupToSubcontractorBidStatus;
		}

		$db->free_result();

		self::$_arrAllSubcontractorBidStatusGroupsToSubcontractorBidStatuses = $arrAllSubcontractorBidStatusGroupsToSubcontractorBidStatuses;

		return $arrAllSubcontractorBidStatusGroupsToSubcontractorBidStatuses;
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
INTO `subcontractor_bid_status_groups_to_subcontractor_bid_statuses`
(`subcontractor_bid_status_group_id`, `subcontractor_bid_status_id`, `subcontractor_bid_status_alias`, `sort_order`)
VALUES (?, ?, ?, ?)
ON DUPLICATE KEY UPDATE `subcontractor_bid_status_alias` = ?, `sort_order` = ?
";
		$arrValues = array($this->subcontractor_bid_status_group_id, $this->subcontractor_bid_status_id, $this->subcontractor_bid_status_alias, $this->sort_order, $this->subcontractor_bid_status_alias, $this->sort_order);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$subcontractor_bid_status_group_to_subcontractor_bid_status_id = $db->insertId;
		$db->free_result();

		return $subcontractor_bid_status_group_to_subcontractor_bid_status_id;
	}

	// Save: insert ignore

	/**
	 * Load all subcontractor_bid_status_groups_to_subcontractor_bid_statuses records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllSubcontractorBidStatusGroupsToSubcontractorBidStatusesOrganizedBySubcontractorBidStatusIdBySubcontractorBidStatusGroupId($database, Input $options=null)
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

		/*
		if ($forceLoadFlag) {
			self::$_arrAllSubcontractorBidStatusGroupsToSubcontractorBidStatusesOrganizedBySubcontractorBidStatusIdBySubcontractorBidStatusGroupId = null;
		}

		$arrAllSubcontractorBidStatusGroupsToSubcontractorBidStatusesOrganizedBySubcontractorBidStatusIdBySubcontractorBidStatusGroupId = self::$_arrAllSubcontractorBidStatusGroupsToSubcontractorBidStatusesOrganizedBySubcontractorBidStatusIdBySubcontractorBidStatusGroupId;
		if (isset($arrAllSubcontractorBidStatusGroupsToSubcontractorBidStatusesOrganizedBySubcontractorBidStatusIdBySubcontractorBidStatusGroupId) && !empty($arrAllSubcontractorBidStatusGroupsToSubcontractorBidStatusesOrganizedBySubcontractorBidStatusIdBySubcontractorBidStatusGroupId)) {
			return $arrAllSubcontractorBidStatusGroupsToSubcontractorBidStatusesOrganizedBySubcontractorBidStatusIdBySubcontractorBidStatusGroupId;
		}
		*/

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `subcontractor_bid_status_group_id` ASC, `subcontractor_bid_status_id` ASC, `subcontractor_bid_status_alias` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY sbsg2sbs.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubcontractorBidStatusGroupToSubcontractorBidStatus = new SubcontractorBidStatusGroupToSubcontractorBidStatus($database);
			$sqlOrderByColumns = $tmpSubcontractorBidStatusGroupToSubcontractorBidStatus->constructSqlOrderByColumns($arrOrderByAttributes);

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

		// Default is no filter
		$sqlFilter = '';
		if (isset($arrSubcontractorBidStatusGroupIds) && !empty($arrSubcontractorBidStatusGroupIds)) {
			$csvSubcontractorBidStatusGroupIds = join(',', $arrSubcontractorBidStatusGroupIds);
			$sqlFilter .= "\nAND sbsg2sbs_fk_sbsg.`id` IN($csvSubcontractorBidStatusGroupIds)";
		}
		if (isset($arrSubcontractorBidStatusIds) && !empty($arrSubcontractorBidStatusIds)) {
			$csvSubcontractorBidStatusIds = join(',', $arrSubcontractorBidStatusIds);
			$sqlFilter .= "\nAND sbsg2sbs_fk_sbs.`id` IN($csvSubcontractorBidStatusIds)";
		}
		if (!empty($sqlFilter)) {
			$sqlFilter = "\nWHERE 1$sqlFilter";
		}

		$query =
"
SELECT

	sbsg2sbs_fk_sbsg.`id` AS 'sbsg2sbs_fk_sbsg__subcontractor_bid_status_group_id',
	sbsg2sbs_fk_sbsg.`subcontractor_bid_status_group` AS 'sbsg2sbs_fk_sbsg__subcontractor_bid_status_group',
	sbsg2sbs_fk_sbsg.`description` AS 'sbsg2sbs_fk_sbsg__description',
	sbsg2sbs_fk_sbsg.`sort_order` AS 'sbsg2sbs_fk_sbsg__sort_order',

	sbsg2sbs_fk_sbs.`id` AS 'sbsg2sbs_fk_sbs__subcontractor_bid_status_id',
	sbsg2sbs_fk_sbs.`subcontractor_bid_status` AS 'sbsg2sbs_fk_sbs__subcontractor_bid_status',
	sbsg2sbs_fk_sbs.`sort_order` AS 'sbsg2sbs_fk_sbs__sort_order',
	sbsg2sbs_fk_sbs.`disabled_flag` AS 'sbsg2sbs_fk_sbs__disabled_flag',

	sbsg2sbs.*

FROM `subcontractor_bid_status_groups_to_subcontractor_bid_statuses` sbsg2sbs
	INNER JOIN `subcontractor_bid_status_groups` sbsg2sbs_fk_sbsg ON sbsg2sbs.`subcontractor_bid_status_group_id` = sbsg2sbs_fk_sbsg.`id`
	INNER JOIN `subcontractor_bid_statuses` sbsg2sbs_fk_sbs ON sbsg2sbs.`subcontractor_bid_status_id` = sbsg2sbs_fk_sbs.`id`{$sqlFilter}{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `subcontractor_bid_status_group_id` ASC, `subcontractor_bid_status_id` ASC, `subcontractor_bid_status_alias` ASC, `sort_order` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllSubcontractorBidStatusGroupsToSubcontractorBidStatusesOrganizedBySubcontractorBidStatusIdBySubcontractorBidStatusGroupId = array();
		while ($row = $db->fetch()) {
			$subcontractorBidStatusGroupToSubcontractorBidStatus = self::instantiateOrm($database, 'SubcontractorBidStatusGroupToSubcontractorBidStatus', $row);
			/* @var $subcontractorBidStatusGroupToSubcontractorBidStatus SubcontractorBidStatusGroupToSubcontractorBidStatus */
			$subcontractorBidStatusGroupToSubcontractorBidStatus->convertPropertiesToData();

			if (isset($row['subcontractor_bid_status_group_id'])) {
				$subcontractor_bid_status_group_id = $row['subcontractor_bid_status_group_id'];
				$row['sbsg2sbs_fk_sbsg__id'] = $subcontractor_bid_status_group_id;
				$subcontractorBidStatusGroup = self::instantiateOrm($database, 'SubcontractorBidStatusGroup', $row, null, $subcontractor_bid_status_group_id, 'sbsg2sbs_fk_sbsg__');
				/* @var $subcontractorBidStatusGroup SubcontractorBidStatusGroup */
				$subcontractorBidStatusGroup->convertPropertiesToData();
			} else {
				$subcontractorBidStatusGroup = false;
			}
			$subcontractorBidStatusGroupToSubcontractorBidStatus->setSubcontractorBidStatusGroup($subcontractorBidStatusGroup);

			if (isset($row['subcontractor_bid_status_id'])) {
				$subcontractor_bid_status_id = $row['subcontractor_bid_status_id'];
				$row['sbsg2sbs_fk_sbs__id'] = $subcontractor_bid_status_id;
				$subcontractorBidStatus = self::instantiateOrm($database, 'SubcontractorBidStatus', $row, null, $subcontractor_bid_status_id, 'sbsg2sbs_fk_sbs__');
				/* @var $subcontractorBidStatus SubcontractorBidStatus */
				$subcontractorBidStatus->convertPropertiesToData();
			} else {
				$subcontractorBidStatus = false;
			}
			$subcontractorBidStatusGroupToSubcontractorBidStatus->setSubcontractorBidStatus($subcontractorBidStatus);

			$subcontractor_bid_status_group_id = $row['subcontractor_bid_status_group_id'];
			$subcontractor_bid_status_id = $row['subcontractor_bid_status_id'];

			$arrAllSubcontractorBidStatusGroupsToSubcontractorBidStatusesOrganizedBySubcontractorBidStatusIdBySubcontractorBidStatusGroupId[$subcontractor_bid_status_id][$subcontractor_bid_status_group_id] = $subcontractorBidStatusGroupToSubcontractorBidStatus;
		}

		$db->free_result();

		//self::$_arrAllSubcontractorBidStatusGroupsToSubcontractorBidStatusesOrganizedBySubcontractorBidStatusIdBySubcontractorBidStatusGroupId = $arrAllSubcontractorBidStatusGroupsToSubcontractorBidStatusesOrganizedBySubcontractorBidStatusIdBySubcontractorBidStatusGroupId;

		return $arrAllSubcontractorBidStatusGroupsToSubcontractorBidStatusesOrganizedBySubcontractorBidStatusIdBySubcontractorBidStatusGroupId;
	}
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

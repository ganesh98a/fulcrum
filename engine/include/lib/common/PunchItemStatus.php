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
 * PunchItemStatus.
 *
 * @category   Framework
 * @package    PunchItemStatus
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class PunchItemStatus extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'PunchItemStatus';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'punch_item_status';

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
	 * unique index `unique_punch_item_status` (`punch_item_status`) comment 'PunchItem Statuses transcend user_companies so user_company_id is not needed.'
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_punch_item_status' => array(
			'punch_item_status' => 'string'
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
		'id' => 'status_id',

		'punch_item_status' => 'punch_item_status',

		'disabled_flag' => 'disabled_flag'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $status_id;

	public $punch_item_status;

	public $disabled_flag;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties
	public $escaped_status;

	// HTML ENTITY ENCODED NL2BR ORM string properties
	public $escaped_status_nl2br;

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllStatuses;
	protected static $_arrAllPunchItemStatus;
	// Foreign Key Objects

	/**
	 * Constructor
	 */
	public function __construct($database, $table='punch_item_statuses')
	{
		parent::__construct($table);
		$this->setDatabase($database);
	}

	// Foreign Key Object Accessor Methods

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllStatus()
	{
		if (isset(self::$_arrAllStatus)) {
			return self::$_arrAllStatus;
		} else {
			return null;
		}
	}

	public static function setArrAllStatuses($arrAllStatuses)
	{
		self::$_arrAllStatus = $arrAllStatuses;
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
	 * @param int $PunchItem_status_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findById($database, $status_id,$table='_status', $module='PunchItemStatus')
	{
		$punchItemStatus = parent::findById($database, $status_id,  $table, $module);
		return $punchItemStatus;
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Similar to FindById, but with SQL as starter code for more complex joins.
	 *
	 * @param string $database
	 * @param int $PunchItem_status_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findPunchItemStatusByIdExtended($database, $status_id)
	{
		$status_id = (int) $status_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	pis.*

FROM `punch_item_status` pis
WHERE pis.`id` = ?
";
		$arrValues = array($status_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$punch_item_status_id = $row['id'];
			$punchItemStatus = self::instantiateOrm($database, 'PunchItemStatus', $row, null, $punch_item_status_id);
			/* @var $PunchItemStatus PunchItemStatus */
			$punchItemStatus->convertPropertiesToData();

			return $punchItemStatus;
		} else {
			return false;
		}
	}

	// Finders: Find By Unique Index
	/**
	 * Find by unique index `unique_PunchItem_status` (`PunchItem_status`) comment 'PunchItem Statuses transcend user_companies so user_company_id is not needed.'.
	 *
	 * @param string $database
	 * @param string $PunchItem_status
	 * @return mixed (single ORM object | false)
	 */
	public static function findByPunchItemStatus($database, $status)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	pis.*

FROM `punch_item_status` pis
WHERE pis.`punch_item_status` = ?
";
		$arrValues = array($status);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if ($row && !empty($row)) {
			$punch_item_status_id = $row['id'];
			$punchItemStatus = self::instantiateOrm($database, 'PunchItemStatus', $row, null, $punch_item_status_id);
			/* @var $punchItemStatus PunchItemStatus */
			return $punchItemStatus;
		} else {
			return false;
		}
	}
	// Finders: Find By Unique Index
	/**
	 * Find by unique index `unique_punch_item_status` (`punch_item_status`) comment 'PunchItem Statuses transcend user_companies so user_company_id is not needed.'.
	 *
	 * @param string $database
	 * @param string $PunchItem_status
	 * @return mixed (single ORM object | false)
	 */
	public static function loadAllPunchItemStatus($database)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	pis.*

FROM `punch_item_status` pis
WHERE pis.`disabled_flag` = 'N'
";
		$db->execute($query);
		// $row = $db->fetch();
		$arrAllPunchItemStatus = array();
		while ($row = $db->fetch()) {
			$punch_item_status_id = $row['id'];
			$punchItemStatus = self::instantiateOrm($database, 'PunchItemStatus', $row, null, $punch_item_status_id);
			/* @var $punchItemStatus PunchItemStatus */
			$arrAllPunchItemStatus[$punch_item_status_id] = $punchItemStatus;
		}

		$db->free_result();

		self::$_arrAllPunchItemStatus = $arrAllPunchItemStatus;

		return $arrAllPunchItemStatus;
	}
	// Save: insert ignore
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

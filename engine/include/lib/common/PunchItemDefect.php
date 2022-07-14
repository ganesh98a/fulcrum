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
 * PunchItemBuildingStatus.
 *
 * @category   Framework
 * @package    PunchItemBuildingStatus
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class PunchItemDefect extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'PunchItemDefect';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'punch_defects';

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

	protected $_arrUniqueness = array(
		'unique_punch_defects' => array(
			'id' => 'int',
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
		'id' => 'id',
		'user_company_id' => 'user_company_id',
		'defect_name' => 'defect_name',
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $id;
	public $user_company_id;
	public $defect_name;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties
	public $escaped_defect_name;

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)
	protected static $_arrAllPunchItemDefect;
	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Foreign Key Objects

	/**
	 * Constructor
	 */
	public function __construct($database, $table='punch_defects')
	{
		parent::__construct($table);
		$this->setDatabase($database);
	}


	// Finder: Find By pk (a single auto int id or a single non auto int pk)
	/**
	 * PHP < 5.3.0
	 *
	 * @param string $database
	 * @param int $PunchItemBuilding_status_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findById($database, $defect_id,$table='_status', $module='PunchItemDefect')
	{
		$punchItemDefect = parent::findById($database, $defect_id, $table, $module);

		return $punchItemDefect;
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Similar to FindById, but with SQL as starter code for more complex joins.
	 *
	 * @param string $database
	 * @param int $PunchItemBuilding_status_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findPunchItemBuildingByIdExtended($database, $defect_id)
	{
		$status_id = (int) $status_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	pid.*

FROM `punch_defects` pid
WHERE pid.`id` = ?
";
		$arrValues = array($defect_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$punch_item_defect_id = $row['id'];
			$punchItemDefect = self::instantiateOrm($database, 'PunchItemDefect', $row, null, $punch_item_defect_id);
			/* @var $PunchItemBuilding PunchItemBuilding */
			$punchItemDefect->convertPropertiesToData();

			return $punchItemDefect;
		} else {
			return false;
		}
	}

	// Finders: Find By Unique Index
	/**
	 * Find by unique index `unique_punch_building_data` (`punch_building_data`) comment 'PunchItemBuilding transcend user_companies so user_company_id is not needed.'.
	 *
	 * @param string $database
	 * @param string $PunchItemBuilding_status
	 * @return mixed (single ORM object | false)
	 */
	public static function findByPunchItemDefect($database, $defect)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	pid.*

FROM `punch_defects` pid
WHERE pid.`defect_name` = ?
";
		$arrValues = array($defect);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if ($row && !empty($row)) {
			$punch_item_defect_id = $row['id'];
			$punchItemDefect = self::instantiateOrm($database, 'PunchItemDefect', $row, null, $punch_item_defect_id);
			$punchItemDefect->convertPropertiesToData();
			/* @var $punchItemBuilding PunchItemBuilding */
			return $punchItemDefect;
		} else {
			return false;
		}
	}
	// Finders: Find By Unique Index
	/**
	 * Find by unique index `unique_punch_building_data` (`punch_building_data`) comment 'PunchItemBuilding transcend user_companies so user_company_id is not needed.'.
	 *
	 * @param string $database
	 * @param string $PunchItemBuilding_status
	 * @return mixed (single ORM object | false)
	 */
	public static function loadAllPunchItemDefect($database, $company_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	pid.*
FROM `punch_defects` pid
WHERE pid.`user_company_id` = ?
";
		$arrValues = array($company_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$arrAllPunchItemDefect = array();
		while ($row = $db->fetch()) {
			$punch_item_defect_id = $row['id'];
			$punchItemDefect = self::instantiateOrm($database, 'PunchItemDefect', $row, null, $punch_item_defect_id);
			$punchItemDefect->convertPropertiesToData();
			/* @var $punchItemDefect PunchItemDefect */
			$arrAllPunchItemDefect[$punch_item_defect_id] = $punchItemDefect;
		}

		$db->free_result();

		self::$_arrAllPunchItemDefect = $arrAllPunchItemDefect;

		return $arrAllPunchItemDefect;
	}
	// Save: insert ignore
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

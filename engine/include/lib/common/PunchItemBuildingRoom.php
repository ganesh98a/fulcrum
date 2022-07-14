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

class PunchItemBuildingRoom extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'PunchItemBuildingRoom';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'punch_room_data';

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
		'unique_punch_room_data' => array(
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
		'project_id' => 'project_id',
		'building_id' => 'building_id',
		'room_name' => 'room_name',
		'description' => 'description'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $id;
	public $project_id;
	public $building_id;
	public $room_name;
	public $description;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties
	public $escaped_room_name;

	// HTML ENTITY ENCODED NL2BR ORM string properties
	public $escaped_description;

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllStatuses;
	protected static $_arrAllPunchItemBuildingRoom;
	// Foreign Key Objects

	/**
	 * Constructor
	 */
	public function __construct($database, $table='punch_room_data')
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
	public static function findById($database, $room_id,$table='_status', $module='PunchItemBuildingRoom')
	{
		$punchItemBuildingRoom = parent::findById($database, $room_id,$table, $module);

		return $punchItemBuildingRoom;
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Similar to FindById, but with SQL as starter code for more complex joins.
	 *
	 * @param string $database
	 * @param int $PunchItemBuilding_status_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findPunchItemBuildingByIdExtended($database, $room_id)
	{
		$status_id = (int) $status_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	pibr.*

FROM `punch_room_data` pibr
WHERE pibr.`id` = ?
";
		$arrValues = array($room_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$punch_item_building_room_id = $row['id'];
			$punchItemBuildingRoom = self::instantiateOrm($database, 'PunchItemBuildingRoom', $row, null, $punch_item_building_room_id);
			/* @var $PunchItemBuilding PunchItemBuilding */
			$punchItemBuildingRoom->convertPropertiesToData();

			return $punchItemBuildingRoom;
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
	public static function findByPunchItemRoomByBuildingId($database, $building_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	pibr.*

FROM `punch_room_data` pibr
WHERE pibr.`building_id` = ?
";
		$arrValues = array($building_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$arrAllPunchItemBuildingRoom = array();
		while ($row = $db->fetch()) {
			$punch_item_building_room_id = $row['id'];
			$punchItemBuildingRoom = self::instantiateOrm($database, 'PunchItemBuildingRoom', $row, null, $punch_item_building_room_id);
			$punchItemBuildingRoom->convertPropertiesToData();
			/* @var $punchItemBuilding PunchItemBuilding */
			$arrAllPunchItemBuildingRoom[$punch_item_building_room_id] = $punchItemBuildingRoom;
		}

		$db->free_result();

		self::$_arrAllPunchItemBuildingRoom = $arrAllPunchItemBuildingRoom;

		return $arrAllPunchItemBuildingRoom;
	}
	// Save: insert ignore
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

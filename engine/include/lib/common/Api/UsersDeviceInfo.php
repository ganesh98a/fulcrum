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

class UsersDeviceInfo extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'UsersDeviceInfo';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'users_device_info';

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
		'unique_user_device_info_via_primary_key' => array(
			'id' => 'int'
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
		'user_id' => 'user_id',
		'fcm_token' => 'fcm_token',
		'device_id' => 'device_id',
		'device_name' => 'device_name',
		'device_version' => 'device_version',
		'device_istablet' => 'device_istablet',
		'device_platform' => 'device_platform',
		'device_32bit_supported_apis' => 'device_32bit_supported_apis',
		'device_64bit_supported_apis' => 'device_64bit_supported_apis',
		'app_version' => 'app_version',
		'app_build_no' => 'app_build_no',
		'app_bundler_id' => 'app_bundler_id',
		'created_date' => 'created_date',
		'modified_date' => 'modified_date',
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $id;
	public $user_id;
	public $fcm_token;
	public $device_id;
	public $device_name;
	public $device_version;
	public $device_istablet;
	public $device_platform;
	public $device_32bit_supported_apis;
	public $device_64bit_supported_apis;
	public $app_version;
	public $app_build_no;
	public $app_bundler_id;
	public $created_date;
	public $modified_date;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties
	public $escaped_device_name;

	// HTML ENTITY ENCODED NL2BR ORM string properties
	public $escaped_device_version;

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllUsersDeviceInfo;
	// Foreign Key Objects

	/**
	 * Constructor
	 */
	public function __construct($database, $table='users_device_info')
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
	public static function findById($database, $users_device_info_id, $table='users_device_info', $module='usersDeviceInfo')
	{
		$usersDeviceInfo = parent::findById($database, $users_device_info_id, 'users_device_info', 'usersDeviceInfo');

		return $usersDeviceInfo;
	}

	/**
	 * 	// Finder: Find By Users Device unique id
	 *
	 * @param string $database
	 * @param int $project_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findByUserDeviceId($database, $device_id)
	{
		$user_device_id = null;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */
		$db->free_result();
		$query =
		"
		SELECT *
		FROM `users_device_info` udi
		WHERE udi.`device_id` = ?
		";
		$arrValues = array($device_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$user_device_id = $row['id'];
		}

		return $user_device_id;
	}

	/**
	 * 	// Finder: Find By Users Device unique id
	 *
	 * @param string $database
	 * @param int $project_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findByIdUsingUserId($database, $user_id)
	{
		$fcm_token = null;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */
		$db->free_result();
		$query =
		"
		SELECT *
		FROM `users_device_info` udi
		WHERE udi.`user_id` = ? AND udi.`is_active` = 'Y'
		";
		$arrValues = array($user_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
	
		while($row = $db->fetch()){
			$fcm_token[] = $row['fcm_token'];
		}
		
		$db->free_result();
		return $fcm_token;
	}
	
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

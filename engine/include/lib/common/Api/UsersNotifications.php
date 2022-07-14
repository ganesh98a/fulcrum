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

class UsersNotifications extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'UsersNotifications';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'users_notifications';

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
		'unique_user_notification_via_primary_key' => array(
			'user_notification_id' => 'int'
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
		'id' => 'user_notification_id',
		'user_id' => 'user_id',
		'project_id' => 'project_id',
		'user_notification_type_id' => 'user_notification_type_id',
		'user_notification_type_reference_id' => 'user_notification_type_reference_id',
		'is_read' => 'is_read',
		'created_date' => 'created_date',
		'moditified_date' => 'moditified_date'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $user_notification_id;
	public $user_id;
	public $project_id;
	public $user_notification_type_id;
	public $user_notification_type_reference_id;
	public $is_read;
	public $created_date;
	public $moditified_date;

	// Other Properties
	//protected $_otherPropertyHere;


	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllUsersNotifications;
	// Foreign Key Objects

	/**
	 * Constructor
	 */
	public function __construct($database, $table='users_notifications')
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
	public static function findById($database, $users_device_info_id, $table='users_notifications', $module='usersNotifications')
	{
		$usersDeviceInfo = parent::findById($database, $users_device_info_id, 'users_notifications', 'usersNotifications');

		return $usersDeviceInfo;
	}

	/**
	 * 	// Finder: Find By Users Id & Project Id
	 *
	 * @param string $database
	 * @param int $project_id
	 * @return mixed (single ORM object | false)
	 */
	public static function loadAllNotificationListByUserAndProjectIds($database, $user_id, $project_id, Input $options=null)
	{
		$forceLoadFlag = false;
		$arrValues = array($user_id, $project_id);
		$whereIsRead = '';
		$limit = '';
		$offset = '';
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
			// where cause
			$whereIsRead = $options->whereIsRead;			
		}

		if ($forceLoadFlag) {
			self::$_arrAllUsersNotifications = null;
		}

		$arrAllUsersNotifications = self::$_arrAllUsersNotifications;
		if (isset($arrAllUsersNotifications) && !empty($arrAllUsersNotifications)) {
			return $arrAllUsersNotifications;
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

		$sqlOrderBy = "\nORDER BY un.`id` DESC";

		$where = '';
		if($whereIsRead != '') {
			$where = ' AND un.`is_read` = ?';
			$arrValues[] = $whereIsRead;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */
		$db->free_result();
		$query =
		"
		SELECT *
		FROM `users_notifications` un
		WHERE un.`user_id` = ?
		AND un.`project_id` = ?
		{$where}{$sqlOrderBy}{$sqlLimit}
		";
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		while ($row = $db->fetch()) {
			$user_notification_id = $row['id'];
			$userNotification = self::instantiateOrm($database, 'UsersNotifications', $row, null, $user_notification_id);
			/* @var $userNotification UsersNotification */
			$userNotification->convertPropertiesToData();
			$arrAllUsersNotifications[$user_notification_id] = $userNotification;
		}
		$db->free_result();
		
		return $arrAllUsersNotifications;
	}
	/**
	 * 	// Finder: Find By Users Id & Project Id get count
	 *
	 * @param string $database
	 * @param int $project_id
	 * @return mixed (single ORM object | false)
	 */
	public static function loadAllUnReadNotificationListByUserAndProjectIds($database, $user_id, $project_id, Input $options=null)
	{
		$forceLoadFlag = false;
		$arrValues = array($user_id, $project_id);
		$whereIsRead = '';
		$limit = '';
		$offset = '';
		$user_notification_unread_count = 0;
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
			// where cause
			$whereIsRead = $options->whereIsRead;			
		}

		if ($forceLoadFlag) {
			self::$_arrAllUsersNotifications = null;
		}

		$arrAllUsersNotifications = self::$_arrAllUsersNotifications;
		if (isset($arrAllUsersNotifications) && !empty($arrAllUsersNotifications)) {
			return $arrAllUsersNotifications;
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

		$sqlOrderBy = "\nORDER BY un.`id` DESC";

		$where = '';
		if($whereIsRead != '') {
			$where = ' AND un.`is_read` = ?';
			$arrValues[] = $whereIsRead;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */
		$db->free_result();
		$query =
		"
		SELECT COUNT(*) AS total_count
 		FROM `users_notifications` un
		WHERE un.`user_id` = ?
		AND un.`project_id` = ?
		{$where}{$sqlOrderBy}{$sqlLimit}
		";
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$user_notification_unread_count = $row['total_count'];
		}
	
		return $user_notification_unread_count;
	}
	/**
	 * 	// Finder: Find By Users Id & Project Id
	 *
	 * @param string $database
	 * @param int $project_id
	 * @return mixed (single ORM object | false)
	 */
	public static function markAsAllReadedByUserId($database, $user_id, $project_id)
	{
		$unReadFlag = 'N';
		$readFlag = 'Y';
		$arrValues = array($readFlag, $user_id, $project_id, $unReadFlag);
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */
		$db->free_result();
		$query =
		"
		UPDATE `users_notifications` un
		SET un.`is_read` = ?
		WHERE un.`user_id` = ?
		AND un.`project_id` = ?
		AND un.`is_read` = ?
		";
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$db->free_result();
		$db->commit();
		return;
	}
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

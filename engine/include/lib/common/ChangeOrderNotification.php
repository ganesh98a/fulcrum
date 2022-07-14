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
 * ChangeOrderNotification.
 *
 * @category   Framework
 * @package    ChangeOrderNotification
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class ChangeOrderNotification extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'ChangeOrderNotification';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'change_order_notifications';

	/**
	 * Singular version of the table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_tableNameSingular = 'change_order_notification';

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
	 * unique index `unique_change_order_notification` (`change_order_id`,`change_order_notification_timestamp`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_change_order_notification' => array(
			'change_order_id' => 'int',
			'change_order_notification_timestamp' => 'string'
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
		'id' => 'change_order_notification_id',

		'change_order_id' => 'change_order_id',

		'change_order_notification_timestamp' => 'change_order_notification_timestamp'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $change_order_notification_id;

	public $change_order_id;

	public $change_order_notification_timestamp;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties

	// HTML ENTITY ENCODED NL2BR ORM string properties

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)
	protected static $_arrChangeOrderNotificationsByChangeOrderId;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllChangeOrderNotifications;

	// Foreign Key Objects
	private $_changeOrder;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='change_order_notifications')
	{
		parent::__construct($table);
		$this->setDatabase($database);
	}

	// Foreign Key Object Accessor Methods
	public function getChangeOrder()
	{
		if (isset($this->_changeOrder)) {
			return $this->_changeOrder;
		} else {
			return null;
		}
	}

	public function setChangeOrder($changeOrder)
	{
		$this->_changeOrder = $changeOrder;
	}

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)
	public static function getArrChangeOrderNotificationsByChangeOrderId()
	{
		if (isset(self::$_arrChangeOrderNotificationsByChangeOrderId)) {
			return self::$_arrChangeOrderNotificationsByChangeOrderId;
		} else {
			return null;
		}
	}

	public static function setArrChangeOrderNotificationsByChangeOrderId($arrChangeOrderNotificationsByChangeOrderId)
	{
		self::$_arrChangeOrderNotificationsByChangeOrderId = $arrChangeOrderNotificationsByChangeOrderId;
	}

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllChangeOrderNotifications()
	{
		if (isset(self::$_arrAllChangeOrderNotifications)) {
			return self::$_arrAllChangeOrderNotifications;
		} else {
			return null;
		}
	}

	public static function setArrAllChangeOrderNotifications($arrAllChangeOrderNotifications)
	{
		self::$_arrAllChangeOrderNotifications = $arrAllChangeOrderNotifications;
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
	 * @param int $change_order_notification_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findById($database, $change_order_notification_id, $table='change_order_notifications', $module='ChangeOrderNotification')
	{
		$changeOrderNotification = parent::findById($database, $change_order_notification_id, $table, $module);

		return $changeOrderNotification;
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Similar to FindById, but with SQL as starter code for more complex joins.
	 *
	 * @param string $database
	 * @param int $change_order_notification_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findChangeOrderNotificationByIdExtended($database, $change_order_notification_id)
	{
		$change_order_notification_id = (int) $change_order_notification_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	con_fk_co.`id` AS 'con_fk_co__change_order_id',
	con_fk_co.`project_id` AS 'con_fk_co__project_id',
	con_fk_co.`co_sequence_number` AS 'con_fk_co__co_sequence_number',
	con_fk_co.`co_custom_sequence_number` AS 'con_fk_co__co_custom_sequence_number',
	con_fk_co.`co_scheduled_value` AS 'con_fk_co__co_scheduled_value',
	con_fk_co.`co_delay_days` AS 'con_fk_co__co_delay_days',
	con_fk_co.`change_order_type_id` AS 'con_fk_co__change_order_type_id',
	con_fk_co.`change_order_status_id` AS 'con_fk_co__change_order_status_id',
	con_fk_co.`change_order_priority_id` AS 'con_fk_co__change_order_priority_id',
	con_fk_co.`co_file_manager_file_id` AS 'con_fk_co__co_file_manager_file_id',
	con_fk_co.`co_cost_code_id` AS 'con_fk_co__co_cost_code_id',
	con_fk_co.`co_creator_contact_id` AS 'con_fk_co__co_creator_contact_id',
	con_fk_co.`co_creator_contact_company_office_id` AS 'con_fk_co__co_creator_contact_company_office_id',
	con_fk_co.`co_creator_phone_contact_company_office_phone_number_id` AS 'con_fk_co__co_creator_phone_contact_company_office_phone_number_id',
	con_fk_co.`co_creator_fax_contact_company_office_phone_number_id` AS 'con_fk_co__co_creator_fax_contact_company_office_phone_number_id',
	con_fk_co.`co_creator_contact_mobile_phone_number_id` AS 'con_fk_co__co_creator_contact_mobile_phone_number_id',
	con_fk_co.`co_recipient_contact_id` AS 'con_fk_co__co_recipient_contact_id',
	con_fk_co.`co_recipient_contact_company_office_id` AS 'con_fk_co__co_recipient_contact_company_office_id',
	con_fk_co.`co_recipient_phone_contact_company_office_phone_number_id` AS 'con_fk_co__co_recipient_phone_contact_company_office_phone_number_id',
	con_fk_co.`co_recipient_fax_contact_company_office_phone_number_id` AS 'con_fk_co__co_recipient_fax_contact_company_office_phone_number_id',
	con_fk_co.`co_recipient_contact_mobile_phone_number_id` AS 'con_fk_co__co_recipient_contact_mobile_phone_number_id',
	con_fk_co.`co_initiator_contact_id` AS 'con_fk_co__co_initiator_contact_id',
	con_fk_co.`co_initiator_contact_company_office_id` AS 'con_fk_co__co_initiator_contact_company_office_id',
	con_fk_co.`co_initiator_phone_contact_company_office_phone_number_id` AS 'con_fk_co__co_initiator_phone_contact_company_office_phone_number_id',
	con_fk_co.`co_initiator_fax_contact_company_office_phone_number_id` AS 'con_fk_co__co_initiator_fax_contact_company_office_phone_number_id',
	con_fk_co.`co_initiator_contact_mobile_phone_number_id` AS 'con_fk_co__co_initiator_contact_mobile_phone_number_id',
	con_fk_co.`co_title` AS 'con_fk_co__co_title',
	con_fk_co.`co_plan_page_reference` AS 'con_fk_co__co_plan_page_reference',
	con_fk_co.`co_statement` AS 'con_fk_co__co_statement',
	con_fk_co.`created` AS 'con_fk_co__created',
	con_fk_co.`co_revised_project_completion_date` AS 'con_fk_co__co_revised_project_completion_date',
	con_fk_co.`co_closed_date` AS 'con_fk_co__co_closed_date',

	con.*

FROM `change_order_notifications` con
	INNER JOIN `change_orders` con_fk_co ON con.`change_order_id` = con_fk_co.`id`
WHERE con.`id` = ?
";
		$arrValues = array($change_order_notification_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$change_order_notification_id = $row['id'];
			$changeOrderNotification = self::instantiateOrm($database, 'ChangeOrderNotification', $row, null, $change_order_notification_id);
			/* @var $changeOrderNotification ChangeOrderNotification */
			$changeOrderNotification->convertPropertiesToData();

			if (isset($row['change_order_id'])) {
				$change_order_id = $row['change_order_id'];
				$row['con_fk_co__id'] = $change_order_id;
				$changeOrder = self::instantiateOrm($database, 'ChangeOrder', $row, null, $change_order_id, 'con_fk_co__');
				/* @var $changeOrder ChangeOrder */
				$changeOrder->convertPropertiesToData();
			} else {
				$changeOrder = false;
			}
			$changeOrderNotification->setChangeOrder($changeOrder);

			return $changeOrderNotification;
		} else {
			return false;
		}
	}

	// Finders: Find By Unique Index
	/**
	 * Find by unique index `unique_change_order_notification` (`change_order_id`,`change_order_notification_timestamp`).
	 *
	 * @param string $database
	 * @param int $change_order_id
	 * @param string $change_order_notification_timestamp
	 * @return mixed (single ORM object | false)
	 */
	public static function findByChangeOrderIdAndChangeOrderNotificationTimestamp($database, $change_order_id, $change_order_notification_timestamp)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	con.*

FROM `change_order_notifications` con
WHERE con.`change_order_id` = ?
AND con.`change_order_notification_timestamp` = ?
";
		$arrValues = array($change_order_id, $change_order_notification_timestamp);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if ($row && !empty($row)) {
			$change_order_notification_id = $row['id'];
			$changeOrderNotification = self::instantiateOrm($database, 'ChangeOrderNotification', $row, null, $change_order_notification_id);
			/* @var $changeOrderNotification ChangeOrderNotification */
			return $changeOrderNotification;
		} else {
			return false;
		}
	}

	// Loaders: Load By pk List (list of auto int ids or other non auto int pk list)
	/**
	 * Load zero or more records by an id list (array of auto int primary keys).
	 *
	 * @param string $database
	 * @param array $arrChangeOrderNotificationIds
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadChangeOrderNotificationsByArrChangeOrderNotificationIds($database, $arrChangeOrderNotificationIds, Input $options=null)
	{
		if (empty($arrChangeOrderNotificationIds)) {
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
		// ORDER BY `id` ASC, `change_order_id` ASC, `change_order_notification_timestamp` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpChangeOrderNotification = new ChangeOrderNotification($database);
			$sqlOrderByColumns = $tmpChangeOrderNotification->constructSqlOrderByColumns($arrOrderByAttributes);

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

		foreach ($arrChangeOrderNotificationIds as $k => $change_order_notification_id) {
			$change_order_notification_id = (int) $change_order_notification_id;
			$arrChangeOrderNotificationIds[$k] = $db->escape($change_order_notification_id);
		}
		$csvChangeOrderNotificationIds = join(',', $arrChangeOrderNotificationIds);

		$query =
"
SELECT

	con.*

FROM `change_order_notifications` con
WHERE con.`id` IN ($csvChangeOrderNotificationIds){$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		$arrChangeOrderNotificationsByCsvChangeOrderNotificationIds = array();
		while ($row = $db->fetch()) {
			$change_order_notification_id = $row['id'];
			$changeOrderNotification = self::instantiateOrm($database, 'ChangeOrderNotification', $row, null, $change_order_notification_id);
			/* @var $changeOrderNotification ChangeOrderNotification */
			$changeOrderNotification->convertPropertiesToData();

			$arrChangeOrderNotificationsByCsvChangeOrderNotificationIds[$change_order_notification_id] = $changeOrderNotification;
		}

		$db->free_result();

		return $arrChangeOrderNotificationsByCsvChangeOrderNotificationIds;
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `change_order_notifications_fk_co` foreign key (`change_order_id`) references `change_orders` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $change_order_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadChangeOrderNotificationsByChangeOrderId($database, $change_order_id, Input $options=null)
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
			self::$_arrChangeOrderNotificationsByChangeOrderId = null;
		}

		$arrChangeOrderNotificationsByChangeOrderId = self::$_arrChangeOrderNotificationsByChangeOrderId;
		if (isset($arrChangeOrderNotificationsByChangeOrderId) && !empty($arrChangeOrderNotificationsByChangeOrderId)) {
			return $arrChangeOrderNotificationsByChangeOrderId;
		}

		$change_order_id = (int) $change_order_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `change_order_id` ASC, `change_order_notification_timestamp` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpChangeOrderNotification = new ChangeOrderNotification($database);
			$sqlOrderByColumns = $tmpChangeOrderNotification->constructSqlOrderByColumns($arrOrderByAttributes);

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
	con.*

FROM `change_order_notifications` con
WHERE con.`change_order_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `change_order_id` ASC, `change_order_notification_timestamp` ASC
		$arrValues = array($change_order_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrChangeOrderNotificationsByChangeOrderId = array();
		while ($row = $db->fetch()) {
			$change_order_notification_id = $row['id'];
			$changeOrderNotification = self::instantiateOrm($database, 'ChangeOrderNotification', $row, null, $change_order_notification_id);
			/* @var $changeOrderNotification ChangeOrderNotification */
			$arrChangeOrderNotificationsByChangeOrderId[$change_order_notification_id] = $changeOrderNotification;
		}

		$db->free_result();

		self::$_arrChangeOrderNotificationsByChangeOrderId = $arrChangeOrderNotificationsByChangeOrderId;

		return $arrChangeOrderNotificationsByChangeOrderId;
	}

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all change_order_notifications records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllChangeOrderNotifications($database, Input $options=null)
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
			self::$_arrAllChangeOrderNotifications = null;
		}

		$arrAllChangeOrderNotifications = self::$_arrAllChangeOrderNotifications;
		if (isset($arrAllChangeOrderNotifications) && !empty($arrAllChangeOrderNotifications)) {
			return $arrAllChangeOrderNotifications;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `change_order_id` ASC, `change_order_notification_timestamp` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpChangeOrderNotification = new ChangeOrderNotification($database);
			$sqlOrderByColumns = $tmpChangeOrderNotification->constructSqlOrderByColumns($arrOrderByAttributes);

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
	con.*

FROM `change_order_notifications` con{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `change_order_id` ASC, `change_order_notification_timestamp` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllChangeOrderNotifications = array();
		while ($row = $db->fetch()) {
			$change_order_notification_id = $row['id'];
			$changeOrderNotification = self::instantiateOrm($database, 'ChangeOrderNotification', $row, null, $change_order_notification_id);
			/* @var $changeOrderNotification ChangeOrderNotification */
			$arrAllChangeOrderNotifications[$change_order_notification_id] = $changeOrderNotification;
		}

		$db->free_result();

		self::$_arrAllChangeOrderNotifications = $arrAllChangeOrderNotifications;

		return $arrAllChangeOrderNotifications;
	}

	// Save: insert on duplicate key update

	// Save: insert ignore
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

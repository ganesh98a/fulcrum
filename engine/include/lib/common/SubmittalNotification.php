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
 * SubmittalNotification.
 *
 * @category   Framework
 * @package    SubmittalNotification
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class SubmittalNotification extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'SubmittalNotification';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'submittal_notifications';

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
	 * unique index `unique_submittal_notification` (`submittal_id`,`submittal_notification_timestamp`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_submittal_notification' => array(
			'submittal_id' => 'int',
			'submittal_notification_timestamp' => 'string'
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
		'id' => 'submittal_notification_id',

		'submittal_id' => 'submittal_id',

		'submittal_notification_timestamp' => 'submittal_notification_timestamp'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $submittal_notification_id;

	public $submittal_id;

	public $submittal_notification_timestamp;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties

	// HTML ENTITY ENCODED NL2BR ORM string properties

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)
	protected static $_arrSubmittalNotificationsBySubmittalId;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllSubmittalNotifications;

	// Foreign Key Objects
	private $_submittal;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='submittal_notifications')
	{
		parent::__construct($table);
		$this->setDatabase($database);
	}

	// Foreign Key Object Accessor Methods
	public function getSubmittal()
	{
		if (isset($this->_submittal)) {
			return $this->_submittal;
		} else {
			return null;
		}
	}

	public function setSubmittal($submittal)
	{
		$this->_submittal = $submittal;
	}

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)
	public static function getArrSubmittalNotificationsBySubmittalId()
	{
		if (isset(self::$_arrSubmittalNotificationsBySubmittalId)) {
			return self::$_arrSubmittalNotificationsBySubmittalId;
		} else {
			return null;
		}
	}

	public static function setArrSubmittalNotificationsBySubmittalId($arrSubmittalNotificationsBySubmittalId)
	{
		self::$_arrSubmittalNotificationsBySubmittalId = $arrSubmittalNotificationsBySubmittalId;
	}

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllSubmittalNotifications()
	{
		if (isset(self::$_arrAllSubmittalNotifications)) {
			return self::$_arrAllSubmittalNotifications;
		} else {
			return null;
		}
	}

	public static function setArrAllSubmittalNotifications($arrAllSubmittalNotifications)
	{
		self::$_arrAllSubmittalNotifications = $arrAllSubmittalNotifications;
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
	 * @param int $submittal_notification_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findById($database, $submittal_notification_id,$table='submittal_notifications', $module='SubmittalNotification')
	{
		$submittalNotification = parent::findById($database, $submittal_notification_id, $table, $module);

		return $submittalNotification;
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Similar to FindById, but with SQL as starter code for more complex joins.
	 *
	 * @param string $database
	 * @param int $submittal_notification_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findSubmittalNotificationByIdExtended($database, $submittal_notification_id)
	{
		$submittal_notification_id = (int) $submittal_notification_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	sun_fk_su.`id` AS 'sun_fk_su__submittal_id',
	sun_fk_su.`project_id` AS 'sun_fk_su__project_id',
	sun_fk_su.`su_sequence_number` AS 'sun_fk_su__su_sequence_number',
	sun_fk_su.`submittal_type_id` AS 'sun_fk_su__submittal_type_id',
	sun_fk_su.`submittal_status_id` AS 'sun_fk_su__submittal_status_id',
	sun_fk_su.`submittal_priority_id` AS 'sun_fk_su__submittal_priority_id',
	sun_fk_su.`submittal_distribution_method_id` AS 'sun_fk_su__submittal_distribution_method_id',
	sun_fk_su.`su_file_manager_file_id` AS 'sun_fk_su__su_file_manager_file_id',
	sun_fk_su.`su_cost_code_id` AS 'sun_fk_su__su_cost_code_id',
	sun_fk_su.`su_creator_contact_id` AS 'sun_fk_su__su_creator_contact_id',
	sun_fk_su.`su_creator_contact_company_office_id` AS 'sun_fk_su__su_creator_contact_company_office_id',
	sun_fk_su.`su_creator_phone_contact_company_office_phone_number_id` AS 'sun_fk_su__su_creator_phone_contact_company_office_phone_number_id',
	sun_fk_su.`su_creator_fax_contact_company_office_phone_number_id` AS 'sun_fk_su__su_creator_fax_contact_company_office_phone_number_id',
	sun_fk_su.`su_creator_contact_mobile_phone_number_id` AS 'sun_fk_su__su_creator_contact_mobile_phone_number_id',
	sun_fk_su.`su_recipient_contact_id` AS 'sun_fk_su__su_recipient_contact_id',
	sun_fk_su.`su_recipient_contact_company_office_id` AS 'sun_fk_su__su_recipient_contact_company_office_id',
	sun_fk_su.`su_recipient_phone_contact_company_office_phone_number_id` AS 'sun_fk_su__su_recipient_phone_contact_company_office_phone_number_id',
	sun_fk_su.`su_recipient_fax_contact_company_office_phone_number_id` AS 'sun_fk_su__su_recipient_fax_contact_company_office_phone_number_id',
	sun_fk_su.`su_recipient_contact_mobile_phone_number_id` AS 'sun_fk_su__su_recipient_contact_mobile_phone_number_id',
	sun_fk_su.`su_initiator_contact_id` AS 'sun_fk_su__su_initiator_contact_id',
	sun_fk_su.`su_initiator_contact_company_office_id` AS 'sun_fk_su__su_initiator_contact_company_office_id',
	sun_fk_su.`su_initiator_phone_contact_company_office_phone_number_id` AS 'sun_fk_su__su_initiator_phone_contact_company_office_phone_number_id',
	sun_fk_su.`su_initiator_fax_contact_company_office_phone_number_id` AS 'sun_fk_su__su_initiator_fax_contact_company_office_phone_number_id',
	sun_fk_su.`su_initiator_contact_mobile_phone_number_id` AS 'sun_fk_su__su_initiator_contact_mobile_phone_number_id',
	sun_fk_su.`su_title` AS 'sun_fk_su__su_title',
	sun_fk_su.`su_plan_page_reference` AS 'sun_fk_su__su_plan_page_reference',
	sun_fk_su.`su_statement` AS 'sun_fk_su__su_statement',
	sun_fk_su.`created` AS 'sun_fk_su__created',
	sun_fk_su.`su_due_date` AS 'sun_fk_su__su_due_date',
	sun_fk_su.`su_closed_date` AS 'sun_fk_su__su_closed_date',

	sun.*

FROM `submittal_notifications` sun
	INNER JOIN `submittals` sun_fk_su ON sun.`submittal_id` = sun_fk_su.`id`
WHERE sun.`id` = ?
";
		$arrValues = array($submittal_notification_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$submittal_notification_id = $row['id'];
			$submittalNotification = self::instantiateOrm($database, 'SubmittalNotification', $row, null, $submittal_notification_id);
			/* @var $submittalNotification SubmittalNotification */
			$submittalNotification->convertPropertiesToData();

			if (isset($row['submittal_id'])) {
				$submittal_id = $row['submittal_id'];
				$row['sun_fk_su__id'] = $submittal_id;
				$submittal = self::instantiateOrm($database, 'Submittal', $row, null, $submittal_id, 'sun_fk_su__');
				/* @var $submittal Submittal */
				$submittal->convertPropertiesToData();
			} else {
				$submittal = false;
			}
			$submittalNotification->setSubmittal($submittal);

			return $submittalNotification;
		} else {
			return false;
		}
	}

		// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Similar to FindById, but with SQL as starter code for more complex joins.
	 *
	 * @param string $database
	 * @param int $submittal_notification_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findSubmittalNotificationBySubmittalIdExtended($database, $submittal_id)
	{
		$submittal_id = (int) $submittal_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	sun.*
FROM `submittal_notifications` sun
WHERE sun.`submittal_id` = ? Order By id Asc
";
		$arrValues = array($submittal_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$submittal_notification_id = $row['id'];
			
			return $submittal_notification_id;
		} else {
			return false;
		}
	}

	// Finders: Find By Unique Index
	/**
	 * Find by unique index `unique_submittal_notification` (`submittal_id`,`submittal_notification_timestamp`).
	 *
	 * @param string $database
	 * @param int $submittal_id
	 * @param string $submittal_notification_timestamp
	 * @return mixed (single ORM object | false)
	 */
	public static function findBySubmittalIdAndSubmittalNotificationTimestamp($database, $submittal_id, $submittal_notification_timestamp)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	sun.*

FROM `submittal_notifications` sun
WHERE sun.`submittal_id` = ?
AND sun.`submittal_notification_timestamp` = ?
";
		$arrValues = array($submittal_id, $submittal_notification_timestamp);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if ($row && !empty($row)) {
			$submittal_notification_id = $row['id'];
			$submittalNotification = self::instantiateOrm($database, 'SubmittalNotification', $row, null, $submittal_notification_id);
			/* @var $submittalNotification SubmittalNotification */
			return $submittalNotification;
		} else {
			return false;
		}
	}

	// Loaders: Load By pk List (list of auto int ids or other non auto int pk list)
	/**
	 * Load zero or more records by an id list (array of auto int primary keys).
	 *
	 * @param string $database
	 * @param array $arrSubmittalNotificationIds
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubmittalNotificationsByArrSubmittalNotificationIds($database, $arrSubmittalNotificationIds, Input $options=null)
	{
		if (empty($arrSubmittalNotificationIds)) {
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
		// ORDER BY `id` ASC, `submittal_id` ASC, `submittal_notification_timestamp` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubmittalNotification = new SubmittalNotification($database);
			$sqlOrderByColumns = $tmpSubmittalNotification->constructSqlOrderByColumns($arrOrderByAttributes);

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

		foreach ($arrSubmittalNotificationIds as $k => $submittal_notification_id) {
			$submittal_notification_id = (int) $submittal_notification_id;
			$arrSubmittalNotificationIds[$k] = $db->escape($submittal_notification_id);
		}
		$csvSubmittalNotificationIds = join(',', $arrSubmittalNotificationIds);

		$query =
"
SELECT

	sun.*

FROM `submittal_notifications` sun
WHERE sun.`id` IN ($csvSubmittalNotificationIds){$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		$arrSubmittalNotificationsByCsvSubmittalNotificationIds = array();
		while ($row = $db->fetch()) {
			$submittal_notification_id = $row['id'];
			$submittalNotification = self::instantiateOrm($database, 'SubmittalNotification', $row, null, $submittal_notification_id);
			/* @var $submittalNotification SubmittalNotification */
			$submittalNotification->convertPropertiesToData();

			$arrSubmittalNotificationsByCsvSubmittalNotificationIds[$submittal_notification_id] = $submittalNotification;
		}

		$db->free_result();

		return $arrSubmittalNotificationsByCsvSubmittalNotificationIds;
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `submittal_notifications_fk_su` foreign key (`submittal_id`) references `submittals` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $submittal_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubmittalNotificationsBySubmittalId($database, $submittal_id, Input $options=null)
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
			self::$_arrSubmittalNotificationsBySubmittalId = null;
		}

		$arrSubmittalNotificationsBySubmittalId = self::$_arrSubmittalNotificationsBySubmittalId;
		if (isset($arrSubmittalNotificationsBySubmittalId) && !empty($arrSubmittalNotificationsBySubmittalId)) {
			return $arrSubmittalNotificationsBySubmittalId;
		}

		$submittal_id = (int) $submittal_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `submittal_id` ASC, `submittal_notification_timestamp` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubmittalNotification = new SubmittalNotification($database);
			$sqlOrderByColumns = $tmpSubmittalNotification->constructSqlOrderByColumns($arrOrderByAttributes);

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
	sun.*

FROM `submittal_notifications` sun
WHERE sun.`submittal_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `submittal_id` ASC, `submittal_notification_timestamp` ASC
		$arrValues = array($submittal_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubmittalNotificationsBySubmittalId = array();
		while ($row = $db->fetch()) {
			$submittal_notification_id = $row['id'];
			$submittalNotification = self::instantiateOrm($database, 'SubmittalNotification', $row, null, $submittal_notification_id);
			/* @var $submittalNotification SubmittalNotification */
			$arrSubmittalNotificationsBySubmittalId[$submittal_notification_id] = $submittalNotification;
		}

		$db->free_result();

		self::$_arrSubmittalNotificationsBySubmittalId = $arrSubmittalNotificationsBySubmittalId;

		return $arrSubmittalNotificationsBySubmittalId;
	}

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all submittal_notifications records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllSubmittalNotifications($database, Input $options=null)
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
			self::$_arrAllSubmittalNotifications = null;
		}

		$arrAllSubmittalNotifications = self::$_arrAllSubmittalNotifications;
		if (isset($arrAllSubmittalNotifications) && !empty($arrAllSubmittalNotifications)) {
			return $arrAllSubmittalNotifications;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `submittal_id` ASC, `submittal_notification_timestamp` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubmittalNotification = new SubmittalNotification($database);
			$sqlOrderByColumns = $tmpSubmittalNotification->constructSqlOrderByColumns($arrOrderByAttributes);

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
	sun.*

FROM `submittal_notifications` sun{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `submittal_id` ASC, `submittal_notification_timestamp` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllSubmittalNotifications = array();
		while ($row = $db->fetch()) {
			$submittal_notification_id = $row['id'];
			$submittalNotification = self::instantiateOrm($database, 'SubmittalNotification', $row, null, $submittal_notification_id);
			/* @var $submittalNotification SubmittalNotification */
			$arrAllSubmittalNotifications[$submittal_notification_id] = $submittalNotification;
		}

		$db->free_result();

		self::$_arrAllSubmittalNotifications = $arrAllSubmittalNotifications;

		return $arrAllSubmittalNotifications;
	}

	public static function loadRequestForSubmittalRecipientsBySubmittalId($database, $submittal_id, Input $options=null){

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
			self::$_arrSubmittalNotificationsBySubmittalId = null;
		}

		$arrSubmittalNotificationsBySubmittalId = self::$_arrSubmittalNotificationsBySubmittalId;
		if (isset($arrSubmittalNotificationsBySubmittalId) && !empty($arrSubmittalNotificationsBySubmittalId)) {
			return $arrSubmittalNotificationsBySubmittalId;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `request_for_information_id` ASC, `request_for_information_notification_timestamp` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			

			if (!empty($sqlOrderByColumns)) {
				$sqlOrderBy = "\nORDER BY $sqlOrderByColumns";
			}
		}else{
			$sqlOrderBy = "\nORDER BY subr.`su_additional_recipient_created_date` ASC";
		}

		$sqlLimit = '';
		if (isset($limit)) {
			if (isset($offset)) {
				$sqlLimit = "\nLIMIT $escapedOffset, $escapedLimit";
			} else {
				$sqlLimit = "\nLIMIT $escapedLimit";
			}
		}

		$submittal_id = (int) $submittal_id;


		$query =
"
SELECT `subnot`.id as submittal_notification_id, `subnot`.`submittal_id` as submittal_id, `subr`.smtp_recipient_header_type,`subr`.su_additional_recipient_contact_id,`subr`.su_additional_recipient_created_date,`subr`.su_additional_recipient_creator_contact_id,`con`.first_name,`con`.`last_name`,`con`.email,`con`.is_archive FROM `submittal_notifications` subnot INNER JOIN submittal_recipients subr ON subr.`submittal_notification_id` = subnot.`id` INNER JOIN `contacts` con ON `subr`.su_additional_recipient_contact_id = `con`.id WHERE `subnot`.`submittal_id` = ? {$sqlOrderBy}{$sqlLimit}
";

		$db->free_result();
		$arrValues = array($submittal_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubmittalBySubmittalId = array();


		while ($row = $db->fetch()) {
			$arrSubmittalBySubmittalId[] = $row;
		}
		$db->free_result();
		return $arrSubmittalBySubmittalId;

	}
	public static function InsertNotification($database,$submittal_id)
	{
		$db = DBI::getInstance($database);
		$query = "INSERT INTO `submittal_notifications`(`submittal_id`) VALUES (?)";
		$arrValues = array($submittal_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$primaryKey = $db->insertId;
		$db->free_result();
		return $primaryKey;
	}

	// Fucntion to list the additional "To" users recipients	
	public static function loadRequestForSubmittalRecipientsForTo($database, $submittal_id){		

		$db = DBI::getInstance($database);
		$submittal_id = (int) $submittal_id;
		$query =
		"
		SELECT `subnot`.id as submittal_notification_id, `subnot`.`submittal_id` as submittal_id, `subr`.smtp_recipient_header_type,`subr`.su_additional_recipient_contact_id,`subr`.su_additional_recipient_created_date,`subr`.su_additional_recipient_creator_contact_id,`con`.first_name,`con`.`last_name`,`con`.email,`con`.is_archive FROM `submittal_notifications` subnot INNER JOIN submittal_recipients subr ON subr.`submittal_notification_id` = subnot.`id` INNER JOIN `contacts` con ON `subr`.su_additional_recipient_contact_id = `con`.id WHERE `subnot`.`submittal_id` = ? AND `subr`.`smtp_recipient_header_type` = 'To' ORDER BY subr.`is_to_history` ASC
		";

		$db->free_result();
		$arrValues = array($submittal_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubmittalBySubmittalId = array();


		while ($row = $db->fetch()) {
			$arrSubmittalBySubmittalId[] = $row;
		}
		$db->free_result();
		return $arrSubmittalBySubmittalId;

	}

	// Fucntion to list the "To" recipients	From submittal_to_recipients_log
	public static function getListOfToRecipientFromSuLog($database, $submittal_id){		

		$db = DBI::getInstance($database);
		$submittal_id = (int) $submittal_id;

		$query =
		"SELECT 
			`subnot`.id AS submittal_notification_id, 
			`subnot`.`submittal_id` AS submittal_id, 
			GROUP_CONCAT(`subrl`.su_to_recipient_contact_id) AS to_id,
			`subrl`.*,
			GROUP_CONCAT(IF(IFNULL(CONCAT(`con`.`first_name`,' ',`con`.`last_name`),'')!='',
			IF(`con`.`is_archive` = 'Y', CONCAT(`con`.`first_name`,' ',`con`.`last_name`,' (Archived)'), CONCAT(`con`.`first_name`,' ',`con`.`last_name`)),
			IF(`con`.`is_archive` = 'Y', CONCAT(`con`.email,' (Archived)'), `con`.email)) SEPARATOR ', ') AS to_email
			FROM `submittal_notifications` subnot 
			INNER JOIN submittal_to_recipients_log subrl ON subrl.`submittal_notification_id` = subnot.`id` 
			INNER JOIN `contacts` con ON `subrl`.su_to_recipient_contact_id = `con`.id 
			WHERE `subnot`.`submittal_id` = ? GROUP BY subrl.`history`,subrl.`status` ORDER BY subrl.`history` ASC
		";

		$arrValues = array($submittal_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubmittalBySubmittalId = array();

		while ($row = $db->fetch()) {
			$arrSubmittalBySubmittalId[] = $row;
		}
		$db->free_result();
		return $arrSubmittalBySubmittalId;
	}


	public static function getNotificationIdforSubmittals($database,$moduleid){
	$db = DBI::getInstance($database);
	
	$query = "SELECT `id` FROM `submittal_notifications` WHERE `submittal_id` = ? ";
	$arrvalues = array($moduleid);
	$db->execute($query, $arrvalues, MYSQLI_USE_RESULT);
	$row = $db->fetch();
	$notification_id = $row['id'];
	$db->free_result();
	return $notification_id;
        }

	// Save: insert on duplicate key update

	// Save: insert ignore
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

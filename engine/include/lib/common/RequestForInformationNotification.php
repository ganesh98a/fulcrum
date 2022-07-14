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
 * RequestForInformationNotification.
 *
 * @category   Framework
 * @package    RequestForInformationNotification
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class RequestForInformationNotification extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'RequestForInformationNotification';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'request_for_information_notifications';

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
	 * unique index `unique_request_for_information_notification` (`request_for_information_id`,`request_for_information_notification_timestamp`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_request_for_information_notification' => array(
			'request_for_information_id' => 'int',
			'request_for_information_notification_timestamp' => 'string'
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
		'id' => 'request_for_information_notification_id',

		'request_for_information_id' => 'request_for_information_id',

		'request_for_information_notification_timestamp' => 'request_for_information_notification_timestamp'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $request_for_information_notification_id;

	public $request_for_information_id;

	public $request_for_information_notification_timestamp;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties

	// HTML ENTITY ENCODED NL2BR ORM string properties

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)
	protected static $_arrRequestForInformationNotificationsByRequestForInformationId;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllRequestForInformationNotifications;

	// Foreign Key Objects
	private $_requestForInformation;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='request_for_information_notifications')
	{
		parent::__construct($table);
		$this->setDatabase($database);
	}

	// Foreign Key Object Accessor Methods
	public function getRequestForInformation()
	{
		if (isset($this->_requestForInformation)) {
			return $this->_requestForInformation;
		} else {
			return null;
		}
	}

	public function setRequestForInformation($requestForInformation)
	{
		$this->_requestForInformation = $requestForInformation;
	}

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)
	public static function getArrRequestForInformationNotificationsByRequestForInformationId()
	{
		if (isset(self::$_arrRequestForInformationNotificationsByRequestForInformationId)) {
			return self::$_arrRequestForInformationNotificationsByRequestForInformationId;
		} else {
			return null;
		}
	}

	public static function setArrRequestForInformationNotificationsByRequestForInformationId($arrRequestForInformationNotificationsByRequestForInformationId)
	{
		self::$_arrRequestForInformationNotificationsByRequestForInformationId = $arrRequestForInformationNotificationsByRequestForInformationId;
	}

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllRequestForInformationNotifications()
	{
		if (isset(self::$_arrAllRequestForInformationNotifications)) {
			return self::$_arrAllRequestForInformationNotifications;
		} else {
			return null;
		}
	}

	public static function setArrAllRequestForInformationNotifications($arrAllRequestForInformationNotifications)
	{
		self::$_arrAllRequestForInformationNotifications = $arrAllRequestForInformationNotifications;
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
	 * @param int $request_for_information_notification_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findById($database, $request_for_information_notification_id,$table='request_for_information_notifications', $module='RequestForInformationNotification')
	{
		$requestForInformationNotification = parent::findById($database, $request_for_information_notification_id, $table, $module);

		return $requestForInformationNotification;
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Similar to FindById, but with SQL as starter code for more complex joins.
	 *
	 * @param string $database
	 * @param int $request_for_information_notification_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findRequestForInformationNotificationByIdExtended($database, $request_for_information_notification_id)
	{
		$request_for_information_notification_id = (int) $request_for_information_notification_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	rfin_fk_rfi.`id` AS 'rfin_fk_rfi__request_for_information_id',
	rfin_fk_rfi.`project_id` AS 'rfin_fk_rfi__project_id',
	rfin_fk_rfi.`rfi_sequence_number` AS 'rfin_fk_rfi__rfi_sequence_number',
	rfin_fk_rfi.`request_for_information_type_id` AS 'rfin_fk_rfi__request_for_information_type_id',
	rfin_fk_rfi.`request_for_information_status_id` AS 'rfin_fk_rfi__request_for_information_status_id',
	rfin_fk_rfi.`request_for_information_priority_id` AS 'rfin_fk_rfi__request_for_information_priority_id',
	rfin_fk_rfi.`rfi_file_manager_file_id` AS 'rfin_fk_rfi__rfi_file_manager_file_id',
	rfin_fk_rfi.`rfi_cost_code_id` AS 'rfin_fk_rfi__rfi_cost_code_id',
	rfin_fk_rfi.`rfi_creator_contact_id` AS 'rfin_fk_rfi__rfi_creator_contact_id',
	rfin_fk_rfi.`rfi_creator_contact_company_office_id` AS 'rfin_fk_rfi__rfi_creator_contact_company_office_id',
	rfin_fk_rfi.`rfi_creator_phone_contact_company_office_phone_number_id` AS 'rfin_fk_rfi__rfi_creator_phone_contact_company_office_phone_number_id',
	rfin_fk_rfi.`rfi_creator_fax_contact_company_office_phone_number_id` AS 'rfin_fk_rfi__rfi_creator_fax_contact_company_office_phone_number_id',
	rfin_fk_rfi.`rfi_creator_contact_mobile_phone_number_id` AS 'rfin_fk_rfi__rfi_creator_contact_mobile_phone_number_id',
	rfin_fk_rfi.`rfi_recipient_contact_id` AS 'rfin_fk_rfi__rfi_recipient_contact_id',
	rfin_fk_rfi.`rfi_recipient_contact_company_office_id` AS 'rfin_fk_rfi__rfi_recipient_contact_company_office_id',
	rfin_fk_rfi.`rfi_recipient_phone_contact_company_office_phone_number_id` AS 'rfin_fk_rfi__rfi_recipient_phone_contact_company_office_phone_number_id',
	rfin_fk_rfi.`rfi_recipient_fax_contact_company_office_phone_number_id` AS 'rfin_fk_rfi__rfi_recipient_fax_contact_company_office_phone_number_id',
	rfin_fk_rfi.`rfi_recipient_contact_mobile_phone_number_id` AS 'rfin_fk_rfi__rfi_recipient_contact_mobile_phone_number_id',
	rfin_fk_rfi.`rfi_initiator_contact_id` AS 'rfin_fk_rfi__rfi_initiator_contact_id',
	rfin_fk_rfi.`rfi_initiator_contact_company_office_id` AS 'rfin_fk_rfi__rfi_initiator_contact_company_office_id',
	rfin_fk_rfi.`rfi_initiator_phone_contact_company_office_phone_number_id` AS 'rfin_fk_rfi__rfi_initiator_phone_contact_company_office_phone_number_id',
	rfin_fk_rfi.`rfi_initiator_fax_contact_company_office_phone_number_id` AS 'rfin_fk_rfi__rfi_initiator_fax_contact_company_office_phone_number_id',
	rfin_fk_rfi.`rfi_initiator_contact_mobile_phone_number_id` AS 'rfin_fk_rfi__rfi_initiator_contact_mobile_phone_number_id',
	rfin_fk_rfi.`rfi_title` AS 'rfin_fk_rfi__rfi_title',
	rfin_fk_rfi.`rfi_plan_page_reference` AS 'rfin_fk_rfi__rfi_plan_page_reference',
	rfin_fk_rfi.`rfi_statement` AS 'rfin_fk_rfi__rfi_statement',
	rfin_fk_rfi.`created` AS 'rfin_fk_rfi__created',
	rfin_fk_rfi.`rfi_due_date` AS 'rfin_fk_rfi__rfi_due_date',
	rfin_fk_rfi.`rfi_closed_date` AS 'rfin_fk_rfi__rfi_closed_date',

	rfin.*

FROM `request_for_information_notifications` rfin
	INNER JOIN `requests_for_information` rfin_fk_rfi ON rfin.`request_for_information_id` = rfin_fk_rfi.`id`
WHERE rfin.`id` = ?
";
		$arrValues = array($request_for_information_notification_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$request_for_information_notification_id = $row['id'];
			$requestForInformationNotification = self::instantiateOrm($database, 'RequestForInformationNotification', $row, null, $request_for_information_notification_id);
			/* @var $requestForInformationNotification RequestForInformationNotification */
			$requestForInformationNotification->convertPropertiesToData();

			if (isset($row['request_for_information_id'])) {
				$request_for_information_id = $row['request_for_information_id'];
				$row['rfin_fk_rfi__id'] = $request_for_information_id;
				$requestForInformation = self::instantiateOrm($database, 'RequestForInformation', $row, null, $request_for_information_id, 'rfin_fk_rfi__');
				/* @var $requestForInformation RequestForInformation */
				$requestForInformation->convertPropertiesToData();
			} else {
				$requestForInformation = false;
			}
			$requestForInformationNotification->setRequestForInformation($requestForInformation);

			return $requestForInformationNotification;
		} else {
			return false;
		}
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Similar to FindById, but with SQL as starter code for more complex joins.
	 *
	 * @param string $database
	 * @param int $request_for_information_notification_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findRequestForInformationNotificationByRfiIdExtended($database, $request_for_information_id)
	{
		$request_for_information_id = (int) $request_for_information_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	rfin.*

FROM `request_for_information_notifications` rfin
WHERE rfin.`request_for_information_id` = ? Order By id Asc
";
		$arrValues = array($request_for_information_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$request_for_information_notification_id = $row['id'];

			return $request_for_information_notification_id;
		} else {
			return false;
		}
	}

	// Finders: Find By Unique Index
	/**
	 * Find by unique index `unique_request_for_information_notification` (`request_for_information_id`,`request_for_information_notification_timestamp`).
	 *
	 * @param string $database
	 * @param int $request_for_information_id
	 * @param string $request_for_information_notification_timestamp
	 * @return mixed (single ORM object | false)
	 */
	public static function findByRequestForInformationIdAndRequestForInformationNotificationTimestamp($database, $request_for_information_id, $request_for_information_notification_timestamp)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	rfin.*

FROM `request_for_information_notifications` rfin
WHERE rfin.`request_for_information_id` = ?
AND rfin.`request_for_information_notification_timestamp` = ?
";
		$arrValues = array($request_for_information_id, $request_for_information_notification_timestamp);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if ($row && !empty($row)) {
			$request_for_information_notification_id = $row['id'];
			$requestForInformationNotification = self::instantiateOrm($database, 'RequestForInformationNotification', $row, null, $request_for_information_notification_id);
			/* @var $requestForInformationNotification RequestForInformationNotification */
			return $requestForInformationNotification;
		} else {
			return false;
		}
	}

	// Loaders: Load By pk List (list of auto int ids or other non auto int pk list)
	/**
	 * Load zero or more records by an id list (array of auto int primary keys).
	 *
	 * @param string $database
	 * @param array $arrRequestForInformationNotificationIds
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadRequestForInformationNotificationsByArrRequestForInformationNotificationIds($database, $arrRequestForInformationNotificationIds, Input $options=null)
	{
		if (empty($arrRequestForInformationNotificationIds)) {
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
		// ORDER BY `id` ASC, `request_for_information_id` ASC, `request_for_information_notification_timestamp` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpRequestForInformationNotification = new RequestForInformationNotification($database);
			$sqlOrderByColumns = $tmpRequestForInformationNotification->constructSqlOrderByColumns($arrOrderByAttributes);

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

		foreach ($arrRequestForInformationNotificationIds as $k => $request_for_information_notification_id) {
			$request_for_information_notification_id = (int) $request_for_information_notification_id;
			$arrRequestForInformationNotificationIds[$k] = $db->escape($request_for_information_notification_id);
		}
		$csvRequestForInformationNotificationIds = join(',', $arrRequestForInformationNotificationIds);

		$query =
"
SELECT

	rfin.*

FROM `request_for_information_notifications` rfin
WHERE rfin.`id` IN ($csvRequestForInformationNotificationIds){$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		$arrRequestForInformationNotificationsByCsvRequestForInformationNotificationIds = array();
		while ($row = $db->fetch()) {
			$request_for_information_notification_id = $row['id'];
			$requestForInformationNotification = self::instantiateOrm($database, 'RequestForInformationNotification', $row, null, $request_for_information_notification_id);
			/* @var $requestForInformationNotification RequestForInformationNotification */
			$requestForInformationNotification->convertPropertiesToData();

			$arrRequestForInformationNotificationsByCsvRequestForInformationNotificationIds[$request_for_information_notification_id] = $requestForInformationNotification;
		}

		$db->free_result();

		return $arrRequestForInformationNotificationsByCsvRequestForInformationNotificationIds;
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `request_for_information_notifications_fk_rfi` foreign key (`request_for_information_id`) references `requests_for_information` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $request_for_information_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadRequestForInformationNotificationsByRequestForInformationId($database, $request_for_information_id, Input $options=null)
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
			self::$_arrRequestForInformationNotificationsByRequestForInformationId = null;
		}

		$arrRequestForInformationNotificationsByRequestForInformationId = self::$_arrRequestForInformationNotificationsByRequestForInformationId;
		if (isset($arrRequestForInformationNotificationsByRequestForInformationId) && !empty($arrRequestForInformationNotificationsByRequestForInformationId)) {
			return $arrRequestForInformationNotificationsByRequestForInformationId;
		}

		$request_for_information_id = (int) $request_for_information_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `request_for_information_id` ASC, `request_for_information_notification_timestamp` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpRequestForInformationNotification = new RequestForInformationNotification($database);
			$sqlOrderByColumns = $tmpRequestForInformationNotification->constructSqlOrderByColumns($arrOrderByAttributes);

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
	rfin.*

FROM `request_for_information_notifications` rfin
WHERE rfin.`request_for_information_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `request_for_information_id` ASC, `request_for_information_notification_timestamp` ASC
		$arrValues = array($request_for_information_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrRequestForInformationNotificationsByRequestForInformationId = array();
		while ($row = $db->fetch()) {
			$request_for_information_notification_id = $row['id'];
			$requestForInformationNotification = self::instantiateOrm($database, 'RequestForInformationNotification', $row, null, $request_for_information_notification_id);
			/* @var $requestForInformationNotification RequestForInformationNotification */
			$arrRequestForInformationNotificationsByRequestForInformationId[$request_for_information_notification_id] = $requestForInformationNotification;
		}

		$db->free_result();

		self::$_arrRequestForInformationNotificationsByRequestForInformationId = $arrRequestForInformationNotificationsByRequestForInformationId;

		return $arrRequestForInformationNotificationsByRequestForInformationId;
	}

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all request_for_information_notifications records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllRequestForInformationNotifications($database, Input $options=null)
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
			self::$_arrAllRequestForInformationNotifications = null;
		}

		$arrAllRequestForInformationNotifications = self::$_arrAllRequestForInformationNotifications;
		if (isset($arrAllRequestForInformationNotifications) && !empty($arrAllRequestForInformationNotifications)) {
			return $arrAllRequestForInformationNotifications;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `request_for_information_id` ASC, `request_for_information_notification_timestamp` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpRequestForInformationNotification = new RequestForInformationNotification($database);
			$sqlOrderByColumns = $tmpRequestForInformationNotification->constructSqlOrderByColumns($arrOrderByAttributes);

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
	rfin.*

FROM `request_for_information_notifications` rfin{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `request_for_information_id` ASC, `request_for_information_notification_timestamp` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllRequestForInformationNotifications = array();
		while ($row = $db->fetch()) {
			$request_for_information_notification_id = $row['id'];
			$requestForInformationNotification = self::instantiateOrm($database, 'RequestForInformationNotification', $row, null, $request_for_information_notification_id);
			/* @var $requestForInformationNotification RequestForInformationNotification */
			$arrAllRequestForInformationNotifications[$request_for_information_notification_id] = $requestForInformationNotification;
		}

		$db->free_result();

		self::$_arrAllRequestForInformationNotifications = $arrAllRequestForInformationNotifications;

		return $arrAllRequestForInformationNotifications;
	}

	public static function loadRequestForInformationRecipientsByRequestForInformationId($database, $request_for_information_id, Input $options=null){

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
			self::$_arrRequestForInformationNotificationsByRequestForInformationId = null;
		}

		$arrRequestForInformationNotificationsByRequestForInformationId = self::$_arrRequestForInformationNotificationsByRequestForInformationId;
		if (isset($arrRequestForInformationNotificationsByRequestForInformationId) && !empty($arrRequestForInformationNotificationsByRequestForInformationId)) {
			return $arrRequestForInformationNotificationsByRequestForInformationId;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			

			if (!empty($sqlOrderByColumns)) {
				$sqlOrderBy = "\nORDER BY $sqlOrderByColumns";
			}
		}else{
			$sqlOrderBy = "\nORDER BY rfir.`rfi_additional_recipient_created_date` ASC";
		}

		$sqlLimit = '';
		if (isset($limit)) {
			if (isset($offset)) {
				$sqlLimit = "\nLIMIT $escapedOffset, $escapedLimit";
			} else {
				$sqlLimit = "\nLIMIT $escapedLimit";
			}
		}

		$request_for_information_id = (int) $request_for_information_id;


		$query = "SELECT `rfin`.`id` as request_for_notification_id, 
					`rfin`.`request_for_information_id` as request_for_information_id,
					`rfir`.`smtp_recipient_header_type`, `rfir`.`rfi_additional_recipient_contact_id`,
					`rfir`.`rfi_additional_recipient_creator_contact_id`, 
					`rfir`.`rfi_additional_recipient_created_date`,
					`con`.`first_name`, `con`.`last_name`,`con`.`email`, `con`.`is_archive`
				FROM `request_for_information_notifications` rfin 
					INNER JOIN `request_for_information_recipients` rfir 
				ON `rfin`.`id` = `rfir`.`request_for_information_notification_id` 
					INNER JOIN `contacts` con 
				ON `rfir`.`rfi_additional_recipient_contact_id` = `con`.`id` 
					WHERE `rfin`.`request_for_information_id` =  ? {$sqlOrderBy}{$sqlLimit} ";
		$db->free_result();
		$arrValues = array($request_for_information_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrRequestForRecipientByRequestForInformationId = array();
		while ($row = $db->fetch()) {
			$arrRequestForRecipientByRequestForInformationId[] = $row;
		}
		$db->free_result();
		return $arrRequestForRecipientByRequestForInformationId;

	}

	// Fucntion to list the additional "To" users recipients	
	public static function loadRequestForInformationRecipientsForTo($database, $request_for_information_id){

		$db = DBI::getInstance($database);		
		$request_for_information_id = (int) $request_for_information_id;

		$query = "SELECT `rfin`.`id` as request_for_notification_id, 
					`rfin`.`request_for_information_id` as request_for_information_id,
					`rfir`.`smtp_recipient_header_type`, `rfir`.`rfi_additional_recipient_contact_id`,
					`rfir`.`rfi_additional_recipient_creator_contact_id`, 
					`rfir`.`rfi_additional_recipient_created_date`,
					`con`.`first_name`, `con`.`last_name`,`con`.`email`, `con`.`is_archive`
				FROM `request_for_information_notifications` rfin 
					INNER JOIN `request_for_information_recipients` rfir 
				ON `rfin`.`id` = `rfir`.`request_for_information_notification_id` 
					INNER JOIN `contacts` con 
				ON `rfir`.`rfi_additional_recipient_contact_id` = `con`.`id` 
					WHERE `rfin`.`request_for_information_id` =  ? AND `rfir`.`smtp_recipient_header_type` = 'To'
				ORDER BY rfir.`is_to_history` ASC";
		$db->free_result();
		$arrValues = array($request_for_information_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrRequestForRecipientByRequestForInformationId = array();
		while ($row = $db->fetch()) {
			$arrRequestForRecipientByRequestForInformationId[] = $row;
		}
		$db->free_result();
		return $arrRequestForRecipientByRequestForInformationId;

	}

	// Fucntion to list the "To" recipients	From request_for_information_to_recipients_log
	public static function getListOfToRecipientFromRfiLog($database, $request_for_information_id){		

		$db = DBI::getInstance($database);
		$request_for_information_id = (int) $request_for_information_id;

		$query =
		"SELECT 
			`rfinot`.id AS request_for_information_notification_id, 
			`rfinot`.`request_for_information_id` AS request_for_information_id, 
			GROUP_CONCAT(`rfinl`.rfi_to_recipient_contact_id) AS to_id,
			`rfinl`.*,
			GROUP_CONCAT(IF(IFNULL(CONCAT(`con`.`first_name`,' ',`con`.`last_name`),'')!='',
			IF(`con`.`is_archive` = 'Y', CONCAT(`con`.`first_name`,' ',`con`.`last_name`,' (Archived)'), CONCAT(`con`.`first_name`,' ',`con`.`last_name`)),
			IF(`con`.`is_archive` = 'Y', CONCAT(`con`.email,' (Archived)'), `con`.email)) SEPARATOR ', ') AS to_email
			FROM `request_for_information_notifications` rfinot 
			INNER JOIN request_for_information_to_recipients_log rfinl ON rfinl.`request_for_information_notification_id` = rfinot.`id` 
			INNER JOIN `contacts` con ON `rfinl`.rfi_to_recipient_contact_id = `con`.id 
			WHERE `rfinot`.`request_for_information_id` = ? GROUP BY rfinl.`history`,rfinl.`status` ORDER BY rfinl.`history` ASC
		";

		$arrValues = array($request_for_information_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrRfiByRfiId = array();

		while ($row = $db->fetch()) {
			$arrRfiByRfiId[] = $row;
		}
		$db->free_result();
		return $arrRfiByRfiId;
	}

	public static function getNotificationIdforRFI($database,$moduleid){
	$db = DBI::getInstance($database);
	
	$query = "SELECT `id` FROM `request_for_information_notifications` WHERE `request_for_information_id` = ? ";
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

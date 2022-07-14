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
 * RequestForInformationRecipient.
 *
 * @category   Framework
 * @package    RequestForInformationRecipient
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class RequestForInformationRecipient extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'RequestForInformationRecipient';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'request_for_information_recipients';

	/**
	 * primary key (`request_for_information_notification_id`,`rfi_additional_recipient_contact_id`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrPrimaryKey = array(
		'request_for_information_notification_id' => 'int',
		'rfi_additional_recipient_contact_id' => 'int',
		'is_to_history' => 'int'
	);

	/**
	 * No Unique Indexes, Just a Primary Key
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_request_for_information_recipient_via_primary_key' => array(
			'request_for_information_notification_id' => 'int',
			'rfi_additional_recipient_contact_id' => 'int',
			'is_to_history' => 'int'
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
		'request_for_information_notification_id' => 'request_for_information_notification_id',
		'rfi_additional_recipient_contact_id' => 'rfi_additional_recipient_contact_id',

		'rfi_additional_recipient_contact_mobile_phone_number_id' => 'rfi_additional_recipient_contact_mobile_phone_number_id',

		'smtp_recipient_header_type' => 'smtp_recipient_header_type',
		'is_to_history' => 'is_to_history'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $request_for_information_notification_id;
	public $rfi_additional_recipient_contact_id;

	public $rfi_additional_recipient_contact_mobile_phone_number_id;

	public $smtp_recipient_header_type;
	public $is_to_history;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties

	// HTML ENTITY ENCODED NL2BR ORM string properties

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)
	protected static $_arrRequestForInformationRecipientsByRequestForInformationNotificationId;
	protected static $_arrRequestForInformationRecipientsByRfiAdditionalRecipientContactId;
	protected static $_arrRequestForInformationRecipientsByRfiAdditionalRecipientContactMobilePhoneNumberId;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllRequestForInformationRecipients;

	// Foreign Key Objects
	private $_requestForInformationNotification;
	private $_rfiAdditionalRecipientContact;
	private $_rfiAdditionalRecipientContactMobilePhoneNumber;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='request_for_information_recipients')
	{
		parent::__construct($table);
		$this->setDatabase($database);
	}

	// Foreign Key Object Accessor Methods
	public function getRequestForInformationNotification()
	{
		if (isset($this->_requestForInformationNotification)) {
			return $this->_requestForInformationNotification;
		} else {
			return null;
		}
	}

	public function setRequestForInformationNotification($requestForInformationNotification)
	{
		$this->_requestForInformationNotification = $requestForInformationNotification;
	}

	public function getRfiAdditionalRecipientContact()
	{
		if (isset($this->_rfiAdditionalRecipientContact)) {
			return $this->_rfiAdditionalRecipientContact;
		} else {
			return null;
		}
	}

	public function setRfiAdditionalRecipientContact($rfiAdditionalRecipientContact)
	{
		$this->_rfiAdditionalRecipientContact = $rfiAdditionalRecipientContact;
	}

	public function getRfiAdditionalRecipientContactMobilePhoneNumber()
	{
		if (isset($this->_rfiAdditionalRecipientContactMobilePhoneNumber)) {
			return $this->_rfiAdditionalRecipientContactMobilePhoneNumber;
		} else {
			return null;
		}
	}

	public function setRfiAdditionalRecipientContactMobilePhoneNumber($rfiAdditionalRecipientContactMobilePhoneNumber)
	{
		$this->_rfiAdditionalRecipientContactMobilePhoneNumber = $rfiAdditionalRecipientContactMobilePhoneNumber;
	}

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)
	public function getArrRequestForInformationRecipientsByRequestForInformationNotificationId()
	{
		if (isset(self::$_arrRequestForInformationRecipientsByRequestForInformationNotificationId)) {
			return self::$_arrRequestForInformationRecipientsByRequestForInformationNotificationId;
		} else {
			return null;
		}
	}

	public function setArrRequestForInformationRecipientsByRequestForInformationNotificationId($arrRequestForInformationRecipientsByRequestForInformationNotificationId)
	{
		self::$_arrRequestForInformationRecipientsByRequestForInformationNotificationId = $arrRequestForInformationRecipientsByRequestForInformationNotificationId;
	}

	public function getArrRequestForInformationRecipientsByRfiAdditionalRecipientContactId()
	{
		if (isset(self::$_arrRequestForInformationRecipientsByRfiAdditionalRecipientContactId)) {
			return self::$_arrRequestForInformationRecipientsByRfiAdditionalRecipientContactId;
		} else {
			return null;
		}
	}

	public function setArrRequestForInformationRecipientsByRfiAdditionalRecipientContactId($arrRequestForInformationRecipientsByRfiAdditionalRecipientContactId)
	{
		self::$_arrRequestForInformationRecipientsByRfiAdditionalRecipientContactId = $arrRequestForInformationRecipientsByRfiAdditionalRecipientContactId;
	}

	public function getArrRequestForInformationRecipientsByRfiAdditionalRecipientContactMobilePhoneNumberId()
	{
		if (isset(self::$_arrRequestForInformationRecipientsByRfiAdditionalRecipientContactMobilePhoneNumberId)) {
			return self::$_arrRequestForInformationRecipientsByRfiAdditionalRecipientContactMobilePhoneNumberId;
		} else {
			return null;
		}
	}

	public function setArrRequestForInformationRecipientsByRfiAdditionalRecipientContactMobilePhoneNumberId($arrRequestForInformationRecipientsByRfiAdditionalRecipientContactMobilePhoneNumberId)
	{
		self::$_arrRequestForInformationRecipientsByRfiAdditionalRecipientContactMobilePhoneNumberId = $arrRequestForInformationRecipientsByRfiAdditionalRecipientContactMobilePhoneNumberId;
	}

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public function getArrAllRequestForInformationRecipients()
	{
		if (isset(self::$_arrAllRequestForInformationRecipients)) {
			return self::$_arrAllRequestForInformationRecipients;
		} else {
			return null;
		}
	}

	public function setArrAllRequestForInformationRecipients($arrAllRequestForInformationRecipients)
	{
		self::$_arrAllRequestForInformationRecipients = $arrAllRequestForInformationRecipients;
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
	 * Find by primary key (`request_for_information_notification_id`,`rfi_additional_recipient_contact_id`).
	 *
	 * @param string $database
	 * @param int $request_for_information_notification_id
	 * @param int $rfi_additional_recipient_contact_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findByRequestForInformationNotificationIdAndRfiAdditionalRecipientContactId($database, $request_for_information_notification_id, $rfi_additional_recipient_contact_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	rfir.*

FROM `request_for_information_recipients` rfir
WHERE rfir.`request_for_information_notification_id` = ?
AND rfir.`rfi_additional_recipient_contact_id` = ?
";
		$arrValues = array($request_for_information_notification_id, $rfi_additional_recipient_contact_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row && !empty($row)) {
			$requestForInformationRecipient = self::instantiateOrm($database, 'RequestForInformationRecipient', $row);
			/* @var $requestForInformationRecipient RequestForInformationRecipient */
			return $requestForInformationRecipient;
		} else {
			return false;
		}
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Find by primary key (`request_for_information_notification_id`,`rfi_additional_recipient_contact_id`) Extended.
	 *
	 * @param string $database
	 * @param int $request_for_information_notification_id
	 * @param int $rfi_additional_recipient_contact_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findByRequestForInformationNotificationIdAndRfiAdditionalRecipientContactIdExtended($database, $request_for_information_notification_id, $rfi_additional_recipient_contact_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	rfir_fk_rfin.`id` AS 'rfir_fk_rfin__request_for_information_notification_id',
	rfir_fk_rfin.`request_for_information_id` AS 'rfir_fk_rfin__request_for_information_id',
	rfir_fk_rfin.`request_for_information_notification_timestamp` AS 'rfir_fk_rfin__request_for_information_notification_timestamp',

	rfir_fk_c.`id` AS 'rfir_fk_c__contact_id',
	rfir_fk_c.`user_company_id` AS 'rfir_fk_c__user_company_id',
	rfir_fk_c.`user_id` AS 'rfir_fk_c__user_id',
	rfir_fk_c.`contact_company_id` AS 'rfir_fk_c__contact_company_id',
	rfir_fk_c.`email` AS 'rfir_fk_c__email',
	rfir_fk_c.`name_prefix` AS 'rfir_fk_c__name_prefix',
	rfir_fk_c.`first_name` AS 'rfir_fk_c__first_name',
	rfir_fk_c.`additional_name` AS 'rfir_fk_c__additional_name',
	rfir_fk_c.`middle_name` AS 'rfir_fk_c__middle_name',
	rfir_fk_c.`last_name` AS 'rfir_fk_c__last_name',
	rfir_fk_c.`name_suffix` AS 'rfir_fk_c__name_suffix',
	rfir_fk_c.`title` AS 'rfir_fk_c__title',
	rfir_fk_c.`vendor_flag` AS 'rfir_fk_c__vendor_flag',

	rfir_fk_c_mobile_cpn.`id` AS 'rfir_fk_c_mobile_cpn__contact_phone_number_id',
	rfir_fk_c_mobile_cpn.`contact_id` AS 'rfir_fk_c_mobile_cpn__contact_id',
	rfir_fk_c_mobile_cpn.`phone_number_type_id` AS 'rfir_fk_c_mobile_cpn__phone_number_type_id',
	rfir_fk_c_mobile_cpn.`country_code` AS 'rfir_fk_c_mobile_cpn__country_code',
	rfir_fk_c_mobile_cpn.`area_code` AS 'rfir_fk_c_mobile_cpn__area_code',
	rfir_fk_c_mobile_cpn.`prefix` AS 'rfir_fk_c_mobile_cpn__prefix',
	rfir_fk_c_mobile_cpn.`number` AS 'rfir_fk_c_mobile_cpn__number',
	rfir_fk_c_mobile_cpn.`extension` AS 'rfir_fk_c_mobile_cpn__extension',
	rfir_fk_c_mobile_cpn.`itu` AS 'rfir_fk_c_mobile_cpn__itu',

	rfir.*

FROM `request_for_information_recipients` rfir
	INNER JOIN `request_for_information_notifications` rfir_fk_rfin ON rfir.`request_for_information_notification_id` = rfir_fk_rfin.`id`
	INNER JOIN `contacts` rfir_fk_c ON rfir.`rfi_additional_recipient_contact_id` = rfir_fk_c.`id`
	LEFT OUTER JOIN `contact_phone_numbers` rfir_fk_c_mobile_cpn ON rfir.`rfi_additional_recipient_contact_mobile_phone_number_id` = rfir_fk_c_mobile_cpn.`id`
WHERE rfir.`request_for_information_notification_id` = ?
AND rfir.`rfi_additional_recipient_contact_id` = ?
";
		$arrValues = array($request_for_information_notification_id, $rfi_additional_recipient_contact_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row && !empty($row)) {
			$requestForInformationRecipient = self::instantiateOrm($database, 'RequestForInformationRecipient', $row);
			/* @var $requestForInformationRecipient RequestForInformationRecipient */
			$requestForInformationRecipient->convertPropertiesToData();

			if (isset($row['request_for_information_notification_id'])) {
				$request_for_information_notification_id = $row['request_for_information_notification_id'];
				$row['rfir_fk_rfin__id'] = $request_for_information_notification_id;
				$requestForInformationNotification = self::instantiateOrm($database, 'RequestForInformationNotification', $row, null, $request_for_information_notification_id, 'rfir_fk_rfin__');
				/* @var $requestForInformationNotification RequestForInformationNotification */
				$requestForInformationNotification->convertPropertiesToData();
			} else {
				$requestForInformationNotification = false;
			}
			$requestForInformationRecipient->setRequestForInformationNotification($requestForInformationNotification);

			if (isset($row['rfi_additional_recipient_contact_id'])) {
				$rfi_additional_recipient_contact_id = $row['rfi_additional_recipient_contact_id'];
				$row['rfir_fk_c__id'] = $rfi_additional_recipient_contact_id;
				$rfiAdditionalRecipientContact = self::instantiateOrm($database, 'Contact', $row, null, $rfi_additional_recipient_contact_id, 'rfir_fk_c__');
				/* @var $rfiAdditionalRecipientContact Contact */
				$rfiAdditionalRecipientContact->convertPropertiesToData();
			} else {
				$rfiAdditionalRecipientContact = false;
			}
			$requestForInformationRecipient->setRfiAdditionalRecipientContact($rfiAdditionalRecipientContact);

			if (isset($row['rfi_additional_recipient_contact_mobile_phone_number_id'])) {
				$rfi_additional_recipient_contact_mobile_phone_number_id = $row['rfi_additional_recipient_contact_mobile_phone_number_id'];
				$row['rfir_fk_c_mobile_cpn__id'] = $rfi_additional_recipient_contact_mobile_phone_number_id;
				$rfiAdditionalRecipientContactMobilePhoneNumber = self::instantiateOrm($database, 'ContactPhoneNumber', $row, null, $rfi_additional_recipient_contact_mobile_phone_number_id, 'rfir_fk_c_mobile_cpn__');
				/* @var $rfiAdditionalRecipientContactMobilePhoneNumber ContactPhoneNumber */
				$rfiAdditionalRecipientContactMobilePhoneNumber->convertPropertiesToData();
			} else {
				$rfiAdditionalRecipientContactMobilePhoneNumber = false;
			}
			$requestForInformationRecipient->setRfiAdditionalRecipientContactMobilePhoneNumber($rfiAdditionalRecipientContactMobilePhoneNumber);

			return $requestForInformationRecipient;
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
	 * @param array $arrRequestForInformationNotificationIdAndRfiAdditionalRecipientContactIdList
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadRequestForInformationRecipientsByArrRequestForInformationNotificationIdAndRfiAdditionalRecipientContactIdList($database, $arrRequestForInformationNotificationIdAndRfiAdditionalRecipientContactIdList, Input $options=null)
	{
		if (empty($arrRequestForInformationNotificationIdAndRfiAdditionalRecipientContactIdList)) {
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
		// ORDER BY `request_for_information_notification_id` ASC, `rfi_additional_recipient_contact_id` ASC, `rfi_additional_recipient_contact_mobile_phone_number_id` ASC, `smtp_recipient_header_type` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpRequestForInformationRecipient = new RequestForInformationRecipient($database);
			$sqlOrderByColumns = $tmpRequestForInformationRecipient->constructSqlOrderByColumns($arrOrderByAttributes);

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
		foreach ($arrRequestForInformationNotificationIdAndRfiAdditionalRecipientContactIdList as $k => $arrTmp) {
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
		if (count($arrRequestForInformationNotificationIdAndRfiAdditionalRecipientContactIdList) > 1) {
			$sqlWhere = join($arrSqlWhere, ' OR ');
			$sqlWhere = "WHERE ($sqlWhere)";
		} else {
			$sqlWhere = "WHERE $tmpInnerAnd";
		}

		$query =
"
SELECT

	rfir.*

FROM `request_for_information_recipients` rfir
{$sqlWhere}{$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrRequestForInformationRecipientsByArrRequestForInformationNotificationIdAndRfiAdditionalRecipientContactIdList = array();
		while ($row = $db->fetch()) {
			$requestForInformationRecipient = self::instantiateOrm($database, 'RequestForInformationRecipient', $row);
			/* @var $requestForInformationRecipient RequestForInformationRecipient */
			$arrRequestForInformationRecipientsByArrRequestForInformationNotificationIdAndRfiAdditionalRecipientContactIdList[] = $requestForInformationRecipient;
		}

		$db->free_result();

		return $arrRequestForInformationRecipientsByArrRequestForInformationNotificationIdAndRfiAdditionalRecipientContactIdList;
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `request_for_information_recipients_fk_rfin` foreign key (`request_for_information_notification_id`) references `request_for_information_notifications` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $request_for_information_notification_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadRequestForInformationRecipientsByRequestForInformationNotificationId($database, $request_for_information_notification_id, Input $options=null)
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
			self::$_arrRequestForInformationRecipientsByRequestForInformationNotificationId = null;
		}

		$arrRequestForInformationRecipientsByRequestForInformationNotificationId = self::$_arrRequestForInformationRecipientsByRequestForInformationNotificationId;
		if (isset($arrRequestForInformationRecipientsByRequestForInformationNotificationId) && !empty($arrRequestForInformationRecipientsByRequestForInformationNotificationId)) {
			return $arrRequestForInformationRecipientsByRequestForInformationNotificationId;
		}

		$request_for_information_notification_id = (int) $request_for_information_notification_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `request_for_information_notification_id` ASC, `rfi_additional_recipient_contact_id` ASC, `rfi_additional_recipient_contact_mobile_phone_number_id` ASC, `smtp_recipient_header_type` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpRequestForInformationRecipient = new RequestForInformationRecipient($database);
			$sqlOrderByColumns = $tmpRequestForInformationRecipient->constructSqlOrderByColumns($arrOrderByAttributes);

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

	rfir_fk_rfin.`id` AS 'rfir_fk_rfin__request_for_information_notification_id',
	rfir_fk_rfin.`request_for_information_id` AS 'rfir_fk_rfin__request_for_information_id',
	rfir_fk_rfin.`request_for_information_notification_timestamp` AS 'rfir_fk_rfin__request_for_information_notification_timestamp',

	rfir_fk_c.`id` AS 'rfir_fk_c__contact_id',
	rfir_fk_c.`user_company_id` AS 'rfir_fk_c__user_company_id',
	rfir_fk_c.`user_id` AS 'rfir_fk_c__user_id',
	rfir_fk_c.`contact_company_id` AS 'rfir_fk_c__contact_company_id',
	rfir_fk_c.`email` AS 'rfir_fk_c__email',
	rfir_fk_c.`name_prefix` AS 'rfir_fk_c__name_prefix',
	rfir_fk_c.`first_name` AS 'rfir_fk_c__first_name',
	rfir_fk_c.`additional_name` AS 'rfir_fk_c__additional_name',
	rfir_fk_c.`middle_name` AS 'rfir_fk_c__middle_name',
	rfir_fk_c.`last_name` AS 'rfir_fk_c__last_name',
	rfir_fk_c.`name_suffix` AS 'rfir_fk_c__name_suffix',
	rfir_fk_c.`title` AS 'rfir_fk_c__title',
	rfir_fk_c.`vendor_flag` AS 'rfir_fk_c__vendor_flag',

	rfir_fk_c_mobile_cpn.`id` AS 'rfir_fk_c_mobile_cpn__contact_phone_number_id',
	rfir_fk_c_mobile_cpn.`contact_id` AS 'rfir_fk_c_mobile_cpn__contact_id',
	rfir_fk_c_mobile_cpn.`phone_number_type_id` AS 'rfir_fk_c_mobile_cpn__phone_number_type_id',
	rfir_fk_c_mobile_cpn.`country_code` AS 'rfir_fk_c_mobile_cpn__country_code',
	rfir_fk_c_mobile_cpn.`area_code` AS 'rfir_fk_c_mobile_cpn__area_code',
	rfir_fk_c_mobile_cpn.`prefix` AS 'rfir_fk_c_mobile_cpn__prefix',
	rfir_fk_c_mobile_cpn.`number` AS 'rfir_fk_c_mobile_cpn__number',
	rfir_fk_c_mobile_cpn.`extension` AS 'rfir_fk_c_mobile_cpn__extension',
	rfir_fk_c_mobile_cpn.`itu` AS 'rfir_fk_c_mobile_cpn__itu',

		rfir.*

FROM `request_for_information_recipients` rfir
	INNER JOIN `request_for_information_notifications` rfir_fk_rfin ON rfir.`request_for_information_notification_id` = rfir_fk_rfin.`id`
	INNER JOIN `contacts` rfir_fk_c ON rfir.`rfi_additional_recipient_contact_id` = rfir_fk_c.`id`
	LEFT OUTER JOIN `contact_phone_numbers` rfir_fk_c_mobile_cpn ON rfir.`rfi_additional_recipient_contact_mobile_phone_number_id` = rfir_fk_c_mobile_cpn.`id`
WHERE rfir.`request_for_information_notification_id` = ? AND rfir_fk_c.`is_archive` = 'N' {$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `request_for_information_notification_id` ASC, `rfi_additional_recipient_contact_id` ASC, `rfi_additional_recipient_contact_mobile_phone_number_id` ASC, `smtp_recipient_header_type` ASC
		$arrValues = array($request_for_information_notification_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrRequestForInformationRecipientsByRequestForInformationNotificationId = array();
		while ($row = $db->fetch()) {
			$requestForInformationRecipient = self::instantiateOrm($database, 'RequestForInformationRecipient', $row);
			/* @var $requestForInformationRecipient RequestForInformationRecipient */
			$requestForInformationRecipient->convertPropertiesToData();

			if (isset($row['request_for_information_notification_id'])) {
				$request_for_information_notification_id = $row['request_for_information_notification_id'];
				$row['rfir_fk_rfin__id'] = $request_for_information_notification_id;
				$requestForInformationNotification = self::instantiateOrm($database, 'RequestForInformationNotification', $row, null, $request_for_information_notification_id, 'rfir_fk_rfin__');
				/* @var $requestForInformationNotification RequestForInformationNotification */
				$requestForInformationNotification->convertPropertiesToData();
			} else {
				$requestForInformationNotification = false;
			}
			$requestForInformationRecipient->setRequestForInformationNotification($requestForInformationNotification);

			if (isset($row['rfi_additional_recipient_contact_id'])) {
				$rfi_additional_recipient_contact_id = $row['rfi_additional_recipient_contact_id'];
				$row['rfir_fk_c__id'] = $rfi_additional_recipient_contact_id;
				$rfiAdditionalRecipientContact = self::instantiateOrm($database, 'Contact', $row, null, $rfi_additional_recipient_contact_id, 'rfir_fk_c__');
				/* @var $rfiAdditionalRecipientContact Contact */
				$rfiAdditionalRecipientContact->convertPropertiesToData();
			} else {
				$rfiAdditionalRecipientContact = false;
			}
			$requestForInformationRecipient->setRfiAdditionalRecipientContact($rfiAdditionalRecipientContact);

			if (isset($row['rfi_additional_recipient_contact_mobile_phone_number_id'])) {
				$rfi_additional_recipient_contact_mobile_phone_number_id = $row['rfi_additional_recipient_contact_mobile_phone_number_id'];
				$row['rfir_fk_c_mobile_cpn__id'] = $rfi_additional_recipient_contact_mobile_phone_number_id;
				$rfiAdditionalRecipientContactMobilePhoneNumber = self::instantiateOrm($database, 'ContactPhoneNumber', $row, null, $rfi_additional_recipient_contact_mobile_phone_number_id, 'rfir_fk_c_mobile_cpn__');
				/* @var $rfiAdditionalRecipientContactMobilePhoneNumber ContactPhoneNumber */
				$rfiAdditionalRecipientContactMobilePhoneNumber->convertPropertiesToData();
			} else {
				$rfiAdditionalRecipientContactMobilePhoneNumber = false;
			}
			$requestForInformationRecipient->setRfiAdditionalRecipientContactMobilePhoneNumber($rfiAdditionalRecipientContactMobilePhoneNumber);

			$arrRequestForInformationRecipientsByRequestForInformationNotificationId[] = $requestForInformationRecipient;
		}

		$db->free_result();

		self::$_arrRequestForInformationRecipientsByRequestForInformationNotificationId = $arrRequestForInformationRecipientsByRequestForInformationNotificationId;

		return $arrRequestForInformationRecipientsByRequestForInformationNotificationId;
	}

	/**
	 * Load by constraint `request_for_information_recipients_fk_c` foreign key (`rfi_additional_recipient_contact_id`) references `contacts` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $rfi_additional_recipient_contact_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadRequestForInformationRecipientsByRfiAdditionalRecipientContactId($database, $rfi_additional_recipient_contact_id, Input $options=null)
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
			self::$_arrRequestForInformationRecipientsByRfiAdditionalRecipientContactId = null;
		}

		$arrRequestForInformationRecipientsByRfiAdditionalRecipientContactId = self::$_arrRequestForInformationRecipientsByRfiAdditionalRecipientContactId;
		if (isset($arrRequestForInformationRecipientsByRfiAdditionalRecipientContactId) && !empty($arrRequestForInformationRecipientsByRfiAdditionalRecipientContactId)) {
			return $arrRequestForInformationRecipientsByRfiAdditionalRecipientContactId;
		}

		$rfi_additional_recipient_contact_id = (int) $rfi_additional_recipient_contact_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `request_for_information_notification_id` ASC, `rfi_additional_recipient_contact_id` ASC, `rfi_additional_recipient_contact_mobile_phone_number_id` ASC, `smtp_recipient_header_type` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpRequestForInformationRecipient = new RequestForInformationRecipient($database);
			$sqlOrderByColumns = $tmpRequestForInformationRecipient->constructSqlOrderByColumns($arrOrderByAttributes);

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
	rfir.*

FROM `request_for_information_recipients` rfir
WHERE rfir.`rfi_additional_recipient_contact_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `request_for_information_notification_id` ASC, `rfi_additional_recipient_contact_id` ASC, `rfi_additional_recipient_contact_mobile_phone_number_id` ASC, `smtp_recipient_header_type` ASC
		$arrValues = array($rfi_additional_recipient_contact_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrRequestForInformationRecipientsByRfiAdditionalRecipientContactId = array();
		while ($row = $db->fetch()) {
			$requestForInformationRecipient = self::instantiateOrm($database, 'RequestForInformationRecipient', $row);
			/* @var $requestForInformationRecipient RequestForInformationRecipient */
			$arrRequestForInformationRecipientsByRfiAdditionalRecipientContactId[] = $requestForInformationRecipient;
		}

		$db->free_result();

		self::$_arrRequestForInformationRecipientsByRfiAdditionalRecipientContactId = $arrRequestForInformationRecipientsByRfiAdditionalRecipientContactId;

		return $arrRequestForInformationRecipientsByRfiAdditionalRecipientContactId;
	}

	/**
	 * Load by constraint `request_for_information_recipients_fk_c_mobile_cpn` foreign key (`rfi_additional_recipient_contact_mobile_phone_number_id`) references `contact_phone_numbers` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $rfi_additional_recipient_contact_mobile_phone_number_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadRequestForInformationRecipientsByRfiAdditionalRecipientContactMobilePhoneNumberId($database, $rfi_additional_recipient_contact_mobile_phone_number_id, Input $options=null)
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
			self::$_arrRequestForInformationRecipientsByRfiAdditionalRecipientContactMobilePhoneNumberId = null;
		}

		$arrRequestForInformationRecipientsByRfiAdditionalRecipientContactMobilePhoneNumberId = self::$_arrRequestForInformationRecipientsByRfiAdditionalRecipientContactMobilePhoneNumberId;
		if (isset($arrRequestForInformationRecipientsByRfiAdditionalRecipientContactMobilePhoneNumberId) && !empty($arrRequestForInformationRecipientsByRfiAdditionalRecipientContactMobilePhoneNumberId)) {
			return $arrRequestForInformationRecipientsByRfiAdditionalRecipientContactMobilePhoneNumberId;
		}

		$rfi_additional_recipient_contact_mobile_phone_number_id = (int) $rfi_additional_recipient_contact_mobile_phone_number_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `request_for_information_notification_id` ASC, `rfi_additional_recipient_contact_id` ASC, `rfi_additional_recipient_contact_mobile_phone_number_id` ASC, `smtp_recipient_header_type` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpRequestForInformationRecipient = new RequestForInformationRecipient($database);
			$sqlOrderByColumns = $tmpRequestForInformationRecipient->constructSqlOrderByColumns($arrOrderByAttributes);

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
	rfir.*

FROM `request_for_information_recipients` rfir
WHERE rfir.`rfi_additional_recipient_contact_mobile_phone_number_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `request_for_information_notification_id` ASC, `rfi_additional_recipient_contact_id` ASC, `rfi_additional_recipient_contact_mobile_phone_number_id` ASC, `smtp_recipient_header_type` ASC
		$arrValues = array($rfi_additional_recipient_contact_mobile_phone_number_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrRequestForInformationRecipientsByRfiAdditionalRecipientContactMobilePhoneNumberId = array();
		while ($row = $db->fetch()) {
			$requestForInformationRecipient = self::instantiateOrm($database, 'RequestForInformationRecipient', $row);
			/* @var $requestForInformationRecipient RequestForInformationRecipient */
			$arrRequestForInformationRecipientsByRfiAdditionalRecipientContactMobilePhoneNumberId[] = $requestForInformationRecipient;
		}

		$db->free_result();

		self::$_arrRequestForInformationRecipientsByRfiAdditionalRecipientContactMobilePhoneNumberId = $arrRequestForInformationRecipientsByRfiAdditionalRecipientContactMobilePhoneNumberId;

		return $arrRequestForInformationRecipientsByRfiAdditionalRecipientContactMobilePhoneNumberId;
	}

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all request_for_information_recipients records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllRequestForInformationRecipients($database, Input $options=null)
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
			self::$_arrAllRequestForInformationRecipients = null;
		}

		$arrAllRequestForInformationRecipients = self::$_arrAllRequestForInformationRecipients;
		if (isset($arrAllRequestForInformationRecipients) && !empty($arrAllRequestForInformationRecipients)) {
			return $arrAllRequestForInformationRecipients;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `request_for_information_notification_id` ASC, `rfi_additional_recipient_contact_id` ASC, `rfi_additional_recipient_contact_mobile_phone_number_id` ASC, `smtp_recipient_header_type` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpRequestForInformationRecipient = new RequestForInformationRecipient($database);
			$sqlOrderByColumns = $tmpRequestForInformationRecipient->constructSqlOrderByColumns($arrOrderByAttributes);

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
	rfir.*

FROM `request_for_information_recipients` rfir{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `request_for_information_notification_id` ASC, `rfi_additional_recipient_contact_id` ASC, `rfi_additional_recipient_contact_mobile_phone_number_id` ASC, `smtp_recipient_header_type` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllRequestForInformationRecipients = array();
		while ($row = $db->fetch()) {
			$requestForInformationRecipient = self::instantiateOrm($database, 'RequestForInformationRecipient', $row);
			/* @var $requestForInformationRecipient RequestForInformationRecipient */
			$arrAllRequestForInformationRecipients[] = $requestForInformationRecipient;
		}

		$db->free_result();

		self::$_arrAllRequestForInformationRecipients = $arrAllRequestForInformationRecipients;

		return $arrAllRequestForInformationRecipients;
	}

	// Save: insert on duplicate key update
	public static function insertOnDuplicateKeyUpdate()
	{
		$database = $this->getDatabase();
		$db = $this->getDb($database);
		/* @var $db DBI_mysqli */

		$query =
"
INSERT
INTO `request_for_information_recipients`
(`request_for_information_notification_id`, `rfi_additional_recipient_contact_id`, `rfi_additional_recipient_contact_mobile_phone_number_id`, `smtp_recipient_header_type`)
VALUES (?, ?, ?, ?)
ON DUPLICATE KEY UPDATE `rfi_additional_recipient_contact_mobile_phone_number_id` = ?, `smtp_recipient_header_type` = ?
";
		$arrValues = array($this->request_for_information_notification_id, $this->rfi_additional_recipient_contact_id, $this->rfi_additional_recipient_contact_mobile_phone_number_id, $this->smtp_recipient_header_type, $this->rfi_additional_recipient_contact_mobile_phone_number_id, $this->smtp_recipient_header_type);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$request_for_information_recipient_id = $db->insertId;
		$db->free_result();

		return $request_for_information_recipient_id;
	}

	public static function getAdditionalRecipientCC($database, $request_for_information_notification_id, $smtp_type){
// $database, $request_for_information_notification_id,'To'

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */
		$query = "SELECT * FROM request_for_information_recipients WHERE request_for_information_notification_id = ? AND smtp_recipient_header_type = ? ";
       

		$arrValues = array($request_for_information_notification_id, $smtp_type);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
 		$contact_row = $db->fetch();
 		$additional_recipient_contact_id = 0;
 		if(!empty($contact_row['rfi_additional_recipient_contact_id'])){
 			$additional_recipient_contact_id = $contact_row['rfi_additional_recipient_contact_id'];
 		}
 		return $additional_recipient_contact_id;

	}

	public static function getAdditionalRecipient($database, $request_for_information_id, $smtp_type =''){
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */
		if(!empty($smtp_type)){
			$subQuery = " AND rfir.`smtp_recipient_header_type` = ?";
			$arrValues = array($request_for_information_id, $smtp_type);
		}else{
			$subQuery = "";
			$arrValues = array($request_for_information_id);
		}


		$query = "SELECT rfir.* FROM request_for_information_recipients as rfir INNER JOIN request_for_information_notifications as rfin ON rfin.`id` = rfir.`request_for_information_notification_id`  WHERE rfin.`request_for_information_id` = ? ".$subQuery." ORDER BY rfir.`rfi_additional_recipient_created_date` ASC";
       
		
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$recipient_arr = array();
 		while($contact_row = $db->fetch()){
 			$recipient_arr[] = $contact_row;
 		}
 		return $recipient_arr;

	}

	public static function InsertNotification($database,$rfi_id)
	{
		$db = DBI::getInstance($database);
		$query = "INSERT INTO `request_for_information_notifications`(`request_for_information_id`) VALUES (?)";
		$arrValues = array($rfi_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$primaryKey = $db->insertId;
		$db->free_result();
		return $primaryKey;
	}

	// check whether the rfi To is captured in the rfi recipient table if not the function will capture the data
	public static function checkandUpdateRfiToField($database,$rfi_id,$notification_id,$contact_id)
	{
		// To get the recipient from rfi table
		$db = DBI::getInstance($database);
		$query = "SELECT `rfi_recipient_contact_id` FROM requests_for_information WHERE id = ? ";
       	$arrValues = array($rfi_id);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
 		$row = $db->fetch();
 		$rfi_recipient_contact_id = $row['rfi_recipient_contact_id'];
 		$db->free_result();



		$db = DBI::getInstance($database);
		$query = "SELECT * FROM request_for_information_recipients WHERE request_for_information_notification_id = ? AND smtp_recipient_header_type = ? and rfi_additional_recipient_contact_id = ?";
       	$arrValues = array($notification_id, 'To',$rfi_recipient_contact_id);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
 		$contact_row = $db->fetch();
 		$db->free_result();
 		if(empty($contact_row))
 		{
 				$db = DBI::getInstance($database);
				$query = "INSERT INTO `request_for_information_recipients`(`request_for_information_notification_id`, `rfi_additional_recipient_contact_id`,  `smtp_recipient_header_type`,`rfi_additional_recipient_creator_contact_id`,`is_to_history`) VALUES (?,?,?,?,?)";
				$arrValues = array($notification_id, $rfi_recipient_contact_id,'To',$contact_id,'1');
				$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
				$db->free_result();
 		}
 		$db->free_result();

 		return $rfi_recipient_contact_id;
	}
	// To get the recipients data based on the header
	public static function getRecipientBasedOnHeader($database,$notification_id,$type)
 	{
 		$db = DBI::getInstance($database);
 		$query = "SELECT `rfi_additional_recipient_contact_id`,`smtp_recipient_header_type` FROM `request_for_information_recipients` WHERE `request_for_information_notification_id` = ? and `smtp_recipient_header_type` = ?";
 		$arrvalues = array($notification_id,$type);
 		$db->execute($query, $arrvalues, MYSQLI_USE_RESULT);
 		$dataarray = array();
 		while($row = $db->fetch())
 		{
 			$dataarray[$row['rfi_additional_recipient_contact_id']]  = $row['rfi_additional_recipient_contact_id'];
 		}
 		$db->free_result();
 			return $dataarray;

 	}

 	// To get the recipients and its company data based on the header
	public static function getRecipientCompanyData($database,$notification_id,$type)
 	{
 		$db = DBI::getInstance($database);
 		$query = "SELECT 
	`rfinot`.id AS rfi_notification_id, 
	`rfinot`.`request_for_information_id` AS rfi_id,
	`con`.id AS contact_id,	
	`con`.contact_company_id AS contact_company_id,	
	`con_co`.company AS comany_name,
	IF(IFNULL(CONCAT(`con`.first_name,' ',`con`.last_name),'')!='',
	IF(`con`.is_archive = 'Y', CONCAT(`con`.first_name,' ',`con`.last_name,' (Archived)'), CONCAT(`con`.first_name,' ',`con`.last_name)),
	IF(`con`.is_archive = 'Y', CONCAT(`con`.email,' (Archived)'), `con`.email)) as name,
	IF(`con`.is_archive = 'Y', CONCAT(`con`.email,' (Archived)'), `con`.email) as email
FROM `request_for_information_notifications` rfinot 
	INNER JOIN request_for_information_recipients rfirl ON rfirl.`request_for_information_notification_id` = rfinot.`id` 
	INNER JOIN `contacts` con ON `rfirl`.rfi_additional_recipient_contact_id = `con`.id 
	INNER JOIN `contact_companies` con_co ON `con`.contact_company_id  = `con_co`.id
		WHERE `rfinot`.`request_for_information_id` = ? AND `rfirl`.`smtp_recipient_header_type` = ? ";
 		$arrvalues = array($notification_id,$type);
 		$db->execute($query, $arrvalues, MYSQLI_USE_RESULT);
 		$dataarray = array();
 		while($row = $db->fetch()){
 			$dataarray[]  = $row;
 		}
 		$db->free_result();
 		return $dataarray;
 	}

 	public static function deleteRecipientHeaderData($database,$notification_id,$type)
 	{
 		
 		$db = DBI::getInstance($database);
 		$query = "DELETE FROM `request_for_information_recipients` WHERE request_for_information_notification_id=? and smtp_recipient_header_type=?";
 		$arrvalues = array($notification_id,$type);
 		if($db->execute($query, $arrvalues))
 		{
 			$ret='true';
 		}else
 		{
 			$ret='false';
 		}
 		$db->free_result();
 		return $ret;
 	}

 	// Fucntion to list the recipients
	public static function getListOfToRecipient($database, $request_for_information_id, $type){		

		$db = DBI::getInstance($database);
		$request_for_information_id = (int) $request_for_information_id;

		$query =
		"SELECT 
			`rfinot`.id AS request_for_information_notification_id, 
			`rfinot`.`request_for_information_id` AS request_for_information_id, 
			GROUP_CONCAT(rfirl.`rfi_additional_recipient_contact_id`) AS contact_id,
			GROUP_CONCAT(IF(IFNULL(CONCAT(`con`.`first_name`,' ',`con`.`last_name`),'')!='',
			IF(`con`.`is_archive` = 'Y', CONCAT(`con`.`first_name`,' ',`con`.`last_name`,' (Archived)'), CONCAT(`con`.`first_name`,' ',`con`.`last_name`)),
			IF(`con`.`is_archive` = 'Y', CONCAT(`con`.email,' (Archived)'), `con`.email)) SEPARATOR ', ') AS to_email
			FROM `request_for_information_notifications` rfinot 
			INNER JOIN request_for_information_recipients rfirl ON rfirl.`request_for_information_notification_id` = rfinot.`id` 
			INNER JOIN `contacts` con ON `rfirl`.rfi_additional_recipient_contact_id = `con`.id 
			WHERE `rfinot`.`request_for_information_id` = ? AND `rfirl`.`smtp_recipient_header_type` = ?
		";

		$arrValues = array($request_for_information_id,$type);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);		
 		$row = $db->fetch();
 		
		$db->free_result();
		return $row;
	}

	public static function saveToRecipientBeforeDelete($database,$notification_id,$prev_ids,$current_ids,$creator_contact_id){

 		$db = DBI::getInstance($database);

 		$extra_id = array_diff($current_ids,$prev_ids);
 		$deleted_id = array_diff($prev_ids,$current_ids);

 		// To get last history
 		$query = "SELECT `history` FROM `request_for_information_to_recipients_log` WHERE `request_for_information_notification_id` = $notification_id ORDER BY `id` DESC LIMIT 1";
 		$db->execute($query);
 		$row = $db->fetch();
 		$db->free_result();
 		$history = 0;
 		if ($row) {
 			$history = $row['history']+1;
 		}

 		if (count($extra_id) > 0) {
	 		foreach ($extra_id as $to_id) { 		
		 		$query2 = "INSERT INTO `request_for_information_to_recipients_log`(`request_for_information_notification_id`, `rfi_to_recipient_contact_id`,`rfi_to_recipient_creator_contact_id`, `status`,`history`) VALUES (?,?,?,?,?)";
				$arrValues2 = array($notification_id, $to_id,$creator_contact_id,'1',$history);
				$db->execute($query2, $arrValues2, MYSQLI_USE_RESULT);
		 		$db->free_result();
	 		}
	 	}

	 	if (count($deleted_id) > 0) {
	 		foreach ($deleted_id as $to_id) { 		
		 		$query3 = "INSERT INTO `request_for_information_to_recipients_log`(`request_for_information_notification_id`, `rfi_to_recipient_contact_id`,`rfi_to_recipient_creator_contact_id`, `status`,`history`) VALUES (?,?,?,?,?)";
				$arrValues3 = array($notification_id, $to_id,$creator_contact_id,'0',$history);
				$db->execute($query3, $arrValues3, MYSQLI_USE_RESULT);
		 		$db->free_result();
	 		}
	 	}

 	}

	// Save: insert ignore
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

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
 * SubmittalRecipient.
 *
 * @category   Framework
 * @package    SubmittalRecipient
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class SubmittalRecipient extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'SubmittalRecipient';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'submittal_recipients';

	/**
	 * primary key (`submittal_notification_id`,`su_additional_recipient_contact_id`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrPrimaryKey = array(
		'submittal_notification_id' => 'int',
		'su_additional_recipient_contact_id' => 'int',
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
		'unique_submittal_recipient_via_primary_key' => array(
			'submittal_notification_id' => 'int',
			'su_additional_recipient_contact_id' => 'int',
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
		'submittal_notification_id' => 'submittal_notification_id',
		'su_additional_recipient_contact_id' => 'su_additional_recipient_contact_id',

		'su_additional_recipient_contact_mobile_phone_number_id' => 'su_additional_recipient_contact_mobile_phone_number_id',

		'smtp_recipient_header_type' => 'smtp_recipient_header_type',
		'is_to_history' => '$is_to_history'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $submittal_notification_id;
	public $su_additional_recipient_contact_id;

	public $su_additional_recipient_contact_mobile_phone_number_id;

	public $smtp_recipient_header_type;
	public $su_additional_recipient_creator_contact_id;
	public $is_to_history;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties

	// HTML ENTITY ENCODED NL2BR ORM string properties

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)
	protected static $_arrSubmittalRecipientsBySubmittalNotificationId;
	protected static $_arrSubmittalRecipientsBySuAdditionalRecipientContactId;
	protected static $_arrSubmittalRecipientsBySuAdditionalRecipientContactMobilePhoneNumberId;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllSubmittalRecipients;

	// Foreign Key Objects
	private $_submittalNotification;
	private $_suAdditionalRecipientContact;
	private $_suAdditionalRecipientContactMobilePhoneNumber;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='submittal_recipients')
	{
		parent::__construct($table);
		$this->setDatabase($database);
	}

	// Foreign Key Object Accessor Methods
	public function getSubmittalNotification()
	{
		if (isset($this->_submittalNotification)) {
			return $this->_submittalNotification;
		} else {
			return null;
		}
	}

	public function setSubmittalNotification($submittalNotification)
	{
		$this->_submittalNotification = $submittalNotification;
	}

	public function getSuAdditionalRecipientContact()
	{
		if (isset($this->_suAdditionalRecipientContact)) {
			return $this->_suAdditionalRecipientContact;
		} else {
			return null;
		}
	}

	public function setSuAdditionalRecipientContact($suAdditionalRecipientContact)
	{
		$this->_suAdditionalRecipientContact = $suAdditionalRecipientContact;
	}

	public function getSuAdditionalRecipientContactMobilePhoneNumber()
	{
		if (isset($this->_suAdditionalRecipientContactMobilePhoneNumber)) {
			return $this->_suAdditionalRecipientContactMobilePhoneNumber;
		} else {
			return null;
		}
	}

	public function setSuAdditionalRecipientContactMobilePhoneNumber($suAdditionalRecipientContactMobilePhoneNumber)
	{
		$this->_suAdditionalRecipientContactMobilePhoneNumber = $suAdditionalRecipientContactMobilePhoneNumber;
	}

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)
	public static function getArrSubmittalRecipientsBySubmittalNotificationId()
	{
		if (isset(self::$_arrSubmittalRecipientsBySubmittalNotificationId)) {
			return self::$_arrSubmittalRecipientsBySubmittalNotificationId;
		} else {
			return null;
		}
	}

	public static function setArrSubmittalRecipientsBySubmittalNotificationId($arrSubmittalRecipientsBySubmittalNotificationId)
	{
		self::$_arrSubmittalRecipientsBySubmittalNotificationId = $arrSubmittalRecipientsBySubmittalNotificationId;
	}

	public static function getArrSubmittalRecipientsBySuAdditionalRecipientContactId()
	{
		if (isset(self::$_arrSubmittalRecipientsBySuAdditionalRecipientContactId)) {
			return self::$_arrSubmittalRecipientsBySuAdditionalRecipientContactId;
		} else {
			return null;
		}
	}

	public static function setArrSubmittalRecipientsBySuAdditionalRecipientContactId($arrSubmittalRecipientsBySuAdditionalRecipientContactId)
	{
		self::$_arrSubmittalRecipientsBySuAdditionalRecipientContactId = $arrSubmittalRecipientsBySuAdditionalRecipientContactId;
	}

	public static function getArrSubmittalRecipientsBySuAdditionalRecipientContactMobilePhoneNumberId()
	{
		if (isset(self::$_arrSubmittalRecipientsBySuAdditionalRecipientContactMobilePhoneNumberId)) {
			return self::$_arrSubmittalRecipientsBySuAdditionalRecipientContactMobilePhoneNumberId;
		} else {
			return null;
		}
	}

	public static function setArrSubmittalRecipientsBySuAdditionalRecipientContactMobilePhoneNumberId($arrSubmittalRecipientsBySuAdditionalRecipientContactMobilePhoneNumberId)
	{
		self::$_arrSubmittalRecipientsBySuAdditionalRecipientContactMobilePhoneNumberId = $arrSubmittalRecipientsBySuAdditionalRecipientContactMobilePhoneNumberId;
	}

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllSubmittalRecipients()
	{
		if (isset(self::$_arrAllSubmittalRecipients)) {
			return self::$_arrAllSubmittalRecipients;
		} else {
			return null;
		}
	}

	public static function setArrAllSubmittalRecipients($arrAllSubmittalRecipients)
	{
		self::$_arrAllSubmittalRecipients = $arrAllSubmittalRecipients;
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
	 * Find by primary key (`submittal_notification_id`,`su_additional_recipient_contact_id`).
	 *
	 * @param string $database
	 * @param int $submittal_notification_id
	 * @param int $su_additional_recipient_contact_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findBySubmittalNotificationIdAndSuAdditionalRecipientContactId($database, $submittal_notification_id, $su_additional_recipient_contact_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	sur.*

FROM `submittal_recipients` sur
WHERE sur.`submittal_notification_id` = ?
AND sur.`su_additional_recipient_contact_id` = ?
";
		$arrValues = array($submittal_notification_id, $su_additional_recipient_contact_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row && !empty($row)) {
			$submittalRecipient = self::instantiateOrm($database, 'SubmittalRecipient', $row);
			/* @var $submittalRecipient SubmittalRecipient */
			return $submittalRecipient;
		} else {
			return false;
		}
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Find by primary key (`submittal_notification_id`,`su_additional_recipient_contact_id`) Extended.
	 *
	 * @param string $database
	 * @param int $submittal_notification_id
	 * @param int $su_additional_recipient_contact_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findBySubmittalNotificationIdAndSuAdditionalRecipientContactIdExtended($database, $submittal_notification_id, $su_additional_recipient_contact_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	sur_fk_sun.`id` AS 'sur_fk_sun__submittal_notification_id',
	sur_fk_sun.`submittal_id` AS 'sur_fk_sun__submittal_id',
	sur_fk_sun.`submittal_notification_timestamp` AS 'sur_fk_sun__submittal_notification_timestamp',

	sur_fk_c.`id` AS 'sur_fk_c__contact_id',
	sur_fk_c.`user_company_id` AS 'sur_fk_c__user_company_id',
	sur_fk_c.`user_id` AS 'sur_fk_c__user_id',
	sur_fk_c.`contact_company_id` AS 'sur_fk_c__contact_company_id',
	sur_fk_c.`email` AS 'sur_fk_c__email',
	sur_fk_c.`name_prefix` AS 'sur_fk_c__name_prefix',
	sur_fk_c.`first_name` AS 'sur_fk_c__first_name',
	sur_fk_c.`additional_name` AS 'sur_fk_c__additional_name',
	sur_fk_c.`middle_name` AS 'sur_fk_c__middle_name',
	sur_fk_c.`last_name` AS 'sur_fk_c__last_name',
	sur_fk_c.`name_suffix` AS 'sur_fk_c__name_suffix',
	sur_fk_c.`title` AS 'sur_fk_c__title',
	sur_fk_c.`vendor_flag` AS 'sur_fk_c__vendor_flag',

	sur_fk_c_mobile_cpn.`id` AS 'sur_fk_c_mobile_cpn__contact_phone_number_id',
	sur_fk_c_mobile_cpn.`contact_id` AS 'sur_fk_c_mobile_cpn__contact_id',
	sur_fk_c_mobile_cpn.`phone_number_type_id` AS 'sur_fk_c_mobile_cpn__phone_number_type_id',
	sur_fk_c_mobile_cpn.`country_code` AS 'sur_fk_c_mobile_cpn__country_code',
	sur_fk_c_mobile_cpn.`area_code` AS 'sur_fk_c_mobile_cpn__area_code',
	sur_fk_c_mobile_cpn.`prefix` AS 'sur_fk_c_mobile_cpn__prefix',
	sur_fk_c_mobile_cpn.`number` AS 'sur_fk_c_mobile_cpn__number',
	sur_fk_c_mobile_cpn.`extension` AS 'sur_fk_c_mobile_cpn__extension',
	sur_fk_c_mobile_cpn.`itu` AS 'sur_fk_c_mobile_cpn__itu',

	sur.*

FROM `submittal_recipients` sur
	INNER JOIN `submittal_notifications` sur_fk_sun ON sur.`submittal_notification_id` = sur_fk_sun.`id`
	INNER JOIN `contacts` sur_fk_c ON sur.`su_additional_recipient_contact_id` = sur_fk_c.`id`
	LEFT OUTER JOIN `contact_phone_numbers` sur_fk_c_mobile_cpn ON sur.`su_additional_recipient_contact_mobile_phone_number_id` = sur_fk_c_mobile_cpn.`id`
WHERE sur.`submittal_notification_id` = ?
AND sur.`su_additional_recipient_contact_id` = ?
";
		$arrValues = array($submittal_notification_id, $su_additional_recipient_contact_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row && !empty($row)) {
			$submittalRecipient = self::instantiateOrm($database, 'SubmittalRecipient', $row);
			/* @var $submittalRecipient SubmittalRecipient */
			$submittalRecipient->convertPropertiesToData();

			if (isset($row['submittal_notification_id'])) {
				$submittal_notification_id = $row['submittal_notification_id'];
				$row['sur_fk_sun__id'] = $submittal_notification_id;
				$submittalNotification = self::instantiateOrm($database, 'SubmittalNotification', $row, null, $submittal_notification_id, 'sur_fk_sun__');
				/* @var $submittalNotification SubmittalNotification */
				$submittalNotification->convertPropertiesToData();
			} else {
				$submittalNotification = false;
			}
			$submittalRecipient->setSubmittalNotification($submittalNotification);

			if (isset($row['su_additional_recipient_contact_id'])) {
				$su_additional_recipient_contact_id = $row['su_additional_recipient_contact_id'];
				$row['sur_fk_c__id'] = $su_additional_recipient_contact_id;
				$suAdditionalRecipientContact = self::instantiateOrm($database, 'Contact', $row, null, $su_additional_recipient_contact_id, 'sur_fk_c__');
				/* @var $suAdditionalRecipientContact Contact */
				$suAdditionalRecipientContact->convertPropertiesToData();
			} else {
				$suAdditionalRecipientContact = false;
			}
			$submittalRecipient->setSuAdditionalRecipientContact($suAdditionalRecipientContact);

			if (isset($row['su_additional_recipient_contact_mobile_phone_number_id'])) {
				$su_additional_recipient_contact_mobile_phone_number_id = $row['su_additional_recipient_contact_mobile_phone_number_id'];
				$row['sur_fk_c_mobile_cpn__id'] = $su_additional_recipient_contact_mobile_phone_number_id;
				$suAdditionalRecipientContactMobilePhoneNumber = self::instantiateOrm($database, 'ContactPhoneNumber', $row, null, $su_additional_recipient_contact_mobile_phone_number_id, 'sur_fk_c_mobile_cpn__');
				/* @var $suAdditionalRecipientContactMobilePhoneNumber ContactPhoneNumber */
				$suAdditionalRecipientContactMobilePhoneNumber->convertPropertiesToData();
			} else {
				$suAdditionalRecipientContactMobilePhoneNumber = false;
			}
			$submittalRecipient->setSuAdditionalRecipientContactMobilePhoneNumber($suAdditionalRecipientContactMobilePhoneNumber);

			return $submittalRecipient;
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
	 * @param array $arrSubmittalNotificationIdAndSuAdditionalRecipientContactIdList
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubmittalRecipientsByArrSubmittalNotificationIdAndSuAdditionalRecipientContactIdList($database, $arrSubmittalNotificationIdAndSuAdditionalRecipientContactIdList, Input $options=null)
	{
		if (empty($arrSubmittalNotificationIdAndSuAdditionalRecipientContactIdList)) {
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
		// ORDER BY `submittal_notification_id` ASC, `su_additional_recipient_contact_id` ASC, `su_additional_recipient_contact_mobile_phone_number_id` ASC, `smtp_recipient_header_type` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubmittalRecipient = new SubmittalRecipient($database);
			$sqlOrderByColumns = $tmpSubmittalRecipient->constructSqlOrderByColumns($arrOrderByAttributes);

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
		foreach ($arrSubmittalNotificationIdAndSuAdditionalRecipientContactIdList as $k => $arrTmp) {
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
		if (count($arrSubmittalNotificationIdAndSuAdditionalRecipientContactIdList) > 1) {
			$sqlWhere = join($arrSqlWhere, ' OR ');
			$sqlWhere = "WHERE ($sqlWhere)";
		} else {
			$sqlWhere = "WHERE $tmpInnerAnd";
		}

		$query =
"
SELECT

	sur.*

FROM `submittal_recipients` sur
{$sqlWhere}{$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubmittalRecipientsByArrSubmittalNotificationIdAndSuAdditionalRecipientContactIdList = array();
		while ($row = $db->fetch()) {
			$submittalRecipient = self::instantiateOrm($database, 'SubmittalRecipient', $row);
			/* @var $submittalRecipient SubmittalRecipient */
			$arrSubmittalRecipientsByArrSubmittalNotificationIdAndSuAdditionalRecipientContactIdList[] = $submittalRecipient;
		}

		$db->free_result();

		return $arrSubmittalRecipientsByArrSubmittalNotificationIdAndSuAdditionalRecipientContactIdList;
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `submittal_recipients_fk_sun` foreign key (`submittal_notification_id`) references `submittal_notifications` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $submittal_notification_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubmittalRecipientsBySubmittalNotificationId($database, $submittal_notification_id, Input $options=null)
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
			self::$_arrSubmittalRecipientsBySubmittalNotificationId = null;
		}

		$arrSubmittalRecipientsBySubmittalNotificationId = self::$_arrSubmittalRecipientsBySubmittalNotificationId;
		if (isset($arrSubmittalRecipientsBySubmittalNotificationId) && !empty($arrSubmittalRecipientsBySubmittalNotificationId)) {
			return $arrSubmittalRecipientsBySubmittalNotificationId;
		}

		$submittal_notification_id = (int) $submittal_notification_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `submittal_notification_id` ASC, `su_additional_recipient_contact_id` ASC, `su_additional_recipient_contact_mobile_phone_number_id` ASC, `smtp_recipient_header_type` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubmittalRecipient = new SubmittalRecipient($database);
			$sqlOrderByColumns = $tmpSubmittalRecipient->constructSqlOrderByColumns($arrOrderByAttributes);

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

	sur_fk_sun.`id` AS 'sur_fk_sun__submittal_notification_id',
	sur_fk_sun.`submittal_id` AS 'sur_fk_sun__submittal_id',
	sur_fk_sun.`submittal_notification_timestamp` AS 'sur_fk_sun__submittal_notification_timestamp',

	sur_fk_c.`id` AS 'sur_fk_c__contact_id',
	sur_fk_c.`user_company_id` AS 'sur_fk_c__user_company_id',
	sur_fk_c.`user_id` AS 'sur_fk_c__user_id',
	sur_fk_c.`contact_company_id` AS 'sur_fk_c__contact_company_id',
	sur_fk_c.`email` AS 'sur_fk_c__email',
	sur_fk_c.`name_prefix` AS 'sur_fk_c__name_prefix',
	sur_fk_c.`first_name` AS 'sur_fk_c__first_name',
	sur_fk_c.`additional_name` AS 'sur_fk_c__additional_name',
	sur_fk_c.`middle_name` AS 'sur_fk_c__middle_name',
	sur_fk_c.`last_name` AS 'sur_fk_c__last_name',
	sur_fk_c.`name_suffix` AS 'sur_fk_c__name_suffix',
	sur_fk_c.`title` AS 'sur_fk_c__title',
	sur_fk_c.`vendor_flag` AS 'sur_fk_c__vendor_flag',

	sur_fk_c_mobile_cpn.`id` AS 'sur_fk_c_mobile_cpn__contact_phone_number_id',
	sur_fk_c_mobile_cpn.`contact_id` AS 'sur_fk_c_mobile_cpn__contact_id',
	sur_fk_c_mobile_cpn.`phone_number_type_id` AS 'sur_fk_c_mobile_cpn__phone_number_type_id',
	sur_fk_c_mobile_cpn.`country_code` AS 'sur_fk_c_mobile_cpn__country_code',
	sur_fk_c_mobile_cpn.`area_code` AS 'sur_fk_c_mobile_cpn__area_code',
	sur_fk_c_mobile_cpn.`prefix` AS 'sur_fk_c_mobile_cpn__prefix',
	sur_fk_c_mobile_cpn.`number` AS 'sur_fk_c_mobile_cpn__number',
	sur_fk_c_mobile_cpn.`extension` AS 'sur_fk_c_mobile_cpn__extension',
	sur_fk_c_mobile_cpn.`itu` AS 'sur_fk_c_mobile_cpn__itu',

		sur.*

FROM `submittal_recipients` sur
	INNER JOIN `submittal_notifications` sur_fk_sun ON sur.`submittal_notification_id` = sur_fk_sun.`id`
	INNER JOIN `contacts` sur_fk_c ON sur.`su_additional_recipient_contact_id` = sur_fk_c.`id`
	LEFT OUTER JOIN `contact_phone_numbers` sur_fk_c_mobile_cpn ON sur.`su_additional_recipient_contact_mobile_phone_number_id` = sur_fk_c_mobile_cpn.`id`
WHERE sur.`submittal_notification_id` = ? AND sur_fk_c.`is_archive` = 'N' {$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `submittal_notification_id` ASC, `su_additional_recipient_contact_id` ASC, `su_additional_recipient_contact_mobile_phone_number_id` ASC, `smtp_recipient_header_type` ASC
		$arrValues = array($submittal_notification_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubmittalRecipientsBySubmittalNotificationId = array();
		while ($row = $db->fetch()) {
			$submittalRecipient = self::instantiateOrm($database, 'SubmittalRecipient', $row);
			/* @var $submittalRecipient SubmittalRecipient */
			$submittalRecipient->convertPropertiesToData();

			if (isset($row['submittal_notification_id'])) {
				$submittal_notification_id = $row['submittal_notification_id'];
				$row['sur_fk_sun__id'] = $submittal_notification_id;
				$submittalNotification = self::instantiateOrm($database, 'SubmittalNotification', $row, null, $submittal_notification_id, 'sur_fk_sun__');
				/* @var $submittalNotification SubmittalNotification */
				$submittalNotification->convertPropertiesToData();
			} else {
				$submittalNotification = false;
			}
			$submittalRecipient->setSubmittalNotification($submittalNotification);

			if (isset($row['su_additional_recipient_contact_id'])) {
				$su_additional_recipient_contact_id = $row['su_additional_recipient_contact_id'];
				$row['sur_fk_c__id'] = $su_additional_recipient_contact_id;
				$suAdditionalRecipientContact = self::instantiateOrm($database, 'Contact', $row, null, $su_additional_recipient_contact_id, 'sur_fk_c__');
				/* @var $suAdditionalRecipientContact Contact */
				$suAdditionalRecipientContact->convertPropertiesToData();
			} else {
				$suAdditionalRecipientContact = false;
			}
			$submittalRecipient->setSuAdditionalRecipientContact($suAdditionalRecipientContact);

			if (isset($row['su_additional_recipient_contact_mobile_phone_number_id'])) {
				$su_additional_recipient_contact_mobile_phone_number_id = $row['su_additional_recipient_contact_mobile_phone_number_id'];
				$row['sur_fk_c_mobile_cpn__id'] = $su_additional_recipient_contact_mobile_phone_number_id;
				$suAdditionalRecipientContactMobilePhoneNumber = self::instantiateOrm($database, 'ContactPhoneNumber', $row, null, $su_additional_recipient_contact_mobile_phone_number_id, 'sur_fk_c_mobile_cpn__');
				/* @var $suAdditionalRecipientContactMobilePhoneNumber ContactPhoneNumber */
				$suAdditionalRecipientContactMobilePhoneNumber->convertPropertiesToData();
			} else {
				$suAdditionalRecipientContactMobilePhoneNumber = false;
			}
			$submittalRecipient->setSuAdditionalRecipientContactMobilePhoneNumber($suAdditionalRecipientContactMobilePhoneNumber);

			$arrSubmittalRecipientsBySubmittalNotificationId[] = $submittalRecipient;
		}

		$db->free_result();

		self::$_arrSubmittalRecipientsBySubmittalNotificationId = $arrSubmittalRecipientsBySubmittalNotificationId;

		return $arrSubmittalRecipientsBySubmittalNotificationId;
	}

	/**
	 * Load by constraint `submittal_recipients_fk_c` foreign key (`su_additional_recipient_contact_id`) references `contacts` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $su_additional_recipient_contact_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubmittalRecipientsBySuAdditionalRecipientContactId($database, $su_additional_recipient_contact_id, Input $options=null)
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
			self::$_arrSubmittalRecipientsBySuAdditionalRecipientContactId = null;
		}

		$arrSubmittalRecipientsBySuAdditionalRecipientContactId = self::$_arrSubmittalRecipientsBySuAdditionalRecipientContactId;
		if (isset($arrSubmittalRecipientsBySuAdditionalRecipientContactId) && !empty($arrSubmittalRecipientsBySuAdditionalRecipientContactId)) {
			return $arrSubmittalRecipientsBySuAdditionalRecipientContactId;
		}

		$su_additional_recipient_contact_id = (int) $su_additional_recipient_contact_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `submittal_notification_id` ASC, `su_additional_recipient_contact_id` ASC, `su_additional_recipient_contact_mobile_phone_number_id` ASC, `smtp_recipient_header_type` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubmittalRecipient = new SubmittalRecipient($database);
			$sqlOrderByColumns = $tmpSubmittalRecipient->constructSqlOrderByColumns($arrOrderByAttributes);

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
	sur.*

FROM `submittal_recipients` sur
WHERE sur.`su_additional_recipient_contact_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `submittal_notification_id` ASC, `su_additional_recipient_contact_id` ASC, `su_additional_recipient_contact_mobile_phone_number_id` ASC, `smtp_recipient_header_type` ASC
		$arrValues = array($su_additional_recipient_contact_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubmittalRecipientsBySuAdditionalRecipientContactId = array();
		while ($row = $db->fetch()) {
			$submittalRecipient = self::instantiateOrm($database, 'SubmittalRecipient', $row);
			/* @var $submittalRecipient SubmittalRecipient */
			$arrSubmittalRecipientsBySuAdditionalRecipientContactId[] = $submittalRecipient;
		}

		$db->free_result();

		self::$_arrSubmittalRecipientsBySuAdditionalRecipientContactId = $arrSubmittalRecipientsBySuAdditionalRecipientContactId;

		return $arrSubmittalRecipientsBySuAdditionalRecipientContactId;
	}

	/**
	 * Load by constraint `submittal_recipients_fk_c_mobile_cpn` foreign key (`su_additional_recipient_contact_mobile_phone_number_id`) references `contact_phone_numbers` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $su_additional_recipient_contact_mobile_phone_number_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubmittalRecipientsBySuAdditionalRecipientContactMobilePhoneNumberId($database, $su_additional_recipient_contact_mobile_phone_number_id, Input $options=null)
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
			self::$_arrSubmittalRecipientsBySuAdditionalRecipientContactMobilePhoneNumberId = null;
		}

		$arrSubmittalRecipientsBySuAdditionalRecipientContactMobilePhoneNumberId = self::$_arrSubmittalRecipientsBySuAdditionalRecipientContactMobilePhoneNumberId;
		if (isset($arrSubmittalRecipientsBySuAdditionalRecipientContactMobilePhoneNumberId) && !empty($arrSubmittalRecipientsBySuAdditionalRecipientContactMobilePhoneNumberId)) {
			return $arrSubmittalRecipientsBySuAdditionalRecipientContactMobilePhoneNumberId;
		}

		$su_additional_recipient_contact_mobile_phone_number_id = (int) $su_additional_recipient_contact_mobile_phone_number_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `submittal_notification_id` ASC, `su_additional_recipient_contact_id` ASC, `su_additional_recipient_contact_mobile_phone_number_id` ASC, `smtp_recipient_header_type` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubmittalRecipient = new SubmittalRecipient($database);
			$sqlOrderByColumns = $tmpSubmittalRecipient->constructSqlOrderByColumns($arrOrderByAttributes);

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
	sur.*

FROM `submittal_recipients` sur
WHERE sur.`su_additional_recipient_contact_mobile_phone_number_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `submittal_notification_id` ASC, `su_additional_recipient_contact_id` ASC, `su_additional_recipient_contact_mobile_phone_number_id` ASC, `smtp_recipient_header_type` ASC
		$arrValues = array($su_additional_recipient_contact_mobile_phone_number_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubmittalRecipientsBySuAdditionalRecipientContactMobilePhoneNumberId = array();
		while ($row = $db->fetch()) {
			$submittalRecipient = self::instantiateOrm($database, 'SubmittalRecipient', $row);
			/* @var $submittalRecipient SubmittalRecipient */
			$arrSubmittalRecipientsBySuAdditionalRecipientContactMobilePhoneNumberId[] = $submittalRecipient;
		}

		$db->free_result();

		self::$_arrSubmittalRecipientsBySuAdditionalRecipientContactMobilePhoneNumberId = $arrSubmittalRecipientsBySuAdditionalRecipientContactMobilePhoneNumberId;

		return $arrSubmittalRecipientsBySuAdditionalRecipientContactMobilePhoneNumberId;
	}

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all submittal_recipients records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllSubmittalRecipients($database, Input $options=null)
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
			self::$_arrAllSubmittalRecipients = null;
		}

		$arrAllSubmittalRecipients = self::$_arrAllSubmittalRecipients;
		if (isset($arrAllSubmittalRecipients) && !empty($arrAllSubmittalRecipients)) {
			return $arrAllSubmittalRecipients;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `submittal_notification_id` ASC, `su_additional_recipient_contact_id` ASC, `su_additional_recipient_contact_mobile_phone_number_id` ASC, `smtp_recipient_header_type` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubmittalRecipient = new SubmittalRecipient($database);
			$sqlOrderByColumns = $tmpSubmittalRecipient->constructSqlOrderByColumns($arrOrderByAttributes);

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
	sur.*

FROM `submittal_recipients` sur{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `submittal_notification_id` ASC, `su_additional_recipient_contact_id` ASC, `su_additional_recipient_contact_mobile_phone_number_id` ASC, `smtp_recipient_header_type` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllSubmittalRecipients = array();
		while ($row = $db->fetch()) {
			$submittalRecipient = self::instantiateOrm($database, 'SubmittalRecipient', $row);
			/* @var $submittalRecipient SubmittalRecipient */
			$arrAllSubmittalRecipients[] = $submittalRecipient;
		}

		$db->free_result();

		self::$_arrAllSubmittalRecipients = $arrAllSubmittalRecipients;

		return $arrAllSubmittalRecipients;
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
INTO `submittal_recipients`
(`submittal_notification_id`, `su_additional_recipient_contact_id`, `su_additional_recipient_contact_mobile_phone_number_id`, `smtp_recipient_header_type`,`su_additional_recipient_creator_contact_id`)
VALUES (?, ?, ?, ?, ?)
ON DUPLICATE KEY UPDATE `su_additional_recipient_contact_mobile_phone_number_id` = ?, `smtp_recipient_header_type` = ?
";
		$arrValues = array($this->submittal_notification_id, $this->su_additional_recipient_contact_id, $this->su_additional_recipient_contact_mobile_phone_number_id, $this->smtp_recipient_header_type,$this->su_additional_recipient_creator_contact_id, $this->su_additional_recipient_contact_mobile_phone_number_id, $this->smtp_recipient_header_type);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$submittal_recipient_id = $db->insertId;
		$db->free_result();

		return $submittal_recipient_id;
	}

	// Save: insert ignore

	public static function getAdditionalRecipientCC($database, $submittal_notification_id, $smtp_type){
// $database, $request_for_information_notification_id,'To'

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */
		$query = "SELECT * FROM submittal_recipients WHERE submittal_notification_id = ? AND smtp_recipient_header_type = ?";
       

		$arrValues = array($submittal_notification_id, $smtp_type);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
 		$contact_row = $db->fetch();
 		$additional_recipient_contact_id = 0;
 		if(!empty($contact_row['su_additional_recipient_contact_id'])){
 			$additional_recipient_contact_id = $contact_row['su_additional_recipient_contact_id'];
 		}
 		return $additional_recipient_contact_id;

	}

	// check whether the submittal To is captured in the Submittal recipient table if not the function will capture the data
	public static function checkandUpdateSubmittalToField($database,$submittal_id,$notification_id,$contact_id)
	{
		// To get the recipient from submittal table
		$db = DBI::getInstance($database);
		$query = "SELECT `su_recipient_contact_id` FROM submittals WHERE id = ? ";
       	$arrValues = array($submittal_id);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
 		$row = $db->fetch();
 		$su_recipient_contact_id = $row['su_recipient_contact_id'];
 		$db->free_result();



		$db = DBI::getInstance($database);
		$query = "SELECT * FROM submittal_recipients WHERE submittal_notification_id = ? AND smtp_recipient_header_type = ? and su_additional_recipient_contact_id = ?";
       	$arrValues = array($notification_id, 'To',$su_recipient_contact_id);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
 		$contact_row = $db->fetch();
 		$db->free_result();
 		if(empty($contact_row))
 		{
 				$db = DBI::getInstance($database);
				$query = "INSERT INTO `submittal_recipients`(`submittal_notification_id`, `su_additional_recipient_contact_id`,  `smtp_recipient_header_type`,`su_additional_recipient_creator_contact_id`, `is_to_history`) VALUES (?,?,?,?,?)";
				$arrValues = array($notification_id, $su_recipient_contact_id,'To',$contact_id,'1');
				$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
				$db->free_result();
 		}
 		$db->free_result();

 		return $su_recipient_contact_id;
	}

	public static function getAdditionalRecipient($database, $submittal_id, $smtp_type = ''){

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */
		if(!empty($smtp_type)){
			$subQuery = " AND subr.`smtp_recipient_header_type` = ?";
			$arrValues = array($submittal_id, $smtp_type);
		}else{
			$subQuery = "";
			$arrValues = array($submittal_id);
		}
		$query = "SELECT subr.* FROM submittal_recipients subr INNER JOIN submittal_notifications as subn ON subr.`submittal_notification_id` = subn.`id` WHERE subn.`submittal_id` = ? ".$subQuery." ORDER BY subr.`su_additional_recipient_created_date` ASC";
       

		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
 		$recipient_arr = array();
 		while($contact_row = $db->fetch()){
 			$recipient_arr[] = $contact_row;
 		}
 		return $recipient_arr;

 	}
 	public static function getRecipientBasedOnHeader($database,$notification_id,$type)
 	{
 		$db = DBI::getInstance($database);
 		$query = "SELECT `su_additional_recipient_contact_id`,`smtp_recipient_header_type` FROM `submittal_recipients` WHERE `submittal_notification_id` = ? and `smtp_recipient_header_type` = ?";
 		$arrvalues = array($notification_id,$type);
 		$db->execute($query, $arrvalues, MYSQLI_USE_RESULT);
 		$dataarray = array();
 		while($row = $db->fetch())
 		{
 			$dataarray[$row['su_additional_recipient_contact_id']]  = $row['su_additional_recipient_contact_id'];
 		}
 		$db->free_result();
 			return $dataarray;

 	}

 	// To get the recipients and its company data based on the header
	public static function getRecipientCompanyData($database,$notification_id,$type)
 	{
 		$db = DBI::getInstance($database);
 		$query = "SELECT 
	`sunot`.id AS su_notification_id, 
	`sunot`.`submittal_id` AS su_id,
	`con`.id AS contact_id,	
	`con`.contact_company_id AS contact_company_id,	
	`con_co`.company AS comany_name,
	IF(IFNULL(CONCAT(`con`.first_name,' ',`con`.last_name),'')!='',
	IF(`con`.is_archive = 'Y', CONCAT(`con`.first_name,' ',`con`.last_name,' (Archived)'), CONCAT(`con`.first_name,' ',`con`.last_name)),
	IF(`con`.is_archive = 'Y', CONCAT(`con`.email,' (Archived)'), `con`.email)) as name,
	IF(`con`.is_archive = 'Y', CONCAT(`con`.email,' (Archived)'), `con`.email) as email
	FROM `submittal_notifications` sunot 
	INNER JOIN submittal_recipients sur ON sur.`submittal_notification_id` = sunot.`id` 
	INNER JOIN `contacts` con ON `sur`.su_additional_recipient_contact_id = `con`.id 
	INNER JOIN `contact_companies` con_co ON `con`.contact_company_id  = `con_co`.id
		WHERE `sunot`.`submittal_id` = ? AND `sur`.`smtp_recipient_header_type` = ? ";
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
 		$query = "DELETE FROM `submittal_recipients` WHERE submittal_notification_id=? and smtp_recipient_header_type=?";
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
	public static function getListOfToRecipient($database, $submittal_id, $type){		

		$db = DBI::getInstance($database);
		$submittal_id = (int) $submittal_id;

		$query =
		"SELECT 
			`subnot`.id AS submittal_notification_id, 
			`subnot`.`submittal_id` AS submittal_id, 
			GROUP_CONCAT(subrl.`su_additional_recipient_contact_id`) AS contact_id,
			GROUP_CONCAT(IF(IFNULL(CONCAT(`con`.`first_name`,' ',`con`.`last_name`),'')!='',
			IF(`con`.`is_archive` = 'Y', CONCAT(`con`.`first_name`,' ',`con`.`last_name`,' (Archived)'), CONCAT(`con`.`first_name`,' ',`con`.`last_name`)),
			IF(`con`.`is_archive` = 'Y', CONCAT(`con`.email,' (Archived)'), `con`.email)) SEPARATOR ', ') AS to_email
			FROM `submittal_notifications` subnot 
			INNER JOIN submittal_recipients subrl ON subrl.`submittal_notification_id` = subnot.`id` 
			INNER JOIN `contacts` con ON `subrl`.su_additional_recipient_contact_id = `con`.id 
			WHERE `subnot`.`submittal_id` = ? AND `subrl`.`smtp_recipient_header_type` = ?
		";

		$arrValues = array($submittal_id,$type);
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
 		$query = "SELECT `history` FROM `submittal_to_recipients_log` WHERE `submittal_notification_id` = $notification_id ORDER BY `id` DESC LIMIT 1";
 		$db->execute($query);
 		$row = $db->fetch();
 		$db->free_result();
 		$history = 0;
 		if ($row) {
 			$history = $row['history']+1;
 		}

 		if (count($extra_id) > 0) {
	 		foreach ($extra_id as $to_id) { 		
		 		$query2 = "INSERT INTO `submittal_to_recipients_log`(`submittal_notification_id`, `su_to_recipient_contact_id`,`su_to_recipient_creator_contact_id`, `status`,`history`) VALUES (?,?,?,?,?)";
				$arrValues2 = array($notification_id, $to_id,$creator_contact_id,'1',$history);
				$db->execute($query2, $arrValues2, MYSQLI_USE_RESULT);
		 		$db->free_result();
	 		}
	 	}

	 	if (count($deleted_id) > 0) {
	 		foreach ($deleted_id as $to_id) { 		
		 		$query3 = "INSERT INTO `submittal_to_recipients_log`(`submittal_notification_id`, `su_to_recipient_contact_id`,`su_to_recipient_creator_contact_id`, `status`,`history`) VALUES (?,?,?,?,?)";
				$arrValues3 = array($notification_id, $to_id,$creator_contact_id,'0',$history);
				$db->execute($query3, $arrValues3, MYSQLI_USE_RESULT);
		 		$db->free_result();
	 		}
	 	}

 	}
	
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

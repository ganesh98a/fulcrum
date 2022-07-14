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
 * ChangeOrderRecipient.
 *
 * @category   Framework
 * @package    ChangeOrderRecipient
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class ChangeOrderRecipient extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'ChangeOrderRecipient';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'change_order_recipients';

	/**
	 * Singular version of the table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_tableNameSingular = 'change_order_recipient';

	/**
	 * primary key (`change_order_notification_id`,`co_additional_recipient_contact_id`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrPrimaryKey = array(
		'change_order_notification_id' => 'int',
		'co_additional_recipient_contact_id' => 'int'
	);

	/**
	 * No Unique Indexes, Just a Primary Key
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_change_order_recipient_via_primary_key' => array(
			'change_order_notification_id' => 'int',
			'co_additional_recipient_contact_id' => 'int'
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
		'change_order_notification_id' => 'change_order_notification_id',
		'co_additional_recipient_contact_id' => 'co_additional_recipient_contact_id',

		'co_additional_recipient_contact_mobile_phone_number_id' => 'co_additional_recipient_contact_mobile_phone_number_id',

		'smtp_recipient_header_type' => 'smtp_recipient_header_type'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $change_order_notification_id;
	public $co_additional_recipient_contact_id;

	public $co_additional_recipient_contact_mobile_phone_number_id;

	public $smtp_recipient_header_type;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties

	// HTML ENTITY ENCODED NL2BR ORM string properties

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)
	protected static $_arrChangeOrderRecipientsByChangeOrderNotificationId;
	protected static $_arrChangeOrderRecipientsByCoAdditionalRecipientContactId;
	protected static $_arrChangeOrderRecipientsByCoAdditionalRecipientContactMobilePhoneNumberId;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllChangeOrderRecipients;

	// Foreign Key Objects
	private $_changeOrderNotification;
	private $_coAdditionalRecipientContact;
	private $_coAdditionalRecipientContactMobilePhoneNumber;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='change_order_recipients')
	{
		parent::__construct($table);
		$this->setDatabase($database);
	}

	// Foreign Key Object Accessor Methods
	public function getChangeOrderNotification()
	{
		if (isset($this->_changeOrderNotification)) {
			return $this->_changeOrderNotification;
		} else {
			return null;
		}
	}

	public function setChangeOrderNotification($changeOrderNotification)
	{
		$this->_changeOrderNotification = $changeOrderNotification;
	}

	public function getCoAdditionalRecipientContact()
	{
		if (isset($this->_coAdditionalRecipientContact)) {
			return $this->_coAdditionalRecipientContact;
		} else {
			return null;
		}
	}

	public function setCoAdditionalRecipientContact($coAdditionalRecipientContact)
	{
		$this->_coAdditionalRecipientContact = $coAdditionalRecipientContact;
	}

	public function getCoAdditionalRecipientContactMobilePhoneNumber()
	{
		if (isset($this->_coAdditionalRecipientContactMobilePhoneNumber)) {
			return $this->_coAdditionalRecipientContactMobilePhoneNumber;
		} else {
			return null;
		}
	}

	public function setCoAdditionalRecipientContactMobilePhoneNumber($coAdditionalRecipientContactMobilePhoneNumber)
	{
		$this->_coAdditionalRecipientContactMobilePhoneNumber = $coAdditionalRecipientContactMobilePhoneNumber;
	}

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)
	public static function getArrChangeOrderRecipientsByChangeOrderNotificationId()
	{
		if (isset(self::$_arrChangeOrderRecipientsByChangeOrderNotificationId)) {
			return self::$_arrChangeOrderRecipientsByChangeOrderNotificationId;
		} else {
			return null;
		}
	}

	public static function setArrChangeOrderRecipientsByChangeOrderNotificationId($arrChangeOrderRecipientsByChangeOrderNotificationId)
	{
		self::$_arrChangeOrderRecipientsByChangeOrderNotificationId = $arrChangeOrderRecipientsByChangeOrderNotificationId;
	}

	public static function getArrChangeOrderRecipientsByCoAdditionalRecipientContactId()
	{
		if (isset(self::$_arrChangeOrderRecipientsByCoAdditionalRecipientContactId)) {
			return self::$_arrChangeOrderRecipientsByCoAdditionalRecipientContactId;
		} else {
			return null;
		}
	}

	public static function setArrChangeOrderRecipientsByCoAdditionalRecipientContactId($arrChangeOrderRecipientsByCoAdditionalRecipientContactId)
	{
		self::$_arrChangeOrderRecipientsByCoAdditionalRecipientContactId = $arrChangeOrderRecipientsByCoAdditionalRecipientContactId;
	}

	public static function getArrChangeOrderRecipientsByCoAdditionalRecipientContactMobilePhoneNumberId()
	{
		if (isset(self::$_arrChangeOrderRecipientsByCoAdditionalRecipientContactMobilePhoneNumberId)) {
			return self::$_arrChangeOrderRecipientsByCoAdditionalRecipientContactMobilePhoneNumberId;
		} else {
			return null;
		}
	}

	public static function setArrChangeOrderRecipientsByCoAdditionalRecipientContactMobilePhoneNumberId($arrChangeOrderRecipientsByCoAdditionalRecipientContactMobilePhoneNumberId)
	{
		self::$_arrChangeOrderRecipientsByCoAdditionalRecipientContactMobilePhoneNumberId = $arrChangeOrderRecipientsByCoAdditionalRecipientContactMobilePhoneNumberId;
	}

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllChangeOrderRecipients()
	{
		if (isset(self::$_arrAllChangeOrderRecipients)) {
			return self::$_arrAllChangeOrderRecipients;
		} else {
			return null;
		}
	}

	public static function setArrAllChangeOrderRecipients($arrAllChangeOrderRecipients)
	{
		self::$_arrAllChangeOrderRecipients = $arrAllChangeOrderRecipients;
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
	 * Find by primary key (`change_order_notification_id`,`co_additional_recipient_contact_id`).
	 *
	 * @param string $database
	 * @param int $change_order_notification_id
	 * @param int $co_additional_recipient_contact_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findByChangeOrderNotificationIdAndCoAdditionalRecipientContactId($database, $change_order_notification_id, $co_additional_recipient_contact_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	corecipients.*

FROM `change_order_recipients` corecipients
WHERE corecipients.`change_order_notification_id` = ?
AND corecipients.`co_additional_recipient_contact_id` = ?
";
		$arrValues = array($change_order_notification_id, $co_additional_recipient_contact_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row && !empty($row)) {
			$changeOrderRecipient = self::instantiateOrm($database, 'ChangeOrderRecipient', $row);
			/* @var $changeOrderRecipient ChangeOrderRecipient */
			return $changeOrderRecipient;
		} else {
			return false;
		}
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Find by primary key (`change_order_notification_id`,`co_additional_recipient_contact_id`) Extended.
	 *
	 * @param string $database
	 * @param int $change_order_notification_id
	 * @param int $co_additional_recipient_contact_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findByChangeOrderNotificationIdAndCoAdditionalRecipientContactIdExtended($database, $change_order_notification_id, $co_additional_recipient_contact_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	corecipients_fk_con.`id` AS 'corecipients_fk_con__change_order_notification_id',
	corecipients_fk_con.`change_order_id` AS 'corecipients_fk_con__change_order_id',
	corecipients_fk_con.`change_order_notification_timestamp` AS 'corecipients_fk_con__change_order_notification_timestamp',

	corecipients_fk_c.`id` AS 'corecipients_fk_c__contact_id',
	corecipients_fk_c.`user_company_id` AS 'corecipients_fk_c__user_company_id',
	corecipients_fk_c.`user_id` AS 'corecipients_fk_c__user_id',
	corecipients_fk_c.`contact_company_id` AS 'corecipients_fk_c__contact_company_id',
	corecipients_fk_c.`email` AS 'corecipients_fk_c__email',
	corecipients_fk_c.`name_prefix` AS 'corecipients_fk_c__name_prefix',
	corecipients_fk_c.`first_name` AS 'corecipients_fk_c__first_name',
	corecipients_fk_c.`additional_name` AS 'corecipients_fk_c__additional_name',
	corecipients_fk_c.`middle_name` AS 'corecipients_fk_c__middle_name',
	corecipients_fk_c.`last_name` AS 'corecipients_fk_c__last_name',
	corecipients_fk_c.`name_suffix` AS 'corecipients_fk_c__name_suffix',
	corecipients_fk_c.`title` AS 'corecipients_fk_c__title',
	corecipients_fk_c.`vendor_flag` AS 'corecipients_fk_c__vendor_flag',

	corecipients_fk_c_mobile_cpn.`id` AS 'corecipients_fk_c_mobile_cpn__contact_phone_number_id',
	corecipients_fk_c_mobile_cpn.`contact_id` AS 'corecipients_fk_c_mobile_cpn__contact_id',
	corecipients_fk_c_mobile_cpn.`phone_number_type_id` AS 'corecipients_fk_c_mobile_cpn__phone_number_type_id',
	corecipients_fk_c_mobile_cpn.`country_code` AS 'corecipients_fk_c_mobile_cpn__country_code',
	corecipients_fk_c_mobile_cpn.`area_code` AS 'corecipients_fk_c_mobile_cpn__area_code',
	corecipients_fk_c_mobile_cpn.`prefix` AS 'corecipients_fk_c_mobile_cpn__prefix',
	corecipients_fk_c_mobile_cpn.`number` AS 'corecipients_fk_c_mobile_cpn__number',
	corecipients_fk_c_mobile_cpn.`extension` AS 'corecipients_fk_c_mobile_cpn__extension',
	corecipients_fk_c_mobile_cpn.`itu` AS 'corecipients_fk_c_mobile_cpn__itu',

	corecipients.*

FROM `change_order_recipients` corecipients
	INNER JOIN `change_order_notifications` corecipients_fk_con ON corecipients.`change_order_notification_id` = corecipients_fk_con.`id`
	INNER JOIN `contacts` corecipients_fk_c ON corecipients.`co_additional_recipient_contact_id` = corecipients_fk_c.`id`
	LEFT OUTER JOIN `contact_phone_numbers` corecipients_fk_c_mobile_cpn ON corecipients.`co_additional_recipient_contact_mobile_phone_number_id` = corecipients_fk_c_mobile_cpn.`id`
WHERE corecipients.`change_order_notification_id` = ?
AND corecipients.`co_additional_recipient_contact_id` = ?
";
		$arrValues = array($change_order_notification_id, $co_additional_recipient_contact_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row && !empty($row)) {
			$changeOrderRecipient = self::instantiateOrm($database, 'ChangeOrderRecipient', $row);
			/* @var $changeOrderRecipient ChangeOrderRecipient */
			$changeOrderRecipient->convertPropertiesToData();

			if (isset($row['change_order_notification_id'])) {
				$change_order_notification_id = $row['change_order_notification_id'];
				$row['corecipients_fk_con__id'] = $change_order_notification_id;
				$changeOrderNotification = self::instantiateOrm($database, 'ChangeOrderNotification', $row, null, $change_order_notification_id, 'corecipients_fk_con__');
				/* @var $changeOrderNotification ChangeOrderNotification */
				$changeOrderNotification->convertPropertiesToData();
			} else {
				$changeOrderNotification = false;
			}
			$changeOrderRecipient->setChangeOrderNotification($changeOrderNotification);

			if (isset($row['co_additional_recipient_contact_id'])) {
				$co_additional_recipient_contact_id = $row['co_additional_recipient_contact_id'];
				$row['corecipients_fk_c__id'] = $co_additional_recipient_contact_id;
				$coAdditionalRecipientContact = self::instantiateOrm($database, 'Contact', $row, null, $co_additional_recipient_contact_id, 'corecipients_fk_c__');
				/* @var $coAdditionalRecipientContact Contact */
				$coAdditionalRecipientContact->convertPropertiesToData();
			} else {
				$coAdditionalRecipientContact = false;
			}
			$changeOrderRecipient->setCoAdditionalRecipientContact($coAdditionalRecipientContact);

			if (isset($row['co_additional_recipient_contact_mobile_phone_number_id'])) {
				$co_additional_recipient_contact_mobile_phone_number_id = $row['co_additional_recipient_contact_mobile_phone_number_id'];
				$row['corecipients_fk_c_mobile_cpn__id'] = $co_additional_recipient_contact_mobile_phone_number_id;
				$coAdditionalRecipientContactMobilePhoneNumber = self::instantiateOrm($database, 'ContactPhoneNumber', $row, null, $co_additional_recipient_contact_mobile_phone_number_id, 'corecipients_fk_c_mobile_cpn__');
				/* @var $coAdditionalRecipientContactMobilePhoneNumber ContactPhoneNumber */
				$coAdditionalRecipientContactMobilePhoneNumber->convertPropertiesToData();
			} else {
				$coAdditionalRecipientContactMobilePhoneNumber = false;
			}
			$changeOrderRecipient->setCoAdditionalRecipientContactMobilePhoneNumber($coAdditionalRecipientContactMobilePhoneNumber);

			return $changeOrderRecipient;
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
	 * @param array $arrChangeOrderNotificationIdAndCoAdditionalRecipientContactIdList
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadChangeOrderRecipientsByArrChangeOrderNotificationIdAndCoAdditionalRecipientContactIdList($database, $arrChangeOrderNotificationIdAndCoAdditionalRecipientContactIdList, Input $options=null)
	{
		if (empty($arrChangeOrderNotificationIdAndCoAdditionalRecipientContactIdList)) {
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
		// ORDER BY `change_order_notification_id` ASC, `co_additional_recipient_contact_id` ASC, `co_additional_recipient_contact_mobile_phone_number_id` ASC, `smtp_recipient_header_type` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpChangeOrderRecipient = new ChangeOrderRecipient($database);
			$sqlOrderByColumns = $tmpChangeOrderRecipient->constructSqlOrderByColumns($arrOrderByAttributes);

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
		foreach ($arrChangeOrderNotificationIdAndCoAdditionalRecipientContactIdList as $k => $arrTmp) {
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
		if (count($arrChangeOrderNotificationIdAndCoAdditionalRecipientContactIdList) > 1) {
			$sqlWhere = join($arrSqlWhere, ' OR ');
			$sqlWhere = "WHERE ($sqlWhere)";
		} else {
			$sqlWhere = "WHERE $tmpInnerAnd";
		}

		$query =
"
SELECT

	corecipients.*

FROM `change_order_recipients` corecipients
{$sqlWhere}{$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrChangeOrderRecipientsByArrChangeOrderNotificationIdAndCoAdditionalRecipientContactIdList = array();
		while ($row = $db->fetch()) {
			$changeOrderRecipient = self::instantiateOrm($database, 'ChangeOrderRecipient', $row);
			/* @var $changeOrderRecipient ChangeOrderRecipient */
			$arrChangeOrderRecipientsByArrChangeOrderNotificationIdAndCoAdditionalRecipientContactIdList[] = $changeOrderRecipient;
		}

		$db->free_result();

		return $arrChangeOrderRecipientsByArrChangeOrderNotificationIdAndCoAdditionalRecipientContactIdList;
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `change_order_recipients_fk_con` foreign key (`change_order_notification_id`) references `change_order_notifications` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $change_order_notification_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadChangeOrderRecipientsByChangeOrderNotificationId($database, $change_order_notification_id, Input $options=null)
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
			self::$_arrChangeOrderRecipientsByChangeOrderNotificationId = null;
		}

		$arrChangeOrderRecipientsByChangeOrderNotificationId = self::$_arrChangeOrderRecipientsByChangeOrderNotificationId;
		if (isset($arrChangeOrderRecipientsByChangeOrderNotificationId) && !empty($arrChangeOrderRecipientsByChangeOrderNotificationId)) {
			return $arrChangeOrderRecipientsByChangeOrderNotificationId;
		}

		$change_order_notification_id = (int) $change_order_notification_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `change_order_notification_id` ASC, `co_additional_recipient_contact_id` ASC, `co_additional_recipient_contact_mobile_phone_number_id` ASC, `smtp_recipient_header_type` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpChangeOrderRecipient = new ChangeOrderRecipient($database);
			$sqlOrderByColumns = $tmpChangeOrderRecipient->constructSqlOrderByColumns($arrOrderByAttributes);

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
	corecipients.*

FROM `change_order_recipients` corecipients
WHERE corecipients.`change_order_notification_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `change_order_notification_id` ASC, `co_additional_recipient_contact_id` ASC, `co_additional_recipient_contact_mobile_phone_number_id` ASC, `smtp_recipient_header_type` ASC
		$arrValues = array($change_order_notification_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrChangeOrderRecipientsByChangeOrderNotificationId = array();
		while ($row = $db->fetch()) {
			$changeOrderRecipient = self::instantiateOrm($database, 'ChangeOrderRecipient', $row);
			/* @var $changeOrderRecipient ChangeOrderRecipient */
			$arrChangeOrderRecipientsByChangeOrderNotificationId[] = $changeOrderRecipient;
		}

		$db->free_result();

		self::$_arrChangeOrderRecipientsByChangeOrderNotificationId = $arrChangeOrderRecipientsByChangeOrderNotificationId;

		return $arrChangeOrderRecipientsByChangeOrderNotificationId;
	}

	/**
	 * Load by constraint `change_order_recipients_fk_c` foreign key (`co_additional_recipient_contact_id`) references `contacts` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $co_additional_recipient_contact_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadChangeOrderRecipientsByCoAdditionalRecipientContactId($database, $co_additional_recipient_contact_id, Input $options=null)
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
			self::$_arrChangeOrderRecipientsByCoAdditionalRecipientContactId = null;
		}

		$arrChangeOrderRecipientsByCoAdditionalRecipientContactId = self::$_arrChangeOrderRecipientsByCoAdditionalRecipientContactId;
		if (isset($arrChangeOrderRecipientsByCoAdditionalRecipientContactId) && !empty($arrChangeOrderRecipientsByCoAdditionalRecipientContactId)) {
			return $arrChangeOrderRecipientsByCoAdditionalRecipientContactId;
		}

		$co_additional_recipient_contact_id = (int) $co_additional_recipient_contact_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `change_order_notification_id` ASC, `co_additional_recipient_contact_id` ASC, `co_additional_recipient_contact_mobile_phone_number_id` ASC, `smtp_recipient_header_type` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpChangeOrderRecipient = new ChangeOrderRecipient($database);
			$sqlOrderByColumns = $tmpChangeOrderRecipient->constructSqlOrderByColumns($arrOrderByAttributes);

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
	corecipients.*

FROM `change_order_recipients` corecipients
WHERE corecipients.`co_additional_recipient_contact_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `change_order_notification_id` ASC, `co_additional_recipient_contact_id` ASC, `co_additional_recipient_contact_mobile_phone_number_id` ASC, `smtp_recipient_header_type` ASC
		$arrValues = array($co_additional_recipient_contact_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrChangeOrderRecipientsByCoAdditionalRecipientContactId = array();
		while ($row = $db->fetch()) {
			$changeOrderRecipient = self::instantiateOrm($database, 'ChangeOrderRecipient', $row);
			/* @var $changeOrderRecipient ChangeOrderRecipient */
			$arrChangeOrderRecipientsByCoAdditionalRecipientContactId[] = $changeOrderRecipient;
		}

		$db->free_result();

		self::$_arrChangeOrderRecipientsByCoAdditionalRecipientContactId = $arrChangeOrderRecipientsByCoAdditionalRecipientContactId;

		return $arrChangeOrderRecipientsByCoAdditionalRecipientContactId;
	}

	/**
	 * Load by constraint `change_order_recipients_fk_c_mobile_cpn` foreign key (`co_additional_recipient_contact_mobile_phone_number_id`) references `contact_phone_numbers` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $co_additional_recipient_contact_mobile_phone_number_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadChangeOrderRecipientsByCoAdditionalRecipientContactMobilePhoneNumberId($database, $co_additional_recipient_contact_mobile_phone_number_id, Input $options=null)
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
			self::$_arrChangeOrderRecipientsByCoAdditionalRecipientContactMobilePhoneNumberId = null;
		}

		$arrChangeOrderRecipientsByCoAdditionalRecipientContactMobilePhoneNumberId = self::$_arrChangeOrderRecipientsByCoAdditionalRecipientContactMobilePhoneNumberId;
		if (isset($arrChangeOrderRecipientsByCoAdditionalRecipientContactMobilePhoneNumberId) && !empty($arrChangeOrderRecipientsByCoAdditionalRecipientContactMobilePhoneNumberId)) {
			return $arrChangeOrderRecipientsByCoAdditionalRecipientContactMobilePhoneNumberId;
		}

		$co_additional_recipient_contact_mobile_phone_number_id = (int) $co_additional_recipient_contact_mobile_phone_number_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `change_order_notification_id` ASC, `co_additional_recipient_contact_id` ASC, `co_additional_recipient_contact_mobile_phone_number_id` ASC, `smtp_recipient_header_type` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpChangeOrderRecipient = new ChangeOrderRecipient($database);
			$sqlOrderByColumns = $tmpChangeOrderRecipient->constructSqlOrderByColumns($arrOrderByAttributes);

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
	corecipients.*

FROM `change_order_recipients` corecipients
WHERE corecipients.`co_additional_recipient_contact_mobile_phone_number_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `change_order_notification_id` ASC, `co_additional_recipient_contact_id` ASC, `co_additional_recipient_contact_mobile_phone_number_id` ASC, `smtp_recipient_header_type` ASC
		$arrValues = array($co_additional_recipient_contact_mobile_phone_number_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrChangeOrderRecipientsByCoAdditionalRecipientContactMobilePhoneNumberId = array();
		while ($row = $db->fetch()) {
			$changeOrderRecipient = self::instantiateOrm($database, 'ChangeOrderRecipient', $row);
			/* @var $changeOrderRecipient ChangeOrderRecipient */
			$arrChangeOrderRecipientsByCoAdditionalRecipientContactMobilePhoneNumberId[] = $changeOrderRecipient;
		}

		$db->free_result();

		self::$_arrChangeOrderRecipientsByCoAdditionalRecipientContactMobilePhoneNumberId = $arrChangeOrderRecipientsByCoAdditionalRecipientContactMobilePhoneNumberId;

		return $arrChangeOrderRecipientsByCoAdditionalRecipientContactMobilePhoneNumberId;
	}

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all change_order_recipients records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllChangeOrderRecipients($database, Input $options=null)
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
			self::$_arrAllChangeOrderRecipients = null;
		}

		$arrAllChangeOrderRecipients = self::$_arrAllChangeOrderRecipients;
		if (isset($arrAllChangeOrderRecipients) && !empty($arrAllChangeOrderRecipients)) {
			return $arrAllChangeOrderRecipients;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `change_order_notification_id` ASC, `co_additional_recipient_contact_id` ASC, `co_additional_recipient_contact_mobile_phone_number_id` ASC, `smtp_recipient_header_type` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpChangeOrderRecipient = new ChangeOrderRecipient($database);
			$sqlOrderByColumns = $tmpChangeOrderRecipient->constructSqlOrderByColumns($arrOrderByAttributes);

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
	corecipients.*

FROM `change_order_recipients` corecipients{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `change_order_notification_id` ASC, `co_additional_recipient_contact_id` ASC, `co_additional_recipient_contact_mobile_phone_number_id` ASC, `smtp_recipient_header_type` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllChangeOrderRecipients = array();
		while ($row = $db->fetch()) {
			$changeOrderRecipient = self::instantiateOrm($database, 'ChangeOrderRecipient', $row);
			/* @var $changeOrderRecipient ChangeOrderRecipient */
			$arrAllChangeOrderRecipients[] = $changeOrderRecipient;
		}

		$db->free_result();

		self::$_arrAllChangeOrderRecipients = $arrAllChangeOrderRecipients;

		return $arrAllChangeOrderRecipients;
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
INTO `change_order_recipients`
(`change_order_notification_id`, `co_additional_recipient_contact_id`, `co_additional_recipient_contact_mobile_phone_number_id`, `smtp_recipient_header_type`)
VALUES (?, ?, ?, ?)
ON DUPLICATE KEY UPDATE `co_additional_recipient_contact_mobile_phone_number_id` = ?, `smtp_recipient_header_type` = ?
";
		$arrValues = array($this->change_order_notification_id, $this->co_additional_recipient_contact_id, $this->co_additional_recipient_contact_mobile_phone_number_id, $this->smtp_recipient_header_type, $this->co_additional_recipient_contact_mobile_phone_number_id, $this->smtp_recipient_header_type);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$change_order_recipient_id = $db->insertId;
		$db->free_result();

		return $change_order_recipient_id;
	}

	// Save: insert ignore
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

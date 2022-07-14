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
 * MobilePhoneNumber.
 *
 * @category   Framework
 * @package    MobilePhoneNumber
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class MobilePhoneNumber extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'MobilePhoneNumber';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'mobile_phone_numbers';

	/**
	 * primary key (`contact_id`,`contact_phone_number_id`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrPrimaryKey = array(
		'contact_id' => 'int',
		'contact_phone_number_id' => 'int'
	);

	/**
	 * No Unique Indexes, Just a Primary Key
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_mobile_phone_number_via_primary_key' => array(
			'contact_id' => 'int',
			'contact_phone_number_id' => 'int'
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
		'contact_id' => 'contact_id',
		'contact_phone_number_id' => 'contact_phone_number_id',

		'mobile_network_carrier_id' => 'mobile_network_carrier_id',

		'verified_flag' => 'verified_flag'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $contact_id;
	public $contact_phone_number_id;

	public $mobile_network_carrier_id;

	public $verified_flag;

	// Other properties
	public $mobile_phone_number;
	public $phone_number_type;
	public $phone_number_type_id;
	public $country_code;
	public $area_code;
	public $prefix;
	public $number;
	public $extension;
	public $itu;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties

	// HTML ENTITY ENCODED NL2BR ORM string properties

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)
	protected static $_arrMobilePhoneNumbersByContactId;
	protected static $_arrMobilePhoneNumbersByContactPhoneNumberId;
	protected static $_arrMobilePhoneNumbersByMobileNetworkCarrierId;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllMobilePhoneNumbers;

	// Foreign Key Objects
	private $_contact;
	private $_contactPhoneNumber;
	private $_mobileNetworkCarrier;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='mobile_phone_numbers')
	{
		parent::__construct($table);
		$this->setDatabase($database);
	}

	// Foreign Key Object Accessor Methods
	public function getContact()
	{
		if (isset($this->_contact)) {
			return $this->_contact;
		} else {
			return null;
		}
	}

	public function setContact($contact)
	{
		$this->_contact = $contact;
	}

	public function getContactPhoneNumber()
	{
		if (isset($this->_contactPhoneNumber)) {
			return $this->_contactPhoneNumber;
		} else {
			return null;
		}
	}

	public function setContactPhoneNumber($contactPhoneNumber)
	{
		$this->_contactPhoneNumber = $contactPhoneNumber;
	}

	public function getMobileNetworkCarrier()
	{
		if (isset($this->_mobileNetworkCarrier)) {
			return $this->_mobileNetworkCarrier;
		} else {
			return null;
		}
	}

	public function setMobileNetworkCarrier($mobileNetworkCarrier)
	{
		$this->_mobileNetworkCarrier = $mobileNetworkCarrier;
	}

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)
	public static function getArrMobilePhoneNumbersByContactId()
	{
		if (isset(self::$_arrMobilePhoneNumbersByContactId)) {
			return self::$_arrMobilePhoneNumbersByContactId;
		} else {
			return null;
		}
	}

	public static function setArrMobilePhoneNumbersByContactId($arrMobilePhoneNumbersByContactId)
	{
		self::$_arrMobilePhoneNumbersByContactId = $arrMobilePhoneNumbersByContactId;
	}

	public static function getArrMobilePhoneNumbersByContactPhoneNumberId()
	{
		if (isset(self::$_arrMobilePhoneNumbersByContactPhoneNumberId)) {
			return self::$_arrMobilePhoneNumbersByContactPhoneNumberId;
		} else {
			return null;
		}
	}

	public static function setArrMobilePhoneNumbersByContactPhoneNumberId($arrMobilePhoneNumbersByContactPhoneNumberId)
	{
		self::$_arrMobilePhoneNumbersByContactPhoneNumberId = $arrMobilePhoneNumbersByContactPhoneNumberId;
	}

	public static function getArrMobilePhoneNumbersByMobileNetworkCarrierId()
	{
		if (isset(self::$_arrMobilePhoneNumbersByMobileNetworkCarrierId)) {
			return self::$_arrMobilePhoneNumbersByMobileNetworkCarrierId;
		} else {
			return null;
		}
	}

	public static function setArrMobilePhoneNumbersByMobileNetworkCarrierId($arrMobilePhoneNumbersByMobileNetworkCarrierId)
	{
		self::$_arrMobilePhoneNumbersByMobileNetworkCarrierId = $arrMobilePhoneNumbersByMobileNetworkCarrierId;
	}

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllMobilePhoneNumbers()
	{
		if (isset(self::$_arrAllMobilePhoneNumbers)) {
			return self::$_arrAllMobilePhoneNumbers;
		} else {
			return null;
		}
	}

	public static function setArrAllMobilePhoneNumbers($arrAllMobilePhoneNumbers)
	{
		self::$_arrAllMobilePhoneNumbers = $arrAllMobilePhoneNumbers;
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
	 * Find by primary key (`contact_id`,`contact_phone_number_id`).
	 *
	 * @param string $database
	 * @param int $contact_id
	 * @param int $contact_phone_number_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findByContactIdAndContactPhoneNumberId($database, $contact_id, $contact_phone_number_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	mpn.*

FROM `mobile_phone_numbers` mpn
WHERE mpn.`contact_id` = ?
AND mpn.`contact_phone_number_id` = ?
";
		$arrValues = array($contact_id, $contact_phone_number_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row && !empty($row)) {
			$mobilePhoneNumber = self::instantiateOrm($database, 'MobilePhoneNumber', $row);
			/* @var $mobilePhoneNumber MobilePhoneNumber */
			return $mobilePhoneNumber;
		} else {
			return false;
		}
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Find by primary key (`contact_id`,`contact_phone_number_id`) Extended.
	 *
	 * @param string $database
	 * @param int $contact_id
	 * @param int $contact_phone_number_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findByContactIdAndContactPhoneNumberIdExtended($database, $contact_id, $contact_phone_number_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	mpn_fk_c.`id` AS 'mpn_fk_c__contact_id',
	mpn_fk_c.`user_company_id` AS 'mpn_fk_c__user_company_id',
	mpn_fk_c.`user_id` AS 'mpn_fk_c__user_id',
	mpn_fk_c.`contact_company_id` AS 'mpn_fk_c__contact_company_id',
	mpn_fk_c.`email` AS 'mpn_fk_c__email',
	mpn_fk_c.`name_prefix` AS 'mpn_fk_c__name_prefix',
	mpn_fk_c.`first_name` AS 'mpn_fk_c__first_name',
	mpn_fk_c.`additional_name` AS 'mpn_fk_c__additional_name',
	mpn_fk_c.`middle_name` AS 'mpn_fk_c__middle_name',
	mpn_fk_c.`last_name` AS 'mpn_fk_c__last_name',
	mpn_fk_c.`name_suffix` AS 'mpn_fk_c__name_suffix',
	mpn_fk_c.`title` AS 'mpn_fk_c__title',
	mpn_fk_c.`vendor_flag` AS 'mpn_fk_c__vendor_flag',

	mpn_fk_cpn.`id` AS 'mpn_fk_cpn__contact_phone_number_id',
	mpn_fk_cpn.`contact_id` AS 'mpn_fk_cpn__contact_id',
	mpn_fk_cpn.`phone_number_type_id` AS 'mpn_fk_cpn__phone_number_type_id',
	mpn_fk_cpn.`country_code` AS 'mpn_fk_cpn__country_code',
	mpn_fk_cpn.`area_code` AS 'mpn_fk_cpn__area_code',
	mpn_fk_cpn.`prefix` AS 'mpn_fk_cpn__prefix',
	mpn_fk_cpn.`number` AS 'mpn_fk_cpn__number',
	mpn_fk_cpn.`extension` AS 'mpn_fk_cpn__extension',
	mpn_fk_cpn.`itu` AS 'mpn_fk_cpn__itu',

	mpn_fk_mnc.`id` AS 'mpn_fk_mnc__mobile_network_carrier_id',
	mpn_fk_mnc.`carrier` AS 'mpn_fk_mnc__carrier',
	mpn_fk_mnc.`carrier_display_name` AS 'mpn_fk_mnc__carrier_display_name',
	mpn_fk_mnc.`sms_email_gateway` AS 'mpn_fk_mnc__sms_email_gateway',
	mpn_fk_mnc.`country` AS 'mpn_fk_mnc__country',

	mpn.*

FROM `mobile_phone_numbers` mpn
	INNER JOIN `contacts` mpn_fk_c ON mpn.`contact_id` = mpn_fk_c.`id`
	INNER JOIN `contact_phone_numbers` mpn_fk_cpn ON mpn.`contact_phone_number_id` = mpn_fk_cpn.`id`
	INNER JOIN `mobile_network_carriers` mpn_fk_mnc ON mpn.`mobile_network_carrier_id` = mpn_fk_mnc.`id`
WHERE mpn.`contact_id` = ?
AND mpn.`contact_phone_number_id` = ?
";
		$arrValues = array($contact_id, $contact_phone_number_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row && !empty($row)) {
			$mobilePhoneNumber = self::instantiateOrm($database, 'MobilePhoneNumber', $row);
			/* @var $mobilePhoneNumber MobilePhoneNumber */
			$mobilePhoneNumber->convertPropertiesToData();

			if (isset($row['contact_id'])) {
				$contact_id = $row['contact_id'];
				$row['mpn_fk_c__id'] = $contact_id;
				$contact = self::instantiateOrm($database, 'Contact', $row, null, $contact_id, 'mpn_fk_c__');
				/* @var $contact Contact */
				$contact->convertPropertiesToData();
			} else {
				$contact = false;
			}
			$mobilePhoneNumber->setContact($contact);

			if (isset($row['contact_phone_number_id'])) {
				$contact_phone_number_id = $row['contact_phone_number_id'];
				$row['mpn_fk_cpn__id'] = $contact_phone_number_id;
				$contactPhoneNumber = self::instantiateOrm($database, 'ContactPhoneNumber', $row, null, $contact_phone_number_id, 'mpn_fk_cpn__');
				/* @var $contactPhoneNumber ContactPhoneNumber */
				$contactPhoneNumber->convertPropertiesToData();
			} else {
				$contactPhoneNumber = false;
			}
			$mobilePhoneNumber->setContactPhoneNumber($contactPhoneNumber);

			if (isset($row['mobile_network_carrier_id'])) {
				$mobile_network_carrier_id = $row['mobile_network_carrier_id'];
				$row['mpn_fk_mnc__id'] = $mobile_network_carrier_id;
				$mobileNetworkCarrier = self::instantiateOrm($database, 'MobileNetworkCarrier', $row, null, $mobile_network_carrier_id, 'mpn_fk_mnc__');
				/* @var $mobileNetworkCarrier MobileNetworkCarrier */
				$mobileNetworkCarrier->convertPropertiesToData();
			} else {
				$mobileNetworkCarrier = false;
			}
			$mobilePhoneNumber->setMobileNetworkCarrier($mobileNetworkCarrier);

			return $mobilePhoneNumber;
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
	 * @param array $arrContactIdAndContactPhoneNumberIdList
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadMobilePhoneNumbersByArrContactIdAndContactPhoneNumberIdList($database, $arrContactIdAndContactPhoneNumberIdList, Input $options=null)
	{
		if (empty($arrContactIdAndContactPhoneNumberIdList)) {
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
		// ORDER BY `contact_id` ASC, `contact_phone_number_id` ASC, `mobile_network_carrier_id` ASC, `verified_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpMobilePhoneNumber = new MobilePhoneNumber($database);
			$sqlOrderByColumns = $tmpMobilePhoneNumber->constructSqlOrderByColumns($arrOrderByAttributes);

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
		foreach ($arrContactIdAndContactPhoneNumberIdList as $k => $arrTmp) {
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
		if (count($arrContactIdAndContactPhoneNumberIdList) > 1) {
			$sqlWhere = join($arrSqlWhere, ' OR ');
			$sqlWhere = "WHERE ($sqlWhere)";
		} else {
			$sqlWhere = "WHERE $tmpInnerAnd";
		}

		$query =
"
SELECT

	mpn.*

FROM `mobile_phone_numbers` mpn
{$sqlWhere}{$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrMobilePhoneNumbersByArrContactIdAndContactPhoneNumberIdList = array();
		while ($row = $db->fetch()) {
			$mobilePhoneNumber = self::instantiateOrm($database, 'MobilePhoneNumber', $row);
			/* @var $mobilePhoneNumber MobilePhoneNumber */
			$arrMobilePhoneNumbersByArrContactIdAndContactPhoneNumberIdList[] = $mobilePhoneNumber;
		}

		$db->free_result();

		return $arrMobilePhoneNumbersByArrContactIdAndContactPhoneNumberIdList;
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `mobile_phone_numbers_fk_c` foreign key (`contact_id`) references `contacts` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $contact_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadMobilePhoneNumbersByContactId($database, $contact_id, Input $options=null)
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
			self::$_arrMobilePhoneNumbersByContactId = null;
		}

		$arrMobilePhoneNumbersByContactId = self::$_arrMobilePhoneNumbersByContactId;
		if (isset($arrMobilePhoneNumbersByContactId) && !empty($arrMobilePhoneNumbersByContactId)) {
			return $arrMobilePhoneNumbersByContactId;
		}

		$contact_id = (int) $contact_id;

		$db = DBI::getInstance($database);
		
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpMobilePhoneNumber = new MobilePhoneNumber($database);
			$sqlOrderByColumns = $tmpMobilePhoneNumber->constructSqlOrderByColumns($arrOrderByAttributes);

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
"SELECT

	mpn_fk_cpn.`id` AS 'mpn_fk_cpn__contact_phone_number_id',
	mpn_fk_cpn.`contact_id` AS 'mpn_fk_cpn__contact_id',
	mpn_fk_cpn.`phone_number_type_id` AS 'mpn_fk_cpn__phone_number_type_id',
	mpn_fk_cpn.`country_code` AS 'mpn_fk_cpn__country_code',
	mpn_fk_cpn.`area_code` AS 'mpn_fk_cpn__area_code',
	mpn_fk_cpn.`prefix` AS 'mpn_fk_cpn__prefix',
	mpn_fk_cpn.`number` AS 'mpn_fk_cpn__number',
	mpn_fk_cpn.`extension` AS 'mpn_fk_cpn__extension',
	mpn_fk_cpn.`itu` AS 'mpn_fk_cpn__itu',

	mpn_fk_c.*
	FROM  `contacts` mpn_fk_c 
	INNER JOIN `contact_phone_numbers` mpn_fk_cpn ON mpn_fk_c.`id` = mpn_fk_cpn.`contact_id`
	
WHERE mpn_fk_c.`id`  = ? and mpn_fk_cpn.`phone_number_type_id` = ?{$sqlOrderBy}{$sqlLimit}


";

		$arrValues = array($contact_id,3);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrMobilePhoneNumbersByContactId = array();
		while ($row = $db->fetch()) {
				if (isset($row['mpn_fk_cpn__area_code'])) {
				$number_id = $row['mpn_fk_cpn__contact_phone_number_id'] ;
				$area_prefix = $row['mpn_fk_cpn__area_code'];
				$mob_prefix = $row['mpn_fk_cpn__prefix'];
				$number_prefix = $row['mpn_fk_cpn__number'];

				$contact_phone_number_id = "(".$area_prefix.")".$mob_prefix."-".$number_prefix;
				$arrMobilePhoneNumbersByContactId[$number_id] = $contact_phone_number_id;
				
			} 
		}

		$db->free_result();
		return $arrMobilePhoneNumbersByContactId;
	}

public static function loadMobilePhoneNumbersByContactId_old($database, $contact_id, Input $options=null)
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
			self::$_arrMobilePhoneNumbersByContactId = null;
		}

		$arrMobilePhoneNumbersByContactId = self::$_arrMobilePhoneNumbersByContactId;
		if (isset($arrMobilePhoneNumbersByContactId) && !empty($arrMobilePhoneNumbersByContactId)) {
			return $arrMobilePhoneNumbersByContactId;
		}

		$contact_id = (int) $contact_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `contact_id` ASC, `contact_phone_number_id` ASC, `mobile_network_carrier_id` ASC, `verified_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpMobilePhoneNumber = new MobilePhoneNumber($database);
			$sqlOrderByColumns = $tmpMobilePhoneNumber->constructSqlOrderByColumns($arrOrderByAttributes);

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

	mpn_fk_cpn.`id` AS 'mpn_fk_cpn__contact_phone_number_id',
	mpn_fk_cpn.`contact_id` AS 'mpn_fk_cpn__contact_id',
	mpn_fk_cpn.`phone_number_type_id` AS 'mpn_fk_cpn__phone_number_type_id',
	mpn_fk_cpn.`country_code` AS 'mpn_fk_cpn__country_code',
	mpn_fk_cpn.`area_code` AS 'mpn_fk_cpn__area_code',
	mpn_fk_cpn.`prefix` AS 'mpn_fk_cpn__prefix',
	mpn_fk_cpn.`number` AS 'mpn_fk_cpn__number',
	mpn_fk_cpn.`extension` AS 'mpn_fk_cpn__extension',
	mpn_fk_cpn.`itu` AS 'mpn_fk_cpn__itu',

	mpn_fk_mnc.`id` AS 'mpn_fk_mnc__mobile_network_carrier_id',
	mpn_fk_mnc.`carrier` AS 'mpn_fk_mnc__carrier',
	mpn_fk_mnc.`carrier_display_name` AS 'mpn_fk_mnc__carrier_display_name',
	mpn_fk_mnc.`sms_email_gateway` AS 'mpn_fk_mnc__sms_email_gateway',
	mpn_fk_mnc.`country` AS 'mpn_fk_mnc__country',

	mpn.*

FROM `mobile_phone_numbers` mpn
	INNER JOIN `contacts` mpn_fk_c ON mpn.`contact_id` = mpn_fk_c.`id`
	INNER JOIN `contact_phone_numbers` mpn_fk_cpn ON mpn.`contact_phone_number_id` = mpn_fk_cpn.`id`
	INNER JOIN `mobile_network_carriers` mpn_fk_mnc ON mpn.`mobile_network_carrier_id` = mpn_fk_mnc.`id`
WHERE mpn.`contact_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `contact_id` ASC, `contact_phone_number_id` ASC, `mobile_network_carrier_id` ASC, `verified_flag` ASC
		$arrValues = array($contact_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrMobilePhoneNumbersByContactId = array();
		while ($row = $db->fetch()) {
			$mobilePhoneNumber = self::instantiateOrm($database, 'MobilePhoneNumber', $row);
			/* @var $mobilePhoneNumber MobilePhoneNumber */
			$mobilePhoneNumber->convertPropertiesToData();

			if (isset($row['contact_phone_number_id'])) {
				$contact_phone_number_id = $row['contact_phone_number_id'];
				$row['mpn_fk_cpn__id'] = $contact_phone_number_id;
				$contactPhoneNumber = self::instantiateOrm($database, 'ContactPhoneNumber', $row, null, $contact_phone_number_id, 'mpn_fk_cpn__');
				/* @var $contactPhoneNumber ContactPhoneNumber */
				$contactPhoneNumber->convertPropertiesToData();
			} else {
				$contactPhoneNumber = false;
			}
			$mobilePhoneNumber->setContactPhoneNumber($contactPhoneNumber);

			if (isset($row['mobile_network_carrier_id'])) {
				$mobile_network_carrier_id = $row['mobile_network_carrier_id'];
				$row['mpn_fk_mnc__id'] = $mobile_network_carrier_id;
				$mobileNetworkCarrier = self::instantiateOrm($database, 'MobileNetworkCarrier', $row, null, $mobile_network_carrier_id, 'mpn_fk_mnc__');
				/* @var $mobileNetworkCarrier MobileNetworkCarrier */
				$mobileNetworkCarrier->convertPropertiesToData();
			} else {
				$mobileNetworkCarrier = false;
			}
			$mobilePhoneNumber->setMobileNetworkCarrier($mobileNetworkCarrier);

			$arrMobilePhoneNumbersByContactId[] = $mobilePhoneNumber;
		}

		$db->free_result();

		self::$_arrMobilePhoneNumbersByContactId = $arrMobilePhoneNumbersByContactId;

		return $arrMobilePhoneNumbersByContactId;
	}

	/**
	 * Load by constraint `mobile_phone_numbers_fk_cpn` foreign key (`contact_phone_number_id`) references `contact_phone_numbers` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $contact_phone_number_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadMobilePhoneNumbersByContactPhoneNumberId($database, $contact_phone_number_id, Input $options=null)
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
			self::$_arrMobilePhoneNumbersByContactPhoneNumberId = null;
		}

		$arrMobilePhoneNumbersByContactPhoneNumberId = self::$_arrMobilePhoneNumbersByContactPhoneNumberId;
		if (isset($arrMobilePhoneNumbersByContactPhoneNumberId) && !empty($arrMobilePhoneNumbersByContactPhoneNumberId)) {
			return $arrMobilePhoneNumbersByContactPhoneNumberId;
		}

		$contact_phone_number_id = (int) $contact_phone_number_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `contact_id` ASC, `contact_phone_number_id` ASC, `mobile_network_carrier_id` ASC, `verified_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpMobilePhoneNumber = new MobilePhoneNumber($database);
			$sqlOrderByColumns = $tmpMobilePhoneNumber->constructSqlOrderByColumns($arrOrderByAttributes);

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
	mpn.*

FROM `mobile_phone_numbers` mpn
WHERE mpn.`contact_phone_number_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `contact_id` ASC, `contact_phone_number_id` ASC, `mobile_network_carrier_id` ASC, `verified_flag` ASC
		$arrValues = array($contact_phone_number_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrMobilePhoneNumbersByContactPhoneNumberId = array();
		while ($row = $db->fetch()) {
			$mobilePhoneNumber = self::instantiateOrm($database, 'MobilePhoneNumber', $row);
			/* @var $mobilePhoneNumber MobilePhoneNumber */
			$arrMobilePhoneNumbersByContactPhoneNumberId[] = $mobilePhoneNumber;
		}

		$db->free_result();

		self::$_arrMobilePhoneNumbersByContactPhoneNumberId = $arrMobilePhoneNumbersByContactPhoneNumberId;

		return $arrMobilePhoneNumbersByContactPhoneNumberId;
	}

	/**
	 * Load by constraint `mobile_phone_numbers_fk_mnc` foreign key (`mobile_network_carrier_id`) references `mobile_network_carriers` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $mobile_network_carrier_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadMobilePhoneNumbersByMobileNetworkCarrierId($database, $mobile_network_carrier_id, Input $options=null)
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
			self::$_arrMobilePhoneNumbersByMobileNetworkCarrierId = null;
		}

		$arrMobilePhoneNumbersByMobileNetworkCarrierId = self::$_arrMobilePhoneNumbersByMobileNetworkCarrierId;
		if (isset($arrMobilePhoneNumbersByMobileNetworkCarrierId) && !empty($arrMobilePhoneNumbersByMobileNetworkCarrierId)) {
			return $arrMobilePhoneNumbersByMobileNetworkCarrierId;
		}

		$mobile_network_carrier_id = (int) $mobile_network_carrier_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `contact_id` ASC, `contact_phone_number_id` ASC, `mobile_network_carrier_id` ASC, `verified_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpMobilePhoneNumber = new MobilePhoneNumber($database);
			$sqlOrderByColumns = $tmpMobilePhoneNumber->constructSqlOrderByColumns($arrOrderByAttributes);

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
	mpn.*

FROM `mobile_phone_numbers` mpn
WHERE mpn.`mobile_network_carrier_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `contact_id` ASC, `contact_phone_number_id` ASC, `mobile_network_carrier_id` ASC, `verified_flag` ASC
		$arrValues = array($mobile_network_carrier_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrMobilePhoneNumbersByMobileNetworkCarrierId = array();
		while ($row = $db->fetch()) {
			$mobilePhoneNumber = self::instantiateOrm($database, 'MobilePhoneNumber', $row);
			/* @var $mobilePhoneNumber MobilePhoneNumber */
			$arrMobilePhoneNumbersByMobileNetworkCarrierId[] = $mobilePhoneNumber;
		}

		$db->free_result();

		self::$_arrMobilePhoneNumbersByMobileNetworkCarrierId = $arrMobilePhoneNumbersByMobileNetworkCarrierId;

		return $arrMobilePhoneNumbersByMobileNetworkCarrierId;
	}

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all mobile_phone_numbers records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllMobilePhoneNumbers($database, Input $options=null)
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
			self::$_arrAllMobilePhoneNumbers = null;
		}

		$arrAllMobilePhoneNumbers = self::$_arrAllMobilePhoneNumbers;
		if (isset($arrAllMobilePhoneNumbers) && !empty($arrAllMobilePhoneNumbers)) {
			return $arrAllMobilePhoneNumbers;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `contact_id` ASC, `contact_phone_number_id` ASC, `mobile_network_carrier_id` ASC, `verified_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpMobilePhoneNumber = new MobilePhoneNumber($database);
			$sqlOrderByColumns = $tmpMobilePhoneNumber->constructSqlOrderByColumns($arrOrderByAttributes);

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
	mpn.*

FROM `mobile_phone_numbers` mpn{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `contact_id` ASC, `contact_phone_number_id` ASC, `mobile_network_carrier_id` ASC, `verified_flag` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllMobilePhoneNumbers = array();
		while ($row = $db->fetch()) {
			$mobilePhoneNumber = self::instantiateOrm($database, 'MobilePhoneNumber', $row);
			/* @var $mobilePhoneNumber MobilePhoneNumber */
			$arrAllMobilePhoneNumbers[] = $mobilePhoneNumber;
		}

		$db->free_result();

		self::$_arrAllMobilePhoneNumbers = $arrAllMobilePhoneNumbers;

		return $arrAllMobilePhoneNumbers;
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
INTO `mobile_phone_numbers`
(`contact_id`, `contact_phone_number_id`, `mobile_network_carrier_id`, `verified_flag`)
VALUES (?, ?, ?, ?)
ON DUPLICATE KEY UPDATE `mobile_network_carrier_id` = ?, `verified_flag` = ?
";
		$arrValues = array($this->contact_id, $this->contact_phone_number_id, $this->mobile_network_carrier_id, $this->verified_flag, $this->mobile_network_carrier_id, $this->verified_flag);
		$db->begin();
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$db->commit();
		$mobile_phone_number_id = $db->insertId;
		$db->free_result();

		return $mobile_phone_number_id;
	}

	// Save: insert ignore

	public function getFormattedMobilePhoneNumber()
	{
		$contactPhoneNumber = $this->getContactPhoneNumber();
		if ($contactPhoneNumber) {
			$formattedPhoneNumber = '('.$contactPhoneNumber->area_code.') '.$contactPhoneNumber->prefix.'-'.$contactPhoneNumber->number;
		} else {
			$formattedPhoneNumber = '';
		}

		return $formattedPhoneNumber;
	}

	public function getMobilePhoneNumber()
	{
		$contactPhoneNumber = $this->getContactPhoneNumber();
		if ($contactPhoneNumber) {
			$mobile_phone_number = $contactPhoneNumber->area_code.$contactPhoneNumber->prefix.$contactPhoneNumber->number;
		} else {
			$mobile_phone_number = '';
		}
		$this->mobile_phone_number = $mobile_phone_number;

		return $mobile_phone_number;
	}
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

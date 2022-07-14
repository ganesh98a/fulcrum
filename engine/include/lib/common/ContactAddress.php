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
 * ContactAddress.
 *
 * @category   Framework
 * @package    ContactAddress
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class ContactAddress extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'ContactAddress';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'contact_addresses';

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
	 * unique index `unique_contact_address` (`contact_id`,`address_line_1`,`address_line_2`,`address_line_3`,`address_line_4`,`address_city`,`address_county`,`address_state_or_region`,`address_postal_code`,`address_postal_code_extension`,`address_country`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_contact_address' => array(
			'contact_id' => 'int',
			'address_line_1' => 'string',
			'address_line_2' => 'string',
			'address_line_3' => 'string',
			'address_line_4' => 'string',
			'address_city' => 'string',
			'address_county' => 'string',
			'address_state_or_region' => 'string',
			'address_postal_code' => 'string',
			'address_postal_code_extension' => 'string',
			'address_country' => 'string'
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
		'id' => 'contact_address_id',

		'contact_id' => 'contact_id',

		'address_nickname' => 'address_nickname',
		'address_line_1' => 'address_line_1',
		'address_line_2' => 'address_line_2',
		'address_line_3' => 'address_line_3',
		'address_line_4' => 'address_line_4',
		'address_city' => 'address_city',
		'address_county' => 'address_county',
		'address_state_or_region' => 'address_state_or_region',
		'address_postal_code' => 'address_postal_code',
		'address_postal_code_extension' => 'address_postal_code_extension',
		'address_country' => 'address_country',

		'default_address_flag' => 'default_address_flag',
		'address_validated_by_user_flag' => 'address_validated_by_user_flag',
		'address_validated_by_web_service_flag' => 'address_validated_by_web_service_flag',
		'address_validation_by_web_service_error_flag' => 'address_validation_by_web_service_error_flag'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $contact_address_id;

	public $contact_id;

	public $address_nickname;
	public $address_line_1;
	public $address_line_2;
	public $address_line_3;
	public $address_line_4;
	public $address_city;
	public $address_county;
	public $address_state_or_region;
	public $address_postal_code;
	public $address_postal_code_extension;
	public $address_country;

	public $default_address_flag;
	public $address_validated_by_user_flag;
	public $address_validated_by_web_service_flag;
	public $address_validation_by_web_service_error_flag;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties
	public $escaped_address_nickname;
	public $escaped_address_line_1;
	public $escaped_address_line_2;
	public $escaped_address_line_3;
	public $escaped_address_line_4;
	public $escaped_address_city;
	public $escaped_address_county;
	public $escaped_address_state_or_region;
	public $escaped_address_postal_code;
	public $escaped_address_postal_code_extension;
	public $escaped_address_country;

	// HTML ENTITY ENCODED NL2BR ORM string properties
	public $escaped_address_nickname_nl2br;
	public $escaped_address_line_1_nl2br;
	public $escaped_address_line_2_nl2br;
	public $escaped_address_line_3_nl2br;
	public $escaped_address_line_4_nl2br;
	public $escaped_address_city_nl2br;
	public $escaped_address_county_nl2br;
	public $escaped_address_state_or_region_nl2br;
	public $escaped_address_postal_code_nl2br;
	public $escaped_address_postal_code_extension_nl2br;
	public $escaped_address_country_nl2br;

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)
	protected static $_arrContactAddressesByContactId;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)
	protected static $_arrContactAddressesByAddressCity;
	protected static $_arrContactAddressesByAddressStateOrRegion;
	protected static $_arrContactAddressesByAddressPostalCode;

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllContactAddresses;

	// Foreign Key Objects
	private $_contact;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='contact_addresses')
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

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)
	public static function getArrContactAddressesByContactId()
	{
		if (isset(self::$_arrContactAddressesByContactId)) {
			return self::$_arrContactAddressesByContactId;
		} else {
			return null;
		}
	}

	public static function setArrContactAddressesByContactId($arrContactAddressesByContactId)
	{
		self::$_arrContactAddressesByContactId = $arrContactAddressesByContactId;
	}

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)
	public static function getArrContactAddressesByAddressCity()
	{
		if (isset(self::$_arrContactAddressesByAddressCity)) {
			return self::$_arrContactAddressesByAddressCity;
		} else {
			return null;
		}
	}

	public static function setArrContactAddressesByAddressCity($arrContactAddressesByAddressCity)
	{
		self::$_arrContactAddressesByAddressCity = $arrContactAddressesByAddressCity;
	}

	public static function getArrContactAddressesByAddressStateOrRegion()
	{
		if (isset(self::$_arrContactAddressesByAddressStateOrRegion)) {
			return self::$_arrContactAddressesByAddressStateOrRegion;
		} else {
			return null;
		}
	}

	public static function setArrContactAddressesByAddressStateOrRegion($arrContactAddressesByAddressStateOrRegion)
	{
		self::$_arrContactAddressesByAddressStateOrRegion = $arrContactAddressesByAddressStateOrRegion;
	}

	public static function getArrContactAddressesByAddressPostalCode()
	{
		if (isset(self::$_arrContactAddressesByAddressPostalCode)) {
			return self::$_arrContactAddressesByAddressPostalCode;
		} else {
			return null;
		}
	}

	public static function setArrContactAddressesByAddressPostalCode($arrContactAddressesByAddressPostalCode)
	{
		self::$_arrContactAddressesByAddressPostalCode = $arrContactAddressesByAddressPostalCode;
	}

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllContactAddresses()
	{
		if (isset(self::$_arrAllContactAddresses)) {
			return self::$_arrAllContactAddresses;
		} else {
			return null;
		}
	}

	public static function setArrAllContactAddresses($arrAllContactAddresses)
	{
		self::$_arrAllContactAddresses = $arrAllContactAddresses;
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
	 * @param int $contact_address_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findById($database, $contact_address_id, $table='contact_addresses', $module='ContactAddress')
	{
		$contactAddress = parent::findById($database, $contact_address_id, $table, $module);

		return $contactAddress;
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Similar to FindById, but with SQL as starter code for more complex joins.
	 *
	 * @param string $database
	 * @param int $contact_address_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findContactAddressByIdExtended($database, $contact_address_id)
	{
		$contact_address_id = (int) $contact_address_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	ca_fk_c.`id` AS 'ca_fk_c__contact_id',
	ca_fk_c.`user_company_id` AS 'ca_fk_c__user_company_id',
	ca_fk_c.`user_id` AS 'ca_fk_c__user_id',
	ca_fk_c.`contact_company_id` AS 'ca_fk_c__contact_company_id',
	ca_fk_c.`email` AS 'ca_fk_c__email',
	ca_fk_c.`name_prefix` AS 'ca_fk_c__name_prefix',
	ca_fk_c.`first_name` AS 'ca_fk_c__first_name',
	ca_fk_c.`additional_name` AS 'ca_fk_c__additional_name',
	ca_fk_c.`middle_name` AS 'ca_fk_c__middle_name',
	ca_fk_c.`last_name` AS 'ca_fk_c__last_name',
	ca_fk_c.`name_suffix` AS 'ca_fk_c__name_suffix',
	ca_fk_c.`title` AS 'ca_fk_c__title',
	ca_fk_c.`vendor_flag` AS 'ca_fk_c__vendor_flag',

	ca.*

FROM `contact_addresses` ca
	INNER JOIN `contacts` ca_fk_c ON ca.`contact_id` = ca_fk_c.`id`
WHERE ca.`id` = ?
";
		$arrValues = array($contact_address_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$contact_address_id = $row['id'];
			$contactAddress = self::instantiateOrm($database, 'ContactAddress', $row, null, $contact_address_id);
			/* @var $contactAddress ContactAddress */
			$contactAddress->convertPropertiesToData();

			if (isset($row['contact_id'])) {
				$contact_id = $row['contact_id'];
				$row['ca_fk_c__id'] = $contact_id;
				$contact = self::instantiateOrm($database, 'Contact', $row, null, $contact_id, 'ca_fk_c__');
				/* @var $contact Contact */
				$contact->convertPropertiesToData();
			} else {
				$contact = false;
			}
			$contactAddress->setContact($contact);

			return $contactAddress;
		} else {
			return false;
		}
	}

	// Finders: Find By Unique Index
	/**
	 * Find by unique index `unique_contact_address` (`contact_id`,`address_line_1`,`address_line_2`,`address_line_3`,`address_line_4`,`address_city`,`address_county`,`address_state_or_region`,`address_postal_code`,`address_postal_code_extension`,`address_country`).
	 *
	 * @param string $database
	 * @param int $contact_id
	 * @param string $address_line_1
	 * @param string $address_line_2
	 * @param string $address_line_3
	 * @param string $address_line_4
	 * @param string $address_city
	 * @param string $address_county
	 * @param string $address_state_or_region
	 * @param string $address_postal_code
	 * @param string $address_postal_code_extension
	 * @param string $address_country
	 * @return mixed (single ORM object | false)
	 */
	public static function findByContactIdAndAddressLine1AndAddressLine2AndAddressLine3AndAddressLine4AndAddressCityAndAddressCountyAndAddressStateOrRegionAndAddressPostalCodeAndAddressPostalCodeExtensionAndAddressCountry($database, $contact_id, $address_line_1, $address_line_2, $address_line_3, $address_line_4, $address_city, $address_county, $address_state_or_region, $address_postal_code, $address_postal_code_extension, $address_country)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	ca.*

FROM `contact_addresses` ca
WHERE ca.`contact_id` = ?
AND ca.`address_line_1` = ?
AND ca.`address_line_2` = ?
AND ca.`address_line_3` = ?
AND ca.`address_line_4` = ?
AND ca.`address_city` = ?
AND ca.`address_county` = ?
AND ca.`address_state_or_region` = ?
AND ca.`address_postal_code` = ?
AND ca.`address_postal_code_extension` = ?
AND ca.`address_country` = ?
";
		$arrValues = array($contact_id, $address_line_1, $address_line_2, $address_line_3, $address_line_4, $address_city, $address_county, $address_state_or_region, $address_postal_code, $address_postal_code_extension, $address_country);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if ($row && !empty($row)) {
			$contact_address_id = $row['id'];
			$contactAddress = self::instantiateOrm($database, 'ContactAddress', $row, null, $contact_address_id);
			/* @var $contactAddress ContactAddress */
			return $contactAddress;
		} else {
			return false;
		}
	}

	// Loaders: Load By pk List (list of auto int ids or other non auto int pk list)
	/**
	 * Load zero or more records by an id list (array of auto int primary keys).
	 *
	 * @param string $database
	 * @param array $arrContactAddressIds
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadContactAddressesByArrContactAddressIds($database, $arrContactAddressIds, Input $options=null)
	{
		if (empty($arrContactAddressIds)) {
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
		// ORDER BY `id` ASC, `contact_id` ASC, `address_nickname` ASC, `address_line_1` ASC, `address_line_2` ASC, `address_line_3` ASC, `address_line_4` ASC, `address_city` ASC, `address_county` ASC, `address_state_or_region` ASC, `address_postal_code` ASC, `address_postal_code_extension` ASC, `address_country` ASC, `default_address_flag` ASC, `address_validated_by_user_flag` ASC, `address_validated_by_web_service_flag` ASC, `address_validation_by_web_service_error_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpContactAddress = new ContactAddress($database);
			$sqlOrderByColumns = $tmpContactAddress->constructSqlOrderByColumns($arrOrderByAttributes);

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

		foreach ($arrContactAddressIds as $k => $contact_address_id) {
			$contact_address_id = (int) $contact_address_id;
			$arrContactAddressIds[$k] = $db->escape($contact_address_id);
		}
		$csvContactAddressIds = join(',', $arrContactAddressIds);

		$query =
"
SELECT

	ca.*

FROM `contact_addresses` ca
WHERE ca.`id` IN ($csvContactAddressIds){$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		$arrContactAddressesByCsvContactAddressIds = array();
		while ($row = $db->fetch()) {
			$contact_address_id = $row['id'];
			$contactAddress = self::instantiateOrm($database, 'ContactAddress', $row, null, $contact_address_id);
			/* @var $contactAddress ContactAddress */
			$contactAddress->convertPropertiesToData();

			$arrContactAddressesByCsvContactAddressIds[$contact_address_id] = $contactAddress;
		}

		$db->free_result();

		return $arrContactAddressesByCsvContactAddressIds;
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `contact_addresses_fk_c` foreign key (`contact_id`) references `contacts` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $contact_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadContactAddressesByContactId($database, $contact_id, Input $options=null)
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
			self::$_arrContactAddressesByContactId = null;
		}

		$arrContactAddressesByContactId = self::$_arrContactAddressesByContactId;
		if (isset($arrContactAddressesByContactId) && !empty($arrContactAddressesByContactId)) {
			return $arrContactAddressesByContactId;
		}

		$contact_id = (int) $contact_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `contact_id` ASC, `address_nickname` ASC, `address_line_1` ASC, `address_line_2` ASC, `address_line_3` ASC, `address_line_4` ASC, `address_city` ASC, `address_county` ASC, `address_state_or_region` ASC, `address_postal_code` ASC, `address_postal_code_extension` ASC, `address_country` ASC, `default_address_flag` ASC, `address_validated_by_user_flag` ASC, `address_validated_by_web_service_flag` ASC, `address_validation_by_web_service_error_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpContactAddress = new ContactAddress($database);
			$sqlOrderByColumns = $tmpContactAddress->constructSqlOrderByColumns($arrOrderByAttributes);

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
	ca.*

FROM `contact_addresses` ca
WHERE ca.`contact_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `contact_id` ASC, `address_nickname` ASC, `address_line_1` ASC, `address_line_2` ASC, `address_line_3` ASC, `address_line_4` ASC, `address_city` ASC, `address_county` ASC, `address_state_or_region` ASC, `address_postal_code` ASC, `address_postal_code_extension` ASC, `address_country` ASC, `default_address_flag` ASC, `address_validated_by_user_flag` ASC, `address_validated_by_web_service_flag` ASC, `address_validation_by_web_service_error_flag` ASC
		$arrValues = array($contact_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrContactAddressesByContactId = array();
		while ($row = $db->fetch()) {
			$contact_address_id = $row['id'];
			$contactAddress = self::instantiateOrm($database, 'ContactAddress', $row, null, $contact_address_id);
			/* @var $contactAddress ContactAddress */
			$arrContactAddressesByContactId[$contact_address_id] = $contactAddress;
		}

		$db->free_result();

		self::$_arrContactAddressesByContactId = $arrContactAddressesByContactId;

		return $arrContactAddressesByContactId;
	}

	// Loaders: Load By index
	/**
	 * Load by key `address_city` (`address_city`).
	 *
	 * @param string $database
	 * @param string $address_city
	 * @param mixed (Input $options object | null)
	 * @return mixed (single ORM object | false)
	 */
	public static function loadContactAddressesByAddressCity($database, $address_city, Input $options=null)
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
			self::$_arrContactAddressesByAddressCity = null;
		}

		$arrContactAddressesByAddressCity = self::$_arrContactAddressesByAddressCity;
		if (isset($arrContactAddressesByAddressCity) && !empty($arrContactAddressesByAddressCity)) {
			return $arrContactAddressesByAddressCity;
		}

		$address_city = (string) $address_city;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `contact_id` ASC, `address_nickname` ASC, `address_line_1` ASC, `address_line_2` ASC, `address_line_3` ASC, `address_line_4` ASC, `address_city` ASC, `address_county` ASC, `address_state_or_region` ASC, `address_postal_code` ASC, `address_postal_code_extension` ASC, `address_country` ASC, `default_address_flag` ASC, `address_validated_by_user_flag` ASC, `address_validated_by_web_service_flag` ASC, `address_validation_by_web_service_error_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpContactAddress = new ContactAddress($database);
			$sqlOrderByColumns = $tmpContactAddress->constructSqlOrderByColumns($arrOrderByAttributes);

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
	ca.*

FROM `contact_addresses` ca
WHERE ca.`address_city` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `contact_id` ASC, `address_nickname` ASC, `address_line_1` ASC, `address_line_2` ASC, `address_line_3` ASC, `address_line_4` ASC, `address_city` ASC, `address_county` ASC, `address_state_or_region` ASC, `address_postal_code` ASC, `address_postal_code_extension` ASC, `address_country` ASC, `default_address_flag` ASC, `address_validated_by_user_flag` ASC, `address_validated_by_web_service_flag` ASC, `address_validation_by_web_service_error_flag` ASC
		$arrValues = array($address_city);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrContactAddressesByAddressCity = array();
		while ($row = $db->fetch()) {
			$contact_address_id = $row['id'];
			$contactAddress = self::instantiateOrm($database, 'ContactAddress', $row, null, $contact_address_id);
			/* @var $contactAddress ContactAddress */
			$arrContactAddressesByAddressCity[$contact_address_id] = $contactAddress;
		}

		$db->free_result();

		self::$_arrContactAddressesByAddressCity = $arrContactAddressesByAddressCity;

		return $arrContactAddressesByAddressCity;
	}

	/**
	 * Load by key `address_state_or_region` (`address_state_or_region`).
	 *
	 * @param string $database
	 * @param string $address_state_or_region
	 * @param mixed (Input $options object | null)
	 * @return mixed (single ORM object | false)
	 */
	public static function loadContactAddressesByAddressStateOrRegion($database, $address_state_or_region, Input $options=null)
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
			self::$_arrContactAddressesByAddressStateOrRegion = null;
		}

		$arrContactAddressesByAddressStateOrRegion = self::$_arrContactAddressesByAddressStateOrRegion;
		if (isset($arrContactAddressesByAddressStateOrRegion) && !empty($arrContactAddressesByAddressStateOrRegion)) {
			return $arrContactAddressesByAddressStateOrRegion;
		}

		$address_state_or_region = (string) $address_state_or_region;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `contact_id` ASC, `address_nickname` ASC, `address_line_1` ASC, `address_line_2` ASC, `address_line_3` ASC, `address_line_4` ASC, `address_city` ASC, `address_county` ASC, `address_state_or_region` ASC, `address_postal_code` ASC, `address_postal_code_extension` ASC, `address_country` ASC, `default_address_flag` ASC, `address_validated_by_user_flag` ASC, `address_validated_by_web_service_flag` ASC, `address_validation_by_web_service_error_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpContactAddress = new ContactAddress($database);
			$sqlOrderByColumns = $tmpContactAddress->constructSqlOrderByColumns($arrOrderByAttributes);

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
	ca.*

FROM `contact_addresses` ca
WHERE ca.`address_state_or_region` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `contact_id` ASC, `address_nickname` ASC, `address_line_1` ASC, `address_line_2` ASC, `address_line_3` ASC, `address_line_4` ASC, `address_city` ASC, `address_county` ASC, `address_state_or_region` ASC, `address_postal_code` ASC, `address_postal_code_extension` ASC, `address_country` ASC, `default_address_flag` ASC, `address_validated_by_user_flag` ASC, `address_validated_by_web_service_flag` ASC, `address_validation_by_web_service_error_flag` ASC
		$arrValues = array($address_state_or_region);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrContactAddressesByAddressStateOrRegion = array();
		while ($row = $db->fetch()) {
			$contact_address_id = $row['id'];
			$contactAddress = self::instantiateOrm($database, 'ContactAddress', $row, null, $contact_address_id);
			/* @var $contactAddress ContactAddress */
			$arrContactAddressesByAddressStateOrRegion[$contact_address_id] = $contactAddress;
		}

		$db->free_result();

		self::$_arrContactAddressesByAddressStateOrRegion = $arrContactAddressesByAddressStateOrRegion;

		return $arrContactAddressesByAddressStateOrRegion;
	}

	/**
	 * Load by key `address_postal_code` (`address_postal_code`).
	 *
	 * @param string $database
	 * @param string $address_postal_code
	 * @param mixed (Input $options object | null)
	 * @return mixed (single ORM object | false)
	 */
	public static function loadContactAddressesByAddressPostalCode($database, $address_postal_code, Input $options=null)
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
			self::$_arrContactAddressesByAddressPostalCode = null;
		}

		$arrContactAddressesByAddressPostalCode = self::$_arrContactAddressesByAddressPostalCode;
		if (isset($arrContactAddressesByAddressPostalCode) && !empty($arrContactAddressesByAddressPostalCode)) {
			return $arrContactAddressesByAddressPostalCode;
		}

		$address_postal_code = (string) $address_postal_code;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `contact_id` ASC, `address_nickname` ASC, `address_line_1` ASC, `address_line_2` ASC, `address_line_3` ASC, `address_line_4` ASC, `address_city` ASC, `address_county` ASC, `address_state_or_region` ASC, `address_postal_code` ASC, `address_postal_code_extension` ASC, `address_country` ASC, `default_address_flag` ASC, `address_validated_by_user_flag` ASC, `address_validated_by_web_service_flag` ASC, `address_validation_by_web_service_error_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpContactAddress = new ContactAddress($database);
			$sqlOrderByColumns = $tmpContactAddress->constructSqlOrderByColumns($arrOrderByAttributes);

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
	ca.*

FROM `contact_addresses` ca
WHERE ca.`address_postal_code` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `contact_id` ASC, `address_nickname` ASC, `address_line_1` ASC, `address_line_2` ASC, `address_line_3` ASC, `address_line_4` ASC, `address_city` ASC, `address_county` ASC, `address_state_or_region` ASC, `address_postal_code` ASC, `address_postal_code_extension` ASC, `address_country` ASC, `default_address_flag` ASC, `address_validated_by_user_flag` ASC, `address_validated_by_web_service_flag` ASC, `address_validation_by_web_service_error_flag` ASC
		$arrValues = array($address_postal_code);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrContactAddressesByAddressPostalCode = array();
		while ($row = $db->fetch()) {
			$contact_address_id = $row['id'];
			$contactAddress = self::instantiateOrm($database, 'ContactAddress', $row, null, $contact_address_id);
			/* @var $contactAddress ContactAddress */
			$arrContactAddressesByAddressPostalCode[$contact_address_id] = $contactAddress;
		}

		$db->free_result();

		self::$_arrContactAddressesByAddressPostalCode = $arrContactAddressesByAddressPostalCode;

		return $arrContactAddressesByAddressPostalCode;
	}

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all contact_addresses records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllContactAddresses($database, Input $options=null)
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
			self::$_arrAllContactAddresses = null;
		}

		$arrAllContactAddresses = self::$_arrAllContactAddresses;
		if (isset($arrAllContactAddresses) && !empty($arrAllContactAddresses)) {
			return $arrAllContactAddresses;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `contact_id` ASC, `address_nickname` ASC, `address_line_1` ASC, `address_line_2` ASC, `address_line_3` ASC, `address_line_4` ASC, `address_city` ASC, `address_county` ASC, `address_state_or_region` ASC, `address_postal_code` ASC, `address_postal_code_extension` ASC, `address_country` ASC, `default_address_flag` ASC, `address_validated_by_user_flag` ASC, `address_validated_by_web_service_flag` ASC, `address_validation_by_web_service_error_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpContactAddress = new ContactAddress($database);
			$sqlOrderByColumns = $tmpContactAddress->constructSqlOrderByColumns($arrOrderByAttributes);

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
	ca.*

FROM `contact_addresses` ca{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `contact_id` ASC, `address_nickname` ASC, `address_line_1` ASC, `address_line_2` ASC, `address_line_3` ASC, `address_line_4` ASC, `address_city` ASC, `address_county` ASC, `address_state_or_region` ASC, `address_postal_code` ASC, `address_postal_code_extension` ASC, `address_country` ASC, `default_address_flag` ASC, `address_validated_by_user_flag` ASC, `address_validated_by_web_service_flag` ASC, `address_validation_by_web_service_error_flag` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllContactAddresses = array();
		while ($row = $db->fetch()) {
			$contact_address_id = $row['id'];
			$contactAddress = self::instantiateOrm($database, 'ContactAddress', $row, null, $contact_address_id);
			/* @var $contactAddress ContactAddress */
			$arrAllContactAddresses[$contact_address_id] = $contactAddress;
		}

		$db->free_result();

		self::$_arrAllContactAddresses = $arrAllContactAddresses;

		return $arrAllContactAddresses;
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
INTO `contact_addresses`
(`contact_id`, `address_nickname`, `address_line_1`, `address_line_2`, `address_line_3`, `address_line_4`, `address_city`, `address_county`, `address_state_or_region`, `address_postal_code`, `address_postal_code_extension`, `address_country`, `default_address_flag`, `address_validated_by_user_flag`, `address_validated_by_web_service_flag`, `address_validation_by_web_service_error_flag`)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
ON DUPLICATE KEY UPDATE `address_nickname` = ?, `default_address_flag` = ?, `address_validated_by_user_flag` = ?, `address_validated_by_web_service_flag` = ?, `address_validation_by_web_service_error_flag` = ?
";
		$arrValues = array($this->contact_id, $this->address_nickname, $this->address_line_1, $this->address_line_2, $this->address_line_3, $this->address_line_4, $this->address_city, $this->address_county, $this->address_state_or_region, $this->address_postal_code, $this->address_postal_code_extension, $this->address_country, $this->default_address_flag, $this->address_validated_by_user_flag, $this->address_validated_by_web_service_flag, $this->address_validation_by_web_service_error_flag, $this->address_nickname, $this->default_address_flag, $this->address_validated_by_user_flag, $this->address_validated_by_web_service_flag, $this->address_validation_by_web_service_error_flag);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$contact_address_id = $db->insertId;
		$db->free_result();

		return $contact_address_id;
	}

	// Save: insert ignore
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

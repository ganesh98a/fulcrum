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
 * Manage addresses.
 *
 * @category   Framework
 * @package    Address
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class Address extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'Address';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'addresses';

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
	 * unique index `unique_address` (`address_line_1`,`address_line_2`,`address_line_3`,`address_line_4`,`address_city`,`address_county`,`address_state_or_region`,`address_postal_code`,`address_postal_code_extension`,`address_country`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_address' => array(
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
		'id' => 'address_id',

		//'address_us_state_id' => 'state_id',
		//'address_us_city_id' => 'city_id',
		//'address_country_id' => 'country_id',

		'address_line_1' => 'address_line_1',
		'address_line_2' => 'address_line_2',
		'address_line_3' => 'address_line_3',
		'address_line_4' => 'address_line_4',
		'address_city' => 'address_city',
		'address_county' => 'address_county',
		'address_state_or_region' => 'address_state_or_region',
		'address_state_or_region_abbreviation' => 'address_state_or_region_abbreviation',
		'address_postal_code' => 'address_postal_code',
		'address_postal_code_extension' => 'address_postal_code_extension',
		'address_country' => 'address_country',

		'address_validated_by_user_flag' => 'address_validated_by_user_flag',
		'address_validated_by_web_service_flag' => 'address_validated_by_web_service_flag',
		'address_validation_by_web_service_error_flag' => 'address_validation_by_web_service_error_flag'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $address_id;

	public $address_line_1;
	public $address_line_2;
	public $address_line_3;
	public $address_line_4;
	public $address_city;
	public $address_county;
	public $address_state_or_region;
	public $address_state_or_region_abbreviation;
	public $address_postal_code;
	public $address_postal_code_extension;
	public $address_country;

	public $address_validated_by_user_flag;
	public $address_validated_by_web_service_flag;
	public $address_validation_by_web_service_error_flag;

	// Other Properties
	//protected $_otherPropertyHere;
	protected $name_prefix;
	protected $first_name;
	protected $middle_name;
	protected $last_name;
	protected $name_suffix;
	protected $complete_name;
	protected $company_name;

	// HTML ENTITY ENCODED ORM string properties
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

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)
	protected static $_arrAddressesByAddressPostalCode;
	protected static $_arrAddressesByAddressCity;
	protected static $_arrAddressesByAddressStateOrRegion;

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)
	protected static $_arrAddressesByAddressLine1;

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllAddresses;

	// Foreign Key Objects

	/**
	 * Object references for delegation.
	 */
	protected $addressValidator;
	protected $soap;

	/**
	 * Constructor
	 */
	public function __construct($database='location', $table='addresses')
	{
		parent::__construct($table);
		$this->setDatabase($database);
	}

	// Foreign Key Object Accessor Methods

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)
	public static function getArrAddressesByAddressPostalCode()
	{
		if (isset(self::$_arrAddressesByAddressPostalCode)) {
			return self::$_arrAddressesByAddressPostalCode;
		} else {
			return null;
		}
	}

	public static function setArrAddressesByAddressPostalCode($arrAddressesByAddressPostalCode)
	{
		self::$_arrAddressesByAddressPostalCode = $arrAddressesByAddressPostalCode;
	}

	public static function getArrAddressesByAddressCity()
	{
		if (isset(self::$_arrAddressesByAddressCity)) {
			return self::$_arrAddressesByAddressCity;
		} else {
			return null;
		}
	}

	public static function setArrAddressesByAddressCity($arrAddressesByAddressCity)
	{
		self::$_arrAddressesByAddressCity = $arrAddressesByAddressCity;
	}

	public static function getArrAddressesByAddressStateOrRegion()
	{
		if (isset(self::$_arrAddressesByAddressStateOrRegion)) {
			return self::$_arrAddressesByAddressStateOrRegion;
		} else {
			return null;
		}
	}

	public static function setArrAddressesByAddressStateOrRegion($arrAddressesByAddressStateOrRegion)
	{
		self::$_arrAddressesByAddressStateOrRegion = $arrAddressesByAddressStateOrRegion;
	}

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)
	public static function getArrAddressesByAddressLine1()
	{
		if (isset(self::$_arrAddressesByAddressLine1)) {
			return self::$_arrAddressesByAddressLine1;
		} else {
			return null;
		}
	}

	public static function setArrAddressesByAddressLine1($arrAddressesByAddressLine1)
	{
		self::$_arrAddressesByAddressLine1 = $arrAddressesByAddressLine1;
	}

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllAddresses()
	{
		if (isset(self::$_arrAllAddresses)) {
			return self::$_arrAllAddresses;
		} else {
			return null;
		}
	}

	public static function setArrAllAddresses($arrAllAddresses)
	{
		self::$_arrAllAddresses = $arrAllAddresses;
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
	 * @param int $address_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findById($database, $address_id, $table='addresses', $module='Address')
	{
		$address = parent::findById($database, $address_id, $table, $module);

		return $address;
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Similar to FindById, but with SQL as starter code for more complex joins.
	 *
	 * @param string $database
	 * @param int $address_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findAddressByIdExtended($database, $address_id)
	{
		$address_id = (int) $address_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	a.*

FROM `addresses` a
WHERE a.`id` = ?
";
		$arrValues = array($address_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$address_id = $row['id'];
			$address = self::instantiateOrm($database, 'Address', $row, null, $address_id);
			/* @var $address Address */
			$address->convertPropertiesToData();

			return $address;
		} else {
			return false;
		}
	}

	// Finders: Find By Unique Index
	/**
	 * Find by unique index `unique_address` (`address_line_1`,`address_line_2`,`address_line_3`,`address_line_4`,`address_city`,`address_county`,`address_state_or_region`,`address_postal_code`,`address_postal_code_extension`,`address_country`).
	 *
	 * @param string $database
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
	public static function findByAddressLine1AndAddressLine2AndAddressLine3AndAddressLine4AndAddressCityAndAddressCountyAndAddressStateOrRegionAndAddressPostalCodeAndAddressPostalCodeExtensionAndAddressCountry($database, $address_line_1, $address_line_2, $address_line_3, $address_line_4, $address_city, $address_county, $address_state_or_region, $address_postal_code, $address_postal_code_extension, $address_country)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	a.*

FROM `addresses` a
WHERE a.`address_line_1` = ?
AND a.`address_line_2` = ?
AND a.`address_line_3` = ?
AND a.`address_line_4` = ?
AND a.`address_city` = ?
AND a.`address_county` = ?
AND a.`address_state_or_region` = ?
AND a.`address_postal_code` = ?
AND a.`address_postal_code_extension` = ?
AND a.`address_country` = ?
";
		$arrValues = array($address_line_1, $address_line_2, $address_line_3, $address_line_4, $address_city, $address_county, $address_state_or_region, $address_postal_code, $address_postal_code_extension, $address_country);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if ($row && !empty($row)) {
			$address_id = $row['id'];
			$address = self::instantiateOrm($database, 'Address', $row, null, $address_id);
			/* @var $address Address */
			return $address;
		} else {
			return false;
		}
	}

	// Loaders: Load By pk List (list of auto int ids or other non auto int pk list)
	/**
	 * Load zero or more records by an id list (array of auto int primary keys).
	 *
	 * @param string $database
	 * @param array $arrAddressIds
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAddressesByArrAddressIds($database, $arrAddressIds, Input $options=null)
	{
		if (empty($arrAddressIds)) {
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
		// ORDER BY `id` ASC, `address_line_1` ASC, `address_line_2` ASC, `address_line_3` ASC, `address_line_4` ASC, `address_city` ASC, `address_county` ASC, `address_state_or_region` ASC, `address_postal_code` ASC, `address_postal_code_extension` ASC, `address_country` ASC, `address_validated_by_user_flag` ASC, `address_validated_by_web_service_flag` ASC, `address_validation_by_web_service_error_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpAddress = new Address($database);
			$sqlOrderByColumns = $tmpAddress->constructSqlOrderByColumns($arrOrderByAttributes);

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

		foreach ($arrAddressIds as $k => $address_id) {
			$address_id = (int) $address_id;
			$arrAddressIds[$k] = $db->escape($address_id);
		}
		$csvAddressIds = join(',', $arrAddressIds);

		$query =
"
SELECT

	a.*

FROM `addresses` a
WHERE a.`id` IN ($csvAddressIds){$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		$arrAddressesByCsvAddressIds = array();
		while ($row = $db->fetch()) {
			$address_id = $row['id'];
			$address = self::instantiateOrm($database, 'Address', $row, null, $address_id);
			/* @var $address Address */
			$address->convertPropertiesToData();

			$arrAddressesByCsvAddressIds[$address_id] = $address;
		}

		$db->free_result();

		return $arrAddressesByCsvAddressIds;
	}

	// Loaders: Load By Foreign Key

	// Loaders: Load By index
	/**
	 * Load by key `address_postal_code` (`address_postal_code`).
	 *
	 * @param string $database
	 * @param string $address_postal_code
	 * @param mixed (Input $options object | null)
	 * @return mixed (single ORM object | false)
	 */
	public static function loadAddressesByAddressPostalCode($database, $address_postal_code, Input $options=null)
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
			self::$_arrAddressesByAddressPostalCode = null;
		}

		$arrAddressesByAddressPostalCode = self::$_arrAddressesByAddressPostalCode;
		if (isset($arrAddressesByAddressPostalCode) && !empty($arrAddressesByAddressPostalCode)) {
			return $arrAddressesByAddressPostalCode;
		}

		$address_postal_code = (string) $address_postal_code;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `address_line_1` ASC, `address_line_2` ASC, `address_line_3` ASC, `address_line_4` ASC, `address_city` ASC, `address_county` ASC, `address_state_or_region` ASC, `address_postal_code` ASC, `address_postal_code_extension` ASC, `address_country` ASC, `address_validated_by_user_flag` ASC, `address_validated_by_web_service_flag` ASC, `address_validation_by_web_service_error_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpAddress = new Address($database);
			$sqlOrderByColumns = $tmpAddress->constructSqlOrderByColumns($arrOrderByAttributes);

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
	a.*

FROM `addresses` a
WHERE a.`address_postal_code` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `address_line_1` ASC, `address_line_2` ASC, `address_line_3` ASC, `address_line_4` ASC, `address_city` ASC, `address_county` ASC, `address_state_or_region` ASC, `address_postal_code` ASC, `address_postal_code_extension` ASC, `address_country` ASC, `address_validated_by_user_flag` ASC, `address_validated_by_web_service_flag` ASC, `address_validation_by_web_service_error_flag` ASC
		$arrValues = array($address_postal_code);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrAddressesByAddressPostalCode = array();
		while ($row = $db->fetch()) {
			$address_id = $row['id'];
			$address = self::instantiateOrm($database, 'Address', $row, null, $address_id);
			/* @var $address Address */
			$arrAddressesByAddressPostalCode[$address_id] = $address;
		}

		$db->free_result();

		self::$_arrAddressesByAddressPostalCode = $arrAddressesByAddressPostalCode;

		return $arrAddressesByAddressPostalCode;
	}

	/**
	 * Load by key `address_city` (`address_city`).
	 *
	 * @param string $database
	 * @param string $address_city
	 * @param mixed (Input $options object | null)
	 * @return mixed (single ORM object | false)
	 */
	public static function loadAddressesByAddressCity($database, $address_city, Input $options=null)
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
			self::$_arrAddressesByAddressCity = null;
		}

		$arrAddressesByAddressCity = self::$_arrAddressesByAddressCity;
		if (isset($arrAddressesByAddressCity) && !empty($arrAddressesByAddressCity)) {
			return $arrAddressesByAddressCity;
		}

		$address_city = (string) $address_city;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `address_line_1` ASC, `address_line_2` ASC, `address_line_3` ASC, `address_line_4` ASC, `address_city` ASC, `address_county` ASC, `address_state_or_region` ASC, `address_postal_code` ASC, `address_postal_code_extension` ASC, `address_country` ASC, `address_validated_by_user_flag` ASC, `address_validated_by_web_service_flag` ASC, `address_validation_by_web_service_error_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpAddress = new Address($database);
			$sqlOrderByColumns = $tmpAddress->constructSqlOrderByColumns($arrOrderByAttributes);

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
	a.*

FROM `addresses` a
WHERE a.`address_city` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `address_line_1` ASC, `address_line_2` ASC, `address_line_3` ASC, `address_line_4` ASC, `address_city` ASC, `address_county` ASC, `address_state_or_region` ASC, `address_postal_code` ASC, `address_postal_code_extension` ASC, `address_country` ASC, `address_validated_by_user_flag` ASC, `address_validated_by_web_service_flag` ASC, `address_validation_by_web_service_error_flag` ASC
		$arrValues = array($address_city);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrAddressesByAddressCity = array();
		while ($row = $db->fetch()) {
			$address_id = $row['id'];
			$address = self::instantiateOrm($database, 'Address', $row, null, $address_id);
			/* @var $address Address */
			$arrAddressesByAddressCity[$address_id] = $address;
		}

		$db->free_result();

		self::$_arrAddressesByAddressCity = $arrAddressesByAddressCity;

		return $arrAddressesByAddressCity;
	}

	/**
	 * Load by key `address_state_or_region` (`address_state_or_region`).
	 *
	 * @param string $database
	 * @param string $address_state_or_region
	 * @param mixed (Input $options object | null)
	 * @return mixed (single ORM object | false)
	 */
	public static function loadAddressesByAddressStateOrRegion($database, $address_state_or_region, Input $options=null)
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
			self::$_arrAddressesByAddressStateOrRegion = null;
		}

		$arrAddressesByAddressStateOrRegion = self::$_arrAddressesByAddressStateOrRegion;
		if (isset($arrAddressesByAddressStateOrRegion) && !empty($arrAddressesByAddressStateOrRegion)) {
			return $arrAddressesByAddressStateOrRegion;
		}

		$address_state_or_region = (string) $address_state_or_region;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `address_line_1` ASC, `address_line_2` ASC, `address_line_3` ASC, `address_line_4` ASC, `address_city` ASC, `address_county` ASC, `address_state_or_region` ASC, `address_postal_code` ASC, `address_postal_code_extension` ASC, `address_country` ASC, `address_validated_by_user_flag` ASC, `address_validated_by_web_service_flag` ASC, `address_validation_by_web_service_error_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpAddress = new Address($database);
			$sqlOrderByColumns = $tmpAddress->constructSqlOrderByColumns($arrOrderByAttributes);

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
	a.*

FROM `addresses` a
WHERE a.`address_state_or_region` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `address_line_1` ASC, `address_line_2` ASC, `address_line_3` ASC, `address_line_4` ASC, `address_city` ASC, `address_county` ASC, `address_state_or_region` ASC, `address_postal_code` ASC, `address_postal_code_extension` ASC, `address_country` ASC, `address_validated_by_user_flag` ASC, `address_validated_by_web_service_flag` ASC, `address_validation_by_web_service_error_flag` ASC
		$arrValues = array($address_state_or_region);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrAddressesByAddressStateOrRegion = array();
		while ($row = $db->fetch()) {
			$address_id = $row['id'];
			$address = self::instantiateOrm($database, 'Address', $row, null, $address_id);
			/* @var $address Address */
			$arrAddressesByAddressStateOrRegion[$address_id] = $address;
		}

		$db->free_result();

		self::$_arrAddressesByAddressStateOrRegion = $arrAddressesByAddressStateOrRegion;

		return $arrAddressesByAddressStateOrRegion;
	}

	// Loaders: Load By additionally indexed attribute
	/**
	 * Load by leftmost indexed attribute: unique index `unique_address` (`address_line_1`,`address_line_2`,`address_line_3`,`address_line_4`,`address_city`,`address_county`,`address_state_or_region`,`address_postal_code`,`address_postal_code_extension`,`address_country`).
	 *
	 * @param string $database
	 * @param string $address_line_1
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAddressesByAddressLine1($database, $address_line_1, Input $options=null)
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
			self::$_arrAddressesByAddressLine1 = null;
		}

		$arrAddressesByAddressLine1 = self::$_arrAddressesByAddressLine1;
		if (isset($arrAddressesByAddressLine1) && !empty($arrAddressesByAddressLine1)) {
			return $arrAddressesByAddressLine1;
		}

		$address_line_1 = (string) $address_line_1;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `address_line_1` ASC, `address_line_2` ASC, `address_line_3` ASC, `address_line_4` ASC, `address_city` ASC, `address_county` ASC, `address_state_or_region` ASC, `address_postal_code` ASC, `address_postal_code_extension` ASC, `address_country` ASC, `address_validated_by_user_flag` ASC, `address_validated_by_web_service_flag` ASC, `address_validation_by_web_service_error_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpAddress = new Address($database);
			$sqlOrderByColumns = $tmpAddress->constructSqlOrderByColumns($arrOrderByAttributes);

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
	a.*

FROM `addresses` a
WHERE a.`address_line_1` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `address_line_1` ASC, `address_line_2` ASC, `address_line_3` ASC, `address_line_4` ASC, `address_city` ASC, `address_county` ASC, `address_state_or_region` ASC, `address_postal_code` ASC, `address_postal_code_extension` ASC, `address_country` ASC, `address_validated_by_user_flag` ASC, `address_validated_by_web_service_flag` ASC, `address_validation_by_web_service_error_flag` ASC
		$arrValues = array($address_line_1);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrAddressesByAddressLine1 = array();
		while ($row = $db->fetch()) {
			$address_id = $row['id'];
			$address = self::instantiateOrm($database, 'Address', $row, null, $address_id);
			/* @var $address Address */
			$arrAddressesByAddressLine1[$address_id] = $address;
		}

		$db->free_result();

		self::$_arrAddressesByAddressLine1 = $arrAddressesByAddressLine1;

		return $arrAddressesByAddressLine1;
	}

	// Loaders: Load All Records
	/**
	 * Load all addresses records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllAddresses($database, Input $options=null)
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
			self::$_arrAllAddresses = null;
		}

		$arrAllAddresses = self::$_arrAllAddresses;
		if (isset($arrAllAddresses) && !empty($arrAllAddresses)) {
			return $arrAllAddresses;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `address_line_1` ASC, `address_line_2` ASC, `address_line_3` ASC, `address_line_4` ASC, `address_city` ASC, `address_county` ASC, `address_state_or_region` ASC, `address_postal_code` ASC, `address_postal_code_extension` ASC, `address_country` ASC, `address_validated_by_user_flag` ASC, `address_validated_by_web_service_flag` ASC, `address_validation_by_web_service_error_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpAddress = new Address($database);
			$sqlOrderByColumns = $tmpAddress->constructSqlOrderByColumns($arrOrderByAttributes);

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
	a.*

FROM `addresses` a{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `address_line_1` ASC, `address_line_2` ASC, `address_line_3` ASC, `address_line_4` ASC, `address_city` ASC, `address_county` ASC, `address_state_or_region` ASC, `address_postal_code` ASC, `address_postal_code_extension` ASC, `address_country` ASC, `address_validated_by_user_flag` ASC, `address_validated_by_web_service_flag` ASC, `address_validation_by_web_service_error_flag` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllAddresses = array();
		while ($row = $db->fetch()) {
			$address_id = $row['id'];
			$address = self::instantiateOrm($database, 'Address', $row, null, $address_id);
			/* @var $address Address */
			$arrAllAddresses[$address_id] = $address;
		}

		$db->free_result();

		self::$_arrAllAddresses = $arrAllAddresses;

		return $arrAllAddresses;
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
INTO `addresses`
(`address_line_1`, `address_line_2`, `address_line_3`, `address_line_4`, `address_city`, `address_county`, `address_state_or_region`, `address_postal_code`, `address_postal_code_extension`, `address_country`, `address_validated_by_user_flag`, `address_validated_by_web_service_flag`, `address_validation_by_web_service_error_flag`)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
ON DUPLICATE KEY UPDATE `address_validated_by_user_flag` = ?, `address_validated_by_web_service_flag` = ?, `address_validation_by_web_service_error_flag` = ?
";
		$arrValues = array($this->address_line_1, $this->address_line_2, $this->address_line_3, $this->address_line_4, $this->address_city, $this->address_county, $this->address_state_or_region, $this->address_postal_code, $this->address_postal_code_extension, $this->address_country, $this->address_validated_by_user_flag, $this->address_validated_by_web_service_flag, $this->address_validation_by_web_service_error_flag, $this->address_validated_by_user_flag, $this->address_validated_by_web_service_flag, $this->address_validation_by_web_service_error_flag);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$address_id = $db->insertId;
		$db->free_result();

		return $address_id;
	}

	// Save: insert ignore

	public static function deriveAbbreviatedStateOrRegion($database, $input)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		if (strlen($input) == 2) {
			$query =
"
SELECT *
FROM `maxmind_states_or_regions`
WHERE `state_or_region` = ?
";
			$arrValues = array($input);
		} else {
			$query =
"
SELECT *
FROM `maxmind_states_or_regions`
WHERE `state_or_region_full_name` = ?
";
			$arrValues = array($input);
		}

		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$state_or_region = $row['state_or_region_full_name'];
			$state_or_region_abbreviated = $row['state_or_region'];
			$country_code = $row['country_code'];
		} else {
			$state_or_region = '';
			$state_or_region_abbreviated = '';
			$country_code = '';
		}

		$address = new Address($database);

		$data = array(
			'address_state_or_region' => $state_or_region,
			'address_state_or_region_abbreviation' => $state_or_region_abbreviated,
			'address_country' => $country_code,
		);
		$address->setData($data);

//		$address->address_state_or_region = $state_or_region;
//		$address->address_state_or_region_abbreviation = $state_or_region_abbreviated;
//		$address->address_country = $country_code;

		$address->convertDataToProperties();

		return $address;
	}

	public static function convertCountryToCountryCode($database, $country)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT `country_code`
FROM `maxmind_country_codes`
WHERE `country` = ?
";
		$arrValues = array($country);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$country_code = $row['country_code'];
		} else {
			$country_code = '';
		}

		return $country_code;
	}

	public static function convertCountryCodeToCountry($database, $country_code)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT `country`
FROM `maxmind_country_codes`
WHERE `country_code` = ?
";
		$arrValues = array($country_code);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$country = $row['country'];
		} else {
			$country = '';
		}

		return $country;
	}

	public function validateByWebService() {
	}

	// Move this to a view Class or a template
	public function getFormattedAddress() {
		$sFormat = '<address>';
		if (!empty($this->first_name)) {
			$sFormat .= htmlentities(stripslashes($this->first_name), ENT_QUOTES);
		}
		if (!empty($this->middle_initial)) {
			$sFormat .= ' ' . htmlentities(stripslashes($this->middle_initial), ENT_QUOTES) . '.';
		}
		if (!empty($this->last_name)) {
			$sFormat .= ' ' . htmlentities(stripslashes($this->last_name), ENT_QUOTES);
		}
		if (!empty($sFormat)) {
			$sFormat .= '<br>';
		}
		if (!empty($this->attention)) {
			$sFormat .= 'ATTN: ' . htmlentities(stripslashes($this->attention), ENT_QUOTES) . '<br>';
		}
		if (!empty($this->line_1)) {
			$sFormat .= htmlentities(stripslashes($this->line_1), ENT_QUOTES) . '<br>';
		}
		if (!empty($this->line_2)) {
			$sFormat .= htmlentities(stripslashes($this->line_2), ENT_QUOTES) . '<br>';
		}
		if (!empty($this->line_3)) {
			$sFormat .= htmlentities(stripslashes($this->line_3), ENT_QUOTES) . '<br>';
		}
		if (!empty($this->city)) {
			$sFormat .= htmlentities(stripslashes($this->city), ENT_QUOTES);
		}
		if (!empty($this->state)) {
			if (!empty($this->city)) {
				$sFormat .= ', ' . htmlentities(stripslashes($this->state), ENT_QUOTES);
			} else {
				$sFormat .= htmlentities(stripslashes($this->state), ENT_QUOTES);
			}
		}
		if (!empty($this->zip)) {
			$sFormat .= ' ' . htmlentities(stripslashes($this->zip), ENT_QUOTES);
		}
		$sFormat .= '<br>';
		if (!empty($this->country)) {
			$sFormat .= htmlentities(stripslashes($this->country), ENT_QUOTES) . '<br>';
		}
		return $sFormat.'</address>';
	}

	/**
	 * Address normalization, standardization, and validation should be used before this method for apples to apples comparison.
	 *
	 * @param Address $address1
	 * @param Address $address2
	 */
	public static function compareAddresses($address1, $address2) {
	}

	/**
	 * Load a list of City, County, State values by postal code.
	 *
	 * Below params are for returned address objects.
	 * @param string $database
	 * @param string $postal_code
	 * @return array of Address Objects
	 */
	public static function loadCityStateCountyGroupingsByPostalCode($database, $address_postal_code)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT mglcl.`city` 'city', mglcl.`state_or_region` 'state_or_region_abbreviation', msor.`state_or_region_full_name` 'state_or_region'
FROM `maxmind_geo_lite_city_locations` mglcl, `maxmind_states_or_regions` msor
WHERE mglcl.`country_code` = 'US'
AND msor.`country_code` = 'US'
AND mglcl.`state_or_region` <> ''
AND mglcl.`state_or_region` IS NOT NULL
AND mglcl.`state_or_region` = msor.`state_or_region`
AND mglcl.`postal_code` = ?
GROUP by mglcl.`city`, mglcl.`state_or_region`
ORDER BY mglcl.`city`, mglcl.`state_or_region`
";
		$arrValues = array($address_postal_code);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$arrAddresses = array();
		while($row = $db->fetch()) {
			$city  = $row['city'];
			$state_or_region = $row['state_or_region'];
			$state_or_region_abbreviation = $row['state_or_region_abbreviation'];

			$data = array(
				'address_city' => $city,
				'address_county' => '',
				'address_state_or_region' => $state_or_region,
				'address_state_or_region_abbreviation' => $state_or_region_abbreviation,
				'address_postal_code' => $address_postal_code,
			);
			$a = new Address($database);
			$a->setData($data);
			$a->convertDataToProperties();
			$arrAddresses[] = $a;
		}
		$db->free_result();

		return $arrAddresses;
	}
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

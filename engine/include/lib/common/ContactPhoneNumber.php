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
 * ContactPhoneNumber.
 *
 * @category   Framework
 * @package    ContactPhoneNumber
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class ContactPhoneNumber extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'ContactPhoneNumber';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'contact_phone_numbers';

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
	 * unique index `unique_contact_phone_number` (`contact_id`,`phone_number_type_id`,`country_code`,`area_code`,`prefix`,`number`,`extension`,`itu`)
	 * unique index `unique_contact_phone_number_by_phone_number_type` (`contact_id`,`phone_number_type_id`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_contact_phone_number' => array(
			'contact_id' => 'int',
			'phone_number_type_id' => 'int',
			'country_code' => 'string',
			'area_code' => 'string',
			'prefix' => 'string',
			'number' => 'string',
			'extension' => 'string',
			'itu' => 'string'
		),
		'unique_contact_phone_number_by_phone_number_type' => array(
			'contact_id' => 'int',
			'phone_number_type_id' => 'int'
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
		'id' => 'contact_phone_number_id',

		'contact_id' => 'contact_id',
		'phone_number_type_id' => 'phone_number_type_id',

		//'mobile_network_carrier_id' => 'mobile_network_carrier_id', // stored in a separate table

		'country_code' => 'country_code',
		'area_code' => 'area_code',
		'prefix' => 'prefix',
		'number' => 'number',
		'extension' => 'extension',
		'itu' => 'itu'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $contact_phone_number_id;

	public $contact_id;
	public $phone_number_type_id;

	public $country_code;
	public $area_code;
	public $prefix;
	public $number;
	public $extension;
	public $itu;

	// Other Properties
	//protected $_otherPropertyHere;
	public $phone_number_type;
	public $mobile_network_carrier_id;

	// HTML ENTITY ENCODED ORM string properties
	public $escaped_country_code;
	public $escaped_area_code;
	public $escaped_prefix;
	public $escaped_number;
	public $escaped_extension;
	public $escaped_itu;

	// HTML ENTITY ENCODED NL2BR ORM string properties
	public $escaped_country_code_nl2br;
	public $escaped_area_code_nl2br;
	public $escaped_prefix_nl2br;
	public $escaped_number_nl2br;
	public $escaped_extension_nl2br;
	public $escaped_itu_nl2br;

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)
	protected static $_arrContactPhoneNumbersByContactId;
	protected static $_arrContactPhoneNumbersByPhoneNumberTypeId;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)
	protected static $_arrContactPhoneNumbersByAreaCodeAndPrefixAndNumber;

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)
	protected static $_arrContactPhoneNumbersByAreaCode;

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllContactPhoneNumbers;

	// Foreign Key Objects
	private $_contact;
	private $_phoneNumberType;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='contact_phone_numbers')
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

	public function getPhoneNumberType()
	{
		if (isset($this->_phoneNumberType)) {
			return $this->_phoneNumberType;
		} else {
			return null;
		}
	}

	public function setPhoneNumberType($phoneNumberType)
	{
		$this->_phoneNumberType = $phoneNumberType;
	}

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)
	public static function getArrContactPhoneNumbersByContactId()
	{
		if (isset(self::$_arrContactPhoneNumbersByContactId)) {
			return self::$_arrContactPhoneNumbersByContactId;
		} else {
			return null;
		}
	}

	public static function setArrContactPhoneNumbersByContactId($arrContactPhoneNumbersByContactId)
	{
		self::$_arrContactPhoneNumbersByContactId = $arrContactPhoneNumbersByContactId;
	}

	public static function getArrContactPhoneNumbersByPhoneNumberTypeId()
	{
		if (isset(self::$_arrContactPhoneNumbersByPhoneNumberTypeId)) {
			return self::$_arrContactPhoneNumbersByPhoneNumberTypeId;
		} else {
			return null;
		}
	}

	public static function setArrContactPhoneNumbersByPhoneNumberTypeId($arrContactPhoneNumbersByPhoneNumberTypeId)
	{
		self::$_arrContactPhoneNumbersByPhoneNumberTypeId = $arrContactPhoneNumbersByPhoneNumberTypeId;
	}

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)
	public static function getArrContactPhoneNumbersByAreaCodeAndPrefixAndNumber()
	{
		if (isset(self::$_arrContactPhoneNumbersByAreaCodeAndPrefixAndNumber)) {
			return self::$_arrContactPhoneNumbersByAreaCodeAndPrefixAndNumber;
		} else {
			return null;
		}
	}

	public static function setArrContactPhoneNumbersByAreaCodeAndPrefixAndNumber($arrContactPhoneNumbersByAreaCodeAndPrefixAndNumber)
	{
		self::$_arrContactPhoneNumbersByAreaCodeAndPrefixAndNumber = $arrContactPhoneNumbersByAreaCodeAndPrefixAndNumber;
	}

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)
	public static function getArrContactPhoneNumbersByAreaCode()
	{
		if (isset(self::$_arrContactPhoneNumbersByAreaCode)) {
			return self::$_arrContactPhoneNumbersByAreaCode;
		} else {
			return null;
		}
	}

	public static function setArrContactPhoneNumbersByAreaCode($arrContactPhoneNumbersByAreaCode)
	{
		self::$_arrContactPhoneNumbersByAreaCode = $arrContactPhoneNumbersByAreaCode;
	}

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllContactPhoneNumbers()
	{
		if (isset(self::$_arrAllContactPhoneNumbers)) {
			return self::$_arrAllContactPhoneNumbers;
		} else {
			return null;
		}
	}

	public static function setArrAllContactPhoneNumbers($arrAllContactPhoneNumbers)
	{
		self::$_arrAllContactPhoneNumbers = $arrAllContactPhoneNumbers;
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
	 * @param int $contact_phone_number_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findById($database, $contact_phone_number_id, $table='contact_phone_numbers', $module='ContactPhoneNumber')
	{
		$contactPhoneNumber = parent::findById($database, $contact_phone_number_id, $table, $module);

		return $contactPhoneNumber;
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Similar to FindById, but with SQL as starter code for more complex joins.
	 *
	 * @param string $database
	 * @param int $contact_phone_number_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findContactPhoneNumberByIdExtended($database, $contact_phone_number_id)
	{
		$contact_phone_number_id = (int) $contact_phone_number_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	cpn_fk_c.`id` AS 'cpn_fk_c__contact_id',
	cpn_fk_c.`user_company_id` AS 'cpn_fk_c__user_company_id',
	cpn_fk_c.`user_id` AS 'cpn_fk_c__user_id',
	cpn_fk_c.`contact_company_id` AS 'cpn_fk_c__contact_company_id',
	cpn_fk_c.`email` AS 'cpn_fk_c__email',
	cpn_fk_c.`name_prefix` AS 'cpn_fk_c__name_prefix',
	cpn_fk_c.`first_name` AS 'cpn_fk_c__first_name',
	cpn_fk_c.`additional_name` AS 'cpn_fk_c__additional_name',
	cpn_fk_c.`middle_name` AS 'cpn_fk_c__middle_name',
	cpn_fk_c.`last_name` AS 'cpn_fk_c__last_name',
	cpn_fk_c.`name_suffix` AS 'cpn_fk_c__name_suffix',
	cpn_fk_c.`title` AS 'cpn_fk_c__title',
	cpn_fk_c.`vendor_flag` AS 'cpn_fk_c__vendor_flag',

	cpn_fk_pnt.`id` AS 'cpn_fk_pnt__phone_number_type_id',
	cpn_fk_pnt.`phone_number_type` AS 'cpn_fk_pnt__phone_number_type',

	cpn.*

FROM `contact_phone_numbers` cpn
	INNER JOIN `contacts` cpn_fk_c ON cpn.`contact_id` = cpn_fk_c.`id`
	INNER JOIN `phone_number_types` cpn_fk_pnt ON cpn.`phone_number_type_id` = cpn_fk_pnt.`id`
WHERE cpn.`id` = ?
";
		$arrValues = array($contact_phone_number_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$contact_phone_number_id = $row['id'];
			$contactPhoneNumber = self::instantiateOrm($database, 'ContactPhoneNumber', $row, null, $contact_phone_number_id);
			/* @var $contactPhoneNumber ContactPhoneNumber */
			$contactPhoneNumber->convertPropertiesToData();

			if (isset($row['contact_id'])) {
				$contact_id = $row['contact_id'];
				$row['cpn_fk_c__id'] = $contact_id;
				$contact = self::instantiateOrm($database, 'Contact', $row, null, $contact_id, 'cpn_fk_c__');
				/* @var $contact Contact */
				$contact->convertPropertiesToData();
			} else {
				$contact = false;
			}
			$contactPhoneNumber->setContact($contact);

			if (isset($row['phone_number_type_id'])) {
				$phone_number_type_id = $row['phone_number_type_id'];
				$row['cpn_fk_pnt__id'] = $phone_number_type_id;
				$phoneNumberType = self::instantiateOrm($database, 'PhoneNumberType', $row, null, $phone_number_type_id, 'cpn_fk_pnt__');
				/* @var $phoneNumberType PhoneNumberType */
				$phoneNumberType->convertPropertiesToData();
			} else {
				$phoneNumberType = false;
			}
			$contactPhoneNumber->setPhoneNumberType($phoneNumberType);

			return $contactPhoneNumber;
		} else {
			return false;
		}
	}

	// Finders: Find By Unique Index
	/**
	 * Find by unique index `unique_contact_phone_number` (`contact_id`,`phone_number_type_id`,`country_code`,`area_code`,`prefix`,`number`,`extension`,`itu`).
	 *
	 * @param string $database
	 * @param int $contact_id
	 * @param int $phone_number_type_id
	 * @param string $country_code
	 * @param string $area_code
	 * @param string $prefix
	 * @param string $number
	 * @param string $extension
	 * @param string $itu
	 * @return mixed (single ORM object | false)
	 */
	public static function findByContactIdAndPhoneNumberTypeIdAndCountryCodeAndAreaCodeAndPrefixAndNumberAndExtensionAndItu($database, $contact_id, $phone_number_type_id, $country_code, $area_code, $prefix, $number, $extension, $itu)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	cpn.*

FROM `contact_phone_numbers` cpn
WHERE cpn.`contact_id` = ?
AND cpn.`phone_number_type_id` = ?
AND cpn.`country_code` = ?
AND cpn.`area_code` = ?
AND cpn.`prefix` = ?
AND cpn.`number` = ?
AND cpn.`extension` = ?
AND cpn.`itu` = ?
";
		$arrValues = array($contact_id, $phone_number_type_id, $country_code, $area_code, $prefix, $number, $extension, $itu);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if ($row && !empty($row)) {
			$contact_phone_number_id = $row['id'];
			$contactPhoneNumber = self::instantiateOrm($database, 'ContactPhoneNumber', $row, null, $contact_phone_number_id);
			/* @var $contactPhoneNumber ContactPhoneNumber */
			return $contactPhoneNumber;
		} else {
			return false;
		}
	}

	/**
	 * Find by unique index `unique_contact_phone_number_by_phone_number_type` (`contact_id`,`phone_number_type_id`).
	 *
	 * @param string $database
	 * @param int $contact_id
	 * @param int $phone_number_type_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findByContactIdAndPhoneNumberTypeId($database, $contact_id, $phone_number_type_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	cpn.*

FROM `contact_phone_numbers` cpn
WHERE cpn.`contact_id` = ?
AND cpn.`phone_number_type_id` = ?
";
		$arrValues = array($contact_id, $phone_number_type_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if ($row && !empty($row)) {
			$contact_phone_number_id = $row['id'];
			$contactPhoneNumber = self::instantiateOrm($database, 'ContactPhoneNumber', $row, null, $contact_phone_number_id);
			/* @var $contactPhoneNumber ContactPhoneNumber */
			return $contactPhoneNumber;
		} else {
			return false;
		}
	}

	// Loaders: Load By pk List (list of auto int ids or other non auto int pk list)
	/**
	 * Load zero or more records by an id list (array of auto int primary keys).
	 *
	 * @param string $database
	 * @param array $arrContactPhoneNumberIds
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadContactPhoneNumbersByArrContactPhoneNumberIds($database, $arrContactPhoneNumberIds, Input $options=null)
	{
		if (empty($arrContactPhoneNumberIds)) {
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
		// ORDER BY `id` ASC, `contact_id` ASC, `phone_number_type_id` ASC, `country_code` ASC, `area_code` ASC, `prefix` ASC, `number` ASC, `extension` ASC, `itu` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpContactPhoneNumber = new ContactPhoneNumber($database);
			$sqlOrderByColumns = $tmpContactPhoneNumber->constructSqlOrderByColumns($arrOrderByAttributes);

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

		foreach ($arrContactPhoneNumberIds as $k => $contact_phone_number_id) {
			$contact_phone_number_id = (int) $contact_phone_number_id;
			$arrContactPhoneNumberIds[$k] = $db->escape($contact_phone_number_id);
		}
		$csvContactPhoneNumberIds = join(',', $arrContactPhoneNumberIds);

		$query =
"
SELECT

	cpn.*

FROM `contact_phone_numbers` cpn
WHERE cpn.`id` IN ($csvContactPhoneNumberIds){$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		$arrContactPhoneNumbersByCsvContactPhoneNumberIds = array();
		while ($row = $db->fetch()) {
			$contact_phone_number_id = $row['id'];
			$contactPhoneNumber = self::instantiateOrm($database, 'ContactPhoneNumber', $row, null, $contact_phone_number_id);
			/* @var $contactPhoneNumber ContactPhoneNumber */
			$contactPhoneNumber->convertPropertiesToData();

			$arrContactPhoneNumbersByCsvContactPhoneNumberIds[$contact_phone_number_id] = $contactPhoneNumber;
		}

		$db->free_result();

		return $arrContactPhoneNumbersByCsvContactPhoneNumberIds;
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `contact_phone_numbers_fk_c` foreign key (`contact_id`) references `contacts` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $contact_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadContactPhoneNumbersByContactId($database, $contact_id, Input $options=null)
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
			self::$_arrContactPhoneNumbersByContactId = null;
		}

		$arrContactPhoneNumbersByContactId = self::$_arrContactPhoneNumbersByContactId;
		if (isset($arrContactPhoneNumbersByContactId) && !empty($arrContactPhoneNumbersByContactId)) {
			return $arrContactPhoneNumbersByContactId;
		}

		$contact_id = (int) $contact_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `contact_id` ASC, `phone_number_type_id` ASC, `country_code` ASC, `area_code` ASC, `prefix` ASC, `number` ASC, `extension` ASC, `itu` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpContactPhoneNumber = new ContactPhoneNumber($database);
			$sqlOrderByColumns = $tmpContactPhoneNumber->constructSqlOrderByColumns($arrOrderByAttributes);

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
	cpn.*

FROM `contact_phone_numbers` cpn
WHERE cpn.`contact_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `contact_id` ASC, `phone_number_type_id` ASC, `country_code` ASC, `area_code` ASC, `prefix` ASC, `number` ASC, `extension` ASC, `itu` ASC
		$arrValues = array($contact_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrContactPhoneNumbersByContactId = array();
		while ($row = $db->fetch()) {
			$contact_phone_number_id = $row['id'];
			$contactPhoneNumber = self::instantiateOrm($database, 'ContactPhoneNumber', $row, null, $contact_phone_number_id);
			/* @var $contactPhoneNumber ContactPhoneNumber */
			$arrContactPhoneNumbersByContactId[$contact_phone_number_id] = $contactPhoneNumber;
		}

		$db->free_result();

		self::$_arrContactPhoneNumbersByContactId = $arrContactPhoneNumbersByContactId;

		return $arrContactPhoneNumbersByContactId;
	}

	/**
	 * Load by constraint `contact_phone_numbers_fk_pnt` foreign key (`phone_number_type_id`) references `phone_number_types` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $phone_number_type_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadContactPhoneNumbersByPhoneNumberTypeId($database, $phone_number_type_id, Input $options=null)
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
			self::$_arrContactPhoneNumbersByPhoneNumberTypeId = null;
		}

		$arrContactPhoneNumbersByPhoneNumberTypeId = self::$_arrContactPhoneNumbersByPhoneNumberTypeId;
		if (isset($arrContactPhoneNumbersByPhoneNumberTypeId) && !empty($arrContactPhoneNumbersByPhoneNumberTypeId)) {
			return $arrContactPhoneNumbersByPhoneNumberTypeId;
		}

		$phone_number_type_id = (int) $phone_number_type_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `contact_id` ASC, `phone_number_type_id` ASC, `country_code` ASC, `area_code` ASC, `prefix` ASC, `number` ASC, `extension` ASC, `itu` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpContactPhoneNumber = new ContactPhoneNumber($database);
			$sqlOrderByColumns = $tmpContactPhoneNumber->constructSqlOrderByColumns($arrOrderByAttributes);

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
	cpn.*

FROM `contact_phone_numbers` cpn
WHERE cpn.`phone_number_type_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `contact_id` ASC, `phone_number_type_id` ASC, `country_code` ASC, `area_code` ASC, `prefix` ASC, `number` ASC, `extension` ASC, `itu` ASC
		$arrValues = array($phone_number_type_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrContactPhoneNumbersByPhoneNumberTypeId = array();
		while ($row = $db->fetch()) {
			$contact_phone_number_id = $row['id'];
			$contactPhoneNumber = self::instantiateOrm($database, 'ContactPhoneNumber', $row, null, $contact_phone_number_id);
			/* @var $contactPhoneNumber ContactPhoneNumber */
			$arrContactPhoneNumbersByPhoneNumberTypeId[$contact_phone_number_id] = $contactPhoneNumber;
		}

		$db->free_result();

		self::$_arrContactPhoneNumbersByPhoneNumberTypeId = $arrContactPhoneNumbersByPhoneNumberTypeId;

		return $arrContactPhoneNumbersByPhoneNumberTypeId;
	}

	// Loaders: Load By index
	/**
	 * Load by key `phone_number` (`area_code`,`prefix`,`number`).
	 *
	 * @param string $database
	 * @param string $area_code
	 * @param string $prefix
	 * @param string $number
	 * @param mixed (Input $options object | null)
	 * @return mixed (single ORM object | false)
	 */
	public static function loadContactPhoneNumbersByAreaCodeAndPrefixAndNumber($database, $area_code, $prefix, $number, Input $options=null)
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
			self::$_arrContactPhoneNumbersByAreaCodeAndPrefixAndNumber = null;
		}

		$arrContactPhoneNumbersByAreaCodeAndPrefixAndNumber = self::$_arrContactPhoneNumbersByAreaCodeAndPrefixAndNumber;
		if (isset($arrContactPhoneNumbersByAreaCodeAndPrefixAndNumber) && !empty($arrContactPhoneNumbersByAreaCodeAndPrefixAndNumber)) {
			return $arrContactPhoneNumbersByAreaCodeAndPrefixAndNumber;
		}

		$area_code = (string) $area_code;
		$prefix = (string) $prefix;
		$number = (string) $number;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `contact_id` ASC, `phone_number_type_id` ASC, `country_code` ASC, `area_code` ASC, `prefix` ASC, `number` ASC, `extension` ASC, `itu` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpContactPhoneNumber = new ContactPhoneNumber($database);
			$sqlOrderByColumns = $tmpContactPhoneNumber->constructSqlOrderByColumns($arrOrderByAttributes);

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
	cpn.*

FROM `contact_phone_numbers` cpn
WHERE cpn.`area_code` = ?
AND cpn.`prefix` = ?
AND cpn.`number` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `contact_id` ASC, `phone_number_type_id` ASC, `country_code` ASC, `area_code` ASC, `prefix` ASC, `number` ASC, `extension` ASC, `itu` ASC
		$arrValues = array($area_code, $prefix, $number);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrContactPhoneNumbersByAreaCodeAndPrefixAndNumber = array();
		while ($row = $db->fetch()) {
			$contact_phone_number_id = $row['id'];
			$contactPhoneNumber = self::instantiateOrm($database, 'ContactPhoneNumber', $row, null, $contact_phone_number_id);
			/* @var $contactPhoneNumber ContactPhoneNumber */
			$arrContactPhoneNumbersByAreaCodeAndPrefixAndNumber[$contact_phone_number_id] = $contactPhoneNumber;
		}

		$db->free_result();

		self::$_arrContactPhoneNumbersByAreaCodeAndPrefixAndNumber = $arrContactPhoneNumbersByAreaCodeAndPrefixAndNumber;

		return $arrContactPhoneNumbersByAreaCodeAndPrefixAndNumber;
	}

	// Loaders: Load By additionally indexed attribute
	/**
	 * Load by leftmost indexed attribute: key `phone_number` (`area_code`,`prefix`,`number`).
	 *
	 * @param string $database
	 * @param string $area_code
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadContactPhoneNumbersByAreaCode($database, $area_code, Input $options=null)
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
			self::$_arrContactPhoneNumbersByAreaCode = null;
		}

		$arrContactPhoneNumbersByAreaCode = self::$_arrContactPhoneNumbersByAreaCode;
		if (isset($arrContactPhoneNumbersByAreaCode) && !empty($arrContactPhoneNumbersByAreaCode)) {
			return $arrContactPhoneNumbersByAreaCode;
		}

		$area_code = (string) $area_code;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `contact_id` ASC, `phone_number_type_id` ASC, `country_code` ASC, `area_code` ASC, `prefix` ASC, `number` ASC, `extension` ASC, `itu` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpContactPhoneNumber = new ContactPhoneNumber($database);
			$sqlOrderByColumns = $tmpContactPhoneNumber->constructSqlOrderByColumns($arrOrderByAttributes);

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
	cpn.*

FROM `contact_phone_numbers` cpn
WHERE cpn.`area_code` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `contact_id` ASC, `phone_number_type_id` ASC, `country_code` ASC, `area_code` ASC, `prefix` ASC, `number` ASC, `extension` ASC, `itu` ASC
		$arrValues = array($area_code);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrContactPhoneNumbersByAreaCode = array();
		while ($row = $db->fetch()) {
			$contact_phone_number_id = $row['id'];
			$contactPhoneNumber = self::instantiateOrm($database, 'ContactPhoneNumber', $row, null, $contact_phone_number_id);
			/* @var $contactPhoneNumber ContactPhoneNumber */
			$arrContactPhoneNumbersByAreaCode[$contact_phone_number_id] = $contactPhoneNumber;
		}

		$db->free_result();

		self::$_arrContactPhoneNumbersByAreaCode = $arrContactPhoneNumbersByAreaCode;

		return $arrContactPhoneNumbersByAreaCode;
	}

	// Loaders: Load All Records
	/**
	 * Load all contact_phone_numbers records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllContactPhoneNumbers($database, Input $options=null)
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
			self::$_arrAllContactPhoneNumbers = null;
		}

		$arrAllContactPhoneNumbers = self::$_arrAllContactPhoneNumbers;
		if (isset($arrAllContactPhoneNumbers) && !empty($arrAllContactPhoneNumbers)) {
			return $arrAllContactPhoneNumbers;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `contact_id` ASC, `phone_number_type_id` ASC, `country_code` ASC, `area_code` ASC, `prefix` ASC, `number` ASC, `extension` ASC, `itu` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpContactPhoneNumber = new ContactPhoneNumber($database);
			$sqlOrderByColumns = $tmpContactPhoneNumber->constructSqlOrderByColumns($arrOrderByAttributes);

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
	cpn.*

FROM `contact_phone_numbers` cpn{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `contact_id` ASC, `phone_number_type_id` ASC, `country_code` ASC, `area_code` ASC, `prefix` ASC, `number` ASC, `extension` ASC, `itu` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllContactPhoneNumbers = array();
		while ($row = $db->fetch()) {
			$contact_phone_number_id = $row['id'];
			$contactPhoneNumber = self::instantiateOrm($database, 'ContactPhoneNumber', $row, null, $contact_phone_number_id);
			/* @var $contactPhoneNumber ContactPhoneNumber */
			$arrAllContactPhoneNumbers[$contact_phone_number_id] = $contactPhoneNumber;
		}

		$db->free_result();

		self::$_arrAllContactPhoneNumbers = $arrAllContactPhoneNumbers;

		return $arrAllContactPhoneNumbers;
	}

	// Save: insert on duplicate key update

	// Save: insert ignore

	public function parsePhoneNumber()
	{
		$area_code = $this->area_code;
		$prefix = $this->prefix;
		$number = $this->number;

		$mobile_phone_number = $area_code.$prefix.$number;
		$this->mobile_phone_number = $mobile_phone_number;
	}

	public function getFormattedNumber()
	{
		$formattedPhoneNumber = '('.$this->area_code.') '.$this->prefix.'-'.$this->number;

		return $formattedPhoneNumber;
	}

	/**
	 * Load a list of phone numbers for a given contact.
	 *
	 * $desiredPhoneNumberType:
	 *
	 * PhoneNumberType::BUSINESS
	 * PhoneNumberType::BUSINESS_FAX
	 *
	 * @param string $database
	 * @param int $contact_id
	 * @param int $desiredPhoneNumberType
	 * @return array ContactPhoneNumber Objects
	 */
	public static function loadContactPhoneNumbersListByContactId($database, $contact_id, $desiredPhoneNumberType=false)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		if (isset($desiredPhoneNumberType) && !empty($desiredPhoneNumberType)) {
			$and = "AND pnt.`id` = $desiredPhoneNumberType ";
		} else {
			$and = "";
		}

		$query =
"
SELECT
	cpn.*,
	pnt.`phone_number_type`,
	cpns.`mobile_network_carrier_id`
FROM
	`phone_number_types` pnt,
	`contact_phone_numbers` cpn LEFT OUTER JOIN `mobile_phone_numbers` cpns ON cpn.`contact_id` = cpns.`contact_id`
WHERE cpn.`contact_id` = ?
AND cpn.`phone_number_type_id` = pnt.`id`
$and
ORDER BY
	pnt.`phone_number_type`,
	`country_code`,
	`area_code`,
	`prefix`,
	`number`,
	`extension`,
	`itu`
";
		$contact_id = (int) $contact_id;
		$arrValues = array($contact_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrRecords = array();
		while ($row = $db->fetch()) {
			// This value comes from a separate table
			$phone_number_type = $row['phone_number_type'];

			// This value comes from a separate table
			$mobile_network_carrier_id = $row['mobile_network_carrier_id'];

			$cpn = new ContactPhoneNumber($database);
			$cpn->setData($row);
			$cpn->convertDataToProperties();
			$cpn->phone_number_type = $phone_number_type;
			$cpn->mobile_network_carrier_id = $mobile_network_carrier_id;
			$arrRecords[] = $cpn;
		}
		$db->free_result();

		return $arrRecords;
	}

	/**
	 * Load a list of phone numbers for a given contact.
	 *
	 * $desiredPhoneNumberType:
	 *
	 * PhoneNumberType::BUSINESS
	 * PhoneNumberType::BUSINESS_FAX
	 *
	 * @param string $database
	 * @param int $contact_id
	 * @param int $desiredPhoneNumberType
	 * @return array ContactPhoneNumber Objects
	 */
	public static function loadContactCompanyPhoneNumbersListByContactCompanyId($database, $contact_company_id, $desiredPhoneNumberType=false)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		if (isset($desiredPhoneNumberType) && !empty($desiredPhoneNumberType)) {
			$and = "AND pnt.`id` = $desiredPhoneNumberType ";
		} else {
			$and = "";
		}

		$query =
"
SELECT cpn.*, pnt.`phone_number_type`
FROM `contacts` c,`contact_phone_numbers` cpn, `phone_number_types` pnt
WHERE c.`contact_company_id` = ?
AND c.`id` = cpn.`contact_id`
AND cpn.`phone_number_type_id` = pnt.`id`
$and
GROUP BY area_code, prefix, number
ORDER BY pnt.`phone_number_type`, `country_code`, `area_code`, `prefix`, `number`, `extension`, `itu`
";
		$arrValues = array($contact_company_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrRecords = array();
		while ($row = $db->fetch()) {
			$phone_number_type = $row['phone_number_type'];
			$cpn = new ContactPhoneNumber($database);
			$cpn->setData($row);
			$cpn->convertDataToProperties();
			$cpn->phone_number_type = $phone_number_type;
			$arrRecords[] = $cpn;
		}
		$db->free_result();

		return $arrRecords;
	}

	/**
	 * Conditionally invoke the standard save() method after deltification.
	 *
	 */
	public function deltifyAndSave()
	{
		//load existing

		//deltify

		//save (insert, update, or do nothing)

		$this->convertPropertiesToData();
		$newData = $this->getData();
		$row = $newData;

		// GUIDs/ID, etc.
		// unique index(`contact_id`, `phone_number_type_id`, `country_code`, `area_code`, `prefix`, `number`, `extension`, `itu`)
		$contact_id = (int) $this->contact_id;
		$phone_number_type_id = (int) $this->phone_number_type_id;
		$country_code = (string) $this->country_code;
		$area_code = (string) $this->area_code;
		$prefix = (string) $this->prefix;
		$number = (string) $this->number;
		$extension = (string) $this->extension;
		$itu = (string) $this->itu;

		$key = array(
			'contact_id' => $contact_id,
			'phone_number_type_id' => $phone_number_type_id,
			'country_code' => $country_code,
			'area_code' => $area_code,
			'prefix' => $prefix,
			'number' => $number,
			'extension' => $extension,
			'itu' => $itu
		);

		$database = $this->getDatabase();
		$tmpObject = new ContactPhoneNumber($database);
		$tmpObject->setKey($key);
		$tmpObject->load();

		/**
		 * Conditionally Insert/Update the record.
		 *
		 * $key is conditionally set based on if record exists.
		 */
		$newData = $row;

		//Iterate over latest input from data feed and only set different values.
		//Same values will be key unset to acheive a conditional update.
		$save = false;
		$existsFlag = $tmpObject->isDataLoaded();
		if ($existsFlag) {
			// Conditionally Update the record
			// Don't compare the key values that loaded the record.
			$id = $tmpObject->id;
			unset($tmpObject->id);

			$existingData = $tmpObject->getData();

			$data = Data::deltify($existingData, $newData);
			if (!empty($data)) {
				$tmpObject->setData($data);
				$save = true;
			}
		} else {
			// Insert the record
			$tmpObject->setKey(null);
			$tmpObject->setData($newData);
			$save = true;
		}

		// Save if needed (conditionally Insert/Update)
		if ($save) {
			$id = $tmpObject->save();

			if (isset($id) && ($id != 0)) {
				$this->setId($id);
			}
		}

		return $id;
	}
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

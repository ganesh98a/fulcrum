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
 * ContactCompanyOfficePhoneNumber.
 *
 * @category   Framework
 * @package    ContactCompanyOfficePhoneNumber
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class ContactCompanyOfficePhoneNumber extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'ContactCompanyOfficePhoneNumber';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'contact_company_office_phone_numbers';

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
	 * unique index `unique_contact_company_office_phone_number` (`contact_company_office_id`,`phone_number_type_id`,`country_code`,`area_code`,`prefix`,`number`,`extension`,`itu`)
	 * unique index `unique_office_phone_number_by_type` (`contact_company_office_id`,`phone_number_type_id`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_contact_company_office_phone_number' => array(
			'contact_company_office_id' => 'int',
			'phone_number_type_id' => 'int',
			'country_code' => 'string',
			'area_code' => 'string',
			'prefix' => 'string',
			'number' => 'string',
			'extension' => 'string',
			'itu' => 'string'
		),
		'unique_office_phone_number_by_type' => array(
			'contact_company_office_id' => 'int',
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
		'id' => 'contact_company_office_phone_number_id',

		'contact_company_office_id' => 'contact_company_office_id',
		'phone_number_type_id' => 'phone_number_type_id',

		'country_code' => 'country_code',
		'area_code' => 'area_code',
		'prefix' => 'prefix',
		'number' => 'number',
		'extension' => 'extension',
		'itu' => 'itu'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $contact_company_office_phone_number_id;

	public $contact_company_office_id;
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
	protected static $_arrContactCompanyOfficePhoneNumbersByContactCompanyOfficeId;
	protected static $_arrContactCompanyOfficePhoneNumbersByPhoneNumberTypeId;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)
	protected static $_arrContactCompanyOfficePhoneNumbersByAreaCodeAndPrefixAndNumber;
	protected static $_arrContactCompanyOfficePhoneNumbersByContactCompanyOfficeIdAndPhoneNumberTypeId;

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)
	protected static $_arrContactCompanyOfficePhoneNumbersByAreaCode;

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllContactCompanyOfficePhoneNumbers;

	// Foreign Key Objects
	private $_contactCompanyOffice;
	private $_phoneNumberType;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='contact_company_office_phone_numbers')
	{
		parent::__construct($table);
		$this->setDatabase($database);
	}

	// Foreign Key Object Accessor Methods
	public function getContactCompanyOffice()
	{
		if (isset($this->_contactCompanyOffice)) {
			return $this->_contactCompanyOffice;
		} else {
			return null;
		}
	}

	public function setContactCompanyOffice($contactCompanyOffice)
	{
		$this->_contactCompanyOffice = $contactCompanyOffice;
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
	public static function getArrContactCompanyOfficePhoneNumbersByContactCompanyOfficeId()
	{
		if (isset(self::$_arrContactCompanyOfficePhoneNumbersByContactCompanyOfficeId)) {
			return self::$_arrContactCompanyOfficePhoneNumbersByContactCompanyOfficeId;
		} else {
			return null;
		}
	}

	public static function setArrContactCompanyOfficePhoneNumbersByContactCompanyOfficeId($arrContactCompanyOfficePhoneNumbersByContactCompanyOfficeId)
	{
		self::$_arrContactCompanyOfficePhoneNumbersByContactCompanyOfficeId = $arrContactCompanyOfficePhoneNumbersByContactCompanyOfficeId;
	}

	public static function getArrContactCompanyOfficePhoneNumbersByPhoneNumberTypeId()
	{
		if (isset(self::$_arrContactCompanyOfficePhoneNumbersByPhoneNumberTypeId)) {
			return self::$_arrContactCompanyOfficePhoneNumbersByPhoneNumberTypeId;
		} else {
			return null;
		}
	}

	public static function setArrContactCompanyOfficePhoneNumbersByPhoneNumberTypeId($arrContactCompanyOfficePhoneNumbersByPhoneNumberTypeId)
	{
		self::$_arrContactCompanyOfficePhoneNumbersByPhoneNumberTypeId = $arrContactCompanyOfficePhoneNumbersByPhoneNumberTypeId;
	}

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)
	public static function getArrContactCompanyOfficePhoneNumbersByAreaCodeAndPrefixAndNumber()
	{
		if (isset(self::$_arrContactCompanyOfficePhoneNumbersByAreaCodeAndPrefixAndNumber)) {
			return self::$_arrContactCompanyOfficePhoneNumbersByAreaCodeAndPrefixAndNumber;
		} else {
			return null;
		}
	}

	public static function setArrContactCompanyOfficePhoneNumbersByAreaCodeAndPrefixAndNumber($arrContactCompanyOfficePhoneNumbersByAreaCodeAndPrefixAndNumber)
	{
		self::$_arrContactCompanyOfficePhoneNumbersByAreaCodeAndPrefixAndNumber = $arrContactCompanyOfficePhoneNumbersByAreaCodeAndPrefixAndNumber;
	}

	public static function getArrContactCompanyOfficePhoneNumbersByContactCompanyOfficeIdAndPhoneNumberTypeId()
	{
		if (isset(self::$_arrContactCompanyOfficePhoneNumbersByContactCompanyOfficeIdAndPhoneNumberTypeId)) {
			return self::$_arrContactCompanyOfficePhoneNumbersByContactCompanyOfficeIdAndPhoneNumberTypeId;
		} else {
			return null;
		}
	}

	public static function setArrContactCompanyOfficePhoneNumbersByContactCompanyOfficeIdAndPhoneNumberTypeId($arrContactCompanyOfficePhoneNumbersByContactCompanyOfficeIdAndPhoneNumberTypeId)
	{
		self::$_arrContactCompanyOfficePhoneNumbersByContactCompanyOfficeIdAndPhoneNumberTypeId = $arrContactCompanyOfficePhoneNumbersByContactCompanyOfficeIdAndPhoneNumberTypeId;
	}

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)
	public static function getArrContactCompanyOfficePhoneNumbersByAreaCode()
	{
		if (isset(self::$_arrContactCompanyOfficePhoneNumbersByAreaCode)) {
			return self::$_arrContactCompanyOfficePhoneNumbersByAreaCode;
		} else {
			return null;
		}
	}

	public static function setArrContactCompanyOfficePhoneNumbersByAreaCode($arrContactCompanyOfficePhoneNumbersByAreaCode)
	{
		self::$_arrContactCompanyOfficePhoneNumbersByAreaCode = $arrContactCompanyOfficePhoneNumbersByAreaCode;
	}

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllContactCompanyOfficePhoneNumbers()
	{
		if (isset(self::$_arrAllContactCompanyOfficePhoneNumbers)) {
			return self::$_arrAllContactCompanyOfficePhoneNumbers;
		} else {
			return null;
		}
	}

	public static function setArrAllContactCompanyOfficePhoneNumbers($arrAllContactCompanyOfficePhoneNumbers)
	{
		self::$_arrAllContactCompanyOfficePhoneNumbers = $arrAllContactCompanyOfficePhoneNumbers;
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

	public function getFormattedPhoneNumber()
	{
		$formattedPhoneNumber = "($this->area_code) {$this->prefix}-{$this->number}";

		return $formattedPhoneNumber;
	}

	// Finder: Find By pk (a single auto int id or a single non auto int pk)
	/**
	 * PHP < 5.3.0
	 *
	 * @param string $database
	 * @param int $contact_company_office_phone_number_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findById($database, $contact_company_office_phone_number_id, $table='contact_company_office_phone_numbers', $module='ContactCompanyOfficePhoneNumber')
	{
		$contactCompanyOfficePhoneNumber = parent::findById($database, $contact_company_office_phone_number_id, $table, $module);

		return $contactCompanyOfficePhoneNumber;
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Similar to FindById, but with SQL as starter code for more complex joins.
	 *
	 * @param string $database
	 * @param int $contact_company_office_phone_number_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findContactCompanyOfficePhoneNumberByIdExtended($database, $contact_company_office_phone_number_id)
	{
		$contact_company_office_phone_number_id = (int) $contact_company_office_phone_number_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	ccopn_fk_cco.`id` AS 'ccopn_fk_cco__contact_company_office_id',
	ccopn_fk_cco.`contact_company_id` AS 'ccopn_fk_cco__contact_company_id',
	ccopn_fk_cco.`office_nickname` AS 'ccopn_fk_cco__office_nickname',
	ccopn_fk_cco.`address_line_1` AS 'ccopn_fk_cco__address_line_1',
	ccopn_fk_cco.`address_line_2` AS 'ccopn_fk_cco__address_line_2',
	ccopn_fk_cco.`address_line_3` AS 'ccopn_fk_cco__address_line_3',
	ccopn_fk_cco.`address_line_4` AS 'ccopn_fk_cco__address_line_4',
	ccopn_fk_cco.`address_city` AS 'ccopn_fk_cco__address_city',
	ccopn_fk_cco.`address_county` AS 'ccopn_fk_cco__address_county',
	ccopn_fk_cco.`address_state_or_region` AS 'ccopn_fk_cco__address_state_or_region',
	ccopn_fk_cco.`address_postal_code` AS 'ccopn_fk_cco__address_postal_code',
	ccopn_fk_cco.`address_postal_code_extension` AS 'ccopn_fk_cco__address_postal_code_extension',
	ccopn_fk_cco.`address_country` AS 'ccopn_fk_cco__address_country',
	ccopn_fk_cco.`head_quarters_flag` AS 'ccopn_fk_cco__head_quarters_flag',
	ccopn_fk_cco.`address_validated_by_user_flag` AS 'ccopn_fk_cco__address_validated_by_user_flag',
	ccopn_fk_cco.`address_validated_by_web_service_flag` AS 'ccopn_fk_cco__address_validated_by_web_service_flag',
	ccopn_fk_cco.`address_validation_by_web_service_error_flag` AS 'ccopn_fk_cco__address_validation_by_web_service_error_flag',

	ccopn_fk_pnt.`id` AS 'ccopn_fk_pnt__phone_number_type_id',
	ccopn_fk_pnt.`phone_number_type` AS 'ccopn_fk_pnt__phone_number_type',

	ccopn.*

FROM `contact_company_office_phone_numbers` ccopn
	INNER JOIN `contact_company_offices` ccopn_fk_cco ON ccopn.`contact_company_office_id` = ccopn_fk_cco.`id`
	INNER JOIN `phone_number_types` ccopn_fk_pnt ON ccopn.`phone_number_type_id` = ccopn_fk_pnt.`id`
WHERE ccopn.`id` = ?
";
		$arrValues = array($contact_company_office_phone_number_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$contact_company_office_phone_number_id = $row['id'];
			$contactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $contact_company_office_phone_number_id);
			/* @var $contactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
			$contactCompanyOfficePhoneNumber->convertPropertiesToData();

			if (isset($row['contact_company_office_id'])) {
				$contact_company_office_id = $row['contact_company_office_id'];
				$row['ccopn_fk_cco__id'] = $contact_company_office_id;
				$contactCompanyOffice = self::instantiateOrm($database, 'ContactCompanyOffice', $row, null, $contact_company_office_id, 'ccopn_fk_cco__');
				/* @var $contactCompanyOffice ContactCompanyOffice */
				$contactCompanyOffice->convertPropertiesToData();
			} else {
				$contactCompanyOffice = false;
			}
			$contactCompanyOfficePhoneNumber->setContactCompanyOffice($contactCompanyOffice);

			if (isset($row['phone_number_type_id'])) {
				$phone_number_type_id = $row['phone_number_type_id'];
				$row['ccopn_fk_pnt__id'] = $phone_number_type_id;
				$phoneNumberType = self::instantiateOrm($database, 'PhoneNumberType', $row, null, $phone_number_type_id, 'ccopn_fk_pnt__');
				/* @var $phoneNumberType PhoneNumberType */
				$phoneNumberType->convertPropertiesToData();
			} else {
				$phoneNumberType = false;
			}
			$contactCompanyOfficePhoneNumber->setPhoneNumberType($phoneNumberType);

			return $contactCompanyOfficePhoneNumber;
		} else {
			return false;
		}
	}

	// Finders: Find By Unique Index
	/**
	 * Find by unique index `unique_contact_company_office_phone_number` (`contact_company_office_id`,`phone_number_type_id`,`country_code`,`area_code`,`prefix`,`number`,`extension`,`itu`).
	 *
	 * @param string $database
	 * @param int $contact_company_office_id
	 * @param int $phone_number_type_id
	 * @param string $country_code
	 * @param string $area_code
	 * @param string $prefix
	 * @param string $number
	 * @param string $extension
	 * @param string $itu
	 * @return mixed (single ORM object | false)
	 */
	public static function findByContactCompanyOfficeIdAndPhoneNumberTypeIdAndCountryCodeAndAreaCodeAndPrefixAndNumberAndExtensionAndItu($database, $contact_company_office_id, $phone_number_type_id, $country_code, $area_code, $prefix, $number, $extension, $itu)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	ccopn.*

FROM `contact_company_office_phone_numbers` ccopn
WHERE ccopn.`contact_company_office_id` = ?
AND ccopn.`phone_number_type_id` = ?
AND ccopn.`country_code` = ?
AND ccopn.`area_code` = ?
AND ccopn.`prefix` = ?
AND ccopn.`number` = ?
AND ccopn.`extension` = ?
AND ccopn.`itu` = ?
";
		$arrValues = array($contact_company_office_id, $phone_number_type_id, $country_code, $area_code, $prefix, $number, $extension, $itu);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if ($row && !empty($row)) {
			$contact_company_office_phone_number_id = $row['id'];
			$contactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $contact_company_office_phone_number_id);
			/* @var $contactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
			return $contactCompanyOfficePhoneNumber;
		} else {
			return false;
		}
	}

	/**
	 * Find by unique index `unique_office_phone_number_by_type` (`contact_company_office_id`,`phone_number_type_id`).
	 *
	 * @param string $database
	 * @param int $contact_company_office_id
	 * @param int $phone_number_type_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findByContactCompanyOfficeIdAndPhoneNumberTypeId($database, $contact_company_office_id, $phone_number_type_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	ccopn.*

FROM `contact_company_office_phone_numbers` ccopn
WHERE ccopn.`contact_company_office_id` = ?
AND ccopn.`phone_number_type_id` = ?
";
		$arrValues = array($contact_company_office_id, $phone_number_type_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if ($row && !empty($row)) {
			$contact_company_office_phone_number_id = $row['id'];
			$contactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $contact_company_office_phone_number_id);
			/* @var $contactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
			return $contactCompanyOfficePhoneNumber;
		} else {
			return false;
		}
	}

	// Loaders: Load By pk List (list of auto int ids or other non auto int pk list)
	/**
	 * Load zero or more records by an id list (array of auto int primary keys).
	 *
	 * @param string $database
	 * @param array $arrContactCompanyOfficePhoneNumberIds
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadContactCompanyOfficePhoneNumbersByArrContactCompanyOfficePhoneNumberIds($database, $arrContactCompanyOfficePhoneNumberIds, Input $options=null)
	{
		if (empty($arrContactCompanyOfficePhoneNumberIds)) {
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
		// ORDER BY `id` ASC, `contact_company_office_id` ASC, `phone_number_type_id` ASC, `country_code` ASC, `area_code` ASC, `prefix` ASC, `number` ASC, `extension` ASC, `itu` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpContactCompanyOfficePhoneNumber = new ContactCompanyOfficePhoneNumber($database);
			$sqlOrderByColumns = $tmpContactCompanyOfficePhoneNumber->constructSqlOrderByColumns($arrOrderByAttributes);

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

		foreach ($arrContactCompanyOfficePhoneNumberIds as $k => $contact_company_office_phone_number_id) {
			$contact_company_office_phone_number_id = (int) $contact_company_office_phone_number_id;
			$arrContactCompanyOfficePhoneNumberIds[$k] = $db->escape($contact_company_office_phone_number_id);
		}
		$csvContactCompanyOfficePhoneNumberIds = join(',', $arrContactCompanyOfficePhoneNumberIds);

		$query =
"
SELECT

	ccopn.*

FROM `contact_company_office_phone_numbers` ccopn
WHERE ccopn.`id` IN ($csvContactCompanyOfficePhoneNumberIds){$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		$arrContactCompanyOfficePhoneNumbersByCsvContactCompanyOfficePhoneNumberIds = array();
		while ($row = $db->fetch()) {
			$contact_company_office_phone_number_id = $row['id'];
			$contactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $contact_company_office_phone_number_id);
			/* @var $contactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
			$contactCompanyOfficePhoneNumber->convertPropertiesToData();

			$arrContactCompanyOfficePhoneNumbersByCsvContactCompanyOfficePhoneNumberIds[$contact_company_office_phone_number_id] = $contactCompanyOfficePhoneNumber;
		}

		$db->free_result();

		return $arrContactCompanyOfficePhoneNumbersByCsvContactCompanyOfficePhoneNumberIds;
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `contact_company_office_phone_numbers_fk_cco` foreign key (`contact_company_office_id`) references `contact_company_offices` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $contact_company_office_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadContactCompanyOfficePhoneNumbersByContactCompanyOfficeId($database, $contact_company_office_id, Input $options=null)
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
			self::$_arrContactCompanyOfficePhoneNumbersByContactCompanyOfficeId = null;
		}

		$arrContactCompanyOfficePhoneNumbersByContactCompanyOfficeId = self::$_arrContactCompanyOfficePhoneNumbersByContactCompanyOfficeId;
		if (isset($arrContactCompanyOfficePhoneNumbersByContactCompanyOfficeId) && !empty($arrContactCompanyOfficePhoneNumbersByContactCompanyOfficeId)) {
			return $arrContactCompanyOfficePhoneNumbersByContactCompanyOfficeId;
		}

		$contact_company_office_id = (int) $contact_company_office_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `contact_company_office_id` ASC, `phone_number_type_id` ASC, `country_code` ASC, `area_code` ASC, `prefix` ASC, `number` ASC, `extension` ASC, `itu` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpContactCompanyOfficePhoneNumber = new ContactCompanyOfficePhoneNumber($database);
			$sqlOrderByColumns = $tmpContactCompanyOfficePhoneNumber->constructSqlOrderByColumns($arrOrderByAttributes);

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
	ccopn.*

FROM `contact_company_office_phone_numbers` ccopn
WHERE ccopn.`contact_company_office_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `contact_company_office_id` ASC, `phone_number_type_id` ASC, `country_code` ASC, `area_code` ASC, `prefix` ASC, `number` ASC, `extension` ASC, `itu` ASC
		$arrValues = array($contact_company_office_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrContactCompanyOfficePhoneNumbersByContactCompanyOfficeId = array();
		while ($row = $db->fetch()) {
			$contact_company_office_phone_number_id = $row['id'];
			$contactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $contact_company_office_phone_number_id);
			/* @var $contactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
			$arrContactCompanyOfficePhoneNumbersByContactCompanyOfficeId[$contact_company_office_phone_number_id] = $contactCompanyOfficePhoneNumber;
		}

		$db->free_result();

		self::$_arrContactCompanyOfficePhoneNumbersByContactCompanyOfficeId = $arrContactCompanyOfficePhoneNumbersByContactCompanyOfficeId;

		return $arrContactCompanyOfficePhoneNumbersByContactCompanyOfficeId;
	}

	/**
	 * Load by constraint `contact_company_office_phone_numbers_fk_pnt` foreign key (`phone_number_type_id`) references `phone_number_types` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $phone_number_type_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadContactCompanyOfficePhoneNumbersByPhoneNumberTypeId($database, $phone_number_type_id, Input $options=null)
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
			self::$_arrContactCompanyOfficePhoneNumbersByPhoneNumberTypeId = null;
		}

		$arrContactCompanyOfficePhoneNumbersByPhoneNumberTypeId = self::$_arrContactCompanyOfficePhoneNumbersByPhoneNumberTypeId;
		if (isset($arrContactCompanyOfficePhoneNumbersByPhoneNumberTypeId) && !empty($arrContactCompanyOfficePhoneNumbersByPhoneNumberTypeId)) {
			return $arrContactCompanyOfficePhoneNumbersByPhoneNumberTypeId;
		}

		$phone_number_type_id = (int) $phone_number_type_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `contact_company_office_id` ASC, `phone_number_type_id` ASC, `country_code` ASC, `area_code` ASC, `prefix` ASC, `number` ASC, `extension` ASC, `itu` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpContactCompanyOfficePhoneNumber = new ContactCompanyOfficePhoneNumber($database);
			$sqlOrderByColumns = $tmpContactCompanyOfficePhoneNumber->constructSqlOrderByColumns($arrOrderByAttributes);

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
	ccopn.*

FROM `contact_company_office_phone_numbers` ccopn
WHERE ccopn.`phone_number_type_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `contact_company_office_id` ASC, `phone_number_type_id` ASC, `country_code` ASC, `area_code` ASC, `prefix` ASC, `number` ASC, `extension` ASC, `itu` ASC
		$arrValues = array($phone_number_type_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrContactCompanyOfficePhoneNumbersByPhoneNumberTypeId = array();
		while ($row = $db->fetch()) {
			$contact_company_office_phone_number_id = $row['id'];
			$contactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $contact_company_office_phone_number_id);
			/* @var $contactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
			$arrContactCompanyOfficePhoneNumbersByPhoneNumberTypeId[$contact_company_office_phone_number_id] = $contactCompanyOfficePhoneNumber;
		}

		$db->free_result();

		self::$_arrContactCompanyOfficePhoneNumbersByPhoneNumberTypeId = $arrContactCompanyOfficePhoneNumbersByPhoneNumberTypeId;

		return $arrContactCompanyOfficePhoneNumbersByPhoneNumberTypeId;
	}

	// Loaders: Load By index
	/**
	 * Load by key `contact_company_office_phone_number` (`area_code`,`prefix`,`number`).
	 *
	 * @param string $database
	 * @param string $area_code
	 * @param string $prefix
	 * @param string $number
	 * @param mixed (Input $options object | null)
	 * @return mixed (single ORM object | false)
	 */
	public static function loadContactCompanyOfficePhoneNumbersByAreaCodeAndPrefixAndNumber($database, $area_code, $prefix, $number, Input $options=null)
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
			self::$_arrContactCompanyOfficePhoneNumbersByAreaCodeAndPrefixAndNumber = null;
		}

		$arrContactCompanyOfficePhoneNumbersByAreaCodeAndPrefixAndNumber = self::$_arrContactCompanyOfficePhoneNumbersByAreaCodeAndPrefixAndNumber;
		if (isset($arrContactCompanyOfficePhoneNumbersByAreaCodeAndPrefixAndNumber) && !empty($arrContactCompanyOfficePhoneNumbersByAreaCodeAndPrefixAndNumber)) {
			return $arrContactCompanyOfficePhoneNumbersByAreaCodeAndPrefixAndNumber;
		}

		$area_code = (string) $area_code;
		$prefix = (string) $prefix;
		$number = (string) $number;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `contact_company_office_id` ASC, `phone_number_type_id` ASC, `country_code` ASC, `area_code` ASC, `prefix` ASC, `number` ASC, `extension` ASC, `itu` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpContactCompanyOfficePhoneNumber = new ContactCompanyOfficePhoneNumber($database);
			$sqlOrderByColumns = $tmpContactCompanyOfficePhoneNumber->constructSqlOrderByColumns($arrOrderByAttributes);

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
	ccopn.*

FROM `contact_company_office_phone_numbers` ccopn
WHERE ccopn.`area_code` = ?
AND ccopn.`prefix` = ?
AND ccopn.`number` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `contact_company_office_id` ASC, `phone_number_type_id` ASC, `country_code` ASC, `area_code` ASC, `prefix` ASC, `number` ASC, `extension` ASC, `itu` ASC
		$arrValues = array($area_code, $prefix, $number);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrContactCompanyOfficePhoneNumbersByAreaCodeAndPrefixAndNumber = array();
		while ($row = $db->fetch()) {
			$contact_company_office_phone_number_id = $row['id'];
			$contactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $contact_company_office_phone_number_id);
			/* @var $contactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
			$arrContactCompanyOfficePhoneNumbersByAreaCodeAndPrefixAndNumber[$contact_company_office_phone_number_id] = $contactCompanyOfficePhoneNumber;
		}

		$db->free_result();

		self::$_arrContactCompanyOfficePhoneNumbersByAreaCodeAndPrefixAndNumber = $arrContactCompanyOfficePhoneNumbersByAreaCodeAndPrefixAndNumber;

		return $arrContactCompanyOfficePhoneNumbersByAreaCodeAndPrefixAndNumber;
	}

	/**
	 * Load by key `contact_company_office_id` (`contact_company_office_id`,`phone_number_type_id`).
	 *
	 * @param string $database
	 * @param int $contact_company_office_id
	 * @param int $phone_number_type_id
	 * @return mixed (single ORM object | false)
	 */
	public static function loadContactCompanyOfficePhoneNumbersByContactCompanyOfficeIdAndPhoneNumberTypeId($database, $contact_company_office_id, $phone_number_type_id, Input $options=null)
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
			self::$_arrContactCompanyOfficePhoneNumbersByContactCompanyOfficeIdAndPhoneNumberTypeId = null;
		}

		$arrContactCompanyOfficePhoneNumbersByContactCompanyOfficeIdAndPhoneNumberTypeId = self::$_arrContactCompanyOfficePhoneNumbersByContactCompanyOfficeIdAndPhoneNumberTypeId;
		if (isset($arrContactCompanyOfficePhoneNumbersByContactCompanyOfficeIdAndPhoneNumberTypeId) && !empty($arrContactCompanyOfficePhoneNumbersByContactCompanyOfficeIdAndPhoneNumberTypeId)) {
			return $arrContactCompanyOfficePhoneNumbersByContactCompanyOfficeIdAndPhoneNumberTypeId;
		}

		$contact_company_office_id = (int) $contact_company_office_id;
		$phone_number_type_id = (int) $phone_number_type_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `contact_company_office_id` ASC, `phone_number_type_id` ASC, `country_code` ASC, `area_code` ASC, `prefix` ASC, `number` ASC, `extension` ASC, `itu` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpContactCompanyOfficePhoneNumber = new ContactCompanyOfficePhoneNumber($database);
			$sqlOrderByColumns = $tmpContactCompanyOfficePhoneNumber->constructSqlOrderByColumns($arrOrderByAttributes);

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
SELECT ccopn.*
FROM `contact_company_office_phone_numbers` ccopn
WHERE ccopn.`contact_company_office_id` = ?
AND ccopn.`phone_number_type_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `contact_company_office_id` ASC, `phone_number_type_id` ASC, `country_code` ASC, `area_code` ASC, `prefix` ASC, `number` ASC, `extension` ASC, `itu` ASC
		$arrValues = array($contact_company_office_id, $phone_number_type_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrContactCompanyOfficePhoneNumbersByContactCompanyOfficeIdAndPhoneNumberTypeId = array();
		while ($row = $db->fetch()) {
			$id = $row['id'];
			$contactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $id);
			$arrContactCompanyOfficePhoneNumbersByContactCompanyOfficeIdAndPhoneNumberTypeId[$id] = $contactCompanyOfficePhoneNumber;
		}

		$db->free_result();

		self::$_arrContactCompanyOfficePhoneNumbersByContactCompanyOfficeIdAndPhoneNumberTypeId = $arrContactCompanyOfficePhoneNumbersByContactCompanyOfficeIdAndPhoneNumberTypeId;

		return $arrContactCompanyOfficePhoneNumbersByContactCompanyOfficeIdAndPhoneNumberTypeId;
	}

	// Loaders: Load By additionally indexed attribute
	/**
	 * Load by leftmost indexed attribute: key `contact_company_office_phone_number` (`area_code`,`prefix`,`number`).
	 *
	 * @param string $database
	 * @param string $area_code
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadContactCompanyOfficePhoneNumbersByAreaCode($database, $area_code, Input $options=null)
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
			self::$_arrContactCompanyOfficePhoneNumbersByAreaCode = null;
		}

		$arrContactCompanyOfficePhoneNumbersByAreaCode = self::$_arrContactCompanyOfficePhoneNumbersByAreaCode;
		if (isset($arrContactCompanyOfficePhoneNumbersByAreaCode) && !empty($arrContactCompanyOfficePhoneNumbersByAreaCode)) {
			return $arrContactCompanyOfficePhoneNumbersByAreaCode;
		}

		$area_code = (string) $area_code;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `contact_company_office_id` ASC, `phone_number_type_id` ASC, `country_code` ASC, `area_code` ASC, `prefix` ASC, `number` ASC, `extension` ASC, `itu` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpContactCompanyOfficePhoneNumber = new ContactCompanyOfficePhoneNumber($database);
			$sqlOrderByColumns = $tmpContactCompanyOfficePhoneNumber->constructSqlOrderByColumns($arrOrderByAttributes);

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
	ccopn.*

FROM `contact_company_office_phone_numbers` ccopn
WHERE ccopn.`area_code` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `contact_company_office_id` ASC, `phone_number_type_id` ASC, `country_code` ASC, `area_code` ASC, `prefix` ASC, `number` ASC, `extension` ASC, `itu` ASC
		$arrValues = array($area_code);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrContactCompanyOfficePhoneNumbersByAreaCode = array();
		while ($row = $db->fetch()) {
			$contact_company_office_phone_number_id = $row['id'];
			$contactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $contact_company_office_phone_number_id);
			/* @var $contactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
			$arrContactCompanyOfficePhoneNumbersByAreaCode[$contact_company_office_phone_number_id] = $contactCompanyOfficePhoneNumber;
		}

		$db->free_result();

		self::$_arrContactCompanyOfficePhoneNumbersByAreaCode = $arrContactCompanyOfficePhoneNumbersByAreaCode;

		return $arrContactCompanyOfficePhoneNumbersByAreaCode;
	}

	// Loaders: Load All Records
	/**
	 * Load all contact_company_office_phone_numbers records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllContactCompanyOfficePhoneNumbers($database, Input $options=null)
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
			self::$_arrAllContactCompanyOfficePhoneNumbers = null;
		}

		$arrAllContactCompanyOfficePhoneNumbers = self::$_arrAllContactCompanyOfficePhoneNumbers;
		if (isset($arrAllContactCompanyOfficePhoneNumbers) && !empty($arrAllContactCompanyOfficePhoneNumbers)) {
			return $arrAllContactCompanyOfficePhoneNumbers;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `contact_company_office_id` ASC, `phone_number_type_id` ASC, `country_code` ASC, `area_code` ASC, `prefix` ASC, `number` ASC, `extension` ASC, `itu` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpContactCompanyOfficePhoneNumber = new ContactCompanyOfficePhoneNumber($database);
			$sqlOrderByColumns = $tmpContactCompanyOfficePhoneNumber->constructSqlOrderByColumns($arrOrderByAttributes);

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
	ccopn.*

FROM `contact_company_office_phone_numbers` ccopn{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `contact_company_office_id` ASC, `phone_number_type_id` ASC, `country_code` ASC, `area_code` ASC, `prefix` ASC, `number` ASC, `extension` ASC, `itu` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllContactCompanyOfficePhoneNumbers = array();
		while ($row = $db->fetch()) {
			$contact_company_office_phone_number_id = $row['id'];
			$contactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $contact_company_office_phone_number_id);
			/* @var $contactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
			$arrAllContactCompanyOfficePhoneNumbers[$contact_company_office_phone_number_id] = $contactCompanyOfficePhoneNumber;
		}

		$db->free_result();

		self::$_arrAllContactCompanyOfficePhoneNumbers = $arrAllContactCompanyOfficePhoneNumbers;

		return $arrAllContactCompanyOfficePhoneNumbers;
	}

	// Save: insert on duplicate key update

	// Save: insert ignore

	public static function loadContactPhoneNumbersListByContactId($database, $contact_company_office_id, $phone_number_type=null)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT cpn.*, pnt.`phone_number_type`
FROM `contact_company_office_phone_numbers`, `phone_number_types` pnt
WHERE cpn.`contact_company_office_id` = ?
AND cpn.`phone_number_type_id` = pnt.`id`
ORDER BY pnt.`phone_number_type`, `country_code`, `area_code`, `prefix`, `number`, `extension`, `itu`
";
		$arrValues = array($contact_company_office_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrRecords = array();
		while ($row = $db->fetch()) {
			$cc = new ContactCompanyOfficePhoneNumber($database);
			$cc->setData($row);
			$cc->convertDataToProperties();
			$arrRecords[] = $cc;
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
		// unique index(`contact_company_office_id`, `phone_number_type_id`, `country_code`, `area_code`, `prefix`, `number`, `extension`, `itu`)
		$contact_company_office_id = (int) $this->contact_company_office_id;
		$phone_number_type_id = (int) $this->phone_number_type_id;
		$country_code = (string) $this->country_code;
		$area_code = (string) $this->area_code;
		$prefix = (string) $this->prefix;
		$number = (string) $this->number;
		$extension = (string) $this->extension;
		$itu = (string) $this->itu;

		$key = array(
			'contact_company_office_id' => $contact_company_office_id,
			'phone_number_type_id' => $phone_number_type_id,
			'country_code' => $country_code,
			'area_code' => $area_code,
			'prefix' => $prefix,
			'number' => $number,
			'extension' => $extension,
			'itu' => $itu
		);

		$database = $this->getDatabase();
		$tmpObject = new ContactCompanyOfficePhoneNumber($database);
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

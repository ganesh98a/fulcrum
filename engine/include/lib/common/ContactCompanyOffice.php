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
 * ContactCompanyOffice.
 *
 * @category   Contacts/Companies_Offices
 * @package    Address
 * @category   Framework
 * @package    ContactCompanyOffice
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class ContactCompanyOffice extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'ContactCompanyOffice';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'contact_company_offices';

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
	 * unique index `unique_contact_company_office` (`contact_company_id`,`address_line_1`,`address_line_2`,`address_line_3`,`address_line_4`,`address_city`,`address_county`,`address_state_or_region`,`address_postal_code`,`address_postal_code_extension`,`address_country`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_contact_company_office' => array(
			'contact_company_id' => 'int',
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
		'id' => 'contact_company_office_id',

		'contact_company_id' => 'contact_company_id',
		//'address_id' => 'address_id',

		'office_nickname' => 'office_nickname',
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

		'head_quarters_flag' => 'head_quarters_flag',
		'address_validated_by_user_flag' => 'address_validated_by_user_flag',
		'address_validated_by_web_service_flag' => 'address_validated_by_web_service_flag',
		'address_validation_by_web_service_error_flag' => 'address_validation_by_web_service_error_flag'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	// addresses database table fields
	public $contact_company_office_id;

	public $contact_company_id;
	//public $address_id;

	public $office_nickname;
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

	public $head_quarters_flag = 'N';
	public $address_validated_by_user_flag = 'N';
	public $address_validated_by_web_service_flag = 'N';
	public $address_validation_by_web_service_error_flag = 'N';

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties
	public $escaped_office_nickname;
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
	public $escaped_office_nickname_nl2br;
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
	protected static $_arrContactCompanyOfficesByContactCompanyId;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)
	protected static $_arrContactCompanyOfficesByAddressCity;
	protected static $_arrContactCompanyOfficesByAddressStateOrRegion;
	protected static $_arrContactCompanyOfficesByAddressPostalCode;

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllContactCompanyOffices;

	// Foreign Key Objects
	private $_contactCompany;
	private $_businessPhoneNumber;
	private $_businessFaxNumber;

	// Object references for delegation.
	private $addressValidator;
	private $soap;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='contact_company_offices')
	{
		parent::__construct($table);
		$this->setDatabase($database);
	}

	// Foreign Key Object Accessor Methods
	public function getContactCompany()
	{
		if (isset($this->_contactCompany)) {
			return $this->_contactCompany;
		} else {
			return null;
		}
	}

	public function setContactCompany($contactCompany)
	{
		$this->_contactCompany = $contactCompany;
	}

	public function getBusinessPhoneNumber()
	{
		return $this->_businessPhoneNumber;
	}

	public function setBusinessPhoneNumber($businessPhoneNumber)
	{
		$this->_businessPhoneNumber = $businessPhoneNumber;
	}

	public function getBusinessFaxNumber()
	{
		return $this->_businessFaxNumber;
	}

	public function setBusinessFaxNumber($businessFaxNumber)
	{
		$this->_businessFaxNumber = $businessFaxNumber;
	}

	public function getFormattedOfficeAddress($twoLines=false)
	{
		if ($twoLines) {
			$formattedOfficeAddress = "$this->address_line_1 <br>$this->address_city, $this->address_state_or_region $this->address_postal_code";
		} else {
			$formattedOfficeAddress = "$this->address_line_1 $this->address_city, $this->address_state_or_region $this->address_postal_code";
		}

		return $formattedOfficeAddress;
	}

	public function getFormattedOfficeAddressHtmlEscaped($twoLines=false)
	{
		$htmlEntityPropertiesEscapedFlag = $this->getHtmlEntityPropertiesEscapedFlag();
		if (!$htmlEntityPropertiesEscapedFlag) {
			$this->htmlEntityEscapeProperties();
		}

		if ($twoLines) {
			$formattedOfficeAddressHtmlEscaped = "$this->escaped_address_line_1 <br>$this->escaped_address_city, $this->escaped_address_state_or_region $this->escaped_address_postal_code";
		} else {
			$formattedOfficeAddressHtmlEscaped = "$this->escaped_address_line_1 $this->escaped_address_city, $this->escaped_address_state_or_region $this->escaped_address_postal_code";
		}

		return $formattedOfficeAddressHtmlEscaped;
	}

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)
	public static function getArrContactCompanyOfficesByContactCompanyId()
	{
		if (isset(self::$_arrContactCompanyOfficesByContactCompanyId)) {
			return self::$_arrContactCompanyOfficesByContactCompanyId;
		} else {
			return null;
		}
	}

	public static function setArrContactCompanyOfficesByContactCompanyId($arrContactCompanyOfficesByContactCompanyId)
	{
		self::$_arrContactCompanyOfficesByContactCompanyId = $arrContactCompanyOfficesByContactCompanyId;
	}

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)
	public static function getArrContactCompanyOfficesByAddressCity()
	{
		if (isset(self::$_arrContactCompanyOfficesByAddressCity)) {
			return self::$_arrContactCompanyOfficesByAddressCity;
		} else {
			return null;
		}
	}

	public static function setArrContactCompanyOfficesByAddressCity($arrContactCompanyOfficesByAddressCity)
	{
		self::$_arrContactCompanyOfficesByAddressCity = $arrContactCompanyOfficesByAddressCity;
	}

	public static function getArrContactCompanyOfficesByAddressStateOrRegion()
	{
		if (isset(self::$_arrContactCompanyOfficesByAddressStateOrRegion)) {
			return self::$_arrContactCompanyOfficesByAddressStateOrRegion;
		} else {
			return null;
		}
	}

	public static function setArrContactCompanyOfficesByAddressStateOrRegion($arrContactCompanyOfficesByAddressStateOrRegion)
	{
		self::$_arrContactCompanyOfficesByAddressStateOrRegion = $arrContactCompanyOfficesByAddressStateOrRegion;
	}

	public static function getArrContactCompanyOfficesByAddressPostalCode()
	{
		if (isset(self::$_arrContactCompanyOfficesByAddressPostalCode)) {
			return self::$_arrContactCompanyOfficesByAddressPostalCode;
		} else {
			return null;
		}
	}

	public static function setArrContactCompanyOfficesByAddressPostalCode($arrContactCompanyOfficesByAddressPostalCode)
	{
		self::$_arrContactCompanyOfficesByAddressPostalCode = $arrContactCompanyOfficesByAddressPostalCode;
	}

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllContactCompanyOffices()
	{
		if (isset(self::$_arrAllContactCompanyOffices)) {
			return self::$_arrAllContactCompanyOffices;
		} else {
			return null;
		}
	}

	public static function setArrAllContactCompanyOffices($arrAllContactCompanyOffices)
	{
		self::$_arrAllContactCompanyOffices = $arrAllContactCompanyOffices;
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
	 * @param int $contact_company_office_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findById($database, $contact_company_office_id, $table='contact_company_offices', $module='ContactCompanyOffice')
	{
		$contactCompanyOffice = parent::findById($database, $contact_company_office_id, $table, $module);

		return $contactCompanyOffice;
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Similar to FindById, but with SQL as starter code for more complex joins.
	 *
	 * @param string $database
	 * @param int $contact_company_office_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findContactCompanyOfficeByIdExtended($database, $contact_company_office_id)
	{
		$contact_company_office_id = (int) $contact_company_office_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	cco_fk_cc.`id` AS 'cco_fk_cc__contact_company_id',
	cco_fk_cc.`user_user_company_id` AS 'cco_fk_cc__user_user_company_id',
	cco_fk_cc.`contact_user_company_id` AS 'cco_fk_cc__contact_user_company_id',
	cco_fk_cc.`company` AS 'cco_fk_cc__company',
	cco_fk_cc.`primary_phone_number` AS 'cco_fk_cc__primary_phone_number',
	cco_fk_cc.`employer_identification_number` AS 'cco_fk_cc__employer_identification_number',
	cco_fk_cc.`construction_license_number` AS 'cco_fk_cc__construction_license_number',
	cco_fk_cc.`construction_license_number_expiration_date` AS 'cco_fk_cc__construction_license_number_expiration_date',
	cco_fk_cc.`vendor_flag` AS 'cco_fk_cc__vendor_flag',

	business_phone.`id` AS 'business_phone__contact_company_office_phone_number_id',
	business_phone.`contact_company_office_id` AS 'business_phone__contact_company_office_id',
	business_phone.`phone_number_type_id` AS 'business_phone__phone_number_type_id',
	business_phone.`country_code` AS 'business_phone__country_code',
	business_phone.`area_code` AS 'business_phone__area_code',
	business_phone.`prefix` AS 'business_phone__prefix',
	business_phone.`number` AS 'business_phone__number',
	business_phone.`extension` AS 'business_phone__extension',
	business_phone.`itu` AS 'business_phone__itu',

	business_fax.`id` AS 'business_fax__contact_company_office_phone_number_id',
	business_fax.`contact_company_office_id` AS 'business_fax__contact_company_office_id',
	business_fax.`phone_number_type_id` AS 'business_fax__phone_number_type_id',
	business_fax.`country_code` AS 'business_fax__country_code',
	business_fax.`area_code` AS 'business_fax__area_code',
	business_fax.`prefix` AS 'business_fax__prefix',
	business_fax.`number` AS 'business_fax__number',
	business_fax.`extension` AS 'business_fax__extension',
	business_fax.`itu` AS 'business_fax__itu',

	cco.*

FROM `contact_company_offices` cco
	INNER JOIN `contact_companies` cco_fk_cc ON cco.`contact_company_id` = cco_fk_cc.`id`

	LEFT OUTER JOIN contact_company_office_phone_numbers business_phone ON (cco.`id` = business_phone.contact_company_office_id AND business_phone.phone_number_type_id = 1)
	LEFT OUTER JOIN contact_company_office_phone_numbers business_fax ON (cco.`id` = business_fax.contact_company_office_id AND business_fax.phone_number_type_id = 2)

WHERE cco.`id` = ?
";
		$arrValues = array($contact_company_office_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$contact_company_office_id = $row['id'];
			$contactCompanyOffice = self::instantiateOrm($database, 'ContactCompanyOffice', $row, null, $contact_company_office_id);
			/* @var $contactCompanyOffice ContactCompanyOffice */
			$contactCompanyOffice->convertPropertiesToData();

			if (isset($row['contact_company_id'])) {
				$contact_company_id = $row['contact_company_id'];
				$row['cco_fk_cc__id'] = $contact_company_id;
				$contactCompany = self::instantiateOrm($database, 'ContactCompany', $row, null, $contact_company_id, 'cco_fk_cc__');
				/* @var $contactCompany ContactCompany */
				$contactCompany->convertPropertiesToData();
			} else {
				$contactCompany = false;
			}
			$contactCompanyOffice->setContactCompany($contactCompany);

			if (isset($row['business_phone__contact_company_office_phone_number_id'])) {
				$business_phone__contact_company_office_phone_number_id = $row['business_phone__contact_company_office_phone_number_id'];
				$row['business_phone__id'] = $business_phone__contact_company_office_phone_number_id;
				$businessPhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $business_phone__contact_company_office_phone_number_id, 'business_phone__');
				/* @var $businessPhoneNumber ContactCompanyOfficePhoneNumber */
				$businessPhoneNumber->convertPropertiesToData();
			} else {
				$businessPhoneNumber = false;
			}
			$contactCompanyOffice->setBusinessPhoneNumber($businessPhoneNumber);

			if (isset($row['business_fax__contact_company_office_phone_number_id'])) {
				$business_fax__contact_company_office_phone_number_id = $row['business_fax__contact_company_office_phone_number_id'];
				$row['business_fax__id'] = $business_fax__contact_company_office_phone_number_id;
				$businessFaxNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $business_fax__contact_company_office_phone_number_id, 'business_fax__');
				/* @var $businessFaxNumber ContactCompanyOfficePhoneNumber */
				$businessFaxNumber->convertPropertiesToData();
			} else {
				$businessFaxNumber = false;
			}
			$contactCompanyOffice->setBusinessFaxNumber($businessFaxNumber);

			return $contactCompanyOffice;
		} else {
			return false;
		}
	}

	// Finders: Find By Unique Index
	/**
	 * Find by unique index `unique_contact_company_office` (`contact_company_id`,`address_line_1`,`address_line_2`,`address_line_3`,`address_line_4`,`address_city`,`address_county`,`address_state_or_region`,`address_postal_code`,`address_postal_code_extension`,`address_country`).
	 *
	 * @param string $database
	 * @param int $contact_company_id
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
	public static function findByContactCompanyIdAndAddressLine1AndAddressLine2AndAddressLine3AndAddressLine4AndAddressCityAndAddressCountyAndAddressStateOrRegionAndAddressPostalCodeAndAddressPostalCodeExtensionAndAddressCountry($database, $contact_company_id, $address_line_1, $address_line_2, $address_line_3, $address_line_4, $address_city, $address_county, $address_state_or_region, $address_postal_code, $address_postal_code_extension, $address_country)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	cco.*

FROM `contact_company_offices` cco
WHERE cco.`contact_company_id` = ?
AND cco.`address_line_1` = ?
AND cco.`address_line_2` = ?
AND cco.`address_line_3` = ?
AND cco.`address_line_4` = ?
AND cco.`address_city` = ?
AND cco.`address_county` = ?
AND cco.`address_state_or_region` = ?
AND cco.`address_postal_code` = ?
AND cco.`address_postal_code_extension` = ?
AND cco.`address_country` = ?
";
		$arrValues = array($contact_company_id, $address_line_1, $address_line_2, $address_line_3, $address_line_4, $address_city, $address_county, $address_state_or_region, $address_postal_code, $address_postal_code_extension, $address_country);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if ($row && !empty($row)) {
			$contact_company_office_id = $row['id'];
			$contactCompanyOffice = self::instantiateOrm($database, 'ContactCompanyOffice', $row, null, $contact_company_office_id);
			/* @var $contactCompanyOffice ContactCompanyOffice */
			return $contactCompanyOffice;
		} else {
			return false;
		}
	}

	// Loaders: Load By pk List (list of auto int ids or other non auto int pk list)
	/**
	 * Load zero or more records by an id list (array of auto int primary keys).
	 *
	 * @param string $database
	 * @param array $arrContactCompanyOfficeIds
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadContactCompanyOfficesByArrContactCompanyOfficeIds($database, $arrContactCompanyOfficeIds, Input $options=null)
	{
		if (empty($arrContactCompanyOfficeIds)) {
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
		// ORDER BY `id` ASC, `contact_company_id` ASC, `office_nickname` ASC, `address_line_1` ASC, `address_line_2` ASC, `address_line_3` ASC, `address_line_4` ASC, `address_city` ASC, `address_county` ASC, `address_state_or_region` ASC, `address_postal_code` ASC, `address_postal_code_extension` ASC, `address_country` ASC, `head_quarters_flag` ASC, `address_validated_by_user_flag` ASC, `address_validated_by_web_service_flag` ASC, `address_validation_by_web_service_error_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpContactCompanyOffice = new ContactCompanyOffice($database);
			$sqlOrderByColumns = $tmpContactCompanyOffice->constructSqlOrderByColumns($arrOrderByAttributes);

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

		foreach ($arrContactCompanyOfficeIds as $k => $contact_company_office_id) {
			$contact_company_office_id = (int) $contact_company_office_id;
			$arrContactCompanyOfficeIds[$k] = $db->escape($contact_company_office_id);
		}
		$csvContactCompanyOfficeIds = join(',', $arrContactCompanyOfficeIds);

		$query =
"
SELECT

	cco.*

FROM `contact_company_offices` cco
WHERE cco.`id` IN ($csvContactCompanyOfficeIds){$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		$arrContactCompanyOfficesByCsvContactCompanyOfficeIds = array();
		while ($row = $db->fetch()) {
			$contact_company_office_id = $row['id'];
			$contactCompanyOffice = self::instantiateOrm($database, 'ContactCompanyOffice', $row, null, $contact_company_office_id);
			/* @var $contactCompanyOffice ContactCompanyOffice */
			$contactCompanyOffice->convertPropertiesToData();

			$arrContactCompanyOfficesByCsvContactCompanyOfficeIds[$contact_company_office_id] = $contactCompanyOffice;
		}

		$db->free_result();

		return $arrContactCompanyOfficesByCsvContactCompanyOfficeIds;
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `contact_company_offices_fk_cc` foreign key (`contact_company_id`) references `contact_companies` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $contact_company_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadContactCompanyOfficesByContactCompanyId($database, $contact_company_id, Input $options=null)
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
			self::$_arrContactCompanyOfficesByContactCompanyId = null;
		}

		$arrContactCompanyOfficesByContactCompanyId = self::$_arrContactCompanyOfficesByContactCompanyId;
		if (isset($arrContactCompanyOfficesByContactCompanyId) && !empty($arrContactCompanyOfficesByContactCompanyId)) {
			return $arrContactCompanyOfficesByContactCompanyId;
		}

		$contact_company_id = (int) $contact_company_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `contact_company_id` ASC, `office_nickname` ASC, `address_line_1` ASC, `address_line_2` ASC, `address_line_3` ASC, `address_line_4` ASC, `address_city` ASC, `address_county` ASC, `address_state_or_region` ASC, `address_postal_code` ASC, `address_postal_code_extension` ASC, `address_country` ASC, `head_quarters_flag` ASC, `address_validated_by_user_flag` ASC, `address_validated_by_web_service_flag` ASC, `address_validation_by_web_service_error_flag` ASC
		$sqlOrderBy = "\nORDER BY `head_quarters_flag` DESC, `address_state_or_region` ASC, `address_county` ASC, `address_city` ASC, `address_postal_code` ASC, `address_postal_code_extension` ASC, `address_line_1` ASC, `address_line_2` ASC, `address_line_3` ASC, `address_line_4` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpContactCompanyOffice = new ContactCompanyOffice($database);
			$sqlOrderByColumns = $tmpContactCompanyOffice->constructSqlOrderByColumns($arrOrderByAttributes);

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

	cco_fk_cc.`id` AS 'cco_fk_cc__contact_company_id',
	cco_fk_cc.`user_user_company_id` AS 'cco_fk_cc__user_user_company_id',
	cco_fk_cc.`contact_user_company_id` AS 'cco_fk_cc__contact_user_company_id',
	cco_fk_cc.`company` AS 'cco_fk_cc__company',
	cco_fk_cc.`primary_phone_number` AS 'cco_fk_cc__primary_phone_number',
	cco_fk_cc.`employer_identification_number` AS 'cco_fk_cc__employer_identification_number',
	cco_fk_cc.`construction_license_number` AS 'cco_fk_cc__construction_license_number',
	cco_fk_cc.`construction_license_number_expiration_date` AS 'cco_fk_cc__construction_license_number_expiration_date',
	cco_fk_cc.`vendor_flag` AS 'cco_fk_cc__vendor_flag',

	business_phone.`id` AS 'business_phone__contact_company_office_phone_number_id',
	business_phone.`contact_company_office_id` AS 'business_phone__contact_company_office_id',
	business_phone.`phone_number_type_id` AS 'business_phone__phone_number_type_id',
	business_phone.`country_code` AS 'business_phone__country_code',
	business_phone.`area_code` AS 'business_phone__area_code',
	business_phone.`prefix` AS 'business_phone__prefix',
	business_phone.`number` AS 'business_phone__number',
	business_phone.`extension` AS 'business_phone__extension',
	business_phone.`itu` AS 'business_phone__itu',

	business_fax.`id` AS 'business_fax__contact_company_office_phone_number_id',
	business_fax.`contact_company_office_id` AS 'business_fax__contact_company_office_id',
	business_fax.`phone_number_type_id` AS 'business_fax__phone_number_type_id',
	business_fax.`country_code` AS 'business_fax__country_code',
	business_fax.`area_code` AS 'business_fax__area_code',
	business_fax.`prefix` AS 'business_fax__prefix',
	business_fax.`number` AS 'business_fax__number',
	business_fax.`extension` AS 'business_fax__extension',
	business_fax.`itu` AS 'business_fax__itu',

	cco.*

FROM `contact_company_offices` cco
	INNER JOIN `contact_companies` cco_fk_cc ON cco.`contact_company_id` = cco_fk_cc.`id`

	LEFT OUTER JOIN contact_company_office_phone_numbers business_phone ON (cco.`id` = business_phone.contact_company_office_id AND business_phone.phone_number_type_id = 1)
	LEFT OUTER JOIN contact_company_office_phone_numbers business_fax ON (cco.`id` = business_fax.contact_company_office_id AND business_fax.phone_number_type_id = 2)

WHERE cco.`contact_company_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `contact_company_id` ASC, `office_nickname` ASC, `address_line_1` ASC, `address_line_2` ASC, `address_line_3` ASC, `address_line_4` ASC, `address_city` ASC, `address_county` ASC, `address_state_or_region` ASC, `address_postal_code` ASC, `address_postal_code_extension` ASC, `address_country` ASC, `head_quarters_flag` ASC, `address_validated_by_user_flag` ASC, `address_validated_by_web_service_flag` ASC, `address_validation_by_web_service_error_flag` ASC
		$arrValues = array($contact_company_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrContactCompanyOfficesByContactCompanyId = array();
		while ($row = $db->fetch()) {
			$contact_company_office_id = $row['id'];
			$contactCompanyOffice = self::instantiateOrm($database, 'ContactCompanyOffice', $row, null, $contact_company_office_id);
			/* @var $contactCompanyOffice ContactCompanyOffice */
			$contactCompanyOffice->convertPropertiesToData();

			if (isset($row['contact_company_id'])) {
				$contact_company_id = $row['contact_company_id'];
				$row['cco_fk_cc__id'] = $contact_company_id;
				$contactCompany = self::instantiateOrm($database, 'ContactCompany', $row, null, $contact_company_id, 'cco_fk_cc__');
				/* @var $contactCompany ContactCompany */
				$contactCompany->convertPropertiesToData();
			} else {
				$contactCompany = false;
			}
			$contactCompanyOffice->setContactCompany($contactCompany);

			if (isset($row['business_phone__contact_company_office_phone_number_id'])) {
				$business_phone__contact_company_office_phone_number_id = $row['business_phone__contact_company_office_phone_number_id'];
				$row['business_phone__id'] = $business_phone__contact_company_office_phone_number_id;
				$businessPhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $business_phone__contact_company_office_phone_number_id, 'business_phone__');
				/* @var $businessPhoneNumber ContactCompanyOfficePhoneNumber */
				$businessPhoneNumber->convertPropertiesToData();
			} else {
				$businessPhoneNumber = false;
			}
			$contactCompanyOffice->setBusinessPhoneNumber($businessPhoneNumber);

			if (isset($row['business_fax__contact_company_office_phone_number_id'])) {
				$business_fax__contact_company_office_phone_number_id = $row['business_fax__contact_company_office_phone_number_id'];
				$row['business_fax__id'] = $business_fax__contact_company_office_phone_number_id;
				$businessFaxNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $business_fax__contact_company_office_phone_number_id, 'business_fax__');
				/* @var $businessFaxNumber ContactCompanyOfficePhoneNumber */
				$businessFaxNumber->convertPropertiesToData();
			} else {
				$businessFaxNumber = false;
			}
			$contactCompanyOffice->setBusinessFaxNumber($businessFaxNumber);

			$arrContactCompanyOfficesByContactCompanyId[$contact_company_office_id] = $contactCompanyOffice;
		}

		$db->free_result();

		self::$_arrContactCompanyOfficesByContactCompanyId = $arrContactCompanyOfficesByContactCompanyId;

		return $arrContactCompanyOfficesByContactCompanyId;
	}
	public static function loadContactCompanyOfficesByContactCompanyIdReport($database, $contact_company_id, Input $options=null)
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
			self::$_arrContactCompanyOfficesByContactCompanyId = null;
		}

		$arrContactCompanyOfficesByContactCompanyId = self::$_arrContactCompanyOfficesByContactCompanyId;
		if (isset($arrContactCompanyOfficesByContactCompanyId) && !empty($arrContactCompanyOfficesByContactCompanyId)) {
			return $arrContactCompanyOfficesByContactCompanyId;
		}

		$contact_company_id = (int) $contact_company_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `contact_company_id` ASC, `office_nickname` ASC, `address_line_1` ASC, `address_line_2` ASC, `address_line_3` ASC, `address_line_4` ASC, `address_city` ASC, `address_county` ASC, `address_state_or_region` ASC, `address_postal_code` ASC, `address_postal_code_extension` ASC, `address_country` ASC, `head_quarters_flag` ASC, `address_validated_by_user_flag` ASC, `address_validated_by_web_service_flag` ASC, `address_validation_by_web_service_error_flag` ASC
		$sqlOrderBy = "\nORDER BY `head_quarters_flag` DESC, `address_state_or_region` ASC, `address_county` ASC, `address_city` ASC, `address_postal_code` ASC, `address_postal_code_extension` ASC, `address_line_1` ASC, `address_line_2` ASC, `address_line_3` ASC, `address_line_4` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpContactCompanyOffice = new ContactCompanyOffice($database);
			$sqlOrderByColumns = $tmpContactCompanyOffice->constructSqlOrderByColumns($arrOrderByAttributes);

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

	cco_fk_cc.`id` AS 'cco_fk_cc__contact_company_id',
	cco_fk_cc.`user_user_company_id` AS 'cco_fk_cc__user_user_company_id',
	cco_fk_cc.`contact_user_company_id` AS 'cco_fk_cc__contact_user_company_id',
	cco_fk_cc.`company` AS 'cco_fk_cc__company',
	cco_fk_cc.`primary_phone_number` AS 'cco_fk_cc__primary_phone_number',
	cco_fk_cc.`employer_identification_number` AS 'cco_fk_cc__employer_identification_number',
	cco_fk_cc.`construction_license_number` AS 'cco_fk_cc__construction_license_number',
	cco_fk_cc.`construction_license_number_expiration_date` AS 'cco_fk_cc__construction_license_number_expiration_date',
	cco_fk_cc.`vendor_flag` AS 'cco_fk_cc__vendor_flag',

	business_phone.`id` AS 'business_phone__contact_company_office_phone_number_id',
	business_phone.`contact_company_office_id` AS 'business_phone__contact_company_office_id',
	business_phone.`phone_number_type_id` AS 'business_phone__phone_number_type_id',
	business_phone.`country_code` AS 'business_phone__country_code',
	business_phone.`area_code` AS 'business_phone__area_code',
	business_phone.`prefix` AS 'business_phone__prefix',
	business_phone.`number` AS 'business_phone__number',
	business_phone.`extension` AS 'business_phone__extension',
	business_phone.`itu` AS 'business_phone__itu',

	business_fax.`id` AS 'business_fax__contact_company_office_phone_number_id',
	business_fax.`contact_company_office_id` AS 'business_fax__contact_company_office_id',
	business_fax.`phone_number_type_id` AS 'business_fax__phone_number_type_id',
	business_fax.`country_code` AS 'business_fax__country_code',
	business_fax.`area_code` AS 'business_fax__area_code',
	business_fax.`prefix` AS 'business_fax__prefix',
	business_fax.`number` AS 'business_fax__number',
	business_fax.`extension` AS 'business_fax__extension',
	business_fax.`itu` AS 'business_fax__itu',

	cco.*

FROM `contact_company_offices` cco
	INNER JOIN `contact_companies` cco_fk_cc ON cco.`contact_company_id` = cco_fk_cc.`id`

	LEFT OUTER JOIN contact_company_office_phone_numbers business_phone ON (cco.`id` = business_phone.contact_company_office_id AND business_phone.phone_number_type_id = 1)
	LEFT OUTER JOIN contact_company_office_phone_numbers business_fax ON (cco.`id` = business_fax.contact_company_office_id AND business_fax.phone_number_type_id = 2)

WHERE cco.`contact_company_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `contact_company_id` ASC, `office_nickname` ASC, `address_line_1` ASC, `address_line_2` ASC, `address_line_3` ASC, `address_line_4` ASC, `address_city` ASC, `address_county` ASC, `address_state_or_region` ASC, `address_postal_code` ASC, `address_postal_code_extension` ASC, `address_country` ASC, `head_quarters_flag` ASC, `address_validated_by_user_flag` ASC, `address_validated_by_web_service_flag` ASC, `address_validation_by_web_service_error_flag` ASC
		$arrValues = array($contact_company_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrContactCompanyOfficesByContactCompanyId = array();
		while ($row = $db->fetch()) {
			$contact_company_office_id = $row['id'];
			$contactCompanyOffice = self::instantiateOrm($database, 'ContactCompanyOffice', $row, null, $contact_company_office_id);
			/* @var $contactCompanyOffice ContactCompanyOffice */
			$contactCompanyOffice->convertPropertiesToData();

			if (isset($row['contact_company_id'])) {
				$contact_company_id = $row['contact_company_id'];
				$row['cco_fk_cc__id'] = $contact_company_id;
				$contactCompany = self::instantiateOrm($database, 'ContactCompany', $row, null, $contact_company_id, 'cco_fk_cc__');
				/* @var $contactCompany ContactCompany */
				$contactCompany->convertPropertiesToData();
			} else {
				$contactCompany = false;
			}
			$contactCompanyOffice->setContactCompany($contactCompany);

			if (isset($row['business_phone__contact_company_office_phone_number_id'])) {
				$business_phone__contact_company_office_phone_number_id = $row['business_phone__contact_company_office_phone_number_id'];
				$row['business_phone__id'] = $business_phone__contact_company_office_phone_number_id;
				$businessPhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $business_phone__contact_company_office_phone_number_id, 'business_phone__');
				/* @var $businessPhoneNumber ContactCompanyOfficePhoneNumber */
				$businessPhoneNumber->convertPropertiesToData();
			} else {
				$businessPhoneNumber = false;
			}
			$contactCompanyOffice->setBusinessPhoneNumber($businessPhoneNumber);

			if (isset($row['business_fax__contact_company_office_phone_number_id'])) {
				$business_fax__contact_company_office_phone_number_id = $row['business_fax__contact_company_office_phone_number_id'];
				$row['business_fax__id'] = $business_fax__contact_company_office_phone_number_id;
				$businessFaxNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $business_fax__contact_company_office_phone_number_id, 'business_fax__');
				/* @var $businessFaxNumber ContactCompanyOfficePhoneNumber */
				$businessFaxNumber->convertPropertiesToData();
			} else {
				$businessFaxNumber = false;
			}
			$contactCompanyOffice->setBusinessFaxNumber($businessFaxNumber);

			$arrContactCompanyOfficesByContactCompanyId[$contact_company_office_id] = $contactCompanyOffice;
		}

		$db->free_result();

		// self::$_arrContactCompanyOfficesByContactCompanyId = $arrContactCompanyOfficesByContactCompanyId;

		return $arrContactCompanyOfficesByContactCompanyId;
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
	public static function loadContactCompanyOfficesByAddressCity($database, $address_city, Input $options=null)
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
			self::$_arrContactCompanyOfficesByAddressCity = null;
		}

		$arrContactCompanyOfficesByAddressCity = self::$_arrContactCompanyOfficesByAddressCity;
		if (isset($arrContactCompanyOfficesByAddressCity) && !empty($arrContactCompanyOfficesByAddressCity)) {
			return $arrContactCompanyOfficesByAddressCity;
		}

		$address_city = (string) $address_city;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `contact_company_id` ASC, `office_nickname` ASC, `address_line_1` ASC, `address_line_2` ASC, `address_line_3` ASC, `address_line_4` ASC, `address_city` ASC, `address_county` ASC, `address_state_or_region` ASC, `address_postal_code` ASC, `address_postal_code_extension` ASC, `address_country` ASC, `head_quarters_flag` ASC, `address_validated_by_user_flag` ASC, `address_validated_by_web_service_flag` ASC, `address_validation_by_web_service_error_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpContactCompanyOffice = new ContactCompanyOffice($database);
			$sqlOrderByColumns = $tmpContactCompanyOffice->constructSqlOrderByColumns($arrOrderByAttributes);

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
	cco.*

FROM `contact_company_offices` cco
WHERE cco.`address_city` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `contact_company_id` ASC, `office_nickname` ASC, `address_line_1` ASC, `address_line_2` ASC, `address_line_3` ASC, `address_line_4` ASC, `address_city` ASC, `address_county` ASC, `address_state_or_region` ASC, `address_postal_code` ASC, `address_postal_code_extension` ASC, `address_country` ASC, `head_quarters_flag` ASC, `address_validated_by_user_flag` ASC, `address_validated_by_web_service_flag` ASC, `address_validation_by_web_service_error_flag` ASC
		$arrValues = array($address_city);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrContactCompanyOfficesByAddressCity = array();
		while ($row = $db->fetch()) {
			$contact_company_office_id = $row['id'];
			$contactCompanyOffice = self::instantiateOrm($database, 'ContactCompanyOffice', $row, null, $contact_company_office_id);
			/* @var $contactCompanyOffice ContactCompanyOffice */
			$arrContactCompanyOfficesByAddressCity[$contact_company_office_id] = $contactCompanyOffice;
		}

		$db->free_result();

		self::$_arrContactCompanyOfficesByAddressCity = $arrContactCompanyOfficesByAddressCity;

		return $arrContactCompanyOfficesByAddressCity;
	}

	/**
	 * Load by key `address_state_or_region` (`address_state_or_region`).
	 *
	 * @param string $database
	 * @param string $address_state_or_region
	 * @param mixed (Input $options object | null)
	 * @return mixed (single ORM object | false)
	 */
	public static function loadContactCompanyOfficesByAddressStateOrRegion($database, $address_state_or_region, Input $options=null)
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
			self::$_arrContactCompanyOfficesByAddressStateOrRegion = null;
		}

		$arrContactCompanyOfficesByAddressStateOrRegion = self::$_arrContactCompanyOfficesByAddressStateOrRegion;
		if (isset($arrContactCompanyOfficesByAddressStateOrRegion) && !empty($arrContactCompanyOfficesByAddressStateOrRegion)) {
			return $arrContactCompanyOfficesByAddressStateOrRegion;
		}

		$address_state_or_region = (string) $address_state_or_region;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `contact_company_id` ASC, `office_nickname` ASC, `address_line_1` ASC, `address_line_2` ASC, `address_line_3` ASC, `address_line_4` ASC, `address_city` ASC, `address_county` ASC, `address_state_or_region` ASC, `address_postal_code` ASC, `address_postal_code_extension` ASC, `address_country` ASC, `head_quarters_flag` ASC, `address_validated_by_user_flag` ASC, `address_validated_by_web_service_flag` ASC, `address_validation_by_web_service_error_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpContactCompanyOffice = new ContactCompanyOffice($database);
			$sqlOrderByColumns = $tmpContactCompanyOffice->constructSqlOrderByColumns($arrOrderByAttributes);

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
	cco.*

FROM `contact_company_offices` cco
WHERE cco.`address_state_or_region` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `contact_company_id` ASC, `office_nickname` ASC, `address_line_1` ASC, `address_line_2` ASC, `address_line_3` ASC, `address_line_4` ASC, `address_city` ASC, `address_county` ASC, `address_state_or_region` ASC, `address_postal_code` ASC, `address_postal_code_extension` ASC, `address_country` ASC, `head_quarters_flag` ASC, `address_validated_by_user_flag` ASC, `address_validated_by_web_service_flag` ASC, `address_validation_by_web_service_error_flag` ASC
		$arrValues = array($address_state_or_region);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrContactCompanyOfficesByAddressStateOrRegion = array();
		while ($row = $db->fetch()) {
			$contact_company_office_id = $row['id'];
			$contactCompanyOffice = self::instantiateOrm($database, 'ContactCompanyOffice', $row, null, $contact_company_office_id);
			/* @var $contactCompanyOffice ContactCompanyOffice */
			$arrContactCompanyOfficesByAddressStateOrRegion[$contact_company_office_id] = $contactCompanyOffice;
		}

		$db->free_result();

		self::$_arrContactCompanyOfficesByAddressStateOrRegion = $arrContactCompanyOfficesByAddressStateOrRegion;

		return $arrContactCompanyOfficesByAddressStateOrRegion;
	}

	/**
	 * Load by key `address_postal_code` (`address_postal_code`).
	 *
	 * @param string $database
	 * @param string $address_postal_code
	 * @param mixed (Input $options object | null)
	 * @return mixed (single ORM object | false)
	 */
	public static function loadContactCompanyOfficesByAddressPostalCode($database, $address_postal_code, Input $options=null)
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
			self::$_arrContactCompanyOfficesByAddressPostalCode = null;
		}

		$arrContactCompanyOfficesByAddressPostalCode = self::$_arrContactCompanyOfficesByAddressPostalCode;
		if (isset($arrContactCompanyOfficesByAddressPostalCode) && !empty($arrContactCompanyOfficesByAddressPostalCode)) {
			return $arrContactCompanyOfficesByAddressPostalCode;
		}

		$address_postal_code = (string) $address_postal_code;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `contact_company_id` ASC, `office_nickname` ASC, `address_line_1` ASC, `address_line_2` ASC, `address_line_3` ASC, `address_line_4` ASC, `address_city` ASC, `address_county` ASC, `address_state_or_region` ASC, `address_postal_code` ASC, `address_postal_code_extension` ASC, `address_country` ASC, `head_quarters_flag` ASC, `address_validated_by_user_flag` ASC, `address_validated_by_web_service_flag` ASC, `address_validation_by_web_service_error_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpContactCompanyOffice = new ContactCompanyOffice($database);
			$sqlOrderByColumns = $tmpContactCompanyOffice->constructSqlOrderByColumns($arrOrderByAttributes);

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
	cco.*

FROM `contact_company_offices` cco
WHERE cco.`address_postal_code` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `contact_company_id` ASC, `office_nickname` ASC, `address_line_1` ASC, `address_line_2` ASC, `address_line_3` ASC, `address_line_4` ASC, `address_city` ASC, `address_county` ASC, `address_state_or_region` ASC, `address_postal_code` ASC, `address_postal_code_extension` ASC, `address_country` ASC, `head_quarters_flag` ASC, `address_validated_by_user_flag` ASC, `address_validated_by_web_service_flag` ASC, `address_validation_by_web_service_error_flag` ASC
		$arrValues = array($address_postal_code);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrContactCompanyOfficesByAddressPostalCode = array();
		while ($row = $db->fetch()) {
			$contact_company_office_id = $row['id'];
			$contactCompanyOffice = self::instantiateOrm($database, 'ContactCompanyOffice', $row, null, $contact_company_office_id);
			/* @var $contactCompanyOffice ContactCompanyOffice */
			$arrContactCompanyOfficesByAddressPostalCode[$contact_company_office_id] = $contactCompanyOffice;
		}

		$db->free_result();

		self::$_arrContactCompanyOfficesByAddressPostalCode = $arrContactCompanyOfficesByAddressPostalCode;

		return $arrContactCompanyOfficesByAddressPostalCode;
	}

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all contact_company_offices records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllContactCompanyOffices($database, Input $options=null)
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
			self::$_arrAllContactCompanyOffices = null;
		}

		$arrAllContactCompanyOffices = self::$_arrAllContactCompanyOffices;
		if (isset($arrAllContactCompanyOffices) && !empty($arrAllContactCompanyOffices)) {
			return $arrAllContactCompanyOffices;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `contact_company_id` ASC, `office_nickname` ASC, `address_line_1` ASC, `address_line_2` ASC, `address_line_3` ASC, `address_line_4` ASC, `address_city` ASC, `address_county` ASC, `address_state_or_region` ASC, `address_postal_code` ASC, `address_postal_code_extension` ASC, `address_country` ASC, `head_quarters_flag` ASC, `address_validated_by_user_flag` ASC, `address_validated_by_web_service_flag` ASC, `address_validation_by_web_service_error_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpContactCompanyOffice = new ContactCompanyOffice($database);
			$sqlOrderByColumns = $tmpContactCompanyOffice->constructSqlOrderByColumns($arrOrderByAttributes);

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
	cco.*

FROM `contact_company_offices` cco{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `contact_company_id` ASC, `office_nickname` ASC, `address_line_1` ASC, `address_line_2` ASC, `address_line_3` ASC, `address_line_4` ASC, `address_city` ASC, `address_county` ASC, `address_state_or_region` ASC, `address_postal_code` ASC, `address_postal_code_extension` ASC, `address_country` ASC, `head_quarters_flag` ASC, `address_validated_by_user_flag` ASC, `address_validated_by_web_service_flag` ASC, `address_validation_by_web_service_error_flag` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllContactCompanyOffices = array();
		while ($row = $db->fetch()) {
			$contact_company_office_id = $row['id'];
			$contactCompanyOffice = self::instantiateOrm($database, 'ContactCompanyOffice', $row, null, $contact_company_office_id);
			/* @var $contactCompanyOffice ContactCompanyOffice */
			$arrAllContactCompanyOffices[$contact_company_office_id] = $contactCompanyOffice;
		}

		$db->free_result();

		self::$_arrAllContactCompanyOffices = $arrAllContactCompanyOffices;

		return $arrAllContactCompanyOffices;
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
INTO `contact_company_offices`
(`contact_company_id`, `office_nickname`, `address_line_1`, `address_line_2`, `address_line_3`, `address_line_4`, `address_city`, `address_county`, `address_state_or_region`, `address_postal_code`, `address_postal_code_extension`, `address_country`, `head_quarters_flag`, `address_validated_by_user_flag`, `address_validated_by_web_service_flag`, `address_validation_by_web_service_error_flag`)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
ON DUPLICATE KEY UPDATE `office_nickname` = ?, `head_quarters_flag` = ?, `address_validated_by_user_flag` = ?, `address_validated_by_web_service_flag` = ?, `address_validation_by_web_service_error_flag` = ?
";
		$arrValues = array($this->contact_company_id, $this->office_nickname, $this->address_line_1, $this->address_line_2, $this->address_line_3, $this->address_line_4, $this->address_city, $this->address_county, $this->address_state_or_region, $this->address_postal_code, $this->address_postal_code_extension, $this->address_country, $this->head_quarters_flag, $this->address_validated_by_user_flag, $this->address_validated_by_web_service_flag, $this->address_validation_by_web_service_error_flag, $this->office_nickname, $this->head_quarters_flag, $this->address_validated_by_user_flag, $this->address_validated_by_web_service_flag, $this->address_validation_by_web_service_error_flag);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$contact_company_office_id = $db->insertId;
		$db->free_result();

		return $contact_company_office_id;
	}

	// Save: insert ignore

	// Like if remove it then change other contacts that were using this to the headquarters
	// Or set to zero if this is the last office being deleted

	/**
	 * Delete a contact_company_offices record.
	 *
	 * Actions:
	 * UPDATE/INSERT contacts_to_contact_company_offices records so that all contacts that were using the deleted office now link to the headquarters office.
	 * Delete any contacts_to_contact_company_offices records with the deleted contact_company_office_id value.
	 * DELETE the contact_company_offices record.
	 *
	 * @param unknown_type $database
	 * @return unknown
	 */
	public function deleteOffice()
	{
		if (!isset($this->contact_company_office_id) || empty($this->contact_company_office_id)) {
			return false;
		}

		// id of the contact_company_offices record being deleted
		$deletedContactCompanyOfficeId = $this->contact_company_office_id;

		$database = $this->getDatabase();
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// get the contact_company_id from the office being deleted
		$contactCompanyOffice = new ContactCompanyOffice($database);
		$key = array('id' => $deletedContactCompanyOfficeId);
		$contactCompanyOffice->setKey($key);
		$attributes = array('contact_company_id' => 1);
		$contactCompanyOffice->setAttributes($attributes);
		$contactCompanyOffice->load();
		$contactCompanyOffice->convertDataToProperties();
		$contact_company_id = $contactCompanyOffice->contact_company_id;

		// gather a list of contact_id values linked to the office being deleted
		$query =
"
SELECT c2cco.`contact_id`
FROM `contacts_to_contact_company_offices` c2cco
WHERE c2cco.`contact_company_office_id` = ?
";
		$arrValues = array($deletedContactCompanyOfficeId);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$arrContactIds = array();
		while ($row = $db->fetch()) {
			$contact_id = $row['contact_id'];
			$arrContactIds[] = $contact_id;
		}
		$db->free_result();

		// find an office to link against
		$query =
"
SELECT `id` 'contact_company_office_id'
FROM `contact_company_offices`
WHERE `contact_company_id` = ?
AND `id` <> $deletedContactCompanyOfficeId
ORDER BY `head_quarters_flag` DESC
";
		$arrValues = array($contact_company_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$arrContactCompanyOfficeIds = array();
		$counter = 0;
		while ($row = $db->fetch()) {
			$contact_company_office_id = $row['contact_company_office_id'];
			$arrContactCompanyOfficeIds[$counter] = $contact_company_office_id;
			$counter++;
		}
		$db->free_result();

		// UPDATE/INSERT contacts_to_contact_company_offices records so that all contacts that were using the deleted office now link to the headquarters office.
		if (!empty($arrContactCompanyOfficeIds)) {
			$newContactCompanyOfficeId = $arrContactCompanyOfficeIds[0];
		} else {
			$newContactCompanyOfficeId = false;
		}

		$db->begin();

		foreach ($arrContactIds as $contact_id) {
			if ($newContactCompanyOfficeId) {
				$contactToContactCompanyOffice = new ContactToContactCompanyOffice($database);
				$contactToContactCompanyOffice->contact_id = $contact_id;
				$contactToContactCompanyOffice->contact_company_office_id = $contact_company_office_id;
				$contactToContactCompanyOffice->primary_office_flag = 'Y';
				$contactToContactCompanyOffice->convertPropertiesToData();
				$contactToContactCompanyOffice->save();
			}

			// Delete the old associations
			$contactToContactCompanyOffice = new ContactToContactCompanyOffice($database);
			$key = array(
				'contact_id' => $contact_id,
				'contact_company_office_id' => $deletedContactCompanyOfficeId
			);
			$contactToContactCompanyOffice->setKey($key);
			$contactToContactCompanyOffice->delete();
		}

		// delete the office
		$contactCompanyOffice = new ContactCompanyOffice($database);
		$key = array('id' => $deletedContactCompanyOfficeId);
		$contactCompanyOffice->setKey($key);
		$contactCompanyOffice->delete();

		$db->commit();

		return true;
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
		// unique index (`contact_company_id`, `address_line_1`, `address_line_2`, `address_line_3`, `address_line_4`, `address_city`, `address_county`, `address_state_or_region`, `address_postal_code`, `address_postal_code_extension`),
		// These fields taken as a composite are the primary key of contact_company_offices
		$contact_company_id = $this->contact_company_id;
		$address_line_1 = (string) $this->address_line_1;
		$address_line_2 = (string) $this->address_line_2;
		$address_line_3 = (string) $this->address_line_3;
		$address_line_4 = (string) $this->address_line_4;
		$address_city = (string) $this->address_city;
		$address_county = (string) $this->address_county;
		$address_state_or_region = (string) $this->address_state_or_region;
		$address_postal_code = (string) $this->address_postal_code;
		$address_postal_code_extension = (string) $this->address_postal_code_extension;
		$address_country = (string) $this->address_country;

		$key = array(
			'contact_company_id' => $contact_company_id,
			'address_line_1' => $address_line_1,
			'address_line_2' => $address_line_2,
			'address_line_3' => $address_line_3,
			'address_line_4' => $address_line_4,
			'address_city' => $address_city,
			'address_county' => $address_county,
			'address_state_or_region' => $address_state_or_region,
			'address_postal_code' => $address_postal_code,
			'address_postal_code_extension' => $address_postal_code_extension,
			'address_country' => $address_country
		);

		$database = $this->getDatabase();
		$tmpObject = new ContactCompanyOffice($database);
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
			//Uniquely identified records may wind up having the landing_page_url change
			//unset($tmpObject->landing_page_url);
			unset($tmpObject->modified);
			unset($tmpObject->created);
			//This attribute shouldn't even be in these tables
			unset($tmpObject->disabled_flag);
			//This attribute shouldn't even be in these tables
			unset($tmpObject->deleted_flag);
			//Uniquely identified records may wind up having the landing_page_url change
			//unset($newData['landing_page_url']);
			//not tracking deleted_flag in the details tables
			//$newData['deleted_flag'] = 0;

			$existingData = $tmpObject->getData();

			//debug
			/*
			$keyDiffFlag = Data::diffKeys($existingData, $newData);
			if (!$keyDiffFlag) {
				echo "Key:\n".print_r($key, true)."\n\n\n\n";
				echo 'Existing:'."\n";
				ksort($existingData);
				print_r($existingData);
				echo 'New:'."\n";
				ksort($newData);
				print_r($newData);
				$n = array_keys($newData);
				$e = array_keys($existingData);
				$_1 = array_diff_key($n, $e);
				echo 'New:'."\n";
				print_r($_1);
				$_2 = array_diff_key($e, $n);
				echo 'Old:'."\n";
				print_r($_2);
				throw new Exception('Keys mismatch');
			}
			*/

			$data = Data::deltify($existingData, $newData);
			if (!empty($data)) {
				$tmpObject->setData($data);
				$save = true;
			}
		} else {
			// Insert the record
			$tmpObject->setKey(null);
			$tmpObject->setData($newData);
			//Add value for created timestamp.
			//$tmpObject->created = null;
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
	//contact company address
	public static function loadCompanyForContact($database, $contact_company_id)
	{
		$contact_company_id = (int) $contact_company_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		 $query ="SELECT 	cco.*

FROM `contact_company_offices` cco
WHERE cco.`id` = ?
";
		$arrValues = array($contact_company_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if (isset($row) && !empty($row)) {
			$contactCompanyOffice = self::instantiateOrm($database, 'ContactCompanyOffice', $row);
			/* @var $contactCompanyOffice ContactCompanyOffice */
		} else {
			$contactCompanyOffice = false;
		}
		
		return $contactCompanyOffice;
	}

	public static function loadContactCompanyOfficeHeadquartersByContactCompanyId($database, $contact_company_id)
	{
		$contact_company_id = (int) $contact_company_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	cco.*

FROM `contact_company_offices` cco
WHERE cco.`contact_company_id` = ?
AND cco.`head_quarters_flag` = 'Y'
";
		$arrValues = array($contact_company_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if (isset($row) && !empty($row)) {
			$contactCompanyOffice = self::instantiateOrm($database, 'ContactCompanyOffice', $row);
			/* @var $contactCompanyOffice ContactCompanyOffice */
		} else {
			$contactCompanyOffice = false;
		}

		return $contactCompanyOffice;
	}
	/*check contact company office address if exists or not*/
	public static function verifyContactCompanyOfficeUsingContactCompanyId($database, $contact_company_id, $address_city, $address_line_1)
	{
		$contact_company_id = (int) $contact_company_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	cco.*

FROM `contact_company_offices` cco
WHERE cco.`contact_company_id` = ?
AND cco.`address_line_1` = ?
AND cco.`address_city` = ?
";
		$arrValues = array($contact_company_id, $address_line_1, $address_city);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if (isset($row) && !empty($row)) {
			$contactCompanyOfficeId = $row['id'];
			/* @var $contactCompanyOffice ContactCompanyOffice */
		} else {
			$contactCompanyOfficeId = '';
		}

		return $contactCompanyOfficeId;
	}
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

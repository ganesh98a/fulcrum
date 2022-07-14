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
 * ContactCompanyOfficeHeadquarters.
 *
 * @category   Framework
 * @package    ContactCompanyOfficeHeadquarters
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class ContactCompanyOfficeHeadquarters extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'ContactCompanyOfficeHeadquarters';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'contact_company_office_headquarters';

	/**
	 * primary key (`contact_company_id`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrPrimaryKey = array(
		'contact_company_id' => 'int'
	);

	/**
	 * No Unique Indexes, Just a Primary Key
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_contact_company_office_headquarters_via_primary_key' => array(
			'contact_company_id' => 'int'
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
		'contact_company_id' => 'contact_company_id',

		'contact_company_office_id' => 'contact_company_office_id'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $contact_company_id;

	public $contact_company_office_id;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties

	// HTML ENTITY ENCODED NL2BR ORM string properties

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)
	protected static $_arrContactCompanyOfficeHeadquartersByContactCompanyId;
	protected static $_arrContactCompanyOfficeHeadquartersByContactCompanyOfficeId;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllContactCompanyOfficeHeadquarters;

	// Foreign Key Objects
	private $_contactCompany;
	private $_contactCompanyOffice;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='contact_company_office_headquarters')
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

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)
	public static function getArrContactCompanyOfficeHeadquartersByContactCompanyId()
	{
		if (isset(self::$_arrContactCompanyOfficeHeadquartersByContactCompanyId)) {
			return self::$_arrContactCompanyOfficeHeadquartersByContactCompanyId;
		} else {
			return null;
		}
	}

	public static function setArrContactCompanyOfficeHeadquartersByContactCompanyId($arrContactCompanyOfficeHeadquartersByContactCompanyId)
	{
		self::$_arrContactCompanyOfficeHeadquartersByContactCompanyId = $arrContactCompanyOfficeHeadquartersByContactCompanyId;
	}

	public static function getArrContactCompanyOfficeHeadquartersByContactCompanyOfficeId()
	{
		if (isset(self::$_arrContactCompanyOfficeHeadquartersByContactCompanyOfficeId)) {
			return self::$_arrContactCompanyOfficeHeadquartersByContactCompanyOfficeId;
		} else {
			return null;
		}
	}

	public static function setArrContactCompanyOfficeHeadquartersByContactCompanyOfficeId($arrContactCompanyOfficeHeadquartersByContactCompanyOfficeId)
	{
		self::$_arrContactCompanyOfficeHeadquartersByContactCompanyOfficeId = $arrContactCompanyOfficeHeadquartersByContactCompanyOfficeId;
	}

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllContactCompanyOfficeHeadquarters()
	{
		if (isset(self::$_arrAllContactCompanyOfficeHeadquarters)) {
			return self::$_arrAllContactCompanyOfficeHeadquarters;
		} else {
			return null;
		}
	}

	public static function setArrAllContactCompanyOfficeHeadquarters($arrAllContactCompanyOfficeHeadquarters)
	{
		self::$_arrAllContactCompanyOfficeHeadquarters = $arrAllContactCompanyOfficeHeadquarters;
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
	 * Find by primary key (`contact_company_id`).
	 *
	 * @param string $database
	 * @param int $contact_company_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findByContactCompanyId($database, $contact_company_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	ccoh.*

FROM `contact_company_office_headquarters` ccoh
WHERE ccoh.`contact_company_id` = ?
";
		$arrValues = array($contact_company_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row && !empty($row)) {
			$contactCompanyOfficeHeadquarters = self::instantiateOrm($database, 'ContactCompanyOfficeHeadquarters', $row);
			/* @var $contactCompanyOfficeHeadquarters ContactCompanyOfficeHeadquarters */
			return $contactCompanyOfficeHeadquarters;
		} else {
			return false;
		}
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Find by primary key (`contact_company_id`) Extended.
	 *
	 * @param string $database
	 * @param int $contact_company_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findByContactCompanyIdExtended($database, $contact_company_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	ccoh_fk_cc.`id` AS 'ccoh_fk_cc__contact_company_id',
	ccoh_fk_cc.`user_user_company_id` AS 'ccoh_fk_cc__user_user_company_id',
	ccoh_fk_cc.`contact_user_company_id` AS 'ccoh_fk_cc__contact_user_company_id',
	ccoh_fk_cc.`company` AS 'ccoh_fk_cc__company',
	ccoh_fk_cc.`primary_phone_number` AS 'ccoh_fk_cc__primary_phone_number',
	ccoh_fk_cc.`employer_identification_number` AS 'ccoh_fk_cc__employer_identification_number',
	ccoh_fk_cc.`construction_license_number` AS 'ccoh_fk_cc__construction_license_number',
	ccoh_fk_cc.`construction_license_number_expiration_date` AS 'ccoh_fk_cc__construction_license_number_expiration_date',
	ccoh_fk_cc.`vendor_flag` AS 'ccoh_fk_cc__vendor_flag',

	ccoh_fk_cco.`id` AS 'ccoh_fk_cco__contact_company_office_id',
	ccoh_fk_cco.`contact_company_id` AS 'ccoh_fk_cco__contact_company_id',
	ccoh_fk_cco.`office_nickname` AS 'ccoh_fk_cco__office_nickname',
	ccoh_fk_cco.`address_line_1` AS 'ccoh_fk_cco__address_line_1',
	ccoh_fk_cco.`address_line_2` AS 'ccoh_fk_cco__address_line_2',
	ccoh_fk_cco.`address_line_3` AS 'ccoh_fk_cco__address_line_3',
	ccoh_fk_cco.`address_line_4` AS 'ccoh_fk_cco__address_line_4',
	ccoh_fk_cco.`address_city` AS 'ccoh_fk_cco__address_city',
	ccoh_fk_cco.`address_county` AS 'ccoh_fk_cco__address_county',
	ccoh_fk_cco.`address_state_or_region` AS 'ccoh_fk_cco__address_state_or_region',
	ccoh_fk_cco.`address_postal_code` AS 'ccoh_fk_cco__address_postal_code',
	ccoh_fk_cco.`address_postal_code_extension` AS 'ccoh_fk_cco__address_postal_code_extension',
	ccoh_fk_cco.`address_country` AS 'ccoh_fk_cco__address_country',
	ccoh_fk_cco.`head_quarters_flag` AS 'ccoh_fk_cco__head_quarters_flag',
	ccoh_fk_cco.`address_validated_by_user_flag` AS 'ccoh_fk_cco__address_validated_by_user_flag',
	ccoh_fk_cco.`address_validated_by_web_service_flag` AS 'ccoh_fk_cco__address_validated_by_web_service_flag',
	ccoh_fk_cco.`address_validation_by_web_service_error_flag` AS 'ccoh_fk_cco__address_validation_by_web_service_error_flag',

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

	ccoh.*

FROM `contact_company_office_headquarters` ccoh
	INNER JOIN `contact_companies` ccoh_fk_cc ON ccoh.`contact_company_id` = ccoh_fk_cc.`id`
	INNER JOIN `contact_company_offices` ccoh_fk_cco ON ccoh.`contact_company_office_id` = ccoh_fk_cco.`id`

	LEFT OUTER JOIN `contact_company_office_phone_numbers` business_phone ON (ccoh_fk_cco.`id` = business_phone.`contact_company_office_id` AND business_phone.`phone_number_type_id` = 1)
	LEFT OUTER JOIN `contact_company_office_phone_numbers` business_fax ON (ccoh_fk_cco.`id` = business_fax.`contact_company_office_id` AND business_fax.`phone_number_type_id` = 2)
WHERE ccoh.`contact_company_id` = ?
";
		$arrValues = array($contact_company_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row && !empty($row)) {
			$contactCompanyOfficeHeadquarters = self::instantiateOrm($database, 'ContactCompanyOfficeHeadquarters', $row);
			/* @var $contactCompanyOfficeHeadquarters ContactCompanyOfficeHeadquarters */
			$contactCompanyOfficeHeadquarters->convertPropertiesToData();

			if (isset($row['contact_company_id'])) {
				$contact_company_id = $row['contact_company_id'];
				$row['ccoh_fk_cc__id'] = $contact_company_id;
				$contactCompany = self::instantiateOrm($database, 'ContactCompany', $row, null, $contact_company_id, 'ccoh_fk_cc__');
				/* @var $contactCompany ContactCompany */
				$contactCompany->convertPropertiesToData();
			} else {
				$contactCompany = false;
			}
			$contactCompanyOfficeHeadquarters->setContactCompany($contactCompany);

			if (isset($row['contact_company_office_id'])) {
				$contact_company_office_id = $row['contact_company_office_id'];
				$row['ccoh_fk_cco__id'] = $contact_company_office_id;
				$contactCompanyOffice = self::instantiateOrm($database, 'ContactCompanyOffice', $row, null, $contact_company_office_id, 'ccoh_fk_cco__');
				/* @var $contactCompanyOffice ContactCompanyOffice */
				$contactCompanyOffice->convertPropertiesToData();
			} else {
				$contactCompanyOffice = false;
			}
			$contactCompanyOfficeHeadquarters->setContactCompanyOffice($contactCompanyOffice);

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

			return $contactCompanyOfficeHeadquarters;
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
	 * @param array $arrContactCompanyIdList
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadContactCompanyOfficeHeadquartersByArrContactCompanyIdList($database, $arrContactCompanyIdList, Input $options=null)
	{
		if (empty($arrContactCompanyIdList)) {
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
		// ORDER BY `contact_company_id` ASC, `contact_company_office_id` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpContactCompanyOfficeHeadquarters = new ContactCompanyOfficeHeadquarters($database);
			$sqlOrderByColumns = $tmpContactCompanyOfficeHeadquarters->constructSqlOrderByColumns($arrOrderByAttributes);

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
		foreach ($arrContactCompanyIdList as $k => $arrTmp) {
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
		if (count($arrContactCompanyIdList) > 1) {
			$sqlWhere = join($arrSqlWhere, ' OR ');
			$sqlWhere = "WHERE ($sqlWhere)";
		} else {
			$sqlWhere = "WHERE $tmpInnerAnd";
		}

		$query =
"
SELECT

	ccoh.*

FROM `contact_company_office_headquarters` ccoh
{$sqlWhere}{$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrContactCompanyOfficeHeadquartersByArrContactCompanyIdList = array();
		while ($row = $db->fetch()) {
			$contactCompanyOfficeHeadquarters = self::instantiateOrm($database, 'ContactCompanyOfficeHeadquarters', $row);
			/* @var $contactCompanyOfficeHeadquarters ContactCompanyOfficeHeadquarters */
			$arrContactCompanyOfficeHeadquartersByArrContactCompanyIdList[] = $contactCompanyOfficeHeadquarters;
		}

		$db->free_result();

		return $arrContactCompanyOfficeHeadquartersByArrContactCompanyIdList;
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `contact_company_office_headquarters_fk_cc` foreign key (`contact_company_id`) references `contact_companies` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $contact_company_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadContactCompanyOfficeHeadquartersByContactCompanyId($database, $contact_company_id, Input $options=null)
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
			self::$_arrContactCompanyOfficeHeadquartersByContactCompanyId = null;
		}

		$arrContactCompanyOfficeHeadquartersByContactCompanyId = self::$_arrContactCompanyOfficeHeadquartersByContactCompanyId;
		if (isset($arrContactCompanyOfficeHeadquartersByContactCompanyId) && !empty($arrContactCompanyOfficeHeadquartersByContactCompanyId)) {
			return $arrContactCompanyOfficeHeadquartersByContactCompanyId;
		}

		$contact_company_id = (int) $contact_company_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `contact_company_id` ASC, `contact_company_office_id` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpContactCompanyOfficeHeadquarters = new ContactCompanyOfficeHeadquarters($database);
			$sqlOrderByColumns = $tmpContactCompanyOfficeHeadquarters->constructSqlOrderByColumns($arrOrderByAttributes);

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
	ccoh.*

FROM `contact_company_office_headquarters` ccoh
WHERE ccoh.`contact_company_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `contact_company_id` ASC, `contact_company_office_id` ASC
		$arrValues = array($contact_company_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrContactCompanyOfficeHeadquartersByContactCompanyId = array();
		while ($row = $db->fetch()) {
			$contactCompanyOfficeHeadquarters = self::instantiateOrm($database, 'ContactCompanyOfficeHeadquarters', $row);
			/* @var $contactCompanyOfficeHeadquarters ContactCompanyOfficeHeadquarters */
			$arrContactCompanyOfficeHeadquartersByContactCompanyId[] = $contactCompanyOfficeHeadquarters;
		}

		$db->free_result();

		self::$_arrContactCompanyOfficeHeadquartersByContactCompanyId = $arrContactCompanyOfficeHeadquartersByContactCompanyId;

		return $arrContactCompanyOfficeHeadquartersByContactCompanyId;
	}

	/**
	 * Load by constraint `contact_company_office_headquarters_fk_cco` foreign key (`contact_company_office_id`) references `contact_company_offices` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $contact_company_office_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadContactCompanyOfficeHeadquartersByContactCompanyOfficeId($database, $contact_company_office_id, Input $options=null)
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
			self::$_arrContactCompanyOfficeHeadquartersByContactCompanyOfficeId = null;
		}

		$arrContactCompanyOfficeHeadquartersByContactCompanyOfficeId = self::$_arrContactCompanyOfficeHeadquartersByContactCompanyOfficeId;
		if (isset($arrContactCompanyOfficeHeadquartersByContactCompanyOfficeId) && !empty($arrContactCompanyOfficeHeadquartersByContactCompanyOfficeId)) {
			return $arrContactCompanyOfficeHeadquartersByContactCompanyOfficeId;
		}

		$contact_company_office_id = (int) $contact_company_office_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `contact_company_id` ASC, `contact_company_office_id` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpContactCompanyOfficeHeadquarters = new ContactCompanyOfficeHeadquarters($database);
			$sqlOrderByColumns = $tmpContactCompanyOfficeHeadquarters->constructSqlOrderByColumns($arrOrderByAttributes);

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
	ccoh.*

FROM `contact_company_office_headquarters` ccoh
WHERE ccoh.`contact_company_office_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `contact_company_id` ASC, `contact_company_office_id` ASC
		$arrValues = array($contact_company_office_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrContactCompanyOfficeHeadquartersByContactCompanyOfficeId = array();
		while ($row = $db->fetch()) {
			$contactCompanyOfficeHeadquarters = self::instantiateOrm($database, 'ContactCompanyOfficeHeadquarters', $row);
			/* @var $contactCompanyOfficeHeadquarters ContactCompanyOfficeHeadquarters */
			$arrContactCompanyOfficeHeadquartersByContactCompanyOfficeId[] = $contactCompanyOfficeHeadquarters;
		}

		$db->free_result();

		self::$_arrContactCompanyOfficeHeadquartersByContactCompanyOfficeId = $arrContactCompanyOfficeHeadquartersByContactCompanyOfficeId;

		return $arrContactCompanyOfficeHeadquartersByContactCompanyOfficeId;
	}

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all contact_company_office_headquarters records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllContactCompanyOfficeHeadquarters($database, Input $options=null)
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
			self::$_arrAllContactCompanyOfficeHeadquarters = null;
		}

		$arrAllContactCompanyOfficeHeadquarters = self::$_arrAllContactCompanyOfficeHeadquarters;
		if (isset($arrAllContactCompanyOfficeHeadquarters) && !empty($arrAllContactCompanyOfficeHeadquarters)) {
			return $arrAllContactCompanyOfficeHeadquarters;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `contact_company_id` ASC, `contact_company_office_id` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpContactCompanyOfficeHeadquarters = new ContactCompanyOfficeHeadquarters($database);
			$sqlOrderByColumns = $tmpContactCompanyOfficeHeadquarters->constructSqlOrderByColumns($arrOrderByAttributes);

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
	ccoh.*

FROM `contact_company_office_headquarters` ccoh{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `contact_company_id` ASC, `contact_company_office_id` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllContactCompanyOfficeHeadquarters = array();
		while ($row = $db->fetch()) {
			$contactCompanyOfficeHeadquarters = self::instantiateOrm($database, 'ContactCompanyOfficeHeadquarters', $row);
			/* @var $contactCompanyOfficeHeadquarters ContactCompanyOfficeHeadquarters */
			$arrAllContactCompanyOfficeHeadquarters[] = $contactCompanyOfficeHeadquarters;
		}

		$db->free_result();

		self::$_arrAllContactCompanyOfficeHeadquarters = $arrAllContactCompanyOfficeHeadquarters;

		return $arrAllContactCompanyOfficeHeadquarters;
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
INTO `contact_company_office_headquarters`
(`contact_company_id`, `contact_company_office_id`)
VALUES (?, ?)
ON DUPLICATE KEY UPDATE `contact_company_office_id` = ?
";
		$arrValues = array($this->contact_company_id, $this->contact_company_office_id, $this->contact_company_office_id);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$contact_company_office_headquarters_id = $db->insertId;
		$db->free_result();

		return $contact_company_office_headquarters_id;
	}

	// Save: insert ignore
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

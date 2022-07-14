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
 * ContactCompany.
 *
 * @category   Framework
 * @package    ContactCompany
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class ContactCompany extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'ContactCompany';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'contact_companies';

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
	 * unique index `unique_contact_company` (`user_user_company_id`,`company`,`primary_phone_number`,`employer_identification_number`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_contact_company' => array(
		'user_user_company_id' => 'int',
		'company' => 'string',
		'primary_phone_number' => 'string',
		'employer_identification_number' => 'string'
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
		'id' => 'contact_company_id',

		'user_user_company_id' => 'user_user_company_id',
		'contact_user_company_id' => 'contact_user_company_id',

		'company' => 'contact_company_name',
		'primary_phone_number' => 'primary_phone_number',
		'employer_identification_number' => 'employer_identification_number',

		'construction_license_number' => 'construction_license_number',
		'construction_license_number_expiration_date' => 'construction_license_number_expiration_date',
		'vendor_flag' => 'vendor_flag'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $contact_company_id;

	public $user_user_company_id;
	public $contact_user_company_id;

	public $contact_company_name;
	public $primary_phone_number;
	public $employer_identification_number;

	public $construction_license_number;
	public $construction_license_number_expiration_date;
	public $vendor_flag;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties
	public $escaped_contact_company_name;
	public $escaped_primary_phone_number;
	public $escaped_employer_identification_number;
	public $escaped_construction_license_number;

	// HTML ENTITY ENCODED NL2BR ORM string properties
	public $escaped_company_nl2br;
	public $escaped_primary_phone_number_nl2br;
	public $escaped_employer_identification_number_nl2br;
	public $escaped_construction_license_number_nl2br;

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)
	protected static $_arrContactCompaniesByUserUserCompanyId;
	protected static $_arrContactCompaniesByContactUserCompanyId;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)
	protected static $_arrContactCompaniesByCompany;
	protected static $_arrContactCompaniesByPrimaryPhoneNumber;
	protected static $_arrContactCompaniesByEmployerIdentificationNumber;
	protected static $_arrContactCompaniesByConstructionLicenseNumber;

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllContactCompanies;

	// Foreign Key Objects
	private $_userUserCompany;
	private $_contactUserCompany;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='contact_companies')
	{
		parent::__construct($table);
		$this->setDatabase($database);
	}

	// Foreign Key Object Accessor Methods
	public function getUserUserCompany()
	{
		if (isset($this->_userUserCompany)) {
			return $this->_userUserCompany;
		} else {
			return null;
		}
	}

	public function setUserUserCompany($userUserCompany)
	{
		$this->_userUserCompany = $userUserCompany;
	}

	public function getContactUserCompany()
	{
		if (isset($this->_contactUserCompany)) {
			return $this->_contactUserCompany;
		} else {
			return null;
		}
	}

	public function setContactUserCompany($contactUserCompany)
	{
		$this->_contactUserCompany = $contactUserCompany;
	}

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)
	public static function getArrContactCompaniesByUserUserCompanyId()
	{
		if (isset(self::$_arrContactCompaniesByUserUserCompanyId)) {
			return self::$_arrContactCompaniesByUserUserCompanyId;
		} else {
			return null;
		}
	}

	public static function setArrContactCompaniesByUserUserCompanyId($arrContactCompaniesByUserUserCompanyId)
	{
		self::$_arrContactCompaniesByUserUserCompanyId = $arrContactCompaniesByUserUserCompanyId;
	}

	public static function getArrContactCompaniesByContactUserCompanyId()
	{
		if (isset(self::$_arrContactCompaniesByContactUserCompanyId)) {
			return self::$_arrContactCompaniesByContactUserCompanyId;
		} else {
			return null;
		}
	}

	public static function setArrContactCompaniesByContactUserCompanyId($arrContactCompaniesByContactUserCompanyId)
	{
		self::$_arrContactCompaniesByContactUserCompanyId = $arrContactCompaniesByContactUserCompanyId;
	}

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)
	public static function getArrContactCompaniesByCompany()
	{
		if (isset(self::$_arrContactCompaniesByCompany)) {
			return self::$_arrContactCompaniesByCompany;
		} else {
			return null;
		}
	}

	public static function setArrContactCompaniesByCompany($arrContactCompaniesByCompany)
	{
		self::$_arrContactCompaniesByCompany = $arrContactCompaniesByCompany;
	}

	public static function getArrContactCompaniesByPrimaryPhoneNumber()
	{
		if (isset(self::$_arrContactCompaniesByPrimaryPhoneNumber)) {
			return self::$_arrContactCompaniesByPrimaryPhoneNumber;
		} else {
			return null;
		}
	}

	public static function setArrContactCompaniesByPrimaryPhoneNumber($arrContactCompaniesByPrimaryPhoneNumber)
	{
		self::$_arrContactCompaniesByPrimaryPhoneNumber = $arrContactCompaniesByPrimaryPhoneNumber;
	}

	public static function getArrContactCompaniesByEmployerIdentificationNumber()
	{
		if (isset(self::$_arrContactCompaniesByEmployerIdentificationNumber)) {
			return self::$_arrContactCompaniesByEmployerIdentificationNumber;
		} else {
			return null;
		}
	}

	public static function setArrContactCompaniesByEmployerIdentificationNumber($arrContactCompaniesByEmployerIdentificationNumber)
	{
		self::$_arrContactCompaniesByEmployerIdentificationNumber = $arrContactCompaniesByEmployerIdentificationNumber;
	}

	public static function getArrContactCompaniesByConstructionLicenseNumber()
	{
		if (isset(self::$_arrContactCompaniesByConstructionLicenseNumber)) {
			return self::$_arrContactCompaniesByConstructionLicenseNumber;
		} else {
			return null;
		}
	}

	public static function setArrContactCompaniesByConstructionLicenseNumber($arrContactCompaniesByConstructionLicenseNumber)
	{
		self::$_arrContactCompaniesByConstructionLicenseNumber = $arrContactCompaniesByConstructionLicenseNumber;
	}

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllContactCompanies()
	{
		if (isset(self::$_arrAllContactCompanies)) {
			return self::$_arrAllContactCompanies;
		} else {
			return null;
		}
	}

	public static function setArrAllContactCompanies($arrAllContactCompanies)
	{
		self::$_arrAllContactCompanies = $arrAllContactCompanies;
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
	 * @param int $contact_company_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findById($database, $contact_company_id, $table='contact_companies', $module='ContactCompany')
	{
		$contactCompany = parent::findById($database, $contact_company_id, $table, $module);

		return $contactCompany;
	}

	public static function findByContactUserCompanyId($database, $contact_company_id)
	{
		$contact_company_id = (int) $contact_company_id;
		$db = DBI::getInstance($database);
		$query = 
			"SELECT 
				company 
			FROM `contact_companies` 
			WHERE `id` = ?
		";
		$arrValues = array($contact_company_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		return $row['company'];
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Similar to FindById, but with SQL as starter code for more complex joins.
	 *
	 * @param string $database
	 * @param int $contact_company_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findContactCompanyByIdExtended($database, $contact_company_id)
	{
		$contact_company_id = (int) $contact_company_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	cc_fk_user_uc.`id` AS 'cc_fk_user_uc__user_company_id',
	cc_fk_user_uc.`company` AS 'cc_fk_user_uc__company',
	cc_fk_user_uc.`primary_phone_number` AS 'cc_fk_user_uc__primary_phone_number',
	cc_fk_user_uc.`employer_identification_number` AS 'cc_fk_user_uc__employer_identification_number',
	cc_fk_user_uc.`construction_license_number` AS 'cc_fk_user_uc__construction_license_number',
	cc_fk_user_uc.`construction_license_number_expiration_date` AS 'cc_fk_user_uc__construction_license_number_expiration_date',
	cc_fk_user_uc.`paying_customer_flag` AS 'cc_fk_user_uc__paying_customer_flag',

	cc_fk_contact_uc.`id` AS 'cc_fk_contact_uc__user_company_id',
	cc_fk_contact_uc.`company` AS 'cc_fk_contact_uc__company',
	cc_fk_contact_uc.`primary_phone_number` AS 'cc_fk_contact_uc__primary_phone_number',
	cc_fk_contact_uc.`employer_identification_number` AS 'cc_fk_contact_uc__employer_identification_number',
	cc_fk_contact_uc.`construction_license_number` AS 'cc_fk_contact_uc__construction_license_number',
	cc_fk_contact_uc.`construction_license_number_expiration_date` AS 'cc_fk_contact_uc__construction_license_number_expiration_date',
	cc_fk_contact_uc.`paying_customer_flag` AS 'cc_fk_contact_uc__paying_customer_flag',

	cc.*

FROM `contact_companies` cc
	INNER JOIN `user_companies` cc_fk_user_uc ON cc.`user_user_company_id` = cc_fk_user_uc.`id`
	INNER JOIN `user_companies` cc_fk_contact_uc ON cc.`contact_user_company_id` = cc_fk_contact_uc.`id`
WHERE cc.`id` = ?
";
		$arrValues = array($contact_company_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$contact_company_id = $row['id'];
			$contactCompany = self::instantiateOrm($database, 'ContactCompany', $row, null, $contact_company_id);
			/* @var $contactCompany ContactCompany */
			$contactCompany->convertPropertiesToData();

			if (isset($row['user_user_company_id'])) {
				$user_user_company_id = $row['user_user_company_id'];
				$row['cc_fk_user_uc__id'] = $user_user_company_id;
				$userUserCompany = self::instantiateOrm($database, 'UserCompany', $row, null, $user_user_company_id, 'cc_fk_user_uc__');
				/* @var $userUserCompany UserCompany */
				$userUserCompany->convertPropertiesToData();
			} else {
				$userUserCompany = false;
			}
			$contactCompany->setUserUserCompany($userUserCompany);

			if (isset($row['contact_user_company_id'])) {
				$contact_user_company_id = $row['contact_user_company_id'];
				$row['cc_fk_contact_uc__id'] = $contact_user_company_id;
				$contactUserCompany = self::instantiateOrm($database, 'UserCompany', $row, null, $contact_user_company_id, 'cc_fk_contact_uc__');
				/* @var $contactUserCompany UserCompany */
				$contactUserCompany->convertPropertiesToData();
			} else {
				$contactUserCompany = false;
			}
			$contactCompany->setContactUserCompany($contactUserCompany);

			return $contactCompany;
		} else {
			return false;
		}
	}

	// Finders: Find By Unique Index
	/**
	 * Find by unique index `unique_contact_company` (`user_user_company_id`,`company`,`primary_phone_number`,`employer_identification_number`).
	 *
	 * @param string $database
	 * @param int $user_user_company_id
	 * @param string $company
	 * @param string $primary_phone_number
	 * @param string $employer_identification_number
	 * @return mixed (single ORM object | false)
	 */
	public static function findByUserUserCompanyIdAndCompanyAndPrimaryPhoneNumberAndEmployerIdentificationNumber($database, $user_user_company_id, $company, $primary_phone_number, $employer_identification_number)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	cc.*

FROM `contact_companies` cc
WHERE cc.`user_user_company_id` = ?
AND cc.`company` = ?
AND cc.`primary_phone_number` = ?
AND cc.`employer_identification_number` = ?
";
		$arrValues = array($user_user_company_id, $company, $primary_phone_number, $employer_identification_number);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if ($row && !empty($row)) {
			$contact_company_id = $row['id'];
			$contactCompany = self::instantiateOrm($database, 'ContactCompany', $row, null, $contact_company_id);
			/* @var $contactCompany ContactCompany */
			return $contactCompany;
		} else {
			return false;
		}
	}

	// Loaders: Load By pk List (list of auto int ids or other non auto int pk list)
	/**
	 * Load zero or more records by an id list (array of auto int primary keys).
	 *
	 * @param string $database
	 * @param array $arrContactCompanyIds
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadContactCompaniesByArrContactCompanyIds($database, $arrContactCompanyIds, Input $options=null)
	{
		if (empty($arrContactCompanyIds)) {
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
		// ORDER BY `id` ASC, `user_user_company_id` ASC, `contact_user_company_id` ASC, `company` ASC, `primary_phone_number` ASC, `employer_identification_number` ASC, `construction_license_number` ASC, `construction_license_number_expiration_date` ASC, `vendor_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpContactCompany = new ContactCompany($database);
			$sqlOrderByColumns = $tmpContactCompany->constructSqlOrderByColumns($arrOrderByAttributes);

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

		foreach ($arrContactCompanyIds as $k => $contact_company_id) {
			$contact_company_id = (int) $contact_company_id;
			$arrContactCompanyIds[$k] = $db->escape($contact_company_id);
		}
		$csvContactCompanyIds = join(',', $arrContactCompanyIds);

		$query =
"
SELECT

	cc.*

FROM `contact_companies` cc
WHERE cc.`id` IN ($csvContactCompanyIds){$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		$arrContactCompaniesByCsvContactCompanyIds = array();
		while ($row = $db->fetch()) {
			$contact_company_id = $row['id'];
			$contactCompany = self::instantiateOrm($database, 'ContactCompany', $row, null, $contact_company_id);
			/* @var $contactCompany ContactCompany */
			$contactCompany->convertPropertiesToData();

			$arrContactCompaniesByCsvContactCompanyIds[$contact_company_id] = $contactCompany;
		}

		$db->free_result();

		return $arrContactCompaniesByCsvContactCompanyIds;
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `contact_companies_fk_user_uc` foreign key (`user_user_company_id`) references `user_companies` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $user_user_company_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadContactCompaniesByUserUserCompanyId($database, $user_user_company_id, Input $options=null)
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
			self::$_arrContactCompaniesByUserUserCompanyId = null;
		}

		$arrContactCompaniesByUserUserCompanyId = self::$_arrContactCompaniesByUserUserCompanyId;
		if (isset($arrContactCompaniesByUserUserCompanyId) && !empty($arrContactCompaniesByUserUserCompanyId)) {
			return $arrContactCompaniesByUserUserCompanyId;
		}

		$user_user_company_id = (int) $user_user_company_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `user_user_company_id` ASC, `contact_user_company_id` ASC, `company` ASC, `primary_phone_number` ASC, `employer_identification_number` ASC, `construction_license_number` ASC, `construction_license_number_expiration_date` ASC, `vendor_flag` ASC
		$sqlOrderBy = "\nORDER BY cc.`company`";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpContactCompany = new ContactCompany($database);
			$sqlOrderByColumns = $tmpContactCompany->constructSqlOrderByColumns($arrOrderByAttributes);

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
	cc.*

FROM `contact_companies` cc
WHERE cc.`user_user_company_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// AND (`company` LIKE 'advent%' OR `company` like 'taylor%' OR `company` LIKE 'Saddleback Valley Neuroscience' OR `company` LIKE 'A & A')
// AND `company` like 'taylor%'
// LIMIT 10
// ORDER BY `id` ASC, `user_user_company_id` ASC, `contact_user_company_id` ASC, `company` ASC, `primary_phone_number` ASC, `employer_identification_number` ASC, `construction_license_number` ASC, `construction_license_number_expiration_date` ASC, `vendor_flag` ASC
		$arrValues = array($user_user_company_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrContactCompaniesByUserUserCompanyId = array();
		while ($row = $db->fetch()) {
			$contact_company_id = $row['id'];
			$contactCompany = self::instantiateOrm($database, 'ContactCompany', $row, null, $contact_company_id);
			/* @var $contactCompany ContactCompany */
			$arrContactCompaniesByUserUserCompanyId[$contact_company_id] = $contactCompany;
		}

		$db->free_result();

		self::$_arrContactCompaniesByUserUserCompanyId = $arrContactCompaniesByUserUserCompanyId;

		return $arrContactCompaniesByUserUserCompanyId;
	}

// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `contact_companies_fk_user_uc` foreign key (`user_user_company_id`) references `user_companies` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $user_user_company_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadContactCompaniesBySubcontractors($database, $user_user_company_id,$project_id, Input $options=null)
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
			self::$_arrContactCompaniesByUserUserCompanyId = null;
		}

		$arrContactCompaniesByUserUserCompanyId = self::$_arrContactCompaniesByUserUserCompanyId;
		if (isset($arrContactCompaniesByUserUserCompanyId) && !empty($arrContactCompaniesByUserUserCompanyId)) {
			return $arrContactCompaniesByUserUserCompanyId;
		}

		$user_user_company_id = (int) $user_user_company_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `user_user_company_id` ASC, `contact_user_company_id` ASC, `company` ASC, `primary_phone_number` ASC, `employer_identification_number` ASC, `construction_license_number` ASC, `construction_license_number_expiration_date` ASC, `vendor_flag` ASC
		$sqlOrderBy = "\nORDER BY cc.`company`";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpContactCompany = new ContactCompany($database);
			$sqlOrderByColumns = $tmpContactCompany->constructSqlOrderByColumns($arrOrderByAttributes);

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

		$query = " SELECT cc.* FROM `gc_budget_line_items` g 
		inner join subcontracts s on g.id = s.gc_budget_line_item_id
		inner join vendors v on v.id = s.vendor_id 
		inner join contact_companies cc on cc.id =v.vendor_contact_company_id
		WHERE cc.`user_user_company_id` = ? and user_company_id = ? and g.project_id= ? {$sqlOrderBy}{$sqlLimit}";

		$arrValues = array($user_user_company_id,$user_user_company_id,$project_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrContactCompaniesByUserUserCompanyId = array();
		while ($row = $db->fetch()) {
			$contact_company_id = $row['id'];
			$contactCompany = self::instantiateOrm($database, 'ContactCompany', $row, null, $contact_company_id);
			/* @var $contactCompany ContactCompany */
			$arrContactCompaniesByUserUserCompanyId[$contact_company_id] = $contactCompany;
		}

		$db->free_result();

		self::$_arrContactCompaniesByUserUserCompanyId = $arrContactCompaniesByUserUserCompanyId;

		return $arrContactCompaniesByUserUserCompanyId;
	}

	/**
	 * Load by constraint `contact_companies_fk_contact_uc` foreign key (`contact_user_company_id`) references `user_companies` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $contact_user_company_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadContactCompaniesByContactUserCompanyId($database, $contact_user_company_id, Input $options=null)
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
			self::$_arrContactCompaniesByContactUserCompanyId = null;
		}

		$arrContactCompaniesByContactUserCompanyId = self::$_arrContactCompaniesByContactUserCompanyId;
		if (isset($arrContactCompaniesByContactUserCompanyId) && !empty($arrContactCompaniesByContactUserCompanyId)) {
			return $arrContactCompaniesByContactUserCompanyId;
		}

		$contact_user_company_id = (int) $contact_user_company_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `user_user_company_id` ASC, `contact_user_company_id` ASC, `company` ASC, `primary_phone_number` ASC, `employer_identification_number` ASC, `construction_license_number` ASC, `construction_license_number_expiration_date` ASC, `vendor_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpContactCompany = new ContactCompany($database);
			$sqlOrderByColumns = $tmpContactCompany->constructSqlOrderByColumns($arrOrderByAttributes);

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
	cc.*

FROM `contact_companies` cc
WHERE cc.`contact_user_company_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `user_user_company_id` ASC, `contact_user_company_id` ASC, `company` ASC, `primary_phone_number` ASC, `employer_identification_number` ASC, `construction_license_number` ASC, `construction_license_number_expiration_date` ASC, `vendor_flag` ASC
		$arrValues = array($contact_user_company_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrContactCompaniesByContactUserCompanyId = array();
		while ($row = $db->fetch()) {
			$contact_company_id = $row['id'];
			$contactCompany = self::instantiateOrm($database, 'ContactCompany', $row, null, $contact_company_id);
			/* @var $contactCompany ContactCompany */
			$arrContactCompaniesByContactUserCompanyId[$contact_company_id] = $contactCompany;
		}

		$db->free_result();

		self::$_arrContactCompaniesByContactUserCompanyId = $arrContactCompaniesByContactUserCompanyId;

		return $arrContactCompaniesByContactUserCompanyId;
	}

	// Loaders: Load By index
	/**
	 * Load by key `company` (`company`).
	 *
	 * @param string $database
	 * @param string $company
	 * @param mixed (Input $options object | null)
	 * @return mixed (single ORM object | false)
	 */
	public static function loadContactCompaniesByCompany($database, $company, Input $options=null)
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
			self::$_arrContactCompaniesByCompany = null;
		}

		$arrContactCompaniesByCompany = self::$_arrContactCompaniesByCompany;
		if (isset($arrContactCompaniesByCompany) && !empty($arrContactCompaniesByCompany)) {
			return $arrContactCompaniesByCompany;
		}

		$company = (string) $company;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `user_user_company_id` ASC, `contact_user_company_id` ASC, `company` ASC, `primary_phone_number` ASC, `employer_identification_number` ASC, `construction_license_number` ASC, `construction_license_number_expiration_date` ASC, `vendor_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpContactCompany = new ContactCompany($database);
			$sqlOrderByColumns = $tmpContactCompany->constructSqlOrderByColumns($arrOrderByAttributes);

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
	cc.*

FROM `contact_companies` cc
WHERE cc.`company` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `user_user_company_id` ASC, `contact_user_company_id` ASC, `company` ASC, `primary_phone_number` ASC, `employer_identification_number` ASC, `construction_license_number` ASC, `construction_license_number_expiration_date` ASC, `vendor_flag` ASC
		$arrValues = array($company);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrContactCompaniesByCompany = array();
		while ($row = $db->fetch()) {
			$contact_company_id = $row['id'];
			$contactCompany = self::instantiateOrm($database, 'ContactCompany', $row, null, $contact_company_id);
			/* @var $contactCompany ContactCompany */
			$arrContactCompaniesByCompany[$contact_company_id] = $contactCompany;
		}

		$db->free_result();

		self::$_arrContactCompaniesByCompany = $arrContactCompaniesByCompany;

		return $arrContactCompaniesByCompany;
	}

	/**
	 * Load by key `primary_phone_number` (`primary_phone_number`).
	 *
	 * @param string $database
	 * @param string $primary_phone_number
	 * @param mixed (Input $options object | null)
	 * @return mixed (single ORM object | false)
	 */
	public static function loadContactCompaniesByPrimaryPhoneNumber($database, $primary_phone_number, Input $options=null)
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
			self::$_arrContactCompaniesByPrimaryPhoneNumber = null;
		}

		$arrContactCompaniesByPrimaryPhoneNumber = self::$_arrContactCompaniesByPrimaryPhoneNumber;
		if (isset($arrContactCompaniesByPrimaryPhoneNumber) && !empty($arrContactCompaniesByPrimaryPhoneNumber)) {
			return $arrContactCompaniesByPrimaryPhoneNumber;
		}

		$primary_phone_number = (string) $primary_phone_number;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `user_user_company_id` ASC, `contact_user_company_id` ASC, `company` ASC, `primary_phone_number` ASC, `employer_identification_number` ASC, `construction_license_number` ASC, `construction_license_number_expiration_date` ASC, `vendor_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpContactCompany = new ContactCompany($database);
			$sqlOrderByColumns = $tmpContactCompany->constructSqlOrderByColumns($arrOrderByAttributes);

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
	cc.*

FROM `contact_companies` cc
WHERE cc.`primary_phone_number` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `user_user_company_id` ASC, `contact_user_company_id` ASC, `company` ASC, `primary_phone_number` ASC, `employer_identification_number` ASC, `construction_license_number` ASC, `construction_license_number_expiration_date` ASC, `vendor_flag` ASC
		$arrValues = array($primary_phone_number);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrContactCompaniesByPrimaryPhoneNumber = array();
		while ($row = $db->fetch()) {
			$contact_company_id = $row['id'];
			$contactCompany = self::instantiateOrm($database, 'ContactCompany', $row, null, $contact_company_id);
			/* @var $contactCompany ContactCompany */
			$arrContactCompaniesByPrimaryPhoneNumber[$contact_company_id] = $contactCompany;
		}

		$db->free_result();

		self::$_arrContactCompaniesByPrimaryPhoneNumber = $arrContactCompaniesByPrimaryPhoneNumber;

		return $arrContactCompaniesByPrimaryPhoneNumber;
	}

	/**
	 * Load by key `employer_identification_number` (`employer_identification_number`).
	 *
	 * @param string $database
	 * @param string $employer_identification_number
	 * @param mixed (Input $options object | null)
	 * @return mixed (single ORM object | false)
	 */
	public static function loadContactCompaniesByEmployerIdentificationNumber($database, $employer_identification_number, Input $options=null)
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
			self::$_arrContactCompaniesByEmployerIdentificationNumber = null;
		}

		$arrContactCompaniesByEmployerIdentificationNumber = self::$_arrContactCompaniesByEmployerIdentificationNumber;
		if (isset($arrContactCompaniesByEmployerIdentificationNumber) && !empty($arrContactCompaniesByEmployerIdentificationNumber)) {
			return $arrContactCompaniesByEmployerIdentificationNumber;
		}

		$employer_identification_number = (string) $employer_identification_number;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `user_user_company_id` ASC, `contact_user_company_id` ASC, `company` ASC, `primary_phone_number` ASC, `employer_identification_number` ASC, `construction_license_number` ASC, `construction_license_number_expiration_date` ASC, `vendor_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpContactCompany = new ContactCompany($database);
			$sqlOrderByColumns = $tmpContactCompany->constructSqlOrderByColumns($arrOrderByAttributes);

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
	cc.*

FROM `contact_companies` cc
WHERE cc.`employer_identification_number` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `user_user_company_id` ASC, `contact_user_company_id` ASC, `company` ASC, `primary_phone_number` ASC, `employer_identification_number` ASC, `construction_license_number` ASC, `construction_license_number_expiration_date` ASC, `vendor_flag` ASC
		$arrValues = array($employer_identification_number);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrContactCompaniesByEmployerIdentificationNumber = array();
		while ($row = $db->fetch()) {
			$contact_company_id = $row['id'];
			$contactCompany = self::instantiateOrm($database, 'ContactCompany', $row, null, $contact_company_id);
			/* @var $contactCompany ContactCompany */
			$arrContactCompaniesByEmployerIdentificationNumber[$contact_company_id] = $contactCompany;
		}

		$db->free_result();

		self::$_arrContactCompaniesByEmployerIdentificationNumber = $arrContactCompaniesByEmployerIdentificationNumber;

		return $arrContactCompaniesByEmployerIdentificationNumber;
	}

	/**
	 * Load by key `construction_license_number` (`construction_license_number`).
	 *
	 * @param string $database
	 * @param string $construction_license_number
	 * @param mixed (Input $options object | null)
	 * @return mixed (single ORM object | false)
	 */
	public static function loadContactCompaniesByConstructionLicenseNumber($database, $construction_license_number, Input $options=null)
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
			self::$_arrContactCompaniesByConstructionLicenseNumber = null;
		}

		$arrContactCompaniesByConstructionLicenseNumber = self::$_arrContactCompaniesByConstructionLicenseNumber;
		if (isset($arrContactCompaniesByConstructionLicenseNumber) && !empty($arrContactCompaniesByConstructionLicenseNumber)) {
			return $arrContactCompaniesByConstructionLicenseNumber;
		}

		$construction_license_number = (string) $construction_license_number;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `user_user_company_id` ASC, `contact_user_company_id` ASC, `company` ASC, `primary_phone_number` ASC, `employer_identification_number` ASC, `construction_license_number` ASC, `construction_license_number_expiration_date` ASC, `vendor_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpContactCompany = new ContactCompany($database);
			$sqlOrderByColumns = $tmpContactCompany->constructSqlOrderByColumns($arrOrderByAttributes);

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
	cc.*

FROM `contact_companies` cc
WHERE cc.`construction_license_number` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `user_user_company_id` ASC, `contact_user_company_id` ASC, `company` ASC, `primary_phone_number` ASC, `employer_identification_number` ASC, `construction_license_number` ASC, `construction_license_number_expiration_date` ASC, `vendor_flag` ASC
		$arrValues = array($construction_license_number);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrContactCompaniesByConstructionLicenseNumber = array();
		while ($row = $db->fetch()) {
			$contact_company_id = $row['id'];
			$contactCompany = self::instantiateOrm($database, 'ContactCompany', $row, null, $contact_company_id);
			/* @var $contactCompany ContactCompany */
			$arrContactCompaniesByConstructionLicenseNumber[$contact_company_id] = $contactCompany;
		}

		$db->free_result();

		self::$_arrContactCompaniesByConstructionLicenseNumber = $arrContactCompaniesByConstructionLicenseNumber;

		return $arrContactCompaniesByConstructionLicenseNumber;
	}

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all contact_companies records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllContactCompanies($database, Input $options=null)
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
			self::$_arrAllContactCompanies = null;
		}

		$arrAllContactCompanies = self::$_arrAllContactCompanies;
		if (isset($arrAllContactCompanies) && !empty($arrAllContactCompanies)) {
			return $arrAllContactCompanies;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `user_user_company_id` ASC, `contact_user_company_id` ASC, `company` ASC, `primary_phone_number` ASC, `employer_identification_number` ASC, `construction_license_number` ASC, `construction_license_number_expiration_date` ASC, `vendor_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpContactCompany = new ContactCompany($database);
			$sqlOrderByColumns = $tmpContactCompany->constructSqlOrderByColumns($arrOrderByAttributes);

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
	cc.*

FROM `contact_companies` cc{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `user_user_company_id` ASC, `contact_user_company_id` ASC, `company` ASC, `primary_phone_number` ASC, `employer_identification_number` ASC, `construction_license_number` ASC, `construction_license_number_expiration_date` ASC, `vendor_flag` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllContactCompanies = array();
		while ($row = $db->fetch()) {
			$contact_company_id = $row['id'];
			$contactCompany = self::instantiateOrm($database, 'ContactCompany', $row, null, $contact_company_id);
			/* @var $contactCompany ContactCompany */
			$arrAllContactCompanies[$contact_company_id] = $contactCompany;
		}

		$db->free_result();

		self::$_arrAllContactCompanies = $arrAllContactCompanies;

		return $arrAllContactCompanies;
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
INTO `contact_companies`
(`user_user_company_id`, `contact_user_company_id`, `company`, `primary_phone_number`, `employer_identification_number`, `construction_license_number`, `construction_license_number_expiration_date`, `vendor_flag`)
VALUES (?, ?, ?, ?, ?, ?, ?, ?)
ON DUPLICATE KEY UPDATE `contact_user_company_id` = ?, `construction_license_number` = ?, `construction_license_number_expiration_date` = ?, `vendor_flag` = ?
";
		$arrValues = array($this->user_user_company_id, $this->contact_user_company_id, $this->company, $this->primary_phone_number, $this->employer_identification_number, $this->construction_license_number, $this->construction_license_number_expiration_date, $this->vendor_flag, $this->contact_user_company_id, $this->construction_license_number, $this->construction_license_number_expiration_date, $this->vendor_flag);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$contact_company_id = $db->insertId;
		$db->free_result();

		return $contact_company_id;
	}

	// Save: insert ignore

	public static function findContactCompanyByUserCompanyIdValues($database, $user_user_company_id, $contact_user_company_id)
	{
		$user_user_company_id = (int) $user_user_company_id;
		$contact_user_company_id = (int) $contact_user_company_id;

		$contactCompany = new ContactCompany($database);
		$key = array(
			'user_user_company_id' => $user_user_company_id,
			'contact_user_company_id' => $contact_user_company_id,
		);
		$contactCompany->setKey($key);
		$contactCompany->load();

		$dataLoadedFlag = $contactCompany->isDataLoaded();
		if ($dataLoadedFlag) {
			$contactCompany->convertDataToProperties();
			$contactCompany->setId($contactCompany->contact_company_id);

			return $contactCompany;
		} else {
			$contactCompany->setKey(null);
		}

		return false;
	}

	public static function loadContactCompaniesCountByLetterByUserCompanyId($database, $user_company_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT SUBSTRING(`company`, 1, 1) 'first_char', COUNT(SUBSTRING(`company`, 1, 1)) 'total'
FROM `contact_companies`
WHERE `user_user_company_id` = ?
GROUP by SUBSTRING(`company`, 1, 1)
ORDER BY `company`
";
		$arrValues = array($user_company_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrRecords = array();
		while ($row = $db->fetch()) {
			$first_char = $row['first_char'];
			$total = $row['total'];
			$arrRecords[$first_char] = $total;
		}
		$db->free_result();

		return $arrRecords;
	}

	public static function loadContactCompaniesListByUserCompanyIdAndSearch($database, $user_company_id, $searchToken)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$searchToken = "%$searchToken%";
		//$searchTokenEscaped = $db->

		$query =
"
SELECT *
FROM `contact_companies`
WHERE `user_user_company_id` = ?
AND `company` LIKE ?
".//"AND company LIKE '%$searchToken%'
"ORDER BY `company`, `employer_identification_number`, `construction_license_number`
";
		$arrValues = array($user_company_id, $searchToken);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrRecords = array();
		while ($row = $db->fetch()) {
			$contact_company_id = $row['id'];
			$cc = new ContactCompany($database);
			$cc->setData($row);
			$cc->convertDataToProperties();
			$arrRecords[$contact_company_id] = $cc;
		}
		$db->free_result();

		return $arrRecords;
	}

	public static function verifyContactCompanyExists($database, $contact_company_id, $user_user_company_id, $contact_company_name)
	{
		$verifiedContactCompanyId = 0;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Check if name and id match
		$query =
"
SELECT `id`
FROM `contact_companies`
WHERE `id` = ?
AND `user_user_company_id` = ?
AND `company` = ?
ORDER BY `company`, `employer_identification_number`, `construction_license_number`
";
		$arrValues = array($contact_company_id, $user_user_company_id, $contact_company_name);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrRecords = array();
		while ($row = $db->fetch()) {
			$cc = new ContactCompany($database);
			$cc->setData($row);
			$cc->convertDataToProperties();
			$arrRecords[] = $cc;
		}
		$db->free_result();

		$recordCount = count($arrRecords);
		if (isset($arrRecords) && $recordCount == 1) {
			$cc = $arrRecords[0];
			$verifiedContactCompanyId = $cc->contact_company_id;
		} elseif (isset($arrRecords) && $recordCount == 0) {
			// If Name and ID did not match then lets just check the name
			$query =
"
SELECT `id`
FROM `contact_companies`
WHERE `user_user_company_id` = ?
AND `company` = ?
ORDER BY `company`, `employer_identification_number`, `construction_license_number`
";
			$arrValues = array($user_user_company_id, $contact_company_name);
			$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

			$arrRecords = array();
			while ($row = $db->fetch()) {
				$cc = new ContactCompany($database);
				$cc->setData($row);
				$cc->convertDataToProperties();
				$arrRecords[] = $cc;
			}
			$db->free_result();

			$recordCount = count($arrRecords);
			if (isset($arrRecords) && $recordCount == 1) {
				$cc = $arrRecords[0];
				$verifiedContactCompanyId = $cc->contact_company_id;
			} else {
				$verifiedContactCompanyId = 0;
			}
		} else {
			$verifiedContactCompanyId = 0;
		}

		return $verifiedContactCompanyId;
	}

	public static function convertPostToStandardContactCompany($database, Egpcs $post)
	{
		/* @var $post Egpcs */

		$cc = new ContactCompany($database);
		$arrAttributes = $cc->getArrAttributesMap();
		// Object Properties are the values in the array so flip it
		$arrAttributes = array_flip($arrAttributes);
		$data = $post->getData();

		$newData = array_intersect_key($data, $arrAttributes);

		// Keys need to match the database key names
		$finalData = array();
		foreach ($newData as $k => $v) {
			$databaseAttribute = $arrAttributes[$k];
			$finalData[$databaseAttribute] = $v;
		}

		$cc->setData($finalData);
		$cc->convertDataToProperties();

		return $cc;
	}
	public static function GenerateFooterData($user_company_id, $database)
	{
    $db = DBI::getInstance($database);
    //To get the contact company_id
     $query1="SELECT id FROM `contact_companies` WHERE `user_user_company_id` = $user_company_id AND `contact_user_company_id` = $user_company_id ";
    $db->execute($query1);
    $row1=$db->fetch();
    $ContactCompId=$row1['id'];
    //To get the compant address
    $Footeraddress='';
    $query2="SELECT * FROM `contact_company_offices` WHERE `contact_company_id` = $ContactCompId and `head_quarters_flag`='Y'  order by id desc limit 1";
    $db->execute($query2);
    $row2=$db->fetch();
    if($row2)
    {
    $CompanyOfficeId=$row2['id'];
    if($row2['address_line_1']!='')
    {
    $Footeraddress.=$row2['address_line_1'];
    }
    if($row2['address_city']!='')
    {
    $Footeraddress.=' | '.$row2['address_city'];
    }
    if($row2['address_state_or_region']!='')
    {
    $Footeraddress.=' , '.$row2['address_state_or_region'];
    }
    if($row2['address_postal_code']!='')
    {
    $Footeraddress.='  '.$row2['address_postal_code'];
    }
    }else{
        $query4="SELECT * FROM `contact_company_offices` WHERE `contact_company_id` = $ContactCompId   order by id desc limit 1";
    $db->execute($query4);
    $row4=$db->fetch();
    
    $CompanyOfficeId=$row4['id'];
    if($row4['address_line_1']!='')
    {
    $Footeraddress.=$row4['address_line_1'];
    }
    if($row4['address_city']!='')
    {
    $Footeraddress.=' | '.$row4['address_city'];
    }
    if($row4['address_state_or_region']!='')
    {
    $Footeraddress.=' , '.$row4['address_state_or_region'];
    }
    if($row4['address_postal_code']!='')
    {
    $Footeraddress.='  '.$row4['address_postal_code'];
    }
    }
    
   $query3="SELECT * FROM `contact_company_office_phone_numbers` WHERE `contact_company_office_id` = $CompanyOfficeId";
    $db->execute($query3);
    $business='';
    $fax='';
     while ($row3 = $db->fetch()) 
        {
           if($row3['phone_number_type_id']=='1')
            {
            $business = $row3['area_code'].'.'.$row3['prefix'].'.'.$row3['number'];
            } 
            if($row3['phone_number_type_id']=='2')
            {
            $fax = ' | (F)'.$row3['area_code'].'.'.$row3['prefix'].'.'.$row3['number'];
            }   
        }
    $Footeraddress=trim($Footeraddress,'| ');
   $faxPhone =$business.$fax;
   return array('address'=>strtoupper($Footeraddress),'number'=>$faxPhone);

     
}
	//To get the contact company Name
	public static function contactCompanyName($database,$company_id,$colvalue)
	{
		$db = DBI::getInstance($database);
		$query1 = "SELECT $colvalue FROM `contact_companies` WHERE `user_user_company_id` = '$company_id' and `contact_user_company_id` = '$company_id' ";
        $db->execute($query1);
		$row1 = $db->fetch();
		$res=$row1[$colvalue];
		return $res;
	}
	//To get the subcontractor company Name
	public static function SubcontractCompanyName($database,$company_id,$colvalue)
	{
		$db = DBI::getInstance($database);
		$query1 = "SELECT $colvalue FROM `contact_companies` WHERE `id` = '$company_id' ";

        $db->execute($query1);
		$row1 = $db->fetch();
		$res=$row1[$colvalue];
		return $res;
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
		// unique index (`company`, `employer_identification_number`, `construction_license_number`, `user_user_company_id`)
		// These fields taken as a composite are the primary key of contact_companies
		$contact_company_name = (string) $this->contact_company_name;
		$employer_identification_number = (string) $this->employer_identification_number;
		$construction_license_number = (string) $this->construction_license_number;
		$user_user_company_id = $this->user_user_company_id;

		// This $key has to match the unique index in the contact_companies table
		// unique index (`company`, `employer_identification_number`, `user_user_company_id`)
		$key = array(
			'company' => $contact_company_name,
			'employer_identification_number' => $employer_identification_number,
			//'construction_license_number' => $construction_license_number,
			'user_user_company_id' => $user_user_company_id,
		);

		$database = $this->getDatabase();
		$tmpObject = new ContactCompany($database);
		$tmpObject->setKey($key);
		$tmpObject->load();
		//$tmpObject->convertDataToProperties();

		// Convert a date of '0000-00-00' to '' for comparison purposes
		$construction_license_number_expiration_date = $tmpObject['construction_license_number_expiration_date'];
		if ($construction_license_number_expiration_date == '0000-00-00') {
			$tmpObject['construction_license_number_expiration_date'] = '';
		}

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
			unset($existingData['contact_user_company_id']);

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

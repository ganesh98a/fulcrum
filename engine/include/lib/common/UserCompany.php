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
 * Company for one or more users.
 *
 * @category   Framework
 * @package    UserCompany
 */

/**
 * ContactCompany
 */
require_once('lib/common/ContactCompany.php');
require_once('lib/common/ContractingEntities.php');


/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class UserCompany extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'UserCompany';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'user_companies';

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
	 * unique index `unique_user_company` (`company`,`primary_phone_number`,`employer_identification_number`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_user_company' => array(
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
		'id' => 'user_company_id',

		'company' => 'user_company_name',
		'primary_phone_number' => 'primary_phone_number',
		'employer_identification_number' => 'employer_identification_number',

		'construction_license_number' => 'construction_license_number',
		'construction_license_number_expiration_date' => 'construction_license_number_expiration_date',
		'paying_customer_flag' => 'paying_customer_flag'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $user_company_id;

	public $user_company_name;
	public $primary_phone_number;
	public $employer_identification_number;

	public $construction_license_number;
	public $construction_license_number_expiration_date;
	public $paying_customer_flag;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties
	public $escaped_user_company_name;
	public $escaped_primary_phone_number;
	public $escaped_employer_identification_number;
	public $escaped_construction_license_number;

	// HTML ENTITY ENCODED NL2BR ORM string properties
	public $escaped_user_company_name_nl2br;
	public $escaped_primary_phone_number_nl2br;
	public $escaped_employer_identification_number_nl2br;
	public $escaped_construction_license_number_nl2br;

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)
	protected static $_arrUserCompaniesByPrimaryPhoneNumber;
	protected static $_arrUserCompaniesByEmployerIdentificationNumber;
	protected static $_arrUserCompaniesByConstructionLicenseNumber;

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)
	protected static $_arrUserCompaniesByCompany;

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllUserCompanies;

	// Foreign Key Objects

	/**
	 * Constructor
	 */
	public function __construct($database, $table='user_companies')
	{
		parent::__construct($table);
		$this->setDatabase($database);
	}

	// Foreign Key Object Accessor Methods

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)
	public static function getArrUserCompaniesByPrimaryPhoneNumber()
	{
		if (isset(self::$_arrUserCompaniesByPrimaryPhoneNumber)) {
			return self::$_arrUserCompaniesByPrimaryPhoneNumber;
		} else {
			return null;
		}
	}

	public static function setArrUserCompaniesByPrimaryPhoneNumber($arrUserCompaniesByPrimaryPhoneNumber)
	{
		self::$_arrUserCompaniesByPrimaryPhoneNumber = $arrUserCompaniesByPrimaryPhoneNumber;
	}

	public static function getArrUserCompaniesByEmployerIdentificationNumber()
	{
		if (isset(self::$_arrUserCompaniesByEmployerIdentificationNumber)) {
			return self::$_arrUserCompaniesByEmployerIdentificationNumber;
		} else {
			return null;
		}
	}

	public static function setArrUserCompaniesByEmployerIdentificationNumber($arrUserCompaniesByEmployerIdentificationNumber)
	{
		self::$_arrUserCompaniesByEmployerIdentificationNumber = $arrUserCompaniesByEmployerIdentificationNumber;
	}

	public static function getArrUserCompaniesByConstructionLicenseNumber()
	{
		if (isset(self::$_arrUserCompaniesByConstructionLicenseNumber)) {
			return self::$_arrUserCompaniesByConstructionLicenseNumber;
		} else {
			return null;
		}
	}

	public static function setArrUserCompaniesByConstructionLicenseNumber($arrUserCompaniesByConstructionLicenseNumber)
	{
		self::$_arrUserCompaniesByConstructionLicenseNumber = $arrUserCompaniesByConstructionLicenseNumber;
	}

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)
	public static function getArrUserCompaniesByCompany()
	{
		if (isset(self::$_arrUserCompaniesByCompany)) {
			return self::$_arrUserCompaniesByCompany;
		} else {
			return null;
		}
	}

	public static function setArrUserCompaniesByCompany($arrUserCompaniesByCompany)
	{
		self::$_arrUserCompaniesByCompany = $arrUserCompaniesByCompany;
	}

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllUserCompanies()
	{
		if (isset(self::$_arrAllUserCompanies)) {
			return self::$_arrAllUserCompanies;
		} else {
			return null;
		}
	}

	public static function setArrAllUserCompanies($arrAllUserCompanies)
	{
		self::$_arrAllUserCompanies = $arrAllUserCompanies;
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
	 * @param int $user_company_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findById($database, $user_company_id,$table='user_companies', $module='UserCompany')
	{
		$userCompany = parent::findById($database, $user_company_id,$table, $module);

		return $userCompany;
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Similar to FindById, but with SQL as starter code for more complex joins.
	 *
	 * @param string $database
	 * @param int $user_company_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findUserCompanyByIdExtended($database, $user_company_id)
	{
		$user_company_id = (int) $user_company_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	uc.*

FROM `user_companies` uc
WHERE uc.`id` = ?
";
		$arrValues = array($user_company_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$user_company_id = $row['id'];
			$userCompany = self::instantiateOrm($database, 'UserCompany', $row, null, $user_company_id);
			/* @var $userCompany UserCompany */
			$userCompany->convertPropertiesToData();

			return $userCompany;
		} else {
			return false;
		}
	}

	// Finders: Find By Unique Index
	/**
	 * Find by unique index `unique_user_company` (`company`,`primary_phone_number`,`employer_identification_number`).
	 *
	 * @param string $database
	 * @param string $company
	 * @param string $primary_phone_number
	 * @param string $employer_identification_number
	 * @return mixed (single ORM object | false)
	 */
	public static function findByCompanyAndPrimaryPhoneNumberAndEmployerIdentificationNumber($database, $company, $primary_phone_number, $employer_identification_number)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	uc.*

FROM `user_companies` uc
WHERE uc.`company` = ?
AND uc.`primary_phone_number` = ?
AND uc.`employer_identification_number` = ?
";
		$arrValues = array($company, $primary_phone_number, $employer_identification_number);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if ($row && !empty($row)) {
			$user_company_id = $row['id'];
			$userCompany = self::instantiateOrm($database, 'UserCompany', $row, null, $user_company_id);
			/* @var $userCompany UserCompany */
			return $userCompany;
		} else {
			return false;
		}
	}

	// Loaders: Load By pk List (list of auto int ids or other non auto int pk list)
	/**
	 * Load zero or more records by an id list (array of auto int primary keys).
	 *
	 * @param string $database
	 * @param array $arrUserCompanyIds
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadUserCompaniesByArrUserCompanyIds($database, $arrUserCompanyIds, Input $options=null)
	{
		if (empty($arrUserCompanyIds)) {
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
		// ORDER BY `id` ASC, `company` ASC, `primary_phone_number` ASC, `employer_identification_number` ASC, `construction_license_number` ASC, `construction_license_number_expiration_date` ASC, `paying_customer_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpUserCompany = new UserCompany($database);
			$sqlOrderByColumns = $tmpUserCompany->constructSqlOrderByColumns($arrOrderByAttributes);

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

		foreach ($arrUserCompanyIds as $k => $user_company_id) {
			$user_company_id = (int) $user_company_id;
			$arrUserCompanyIds[$k] = $db->escape($user_company_id);
		}
		$csvUserCompanyIds = join(',', $arrUserCompanyIds);

		$query =
"
SELECT

	uc.*

FROM `user_companies` uc
WHERE uc.`id` IN ($csvUserCompanyIds){$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		$arrUserCompaniesByCsvUserCompanyIds = array();
		while ($row = $db->fetch()) {
			$user_company_id = $row['id'];
			$userCompany = self::instantiateOrm($database, 'UserCompany', $row, null, $user_company_id);
			/* @var $userCompany UserCompany */
			$userCompany->convertPropertiesToData();

			$arrUserCompaniesByCsvUserCompanyIds[$user_company_id] = $userCompany;
		}

		$db->free_result();

		return $arrUserCompaniesByCsvUserCompanyIds;
	}

	// Loaders: Load By Foreign Key

	// Loaders: Load By index
	/**
	 * Load by key `primary_phone_number` (`primary_phone_number`).
	 *
	 * @param string $database
	 * @param string $primary_phone_number
	 * @param mixed (Input $options object | null)
	 * @return mixed (single ORM object | false)
	 */
	public static function loadUserCompaniesByPrimaryPhoneNumber($database, $primary_phone_number, Input $options=null)
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
			self::$_arrUserCompaniesByPrimaryPhoneNumber = null;
		}

		$arrUserCompaniesByPrimaryPhoneNumber = self::$_arrUserCompaniesByPrimaryPhoneNumber;
		if (isset($arrUserCompaniesByPrimaryPhoneNumber) && !empty($arrUserCompaniesByPrimaryPhoneNumber)) {
			return $arrUserCompaniesByPrimaryPhoneNumber;
		}

		$primary_phone_number = (string) $primary_phone_number;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `company` ASC, `primary_phone_number` ASC, `employer_identification_number` ASC, `construction_license_number` ASC, `construction_license_number_expiration_date` ASC, `paying_customer_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpUserCompany = new UserCompany($database);
			$sqlOrderByColumns = $tmpUserCompany->constructSqlOrderByColumns($arrOrderByAttributes);

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
	uc.*

FROM `user_companies` uc
WHERE uc.`primary_phone_number` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `company` ASC, `primary_phone_number` ASC, `employer_identification_number` ASC, `construction_license_number` ASC, `construction_license_number_expiration_date` ASC, `paying_customer_flag` ASC
		$arrValues = array($primary_phone_number);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrUserCompaniesByPrimaryPhoneNumber = array();
		while ($row = $db->fetch()) {
			$user_company_id = $row['id'];
			$userCompany = self::instantiateOrm($database, 'UserCompany', $row, null, $user_company_id);
			/* @var $userCompany UserCompany */
			$arrUserCompaniesByPrimaryPhoneNumber[$user_company_id] = $userCompany;
		}

		$db->free_result();

		self::$_arrUserCompaniesByPrimaryPhoneNumber = $arrUserCompaniesByPrimaryPhoneNumber;

		return $arrUserCompaniesByPrimaryPhoneNumber;
	}

	/**
	 * Load by key `employer_identification_number` (`employer_identification_number`).
	 *
	 * @param string $database
	 * @param string $employer_identification_number
	 * @param mixed (Input $options object | null)
	 * @return mixed (single ORM object | false)
	 */
	public static function loadUserCompaniesByEmployerIdentificationNumber($database, $employer_identification_number, Input $options=null)
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
			self::$_arrUserCompaniesByEmployerIdentificationNumber = null;
		}

		$arrUserCompaniesByEmployerIdentificationNumber = self::$_arrUserCompaniesByEmployerIdentificationNumber;
		if (isset($arrUserCompaniesByEmployerIdentificationNumber) && !empty($arrUserCompaniesByEmployerIdentificationNumber)) {
			return $arrUserCompaniesByEmployerIdentificationNumber;
		}

		$employer_identification_number = (string) $employer_identification_number;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `company` ASC, `primary_phone_number` ASC, `employer_identification_number` ASC, `construction_license_number` ASC, `construction_license_number_expiration_date` ASC, `paying_customer_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpUserCompany = new UserCompany($database);
			$sqlOrderByColumns = $tmpUserCompany->constructSqlOrderByColumns($arrOrderByAttributes);

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
	uc.*

FROM `user_companies` uc
WHERE uc.`employer_identification_number` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `company` ASC, `primary_phone_number` ASC, `employer_identification_number` ASC, `construction_license_number` ASC, `construction_license_number_expiration_date` ASC, `paying_customer_flag` ASC
		$arrValues = array($employer_identification_number);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrUserCompaniesByEmployerIdentificationNumber = array();
		while ($row = $db->fetch()) {
			$user_company_id = $row['id'];
			$userCompany = self::instantiateOrm($database, 'UserCompany', $row, null, $user_company_id);
			/* @var $userCompany UserCompany */
			$arrUserCompaniesByEmployerIdentificationNumber[$user_company_id] = $userCompany;
		}

		$db->free_result();

		self::$_arrUserCompaniesByEmployerIdentificationNumber = $arrUserCompaniesByEmployerIdentificationNumber;

		return $arrUserCompaniesByEmployerIdentificationNumber;
	}

	/**
	 * Load by key `construction_license_number` (`construction_license_number`).
	 *
	 * @param string $database
	 * @param string $construction_license_number
	 * @param mixed (Input $options object | null)
	 * @return mixed (single ORM object | false)
	 */
	public static function loadUserCompaniesByConstructionLicenseNumber($database, $construction_license_number, Input $options=null)
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
			self::$_arrUserCompaniesByConstructionLicenseNumber = null;
		}

		$arrUserCompaniesByConstructionLicenseNumber = self::$_arrUserCompaniesByConstructionLicenseNumber;
		if (isset($arrUserCompaniesByConstructionLicenseNumber) && !empty($arrUserCompaniesByConstructionLicenseNumber)) {
			return $arrUserCompaniesByConstructionLicenseNumber;
		}

		$construction_license_number = (string) $construction_license_number;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `company` ASC, `primary_phone_number` ASC, `employer_identification_number` ASC, `construction_license_number` ASC, `construction_license_number_expiration_date` ASC, `paying_customer_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpUserCompany = new UserCompany($database);
			$sqlOrderByColumns = $tmpUserCompany->constructSqlOrderByColumns($arrOrderByAttributes);

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
	uc.*

FROM `user_companies` uc
WHERE uc.`construction_license_number` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `company` ASC, `primary_phone_number` ASC, `employer_identification_number` ASC, `construction_license_number` ASC, `construction_license_number_expiration_date` ASC, `paying_customer_flag` ASC
		$arrValues = array($construction_license_number);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrUserCompaniesByConstructionLicenseNumber = array();
		while ($row = $db->fetch()) {
			$user_company_id = $row['id'];
			$userCompany = self::instantiateOrm($database, 'UserCompany', $row, null, $user_company_id);
			/* @var $userCompany UserCompany */
			$arrUserCompaniesByConstructionLicenseNumber[$user_company_id] = $userCompany;
		}

		$db->free_result();

		self::$_arrUserCompaniesByConstructionLicenseNumber = $arrUserCompaniesByConstructionLicenseNumber;

		return $arrUserCompaniesByConstructionLicenseNumber;
	}

	// Loaders: Load By additionally indexed attribute
	/**
	 * Load by leftmost indexed attribute: unique index `unique_user_company` (`company`,`primary_phone_number`,`employer_identification_number`).
	 *
	 * @param string $database
	 * @param string $company
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadUserCompaniesByCompany($database, $company, Input $options=null)
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
			self::$_arrUserCompaniesByCompany = null;
		}

		$arrUserCompaniesByCompany = self::$_arrUserCompaniesByCompany;
		if (isset($arrUserCompaniesByCompany) && !empty($arrUserCompaniesByCompany)) {
			return $arrUserCompaniesByCompany;
		}

		$company = (string) $company;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `company` ASC, `primary_phone_number` ASC, `employer_identification_number` ASC, `construction_license_number` ASC, `construction_license_number_expiration_date` ASC, `paying_customer_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpUserCompany = new UserCompany($database);
			$sqlOrderByColumns = $tmpUserCompany->constructSqlOrderByColumns($arrOrderByAttributes);

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
	uc.*

FROM `user_companies` uc
WHERE uc.`company` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `company` ASC, `primary_phone_number` ASC, `employer_identification_number` ASC, `construction_license_number` ASC, `construction_license_number_expiration_date` ASC, `paying_customer_flag` ASC
		$arrValues = array($company);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrUserCompaniesByCompany = array();
		while ($row = $db->fetch()) {
			$user_company_id = $row['id'];
			$userCompany = self::instantiateOrm($database, 'UserCompany', $row, null, $user_company_id);
			/* @var $userCompany UserCompany */
			$arrUserCompaniesByCompany[$user_company_id] = $userCompany;
		}

		$db->free_result();

		self::$_arrUserCompaniesByCompany = $arrUserCompaniesByCompany;

		return $arrUserCompaniesByCompany;
	}

	// Loaders: Load All Records
	/**
	 * Load all user_companies records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllUserCompanies($database, Input $options=null)
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
			self::$_arrAllUserCompanies = null;
		}

		$arrAllUserCompanies = self::$_arrAllUserCompanies;
		if (isset($arrAllUserCompanies) && !empty($arrAllUserCompanies)) {
			return $arrAllUserCompanies;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `company` ASC, `primary_phone_number` ASC, `employer_identification_number` ASC, `construction_license_number` ASC, `construction_license_number_expiration_date` ASC, `paying_customer_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpUserCompany = new UserCompany($database);
			$sqlOrderByColumns = $tmpUserCompany->constructSqlOrderByColumns($arrOrderByAttributes);

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
	uc.*

FROM `user_companies` uc{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `company` ASC, `primary_phone_number` ASC, `employer_identification_number` ASC, `construction_license_number` ASC, `construction_license_number_expiration_date` ASC, `paying_customer_flag` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllUserCompanies = array();
		while ($row = $db->fetch()) {
			$user_company_id = $row['id'];
			$userCompany = self::instantiateOrm($database, 'UserCompany', $row, null, $user_company_id);
			/* @var $userCompany UserCompany */
			$arrAllUserCompanies[$user_company_id] = $userCompany;
		}

		$db->free_result();

		self::$_arrAllUserCompanies = $arrAllUserCompanies;

		return $arrAllUserCompanies;
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
INTO `user_companies`
(`company`, `primary_phone_number`, `employer_identification_number`, `construction_license_number`, `construction_license_number_expiration_date`, `paying_customer_flag`)
VALUES (?, ?, ?, ?, ?, ?)
ON DUPLICATE KEY UPDATE `construction_license_number` = ?, `construction_license_number_expiration_date` = ?, `paying_customer_flag` = ?
";
		$arrValues = array($this->company, $this->primary_phone_number, $this->employer_identification_number, $this->construction_license_number, $this->construction_license_number_expiration_date, $this->paying_customer_flag, $this->construction_license_number, $this->construction_license_number_expiration_date, $this->paying_customer_flag);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$user_company_id = $db->insertId;
		$db->free_result();

		return $user_company_id;
	}

	// Save: insert ignore

	public static function convertPostToStandardUserCompany($database, Egpcs $post)
	{
		/* @var $post Egpcs */

		$uc = new UserCompany($database);
		$arrAttributes = $uc->getArrAttributesMap();
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

		// Fix construction_license_number_expiration_date to be YY-mm-dd
		if (isset($finalData['construction_license_number_expiration_date'])) {
			$tmp = $finalData['construction_license_number_expiration_date'];
			$construction_license_number_expiration_date = Date::convertDateTimeFormat($tmp, 'database_date');

			//$arrTmp = explode('/', $tmp);
			//$construction_license_number_expiration_date = $arrTmp[2] . '-'. $arrTmp[0] . '-'. $arrTmp[1];

			$finalData['construction_license_number_expiration_date'] = $construction_license_number_expiration_date;
		}

		$uc->setData($finalData);
		$uc->convertDataToProperties();

		return $uc;
	}

	public function registerUserCompanyAccount($database)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$db->begin();

		// Check for availability of user info
		// unique index (`company`, `employer_identification_number`)
		$query =
"
SELECT *
FROM `user_companies`
WHERE `company` = ?
AND `employer_identification_number` = ?
";
		$arrValues = array($this->user_company_name, $this->employer_identification_number);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$storedCompany = $row['company'];
			$storedEIN = $row['employer_identification_number'];

			if ($this->user_company_name == $storedCompany) {
				$arrErrors['user_company_name'] = true;
			}

			if ($this->employer_identification_number == $storedEIN) {
				$arrErrors['employer_identification_number'] = true;
			}

			$db->rollback();

			$user_company_id = -1;
			$contact_company_id = -1;
		} else {
			// INSERT INTO user_companies table
			$this->setKey(null);
			$this->convertPropertiesToData();

			$user_company_id = $this->save();


			/* Contracting Company - Start */
			$contractEntityName = $this->user_company_name;
			$contracting_entity =  ContractingEntities::getContractEntityByName($database, $contractEntityName, $user_company_id);

			if(empty($contracting_entity)){ // No Contracting Entity Exists
				$params_arr = array();
				$params_arr['user_company_id'] = $user_company_id;
				$params_arr['contractEntityName'] = $contractEntityName;
				$params_arr['construction_license_number'] = $this->construction_license_number;
				ContractingEntities::createEntity($database, $params_arr);
			}
			/* Contracting Company - End */

			// INSERT INTO contact_companies table
			$cc = new ContactCompany($database);
			$cc->user_user_company_id = $user_company_id;
			$cc->contact_user_company_id = $user_company_id;
			$cc->contact_company_name = $this->user_company_name;
			$cc->employer_identification_number = $this->employer_identification_number;
			$cc->construction_license_number = $this->construction_license_number;
			$cc->construction_license_number_expiration_date = $this->construction_license_number_expiration_date;
			//$cc->paying_customer_flag = $this->paying_customer_flag;
			$cc->convertPropertiesToData();
			$contact_company_id = $cc->save();

			$db->commit();

			$arrErrors = array();
		}

		$db->free_result();
		$arrReturn = array(
			'user_company_id' => $user_company_id,
			'contact_company_id' => $contact_company_id,
			'errors' => $arrErrors
		);

		return $arrReturn;
	}

	public function updateUserCompanyAccount($database)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$db->begin();

		// Check for availability of user company info
		// unique index (`company`, `employer_identification_number`)
		$query =
"
SELECT *
FROM `user_companies`
WHERE `company` = ?
AND `employer_identification_number` = ?
AND `id` <> ?
";
		$arrValues = array($this->user_company_name, $this->employer_identification_number, $this->user_company_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$storedCompany = $row['company'];
			$storedEIN = $row['employer_identification_number'];

			if ($this->user_company_name == $storedCompany) {
				$arrErrors['user_company_name'] = true;
			}

			if ($this->employer_identification_number == $storedEIN) {
				$arrErrors['employer_identification_number'] = true;
			}

			$db->rollback();
		} else {
			// UPDATE user_companies table
			$key = array(
				'id' => $this->user_company_id
			);
			$this->setKey($key);
			unset($this['id']);
			$this->save();

			// UPDATE contact_companies table to mirror the change
			$cc = new ContactCompany($database);
			$key = array(
				'user_user_company_id' => $this->user_company_id,
				'contact_user_company_id' => $this->user_company_id
			);
			$cc->setKey($key);
			$cc->load();
			if (isset($cc['id'])) {
				$contact_company_id = $cc['id'];
			} else {
				$contact_company_id = null;
			}
			$existingData = $cc->getData();

			$cc->user_user_company_id = $this->user_company_id;
			$cc->contact_user_company_id = $this->user_company_id;
			$cc->contact_company_name = $this->user_company_name;
			$cc->employer_identification_number = $this->employer_identification_number;
			$cc->construction_license_number = $this->construction_license_number;
			$cc->construction_license_number_expiration_date = $this->construction_license_number_expiration_date;
			$cc->convertPropertiesToData();
			$newData = $cc->getData();

			$data = Data::deltify($existingData, $newData);
			if (!empty($data)) {
				$cc->setData($data);
				$cc->save();
			}

			$db->commit();

			$arrErrors = array();
		}

		$db->free_result();

		$user_company_id = $this->user_company_id;

		$arrReturn = array(
			'user_company_id' => $user_company_id,
			'contact_company_id' => $contact_company_id,
			'errors' => $arrErrors
		);

		return $arrReturn;
	}

	public static function determineIfPayingCustomer($database, $user_company_id)
	{
		$db = DBI::getInstance($database);

		// Determine if paying customer
		$query =
"
SELECT `paying_customer_flag`
FROM `user_companies`
WHERE `id` = ?
";
		$arrValues = array($user_company_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if (isset($row) && !empty($row['paying_customer_flag'])) {
			$paying_customer_flag = $row['paying_customer_flag'];
		} else {
			$paying_customer_flag = 'N';
		}

		return $paying_customer_flag;
	}

	public static function loadUserCompaniesList($database)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$AXIS_NON_EXISTENT_USER_COMPANY_ID = AXIS_NON_EXISTENT_USER_COMPANY_ID;
		$query =
"
SELECT *
FROM `user_companies`
WHERE `id` <> $AXIS_NON_EXISTENT_USER_COMPANY_ID and is_disabled ='N'
ORDER BY `company`, `employer_identification_number`, `construction_license_number`
";
		$db->query($query, MYSQLI_USE_RESULT);

		$arrObjectsList = array();
		$arrOptionsList = array();
		while ($row = $db->fetch()) {
			$id = $row['id'];
			$optionValue = $row['company'];

			$object = new UserCompany($database);
			$object->setData($row);
			$object->convertDataToProperties();

			// Object list format
			$arrObjectsList[$id] = $object;

			// Drop down select options list format
			$arrOptionsList[$id] = $optionValue;
		}
		$db->free_result();

		$arrReturn = array(
			'objects_list' => $arrObjectsList,
			'options_list' => $arrOptionsList
		);

		return $arrReturn;
	}

	public static function findUserCompanyByUserCompanyId($database, $user_company_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT *
FROM `user_companies`
WHERE id = ?
";
		$arrValues = array($user_company_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		$uc = new UserCompany($database);
		$uc->setData($row);
		$uc->convertDataToProperties();

		return $uc;
	}

	public static function loadUserCompaniesListBySearch($database, $searchToken)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$searchToken = "%$searchToken%";

		$query =
"
SELECT *
FROM `user_companies`
WHERE company LIKE ?
ORDER BY `company`, `employer_identification_number`, `construction_license_number`
";
		$arrValues = array($searchToken);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrRecords = array();
		while ($row = $db->fetch()) {
			$uc = new UserCompany($database);
			$uc->setData($row);
			$uc->convertDataToProperties();
			$arrRecords[] = $uc;
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
		// unique index (`company`, `employer_identification_number`, `construction_license_number`, `user_user_company_id`)
		// These fields taken as a composite are the primary key of user_companies
		$user_company_name = (string) $this->user_company_name;
		$employer_identification_number = (string) $this->employer_identification_number;
		$construction_license_number = (string) $this->construction_license_number;
		$user_user_company_id = $this->user_user_company_id;

		$key = array(
			'company' => $user_company_name,
			'employer_identification_number' => $employer_identification_number,
			'construction_license_number' => $construction_license_number,
			'user_user_company_id' => $user_user_company_id,
		);

		$database = $this->getDatabase();
		$tmpObject = new UserCompany($database);
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

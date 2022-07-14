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
 * ContactToContactCompanyOffice.
 *
 * @category   Framework
 * @package    ContactToContactCompanyOffice
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class ContactToContactCompanyOffice extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'ContactToContactCompanyOffice';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'contacts_to_contact_company_offices';

	/**
	 * primary key (`contact_id`,`contact_company_office_id`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrPrimaryKey = array(
		'contact_id' => 'int',
		'contact_company_office_id' => 'int'
	);

	/**
	 * No Unique Indexes, Just a Primary Key
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_contact_to_contact_company_office_via_primary_key' => array(
			'contact_id' => 'int',
			'contact_company_office_id' => 'int'
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
		'contact_company_office_id' => 'contact_company_office_id',

		'primary_office_flag' => 'primary_office_flag'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $contact_id;
	public $contact_company_office_id;

	public $primary_office_flag;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties

	// HTML ENTITY ENCODED NL2BR ORM string properties

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)
	protected static $_arrContactsToContactCompanyOfficesByContactId;
	protected static $_arrContactsToContactCompanyOfficesByContactCompanyOfficeId;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllContactsToContactCompanyOffices;

	// Foreign Key Objects
	private $_contact;
	private $_contactCompanyOffice;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='contacts_to_contact_company_offices')
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
	public static function getArrContactsToContactCompanyOfficesByContactId()
	{
		if (isset(self::$_arrContactsToContactCompanyOfficesByContactId)) {
			return self::$_arrContactsToContactCompanyOfficesByContactId;
		} else {
			return null;
		}
	}

	public static function setArrContactsToContactCompanyOfficesByContactId($arrContactsToContactCompanyOfficesByContactId)
	{
		self::$_arrContactsToContactCompanyOfficesByContactId = $arrContactsToContactCompanyOfficesByContactId;
	}

	public static function getArrContactsToContactCompanyOfficesByContactCompanyOfficeId()
	{
		if (isset(self::$_arrContactsToContactCompanyOfficesByContactCompanyOfficeId)) {
			return self::$_arrContactsToContactCompanyOfficesByContactCompanyOfficeId;
		} else {
			return null;
		}
	}

	public static function setArrContactsToContactCompanyOfficesByContactCompanyOfficeId($arrContactsToContactCompanyOfficesByContactCompanyOfficeId)
	{
		self::$_arrContactsToContactCompanyOfficesByContactCompanyOfficeId = $arrContactsToContactCompanyOfficesByContactCompanyOfficeId;
	}

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllContactsToContactCompanyOffices()
	{
		if (isset(self::$_arrAllContactsToContactCompanyOffices)) {
			return self::$_arrAllContactsToContactCompanyOffices;
		} else {
			return null;
		}
	}

	public static function setArrAllContactsToContactCompanyOffices($arrAllContactsToContactCompanyOffices)
	{
		self::$_arrAllContactsToContactCompanyOffices = $arrAllContactsToContactCompanyOffices;
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
	 * Find by primary key (`contact_id`,`contact_company_office_id`).
	 *
	 * @param string $database
	 * @param int $contact_id
	 * @param int $contact_company_office_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findByContactIdAndContactCompanyOfficeId($database, $contact_id, $contact_company_office_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	c2cco.*

FROM `contacts_to_contact_company_offices` c2cco
WHERE c2cco.`contact_id` = ?
AND c2cco.`contact_company_office_id` = ?
";
		$arrValues = array($contact_id, $contact_company_office_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row && !empty($row)) {
			$contactToContactCompanyOffice = self::instantiateOrm($database, 'ContactToContactCompanyOffice', $row);
			/* @var $contactToContactCompanyOffice ContactToContactCompanyOffice */
			return $contactToContactCompanyOffice;
		} else {
			return false;
		}
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Find by primary key (`contact_id`,`contact_company_office_id`) Extended.
	 *
	 * @param string $database
	 * @param int $contact_id
	 * @param int $contact_company_office_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findByContactIdAndContactCompanyOfficeIdExtended($database, $contact_id, $contact_company_office_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	c2cco_fk_c.`id` AS 'c2cco_fk_c__contact_id',
	c2cco_fk_c.`user_company_id` AS 'c2cco_fk_c__user_company_id',
	c2cco_fk_c.`user_id` AS 'c2cco_fk_c__user_id',
	c2cco_fk_c.`contact_company_id` AS 'c2cco_fk_c__contact_company_id',
	c2cco_fk_c.`email` AS 'c2cco_fk_c__email',
	c2cco_fk_c.`name_prefix` AS 'c2cco_fk_c__name_prefix',
	c2cco_fk_c.`first_name` AS 'c2cco_fk_c__first_name',
	c2cco_fk_c.`additional_name` AS 'c2cco_fk_c__additional_name',
	c2cco_fk_c.`middle_name` AS 'c2cco_fk_c__middle_name',
	c2cco_fk_c.`last_name` AS 'c2cco_fk_c__last_name',
	c2cco_fk_c.`name_suffix` AS 'c2cco_fk_c__name_suffix',
	c2cco_fk_c.`title` AS 'c2cco_fk_c__title',
	c2cco_fk_c.`vendor_flag` AS 'c2cco_fk_c__vendor_flag',

	c2cco_fk_cco.`id` AS 'c2cco_fk_cco__contact_company_office_id',
	c2cco_fk_cco.`contact_company_id` AS 'c2cco_fk_cco__contact_company_id',
	c2cco_fk_cco.`office_nickname` AS 'c2cco_fk_cco__office_nickname',
	c2cco_fk_cco.`address_line_1` AS 'c2cco_fk_cco__address_line_1',
	c2cco_fk_cco.`address_line_2` AS 'c2cco_fk_cco__address_line_2',
	c2cco_fk_cco.`address_line_3` AS 'c2cco_fk_cco__address_line_3',
	c2cco_fk_cco.`address_line_4` AS 'c2cco_fk_cco__address_line_4',
	c2cco_fk_cco.`address_city` AS 'c2cco_fk_cco__address_city',
	c2cco_fk_cco.`address_county` AS 'c2cco_fk_cco__address_county',
	c2cco_fk_cco.`address_state_or_region` AS 'c2cco_fk_cco__address_state_or_region',
	c2cco_fk_cco.`address_postal_code` AS 'c2cco_fk_cco__address_postal_code',
	c2cco_fk_cco.`address_postal_code_extension` AS 'c2cco_fk_cco__address_postal_code_extension',
	c2cco_fk_cco.`address_country` AS 'c2cco_fk_cco__address_country',
	c2cco_fk_cco.`head_quarters_flag` AS 'c2cco_fk_cco__head_quarters_flag',
	c2cco_fk_cco.`address_validated_by_user_flag` AS 'c2cco_fk_cco__address_validated_by_user_flag',
	c2cco_fk_cco.`address_validated_by_web_service_flag` AS 'c2cco_fk_cco__address_validated_by_web_service_flag',
	c2cco_fk_cco.`address_validation_by_web_service_error_flag` AS 'c2cco_fk_cco__address_validation_by_web_service_error_flag',

	c2cco.*

FROM `contacts_to_contact_company_offices` c2cco
	INNER JOIN `contacts` c2cco_fk_c ON c2cco.`contact_id` = c2cco_fk_c.`id`
	INNER JOIN `contact_company_offices` c2cco_fk_cco ON c2cco.`contact_company_office_id` = c2cco_fk_cco.`id`
WHERE c2cco.`contact_id` = ?
AND c2cco.`contact_company_office_id` = ?
";
		$arrValues = array($contact_id, $contact_company_office_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row && !empty($row)) {
			$contactToContactCompanyOffice = self::instantiateOrm($database, 'ContactToContactCompanyOffice', $row);
			/* @var $contactToContactCompanyOffice ContactToContactCompanyOffice */
			$contactToContactCompanyOffice->convertPropertiesToData();

			if (isset($row['contact_id'])) {
				$contact_id = $row['contact_id'];
				$row['c2cco_fk_c__id'] = $contact_id;
				$contact = self::instantiateOrm($database, 'Contact', $row, null, $contact_id, 'c2cco_fk_c__');
				/* @var $contact Contact */
				$contact->convertPropertiesToData();
			} else {
				$contact = false;
			}
			$contactToContactCompanyOffice->setContact($contact);

			if (isset($row['contact_company_office_id'])) {
				$contact_company_office_id = $row['contact_company_office_id'];
				$row['c2cco_fk_cco__id'] = $contact_company_office_id;
				$contactCompanyOffice = self::instantiateOrm($database, 'ContactCompanyOffice', $row, null, $contact_company_office_id, 'c2cco_fk_cco__');
				/* @var $contactCompanyOffice ContactCompanyOffice */
				$contactCompanyOffice->convertPropertiesToData();
			} else {
				$contactCompanyOffice = false;
			}
			$contactToContactCompanyOffice->setContactCompanyOffice($contactCompanyOffice);

			return $contactToContactCompanyOffice;
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
	 * @param array $arrContactIdAndContactCompanyOfficeIdList
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadContactsToContactCompanyOfficesByArrContactIdAndContactCompanyOfficeIdList($database, $arrContactIdAndContactCompanyOfficeIdList, Input $options=null)
	{
		if (empty($arrContactIdAndContactCompanyOfficeIdList)) {
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
		// ORDER BY `contact_id` ASC, `contact_company_office_id` ASC, `primary_office_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpContactToContactCompanyOffice = new ContactToContactCompanyOffice($database);
			$sqlOrderByColumns = $tmpContactToContactCompanyOffice->constructSqlOrderByColumns($arrOrderByAttributes);

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
		foreach ($arrContactIdAndContactCompanyOfficeIdList as $k => $arrTmp) {
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
		if (count($arrContactIdAndContactCompanyOfficeIdList) > 1) {
			$sqlWhere = join($arrSqlWhere, ' OR ');
			$sqlWhere = "WHERE ($sqlWhere)";
		} else {
			$sqlWhere = "WHERE $tmpInnerAnd";
		}

		$query =
"
SELECT

	c2cco.*

FROM `contacts_to_contact_company_offices` c2cco
{$sqlWhere}{$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrContactsToContactCompanyOfficesByArrContactIdAndContactCompanyOfficeIdList = array();
		while ($row = $db->fetch()) {
			$contactToContactCompanyOffice = self::instantiateOrm($database, 'ContactToContactCompanyOffice', $row);
			/* @var $contactToContactCompanyOffice ContactToContactCompanyOffice */
			$arrContactsToContactCompanyOfficesByArrContactIdAndContactCompanyOfficeIdList[] = $contactToContactCompanyOffice;
		}

		$db->free_result();

		return $arrContactsToContactCompanyOfficesByArrContactIdAndContactCompanyOfficeIdList;
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `contacts_to_contact_company_offices_fk_c` foreign key (`contact_id`) references `contacts` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $contact_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadContactsToContactCompanyOfficesByContactId($database, $contact_id, Input $options=null)
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
			self::$_arrContactsToContactCompanyOfficesByContactId = null;
		}

		$arrContactsToContactCompanyOfficesByContactId = self::$_arrContactsToContactCompanyOfficesByContactId;
		if (isset($arrContactsToContactCompanyOfficesByContactId) && !empty($arrContactsToContactCompanyOfficesByContactId)) {
			return $arrContactsToContactCompanyOfficesByContactId;
		}

		$contact_id = (int) $contact_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `contact_id` ASC, `contact_company_office_id` ASC, `primary_office_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpContactToContactCompanyOffice = new ContactToContactCompanyOffice($database);
			$sqlOrderByColumns = $tmpContactToContactCompanyOffice->constructSqlOrderByColumns($arrOrderByAttributes);

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
	c2cco.*

FROM `contacts_to_contact_company_offices` c2cco
WHERE c2cco.`contact_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `contact_id` ASC, `contact_company_office_id` ASC, `primary_office_flag` ASC
		$arrValues = array($contact_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrContactsToContactCompanyOfficesByContactId = array();
		while ($row = $db->fetch()) {
			$contactToContactCompanyOffice = self::instantiateOrm($database, 'ContactToContactCompanyOffice', $row);
			/* @var $contactToContactCompanyOffice ContactToContactCompanyOffice */
			$arrContactsToContactCompanyOfficesByContactId[] = $contactToContactCompanyOffice;
		}

		$db->free_result();

		self::$_arrContactsToContactCompanyOfficesByContactId = $arrContactsToContactCompanyOfficesByContactId;

		return $arrContactsToContactCompanyOfficesByContactId;
	}

	/**
	 * Load by constraint `contacts_to_contact_company_offices_fk_cco` foreign key (`contact_company_office_id`) references `contact_company_offices` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $contact_company_office_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadContactsToContactCompanyOfficesByContactCompanyOfficeId($database, $contact_company_office_id, Input $options=null)
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
			self::$_arrContactsToContactCompanyOfficesByContactCompanyOfficeId = null;
		}

		$arrContactsToContactCompanyOfficesByContactCompanyOfficeId = self::$_arrContactsToContactCompanyOfficesByContactCompanyOfficeId;
		if (isset($arrContactsToContactCompanyOfficesByContactCompanyOfficeId) && !empty($arrContactsToContactCompanyOfficesByContactCompanyOfficeId)) {
			return $arrContactsToContactCompanyOfficesByContactCompanyOfficeId;
		}

		$contact_company_office_id = (int) $contact_company_office_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `contact_id` ASC, `contact_company_office_id` ASC, `primary_office_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpContactToContactCompanyOffice = new ContactToContactCompanyOffice($database);
			$sqlOrderByColumns = $tmpContactToContactCompanyOffice->constructSqlOrderByColumns($arrOrderByAttributes);

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
	c2cco.*

FROM `contacts_to_contact_company_offices` c2cco
WHERE c2cco.`contact_company_office_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `contact_id` ASC, `contact_company_office_id` ASC, `primary_office_flag` ASC
		$arrValues = array($contact_company_office_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrContactsToContactCompanyOfficesByContactCompanyOfficeId = array();
		while ($row = $db->fetch()) {
			$contactToContactCompanyOffice = self::instantiateOrm($database, 'ContactToContactCompanyOffice', $row);
			/* @var $contactToContactCompanyOffice ContactToContactCompanyOffice */
			$arrContactsToContactCompanyOfficesByContactCompanyOfficeId[] = $contactToContactCompanyOffice;
		}

		$db->free_result();

		self::$_arrContactsToContactCompanyOfficesByContactCompanyOfficeId = $arrContactsToContactCompanyOfficesByContactCompanyOfficeId;

		return $arrContactsToContactCompanyOfficesByContactCompanyOfficeId;
	}

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all contacts_to_contact_company_offices records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllContactsToContactCompanyOffices($database, Input $options=null)
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
			self::$_arrAllContactsToContactCompanyOffices = null;
		}

		$arrAllContactsToContactCompanyOffices = self::$_arrAllContactsToContactCompanyOffices;
		if (isset($arrAllContactsToContactCompanyOffices) && !empty($arrAllContactsToContactCompanyOffices)) {
			return $arrAllContactsToContactCompanyOffices;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `contact_id` ASC, `contact_company_office_id` ASC, `primary_office_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpContactToContactCompanyOffice = new ContactToContactCompanyOffice($database);
			$sqlOrderByColumns = $tmpContactToContactCompanyOffice->constructSqlOrderByColumns($arrOrderByAttributes);

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
	c2cco.*

FROM `contacts_to_contact_company_offices` c2cco{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `contact_id` ASC, `contact_company_office_id` ASC, `primary_office_flag` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllContactsToContactCompanyOffices = array();
		while ($row = $db->fetch()) {
			$contactToContactCompanyOffice = self::instantiateOrm($database, 'ContactToContactCompanyOffice', $row);
			/* @var $contactToContactCompanyOffice ContactToContactCompanyOffice */
			$arrAllContactsToContactCompanyOffices[] = $contactToContactCompanyOffice;
		}

		$db->free_result();

		self::$_arrAllContactsToContactCompanyOffices = $arrAllContactsToContactCompanyOffices;

		return $arrAllContactsToContactCompanyOffices;
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
INTO `contacts_to_contact_company_offices`
(`contact_id`, `contact_company_office_id`, `primary_office_flag`)
VALUES (?, ?, ?)
ON DUPLICATE KEY UPDATE `primary_office_flag` = ?
";
		$arrValues = array($this->contact_id, $this->contact_company_office_id, $this->primary_office_flag, $this->primary_office_flag);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$contact_to_contact_company_office_id = $db->insertId;
		$db->free_result();

		return $contact_to_contact_company_office_id;
	}

	// Save: insert ignore

	public static function loadContactCompanyOfficesListByContact($database, $contact_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */
		$contact_company_id = $contact_id;
		$query =
"
SELECT *
FROM `contact_company_offices`
WHERE contact_company_id = ?
ORDER BY `address_line_1`, `address_line_2`, `address_line_3`, `address_line_4`, `address_city`, `address_county`, `address_state_or_region`, `address_postal_code`, `address_postal_code_extension`
";
		$arrValues = array($contact_company_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrRecords = array();
		while ($row = $db->fetch()) {
			$cco = new ContactCompanyOffice($database);
			$cco->setData($row);
			$cco->convertDataToProperties();
			$arrRecords[] = $cco;
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
		$contact_id = $this->contact_id;
		$contact_company_office_id = $this->contact_company_office_id;
		$primary_office_flag = $this->primary_office_flag;

		$key = array(
			'contact_id' => $contact_id,
			'contact_company_office_id' => $contact_company_office_id
		);

		$database = $this->getDatabase();
		$tmpObject = new ContactToContactCompanyOffice($database);
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

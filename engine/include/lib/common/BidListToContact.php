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
 * BidListToContact.
 *
 * @category   Framework
 * @package    BidListToContact
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class BidListToContact extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'BidListToContact';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'bid_lists_to_contacts';

	/**
	 * primary key (`bid_list_id`,`contact_id`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrPrimaryKey = array(
		'bid_list_id' => 'int',
		'contact_id' => 'int'
	);

	/**
	 * No Unique Indexes, Just a Primary Key
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_bid_list_to_contact_via_primary_key' => array(
			'bid_list_id' => 'int',
			'contact_id' => 'int'
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
		'bid_list_id' => 'bid_list_id',
		'contact_id' => 'contact_id'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $bid_list_id;
	public $contact_id;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties

	// HTML ENTITY ENCODED NL2BR ORM string properties

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)
	protected static $_arrBidListsToContactsByBidListId;
	protected static $_arrBidListsToContactsByContactId;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllBidListsToContacts;

	// Foreign Key Objects
	private $_bidList;
	private $_contact;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='bid_lists_to_contacts')
	{
		parent::__construct($table);
		$this->setDatabase($database);
	}

	// Foreign Key Object Accessor Methods
	public function getBidList()
	{
		if (isset($this->_bidList)) {
			return $this->_bidList;
		} else {
			return null;
		}
	}

	public function setBidList($bidList)
	{
		$this->_bidList = $bidList;
	}

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
	public static function getArrBidListsToContactsByBidListId()
	{
		if (isset(self::$_arrBidListsToContactsByBidListId)) {
			return self::$_arrBidListsToContactsByBidListId;
		} else {
			return null;
		}
	}

	public static function setArrBidListsToContactsByBidListId($arrBidListsToContactsByBidListId)
	{
		self::$_arrBidListsToContactsByBidListId = $arrBidListsToContactsByBidListId;
	}

	public static function getArrBidListsToContactsByContactId()
	{
		if (isset(self::$_arrBidListsToContactsByContactId)) {
			return self::$_arrBidListsToContactsByContactId;
		} else {
			return null;
		}
	}

	public static function setArrBidListsToContactsByContactId($arrBidListsToContactsByContactId)
	{
		self::$_arrBidListsToContactsByContactId = $arrBidListsToContactsByContactId;
	}

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllBidListsToContacts()
	{
		if (isset(self::$_arrAllBidListsToContacts)) {
			return self::$_arrAllBidListsToContacts;
		} else {
			return null;
		}
	}

	public static function setArrAllBidListsToContacts($arrAllBidListsToContacts)
	{
		self::$_arrAllBidListsToContacts = $arrAllBidListsToContacts;
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
	 * Find by primary key (`bid_list_id`,`contact_id`).
	 *
	 * @param string $database
	 * @param int $bid_list_id
	 * @param int $contact_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findByBidListIdAndContactId($database, $bid_list_id, $contact_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	bl2c.*

FROM `bid_lists_to_contacts` bl2c
WHERE bl2c.`bid_list_id` = ?
AND bl2c.`contact_id` = ?
";
		$arrValues = array($bid_list_id, $contact_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row && !empty($row)) {
			$bidListToContact = self::instantiateOrm($database, 'BidListToContact', $row);
			/* @var $bidListToContact BidListToContact */
			return $bidListToContact;
		} else {
			return false;
		}
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Find by primary key (`bid_list_id`,`contact_id`) Extended.
	 *
	 * @param string $database
	 * @param int $bid_list_id
	 * @param int $contact_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findByBidListIdAndContactIdExtended($database, $bid_list_id, $contact_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	bl2c_fk_bl.`id` AS 'bl2c_fk_bl__bid_list_id',
	bl2c_fk_bl.`user_company_id` AS 'bl2c_fk_bl__user_company_id',
	bl2c_fk_bl.`bid_list_name` AS 'bl2c_fk_bl__bid_list_name',
	bl2c_fk_bl.`bid_list_description` AS 'bl2c_fk_bl__bid_list_description',
	bl2c_fk_bl.`sort_order` AS 'bl2c_fk_bl__sort_order',

	bl2c_fk_c.`id` AS 'bl2c_fk_c__contact_id',
	bl2c_fk_c.`user_company_id` AS 'bl2c_fk_c__user_company_id',
	bl2c_fk_c.`user_id` AS 'bl2c_fk_c__user_id',
	bl2c_fk_c.`contact_company_id` AS 'bl2c_fk_c__contact_company_id',
	bl2c_fk_c.`email` AS 'bl2c_fk_c__email',
	bl2c_fk_c.`name_prefix` AS 'bl2c_fk_c__name_prefix',
	bl2c_fk_c.`first_name` AS 'bl2c_fk_c__first_name',
	bl2c_fk_c.`additional_name` AS 'bl2c_fk_c__additional_name',
	bl2c_fk_c.`middle_name` AS 'bl2c_fk_c__middle_name',
	bl2c_fk_c.`last_name` AS 'bl2c_fk_c__last_name',
	bl2c_fk_c.`name_suffix` AS 'bl2c_fk_c__name_suffix',
	bl2c_fk_c.`title` AS 'bl2c_fk_c__title',
	bl2c_fk_c.`vendor_flag` AS 'bl2c_fk_c__vendor_flag',

	bl2c.*

FROM `bid_lists_to_contacts` bl2c
	INNER JOIN `bid_lists` bl2c_fk_bl ON bl2c.`bid_list_id` = bl2c_fk_bl.`id`
	INNER JOIN `contacts` bl2c_fk_c ON bl2c.`contact_id` = bl2c_fk_c.`id`
WHERE bl2c.`bid_list_id` = ?
AND bl2c.`contact_id` = ?
";
		$arrValues = array($bid_list_id, $contact_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row && !empty($row)) {
			$bidListToContact = self::instantiateOrm($database, 'BidListToContact', $row);
			/* @var $bidListToContact BidListToContact */
			$bidListToContact->convertPropertiesToData();

			if (isset($row['bid_list_id'])) {
				$bid_list_id = $row['bid_list_id'];
				$row['bl2c_fk_bl__id'] = $bid_list_id;
				$bidList = self::instantiateOrm($database, 'BidList', $row, null, $bid_list_id, 'bl2c_fk_bl__');
				/* @var $bidList BidList */
				$bidList->convertPropertiesToData();
			} else {
				$bidList = false;
			}
			$bidListToContact->setBidList($bidList);

			if (isset($row['contact_id'])) {
				$contact_id = $row['contact_id'];
				$row['bl2c_fk_c__id'] = $contact_id;
				$contact = self::instantiateOrm($database, 'Contact', $row, null, $contact_id, 'bl2c_fk_c__');
				/* @var $contact Contact */
				$contact->convertPropertiesToData();
			} else {
				$contact = false;
			}
			$bidListToContact->setContact($contact);

			return $bidListToContact;
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
	 * @param array $arrBidListIdAndContactIdList
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadBidListsToContactsByArrBidListIdAndContactIdList($database, $arrBidListIdAndContactIdList, Input $options=null)
	{
		if (empty($arrBidListIdAndContactIdList)) {
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
		// ORDER BY `bid_list_id` ASC, `contact_id` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpBidListToContact = new BidListToContact($database);
			$sqlOrderByColumns = $tmpBidListToContact->constructSqlOrderByColumns($arrOrderByAttributes);

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
		foreach ($arrBidListIdAndContactIdList as $k => $arrTmp) {
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
		if (count($arrBidListIdAndContactIdList) > 1) {
			$sqlWhere = join($arrSqlWhere, ' OR ');
			$sqlWhere = "WHERE ($sqlWhere)";
		} else {
			$sqlWhere = "WHERE $tmpInnerAnd";
		}

		$query =
"
SELECT

	bl2c.*

FROM `bid_lists_to_contacts` bl2c
{$sqlWhere}{$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrBidListsToContactsByArrBidListIdAndContactIdList = array();
		while ($row = $db->fetch()) {
			$bidListToContact = self::instantiateOrm($database, 'BidListToContact', $row);
			/* @var $bidListToContact BidListToContact */
			$arrBidListsToContactsByArrBidListIdAndContactIdList[] = $bidListToContact;
		}

		$db->free_result();

		return $arrBidListsToContactsByArrBidListIdAndContactIdList;
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `bid_lists_to_contacts_fk_bl` foreign key (`bid_list_id`) references `bid_lists` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $bid_list_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadBidListsToContactsByBidListId($database, $bid_list_id, Input $options=null)
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
			self::$_arrBidListsToContactsByBidListId = null;
		}

		$arrBidListsToContactsByBidListId = self::$_arrBidListsToContactsByBidListId;
		if (isset($arrBidListsToContactsByBidListId) && !empty($arrBidListsToContactsByBidListId)) {
			return $arrBidListsToContactsByBidListId;
		}

		$bid_list_id = (int) $bid_list_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `bid_list_id` ASC, `contact_id` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpBidListToContact = new BidListToContact($database);
			$sqlOrderByColumns = $tmpBidListToContact->constructSqlOrderByColumns($arrOrderByAttributes);

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
	bl2c_fk_c.`id` AS 'bl2c_fk_c__contact_id',
	bl2c_fk_c.`user_company_id` AS 'bl2c_fk_c__user_company_id',
	bl2c_fk_c.`user_id` AS 'bl2c_fk_c__user_id',
	bl2c_fk_c.`contact_company_id` AS 'bl2c_fk_c__contact_company_id',
	bl2c_fk_c.`email` AS 'bl2c_fk_c__email',
	bl2c_fk_c.`name_prefix` AS 'bl2c_fk_c__name_prefix',
	bl2c_fk_c.`first_name` AS 'bl2c_fk_c__first_name',
	bl2c_fk_c.`additional_name` AS 'bl2c_fk_c__additional_name',
	bl2c_fk_c.`middle_name` AS 'bl2c_fk_c__middle_name',
	bl2c_fk_c.`last_name` AS 'bl2c_fk_c__last_name',
	bl2c_fk_c.`name_suffix` AS 'bl2c_fk_c__name_suffix',
	bl2c_fk_c.`title` AS 'bl2c_fk_c__title',
	bl2c_fk_c.`vendor_flag` AS 'bl2c_fk_c__vendor_flag',

	bl2c.*

FROM `bid_lists_to_contacts` bl2c
	INNER JOIN `contacts` bl2c_fk_c ON bl2c.`contact_id` = bl2c_fk_c.`id`
WHERE bl2c.`bid_list_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `bid_list_id` ASC, `contact_id` ASC
		$arrValues = array($bid_list_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrBidListsToContactsByBidListId = array();
		while ($row = $db->fetch()) {
			$bidListToContact = self::instantiateOrm($database, 'BidListToContact', $row);
			/* @var $bidListToContact BidListToContact */
			$bidListToContact->convertPropertiesToData();

			if (isset($row['contact_id'])) {
				$contact_id = $row['contact_id'];
				$row['bl2c_fk_c__id'] = $contact_id;
				$contact = self::instantiateOrm($database, 'Contact', $row, null, $contact_id, 'bl2c_fk_c__');
				/* @var $contact Contact */
				$contact->convertPropertiesToData();
			} else {
				$contact = false;
			}
			$bidListToContact->setContact($contact);

			$arrBidListsToContactsByBidListId[] = $bidListToContact;
		}

		$db->free_result();

		self::$_arrBidListsToContactsByBidListId = $arrBidListsToContactsByBidListId;

		return $arrBidListsToContactsByBidListId;
	}

	/**
	 * Load by constraint `bid_lists_to_contacts_fk_c` foreign key (`contact_id`) references `contacts` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $contact_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadBidListsToContactsByContactId($database, $contact_id, Input $options=null)
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
			self::$_arrBidListsToContactsByContactId = null;
		}

		$arrBidListsToContactsByContactId = self::$_arrBidListsToContactsByContactId;
		if (isset($arrBidListsToContactsByContactId) && !empty($arrBidListsToContactsByContactId)) {
			return $arrBidListsToContactsByContactId;
		}

		$contact_id = (int) $contact_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `bid_list_id` ASC, `contact_id` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpBidListToContact = new BidListToContact($database);
			$sqlOrderByColumns = $tmpBidListToContact->constructSqlOrderByColumns($arrOrderByAttributes);

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
	bl2c.*

FROM `bid_lists_to_contacts` bl2c
WHERE bl2c.`contact_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `bid_list_id` ASC, `contact_id` ASC
		$arrValues = array($contact_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrBidListsToContactsByContactId = array();
		while ($row = $db->fetch()) {
			$bidListToContact = self::instantiateOrm($database, 'BidListToContact', $row);
			/* @var $bidListToContact BidListToContact */
			$arrBidListsToContactsByContactId[] = $bidListToContact;
		}

		$db->free_result();

		self::$_arrBidListsToContactsByContactId = $arrBidListsToContactsByContactId;

		return $arrBidListsToContactsByContactId;
	}

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all bid_lists_to_contacts records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllBidListsToContacts($database, Input $options=null)
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
			self::$_arrAllBidListsToContacts = null;
		}

		$arrAllBidListsToContacts = self::$_arrAllBidListsToContacts;
		if (isset($arrAllBidListsToContacts) && !empty($arrAllBidListsToContacts)) {
			return $arrAllBidListsToContacts;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `bid_list_id` ASC, `contact_id` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpBidListToContact = new BidListToContact($database);
			$sqlOrderByColumns = $tmpBidListToContact->constructSqlOrderByColumns($arrOrderByAttributes);

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
	bl2c.*

FROM `bid_lists_to_contacts` bl2c{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `bid_list_id` ASC, `contact_id` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllBidListsToContacts = array();
		while ($row = $db->fetch()) {
			$bidListToContact = self::instantiateOrm($database, 'BidListToContact', $row);
			/* @var $bidListToContact BidListToContact */
			$arrAllBidListsToContacts[] = $bidListToContact;
		}

		$db->free_result();

		self::$_arrAllBidListsToContacts = $arrAllBidListsToContacts;

		return $arrAllBidListsToContacts;
	}

	// Save: insert on duplicate key update

	// Save: insert ignore
	public function insertIgnore()
	{
		$database = $this->getDatabase();
		$db = $this->getDb($database);
		/* @var $db DBI_mysqli */

		$query =
"
INSERT IGNORE
INTO `bid_lists_to_contacts`
(`bid_list_id`, `contact_id`)
VALUES (?, ?)
";
		$arrValues = array($this->bid_list_id, $this->contact_id);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$db->free_result();

		return true;
	}

	public static function addContactToBidList($database, $bid_list_id, $contact_id)
	{
		$bid_list_id = (int) $bid_list_id;
		$contact_id = (int) $contact_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
INSERT IGNORE
INTO `bid_lists_to_contacts`
(`bid_list_id`, `contact_id`)
VALUES (?, ?)
";
		$arrValues = array($bid_list_id, $contact_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$db->free_result();
	}
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

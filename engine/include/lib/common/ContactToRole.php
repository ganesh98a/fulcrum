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
 * ContactToRole.
 *
 * @category   Framework
 * @package    ContactToRole
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class ContactToRole extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'ContactToRole';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'contacts_to_roles';

	/**
	 * primary key (`contact_id`,`role_id`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrPrimaryKey = array(
		'contact_id' => 'int',
		'role_id' => 'int'
	);

	/**
	 * No Unique Indexes, Just a Primary Key
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_contact_to_role_via_primary_key' => array(
			'contact_id' => 'int',
			'role_id' => 'int'
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
		'role_id' => 'role_id'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $contact_id;
	public $role_id;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties

	// HTML ENTITY ENCODED NL2BR ORM string properties

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)
	protected static $_arrContactsToRolesByContactId;
	protected static $_arrContactsToRolesByRoleId;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllContactsToRoles;

	// Foreign Key Objects
	private $_contact;
	private $_role;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='contacts_to_roles')
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

	public function getRole()
	{
		if (isset($this->_role)) {
			return $this->_role;
		} else {
			return null;
		}
	}

	public function setRole($role)
	{
		$this->_role = $role;
	}

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)
	public static function getArrContactsToRolesByContactId()
	{
		if (isset(self::$_arrContactsToRolesByContactId)) {
			return self::$_arrContactsToRolesByContactId;
		} else {
			return null;
		}
	}

	public static function setArrContactsToRolesByContactId($arrContactsToRolesByContactId)
	{
		self::$_arrContactsToRolesByContactId = $arrContactsToRolesByContactId;
	}

	public static function getArrContactsToRolesByRoleId()
	{
		if (isset(self::$_arrContactsToRolesByRoleId)) {
			return self::$_arrContactsToRolesByRoleId;
		} else {
			return null;
		}
	}

	public static function setArrContactsToRolesByRoleId($arrContactsToRolesByRoleId)
	{
		self::$_arrContactsToRolesByRoleId = $arrContactsToRolesByRoleId;
	}

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllContactsToRoles()
	{
		if (isset(self::$_arrAllContactsToRoles)) {
			return self::$_arrAllContactsToRoles;
		} else {
			return null;
		}
	}

	public static function setArrAllContactsToRoles($arrAllContactsToRoles)
	{
		self::$_arrAllContactsToRoles = $arrAllContactsToRoles;
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
	 * Find by primary key (`contact_id`,`role_id`).
	 *
	 * @param string $database
	 * @param int $contact_id
	 * @param int $role_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findByContactIdAndRoleId($database, $contact_id, $role_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	c2r.*

FROM `contacts_to_roles` c2r
WHERE c2r.`contact_id` = ?
AND c2r.`role_id` = ?
";
		$arrValues = array($contact_id, $role_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row && !empty($row)) {
			$contactToRole = self::instantiateOrm($database, 'ContactToRole', $row);
			/* @var $contactToRole ContactToRole */
			return $contactToRole;
		} else {
			return false;
		}
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Find by primary key (`contact_id`,`role_id`) Extended.
	 *
	 * @param string $database
	 * @param int $contact_id
	 * @param int $role_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findByContactIdAndRoleIdExtended($database, $contact_id, $role_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	c2r_fk_c.`id` AS 'c2r_fk_c__contact_id',
	c2r_fk_c.`user_company_id` AS 'c2r_fk_c__user_company_id',
	c2r_fk_c.`user_id` AS 'c2r_fk_c__user_id',
	c2r_fk_c.`contact_company_id` AS 'c2r_fk_c__contact_company_id',
	c2r_fk_c.`email` AS 'c2r_fk_c__email',
	c2r_fk_c.`name_prefix` AS 'c2r_fk_c__name_prefix',
	c2r_fk_c.`first_name` AS 'c2r_fk_c__first_name',
	c2r_fk_c.`additional_name` AS 'c2r_fk_c__additional_name',
	c2r_fk_c.`middle_name` AS 'c2r_fk_c__middle_name',
	c2r_fk_c.`last_name` AS 'c2r_fk_c__last_name',
	c2r_fk_c.`name_suffix` AS 'c2r_fk_c__name_suffix',
	c2r_fk_c.`title` AS 'c2r_fk_c__title',
	c2r_fk_c.`vendor_flag` AS 'c2r_fk_c__vendor_flag',

	c2r_fk_r.`id` AS 'c2r_fk_r__role_id',
	c2r_fk_r.`role` AS 'c2r_fk_r__role',
	c2r_fk_r.`role_description` AS 'c2r_fk_r__role_description',
	c2r_fk_r.`project_specific_flag` AS 'c2r_fk_r__project_specific_flag',
	c2r_fk_r.`sort_order` AS 'c2r_fk_r__sort_order',

	c2r.*

FROM `contacts_to_roles` c2r
	INNER JOIN `contacts` c2r_fk_c ON c2r.`contact_id` = c2r_fk_c.`id`
	INNER JOIN `roles` c2r_fk_r ON c2r.`role_id` = c2r_fk_r.`id`
WHERE c2r.`contact_id` = ?
AND c2r.`role_id` = ?
";
		$arrValues = array($contact_id, $role_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row && !empty($row)) {
			$contactToRole = self::instantiateOrm($database, 'ContactToRole', $row);
			/* @var $contactToRole ContactToRole */
			$contactToRole->convertPropertiesToData();

			if (isset($row['contact_id'])) {
				$contact_id = $row['contact_id'];
				$row['c2r_fk_c__id'] = $contact_id;
				$contact = self::instantiateOrm($database, 'Contact', $row, null, $contact_id, 'c2r_fk_c__');
				/* @var $contact Contact */
				$contact->convertPropertiesToData();
			} else {
				$contact = false;
			}
			$contactToRole->setContact($contact);

			if (isset($row['role_id'])) {
				$role_id = $row['role_id'];
				$row['c2r_fk_r__id'] = $role_id;
				$role = self::instantiateOrm($database, 'Role', $row, null, $role_id, 'c2r_fk_r__');
				/* @var $role Role */
				$role->convertPropertiesToData();
			} else {
				$role = false;
			}
			$contactToRole->setRole($role);

			return $contactToRole;
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
	 * @param array $arrContactIdAndRoleIdList
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadContactsToRolesByArrContactIdAndRoleIdList($database, $arrContactIdAndRoleIdList, Input $options=null)
	{
		if (empty($arrContactIdAndRoleIdList)) {
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
		// ORDER BY `contact_id` ASC, `role_id` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpContactToRole = new ContactToRole($database);
			$sqlOrderByColumns = $tmpContactToRole->constructSqlOrderByColumns($arrOrderByAttributes);

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
		foreach ($arrContactIdAndRoleIdList as $k => $arrTmp) {
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
		if (count($arrContactIdAndRoleIdList) > 1) {
			$sqlWhere = join($arrSqlWhere, ' OR ');
			$sqlWhere = "WHERE ($sqlWhere)";
		} else {
			$sqlWhere = "WHERE $tmpInnerAnd";
		}

		$query =
"
SELECT

	c2r.*

FROM `contacts_to_roles` c2r
{$sqlWhere}{$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrContactsToRolesByArrContactIdAndRoleIdList = array();
		while ($row = $db->fetch()) {
			$contactToRole = self::instantiateOrm($database, 'ContactToRole', $row);
			/* @var $contactToRole ContactToRole */
			$arrContactsToRolesByArrContactIdAndRoleIdList[] = $contactToRole;
		}

		$db->free_result();

		return $arrContactsToRolesByArrContactIdAndRoleIdList;
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `contacts_to_roles_fk_c` foreign key (`contact_id`) references `contacts` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $contact_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadContactsToRolesByContactId($database, $contact_id, Input $options=null)
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
			self::$_arrContactsToRolesByContactId = null;
		}

		$arrContactsToRolesByContactId = self::$_arrContactsToRolesByContactId;
		if (isset($arrContactsToRolesByContactId) && !empty($arrContactsToRolesByContactId)) {
			return $arrContactsToRolesByContactId;
		}

		$contact_id = (int) $contact_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `contact_id` ASC, `role_id` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpContactToRole = new ContactToRole($database);
			$sqlOrderByColumns = $tmpContactToRole->constructSqlOrderByColumns($arrOrderByAttributes);

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
	c2r.*

FROM `contacts_to_roles` c2r
WHERE c2r.`contact_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `contact_id` ASC, `role_id` ASC
		$arrValues = array($contact_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrContactsToRolesByContactId = array();
		while ($row = $db->fetch()) {
			$contactToRole = self::instantiateOrm($database, 'ContactToRole', $row);
			/* @var $contactToRole ContactToRole */
			$arrContactsToRolesByContactId[] = $contactToRole;
		}

		$db->free_result();

		self::$_arrContactsToRolesByContactId = $arrContactsToRolesByContactId;

		return $arrContactsToRolesByContactId;
	}

	/**
	 * Load by constraint `contacts_to_roles_fk_r` foreign key (`role_id`) references `roles` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $role_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadContactsToRolesByRoleId($database, $role_id, Input $options=null)
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
			self::$_arrContactsToRolesByRoleId = null;
		}

		$arrContactsToRolesByRoleId = self::$_arrContactsToRolesByRoleId;
		if (isset($arrContactsToRolesByRoleId) && !empty($arrContactsToRolesByRoleId)) {
			return $arrContactsToRolesByRoleId;
		}

		$role_id = (int) $role_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `contact_id` ASC, `role_id` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpContactToRole = new ContactToRole($database);
			$sqlOrderByColumns = $tmpContactToRole->constructSqlOrderByColumns($arrOrderByAttributes);

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
	c2r.*

FROM `contacts_to_roles` c2r
WHERE c2r.`role_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `contact_id` ASC, `role_id` ASC
		$arrValues = array($role_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrContactsToRolesByRoleId = array();
		while ($row = $db->fetch()) {
			$contactToRole = self::instantiateOrm($database, 'ContactToRole', $row);
			/* @var $contactToRole ContactToRole */
			$arrContactsToRolesByRoleId[] = $contactToRole;
		}

		$db->free_result();

		self::$_arrContactsToRolesByRoleId = $arrContactsToRolesByRoleId;

		return $arrContactsToRolesByRoleId;
	}

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all contacts_to_roles records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllContactsToRoles($database, Input $options=null)
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
			self::$_arrAllContactsToRoles = null;
		}

		$arrAllContactsToRoles = self::$_arrAllContactsToRoles;
		if (isset($arrAllContactsToRoles) && !empty($arrAllContactsToRoles)) {
			return $arrAllContactsToRoles;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `contact_id` ASC, `role_id` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpContactToRole = new ContactToRole($database);
			$sqlOrderByColumns = $tmpContactToRole->constructSqlOrderByColumns($arrOrderByAttributes);

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
	c2r.*

FROM `contacts_to_roles` c2r{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `contact_id` ASC, `role_id` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllContactsToRoles = array();
		while ($row = $db->fetch()) {
			$contactToRole = self::instantiateOrm($database, 'ContactToRole', $row);
			/* @var $contactToRole ContactToRole */
			$arrAllContactsToRoles[] = $contactToRole;
		}

		$db->free_result();

		self::$_arrAllContactsToRoles = $arrAllContactsToRoles;

		return $arrAllContactsToRoles;
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
INTO `contacts_to_roles`
(`contact_id`, `role_id`)
VALUES (?, ?)
";
		$arrValues = array($this->contact_id, $this->role_id);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$db->free_result();

		return true;
	}

	public static function loadContactsToRolesByUserId($database, $user_id, Input $options=null)
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
			self::$_arrContactsToRolesByUserId = null;
		}

		$arrContactsToRolesByUserId = self::$_arrContactsToRolesByUserId;
		if (isset($arrContactsToRolesByUserId) && !empty($arrContactsToRolesByUserId)) {
			return $arrContactsToRolesByUserId;
		}

		$contact_id = (int) $contact_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `contact_id` ASC, `role_id` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpContactToRole = new ContactToRole($database);
			$sqlOrderByColumns = $tmpContactToRole->constructSqlOrderByColumns($arrOrderByAttributes);

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

	c2r.*

FROM `contacts_to_roles` c2r
WHERE c2r.`contact_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `contact_id` ASC, `role_id` ASC
		$arrValues = array($contact_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrContactsToRolesByContactId = array();
		while ($row = $db->fetch()) {
			$contactToRole = self::instantiateOrm($database, 'ContactToRole', $row);
			/* @var $contactToRole ContactToRole */
			$arrContactsToRolesByContactId[] = $contactToRole;
		}

		$db->free_result();

		self::$_arrContactsToRolesByContactId = $arrContactsToRolesByContactId;

		return $arrContactsToRolesByContactId;
	
	}

	public static function loadAssignedRolesByContactId($database, $contact_id, Input $options=null)
	{
		$arrAssignedRolesByContactId = self::loadContactsToRolesByContactId($database, $contact_id, $options);

		return $arrAssignedRolesByContactId;
	}

	/**
	 * INSERT a single record into an "association table" (join-box).
	 *
	 * @param string $database
	 * @param int $contact_id
	 * @param int $role_id
	 */
	public static function addRoleToContact($database, $contact_id, $role_id)
	{
		$AXIS_USER_ROLE_ID_USER = AXIS_USER_ROLE_ID_USER;

		$insertIgnoreQuery =
"
INSERT IGNORE
INTO `contacts_to_roles` (`contact_id`, `role_id`)
VALUES (?, ?)
";

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$db->begin();

		$arrValues = array($contact_id, $role_id);
		$db->execute($insertIgnoreQuery, $arrValues, MYSQLI_USE_RESULT);
		$db->free_result();

		if ($role_id <> $AXIS_USER_ROLE_ID_USER) {
			$arrValues = array($contact_id, $AXIS_USER_ROLE_ID_USER);
			$db->execute($insertIgnoreQuery, $arrValues, MYSQLI_USE_RESULT);
			$db->free_result();
		}

		$db->commit();
		$db->free_result();
	}

	/**
	 * INSERT a single record into an "association table" (join-box).
	 *
	 * @param string $database
	 * @param int $contact_id
	 * @param int $role_id
	 */
	public static function removeRoleFromContact($database, $contact_id, $role_id)
	{
		$AXIS_USER_ROLE_ID_USER = AXIS_USER_ROLE_ID_USER;

		if ($role_id == $AXIS_USER_ROLE_ID_USER) {
			return;
		}

		$insertIgnoreQuery =
"
INSERT IGNORE
INTO `contacts_to_roles` (`contact_id`, `role_id`)
VALUES (?, $AXIS_USER_ROLE_ID_USER)
";

		$deleteQuery =
"
DELETE FROM `contacts_to_roles`
WHERE `contact_id` = ?
AND `role_id` = ?
";

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$db->begin();

		$arrValues = array($contact_id, $role_id);
		$db->execute($deleteQuery, $arrValues, MYSQLI_USE_RESULT);
		$db->free_result();

		$arrValues = array($contact_id);
		$db->execute($insertIgnoreQuery, $arrValues, MYSQLI_USE_RESULT);
		$db->free_result();

		$db->commit();
		$db->free_result();
	}

	/**
	 * Add a contact to contacts_to_roles.
	 *
	 * @param string $database
	 * @param int $contact_id
	 */
	public static function addContact($database, $contact_id)
	{
		$AXIS_USER_ROLE_ID_USER = AXIS_USER_ROLE_ID_USER;

		$insertIgnoreQuery =
"
INSERT IGNORE
INTO `contacts_to_roles` (`contact_id`, `role_id`)
VALUES (?, $AXIS_USER_ROLE_ID_USER)
";

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$db->begin();

		$arrValues = array($contact_id);
		$db->execute($insertIgnoreQuery, $arrValues, MYSQLI_USE_RESULT);
		$db->free_result();

		$db->commit();
		$db->free_result();
	}

	public static function removeContact($database, $contact_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$deleteQuery =
"
DELETE
FROM `contacts_to_roles`
WHERE `contact_id` = ?
";

		$db->begin();

		$arrValues = array($contact_id);
		$db->execute($deleteQuery, $arrValues, MYSQLI_USE_RESULT);
		$db->free_result();

		$db->commit();
		$db->free_result();
	}

	// to remove a admin permisssion to a contact 
		public static function RemoveAdminToContact($contact_id,$role_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$deleteQuery ="DELETE FROM `contacts_to_roles` WHERE `contact_id` = ? AND `role_id` = ?";

		$db->begin();

		$arrValues = array($contact_id,$role_id);
		$db->execute($deleteQuery, $arrValues, MYSQLI_USE_RESULT);
		$db->free_result();

		$db->commit();
		$db->free_result();
	}
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

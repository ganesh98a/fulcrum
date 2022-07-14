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
 * ContactToSoftwareModuleFunction.
 *
 * @category   Framework
 * @package    ContactToSoftwareModuleFunction
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class ContactToSoftwareModuleFunction extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'ContactToSoftwareModuleFunction';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'contacts_to_software_module_functions';

	/**
	 * primary key (`contact_id`,`software_module_function_id`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrPrimaryKey = array(
		'contact_id' => 'int',
		'software_module_function_id' => 'int'
	);

	/**
	 * No Unique Indexes, Just a Primary Key
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_contact_to_software_module_function_via_primary_key' => array(
			'contact_id' => 'int',
			'software_module_function_id' => 'int'
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
		'software_module_function_id' => 'software_module_function_id'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $contact_id;
	public $software_module_function_id;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties

	// HTML ENTITY ENCODED NL2BR ORM string properties

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)
	protected static $_arrContactsToSoftwareModuleFunctionsByContactId;
	protected static $_arrContactsToSoftwareModuleFunctionsBySoftwareModuleFunctionId;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllContactsToSoftwareModuleFunctions;

	// Foreign Key Objects
	private $_contact;
	private $_softwareModuleFunction;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='contacts_to_software_module_functions')
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

	public function getSoftwareModuleFunction()
	{
		if (isset($this->_softwareModuleFunction)) {
			return $this->_softwareModuleFunction;
		} else {
			return null;
		}
	}

	public function setSoftwareModuleFunction($softwareModuleFunction)
	{
		$this->_softwareModuleFunction = $softwareModuleFunction;
	}

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)
	public static function getArrContactsToSoftwareModuleFunctionsByContactId()
	{
		if (isset(self::$_arrContactsToSoftwareModuleFunctionsByContactId)) {
			return self::$_arrContactsToSoftwareModuleFunctionsByContactId;
		} else {
			return null;
		}
	}

	public static function setArrContactsToSoftwareModuleFunctionsByContactId($arrContactsToSoftwareModuleFunctionsByContactId)
	{
		self::$_arrContactsToSoftwareModuleFunctionsByContactId = $arrContactsToSoftwareModuleFunctionsByContactId;
	}

	public static function getArrContactsToSoftwareModuleFunctionsBySoftwareModuleFunctionId()
	{
		if (isset(self::$_arrContactsToSoftwareModuleFunctionsBySoftwareModuleFunctionId)) {
			return self::$_arrContactsToSoftwareModuleFunctionsBySoftwareModuleFunctionId;
		} else {
			return null;
		}
	}

	public static function setArrContactsToSoftwareModuleFunctionsBySoftwareModuleFunctionId($arrContactsToSoftwareModuleFunctionsBySoftwareModuleFunctionId)
	{
		self::$_arrContactsToSoftwareModuleFunctionsBySoftwareModuleFunctionId = $arrContactsToSoftwareModuleFunctionsBySoftwareModuleFunctionId;
	}

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllContactsToSoftwareModuleFunctions()
	{
		if (isset(self::$_arrAllContactsToSoftwareModuleFunctions)) {
			return self::$_arrAllContactsToSoftwareModuleFunctions;
		} else {
			return null;
		}
	}

	public static function setArrAllContactsToSoftwareModuleFunctions($arrAllContactsToSoftwareModuleFunctions)
	{
		self::$_arrAllContactsToSoftwareModuleFunctions = $arrAllContactsToSoftwareModuleFunctions;
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
	 * Find by primary key (`contact_id`,`software_module_function_id`).
	 *
	 * @param string $database
	 * @param int $contact_id
	 * @param int $software_module_function_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findByContactIdAndSoftwareModuleFunctionId($database, $contact_id, $software_module_function_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	c2smf.*

FROM `contacts_to_software_module_functions` c2smf
WHERE c2smf.`contact_id` = ?
AND c2smf.`software_module_function_id` = ?
";
		$arrValues = array($contact_id, $software_module_function_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row && !empty($row)) {
			$contactToSoftwareModuleFunction = self::instantiateOrm($database, 'ContactToSoftwareModuleFunction', $row);
			/* @var $contactToSoftwareModuleFunction ContactToSoftwareModuleFunction */
			return $contactToSoftwareModuleFunction;
		} else {
			return false;
		}
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Find by primary key (`contact_id`,`software_module_function_id`) Extended.
	 *
	 * @param string $database
	 * @param int $contact_id
	 * @param int $software_module_function_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findByContactIdAndSoftwareModuleFunctionIdExtended($database, $contact_id, $software_module_function_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	c2smf_fk_c.`id` AS 'c2smf_fk_c__contact_id',
	c2smf_fk_c.`user_company_id` AS 'c2smf_fk_c__user_company_id',
	c2smf_fk_c.`user_id` AS 'c2smf_fk_c__user_id',
	c2smf_fk_c.`contact_company_id` AS 'c2smf_fk_c__contact_company_id',
	c2smf_fk_c.`email` AS 'c2smf_fk_c__email',
	c2smf_fk_c.`name_prefix` AS 'c2smf_fk_c__name_prefix',
	c2smf_fk_c.`first_name` AS 'c2smf_fk_c__first_name',
	c2smf_fk_c.`additional_name` AS 'c2smf_fk_c__additional_name',
	c2smf_fk_c.`middle_name` AS 'c2smf_fk_c__middle_name',
	c2smf_fk_c.`last_name` AS 'c2smf_fk_c__last_name',
	c2smf_fk_c.`name_suffix` AS 'c2smf_fk_c__name_suffix',
	c2smf_fk_c.`title` AS 'c2smf_fk_c__title',
	c2smf_fk_c.`vendor_flag` AS 'c2smf_fk_c__vendor_flag',

	c2smf_fk_smf.`id` AS 'c2smf_fk_smf__software_module_function_id',
	c2smf_fk_smf.`software_module_id` AS 'c2smf_fk_smf__software_module_id',
	c2smf_fk_smf.`software_module_function` AS 'c2smf_fk_smf__software_module_function',
	c2smf_fk_smf.`software_module_function_label` AS 'c2smf_fk_smf__software_module_function_label',
	c2smf_fk_smf.`software_module_function_navigation_label` AS 'c2smf_fk_smf__software_module_function_navigation_label',
	c2smf_fk_smf.`software_module_function_description` AS 'c2smf_fk_smf__software_module_function_description',
	c2smf_fk_smf.`default_software_module_function_url` AS 'c2smf_fk_smf__default_software_module_function_url',
	c2smf_fk_smf.`show_in_navigation_flag` AS 'c2smf_fk_smf__show_in_navigation_flag',
	c2smf_fk_smf.`available_to_all_users_flag` AS 'c2smf_fk_smf__available_to_all_users_flag',
	c2smf_fk_smf.`global_admin_only_flag` AS 'c2smf_fk_smf__global_admin_only_flag',
	c2smf_fk_smf.`purchased_function_flag` AS 'c2smf_fk_smf__purchased_function_flag',
	c2smf_fk_smf.`customer_configurable_permissions_by_role_flag` AS 'c2smf_fk_smf__customer_configurable_permissions_by_role_flag',
	c2smf_fk_smf.`customer_configurable_permissions_by_project_by_role_flag` AS 'c2smf_fk_smf__customer_configurable_permissions_by_project_by_role_flag',
	c2smf_fk_smf.`customer_configurable_permissions_by_contact_flag` AS 'c2smf_fk_smf__customer_configurable_permissions_by_contact_flag',
	c2smf_fk_smf.`project_specific_flag` AS 'c2smf_fk_smf__project_specific_flag',
	c2smf_fk_smf.`disabled_flag` AS 'c2smf_fk_smf__disabled_flag',
	c2smf_fk_smf.`sort_order` AS 'c2smf_fk_smf__sort_order',

	c2smf.*

FROM `contacts_to_software_module_functions` c2smf
	INNER JOIN `contacts` c2smf_fk_c ON c2smf.`contact_id` = c2smf_fk_c.`id`
	INNER JOIN `software_module_functions` c2smf_fk_smf ON c2smf.`software_module_function_id` = c2smf_fk_smf.`id`
WHERE c2smf.`contact_id` = ?
AND c2smf.`software_module_function_id` = ?
";
		$arrValues = array($contact_id, $software_module_function_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row && !empty($row)) {
			$contactToSoftwareModuleFunction = self::instantiateOrm($database, 'ContactToSoftwareModuleFunction', $row);
			/* @var $contactToSoftwareModuleFunction ContactToSoftwareModuleFunction */
			$contactToSoftwareModuleFunction->convertPropertiesToData();

			if (isset($row['contact_id'])) {
				$contact_id = $row['contact_id'];
				$row['c2smf_fk_c__id'] = $contact_id;
				$contact = self::instantiateOrm($database, 'Contact', $row, null, $contact_id, 'c2smf_fk_c__');
				/* @var $contact Contact */
				$contact->convertPropertiesToData();
			} else {
				$contact = false;
			}
			$contactToSoftwareModuleFunction->setContact($contact);

			if (isset($row['software_module_function_id'])) {
				$software_module_function_id = $row['software_module_function_id'];
				$row['c2smf_fk_smf__id'] = $software_module_function_id;
				$softwareModuleFunction = self::instantiateOrm($database, 'SoftwareModuleFunction', $row, null, $software_module_function_id, 'c2smf_fk_smf__');
				/* @var $softwareModuleFunction SoftwareModuleFunction */
				$softwareModuleFunction->convertPropertiesToData();
			} else {
				$softwareModuleFunction = false;
			}
			$contactToSoftwareModuleFunction->setSoftwareModuleFunction($softwareModuleFunction);

			return $contactToSoftwareModuleFunction;
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
	 * @param array $arrContactIdAndSoftwareModuleFunctionIdList
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadContactsToSoftwareModuleFunctionsByArrContactIdAndSoftwareModuleFunctionIdList($database, $arrContactIdAndSoftwareModuleFunctionIdList, Input $options=null)
	{
		if (empty($arrContactIdAndSoftwareModuleFunctionIdList)) {
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
		// ORDER BY `contact_id` ASC, `software_module_function_id` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpContactToSoftwareModuleFunction = new ContactToSoftwareModuleFunction($database);
			$sqlOrderByColumns = $tmpContactToSoftwareModuleFunction->constructSqlOrderByColumns($arrOrderByAttributes);

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
		foreach ($arrContactIdAndSoftwareModuleFunctionIdList as $k => $arrTmp) {
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
		if (count($arrContactIdAndSoftwareModuleFunctionIdList) > 1) {
			$sqlWhere = join($arrSqlWhere, ' OR ');
			$sqlWhere = "WHERE ($sqlWhere)";
		} else {
			$sqlWhere = "WHERE $tmpInnerAnd";
		}

		$query =
"
SELECT

	c2smf.*

FROM `contacts_to_software_module_functions` c2smf
{$sqlWhere}{$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrContactsToSoftwareModuleFunctionsByArrContactIdAndSoftwareModuleFunctionIdList = array();
		while ($row = $db->fetch()) {
			$contactToSoftwareModuleFunction = self::instantiateOrm($database, 'ContactToSoftwareModuleFunction', $row);
			/* @var $contactToSoftwareModuleFunction ContactToSoftwareModuleFunction */
			$arrContactsToSoftwareModuleFunctionsByArrContactIdAndSoftwareModuleFunctionIdList[] = $contactToSoftwareModuleFunction;
		}

		$db->free_result();

		return $arrContactsToSoftwareModuleFunctionsByArrContactIdAndSoftwareModuleFunctionIdList;
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `contacts_to_software_module_functions_fk_c` foreign key (`contact_id`) references `contacts` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $contact_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadContactsToSoftwareModuleFunctionsByContactId($database, $contact_id, Input $options=null)
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
			self::$_arrContactsToSoftwareModuleFunctionsByContactId = null;
		}

		$arrContactsToSoftwareModuleFunctionsByContactId = self::$_arrContactsToSoftwareModuleFunctionsByContactId;
		if (isset($arrContactsToSoftwareModuleFunctionsByContactId) && !empty($arrContactsToSoftwareModuleFunctionsByContactId)) {
			return $arrContactsToSoftwareModuleFunctionsByContactId;
		}

		$contact_id = (int) $contact_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `contact_id` ASC, `software_module_function_id` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpContactToSoftwareModuleFunction = new ContactToSoftwareModuleFunction($database);
			$sqlOrderByColumns = $tmpContactToSoftwareModuleFunction->constructSqlOrderByColumns($arrOrderByAttributes);

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
	c2smf.*

FROM `contacts_to_software_module_functions` c2smf
WHERE c2smf.`contact_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `contact_id` ASC, `software_module_function_id` ASC
		$arrValues = array($contact_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrContactsToSoftwareModuleFunctionsByContactId = array();
		while ($row = $db->fetch()) {
			$contactToSoftwareModuleFunction = self::instantiateOrm($database, 'ContactToSoftwareModuleFunction', $row);
			/* @var $contactToSoftwareModuleFunction ContactToSoftwareModuleFunction */
			$arrContactsToSoftwareModuleFunctionsByContactId[] = $contactToSoftwareModuleFunction;
		}

		$db->free_result();

		self::$_arrContactsToSoftwareModuleFunctionsByContactId = $arrContactsToSoftwareModuleFunctionsByContactId;

		return $arrContactsToSoftwareModuleFunctionsByContactId;
	}

	/**
	 * Load by constraint `contacts_to_software_module_functions_fk_smf` foreign key (`software_module_function_id`) references `software_module_functions` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $software_module_function_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadContactsToSoftwareModuleFunctionsBySoftwareModuleFunctionId($database, $software_module_function_id, Input $options=null)
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
			self::$_arrContactsToSoftwareModuleFunctionsBySoftwareModuleFunctionId = null;
		}

		$arrContactsToSoftwareModuleFunctionsBySoftwareModuleFunctionId = self::$_arrContactsToSoftwareModuleFunctionsBySoftwareModuleFunctionId;
		if (isset($arrContactsToSoftwareModuleFunctionsBySoftwareModuleFunctionId) && !empty($arrContactsToSoftwareModuleFunctionsBySoftwareModuleFunctionId)) {
			return $arrContactsToSoftwareModuleFunctionsBySoftwareModuleFunctionId;
		}

		$software_module_function_id = (int) $software_module_function_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `contact_id` ASC, `software_module_function_id` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpContactToSoftwareModuleFunction = new ContactToSoftwareModuleFunction($database);
			$sqlOrderByColumns = $tmpContactToSoftwareModuleFunction->constructSqlOrderByColumns($arrOrderByAttributes);

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
	c2smf.*

FROM `contacts_to_software_module_functions` c2smf
WHERE c2smf.`software_module_function_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `contact_id` ASC, `software_module_function_id` ASC
		$arrValues = array($software_module_function_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrContactsToSoftwareModuleFunctionsBySoftwareModuleFunctionId = array();
		while ($row = $db->fetch()) {
			$contactToSoftwareModuleFunction = self::instantiateOrm($database, 'ContactToSoftwareModuleFunction', $row);
			/* @var $contactToSoftwareModuleFunction ContactToSoftwareModuleFunction */
			$arrContactsToSoftwareModuleFunctionsBySoftwareModuleFunctionId[] = $contactToSoftwareModuleFunction;
		}

		$db->free_result();

		self::$_arrContactsToSoftwareModuleFunctionsBySoftwareModuleFunctionId = $arrContactsToSoftwareModuleFunctionsBySoftwareModuleFunctionId;

		return $arrContactsToSoftwareModuleFunctionsBySoftwareModuleFunctionId;
	}

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all contacts_to_software_module_functions records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllContactsToSoftwareModuleFunctions($database, Input $options=null)
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
			self::$_arrAllContactsToSoftwareModuleFunctions = null;
		}

		$arrAllContactsToSoftwareModuleFunctions = self::$_arrAllContactsToSoftwareModuleFunctions;
		if (isset($arrAllContactsToSoftwareModuleFunctions) && !empty($arrAllContactsToSoftwareModuleFunctions)) {
			return $arrAllContactsToSoftwareModuleFunctions;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `contact_id` ASC, `software_module_function_id` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpContactToSoftwareModuleFunction = new ContactToSoftwareModuleFunction($database);
			$sqlOrderByColumns = $tmpContactToSoftwareModuleFunction->constructSqlOrderByColumns($arrOrderByAttributes);

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
	c2smf.*

FROM `contacts_to_software_module_functions` c2smf{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `contact_id` ASC, `software_module_function_id` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllContactsToSoftwareModuleFunctions = array();
		while ($row = $db->fetch()) {
			$contactToSoftwareModuleFunction = self::instantiateOrm($database, 'ContactToSoftwareModuleFunction', $row);
			/* @var $contactToSoftwareModuleFunction ContactToSoftwareModuleFunction */
			$arrAllContactsToSoftwareModuleFunctions[] = $contactToSoftwareModuleFunction;
		}

		$db->free_result();

		self::$_arrAllContactsToSoftwareModuleFunctions = $arrAllContactsToSoftwareModuleFunctions;

		return $arrAllContactsToSoftwareModuleFunctions;
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
INTO `contacts_to_software_module_functions`
(`contact_id`, `software_module_function_id`)
VALUES (?, ?)
";
		$arrValues = array($this->contact_id, $this->software_module_function_id);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$db->free_result();

		return true;
	}
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

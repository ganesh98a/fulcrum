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
 * PhoneNumberType.
 *
 * @category   Framework
 * @package    PhoneNumberType
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class PhoneNumberType extends IntegratedMapper
{
	const BUSINESS = 1;
	const BUSINESS_FAX = 2;
	const MOBILE = 3;
	const ADDITIONAL = 13;

/*
1	Business
2	Business Fax
3	Mobile
4	Home
5	Home Fax
6	Cell
7	Office
8	Office Fax
9	Pager
10	Residential
11	Work
12	Work Fax
*/

	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'PhoneNumberType';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'phone_number_types';

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
	 * unique index `unique_phone_number_type` (`phone_number_type`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_phone_number_type' => array(
			'phone_number_type' => 'string'
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
		'id' => 'phone_number_type_id',

		'phone_number_type' => 'phone_number_type'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $phone_number_type_id;

	public $phone_number_type;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties
	public $escaped_phone_number_type;

	// HTML ENTITY ENCODED NL2BR ORM string properties
	public $escaped_phone_number_type_nl2br;

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllPhoneNumberTypes;

	// Foreign Key Objects

	/**
	 * Constructor
	 */
	public function __construct($database, $table='phone_number_types')
	{
		parent::__construct($table);
		$this->setDatabase($database);
	}

	// Foreign Key Object Accessor Methods

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllPhoneNumberTypes()
	{
		if (isset(self::$_arrAllPhoneNumberTypes)) {
			return self::$_arrAllPhoneNumberTypes;
		} else {
			return null;
		}
	}

	public static function setArrAllPhoneNumberTypes($arrAllPhoneNumberTypes)
	{
		self::$_arrAllPhoneNumberTypes = $arrAllPhoneNumberTypes;
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
	 * @param int $phone_number_type_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findById($database, $phone_number_type_id,$table='phone_number_types', $module='PhoneNumberType')
	{
		$phoneNumberType = parent::findById($database, $phone_number_type_id,$table, $module);

		return $phoneNumberType;
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Similar to FindById, but with SQL as starter code for more complex joins.
	 *
	 * @param string $database
	 * @param int $phone_number_type_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findPhoneNumberTypeByIdExtended($database, $phone_number_type_id)
	{
		$phone_number_type_id = (int) $phone_number_type_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	pnt.*

FROM `phone_number_types` pnt
WHERE pnt.`id` = ?
";
		$arrValues = array($phone_number_type_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$phone_number_type_id = $row['id'];
			$phoneNumberType = self::instantiateOrm($database, 'PhoneNumberType', $row, null, $phone_number_type_id);
			/* @var $phoneNumberType PhoneNumberType */
			$phoneNumberType->convertPropertiesToData();

			return $phoneNumberType;
		} else {
			return false;
		}
	}

	// Finders: Find By Unique Index
	/**
	 * Find by unique index `unique_phone_number_type` (`phone_number_type`).
	 *
	 * @param string $database
	 * @param string $phone_number_type
	 * @return mixed (single ORM object | false)
	 */
	public static function findByPhoneNumberType($database, $phone_number_type)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	pnt.*

FROM `phone_number_types` pnt
WHERE pnt.`phone_number_type` = ?
";
		$arrValues = array($phone_number_type);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if ($row && !empty($row)) {
			$phone_number_type_id = $row['id'];
			$phoneNumberType = self::instantiateOrm($database, 'PhoneNumberType', $row, null, $phone_number_type_id);
			/* @var $phoneNumberType PhoneNumberType */
			return $phoneNumberType;
		} else {
			return false;
		}
	}

	// Loaders: Load By pk List (list of auto int ids or other non auto int pk list)
	/**
	 * Load zero or more records by an id list (array of auto int primary keys).
	 *
	 * @param string $database
	 * @param array $arrPhoneNumberTypeIds
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadPhoneNumberTypesByArrPhoneNumberTypeIds($database, $arrPhoneNumberTypeIds, Input $options=null)
	{
		if (empty($arrPhoneNumberTypeIds)) {
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
		// ORDER BY `id` ASC, `phone_number_type` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpPhoneNumberType = new PhoneNumberType($database);
			$sqlOrderByColumns = $tmpPhoneNumberType->constructSqlOrderByColumns($arrOrderByAttributes);

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

		foreach ($arrPhoneNumberTypeIds as $k => $phone_number_type_id) {
			$phone_number_type_id = (int) $phone_number_type_id;
			$arrPhoneNumberTypeIds[$k] = $db->escape($phone_number_type_id);
		}
		$csvPhoneNumberTypeIds = join(',', $arrPhoneNumberTypeIds);

		$query =
"
SELECT

	pnt.*

FROM `phone_number_types` pnt
WHERE pnt.`id` IN ($csvPhoneNumberTypeIds){$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		$arrPhoneNumberTypesByCsvPhoneNumberTypeIds = array();
		while ($row = $db->fetch()) {
			$phone_number_type_id = $row['id'];
			$phoneNumberType = self::instantiateOrm($database, 'PhoneNumberType', $row, null, $phone_number_type_id);
			/* @var $phoneNumberType PhoneNumberType */
			$phoneNumberType->convertPropertiesToData();

			$arrPhoneNumberTypesByCsvPhoneNumberTypeIds[$phone_number_type_id] = $phoneNumberType;
		}

		$db->free_result();

		return $arrPhoneNumberTypesByCsvPhoneNumberTypeIds;
	}

	// Loaders: Load By Foreign Key

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all phone_number_types records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllPhoneNumberTypes($database, Input $options=null)
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
			self::$_arrAllPhoneNumberTypes = null;
		}

		$arrAllPhoneNumberTypes = self::$_arrAllPhoneNumberTypes;
		if (isset($arrAllPhoneNumberTypes) && !empty($arrAllPhoneNumberTypes)) {
			return $arrAllPhoneNumberTypes;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `phone_number_type` ASC
		$sqlOrderBy = "\nORDER BY pnt.`phone_number_type` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpPhoneNumberType = new PhoneNumberType($database);
			$sqlOrderByColumns = $tmpPhoneNumberType->constructSqlOrderByColumns($arrOrderByAttributes);

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
	pnt.*

FROM `phone_number_types` pnt{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `phone_number_type` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllPhoneNumberTypes = array();
		while ($row = $db->fetch()) {
			$phone_number_type_id = $row['id'];
			$phoneNumberType = self::instantiateOrm($database, 'PhoneNumberType', $row, null, $phone_number_type_id);
			/* @var $phoneNumberType PhoneNumberType */
			$arrAllPhoneNumberTypes[$phone_number_type_id] = $phoneNumberType;
		}

		$db->free_result();

		self::$_arrAllPhoneNumberTypes = $arrAllPhoneNumberTypes;

		return $arrAllPhoneNumberTypes;
	}

	// Save: insert on duplicate key update

	// Save: insert ignore

	public static function parsePhoneNumber($rawPhoneNumber)
	{
		// Remove non-numeric value, e.g. convert "(949) 555-1234" to "9495551234"
		$rawPhoneNumber = trim($rawPhoneNumber);
		$phoneNumber = preg_replace('/[^0-9]+/', '', $rawPhoneNumber, -1);
		$phoneNumber = trim($phoneNumber);
		$area_code = substr($phoneNumber, 0, 3);
		$prefix = substr($phoneNumber, 3, 3);
		$number = substr($phoneNumber, 6, 8);

		$arrPhoneNumber = array(
			'area_code'	=> (string) $area_code,
			'prefix'	=> (string) $prefix,
			'number'	=> (string) $number
		);

		return $arrPhoneNumber;
	}
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

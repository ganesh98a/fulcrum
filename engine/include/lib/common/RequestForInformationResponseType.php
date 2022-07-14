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
 * RequestForInformationResponseType.
 *
 * @category   Framework
 * @package    RequestForInformationResponseType
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class RequestForInformationResponseType extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'RequestForInformationResponseType';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'request_for_information_response_types';

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
	 * unique index `unique_request_for_information_response_type` (`request_for_information_response_type`) comment 'RFI Response Types transcend user_companies so user_company_id is not needed.'
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_request_for_information_response_type' => array(
			'request_for_information_response_type' => 'string'
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
		'id' => 'request_for_information_response_type_id',

		'request_for_information_response_type' => 'request_for_information_response_type',

		'disabled_flag' => 'disabled_flag'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $request_for_information_response_type_id;

	public $request_for_information_response_type;

	public $disabled_flag;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties
	public $escaped_request_for_information_response_type;

	// HTML ENTITY ENCODED NL2BR ORM string properties
	public $escaped_request_for_information_response_type_nl2br;

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllRequestForInformationResponseTypes;

	// Foreign Key Objects

	/**
	 * Constructor
	 */
	public function __construct($database, $table='request_for_information_response_types')
	{
		parent::__construct($table);
		$this->setDatabase($database);
	}

	// Foreign Key Object Accessor Methods

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllRequestForInformationResponseTypes()
	{
		if (isset(self::$_arrAllRequestForInformationResponseTypes)) {
			return self::$_arrAllRequestForInformationResponseTypes;
		} else {
			return null;
		}
	}

	public static function setArrAllRequestForInformationResponseTypes($arrAllRequestForInformationResponseTypes)
	{
		self::$_arrAllRequestForInformationResponseTypes = $arrAllRequestForInformationResponseTypes;
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
	 * @param int $request_for_information_response_type_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findById($database, $request_for_information_response_type_id,$table='request_for_information_response_types', $module='RequestForInformationResponseType')
	{
		$requestForInformationResponseType = parent::findById($database, $request_for_information_response_type_id,$table, $module);

		return $requestForInformationResponseType;
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Similar to FindById, but with SQL as starter code for more complex joins.
	 *
	 * @param string $database
	 * @param int $request_for_information_response_type_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findRequestForInformationResponseTypeByIdExtended($database, $request_for_information_response_type_id)
	{
		$request_for_information_response_type_id = (int) $request_for_information_response_type_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	rfirt.*

FROM `request_for_information_response_types` rfirt
WHERE rfirt.`id` = ?
";
		$arrValues = array($request_for_information_response_type_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$request_for_information_response_type_id = $row['id'];
			$requestForInformationResponseType = self::instantiateOrm($database, 'RequestForInformationResponseType', $row, null, $request_for_information_response_type_id);
			/* @var $requestForInformationResponseType RequestForInformationResponseType */
			$requestForInformationResponseType->convertPropertiesToData();

			return $requestForInformationResponseType;
		} else {
			return false;
		}
	}

	// Finders: Find By Unique Index
	/**
	 * Find by unique index `unique_request_for_information_response_type` (`request_for_information_response_type`) comment 'RFI Response Types transcend user_companies so user_company_id is not needed.'.
	 *
	 * @param string $database
	 * @param string $request_for_information_response_type
	 * @return mixed (single ORM object | false)
	 */
	public static function findByRequestForInformationResponseType($database, $request_for_information_response_type)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	rfirt.*

FROM `request_for_information_response_types` rfirt
WHERE rfirt.`request_for_information_response_type` = ?
";
		$arrValues = array($request_for_information_response_type);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if ($row && !empty($row)) {
			$request_for_information_response_type_id = $row['id'];
			$requestForInformationResponseType = self::instantiateOrm($database, 'RequestForInformationResponseType', $row, null, $request_for_information_response_type_id);
			/* @var $requestForInformationResponseType RequestForInformationResponseType */
			return $requestForInformationResponseType;
		} else {
			return false;
		}
	}

	// Loaders: Load By pk List (list of auto int ids or other non auto int pk list)
	/**
	 * Load zero or more records by an id list (array of auto int primary keys).
	 *
	 * @param string $database
	 * @param array $arrRequestForInformationResponseTypeIds
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadRequestForInformationResponseTypesByArrRequestForInformationResponseTypeIds($database, $arrRequestForInformationResponseTypeIds, Input $options=null)
	{
		if (empty($arrRequestForInformationResponseTypeIds)) {
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
		// ORDER BY `id` ASC, `request_for_information_response_type` ASC, `disabled_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpRequestForInformationResponseType = new RequestForInformationResponseType($database);
			$sqlOrderByColumns = $tmpRequestForInformationResponseType->constructSqlOrderByColumns($arrOrderByAttributes);

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

		foreach ($arrRequestForInformationResponseTypeIds as $k => $request_for_information_response_type_id) {
			$request_for_information_response_type_id = (int) $request_for_information_response_type_id;
			$arrRequestForInformationResponseTypeIds[$k] = $db->escape($request_for_information_response_type_id);
		}
		$csvRequestForInformationResponseTypeIds = join(',', $arrRequestForInformationResponseTypeIds);

		$query =
"
SELECT

	rfirt.*

FROM `request_for_information_response_types` rfirt
WHERE rfirt.`id` IN ($csvRequestForInformationResponseTypeIds){$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		$arrRequestForInformationResponseTypesByCsvRequestForInformationResponseTypeIds = array();
		while ($row = $db->fetch()) {
			$request_for_information_response_type_id = $row['id'];
			$requestForInformationResponseType = self::instantiateOrm($database, 'RequestForInformationResponseType', $row, null, $request_for_information_response_type_id);
			/* @var $requestForInformationResponseType RequestForInformationResponseType */
			$requestForInformationResponseType->convertPropertiesToData();

			$arrRequestForInformationResponseTypesByCsvRequestForInformationResponseTypeIds[$request_for_information_response_type_id] = $requestForInformationResponseType;
		}

		$db->free_result();

		return $arrRequestForInformationResponseTypesByCsvRequestForInformationResponseTypeIds;
	}

	// Loaders: Load By Foreign Key

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all request_for_information_response_types records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllRequestForInformationResponseTypes($database, Input $options=null)
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
			self::$_arrAllRequestForInformationResponseTypes = null;
		}

		$arrAllRequestForInformationResponseTypes = self::$_arrAllRequestForInformationResponseTypes;
		if (isset($arrAllRequestForInformationResponseTypes) && !empty($arrAllRequestForInformationResponseTypes)) {
			return $arrAllRequestForInformationResponseTypes;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `request_for_information_response_type` ASC, `disabled_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpRequestForInformationResponseType = new RequestForInformationResponseType($database);
			$sqlOrderByColumns = $tmpRequestForInformationResponseType->constructSqlOrderByColumns($arrOrderByAttributes);

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
	rfirt.*

FROM `request_for_information_response_types` rfirt{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `request_for_information_response_type` ASC, `disabled_flag` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllRequestForInformationResponseTypes = array();
		while ($row = $db->fetch()) {
			$request_for_information_response_type_id = $row['id'];
			$requestForInformationResponseType = self::instantiateOrm($database, 'RequestForInformationResponseType', $row, null, $request_for_information_response_type_id);
			/* @var $requestForInformationResponseType RequestForInformationResponseType */
			$arrAllRequestForInformationResponseTypes[$request_for_information_response_type_id] = $requestForInformationResponseType;
		}

		$db->free_result();

		self::$_arrAllRequestForInformationResponseTypes = $arrAllRequestForInformationResponseTypes;

		return $arrAllRequestForInformationResponseTypes;
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
INTO `request_for_information_response_types`
(`request_for_information_response_type`, `disabled_flag`)
VALUES (?, ?)
ON DUPLICATE KEY UPDATE `disabled_flag` = ?
";
		$arrValues = array($this->request_for_information_response_type, $this->disabled_flag, $this->disabled_flag);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$request_for_information_response_type_id = $db->insertId;
		$db->free_result();

		return $request_for_information_response_type_id;
	}

	// Save: insert ignore
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

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
 * SubmittalResponseType.
 *
 * @category   Framework
 * @package    SubmittalResponseType
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class SubmittalResponseType extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'SubmittalResponseType';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'submittal_response_types';

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
	 * unique index `unique_submittal_response_type` (`submittal_response_type`) comment 'Submittal Response Types transcend user_companies so user_company_id is not needed.'
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_submittal_response_type' => array(
			'submittal_response_type' => 'string'
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
		'id' => 'submittal_response_type_id',

		'submittal_response_type' => 'submittal_response_type',

		'disabled_flag' => 'disabled_flag'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $submittal_response_type_id;

	public $submittal_response_type;

	public $disabled_flag;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties
	public $escaped_submittal_response_type;

	// HTML ENTITY ENCODED NL2BR ORM string properties
	public $escaped_submittal_response_type_nl2br;

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllSubmittalResponseTypes;

	// Foreign Key Objects

	/**
	 * Constructor
	 */
	public function __construct($database, $table='submittal_response_types')
	{
		parent::__construct($table);
		$this->setDatabase($database);
	}

	// Foreign Key Object Accessor Methods

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllSubmittalResponseTypes()
	{
		if (isset(self::$_arrAllSubmittalResponseTypes)) {
			return self::$_arrAllSubmittalResponseTypes;
		} else {
			return null;
		}
	}

	public static function setArrAllSubmittalResponseTypes($arrAllSubmittalResponseTypes)
	{
		self::$_arrAllSubmittalResponseTypes = $arrAllSubmittalResponseTypes;
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
	 * @param int $submittal_response_type_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findById($database, $submittal_response_type_id,$table='submittal_response_types', $module='SubmittalResponseType')
	{
		$submittalResponseType = parent::findById($database, $submittal_response_type_id,  $table, $module);

		return $submittalResponseType;
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Similar to FindById, but with SQL as starter code for more complex joins.
	 *
	 * @param string $database
	 * @param int $submittal_response_type_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findSubmittalResponseTypeByIdExtended($database, $submittal_response_type_id)
	{
		$submittal_response_type_id = (int) $submittal_response_type_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	surt.*

FROM `submittal_response_types` surt
WHERE surt.`id` = ?
";
		$arrValues = array($submittal_response_type_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$submittal_response_type_id = $row['id'];
			$submittalResponseType = self::instantiateOrm($database, 'SubmittalResponseType', $row, null, $submittal_response_type_id);
			/* @var $submittalResponseType SubmittalResponseType */
			$submittalResponseType->convertPropertiesToData();

			return $submittalResponseType;
		} else {
			return false;
		}
	}

	// Finders: Find By Unique Index
	/**
	 * Find by unique index `unique_submittal_response_type` (`submittal_response_type`) comment 'Submittal Response Types transcend user_companies so user_company_id is not needed.'.
	 *
	 * @param string $database
	 * @param string $submittal_response_type
	 * @return mixed (single ORM object | false)
	 */
	public static function findBySubmittalResponseType($database, $submittal_response_type)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	surt.*

FROM `submittal_response_types` surt
WHERE surt.`submittal_response_type` = ?
";
		$arrValues = array($submittal_response_type);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if ($row && !empty($row)) {
			$submittal_response_type_id = $row['id'];
			$submittalResponseType = self::instantiateOrm($database, 'SubmittalResponseType', $row, null, $submittal_response_type_id);
			/* @var $submittalResponseType SubmittalResponseType */
			return $submittalResponseType;
		} else {
			return false;
		}
	}

	// Loaders: Load By pk List (list of auto int ids or other non auto int pk list)
	/**
	 * Load zero or more records by an id list (array of auto int primary keys).
	 *
	 * @param string $database
	 * @param array $arrSubmittalResponseTypeIds
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubmittalResponseTypesByArrSubmittalResponseTypeIds($database, $arrSubmittalResponseTypeIds, Input $options=null)
	{
		if (empty($arrSubmittalResponseTypeIds)) {
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
		// ORDER BY `id` ASC, `submittal_response_type` ASC, `disabled_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubmittalResponseType = new SubmittalResponseType($database);
			$sqlOrderByColumns = $tmpSubmittalResponseType->constructSqlOrderByColumns($arrOrderByAttributes);

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

		foreach ($arrSubmittalResponseTypeIds as $k => $submittal_response_type_id) {
			$submittal_response_type_id = (int) $submittal_response_type_id;
			$arrSubmittalResponseTypeIds[$k] = $db->escape($submittal_response_type_id);
		}
		$csvSubmittalResponseTypeIds = join(',', $arrSubmittalResponseTypeIds);

		$query =
"
SELECT

	surt.*

FROM `submittal_response_types` surt
WHERE surt.`id` IN ($csvSubmittalResponseTypeIds){$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		$arrSubmittalResponseTypesByCsvSubmittalResponseTypeIds = array();
		while ($row = $db->fetch()) {
			$submittal_response_type_id = $row['id'];
			$submittalResponseType = self::instantiateOrm($database, 'SubmittalResponseType', $row, null, $submittal_response_type_id);
			/* @var $submittalResponseType SubmittalResponseType */
			$submittalResponseType->convertPropertiesToData();

			$arrSubmittalResponseTypesByCsvSubmittalResponseTypeIds[$submittal_response_type_id] = $submittalResponseType;
		}

		$db->free_result();

		return $arrSubmittalResponseTypesByCsvSubmittalResponseTypeIds;
	}

	// Loaders: Load By Foreign Key

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all submittal_response_types records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllSubmittalResponseTypes($database, Input $options=null)
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
			self::$_arrAllSubmittalResponseTypes = null;
		}

		$arrAllSubmittalResponseTypes = self::$_arrAllSubmittalResponseTypes;
		if (isset($arrAllSubmittalResponseTypes) && !empty($arrAllSubmittalResponseTypes)) {
			return $arrAllSubmittalResponseTypes;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `submittal_response_type` ASC, `disabled_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubmittalResponseType = new SubmittalResponseType($database);
			$sqlOrderByColumns = $tmpSubmittalResponseType->constructSqlOrderByColumns($arrOrderByAttributes);

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
	surt.*

FROM `submittal_response_types` surt{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `submittal_response_type` ASC, `disabled_flag` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllSubmittalResponseTypes = array();
		while ($row = $db->fetch()) {
			$submittal_response_type_id = $row['id'];
			$submittalResponseType = self::instantiateOrm($database, 'SubmittalResponseType', $row, null, $submittal_response_type_id);
			/* @var $submittalResponseType SubmittalResponseType */
			$arrAllSubmittalResponseTypes[$submittal_response_type_id] = $submittalResponseType;
		}

		$db->free_result();

		self::$_arrAllSubmittalResponseTypes = $arrAllSubmittalResponseTypes;

		return $arrAllSubmittalResponseTypes;
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
INTO `submittal_response_types`
(`submittal_response_type`, `disabled_flag`)
VALUES (?, ?)
ON DUPLICATE KEY UPDATE `disabled_flag` = ?
";
		$arrValues = array($this->submittal_response_type, $this->disabled_flag, $this->disabled_flag);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$submittal_response_type_id = $db->insertId;
		$db->free_result();

		return $submittal_response_type_id;
	}

	// Save: insert ignore
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

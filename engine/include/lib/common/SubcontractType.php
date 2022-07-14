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
 * SubcontractType.
 *
 * @category   Framework
 * @package    SubcontractType
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class SubcontractType extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'SubcontractType';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'subcontract_types';

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
	 * unique index `unique_subcontract_type` (`subcontract_type`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_subcontract_type' => array(
			'subcontract_type' => 'string'
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
		'id' => 'subcontract_type_id',

		'subcontract_type' => 'subcontract_type',

		'disabled_flag' => 'disabled_flag'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $subcontract_type_id;

	public $subcontract_type;

	public $disabled_flag;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties
	public $escaped_subcontract_type;

	// HTML ENTITY ENCODED NL2BR ORM string properties
	public $escaped_subcontract_type_nl2br;

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllSubcontractTypes;

	// Foreign Key Objects

	/**
	 * Constructor
	 */
	public function __construct($database, $table='subcontract_types')
	{
		parent::__construct($table);
		$this->setDatabase($database);
	}

	// Foreign Key Object Accessor Methods

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllSubcontractTypes()
	{
		if (isset(self::$_arrAllSubcontractTypes)) {
			return self::$_arrAllSubcontractTypes;
		} else {
			return null;
		}
	}

	public static function setArrAllSubcontractTypes($arrAllSubcontractTypes)
	{
		self::$_arrAllSubcontractTypes = $arrAllSubcontractTypes;
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
	 * @param int $subcontract_type_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findById($database, $subcontract_type_id,$table='subcontract_types', $module='SubcontractType')
	{
		$subcontractType = parent::findById($database, $subcontract_type_id,$table, $module);

		return $subcontractType;
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Similar to FindById, but with SQL as starter code for more complex joins.
	 *
	 * @param string $database
	 * @param int $subcontract_type_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findSubcontractTypeByIdExtended($database, $subcontract_type_id)
	{
		$subcontract_type_id = (int) $subcontract_type_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	stypes.*

FROM `subcontract_types` stypes
WHERE stypes.`id` = ?
";
		$arrValues = array($subcontract_type_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$subcontract_type_id = $row['id'];
			$subcontractType = self::instantiateOrm($database, 'SubcontractType', $row, null, $subcontract_type_id);
			/* @var $subcontractType SubcontractType */
			$subcontractType->convertPropertiesToData();

			return $subcontractType;
		} else {
			return false;
		}
	}

	// Finders: Find By Unique Index
	/**
	 * Find by unique index `unique_subcontract_type` (`subcontract_type`).
	 *
	 * @param string $database
	 * @param string $subcontract_type
	 * @return mixed (single ORM object | false)
	 */
	public static function findBySubcontractType($database, $subcontract_type)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	stypes.*

FROM `subcontract_types` stypes
WHERE stypes.`subcontract_type` = ?
";
		$arrValues = array($subcontract_type);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if ($row && !empty($row)) {
			$subcontract_type_id = $row['id'];
			$subcontractType = self::instantiateOrm($database, 'SubcontractType', $row, null, $subcontract_type_id);
			/* @var $subcontractType SubcontractType */
			return $subcontractType;
		} else {
			return false;
		}
	}

	// Loaders: Load By pk List (list of auto int ids or other non auto int pk list)
	/**
	 * Load zero or more records by an id list (array of auto int primary keys).
	 *
	 * @param string $database
	 * @param array $arrSubcontractTypeIds
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubcontractTypesByArrSubcontractTypeIds($database, $arrSubcontractTypeIds, Input $options=null)
	{
		if (empty($arrSubcontractTypeIds)) {
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
		// ORDER BY `id` ASC, `subcontract_type` ASC, `disabled_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubcontractType = new SubcontractType($database);
			$sqlOrderByColumns = $tmpSubcontractType->constructSqlOrderByColumns($arrOrderByAttributes);

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

		foreach ($arrSubcontractTypeIds as $k => $subcontract_type_id) {
			$subcontract_type_id = (int) $subcontract_type_id;
			$arrSubcontractTypeIds[$k] = $db->escape($subcontract_type_id);
		}
		$csvSubcontractTypeIds = join(',', $arrSubcontractTypeIds);

		$query =
"
SELECT

	stypes.*

FROM `subcontract_types` stypes
WHERE stypes.`id` IN ($csvSubcontractTypeIds){$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		$arrSubcontractTypesByCsvSubcontractTypeIds = array();
		while ($row = $db->fetch()) {
			$subcontract_type_id = $row['id'];
			$subcontractType = self::instantiateOrm($database, 'SubcontractType', $row, null, $subcontract_type_id);
			/* @var $subcontractType SubcontractType */
			$subcontractType->convertPropertiesToData();

			$arrSubcontractTypesByCsvSubcontractTypeIds[$subcontract_type_id] = $subcontractType;
		}

		$db->free_result();

		return $arrSubcontractTypesByCsvSubcontractTypeIds;
	}

	// Loaders: Load By Foreign Key

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all subcontract_types records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllSubcontractTypes($database, Input $options=null)
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
			self::$_arrAllSubcontractTypes = null;
		}

		$arrAllSubcontractTypes = self::$_arrAllSubcontractTypes;
		if (isset($arrAllSubcontractTypes) && !empty($arrAllSubcontractTypes)) {
			return $arrAllSubcontractTypes;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `subcontract_type` ASC, `disabled_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubcontractType = new SubcontractType($database);
			$sqlOrderByColumns = $tmpSubcontractType->constructSqlOrderByColumns($arrOrderByAttributes);

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

		$query = 	"SELECT
						stypes.*
					FROM `subcontract_types` stypes WHERE `disabled_flag` = 'N' {$sqlOrderBy}{$sqlLimit}";

		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllSubcontractTypes = array();
		while ($row = $db->fetch()) {
			$subcontract_type_id = $row['id'];
			$subcontractType = self::instantiateOrm($database, 'SubcontractType', $row, null, $subcontract_type_id);
			/* @var $subcontractType SubcontractType */
			$arrAllSubcontractTypes[$subcontract_type_id] = $subcontractType;
		}

		$db->free_result();

		self::$_arrAllSubcontractTypes = $arrAllSubcontractTypes;

		return $arrAllSubcontractTypes;
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
INTO `subcontract_types`
(`subcontract_type`, `disabled_flag`)
VALUES (?, ?)
ON DUPLICATE KEY UPDATE `disabled_flag` = ?
";
		$arrValues = array($this->subcontract_type, $this->disabled_flag, $this->disabled_flag);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$subcontract_type_id = $db->insertId;
		$db->free_result();

		return $subcontract_type_id;
	}

	// Save: insert ignore
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

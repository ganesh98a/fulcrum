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
 * SoftwareModuleFunctionRelationship.
 *
 * @category   Framework
 * @package    SoftwareModuleFunctionRelationship
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class SoftwareModuleFunctionRelationship extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'SoftwareModuleFunctionRelationship';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'software_module_function_relationships';

	/**
	 * primary key (`software_module_function_id`,`prerequisite_software_module_function_id`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrPrimaryKey = array(
		'software_module_function_id' => 'int',
		'prerequisite_software_module_function_id' => 'int'
	);

	/**
	 * No Unique Indexes, Just a Primary Key
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_software_module_function_relationship_via_primary_key' => array(
			'software_module_function_id' => 'int',
			'prerequisite_software_module_function_id' => 'int'
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
		'software_module_function_id' => 'software_module_function_id',
		'prerequisite_software_module_function_id' => 'prerequisite_software_module_function_id'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $software_module_function_id;
	public $prerequisite_software_module_function_id;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties

	// HTML ENTITY ENCODED NL2BR ORM string properties

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)
	protected static $_arrSoftwareModuleFunctionRelationshipsBySoftwareModuleFunctionId;

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllSoftwareModuleFunctionRelationships;

	// Foreign Key Objects

	/**
	 * Constructor
	 */
	public function __construct($database, $table='software_module_function_relationships')
	{
		parent::__construct($table);
		$this->setDatabase($database);
	}

	// Foreign Key Object Accessor Methods

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)
	public static function getArrSoftwareModuleFunctionRelationshipsBySoftwareModuleFunctionId()
	{
		if (isset(self::$_arrSoftwareModuleFunctionRelationshipsBySoftwareModuleFunctionId)) {
			return self::$_arrSoftwareModuleFunctionRelationshipsBySoftwareModuleFunctionId;
		} else {
			return null;
		}
	}

	public static function setArrSoftwareModuleFunctionRelationshipsBySoftwareModuleFunctionId($arrSoftwareModuleFunctionRelationshipsBySoftwareModuleFunctionId)
	{
		self::$_arrSoftwareModuleFunctionRelationshipsBySoftwareModuleFunctionId = $arrSoftwareModuleFunctionRelationshipsBySoftwareModuleFunctionId;
	}

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllSoftwareModuleFunctionRelationships()
	{
		if (isset(self::$_arrAllSoftwareModuleFunctionRelationships)) {
			return self::$_arrAllSoftwareModuleFunctionRelationships;
		} else {
			return null;
		}
	}

	public static function setArrAllSoftwareModuleFunctionRelationships($arrAllSoftwareModuleFunctionRelationships)
	{
		self::$_arrAllSoftwareModuleFunctionRelationships = $arrAllSoftwareModuleFunctionRelationships;
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
	 * Find by primary key (`software_module_function_id`,`prerequisite_software_module_function_id`).
	 *
	 * @param string $database
	 * @param int $software_module_function_id
	 * @param int $prerequisite_software_module_function_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findBySoftwareModuleFunctionIdAndPrerequisiteSoftwareModuleFunctionId($database, $software_module_function_id, $prerequisite_software_module_function_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	smfr.*

FROM `software_module_function_relationships` smfr
WHERE smfr.`software_module_function_id` = ?
AND smfr.`prerequisite_software_module_function_id` = ?
";
		$arrValues = array($software_module_function_id, $prerequisite_software_module_function_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row && !empty($row)) {
			$softwareModuleFunctionRelationship = self::instantiateOrm($database, 'SoftwareModuleFunctionRelationship', $row);
			/* @var $softwareModuleFunctionRelationship SoftwareModuleFunctionRelationship */
			return $softwareModuleFunctionRelationship;
		} else {
			return false;
		}
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)

	// Finders: Find By Unique Index

	// Loaders: Load By pk List (list of auto int ids or other non auto int pk list)---find_replace_load_records_by_pk_list_method---

	// Loaders: Load By Foreign Key

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute
	/**
	 * Load by leftmost indexed attribute: primary key (`software_module_function_id`,`prerequisite_software_module_function_id`).
	 *
	 * @param string $database
	 * @param int $software_module_function_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSoftwareModuleFunctionRelationshipsBySoftwareModuleFunctionId($database, $software_module_function_id, Input $options=null)
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
			self::$_arrSoftwareModuleFunctionRelationshipsBySoftwareModuleFunctionId = null;
		}

		$arrSoftwareModuleFunctionRelationshipsBySoftwareModuleFunctionId = self::$_arrSoftwareModuleFunctionRelationshipsBySoftwareModuleFunctionId;
		if (isset($arrSoftwareModuleFunctionRelationshipsBySoftwareModuleFunctionId) && !empty($arrSoftwareModuleFunctionRelationshipsBySoftwareModuleFunctionId)) {
			return $arrSoftwareModuleFunctionRelationshipsBySoftwareModuleFunctionId;
		}

		$software_module_function_id = (int) $software_module_function_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `software_module_function_id` ASC, `prerequisite_software_module_function_id` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSoftwareModuleFunctionRelationship = new SoftwareModuleFunctionRelationship($database);
			$sqlOrderByColumns = $tmpSoftwareModuleFunctionRelationship->constructSqlOrderByColumns($arrOrderByAttributes);

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
	smfr.*

FROM `software_module_function_relationships` smfr
WHERE smfr.`software_module_function_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `software_module_function_id` ASC, `prerequisite_software_module_function_id` ASC
		$arrValues = array($software_module_function_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSoftwareModuleFunctionRelationshipsBySoftwareModuleFunctionId = array();
		while ($row = $db->fetch()) {
			$softwareModuleFunctionRelationship = self::instantiateOrm($database, 'SoftwareModuleFunctionRelationship', $row);
			/* @var $softwareModuleFunctionRelationship SoftwareModuleFunctionRelationship */
			$arrSoftwareModuleFunctionRelationshipsBySoftwareModuleFunctionId[] = $softwareModuleFunctionRelationship;
		}

		$db->free_result();

		self::$_arrSoftwareModuleFunctionRelationshipsBySoftwareModuleFunctionId = $arrSoftwareModuleFunctionRelationshipsBySoftwareModuleFunctionId;

		return $arrSoftwareModuleFunctionRelationshipsBySoftwareModuleFunctionId;
	}

	// Loaders: Load All Records
	/**
	 * Load all software_module_function_relationships records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllSoftwareModuleFunctionRelationships($database, Input $options=null)
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
			self::$_arrAllSoftwareModuleFunctionRelationships = null;
		}

		$arrAllSoftwareModuleFunctionRelationships = self::$_arrAllSoftwareModuleFunctionRelationships;
		if (isset($arrAllSoftwareModuleFunctionRelationships) && !empty($arrAllSoftwareModuleFunctionRelationships)) {
			return $arrAllSoftwareModuleFunctionRelationships;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `software_module_function_id` ASC, `prerequisite_software_module_function_id` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSoftwareModuleFunctionRelationship = new SoftwareModuleFunctionRelationship($database);
			$sqlOrderByColumns = $tmpSoftwareModuleFunctionRelationship->constructSqlOrderByColumns($arrOrderByAttributes);

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
	smfr.*

FROM `software_module_function_relationships` smfr{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `software_module_function_id` ASC, `prerequisite_software_module_function_id` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllSoftwareModuleFunctionRelationships = array();
		while ($row = $db->fetch()) {
			$softwareModuleFunctionRelationship = self::instantiateOrm($database, 'SoftwareModuleFunctionRelationship', $row);
			/* @var $softwareModuleFunctionRelationship SoftwareModuleFunctionRelationship */
			$arrAllSoftwareModuleFunctionRelationships[] = $softwareModuleFunctionRelationship;
		}

		$db->free_result();

		self::$_arrAllSoftwareModuleFunctionRelationships = $arrAllSoftwareModuleFunctionRelationships;

		return $arrAllSoftwareModuleFunctionRelationships;
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
INTO `software_module_function_relationships`
(`software_module_function_id`, `prerequisite_software_module_function_id`)
VALUES (?, ?)
";
		$arrValues = array($this->software_module_function_id, $this->prerequisite_software_module_function_id);
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

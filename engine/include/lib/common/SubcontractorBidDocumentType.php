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
 * SubcontractorBidDocumentType.
 *
 * @category   Framework
 * @package    SubcontractorBidDocumentType
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class SubcontractorBidDocumentType extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'SubcontractorBidDocumentType';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'subcontractor_bid_document_types';

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
	 * unique index `unique_subcontractor_bid_document_type` (`subcontractor_bid_document_type`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_subcontractor_bid_document_type' => array(
			'subcontractor_bid_document_type' => 'string'
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
		'id' => 'subcontractor_bid_document_type_id',

		'subcontractor_bid_document_type' => 'subcontractor_bid_document_type',

		'subcontractor_bid_document_type_abbreviation' => 'subcontractor_bid_document_type_abbreviation',
		'created' => 'created',
		'sort_order' => 'sort_order'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $subcontractor_bid_document_type_id;

	public $subcontractor_bid_document_type;

	public $subcontractor_bid_document_type_abbreviation;
	public $created;
	public $sort_order;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties
	public $escaped_subcontractor_bid_document_type;
	public $escaped_subcontractor_bid_document_type_abbreviation;

	// HTML ENTITY ENCODED NL2BR ORM string properties
	public $escaped_subcontractor_bid_document_type_nl2br;
	public $escaped_subcontractor_bid_document_type_abbreviation_nl2br;

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllSubcontractorBidDocumentTypes;

	// Foreign Key Objects

	/**
	 * Constructor
	 */
	public function __construct($database, $table='subcontractor_bid_document_types')
	{
		parent::__construct($table);
		$this->setDatabase($database);
	}

	// Foreign Key Object Accessor Methods

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllSubcontractorBidDocumentTypes()
	{
		if (isset(self::$_arrAllSubcontractorBidDocumentTypes)) {
			return self::$_arrAllSubcontractorBidDocumentTypes;
		} else {
			return null;
		}
	}

	public static function setArrAllSubcontractorBidDocumentTypes($arrAllSubcontractorBidDocumentTypes)
	{
		self::$_arrAllSubcontractorBidDocumentTypes = $arrAllSubcontractorBidDocumentTypes;
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
	 * @param int $subcontractor_bid_document_type_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findById($database, $subcontractor_bid_document_type_id,$table='subcontractor_bid_document_types', $module='SubcontractorBidDocumentType')
	{
		$subcontractorBidDocumentType = parent::findById($database, $subcontractor_bid_document_type_id, $table, $module);

		return $subcontractorBidDocumentType;
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Similar to FindById, but with SQL as starter code for more complex joins.
	 *
	 * @param string $database
	 * @param int $subcontractor_bid_document_type_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findSubcontractorBidDocumentTypeByIdExtended($database, $subcontractor_bid_document_type_id)
	{
		$subcontractor_bid_document_type_id = (int) $subcontractor_bid_document_type_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	sbdt.*

FROM `subcontractor_bid_document_types` sbdt
WHERE sbdt.`id` = ?
";
		$arrValues = array($subcontractor_bid_document_type_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$subcontractor_bid_document_type_id = $row['id'];
			$subcontractorBidDocumentType = self::instantiateOrm($database, 'SubcontractorBidDocumentType', $row, null, $subcontractor_bid_document_type_id);
			/* @var $subcontractorBidDocumentType SubcontractorBidDocumentType */
			$subcontractorBidDocumentType->convertPropertiesToData();

			return $subcontractorBidDocumentType;
		} else {
			return false;
		}
	}

	// Finders: Find By Unique Index
	/**
	 * Find by unique index `unique_subcontractor_bid_document_type` (`subcontractor_bid_document_type`).
	 *
	 * @param string $database
	 * @param string $subcontractor_bid_document_type
	 * @return mixed (single ORM object | false)
	 */
	public static function findBySubcontractorBidDocumentType($database, $subcontractor_bid_document_type)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	sbdt.*

FROM `subcontractor_bid_document_types` sbdt
WHERE sbdt.`subcontractor_bid_document_type` = ?
";
		$arrValues = array($subcontractor_bid_document_type);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if ($row && !empty($row)) {
			$subcontractor_bid_document_type_id = $row['id'];
			$subcontractorBidDocumentType = self::instantiateOrm($database, 'SubcontractorBidDocumentType', $row, null, $subcontractor_bid_document_type_id);
			/* @var $subcontractorBidDocumentType SubcontractorBidDocumentType */
			return $subcontractorBidDocumentType;
		} else {
			return false;
		}
	}

	// Loaders: Load By pk List (list of auto int ids or other non auto int pk list)
	/**
	 * Load zero or more records by an id list (array of auto int primary keys).
	 *
	 * @param string $database
	 * @param array $arrSubcontractorBidDocumentTypeIds
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubcontractorBidDocumentTypesByArrSubcontractorBidDocumentTypeIds($database, $arrSubcontractorBidDocumentTypeIds, Input $options=null)
	{
		if (empty($arrSubcontractorBidDocumentTypeIds)) {
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
		// ORDER BY `id` ASC, `subcontractor_bid_document_type` ASC, `subcontractor_bid_document_type_abbreviation` ASC, `created` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY sbdt.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubcontractorBidDocumentType = new SubcontractorBidDocumentType($database);
			$sqlOrderByColumns = $tmpSubcontractorBidDocumentType->constructSqlOrderByColumns($arrOrderByAttributes);

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

		foreach ($arrSubcontractorBidDocumentTypeIds as $k => $subcontractor_bid_document_type_id) {
			$subcontractor_bid_document_type_id = (int) $subcontractor_bid_document_type_id;
			$arrSubcontractorBidDocumentTypeIds[$k] = $db->escape($subcontractor_bid_document_type_id);
		}
		$csvSubcontractorBidDocumentTypeIds = join(',', $arrSubcontractorBidDocumentTypeIds);

		$query =
"
SELECT

	sbdt.*

FROM `subcontractor_bid_document_types` sbdt
WHERE sbdt.`id` IN ($csvSubcontractorBidDocumentTypeIds){$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		$arrSubcontractorBidDocumentTypesByCsvSubcontractorBidDocumentTypeIds = array();
		while ($row = $db->fetch()) {
			$subcontractor_bid_document_type_id = $row['id'];
			$subcontractorBidDocumentType = self::instantiateOrm($database, 'SubcontractorBidDocumentType', $row, null, $subcontractor_bid_document_type_id);
			/* @var $subcontractorBidDocumentType SubcontractorBidDocumentType */
			$subcontractorBidDocumentType->convertPropertiesToData();

			$arrSubcontractorBidDocumentTypesByCsvSubcontractorBidDocumentTypeIds[$subcontractor_bid_document_type_id] = $subcontractorBidDocumentType;
		}

		$db->free_result();

		return $arrSubcontractorBidDocumentTypesByCsvSubcontractorBidDocumentTypeIds;
	}

	// Loaders: Load By Foreign Key

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all subcontractor_bid_document_types records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllSubcontractorBidDocumentTypes($database, Input $options=null)
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
			self::$_arrAllSubcontractorBidDocumentTypes = null;
		}

		$arrAllSubcontractorBidDocumentTypes = self::$_arrAllSubcontractorBidDocumentTypes;
		if (isset($arrAllSubcontractorBidDocumentTypes) && !empty($arrAllSubcontractorBidDocumentTypes)) {
			return $arrAllSubcontractorBidDocumentTypes;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `subcontractor_bid_document_type` ASC, `subcontractor_bid_document_type_abbreviation` ASC, `created` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY sbdt.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubcontractorBidDocumentType = new SubcontractorBidDocumentType($database);
			$sqlOrderByColumns = $tmpSubcontractorBidDocumentType->constructSqlOrderByColumns($arrOrderByAttributes);

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
	sbdt.*

FROM `subcontractor_bid_document_types` sbdt{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `subcontractor_bid_document_type` ASC, `subcontractor_bid_document_type_abbreviation` ASC, `created` ASC, `sort_order` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllSubcontractorBidDocumentTypes = array();
		while ($row = $db->fetch()) {
			$subcontractor_bid_document_type_id = $row['id'];
			$subcontractorBidDocumentType = self::instantiateOrm($database, 'SubcontractorBidDocumentType', $row, null, $subcontractor_bid_document_type_id);
			/* @var $subcontractorBidDocumentType SubcontractorBidDocumentType */
			$arrAllSubcontractorBidDocumentTypes[$subcontractor_bid_document_type_id] = $subcontractorBidDocumentType;
		}

		$db->free_result();

		self::$_arrAllSubcontractorBidDocumentTypes = $arrAllSubcontractorBidDocumentTypes;

		return $arrAllSubcontractorBidDocumentTypes;
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
INTO `subcontractor_bid_document_types`
(`subcontractor_bid_document_type`, `subcontractor_bid_document_type_abbreviation`, `created`, `sort_order`)
VALUES (?, ?, ?, ?)
ON DUPLICATE KEY UPDATE `subcontractor_bid_document_type_abbreviation` = ?, `created` = ?, `sort_order` = ?
";
		$arrValues = array($this->subcontractor_bid_document_type, $this->subcontractor_bid_document_type_abbreviation, $this->created, $this->sort_order, $this->subcontractor_bid_document_type_abbreviation, $this->created, $this->sort_order);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$subcontractor_bid_document_type_id = $db->insertId;
		$db->free_result();

		return $subcontractor_bid_document_type_id;
	}

	// Save: insert ignore
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

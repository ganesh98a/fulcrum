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
 * WeatherUndergroundConditionLabel.
 *
 * @category   Framework
 * @package    WeatherUndergroundConditionLabel
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class WeatherUndergroundConditionLabel extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'WeatherUndergroundConditionLabel';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'weather_underground_condition_labels';

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
	 * unique index `unique_weather_condition_label` (`weather_condition_label`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_weather_condition_label' => array(
			'weather_condition_label' => 'string'
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
		'id' => 'weather_underground_condition_label_id',

		'weather_condition_label' => 'weather_condition_label',

		'sort_order' => 'sort_order'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $weather_underground_condition_label_id;

	public $weather_condition_label;

	public $sort_order;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties
	public $escaped_weather_condition_label;

	// HTML ENTITY ENCODED NL2BR ORM string properties
	public $escaped_weather_condition_label_nl2br;

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllWeatherUndergroundConditionLabels;

	// Foreign Key Objects

	/**
	 * Constructor
	 */
	public function __construct($database, $table='weather_underground_condition_labels')
	{
		parent::__construct($table);
		$this->setDatabase($database);
	}

	// Foreign Key Object Accessor Methods

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllWeatherUndergroundConditionLabels()
	{
		if (isset(self::$_arrAllWeatherUndergroundConditionLabels)) {
			return self::$_arrAllWeatherUndergroundConditionLabels;
		} else {
			return null;
		}
	}

	public static function setArrAllWeatherUndergroundConditionLabels($arrAllWeatherUndergroundConditionLabels)
	{
		self::$_arrAllWeatherUndergroundConditionLabels = $arrAllWeatherUndergroundConditionLabels;
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
	 * @param int $weather_underground_condition_label_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findById($database, $weather_underground_condition_label_id,$table='weather_underground_condition_labels', $module='WeatherUndergroundConditionLabel')
	{
		$weatherUndergroundConditionLabel = parent::findById($database, $weather_underground_condition_label_id, $table, $module);

		return $weatherUndergroundConditionLabel;
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Similar to FindById, but with SQL as starter code for more complex joins.
	 *
	 * @param string $database
	 * @param int $weather_underground_condition_label_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findWeatherUndergroundConditionLabelByIdExtended($database, $weather_underground_condition_label_id)
	{
		$weather_underground_condition_label_id = (int) $weather_underground_condition_label_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	wucl.*

FROM `weather_underground_condition_labels` wucl
WHERE wucl.`id` = ?
";
		$arrValues = array($weather_underground_condition_label_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$weather_underground_condition_label_id = $row['id'];
			$weatherUndergroundConditionLabel = self::instantiateOrm($database, 'WeatherUndergroundConditionLabel', $row, null, $weather_underground_condition_label_id);
			/* @var $weatherUndergroundConditionLabel WeatherUndergroundConditionLabel */
			$weatherUndergroundConditionLabel->convertPropertiesToData();

			return $weatherUndergroundConditionLabel;
		} else {
			return false;
		}
	}

	// Finders: Find By Unique Index
	/**
	 * Find by unique index `unique_weather_condition_label` (`weather_condition_label`).
	 *
	 * @param string $database
	 * @param string $weather_condition_label
	 * @return mixed (single ORM object | false)
	 */
	public static function findByWeatherConditionLabel($database, $weather_condition_label)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	wucl.*

FROM `weather_underground_condition_labels` wucl
WHERE wucl.`weather_condition_label` = ?
";
		$arrValues = array($weather_condition_label);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if ($row && !empty($row)) {
			$weather_underground_condition_label_id = $row['id'];
			$weatherUndergroundConditionLabel = self::instantiateOrm($database, 'WeatherUndergroundConditionLabel', $row, null, $weather_underground_condition_label_id);
			/* @var $weatherUndergroundConditionLabel WeatherUndergroundConditionLabel */
			return $weatherUndergroundConditionLabel;
		} else {
			return false;
		}
	}

	// Loaders: Load By pk List (list of auto int ids or other non auto int pk list)
	/**
	 * Load zero or more records by an id list (array of auto int primary keys).
	 *
	 * @param string $database
	 * @param array $arrWeatherUndergroundConditionLabelIds
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadWeatherUndergroundConditionLabelsByArrWeatherUndergroundConditionLabelIds($database, $arrWeatherUndergroundConditionLabelIds, Input $options=null)
	{
		if (empty($arrWeatherUndergroundConditionLabelIds)) {
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
		// ORDER BY `id` ASC, `weather_condition_label` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY wucl.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpWeatherUndergroundConditionLabel = new WeatherUndergroundConditionLabel($database);
			$sqlOrderByColumns = $tmpWeatherUndergroundConditionLabel->constructSqlOrderByColumns($arrOrderByAttributes);

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

		foreach ($arrWeatherUndergroundConditionLabelIds as $k => $weather_underground_condition_label_id) {
			$weather_underground_condition_label_id = (int) $weather_underground_condition_label_id;
			$arrWeatherUndergroundConditionLabelIds[$k] = $db->escape($weather_underground_condition_label_id);
		}
		$csvWeatherUndergroundConditionLabelIds = join(',', $arrWeatherUndergroundConditionLabelIds);

		$query =
"
SELECT

	wucl.*

FROM `weather_underground_condition_labels` wucl
WHERE wucl.`id` IN ($csvWeatherUndergroundConditionLabelIds){$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		$arrWeatherUndergroundConditionLabelsByCsvWeatherUndergroundConditionLabelIds = array();
		while ($row = $db->fetch()) {
			$weather_underground_condition_label_id = $row['id'];
			$weatherUndergroundConditionLabel = self::instantiateOrm($database, 'WeatherUndergroundConditionLabel', $row, null, $weather_underground_condition_label_id);
			/* @var $weatherUndergroundConditionLabel WeatherUndergroundConditionLabel */
			$weatherUndergroundConditionLabel->convertPropertiesToData();

			$arrWeatherUndergroundConditionLabelsByCsvWeatherUndergroundConditionLabelIds[$weather_underground_condition_label_id] = $weatherUndergroundConditionLabel;
		}

		$db->free_result();

		return $arrWeatherUndergroundConditionLabelsByCsvWeatherUndergroundConditionLabelIds;
	}

	// Loaders: Load By Foreign Key

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all weather_underground_condition_labels records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllWeatherUndergroundConditionLabels($database, Input $options=null)
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
			self::$_arrAllWeatherUndergroundConditionLabels = null;
		}

		$arrAllWeatherUndergroundConditionLabels = self::$_arrAllWeatherUndergroundConditionLabels;
		if (isset($arrAllWeatherUndergroundConditionLabels) && !empty($arrAllWeatherUndergroundConditionLabels)) {
			return $arrAllWeatherUndergroundConditionLabels;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `weather_condition_label` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY wucl.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpWeatherUndergroundConditionLabel = new WeatherUndergroundConditionLabel($database);
			$sqlOrderByColumns = $tmpWeatherUndergroundConditionLabel->constructSqlOrderByColumns($arrOrderByAttributes);

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
	wucl.*

FROM `weather_underground_condition_labels` wucl{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `weather_condition_label` ASC, `sort_order` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllWeatherUndergroundConditionLabels = array();
		while ($row = $db->fetch()) {
			$weather_underground_condition_label_id = $row['id'];
			$weatherUndergroundConditionLabel = self::instantiateOrm($database, 'WeatherUndergroundConditionLabel', $row, null, $weather_underground_condition_label_id);
			/* @var $weatherUndergroundConditionLabel WeatherUndergroundConditionLabel */
			$arrAllWeatherUndergroundConditionLabels[$weather_underground_condition_label_id] = $weatherUndergroundConditionLabel;
		}

		$db->free_result();

		self::$_arrAllWeatherUndergroundConditionLabels = $arrAllWeatherUndergroundConditionLabels;

		return $arrAllWeatherUndergroundConditionLabels;
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
INTO `weather_underground_condition_labels`
(`weather_condition_label`, `sort_order`)
VALUES (?, ?)
ON DUPLICATE KEY UPDATE `sort_order` = ?
";
		$arrValues = array($this->weather_condition_label, $this->sort_order, $this->sort_order);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$weather_underground_condition_label_id = $db->insertId;
		$db->free_result();

		return $weather_underground_condition_label_id;
	}

	// Save: insert ignore
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

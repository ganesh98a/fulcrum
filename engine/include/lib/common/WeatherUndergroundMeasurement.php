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
 * WeatherUndergroundMeasurement.
 *
 * @category   Framework
 * @package    WeatherUndergroundMeasurement
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class WeatherUndergroundMeasurement extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'WeatherUndergroundMeasurement';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'weather_underground_measurements';

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
	 * unique index `unique_weather_underground_measurement` (`weather_underground_reporting_station_id`,`created`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_weather_underground_measurement' => array(
			'weather_underground_reporting_station_id' => 'int',
			'created' => 'string'
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
		'id' => 'weather_underground_measurement_id',

		'weather_underground_reporting_station_id' => 'weather_underground_reporting_station_id',
		'weather_underground_condition_label_id' => 'weather_underground_condition_label_id',

		'created' => 'created',

		'temperature' => 'temperature'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $weather_underground_measurement_id;

	public $weather_underground_reporting_station_id;
	public $weather_underground_condition_label_id;

	public $created;

	public $temperature;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties

	// HTML ENTITY ENCODED NL2BR ORM string properties

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)
	protected static $_arrWeatherUndergroundMeasurementsByWeatherUndergroundReportingStationId;
	protected static $_arrWeatherUndergroundMeasurementsByWeatherUndergroundConditionLabelId;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)
	protected static $_arrWeatherUndergroundMeasurementsByCreated;

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllWeatherUndergroundMeasurements;
	//protected static $_arrWeatherUndergroundMeasurementsByProjectIdAndTimeRange;

	// Foreign Key Objects
	private $_weatherUndergroundReportingStation;
	private $_weatherUndergroundConditionLabel;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='weather_underground_measurements')
	{
		parent::__construct($table);
		$this->setDatabase($database);
	}

	// Foreign Key Object Accessor Methods
	public function getWeatherUndergroundReportingStation()
	{
		if (isset($this->_weatherUndergroundReportingStation)) {
			return $this->_weatherUndergroundReportingStation;
		} else {
			return null;
		}
	}

	public function setWeatherUndergroundReportingStation($weatherUndergroundReportingStation)
	{
		$this->_weatherUndergroundReportingStation = $weatherUndergroundReportingStation;
	}

	public function getWeatherUndergroundConditionLabel()
	{
		if (isset($this->_weatherUndergroundConditionLabel)) {
			return $this->_weatherUndergroundConditionLabel;
		} else {
			return null;
		}
	}

	public function setWeatherUndergroundConditionLabel($weatherUndergroundConditionLabel)
	{
		$this->_weatherUndergroundConditionLabel = $weatherUndergroundConditionLabel;
	}

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)
	public static function getArrWeatherUndergroundMeasurementsByWeatherUndergroundReportingStationId()
	{
		if (isset(self::$_arrWeatherUndergroundMeasurementsByWeatherUndergroundReportingStationId)) {
			return self::$_arrWeatherUndergroundMeasurementsByWeatherUndergroundReportingStationId;
		} else {
			return null;
		}
	}

	public static function setArrWeatherUndergroundMeasurementsByWeatherUndergroundReportingStationId($arrWeatherUndergroundMeasurementsByWeatherUndergroundReportingStationId)
	{
		self::$_arrWeatherUndergroundMeasurementsByWeatherUndergroundReportingStationId = $arrWeatherUndergroundMeasurementsByWeatherUndergroundReportingStationId;
	}

	public static function getArrWeatherUndergroundMeasurementsByWeatherUndergroundConditionLabelId()
	{
		if (isset(self::$_arrWeatherUndergroundMeasurementsByWeatherUndergroundConditionLabelId)) {
			return self::$_arrWeatherUndergroundMeasurementsByWeatherUndergroundConditionLabelId;
		} else {
			return null;
		}
	}

	public static function setArrWeatherUndergroundMeasurementsByWeatherUndergroundConditionLabelId($arrWeatherUndergroundMeasurementsByWeatherUndergroundConditionLabelId)
	{
		self::$_arrWeatherUndergroundMeasurementsByWeatherUndergroundConditionLabelId = $arrWeatherUndergroundMeasurementsByWeatherUndergroundConditionLabelId;
	}

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)
	public static function getArrWeatherUndergroundMeasurementsByCreated()
	{
		if (isset(self::$_arrWeatherUndergroundMeasurementsByCreated)) {
			return self::$_arrWeatherUndergroundMeasurementsByCreated;
		} else {
			return null;
		}
	}

	public static function setArrWeatherUndergroundMeasurementsByCreated($arrWeatherUndergroundMeasurementsByCreated)
	{
		self::$_arrWeatherUndergroundMeasurementsByCreated = $arrWeatherUndergroundMeasurementsByCreated;
	}

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllWeatherUndergroundMeasurements()
	{
		if (isset(self::$_arrAllWeatherUndergroundMeasurements)) {
			return self::$_arrAllWeatherUndergroundMeasurements;
		} else {
			return null;
		}
	}

	public static function setArrAllWeatherUndergroundMeasurements($arrAllWeatherUndergroundMeasurements)
	{
		self::$_arrAllWeatherUndergroundMeasurements = $arrAllWeatherUndergroundMeasurements;
	}

	/*
	public static function getWeatherUndergroundMeasurementsByProjectIdAndTimeRange()
	{
		if (isset(self::$_arrWeatherUndergroundMeasurementsByProjectIdAndTimeRange)) {
			return self::$_arrWeatherUndergroundMeasurementsByProjectIdAndTimeRange;
		} else {
			return null;
		}
	}

	public static function setWeatherUndergroundMeasurementsByProjectIdAndTimeRange($arrWeatherUndergroundMeasurementsByProjectIdAndTimeRange)
	{
		self::$_arrWeatherUndergroundMeasurementsByProjectIdAndTimeRange = $arrWeatherUndergroundMeasurementsByProjectIdAndTimeRange;
	}
	*/

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
	 * @param int $weather_underground_measurement_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findById($database, $weather_underground_measurement_id,$table='weather_underground_measurements', $module='WeatherUndergroundMeasurement')
	{
		$weatherUndergroundMeasurement = parent::findById($database, $weather_underground_measurement_id, $table, $module);

		return $weatherUndergroundMeasurement;
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Similar to FindById, but with SQL as starter code for more complex joins.
	 *
	 * @param string $database
	 * @param int $weather_underground_measurement_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findWeatherUndergroundMeasurementByIdExtended($database, $weather_underground_measurement_id)
	{
		$weather_underground_measurement_id = (int) $weather_underground_measurement_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	wum_fk_wurs.`id` AS 'wum_fk_wurs__weather_underground_reporting_station_id',
	wum_fk_wurs.`weather_reporting_station` AS 'wum_fk_wurs__weather_reporting_station',
	wum_fk_wurs.`latitude` AS 'wum_fk_wurs__latitude',
	wum_fk_wurs.`longitude` AS 'wum_fk_wurs__longitude',
	wum_fk_wurs.`elevation` AS 'wum_fk_wurs__elevation',
	wum_fk_wurs.`address_city` AS 'wum_fk_wurs__address_city',
	wum_fk_wurs.`address_state_or_region` AS 'wum_fk_wurs__address_state_or_region',
	wum_fk_wurs.`address_country` AS 'wum_fk_wurs__address_country',
	wum_fk_wurs.`sort_order` AS 'wum_fk_wurs__sort_order',

	wum_fk_wucl.`id` AS 'wum_fk_wucl__weather_underground_condition_label_id',
	wum_fk_wucl.`weather_condition_label` AS 'wum_fk_wucl__weather_condition_label',
	wum_fk_wucl.`sort_order` AS 'wum_fk_wucl__sort_order',

	wum.*

FROM `weather_underground_measurements` wum
	INNER JOIN `weather_underground_reporting_stations` wum_fk_wurs ON wum.`weather_underground_reporting_station_id` = wum_fk_wurs.`id`
	INNER JOIN `weather_underground_condition_labels` wum_fk_wucl ON wum.`weather_underground_condition_label_id` = wum_fk_wucl.`id`
WHERE wum.`id` = ?
";
		$arrValues = array($weather_underground_measurement_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$weather_underground_measurement_id = $row['id'];
			$weatherUndergroundMeasurement = self::instantiateOrm($database, 'WeatherUndergroundMeasurement', $row, null, $weather_underground_measurement_id);
			/* @var $weatherUndergroundMeasurement WeatherUndergroundMeasurement */
			$weatherUndergroundMeasurement->convertPropertiesToData();

			if (isset($row['weather_underground_reporting_station_id'])) {
				$weather_underground_reporting_station_id = $row['weather_underground_reporting_station_id'];
				$row['wum_fk_wurs__id'] = $weather_underground_reporting_station_id;
				$weatherUndergroundReportingStation = self::instantiateOrm($database, 'WeatherUndergroundReportingStation', $row, null, $weather_underground_reporting_station_id, 'wum_fk_wurs__');
				/* @var $weatherUndergroundReportingStation WeatherUndergroundReportingStation */
				$weatherUndergroundReportingStation->convertPropertiesToData();
			} else {
				$weatherUndergroundReportingStation = false;
			}
			$weatherUndergroundMeasurement->setWeatherUndergroundReportingStation($weatherUndergroundReportingStation);

			if (isset($row['weather_underground_condition_label_id'])) {
				$weather_underground_condition_label_id = $row['weather_underground_condition_label_id'];
				$row['wum_fk_wucl__id'] = $weather_underground_condition_label_id;
				$weatherUndergroundConditionLabel = self::instantiateOrm($database, 'WeatherUndergroundConditionLabel', $row, null, $weather_underground_condition_label_id, 'wum_fk_wucl__');
				/* @var $weatherUndergroundConditionLabel WeatherUndergroundConditionLabel */
				$weatherUndergroundConditionLabel->convertPropertiesToData();
			} else {
				$weatherUndergroundConditionLabel = false;
			}
			$weatherUndergroundMeasurement->setWeatherUndergroundConditionLabel($weatherUndergroundConditionLabel);

			return $weatherUndergroundMeasurement;
		} else {
			return false;
		}
	}

	// Finders: Find By Unique Index
	/**
	 * Find by unique index `unique_weather_underground_measurement` (`weather_underground_reporting_station_id`,`created`).
	 *
	 * @param string $database
	 * @param int $weather_underground_reporting_station_id
	 * @param string $created
	 * @return mixed (single ORM object | false)
	 */
	public static function findByWeatherUndergroundReportingStationIdAndCreated($database, $weather_underground_reporting_station_id, $created)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	wum.*

FROM `weather_underground_measurements` wum
WHERE wum.`weather_underground_reporting_station_id` = ?
AND wum.`created` = ?
";
		$arrValues = array($weather_underground_reporting_station_id, $created);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if ($row && !empty($row)) {
			$weather_underground_measurement_id = $row['id'];
			$weatherUndergroundMeasurement = self::instantiateOrm($database, 'WeatherUndergroundMeasurement', $row, null, $weather_underground_measurement_id);
			/* @var $weatherUndergroundMeasurement WeatherUndergroundMeasurement */
			return $weatherUndergroundMeasurement;
		} else {
			return false;
		}
	}

	// Loaders: Load By pk List (list of auto int ids or other non auto int pk list)
	/**
	 * Load zero or more records by an id list (array of auto int primary keys).
	 *
	 * @param string $database
	 * @param array $arrWeatherUndergroundMeasurementIds
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadWeatherUndergroundMeasurementsByArrWeatherUndergroundMeasurementIds($database, $arrWeatherUndergroundMeasurementIds, Input $options=null)
	{
		if (empty($arrWeatherUndergroundMeasurementIds)) {
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
		// ORDER BY `id` ASC, `weather_underground_reporting_station_id` ASC, `weather_underground_condition_label_id` ASC, `created` ASC, `temperature` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpWeatherUndergroundMeasurement = new WeatherUndergroundMeasurement($database);
			$sqlOrderByColumns = $tmpWeatherUndergroundMeasurement->constructSqlOrderByColumns($arrOrderByAttributes);

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

		foreach ($arrWeatherUndergroundMeasurementIds as $k => $weather_underground_measurement_id) {
			$weather_underground_measurement_id = (int) $weather_underground_measurement_id;
			$arrWeatherUndergroundMeasurementIds[$k] = $db->escape($weather_underground_measurement_id);
		}
		$csvWeatherUndergroundMeasurementIds = join(',', $arrWeatherUndergroundMeasurementIds);

		$query =
"
SELECT

	wum.*

FROM `weather_underground_measurements` wum
WHERE wum.`id` IN ($csvWeatherUndergroundMeasurementIds){$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		$arrWeatherUndergroundMeasurementsByCsvWeatherUndergroundMeasurementIds = array();
		while ($row = $db->fetch()) {
			$weather_underground_measurement_id = $row['id'];
			$weatherUndergroundMeasurement = self::instantiateOrm($database, 'WeatherUndergroundMeasurement', $row, null, $weather_underground_measurement_id);
			/* @var $weatherUndergroundMeasurement WeatherUndergroundMeasurement */
			$weatherUndergroundMeasurement->convertPropertiesToData();

			$arrWeatherUndergroundMeasurementsByCsvWeatherUndergroundMeasurementIds[$weather_underground_measurement_id] = $weatherUndergroundMeasurement;
		}

		$db->free_result();

		return $arrWeatherUndergroundMeasurementsByCsvWeatherUndergroundMeasurementIds;
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `weather_underground_measurements_fk_wurs` foreign key (`weather_underground_reporting_station_id`) references `weather_underground_reporting_stations` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $weather_underground_reporting_station_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadWeatherUndergroundMeasurementsByWeatherUndergroundReportingStationId($database, $weather_underground_reporting_station_id, Input $options=null)
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
			self::$_arrWeatherUndergroundMeasurementsByWeatherUndergroundReportingStationId = null;
		}

		$arrWeatherUndergroundMeasurementsByWeatherUndergroundReportingStationId = self::$_arrWeatherUndergroundMeasurementsByWeatherUndergroundReportingStationId;
		if (isset($arrWeatherUndergroundMeasurementsByWeatherUndergroundReportingStationId) && !empty($arrWeatherUndergroundMeasurementsByWeatherUndergroundReportingStationId)) {
			return $arrWeatherUndergroundMeasurementsByWeatherUndergroundReportingStationId;
		}

		$weather_underground_reporting_station_id = (int) $weather_underground_reporting_station_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `weather_underground_reporting_station_id` ASC, `weather_underground_condition_label_id` ASC, `created` ASC, `temperature` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpWeatherUndergroundMeasurement = new WeatherUndergroundMeasurement($database);
			$sqlOrderByColumns = $tmpWeatherUndergroundMeasurement->constructSqlOrderByColumns($arrOrderByAttributes);

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
	wum.*

FROM `weather_underground_measurements` wum
WHERE wum.`weather_underground_reporting_station_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `weather_underground_reporting_station_id` ASC, `weather_underground_condition_label_id` ASC, `created` ASC, `temperature` ASC
		$arrValues = array($weather_underground_reporting_station_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrWeatherUndergroundMeasurementsByWeatherUndergroundReportingStationId = array();
		while ($row = $db->fetch()) {
			$weather_underground_measurement_id = $row['id'];
			$weatherUndergroundMeasurement = self::instantiateOrm($database, 'WeatherUndergroundMeasurement', $row, null, $weather_underground_measurement_id);
			/* @var $weatherUndergroundMeasurement WeatherUndergroundMeasurement */
			$arrWeatherUndergroundMeasurementsByWeatherUndergroundReportingStationId[$weather_underground_measurement_id] = $weatherUndergroundMeasurement;
		}

		$db->free_result();

		self::$_arrWeatherUndergroundMeasurementsByWeatherUndergroundReportingStationId = $arrWeatherUndergroundMeasurementsByWeatherUndergroundReportingStationId;

		return $arrWeatherUndergroundMeasurementsByWeatherUndergroundReportingStationId;
	}

	/**
	 * Load by constraint `weather_underground_measurements_fk_wucl` foreign key (`weather_underground_condition_label_id`) references `weather_underground_condition_labels` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $weather_underground_condition_label_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadWeatherUndergroundMeasurementsByWeatherUndergroundConditionLabelId($database, $weather_underground_condition_label_id, Input $options=null)
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
			self::$_arrWeatherUndergroundMeasurementsByWeatherUndergroundConditionLabelId = null;
		}

		$arrWeatherUndergroundMeasurementsByWeatherUndergroundConditionLabelId = self::$_arrWeatherUndergroundMeasurementsByWeatherUndergroundConditionLabelId;
		if (isset($arrWeatherUndergroundMeasurementsByWeatherUndergroundConditionLabelId) && !empty($arrWeatherUndergroundMeasurementsByWeatherUndergroundConditionLabelId)) {
			return $arrWeatherUndergroundMeasurementsByWeatherUndergroundConditionLabelId;
		}

		$weather_underground_condition_label_id = (int) $weather_underground_condition_label_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `weather_underground_reporting_station_id` ASC, `weather_underground_condition_label_id` ASC, `created` ASC, `temperature` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpWeatherUndergroundMeasurement = new WeatherUndergroundMeasurement($database);
			$sqlOrderByColumns = $tmpWeatherUndergroundMeasurement->constructSqlOrderByColumns($arrOrderByAttributes);

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
	wum.*

FROM `weather_underground_measurements` wum
WHERE wum.`weather_underground_condition_label_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `weather_underground_reporting_station_id` ASC, `weather_underground_condition_label_id` ASC, `created` ASC, `temperature` ASC
		$arrValues = array($weather_underground_condition_label_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrWeatherUndergroundMeasurementsByWeatherUndergroundConditionLabelId = array();
		while ($row = $db->fetch()) {
			$weather_underground_measurement_id = $row['id'];
			$weatherUndergroundMeasurement = self::instantiateOrm($database, 'WeatherUndergroundMeasurement', $row, null, $weather_underground_measurement_id);
			/* @var $weatherUndergroundMeasurement WeatherUndergroundMeasurement */
			$arrWeatherUndergroundMeasurementsByWeatherUndergroundConditionLabelId[$weather_underground_measurement_id] = $weatherUndergroundMeasurement;
		}

		$db->free_result();

		self::$_arrWeatherUndergroundMeasurementsByWeatherUndergroundConditionLabelId = $arrWeatherUndergroundMeasurementsByWeatherUndergroundConditionLabelId;

		return $arrWeatherUndergroundMeasurementsByWeatherUndergroundConditionLabelId;
	}

	// Loaders: Load By index
	/**
	 * Load by key `created` (`created`).
	 *
	 * @param string $database
	 * @param string $created
	 * @param mixed (Input $options object | null)
	 * @return mixed (single ORM object | false)
	 */
	public static function loadWeatherUndergroundMeasurementsByCreated($database, $created, Input $options=null)
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
			self::$_arrWeatherUndergroundMeasurementsByCreated = null;
		}

		$arrWeatherUndergroundMeasurementsByCreated = self::$_arrWeatherUndergroundMeasurementsByCreated;
		if (isset($arrWeatherUndergroundMeasurementsByCreated) && !empty($arrWeatherUndergroundMeasurementsByCreated)) {
			return $arrWeatherUndergroundMeasurementsByCreated;
		}

		$created = (string) $created;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `weather_underground_reporting_station_id` ASC, `weather_underground_condition_label_id` ASC, `created` ASC, `temperature` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpWeatherUndergroundMeasurement = new WeatherUndergroundMeasurement($database);
			$sqlOrderByColumns = $tmpWeatherUndergroundMeasurement->constructSqlOrderByColumns($arrOrderByAttributes);

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
	wum.*

FROM `weather_underground_measurements` wum
WHERE wum.`created` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `weather_underground_reporting_station_id` ASC, `weather_underground_condition_label_id` ASC, `created` ASC, `temperature` ASC
		$arrValues = array($created);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrWeatherUndergroundMeasurementsByCreated = array();
		while ($row = $db->fetch()) {
			$weather_underground_measurement_id = $row['id'];
			$weatherUndergroundMeasurement = self::instantiateOrm($database, 'WeatherUndergroundMeasurement', $row, null, $weather_underground_measurement_id);
			/* @var $weatherUndergroundMeasurement WeatherUndergroundMeasurement */
			$arrWeatherUndergroundMeasurementsByCreated[$weather_underground_measurement_id] = $weatherUndergroundMeasurement;
		}

		$db->free_result();

		self::$_arrWeatherUndergroundMeasurementsByCreated = $arrWeatherUndergroundMeasurementsByCreated;

		return $arrWeatherUndergroundMeasurementsByCreated;
	}

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all weather_underground_measurements records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllWeatherUndergroundMeasurements($database, Input $options=null)
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
			self::$_arrAllWeatherUndergroundMeasurements = null;
		}

		$arrAllWeatherUndergroundMeasurements = self::$_arrAllWeatherUndergroundMeasurements;
		if (isset($arrAllWeatherUndergroundMeasurements) && !empty($arrAllWeatherUndergroundMeasurements)) {
			return $arrAllWeatherUndergroundMeasurements;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `weather_underground_reporting_station_id` ASC, `weather_underground_condition_label_id` ASC, `created` ASC, `temperature` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpWeatherUndergroundMeasurement = new WeatherUndergroundMeasurement($database);
			$sqlOrderByColumns = $tmpWeatherUndergroundMeasurement->constructSqlOrderByColumns($arrOrderByAttributes);

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
	wum.*

FROM `weather_underground_measurements` wum{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `weather_underground_reporting_station_id` ASC, `weather_underground_condition_label_id` ASC, `created` ASC, `temperature` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllWeatherUndergroundMeasurements = array();
		while ($row = $db->fetch()) {
			$weather_underground_measurement_id = $row['id'];
			$weatherUndergroundMeasurement = self::instantiateOrm($database, 'WeatherUndergroundMeasurement', $row, null, $weather_underground_measurement_id);
			/* @var $weatherUndergroundMeasurement WeatherUndergroundMeasurement */
			$arrAllWeatherUndergroundMeasurements[$weather_underground_measurement_id] = $weatherUndergroundMeasurement;
		}

		$db->free_result();

		self::$_arrAllWeatherUndergroundMeasurements = $arrAllWeatherUndergroundMeasurements;

		return $arrAllWeatherUndergroundMeasurements;
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
INTO `weather_underground_measurements`
(`weather_underground_reporting_station_id`, `weather_underground_condition_label_id`, `created`, `temperature`)
VALUES (?, ?, ?, ?)
ON DUPLICATE KEY UPDATE `weather_underground_condition_label_id` = ?, `temperature` = ?
";
		$arrValues = array($this->weather_underground_reporting_station_id, $this->weather_underground_condition_label_id, $this->created, $this->temperature, $this->weather_underground_condition_label_id, $this->temperature);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$weather_underground_measurement_id = $db->insertId;
		$db->free_result();

		return $weather_underground_measurement_id;
	}

	// Save: insert ignore

	/**
	 * Similar to FindById, but with SQL as starter code for more complex joins.
	 *
	 * @param string $database
	 * @param int $weather_underground_measurement_id
	 * @return mixed (single ORM object | false)
	 */
	public static function loadAmPmWeatherUndergroundMeasurementsByProjectId($database, $project_id, $date=null)
	{
		if (!isset($date)) {
			$date = 'CURDATE()';
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

			$amQueryFilter =
"
AND TIME(wum.created) >= '05:00:00'
AND TIME(wum.created) < '09:00:00'
";
			$pmQueryFilter =
"
AND TIME(wum.created) >= '15:00:00'
AND TIME(wum.created) < '18:00:00'
";

		$query =
"
SELECT

	round(AVG(wum.`temperature`), 1) AS 'temperature',
	wum.`weather_underground_condition_label_id`,

	wum_fk_wurs.`id` AS 'wum_fk_wurs__weather_underground_reporting_station_id',
	wum_fk_wurs.`weather_reporting_station` AS 'wum_fk_wurs__weather_reporting_station',
	wum_fk_wurs.`latitude` AS 'wum_fk_wurs__latitude',
	wum_fk_wurs.`longitude` AS 'wum_fk_wurs__longitude',
	wum_fk_wurs.`elevation` AS 'wum_fk_wurs__elevation',
	wum_fk_wurs.`address_city` AS 'wum_fk_wurs__address_city',
	wum_fk_wurs.`address_state_or_region` AS 'wum_fk_wurs__address_state_or_region',
	wum_fk_wurs.`address_country` AS 'wum_fk_wurs__address_country',
	wum_fk_wurs.`sort_order` AS 'wum_fk_wurs__sort_order',

	wum_fk_wucl.`id` AS 'wum_fk_wucl__weather_underground_condition_label_id',
	wum_fk_wucl.`weather_condition_label` AS 'wum_fk_wucl__weather_condition_label',
	wum_fk_wucl.`sort_order` AS 'wum_fk_wucl__sort_order',

	wum.*,
	wum_fk_wurs.`id` AS 'weather_underground_reporting_station_id',
	wum_fk_wucl.`id` AS 'weather_underground_condition_label_id'

FROM `weather_underground_measurements` wum
	INNER JOIN `projects_to_weather_underground_reporting_stations` p2wurs ON wum.`weather_underground_reporting_station_id` = p2wurs.`weather_underground_reporting_station_id`
	INNER JOIN `weather_underground_reporting_stations` wum_fk_wurs ON wum.`weather_underground_reporting_station_id` = wum_fk_wurs.`id`
	INNER JOIN `weather_underground_condition_labels` wum_fk_wucl ON wum.`weather_underground_condition_label_id` = wum_fk_wucl.`id`
WHERE p2wurs.`project_id` = ?
AND DATE(wum.`created`) = '$date'
--find_replace_filter--
GROUP by wum.`weather_underground_condition_label_id`
ORDER BY COUNT(wum.`weather_underground_condition_label_id`) DESC
limit 1
";

		$amQuery = str_replace('--find_replace_filter--', $amQueryFilter, $query);
		$pmQuery = str_replace('--find_replace_filter--', $pmQueryFilter, $query);
		$arrValues = array($project_id);

		$db->execute($amQuery, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$amWeatherUndergroundMeasurement = self::instantiateOrm($database, 'WeatherUndergroundMeasurement', $row);
			/* @var $amWeatherUndergroundMeasurement WeatherUndergroundMeasurement */
			$amWeatherUndergroundMeasurement->convertPropertiesToData();

			if (isset($row['weather_underground_reporting_station_id'])) {
				$weather_underground_reporting_station_id = $row['weather_underground_reporting_station_id'];
				$row['wum_fk_wurs__id'] = $weather_underground_reporting_station_id;
				$weatherUndergroundReportingStation = self::instantiateOrm($database, 'WeatherUndergroundReportingStation', $row, null, $weather_underground_reporting_station_id, 'wum_fk_wurs__');
				/* @var $weatherUndergroundReportingStation WeatherUndergroundReportingStation */
				$weatherUndergroundReportingStation->convertPropertiesToData();
			} else {
				$weatherUndergroundReportingStation = false;
			}
			$amWeatherUndergroundMeasurement->setWeatherUndergroundReportingStation($weatherUndergroundReportingStation);

			if (isset($row['weather_underground_condition_label_id'])) {
				$weather_underground_condition_label_id = $row['weather_underground_condition_label_id'];
				$row['wum_fk_wucl__id'] = $weather_underground_condition_label_id;
				$weatherUndergroundConditionLabel = self::instantiateOrm($database, 'WeatherUndergroundConditionLabel', $row, null, $weather_underground_condition_label_id, 'wum_fk_wucl__');
				/* @var $weatherUndergroundConditionLabel WeatherUndergroundConditionLabel */
				$weatherUndergroundConditionLabel->convertPropertiesToData();
			} else {
				$weatherUndergroundConditionLabel = false;
			}
			$amWeatherUndergroundMeasurement->setWeatherUndergroundConditionLabel($weatherUndergroundConditionLabel);
		} else {
			$amWeatherUndergroundMeasurement = false;
		}

		$db->execute($pmQuery, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$pmWeatherUndergroundMeasurement = self::instantiateOrm($database, 'WeatherUndergroundMeasurement', $row);
			/* @var $pmWeatherUndergroundMeasurement WeatherUndergroundMeasurement */
			$pmWeatherUndergroundMeasurement->convertPropertiesToData();

			if (isset($row['weather_underground_reporting_station_id'])) {
				$weather_underground_reporting_station_id = $row['weather_underground_reporting_station_id'];
				$row['wum_fk_wurs__id'] = $weather_underground_reporting_station_id;
				$weatherUndergroundReportingStation = self::instantiateOrm($database, 'WeatherUndergroundReportingStation', $row, null, $weather_underground_reporting_station_id, 'wum_fk_wurs__');
				/* @var $weatherUndergroundReportingStation WeatherUndergroundReportingStation */
				$weatherUndergroundReportingStation->convertPropertiesToData();
			} else {
				$weatherUndergroundReportingStation = false;
			}
			$pmWeatherUndergroundMeasurement->setWeatherUndergroundReportingStation($weatherUndergroundReportingStation);

			if (isset($row['weather_underground_condition_label_id'])) {
				$weather_underground_condition_label_id = $row['weather_underground_condition_label_id'];
				$row['wum_fk_wucl__id'] = $weather_underground_condition_label_id;
				$weatherUndergroundConditionLabel = self::instantiateOrm($database, 'WeatherUndergroundConditionLabel', $row, null, $weather_underground_condition_label_id, 'wum_fk_wucl__');
				/* @var $weatherUndergroundConditionLabel WeatherUndergroundConditionLabel */
				$weatherUndergroundConditionLabel->convertPropertiesToData();
			} else {
				$weatherUndergroundConditionLabel = false;
			}
			$pmWeatherUndergroundMeasurement->setWeatherUndergroundConditionLabel($weatherUndergroundConditionLabel);
		} else {
			$pmWeatherUndergroundMeasurement = false;
		}

		$arrReturn = array(
			'am' => $amWeatherUndergroundMeasurement,
			'pm' => $pmWeatherUndergroundMeasurement,
		);

		return $arrReturn;
	}
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

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
 * WeatherUndergroundAmPmLog.
 *
 * @category   Framework
 * @package    WeatherUndergroundAmPmLog
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class WeatherUndergroundAmPmLog extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'WeatherUndergroundAmPmLog';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'weather_underground_am_pm_logs';

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
	 * unique index `unique_weather_underground_am_pm_log` (`weather_underground_reporting_station_id`,`created`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_weather_underground_am_pm_log' => array(
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
		'id' => 'weather_underground_am_pm_log_id',

		'weather_underground_reporting_station_id' => 'weather_underground_reporting_station_id',
		'am_weather_underground_condition_label_id' => 'am_weather_underground_condition_label_id',
		'pm_weather_underground_condition_label_id' => 'pm_weather_underground_condition_label_id',

		'created' => 'created',

		'am_temperature' => 'am_temperature',
		'pm_temperature' => 'pm_temperature'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $weather_underground_am_pm_log_id;

	public $weather_underground_reporting_station_id;
	public $am_weather_underground_condition_label_id;
	public $pm_weather_underground_condition_label_id;

	public $created;

	public $am_temperature;
	public $pm_temperature;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties

	// HTML ENTITY ENCODED NL2BR ORM string properties

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)
	protected static $_arrWeatherUndergroundAmPmLogsByWeatherUndergroundReportingStationId;
	protected static $_arrWeatherUndergroundAmPmLogsByAmWeatherUndergroundConditionLabelId;
	protected static $_arrWeatherUndergroundAmPmLogsByPmWeatherUndergroundConditionLabelId;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)
	protected static $_arrWeatherUndergroundAmPmLogsByCreated;

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllWeatherUndergroundAmPmLogs;

	// Foreign Key Objects
	private $_weatherUndergroundReportingStation;
	private $_amWeatherUndergroundConditionLabel;
	private $_pmWeatherUndergroundConditionLabel;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='weather_underground_am_pm_logs')
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

	public function getAmWeatherUndergroundConditionLabel()
	{
		if (isset($this->_amWeatherUndergroundConditionLabel)) {
			return $this->_amWeatherUndergroundConditionLabel;
		} else {
			return null;
		}
	}

	public function setAmWeatherUndergroundConditionLabel($amWeatherUndergroundConditionLabel)
	{
		$this->_amWeatherUndergroundConditionLabel = $amWeatherUndergroundConditionLabel;
	}

	public function getPmWeatherUndergroundConditionLabel()
	{
		if (isset($this->_pmWeatherUndergroundConditionLabel)) {
			return $this->_pmWeatherUndergroundConditionLabel;
		} else {
			return null;
		}
	}

	public function setPmWeatherUndergroundConditionLabel($pmWeatherUndergroundConditionLabel)
	{
		$this->_pmWeatherUndergroundConditionLabel = $pmWeatherUndergroundConditionLabel;
	}

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)
	public static function getArrWeatherUndergroundAmPmLogsByWeatherUndergroundReportingStationId()
	{
		if (isset(self::$_arrWeatherUndergroundAmPmLogsByWeatherUndergroundReportingStationId)) {
			return self::$_arrWeatherUndergroundAmPmLogsByWeatherUndergroundReportingStationId;
		} else {
			return null;
		}
	}

	public static function setArrWeatherUndergroundAmPmLogsByWeatherUndergroundReportingStationId($arrWeatherUndergroundAmPmLogsByWeatherUndergroundReportingStationId)
	{
		self::$_arrWeatherUndergroundAmPmLogsByWeatherUndergroundReportingStationId = $arrWeatherUndergroundAmPmLogsByWeatherUndergroundReportingStationId;
	}

	public static function getArrWeatherUndergroundAmPmLogsByAmWeatherUndergroundConditionLabelId()
	{
		if (isset(self::$_arrWeatherUndergroundAmPmLogsByAmWeatherUndergroundConditionLabelId)) {
			return self::$_arrWeatherUndergroundAmPmLogsByAmWeatherUndergroundConditionLabelId;
		} else {
			return null;
		}
	}

	public static function setArrWeatherUndergroundAmPmLogsByAmWeatherUndergroundConditionLabelId($arrWeatherUndergroundAmPmLogsByAmWeatherUndergroundConditionLabelId)
	{
		self::$_arrWeatherUndergroundAmPmLogsByAmWeatherUndergroundConditionLabelId = $arrWeatherUndergroundAmPmLogsByAmWeatherUndergroundConditionLabelId;
	}

	public static function getArrWeatherUndergroundAmPmLogsByPmWeatherUndergroundConditionLabelId()
	{
		if (isset(self::$_arrWeatherUndergroundAmPmLogsByPmWeatherUndergroundConditionLabelId)) {
			return self::$_arrWeatherUndergroundAmPmLogsByPmWeatherUndergroundConditionLabelId;
		} else {
			return null;
		}
	}

	public static function setArrWeatherUndergroundAmPmLogsByPmWeatherUndergroundConditionLabelId($arrWeatherUndergroundAmPmLogsByPmWeatherUndergroundConditionLabelId)
	{
		self::$_arrWeatherUndergroundAmPmLogsByPmWeatherUndergroundConditionLabelId = $arrWeatherUndergroundAmPmLogsByPmWeatherUndergroundConditionLabelId;
	}

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)
	public static function getArrWeatherUndergroundAmPmLogsByCreated()
	{
		if (isset(self::$_arrWeatherUndergroundAmPmLogsByCreated)) {
			return self::$_arrWeatherUndergroundAmPmLogsByCreated;
		} else {
			return null;
		}
	}

	public static function setArrWeatherUndergroundAmPmLogsByCreated($arrWeatherUndergroundAmPmLogsByCreated)
	{
		self::$_arrWeatherUndergroundAmPmLogsByCreated = $arrWeatherUndergroundAmPmLogsByCreated;
	}

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllWeatherUndergroundAmPmLogs()
	{
		if (isset(self::$_arrAllWeatherUndergroundAmPmLogs)) {
			return self::$_arrAllWeatherUndergroundAmPmLogs;
		} else {
			return null;
		}
	}

	public static function setArrAllWeatherUndergroundAmPmLogs($arrAllWeatherUndergroundAmPmLogs)
	{
		self::$_arrAllWeatherUndergroundAmPmLogs = $arrAllWeatherUndergroundAmPmLogs;
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
	 * @param int $weather_underground_am_pm_log_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findById($database, $weather_underground_am_pm_log_id,$table='weather_underground_am_pm_logs', $module='WeatherUndergroundAmPmLog')
	{
		$weatherUndergroundAmPmLog = parent::findById($database, $weather_underground_am_pm_log_id, $table, $module);

		return $weatherUndergroundAmPmLog;
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Similar to FindById, but with SQL as starter code for more complex joins.
	 *
	 * @param string $database
	 * @param int $weather_underground_am_pm_log_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findWeatherUndergroundAmPmLogByIdExtended($database, $weather_underground_am_pm_log_id)
	{
		$weather_underground_am_pm_log_id = (int) $weather_underground_am_pm_log_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	wuapl_fk_wurs.`id` AS 'wuapl_fk_wurs__weather_underground_reporting_station_id',
	wuapl_fk_wurs.`weather_reporting_station` AS 'wuapl_fk_wurs__weather_reporting_station',
	wuapl_fk_wurs.`latitude` AS 'wuapl_fk_wurs__latitude',
	wuapl_fk_wurs.`longitude` AS 'wuapl_fk_wurs__longitude',
	wuapl_fk_wurs.`elevation` AS 'wuapl_fk_wurs__elevation',
	wuapl_fk_wurs.`address_city` AS 'wuapl_fk_wurs__address_city',
	wuapl_fk_wurs.`address_state_or_region` AS 'wuapl_fk_wurs__address_state_or_region',
	wuapl_fk_wurs.`address_country` AS 'wuapl_fk_wurs__address_country',
	wuapl_fk_wurs.`sort_order` AS 'wuapl_fk_wurs__sort_order',

	wuapl_fk_am_wucl.`id` AS 'wuapl_fk_am_wucl__weather_underground_condition_label_id',
	wuapl_fk_am_wucl.`weather_condition_label` AS 'wuapl_fk_am_wucl__weather_condition_label',
	wuapl_fk_am_wucl.`sort_order` AS 'wuapl_fk_am_wucl__sort_order',

	wuapl_fk_pm_wucl.`id` AS 'wuapl_fk_pm_wucl__weather_underground_condition_label_id',
	wuapl_fk_pm_wucl.`weather_condition_label` AS 'wuapl_fk_pm_wucl__weather_condition_label',
	wuapl_fk_pm_wucl.`sort_order` AS 'wuapl_fk_pm_wucl__sort_order',

	wuapl.*

FROM `weather_underground_am_pm_logs` wuapl
	INNER JOIN `weather_underground_reporting_stations` wuapl_fk_wurs ON wuapl.`weather_underground_reporting_station_id` = wuapl_fk_wurs.`id`
	INNER JOIN `weather_underground_condition_labels` wuapl_fk_am_wucl ON wuapl.`am_weather_underground_condition_label_id` = wuapl_fk_am_wucl.`id`
	INNER JOIN `weather_underground_condition_labels` wuapl_fk_pm_wucl ON wuapl.`pm_weather_underground_condition_label_id` = wuapl_fk_pm_wucl.`id`
WHERE wuapl.`id` = ?
";
		$arrValues = array($weather_underground_am_pm_log_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$weather_underground_am_pm_log_id = $row['id'];
			$weatherUndergroundAmPmLog = self::instantiateOrm($database, 'WeatherUndergroundAmPmLog', $row, null, $weather_underground_am_pm_log_id);
			/* @var $weatherUndergroundAmPmLog WeatherUndergroundAmPmLog */
			$weatherUndergroundAmPmLog->convertPropertiesToData();

			if (isset($row['weather_underground_reporting_station_id'])) {
				$weather_underground_reporting_station_id = $row['weather_underground_reporting_station_id'];
				$row['wuapl_fk_wurs__id'] = $weather_underground_reporting_station_id;
				$weatherUndergroundReportingStation = self::instantiateOrm($database, 'WeatherUndergroundReportingStation', $row, null, $weather_underground_reporting_station_id, 'wuapl_fk_wurs__');
				/* @var $weatherUndergroundReportingStation WeatherUndergroundReportingStation */
				$weatherUndergroundReportingStation->convertPropertiesToData();
			} else {
				$weatherUndergroundReportingStation = false;
			}
			$weatherUndergroundAmPmLog->setWeatherUndergroundReportingStation($weatherUndergroundReportingStation);

			if (isset($row['am_weather_underground_condition_label_id'])) {
				$am_weather_underground_condition_label_id = $row['am_weather_underground_condition_label_id'];
				$row['wuapl_fk_am_wucl__id'] = $am_weather_underground_condition_label_id;
				$amWeatherUndergroundConditionLabel = self::instantiateOrm($database, 'WeatherUndergroundConditionLabel', $row, null, $am_weather_underground_condition_label_id, 'wuapl_fk_am_wucl__');
				/* @var $amWeatherUndergroundConditionLabel WeatherUndergroundConditionLabel */
				$amWeatherUndergroundConditionLabel->convertPropertiesToData();
			} else {
				$amWeatherUndergroundConditionLabel = false;
			}
			$weatherUndergroundAmPmLog->setAmWeatherUndergroundConditionLabel($amWeatherUndergroundConditionLabel);

			if (isset($row['pm_weather_underground_condition_label_id'])) {
				$pm_weather_underground_condition_label_id = $row['pm_weather_underground_condition_label_id'];
				$row['wuapl_fk_pm_wucl__id'] = $pm_weather_underground_condition_label_id;
				$pmWeatherUndergroundConditionLabel = self::instantiateOrm($database, 'WeatherUndergroundConditionLabel', $row, null, $pm_weather_underground_condition_label_id, 'wuapl_fk_pm_wucl__');
				/* @var $pmWeatherUndergroundConditionLabel WeatherUndergroundConditionLabel */
				$pmWeatherUndergroundConditionLabel->convertPropertiesToData();
			} else {
				$pmWeatherUndergroundConditionLabel = false;
			}
			$weatherUndergroundAmPmLog->setPmWeatherUndergroundConditionLabel($pmWeatherUndergroundConditionLabel);

			return $weatherUndergroundAmPmLog;
		} else {
			return false;
		}
	}

	// Finders: Find By Unique Index
	/**
	 * Find by unique index `unique_weather_underground_am_pm_log` (`weather_underground_reporting_station_id`,`created`).
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
	wuapl.*

FROM `weather_underground_am_pm_logs` wuapl
WHERE wuapl.`weather_underground_reporting_station_id` = ?
AND wuapl.`created` = ?
";
		$arrValues = array($weather_underground_reporting_station_id, $created);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if ($row && !empty($row)) {
			$weather_underground_am_pm_log_id = $row['id'];
			$weatherUndergroundAmPmLog = self::instantiateOrm($database, 'WeatherUndergroundAmPmLog', $row, null, $weather_underground_am_pm_log_id);
			/* @var $weatherUndergroundAmPmLog WeatherUndergroundAmPmLog */
			return $weatherUndergroundAmPmLog;
		} else {
			return false;
		}
	}

	// Loaders: Load By pk List (list of auto int ids or other non auto int pk list)
	/**
	 * Load zero or more records by an id list (array of auto int primary keys).
	 *
	 * @param string $database
	 * @param array $arrWeatherUndergroundAmPmLogIds
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadWeatherUndergroundAmPmLogsByArrWeatherUndergroundAmPmLogIds($database, $arrWeatherUndergroundAmPmLogIds, Input $options=null)
	{
		if (empty($arrWeatherUndergroundAmPmLogIds)) {
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
		// ORDER BY `id` ASC, `weather_underground_reporting_station_id` ASC, `am_weather_underground_condition_label_id` ASC, `pm_weather_underground_condition_label_id` ASC, `created` ASC, `am_temperature` ASC, `pm_temperature` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpWeatherUndergroundAmPmLog = new WeatherUndergroundAmPmLog($database);
			$sqlOrderByColumns = $tmpWeatherUndergroundAmPmLog->constructSqlOrderByColumns($arrOrderByAttributes);

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

		foreach ($arrWeatherUndergroundAmPmLogIds as $k => $weather_underground_am_pm_log_id) {
			$weather_underground_am_pm_log_id = (int) $weather_underground_am_pm_log_id;
			$arrWeatherUndergroundAmPmLogIds[$k] = $db->escape($weather_underground_am_pm_log_id);
		}
		$csvWeatherUndergroundAmPmLogIds = join(',', $arrWeatherUndergroundAmPmLogIds);

		$query =
"
SELECT

	wuapl.*

FROM `weather_underground_am_pm_logs` wuapl
WHERE wuapl.`id` IN ($csvWeatherUndergroundAmPmLogIds){$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		$arrWeatherUndergroundAmPmLogsByCsvWeatherUndergroundAmPmLogIds = array();
		while ($row = $db->fetch()) {
			$weather_underground_am_pm_log_id = $row['id'];
			$weatherUndergroundAmPmLog = self::instantiateOrm($database, 'WeatherUndergroundAmPmLog', $row, null, $weather_underground_am_pm_log_id);
			/* @var $weatherUndergroundAmPmLog WeatherUndergroundAmPmLog */
			$weatherUndergroundAmPmLog->convertPropertiesToData();

			$arrWeatherUndergroundAmPmLogsByCsvWeatherUndergroundAmPmLogIds[$weather_underground_am_pm_log_id] = $weatherUndergroundAmPmLog;
		}

		$db->free_result();

		return $arrWeatherUndergroundAmPmLogsByCsvWeatherUndergroundAmPmLogIds;
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `weather_underground_am_pm_logs_fk_wurs` foreign key (`weather_underground_reporting_station_id`) references `weather_underground_reporting_stations` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $weather_underground_reporting_station_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadWeatherUndergroundAmPmLogsByWeatherUndergroundReportingStationId($database, $weather_underground_reporting_station_id, Input $options=null)
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
			self::$_arrWeatherUndergroundAmPmLogsByWeatherUndergroundReportingStationId = null;
		}

		$arrWeatherUndergroundAmPmLogsByWeatherUndergroundReportingStationId = self::$_arrWeatherUndergroundAmPmLogsByWeatherUndergroundReportingStationId;
		if (isset($arrWeatherUndergroundAmPmLogsByWeatherUndergroundReportingStationId) && !empty($arrWeatherUndergroundAmPmLogsByWeatherUndergroundReportingStationId)) {
			return $arrWeatherUndergroundAmPmLogsByWeatherUndergroundReportingStationId;
		}

		$weather_underground_reporting_station_id = (int) $weather_underground_reporting_station_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `weather_underground_reporting_station_id` ASC, `am_weather_underground_condition_label_id` ASC, `pm_weather_underground_condition_label_id` ASC, `created` ASC, `am_temperature` ASC, `pm_temperature` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpWeatherUndergroundAmPmLog = new WeatherUndergroundAmPmLog($database);
			$sqlOrderByColumns = $tmpWeatherUndergroundAmPmLog->constructSqlOrderByColumns($arrOrderByAttributes);

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
	wuapl.*

FROM `weather_underground_am_pm_logs` wuapl
WHERE wuapl.`weather_underground_reporting_station_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `weather_underground_reporting_station_id` ASC, `am_weather_underground_condition_label_id` ASC, `pm_weather_underground_condition_label_id` ASC, `created` ASC, `am_temperature` ASC, `pm_temperature` ASC
		$arrValues = array($weather_underground_reporting_station_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrWeatherUndergroundAmPmLogsByWeatherUndergroundReportingStationId = array();
		while ($row = $db->fetch()) {
			$weather_underground_am_pm_log_id = $row['id'];
			$weatherUndergroundAmPmLog = self::instantiateOrm($database, 'WeatherUndergroundAmPmLog', $row, null, $weather_underground_am_pm_log_id);
			/* @var $weatherUndergroundAmPmLog WeatherUndergroundAmPmLog */
			$arrWeatherUndergroundAmPmLogsByWeatherUndergroundReportingStationId[$weather_underground_am_pm_log_id] = $weatherUndergroundAmPmLog;
		}

		$db->free_result();

		self::$_arrWeatherUndergroundAmPmLogsByWeatherUndergroundReportingStationId = $arrWeatherUndergroundAmPmLogsByWeatherUndergroundReportingStationId;

		return $arrWeatherUndergroundAmPmLogsByWeatherUndergroundReportingStationId;
	}

	/**
	 * Load by constraint `weather_underground_am_pm_logs_fk_am_wucl` foreign key (`am_weather_underground_condition_label_id`) references `weather_underground_condition_labels` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $am_weather_underground_condition_label_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadWeatherUndergroundAmPmLogsByAmWeatherUndergroundConditionLabelId($database, $am_weather_underground_condition_label_id, Input $options=null)
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
			self::$_arrWeatherUndergroundAmPmLogsByAmWeatherUndergroundConditionLabelId = null;
		}

		$arrWeatherUndergroundAmPmLogsByAmWeatherUndergroundConditionLabelId = self::$_arrWeatherUndergroundAmPmLogsByAmWeatherUndergroundConditionLabelId;
		if (isset($arrWeatherUndergroundAmPmLogsByAmWeatherUndergroundConditionLabelId) && !empty($arrWeatherUndergroundAmPmLogsByAmWeatherUndergroundConditionLabelId)) {
			return $arrWeatherUndergroundAmPmLogsByAmWeatherUndergroundConditionLabelId;
		}

		$am_weather_underground_condition_label_id = (int) $am_weather_underground_condition_label_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `weather_underground_reporting_station_id` ASC, `am_weather_underground_condition_label_id` ASC, `pm_weather_underground_condition_label_id` ASC, `created` ASC, `am_temperature` ASC, `pm_temperature` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpWeatherUndergroundAmPmLog = new WeatherUndergroundAmPmLog($database);
			$sqlOrderByColumns = $tmpWeatherUndergroundAmPmLog->constructSqlOrderByColumns($arrOrderByAttributes);

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
	wuapl.*

FROM `weather_underground_am_pm_logs` wuapl
WHERE wuapl.`am_weather_underground_condition_label_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `weather_underground_reporting_station_id` ASC, `am_weather_underground_condition_label_id` ASC, `pm_weather_underground_condition_label_id` ASC, `created` ASC, `am_temperature` ASC, `pm_temperature` ASC
		$arrValues = array($am_weather_underground_condition_label_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrWeatherUndergroundAmPmLogsByAmWeatherUndergroundConditionLabelId = array();
		while ($row = $db->fetch()) {
			$weather_underground_am_pm_log_id = $row['id'];
			$weatherUndergroundAmPmLog = self::instantiateOrm($database, 'WeatherUndergroundAmPmLog', $row, null, $weather_underground_am_pm_log_id);
			/* @var $weatherUndergroundAmPmLog WeatherUndergroundAmPmLog */
			$arrWeatherUndergroundAmPmLogsByAmWeatherUndergroundConditionLabelId[$weather_underground_am_pm_log_id] = $weatherUndergroundAmPmLog;
		}

		$db->free_result();

		self::$_arrWeatherUndergroundAmPmLogsByAmWeatherUndergroundConditionLabelId = $arrWeatherUndergroundAmPmLogsByAmWeatherUndergroundConditionLabelId;

		return $arrWeatherUndergroundAmPmLogsByAmWeatherUndergroundConditionLabelId;
	}

	/**
	 * Load by constraint `weather_underground_am_pm_logs_fk_pm_wucl` foreign key (`pm_weather_underground_condition_label_id`) references `weather_underground_condition_labels` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $pm_weather_underground_condition_label_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadWeatherUndergroundAmPmLogsByPmWeatherUndergroundConditionLabelId($database, $pm_weather_underground_condition_label_id, Input $options=null)
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
			self::$_arrWeatherUndergroundAmPmLogsByPmWeatherUndergroundConditionLabelId = null;
		}

		$arrWeatherUndergroundAmPmLogsByPmWeatherUndergroundConditionLabelId = self::$_arrWeatherUndergroundAmPmLogsByPmWeatherUndergroundConditionLabelId;
		if (isset($arrWeatherUndergroundAmPmLogsByPmWeatherUndergroundConditionLabelId) && !empty($arrWeatherUndergroundAmPmLogsByPmWeatherUndergroundConditionLabelId)) {
			return $arrWeatherUndergroundAmPmLogsByPmWeatherUndergroundConditionLabelId;
		}

		$pm_weather_underground_condition_label_id = (int) $pm_weather_underground_condition_label_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `weather_underground_reporting_station_id` ASC, `am_weather_underground_condition_label_id` ASC, `pm_weather_underground_condition_label_id` ASC, `created` ASC, `am_temperature` ASC, `pm_temperature` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpWeatherUndergroundAmPmLog = new WeatherUndergroundAmPmLog($database);
			$sqlOrderByColumns = $tmpWeatherUndergroundAmPmLog->constructSqlOrderByColumns($arrOrderByAttributes);

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
	wuapl.*

FROM `weather_underground_am_pm_logs` wuapl
WHERE wuapl.`pm_weather_underground_condition_label_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `weather_underground_reporting_station_id` ASC, `am_weather_underground_condition_label_id` ASC, `pm_weather_underground_condition_label_id` ASC, `created` ASC, `am_temperature` ASC, `pm_temperature` ASC
		$arrValues = array($pm_weather_underground_condition_label_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrWeatherUndergroundAmPmLogsByPmWeatherUndergroundConditionLabelId = array();
		while ($row = $db->fetch()) {
			$weather_underground_am_pm_log_id = $row['id'];
			$weatherUndergroundAmPmLog = self::instantiateOrm($database, 'WeatherUndergroundAmPmLog', $row, null, $weather_underground_am_pm_log_id);
			/* @var $weatherUndergroundAmPmLog WeatherUndergroundAmPmLog */
			$arrWeatherUndergroundAmPmLogsByPmWeatherUndergroundConditionLabelId[$weather_underground_am_pm_log_id] = $weatherUndergroundAmPmLog;
		}

		$db->free_result();

		self::$_arrWeatherUndergroundAmPmLogsByPmWeatherUndergroundConditionLabelId = $arrWeatherUndergroundAmPmLogsByPmWeatherUndergroundConditionLabelId;

		return $arrWeatherUndergroundAmPmLogsByPmWeatherUndergroundConditionLabelId;
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
	public static function loadWeatherUndergroundAmPmLogsByCreated($database, $created, Input $options=null)
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
			self::$_arrWeatherUndergroundAmPmLogsByCreated = null;
		}

		$arrWeatherUndergroundAmPmLogsByCreated = self::$_arrWeatherUndergroundAmPmLogsByCreated;
		if (isset($arrWeatherUndergroundAmPmLogsByCreated) && !empty($arrWeatherUndergroundAmPmLogsByCreated)) {
			return $arrWeatherUndergroundAmPmLogsByCreated;
		}

		$created = (string) $created;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `weather_underground_reporting_station_id` ASC, `am_weather_underground_condition_label_id` ASC, `pm_weather_underground_condition_label_id` ASC, `created` ASC, `am_temperature` ASC, `pm_temperature` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpWeatherUndergroundAmPmLog = new WeatherUndergroundAmPmLog($database);
			$sqlOrderByColumns = $tmpWeatherUndergroundAmPmLog->constructSqlOrderByColumns($arrOrderByAttributes);

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
	wuapl.*

FROM `weather_underground_am_pm_logs` wuapl
WHERE wuapl.`created` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `weather_underground_reporting_station_id` ASC, `am_weather_underground_condition_label_id` ASC, `pm_weather_underground_condition_label_id` ASC, `created` ASC, `am_temperature` ASC, `pm_temperature` ASC
		$arrValues = array($created);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrWeatherUndergroundAmPmLogsByCreated = array();
		while ($row = $db->fetch()) {
			$weather_underground_am_pm_log_id = $row['id'];
			$weatherUndergroundAmPmLog = self::instantiateOrm($database, 'WeatherUndergroundAmPmLog', $row, null, $weather_underground_am_pm_log_id);
			/* @var $weatherUndergroundAmPmLog WeatherUndergroundAmPmLog */
			$arrWeatherUndergroundAmPmLogsByCreated[$weather_underground_am_pm_log_id] = $weatherUndergroundAmPmLog;
		}

		$db->free_result();

		self::$_arrWeatherUndergroundAmPmLogsByCreated = $arrWeatherUndergroundAmPmLogsByCreated;

		return $arrWeatherUndergroundAmPmLogsByCreated;
	}

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all weather_underground_am_pm_logs records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllWeatherUndergroundAmPmLogs($database, Input $options=null)
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
			self::$_arrAllWeatherUndergroundAmPmLogs = null;
		}

		$arrAllWeatherUndergroundAmPmLogs = self::$_arrAllWeatherUndergroundAmPmLogs;
		if (isset($arrAllWeatherUndergroundAmPmLogs) && !empty($arrAllWeatherUndergroundAmPmLogs)) {
			return $arrAllWeatherUndergroundAmPmLogs;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `weather_underground_reporting_station_id` ASC, `am_weather_underground_condition_label_id` ASC, `pm_weather_underground_condition_label_id` ASC, `created` ASC, `am_temperature` ASC, `pm_temperature` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpWeatherUndergroundAmPmLog = new WeatherUndergroundAmPmLog($database);
			$sqlOrderByColumns = $tmpWeatherUndergroundAmPmLog->constructSqlOrderByColumns($arrOrderByAttributes);

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
	wuapl.*

FROM `weather_underground_am_pm_logs` wuapl{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `weather_underground_reporting_station_id` ASC, `am_weather_underground_condition_label_id` ASC, `pm_weather_underground_condition_label_id` ASC, `created` ASC, `am_temperature` ASC, `pm_temperature` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllWeatherUndergroundAmPmLogs = array();
		while ($row = $db->fetch()) {
			$weather_underground_am_pm_log_id = $row['id'];
			$weatherUndergroundAmPmLog = self::instantiateOrm($database, 'WeatherUndergroundAmPmLog', $row, null, $weather_underground_am_pm_log_id);
			/* @var $weatherUndergroundAmPmLog WeatherUndergroundAmPmLog */
			$arrAllWeatherUndergroundAmPmLogs[$weather_underground_am_pm_log_id] = $weatherUndergroundAmPmLog;
		}

		$db->free_result();

		self::$_arrAllWeatherUndergroundAmPmLogs = $arrAllWeatherUndergroundAmPmLogs;

		return $arrAllWeatherUndergroundAmPmLogs;
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
INTO `weather_underground_am_pm_logs`
(`weather_underground_reporting_station_id`, `am_weather_underground_condition_label_id`, `pm_weather_underground_condition_label_id`, `created`, `am_temperature`, `pm_temperature`)
VALUES (?, ?, ?, ?, ?, ?)
ON DUPLICATE KEY UPDATE `am_weather_underground_condition_label_id` = ?, `pm_weather_underground_condition_label_id` = ?, `am_temperature` = ?, `pm_temperature` = ?
";
		$arrValues = array($this->weather_underground_reporting_station_id, $this->am_weather_underground_condition_label_id, $this->pm_weather_underground_condition_label_id, $this->created, $this->am_temperature, $this->pm_temperature, $this->am_weather_underground_condition_label_id, $this->pm_weather_underground_condition_label_id, $this->am_temperature, $this->pm_temperature);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$weather_underground_am_pm_log_id = $db->insertId;
		$db->free_result();

		return $weather_underground_am_pm_log_id;
	}

	// Save: insert ignore
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

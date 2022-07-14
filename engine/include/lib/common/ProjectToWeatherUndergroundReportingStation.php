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
 * ProjectToWeatherUndergroundReportingStation.
 *
 * @category   Framework
 * @package    ProjectToWeatherUndergroundReportingStation
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class ProjectToWeatherUndergroundReportingStation extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'ProjectToWeatherUndergroundReportingStation';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'projects_to_weather_underground_reporting_stations';

	/**
	 * primary key (`project_id`,`weather_underground_reporting_station_id`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrPrimaryKey = array(
		'project_id' => 'int',
		'weather_underground_reporting_station_id' => 'int'
	);

	/**
	 * No Unique Indexes, Just a Primary Key
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_project_to_weather_underground_reporting_station_via_primary_key' => array(
			'project_id' => 'int',
			'weather_underground_reporting_station_id' => 'int'
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
		'project_id' => 'project_id',
		'weather_underground_reporting_station_id' => 'weather_underground_reporting_station_id'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $project_id;
	public $weather_underground_reporting_station_id;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)
	protected static $_arrProjectsToWeatherUndergroundReportingStationsByProjectId;
	protected static $_arrProjectsToWeatherUndergroundReportingStationsByWeatherUndergroundReportingStationId;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllProjectsToWeatherUndergroundReportingStations;

	// Foreign Key Objects
	private $_project;
	private $_weatherUndergroundReportingStation;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='projects_to_weather_underground_reporting_stations')
	{
		parent::__construct($table);
		$this->setDatabase($database);
	}

	// Foreign Key Object Accessor Methods
	public function getProject()
	{
		if (isset($this->_project)) {
			return $this->_project;
		} else {
			return null;
		}
	}

	public function setProject($project)
	{
		$this->_project = $project;
	}

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

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)
	public static function getArrProjectsToWeatherUndergroundReportingStationsByProjectId()
	{
		if (isset(self::$_arrProjectsToWeatherUndergroundReportingStationsByProjectId)) {
			return self::$_arrProjectsToWeatherUndergroundReportingStationsByProjectId;
		} else {
			return null;
		}
	}

	public static function setArrProjectsToWeatherUndergroundReportingStationsByProjectId($arrProjectsToWeatherUndergroundReportingStationsByProjectId)
	{
		self::$_arrProjectsToWeatherUndergroundReportingStationsByProjectId = $arrProjectsToWeatherUndergroundReportingStationsByProjectId;
	}

	public static function getArrProjectsToWeatherUndergroundReportingStationsByWeatherUndergroundReportingStationId()
	{
		if (isset(self::$_arrProjectsToWeatherUndergroundReportingStationsByWeatherUndergroundReportingStationId)) {
			return self::$_arrProjectsToWeatherUndergroundReportingStationsByWeatherUndergroundReportingStationId;
		} else {
			return null;
		}
	}

	public static function setArrProjectsToWeatherUndergroundReportingStationsByWeatherUndergroundReportingStationId($arrProjectsToWeatherUndergroundReportingStationsByWeatherUndergroundReportingStationId)
	{
		self::$_arrProjectsToWeatherUndergroundReportingStationsByWeatherUndergroundReportingStationId = $arrProjectsToWeatherUndergroundReportingStationsByWeatherUndergroundReportingStationId;
	}

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllProjectsToWeatherUndergroundReportingStations()
	{
		if (isset(self::$_arrAllProjectsToWeatherUndergroundReportingStations)) {
			return self::$_arrAllProjectsToWeatherUndergroundReportingStations;
		} else {
			return null;
		}
	}

	public static function setArrAllProjectsToWeatherUndergroundReportingStations($arrAllProjectsToWeatherUndergroundReportingStations)
	{
		self::$_arrAllProjectsToWeatherUndergroundReportingStations = $arrAllProjectsToWeatherUndergroundReportingStations;
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
	 * Find by primary key (`project_id`,`weather_underground_reporting_station_id`).
	 *
	 * @param string $database
	 * @param int $project_id
	 * @param int $weather_underground_reporting_station_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findByProjectIdAndWeatherUndergroundReportingStationId($database, $project_id, $weather_underground_reporting_station_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	p2wurs.*

FROM `projects_to_weather_underground_reporting_stations` p2wurs
WHERE p2wurs.`project_id` = ?
AND p2wurs.`weather_underground_reporting_station_id` = ?
";
		$arrValues = array($project_id, $weather_underground_reporting_station_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row && !empty($row)) {
			$projectToWeatherUndergroundReportingStation = self::instantiateOrm($database, 'ProjectToWeatherUndergroundReportingStation', $row);
			/* @var $projectToWeatherUndergroundReportingStation ProjectToWeatherUndergroundReportingStation */
			return $projectToWeatherUndergroundReportingStation;
		} else {
			return false;
		}
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Find by primary key (`project_id`,`weather_underground_reporting_station_id`) Extended.
	 *
	 * @param string $database
	 * @param int $project_id
	 * @param int $weather_underground_reporting_station_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findByProjectIdAndWeatherUndergroundReportingStationIdExtended($database, $project_id, $weather_underground_reporting_station_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	p2wurs_fk_p.`id` AS 'p2wurs_fk_p__project_id',
	p2wurs_fk_p.`project_type_id` AS 'p2wurs_fk_p__project_type_id',
	p2wurs_fk_p.`user_company_id` AS 'p2wurs_fk_p__user_company_id',
	p2wurs_fk_p.`user_custom_project_id` AS 'p2wurs_fk_p__user_custom_project_id',
	p2wurs_fk_p.`project_name` AS 'p2wurs_fk_p__project_name',
	p2wurs_fk_p.`project_owner_name` AS 'p2wurs_fk_p__project_owner_name',
	p2wurs_fk_p.`latitude` AS 'p2wurs_fk_p__latitude',
	p2wurs_fk_p.`longitude` AS 'p2wurs_fk_p__longitude',
	p2wurs_fk_p.`address_line_1` AS 'p2wurs_fk_p__address_line_1',
	p2wurs_fk_p.`address_line_2` AS 'p2wurs_fk_p__address_line_2',
	p2wurs_fk_p.`address_line_3` AS 'p2wurs_fk_p__address_line_3',
	p2wurs_fk_p.`address_line_4` AS 'p2wurs_fk_p__address_line_4',
	p2wurs_fk_p.`address_city` AS 'p2wurs_fk_p__address_city',
	p2wurs_fk_p.`address_county` AS 'p2wurs_fk_p__address_county',
	p2wurs_fk_p.`address_state_or_region` AS 'p2wurs_fk_p__address_state_or_region',
	p2wurs_fk_p.`address_postal_code` AS 'p2wurs_fk_p__address_postal_code',
	p2wurs_fk_p.`address_postal_code_extension` AS 'p2wurs_fk_p__address_postal_code_extension',
	p2wurs_fk_p.`address_country` AS 'p2wurs_fk_p__address_country',
	p2wurs_fk_p.`building_count` AS 'p2wurs_fk_p__building_count',
	p2wurs_fk_p.`unit_count` AS 'p2wurs_fk_p__unit_count',
	p2wurs_fk_p.`gross_square_footage` AS 'p2wurs_fk_p__gross_square_footage',
	p2wurs_fk_p.`net_rentable_square_footage` AS 'p2wurs_fk_p__net_rentable_square_footage',
	p2wurs_fk_p.`is_active_flag` AS 'p2wurs_fk_p__is_active_flag',
	p2wurs_fk_p.`public_plans_flag` AS 'p2wurs_fk_p__public_plans_flag',
	p2wurs_fk_p.`prevailing_wage_flag` AS 'p2wurs_fk_p__prevailing_wage_flag',
	p2wurs_fk_p.`city_business_license_required_flag` AS 'p2wurs_fk_p__city_business_license_required_flag',
	p2wurs_fk_p.`is_internal_flag` AS 'p2wurs_fk_p__is_internal_flag',
	p2wurs_fk_p.`project_contract_date` AS 'p2wurs_fk_p__project_contract_date',
	p2wurs_fk_p.`project_start_date` AS 'p2wurs_fk_p__project_start_date',
	p2wurs_fk_p.`project_completed_date` AS 'p2wurs_fk_p__project_completed_date',
	p2wurs_fk_p.`sort_order` AS 'p2wurs_fk_p__sort_order',

	p2wurs_fk_wurs.`id` AS 'p2wurs_fk_wurs__weather_underground_reporting_station_id',
	p2wurs_fk_wurs.`weather_reporting_station` AS 'p2wurs_fk_wurs__weather_reporting_station',
	p2wurs_fk_wurs.`latitude` AS 'p2wurs_fk_wurs__latitude',
	p2wurs_fk_wurs.`longitude` AS 'p2wurs_fk_wurs__longitude',
	p2wurs_fk_wurs.`elevation` AS 'p2wurs_fk_wurs__elevation',
	p2wurs_fk_wurs.`address_city` AS 'p2wurs_fk_wurs__address_city',
	p2wurs_fk_wurs.`address_state_or_region` AS 'p2wurs_fk_wurs__address_state_or_region',
	p2wurs_fk_wurs.`address_country` AS 'p2wurs_fk_wurs__address_country',
	p2wurs_fk_wurs.`sort_order` AS 'p2wurs_fk_wurs__sort_order',

	p2wurs.*

FROM `projects_to_weather_underground_reporting_stations` p2wurs
	INNER JOIN `projects` p2wurs_fk_p ON p2wurs.`project_id` = p2wurs_fk_p.`id`
	INNER JOIN `weather_underground_reporting_stations` p2wurs_fk_wurs ON p2wurs.`weather_underground_reporting_station_id` = p2wurs_fk_wurs.`id`
WHERE p2wurs.`project_id` = ?
AND p2wurs.`weather_underground_reporting_station_id` = ?
";
		$arrValues = array($project_id, $weather_underground_reporting_station_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row && !empty($row)) {
			$projectToWeatherUndergroundReportingStation = self::instantiateOrm($database, 'ProjectToWeatherUndergroundReportingStation', $row);
			/* @var $projectToWeatherUndergroundReportingStation ProjectToWeatherUndergroundReportingStation */
			$projectToWeatherUndergroundReportingStation->convertPropertiesToData();

			if (isset($row['project_id'])) {
				$project_id = $row['project_id'];
				$row['p2wurs_fk_p__id'] = $project_id;
				$project = self::instantiateOrm($database, 'Project', $row, null, $project_id, 'p2wurs_fk_p__');
				/* @var $project Project */
				$project->convertPropertiesToData();
			} else {
				$project = false;
			}
			$projectToWeatherUndergroundReportingStation->setProject($project);

			if (isset($row['weather_underground_reporting_station_id'])) {
				$weather_underground_reporting_station_id = $row['weather_underground_reporting_station_id'];
				$row['p2wurs_fk_wurs__id'] = $weather_underground_reporting_station_id;
				$weatherUndergroundReportingStation = self::instantiateOrm($database, 'WeatherUndergroundReportingStation', $row, null, $weather_underground_reporting_station_id, 'p2wurs_fk_wurs__');
				/* @var $weatherUndergroundReportingStation WeatherUndergroundReportingStation */
				$weatherUndergroundReportingStation->convertPropertiesToData();
			} else {
				$weatherUndergroundReportingStation = false;
			}
			$projectToWeatherUndergroundReportingStation->setWeatherUndergroundReportingStation($weatherUndergroundReportingStation);

			return $projectToWeatherUndergroundReportingStation;
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
	 * @param array $arrProjectIdAndWeatherUndergroundReportingStationIdList
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadProjectsToWeatherUndergroundReportingStationsByArrProjectIdAndWeatherUndergroundReportingStationIdList($database, $arrProjectIdAndWeatherUndergroundReportingStationIdList, Input $options=null)
	{
		if (empty($arrProjectIdAndWeatherUndergroundReportingStationIdList)) {
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
		// ORDER BY `project_id` ASC, `weather_underground_reporting_station_id` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpProjectToWeatherUndergroundReportingStation = new ProjectToWeatherUndergroundReportingStation($database);
			$sqlOrderByColumns = $tmpProjectToWeatherUndergroundReportingStation->constructSqlOrderByColumns($arrOrderByAttributes);

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
		foreach ($arrProjectIdAndWeatherUndergroundReportingStationIdList as $k => $arrTmp) {
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
		if (count($arrProjectIdAndWeatherUndergroundReportingStationIdList) > 1) {
			$sqlWhere = join($arrSqlWhere, ' OR ');
			$sqlWhere = "WHERE ($sqlWhere)";
		} else {
			$sqlWhere = "WHERE $tmpInnerAnd";
		}

		$query =
"
SELECT

	p2wurs.*

FROM `projects_to_weather_underground_reporting_stations` p2wurs
{$sqlWhere}{$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrProjectsToWeatherUndergroundReportingStationsByArrProjectIdAndWeatherUndergroundReportingStationIdList = array();
		while ($row = $db->fetch()) {
			$projectToWeatherUndergroundReportingStation = self::instantiateOrm($database, 'ProjectToWeatherUndergroundReportingStation', $row);
			/* @var $projectToWeatherUndergroundReportingStation ProjectToWeatherUndergroundReportingStation */
			$arrProjectsToWeatherUndergroundReportingStationsByArrProjectIdAndWeatherUndergroundReportingStationIdList[] = $projectToWeatherUndergroundReportingStation;
		}

		$db->free_result();

		return $arrProjectsToWeatherUndergroundReportingStationsByArrProjectIdAndWeatherUndergroundReportingStationIdList;
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `projects_to_weather_underground_reporting_stations_fk_p` foreign key (`project_id`) references `projects` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $project_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadProjectsToWeatherUndergroundReportingStationsByProjectId($database, $project_id, Input $options=null)
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
			self::$_arrProjectsToWeatherUndergroundReportingStationsByProjectId = null;
		}

		$arrProjectsToWeatherUndergroundReportingStationsByProjectId = self::$_arrProjectsToWeatherUndergroundReportingStationsByProjectId;
		if (isset($arrProjectsToWeatherUndergroundReportingStationsByProjectId) && !empty($arrProjectsToWeatherUndergroundReportingStationsByProjectId)) {
			return $arrProjectsToWeatherUndergroundReportingStationsByProjectId;
		}

		$project_id = (int) $project_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `project_id` ASC, `weather_underground_reporting_station_id` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpProjectToWeatherUndergroundReportingStation = new ProjectToWeatherUndergroundReportingStation($database);
			$sqlOrderByColumns = $tmpProjectToWeatherUndergroundReportingStation->constructSqlOrderByColumns($arrOrderByAttributes);

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
	p2wurs.*

FROM `projects_to_weather_underground_reporting_stations` p2wurs
WHERE p2wurs.`project_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `project_id` ASC, `weather_underground_reporting_station_id` ASC
		$arrValues = array($project_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrProjectsToWeatherUndergroundReportingStationsByProjectId = array();
		while ($row = $db->fetch()) {
			$projectToWeatherUndergroundReportingStation = self::instantiateOrm($database, 'ProjectToWeatherUndergroundReportingStation', $row);
			/* @var $projectToWeatherUndergroundReportingStation ProjectToWeatherUndergroundReportingStation */
			$arrProjectsToWeatherUndergroundReportingStationsByProjectId[] = $projectToWeatherUndergroundReportingStation;
		}

		$db->free_result();

		self::$_arrProjectsToWeatherUndergroundReportingStationsByProjectId = $arrProjectsToWeatherUndergroundReportingStationsByProjectId;

		return $arrProjectsToWeatherUndergroundReportingStationsByProjectId;
	}

	/**
	 * Load by constraint `projects_to_weather_underground_reporting_stations_fk_wurs` foreign key (`weather_underground_reporting_station_id`) references `weather_underground_reporting_stations` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $weather_underground_reporting_station_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadProjectsToWeatherUndergroundReportingStationsByWeatherUndergroundReportingStationId($database, $weather_underground_reporting_station_id, Input $options=null)
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
			self::$_arrProjectsToWeatherUndergroundReportingStationsByWeatherUndergroundReportingStationId = null;
		}

		$arrProjectsToWeatherUndergroundReportingStationsByWeatherUndergroundReportingStationId = self::$_arrProjectsToWeatherUndergroundReportingStationsByWeatherUndergroundReportingStationId;
		if (isset($arrProjectsToWeatherUndergroundReportingStationsByWeatherUndergroundReportingStationId) && !empty($arrProjectsToWeatherUndergroundReportingStationsByWeatherUndergroundReportingStationId)) {
			return $arrProjectsToWeatherUndergroundReportingStationsByWeatherUndergroundReportingStationId;
		}

		$weather_underground_reporting_station_id = (int) $weather_underground_reporting_station_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `project_id` ASC, `weather_underground_reporting_station_id` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpProjectToWeatherUndergroundReportingStation = new ProjectToWeatherUndergroundReportingStation($database);
			$sqlOrderByColumns = $tmpProjectToWeatherUndergroundReportingStation->constructSqlOrderByColumns($arrOrderByAttributes);

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
	p2wurs.*

FROM `projects_to_weather_underground_reporting_stations` p2wurs
WHERE p2wurs.`weather_underground_reporting_station_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `project_id` ASC, `weather_underground_reporting_station_id` ASC
		$arrValues = array($weather_underground_reporting_station_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrProjectsToWeatherUndergroundReportingStationsByWeatherUndergroundReportingStationId = array();
		while ($row = $db->fetch()) {
			$projectToWeatherUndergroundReportingStation = self::instantiateOrm($database, 'ProjectToWeatherUndergroundReportingStation', $row);
			/* @var $projectToWeatherUndergroundReportingStation ProjectToWeatherUndergroundReportingStation */
			$arrProjectsToWeatherUndergroundReportingStationsByWeatherUndergroundReportingStationId[] = $projectToWeatherUndergroundReportingStation;
		}

		$db->free_result();

		self::$_arrProjectsToWeatherUndergroundReportingStationsByWeatherUndergroundReportingStationId = $arrProjectsToWeatherUndergroundReportingStationsByWeatherUndergroundReportingStationId;

		return $arrProjectsToWeatherUndergroundReportingStationsByWeatherUndergroundReportingStationId;
	}

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all projects_to_weather_underground_reporting_stations records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllProjectsToWeatherUndergroundReportingStations($database, Input $options=null)
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
			self::$_arrAllProjectsToWeatherUndergroundReportingStations = null;
		}

		$arrAllProjectsToWeatherUndergroundReportingStations = self::$_arrAllProjectsToWeatherUndergroundReportingStations;
		if (isset($arrAllProjectsToWeatherUndergroundReportingStations) && !empty($arrAllProjectsToWeatherUndergroundReportingStations)) {
			return $arrAllProjectsToWeatherUndergroundReportingStations;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `project_id` ASC, `weather_underground_reporting_station_id` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpProjectToWeatherUndergroundReportingStation = new ProjectToWeatherUndergroundReportingStation($database);
			$sqlOrderByColumns = $tmpProjectToWeatherUndergroundReportingStation->constructSqlOrderByColumns($arrOrderByAttributes);

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
	p2wurs.*

FROM `projects_to_weather_underground_reporting_stations` p2wurs{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `project_id` ASC, `weather_underground_reporting_station_id` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllProjectsToWeatherUndergroundReportingStations = array();
		while ($row = $db->fetch()) {
			$projectToWeatherUndergroundReportingStation = self::instantiateOrm($database, 'ProjectToWeatherUndergroundReportingStation', $row);
			/* @var $projectToWeatherUndergroundReportingStation ProjectToWeatherUndergroundReportingStation */
			$arrAllProjectsToWeatherUndergroundReportingStations[] = $projectToWeatherUndergroundReportingStation;
		}

		$db->free_result();

		self::$_arrAllProjectsToWeatherUndergroundReportingStations = $arrAllProjectsToWeatherUndergroundReportingStations;

		return $arrAllProjectsToWeatherUndergroundReportingStations;
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
INTO `projects_to_weather_underground_reporting_stations`
(`project_id`, `weather_underground_reporting_station_id`)
VALUES (?, ?)
";
		$arrValues = array($this->project_id, $this->weather_underground_reporting_station_id);
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

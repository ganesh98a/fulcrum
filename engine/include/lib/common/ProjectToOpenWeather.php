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
 * ProjectToOpenWeather.
 *
 * @category   Framework
 * @package    ProjectToOpenWeather
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class ProjectToOpenWeather extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'ProjectToOpenWeather';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'project_to_open_weather';

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
		'id' => 'project_to_open_weather_id',
		'project_id' => 'project_id',
		'latitude' => 'latitude',
		'longitude' => 'longitude',
		'address_code' => 'address_code',
		'address_country' => 'address_country',
		'address_city' => 'address_city',
		'created' => 'created',
		'temperature' => 'temperature'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $project_to_open_weather_id;

	public $project_id;

	public $latitude;

	public $longitude;

	public $address_code;

	public $address_country;

	public $address_city;

	public $created;

	public $temperature;
	

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllProjectsToOpenWeatherLabels;

	// Foreign Key Objects

	/**
	 * Constructor
	 */
	public function __construct($database, $table='project_to_open_weather')
	{
		parent::__construct($table);
		$this->setDatabase($database);
	}

	// Foreign Key Object Accessor Methods

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllProjectsToOpenWeatherLabels()
	{
		if (isset(self::$_arrAllProjectsToOpenWeatherLabels)) {
			return self::$_arrAllProjectsToOpenWeatherLabels;
		} else {
			return null;
		}
	}

	public static function setArrAllProjectsToOpenWeatherLabels($_arrAllProjectsToOpenWeatherLabels)
	{
		self::$_arrAllProjectsToOpenWeatherLabels = $_arrAllProjectsToOpenWeatherLabels;
	}

	

	// Finder: Find By pk (a single auto int id or a single non auto int pk)
	/**
	 * PHP < 5.3.0
	 *
	 * @param string $database
	 * @param int $project_to_open_weather_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findById($database, $project_to_open_weather_id,$table='weather_underground_condition_labels', $module='ProjectToOpenWeather')
	{
		$ProjectToOpenWeather = parent::findById($database, $project_to_open_weather_id, $table, $module);

		return $ProjectToOpenWeather;
	}

	
	// Finders: Find By Unique Index
	/**
	 * Find by unique index `unique_weather_condition_label` (`weather_condition_label`).
	 *
	 * @param string $database
	 * @param string $project_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findByWeatherprojectId($database, $project_id,$created)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	pow.*

FROM `project_to_open_weather` pow
WHERE pow.`project_id` = ? and DATE(pow.`created`) = ?
";
		$arrValues = array($project_id,$created);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if ($row && !empty($row)) {
			$project_to_open_weather_id = $row['id'];
			$ProjectToOpenWeather = self::instantiateOrm($database, 'ProjectToOpenWeather', $row, null, $project_to_open_weather_id);
			/* @var $ProjectToOpenWeather ProjectToOpenWeather */
			return $ProjectToOpenWeather;
		} else {
			return false;
		}
	}

	public static function findByProjectIdAndWeatherbyAddressCode($database, $project_id, $addresscode)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	p2wurs.*

FROM `project_to_open_weather` p2wurs
WHERE p2wurs.`project_id` = ?
AND p2wurs.`address_code` = ?
";
		$arrValues = array($project_id, $addresscode);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row && !empty($row)) {
			$ProjectToOpenWeather = self::instantiateOrm($database, 'ProjectToOpenWeather', $row);
			/* @var $ProjectToOpenWeather ProjectToOpenWeather */
			return $ProjectToOpenWeather;
		} else {
			return false;
		}
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
INTO `project_to_open_weather`
( `project_id`, `latitude`, `longitude`, `address_code`, `address_country`, `address_city`, `created`,`temperature`)VALUES (?, ?, ?, ?, ?, ?, ?, ?)
";
		$arrValues = array($this->project_id, $this->latitude, $this->longitude, $this->address_code, $this->address_country, $this->address_city, $this->created ,$this->temperature);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$project_to_open_weather_id = $db->insertId;
		$db->free_result();

		return $project_to_open_weather_id;
	}

	// Save: insert ignore
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

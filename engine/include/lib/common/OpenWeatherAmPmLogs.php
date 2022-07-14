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
 * OpenWeatherAmPmLogs.
 *
 * @category   Framework
 * @package    OpenWeatherAmPmLogs
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class OpenWeatherAmPmLogs extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'OpenWeatherAmPmLogs';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'open_weather_am_pm_logs';

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
		'id' => 'open_weather_am_pm_log_id',

		'address_code' => 'address_code',
		'am_weather_underground_condition_label_id' => 'am_weather_underground_condition_label_id',
		'pm_weather_underground_condition_label_id' => 'pm_weather_underground_condition_label_id',

		'created' => 'created',

		'am_temperature' => 'am_temperature',
		'pm_temperature' => 'pm_temperature'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $open_weather_am_pm_log_id;
	public $address_code;
	public $am_weather_underground_condition_label_id;
	public $pm_weather_underground_condition_label_id;
	public $created;
	public $am_temperature;
	public $pm_temperature;

	
	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllOpenWeatherAmPmLogs;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='open_weather_am_pm_logs')
	{
		parent::__construct($table);
		$this->setDatabase($database);
	}

	
	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)
	public static function getArrAllOpenWeatherAmPmLogs()
	{
		if (isset(self::$_arrAllOpenWeatherAmPmLogs)) {
			return self::$_arrAllOpenWeatherAmPmLogs;
		} else {
			return null;
		}
	}

	public static function setArrAllOpenWeatherAmPmLogs($arrAllOpenWeatherAmPmLogs)
	{
		self::$_arrAllOpenWeatherAmPmLogs = $_arrAllOpenWeatherAmPmLogs;
	}

	// Finder: Find By pk (a single auto int id or a single non auto int pk)
	/**
	 * PHP < 5.3.0
	 *
	 * @param string $database
	 * @param int $weather_underground_am_pm_log_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findById($database, $open_weather_am_pm_log_id,$table='open_weather_am_pm_logs', $module='OpenWeatherAmPmLogs')
	{
		$OpenWeatherAmPmLogs = parent::findById($database, $open_weather_am_pm_log_id,$table, $module);

		return $OpenWeatherAmPmLogs;
	}

	

	// Finders: Find By Unique Index
	/**
	 * Find by unique index `unique_weather_underground_am_pm_log` (`address_code`,`created`).
	 *
	 * @param string $database
	 * @param int $address_code
	 * @param string $created
	 * @return mixed (single ORM object | false)
	 */
	public static function findByOpenWeatherAddressCodeAndCreated($database, $address_code, $created)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	owapl.*

FROM `open_weather_am_pm_logs` owapl
WHERE owapl.`address_code` = ?
AND owapl.`created` = ?
";
		$arrValues = array($address_code, $created);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if ($row && !empty($row)) {
			$open_weather_am_pm_log_id = $row['id'];
			$OpenWeatherAmPmLogs = self::instantiateOrm($database, 'OpenWeatherAmPmLogs', $row, null, $open_weather_am_pm_log_id);
			/* @var $OpenWeatherAmPmLogs OpenWeatherAmPmLogs */
			return $OpenWeatherAmPmLogs;
		} else {
			return false;
		}
	}

	// Save: insert ignore

	/**
	 * Similar to FindById, but with SQL as starter code for more complex joins.
	 *
	 * @param string $database
	 * @return mixed (single ORM object | false)
	 */
	public static function loadAmPmOpenWeatherByProjectId($database, $project_id, $date=null)
	{
		if (!isset($date)) {
			$date = 'CURDATE()';
		}
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */
		

			$amQueryFilter ="inner join `weather_underground_condition_labels` as wucl on owap.am_weather_underground_condition_label_id =wucl.`id`";

			$amWhere ="and owap.`am_temperature` is not null";

			$pmQueryFilter =" inner join `weather_underground_condition_labels` as wucl on owap.pm_weather_underground_condition_label_id =wucl.`id`";

			$pmWhere ="and owap.`pm_temperature` is not null";



		$query =
"
SELECT owap.`id` AS open_weather_id , owap.`address_code` , owap.`am_weather_underground_condition_label_id`,owap. `pm_weather_underground_condition_label_id`,owap. `created`,owap. `am_temperature`,owap. `pm_temperature`,
wucl.`id` AS condition_label_id ,wucl. `weather_condition_label`,wucl. `sort_order`,
p2ow.* FROM `project_to_open_weather` as p2ow inner join open_weather_am_pm_logs as owap on p2ow.address_code = owap.address_code  
--find_replace_filter--
 WHERE p2ow.project_id= ? and date(p2ow.created) = ?  and owap.created = ?
--find_where--
";

		$amQuery = str_replace('--find_replace_filter--', $amQueryFilter, $query);
		$amQuery = str_replace('--find_where--', $amWhere, $amQuery);
		$pmQuery = str_replace('--find_replace_filter--', $pmQueryFilter, $query);
		$pmQuery = str_replace('--find_where--', $pmWhere, $pmQuery);
		$arrValues = array($project_id,$date,$date);
		
		$db->execute($amQuery, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		
		$amWeather=array();
		
			if($row['am_temperature'] != NULL)
			{
			$amWeather['condition'] =  $row['weather_condition_label'];
			$amWeather['temperature'] =  $row['am_temperature'];
			$amWeatherMeasurement = $amWeather;
			}else
			{
				$amWeatherMeasurement = false;
			}
			
		
		$db->free_result();

		$db->execute($pmQuery, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		$pmWeather=array();

		
			if($row['pm_temperature'] != NULL)
			{
			$pmWeather['condition'] =  $row['weather_condition_label'];
			$pmWeather['temperature'] =  $row['pm_temperature'];
			$pmWeatherMeasurement = $pmWeather;
		}else
		{
			$pmWeatherMeasurement = false;
		}
			
		


		$arrReturn = array(
			'am' => $amWeatherMeasurement,
			'pm' => $pmWeatherMeasurement,
		);
		

		return $arrReturn;
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
INTO `open_weather_am_pm_logs`
( `address_code`, `am_weather_underground_condition_label_id`, `pm_weather_underground_condition_label_id`, `created`, `am_temperature`, `pm_temperature`)
VALUES (?, ?, ?, ?, ?, ?)
ON DUPLICATE KEY UPDATE `am_weather_underground_condition_label_id` = ?, `pm_weather_underground_condition_label_id` = ?, `am_temperature` = ?, `pm_temperature` = ?
";
		$arrValues = array($this->address_code,  $this->am_weather_underground_condition_label_id, $this->pm_weather_underground_condition_label_id, $this->created, $this->am_temperature, $this->pm_temperature, $this->am_weather_underground_condition_label_id, $this->pm_weather_underground_condition_label_id, $this->am_temperature, $this->pm_temperature);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$open_weather_am_pm_log_id = $db->insertId;
		$db->free_result();

		return $open_weather_am_pm_log_id;
	}

	// Save: insert ignore

	// Function to insert and update weather cron details into Logs.
	public static function loadAmOrPmIntoLogs($database, $project_id, $date, $amOrPm, $zoneTime)
	{
		$db = DBI::getInstance($database);
		$query = "SELECT count(id) as id FROM `dcr_weather_logs` WHERE `project_id`= ? and ( DATE(`dcr_run_date_time`)= ? OR DATE(`am_run_date_time`) = ? OR Date(`pm_run_date_time`) =?)";
		$arrValues = array($project_id,$date,$date,$date);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$count=$row['id'];
		$db->free_result();	

		$dateTime = $date.' '.$zoneTime.':00';

		if ($amOrPm == 'am') {
			$updateData = "`weather_am_flag` = ?,`am_run_date_time` = ?";
			$insertData = "weather_am_flag,am_run_date_time";
		}else{
			$updateData = "`weather_pm_flag` = ?,`pm_run_date_time` = ?";
			$insertData = "weather_pm_flag,pm_run_date_time";
		}

		if ($count == 0) {
			$query1 = 'INSERT INTO dcr_weather_logs (project_id,'.$insertData.') VALUES (?,?,?)';
			$arrValues1 = array($project_id, 'Y', $dateTime);
			$db->execute($query1, $arrValues1, MYSQLI_STORE_RESULT);
			$db->commit();		
			$db->free_result();
		}else{
			$query2 = 'UPDATE dcr_weather_logs SET '.$updateData.' WHERE `project_id`= ? and ( DATE(`dcr_run_date_time`)= ? OR DATE(`am_run_date_time`) = ? OR Date(`pm_run_date_time`) = ?) ';
			$arrValues2 = array('Y',$dateTime,$project_id,$date,$date,$date);
			$db->execute($query2, $arrValues2, MYSQLI_STORE_RESULT);
			$db->commit();			
			$db->free_result();
		}
	}
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

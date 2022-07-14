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

$init['access_level'] = 'anon';
$init['application'] = 'www.axis.com';
$init['cache_control'] = 'nocache';
$init['debugging_mode'] = true;
$init['display'] = false;
$init['https'] = false;
$init['https_admin'] = true;
$init['https_auth'] = true;
$init['no_db_init'] = false;
$init['override_php_ini'] = false;
$init['sapi'] = 'cli';
$init['skip_always_include'] = true;
$init['timer'] = true;
$init['timer_start'] = false;
require_once('lib/common/init.php');

require_once('lib/common/Address.php');
require_once('lib/common/JobsiteDailyLog.php');
require_once('lib/common/Project.php');
require_once('lib/common/Weather/Underground.php');
require_once('lib/common/WeatherUndergroundConditionLabel.php');
require_once('lib/common/ProjectToOpenWeather.php');
require_once('lib/common/OpenWeatherAmPmLogs.php');
require_once('lib/common/DrawActionTypeOptions.php');

// To get all time zone.
$arrTimeZoneTypeOptions = DrawActionTypeOptions::loadAllTimeZone($database);
$time_zone_id = array();
$amOrPm = '';
$zoneTime = '';
$realZoneTime = '';
foreach ($arrTimeZoneTypeOptions as $key => $value) {

	// To get current time based on time zone
	date_default_timezone_set($value['time_zone']);
	$zoneTime = date('H:i');
	
	// To check the morning and evening time
	if ($zoneTime == '07:00' || $zoneTime == '16:00') {
		$timeZoneId = $value['id'];
		array_push($time_zone_id, $timeZoneId);
		$amOrPm = date('a');
		$realZoneTime = $zoneTime;
		//project_to_open_weather
		$created = date('Y-m-d');
	}	
}

echo  date('Y-m-d H:i:s a');
if(empty($time_zone_id)){
	echo 'Time Zone ID is empty';
	die;
}

$arrAllActiveProjects = Project::loadAllActiveProjects($database,$time_zone_id);

// Link projects to weather_underground_reporting_stations via projects_to_weather_underground_reporting_stations
$arrWeatherByZipCode = array();
$arrWeatherReportingStationsToZipCodes = array();
foreach ($arrAllActiveProjects as $project_id => $project) {
	/* @var $project Project */
	
	$address_postal_code = (string) $project->address_postal_code;
	if (empty($address_postal_code)) {
		continue;
	}

	// Weather data.
	// @todo Use lat/lon in addition to address_postal_code and key off of some other location id
	// @todo Use lat/lon to derive address_postal_code if possible (new project may not have zip code?)
	

		$weather = Weather_Underground::fetchWeather($project->address_postal_code);
		if(!empty($weather->cod) && $weather->cod =='404'){
			echo $project->address_postal_code.' Country not found';
			continue;
		}
		/* @var $weather Weather_Underground */

		//new weather variables
		$latitude = $weather->coord->lat;
		$longitude = $weather->coord->lon;
		$address_city = $weather->name;
		$address_country = $weather->sys->country;
		$address_code  = $address_postal_code.'_'.$project_id;
		


	
	// weather conditions
	$weather_condition_label = $weather->weather[0]->main;
	$kelvin_temperature = $weather->main->temp;
	//from kelvin to farenheit
	$temperature =  (9/5)* ($kelvin_temperature - 273) + 32;

	// weather_underground_condition_labels
	$weatherUndergroundConditionLabel = WeatherUndergroundConditionLabel::findByWeatherConditionLabel($database, $weather_condition_label);
	/* @var $weatherUndergroundConditionLabel WeatherUndergroundConditionLabel */

	if ($weatherUndergroundConditionLabel) {
		$weather_underground_condition_label_id = $weatherUndergroundConditionLabel->weather_underground_condition_label_id;
	} else {
		$weatherUndergroundConditionLabel = new WeatherUndergroundConditionLabel($database);
		$data = array(
			'weather_condition_label' => $weather_condition_label
		);
		$weatherUndergroundConditionLabel->setData($data);
		$weather_underground_condition_label_id = $weatherUndergroundConditionLabel->save();
	}

	$ProjectToOpenWeatherdata = ProjectToOpenWeather::findByWeatherprojectId($database, $project_id,$created);

	/* @var $weatherUndergroundConditionLabel WeatherUndergroundConditionLabel */
		if ($ProjectToOpenWeatherdata) {
		$project_to_open_weather_id = $ProjectToOpenWeatherdata->project_to_open_weather_id;
	} else {
		$ProjectToOpenWeatherdata = new ProjectToOpenWeather($database);
		$data = array(
			'project_id' => $project_id,
			'latitude' => $latitude,
			'longitude' => $longitude,
			'latitude' => $latitude,
			'address_code' => $address_code,
			'address_country' => $address_country,
			'address_city' => $address_city,
			'temperature' => $temperature
		);
		$ProjectToOpenWeatherdata->setData($data);
		$project_to_open_weather_id = $ProjectToOpenWeatherdata->save();
		
	}

	//project_to_open_weather
	$OpenWeatherAmPmLogs = OpenWeatherAmPmLogs::findByOpenWeatherAddressCodeAndCreated($database, $address_code, $created);
	if ($OpenWeatherAmPmLogs) {
		$open_weather_am_pm_log_id = $OpenWeatherAmPmLogs->open_weather_am_pm_log_id;
		$address_code = $OpenWeatherAmPmLogs->address_code;
		$am_weather_underground_condition_label_id = $OpenWeatherAmPmLogs->am_weather_underground_condition_label_id;
		$pm_weather_underground_condition_label_id = $OpenWeatherAmPmLogs->pm_weather_underground_condition_label_id;
		$created = $OpenWeatherAmPmLogs->created;
		$am_temperature = $OpenWeatherAmPmLogs->am_temperature;
		$pm_temperature = $OpenWeatherAmPmLogs->pm_temperature;

		// Record afternoon values
		// update
		if (($amOrPm == 'pm') && ($pm_weather_underground_condition_label_id == 1)) {
			$data = array(
				'pm_weather_underground_condition_label_id' => $weather_underground_condition_label_id,
				'pm_temperature' => $temperature
			);
			$OpenWeatherAmPmLogs->setData($data);
			$OpenWeatherAmPmLogs->save();
		}
	} else {
		$OpenWeatherAmPmLogs = new OpenWeatherAmPmLogs($database);
		$data = array(
			'address_code' => $address_code,
			'created' => $created
		);
		if ($amOrPm == 'am') {
			$data['am_weather_underground_condition_label_id'] = $weather_underground_condition_label_id;
			$data['pm_weather_underground_condition_label_id'] = 1;
			$data['am_temperature'] = $temperature;
		} else {
			$data['am_weather_underground_condition_label_id'] = 1;
			$data['pm_weather_underground_condition_label_id'] = $weather_underground_condition_label_id;
			$data['pm_temperature'] = $temperature;
		}
		$OpenWeatherAmPmLogs->setData($data);
		$open_weather_am_pm_log_id = $OpenWeatherAmPmLogs->save();
	}

	// Function to insert and update weather cron details into Logs.
	$loadDCRIntoLogs = OpenWeatherAmPmLogs::loadAmOrPmIntoLogs($database, $project_id, $created, $amOrPm, $realZoneTime);
	

	$arrWeatherObjects = array(
		'weather' => $weather,
		'weather_condition_label' => $weatherUndergroundConditionLabel,
		'address_code' => $address_code,
	);

	$arrWeatherByReportingStations[$address_code] = $arrWeatherObjects;
	$arrAddressPostalCodesToWeatherReportingStations[$address_postal_code] = $address_code;

	// Delay for throttling the weather api calls
	usleep(600);
}

exit;

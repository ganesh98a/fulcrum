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
 * Weather data class. Uses web services/apis.
 *
 * PHP versions 5
 *
 * @category   Framework
 * @package    Weather
 */

/**
 * Web_Robot
 */
require_once('lib/common/Web_Robot.php');

/**
 * Integrated_Mapper
 */
require_once('lib/common/IntegratedMapper.php');

/**
 * Object_Array
 */
require_once('lib/common/ObjectArray.php');

class Weather extends IntegratedMapper
{
	protected static $instance;

	public static function getInstance($domain = 'global')
	{
		if (!isset(self::$instance)) {
			self::$instance = new Geo($domain);
		}
		return self::$instance;
	}

	public static function fetchWeather($zipCode=null, $city=null, $state=null, $source='weatherChannel')
	{
		if (!isset($zipCode) && (!isset($city) || !isset($state))) {
			return;
		}

		switch ($source) {
			case 'weatherUnderground':
				$weather = Weather::fetchWeatherViaWeatherUnderground($zipCode, $city, $state);
				break;
			case 'worldWeatherOnline':
				$weather = Weather::fetchWeatherViaWorldWeatherOnline($zipCode, $city, $state);
				break;
			case 'weatherChannel':
			default:
				$weather = Weather::fetchWeatherViaWeatherChannel($zipCode, $city, $state);
				break;
		}

		return $weather;
	}

	public static function fetchWeatherViaWeatherChannel($zipCode=null, $city=null, $state=null)
	{
		if (!isset($zipCode) && (!isset($city) || !isset($state))) {
			return;
		}

		//Derive zip code if missing
		if (!isset($zipCode) && (isset($city) && isset($state))) {
			$l = Weather::deriveZipCode($city, $state);
			$cityCode = $l[0]['id'];
			$zipCode = $cityCode;
		}

		/*
		$url =
			'http://xoap.weather.com/weather/local/'.
			$zipCode.'?cc=*&dayf=5&link=xoap&prod=xoap&par=1185368780&key=756b075aad5caaa6';
		*/

		$url =
			'http://wxdata.weather.com/wxdata/weather/local/'.
			$zipCode.'?cc=*&dayf=5&link=xoap&prod=xoap&par=1185368780&key=756b075aad5caaa6';

		$bot = new Web_Robot('www.weather.com');
		$bot->initHttp();
		//Don't refresh HTML full text until fully debugged.
		$bot->setNoRefresh(true);
		$client = $bot->getHttpClient();
		/* @var $client Web_Robot_Http_Client */

		//debug
		$content = '';
		$content = $client->fetchContentViaCurl($url);

		$arrContent = preg_split('/[\s]+/', $content, -1, PREG_SPLIT_NO_EMPTY);
		$content = join(' ', $arrContent);

		$matchedFlag = preg_match('/.*(\<weather ver="2.0"\>.+\<\/weather\>)/', $content, $arrMatches);
		if ($matchedFlag) {
			$content = $arrMatches[1];

			//parse xml content
			$xml = simplexml_load_string($content);

			$head = $xml->head;
			$loc = $xml->loc;
			$links = $xml->lnks;
			$cc = $xml->cc;
			$forecast = $xml->dayf;

			/**
			 * Header with units and locale
			 */
			$locale = (string) $head->locale;
			$arrUnits = array(
				'unit_of_temperature' => (string) $head->ut,
				'unit_of_distance' => (string) $head->ud,
				'unit_of_speed' => (string) $head->us,
				'unit_of_pressure' => (string) $head->up,
				'unit_of_precipitation' => (string) $head->ur,
			);

			/**
			 * Location Details
			 */
			//City
			$location = (string) $loc->dnam;
			$latitude = (string) $loc->lat;
			$longitude = (string) $loc->lon;
			$sunrise = (string) $loc->sunr;
			$sunset = (string) $loc->suns;
			$localTime = (string) $loc->tm;
			//UTC offset
			$timeZone = (string) $loc->zone;
			$arrLocation = array(
				'location' => $location,
				'sunrise' => $sunrise,
				'sunset' => $sunset,
				'local_time' => $localTime
			);

			/**
			 * Ad Links
			 */
			$arrTmpLinks = $links->link;
			$arrLinks = array();
			foreach ($arrTmpLinks as $link) {
				$href = (string) $link->l;
				$text = (string) $link->t;
				$arrTmp = array(
					'href' => $href,
					'text' => $text
				);
				$arrLinks[] = $arrTmp;
			}

			/**
			 * Current Conditions (cc)
			 */
			$arrCurrentConditions = array(
				'observation_timestamp' => (string) $cc->lsup,
				'observation_station' => (string) $cc->obst,
				'temperature' => (string) $cc->tmp,
				'temperature_feels_like' => (string) $cc->flik,
				'weather_description' => (string) $cc->t,
				'weather_icon_code' => (string) $cc->icon,
				'barometric_pressure' => (string) $cc->bar->r,
				'barometric_pressure_trend' => (string) $cc->bar->d,
				'wind_speed' => (string) $cc->wind->s,
				'wind_gust' => (string) $cc->wind->gust,
				'wind_direction_degrees' => (string) $cc->wind->d,
				'wind_direction_description' => (string) $cc->wind->t,
				'relative_humidity' => (string) $cc->hmid,
				'visibility' => (string) $cc->vis,
				'uv_index' => (string) $cc->uv->i,
				'uv_description' => (string) $cc->uv->t,
				'dew_point' => (string) $cc->dewp,
				'moon_icon_code' => (string) $cc->moon->icon,
				'moon_phase' => (string) $cc->moon->t
			);

			/**
			 * Weather Forecast (5 Day)
			 */
			$forecastTimestamp = (string) $forecast->lsup;
			$arrDays = $forecast->day;
			$arrFiveDayForecast = array(
				'forecast_timestamp' => $forecastTimestamp
			);

			foreach ($arrDays as $day) {
				//attributes
				$arrDayAttributes = (array) $day->attributes();
				$dayOfWeek = (string) $arrDayAttributes['@attributes']['t'];
				$date = (string) $arrDayAttributes['@attributes']['dt'];
				$dayCounter = (int) $arrDayAttributes['@attributes']['d'];

				//values
				$highTemperature = (string) $day->hi;
				$lowTemperature = (string) $day->low;
				$sunrise= (string) $day->sunr;
				$sunset = (string) $day->suns;

				$arrPart = $day->part;

				//day values
				$dayForecast = $day->part[0];
				$arrTmpDay = array(
					'weather_icon_code' => (string) $dayForecast->icon,
					'weather_description' => (string) $dayForecast->t,
					'wind_speed' => (string) $dayForecast->wind->s,
					'wind_gust' => (string) $dayForecast->wind->gust,
					'wind_direction_degrees' => (string) $dayForecast->wind->d,
					'wind_direction_description' => (string) $dayForecast->wind->t,
					'weather_short_description' => (string) $dayForecast->bt,
					'chance_of_precipitation' => (string) $dayForecast->ppcp,
					'relative_humidity' => (string) $dayForecast->hmid
				);

				//night values
				$nightForecast = $day->part[1];
				$arrTmpNight = array(
					'weather_icon_code' => (string) $nightForecast->icon,
					'weather_description' => (string) $nightForecast->t,
					'wind_speed' => (string) $nightForecast->wind->s,
					'wind_gust' => (string) $nightForecast->wind->gust,
					'wind_direction_degrees' => (string) $nightForecast->wind->d,
					'wind_direction_description' => (string) $nightForecast->wind->t,
					'weather_short_description' => (string) $nightForecast->bt,
					'chance_of_precipitation' => (string) $nightForecast->ppcp,
					'relative_humidity' => (string) $nightForecast->hmid
				);

				$arrTmp = array(
					'day_of_week' => $dayOfWeek,
					'date' => $date,
					'high_temperature' => $highTemperature,
					'low_temperature' => $lowTemperature,
					'sunrise' => $sunrise,
					'sunset' => $sunset,
					'day_forecast' => $arrTmpDay,
					'night_forecast' => $arrTmpNight,

				);

				$arrFiveDayForecast[$dayCounter] = $arrTmp;
			}
		}

		$current_conditions = new Object_Array();
		$current_conditions->setData($arrCurrentConditions);

		$five_day_forecast = new Object_Array();
		$five_day_forecast->setData($arrFiveDayForecast);

		$location = new Object_Array();
		$location->setData($arrLocation);

		$arrWeather = array(
			'current_conditions' => $current_conditions,
			'five_day_forecast' => $five_day_forecast,
			'location' => $location
		);

		$w = new Object_Array();
		$w->setData($arrWeather);
		return $w;
	}

	public static function fetchWeatherViaWorldWeatherOnline($zipCode=null, $city=null, $state=null)
	{
		if (!isset($zipCode) && (!isset($city) || !isset($state))) {
			return;
		}

		//Derive zip code if missing
		if (!isset($zipCode) && (isset($city) && isset($state))) {
			$l = Weather::deriveZipCode($city, $state);
			$cityCode = $l[0]['id'];
			$zipCode = $cityCode;
		}

		$url = 'http://api.worldweatheronline.com/free/v1/weather.ashx?q='.$zipCode.'&format=json&num_of_days=5&key=gffsjgfw4x6ztjaqxnqwpdnv';

		$bot = new Web_Robot('api.worldweatheronline.com');
		$bot->initHttp();
		//Don't refresh HTML full text until fully debugged.
		$bot->setNoRefresh(true);
		$client = $bot->getHttpClient();
		/* @var $client Web_Robot_Http_Client */

		//Debug
		$content = '';

		//$content = $client->fetchContentViaCurl($url);
		$content = $client->fetchContent($url);
		$json = json_decode($content);

		$arrContent = preg_split('/[\s]+/', $content, -1, PREG_SPLIT_NO_EMPTY);
		$content = join(' ', $arrContent);

		$matchedFlag = preg_match('/.*(\<weather ver="2.0"\>.+\<\/weather\>)/', $content, $arrMatches);
		if ($matchedFlag) {
			$content = $arrMatches[1];

			//parse xml content
			$xml = simplexml_load_string($content);

			$head = $xml->head;
			$loc = $xml->loc;
			$links = $xml->lnks;
			$cc = $xml->cc;
			$forecast = $xml->dayf;

			/**
			 * Header with units and locale
			 */
			$locale = (string) $head->locale;
			$arrUnits = array(
				'unit_of_temperature' => (string) $head->ut,
				'unit_of_distance' => (string) $head->ud,
				'unit_of_speed' => (string) $head->us,
				'unit_of_pressure' => (string) $head->up,
				'unit_of_precipitation' => (string) $head->ur,
			);

			/**
			 * Location Details
			 */
			//City
			$location = (string) $loc->dnam;
			$latitude = (string) $loc->lat;
			$longitude = (string) $loc->lon;
			$sunrise = (string) $loc->sunr;
			$sunset = (string) $loc->suns;
			$localTime = (string) $loc->tm;
			//UTC offset
			$timeZone = (string) $loc->zone;
			$arrLocation = array(
				'location' => $location,
				'sunrise' => $sunrise,
				'sunset' => $sunset,
				'local_time' => $localTime
			);

			/**
			 * Ad Links
			 */
			$arrTmpLinks = $links->link;
			$arrLinks = array();
			foreach ($arrTmpLinks as $link) {
				$href = (string) $link->l;
				$text = (string) $link->t;
				$arrTmp = array(
					'href' => $href,
					'text' => $text
				);
				$arrLinks[] = $arrTmp;
			}

			/**
			 * Current Conditions (cc)
			 */
			$arrCurrentConditions = array(
				'observation_timestamp' => (string) $cc->lsup,
				'observation_station' => (string) $cc->obst,
				'temperature' => (string) $cc->tmp,
				'temperature_feels_like' => (string) $cc->flik,
				'weather_description' => (string) $cc->t,
				'weather_icon_code' => (string) $cc->icon,
				'barometric_pressure' => (string) $cc->bar->r,
				'barometric_pressure_trend' => (string) $cc->bar->d,
				'wind_speed' => (string) $cc->wind->s,
				'wind_gust' => (string) $cc->wind->gust,
				'wind_direction_degrees' => (string) $cc->wind->d,
				'wind_direction_description' => (string) $cc->wind->t,
				'relative_humidity' => (string) $cc->hmid,
				'visibility' => (string) $cc->vis,
				'uv_index' => (string) $cc->uv->i,
				'uv_description' => (string) $cc->uv->t,
				'dew_point' => (string) $cc->dewp,
				'moon_icon_code' => (string) $cc->moon->icon,
				'moon_phase' => (string) $cc->moon->t
			);

			/**
			 * Weather Forecast (5 Day)
			 */
			$forecastTimestamp = (string) $forecast->lsup;
			$arrDays = $forecast->day;
			$arrFiveDayForecast = array(
				'forecast_timestamp' => $forecastTimestamp
			);

			foreach ($arrDays as $day) {
				//attributes
				$arrDayAttributes = (array) $day->attributes();
				$dayOfWeek = (string) $arrDayAttributes['@attributes']['t'];
				$date = (string) $arrDayAttributes['@attributes']['dt'];
				$dayCounter = (int) $arrDayAttributes['@attributes']['d'];

				//values
				$highTemperature = (string) $day->hi;
				$lowTemperature = (string) $day->low;
				$sunrise= (string) $day->sunr;
				$sunset = (string) $day->suns;

				$arrPart = $day->part;

				//day values
				$dayForecast = $day->part[0];
				$arrTmpDay = array(
					'weather_icon_code' => (string) $dayForecast->icon,
					'weather_description' => (string) $dayForecast->t,
					'wind_speed' => (string) $dayForecast->wind->s,
					'wind_gust' => (string) $dayForecast->wind->gust,
					'wind_direction_degrees' => (string) $dayForecast->wind->d,
					'wind_direction_description' => (string) $dayForecast->wind->t,
					'weather_short_description' => (string) $dayForecast->bt,
					'chance_of_precipitation' => (string) $dayForecast->ppcp,
					'relative_humidity' => (string) $dayForecast->hmid
				);

				//night values
				$nightForecast = $day->part[1];
				$arrTmpNight = array(
					'weather_icon_code' => (string) $nightForecast->icon,
					'weather_description' => (string) $nightForecast->t,
					'wind_speed' => (string) $nightForecast->wind->s,
					'wind_gust' => (string) $nightForecast->wind->gust,
					'wind_direction_degrees' => (string) $nightForecast->wind->d,
					'wind_direction_description' => (string) $nightForecast->wind->t,
					'weather_short_description' => (string) $nightForecast->bt,
					'chance_of_precipitation' => (string) $nightForecast->ppcp,
					'relative_humidity' => (string) $nightForecast->hmid
				);

				$arrTmp = array(
					'day_of_week' => $dayOfWeek,
					'date' => $date,
					'high_temperature' => $highTemperature,
					'low_temperature' => $lowTemperature,
					'sunrise' => $sunrise,
					'sunset' => $sunset,
					'day_forecast' => $arrTmpDay,
					'night_forecast' => $arrTmpNight,

				);

				$arrFiveDayForecast[$dayCounter] = $arrTmp;
			}
		}

		$current_conditions = new Object_Array();
		$current_conditions->setData($arrCurrentConditions);

		$five_day_forecast = new Object_Array();
		$five_day_forecast->setData($arrFiveDayForecast);

		$location = new Object_Array();
		$location->setData($arrLocation);

		$arrWeather = array(
			'current_conditions' => $current_conditions,
			'five_day_forecast' => $five_day_forecast,
			'location' => $location
		);

		$w = new Object_Array();
		$w->setData($arrWeather);
		return $w;
	}

	// e4555662c067b131
	public static function fetchWeatherViaWeatherUnderground($zipCode=null, $city=null, $state=null)
	{
		$url = 'http://api.wunderground.com/api/e4555662c067b131/geolookup/conditions/lang:EN/pws:1/bestfct:1/q/'.$zipCode.'.json';
		//$url = 'http://api.wunderground.com/api/e4555662c067b131/conditions/lang:EN/pws:1/bestfct:1/q/'.$zipCode.'.json';

		$bot = new Web_Robot('www.wunderground.com');
		$bot->initHttp();
		//Don't refresh HTML full text until fully debugged.
		$bot->setNoRefresh(true);
		$client = $bot->getHttpClient();
		/* @var $client Web_Robot_Http_Client */

		//Debug
		$content = '';

		//$content = $client->fetchContentViaCurl($url);
		$content = $client->fetchContent($url);
		$json = json_decode($content);

		return $json;
	}

	public static function deriveZipCode($city=null, $state=null)
	{
		if (!isset($city) && !isset($state)) {
			return;
		}

		$tmpCity = strtolower($city);
		$tmpState = strtolower($state);

		$encodedCityState = $tmpCity.' '.$tmpState;
		$encodedCityState = urlencode($encodedCityState);

		$url =
			'http://xoap.weather.com/search/search?where='.
			$encodedCityState;

		$bot = new Web_Robot('ad_hoc');
		$bot->initHttp();
		//Don't refresh HTML full text until fully debugged.
		$bot->setNoRefresh(true);
		$client = $bot->getHttpClient();
		/* @var $client Web_Robot_Http_Client */

		//debug
		$content = '';
		$content = $client->fetchContentViaCurl($url);

		$arrContent = preg_split('/[\s]+/', $content, -1, PREG_SPLIT_NO_EMPTY);
		$content = join(' ', $arrContent);

		$matchedFlag = preg_match('/.*(\<search ver="[0-9]{1}\.[0-9]{1}\"\>.+\<\/search\>)/', $content, $arrMatches);
		if ($matchedFlag) {
			$content = $arrMatches[1];

			//parse xml content
			$xml = simplexml_load_string($content);

			$arrLoc = $xml->loc;

			/**
			 * Location Details
			 */
			$arrLocation = array();
			foreach ($arrLoc as $loc) {
				$arrTmpLoc = (array) $loc;

				//attributes
				$arrAttributes = (array) $loc->attributes();
				$id = (string) $arrAttributes['@attributes']['id'];
				$type = (string) $arrAttributes['@attributes']['type'];

				//values
				$location = (string) $arrTmpLoc[0];
				$arrTmp = array(
					'location' => $location,
					'id' => $id
				);
				$arrLocation[] = $arrTmp;
			}
		}

		$l = new Object_Array();
		$l->setData($arrLocation);
		return $l;
	}
}

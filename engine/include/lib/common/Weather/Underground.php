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
 * Weather
 */
require_once('lib/common/Weather.php');

class Weather_Underground extends Weather
{

	private static $_arrTerms = array(
		'tempm' => 'Temp in C',
		'tempi' => 'Temp in F',
		'dewptm' => 'Dewpoint in C',
		'dewpti' => 'Duepoint in F',
		'hum' => 'Humidity %',
		'wspdm' => 'WindSpeed kph',
		'wspdi' => 'Windspeed in mph',
		'wgustm' => 'Wind gust in kph',
		'wgusti' => 'Wind gust in mph',
		'wdird' => 'Wind direction in degrees',
		'wdire' => 'Wind direction description (ie, SW, NNE)',
		'vism' => 'Visibility in Km',
		'visi' => 'Visability in Miles',
		'pressurem' => 'Pressure in mBar',
		'pressurei' => 'Pressure in inHg',
		'windchillm' => 'Wind chill in C',
		'windchilli' => 'Wind chill in F',
		'heatindexm' => 'Heat index C',
		'heatindexi' => 'Heat Index F',
		'precipm' => 'Precipitation in mm',
		'precipi' => 'Precipitation in inches',
		'pop' => 'Probability of Precipitation',
		'conds' => 'See possible condition phrases below',
	);

	public function getArrTerms()
	{
		$arrTerms = self::$_arrTerms;

		return $arrTerms;
	}

	private static $_arrWeatherConditions = array(
		'' => 1,
		'Blowing Sand' => 2,
		'Blowing Snow' => 3,
		'Blowing Widespread Dust' => 4,
		'Clear' => 5,
		'Drizzle' => 6,
		'Dust Whirls' => 7,
		'Fog' => 8,
		'Fog Patches' => 9,
		'Freezing Drizzle' => 10,
		'Freezing Fog' => 11,
		'Freezing Rain' => 12,
		'Funnel Cloud' => 13,
		'Hail' => 14,
		'Hail Showers' => 15,
		'Haze' => 16,
		'Heavy Blowing Sand' => 17,
		'Heavy Blowing Snow' => 18,
		'Heavy Blowing Widespread Dust' => 19,
		'Heavy Drizzle' => 20,
		'Heavy Dust Whirls' => 21,
		'Heavy Fog' => 22,
		'Heavy Fog Patches' => 23,
		'Heavy Freezing Drizzle' => 24,
		'Heavy Freezing Fog' => 25,
		'Heavy Freezing Rain' => 26,
		'Heavy Hail' => 27,
		'Heavy Hail Showers' => 28,
		'Heavy Haze' => 29,
		'Heavy Ice Crystals' => 30,
		'Heavy Ice Pellet Showers' => 31,
		'Heavy Ice Pellets' => 32,
		'Heavy Low Drifting Sand' => 33,
		'Heavy Low Drifting Snow' => 34,
		'Heavy Low Drifting Widespread ' => 35,
		'Heavy Mist' => 36,
		'Heavy Rain' => 37,
		'Heavy Rain Mist' => 38,
		'Heavy Rain Showers' => 39,
		'Heavy Sand' => 40,
		'Heavy Sandstorm' => 41,
		'Heavy Small Hail Showers' => 42,
		'Heavy Smoke' => 43,
		'Heavy Snow' => 44,
		'Heavy Snow Blowing Snow Mist' => 45,
		'Heavy Snow Grains' => 46,
		'Heavy Snow Showers' => 47,
		'Heavy Spray' => 48,
		'Heavy Thunderstorm' => 49,
		'Heavy Thunderstorms and Ice Pe' => 50,
		'Heavy Thunderstorms and Rain' => 51,
		'Heavy Thunderstorms and Snow' => 52,
		'Heavy Thunderstorms with Hail' => 53,
		'Heavy Thunderstorms with Small' => 54,
		'Heavy Volcanic Ash' => 55,
		'Heavy Widespread Dust' => 56,
		'Ice Crystals' => 57,
		'Ice Pellet Showers' => 58,
		'Ice Pellets' => 59,
		'Light Blowing Sand' => 60,
		'Light Blowing Snow' => 61,
		'Light Blowing Widespread Dust' => 62,
		'Light Drizzle' => 63,
		'Light Dust Whirls' => 64,
		'Light Fog' => 65,
		'Light Fog Patches' => 66,
		'Light Freezing Drizzle' => 67,
		'Light Freezing Fog' => 68,
		'Light Freezing Rain' => 69,
		'Light Hail' => 70,
		'Light Hail Showers' => 71,
		'Light Haze' => 72,
		'Light Ice Crystals' => 73,
		'Light Ice Pellet Showers' => 74,
		'Light Ice Pellets' => 75,
		'Light Low Drifting Sand' => 76,
		'Light Low Drifting Snow' => 77,
		'Light Low Drifting Widespread ' => 78,
		'Light Mist' => 79,
		'Light Rain' => 80,
		'Light Rain Mist' => 81,
		'Light Rain Showers' => 82,
		'Light Sand' => 83,
		'Light Sandstorm' => 84,
		'Light Small Hail Showers' => 85,
		'Light Smoke' => 86,
		'Light Snow' => 87,
		'Light Snow Blowing Snow Mist' => 88,
		'Light Snow Grains' => 89,
		'Light Snow Showers' => 90,
		'Light Spray' => 91,
		'Light Thunderstorm' => 92,
		'Light Thunderstorms and Ice Pe' => 93,
		'Light Thunderstorms and Rain' => 94,
		'Light Thunderstorms and Snow' => 95,
		'Light Thunderstorms with Hail' => 96,
		'Light Thunderstorms with Small' => 97,
		'Light Volcanic Ash' => 98,
		'Light Widespread Dust' => 99,
		'Low Drifting Sand' => 100,
		'Low Drifting Snow' => 101,
		'Low Drifting Widespread Dust' => 102,
		'Mist' => 103,
		'Mostly Cloudy' => 104,
		'Overcast' => 105,
		'Partial Fog' => 106,
		'Partly Cloudy' => 107,
		'Patches of Fog' => 108,
		'Rain' => 109,
		'Rain Mist' => 110,
		'Rain Showers' => 111,
		'Sand' => 112,
		'Sandstorm' => 113,
		'Scattered Clouds' => 114,
		'Shallow Fog' => 115,
		'Small Hail' => 116,
		'Small Hail Showers' => 117,
		'Smoke' => 118,
		'Snow' => 119,
		'Snow Blowing Snow Mist' => 120,
		'Snow Grains' => 121,
		'Snow Showers' => 122,
		'Spray' => 123,
		'Squalls' => 124,
		'Thunderstorm' => 125,
		'Thunderstorms and Ice Pellets' => 126,
		'Thunderstorms and Rain' => 127,
		'Thunderstorms and Snow' => 128,
		'Thunderstorms with Hail' => 129,
		'Thunderstorms with Small Hail' => 130,
		'Unknown' => 131,
		'Unknown Precipitation' => 132,
		'Volcanic Ash' => 133,
		'Widespread Dust' => 134
	);

	public function getWeatherConditions()
	{
		$arrWeatherConditions = self::$_arrWeatherConditions;

		return $arrWeatherConditions;
	}

	// e4555662c067b131
	public static function fetchWeather($zipCode=null, $city=null, $state=null, $source='weatherChannel')
	{
		$url = 'http://api.openweathermap.org/data/2.5/weather?zip='.$zipCode.'&appid=9033ca8aaaaa8018e34956ed7febc6ef';
		// echo "<br><br>apiz call : ".$url = 'http://api.wunderground.com/api/e4555662c067b131/geolookup/conditions/lang:EN/pws:1/bestfct:1/q/'.$zipCode.'.json';
		//$url = 'http://api.wunderground.com/api/e4555662c067b131/conditions/history/lang:EN/pws:1/bestfct:1/q/'.$zipCode.'.json';

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

		// Debug / Test
		//require_once('Zend/Json.php');
		//$json = Zend_Json::decode($content);

		return $json;
	}
}

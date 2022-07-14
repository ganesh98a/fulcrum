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
 * GeoLocation data class. IP Delivery based upon users ip address.
 *
 * Uses MaxMind data/api.
 *
 * PHP versions 5
 *
 * @category   GeoLocation
 * @package    GeoLocation
 */

/**
 * @see IntegratedMapper
 */
//Already Included...commented out for performance gain
//require_once('lib/common/IntegratedMapper.php');

class GeoLocation extends IntegratedMapper
{
	private static $_instance;

	public $ipAddress;
	public $latitude;
	public $longitude;

	public $twoLetterCountryCode;
	public $threeLetterCountryCode;
	public $country;
	public $region;
	public $city;
	public $postalCode;
	public $metroCode;
	public $areaCode;
	public $continentCode;
	public $dmaCode;

	/**
	 * Constructor.
	 *
	 * @return void
	 *
	 */
	public function __construct()
	{
		/**
		 * MaxMind api.
		 */
		require_once('lib/common/GeoLocation/geoipcity.inc');

		$config = Application::getInstance()->getConfig();
		$baseDir = $config->system->base_directory;
		$geoFilePath = $baseDir.'engine/include/lib/common/GeoLocation/Data/GeoLiteCity.dat';
		//echo $geoFilePath;
		$geo = geoip_open($geoFilePath, GEOIP_STANDARD);

		// Debug
		//$ip_address = '24.24.24.24';
		//$ip_address = '66.10.88.2';
		//$ip_address = '199.255.44.5';
		//$ip_address = '174.67.218.120';
		$ip_address = '98.189.243.66';

		//$ip_address = $_SERVER['REMOTE_ADDR'];
		$this->ipAddress = $ip_address;

		$geoCity = geoip_record_by_addr($geo, $ip_address);

		$this->twoLetterCountryCode = $geoCity->country_code;
		$this->threeLetterCountryCode = $geoCity->country_code3;
		$this->country = $geoCity->country_name;
		if (isset($GEOIP_REGION_NAME[$geoCity->country_code][$geoCity->region])) {
			$this->region = $GEOIP_REGION_NAME[$geoCity->country_code][$geoCity->region];
		} else {
			$this->region = '';
		}
		$this->city = $geoCity->city;
		$this->postalCode = $geoCity->postal_code;
		$this->latitude = $geoCity->latitude;
		$this->longitude = $geoCity->longitude;
		$this->metroCode = $geoCity->metro_code;
		$this->areaCode = $geoCity->area_code;
		$this->continentCode = $geoCity->continent_code;
		$this->dmaCode = $geoCity->dma_code;

		geoip_close($geo);
	}

	public static function getInstance($domain = 'global')
	{
		// Check if a Singleton exists for this class
		$instance = self::$_instance;

		if (!isset($instance) || !($instance instanceof GeoLocation)) {
			$instance = new GeoLocation($domain);
			self::$_instance = $instance;
		}

		return $instance;
	}
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */
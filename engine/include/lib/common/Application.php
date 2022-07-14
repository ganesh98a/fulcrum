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
 * Global application and initialization class.
 *
 * PHP versions 5
 *
 * @category   Application/Initialization
 * @package    Application
 *
 * @see        init.php
 * @see        conf/config.ini
 */

/**
 * AbstractWebToolkit
 */
require_once('lib/common/AbstractWebToolkit.php');

class Application extends AbstractWebToolkit
{
	const LINUX_OS = 'Linux';
	const WINDOWS_OS = 'Windows';

	protected static $_operatingSystem;

	public static function getOperatingSystem()
	{
		if (isset(self::$_operatingSystem)) {
			return self::$_operatingSystem;
		} else {
			$os = PHP_OS;
			if (is_int(stripos($os, 'WIN', 0))) {
				self::$_operatingSystem = self::WINDOWS_OS;
			} else {
				self::$_operatingSystem = self::LINUX_OS;
			}
			return self::$_operatingSystem;
		}
	}

	/**
	 * Static class instance variable for singleton pattern.
	 *
	 * @var Application Object Reference
	 */
	private static $_instance;

	public static $application = 'global';

	public $scriptStartTime;

	private $sessionStartTime;

	private $sessionEndTime;

	private $sessionTotalTime;

	public $uriRequested;

	public static $includesRegistry = array();

	/**
	 * Object reference to Config.
	 *
	 * @var Config
	 */
	private $config;

	/**
	 * Boolean whether config is initialized.
	 *
	 * @var bool
	 */
	private $configInitialized = false;

	/**
	 * $input is a collection of EGPCS objects that are deslashified as neccessary.
	 *
	 * @var Egpcs
	 */
	private $gpc;
	private $gpcInitialized = false;

	private $environment;
	private $get;
	private $post;
	private $cookie;
	private $server;
	private $request;

	private $geo;
	private $geoInitialized = false;

	private $browser;
	private $browserInitialized = false;

	private $ajax;
	private $ajaxInitialized = false;

	private $error;
	private $errorInitialized = false;

	private $php_os;
	private $sapi;
	private $sapiInitialized = false;

	private $uri;
	private $uriInitialized = false;

	private $session;
	private $sessionInitialized = false;

	private $auth;
	private $authInitialized = false;

	private $permissions;
	private $permissionsInitialized = false;

	private $cache;
	private $cacheInitialized = false;

	private $template;
	private $templateInitialized = false;

	private $timer;
	private $timerInitialized = false;

	/**
	 * Configuration inputs
	 *
	 * @var unknown_type
	 */
	private $_scriptParams;
	private $applicationParams;

	private $_application;

	/**
	 * Singleton global application initialization class.  This class could be called Init.
	 *
	 * Only one control object is necessary to initialize a given script for the application
	 * that it belongs to.
	 *
	 * @param string $application
	 * @return Application object reference
	 */
	public static function getInstance($application = 'global')
	{
		$instance = self::$_instance;

		if (!isset($instance)) {
			$instance = new Application($application);
			self::$_instance = $instance;
		}

		return $instance;
	}

	/**
	 * Initialize environment: configuration and uri sections only.
	 *
	 * @return void
	 *
	 */
	private function __construct($application)
	{
		// $application is always set from getInstance() method - defaults to 'global'.
		$this->_application = $application;

		// $_SERVER['REQUEST_TIME'] is not available from CLI
		if (isset($_SERVER['REQUEST_TIME'])) {
			$this->scriptStartTime = $_SERVER['REQUEST_TIME'];
		} else {
			$this->scriptStartTime = time();
		}

		// This is set from initUri()
		/*
		// $_SERVER['SERVER_NAME'] and $_SERVER['REQUEST_URI'] are not available from CLI
		if (isset($_SERVER['SERVER_NAME']) && isset($_SERVER['REQUEST_URI'])) {
			$this->uriRequested = 'http://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
		} else {
			$this->uriRequested = $_SERVER['PHP_SELF'];
		}
		*/
	}

	public function __destruct()
	{
		if (isset($scriptParams['timer']) && $scriptParams['timer']) {
			$timer = $this->timer;
			/* @var $timer Timer */
			$timer->stopTimer();
			$time = $timer->fetchFormattedTimerOutput();
		}

		/**
		 * Need to close session since session_start() is called before
		 * Session::__destruct();
		 *
		 * This prevents mysqli::__destruct from destroying the mysqli object
		 * before the session data is written to the session store.
		 * http://bugs.php.net/bug.php?id=33772
		 */
		if (isset($_SESSION)) {
			session_write_close();
		}
	}

	/**
	 * Initialize environment.
	 *
	 * @return void
	 *
	 */
	public function init($scriptParams = null)
	{
		// Make code gen files accessible and match in diff when deployed
		if (isset($_SERVER['HTTP_HOST']) && isset($_SERVER['PHP_SELF'])) {
			if (($_SERVER['HTTP_HOST'] == 'localdev.example.com') && is_int(strpos($_SERVER['PHP_SELF'], '/auto/'))) {
				$scriptParams['access_level'] = 'anon';
			}
		}

		$this->_scriptParams = $scriptParams;

		// One time require_once for DBI and DBI_mysqli classes
		require_once('lib/common/Model.php');
		if (isset($scriptParams['no_db_init']) && $scriptParams['no_db_init']) {
			// No inclusion of Database/ORM classes
		} else {
			require_once('lib/common/DBI.php');
			require_once('lib/common/DBI/mysqli.php');
			require_once('lib/common/IntegratedMapper.php');
		}

		if (isset($scriptParams['timer']) && $scriptParams['timer']) {
			if (isset($scriptParams['timer_start']) && !$scriptParams['timer_start']) {
				$start = false;
			} else {
				$start = true;
			}
			$this->initTimer($start);
		}

		// Server Application Programming Interface - CLI, CGI, Apache, etc.
		$this->initSapi();

		// Free Up Memory Resources - PHP Variable Cleanup
		$this->initMemory();

		// Config
		$this->initConfig();

		// PHP ini
		$this->initPhpIni();

		// Cache
		$this->initCache();

		// Input (EGPCS) - Filter & Prepare
		$this->initEgpcs();

		// Geo
		if (!(isset($scriptParams['geo']) && ($scriptParams['geo'] == false))) {
			$this->initGeo();
		}

		// Uri
		if (!(isset($scriptParams['uri']) && ($scriptParams['uri'] == false))) {
			$this->initUri();
		}

		// Ajax...bypass for CLI application components.
		if ($this->sapi != 'cli') {
			$this->initAjax($scriptParams);
		}

		// Session...bypass for CLI application components.
		if ($this->sapi != 'cli') {
			$skip_session = false;
			if (isset($scriptParams['skip_session'])) {
				$skip_session = (bool) $scriptParams['skip_session'];
			}

			if (!$skip_session) {
				$this->initSession();
			}
		}

		// Error & Exception Handling
		$this->initError($scriptParams);

		// Authentication & Authorization
		// ...bypass for CLI application components since dependent upon Session.
		if ($this->sapi != 'cli') {
			$this->initSecurity($scriptParams);
		}

		// After Authentication & Authorization, which use cookies, we can verify Input
		if ( (isset($scriptParams['get_required']) && ($scriptParams['get_required'] == true)) ||
			 (isset($scriptParams['post_required']) && ($scriptParams['post_required'] == true)) ) {
			$this->initRequiredInput($scriptParams);
		}

		// Server-side Browser Detection
		if ($this->sapi != 'cli') {
//			$this->initBrowser();
		}

		// Templating Engine
		if (isset($scriptParams['display']) && ($scriptParams['display'] == true)) {
			if (isset($this->config->templating) && $this->config->templating) {
				$skip_templating = false;
				if (isset($scriptParams['skip_templating'])) {
					$skip_templating = (bool) $scriptParams['skip_templating'];
				}

				if (!$skip_templating) {
					$this->initTemplating($scriptParams);
				}
			}

			// Display (Output Buffering)
			if (isset($this->config->display) && $this->config->display) {
				$this->initDisplay();
			}
		}

		//$this->initSite(isset($this->params['domain']) ? $this->params['domain']: null);

		/**
		 * Ensure final Config object is read only.
		 */
		$this->config->setReadOnly();

		/**
		 * Return an array of common objects.
		 * Possibly register within Zend Registry
		 */
		$arrObjectList = array(
								'ajax',
								'auth',
								'cache',
								'config',
								'cookie',
								'error',
								'geo',
								'get',
								'permissions',
								'post',
								'request',
								'session',
								'template',
								'timer',
								'uri'
								);

		// Will be added to the list, but not the Zend_Registry (already added by their init() method).
		// These objects were already added to the Registry due to catch-22 situations.
		$arrObjectsToSkip = array(
			'config' => 1,
			'session' => 1,
			'uri' => 1,
		);
		$arrObjects = array();
		foreach ($arrObjectList as $objectName) {
			if (isset($this->$objectName)) {
				$arrObjects[$objectName] = $this->$objectName;
				if (!isset($arrObjectsToSkip[$objectName])) {
					Zend_Registry::set($objectName, $this->$objectName);
				}
			}
		}

		/**/
		// Custom app-level permissions
		// ...bypass for CLI application components since dependent upon Session.
		if ($this->sapi != 'cli') {
			$this->initPermissions($scriptParams);

			if (isset($scriptParams['access_level'])) {
				$access_level = $scriptParams['access_level'];
			} else {
				$access_level = 'anon';
			}

			if (isset($scriptParams['display'])) {
				$displayFlag = (bool) $scriptParams['display'];
			} else {
				$displayFlag = false;
			}

			if (isset($scriptParams['ajax'])) {
				$ajaxFlag = (bool) $scriptParams['ajax'];
			} else {
				$ajaxFlag = false;
			}

			if (isset($scriptParams['skip_permissions_check'])) {
				$skip_permissions_check = (bool) $scriptParams['skip_permissions_check'];
			} else {
				$skip_permissions_check = false;
			}

			// Check all flags to see if we need to enforce permissions
			// Only enforce permissions for "auth" or "admin" or "global_admin"
			// Only enforce permissions for display scripts
			// Do not enforce permissions for ajax scripts because the URL is not set in the permissions tables -> software_modules / software_module_functions
			if (($access_level <> 'anon') && $displayFlag && !$ajaxFlag && !$skip_permissions_check) {
				// Check if user has access to this script
				$currentlyRequestedUrl = $this->uri->path;
				$arrSoftwareModuleUrls = $this->permissions->getArrSoftwareModuleUrls();
				$arrSoftwareModuleFunctionUrls = $this->permissions->getArrSoftwareModuleFunctionUrls();
				if (!isset($arrSoftwareModuleUrls[$currentlyRequestedUrl]) && !isset($arrSoftwareModuleFunctionUrls[$currentlyRequestedUrl])) {
					$user_id = $this->session->getUserId();

					if ((isset($user_id) && ($user_id > 0)) && ($currentlyRequestedUrl != "/account.php")) {
						//$url = '/account.php'.$uri->queryString;
						$url = '/account.php';
						header('Location: '.$url);
					} else {
						$url = '/';
						header('Location: '.$url);
					}
					exit;
				}
			}

			Zend_Registry::set('permissions', $this->permissions);
			$arrObjects['permissions'] = $this->permissions;
		}
		/**/

		/**
		 * Use the $data array of Application instance as a registry for the standard objects.
		 */
		$this->setData($arrObjects);

		unset($scriptParams);

		return $arrObjects;
	}

	public function getSessionStartTime()
	{
		if (isset($this->sessionStartTime)) {
			$sessionStartTime = (float) $this->sessionStartTime;
			return $sessionStartTime;
		} else {
			return null;
		}
	}

	public function setSessionStartTime($sessionStartTime=null)
	{
		if (isset($sessionStartTime)) {
			$this->sessionStartTime = (float) $sessionStartTime;
		} else {
			$this->sessionStartTime = null;
		}
	}

	public function getSessionEndTime()
	{
		if (isset($this->sessionEndTime)) {
			$sessionEndTime = (float) $this->sessionEndTime;
			return $sessionEndTime;
		} else {
			return null;
		}
	}

	public function setSessionEndTime($sessionEndTime=null)
	{
		if (isset($sessionEndTime)) {
			$this->sessionEndTime = (float) $sessionEndTime;
		} else {
			$this->sessionEndTime = null;
		}
	}

	public function getSessionTotalTime()
	{
		$sessionEndTime = $this->getSessionEndTime();
		$sessionStartTime = $this->getSessionStartTime();;
		if (isset($sessionEndTime) && isset($sessionStartTime)) {
			$sessionTotalTime = (float) ($sessionEndTime - $sessionStartTime);
			return $sessionTotalTime;
		} else {
			return null;
		}
	}

	public function getAjax()
	{
		if (!$this->ajaxInitialized) {
			$this->initAjax();
		}
		return $this->ajax;
	}

	public function getConfig($init = null)
	{
		if (!$this->configInitialized) {
			$this->initConfig($init);
		}
		return $this->config;
	}

	public function getGeo($domain = null)
	{
		if (!$this->geoInitialized) {
			$this->initGeo();
		}
		return $this->geo;
	}

	public function getUri($domain = null)
	{
		if (!$this->uriInitialized) {
			$this->initUri();
		}
		return $this->uri;
	}

	public function getSession($key = null)
	{
		if (!$this->sessionInitialized) {
			$this->initSession();
		}
		return $this->session;
	}

	public function getAuth()
	{
		if (!$this->authInitialized) {
			$this->initAuth();
		}
		return $this->auth;
	}

	public function getSapi()
	{
		if (!$this->sapiInitialized) {
			$this->initSapi();
		}
		return $this->sapi;
	}

	public function getTemplate()
	{
		if (!$this->templateInitialized) {
			$this->initTemplate();
		}
		return $this->template;
	}

	public function getTimer()
	{
		if (!$this->timerInitialized) {
			$this->initTimer();
		}
		return $this->timer;
	}

	/**
	 * Initialize ajax api.
	 *
	 *
	 * @return void
	 */
	public function initAjax($scriptParams = null)
	{
		if (!isset($this->config) || !($this->config instanceof Zend_Config)) {
			throw new Exception('No Config object defined');
		}

		require_once('lib/common/Ajax.php');
		$this->ajax = new Ajax();
		$this->ajaxInitialized = true;
		return;

		// Confirm that the page was requested by the jQuery AJAX api
		if (isset($scriptParams['ajax']) && !empty($scriptParams['ajax'])) {
			if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || empty($_SERVER['HTTP_X_REQUESTED_WITH'])) {
				$uri = $this->uri;
				$referrer = $uri->referrer;
				if (isset($referrer) && !empty($referrer)) {
					$location = $uri->referrer;
				} else {
					$location = $uri->https . 'account.php';
				}
				$header = "Location: $location";
				header($header, true, 303);
				exit;
			}
		}
	}

	/**
	 * Initialize the configuration for a given domain (sub-application), e.g listserv.
	 *
	 * Config's default is to return global configuration settings.  If $domain
	 * is not set then the defaults will be used in Config.
	 *
	 * @param string $domain	The sub-application, e.g. 'mall', 'cms', etc.
	 *
	 * @return void
	 *
	 * @throws Exception
	 */
	public function initConfig()
	{
		/**
		 * Initialize configuration data.  Instantiate Config object collection.
		 */
		require_once('Zend/Config/Ini.php');
		$this->config = new Zend_Config_Ini('conf/config.ini', null, true);

		/**
		 * Possibly read an application specific config file
		 */
		if ($this->_application && ($this->_application != 'global')) {
			$applicationConfigFile = $this->_application.'.ini';
			$baseDir = $this->config->system->base_directory;
			$file = $baseDir.'engine/include/conf/'.$applicationConfigFile;
			if (is_file($file)) {
				$applicationConfig = new Zend_Config_Ini('conf/'.$applicationConfigFile, null, true);
				$this->config->merge($applicationConfig);

				// Defined constants section
				if ($this->config->defined_constants) {
					$arrDefinedConstants = $this->config->defined_constants;
					foreach ($arrDefinedConstants as $definedConstantKey => $definedConstantValue) {
						if (!defined($definedConstantKey)) {
							define($definedConstantKey, $definedConstantValue);
						}
					}
				}

				// Application specific Includes Section
				if (isset($this->_scriptParams['skip_always_include']) && ($this->_scriptParams['skip_always_include'])) {
					$skip_always_include = (bool) $this->_scriptParams['skip_always_include'];
				} else {
					$skip_always_include = false;
				}
				if (isset($this->config->application_includes->always_include) && !$skip_always_include) {
					$application_includes = $this->config->application_includes->always_include;
					$arrApplicationIncludes = explode(',', $application_includes);
					foreach ($arrApplicationIncludes as $tmpFilePath) {
						$applicationIncludeFilePath = $baseDir.'engine/include/'.$tmpFilePath;
						if (file_exists($applicationIncludeFilePath)) {
							//require_once($applicationIncludeFilePath);
							require_once($tmpFilePath);
						}
					}
				}
			}
		}

		/**
		 * Possibly take in paramaters from a given script.
		 */
		if (isset($this->_scriptParams) && is_array($this->_scriptParams) && !empty($this->_scriptParams)) {
			// Create a nested array from init so a "script" Config object will exist
			//		within the master Config objects collection of Config objects.
			$init = array('script' => $this->_scriptParams);
			$scriptConfig = new Zend_Config($init);
			unset($init);
			// Merge the script Config object into the master Config object
			$this->config->merge($scriptConfig);
			unset($scriptConfig);
		}

		/**
		 * Ensure final Config object is read only.
		 */
		//$this->config->setReadOnly();

		$this->configInitialized = true;

		Zend_Registry::set('config', $this->config);
	}

	/**
	 * Override php.ini settings.
	 *
	 * This section allows for cases when modifying php.ini is unavailable or undesired.
	 *
	 * @return void
	 *
	 */
	public function initPhpIni()
	{
		if (!isset($this->config) || !($this->config instanceof Zend_Config)) {
			throw new Exception('No Config object defined');
		}
		// Conditionally override php.ini settings if set in config file or script
		$systemOverridePhpIni = $this->config->system->override_php_ini;
		$scriptOverridePhpIni = $this->config->script->override_php_ini;

		if ($systemOverridePhpIni || $scriptOverridePhpIni) {
			/**
			 * Include additional config-php.ini for php.ini settings.
			 */
			$phpConfig = new Zend_Config_Ini('conf/config-php.ini', null, true);
			$arrPhpSettings = $phpConfig->php->toArray();
			unset($phpConfig);

			foreach ($arrPhpSettings as $key => $value) {
				if (is_array($value)) {
					foreach ($value as $k => $v) {
						$iniKey = $key.'.'.$k;
						ini_set($iniKey, $v);
					}
				} else {
					ini_set($key, $value);
				}

			}
			unset($key);
			unset($value);

			// general section
			//set_magic_quotes_runtime($arrPhpSettings['magic_quotes_runtime']);

			// error handling
			//error_reporting($arrPhpSettings['error_reporting']);
		}
	}

	/**
	 * Initialize the application-specific Zend_Cache
	 *
	 * @return void
	 *
	 * @throws Zend_Cache_Exception
	 */
	public function initCache()
	{
		/**
		 * Zend_Cache
		 */
		require_once('Zend/Cache.php');

		/**
		 * Zend_Cache Frontend options
		 *
		 * These should come from the config.ini file
		 */
		$frontendOptions = array(
			'lifetime' => 86400, // cache lifetime of 24 hours
			'automatic_serialization' => true
		);

		/**
		 * Zend_Cache Backend options
		 *
		 * These should come from the config.ini file
		 */
		$tempDir = $this->config->system->base_directory;
		$tempDir .= 'cache/www/'.$this->_application.'/miscellaneous/';
		$backendOptions = array(
			'cache_dir' => $tempDir // Directory where to put the cache files
		);

		/**
		 * getting a Zend_Cache_Core object
		 */
		$cache = Zend_Cache::factory('Core', 'File', $frontendOptions, $backendOptions);
		$this->cache = $cache;

		$this->cacheInitialized = true;
	}

	/**
	 * Initialize EGPCS Input.  Filter and truncate whitespace.
	 *
	 *
	 */
	public function initEgpcs()
	{
		if (!isset($this->config) || !($this->config instanceof Zend_Config)) {
			throw new Exception('No Config object defined');
		}

		require_once('lib/common/Egpcs.php');

		if (isset($_GET) && !empty($_GET)) {
			$this->get = new Egpcs('get', $this->_application);
			$this->get->setData($_GET);
			/* @var $this->get Egpcs */
			if (isset($this->_scriptParams['get_maxlength'])) {
				$maxLength = $this->_scriptParams['get_maxlength'];
			} else {
				$maxLength = 2048;
			}
			$this->get->clean($maxLength);
		}

		/**
		 * $_POST and post back.
		 */
		if (isset($_POST) && !empty($_POST)) {
			$this->post = new Egpcs('post', $this->_application);
			$this->post->setData($_POST);
			if (isset($this->_scriptParams['post_maxlength'])) {
				$maxLength = $this->_scriptParams['post_maxlength'];
			} else {
				$maxLength = 2048;
			}
			$this->post->clean($maxLength);
		}

		if (isset($_COOKIE) && !empty($_COOKIE)) {
			$this->cookie = new Egpcs('cookie', $this->_application);
			$this->cookie->setData($_COOKIE);
			if (isset($this->_scriptParams['cookie_maxlength'])) {
				$maxLength = $this->_scriptParams['cookie_maxlength'];
			} else {
				$maxLength = 4096;
			}
			$this->cookie->clean($maxLength);
		}

		if (isset($_REQUEST) && !empty($_REQUEST)) {
			$this->request = new Egpcs('request', $this->_application);
			$this->request->setData($_REQUEST);
			if (isset($this->_scriptParams['request_maxlength'])) {
				$maxLength = $this->_scriptParams['request_maxlength'];
			} else {
				$maxLength = 2048;
			}
			$this->request->clean($maxLength);
		}

		$this->gpcInitialized = true;
	}

	/**
	 * Initialize geo location data by user's IP Address.
	 *
	 * @param string $domain
	 *
	 * @return void
	 *
	 */
	public function initGeo()
	{
		if (!isset($this->config) || !($this->config instanceof Zend_Config)) {
			throw new Exception('No Config object defined');
		}
		require_once('lib/common/GeoLocation.php');
		$this->geo = new GeoLocation();
		$this->geoInitialized = true;
	}

	/**
	 * Initialize uri links.
	 *
	 * @param string $domain	The sub-application to initialize the links for.
	 *
	 * @return void
	 *
	 */
	private function initUri()
	{
		if (!isset($this->config) || !($this->config instanceof Zend_Config)) {
			throw new Exception('No Config object defined');
		}

		$uriConfig = $this->config->uri;
		$uriConfig->sapi = $this->sapi;

		require_once('lib/common/Uri.php');
		$uri = Uri::getInstance($uriConfig);
		/* @var $uri Uri */

		$this->uri = $uri;
		$this->uriInitialized = true;
		$this->uriRequested = $uri->requestedUrl;

		if ($uriConfig->allow_dynamic_hostname && isset($this->config->session)) {
			// Update the session.cookie_domain value in the session config.
			$sessionConfig = $this->config->session;
			$sessionConfig->domain = $uri->wildcard_subdomain;
		}

		Zend_Registry::set('uri', $uri);
	}

	/**
	 * Initialize error handler and exception handler.
	 *
	 * @return void
	 *
	 */
	public function initError($init=null)
	{
		if (!isset($this->config) || !($this->config instanceof Zend_Config)) {
			throw new Exception('No Config object defined');
		}

		require_once('lib/common/functions/error.php');

		/**
		 * Register user-defined error handler call back function.
		 */
		if (isset($init['ajax'])) {
			$ajaxFlag = (bool) $init['ajax'];
		} else {
			$ajaxFlag = false;
		}
		if ($ajaxFlag) {
			// Use the ajax specific error_handler function
			$errorHandlerFunction = 'masterAjaxErrorHandler';
		} else {
			// Use the config.ini error_handler function
			$errorHandlerFunction = $this->config->system->error_handler;
		}

		// Debug
		$errorHandlerFunction = 'masterErrorHandler';

		if (isset($errorHandlerFunction) && !empty($errorHandlerFunction) && function_exists($errorHandlerFunction)) {
			// Set a custom user defined PHP error handler for use with Ajax requests
			// Save the previous error hander function name into the variable "$existingErrorHandler" in case we want to set it back after our Ajax code block
			//set_error_handler($errorHandlerFunction);
			$existingErrorHandler = set_error_handler($errorHandlerFunction, E_ALL);
		}

		/**
		 * Register user-defined exception handler call back function.
		 */
		$exceptionHandlerFunction = $this->config->system->exception_handler;
		if (isset($exceptionHandlerFunction) && !empty($exceptionHandlerFunction) && function_exists($exceptionHandlerFunction)) {
			set_exception_handler($exceptionHandlerFunction);
		}

		require_once('lib/common/Error.php');
		$this->error = Error::getInstance();
		$this->errorInitialized = true;
	}

	/**
	 * Initialize the session.
	 *
	 * @param string $key	A possible key to scope the session space.
	 *
	 * @return void
	 *
	 */
	public function initSession()
	{
		if (!isset($this->config) || !($this->config instanceof Zend_Config)) {
			throw new Exception('No Config object defined');
		}

		require_once('lib/common/functions/session_transactional_mysqli.php');

		/**
		 * Set up database session storage for $_SESSION via MySQL storage backend.
		 *
		 * Register user-defined session call back functions.
		 *
		 */
		//session_set_save_handler("sessionOpen", "sessionClose", "sessionRead", "sessionWrite", "sessionDestroy", "sessionGC");

		/**
		 * Database sessions and peristenct objects require the definition of the class before unserializing the object out of the session.
		 * THIS CAN BE COMPLETELY AVOIDED AS I HAVE DONE HERE BY HAVING THE CLASS CONVERT IT'S DATA TO A SIMPLE ARRAY AND THEN
		 * THE SESSION SIMPLY STORES AN ARRAY AS PART OF ITSELF.
		 */
		//require_once('lib/common/Message.php');

		/**
		 * Instantiate application level session object.
		 *
		 */
		require_once('lib/common/Authorization.php');
		require_once('lib/common/Session.php');
		$sessionConfig = $this->config->session;
		if (isset($sessionConfig)) {
			$session = Session::getInstance($sessionConfig);
		} else {
			$session = Session::getInstance();
		}
		$this->session = $session;
		$this->sessionInitialized = true;

		$user_id = (int) $session->getUserId();
		$customDbSession = CustomDbSession::getInstance();
		/* @var $customDbSession CustomDbSession */
		$customDbSession->setUserId($user_id);

		Zend_Registry::set('session', $session);
	}

	/**
	 * Perform security checks.
	 *
	 * @param array $settings	The security settings for the given script.
	 *
	 * @return void
	 *
	 */
	public function initSecurity($settings = null)
	{
		// First see if site is cloaked
		$this->cloakSite();

		// Check if HTTPS is required
//		$this->httpsCheck($settings);

		// Validate auth based on a given script's init settings
		$this->initAuth($settings);
		//$this->getAuth()->init($settings, $this->getSession());
	}

	public function httpsCheck($settings = null)
	{
		// HTTPS always required
		$https = $settings['https'];

		// HTTPS required when access_level is "auth"
		$https_auth = $settings['https_auth'];

		// HTTPS always required
		$https_admin = $settings['https_admin'];

		// HTTPS TLS/SSL check
		if ($https || (($access_level == 'auth') && $https_auth) || (($access_level == 'admin') && $https_admin)) {
			// Redirect to the same URL with session in tact, but over https
			if ($_SERVER["HTTPS"] != "on") {
				$location = $this->uri->full_https_uri;
				header('Location: '.$location);
				exit;
			}
		}
	}

	/**
	 * Perform auth checks.
	 *
	 * Page access level:
	 * Currently there are four levels of access:
	 * 1) anon
	 * 2) auth (user, but not admin)
	 * 3) admin (account admin)
	 * 4) global_admin
	 *
	 * @param array $settings	The security settings for the given script.
	 *
	 * @return void
	 *
	 */
	public function initAuth($settings = null)
	{
		// Default to anon...this may change
		$defaultAccessLevel = 'anon';

		if (isset($settings['access_level']) && !empty($settings['access_level'])) {
			$access_level = $settings['access_level'];
			if (($access_level != 'anon') && ($access_level != 'auth') && ($access_level != 'admin') && ($access_level != 'global_admin')) {
				$access_level = $defaultAccessLevel;
			}
		} else {
			$access_level = $defaultAccessLevel;
		}

		// user_id ("logged in") check
		if (($access_level == 'auth') || ($access_level == 'admin') || ($access_level == 'global_admin')) {
			$session = Session::getInstance();
			$user_id = (int) $session->getUserId();

			if (!isset($user_id) || empty($user_id) || $user_id < 1) {
				$session->logOut();
				$uri = $this->getUri();
				/* @var $uri Uri */
				$requestedUrl = $uri->requestedUrl;
				$session->setRequestedUri($requestedUrl);
				require_once('lib/common/Message.php');
				$message = Message::getInstance();
				/* @var $message Message */
				//$message = new Message;
				$message->reset();
				$message->enqueueError('Please login to access your account.', 'login-form.php');
				$message->sessionPut();

				//$queryString = (isset($_SERVER['QUERY_STRING']) && !empty($_SERVER['QUERY_STRING']) ? '?'.$_SERVER['QUERY_STRING'] : '');
				$url = $uri->https.'login-form.php'.$uri->queryString;
				//session_write_close();
				header("Location: $url");
				exit;
			} else {
				$database = $this->config->database->default_database;
				$user_company_id = $session->getUserCompanyId();
				//$auth = Authorization::getInstance();
				$auth = Authorization::authorizeUser($database, $user_id, $user_company_id);
				/* @var $auth Authorization */
				if ($auth && ($auth instanceof Authorization)) {
					$this->auth = $auth;
					$this->authInitialized = true;
					$userRole = $auth->getUserRole();
				} else {
					$userRole = '';
				}

				$requiredAccessLevel = $access_level;
				$accessDenied = true;
				if (($userRole == 'global_admin') || ($userRole == $requiredAccessLevel)) { // global_admin gets access to all pages
					$accessDenied = false;
				} elseif (($requiredAccessLevel == 'global_admin') && ($userRole != 'global_admin')) { // check if global_admin role required
					$accessDenied = true;
				} elseif (($requiredAccessLevel == 'admin') && ($userRole != 'admin')) { // check if admin role required
					$accessDenied = true;
				} elseif ($requiredAccessLevel == 'auth') { // allow authenticated user access
					$accessDenied = false;
				}

				if ($accessDenied) {
					require_once('lib/common/Message.php');
					$message = Message::getInstance();
					/* @var $message Message */
					$message->reset();
					$message->enqueueError('You have no access to this page.', 'account.php');
					$message->sessionPut();

					$queryString = (isset($_SERVER['QUERY_STRING']) && !empty($_SERVER['QUERY_STRING']) ? '?'.$_SERVER['QUERY_STRING'] : '');
					//$url = '/account.php'.$queryString;
					$url = '/account.php';
					header("Location: $url");
					exit;
				}

				/*
				// Custom app-level permissions
				// ...bypass for CLI application components since dependent upon Session.
				if ($this->sapi != 'cli') {
					$this->initPermissions();
					Zend_Registry::set('permissions', $this->permissions);
				}
				*/
			}
		}
	}

	public function initPermissions($scriptParams = null)
	{
		if (isset($scriptParams['access_level']) && !empty($scriptParams['access_level'])) {
			$access_level = $scriptParams['access_level'];
			if (($access_level != 'anon') && ($access_level != 'auth') && ($access_level != 'admin') && ($access_level != 'global_admin')) {
				$access_level = 'anon';
			}
		} else {
			$access_level = 'anon';
		}

		if ($access_level == 'anon') {
			return;
		}

		// Some pages have $init['access_level'] = 'anon'; for debug convenience
		// Granular permissions
		require_once('lib/common/Permissions.php');
		$database = $this->config->database->default_database;
		Permissions::loadPermissions($database);
		$permissions = Permissions::getInstance();
		$this->permissions = $permissions;
		$this->permissionsInitialized = true;
	}

	/**
	 * After Authentication & Authorization, which use cookies, we can verify Input
	 *
	 */
	public function initRequiredInput($scriptParams = null)
	{
		// Default to allow for more flexible per-page access
		$validInput = true;

		// Check for required GET input
		if (isset($scriptParams['get_required']) && ($scriptParams['get_required'] == true)) {
			$get = $this->get;
			if (isset($get)) {
				$getData = $get->getData();
			} else {
				$getData = array();
			}

			if (empty($getData)) {
				$validInput = false;
			}
		}

		// Check for required POST input
		if (isset($scriptParams['post_required']) && ($scriptParams['post_required'] == true)) {
			$post = $this->post;
			if (isset($post)) {
				$postData = $post->getData();
			} else {
				$postData = array();
			}

			if (empty($postData)) {
				$validInput = false;
			}
		}

		// Check for raw post (Ajax case)
		// ...

		if ($validInput === false) {
			// Ajax scripts simply output an empty string to avoid the JavaScript error handler from being invoked
			if (isset($scriptParams['ajax']) && $scriptParams['ajax']) {
				echo '';
				exit;
			}

			// Either redirect to the auth home or actual home page depending upon if the user is logged in

			// Check for an active session
			if (isset($_SESSION) && !empty($_SESSION)) {
				// Check if the user is authenticated
				$session = $this->session;
				/* @var $session Session */
				$authenticated = $session->isUserAuthenticated();
				if ($authenticated) {
					require_once('lib/common/Message.php');
					$message = Message::getInstance();
					/* @var $message Message */
					$message->reset();
					$message->enqueueError('An unkown error has occurred.', 'account.php');
					$message->sessionPut();

					$queryString = (isset($_SERVER['QUERY_STRING']) && !empty($_SERVER['QUERY_STRING']) ? '?'.$_SERVER['QUERY_STRING'] : '');
					$url = 'account.php'.$queryString;
					header("Location: $url");
					exit;
				} else {
					// Redirect to site home page since not authenticated
					$url = '/';
					header("Location: $url");
					exit;
				}
			} else {
				// Redirect to site home page since no active session and not authenticated
				$url = '/';
				header("Location: $url");
				exit;
			}
		}
	}

	/**
	 * Server-side browser detection.
	 *
	 * @return void
	 *
	 */
	public function initBrowser()
	{
		return;

		if (!isset($this->config) || !($this->config instanceof Zend_Config)) {
			throw new Exception('No Config object defined');
		}

		$browser1 = get_browser();
		print_r($browser1);
		exit;

		require_once('browser/TeraWurfl.php');
		$browser = new TeraWurfl();
		// Get the capabilities of the current client.
		$browser->getDeviceCapabilitiesFromAgent();
		print_r($browser);
		exit;
		$wirelessDeviceFlag = $browser->getDeviceCapability("is_wireless_device");
		$screenWidth = $browser->getDeviceCapability("resolution_width");
		$screenHeight = $browser->getDeviceCapability("resolution_height");
		$preferredMarkup = $browser->getDeviceCapability("preferred_markup");

		$this->browser = $browser;
		$this->browserInitialized = true;
	}

	/**
	 * Initialize site params.
	 *
	 * @param string $domain	The sub-application the current script belongs to.
	 *
	 * @return void
	 *
	 */
	public function initSite($domain = 'global')
	{
	}

	/**
	 * Set up environment for display script
	 *
	 * Include templating engine code.
	 * Initialize templating engine.
	 *
	 * @return void
	 *
	 */
	public function initTemplating($scriptParams)
	{
		$config = $this->config;
		$baseDirectory = $config->system->base_directory;

		$smarty_root = $config->templating->smarty_root;
		$smarty_class_path = $config->templating->smarty_class_path;
		$smarty_cache_directory = $config->templating->smarty_cache_directory;
		$smarty_compile_directory = $config->templating->smarty_compile_directory;
		$smarty_config_directory = $config->templating->smarty_config_directory;
		$smarty_template_directory = $config->templating->smarty_template_directory;
		$smarty_debug_template_path = $config->templating->smarty_debug_template_path;

		$smarty_allow_php_tag = $config->templating->smarty_allow_php_tag;
		$smarty_caching = $config->templating->smarty_caching;
		$smarty_cache_lifetime = $config->templating->smarty_cache_lifetime;
		$smarty_debugging = $config->templating->smarty_debugging;
		$smarty_force_compile = $config->templating->smarty_force_compile;

		$smartyCacheDirectory = $baseDirectory.$smarty_cache_directory;
		$smartyCompileDirectory = $baseDirectory.$smarty_compile_directory;
		$smartyConfigDirectory = $baseDirectory.$smarty_config_directory;
		$smartyTemplateDirectory = $baseDirectory.$smarty_template_directory;
		$smartyDebugTemplatePath = $baseDirectory.$smarty_debug_template_path;

		require_once($smarty_class_path);
		$smarty = new Smarty;
		$smarty->template_dir = $smartyTemplateDirectory;
		$smarty->compile_dir  = $smartyCompileDirectory;
		$smarty->config_dir   = $smartyConfigDirectory;
		$smarty->cache_dir    = $smartyCacheDirectory;
		$smarty->allow_php_tag = $smarty_allow_php_tag;
		$smarty->caching = $smarty_caching;
		$smarty->debugging = $smarty_debugging;
		$smarty->debug_tpl = $smartyDebugTemplatePath;
		$smarty->cache_lifetime = $smarty_cache_lifetime;
		$smarty->force_compile = $smarty_force_compile;

		require_once('lib/common/Template.php');
		$session = $this->session;
		/* @var $session Session */
		$template_theme = $session->getCurrentlyActiveTemplateTheme();

		if (!isset($template_theme)) {
			$template_theme = $config->templating->template_theme;
		}

		$template = Template::getInstance($template_theme);
		/* @var $template Template */

		if (isset($scriptParams['output_buffering'])) {
			$output_buffering = $scriptParams['output_buffering'];
		} else {
			$output_buffering = $config->system->output_buffering;
		}

		$template->setEngine($smarty);
		$template->setCaching(true);
		$template->setOutputBuffering($output_buffering);
		$template->init();

		if (isset($scriptParams['access_level']) && ($scriptParams['access_level'] <> 'anon')) {
			$loadMenuFlag = true;
		} else {
			$loadMenuFlag = false;
		}
		$template->setLoadMenuFlag($loadMenuFlag);

		$this->template = $template;
		$this->templateInitialized = true;
	}

	/**
	 * Set up environment for display script
	 *
	 * Include templating engine code.
	 * Initialize templating engine.
	 *
	 * @return void
	 *
	 */
	public function initDisplay()
	{
		/**
		 * output buffering
		 */
		if ($arrPhpSettings['output_buffering'] && $arrPhpSettings['page_compression']) {
			ob_start('ob_gzhandler');
		} elseif ($arrPhpSettings['output_buffering']) {
			ob_start();
		}
	}

	/**
	 * Free up memory by unsetting needless SuperGlobals.
	 *
	 */
	public function initSapi()
	{
		if (isset($this->_scriptParams['sapi'])) {
			$sapi_type = $this->_scriptParams['sapi'];
		} else {
			//dynamically detect SAPI
			$sapi_type = php_sapi_name();
		}

		// These could be set from the config.ini file or set in web server environmental variables.
		//$os = php_uname();
		$this->php_os = PHP_OS;
		$this->sapi = $sapi_type;
		$this->sapiInitialized = true;

		if (is_int(stripos($this->php_os, 'WIN', 0))) {
			self::$_operatingSystem = self::WINDOWS_OS;
		} else {
			self::$_operatingSystem = self::LINUX_OS;
		}
	}

	/**
	 * Free up memory by unsetting needless SuperGlobals.
	 *
	 */
	public function initMemory()
	{
		/**
		 * Unset $_REQUEST - should never be used.
		 */
		unset($_REQUEST);

		/**
		 * Delete any superglobals that are empty.
		 */
		foreach ($GLOBALS as $key => $value) {
			if (empty($value)) {
				unset($GLOBALS[$key]);
			}
		}
	}

	/**
	 * Set up a timer on the script.
	 *
	 */
	public function initTimer($start=true)
	{
		/**
		 * Timer
		 */
		require_once('lib/common/Timer.php');

		$timer = Timer::getInstance();
		/* @var $timer Timer */

		if ($start) {
			$timer->startTimer();
		}

		$this->timer = $timer;
		/* @var $this->timer Timer */
		unset($timer);
	}

	/**
	 * Site Cloaking.
	 *
	 * The site may be cloaked to dissallow public access.
	 * When cloaked, an HTTP 404 Header is returned.
	 *
	 * Decloaking is acheived by a URL input for a given session or by some login mechanism.
	 * An allowed ip address or subnet may be used to decloak the site as well.
	 */
	public function cloakSite() {
		// For performance reasons, here is an in-line cloak setting for future use.
		//return;

		/**
		 * Site may be Cloaked...
		 *
		 * 1) Check config cloak setting.
		 * 2) Check allowed ip address pool.
		 * 3) Check session cloak variable.
		 * 4) Check URL input for decloaking contents and decloak.
		 * 5) Site is still cloaked after all other checks so return 404 Error.
		 */

		// 1)
		// Retrieve the configuration "cloak" value.
		$config = $this->getConfig();
		$cloak = $config->system->cloak;
		if (!$cloak) {
			// Site is not supposed to be cloaked so return.
			return;
		}

		// 2)
		// Retrieve the allowed ip list for decloaking.
		if (isset($_SERVER['REMOTE_ADDR']) && !empty($_SERVER['REMOTE_ADDR'])) {
			$allowed_ip_pool = $config->system->allowed_ip_pool;
			$arrIp = explode(' ', $allowed_ip_pool);

			// Determine the ip of the user attempting access.
			$ip = $_SERVER['REMOTE_ADDR'];

			if (in_array($ip, $arrIp)) {
				return;
			}
		}

		// 3)
		// Retrieve a handle to the Session class.
		$session = Session::getInstance();
		// Check to see if site is already decloaked based upon the session "cloak" value.
		$cloakFlag = $session->cloak;
		if (isset($cloakFlag) && !$cloakFlag) {
			return;
		}

		// 4)
		// Possibly decloak site from URL input...
		$decloak_url_key = $config->uri->decloak_url_key;
		if (isset($this->get) && isset($decloak_url_key)) {
			$uri = $this->getUri();
			/* @var uri Uri */
			$queryString = $uri->queryString;
			if (is_int(strpos($queryString, $decloak_url_key))) {
				// Decloak via session for next page request.
				$session->cloak = false;
				return;
			}
		}

		// 5)
		// Site is cloaked so return 404 Error and exit.
		/**
		 * Very complicated flow here:
		 *
		 * Apache 2.2 Directive:
		 * ErrorDocument 404 /error/404.php
		 *
		 * Any 404 error from Apache is served by /error/404.php which uses
		 * Application::init().  If site is cloaked, the below code is executed
		 * and the contents of 404.php are not utilized.  This always holds up
		 * unless a front controller is processing the page.  In that case
		 * the front controller must call 404.php when appropriate.
		 *
		 * E.g. http://www.example.com/parts/aa (part.php front controller
		 * would call 404.php since aa is not a valid url input/page).
		 *
		 * If the site is not cloaked, the below code is not reached and the
		 * contents of 404.php provide a friendly 404 page that is the site's
		 * standard 404 error page.
		 *
		 * Bottom Line:
		 * Two types of standard 404 situations, cloaked and not cloaked.
		 * Cloaked outputs Apache 2.2's generic HTML 2.0 404 message.
		 * Decloaked/not cloaked outputs friendly 404.php page.
		 * One exception case which is bad URL input to a front controller.
		 * Front contoller would include 404.php (assuming site is decloaked).
		 *
		 * Cloaked Case: Output is Fake Apache 2.2 404 HTML 2.0 message.
		 * Not Cloaked Case: Output is friendly 404.php page w/ sitemap.
		 * Front Controler Case: Output is friendly 404.php page w/ sitemap.
		 *
		 */
		header('HTTP/1.0 404 Not Found');
		ob_start();
		// Apache 2.2's generic HTML 2.0 404 message.
		include('page-components/apache-2.2-404.php');
		$contents = ob_get_clean();
		ob_end_clean();
		echo $contents;
//		$headersFlag = headers_sent($file, $line);
//		$arrHeaders = headers_list();
//		echo '<pre>'.print_r($arrHeaders, true).'</pre>';
		exit;
	}

	/**
	 * Reset all EGPCS vars and $_SESSION.
	 *
	 * @return void
	 *
	 */
	public function killSuperglobals() {
		$_SERVER = array();
		$_GET = array();
		$_POST = array();
		$_COOKIE = array();
		$_FILES = array();
		$_ENV = array();
		$_REQUEST = array();
		$_SESSION = array();
	}
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

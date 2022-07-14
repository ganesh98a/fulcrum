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
// Debug settings
//error_reporting(E_ALL);
//ini_set('display_errors', true);
//ini_set('max_execution_time', 0);

/**
 * Global initialization file.
 *
 * init.php does the following:
 * 1) Allows for quick and immediate changes to the core PHP configuration.
 * 2) Prevents itself from being called more than once for the CLI case via $publishingEngineInitIncluded.
 * 3) Checks to insure it was not called directly, if so exit.
 * 4) Potentially updates php's include path.
 * 5) Pulls base-level include directory and config settings from Apache's (or httpd's) shared memory.
 * 6) Potentially include missing functions for Windows or older versions of PHP.
 * 7) Initialize the application via Application::init();
 * 8) Pull standard application objects into global scope and set them in the Registry.
 * 9) Provide Object type hints to the standard application objects.
 *
 * PHP versions 5
 *
 * @category   Framework
 * @package    Application
 *
 * @see        lib/common/Application.php
 * @see        conf/config.ini
 */

/**
 * Sanity check (This script runs inside of a publishing engine)
 *
 * Each "controller" will call this script for each page rendering.  When
 * publishing all pages to static html via the publishing engine we want
 * to skip the require_once since it is so much slower than checking
 * the global scope for a defined constant.
 */
$publishingEngineInitIncluded = true;

/**
 * Security invocation check to insure file is never called directly.
 */
$arrScript = explode('/', $_SERVER['PHP_SELF']);
$called_script = array_pop($arrScript);

$arrFile = preg_split("/[\/\\\]/", __FILE__);
$this_file = array_pop($arrFile);

//$this_file = __FILE__;
//$called_script = realpath($_SERVER['SCRIPT_FILENAME']);
//if (__FILE__ == realpath($_SERVER['SCRIPT_FILENAME'])) {
if ($called_script == $this_file) {
	exit;
} else {
	unset($arrScript);
	unset($called_script);
	unset($arrFile);
	unset($this_file);
}

/**
 * PHP debug settings.
 */
if (isset($init['debugging_mode']) && $init['debugging_mode']) {
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
	ini_set('max_execution_time', 0);
}

/**
 * Script level dynamic path settings.
 *
 * Add a list of filesystem directories, each separated by a comma,
 * to add to the include path.
 *
 * Be sure to add an entry for the application directory
 * if it is not included in php.ini include_path.
 * This directory contains the subdirectories:
 * /conf, /lib, and /template.
 *
 * NOTE: For win32, be sure to use FORWARD SLASHES in the path string, not back slashes.
 * e.g. $path = 'c:/path/to/includes/';
 *
 */
$path = '';
if (!empty($path)) {
	$arrPathStrings = explode(',', $path);
	if (count($arrPathStrings) > 1) {
		$tmpPath = '';
		foreach ($arrPathStrings as $value) {
			if (!empty($value)) {
				$tmpPath .= PATH_SEPARATOR . trim($value);
			}
		}
		unset($value);
	} else {
		$tmpPath = PATH_SEPARATOR . trim($path);
	}
	$currentIncludePath = get_include_path();
	$updatedIncludePath = $currentIncludePath . $tmpPath;
	set_include_path($updatedIncludePath);
	unset($arrPathStrings);
	unset($tmpPath);
	unset($currentIncludePath);
	unset($updatedIncludePath);
}
unset($path);

// Apache ENV variables in shared memory
if (isset($_SERVER['PHP_INCLUDE_PATH']) && !empty($_SERVER['PHP_INCLUDE_PATH'])) {
	$phpIncludePath = $_SERVER['PHP_INCLUDE_PATH'];
	$ApplicationClassIncludePath = $phpIncludePath . 'lib/common/Application.php';
	$ZendRegistryIncludePath = $phpIncludePath . 'Zend/Registry.php';

	//$currentWorkingDirectory = getcwd();
	//$directoryChangedFlag = chdir($phpIncludePath);
} else {
	$phpIncludePath = false;
	$ApplicationClassIncludePath = 'lib/common/Application.php';
	$ZendRegistryIncludePath = 'Zend/Registry.php';
}

/*
// Avoid using defined constants as they are very slow
if (!defined('INCLUDE_PATH')) {
	$include_path = get_include_path();

	$tmpPath = dirname(__FILE__);
	$tmpPath .= '/../..';
	$dynamicIncludePath = realpath($tmpPath);
	$dynamicIncludePath = str_replace('\\', '/', $dynamicIncludePath);
	if (!is_int(strpos($include_path, $dynamicIncludePath))) {
		$updated_include_path = $include_path . PATH_SEPARATOR . $dynamicIncludePath;
		set_include_path($updated_include_path);
		$final_include_path = $updated_include_path;
	} else {
		$final_include_path = $include_path;
	}

	define('INCLUDE_PATH', $final_include_path);
}
// E.g. require_once(INCLUDE_PATH . "lib/common/$className.php");
*/

require_once 'Zend/Registry.php';

/**
 * Missing functions support for PHP < 5.4.
 * Test the version of PHP and include missing functions if needed.
 *
 * JSON support for PHP < 5.2.0
 */
$phpVersion = phpversion();
if ($phpVersion < 5.4) {
	$phpVersionTest = (int) str_replace('.', '', $phpVersion);
	if ($phpVersionTest < 520) {
		// JSON support for PHP < 5.2.0
		require_once('lib/common/functions/json.php');
	}
	if ($phpVersionTest < 521) {
		// Add in core php functions added in version 5.2.1
		require_once('lib/common/functions/missing_functions_5.2.1.php');
	}
	if ($phpVersionTest < 530) {
		// Add in core php functions added in version 5.3.0
		require_once('lib/common/functions/missing_functions_5.3.0.php');
	}

	if ($phpVersionTest < 540) {
		// Add in core php functions added in version 5.4.0
		require_once('lib/common/functions/missing_functions_5.4.0.php');
	}
}
$phpOs = PHP_OS;
if (is_int(stripos($phpOs, 'WIN'))) {
	require_once('lib/common/functions/missing_functions_windows.php');
}

/**
 * Zend_Registry
 */
//require_once($ZendRegistryIncludePath);
$applicationLabel = (isset($init['application']) ? $init['application'] : 'global');
Zend_Registry::set('applicationLabel', $applicationLabel);

/**
 * Initialize application and run-time environment:
 *
 * Global and script level initialization of configuration variables.
 * Script level registration of callback functions.
 *
 * 1) Retrieve/initialize configuration data.
 * 2) Set up session.
 * 3) Perform security checks.
 *
 * @param $init array (optional)	An array of params to initialize the various aspects
 * of a script, including security, etc.
 *
 */
require_once($ApplicationClassIncludePath);
$application = Application::getInstance($applicationLabel);
/* @var $application Application */
$init = (isset($init) ? $init: null);
$standardObjects = $application->init($init);
unset($init);

/**
 * Expose standard application objects/arrays for convenience and speed of development.
 *
 * $ajax		AJAX API object.
 * $auth		Security object.
 * $cache		Cache object.
 * $config		Config object.
 * $cookie		Cleaned $_COOKIE array.
 * $error		Error object.
 * $geo			GeoLocation object.
 * $get			Cleaned $_GET array.
 * $post		Cleaned $_POST array.
 * $request		Cleaned $_REQUEST array.
 * $session		Session object.
 * $template	Templating Engine object.
 * $timer		Timer object.
 * $uri			URI/URL object.
 *
 */
if (isset($standardObjects) && !empty($standardObjects) && is_array($standardObjects)) {
	foreach ($standardObjects as $objectName => $obj) {
		if (isset($obj)) {
			$$objectName = $obj;
		}
	}
}
unset($standardObjects);
unset($objectName);
unset($obj);

// Standard objects that are placed into $_GLOBAL scope by init.php.
/* @var $ajax Ajax */
/* @var $auth Authorization */
/* @var $db DBI_mysqli */
/* @var $cache Zend_Cache_Core */
/* @var $config Zend_Config_Ini */
/* @var $cookie Egpcs */
/* @var $error Error */
/* @var $geo GeoLocation */
/* @var $get Egpcs */
/* @var $post Egpcs */
/* @var $request Egpcs */
/* @var $session Session */
/* @var $template Template */
/* @var $timer Timer */
/* @var $uri Uri */

// Default database.
$database = $config->database->default_database;
if (!isset($database)) {
	throw new Exception('default_database is undefined.');
}
/* @var $database string */
Zend_Registry::set('database', $database);

// Debug Mode
if (isset($session)) {
	$debugMode = (string) $session->getDebugMode();
	Zend_Registry::set('debugMode', $debugMode);
}

// Current PHP Script
$currentPhpScript = $uri->currentPhpScript;
Zend_Registry::set('currentPhpScript', $currentPhpScript);

// Application object itself
Zend_Registry::set('application', $application);

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

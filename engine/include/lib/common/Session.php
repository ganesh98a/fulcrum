<?php
session_start();
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
 * Session object for uniform manipulation of session variables.
 *
 * php.ini values:
 * session.name
 * 		arbitrarily set the name of the cookie to 'oatmealraisin'
 * 		ini_set('session.name', 'oatmealraisin');
 *
 * PHP version 5
 *
 * @category   Session Management
 * @package    Session
 *
 * @see        lib/common/Session/php.php
 * @see        lib/common/Session/mohawk.php
 */

/**
 * AbstractWebToolkit
 */
//Already Included...commented out for performance gain
//require_once('lib/common/AbstractWebToolkit.php');

class Session extends AbstractWebToolkit
{
	/**
	 * Static Singleton instance variable with class scope
	 *
	 * @var object reference
	 */
	private static $_instance;

	private $envelope;
	private $attributes;

	/**
	 * stdin and stderr functionality for get and post operations, etc.
	 */
	//array of the current get variables being passed from the master form
	private $get = array();

	//array of the current post variables being passed from the master form
	private $post = array();

	//array of the current post variables being passed from the master form
	private $request = array();

	//array of the current post variables being passed from the master form
	private $cookie = array();

	//show any errors using $arrErrors["message"] and fields in red using their names
	private $arrErrors = array();

	//show any messages using $arrMessage["message"] and fields in purple using their names
	private $arrMessage = array();

	//Log referring url and keywords used to get to site e.g. google - with keywords used to search
	private $arrLog = array();

	//Show error messages on display screen (set by action script setting error message)
	private $showError = false;

	//Show display messages on display screen (set by action script setting display message)
	private $showMessage = false;

	//Track form submission to allow only one submit from a from display script
	private $formSubmitted = false;

	//array of commonly used values, e.g. user_recid and account_recid
	private $masterValues = array();

	//container for global site message queue
	private $messageQueue = null;

	/**
	 * anonymous user tracking
	 */
	private $ipAddress = null;

	//object to hold current browser characteristics for anonymous user tracking
	private $browser = null;

	//log_id of entity within log relation used to track user characteristics
	private $logId = null;

	//web_log_id of entity within web_log relation used to track user navigation and behavior
	private $webLogId = null;

	//email_log_id of entity within email_log relation used to track email sent by user
	private $emailLogId = null;

	/**
	 * debug info
	 */
	//for DEBUG only --->array of the current server super global variables
	// value assigned in individual scripts
	private $serverGlobals = null;

	//for DEBUG only --->array of the current server super global variables
	// value assigned in individual scripts
	private $debugVars = null;

	/**
	 * Shopping Cart
	 */
	//the value of the number of unique products in the shopping cart
	private $itemCount = 0;

	//the product id (primary key) for the product most recently inserted into the cart
	private $mostRecentProduct = null;

	//Monetary total for items in cart
	private $cartTotal = null;

	//Boolean to flag if cart values are updatable (e.g. quote is in cart means vals are not updatable)
	private $cartUpdate = true;

	/**
	 * Captured Customer Orders
	 */
	//the current order id for the shopping cart
	private $orderId = null;

	//real customer orderId
	private $finalOrderId = null;

	/**
	 * Site Search Engine - sort order, etc.
	 */
	//search input for site search script
	private $searchString = null;

	//category to search (0 is whole site or "all product lines")
	private $searchCategory = 0;

	//sort option
	private $searchSortChoice = null;

	/**
	 * Template/Presentation layer
	 */
	//the current html template being used for presentation --> PK from DB Table
	private $templateId = null;

	//the current html template being used for presentation --> actual file name
	private $templateFile = null;

	/**
	 * timestamps (timers) for account login and session
	 */
	//holds the start time for the actual session itself
	private $sessionStartTime = null;

	//start counter for first account login access
	private $accountLoginTime = null;

	//holds time of last account access/activity
	private $accountLastAccessTime = null;

	//time of current account access/activity
	private $accountCurrentAccessTime = null;

	//to determine if timeout period is expired:
	// accountCurrentAccessTime - accountLastAccessTime > timeOutTime

	//timeout values for user and admin
	//time allotted to an inactive user before session expires
	private $userTimeOut = null;

	//time allotted to an inactive admin user before session expires
	private $adminTimeOut = null;

	/**
	 * user and admin status flags
	 */
	//holds the user id when the user is logged in --> any negative value is an anonymous user
	private $userId = -1;

	//normal user login status flag
	private $userLoggedIn = false;

	//admin super user login status flag
	private $adminLoggedIn = false;

	/**
	 * screen messages for logged in, messages, timeout, etc.
	 */
	//displays logged in/out messages
	private $loginStatusMessage = null;

	//normal user loginscreen message
	private $loginScreenMessage = null;

	//normal user account page message
	private $userAccountMessage = null;

	//message for admin account
	private $adminAccountMessage = null;

	//message for logout page following logout, etc. -> could use index page
	private $displayMessage = null;

	//session timed out message for loginscreen
	private $timedOutMessage = null;

	/**
	 * admin account modifier flags
	 */
	//for change admin account script
	private $modifyAdminAccount = false;

	//for change admin email script
	private $modifyAdminEmail = false;

	//for chang admin password script
	private $modifyAdminPassword = false;

	//for admin chat page
	private $adminChat = false;

	/**
	 * user account modifier flags
	 */
	//for change user account script
	private $modifyUserAccount = false;

	//for change user email script
	private $modifyUserEmail = false;

	//for change user password script
	private $modifyUserPassword = false;

	//for user chat page
	private $userChat = false;

	//for password retrieval of any user (used to enforce workflow ->screen landing, etc.)
	private $forgotPassword = false;

	//account modifier flags
	//for change user account script
	private $modifyAccount = false;

	//for change user email script
	private $modifyEmail = false;

	//for change user password script
	private $modifyPassword = false;

	//for chat page
	private $chat = false;

	//payment flags
	//track payment method
	private $paymentMethod = null;

	//track payment amount
	private $paymentAmount = null;

	//track payment details such as credit card information
	private $paymentDetails = null;

	//track invoice information
	private $invoice = null;

	//track if a payment is associated with the order
	private $paymentAdded = false;

	//flag to set for edit payment method
	private $paymentEdit = false;

	//flag if user successfully checked out
	private $checkoutOk = false;

	// Flag to track if the "logout" event has occurred
	private $logOut = false;

	/**
	 * constructor method sets up session paramaters
	 *
	 * Create object before calling session_transactional file include
	 * so destructor can call session_write_close()
	 * before mysqli __destructor fires off killing the MySQL connection.
	 *
	 */
	private function __construct() {
		//constructor sets template id from config file
		//$this->setTemplateId(_TEMPLATE_ID_);
		//$this->setUserTimeOut(_USER_TIME_OUT_);
		//$this->setAdminTimeOut(_ADMIN_TIME_OUT_);

		$time = time();
		$this->setSessionStartTime($time);
		$this->userTracking();
	}

	/**
	 * Once the session exists and is unserialized out of $_SESSION
	 * this will no longer be called so should be empty or not even exist.
	 *
	 * session_write_close() is called from the Application class destructor
	 * since it always runs every time.
	 *
	 */
	/*
	public function __destruct()
	{
	}
	*/

	/**
	 * Static factory method to return an instance of the session object
	 * from the session store.
	 *
	 * If an object reference to Session is not in the superglobal
	 * $_SESSION array (the session store api) and a session object is not
	 * instantiated, create a singleton instance of the Session object and
	 * place it in the $_SESSION superglobal.  Multiple objects may be used
	 * if neccessary due to multiple sites on one http domain.
	 * E.g. one object for store and one for admin;
	 *
	 * [Session Security]
	 *
	 * Prevent session fixation:
	 * 1) Prevent URL-based session id attacks
	 * session.use_only_cookies
	 * @see http://www.acros.si/papers/session_fixation.pdf
	 *
	 * 2) Pass cookies over ssl only
	 * Use ssl all the time or
	 * session.cookie_secure
	 * or call session_regenerate_id(true) at login time over ssl
	 *
	 * session_set_cookie_params(...)
	 *
	 * @param Zend_Config_Ini $config
	 * @return Session Object Reference
	 */
	public static function getInstance($config = null) {
		// Ensure that PHP's session manager is started
		if (!isset($_SESSION)) {
			if (isset($config)) {
				$lifetime = $config->lifetime;
				$path = $config->path;
				$domain = $config->domain;
				$secure = $config->secure;
				//$arrExistingCookieParams = session_get_cookie_params();
				session_set_cookie_params($lifetime, $path, $domain, $secure);
			}

			session_start();
		}

		// Check if a Singleton exists for this class
		$instance = self::$_instance;
		if (!isset($instance) || !($instance instanceof Session)) {
			// Check if session has the object
			if (isset($_SESSION['session'])) {
				$session = $_SESSION['session'];
				if (!isset($session) || !($session instanceof Session)) {
					// Destroy the session and recreate
					unset($_SESSION['session']);
					session_regenerate_id(true);
					$session = new Session();
				}
			} else {
				$session = new Session();
			}
			self::$_instance = $session;
		}

		// Verify $_SESSION['session'] has the $session object <id>
		// self::$_instance is a static reference (object handle) to the session object
		// the session object is actually stored in the $_SESSION superglobal array
		if (!isset($_SESSION['session'])) {
			$_SESSION['session'] = self::$_instance;
		}

		return self::$_instance;
	}

    /**
     * getter method.
     *
     * @param string $key - get the value associated with $key
     * @return mixed
     * @throws Exception if no entry is registered for $key.
     */
    public static function get($key)
    {
        $instance = self::getInstance();
        $value = $instance->offsetGet($key);

        return $value;
    }

    /**
     * setter method.
     *
     * @param string $key The location in the ArrayObject in which to store
     *   the value.
     * @param mixed $value The object to store in the ArrayObject.
     * @return void
     */
    public static function set($key, $value)
    {
        $instance = self::getInstance();
        $instance->offsetSet($key, $value);
    }

	public function getValue($key, $scope = 'global')
	{
		if (isset($this->masterValues[$scope][$key])) {
			$value = $this->masterValues[$scope][$key];
			return $value;
		} else {
			return null;
		}
	}

	public function setValue($key, $value, $scope = 'global')
	{
		$this->masterValues[$scope][$key] = $value;
	}

	public function clearValue($key, $scope = 'global')
	{
		if (isset($this->masterValues[$scope][$key])) {
			unset($this->masterValues[$scope][$key]);
		}
	}

	/**
	 * Record user tracking info
	 *
	 */
	private function userTracking()
	{
		if (isset($_SERVER) && !empty($_SERVER)) {
			if (isset($_SERVER['REMOTE_ADDR']) && !empty($_SERVER['REMOTE_ADDR'])) {
				$remoteIpAddress = $_SERVER['REMOTE_ADDR'];
				$this->setIpAddress($remoteIpAddress);
			}
			if (isset($_SERVER['HTTP_USER_AGENT']) && !empty($_SERVER['HTTP_USER_AGENT'])) {
				// get_browser returns an object with the browser's properties
				$browser = get_browser();
				$this->setBrowser($browser);
			}
			// create temp array to set arrLog
			$array = array();
			if (isset($_SERVER['HTTP_USER_AGENT']) && !empty($_SERVER['HTTP_USER_AGENT'])) {
				$httpUserAgent = $_SERVER['HTTP_USER_AGENT'];
				$array['HTTP_USER_AGENT'] = $httpUserAgent;
			}
			if (isset($_SERVER['REMOTE_ADDR']) && !empty($_SERVER['REMOTE_ADDR'])) {
				$remoteIpAddress = $_SERVER['REMOTE_ADDR'];
				$array['REMOTE_ADDR'] = $remoteIpAddress;
			}
			if (isset($_SERVER['HTTP_HOST']) && !empty($_SERVER['HTTP_HOST'])) {
				$httpHost = $_SERVER['HTTP_HOST'];
				$array['HTTP_HOST'] = $httpHost;
			}
			if (isset($_SERVER['HTTP_CONNECTION']) && !empty($_SERVER['HTTP_CONNECTION'])) {
				$httpConnection = $_SERVER['HTTP_CONNECTION'];
				$array['HTTP_CONNECTION'] = $httpConnection;
			}
			if (isset($_SERVER['HTTP_REFERER'])) {
				$httpReferrer = $_SERVER['HTTP_REFERER'];
				$array['HTTP_REFERER'] = $httpReferrer;
			}
			if (!empty($array)) {
				$this->setArrLog($array);
			}
		}
	}

	//could add rollback method

	// debugMode
	public function getDebugMode()
	{
		if (isset($this->masterValues['global']['debugMode'])) {
			$debugMode = $this->masterValues['global']['debugMode'];
		} else {
			$debugMode = false;
		}

		// global_admin only
		$actualUserRole = $this->getActualUserRole();
		if ($actualUserRole <> 'global_admin') {
			$debugMode = false;
		}

		return $debugMode;
	}
	public function setDebugMode($debugMode = false)
	{
		$this->masterValues['global']['debugMode'] = $debugMode;
	}

	// cssDebugMode
	public function getCssDebugMode()
	{
		if (isset($this->masterValues['global']['cssDebugMode'])) {
			$cssDebugMode = $this->masterValues['global']['cssDebugMode'];
		} else {
			$cssDebugMode = false;
		}

		// global_admin only
		$actualUserRole = $this->getActualUserRole();
		if ($actualUserRole <> 'global_admin') {
			$cssDebugMode = false;
		}

		return $cssDebugMode;
	}
	public function setCssDebugMode($cssDebugMode = false)
	{
		$this->masterValues['global']['cssDebugMode'] = $cssDebugMode;
	}

	// javaScriptDebugMode
	public function getJavaScriptDebugMode()
	{
		if (isset($this->masterValues['global']['javaScriptDebugMode'])) {
			$javaScriptDebugMode = $this->masterValues['global']['javaScriptDebugMode'];
		} else {
			$javaScriptDebugMode = false;
		}

		// global_admin only
		$actualUserRole = $this->getActualUserRole();
		if ($actualUserRole <> 'global_admin') {
			$javaScriptDebugMode = false;
		}

		return $javaScriptDebugMode;
	}
	public function setJavaScriptDebugMode($javaScriptDebugMode = false)
	{
		$this->masterValues['global']['javaScriptDebugMode'] = $javaScriptDebugMode;
	}

	// showJSExceptions
	public function getShowJSExceptions()
	{
		if (isset($this->masterValues['global']['showJSExceptions'])) {
			$showJSExceptions = $this->masterValues['global']['showJSExceptions'];
		} else {
			$showJSExceptions = false;
		}

		// global_admin only
		$actualUserRole = $this->getActualUserRole();
		if ($actualUserRole <> 'global_admin') {
			$showJSExceptions = false;
		}

		return $showJSExceptions;
	}
	public function setShowJSExceptions($showJSExceptions = false)
	{
		$this->masterValues['global']['showJSExceptions'] = $showJSExceptions;
	}

	// ajaxUrlDebugMode
	public function getAjaxUrlDebugMode()
	{
		if (isset($this->masterValues['global']['ajaxUrlDebugMode'])) {
			$ajaxUrlDebugMode = $this->masterValues['global']['ajaxUrlDebugMode'];
		} else {
			$ajaxUrlDebugMode = false;
		}

		// global_admin only
		$actualUserRole = $this->getActualUserRole();
		if ($actualUserRole <> 'global_admin') {
			$ajaxUrlDebugMode = false;
		}

		return $ajaxUrlDebugMode;
	}
	public function setAjaxUrlDebugMode($ajaxUrlDebugMode = false)
	{
		$this->masterValues['global']['ajaxUrlDebugMode'] = $ajaxUrlDebugMode;
	}

	// consoleLoggingMode
	public function getConsoleLoggingMode()
	{
		if (isset($this->masterValues['global']['consoleLoggingMode'])) {
			$consoleLoggingMode = $this->masterValues['global']['consoleLoggingMode'];
		} else {
			$consoleLoggingMode = false;
		}

		// global_admin only
		$actualUserRole = $this->getActualUserRole();
		if ($actualUserRole <> 'global_admin') {
			$consoleLoggingMode = false;
		}

		return $consoleLoggingMode;
	}
	public function setConsoleLoggingMode($consoleLoggingMode = false)
	{
		$this->masterValues['global']['consoleLoggingMode'] = $consoleLoggingMode;
	}

	// requestedUri
	public function getRequestedUri()
	{
		if (isset($this->masterValues['global']['requestedUri'])) {
			$requestedUri = $this->masterValues['global']['requestedUri'];
		} else {
			$requestedUri = null;
		}

		return $requestedUri;
	}
	public function setRequestedUri($requestedUri = null)
	{
		$this->masterValues['global']['requestedUri'] = $requestedUri;
	}

	// actual_user_company_id
	public function getActualUserCompanyId()
	{
		if (isset($this->masterValues['global']['actual_user_company_id'])) {
			$user_company_id = $this->masterValues['global']['actual_user_company_id'];
		} else {
			$user_company_id = null;
		}

		return $user_company_id;
	}
	public function setActualUserCompanyId($user_company_id = null)
	{
		$this->masterValues['global']['actual_user_company_id'] = $user_company_id;
	}

	// user_company_id
	public function getUserCompanyId()
	{
		if (isset($this->masterValues['global']['user_company_id'])) {
			$user_company_id = $this->masterValues['global']['user_company_id'];
		} else {
			$user_company_id = null;
		}

		return $user_company_id;
	}
	public function setUserCompanyId($input = null)
	{
		$this->masterValues['global']['user_company_id'] = $input;
	}

	// actual_user_id
	public function getActualUserId()
	{
		if (isset($this->masterValues['global']['actual_user_id'])) {
			$user_id = $this->masterValues['global']['actual_user_id'];
		} else {
			$user_id = null;
		}

		return $user_id;
	}
	public function setActualUserId($user_id = null)
	{
		$this->masterValues['global']['actual_user_id'] = $user_id;
	}

	// user_id
	public function getUserId()
	{
		//return $_SESSION['user_recid'];

		if (isset($this->masterValues['global']['user_id'])) {
			$user_id = $this->masterValues['global']['user_id'];
		} else {
			$user_id = null;
		}

		return $user_id;
	}
	public function setUserId($user_id = null)
	{
		//$_SESSION['user_id'] = $user_id;
		$this->masterValues['global']['user_id'] = $user_id;
	}

	/**
	 * actual_primary_contact_id
	 *
	 * Each user has a contact record for their user_company_id
	 * Users may have many contact_id values, but only one per user_company_id value.
	 * I.e. a user may be a contact in many GC contact lists.
	 *
	 * @return int primary_contact_id
	 */
	public function getActualPrimaryContactId()
	{
		if (isset($this->masterValues['global']['actual_primary_contact_id'])) {
			$actual_primary_contact_id = $this->masterValues['global']['actual_primary_contact_id'];
		} else {
			$actual_primary_contact_id = null;
		}

		return $actual_primary_contact_id;
	}
	public function setActualPrimaryContactId($actual_primary_contact_id = null)
	{
		$this->masterValues['global']['actual_primary_contact_id'] = $actual_primary_contact_id;
	}

	/**
	 * primary_contact_id
	 *
	 * Each user has a contact record for their user_company_id
	 * Users may have many contact_id values, but only one per user_company_id value.
	 * I.e. a user may be a contact in many GC contact lists.
	 *
	 * @return int primary_contact_id
	 */
	public function getPrimaryContactId()
	{
		if (isset($this->masterValues['global']['primary_contact_id'])) {
			$primary_contact_id = $this->masterValues['global']['primary_contact_id'];
		} else {
			$primary_contact_id = null;
		}

		return $primary_contact_id;
	}
	public function setPrimaryContactId($primary_contact_id = null)
	{
		$this->masterValues['global']['primary_contact_id'] = $primary_contact_id;
	}

	// $actualUserRole
	public function getActualUserRole()
	{
		if (isset($this->masterValues['global']['actualUserRole'])) {
			$userRole = $this->masterValues['global']['actualUserRole'];
		} else {
			$userRole = null;
		}

		return $userRole;
	}
	public function setActualUserRole($userRole = null)
	{
		$this->masterValues['global']['actualUserRole'] = $userRole;
	}

	// $userRole
	public function getUserRole()
	{
		if (isset($this->masterValues['global']['userRole'])) {
			$userRole = $this->masterValues['global']['userRole'];
		} else {
			$userRole = null;
		}

		return $userRole;
	}
	public function setUserRole($userRole = null)
	{
		$this->masterValues['global']['userRole'] = $userRole;
	}

	// actual_role_id
	public function getActualRoleId()
	{
		if (isset($this->masterValues['global']['actual_role_id'])) {
			$actual_role_id = $this->masterValues['global']['actual_role_id'];
		} else {
			$actual_role_id = null;
		}

		return $actual_role_id;
	}
	public function setActualRoleId($actual_role_id = null)
	{
		$this->masterValues['global']['actual_role_id'] = $actual_role_id;
	}

	// role_id
	public function getRoleId()
	{
		if (isset($this->masterValues['global']['role_id'])) {
			$role_id = $this->masterValues['global']['role_id'];
		} else {
			$role_id = null;
		}

		return $role_id;
	}
	public function setRoleId($role_id = null)
	{
		$this->masterValues['global']['role_id'] = $role_id;
	}

	// actual_login_name
	public function getActualLoginName() {
		if (isset($this->masterValues['global']['actual_login_name'])) {
			$login_name = $this->masterValues['global']['actual_login_name'];
		} else {
			$login_name = null;
		}

		return $login_name;
	}
	public function setActualLoginName($input = null) {
		$this->masterValues['global']['actual_login_name'] = $input;
	}

	// login_name
	public function getLoginName() {
		//return $_SESSION['login_name'];
		//return (isset($this->masterValues['global']['login_name']) ? $this->masterValues['global']['login_name'] : null);

		if (isset($this->masterValues['global']['login_name'])) {
			$login_name = $this->masterValues['global']['login_name'];
		} else {
			$login_name = null;
		}

		return $login_name;
	}
	public function setLoginName($input = null) {
		//$_SESSION['login_name'] = $input;
		$this->masterValues['global']['login_name'] = $input;
	}

	// actualCurrentlySelectedProjectUserCompanyId
	public function getActualCurrentlySelectedProjectUserCompanyId()
	{
		if (isset($this->masterValues['global']['actualCurrentlySelectedProjectUserCompanyId'])) {
			$actualCurrentlySelectedProjectUserCompanyId = $this->masterValues['global']['actualCurrentlySelectedProjectUserCompanyId'];
		} else {
			$actualCurrentlySelectedProjectUserCompanyId = null;
		}

		return $actualCurrentlySelectedProjectUserCompanyId;
	}
	public function setActualCurrentlySelectedProjectUserCompanyId($actualCurrentlySelectedProjectUserCompanyId = null)
	{
		$this->masterValues['global']['actualCurrentlySelectedProjectUserCompanyId'] = $actualCurrentlySelectedProjectUserCompanyId;
	}

	// currentlySelectedProjectUserCompanyId
	public function getCurrentlySelectedProjectUserCompanyId()
	{
		if (isset($this->masterValues['global']['currentlySelectedProjectUserCompanyId'])) {
			$currentlySelectedProjectUserCompanyId = $this->masterValues['global']['currentlySelectedProjectUserCompanyId'];
		} else {
			$currentlySelectedProjectUserCompanyId = null;
		}

		return $currentlySelectedProjectUserCompanyId;
	}
	public function setCurrentlySelectedProjectUserCompanyId($currentlySelectedProjectUserCompanyId = null)
	{
		$this->masterValues['global']['currentlySelectedProjectUserCompanyId'] = $currentlySelectedProjectUserCompanyId;
	}

	// actualCurrentlySelectedProjectId
	public function getActualCurrentlySelectedProjectId()
	{
		if (isset($this->masterValues['global']['actualCurrentlySelectedProjectId'])) {
			$actualCurrentlySelectedProjectId = $this->masterValues['global']['actualCurrentlySelectedProjectId'];
		} else {
			$actualCurrentlySelectedProjectId = null;
		}

		return $actualCurrentlySelectedProjectId;
	}
	public function setActualCurrentlySelectedProjectId($actualCurrentlySelectedProjectId = null)
	{
		$this->masterValues['global']['actualCurrentlySelectedProjectId'] = $actualCurrentlySelectedProjectId;
	}

	// currentlySelectedProjectId
	public function getCurrentlySelectedProjectId()
	{
		if (isset($this->masterValues['global']['currentlySelectedProjectId'])) {
			$currentlySelectedProjectId = $this->masterValues['global']['currentlySelectedProjectId'];
		} else {
			$currentlySelectedProjectId = null;
		}

		return $currentlySelectedProjectId;
	}
	public function setCurrentlySelectedProjectId($currentlySelectedProjectId = null)
	{
		$this->masterValues['global']['currentlySelectedProjectId'] = $currentlySelectedProjectId;
	}

	/**
	 * actualCurrentlyActiveContactId
	 *
	 * Each user may have many contact_id values, but only one per user_company_id value.
	 * I.e. a user may be a contact in many GC contact lists.
	 * The $currentlySelectedProjectId has an owner (user_company_id that owns the project) and the users contact_id
	 * in that companies contacts list is this value here.
	 *
	 * @return int actualCurrentlyActiveContactId
	 */
	public function getActualCurrentlyActiveContactId()
	{
		if (isset($this->masterValues['global']['actualCurrentlyActiveContactId'])) {
			$actualCurrentlyActiveContactId = $this->masterValues['global']['actualCurrentlyActiveContactId'];
		} else {
			$actualCurrentlyActiveContactId = null;
		}

		return $actualCurrentlyActiveContactId;
	}
	public function setActualCurrentlyActiveContactId($actualCurrentlyActiveContactId = null)
	{
		$this->masterValues['global']['actualCurrentlyActiveContactId'] = $actualCurrentlyActiveContactId;
	}

	/**
	 * currentlyActiveContactId
	 *
	 * Each user may have many contact_id values, but only one per user_company_id value.
	 * I.e. a user may be a contact in many GC contact lists.
	 * The $currentlySelectedProjectId has an owner (user_company_id that owns the project) and the users contact_id
	 * in that companies contacts list is this value here.
	 *
	 * @return int currentlyActiveContactId
	 */
	public function getCurrentlyActiveContactId()
	{
		if (isset($this->masterValues['global']['currentlyActiveContactId'])) {
			$currentlyActiveContactId = $this->masterValues['global']['currentlyActiveContactId'];
		} else {
			$currentlyActiveContactId = null;
		}

		return $currentlyActiveContactId;
	}
	public function setCurrentlyActiveContactId($currentlyActiveContactId = null)
	{
		$this->masterValues['global']['currentlyActiveContactId'] = $currentlyActiveContactId;
	}

	// actualCurrentlySelectedProjectName
	public function getActualCurrentlySelectedProjectName()
	{
		if (isset($this->masterValues['global']['actualCurrentlySelectedProjectName'])) {
			$actualCurrentlySelectedProjectName = $this->masterValues['global']['actualCurrentlySelectedProjectName'];
		} else {
			$actualCurrentlySelectedProjectName = null;
		}

		return $actualCurrentlySelectedProjectName;
	}
	public function setActualCurrentlySelectedProjectName($actualCurrentlySelectedProjectName = null)
	{
		$this->masterValues['global']['actualCurrentlySelectedProjectName'] = $actualCurrentlySelectedProjectName;
	}

	// currentlySelectedProjectName
	public function getCurrentlySelectedProjectName()
	{
		if (isset($this->masterValues['global']['currentlySelectedProjectName'])) {
			$currentlySelectedProjectName = $this->masterValues['global']['currentlySelectedProjectName'];
		} else {
			$currentlySelectedProjectName = null;
		}

		return $currentlySelectedProjectName;
	}
	public function setCurrentlySelectedProjectName($currentlySelectedProjectName = null)
	{
		$this->masterValues['global']['currentlySelectedProjectName'] = $currentlySelectedProjectName;
	}

	// currentlySelectedSoftwareCategory
	public function getCurrentlySelectedSoftwareCategory()
	{
		if (isset($this->masterValues['global']['currentlySelectedSoftwareCategory'])) {
			$currentlySelectedSoftwareCategory = $this->masterValues['global']['currentlySelectedSoftwareCategory'];
		} else {
			$currentlySelectedSoftwareCategory = null;
		}

		return $currentlySelectedSoftwareCategory;
	}
	public function setCurrentlySelectedSoftwareCategory($currentlySelectedSoftwareCategory = null)
	{
		$this->masterValues['global']['currentlySelectedSoftwareCategory'] = $currentlySelectedSoftwareCategory;
	}

	// currentlySelectedSoftwareModule
	public function getCurrentlySelectedSoftwareModule()
	{
		if (isset($this->masterValues['global']['currentlySelectedSoftwareModule'])) {
			$currentlySelectedSoftwareModule = $this->masterValues['global']['currentlySelectedSoftwareModule'];
		} else {
			$currentlySelectedSoftwareModule = null;
		}

		return $currentlySelectedSoftwareModule;
	}
	public function setCurrentlySelectedSoftwareModule($currentlySelectedSoftwareModule = null)
	{
		$this->masterValues['global']['currentlySelectedSoftwareModule'] = $currentlySelectedSoftwareModule;
	}

	// currentlySelectedSoftwareModuleFunction
	public function getCurrentlySelectedSoftwareModuleFunction()
	{
		if (isset($this->masterValues['global']['currentlySelectedSoftwareModuleFunction'])) {
			$currentlySelectedSoftwareModuleFunction = $this->masterValues['global']['currentlySelectedSoftwareModuleFunction'];
		} else {
			$currentlySelectedSoftwareModuleFunction = null;
		}

		return $currentlySelectedSoftwareModuleFunction;
	}
	public function setCurrentlySelectedSoftwareModuleFunction($currentlySelectedSoftwareModuleFunction = null)
	{
		$this->masterValues['global']['currentlySelectedSoftwareModuleFunction'] = $currentlySelectedSoftwareModuleFunction;
	}

	/**
	 * currentlyActiveTemplateTheme
	 *
	 *
	 * @return int currentlyActiveTemplateTheme
	 */
	public function getActualCurrentlyActiveTemplateTheme()
	{
		if (isset($this->masterValues['global']['actualCurrentlyActiveTemplateTheme'])) {
			$actualCurrentlyActiveTemplateTheme = $this->masterValues['global']['actualCurrentlyActiveTemplateTheme'];
		} else {
			$actualCurrentlyActiveTemplateTheme = null;
		}

		return $actualCurrentlyActiveTemplateTheme;
	}
	public function setActualCurrentlyActiveTemplateTheme($actualCurrentlyActiveTemplateTheme = null)
	{
		$this->masterValues['global']['actualCurrentlyActiveTemplateTheme'] = $actualCurrentlyActiveTemplateTheme;
	}
	public function getCurrentlyActiveTemplateTheme()
	{
		if (isset($this->masterValues['global']['currentlyActiveTemplateTheme'])) {
			$currentlyActiveTemplateTheme = $this->masterValues['global']['currentlyActiveTemplateTheme'];
		} else {
			$currentlyActiveTemplateTheme = null;
		}

		return $currentlyActiveTemplateTheme;
	}
	public function setCurrentlyActiveTemplateTheme($currentlyActiveTemplateTheme = null)
	{
		$this->masterValues['global']['currentlyActiveTemplateTheme'] = $currentlyActiveTemplateTheme;
	}

	// authentication check
	public function isUserAuthenticated()
	{
		$user_id = $this->getUserId();

		if (isset($user_id) && ($user_id > 0)) {
			return true;
		} else {
			return false;
		}
	}

	// user_profile_id
	public function getUserProfileId()
	{
		if (isset($this->masterValues['global']['user_profile_id'])) {
			return $this->masterValues['global']['user_profile_id'];
		} else {
			return null;
		}
	}
	public function setUserProfileId($input = null)
	{
		$this->masterValues['global']['user_profile_id'] = $input;
	}
	public function getUserProfileNewRecordFlag()
	{
		if (isset($this->masterValues['global']['user_profile_new_record_flag'])) {
			return $this->masterValues['global']['user_profile_new_record_flag'];
		} else {
			return false;
		}
	}
	public function setUserProfileNewRecordFlag($input = null)
	{
		$this->masterValues['global']['user_profile_new_record_flag'] = $input;
	}
	public function getUserProfile()
	{
		if (isset($this->masterValues['global']['user_profile_object'])) {
			return $this->masterValues['global']['user_profile_object'];
		} else {
			return false;
		}
	}
	public function setUserProfile($input = null)
	{
		$this->masterValues['global']['user_profile_object'] = $input;
	}


	// user_image_id
	public function getUserImageId()
	{
		if (isset($this->masterValues['global']['user_image_id'])) {
			return $this->masterValues['global']['user_image_id'];
		} else {
			return null;
		}
	}
	public function setUserImageId($input = null)
	{
		$this->masterValues['global']['user_image_id'] = $input;
	}

	//user_role_recid
	public function getUserRoleRecid() {
		return isset($_SESSION['user_role_recid']) ? $_SESSION['user_role_recid'] : null;
		//return $this->masterValues['global']['user_role_recid'];
	}
	public function setUserRoleRecid($input = null) {
		$_SESSION['user_role_recid'] = $input;
		$this->masterValues['global']['user_role_recid'] = $input;
	}
	public function isUserStoreAdmin() {
		if ($_SESSION['user_role_recid'] == 5) {
			return true;
		} else {
			return false;
		}
	}

	//user_to_account_recid
	public function getUserToAccountRecid() {
		return $_SESSION['user_to_account_recid'];
		//return $this->masterValues['global']['user_to_account_recid'];
	}
	public function setUserToAccountRecid($input = null) {
		$_SESSION['user_to_account_recid'] = $input;
		$this->masterValues['global']['user_to_account_recid'] = $input;
	}

	//account_recid
	public function getAccountRecid() {
		return isset($_SESSION['account_recid']) ? $_SESSION['account_recid'] : null;
		//return $this->masterValues['global']['account_recid'];
	}
	public function setAccountRecid($input = null) {
		$_SESSION['account_recid'] = $input;
		$this->masterValues['global']['account_recid'] = $input;
	}

	//account_name
	public function getAccountName() {
		return (isset($_SESSION['account_name']) ? $_SESSION['account_name'] : null);
		//return $this->masterValues['global']['account_name'];
	}
	public function setAccountName($input = null) {
		$_SESSION['account_name'] = $input;
		$this->masterValues['global']['account_name'] = $input;
	}

	//account_logo
	public function getAccountLogo() {
		return $_SESSION['account_logo'];
		//return $this->masterValues['global']['account_logo'];
	}
	public function setAccountLogo($logoUrl = null) {
		$_SESSION['account_logo'] = $logoUrl;
		$this->masterValues['global']['account_logo'] = $logoUrl;
	}

	//rollup_shipping_price_ind
	public function getRollupShippingPriceInd() {
		return $_SESSION['rollup_shipping_price_ind'];
		//return $this->masterValues['global']['rollup_shipping_price_ind'];
	}
	public function setRollupShippingPriceInd($input = null) {
		$_SESSION['rollup_shipping_price_ind'] = $input;
		$this->masterValues['global']['rollup_shipping_price_ind'] = $input;
	}

	//tax_exempt_ind
	public function getTaxExemptInd() {
		return $_SESSION['tax_exempt_ind'];
		//return $this->masterValues['global']['tax_exempt_ind'];
	}
	public function setTaxExemptInd($input = null) {
		$_SESSION['tax_exempt_ind'] = $input;
		$this->masterValues['global']['tax_exempt_ind'] = $input;
	}

	//session data associated flag
	public function getAccountInfoAssociated() {
		return $_SESSION['account_info_associated'];
		//return $this->masterValues['global']['account_info_associated'];
	}
	public function setAccountInfoAssociated($input = null) {
		$_SESSION['account_info_associated'] = $input;
		$this->masterValues['global']['account_info_associated'] = $input;
	}

	public function unsetStagingDate() {
		if (isset($this->_data['staging_date'])) {
			unset($this->_data['staging_date']);
		}
	}

	public function getGet() { return $this->get; }
	public function setGet($input = null) { $this->get = $input; }

	public function getPost() { return $this->post; }
	public function setPost($input = null) { $this->post = $input; }

	public function getRequest() { return $this->request; }
	public function setRequest($input = null) { $this->request = $input; }

	public function getCookie() { return $this->cookie; }
	public function setCookie($input = null) { $this->cookie = $input; }

	public function getArrError() { return $this->arrErrors; }
	public function setArrError($input = null) { $this->arrErrors = $input; }

	public function getArrMessage() { return $this->arrMessage; }
	public function setArrMessage($input = null) { $this->arrMessage = $input; }

	public function getArrLog() { return $this->arrLog; }
	public function setArrLog($input = null) { $this->arrLog = $input; }

	public function getShowError() { return $this->showError; }
	public function setShowError($input = null) { $this->showError = $input; }

	public function getShowMessage() { return $this->showMessage; }
	public function setShowMessage($input = null) { $this->showMessage = $input; }

	public function getFormSubmitted() { return $this->formSubmitted; }
	public function setFormSubmitted($input = null) { $this->formSubmitted = $input; }

	public function getMasterValues() { return $this->masterValues; }
	public function setMasterValues($input = null) { $this->masterValues = $input; }

	public function getMessageQueue() { return $this->messageQueue; }
	public function setMessageQueue($input = null) { $this->messageQueue = $input; }

	public function getIpAddress() { return $this->ipAddress; }
	public function setIpAddress($input = null) { $this->ipAddress = $input; }

	public function getBrowser() { return $this->browser; }
	public function setBrowser($input = null) { $this->browser = $input; }

	public function getLogId() { return $this->logId; }
	public function setLogId($input = null) { $this->logId = $input; }

	public function getWebLogId() { return $this->webLogId; }
	public function setWebLogId($input = null) { $this->webLogId = $input; }

	public function getEmailLogId() { return $this->emailLogId; }
	public function setEmailLogId($input = null) { $this->emailLogId = $input; }

	public function getServerGlobals() { return $this->serverGlobals; }
	public function setServerGlobals($input = null) { $this->serverGlobals = $input; }

	public function getDebugVars() { return $this->debugVars; }
	public function setDebugVars($input = null) { $this->debugVars = $input; }

	public function getItemCount() { return $this->itemCount; }
	public function setItemCount($input = 0) { $this->itemCount = $input; }

	public function getMostRecentProduct() { return $this->mostRecentProduct; }
	public function setMostRecentProduct($input = null) { $this->mostRecentProduct = $input; }

	public function getCartTotal() { return $this->cartTotal; }
	public function setCartTotal($input = null) { $this->cartTotal = $input; }

	public function getCartUpdate() { return $this->cartUpdate; }
	public function setCartUpdate($input = null) { $this->cartUpdate = $input; }

	public function getOrderId() { return $this->orderId; }
	public function setOrderId($input = null) { $this->orderId = $input; }

	public function getFinalOrderId() { return $this->finalOrderId; }
	public function setFinalOrderId($input = null) { $this->finalOrderId = $input; }

	public function getSortChoice() { return $this->sortChoice; }
	public function setSortChoice($input = null) { $this->sortChoice = $input; }

	public function getSearchString() { return $this->searchString; }
	public function setSearchString($input = null) { $this->searchString = $input; }

	public function getSearchCategory() { return $this->searchCategory; }
	public function setSearchCategory($input = null) { $this->searchCategory = $input; }

	public function getSearchSortChoice() { return $this->searchSortChoice; }
	public function setSearchSortChoice($input = null) { $this->searchSortChoice = $input; }

	public function getTemplateId() { return $this->templateId; }
	public function setTemplateId($input = null) { $this->templateId = $input; }

	public function getTemplateFile() { return $this->templateFile; }
	public function setTemplateFile($input = null) { $this->templateFile = $input; }

	public function getSessionStartTime() { return $this->sessionStartTime; }
	public function setSessionStartTime($input = null) { $this->sessionStartTime = $input; }

	public function getAccountLoginTime() { return $this->accountLoginTime; }
	public function setAccountLoginTime($input = null) { $this->accountLoginTime = $input; }

	public function getAccountLastAccessTime() { return $this->accountLastAccessTime; }
	public function setAccountLastAccessTime($input = null) { $this->accountLastAccessTime = $input; }

	public function getAccountCurrentAccessTime() { return $this->accountCurrentAccessTime; }
	public function setAccountCurrentAccessTime($input = null) { $this->accountCurrentAccessTime = $input; }

	public function getUserTimeOut() { return $this->userTimeOut; }
	public function setUserTimeOut($input = null) { $this->userTimeOut = $input; }

	public function getAdminTimeOut() { return $this->adminTimeOut; }
	public function setAdminTimeOut($input = null) { $this->adminTimeOut = $input; }

	public function getUserLoggedIn() { return $this->userLoggedIn; }
	public function setUserLoggedIn($input = null) { $this->userLoggedIn = $input; }

	public function getAdminLoggedIn() { return $this->adminLoggedIn; }
	public function setAdminLoggedIn($input = null) { $this->adminLoggedIn = $input; }

	public function getLoginStatusMessage() { return $this->loginStatus; }
	public function setLoginStatusMessage($input = null) { $this->loginStatus = $input; }

	public function getLoginScreenMessage() { return $this->loginScreenMessage; }
	public function setLoginScreenMessage($input = null) { $this->loginScreenMessage = $input; }

	public function getUserAccountMessage() { return $this->userAccountMessage; }
	public function setUserAccountMessage($input = null) { $this->userAccountMessage = $input; }

	public function getAdminAccountMessage() { return $this->adminAccountMessage; }
	public function setAdminAccountMessage($input = null) { $this->adminAccountMessage = $input; }

	public function getDisplayMessage() { return $this->displayMessage; }
	public function setDisplayMessage($input = null) { $this->displayMessage = $input; }

	public function getModifyAccount() { return $this->modifyAccount; }
	public function setModifyAccount($input = false) { $this->modifyAccount = $input; }

	public function getTimedOutMessage() { return $this->timedOutMessage; }
	public function setTimedOutMessage($input = null) { $this->timedOutMessage = $input; }

	public function getModifyUserAccount() { return $this->modifyUserAccount; }
	public function setModifyUserAccount($input = false) { $this->modifyUserAccount = $input; }

	public function getModifyUserEmail() { return $this->modifyUserEmail; }
	public function setModifyUserEmail($input = false) { $this->modifyUserEmail = $input; }

	public function getModifyUserPassword() { return $this->modifyUserPassword; }
	public function setModifyUserPassword($input = false) { $this->modifyUserPassword = $input; }

	public function getUserChat() { return $this->userChat; }
	public function setUserChat($input = false) { $this->userChat = $input; }

	public function getModifyEmail() { return $this->modifyEmail; }
	public function setModifyEmail($input = false) { $this->modifyEmail = $input; }

	public function getModifyPassword() { return $this->modifyPassword; }
	public function setModifyPassword($input = false) { $this->modifyPassword = $input; }

	public function getChat() { return $this->chat; }
	public function setChat($input = false) { $this->chat = $input; }

	public function getForgotPassword() { return $this->forgotPassword; }
	public function setForgotPassword($input = false) { $this->forgotPassword = $input; }

	public function getModifyAdminAccount() { return $this->modifyAdminAccount; }
	public function setModifyAdminAccount($input = false) { $this->modifyAdminAccount = $input; }

	public function getModifyAdminEmail() { return $this->modifyAdminEmail; }
	public function setModifyAdminEmail($input = false) { $this->modifyAdminEmail = $input; }

	public function getModifyAdminPassword() { return $this->modifyAdminPassword; }
	public function setModifyAdminPassword($input = false) { $this->modifyAdminPassword = $input; }

	public function getAdminChat() { return $this->userChat; }
	public function setAdminChat($input = false) { $this->userChat = $input; }

	public function getAdminUpdate() { return $this->adminUpdate; }
	public function setAdminUpdate($input = false) { $this->adminUpdate = $input; }

	public function getPaymentMethod() { return $this->paymentMethod; }
	public function setPaymentMethod($input = null) { $this->paymentMethod = $input; }

	public function getPaymentAmount() { return $this->paymentAmount; }
	public function setPaymentAmount($input = null) { $this->paymentAmount = $input; }

	public function getPaymentDetails() { return $this->paymentDetails; }
	public function setPaymentDetails($input = null) { $this->paymentDetails = $input; }

	public function getInvoice() { return $this->invoice; }
	public function setInvoice($input = null) { $this->invoice = $input; }

	public function getPaymentAdded() { return $this->paymentAdded; }
	public function setPaymentAdded($input = false) { $this->paymentAdded = $input; }

	public function getPaymentEdit() { return $this->paymentEdit; }
	public function setPaymentEdit($input = false) { $this->paymentEdit = $input; }

	public function getCheckoutOk() { return $this->checkoutOk; }
	public function setCheckoutOk($input = false) { $this->checkoutOk = $input; }

	public function getLogOut() { return $this->logOut; }
	public function setLogOut($input = false) { $this->logOut = $input; }

	//gpe stands for get post error (resets stdin and stderr streams)
	public function gpmeReset() {
		$array = array();
		$this->setGet($array);
		$this->setPost($array);
		$this->setArrError($array);
		$this->setArrMessage($array);
	}


	//reset error and display messages
	public function messagesReset() {
		$array = array();
		$this->setArrError($array);
		$this->setArrMessage($array);
	}


	//reset anonymous user tracking
	public function anonymousTrackingReset() {
		$this->setBrowser(null);
		$this->setLogId(null);
	}


	public function debugReset() {
		$this->setServerGlobals(null);
		$this->setDebugVars(null);
	}


	public function cartReset() {
		$this->setItemCount(0);
		$this->setMostRecentProduct(null);
		$this->setCartTotal(null);
		$this->setCartUpdate(null);
	}


	public function orderReset() {
		$this->setOrderId(null);
		$this->setFinalOrderId(null);
	}


	public function searchReset() {
		$this->setSearchString(null);
		$this->setSearchCategory(0);
		$this->setSearchSortChoice(null);
	}


	public function templateReset() {
		$this->setTemplateId(null);
	}


	public function sessionTimersReset() {
		$time = time();
		$this->setSessionStartTime($time);
		$this->setAccountLoginTime(null);
		$this->setAccountLastAccessTime(null);
		$this->setAccountCurrentAccessTime(null);
	}


	public function sessionStartTimeReset() {
		$this->setSessionStartTime(time());
	}


	public function timeoutValuesReset() {
		$this->setUserTimeOut(_USER_TIME_OUT_);
		$this->setAdminTimeOut(_ADMIN_TIME_OUT_);
	}


	public function accountModifierFlagsReset() {
		$this->setModifyAccount(false);
		$this->setModifyEmail(false);
		$this->setModifyPassword(false);
		$this->setChat(false);
		$this->setForgotPassword(false);
	}


	public function paymentFlagsReset() {
		$this->setPaymentMethod(null);
		$this->setPaymentAmount(null);
		$this->setPaymentDetails(null);
		$this->setInvoice(null);
		$this->setPaymentAdded(false);
		$this->setPaymentEdit(false);
		$this->setCheckoutOk(false);
	}


	//call all reset methods for total loss of state data
	public function sessionReset() {
		$this->gpeReset();
		$this->anonymousTrackingReset();
		$this->debugReset();
		$this->cartReset();
		$this->orderReset();
		$this->searchReset();
		$this->templateReset();
		$this->sessionTimersReset();
		$this->sessionStartTimeReset();
		$this->timeoutValuesReset();
		$this->accountModifierFlagsReset();
		$this->paymentFlagsReset();
		$this->statusFlagReset();
		$this->screenMessagesReset();
		$this->userAccountModifierFlagsResetReset();
		$this->adminAccountModifierFlagsResetReset();
		$this->paymentFlagsResetReset();
		$this->screenMessagesReset();
		$this->userAccountModifierFlagsResetReset();
		$this->adminAccountModifierFlagsResetReset();
		$this->paymentFlagsResetReset();

		$this->completeLogOut();
	}


	public function sessionKill() {
		//set factory method static instance flag to false
		self::$_instance = false;
		self::$_instanceAdmin = false;
		//kill session superglobal "session" key and value
		if (isset($_SESSION['session']))
			unset($_SESSION['session']);
		if (isset($_SESSION['session_admin']))
			unset($_SESSION['session_admin']);
	}

	public function sessionDestroy() {
		session_destroy();
	}

	static public function destroy($scope=null) {
		if (is_null($scope)) {
			session_destroy();
		} else {
			if ($scope === 'admin') { unset($_SESSION['session_admin']); }
			else                    { unset($_SESSION['session']);       }
		}
	}

	/**
	 * Logout a user.
	 *
	 */
	public function logOut()
	{
		// kill user_company_id
		unset($this->masterValues['global']['actual_user_company_id']);
		unset($this->masterValues['global']['user_company_id']);

		// kill user_id
		unset($this->masterValues['global']['actual_user_id']);
		unset($this->masterValues['global']['user_id']);

		// kill primary_contact_id
		unset($this->masterValues['global']['actual_primary_contact_id']);
		unset($this->masterValues['global']['primary_contact_id']);

		// kill role_id
		unset($this->masterValues['global']['actual_role_id']);
		unset($this->masterValues['global']['role_id']);

		// kill userRole
		unset($this->masterValues['global']['actualUserRole']);
		unset($this->masterValues['global']['userRole']);

		// kill login_name
		unset($this->masterValues['global']['actual_login_name']);
		unset($this->masterValues['global']['login_name']);

		// kill currentlySelectedProjectUserCompanyId
		unset($this->masterValues['global']['actualCurrentlySelectedProjectUserCompanyId']);
		unset($this->masterValues['global']['currentlySelectedProjectUserCompanyId']);

		// kill currentlySelectedProjectId
		unset($this->masterValues['global']['actualCurrentlySelectedProjectId']);
		unset($this->masterValues['global']['currentlySelectedProjectId']);

		// kill currentlyActiveContactId
		unset($this->masterValues['global']['actualCurrentlyActiveContactId']);
		unset($this->masterValues['global']['currentlyActiveContactId']);

		// currentlySelectedProjectName
		unset($this->masterValues['global']['actualCurrentlySelectedProjectName']);
		unset($this->masterValues['global']['currentlySelectedProjectName']);

		// currentlySelectedProjectName
		unset($this->masterValues['global']['actualCurrentlyActiveTemplateTheme']);
		unset($this->masterValues['global']['currentlyActiveTemplateTheme']);

		// kill requestedUri
		unset($this->masterValues['global']['requestedUri']);

		//reset timers to null
		$this->setAccountLoginTime(null);
		$this->setAccountLastAccessTime(null);
		$this->setAccountCurrentAccessTime(null);

		//reset account modifier flags
		$this->setModifyAccount(false);
		$this->setModifyEmail(false);
		$this->setModifyPassword(false);
		$this->setChat(false);
		$this->setForgotPassword(false);
		$this->setLogOut(true);
	}


//	public function logOut() {
//		unset($_SESSION['user_recid']);
//		unset($_SESSION['user_role_recid']);
//		unset($_SESSION['login_name']);
//		unset($_SESSION['destination_bookmark']);
//
//		//reset timers to null
//		$this->setAccountLoginTime(null);
//		$this->setAccountLastAccessTime(null);
//		$this->setAccountCurrentAccessTime(null);
//
//		//reset account modifier flags
//		$this->setModifyAccount(false);
//		$this->setModifyEmail(false);
//		$this->setModifyPassword(false);
//		$this->setChat(false);
//		$this->setForgotPassword(false);
//	}


	public function userLogOut() {
		//do not unset account and user_to_account so user can log back in and have same account assocations

		unset($_SESSION['account_recid']);
		unset($_SESSION['account_name']);
		unset($_SESSION['account_logo']);
		unset($_SESSION['user_recid']);
		unset($_SESSION['user_role_recid']);
		unset($_SESSION['login_name']);
		unset($_SESSION['user_to_account_recid']);
		unset($_SESSION['destination_bookmark']);
		unset($_SESSION['rollup_shipping_price_ind']);
		unset($_SESSION['tax_exempt_ind']);
		$this->unsetStagingDate();
		//anonymous_user_indentifier should never be unset
		//unset($_SESSION['anonymous_user_identifier']);

		//reset timers to null
		$this->setAccountLoginTime(null);
		$this->setAccountLastAccessTime(null);
		$this->setAccountCurrentAccessTime(null);

		//reset account modifier flags
		$this->setModifyAccount(false);
		$this->setModifyEmail(false);
		$this->setModifyPassword(false);
		$this->setChat(false);
		$this->setForgotPassword(false);
	}


	public function adminLogOut() {
		//log admin user out
		$this->setAdminLoggedIn(false);

		//additional log user out (redundancy)
		//additional flag free floating in $_SESSION for extra security
		if (isset($_SESSION["adminLoginOk"]))
			unset($_SESSION["adminLoginOk"]);

		//reset user id to anonymous user (any negative value)  --> admin user id is 0
		$this->setUserId(-1);

		//reset admin and general account messages
		$this->setLoginStatusMessage(null);
		$this->setLoginScreenMessage(null);
		$this->setAdminAccountMessage(null);
		$this->setDisplayMessage('You Have Successfully Logged Out'); //always use single quotes when not interpolating vars
		$this->setTimedOutMessage(null);

		//reset timers to null
		$this->setAccountLoginTime(null);
		$this->setAccountLastAccessTime(null);
		$this->setAccountCurrentAccessTime(null);

		//reset user account modifier flags
		$this->setModifyAccount(false);
		$this->setModifyEmail(false);
		$this->setModifyPassword(false);
		$this->setChat(false);
		$this->setForgotPassword(false);
	}


	public function completeLogOut() {
		$this->userLogOut();
		$this->adminLogOut();
	}


	function anonymousUserLoginCheck() {
		if (isset($_SESSION['user_recid']) && ($_SESSION['user_recid'] == -1)) {
			return true;
		} else {
			return false;
		}
	}


	public function userLoginCheck() {
		if (isset($_SESSION['user_recid']))
			if (is_long($_SESSION['user_recid']))
				if ($_SESSION['user_recid'] > 0) {
					//timeout check
					$time = time();
					$this->setAccountCurrentAccessTime($time);

					/*
					//timeout check
					if (($this->getAccountCurrentAccessTime() - $this->getAccountLastAccessTime()) > $this->getUserTimeOut()) {
						$this->userLogOut();
						return false;
					}
					*/

					$this->setAccountLastAccessTime($time);

					return true;
				}

		return false;

	}


	public function adminLoginCheck() {
		if (! ($this->getAdminLoggedIn() && $_SESSION["adminLoginOk"])) {
			$this->adminLogOut();
			return false;
		}

		$this->setAccountCurrentAccessTime(time());

		if (($this->getAccountCurrentAccessTime() - $this->getAccountLastAccessTime()) > $this->getAdminTimeOut()) {
			$this->adminLogOut();
			return false;
		}
		else {
			$this->setAccountLastAccessTime($this->getAccountCurrentAccessTime);
			return true;
		}
	}


	public function timedOut() {
		require_once('includes/classes/Message.php');
		$this->completeLogout();
		$arrErrors[] = 'Your Session Has Timed Out&nbsp;&#8212;&nbsp;Please Login Again';
		Message::getInstance()->enqueueError($arrErrors);
		Message::getInstance()->setMessageLocation('existingUser');
		Message::getInstance()->sessionPut();
		header("Location: " . _HTTPS_ . "loginscreen.html");
		exit;
	}//end method timedOut


	public function write() {
		$_SESSION['session'] =  $this;
	}


	//truncate and clean post input
	//inputs: $_POST and truncate length
	//begin: dirty post array
	//end: clean post array ready for plain text display
	function cleanPost2PlainText($post = array(), $maxLength = 0) {
		//select which escape function to use based upon availability
		$function = function_exists("mysql_escape_string") ? "mysql_escape_string" : "addslashes";

		//dirty post stays in POST
		//clean post is placed in session->post
		foreach ($post as &$value) {
			//unescape string if auto-escaped
			if (get_magic_quotes_gpc())
				$value = stripslashes($value);

			//escape every array element including double quotes
			//all data is 1)trimmed, 2)truncated, and
			//3) finally all resulting data is escaped for insertion into the database
			$value = $function(substr(trim($value), 0, $maxLength));
		}

		$this->setPost($post);
	}



	//truncate and clean post input
	//inputs: $_POST and truncate length
	//begin: dirty post array
	//end: clean post array ready for plain text display
	function cleanPost2Html($post = array(), $maxLength = 0) {
		//select which escape function to use based upon availability
		$function = function_exists("mysql_escape_string") ? "mysql_escape_string" : "addslashes";

		//dirty post stays in POST
		//clean post is placed in session->post
		foreach ($post as &$value) {
			//unescape string if auto-escaped
			if (get_magic_quotes_gpc())
				$value = stripslashes($value);

			//escape every array element including double quotes
			//all data is 1)trimmed, 2)truncated, 3)html entitied (special html chars converted to html entities), and
			//4) finally all resulting data is escaped for insertion into the database
			$value = $function(htmlentities(substr(trim($value), 0, $maxLength), ENT_QUOTES));
		}

		$this->setPost($post);
	}


/**
*
* initialize master values for a page
* Input:
* Output:
* Action: 1) initialize an array of master values for a page, 2) GET ui customization
*
*/
	function init() {
		$this->pageAccessCheck();
	}


/**
*
* Require a script to be called over ssl/tls
* Input: none (constraints set in config file)
* Output: Returns true on success and false on failure
* Action: forces a script to call itself over ssl/tls if flag is set
*
*/
	function httpsCheck() {
		//a script can cause the https check to be skipped by defining _HTTPS_DISABLED_ to true
		if (defined('_HTTPS_DISABLED_') && (_HTTPS_DISABLED_ === true)) {
			return;
		}

		//https check -> redirect script back to itself over ssl/tls (https) if not initially invoked over ssl/tls
		if (_HTTPS_REQUIRED_)
			if ($_SERVER["HTTPS"] != "on") {
				$location = _SECURE_DOMAIN_ . $_SERVER['PHP_SELF'];
				$location .= (isset($_SERVER['QUERY_STRING']) && (!empty($_SERVER['QUERY_STRING']))) ? '?' . $_SERVER['QUERY_STRING'] : '';
				header('Location: ' . $location);
				exit;
			}
	}


	/**
	 * Check for session spoofing by preventing access from subsequently different ip address.
	 * Input: none
	 * Output: Returns true on session hijack and false on failure
	 * Action: None
	 *
	 * @return unknown
	 */
	function sessionHiJackedCheck() {
		$tmp = $this->getIpAddress();
		if ($_SERVER['REMOTE_ADDR'] != $tmp) {
			return true;
		} else {
			return false;
		}
	}


/**
*
* Allow/Disallow anonymous browse access to a page (user_recid must always exist and be -1 or a positive integer)
* Input: boolean to indicate if explicit authentication is required for page access (false indicates page allows anonymous access)
* Output: Returns true on success and false on failure
* Action: redirects to loginscreen if page access constraints are violated
*
*/
	function pageAccessCheck($authentication = true) {
		require_once('includes/classes/Message.php');
		//page that allows anonymous access case
		if ($authentication === false) {
			//1) user_recid must be set to -1 or a positive integer in session, otherwise redirect to loginscreen
			if ((!isset($_SESSION['user_recid'])) || (!is_long($_SESSION['user_recid'])) || ($_SESSION['user_recid'] < 1))
				if (is_int($_SESSION['user_recid']) && $_SESSION['user_recid'] == -1) {
					//check if account allows anon login
					//require_once(_TEAM_INCLUDE_PATH_ . 'classes/Authenticate.php');
					require_once('includes/classes/Authenticate.php');
					$auth = new Authenticate();
					$ok = $auth->AnonymousAccountAuthentication($_SESSION['account_recid']);
					if (!$ok) {
						$arrErrors[] = 'Please Login To Enter The Site';
						Message::getInstance()->enqueueError($arrErrors);
						Message::getInstance()->setMessageLocation('existingUser');
						Message::getInstance()->sessionPut();
						//set session destination bookmark
						if (!empty($_SERVER['QUERY_STRING'])) {
							$queryString = '?' . $_SERVER['QUERY_STRING'];
						} else {
							$queryString = '';
						}
						$_SESSION['destination_bookmark'] = _SECURE_DOMAIN_ . $_SERVER['PHP_SELF'] . $queryString;
						header('Location: ' . _HTTPS_ . 'loginscreen.html');
						exit;
					}
				}
				else {
					$arrErrors[] = 'Please Login To Enter The Site';
					Message::getInstance()->enqueueError($arrErrors);
					Message::getInstance()->setMessageLocation('existingUser');
					Message::getInstance()->sessionPut();
					//set session destination bookmark
					if (!empty($_SERVER['QUERY_STRING'])) {
						$queryString = '?' . $_SERVER['QUERY_STRING'];
					} else {
						$queryString = '';
					}
					$_SESSION['destination_bookmark'] = _SECURE_DOMAIN_ . $_SERVER['PHP_SELF'] . $queryString;
					header('Location: ' . _HTTPS_ . 'loginscreen.html');
					exit;
				}
		} //end anonymous access case
		//page that does not allow anonymous access
		else {
			//login check -> user_recid must exist and be a positive integer
			//user_recid must be set to a positive integer in session, otherwise redirect to loginscreen
			if ((!isset($_SESSION['user_recid'])) || (!is_long($_SESSION['user_recid'])) || ($_SESSION['user_recid'] < 1)) {
				$arrErrors[] = 'Please Login To Enter The Site';
				Message::getInstance()->enqueueError($arrErrors);
				Message::getInstance()->setMessageLocation('existingUser');
				Message::getInstance()->sessionPut();
				//set session destination bookmark
				if (!empty($_SERVER['QUERY_STRING'])) {
					$queryString = '?' . $_SERVER['QUERY_STRING'];
				} else {
					$queryString = '';
				}
				$_SESSION['destination_bookmark'] = _SECURE_DOMAIN_ . $_SERVER['PHP_SELF'] . $queryString;
				header('Location: ' . _HTTPS_ . 'loginscreen.html');
				exit;
			}
		} //end auth required case
	}


/**
*
* Set up session vars for anonymous user
* Input: Requires account_recid and account_name
* Output: Returns true on success and false on failure
* Action: sets up session for anonymous user
*
*/
	function anonymousLogin($accountRecid = null, $accountName = null, $rollupShippingPriceInd = null, $taxExemptInd = null) {
		if (isset($accountRecid) && isset($accountName)) {
			/*
			//grab user_role_recid from account default_user_role_recid
			//get account default user_role_recid setting
			require_once('includes/classes/Account.php');
			$account = new Account($_SESSION['account_recid']);
			$account->initAccountInfo();
			$defaultUserRoleRecid = $account->getDefaultUserRoleRecid();
			*/

			//set up session info
			$_SESSION['user_recid'] = -1;
			$_SESSION['user_to_account_recid'] = -1;
			$_SESSION['user_role_recid'] = 2;  // 2 is a browser (maybe an anonymous user_role_recid should be added)
			//$_SESSION['user_role_recid'] = $defaultUserRoleRecid;  // default_anonymous_user_role_recid could be added to admin tool and account table
			$_SESSION['login_name'] = 'anonymous';
			//keep anonymous_user_identifier from session if already set
			if (!isset($_SESSION['anonymous_user_identifier']))
				$_SESSION['anonymous_user_identifier'] = md5(uniqid(mt_rand(), true));
			$_SESSION['account_recid'] = $accountRecid;
			$_SESSION['account_name'] = $accountName;
			$_SESSION['rollup_shipping_price_ind'] = $rollupShippingPriceInd;
			$_SESSION['tax_exempt_ind'] = $taxExemptInd;

			return true;
		} else {
			return false;
		}
	}
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

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
 * Scrub class for uniform data escaping/unescaping for DB or plain text usage
 * and proper post-back html rendering.
 *
 * Scrub data for post-back/email operations and unscrub before passing to db access layer.
 *
 * Data is always in one of two forms: 1) raw (trimmed and truncated), 2) html (htmlentitied)
 * The true "raw" data lives on in the original super global arrays, e.g. $_POST
 *
 * Scrub methods are not static to support templated page layouts with multi-form attributes
 * and nested architectures.
 * Note: Db access layer always gets raw data so it can prepare (escape) the data independently.
 * Steps performed by Scrub class to scrub data :
 *	I. Scenarios - Server Side
 *		A) Validation - Prepare data for server-side validation
 *			1) raw data comes in via get, post, request, or from a data store (xml, database, etc.)
 *			2) raw data is:
 *				a. trimmed - leading and trailing whitespace is removed via php trim() function
 *				b. truncated - each string is truncated to a maxlength via
 * 						php sub_str($str, $maxlength)
 *				c. validated - Perform server-side validation and build an error array,
 * 						if there are any errors
 *
 *		B) Post-back - Prepare data for post-back operation to be rendered as html.
 * 				E.g. on error have "sticky" form
 *			Note: This scenario typically occurs after A and usually only on error condition
 *				  Prepare data to be viewed as html, e.g. for post-back/html rendering
 * 						(make html friendly via htmlentities)
 *				  Data is assumed to be trimmed and truncated
 *			1) raw data is :
 *				a. html entitied - convert special chars to html entitites via
 * 						php htmlentities($str, ENT_QUOTES) function
 *
 *		C) Database Insert - Convert htmlentitied data to raw form to be passed
 * 				to database access layer
 *
 *
 *	II. Scenarios - Client Side
 *		Note: Default character list is defined as param and can be disabled on a
 * 				page basis to allow testing server-side validation
 *				-> This way client-side validation can be added concurrently without
 * 					hampering testing server-side validation
 *		A) Html text input fields (<input type="text">, or <textarea>) -
 * 				Filter a set of unwanted characters
 *			1) Have a js place-holder grab the return contents of
 * 							buildJavaScriptPreventSpecialCharFunction()
 *				a. Optionally pass in a set of the special chars to filter
 *			2) Add onkeypress and onchange event handlers to text input fields to
 * 					filter unwanted characters
 *
 *
 *
 * PHP versions 5
 *
 * @category   Data
 * @package    Scrub
 *
 */

interface iScrub
{
	public function reset();

	//generate a js function to filter html text input fields on the client side
	public function buildJavaScriptPreventSpecialCharFunction($filteredChars = false, $filterStyle = 'exclude', $allowDigits = true);

	//server-side validation preparation trims whitespace and truncates input to a maximum length
	// -> data is still semi-raw for easy regex manipulation, etc.
	// ***Note: Raw data is data that has been processed by these methods
	public function prepareGetForValidation($maxLength = 80);
	public function preparePostForValidation($maxLength = 80);
	public function prepareCookieForValidation($maxLength = 80);
	public function prepareRequestForValidation($maxLength = 80);
	//array of message boxes that have a consistent maxlength
	public function prepareArrMessageBoxForValidation($input = null, $maxLength = 5000);

	//sticky form preparation uses html_entities to make special chars into html entities
	// -> prevents quotes from causing page field bleeds, etc.
	public function prepareGetForGetBack($function = 'htmlentities', $quoteStyle = 'ENT_QUOTES', $maxLength = 80);
	public function preparePostForPostBack($function = 'htmlentities', $quoteStyle = 'ENT_QUOTES', $maxLength = 80);
	public function prepareCookieForCookieBack($function = 'htmlentities', $quoteStyle = 'ENT_QUOTES', $maxLength = 80);
	public function prepareRequestForRequestBack($function = 'htmlentities', $quoteStyle = 'ENT_QUOTES', $maxLength = 80);
	public function prepareMessageBoxForMessageBoxBack($function = 'htmlentities', $quoteStyle = 'ENT_QUOTES', $maxLength = 80);

	//prepare data for pass off to database abstraction layer by getting into raw format
	// -> allows db layer to prepare the data, escape it, etc. using its own routines
	// -> this allows the raw data to be stored in the database
	// Note: May not be necessary, but is available to run html_entity_decode
	public function convertHtmlArrayToRaw($function = 'html_entity_decode', $quoteStyle = 'ENT_QUOTES');
}

class Scrub implements iScrub
{
	//string input
	protected $strRawInput = '';
	protected $strCleanInput = '';
	protected $strDbRawInput = '';

	//array input
	protected $arrRawInput = array();
	protected $arrCleanInput = array();
	protected $arrDbRawInput = '';

	//message box string input
	protected $strRawMessage = '';
	protected $strCleanMessage = '';
	protected $strDbRawMessage = '';

	static protected $instance;

	//GPCRM data containers
	//raw data is 1) trimmed, and 2) truncated, but not escaped or htmlentitied
	//html data is 1) trimmed, 2) truncated, and 3) htmlentitied
	protected $arrRawGet = array();
	protected $arrHtmlGet = array();
	protected $arrRawPost = array();
	protected $arrHtmlPost = array();
	protected $arrRawCookie = array();
	protected $arrHtmlCookie = array();
	protected $arrRawRequest = array();
	protected $arrHtmlRequest = array();
	protected $arrRawMessageBox = array();
	protected $arrHtmlMessageBox = arrAy();

	//constructor
	public function __construct() {
		//initialize instance variables
		$this->reset();
	} //end method __construct

	public static function getInstance()
	{
		$instance = self::$_instance;

		if (!isset($instance)) {
			$instance = new Scrub();
			self::$_instance = $instance;
		}

		return $instance;
	}

	//reset method
	public function reset() {
		$this->strRawInput = '';
		$this->strCleanInput = '';

		$this->arrRawInput = array();
		$this->arrCleanInput = array();

		$this->strRawMessage = '';
		$this->strCleanMessage = '';
	}

	public function __get($varname) { return false; }
	public function __set($varname, $value) { return false; }
	public function __toString() {}
	public function __destruct() {}

	//string input
	public function getStrRawInput() { return $this->strRawInput; }
	public function setStrRawInput( $input = null ) { $this->strRawInput = $input; }
	public function getStrCleanInput() { return $this->strCleanInput; }
	public function setStrCleanInput( $input = null ) { $this->strCleanInput = $input; }

	//array input
	public function getArrRawInput() { return $this->arrRawInput; }
	public function setArrRawInput( $input = array() ) { $this->arrRawInput = $input; }
	public function getArrCleanInput() { return $this->arrCleanInput; }
	public function setArrCleanInput( $input = array() ) { $this->arrCleanInput = $input; }

	//message box string data
	public function getStrRawMessageBox() { return $this->strRawMessage; }
	public function setStrRawMessageBox( $input = null ) { $this->strRawMessage = $input; }
	public function getStrCleanMessageBox() { return $this->strCleanMessage; }
	public function setStrCleanMessageBox( $input = null ) { $this->strCleanMessage = $input; }

	//GPCRM raw data (trimmed and truncated)
	public function getArrRawGet() { return $this->arrRawGet; }
	public function setArrRawGet( $input = array() ) { $this->arrRawGet = $input; }
	public function getArrRawPost() { return $this->arrRawPost; }
	public function setArrRawPost( $input = array() ) { $this->arrRawPost = $input; }
	public function getArrRawCookie() { return $this->arrRawCookie; }
	public function setArrRawCookie( $input = array() ) { $this->arrRawCookie = $input; }
	public function getArrRawRequest() { return $this->arrRawRequest; }
	public function setArrRawRequest( $input = array() ) { $this->arrRawRequest = $input; }
	public function getArrRawMessageBox() { return $this->arrRawRequest; }
	public function setArrRawMessageBox( $input = array() ) { $this->arrRawRequest = $input; }

	//GPCRM html data (htmlentitied)
	public function getArrHtmlGet() { return $this->arrHtmlGet; }
	public function setArrHtmlGet( $input = array() ) { $this->arrHtmlGet = $input; }
	public function getArrHtmlPost() { return $this->arrHtmlPost; }
	public function setArrHtmlPost( $input = array() ) { $this->arrHtmlPost = $input; }
	public function getArrHtmlCookie() { return $this->arrHtmlCookie; }
	public function setArrHtmlCookie( $input = array() ) { $this->arrHtmlCookie = $input; }
	public function getArrHtmlRequest() { return $this->arrHtmlRequest; }
	public function setArrHtmlRequest( $input = array() ) { $this->arrHtmlRequest = $input; }


	//generate a js function to filter html text input fields on the client side
	public function buildJavaScriptPreventSpecialCharFunction($filteredChars = false, $filterStyle = 'exclude', $allowDigits = true)
	{
		if( $filterStyle == 'exclude' ) {
			if( $allowDigits ) {
				$regEx = $filteredChars ? $filteredChars : "/[\s?.+'" . '"' . "!@#$%^&*(){}\[\]:;,~`\\\/<>=-]/g";
			} else {
				$regEx = $filteredChars ? $filteredChars : "/[\s?.+'" . '"' . "!@#$%^&*(){}\[\]:;,~`\\\/<>=-]|\d+/g";
			}
		} elseif( $filterStyle == 'include' ) {
			if( $allowDigits ) {
				$regEx = $filteredChars ? $filteredChars : "/[^\s?.+'" . '"' . "!@#$%^&*(){}\[\]:;,~`\\\/<>=-]/g";
			} else {
				$regEx = $filteredChars ? $filteredChars : "/[^\s?.+'" . '"' . "!@#$%^&*(){}\[\]:;,~`\\\/<>=-]|\d+/g";
			}
		}

		$js = '
		<script>
	 	function validateSpecialChar(e, allow_digit)
	 	{
			var key;
			var keychar;
			var reg;
			if(window.event) {
				// for IE, e.keyCode or window.event.keyCode can be used
				key = e.keyCode;
			}
			else if(e.which) {
				// netscape
				key = e.which;
			}
			else {
				// no event, so pass through
				return true;
			}
			if(key == 8) {
				return true;
			}
			keychar = String.fromCharCode(key);
		  	if(allow_digit == 1) {
				var re = /[\s?.+' . '\'' . '"!@#$%^&*(){}\[\]:;,~`\\\/<>=-]/g;
			} else {
		  		var re = /[\s?.+' . '\'' . '"!@#$%^&*(){}\[\]:;,~`\\\/<>=-]|\d+/g;
			}
			if(re.test(keychar)) {
				// fail the test
				//alert("This field only accepts digits.");
				return false;
			}
			return true;
		}
		function stripLoginscreenBadChar(obj) {
		  	var re = /[' . '\'' . '\s?.+"!@#$%^&*(){}\[\]:;,~`\\\/<>=-]|\d+/g;

		  	if(obj.value.match(re)) {
		  		obj.value = obj.value.replace(re, "");

		  		eval(obj);
		  	}
		}
	</script>
';
		return true;
	}


	/**
	 * server-side validation preparation trims whitespace and truncates input to a maximum length
	 * -> data is still raw for easy regex manipulation, etc.
	 *
	 * @param string $input
	 * @param int $maxLength
	 *
	 */
	public function prepareStringForValidation($input = '', $maxLength = 80)
	{
		if( !empty($input) ) {
			//unescape $input if auto-escaped
			if( get_magic_quotes_gpc() ) {
				$input = stripslashes($input);
			}
			$input = substr(trim($input), 0, $maxLength);
			return $input;
		} else {
			return false;
		}
	} //end method prepareStringForValidation


	/**
	 * server-side validation preparation trims whitespace and truncates input to a maximum length
	 * -> data is still raw for easy regex manipulation, etc.
	 *
	 * @param array $input
	 * @param int $maxLength
	 *
	 */
	public function prepareArrayForValidation($input = array(), $maxLength = 80)
	{
		if( !empty($input) ) {
			//unescape $input if auto-escaped
			if( get_magic_quotes_gpc() ) {
				foreach( $input as $k => $v ) {
					$input[$k] = stripslashes($v);
				}
			}

			reset($input);

			//all data is 1)trimmed, and 2)truncated (still considered in "raw" format)
			while( list($k, $v) = each($input) ) {
				$input[$k] = substr(trim($v), 0, $maxLength);
			}

			return $input;
		} else {
			return false;
		}
	} //end method prepareArrayForValidation


	public function prepareGetForValidation($maxLength = 80)
	{
		if( !empty($_GET) ) {
			$array = $this->prepareArrayForValidation($_GET, $maxLength);
			if( $array ) {
				//save raw post
				$this->setArrRawGet($array);
				return $array;
			} else {
				return false;
			}
		} else {
			return false;
		}
	} //end method prepareGetForValidation


	/**
	 * server-side validation preparation trims whitespace and truncates input to a maximum length
	 * -> data is still raw for easy regex manipulation, etc.
	 *
	 * @param int $maxLength
	 *
	 */
	public function preparePostForValidation($maxLength = 80)
	{
		if( !empty($_POST) ) {
			$array = $this->prepareArrayForValidation($_POST, $maxLength);
			if( $array ) {
				//save raw post
				$this->setArrRawPost($array);
				return $array;
			} else {
				return false;
			}
		} else {
			return false;
		}
	} //end method preparePostForValidation


	public function prepareCookieForValidation($maxLength = 80)
	{
		if( !empty($_COOKIE) ) {
			$array = $this->prepareArrayForValidation($_COOKIE, $maxLength);
			if( $array ) {
				//save raw post
				$this->setArrRawCookie($array);
				return $array;
			} else {
				return false;
			}
		} else {
			return false;
		}
	} //end method prepareCookieForValidation


	public function prepareRequestForValidation($maxLength = 80)
	{
		if( !empty($_REQUEST) ) {
			$array = $this->prepareArrayForValidation($_REQUEST, $maxLength);
			if( $array ) {
				//save raw post
				$this->setArrRawRequest($array);
				return $array;
			} else {
				return false;
			}
		} else {
			return false;
		}
	} //end method prepareRequestForValidation


	/**
	 * Prepare an array of message box strings for validation
	 * This method is designed to allow a set of message boxes to be truncated to a common length
	 *
	 * @param array $input
	 * @param int $maxLength
	 */
	public function prepareArrMessageBoxForValidation($input = null, $maxLength = 5000)
	{
		if( !empty($input) ) {
			$array = $this->prepareArrayForValidation($input, $maxLength);
			if( $array ) {
				//save raw MessageBox contents
				$this->setArrRawMessageBox($array);
				return $array;
			} else {
				return false;
			}
		} else {
			return false;
		}
	} //end method prepareArrMessageBoxForValidation


	public function prepareGetForGetBack($function = 'htmlentities', $quoteStyle = 'ENT_QUOTES', $maxLength = 80)
	{
		return true;
	}
	/**
	 * sticky form preparation uses html_entities to make special chars into html entities
	 * -> prevents quotes from causing page field bleeds, etc.
	 *
	 * @param string $function
	 * @param string $quoteStyle
	 * @param int $maxLength
	 *
	 */
	public function preparePostForPostBack($function = 'htmlentities', $quoteStyle = 'ENT_QUOTES', $maxLength = 80)
	{
		$post = $this->getArrRawPost();
		if( empty($post) ) {
			$post = $this->preparePostForValidation($maxLength);
		}
		if( !empty($post) ) {
			foreach( $post as $k => $v ) {
				$post[$k] = $function($k, $quoteStyle);
			}
			$this->setArrHtmlPost($post);
			return $post;
		} else {
			return false;
		}
	} //end method preparePostForPostBack


	public function prepareCookieForCookieBack($function = 'htmlentities', $quoteStyle = 'ENT_QUOTES', $maxLength = 80)
	{
		return true;
	}
	public function prepareRequestForRequestBack($function = 'htmlentities', $quoteStyle = 'ENT_QUOTES', $maxLength = 80)
	{
		return true;
	}
	public function prepareMessageBoxForMessageBoxBack($function = 'htmlentities', $quoteStyle = 'ENT_QUOTES', $maxLength = 80)
	{
		return true;
	}


	//prepare data for pass off to database abstraction layer by getting into raw format from html format
	// -> allows db layer to prepare the data, escape it, etc. using its own routines
	// -> this allows the pure raw data to be stored in the database
	// Note: only needed if only html formatted data is available to begin with
	public function convertHtmlArrayToRaw($input = null, $function = 'html_entity_decode', $quoteStyle = 'ENT_QUOTES')
	{
		if( !empty($input) ) {
			$input = html_entity_decode($input, $quoteStyle);
			return $input;
		} else {
			return false;
		}
	} //end method convertHtmlArrayToRaw




	//truncate and clean a single string
	//inputs: string, truncate length
	//begin: raw string
	//end: html converted string ready for insertion into db
	public function cleanString2Html($input, $maxLength)
	{
		if( ! is_string($input) )
			return false; //change to throw an exception

		//select which escape function to use based upon availability
		$function = function_exists( "mysql_escape_string" ) ? "mysql_escape_string" : "addslashes";

		//save raw input for later
		$this->setStrRawInput($input);

		//unescape string if auto-escaped
		if( get_magic_quotes_gpc() )
			$input = stripslashes($input);

		//escape everything within the string including double quotes
		//all data is 1)trimmed, 2)truncated, 3)html entitied (special html chars converted to html entities), and
		//4) finally all resulting data is escaped for insertion into the database
		$input = $function( htmlentities( substr( trim($input), 0, $maxLength ), ENT_QUOTES ) );

		//store clean input for later use
		$this->setStrCleanInput($input);

		return $input;
	} //end method cleanString


	//inverse method to take clean string content and convert it back to plain text ready form
	public function cleanedString2PlainText( $input )
	{
		if( ! is_string($input) )
			return false; //change to throw an exception

		//save raw input for later
		$this->setStrRawInput($input);

		//unescape db escaped string and convert html entities back to normal form
		$input = html_entity_decode( stripslashes($input), ENT_QUOTES );

		return $input;
	} //end method cleanStr2PlainText


	//truncate and clean a single string
	//inputs: string, truncate length
	//begin: dirty string
	//end: clean string ready for plain text display
	public function cleanString2PlainText($input, $maxLength)
	{
		if( ! is_string($input) )
			return false; //change to throw an exception

		//save raw input for later
		$this->setStrRawInput($input);

		//unescape string if auto-escaped
		if( get_magic_quotes_gpc() )
			$input = stripslashes($input);

		/////////ADD SHELL ESCAPE
		//escape everything within the string including double quotes
		//all data is 1)trimmed, and 2)truncated,
		$input = substr( trim($input), 0, $maxLength );

		//store clean input for later use
		$this->setStrCleanInput($input);

		return $input;
	} //end method cleanString


	//inverse method to take clean string content and convert it back to html ready form
	//start: database escaped string
	//finish: html string ready for a display page
	public function cleanedString2Html($input)
	{
		if( ! is_string($input) )
			return false; //change to throw an exception

		//save raw input for later
		$this->setStrRawInput($input);

		//unescape db escaped string
		$input = stripslashes($input);

		return $input;
	} //end method cleanStr2Html


	//truncate and clean every element of an array
	//inputs: array, truncate length
	//begin: raw array of dirty strings
	//end: html converted array of strings ready for insertion into db
	public function cleanArray2Html($input, $maxLength)
	{
		if( ! is_array($input) )
			return false; //change to throw an exception

		//select which escape function to use based upon availability
		$function = function_exists( "mysql_escape_string" ) ? "mysql_escape_string" : "addslashes";

		//save raw input for later
		$this->setArrRawInput($input);

		//unescape string if auto-escaped
		if( get_magic_quotes_gpc() )
			foreach( $input as &$value ) //& allows foreach to use a reference instead of a copy of array's value
				$value = stripslashes($value);

		//escape every array element including double quotes
		//all data is 1)trimmed, 2)truncated, 3)html entitied (special html chars converted to html entities), and
		//4) finally all resulting data is escaped for insertion into the database
		foreach( $input as &$value ) //& allows foreach to use a reference instead of a copy of array's value
			$value = $function( htmlentities( substr( trim($value), 0, $maxLength ), ENT_QUOTES ) );

		//store clean input for later use
		$this->setArrCleanInput($input);

		return $input;
	} //end method cleanArray


	//inverse method to take clean array content and convert it back to plain text ready form
	public function cleanedArray2PlainText( $input )
	{

	} //end method cleanArr2PlainText


	//truncate and clean every element of an array
	//inputs: array, truncate length
	//begin: raw array of dirty strings
	//end: clean array of strings ready for plain text display
	public function cleanArray2PlainText($input, $maxLength)
	{
		if( ! is_array($input) )
			return false; //change to throw an exception

		//select which escape function to use based upon availability
		$function = function_exists( "mysql_escape_string" ) ? "mysql_escape_string" : "addslashes";

		//save raw input for later
		$this->setArrRawInput($input);

		//unescape string if auto-escaped
		if( get_magic_quotes_gpc() )
			foreach( $input as &$value ) //& allows foreach to use a reference instead of a copy of array's value
				$value = stripslashes($value);

		//escape every array element including double quotes
		//all data is 1)trimmed, 2)truncated, 3)html entitied (special html chars converted to html entities), and
		//4) finally all resulting data is escaped for insertion into the database
		foreach( $input as &$value ) //& allows foreach to use a reference instead of a copy of array's value
			$value = $function( htmlentities( substr( trim($value), 0, $maxLength ), ENT_QUOTES ) );

		//store clean input for later use
		$this->setArrCleanInput($input);

		return $input;
	} //end method cleanArray


	//inverse method to take clean array content and convert it back to html ready form
	public function cleanedArray2Html( $input )
	{

	} //end method cleanArr2Html


	//pass in $session object reference and a maximum string length value
	public function cleanPost2Html($session, $maxLength)
	{
		$input = array(); //initialize input for best practice
		$input = $session->getPost(); //retrieve post array from session object
		$input = $this->cleanArray2Html($input, $maxLength); //clean the post data
		$session->setPost($input); //place cleaned post data back into the session object
		return true;
	} //end method cleanPost


	//pass in $session object reference and a maximum string length value
	public function cleanPost2PlainText($session, $maxLength)
	{
		$input = array(); //initialize input for best practice
		$input = $session->getPost(); //retrieve post array from session object
		$input = $this->cleanArray2PlainText($input, $maxLength); //clean the post data
		$session->setPost($input); //place cleaned post data back into the session object
		return true;
	} //end method cleanPost


	//pass in $session object reference and a maximum string length value
	public function cleanGet2Html($session, $maxLength)
	{
		$input = array(); //initialize input for best practice
		$input = $session->getGet(); //retrieve get array from session object
		$input = $this->cleanArray2Html($input, $maxLength); //clean the get data
		$session->setGet($input); //place cleaned post data back into the session object
		return true;
	} //end method cleanGet


	//pass in $session object reference and a maximum string length value
	public function cleanGet2PlainText($session, $maxLength)
	{
		$input = array(); //initialize input for best practice
		$input = $session->getGet(); //retrieve get array from session object
		$input = $this->cleanArray2PlainText($input, $maxLength); //clean the get data
		$session->setGet($input); //place cleaned post data back into the session object
		return true;
	} //end method cleanGet


	public function cleanMessageBox($input, $maxLength)
	{
		if( ! is_string($input) )
			return false; //change to throw an exception

		//select which escape function to use based upon availability
		$function = function_exists( "mysql_escape_string" ) ? "mysql_escape_string" : "addslashes";

		//save raw input for later
		$this->setStrRawMessage($input);

		//unescape string if auto-escaped
		if( get_magic_quotes_gpc() )
			$input = stripslashes($input);

		//escape everything within the string including double quotes
		//all data is 1)trimmed, 2)truncated, 3)html entitied (special html chars converted to html entities),
		//4) newlines converted to <br>, and finally 5) all resulting data is escaped for insertion into the database
		//$input = $function( nl2br( htmlentities( substr( trim($input), 0, $maxLength ), ENT_QUOTES ) ) );
		$input = trim($input);
		$input = substr($input, 0, $maxLength);
		$input = htmlentities($input, ENT_QUOTES);
		$input = nl2br($input);
		$input = $function($input);

		//store clean input for later use
		$this->setStrCleanMessage($input);

		return $input;
	} //end method cleanMessageBox


	public function cleanMessageBox4PlainText( $message, $maxLength )
	{
		if( ! is_string($input) )
			return false; //change to throw an exception

		//save raw input for later
		$this->setStrRawMessage($input);

		//unescape string if auto-escaped
		if( get_magic_quotes_gpc() )
			$input = stripslashes($input);

		//escape everything within the string including double quotes
		//all data is 1)trimmed, and 2)truncated
		$input = substr( trim($input), 0, $maxLength );

		//store clean input for later use
		$this->setStrCleanMessage($input);

		return $input;
	} //end method cleanMessageBox4Email


} //end class Scrub

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */
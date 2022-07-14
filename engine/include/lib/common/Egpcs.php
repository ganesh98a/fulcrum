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
 * EGCPCS wrapper class to guarantee consistent form/cookie data
 * being passed between the client and server.
 *
 * Escaping special characters and moving data around correctly is critical.
 *
 * @category   Framework/Data
 * @package    Egpcs.php
 * @see        Scrub.php
 */

//require_once('includes/classes/Exceptions.php');

/**
 * AbstractWebToolkit
 */
//Already Included...commented out for performance gain
//require_once('lib/common/AbstractWebToolkit.php');

/**
 * Egpcs_Interface
 */
require_once('lib/common/Egpcs/Interface.php');

class Egpcs extends AbstractWebToolkit implements Egpcs_Interface
{
	//wrap around get, post, cookie, etc.

	/**
	 * Array of form field names to indicate the allowed set of
	 * valid input for heightened security.
	 *
	 * Can have a list of the allowable form inputs.
	 * Have a section for each incoming form to have different sets of inputs.
	 * NOTE: This array may contain a key/value pair for each form field
	 *  with the value being a maxlength.
	 */
	protected $_validateFormStrict = false;
	protected $_magicQuotesGpcFlag;
	protected $_magicQuotesRuntimeFlag;

	protected $_quote_style;
	protected $_charset;
	protected $_namespace;
	protected $_postBackFlag = false;

	/**
	 * 'get', 'post', or 'cookie'
	 *
	 * @var string
	 */
	protected $_key;

	/**
	 * 'raw' or 'html'
	 *
	 * 'raw' is for form processing and 'html' is for post back (sticky form).
	 *
	 * @var string
	 */
	protected $_view = 'raw';

	/**
	 * Constructor.
	 * $key and $namespace are for Session get and Session put operations.
	 * An Egpcs object can be for get, post, or cookie.
	 *
	 * @param string $key
	 * @param string $namespace
	 */
	public function __construct($key, $namespace = 'global')
	{
		$this->_key = $key;
		$this->_namespace = $namespace;
		$this->_quote_style = ENT_QUOTES;
		$this->_charset = 'UTF-8';

		/**
		 * Check for magic quotes setting.
		 */
		$this->_magicQuotesGpcFlag = (bool) get_magic_quotes_gpc();
	}

	public function getPostBackFlag()
	{
		if ($this->_postBackFlag) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Clean a string or an array.
	 * 1) Trim whitespace.
	 * 2) Deslashify if needed to undo magic quotes.
	 * 3) Truncate length after deslashification.
	 *
	 *
	 * Server-side validation preparation trims whitespace and
	 * truncates input to a maximum length.
	 * Data is still raw (no htmlentities conversion) for
	 * easy regex manipulation, etc.
	 * If slashes were added by magic quotes those slashes are removed
	 * to ensure data is raw.
	 *
	 * @param mixed $input
	 * @param int	$maxLength
	 */
	public function clean($maxLength = 2048)
	{
		if (!isset($this->_data)) {
			throw new Exception('Egpcs::clean() invalid or missing $this->_data.');
		}

		if (!empty($this->_data)) {
			if ($this->_magicQuotesGpcFlag) {
				$this->magicClean($this->_data, $maxLength);
			} else {
				$this->regularClean($this->_data, $maxLength);
			}
		}
	}

	/**
	 * Recursive method to recurse down an array until it reaches
	 * non-array elements (array may have sub-arrays as elements).
	 * This supports complex forms w/ nested elements.
	 *
	 * @param unknown_type $input
	 * @param unknown_type $maxLength
	 * @return unknown
	 */
	protected function regularClean(&$input, $maxLength)
	{
		foreach ($input as &$value) {
			if (isset($value) && !empty($value)) {
				if (is_array($value)) {
					$this->regularClean($value, $maxLength);
				} else {
					$value = trim($value);
					if (!empty($value)) {
						$value = substr($value, 0, $maxLength);
					}
				}
			}
		}
	}

	/**
	 * Recursive method to recurse down an array until it reaches
	 * non-array elements (array may have sub-arrays as elements).
	 * This supports complex forms w/ nested elements.
	 *
	 * @param unknown_type $input
	 * @param unknown_type $maxLength
	 * @return unknown
	 */
	protected function magicClean(&$input, $maxLength)
	{
		foreach ($input as &$value) {
			if (isset($value) && !empty($value)) {
				if (is_array($value)) {
					$this->magicClean($value, $maxLength);
				} else {
					$value = trim($value);
					$value = stripslashes($value);
					$value = substr($value, 0, $maxLength);
				}
			}
		}
	}

	/**
	 * Validate g, p, or c input based upon allowable form keys
	 * and their reasonable values.
	 *
	 * $arrForm is a set of key value pairs
	 * The keys are allowable form element names to compare against
	 * for security.
	 * The values are allowable value types
	 * This is to help enforce high security.
	 *
	 * @param array $arrForm
	 *
	 * @return bool
	 *
	 */
	public function validFormInput($arrForm, $input)
	{
		if (!isset($arrForm)) {
			$msg = 'Egpcs::validFormInput() missing required $arrForm param.';
			throw new Exception($msg);
		}

		if (!empty($arrForm)) {
			$arrDiff = array_diff_key($arrForm, $input);
			if (empty($arrDiff)) {
				return true;
			} else {
				return false;
			}

/*
			foreach ($arrForm as $element => $type) {

			}

			$tmp = array();
			$arrIllegalFormFields = array();
			while (list($k, $v) = each($input)) {
				if (!in_array($k, $arrAllowedFormElements)) {
					$arrIllegalFormFields[] = array($k => $v);
				} elseif (array_key_exists($k, $arrAllowedFormElements)) {
					//the maxlength value for the form field is stored in $arrAllowedFormElements[$k]
					// for the given form field
					$tmp[$k] = $this->cleanStringToPlainText($v, $arrAllowedFormElements[$k]);
				} else {
					$tmp[$k] = $this->cleanStringToPlainText($v, $maxLength);
				}
			}
			if (!empty($arrIllegalFormFields)) {
				syslog(LOG_ERR, 'Illegal form data' . __FILE__ . print_r($arrIllegalFormFields));
			}
*/
		} else {
			return true;
		}
	}

	public function fetchMagicQuotesGpcSetting()
	{
		if (!isset($this->_magicQuotesGpcFlag)) {
			$this->_magicQuotesGpcFlag = (bool) get_magic_quotes_gpc();
		}

		return $this->_magicQuotesGpcFlag;
	}

	public function getMagicQuotesGpcFlag()
	{
		if (!isset($this->_magicQuotesGpcFlag)) {
			$this->fetchMagicQuotesGpcSetting();
		}

		return $this->_magicQuotesGpcFlag;
	}

	public function fetchMagicQuotesRuntimeSetting()
	{
		if (!isset($this->_magicQuotesRuntimeFlag)) {
			$this->_magicQuotesRuntimeFlag = (bool) get_magic_quotes_runtime();
		}

		return $this->_magicQuotesRuntimeFlag;
	}

	public function getMagicQuotesRuntimeFlag()
	{
		if (!isset($this->_magicQuotesRuntimeFlag)) {
			$this->fetchMagicQuotesRuntimeSetting();
		}

		return $this->_magicQuotesRuntimeFlag;
	}

	public function htmlView($key)
	{
		if ($this->_view != 'html') {
			$data = htmlentities($this->_data[$key], $this->_quote_style, $this->_charset);
		}

		return $data;
	}

	public function convertToHtml()
	{
		if ($this->_view != 'html') {
			$this->_data = $this->htmlConvert($this->_data);
			$this->_view = 'html';
		}
	}

	/**
	 * Separate method for possible recursive case.
	 *
	 */
	protected function htmlConvert($input)
	{
		foreach ($input as $k => $v) {
			if (is_array($v)) {
				$input[$k] = $this->htmlConvert($v);
			} else {
				$tmp = htmlentities($v, $this->_quote_style, $this->_charset);
				$input[$k] = $tmp;
			}
		}
		return $input;
	}

	/**
	 * Store data in session for sticky form effect.
	 *
	 * $_data is post back, get back, etc.
	 * $view refers to raw or html (html entity conversion).
	 *
	 * @param string $namespace
	 */
	public function sessionPut($formName)
	{
		if (!isset($this->_key) || !isset($this->_namespace)) {
			throw new Exception('Egpcs::sessionPut - invalid namespace/key.');
		}
		$this->_postBackFlag = true;

		/*
		Application::getInstance($this->_namespace)
		->getSession()
		->setData($this->_namespace, $this->_key, $this);
		*/

		$application = Application::getInstance($this->_namespace);
		$session = $application->getSession();

		$arrEgcps = $session->egpcs;
		if (!($arrEgcps && is_array($arrEgcps))) {
			$arrEgcps = array();
		}

		$obj = $this;
		$key = $this->_key;
		$arrEgcps[$formName][$key] = $obj;
		$session->egpcs = $arrEgcps;
	}

	/**
	 * $namespace is the application namespace.
	 * $formName is the form itself.
	 * $key is "get", "post", etc.
	 *
	 * @param string $namespace
	 * @param string $formName
	 * @param string $key
	 * @return Egpcs Object
	 */
	public static function sessionGet($namespace, $formName, $key)
	{
		/*
		$obj =
		Application::getInstance($namespace)
		->getSession()
		->getData($namespace, $key);
		*/

		$application = Application::getInstance($namespace);
		$session = $application->getSession();

		if ($session->egpcs) {
			$arrEgpcs = $session->egpcs;
			if (isset($arrEgpcs[$formName][$key])) {
				$obj = $arrEgpcs[$formName][$key];
			} else {
				$obj = false;
			}
		} else {
			$obj = false;
		}

		if ($obj && ($obj instanceof Egpcs)) {
			return $obj;
		} else {
			$tmp = new Egpcs($key, $namespace);
			return $tmp;
		}
	}

	public function sessionClear()
	{
		/*
		Application::getInstance($this->_namespace)
		->getSession()
		->setData($this->_namespace, $this->_key, null);
		*/

		$application = Application::getInstance($this->_namespace);
		$session = $application->getSession();
		unset($session->egpcs);
	}

	public static function sessionClearKey($namespace, $formName, $key)
	{
		$application = Application::getInstance($namespace);
		$session = $application->getSession();

		if ($session->egpcs) {
			$arrEgpcs = $session->egpcs;
			if (isset($arrEgpcs[$formName][$key])) {
				unset($arrEgpcs[$formName][$key]);
			}
			$session->egpcs = $arrEgpcs;
		}
	}

	protected function getSession()
	{
//		require_once('lib/common/Session.php');
//		return Session::getInstance();
		return Application::getInstance()->getSession;
	}
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

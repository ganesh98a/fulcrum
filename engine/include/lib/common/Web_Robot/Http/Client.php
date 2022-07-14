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
 * Zend_Http_Client wrapper class for use with Web_Robot base class.
 *
 * Includes all details to have a fully operational http bot.
 *
 * @category   Framework
 * @package    Web_Robot
 */

/**
 * Zend_Http_Client
 */
require_once('Zend/Http/Client.php');

class Web_Robot_Http_Client extends Zend_Http_Client
{
	/**
	 * Current User Agent sent out with each HTTP request.
	 *
	 * @var string
	 */
	protected $userAgent;

	/**
	 * Current User Agent sent out with each HTTP request.
	 *
	 * @var string
	 */
	protected $userAgentInitialized = false;

	/**
	 * List of user agents.
	 *
	 * This will be a list within a database of thousands of possibilities.
	 *
	 * @var array
	 */
	protected $userAgents = array(
		'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.12) Gecko/20080201 Firefox/2.0.0.12',
		'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.0.7) Gecko/2009021910 Firefox/3.0.7'
	);

	protected $_processContent = false;

	/**
	 * Constructor.
	 */
	public function __construct($uri = null, $config = null)
	{
		/**
		 * Invoke parent constructor.
		 */
		parent::__construct($uri, $config);
	}

	/**
	 * Initialize User Agent (UA) and configuration data.
	 */
	public function init()
	{
		/**
		 * Randomize User Agent for Http Client.
		 */
		$this->uaRandomize();

		/**
		 * Initialize Http Client.
		 *
		 * Set up configuration for Zend_Http_Client.
		 */
		$config = array(
						'maxredirects'		=> 5,
						'strict'			=> true,
						'strictredirects'	=> false,
						'useragent'			=> $this->userAgent,
						'timeout'			=> 90,
						'httpversion'		=> '1.1',
						'adapter'			=> 'Zend_Http_Client_Adapter_Socket',
						'keepalive'			=> false
						);
		$this->setConfig($config);
		$this->setCookieJar();
	}

	public function getUserAgent()
	{
		if (!$this->userAgentInitialized) {
			$this->uARandomize();
		}

		return $this->userAgent;
	}

	public function uARandomize()
	{
		/**
		 * Randomize User Agent.
		 */
		$uaOffset = mt_rand(0, 1);
		$ua = $this->userAgents[$uaOffset];
		$this->userAgent = $ua;
		$this->userAgentInitialized = true;
	}

	/**
	 * Perform an  HTTP HEAD request for a given URI.
	 *
	 * @param string|Zend_Uri $uri
	 * @return Zend_Http_Response
	 */
	public function head($uri)
	{
		$this->setUri($uri);

		try {
			$response = $this->request(Zend_Http_Client::HEAD);
			/* @var $response Zend_Http_Response */
		} catch (Exception $e) {
			$arrHeaders = array(
				'connection' => 'close'
			);
			$response = new Zend_Http_Response(404, $arrHeaders, null, '1.1', 'Not Found');
		}

		return $response;
	}

	/**
	 * Perform an  HTTP GET request for a given URI.
	 *
	 * @param string|Zend_Uri $uri
	 * @return Zend_Http_Response
	 */
	public function get($uri)
	{
		$this->setUri($uri);

		try {
			$response = $this->request(Zend_Http_Client::GET);
			/* @var $response Zend_Http_Response */
		} catch (Exception $e) {
			$arrHeaders = array(
				'connection' => 'close'
			);
			$response = new Zend_Http_Response(404, $arrHeaders, null, '1.1', 'Not Found');
		}

		return $response;
	}

	/**
	 * Perform an  HTTP POST request for a given URI.
	 *
	 * @param string|Zend_Uri $uri
	 * @return Zend_Http_Response
	 */
	public function post($uri)
	{
		$this->setUri($uri);

		try {
			$response = $this->request(Zend_Http_Client::POST);
			/* @var $response Zend_Http_Response */
		} catch (Exception $e) {
			$arrHeaders = array(
				'connection' => 'close'
			);
			$response = new Zend_Http_Response(404, $arrHeaders, null, '1.1', 'Not Found');
		}

		return $response;
	}

	/**
	 * Simple spider method using libCURL
	 *
	 * @param string $url
	 * @param string $method
	 */
	public function fetchContentViaCurl($url, $method='get')
	{
		$ch = curl_init ();
	    curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1);
	    curl_setopt ($ch, CURLOPT_HEADER, 1);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt ($ch, CURLOPT_TIMEOUT, 90);
		curl_setopt ($ch, CURLOPT_URL, $url);
	    curl_setopt ($ch, CURLOPT_USERAGENT, $this->userAgent);
		$buffer = curl_exec ($ch);
		if (!$buffer) {
			$error_no = curl_errno($ch);
			$error = curl_error($ch);
			$buffer = '';
		}
		curl_close ($ch);
		return $buffer;
	}

	/**
	 * Get the HTML for a given URI.
	 *
	 * @param string|Zend_Uri $uri
	 * @param string $method
	 * @return string
	 */
	public function fetchContent($uri, $method='get')
	{
		$response = $this->$method($uri);
		/* @var $response Zend_Http_Response */

		$responseStatus = $response->getStatus();
		$content = $response->getBody();

		if (isset($content) && !empty($content) && $this->_processContent) {
			$this->processContent($content);
		} elseif (!isset($content) || empty($content))  {
			$content = null;
		}

		if ($responseStatus != 200) {
			$error = $response->isError();
			if ($error) {
				$this->errorMessage =
					'HTTP Error: '.$response->getStatus().' '.$response->getMessage()."\n";
			}
		}

		return $content;
	}

	public function processContent(& $content)
	{
		$content = trim($content);
		$content = preg_replace('/[\r]+/', '', $content);
		$content = preg_replace('/[\t]+/', '', $content);
		$arrLines = preg_split('/[\n]/', $content, -1, PREG_SPLIT_NO_EMPTY);
		foreach ($arrLines as & $line) {
			$line = trim($line);
		}
		$content = join("\n", $arrLines);
		unset($arrLines);
		$content = preg_replace('/[\n]{2,}/', "\n", $content);
	}

	public function getError()
	{
		if (isset($this->errorMessage)) {
			return $this->errorMessage;
		} else {
			return null;
		}
	}
}

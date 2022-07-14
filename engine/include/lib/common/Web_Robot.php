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
 * Web robots base class.
 *
 * Uses delegation for HTTP requests.
 *
 * @category   Framework
 * @package    Web_Robot
 */

/**
 * Abstract_Web_Toolkit
 */
require_once('lib/common/AbstractWebToolkit.php');

/**
 * Web_Robot_Documents
 */
require_once('lib/common/Web_Robot/Documents.php');

/**
 * @see Web_Robot_Http_Client
 */
require_once('lib/common/Web_Robot/Http/Client.php');

class Web_Robot extends AbstractWebToolkit
{
	/**
	 * Name of web robot.
	 *
	 * @var string
	 */
	protected $robotName;

	/**
	 * HTTP client object to use for issuing requests, etc.
	 *
	 * @var Web_Robot_Http_Client
	 */
	protected $httpClient;

	/**
	 * Latest HTTP response object.
	 *
	 * @var Zend_Http_Response
	 */
	protected $httpResponse;

	/**
	 * Latest web document.
	 *
	 * @var Web_Robot_Documents
	 */
	protected $document;

	/**
	 * Latest uri.
	 *
	 * @var Zend_Uri
	 */
	protected $uri;

	/**
	 * Latest referer uri.
	 *
	 * @var Zend_Uri
	 */
	protected $referer;

	/**
	 * Transport protocol.
	 *
	 * @var string
	 */
	protected $protocol = 'http';

	/**
	 * Transport protocol method. Get or Post.
	 *
	 * @var string
	 */
	protected $method = 'get';

	/**
	 * Type of page.
	 *
	 * @var string
	 */
	protected $type = null;

	/**
	 * Flag to determine if full text from a web document should be refreshed
	 * when requested from the web_robot_documents store.
	 *
	 * If set to false, host webserver of document will not be contacted
	 * for latest copy.
	 *
	 * @var boolean
	 */
	protected $noRefresh = false;

	protected $errorMessage;

	protected $rootSet;

	protected $startPattern;

	protected $endPattern;

	protected $fullContent;

	protected $extractedContent;

	/**
	 * Three types of pages:
	 * 1) Page with no content, just links. Type = 'links_only'.
	 * 2) Links and content. Type = 'links_and_content'.
	 * 3) Content only. Type = 'content_only'.
	 *
	 * @var unknown_type
	 */
	protected $documentType;

	/**
	 * Constructor.
	 *
	 */
	public function __construct($robotName = 'VirtualBot')
	{
		$this->robotName = $robotName;
	}

	/**
	 * Web_Robot_Documents
	 */
	public function getWebRobotDocuments()
	{
		if (!$this->document instanceof Web_Robot_Documents) {
			$this->document = new Web_Robot_Documents();
		}

		return $this->document;
	}

	public function initHttp($timeout=90)
	{
		$client = $this->getHttpClient();
		$client->init($timeout);
	}

	/**
	 * Set the HTTP client reference.
	 *
	 * Sets the HTTP client object to use for retrieving the feeds.
	 *
	 * @param  Web_Robot_Http_Client $httpClient
	 * @return void
	 */
	public function setHttpClient(Web_Robot_Http_Client $httpClient)
	{
		$this->httpClient = $httpClient;
	}

	/**
	 * Gets the HTTP client object. If none is set, a new Web_Robot_Http_Client will be used.
	 *
	 * @return Web_Robot_Http_Client
	 */
	public function getHttpClient()
	{
		if (!$this->httpClient instanceof Web_Robot_Http_Client) {
			$this->httpClient = new Web_Robot_Http_Client();
		}

		return $this->httpClient;
	}

	/**
	 * Get latest HTTP request string.
	 *
	 * @return string
	 */
	public function getLastHttpRequest()
	{
		$client = $this->getHttpClient();
		/* @var $client Web_Robot_Http_Client */

		$request = $client->getLastRequest();

		return $request;
	}

	/**
	 * Get latest HTTP response object.
	 *
	 * @return Zend_Http_Response
	 */
	public function getLastHttpResponse()
	{
		$client = $this->getHttpClient();
		/* @var $client Web_Robot_Http_Client */

		$response = $client->getLastResponse();

		return $response;
	}

	/**
	 * Fetch the latest content or use existing content from index.
	 *
	 * 1) Fetch document from index:
	 * 2) Standard HEAD or If-Modified-Since HEAD
	 * 3) Standard GET or If-Modified-Since GET
	 *
	 * Populate index with latest content or use existing content.
	 *
	 * @param Zend_Uri $uri
	 * @return Web_Robot_Documents
	 */
	public function fetchLatestDocument(Zend_Uri $uri, Zend_Uri $referer=null, $protocol='http', $method='get', $type=null)
	{
		if (isset($uri)) {
			$this->uri = $uri;
		}
		if (isset($referer)) {
			$this->referer = $referer;
		}
		if (isset($method)) {
			$this->method = $method;
		}
		if (isset($type)) {
			$this->type = $type;
		}

		// Does page already exist in database?
		$this->getWebRobotDocuments();
		$document = Web_Robot_Documents::findByUrl($uri);
		/* @var $document Web_Robot_Documents */

		$client = $this->getHttpClient();
		/* @var $client Web_Robot_Http_Client */

		// Get URL
		$url = $uri->getUri();
		$url = str_replace(':80', '', $url);

		// Get referer URL (aka parent URL)
		$refUrl = $referer->getUri();
		$refUrl = str_replace(':80', '', $refUrl);

		// Add Headers
		// Referer always used.
		$headers['Referer'] = $refUrl;

		/**
		 * Determine if document already has been indexed in the database.
		 *
		 * If isDataLoaded() returns true then the document already exists.
		 */
		$loaded = $document->isDataLoaded();
//		$document->reset();
//		$loaded = false;
		if ($loaded) {
			// If noRefresh is set then do not refresh the full content.
			// This means avoiding hitting the live webserver.
			// Useful for debugging, etc.
			if ($this->noRefresh) {
				return $document;
			}

			// Perform a If-Modified-Since HEAD request to see:
			// 1) If page still exists.
			// 2) If page has been moved to a new URL.
			// 3) If page refresh is needed

			// Get date from server_response_date field.
			$modifiedDate = $document->server_response_date;

			// Add If-Modified-Since header since document already exists
			$headers['If-Modified-Since'] = $modifiedDate;

			// Conditional HEAD request
			$client->setHeaders($headers);
			$response = $client->head($url);
			/* @var $response Zend_Http_Response */
			$status = $response->getStatus();

			// Determine if refresh is needed.
			// If page no longer exists, mark related content as EOL in index.
//			$status = 200;

			if ($status == 304) {
				return $document;
				// Data from web_robot_documents table is still fresh so
				// use loaded data from web_robot_documents table.
				// Update record with latest server_response_date
				$date = (string) $response->getHeader('date');
				$document->server_response_date = $date;
				//The below line causes bugs...
				$document->prepareDocumentForSave($this);
			} elseif ($status == 404) {
				// Flag page as 404 not found.
				// Update record with latest server_response_date
				$document->not_found_404_flag = 1;
				$date = (string) $response->getHeader('date');
				$document->server_response_date = $date;
			} else {
				// Conditional GET request if page still exists.
				// If-Modified-Since headers set previosly.
				$fullContent = $this->fetchContent($uri);

				$response = $client->getLastResponse();
				/* @var $response Zend_Http_Response */
				$headers = $response->getHeaders();
				$status = $response->getStatus();

				// Test status of standard get/post request
				if ($status != 404) {
					// Use sha1 to see if content has changed.
					$sha1Latest = sha1($fullContent);
					$sha1Existing = $document->sha1;

					if ($sha1Latest != $sha1Existing) {
						// Prepare variables and save document.
						$date = (string) $response->getHeader('date');
						$document->server_response_date = $date;
						$document->not_found_404_flag = 0;
						$document->no_server_response_flag = 0;
						// Update web_robot_documents record, so set key first.
						$document->prepareDocumentForSave($this);
					} else {
						return $document;
					}
				} else {
					// Flag page as 404 not found.
					// Update record with latest server_response_date
					$document->not_found_404_flag = 1;
					$date = (string) $response->getHeader('date');
					$document->server_response_date = $date;
				}
			}
			$document->save();
		} else {
			//Time delay for actual scraping
			$microtime = mt_rand(100000, 300000);
			usleep($microtime);

			// Get full content for the first time
			// HEAD request to detect 404 possibility.
			$client->setHeaders($headers);
			$response = $client->head($url);
			/* @var $response Zend_Http_Response */
			$status = $response->getStatus();

			// Test status of head request.
			if ($status != 404) {
				//$fullContent = $this->fetchContent($uri);
				$this->fetchContent($uri);

				$response = $client->getLastResponse();
				/* @var $response Zend_Http_Response */
				$headers = $response->getHeaders();
				$status = $response->getStatus();

				// Test status of standard get/post request
				if ($status != 404) {
					// Prepare variables and save document.
					$document->prepareDocumentForSave($this);
					$document->created = null;
					$document->save();
					$key = array('url' => $url);
					$document->setKey($key);
				}
			}
		}

		return $document;
	}

	/**
	 * Get the HTML for a given URI.
	 *
	 * @param string|Zend_Uri_Http $uri
	 * @param string $method
	 * @return string
	 */
	public function fetchContent($uri, $method='get')
	{
		$client = $this->getHttpClient();
		/* @var $client Web_Robot_Http_Client */

		$response = $client->$method($uri);
		/* @var $response Zend_Http_Response */

		$responseStatus = $response->getStatus();
		$content = $response->getBody();

		if (!isset($content) || empty($content))  {
			$content = null;
		}

		// Already in Response object, but this is the processed content.
		$this->fullContent = $content;

		if ($responseStatus != 200) {
			$error = $response->isError();
			if ($error) {
				$this->errorMessage =
					'HTTP Error: '.$response->getStatus().' '.$response->getMessage()."\n";
			}
		}

		return $content;
	}

	/**
	 * Retrieve an error message.
	 *
	 * @return mixed
	 */
	public function getError()
	{
		if (isset($this->errorMessage)) {
			return $this->errorMessage;
		} else {
			return null;
		}
	}
}

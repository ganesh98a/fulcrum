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
 * Global uri (link) class.
 *
 * PHP versions 5
 *
 * @category   Initialization
 * @package    Uri
 *
 * @see        init.php
 * @see        lib/common/Init.php
 *
 */

/**
 * Model
 */
//Already Included...commented out for performance gain
//require_once('lib/common/Model.php');

class Uri extends Model
{
	private static $_instance;

	private $urlsInitialized = false;

	/**
	 * Map $_data attributes to Uri properties.
	 *
	 * @var array
	 */
	protected $arrAttributesMap = array(
		'remote_ip_address' => 'remote_ip_address',
		'remote_host' => 'remote_host',
		'remote_port' => 'remote_port',
		'remote_user' => 'remote_user',

		'server_ip_address' => 'server_ip_address',

		'allow_dynamic_hostname' => 'allow_dynamic_hostname',
		'http_prefix' => 'http_prefix',
		'https_prefix' => 'https_prefix',
		'cdn_prefix' => 'cdn_prefix',
		'decloak_url_key' => 'decloak_url_key',

		'css' => 'css',
		'img' => 'img',
		'js' => 'js',

		'domain' => 'domain',
		'wildcard_subdomain' => 'wildcard_subdomain',
		'cdn_domain' => 'cdn_domain',
		'cdn_scheme' => 'cdn_scheme',

		'http' => 'http',
		'https' => 'https',
		'cdn' => 'cdn',
		'cdn1' => 'cdn1',
		'cdn2' => 'cdn2',
		'cdn_absolute_url' => 'cdn_absolute_url',
		'cdn1_absolute_url' => 'cdn1_absolute_url',
		'cdn2_absolute_url' => 'cdn2_absolute_url',

		'use_cdn_origin_node' => 'use_cdn_origin_node',
		'cdn_origin_node' => 'cdn_origin_node',
		'cdn_origin_node_domain' => 'cdn_origin_node_domain',
		'cdn_origin_node_scheme' => 'cdn_origin_node_scheme',
		'cdn_origin_node_absolute_url' => 'cdn_origin_node_absolute_url',

		'base_href' => 'base_href',
		'current' => 'current',
		'currentPhpScript' => 'currentPhpScript',
		'full_http_uri' => 'full_http_uri',
		'full_https_uri' => 'full_https_uri',
		'path' => 'path',
		'port' => 'port',
		'queryString' => 'queryString',
		'scheme' => 'scheme',
		'sslFlag' => 'sslFlag',

		'referrer' => 'referrer',
		'referrerHost' => 'referrerHost',
		'referrerPath' => 'referrerPath',
		'referrerPhpScript' => 'referrerPhpScript',
		'referrerQueryString' => 'referrerQueryString',
		'referrerScheme' => 'referrerScheme',

		'requestedUri' => 'requestedUri',
		'requestedUrl' => 'requestedUrl',
	);

	public $remote_ip_address;
	public $remote_host;
	public $remote_port;
	public $remote_user;

	public $server_ip_address;

	public $allow_dynamic_hostname;
	public $http_prefix;
	public $https_prefix;
	public $cdn_prefix;
	public $decloak_url_key;

	public $css;
	public $img;
	public $js;

	public $domain;
	public $wildcard_subdomain;
	public $cdn_domain;
	public $cdn_scheme;

	public $http;
	public $https;
	public $cdn;
	public $cdn1;
	public $cdn2;
	public $cdn_absolute_url;
	public $cdn1_absolute_url;
	public $cdn2_absolute_url;

	public $use_cdn_origin_node;
	public $cdn_origin_node;
	public $cdn_origin_node_domain;
	public $cdn_origin_node_scheme;
	public $cdn_origin_node_absolute_url;

	public $base_href;
	public $current;
	public $currentPhpScript;
	public $full_http_uri;
	public $full_https_uri;
	public $path;
	public $port;
	public $queryString;
	public $scheme;
	public $sslFlag;

	public $referrer;
	public $referrerHost;
	public $referrerPath;
	public $referrerQueryString;
	public $referrerScheme;
	public $referrerPhpScript;

	public $requestedUri;
	public $requestedUrl;

	public static function getInstance(Zend_Config $config)
	{
		// Check if a Singleton exists for this class
		$instance = self::$_instance;

		if (!isset($instance) || !($instance instanceof Uri)) {
			$instance = new Uri($config);
			self::$_instance = $instance;
		}

		return $instance;
	}

	/**
	 * Constructor.
	 *
	 * Initialize the URL values for the given site/application.
	 *
	 * http							= "http://localdev.axis.com/"
	 * https						= "http://localdev.axis.com/"
	 * cdn							= "//localdev-cdn1.axis.com/"
	 * css							= "/css/"
	 * img							= "/images/"
	 * js							= "/js/"
	 * http_protocol				= "http"
	 * https_protocol				= "http"
	 * cdn_protocol					= ""
	 * allow_dynamic_hostname		= "0"
	 *
	 * @param Zend_Config $config
	 * @param unknown_type $forceFlag
	 */
	private function __construct(Zend_Config $config, $forceFlag = false)
	{
		$urlsInitialized = $this->urlsInitialized;

		if (!$urlsInitialized || $forceFlag) {
			$this->_data = $config->toArray();
			$this->convertDataToProperties();
			$allow_dynamic_hostname = $this->allow_dynamic_hostname;

			// Parse out the current URI into a Zend_Uri object.
			// This can then be used to derive all other formats.
			if (isset($config->sapi) && ($config->sapi == 'cli')) {
				$cliFlag = true;
			} else {
				$cliFlag = false;
			}

			// Debug
			//$cliFlag = true;

			if (!$cliFlag) {
				$this->parseRequestedUri($allow_dynamic_hostname);
			} else {
				/**
				 * @todo Add in argv URL for custom "$uri->current" value.
				 */
				$this->current = $this->http;
			}
			$domain = '';
			// All values are already defined in the config file: www.example.com.ini
			// This section allows on the fly overriding the config file values
			if ($allow_dynamic_hostname) {
				$http_prefix = $this->http_prefix;
				$https_prefix = $this->https_prefix;
				$cdn_prefix = $this->cdn_prefix;
				$cdn_scheme = $this->cdn_scheme;

				// Confirm that $this->domain is set from the Host request-header field from the browser or HTTP user agent.
				// It would have been set in parseRequestedUri()
				if (!isset($this->domain)) {
					// Not set so use config value
					$this->domain = $config->domain;
				}

				$arrTmp = explode('.', $this->domain);
				if (count($arrTmp) > 2) {
					// e.g. www.example.com -> .example.com
					array_shift($arrTmp);
					$wildcard_subdomain = join('.', $arrTmp);
					$wildcard_subdomain = ".$wildcard_subdomain";
				} else {
					$wildcard_subdomain = ".$domain";
				}
				$this->wildcard_subdomain = $wildcard_subdomain;

				$http = $http_prefix . $this->domain . '/';
				$this->http = $http;

				$https = $https_prefix . $this->domain . '/';
				$this->https = $https;

				$use_cdn_origin_node = $this->use_cdn_origin_node;
				if (isset($this->use_cdn_origin_node) && $this->use_cdn_origin_node && isset($this->cdn_origin_node) && $this->cdn_origin_node) {
					$cdn_origin_node = $this->cdn_origin_node;
					$cdn_origin_node_domain = $this->cdn_origin_node_domain;
					$cdn_origin_node_scheme = $this->cdn_origin_node_scheme;
					$cdn_origin_node_absolute_url = $this->cdn_origin_node_absolute_url;

					$cdn = $cdn_origin_node;
					$cdn1 = $cdn_origin_node;
					$cdn2 = $cdn_origin_node;
					$cdn_absolute_url = $cdn_origin_node_absolute_url;

					$this->cdn = $cdn;
					$this->cdn1 = $cdn1;
					$this->cdn2 = $cdn2;
					$this->cdn_absolute_url = $cdn_absolute_url;
				} else {
					$cdn = $cdn_prefix . $this->domain . '/';
					$cdn1 = $cdn_prefix . $this->domain . '/';
					$cdn2 = $cdn_prefix . $this->domain . '/';
					$cdn_absolute_url = $cdn_scheme . '://' . $this->domain . '/';

					$this->cdn = $cdn;
					$this->cdn1 = $cdn1;
					$this->cdn2 = $cdn2;
					$this->cdn_absolute_url = $cdn_absolute_url;
				}
			}

			$tmpCurrent = substr($this->current, 1);
			$this->full_http_uri  = $this->http  . $tmpCurrent;
			$this->full_https_uri = $this->https . $tmpCurrent;

			if (isset($_SERVER['HTTP_REFERER']) && !empty($_SERVER['HTTP_REFERER'])) {
				$HTTP_REFERER = $_SERVER['HTTP_REFERER'];
				if (is_int(strpos($HTTP_REFERER, '?'))) {
					// Remove debug string added by ZS
					$referrer = $this->removeZendDebugUrlTokens($HTTP_REFERER);
					// Remove decloak string that may be present
					$decloak_url_key = $this->decloak_url_key;
					$referrer = $this->removeDecloakUrlTokens($decloak_url_key, $referrer);
				} else {
					$referrer = $HTTP_REFERER;
				}
				$arrParsedReferrerUrl = parse_url($referrer);
				if (isset($arrParsedReferrerUrl['host'])) {
					$referrerHost = $arrParsedReferrerUrl['host'];
				} else {
					$referrerHost = '';
				}
				if (isset($arrParsedReferrerUrl['path'])) {
					$referrerPath = $arrParsedReferrerUrl['path'];
				} else {
					$referrerPath = '';
				}
				if (isset($referrer) && !empty($referrer)) {
					$referrerPhpScript = $this->parsePhpScriptFromUrl($referrer);
				} else {
					$referrerPhpScript = '';
				}
				if (isset($arrParsedReferrerUrl['query'])) {
					$referrerQueryString = '?'.$arrParsedReferrerUrl['query'];
				} else {
					$referrerQueryString = '';
				}
				if (isset($arrParsedReferrerUrl['scheme'])) {
					$referrerScheme = $arrParsedReferrerUrl['scheme'];
				} else {
					$referrerScheme = '';
				}
			} else {
				$referrer = '';
				$referrerHost = '';
				$referrerPath = '';
				$referrerPhpScript = '';
				$referrerQueryString = '';
				$referrerScheme = '';
			}
			$this->referrer = $referrer;
			$this->referrerHost = $referrerHost;
			$this->referrerPath = $referrerPath;
			$this->referrerPhpScript = $referrerPhpScript;
			$this->referrerQueryString = $referrerQueryString;
			$this->referrerScheme = $referrerScheme;

			if (isset($_SERVER['SERVER_ADDR'])) {
				$server_ip_address = $_SERVER['SERVER_ADDR'];
			} else {
				$server_ip_address = '';
			}

			if (isset($_SERVER['REMOTE_ADDR'])) {
				$remote_ip_address = $_SERVER['REMOTE_ADDR'];
			} else {
				$remote_ip_address = '';
			}

			if (isset($_SERVER['REMOTE_HOST'])) {
				$remote_host = $_SERVER['REMOTE_HOST'];
			} else {
				$remote_host = '';
			}

			if (isset($_SERVER['REMOTE_PORT'])) {
				$remote_port = $_SERVER['REMOTE_PORT'];
			} else {
				$remote_port = '';
			}

			if (isset($_SERVER['REMOTE_USER'])) {
				$remote_user = $_SERVER['REMOTE_USER'];
			} else {
				$remote_user = '';
			}

			$this->server_ip_address = $server_ip_address;
			$this->remote_ip_address = $remote_ip_address;
			$this->remote_host = $remote_host;
			$this->remote_port = $remote_port;
			$this->remote_user = $remote_user;

			$this->convertPropertiesToData();

			$this->urlsInitialized = true;
		}
	}

	/**
	 * CLI mode will not have the values set so need to use config file in that case.
	 * E.g. CLI publishing engine mode.
	 *
	 */
	public function parseRequestedUri($allow_dynamic_hostname)
	{
		//$arrHeaders = apache_request_headers();

		// $_SERVER['SERVER_NAME'] and $_SERVER['REQUEST_URI'] are not available from CLI
		// The Host request-header field from the browser or HTTP user agent.
		// $HTTP_HOST = $_SERVER['HTTP_HOST'];
		// The apache conf value assuming: UseCanonicalName On and ServerName is set.
		// $_SERVER['SERVER_NAME']

		// Debug
		//unset($_SERVER['SERVER_NAME']);
		//unset($_SERVER['REQUEST_URI']);

		// Normalize HTTP URI Request into parts
		// scheme://domain:port/path?query_string#fragment_id
		// scheme://domain/path?query_string
		if (isset($_SERVER['SERVER_PORT']) && !empty($_SERVER['SERVER_PORT'])) {
			$port = $_SERVER['SERVER_PORT'];
		} else {
			// Set sensible default for CLI scripts
			$port = null;
		}

		if (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] <> 'off') || ($port == 443)) {
			$scheme = 'https';
			$sslFlag = true;
		} elseif (isset($port)) {
			if ($port == 443) {
				$scheme = 'https';
				$sslFlag = true;
			} elseif ($port == 80) {
				$scheme = 'http';
				$sslFlag = false;
			} else {
				$scheme = 'http';
				$sslFlag = false;
			}
		} else {
			$scheme = 'http';
			$sslFlag = false;
		}

		if (isset($_SERVER['SCRIPT_URI']) && !empty($_SERVER['SCRIPT_URI'])) {
			$SCRIPT_URI = $_SERVER['SCRIPT_URI'];
		} else {
			$SCRIPT_URI = null;
		}

		// $_SERVER['SERVER_NAME'] and $_SERVER['REQUEST_URI'] are not available from CLI
		if (isset($_SERVER['HTTP_HOST']) && !empty($_SERVER['HTTP_HOST'])) {
			$domain = $_SERVER['HTTP_HOST'];
		} elseif (isset($_SERVER['SERVER_NAME']) && !empty($_SERVER['SERVER_NAME'])) {
			$domain = $_SERVER['SERVER_NAME'];
		} else {
			$domain = null;
		}

		// $currentPhpScript e.g. "/path/to/script.php" -> "script.php"
		if (isset($_SERVER['PHP_SELF']) && !empty($_SERVER['PHP_SELF'])) {
			$tmpPath = $_SERVER['PHP_SELF'];
			$arrTmpPath = explode('/', $tmpPath);
			$currentPhpScript = array_pop($arrTmpPath);
		} else {
			$currentPhpScript = '';
		}

		// $path e.g. "/path/to/script.php?a=1&b=2" -> "/path/to/script.php"
		if (isset($_SERVER['PHP_SELF']) && !empty($_SERVER['PHP_SELF'])) {
			$path = $_SERVER['PHP_SELF'];
		} else {
			$path = null;
		}

		// Query string
		// NOTE: we may want to remove the debug and decloak URL tokens...
		$queryString = (isset($_SERVER['QUERY_STRING']) && !empty($_SERVER['QUERY_STRING']) ? '?'.$_SERVER['QUERY_STRING'] : '');

		// $_SERVER['SERVER_NAME'] and $_SERVER['REQUEST_URI'] are not available from CLI
		if (isset($_SERVER['REQUEST_URI']) && !empty($_SERVER['REQUEST_URI'])) {
			$REQUEST_URI = $_SERVER['REQUEST_URI'];
		} else {
			$REQUEST_URI = null;
		}

		// Form the final $url and $base_href URL values
		// Explicitly check for each available URL component as we may be running PHP CLI or as a service
		// scheme://domain/path?query_string
		if (isset($scheme) && isset($domain) && isset($REQUEST_URI)) {
			$requestedUrl = "$scheme://$domain$REQUEST_URI";
		} else {
			$requestedUrl = null;
		}
		if (isset($scheme) && isset($domain) && isset($path)) {
			$base_href = "$scheme://$domain$path";
		} else {
			$base_href = null;
		}

		// Form the $current URL value
		if (isset($REQUEST_URI)) {
			if (is_int(strpos($REQUEST_URI, '?'))) {
				// Remove debug string added by ZS
				$current = $this->removeZendDebugUrlTokens($REQUEST_URI);
				// Remove decloak string that may be present
				$decloak_url_key = $this->decloak_url_key;
				$current = $this->removeDecloakUrlTokens($decloak_url_key, $current);
			} else {
				$current = $REQUEST_URI;
			}
		} else {
			$current = null;
		}
		$sslFlag = '';
		$scheme = '';
		$this->sslFlag = $sslFlag;
		$this->scheme = $scheme;
		$this->port = $port;
		$this->path = $path;
		$this->queryString = $queryString;
		$this->base_href = $base_href;
		$this->current = $current;
		$this->currentPhpScript = $currentPhpScript;
		$this->requestedUrl = $requestedUrl;

		if ($allow_dynamic_hostname) {
			$this->domain = $domain;
		}

		//require_once('Zend/Uri.php');
		//$requestedUri = Zend_Uri::factory($requestedUrl);
		//$this->requestedUri = $requestedUri;
	}

	public function parsePhpScriptFromUrl($url)
	{
		$tmp = preg_replace('/[#].+$/', '', $url);
		$tmp = preg_replace('/[?&].+$/', '', $tmp);
		$arrTmp = explode('/', $tmp);
		$phpScript = array_pop($arrTmp);
		$phpScript = trim($phpScript);

		return $phpScript;
	}

	public function removeZendDebugUrlTokens($url)
	{
		$urlOutput = preg_replace('/[?&]{1}start_debug.*$/', '', $url);
		return $urlOutput;
	}

	public function removeDecloakUrlTokens($decloak_url_key, $url)
	{
		// '/[?&]{1}abc=123&decloak=true.*$/'
		$regex = "/[?&]{1}$decloak_url_key.*$/";
		$urlOutput = preg_replace($regex, '', $url);
		return $urlOutput;
	}

	/**
	 * Convert a simple URI into an absolute content delivery network URI.
	 *
	 * @param string $src
	 * @return string
	 */
	public function src($uri = null)
	{
		if (isset($uri)) {
			$db = $this->getDb();
			$query =	'SELECT revved_uri '.
						'FROM uri_component_registry '.
						'WHERE uri = ? '.
						'AND deleted_flag != 1 '.
						'AND disabled_flag != 1 ';

			$arrValues = array($uri);
			$db->execute($query, $arrValues);
			$row = $db->fetch();
			$db->free_result();
			$revved_uri = $row['revved_uri'];
		}

		$revved_uri = (string) $revved_uri;
		$revved_uri = substr($revved_uri, 1);
		$uri = Zend_Registry::get('uri');
		$revved_uri = $uri->cdn.$revved_uri;

		return $revved_uri;
	}

	/**
	 * Get the current page's exact uri.  This includes any query string, etc.
	 *
	 */
	public function getCurrent()
	{
		if (isset($_SERVER['REQUEST_URI']) && !empty($_SERVER['REQUEST_URI'])) {
			$REQUEST_URI = $_SERVER['REQUEST_URI'];
			if (is_int(strpos($REQUEST_URI, '?'))) {
				// Remove debug string added by ZS
				$current = $this->removeZendDebugUrlTokens($REQUEST_URI);
				// Remove decloak string that may be present
				$decloak_url_key = $this->decloak_url_key;
				$current = $this->removeDecloakUrlTokens($decloak_url_key, $current);
			} else {
				$current = $REQUEST_URI;
			}
		} else {
			$current = '';
		}

		return $current;
	}

	/**
	 * Get the current page's fully qualified base URL.  This excludes any query string, etc.
	 *
	 */
	public function getBaseHref()
	{
		if (isset($_SERVER['SCRIPT_URI']) && !empty($_SERVER['SCRIPT_URI'])) {
			$SCRIPT_URI = $_SERVER['SCRIPT_URI'];
			if (is_int(strpos($SCRIPT_URI, '?'))) {
				// Remove debug string added by ZS
				$base_href = removeZendDebugUrlTokens($SCRIPT_URI);
				// Remove decloak string that may be present
				$decloak_url_key = $this->decloak_url_key;
				$base_href = $this->removeDecloakUrlTokens($decloak_url_key, $base_href);
			} else {
				$base_href = $SCRIPT_URI;
			}
		} else {
			$base_href = '';
		}

		return $base_href;
	}

	/**
	 * Parse url snippet and return the base portion (possibly empty string) and the filters in an array.
	 *
	 * activeTab-offset-limit-filter values
	 *
	 * should add regex sanity checks to input values
	 *
	 * @param string $url
	 * @param string $paginationSeparator
	 * @return array $arrReturn
	 */
	public static function parseUrlFilterValues($url, $paginationSeparator='-pp-')
	{
		//sanity check for the pagination separator
		if (is_int(strpos($url, $paginationSeparator))) {
			//split on the pagination separator with the base string and the filters portion
			$arrPagination = explode($paginationSeparator, $url);

			//get the last piece of the string and join back the rest
			// this prevents problems if the pagination separator is in the url for some other reason
			$pagination = array_pop($arrPagination);

			//in rare case pagination separator is part of the legitimate url itself
			// if array is just one element, then the join will do nothing...that is why this works
			$urlSnippet = join($paginationSeparator, $arrPagination);

			$len = strlen($pagination);
			if ($len > 0 ) {
				$arrInput = preg_split('/[-]{1}/', $pagination, -1, PREG_SPLIT_NO_EMPTY);
				//activeTab
				if (isset($arrInput[0])) {
					$activeTab = $arrInput[0];
				} else {
					$activeTab = 'default';
				}
				//offset
				if (isset($arrInput[1])) {
					$offset = $arrInput[1];
				} else {
					$offset = 0;
				}
				//limit
				if (isset($arrInput[2])) {
					$limit = $arrInput[2];
				} else {
					$limit = 200;
				}
				//filter
				if (isset($arrInput[3])) {
					$filter = $arrInput[3];
				} else {
					$filter = 'all';
				}
			} else {
				$urlSnippet = $url;
				$activeTab = 'default';
				$offset = 0;
				$limit = 200;
				$filter = 'all';
			}
		} else {
			$urlSnippet = $url;
			$activeTab = 'default';
			$offset = 0;
			$limit = 20;
			$filter = 'all';
		}

		$arrReturn = array(
			'urlSnippet' => $urlSnippet,
			'activeTab' => $activeTab,
			'offset' => $offset,
			'limit' => $limit,
			'filter' => $filter
		);

		return $arrReturn;
	}

	/**
	 * /upgrades/ibm/thinkpad/a31/2652m6u/kingston-dram-ktm-tp0028-512--pp-DRAM-partdetails-0-100-all/
	 *
	 * Parse a url into:
	 * 1) Grouping
	 * 2) Active Section or Tab
	 * 3) Offset
	 * 4) Limit
	 * 5) Filter
	 * 6) Any Future Additions...
	 *
	 * Reverse the order of the tokens for now???
	 *
	 * @param string $url
	 * @return array $arrReturn
	 */
	public static function parseUrlFilterValuesExtended($url, $paginationSeparator='pp-')
	{
		//sanity check for the pagination separator
		if (is_int(strpos($url, $paginationSeparator))) {
			//split on the pagination separator with the base string and the filters portion
			$arrPagination = explode($paginationSeparator, $url);

			//get the last piece of the string and join back the rest
			// this prevents problems if the pagination separator is in the url for some other reason
			$pagination = array_pop($arrPagination);

			//in rare case pagination separator is part of the legitimate url itself
			// if array is just one element, then the join will do nothing...that is why this works
			$urlSnippet = join($paginationSeparator, $arrPagination);

			$len = strlen($pagination);
			if ($len > 0 ) {
				$arrInput = preg_split('/[-]{1}/', $pagination, -1, PREG_SPLIT_NO_EMPTY);
				// activeGrouping
				if (isset($arrInput[0])) {
					$activeGrouping = $arrInput[0];
				} else {
					$activeGrouping = 'default';
				}
				// activeTab
				if (isset($arrInput[1])) {
					$activeTab = $arrInput[1];
				} else {
					$activeTab = 'default';
				}
				// offset
				if (isset($arrInput[2])) {
					$offset = $arrInput[2];
				} else {
					$offset = 0;
				}
				// limit
				if (isset($arrInput[3])) {
					$limit = $arrInput[3];
				} else {
					$limit = 200;
				}
				// filter
				if (isset($arrInput[4])) {
					$filter = $arrInput[4];
				} else {
					$filter = 'all';
				}
			} else {
				$urlSnippet = $url;
				$activeGrouping = 'default';
				$activeTab = 'default';
				$offset = 0;
				$limit = 200;
				$filter = 'all';
			}
		} else {
			$urlSnippet = $url;
			$activeGrouping = 'default';
			$activeTab = 'default';
			$offset = 0;
			$limit = 20;
			$filter = 'all';
		}

		$arrReturn = array(
			'urlSnippet' => $urlSnippet,
			'activeGrouping' => $activeGrouping,
			'activeTab' => $activeTab,
			'offset' => $offset,
			'limit' => $limit,
			'filter' => $filter
		);

		return $arrReturn;
	}
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

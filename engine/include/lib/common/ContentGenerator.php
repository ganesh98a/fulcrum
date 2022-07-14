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
 * Generate Lorem Ipsum dummy placeholder content.
 *
 * @category   ContentGenerator
 * @package    ContentGenerator
 *
 */

class ContentGenerator
{
	/**
	 * Lipson JSON URI
	 */
	CONST URI = "http://www.lipsum.com/feed/json";

	/**
	 * Default Count
	 */
	CONST COUNT = 5;

	/**
	 * Default staring with Lorem Ipsum....
	 */
	CONST START = "yes";

	/**
	 * Default List Type
	 */
	CONST LIST_TYPE = "ul";

	/**
	 * Zend_Http_Client
	 */
	protected $_localHttpClient;

	protected static $_initFlag = false;

	/**
	 * Public constructor
	 *
	 * Setup http client
	 * @return void
	 */
	public function __construct()
	{
		if (!ContentGenerator::$_initFlag) {
			ContentGenerator::init();
		}
		$this->_localHttpClient = new Zend_Http_Client();
		$uri = self::URI;
		$this->_localHttpClient->setUri($uri);
	}

	protected static function init()
	{
		if (ContentGenerator::$_initFlag) {
			return;
		}

		require_once('Zend/View/Helper/Abstract.php');
		require_once('Zend/Http/Client.php');
		require_once('Zend/Json.php');

		ContentGenerator::$_initFlag = true;
	}

	/**
	 * View helper.  Route to correct helper via options.
	 * default to paragraph
	 * @return string
	 */
	public function loremIpsum(array $options)
	{
		switch($options['type']) {
			case 'words':
				return $this->_words($options);
				break;
			case 'bytes':
				return $this->_bytes($options);
				break;
			case 'lists':
				return $this->_lists($options);
				break;
			case 'paragraph':
			default:
				return $this->_paragraph($options);
		}
	}

	/**
	 * Validate count to make sure it's set.
	 * @return string
	 */
	protected function _validateCount($count)
	{
		if (is_numeric($count) && isset($count)) {
			return $count;
		} else {
			return self::COUNT;
		}
	}

	/**
	 * Validate Start to make sure it's set
	 * @return string
	 */
	protected function _validateStart($start)
	{
		if (isset($start) && ("yes" === $start || "no" === $start)) {
			return $start;
		} else {
			return self::START;
		}
	}

	/**
	 * Validate list type to make sure it's set
	 * @return string
	 */
	protected function _validateListType($type)
	{
		if (isset($type) && in_array($type, array('ul', 'ol'))) {
			return $type;
		} else {
			return self::LIST_TYPE;
		}
	}

	/**
	 * Generate Paragraphs
	 * @param array $options
	 * @return string
	 */
	protected function _paragraph(array $options)
	{
		$httpClient = $this->_localHttpClient;
		$httpClient->resetParameters(true);

		$count = $options['count'];
		$start = $options['start'];
		$validatedCount = $this->_validateCount($count);
		$validatedStart = $this->_validateStart($start);

		$arrPostParameters = array(
			'what' => 'paras',
			'amount' => $validatedCount,
			'start' => $validatedStart,
		);

		$httpClient->setParameterPost($arrPostParameters);
		$requestType = Zend_Http_Client::POST;
		$response = $httpClient->request($requestType);
		$responseBody = $response->getBody();
		$jsonData = str_replace("\n", "</p><p>", $responseBody);
		$data = Zend_Json::decode($jsonData);
		$content = $data['feed']['lipsum'];
		$formattedContent = "<p>" . $content . "</p>";

		return $formattedContent;
	}

	/**
	 * Generate words
	 * @param array $options
	 * @return string
	 */
	protected function _words(array $options)
	{
		$this->_localHttpClient->resetParameters(true)->setParameterPost(array(
			'what' => 'words',
			'amount' => $this->_validateCount($options['count']),
			'start' => $this->_validateStart($options['start']),
		));
		$response = $this->_localHttpClient->request(Zend_Http_Client::POST);
		$data = str_replace("\n", "", $response->getBody());
		$data = Zend_Json::decode($data);
		return $data['feed']['lipsum'];
	}

	/**
	 * Generate words with the specified bytes
	 * @param array $options
	 */
	protected function _bytes(array $options)
	{
		$this->_localHttpClient->resetParameters(true)->setParameterPost(array(
			'what' => 'bytes',
			'amount' => $this->_validateCount($options['count']),
			'start' => $this->_validateStart($options['start']),
		));
		$response = $this->_localHttpClient->request(Zend_Http_Client::POST);
		$data = str_replace("\n", "", $response->getBody());
		$data = Zend_Json::decode($data);
		return $data['feed']['lipsum'];
	}

	/**
	 * Gernerate UL or OL lists
	 * @param array $options
	 * @return string
	 */
	protected function _lists(array $options)
	{
		$this->_localHttpClient->resetParameters(true)->setParameterPost(array(
			'what' => 'lists',
			'amount' => $this->_validateCount($options['count']),
			'start' => $this->_validateStart($options['start']),
		));

		$listType = $this->_validateListType($options['list']);

		$response = $this->_localHttpClient->request(Zend_Http_Client::POST);
		$data = str_replace("\n", "_LIST_", $response->getBody());
		$data = Zend_Json::decode($data);

		$ulLists = array();

		$lists = explode("_LIST_", $data['feed']['lipsum']);
		foreach ($lists AS $list) {
			$items = explode(".", $list);
			$listItems = array();
			foreach ($items as $item) {
				if (strlen(trim($item)) > 0) {
					$listItems[] = "<li>" . trim($item) . "</li>";
				}
			}
			$lis = implode("\n", $listItems);
			$ulLists[] = "<" . $listType . ">" . $lis . "</" . $listType . ">";
		}

		return implode("\n", $ulLists);
	}

	/**
	 * Generate random text
	 *
	 * string getContent( int $wordCount [, string $format = html] [, boolean $loremipsum = true] )
	 *
	 * @param int $wordCount The number of words to be returned.
	 * @param string $type (txt|plain|html)
	 * @param boolean $loremipsum Whether or not the content should begin with ‘Lorem ipsum’. True by default.
	 */
	public static function generateContent($wordCount=100, $format='txt', $loremipsum=true)
	{
		/**
		 * LoremIpsumGenerator
		 */
		require_once('ContentGenerator/LoremIpsum.class.php');

		if (($format <> 'html') && ($format <> 'plain') && ($format <> 'txt')) {
			$format = 'txt';
		}

		$generator = new LoremIpsumGenerator();
		$content = $generator->getContent($wordCount, $format, $loremipsum);

		return $content;
	}

	public static function generateParagraphs($count=1)
	{

	}
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

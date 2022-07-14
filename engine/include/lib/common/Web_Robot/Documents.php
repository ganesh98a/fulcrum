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
 * ORM web_robot_documents table.
 *
 * Full content from spidered/scraped web documents, images, etc.
 *
 * @category   Framework
 * @package    Web_Robot
 */

/**
 * File
 */
require_once('lib/common/File.php');

/**
 * Integrated_Mapper
 */
require_once('lib/common/IntegratedMapper.php');

class Web_Robot_Documents extends IntegratedMapper
{
	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var unknown_type
	 */
	protected $_table = 'web_robot_documents';

	protected $compressed = false;

	protected $compressionLevel = 9;

	/**
	 * This is a temp location for the content while it is being saved.
	 * The content is saved in a compressed format.
	 *
	 * $_data holds the values that are INSERTED/UPDATED so this value
	 * is ignored during the save() operation.
	 *
	 * @var string
	 */
	protected $uncompressed_content;

	const driveRootFolder = 'C:/Web_Robot_Documents';

	const fileNamePrefix = '_';

	/**
	 * Constructor.
	 *
	 */
	public function __construct()
	{
		parent::__construct($this->_table);
		$this->_database = 'bots';
	}

	public function setCompressed($boolean)
	{
		$boolean = (bool) $boolean;
		$this->compressed = $boolean;
	}

	public static function compressFullContentField()
	{
		$document = new Web_Robot_Documents();
		$db = $document->getDb();

		$query = 'SELECT d.`url`, d.`full_content`, d.`modified` '.
				 'FROM web_robot_documents d ';
		$db->query($query);
		$arrRecords = array();
		while($row = $db->fetch()) {
			$arrRecords[] = $row;
		}
		$db->free_result();
		$db->reset();

		$counter = 0;
		foreach ($arrRecords as $record) {
			$url = $record['url'];
			//Don't need to update the url value
			unset($record['url']);

			$d = new Web_Robot_Documents();
			$d->setData($record);
			unset($record);
			$d->setCompressed(false);

			//Compression
			$full_content = $d->full_content;
			$d->compress($full_content);
			$d->full_content = $full_content;
			unset($full_content);

			$key = array('url' => $url);
			$d->setKey($key);
			$d->save();
			$counter++;
		}

		return $counter;
	}

	public static function findById($id,$database='', $table='web_robot_documents', $class='WebRobotDocuments')
	{
		$document = new Web_Robot_Documents();
		$db = $document->getDb();

		$query = 'SELECT d.* '.
				 'FROM web_robot_documents d '.
				 'WHERE d.`id` = ? ';
		$arrValues = array($id);
		$db->execute($query, $arrValues);
		$row = $db->fetch();
		$db->free_result();
		$db->reset();
		unset($db);
		unset($query);
		unset($arrValues);

		if (isset($row) && !empty($row)) {
			$id = $row['id'];
			$url = $row['url'];
			$document->setData($row);
			$key = array('id' => $id);
			$document->setKey($key);
			unset($row);

			// Load file from file system
			$arrFilePath = Web_Robot_Documents::createFilePathFromId($id);
			$path = $arrFilePath['path'];
			$filename = $arrFilePath['filename'];
			$fullPath = $path.$filename;
			$full_content = File::fread($fullPath);
			$document->full_content = $full_content;
			unset($full_content);

			// Uncompress content
			$document->uncompress($document->full_content);
			$document->compressed = false;
		}

		return $document;
	}

	/**
	 * Load a record from its URL.
	 *
	 * @param Zend_Uri $uri
	 * @return Web_Robot_Documents object
	 */
	public static function findByUrl(Zend_Uri $uri)
	{
		if (!isset($uri)|| !($uri instanceof Zend_Uri)) {
			throw new Exception('Missing param');
		}

		/**
		 * Extract URL string.
		 */
		$url = $uri->getUri();

		$document = new Web_Robot_Documents();
		$db = $document->getDb();

		$query = 'SELECT d.* '.
				 'FROM web_robot_documents d '.
				 'WHERE d.url = ? ';
		$arrValues = array($url);
		$db->execute($query, $arrValues);
		$row = $db->fetch();
		$db->free_result();
		$db->reset();
		unset($db);
		unset($query);
		unset($arrValues);

		if (isset($row) && !empty($row)) {
			$id = $row['id'];
			$url = $row['url'];
			$document->setData($row);
			$key = array('url' => $url);
			$document->setKey($key);
			unset($row);

			// Load file from file system
			$arrFilePath = Web_Robot_Documents::createFilePathFromId($id);
			$path = $arrFilePath['path'];
			$filename = $arrFilePath['filename'];
			$fullPath = $path.$filename;
			$full_content = File::fread($fullPath);
			$document->full_content = $full_content;
			unset($full_content);

			// Uncompress content
			$document->uncompress($document->full_content);
			$document->compressed = false;
		}

		return $document;
	}

	/**
	 * Compression of full_content is transparently handled in the following methods:
	 *
	 * 1) public function prepareDocumentForSave(Web_Robot $bot)
	 * 2) public function save()
	 * 3) public static function findByUrl(Zend_Uri $uri) methods.
	 *
	 * @param Web_Robot $bot
	 */
	public function prepareDocumentForSave(Web_Robot $bot)
	{
		// Extract needed objects and data.
		$uri = $bot->getUri();
		$referer = $bot->getReferer();
		$fullContent = $bot->getFullContent();

		$client = $bot->getHttpClient();
		/* @var $client Web_Robot_Http_Client */

		$request = $client->getLastRequest();
		$response = $client->getLastResponse();
		/* @var $response Zend_Http_Response */

		// Prepare variables.
		$url = $uri->getUri();
		$url = str_replace(':80', '', $url);
		$parentUrl = $referer->getUri();
		$parentUrl = str_replace(':80', '', $parentUrl);
		$webRobotName = $bot->getRobotName();
		$type = $bot->getType();
		$date = (string) $response->getHeader('date');
		$lastModified = (string) $response->getHeader('last-modified');
		$expires = (string) $response->getHeader('expires');
//		$fullContent = $response->getBody();
		$sha1 = sha1($fullContent);
		$size = strlen($fullContent);
		$etag = (string) $response->getHeader('etag');
		$contentEncoding = (string) $response->getHeader('content-encoding');
		$contentType = (string) $response->getHeader('content-type');

		// Perform insert/update operation via save() method
		$this->url = $url;
		$this->parent_url = $parentUrl;
		$this->web_robot_name = $webRobotName;
		$this->type = $type;

		// Compress content
		// Want to retain uncompressed content for processing
		$this->uncompressed_content = $fullContent;
		$this->compress($fullContent);

		$this->full_content = $fullContent;
		$this->server_response_date = $date;
		$this->last_modified = $lastModified;
		$this->expires = $expires;
		$this->sha1 = $sha1;
		$this->file_size = $size;
		$this->e_tag = $etag;
		$this->content_encoding = $contentEncoding;
		$this->content_type = $contentType;
	}

	/**
	 * full_content is saved as a compressed string so restore the
	 * uncompressed full_content back after a save operation.
	 *
	 */
	public function save()
	{
		// Don't write file contents to the database...it chokes after 6GB+
		$full_content = $this->full_content;
		unset($this->full_content);
		$id = parent::save();

		// Save file contents to disk
		if (!isset($id)) {
			$id = $this->id;
		}
		$arrFilePath = Web_Robot_Documents::createFilePathFromId($id);
		$path = $arrFilePath['path'];
		$filename = $arrFilePath['filename'];
		$f = new File();
		$f->fwrite($path, $filename, $full_content);

		// Put content back for convenience of processing
		$this->full_content = $this->uncompressed_content;
	}

	/**
	 * Compress content using GZIP OR ZLIB compression.
	 *
	 * @param string $content
	 */
	public function compress(& $content)
	{
		if (!$this->compressed) {
			$content = gzdeflate($content, $this->compressionLevel);
			$this->compressed = true;
		}

		//Test Cases: gzdeflate barely edged out the others on average.
		//$deflate = gzdeflate($content, 9);
		//$encode = gzencode($content, 9);
		//$compress = gzcompress($content, 9);
	}

	/**
	 * Decompress content using GZIP OR ZLIB compression.
	 *
	 * @param string $content
	 */
	public function uncompress(& $content)
	{
		$tmp = $content;
		$tmp = gzinflate($tmp);

		// gzinflate() returns false upon failure...file might not have been
		// compressed to begin with.
		if ($tmp) {
			$content = $tmp;
		}
	}

	/**
	 * Load parent documents.
	 *
	 */
	public function loadParents()
	{
	}

	/**
	 * Load child documents.
	 *
	 */
	public function loadChildren()
	{
	}

	/**
	 * Form a file path with a folder path and a filename from the db primary key "id"
	 *
	 * e.g. 498847 -> J:/X/49/88/_47
	 *
	 * @param int $id
	 * @return string
	 */
	public static function createFilePathFromId($id)
	{
		if (!isset($id)) {
			// bad input
			echo "Bad input: $id";
			exit;
		}

		$driveRootFolder = Web_Robot_Documents::driveRootFolder;
		$fileNamePrefix = Web_Robot_Documents::fileNamePrefix;

		$arrPath = str_split($id, 2);
		$fileName = array_pop($arrPath);
		$fileName = $fileNamePrefix.$fileName;
		$path = $driveRootFolder.'/';
		foreach ($arrPath as $pathChunk) {
			$path .= $pathChunk.'/';
		}
		//$path .= $fileName;

		$arrReturn = array(
			'path' => $path,
			'filename' => $fileName
		);

		return $arrReturn;
	}
}

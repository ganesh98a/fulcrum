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
 * Manage binary and text files on disk in the cloud.
 *
 * @category   Framework
 * @package    FileLocation
 */

/**
 * File
 */
require_once('lib/common/File.php');

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class FileLocation extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'FileLocation';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'file_locations';

	/**
	 * primary key (`id`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrPrimaryKey = array(
		'id' => 'int'
	);

	/**
	 * unique index `unique_file_location` (`file_sha1`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_file_location' => array(
			'file_sha1' => 'string'
		)
	);

	/**
	 * Standard attributes list.
	 *
	 * Metadata mapper pattern maps db attributes to object properties.
	 *
	 * Key - database attribute/field
	 * Value - object property
	 *
	 * @var array
	 */
	protected $arrAttributesMap = array(
		'id' => 'file_location_id',

		'file_sha1' => 'file_sha1',

		'cloud_vendor' => 'cloud_vendor',
		'url' => 'url',
		'file_size' => 'file_size',
		'file_size_compressed' => 'file_size_compressed',
		'compression_ratio' => 'compression_ratio',
		'modified' => 'modified',
		'created' => 'created'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $file_location_id;

	public $file_sha1;

	public $cloud_vendor;
	public $url;
	public $file_size;
	public $file_size_compressed;
	public $compression_ratio;
	public $modified;
	public $created;

	// Other Properties
	//protected $_otherPropertyHere;
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

	//const driveRootFolder = 'J:/Web_Robot_Documents';
	const driveRootFolder = 'F:/dev/build/sites/branches/development/engine/include/lib/common/Scraper/Web_Robot_Documents';

	const fileNamePrefix = '_';

	// HTML ENTITY ENCODED ORM string properties
	public $escaped_file_sha1;
	public $escaped_url;
	public $escaped_file_size;
	public $escaped_file_size_compressed;
	public $escaped_compression_ratio;

	// HTML ENTITY ENCODED NL2BR ORM string properties
	public $escaped_file_sha1_nl2br;
	public $escaped_url_nl2br;
	public $escaped_file_size_nl2br;
	public $escaped_file_size_compressed_nl2br;
	public $escaped_compression_ratio_nl2br;

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)
	protected static $_arrFileLocationsByCloudVendor;
	protected static $_arrFileLocationsByFileSize;
	protected static $_arrFileLocationsByFileSizeCompressed;
	protected static $_arrFileLocationsByCompressionRatio;

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllFileLocations;

	// Foreign Key Objects

	/**
	 * Constructor
	 */
	public function __construct($database, $table='file_locations')
	{
		parent::__construct($table);
		$this->setDatabase($database);
	}

	// Foreign Key Object Accessor Methods

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)
	public static function getArrFileLocationsByCloudVendor()
	{
		if (isset(self::$_arrFileLocationsByCloudVendor)) {
			return self::$_arrFileLocationsByCloudVendor;
		} else {
			return null;
		}
	}

	public static function setArrFileLocationsByCloudVendor($arrFileLocationsByCloudVendor)
	{
		self::$_arrFileLocationsByCloudVendor = $arrFileLocationsByCloudVendor;
	}

	public static function getArrFileLocationsByFileSize()
	{
		if (isset(self::$_arrFileLocationsByFileSize)) {
			return self::$_arrFileLocationsByFileSize;
		} else {
			return null;
		}
	}

	public static function setArrFileLocationsByFileSize($arrFileLocationsByFileSize)
	{
		self::$_arrFileLocationsByFileSize = $arrFileLocationsByFileSize;
	}

	public static function getArrFileLocationsByFileSizeCompressed()
	{
		if (isset(self::$_arrFileLocationsByFileSizeCompressed)) {
			return self::$_arrFileLocationsByFileSizeCompressed;
		} else {
			return null;
		}
	}

	public static function setArrFileLocationsByFileSizeCompressed($arrFileLocationsByFileSizeCompressed)
	{
		self::$_arrFileLocationsByFileSizeCompressed = $arrFileLocationsByFileSizeCompressed;
	}

	public static function getArrFileLocationsByCompressionRatio()
	{
		if (isset(self::$_arrFileLocationsByCompressionRatio)) {
			return self::$_arrFileLocationsByCompressionRatio;
		} else {
			return null;
		}
	}

	public static function setArrFileLocationsByCompressionRatio($arrFileLocationsByCompressionRatio)
	{
		self::$_arrFileLocationsByCompressionRatio = $arrFileLocationsByCompressionRatio;
	}

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllFileLocations()
	{
		if (isset(self::$_arrAllFileLocations)) {
			return self::$_arrAllFileLocations;
		} else {
			return null;
		}
	}

	public static function setArrAllFileLocations($arrAllFileLocations)
	{
		self::$_arrAllFileLocations = $arrAllFileLocations;
	}

	/*
	public function getOtherProperty()
	{
		if (isset($this->_otherPropertyHere)) {
			return $this->_otherPropertyHere;
		} else {
			return null;
		}
	}
	*/

	// Finder: Find By pk (a single auto int id or a single non auto int pk)
	/**
	 * PHP < 5.3.0
	 *
	 * @param string $database
	 * @param int $file_location_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findById($database, $file_location_id, $table='file_locations', $module='FileLocation')
	{
		$fileLocation = parent::findById($database, $file_location_id, $table, $module);

		return $fileLocation;
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Similar to FindById, but with SQL as starter code for more complex joins.
	 *
	 * @param string $database
	 * @param int $file_location_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findFileLocationByIdExtended($database, $file_location_id)
	{
		$file_location_id = (int) $file_location_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	fl.*

FROM `file_locations` fl
WHERE fl.`id` = ?
";
		$arrValues = array($file_location_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$file_location_id = $row['id'];
			$fileLocation = self::instantiateOrm($database, 'FileLocation', $row, null, $file_location_id);
			/* @var $fileLocation FileLocation */
			$fileLocation->convertPropertiesToData();

			return $fileLocation;
		} else {
			return false;
		}
	}

	// Finders: Find By Unique Index
	/**
	 * Find by unique index `unique_file_location` (`file_sha1`).
	 *
	 * @param string $database
	 * @param string $file_sha1
	 * @return mixed (single ORM object | false)
	 */
	public static function findByFileSha1($database, $file_sha1)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	fl.*

FROM `file_locations` fl
WHERE fl.`file_sha1` = ?
";
		$arrValues = array($file_sha1);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if ($row && !empty($row)) {
			$file_location_id = $row['id'];
			$fileLocation = self::instantiateOrm($database, 'FileLocation', $row, null, $file_location_id);
			/* @var $fileLocation FileLocation */
			return $fileLocation;
		} else {
			return false;
		}
	}

	// Loaders: Load By pk List (list of auto int ids or other non auto int pk list)
	/**
	 * Load zero or more records by an id list (array of auto int primary keys).
	 *
	 * @param string $database
	 * @param array $arrFileLocationIds
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadFileLocationsByArrFileLocationIds($database, $arrFileLocationIds, Input $options=null)
	{
		if (empty($arrFileLocationIds)) {
			return array();
		}

		if (isset($options)) {
			$arrOrderByAttributes = $options->arrOrderByAttributes;
			$limit = $options->limit;
			$offset = $options->offset;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `file_sha1` ASC, `cloud_vendor` ASC, `url` ASC, `file_size` ASC, `file_size_compressed` ASC, `compression_ratio` ASC, `modified` ASC, `created` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpFileLocation = new FileLocation($database);
			$sqlOrderByColumns = $tmpFileLocation->constructSqlOrderByColumns($arrOrderByAttributes);

			if (!empty($sqlOrderByColumns)) {
				$sqlOrderBy = "\nORDER BY $sqlOrderByColumns";
			}
		}

		$sqlLimit = '';
		if (isset($limit)) {
			$escapedLimit = $db->escape($limit);
			if (isset($offset)) {
				$escapedOffset = $db->escape($offset);
				$sqlLimit = "\nLIMIT $escapedOffset, $escapedLimit";
			} else {
				$sqlLimit = "\nLIMIT $escapedLimit";
			}
		}

		foreach ($arrFileLocationIds as $k => $file_location_id) {
			$file_location_id = (int) $file_location_id;
			$arrFileLocationIds[$k] = $db->escape($file_location_id);
		}
		$csvFileLocationIds = join(',', $arrFileLocationIds);

		$query =
"
SELECT

	fl.*

FROM `file_locations` fl
WHERE fl.`id` IN ($csvFileLocationIds){$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		$arrFileLocationsByCsvFileLocationIds = array();
		while ($row = $db->fetch()) {
			$file_location_id = $row['id'];
			$fileLocation = self::instantiateOrm($database, 'FileLocation', $row, null, $file_location_id);
			/* @var $fileLocation FileLocation */
			$fileLocation->convertPropertiesToData();

			$arrFileLocationsByCsvFileLocationIds[$file_location_id] = $fileLocation;
		}

		$db->free_result();

		return $arrFileLocationsByCsvFileLocationIds;
	}

	// Loaders: Load By Foreign Key

	// Loaders: Load By index
	/**
	 * Load by key `cloud_vendor` (`cloud_vendor`).
	 *
	 * @param string $database
	 * @param string $cloud_vendor
	 * @param mixed (Input $options object | null)
	 * @return mixed (single ORM object | false)
	 */
	public static function loadFileLocationsByCloudVendor($database, $cloud_vendor, Input $options=null)
	{
		$forceLoadFlag = false;
		if (isset($options)) {
			$arrOrderByAttributes = $options->arrOrderByAttributes;
			$limit = $options->limit;
			$offset = $options->offset;

			// Avoid cache when using filters and limits
			if (isset($arrOrderByAttributes) || isset($limit) || isset($offset)) {
				$forceLoadFlag = true;
			} else {
				$forceLoadFlag = $options->forceLoadFlag;
			}
		}

		if ($forceLoadFlag) {
			self::$_arrFileLocationsByCloudVendor = null;
		}

		$arrFileLocationsByCloudVendor = self::$_arrFileLocationsByCloudVendor;
		if (isset($arrFileLocationsByCloudVendor) && !empty($arrFileLocationsByCloudVendor)) {
			return $arrFileLocationsByCloudVendor;
		}

		$cloud_vendor = (string) $cloud_vendor;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `file_sha1` ASC, `cloud_vendor` ASC, `url` ASC, `file_size` ASC, `file_size_compressed` ASC, `compression_ratio` ASC, `modified` ASC, `created` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpFileLocation = new FileLocation($database);
			$sqlOrderByColumns = $tmpFileLocation->constructSqlOrderByColumns($arrOrderByAttributes);

			if (!empty($sqlOrderByColumns)) {
				$sqlOrderBy = "\nORDER BY $sqlOrderByColumns";
			}
		}

		$sqlLimit = '';
		if (isset($limit)) {
			$escapedLimit = $db->escape($limit);
			if (isset($offset)) {
				$escapedOffset = $db->escape($offset);
				$sqlLimit = "\nLIMIT $escapedOffset, $escapedLimit";
			} else {
				$sqlLimit = "\nLIMIT $escapedLimit";
			}
		}

		$query =
"
SELECT
	fl.*

FROM `file_locations` fl
WHERE fl.`cloud_vendor` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `file_sha1` ASC, `cloud_vendor` ASC, `url` ASC, `file_size` ASC, `file_size_compressed` ASC, `compression_ratio` ASC, `modified` ASC, `created` ASC
		$arrValues = array($cloud_vendor);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrFileLocationsByCloudVendor = array();
		while ($row = $db->fetch()) {
			$file_location_id = $row['id'];
			$fileLocation = self::instantiateOrm($database, 'FileLocation', $row, null, $file_location_id);
			/* @var $fileLocation FileLocation */
			$arrFileLocationsByCloudVendor[$file_location_id] = $fileLocation;
		}

		$db->free_result();

		self::$_arrFileLocationsByCloudVendor = $arrFileLocationsByCloudVendor;

		return $arrFileLocationsByCloudVendor;
	}

	/**
	 * Load by key `file_size` (`file_size`).
	 *
	 * @param string $database
	 * @param string $file_size
	 * @param mixed (Input $options object | null)
	 * @return mixed (single ORM object | false)
	 */
	public static function loadFileLocationsByFileSize($database, $file_size, Input $options=null)
	{
		$forceLoadFlag = false;
		if (isset($options)) {
			$arrOrderByAttributes = $options->arrOrderByAttributes;
			$limit = $options->limit;
			$offset = $options->offset;

			// Avoid cache when using filters and limits
			if (isset($arrOrderByAttributes) || isset($limit) || isset($offset)) {
				$forceLoadFlag = true;
			} else {
				$forceLoadFlag = $options->forceLoadFlag;
			}
		}

		if ($forceLoadFlag) {
			self::$_arrFileLocationsByFileSize = null;
		}

		$arrFileLocationsByFileSize = self::$_arrFileLocationsByFileSize;
		if (isset($arrFileLocationsByFileSize) && !empty($arrFileLocationsByFileSize)) {
			return $arrFileLocationsByFileSize;
		}

		$file_size = (string) $file_size;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `file_sha1` ASC, `cloud_vendor` ASC, `url` ASC, `file_size` ASC, `file_size_compressed` ASC, `compression_ratio` ASC, `modified` ASC, `created` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpFileLocation = new FileLocation($database);
			$sqlOrderByColumns = $tmpFileLocation->constructSqlOrderByColumns($arrOrderByAttributes);

			if (!empty($sqlOrderByColumns)) {
				$sqlOrderBy = "\nORDER BY $sqlOrderByColumns";
			}
		}

		$sqlLimit = '';
		if (isset($limit)) {
			$escapedLimit = $db->escape($limit);
			if (isset($offset)) {
				$escapedOffset = $db->escape($offset);
				$sqlLimit = "\nLIMIT $escapedOffset, $escapedLimit";
			} else {
				$sqlLimit = "\nLIMIT $escapedLimit";
			}
		}

		$query =
"
SELECT
	fl.*

FROM `file_locations` fl
WHERE fl.`file_size` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `file_sha1` ASC, `cloud_vendor` ASC, `url` ASC, `file_size` ASC, `file_size_compressed` ASC, `compression_ratio` ASC, `modified` ASC, `created` ASC
		$arrValues = array($file_size);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrFileLocationsByFileSize = array();
		while ($row = $db->fetch()) {
			$file_location_id = $row['id'];
			$fileLocation = self::instantiateOrm($database, 'FileLocation', $row, null, $file_location_id);
			/* @var $fileLocation FileLocation */
			$arrFileLocationsByFileSize[$file_location_id] = $fileLocation;
		}

		$db->free_result();

		self::$_arrFileLocationsByFileSize = $arrFileLocationsByFileSize;

		return $arrFileLocationsByFileSize;
	}

	/**
	 * Load by key `file_size_compressed` (`file_size_compressed`).
	 *
	 * @param string $database
	 * @param string $file_size_compressed
	 * @param mixed (Input $options object | null)
	 * @return mixed (single ORM object | false)
	 */
	public static function loadFileLocationsByFileSizeCompressed($database, $file_size_compressed, Input $options=null)
	{
		$forceLoadFlag = false;
		if (isset($options)) {
			$arrOrderByAttributes = $options->arrOrderByAttributes;
			$limit = $options->limit;
			$offset = $options->offset;

			// Avoid cache when using filters and limits
			if (isset($arrOrderByAttributes) || isset($limit) || isset($offset)) {
				$forceLoadFlag = true;
			} else {
				$forceLoadFlag = $options->forceLoadFlag;
			}
		}

		if ($forceLoadFlag) {
			self::$_arrFileLocationsByFileSizeCompressed = null;
		}

		$arrFileLocationsByFileSizeCompressed = self::$_arrFileLocationsByFileSizeCompressed;
		if (isset($arrFileLocationsByFileSizeCompressed) && !empty($arrFileLocationsByFileSizeCompressed)) {
			return $arrFileLocationsByFileSizeCompressed;
		}

		$file_size_compressed = (string) $file_size_compressed;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `file_sha1` ASC, `cloud_vendor` ASC, `url` ASC, `file_size` ASC, `file_size_compressed` ASC, `compression_ratio` ASC, `modified` ASC, `created` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpFileLocation = new FileLocation($database);
			$sqlOrderByColumns = $tmpFileLocation->constructSqlOrderByColumns($arrOrderByAttributes);

			if (!empty($sqlOrderByColumns)) {
				$sqlOrderBy = "\nORDER BY $sqlOrderByColumns";
			}
		}

		$sqlLimit = '';
		if (isset($limit)) {
			$escapedLimit = $db->escape($limit);
			if (isset($offset)) {
				$escapedOffset = $db->escape($offset);
				$sqlLimit = "\nLIMIT $escapedOffset, $escapedLimit";
			} else {
				$sqlLimit = "\nLIMIT $escapedLimit";
			}
		}

		$query =
"
SELECT
	fl.*

FROM `file_locations` fl
WHERE fl.`file_size_compressed` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `file_sha1` ASC, `cloud_vendor` ASC, `url` ASC, `file_size` ASC, `file_size_compressed` ASC, `compression_ratio` ASC, `modified` ASC, `created` ASC
		$arrValues = array($file_size_compressed);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrFileLocationsByFileSizeCompressed = array();
		while ($row = $db->fetch()) {
			$file_location_id = $row['id'];
			$fileLocation = self::instantiateOrm($database, 'FileLocation', $row, null, $file_location_id);
			/* @var $fileLocation FileLocation */
			$arrFileLocationsByFileSizeCompressed[$file_location_id] = $fileLocation;
		}

		$db->free_result();

		self::$_arrFileLocationsByFileSizeCompressed = $arrFileLocationsByFileSizeCompressed;

		return $arrFileLocationsByFileSizeCompressed;
	}

	/**
	 * Load by key `compression_ratio` (`compression_ratio`).
	 *
	 * @param string $database
	 * @param string $compression_ratio
	 * @param mixed (Input $options object | null)
	 * @return mixed (single ORM object | false)
	 */
	public static function loadFileLocationsByCompressionRatio($database, $compression_ratio, Input $options=null)
	{
		$forceLoadFlag = false;
		if (isset($options)) {
			$arrOrderByAttributes = $options->arrOrderByAttributes;
			$limit = $options->limit;
			$offset = $options->offset;

			// Avoid cache when using filters and limits
			if (isset($arrOrderByAttributes) || isset($limit) || isset($offset)) {
				$forceLoadFlag = true;
			} else {
				$forceLoadFlag = $options->forceLoadFlag;
			}
		}

		if ($forceLoadFlag) {
			self::$_arrFileLocationsByCompressionRatio = null;
		}

		$arrFileLocationsByCompressionRatio = self::$_arrFileLocationsByCompressionRatio;
		if (isset($arrFileLocationsByCompressionRatio) && !empty($arrFileLocationsByCompressionRatio)) {
			return $arrFileLocationsByCompressionRatio;
		}

		$compression_ratio = (string) $compression_ratio;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `file_sha1` ASC, `cloud_vendor` ASC, `url` ASC, `file_size` ASC, `file_size_compressed` ASC, `compression_ratio` ASC, `modified` ASC, `created` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpFileLocation = new FileLocation($database);
			$sqlOrderByColumns = $tmpFileLocation->constructSqlOrderByColumns($arrOrderByAttributes);

			if (!empty($sqlOrderByColumns)) {
				$sqlOrderBy = "\nORDER BY $sqlOrderByColumns";
			}
		}

		$sqlLimit = '';
		if (isset($limit)) {
			$escapedLimit = $db->escape($limit);
			if (isset($offset)) {
				$escapedOffset = $db->escape($offset);
				$sqlLimit = "\nLIMIT $escapedOffset, $escapedLimit";
			} else {
				$sqlLimit = "\nLIMIT $escapedLimit";
			}
		}

		$query =
"
SELECT
	fl.*

FROM `file_locations` fl
WHERE fl.`compression_ratio` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `file_sha1` ASC, `cloud_vendor` ASC, `url` ASC, `file_size` ASC, `file_size_compressed` ASC, `compression_ratio` ASC, `modified` ASC, `created` ASC
		$arrValues = array($compression_ratio);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrFileLocationsByCompressionRatio = array();
		while ($row = $db->fetch()) {
			$file_location_id = $row['id'];
			$fileLocation = self::instantiateOrm($database, 'FileLocation', $row, null, $file_location_id);
			/* @var $fileLocation FileLocation */
			$arrFileLocationsByCompressionRatio[$file_location_id] = $fileLocation;
		}

		$db->free_result();

		self::$_arrFileLocationsByCompressionRatio = $arrFileLocationsByCompressionRatio;

		return $arrFileLocationsByCompressionRatio;
	}

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all file_locations records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllFileLocations($database, Input $options=null)
	{
		$forceLoadFlag = false;
		if (isset($options)) {
			$arrOrderByAttributes = $options->arrOrderByAttributes;
			$limit = $options->limit;
			$offset = $options->offset;

			// Avoid cache when using filters and limits
			if (isset($arrOrderByAttributes) || isset($limit) || isset($offset)) {
				$forceLoadFlag = true;
			} else {
				$forceLoadFlag = $options->forceLoadFlag;
			}
		}

		if ($forceLoadFlag) {
			self::$_arrAllFileLocations = null;
		}

		$arrAllFileLocations = self::$_arrAllFileLocations;
		if (isset($arrAllFileLocations) && !empty($arrAllFileLocations)) {
			return $arrAllFileLocations;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `file_sha1` ASC, `cloud_vendor` ASC, `url` ASC, `file_size` ASC, `file_size_compressed` ASC, `compression_ratio` ASC, `modified` ASC, `created` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpFileLocation = new FileLocation($database);
			$sqlOrderByColumns = $tmpFileLocation->constructSqlOrderByColumns($arrOrderByAttributes);

			if (!empty($sqlOrderByColumns)) {
				$sqlOrderBy = "\nORDER BY $sqlOrderByColumns";
			}
		}

		$sqlLimit = '';
		if (isset($limit)) {
			$escapedLimit = $db->escape($limit);
			if (isset($offset)) {
				$escapedOffset = $db->escape($offset);
				$sqlLimit = "\nLIMIT $escapedOffset, $escapedLimit";
			} else {
				$sqlLimit = "\nLIMIT $escapedLimit";
			}
		}

		$query =
"
SELECT
	fl.*

FROM `file_locations` fl{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `file_sha1` ASC, `cloud_vendor` ASC, `url` ASC, `file_size` ASC, `file_size_compressed` ASC, `compression_ratio` ASC, `modified` ASC, `created` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllFileLocations = array();
		while ($row = $db->fetch()) {
			$file_location_id = $row['id'];
			$fileLocation = self::instantiateOrm($database, 'FileLocation', $row, null, $file_location_id);
			/* @var $fileLocation FileLocation */
			$arrAllFileLocations[$file_location_id] = $fileLocation;
		}

		$db->free_result();

		self::$_arrAllFileLocations = $arrAllFileLocations;

		return $arrAllFileLocations;
	}

	// Save: insert on duplicate key update
	public function insertOnDuplicateKeyUpdate()
	{
		$database = $this->getDatabase();
		$db = $this->getDb($database);
		/* @var $db DBI_mysqli */

		$query =
"
INSERT
INTO `file_locations`
(`file_sha1`, `cloud_vendor`, `url`, `file_size`, `file_size_compressed`, `compression_ratio`, `modified`, `created`)
VALUES (?, ?, ?, ?, ?, ?, ?, ?)
ON DUPLICATE KEY UPDATE `cloud_vendor` = ?, `url` = ?, `file_size` = ?, `file_size_compressed` = ?, `compression_ratio` = ?, `modified` = ?, `created` = ?
";
		$arrValues = array($this->file_sha1, $this->cloud_vendor, $this->url, $this->file_size, $this->file_size_compressed, $this->compression_ratio, $this->modified, $this->created, $this->cloud_vendor, $this->url, $this->file_size, $this->file_size_compressed, $this->compression_ratio, $this->modified, $this->created);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$file_location_id = $db->insertId;
		$db->free_result();

		return $file_location_id;
	}

	// Save: insert ignore

	public static function saveFileToCloud($database, $fileUploadName, File $file)
	{
		// Get sha1 of the file as a binary string
		$file_sha1 = sha1_file($_FILES[$fileUploadName]['tmp_name']);

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT `id`
FROM `file_locations`
WHERE `file_sha1` = '$file_sha1'
";
		$db->query($query, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row && isset($row['id']) && !empty($row['id'])) {
			$project_file_location_id = $row['id'];
		} else {
			// Save file into the CAS and inert into db
			// Simulate CAS storage using a local file store for now
			/**
			 * @todo ADD CAS FILE STORAGE VIA S3 OR LINODE
			 */
			$pfl = new ProjectFileLocation($database);
			$pfl->file_sha1 = $file_sha1;
			$project_file_location_id = $pfl->save();

			$arrFilePath = $pfl->createFilePathFromId($project_file_location_id);
			$filePath = $arrFilePath['file_path'];
			$fileName = $arrFilePath['file_name'];

			// Will be eventually copying over to cloud vendor here...
			$successFlag = $pfl->moveUploadedFile($file, $filePath, $fileName);
		}

		return $project_file_location_id;
	}

	/**
	 * full_content is saved as a compressed string so restore the
	 * uncompressed full_content back after a save operation.
	 *
	 */
	public function save()
	{
		// Don't write file contents to the database...it chokes after 6GB+
		// not an issue here...
		//$full_content = $this->full_content;
		//unset($this->full_content);
		$id = parent::save();

		// Save file contents to disk
		if (!isset($id)) {
			$id = $this->id;
		}

		return $id;
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
			throw new Exception('Bad file input.');
		}

		$config = Zend_Registry::get('config');
		/* @var $config Config */

		// E.g. "/var/ftp/file_manager_backend/"
		$file_manager_base_path = $config->system->file_manager_base_path;

		// E.g. "backend/data/"
		$file_manager_backend_storage_path = $config->system->file_manager_backend_storage_path;

		// E.g. "_"
		$file_manager_file_name_prefix = $config->system->file_manager_file_name_prefix;

		$arrPath = str_split($id, 2);
		$fileName = array_pop($arrPath);
		$fileName = $file_manager_file_name_prefix.$fileName;
		$path = $file_manager_base_path.$file_manager_backend_storage_path;
		$shortFilePath = '';
		foreach ($arrPath as $pathChunk) {
			$path .= $pathChunk.'/';
			$shortFilePath .= $pathChunk.'/';
		}
		//$path .= $fileName;

		$arrReturn = array(
			'short_file_path' => $shortFilePath,
			'file_path' => $path,
			'file_name' => $fileName,
		);

		return $arrReturn;
	}

	public function moveUploadedFile($file, $filePath, $fileName=false)
	{
		$name = $file->name;
		$tmp_name = $file->tmp_name;
		$finalPath = $filePath.$fileName;

		$fileMovedFlag = move_uploaded_file($tmp_name, $finalPath);

		return $fileMovedFlag;
	}

	public function moveUploadedFile2($fileUploadDirectory, $fileName=false)
	{
		$this->fileUploadDirectory = $fileUploadDirectory;

		$name = $this->name;
		$tmp_name = $this->tmp_name;

		if ($fileName) {
			$this->fileName = $fileName;
			$fileExtension = File::extractFileExtension($fileName);
			$this->fileExtension = $fileExtension;
		} else {
			// derive the fileName value from an MD5 hash of the file binary
			$md5 = md5_file($tmp_name);
			$fileExtension = File::extractFileExtension($name);
			$this->fileExtension = $fileExtension;
			$fileName = $md5.'.'.$fileExtension;
			$this->fileName = $fileName;
		}

		// could add a check to see if the file already exists
		$filePath = $fileUploadDirectory.$fileName;
		$this->filePath = $filePath;
		$filePathExists = is_file($filePath);
		if ($filePathExists) {
			$existingMd5 = md5_file($filePath);
			if ($md5 == $existingMd5) {
				unlink($tmp_name);
				return $filePath;
			}
		}
		if (move_uploaded_file($tmp_name, $filePath)) {
			return $filePath;
		} else {
			return false;
		}
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
				 //"WHERE `url`='http://shop.kingston.com/memtype_parts.asp?type=DIMM%2C3%2C%2C&SUBMIT1=Find'";
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

	//To Delete file location 
	function permanentlyDeleteFileLocation($database,$file_location)
	{
		$db = DBI::getInstance($database);
		$query = "DELETE FROM `file_locations` WHERE `id` = ? ";
		$arrValues = array($file_location);
		if($db->execute($query, $arrValues))
		{
			$config = Zend_Registry::get('config');
			$file_manager_base_path = $config->system->file_manager_base_path;
			$file_manager_backend_storage_path = $config->system->file_manager_backend_storage_path;
			$file_manager_file_name_prefix = $config->system->file_manager_file_name_prefix;

			$arrPath = str_split($file_location, 2);
			$fileName = array_pop($arrPath);
			$fileName = $file_manager_file_name_prefix.$fileName;
			$path = $file_manager_base_path.$file_manager_backend_storage_path;
			$shortFilePath = '';
			foreach ($arrPath as $pathChunk) {
				$path .= $pathChunk.'/';
				$shortFilePath .= $pathChunk.'/';
			}
			$wholepath = $path.$fileName;
			unlink($wholepath);
		}
		$db->free_result();
		return $fileLocation;
	}
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

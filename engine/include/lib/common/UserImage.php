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
 * User details class to encapsulate all of the details of a user
 * excluding authentication information.
 *
 * @category   Framework
 * @package    UserImage
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class UserImage extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'UserImage';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'user_images';

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
	 * unique index `unique_user_image` (`src`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_user_image' => array(
			'src' => 'string'
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
		'id' => 'user_image_id',

		'src' => 'src',

		'width' => 'width',
		'height' => 'height',
		'size' => 'size'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $user_image_id;

	public $src;

	public $width;
	public $height;
	public $size;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties
	public $escaped_src;

	// HTML ENTITY ENCODED NL2BR ORM string properties
	public $escaped_src_nl2br;

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllUserImages;

	// Foreign Key Objects

	/**
	 * Constructor
	 */
	public function __construct($database, $table='user_images')
	{
		parent::__construct($table);
		$this->setDatabase($database);
	}

	// Foreign Key Object Accessor Methods

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllUserImages()
	{
		if (isset(self::$_arrAllUserImages)) {
			return self::$_arrAllUserImages;
		} else {
			return null;
		}
	}

	public static function setArrAllUserImages($arrAllUserImages)
	{
		self::$_arrAllUserImages = $arrAllUserImages;
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
	 * @param int $user_image_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findById($database, $user_image_id,$table='user_images', $module='UserImage')
	{
		$userImage = parent::findById($database, $user_image_id, $table, $module);

		return $userImage;
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Similar to FindById, but with SQL as starter code for more complex joins.
	 *
	 * @param string $database
	 * @param int $user_image_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findUserImageByIdExtended($database, $user_image_id)
	{
		$user_image_id = (int) $user_image_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	uimages.*

FROM `user_images` uimages
WHERE uimages.`id` = ?
";
		$arrValues = array($user_image_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$user_image_id = $row['id'];
			$userImage = self::instantiateOrm($database, 'UserImage', $row, null, $user_image_id);
			/* @var $userImage UserImage */
			$userImage->convertPropertiesToData();

			return $userImage;
		} else {
			return false;
		}
	}

	// Finders: Find By Unique Index
	/**
	 * Find by unique index `unique_user_image` (`src`).
	 *
	 * @param string $database
	 * @param string $src
	 * @return mixed (single ORM object | false)
	 */
	public static function findBySrc($database, $src)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	uimages.*

FROM `user_images` uimages
WHERE uimages.`src` = ?
";
		$arrValues = array($src);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if ($row && !empty($row)) {
			$user_image_id = $row['id'];
			$userImage = self::instantiateOrm($database, 'UserImage', $row, null, $user_image_id);
			/* @var $userImage UserImage */
			return $userImage;
		} else {
			return false;
		}
	}

	// Loaders: Load By pk List (list of auto int ids or other non auto int pk list)
	/**
	 * Load zero or more records by an id list (array of auto int primary keys).
	 *
	 * @param string $database
	 * @param array $arrUserImageIds
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadUserImagesByArrUserImageIds($database, $arrUserImageIds, Input $options=null)
	{
		if (empty($arrUserImageIds)) {
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
		// ORDER BY `id` ASC, `src` ASC, `width` ASC, `height` ASC, `size` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpUserImage = new UserImage($database);
			$sqlOrderByColumns = $tmpUserImage->constructSqlOrderByColumns($arrOrderByAttributes);

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

		foreach ($arrUserImageIds as $k => $user_image_id) {
			$user_image_id = (int) $user_image_id;
			$arrUserImageIds[$k] = $db->escape($user_image_id);
		}
		$csvUserImageIds = join(',', $arrUserImageIds);

		$query =
"
SELECT

	uimages.*

FROM `user_images` uimages
WHERE uimages.`id` IN ($csvUserImageIds){$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		$arrUserImagesByCsvUserImageIds = array();
		while ($row = $db->fetch()) {
			$user_image_id = $row['id'];
			$userImage = self::instantiateOrm($database, 'UserImage', $row, null, $user_image_id);
			/* @var $userImage UserImage */
			$userImage->convertPropertiesToData();

			$arrUserImagesByCsvUserImageIds[$user_image_id] = $userImage;
		}

		$db->free_result();

		return $arrUserImagesByCsvUserImageIds;
	}

	// Loaders: Load By Foreign Key

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all user_images records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllUserImages($database, Input $options=null)
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
			self::$_arrAllUserImages = null;
		}

		$arrAllUserImages = self::$_arrAllUserImages;
		if (isset($arrAllUserImages) && !empty($arrAllUserImages)) {
			return $arrAllUserImages;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `src` ASC, `width` ASC, `height` ASC, `size` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpUserImage = new UserImage($database);
			$sqlOrderByColumns = $tmpUserImage->constructSqlOrderByColumns($arrOrderByAttributes);

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
	uimages.*

FROM `user_images` uimages{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `src` ASC, `width` ASC, `height` ASC, `size` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllUserImages = array();
		while ($row = $db->fetch()) {
			$user_image_id = $row['id'];
			$userImage = self::instantiateOrm($database, 'UserImage', $row, null, $user_image_id);
			/* @var $userImage UserImage */
			$arrAllUserImages[$user_image_id] = $userImage;
		}

		$db->free_result();

		self::$_arrAllUserImages = $arrAllUserImages;

		return $arrAllUserImages;
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
INTO `user_images`
(`src`, `width`, `height`, `size`)
VALUES (?, ?, ?, ?)
ON DUPLICATE KEY UPDATE `width` = ?, `height` = ?, `size` = ?
";
		$arrValues = array($this->src, $this->width, $this->height, $this->size, $this->width, $this->height, $this->size);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$user_image_id = $db->insertId;
		$db->free_result();

		return $user_image_id;
	}

	// Save: insert ignore

	public static function convertFileToUserImage($database, $f)
	{
		//
		$filePath = $f->filePath;
		$fileName = $f->fileName;
		$src = '/images/photos/'.$fileName;
		$width = 0;
		$height = 0;
		$size = 0;
		$ui = new UserImage($database);
		$ui->src = $src;
		$ui->width = $width;
		$ui->height = $height;
		$ui->size = $size;
		$ui->deltifyAndSave();

		return $ui;
	}

	/**
	 * Conditionally invoke the standard save() method after deltification.
	 *
	 */
	public function deltifyAndSave()
	{
		// load existing

		// deltify

		// save (insert, update, or do nothing)

		$newData = $this->getData();
		$key = array('src' => $this->src);

		$database = $this->getDatabase();
		$ui = new UserImage($database);
		$ui->setKey($key);
		$ui->load();

		/**
		 * Conditionally Insert/Update the record.
		 *
		 * $key is conditionally set based on if record exists.
		 */

		//Iterate over latest input from data feed and only set different values.
		//Same values will be key unset to acheive a conditional update.
		$save = false;
		$existsFlag = $ui->isDataLoaded();
		if ($existsFlag) {
			$id = $ui->id;
			$this->setId($id);

			//Conditionally Update the record
			//Don't compare the key values that loaded the record.
			unset($ui->id);

			$existingData = $ui->getData();

			//debug
			/*
			$keyDiffFlag = Data::diffKeys($existingData, $newData);
			if (!$keyDiffFlag) {
				echo "Key:\n".print_r($key, true)."\n\n\n\n";
				echo 'Existing:'."\n";
				ksort($existingData);
				print_r($existingData);
				echo 'New:'."\n";
				ksort($newData);
				print_r($newData);
				$n = array_keys($newData);
				$e = array_keys($existingData);
				$_1 = array_diff_key($n, $e);
				echo 'New:'."\n";
				print_r($_1);
				$_2 = array_diff_key($e, $n);
				echo 'Old:'."\n";
				print_r($_2);
				throw new Exception('Keys mismatch');
			}
			*/

			$data = Data::deltify($existingData, $newData);
			if (!empty($data)) {
				$ui->setData($data);
				$save = true;
			} else {
				return;
			}
		} else {
			//Insert the record
			$ui->setKey(null);
			$ui->setData($newData);
			//Add value for created timestamp.
			//$ui->created = null;
			$save = true;
		}

		//Save if needed (conditionally Insert/Update)
		if ($save) {
			$id = $ui->save();

			if (isset($id)) {
				$this->setId($id);
			}
		}

		return;
	}
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

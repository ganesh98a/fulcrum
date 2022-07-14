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
 * Ancestor super class for all MVC Model classes: ORM, Active_Record,
 * Mapper, IntegratedMapper, etc.
 *
 * @category   MVC/Model
 * @package    Model
 *
 * @see        AbstractWebToolkit
 *
 */

/**
 * AbstractWebToolkit
 */
//Already Included...commented out for performance gain
//require_once('lib/common/AbstractWebToolkit.php');

/**
 * DBI
 */
//Already Included...commented out for performance gain
//require_once('lib/common/DBI.php');

class Model extends AbstractWebToolkit
{
	// 0 is okay, 2 is data already saved on server
	const ERROR_NO_ERROR = 0;

	// 1 is database error occurred, rollback
	const ERROR_DATA_NOT_SAVED = 1;

	// 2 is data already saved on server
	const ERROR_DUPLICATE_DATA = 2;

	// 3 is data does not exist on server
	const ERROR_DATA_DOES_NOT_EXIST = 3;

	// 4 is data cannot be deleted
	const ERROR_DATA_CANNOT_BE_DELETED_DUE_TO_FK = 4;

	/**
	 * Database object reference.
	 *
	 * @var object
	 */
	protected $_db;

	/**
	 * Cache object reference.
	 *
	 * @var object
	 */
	protected $_cache;

	/**
	 * $_autoCommit is a flag that determines if commmit is called after
	 * insert, update and delete operations.
	 *
	 * autocommit can be used as opposed to BEGIN/COMMIT/ROLLBACK
	 *
	 * @var boolean
	 */
	protected $_autoCommit = false;

	/**
	 * The name of the database the ORM object is using.
	 *
	 * @var string
	 */
	protected $_database = 'default';

	/**
	 * The name of the table prefix the ORM object encapsulates.
	 *
	 * @var string
	 */
	protected $_tablePrefix = '';

	/**
	 * The name of the table the ORM object encapsulates.
	 *
	 * Each ORM object encapsulates a set of one or more rows.
	 */
	protected $_table;

	/**
	 * Singular version of the table name that the ORM object encapsulates.
	 *
	 * Each ORM object encapsulates a set of one or more rows.
	 */
	protected $_tableNameSingular;

	/**
	 * The id of the record the ORM object encapsulates.
	 *
	 * Each ORM object encapsulates a set of one or more rows.
	 * This is useful for the single row case.
	 */
	protected $_id;

	/**
	 * Attributes that make up the primary key (may be one or more attributes).
	 *
	 * @var array
	 */
	protected $_arrPrimaryKey;

	/**
	 * Attributes that make up a candidate key (unique index), if any.
	 *
	 * @var array
	 */
	protected $_arrUniqueness;

	/**
	 * Attributes that are required for the "Create" pattern or database INSERT.
	 *
	 * @var array
	 */
	protected $arrRequiredAttributes;

	/**
	 * Format object reference.
	 *
	 * @var object
	 */
	protected $_format;

	/**
	 * Image object reference.
	 *
	 * @var object
	 */
	protected $_image;

	/**
	 * Alias for getData().
	 */
	public function getAttributes()
	{
		$attributes = $this->getData();
		return $attributes;
	}

	/**
	 * Alias for setData().
	 *
	 * @param array $input
	 */
	public function setAttributes($input=null)
	{
		$this->setData($input);
	}

	/**
	 * Returns a list of array keys from the $_data array.
	 * For an ORM class this corresponds to the database attribute names.
	 *
	 * @return array
	 */
	public function getAttributeKeys()
	{
		if (isset($this->_data) && is_array($this->_data) && !empty($this->_data)) {
			$attributeNames = array_keys($this->_data);
		} else {
			$attributeNames = array();
		}
		return $attributeNames;
	}

	/**
	 * Populate the $_data array with a set of keys that have null values.
	 * Use array_fill_keys() once we go with PHP >= 5.2.0
	 *
	 * @param array $attributeNames
	 */
	public function setAttributeKeys($names)
	{
		if (isset($names) && !empty($names) && is_array($names)) {
			foreach ($names as $name) {
				$this->_data[$name] = null;
			}
		} else {
			$msg = __METHOD__.' - Missing or invalid param $names';
			throw new Exception($msg);
		}
	}

	/**
	 * Return the name of the current database.
	 *
	 * $_database holds the name of that database.
	 *
	 * @return string
	 */
	public function getDatabase()
	{
		if (isset($this->_database)) {
			return $this->_database;
		} else {
			return null;
		}
	}

	/**
	 * Set the database to use.
	 *
	 * @param string $db
	 */
	public function setDatabase($db)
	{
		$this->_database = $db;
	}

	/**
	 * Return the name of the current table.
	 *
	 * An ORM object instance corresponds to a table.
	 * $_table holds the name of that table.
	 *
	 * @return mixed
	 */
	public function getTable()
	{
		if (isset($this->_table)) {
			return $this->_table;
		} else {
			return null;
		}
	}

	/**
	 * Set the name of the current table.
	 *
	 * An ORM object instance corresponds to a table.
	 * $_table holds the name of that table.
	 */
	public function setTable($table)
	{
		if (isset($table) && is_string($table)) {
			$this->_table = $table;
		} else {
			$msg = __METHOD__.' - Missing or invalid param $table';
			throw new Exception($msg);
		}
	}

	/**
	 * Return the singular name of the current table.
	 *
	 * singular_table_name_id is the FK naming convention.
	 *
	 * @return mixed
	 */
	public function getTableNameSingular()
	{
		if (isset($this->_tableNameSingular)) {
			return $this->_tableNameSingular;
		} else {
			return null;
		}
	}

	/**
	 * Set the singular name of the current table.
	 *
	 * singular_table_name_id is the FK naming convention.
	 */
	public function setTableNameSingular($tableNameSingular)
	{
		if (isset($tableNameSingular) && is_string($tableNameSingular)) {
			$this->_tableNameSingular = $tableNameSingular;
		} else {
			$msg = __METHOD__.' - Missing or invalid param $tableNameSingular';
			throw new Exception($msg);
		}
	}

	/**
	 * Return the value of the current id.
	 *
	 * An ORM object instance may correspond to a single record.
	 * $_id holds the value of that records primary key (id).
	 *
	 * @return int
	 */
	public function getId()
	{
		if (isset($this->_id)) {
			return $this->_id;
		} else {
			return null;
		}
	}

	/**
	 * Set the value of the current id.
	 *
	 * An ORM object instance may correspond to a single record.
	 * $_id holds the value of that records primary key (id).
	 */
	public function setId($id)
	{
		if (isset($id) && !empty($id)) {
			$this->_id = $id;
		} else {
			$msg = __METHOD__.' - Missing or invalid param $id';
			throw new Exception($msg);
		}
	}

	/**
	 * $key is an array of key value pairs, one pair per column in the key
	 *
	 * The key may or may not contain more than one column.
	 *
	 */
	public function getKey()
	{
		if (isset($this->_key)) {
			return $this->_key;
		} else {
			return null;
		}
	}

	/**
	 * $key must always be passed in as an array of key/value pairs.
	 *
	 * The keys are column names that make up a unique key for a record.
	 * Multiple key/value pairs are for composite keys.
	 * $key can be null to "unset" the key.
	 *
	 */
	public function setKey($key)
	{
		$this->_key = $key;
	}

	/**
	 *
	 */
	public function getArrPrimaryKey()
	{
		if (isset($this->_arrPrimaryKey)) {
			return $this->_arrPrimaryKey;
		} else {
			return null;
		}
	}

	/**
	 *
	 */
	public function setArrPrimaryKey($arrPrimaryKey)
	{
		if (isset($arrPrimaryKey) && !empty($arrPrimaryKey) && is_array($arrPrimaryKey)) {
			$this->_arrPrimaryKey = $arrPrimaryKey;
		} else {
			$msg = __METHOD__.' - Missing or invalid param $arrPrimaryKey';
			throw new Exception($msg);
		}
	}

	/**
	 *
	 */
	public function getArrUniqueness()
	{
		if (isset($this->_arrUniqueness)) {
			return $this->_arrUniqueness;
		} else {
			return null;
		}
	}

	/**
	 *
	 */
	public function setArrUniqueness($arrUniqueness)
	{
		if (isset($arrUniqueness) && !empty($arrUniqueness) && is_array($arrUniqueness)) {
			$this->_arrUniqueness = $arrUniqueness;
		} else {
			$msg = __METHOD__.' - Missing or invalid param $arrUniqueness';
			throw new Exception($msg);
		}
	}

	/**
	 * A database record may require certain attributes for INSERTion to succeed.
	 */
	public function getRequiredAttributes()
	{
		return $this->arrRequiredAttributes;
	}

	/**
	 * Metadata mapper pattern maps db attributes to object properties.
	 */
	public function setRequiredAttributes($arrRequiredAttributes)
	{
		$this->arrRequiredAttributes = $arrRequiredAttributes;
	}

	public function deriveKey($uniqueIndexLabel=null)
	{
		// GUIDs/ID, etc.
		// unique index comes from $arrUniqueness
		if (isset($uniqueIndexLabel)) {
			if (isset($this->_arrUniqueness[$uniqueIndexLabel])) {
				$arrUniqueness = $this->_arrUniqueness[$uniqueIndexLabel];
			} else {
				$tmpArrUniqueness = $this->_arrUniqueness;

				// Deal with legacy code here...
				$tmpArrKeys = array_keys($tmpArrUniqueness);
				$tmpFirstKey = array_shift($tmpArrKeys);
				if (is_array($tmpArrUniqueness[$tmpFirstKey])) {
					$arrUniqueness = array_shift($tmpArrUniqueness);
				} else {
					$arrUniqueness = $this->_arrUniqueness;
				}
			}
		} else {
			$tmpArrUniqueness = $this->_arrUniqueness;

			// Deal with legacy code here...
			/*
			// Debug
			if (!is_array($tmpArrUniqueness)) {
				$x = 1;
			}
			*/
			if(is_array($tmpArrUniqueness)){
			$tmpArrKeys = array_keys($tmpArrUniqueness);
			$tmpFirstKey = array_shift($tmpArrKeys);
			if (is_array($tmpArrUniqueness[$tmpFirstKey])) {
				$arrUniqueness = array_shift($tmpArrUniqueness);
			} else {
				$arrUniqueness = $this->_arrUniqueness;
			}
			}
		}
 		$id = $this->_id;
		$data = $this->getData();

		$key = array();
		if (!empty($arrUniqueness)) {
			foreach ($arrUniqueness as $attribute => $attributeType) {
				if (!isset($data[$attribute])) {
					$key = array();
					break;
				}

				// Debugging convenience
				$attributeValue = $data[$attribute];

				switch ($attributeType) {
					case 'int':
					case 'integer':
						$key[$attribute] = (int) $attributeValue;
						break;

					case 'string':
					default:
						$key[$attribute] = (string) $attributeValue;
						break;
				}
			}
		}

		if (empty($key) && !empty($id)) {
			$key = array('id' => $id);
		}

		return $key;
	}

	public function getAutoCommit()
	{
		if (isset($this->_autoCommit)) {
			return $this->_autoCommit;
		} else {
			return null;
		}
	}

	public function setAutoCommit($boolean)
	{
		if (isset($boolean)) {
			$this->_autoCommit = $boolean;
		} else {
			$msg = __METHOD__.' - Missing or invalid param $boolean.';
			throw new Exception($msg);
		}
	}

	/**
	 * Obtain a handle to the database abstraction class
	 *
	 * If the $db param is input, then the handle will be for that given database.
	 * Any successive call with the $db param set will make a new call to ensure a handle is
	 * retrieved for the given database.
	 *
	 * Any successive call without the $db param set will return the previously set handle.
	 *
	 */
	public function getDb($database = null)
	{
		if (!isset($this->_db)) {
			//Already Included...commented out for performance gain
			//require_once('lib/common/DBI.php');
			if (!isset($database)) {
				$database = $this->_database;
			}
			$this->_db = DBI::getInstance($database);
			/* @var $this->_db DBI_mysqli */

//			require_once('lib/common/Db.php');
//			$this->_db = Db::getInstance($db);

			return $this->_db;
		}

		if (isset($this->_db) && empty($database)) {
			return $this->_db;
		} elseif (isset($this->_db) && !empty($database)) {
			$this->_db = DBI::getInstance($database);
			return $this->_db;
		} else {
			throw new Exception('Record::getDb() fatal error getting reference to Db $instance data');
		}
	}

	/**
	 * Set the database access object handle.
	 *
	 * This method allows an existing instance of the database access handle to be used.
	 * $db should be an object reference to a Database abstraction class.
	 * Set or update the database access handle for the given $db
	 * This method is mainly to get a new database handle for a different database.
	 *
	 * @param (obj) $db
	 *
	 */
	public function setDb($db)
	{
		if (isset($db) && is_object($db)) {
			$this->_db = $db;
		} else {
			$msg = __METHOD__.' - Missing or invalid param $db.';
			throw new Exception($msg);
		}
	}

	/**
	 * Obtain a handle to a Format object.
	 *
	 * @return object handle
	 */
	public function getFormat()
	{
		if (!isset($this->_format)) {
			require_once('lib/common/Format.php');
			$this->_format = new Format();
		}

		return $this->_format;
	}

	/**
	 * Obtain a handle to an Image object.
	 *
	 * @return object handle
	 */
	public function getImage()
	{
		if (!isset($this->_image)) {
			require_once('lib/common/Image.php');
			$this->_image = new Image();
		}

		return $this->_image;
	}
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

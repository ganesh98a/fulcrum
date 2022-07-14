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
 * Generic record container for oop interface to any db record.
 *
 * Generic Container/Ancestor class for OR Mappers
 * Each Record object is an instance of a database record for any given table.
 * This class is the ancestor for all other mapper classes and provides the base api
 * one level above the direct database access class.
 * All tables for a given project should have a common table prefix, e.g. 'tbl_'
 *
 * @category   MVC/Model (Database Abstraction Layer)
 * @package    IntegratedMapper
 *
 * @see        DBI.php
 *
 */

//require_once('includes/classes/Exceptions.php');

/**
 * Data
 */
//Already Included...commented out for performance gain
//require_once('lib/common/Data.php');

/**
 * Model
 */
//Already Included...commented out for performance gain
//require_once('lib/common/Model.php');

/**
 * @see IntegratedMapper_Interface
 */
require_once('lib/common/IntegratedMapper/Interface.php');

class IntegratedMapper extends Model implements IntegratedMapper_Interface
{
	/**
	 * A collection of records; an array of Record child objects.
	 *
	 * An itelligent approach is to use a sort order as the key.
	 */
	protected $_records;

	/**
	 * The $key can be the primary key or any other candidate key for a given record.
	 *
	 * $key is always an array of key/value arrays (key is column name, value is column value)
	 * $key may be single column or multi-column (concatenated key).
	 * In the case of a single column key the $key variable will be an integer datatype.
	 * In the case of a concatenated key the $key variable will be an array datatype
	 */
	protected $_key = null;

	/**
	 * SQL Where clause key value pairs or complete string.
	 *
	 * Don't put the "WHERE" statement within this string.
	 * May be a string or an array.
	 * When an array simply converted to AND key = value.
	 * Use string form for anything else, IN(), etc.
	 *
	 * @var mixed
	 */
	protected $_condition = null;

	protected $_htmlEntityPropertiesEscapedFlag = false;

	/**
	 * Create an object interface to a record for any table.
	 *
	 * $attributeNames is a list of columns to load from the table row.
	 *
	 * Constructor
	 * Output: None
	 * Action: SELECT on primary key or on condition.
	 *
	 * @param string $table
	 * @param array $key
	 * @param array $attributeNames
	 * @param string $condition
	 * @param bool $load
	 */
	public function __construct ($table, $key=null, $attributeNames=null, $cond=null, $load=false)
	{
		if (isset($table) && !empty($table) && is_string($table)) {
			$this->setTable($table);
		} else {
			$msg = __METHOD__.' - Missing or invalid param $table';
			throw new Exception($msg);
		}
		if (isset($key) && !empty($key) && is_array($key)) {
			$this->setKey($key);
		}
		if (isset($attributeNames) && !empty($attributeNames) && is_array($attributeNames)) {
			$this->setAttributeNames($attributeNames);
		}
		if (isset($cond) && !empty($cond)) {
			$this->setCondition($cond);
		}
		if ($load && ((isset($key) && !empty($key)) || (isset($cond) && !empty($cond)))) {
			$this->load();
		}
	}

	public function getHtmlEntityPropertiesEscapedFlag()
	{
		return (bool) $this->_htmlEntityPropertiesEscapedFlag;
	}

	/**
	 * $condition is either a string or an array.
	 *
	 * @return mixed
	 */
	public function getCondition()
	{
		if (isset($this->_condition)) {
			return $this->_condition;
		} else {
			return null;
		}
	}

	public function setCondition($condition)
	{
		if (isset($condition)) {
			$this->_condition = $condition;
		} else {
			$msg = __METHOD__.' - Missing or invalid param $condition';
			throw new Exception($msg);
		}
	}

	public function constructQuery($operation, $condition)
	{
		return $query;
	}

	/**
	 * Back up attributes to $_dataHistory
	 * Store attributes in their raw format (exactly as they were in attributes array)
	 * 		-> this is acceived by bypassing call to getAttribute()
	 *
	 */
	public function archiveData()
	{
		if (!empty($this->_data)) {
			$tmp = array();
			while (list($k, $v) = each($this->_data)) {
				$tmp[$k] = $v;
			}
			/**
			 * _dataHistory is a stack with one array per archived "attribute list"
			 *
			 */
			$this->_dataHistory[] = $tmp;
		}
	}

	/**
	 * Load a result set from the archive.
	 *
	 * Input: Primary Key
	 * Output: None
	 * Action: Loads result set for one record into memory (protected attribute $attributes)
	 *
	 */
	public function loadDataFromArchive($key)
	{
		if (isset($key) && isset($this->_dataHistory[$key])) {
			$tmp = $this->_dataHistory[$key];
			$this->_data = array();
			foreach ($tmp as $k => $v) {
				$this->_data[$k] = $v;
			}
		} elseif (!empty($this->_dataHistory)) {
			$tmp = array_pop($this->_dataHistory);
			foreach ($tmp as $k => $v) {
				$this->_data[$k] = $v;
			}
		}
	}

	/**
	 *
	 * Retrieve the next available recid (primary key)
	 *
	 * Output: Returns the next available primary key for the given table
	 * @return int next_id
	 *
	 */
	public function getNextRecid()
	{
		$query = 'SELECT (max(recid)+1) as next_id '.
		         '  FROM ' . $this->_tablePrefix . $this->_table;
		$result = $this->getDb()->fetch($query);
		if (empty($result)) {
			$msg = __METHOD__.' - Problem with query accessing table.';
			throw new Exception($msg);
		} else {
			return $result[0]['next_id'];
		}
	}

	/**
	 * Reset the given Record object
	 *
	 * Current state of "active" record object is saved in the archive
	 *
	 */
	public function reset()
	{
		/**
		 * Back up attributes to $_dataHistory
		 * Reset all vars to their default state
		 */
		//$this->archiveData();
		$this->_data = array();
		$this->_dataLoadedFlag = false;
	}

	/**
	 * Free memory.
	 *
	 */
	public function freeMemory()
	{
		$db = $this->getDb();
		/* @var $db DBI_mysqli */
		$db->free_result();
		$db->reset();
	}

	/**
	 * Construct a where clause from a key or a condition or both.
	 *
	 * @param mixed $key
	 * @param mixed $condition
	 */
	public function constructWhere($key=null, $condition=null)
	{
		/**
		 * Construct "WHERE" clause.
		 */
		$where = '';
		$arrValues = array();

		/**
		 * key is always an array of key/value pairs of at least size 1.
		 *
		 * Composite keys may require the AND statement.
		 */
		if (isset($key) && !empty($key) && is_array($key)) {
			$first = true;
			while (list($k, $v) = each($key)) {
				if ($first) {
					$where = 'WHERE `'.$k.'`=?';
					$first = false;
					$arrValues[] = $v;
				} else {
					$where .= ' AND `'.$k.'`=?';
					$arrValues[] = $v;
				}
			}
		}

		/**
		 * May have a key and an additional condition.
		 */
		if (!empty($where) && !empty($condition)) {
			if (is_string($condition)) {
				$where .= ' AND '.$condition;
			} elseif (is_array($condition)) {
				foreach ($condition as $k => $v) {
					$where .= ' AND '.$k.'=?';
					$arrValues[] = $v;
				}
			}
		} elseif (!empty($condition)) {
			if (is_string($condition)) {
				$where = 'WHERE '.$condition;
			} elseif (is_array($condition)) {
				$first = true;
				while (list($k, $v) = each($condition)) {
					if ($first) {
						$where = 'WHERE '.$k.'=?';
						$first = false;
						$arrValues[] = $v;
					} else {
						$where .= ' AND '.$k.'=?';
						$arrValues[] = $v;
					}
				}
			}
		}

		$arrReturn = array($where, $arrValues);
		return $arrReturn;
	}

	public function constructSqlOrderByColumns($arrOrderByAttributes)
	{
		// Security check - possibly make this a separate method
		//$arrAttributesMap = $this->getArrAttributesMap();
		//$arrDiff = array_diff_key($arrOrderByAttributes , $arrAttributesMap);

		// An empty result means no rogue attributes passed in for order by
		// An empty result means that all attributes passed in for sorting are part of the standard attributes list
		// This can be commented out for more complex queries
		//if (empty($arrDiff)) {

			$arrOrderBy = array();
			foreach ($arrOrderByAttributes as $attribute => $sortOrdering) {
				if (!is_int(strpos($attribute, '`')) && !is_int(strpos($attribute, '.'))) {
					$attribute = "`$attribute`";
				}
				$sortOrdering = strtoupper($sortOrdering);
				if ($sortOrdering <> 'DESC') {
					$sortOrdering = 'ASC';
				}
				$arrOrderBy[] = "$attribute $sortOrdering";
			}

			$sqlOrderByColumns = join(', ', $arrOrderBy);

		//} else {

			//$sqlOrderByColumns = '';

		//}

		return $sqlOrderByColumns;
	}

	/**
	 * Active record "SELECT count(*)" operation.  SELECT on key and/or condition.
	 *
	 * Load a complete or partial set of attributes for a given database record based on a "key".
	 * The unique identifier (key) may be a single attribute or an attribute list
	 * (composite key case).  Composite keys are multi-column and are called concatenated keys.
	 * The table name and key must be previously set, or an exception will be thrown.
	 *
	 * Load a complete or partial set of attributes for a
	 * set of database records based on a condition.
	 *
	 * If no condition, then will attempt to load all records from the table.
	 *
	 * $attributeNames is a list of attribute names for which to SELECT on.
	 *
	 */
	public function count()
	{
		$table = $this->getTable();
		$key = $this->getKey();
		$attributeNames = array('count(*)');
		$condition = $this->getCondition();
		$this->sqlSelect($this->_table, $this->_key, $attributeNames, $this->_condition, true);
	}

	/**
	 * Active record "SELECT" operation.  SELECT on key and/or condition.
	 *
	 * Load a complete or partial set of attributes for a given database record based on a "key".
	 * The unique identifier (key) may be a single attribute or an attribute list
	 * (composite key case).  Composite keys are multi-column and are called concatenated keys.
	 * The table name and key must be previously set, or an exception will be thrown.
	 *
	 * Load a complete or partial set of attributes for a
	 * set of database records based on a condition.
	 *
	 * If no condition, then will attempt to load all records from the table.
	 *
	 * $attributeNames is a list of attribute names for which to SELECT on.
	 *
	 */
	public function load()
	{
		$table = $this->getTable();
		$key = $this->getKey();
		$attributeNames = $this->getAttributeKeys();
		$condition = $this->getCondition();
		$this->sqlSelect($this->_table, $this->_key, $attributeNames, $this->_condition);
	}

	/**
	 * INSERT or UPDATE a record as needed to save state.
	 *
	 * The attributes and table name may be passed in directly or previously set.
	 *
	 * @throws Exception
	 *
	 */
	public function save()
	{
		if (isset($this->_key)) {
			$this->sqlUpdate($this->_table, $this->_data, $this->_key, $this->_condition);
			return null;
		} else {
			$id = $this->sqlInsert($this->_table, $this->_data);
			return $id;
		}
	}

	/**
	 * DELETE a record w/in any table
	 *
	 * The data manipulation language (DML) DELETE operator requires a table name
	 * and a primary key for the record to be deleted.
	 * The primary key may be atomic or composite.
	 *
	 * If no key or condition is provided then the whole table will be deleted.
	 * -> Truncated for faster delete.
	 *
	 * @throws Exception
	 *
	 */
	public function delete()
	{
		$table = $this->getTable();
		$key = $this->getKey();
		$condition = $this->getCondition();

		$this->sqlDelete($table, $key, $condition);
	}

	public function trimOrNullify()
	{
		$data = $this->getData();
		$data = Data::trimOrNullifyValues($data);
		$this->setData($data);
	}

	/**
	 * Active record "SELECT" operation.  Perform SELECT on primary key or condition.
	 *
	 * Load a complete or partial set of attributes for a given database record based on a "key".
	 * The unique identifier (key) may be a single attribute or an attribute list
	 * (composite key case).  Composite keys are multi-column and are called concatenated keys.
	 * The table name and key must be previously set or passed in to this method,
	 * or an exception will be thrown.
	 *
	 * Load an arbitrary collection of records based on a condition.
	 *
	 * If no condition or key, then will attempt to load all records from the table.
	 *
	 * $attributeNames is a list of attribute names for which to SELECT on
	 * thus retrieving the attribute values.
	 *
	 * @param array $key (key of record)
	 * @param array $attributes (names of table attributes)
	 * @param mixed $condition (WHERE clause)
	 *
	 */
	protected function sqlSelect($table, $key=null, $attributes=null, $condition='', $countQuery=false)
	{
		if (!isset($table)) {
			$msg = __METHOD__.' - Missing or invalid param $table';
			throw new Exception($msg);
		}

		/**
		 * Perform SELECT operation.
		 *
		 * Build the "SELECT" statement based on $attributes, or select all attributes.
		 *
		 */
		$arrValues = array();
		if ($countQuery) {
			$select = 'SELECT count(*)';
		} else {
			if (isset($attributes) && is_array($attributes) && !empty($attributes)) {
				$first = true;
				foreach ($attributes as $attribute) {
					if ($first) {
						$select = 'SELECT `'.$attribute.'` ';
						$first = false;
					} else {
						$select .= ', `'.$attribute.'` ';
					}
				}
				unset($attribute);
				unset($first);
			} else {
				$select = 'SELECT *';
			}
		}
		unset($attributes);

		/**
		 * Construct "WHERE" clause.
		 */
		if (isset($key) || isset($condition)) {
			$arrWhere = $this->constructWhere($key, $condition);
			$where = $arrWhere[0];
			$arrWhereValues = $arrWhere[1];
			unset($arrWhere);
		} else {
			$where = '';
			$arrWhereValues = array();
		}
		unset($key);
		unset($condition);

//		$query = $this->constructQuery();
		$query = $select.' FROM `'.$table.'` '.$where;
		unset($select);
		unset($table);
		unset($where);

		$arrValues = array_merge($arrValues, $arrWhereValues);
		unset($arrWhereValues);

		$db = $this->getDb();
		/* @var $db DBI_mysqli */
		// @todo Potentially go to MYSQLI_USE_RESULT as the default
		$db->execute($query, $arrValues);
		unset($query);
		unset($arrValues);
		$arrResult = array();
		while ($row = $db->fetch()) {
			$arrResult[] = $row;
		}
		unset($row);
//		$this->freeMemory();
		$db->free_result();
		//Don't do this so can have record counts, etc.
		//$db->reset();
		unset($db);

		if (!empty($arrResult)) {
			// Set the data directly for single value case.
			// Allows single or multiple records to be stored in $data array.
			if (count($arrResult) == 1) {
				$arrResult = array_pop($arrResult);
			}
			$this->_dataLoadedFlag = true;
			$this->setData($arrResult);
			unset($arrResult);
//			$this->setAttributes($result);
//			foreach ($result as $recordAttributes) {
//				while (list($k, $v) = each($recordAttributes)) {
//					$this->$k = $v;
//				}
//			}
		} else {
			$this->_dataLoadedFlag = false;
		}
	}

	/**
	 * Insert a record into any table
	 *
	 * The attributes and table name may be passed in directly or previously set.
	 *
	 * @param string $table
	 * @param array $attributes
	 *
	 * @throws Exception
	 *
	 */
	protected function sqlInsert($table, $attributes)
	{
		if (!isset($table)) {
			$msg = __METHOD__.' - Missing or invalid param $table';
			throw new Exception($msg);
		}
		if (!isset($attributes)) {
			$msg = __METHOD__.' - Missing or invalid param $attributes';
			throw new Exception($msg);
		}
		if (isset($this->_key)) {
			$msg = __METHOD__.' - $_key is already set. Update instead.';
			throw new Exception($msg);
		}

		/**
		 * Perform INSERT operation for the given record.
		 * Only insert the specified attributes.
		 *
		 * Build the "INSERT" statement based on $attributes.
		 *
		 * This allows for easy cloning.
		 * Our ORM object should always have the latest correct values.
		 */
		$insert = 'INSERT INTO `'.$table.'` (';
		$values = 'VALUES (';
		$first = true;
		$arrValues = array();
		foreach ($attributes as $k => $v) {
			if ($first) {
				$insert .= "`$k`";
				$values .= '?';
				$arrValues[] = $v;
				$first = false;
			} else {
				$insert .= ', '."`$k`";
				$values .= ', ?';
				$arrValues[] = $v;
			}
		}
		$insert .= ') ';
		$values .= ')';

		$query = $insert.$values;

		$db = $this->getDb();
		/* @var $db DBI_mysqli */

		// This will force commit the query even if MYSQL has AUTOCOMMIT = 0 by wrapping
		// it in the below transaction sequence.
		if ($this->_autoCommit === true) {
			$db->begin();
		}

		// The below query will commit by default if MYSQL has AUTOCOMMIT = 1
		// and this query is not wrapped inside of a BEGIN...COMMIT transaction sequence.
		// mysql> SHOW VARIABLES LIKE 'AUTOCOMMIT';
		$result = $db->execute($query, $arrValues);

		if ($this->_autoCommit === true) {
			$db->commit();
		}

		$id = $db->insertId;

		$db->free_result();
		$db->reset();
		unset($db);

		return $id;
	}

	/**
	 * Update a record or set of records w/in any table.
	 *
	 * @param string $table
	 * @param array $attributes
	 * @param array $key
	 * @param mixed $condition
	 *
	 * @throws Exception
	 *
	 */
	protected function sqlUpdate($table, $attributes, $key=null, $condition=null)
	{
		/**
		 * Check input and verify required fields are present to perform the operation.
		 *
		 * Only update the specified attributes.  The previous values remain intact.
		 * Our Record object should always have the latest correct values.
		 * Throw exception if missing reqd. attributes.
		 *
		 */
		if (!isset($table)) {
			$msg = __METHOD__.' - Missing or invalid param $table';
			throw new Exception($msg);
		}
		if (!isset($attributes)) {
			$msg = __METHOD__.' - Missing or invalid param $attributes';
			throw new Exception($msg);
		}

		/**
		 * Build the "UPDATE" statement based on $attributes.
		 *
		 */
		$update = 'UPDATE `'.$table.'`';
		unset($table);
		$arrValues = array();
		if (isset($attributes) && is_array($attributes) && !empty($attributes)) {
			$values = array();
			$first = true;
			foreach ($attributes as $k => $v) {
				if ($first) {
					$update .= ' SET `'.$k.'`=?';
					$arrValues[] = $v;
					$first = false;
				} else {
					$update .= ', `'.$k.'`=?';
					$arrValues[] = $v;
				}
			}
		}

		/**
		 * Construct "WHERE" clause.
		 */
		if (isset($key) || isset($condition)) {
			$arrWhere = $this->constructWhere($key, $condition);
			unset($key);
			unset($condition);
			$where = $arrWhere[0];
			$arrWhereValues = $arrWhere[1];
			unset($arrWhere);
		} else {
			$where = '';
			$arrWhereValues = array();
		}

		$query = $update.' '.$where;
		unset($update);
		unset($where);

		$arrValues = array_merge($arrValues, $arrWhereValues);
		unset($arrWhereValues);

		$db = $this->getDb();
		/* @var $db DBI_mysqli */

		// This will force commit the query even if MYSQL has AUTOCOMMIT = 0 by wrapping
		// it in the below transaction sequence.
		if ($this->_autoCommit === true) {
			$db->begin();
		}

		// The below query will commit by default if MYSQL has AUTOCOMMIT = 1
		// and this query is not wrapped inside of a BEGIN...COMMIT transaction sequence.
		// mysql> SHOW VARIABLES LIKE 'AUTOCOMMIT';
		$result = $db->execute($query, $arrValues);

		if ($this->_autoCommit === true) {
			$db->commit();
		}

		// This may work if the update is using an auto increment field...need to test
		//$id = $db->insertId;

		$db->free_result();
		$db->reset();
		unset($db);
	}

	/**
	 * Delete a record w/in any table
	 *
	 * The data manipulation language (DML) DELETE operator requires a table name
	 * and a primary key for the record to be deleted.
	 * The primary key may be atomic or composite.
	 *
	 * @param string $table
	 * @param array $attributes ($attributes
	 *
	 * @throws Exception
	 *
	 */
	protected function sqlDelete($table, $key=null, $condition=null)
	{
		if (!isset($table)) {
			$msg = __METHOD__.' - Missing or invalid param $table';
			throw new Exception($msg);
		}

		/**
		 * Construct "WHERE" clause.
		 */
		if (isset($key) || isset($condition)) {
			$arrWhere = $this->constructWhere($key, $condition);
			unset($key);
			unset($condition);
			$where = $arrWhere[0];
			$arrValues = $arrWhere[1];
			unset($arrWhere);
		} else {
			$where = '';
			$arrValues = array();
		}

		/**
		 * Truncate table for blazing speed if no condition is provided.
		 */
		if (empty($where)) {
			$query = 'TRUNCATE TABLE `'.$table.'`';
		} else {
			$delete = 'DELETE FROM `'.$table.'`';
			$query = $delete.' '.$where;
			unset($delete);
			unset($where);
		}
		unset($table);

		$db = $this->getDb();
		/* @var $db DBI_mysqli */

		// This will force commit the query even if MYSQL has AUTOCOMMIT = 0 by wrapping
		// it in the below transaction sequence.
		if ($this->_autoCommit === true) {
			$db->begin();
		}

		// The below query will commit by default if MYSQL has AUTOCOMMIT = 1
		// and this query is not wrapped inside of a BEGIN...COMMIT transaction sequence.
		// mysql> SHOW VARIABLES LIKE 'AUTOCOMMIT';
		$db->execute($query, $arrValues);

		if ($this->_autoCommit === true) {
			$db->commit();
		}

		$db->free_result();
		$db->reset();
		unset($db);
	}

	/*
	// PHP 5.3.0+
	public static function findById($database, $id)
	{
		// get_called_class() PHP 5 >= 5.3.0
		$class = get_called_class();
		$object = new $class($database);
		$key = array('id' => $id);
		$object->setKey($key);
		$object->load();
		$dataLoadedFlag = $object->isDataLoaded();
		if ($dataLoadedFlag) {
			$object->convertDataToProperties();
			$object->setId($id);
			return $object;
		} else {
			return false;
		}
	}
	*/

	public function getPrimaryKeyAsString()
	{
		if (isset($this->_arrPrimaryKey)) {
			$arrPrimaryKey = array_keys($this->_arrPrimaryKey);
			$arrPrimaryKeyProperties = array();
			foreach ($arrPrimaryKey as $attribute) {
				$property = $this->arrAttributesMap[$attribute];
				$propertyValue = $this->$property;
				$arrPrimaryKeyProperties[] = $propertyValue;
			}
			$primaryKeyAsString = join('-', $arrPrimaryKeyProperties);
		} elseif (isset($this->_id)) {
			$primaryKeyAsString = $this->_id;
		} elseif (isset($this->_data['id'])) {
			$primaryKeyAsString = $this->_data['id'];
		} elseif (isset($this->_arrUniqueness)) {
			$arrUniqueness = array_keys($this->_arrUniqueness);
			$arrUniqueProperties = array();
			foreach ($arrPrimaryKey as $attribute) {
				$property = $this->_arrAttributesMap[$attribute];
				$propertyValue = $this->$property;
				$arrUniqueProperties[] = $propertyValue;
			}
			$primaryKeyAsString = join('-', $arrUniqueProperties);
		}

		return $primaryKeyAsString;
	}

	/**
	 * Enter description here...
	 *
	 * @param unknown_type $primaryKey
	 * @param $format $type (id|primary_key|unique_index)
	 * @return array
	 */
	public function parsePrimaryKeyFromString($primaryKey, $format='id')
	{
		$arrPrimaryKey = array();

		if ($format == 'id' && isset($this->_id)) {
			if (preg_match('/^[0-9]+$/', $primaryKey)) {
				$arrPrimaryKey = array('id' => $primaryKey);
				$this->setId($primaryKey);
			}
		} elseif ($format == 'primary_key' && isset($this->_arrPrimaryKey)) {
			$arrPrimaryKeyKeys = array_keys($this->_arrPrimaryKey);
			$arrPrimaryKeyValues = explode('-', $primaryKey);
			if (count($arrPrimaryKeyKeys) == count($arrPrimaryKeyValues)) {
				$arrPrimaryKey = array_combine($arrPrimaryKeyKeys, $arrPrimaryKeyValues);
				$this->setArrPrimaryKey($arrPrimaryKey);
			}
		} elseif (isset($this->_arrUniqueness)) {
			$arrUniquenessKeys = array_keys($this->_arrUniqueness);
			$arrUniquenessValues = explode('-', $primaryKey);
			if (count($arrUniquenessKeys) == count($arrUniquenessValues)) {
				$arrPrimaryKey = array_combine($arrUniquenessKeys, $arrUniquenessValues);
				$this->setArrPrimaryKey($arrPrimaryKey);
			}
		}

		return $arrPrimaryKey;
	}

	/**
	 * PHP < 5.3.0
	 *
	 * This loads the record by id via SQL and dynamically sets the $key to
	 * the $arrUniqueness variables.
	 *
	 * Order of attributes matches the above future version with no $table or $class.
	 *
	 * @param string $database
	 * @param string $class
	 * @param int $id
	 * @return mixed (single ORM object | false)
	 */
	public static function findById($database, $id, $table, $class)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */
		$db->free_result();
		$query =
"
SELECT *
FROM `$table`
WHERE `id` = ?
";
		$arrValues = array($id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if (isset($row) && !empty($row)) {
			// @todo Figure out this behavior
			// id is the key for now since it was the finder
			$key = array('id' => $id);
			$orm = self::instantiateOrm($database, $class, $row, $key, $id);
			$orm->setDb($db);
			return $orm;
		} else {
			return false;
		}
	}

	public function loadById($id)
	{
		$key = array('id' => $id);
		$this->setKey($key);
		$this->load();
		$dataLoadedFlag = $this->isDataLoaded();
		if ($dataLoadedFlag) {
			$this->setId($id);
			$this->convertDataToProperties();
		}
	}

	public function findByUniqueIndex($uniqueIndexLabel=null)
	{
		if (isset($this->_data['id'])) {
			$id = $this->_data['id'];
			$this->_id = $id;
		}
		$key = $this->deriveKey($uniqueIndexLabel);
		if (!empty($key)) {
			$this->setKey($key);
			$this->setData(null);
			$this->load();
			$dataLoadedFlag = $this->isDataLoaded();
			if ($dataLoadedFlag) {
				$this->convertDataToProperties();
			}
		} else {
			$this->reset();
		}
	}

	/**
	 * This is for a load operation performed by a sub-class. Each record is
	 * mapped to an object an initialized as an ORM instance. No load operation
	 * is being performed here.
	 *
	 * @param string $database
	 * @param string $class
	 * @param array $row
	 * @param array $key
	 * @return IntegratedMapper / ORM Object
	 */
	public static function instantiateOrm($database, $class, $row, $key=null, $id=null, $prefix=null)
	{
		// Sanity check for existence of data for the record
		if (!isset($row) || empty($row)) {
			return false;
		}

		if (isset($prefix) && !empty($prefix)) {
			$tmpRow = $row;
			$row = array();
			foreach ($tmpRow as $tmpKey => $tmpValue) {
				if (is_int(strpos($tmpKey, $prefix))) {
					$actualKey = str_replace($prefix, '', $tmpKey);
					$row[$actualKey] = $tmpValue;
				}
			}
		}

		$orm = new $class($database);
		$orm->setData($row);
		$orm->convertDataToProperties();

		// Set the id value before invocation of $orm->deriveKey();
		// id may have a different name than "id" such as "contact_id"
		if (isset($id) && !empty($id)) {
			$orm->setId($id);
		} elseif (isset($row['id'])) {
			$id = (int) $row['id'];
			$orm->setId($id);
		}

		// Some tables may not have id=xxx as the key or need a unique index to be used instead.
		// If no explicit value for $key passed in then derive it here.
		if (!isset($key) || empty($key)) {
			$key = $orm->deriveKey();
		}

		if (!isset($key) || empty($key)) {
			// All values for the $key must exist in $row so kill the $key
			$key = null;
		}

		if (isset($key) && !empty($key)) {
			$orm->setKey($key);
		}

		return $orm;
	}

	/**
	 * This is for an ORM that used load(). Standardized the steps. Code reuse.
	 *
	 * @param array $key
	 * @return void
	 */
	public function initializeOrm($key=null)
	{
		$dataLoadedFlag = $this->isDataLoaded();
		if ($dataLoadedFlag) {
			$this->convertDataToProperties();
		}

		// Set the id value before invocation of $orm->deriveKey();
		if (isset($this->arrAttributesMap['id']) && !empty($this->arrAttributesMap['id'])) {
			$idVariableName = $this->arrAttributesMap['id'];
			if (isset($this->$idVariableName) && !empty($this->$idVariableName)) {
				$id = (int) $this->$idVariableName;
				$this->setId($id);
			}
		}

		// Some tables may not have id=xxx as the key or need a unique index to be used instead.
		// If no explicit value for $key passed in then derive it here.
		if (!isset($key) || empty($key)) {
			$key = $this->deriveKey();
		}

		if (!isset($key) || empty($key)) {
			// All values for the $key must exist in $row so kill the $key
			$key = null;
		}

		if (isset($key) && !empty($key)) {
			$this->setKey($key);
		}

		return;
	}

	/**
	 * Convert each public ORM property to an HTML ENTITY encoded version for use in HTML and forms.
	 *
	 * @todo Add extra array of ad-hoc properties to additionally escape in addition to properties within $arrAttributesMap.
	 *
	 * @return void
	 */
	public function htmlEntityEscapeProperties($forceRedoFlag=false)
	{
		$htmlEntityPropertiesEscapedFlag = $this->_htmlEntityPropertiesEscapedFlag;

		if ($htmlEntityPropertiesEscapedFlag && !$forceRedoFlag) {
			return;
		}

		$arrAttributesMap = $this->arrAttributesMap;

		foreach ($arrAttributesMap as $attributeKey => $propertyKey) {
			if (isset($this->$propertyKey) && !empty($this->$propertyKey)) {
				$propertyValue = $this->$propertyKey;
				$escapedPropertyKey = "escaped_{$propertyKey}";
				$escapedPropertyKeyNl2br = "escaped_{$propertyKey}_nl2br";
				// bool property_exists ( mixed $class , string $property )
				$htmlEntityEscapedPropertyExistsFlag = property_exists($this, $escapedPropertyKey);
				if ($htmlEntityEscapedPropertyExistsFlag) {
					$escapedPropertyValue = Data::entity_encode($propertyValue);
					$escapedPropertyValueNl2br = nl2br($escapedPropertyValue);
					$this->$escapedPropertyKey = $escapedPropertyValue;
					$this->$escapedPropertyKeyNl2br = $escapedPropertyValueNl2br;
				}
			}
		}

		$this->_htmlEntityPropertiesEscapedFlag = true;

		return;
	}

	/**
	 * The first object contains the key/id and the second only has to have the $_data array
	 *
	 * @param unknown_type $objectExistingData
	 * @param unknown_type $objectNewData
	 * @return unknown
	 */
	public static function deltifyAndUpdate($objectExistingData, $objectNewData)
	{
		// No inserts are happening here
		// deltify
		// save via update, or do nothing

		$newData = $objectNewData->getData();

		// Iterate over latest input from data feed and only set different values.
		// Same values will be key unset to acheive a conditional update.
		$save = false;
		$existsFlag = $objectExistingData->isDataLoaded();
		if ($existsFlag) {
			//$record_id = $objectExistingData->id;

			//Conditionally Update the record
			//Don't compare the key values that loaded the record.
			//unset($u->id);
			//unset($u->modified);
			//unset($u->created);
			//unset($u->deleted_flag);

			$existingData = $objectExistingData->getData();

			// debug
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
				$objectExistingData->setData($data);
				$save = true;
			} else {
				$save = false;
			}
		}

		// Save if needed (conditionally Insert/Update)
		if ($save) {
			$objectExistingData->save();
		}

		// Return the updated object with the latest data
		if (isset($data) && !empty($data)) {
			$arrUpdatedData = $existingData;
			foreach ($data as $k => $v) {
				$arrUpdatedData[$k] = $v;
			}

			$objectExistingData->setData($arrUpdatedData);

			// CovertDataToProperties() ???
			$objectExistingData->convertDataToProperties();
		}

		return $objectExistingData;
	}

	/**
	 * Conditionally invoke the standard save() method after deltification.
	 *
	 */
	public function deltifyAndSaveViaInsert()
	{
		// All of these occur inline via Insert on duplicate key update

		// load existing

		// deltify inline

		// save (insert, update, or do nothing)

		$arrAttributesMap = $this->arrAttributesMap;
		$this->convertPropertiesToData();
		if (isset($arrAttributesMap['created'])) {
			// `created` timestamp may be set to null to initialize its value
			// It is skipped by the above $this->convertPropertiesToData(); line
			if (property_exists($this, 'created')) {
				$newData['created'] = $this->created;
			}
		}
		$newData = $this->getData();

		//INSERT #IGNORE
		//INTO bid_lists (user_company_id, bid_list_name, bid_list_description)
		//VALUES (22, 'Las Alturas', 'Example Description')
		//ON DUPLICATE KEY UPDATE bid_list_description = 'Example Description1'

		/*
		// GUIDs/ID, etc.
		// unique index comes from $arrUniqueness
		$arrUniqueness = $this->_arrUniqueness;
		$id = $this->_id;

		$key = array();
		if (!empty($arrUniqueness)) {
			foreach ($arrUniqueness as $attribute => $attributeType) {
				switch ($attributeType) {
					case 'int':
					case 'integer':
						$key[$attribute] = (int) $this->$attribute;
						break;

					case 'string':
					default:
						$key[$attribute] = (string) $this->$attribute;
						break;
				}
			}
		} elseif (!empty($id)) {
			$key = array('id' => $id);
		}
		*/

		$db = $this->getDb();
		/* @var $db DBI_mysqli */

		$table = $this->getTable();
		$insert =
			'INSERT IGNORE INTO `'.
			$table.'` (';
		$values = 'VALUES (';
		$onDuplicateKeyUpdateQueryClauseExists = false;
		$first = true;
		$onDuplicateKeyUpdateFirst = true;
		$arrValues = array();
		$arrOnDuplicateKeyUpdateValues = array();
		$key = $this->deriveKey();
		if (isset($key) && !empty($key) && !isset($key['id'])) {
			unset($newData['id']);
		}

		if (isset($this->arrAttributesMap['id'])) {
			$onDuplicateKeyUpdate = ' ON DUPLICATE KEY UPDATE id=LAST_INSERT_ID(id), ';
		} else {
			$onDuplicateKeyUpdate = ' ON DUPLICATE KEY UPDATE ';
		}

		foreach ($arrAttributesMap as $attribute => $property) {
			$k = $attribute;
			if (!isset($newData[$attribute])) {
				continue;
			}
			$v = $newData[$attribute];

			if ($first) {
				$insert .= "`$k`";
				$values .= '?';
				$arrValues[] = $v;
				$first = false;
			} else {
				$insert .= ', '."`$k`";
				$values .= ', ?';
				$arrValues[] = $v;
			}

			if (!isset($key[$attribute])) {
				//$quotedValue = $db->quote($v);
				if ($onDuplicateKeyUpdateFirst) {
					$onDuplicateKeyUpdate .= " $k = ?";
					$onDuplicateKeyUpdateQueryClauseExists = true;
					$onDuplicateKeyUpdateFirst = false;
					$arrOnDuplicateKeyUpdateValues[] = $v;
				} else {
					if (!isset($key[$attribute])) {
						$onDuplicateKeyUpdate .= ", $k = ?";
						$onDuplicateKeyUpdateQueryClauseExists = true;
						$arrOnDuplicateKeyUpdateValues[] = $v;
					}
				}
			}
		}
		$insert .= ') ';
		$values .= ')';

		$query = $insert.$values;

		if ($onDuplicateKeyUpdateQueryClauseExists) {
			$query .= $onDuplicateKeyUpdate;
			//$arrValuesFinal = $arrValues + $arrOnDuplicateKeyUpdateValues;
			foreach ($arrOnDuplicateKeyUpdateValues as $extraValue) {
				$arrValues[] = $extraValue;
			}
		}

		// This will force commit the query even if MYSQL has AUTOCOMMIT = 0 by wrapping
		// it in the below transaction sequence.
		if ($this->_autoCommit === true) {
			$db->begin();
		}

		// The below query will commit by default if MYSQL has AUTOCOMMIT = 1
		// and this query is not wrapped inside of a BEGIN...COMMIT transaction sequence.
		// mysql> SHOW VARIABLES LIKE 'AUTOCOMMIT';
		$result = $db->execute($query, $arrValues);

		if ($this->_autoCommit === true) {
			$db->commit();
		}

		$id = $db->insertId;

		$db->free_result();
		$db->reset();
		unset($db);

		return $id;
	}

	/**
	 * Conditionally invoke the standard save() method after deltification.
	 *
	 */
	public function deltifyAndSave()
	{
		if (isset($this->_className)) {
			$class = $this->_className;
		} else {
			$class = get_class($this);
			//throw new Exception('Invalid invocation: missing $this->_className');
		}

//		if (!isset($this->_arrUniqueness)) {
//			throw new Exception('Invalid invocation: missing $this->_arrUniqueness');
//		}

		//load existing

		//deltify

		//save (insert, update, or do nothing)

		$this->convertPropertiesToData();
		$newData = $this->getData();

		// `created` timestamp may be set to null to initialize its value
		// It is skipped by the above $this->convertPropertiesToData(); line
		if (isset($this->arrAttributesMap['created']) && property_exists($this, 'created')) {
			$newData['created'] = $this->created;
		}

		$database = $this->getDatabase();
		$tmpObject = new $class($database);

		// GUIDs/ID, etc.
		// unique index comes from $arrUniqueness
		$key = $this->deriveKey();

		if (isset($key) && !empty($key)) {
			$tmpObject->setKey($key);
			$tmpObject->load();
		}

		/**
		 * Conditionally Insert/Update the record.
		 *
		 * $key is conditionally set based on if record exists.
		 */
		//Iterate over latest input from data feed and only set different values.
		//Same values will be key unset to acheive a conditional update.
		$save = false;
		$existsFlag = $tmpObject->isDataLoaded();
		if ($existsFlag) {
			// Conditionally Update the record
			// Don't compare the key values that loaded the record.
			$id = $tmpObject->id;
			unset($tmpObject->id);

			$existingData = $tmpObject->getData();

			$data = Data::deltify($existingData, $newData);
			if (!empty($data)) {
				$tmpObject->setData($data);
				$save = true;
			}
		} else {
			// Insert the record
			$tmpObject->setKey(null);
			$tmpObject->setData($newData);
			$save = true;
		}

		// Save if needed (conditionally Insert/Update)
		if ($save) {
			$id = $tmpObject->save();

			if (isset($id) && ($id != 0)) {
				$this->setId($id);
			}
		}

		return $id;
	}
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

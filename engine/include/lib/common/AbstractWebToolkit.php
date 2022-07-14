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
 * Ancestor super class for all MVC classes: Model, View, Controller, etc.
 *
 * @category   MVC Super Class (Base Class)
 * @package    AbstractWebToolkit
 *
 *
 */

abstract class AbstractWebToolkit implements ArrayAccess, Countable, Iterator
{
    /**
     * Iteration index
     *
     * @var integer
     */
    protected $_index;

    /**
     * Number of elements in $_data
     *
     * @var integer
     */
    protected $_count;

	/**
	 * A set of data for the given object.
	 *
	 * @var array
	 */
	protected $_data;

	/**
	 * Boolean to indicate if $_data is empty.
	 *
	 * @var bool
	 */
	protected $_dataLoadedFlag = false;

	/**
	 * Attribute-value / name-value / key-value pairs mapping for data input
	 * to object properties within an object reference.
	 *
	 * $_data is an associative array.
	 *
	 * The attributes for a single record are stored as key-value pairs in $_data.
	 * Metadata mapper pattern maps db attributes to object properties.
	 *
	 * ini files store key-value pairs and so config files can easily use this.
	 *
	 * @var array
	 */
	protected $arrAttributesMap = array();

	/**
	 * Object reference for the Timer class.
	 *
	 * @var unknown_type
	 */
//	protected $_timer;

	/**
	 * Methods below are for the ArrayAccess interface.
	 *
	 */
	public function offsetExists($index)
	{
		if (isset($this->_data) && is_array($this->_data) && array_key_exists($index, $this->_data)) {
			return true;
		} else {
			return false;
		}
	}
	public function offsetGet($index)
	{
		if (isset($this->_data) && is_array($this->_data) &&
				array_key_exists($index, $this->_data)) {

			$data = $this->_data[$index];
			return $data;
		} else {
			return null;
		}
	}
	public function offsetSet($index, $new_value)
	{
		$this->_data[$index] = $new_value;
	}
	public function offsetUnset($index)
	{
		unset($this->_data[$index]);
	}

    /**
     * Defined by Countable interface
     *
     * @return int
     */
	public function count()
	{
		return $this->_count;
	}

	/**
	 * Defined by Iterator interface
	 *
	 */
	public function rewind()
	{
		reset($this->_data);
		$this->_index = 0;
	}

	/**
	 * Defined by Iterator interface
	 *
	 */
	public function next()
	{
		$result = next($this->_data);
		$this->_index++;
		return $result;
	}

	/**
	 * Defined by Iterator interface
	 *
	 * @return boolean
	 */
	public function valid()
	{
		$result = $this->_index < $this->_count;
		return $result;
	}

	/**
	 * Defined by Iterator interface
	 *
	 * @return mixed
	 */
	public function key()
	{
		$result = key($this->_data);
		return $result;
	}

	/**
	 * Defined by Iterator interface
	 *
	 * @return mixed
	 */
	public function current()
	{
		$result = current($this->_data);
		return $result;
	}

	/**
	 * Get the value of an attribute for a given record.
	 *
	 * Typically corresponds to the database attribute value for the given record.
	 * The value of the attribute is returned.
	 *
	 * @param $key
	 *
	 *
	 */
	public function __get($key)
	{
		if (isset($this->_data) && isset($this->_data[$key])) {
			$result = $this->_data[$key];
		} else {
			$result = null;
		}
		return $result;
// Bug in ZS so below is commented out.
//		} else {
//			throw new Exception("Record::__get() - attribute $key does not exist.");
//		}
	}

	/**
	 * Set the value of an attribute for a given record.
	 *
	 * Typically corresponds to the database attribute value for the given record.
	 * The value of the attribute is changed to the input value.
	 *
	 * @param $key
	 * @param $value
	 *
	 */
	public function __set($key, $value)
	{
		if (isset($key) && strlen($key) > 0) {
			$this->_data[$key] = $value;
		} else {
			$msg = __CLASS__.' '.__METHOD__.' on line '.__LINE__.' of '.__FILE__;
			$msg .= ' - Missing param $key';
			throw new Exception($msg);
		}
	}

    /**
     * Support isset() overloading on PHP 5.1
     *
     * @param string $name
     * @return boolean
     */
	public function __isset($name)
	{
		$result = isset($this->_data[$name]);

		return $result;
	}

    /**
     * Support unset() overloading on PHP 5.1
     *
     * @param string $name
     */
	public function __unset($name)
	{
		unset($this->_data[$name]);
	}

	/**
	 * Call any method.
	 *
	 * Typically corresponds to the database attribute value for the given record.
	 * The value of the attribute is changed to the input value.
	 *
	 * Avoid writing get/set methods ever =:-)
	 *
	 * @param string $method
	 * @param mixed $params
	 *
	 */
	public function __call($method, $params = null)
	{
		if (isset($method) && !empty($method) && is_string($method)) {
			if (method_exists($this, $method)) {
				$this->$method($params);
			} elseif (is_int(strpos($method, 'get'))) {
				$property = str_replace('get', '', $method);
				$property[0] = strtolower($property[0]);
				if (property_exists($this, $property)) {
					return $this->$property;
				} elseif (property_exists($this, '_'.$property)) {
					$property = '_'.$property;
					return $this->$property;
				}
			} elseif (is_int(strpos($method, 'set'))) {
				$property = str_replace('set', '', $method);
				$property[0] = strtolower($property[0]);
				$input = array_pop($params);
				if (property_exists($this, $property)) {
					$this->$property = $input;
				} elseif (property_exists($this, '_'.$property)) {
					$property = '_'.$property;
					$this->$property = $input;
				}
			}
		} else {
			$msg = __CLASS__.' '.__METHOD__.' on line '.__LINE__.' of '.__FILE__;
			$msg .= ' - Invalid params.';
			throw new Exception($msg);
		}
	}

	public function __toString()
	{
		$string = '<font color=#CB0100 face=Arial size=4><pre>'.print_r($this, true).'</pre></font>';
		return $string;
	}

	/**
	 * Get the complete array of key value pairs for the current data set.
	 *
	 * Typically corresponds to the database attributes and their values
	 * for the given result set.
	 *
	 */
	public function getData()
	{
		if (isset($this->_data)) {
			return $this->_data;
		} else {
			return null;
		}
	}

	/**
	 * Set the result set to an array value.
	 *
	 * Typically corresponds to the database attribute value for the given record.
	 * The value of the attribute is changed to the input value.
	 *
	 * @param $data
	 *
	 */
	public function setData($data, $filterKeys=false)
	{
		if ($filterKeys) {
			$arrAttributesMap = $this->getArrAttributesMap();
			$arrIntersection = array_intersect_key($data, $arrAttributesMap);
			$data = $arrIntersection;
		}

		$this->_data = $data;
		$this->_dataLoadedFlag = true;

		//Set $_count so Iterator pattern holds up
		if (isset($data) && is_array($data)) {
			$this->_count = count($data);
		} else {
			$this->_count = 0;
		}
	}

	public function isDataLoaded()
	{
		if (isset($this->_data) && !empty($this->_data)) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Metadata mapper pattern maps db attributes to object properties.
	 */
	public function getArrAttributesMap()
	{
		return $this->arrAttributesMap;
	}

	/**
	 * Metadata mapper pattern maps db attributes to object properties.
	 */
	public function setArrAttributesMap($arrAttributesMap)
	{
		$this->arrAttributesMap = $arrAttributesMap;
	}

	/**
	 * Metadata mapper pattern maps db attributes to object properties.
	 */
	public function convertDataToProperties()
	{
		$arrAttributesMap = $this->getArrAttributesMap();
		$data = $this->getData();
		if (isset($arrAttributesMap) && !empty($arrAttributesMap) && isset($data) && !empty($data)) {
			foreach ($arrAttributesMap as $key => $value) {
				if (array_key_exists($key, $data)) {
					$this->$value = $data[$key];
				}
			}
		}
	}

	/**
	 * Metadata mapper pattern maps db attributes to object properties.
	 */
	public function convertPropertiesToData()
	{
		$arrAttributesMap = $this->getArrAttributesMap();
		$data = array();
		foreach ($arrAttributesMap as $key => $value) {


			$currentValue = $this->$value;
			// No NULL values arr allowed using this method so they would have to be manually set afterward
			// @todo Add setFlags for each property to indicate whether the value was explicitly "set" via an accessor method.
			if (isset($currentValue)) {
				$data[$key] = $currentValue;
			}
		}
		$this->setData($data);
	}

	public function get_called_class()
	{
		if (function_exists('get_called_class')) {
			$class = get_called_class();
		} else {
			$class = $this->_className;
		}

		return $class;
	}
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

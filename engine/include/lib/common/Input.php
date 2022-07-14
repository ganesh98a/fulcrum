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
 * Input class takes any arguments array and converts it into an object.
 *
 * Its purpose is to be the input for any interface.
 * All arguments to methods/functions can be encapsulated within
 * a given Input object.
 *
 * @category	Input
 * @package		Input
 * @see			ObjectArray
 * @see 		ArrayObject (SPL)
 */

/**
 * AbstractWebToolkit
 */
//Already Included...commented out for performance gain
//require_once('lib/common/AbstractWebToolkit.php');

/**
 * ArrayObject
 */
//require_once('lib/common/ObjectArray.php');

//class Input extends Object_Array
class Input extends AbstractWebToolkit
{
	public $arrOrderByAttributes = array();
	public $extendedReturn = false;
	public $filterByCostCode = false;
	public $forceLoadFlag = false;

	// Views
	public $whitespacePrefix = '';
	public $attributeGroup = '';
	public $attributeSubgroup = '';
	public $uniqueId = '';
	public $dummyId = '';

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

	public function debug()
	{
		echo '<pre>';
		print_r($this->_data);
		echo '</pre>';
	}
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

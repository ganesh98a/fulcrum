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
 * Contact.
 *
 * @category   Framework
 * @package    Contact
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class DrawActionTypeOptions extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'DrawActionTypeOptions';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'draw_action_type_options';

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
	 * unique index `unique_contact` (`user_company_id`,`contact_company_id`,`email`,`first_name`,`last_name`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	/*protected $_arrUniqueness = array(
		'unique_contact' => array(
			'project_id' => 'int',
			'draw_id' => 'int',
			'signature_type_id' => 'string',
		)
	);*/

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
		'id' => 'draw_action_type_option_id',
		'draw_action_type_id' => 'draw_action_type_id',
		'option_name' => 'option_name',
		'disable_flag' => 'disable_flag'		
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $draw_action_type_option_id;
	public $draw_action_type_id;
	public $option_name;
	public $disable_flag;
	
	
	// HTML ENTITY ENCODED ORM string properties
	public $escaped_option_name;

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllDrawActionTypes;
	protected static $_arrAllDrawActionTypeOptions;
	/**
	 * Constructor
	 */
	public function __construct($database, $table='draw_action_type_options')
	{
		parent::__construct($table);
		$this->setDatabase($database);
	}
	// Finder: Find By pk (a single auto int id or a single non auto int pk)
	/**
	 * PHP < 5.3.0
	 *
	 * @param string $database
	 * @param int $contact_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findById($database, $draw_action_type_id, $table='draw_action_type_options', $module='DrawActionTypeOptions')
	{
		$actionType = parent::findById($database, $draw_action_type_id, $table, $module);

		return $actionType;
	}

	public static function getArrAllDrawActionType()
	{
		if (isset(self::$_arrAllDrawActionTypes)) {
			return self::$_arrAllDrawActionTypes;
		} else {
			return null;
		}
	}

	public static function setArrAllDrawActionType($arrAllDrawActionTypes)
	{
		self::$_arrAllDrawActionTypes = $arrAllDrawActionTypes;
	}

	/*public static function getArrAllDrawActionTypeOption()
	{
		if (isset(self::$_arrAllDrawActionTypeOptions)) {
			return self::$_arrAllDrawActionTypeOptions;
		} else {
			return null;
		}
	}

	public static function setArrAllDrawActionTypeOption($arrAllDrawActionTypeOptions)
	{
		self::$_arrAllDrawActionTypeOptions = $arrAllDrawActionTypeOptions;
	}*/

	// Loaders: Load All Draw Action Type Records
	/**
	 * Load all draw signature block records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllDrawActionTypeOptionsByActId($database, $action_type_id, Input $options=null)
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
			self::$_arrAllDrawActionTypes = null;
		}

		$arrAllDrawActionTypes = self::$_arrAllDrawActionTypes;
		if (isset($arrAllDrawActionTypes) && !empty($arrAllDrawActionTypes)) {
			return $arrAllDrawActionTypes;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpContact = new DrawSignatureType($database);
			$sqlOrderByColumns = $tmpContact->constructSqlOrderByColumns($arrOrderByAttributes);

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
		dato.*
		FROM `draw_action_type_options` dato
		WHERE dato.`draw_action_type_id` = ? AND  dato.`disable_flag` = 'N'
		{$sqlOrderBy}{$sqlLimit}
		";
		$arrValues = array($action_type_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrAllDrawActionTypes = array();
		while ($row = $db->fetch()) {
			$action_type_option_id = $row['id'];
			$actionTypeOption = self::instantiateOrm($database, 'DrawActionTypeOptions', $row, null, $action_type_option_id);
			/* @var $contact Contact */

			$arrAllDrawActionTypes[$action_type_option_id] = $actionTypeOption;
		}

		$db->free_result();

		self::$_arrAllDrawActionTypes = $arrAllDrawActionTypes;

		return $arrAllDrawActionTypes;
	}

		//To get the Draw Action Type 
	public static function getDrawActionOptionName($database,$draw_template_id){

		$db = DBI::getInstance();
        $query = "SELECT  option_name FROM  draw_action_type_options where id='$draw_template_id'";
        $db->execute($query);
		$row = $db->fetch();
        $option_name=$row['option_name'];
		$db->free_result();

		return $option_name;

	}

	//To get all the time zone
	public static function loadAllTimeZone($database){

		$db = DBI::getInstance();
        $query = "SELECT  * FROM  time_zone where status='Y'";
        $db->execute($query);
		$arrAllDrawActionTypes = array();
		while ($row = $db->fetch()) {
			$action_type_option_id = $row['id'];
			$arrAllDrawActionTypes[$action_type_option_id] = $row;
			$arrAllDrawActionTypes[$action_type_option_id]['name'] = $row['zone_name'].', '.$row['city'];
		}

		$db->free_result();
		return $arrAllDrawActionTypes;

	}

	//To get all the delivery time
	public static function loadAllDeliveryTime($database){

		$db = DBI::getInstance();
        $query = "SELECT  * FROM  delivery_time where status='Y'";
        $db->execute($query);
		$arrAllDrawActionTypes = array();
		while ($row = $db->fetch()) {
			$action_type_option_id = $row['id'];
			$arrAllDrawActionTypes[$action_type_option_id]['id'] = $row['id'];
			$arrAllDrawActionTypes[$action_type_option_id]['value'] = $row['value'];
		}

		$db->free_result();
		return $arrAllDrawActionTypes;

	}

	// To get specific timezone
	public static function getTimeZone($database,$timeZoneId){

		$db = DBI::getInstance();
        $query = "SELECT  * FROM  time_zone where id=$timeZoneId and status='Y'";
        $db->execute($query);		
		$row = $db->fetch();
		$arrAllDrawActionTypes = $row['zone_name'].', '.$row['city'];
		$db->free_result();
		return $arrAllDrawActionTypes;
	}

	// To get specific Delivery Time
	public static function getDeliveryTime($database,$deliveryTimeId){
		$db = DBI::getInstance();
        $query = "SELECT  * FROM  delivery_time where id=$deliveryTimeId and status='Y'";
        $db->execute($query);		
		$row = $db->fetch();
		$arrAllDrawActionTypes = $row['value'];
		$db->free_result();
		return $arrAllDrawActionTypes;
	}
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

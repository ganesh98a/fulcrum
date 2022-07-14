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

class DrawActionTypes extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'DrawActionTypes';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'draw_action_types';

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
		'id' => 'draw_action_type_id',
		'action_name' => 'action_name',
		'disable_flag' => 'disable_flag',
		'action_option' => 'action_option',
		'enable_flag' => 'enable_flag',
		'xlsx_download' => 'xlsx_download',
		'pdf_download' => 'pdf_download'		
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $id;
	public $action_name;
	public $disable_flag;
	public $action_option;
	public $enable_flag;
	public $xlsx_download;
	public $pdf_download;
	
	// HTML ENTITY ENCODED ORM string properties
	public $escaped_action_name;

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllDrawActionTypes;
	protected static $_arrAllDrawActionTypeOptions;
	/**
	 * Constructor
	 */
	public function __construct($database, $table='draw_action_types')
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
	public static function findById($database, $draw_action_type_id, $table='draw_action_types', $module='DrawActionTypes')
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

	public static function getArrAllDrawActionTypeOption()
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
	}

	// Loaders: Load All Draw Action Type Records
	/**
	 * Load all draw signature block records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllDrawActionTypes($database, Input $options=null)
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
		dat.*,
		dato.`id` AS 'dato__id',
		dato.`option_name` AS 'dato__option_name',
		dato.`draw_action_type_id` AS 'dato__draw_action_type_id',
		dato.`disable_flag` AS 'dato__disable_flag'
		
		FROM `draw_action_types` dat
		LEFT JOIN  `draw_action_type_options` AS dato ON dato.`draw_action_type_id` = dat.`id` AND dato.`disable_flag` = 'N'
		WHERE dat.`disable_flag` = 'N'
		{$sqlOrderBy}{$sqlLimit}
		";
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllDrawActionTypes = array();
		while ($row = $db->fetch()) {
			$action_type_id = $row['id'];
			$actionType = self::instantiateOrm($database, 'DrawActionTypes', $row, null, $action_type_id);
			/* @var $contact Contact */


			if (isset($row['dato__id'])) {
				$dsclId = $row['dato__id'];
				$row['dato__id'] = $dsclId;
				$actionTypeOptions = self::instantiateOrm($database, 'DrawActionTypeOptions', $row, null, $dsclId, 'dato');

				/* @var $meeting Meeting */
				$actionTypeOptions->convertPropertiesToData();
				// print_r($actionTypeOptions);
			} else {
				$actionTypeOptions = false;
			}

			$actionType->setArrAllDrawActionTypeOption($actionTypeOptions);
			// print_r($signatureBlock->getSignatureBlockConstructionLender());
			$arrAllDrawActionTypes[$action_type_id] = $actionType;
		}

		$db->free_result();

		self::$_arrAllDrawActionTypes = $arrAllDrawActionTypes;

		return $arrAllDrawActionTypes;
	}

	public static function getTypeName($database, $id)
	{
		$db = DBI::getInstance($database);
		$query =" SELECT * FROM `draw_action_types` WHERE id = $id AND `disable_flag` = 'N' ";
		$db->query($query, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$typeName = $row['action_name'];
		$db->free_result();
		return $typeName;
	}

}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

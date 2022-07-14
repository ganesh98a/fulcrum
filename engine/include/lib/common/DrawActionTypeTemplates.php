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

class DrawActionTypeTemplates extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'DrawActionTypeTemplates';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'draw_action_type_templates';

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
		'id' => 'draw_action_type_template_id',
		'draw_action_type_id' => 'draw_action_type_id',
		'draw_action_type_option_id' => 'draw_action_type_option_id',
		'template_content' => 'template_content',
		'created_date' => 'created_date',
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $draw_action_type_template_id;
	public $draw_action_type_id;
	public $draw_action_type_option_id;
	public $template_content;
	public $created_date;
	
	// HTML ENTITY ENCODED ORM string properties
	public $escaped_template_content;

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllDrawActionTypeTemplates;
	/**
	 * Constructor
	 */
	public function __construct($database, $table='draw_action_type_templates')
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
	public static function findById($database, $draw_action_type_template_id, $table='draw_action_type_templates', $module='DrawActionTypeTemplates')
	{
		$actionTypeTemplate = parent::findById($database, $draw_action_type_template_id, $table, $module);

		return $actionTypeTemplate;
	}

	public static function getArrAllDrawActionTypeTemplate()
	{
		if (isset(self::$_arrAllDrawActionTypeTemplates)) {
			return self::$_arrAllDrawActionTypeTemplates;
		} else {
			return null;
		}
	}

	public static function setArrAllDrawActionTypeTemplate($arrAllDrawActionTypeTemplate)
	{
		self::$_arrAllDrawActionTypeTemplates = $arrAllDrawActionTypeTemplate;
	}

	// Loaders: Load All Draw Action Type Records
	/**
	 * Load all draw signature block records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllDrawActionTypeTemplatesByIds($database, $draw_action_type_id, $draw_action_type_option_id, Input $options=null)
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
			self::$_arrAllDrawActionTypeTemplates = null;
		}

		$arrAllDrawActionTypeTemplates = self::$_arrAllDrawActionTypeTemplates;
		if (isset($arrAllDrawActionTypeTemplates) && !empty($arrAllDrawActionTypeTemplates)) {
			return $arrAllDrawActionTypeTemplates;
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
		$whereCause = "datt.`draw_action_type_option_id` = $draw_action_type_option_id";
		if($draw_action_type_option_id =='' || $draw_action_type_option_id == NULL){
			$whereCause = "datt.`draw_action_type_option_id` IS NULL";
			// $whereCause = "";
		}
		$query =
		"
		SELECT
		datt.`id`,
		datt.`template_content`,
		datt.`draw_action_type_id`,
		datt.`draw_action_type_option_id`,
		datt.`created_date`

		FROM `draw_action_type_templates` datt
		WHERE datt.`draw_action_type_id` = $draw_action_type_id AND {$whereCause}
		{$sqlOrderBy}{$sqlLimit} LIMIT 1
		";
		$arrValues = array($draw_action_type_id, $draw_action_type_option_id);
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllDrawActionTypeTemplates = array();
		while ($row = $db->fetch()) {
			$action_type_template_id = $row['id'];
			// echo $action_type_template = $row['template_content'];
			// print_r($row);
			$actionTypeTemplate = self::instantiateOrm($database, 'DrawActionTypeTemplates', $row, null, $action_type_template_id);
			$arrAllDrawActionTypeTemplates = $actionTypeTemplate;
		}

		$db->free_result();

		self::$_arrAllDrawActionTypeTemplates = $arrAllDrawActionTypeTemplates;

		return $arrAllDrawActionTypeTemplates;
	}

}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

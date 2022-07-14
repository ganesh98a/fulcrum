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
 * PunchItemBuildingStatus.
 *
 * @category   Framework
 * @package    PunchItemBuildingStatus
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class MobileNavigation extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'MobileNavigation';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'mobile_navigation';

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
	 * No Unique Indexes, Just a Primary Key
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_mobile_navigation_via_primary_key' => array(
			'id' => 'int'
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
		'id' => 'id',
		'software_module_category' => 'software_module_category',
		'software_module' => 'software_module',
		'module_navigation' => 'module_navigation',
		'module_icon' => 'module_icon',
		'module_is_available' => 'module_is_available',
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $id;
	public $software_module_category;
	public $software_module;
	public $module_navigation;
	public $module_icon;
	public $module_is_available;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties
	public $escaped_module_navigation;
	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllMobileNavigatino;
	// Foreign Key Objects

	/**
	 * Constructor
	 */
	public function __construct($database, $table='mobile_navigation')
	{
		parent::__construct($table);
		$this->setDatabase($database);
	}


	// Finder: Find By pk (a single auto int id or a single non auto int pk)
	/**
	 * PHP < 5.3.0
	 *
	 * @param string $database
	 * @param int $mobile_navigation_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findById($database, $mobile_navigation_id, $table='mobile_navigation', $module='MobileNavigation')
	{
		$mobileNavigation = parent::findById($database, $mobile_navigation_id, 'mobile_navigation', 'MobileNavigation');

		return $mobileNavigation;
	}

	// Finder: Find By pk (a single auto int id or a single non auto int pk)
	/**
	 * PHP < 5.3.0
	 *
	 * @param string $database
	 * @param int $mobile_navigation_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findByModuleNavigation($database, $mobile_navigation_module)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */
		$db->free_result();
		$query =
		"
		SELECT *
		FROM `mobile_navigation` mn
		WHERE mn.`module_navigation` = ?
		";
		$arrValues = array($mobile_navigation_module);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$row = $db->fetch();
		$db->free_result();
		$mobileNavigation = null;
		if ($row) {
			$mobile_navigation_id = $row['id'];
			$mobileNavigation = self::instantiateOrm($database, 'MobileNavigation', $row, null, $mobile_navigation_id);
		}
		return $mobileNavigation;
	}
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

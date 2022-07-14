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
 * MeetingTypeTemplate.
 *
 * @category   Framework
 * @package    MeetingTypeTemplate
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class MeetingTypeTemplate extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'MeetingTypeTemplate';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'meeting_type_templates';

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
	 * unique index `unique_meeting_type_template` (`meeting_type`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_meeting_type_template' => array(
			'meeting_type' => 'string'
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
		'id' => 'meeting_type_template_id',

		'meeting_type' => 'meeting_type',

		'meeting_type_abbreviation' => 'meeting_type_abbreviation',
		'sort_order' => 'sort_order'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $meeting_type_template_id;

	public $meeting_type;

	public $meeting_type_abbreviation;
	public $sort_order;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties
	public $escaped_meeting_type;
	public $escaped_meeting_type_abbreviation;

	// HTML ENTITY ENCODED NL2BR ORM string properties
	public $escaped_meeting_type_nl2br;
	public $escaped_meeting_type_abbreviation_nl2br;

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllMeetingTypeTemplates;

	// Foreign Key Objects

	/**
	 * Constructor
	 */
	public function __construct($database, $table='meeting_type_templates')
	{
		parent::__construct($table);
		$this->setDatabase($database);
	}

	// Foreign Key Object Accessor Methods

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllMeetingTypeTemplates()
	{
		if (isset(self::$_arrAllMeetingTypeTemplates)) {
			return self::$_arrAllMeetingTypeTemplates;
		} else {
			return null;
		}
	}

	public static function setArrAllMeetingTypeTemplates($arrAllMeetingTypeTemplates)
	{
		self::$_arrAllMeetingTypeTemplates = $arrAllMeetingTypeTemplates;
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
	 * @param int $meeting_type_template_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findById($database, $meeting_type_template_id,$table='meeting_type_templates', $module='MeetingTypeTemplate')
	{
		$meetingTypeTemplate = parent::findById($database, $meeting_type_template_id, $table, $module);

		return $meetingTypeTemplate;
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Similar to FindById, but with SQL as starter code for more complex joins.
	 *
	 * @param string $database
	 * @param int $meeting_type_template_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findMeetingTypeTemplateByIdExtended($database, $meeting_type_template_id)
	{
		$meeting_type_template_id = (int) $meeting_type_template_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	mtt.*

FROM `meeting_type_templates` mtt
WHERE mtt.`id` = ?
";
		$arrValues = array($meeting_type_template_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$meeting_type_template_id = $row['id'];
			$meetingTypeTemplate = self::instantiateOrm($database, 'MeetingTypeTemplate', $row, null, $meeting_type_template_id);
			/* @var $meetingTypeTemplate MeetingTypeTemplate */
			$meetingTypeTemplate->convertPropertiesToData();

			return $meetingTypeTemplate;
		} else {
			return false;
		}
	}

	// Finders: Find By Unique Index
	/**
	 * Find by unique index `unique_meeting_type_template` (`meeting_type`).
	 *
	 * @param string $database
	 * @param string $meeting_type
	 * @return mixed (single ORM object | false)
	 */
	public static function findByMeetingType($database, $meeting_type)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	mtt.*

FROM `meeting_type_templates` mtt
WHERE mtt.`meeting_type` = ?
";
		$arrValues = array($meeting_type);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if ($row && !empty($row)) {
			$meeting_type_template_id = $row['id'];
			$meetingTypeTemplate = self::instantiateOrm($database, 'MeetingTypeTemplate', $row, null, $meeting_type_template_id);
			/* @var $meetingTypeTemplate MeetingTypeTemplate */
			return $meetingTypeTemplate;
		} else {
			return false;
		}
	}

	// Loaders: Load By pk List (list of auto int ids or other non auto int pk list)
	/**
	 * Load zero or more records by an id list (array of auto int primary keys).
	 *
	 * @param string $database
	 * @param array $arrMeetingTypeTemplateIds
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadMeetingTypeTemplatesByArrMeetingTypeTemplateIds($database, $arrMeetingTypeTemplateIds, Input $options=null)
	{
		if (empty($arrMeetingTypeTemplateIds)) {
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
		// ORDER BY `id` ASC, `meeting_type` ASC, `meeting_type_abbreviation` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY mtt.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpMeetingTypeTemplate = new MeetingTypeTemplate($database);
			$sqlOrderByColumns = $tmpMeetingTypeTemplate->constructSqlOrderByColumns($arrOrderByAttributes);

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

		foreach ($arrMeetingTypeTemplateIds as $k => $meeting_type_template_id) {
			$meeting_type_template_id = (int) $meeting_type_template_id;
			$arrMeetingTypeTemplateIds[$k] = $db->escape($meeting_type_template_id);
		}
		$csvMeetingTypeTemplateIds = join(',', $arrMeetingTypeTemplateIds);

		$query =
"
SELECT

	mtt.*

FROM `meeting_type_templates` mtt
WHERE mtt.`id` IN ($csvMeetingTypeTemplateIds){$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		$arrMeetingTypeTemplatesByCsvMeetingTypeTemplateIds = array();
		while ($row = $db->fetch()) {
			$meeting_type_template_id = $row['id'];
			$meetingTypeTemplate = self::instantiateOrm($database, 'MeetingTypeTemplate', $row, null, $meeting_type_template_id);
			/* @var $meetingTypeTemplate MeetingTypeTemplate */
			$meetingTypeTemplate->convertPropertiesToData();

			$arrMeetingTypeTemplatesByCsvMeetingTypeTemplateIds[$meeting_type_template_id] = $meetingTypeTemplate;
		}

		$db->free_result();

		return $arrMeetingTypeTemplatesByCsvMeetingTypeTemplateIds;
	}

	// Loaders: Load By Foreign Key

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all meeting_type_templates records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllMeetingTypeTemplates($database, Input $options=null)
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
			self::$_arrAllMeetingTypeTemplates = null;
		}

		$arrAllMeetingTypeTemplates = self::$_arrAllMeetingTypeTemplates;
		if (isset($arrAllMeetingTypeTemplates) && !empty($arrAllMeetingTypeTemplates)) {
			return $arrAllMeetingTypeTemplates;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `meeting_type` ASC, `meeting_type_abbreviation` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY mtt.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpMeetingTypeTemplate = new MeetingTypeTemplate($database);
			$sqlOrderByColumns = $tmpMeetingTypeTemplate->constructSqlOrderByColumns($arrOrderByAttributes);

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
	mtt.*

FROM `meeting_type_templates` mtt{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `meeting_type` ASC, `meeting_type_abbreviation` ASC, `sort_order` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllMeetingTypeTemplates = array();
		while ($row = $db->fetch()) {
			$meeting_type_template_id = $row['id'];
			$meetingTypeTemplate = self::instantiateOrm($database, 'MeetingTypeTemplate', $row, null, $meeting_type_template_id);
			/* @var $meetingTypeTemplate MeetingTypeTemplate */
			$arrAllMeetingTypeTemplates[$meeting_type_template_id] = $meetingTypeTemplate;
		}

		$db->free_result();

		self::$_arrAllMeetingTypeTemplates = $arrAllMeetingTypeTemplates;

		return $arrAllMeetingTypeTemplates;
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
INTO `meeting_type_templates`
(`meeting_type`, `meeting_type_abbreviation`, `sort_order`)
VALUES (?, ?, ?)
ON DUPLICATE KEY UPDATE `meeting_type_abbreviation` = ?, `sort_order` = ?
";
		$arrValues = array($this->meeting_type, $this->meeting_type_abbreviation, $this->sort_order, $this->meeting_type_abbreviation, $this->sort_order);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$meeting_type_template_id = $db->insertId;
		$db->free_result();

		return $meeting_type_template_id;
	}

	// Save: insert ignore
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

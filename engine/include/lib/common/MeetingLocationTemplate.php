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
 * MeetingLocationTemplate.
 *
 * @category   Framework
 * @package    MeetingLocationTemplate
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class MeetingLocationTemplate extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'MeetingLocationTemplate';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'meeting_location_templates';

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
	 * unique index `unique_meeting_location_template` (`meeting_location`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_meeting_location_template' => array(
			'meeting_location' => 'string'
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
		'id' => 'meeting_location_template_id',

		'meeting_location' => 'meeting_location',

		'meeting_location_abbreviation' => 'meeting_location_abbreviation',
		'sort_order' => 'sort_order'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $meeting_location_template_id;

	public $meeting_location;

	public $meeting_location_abbreviation;
	public $sort_order;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties
	public $escaped_meeting_location;
	public $escaped_meeting_location_abbreviation;

	// HTML ENTITY ENCODED NL2BR ORM string properties
	public $escaped_meeting_location_nl2br;
	public $escaped_meeting_location_abbreviation_nl2br;

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllMeetingLocationTemplates;

	// Foreign Key Objects

	/**
	 * Constructor
	 */
	public function __construct($database, $table='meeting_location_templates')
	{
		parent::__construct($table);
		$this->setDatabase($database);
	}

	// Foreign Key Object Accessor Methods

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllMeetingLocationTemplates()
	{
		if (isset(self::$_arrAllMeetingLocationTemplates)) {
			return self::$_arrAllMeetingLocationTemplates;
		} else {
			return null;
		}
	}

	public static function setArrAllMeetingLocationTemplates($arrAllMeetingLocationTemplates)
	{
		self::$_arrAllMeetingLocationTemplates = $arrAllMeetingLocationTemplates;
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
	 * @param int $meeting_location_template_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findById($database, $meeting_location_template_id,$table='meeting_location_templates', $module='MeetingLocationTemplate')
	{
		$meetingLocationTemplate = parent::findById($database, $meeting_location_template_id, $table, $module);

		return $meetingLocationTemplate;
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Similar to FindById, but with SQL as starter code for more complex joins.
	 *
	 * @param string $database
	 * @param int $meeting_location_template_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findMeetingLocationTemplateByIdExtended($database, $meeting_location_template_id)
	{
		$meeting_location_template_id = (int) $meeting_location_template_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	mlt.*

FROM `meeting_location_templates` mlt
WHERE mlt.`id` = ?
";
		$arrValues = array($meeting_location_template_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$meeting_location_template_id = $row['id'];
			$meetingLocationTemplate = self::instantiateOrm($database, 'MeetingLocationTemplate', $row, null, $meeting_location_template_id);
			/* @var $meetingLocationTemplate MeetingLocationTemplate */
			$meetingLocationTemplate->convertPropertiesToData();

			return $meetingLocationTemplate;
		} else {
			return false;
		}
	}

	// Finders: Find By Unique Index
	/**
	 * Find by unique index `unique_meeting_location_template` (`meeting_location`).
	 *
	 * @param string $database
	 * @param string $meeting_location
	 * @return mixed (single ORM object | false)
	 */
	public static function findByMeetingLocation($database, $meeting_location)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	mlt.*

FROM `meeting_location_templates` mlt
WHERE mlt.`meeting_location` = ?
";
		$arrValues = array($meeting_location);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if ($row && !empty($row)) {
			$meeting_location_template_id = $row['id'];
			$meetingLocationTemplate = self::instantiateOrm($database, 'MeetingLocationTemplate', $row, null, $meeting_location_template_id);
			/* @var $meetingLocationTemplate MeetingLocationTemplate */
			return $meetingLocationTemplate;
		} else {
			return false;
		}
	}

	// Loaders: Load By pk List (list of auto int ids or other non auto int pk list)
	/**
	 * Load zero or more records by an id list (array of auto int primary keys).
	 *
	 * @param string $database
	 * @param array $arrMeetingLocationTemplateIds
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadMeetingLocationTemplatesByArrMeetingLocationTemplateIds($database, $arrMeetingLocationTemplateIds, Input $options=null)
	{
		if (empty($arrMeetingLocationTemplateIds)) {
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
		// ORDER BY `id` ASC, `meeting_location` ASC, `meeting_location_abbreviation` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY mlt.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpMeetingLocationTemplate = new MeetingLocationTemplate($database);
			$sqlOrderByColumns = $tmpMeetingLocationTemplate->constructSqlOrderByColumns($arrOrderByAttributes);

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

		foreach ($arrMeetingLocationTemplateIds as $k => $meeting_location_template_id) {
			$meeting_location_template_id = (int) $meeting_location_template_id;
			$arrMeetingLocationTemplateIds[$k] = $db->escape($meeting_location_template_id);
		}
		$csvMeetingLocationTemplateIds = join(',', $arrMeetingLocationTemplateIds);

		$query =
"
SELECT

	mlt.*

FROM `meeting_location_templates` mlt
WHERE mlt.`id` IN ($csvMeetingLocationTemplateIds){$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		$arrMeetingLocationTemplatesByCsvMeetingLocationTemplateIds = array();
		while ($row = $db->fetch()) {
			$meeting_location_template_id = $row['id'];
			$meetingLocationTemplate = self::instantiateOrm($database, 'MeetingLocationTemplate', $row, null, $meeting_location_template_id);
			/* @var $meetingLocationTemplate MeetingLocationTemplate */
			$meetingLocationTemplate->convertPropertiesToData();

			$arrMeetingLocationTemplatesByCsvMeetingLocationTemplateIds[$meeting_location_template_id] = $meetingLocationTemplate;
		}

		$db->free_result();

		return $arrMeetingLocationTemplatesByCsvMeetingLocationTemplateIds;
	}

	// Loaders: Load By Foreign Key

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all meeting_location_templates records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllMeetingLocationTemplates($database, Input $options=null)
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
			self::$_arrAllMeetingLocationTemplates = null;
		}

		$arrAllMeetingLocationTemplates = self::$_arrAllMeetingLocationTemplates;
		if (isset($arrAllMeetingLocationTemplates) && !empty($arrAllMeetingLocationTemplates)) {
			return $arrAllMeetingLocationTemplates;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `meeting_location` ASC, `meeting_location_abbreviation` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY mlt.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpMeetingLocationTemplate = new MeetingLocationTemplate($database);
			$sqlOrderByColumns = $tmpMeetingLocationTemplate->constructSqlOrderByColumns($arrOrderByAttributes);

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
	mlt.*

FROM `meeting_location_templates` mlt{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `meeting_location` ASC, `meeting_location_abbreviation` ASC, `sort_order` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllMeetingLocationTemplates = array();
		while ($row = $db->fetch()) {
			$meeting_location_template_id = $row['id'];
			$meetingLocationTemplate = self::instantiateOrm($database, 'MeetingLocationTemplate', $row, null, $meeting_location_template_id);
			/* @var $meetingLocationTemplate MeetingLocationTemplate */
			$arrAllMeetingLocationTemplates[$meeting_location_template_id] = $meetingLocationTemplate;
		}

		$db->free_result();

		self::$_arrAllMeetingLocationTemplates = $arrAllMeetingLocationTemplates;

		return $arrAllMeetingLocationTemplates;
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
INTO `meeting_location_templates`
(`meeting_location`, `meeting_location_abbreviation`, `sort_order`)
VALUES (?, ?, ?)
ON DUPLICATE KEY UPDATE `meeting_location_abbreviation` = ?, `sort_order` = ?
";
		$arrValues = array($this->meeting_location, $this->meeting_location_abbreviation, $this->sort_order, $this->meeting_location_abbreviation, $this->sort_order);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$meeting_location_template_id = $db->insertId;
		$db->free_result();

		return $meeting_location_template_id;
	}

	// Save: insert ignore
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

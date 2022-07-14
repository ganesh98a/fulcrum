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
 * JobsiteBuildingActivityTemplate.
 *
 * @category   Framework
 * @package    JobsiteBuildingActivityTemplate
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class JobsiteBuildingActivityTemplate extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'JobsiteBuildingActivityTemplate';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'jobsite_building_activity_templates';

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
	 * unique index `unique_jobsite_building_activity_template` (`jobsite_activity_list_template_id`,`jobsite_building_activity_label`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_jobsite_building_activity_template' => array(
			'jobsite_activity_list_template_id' => 'int',
			'jobsite_building_activity_label' => 'string'
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
		'id' => 'jobsite_building_activity_template_id',

		'jobsite_activity_list_template_id' => 'jobsite_activity_list_template_id',

		'jobsite_building_activity_label' => 'jobsite_building_activity_label',

		'sort_order' => 'sort_order',
		'disabled_flag' => 'disabled_flag'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $jobsite_building_activity_template_id;

	public $jobsite_activity_list_template_id;

	public $jobsite_building_activity_label;

	public $sort_order;
	public $disabled_flag;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties
	public $escaped_jobsite_building_activity_label;

	// HTML ENTITY ENCODED NL2BR ORM string properties
	public $escaped_jobsite_building_activity_label_nl2br;

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)
	protected static $_arrJobsiteBuildingActivityTemplatesByJobsiteActivityListTemplateId;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllJobsiteBuildingActivityTemplates;

	// Foreign Key Objects
	private $_jobsiteActivityListTemplate;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='jobsite_building_activity_templates')
	{
		parent::__construct($table);
		$this->setDatabase($database);
	}

	// Foreign Key Object Accessor Methods
	public function getJobsiteActivityListTemplate()
	{
		if (isset($this->_jobsiteActivityListTemplate)) {
			return $this->_jobsiteActivityListTemplate;
		} else {
			return null;
		}
	}

	public function setJobsiteActivityListTemplate($jobsiteActivityListTemplate)
	{
		$this->_jobsiteActivityListTemplate = $jobsiteActivityListTemplate;
	}

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)
	public static function getArrJobsiteBuildingActivityTemplatesByJobsiteActivityListTemplateId()
	{
		if (isset(self::$_arrJobsiteBuildingActivityTemplatesByJobsiteActivityListTemplateId)) {
			return self::$_arrJobsiteBuildingActivityTemplatesByJobsiteActivityListTemplateId;
		} else {
			return null;
		}
	}

	public static function setArrJobsiteBuildingActivityTemplatesByJobsiteActivityListTemplateId($arrJobsiteBuildingActivityTemplatesByJobsiteActivityListTemplateId)
	{
		self::$_arrJobsiteBuildingActivityTemplatesByJobsiteActivityListTemplateId = $arrJobsiteBuildingActivityTemplatesByJobsiteActivityListTemplateId;
	}

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllJobsiteBuildingActivityTemplates()
	{
		if (isset(self::$_arrAllJobsiteBuildingActivityTemplates)) {
			return self::$_arrAllJobsiteBuildingActivityTemplates;
		} else {
			return null;
		}
	}

	public static function setArrAllJobsiteBuildingActivityTemplates($arrAllJobsiteBuildingActivityTemplates)
	{
		self::$_arrAllJobsiteBuildingActivityTemplates = $arrAllJobsiteBuildingActivityTemplates;
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
	 * @param int $jobsite_building_activity_template_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findById($database, $jobsite_building_activity_template_id, $table='jobsite_building_activity_templates', $module='JobsiteBuildingActivityTemplate')
	{
		$jobsiteBuildingActivityTemplate = parent::findById($database, $jobsite_building_activity_template_id, $table, $module);

		return $jobsiteBuildingActivityTemplate;
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Similar to FindById, but with SQL as starter code for more complex joins.
	 *
	 * @param string $database
	 * @param int $jobsite_building_activity_template_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findJobsiteBuildingActivityTemplateByIdExtended($database, $jobsite_building_activity_template_id)
	{
		$jobsite_building_activity_template_id = (int) $jobsite_building_activity_template_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	jbat_fk_jalt.`id` AS 'jbat_fk_jalt__jobsite_activity_list_template_id',
	jbat_fk_jalt.`user_company_id` AS 'jbat_fk_jalt__user_company_id',
	jbat_fk_jalt.`project_type_id` AS 'jbat_fk_jalt__project_type_id',
	jbat_fk_jalt.`jobsite_activity_list_template` AS 'jbat_fk_jalt__jobsite_activity_list_template',
	jbat_fk_jalt.`disabled_flag` AS 'jbat_fk_jalt__disabled_flag',
	jbat_fk_jalt.`sort_order` AS 'jbat_fk_jalt__sort_order',

	jbat.*

FROM `jobsite_building_activity_templates` jbat
	INNER JOIN `jobsite_activity_list_templates` jbat_fk_jalt ON jbat.`jobsite_activity_list_template_id` = jbat_fk_jalt.`id`
WHERE jbat.`id` = ?
";
		$arrValues = array($jobsite_building_activity_template_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$jobsite_building_activity_template_id = $row['id'];
			$jobsiteBuildingActivityTemplate = self::instantiateOrm($database, 'JobsiteBuildingActivityTemplate', $row, null, $jobsite_building_activity_template_id);
			/* @var $jobsiteBuildingActivityTemplate JobsiteBuildingActivityTemplate */
			$jobsiteBuildingActivityTemplate->convertPropertiesToData();

			if (isset($row['jobsite_activity_list_template_id'])) {
				$jobsite_activity_list_template_id = $row['jobsite_activity_list_template_id'];
				$row['jbat_fk_jalt__id'] = $jobsite_activity_list_template_id;
				$jobsiteActivityListTemplate = self::instantiateOrm($database, 'JobsiteActivityListTemplate', $row, null, $jobsite_activity_list_template_id, 'jbat_fk_jalt__');
				/* @var $jobsiteActivityListTemplate JobsiteActivityListTemplate */
				$jobsiteActivityListTemplate->convertPropertiesToData();
			} else {
				$jobsiteActivityListTemplate = false;
			}
			$jobsiteBuildingActivityTemplate->setJobsiteActivityListTemplate($jobsiteActivityListTemplate);

			return $jobsiteBuildingActivityTemplate;
		} else {
			return false;
		}
	}

	// Finders: Find By Unique Index
	/**
	 * Find by unique index `unique_jobsite_building_activity_template` (`jobsite_activity_list_template_id`,`jobsite_building_activity_label`).
	 *
	 * @param string $database
	 * @param int $jobsite_activity_list_template_id
	 * @param string $jobsite_building_activity_label
	 * @return mixed (single ORM object | false)
	 */
	public static function findByJobsiteActivityListTemplateIdAndJobsiteBuildingActivityLabel($database, $jobsite_activity_list_template_id, $jobsite_building_activity_label)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	jbat.*

FROM `jobsite_building_activity_templates` jbat
WHERE jbat.`jobsite_activity_list_template_id` = ?
AND jbat.`jobsite_building_activity_label` = ?
";
		$arrValues = array($jobsite_activity_list_template_id, $jobsite_building_activity_label);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if ($row && !empty($row)) {
			$jobsite_building_activity_template_id = $row['id'];
			$jobsiteBuildingActivityTemplate = self::instantiateOrm($database, 'JobsiteBuildingActivityTemplate', $row, null, $jobsite_building_activity_template_id);
			/* @var $jobsiteBuildingActivityTemplate JobsiteBuildingActivityTemplate */
			return $jobsiteBuildingActivityTemplate;
		} else {
			return false;
		}
	}

	// Loaders: Load By pk List (list of auto int ids or other non auto int pk list)
	/**
	 * Load zero or more records by an id list (array of auto int primary keys).
	 *
	 * @param string $database
	 * @param array $arrJobsiteBuildingActivityTemplateIds
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadJobsiteBuildingActivityTemplatesByArrJobsiteBuildingActivityTemplateIds($database, $arrJobsiteBuildingActivityTemplateIds, Input $options=null)
	{
		if (empty($arrJobsiteBuildingActivityTemplateIds)) {
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
		// ORDER BY `id` ASC, `jobsite_activity_list_template_id` ASC, `jobsite_building_activity_label` ASC, `sort_order` ASC, `disabled_flag` ASC
		$sqlOrderBy = "\nORDER BY jbat.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsiteBuildingActivityTemplate = new JobsiteBuildingActivityTemplate($database);
			$sqlOrderByColumns = $tmpJobsiteBuildingActivityTemplate->constructSqlOrderByColumns($arrOrderByAttributes);

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

		foreach ($arrJobsiteBuildingActivityTemplateIds as $k => $jobsite_building_activity_template_id) {
			$jobsite_building_activity_template_id = (int) $jobsite_building_activity_template_id;
			$arrJobsiteBuildingActivityTemplateIds[$k] = $db->escape($jobsite_building_activity_template_id);
		}
		$csvJobsiteBuildingActivityTemplateIds = join(',', $arrJobsiteBuildingActivityTemplateIds);

		$query =
"
SELECT

	jbat.*

FROM `jobsite_building_activity_templates` jbat
WHERE jbat.`id` IN ($csvJobsiteBuildingActivityTemplateIds){$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		//$row = $db->fetch();
		//$db->free_result();

		$arrJobsiteBuildingActivityTemplatesByCsvJobsiteBuildingActivityTemplateIds = array();
		while ($row = $db->fetch()) {
			$jobsite_building_activity_template_id = $row['id'];
			$jobsiteBuildingActivityTemplate = self::instantiateOrm($database, 'JobsiteBuildingActivityTemplate', $row, null, $jobsite_building_activity_template_id);
			/* @var $jobsiteBuildingActivityTemplate JobsiteBuildingActivityTemplate */
			$jobsiteBuildingActivityTemplate->convertPropertiesToData();

			$arrJobsiteBuildingActivityTemplatesByCsvJobsiteBuildingActivityTemplateIds[$jobsite_building_activity_template_id] = $jobsiteBuildingActivityTemplate;
		}

		$db->free_result();

		return $arrJobsiteBuildingActivityTemplatesByCsvJobsiteBuildingActivityTemplateIds;
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `jobsite_building_activity_templates_fk_jalt` foreign key (`jobsite_activity_list_template_id`) references `jobsite_activity_list_templates` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $jobsite_activity_list_template_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadJobsiteBuildingActivityTemplatesByJobsiteActivityListTemplateId($database, $jobsite_activity_list_template_id, Input $options=null)
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
			self::$_arrJobsiteBuildingActivityTemplatesByJobsiteActivityListTemplateId = null;
		}

		$arrJobsiteBuildingActivityTemplatesByJobsiteActivityListTemplateId = self::$_arrJobsiteBuildingActivityTemplatesByJobsiteActivityListTemplateId;
		if (isset($arrJobsiteBuildingActivityTemplatesByJobsiteActivityListTemplateId) && !empty($arrJobsiteBuildingActivityTemplatesByJobsiteActivityListTemplateId)) {
			return $arrJobsiteBuildingActivityTemplatesByJobsiteActivityListTemplateId;
		}

		$jobsite_activity_list_template_id = (int) $jobsite_activity_list_template_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `jobsite_activity_list_template_id` ASC, `jobsite_building_activity_label` ASC, `sort_order` ASC, `disabled_flag` ASC
		$sqlOrderBy = "\nORDER BY jbat.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsiteBuildingActivityTemplate = new JobsiteBuildingActivityTemplate($database);
			$sqlOrderByColumns = $tmpJobsiteBuildingActivityTemplate->constructSqlOrderByColumns($arrOrderByAttributes);

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
	jbat.*

FROM `jobsite_building_activity_templates` jbat
WHERE jbat.`jobsite_activity_list_template_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `jobsite_activity_list_template_id` ASC, `jobsite_building_activity_label` ASC, `sort_order` ASC, `disabled_flag` ASC
		$arrValues = array($jobsite_activity_list_template_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrJobsiteBuildingActivityTemplatesByJobsiteActivityListTemplateId = array();
		while ($row = $db->fetch()) {
			$jobsite_building_activity_template_id = $row['id'];
			$jobsiteBuildingActivityTemplate = self::instantiateOrm($database, 'JobsiteBuildingActivityTemplate', $row, null, $jobsite_building_activity_template_id);
			/* @var $jobsiteBuildingActivityTemplate JobsiteBuildingActivityTemplate */
			$arrJobsiteBuildingActivityTemplatesByJobsiteActivityListTemplateId[$jobsite_building_activity_template_id] = $jobsiteBuildingActivityTemplate;
		}

		$db->free_result();

		self::$_arrJobsiteBuildingActivityTemplatesByJobsiteActivityListTemplateId = $arrJobsiteBuildingActivityTemplatesByJobsiteActivityListTemplateId;

		return $arrJobsiteBuildingActivityTemplatesByJobsiteActivityListTemplateId;
	}

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all jobsite_building_activity_templates records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllJobsiteBuildingActivityTemplates($database, Input $options=null)
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
			self::$_arrAllJobsiteBuildingActivityTemplates = null;
		}

		$arrAllJobsiteBuildingActivityTemplates = self::$_arrAllJobsiteBuildingActivityTemplates;
		if (isset($arrAllJobsiteBuildingActivityTemplates) && !empty($arrAllJobsiteBuildingActivityTemplates)) {
			return $arrAllJobsiteBuildingActivityTemplates;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `jobsite_activity_list_template_id` ASC, `jobsite_building_activity_label` ASC, `sort_order` ASC, `disabled_flag` ASC
		$sqlOrderBy = "\nORDER BY jbat.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsiteBuildingActivityTemplate = new JobsiteBuildingActivityTemplate($database);
			$sqlOrderByColumns = $tmpJobsiteBuildingActivityTemplate->constructSqlOrderByColumns($arrOrderByAttributes);

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
	jbat.*

FROM `jobsite_building_activity_templates` jbat{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `jobsite_activity_list_template_id` ASC, `jobsite_building_activity_label` ASC, `sort_order` ASC, `disabled_flag` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllJobsiteBuildingActivityTemplates = array();
		while ($row = $db->fetch()) {
			$jobsite_building_activity_template_id = $row['id'];
			$jobsiteBuildingActivityTemplate = self::instantiateOrm($database, 'JobsiteBuildingActivityTemplate', $row, null, $jobsite_building_activity_template_id);
			/* @var $jobsiteBuildingActivityTemplate JobsiteBuildingActivityTemplate */
			$arrAllJobsiteBuildingActivityTemplates[$jobsite_building_activity_template_id] = $jobsiteBuildingActivityTemplate;
		}

		$db->free_result();

		self::$_arrAllJobsiteBuildingActivityTemplates = $arrAllJobsiteBuildingActivityTemplates;

		return $arrAllJobsiteBuildingActivityTemplates;
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
INTO `jobsite_building_activity_templates`
(`jobsite_activity_list_template_id`, `jobsite_building_activity_label`, `sort_order`, `disabled_flag`)
VALUES (?, ?, ?, ?)
ON DUPLICATE KEY UPDATE `sort_order` = ?, `disabled_flag` = ?
";
		$arrValues = array($this->jobsite_activity_list_template_id, $this->jobsite_building_activity_label, $this->sort_order, $this->disabled_flag, $this->sort_order, $this->disabled_flag);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$jobsite_building_activity_template_id = $db->insertId;
		$db->free_result();

		return $jobsite_building_activity_template_id;
	}

	// Save: insert ignore
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

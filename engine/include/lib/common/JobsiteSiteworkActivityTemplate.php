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
 * JobsiteSiteworkActivityTemplate.
 *
 * @category   Framework
 * @package    JobsiteSiteworkActivityTemplate
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class JobsiteSiteworkActivityTemplate extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'JobsiteSiteworkActivityTemplate';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'jobsite_sitework_activity_templates';

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
	 * unique index `unique_jobsite_sitework_activity_template` (`jobsite_activity_list_template_id`,`jobsite_sitework_activity_label`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_jobsite_sitework_activity_template' => array(
			'jobsite_activity_list_template_id' => 'int',
			'jobsite_sitework_activity_label' => 'string'
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
		'id' => 'jobsite_sitework_activity_template_id',

		'jobsite_activity_list_template_id' => 'jobsite_activity_list_template_id',

		'jobsite_sitework_activity_label' => 'jobsite_sitework_activity_label',

		'sort_order' => 'sort_order',
		'disabled_flag' => 'disabled_flag'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $jobsite_sitework_activity_template_id;

	public $jobsite_activity_list_template_id;

	public $jobsite_sitework_activity_label;

	public $sort_order;
	public $disabled_flag;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties
	public $escaped_jobsite_sitework_activity_label;

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)
	protected static $_arrJobsiteSiteworkActivityTemplatesByJobsiteActivityListTemplateId;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllJobsiteSiteworkActivityTemplates;

	// Foreign Key Objects
	private $_jobsiteActivityListTemplate;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='jobsite_sitework_activity_templates')
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
	public static function getArrJobsiteSiteworkActivityTemplatesByJobsiteActivityListTemplateId()
	{
		if (isset(self::$_arrJobsiteSiteworkActivityTemplatesByJobsiteActivityListTemplateId)) {
			return self::$_arrJobsiteSiteworkActivityTemplatesByJobsiteActivityListTemplateId;
		} else {
			return null;
		}
	}

	public static function setArrJobsiteSiteworkActivityTemplatesByJobsiteActivityListTemplateId($arrJobsiteSiteworkActivityTemplatesByJobsiteActivityListTemplateId)
	{
		self::$_arrJobsiteSiteworkActivityTemplatesByJobsiteActivityListTemplateId = $arrJobsiteSiteworkActivityTemplatesByJobsiteActivityListTemplateId;
	}

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllJobsiteSiteworkActivityTemplates()
	{
		if (isset(self::$_arrAllJobsiteSiteworkActivityTemplates)) {
			return self::$_arrAllJobsiteSiteworkActivityTemplates;
		} else {
			return null;
		}
	}

	public static function setArrAllJobsiteSiteworkActivityTemplates($arrAllJobsiteSiteworkActivityTemplates)
	{
		self::$_arrAllJobsiteSiteworkActivityTemplates = $arrAllJobsiteSiteworkActivityTemplates;
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
	 * @param int $jobsite_sitework_activity_template_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findById($database, $jobsite_sitework_activity_template_id, $table='jobsite_sitework_activity_templates', $module='JobsiteSiteworkActivityTemplate')
	{
		$jobsiteSiteworkActivityTemplate = parent::findById($database, $jobsite_sitework_activity_template_id, $table, $module);

		return $jobsiteSiteworkActivityTemplate;
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Similar to FindById, but with SQL as starter code for more complex joins.
	 *
	 * @param string $database
	 * @param int $jobsite_sitework_activity_template_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findJobsiteSiteworkActivityTemplateByIdExtended($database, $jobsite_sitework_activity_template_id)
	{
		$jobsite_sitework_activity_template_id = (int) $jobsite_sitework_activity_template_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	jsat_fk_jalt.`id` AS 'jsat_fk_jalt__jobsite_activity_list_template_id',
	jsat_fk_jalt.`user_company_id` AS 'jsat_fk_jalt__user_company_id',
	jsat_fk_jalt.`project_type_id` AS 'jsat_fk_jalt__project_type_id',
	jsat_fk_jalt.`jobsite_activity_list_template` AS 'jsat_fk_jalt__jobsite_activity_list_template',
	jsat_fk_jalt.`disabled_flag` AS 'jsat_fk_jalt__disabled_flag',
	jsat_fk_jalt.`sort_order` AS 'jsat_fk_jalt__sort_order',

	jsat.*

FROM `jobsite_sitework_activity_templates` jsat
	INNER JOIN `jobsite_activity_list_templates` jsat_fk_jalt ON jsat.`jobsite_activity_list_template_id` = jsat_fk_jalt.`id`
WHERE jsat.`id` = ?
";
		$arrValues = array($jobsite_sitework_activity_template_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$jobsite_sitework_activity_template_id = $row['id'];
			$jobsiteSiteworkActivityTemplate = self::instantiateOrm($database, 'JobsiteSiteworkActivityTemplate', $row, null, $jobsite_sitework_activity_template_id);
			/* @var $jobsiteSiteworkActivityTemplate JobsiteSiteworkActivityTemplate */
			$jobsiteSiteworkActivityTemplate->convertPropertiesToData();

			if (isset($row['jobsite_activity_list_template_id'])) {
				$jobsite_activity_list_template_id = $row['jobsite_activity_list_template_id'];
				$row['jsat_fk_jalt__id'] = $jobsite_activity_list_template_id;
				$jobsiteActivityListTemplate = self::instantiateOrm($database, 'JobsiteActivityListTemplate', $row, null, $jobsite_activity_list_template_id, 'jsat_fk_jalt__');
				/* @var $jobsiteActivityListTemplate JobsiteActivityListTemplate */
				$jobsiteActivityListTemplate->convertPropertiesToData();
			} else {
				$jobsiteActivityListTemplate = false;
			}
			$jobsiteSiteworkActivityTemplate->setJobsiteActivityListTemplate($jobsiteActivityListTemplate);

			return $jobsiteSiteworkActivityTemplate;
		} else {
			return false;
		}
	}

	// Finders: Find By Unique Index
	/**
	 * Find by unique index `unique_jobsite_sitework_activity_template` (`jobsite_activity_list_template_id`,`jobsite_sitework_activity_label`).
	 *
	 * @param string $database
	 * @param int $jobsite_activity_list_template_id
	 * @param string $jobsite_sitework_activity_label
	 * @return mixed (single ORM object | false)
	 */
	public static function findByJobsiteActivityListTemplateIdAndJobsiteSiteworkActivityLabel($database, $jobsite_activity_list_template_id, $jobsite_sitework_activity_label)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	jsat.*

FROM `jobsite_sitework_activity_templates` jsat
WHERE jsat.`jobsite_activity_list_template_id` = ?
AND jsat.`jobsite_sitework_activity_label` = ?
";
		$arrValues = array($jobsite_activity_list_template_id, $jobsite_sitework_activity_label);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if ($row && !empty($row)) {
			$jobsite_sitework_activity_template_id = $row['id'];
			$jobsiteSiteworkActivityTemplate = self::instantiateOrm($database, 'JobsiteSiteworkActivityTemplate', $row, null, $jobsite_sitework_activity_template_id);
			/* @var $jobsiteSiteworkActivityTemplate JobsiteSiteworkActivityTemplate */
			return $jobsiteSiteworkActivityTemplate;
		} else {
			return false;
		}
	}

	// Loaders: Load By pk List (list of auto int ids or other non auto int pk list)
	/**
	 * Load zero or more records by an id list (array of auto int primary keys).
	 *
	 * @param string $database
	 * @param array $arrJobsiteSiteworkActivityTemplateIds
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadJobsiteSiteworkActivityTemplatesByArrJobsiteSiteworkActivityTemplateIds($database, $arrJobsiteSiteworkActivityTemplateIds, Input $options=null)
	{
		if (empty($arrJobsiteSiteworkActivityTemplateIds)) {
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
		// ORDER BY `id` ASC, `jobsite_activity_list_template_id` ASC, `jobsite_sitework_activity_label` ASC, `sort_order` ASC, `disabled_flag` ASC
		$sqlOrderBy = "\nORDER BY jsat.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsiteSiteworkActivityTemplate = new JobsiteSiteworkActivityTemplate($database);
			$sqlOrderByColumns = $tmpJobsiteSiteworkActivityTemplate->constructSqlOrderByColumns($arrOrderByAttributes);

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

		foreach ($arrJobsiteSiteworkActivityTemplateIds as $k => $jobsite_sitework_activity_template_id) {
			$jobsite_sitework_activity_template_id = (int) $jobsite_sitework_activity_template_id;
			$arrJobsiteSiteworkActivityTemplateIds[$k] = $db->escape($jobsite_sitework_activity_template_id);
		}
		$csvJobsiteSiteworkActivityTemplateIds = join(',', $arrJobsiteSiteworkActivityTemplateIds);

		$query =
"
SELECT

	jsat.*

FROM `jobsite_sitework_activity_templates` jsat
WHERE jsat.`id` IN ($csvJobsiteSiteworkActivityTemplateIds){$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrJobsiteSiteworkActivityTemplatesByCsvJobsiteSiteworkActivityTemplateIds = array();
		while ($row = $db->fetch()) {
			$jobsite_sitework_activity_template_id = $row['id'];
			$jobsiteSiteworkActivityTemplate = self::instantiateOrm($database, 'JobsiteSiteworkActivityTemplate', $row, null, $jobsite_sitework_activity_template_id);
			/* @var $jobsiteSiteworkActivityTemplate JobsiteSiteworkActivityTemplate */
			$jobsiteSiteworkActivityTemplate->convertPropertiesToData();

			$arrJobsiteSiteworkActivityTemplatesByCsvJobsiteSiteworkActivityTemplateIds[$jobsite_sitework_activity_template_id] = $jobsiteSiteworkActivityTemplate;
		}

		$db->free_result();

		return $arrJobsiteSiteworkActivityTemplatesByCsvJobsiteSiteworkActivityTemplateIds;
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `jobsite_sitework_activity_templates_fk_jalt` foreign key (`jobsite_activity_list_template_id`) references `jobsite_activity_list_templates` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $jobsite_activity_list_template_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadJobsiteSiteworkActivityTemplatesByJobsiteActivityListTemplateId($database, $jobsite_activity_list_template_id, Input $options=null)
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
			self::$_arrJobsiteSiteworkActivityTemplatesByJobsiteActivityListTemplateId = null;
		}

		$arrJobsiteSiteworkActivityTemplatesByJobsiteActivityListTemplateId = self::$_arrJobsiteSiteworkActivityTemplatesByJobsiteActivityListTemplateId;
		if (isset($arrJobsiteSiteworkActivityTemplatesByJobsiteActivityListTemplateId) && !empty($arrJobsiteSiteworkActivityTemplatesByJobsiteActivityListTemplateId)) {
			return $arrJobsiteSiteworkActivityTemplatesByJobsiteActivityListTemplateId;
		}

		$jobsite_activity_list_template_id = (int) $jobsite_activity_list_template_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `jobsite_activity_list_template_id` ASC, `jobsite_sitework_activity_label` ASC, `sort_order` ASC, `disabled_flag` ASC
		$sqlOrderBy = "\nORDER BY jsat.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsiteSiteworkActivityTemplate = new JobsiteSiteworkActivityTemplate($database);
			$sqlOrderByColumns = $tmpJobsiteSiteworkActivityTemplate->constructSqlOrderByColumns($arrOrderByAttributes);

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
	jsat.*

FROM `jobsite_sitework_activity_templates` jsat
WHERE jsat.`jobsite_activity_list_template_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `jobsite_activity_list_template_id` ASC, `jobsite_sitework_activity_label` ASC, `sort_order` ASC, `disabled_flag` ASC
		$arrValues = array($jobsite_activity_list_template_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrJobsiteSiteworkActivityTemplatesByJobsiteActivityListTemplateId = array();
		while ($row = $db->fetch()) {
			$jobsite_sitework_activity_template_id = $row['id'];
			$jobsiteSiteworkActivityTemplate = self::instantiateOrm($database, 'JobsiteSiteworkActivityTemplate', $row, null, $jobsite_sitework_activity_template_id);
			/* @var $jobsiteSiteworkActivityTemplate JobsiteSiteworkActivityTemplate */
			$arrJobsiteSiteworkActivityTemplatesByJobsiteActivityListTemplateId[$jobsite_sitework_activity_template_id] = $jobsiteSiteworkActivityTemplate;
		}

		$db->free_result();

		self::$_arrJobsiteSiteworkActivityTemplatesByJobsiteActivityListTemplateId = $arrJobsiteSiteworkActivityTemplatesByJobsiteActivityListTemplateId;

		return $arrJobsiteSiteworkActivityTemplatesByJobsiteActivityListTemplateId;
	}

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all jobsite_sitework_activity_templates records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllJobsiteSiteworkActivityTemplates($database, Input $options=null)
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
			self::$_arrAllJobsiteSiteworkActivityTemplates = null;
		}

		$arrAllJobsiteSiteworkActivityTemplates = self::$_arrAllJobsiteSiteworkActivityTemplates;
		if (isset($arrAllJobsiteSiteworkActivityTemplates) && !empty($arrAllJobsiteSiteworkActivityTemplates)) {
			return $arrAllJobsiteSiteworkActivityTemplates;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `jobsite_activity_list_template_id` ASC, `jobsite_sitework_activity_label` ASC, `sort_order` ASC, `disabled_flag` ASC
		$sqlOrderBy = "\nORDER BY jsat.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsiteSiteworkActivityTemplate = new JobsiteSiteworkActivityTemplate($database);
			$sqlOrderByColumns = $tmpJobsiteSiteworkActivityTemplate->constructSqlOrderByColumns($arrOrderByAttributes);

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
	jsat.*

FROM `jobsite_sitework_activity_templates` jsat{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `jobsite_activity_list_template_id` ASC, `jobsite_sitework_activity_label` ASC, `sort_order` ASC, `disabled_flag` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllJobsiteSiteworkActivityTemplates = array();
		while ($row = $db->fetch()) {
			$jobsite_sitework_activity_template_id = $row['id'];
			$jobsiteSiteworkActivityTemplate = self::instantiateOrm($database, 'JobsiteSiteworkActivityTemplate', $row, null, $jobsite_sitework_activity_template_id);
			/* @var $jobsiteSiteworkActivityTemplate JobsiteSiteworkActivityTemplate */
			$arrAllJobsiteSiteworkActivityTemplates[$jobsite_sitework_activity_template_id] = $jobsiteSiteworkActivityTemplate;
		}

		$db->free_result();

		self::$_arrAllJobsiteSiteworkActivityTemplates = $arrAllJobsiteSiteworkActivityTemplates;

		return $arrAllJobsiteSiteworkActivityTemplates;
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
INTO `jobsite_sitework_activity_templates`
(`jobsite_activity_list_template_id`, `jobsite_sitework_activity_label`, `sort_order`, `disabled_flag`)
VALUES (?, ?, ?, ?)
ON DUPLICATE KEY UPDATE `sort_order` = ?, `disabled_flag` = ?
";
		$arrValues = array($this->jobsite_activity_list_template_id, $this->jobsite_sitework_activity_label, $this->sort_order, $this->disabled_flag, $this->sort_order, $this->disabled_flag);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$jobsite_sitework_activity_template_id = $db->insertId;
		$db->free_result();

		return $jobsite_sitework_activity_template_id;
	}

	// Save: insert ignore
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

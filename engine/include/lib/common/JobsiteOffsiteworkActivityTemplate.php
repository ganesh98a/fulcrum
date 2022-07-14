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
 * JobsiteOffsiteworkActivityTemplate.
 *
 * @category   Framework
 * @package    JobsiteOffsiteworkActivityTemplate
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class JobsiteOffsiteworkActivityTemplate extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'JobsiteOffsiteworkActivityTemplate';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'jobsite_offsitework_activity_templates';

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
	 * unique index `unique_jobsite_offsitework_activity_template` (`jobsite_activity_list_template_id`,`jobsite_offsitework_activity_label`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_jobsite_offsitework_activity_template' => array(
			'jobsite_activity_list_template_id' => 'int',
			'jobsite_offsitework_activity_label' => 'string'
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
		'id' => 'jobsite_offsitework_activity_template_id',

		'jobsite_activity_list_template_id' => 'jobsite_activity_list_template_id',

		'jobsite_offsitework_activity_label' => 'jobsite_offsitework_activity_label',

		'sort_order' => 'sort_order',
		'disabled_flag' => 'disabled_flag'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $jobsite_offsitework_activity_template_id;

	public $jobsite_activity_list_template_id;

	public $jobsite_offsitework_activity_label;

	public $sort_order;
	public $disabled_flag;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties
	public $escaped_jobsite_offsitework_activity_label;

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)
	protected static $_arrJobsiteOffsiteworkActivityTemplatesByJobsiteActivityListTemplateId;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllJobsiteOffsiteworkActivityTemplates;

	// Foreign Key Objects
	private $_jobsiteActivityListTemplate;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='jobsite_offsitework_activity_templates')
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
	public static function getArrJobsiteOffsiteworkActivityTemplatesByJobsiteActivityListTemplateId()
	{
		if (isset(self::$_arrJobsiteOffsiteworkActivityTemplatesByJobsiteActivityListTemplateId)) {
			return self::$_arrJobsiteOffsiteworkActivityTemplatesByJobsiteActivityListTemplateId;
		} else {
			return null;
		}
	}

	public static function setArrJobsiteOffsiteworkActivityTemplatesByJobsiteActivityListTemplateId($arrJobsiteOffsiteworkActivityTemplatesByJobsiteActivityListTemplateId)
	{
		self::$_arrJobsiteOffsiteworkActivityTemplatesByJobsiteActivityListTemplateId = $arrJobsiteOffsiteworkActivityTemplatesByJobsiteActivityListTemplateId;
	}

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllJobsiteOffsiteworkActivityTemplates()
	{
		if (isset(self::$_arrAllJobsiteOffsiteworkActivityTemplates)) {
			return self::$_arrAllJobsiteOffsiteworkActivityTemplates;
		} else {
			return null;
		}
	}

	public static function setArrAllJobsiteOffsiteworkActivityTemplates($arrAllJobsiteOffsiteworkActivityTemplates)
	{
		self::$_arrAllJobsiteOffsiteworkActivityTemplates = $arrAllJobsiteOffsiteworkActivityTemplates;
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
	 * @param int $jobsite_offsitework_activity_template_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findById($database, $jobsite_offsitework_activity_template_id, $table='jobsite_offsitework_activity_templates', $module='JobsiteOffsiteworkActivityTemplate')
	{
		$jobsiteOffsiteworkActivityTemplate = parent::findById($database, $jobsite_offsitework_activity_template_id, $table, $module);

		return $jobsiteOffsiteworkActivityTemplate;
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Similar to FindById, but with SQL as starter code for more complex joins.
	 *
	 * @param string $database
	 * @param int $jobsite_offsitework_activity_template_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findJobsiteOffsiteworkActivityTemplateByIdExtended($database, $jobsite_offsitework_activity_template_id)
	{
		$jobsite_offsitework_activity_template_id = (int) $jobsite_offsitework_activity_template_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	joat_fk_jalt.`id` AS 'joat_fk_jalt__jobsite_activity_list_template_id',
	joat_fk_jalt.`user_company_id` AS 'joat_fk_jalt__user_company_id',
	joat_fk_jalt.`project_type_id` AS 'joat_fk_jalt__project_type_id',
	joat_fk_jalt.`jobsite_activity_list_template` AS 'joat_fk_jalt__jobsite_activity_list_template',
	joat_fk_jalt.`disabled_flag` AS 'joat_fk_jalt__disabled_flag',
	joat_fk_jalt.`sort_order` AS 'joat_fk_jalt__sort_order',

	joat.*

FROM `jobsite_offsitework_activity_templates` joat
	INNER JOIN `jobsite_activity_list_templates` joat_fk_jalt ON joat.`jobsite_activity_list_template_id` = joat_fk_jalt.`id`
WHERE joat.`id` = ?
";
		$arrValues = array($jobsite_offsitework_activity_template_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$jobsite_offsitework_activity_template_id = $row['id'];
			$jobsiteOffsiteworkActivityTemplate = self::instantiateOrm($database, 'JobsiteOffsiteworkActivityTemplate', $row, null, $jobsite_offsitework_activity_template_id);
			/* @var $jobsiteOffsiteworkActivityTemplate JobsiteOffsiteworkActivityTemplate */
			$jobsiteOffsiteworkActivityTemplate->convertPropertiesToData();

			if (isset($row['jobsite_activity_list_template_id'])) {
				$jobsite_activity_list_template_id = $row['jobsite_activity_list_template_id'];
				$row['joat_fk_jalt__id'] = $jobsite_activity_list_template_id;
				$jobsiteActivityListTemplate = self::instantiateOrm($database, 'JobsiteActivityListTemplate', $row, null, $jobsite_activity_list_template_id, 'joat_fk_jalt__');
				/* @var $jobsiteActivityListTemplate JobsiteActivityListTemplate */
				$jobsiteActivityListTemplate->convertPropertiesToData();
			} else {
				$jobsiteActivityListTemplate = false;
			}
			$jobsiteOffsiteworkActivityTemplate->setJobsiteActivityListTemplate($jobsiteActivityListTemplate);

			return $jobsiteOffsiteworkActivityTemplate;
		} else {
			return false;
		}
	}

	// Finders: Find By Unique Index
	/**
	 * Find by unique index `unique_jobsite_offsitework_activity_template` (`jobsite_activity_list_template_id`,`jobsite_offsitework_activity_label`).
	 *
	 * @param string $database
	 * @param int $jobsite_activity_list_template_id
	 * @param string $jobsite_offsitework_activity_label
	 * @return mixed (single ORM object | false)
	 */
	public static function findByJobsiteActivityListTemplateIdAndJobsiteOffsiteworkActivityLabel($database, $jobsite_activity_list_template_id, $jobsite_offsitework_activity_label)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	joat.*

FROM `jobsite_offsitework_activity_templates` joat
WHERE joat.`jobsite_activity_list_template_id` = ?
AND joat.`jobsite_offsitework_activity_label` = ?
";
		$arrValues = array($jobsite_activity_list_template_id, $jobsite_offsitework_activity_label);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if ($row && !empty($row)) {
			$jobsite_offsitework_activity_template_id = $row['id'];
			$jobsiteOffsiteworkActivityTemplate = self::instantiateOrm($database, 'JobsiteOffsiteworkActivityTemplate', $row, null, $jobsite_offsitework_activity_template_id);
			/* @var $jobsiteOffsiteworkActivityTemplate JobsiteOffsiteworkActivityTemplate */
			return $jobsiteOffsiteworkActivityTemplate;
		} else {
			return false;
		}
	}

	// Loaders: Load By pk List (list of auto int ids or other non auto int pk list)
	/**
	 * Load zero or more records by an id list (array of auto int primary keys).
	 *
	 * @param string $database
	 * @param array $arrJobsiteOffsiteworkActivityTemplateIds
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadJobsiteOffsiteworkActivityTemplatesByArrJobsiteOffsiteworkActivityTemplateIds($database, $arrJobsiteOffsiteworkActivityTemplateIds, Input $options=null)
	{
		if (empty($arrJobsiteOffsiteworkActivityTemplateIds)) {
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
		// ORDER BY `id` ASC, `jobsite_activity_list_template_id` ASC, `jobsite_offsitework_activity_label` ASC, `sort_order` ASC, `disabled_flag` ASC
		$sqlOrderBy = "\nORDER BY joat.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsiteOffsiteworkActivityTemplate = new JobsiteOffsiteworkActivityTemplate($database);
			$sqlOrderByColumns = $tmpJobsiteOffsiteworkActivityTemplate->constructSqlOrderByColumns($arrOrderByAttributes);

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

		foreach ($arrJobsiteOffsiteworkActivityTemplateIds as $k => $jobsite_offsitework_activity_template_id) {
			$jobsite_offsitework_activity_template_id = (int) $jobsite_offsitework_activity_template_id;
			$arrJobsiteOffsiteworkActivityTemplateIds[$k] = $db->escape($jobsite_offsitework_activity_template_id);
		}
		$csvJobsiteOffsiteworkActivityTemplateIds = join(',', $arrJobsiteOffsiteworkActivityTemplateIds);

		$query =
"
SELECT

	joat.*

FROM `jobsite_offsitework_activity_templates` joat
WHERE joat.`id` IN ($csvJobsiteOffsiteworkActivityTemplateIds){$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		$arrJobsiteOffsiteworkActivityTemplatesByCsvJobsiteOffsiteworkActivityTemplateIds = array();
		while ($row = $db->fetch()) {
			$jobsite_offsitework_activity_template_id = $row['id'];
			$jobsiteOffsiteworkActivityTemplate = self::instantiateOrm($database, 'JobsiteOffsiteworkActivityTemplate', $row, null, $jobsite_offsitework_activity_template_id);
			/* @var $jobsiteOffsiteworkActivityTemplate JobsiteOffsiteworkActivityTemplate */
			$jobsiteOffsiteworkActivityTemplate->convertPropertiesToData();

			$arrJobsiteOffsiteworkActivityTemplatesByCsvJobsiteOffsiteworkActivityTemplateIds[$jobsite_offsitework_activity_template_id] = $jobsiteOffsiteworkActivityTemplate;
		}

		$db->free_result();

		return $arrJobsiteOffsiteworkActivityTemplatesByCsvJobsiteOffsiteworkActivityTemplateIds;
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `jobsite_offsitework_activity_templates_fk_jalt` foreign key (`jobsite_activity_list_template_id`) references `jobsite_activity_list_templates` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $jobsite_activity_list_template_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadJobsiteOffsiteworkActivityTemplatesByJobsiteActivityListTemplateId($database, $jobsite_activity_list_template_id, Input $options=null)
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
			self::$_arrJobsiteOffsiteworkActivityTemplatesByJobsiteActivityListTemplateId = null;
		}

		$arrJobsiteOffsiteworkActivityTemplatesByJobsiteActivityListTemplateId = self::$_arrJobsiteOffsiteworkActivityTemplatesByJobsiteActivityListTemplateId;
		if (isset($arrJobsiteOffsiteworkActivityTemplatesByJobsiteActivityListTemplateId) && !empty($arrJobsiteOffsiteworkActivityTemplatesByJobsiteActivityListTemplateId)) {
			return $arrJobsiteOffsiteworkActivityTemplatesByJobsiteActivityListTemplateId;
		}

		$jobsite_activity_list_template_id = (int) $jobsite_activity_list_template_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `jobsite_activity_list_template_id` ASC, `jobsite_offsitework_activity_label` ASC, `sort_order` ASC, `disabled_flag` ASC
		$sqlOrderBy = "\nORDER BY joat.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsiteOffsiteworkActivityTemplate = new JobsiteOffsiteworkActivityTemplate($database);
			$sqlOrderByColumns = $tmpJobsiteOffsiteworkActivityTemplate->constructSqlOrderByColumns($arrOrderByAttributes);

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
	joat.*

FROM `jobsite_offsitework_activity_templates` joat
WHERE joat.`jobsite_activity_list_template_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `jobsite_activity_list_template_id` ASC, `jobsite_offsitework_activity_label` ASC, `sort_order` ASC, `disabled_flag` ASC
		$arrValues = array($jobsite_activity_list_template_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrJobsiteOffsiteworkActivityTemplatesByJobsiteActivityListTemplateId = array();
		while ($row = $db->fetch()) {
			$jobsite_offsitework_activity_template_id = $row['id'];
			$jobsiteOffsiteworkActivityTemplate = self::instantiateOrm($database, 'JobsiteOffsiteworkActivityTemplate', $row, null, $jobsite_offsitework_activity_template_id);
			/* @var $jobsiteOffsiteworkActivityTemplate JobsiteOffsiteworkActivityTemplate */
			$arrJobsiteOffsiteworkActivityTemplatesByJobsiteActivityListTemplateId[$jobsite_offsitework_activity_template_id] = $jobsiteOffsiteworkActivityTemplate;
		}

		$db->free_result();

		self::$_arrJobsiteOffsiteworkActivityTemplatesByJobsiteActivityListTemplateId = $arrJobsiteOffsiteworkActivityTemplatesByJobsiteActivityListTemplateId;

		return $arrJobsiteOffsiteworkActivityTemplatesByJobsiteActivityListTemplateId;
	}

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all jobsite_offsitework_activity_templates records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllJobsiteOffsiteworkActivityTemplates($database, Input $options=null)
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
			self::$_arrAllJobsiteOffsiteworkActivityTemplates = null;
		}

		$arrAllJobsiteOffsiteworkActivityTemplates = self::$_arrAllJobsiteOffsiteworkActivityTemplates;
		if (isset($arrAllJobsiteOffsiteworkActivityTemplates) && !empty($arrAllJobsiteOffsiteworkActivityTemplates)) {
			return $arrAllJobsiteOffsiteworkActivityTemplates;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `jobsite_activity_list_template_id` ASC, `jobsite_offsitework_activity_label` ASC, `sort_order` ASC, `disabled_flag` ASC
		$sqlOrderBy = "\nORDER BY joat.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsiteOffsiteworkActivityTemplate = new JobsiteOffsiteworkActivityTemplate($database);
			$sqlOrderByColumns = $tmpJobsiteOffsiteworkActivityTemplate->constructSqlOrderByColumns($arrOrderByAttributes);

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
	joat.*

FROM `jobsite_offsitework_activity_templates` joat{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `jobsite_activity_list_template_id` ASC, `jobsite_offsitework_activity_label` ASC, `sort_order` ASC, `disabled_flag` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllJobsiteOffsiteworkActivityTemplates = array();
		while ($row = $db->fetch()) {
			$jobsite_offsitework_activity_template_id = $row['id'];
			$jobsiteOffsiteworkActivityTemplate = self::instantiateOrm($database, 'JobsiteOffsiteworkActivityTemplate', $row, null, $jobsite_offsitework_activity_template_id);
			/* @var $jobsiteOffsiteworkActivityTemplate JobsiteOffsiteworkActivityTemplate */
			$arrAllJobsiteOffsiteworkActivityTemplates[$jobsite_offsitework_activity_template_id] = $jobsiteOffsiteworkActivityTemplate;
		}

		$db->free_result();

		self::$_arrAllJobsiteOffsiteworkActivityTemplates = $arrAllJobsiteOffsiteworkActivityTemplates;

		return $arrAllJobsiteOffsiteworkActivityTemplates;
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
INTO `jobsite_offsitework_activity_templates`
(`jobsite_activity_list_template_id`, `jobsite_offsitework_activity_label`, `sort_order`, `disabled_flag`)
VALUES (?, ?, ?, ?)
ON DUPLICATE KEY UPDATE `sort_order` = ?, `disabled_flag` = ?
";
		$arrValues = array($this->jobsite_activity_list_template_id, $this->jobsite_offsitework_activity_label, $this->sort_order, $this->disabled_flag, $this->sort_order, $this->disabled_flag);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$jobsite_offsitework_activity_template_id = $db->insertId;
		$db->free_result();

		return $jobsite_offsitework_activity_template_id;
	}

	// Save: insert ignore

	public static function loadJobsiteOffsiteworkActivityTemplatesByCsvJobsiteOffsiteworkActivityTemplateIds($database, $csvJobsiteOffsiteworkActivityTemplateIds, Input $options=null)
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

		/*
		if ($forceLoadFlag) {
			self::$_arrJobsiteOffsiteworkActivityTemplatesByCsvJobsiteOffsiteworkActivityTemplateIds = null;
		}

		$arrJobsiteOffsiteworkActivityTemplatesByJobsiteActivityListTemplateId = self::$_arrJobsiteOffsiteworkActivityTemplatesByJobsiteActivityListTemplateId;
		if (isset($arrJobsiteOffsiteworkActivityTemplatesByJobsiteActivityListTemplateId) && !empty($arrJobsiteOffsiteworkActivityTemplatesByJobsiteActivityListTemplateId)) {
			return $arrJobsiteOffsiteworkActivityTemplatesByJobsiteActivityListTemplateId;
		}
		*/

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `jobsite_activity_list_template_id` ASC, `jobsite_offsitework_activity_label` ASC, `sort_order` ASC, `disabled_flag` ASC
		$sqlOrderBy = "\nORDER BY joat.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsiteOffsiteworkActivityTemplate = new JobsiteOffsiteworkActivityTemplate($database);
			$sqlOrderByColumns = $tmpJobsiteOffsiteworkActivityTemplate->constructSqlOrderByColumns($arrOrderByAttributes);

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
	joat.*
FROM `jobsite_offsitework_activity_templates` joat
WHERE joat.`id` in ($csvJobsiteOffsiteworkActivityTemplateIds){$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `jobsite_activity_list_template_id` ASC, `jobsite_offsitework_activity_label` ASC, `sort_order` ASC, `disabled_flag` ASC
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrJobsiteOffsiteworkActivityTemplatesByCsvJobsiteOffsiteworkActivityTemplateIds = array();
		while ($row = $db->fetch()) {
			$id = $row['id'];
			$jobsiteOffsiteworkActivityTemplate = self::instantiateOrm($database, 'JobsiteOffsiteworkActivityTemplate', $row, null, $id);
			/* @var $jobsiteOffsiteworkActivityTemplate JobsiteOffsiteworkActivityTemplate */
			$arrJobsiteOffsiteworkActivityTemplatesByCsvJobsiteOffsiteworkActivityTemplateIds[$id] = $jobsiteOffsiteworkActivityTemplate;
		}

		$db->free_result();

		return $arrJobsiteOffsiteworkActivityTemplatesByCsvJobsiteOffsiteworkActivityTemplateIds;
	}
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

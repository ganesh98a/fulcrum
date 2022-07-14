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
 * JobsiteActivityListTemplate.
 *
 * @category   Framework
 * @package    JobsiteActivityListTemplate
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class JobsiteActivityListTemplate extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'JobsiteActivityListTemplate';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'jobsite_activity_list_templates';

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
	 * unique index `unique_jobsite_activity_list_template` (`user_company_id`,`jobsite_activity_list_template`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_jobsite_activity_list_template' => array(
			'user_company_id' => 'int',
			'jobsite_activity_list_template' => 'string'
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
		'id' => 'jobsite_activity_list_template_id',

		'user_company_id' => 'user_company_id',
		'project_type_id' => 'project_type_id',

		'jobsite_activity_list_template' => 'jobsite_activity_list_template',

		'disabled_flag' => 'disabled_flag',
		'sort_order' => 'sort_order'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $jobsite_activity_list_template_id;

	public $user_company_id;
	public $project_type_id;

	public $jobsite_activity_list_template;

	public $disabled_flag;
	public $sort_order;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties
	public $escaped_jobsite_activity_list_template;

	// HTML ENTITY ENCODED NL2BR ORM string properties
	public $escaped_jobsite_activity_list_template_nl2br;

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)
	protected static $_arrJobsiteActivityListTemplatesByUserCompanyId;
	protected static $_arrJobsiteActivityListTemplatesByProjectTypeId;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllJobsiteActivityListTemplates;

	// Foreign Key Objects
	private $_userCompany;
	private $_projectType;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='jobsite_activity_list_templates')
	{
		parent::__construct($table);
		$this->setDatabase($database);
	}

	// Foreign Key Object Accessor Methods
	public function getUserCompany()
	{
		if (isset($this->_userCompany)) {
			return $this->_userCompany;
		} else {
			return null;
		}
	}

	public function setUserCompany($userCompany)
	{
		$this->_userCompany = $userCompany;
	}

	public function getProjectType()
	{
		if (isset($this->_projectType)) {
			return $this->_projectType;
		} else {
			return null;
		}
	}

	public function setProjectType($projectType)
	{
		$this->_projectType = $projectType;
	}

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)
	public static function getArrJobsiteActivityListTemplatesByUserCompanyId()
	{
		if (isset(self::$_arrJobsiteActivityListTemplatesByUserCompanyId)) {
			return self::$_arrJobsiteActivityListTemplatesByUserCompanyId;
		} else {
			return null;
		}
	}

	public static function setArrJobsiteActivityListTemplatesByUserCompanyId($arrJobsiteActivityListTemplatesByUserCompanyId)
	{
		self::$_arrJobsiteActivityListTemplatesByUserCompanyId = $arrJobsiteActivityListTemplatesByUserCompanyId;
	}

	public static function getArrJobsiteActivityListTemplatesByProjectTypeId()
	{
		if (isset(self::$_arrJobsiteActivityListTemplatesByProjectTypeId)) {
			return self::$_arrJobsiteActivityListTemplatesByProjectTypeId;
		} else {
			return null;
		}
	}

	public static function setArrJobsiteActivityListTemplatesByProjectTypeId($arrJobsiteActivityListTemplatesByProjectTypeId)
	{
		self::$_arrJobsiteActivityListTemplatesByProjectTypeId = $arrJobsiteActivityListTemplatesByProjectTypeId;
	}

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllJobsiteActivityListTemplates()
	{
		if (isset(self::$_arrAllJobsiteActivityListTemplates)) {
			return self::$_arrAllJobsiteActivityListTemplates;
		} else {
			return null;
		}
	}

	public static function setArrAllJobsiteActivityListTemplates($arrAllJobsiteActivityListTemplates)
	{
		self::$_arrAllJobsiteActivityListTemplates = $arrAllJobsiteActivityListTemplates;
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
	 * @param int $jobsite_activity_list_template_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findById($database, $jobsite_activity_list_template_id, $table='jobsite_activity_list_templates', $module='JobsiteActivityListTemplate')
	{
		$jobsiteActivityListTemplate = parent::findById($database, $jobsite_activity_list_template_id, $table, $module);

		return $jobsiteActivityListTemplate;
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Similar to FindById, but with SQL as starter code for more complex joins.
	 *
	 * @param string $database
	 * @param int $jobsite_activity_list_template_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findJobsiteActivityListTemplateByIdExtended($database, $jobsite_activity_list_template_id)
	{
		$jobsite_activity_list_template_id = (int) $jobsite_activity_list_template_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	jalt_fk_uc.`id` AS 'jalt_fk_uc__user_company_id',
	jalt_fk_uc.`company` AS 'jalt_fk_uc__company',
	jalt_fk_uc.`primary_phone_number` AS 'jalt_fk_uc__primary_phone_number',
	jalt_fk_uc.`employer_identification_number` AS 'jalt_fk_uc__employer_identification_number',
	jalt_fk_uc.`construction_license_number` AS 'jalt_fk_uc__construction_license_number',
	jalt_fk_uc.`construction_license_number_expiration_date` AS 'jalt_fk_uc__construction_license_number_expiration_date',
	jalt_fk_uc.`paying_customer_flag` AS 'jalt_fk_uc__paying_customer_flag',

	jalt_fk_pt.`id` AS 'jalt_fk_pt__project_type_id',
	jalt_fk_pt.`user_company_id` AS 'jalt_fk_pt__user_company_id',
	jalt_fk_pt.`construction_type` AS 'jalt_fk_pt__construction_type',
	jalt_fk_pt.`project_type` AS 'jalt_fk_pt__project_type',
	jalt_fk_pt.`project_type_label` AS 'jalt_fk_pt__project_type_label',
	jalt_fk_pt.`project_type_description` AS 'jalt_fk_pt__project_type_description',
	jalt_fk_pt.`hidden_flag` AS 'jalt_fk_pt__hidden_flag',
	jalt_fk_pt.`disabled_flag` AS 'jalt_fk_pt__disabled_flag',
	jalt_fk_pt.`sort_order` AS 'jalt_fk_pt__sort_order',

	jalt.*

FROM `jobsite_activity_list_templates` jalt
	INNER JOIN `user_companies` jalt_fk_uc ON jalt.`user_company_id` = jalt_fk_uc.`id`
	INNER JOIN `project_types` jalt_fk_pt ON jalt.`project_type_id` = jalt_fk_pt.`id`
WHERE jalt.`id` = ?
";
		$arrValues = array($jobsite_activity_list_template_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$jobsite_activity_list_template_id = $row['id'];
			$jobsiteActivityListTemplate = self::instantiateOrm($database, 'JobsiteActivityListTemplate', $row, null, $jobsite_activity_list_template_id);
			/* @var $jobsiteActivityListTemplate JobsiteActivityListTemplate */
			$jobsiteActivityListTemplate->convertPropertiesToData();

			if (isset($row['user_company_id'])) {
				$user_company_id = $row['user_company_id'];
				$row['jalt_fk_uc__id'] = $user_company_id;
				$userCompany = self::instantiateOrm($database, 'UserCompany', $row, null, $user_company_id, 'jalt_fk_uc__');
				/* @var $userCompany UserCompany */
				$userCompany->convertPropertiesToData();
			} else {
				$userCompany = false;
			}
			$jobsiteActivityListTemplate->setUserCompany($userCompany);

			if (isset($row['project_type_id'])) {
				$project_type_id = $row['project_type_id'];
				$row['jalt_fk_pt__id'] = $project_type_id;
				$projectType = self::instantiateOrm($database, 'ProjectType', $row, null, $project_type_id, 'jalt_fk_pt__');
				/* @var $projectType ProjectType */
				$projectType->convertPropertiesToData();
			} else {
				$projectType = false;
			}
			$jobsiteActivityListTemplate->setProjectType($projectType);

			return $jobsiteActivityListTemplate;
		} else {
			return false;
		}
	}

	// Finders: Find By Unique Index
	/**
	 * Find by unique index `unique_jobsite_activity_list_template` (`user_company_id`,`jobsite_activity_list_template`).
	 *
	 * @param string $database
	 * @param int $user_company_id
	 * @param string $jobsite_activity_list_template
	 * @return mixed (single ORM object | false)
	 */
	public static function findByUserCompanyIdAndJobsiteActivityListTemplate($database, $user_company_id, $jobsite_activity_list_template)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	jalt.*

FROM `jobsite_activity_list_templates` jalt
WHERE jalt.`user_company_id` = ?
AND jalt.`jobsite_activity_list_template` = ?
";
		$arrValues = array($user_company_id, $jobsite_activity_list_template);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if ($row && !empty($row)) {
			$jobsite_activity_list_template_id = $row['id'];
			$jobsiteActivityListTemplate = self::instantiateOrm($database, 'JobsiteActivityListTemplate', $row, null, $jobsite_activity_list_template_id);
			/* @var $jobsiteActivityListTemplate JobsiteActivityListTemplate */
			return $jobsiteActivityListTemplate;
		} else {
			return false;
		}
	}

	// Loaders: Load By pk List (list of auto int ids or other non auto int pk list)
	/**
	 * Load zero or more records by an id list (array of auto int primary keys).
	 *
	 * @param string $database
	 * @param array $arrJobsiteActivityListTemplateIds
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadJobsiteActivityListTemplatesByArrJobsiteActivityListTemplateIds($database, $arrJobsiteActivityListTemplateIds, Input $options=null)
	{
		if (empty($arrJobsiteActivityListTemplateIds)) {
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
		// ORDER BY `id` ASC, `user_company_id` ASC, `project_type_id` ASC, `jobsite_activity_list_template` ASC, `disabled_flag` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY jalt.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsiteActivityListTemplate = new JobsiteActivityListTemplate($database);
			$sqlOrderByColumns = $tmpJobsiteActivityListTemplate->constructSqlOrderByColumns($arrOrderByAttributes);

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

		foreach ($arrJobsiteActivityListTemplateIds as $k => $jobsite_activity_list_template_id) {
			$jobsite_activity_list_template_id = (int) $jobsite_activity_list_template_id;
			$arrJobsiteActivityListTemplateIds[$k] = $db->escape($jobsite_activity_list_template_id);
		}
		$csvJobsiteActivityListTemplateIds = join(',', $arrJobsiteActivityListTemplateIds);

		$query =
"
SELECT

	jalt.*

FROM `jobsite_activity_list_templates` jalt
WHERE jalt.`id` IN ($csvJobsiteActivityListTemplateIds){$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		$arrJobsiteActivityListTemplatesByCsvJobsiteActivityListTemplateIds = array();
		while ($row = $db->fetch()) {
			$jobsite_activity_list_template_id = $row['id'];
			$jobsiteActivityListTemplate = self::instantiateOrm($database, 'JobsiteActivityListTemplate', $row, null, $jobsite_activity_list_template_id);
			/* @var $jobsiteActivityListTemplate JobsiteActivityListTemplate */
			$jobsiteActivityListTemplate->convertPropertiesToData();

			$arrJobsiteActivityListTemplatesByCsvJobsiteActivityListTemplateIds[$jobsite_activity_list_template_id] = $jobsiteActivityListTemplate;
		}

		$db->free_result();

		return $arrJobsiteActivityListTemplatesByCsvJobsiteActivityListTemplateIds;
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `jobsite_activity_list_templates_fk_uc` foreign key (`user_company_id`) references `user_companies` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $user_company_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadJobsiteActivityListTemplatesByUserCompanyId($database, $user_company_id, Input $options=null)
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
			self::$_arrJobsiteActivityListTemplatesByUserCompanyId = null;
		}

		$arrJobsiteActivityListTemplatesByUserCompanyId = self::$_arrJobsiteActivityListTemplatesByUserCompanyId;
		if (isset($arrJobsiteActivityListTemplatesByUserCompanyId) && !empty($arrJobsiteActivityListTemplatesByUserCompanyId)) {
			return $arrJobsiteActivityListTemplatesByUserCompanyId;
		}

		$user_company_id = (int) $user_company_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `user_company_id` ASC, `project_type_id` ASC, `jobsite_activity_list_template` ASC, `disabled_flag` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY jalt.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsiteActivityListTemplate = new JobsiteActivityListTemplate($database);
			$sqlOrderByColumns = $tmpJobsiteActivityListTemplate->constructSqlOrderByColumns($arrOrderByAttributes);

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
	jalt.*

FROM `jobsite_activity_list_templates` jalt
WHERE jalt.`user_company_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `user_company_id` ASC, `project_type_id` ASC, `jobsite_activity_list_template` ASC, `disabled_flag` ASC, `sort_order` ASC
		$arrValues = array($user_company_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrJobsiteActivityListTemplatesByUserCompanyId = array();
		while ($row = $db->fetch()) {
			$jobsite_activity_list_template_id = $row['id'];
			$jobsiteActivityListTemplate = self::instantiateOrm($database, 'JobsiteActivityListTemplate', $row, null, $jobsite_activity_list_template_id);
			/* @var $jobsiteActivityListTemplate JobsiteActivityListTemplate */
			$arrJobsiteActivityListTemplatesByUserCompanyId[$jobsite_activity_list_template_id] = $jobsiteActivityListTemplate;
		}

		$db->free_result();

		self::$_arrJobsiteActivityListTemplatesByUserCompanyId = $arrJobsiteActivityListTemplatesByUserCompanyId;

		return $arrJobsiteActivityListTemplatesByUserCompanyId;
	}

	/**
	 * Load by constraint `jobsite_activity_list_templates_fk_pt` foreign key (`project_type_id`) references `project_types` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $project_type_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadJobsiteActivityListTemplatesByProjectTypeId($database, $project_type_id, Input $options=null)
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
			self::$_arrJobsiteActivityListTemplatesByProjectTypeId = null;
		}

		$arrJobsiteActivityListTemplatesByProjectTypeId = self::$_arrJobsiteActivityListTemplatesByProjectTypeId;
		if (isset($arrJobsiteActivityListTemplatesByProjectTypeId) && !empty($arrJobsiteActivityListTemplatesByProjectTypeId)) {
			return $arrJobsiteActivityListTemplatesByProjectTypeId;
		}

		$project_type_id = (int) $project_type_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `user_company_id` ASC, `project_type_id` ASC, `jobsite_activity_list_template` ASC, `disabled_flag` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY jalt.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsiteActivityListTemplate = new JobsiteActivityListTemplate($database);
			$sqlOrderByColumns = $tmpJobsiteActivityListTemplate->constructSqlOrderByColumns($arrOrderByAttributes);

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
	jalt.*

FROM `jobsite_activity_list_templates` jalt
WHERE jalt.`project_type_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `user_company_id` ASC, `project_type_id` ASC, `jobsite_activity_list_template` ASC, `disabled_flag` ASC, `sort_order` ASC
		$arrValues = array($project_type_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrJobsiteActivityListTemplatesByProjectTypeId = array();
		while ($row = $db->fetch()) {
			$jobsite_activity_list_template_id = $row['id'];
			$jobsiteActivityListTemplate = self::instantiateOrm($database, 'JobsiteActivityListTemplate', $row, null, $jobsite_activity_list_template_id);
			/* @var $jobsiteActivityListTemplate JobsiteActivityListTemplate */
			$arrJobsiteActivityListTemplatesByProjectTypeId[$jobsite_activity_list_template_id] = $jobsiteActivityListTemplate;
		}

		$db->free_result();

		self::$_arrJobsiteActivityListTemplatesByProjectTypeId = $arrJobsiteActivityListTemplatesByProjectTypeId;

		return $arrJobsiteActivityListTemplatesByProjectTypeId;
	}

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all jobsite_activity_list_templates records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllJobsiteActivityListTemplates($database, Input $options=null)
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
			self::$_arrAllJobsiteActivityListTemplates = null;
		}

		$arrAllJobsiteActivityListTemplates = self::$_arrAllJobsiteActivityListTemplates;
		if (isset($arrAllJobsiteActivityListTemplates) && !empty($arrAllJobsiteActivityListTemplates)) {
			return $arrAllJobsiteActivityListTemplates;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `user_company_id` ASC, `project_type_id` ASC, `jobsite_activity_list_template` ASC, `disabled_flag` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY jalt.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsiteActivityListTemplate = new JobsiteActivityListTemplate($database);
			$sqlOrderByColumns = $tmpJobsiteActivityListTemplate->constructSqlOrderByColumns($arrOrderByAttributes);

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
	jalt.*

FROM `jobsite_activity_list_templates` jalt{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `user_company_id` ASC, `project_type_id` ASC, `jobsite_activity_list_template` ASC, `disabled_flag` ASC, `sort_order` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllJobsiteActivityListTemplates = array();
		while ($row = $db->fetch()) {
			$jobsite_activity_list_template_id = $row['id'];
			$jobsiteActivityListTemplate = self::instantiateOrm($database, 'JobsiteActivityListTemplate', $row, null, $jobsite_activity_list_template_id);
			/* @var $jobsiteActivityListTemplate JobsiteActivityListTemplate */
			$arrAllJobsiteActivityListTemplates[$jobsite_activity_list_template_id] = $jobsiteActivityListTemplate;
		}

		$db->free_result();

		self::$_arrAllJobsiteActivityListTemplates = $arrAllJobsiteActivityListTemplates;

		return $arrAllJobsiteActivityListTemplates;
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
INTO `jobsite_activity_list_templates`
(`user_company_id`, `project_type_id`, `jobsite_activity_list_template`, `disabled_flag`, `sort_order`)
VALUES (?, ?, ?, ?, ?)
ON DUPLICATE KEY UPDATE `project_type_id` = ?, `disabled_flag` = ?, `sort_order` = ?
";
		$arrValues = array($this->user_company_id, $this->project_type_id, $this->jobsite_activity_list_template, $this->disabled_flag, $this->sort_order, $this->project_type_id, $this->disabled_flag, $this->sort_order);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$jobsite_activity_list_template_id = $db->insertId;
		$db->free_result();

		return $jobsite_activity_list_template_id;
	}

	// Save: insert ignore
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

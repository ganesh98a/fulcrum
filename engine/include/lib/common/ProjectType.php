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
 * ProjectType.
 *
 * @category   Framework
 * @package    ProjectType
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class ProjectType extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'ProjectType';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'project_types';

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
	 * unique index `unique_project_type` (`user_company_id`,`construction_type`,`project_type`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_project_type' => array(
			'user_company_id' => 'int',
			'construction_type' => 'string',
			'project_type' => 'string'
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
		'id' => 'project_type_id',

		'user_company_id' => 'user_company_id',

		'construction_type' => 'construction_type',
		'project_type' => 'project_type',

		'project_type_label' => 'project_type_label',
		'project_type_description' => 'project_type_description',
		'hidden_flag' => 'hidden_flag',
		'disabled_flag' => 'disabled_flag',
		'sort_order' => 'sort_order'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $project_type_id;

	public $user_company_id;

	public $construction_type;
	public $project_type;

	public $project_type_label;
	public $project_type_description;
	public $hidden_flag;
	public $disabled_flag;
	public $sort_order;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties
	public $escaped_construction_type;
	public $escaped_project_type;
	public $escaped_project_type_label;
	public $escaped_project_type_description;

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)
	protected static $_arrProjectTypesByUserCompanyId;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)
	protected static $_arrProjectTypesByProjectType;

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllProjectTypes;

	// Foreign Key Objects
	private $_userCompany;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='project_types')
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

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)
	public static function getArrProjectTypesByUserCompanyId()
	{
		if (isset(self::$_arrProjectTypesByUserCompanyId)) {
			return self::$_arrProjectTypesByUserCompanyId;
		} else {
			return null;
		}
	}

	public static function setArrProjectTypesByUserCompanyId($arrProjectTypesByUserCompanyId)
	{
		self::$_arrProjectTypesByUserCompanyId = $arrProjectTypesByUserCompanyId;
	}

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)
	public static function getArrProjectTypesByProjectType()
	{
		if (isset(self::$_arrProjectTypesByProjectType)) {
			return self::$_arrProjectTypesByProjectType;
		} else {
			return null;
		}
	}

	public static function setArrProjectTypesByProjectType($arrProjectTypesByProjectType)
	{
		self::$_arrProjectTypesByProjectType = $arrProjectTypesByProjectType;
	}

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllProjectTypes()
	{
		if (isset(self::$_arrAllProjectTypes)) {
			return self::$_arrAllProjectTypes;
		} else {
			return null;
		}
	}

	public static function setArrAllProjectTypes($arrAllProjectTypes)
	{
		self::$_arrAllProjectTypes = $arrAllProjectTypes;
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
	 * @param int $project_type_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findById($database, $project_type_id,$table='project_types', $module='ProjectType')
	{
		$projectType = parent::findById($database, $project_type_id,$table, $module);

		return $projectType;
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Similar to FindById, but with SQL as starter code for more complex joins.
	 *
	 * @param string $database
	 * @param int $project_type_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findProjectTypeByIdExtended($database, $project_type_id)
	{
		$project_type_id = (int) $project_type_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	pt_fk_uc.`id` AS 'pt_fk_uc__user_company_id',
	pt_fk_uc.`company` AS 'pt_fk_uc__company',
	pt_fk_uc.`primary_phone_number` AS 'pt_fk_uc__primary_phone_number',
	pt_fk_uc.`employer_identification_number` AS 'pt_fk_uc__employer_identification_number',
	pt_fk_uc.`construction_license_number` AS 'pt_fk_uc__construction_license_number',
	pt_fk_uc.`construction_license_number_expiration_date` AS 'pt_fk_uc__construction_license_number_expiration_date',
	pt_fk_uc.`paying_customer_flag` AS 'pt_fk_uc__paying_customer_flag',

	pt.*

FROM `project_types` pt
	INNER JOIN `user_companies` pt_fk_uc ON pt.`user_company_id` = pt_fk_uc.`id`
WHERE pt.`id` = ?
";
		$arrValues = array($project_type_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$project_type_id = $row['id'];
			$projectType = self::instantiateOrm($database, 'ProjectType', $row, null, $project_type_id);
			/* @var $projectType ProjectType */
			$projectType->convertPropertiesToData();

			if (isset($row['user_company_id'])) {
				$user_company_id = $row['user_company_id'];
				$row['pt_fk_uc__id'] = $user_company_id;
				$userCompany = self::instantiateOrm($database, 'UserCompany', $row, null, $user_company_id, 'pt_fk_uc__');
				/* @var $userCompany UserCompany */
				$userCompany->convertPropertiesToData();
			} else {
				$userCompany = false;
			}
			$projectType->setUserCompany($userCompany);

			return $projectType;
		} else {
			return false;
		}
	}

	// Finders: Find By Unique Index
	/**
	 * Find by unique index `unique_project_type` (`user_company_id`,`construction_type`,`project_type`).
	 *
	 * @param string $database
	 * @param int $user_company_id
	 * @param string $construction_type
	 * @param string $project_type
	 * @return mixed (single ORM object | false)
	 */
	public static function findByUserCompanyIdAndConstructionTypeAndProjectType($database, $user_company_id, $construction_type, $project_type)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	pt.*

FROM `project_types` pt
WHERE pt.`user_company_id` = ?
AND pt.`construction_type` = ?
AND pt.`project_type` = ?
";
		$arrValues = array($user_company_id, $construction_type, $project_type);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if ($row && !empty($row)) {
			$project_type_id = $row['id'];
			$projectType = self::instantiateOrm($database, 'ProjectType', $row, null, $project_type_id);
			/* @var $projectType ProjectType */
			return $projectType;
		} else {
			return false;
		}
	}

	// Loaders: Load By pk List (list of auto int ids or other non auto int pk list)
	/**
	 * Load zero or more records by an id list (array of auto int primary keys).
	 *
	 * @param string $database
	 * @param array $arrProjectTypeIds
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadProjectTypesByArrProjectTypeIds($database, $arrProjectTypeIds, Input $options=null)
	{
		if (empty($arrProjectTypeIds)) {
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
		// ORDER BY `id` ASC, `user_company_id` ASC, `construction_type` ASC, `project_type` ASC, `project_type_label` ASC, `project_type_description` ASC, `hidden_flag` ASC, `disabled_flag` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY pt.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpProjectType = new ProjectType($database);
			$sqlOrderByColumns = $tmpProjectType->constructSqlOrderByColumns($arrOrderByAttributes);

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

		foreach ($arrProjectTypeIds as $k => $project_type_id) {
			$project_type_id = (int) $project_type_id;
			$arrProjectTypeIds[$k] = $db->escape($project_type_id);
		}
		$csvProjectTypeIds = join(',', $arrProjectTypeIds);

		$query =
"
SELECT

	pt.*

FROM `project_types` pt
WHERE pt.`id` IN ($csvProjectTypeIds){$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		$arrProjectTypesByCsvProjectTypeIds = array();
		while ($row = $db->fetch()) {
			$project_type_id = $row['id'];
			$projectType = self::instantiateOrm($database, 'ProjectType', $row, null, $project_type_id);
			/* @var $projectType ProjectType */
			$projectType->convertPropertiesToData();

			$arrProjectTypesByCsvProjectTypeIds[$project_type_id] = $projectType;
		}

		$db->free_result();

		return $arrProjectTypesByCsvProjectTypeIds;
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `project_types_fk_uc` foreign key (`user_company_id`) references `user_companies` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $user_company_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadProjectTypesByUserCompanyId($database, $user_company_id, Input $options=null)
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
			self::$_arrProjectTypesByUserCompanyId = null;
		}

		$arrProjectTypesByUserCompanyId = self::$_arrProjectTypesByUserCompanyId;
		if (isset($arrProjectTypesByUserCompanyId) && !empty($arrProjectTypesByUserCompanyId)) {
			return $arrProjectTypesByUserCompanyId;
		}

		$user_company_id = (int) $user_company_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `user_company_id` ASC, `construction_type` ASC, `project_type` ASC, `project_type_label` ASC, `project_type_description` ASC, `hidden_flag` ASC, `disabled_flag` ASC, `sort_order` ASC
		//$sqlOrderBy = "\nORDER BY `sort_order` ASC, `project_type` ASC";
		$sqlOrderBy = "\nORDER BY `id` ASC, `sort_order` ASC, `project_type` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpProjectType = new ProjectType($database);
			$sqlOrderByColumns = $tmpProjectType->constructSqlOrderByColumns($arrOrderByAttributes);

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
	pt.*

FROM `project_types` pt
WHERE pt.`user_company_id` = ?
AND pt.`project_type` <> ''{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `user_company_id` ASC, `construction_type` ASC, `project_type` ASC, `project_type_label` ASC, `project_type_description` ASC, `hidden_flag` ASC, `disabled_flag` ASC, `sort_order` ASC
		$arrValues = array($user_company_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrProjectTypesByUserCompanyId = array();
		while ($row = $db->fetch()) {
			$project_type_id = $row['id'];
			$projectType = self::instantiateOrm($database, 'ProjectType', $row, null, $project_type_id);
			/* @var $projectType ProjectType */
			$arrProjectTypesByUserCompanyId[$project_type_id] = $projectType;
		}

		$db->free_result();

		self::$_arrProjectTypesByUserCompanyId = $arrProjectTypesByUserCompanyId;

		return $arrProjectTypesByUserCompanyId;
	}

	// Loaders: Load By index
	/**
	 * Load by key `project_type` (`project_type`).
	 *
	 * @param string $database
	 * @param string $project_type
	 * @param mixed (Input $options object | null)
	 * @return mixed (single ORM object | false)
	 */
	public static function loadProjectTypesByProjectType($database, $project_type, Input $options=null)
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
			self::$_arrProjectTypesByProjectType = null;
		}

		$arrProjectTypesByProjectType = self::$_arrProjectTypesByProjectType;
		if (isset($arrProjectTypesByProjectType) && !empty($arrProjectTypesByProjectType)) {
			return $arrProjectTypesByProjectType;
		}

		$project_type = (string) $project_type;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `user_company_id` ASC, `construction_type` ASC, `project_type` ASC, `project_type_label` ASC, `project_type_description` ASC, `hidden_flag` ASC, `disabled_flag` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY pt.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpProjectType = new ProjectType($database);
			$sqlOrderByColumns = $tmpProjectType->constructSqlOrderByColumns($arrOrderByAttributes);

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
	pt.*

FROM `project_types` pt
WHERE pt.`project_type` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `user_company_id` ASC, `construction_type` ASC, `project_type` ASC, `project_type_label` ASC, `project_type_description` ASC, `hidden_flag` ASC, `disabled_flag` ASC, `sort_order` ASC
		$arrValues = array($project_type);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrProjectTypesByProjectType = array();
		while ($row = $db->fetch()) {
			$project_type_id = $row['id'];
			$projectType = self::instantiateOrm($database, 'ProjectType', $row, null, $project_type_id);
			/* @var $projectType ProjectType */
			$arrProjectTypesByProjectType[$project_type_id] = $projectType;
		}

		$db->free_result();

		self::$_arrProjectTypesByProjectType = $arrProjectTypesByProjectType;

		return $arrProjectTypesByProjectType;
	}

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all project_types records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllProjectTypes($database, Input $options=null)
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
			self::$_arrAllProjectTypes = null;
		}

		$arrAllProjectTypes = self::$_arrAllProjectTypes;
		if (isset($arrAllProjectTypes) && !empty($arrAllProjectTypes)) {
			return $arrAllProjectTypes;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `user_company_id` ASC, `construction_type` ASC, `project_type` ASC, `project_type_label` ASC, `project_type_description` ASC, `hidden_flag` ASC, `disabled_flag` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY pt.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpProjectType = new ProjectType($database);
			$sqlOrderByColumns = $tmpProjectType->constructSqlOrderByColumns($arrOrderByAttributes);

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
	pt.*

FROM `project_types` pt{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `user_company_id` ASC, `construction_type` ASC, `project_type` ASC, `project_type_label` ASC, `project_type_description` ASC, `hidden_flag` ASC, `disabled_flag` ASC, `sort_order` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllProjectTypes = array();
		while ($row = $db->fetch()) {
			$project_type_id = $row['id'];
			$projectType = self::instantiateOrm($database, 'ProjectType', $row, null, $project_type_id);
			/* @var $projectType ProjectType */
			$arrAllProjectTypes[$project_type_id] = $projectType;
		}

		$db->free_result();

		self::$_arrAllProjectTypes = $arrAllProjectTypes;

		return $arrAllProjectTypes;
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
INTO `project_types`
(`user_company_id`, `construction_type`, `project_type`, `project_type_label`, `project_type_description`, `hidden_flag`, `disabled_flag`, `sort_order`)
VALUES (?, ?, ?, ?, ?, ?, ?, ?)
ON DUPLICATE KEY UPDATE `project_type_label` = ?, `project_type_description` = ?, `hidden_flag` = ?, `disabled_flag` = ?, `sort_order` = ?
";
		$arrValues = array($this->user_company_id, $this->construction_type, $this->project_type, $this->project_type_label, $this->project_type_description, $this->hidden_flag, $this->disabled_flag, $this->sort_order, $this->project_type_label, $this->project_type_description, $this->hidden_flag, $this->disabled_flag, $this->sort_order);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$project_type_id = $db->insertId;
		$db->free_result();

		return $project_type_id;
	}

	// Save: insert ignore

	/**
	 * Load all project_types records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllEligibleProjectTypes($database, Input $options=null)
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
			self::$_arrAllEligibleProjectTypes = null;
		}

		$arrAllEligibleProjectTypes = self::$_arrAllEligibleProjectTypes;
		if (isset($arrAllEligibleProjectTypes) && !empty($arrAllEligibleProjectTypes)) {
			return $arrAllEligibleProjectTypes;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `user_company_id` ASC, `project_type` ASC, `project_type_label` ASC, `project_type_description` ASC, `hidden_flag` ASC, `disabled_flag` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY pt.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpProjectType = new ProjectType($database);
			$sqlOrderByColumns = $tmpProjectType->constructSqlOrderByColumns($arrOrderByAttributes);

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
	pt.*
FROM `project_types` pt
WHERE `id` > 2{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_type` ASC, `project_type_label` ASC, `project_type_description` ASC, `hidden_flag` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllProjectTypes = array();
		while ($row = $db->fetch()) {
			$id = $row['id'];
			$projectType = self::instantiateOrm($database, 'ProjectType', $row, null, $id);
			/* @var $projectType ProjectType */
			$arrAllProjectTypes[$id] = $projectType;
		}

		$db->free_result();

		self::$_arrAllEligibleProjectTypes = $arrAllEligibleProjectTypes;

		return $arrAllEligibleProjectTypes;
	}

	public static function loadProjectTypesList($database, $showHiddenFlag=false)
	{
		$db = DBI::getInstance($database);

		if ($showHiddenFlag) {
			$where = "WHERE pt.`hidden_flag` IN ('Y', 'N') ";
		} else {
			$where = "WHERE pt.`hidden_flag` IN ('N') ";
		}

		$query =
"
SELECT pt.*
FROM `project_types` pt
$where
ORDER BY `project_type` ASC
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrProjectTypesList = array();
		$arrProjectTypeOptions = array();
		while ($row = $db->fetch()) {
			$project_type_id = $row['id'];
			$project_type = $row['project_type'];
			$projectType = new ProjectType($database);
			$projectType->setId($project_type_id);
			$key = array('id' => $project_type_id);
			$projectType->setKey($key);
			$projectType->setData($row);
			$projectType->convertDataToProperties();
			// Object list format
			$arrProjectTypesList[$project_type_id] = $projectType;

			// Drop down list format
			$arrProjectTypeOptions[$project_type_id] = $project_type;
		}
		$db->free_result();

		$arrReturn = array(
			'objects_list' => $arrProjectTypesList,
			'options_list' => $arrProjectTypeOptions
		);

		return $arrReturn;
	}

	/**
	 * Find by `project_type` = 'Not Specified' for a given user_company_id.
	 *
	 * @param string $database
	 * @param int $user_company_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findByUserCompanyIdAndDefaultProjectType($database, $user_company_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	pt.*

FROM `project_types` pt
WHERE pt.`user_company_id` = ?
AND pt.`project_type` = 'Not Specified'
";
		$arrValues = array($user_company_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if ($row && !empty($row)) {
			$project_type_id = $row['id'];
			$projectType = self::instantiateOrm($database, 'ProjectType', $row, null, $project_type_id);
			/* @var $projectType ProjectType */
			return $projectType;
		} else {
			return false;
		}
	}
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

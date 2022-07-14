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
 * JobsiteDelaySubcategory.
 *
 * @category   Framework
 * @package    JobsiteDelaySubcategory
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class JobsiteDelaySubcategory extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'JobsiteDelaySubcategory';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'jobsite_delay_subcategories';

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
	 * unique index `unique_jobsite_delay_subcategory` (`jobsite_delay_category_id`,`jobsite_delay_subcategory`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_jobsite_delay_subcategory' => array(
			'jobsite_delay_category_id' => 'int',
			'jobsite_delay_subcategory' => 'string'
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
		'id' => 'jobsite_delay_subcategory_id',

		'jobsite_delay_category_id' => 'jobsite_delay_category_id',

		'jobsite_delay_subcategory' => 'jobsite_delay_subcategory',

		'disabled_flag' => 'disabled_flag',
		'sort_order' => 'sort_order'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $jobsite_delay_subcategory_id;

	public $jobsite_delay_category_id;

	public $jobsite_delay_subcategory;

	public $disabled_flag;
	public $sort_order;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties
	public $escaped_jobsite_delay_subcategory;

	// HTML ENTITY ENCODED NL2BR ORM string properties
	public $escaped_jobsite_delay_subcategory_nl2br;

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)
	protected static $_arrJobsiteDelaySubcategoriesByJobsiteDelayCategoryId;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllJobsiteDelaySubcategories;

	// Foreign Key Objects
	private $_jobsiteDelayCategory;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='jobsite_delay_subcategories')
	{
		parent::__construct($table);
		$this->setDatabase($database);
	}

	// Foreign Key Object Accessor Methods
	public function getJobsiteDelayCategory()
	{
		if (isset($this->_jobsiteDelayCategory)) {
			return $this->_jobsiteDelayCategory;
		} else {
			return null;
		}
	}

	public function setJobsiteDelayCategory($jobsiteDelayCategory)
	{
		$this->_jobsiteDelayCategory = $jobsiteDelayCategory;
	}

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)
	public static function getArrJobsiteDelaySubcategoriesByJobsiteDelayCategoryId()
	{
		if (isset(self::$_arrJobsiteDelaySubcategoriesByJobsiteDelayCategoryId)) {
			return self::$_arrJobsiteDelaySubcategoriesByJobsiteDelayCategoryId;
		} else {
			return null;
		}
	}

	public static function setArrJobsiteDelaySubcategoriesByJobsiteDelayCategoryId($arrJobsiteDelaySubcategoriesByJobsiteDelayCategoryId)
	{
		self::$_arrJobsiteDelaySubcategoriesByJobsiteDelayCategoryId = $arrJobsiteDelaySubcategoriesByJobsiteDelayCategoryId;
	}

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllJobsiteDelaySubcategories()
	{
		if (isset(self::$_arrAllJobsiteDelaySubcategories)) {
			return self::$_arrAllJobsiteDelaySubcategories;
		} else {
			return null;
		}
	}

	public static function setArrAllJobsiteDelaySubcategories($arrAllJobsiteDelaySubcategories)
	{
		self::$_arrAllJobsiteDelaySubcategories = $arrAllJobsiteDelaySubcategories;
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
	 * @param int $jobsite_delay_subcategory_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findById($database, $jobsite_delay_subcategory_id, $table='jobsite_delay_subcategories', $module='JobsiteDelaySubcategory')
	{
		$jobsiteDelaySubcategory = parent::findById($database, $jobsite_delay_subcategory_id, $table, $module);

		return $jobsiteDelaySubcategory;
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Similar to FindById, but with SQL as starter code for more complex joins.
	 *
	 * @param string $database
	 * @param int $jobsite_delay_subcategory_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findJobsiteDelaySubcategoryByIdExtended($database, $jobsite_delay_subcategory_id)
	{
		$jobsite_delay_subcategory_id = (int) $jobsite_delay_subcategory_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	jds_fk_jdc.`id` AS 'jds_fk_jdc__jobsite_delay_category_id',
	jds_fk_jdc.`user_company_id` AS 'jds_fk_jdc__user_company_id',
	jds_fk_jdc.`jobsite_delay_category` AS 'jds_fk_jdc__jobsite_delay_category',
	jds_fk_jdc.`disabled_flag` AS 'jds_fk_jdc__disabled_flag',
	jds_fk_jdc.`sort_order` AS 'jds_fk_jdc__sort_order',

	jds.*

FROM `jobsite_delay_subcategories` jds
	INNER JOIN `jobsite_delay_categories` jds_fk_jdc ON jds.`jobsite_delay_category_id` = jds_fk_jdc.`id`
WHERE jds.`id` = ?
";
		$arrValues = array($jobsite_delay_subcategory_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$jobsite_delay_subcategory_id = $row['id'];
			$jobsiteDelaySubcategory = self::instantiateOrm($database, 'JobsiteDelaySubcategory', $row, null, $jobsite_delay_subcategory_id);
			/* @var $jobsiteDelaySubcategory JobsiteDelaySubcategory */
			$jobsiteDelaySubcategory->convertPropertiesToData();

			if (isset($row['jobsite_delay_category_id'])) {
				$jobsite_delay_category_id = $row['jobsite_delay_category_id'];
				$row['jds_fk_jdc__id'] = $jobsite_delay_category_id;
				$jobsiteDelayCategory = self::instantiateOrm($database, 'JobsiteDelayCategory', $row, null, $jobsite_delay_category_id, 'jds_fk_jdc__');
				/* @var $jobsiteDelayCategory JobsiteDelayCategory */
				$jobsiteDelayCategory->convertPropertiesToData();
			} else {
				$jobsiteDelayCategory = false;
			}
			$jobsiteDelaySubcategory->setJobsiteDelayCategory($jobsiteDelayCategory);

			return $jobsiteDelaySubcategory;
		} else {
			return false;
		}
	}

	// Finders: Find By Unique Index
	/**
	 * Find by unique index `unique_jobsite_delay_subcategory` (`jobsite_delay_category_id`,`jobsite_delay_subcategory`).
	 *
	 * @param string $database
	 * @param int $jobsite_delay_category_id
	 * @param string $jobsite_delay_subcategory
	 * @return mixed (single ORM object | false)
	 */
	public static function findByJobsiteDelayCategoryIdAndJobsiteDelaySubcategory($database, $jobsite_delay_category_id, $jobsite_delay_subcategory)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	jds.*

FROM `jobsite_delay_subcategories` jds
WHERE jds.`jobsite_delay_category_id` = ?
AND jds.`jobsite_delay_subcategory` = ?
";
		$arrValues = array($jobsite_delay_category_id, $jobsite_delay_subcategory);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if ($row && !empty($row)) {
			$jobsite_delay_subcategory_id = $row['id'];
			$jobsiteDelaySubcategory = self::instantiateOrm($database, 'JobsiteDelaySubcategory', $row, null, $jobsite_delay_subcategory_id);
			/* @var $jobsiteDelaySubcategory JobsiteDelaySubcategory */
			return $jobsiteDelaySubcategory;
		} else {
			return false;
		}
	}

	// Loaders: Load By pk List (list of auto int ids or other non auto int pk list)
	/**
	 * Load zero or more records by an id list (array of auto int primary keys).
	 *
	 * @param string $database
	 * @param array $arrJobsiteDelaySubcategoryIds
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadJobsiteDelaySubcategoriesByArrJobsiteDelaySubcategoryIds($database, $arrJobsiteDelaySubcategoryIds, Input $options=null)
	{
		if (empty($arrJobsiteDelaySubcategoryIds)) {
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
		// ORDER BY `id` ASC, `jobsite_delay_category_id` ASC, `jobsite_delay_subcategory` ASC, `disabled_flag` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY jds.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsiteDelaySubcategory = new JobsiteDelaySubcategory($database);
			$sqlOrderByColumns = $tmpJobsiteDelaySubcategory->constructSqlOrderByColumns($arrOrderByAttributes);

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

		foreach ($arrJobsiteDelaySubcategoryIds as $k => $jobsite_delay_subcategory_id) {
			$jobsite_delay_subcategory_id = (int) $jobsite_delay_subcategory_id;
			$arrJobsiteDelaySubcategoryIds[$k] = $db->escape($jobsite_delay_subcategory_id);
		}
		$csvJobsiteDelaySubcategoryIds = join(',', $arrJobsiteDelaySubcategoryIds);

		$query =
"
SELECT

	jds.*

FROM `jobsite_delay_subcategories` jds
WHERE jds.`id` IN ($csvJobsiteDelaySubcategoryIds){$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		$arrJobsiteDelaySubcategoriesByCsvJobsiteDelaySubcategoryIds = array();
		while ($row = $db->fetch()) {
			$jobsite_delay_subcategory_id = $row['id'];
			$jobsiteDelaySubcategory = self::instantiateOrm($database, 'JobsiteDelaySubcategory', $row, null, $jobsite_delay_subcategory_id);
			/* @var $jobsiteDelaySubcategory JobsiteDelaySubcategory */
			$jobsiteDelaySubcategory->convertPropertiesToData();

			$arrJobsiteDelaySubcategoriesByCsvJobsiteDelaySubcategoryIds[$jobsite_delay_subcategory_id] = $jobsiteDelaySubcategory;
		}

		$db->free_result();

		return $arrJobsiteDelaySubcategoriesByCsvJobsiteDelaySubcategoryIds;
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `jobsite_delay_subcategories_fk_jdc` foreign key (`jobsite_delay_category_id`) references `jobsite_delay_categories` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $jobsite_delay_category_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadJobsiteDelaySubcategoriesByJobsiteDelayCategoryId($database, $jobsite_delay_category_id, Input $options=null)
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
			self::$_arrJobsiteDelaySubcategoriesByJobsiteDelayCategoryId = null;
		}

		$arrJobsiteDelaySubcategoriesByJobsiteDelayCategoryId = self::$_arrJobsiteDelaySubcategoriesByJobsiteDelayCategoryId;
		if (isset($arrJobsiteDelaySubcategoriesByJobsiteDelayCategoryId) && !empty($arrJobsiteDelaySubcategoriesByJobsiteDelayCategoryId)) {
			return $arrJobsiteDelaySubcategoriesByJobsiteDelayCategoryId;
		}

		$jobsite_delay_category_id = (int) $jobsite_delay_category_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `jobsite_delay_category_id` ASC, `jobsite_delay_subcategory` ASC, `disabled_flag` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY jds.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsiteDelaySubcategory = new JobsiteDelaySubcategory($database);
			$sqlOrderByColumns = $tmpJobsiteDelaySubcategory->constructSqlOrderByColumns($arrOrderByAttributes);

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
	jds.*

FROM `jobsite_delay_subcategories` jds
WHERE jds.`jobsite_delay_category_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `jobsite_delay_category_id` ASC, `jobsite_delay_subcategory` ASC, `disabled_flag` ASC, `sort_order` ASC
		$arrValues = array($jobsite_delay_category_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrJobsiteDelaySubcategoriesByJobsiteDelayCategoryId = array();
		while ($row = $db->fetch()) {
			$jobsite_delay_subcategory_id = $row['id'];
			$jobsiteDelaySubcategory = self::instantiateOrm($database, 'JobsiteDelaySubcategory', $row, null, $jobsite_delay_subcategory_id);
			/* @var $jobsiteDelaySubcategory JobsiteDelaySubcategory */
			$arrJobsiteDelaySubcategoriesByJobsiteDelayCategoryId[$jobsite_delay_subcategory_id] = $jobsiteDelaySubcategory;
		}

		$db->free_result();

		self::$_arrJobsiteDelaySubcategoriesByJobsiteDelayCategoryId = $arrJobsiteDelaySubcategoriesByJobsiteDelayCategoryId;

		return $arrJobsiteDelaySubcategoriesByJobsiteDelayCategoryId;
	}

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all jobsite_delay_subcategories records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllJobsiteDelaySubcategories($database, Input $options=null)
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
			self::$_arrAllJobsiteDelaySubcategories = null;
		}

		$arrAllJobsiteDelaySubcategories = self::$_arrAllJobsiteDelaySubcategories;
		if (isset($arrAllJobsiteDelaySubcategories) && !empty($arrAllJobsiteDelaySubcategories)) {
			return $arrAllJobsiteDelaySubcategories;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `jobsite_delay_category_id` ASC, `jobsite_delay_subcategory` ASC, `disabled_flag` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY jds.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsiteDelaySubcategory = new JobsiteDelaySubcategory($database);
			$sqlOrderByColumns = $tmpJobsiteDelaySubcategory->constructSqlOrderByColumns($arrOrderByAttributes);

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
	jds.*

FROM `jobsite_delay_subcategories` jds{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `jobsite_delay_category_id` ASC, `jobsite_delay_subcategory` ASC, `disabled_flag` ASC, `sort_order` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllJobsiteDelaySubcategories = array();
		while ($row = $db->fetch()) {
			$jobsite_delay_subcategory_id = $row['id'];
			$jobsiteDelaySubcategory = self::instantiateOrm($database, 'JobsiteDelaySubcategory', $row, null, $jobsite_delay_subcategory_id);
			/* @var $jobsiteDelaySubcategory JobsiteDelaySubcategory */
			$arrAllJobsiteDelaySubcategories[$jobsite_delay_subcategory_id] = $jobsiteDelaySubcategory;
		}

		$db->free_result();

		self::$_arrAllJobsiteDelaySubcategories = $arrAllJobsiteDelaySubcategories;

		return $arrAllJobsiteDelaySubcategories;
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
INTO `jobsite_delay_subcategories`
(`jobsite_delay_category_id`, `jobsite_delay_subcategory`, `disabled_flag`, `sort_order`)
VALUES (?, ?, ?, ?)
ON DUPLICATE KEY UPDATE `disabled_flag` = ?, `sort_order` = ?
";
		$arrValues = array($this->jobsite_delay_category_id, $this->jobsite_delay_subcategory, $this->disabled_flag, $this->sort_order, $this->disabled_flag, $this->sort_order);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$jobsite_delay_subcategory_id = $db->insertId;
		$db->free_result();

		return $jobsite_delay_subcategory_id;
	}

	// Save: insert ignore

	/**
	 * Load jobsite_delay_subcategories by join on jobsite_delay_categories FK user_company_id.
	 *
	 * @param string $database
	 * @param int $user_company_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadJobsiteDelaySubcategoriesByUserCompanyIdGroupedByJobsiteDelayCategoryId($database, $user_company_id, Input $options=null)
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

		$user_company_id = (int) $user_company_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `jobsite_delay_category_id` ASC, `jobsite_delay_subcategory` ASC, `disabled_flag` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY jds_fk_jdc.`sort_order` ASC, jds.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsiteDelaySubcategory = new JobsiteDelaySubcategory($database);
			$sqlOrderByColumns = $tmpJobsiteDelaySubcategory->constructSqlOrderByColumns($arrOrderByAttributes);

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
	jds.*

FROM `jobsite_delay_subcategories` jds
	INNER JOIN `jobsite_delay_categories` jds_fk_jdc ON jds.`jobsite_delay_category_id` = jds_fk_jdc.`id`
WHERE jds_fk_jdc.`user_company_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `jobsite_delay_category_id` ASC, `jobsite_delay_subcategory` ASC, `disabled_flag` ASC, `sort_order` ASC
		$arrValues = array($user_company_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrJobsiteDelaySubcategoriesByUserCompanyIdGroupedByJobsiteDelayCategoryId = array();
		while ($row = $db->fetch()) {
			$jobsite_delay_subcategory_id = $row['id'];
			$jobsiteDelaySubcategory = self::instantiateOrm($database, 'JobsiteDelaySubcategory', $row, null, $jobsite_delay_subcategory_id);
			/* @var $jobsiteDelaySubcategory JobsiteDelaySubcategory */

			$jobsite_delay_category_id = $row['jobsite_delay_category_id'];
			$arrJobsiteDelaySubcategoriesByUserCompanyIdGroupedByJobsiteDelayCategoryId[$jobsite_delay_category_id][$jobsite_delay_subcategory_id] = $jobsiteDelaySubcategory;
		}

		$db->free_result();

		return $arrJobsiteDelaySubcategoriesByUserCompanyIdGroupedByJobsiteDelayCategoryId;
	}
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

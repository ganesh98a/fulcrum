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
 * JobsiteDelayCategory.
 *
 * @category   Framework
 * @package    JobsiteDelayCategory
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class JobsiteDelayCategory extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'JobsiteDelayCategory';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'jobsite_delay_categories';

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
	 * unique index `unique_jobsite_delay_category` (`user_company_id`,`jobsite_delay_category`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_jobsite_delay_category' => array(
			'user_company_id' => 'int',
			'jobsite_delay_category' => 'string'
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
		'id' => 'jobsite_delay_category_id',

		'user_company_id' => 'user_company_id',
		'jobsite_delay_category' => 'jobsite_delay_category',

		'disabled_flag' => 'disabled_flag',
		'sort_order' => 'sort_order'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $jobsite_delay_category_id;

	public $user_company_id;
	public $jobsite_delay_category;

	public $disabled_flag;
	public $sort_order;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties
	public $escaped_jobsite_delay_category;

	// HTML ENTITY ENCODED NL2BR ORM string properties
	public $escaped_jobsite_delay_category_nl2br;

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)
	protected static $_arrJobsiteDelayCategoriesByUserCompanyId;

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllJobsiteDelayCategories;

	// Foreign Key Objects

	/**
	 * Constructor
	 */
	public function __construct($database, $table='jobsite_delay_categories')
	{
		parent::__construct($table);
		$this->setDatabase($database);
	}

	// Foreign Key Object Accessor Methods

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)
	public static function getArrJobsiteDelayCategoriesByUserCompanyId()
	{
		if (isset(self::$_arrJobsiteDelayCategoriesByUserCompanyId)) {
			return self::$_arrJobsiteDelayCategoriesByUserCompanyId;
		} else {
			return null;
		}
	}

	public static function setArrJobsiteDelayCategoriesByUserCompanyId($arrJobsiteDelayCategoriesByUserCompanyId)
	{
		self::$_arrJobsiteDelayCategoriesByUserCompanyId = $arrJobsiteDelayCategoriesByUserCompanyId;
	}

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllJobsiteDelayCategories()
	{
		if (isset(self::$_arrAllJobsiteDelayCategories)) {
			return self::$_arrAllJobsiteDelayCategories;
		} else {
			return null;
		}
	}

	public static function setArrAllJobsiteDelayCategories($arrAllJobsiteDelayCategories)
	{
		self::$_arrAllJobsiteDelayCategories = $arrAllJobsiteDelayCategories;
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
	 * @param int $jobsite_delay_category_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findById($database, $jobsite_delay_category_id, $table='jobsite_delay_categories', $module='JobsiteDelayCategory')
	{
		$jobsiteDelayCategory = parent::findById($database, $jobsite_delay_category_id, $table, $module);

		return $jobsiteDelayCategory;
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Similar to FindById, but with SQL as starter code for more complex joins.
	 *
	 * @param string $database
	 * @param int $jobsite_delay_category_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findJobsiteDelayCategoryByIdExtended($database, $jobsite_delay_category_id)
	{
		$jobsite_delay_category_id = (int) $jobsite_delay_category_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	jdc.*

FROM `jobsite_delay_categories` jdc
WHERE jdc.`id` = ?
";
		$arrValues = array($jobsite_delay_category_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$jobsite_delay_category_id = $row['id'];
			$jobsiteDelayCategory = self::instantiateOrm($database, 'JobsiteDelayCategory', $row, null, $jobsite_delay_category_id);
			/* @var $jobsiteDelayCategory JobsiteDelayCategory */
			$jobsiteDelayCategory->convertPropertiesToData();

			return $jobsiteDelayCategory;
		} else {
			return false;
		}
	}

	// Finders: Find By Unique Index
	/**
	 * Find by unique index `unique_jobsite_delay_category` (`user_company_id`,`jobsite_delay_category`).
	 *
	 * @param string $database
	 * @param int $user_company_id
	 * @param string $jobsite_delay_category
	 * @return mixed (single ORM object | false)
	 */
	public static function findByUserCompanyIdAndJobsiteDelayCategory($database, $user_company_id, $jobsite_delay_category)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	jdc.*

FROM `jobsite_delay_categories` jdc
WHERE jdc.`user_company_id` = ?
AND jdc.`jobsite_delay_category` = ?
";
		$arrValues = array($user_company_id, $jobsite_delay_category);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if ($row && !empty($row)) {
			$jobsite_delay_category_id = $row['id'];
			$jobsiteDelayCategory = self::instantiateOrm($database, 'JobsiteDelayCategory', $row, null, $jobsite_delay_category_id);
			/* @var $jobsiteDelayCategory JobsiteDelayCategory */
			return $jobsiteDelayCategory;
		} else {
			return false;
		}
	}

	// Loaders: Load By pk List (list of auto int ids or other non auto int pk list)
	/**
	 * Load zero or more records by an id list (array of auto int primary keys).
	 *
	 * @param string $database
	 * @param array $arrJobsiteDelayCategoryIds
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadJobsiteDelayCategoriesByArrJobsiteDelayCategoryIds($database, $arrJobsiteDelayCategoryIds, Input $options=null)
	{
		if (empty($arrJobsiteDelayCategoryIds)) {
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
		// ORDER BY `id` ASC, `user_company_id` ASC, `jobsite_delay_category` ASC, `disabled_flag` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY jdc.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsiteDelayCategory = new JobsiteDelayCategory($database);
			$sqlOrderByColumns = $tmpJobsiteDelayCategory->constructSqlOrderByColumns($arrOrderByAttributes);

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

		foreach ($arrJobsiteDelayCategoryIds as $k => $jobsite_delay_category_id) {
			$jobsite_delay_category_id = (int) $jobsite_delay_category_id;
			$arrJobsiteDelayCategoryIds[$k] = $db->escape($jobsite_delay_category_id);
		}
		$csvJobsiteDelayCategoryIds = join(',', $arrJobsiteDelayCategoryIds);

		$query =
"
SELECT

	jdc.*

FROM `jobsite_delay_categories` jdc
WHERE jdc.`id` IN ($csvJobsiteDelayCategoryIds){$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		$arrJobsiteDelayCategoriesByCsvJobsiteDelayCategoryIds = array();
		while ($row = $db->fetch()) {
			$jobsite_delay_category_id = $row['id'];
			$jobsiteDelayCategory = self::instantiateOrm($database, 'JobsiteDelayCategory', $row, null, $jobsite_delay_category_id);
			/* @var $jobsiteDelayCategory JobsiteDelayCategory */
			$jobsiteDelayCategory->convertPropertiesToData();

			$arrJobsiteDelayCategoriesByCsvJobsiteDelayCategoryIds[$jobsite_delay_category_id] = $jobsiteDelayCategory;
		}

		$db->free_result();

		return $arrJobsiteDelayCategoriesByCsvJobsiteDelayCategoryIds;
	}

	// Loaders: Load By Foreign Key

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute
	/**
	 * Load by leftmost indexed attribute: unique index `unique_jobsite_delay_category` (`user_company_id`,`jobsite_delay_category`).
	 *
	 * @param string $database
	 * @param int $user_company_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadJobsiteDelayCategoriesByUserCompanyId($database, $user_company_id, Input $options=null)
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
			self::$_arrJobsiteDelayCategoriesByUserCompanyId = null;
		}

		$arrJobsiteDelayCategoriesByUserCompanyId = self::$_arrJobsiteDelayCategoriesByUserCompanyId;
		if (isset($arrJobsiteDelayCategoriesByUserCompanyId) && !empty($arrJobsiteDelayCategoriesByUserCompanyId)) {
			return $arrJobsiteDelayCategoriesByUserCompanyId;
		}

		$user_company_id = (int) $user_company_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `user_company_id` ASC, `jobsite_delay_category` ASC, `disabled_flag` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY jdc.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsiteDelayCategory = new JobsiteDelayCategory($database);
			$sqlOrderByColumns = $tmpJobsiteDelayCategory->constructSqlOrderByColumns($arrOrderByAttributes);

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
	jdc.*

FROM `jobsite_delay_categories` jdc
WHERE jdc.`user_company_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `user_company_id` ASC, `jobsite_delay_category` ASC, `disabled_flag` ASC, `sort_order` ASC
		$arrValues = array($user_company_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrJobsiteDelayCategoriesByUserCompanyId = array();
		while ($row = $db->fetch()) {
			$jobsite_delay_category_id = $row['id'];
			$jobsiteDelayCategory = self::instantiateOrm($database, 'JobsiteDelayCategory', $row, null, $jobsite_delay_category_id);
			/* @var $jobsiteDelayCategory JobsiteDelayCategory */
			$arrJobsiteDelayCategoriesByUserCompanyId[$jobsite_delay_category_id] = $jobsiteDelayCategory;
		}

		$db->free_result();

		self::$_arrJobsiteDelayCategoriesByUserCompanyId = $arrJobsiteDelayCategoriesByUserCompanyId;

		return $arrJobsiteDelayCategoriesByUserCompanyId;
	}

	// Loaders: Load All Records
	/**
	 * Load all jobsite_delay_categories records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllJobsiteDelayCategories($database, Input $options=null)
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
			self::$_arrAllJobsiteDelayCategories = null;
		}

		$arrAllJobsiteDelayCategories = self::$_arrAllJobsiteDelayCategories;
		if (isset($arrAllJobsiteDelayCategories) && !empty($arrAllJobsiteDelayCategories)) {
			return $arrAllJobsiteDelayCategories;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `user_company_id` ASC, `jobsite_delay_category` ASC, `disabled_flag` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY jdc.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsiteDelayCategory = new JobsiteDelayCategory($database);
			$sqlOrderByColumns = $tmpJobsiteDelayCategory->constructSqlOrderByColumns($arrOrderByAttributes);

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
	jdc.*

FROM `jobsite_delay_categories` jdc{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `user_company_id` ASC, `jobsite_delay_category` ASC, `disabled_flag` ASC, `sort_order` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllJobsiteDelayCategories = array();
		while ($row = $db->fetch()) {
			$jobsite_delay_category_id = $row['id'];
			$jobsiteDelayCategory = self::instantiateOrm($database, 'JobsiteDelayCategory', $row, null, $jobsite_delay_category_id);
			/* @var $jobsiteDelayCategory JobsiteDelayCategory */
			$arrAllJobsiteDelayCategories[$jobsite_delay_category_id] = $jobsiteDelayCategory;
		}

		$db->free_result();

		self::$_arrAllJobsiteDelayCategories = $arrAllJobsiteDelayCategories;

		return $arrAllJobsiteDelayCategories;
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
INTO `jobsite_delay_categories`
(`user_company_id`, `jobsite_delay_category`, `disabled_flag`, `sort_order`)
VALUES (?, ?, ?, ?)
ON DUPLICATE KEY UPDATE `disabled_flag` = ?, `sort_order` = ?
";
		$arrValues = array($this->user_company_id, $this->jobsite_delay_category, $this->disabled_flag, $this->sort_order, $this->disabled_flag, $this->sort_order);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$jobsite_delay_category_id = $db->insertId;
		$db->free_result();

		return $jobsite_delay_category_id;
	}

	// Save: insert ignore
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

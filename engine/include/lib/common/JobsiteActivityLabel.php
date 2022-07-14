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
 * JobsiteActivityLabel.
 *
 * @category   Framework
 * @package    JobsiteActivityLabel
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class JobsiteActivityLabel extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'JobsiteActivityLabel';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'jobsite_activity_labels';

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
	 * unique index `unique_jobsite_activity_label` (`user_company_id`,`jobsite_activity_label`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_jobsite_activity_label' => array(
			'user_company_id' => 'int',
			'jobsite_activity_label' => 'string'
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
		'id' => 'jobsite_activity_label_id',

		'user_company_id' => 'user_company_id',

		'jobsite_activity_label' => 'jobsite_activity_label',

		'jobsite_activity_description' => 'jobsite_activity_description',
		'sort_order' => 'sort_order',
		'disabled_flag' => 'disabled_flag'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $jobsite_activity_label_id;

	public $user_company_id;

	public $jobsite_activity_label;

	public $jobsite_activity_description;
	public $sort_order;
	public $disabled_flag;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties
	public $escaped_jobsite_activity_label;
	public $escaped_jobsite_activity_description;

	// HTML ENTITY ENCODED NL2BR ORM string properties
	public $escaped_jobsite_activity_label_nl2br;
	public $escaped_jobsite_activity_description_nl2br;

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)
	protected static $_arrJobsiteActivityLabelsByUserCompanyId;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllJobsiteActivityLabels;

	// Foreign Key Objects
	private $_userCompany;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='jobsite_activity_labels')
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
	public static function getArrJobsiteActivityLabelsByUserCompanyId()
	{
		if (isset(self::$_arrJobsiteActivityLabelsByUserCompanyId)) {
			return self::$_arrJobsiteActivityLabelsByUserCompanyId;
		} else {
			return null;
		}
	}

	public static function setArrJobsiteActivityLabelsByUserCompanyId($arrJobsiteActivityLabelsByUserCompanyId)
	{
		self::$_arrJobsiteActivityLabelsByUserCompanyId = $arrJobsiteActivityLabelsByUserCompanyId;
	}

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllJobsiteActivityLabels()
	{
		if (isset(self::$_arrAllJobsiteActivityLabels)) {
			return self::$_arrAllJobsiteActivityLabels;
		} else {
			return null;
		}
	}

	public static function setArrAllJobsiteActivityLabels($arrAllJobsiteActivityLabels)
	{
		self::$_arrAllJobsiteActivityLabels = $arrAllJobsiteActivityLabels;
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
	 * @param int $jobsite_activity_label_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findById($database, $jobsite_activity_label_id, $table='jobsite_activity_labels', $module='JobsiteActivityLabel')
	{
		$jobsiteActivityLabel = parent::findById($database, $jobsite_activity_label_id, $table, $module);

		return $jobsiteActivityLabel;
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Similar to FindById, but with SQL as starter code for more complex joins.
	 *
	 * @param string $database
	 * @param int $jobsite_activity_label_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findJobsiteActivityLabelByIdExtended($database, $jobsite_activity_label_id)
	{
		$jobsite_activity_label_id = (int) $jobsite_activity_label_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	jal_fk_uc.`id` AS 'jal_fk_uc__user_company_id',
	jal_fk_uc.`company` AS 'jal_fk_uc__company',
	jal_fk_uc.`primary_phone_number` AS 'jal_fk_uc__primary_phone_number',
	jal_fk_uc.`employer_identification_number` AS 'jal_fk_uc__employer_identification_number',
	jal_fk_uc.`construction_license_number` AS 'jal_fk_uc__construction_license_number',
	jal_fk_uc.`construction_license_number_expiration_date` AS 'jal_fk_uc__construction_license_number_expiration_date',
	jal_fk_uc.`paying_customer_flag` AS 'jal_fk_uc__paying_customer_flag',

	jal.*

FROM `jobsite_activity_labels` jal
	INNER JOIN `user_companies` jal_fk_uc ON jal.`user_company_id` = jal_fk_uc.`id`
WHERE jal.`id` = ?
";
		$arrValues = array($jobsite_activity_label_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$jobsite_activity_label_id = $row['id'];
			$jobsiteActivityLabel = self::instantiateOrm($database, 'JobsiteActivityLabel', $row, null, $jobsite_activity_label_id);
			/* @var $jobsiteActivityLabel JobsiteActivityLabel */
			$jobsiteActivityLabel->convertPropertiesToData();

			if (isset($row['user_company_id'])) {
				$user_company_id = $row['user_company_id'];
				$row['jal_fk_uc__id'] = $user_company_id;
				$userCompany = self::instantiateOrm($database, 'UserCompany', $row, null, $user_company_id, 'jal_fk_uc__');
				/* @var $userCompany UserCompany */
				$userCompany->convertPropertiesToData();
			} else {
				$userCompany = false;
			}
			$jobsiteActivityLabel->setUserCompany($userCompany);

			return $jobsiteActivityLabel;
		} else {
			return false;
		}
	}

	// Finders: Find By Unique Index
	/**
	 * Find by unique index `unique_jobsite_activity_label` (`user_company_id`,`jobsite_activity_label`).
	 *
	 * @param string $database
	 * @param int $user_company_id
	 * @param string $jobsite_activity_label
	 * @return mixed (single ORM object | false)
	 */
	public static function findByUserCompanyIdAndJobsiteActivityLabel($database, $user_company_id, $jobsite_activity_label)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	jal.*

FROM `jobsite_activity_labels` jal
WHERE jal.`user_company_id` = ?
AND jal.`jobsite_activity_label` = ?
";
		$arrValues = array($user_company_id, $jobsite_activity_label);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if ($row && !empty($row)) {
			$jobsite_activity_label_id = $row['id'];
			$jobsiteActivityLabel = self::instantiateOrm($database, 'JobsiteActivityLabel', $row, null, $jobsite_activity_label_id);
			/* @var $jobsiteActivityLabel JobsiteActivityLabel */
			return $jobsiteActivityLabel;
		} else {
			return false;
		}
	}

	// Loaders: Load By pk List (list of auto int ids or other non auto int pk list)
	/**
	 * Load zero or more records by an id list (array of auto int primary keys).
	 *
	 * @param string $database
	 * @param array $arrJobsiteActivityLabelIds
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadJobsiteActivityLabelsByArrJobsiteActivityLabelIds($database, $arrJobsiteActivityLabelIds, Input $options=null)
	{
		if (empty($arrJobsiteActivityLabelIds)) {
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
		// ORDER BY `id` ASC, `user_company_id` ASC, `jobsite_activity_label` ASC, `jobsite_activity_description` ASC, `sort_order` ASC, `disabled_flag` ASC
		$sqlOrderBy = "\nORDER BY jal.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsiteActivityLabel = new JobsiteActivityLabel($database);
			$sqlOrderByColumns = $tmpJobsiteActivityLabel->constructSqlOrderByColumns($arrOrderByAttributes);

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

		foreach ($arrJobsiteActivityLabelIds as $k => $jobsite_activity_label_id) {
			$jobsite_activity_label_id = (int) $jobsite_activity_label_id;
			$arrJobsiteActivityLabelIds[$k] = $db->escape($jobsite_activity_label_id);
		}
		$csvJobsiteActivityLabelIds = join(',', $arrJobsiteActivityLabelIds);

		$query =
"
SELECT

	jal.*

FROM `jobsite_activity_labels` jal
WHERE jal.`id` IN ($csvJobsiteActivityLabelIds){$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		$arrJobsiteActivityLabelsByCsvJobsiteActivityLabelIds = array();
		while ($row = $db->fetch()) {
			$jobsite_activity_label_id = $row['id'];
			$jobsiteActivityLabel = self::instantiateOrm($database, 'JobsiteActivityLabel', $row, null, $jobsite_activity_label_id);
			/* @var $jobsiteActivityLabel JobsiteActivityLabel */
			$jobsiteActivityLabel->convertPropertiesToData();

			$arrJobsiteActivityLabelsByCsvJobsiteActivityLabelIds[$jobsite_activity_label_id] = $jobsiteActivityLabel;
		}

		$db->free_result();

		return $arrJobsiteActivityLabelsByCsvJobsiteActivityLabelIds;
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `jobsite_activity_labels_fk_uc` foreign key (`user_company_id`) references `user_companies` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $user_company_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadJobsiteActivityLabelsByUserCompanyId($database, $user_company_id, Input $options=null)
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
			self::$_arrJobsiteActivityLabelsByUserCompanyId = null;
		}

		$arrJobsiteActivityLabelsByUserCompanyId = self::$_arrJobsiteActivityLabelsByUserCompanyId;
		if (isset($arrJobsiteActivityLabelsByUserCompanyId) && !empty($arrJobsiteActivityLabelsByUserCompanyId)) {
			return $arrJobsiteActivityLabelsByUserCompanyId;
		}

		$user_company_id = (int) $user_company_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `user_company_id` ASC, `jobsite_activity_label` ASC, `jobsite_activity_description` ASC, `sort_order` ASC, `disabled_flag` ASC
		$sqlOrderBy = "\nORDER BY `sort_order` ASC, `jobsite_activity_label` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsiteActivityLabel = new JobsiteActivityLabel($database);
			$sqlOrderByColumns = $tmpJobsiteActivityLabel->constructSqlOrderByColumns($arrOrderByAttributes);

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
	jal.*

FROM `jobsite_activity_labels` jal
WHERE jal.`user_company_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `user_company_id` ASC, `jobsite_activity_label` ASC, `jobsite_activity_description` ASC, `sort_order` ASC, `disabled_flag` ASC
		$arrValues = array($user_company_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrJobsiteActivityLabelsByUserCompanyId = array();
		while ($row = $db->fetch()) {
			$jobsite_activity_label_id = $row['id'];
			$jobsiteActivityLabel = self::instantiateOrm($database, 'JobsiteActivityLabel', $row, null, $jobsite_activity_label_id);
			/* @var $jobsiteActivityLabel JobsiteActivityLabel */
			$arrJobsiteActivityLabelsByUserCompanyId[$jobsite_activity_label_id] = $jobsiteActivityLabel;
		}

		$db->free_result();

		self::$_arrJobsiteActivityLabelsByUserCompanyId = $arrJobsiteActivityLabelsByUserCompanyId;

		return $arrJobsiteActivityLabelsByUserCompanyId;
	}

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all jobsite_activity_labels records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllJobsiteActivityLabels($database, Input $options=null)
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
			self::$_arrAllJobsiteActivityLabels = null;
		}

		$arrAllJobsiteActivityLabels = self::$_arrAllJobsiteActivityLabels;
		if (isset($arrAllJobsiteActivityLabels) && !empty($arrAllJobsiteActivityLabels)) {
			return $arrAllJobsiteActivityLabels;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `user_company_id` ASC, `jobsite_activity_label` ASC, `jobsite_activity_description` ASC, `sort_order` ASC, `disabled_flag` ASC
		$sqlOrderBy = "\nORDER BY jal.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsiteActivityLabel = new JobsiteActivityLabel($database);
			$sqlOrderByColumns = $tmpJobsiteActivityLabel->constructSqlOrderByColumns($arrOrderByAttributes);

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
	jal.*

FROM `jobsite_activity_labels` jal{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `user_company_id` ASC, `jobsite_activity_label` ASC, `jobsite_activity_description` ASC, `sort_order` ASC, `disabled_flag` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllJobsiteActivityLabels = array();
		while ($row = $db->fetch()) {
			$jobsite_activity_label_id = $row['id'];
			$jobsiteActivityLabel = self::instantiateOrm($database, 'JobsiteActivityLabel', $row, null, $jobsite_activity_label_id);
			/* @var $jobsiteActivityLabel JobsiteActivityLabel */
			$arrAllJobsiteActivityLabels[$jobsite_activity_label_id] = $jobsiteActivityLabel;
		}

		$db->free_result();

		self::$_arrAllJobsiteActivityLabels = $arrAllJobsiteActivityLabels;

		return $arrAllJobsiteActivityLabels;
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
INTO `jobsite_activity_labels`
(`user_company_id`, `jobsite_activity_label`, `jobsite_activity_description`, `sort_order`, `disabled_flag`)
VALUES (?, ?, ?, ?, ?)
ON DUPLICATE KEY UPDATE `jobsite_activity_description` = ?, `sort_order` = ?, `disabled_flag` = ?
";
		$arrValues = array($this->user_company_id, $this->jobsite_activity_label, $this->jobsite_activity_description, $this->sort_order, $this->disabled_flag, $this->jobsite_activity_description, $this->sort_order, $this->disabled_flag);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$jobsite_activity_label_id = $db->insertId;
		$db->free_result();

		return $jobsite_activity_label_id;
	}

	// Save: insert ignore
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

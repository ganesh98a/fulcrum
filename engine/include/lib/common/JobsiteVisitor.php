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
 * JobsiteVisitor.
 *
 * @category   Framework
 * @package    JobsiteVisitor
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class JobsiteVisitor extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'JobsiteVisitor';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'jobsite_visitors';

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
	 * unique index `unique_jobsite_visitors` (`jobsite_daily_log_id`,`jobsite_visitor_contact_id`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_jobsite_visitors' => array(
			'jobsite_daily_log_id' => 'int',
			'jobsite_visitor_contact_id' => 'int'
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
		'id' => 'jobsite_visitor_id',

		'jobsite_daily_log_id' => 'jobsite_daily_log_id',
		'jobsite_visitor_contact_id' => 'jobsite_visitor_contact_id'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $jobsite_visitor_id;

	public $jobsite_daily_log_id;
	public $jobsite_visitor_contact_id;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)
	protected static $_arrJobsiteVisitorsByJobsiteDailyLogId;
	protected static $_arrJobsiteVisitorsByJobsiteVisitorContactId;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllJobsiteVisitors;

	// Foreign Key Objects
	private $_jobsiteDailyLog;
	private $_jobsiteVisitorContact;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='jobsite_visitors')
	{
		parent::__construct($table);
		$this->setDatabase($database);
	}

	// Foreign Key Object Accessor Methods
	public function getJobsiteDailyLog()
	{
		if (isset($this->_jobsiteDailyLog)) {
			return $this->_jobsiteDailyLog;
		} else {
			return null;
		}
	}

	public function setJobsiteDailyLog($jobsiteDailyLog)
	{
		$this->_jobsiteDailyLog = $jobsiteDailyLog;
	}

	public function getJobsiteVisitorContact()
	{
		if (isset($this->_jobsiteVisitorContact)) {
			return $this->_jobsiteVisitorContact;
		} else {
			return null;
		}
	}

	public function setJobsiteVisitorContact($jobsiteVisitorContact)
	{
		$this->_jobsiteVisitorContact = $jobsiteVisitorContact;
	}

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)
	public static function getArrJobsiteVisitorsByJobsiteDailyLogId()
	{
		if (isset(self::$_arrJobsiteVisitorsByJobsiteDailyLogId)) {
			return self::$_arrJobsiteVisitorsByJobsiteDailyLogId;
		} else {
			return null;
		}
	}

	public static function setArrJobsiteVisitorsByJobsiteDailyLogId($arrJobsiteVisitorsByJobsiteDailyLogId)
	{
		self::$_arrJobsiteVisitorsByJobsiteDailyLogId = $arrJobsiteVisitorsByJobsiteDailyLogId;
	}

	public static function getArrJobsiteVisitorsByJobsiteVisitorContactId()
	{
		if (isset(self::$_arrJobsiteVisitorsByJobsiteVisitorContactId)) {
			return self::$_arrJobsiteVisitorsByJobsiteVisitorContactId;
		} else {
			return null;
		}
	}

	public static function setArrJobsiteVisitorsByJobsiteVisitorContactId($arrJobsiteVisitorsByJobsiteVisitorContactId)
	{
		self::$_arrJobsiteVisitorsByJobsiteVisitorContactId = $arrJobsiteVisitorsByJobsiteVisitorContactId;
	}

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllJobsiteVisitors()
	{
		if (isset(self::$_arrAllJobsiteVisitors)) {
			return self::$_arrAllJobsiteVisitors;
		} else {
			return null;
		}
	}

	public static function setArrAllJobsiteVisitors($arrAllJobsiteVisitors)
	{
		self::$_arrAllJobsiteVisitors = $arrAllJobsiteVisitors;
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
	 * @param int $jobsite_visitor_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findById($database, $jobsite_visitor_id,$table='jobsite_visitors', $module='JobsiteVisitor')
	{
		$jobsiteVisitor = parent::findById($database, $jobsite_visitor_id, $table, $module);

		return $jobsiteVisitor;
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Similar to FindById, but with SQL as starter code for more complex joins.
	 *
	 * @param string $database
	 * @param int $jobsite_visitor_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findJobsiteVisitorByIdExtended($database, $jobsite_visitor_id)
	{
		$jobsite_visitor_id = (int) $jobsite_visitor_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	jv_fk_jdl.`id` AS 'jv_fk_jdl__jobsite_daily_log_id',
	jv_fk_jdl.`project_id` AS 'jv_fk_jdl__project_id',
	jv_fk_jdl.`modified_by_contact_id` AS 'jv_fk_jdl__modified_by_contact_id',
	jv_fk_jdl.`created_by_contact_id` AS 'jv_fk_jdl__created_by_contact_id',
	jv_fk_jdl.`modified` AS 'jv_fk_jdl__modified',
	jv_fk_jdl.`jobsite_daily_log_created_date` AS 'jv_fk_jdl__jobsite_daily_log_created_date',

	jv_fk_c.`id` AS 'jv_fk_c__contact_id',
	jv_fk_c.`user_company_id` AS 'jv_fk_c__user_company_id',
	jv_fk_c.`user_id` AS 'jv_fk_c__user_id',
	jv_fk_c.`contact_company_id` AS 'jv_fk_c__contact_company_id',
	jv_fk_c.`email` AS 'jv_fk_c__email',
	jv_fk_c.`name_prefix` AS 'jv_fk_c__name_prefix',
	jv_fk_c.`first_name` AS 'jv_fk_c__first_name',
	jv_fk_c.`additional_name` AS 'jv_fk_c__additional_name',
	jv_fk_c.`middle_name` AS 'jv_fk_c__middle_name',
	jv_fk_c.`last_name` AS 'jv_fk_c__last_name',
	jv_fk_c.`name_suffix` AS 'jv_fk_c__name_suffix',
	jv_fk_c.`title` AS 'jv_fk_c__title',
	jv_fk_c.`vendor_flag` AS 'jv_fk_c__vendor_flag',

	jv.*

FROM `jobsite_visitors` jv
	INNER JOIN `jobsite_daily_logs` jv_fk_jdl ON jv.`jobsite_daily_log_id` = jv_fk_jdl.`id`
	INNER JOIN `contacts` jv_fk_c ON jv.`jobsite_visitor_contact_id` = jv_fk_c.`id`
WHERE jv.`id` = ?
";
		$arrValues = array($jobsite_visitor_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$jobsite_visitor_id = $row['id'];
			$jobsiteVisitor = self::instantiateOrm($database, 'JobsiteVisitor', $row, null, $jobsite_visitor_id);
			/* @var $jobsiteVisitor JobsiteVisitor */
			$jobsiteVisitor->convertPropertiesToData();

			if (isset($row['jobsite_daily_log_id'])) {
				$jobsite_daily_log_id = $row['jobsite_daily_log_id'];
				$row['jv_fk_jdl__id'] = $jobsite_daily_log_id;
				$jobsiteDailyLog = self::instantiateOrm($database, 'JobsiteDailyLog', $row, null, $jobsite_daily_log_id, 'jv_fk_jdl__');
				/* @var $jobsiteDailyLog JobsiteDailyLog */
				$jobsiteDailyLog->convertPropertiesToData();
			} else {
				$jobsiteDailyLog = false;
			}
			$jobsiteVisitor->setJobsiteDailyLog($jobsiteDailyLog);

			if (isset($row['jobsite_visitor_contact_id'])) {
				$jobsite_visitor_contact_id = $row['jobsite_visitor_contact_id'];
				$row['jv_fk_c__id'] = $jobsite_visitor_contact_id;
				$jobsiteVisitorContact = self::instantiateOrm($database, 'Contact', $row, null, $jobsite_visitor_contact_id, 'jv_fk_c__');
				/* @var $jobsiteVisitorContact Contact */
				$jobsiteVisitorContact->convertPropertiesToData();
			} else {
				$jobsiteVisitorContact = false;
			}
			$jobsiteVisitor->setJobsiteVisitorContact($jobsiteVisitorContact);

			return $jobsiteVisitor;
		} else {
			return false;
		}
	}

	// Finders: Find By Unique Index
	/**
	 * Find by unique index `unique_jobsite_visitors` (`jobsite_daily_log_id`,`jobsite_visitor_contact_id`).
	 *
	 * @param string $database
	 * @param int $jobsite_daily_log_id
	 * @param int $jobsite_visitor_contact_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findByJobsiteDailyLogIdAndJobsiteVisitorContactId($database, $jobsite_daily_log_id, $jobsite_visitor_contact_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	jv.*

FROM `jobsite_visitors` jv
WHERE jv.`jobsite_daily_log_id` = ?
AND jv.`jobsite_visitor_contact_id` = ?
";
		$arrValues = array($jobsite_daily_log_id, $jobsite_visitor_contact_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if ($row && !empty($row)) {
			$jobsite_visitor_id = $row['id'];
			$jobsiteVisitor = self::instantiateOrm($database, 'JobsiteVisitor', $row, null, $jobsite_visitor_id);
			/* @var $jobsiteVisitor JobsiteVisitor */
			return $jobsiteVisitor;
		} else {
			return false;
		}
	}

	// Loaders: Load By pk List (list of auto int ids or other non auto int pk list)
	/**
	 * Load zero or more records by an id list (array of auto int primary keys).
	 *
	 * @param string $database
	 * @param array $arrJobsiteVisitorIds
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadJobsiteVisitorsByArrJobsiteVisitorIds($database, $arrJobsiteVisitorIds, Input $options=null)
	{
		if (empty($arrJobsiteVisitorIds)) {
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
		// ORDER BY `id` ASC, `jobsite_daily_log_id` ASC, `jobsite_visitor_contact_id` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsiteVisitor = new JobsiteVisitor($database);
			$sqlOrderByColumns = $tmpJobsiteVisitor->constructSqlOrderByColumns($arrOrderByAttributes);

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

		foreach ($arrJobsiteVisitorIds as $k => $jobsite_visitor_id) {
			$jobsite_visitor_id = (int) $jobsite_visitor_id;
			$arrJobsiteVisitorIds[$k] = $db->escape($jobsite_visitor_id);
		}
		$csvJobsiteVisitorIds = join(',', $arrJobsiteVisitorIds);

		$query =
"
SELECT

	jv.*

FROM `jobsite_visitors` jv
WHERE jv.`id` IN ($csvJobsiteVisitorIds){$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		$arrJobsiteVisitorsByCsvJobsiteVisitorIds = array();
		while ($row = $db->fetch()) {
			$jobsite_visitor_id = $row['id'];
			$jobsiteVisitor = self::instantiateOrm($database, 'JobsiteVisitor', $row, null, $jobsite_visitor_id);
			/* @var $jobsiteVisitor JobsiteVisitor */
			$jobsiteVisitor->convertPropertiesToData();

			$arrJobsiteVisitorsByCsvJobsiteVisitorIds[$jobsite_visitor_id] = $jobsiteVisitor;
		}

		$db->free_result();

		return $arrJobsiteVisitorsByCsvJobsiteVisitorIds;
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `jobsite_visitors_fk_jdl` foreign key (`jobsite_daily_log_id`) references `jobsite_daily_logs` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $jobsite_daily_log_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadJobsiteVisitorsByJobsiteDailyLogId($database, $jobsite_daily_log_id, Input $options=null)
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
			self::$_arrJobsiteVisitorsByJobsiteDailyLogId = null;
		}

		$arrJobsiteVisitorsByJobsiteDailyLogId = self::$_arrJobsiteVisitorsByJobsiteDailyLogId;
		if (isset($arrJobsiteVisitorsByJobsiteDailyLogId) && !empty($arrJobsiteVisitorsByJobsiteDailyLogId)) {
			return $arrJobsiteVisitorsByJobsiteDailyLogId;
		}

		$jobsite_daily_log_id = (int) $jobsite_daily_log_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `jobsite_daily_log_id` ASC, `jobsite_visitor_contact_id` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsiteVisitor = new JobsiteVisitor($database);
			$sqlOrderByColumns = $tmpJobsiteVisitor->constructSqlOrderByColumns($arrOrderByAttributes);

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
	jv.*

FROM `jobsite_visitors` jv
WHERE jv.`jobsite_daily_log_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `jobsite_daily_log_id` ASC, `jobsite_visitor_contact_id` ASC
		$arrValues = array($jobsite_daily_log_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrJobsiteVisitorsByJobsiteDailyLogId = array();
		while ($row = $db->fetch()) {
			$jobsite_visitor_id = $row['id'];
			$jobsiteVisitor = self::instantiateOrm($database, 'JobsiteVisitor', $row, null, $jobsite_visitor_id);
			/* @var $jobsiteVisitor JobsiteVisitor */
			$arrJobsiteVisitorsByJobsiteDailyLogId[$jobsite_visitor_id] = $jobsiteVisitor;
		}

		$db->free_result();

		self::$_arrJobsiteVisitorsByJobsiteDailyLogId = $arrJobsiteVisitorsByJobsiteDailyLogId;

		return $arrJobsiteVisitorsByJobsiteDailyLogId;
	}

	/**
	 * Load by constraint `jobsite_visitors_fk_c` foreign key (`jobsite_visitor_contact_id`) references `contacts` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $jobsite_visitor_contact_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadJobsiteVisitorsByJobsiteVisitorContactId($database, $jobsite_visitor_contact_id, Input $options=null)
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
			self::$_arrJobsiteVisitorsByJobsiteVisitorContactId = null;
		}

		$arrJobsiteVisitorsByJobsiteVisitorContactId = self::$_arrJobsiteVisitorsByJobsiteVisitorContactId;
		if (isset($arrJobsiteVisitorsByJobsiteVisitorContactId) && !empty($arrJobsiteVisitorsByJobsiteVisitorContactId)) {
			return $arrJobsiteVisitorsByJobsiteVisitorContactId;
		}

		$jobsite_visitor_contact_id = (int) $jobsite_visitor_contact_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `jobsite_daily_log_id` ASC, `jobsite_visitor_contact_id` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsiteVisitor = new JobsiteVisitor($database);
			$sqlOrderByColumns = $tmpJobsiteVisitor->constructSqlOrderByColumns($arrOrderByAttributes);

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
	jv.*

FROM `jobsite_visitors` jv
WHERE jv.`jobsite_visitor_contact_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `jobsite_daily_log_id` ASC, `jobsite_visitor_contact_id` ASC
		$arrValues = array($jobsite_visitor_contact_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrJobsiteVisitorsByJobsiteVisitorContactId = array();
		while ($row = $db->fetch()) {
			$jobsite_visitor_id = $row['id'];
			$jobsiteVisitor = self::instantiateOrm($database, 'JobsiteVisitor', $row, null, $jobsite_visitor_id);
			/* @var $jobsiteVisitor JobsiteVisitor */
			$arrJobsiteVisitorsByJobsiteVisitorContactId[$jobsite_visitor_id] = $jobsiteVisitor;
		}

		$db->free_result();

		self::$_arrJobsiteVisitorsByJobsiteVisitorContactId = $arrJobsiteVisitorsByJobsiteVisitorContactId;

		return $arrJobsiteVisitorsByJobsiteVisitorContactId;
	}

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all jobsite_visitors records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllJobsiteVisitors($database, Input $options=null)
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
			self::$_arrAllJobsiteVisitors = null;
		}

		$arrAllJobsiteVisitors = self::$_arrAllJobsiteVisitors;
		if (isset($arrAllJobsiteVisitors) && !empty($arrAllJobsiteVisitors)) {
			return $arrAllJobsiteVisitors;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `jobsite_daily_log_id` ASC, `jobsite_visitor_contact_id` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsiteVisitor = new JobsiteVisitor($database);
			$sqlOrderByColumns = $tmpJobsiteVisitor->constructSqlOrderByColumns($arrOrderByAttributes);

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
	jv.*

FROM `jobsite_visitors` jv{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `jobsite_daily_log_id` ASC, `jobsite_visitor_contact_id` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllJobsiteVisitors = array();
		while ($row = $db->fetch()) {
			$jobsite_visitor_id = $row['id'];
			$jobsiteVisitor = self::instantiateOrm($database, 'JobsiteVisitor', $row, null, $jobsite_visitor_id);
			/* @var $jobsiteVisitor JobsiteVisitor */
			$arrAllJobsiteVisitors[$jobsite_visitor_id] = $jobsiteVisitor;
		}

		$db->free_result();

		self::$_arrAllJobsiteVisitors = $arrAllJobsiteVisitors;

		return $arrAllJobsiteVisitors;
	}

	// Save: insert on duplicate key update

	// Save: insert ignore
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

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
 * JobsiteManPower.
 *
 * @category   Framework
 * @package    JobsiteManPower
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class JobsiteManPower extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'JobsiteManPower';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'jobsite_man_power';

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
	 * unique index `unique_jobsite_man_power` (`jobsite_daily_log_id`,`subcontract_id`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_jobsite_man_power' => array(
			'jobsite_daily_log_id' => 'int',
			'subcontract_id' => 'int'
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
		'id' => 'jobsite_man_power_id',

		'jobsite_daily_log_id' => 'jobsite_daily_log_id',
		'subcontract_id' => 'subcontract_id',

		'number_of_people' => 'number_of_people'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $jobsite_man_power_id;

	public $jobsite_daily_log_id;
	public $subcontract_id;

	public $number_of_people;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties

	// HTML ENTITY ENCODED NL2BR ORM string properties

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)
	protected static $_arrJobsiteManPowerByJobsiteDailyLogId;
	protected static $_arrJobsiteManPowerBySubcontractId;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllJobsiteManPower;

	// Foreign Key Objects
	private $_jobsiteDailyLog;
	private $_subcontract;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='jobsite_man_power')
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

	public function getSubcontract()
	{
		if (isset($this->_subcontract)) {
			return $this->_subcontract;
		} else {
			return null;
		}
	}

	public function setSubcontract($subcontract)
	{
		$this->_subcontract = $subcontract;
	}

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)
	public static function getArrJobsiteManPowerByJobsiteDailyLogId()
	{
		if (isset(self::$_arrJobsiteManPowerByJobsiteDailyLogId)) {
			return self::$_arrJobsiteManPowerByJobsiteDailyLogId;
		} else {
			return null;
		}
	}

	public static function setArrJobsiteManPowerByJobsiteDailyLogId($arrJobsiteManPowerByJobsiteDailyLogId)
	{
		self::$_arrJobsiteManPowerByJobsiteDailyLogId = $arrJobsiteManPowerByJobsiteDailyLogId;
	}

	public static function getArrJobsiteManPowerBySubcontractId()
	{
		if (isset(self::$_arrJobsiteManPowerBySubcontractId)) {
			return self::$_arrJobsiteManPowerBySubcontractId;
		} else {
			return null;
		}
	}

	public static function setArrJobsiteManPowerBySubcontractId($arrJobsiteManPowerBySubcontractId)
	{
		self::$_arrJobsiteManPowerBySubcontractId = $arrJobsiteManPowerBySubcontractId;
	}

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllJobsiteManPower()
	{
		if (isset(self::$_arrAllJobsiteManPower)) {
			return self::$_arrAllJobsiteManPower;
		} else {
			return null;
		}
	}

	public static function setArrAllJobsiteManPower($arrAllJobsiteManPower)
	{
		self::$_arrAllJobsiteManPower = $arrAllJobsiteManPower;
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
	 * @param int $jobsite_man_power_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findById($database, $jobsite_man_power_id, $table='jobsite_man_power', $module='JobsiteManPower')
	{
		$jobsiteManPower = parent::findById($database, $jobsite_man_power_id, $table, $module);

		return $jobsiteManPower;
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Similar to FindById, but with SQL as starter code for more complex joins.
	 *
	 * @param string $database
	 * @param int $jobsite_man_power_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findJobsiteManPowerByIdExtended($database, $jobsite_man_power_id)
	{
		$jobsite_man_power_id = (int) $jobsite_man_power_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	jmp_fk_jdl.`id` AS 'jmp_fk_jdl__jobsite_daily_log_id',
	jmp_fk_jdl.`project_id` AS 'jmp_fk_jdl__project_id',
	jmp_fk_jdl.`modified_by_contact_id` AS 'jmp_fk_jdl__modified_by_contact_id',
	jmp_fk_jdl.`created_by_contact_id` AS 'jmp_fk_jdl__created_by_contact_id',
	jmp_fk_jdl.`modified` AS 'jmp_fk_jdl__modified',
	jmp_fk_jdl.`jobsite_daily_log_created_date` AS 'jmp_fk_jdl__jobsite_daily_log_created_date',

	jmp_fk_s.`id` AS 'jmp_fk_s__subcontract_id',
	jmp_fk_s.`gc_budget_line_item_id` AS 'jmp_fk_s__gc_budget_line_item_id',
	jmp_fk_s.`subcontract_sequence_number` AS 'jmp_fk_s__subcontract_sequence_number',
	jmp_fk_s.`subcontractor_bid_id` AS 'jmp_fk_s__subcontractor_bid_id',
	jmp_fk_s.`subcontract_template_id` AS 'jmp_fk_s__subcontract_template_id',
	jmp_fk_s.`subcontract_gc_contact_company_office_id` AS 'jmp_fk_s__subcontract_gc_contact_company_office_id',
	jmp_fk_s.`subcontract_gc_phone_contact_company_office_phone_number_id` AS 'jmp_fk_s__subcontract_gc_phone_contact_company_office_phone_number_id',
	jmp_fk_s.`subcontract_gc_fax_contact_company_office_phone_number_id` AS 'jmp_fk_s__subcontract_gc_fax_contact_company_office_phone_number_id',
	jmp_fk_s.`subcontract_gc_contact_id` AS 'jmp_fk_s__subcontract_gc_contact_id',
	jmp_fk_s.`subcontract_gc_contact_mobile_phone_number_id` AS 'jmp_fk_s__subcontract_gc_contact_mobile_phone_number_id',
	jmp_fk_s.`vendor_id` AS 'jmp_fk_s__vendor_id',
	jmp_fk_s.`subcontract_vendor_contact_company_office_id` AS 'jmp_fk_s__subcontract_vendor_contact_company_office_id',
	jmp_fk_s.`subcontract_vendor_phone_contact_company_office_phone_number_id` AS 'jmp_fk_s__subcontract_vendor_phone_contact_company_office_phone_number_id',
	jmp_fk_s.`subcontract_vendor_fax_contact_company_office_phone_number_id` AS 'jmp_fk_s__subcontract_vendor_fax_contact_company_office_phone_number_id',
	jmp_fk_s.`subcontract_vendor_contact_id` AS 'jmp_fk_s__subcontract_vendor_contact_id',
	jmp_fk_s.`subcontract_vendor_contact_mobile_phone_number_id` AS 'jmp_fk_s__subcontract_vendor_contact_mobile_phone_number_id',
	jmp_fk_s.`unsigned_subcontract_file_manager_file_id` AS 'jmp_fk_s__unsigned_subcontract_file_manager_file_id',
	jmp_fk_s.`signed_subcontract_file_manager_file_id` AS 'jmp_fk_s__signed_subcontract_file_manager_file_id',
	jmp_fk_s.`subcontract_forecasted_value` AS 'jmp_fk_s__subcontract_forecasted_value',
	jmp_fk_s.`subcontract_actual_value` AS 'jmp_fk_s__subcontract_actual_value',
	jmp_fk_s.`subcontract_retention_percentage` AS 'jmp_fk_s__subcontract_retention_percentage',
	jmp_fk_s.`subcontract_issued_date` AS 'jmp_fk_s__subcontract_issued_date',
	jmp_fk_s.`subcontract_target_execution_date` AS 'jmp_fk_s__subcontract_target_execution_date',
	jmp_fk_s.`subcontract_execution_date` AS 'jmp_fk_s__subcontract_execution_date',
	jmp_fk_s.`active_flag` AS 'jmp_fk_s__active_flag',

	jmp.*

FROM `jobsite_man_power` jmp
	INNER JOIN `jobsite_daily_logs` jmp_fk_jdl ON jmp.`jobsite_daily_log_id` = jmp_fk_jdl.`id`
	INNER JOIN `subcontracts` jmp_fk_s ON jmp.`subcontract_id` = jmp_fk_s.`id`
WHERE jmp.`id` = ?
";
		$arrValues = array($jobsite_man_power_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$jobsite_man_power_id = $row['id'];
			$jobsiteManPower = self::instantiateOrm($database, 'JobsiteManPower', $row, null, $jobsite_man_power_id);
			/* @var $jobsiteManPower JobsiteManPower */
			$jobsiteManPower->convertPropertiesToData();

			if (isset($row['jobsite_daily_log_id'])) {
				$jobsite_daily_log_id = $row['jobsite_daily_log_id'];
				$row['jmp_fk_jdl__id'] = $jobsite_daily_log_id;
				$jobsiteDailyLog = self::instantiateOrm($database, 'JobsiteDailyLog', $row, null, $jobsite_daily_log_id, 'jmp_fk_jdl__');
				/* @var $jobsiteDailyLog JobsiteDailyLog */
				$jobsiteDailyLog->convertPropertiesToData();
			} else {
				$jobsiteDailyLog = false;
			}
			$jobsiteManPower->setJobsiteDailyLog($jobsiteDailyLog);

			if (isset($row['subcontract_id'])) {
				$subcontract_id = $row['subcontract_id'];
				$row['jmp_fk_s__id'] = $subcontract_id;
				$subcontract = self::instantiateOrm($database, 'Subcontract', $row, null, $subcontract_id, 'jmp_fk_s__');
				/* @var $subcontract Subcontract */
				$subcontract->convertPropertiesToData();
			} else {
				$subcontract = false;
			}
			$jobsiteManPower->setSubcontract($subcontract);

			return $jobsiteManPower;
		} else {
			return false;
		}
	}

	// Finders: Find By Unique Index
	/**
	 * Find by unique index `unique_jobsite_man_power` (`jobsite_daily_log_id`,`subcontract_id`).
	 *
	 * @param string $database
	 * @param int $jobsite_daily_log_id
	 * @param int $subcontract_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findByJobsiteDailyLogIdAndSubcontractId($database, $jobsite_daily_log_id, $subcontract_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	jmp.*

FROM `jobsite_man_power` jmp
WHERE jmp.`jobsite_daily_log_id` = ?
AND jmp.`subcontract_id` = ?
";
		$arrValues = array($jobsite_daily_log_id, $subcontract_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if ($row && !empty($row)) {
			$jobsite_man_power_id = $row['id'];
			$jobsiteManPower = self::instantiateOrm($database, 'JobsiteManPower', $row, null, $jobsite_man_power_id);
			/* @var $jobsiteManPower JobsiteManPower */
			return $jobsiteManPower;
		} else {
			return false;
		}
	}

	// Loaders: Load By pk List (list of auto int ids or other non auto int pk list)
	/**
	 * Load zero or more records by an id list (array of auto int primary keys).
	 *
	 * @param string $database
	 * @param array $arrJobsiteManPowerIds
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadJobsiteManPowerByArrJobsiteManPowerIds($database, $arrJobsiteManPowerIds, Input $options=null)
	{
		if (empty($arrJobsiteManPowerIds)) {
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
		// ORDER BY `id` ASC, `jobsite_daily_log_id` ASC, `subcontract_id` ASC, `number_of_people` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsiteManPower = new JobsiteManPower($database);
			$sqlOrderByColumns = $tmpJobsiteManPower->constructSqlOrderByColumns($arrOrderByAttributes);

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

		foreach ($arrJobsiteManPowerIds as $k => $jobsite_man_power_id) {
			$jobsite_man_power_id = (int) $jobsite_man_power_id;
			$arrJobsiteManPowerIds[$k] = $db->escape($jobsite_man_power_id);
		}
		$csvJobsiteManPowerIds = join(',', $arrJobsiteManPowerIds);

		$query =
"
SELECT

	jmp.*

FROM `jobsite_man_power` jmp
WHERE jmp.`id` IN ($csvJobsiteManPowerIds){$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		$arrJobsiteManPowerByCsvJobsiteManPowerIds = array();
		while ($row = $db->fetch()) {
			$jobsite_man_power_id = $row['id'];
			$jobsiteManPower = self::instantiateOrm($database, 'JobsiteManPower', $row, null, $jobsite_man_power_id);
			/* @var $jobsiteManPower JobsiteManPower */
			$jobsiteManPower->convertPropertiesToData();

			$arrJobsiteManPowerByCsvJobsiteManPowerIds[$jobsite_man_power_id] = $jobsiteManPower;
		}

		$db->free_result();

		return $arrJobsiteManPowerByCsvJobsiteManPowerIds;
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `jobsite_man_power_fk_jdl` foreign key (`jobsite_daily_log_id`) references `jobsite_daily_logs` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $jobsite_daily_log_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadJobsiteManPowerByJobsiteDailyLogId($database, $jobsite_daily_log_id, Input $options=null)
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
			self::$_arrJobsiteManPowerByJobsiteDailyLogId = null;
		}

		$arrJobsiteManPowerByJobsiteDailyLogId = self::$_arrJobsiteManPowerByJobsiteDailyLogId;
		if (isset($arrJobsiteManPowerByJobsiteDailyLogId) && !empty($arrJobsiteManPowerByJobsiteDailyLogId)) {
			return $arrJobsiteManPowerByJobsiteDailyLogId;
		}

		$jobsite_daily_log_id = (int) $jobsite_daily_log_id;

		$db = DBI::getInstance($database);
		$db->free_result();
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `jobsite_daily_log_id` ASC, `subcontract_id` ASC, `number_of_people` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsiteManPower = new JobsiteManPower($database);
			$sqlOrderByColumns = $tmpJobsiteManPower->constructSqlOrderByColumns($arrOrderByAttributes);

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
	jmp.*

FROM `jobsite_man_power` jmp
WHERE jmp.`jobsite_daily_log_id` = ? {$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `jobsite_daily_log_id` ASC, `subcontract_id` ASC, `number_of_people` ASC
		$arrValues = array($jobsite_daily_log_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubcontractIds = array();
		$arrJobsiteManPowerIds = array();
		$arrJobsiteManPowerByJobsiteDailyLogId = array();
		$arrJobsiteManPowerBySubcontractId = array();
		while ($row = $db->fetch()) {
			$jobsite_man_power_id = $row['id'];
			$subcontract_id = $row['subcontract_id'];
			$jobsiteManPower = self::instantiateOrm($database, 'JobsiteManPower', $row, null, $jobsite_man_power_id);
			/* @var $jobsiteManPower JobsiteManPower */
			$arrJobsiteManPowerByJobsiteDailyLogId[$jobsite_man_power_id] = $jobsiteManPower;
			$arrSubcontractIds[$subcontract_id] = $jobsite_man_power_id;
			$arrJobsiteManPowerIds[$jobsite_man_power_id] = $subcontract_id;
			$arrJobsiteManPowerBySubcontractId[$subcontract_id] = $jobsiteManPower;
		}

		$db->free_result();

		self::$_arrJobsiteManPowerByJobsiteDailyLogId = $arrJobsiteManPowerByJobsiteDailyLogId;

		$arrReturn = array(
			'subcontract_ids' => $arrSubcontractIds,
			'jobsite_man_power_ids' => $arrJobsiteManPowerIds,
			'objects' => $arrJobsiteManPowerByJobsiteDailyLogId,
			'jobsite_man_power_by_subcontract_id' => $arrJobsiteManPowerBySubcontractId
		);

		return $arrReturn;
		//return $arrJobsiteManPowerByJobsiteDailyLogId;
	}

	/**
	 * Load by constraint `jobsite_man_power_fk_s` foreign key (`subcontract_id`) references `subcontracts` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $subcontract_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadJobsiteManPowerBySubcontractId($database, $subcontract_id, Input $options=null)
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
			self::$_arrJobsiteManPowerBySubcontractId = null;
		}

		$arrJobsiteManPowerBySubcontractId = self::$_arrJobsiteManPowerBySubcontractId;
		if (isset($arrJobsiteManPowerBySubcontractId) && !empty($arrJobsiteManPowerBySubcontractId)) {
			return $arrJobsiteManPowerBySubcontractId;
		}

		$subcontract_id = (int) $subcontract_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `jobsite_daily_log_id` ASC, `subcontract_id` ASC, `number_of_people` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsiteManPower = new JobsiteManPower($database);
			$sqlOrderByColumns = $tmpJobsiteManPower->constructSqlOrderByColumns($arrOrderByAttributes);

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
	jmp.*

FROM `jobsite_man_power` jmp
WHERE jmp.`subcontract_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `jobsite_daily_log_id` ASC, `subcontract_id` ASC, `number_of_people` ASC
		$arrValues = array($subcontract_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrJobsiteManPowerBySubcontractId = array();
		while ($row = $db->fetch()) {
			$jobsite_man_power_id = $row['id'];
			$jobsiteManPower = self::instantiateOrm($database, 'JobsiteManPower', $row, null, $jobsite_man_power_id);
			/* @var $jobsiteManPower JobsiteManPower */
			$arrJobsiteManPowerBySubcontractId[$jobsite_man_power_id] = $jobsiteManPower;
		}

		$db->free_result();

		self::$_arrJobsiteManPowerBySubcontractId = $arrJobsiteManPowerBySubcontractId;

		return $arrJobsiteManPowerBySubcontractId;
	}

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all jobsite_man_power records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllJobsiteManPower($database, Input $options=null)
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
			self::$_arrAllJobsiteManPower = null;
		}

		$arrAllJobsiteManPower = self::$_arrAllJobsiteManPower;
		if (isset($arrAllJobsiteManPower) && !empty($arrAllJobsiteManPower)) {
			return $arrAllJobsiteManPower;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `jobsite_daily_log_id` ASC, `subcontract_id` ASC, `number_of_people` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsiteManPower = new JobsiteManPower($database);
			$sqlOrderByColumns = $tmpJobsiteManPower->constructSqlOrderByColumns($arrOrderByAttributes);

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
	jmp.*

FROM `jobsite_man_power` jmp{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `jobsite_daily_log_id` ASC, `subcontract_id` ASC, `number_of_people` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllJobsiteManPower = array();
		while ($row = $db->fetch()) {
			$jobsite_man_power_id = $row['id'];
			$jobsiteManPower = self::instantiateOrm($database, 'JobsiteManPower', $row, null, $jobsite_man_power_id);
			/* @var $jobsiteManPower JobsiteManPower */
			$arrAllJobsiteManPower[$jobsite_man_power_id] = $jobsiteManPower;
		}

		$db->free_result();

		self::$_arrAllJobsiteManPower = $arrAllJobsiteManPower;

		return $arrAllJobsiteManPower;
	}
	// to check whether the subcontract has man power
	public static function checkSubcontractHasManPower($database,$subcontract_id,$date=null)
	{

		$db = DBI::getInstance($database);
		$db->free_result();
		// If date is null take current date
		if($date == null)
		{
			$jobdate = date('Y-m-d');
		}else
		{
			$jobdate = $date;
		}

		$query = "SELECT number_of_people FROM `jobsite_daily_logs` as jl inner join jobsite_man_power as jp on jl.`id` = jp.`jobsite_daily_log_id` where jl.`jobsite_daily_log_created_date` ='$jobdate' and jp.`subcontract_id` =$subcontract_id ";
		$db->query($query);

		$row = $db->fetch();
		$jobsite_man_power = $row['number_of_people'];
		
		if($jobsite_man_power && $jobsite_man_power >0)
		{
			$return ="Y";	
		}else
		{
			$return ="N";
		}
		$db->free_result();
		return $return;

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
INTO `jobsite_man_power`
(`jobsite_daily_log_id`, `subcontract_id`, `number_of_people`)
VALUES (?, ?, ?)
ON DUPLICATE KEY UPDATE `number_of_people` = ?
";
		$arrValues = array($this->jobsite_daily_log_id, $this->subcontract_id, $this->number_of_people, $this->number_of_people);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$jobsite_man_power_id = $db->insertId;
		$db->free_result();

		return $jobsite_man_power_id;
	}

	// Save: insert ignore
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

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
 * JobsiteDailyLog.
 *
 * @category   Framework
 * @package    JobsiteDailyLog
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class JobsiteDailyLog extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'JobsiteDailyLog';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'jobsite_daily_logs';

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
	 * unique index `unique_jobsite_daily_log` (`project_id`,`jobsite_daily_log_created_date`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_jobsite_daily_log' => array(
			'project_id' => 'int',
			'jobsite_daily_log_created_date' => 'string'
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
		'id' => 'jobsite_daily_log_id',

		'project_id' => 'project_id',
		'modified_by_contact_id' => 'modified_by_contact_id',
		'created_by_contact_id' => 'created_by_contact_id',

		'modified' => 'modified',
		'jobsite_daily_log_created_date' => 'jobsite_daily_log_created_date'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $jobsite_daily_log_id;

	public $project_id;
	public $modified_by_contact_id;
	public $created_by_contact_id;

	public $modified;
	public $jobsite_daily_log_created_date;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties

	// HTML ENTITY ENCODED NL2BR ORM string properties

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)
	protected static $_arrJobsiteDailyLogsByProjectId;
	protected static $_arrJobsiteDailyLogsByModifiedByContactId;
	protected static $_arrJobsiteDailyLogsByCreatedByContactId;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)
	protected static $_arrJobsiteDailyLogsByJobsiteDailyLogCreatedDate;

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllJobsiteDailyLogs;

	// Foreign Key Objects
	private $_project;
	private $_modifiedByContact;
	private $_createdByContact;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='jobsite_daily_logs')
	{
		parent::__construct($table);
		$this->setDatabase($database);
	}

	// Foreign Key Object Accessor Methods
	public function getProject()
	{
		if (isset($this->_project)) {
			return $this->_project;
		} else {
			return null;
		}
	}

	public function setProject($project)
	{
		$this->_project = $project;
	}

	public function getModifiedByContact()
	{
		if (isset($this->_modifiedByContact)) {
			return $this->_modifiedByContact;
		} else {
			return null;
		}
	}

	public function setModifiedByContact($modifiedByContact)
	{
		$this->_modifiedByContact = $modifiedByContact;
	}

	public function getCreatedByContact()
	{
		if (isset($this->_createdByContact)) {
			return $this->_createdByContact;
		} else {
			return null;
		}
	}

	public function setCreatedByContact($createdByContact)
	{
		$this->_createdByContact = $createdByContact;
	}

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)
	public static function getArrJobsiteDailyLogsByProjectId()
	{
		if (isset(self::$_arrJobsiteDailyLogsByProjectId)) {
			return self::$_arrJobsiteDailyLogsByProjectId;
		} else {
			return null;
		}
	}

	public static function setArrJobsiteDailyLogsByProjectId($arrJobsiteDailyLogsByProjectId)
	{
		self::$_arrJobsiteDailyLogsByProjectId = $arrJobsiteDailyLogsByProjectId;
	}

	public static function getArrJobsiteDailyLogsByModifiedByContactId()
	{
		if (isset(self::$_arrJobsiteDailyLogsByModifiedByContactId)) {
			return self::$_arrJobsiteDailyLogsByModifiedByContactId;
		} else {
			return null;
		}
	}

	public static function setArrJobsiteDailyLogsByModifiedByContactId($arrJobsiteDailyLogsByModifiedByContactId)
	{
		self::$_arrJobsiteDailyLogsByModifiedByContactId = $arrJobsiteDailyLogsByModifiedByContactId;
	}

	public static function getArrJobsiteDailyLogsByCreatedByContactId()
	{
		if (isset(self::$_arrJobsiteDailyLogsByCreatedByContactId)) {
			return self::$_arrJobsiteDailyLogsByCreatedByContactId;
		} else {
			return null;
		}
	}

	public static function setArrJobsiteDailyLogsByCreatedByContactId($arrJobsiteDailyLogsByCreatedByContactId)
	{
		self::$_arrJobsiteDailyLogsByCreatedByContactId = $arrJobsiteDailyLogsByCreatedByContactId;
	}

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)
	public static function getArrJobsiteDailyLogsByJobsiteDailyLogCreatedDate()
	{
		if (isset(self::$_arrJobsiteDailyLogsByJobsiteDailyLogCreatedDate)) {
			return self::$_arrJobsiteDailyLogsByJobsiteDailyLogCreatedDate;
		} else {
			return null;
		}
	}

	public static function setArrJobsiteDailyLogsByJobsiteDailyLogCreatedDate($arrJobsiteDailyLogsByJobsiteDailyLogCreatedDate)
	{
		self::$_arrJobsiteDailyLogsByJobsiteDailyLogCreatedDate = $arrJobsiteDailyLogsByJobsiteDailyLogCreatedDate;
	}

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllJobsiteDailyLogs()
	{
		if (isset(self::$_arrAllJobsiteDailyLogs)) {
			return self::$_arrAllJobsiteDailyLogs;
		} else {
			return null;
		}
	}

	public static function setArrAllJobsiteDailyLogs($arrAllJobsiteDailyLogs)
	{
		self::$_arrAllJobsiteDailyLogs = $arrAllJobsiteDailyLogs;
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
	 * @param int $jobsite_daily_log_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findById($database, $jobsite_daily_log_id, $table='jobsite_daily_logs', $module='JobsiteDailyLog')
	{
		$jobsiteDailyLog = parent::findById($database, $jobsite_daily_log_id, $table, $module);

		return $jobsiteDailyLog;
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Similar to FindById, but with SQL as starter code for more complex joins.
	 *
	 * @param string $database
	 * @param int $jobsite_daily_log_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findJobsiteDailyLogByIdExtended($database, $jobsite_daily_log_id)
	{
		$jobsite_daily_log_id = (int) $jobsite_daily_log_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	jdl_fk_p.`id` AS 'jdl_fk_p__project_id',
	jdl_fk_p.`project_type_id` AS 'jdl_fk_p__project_type_id',
	jdl_fk_p.`user_company_id` AS 'jdl_fk_p__user_company_id',
	jdl_fk_p.`user_custom_project_id` AS 'jdl_fk_p__user_custom_project_id',
	jdl_fk_p.`project_name` AS 'jdl_fk_p__project_name',
	jdl_fk_p.`project_owner_name` AS 'jdl_fk_p__project_owner_name',
	jdl_fk_p.`latitude` AS 'jdl_fk_p__latitude',
	jdl_fk_p.`longitude` AS 'jdl_fk_p__longitude',
	jdl_fk_p.`address_line_1` AS 'jdl_fk_p__address_line_1',
	jdl_fk_p.`address_line_2` AS 'jdl_fk_p__address_line_2',
	jdl_fk_p.`address_line_3` AS 'jdl_fk_p__address_line_3',
	jdl_fk_p.`address_line_4` AS 'jdl_fk_p__address_line_4',
	jdl_fk_p.`address_city` AS 'jdl_fk_p__address_city',
	jdl_fk_p.`address_county` AS 'jdl_fk_p__address_county',
	jdl_fk_p.`address_state_or_region` AS 'jdl_fk_p__address_state_or_region',
	jdl_fk_p.`address_postal_code` AS 'jdl_fk_p__address_postal_code',
	jdl_fk_p.`address_postal_code_extension` AS 'jdl_fk_p__address_postal_code_extension',
	jdl_fk_p.`address_country` AS 'jdl_fk_p__address_country',
	jdl_fk_p.`building_count` AS 'jdl_fk_p__building_count',
	jdl_fk_p.`unit_count` AS 'jdl_fk_p__unit_count',
	jdl_fk_p.`gross_square_footage` AS 'jdl_fk_p__gross_square_footage',
	jdl_fk_p.`net_rentable_square_footage` AS 'jdl_fk_p__net_rentable_square_footage',
	jdl_fk_p.`is_active_flag` AS 'jdl_fk_p__is_active_flag',
	jdl_fk_p.`public_plans_flag` AS 'jdl_fk_p__public_plans_flag',
	jdl_fk_p.`prevailing_wage_flag` AS 'jdl_fk_p__prevailing_wage_flag',
	jdl_fk_p.`city_business_license_required_flag` AS 'jdl_fk_p__city_business_license_required_flag',
	jdl_fk_p.`is_internal_flag` AS 'jdl_fk_p__is_internal_flag',
	jdl_fk_p.`project_contract_date` AS 'jdl_fk_p__project_contract_date',
	jdl_fk_p.`project_start_date` AS 'jdl_fk_p__project_start_date',
	jdl_fk_p.`project_completed_date` AS 'jdl_fk_p__project_completed_date',
	jdl_fk_p.`sort_order` AS 'jdl_fk_p__sort_order',
	jdl_fk_p.`max_photos_displayed` AS 'jdl_fk_p__max_photos_displayed',
	jdl_fk_p.`photos_displayed_per_page` AS 'jdl_fk_p__photos_displayed_per_page',

	jdl_fk_modified_by_c.`id` AS 'jdl_fk_modified_by_c__contact_id',
	jdl_fk_modified_by_c.`user_company_id` AS 'jdl_fk_modified_by_c__user_company_id',
	jdl_fk_modified_by_c.`user_id` AS 'jdl_fk_modified_by_c__user_id',
	jdl_fk_modified_by_c.`contact_company_id` AS 'jdl_fk_modified_by_c__contact_company_id',
	jdl_fk_modified_by_c.`email` AS 'jdl_fk_modified_by_c__email',
	jdl_fk_modified_by_c.`name_prefix` AS 'jdl_fk_modified_by_c__name_prefix',
	jdl_fk_modified_by_c.`first_name` AS 'jdl_fk_modified_by_c__first_name',
	jdl_fk_modified_by_c.`additional_name` AS 'jdl_fk_modified_by_c__additional_name',
	jdl_fk_modified_by_c.`middle_name` AS 'jdl_fk_modified_by_c__middle_name',
	jdl_fk_modified_by_c.`last_name` AS 'jdl_fk_modified_by_c__last_name',
	jdl_fk_modified_by_c.`name_suffix` AS 'jdl_fk_modified_by_c__name_suffix',
	jdl_fk_modified_by_c.`title` AS 'jdl_fk_modified_by_c__title',
	jdl_fk_modified_by_c.`vendor_flag` AS 'jdl_fk_modified_by_c__vendor_flag',

	jdl_fk_created_by_c.`id` AS 'jdl_fk_created_by_c__contact_id',
	jdl_fk_created_by_c.`user_company_id` AS 'jdl_fk_created_by_c__user_company_id',
	jdl_fk_created_by_c.`user_id` AS 'jdl_fk_created_by_c__user_id',
	jdl_fk_created_by_c.`contact_company_id` AS 'jdl_fk_created_by_c__contact_company_id',
	jdl_fk_created_by_c.`email` AS 'jdl_fk_created_by_c__email',
	jdl_fk_created_by_c.`name_prefix` AS 'jdl_fk_created_by_c__name_prefix',
	jdl_fk_created_by_c.`first_name` AS 'jdl_fk_created_by_c__first_name',
	jdl_fk_created_by_c.`additional_name` AS 'jdl_fk_created_by_c__additional_name',
	jdl_fk_created_by_c.`middle_name` AS 'jdl_fk_created_by_c__middle_name',
	jdl_fk_created_by_c.`last_name` AS 'jdl_fk_created_by_c__last_name',
	jdl_fk_created_by_c.`name_suffix` AS 'jdl_fk_created_by_c__name_suffix',
	jdl_fk_created_by_c.`title` AS 'jdl_fk_created_by_c__title',
	jdl_fk_created_by_c.`vendor_flag` AS 'jdl_fk_created_by_c__vendor_flag',

	p_fk_uc.`id` AS 'p_fk_uc__user_company_id',
	p_fk_uc.`company` AS 'p_fk_uc__company',
	p_fk_uc.`primary_phone_number` AS 'p_fk_uc__primary_phone_number',
	p_fk_uc.`employer_identification_number` AS 'p_fk_uc__employer_identification_number',
	p_fk_uc.`construction_license_number` AS 'p_fk_uc__construction_license_number',
	p_fk_uc.`construction_license_number_expiration_date` AS 'p_fk_uc__construction_license_number_expiration_date',
	p_fk_uc.`paying_customer_flag` AS 'p_fk_uc__paying_customer_flag',

	jdl.*

FROM `jobsite_daily_logs` jdl
	INNER JOIN `projects` jdl_fk_p ON jdl.`project_id` = jdl_fk_p.`id`
	LEFT OUTER JOIN `contacts` jdl_fk_modified_by_c ON jdl.`modified_by_contact_id` = jdl_fk_modified_by_c.`id`
	LEFT OUTER JOIN `contacts` jdl_fk_created_by_c ON jdl.`created_by_contact_id` = jdl_fk_created_by_c.`id`

	INNER JOIN `user_companies` p_fk_uc ON jdl_fk_p.`user_company_id` = p_fk_uc.`id`
WHERE jdl.`id` = ?
";

		$arrValues = array($jobsite_daily_log_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$jobsite_daily_log_id = $row['id'];
			$jobsiteDailyLog = self::instantiateOrm($database, 'JobsiteDailyLog', $row, null, $jobsite_daily_log_id);
			/* @var $jobsiteDailyLog JobsiteDailyLog */
			$jobsiteDailyLog->convertPropertiesToData();

			if (isset($row['project_id'])) {
				$project_id = $row['project_id'];
				$row['jdl_fk_p__id'] = $project_id;
				$project = self::instantiateOrm($database, 'Project', $row, null, $project_id, 'jdl_fk_p__');
				/* @var $project Project */
				$project->convertPropertiesToData();
			} else {
				$project = false;
			}
			$jobsiteDailyLog->setProject($project);

			if (isset($row['modified_by_contact_id'])) {
				$modified_by_contact_id = $row['modified_by_contact_id'];
				$row['jdl_fk_modified_by_c__id'] = $modified_by_contact_id;
				$modifiedByContact = self::instantiateOrm($database, 'Contact', $row, null, $modified_by_contact_id, 'jdl_fk_modified_by_c__');
				/* @var $modifiedByContact Contact */
				$modifiedByContact->convertPropertiesToData();
			} else {
				$modifiedByContact = false;
			}
			$jobsiteDailyLog->setModifiedByContact($modifiedByContact);

			if (isset($row['created_by_contact_id'])) {
				$created_by_contact_id = $row['created_by_contact_id'];
				$row['jdl_fk_created_by_c__id'] = $created_by_contact_id;
				$createdByContact = self::instantiateOrm($database, 'Contact', $row, null, $created_by_contact_id, 'jdl_fk_created_by_c__');
				/* @var $createdByContact Contact */
				$createdByContact->convertPropertiesToData();
			} else {
				$createdByContact = false;
			}
			$jobsiteDailyLog->setCreatedByContact($createdByContact);

			if (isset($row['p_fk_uc__user_company_id'])) {
				$user_company_id = $row['p_fk_uc__user_company_id'];
				$row['p_fk_uc__id'] = $user_company_id;
				$userCompany = self::instantiateOrm($database, 'UserCompany', $row, null, $user_company_id, 'p_fk_uc__');
				/* @var $userCompany UserCompany */
				$userCompany->convertPropertiesToData();
			} else {
				$userCompany = false;
			}
			$project->setUserCompany($userCompany);

			return $jobsiteDailyLog;
		} else {
			return false;
		}
	}
	// Finders: Find By Unique Index
	/**
	 * Find by unique index `unique_jobsite_daily_log` (`project_id`,`jobsite_daily_log_created_date`).
	 *
	 * @param string $database
	 * @param int $project_id
	 * @param string $jobsite_daily_log_created_date
	 * @return mixed (single ORM object | false)
	 */
	//To get the Jobsite Id based on a Date
public static function findByProjectIdForJobsiteDailyLogDate($database, $project_id, $jobsite_start_date,$jobSite_end_date)
	{
		$db = DBI::getInstance($database);
		$db->free_result();
		/* @var $db DBI_mysqli */
  $query =
"
SELECT
	jdl.*

FROM `jobsite_daily_logs` jdl
WHERE jdl.`project_id` = ?
AND jdl.`jobsite_daily_log_created_date` between ? and ?
";
		$arrValues = array($project_id, $jobsite_start_date,$jobSite_end_date);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$jobsite_daily_log_id=array();
		// if ($row1 && !empty($row1)) {
					while ($row = $db->fetch()) {
						 $jobsite_daily_log_id[] = $row['id'];
			$jobsiteDailyLog = self::instantiateOrm($database, 'JobsiteDailyLog', $row, null, $jobsite_daily_log_id);
			/* @var $jobsiteDailyLog JobsiteDailyLog */
			
		}
		return $jobsite_daily_log_id;
		// } else {
		// 	return false;
		// }
	}

	
	// Finders: Find By Unique Index
	/**
	 * Find by unique index `unique_jobsite_daily_log` (`project_id`,`jobsite_daily_log_created_date`).
	 *
	 * @param string $database
	 * @param int $project_id
	 * @param string $jobsite_daily_log_created_date
	 * @return mixed (single ORM object | false)
	 */
	//To get the Jobsite Id based on a Date
public static function findByProjectIdForJobsiteDailyDateValues($database, $project_id, $jobsite_start_date,$jobSite_end_date)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */
		$db->free_result();
		  $query =
"
SELECT
	jdl.*

FROM `jobsite_daily_logs` jdl
WHERE jdl.`project_id` = ?
AND jdl.`jobsite_daily_log_created_date` between ? and ?
";
		$arrValues = array($project_id, $jobsite_start_date,$jobSite_end_date);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$jobsite_daily_log_date=array();
		
					while ($row = $db->fetch()) {
			$jobsite_daily_log_date[] = $row['jobsite_daily_log_created_date'];
			// $jobsiteDailyLog = self::instantiateOrm($database, 'JobsiteDailyLog', $row, null, $jobsite_daily_log_id);
			/* @var $jobsiteDailyLog JobsiteDailyLog */
			
		}
		return $jobsite_daily_log_date;
		
	}

	

	// Finders: Find By Unique Index
	/**
	 * Find by unique index `unique_jobsite_daily_log` (`project_id`,`jobsite_daily_log_created_date`).
	 *
	 * @param string $database
	 * @param int $project_id
	 * @param string $jobsite_daily_log_created_date
	 * @return mixed (single ORM object | false)
	 */
	public static function findByProjectIdAndJobsiteDailyLogCreatedDate($database, $project_id, $jobsite_daily_log_created_date)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$querys =
"
SELECT
	jdl.*

FROM `jobsite_daily_logs` jdl
WHERE jdl.`project_id` = $project_id
AND jdl.`jobsite_daily_log_created_date` = '$jobsite_daily_log_created_date'
";
		$arrValues = array($project_id, $jobsite_daily_log_created_date);
		$db->execute($querys);
		$rows = $db->fetch();
		$db->free_result();
		if ($rows && !empty($rows)) {
			$jobsite_daily_log_id = $rows['id'];
			$jobsiteDailyLog = self::instantiateOrm($database, 'JobsiteDailyLog', $rows, null, $jobsite_daily_log_id);
			/* @var $jobsiteDailyLog JobsiteDailyLog */
			return $jobsiteDailyLog;
		} else {
			return false;
		}
	}

	// Loaders: Load By pk List (list of auto int ids or other non auto int pk list)
	/**
	 * Load zero or more records by an id list (array of auto int primary keys).
	 *
	 * @param string $database
	 * @param array $arrJobsiteDailyLogIds
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadJobsiteDailyLogsByArrJobsiteDailyLogIds($database, $arrJobsiteDailyLogIds, Input $options=null)
	{
		if (empty($arrJobsiteDailyLogIds)) {
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
		// ORDER BY `id` ASC, `project_id` ASC, `modified_by_contact_id` ASC, `created_by_contact_id` ASC, `modified` ASC, `jobsite_daily_log_created_date` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsiteDailyLog = new JobsiteDailyLog($database);
			$sqlOrderByColumns = $tmpJobsiteDailyLog->constructSqlOrderByColumns($arrOrderByAttributes);

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

		foreach ($arrJobsiteDailyLogIds as $k => $jobsite_daily_log_id) {
			$jobsite_daily_log_id = (int) $jobsite_daily_log_id;
			$arrJobsiteDailyLogIds[$k] = $db->escape($jobsite_daily_log_id);
		}
		$csvJobsiteDailyLogIds = join(',', $arrJobsiteDailyLogIds);

		$query =
"
SELECT

	jdl.*

FROM `jobsite_daily_logs` jdl
WHERE jdl.`id` IN ($csvJobsiteDailyLogIds){$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		$arrJobsiteDailyLogsByCsvJobsiteDailyLogIds = array();
		while ($row = $db->fetch()) {
			$jobsite_daily_log_id = $row['id'];
			$jobsiteDailyLog = self::instantiateOrm($database, 'JobsiteDailyLog', $row, null, $jobsite_daily_log_id);
			/* @var $jobsiteDailyLog JobsiteDailyLog */
			$jobsiteDailyLog->convertPropertiesToData();

			$arrJobsiteDailyLogsByCsvJobsiteDailyLogIds[$jobsite_daily_log_id] = $jobsiteDailyLog;
		}

		$db->free_result();

		return $arrJobsiteDailyLogsByCsvJobsiteDailyLogIds;
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `jobsite_daily_logs_fk_p` foreign key (`project_id`) references `projects` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $project_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadJobsiteDailyLogsByProjectId($database, $project_id, Input $options=null)
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
			self::$_arrJobsiteDailyLogsByProjectId = null;
		}

		$arrJobsiteDailyLogsByProjectId = self::$_arrJobsiteDailyLogsByProjectId;
		if (isset($arrJobsiteDailyLogsByProjectId) && !empty($arrJobsiteDailyLogsByProjectId)) {
			return $arrJobsiteDailyLogsByProjectId;
		}

		$project_id = (int) $project_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `modified_by_contact_id` ASC, `created_by_contact_id` ASC, `modified` ASC, `jobsite_daily_log_created_date` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsiteDailyLog = new JobsiteDailyLog($database);
			$sqlOrderByColumns = $tmpJobsiteDailyLog->constructSqlOrderByColumns($arrOrderByAttributes);

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
	jdl.*

FROM `jobsite_daily_logs` jdl
WHERE jdl.`project_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `modified_by_contact_id` ASC, `created_by_contact_id` ASC, `modified` ASC, `jobsite_daily_log_created_date` ASC
		$arrValues = array($project_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrJobsiteDailyLogsByProjectId = array();
		while ($row = $db->fetch()) {
			$jobsite_daily_log_id = $row['id'];
			$jobsiteDailyLog = self::instantiateOrm($database, 'JobsiteDailyLog', $row, null, $jobsite_daily_log_id);
			/* @var $jobsiteDailyLog JobsiteDailyLog */
			$arrJobsiteDailyLogsByProjectId[$jobsite_daily_log_id] = $jobsiteDailyLog;
		}

		$db->free_result();

		self::$_arrJobsiteDailyLogsByProjectId = $arrJobsiteDailyLogsByProjectId;

		return $arrJobsiteDailyLogsByProjectId;
	}

	/**
	 * Load by constraint `jobsite_daily_logs_fk_modified_by_c` foreign key (`modified_by_contact_id`) references `contacts` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $modified_by_contact_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadJobsiteDailyLogsByModifiedByContactId($database, $modified_by_contact_id, Input $options=null)
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
			self::$_arrJobsiteDailyLogsByModifiedByContactId = null;
		}

		$arrJobsiteDailyLogsByModifiedByContactId = self::$_arrJobsiteDailyLogsByModifiedByContactId;
		if (isset($arrJobsiteDailyLogsByModifiedByContactId) && !empty($arrJobsiteDailyLogsByModifiedByContactId)) {
			return $arrJobsiteDailyLogsByModifiedByContactId;
		}

		$modified_by_contact_id = (int) $modified_by_contact_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `modified_by_contact_id` ASC, `created_by_contact_id` ASC, `modified` ASC, `jobsite_daily_log_created_date` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsiteDailyLog = new JobsiteDailyLog($database);
			$sqlOrderByColumns = $tmpJobsiteDailyLog->constructSqlOrderByColumns($arrOrderByAttributes);

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
	jdl.*

FROM `jobsite_daily_logs` jdl
WHERE jdl.`modified_by_contact_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `modified_by_contact_id` ASC, `created_by_contact_id` ASC, `modified` ASC, `jobsite_daily_log_created_date` ASC
		$arrValues = array($modified_by_contact_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrJobsiteDailyLogsByModifiedByContactId = array();
		while ($row = $db->fetch()) {
			$jobsite_daily_log_id = $row['id'];
			$jobsiteDailyLog = self::instantiateOrm($database, 'JobsiteDailyLog', $row, null, $jobsite_daily_log_id);
			/* @var $jobsiteDailyLog JobsiteDailyLog */
			$arrJobsiteDailyLogsByModifiedByContactId[$jobsite_daily_log_id] = $jobsiteDailyLog;
		}

		$db->free_result();

		self::$_arrJobsiteDailyLogsByModifiedByContactId = $arrJobsiteDailyLogsByModifiedByContactId;

		return $arrJobsiteDailyLogsByModifiedByContactId;
	}

	/**
	 * Load by constraint `jobsite_daily_logs_fk_created_by_c` foreign key (`created_by_contact_id`) references `contacts` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $created_by_contact_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadJobsiteDailyLogsByCreatedByContactId($database, $created_by_contact_id, Input $options=null)
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
			self::$_arrJobsiteDailyLogsByCreatedByContactId = null;
		}

		$arrJobsiteDailyLogsByCreatedByContactId = self::$_arrJobsiteDailyLogsByCreatedByContactId;
		if (isset($arrJobsiteDailyLogsByCreatedByContactId) && !empty($arrJobsiteDailyLogsByCreatedByContactId)) {
			return $arrJobsiteDailyLogsByCreatedByContactId;
		}

		$created_by_contact_id = (int) $created_by_contact_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `modified_by_contact_id` ASC, `created_by_contact_id` ASC, `modified` ASC, `jobsite_daily_log_created_date` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsiteDailyLog = new JobsiteDailyLog($database);
			$sqlOrderByColumns = $tmpJobsiteDailyLog->constructSqlOrderByColumns($arrOrderByAttributes);

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
	jdl.*

FROM `jobsite_daily_logs` jdl
WHERE jdl.`created_by_contact_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `modified_by_contact_id` ASC, `created_by_contact_id` ASC, `modified` ASC, `jobsite_daily_log_created_date` ASC
		$arrValues = array($created_by_contact_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrJobsiteDailyLogsByCreatedByContactId = array();
		while ($row = $db->fetch()) {
			$jobsite_daily_log_id = $row['id'];
			$jobsiteDailyLog = self::instantiateOrm($database, 'JobsiteDailyLog', $row, null, $jobsite_daily_log_id);
			/* @var $jobsiteDailyLog JobsiteDailyLog */
			$arrJobsiteDailyLogsByCreatedByContactId[$jobsite_daily_log_id] = $jobsiteDailyLog;
		}

		$db->free_result();

		self::$_arrJobsiteDailyLogsByCreatedByContactId = $arrJobsiteDailyLogsByCreatedByContactId;

		return $arrJobsiteDailyLogsByCreatedByContactId;
	}

	// Loaders: Load By index
	/**
	 * Load by key `jobsite_daily_log_created_date` (`jobsite_daily_log_created_date`).
	 *
	 * @param string $database
	 * @param string $jobsite_daily_log_created_date
	 * @param mixed (Input $options object | null)
	 * @return mixed (single ORM object | false)
	 */
	public static function loadJobsiteDailyLogsByJobsiteDailyLogCreatedDate($database, $jobsite_daily_log_created_date, $time=null, $project_id=null, Input $options=null)
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

		$arrValues = array($jobsite_daily_log_created_date);

		$hasTime = '';
		if (!empty($time)) {
			$hasTime = "and jdl_fk_p.`delivery_time` = ?";
			array_push($arrValues,$time);
		}

		$hasProject = '';
		if (!empty($project_id)) {
			$hasProject = "and jdl_fk_p.`id` = ?";
			array_push($arrValues,$project_id);
		}

		if ($forceLoadFlag) {
			self::$_arrJobsiteDailyLogsByJobsiteDailyLogCreatedDate = null;
		}

		$arrJobsiteDailyLogsByJobsiteDailyLogCreatedDate = self::$_arrJobsiteDailyLogsByJobsiteDailyLogCreatedDate;
		if (isset($arrJobsiteDailyLogsByJobsiteDailyLogCreatedDate) && !empty($arrJobsiteDailyLogsByJobsiteDailyLogCreatedDate)) {
			return $arrJobsiteDailyLogsByJobsiteDailyLogCreatedDate;
		}

		$jobsite_daily_log_created_date = (string) $jobsite_daily_log_created_date;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `modified_by_contact_id` ASC, `created_by_contact_id` ASC, `modified` ASC, `jobsite_daily_log_created_date` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsiteDailyLog = new JobsiteDailyLog($database);
			$sqlOrderByColumns = $tmpJobsiteDailyLog->constructSqlOrderByColumns($arrOrderByAttributes);

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

	jdl_fk_p.`id` AS 'jdl_fk_p__project_id',
	jdl_fk_p.`project_type_id` AS 'jdl_fk_p__project_type_id',
	jdl_fk_p.`user_company_id` AS 'jdl_fk_p__user_company_id',
	jdl_fk_p.`user_custom_project_id` AS 'jdl_fk_p__user_custom_project_id',
	jdl_fk_p.`project_name` AS 'jdl_fk_p__project_name',
	jdl_fk_p.`project_owner_name` AS 'jdl_fk_p__project_owner_name',
	jdl_fk_p.`latitude` AS 'jdl_fk_p__latitude',
	jdl_fk_p.`longitude` AS 'jdl_fk_p__longitude',
	jdl_fk_p.`address_line_1` AS 'jdl_fk_p__address_line_1',
	jdl_fk_p.`address_line_2` AS 'jdl_fk_p__address_line_2',
	jdl_fk_p.`address_line_3` AS 'jdl_fk_p__address_line_3',
	jdl_fk_p.`address_line_4` AS 'jdl_fk_p__address_line_4',
	jdl_fk_p.`address_city` AS 'jdl_fk_p__address_city',
	jdl_fk_p.`address_county` AS 'jdl_fk_p__address_county',
	jdl_fk_p.`address_state_or_region` AS 'jdl_fk_p__address_state_or_region',
	jdl_fk_p.`address_postal_code` AS 'jdl_fk_p__address_postal_code',
	jdl_fk_p.`address_postal_code_extension` AS 'jdl_fk_p__address_postal_code_extension',
	jdl_fk_p.`address_country` AS 'jdl_fk_p__address_country',
	jdl_fk_p.`building_count` AS 'jdl_fk_p__building_count',
	jdl_fk_p.`unit_count` AS 'jdl_fk_p__unit_count',
	jdl_fk_p.`gross_square_footage` AS 'jdl_fk_p__gross_square_footage',
	jdl_fk_p.`net_rentable_square_footage` AS 'jdl_fk_p__net_rentable_square_footage',
	jdl_fk_p.`is_active_flag` AS 'jdl_fk_p__is_active_flag',
	jdl_fk_p.`public_plans_flag` AS 'jdl_fk_p__public_plans_flag',
	jdl_fk_p.`prevailing_wage_flag` AS 'jdl_fk_p__prevailing_wage_flag',
	jdl_fk_p.`city_business_license_required_flag` AS 'jdl_fk_p__city_business_license_required_flag',
	jdl_fk_p.`is_internal_flag` AS 'jdl_fk_p__is_internal_flag',
	jdl_fk_p.`project_contract_date` AS 'jdl_fk_p__project_contract_date',
	jdl_fk_p.`project_start_date` AS 'jdl_fk_p__project_start_date',
	jdl_fk_p.`project_completed_date` AS 'jdl_fk_p__project_completed_date',
	jdl_fk_p.`sort_order` AS 'jdl_fk_p__sort_order',
	jdl_fk_p.`delivery_time` AS 'jdl_fk_p__delivery_time',
	jdl_fk_p.`max_photos_displayed` AS 'jdl_fk_p__max_photos_displayed',

	jdl_fk_modified_by_c.`id` AS 'jdl_fk_modified_by_c__contact_id',
	jdl_fk_modified_by_c.`user_company_id` AS 'jdl_fk_modified_by_c__user_company_id',
	jdl_fk_modified_by_c.`user_id` AS 'jdl_fk_modified_by_c__user_id',
	jdl_fk_modified_by_c.`contact_company_id` AS 'jdl_fk_modified_by_c__contact_company_id',
	jdl_fk_modified_by_c.`email` AS 'jdl_fk_modified_by_c__email',
	jdl_fk_modified_by_c.`name_prefix` AS 'jdl_fk_modified_by_c__name_prefix',
	jdl_fk_modified_by_c.`first_name` AS 'jdl_fk_modified_by_c__first_name',
	jdl_fk_modified_by_c.`additional_name` AS 'jdl_fk_modified_by_c__additional_name',
	jdl_fk_modified_by_c.`middle_name` AS 'jdl_fk_modified_by_c__middle_name',
	jdl_fk_modified_by_c.`last_name` AS 'jdl_fk_modified_by_c__last_name',
	jdl_fk_modified_by_c.`name_suffix` AS 'jdl_fk_modified_by_c__name_suffix',
	jdl_fk_modified_by_c.`title` AS 'jdl_fk_modified_by_c__title',
	jdl_fk_modified_by_c.`vendor_flag` AS 'jdl_fk_modified_by_c__vendor_flag',

	jdl_fk_created_by_c.`id` AS 'jdl_fk_created_by_c__contact_id',
	jdl_fk_created_by_c.`user_company_id` AS 'jdl_fk_created_by_c__user_company_id',
	jdl_fk_created_by_c.`user_id` AS 'jdl_fk_created_by_c__user_id',
	jdl_fk_created_by_c.`contact_company_id` AS 'jdl_fk_created_by_c__contact_company_id',
	jdl_fk_created_by_c.`email` AS 'jdl_fk_created_by_c__email',
	jdl_fk_created_by_c.`name_prefix` AS 'jdl_fk_created_by_c__name_prefix',
	jdl_fk_created_by_c.`first_name` AS 'jdl_fk_created_by_c__first_name',
	jdl_fk_created_by_c.`additional_name` AS 'jdl_fk_created_by_c__additional_name',
	jdl_fk_created_by_c.`middle_name` AS 'jdl_fk_created_by_c__middle_name',
	jdl_fk_created_by_c.`last_name` AS 'jdl_fk_created_by_c__last_name',
	jdl_fk_created_by_c.`name_suffix` AS 'jdl_fk_created_by_c__name_suffix',
	jdl_fk_created_by_c.`title` AS 'jdl_fk_created_by_c__title',
	jdl_fk_created_by_c.`vendor_flag` AS 'jdl_fk_created_by_c__vendor_flag',

	p_fk_uc.`id` AS 'p_fk_uc__user_company_id',
	p_fk_uc.`company` AS 'p_fk_uc__company',
	p_fk_uc.`primary_phone_number` AS 'p_fk_uc__primary_phone_number',
	p_fk_uc.`employer_identification_number` AS 'p_fk_uc__employer_identification_number',
	p_fk_uc.`construction_license_number` AS 'p_fk_uc__construction_license_number',
	p_fk_uc.`construction_license_number_expiration_date` AS 'p_fk_uc__construction_license_number_expiration_date',
	p_fk_uc.`paying_customer_flag` AS 'p_fk_uc__paying_customer_flag',

	jdl.*

FROM `jobsite_daily_logs` jdl
	INNER JOIN `projects` jdl_fk_p ON jdl.`project_id` = jdl_fk_p.`id`
	LEFT OUTER JOIN `contacts` jdl_fk_modified_by_c ON jdl.`modified_by_contact_id` = jdl_fk_modified_by_c.`id`
	LEFT OUTER JOIN `contacts` jdl_fk_created_by_c ON jdl.`created_by_contact_id` = jdl_fk_created_by_c.`id`

	INNER JOIN `user_companies` p_fk_uc ON jdl_fk_p.`user_company_id` = p_fk_uc.`id`
WHERE jdl.`jobsite_daily_log_created_date` = ? AND jdl.`modified_by_contact_id` <> '' $hasTime $hasProject {$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `modified_by_contact_id` ASC, `created_by_contact_id` ASC, `modified` ASC, `jobsite_daily_log_created_date` ASC

		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrJobsiteDailyLogsByJobsiteDailyLogCreatedDate = array();
		while ($row = $db->fetch()) {
			$jobsite_daily_log_id = $row['id'];
			$jobsiteDailyLog = self::instantiateOrm($database, 'JobsiteDailyLog', $row, null, $jobsite_daily_log_id);
			/* @var $jobsiteDailyLog JobsiteDailyLog */
			$jobsiteDailyLog->convertPropertiesToData();

			if (isset($row['project_id'])) {
				$project_id = $row['project_id'];
				$row['jdl_fk_p__id'] = $project_id;
				$project = self::instantiateOrm($database, 'Project', $row, null, $project_id, 'jdl_fk_p__');
				/* @var $project Project */
				$project->convertPropertiesToData();
			} else {
				$project = false;
			}
			$jobsiteDailyLog->setProject($project);

			if (isset($row['modified_by_contact_id'])) {
				$modified_by_contact_id = $row['modified_by_contact_id'];
				$row['jdl_fk_modified_by_c__id'] = $modified_by_contact_id;
				$modifiedByContact = self::instantiateOrm($database, 'Contact', $row, null, $modified_by_contact_id, 'jdl_fk_modified_by_c__');
				/* @var $modifiedByContact Contact */
				$modifiedByContact->convertPropertiesToData();
			} else {
				$modifiedByContact = false;
			}
			$jobsiteDailyLog->setModifiedByContact($modifiedByContact);

			if (isset($row['created_by_contact_id'])) {
				$created_by_contact_id = $row['created_by_contact_id'];
				$row['jdl_fk_created_by_c__id'] = $created_by_contact_id;
				$createdByContact = self::instantiateOrm($database, 'Contact', $row, null, $created_by_contact_id, 'jdl_fk_created_by_c__');
				/* @var $createdByContact Contact */
				$createdByContact->convertPropertiesToData();
			} else {
				$createdByContact = false;
			}
			$jobsiteDailyLog->setCreatedByContact($createdByContact);

			if (isset($row['p_fk_uc__user_company_id'])) {
				$user_company_id = $row['p_fk_uc__user_company_id'];
				$row['p_fk_uc__id'] = $user_company_id;
				$userCompany = self::instantiateOrm($database, 'UserCompany', $row, null, $user_company_id, 'p_fk_uc__');
				/* @var $userCompany UserCompany */
				$userCompany->convertPropertiesToData();
			} else {
				$userCompany = false;
			}
			$project->setUserCompany($userCompany);

			$arrJobsiteDailyLogsByJobsiteDailyLogCreatedDate[$jobsite_daily_log_id] = $jobsiteDailyLog;
		}

		$db->free_result();

		self::$_arrJobsiteDailyLogsByJobsiteDailyLogCreatedDate = $arrJobsiteDailyLogsByJobsiteDailyLogCreatedDate;

		return $arrJobsiteDailyLogsByJobsiteDailyLogCreatedDate;
	}
	//To get the sort order
	public function NextsortOrderDaliylog($table,$project_id)
	{
		$db = DBI::getInstance($database);
		$query = "SELECT max(sort_order) as sort_order FROM $table where project_id=$project_id ";
		$db->execute($query);
		$row = $db->fetch();
		if($row)
		$sort_data=$row['sort_order']+1;
		else
		$sort_data='0';
		return $sort_data;
	}
	//To update the sort order
	public function updateDaliylogSortOrder($table,$project_id,$id, $new_sort_order)
	{

		//To get the original Id
		$db = DBI::getInstance($database);
		$query = "SELECT sort_order FROM $table where project_id=$project_id and id=$id ";
		$db->execute($query);
		$row = $db->fetch();
		$original_sort_order=$row['sort_order'];
		$db->free_result();

		if ($new_sort_order > $original_sort_order) {
			$movedDown = true;
			$movedUp = false;
		} elseif ($new_sort_order < $original_sort_order) {
			$movedDown = false;
			$movedUp = true;
		} else {
			// Same sort_order
			// Default to Moved Down
			$movedDown = true;
			$movedUp = false;
		}


		if ($movedDown) {
		$query =
"
UPDATE $table
SET `sort_order` = (`sort_order`-1)
WHERE `project_id` = ?
AND `sort_order` > ?
AND `sort_order` <= ?
";
			$arrValues = array($project_id, $original_sort_order, $new_sort_order);
			$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
			$db->free_result();
		} elseif ($movedUp) {
		$query =
"
UPDATE $table
SET `sort_order` = (`sort_order`+1)
WHERE `project_id` = ?
AND `sort_order` < ?
AND `sort_order` >= ?
";
			$arrValues = array($project_id, $original_sort_order, $new_sort_order);
			$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
			$db->free_result();
		}

	}


	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all jobsite_daily_logs records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllJobsiteDailyLogs($database, Input $options=null)
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
			self::$_arrAllJobsiteDailyLogs = null;
		}

		$arrAllJobsiteDailyLogs = self::$_arrAllJobsiteDailyLogs;
		if (isset($arrAllJobsiteDailyLogs) && !empty($arrAllJobsiteDailyLogs)) {
			return $arrAllJobsiteDailyLogs;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `modified_by_contact_id` ASC, `created_by_contact_id` ASC, `modified` ASC, `jobsite_daily_log_created_date` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpJobsiteDailyLog = new JobsiteDailyLog($database);
			$sqlOrderByColumns = $tmpJobsiteDailyLog->constructSqlOrderByColumns($arrOrderByAttributes);

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
	jdl.*

FROM `jobsite_daily_logs` jdl{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `modified_by_contact_id` ASC, `created_by_contact_id` ASC, `modified` ASC, `jobsite_daily_log_created_date` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllJobsiteDailyLogs = array();
		while ($row = $db->fetch()) {
			$jobsite_daily_log_id = $row['id'];
			$jobsiteDailyLog = self::instantiateOrm($database, 'JobsiteDailyLog', $row, null, $jobsite_daily_log_id);
			/* @var $jobsiteDailyLog JobsiteDailyLog */
			$arrAllJobsiteDailyLogs[$jobsite_daily_log_id] = $jobsiteDailyLog;
		}

		$db->free_result();

		self::$_arrAllJobsiteDailyLogs = $arrAllJobsiteDailyLogs;

		return $arrAllJobsiteDailyLogs;
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
INTO `jobsite_daily_logs`
(`project_id`, `modified_by_contact_id`, `created_by_contact_id`, `modified`, `jobsite_daily_log_created_date`)
VALUES (?, ?, ?, ?, ?)
ON DUPLICATE KEY UPDATE `modified_by_contact_id` = ?, `created_by_contact_id` = ?, `modified` = ?
";
		$arrValues = array($this->project_id, $this->modified_by_contact_id, $this->created_by_contact_id, $this->modified, $this->jobsite_daily_log_created_date, $this->modified_by_contact_id, $this->created_by_contact_id, $this->modified);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$jobsite_daily_log_id = $db->insertId;
		$db->free_result();

		return $jobsite_daily_log_id;
	}

	// Save: insert ignore
	
	// Function to insert and update DCR cron details into Logs.
	public static function loadDCRIntoLogs($database, $project_id, $date){

		$db = DBI::getInstance($database);
		$query = "SELECT count(id) as id FROM `dcr_weather_logs` WHERE `project_id`= ? and ( DATE(`dcr_run_date_time`)= ? OR DATE(`am_run_date_time`) = ? OR Date(`pm_run_date_time`) =?)";
		$arrValues = array($project_id,$date,$date,$date);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$count=$row['id'];
		$db->free_result();	

		$dateTime = $date.' '.date('H:i:s');

		if ($count == 0) {			
			$query1 = 'INSERT INTO dcr_weather_logs (project_id,dcr_flag,dcr_run_date_time) VALUES (?,?,?)';
			$arrValues1 = array($project_id, 'Y', $dateTime);
			$db->execute($query1, $arrValues1, MYSQLI_STORE_RESULT);
			$db->commit();		
			$db->free_result();
		}else{
			$query2 = 'UPDATE dcr_weather_logs SET `dcr_flag` = ?,`dcr_run_date_time` = ? WHERE `project_id`= ? and ( DATE(`dcr_run_date_time`)= ? OR DATE(`am_run_date_time`) = ? OR Date(`pm_run_date_time`) = ?) ';
			$arrValues2 = array('Y',$dateTime,$project_id,$date,$date,$date);
			$db->execute($query2, $arrValues2, MYSQLI_STORE_RESULT);
			$db->commit();			
			$db->free_result();
		}

	}

	// To get array of project not sent out mail
	public static function getProjectFromDcrFile($database,$date,$status){
		$db = DBI::getInstance($database);
		$query = "SELECT `project_id` FROM `dcr_file` WHERE `is_mailed`= ? and DATE(`date`)= ? ";
		$arrValues = array($status,$date);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$array = array();
		while ($row = $db->fetch()) {
			$id = $row['project_id'];
			$array[$id] = $id;
		}
		$db->free_result();
		return $array;

	}

	// Function to insert and update DCR file_details
	public static function loadDCRfileDetails($database, $project_id, $file, $filename, $file_size_status, $date, $insertOrUpdate){
		$db = DBI::getInstance($database);

		$query = "SELECT count(id) as id FROM `dcr_file` WHERE `project_id`= ? and DATE(`date`)= ? ";
		$arrValues = array($project_id,$date);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$count=$row['id'];
		$db->free_result();

		if ($insertOrUpdate == 1 && $count == 0) {
			$query1 = 'INSERT INTO dcr_file (project_id,dcr_file,dcr_file_name,file_size_status,date) VALUES (?,?,?,?,?)';
			$arrValues1 = array($project_id,$file,$filename,$file_size_status,$date);
			$db->execute($query1, $arrValues1, MYSQLI_STORE_RESULT);
			$db->commit();		
			$db->free_result();
		}
		if ($insertOrUpdate == 2) {
			$query2 = 'UPDATE dcr_file SET `is_mailed` = 1 WHERE `project_id`= ? and DATE(`date`)= ?';
			$arrValues2 = array($project_id,$date);
			$db->execute($query2, $arrValues2, MYSQLI_STORE_RESULT);
			$db->commit();			
			$db->free_result();
		}		
	}
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

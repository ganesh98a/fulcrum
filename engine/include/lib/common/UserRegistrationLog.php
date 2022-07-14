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
 * UserRegistrationLog.
 *
 * @category   Framework
 * @package    UserRegistrationLog
 */

/**
 * Contact
 */
require_once('lib/common/Contact.php');

/**
 * ContactCompany
 */
require_once('lib/common/ContactCompany.php');

/**
 * User
 */
require_once('lib/common/User.php');

/**
 * Mail
 */
require_once('lib/common/Mail.php');

/**
 * MessageGateway_Sms
 */
require_once('lib/common/MessageGateway/Sms.php');

/**
 * Validate
 */
require_once('lib/common/Validate.php');

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class UserRegistrationLog extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'UserRegistrationLog';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'user_registration_log';

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
	 * unique index `unique_user_registration_log` (`user_id`,`contact_id`,`project_id`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_user_registration_log' => array(
			'user_id' => 'int',
			'contact_id' => 'int',
			'project_id' => 'int'
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
		'id' => 'user_registration_log_id',

		'user_id' => 'user_id',
		'contact_id' => 'contact_id',
		'project_id' => 'project_id',

		'created' => 'created'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $user_registration_log_id;

	public $user_id;
	public $contact_id;
	public $project_id;

	public $created;

	// Other Properties
	//protected $_otherPropertyHere;
	protected $_approvedFlag;

	// HTML ENTITY ENCODED ORM string properties

	// HTML ENTITY ENCODED NL2BR ORM string properties

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)
	protected static $_arrUserRegistrationLogByUserId;
	protected static $_arrUserRegistrationLogByContactId;
	protected static $_arrUserRegistrationLogByProjectId;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)
	protected static $_arrUserRegistrationLogByCreated;

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllUserRegistrationLog;

	// Foreign Key Objects
	private $_user;
	private $_contact;
	private $_project;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='user_registration_log')
	{
		parent::__construct($table);
		$this->setDatabase($database);
	}

	// Foreign Key Object Accessor Methods
	public function getUser()
	{
		if (isset($this->_user)) {
			return $this->_user;
		} else {
			return null;
		}
	}

	public function setUser($user)
	{
		$this->_user = $user;
	}

	public function getContact()
	{
		if (isset($this->_contact)) {
			return $this->_contact;
		} else {
			return null;
		}
	}

	public function setContact($contact)
	{
		$this->_contact = $contact;
	}

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

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)
	public static function getArrUserRegistrationLogByUserId()
	{
		if (isset(self::$_arrUserRegistrationLogByUserId)) {
			return self::$_arrUserRegistrationLogByUserId;
		} else {
			return null;
		}
	}

	public static function setArrUserRegistrationLogByUserId($arrUserRegistrationLogByUserId)
	{
		self::$_arrUserRegistrationLogByUserId = $arrUserRegistrationLogByUserId;
	}

	public static function getArrUserRegistrationLogByContactId()
	{
		if (isset(self::$_arrUserRegistrationLogByContactId)) {
			return self::$_arrUserRegistrationLogByContactId;
		} else {
			return null;
		}
	}

	public static function setArrUserRegistrationLogByContactId($arrUserRegistrationLogByContactId)
	{
		self::$_arrUserRegistrationLogByContactId = $arrUserRegistrationLogByContactId;
	}

	public static function getArrUserRegistrationLogByProjectId()
	{
		if (isset(self::$_arrUserRegistrationLogByProjectId)) {
			return self::$_arrUserRegistrationLogByProjectId;
		} else {
			return null;
		}
	}

	public static function setArrUserRegistrationLogByProjectId($arrUserRegistrationLogByProjectId)
	{
		self::$_arrUserRegistrationLogByProjectId = $arrUserRegistrationLogByProjectId;
	}

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)
	public static function getArrUserRegistrationLogByCreated()
	{
		if (isset(self::$_arrUserRegistrationLogByCreated)) {
			return self::$_arrUserRegistrationLogByCreated;
		} else {
			return null;
		}
	}

	public static function setArrUserRegistrationLogByCreated($arrUserRegistrationLogByCreated)
	{
		self::$_arrUserRegistrationLogByCreated = $arrUserRegistrationLogByCreated;
	}

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllUserRegistrationLog()
	{
		if (isset(self::$_arrAllUserRegistrationLog)) {
			return self::$_arrAllUserRegistrationLog;
		} else {
			return null;
		}
	}

	public static function setArrAllUserRegistrationLog($arrAllUserRegistrationLog)
	{
		self::$_arrAllUserRegistrationLog = $arrAllUserRegistrationLog;
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
	 * @param int $user_registration_log_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findById($database, $user_registration_log_id,$table='user_registration_log', $module='UserRegistrationLog')
	{
		$userRegistrationLog = parent::findById($database, $user_registration_log_id,$table, $module);

		return $userRegistrationLog;
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Similar to FindById, but with SQL as starter code for more complex joins.
	 *
	 * @param string $database
	 * @param int $user_registration_log_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findUserRegistrationLogByIdExtended($database, $user_registration_log_id)
	{
		$user_registration_log_id = (int) $user_registration_log_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	url_fk_u.`id` AS 'url_fk_u__user_id',
	url_fk_u.`user_company_id` AS 'url_fk_u__user_company_id',
	url_fk_u.`role_id` AS 'url_fk_u__role_id',
	url_fk_u.`default_project_id` AS 'url_fk_u__default_project_id',
	url_fk_u.`primary_contact_id` AS 'url_fk_u__primary_contact_id',
	url_fk_u.`mobile_network_carrier_id` AS 'url_fk_u__mobile_network_carrier_id',
	url_fk_u.`user_image_id` AS 'url_fk_u__user_image_id',
	url_fk_u.`security_image_id` AS 'url_fk_u__security_image_id',
	url_fk_u.`html_template_theme_id` AS 'url_fk_u__html_template_theme_id',
	url_fk_u.`mobile_phone_number` AS 'url_fk_u__mobile_phone_number',
	url_fk_u.`screen_name` AS 'url_fk_u__screen_name',
	url_fk_u.`email` AS 'url_fk_u__email',
	url_fk_u.`password_hash` AS 'url_fk_u__password_hash',
	url_fk_u.`password_guid` AS 'url_fk_u__password_guid',
	url_fk_u.`security_phrase` AS 'url_fk_u__security_phrase',
	url_fk_u.`modified` AS 'url_fk_u__modified',
	url_fk_u.`accessed` AS 'url_fk_u__accessed',
	url_fk_u.`created` AS 'url_fk_u__created',
	url_fk_u.`alerts` AS 'url_fk_u__alerts',
	url_fk_u.`tc_accepted_flag` AS 'url_fk_u__tc_accepted_flag',
	url_fk_u.`email_subscribe_flag` AS 'url_fk_u__email_subscribe_flag',
	url_fk_u.`remember_me_flag` AS 'url_fk_u__remember_me_flag',
	url_fk_u.`change_password_flag` AS 'url_fk_u__change_password_flag',
	url_fk_u.`disabled_flag` AS 'url_fk_u__disabled_flag',
	url_fk_u.`deleted_flag` AS 'url_fk_u__deleted_flag',

	url_fk_c.`id` AS 'url_fk_c__contact_id',
	url_fk_c.`user_company_id` AS 'url_fk_c__user_company_id',
	url_fk_c.`user_id` AS 'url_fk_c__user_id',
	url_fk_c.`contact_company_id` AS 'url_fk_c__contact_company_id',
	url_fk_c.`email` AS 'url_fk_c__email',
	url_fk_c.`name_prefix` AS 'url_fk_c__name_prefix',
	url_fk_c.`first_name` AS 'url_fk_c__first_name',
	url_fk_c.`additional_name` AS 'url_fk_c__additional_name',
	url_fk_c.`middle_name` AS 'url_fk_c__middle_name',
	url_fk_c.`last_name` AS 'url_fk_c__last_name',
	url_fk_c.`name_suffix` AS 'url_fk_c__name_suffix',
	url_fk_c.`title` AS 'url_fk_c__title',
	url_fk_c.`vendor_flag` AS 'url_fk_c__vendor_flag',

	url_fk_p.`id` AS 'url_fk_p__project_id',
	url_fk_p.`project_type_id` AS 'url_fk_p__project_type_id',
	url_fk_p.`user_company_id` AS 'url_fk_p__user_company_id',
	url_fk_p.`user_custom_project_id` AS 'url_fk_p__user_custom_project_id',
	url_fk_p.`project_name` AS 'url_fk_p__project_name',
	url_fk_p.`project_owner_name` AS 'url_fk_p__project_owner_name',
	url_fk_p.`latitude` AS 'url_fk_p__latitude',
	url_fk_p.`longitude` AS 'url_fk_p__longitude',
	url_fk_p.`address_line_1` AS 'url_fk_p__address_line_1',
	url_fk_p.`address_line_2` AS 'url_fk_p__address_line_2',
	url_fk_p.`address_line_3` AS 'url_fk_p__address_line_3',
	url_fk_p.`address_line_4` AS 'url_fk_p__address_line_4',
	url_fk_p.`address_city` AS 'url_fk_p__address_city',
	url_fk_p.`address_county` AS 'url_fk_p__address_county',
	url_fk_p.`address_state_or_region` AS 'url_fk_p__address_state_or_region',
	url_fk_p.`address_postal_code` AS 'url_fk_p__address_postal_code',
	url_fk_p.`address_postal_code_extension` AS 'url_fk_p__address_postal_code_extension',
	url_fk_p.`address_country` AS 'url_fk_p__address_country',
	url_fk_p.`building_count` AS 'url_fk_p__building_count',
	url_fk_p.`unit_count` AS 'url_fk_p__unit_count',
	url_fk_p.`gross_square_footage` AS 'url_fk_p__gross_square_footage',
	url_fk_p.`net_rentable_square_footage` AS 'url_fk_p__net_rentable_square_footage',
	url_fk_p.`is_active_flag` AS 'url_fk_p__is_active_flag',
	url_fk_p.`public_plans_flag` AS 'url_fk_p__public_plans_flag',
	url_fk_p.`prevailing_wage_flag` AS 'url_fk_p__prevailing_wage_flag',
	url_fk_p.`city_business_license_required_flag` AS 'url_fk_p__city_business_license_required_flag',
	url_fk_p.`is_internal_flag` AS 'url_fk_p__is_internal_flag',
	url_fk_p.`project_contract_date` AS 'url_fk_p__project_contract_date',
	url_fk_p.`project_start_date` AS 'url_fk_p__project_start_date',
	url_fk_p.`project_completed_date` AS 'url_fk_p__project_completed_date',
	url_fk_p.`sort_order` AS 'url_fk_p__sort_order',

	url.*

FROM `user_registration_log` url
	INNER JOIN `users` url_fk_u ON url.`user_id` = url_fk_u.`id`
	INNER JOIN `contacts` url_fk_c ON url.`contact_id` = url_fk_c.`id`
	INNER JOIN `projects` url_fk_p ON url.`project_id` = url_fk_p.`id`
WHERE url.`id` = ?
";
		$arrValues = array($user_registration_log_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$user_registration_log_id = $row['id'];
			$userRegistrationLog = self::instantiateOrm($database, 'UserRegistrationLog', $row, null, $user_registration_log_id);
			/* @var $userRegistrationLog UserRegistrationLog */
			$userRegistrationLog->convertPropertiesToData();

			if (isset($row['user_id'])) {
				$user_id = $row['user_id'];
				$row['url_fk_u__id'] = $user_id;
				$user = self::instantiateOrm($database, 'User', $row, null, $user_id, 'url_fk_u__');
				/* @var $user User */
				$user->convertPropertiesToData();
			} else {
				$user = false;
			}
			$userRegistrationLog->setUser($user);

			if (isset($row['contact_id'])) {
				$contact_id = $row['contact_id'];
				$row['url_fk_c__id'] = $contact_id;
				$contact = self::instantiateOrm($database, 'Contact', $row, null, $contact_id, 'url_fk_c__');
				/* @var $contact Contact */
				$contact->convertPropertiesToData();
			} else {
				$contact = false;
			}
			$userRegistrationLog->setContact($contact);

			if (isset($row['project_id'])) {
				$project_id = $row['project_id'];
				$row['url_fk_p__id'] = $project_id;
				$project = self::instantiateOrm($database, 'Project', $row, null, $project_id, 'url_fk_p__');
				/* @var $project Project */
				$project->convertPropertiesToData();
			} else {
				$project = false;
			}
			$userRegistrationLog->setProject($project);

			return $userRegistrationLog;
		} else {
			return false;
		}
	}

	// Finders: Find By Unique Index
	/**
	 * Find by unique index `unique_user_registration_log` (`user_id`,`contact_id`,`project_id`).
	 *
	 * @param string $database
	 * @param int $user_id
	 * @param int $contact_id
	 * @param int $project_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findByUserIdAndContactIdAndProjectId($database, $user_id, $contact_id, $project_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	url.*

FROM `user_registration_log` url
WHERE url.`user_id` = ?
AND url.`contact_id` = ?
AND url.`project_id` = ?
";
		$arrValues = array($user_id, $contact_id, $project_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if ($row && !empty($row)) {
			$user_registration_log_id = $row['id'];
			$userRegistrationLog = self::instantiateOrm($database, 'UserRegistrationLog', $row, null, $user_registration_log_id);
			/* @var $userRegistrationLog UserRegistrationLog */
			return $userRegistrationLog;
		} else {
			return false;
		}
	}

	// Loaders: Load By pk List (list of auto int ids or other non auto int pk list)
	/**
	 * Load zero or more records by an id list (array of auto int primary keys).
	 *
	 * @param string $database
	 * @param array $arrUserRegistrationLogIds
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadUserRegistrationLogByArrUserRegistrationLogIds($database, $arrUserRegistrationLogIds, Input $options=null)
	{
		if (empty($arrUserRegistrationLogIds)) {
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
		// ORDER BY `id` ASC, `user_id` ASC, `contact_id` ASC, `project_id` ASC, `created` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpUserRegistrationLog = new UserRegistrationLog($database);
			$sqlOrderByColumns = $tmpUserRegistrationLog->constructSqlOrderByColumns($arrOrderByAttributes);

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

		foreach ($arrUserRegistrationLogIds as $k => $user_registration_log_id) {
			$user_registration_log_id = (int) $user_registration_log_id;
			$arrUserRegistrationLogIds[$k] = $db->escape($user_registration_log_id);
		}
		$csvUserRegistrationLogIds = join(',', $arrUserRegistrationLogIds);

		$query =
"
SELECT

	url.*

FROM `user_registration_log` url
WHERE url.`id` IN ($csvUserRegistrationLogIds){$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		$arrUserRegistrationLogByCsvUserRegistrationLogIds = array();
		while ($row = $db->fetch()) {
			$user_registration_log_id = $row['id'];
			$userRegistrationLog = self::instantiateOrm($database, 'UserRegistrationLog', $row, null, $user_registration_log_id);
			/* @var $userRegistrationLog UserRegistrationLog */
			$userRegistrationLog->convertPropertiesToData();

			$arrUserRegistrationLogByCsvUserRegistrationLogIds[$user_registration_log_id] = $userRegistrationLog;
		}

		$db->free_result();

		return $arrUserRegistrationLogByCsvUserRegistrationLogIds;
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `user_registration_log_fk_u` foreign key (`user_id`) references `users` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $user_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadUserRegistrationLogByUserId($database, $user_id, Input $options=null)
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
			self::$_arrUserRegistrationLogByUserId = null;
		}

		$arrUserRegistrationLogByUserId = self::$_arrUserRegistrationLogByUserId;
		if (isset($arrUserRegistrationLogByUserId) && !empty($arrUserRegistrationLogByUserId)) {
			return $arrUserRegistrationLogByUserId;
		}

		$user_id = (int) $user_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `user_id` ASC, `contact_id` ASC, `project_id` ASC, `created` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpUserRegistrationLog = new UserRegistrationLog($database);
			$sqlOrderByColumns = $tmpUserRegistrationLog->constructSqlOrderByColumns($arrOrderByAttributes);

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
	url.*

FROM `user_registration_log` url
WHERE url.`user_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `user_id` ASC, `contact_id` ASC, `project_id` ASC, `created` ASC
		$arrValues = array($user_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrUserRegistrationLogByUserId = array();
		while ($row = $db->fetch()) {
			$user_registration_log_id = $row['id'];
			$userRegistrationLog = self::instantiateOrm($database, 'UserRegistrationLog', $row, null, $user_registration_log_id);
			/* @var $userRegistrationLog UserRegistrationLog */
			$arrUserRegistrationLogByUserId[$user_registration_log_id] = $userRegistrationLog;
		}

		$db->free_result();

		self::$_arrUserRegistrationLogByUserId = $arrUserRegistrationLogByUserId;

		return $arrUserRegistrationLogByUserId;
	}

	/**
	 * Load by constraint `user_registration_log_fk_c` foreign key (`contact_id`) references `contacts` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $contact_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadUserRegistrationLogByContactId($database, $contact_id, Input $options=null)
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
			self::$_arrUserRegistrationLogByContactId = null;
		}

		$arrUserRegistrationLogByContactId = self::$_arrUserRegistrationLogByContactId;
		if (isset($arrUserRegistrationLogByContactId) && !empty($arrUserRegistrationLogByContactId)) {
			return $arrUserRegistrationLogByContactId;
		}

		$contact_id = (int) $contact_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `user_id` ASC, `contact_id` ASC, `project_id` ASC, `created` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpUserRegistrationLog = new UserRegistrationLog($database);
			$sqlOrderByColumns = $tmpUserRegistrationLog->constructSqlOrderByColumns($arrOrderByAttributes);

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
	url.*

FROM `user_registration_log` url
WHERE url.`contact_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `user_id` ASC, `contact_id` ASC, `project_id` ASC, `created` ASC
		$arrValues = array($contact_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrUserRegistrationLogByContactId = array();
		while ($row = $db->fetch()) {
			$user_registration_log_id = $row['id'];
			$userRegistrationLog = self::instantiateOrm($database, 'UserRegistrationLog', $row, null, $user_registration_log_id);
			/* @var $userRegistrationLog UserRegistrationLog */
			$arrUserRegistrationLogByContactId[$user_registration_log_id] = $userRegistrationLog;
		}

		$db->free_result();

		self::$_arrUserRegistrationLogByContactId = $arrUserRegistrationLogByContactId;

		return $arrUserRegistrationLogByContactId;
	}

	/**
	 * Load by constraint `user_registration_log_fk_p` foreign key (`project_id`) references `projects` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $project_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadUserRegistrationLogByProjectId($database, $project_id, Input $options=null)
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
			self::$_arrUserRegistrationLogByProjectId = null;
		}

		$arrUserRegistrationLogByProjectId = self::$_arrUserRegistrationLogByProjectId;
		if (isset($arrUserRegistrationLogByProjectId) && !empty($arrUserRegistrationLogByProjectId)) {
			return $arrUserRegistrationLogByProjectId;
		}

		$project_id = (int) $project_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `user_id` ASC, `contact_id` ASC, `project_id` ASC, `created` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpUserRegistrationLog = new UserRegistrationLog($database);
			$sqlOrderByColumns = $tmpUserRegistrationLog->constructSqlOrderByColumns($arrOrderByAttributes);

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
	url.*

FROM `user_registration_log` url
WHERE url.`project_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `user_id` ASC, `contact_id` ASC, `project_id` ASC, `created` ASC
		$arrValues = array($project_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrUserRegistrationLogByProjectId = array();
		while ($row = $db->fetch()) {
			$user_registration_log_id = $row['id'];
			$userRegistrationLog = self::instantiateOrm($database, 'UserRegistrationLog', $row, null, $user_registration_log_id);
			/* @var $userRegistrationLog UserRegistrationLog */
			$arrUserRegistrationLogByProjectId[$user_registration_log_id] = $userRegistrationLog;
		}

		$db->free_result();

		self::$_arrUserRegistrationLogByProjectId = $arrUserRegistrationLogByProjectId;

		return $arrUserRegistrationLogByProjectId;
	}

	// Loaders: Load By index
	/**
	 * Load by key `created` (`created`).
	 *
	 * @param string $database
	 * @param string $created
	 * @param mixed (Input $options object | null)
	 * @return mixed (single ORM object | false)
	 */
	public static function loadUserRegistrationLogByCreated($database, $created, Input $options=null)
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
			self::$_arrUserRegistrationLogByCreated = null;
		}

		$arrUserRegistrationLogByCreated = self::$_arrUserRegistrationLogByCreated;
		if (isset($arrUserRegistrationLogByCreated) && !empty($arrUserRegistrationLogByCreated)) {
			return $arrUserRegistrationLogByCreated;
		}

		$created = (string) $created;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `user_id` ASC, `contact_id` ASC, `project_id` ASC, `created` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpUserRegistrationLog = new UserRegistrationLog($database);
			$sqlOrderByColumns = $tmpUserRegistrationLog->constructSqlOrderByColumns($arrOrderByAttributes);

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
	url.*

FROM `user_registration_log` url
WHERE url.`created` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `user_id` ASC, `contact_id` ASC, `project_id` ASC, `created` ASC
		$arrValues = array($created);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrUserRegistrationLogByCreated = array();
		while ($row = $db->fetch()) {
			$user_registration_log_id = $row['id'];
			$userRegistrationLog = self::instantiateOrm($database, 'UserRegistrationLog', $row, null, $user_registration_log_id);
			/* @var $userRegistrationLog UserRegistrationLog */
			$arrUserRegistrationLogByCreated[$user_registration_log_id] = $userRegistrationLog;
		}

		$db->free_result();

		self::$_arrUserRegistrationLogByCreated = $arrUserRegistrationLogByCreated;

		return $arrUserRegistrationLogByCreated;
	}

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all user_registration_log records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllUserRegistrationLog($database, Input $options=null)
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
			self::$_arrAllUserRegistrationLog = null;
		}

		$arrAllUserRegistrationLog = self::$_arrAllUserRegistrationLog;
		if (isset($arrAllUserRegistrationLog) && !empty($arrAllUserRegistrationLog)) {
			return $arrAllUserRegistrationLog;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `user_id` ASC, `contact_id` ASC, `project_id` ASC, `created` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpUserRegistrationLog = new UserRegistrationLog($database);
			$sqlOrderByColumns = $tmpUserRegistrationLog->constructSqlOrderByColumns($arrOrderByAttributes);

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
	url.*

FROM `user_registration_log` url{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `user_id` ASC, `contact_id` ASC, `project_id` ASC, `created` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllUserRegistrationLog = array();
		while ($row = $db->fetch()) {
			$user_registration_log_id = $row['id'];
			$userRegistrationLog = self::instantiateOrm($database, 'UserRegistrationLog', $row, null, $user_registration_log_id);
			/* @var $userRegistrationLog UserRegistrationLog */
			$arrAllUserRegistrationLog[$user_registration_log_id] = $userRegistrationLog;
		}

		$db->free_result();

		self::$_arrAllUserRegistrationLog = $arrAllUserRegistrationLog;

		return $arrAllUserRegistrationLog;
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
INTO `user_registration_log`
(`user_id`, `contact_id`, `project_id`, `created`)
VALUES (?, ?, ?, ?)
ON DUPLICATE KEY UPDATE `created` = ?
";
		$arrValues = array($this->user_id, $this->contact_id, $this->project_id, $this->created, $this->created);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$user_registration_log_id = $db->insertId;
		$db->free_result();

		return $user_registration_log_id;
	}

	// Save: insert ignore

	public static function logUserRegistration($database, $user_id, $contact_id, $project_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$db->begin();

		$query =
"
SELECT url.*
FROM `user_registration_log` url
WHERE url.`user_id` = ?
AND url.`contact_id` = ?
AND url.`project_id` = ?
";
		$arrValues = array($user_id, $contact_id, $project_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$arrRecords = array();
		$row = $db->fetch();
		$db->free_result();

		if (isset($row) && !empty($row)) {
			$query =
"
UPDATE `user_registration_log`
SET `created` = null
WHERE url.`user_id` = ?
AND url.`contact_id` = ?
AND url.`project_id` = ?
";
			$arrValues = array($user_id, $contact_id, $project_id);
		} else {
			$query =
"
INSERT INTO `user_registration_log`
(`user_id`, `contact_id`, `project_id`, `created`)
VALUES ( ?, ?, ?, null)
";
			$arrValues = array($user_id, $contact_id, $project_id);
		}
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$db->free_result();

		$db->commit();
	}

	public static function loadUserRegistrationLogsByUserCompanyIdAndProjectId($database, $user_company_id, $project_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT url.*
FROM `user_registration_log` url, `contacts` c, `projects_to_contacts_to_roles` p2c2r
WHERE c.`user_company_id` = ?
AND c.`id` = p2c2r.`contact_id`
AND p2c2r.`project_id` = ?
AND c.`id` = url.`contact_id`
GROUP BY url.`id`
";
		$arrValues = array($user_company_id, $project_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$arrRecords = array();
		while ($row = $db->fetch()) {
			$user_registration_log_id = $row['id'];
			$userRegistrationLog = new UserRegistrationLog($database);
			$key = array('id' => $user_registration_log_id);
			$userRegistrationLog->setKey($key);
			$userRegistrationLog->setData($row);
			$userRegistrationLog->convertDataToProperties();

			$arrRecords[$user_registration_log_id] = $userRegistrationLog;
		}
		$db->free_result();

		return $arrRecords;
	}

	public static function loadUserRegistrationLogsByUserCompanyIdAndProjectIdExtended($database, $user_company_id, $project_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	url_fk_u.`id` AS 'url_fk_u__user_id',
	url_fk_u.`user_company_id` AS 'url_fk_u__user_company_id',
	url_fk_u.`role_id` AS 'url_fk_u__role_id',
	url_fk_u.`default_project_id` AS 'url_fk_u__default_project_id',
	url_fk_u.`primary_contact_id` AS 'url_fk_u__primary_contact_id',
	url_fk_u.`mobile_network_carrier_id` AS 'url_fk_u__mobile_network_carrier_id',
	url_fk_u.`user_image_id` AS 'url_fk_u__user_image_id',
	url_fk_u.`security_image_id` AS 'url_fk_u__security_image_id',
	url_fk_u.`html_template_theme_id` AS 'url_fk_u__html_template_theme_id',
	url_fk_u.`mobile_phone_number` AS 'url_fk_u__mobile_phone_number',
	url_fk_u.`screen_name` AS 'url_fk_u__screen_name',
	url_fk_u.`email` AS 'url_fk_u__email',
	url_fk_u.`password_hash` AS 'url_fk_u__password_hash',
	url_fk_u.`password_guid` AS 'url_fk_u__password_guid',
	url_fk_u.`security_phrase` AS 'url_fk_u__security_phrase',
	url_fk_u.`modified` AS 'url_fk_u__modified',
	url_fk_u.`accessed` AS 'url_fk_u__accessed',
	url_fk_u.`created` AS 'url_fk_u__created',
	url_fk_u.`alerts` AS 'url_fk_u__alerts',
	url_fk_u.`tc_accepted_flag` AS 'url_fk_u__tc_accepted_flag',
	url_fk_u.`email_subscribe_flag` AS 'url_fk_u__email_subscribe_flag',
	url_fk_u.`remember_me_flag` AS 'url_fk_u__remember_me_flag',
	url_fk_u.`change_password_flag` AS 'url_fk_u__change_password_flag',
	url_fk_u.`disabled_flag` AS 'url_fk_u__disabled_flag',
	url_fk_u.`deleted_flag` AS 'url_fk_u__deleted_flag',

	url_fk_c.`id` AS 'url_fk_c__contact_id',
	url_fk_c.`user_company_id` AS 'url_fk_c__user_company_id',
	url_fk_c.`user_id` AS 'url_fk_c__user_id',
	url_fk_c.`contact_company_id` AS 'url_fk_c__contact_company_id',
	url_fk_c.`email` AS 'url_fk_c__email',
	url_fk_c.`name_prefix` AS 'url_fk_c__name_prefix',
	url_fk_c.`first_name` AS 'url_fk_c__first_name',
	url_fk_c.`additional_name` AS 'url_fk_c__additional_name',
	url_fk_c.`middle_name` AS 'url_fk_c__middle_name',
	url_fk_c.`last_name` AS 'url_fk_c__last_name',
	url_fk_c.`name_suffix` AS 'url_fk_c__name_suffix',
	url_fk_c.`title` AS 'url_fk_c__title',
	url_fk_c.`vendor_flag` AS 'url_fk_c__vendor_flag',

	c_fk_cc.`id` AS 'c_fk_cc__contact_company_id',
	c_fk_cc.`user_user_company_id` AS 'c_fk_cc__user_user_company_id',
	c_fk_cc.`contact_user_company_id` AS 'c_fk_cc__contact_user_company_id',
	c_fk_cc.`company` AS 'c_fk_cc__company',
	c_fk_cc.`primary_phone_number` AS 'c_fk_cc__primary_phone_number',
	c_fk_cc.`employer_identification_number` AS 'c_fk_cc__employer_identification_number',
	c_fk_cc.`construction_license_number` AS 'c_fk_cc__construction_license_number',
	c_fk_cc.`construction_license_number_expiration_date` AS 'c_fk_cc__construction_license_number_expiration_date',
	c_fk_cc.`vendor_flag` AS 'c_fk_cc__vendor_flag',

	url_fk_p.`id` AS 'url_fk_p__project_id',
	url_fk_p.`project_type_id` AS 'url_fk_p__project_type_id',
	url_fk_p.`user_company_id` AS 'url_fk_p__user_company_id',
	url_fk_p.`user_custom_project_id` AS 'url_fk_p__user_custom_project_id',
	url_fk_p.`project_name` AS 'url_fk_p__project_name',
	url_fk_p.`project_owner_name` AS 'url_fk_p__project_owner_name',
	url_fk_p.`latitude` AS 'url_fk_p__latitude',
	url_fk_p.`longitude` AS 'url_fk_p__longitude',
	url_fk_p.`address_line_1` AS 'url_fk_p__address_line_1',
	url_fk_p.`address_line_2` AS 'url_fk_p__address_line_2',
	url_fk_p.`address_line_3` AS 'url_fk_p__address_line_3',
	url_fk_p.`address_line_4` AS 'url_fk_p__address_line_4',
	url_fk_p.`address_city` AS 'url_fk_p__address_city',
	url_fk_p.`address_county` AS 'url_fk_p__address_county',
	url_fk_p.`address_state_or_region` AS 'url_fk_p__address_state_or_region',
	url_fk_p.`address_postal_code` AS 'url_fk_p__address_postal_code',
	url_fk_p.`address_postal_code_extension` AS 'url_fk_p__address_postal_code_extension',
	url_fk_p.`address_country` AS 'url_fk_p__address_country',
	url_fk_p.`building_count` AS 'url_fk_p__building_count',
	url_fk_p.`unit_count` AS 'url_fk_p__unit_count',
	url_fk_p.`gross_square_footage` AS 'url_fk_p__gross_square_footage',
	url_fk_p.`net_rentable_square_footage` AS 'url_fk_p__net_rentable_square_footage',
	url_fk_p.`is_active_flag` AS 'url_fk_p__is_active_flag',
	url_fk_p.`public_plans_flag` AS 'url_fk_p__public_plans_flag',
	url_fk_p.`prevailing_wage_flag` AS 'url_fk_p__prevailing_wage_flag',
	url_fk_p.`city_business_license_required_flag` AS 'url_fk_p__city_business_license_required_flag',
	url_fk_p.`is_internal_flag` AS 'url_fk_p__is_internal_flag',
	url_fk_p.`project_contract_date` AS 'url_fk_p__project_contract_date',
	url_fk_p.`project_start_date` AS 'url_fk_p__project_start_date',
	url_fk_p.`project_completed_date` AS 'url_fk_p__project_completed_date',
	url_fk_p.`sort_order` AS 'url_fk_p__sort_order',

	url.*

FROM `user_registration_log` url
	INNER JOIN `users` url_fk_u ON url.`user_id` = url_fk_u.`id`
	INNER JOIN `contacts` url_fk_c ON url.`contact_id` = url_fk_c.`id`
	INNER JOIN `projects` url_fk_p ON url.`project_id` = url_fk_p.`id`

	INNER JOIN `projects_to_contacts_to_roles` p2c2r ON url_fk_c.`id` = p2c2r.`contact_id`
	INNER JOIN `contact_companies` c_fk_cc ON url_fk_c.`contact_company_id` = c_fk_cc.`id`

WHERE url_fk_c.`user_company_id` = ?
AND p2c2r.`project_id` = ?
AND p2c2r.`role_id` = 3
";
//GROUP BY url.`id`

		$arrValues = array($user_company_id, $project_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$arrUserRegistrationLogsByUserCompanyIdAndProjectId = array();
		while ($row = $db->fetch()) {
			$user_registration_log_id = $row['id'];
			$userRegistrationLog = self::instantiateOrm($database, 'UserRegistrationLog', $row, null, $user_registration_log_id);
			/* @var $userRegistrationLog UserRegistrationLog */
			$userRegistrationLog->convertPropertiesToData();

			if (isset($row['user_id'])) {
				$user_id = $row['user_id'];
				$row['url_fk_u__id'] = $user_id;
				$user = self::instantiateOrm($database, 'User', $row, null, $user_id, 'url_fk_u__');
				/* @var $user User */
				$user->convertPropertiesToData();
			} else {
				$user = false;
			}
			$userRegistrationLog->setUser($user);

			if (isset($row['contact_id'])) {
				$contact_id = $row['contact_id'];
				$row['url_fk_c__id'] = $contact_id;
				$contact = self::instantiateOrm($database, 'Contact', $row, null, $contact_id, 'url_fk_c__');
				/* @var $contact Contact */
				$contact->convertPropertiesToData();
			} else {
				$contact = false;
			}
			$userRegistrationLog->setContact($contact);

			if (isset($row['project_id'])) {
				$project_id = $row['project_id'];
				$row['url_fk_p__id'] = $project_id;
				$project = self::instantiateOrm($database, 'Project', $row, null, $project_id, 'url_fk_p__');
				/* @var $project Project */
				$project->convertPropertiesToData();
			} else {
				$project = false;
			}
			$userRegistrationLog->setProject($project);

			if (isset($row['c_fk_cc__contact_company_id'])) {
				$contact_company_id = $row['c_fk_cc__contact_company_id'];
				$row['c_fk_cc__id'] = $contact_company_id;
				$contactCompany = self::instantiateOrm($database, 'ContactCompany', $row, null, $contact_company_id, 'c_fk_cc__');
				/* @var $contactCompany ContactCompany */
				$contactCompany->convertPropertiesToData();
			} else {
				$contactCompany = false;
			}
			$contact->setContactCompany($contactCompany);

			$arrUserRegistrationLogsByUserCompanyIdAndProjectId[$user_registration_log_id] = $userRegistrationLog;
		}
		$db->free_result();

		return $arrUserRegistrationLogsByUserCompanyIdAndProjectId;
	}
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

<?php
ini_set('MAX_EXECUTION_TIME', '-1');

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
* Invite a person to join the system via "User Invitation & Registration" (contact to user).
*
* @category   Framework
* @package    UserInvitation
*/

/**
* User
*/
require_once('lib/common/User.php');

/**
* Contact
*/
require_once('lib/common/Contact.php');

/**
* ContactCompany
*/
require_once('lib/common/ContactCompany.php');

/**
* ContactPhoneNumber
*/
require_once('lib/common/ContactPhoneNumber.php');

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
require_once('lib/common/Module.php');


/**
* @see IntegratedMapper
*/
//require_once('lib/common/IntegratedMapper.php');

class UserInvitation extends IntegratedMapper
{
	/**
	* Class name for use in deltifyAndSave().
	*/
	protected $_className = 'UserInvitation';

	/**
	* Table name for this Integrated Mapper.
	*
	* @var string
	*/
	protected $_table = 'user_invitations';

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
	* unique index `unique_user_invitation` (`guid`)
	*
	* 'db_table_attribute' => 'type'
	*
	* @var array
	*/
	protected $_arrUniqueness = array(
		'unique_user_invitation' => array(
			'guid' => 'string'
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
		'id' => 'user_invitation_id',

		'user_id' => 'user_id',
		'contact_id' => 'contact_id',
		'project_id' => 'project_id',
		'user_invitation_type_id' => 'user_invitation_type_id',

		'guid' => 'guid',

		'contact_user_company_id' => 'contact_user_company_id',
		'employer_identification_number' => 'employer_identification_number',
		'created' => 'created',
		'user_invitation_expiration_timestamp' => 'user_invitation_expiration_timestamp'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $user_invitation_id;

	public $user_id;
	public $contact_id;
	public $project_id;
	public $user_invitation_type_id;

	public $guid;

	public $contact_user_company_id;
	public $employer_identification_number;
	public $created;
	public $user_invitation_expiration_timestamp;

	// Other Properties
	//protected $_otherPropertyHere;
	protected $_approvedFlag;

	// HTML ENTITY ENCODED ORM string properties
	public $escaped_guid;
	public $escaped_employer_identification_number;

	// HTML ENTITY ENCODED NL2BR ORM string properties
	public $escaped_guid_nl2br;
	public $escaped_employer_identification_number_nl2br;

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)
	protected static $_arrUserInvitationsByUserId;
	protected static $_arrUserInvitationsByContactId;
	protected static $_arrUserInvitationsByProjectId;
	protected static $_arrUserInvitationsByUserInvitationTypeId;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)
	protected static $_arrUserInvitationsByCreated;
	protected static $_arrUserInvitationsByUserInvitationExpirationTimestamp;

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllUserInvitations;

	// Foreign Key Objects
	private $_user;
	private $_contact;
	private $_project;
	private $_userInvitationType;

	/**
	* Constructor
	*/
	public function __construct($database, $table='user_invitations')
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

	public function getUserInvitationType()
	{
		if (isset($this->_userInvitationType)) {
			return $this->_userInvitationType;
		} else {
			return null;
		}
	}

	public function setUserInvitationType($userInvitationType)
	{
		$this->_userInvitationType = $userInvitationType;
	}

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)
	public static function getArrUserInvitationsByUserId()
	{
		if (isset(self::$_arrUserInvitationsByUserId)) {
			return self::$_arrUserInvitationsByUserId;
		} else {
			return null;
		}
	}

	public static function setArrUserInvitationsByUserId($arrUserInvitationsByUserId)
	{
		self::$_arrUserInvitationsByUserId = $arrUserInvitationsByUserId;
	}

	public static function getArrUserInvitationsByContactId()
	{
		if (isset(self::$_arrUserInvitationsByContactId)) {
			return self::$_arrUserInvitationsByContactId;
		} else {
			return null;
		}
	}

	public static function setArrUserInvitationsByContactId($arrUserInvitationsByContactId)
	{
		self::$_arrUserInvitationsByContactId = $arrUserInvitationsByContactId;
	}

	public static function getArrUserInvitationsByProjectId()
	{
		if (isset(self::$_arrUserInvitationsByProjectId)) {
			return self::$_arrUserInvitationsByProjectId;
		} else {
			return null;
		}
	}

	public static function setArrUserInvitationsByProjectId($arrUserInvitationsByProjectId)
	{
		self::$_arrUserInvitationsByProjectId = $arrUserInvitationsByProjectId;
	}

	public static function getArrUserInvitationsByUserInvitationTypeId()
	{
		if (isset(self::$_arrUserInvitationsByUserInvitationTypeId)) {
			return self::$_arrUserInvitationsByUserInvitationTypeId;
		} else {
			return null;
		}
	}

	public static function setArrUserInvitationsByUserInvitationTypeId($arrUserInvitationsByUserInvitationTypeId)
	{
		self::$_arrUserInvitationsByUserInvitationTypeId = $arrUserInvitationsByUserInvitationTypeId;
	}

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)
	public static function getArrUserInvitationsByCreated()
	{
		if (isset(self::$_arrUserInvitationsByCreated)) {
			return self::$_arrUserInvitationsByCreated;
		} else {
			return null;
		}
	}

	public static function setArrUserInvitationsByCreated($arrUserInvitationsByCreated)
	{
		self::$_arrUserInvitationsByCreated = $arrUserInvitationsByCreated;
	}

	public static function getArrUserInvitationsByUserInvitationExpirationTimestamp()
	{
		if (isset(self::$_arrUserInvitationsByUserInvitationExpirationTimestamp)) {
			return self::$_arrUserInvitationsByUserInvitationExpirationTimestamp;
		} else {
			return null;
		}
	}

	public static function setArrUserInvitationsByUserInvitationExpirationTimestamp($arrUserInvitationsByUserInvitationExpirationTimestamp)
	{
		self::$_arrUserInvitationsByUserInvitationExpirationTimestamp = $arrUserInvitationsByUserInvitationExpirationTimestamp;
	}

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllUserInvitations()
	{
		if (isset(self::$_arrAllUserInvitations)) {
			return self::$_arrAllUserInvitations;
		} else {
			return null;
		}
	}

	public static function setArrAllUserInvitations($arrAllUserInvitations)
	{
		self::$_arrAllUserInvitations = $arrAllUserInvitations;
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
* @param int $user_invitation_id
* @return mixed (single ORM object | false)
*/
public static function findById($database, $user_invitation_id,$table='user_invitations', $module='UserInvitation')
{
	$userInvitation = parent::findById($database, $user_invitation_id,$table, $module);

	return $userInvitation;
}

// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
/**
* Similar to FindById, but with SQL as starter code for more complex joins.
*
* @param string $database
* @param int $user_invitation_id
* @return mixed (single ORM object | false)
*/
public static function findUserInvitationByIdExtended($database, $user_invitation_id)
{
	$user_invitation_id = (int) $user_invitation_id;

	$db = DBI::getInstance($database);
	/* @var $db DBI_mysqli */

	$query =
	"
	SELECT

	ui_fk_u.`id` AS 'ui_fk_u__user_id',
	ui_fk_u.`user_company_id` AS 'ui_fk_u__user_company_id',
	ui_fk_u.`role_id` AS 'ui_fk_u__role_id',
	ui_fk_u.`default_project_id` AS 'ui_fk_u__default_project_id',
	ui_fk_u.`primary_contact_id` AS 'ui_fk_u__primary_contact_id',
	ui_fk_u.`mobile_network_carrier_id` AS 'ui_fk_u__mobile_network_carrier_id',
	ui_fk_u.`user_image_id` AS 'ui_fk_u__user_image_id',
	ui_fk_u.`security_image_id` AS 'ui_fk_u__security_image_id',
	ui_fk_u.`html_template_theme_id` AS 'ui_fk_u__html_template_theme_id',
	ui_fk_u.`mobile_phone_number` AS 'ui_fk_u__mobile_phone_number',
	ui_fk_u.`screen_name` AS 'ui_fk_u__screen_name',
	ui_fk_u.`email` AS 'ui_fk_u__email',
	ui_fk_u.`password_hash` AS 'ui_fk_u__password_hash',
	ui_fk_u.`password_guid` AS 'ui_fk_u__password_guid',
	ui_fk_u.`security_phrase` AS 'ui_fk_u__security_phrase',
	ui_fk_u.`modified` AS 'ui_fk_u__modified',
	ui_fk_u.`accessed` AS 'ui_fk_u__accessed',
	ui_fk_u.`created` AS 'ui_fk_u__created',
	ui_fk_u.`alerts` AS 'ui_fk_u__alerts',
	ui_fk_u.`tc_accepted_flag` AS 'ui_fk_u__tc_accepted_flag',
	ui_fk_u.`email_subscribe_flag` AS 'ui_fk_u__email_subscribe_flag',
	ui_fk_u.`remember_me_flag` AS 'ui_fk_u__remember_me_flag',
	ui_fk_u.`change_password_flag` AS 'ui_fk_u__change_password_flag',
	ui_fk_u.`disabled_flag` AS 'ui_fk_u__disabled_flag',
	ui_fk_u.`deleted_flag` AS 'ui_fk_u__deleted_flag',

	ui_fk_c.`id` AS 'ui_fk_c__contact_id',
	ui_fk_c.`user_company_id` AS 'ui_fk_c__user_company_id',
	ui_fk_c.`user_id` AS 'ui_fk_c__user_id',
	ui_fk_c.`contact_company_id` AS 'ui_fk_c__contact_company_id',
	ui_fk_c.`email` AS 'ui_fk_c__email',
	ui_fk_c.`name_prefix` AS 'ui_fk_c__name_prefix',
	ui_fk_c.`first_name` AS 'ui_fk_c__first_name',
	ui_fk_c.`additional_name` AS 'ui_fk_c__additional_name',
	ui_fk_c.`middle_name` AS 'ui_fk_c__middle_name',
	ui_fk_c.`last_name` AS 'ui_fk_c__last_name',
	ui_fk_c.`name_suffix` AS 'ui_fk_c__name_suffix',
	ui_fk_c.`title` AS 'ui_fk_c__title',
	ui_fk_c.`vendor_flag` AS 'ui_fk_c__vendor_flag',

	ui_fk_p.`id` AS 'ui_fk_p__project_id',
	ui_fk_p.`project_type_id` AS 'ui_fk_p__project_type_id',
	ui_fk_p.`user_company_id` AS 'ui_fk_p__user_company_id',
	ui_fk_p.`user_custom_project_id` AS 'ui_fk_p__user_custom_project_id',
	ui_fk_p.`project_name` AS 'ui_fk_p__project_name',
	ui_fk_p.`project_owner_name` AS 'ui_fk_p__project_owner_name',
	ui_fk_p.`latitude` AS 'ui_fk_p__latitude',
	ui_fk_p.`longitude` AS 'ui_fk_p__longitude',
	ui_fk_p.`address_line_1` AS 'ui_fk_p__address_line_1',
	ui_fk_p.`address_line_2` AS 'ui_fk_p__address_line_2',
	ui_fk_p.`address_line_3` AS 'ui_fk_p__address_line_3',
	ui_fk_p.`address_line_4` AS 'ui_fk_p__address_line_4',
	ui_fk_p.`address_city` AS 'ui_fk_p__address_city',
	ui_fk_p.`address_county` AS 'ui_fk_p__address_county',
	ui_fk_p.`address_state_or_region` AS 'ui_fk_p__address_state_or_region',
	ui_fk_p.`address_postal_code` AS 'ui_fk_p__address_postal_code',
	ui_fk_p.`address_postal_code_extension` AS 'ui_fk_p__address_postal_code_extension',
	ui_fk_p.`address_country` AS 'ui_fk_p__address_country',
	ui_fk_p.`building_count` AS 'ui_fk_p__building_count',
	ui_fk_p.`unit_count` AS 'ui_fk_p__unit_count',
	ui_fk_p.`gross_square_footage` AS 'ui_fk_p__gross_square_footage',
	ui_fk_p.`net_rentable_square_footage` AS 'ui_fk_p__net_rentable_square_footage',
	ui_fk_p.`is_active_flag` AS 'ui_fk_p__is_active_flag',
	ui_fk_p.`public_plans_flag` AS 'ui_fk_p__public_plans_flag',
	ui_fk_p.`prevailing_wage_flag` AS 'ui_fk_p__prevailing_wage_flag',
	ui_fk_p.`city_business_license_required_flag` AS 'ui_fk_p__city_business_license_required_flag',
	ui_fk_p.`is_internal_flag` AS 'ui_fk_p__is_internal_flag',
	ui_fk_p.`project_contract_date` AS 'ui_fk_p__project_contract_date',
	ui_fk_p.`project_start_date` AS 'ui_fk_p__project_start_date',
	ui_fk_p.`project_completed_date` AS 'ui_fk_p__project_completed_date',
	ui_fk_p.`sort_order` AS 'ui_fk_p__sort_order',

	ui_fk_uit.`id` AS 'ui_fk_uit__user_invitation_type_id',
	ui_fk_uit.`invitation_type` AS 'ui_fk_uit__invitation_type',

	ui.*

	FROM `user_invitations` ui
	INNER JOIN `users` ui_fk_u ON ui.`user_id` = ui_fk_u.`id`
	INNER JOIN `contacts` ui_fk_c ON ui.`contact_id` = ui_fk_c.`id`
	INNER JOIN `projects` ui_fk_p ON ui.`project_id` = ui_fk_p.`id`
	INNER JOIN `user_invitation_types` ui_fk_uit ON ui.`user_invitation_type_id` = ui_fk_uit.`id`
	WHERE ui.`id` = ?
	";
	$arrValues = array($user_invitation_id);
	$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
	$row = $db->fetch();
	$db->free_result();

	if ($row) {
		$user_invitation_id = $row['id'];
		$userInvitation = self::instantiateOrm($database, 'UserInvitation', $row, null, $user_invitation_id);
		/* @var $userInvitation UserInvitation */
		$userInvitation->convertPropertiesToData();

		if (isset($row['user_id'])) {
			$user_id = $row['user_id'];
			$row['ui_fk_u__id'] = $user_id;
			$user = self::instantiateOrm($database, 'User', $row, null, $user_id, 'ui_fk_u__');
			/* @var $user User */
			$user->convertPropertiesToData();
		} else {
			$user = false;
		}
		$userInvitation->setUser($user);

		if (isset($row['contact_id'])) {
			$contact_id = $row['contact_id'];
			$row['ui_fk_c__id'] = $contact_id;
			$contact = self::instantiateOrm($database, 'Contact', $row, null, $contact_id, 'ui_fk_c__');
			/* @var $contact Contact */
			$contact->convertPropertiesToData();
		} else {
			$contact = false;
		}
		$userInvitation->setContact($contact);

		if (isset($row['project_id'])) {
			$project_id = $row['project_id'];
			$row['ui_fk_p__id'] = $project_id;
			$project = self::instantiateOrm($database, 'Project', $row, null, $project_id, 'ui_fk_p__');
			/* @var $project Project */
			$project->convertPropertiesToData();
		} else {
			$project = false;
		}
		$userInvitation->setProject($project);

		if (isset($row['user_invitation_type_id'])) {
			$user_invitation_type_id = $row['user_invitation_type_id'];
			$row['ui_fk_uit__id'] = $user_invitation_type_id;
			$userInvitationType = self::instantiateOrm($database, 'UserInvitationType', $row, null, $user_invitation_type_id, 'ui_fk_uit__');
			/* @var $userInvitationType UserInvitationType */
			$userInvitationType->convertPropertiesToData();
		} else {
			$userInvitationType = false;
		}
		$userInvitation->setUserInvitationType($userInvitationType);

		return $userInvitation;
	} else {
		return false;
	}
}

// Finders: Find By Unique Index
/**
* Find by unique index `unique_user_invitation` (`guid`).
*
* @param string $database
* @param string $guid
* @return mixed (single ORM object | false)
*/
public static function findByGuid($database, $guid)
{
	$db = DBI::getInstance($database);
	/* @var $db DBI_mysqli */

	$query =
	"
	SELECT
	ui.*

	FROM `user_invitations` ui
	WHERE ui.`guid` = ?
	";
	$arrValues = array($guid);
	$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
	$row = $db->fetch();
	$db->free_result();
	if ($row && !empty($row)) {
		$user_invitation_id = $row['id'];
		$userInvitation = self::instantiateOrm($database, 'UserInvitation', $row, null, $user_invitation_id);
		/* @var $userInvitation UserInvitation */
		return $userInvitation;
	} else {
		return false;
	}
}

// Loaders: Load By pk List (list of auto int ids or other non auto int pk list)
/**
* Load zero or more records by an id list (array of auto int primary keys).
*
* @param string $database
* @param array $arrUserInvitationIds
* @param mixed (Input $options object | null)
* @return mixed (array ORM List | empty array)
*/
public static function loadUserInvitationsByArrUserInvitationIds($database, $arrUserInvitationIds, Input $options=null)
{
	if (empty($arrUserInvitationIds)) {
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
	// ORDER BY `id` ASC, `user_id` ASC, `contact_id` ASC, `project_id` ASC, `user_invitation_type_id` ASC, `guid` ASC, `contact_user_company_id` ASC, `employer_identification_number` ASC, `created` ASC, `user_invitation_expiration_timestamp` ASC
	$sqlOrderBy = '';
	if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
		$tmpUserInvitation = new UserInvitation($database);
		$sqlOrderByColumns = $tmpUserInvitation->constructSqlOrderByColumns($arrOrderByAttributes);

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

	foreach ($arrUserInvitationIds as $k => $user_invitation_id) {
		$user_invitation_id = (int) $user_invitation_id;
		$arrUserInvitationIds[$k] = $db->escape($user_invitation_id);
	}
	$csvUserInvitationIds = join(',', $arrUserInvitationIds);

	$query =
	"
	SELECT

	ui.*

	FROM `user_invitations` ui
	WHERE ui.`id` IN ($csvUserInvitationIds){$sqlOrderBy}{$sqlLimit}
	";
	$arrValues = array();
	$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
	$row = $db->fetch();
	$db->free_result();

	$arrUserInvitationsByCsvUserInvitationIds = array();
	while ($row = $db->fetch()) {
		$user_invitation_id = $row['id'];
		$userInvitation = self::instantiateOrm($database, 'UserInvitation', $row, null, $user_invitation_id);
		/* @var $userInvitation UserInvitation */
		$userInvitation->convertPropertiesToData();

		$arrUserInvitationsByCsvUserInvitationIds[$user_invitation_id] = $userInvitation;
	}

	$db->free_result();

	return $arrUserInvitationsByCsvUserInvitationIds;
}

// Loaders: Load By Foreign Key
/**
* Load by constraint `user_invitations_fk_u` foreign key (`user_id`) references `users` (`id`) on delete cascade on update cascade.
*
* @param string $database
* @param int $user_id
* @param mixed (Input $options object | null)
* @return mixed (array ORM List | empty array)
*/
public static function loadUserInvitationsByUserId($database, $user_id, Input $options=null)
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
		self::$_arrUserInvitationsByUserId = null;
	}

	$arrUserInvitationsByUserId = self::$_arrUserInvitationsByUserId;
	if (isset($arrUserInvitationsByUserId) && !empty($arrUserInvitationsByUserId)) {
		return $arrUserInvitationsByUserId;
	}

	$user_id = (int) $user_id;

	$db = DBI::getInstance($database);
	/* @var $db DBI_mysqli */

	// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
	// ORDER BY `id` ASC, `user_id` ASC, `contact_id` ASC, `project_id` ASC, `user_invitation_type_id` ASC, `guid` ASC, `contact_user_company_id` ASC, `employer_identification_number` ASC, `created` ASC, `user_invitation_expiration_timestamp` ASC
	$sqlOrderBy = '';
	if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
		$tmpUserInvitation = new UserInvitation($database);
		$sqlOrderByColumns = $tmpUserInvitation->constructSqlOrderByColumns($arrOrderByAttributes);

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
	ui.*

	FROM `user_invitations` ui
	WHERE ui.`user_id` = ?{$sqlOrderBy}{$sqlLimit}
	";
	// LIMIT 10
	// ORDER BY `id` ASC, `user_id` ASC, `contact_id` ASC, `project_id` ASC, `user_invitation_type_id` ASC, `guid` ASC, `contact_user_company_id` ASC, `employer_identification_number` ASC, `created` ASC, `user_invitation_expiration_timestamp` ASC
	$arrValues = array($user_id);
	$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

	$arrUserInvitationsByUserId = array();
	while ($row = $db->fetch()) {
		$user_invitation_id = $row['id'];
		$userInvitation = self::instantiateOrm($database, 'UserInvitation', $row, null, $user_invitation_id);
		/* @var $userInvitation UserInvitation */
		$arrUserInvitationsByUserId[$user_invitation_id] = $userInvitation;
	}

	$db->free_result();

	self::$_arrUserInvitationsByUserId = $arrUserInvitationsByUserId;

	return $arrUserInvitationsByUserId;
}

/**
* Load by constraint `user_invitations_fk_c` foreign key (`contact_id`) references `contacts` (`id`) on delete cascade on update cascade.
*
* @param string $database
* @param int $contact_id
* @param mixed (Input $options object | null)
* @return mixed (array ORM List | empty array)
*/
public static function loadUserInvitationsByContactId($database, $contact_id, Input $options=null)
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
		self::$_arrUserInvitationsByContactId = null;
	}

	$arrUserInvitationsByContactId = self::$_arrUserInvitationsByContactId;
	if (isset($arrUserInvitationsByContactId) && !empty($arrUserInvitationsByContactId)) {
		return $arrUserInvitationsByContactId;
	}

	$contact_id = (int) $contact_id;

	$db = DBI::getInstance($database);
	/* @var $db DBI_mysqli */

	// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
	// ORDER BY `id` ASC, `user_id` ASC, `contact_id` ASC, `project_id` ASC, `user_invitation_type_id` ASC, `guid` ASC, `contact_user_company_id` ASC, `employer_identification_number` ASC, `created` ASC, `user_invitation_expiration_timestamp` ASC
	$sqlOrderBy = '';
	if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
		$tmpUserInvitation = new UserInvitation($database);
		$sqlOrderByColumns = $tmpUserInvitation->constructSqlOrderByColumns($arrOrderByAttributes);

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
	ui.*

	FROM `user_invitations` ui
	WHERE ui.`contact_id` = ?{$sqlOrderBy}{$sqlLimit}
	";
	// LIMIT 10
	// ORDER BY `id` ASC, `user_id` ASC, `contact_id` ASC, `project_id` ASC, `user_invitation_type_id` ASC, `guid` ASC, `contact_user_company_id` ASC, `employer_identification_number` ASC, `created` ASC, `user_invitation_expiration_timestamp` ASC
	$arrValues = array($contact_id);
	$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

	$arrUserInvitationsByContactId = array();
	while ($row = $db->fetch()) {
		$user_invitation_id = $row['id'];
		$userInvitation = self::instantiateOrm($database, 'UserInvitation', $row, null, $user_invitation_id);
		/* @var $userInvitation UserInvitation */
		$arrUserInvitationsByContactId[$user_invitation_id] = $userInvitation;
	}

	$db->free_result();

	self::$_arrUserInvitationsByContactId = $arrUserInvitationsByContactId;

	return $arrUserInvitationsByContactId;
}

/**
* Load by constraint `user_invitations_fk_p` foreign key (`project_id`) references `projects` (`id`) on delete cascade on update cascade.
*
* @param string $database
* @param int $project_id
* @param mixed (Input $options object | null)
* @return mixed (array ORM List | empty array)
*/
public static function loadUserInvitationsByProjectId($database, $project_id, Input $options=null)
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
		self::$_arrUserInvitationsByProjectId = null;
	}

	$arrUserInvitationsByProjectId = self::$_arrUserInvitationsByProjectId;
	if (isset($arrUserInvitationsByProjectId) && !empty($arrUserInvitationsByProjectId)) {
		return $arrUserInvitationsByProjectId;
	}

	$project_id = (int) $project_id;

	$db = DBI::getInstance($database);
	/* @var $db DBI_mysqli */

	// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
	// ORDER BY `id` ASC, `user_id` ASC, `contact_id` ASC, `project_id` ASC, `user_invitation_type_id` ASC, `guid` ASC, `contact_user_company_id` ASC, `employer_identification_number` ASC, `created` ASC, `user_invitation_expiration_timestamp` ASC
	$sqlOrderBy = '';
	if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
		$tmpUserInvitation = new UserInvitation($database);
		$sqlOrderByColumns = $tmpUserInvitation->constructSqlOrderByColumns($arrOrderByAttributes);

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
	ui.*

	FROM `user_invitations` ui
	WHERE ui.`project_id` = ?{$sqlOrderBy}{$sqlLimit}
	";
	// LIMIT 10
	// ORDER BY `id` ASC, `user_id` ASC, `contact_id` ASC, `project_id` ASC, `user_invitation_type_id` ASC, `guid` ASC, `contact_user_company_id` ASC, `employer_identification_number` ASC, `created` ASC, `user_invitation_expiration_timestamp` ASC
	$arrValues = array($project_id);
	$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

	$arrUserInvitationsByProjectId = array();
	while ($row = $db->fetch()) {
		$user_invitation_id = $row['id'];
		$userInvitation = self::instantiateOrm($database, 'UserInvitation', $row, null, $user_invitation_id);
		/* @var $userInvitation UserInvitation */
		$arrUserInvitationsByProjectId[$user_invitation_id] = $userInvitation;
	}

	$db->free_result();

	self::$_arrUserInvitationsByProjectId = $arrUserInvitationsByProjectId;

	return $arrUserInvitationsByProjectId;
}

/**
* Load by constraint `user_invitations_fk_uit` foreign key (`user_invitation_type_id`) references `user_invitation_types` (`id`) on delete restrict on update cascade.
*
* @param string $database
* @param int $user_invitation_type_id
* @param mixed (Input $options object | null)
* @return mixed (array ORM List | empty array)
*/
public static function loadUserInvitationsByUserInvitationTypeId($database, $user_invitation_type_id, Input $options=null)
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
		self::$_arrUserInvitationsByUserInvitationTypeId = null;
	}

	$arrUserInvitationsByUserInvitationTypeId = self::$_arrUserInvitationsByUserInvitationTypeId;
	if (isset($arrUserInvitationsByUserInvitationTypeId) && !empty($arrUserInvitationsByUserInvitationTypeId)) {
		return $arrUserInvitationsByUserInvitationTypeId;
	}

	$user_invitation_type_id = (int) $user_invitation_type_id;

	$db = DBI::getInstance($database);
	/* @var $db DBI_mysqli */

	// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
	// ORDER BY `id` ASC, `user_id` ASC, `contact_id` ASC, `project_id` ASC, `user_invitation_type_id` ASC, `guid` ASC, `contact_user_company_id` ASC, `employer_identification_number` ASC, `created` ASC, `user_invitation_expiration_timestamp` ASC
	$sqlOrderBy = '';
	if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
		$tmpUserInvitation = new UserInvitation($database);
		$sqlOrderByColumns = $tmpUserInvitation->constructSqlOrderByColumns($arrOrderByAttributes);

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
	ui.*

	FROM `user_invitations` ui
	WHERE ui.`user_invitation_type_id` = ?{$sqlOrderBy}{$sqlLimit}
	";
	// LIMIT 10
	// ORDER BY `id` ASC, `user_id` ASC, `contact_id` ASC, `project_id` ASC, `user_invitation_type_id` ASC, `guid` ASC, `contact_user_company_id` ASC, `employer_identification_number` ASC, `created` ASC, `user_invitation_expiration_timestamp` ASC
	$arrValues = array($user_invitation_type_id);
	$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

	$arrUserInvitationsByUserInvitationTypeId = array();
	while ($row = $db->fetch()) {
		$user_invitation_id = $row['id'];
		$userInvitation = self::instantiateOrm($database, 'UserInvitation', $row, null, $user_invitation_id);
		/* @var $userInvitation UserInvitation */
		$arrUserInvitationsByUserInvitationTypeId[$user_invitation_id] = $userInvitation;
	}

	$db->free_result();

	self::$_arrUserInvitationsByUserInvitationTypeId = $arrUserInvitationsByUserInvitationTypeId;

	return $arrUserInvitationsByUserInvitationTypeId;
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
public static function loadUserInvitationsByCreated($database, $created, Input $options=null)
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
		self::$_arrUserInvitationsByCreated = null;
	}

	$arrUserInvitationsByCreated = self::$_arrUserInvitationsByCreated;
	if (isset($arrUserInvitationsByCreated) && !empty($arrUserInvitationsByCreated)) {
		return $arrUserInvitationsByCreated;
	}

	$created = (string) $created;

	$db = DBI::getInstance($database);
	/* @var $db DBI_mysqli */

	// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
	// ORDER BY `id` ASC, `user_id` ASC, `contact_id` ASC, `project_id` ASC, `user_invitation_type_id` ASC, `guid` ASC, `contact_user_company_id` ASC, `employer_identification_number` ASC, `created` ASC, `user_invitation_expiration_timestamp` ASC
	$sqlOrderBy = '';
	if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
		$tmpUserInvitation = new UserInvitation($database);
		$sqlOrderByColumns = $tmpUserInvitation->constructSqlOrderByColumns($arrOrderByAttributes);

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
	ui.*

	FROM `user_invitations` ui
	WHERE ui.`created` = ?{$sqlOrderBy}{$sqlLimit}
	";
	// LIMIT 10
	// ORDER BY `id` ASC, `user_id` ASC, `contact_id` ASC, `project_id` ASC, `user_invitation_type_id` ASC, `guid` ASC, `contact_user_company_id` ASC, `employer_identification_number` ASC, `created` ASC, `user_invitation_expiration_timestamp` ASC
	$arrValues = array($created);
	$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

	$arrUserInvitationsByCreated = array();
	while ($row = $db->fetch()) {
		$user_invitation_id = $row['id'];
		$userInvitation = self::instantiateOrm($database, 'UserInvitation', $row, null, $user_invitation_id);
		/* @var $userInvitation UserInvitation */
		$arrUserInvitationsByCreated[$user_invitation_id] = $userInvitation;
	}

	$db->free_result();

	self::$_arrUserInvitationsByCreated = $arrUserInvitationsByCreated;

	return $arrUserInvitationsByCreated;
}

/**
* Load by key `user_invitation_expiration_timestamp` (`user_invitation_expiration_timestamp`).
*
* @param string $database
* @param string $user_invitation_expiration_timestamp
* @param mixed (Input $options object | null)
* @return mixed (single ORM object | false)
*/
public static function loadUserInvitationsByUserInvitationExpirationTimestamp($database, $user_invitation_expiration_timestamp, Input $options=null)
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
		self::$_arrUserInvitationsByUserInvitationExpirationTimestamp = null;
	}

	$arrUserInvitationsByUserInvitationExpirationTimestamp = self::$_arrUserInvitationsByUserInvitationExpirationTimestamp;
	if (isset($arrUserInvitationsByUserInvitationExpirationTimestamp) && !empty($arrUserInvitationsByUserInvitationExpirationTimestamp)) {
		return $arrUserInvitationsByUserInvitationExpirationTimestamp;
	}

	$user_invitation_expiration_timestamp = (string) $user_invitation_expiration_timestamp;

	$db = DBI::getInstance($database);
	/* @var $db DBI_mysqli */

	// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
	// ORDER BY `id` ASC, `user_id` ASC, `contact_id` ASC, `project_id` ASC, `user_invitation_type_id` ASC, `guid` ASC, `contact_user_company_id` ASC, `employer_identification_number` ASC, `created` ASC, `user_invitation_expiration_timestamp` ASC
	$sqlOrderBy = '';
	if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
		$tmpUserInvitation = new UserInvitation($database);
		$sqlOrderByColumns = $tmpUserInvitation->constructSqlOrderByColumns($arrOrderByAttributes);

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
	ui.*

	FROM `user_invitations` ui
	WHERE ui.`user_invitation_expiration_timestamp` = ?{$sqlOrderBy}{$sqlLimit}
	";
	// LIMIT 10
	// ORDER BY `id` ASC, `user_id` ASC, `contact_id` ASC, `project_id` ASC, `user_invitation_type_id` ASC, `guid` ASC, `contact_user_company_id` ASC, `employer_identification_number` ASC, `created` ASC, `user_invitation_expiration_timestamp` ASC
	$arrValues = array($user_invitation_expiration_timestamp);
	$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

	$arrUserInvitationsByUserInvitationExpirationTimestamp = array();
	while ($row = $db->fetch()) {
		$user_invitation_id = $row['id'];
		$userInvitation = self::instantiateOrm($database, 'UserInvitation', $row, null, $user_invitation_id);
		/* @var $userInvitation UserInvitation */
		$arrUserInvitationsByUserInvitationExpirationTimestamp[$user_invitation_id] = $userInvitation;
	}

	$db->free_result();

	self::$_arrUserInvitationsByUserInvitationExpirationTimestamp = $arrUserInvitationsByUserInvitationExpirationTimestamp;

	return $arrUserInvitationsByUserInvitationExpirationTimestamp;
}

// Loaders: Load By additionally indexed attribute

// Loaders: Load All Records
/**
* Load all user_invitations records.
*
* @param string $database
* @param mixed (Input $options object | null)
* @return mixed (array ORM List | empty array)
*/
public static function loadAllUserInvitations($database, Input $options=null)
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
		self::$_arrAllUserInvitations = null;
	}

	$arrAllUserInvitations = self::$_arrAllUserInvitations;
	if (isset($arrAllUserInvitations) && !empty($arrAllUserInvitations)) {
		return $arrAllUserInvitations;
	}

	$db = DBI::getInstance($database);
	/* @var $db DBI_mysqli */

	// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
	// ORDER BY `id` ASC, `user_id` ASC, `contact_id` ASC, `project_id` ASC, `user_invitation_type_id` ASC, `guid` ASC, `contact_user_company_id` ASC, `employer_identification_number` ASC, `created` ASC, `user_invitation_expiration_timestamp` ASC
	$sqlOrderBy = '';
	if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
		$tmpUserInvitation = new UserInvitation($database);
		$sqlOrderByColumns = $tmpUserInvitation->constructSqlOrderByColumns($arrOrderByAttributes);

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
	ui.*

	FROM `user_invitations` ui{$sqlOrderBy}{$sqlLimit}
	";
	// LIMIT 10
	// ORDER BY `id` ASC, `user_id` ASC, `contact_id` ASC, `project_id` ASC, `user_invitation_type_id` ASC, `guid` ASC, `contact_user_company_id` ASC, `employer_identification_number` ASC, `created` ASC, `user_invitation_expiration_timestamp` ASC
	$db->query($query, MYSQLI_USE_RESULT);

	$arrAllUserInvitations = array();
	while ($row = $db->fetch()) {
		$user_invitation_id = $row['id'];
		$userInvitation = self::instantiateOrm($database, 'UserInvitation', $row, null, $user_invitation_id);
		/* @var $userInvitation UserInvitation */
		$arrAllUserInvitations[$user_invitation_id] = $userInvitation;
	}

	$db->free_result();

	self::$_arrAllUserInvitations = $arrAllUserInvitations;

	return $arrAllUserInvitations;
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
	INTO `user_invitations`
	(`user_id`, `contact_id`, `project_id`, `user_invitation_type_id`, `guid`, `contact_user_company_id`, `employer_identification_number`, `created`, `user_invitation_expiration_timestamp`)
	VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
	ON DUPLICATE KEY UPDATE `user_id` = ?, `contact_id` = ?, `project_id` = ?, `user_invitation_type_id` = ?, `contact_user_company_id` = ?, `employer_identification_number` = ?, `created` = ?, `user_invitation_expiration_timestamp` = ?
	";
	$arrValues = array($this->user_id, $this->contact_id, $this->project_id, $this->user_invitation_type_id, $this->guid, $this->contact_user_company_id, $this->employer_identification_number, $this->created, $this->user_invitation_expiration_timestamp, $this->user_id, $this->contact_id, $this->project_id, $this->user_invitation_type_id, $this->contact_user_company_id, $this->employer_identification_number, $this->created, $this->user_invitation_expiration_timestamp);
	$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
	$user_invitation_id = $db->insertId;
	$db->free_result();

	return $user_invitation_id;
}

// Save: insert ignore

// Loaders: Load By fk List (list of foreign keys)
/**
* Load zero or more records by a foreign key list.
*
* @param string $database
* @param array $arrContactIds
* @param mixed (Input $options object | null)
* @return mixed (array ORM List | empty array)
*/
public static function loadUserInvitationsByArrContactIds($database, $arrContactIds, Input $options=null)
{
	if (empty($arrContactIds)) {
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
	// ORDER BY `id` ASC, `user_id` ASC, `contact_id` ASC, `project_id` ASC, `user_invitation_type_id` ASC, `guid` ASC, `contact_user_company_id` ASC, `employer_identification_number` ASC, `created` ASC, `user_invitation_expiration_timestamp` ASC
	$sqlOrderBy = '';
	if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
		$tmpUserInvitation = new UserInvitation($database);
		$sqlOrderByColumns = $tmpUserInvitation->constructSqlOrderByColumns($arrOrderByAttributes);

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

	foreach ($arrContactIds as $k => $contact_id) {
		$contact_id = (int) $contact_id;
		$arrContactIds[$k] = $db->escape($contact_id);
	}
	$csvContactIds = join(',', $arrContactIds);

	$query =
	"
	SELECT

	ui.*

	FROM `user_invitations` ui
	WHERE ui.`contact_id` IN ($csvContactIds){$sqlOrderBy}{$sqlLimit}
	";
	$arrValues = array();
	$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
	$row = $db->fetch();
	$db->free_result();

	$arrUserInvitationsByCsvContactIds = array();
	while ($row = $db->fetch()) {
		$user_invitation_id = $row['id'];
		$userInvitation = self::instantiateOrm($database, 'UserInvitation', $row, null, $user_invitation_id);
		/* @var $userInvitation UserInvitation */
		$userInvitation->convertPropertiesToData();

		$arrUserInvitationsByCsvContactIds[$user_invitation_id] = $userInvitation;
	}

	$db->free_result();

	return $arrUserInvitationsByCsvContactIds;
}

public static function verifyInvitation($database, $guid)
{
	$userInvitation = new UserInvitation($database);
	$key = array('guid' => $guid);
	$userInvitation->setKey($key);
	$userInvitation->load();
	$dataLoadedFlag = $userInvitation->isDataLoaded();
	if ($dataLoadedFlag) {
		$userInvitation->convertDataToProperties();
		return $userInvitation;
	} else {
		return false;
	}
}

public static function notifyAccountAdminForMissingContactEmail($database, $contact_id, $inValidEmail,$user_id)
{
	// Application constants
	$AXIS_USER_ROLE_ID_GLOBAL_ADMIN = AXIS_USER_ROLE_ID_GLOBAL_ADMIN;
	$AXIS_USER_ROLE_ID_ADMIN = AXIS_USER_ROLE_ID_ADMIN;
	$contact_id = (int) $contact_id;

	$db = DBI::getInstance($database);
	/* @var $db DBI_mysqli */

	// Load all of the global_admin or admin users for a contact's User Company
	//		and alert them that the contact has an invalid email address.

	$query =
	"
	SELECT u.*
	FROM `users` u
	INNER JOIN `contacts` c ON u.`user_company_id` = c.`user_company_id`
	WHERE c.`id` = $contact_id
	AND u.`id` = $user_id
	";
	$arrValues = array();
	$db->query($query, MYSQLI_USE_RESULT);
	$row = $db->fetch();
	$db->free_result();
		
	// Send out a confirmation SMS or Email alert message
	// Determine if SMS, Email, or Both
	$alerts = $row['alerts'];

	if ($alerts == 'Both') {
		$emailFlag = true;
		$smsFlag = true;
	} elseif ($alerts == 'Email') {
		$emailFlag = true;
		$smsFlag = false;
	} elseif ($alerts == 'SMS') {
		$emailFlag = false;
		$smsFlag = true;
	} else {
		$emailFlag = true;
		$smsFlag = true;
	}

	$toName = $row['screen_name'];
	$fromEmail = 'alert@myfulcrum.com';
	$fromName = 'MyFulcrum.com AutoMessage';
	$alertMessageSubject = 'Contact record with an invalid email address';
	$alertMessageBody = $inValidEmail.' is an invalid email address.';
	$htmlAlertMessageBody = nl2br($alertMessageBody);	

	if ($emailFlag) {
		$toEmail = $row['email'];

		$mail = new Mail();
		$mail->setBodyText($alertMessageBody);
		$mail->setBodyHtml('<h2>'.$htmlAlertMessageBody.'</h2>');
		$mail->setFrom($fromEmail, $fromName);
		$mail->addTo($toEmail, $toName);
		$mail->addBcc('info@myfulcrum.com', $toName);
		$mail->setSubject($alertMessageSubject);
		$mail->send();
	}

	if ($smsFlag) {
		/**
		* MessageGateway_Sms
		*/
		MessageGateway_Sms::sendSmsMessage($row['mobile_phone_number'], $row['mobile_network_carrier_id'], $toName, $fromEmail, $fromName, $alertMessageSubject, $alertMessageBody);
	}
	
}

public static function verifyUserInvitationGuidUniqueness($database, $password_guid)
{
	$db = DBI::getInstance($database);
	/* @var $db DBI_mysqli */

	$query =
	"
	SELECT `guid`
	FROM `user_invitations`
	WHERE `guid` = ?
	";
	$arrValues = array($password_guid);
	$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
	$row = $db->fetch();
	$db->free_result();

	if (isset($row) && !empty($row)) {
		return false;
	} else {
		return true;
	}

	return false;
}

/**
* Invite a user to:
* a) bid
* 		$arrObjects is a list of trades
* b) join
* 		$arrObjects is a list of projects
*
* $arrObjects can by a list of trades, projects, or null
*
* @param string $database
* @param Contact $contact
* @param string $type
* @param array $arrObjects
* @return void
*/
public static function initiateUserInvitationProcess(
	$database,
	UserCompany $inviterUserCompany,
	Contact $inviterContact,
	Contact $contact,
	$type='bid',
	array $arrObjects=null,
	Project $project=null,
	$customEmailMessageFromInviter=null,$currentlyActiveContactId,$userPassGuide,$csvSubcontractorBidIds,$ccmail=null,$fileBidAttachments=null,$arrSubcontractorBidIds=null,$TransmittalId=''
	)
	{
		/* @var $inviterUserCompany UserCompany */
		/* @var $inviterContact Contact */
		/* @var $contact Contact */
		/* @var $project Project */

		// Debug
		//throw new Exception('');

		$arrTypes = array(
			'budget_number' => 1,
			'bid' => 1,
			'join' => 1
		);
		if (!isset($arrTypes[$type])) {
			throw new Exception('Invalid Inviation Type');;
		}

		$arrProjects = null;
		$arrSubcontractorBids = null;
		if (isset($arrObjects) && !empty($arrObjects)) {
			if ($type == 'join') {
				$arrProjects = $arrObjects;
			} elseif ($type == 'bid') {
				$arrSubcontractorBids = $arrObjects;
			} elseif ($type == 'budget_number') {
				$arrSubcontractorBids = $arrObjects;
			}
		}

		// "bid" type requires $project to be set
		if ($type == 'bid') {
			if (!isset($project) || !($project instanceof Project)) {
				throw new Exception('No Project.');
			}
			if (empty($arrSubcontractorBids)) {
				throw new Exception('No Trades.');
			}
		} elseif ($type == 'budget_number') {
			if (!isset($project) || !($project instanceof Project)) {
				throw new Exception('No Project.');
			}
			if (empty($arrSubcontractorBids)) {
				throw new Exception('No Trades.');
			}
		} elseif ($type == 'join') {
			// Error detection here for the Join case...if needed
		}

		// Application constants
		$AXIS_USER_INVITATION_TYPE_ID_USER_CREATION_VIA_INVITATION = AXIS_USER_INVITATION_TYPE_ID_USER_CREATION_VIA_INVITATION;
		$AXIS_USER_INVITATION_TYPE_ID_USER_CREATION_VIA_BID = AXIS_USER_INVITATION_TYPE_ID_USER_CREATION_VIA_BID;
		//$AXIS_USER_INVITATION_TYPE_ID_USER_CREATION_VIA_BUDGET_NUMBER = AXIS_USER_INVITATION_TYPE_ID_USER_CREATION_VIA_BUDGET_NUMBER;
		$AXIS_USER_INVITATION_TYPE_ID_USER_CREATION_VIA_BUDGET_NUMBER = AXIS_USER_INVITATION_TYPE_ID_USER_CREATION_VIA_BID;

		// convert a contact into a user
		// 1) create a user_invitations record
		// 2) send an email to the contact's email address with a GUID in the link

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		
		$codehash='';
		$mobilePhoneNumber = $contact->getMobilePhoneNumber();
		/* @var $mobilePhoneNumber MobilePhoneNumber */
		if ($mobilePhoneNumber) {
			$mobile_phone_number = $mobilePhoneNumber->getMobilePhoneNumber();
			$mobile_network_carrier_id = $mobilePhoneNumber->mobile_network_carrier_id;
			$smsFlag = true;
		} else {
			$smsFlag = false;
		}

		$user_company_id = $contact->user_company_id;
		$user_id = $contact->user_id;
		$contact_company_id = $contact->contact_company_id;

		$contactCompany = ContactCompany::findById($database, $contact_company_id);
		$contact_user_company_id = $contactCompany->contact_user_company_id;

		$toEmail = $contact->email;
		$contactFullName = $contact->getContactFullName();
		$name_prefix = $contact->name_prefix;
		$first_name = $contact->first_name;
		$additional_name = $contact->additional_name;
		$middle_name = $contact->middle_name;
		$last_name = $contact->last_name;
		$name_suffix = $contact->name_suffix;
		$title = $contact->title;
		$contact_id=$contact->contact_id;

		// Check for a valid email
		$validEmail = false;
		if (isset($toEmail) || !empty($toEmail)) {
			$validContactEmailFlag = Validate::email2($toEmail);
			if ($validContactEmailFlag) {
				$validEmail = true;
			}
		}

		$currently_Active_Contact_Id = $inviterContact->user_id;

		// Debug
		//$validEmail = false;
		if (!$validEmail) {
			// Send a message to the account admin for bad contact data
			// @todo Add the type ("join" or "bid")
			self::notifyAccountAdminForMissingContactEmail($database, $contact->contact_id, $toEmail,$currently_Active_Contact_Id);
			return false;
		}

		$formattedProjectList = '';
		$formattedTradesList = '';
		$includeAttachment = false;
		$arrAttachments = array();
		if ($type == 'join') {
			$user_invitation_type = $AXIS_USER_INVITATION_TYPE_ID_USER_CREATION_VIA_INVITATION;
			$AXIS_NON_EXISTENT_PROJECT_ID = AXIS_NON_EXISTENT_PROJECT_ID;
			$projectCount = 0;
			if (isset($arrProjects) && !empty($arrProjects)) {
				$projectCount = count($arrProjects);
				$formattedProjectList = 'Projects:'.PHP_EOL;
				foreach ($arrProjects as $project) {
					$formattedProjectList .= $project->project_name . PHP_EOL;
				}

				if ($projectCount == 1) {
					$project = array_pop($arrProjects);
				}
			}
			$checkatt="0";

			$invitePDF ="<table style=width:80%;>
			<tr>
			<td style='padding:2px;'>Please find the PDF File Link(s) :</td></tr>";
			// UUID/GUID for the user_inivation guid attribute
			do {
				$password_guid = User::createPasswordGuid();
				$passwordGuidUniqueFlag = User::verifyPasswordGuidUniqueness($database, $password_guid);
				$userInvitationGuidUniqueFlag = UserInvitation::verifyUserInvitationGuidUniqueness($database, $password_guid);
			} while (!$passwordGuidUniqueFlag && !$userInvitationGuidUniqueFlag);
			$guid = $password_guid;

			$uri = Zend_Registry::get('uri');
			$url = $uri->https.'account-registration-form-step1.php?guid='.$guid;
			$smsUrl = $uri->https.'r.php?guid='.$guid;

			// Debug
			//$url = 'http://staging2.adventcompanies.com/account-registration-form-step1.php?guid='.$guid;

			/**
			* @todo $project_id in the arrayValues is not being defined ...
			*/

			$query =
			"
			DELETE
			FROM `user_invitations`
			WHERE `user_id` = ?
			AND `contact_id` = ?
			AND `user_invitation_type_id` = 1
			";
			$arrValues = array($contact->user_id,  $contact->contact_id);
			$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
			$db->free_result();

			$query =
			"
			INSERT INTO `user_invitations`
			( `user_id`, `contact_id`, `project_id`, `user_invitation_type_id`, `guid`, `contact_user_company_id`, `created`, `user_invitation_expiration_timestamp` )
			VALUES ( ?, ?, ?, ?, ?, ?, null, (NOW() + INTERVAL 1 DAY) )
			";
			$arrValues = array($contact->user_id, $contact->contact_id, $AXIS_NON_EXISTENT_PROJECT_ID, $user_invitation_type, $guid, $contact_user_company_id);
			$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
			$db->free_result();
		} elseif ($type == 'bid') {

			$user_invitation_type = $AXIS_USER_INVITATION_TYPE_ID_USER_CREATION_VIA_BID;
			$projectCount = 1;
			$arrGcBudgetLineItemIds = array();
			if (isset($arrSubcontractorBids) && !empty($arrSubcontractorBids)) {
				$subcontractorBidCount = count($arrSubcontractorBids);
				$formattedTradesList = 'Trades:'.PHP_EOL;
				foreach ($arrSubcontractorBids as $subcontractor_bid_id => $subcontractorBid) {
					/* @var $subcontractorBid SubcontractorBid */

					$gcBudgetLineItem = $subcontractorBid->getGcBudgetLineItem();
					/* @var $gcBudgetLineItem GcBudgetLineItem */

					$costCode = $gcBudgetLineItem->getCostCode();
					/* @var $costCode CostCode */

					$formattedCostCode = $costCode->getFormattedCostCode($database,true,$user_company_id);
					$codehash = base64_encode($formattedCostCode);


					$formattedTradesList .= $formattedCostCode . PHP_EOL;
					$arrGcBudgetLineItemIds[] = $subcontractorBid->gc_budget_line_item_id;

					// @todo Load Scope of work documents by gc_budget_line_item_id or subcontractor_bid_id
					// Check to see if there is a scope of work that we need to include in the email
					$query =
					"
					SELECT *
					FROM `gc_budget_line_item_unsigned_scope_of_work_documents`
					WHERE `gc_budget_line_item_id` = ?
					ORDER BY `unsigned_scope_of_work_document_sequence_number` DESC
					LIMIT 1
					";
					$arrValues = array($subcontractorBid->gc_budget_line_item_id);
					$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
					while ($row = $db->fetch()) {
						if (isset($row['unsigned_scope_of_work_document_file_manager_file_id']) && !empty($row['unsigned_scope_of_work_document_file_manager_file_id'])) {
							$includeAttachment = true;
							$unsigned_scope_of_work_document_file_manager_file_id = $row['unsigned_scope_of_work_document_file_manager_file_id'];

							$arrAttachments[$unsigned_scope_of_work_document_file_manager_file_id]['cdnFileUrl'] = "";
							$arrAttachments[$unsigned_scope_of_work_document_file_manager_file_id]['fileName'] = "";
							break;
						}
					}
					$db->free_result();
				}
			}

			// Mail attachments
			if(isset($fileBidAttachments) && !empty($fileBidAttachments))
			{
				foreach($fileBidAttachments as $attachExist)
				{
				$fileManagefile = FileManagerFile::findById($database, $attachExist);
				$includeAttachment = true;
				$file_manager_file_id = $fileManagefile->id;
				$arrAttachments[$file_manager_file_id]['cdnFileUrl'] = "";
				$arrAttachments[$file_manager_file_id]['fileName'] = "";
				}
			}

			$project_id = $project->project_id;

			// Check to see if there is a bid invitation that we need to include in the email
			$query =
			"
			SELECT *
			FROM `project_bid_invitations`
			WHERE `project_id` = ?
			ORDER BY `project_bid_invitation_sequence_number` DESC
			LIMIT 1
			";
			$arrValues = array($project_id);
			$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
			while ($row = $db->fetch()) {
				$includeAttachment = true;
				$file_manager_file_id = $row['project_bid_invitation_file_manager_file_id'];

				$arrAttachments[$file_manager_file_id]['cdnFileUrl'] = "";
				$arrAttachments[$file_manager_file_id]['fileName'] = "";
				break;
			}
			$db->free_result();

			$uri = Zend_Registry::get('uri');
			if ($includeAttachment) {
				require_once('lib/common/FileManagerFile.php');

				foreach ($arrAttachments AS $file_manager_file_id => $null) {
					$fileManagerFile = FileManagerFile::findById($database, $file_manager_file_id);
					$cdnFileUrl = $uri->cdn . '_' . $file_manager_file_id;
					//To check the pdf size

					// $attachMentFile = $fileManagerFile->generateUrl();

					// for file size greater than 17 mb
					$filemaxSize=Module::getfilemanagerfilesize($fileManagerFile->file_location_id, $database);
					if(!$filemaxSize)
					{

						if (strpos($attachMentFile,"?"))
						{
							$virtual_file_name_url = $attachMentFile."&id=76wrQhuMZizg60wWPppeHFGijhGktEXs94bs0otFuxmTK5JPk2GtviAzLfqPvM4yTJ7KeRP6fsK96InPHvimqtUGUAgt1T8bGn1C";
						}else
						{
							$virtual_file_name_url = $attachMentFile."?id=76wrQhuMZizg60wWPppeHFGijhGktEXs94bs0otFuxmTK5JPk2GtviAzLfqPvM4yTJ7KeRP6fsK96InPHvimqtUGUAgt1T8bGn1C";
						}

						$invitePDF .="<tr><td style='padding:2px;'><a href='".$virtual_file_name_url."'>".$fileManagerFile->virtual_file_name."</a></td></tr>";
						$checkatt= "1";
					} //End of file size
					else
					{


						$arrAttachments[$file_manager_file_id]['cdnFileUrl'] = $cdnFileUrl;
						$arrAttachments[$file_manager_file_id]['fileName'] = $fileManagerFile->virtual_file_name;
					}
				}
			}

			// UUID/GUID for the user_inivation guid attribute
			do {
				$password_guid = User::createPasswordGuid();
				$passwordGuidUniqueFlag = User::verifyPasswordGuidUniqueness($database, $password_guid);
				$userInvitationGuidUniqueFlag = UserInvitation::verifyUserInvitationGuidUniqueness($database, $password_guid);

				$continueDo = false;
				if (!$passwordGuidUniqueFlag) {
					$continueDo = true;
				}
				if (!$userInvitationGuidUniqueFlag) {
					$continueDo = true;
				}
			} while ($continueDo);
			$guid = $password_guid;

			$csvGcBudgetLineItemIds = implode(',', $arrGcBudgetLineItemIds);
			$url = $uri->https.'account-registration-form-bid-response-step1.php?guid='.$guid.'&gblids='.$csvGcBudgetLineItemIds;
			$smsUrl = $uri->https.'r.php?guid='.$guid;

			$query =
			"
			DELETE
			FROM `user_invitations`
			WHERE `user_id` = ?
			AND `contact_id` = ?
			AND `user_invitation_type_id` = 1
			";
			$arrValues = array($contact->user_id,  $contact->contact_id);
			$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
			$db->free_result();

			$query =
			"
			INSERT INTO `user_invitations`
			( `user_id`, `contact_id`, `project_id`, `user_invitation_type_id`, `guid`, `contact_user_company_id`, `created`, `user_invitation_expiration_timestamp` )
			VALUES ( ?, ?, ?, ?, ?, ?, null, (NOW() + INTERVAL 1 DAY) )
			";
			$arrValues = array($contact->user_id, $contact->contact_id, $project_id, $user_invitation_type, $guid, $contact_user_company_id);
			$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
			$db->free_result();
		} elseif ($type == 'budget_number') {

			$user_invitation_type = $AXIS_USER_INVITATION_TYPE_ID_USER_CREATION_VIA_BUDGET_NUMBER;
			$projectCount = 1;
			$arrGcBudgetLineItemIds = array();
			if (isset($arrSubcontractorBids) && !empty($arrSubcontractorBids)) {
				$subcontractorBidCount = count($arrSubcontractorBids);
				$formattedTradesList = 'Trades:'.PHP_EOL;
				foreach ($arrSubcontractorBids as $subcontractor_bid_id => $subcontractorBid) {
					/* @var $subcontractorBid SubcontractorBid */

					$gcBudgetLineItem = $subcontractorBid->getGcBudgetLineItem();
					/* @var $gcBudgetLineItem GcBudgetLineItem */

					$costCode = $gcBudgetLineItem->getCostCode();
					/* @var $costCode CostCode */

					$formattedCostCode = $costCode->getFormattedCostCode($database,true, $user_company_id);

					$formattedTradesList .= $formattedCostCode . PHP_EOL;
					$arrGcBudgetLineItemIds[] = $subcontractorBid->gc_budget_line_item_id;

					// Check to see if there is a scope of work that we need to include in the email
					$query =
					"
					SELECT *
					FROM `gc_budget_line_item_unsigned_scope_of_work_documents`
					WHERE `gc_budget_line_item_id` = ?
					ORDER BY `unsigned_scope_of_work_document_sequence_number` DESC
					LIMIT 1
					";
					$arrValues = array($subcontractorBid->gc_budget_line_item_id);
					$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

					while ($row = $db->fetch()) {
						if (isset($row['unsigned_scope_of_work_document_file_manager_file_id']) && !empty($row['unsigned_scope_of_work_document_file_manager_file_id'])) {
							$includeAttachment = true;
							$unsigned_scope_of_work_document_file_manager_file_id = $row['unsigned_scope_of_work_document_file_manager_file_id'];

							$arrAttachments[$unsigned_scope_of_work_document_file_manager_file_id]['cdnFileUrl'] = "";
							$arrAttachments[$unsigned_scope_of_work_document_file_manager_file_id]['fileName'] = "";
							break;
						}
						break;
					}
					$db->free_result();
				}
			}

			$project_id = $project->project_id;

			// Check to see if there is a bid invitation that we need to include in the email
			$query =
			"
			SELECT *
			FROM `project_bid_invitations`
			WHERE `project_id` = ?
			ORDER BY `project_bid_invitation_sequence_number` DESC
			LIMIT 1
			";
			$arrValues = array($project_id);
			$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
			while ($row = $db->fetch()) {
				$includeAttachment = true;
				$file_manager_file_id = $row['project_bid_invitation_file_manager_file_id'];

				$arrAttachments[$file_manager_file_id]['cdnFileUrl'] = '';
				$arrAttachments[$file_manager_file_id]['fileName'] = '';
				break;
			}
			$db->free_result();

			$uri = Zend_Registry::get('uri');
			if ($includeAttachment) {
				require_once('lib/common/FileManagerFile.php');

				foreach ($arrAttachments AS $file_manager_file_id => $null) {
					$fileManagerFile = FileManagerFile::findById($database, $file_manager_file_id);
					$cdnFileUrl = $uri->cdn . '_' . $file_manager_file_id;

					//To check the pdf size

					$attachMentFile = $fileManagerFile->generateUrl(true);

					// for file size greater than 17 mb
					$filemaxSize=Module::getfilemanagerfilesize($fileManagerFile->file_location_id, $database);
					if(!$filemaxSize)
					{

						if (strpos($attachMentFile,"?"))
						{
							$virtual_file_name_url = $attachMentFile."&id=76wrQhuMZizg60wWPppeHFGijhGktEXs94bs0otFuxmTK5JPk2GtviAzLfqPvM4yTJ7KeRP6fsK96InPHvimqtUGUAgt1T8bGn1C";
						}else
						{
							$virtual_file_name_url = $attachMentFile."?id=76wrQhuMZizg60wWPppeHFGijhGktEXs94bs0otFuxmTK5JPk2GtviAzLfqPvM4yTJ7KeRP6fsK96InPHvimqtUGUAgt1T8bGn1C";
						}

						$invitePDF .="<tr><td style='padding:2px;'><a href='".$virtual_file_name_url."'>".$fileManagerFile->virtual_file_name."</a></td></tr>";
						$checkatt= "1";
					} //End of file size
					else
					{
						$arrAttachments[$file_manager_file_id]['cdnFileUrl'] = $cdnFileUrl;
						$arrAttachments[$file_manager_file_id]['fileName'] = $fileManagerFile->virtual_file_name;
					}
				}

			}
			$invitePDF .="</table><br>";

			if($checkatt=="1")
			{
				$inviteLink=$invitePDF;
			}else {
				$inviteLink="";
			}

			// UUID/GUID for the user_inivation guid attribute
			$db->begin();
			do {
				$password_guid = User::createPasswordGuid();
				$passwordGuidUniqueFlag = User::verifyPasswordGuidUniqueness($database, $password_guid);
				$userInvitationGuidUniqueFlag = UserInvitation::verifyUserInvitationGuidUniqueness($database, $password_guid);

				$continueDo = false;
				if (!$passwordGuidUniqueFlag) {
					$continueDo = true;
				}
				if (!$userInvitationGuidUniqueFlag) {
					$continueDo = true;
				}
			} while ($continueDo);
			$guid = $password_guid;

			$csvGcBudgetLineItemIds = implode(',', $arrGcBudgetLineItemIds);
			$url = $uri->https.'account-registration-form-bid-response-step1.php?guid='.$guid.'&gblids='.$csvGcBudgetLineItemIds;
			$smsUrl = $uri->https.'r.php?guid='.$guid;
			$viewURL = $uri->https.'Guest/modules-file-manager-file-browser.php?token='.$userPassGuide.'&pt_token='.$project_id.'&codes='.$codehash;

			$query =
			"
			DELETE
			FROM `user_invitations`
			WHERE `user_id` = ?
			AND `contact_id` = ?
			AND `user_invitation_type_id` = 1
			";
			$arrValues = array($contact->user_id,  $contact->contact_id);
			$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
			$db->free_result();

			$query =
			"
			INSERT INTO `user_invitations`
			( `user_id`, `contact_id`, `project_id`, `user_invitation_type_id`, `guid`, `contact_user_company_id`, `created`, `user_invitation_expiration_timestamp` )
			VALUES ( ?, ?, ?, ?, ?, ?, null, (NOW() + INTERVAL 1 DAY) )
			";
			$arrValues = array($contact->user_id, $contact->contact_id, $project_id, $user_invitation_type, $guid, $contact_user_company_id);
			$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
			$db->free_result();
			$db->commit();
		}



		// Send email to invite contact to register as a user or link an existing user account to the given contact_id
		// Send out a confirmation SMS or Email alert message
		// Determine if SMS, Email, or Both
		$emailFlag = true;
		$conid=base64_encode($contact_id);
		$subid=base64_encode($csvSubcontractorBidIds);
		$viewURL = $uri->https.'Guest/modules-file-manager-file-browser.php?token='.$userPassGuide.'&pt_token='.$project_id.'&subid='.$subid.'&conid='.$conid;

		// Email/SMS Details
		// To Name
		if (isset($first_name) && isset($last_name)) {
			$toName = $first_name.' '.$last_name;
			$smsToName = $first_name;
		} else {
			$toName = $contactFullName;
			$smsToName = $contactFullName;
		}

		// Invitation Initiator/Sender/Inviter's Information
		$inviteFromName = '';
/*
		if ($inviterUserCompany->company) {
			$closeParen = true;
			$inviteFromName = $inviterUserCompany->company .' (';
		} else {
			$closeParen = false;
		}
		if ($inviterContact->first_name && $inviterContact->last_name) {
			if (!empty($inviteFromName)) {
				$inviteFromName .= $inviterContact->first_name.' '.$inviterContact->last_name;
			}
			if ($inviterContact->title) {
				$inviteFromName .= ' - '.$inviterContact->title;
			}
		} else {
			$inviteFromName .= $inviterContact->email;
			if ($inviterContact->title) {
				$inviteFromName .= ' - '.$inviterContact->title;
			}
		}
		if ($closeParen) {
			$inviteFromName .= ')';
		}
*/

		$fromName = 'Fulcrum AutoMessage';
		//$fromEmail = 'service@myfulcrum.com';
		$smsFromName = 'Fulcrum';
		//$smsFromEmail = 'alert@myfulcrum.com';

		// Invitation Initiator/Sender/Inviter's Information
		$inviteFromSignature = '';
		// First Name
		if ($inviterContact->first_name) {
			$inviteFromSignature .= $inviterContact->first_name;
			$fromName = $inviterContact->first_name;
			$smsFromName = $inviterContact->first_name;
		}
		// Last Name
		if ($inviterContact->last_name) {
			$inviteFromSignature .= ' '.$inviterContact->last_name;
			if ($fromName != 'Fulcrum AutoMessage') {
				$fromName .= ' '.$inviterContact->last_name;
			}
		}
		// Title
		if ($inviterContact->title) {
			$inviteFromSignature .= '<br>'.$inviterContact->title;
		}
		// Company
		if ($inviterUserCompany->company) {
			$inviteFromSignature .= '<br>' .$inviterUserCompany->company;
		}

		// Address
		/**
		 * @todo Load Address info into signature if they have a primary office set
		 */

		// Phone Numbers
		/**
		 * @todo Load Phone info into signature if they have any
		 */

		// Email
		$inviteFromSignature .= '<br>' . $inviterContact->email;
		$fromEmail = $inviterContact->email;
		$smsFromEmail = $fromEmail;



/*
		$fromName = 'Fulcrum AutoMessage';
		$fromEmail = 'service@myfulcrum.com';
		$smsFromName = 'Fulcrum';
		$smsFromEmail = 'alert@myfulcrum.com';
*/

		// Subject Line
		if ($type == 'join') {
			if ($projectCount == 1) {
				// Subject line has the project name in it
				//$alertMessageSubject = "$project->project_name - {$inviterUserCompany->company} - Invitation to Join using Fulcrum Construction Management Software";
				$alertMessageSubject = "$project->project_name - Invitation to Join Project Team";
				//$smsAlertMessageSubject = "Join $project->project_name - {$inviterUserCompany->company}";
				$smsAlertMessageSubject = "Join $project->project_name";
			} else {
				// Generic join Fulcrum message
				$alertMessageSubject = "Fulcrum Construction Management Software - Invitation to Join";
				$smsAlertMessageSubject = "Join Fulcrum";
			}
		} elseif ($type == 'bid') {
			// Subject line has the project name in it
			//$alertMessageSubject = "$project->project_name ({$inviterUserCompany->company}) - Invitation to Bid Using Fulcrum Construction Management Software";
			$alertMessageSubject = "$project->project_name - Invitation to Bid";
			//$smsAlertMessageSubject = "Bid On $project->project_name ({$inviterUserCompany->company})";
			$smsAlertMessageSubject = "Bid On $project->project_name";
		} elseif ($type == 'budget_number') {
			// Subject line has the project name in it
			//$alertMessageSubject = "$project->project_name ({$inviterUserCompany->company}) - Invitation to Bid Using Fulcrum Construction Management Software";
			$alertMessageSubject = "$project->project_name - Budget Number Request";
			//$smsAlertMessageSubject = "Bid On $project->project_name ({$inviterUserCompany->company})";
			$smsAlertMessageSubject = "Budget Number for $project->project_name";
		}

		//$timestamp = date("D, M j g:i A", (time()+86400)); // @todo Eventually make the link have an user_invitation_expiration_timestamp
		$timestamp = date("D, M j g:i A", time());

		/*
		if ($emailFlag) {
			$requestInitiatedBy = "$toName ($u->email)";
		} else {
			$requestInitiatedBy = "$toName ($u->mobile_phone_number)";
		}
		*/

		$systemMessage = "";
		$systemMessage2 = "";
		$alertHeadline = "";
		$alertBody = "";
		// SMS and Text Email clients
		if ($type == 'join') {
			$systemMessage = 'Please <a href="'.$url.'">Register or Sign In</a> to join '.$inviterUserCompany->company.'&#39;s '.$project->project_name.' project.';
			if ($projectCount == 1) {
				// Subject line has the project name in it
				$smsAlertMessageBody = "Register: $smsUrl";
				$alertHeadline = 'Please <a href="'.$url.'">Register or Sign In</a> to join '.$inviterUserCompany->company.'&#39;s '.$project->project_name.' project.';
			} else {
				// Generic join Fulcrum message
				$smsAlertMessageBody = "Register: $smsUrl";
				$alertHeadline = 'Please <a href="'.$url.'">Register or Sign In</a> to join Fulcrum.';
			}
/*
			$alertBody =
				PHP_EOL.
				"User Invitation Was Sent On: $timestamp PST".PHP_EOL.
				"User Invitation Was Extended By: $inviteFromName".PHP_EOL;
*/

		} elseif ($type == 'bid') {
			// Subject line has the project name in it
			$smsAlertMessageBody = "Bid: $smsUrl";
			//$alertHeadline = 'Please <a href="'.$url.'">Register or Sign In</a> to Bid on '.$inviterUserCompany->company.'&#39;s '.$project->project_name.' project.';
			$systemMessage = 'We cordially invite you to submit a bid proposal for the following trades on ' .$inviterUserCompany->company.'&#39;s '.$project->project_name. ' project.  Please see the attached bid invitation for more information regarding the project.<br><br>';
			$systemMessage2 = '
					Are you interested in bidding this project?  Let us know by clicking one of the following options.
					<br><br>
					<a href="'.$viewURL.'">
					<input type="button" value="CLICK HERE TO VIEW PLANS."/>
					</a>
					<br><br>
					
					
					<a href="'.$url.'&answer=0">
						<input type="button" value="NO. I AM NOT INTERESTED IN BIDDING."/>
					</a>
					<br><br>
					
			';
			/*<a href="'.$url.'&answer=1">
						<input type="button" value="YES. I AM INTERESTED IN BIDDING."/>
					</a>
					<br><br>
			<a href="'.$url.'&answer=2">
						<input type="button" value="NOT SURE. TAKE ME TO THE PLANS."/>
					</a>
					<br><br>*/
/*
			$alertBody =
				PHP_EOL.
				"Bid Invitation Was Sent On: $timestamp PST".PHP_EOL.
				"Bid Invitation Was Extended By: $inviteFromName".PHP_EOL;
*/
		} elseif ($type == 'budget_number') {
			// Subject line has the project name in it
			$smsAlertMessageBody = "Budget Number: $smsUrl";
			//$alertHeadline = 'Please <a href="'.$url.'">Register or Sign In</a> to Bid on '.$inviterUserCompany->company.'&#39;s '.$project->project_name.' project.';
			$systemMessage = 'We cordially invite you to submit a budget number for for the following trades on ' .$inviterUserCompany->company.'&#39;s '.$project->project_name. ' project.  Please see the attached bid invitation for more information regarding the project.<br><br>';
			$systemMessage2 = '
					Are you interested in providing a budget number this project?  Let us know by clicking one of the following options.
					<br><br>
					<a href="'.$url.'&answer=11">
						<input type="button" value="YES. I WILL PROVIDE A BUDGET NUMBER	."/>
					</a>
					<br><br>
					<a href="'.$url.'&answer=10">
						<input type="button" value="NO. I WILL NOT PROVIDE A BUDGET NUMBER."/>
					</a>
					<br><br>
					<a href="'.$url.'&answer=12">
						<input type="button" value="NOT SURE. TAKE ME TO THE PLANS."/>
					</a>
					<br><br>
					
			';
/*
			$alertBody =
				PHP_EOL.
				"Bid Invitation Was Sent On: $timestamp PST".PHP_EOL.
				"Bid Invitation Was Extended By: $inviteFromName".PHP_EOL;
*/
		}
		$htmlAlertHeadline = $alertHeadline;
		$alertMessageBody = $alertHeadline.$alertBody;

		if (!empty($formattedProjectList)) {
			$bidOrJoinBody = nl2br($formattedProjectList);
			$bidOrJoinBody .= '<br>';
		} elseif (!empty($formattedTradesList)) {
			$bidOrJoinBody = nl2br($formattedTradesList);
			$bidOrJoinBody .= '<br>';
		} else {
			$bidOrJoinBody = '';
		}

		$toName = trim($toName);
		$greetingLine = "Hi,<br><br>";
		if (isset($toName) && !empty($toName)) {
			$greetingLine = $toName.',<br><br>';
		}

// HTML Email output for Email clients that support HTML
$htmlAlertMessageBody = <<<ENDHTMLMESSAGE
$greetingLine$systemMessage
$inviteLink

$bidOrJoinBody
$systemMessage2
$customEmailMessageFromInviter
<br><br>
$inviteFromSignature
<br>
ENDHTMLMESSAGE;
		require_once('lib/common/Logo.php');
		$mail_image = Logo::logoByUserCompanyIDforemail($database,$user_company_id);

		ob_start();
		$formattedType = ucfirst($type);
		$mail_image=$mail_image;
		//$headline = 'Invitation to '.$formattedType;
		if ($type == 'bid') {
			include('templates/mail-template-bid-invitations.php');
		} else {
			include('templates/mail-template.php');
		}
		$bodyHtml = ob_get_clean();

		try {
			//$var1 = $var2;
			// Debug
			if (strstr($toEmail, "precision")) {
				throw new Exception('');
			}
			//throw new Exception('');
			if ($emailFlag) {
				$mail_log ='';
				$db = DBI::getInstance($database); 
				$queryS ="SELECT mail_log FROM transmittal_data WHERE `id` = ?
				";
				$arrValuesS = array($TransmittalId);
				$db->execute($queryS, $arrValuesS, MYSQLI_USE_RESULT);
				$row = $db->fetch();
				if(isset($row) && !empty($row)){
					$mail_log = $row['mail_log'];
				}

				try {

					//$toEmail = $email;
					$sendEmail = 'Alert@MyFulcrum.com';
					$sendName = ($fromName !=" ") ? $fromName : "Fulcrum Message";
					$mail = new Mail();
					$mail->setReturnPath($contact->email);
					//$mail->setBodyText($alertMessageBody);
					$mail->setBodyHtml($bodyHtml, 'UTF-8', Zend_Mime::MULTIPART_RELATED);
					//$mail->setBodyHtml($bodyHtml, 'UTF-8', Zend_Mime::MULTIPART_RELATED, false);
					$mail->setFrom($sendEmail, $sendName);
					$mail->addTo($toEmail, $toName);
					$mail->addHeader('Reply-To',$fromEmail);
					// To include the cc
					if($ccmail=='Y')
					{
						$mail->addCc($fromEmail,$fromName);
					}

					$mail->setSubject($alertMessageSubject);
					if ($includeAttachment) {
						foreach ($arrAttachments AS $file_manager_file_id => $null) {
							$cdnFileUrl = $arrAttachments[$file_manager_file_id]['cdnFileUrl'];
							$attachmentFileName = $arrAttachments[$file_manager_file_id]['fileName'];

							$cdnFileUrl = str_replace('http:', '', $cdnFileUrl);
							$fileContents = file_get_contents('http:' . $cdnFileUrl . '?id=76wrQhuMZizg60wWPppeHFGijhGktEXs94bs0otFuxmTK5JPk2GtviAzLfqPvM4yTJ7KeRP6fsK96InPHvimqtUGUAgt1T8bGn1C');
							$mail->createAttachment($attachmentFileName, $fileContents);

						//$file = $mail->createAttachment($fileContents);
						//$file->filename = $attachmentFileName;
						}
					}
					$mail->send();

					if($TransmittalId!=''){
						$db = DBI::getInstance($database); 
						$query ="UPDATE transmittal_data SET `mail_log`=?  WHERE `id` = ?
						";
						if($mail_log==''){
							$sValue='<tr><td>'.$toEmail.'<td><th> : Sent</th></tr>';
						}else{
							$sValue=$mail_log.'<tr><td>'.$toEmail.'<td><th> : Sent</th></tr>';
						}
						
						$arrValues = array($sValue,$TransmittalId);
						$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
						$db->free_result();
					}
					
				} catch (Exception $e) {
					if($TransmittalId!=''){
						$db = DBI::getInstance($database); 
						$query ="UPDATE transmittal_data SET `mail_log`=?  WHERE `id` = ?
						";
						if($mail_log==''){
							$sValue='<tr><td>'.$toEmail.'<td><th> : Failed</th></tr>';
						}else{
							$sValue=$mail_log.'<tr><td>'.$toEmail.'<td><th> : Failed</th></tr>';
						}
						$arrValues = array($sValue,$TransmittalId);
						$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
						$db->free_result();
					}
				}

				//To delete the img
				$config = Zend_Registry::get('config');
				$file_manager_back = $config->system->base_directory;
				$file_manager_back =$file_manager_back.'www/www.axis.com/';
				$path=$file_manager_back.$mail_image;
				unlink($path);
			}

			if ($smsFlag) {
				/**
				 * MessageGateway_Sms
				 */
				MessageGateway_Sms::sendSmsMessage($mobile_phone_number, $mobile_network_carrier_id, $smsToName, $smsFromEmail, $smsFromName, $smsAlertMessageSubject, $smsAlertMessageBody);
			}
		} catch(Exception $e) {
			// Mail/SMS failed to send
			$errorMessage = $e->getMessage();
			throw new Exception($errorMessage);
		}

		return true;
	}
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

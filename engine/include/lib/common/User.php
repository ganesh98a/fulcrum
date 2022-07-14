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
 * A "User" is a unique way to identify a given user's account.
 *
 * GUIDS:
 * 	email
 * 	mobile_phone_number
 *
 * @category   Framework
 * @package    User
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class User extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'User';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'users';

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
	 * unique index `unique_user_via_email` (`email`)
	 * unique index `unique_user_via_mobile_phone_number` (`mobile_phone_number`)
	 * unique index `unique_user_via_password_guid` (`password_guid`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_user_via_email' => array(
			'email' => 'string'
		),
		'unique_user_via_mobile_phone_number' => array(
			'mobile_phone_number' => 'string'
		),
		'unique_user_via_password_guid' => array(
			'password_guid' => 'string'
		)
	);

	public static $arrUserAttributes = array(
		'user_company_id' => '',
		'role_id' => '',
		'default_project_id' => '',
		'primary_contact_id' => '',
		'mobile_network_carrier_id' => '',
		'user_image_id' => '',
		'security_image_id' => '',

		'mobile_phone_number' => '',
		'screen_name' => '',
		'email' => '',
		//'alternate_email' => '',
		//'username' => '',

		'password_hash' => '',
		'password_guid' => '',
		'salt' => '',
		'password' => '',
		//'password_md5' => '',
		//'password_sha1' => '',
		//'password_other' => '',
		'security_phrase' => '',

		//'modified' => '',
		//'accessed' => '',
		//'created' => '',

		//'birth_date' => '',
		'alerts' => '',
		//'privacy' => '',

		'tc_accepted_flag' => '',
		'email_subscribe_flag' => '',
		'remember_me_flag' => '',
		'change_password_flag' => '',
		'disabled_flag' => '',
		'deleted_flag' => '',
		'is_archive' => '',
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
		'id' => 'user_id',

		'user_company_id' => 'user_company_id',
		'role_id' => 'role_id',
		'default_project_id' => 'default_project_id',
		'primary_contact_id' => 'primary_contact_id',
		'mobile_network_carrier_id' => 'mobile_network_carrier_id',
		'user_image_id' => 'user_image_id',
		'security_image_id' => 'security_image_id',
		'html_template_theme_id' => 'html_template_theme_id',

		'mobile_phone_number' => 'mobile_phone_number',
		'screen_name' => 'screen_name',
		'email' => 'email',

		// Need password for register user case
		'password' => 'password',
		'password_hash' => 'password_hash',
		'password_guid' => 'password_guid',
		//'salt' => 'salt',
		'security_phrase' => 'security_phrase',
		'modified' => 'modified',
		'accessed' => 'accessed',
		'created' => 'created',
		'alerts' => 'alerts',
		'tc_accepted_flag' => 'tc_accepted_flag',
		'email_subscribe_flag' => 'email_subscribe_flag',
		'remember_me_flag' => 'remember_me_flag',
		'change_password_flag' => 'change_password_flag',
		'disabled_flag' => 'disabled_flag',
		'deleted_flag' => 'deleted_flag',
		'is_archive' => 'is_archive'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $user_id;

	public $user_company_id;
	public $role_id;
	public $default_project_id;
	public $primary_contact_id;
	public $mobile_network_carrier_id;
	public $user_image_id;
	public $security_image_id;
	public $html_template_theme_id;

	public $mobile_phone_number;
	public $screen_name;
	public $email;
	public $password_hash;
	public $password_guid;
	//public $salt;
	public $password;
	public $security_phrase;
	public $modified;
	public $accessed;
	public $created;
	public $alerts;
	public $tc_accepted_flag;
	public $email_subscribe_flag;
	public $remember_me_flag;
	public $change_password_flag;
	public $disabled_flag;
	public $deleted_flag;
	public $is_archive;

	// Other Properties
	//protected $_otherPropertyHere;
	public $currentlySelectedProjectUserCompanyId;
	public $currentlySelectedProjectId;
	public $currentlySelectedProjectName;
	public $currentlyActiveContactId;
	public $currentlyActiveTemplateTheme;
	public $newRecordFlag = false;

	/**
	 * Session-based salt.
	 *
	 * @var string
	 */
	public $sessionSalt;

	// Other Properties
	protected $_primaryContactCompany;
	protected $_primaryContactCompanyOffice;
	protected $_primaryContactAddress;
	protected $_officeList;
	protected $_phoneNumberList;
	protected $arrOwnedProjects;
	protected $arrGuestProjects;
	protected $userRole;

	// HTML ENTITY ENCODED ORM string properties
	public $escaped_mobile_phone_number;
	public $escaped_screen_name;
	public $escaped_email;
	public $escaped_password_guid;
	public $escaped_security_phrase;

	// HTML ENTITY ENCODED NL2BR ORM string properties
	public $escaped_mobile_phone_number_nl2br;
	public $escaped_screen_name_nl2br;
	public $escaped_email_nl2br;
	public $escaped_password_guid_nl2br;
	public $escaped_security_phrase_nl2br;

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)
	protected static $_arrUsersByUserCompanyId;
	protected static $_arrUsersByRoleId;
	protected static $_arrUsersByDefaultProjectId;
	protected static $_arrUsersByPrimaryContactId;
	protected static $_arrUsersByMobileNetworkCarrierId;
	protected static $_arrUsersBySecurityImageId;
	protected static $_arrUsersByHtmlTemplateThemeId;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllUsers;

	// Foreign Key Objects
	private $_userCompany;
	private $_role;
	private $_defaultProject;
	private $_primaryContact;
	private $_mobileNetworkCarrier;
	private $_securityImage;
	private $_htmlTemplateTheme;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='users')
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

	public function getRole()
	{
		if (isset($this->_role)) {
			return $this->_role;
		} else {
			return null;
		}
	}

	public function setRole($role)
	{
		$this->_role = $role;
	}

	public function getDefaultProject()
	{
		if (isset($this->_defaultProject)) {
			return $this->_defaultProject;
		} else {
			return null;
		}
	}

	public function setDefaultProject($defaultProject)
	{
		$this->_defaultProject = $defaultProject;
	}

	public function getPrimaryContact()
	{
		if (isset($this->_primaryContact)) {
			return $this->_primaryContact;
		} else {
			return null;
		}
	}

	public function setPrimaryContact($primaryContact)
	{
		$this->_primaryContact = $primaryContact;
	}

	public function getMobileNetworkCarrier()
	{
		if (isset($this->_mobileNetworkCarrier)) {
			return $this->_mobileNetworkCarrier;
		} else {
			return null;
		}
	}

	public function setMobileNetworkCarrier($mobileNetworkCarrier)
	{
		$this->_mobileNetworkCarrier = $mobileNetworkCarrier;
	}

	public function getSecurityImage()
	{
		if (isset($this->_securityImage)) {
			return $this->_securityImage;
		} else {
			return null;
		}
	}

	public function setSecurityImage($securityImage)
	{
		$this->_securityImage = $securityImage;
	}

	public function getHtmlTemplateTheme()
	{
		if (isset($this->_htmlTemplateTheme)) {
			return $this->_htmlTemplateTheme;
		} else {
			return null;
		}
	}

	public function setHtmlTemplateTheme($htmlTemplateTheme)
	{
		$this->_htmlTemplateTheme = $htmlTemplateTheme;
	}

	public function getPrimaryContactCompany()
	{
		return $this->_primaryContactCompany;
	}

	public function setPrimaryContactCompany($primaryContactCompany)
	{
		$this->_primaryContactCompany = $primaryContactCompany;
	}

	public function getPrimaryContactCompanyOffice()
	{
		return $this->_primaryContactCompanyOffice;
	}

	public function setPrimaryContactCompanyOffice($primaryContactCompanyOffice)
	{
		$this->_primaryContactCompanyOffice = $primaryContactCompanyOffice;
	}

	public function getPrimaryContactAddress()
	{
		return $this->_primaryContactAddress;
	}

	public function setPrimaryContactAddress($primaryContactAddress)
	{
		$this->_primaryContactAddress = $primaryContactAddress;
	}

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)
	public static function getArrUsersByUserCompanyId()
	{
		if (isset(self::$_arrUsersByUserCompanyId)) {
			return self::$_arrUsersByUserCompanyId;
		} else {
			return null;
		}
	}

	public static function setArrUsersByUserCompanyId($arrUsersByUserCompanyId)
	{
		self::$_arrUsersByUserCompanyId = $arrUsersByUserCompanyId;
	}

	public static function getArrUsersByRoleId()
	{
		if (isset(self::$_arrUsersByRoleId)) {
			return self::$_arrUsersByRoleId;
		} else {
			return null;
		}
	}

	public static function setArrUsersByRoleId($arrUsersByRoleId)
	{
		self::$_arrUsersByRoleId = $arrUsersByRoleId;
	}

	public static function getArrUsersByDefaultProjectId()
	{
		if (isset(self::$_arrUsersByDefaultProjectId)) {
			return self::$_arrUsersByDefaultProjectId;
		} else {
			return null;
		}
	}

	public static function setArrUsersByDefaultProjectId($arrUsersByDefaultProjectId)
	{
		self::$_arrUsersByDefaultProjectId = $arrUsersByDefaultProjectId;
	}

	public static function getArrUsersByPrimaryContactId()
	{
		if (isset(self::$_arrUsersByPrimaryContactId)) {
			return self::$_arrUsersByPrimaryContactId;
		} else {
			return null;
		}
	}

	public static function setArrUsersByPrimaryContactId($arrUsersByPrimaryContactId)
	{
		self::$_arrUsersByPrimaryContactId = $arrUsersByPrimaryContactId;
	}

	public static function getArrUsersByMobileNetworkCarrierId()
	{
		if (isset(self::$_arrUsersByMobileNetworkCarrierId)) {
			return self::$_arrUsersByMobileNetworkCarrierId;
		} else {
			return null;
		}
	}

	public static function setArrUsersByMobileNetworkCarrierId($arrUsersByMobileNetworkCarrierId)
	{
		self::$_arrUsersByMobileNetworkCarrierId = $arrUsersByMobileNetworkCarrierId;
	}

	public static function getArrUsersBySecurityImageId()
	{
		if (isset(self::$_arrUsersBySecurityImageId)) {
			return self::$_arrUsersBySecurityImageId;
		} else {
			return null;
		}
	}

	public static function setArrUsersBySecurityImageId($arrUsersBySecurityImageId)
	{
		self::$_arrUsersBySecurityImageId = $arrUsersBySecurityImageId;
	}

	public static function getArrUsersByHtmlTemplateThemeId()
	{
		if (isset(self::$_arrUsersByHtmlTemplateThemeId)) {
			return self::$_arrUsersByHtmlTemplateThemeId;
		} else {
			return null;
		}
	}

	public static function setArrUsersByHtmlTemplateThemeId($arrUsersByHtmlTemplateThemeId)
	{
		self::$_arrUsersByHtmlTemplateThemeId = $arrUsersByHtmlTemplateThemeId;
	}

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllUsers()
	{
		if (isset(self::$_arrAllUsers)) {
			return self::$_arrAllUsers;
		} else {
			return null;
		}
	}

	public static function setArrAllUsers($arrAllUsers)
	{
		self::$_arrAllUsers = $arrAllUsers;
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
	 * @param int $user_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findById($database, $user_id,$table='users', $module='User')
	{
		$user = parent::findById($database, $user_id,$table, $module);

		return $user;
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Similar to FindById, but with SQL as starter code for more complex joins.
	 *
	 * @param string $database
	 * @param int $user_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findUserByIdExtended($database, $user_id)
	{
		$user_id = (int) $user_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */
		/*default change for all to access axis html template
		INNER JOIN `html_template_themes` u_fk_htt ON u_fk_htt.`id` = u.`html_template_theme_id` // 2
		*/
		$query =
"
SELECT

	u_fk_uc.`id` AS 'u_fk_uc__user_company_id',
	u_fk_uc.`company` AS 'u_fk_uc__company',
	u_fk_uc.`primary_phone_number` AS 'u_fk_uc__primary_phone_number',
	u_fk_uc.`employer_identification_number` AS 'u_fk_uc__employer_identification_number',
	u_fk_uc.`construction_license_number` AS 'u_fk_uc__construction_license_number',
	u_fk_uc.`construction_license_number_expiration_date` AS 'u_fk_uc__construction_license_number_expiration_date',
	u_fk_uc.`paying_customer_flag` AS 'u_fk_uc__paying_customer_flag',

	u_fk_r.`id` AS 'u_fk_r__role_id',
	u_fk_r.`role` AS 'u_fk_r__role',
	u_fk_r.`role_description` AS 'u_fk_r__role_description',
	u_fk_r.`project_specific_flag` AS 'u_fk_r__project_specific_flag',
	u_fk_r.`sort_order` AS 'u_fk_r__sort_order',

	u_fk_default_p.`id` AS 'u_fk_default_p__project_id',
	u_fk_default_p.`project_type_id` AS 'u_fk_default_p__project_type_id',
	u_fk_default_p.`user_company_id` AS 'u_fk_default_p__user_company_id',
	u_fk_default_p.`user_custom_project_id` AS 'u_fk_default_p__user_custom_project_id',
	u_fk_default_p.`project_name` AS 'u_fk_default_p__project_name',
	u_fk_default_p.`project_owner_name` AS 'u_fk_default_p__project_owner_name',
	u_fk_default_p.`latitude` AS 'u_fk_default_p__latitude',
	u_fk_default_p.`longitude` AS 'u_fk_default_p__longitude',
	u_fk_default_p.`address_line_1` AS 'u_fk_default_p__address_line_1',
	u_fk_default_p.`address_line_2` AS 'u_fk_default_p__address_line_2',
	u_fk_default_p.`address_line_3` AS 'u_fk_default_p__address_line_3',
	u_fk_default_p.`address_line_4` AS 'u_fk_default_p__address_line_4',
	u_fk_default_p.`address_city` AS 'u_fk_default_p__address_city',
	u_fk_default_p.`address_county` AS 'u_fk_default_p__address_county',
	u_fk_default_p.`address_state_or_region` AS 'u_fk_default_p__address_state_or_region',
	u_fk_default_p.`address_postal_code` AS 'u_fk_default_p__address_postal_code',
	u_fk_default_p.`address_postal_code_extension` AS 'u_fk_default_p__address_postal_code_extension',
	u_fk_default_p.`address_country` AS 'u_fk_default_p__address_country',
	u_fk_default_p.`building_count` AS 'u_fk_default_p__building_count',
	u_fk_default_p.`unit_count` AS 'u_fk_default_p__unit_count',
	u_fk_default_p.`gross_square_footage` AS 'u_fk_default_p__gross_square_footage',
	u_fk_default_p.`net_rentable_square_footage` AS 'u_fk_default_p__net_rentable_square_footage',
	u_fk_default_p.`is_active_flag` AS 'u_fk_default_p__is_active_flag',
	u_fk_default_p.`public_plans_flag` AS 'u_fk_default_p__public_plans_flag',
	u_fk_default_p.`prevailing_wage_flag` AS 'u_fk_default_p__prevailing_wage_flag',
	u_fk_default_p.`city_business_license_required_flag` AS 'u_fk_default_p__city_business_license_required_flag',
	u_fk_default_p.`is_internal_flag` AS 'u_fk_default_p__is_internal_flag',
	u_fk_default_p.`project_contract_date` AS 'u_fk_default_p__project_contract_date',
	u_fk_default_p.`project_start_date` AS 'u_fk_default_p__project_start_date',
	u_fk_default_p.`project_completed_date` AS 'u_fk_default_p__project_completed_date',
	u_fk_default_p.`sort_order` AS 'u_fk_default_p__sort_order',

	u_fk_primary_c.`id` AS 'u_fk_primary_c__contact_id',
	u_fk_primary_c.`user_company_id` AS 'u_fk_primary_c__user_company_id',
	u_fk_primary_c.`user_id` AS 'u_fk_primary_c__user_id',
	u_fk_primary_c.`contact_company_id` AS 'u_fk_primary_c__contact_company_id',
	u_fk_primary_c.`email` AS 'u_fk_primary_c__email',
	u_fk_primary_c.`name_prefix` AS 'u_fk_primary_c__name_prefix',
	u_fk_primary_c.`first_name` AS 'u_fk_primary_c__first_name',
	u_fk_primary_c.`additional_name` AS 'u_fk_primary_c__additional_name',
	u_fk_primary_c.`middle_name` AS 'u_fk_primary_c__middle_name',
	u_fk_primary_c.`last_name` AS 'u_fk_primary_c__last_name',
	u_fk_primary_c.`name_suffix` AS 'u_fk_primary_c__name_suffix',
	u_fk_primary_c.`title` AS 'u_fk_primary_c__title',
	u_fk_primary_c.`vendor_flag` AS 'u_fk_primary_c__vendor_flag',

	u_fk_mnc.`id` AS 'u_fk_mnc__mobile_network_carrier_id',
	u_fk_mnc.`carrier` AS 'u_fk_mnc__carrier',
	u_fk_mnc.`carrier_display_name` AS 'u_fk_mnc__carrier_display_name',
	u_fk_mnc.`sms_email_gateway` AS 'u_fk_mnc__sms_email_gateway',
	u_fk_mnc.`country` AS 'u_fk_mnc__country',

	u_fk_si.`id` AS 'u_fk_si__security_image_id',
	u_fk_si.`src` AS 'u_fk_si__src',
	u_fk_si.`security_image` AS 'u_fk_si__security_image',
	u_fk_si.`width` AS 'u_fk_si__width',
	u_fk_si.`height` AS 'u_fk_si__height',
	u_fk_si.`size` AS 'u_fk_si__size',

	u_fk_htt.`id` AS 'u_fk_htt__html_template_theme_id',
	u_fk_htt.`user_company_id` AS 'u_fk_htt__user_company_id',
	u_fk_htt.`html_template_theme_name` AS 'u_fk_htt__html_template_theme_name',

	u_fk_primary_c__fk_cc.`id` AS 'u_fk_primary_c__fk_cc__contact_company_id',
	u_fk_primary_c__fk_cc.`user_user_company_id` AS 'u_fk_primary_c__fk_cc__user_user_company_id',
	u_fk_primary_c__fk_cc.`contact_user_company_id` AS 'u_fk_primary_c__fk_cc__contact_user_company_id',
	u_fk_primary_c__fk_cc.`company` AS 'u_fk_primary_c__fk_cc__company',
	u_fk_primary_c__fk_cc.`primary_phone_number` AS 'u_fk_primary_c__fk_cc__primary_phone_number',
	u_fk_primary_c__fk_cc.`employer_identification_number` AS 'u_fk_primary_c__fk_cc__employer_identification_number',
	u_fk_primary_c__fk_cc.`construction_license_number` AS 'u_fk_primary_c__fk_cc__construction_license_number',
	u_fk_primary_c__fk_cc.`construction_license_number_expiration_date` AS 'u_fk_primary_c__fk_cc__construction_license_number_expiration_date',
	u_fk_primary_c__fk_cc.`vendor_flag` AS 'u_fk_primary_c__fk_cc__vendor_flag',

	primary_c__cco.`id` AS 'primary_c__cco__contact_company_office_id',
	primary_c__cco.`contact_company_id` AS 'primary_c__cco__contact_company_id',
	primary_c__cco.`office_nickname` AS 'primary_c__cco__office_nickname',
	primary_c__cco.`address_line_1` AS 'primary_c__cco__address_line_1',
	primary_c__cco.`address_line_2` AS 'primary_c__cco__address_line_2',
	primary_c__cco.`address_line_3` AS 'primary_c__cco__address_line_3',
	primary_c__cco.`address_line_4` AS 'primary_c__cco__address_line_4',
	primary_c__cco.`address_city` AS 'primary_c__cco__address_city',
	primary_c__cco.`address_county` AS 'primary_c__cco__address_county',
	primary_c__cco.`address_state_or_region` AS 'primary_c__cco__address_state_or_region',
	primary_c__cco.`address_postal_code` AS 'primary_c__cco__address_postal_code',
	primary_c__cco.`address_postal_code_extension` AS 'primary_c__cco__address_postal_code_extension',
	primary_c__cco.`address_country` AS 'primary_c__cco__address_country',
	primary_c__cco.`head_quarters_flag` AS 'primary_c__cco__head_quarters_flag',
	primary_c__cco.`address_validated_by_user_flag` AS 'primary_c__cco__address_validated_by_user_flag',
	primary_c__cco.`address_validated_by_web_service_flag` AS 'primary_c__cco__address_validated_by_web_service_flag',
	primary_c__cco.`address_validation_by_web_service_error_flag` AS 'primary_c__cco__address_validation_by_web_service_error_flag',

	primary_c__ca.`id` AS 'primary_c__ca__contact_address_id',
	primary_c__ca.`contact_id` AS 'primary_c__ca__contact_id',
	primary_c__ca.`address_nickname` AS 'primary_c__ca__address_nickname',
	primary_c__ca.`address_line_1` AS 'primary_c__ca__address_line_1',
	primary_c__ca.`address_line_2` AS 'primary_c__ca__address_line_2',
	primary_c__ca.`address_line_3` AS 'primary_c__ca__address_line_3',
	primary_c__ca.`address_line_4` AS 'primary_c__ca__address_line_4',
	primary_c__ca.`address_city` AS 'primary_c__ca__address_city',
	primary_c__ca.`address_county` AS 'primary_c__ca__address_county',
	primary_c__ca.`address_state_or_region` AS 'primary_c__ca__address_state_or_region',
	primary_c__ca.`address_postal_code` AS 'primary_c__ca__address_postal_code',
	primary_c__ca.`address_postal_code_extension` AS 'primary_c__ca__address_postal_code_extension',
	primary_c__ca.`address_country` AS 'primary_c__ca__address_country',
	primary_c__ca.`default_address_flag` AS 'primary_c__ca__default_address_flag',
	primary_c__ca.`address_validated_by_user_flag` AS 'primary_c__ca__address_validated_by_user_flag',
	primary_c__ca.`address_validated_by_web_service_flag` AS 'primary_c__ca__address_validated_by_web_service_flag',
	primary_c__ca.`address_validation_by_web_service_error_flag` AS 'primary_c__ca__address_validation_by_web_service_error_flag',

	u.*

FROM `users` u
	INNER JOIN `user_companies` u_fk_uc ON u.`user_company_id` = u_fk_uc.`id`
	INNER JOIN `roles` u_fk_r ON u.`role_id` = u_fk_r.`id`
	INNER JOIN `projects` u_fk_default_p ON u.`default_project_id` = u_fk_default_p.`id`
	INNER JOIN `contacts` u_fk_primary_c ON u.`primary_contact_id` = u_fk_primary_c.`id`
	INNER JOIN `mobile_network_carriers` u_fk_mnc ON u.`mobile_network_carrier_id` = u_fk_mnc.`id`
	INNER JOIN `security_images` u_fk_si ON u.`security_image_id` = u_fk_si.`id`
	INNER JOIN `html_template_themes` u_fk_htt ON u_fk_htt.`id` = 2
	INNER JOIN `contact_companies` u_fk_primary_c__fk_cc ON u_fk_primary_c.`contact_company_id` = u_fk_primary_c__fk_cc.`id`
	LEFT OUTER JOIN `contact_company_offices` primary_c__cco ON (u_fk_primary_c__fk_cc.`id` = primary_c__cco.contact_company_id AND primary_c__cco.head_quarters_flag = 'Y')
	LEFT OUTER JOIN contact_addresses primary_c__ca ON u_fk_primary_c.`id` = primary_c__ca.contact_id

WHERE u.`id` = ?
";
		$arrValues = array($user_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$user_id = $row['id'];
			$user = self::instantiateOrm($database, 'User', $row, null, $user_id);
			/* @var $user User */
			$user->convertPropertiesToData();

			if (isset($row['user_company_id'])) {
				$user_company_id = $row['user_company_id'];
				$row['u_fk_uc__id'] = $user_company_id;
				$userCompany = self::instantiateOrm($database, 'UserCompany', $row, null, $user_company_id, 'u_fk_uc__');
				/* @var $userCompany UserCompany */
				$userCompany->convertPropertiesToData();
			} else {
				$userCompany = false;
			}
			$user->setUserCompany($userCompany);

			if (isset($row['role_id'])) {
				$role_id = $row['role_id'];
				$row['u_fk_r__id'] = $role_id;
				$role = self::instantiateOrm($database, 'Role', $row, null, $role_id, 'u_fk_r__');
				/* @var $role Role */
				$role->convertPropertiesToData();
			} else {
				$role = false;
			}
			$user->setRole($role);

			if (isset($row['default_project_id'])) {
				$default_project_id = $row['default_project_id'];
				$row['u_fk_default_p__id'] = $default_project_id;
				$defaultProject = self::instantiateOrm($database, 'Project', $row, null, $default_project_id, 'u_fk_default_p__');
				/* @var $defaultProject Project */
				$defaultProject->convertPropertiesToData();
			} else {
				$defaultProject = false;
			}
			$user->setDefaultProject($defaultProject);

			if (isset($row['primary_contact_id'])) {
				$primary_contact_id = $row['primary_contact_id'];
				$row['u_fk_primary_c__id'] = $primary_contact_id;
				$primaryContact = self::instantiateOrm($database, 'Contact', $row, null, $primary_contact_id, 'u_fk_primary_c__');
				/* @var $primaryContact Contact */
				$primaryContact->convertPropertiesToData();
			} else {
				$primaryContact = false;
			}
			$user->setPrimaryContact($primaryContact);

			if (isset($row['mobile_network_carrier_id'])) {
				$mobile_network_carrier_id = $row['mobile_network_carrier_id'];
				$row['u_fk_mnc__id'] = $mobile_network_carrier_id;
				$mobileNetworkCarrier = self::instantiateOrm($database, 'MobileNetworkCarrier', $row, null, $mobile_network_carrier_id, 'u_fk_mnc__');
				/* @var $mobileNetworkCarrier MobileNetworkCarrier */
				$mobileNetworkCarrier->convertPropertiesToData();
			} else {
				$mobileNetworkCarrier = false;
			}
			$user->setMobileNetworkCarrier($mobileNetworkCarrier);

			//if (isset($row['security_image_id'])) {
			//	$security_image_id = $row['security_image_id'];
			//	$row['u_fk_si__id'] = $security_image_id;
			//	$securityImage = self::instantiateOrm($database, 'SecurityImage', $row, null, $security_image_id, 'u_fk_si__');
			//	/* @var $securityImage SecurityImage */
			//	$securityImage->convertPropertiesToData();
			//} else {
			//	$securityImage = false;
			//}
			//$user->setSecurityImage($securityImage);

			//if (isset($row['html_template_theme_id'])) {
			//	$html_template_theme_id = $row['html_template_theme_id'];
			//	$row['u_fk_htt__id'] = $html_template_theme_id;
			//	$htmlTemplateTheme = self::instantiateOrm($database, 'HtmlTemplateTheme', $row, null, $html_template_theme_id, 'u_fk_htt__');
			//	/* @var $htmlTemplateTheme HtmlTemplateTheme */
			//	$htmlTemplateTheme->convertPropertiesToData();
			//} else {
			//	$htmlTemplateTheme = false;
			//}
			//$user->setHtmlTemplateTheme($htmlTemplateTheme);

			if (isset($row['u_fk_primary_c__fk_cc__contact_company_id'])) {
				$contact_company_id = $row['u_fk_primary_c__fk_cc__contact_company_id'];
				$row['u_fk_primary_c__fk_cc__id'] = $contact_company_id;
				$primaryContactCompany = self::instantiateOrm($database, 'ContactCompany', $row, null, $contact_company_id, 'u_fk_primary_c__fk_cc__');
				/* @var $primaryContactCompany ContactCompany */
				$primaryContactCompany->convertPropertiesToData();
			} else {
				$primaryContactCompany = false;
			}
			$user->setPrimaryContactCompany($primaryContactCompany);

			if (isset($row['primary_c__cco__contact_company_office_id'])) {
				$contact_company_office_id = $row['primary_c__cco__contact_company_office_id'];
				$row['primary_c__cco__id'] = $contact_company_office_id;
				$primaryContactCompanyOffice = self::instantiateOrm($database, 'ContactCompanyOffice', $row, null, $contact_company_office_id, 'primary_c__cco__');
				/* @var $primaryContactCompanyOffice ContactCompanyOffice */
				$primaryContactCompanyOffice->convertPropertiesToData();
			} else {
				$primaryContactCompanyOffice = false;
			}
			$user->setPrimaryContactCompanyOffice($primaryContactCompanyOffice);

			if (isset($row['primary_c__ca__contact_address_id'])) {
				$contact_address_id = $row['primary_c__ca__contact_address_id'];
				$row['primary_c__ca__id'] = $contact_address_id;
				$primaryContactAddress = self::instantiateOrm($database, 'ContactAddress', $row, null, $contact_address_id, 'primary_c__ca__');
				/* @var $primaryContactAddress ContactAddress */
				$primaryContactAddress->convertPropertiesToData();
			} else {
				$primaryContactAddress = false;
			}
			$user->setPrimaryContactAddress($primaryContactAddress);

			return $user;
		} else {
			return false;
		}
	}

	// Finders: Find By Unique Index
	/**
	 * Find by unique index `unique_user_via_email` (`email`).
	 *
	 * @param string $database
	 * @param string $email
	 * @return mixed (single ORM object | false)
	 */
	public static function findByEmail($database, $email)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	u.*

FROM `users` u
WHERE u.`email` = ?
";
		$arrValues = array($email);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if ($row && !empty($row)) {
			$user_id = $row['id'];
			$user = self::instantiateOrm($database, 'User', $row, null, $user_id);
			/* @var $user User */
			return $user;
		} else {
			return false;
		}
	}

	/**
	 * Find by unique index `unique_user_via_mobile_phone_number` (`mobile_phone_number`).
	 *
	 * @param string $database
	 * @param string $mobile_phone_number
	 * @return mixed (single ORM object | false)
	 */
	public static function findByMobilePhoneNumber($database, $mobile_phone_number)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	u.*

FROM `users` u
WHERE u.`mobile_phone_number` = ?
";
		$arrValues = array($mobile_phone_number);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if ($row && !empty($row)) {
			$user_id = $row['id'];
			$user = self::instantiateOrm($database, 'User', $row, null, $user_id);
			/* @var $user User */
			return $user;
		} else {
			return false;
		}
	}

	/**
	 * Find by unique index `unique_user_via_password_guid` (`password_guid`).
	 *
	 * @param string $database
	 * @param string $password_guid
	 * @return mixed (single ORM object | false)
	 */
	public static function findByPasswordGuid($database, $password_guid)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	u.*

FROM `users` u
WHERE u.`password_guid` = ?
";
		$arrValues = array($password_guid);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if ($row && !empty($row)) {
			$user_id = $row['id'];
			$user = self::instantiateOrm($database, 'User', $row, null, $user_id);
			/* @var $user User */
			return $user;
		} else {
			return false;
		}
	}

	// Loaders: Load By pk List (list of auto int ids or other non auto int pk list)
	/**
	 * Load zero or more records by an id list (array of auto int primary keys).
	 *
	 * @param string $database
	 * @param array $arrUserIds
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadUsersByArrUserIds($database, $arrUserIds, Input $options=null)
	{
		if (empty($arrUserIds)) {
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
		// ORDER BY `id` ASC, `user_company_id` ASC, `role_id` ASC, `default_project_id` ASC, `primary_contact_id` ASC, `mobile_network_carrier_id` ASC, `user_image_id` ASC, `security_image_id` ASC, `html_template_theme_id` ASC, `mobile_phone_number` ASC, `screen_name` ASC, `email` ASC, `password_hash` ASC, `password_guid` ASC, `security_phrase` ASC, `modified` ASC, `accessed` ASC, `created` ASC, `alerts` ASC, `tc_accepted_flag` ASC, `email_subscribe_flag` ASC, `remember_me_flag` ASC, `change_password_flag` ASC, `disabled_flag` ASC, `deleted_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpUser = new User($database);
			$sqlOrderByColumns = $tmpUser->constructSqlOrderByColumns($arrOrderByAttributes);

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

		foreach ($arrUserIds as $k => $user_id) {
			$user_id = (int) $user_id;
			$arrUserIds[$k] = $db->escape($user_id);
		}
		$csvUserIds = join(',', $arrUserIds);

		$query =
"
SELECT

	u.*

FROM `users` u
WHERE u.`id` IN ($csvUserIds){$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		$arrUsersByCsvUserIds = array();
		while ($row = $db->fetch()) {
			$user_id = $row['id'];
			$user = self::instantiateOrm($database, 'User', $row, null, $user_id);
			/* @var $user User */
			$user->convertPropertiesToData();

			$arrUsersByCsvUserIds[$user_id] = $user;
		}

		$db->free_result();

		return $arrUsersByCsvUserIds;
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `users_fk_uc` foreign key (`user_company_id`) references `user_companies` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $user_company_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadUsersByUserCompanyId($database, $user_company_id, Input $options=null)
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
			self::$_arrUsersByUserCompanyId = null;
		}

		$arrUsersByUserCompanyId = self::$_arrUsersByUserCompanyId;
		if (isset($arrUsersByUserCompanyId) && !empty($arrUsersByUserCompanyId)) {
			return $arrUsersByUserCompanyId;
		}

		$user_company_id = (int) $user_company_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `user_company_id` ASC, `role_id` ASC, `default_project_id` ASC, `primary_contact_id` ASC, `mobile_network_carrier_id` ASC, `user_image_id` ASC, `security_image_id` ASC, `html_template_theme_id` ASC, `mobile_phone_number` ASC, `screen_name` ASC, `email` ASC, `password_hash` ASC, `password_guid` ASC, `security_phrase` ASC, `modified` ASC, `accessed` ASC, `created` ASC, `alerts` ASC, `tc_accepted_flag` ASC, `email_subscribe_flag` ASC, `remember_me_flag` ASC, `change_password_flag` ASC, `disabled_flag` ASC, `deleted_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpUser = new User($database);
			$sqlOrderByColumns = $tmpUser->constructSqlOrderByColumns($arrOrderByAttributes);

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
	u.*

FROM `users` u
WHERE u.`user_company_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `user_company_id` ASC, `role_id` ASC, `default_project_id` ASC, `primary_contact_id` ASC, `mobile_network_carrier_id` ASC, `user_image_id` ASC, `security_image_id` ASC, `html_template_theme_id` ASC, `mobile_phone_number` ASC, `screen_name` ASC, `email` ASC, `password_hash` ASC, `password_guid` ASC, `security_phrase` ASC, `modified` ASC, `accessed` ASC, `created` ASC, `alerts` ASC, `tc_accepted_flag` ASC, `email_subscribe_flag` ASC, `remember_me_flag` ASC, `change_password_flag` ASC, `disabled_flag` ASC, `deleted_flag` ASC
		$arrValues = array($user_company_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrUsersByUserCompanyId = array();
		while ($row = $db->fetch()) {
			$user_id = $row['id'];
			$user = self::instantiateOrm($database, 'User', $row, null, $user_id);
			/* @var $user User */
			$arrUsersByUserCompanyId[$user_id] = $user;
		}

		$db->free_result();

		self::$_arrUsersByUserCompanyId = $arrUsersByUserCompanyId;

		return $arrUsersByUserCompanyId;
	}

	/**
	 * Load by constraint `users_fk_r` foreign key (`role_id`) references `roles` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $role_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadUsersByRoleId($database, $role_id, Input $options=null)
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
			self::$_arrUsersByRoleId = null;
		}

		$arrUsersByRoleId = self::$_arrUsersByRoleId;
		if (isset($arrUsersByRoleId) && !empty($arrUsersByRoleId)) {
			return $arrUsersByRoleId;
		}

		$role_id = (int) $role_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `user_company_id` ASC, `role_id` ASC, `default_project_id` ASC, `primary_contact_id` ASC, `mobile_network_carrier_id` ASC, `user_image_id` ASC, `security_image_id` ASC, `html_template_theme_id` ASC, `mobile_phone_number` ASC, `screen_name` ASC, `email` ASC, `password_hash` ASC, `password_guid` ASC, `security_phrase` ASC, `modified` ASC, `accessed` ASC, `created` ASC, `alerts` ASC, `tc_accepted_flag` ASC, `email_subscribe_flag` ASC, `remember_me_flag` ASC, `change_password_flag` ASC, `disabled_flag` ASC, `deleted_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpUser = new User($database);
			$sqlOrderByColumns = $tmpUser->constructSqlOrderByColumns($arrOrderByAttributes);

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
	u.*

FROM `users` u
WHERE u.`role_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `user_company_id` ASC, `role_id` ASC, `default_project_id` ASC, `primary_contact_id` ASC, `mobile_network_carrier_id` ASC, `user_image_id` ASC, `security_image_id` ASC, `html_template_theme_id` ASC, `mobile_phone_number` ASC, `screen_name` ASC, `email` ASC, `password_hash` ASC, `password_guid` ASC, `security_phrase` ASC, `modified` ASC, `accessed` ASC, `created` ASC, `alerts` ASC, `tc_accepted_flag` ASC, `email_subscribe_flag` ASC, `remember_me_flag` ASC, `change_password_flag` ASC, `disabled_flag` ASC, `deleted_flag` ASC
		$arrValues = array($role_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrUsersByRoleId = array();
		while ($row = $db->fetch()) {
			$user_id = $row['id'];
			$user = self::instantiateOrm($database, 'User', $row, null, $user_id);
			/* @var $user User */
			$arrUsersByRoleId[$user_id] = $user;
		}

		$db->free_result();

		self::$_arrUsersByRoleId = $arrUsersByRoleId;

		return $arrUsersByRoleId;
	}

	/**
	 * Load by constraint `users_fk_default_p` foreign key (`default_project_id`) references `projects` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $default_project_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadUsersByDefaultProjectId($database, $default_project_id, Input $options=null)
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
			self::$_arrUsersByDefaultProjectId = null;
		}

		$arrUsersByDefaultProjectId = self::$_arrUsersByDefaultProjectId;
		if (isset($arrUsersByDefaultProjectId) && !empty($arrUsersByDefaultProjectId)) {
			return $arrUsersByDefaultProjectId;
		}

		$default_project_id = (int) $default_project_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `user_company_id` ASC, `role_id` ASC, `default_project_id` ASC, `primary_contact_id` ASC, `mobile_network_carrier_id` ASC, `user_image_id` ASC, `security_image_id` ASC, `html_template_theme_id` ASC, `mobile_phone_number` ASC, `screen_name` ASC, `email` ASC, `password_hash` ASC, `password_guid` ASC, `security_phrase` ASC, `modified` ASC, `accessed` ASC, `created` ASC, `alerts` ASC, `tc_accepted_flag` ASC, `email_subscribe_flag` ASC, `remember_me_flag` ASC, `change_password_flag` ASC, `disabled_flag` ASC, `deleted_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpUser = new User($database);
			$sqlOrderByColumns = $tmpUser->constructSqlOrderByColumns($arrOrderByAttributes);

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
	u.*

FROM `users` u
WHERE u.`default_project_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `user_company_id` ASC, `role_id` ASC, `default_project_id` ASC, `primary_contact_id` ASC, `mobile_network_carrier_id` ASC, `user_image_id` ASC, `security_image_id` ASC, `html_template_theme_id` ASC, `mobile_phone_number` ASC, `screen_name` ASC, `email` ASC, `password_hash` ASC, `password_guid` ASC, `security_phrase` ASC, `modified` ASC, `accessed` ASC, `created` ASC, `alerts` ASC, `tc_accepted_flag` ASC, `email_subscribe_flag` ASC, `remember_me_flag` ASC, `change_password_flag` ASC, `disabled_flag` ASC, `deleted_flag` ASC
		$arrValues = array($default_project_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrUsersByDefaultProjectId = array();
		while ($row = $db->fetch()) {
			$user_id = $row['id'];
			$user = self::instantiateOrm($database, 'User', $row, null, $user_id);
			/* @var $user User */
			$arrUsersByDefaultProjectId[$user_id] = $user;
		}

		$db->free_result();

		self::$_arrUsersByDefaultProjectId = $arrUsersByDefaultProjectId;

		return $arrUsersByDefaultProjectId;
	}

	/**
	 * Load by constraint `users_fk_primary_c` foreign key (`primary_contact_id`) references `contacts` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $primary_contact_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadUsersByPrimaryContactId($database, $primary_contact_id, Input $options=null)
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
			self::$_arrUsersByPrimaryContactId = null;
		}

		$arrUsersByPrimaryContactId = self::$_arrUsersByPrimaryContactId;
		if (isset($arrUsersByPrimaryContactId) && !empty($arrUsersByPrimaryContactId)) {
			return $arrUsersByPrimaryContactId;
		}

		$primary_contact_id = (int) $primary_contact_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `user_company_id` ASC, `role_id` ASC, `default_project_id` ASC, `primary_contact_id` ASC, `mobile_network_carrier_id` ASC, `user_image_id` ASC, `security_image_id` ASC, `html_template_theme_id` ASC, `mobile_phone_number` ASC, `screen_name` ASC, `email` ASC, `password_hash` ASC, `password_guid` ASC, `security_phrase` ASC, `modified` ASC, `accessed` ASC, `created` ASC, `alerts` ASC, `tc_accepted_flag` ASC, `email_subscribe_flag` ASC, `remember_me_flag` ASC, `change_password_flag` ASC, `disabled_flag` ASC, `deleted_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpUser = new User($database);
			$sqlOrderByColumns = $tmpUser->constructSqlOrderByColumns($arrOrderByAttributes);

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
	u.*

FROM `users` u
WHERE u.`primary_contact_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `user_company_id` ASC, `role_id` ASC, `default_project_id` ASC, `primary_contact_id` ASC, `mobile_network_carrier_id` ASC, `user_image_id` ASC, `security_image_id` ASC, `html_template_theme_id` ASC, `mobile_phone_number` ASC, `screen_name` ASC, `email` ASC, `password_hash` ASC, `password_guid` ASC, `security_phrase` ASC, `modified` ASC, `accessed` ASC, `created` ASC, `alerts` ASC, `tc_accepted_flag` ASC, `email_subscribe_flag` ASC, `remember_me_flag` ASC, `change_password_flag` ASC, `disabled_flag` ASC, `deleted_flag` ASC
		$arrValues = array($primary_contact_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrUsersByPrimaryContactId = array();
		while ($row = $db->fetch()) {
			$user_id = $row['id'];
			$user = self::instantiateOrm($database, 'User', $row, null, $user_id);
			/* @var $user User */
			$arrUsersByPrimaryContactId[$user_id] = $user;
		}

		$db->free_result();

		self::$_arrUsersByPrimaryContactId = $arrUsersByPrimaryContactId;

		return $arrUsersByPrimaryContactId;
	}

	/**
	 * Load by constraint `users_fk_mnc` foreign key (`mobile_network_carrier_id`) references `mobile_network_carriers` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $mobile_network_carrier_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadUsersByMobileNetworkCarrierId($database, $mobile_network_carrier_id, Input $options=null)
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
			self::$_arrUsersByMobileNetworkCarrierId = null;
		}

		$arrUsersByMobileNetworkCarrierId = self::$_arrUsersByMobileNetworkCarrierId;
		if (isset($arrUsersByMobileNetworkCarrierId) && !empty($arrUsersByMobileNetworkCarrierId)) {
			return $arrUsersByMobileNetworkCarrierId;
		}

		$mobile_network_carrier_id = (int) $mobile_network_carrier_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `user_company_id` ASC, `role_id` ASC, `default_project_id` ASC, `primary_contact_id` ASC, `mobile_network_carrier_id` ASC, `user_image_id` ASC, `security_image_id` ASC, `html_template_theme_id` ASC, `mobile_phone_number` ASC, `screen_name` ASC, `email` ASC, `password_hash` ASC, `password_guid` ASC, `security_phrase` ASC, `modified` ASC, `accessed` ASC, `created` ASC, `alerts` ASC, `tc_accepted_flag` ASC, `email_subscribe_flag` ASC, `remember_me_flag` ASC, `change_password_flag` ASC, `disabled_flag` ASC, `deleted_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpUser = new User($database);
			$sqlOrderByColumns = $tmpUser->constructSqlOrderByColumns($arrOrderByAttributes);

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
	u.*

FROM `users` u
WHERE u.`mobile_network_carrier_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `user_company_id` ASC, `role_id` ASC, `default_project_id` ASC, `primary_contact_id` ASC, `mobile_network_carrier_id` ASC, `user_image_id` ASC, `security_image_id` ASC, `html_template_theme_id` ASC, `mobile_phone_number` ASC, `screen_name` ASC, `email` ASC, `password_hash` ASC, `password_guid` ASC, `security_phrase` ASC, `modified` ASC, `accessed` ASC, `created` ASC, `alerts` ASC, `tc_accepted_flag` ASC, `email_subscribe_flag` ASC, `remember_me_flag` ASC, `change_password_flag` ASC, `disabled_flag` ASC, `deleted_flag` ASC
		$arrValues = array($mobile_network_carrier_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrUsersByMobileNetworkCarrierId = array();
		while ($row = $db->fetch()) {
			$user_id = $row['id'];
			$user = self::instantiateOrm($database, 'User', $row, null, $user_id);
			/* @var $user User */
			$arrUsersByMobileNetworkCarrierId[$user_id] = $user;
		}

		$db->free_result();

		self::$_arrUsersByMobileNetworkCarrierId = $arrUsersByMobileNetworkCarrierId;

		return $arrUsersByMobileNetworkCarrierId;
	}

	/**
	 * Load by constraint `users_fk_si` foreign key (`security_image_id`) references `security_images` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $security_image_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadUsersBySecurityImageId($database, $security_image_id, Input $options=null)
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
			self::$_arrUsersBySecurityImageId = null;
		}

		$arrUsersBySecurityImageId = self::$_arrUsersBySecurityImageId;
		if (isset($arrUsersBySecurityImageId) && !empty($arrUsersBySecurityImageId)) {
			return $arrUsersBySecurityImageId;
		}

		$security_image_id = (int) $security_image_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `user_company_id` ASC, `role_id` ASC, `default_project_id` ASC, `primary_contact_id` ASC, `mobile_network_carrier_id` ASC, `user_image_id` ASC, `security_image_id` ASC, `html_template_theme_id` ASC, `mobile_phone_number` ASC, `screen_name` ASC, `email` ASC, `password_hash` ASC, `password_guid` ASC, `security_phrase` ASC, `modified` ASC, `accessed` ASC, `created` ASC, `alerts` ASC, `tc_accepted_flag` ASC, `email_subscribe_flag` ASC, `remember_me_flag` ASC, `change_password_flag` ASC, `disabled_flag` ASC, `deleted_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpUser = new User($database);
			$sqlOrderByColumns = $tmpUser->constructSqlOrderByColumns($arrOrderByAttributes);

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
	u.*

FROM `users` u
WHERE u.`security_image_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `user_company_id` ASC, `role_id` ASC, `default_project_id` ASC, `primary_contact_id` ASC, `mobile_network_carrier_id` ASC, `user_image_id` ASC, `security_image_id` ASC, `html_template_theme_id` ASC, `mobile_phone_number` ASC, `screen_name` ASC, `email` ASC, `password_hash` ASC, `password_guid` ASC, `security_phrase` ASC, `modified` ASC, `accessed` ASC, `created` ASC, `alerts` ASC, `tc_accepted_flag` ASC, `email_subscribe_flag` ASC, `remember_me_flag` ASC, `change_password_flag` ASC, `disabled_flag` ASC, `deleted_flag` ASC
		$arrValues = array($security_image_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrUsersBySecurityImageId = array();
		while ($row = $db->fetch()) {
			$user_id = $row['id'];
			$user = self::instantiateOrm($database, 'User', $row, null, $user_id);
			/* @var $user User */
			$arrUsersBySecurityImageId[$user_id] = $user;
		}

		$db->free_result();

		self::$_arrUsersBySecurityImageId = $arrUsersBySecurityImageId;

		return $arrUsersBySecurityImageId;
	}

	/**
	 * Load by constraint `users_fk_htt` foreign key (`html_template_theme_id`) references `html_template_themes` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $html_template_theme_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadUsersByHtmlTemplateThemeId($database, $html_template_theme_id, Input $options=null)
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
			self::$_arrUsersByHtmlTemplateThemeId = null;
		}

		$arrUsersByHtmlTemplateThemeId = self::$_arrUsersByHtmlTemplateThemeId;
		if (isset($arrUsersByHtmlTemplateThemeId) && !empty($arrUsersByHtmlTemplateThemeId)) {
			return $arrUsersByHtmlTemplateThemeId;
		}

		$html_template_theme_id = (int) $html_template_theme_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `user_company_id` ASC, `role_id` ASC, `default_project_id` ASC, `primary_contact_id` ASC, `mobile_network_carrier_id` ASC, `user_image_id` ASC, `security_image_id` ASC, `html_template_theme_id` ASC, `mobile_phone_number` ASC, `screen_name` ASC, `email` ASC, `password_hash` ASC, `password_guid` ASC, `security_phrase` ASC, `modified` ASC, `accessed` ASC, `created` ASC, `alerts` ASC, `tc_accepted_flag` ASC, `email_subscribe_flag` ASC, `remember_me_flag` ASC, `change_password_flag` ASC, `disabled_flag` ASC, `deleted_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpUser = new User($database);
			$sqlOrderByColumns = $tmpUser->constructSqlOrderByColumns($arrOrderByAttributes);

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
	u.*

FROM `users` u
WHERE u.`html_template_theme_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `user_company_id` ASC, `role_id` ASC, `default_project_id` ASC, `primary_contact_id` ASC, `mobile_network_carrier_id` ASC, `user_image_id` ASC, `security_image_id` ASC, `html_template_theme_id` ASC, `mobile_phone_number` ASC, `screen_name` ASC, `email` ASC, `password_hash` ASC, `password_guid` ASC, `security_phrase` ASC, `modified` ASC, `accessed` ASC, `created` ASC, `alerts` ASC, `tc_accepted_flag` ASC, `email_subscribe_flag` ASC, `remember_me_flag` ASC, `change_password_flag` ASC, `disabled_flag` ASC, `deleted_flag` ASC
		$arrValues = array($html_template_theme_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrUsersByHtmlTemplateThemeId = array();
		while ($row = $db->fetch()) {
			$user_id = $row['id'];
			$user = self::instantiateOrm($database, 'User', $row, null, $user_id);
			/* @var $user User */
			$arrUsersByHtmlTemplateThemeId[$user_id] = $user;
		}

		$db->free_result();

		self::$_arrUsersByHtmlTemplateThemeId = $arrUsersByHtmlTemplateThemeId;

		return $arrUsersByHtmlTemplateThemeId;
	}

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all users records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllUsers($database, Input $options=null)
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
			self::$_arrAllUsers = null;
		}

		$arrAllUsers = self::$_arrAllUsers;
		if (isset($arrAllUsers) && !empty($arrAllUsers)) {
			return $arrAllUsers;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `user_company_id` ASC, `role_id` ASC, `default_project_id` ASC, `primary_contact_id` ASC, `mobile_network_carrier_id` ASC, `user_image_id` ASC, `security_image_id` ASC, `html_template_theme_id` ASC, `mobile_phone_number` ASC, `screen_name` ASC, `email` ASC, `password_hash` ASC, `password_guid` ASC, `security_phrase` ASC, `modified` ASC, `accessed` ASC, `created` ASC, `alerts` ASC, `tc_accepted_flag` ASC, `email_subscribe_flag` ASC, `remember_me_flag` ASC, `change_password_flag` ASC, `disabled_flag` ASC, `deleted_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpUser = new User($database);
			$sqlOrderByColumns = $tmpUser->constructSqlOrderByColumns($arrOrderByAttributes);

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
	u.*

FROM `users` u{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `user_company_id` ASC, `role_id` ASC, `default_project_id` ASC, `primary_contact_id` ASC, `mobile_network_carrier_id` ASC, `user_image_id` ASC, `security_image_id` ASC, `html_template_theme_id` ASC, `mobile_phone_number` ASC, `screen_name` ASC, `email` ASC, `password_hash` ASC, `password_guid` ASC, `security_phrase` ASC, `modified` ASC, `accessed` ASC, `created` ASC, `alerts` ASC, `tc_accepted_flag` ASC, `email_subscribe_flag` ASC, `remember_me_flag` ASC, `change_password_flag` ASC, `disabled_flag` ASC, `deleted_flag` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllUsers = array();
		while ($row = $db->fetch()) {
			$user_id = $row['id'];
			$user = self::instantiateOrm($database, 'User', $row, null, $user_id);
			/* @var $user User */
			$arrAllUsers[$user_id] = $user;
		}

		$db->free_result();

		self::$_arrAllUsers = $arrAllUsers;

		return $arrAllUsers;
	}

	// Save: insert on duplicate key update

	// Save: insert ignore

	public function getUserRole()
	{
		if (!isset($this->userRole)) {
			$AXIS_USER_ROLE_ID_GLOBAL_ADMIN = AXIS_USER_ROLE_ID_GLOBAL_ADMIN;
			$AXIS_USER_ROLE_ID_ADMIN = AXIS_USER_ROLE_ID_ADMIN;
			$AXIS_USER_ROLE_ID_USER = AXIS_USER_ROLE_ID_USER;

			$arrRolesMap = array(
				$AXIS_USER_ROLE_ID_GLOBAL_ADMIN => 'global_admin',
				$AXIS_USER_ROLE_ID_ADMIN => 'admin',
				$AXIS_USER_ROLE_ID_USER => 'user',
			);

			$role_id = (int) $this->role_id;
			if (isset($arrRolesMap[$role_id])) {
				$this->userRole = $arrRolesMap[$role_id];
			} else {
				$this->userRole = 'guest';
			}
		}

		return $this->userRole;
	}

	public function setUserRole($userRole)
	{
		$this->userRole = $userRole;
	}

	public function getArrOwnedProjects()
	{
		$dataLoaded = $this->isDataLoaded();
		if (!$dataLoaded) {
			return array();
		}

		if (!isset($this->arrOwnedProjects)) {
			$database = $this->getDatabase();
			$userRole = $this->getUserRole();
			$user_company_id = $this->user_company_id;
			$user_id = $this->user_id;
			$primary_contact_id = $this->primary_contact_id;

			$this->arrOwnedProjects = Project::loadOwnedProjects($database, $userRole, $user_company_id, $user_id, $primary_contact_id);
		}

		return $this->arrOwnedProjects;
	}

	public function setArrOwnedProjects($arrOwnedProjects)
	{
		$this->arrOwnedProjects = $arrOwnedProjects;
	}

	public function getArrGuestProjects()
	{
		if (!isset($this->arrGuestProjects)) {
			$database = $this->getDatabase();
			$user_company_id = $this->user_company_id;
			$user_id = $this->user_id;
			$primary_contact_id = $this->primary_contact_id;

			$this->arrGuestProjects = Project::loadGuestProjects($database, $user_company_id, $user_id, $primary_contact_id);
		}

		return $this->arrGuestProjects;
	}

	public function setArrGuestProjects($arrGuestProjects)
	{
		$this->arrGuestProjects = $arrGuestProjects;
	}

	public static function loadUsersList($database, $user_company_id=null)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		if (isset($user_company_id) && !empty($user_company_id)) {
			$escapedUserCompanyId = $db->quote($user_company_id);
			$and = "AND user_company_id = $escapedUserCompanyId ";
			$orderBy = "ORDER BY `email` ASC ";
		} else {
			$and = "";
			$orderBy = "ORDER BY  `email`,`user_company_id` ASC ";
		}

		// Never load the "Non-existent User"
		$AXIS_NON_EXISTENT_USER_ID = AXIS_NON_EXISTENT_USER_ID;
		$query =
"
SELECT *
FROM `users`
WHERE `id` <> $AXIS_NON_EXISTENT_USER_ID
AND `is_archive` = 'N'
$and
$orderBy
";
		$db->query($query, MYSQLI_USE_RESULT);

		$arrObjectsList = array();
		$arrOptionsList = array();
		while ($row = $db->fetch()) {
			$id = $row['id'];
			$optionValue = $row['email'];

			$object = new User($database);
			$object->setData($row);
			$object->convertDataToProperties();

			// Object list format
			$arrObjectsList[$id] = $object;

			// Drop down select options list format
			$arrOptionsList[$id] = $optionValue;
		}
		$db->free_result();

		$arrReturn = array(
			'objects_list' => $arrObjectsList,
			'options_list' => $arrOptionsList
		);

		return $arrReturn;
	}

	public static function generateSecurityQuestionList($database)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT *
FROM `security_questions`
";
		$db->query($query, MYSQLI_USE_RESULT);
		$arrSecurityQuestions = array();
		while($row = $db->fetch()) {
			$id  = $row['id'];
			$security_question = $row['security_question'];
			$arrSecurityQuestions[$security_question] = $id;
		}
		$db->free_result();

		return $arrSecurityQuestions;
	}

	public static function convertPostToStandardUser($database, Egpcs $post)
	{
		/* @var $post Egpcs */

		$u = new User($database);
		$arrAttributes = $u->getArrAttributesMap();
		// Map the form fields/inputs to Class/Object Properties so flip the $arrAttributesMap
		$arrAttributes = array_flip($arrAttributes);
		$data = $post->getData();

		// Lowercase email address
		$data['email'] = strtolower($data['email']);

		// Get a mobile_phone_number as a concatenated string or NULL for the unique index.
		if (isset($data['mobile_phone_area_code']) && isset($data['mobile_phone_prefix']) && isset($data['mobile_phone_number'])) {
			$mobile_phone_number = $data['mobile_phone_area_code'].$data['mobile_phone_prefix'].$data['mobile_phone_number'];
		}
		if (!isset($mobile_phone_number) || empty($mobile_phone_number)) {
			$mobile_phone_number = null;
		}
		$data['mobile_phone_number'] = $mobile_phone_number;

		// Cell phone is optional so set mobile_network_carrier_id = 1 when no information is submitted.
		if (!isset($data['mobile_network_carrier_id']) || (isset($data['mobile_network_carrier_id']) && empty($data['mobile_network_carrier_id']))) {
			$data['mobile_network_carrier_id'] = 1;
		}

		/*
		// birth_date
		// 2011-06-25
		if (isset($data['birth_year'])) {
			$birth_year = $data['birth_year'];
		}
		if (isset($data['birth_month'])) {
			$birth_month = $data['birth_month'];
			$birth_month = str_pad($birth_month, 2, '0', STR_PAD_LEFT);
		}
		if (isset($data['birth_day'])) {
			$birth_day = $data['birth_day'];
			$birth_day = str_pad($birth_day, 2, '0', STR_PAD_LEFT);
		}
		if (isset($birth_year) && isset($birth_month) && isset($birth_day)) {
			$birth_date = $birth_year.'-'.$birth_month.'-'.$birth_day;
			$data['birth_date'] = $birth_date;
		}
		*/

		// alerts
		if (isset($data['alertTypes']) && !empty($data['alertTypes'])) {
			$arrTmp = $data['alertTypes'];
			//$arrAlertTypes = array_flip($arrAlertTypes);
			$arrAlertTypes = array();
			foreach ($arrTmp as $value) {
				$arrAlertTypes[$value] = 1;
			}

			if (isset($arrAlertTypes['emailAlert'])) {
				$emailAlertFlag = true;
			} else {
				$emailAlertFlag = false;
			}

			if (isset($arrAlertTypes['smsAlert'])) {
				$smsAlertFlag = true;
			} else {
				$smsAlertFlag = false;
			}

			if ($emailAlertFlag && $smsAlertFlag) {
				$alerts = 'Both';
			} elseif ($emailAlertFlag && !$smsAlertFlag) {
				$alerts = 'Email';
			} elseif (!$emailAlertFlag && $smsAlertFlag) {
				$alerts = 'SMS';
			} else {
				$alerts = 'SMS';
			}

			$data['alerts'] = $alerts;
		}

		/*
		// privacy
		if (isset($data['privacyPreference']) && !empty($data['privacyPreference'])) {
			$privacy = $data['privacyPreference'];
			if ($privacy == 'anyone') {
				$privacy = 'Always Share';
			} elseif ($privacy == 'match') {
				$privacy = 'Share if Match';
			} elseif ($privacy == 'prompt') {
				$privacy = 'Prompt to Share';
			} else {
				$privacy = 'Prompt to Share';
			}

			$data['privacy'] = $privacy;
		}
		*/

		// Terms & Conditions / Legal
		// Submitting the form implies agreement
		// ??? Do we need this as a database flag at all?
		$data['tc_accepted_flag'] = 'Y';

		$newData = array_intersect_key($data, $arrAttributes);

		/*
		$data = array();
		foreach ($arrUserAttributes as $key => $null) {
			$data[$key] = $post->$key;
		}
		*/

		// Keys need to match the database key names
		$finalData = array();
		foreach ($newData as $k => $v) {
			$databaseAttribute = $arrAttributes[$k];
			$finalData[$databaseAttribute] = $v;
		}

		$u->setData($finalData);
		$u->convertDataToProperties();

		return $u;
	}

	public function registerUserAccount($database)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$db->begin();

		$arrSelect = array();
		$arrAnd = array();

		// Check for availability of user info
		// if (isset($this->mobile_phone_number) && !empty($this->mobile_phone_number)) {
		// 	$arrSelect[] = ", `mobile_phone_number`";
		// 	$arrAnd[] = "AND `mobile_phone_number` = ?";
		// 	$arrValues[] = $this->mobile_phone_number;
		// }
		// if (isset($this->screen_name) && !empty($this->screen_name)) {
		// 	$arrSelect[] = ", `screen_name`";
		// 	$arrAnd[] = "AND `screen_name` = ?";
		// 	$arrValues[] = $this->screen_name;
		// }
		if (isset($this->email) && !empty($this->email)) {
			$arrSelect[] = ", `email`";
			$arrAnd[] = "AND `email` = ?";
			$arrValues[] = $this->email;
		}

		$select = join('', $arrSelect);
		$and = join(' ', $arrAnd);

		$query =
"
SELECT `id`$select
FROM `users`
WHERE 1
$and
";
		//$arrValues = array($this->mobile_phone_number, $this->email, $this->screen_name);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			if (isset($this->mobile_phone_number) && !empty($this->mobile_phone_number)) {
				$storedMobilePhoneNumber = $row['mobile_phone_number'];
				if ($this->mobile_phone_number == $storedMobilePhoneNumber) {
					$arrErrors['mobile_phone_number'] = true;
				}
			}

			if (isset($this->screen_name) && !empty($this->screen_name)) {
				$storedScreenName = $row['screen_name'];
				if ($this->screen_name == $storedScreenName) {
					$arrErrors['screen_name'] = true;
				}
			}

			if (isset($this->email) && !empty($this->email)) {
				$storedEmail = $row['email'];
				if ($this->email == $storedEmail) {
					$arrErrors['email'] = true;
				}
			}

			$db->rollback();

			$user_id = -1;
		} else {
			// INSERT INTO users table
			/*
			$key = array(
				'mobile_phone_number' => $u->mobile_phone_number
			);
			$this->setKey($key);
			*/

			// temporary
			$this->security_image_id = 1;

			// set timestamps
			$this->created = null;
			$this->accessed = null;

			// one-way encrypt password
			$passwordHash = User::createPasswordHash($this->password);
			$this->password_hash = $passwordHash;
			// Unsets property
			unset($this->password);
			// Unsets $_data['password']
			unset($this->password);

			do {
				$password_guid = User::createPasswordGuid();
			} while (!User::verifyPasswordGuidUniqueness($database, $password_guid));
			$this->password_guid = $password_guid;

			// html_template_theme_id
			$AXIS_USER_ROLE_ID_GLOBAL_ADMIN = AXIS_USER_ROLE_ID_GLOBAL_ADMIN;
			if ($this->role_id == $AXIS_USER_ROLE_ID_GLOBAL_ADMIN) {
				$this->html_template_theme_id = 1;
			} else {
				$this->html_template_theme_id = 2;
			}

			// Convert the object's properties to data
			$this->convertPropertiesToData();

			$user_id = $this->save();

			$db->commit();
			$db->free_result();

			$arrErrors = array();
		}

		$db->free_result();
		$arrReturn = array(
			'user_id' => $user_id,
			'errors' => $arrErrors
		);

		return $arrReturn;
	}

	public static function verifyPasswordGuidUniqueness($database, $password_guid)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT `password_guid`
FROM `users`
WHERE `password_guid` = ?
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

	public function updateUserAccount($database)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$db->begin();

		// Check for availability of GUIDS
		// First see which GUIDS have changed

		$emailAvailable = 1;

		// UPDATE users table
		$key = array(
			'id' => $this->user_id
		);
		$this->setKey($key);
		unset($this->user_id);

		// temporary
		$this->security_image_id = 1;

		// set timestamps
		$this->modified = null;

		if ($this->password) {
			// one-way encrypt password
			$passwordHash = User::createPasswordHash($this->password);
			$this->password_hash = $passwordHash;
			unset($this->password);
			unset($this->salt);
		} else {
			unset($this->password_hash);
			unset($this->salt);
			unset($this->password);
		}

		// Convert the object's properties to data
		$this->convertPropertiesToData();

		$this->save();

		// INSERT INTO user_details

		// INSERT INTO points_of_compatibility_user_templates

		$db->commit();

		$arrErrors = array();

		$arrReturn = array(
			'errors' => $arrErrors
		);

		return $arrReturn;
	}

	/**
	 * Conditionally invoke the standard save() method after deltification.
	 *
	 */
	public function deltifyAndSave()
	{
		// prevent error messages
		$newRecord = false;

		//load existing

		//deltify

		//save (insert, update, or do nothing)

		$newData = $this->getData();
		$row = $newData;

		// These GUIDs taken as a composite are the primary key of users
		// <id>
		$user_id = $this->user_id;

		$key = array(
			'id' => $user_id
		);

		$database = $this->getDatabase();
		$table = $this->getTable();
		$u = new User($database, $table);
		$u->setKey($key);
		$u->load();

		/**
		 * Conditionally Insert/Update the record.
		 *
		 * $key is conditionally set based on if record exists.
		 */
		$newData = $row;

		//Iterate over latest input from data feed and only set different values.
		//Same values will be key unset to acheive a conditional update.
		$save = false;
		$existsFlag = $u->isDataLoaded();
		if ($existsFlag) {
			$record_id = $u->id;

			//Conditionally Update the record
			//Don't compare the key values that loaded the record.
			unset($u->id);
			unset($u->modified);
			//unset($u->created);
			//unset($u->deleted_flag);

			$existingData = $u->getData();

			//debug
			/*
			$keyDiffFlag = Data::diffKeys($existingData, $newData);
			if (!$keyDiffFlag) {
				echo "Key:\n".print_r($key, true)."\n\n\n\n";
				echo 'Existing:'."\n";
				ksort($existingData);
				print_r($existingData);
				echo 'New:'."\n";
				ksort($newData);
				print_r($newData);
				$n = array_keys($newData);
				$e = array_keys($existingData);
				$_1 = array_diff_key($n, $e);
				echo 'New:'."\n";
				print_r($_1);
				$_2 = array_diff_key($e, $n);
				echo 'Old:'."\n";
				print_r($_2);
				throw new Exception('Keys mismatch');
			}
			*/

			$data = Data::deltify($existingData, $newData);
			if (!empty($data)) {
				$u->setData($data);
				$save = true;
				//$this->updatedRecords++;
			} else {
				$u->id = $record_id;
				return $bi;
			}
		} else {
			return false;
		}

		//Save if needed (conditionally Insert/Update)
		if ($save) {
			$id = $u->save();

			if (isset($id)) {
				$u->id = $record_id;
			}
		}

		return $bi;
	}

	public function updateUserImage()
	{
//		$database = $this->getDatabase();
//		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$data = $this->getData();

		//$db->begin();

		// UPDATE users table
		$key = array(
			'email' => $this->email
		);
		$this->setKey($key);

		// update user_image_id only
		$tmpData = array('user_image_id' => $this->user_image_id);
		$this->setData($tmpData);

		$this->save();

		//$db->commit();

		$this->setData($data);
		$this->setKey(null);
	}

	public function updatePassword($database, $newPassword)
	{
		$user_id = $this->user_id;

		if (!isset($user_id) || empty($user_id)) {
			return false;
		}

		// one-way encrypt password
		$passwordHash = User::createPasswordHash($newPassword);

		// Create a new Password GUID
		do {
			$password_guid = User::createPasswordGuid();
		} while (!User::verifyPasswordGuidUniqueness($database, $password_guid));
		$this->password_guid = $password_guid;
		$this->password_guid = $password_guid;
		$this['password_guid'] = $password_guid;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$db->begin();

		// encrypt password before storing it in the database
		// use the standard salt, etc.
		// set change_password_flag to "Y"
		$query =
"
UPDATE `users`
SET `password_hash` = ?,
password_guid = ?,
".//"`salt` = ?,
"`change_password_flag` = 'N'
WHERE `id` = ?
";
		//$arrValues = array($passwordHash, $salt, $user_id);
		$arrValues = array($passwordHash, $password_guid, $user_id);

		$result = $db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		if (!$result) {
			$db->rollback();
			$db->free_result();
			return false;
		}

		$db->commit();
		$db->free_result();

		$this->password_hash = $passwordHash;
		$this['password_hash'] = $passwordHash;

		return true;
	}

	public static function resetUserPassword($database, $email=false, $mobile_phone_number=false)
	{
		// Always lowercase the email input value
		if ($email) {
			$email = strtolower($email);
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$db->begin();

		// Verify that the user exists (email or cell phone number)
		if ($email) {
			$query =
"
SELECT *
FROM `users`
WHERE `email` = ?
";
			$arrValues = array($email);
		} elseif ($mobile_phone_number) {
			$query =
"
SELECT *
FROM `users`
WHERE `mobile_phone_number` = ?
";
			$arrValues = array($mobile_phone_number);
		} else {
			// Return an error message
			$arrErrors = array(
				'error' => 'Please enter a valid email or cell phone number.'
			);
		}

		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$u = new User($database);
			$u->setData($row);
			$u->convertDataToProperties();

			// reset user's password and send made-up password in an email to the user

			// generate random password
			$newPassword = User::generateUserPassword(8);
			$u->newPassword = $newPassword;

			do {
				$password_guid = User::createPasswordGuid();
			} while (!User::verifyPasswordGuidUniqueness($database, $password_guid));
			$u->password_guid = $password_guid;

			// encrypt password before storing it in the database
			// use a new randomly generated salt
			// set change_password_flag to "Y"

			// one-way encrypt password
			$passwordHash = User::createPasswordHash($newPassword);
			$u->password_hash = $passwordHash;
			$u['password_hash'] = $passwordHash;

			if ($email) {
				$query =
"
UPDATE `users`
SET `password_hash` = ?,
password_guid = ?,
".//"`salt` = ?,
"`change_password_flag` = 'Y'
WHERE `email` = ?
";
				$arrValues = array($passwordHash, $password_guid, $email);
			} elseif ($mobile_phone_number) {
				$query =
"
UPDATE `users`
SET `password` = ?,
password_guid = ?,
".//"`salt` = ?,
"`change_password_flag` = 'Y'
WHERE `mobile_phone_number` = ?
";
				$arrValues = array($passwordHash, $password_guid, $mobile_phone_number);
			}

			$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

			$arrErrors = array();
		} else {
			// Send back an error message since the user was not found
			$u = false;
			$arrErrors = array(
				'error' => 'User not found.'
			);
		}

		$db->commit();
		$db->free_result();

		$arrReturn = array(
			'user' => $u,
			'errors' => $arrErrors
		);

		return $arrReturn;
	}

	public static function generateUserPassword($passwordLength=8)
	{
		$arrDecimals = array (
			'0' => 0,
			//'1' => 1,
			'1' => 2,
			'2' => 3,
			'3' => 4,
			'4' => 5,
			'5' => 6,
			'6' => 7,
			'7' => 8,
			'8' => 9,
		);

		$arrLowerCaseLetters = array(
			'0' => 'a',
			'1' => 'b',
			'2' => 'c',
			'3' => 'd',
			'4' => 'e',
			'5' => 'f',
			'6' => 'g',
			'7' => 'h',
			'8' => 'i',
			'9' => 'j',
			'10' => 'k',
			//'11' => 'l',
			'11' => 'm',
			'12' => 'n',
			'13' => 'o',
			'14' => 'p',
			'15' => 'q',
			'16' => 'r',
			'17' => 's',
			'18' => 't',
			'19' => 'u',
			'20' => 'v',
			'21' => 'w',
			'22' => 'x',
			'23' => 'y',
			'24' => 'z',
		);

		$arrUpperCaseLetters = array(
			'0' => 'A',
			'1' => 'B',
			'2' => 'C',
			'3' => 'D',
			'4' => 'E',
			'5' => 'F',
			'6' => 'G',
			'7' => 'H',
			'8' => 'I',
			'9' => 'J',
			'10' => 'K',
			'11' => 'L',
			'12' => 'M',
			'13' => 'N',
			'14' => 'O',
			'15' => 'P',
			'16' => 'Q',
			'17' => 'R',
			'18' => 'S',
			'19' => 'T',
			'20' => 'U',
			'21' => 'V',
			'22' => 'W',
			'23' => 'X',
			'24' => 'Y',
			'25' => 'Z',
		);

		$arrSymbols = array(
			'0' => '!',
			'1' => '@',
			'2' => '#',
			'3' => '$',
			'4' => '%',
			'5' => '^',
			'6' => '&',
			'7' => '*',
			'8' => '-',
			'9' => '+',
			'10' => '/',
			'11' => '=',
		);

		$randomlyGeneratedPassword = '';

		// password defaults to 8 characters in length
		for ($i = 0; $i < $passwordLength; $i++) {
			// avoid using symbols for now so $randChoice is 0 to 2, not 0 to 3
			$randChoice = mt_rand(0, 2);
			if ($randChoice == 0) { // use 0, skip "1", or 2-9
				$randIndex = mt_rand(0, 8);
				$randomlyGeneratedPassword .= $arrDecimals[$randIndex];
			} elseif ($randChoice == 1) { // use a-k, skip "l", or m-z
				$randIndex = mt_rand(0, 24);
				$randomlyGeneratedPassword .= $arrLowerCaseLetters[$randIndex];
			} elseif ($randChoice == 2) { // use A-Z
				$randIndex = mt_rand(0, 25);
				$randomlyGeneratedPassword .= $arrUpperCaseLetters[$randIndex];
			} elseif ($randChoice == 3) { // use symbol
				$randIndex = mt_rand(0, 11);
				$randomlyGeneratedPassword .= $arrSymbols[$randIndex];
			}
		}

		return $randomlyGeneratedPassword;
	}

	public static function generatePasswordSalt($size = 8)
	{
		if (!isset($size) || !is_int($size) || ($size < 8)) {
			$size = 8;
		}

		// Allowable Characters: ./0-9A-Za-z
		// ./0-9
		$charRange1Min = 46;
		$charRange1Max = 57;
		// A-Z
		$charRange2Min = 65;
		$charRange2Max = 90;
		// a-z
		$charRange3Min = 97;
		$charRange3Max = 122;

		$salt = '';
		for ($i=0; $i<$size; $i++) {
			mt_srand();
			$charRange = mt_rand(1, 3);
			$tmpMin = 'charRange'.$charRange.'Min';
			$tmpMax = 'charRange'.$charRange.'Max';
			mt_srand();
			$min = $$tmpMin;
			$max = $$tmpMax;
			$ascii = mt_rand($min, $max);
			$chr = chr($ascii);
			$salt .= $chr;
		}

		return $salt;
	}

	public static function createPasswordGuid($size = 16)
	{
		require_once('lib/common/PasswordHash.php');
		$passwordHash = new PasswordHash();
		$passwordHash->setSaltSizeInBytes($size);
		$guid = $passwordHash->getSaltHex();

		return $guid;
	}

	public static function createPasswordHash($plaintextPassword)
	{
		//$passwordHash = crypt($password, $salt);
		require_once('lib/common/PasswordHash.php');
		$passwordHash = PasswordHash::create_hash($plaintextPassword);
		/* @var $passwordHash PasswordHash */
		$formattedPasswordHashString = $passwordHash->getFormattedPasswordHashOutput();

		return $formattedPasswordHashString;
	}

	public static function verifyPassword($plaintextPassword, $passwordHash)
	{
		require_once('lib/common/PasswordHash.php');
		$passwordVerifiedFlag = PasswordHash::validate_password($plaintextPassword, $passwordHash);

		return $passwordVerifiedFlag;
	}

	/**
	 * See if user info is available.
	 */
	public static function isUserInfoAvailable($database, $mobile_phone_number=null, $email=null, $screen_name=null) {
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$db->begin();

		$query =
"
SELECT `mobile_phone_number`, `email`, `screen_name`
FROM `users`
WHERE `mobile_phone_number` = ?
OR `email` = ?
OR `screen_name` = ?
";
		$arrValues = array($mobile_phone_number, $email, $screen_name);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$storedMobilePhoneNumber = $row['mobile_phone_number'];
			$storedEmail = $row['email'];
			$storedScreenName = $row['screen_name'];

			if ($mobile_phone_number == $storedMobilePhoneNumber) {
				$arrReturn['mobile_phone_number'] = false;
			} else {
				$arrReturn['mobile_phone_number'] = true;
			}

			if ($email == $storedEmail) {
				$arrReturn['email'] = false;
			} else {
				$arrReturn['email'] = true;
			}

			if ($screen_name == $storedScreenName) {
				$arrReturn['screen_name'] = false;
			} else {
				$arrReturn['screen_name'] = true;
			}
		} else {
			$arrReturn = array(
				'mobile_phone_number' => false,
				'email' => false,
				'screen_name' => false,
			);
		}

		// INSERT INTO reserved_user_info table to reserve screen_name, etc.

		$db->commit();
		return $arrReturn;
	}

	/**
	 * See if mobile_phone_number is available or already in use.
	 */
	public static function isMobilePhoneNumberAvailable($database, $mobile_phone_number)
	{
		if (!isset($mobile_phone_number) || empty($mobile_phone_number)) {
			throw new Exception('Bad input');
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT `mobile_phone_number`
FROM `users`
WHERE `mobile_phone_number` = ?
AND `mobile_phone_number` IS NOT NULL
";
		$arrValues = array($mobile_phone_number);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$storedMobilePhoneNumber = $row['mobile_phone_number'];

			if ($mobile_phone_number == $storedMobilePhoneNumber) {
				return false;
			} else {
				return true;
			}
		} else {
			return true;
		}

		return false;
	}

	/**
	 * See if email is available or already in use.
	 */
	public static function isEmailAvailable($database, $email)
	{
		if (!isset($email) || empty($email)) {
			throw new Exception('Bad input');
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT `email`
FROM `users`
WHERE `email` = ?
AND `email` IS NOT NULL
";
		$arrValues = array($email);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$existingEmail = $row['email'];

			if ($email == $existingEmail) {
				return false;
			} else {
				return true;
			}
		} else {
			return true;
		}

		return false;
	}

	/**
	 * See if email is available or already in use.
	 */
	public static function isScreenNameAvailable($database, $screen_name)
	{
		if (!isset($screen_name) || empty($screen_name)) {
			throw new Exception('Bad input');
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT `screen_name`
FROM `users`
WHERE `screen_name` = ?
AND `screen_name` IS NOT NULL
";
		$arrValues = array($screen_name);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$existingScreenName = $row['screen_name'];

			if ($screen_name == $existingScreenName) {
				return false;
			} else {
				return true;
			}
		} else {
			return true;
		}

		return false;
	}

	/**
	 * See if user info is available.
	 */
	public static function reserveUserInfo($database, $mobile_phone_number, $email, $screen_name)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$db->begin();

		$query =
"
SELECT `mobile_phone_number`, `email`, `screen_name`
FROM `users`
WHERE `mobile_phone_number` = ?
OR `email` = ?
OR `screen_name` = ?
";
		$arrValues = array($mobile_phone_number, $email, $screen_name);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$storedMobilePhoneNumber = $row['mobile_phone_number'];
			$storedEmail = $row['email'];
			$storedScreenName = $row['screen_name'];

			if ($mobile_phone_number == $storedMobilePhoneNumber) {
				$arrReturn['mobile_phone_number'] = false;
			} else {
				$arrReturn['mobile_phone_number'] = true;
			}

			if ($email == $storedEmail) {
				$arrReturn['email'] = false;
			} else {
				$arrReturn['email'] = true;
			}

			if ($screen_name == $storedScreenName) {
				$arrReturn['screen_name'] = false;
			} else {
				$arrReturn['screen_name'] = true;
			}
		} else {
			$arrReturn = array(
				'mobile_phone_number' => false,
				'email' => false,
				'screen_name' => false,
			);
		}

		// INSERT INTO reserved_user_info table to reserve screen_name, etc.

		$db->commit();
		return $arrReturn;
	}

	/**
	 * Retrieve a user_id value from Users GUIDs
	 */
	public static function findUserIdByGuid($database, $mobile_phone_number, $email) {
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT `id`
FROM `users`
WHERE `email` = ?
OR `mobile_phone_number` = ?
";
		$arrValues = array($mobile_phone_number, $email);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row && isset($row['id'])) {
			$user_id = $row['id'];
		} else {
			$user_id = null;
		}

		return $user_id;
	}

	public static function findUserIdByUUID($database, $uuidAttribute, $uuidValue)
	{
		$arrUuidAttributes = array(
			'user_id' => 'id',
			'mobile_phone_number' => 'mobile_phone_number',
			'email' => 'email',
			'password_guid' => 'password_guid',
			'primary_contact_id' => 'primary_contact_id',
			'screen_name' => 'screen_name',
		);

		if (isset($arrUuidAttributes[$uuidAttribute])) {
			$attribute = $arrUuidAttributes[$uuidAttribute];
		} else {
			throw new Exception('Invalid UUID for users.');
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT u.`id`
FROM `users` u
WHERE u.`$attribute` = ?
AND u.`$attribute` IS NOT NULL
";
		$arrValues = array($uuidValue);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row && !empty($row)) {
			$user_id = $row['id'];

			return $user_id;
		} else {
			return false;
		}

		return false;
	}

	public static function findUserIdByEmail($database, $email)
	{
		$user_id = self::findUserIdByUUID($database, 'email', $email);

		if ($user_id) {
			return $user_id;
		} else {
			return false;
		}

		return false;
	}

	public static function findUserIdByMobilePhoneNumber($database, $mobile_phone_number)
	{
		$user_id = self::findUserIdByUUID($database, 'mobile_phone_number', $mobile_phone_number);

		if ($user_id) {
			return $user_id;
		} else {
			return false;
		}

		return false;
	}

	public static function findUserIdByScreenName($database, $screen_name)
	{
		$user_id = self::findUserIdByUUID($database, 'screen_name', $screen_name);

		if ($user_id) {
			return $user_id;
		} else {
			return false;
		}

		return false;
	}

	public static function findUserIdByPasswordGuid($database, $password_guid)
	{
		$user_id = self::findUserIdByUUID($database, 'password_guid', $password_guid);

		if ($user_id) {
			return $user_id;
		} else {
			return false;
		}

		return false;
	}

	public function deriveCurrentlySelectedProjectId()
	{
		$dataLoaded = $this->isDataLoaded();
		if (!$dataLoaded) {
			$this->currentlySelectedProjectId = AXIS_NON_EXISTENT_PROJECT_ID;
		}

		$AXIS_NON_EXISTENT_PROJECT_ID = AXIS_NON_EXISTENT_PROJECT_ID;

		$arrOwnedProjects = $this->getArrOwnedProjects();
		$arrGuestProjects = $this->getArrGuestProjects();

		// Sanity check
		if (isset($arrOwnedProjects[$AXIS_NON_EXISTENT_PROJECT_ID])) {
			unset($arrOwnedProjects[$AXIS_NON_EXISTENT_PROJECT_ID]);
		}
		if (isset($arrGuestProjects[$AXIS_NON_EXISTENT_PROJECT_ID])) {
			unset($arrGuestProjects[$AXIS_NON_EXISTENT_PROJECT_ID]);
		}

		// This is a "cache" value so might be stale, therefor check it to confirm
		$default_project_id = $this->default_project_id;

		if (isset($arrOwnedProjects[$default_project_id])) {
			$currentlySelectedProjectId = $default_project_id;
		} elseif (isset($arrGuestProjects[$default_project_id])) {
			$currentlySelectedProjectId = $default_project_id;
		} elseif (!empty($arrOwnedProjects)) {
			// Get a reasonable value based on the list
			$arrKeys = array_keys($arrOwnedProjects);
			$currentlySelectedProjectId = array_shift($arrKeys);
		} elseif (!empty($arrGuestProjects)) {
			// Get a reasonable value based on the list
			$arrKeys = array_keys($arrGuestProjects);
			$currentlySelectedProjectId = array_shift($arrKeys);
		} else {
			$currentlySelectedProjectId = AXIS_NON_EXISTENT_PROJECT_ID;
		}

		$this->currentlySelectedProjectId = $currentlySelectedProjectId;
	}

	/**
	 * Load a users' contact, template theme, and project information
	 *
	 * @return void
	 */
	public function loadUserInfo()
	{
		$user_id = $this->user_id;
		if (!isset($user_id) || empty($user_id)) {
			throw new Exception('Missing user_id');
		} else {
			$user_id = (int) $user_id;
		}

		$database = $this->getDatabase();

		// Application constants
		$AXIS_NON_EXISTENT_USER_COMPANY_ID = AXIS_NON_EXISTENT_USER_COMPANY_ID;
		$AXIS_NON_EXISTENT_USER_ID = AXIS_NON_EXISTENT_USER_ID;
		$AXIS_NON_EXISTENT_PROJECT_ID = AXIS_NON_EXISTENT_PROJECT_ID;

		$AXIS_USER_ROLE_ID_GLOBAL_ADMIN = AXIS_USER_ROLE_ID_GLOBAL_ADMIN;
		$AXIS_USER_ROLE_ID_ADMIN = AXIS_USER_ROLE_ID_ADMIN;
		$AXIS_USER_ROLE_ID_USER = AXIS_USER_ROLE_ID_USER;

		$user_company_id = $this->user_company_id;
		$primary_contact_id = $this->primary_contact_id;
		$userRole = $this->getUserRole();

		// Derive the $currentlySelectedProjectId value
		// default_project_id should exist in owned or guest projects and thus be a good value, but bad data may arise where it is stale
		// default_project_id is like "cache", not dependable
		$this->deriveCurrentlySelectedProjectId();
		$currentlySelectedProjectId = $this->currentlySelectedProjectId;

		if ($currentlySelectedProjectId <> $AXIS_NON_EXISTENT_PROJECT_ID) {
			$arrOwnedProjects = $this->getArrOwnedProjects();
			$arrGuestProjects = $this->getArrOwnedProjects();
			if (isset($arrOwnedProjects[$currentlySelectedProjectId])) {
				$arrProject = $arrOwnedProjects[$currentlySelectedProjectId];
			} elseif (isset($arrGuestProjects[$currentlySelectedProjectId])) {
				$arrProject = $arrGuestProjects[$currentlySelectedProjectId];
			} else {
				// Something went wrong, but load the project record anyway
				$project = Project::findProjectById($database, $currentlySelectedProjectId);
				/* @var $project Project */
				$arrProject = $project->getData();
			}
			$currentlySelectedProjectUserCompanyId = $arrProject['user_company_id'];
			$currentlySelectedProjectName = $arrProject['project_name'];

			// Get $currentlyActiveContactId based on the $currentlySelectedProjectUserCompanyId
			if ($currentlySelectedProjectUserCompanyId == $user_company_id) {
				// Project owner case
				$currentlyActiveContactId = $this->primary_contact_id;
			} else {
				require_once('lib/common/Contact.php');
				$contact = Contact::findContactByUserCompanyIdAndUserId($database, $currentlySelectedProjectUserCompanyId, $user_id);
				/* @var $contact Contact */
				$currentlyActiveContactId = $contact->contact_id;
			}
		} else {
			// @todo What should this value be set to???
			$currentlySelectedProjectUserCompanyId = $AXIS_NON_EXISTENT_USER_COMPANY_ID;
			$currentlySelectedProjectName = '';
			$currentlyActiveContactId = $this->primary_contact_id;
		}

		$this->currentlySelectedProjectUserCompanyId = $currentlySelectedProjectUserCompanyId;
		$this->currentlySelectedProjectName = $currentlySelectedProjectName;
		$this->currentlyActiveContactId = $currentlyActiveContactId;

		// Get the currently active html_template_theme_name
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */
		/*default access for axis theme to all
		 LEFT OUTER JOIN `html_template_themes` htt ON u.`html_template_theme_id` = htt.`id`
		*/
		$query =
"
SELECT htt.`html_template_theme_name`
FROM `users` u LEFT OUTER JOIN `html_template_themes` htt ON u.`html_template_theme_id` = 2
WHERE u.`id` = ?
";
		$arrValues = array($user_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row && isset($row['html_template_theme_name']) && !empty($row['html_template_theme_name'])) {
			$currentlyActiveTemplateTheme = $row['html_template_theme_name'];
		} else {
			$currentlyActiveTemplateTheme = 'axis';
		}
		$this->currentlyActiveTemplateTheme = $currentlyActiveTemplateTheme;
	}

	public static function findUserByUUID($database, $uuidAttribute, $uuidValue)
	{
		$arrUuidAttributes = array(
			'user_id' => 'id',
			'mobile_phone_number' => 'mobile_phone_number',
			'email' => 'email',
			'password_guid' => 'password_guid',
			'primary_contact_id' => 'primary_contact_id',
			'screen_name' => 'screen_name',
		);

		if (isset($arrUuidAttributes[$uuidAttribute])) {
			$attribute = $arrUuidAttributes[$uuidAttribute];
		} else {
			throw new Exception('Invalid UUID for users.');
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT u.*
FROM `users` u
WHERE u.`$attribute` = ?
AND u.`$attribute` IS NOT NULL
";
		$arrValues = array($uuidValue);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row && !empty($row)) {
			$user_id = $row['id'];
			$user = new User($database);
			$user->setId($user_id);
			$key = array('id' => $user_id);
			$user->setKey($key);
			$user->setData($row);
			$user->convertDataToProperties();

			return $user;
		} else {
			return false;
		}

		return false;
	}

	public static function findUserById($database, $user_id, $loadUserInfo=false)
	{
		$user = self::findUserByUUID($database, 'user_id', $user_id);
		/* @var $user User */

		if ($user) {
			if ($loadUserInfo) {
				$user->loadUserInfo();
			}
			return $user;
		} else {
			return false;
		}

		return false;
	}

	/**
	 * Load a users record if the contact_id passed in is the primary_contact_id for a record in the users table.
	 *
	 * @param string $database
	 * @param int $contact_id
	 * @return mixed
	 */
	public static function findUserByPrimaryContactId($database, $contact_id, $loadUserInfo=false)
	{
		$user = self::findUserByUUID($database, 'primary_contact_id', $contact_id);
		/* @var $user User */

		if ($user) {
			if ($loadUserInfo) {
				$user->loadUserInfo();
			}
			return $user;
		} else {
			return false;
		}

		return false;
	}

	public static function findUserByPasswordGuidAuthentication($database, $password_guid, $loadUserInfo=false)
	{
		$user = self::findUserByUUID($database, 'password_guid', $password_guid);
		/* @var $user User */

		if ($user) {
			self::recordUserLogin($database, $user->user_id);
			if ($loadUserInfo) {
				$user->loadUserInfo();
			}
			return $user;
		} else {
			return false;
		}

		return false;
	}

	public static function findUserIsArchive($database, $user_id){
		$db = DBI::getInstance($database);
		$query =
"
SELECT `is_archive`
FROM `users`
WHERE `id` = ?
";
		$arrValues = array($user_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row['is_archive'] == 'Y') {
			return true;
		} else {
			return false;
		}
	}

	public static function findUserByEmailAuthentication($database, $email, $password, $sessionSalt, $loadUserInfo=false)
	{
		$user = self::findUserByUUID($database, 'email', $email);
		/* @var $user User */

		if ($user) {
			// Authenticate user
			// Verify password
			// later may add session salt, etc.
			$storedPasswordHash = $user->password_hash;
			$passwordVerifiedFlag = User::verifyPassword($password, $storedPasswordHash);

			if ($passwordVerifiedFlag) {
				self::recordUserLogin($database, $user->user_id);
				if ($loadUserInfo) {
					$user->loadUserInfo();
				}
				return $user;
			} else {
				return false;
			}

		} else {
			return false;
		}

		return false;
	}

	public static function findUserByPWDGuidAuthentication($database, $token, $loadUserInfo=false)
	{
		$user = self::findUserByUUID($database, 'password_guid', $token);
		/* @var $user User */

		if ($user) {
			// Authenticate user
			// Verify password
			// later may add session salt, etc.
			$storedPasswordHash = $user->password_hash;
			/*$passwordVerifiedFlag = User::verifyPassword($password, $storedPasswordHash);*/

			// if ($passwordVerifiedFlag) {
				self::recordUserLogin($database, $user->user_id);
				if ($loadUserInfo) {
					$user->loadUserInfo();
				}
				return $user;
			// } else {
				// return false;
			// }

		} else {
			return false;
		}

		return false;
	}

	public static function findUserByMobilePhoneNumberAuthentication($database, $mobile_phone_number, $password, $sessionSalt, $loadUserInfo=false)
	{
		$user = self::findUserByUUID($database, 'mobile_phone_number', $mobile_phone_number);
		/* @var $user User */

		if ($user) {
			// Authenticate user
			// Verify password
			// later may add session salt, etc.
			$storedPasswordHash = $user->password_hash;
			$passwordVerifiedFlag = User::verifyPassword($password, $storedPasswordHash);

			if ($passwordVerifiedFlag) {
				self::recordUserLogin($database, $user->user_id);
				if ($loadUserInfo) {
					$user->loadUserInfo();
				}
				return $user;
			} else {
				return false;
			}

		} else {
			return false;
		}

		return false;
	}

	/**
	 * Retrieve a user_id value from Users GUIDs
	 */
	public static function findPasswordHashByEmail($database, $email) {
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT `password_hash`
FROM `users`
WHERE `email` = ?
";
		$arrValues = array($email);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row && isset($row['password_hash'])) {
			$formattedPasswordHash = $row['password_hash'];
			require_once('lib/common/PasswordHash.php');
			$passwordHash = PasswordHash::findPasswordHashByFormattedPasswordHash($formattedPasswordHash);
			return $passwordHash;
		} else {
			return null;
		}

		return null;
	}

	/**
	 * Retrieve a user_id value from Users GUIDs
	 */
	public static function findPasswordHashSaltByEmail($database, $email) {
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT `password_hash`
FROM `users`
WHERE `email` = ?
";
		$arrValues = array($email);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row && isset($row['password_hash'])) {
			$formattedPasswordHash = $row['password_hash'];
			require_once('lib/common/PasswordHash.php');
			$passwordHash = PasswordHash::findPasswordHashByFormattedPasswordHash($formattedPasswordHash);
			/* @var $passwordHash PasswordHash */
			$salt = $passwordHash->getSaltHex();
		} else {
			$salt = null;
		}

		return $salt;
	}

	public static function recordUserLogin($database, $user_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// UPDATE accesses timestamp
		$query =
"
UPDATE `users`
SET `accessed` = null
WHERE `id` = ?
";
		$arrValues = array($user_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$db->free_result();

		return;
	}

	public static function finduserByPassGuide($database,$contact_id)
	{
		$db = DBI::getInstance($database);
		$typeQuery = "SELECT `password_guid` FROM `users` WHERE `primary_contact_id` = ?";
		$arrValues = array($contact_id);
		$db->execute($typeQuery, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$userPassGuide=$row['password_guid'];
		$db->free_result();
		return $userPassGuide;
	}

	public static function sessionGet()
	{
		$session = Zend_Registry::get('session');
		/* @var $session Session */
		$dataSerialized = $session->getValue('User');
		$data = unserialize($dataSerialized);
		$database = $data['database'];
		$u = new User($database);
		$u->setData($data);
		$u->convertDataToProperties();
		return $u;
	}

	public static function sessionPut($u)
	{
		$data = $u->getData();
		$dataSerialized = serialize($data);
		$session = Zend_Registry::get('session');
		/* @var $session Session */
		$session->setValue('User', $dataSerialized);
	}

	public static function sessionClear()
	{
		$session = Zend_Registry::get('session');
		/* @var $session Session */
		$session->clearValue('User');
	}
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

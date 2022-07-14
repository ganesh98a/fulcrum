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
 * Contact.
 *
 * @category   Framework
 * @package    Contact
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');
require_once('lib/common/Project.php');

class Contact extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'Contact';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'contacts';

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
	 * unique index `unique_contact` (`user_company_id`,`contact_company_id`,`email`,`first_name`,`last_name`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_contact' => array(
			'user_company_id' => 'int',
			'contact_company_id' => 'int',
			'email' => 'string',
			'first_name' => 'string',
			'last_name' => 'string'
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
		'id' => 'contact_id',

		'user_company_id' => 'user_company_id',
		'user_id' => 'user_id',
		'contact_company_id' => 'contact_company_id',

		'email' => 'email',
		//'full_name' => 'full_name',

		'name_prefix' => 'name_prefix',
		'first_name' => 'first_name',
		'additional_name' => 'additional_name',
		'middle_name' => 'middle_name',
		'last_name' => 'last_name',

		'name_suffix' => 'name_suffix',
		'title' => 'title',
		'vendor_flag' => 'vendor_flag',
		'is_archive' => 'is_archive'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $contact_id;

	public $user_company_id;
	public $user_id;
	public $contact_company_id;

	public $email;
	public $name_prefix;
	public $first_name;
	public $additional_name;
	public $middle_name;
	public $last_name;

	public $name_suffix;
	public $title;
	public $vendor_flag;
	public $is_archive;

	// Other Properties
	//protected $_otherPropertyHere;
	protected $_officeList;
	protected $_phoneNumberList;

	protected $_parentUserCompanyProjectsAndRoles;
	protected $_parentUserCompanyProjectsByAdHoc;

	private $_contactFullName;
	private $_contactFullNameHtmlEscaped;

	private $_contactFullNameWithEmail;
	private $_contactFullNameWithEmailHtmlEscaped;

	private $_arrRoleIdsByProjectId;

	// HTML ENTITY ENCODED ORM string properties
	public $escaped_email;
	public $escaped_name_prefix;
	public $escaped_first_name;
	public $escaped_additional_name;
	public $escaped_middle_name;
	public $escaped_last_name;
	public $escaped_name_suffix;
	public $escaped_title;
	public $escaped_is_archive;

	// HTML ENTITY ENCODED NL2BR ORM string properties
	public $escaped_email_nl2br;
	public $escaped_name_prefix_nl2br;
	public $escaped_first_name_nl2br;
	public $escaped_additional_name_nl2br;
	public $escaped_middle_name_nl2br;
	public $escaped_last_name_nl2br;
	public $escaped_name_suffix_nl2br;
	public $escaped_title_nl2br;

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)
	protected static $_arrContactsByUserCompanyId;
	protected static $_arrContactsByUserId;
	protected static $_arrContactsByContactCompanyId;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)
	protected static $_arrContactsByEmail;
	protected static $_arrContactsByFullName;
	protected static $_arrContactsByFirstNameAndMiddleNameAndLastName;
	protected static $_arrContactsByLastName;

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)
	protected static $_arrContactsByFirstName;

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllContacts;

	// Foreign Key Objects
	private $_userCompany;
	private $_user;
	private $_contactCompany;
	private $_mobilePhoneNumber;
	private $_userInvitation;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='contacts')
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

	public function getContactCompany()
	{
		if (isset($this->_contactCompany)) {
			return $this->_contactCompany;
		} else {
			return null;
		}
	}

	public function setContactCompany($contactCompany)
	{
		$this->_contactCompany = $contactCompany;
	}

	/**
	 * @todo Refactor this whole method to allow many cell phone numbers per contact???
	 *
	 * @return MobilePhoneNumber mobile_phone_number
	 */
	public function getMobilePhoneNumber()
	{
		if (!isset($this->_mobilePhoneNumber) || !($this->_mobilePhoneNumber instanceof MobilePhoneNumber)) {
			$mobilePhoneNumber = $this->loadMobilePhoneNumber();
			$this->_mobilePhoneNumber = $mobilePhoneNumber;
		}

		return $this->_mobilePhoneNumber;
	}

	public function setMobilePhoneNumber($mobilePhoneNumber)
	{
		$this->_mobilePhoneNumber = $mobilePhoneNumber;
	}

	public function getUserInvitation()
	{
		if (isset($this->_userInvitation)) {
			return $this->_userInvitation;
		} else {
			return null;
		}
	}

	public function setUserInvitation($userInvitation)
	{
		$this->_userInvitation = $userInvitation;
	}

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)
	public static function getArrContactsByUserCompanyId()
	{
		if (isset(self::$_arrContactsByUserCompanyId)) {
			return self::$_arrContactsByUserCompanyId;
		} else {
			return null;
		}
	}

	public static function setArrContactsByUserCompanyId($arrContactsByUserCompanyId)
	{
		self::$_arrContactsByUserCompanyId = $arrContactsByUserCompanyId;
	}

	public static function getArrContactsByUserId()
	{
		if (isset(self::$_arrContactsByUserId)) {
			return self::$_arrContactsByUserId;
		} else {
			return null;
		}
	}

	public static function setArrContactsByUserId($arrContactsByUserId)
	{
		self::$_arrContactsByUserId = $arrContactsByUserId;
	}

	public static function getArrContactsByContactCompanyId()
	{
		if (isset(self::$_arrContactsByContactCompanyId)) {
			return self::$_arrContactsByContactCompanyId;
		} else {
			return null;
		}
	}

	public static function setArrContactsByContactCompanyId($arrContactsByContactCompanyId)
	{
		self::$_arrContactsByContactCompanyId = $arrContactsByContactCompanyId;
	}

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)
	public static function getArrContactsByEmail()
	{
		if (isset(self::$_arrContactsByEmail)) {
			return self::$_arrContactsByEmail;
		} else {
			return null;
		}
	}

	public static function setArrContactsByEmail($arrContactsByEmail)
	{
		self::$_arrContactsByEmail = $arrContactsByEmail;
	}

	public static function getArrContactsByFullName()
	{
		if (isset(self::$_arrContactsByFullName)) {
			return self::$_arrContactsByFullName;
		} else {
			return null;
		}
	}

	public static function setArrContactsByFullName($arrContactsByFullName)
	{
		self::$_arrContactsByFullName = $arrContactsByFullName;
	}

	public static function getArrContactsByFirstNameAndMiddleNameAndLastName()
	{
		if (isset(self::$_arrContactsByFirstNameAndMiddleNameAndLastName)) {
			return self::$_arrContactsByFirstNameAndMiddleNameAndLastName;
		} else {
			return null;
		}
	}

	public static function setArrContactsByFirstNameAndMiddleNameAndLastName($arrContactsByFirstNameAndMiddleNameAndLastName)
	{
		self::$_arrContactsByFirstNameAndMiddleNameAndLastName = $arrContactsByFirstNameAndMiddleNameAndLastName;
	}

	public static function getArrContactsByLastName()
	{
		if (isset(self::$_arrContactsByLastName)) {
			return self::$_arrContactsByLastName;
		} else {
			return null;
		}
	}

	public static function setArrContactsByLastName($arrContactsByLastName)
	{
		self::$_arrContactsByLastName = $arrContactsByLastName;
	}

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)
	public static function getArrContactsByFirstName()
	{
		if (isset(self::$_arrContactsByFirstName)) {
			return self::$_arrContactsByFirstName;
		} else {
			return null;
		}
	}

	public static function setArrContactsByFirstName($arrContactsByFirstName)
	{
		self::$_arrContactsByFirstName = $arrContactsByFirstName;
	}

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllContacts()
	{
		if (isset(self::$_arrAllContacts)) {
			return self::$_arrAllContacts;
		} else {
			return null;
		}
	}

	public static function setArrAllContacts($arrAllContacts)
	{
		self::$_arrAllContacts = $arrAllContacts;
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

	public function getRoles()
	{
		if (isset($this->_roles)) {
			return $this->_roles;
		} else {
			return array();
		}
	}

	/**
	 * Pass in a list of role_id => roleObject
	 *
	 * @param array $arrRoles
	 */
	public function setRoles($arrRoles)
	{
		$this->_roles = $arrRoles;
	}

	public function getParentUserCompanyProjectsAndRoles()
	{
		if (isset($this->_parentUserCompanyProjectsAndRoles)) {
			return $this->_parentUserCompanyProjectsAndRoles;
		} else {
			return array();
		}
	}

	public function setParentUserCompanyProjectsAndRoles($arrParentUserCompanyProjectsAndRoles)
	{
		$this->_parentUserCompanyProjectsAndRoles = $arrParentUserCompanyProjectsAndRoles;
	}

	/**
	 * This formats a "Contact Full Name" value from:
	 *
	 * first_name
	 * additional_name
	 * middle_name
	 * last_name
	 *
	 * @return unknown
	 */
	public function getContactFullName($includeCompanyName=false, $format='-')
	{
		$contactFullName = $this->_contactFullName;

		if (isset($contactFullName) && !empty($contactFullName)) {
			return $contactFullName;
		}

		$arrFullName = array();

		$first_name = $this->first_name;
		if (isset($first_name) && !empty($first_name)) {
			$arrFullName[] = $first_name;
		}

		$additional_name = $this->additional_name;
		if (isset($additional_name) && !empty($additional_name)) {
			$arrFullName[] = $additional_name;
		}

		$middle_name = $this->middle_name;
		if (isset($middle_name) && !empty($middle_name)) {
			$arrFullName[] = $middle_name;
		}

		$last_name = $this->last_name;
		if (isset($last_name) && !empty($last_name)) {
			$arrFullName[] = $last_name;
		}

		if (!empty($arrFullName)) {
			$contactFullName = join(' ', $arrFullName);
		}

		if (empty($contactFullName)) {
			$email = $this->email;
			if (isset($email) && !empty($email)) {
				$contactFullName = $email;
			}
		}

		$contactFullName = Data::singleSpace($contactFullName);

		if ($includeCompanyName) {
			$contactCompany = $this->getContactCompany();
			/* @var $contactCompany ContactCompany */

			if (isset($contactCompany) && $contactCompany) {
				$contact_company_name = $contactCompany->contact_company_name;

				if ($format == '-') {
					$contactFullName .= ' - ' . $contact_company_name;
				} else {
					$contactFullName .= ' (' . $contact_company_name . ')';
				}
			}
		}

		$is_archive = $this->is_archive;
		if (isset($is_archive) && !empty($is_archive) && $is_archive == 'Y') {
			$contactFullName .= ' (Archived)';
		}

		$this->_contactFullName = $contactFullName;

		return $contactFullName;
	}

	public function getContactFullNameHtmlEscaped($includeCompanyName=false, $format='-')
	{
		$contactFullNameHtmlEscaped = $this->_contactFullNameHtmlEscaped;

		if (isset($contactFullNameHtmlEscaped) && !empty($contactFullNameHtmlEscaped)) {
			return $contactFullNameHtmlEscaped;
		}

		$htmlEntityPropertiesEscapedFlag = $this->getHtmlEntityPropertiesEscapedFlag();
		if (!$htmlEntityPropertiesEscapedFlag) {
			$this->htmlEntityEscapeProperties();
		}

		$arrFullName = array();

		$first_name = $this->escaped_first_name;
		if (isset($first_name) && !empty($first_name)) {
			$arrFullName[] = $first_name;
		}

		$additional_name = $this->escaped_additional_name;
		if (isset($additional_name) && !empty($additional_name)) {
			$arrFullName[] = $additional_name;
		}

		$middle_name = $this->escaped_middle_name;
		if (isset($middle_name) && !empty($middle_name)) {
			$arrFullName[] = $middle_name;
		}

		$last_name = $this->escaped_last_name;
		if (isset($last_name) && !empty($last_name)) {
			$arrFullName[] = $last_name;
		}

		if (!empty($arrFullName)) {
			$contactFullNameHtmlEscaped = join(' ', $arrFullName);
		}

		if (empty($contactFullNameHtmlEscaped)) {
			$email = $this->escaped_email;
			if (isset($email) && !empty($email)) {
				$contactFullNameHtmlEscaped = $email;
			}
		}

		$contactFullNameHtmlEscaped = Data::singleSpace($contactFullNameHtmlEscaped);

		if ($includeCompanyName) {
			$contactCompany = $this->getContactCompany();
			/* @var $contactCompany ContactCompany */

			if (isset($contactCompany) && $contactCompany) {
				$contactCompany->htmlEntityEscapeProperties();
				$escaped_contact_company_name = $contactCompany->escaped_contact_company_name;

				if ($format == '-') {
					$contactFullNameHtmlEscaped .= ' - ' . $escaped_contact_company_name;
				} else {
					$contactFullNameHtmlEscaped .= ' (' . $escaped_contact_company_name . ')';
				}
			}
		}

		$is_archive = $this->escaped_is_archive;
		if (isset($is_archive) && !empty($is_archive) && $is_archive == 'Y') {
			$contactFullNameHtmlEscaped .= ' (Archived)';
		}

		$this->_contactFullNameHtmlEscaped = $contactFullNameHtmlEscaped;

		return $contactFullNameHtmlEscaped;
	}

	public function getContactFullEmail()
	{
		$contactFullNameHtmlEscaped = $this->_contactFullNameHtmlEscaped;

		if (isset($contactFullNameHtmlEscaped) && !empty($contactFullNameHtmlEscaped)) {
			return $contactFullNameHtmlEscaped;
		}

		$htmlEntityPropertiesEscapedFlag = $this->getHtmlEntityPropertiesEscapedFlag();
		if (!$htmlEntityPropertiesEscapedFlag) {
			$this->htmlEntityEscapeProperties();
		}

		if (empty($contactFullNameHtmlEscaped)) {
			$email = $this->escaped_email;
			if (isset($email) && !empty($email)) {
				$contactFullNameHtmlEscaped = $email;
			}
		}

		$contactFullNameHtmlEscaped = Data::singleSpace($contactFullNameHtmlEscaped);

		$is_archive = $this->escaped_is_archive;
		if (isset($is_archive) && !empty($is_archive) && $is_archive == 'Y') {
			$contactFullNameHtmlEscaped .= ' (Archived)';
		}

		$this->_contactFullNameHtmlEscaped = $contactFullNameHtmlEscaped;

		return $contactFullNameHtmlEscaped;
	}

	public function getContactFullNameWithEmail($includeCompanyName=false, $emailFormat = '<', $companyNameFormat='-')
	{
		$arrFullName = array();

		$first_name = $this->first_name;
		if (isset($first_name) && !empty($first_name)) {
			$arrFullName[] = $first_name;
		}

		$additional_name = $this->additional_name;
		if (isset($additional_name) && !empty($additional_name)) {
			$arrFullName[] = $additional_name;
		}

		$middle_name = $this->middle_name;
		if (isset($middle_name) && !empty($middle_name)) {
			$arrFullName[] = $middle_name;
		}

		$last_name = $this->last_name;
		if (isset($last_name) && !empty($last_name)) {
			$arrFullName[] = $last_name;
		}

		if (!empty($arrFullName)) {
			$contactFullNameWithEmail = join(' ', $arrFullName);
		} else {
			$contactFullNameWithEmail = '';
		}

		$email = $this->email;
		if (isset($email) && !empty($email)) {
			if (empty($contactFullNameWithEmail)) {
				$contactFullNameWithEmail = $email;
			} else {
				if ($emailFormat == '<') {
					$contactFullNameWithEmail .= " <$email>";
				}
			}
			$contactFullNameWithEmail = Data::singleSpace($contactFullNameWithEmail);
		} else {
			$contactFullNameWithEmail = '';
		}

		if ($includeCompanyName) {
			$contactCompany = $this->getContactCompany();
			if (isset($contactCompany) && $contactCompany) {
				$contact_company_name = $contactCompany->contact_company_name;

				if ($companyNameFormat == '-') {
					$contactFullNameWithEmail .= ' - ' . $contact_company_name;
				} else {
					$contactFullNameWithEmail .= ' (' . $contact_company_name . ')';
				}
			}
		}

		$this->_contactFullNameWithEmail = $contactFullNameWithEmail;

		return $contactFullNameWithEmail;
	}

	public function getArrRoleIdsByProjectId()
	{
		if (isset($this->_arrRoleIdsByProjectId)) {
			return $this->_arrRoleIdsByProjectId;
		} else {
			return null;
		}
	}

	public function setArrRoleIdsByProjectId($arrRoleIdsByProjectId)
	{
		$this->_arrRoleIdsByProjectId = $arrRoleIdsByProjectId;
	}

	// Finder: Find By pk (a single auto int id or a single non auto int pk)
	/**
	 * PHP < 5.3.0
	 *
	 * @param string $database
	 * @param int $contact_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findById($database, $contact_id, $table='contacts', $module='Contact')
	{
		$contact = parent::findById($database, $contact_id, $table, $module);

		return $contact;
	}

	// To get the role id form user id

	public static function findRoleId($database, $contact_id){

		$contact_id = (int) $contact_id;

		$db = DBI::getInstance($database);
		$db->free_result();
		$query ="SELECT `role_id` FROM `users` WHERE `id` = ? ";
		$arrValues = array($contact_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$roleId = $row['role_id'];
		$db->free_result();
		return $roleId;
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Similar to FindById, but with SQL as starter code for more complex joins.
	 *
	 * @param string $database
	 * @param int $contact_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findContactByIdExtended($database, $contact_id)
	{
		$contact_id = (int) $contact_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */
		$db->free_result();
		$query =
"
SELECT

	c_fk_uc.`id` AS 'c_fk_uc__user_company_id',
	c_fk_uc.`company` AS 'c_fk_uc__company',
	c_fk_uc.`primary_phone_number` AS 'c_fk_uc__primary_phone_number',
	c_fk_uc.`employer_identification_number` AS 'c_fk_uc__employer_identification_number',
	c_fk_uc.`construction_license_number` AS 'c_fk_uc__construction_license_number',
	c_fk_uc.`construction_license_number_expiration_date` AS 'c_fk_uc__construction_license_number_expiration_date',
	c_fk_uc.`paying_customer_flag` AS 'c_fk_uc__paying_customer_flag',

	c_fk_u.`id` AS 'c_fk_u__user_id',
	c_fk_u.`user_company_id` AS 'c_fk_u__user_company_id',
	c_fk_u.`role_id` AS 'c_fk_u__role_id',
	c_fk_u.`default_project_id` AS 'c_fk_u__default_project_id',
	c_fk_u.`primary_contact_id` AS 'c_fk_u__primary_contact_id',
	c_fk_u.`mobile_network_carrier_id` AS 'c_fk_u__mobile_network_carrier_id',
	c_fk_u.`user_image_id` AS 'c_fk_u__user_image_id',
	c_fk_u.`security_image_id` AS 'c_fk_u__security_image_id',
	c_fk_u.`html_template_theme_id` AS 'c_fk_u__html_template_theme_id',
	c_fk_u.`mobile_phone_number` AS 'c_fk_u__mobile_phone_number',
	c_fk_u.`screen_name` AS 'c_fk_u__screen_name',
	c_fk_u.`email` AS 'c_fk_u__email',
	c_fk_u.`password_hash` AS 'c_fk_u__password_hash',
	c_fk_u.`password_guid` AS 'c_fk_u__password_guid',
	c_fk_u.`security_phrase` AS 'c_fk_u__security_phrase',
	c_fk_u.`modified` AS 'c_fk_u__modified',
	c_fk_u.`accessed` AS 'c_fk_u__accessed',
	c_fk_u.`created` AS 'c_fk_u__created',
	c_fk_u.`alerts` AS 'c_fk_u__alerts',
	c_fk_u.`tc_accepted_flag` AS 'c_fk_u__tc_accepted_flag',
	c_fk_u.`email_subscribe_flag` AS 'c_fk_u__email_subscribe_flag',
	c_fk_u.`remember_me_flag` AS 'c_fk_u__remember_me_flag',
	c_fk_u.`change_password_flag` AS 'c_fk_u__change_password_flag',
	c_fk_u.`disabled_flag` AS 'c_fk_u__disabled_flag',
	c_fk_u.`deleted_flag` AS 'c_fk_u__deleted_flag',

	c_fk_cc.`id` AS 'c_fk_cc__contact_company_id',
	c_fk_cc.`user_user_company_id` AS 'c_fk_cc__user_user_company_id',
	c_fk_cc.`contact_user_company_id` AS 'c_fk_cc__contact_user_company_id',
	c_fk_cc.`company` AS 'c_fk_cc__company',
	c_fk_cc.`primary_phone_number` AS 'c_fk_cc__primary_phone_number',
	c_fk_cc.`employer_identification_number` AS 'c_fk_cc__employer_identification_number',
	c_fk_cc.`construction_license_number` AS 'c_fk_cc__construction_license_number',
	c_fk_cc.`construction_license_number_expiration_date` AS 'c_fk_cc__construction_license_number_expiration_date',
	c_fk_cc.`vendor_flag` AS 'c_fk_cc__vendor_flag',

	c.*

FROM `contacts` c
	INNER JOIN `user_companies` c_fk_uc ON c.`user_company_id` = c_fk_uc.`id`
	INNER JOIN `users` c_fk_u ON c.`user_id` = c_fk_u.`id`
	INNER JOIN `contact_companies` c_fk_cc ON c.`contact_company_id` = c_fk_cc.`id`
WHERE c.`id` = ?
";
		$arrValues = array($contact_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$contact_id = $row['id'];
			$contact = self::instantiateOrm($database, 'Contact', $row, null, $contact_id);
			/* @var $contact Contact */
			$contact->convertPropertiesToData();

			if (isset($row['user_company_id'])) {
				$user_company_id = $row['user_company_id'];
				$row['c_fk_uc__id'] = $user_company_id;
				$userCompany = self::instantiateOrm($database, 'UserCompany', $row, null, $user_company_id, 'c_fk_uc__');
				/* @var $userCompany UserCompany */
				$userCompany->convertPropertiesToData();
			} else {
				$userCompany = false;
			}
			$contact->setUserCompany($userCompany);

			if (isset($row['user_id'])) {
				$user_id = $row['user_id'];
				$row['c_fk_u__id'] = $user_id;
				$user = self::instantiateOrm($database, 'User', $row, null, $user_id, 'c_fk_u__');
				/* @var $user User */
				$user->convertPropertiesToData();
			} else {
				$user = false;
			}
			$contact->setUser($user);

			if (isset($row['contact_company_id'])) {
				$contact_company_id = $row['contact_company_id'];
				$row['c_fk_cc__id'] = $contact_company_id;
				$contactCompany = self::instantiateOrm($database, 'ContactCompany', $row, null, $contact_company_id, 'c_fk_cc__');
				/* @var $contactCompany ContactCompany */
				$contactCompany->convertPropertiesToData();
			} else {
				$contactCompany = false;
			}
			$contact->setContactCompany($contactCompany);

			return $contact;
		} else {
			return false;
		}
	}

	// Finders: Find By Unique Index
	/**
	 * Find by unique index `unique_contact` (`user_company_id`,`contact_company_id`,`email`,`first_name`,`last_name`).
	 *
	 * @param string $database
	 * @param int $user_company_id
	 * @param int $contact_company_id
	 * @param string $email
	 * @param string $first_name
	 * @param string $last_name
	 * @return mixed (single ORM object | false)
	 */
	public static function findByUserCompanyIdAndContactCompanyIdAndEmailAndFirstNameAndLastName($database, $user_company_id, $contact_company_id, $email, $first_name, $last_name)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	c.*

FROM `contacts` c
WHERE c.`user_company_id` = ?
AND c.`contact_company_id` = ?
AND c.`email` = ?
AND c.`first_name` = ?
AND c.`last_name` = ?
";
		$arrValues = array($user_company_id, $contact_company_id, $email, $first_name, $last_name);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if ($row && !empty($row)) {
			$contact_id = $row['id'];
			$contact = self::instantiateOrm($database, 'Contact', $row, null, $contact_id);
			/* @var $contact Contact */
			return $contact;
		} else {
			return false;
		}
	}

	// Loaders: Load By pk List (list of auto int ids or other non auto int pk list)
	/**
	 * Load zero or more records by an id list (array of auto int primary keys).
	 *
	 * @param string $database
	 * @param array $arrContactIds
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadContactsByArrContactIds($database, $arrContactIds, Input $options=null)
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
		// ORDER BY `id` ASC, `user_company_id` ASC, `user_id` ASC, `contact_company_id` ASC, `email` ASC, `name_prefix` ASC, `first_name` ASC, `additional_name` ASC, `middle_name` ASC, `last_name` ASC, `name_suffix` ASC, `title` ASC, `vendor_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpContact = new Contact($database);
			$sqlOrderByColumns = $tmpContact->constructSqlOrderByColumns($arrOrderByAttributes);

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

	c_fk_uc.`id` AS 'c_fk_uc__user_company_id',
	c_fk_uc.`company` AS 'c_fk_uc__company',
	c_fk_uc.`primary_phone_number` AS 'c_fk_uc__primary_phone_number',
	c_fk_uc.`employer_identification_number` AS 'c_fk_uc__employer_identification_number',
	c_fk_uc.`construction_license_number` AS 'c_fk_uc__construction_license_number',
	c_fk_uc.`construction_license_number_expiration_date` AS 'c_fk_uc__construction_license_number_expiration_date',
	c_fk_uc.`paying_customer_flag` AS 'c_fk_uc__paying_customer_flag',

	c_fk_u.`id` AS 'c_fk_u__user_id',
	c_fk_u.`user_company_id` AS 'c_fk_u__user_company_id',
	c_fk_u.`role_id` AS 'c_fk_u__role_id',
	c_fk_u.`default_project_id` AS 'c_fk_u__default_project_id',
	c_fk_u.`primary_contact_id` AS 'c_fk_u__primary_contact_id',
	c_fk_u.`mobile_network_carrier_id` AS 'c_fk_u__mobile_network_carrier_id',
	c_fk_u.`user_image_id` AS 'c_fk_u__user_image_id',
	c_fk_u.`security_image_id` AS 'c_fk_u__security_image_id',
	c_fk_u.`html_template_theme_id` AS 'c_fk_u__html_template_theme_id',
	c_fk_u.`mobile_phone_number` AS 'c_fk_u__mobile_phone_number',
	c_fk_u.`screen_name` AS 'c_fk_u__screen_name',
	c_fk_u.`email` AS 'c_fk_u__email',
	c_fk_u.`password_hash` AS 'c_fk_u__password_hash',
	c_fk_u.`password_guid` AS 'c_fk_u__password_guid',
	c_fk_u.`security_phrase` AS 'c_fk_u__security_phrase',
	c_fk_u.`modified` AS 'c_fk_u__modified',
	c_fk_u.`accessed` AS 'c_fk_u__accessed',
	c_fk_u.`created` AS 'c_fk_u__created',
	c_fk_u.`alerts` AS 'c_fk_u__alerts',
	c_fk_u.`tc_accepted_flag` AS 'c_fk_u__tc_accepted_flag',
	c_fk_u.`email_subscribe_flag` AS 'c_fk_u__email_subscribe_flag',
	c_fk_u.`remember_me_flag` AS 'c_fk_u__remember_me_flag',
	c_fk_u.`change_password_flag` AS 'c_fk_u__change_password_flag',
	c_fk_u.`disabled_flag` AS 'c_fk_u__disabled_flag',
	c_fk_u.`deleted_flag` AS 'c_fk_u__deleted_flag',

	c_fk_cc.`id` AS 'c_fk_cc__contact_company_id',
	c_fk_cc.`user_user_company_id` AS 'c_fk_cc__user_user_company_id',
	c_fk_cc.`contact_user_company_id` AS 'c_fk_cc__contact_user_company_id',
	c_fk_cc.`company` AS 'c_fk_cc__company',
	c_fk_cc.`primary_phone_number` AS 'c_fk_cc__primary_phone_number',
	c_fk_cc.`employer_identification_number` AS 'c_fk_cc__employer_identification_number',
	c_fk_cc.`construction_license_number` AS 'c_fk_cc__construction_license_number',
	c_fk_cc.`construction_license_number_expiration_date` AS 'c_fk_cc__construction_license_number_expiration_date',
	c_fk_cc.`vendor_flag` AS 'c_fk_cc__vendor_flag',

	ui.`id` AS 'ui__user_invitation_id',
	ui.`user_id` AS 'ui__user_id',
	ui.`contact_id` AS 'ui__contact_id',
	ui.`project_id` AS 'ui__project_id',
	ui.`user_invitation_type_id` AS 'ui__user_invitation_type_id',
	ui.`guid` AS 'ui__guid',
	ui.`contact_user_company_id` AS 'ui__contact_user_company_id',
	ui.`employer_identification_number` AS 'ui__employer_identification_number',
	ui.`created` AS 'ui__created',
	ui.`user_invitation_expiration_timestamp` AS 'ui__user_invitation_expiration_timestamp',

	c.*

FROM `contacts` c
	INNER JOIN `user_companies` c_fk_uc ON c.`user_company_id` = c_fk_uc.`id`
	INNER JOIN `users` c_fk_u ON c.`user_id` = c_fk_u.`id`
	INNER JOIN `contact_companies` c_fk_cc ON c.`contact_company_id` = c_fk_cc.`id`

	LEFT OUTER JOIN `user_invitations` ui ON c.`id` = ui.`contact_id`
WHERE c.`id` IN ($csvContactIds){$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrContactsByCsvContactIds = array();
		while ($row = $db->fetch()) {
			$contact_id = $row['id'];
			$contact = self::instantiateOrm($database, 'Contact', $row, null, $contact_id);
			/* @var $contact Contact */
			$contact->convertPropertiesToData();

			if (isset($row['user_company_id'])) {
				$user_company_id = $row['user_company_id'];
				$row['c_fk_uc__id'] = $user_company_id;
				$userCompany = self::instantiateOrm($database, 'UserCompany', $row, null, $user_company_id, 'c_fk_uc__');
				/* @var $userCompany UserCompany */
				$userCompany->convertPropertiesToData();
			} else {
				$userCompany = false;
			}
			$contact->setUserCompany($userCompany);

			if (isset($row['user_id'])) {
				$user_id = $row['user_id'];
				$row['c_fk_u__id'] = $user_id;
				$user = self::instantiateOrm($database, 'User', $row, null, $user_id, 'c_fk_u__');
				/* @var $user User */
				$user->convertPropertiesToData();
			} else {
				$user = false;
			}
			$contact->setUser($user);

			if (isset($row['contact_company_id'])) {
				$contact_company_id = $row['contact_company_id'];
				$row['c_fk_cc__id'] = $contact_company_id;
				$contactCompany = self::instantiateOrm($database, 'ContactCompany', $row, null, $contact_company_id, 'c_fk_cc__');
				/* @var $contactCompany ContactCompany */
				$contactCompany->convertPropertiesToData();
			} else {
				$contactCompany = false;
			}
			$contact->setContactCompany($contactCompany);

			if (isset($row['user_invitation_id'])) {
				$user_invitation_id = $row['user_invitation_id'];
				$row['ui__id'] = $user_invitation_id;
				$userInvitation = self::instantiateOrm($database, 'UserInvitation', $row, null, $user_invitation_id, 'ui__');
				/* @var $userInvitation UserInvitation */
				$userInvitation->convertPropertiesToData();
			} else {
				$userInvitation = false;
			}
			$contact->setUserInvitation($userInvitation);

			$arrContactsByCsvContactIds[$contact_id] = $contact;
		}

		$db->free_result();

		return $arrContactsByCsvContactIds;
	}
	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `contacts_fk_uc` foreign key (`user_company_id`) references `user_companies` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $user_company_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadContactsBycostcodeandUserCompanyId($database, $user_company_id,$costcode, $project_id,Input $options=null)
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

		/*
		$cache = Zend_Registry::get('cache');
		$cacheKey = 'Contact_loadContactsByUserCompanyId_' . $user_company_id;
		$arrContactsByUserCompanyId = $cache->load($cacheKey);
		if ($arrContactsByUserCompanyId) {
			return $arrContactsByUserCompanyId;
		}
		*/

		if ($forceLoadFlag) {
			self::$_arrContactsByUserCompanyId = null;
		}

		$arrContactsByUserCompanyId = self::$_arrContactsByUserCompanyId;
		if (isset($arrContactsByUserCompanyId) && !empty($arrContactsByUserCompanyId)) {
			return $arrContactsByUserCompanyId;
		}

		$user_company_id = (int) $user_company_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */
		//to get the cost code
		 $query1 = "SELECT group_concat(subcontract_vendor_contact_id ) as vendor_id FROM `subcontracts` WHERE `gc_budget_line_item_id` = (SELECT id FROM `gc_budget_line_items` WHERE `project_id` = $project_id AND `cost_code_id` = $costcode ORDER BY `id` DESC ) ORDER BY `id` DESC ";
	
	$db->execute($query1);
	$row1 = $db->fetch();
	$vendor_ids=$row1['vendor_id'];
	if($vendor_ids)
	{
		$filter = "FIELD (c.id, $vendor_ids ) DESC ,";
		//To split costvendor
		$data=explode(',',$vendor_ids);
		$vendorvalue='';
		foreach($data as $eachval)
		{
	   	 $vendorvalue .="'".$eachval."',";
		}
		$vendorvalue=trim($vendorvalue,',');


	}else{
			$filter = '';
		}
				$db->free_result();
				//To get the cost code contacts
	
//End of vendor cost code

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `user_company_id` ASC, `user_id` ASC, `contact_company_id` ASC, `email` ASC, `name_prefix` ASC, `first_name` ASC, `additional_name` ASC, `middle_name` ASC, `last_name` ASC, `name_suffix` ASC, `title` ASC, `vendor_flag` ASC
		$sqlOrderBy = "\nORDER BY $filter c_fk_cc.`company` ASC, c.`first_name` ASC, c.`last_name` ASC, c.`email` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpContact = new Contact($database);
			$sqlOrderByColumns = $tmpContact->constructSqlOrderByColumns($arrOrderByAttributes);

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

	c_fk_uc.`id` AS 'c_fk_uc__user_company_id',
	c_fk_uc.`company` AS 'c_fk_uc__company',
	c_fk_uc.`primary_phone_number` AS 'c_fk_uc__primary_phone_number',
	c_fk_uc.`employer_identification_number` AS 'c_fk_uc__employer_identification_number',
	c_fk_uc.`construction_license_number` AS 'c_fk_uc__construction_license_number',
	c_fk_uc.`construction_license_number_expiration_date` AS 'c_fk_uc__construction_license_number_expiration_date',
	c_fk_uc.`paying_customer_flag` AS 'c_fk_uc__paying_customer_flag',

	c_fk_u.`id` AS 'c_fk_u__user_id',
	c_fk_u.`user_company_id` AS 'c_fk_u__user_company_id',
	c_fk_u.`role_id` AS 'c_fk_u__role_id',
	c_fk_u.`default_project_id` AS 'c_fk_u__default_project_id',
	c_fk_u.`primary_contact_id` AS 'c_fk_u__primary_contact_id',
	c_fk_u.`mobile_network_carrier_id` AS 'c_fk_u__mobile_network_carrier_id',
	c_fk_u.`user_image_id` AS 'c_fk_u__user_image_id',
	c_fk_u.`security_image_id` AS 'c_fk_u__security_image_id',
	c_fk_u.`html_template_theme_id` AS 'c_fk_u__html_template_theme_id',
	c_fk_u.`mobile_phone_number` AS 'c_fk_u__mobile_phone_number',
	c_fk_u.`screen_name` AS 'c_fk_u__screen_name',
	c_fk_u.`email` AS 'c_fk_u__email',
	c_fk_u.`password_hash` AS 'c_fk_u__password_hash',
	c_fk_u.`password_guid` AS 'c_fk_u__password_guid',
	c_fk_u.`security_phrase` AS 'c_fk_u__security_phrase',
	c_fk_u.`modified` AS 'c_fk_u__modified',
	c_fk_u.`accessed` AS 'c_fk_u__accessed',
	c_fk_u.`created` AS 'c_fk_u__created',
	c_fk_u.`alerts` AS 'c_fk_u__alerts',
	c_fk_u.`tc_accepted_flag` AS 'c_fk_u__tc_accepted_flag',
	c_fk_u.`email_subscribe_flag` AS 'c_fk_u__email_subscribe_flag',
	c_fk_u.`remember_me_flag` AS 'c_fk_u__remember_me_flag',
	c_fk_u.`change_password_flag` AS 'c_fk_u__change_password_flag',
	c_fk_u.`disabled_flag` AS 'c_fk_u__disabled_flag',
	c_fk_u.`deleted_flag` AS 'c_fk_u__deleted_flag',

	c_fk_cc.`id` AS 'c_fk_cc__contact_company_id',
	c_fk_cc.`user_user_company_id` AS 'c_fk_cc__user_user_company_id',
	c_fk_cc.`contact_user_company_id` AS 'c_fk_cc__contact_user_company_id',
	c_fk_cc.`company` AS 'c_fk_cc__company',
	c_fk_cc.`primary_phone_number` AS 'c_fk_cc__primary_phone_number',
	c_fk_cc.`employer_identification_number` AS 'c_fk_cc__employer_identification_number',
	c_fk_cc.`construction_license_number` AS 'c_fk_cc__construction_license_number',
	c_fk_cc.`construction_license_number_expiration_date` AS 'c_fk_cc__construction_license_number_expiration_date',
	c_fk_cc.`vendor_flag` AS 'c_fk_cc__vendor_flag',

	c.*

FROM `contacts` c
	INNER JOIN `user_companies` c_fk_uc ON c.`user_company_id` = c_fk_uc.`id`
	INNER JOIN `users` c_fk_u ON c.`user_id` = c_fk_u.`id`
	INNER JOIN `contact_companies` c_fk_cc ON c.`contact_company_id` = c_fk_cc.`id`
WHERE c.`user_company_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `user_company_id` ASC, `user_id` ASC, `contact_company_id` ASC, `email` ASC, `name_prefix` ASC, `first_name` ASC, `additional_name` ASC, `middle_name` ASC, `last_name` ASC, `name_suffix` ASC, `title` ASC, `vendor_flag` ASC
		$arrValues = array($user_company_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrContactsByUserCompanyId = array();
		while ($row = $db->fetch()) {
			$contact_id = $row['id'];
			$contact = self::instantiateOrm($database, 'Contact', $row, null, $contact_id);
			/* @var $contact Contact */
			$contact->convertPropertiesToData();

			if (isset($row['user_company_id'])) {
				$user_company_id = $row['user_company_id'];
				$row['c_fk_uc__id'] = $user_company_id;
				$userCompany = self::instantiateOrm($database, 'UserCompany', $row, null, $user_company_id, 'c_fk_uc__');
				/* @var $userCompany UserCompany */
				$userCompany->convertPropertiesToData();
			} else {
				$userCompany = false;
			}
			$contact->setUserCompany($userCompany);

			if (isset($row['user_id'])) {
				$user_id = $row['user_id'];
				$row['c_fk_u__id'] = $user_id;
				$user = self::instantiateOrm($database, 'User', $row, null, $user_id, 'c_fk_u__');
				/* @var $user User */
				$user->convertPropertiesToData();
			} else {
				$user = false;
			}
			$contact->setUser($user);

			if (isset($row['contact_company_id'])) {
				$contact_company_id = $row['contact_company_id'];
				$row['c_fk_cc__id'] = $contact_company_id;
				$contactCompany = self::instantiateOrm($database, 'ContactCompany', $row, null, $contact_company_id, 'c_fk_cc__');
				/* @var $contactCompany ContactCompany */
				$contactCompany->convertPropertiesToData();
			} else {
				$contactCompany = false;
			}
			$contact->setContactCompany($contactCompany);

			$arrContactsByUserCompanyId[$contact_id] = $contact;
		}

		$db->free_result();

		self::$_arrContactsByUserCompanyId = $arrContactsByUserCompanyId;

		//$cache->save($arrContactsByUserCompanyId, $cacheKey);

		return $arrContactsByUserCompanyId;
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `contacts_fk_uc` foreign key (`user_company_id`) references `user_companies` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $user_company_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadContactsByUserCompanyId($database, $user_company_id, Input $options=null)
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

		/*
		$cache = Zend_Registry::get('cache');
		$cacheKey = 'Contact_loadContactsByUserCompanyId_' . $user_company_id;
		$arrContactsByUserCompanyId = $cache->load($cacheKey);
		if ($arrContactsByUserCompanyId) {
			return $arrContactsByUserCompanyId;
		}
		*/

		if ($forceLoadFlag) {
			self::$_arrContactsByUserCompanyId = null;
		}

		$arrContactsByUserCompanyId = self::$_arrContactsByUserCompanyId;
		if (isset($arrContactsByUserCompanyId) && !empty($arrContactsByUserCompanyId)) {
			return $arrContactsByUserCompanyId;
		}

		$user_company_id = (int) $user_company_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `user_company_id` ASC, `user_id` ASC, `contact_company_id` ASC, `email` ASC, `name_prefix` ASC, `first_name` ASC, `additional_name` ASC, `middle_name` ASC, `last_name` ASC, `name_suffix` ASC, `title` ASC, `vendor_flag` ASC
		$sqlOrderBy = "\nORDER BY c_fk_cc.`company` ASC, c.`first_name` ASC, c.`last_name` ASC, c.`email` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpContact = new Contact($database);
			$sqlOrderByColumns = $tmpContact->constructSqlOrderByColumns($arrOrderByAttributes);

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

	c_fk_uc.`id` AS 'c_fk_uc__user_company_id',
	c_fk_uc.`company` AS 'c_fk_uc__company',
	c_fk_uc.`primary_phone_number` AS 'c_fk_uc__primary_phone_number',
	c_fk_uc.`employer_identification_number` AS 'c_fk_uc__employer_identification_number',
	c_fk_uc.`construction_license_number` AS 'c_fk_uc__construction_license_number',
	c_fk_uc.`construction_license_number_expiration_date` AS 'c_fk_uc__construction_license_number_expiration_date',
	c_fk_uc.`paying_customer_flag` AS 'c_fk_uc__paying_customer_flag',

	c_fk_u.`id` AS 'c_fk_u__user_id',
	c_fk_u.`user_company_id` AS 'c_fk_u__user_company_id',
	c_fk_u.`role_id` AS 'c_fk_u__role_id',
	c_fk_u.`default_project_id` AS 'c_fk_u__default_project_id',
	c_fk_u.`primary_contact_id` AS 'c_fk_u__primary_contact_id',
	c_fk_u.`mobile_network_carrier_id` AS 'c_fk_u__mobile_network_carrier_id',
	c_fk_u.`user_image_id` AS 'c_fk_u__user_image_id',
	c_fk_u.`security_image_id` AS 'c_fk_u__security_image_id',
	c_fk_u.`html_template_theme_id` AS 'c_fk_u__html_template_theme_id',
	c_fk_u.`mobile_phone_number` AS 'c_fk_u__mobile_phone_number',
	c_fk_u.`screen_name` AS 'c_fk_u__screen_name',
	c_fk_u.`email` AS 'c_fk_u__email',
	c_fk_u.`password_hash` AS 'c_fk_u__password_hash',
	c_fk_u.`password_guid` AS 'c_fk_u__password_guid',
	c_fk_u.`security_phrase` AS 'c_fk_u__security_phrase',
	c_fk_u.`modified` AS 'c_fk_u__modified',
	c_fk_u.`accessed` AS 'c_fk_u__accessed',
	c_fk_u.`created` AS 'c_fk_u__created',
	c_fk_u.`alerts` AS 'c_fk_u__alerts',
	c_fk_u.`tc_accepted_flag` AS 'c_fk_u__tc_accepted_flag',
	c_fk_u.`email_subscribe_flag` AS 'c_fk_u__email_subscribe_flag',
	c_fk_u.`remember_me_flag` AS 'c_fk_u__remember_me_flag',
	c_fk_u.`change_password_flag` AS 'c_fk_u__change_password_flag',
	c_fk_u.`disabled_flag` AS 'c_fk_u__disabled_flag',
	c_fk_u.`deleted_flag` AS 'c_fk_u__deleted_flag',

	c_fk_cc.`id` AS 'c_fk_cc__contact_company_id',
	c_fk_cc.`user_user_company_id` AS 'c_fk_cc__user_user_company_id',
	c_fk_cc.`contact_user_company_id` AS 'c_fk_cc__contact_user_company_id',
	c_fk_cc.`company` AS 'c_fk_cc__company',
	c_fk_cc.`primary_phone_number` AS 'c_fk_cc__primary_phone_number',
	c_fk_cc.`employer_identification_number` AS 'c_fk_cc__employer_identification_number',
	c_fk_cc.`construction_license_number` AS 'c_fk_cc__construction_license_number',
	c_fk_cc.`construction_license_number_expiration_date` AS 'c_fk_cc__construction_license_number_expiration_date',
	c_fk_cc.`vendor_flag` AS 'c_fk_cc__vendor_flag',

	c.*

FROM `contacts` c
	INNER JOIN `user_companies` c_fk_uc ON c.`user_company_id` = c_fk_uc.`id`
	INNER JOIN `users` c_fk_u ON c.`user_id` = c_fk_u.`id`
	INNER JOIN `contact_companies` c_fk_cc ON c.`contact_company_id` = c_fk_cc.`id`
WHERE c.`user_company_id` = ? AND c.`is_archive`='N' {$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `user_company_id` ASC, `user_id` ASC, `contact_company_id` ASC, `email` ASC, `name_prefix` ASC, `first_name` ASC, `additional_name` ASC, `middle_name` ASC, `last_name` ASC, `name_suffix` ASC, `title` ASC, `vendor_flag` ASC
		$arrValues = array($user_company_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrContactsByUserCompanyId = array();
		while ($row = $db->fetch()) {
			$contact_id = $row['id'];
			$contact = self::instantiateOrm($database, 'Contact', $row, null, $contact_id);
			/* @var $contact Contact */
			$contact->convertPropertiesToData();

			if (isset($row['user_company_id'])) {
				$user_company_id = $row['user_company_id'];
				$row['c_fk_uc__id'] = $user_company_id;
				$userCompany = self::instantiateOrm($database, 'UserCompany', $row, null, $user_company_id, 'c_fk_uc__');
				/* @var $userCompany UserCompany */
				$userCompany->convertPropertiesToData();
			} else {
				$userCompany = false;
			}
			$contact->setUserCompany($userCompany);

			if (isset($row['user_id'])) {
				$user_id = $row['user_id'];
				$row['c_fk_u__id'] = $user_id;
				$user = self::instantiateOrm($database, 'User', $row, null, $user_id, 'c_fk_u__');
				/* @var $user User */
				$user->convertPropertiesToData();
			} else {
				$user = false;
			}
			$contact->setUser($user);

			if (isset($row['contact_company_id'])) {
				$contact_company_id = $row['contact_company_id'];
				$row['c_fk_cc__id'] = $contact_company_id;
				$contactCompany = self::instantiateOrm($database, 'ContactCompany', $row, null, $contact_company_id, 'c_fk_cc__');
				/* @var $contactCompany ContactCompany */
				$contactCompany->convertPropertiesToData();
			} else {
				$contactCompany = false;
			}
			$contact->setContactCompany($contactCompany);

			$arrContactsByUserCompanyId[$contact_id] = $contact;
		}

		$db->free_result();

		self::$_arrContactsByUserCompanyId = $arrContactsByUserCompanyId;

		//$cache->save($arrContactsByUserCompanyId, $cacheKey);

		return $arrContactsByUserCompanyId;
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `contacts_fk_uc` foreign key (`user_company_id`) references `user_companies` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $user_company_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadContactsByProjectId($database, $project_id, Input $options=null)
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

		/*
		$cache = Zend_Registry::get('cache');
		$cacheKey = 'Contact_loadContactsByUserCompanyId_' . $user_company_id;
		$arrContactsByUserCompanyId = $cache->load($cacheKey);
		if ($arrContactsByUserCompanyId) {
			return $arrContactsByUserCompanyId;
		}
		*/

		if ($forceLoadFlag) {
			self::$_arrContactsByUserCompanyId = null;
		}

		$arrContactsByUserCompanyId = self::$_arrContactsByUserCompanyId;
		if (isset($arrContactsByUserCompanyId) && !empty($arrContactsByUserCompanyId)) {
			return $arrContactsByUserCompanyId;
		}

		$user_company_id = (int) $user_company_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `user_company_id` ASC, `user_id` ASC, `contact_company_id` ASC, `email` ASC, `name_prefix` ASC, `first_name` ASC, `additional_name` ASC, `middle_name` ASC, `last_name` ASC, `name_suffix` ASC, `title` ASC, `vendor_flag` ASC
		$sqlOrderBy = "\nORDER BY c_fk_cc.`company` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpContact = new Contact($database);
			$sqlOrderByColumns = $tmpContact->constructSqlOrderByColumns($arrOrderByAttributes);

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
	c_fk_cc.`id` AS 'contact_company_id',
	c_fk_cc.`user_user_company_id` AS 'user_user_company_id',
	c_fk_cc.`contact_user_company_id` AS 'contact_user_company_id',
	c_fk_cc.`company` AS 'company',
	c_fk_cc.`primary_phone_number` AS 'primary_phone_number',
	c_fk_cc.`employer_identification_number` AS 'employer_identification_number',
	c_fk_cc.`construction_license_number` AS 'construction_license_number',
	c_fk_cc.`construction_license_number_expiration_date` AS 'construction_license_number_expiration_date',
	c_fk_cc.`vendor_flag` AS 'vendor_flag',

	s.`gc_budget_line_item_id` AS 'gc_budget_line_item_id',
	s.`vendor_id` AS 'vendor_id',

	gbli.`cost_code_id` AS 'cost_code_id',

	s.`id` AS 's_id'
FROM `subcontracts` s
	INNER JOIN `gc_budget_line_items` gbli ON gbli.`id` = s.`gc_budget_line_item_id`
	INNER JOIN `vendors` v ON v.`id` = s.`vendor_id`
	INNER JOIN `contact_companies` c_fk_cc ON v.`vendor_contact_company_id` = c_fk_cc.`id`
WHERE gbli.`project_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `user_company_id` ASC, `user_id` ASC, `contact_company_id` ASC, `email` ASC, `name_prefix` ASC, `first_name` ASC, `additional_name` ASC, `middle_name` ASC, `last_name` ASC, `name_suffix` ASC, `title` ASC, `vendor_flag` ASC
		$arrValues = array($project_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrContactsByUserCompanyId = array();
		
		while ($row = $db->fetch()) {
			$id = $row['gc_budget_line_item_id'].$row['cost_code_id'].$row['contact_company_id'];
			$arrContactsByUserCompanyId[$id] = $row;
		}

		$db->free_result();

		return $arrContactsByUserCompanyId;
	}

	/**
	 * Load by constraint `contacts_fk_u` foreign key (`user_id`) references `users` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $user_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadContactsByUserId($database, $user_id, Input $options=null)
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
			self::$_arrContactsByUserId = null;
		}

		$arrContactsByUserId = self::$_arrContactsByUserId;
		if (isset($arrContactsByUserId) && !empty($arrContactsByUserId)) {
			return $arrContactsByUserId;
		}

		$user_id = (int) $user_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `user_company_id` ASC, `user_id` ASC, `contact_company_id` ASC, `email` ASC, `name_prefix` ASC, `first_name` ASC, `additional_name` ASC, `middle_name` ASC, `last_name` ASC, `name_suffix` ASC, `title` ASC, `vendor_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpContact = new Contact($database);
			$sqlOrderByColumns = $tmpContact->constructSqlOrderByColumns($arrOrderByAttributes);

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
	c.*

FROM `contacts` c
WHERE c.`user_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `user_company_id` ASC, `user_id` ASC, `contact_company_id` ASC, `email` ASC, `name_prefix` ASC, `first_name` ASC, `additional_name` ASC, `middle_name` ASC, `last_name` ASC, `name_suffix` ASC, `title` ASC, `vendor_flag` ASC
		$arrValues = array($user_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrContactsByUserId = array();
		while ($row = $db->fetch()) {
			$contact_id = $row['id'];
			$contact = self::instantiateOrm($database, 'Contact', $row, null, $contact_id);
			/* @var $contact Contact */
			$arrContactsByUserId[$contact_id] = $contact;
		}

		$db->free_result();

		self::$_arrContactsByUserId = $arrContactsByUserId;

		return $arrContactsByUserId;
	}

	/**
	 * Load by constraint `contacts_fk_cc` foreign key (`contact_company_id`) references `contact_companies` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $contact_company_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadContactsByContactCompanyId($database, $contact_company_id, Input $options=null)
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
			self::$_arrContactsByContactCompanyId = null;
		}

		$arrContactsByContactCompanyId = self::$_arrContactsByContactCompanyId;
		if (isset($arrContactsByContactCompanyId) && !empty($arrContactsByContactCompanyId)) {
			return $arrContactsByContactCompanyId;
		}

		$contact_company_id = (int) $contact_company_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `user_company_id` ASC, `user_id` ASC, `contact_company_id` ASC, `email` ASC, `name_prefix` ASC, `first_name` ASC, `additional_name` ASC, `middle_name` ASC, `last_name` ASC, `name_suffix` ASC, `title` ASC, `vendor_flag` ASC
		$sqlOrderBy = "\nORDER BY c.`last_name`, c.`first_name`, c.`email`";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpContact = new Contact($database);
			$sqlOrderByColumns = $tmpContact->constructSqlOrderByColumns($arrOrderByAttributes);

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
	c.*

FROM `contacts` c
WHERE c.`contact_company_id` = ? AND c.`is_archive` = 'N' {$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `user_company_id` ASC, `user_id` ASC, `contact_company_id` ASC, `email` ASC, `name_prefix` ASC, `first_name` ASC, `additional_name` ASC, `middle_name` ASC, `last_name` ASC, `name_suffix` ASC, `title` ASC, `vendor_flag` ASC
		$arrValues = array($contact_company_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrContactsByContactCompanyId = array();
		while ($row = $db->fetch()) {
			$contact_id = $row['id'];
			$contact = self::instantiateOrm($database, 'Contact', $row, null, $contact_id);
			/* @var $contact Contact */
			$arrContactsByContactCompanyId[$contact_id] = $contact;
		}

		$db->free_result();

		self::$_arrContactsByContactCompanyId = $arrContactsByContactCompanyId;

		return $arrContactsByContactCompanyId;
	}

	/**
	 * Load by constraint `contacts_fk_cc` foreign key (`contact_company_id`) references `contact_companies` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $contact_company_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadContactsByRoleForeman($database, $project_id, Input $options=null)
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
			self::$_arrContactsByContactCompanyId = null;
		}

		$arrContactsByContactCompanyId = self::$_arrContactsByContactCompanyId;
		if (isset($arrContactsByContactCompanyId) && !empty($arrContactsByContactCompanyId)) {
			return $arrContactsByContactCompanyId;
		}

		// $contact_company_id = (int) $contact_company_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `user_company_id` ASC, `user_id` ASC, `contact_company_id` ASC, `email` ASC, `name_prefix` ASC, `first_name` ASC, `additional_name` ASC, `middle_name` ASC, `last_name` ASC, `name_suffix` ASC, `title` ASC, `vendor_flag` ASC
		$sqlOrderBy = "\nORDER BY c.`last_name`, c.`first_name`, c.`email`";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpContact = new Contact($database);
			$sqlOrderByColumns = $tmpContact->constructSqlOrderByColumns($arrOrderByAttributes);

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
SELECT * 
FROM `projects_to_contacts_to_roles`
INNER JOIN `roles` ON `roles`.id =  `projects_to_contacts_to_roles`.role_id
LEFT JOIN `contacts` c ON `c`.id = `projects_to_contacts_to_roles`.contact_id
LEFT JOIN `contact_companies` cc ON `cc`.id = `c`.contact_company_id
WHERE `projects_to_contacts_to_roles`.`project_id` = ? 
AND `roles`.role IN ('Foreman')
{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `user_company_id` ASC, `user_id` ASC, `contact_company_id` ASC, `email` ASC, `name_prefix` ASC, `first_name` ASC, `additional_name` ASC, `middle_name` ASC, `last_name` ASC, `name_suffix` ASC, `title` ASC, `vendor_flag` ASC
		$arrValues = array($project_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$arrContactsByContactCompanyId = array();
		while ($row = $db->fetch()) {
			$contact_id = $row['contact_id'];
			$contact = self::instantiateOrm($database, 'Contact', $row, null, $contact_id);
			/* @var $contact Contact */
			$arrContactsByContactCompanyId[$contact_id] = $contact;
		}

		$db->free_result();

		self::$_arrContactsByContactCompanyId = $arrContactsByContactCompanyId;

		return $arrContactsByContactCompanyId;
	}

	public static function loadContactsByContactCompanyIdArchived($database, $contact_company_id, Input $options=null)
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
			self::$_arrContactsByContactCompanyId = null;
		}

		$arrContactsByContactCompanyId = self::$_arrContactsByContactCompanyId;
		if (isset($arrContactsByContactCompanyId) && !empty($arrContactsByContactCompanyId)) {
			return $arrContactsByContactCompanyId;
		}

		$contact_company_id = (int) $contact_company_id;

		$db = DBI::getInstance($database);
		
		$sqlOrderBy = "\nORDER BY c.`last_name`, c.`first_name`, c.`email`";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpContact = new Contact($database);
			$sqlOrderByColumns = $tmpContact->constructSqlOrderByColumns($arrOrderByAttributes);

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
	c.*

FROM `contacts` c
WHERE c.`contact_company_id` = ? AND c.`is_archive`='N' {$sqlOrderBy}{$sqlLimit}
";

		$arrValues = array($contact_company_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrContactsByContactCompanyId = array();
		while ($row = $db->fetch()) {
			$contact_id = $row['id'];
			$contact = self::instantiateOrm($database, 'Contact', $row, null, $contact_id);
			/* @var $contact Contact */
			$arrContactsByContactCompanyId[$contact_id] = $contact;
		}

		$db->free_result();

		self::$_arrContactsByContactCompanyId = $arrContactsByContactCompanyId;

		return $arrContactsByContactCompanyId;
	}

	// Loaders: Load By index
	/**
	 * Load by key `email` (`email`).
	 *
	 * @param string $database
	 * @param string $email
	 * @param mixed (Input $options object | null)
	 * @return mixed (single ORM object | false)
	 */
	public static function loadContactsByEmail($database, $email, Input $options=null)
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
			self::$_arrContactsByEmail = null;
		}

		$arrContactsByEmail = self::$_arrContactsByEmail;
		if (isset($arrContactsByEmail) && !empty($arrContactsByEmail)) {
			return $arrContactsByEmail;
		}

		$email = (string) $email;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `user_company_id` ASC, `user_id` ASC, `contact_company_id` ASC, `email` ASC, `name_prefix` ASC, `first_name` ASC, `additional_name` ASC, `middle_name` ASC, `last_name` ASC, `name_suffix` ASC, `title` ASC, `vendor_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpContact = new Contact($database);
			$sqlOrderByColumns = $tmpContact->constructSqlOrderByColumns($arrOrderByAttributes);

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
	c.*

FROM `contacts` c
WHERE c.`email` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `user_company_id` ASC, `user_id` ASC, `contact_company_id` ASC, `email` ASC, `name_prefix` ASC, `first_name` ASC, `additional_name` ASC, `middle_name` ASC, `last_name` ASC, `name_suffix` ASC, `title` ASC, `vendor_flag` ASC
		$arrValues = array($email);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrContactsByEmail = array();
		while ($row = $db->fetch()) {
			$contact_id = $row['id'];
			$contact = self::instantiateOrm($database, 'Contact', $row, null, $contact_id);
			/* @var $contact Contact */
			$arrContactsByEmail[$contact_id] = $contact;
		}

		$db->free_result();

		self::$_arrContactsByEmail = $arrContactsByEmail;

		return $arrContactsByEmail;
	}

	/**
	 * Load by key `full_name` (`first_name`,`middle_name`,`last_name`).
	 *
	 * @param string $database
	 * @param string $first_name
	 * @param string $middle_name
	 * @param string $last_name
	 * @param mixed (Input $options object | null)
	 * @return mixed (single ORM object | false)
	 */
	public static function loadContactsByFirstNameAndMiddleNameAndLastName($database, $first_name, $middle_name, $last_name, Input $options=null)
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
			self::$_arrContactsByFirstNameAndMiddleNameAndLastName = null;
		}

		$arrContactsByFirstNameAndMiddleNameAndLastName = self::$_arrContactsByFirstNameAndMiddleNameAndLastName;
		if (isset($arrContactsByFirstNameAndMiddleNameAndLastName) && !empty($arrContactsByFirstNameAndMiddleNameAndLastName)) {
			return $arrContactsByFirstNameAndMiddleNameAndLastName;
		}

		$first_name = (string) $first_name;
		$middle_name = (string) $middle_name;
		$last_name = (string) $last_name;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `user_company_id` ASC, `user_id` ASC, `contact_company_id` ASC, `email` ASC, `name_prefix` ASC, `first_name` ASC, `additional_name` ASC, `middle_name` ASC, `last_name` ASC, `name_suffix` ASC, `title` ASC, `vendor_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpContact = new Contact($database);
			$sqlOrderByColumns = $tmpContact->constructSqlOrderByColumns($arrOrderByAttributes);

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
	c.*

FROM `contacts` c
WHERE c.`first_name` = ?
AND c.`middle_name` = ?
AND c.`last_name` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `user_company_id` ASC, `user_id` ASC, `contact_company_id` ASC, `email` ASC, `name_prefix` ASC, `first_name` ASC, `additional_name` ASC, `middle_name` ASC, `last_name` ASC, `name_suffix` ASC, `title` ASC, `vendor_flag` ASC
		$arrValues = array($first_name, $middle_name, $last_name);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrContactsByFirstNameAndMiddleNameAndLastName = array();
		while ($row = $db->fetch()) {
			$contact_id = $row['id'];
			$contact = self::instantiateOrm($database, 'Contact', $row, null, $contact_id);
			/* @var $contact Contact */
			$arrContactsByFirstNameAndMiddleNameAndLastName[$contact_id] = $contact;
		}

		$db->free_result();

		self::$_arrContactsByFirstNameAndMiddleNameAndLastName = $arrContactsByFirstNameAndMiddleNameAndLastName;

		return $arrContactsByFirstNameAndMiddleNameAndLastName;
	}

	/**
	 * Load by key `last_name` (`last_name`).
	 *
	 * @param string $database
	 * @param string $last_name
	 * @param mixed (Input $options object | null)
	 * @return mixed (single ORM object | false)
	 */
	public static function loadContactsByLastName($database, $last_name, Input $options=null)
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
			self::$_arrContactsByLastName = null;
		}

		$arrContactsByLastName = self::$_arrContactsByLastName;
		if (isset($arrContactsByLastName) && !empty($arrContactsByLastName)) {
			return $arrContactsByLastName;
		}

		$last_name = (string) $last_name;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `user_company_id` ASC, `user_id` ASC, `contact_company_id` ASC, `email` ASC, `name_prefix` ASC, `first_name` ASC, `additional_name` ASC, `middle_name` ASC, `last_name` ASC, `name_suffix` ASC, `title` ASC, `vendor_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpContact = new Contact($database);
			$sqlOrderByColumns = $tmpContact->constructSqlOrderByColumns($arrOrderByAttributes);

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
	c.*

FROM `contacts` c
WHERE c.`last_name` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `user_company_id` ASC, `user_id` ASC, `contact_company_id` ASC, `email` ASC, `name_prefix` ASC, `first_name` ASC, `additional_name` ASC, `middle_name` ASC, `last_name` ASC, `name_suffix` ASC, `title` ASC, `vendor_flag` ASC
		$arrValues = array($last_name);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrContactsByLastName = array();
		while ($row = $db->fetch()) {
			$contact_id = $row['id'];
			$contact = self::instantiateOrm($database, 'Contact', $row, null, $contact_id);
			/* @var $contact Contact */
			$arrContactsByLastName[$contact_id] = $contact;
		}

		$db->free_result();

		self::$_arrContactsByLastName = $arrContactsByLastName;

		return $arrContactsByLastName;
	}

	// Loaders: Load By additionally indexed attribute
	/**
	 * Load by leftmost indexed attribute: key `full_name` (`first_name`,`middle_name`,`last_name`).
	 *
	 * @param string $database
	 * @param string $first_name
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadContactsByFirstName($database, $first_name, Input $options=null)
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
			self::$_arrContactsByFirstName = null;
		}

		$arrContactsByFirstName = self::$_arrContactsByFirstName;
		if (isset($arrContactsByFirstName) && !empty($arrContactsByFirstName)) {
			return $arrContactsByFirstName;
		}

		$first_name = (string) $first_name;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `user_company_id` ASC, `user_id` ASC, `contact_company_id` ASC, `email` ASC, `name_prefix` ASC, `first_name` ASC, `additional_name` ASC, `middle_name` ASC, `last_name` ASC, `name_suffix` ASC, `title` ASC, `vendor_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpContact = new Contact($database);
			$sqlOrderByColumns = $tmpContact->constructSqlOrderByColumns($arrOrderByAttributes);

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
	c.*

FROM `contacts` c
WHERE c.`first_name` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `user_company_id` ASC, `user_id` ASC, `contact_company_id` ASC, `email` ASC, `name_prefix` ASC, `first_name` ASC, `additional_name` ASC, `middle_name` ASC, `last_name` ASC, `name_suffix` ASC, `title` ASC, `vendor_flag` ASC
		$arrValues = array($first_name);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrContactsByFirstName = array();
		while ($row = $db->fetch()) {
			$contact_id = $row['id'];
			$contact = self::instantiateOrm($database, 'Contact', $row, null, $contact_id);
			/* @var $contact Contact */
			$arrContactsByFirstName[$contact_id] = $contact;
		}

		$db->free_result();

		self::$_arrContactsByFirstName = $arrContactsByFirstName;

		return $arrContactsByFirstName;
	}

	// Loaders: Load All Records
	/**
	 * Load all contacts records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllContacts($database, Input $options=null)
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
			self::$_arrAllContacts = null;
		}

		$arrAllContacts = self::$_arrAllContacts;
		if (isset($arrAllContacts) && !empty($arrAllContacts)) {
			return $arrAllContacts;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `user_company_id` ASC, `user_id` ASC, `contact_company_id` ASC, `email` ASC, `name_prefix` ASC, `first_name` ASC, `additional_name` ASC, `middle_name` ASC, `last_name` ASC, `name_suffix` ASC, `title` ASC, `vendor_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpContact = new Contact($database);
			$sqlOrderByColumns = $tmpContact->constructSqlOrderByColumns($arrOrderByAttributes);

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
	c.*

FROM `contacts` c{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `user_company_id` ASC, `user_id` ASC, `contact_company_id` ASC, `email` ASC, `name_prefix` ASC, `first_name` ASC, `additional_name` ASC, `middle_name` ASC, `last_name` ASC, `name_suffix` ASC, `title` ASC, `vendor_flag` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllContacts = array();
		while ($row = $db->fetch()) {
			$contact_id = $row['id'];
			$contact = self::instantiateOrm($database, 'Contact', $row, null, $contact_id);
			/* @var $contact Contact */
			$arrAllContacts[$contact_id] = $contact;
		}

		$db->free_result();

		self::$_arrAllContacts = $arrAllContacts;

		return $arrAllContacts;
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
INTO `contacts`
(`user_company_id`, `user_id`, `contact_company_id`, `email`, `name_prefix`, `first_name`, `additional_name`, `middle_name`, `last_name`, `name_suffix`, `title`, `vendor_flag`)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
ON DUPLICATE KEY UPDATE `user_id` = ?, `name_prefix` = ?, `additional_name` = ?, `middle_name` = ?, `name_suffix` = ?, `title` = ?, `vendor_flag` = ?
";
		$arrValues = array($this->user_company_id, $this->user_id, $this->contact_company_id, $this->email, $this->name_prefix, $this->first_name, $this->additional_name, $this->middle_name, $this->last_name, $this->name_suffix, $this->title, $this->vendor_flag, $this->user_id, $this->name_prefix, $this->additional_name, $this->middle_name, $this->name_suffix, $this->title, $this->vendor_flag);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$contact_id = $db->insertId;
		$db->free_result();

		return $contact_id;
	}

	// Save: insert ignore

	public static function findContactByUserCompanyIdAndUserId($database, $user_company_id, $user_id)
	{
		$contact = new Contact($database);
		$key = array(
			'user_company_id' => $user_company_id,
			'user_id' => $user_id
		);
		$contact->setKey($key);
		$contact->load();

		$dataLoadedFlag = $contact->isDataLoaded();
		if ($dataLoadedFlag) {
			$contact->convertDataToProperties();
			$contact->setId($contact->contact_id);

			return $contact;
		} else {
			$contact->setKey(null);
		}

		return false;
	}

	public static function findContactByUserCompanyIdAndEmail($database, $user_company_id, $email)
	{
		$contact = new Contact($database);
		$key = array(
			'user_company_id' => $user_company_id,
			'email' => $email
		);
		$contact->setKey($key);
		$contact->load();

		$dataLoadedFlag = $contact->isDataLoaded();
		if ($dataLoadedFlag) {
			$contact->convertDataToProperties();
			$contact->setId($contact->contact_id);

			return $contact;
		} else {
			$contact->setKey(null);
		}

		return false;
	}
	// To get  the contact name or email
	public static function ContactEmailById($database,$raised_by,$data){
		$db = DBI::getInstance($database);
		$first_name = '';
        $query = "SELECT * FROM contacts where id='$raised_by'";
        $db->execute($query);
        $first_name='';
		while($row = $db->fetch())
		{
			if($data=='email')
				$first_name=$row['email'];
			else if($data=='name')
				$first_name=$row['first_name'].' '.$row['last_name'];
		   	
		}
		$first_name=trim($first_name," ");
		$db->free_result();
		return $first_name;

	}
	public static function ContactEmailOrNameById($database,$raised_by){
		$db = DBI::getInstance($database);
		$first_name = '';
        $query = "SELECT * FROM contacts where id='$raised_by'";
        $db->execute($query);
        $first_name='';
		while($row = $db->fetch())
		{
			if(!empty($row['email']))
				$first_name=$row['email'];
			else if(!empty($row['first_name']) || !empty($row['last_name']))
				$first_name=$row['first_name'].' '.$row['last_name'];
		   	
		}
		$first_name=trim($first_name," ");
		$db->free_result();
		return $first_name;

	}

	//To get Company name from contact id
	public static function CompanyNamefromContactID($database,$contact_id){
		$db = DBI::getInstance($database);
	   	$query = "SELECT cc.`id` as comp_id, cc.`user_user_company_id`, cc.`contact_user_company_id`, cc.`company`, cc.`primary_phone_number`, c.* FROM contacts as c inner join contact_companies as cc on c.contact_company_id = cc.id  where c.id='$contact_id'";
        	$db->execute($query);
		$row = $db->fetch();
		$db->free_result();
		return $row;

	}

	// To get  the contact name or email
	public static function loadAllcontactDatabycontactId($database,$contact_id){

		$db = DBI::getInstance();
        $query = "SELECT 
            cont.`company`,
		    c.*
        FROM contacts as c     
        inner join contact_companies as cont on c.contact_company_id=cont.id where c.id='$contact_id'";

      
        $db->execute($query);
        $conarr=array();
        $first_name='';
		while($row = $db->fetch())
		{
			$conarr=$row;		   	
		}
		
		$db->free_result();
	
		return $conarr;

	}
	// To get  the contact name or email
	public static function getcontactcompanyAddreess($database,$contact_id){

		$db = DBI::getInstance();
        $query = "SELECT 
            contact_company_office_id
        FROM   
        contacts_to_contact_company_offices where contact_id='$contact_id'";

      
        $db->execute($query);
		$row = $db->fetch();
        $contact_company_office_id=$row['contact_company_office_id'];
		$db->free_result();
	
		return $contact_company_office_id;

	}


	public static function findContactById($database, $contact_id, $loadContactCompany=false, $loadContactOffices=false, $loadContactPhoneNumbers=false)
	{
		$contact = new Contact($database);
		$key = array(
			'id' => $contact_id
		);
		$contact->setKey($key);
		$contact->load();

		$dataLoadedFlag = $contact->isDataLoaded();
		if ($dataLoadedFlag) {
			$contact->convertDataToProperties();
			$contact->setId($contact->contact_id);
			if ($loadContactCompany || $loadContactOffices || $loadContactPhoneNumbers) {
				$contact->loadContactInfo($loadContactCompany, $loadContactOffices, $loadContactPhoneNumbers);
			}

			return $contact;
		} else {
			$contact->setKey(null);
		}

		return false;
	}
	// To get  the contact name or email
	public static function ContactNameById($database,$raised_by){
		$db = DBI::getInstance($database);
		$first_name = '';
        $query = "SELECT * FROM contacts where id='$raised_by'";
        $db->execute($query);
		while($row = $db->fetch())
		{
			if($row['first_name']!='' || $row['last_name']!='')
		   	$first_name = $row['first_name'].' '.$row['last_name'];
		   else
		   	$first_name=$row['email'];

		   	if ($row['is_archive'] == 'Y') {
		   		$first_name = $first_name." (Archived)";
		   	}
		   	
		}
		$db->free_result();
		return $first_name;

	}

	// To get  the contact name or email
	public static function ContactNameByIdList($database,$conList){
		$db = DBI::getInstance($database);
        $query = "SELECT GROUP_CONCAT(IF(IFNULL(CONCAT(first_name,' ',last_name),'')!='',
			IF(is_archive = 'Y', CONCAT(first_name,' ',last_name,' (Archived)'), CONCAT(first_name,' ',last_name)),
			IF(is_archive = 'Y', CONCAT(email,' (Archived)'), email)) SEPARATOR ', ') as email FROM contacts where id IN ($conList) ";
        $db->execute($query);
		$row = $db->fetch();
		$email = $row['email'];
		$db->free_result();
		return $email;

	}

	public static function loadGuestContactIdList($database, $user_company_id, $user_id, $primary_contact_id)
	{
		$AXIS_NON_EXISTENT_CONTACT_ID = AXIS_NON_EXISTENT_CONTACT_ID;

		$db = DBI::getInstance($database);

		// get all guest contact_id values for convenience
		$query =
"
SELECT c.`id`
FROM contacts c
WHERE c.`user_id` = ?
AND c.`user_company_id` <> ?
AND c.`id` NOT IN ($AXIS_NON_EXISTENT_CONTACT_ID, ?)
";
		$arrValues = array($user_id, $user_company_id, $primary_contact_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrIds = array();
		while($row = $db->fetch()) {
			$id = $row['id'];
			$arrIds[$id] = 1;
		}
		$db->free_result();

		return $arrIds;
	}

	public function loadContactInfo($loadContactCompany=false, $loadContactOffices=false, $loadContactPhoneNumbers=false, $loadUserInvitation=false)
	{
		if (!isset($this->contact_id)) {
			return;
		}

		if (!$this->isDataLoaded()) {
			$contact_id = $this->contact_id;

			$database = $this->getDatabase();
			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			// Load base contact information
			$query =
"
SELECT *
FROM `contacts`
WHERE `id` = ?
";
			$arrValues = array($contact_id);
			$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

			$row = $db->fetch();
			$db->free_result();

			if ($row) {
				$this->setId($contact_id);
				$key = array('id' => $contact_id);
				$this->setKey($key);
				$this->setData($row);
				$this->convertDataToProperties();
			}
		}

		if ($loadContactCompany) {
			$this->loadContactCompany();
		}

		if ($loadContactOffices) {
			$this->loadOfficeList();
		}

		if ($loadContactPhoneNumbers) {
			$this->loadPhoneNumberList();
		}

		if ($loadUserInvitation) {
			$this->loadUserInvitation();
		}

		return;
	}

	public function loadContactCompany()
	{
		if (!isset($this->contact_id) && !isset($this->contact_company_id)) {
			return;
		}

		if (!isset($this->contact_company_id)) {
			$this->loadContactInfo();
		}

		$database = $this->getDatabase();
		$contactCompany = new ContactCompany($database);
		$key = array(
			'id' => $this->contact_company_id
		);
		$contactCompany->setKey($key);
		$contactCompany->load();
		$contactCompany->convertDataToProperties();

		$this->setContactCompany($contactCompany);

		return;
	}
	//To get the details of non login Contacts in Fulcrum
	public static function GetContactInfo($database,$contact_id,$project_id)
	{

		$db = DBI::getInstance($database);
	
		// Load base contact information
		$query ="SELECT 
		cc.`id` as cc_id,
		cc.`user_user_company_id` as cc_user_user_company_id,
		cc.`contact_user_company_id` as cc_contact_user_company_id,
		cc. `company` as cc_company,
		cc. `primary_phone_number` as cc_primary_phone_number,
		cc. `employer_identification_number` as cc_employer_identification_number,
		cc. `construction_license_number` as cc_construction_license_number,
		cc. `construction_license_number_expiration_date` as cc_construction_license_number_expiration_date,
		cc. `vendor_flag` as cc_vendor_flag,

		uc.`id` as uc_id,
		uc.`company` as uc_company, 
		uc.`primary_phone_number` as uc_primary_phone_number, 
		uc.`employer_identification_number` as uc_employer_identification_number, 
		uc.`construction_license_number` as uc_construction_license_number, 
		uc.`construction_license_number_expiration_date` as uc_construction_license_number_expiration_date, 
		uc.`paying_customer_flag` as uc_paying_customer_flag, 
		uc.`created_date` as uc_created_date,
		c.* 
		FROM `contacts` as c INNER Join `contact_companies` as cc on c.`contact_company_id` = cc.`id` Inner join user_companies as uc on  cc.`user_user_company_id` = uc.`id` WHERE c.`id` = ? ";
			$arrValues = array($contact_id);
			$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

			$row = $db->fetch();
			$db->free_result();
			if ($row) {
				
				$conarr->currentlyActiveContactId =  $contact_id;
				$conarr->primary_contact_id = $contact_id;
				$conarr->user_company_id =  $row['user_company_id'];
				$conarr->user_company_name =  $row['uc_company'];
				$conarr->email =  $row['email'];
				$conarr->currentlyActiveContactUserCompanyId =  $row['contact_company_id'];
				$conarr->contact_company_id =$row['contact_company_id'];
				$conarr->user_user_company_id =$row['user_company_id'];
				$conarr->contact_company_name =$row['cc_company'];
			}
			$project = Project::findById($database, $project_id);
			$conarr->currentlySelectedProjectId = $project->project_id;
			$conarr->currentlySelectedProjectUserCompanyId = $project->user_company_id;
			$conarr->currentlySelectedProjectName = $project->project_name;
		return $conarr;
	}

	public function loadOfficeList($primaryOnlyFlag=false)
	{
		if (!isset($this->contact_id)) {
			return;
		}

		$contact_id = $this->contact_id;

		$database = $this->getDatabase();
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		if ($primaryOnlyFlag) {
			$and =
"AND c2cco.`primary_office_flag` = 'Y' ";
		} else {
			$and = "";
		}

		$query =
"
SELECT cco.*
FROM `contacts_to_contact_company_offices` c2cco, `contact_company_offices` cco
WHERE c2cco.`contact_id` = ?
AND c2cco.`contact_company_office_id` = cco.`id`
".
		$and;
		$arrValues = array($contact_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrRecords = array();
		while ($row = $db->fetch()) {
			$cco = new ContactCompanyOffice($database);
			$cco->setData($row);
			$cco->convertDataToProperties();
			$arrRecords[] = $cco;
		}
		$db->free_result();

		$this->setOfficeList($arrRecords);

		return;
	}

	public function loadPhoneNumberList()
	{
		if (!isset($this->contact_id)) {
			return;
		}

		$database = $this->getDatabase();
		$arrPhoneNumbers = ContactPhoneNumber::loadContactPhoneNumbersListByContactId($database, $this->contact_id);
		$this->setPhoneNumberList($arrPhoneNumbers);

		return;
	}

	public function loadUserInvitation()
	{
		if (!isset($this->contact_id)) {
			return;
		}

		$database = $this->getDatabase();
		$userInvitation = new UserInvitation($database);
		$key = array(
			'contact_id' => $this->contact_id
		);
		$userInvitation->setKey($key);
		$userInvitation->load();
		$userInvitation->convertDataToProperties();

		$this->setUserInvitation($userInvitation);

		return;
	}

	/**
	 * Return true or false.
	 *
	 * Checks role_id in the users table and the contacts_to_roles table.
	 *
	 */
	public function isAdmin()
	{
		if (!isset($this->contact_id)) {
			return false;
		}

		$database = $this->getDatabase();

		$AXIS_USER_ROLE_ID_ADMIN = AXIS_USER_ROLE_ID_ADMIN;
		$AXIS_USER_ROLE_ID_USER = AXIS_USER_ROLE_ID_USER;

		$arrAssignedRolesByContactId = ContactToRole::loadAssignedRolesByContactId($database, $this->contact_id);

		if (isset($arrAssignedRolesByContactId[$AXIS_USER_ROLE_ID_ADMIN])) {
			return true;
		}

		if (isset($this->user_id) && ($this->user_id != 1)) {
			$this->loadUser();
		}

		$user = $this->getUser();

		if (isset($user) && ($user instanceof User)) {
			$role_id = $user->role_id;
			if ($role_id ==  $AXIS_USER_ROLE_ID_ADMIN) {
				return true;
			}
		}

		return false;
	}

	public function toggleAdmin()
	{
		if (!isset($this->contact_id)) {
			return;
		}

		$AXIS_USER_ROLE_ID_ADMIN = AXIS_USER_ROLE_ID_ADMIN;
		$AXIS_USER_ROLE_ID_USER = AXIS_USER_ROLE_ID_USER;

		$database = $this->getDatabase();

		if (isset($this->user_id) && ($this->user_id != 1)) {
			$this->loadUser();
		}

		$user = $this->getUser();

		// Test for user existence first and use that as a role guide to ensure no bad data (override contacts_to_roles)
		$registeredUser = false;
		if (isset($user) && ($user instanceof User)) {
			$registeredUser = true;
			$currentUserRoleId = $user->role_id;
			if ($currentUserRoleId ==  $AXIS_USER_ROLE_ID_ADMIN) {
				$newUserRoleId = $AXIS_USER_ROLE_ID_USER;
			} elseif ($currentUserRoleId ==  $AXIS_USER_ROLE_ID_USER) {
				$newUserRoleId = $AXIS_USER_ROLE_ID_ADMIN;
			}

			$data = array(
				'role_id' => $newUserRoleId
			);

			$tmpData = $user->getData();
			$user->setData($data);
			$user->save();
			$tmpData['role_id'] = $newUserRoleId;
			$user->role_id = $newUserRoleId;
			$user->setData($tmpData);
		}

		$arrAssignedRolesByContactId = ContactToRole::loadAssignedRolesByContactId($database, $this->contact_id);

		// Always link a contact to the "User" role
		if (!isset($arrAssignedRolesByContactId[$AXIS_USER_ROLE_ID_USER])) {
			// contact_id was not linked to the "User" role in contacts_to_roles so add in <contact_id, $AXIS_USER_ROLE_ID_USER>
			ContactToRole::addRoleToContact($database, $this->contact_id, $AXIS_USER_ROLE_ID_USER);
		}

		if ($registeredUser) {
			if ($newUserRoleId == $AXIS_USER_ROLE_ID_ADMIN) {
				if (!isset($arrAssignedRolesByContactId[$AXIS_USER_ROLE_ID_ADMIN])) {
					ContactToRole::addRoleToContact($database, $this->contact_id, $AXIS_USER_ROLE_ID_ADMIN);
				}
			} elseif ($newUserRoleId == $AXIS_USER_ROLE_ID_USER) {
				if (isset($arrAssignedRolesByContactId[$AXIS_USER_ROLE_ID_ADMIN])) {
					ContactToRole::removeRoleFromContact($database, $this->contact_id, $AXIS_USER_ROLE_ID_ADMIN);
				}
			}
		} else {
			if (isset($arrAssignedRolesByContactId[$AXIS_USER_ROLE_ID_ADMIN])) {
				// if admin, switch to user
				ContactToRole::removeRoleFromContact($database, $this->contact_id, $AXIS_USER_ROLE_ID_ADMIN);
			} elseif (isset($arrAssignedRolesByContactId[$AXIS_USER_ROLE_ID_USER])) {
				// if user, switch to admin
				ContactToRole::addRoleToContact($database, $this->contact_id, $AXIS_USER_ROLE_ID_ADMIN);
			}
		}

		return;
	}

	public function loadUser($forceLoad=false)
	{
		if (!isset($this->user_id) || (isset($this->user_id) && ($this->user_id == 1))) {
			return;
		}

		if (!$forceLoad) {
			if (isset($this->_user)) {
				return;
			}
		}

		$database = $this->getDatabase();
		$user = new User($database);
		$key = array(
			'id' => $this->user_id
		);
		$user->setKey($key);
		$user->load();
		$user->convertDataToProperties();

		$this->setUser($user);

		return;
	}

	public function loadMobilePhoneNumber()
	{
		if (!isset($this->contact_id)) {
			return false;
		}

		$database = $this->getDatabase();
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	mpn.*,
	cpn.*,
	mnc.*,
	mpn.`mobile_network_carrier_id`,
	cpn.`id` as 'contact_phone_number_id'
FROM `mobile_phone_numbers` mpn
	INNER JOIN `contact_phone_numbers` cpn ON mpn.`contact_phone_number_id` = cpn.`id`
	INNER JOIN `mobile_network_carriers` mnc ON mpn.`mobile_network_carrier_id` = mnc.`id`
WHERE mpn.`contact_id` = ?
";
		$arrValues = array($this->contact_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row && !empty($row)) {
			unset($row['id']);

			// Skip contact_id since we're using the Contact class as the data load starting point.
			//$contact_id = $row['contact_id'];
			$contact_phone_number_id = $row['contact_phone_number_id'];
			$mobile_network_carrier_id = $row['mobile_network_carrier_id'];

			$key = array(
				'contact_id' => $this->contact_id,
				'contact_phone_number_id' => $contact_phone_number_id
			);
			$mobilePhoneNumber = self::instantiateOrm($database, 'MobilePhoneNumber', $row, $key);
			/* @var $mobilePhoneNumber MobilePhoneNumber */
			$mobilePhoneNumber->convertPropertiesToData();

			if (isset($contact_phone_number_id)) {
				$row['id'] = $contact_phone_number_id;
				$contactPhoneNumber = self::instantiateOrm($database, 'ContactPhoneNumber', $row, null, $contact_phone_number_id);
				$contactPhoneNumber->convertPropertiesToData();
			} else {
				$contactPhoneNumber = false;
			}

			if (isset($mobile_network_carrier_id)) {
				$row['id'] = $mobile_network_carrier_id;
				$mobileNetworkCarrier = self::instantiateOrm($database, 'MobileNetworkCarrier', $row, null, $mobile_network_carrier_id);
				$mobileNetworkCarrier->convertPropertiesToData();
			} else {
				$mobileNetworkCarrier = false;
			}

			$mobilePhoneNumber->setContactPhoneNumber($contactPhoneNumber);
			$mobilePhoneNumber->setMobileNetworkCarrier($mobileNetworkCarrier);

			return $mobilePhoneNumber;
		} else {
			return false;
		}
	}

	/**
	 * Current implementation allows only one office to be linked to a contact at one time.
	 *
	 * @param int $contact_company_office_id
	 */
	public function linkContactToOffice($contact_company_office_id)
	{
		$contact_id = $this->contact_id;
		$database = $this->getDatabase();

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Check if the contact is linked another office
		$query =
"
SELECT `contact_company_office_id`
FROM `contacts_to_contact_company_offices`
WHERE `contact_id` = ?
";
//"AND `contact_company_office_id` = ? ";
		$arrValues = array($contact_id);
		$db->begin();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrContactCompanyOfficeIds = array();
		while ($row = $db->fetch()) {
			$id = $row['contact_company_office_id'];
			$arrContactCompanyOfficeIds[$id] = 1;
		}
		$db->free_result();

		if (isset($arrContactCompanyOfficeIds) && !empty($arrContactCompanyOfficeIds)) {
			// Check if the relationship exists already
			if (isset($arrContactCompanyOfficeIds[$contact_company_office_id])) {
				// unset here for later check
				unset($arrContactCompanyOfficeIds[$contact_company_office_id]);
			} else {
				$i = new IntegratedMapper('contacts_to_contact_company_offices');
				$i->setDatabase($database);
				$i->contact_id = $contact_id;
				$i->contact_company_office_id = $contact_company_office_id;
				$i->primary_office_flag = 'Y';
				$i->setAutoCommit(false);
				$i->save();
			}

			// Delete any offices other than the office being linked.
			if (isset($arrContactCompanyOfficeIds) && !empty($arrContactCompanyOfficeIds)) {
				foreach ($arrContactCompanyOfficeIds as $contact_company_office_id => $null) {
					$i = new IntegratedMapper('contacts_to_contact_company_offices');
					$i->setDatabase($database);
					$key = array(
						'contact_id' => $contact_id,
						'contact_company_office_id' => $contact_company_office_id,
					);
					$i->setKey($key);
					//$i->contact_id = $contact_id;
					//$i->contact_company_office_id = $contact_company_office_id;
					$i->setAutoCommit(false);
					$i->delete();
				}
			}
		} else {
			$i = new IntegratedMapper('contacts_to_contact_company_offices');
			$i->setDatabase($database);
			$i->contact_id = $contact_id;
			$i->contact_company_office_id = $contact_company_office_id;
			$i->primary_office_flag = 'Y';
			$i->setAutoCommit(false);
			$i->save();
		}
		$db->commit();
		$db->free_result();

		return true;
	}
	//To check email present in the contact or not
	public static function emailContactsByUserCompanyIdAndContactCompanyId($database, $user_company_id, $contact_company_id,$email)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query ="SELECT * FROM `contacts` WHERE `user_company_id` = ? AND `contact_company_id` = ?
		and `email` = ?";
		$arrValues = array($user_company_id, $contact_company_id,$email);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$row = $db->fetch();
		if($row)
		{
			$result="1";
		}else
		{
			$result="0";
		}
		
		$db->free_result();

		return $result;
	}

	// To check contact is archived or not
	public static function isUserArchive($database,$contact_id){
		$db = DBI::getInstance($database);
		$querycon ="SELECT is_archive FROM `contacts` WHERE `id` = ?";
		$arrValues = array($contact_id);
		$db->execute($querycon, $arrValues, MYSQLI_USE_RESULT);
		$row1 = $db->fetch();
		$isArchive=$row1['is_archive'];
		if($isArchive == 'Y'){
			$result = false;
		}else{
			$result = true;
		}
		$db->free_result();
		return $result;
	}

	//To check email present in the user or not
	public static function emailContactsAsUserOrNot($database, $contact_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */
		$querycon ="SELECT * FROM `contacts` WHERE `id` = ?";
		$arrValues = array($contact_id);
		$db->execute($querycon, $arrValues, MYSQLI_USE_RESULT);

		$row1 = $db->fetch();
		if($row1)
		{
			$email=$row1['email'];
			$db->free_result();
		

		$query ="SELECT * FROM `users` WHERE `email` = ?";
		$arrValues = array($email);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$row = $db->fetch();
			if($row)
			{
				$result="1";
			}else
			{
				$result="0";
			}
		}else
		{
			$result="0";
		}
		
		$db->free_result();

		return $result;
	}

	public static function loadContactsByUserCompanyIdAndContactCompanyId($database, $user_company_id, $contact_company_id,$is_archive)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		if ($is_archive == 1) {
			$archive = "AND `is_archive` = 'N'";
		}else if ($is_archive == 2){
			$archive = "AND `is_archive` = 'Y'";
		}else{
			$archive = '';
		}

		$query =
"
SELECT *
FROM `contacts`
WHERE `user_company_id` = ?
$archive
AND `contact_company_id` = ?
ORDER BY `name_prefix`, `first_name`, `additional_name`, `middle_name`, `last_name`, `name_suffix`, `email`
";
		$arrValues = array($user_company_id, $contact_company_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrContactsByUserCompanyIdAndContactCompanyId = array();
		while ($row = $db->fetch()) {
			$contact_id = $row['id'];
			$contact = self::instantiateOrm($database, 'Contact', $row, null, $contact_id);
			/* @var $contact Contact */

			$arrContactsByUserCompanyIdAndContactCompanyId[$contact_id] = $contact;
			$arrContactsByUserCompanyIdAndContactCompanyId[$contact_id]['name'] = $contact->getContactFullName();
		}
		$db->free_result();

		return $arrContactsByUserCompanyIdAndContactCompanyId;
	}

	public static function loadContactIdsListByUserCompanyIdAndContactCompanyId($database, $user_company_id, $contact_company_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT c.`id` 'contact_id'
FROM `contacts` c
WHERE `user_company_id` = ?
AND `contact_company_id` = ?
";
		$arrValues = array($user_company_id, $contact_company_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrRecords = array();
		while ($row = $db->fetch()) {
			$contact_id = $row['contact_id'];
			$arrRecords[] = $contact_id;
		}
		$db->free_result();

		return $arrRecords;
	}

	public static function loadContactsListByUserCompanyId($database, $user_company_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT *
FROM `contacts`
WHERE `user_company_id` = ?
".//AND `contact_company_id` = ?
"ORDER BY `name_prefix`, `first_name`, `additional_name`, `middle_name`, `last_name`, `name_suffix`, `email`
";
		$arrValues = array($user_company_id, $contact_company_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrRecords = array();
		while ($row = $db->fetch()) {
			$contact = new Contact($database);
			$contact->setData($row);
			$contact->convertDataToProperties();
			$arrRecords[] = $contact;
		}
		$db->free_result();

		return $arrRecords;
	}

	public static function loadContactsListByProjectId($database, $project_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT c.*
FROM `projects_to_contacts_to_roles` pcr,`contacts` c
WHERE pcr.`project_id` = ?
AND pcr.`contact_id` = c.`id`
ORDER BY `name_prefix`, `first_name`, `additional_name`, `middle_name`, `last_name`, `name_suffix`, `email`
";
		$arrValues = array($project_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrRecords = array();
		while ($row = $db->fetch()) {
			$contact = new Contact($database);
			$contact->setData($row);
			$contact->convertDataToProperties();
			$arrRecords[] = $contact;
		}
		$db->free_result();

		return $arrRecords;
	}

	public function addRolesToContactById($arrRoles)
	{
		$database = $this->getDatabase();
		$arrRoles = array();
		foreach ($arrRoleIds as $role_id => $data) {
			$role = new Role($database);
			//$
		}
	}

	public static function loadAdminContactIdListByUserCompanyId($database, $user_company_id)
	{
		$AXIS_USER_ROLE_ID_ADMIN = AXIS_USER_ROLE_ID_ADMIN;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT c.`id` 'contact_id'
FROM `contacts` c, `contact_companies` cc, `contacts_to_roles` c2r
WHERE c.`user_company_id` = ?
AND c.`contact_company_id` = cc.`id`
AND c.`is_archive` = 'N'
AND cc.`user_user_company_id` = cc.`contact_user_company_id`
AND cc.`user_user_company_id` = ?
AND c2r.`contact_id` = c.`id`
AND c2r.`role_id` = $AXIS_USER_ROLE_ID_ADMIN
";
			//"ORDER BY `name_prefix`, `first_name`, `additional_name`, `middle_name`, `last_name`, `name_suffix`, `email` ";
		$arrValues = array($user_company_id, $user_company_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrContactIds = array();
		while ($row = $db->fetch()) {
			$contact_id = $row['contact_id'];
			$arrContactIds[$contact_id] = 1;
		}
		$db->free_result();

		return $arrContactIds;
	}

	public function loadOwnedProjectRoles()
	{
		$database = $this->getDatabase();
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$contact_id = $this->contact_id;
		$user_company_id = $this->user_company_id;

		$arrProjectIds = array();
		// projects_to_contacts_to_roles, projects, roles
		$query =
"
SELECT

	p2c2r_fk_p.`id` AS 'p2c2r_fk_p__project_id',
	p2c2r_fk_p.`project_type_id` AS 'p2c2r_fk_p__project_type_id',
	p2c2r_fk_p.`user_company_id` AS 'p2c2r_fk_p__user_company_id',
	p2c2r_fk_p.`user_custom_project_id` AS 'p2c2r_fk_p__user_custom_project_id',
	p2c2r_fk_p.`project_name` AS 'p2c2r_fk_p__project_name',
	p2c2r_fk_p.`project_owner_name` AS 'p2c2r_fk_p__project_owner_name',
	p2c2r_fk_p.`latitude` AS 'p2c2r_fk_p__latitude',
	p2c2r_fk_p.`longitude` AS 'p2c2r_fk_p__longitude',
	p2c2r_fk_p.`address_line_1` AS 'p2c2r_fk_p__address_line_1',
	p2c2r_fk_p.`address_line_2` AS 'p2c2r_fk_p__address_line_2',
	p2c2r_fk_p.`address_line_3` AS 'p2c2r_fk_p__address_line_3',
	p2c2r_fk_p.`address_line_4` AS 'p2c2r_fk_p__address_line_4',
	p2c2r_fk_p.`address_city` AS 'p2c2r_fk_p__address_city',
	p2c2r_fk_p.`address_county` AS 'p2c2r_fk_p__address_county',
	p2c2r_fk_p.`address_state_or_region` AS 'p2c2r_fk_p__address_state_or_region',
	p2c2r_fk_p.`address_postal_code` AS 'p2c2r_fk_p__address_postal_code',
	p2c2r_fk_p.`address_postal_code_extension` AS 'p2c2r_fk_p__address_postal_code_extension',
	p2c2r_fk_p.`address_country` AS 'p2c2r_fk_p__address_country',
	p2c2r_fk_p.`building_count` AS 'p2c2r_fk_p__building_count',
	p2c2r_fk_p.`unit_count` AS 'p2c2r_fk_p__unit_count',
	p2c2r_fk_p.`gross_square_footage` AS 'p2c2r_fk_p__gross_square_footage',
	p2c2r_fk_p.`net_rentable_square_footage` AS 'p2c2r_fk_p__net_rentable_square_footage',
	p2c2r_fk_p.`is_active_flag` AS 'p2c2r_fk_p__is_active_flag',
	p2c2r_fk_p.`public_plans_flag` AS 'p2c2r_fk_p__public_plans_flag',
	p2c2r_fk_p.`prevailing_wage_flag` AS 'p2c2r_fk_p__prevailing_wage_flag',
	p2c2r_fk_p.`city_business_license_required_flag` AS 'p2c2r_fk_p__city_business_license_required_flag',
	p2c2r_fk_p.`is_internal_flag` AS 'p2c2r_fk_p__is_internal_flag',
	p2c2r_fk_p.`project_contract_date` AS 'p2c2r_fk_p__project_contract_date',
	p2c2r_fk_p.`project_start_date` AS 'p2c2r_fk_p__project_start_date',
	p2c2r_fk_p.`project_completed_date` AS 'p2c2r_fk_p__project_completed_date',
/*
	p2c2r_fk_c.`id` AS 'p2c2r_fk_c__contact_id',
	p2c2r_fk_c.`user_company_id` AS 'p2c2r_fk_c__user_company_id',
	p2c2r_fk_c.`user_id` AS 'p2c2r_fk_c__user_id',
	p2c2r_fk_c.`contact_company_id` AS 'p2c2r_fk_c__contact_company_id',
	p2c2r_fk_c.`email` AS 'p2c2r_fk_c__email',
	p2c2r_fk_c.`name_prefix` AS 'p2c2r_fk_c__name_prefix',
	p2c2r_fk_c.`first_name` AS 'p2c2r_fk_c__first_name',
	p2c2r_fk_c.`additional_name` AS 'p2c2r_fk_c__additional_name',
	p2c2r_fk_c.`middle_name` AS 'p2c2r_fk_c__middle_name',
	p2c2r_fk_c.`last_name` AS 'p2c2r_fk_c__last_name',
	p2c2r_fk_c.`name_suffix` AS 'p2c2r_fk_c__name_suffix',
	p2c2r_fk_c.`title` AS 'p2c2r_fk_c__title',
	p2c2r_fk_c.`vendor_flag` AS 'p2c2r_fk_c__vendor_flag',
*/
	p2c2r_fk_r.`id` AS 'p2c2r_fk_r__role_id',
	p2c2r_fk_r.`role` AS 'p2c2r_fk_r__role',
	p2c2r_fk_r.`role_description` AS 'p2c2r_fk_r__role_description',
	p2c2r_fk_r.`project_specific_flag` AS 'p2c2r_fk_r__project_specific_flag',
	p2c2r_fk_r.`sort_order` AS 'p2c2r_fk_r__sort_order',

		p2c2r.*

FROM `projects_to_contacts_to_roles` p2c2r
	INNER JOIN `projects` p2c2r_fk_p ON p2c2r.`project_id` = p2c2r_fk_p.`id`
	INNER JOIN `contacts` p2c2r_fk_c ON p2c2r.`contact_id` = p2c2r_fk_c.`id`
	INNER JOIN `roles` p2c2r_fk_r ON p2c2r.`role_id` = p2c2r_fk_r.`id`
WHERE p2c2r.`contact_id` = ?
AND p.`user_company_id` = ?
";
		$arrValues = array($contact_id, $user_company_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		$arrOwnedProjectRoles = array();
		while ($row = $db->fetch()) {
			$projectToContactToRole = self::instantiateOrm($database, 'ProjectToContactToRole', $row);
			/* @var $projectToContactToRole ProjectToContactToRole */
			$projectToContactToRole->convertPropertiesToData();

			if (isset($row['project_id'])) {
				$project_id = $row['project_id'];
				$row['p2c2r_fk_p__id'] = $project_id;
				$project = self::instantiateOrm($database, 'Project', $row, null, $project_id, 'p2c2r_fk_p__');
				/* @var $project Project */
				$project->convertPropertiesToData();
			} else {
				$project = false;
			}
			$projectToContactToRole->setProject($project);

			if (isset($row['contact_id'])) {
				$contact_id = $row['contact_id'];
				$row['p2c2r_fk_c__id'] = $contact_id;
				$contact = self::instantiateOrm($database, 'Contact', $row, null, $contact_id, 'p2c2r_fk_c__');
				/* @var $contact Contact */
				$contact->convertPropertiesToData();
			} else {
				$contact = false;
			}
			$projectToContactToRole->setContact($contact);

			if (isset($row['role_id'])) {
				$role_id = $row['role_id'];
				$row['p2c2r_fk_r__id'] = $role_id;
				$role = self::instantiateOrm($database, 'Role', $row, null, $role_id, 'p2c2r_fk_r__');
				/* @var $role Role */
				$role->convertPropertiesToData();
			} else {
				$role = false;
			}
			$projectToContactToRole->setRole($role);

			$arrOwnedProjectRoles[$project_id]['project'] = $project;
			$arrOwnedProjectRoles[$project_id]['roles'][$role_id] = $role;
		}
		$db->free_result();

		$this->setParentUserCompanyProjectsAndRoles($arrOwnedProjectRoles);
		//return $arrOwnedProjectRoles;
	}

	public static function convertPostToStandardContact($database, Egpcs $post)
	{
		/* @var $post Egpcs */

		$c = new Contact($database);
		$arrAttributes = $c->getArrAttributesMap();
		// Map the form fields/inputs to Class/Object Properties so flip the $arrAttributesMap
		$arrAttributes = array_flip($arrAttributes);
		$data = $post->getData();

		if (isset($data['email'])) {
			$data['email'] = strtolower($data['email']);
		}

		/*
		if (isset($data['first_name']) && isset($data['last_name'])) {
			$contactFullName = $data['first_name'].' '.$data['last_name'];
			$contactFullName = Data::singleSpace($contactFullName);
			$data['full_name'] = $contactFullName;
		}
		*/

		$newData = array_intersect_key($data, $arrAttributes);

		// Keys need to match the database key names
		$finalData = array();
		foreach ($newData as $k => $v) {
			$databaseAttribute = $arrAttributes[$k];
			$finalData[$databaseAttribute] = $v;
		}

		$c->setData($finalData);
		$c->convertDataToProperties();

		return $c;
	}

	/**
	 * Conditionally invoke the standard save() method after deltification.
	 *
	 */
	public function deltifyAndSave()
	{
		//load existing

		//deltify

		//save (insert, update, or do nothing)

		$this->convertPropertiesToData();
		$newData = $this->getData();
		$row = $newData;

		// GUIDs/ID, etc.
		// unique index (`user_company_id`, `contact_company_id`, `email`, `first_name`, `last_name`)
		$user_company_id = (int) $this->user_company_id;
		$contact_company_id = (int) $this->contact_company_id;
		$email = (string) $this->email;
		$first_name = (string) $this->first_name;
		$last_name = (string) $this->last_name;

		$key = array(
			'user_company_id' => $user_company_id,
			'contact_company_id' => $contact_company_id,
			'email' => $email,
			'first_name' => $first_name,
			'last_name' => $last_name
		);

		$database = $this->getDatabase();
		$tmpObject = new Contact($database);
		$tmpObject->setKey($key);
		$tmpObject->load();

		/**
		 * Conditionally Insert/Update the record.
		 *
		 * $key is conditionally set based on if record exists.
		 */
		$newData = $row;

		//Iterate over latest input from data feed and only set different values.
		//Same values will be key unset to acheive a conditional update.
		$save = false;
		$existsFlag = $tmpObject->isDataLoaded();
		if ($existsFlag) {
			// Conditionally Update the record
			// Don't compare the key values that loaded the record.
			$id = $tmpObject->id;
			unset($tmpObject->id);

			$existingData = $tmpObject->getData();

			$data = Data::deltify($existingData, $newData);
			if (!empty($data)) {
				$tmpObject->setData($data);
				$save = true;
			}
		} else {
			// Insert the record
			$tmpObject->setKey(null);
			$tmpObject->setData($newData);
			$save = true;
		}

		// Save if needed (conditionally Insert/Update)
		if ($save) {
			if ($existsFlag) {
				$tmpObject->save();
			} else {
				$id = $tmpObject->save();
			}

			if (isset($id) && ($id != 0)) {
				$this->setId($id);
			}
		}

		return $id;
	}

	public static function loadSignatorMembers($database, $user_company_id, $project_id)
	{
		$db = DBI::getInstance();
		//To get the company users
		 $query ="	SELECT  c.`user_company_id`, c.`user_id`, c.`contact_company_id`, c.`email`, c.`name_prefix`, c.`first_name`, c.`additional_name`, c.`middle_name`, c.`last_name`, c.`name_suffix`, c.`title`, c.`vendor_flag`,uc.`company`, u.* FROM `users` as u 
		 inner join contacts as c on u.primary_contact_id = c.id
		 inner join `user_companies` as uc on uc.id=u.user_company_id WHERE u.`user_company_id` = ? ";

		$arrValues = array($user_company_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSignatorTeamMembers = array();
		while ($row = $db->fetch()) {
			if($row['primary_contact_id'] !='1')
			{
			$arrSignatorTeamMembers[$row['primary_contact_id']]['user_id']=$row['user_id'];
			$arrSignatorTeamMembers[$row['primary_contact_id']]['contact_id']=$row['primary_contact_id'];
			$arrSignatorTeamMembers[$row['primary_contact_id']]['first_name']=$row['first_name'];
			$arrSignatorTeamMembers[$row['primary_contact_id']]['last_name']=$row['last_name'];
			$arrSignatorTeamMembers[$row['primary_contact_id']]['email']=$row['email'];
			$arrSignatorTeamMembers[$row['primary_contact_id']]['user_company_id']=$row['user_company_id'];
			$arrSignatorTeamMembers[$row['primary_contact_id']]['contact_company_id']=$row['contact_company_id'];
			$arrSignatorTeamMembers[$row['primary_contact_id']]['title']=$row['title'];
			$arrSignatorTeamMembers[$row['primary_contact_id']]['company']=$row['company'];
			if($row['first_name']!='' && $row['last_name'] !='')
			{
			$arrSignatorTeamMembers[$row['primary_contact_id']]['ContactFullName']=$row['first_name'].' '.$row['last_name'].' &lt;'.$row['email'].'&gt;';
		}else
		{
			$arrSignatorTeamMembers[$row['primary_contact_id']]['ContactFullName']=$row['email'];
		}
	}
		}
		$db->free_result();
		
		//To get the projects PM and PE
		 $query1 ="	SELECT  c.`user_company_id`, c.`user_id`, c.`contact_company_id`, c.`email`, c.`name_prefix`, c.`first_name`, c.`additional_name`, c.`middle_name`, c.`last_name`, c.`name_suffix`, c.`title`, c.`vendor_flag`,cc.`company`,p.* FROM `projects_to_contacts_to_roles` as p 
		 inner join contacts as c on p.contact_id = c.id
		 inner join contact_companies as cc on  cc.id=c.contact_company_id WHERE p.`project_id` = ? and p.role_id IN (4,5) ";

		$arrValues = array($project_id);
		$db->execute($query1, $arrValues, MYSQLI_USE_RESULT);
		while ($row1 = $db->fetch()) {
			$arrSignatorTeamMembers[$row1['contact_id']]['user_id']=$row1['user_id'];
			$arrSignatorTeamMembers[$row1['contact_id']]['contact_id']=$row1['contact_id'];
			$arrSignatorTeamMembers[$row1['contact_id']]['first_name']=$row1['first_name'];
			$arrSignatorTeamMembers[$row1['contact_id']]['last_name']=$row1['last_name'];
			$arrSignatorTeamMembers[$row1['contact_id']]['email']=$row1['email'];
			$arrSignatorTeamMembers[$row1['contact_id']]['user_company_id']=$row1['user_company_id'];
			$arrSignatorTeamMembers[$row1['contact_id']]['contact_company_id']=$row1['contact_company_id'];
			$arrSignatorTeamMembers[$row1['contact_id']]['title']=$row1['title'];
			$arrSignatorTeamMembers[$row1['contact_id']]['company']=$row1['company'];
			if($row1['first_name']!='' && $row1['last_name'] !='')
			{
			$arrSignatorTeamMembers[$row1['contact_id']]['ContactFullName']=$row1['first_name'].' '.$row1['last_name'].' &lt;'.$row1['email'].'&gt;';
		}else
		{
			$arrSignatorTeamMembers[$row1['contact_id']]['ContactFullName']=$row1['email'];
		}
		}


		return $arrSignatorTeamMembers;

	}

	public static function loadProjectTeamMembersNew($database, $project_id, $softwareModule, $rolesMemID=null,$company=null,$bidder=null,$filter=null,$search=null)
	{
		$AXIS_USER_ROLE_ID_USER = AXIS_USER_ROLE_ID_USER;
		$AXIS_USER_ROLE_ID_BIDDER = AXIS_USER_ROLE_ID_BIDDER;

		$db = DBI::getInstance($database);
		$arrContactTeamMembers = array();	
		$whereIn = ""	;

		if($rolesMemID != '' || $rolesMemID != null){
			$whereIn = 'and p2c2r.role_id IN ('.$rolesMemID.')';
		}

		if($company != '' || $company != null){			
			$whereIn="and c_fk_cc.`id`=$company";
		}
		if($search !="" ||$search !=null)
		{
			$searchfil ="and ((c.`email` LIKE '".$search."%' OR c.`first_name` LIKE '".$search."%' ) OR c_fk_cc.`company` Like '".$search."%')";
		}

		$orderby= " r.`sort_order` ASC, c_fk_cc.`company` ASC, c.`first_name` ASC, c.`last_name` ASC, c.`email` ASC";		
		
		$query =
"
SELECT
	c_fk_cc.`id` AS 'c_fk_cc__contact_company_id',
	c_fk_cc.`user_user_company_id` AS 'c_fk_cc__user_user_company_id',
	c_fk_cc.`contact_user_company_id` AS 'c_fk_cc__contact_user_company_id',
	c_fk_cc.`company` AS 'c_fk_cc__company',
	c_fk_cc.`primary_phone_number` AS 'c_fk_cc__primary_phone_number',
	c_fk_cc.`employer_identification_number` AS 'c_fk_cc__employer_identification_number',
	c_fk_cc.`construction_license_number` AS 'c_fk_cc__construction_license_number',
	c_fk_cc.`construction_license_number_expiration_date` AS 'c_fk_cc__construction_license_number_expiration_date',
	c_fk_cc.`vendor_flag` AS 'c_fk_cc__vendor_flag',

	c.*

FROM `contacts` c
	INNER JOIN `user_companies` c_fk_uc ON c.`user_company_id` = c_fk_uc.`id`
	INNER JOIN `users` c_fk_u ON c.`user_id` = c_fk_u.`id`
	INNER JOIN `contact_companies` c_fk_cc ON c.`contact_company_id` = c_fk_cc.`id`
	INNER JOIN `projects_to_contacts_to_roles` p2c2r ON p2c2r.`contact_id` = c.`id`
	INNER JOIN `roles` r ON p2c2r.`role_id` = r.`id`
	
	WHERE p2c2r.`project_id` = ? AND c.`is_archive` = 'N' $whereIn $searchfil ORDER BY $orderby
";

		$arrValues = array($project_id);
		$db->execute($query, $arrValues,MYSQLI_USE_RESULT);

		while($row = $db->fetch())
		{
			$val=$row['id'];
			$exist= array_key_exists($val,$arrContactTeamMembers);
			if(!$exist){
				$arrContactTeamMembers[$val]=$row;
			}
		}

		$db->free_result();

		foreach ($arrContactTeamMembers as  $value) {
			$quer1="SELECT GROUP_CONCAT(`role_id`) as role_id FROM `projects_to_contacts_to_roles` WHERE `project_id` = ? AND `contact_id` = ?";
			$arrMoudle = array($project_id,$value['id']);
			$db->execute($quer1, $arrMoudle);
			$roleIds = $db->fetch();
			$db->free_result();
			$role = explode(',', $roleIds['role_id']);
			if ((in_array($AXIS_USER_ROLE_ID_USER, $role) && in_array($AXIS_USER_ROLE_ID_BIDDER, $role) && count($role) == 2)) {
				unset($arrContactTeamMembers[$value['id']]);
			}
			
		}

		$moudleId = "
SELECT GROUP_CONCAT(smf.`id`) as id FROM `software_modules` s
INNER JOIN `software_module_functions` smf ON s.`id` = smf.`software_module_id`
WHERE s.`software_module` = ? 
";
		$arrMoudle = array($softwareModule);
		$db->execute($moudleId,$arrMoudle);
		$softModIds = $db->fetch();
		$softModId = $softModIds['id'];

		$db->free_result();

	$queryRareCase =
"
SELECT
	c_fk_cc.`id` AS 'c_fk_cc__contact_company_id',
	c_fk_cc.`user_user_company_id` AS 'c_fk_cc__user_user_company_id',
	c_fk_cc.`contact_user_company_id` AS 'c_fk_cc__contact_user_company_id',
	c_fk_cc.`company` AS 'c_fk_cc__company',
	c_fk_cc.`primary_phone_number` AS 'c_fk_cc__primary_phone_number',
	c_fk_cc.`employer_identification_number` AS 'c_fk_cc__employer_identification_number',
	c_fk_cc.`construction_license_number` AS 'c_fk_cc__construction_license_number',
	c_fk_cc.`construction_license_number_expiration_date` AS 'c_fk_cc__construction_license_number_expiration_date',
	c_fk_cc.`vendor_flag` AS 'c_fk_cc__vendor_flag',

	c.*

FROM `contacts` c
	INNER JOIN `user_companies` c_fk_uc ON c.`user_company_id` = c_fk_uc.`id`
	INNER JOIN `users` c_fk_u ON c.`user_id` = c_fk_u.`id`
	INNER JOIN `contact_companies` c_fk_cc ON c.`contact_company_id` = c_fk_cc.`id`
	INNER JOIN `projects_to_contacts_to_software_module_functions` p2c2r ON p2c2r.`contact_id` = c.`id`

	WHERE p2c2r.`project_id` = ? and p2c2r.`software_module_function_id` IN ($softModId) $searchfil ORDER BY c.`first_name` ASC, c.`last_name` ASC, c.`email` ASC
";

		$arrRareCase = array($project_id);
		$db->execute($queryRareCase, $arrRareCase);

		while($row = $db->fetch())
		{
			$val=$row['id'];
			$row['c_fk_cc__company'] = "Rare Case";
			$exist= array_key_exists($val,$arrContactTeamMembers);
			if(!$exist){
				$arrContactTeamMembers[$val]=$row;
			}
		}

		$db->free_result();

		return $arrContactTeamMembers;
	}

	public static function loadProjectTeamMembers($database, $project_id, $rolesMemID=null,$bidder=null,$filter=null)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */
		//The contact should not be a bidder and he should assign with some other role in that project
		// if rolesMemID not null select only with in roles using roles_id
		if($rolesMemID != '' || $rolesMemID != null){
		$whereIn = 'and p2c2r.role_id IN ('.$rolesMemID.')';
		}else{
			$whereIn = '';
		}
		if($bidder=='1')
		{
			$wherebid="and p2c2r.role_id not IN ('3')";
		}else
		{
			$wherebid="and p2c2r.role_id not IN ('14','3')";
		}
		if($filter)
		{
			$orderby= "c_fk_cc__company ASC, r.`sort_order` ASC, r.`role` ASC, c.`last_name` ASC, c.`first_name` ASC";
		}else
		{
			$orderby= " r.`sort_order` ASC, r.`role` ASC, c.`last_name` ASC, c.`first_name` ASC";
		}

	$query =
"
SELECT

	c_fk_uc.`id` AS 'c_fk_uc__user_company_id',
	c_fk_uc.`company` AS 'c_fk_uc__company',
	c_fk_uc.`primary_phone_number` AS 'c_fk_uc__primary_phone_number',
	c_fk_uc.`employer_identification_number` AS 'c_fk_uc__employer_identification_number',
	c_fk_uc.`construction_license_number` AS 'c_fk_uc__construction_license_number',
	c_fk_uc.`construction_license_number_expiration_date` AS 'c_fk_uc__construction_license_number_expiration_date',
	c_fk_uc.`paying_customer_flag` AS 'c_fk_uc__paying_customer_flag',

	c_fk_u.`id` AS 'c_fk_u__user_id',
	c_fk_u.`user_company_id` AS 'c_fk_u__user_company_id',
	c_fk_u.`role_id` AS 'c_fk_u__role_id',
	c_fk_u.`default_project_id` AS 'c_fk_u__default_project_id',
	c_fk_u.`primary_contact_id` AS 'c_fk_u__primary_contact_id',
	c_fk_u.`mobile_network_carrier_id` AS 'c_fk_u__mobile_network_carrier_id',
	c_fk_u.`user_image_id` AS 'c_fk_u__user_image_id',
	c_fk_u.`security_image_id` AS 'c_fk_u__security_image_id',
	c_fk_u.`html_template_theme_id` AS 'c_fk_u__html_template_theme_id',
	c_fk_u.`mobile_phone_number` AS 'c_fk_u__mobile_phone_number',
	c_fk_u.`screen_name` AS 'c_fk_u__screen_name',
	c_fk_u.`email` AS 'c_fk_u__email',
	c_fk_u.`password_hash` AS 'c_fk_u__password_hash',
	c_fk_u.`password_guid` AS 'c_fk_u__password_guid',
	c_fk_u.`security_phrase` AS 'c_fk_u__security_phrase',
	c_fk_u.`modified` AS 'c_fk_u__modified',
	c_fk_u.`accessed` AS 'c_fk_u__accessed',
	c_fk_u.`created` AS 'c_fk_u__created',
	c_fk_u.`alerts` AS 'c_fk_u__alerts',
	c_fk_u.`tc_accepted_flag` AS 'c_fk_u__tc_accepted_flag',
	c_fk_u.`email_subscribe_flag` AS 'c_fk_u__email_subscribe_flag',
	c_fk_u.`remember_me_flag` AS 'c_fk_u__remember_me_flag',
	c_fk_u.`change_password_flag` AS 'c_fk_u__change_password_flag',
	c_fk_u.`disabled_flag` AS 'c_fk_u__disabled_flag',
	c_fk_u.`deleted_flag` AS 'c_fk_u__deleted_flag',

	c_fk_cc.`id` AS 'c_fk_cc__contact_company_id',
	c_fk_cc.`user_user_company_id` AS 'c_fk_cc__user_user_company_id',
	c_fk_cc.`contact_user_company_id` AS 'c_fk_cc__contact_user_company_id',
	c_fk_cc.`company` AS 'c_fk_cc__company',
	c_fk_cc.`primary_phone_number` AS 'c_fk_cc__primary_phone_number',
	c_fk_cc.`employer_identification_number` AS 'c_fk_cc__employer_identification_number',
	c_fk_cc.`construction_license_number` AS 'c_fk_cc__construction_license_number',
	c_fk_cc.`construction_license_number_expiration_date` AS 'c_fk_cc__construction_license_number_expiration_date',
	c_fk_cc.`vendor_flag` AS 'c_fk_cc__vendor_flag',

	c.*

FROM `contacts` c
	INNER JOIN `user_companies` c_fk_uc ON c.`user_company_id` = c_fk_uc.`id`
	INNER JOIN `users` c_fk_u ON c.`user_id` = c_fk_u.`id`
	INNER JOIN `contact_companies` c_fk_cc ON c.`contact_company_id` = c_fk_cc.`id`

	INNER JOIN `projects_to_contacts_to_roles` p2c2r ON p2c2r.`contact_id` = c.`id`
	INNER JOIN `roles` r ON p2c2r.`role_id` = r.`id`
	
WHERE p2c2r.`project_id` = ? $wherebid $whereIn ORDER BY $orderby
";
//INNER JOIN `role_groups_to_roles` rg2r ON r.`id` = rg2r.`role_id` 	INNER JOIN `role_groups` rg ON rg2r.`role_group_id` = rg.`id`
		$arrValues = array($project_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrContactTeamMembers = array();
		while ($row = $db->fetch()) {
			$contact_id = $row['id'];
			$contact = self::instantiateOrm($database, 'Contact', $row, null, $contact_id);
			/* @var $contact Contact */
			$contact->convertPropertiesToData();

			if (isset($row['user_company_id'])) {
				$user_company_id = $row['user_company_id'];
				$row['c_fk_uc__id'] = $user_company_id;
				$userCompany = self::instantiateOrm($database, 'UserCompany', $row, null, $user_company_id, 'c_fk_uc__');
				/* @var $userCompany UserCompany */
				$userCompany->convertPropertiesToData();
			} else {
				$userCompany = false;
			}
			$contact->setUserCompany($userCompany);

			if (isset($row['user_id'])) {
				$user_id = $row['user_id'];
				$row['c_fk_u__id'] = $user_id;
				$user = self::instantiateOrm($database, 'User', $row, null, $user_id, 'c_fk_u__');
				/* @var $user User */
				$user->convertPropertiesToData();
			} else {
				$user = false;
			}
			$contact->setUser($user);

			if (isset($row['contact_company_id'])) {
				$contact_company_id = $row['contact_company_id'];
				$row['c_fk_cc__id'] = $contact_company_id;
				$contactCompany = self::instantiateOrm($database, 'ContactCompany', $row, null, $contact_company_id, 'c_fk_cc__');
				/* @var $contactCompany ContactCompany */
				$contactCompany->convertPropertiesToData();
			} else {
				$contactCompany = false;
			}
			$contact->setContactCompany($contactCompany);

			$arrContactTeamMembers[$contact_id]  = $contact;
		}
		$db->free_result();

		return $arrContactTeamMembers;
	}

	public static function loadContactsByUserCompanyIdAndPartialFirstNameAndPartialLastNameAndPartialCompany($database, $user_company_id, $first_name, $last_name, $company, Input $options=null)
	{
		if (isset($options)) {
			$arrOrderByAttributes = $options->arrOrderByAttributes;
			$limit = $options->limit;
			$offset = $options->offset;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `user_company_id` ASC, `user_id` ASC, `contact_company_id` ASC, `email` ASC, `name_prefix` ASC, `first_name` ASC, `additional_name` ASC, `middle_name` ASC, `last_name` ASC, `name_suffix` ASC, `title` ASC, `vendor_flag` ASC
		$sqlOrderBy = "\nORDER BY c_fk_cc.`company` ASC, c.`first_name` ASC, c.`last_name` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpContact = new Contact($database);
			$sqlOrderByColumns = $tmpContact->constructSqlOrderByColumns($arrOrderByAttributes);

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

		$queryFilter = '';
		$arrQueryFilter = array();

		if (strlen($company) > 1) {
			$escapedCompany = $db->escape($company);
			$arrQueryFilter[] = "(c_fk_cc.`company` LIKE '%$escapedCompany%')";
		}
		if (strlen($first_name) > 1) {
			$escapedFirstName = $db->escape($first_name);
			$arrQueryFilter[] = "(c.`first_name` LIKE '%$escapedFirstName%')";
		}
		if (strlen($last_name) > 1) {
			$escapedLastName = $db->escape($last_name);
			$arrQueryFilter[] = "(c.`last_name` LIKE '%$escapedLastName%')";
		}

		if (!empty($arrQueryFilter)) {
			$queryFilter = join(' AND ', $arrQueryFilter);
			$queryFilter = "AND ($queryFilter)";
		}

		$query =
"
SELECT

	c_fk_uc.`id` AS 'c_fk_uc__user_company_id',
	c_fk_uc.`company` AS 'c_fk_uc__company',
	c_fk_uc.`primary_phone_number` AS 'c_fk_uc__primary_phone_number',
	c_fk_uc.`employer_identification_number` AS 'c_fk_uc__employer_identification_number',
	c_fk_uc.`construction_license_number` AS 'c_fk_uc__construction_license_number',
	c_fk_uc.`construction_license_number_expiration_date` AS 'c_fk_uc__construction_license_number_expiration_date',
	c_fk_uc.`paying_customer_flag` AS 'c_fk_uc__paying_customer_flag',

	c_fk_u.`id` AS 'c_fk_u__user_id',
	c_fk_u.`user_company_id` AS 'c_fk_u__user_company_id',
	c_fk_u.`role_id` AS 'c_fk_u__role_id',
	c_fk_u.`default_project_id` AS 'c_fk_u__default_project_id',
	c_fk_u.`primary_contact_id` AS 'c_fk_u__primary_contact_id',
	c_fk_u.`mobile_network_carrier_id` AS 'c_fk_u__mobile_network_carrier_id',
	c_fk_u.`user_image_id` AS 'c_fk_u__user_image_id',
	c_fk_u.`security_image_id` AS 'c_fk_u__security_image_id',
	c_fk_u.`html_template_theme_id` AS 'c_fk_u__html_template_theme_id',
	c_fk_u.`mobile_phone_number` AS 'c_fk_u__mobile_phone_number',
	c_fk_u.`screen_name` AS 'c_fk_u__screen_name',
	c_fk_u.`email` AS 'c_fk_u__email',
	c_fk_u.`password_hash` AS 'c_fk_u__password_hash',
	c_fk_u.`password_guid` AS 'c_fk_u__password_guid',
	c_fk_u.`security_phrase` AS 'c_fk_u__security_phrase',
	c_fk_u.`modified` AS 'c_fk_u__modified',
	c_fk_u.`accessed` AS 'c_fk_u__accessed',
	c_fk_u.`created` AS 'c_fk_u__created',
	c_fk_u.`alerts` AS 'c_fk_u__alerts',
	c_fk_u.`tc_accepted_flag` AS 'c_fk_u__tc_accepted_flag',
	c_fk_u.`email_subscribe_flag` AS 'c_fk_u__email_subscribe_flag',
	c_fk_u.`remember_me_flag` AS 'c_fk_u__remember_me_flag',
	c_fk_u.`change_password_flag` AS 'c_fk_u__change_password_flag',
	c_fk_u.`disabled_flag` AS 'c_fk_u__disabled_flag',
	c_fk_u.`deleted_flag` AS 'c_fk_u__deleted_flag',

	c_fk_cc.`id` AS 'c_fk_cc__contact_company_id',
	c_fk_cc.`user_user_company_id` AS 'c_fk_cc__user_user_company_id',
	c_fk_cc.`contact_user_company_id` AS 'c_fk_cc__contact_user_company_id',
	c_fk_cc.`company` AS 'c_fk_cc__company',
	c_fk_cc.`primary_phone_number` AS 'c_fk_cc__primary_phone_number',
	c_fk_cc.`employer_identification_number` AS 'c_fk_cc__employer_identification_number',
	c_fk_cc.`construction_license_number` AS 'c_fk_cc__construction_license_number',
	c_fk_cc.`construction_license_number_expiration_date` AS 'c_fk_cc__construction_license_number_expiration_date',
	c_fk_cc.`vendor_flag` AS 'c_fk_cc__vendor_flag',

	c.*

FROM `contacts` c
	INNER JOIN `user_companies` c_fk_uc ON c.`user_company_id` = c_fk_uc.`id`
	INNER JOIN `users` c_fk_u ON c.`user_id` = c_fk_u.`id`
	INNER JOIN `contact_companies` c_fk_cc ON c.`contact_company_id` = c_fk_cc.`id`
WHERE c.`user_company_id` = ?
{$queryFilter}{$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array($user_company_id);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);

		$arrContacts = array();
		while ($row = $db->fetch()) {
			$contact_id = $row['id'];
			$contact = self::instantiateOrm($database, 'Contact', $row, null, $contact_id);
			/* @var $contact Contact */
			$contact->convertPropertiesToData();

			if (isset($row['user_company_id'])) {
				$user_company_id = $row['user_company_id'];
				$row['c_fk_uc__id'] = $user_company_id;
				$userCompany = self::instantiateOrm($database, 'UserCompany', $row, null, $user_company_id, 'c_fk_uc__');
				/* @var $userCompany UserCompany */
				$userCompany->convertPropertiesToData();
			} else {
				$userCompany = false;
			}
			$contact->setUserCompany($userCompany);

			if (isset($row['user_id'])) {
				$user_id = $row['user_id'];
				$row['c_fk_u__id'] = $user_id;
				$user = self::instantiateOrm($database, 'User', $row, null, $user_id, 'c_fk_u__');
				/* @var $user User */
				$user->convertPropertiesToData();
			} else {
				$user = false;
			}
			$contact->setUser($user);

			if (isset($row['contact_company_id'])) {
				$contact_company_id = $row['contact_company_id'];
				$row['c_fk_cc__id'] = $contact_company_id;
				$contactCompany = self::instantiateOrm($database, 'ContactCompany', $row, null, $contact_company_id, 'c_fk_cc__');
				/* @var $contactCompany ContactCompany */
				$contactCompany->convertPropertiesToData();
			} else {
				$contactCompany = false;
			}
			$contact->setContactCompany($contactCompany);

			$arrContacts[$contact_id] = $contact;
		}

		$db->free_result();

		return $arrContacts;
	}
	/*check the email is alredy exists*/
	public static function verifyEmailUsingEnteredEmail($database, $contactCompanyId, $email)
	{
		$db = DBI::getInstance($database);
		$db->free_result();
		/* @var $db DBI_mysqli */

		$query =	"SELECT * FROM `contacts` WHERE `email` = ? AND contact_company_id = ? ";
		$arrValues = array($email, $contactCompanyId);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrContactsByUserCompanyIdAndContactCompanyId = '';
		while ($row = $db->fetch()) {
			$contact_id = $row['id'];
			/* @var $contact Contact */
			$arrContactsByUserCompanyIdAndContactCompanyId = $contact_id;
		}
		$db->free_result();

		return $arrContactsByUserCompanyIdAndContactCompanyId;
	}
	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `contacts_fk_uc` foreign key (`user_company_id`) references `user_companies` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $user_company_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubcontractsByProjectIdAndCostCodeIdOld($database, $user_company_id,$costcode = 0, $project_id,Input $options=null)
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
			self::$_arrContactsByUserCompanyId = null;
		}

		$arrContactsByUserCompanyId = self::$_arrContactsByUserCompanyId;
		if (isset($arrContactsByUserCompanyId) && !empty($arrContactsByUserCompanyId)) {
			return $arrContactsByUserCompanyId;
		}

		$user_company_id = (int) $user_company_id;

		//To get the project company cost code data
		$session = Zend_Registry::get('session');
		$currentlySelectedProjectUserCompanyId = $session->getCurrentlySelectedProjectUserCompanyId();
		if($user_company_id != $currentlySelectedProjectUserCompanyId)
		{
			$user_company_id = $currentlySelectedProjectUserCompanyId;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */
		//to get the cost code
		 $costCodeQuery = "SELECT group_concat(subcontract_vendor_contact_id ) as vendor_id FROM `subcontracts` WHERE `gc_budget_line_item_id` = (SELECT id FROM `gc_budget_line_items` WHERE `project_id` = $project_id AND `cost_code_id` = $costcode ORDER BY `id` DESC ) ORDER BY `id` DESC ";
	
	$db->execute($costCodeQuery);
	$costCode = $db->fetch();
	$vendor_ids=$costCode['vendor_id'];
	if($vendor_ids){
		$filter = "FIELD (c.id, $vendor_ids ) DESC ,";
		//To split costvendor
		$data=explode(',',$vendor_ids);
		$vendorvalue='';
		foreach($data as $eachval)
		{
	   	 $vendorvalue .="'".$eachval."',";
		}
		$vendorvalue=trim($vendorvalue,',');
   }else{
		$filter = '';
   }
  $db->free_result();
  $sqlOrderBy = "\nORDER BY $filter c_fk_cc.`company` ASC, c.`first_name` ASC, c.`last_name` ASC, c.`email` ASC";
	if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
		$tmpContact = new Contact($database);
		$sqlOrderByColumns = $tmpContact->constructSqlOrderByColumns($arrOrderByAttributes);

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

    $contactCompanyQuery = "SELECT cc.id as comp_id FROM `gc_budget_line_items` as gc
    inner join `subcontracts` as s on gc.id=s.gc_budget_line_item_id 
    inner join `vendors` as v on v.id=s.vendor_id 
    inner join `contact_companies` as cc on cc.id=v.vendor_contact_company_id 
    WHERE gc.`user_company_id` = $user_company_id AND gc.`project_id` = $project_id 
    AND gc.`cost_code_id` = $costcode and s.unsigned_subcontract_file_manager_file_id!='' ";
	
	$db->execute($contactCompanyQuery);
	$contactCompanyRow = $db->fetch();
	$contactCompanyIds = $contactCompanyRow['comp_id'];
	$db->free_result();

		 $query =
"
SELECT

	c_fk_uc.`id` AS 'c_fk_uc__user_company_id',
	c_fk_uc.`company` AS 'c_fk_uc__company',
	c_fk_uc.`primary_phone_number` AS 'c_fk_uc__primary_phone_number',
	c_fk_uc.`employer_identification_number` AS 'c_fk_uc__employer_identification_number',
	c_fk_uc.`construction_license_number` AS 'c_fk_uc__construction_license_number',
	c_fk_uc.`construction_license_number_expiration_date` AS 'c_fk_uc__construction_license_number_expiration_date',
	c_fk_uc.`paying_customer_flag` AS 'c_fk_uc__paying_customer_flag',

	c_fk_u.`id` AS 'c_fk_u__user_id',
	c_fk_u.`user_company_id` AS 'c_fk_u__user_company_id',
	c_fk_u.`role_id` AS 'c_fk_u__role_id',
	c_fk_u.`default_project_id` AS 'c_fk_u__default_project_id',
	c_fk_u.`primary_contact_id` AS 'c_fk_u__primary_contact_id',
	c_fk_u.`mobile_network_carrier_id` AS 'c_fk_u__mobile_network_carrier_id',
	c_fk_u.`user_image_id` AS 'c_fk_u__user_image_id',
	c_fk_u.`security_image_id` AS 'c_fk_u__security_image_id',
	c_fk_u.`html_template_theme_id` AS 'c_fk_u__html_template_theme_id',
	c_fk_u.`mobile_phone_number` AS 'c_fk_u__mobile_phone_number',
	c_fk_u.`screen_name` AS 'c_fk_u__screen_name',
	c_fk_u.`email` AS 'c_fk_u__email',
	c_fk_u.`password_hash` AS 'c_fk_u__password_hash',
	c_fk_u.`password_guid` AS 'c_fk_u__password_guid',
	c_fk_u.`security_phrase` AS 'c_fk_u__security_phrase',
	c_fk_u.`modified` AS 'c_fk_u__modified',
	c_fk_u.`accessed` AS 'c_fk_u__accessed',
	c_fk_u.`created` AS 'c_fk_u__created',
	c_fk_u.`alerts` AS 'c_fk_u__alerts',
	c_fk_u.`tc_accepted_flag` AS 'c_fk_u__tc_accepted_flag',
	c_fk_u.`email_subscribe_flag` AS 'c_fk_u__email_subscribe_flag',
	c_fk_u.`remember_me_flag` AS 'c_fk_u__remember_me_flag',
	c_fk_u.`change_password_flag` AS 'c_fk_u__change_password_flag',
	c_fk_u.`disabled_flag` AS 'c_fk_u__disabled_flag',
	c_fk_u.`deleted_flag` AS 'c_fk_u__deleted_flag',

	c_fk_cc.`id` AS 'c_fk_cc__contact_company_id',
	c_fk_cc.`user_user_company_id` AS 'c_fk_cc__user_user_company_id',
	c_fk_cc.`contact_user_company_id` AS 'c_fk_cc__contact_user_company_id',
	c_fk_cc.`company` AS 'c_fk_cc__company',
	c_fk_cc.`primary_phone_number` AS 'c_fk_cc__primary_phone_number',
	c_fk_cc.`employer_identification_number` AS 'c_fk_cc__employer_identification_number',
	c_fk_cc.`construction_license_number` AS 'c_fk_cc__construction_license_number',
	c_fk_cc.`construction_license_number_expiration_date` AS 'c_fk_cc__construction_license_number_expiration_date',
	c_fk_cc.`vendor_flag` AS 'c_fk_cc__vendor_flag',

	c.*

    FROM `contacts` c
	INNER JOIN `user_companies` c_fk_uc ON c.`user_company_id` = c_fk_uc.`id`
	INNER JOIN `users` c_fk_u ON c.`user_id` = c_fk_u.`id`
	INNER JOIN `contact_companies` c_fk_cc ON c.`contact_company_id` = c_fk_cc.`id` 
	AND c.`contact_company_id` IN (?)
    WHERE c.`user_company_id` = ? AND c.`is_archive`='N' {$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array($contactCompanyIds, $user_company_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrContactsByUserCompanyId = array();
		while ($row = $db->fetch()) {
			$contact_id = $row['id'];
			$contact = self::instantiateOrm($database, 'Contact', $row, null, $contact_id);
			/* @var $contact Contact */
			$contact->convertPropertiesToData();

			if (isset($row['user_company_id'])) {
				$user_company_id = $row['user_company_id'];
				$row['c_fk_uc__id'] = $user_company_id;
				$userCompany = self::instantiateOrm($database, 'UserCompany', $row, null, $user_company_id, 'c_fk_uc__');
				/* @var $userCompany UserCompany */
				$userCompany->convertPropertiesToData();
			} else {
				$userCompany = false;
			}
			$contact->setUserCompany($userCompany);

			if (isset($row['user_id'])) {
				$user_id = $row['user_id'];
				$row['c_fk_u__id'] = $user_id;
				$user = self::instantiateOrm($database, 'User', $row, null, $user_id, 'c_fk_u__');
				/* @var $user User */
				$user->convertPropertiesToData();
			} else {
				$user = false;
			}
			$contact->setUser($user);

			if (isset($row['contact_company_id'])) {
				$contact_company_id = $row['contact_company_id'];
				$row['c_fk_cc__id'] = $contact_company_id;
				$contactCompany = self::instantiateOrm($database, 'ContactCompany', $row, null, $contact_company_id, 'c_fk_cc__');
				/* @var $contactCompany ContactCompany */
				$contactCompany->convertPropertiesToData();
			} else {
				$contactCompany = false;
			}
			$contact->setContactCompany($contactCompany);

			$arrContactsByUserCompanyId[$contact_id] = $contact;
		}

		$db->free_result();
		self::$_arrContactsByUserCompanyId = $arrContactsByUserCompanyId;
		return $arrContactsByUserCompanyId;
	}
	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `contacts_fk_uc` foreign key (`user_company_id`) references `user_companies` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $user_company_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubcontractsByProjectIdAndCostCodeId($database, $user_company_id,$costcode = 0, $project_id,Input $options=null)
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
			self::$_arrContactsByUserCompanyId = null;
		}

		$arrContactsByUserCompanyId = self::$_arrContactsByUserCompanyId;
		if (isset($arrContactsByUserCompanyId) && !empty($arrContactsByUserCompanyId)) {
			return $arrContactsByUserCompanyId;
		}

		$user_company_id = (int) $user_company_id;

		//To get the project company cost code data
		$session = Zend_Registry::get('session');
		$currentlySelectedProjectUserCompanyId = $session->getCurrentlySelectedProjectUserCompanyId();
		if($user_company_id != $currentlySelectedProjectUserCompanyId)
		{
			$user_company_id = $currentlySelectedProjectUserCompanyId;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */
		//to get the cost code
		$costCodeQuery = "SELECT group_concat(subcontract_vendor_contact_id ) as vendor_id FROM `subcontracts` WHERE `gc_budget_line_item_id` = (SELECT id FROM `gc_budget_line_items` WHERE `project_id` = $project_id AND `cost_code_id` = $costcode ORDER BY `id` DESC ) ORDER BY `id` DESC ";
		/*$costCodeQuery = "
		SELECT  group_concat(v.`vendor_contact_company_id`) as vendor_id,
		s.`vendor_id`, s.`gc_budget_line_item_id` FROM `subcontracts` AS s
		LEFT JOIN vendors AS v ON v.`id` = s.`vendor_id`
		WHERE s.`gc_budget_line_item_id` = (SELECT id FROM `gc_budget_line_items` WHERE `project_id` = $project_id AND `cost_code_id` = $costcode ORDER BY `id` DESC ) ORDER BY s.`id` DESC
		";*/
		$db->execute($costCodeQuery);
		$costCode = $db->fetch();
		$vendor_ids=$costCode['vendor_id'];
		if($vendor_ids){
			$filter = "FIELD (c.id, $vendor_ids ) DESC ,";
			//To split costvendor
			$data=explode(',',$vendor_ids);
			$vendorvalue='';
			foreach($data as $eachval)
			{
		   	 $vendorvalue .="'".$eachval."',";
			}
			$vendorvalue=trim($vendorvalue,',');
	   }else{
			$filter = '';
	   }
	    $db->free_result();
	    $sqlOrderBy = "\nORDER BY c.`contact_company_id` ASC, c_fk_cc.`company` ASC, c.`first_name` ASC, c.`last_name` ASC, c.`email` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpContact = new Contact($database);
			$sqlOrderByColumns = $tmpContact->constructSqlOrderByColumns($arrOrderByAttributes);

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

	    // $contactCompanyQuery = "SELECT cc.id as comp_id FROM `gc_budget_line_items` as gc
	    // inner join `subcontracts` as s on gc.id=s.gc_budget_line_item_id 
	    // inner join `vendors` as v on v.id=s.vendor_id 
	    // inner join `contact_companies` as cc on cc.id=v.vendor_contact_company_id 
	    // WHERE gc.`user_company_id` = $user_company_id AND gc.`project_id` = $project_id 
	    // AND gc.`cost_code_id` = $costcode and s.unsigned_subcontract_file_manager_file_id!='' ";
		
		$contactCompanyQuery = "
			SELECT  group_concat(v.`vendor_contact_company_id`) as comp_id,
			s.`vendor_id`, s.`gc_budget_line_item_id` FROM `subcontracts` AS s
			LEFT JOIN vendors AS v ON v.`id` = s.`vendor_id`
			WHERE s.`gc_budget_line_item_id` = (SELECT id FROM `gc_budget_line_items` WHERE `project_id` = $project_id AND `cost_code_id` = $costcode ORDER BY `id` DESC ) ORDER BY s.`id` DESC
			";

		$db->execute($contactCompanyQuery);
		$contactCompanyRow = $db->fetch();
		$contactCompanyIds = $contactCompanyRow['comp_id'];
		$db->free_result();
		$db->begin();
		$query =
		"
		SELECT

			c_fk_uc.`id` AS 'c_fk_uc__user_company_id',
			c_fk_uc.`company` AS 'c_fk_uc__company',
			c_fk_uc.`primary_phone_number` AS 'c_fk_uc__primary_phone_number',
			c_fk_uc.`employer_identification_number` AS 'c_fk_uc__employer_identification_number',
			c_fk_uc.`construction_license_number` AS 'c_fk_uc__construction_license_number',
			c_fk_uc.`construction_license_number_expiration_date` AS 'c_fk_uc__construction_license_number_expiration_date',
			c_fk_uc.`paying_customer_flag` AS 'c_fk_uc__paying_customer_flag',

			c_fk_u.`id` AS 'c_fk_u__user_id',
			c_fk_u.`user_company_id` AS 'c_fk_u__user_company_id',
			c_fk_u.`role_id` AS 'c_fk_u__role_id',
			c_fk_u.`default_project_id` AS 'c_fk_u__default_project_id',
			c_fk_u.`primary_contact_id` AS 'c_fk_u__primary_contact_id',
			c_fk_u.`mobile_network_carrier_id` AS 'c_fk_u__mobile_network_carrier_id',
			c_fk_u.`user_image_id` AS 'c_fk_u__user_image_id',
			c_fk_u.`security_image_id` AS 'c_fk_u__security_image_id',
			c_fk_u.`html_template_theme_id` AS 'c_fk_u__html_template_theme_id',
			c_fk_u.`mobile_phone_number` AS 'c_fk_u__mobile_phone_number',
			c_fk_u.`screen_name` AS 'c_fk_u__screen_name',
			c_fk_u.`email` AS 'c_fk_u__email',
			c_fk_u.`password_hash` AS 'c_fk_u__password_hash',
			c_fk_u.`password_guid` AS 'c_fk_u__password_guid',
			c_fk_u.`security_phrase` AS 'c_fk_u__security_phrase',
			c_fk_u.`modified` AS 'c_fk_u__modified',
			c_fk_u.`accessed` AS 'c_fk_u__accessed',
			c_fk_u.`created` AS 'c_fk_u__created',
			c_fk_u.`alerts` AS 'c_fk_u__alerts',
			c_fk_u.`tc_accepted_flag` AS 'c_fk_u__tc_accepted_flag',
			c_fk_u.`email_subscribe_flag` AS 'c_fk_u__email_subscribe_flag',
			c_fk_u.`remember_me_flag` AS 'c_fk_u__remember_me_flag',
			c_fk_u.`change_password_flag` AS 'c_fk_u__change_password_flag',
			c_fk_u.`disabled_flag` AS 'c_fk_u__disabled_flag',
			c_fk_u.`deleted_flag` AS 'c_fk_u__deleted_flag',

			c_fk_cc.`id` AS 'c_fk_cc__contact_company_id',
			c_fk_cc.`user_user_company_id` AS 'c_fk_cc__user_user_company_id',
			c_fk_cc.`contact_user_company_id` AS 'c_fk_cc__contact_user_company_id',
			c_fk_cc.`company` AS 'c_fk_cc__company',
			c_fk_cc.`primary_phone_number` AS 'c_fk_cc__primary_phone_number',
			c_fk_cc.`employer_identification_number` AS 'c_fk_cc__employer_identification_number',
			c_fk_cc.`construction_license_number` AS 'c_fk_cc__construction_license_number',
			c_fk_cc.`construction_license_number_expiration_date` AS 'c_fk_cc__construction_license_number_expiration_date',
			c_fk_cc.`vendor_flag` AS 'c_fk_cc__vendor_flag',

			c.*

		    FROM `contacts` c
			INNER JOIN `user_companies` c_fk_uc ON c.`user_company_id` = c_fk_uc.`id`
			INNER JOIN `users` c_fk_u ON c.`user_id` = c_fk_u.`id`
			INNER JOIN `contact_companies` c_fk_cc ON c.`contact_company_id` = c_fk_cc.`id` 
			AND c.`contact_company_id` IN ($contactCompanyIds)
		    WHERE c.`is_archive`='N' {$sqlOrderBy}{$sqlLimit}
		";
		$arrValues = array($user_company_id);
		$db->query($query);

		$arrContactsByUserCompanyId = array();
		while ($row = $db->fetch()) {
			$contact_id = $row['id'];
			$contact = self::instantiateOrm($database, 'Contact', $row, null, $contact_id);
			/* @var $contact Contact */
			$contact->convertPropertiesToData();

			if (isset($row['user_company_id'])) {
				$user_company_id = $row['user_company_id'];
				$row['c_fk_uc__id'] = $user_company_id;
				$userCompany = self::instantiateOrm($database, 'UserCompany', $row, null, $user_company_id, 'c_fk_uc__');
				/* @var $userCompany UserCompany */
				$userCompany->convertPropertiesToData();
			} else {
				$userCompany = false;
			}
			$contact->setUserCompany($userCompany);

			if (isset($row['user_id'])) {
				$user_id = $row['user_id'];
				$row['c_fk_u__id'] = $user_id;
				$user = self::instantiateOrm($database, 'User', $row, null, $user_id, 'c_fk_u__');
				/* @var $user User */
				$user->convertPropertiesToData();
			} else {
				$user = false;
			}
			$contact->setUser($user);

			if (isset($row['contact_company_id'])) {
				$contact_company_id = $row['contact_company_id'];
				$row['c_fk_cc__id'] = $contact_company_id;
				$contactCompany = self::instantiateOrm($database, 'ContactCompany', $row, null, $contact_company_id, 'c_fk_cc__');
				/* @var $contactCompany ContactCompany */
				$contactCompany->convertPropertiesToData();
			} else {
				$contactCompany = false;
			}
			$contact->setContactCompany($contactCompany);

			$arrContactsByUserCompanyId[$contact_id] = $contact;
		}

		$db->free_result();
		self::$_arrContactsByUserCompanyId = $arrContactsByUserCompanyId;
		return $arrContactsByUserCompanyId;
	}

	// Function to add a non contant email.
	public static function addNonContactEmail($database, $email, $project_id)
	{
		
		$db = DBI::getInstance($database);

		// To check whether email is already exist or not.
		$query = "SELECT count(id) as count FROM `non_contact_person` WHERE `email` = ? AND project_id = ? ";
		$arrValues = array($email, $project_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$count = $row['count'];
		$db->free_result();

		if ($count == 0) {
			// To add email to the table.
			$query1 = 'INSERT INTO non_contact_person (project_id,email,is_delete) VALUES (?,?,?)';
			$arrValues1 = array($project_id, $email, 'Y');
			$db->execute($query1, $arrValues1, MYSQLI_STORE_RESULT);
			$db->commit();		
			$db->free_result();
			$return = 0;
		}

		return $count;
	}

	//Function to check user is exist or not in contacts
	public static function checkUserEmailOnContacts($database,$email,$user_user_company_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query ="SELECT c.*,cc.company AS companyName FROM contacts c INNER JOIN `contact_companies` cc ON c.contact_company_id = cc.id WHERE c.email=? AND c.user_company_id=?ORDER BY c.id DESC LIMIT 1";
		$arrValues = array($email,$user_user_company_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$row = $db->fetch();
		if($row)
		{
			$result=$row['companyName'];
		}else
		{
			$result="0";
		}
		
		$db->free_result();

		return $result;
	}

	//Function to check user is exist or not in contacts
	public static function checkUserEmailOnUsers($database,$email)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query ="SELECT * FROM `users` WHERE `email` = ?";
		$arrValues = array($email);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$row = $db->fetch();
		if($row)
		{
			$result="1";
		}else
		{
			$result="0";
		}
		
		$db->free_result();

		return $result;
	}
	// To update all the email id to the user id instead of 1
	public static function updateAllExistingContactUserId($database,$email,$user_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query ="UPDATE `contacts` set user_id = ? WHERE `email` = ?";
		$arrValues = array($user_id,$email);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$db->free_result();

		return $result;
	}
	public static function updateUserbasedonEmailId($database,$email)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */
		$query ="SELECT `id` from  `users` WHERE `email` = ?";
		$arrValues = array($email);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row =$db->fetch();
		if($row){
			$user_id = $row['id'];
		}else
		{
			$user_id =1;
		}
		
		$db->free_result();
		return $user_id;
		// self::updateAllExistingContactUserId($database,$email,$user_id)

	}
	public static function OwnerContactInGCProject($database,$user_company_id)
    {
    	$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */
		$query ="SELECT uc.id, uc.company,c.id as contact_id,c.email,c.first_name, c.last_name ,p2c.project_id FROM `contacts` as c inner join `projects_to_contacts_to_roles` as p2c on p2c.contact_id = c.id inner join `user_companies` as uc on uc.id = c.`user_company_id` WHERE p2c.role_id = ? ORDER BY uc.`id` ASC ";
		$arrValues = array(8);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$company_arr = array();
		while($row =$db->fetch())
		{
			$compid = $row['id'];
			$company_arr['contact'][] = $row;
			$company_arr['company'][$compid] = $row;
		}
		$db->free_result();
		return $company_arr;

		
    }
    public static function OwnerContactInGCProjectForadmin($database,$user_company_id)
    {
    	$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */
		$query ="SELECT uc.id, uc.company,c.id as contact_id,c.email,c.first_name, c.last_name ,p2c.project_id FROM `contacts` as c inner join `projects_to_contacts_to_roles` as p2c on p2c.contact_id = c.id inner join `user_companies` as uc on uc.id = c.`user_company_id` WHERE p2c.role_id = ? ORDER BY uc.`id` ASC ";
		$arrValues = array(8);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$company_arr = array();
		while($row =$db->fetch())
		{
			$compid = $row['id'];
			$company_arr[$compid] = $row['company'];
		}
		$db->free_result();
		return $company_arr;

		
    }

    public static function OwnerContactInGCProjectForadminProject($database,$project_id)
    {
    	$db = DBI::getInstance($database);

    	$joinFilter ="
    	INNER JOIN `role_groups_to_roles` rg2r ON p2c2r.`role_id` = rg2r.`role_id`
    	INNER JOIN `role_groups` rg ON rg2r.`role_group_id` = rg.`id`";
    	$whereFilter ="AND rg.`role_group` = 'project_team_members'  AND rg2r.`role_id`='8'";


    	$query ="
    	SELECT
    	p2c2r.`contact_id`,
    	p2c2r.`role_id`
    	FROM `projects_to_contacts_to_roles` p2c2r $joinFilter
    	WHERE p2c2r.`project_id` = ? $whereFilter
    	";
    	$arrValues = array($project_id);
    	$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
    	$arrContactIdsToRoleIdsByProjectId = array();
    	$arrContactIds = array();
    	while ($row = $db->fetch()) {
    		$contact_id = $row['contact_id'];
    		$role_id = $row['role_id'];

    		$arrContactIdsToRoleIdsByProjectId[$contact_id][$project_id][$role_id] = $role_id;
    		$arrContactIds[$contact_id] = 1;
    	}
    	$db->free_result();
    	$company_arr = array();
    	if (!empty($arrContactIds)) {

			// Assign role_id by project_id lists to each $contact object
    		$arrContactIds = array_keys($arrContactIds);
    		$in = join(',', $arrContactIds);
    		$query1 ="
    		SELECT
    		cc.*,
    		ui.contact_id,
    		c.`id` as 'contact_id',
    		cc.`id` as 'contact_company_id',
    		ui.`id` as 'user_invitation_id',
    		c.`user_id` AS 'contact_user_id',
    		ui.`user_id` as 'user_invitation_user_id',
    		ui.`created` as 'ui_created'
    		FROM `contacts` c
    		INNER JOIN `contact_companies` cc ON c.`contact_company_id` = cc.`id`
    		LEFT OUTER JOIN `user_invitations` ui ON c.`id` = ui.`contact_id`
    		WHERE c.`id` IN ($in) AND c.`is_archive` = 'N'";
    		$arrValues = array();
    		$db->execute($query1, $arrValues, MYSQLI_USE_RESULT);
    		while($row1 =$db->fetch())
    		{
    			$compid = $row1['contact_user_company_id'];
    			$company_arr[$compid] = $row1['company'];
    		}
    		$db->free_result();
    		return $company_arr;
    	}else {
    		return $company_arr;
    	}



		
    }

    public static function EmailContactbasedonUserCompany($database,$user_company_id)
    {
    	$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */
		$query ="SELECT * FROM `contacts` c inner join contact_companies cc on cc.id = c.contact_company_id WHERE `user_company_id` = ? ORDER BY `c`.`contact_company_id` DESC ";
		// SELECT * FROM `contacts` WHERE `user_company_id` = ? ORDER BY `email` ASC ";
		$arrValues = array($user_company_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$contact_arr = array();
		while($row =$db->fetch())
		{
			$contact_arr[] = $row;
		}
		$db->free_result();
		return $contact_arr;

		
    }
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

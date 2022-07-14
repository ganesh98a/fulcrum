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
 * SubmittalResponse.
 *
 * @category   Framework
 * @package    SubmittalResponse
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class SubmittalResponse extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'SubmittalResponse';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'submittal_responses';

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
	 * unique index `unique_submittal_response` (`submittal_id`,`submittal_response_sequence_number`) comment 'One Submittal can have many Responses'
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_submittal_response' => array(
			'submittal_id' => 'int',
			'submittal_response_sequence_number' => 'int'
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
		'id' => 'submittal_response_id',

		'submittal_id' => 'submittal_id',
		'submittal_response_sequence_number' => 'submittal_response_sequence_number',

		'submittal_response_type_id' => 'submittal_response_type_id',
		'su_responder_contact_id' => 'su_responder_contact_id',
		'su_responder_contact_company_office_id' => 'su_responder_contact_company_office_id',
		'su_responder_phone_contact_company_office_phone_number_id' => 'su_responder_phone_contact_company_office_phone_number_id',
		'su_responder_fax_contact_company_office_phone_number_id' => 'su_responder_fax_contact_company_office_phone_number_id',
		'su_responder_contact_mobile_phone_number_id' => 'su_responder_contact_mobile_phone_number_id',

		'submittal_response_title' => 'submittal_response_title',
		'submittal_response' => 'submittal_response',
		'modified' => 'modified',
		'created' => 'created'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $submittal_response_id;

	public $submittal_id;
	public $submittal_response_sequence_number;

	public $submittal_response_type_id;
	public $su_responder_contact_id;
	public $su_responder_contact_company_office_id;
	public $su_responder_phone_contact_company_office_phone_number_id;
	public $su_responder_fax_contact_company_office_phone_number_id;
	public $su_responder_contact_mobile_phone_number_id;

	public $submittal_response_title;
	public $submittal_response;
	public $modified;
	public $created;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties
	public $escaped_submittal_response_title;
	public $escaped_submittal_response;

	// HTML ENTITY ENCODED NL2BR ORM string properties
	public $escaped_submittal_response_title_nl2br;
	public $escaped_submittal_response_nl2br;

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)
	protected static $_arrSubmittalResponsesBySubmittalId;
	protected static $_arrSubmittalResponsesBySubmittalResponseTypeId;
	protected static $_arrSubmittalResponsesBySuResponderContactId;
	protected static $_arrSubmittalResponsesBySuResponderContactCompanyOfficeId;
	protected static $_arrSubmittalResponsesBySuResponderPhoneContactCompanyOfficePhoneNumberId;
	protected static $_arrSubmittalResponsesBySuResponderFaxContactCompanyOfficePhoneNumberId;
	protected static $_arrSubmittalResponsesBySuResponderContactMobilePhoneNumberId;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllSubmittalResponses;

	// Foreign Key Objects
	private $_submittal;
	private $_submittalResponseType;
	private $_suResponderContact;
	private $_suResponderContactCompanyOffice;
	private $_suResponderPhoneContactCompanyOfficePhoneNumber;
	private $_suResponderFaxContactCompanyOfficePhoneNumber;
	private $_suResponderContactMobilePhoneNumber;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='submittal_responses')
	{
		parent::__construct($table);
		$this->setDatabase($database);
	}

	// Foreign Key Object Accessor Methods
	public function getSubmittal()
	{
		if (isset($this->_submittal)) {
			return $this->_submittal;
		} else {
			return null;
		}
	}

	public function setSubmittal($submittal)
	{
		$this->_submittal = $submittal;
	}

	public function getSubmittalResponseType()
	{
		if (isset($this->_submittalResponseType)) {
			return $this->_submittalResponseType;
		} else {
			return null;
		}
	}

	public function setSubmittalResponseType($submittalResponseType)
	{
		$this->_submittalResponseType = $submittalResponseType;
	}

	public function getSuResponderContact()
	{
		if (isset($this->_suResponderContact)) {
			return $this->_suResponderContact;
		} else {
			return null;
		}
	}

	public function setSuResponderContact($suResponderContact)
	{
		$this->_suResponderContact = $suResponderContact;
	}

	public function getSuResponderContactCompanyOffice()
	{
		if (isset($this->_suResponderContactCompanyOffice)) {
			return $this->_suResponderContactCompanyOffice;
		} else {
			return null;
		}
	}

	public function setSuResponderContactCompanyOffice($suResponderContactCompanyOffice)
	{
		$this->_suResponderContactCompanyOffice = $suResponderContactCompanyOffice;
	}

	public function getSuResponderPhoneContactCompanyOfficePhoneNumber()
	{
		if (isset($this->_suResponderPhoneContactCompanyOfficePhoneNumber)) {
			return $this->_suResponderPhoneContactCompanyOfficePhoneNumber;
		} else {
			return null;
		}
	}

	public function setSuResponderPhoneContactCompanyOfficePhoneNumber($suResponderPhoneContactCompanyOfficePhoneNumber)
	{
		$this->_suResponderPhoneContactCompanyOfficePhoneNumber = $suResponderPhoneContactCompanyOfficePhoneNumber;
	}

	public function getSuResponderFaxContactCompanyOfficePhoneNumber()
	{
		if (isset($this->_suResponderFaxContactCompanyOfficePhoneNumber)) {
			return $this->_suResponderFaxContactCompanyOfficePhoneNumber;
		} else {
			return null;
		}
	}

	public function setSuResponderFaxContactCompanyOfficePhoneNumber($suResponderFaxContactCompanyOfficePhoneNumber)
	{
		$this->_suResponderFaxContactCompanyOfficePhoneNumber = $suResponderFaxContactCompanyOfficePhoneNumber;
	}

	public function getSuResponderContactMobilePhoneNumber()
	{
		if (isset($this->_suResponderContactMobilePhoneNumber)) {
			return $this->_suResponderContactMobilePhoneNumber;
		} else {
			return null;
		}
	}

	public function setSuResponderContactMobilePhoneNumber($suResponderContactMobilePhoneNumber)
	{
		$this->_suResponderContactMobilePhoneNumber = $suResponderContactMobilePhoneNumber;
	}

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)
	public static function getArrSubmittalResponsesBySubmittalId()
	{
		if (isset(self::$_arrSubmittalResponsesBySubmittalId)) {
			return self::$_arrSubmittalResponsesBySubmittalId;
		} else {
			return null;
		}
	}

	public static function setArrSubmittalResponsesBySubmittalId($arrSubmittalResponsesBySubmittalId)
	{
		self::$_arrSubmittalResponsesBySubmittalId = $arrSubmittalResponsesBySubmittalId;
	}

	public static function getArrSubmittalResponsesBySubmittalResponseTypeId()
	{
		if (isset(self::$_arrSubmittalResponsesBySubmittalResponseTypeId)) {
			return self::$_arrSubmittalResponsesBySubmittalResponseTypeId;
		} else {
			return null;
		}
	}

	public static function setArrSubmittalResponsesBySubmittalResponseTypeId($arrSubmittalResponsesBySubmittalResponseTypeId)
	{
		self::$_arrSubmittalResponsesBySubmittalResponseTypeId = $arrSubmittalResponsesBySubmittalResponseTypeId;
	}

	public static function getArrSubmittalResponsesBySuResponderContactId()
	{
		if (isset(self::$_arrSubmittalResponsesBySuResponderContactId)) {
			return self::$_arrSubmittalResponsesBySuResponderContactId;
		} else {
			return null;
		}
	}

	public static function setArrSubmittalResponsesBySuResponderContactId($arrSubmittalResponsesBySuResponderContactId)
	{
		self::$_arrSubmittalResponsesBySuResponderContactId = $arrSubmittalResponsesBySuResponderContactId;
	}

	public static function getArrSubmittalResponsesBySuResponderContactCompanyOfficeId()
	{
		if (isset(self::$_arrSubmittalResponsesBySuResponderContactCompanyOfficeId)) {
			return self::$_arrSubmittalResponsesBySuResponderContactCompanyOfficeId;
		} else {
			return null;
		}
	}

	public static function setArrSubmittalResponsesBySuResponderContactCompanyOfficeId($arrSubmittalResponsesBySuResponderContactCompanyOfficeId)
	{
		self::$_arrSubmittalResponsesBySuResponderContactCompanyOfficeId = $arrSubmittalResponsesBySuResponderContactCompanyOfficeId;
	}

	public static function getArrSubmittalResponsesBySuResponderPhoneContactCompanyOfficePhoneNumberId()
	{
		if (isset(self::$_arrSubmittalResponsesBySuResponderPhoneContactCompanyOfficePhoneNumberId)) {
			return self::$_arrSubmittalResponsesBySuResponderPhoneContactCompanyOfficePhoneNumberId;
		} else {
			return null;
		}
	}

	public static function setArrSubmittalResponsesBySuResponderPhoneContactCompanyOfficePhoneNumberId($arrSubmittalResponsesBySuResponderPhoneContactCompanyOfficePhoneNumberId)
	{
		self::$_arrSubmittalResponsesBySuResponderPhoneContactCompanyOfficePhoneNumberId = $arrSubmittalResponsesBySuResponderPhoneContactCompanyOfficePhoneNumberId;
	}

	public static function getArrSubmittalResponsesBySuResponderFaxContactCompanyOfficePhoneNumberId()
	{
		if (isset(self::$_arrSubmittalResponsesBySuResponderFaxContactCompanyOfficePhoneNumberId)) {
			return self::$_arrSubmittalResponsesBySuResponderFaxContactCompanyOfficePhoneNumberId;
		} else {
			return null;
		}
	}

	public static function setArrSubmittalResponsesBySuResponderFaxContactCompanyOfficePhoneNumberId($arrSubmittalResponsesBySuResponderFaxContactCompanyOfficePhoneNumberId)
	{
		self::$_arrSubmittalResponsesBySuResponderFaxContactCompanyOfficePhoneNumberId = $arrSubmittalResponsesBySuResponderFaxContactCompanyOfficePhoneNumberId;
	}

	public static function getArrSubmittalResponsesBySuResponderContactMobilePhoneNumberId()
	{
		if (isset(self::$_arrSubmittalResponsesBySuResponderContactMobilePhoneNumberId)) {
			return self::$_arrSubmittalResponsesBySuResponderContactMobilePhoneNumberId;
		} else {
			return null;
		}
	}

	public static function setArrSubmittalResponsesBySuResponderContactMobilePhoneNumberId($arrSubmittalResponsesBySuResponderContactMobilePhoneNumberId)
	{
		self::$_arrSubmittalResponsesBySuResponderContactMobilePhoneNumberId = $arrSubmittalResponsesBySuResponderContactMobilePhoneNumberId;
	}

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllSubmittalResponses()
	{
		if (isset(self::$_arrAllSubmittalResponses)) {
			return self::$_arrAllSubmittalResponses;
		} else {
			return null;
		}
	}

	public static function setArrAllSubmittalResponses($arrAllSubmittalResponses)
	{
		self::$_arrAllSubmittalResponses = $arrAllSubmittalResponses;
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
	 * @param int $submittal_response_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findById($database, $submittal_response_id,$table='submittal_responses', $module='SubmittalResponse')
	{
		$submittalResponse = parent::findById($database, $submittal_response_id, $table, $module);

		return $submittalResponse;
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Similar to FindById, but with SQL as starter code for more complex joins.
	 *
	 * @param string $database
	 * @param int $submittal_response_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findSubmittalResponseByIdExtended($database, $submittal_response_id)
	{
		$submittal_response_id = (int) $submittal_response_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	suresponses_fk_su.`id` AS 'suresponses_fk_su__submittal_id',
	suresponses_fk_su.`project_id` AS 'suresponses_fk_su__project_id',
	suresponses_fk_su.`su_sequence_number` AS 'suresponses_fk_su__su_sequence_number',
	suresponses_fk_su.`submittal_type_id` AS 'suresponses_fk_su__submittal_type_id',
	suresponses_fk_su.`submittal_status_id` AS 'suresponses_fk_su__submittal_status_id',
	suresponses_fk_su.`submittal_priority_id` AS 'suresponses_fk_su__submittal_priority_id',
	suresponses_fk_su.`submittal_distribution_method_id` AS 'suresponses_fk_su__submittal_distribution_method_id',
	suresponses_fk_su.`su_file_manager_file_id` AS 'suresponses_fk_su__su_file_manager_file_id',
	suresponses_fk_su.`su_cost_code_id` AS 'suresponses_fk_su__su_cost_code_id',
	suresponses_fk_su.`su_creator_contact_id` AS 'suresponses_fk_su__su_creator_contact_id',
	suresponses_fk_su.`su_creator_contact_company_office_id` AS 'suresponses_fk_su__su_creator_contact_company_office_id',
	suresponses_fk_su.`su_creator_phone_contact_company_office_phone_number_id` AS 'suresponses_fk_su__su_creator_phone_contact_company_office_phone_number_id',
	suresponses_fk_su.`su_creator_fax_contact_company_office_phone_number_id` AS 'suresponses_fk_su__su_creator_fax_contact_company_office_phone_number_id',
	suresponses_fk_su.`su_creator_contact_mobile_phone_number_id` AS 'suresponses_fk_su__su_creator_contact_mobile_phone_number_id',
	suresponses_fk_su.`su_recipient_contact_id` AS 'suresponses_fk_su__su_recipient_contact_id',
	suresponses_fk_su.`su_recipient_contact_company_office_id` AS 'suresponses_fk_su__su_recipient_contact_company_office_id',
	suresponses_fk_su.`su_recipient_phone_contact_company_office_phone_number_id` AS 'suresponses_fk_su__su_recipient_phone_contact_company_office_phone_number_id',
	suresponses_fk_su.`su_recipient_fax_contact_company_office_phone_number_id` AS 'suresponses_fk_su__su_recipient_fax_contact_company_office_phone_number_id',
	suresponses_fk_su.`su_recipient_contact_mobile_phone_number_id` AS 'suresponses_fk_su__su_recipient_contact_mobile_phone_number_id',
	suresponses_fk_su.`su_initiator_contact_id` AS 'suresponses_fk_su__su_initiator_contact_id',
	suresponses_fk_su.`su_initiator_contact_company_office_id` AS 'suresponses_fk_su__su_initiator_contact_company_office_id',
	suresponses_fk_su.`su_initiator_phone_contact_company_office_phone_number_id` AS 'suresponses_fk_su__su_initiator_phone_contact_company_office_phone_number_id',
	suresponses_fk_su.`su_initiator_fax_contact_company_office_phone_number_id` AS 'suresponses_fk_su__su_initiator_fax_contact_company_office_phone_number_id',
	suresponses_fk_su.`su_initiator_contact_mobile_phone_number_id` AS 'suresponses_fk_su__su_initiator_contact_mobile_phone_number_id',
	suresponses_fk_su.`su_title` AS 'suresponses_fk_su__su_title',
	suresponses_fk_su.`su_plan_page_reference` AS 'suresponses_fk_su__su_plan_page_reference',
	suresponses_fk_su.`su_statement` AS 'suresponses_fk_su__su_statement',
	suresponses_fk_su.`created` AS 'suresponses_fk_su__created',
	suresponses_fk_su.`su_due_date` AS 'suresponses_fk_su__su_due_date',
	suresponses_fk_su.`su_closed_date` AS 'suresponses_fk_su__su_closed_date',

	suresponses_fk_surt.`id` AS 'suresponses_fk_surt__submittal_response_type_id',
	suresponses_fk_surt.`submittal_response_type` AS 'suresponses_fk_surt__submittal_response_type',
	suresponses_fk_surt.`disabled_flag` AS 'suresponses_fk_surt__disabled_flag',

	suresponses_fk_responder_c.`id` AS 'suresponses_fk_responder_c__contact_id',
	suresponses_fk_responder_c.`user_company_id` AS 'suresponses_fk_responder_c__user_company_id',
	suresponses_fk_responder_c.`user_id` AS 'suresponses_fk_responder_c__user_id',
	suresponses_fk_responder_c.`contact_company_id` AS 'suresponses_fk_responder_c__contact_company_id',
	suresponses_fk_responder_c.`email` AS 'suresponses_fk_responder_c__email',
	suresponses_fk_responder_c.`name_prefix` AS 'suresponses_fk_responder_c__name_prefix',
	suresponses_fk_responder_c.`first_name` AS 'suresponses_fk_responder_c__first_name',
	suresponses_fk_responder_c.`additional_name` AS 'suresponses_fk_responder_c__additional_name',
	suresponses_fk_responder_c.`middle_name` AS 'suresponses_fk_responder_c__middle_name',
	suresponses_fk_responder_c.`last_name` AS 'suresponses_fk_responder_c__last_name',
	suresponses_fk_responder_c.`name_suffix` AS 'suresponses_fk_responder_c__name_suffix',
	suresponses_fk_responder_c.`title` AS 'suresponses_fk_responder_c__title',
	suresponses_fk_responder_c.`vendor_flag` AS 'suresponses_fk_responder_c__vendor_flag',

	suresponses_fk_responder_cco.`id` AS 'suresponses_fk_responder_cco__contact_company_office_id',
	suresponses_fk_responder_cco.`contact_company_id` AS 'suresponses_fk_responder_cco__contact_company_id',
	suresponses_fk_responder_cco.`office_nickname` AS 'suresponses_fk_responder_cco__office_nickname',
	suresponses_fk_responder_cco.`address_line_1` AS 'suresponses_fk_responder_cco__address_line_1',
	suresponses_fk_responder_cco.`address_line_2` AS 'suresponses_fk_responder_cco__address_line_2',
	suresponses_fk_responder_cco.`address_line_3` AS 'suresponses_fk_responder_cco__address_line_3',
	suresponses_fk_responder_cco.`address_line_4` AS 'suresponses_fk_responder_cco__address_line_4',
	suresponses_fk_responder_cco.`address_city` AS 'suresponses_fk_responder_cco__address_city',
	suresponses_fk_responder_cco.`address_county` AS 'suresponses_fk_responder_cco__address_county',
	suresponses_fk_responder_cco.`address_state_or_region` AS 'suresponses_fk_responder_cco__address_state_or_region',
	suresponses_fk_responder_cco.`address_postal_code` AS 'suresponses_fk_responder_cco__address_postal_code',
	suresponses_fk_responder_cco.`address_postal_code_extension` AS 'suresponses_fk_responder_cco__address_postal_code_extension',
	suresponses_fk_responder_cco.`address_country` AS 'suresponses_fk_responder_cco__address_country',
	suresponses_fk_responder_cco.`head_quarters_flag` AS 'suresponses_fk_responder_cco__head_quarters_flag',
	suresponses_fk_responder_cco.`address_validated_by_user_flag` AS 'suresponses_fk_responder_cco__address_validated_by_user_flag',
	suresponses_fk_responder_cco.`address_validated_by_web_service_flag` AS 'suresponses_fk_responder_cco__address_validated_by_web_service_flag',
	suresponses_fk_responder_cco.`address_validation_by_web_service_error_flag` AS 'suresponses_fk_responder_cco__address_validation_by_web_service_error_flag',

	suresponses_fk_responder_phone_ccopn.`id` AS 'suresponses_fk_responder_phone_ccopn__contact_company_office_phone_number_id',
	suresponses_fk_responder_phone_ccopn.`contact_company_office_id` AS 'suresponses_fk_responder_phone_ccopn__contact_company_office_id',
	suresponses_fk_responder_phone_ccopn.`phone_number_type_id` AS 'suresponses_fk_responder_phone_ccopn__phone_number_type_id',
	suresponses_fk_responder_phone_ccopn.`country_code` AS 'suresponses_fk_responder_phone_ccopn__country_code',
	suresponses_fk_responder_phone_ccopn.`area_code` AS 'suresponses_fk_responder_phone_ccopn__area_code',
	suresponses_fk_responder_phone_ccopn.`prefix` AS 'suresponses_fk_responder_phone_ccopn__prefix',
	suresponses_fk_responder_phone_ccopn.`number` AS 'suresponses_fk_responder_phone_ccopn__number',
	suresponses_fk_responder_phone_ccopn.`extension` AS 'suresponses_fk_responder_phone_ccopn__extension',
	suresponses_fk_responder_phone_ccopn.`itu` AS 'suresponses_fk_responder_phone_ccopn__itu',

	suresponses_fk_responder_fax_ccopn.`id` AS 'suresponses_fk_responder_fax_ccopn__contact_company_office_phone_number_id',
	suresponses_fk_responder_fax_ccopn.`contact_company_office_id` AS 'suresponses_fk_responder_fax_ccopn__contact_company_office_id',
	suresponses_fk_responder_fax_ccopn.`phone_number_type_id` AS 'suresponses_fk_responder_fax_ccopn__phone_number_type_id',
	suresponses_fk_responder_fax_ccopn.`country_code` AS 'suresponses_fk_responder_fax_ccopn__country_code',
	suresponses_fk_responder_fax_ccopn.`area_code` AS 'suresponses_fk_responder_fax_ccopn__area_code',
	suresponses_fk_responder_fax_ccopn.`prefix` AS 'suresponses_fk_responder_fax_ccopn__prefix',
	suresponses_fk_responder_fax_ccopn.`number` AS 'suresponses_fk_responder_fax_ccopn__number',
	suresponses_fk_responder_fax_ccopn.`extension` AS 'suresponses_fk_responder_fax_ccopn__extension',
	suresponses_fk_responder_fax_ccopn.`itu` AS 'suresponses_fk_responder_fax_ccopn__itu',

	suresponses_fk_responder_c_mobile_cpn.`id` AS 'suresponses_fk_responder_c_mobile_cpn__contact_phone_number_id',
	suresponses_fk_responder_c_mobile_cpn.`contact_id` AS 'suresponses_fk_responder_c_mobile_cpn__contact_id',
	suresponses_fk_responder_c_mobile_cpn.`phone_number_type_id` AS 'suresponses_fk_responder_c_mobile_cpn__phone_number_type_id',
	suresponses_fk_responder_c_mobile_cpn.`country_code` AS 'suresponses_fk_responder_c_mobile_cpn__country_code',
	suresponses_fk_responder_c_mobile_cpn.`area_code` AS 'suresponses_fk_responder_c_mobile_cpn__area_code',
	suresponses_fk_responder_c_mobile_cpn.`prefix` AS 'suresponses_fk_responder_c_mobile_cpn__prefix',
	suresponses_fk_responder_c_mobile_cpn.`number` AS 'suresponses_fk_responder_c_mobile_cpn__number',
	suresponses_fk_responder_c_mobile_cpn.`extension` AS 'suresponses_fk_responder_c_mobile_cpn__extension',
	suresponses_fk_responder_c_mobile_cpn.`itu` AS 'suresponses_fk_responder_c_mobile_cpn__itu',

	suresponses.*

FROM `submittal_responses` suresponses
	INNER JOIN `submittals` suresponses_fk_su ON suresponses.`submittal_id` = suresponses_fk_su.`id`
	INNER JOIN `submittal_response_types` suresponses_fk_surt ON suresponses.`submittal_response_type_id` = suresponses_fk_surt.`id`
	INNER JOIN `contacts` suresponses_fk_responder_c ON suresponses.`su_responder_contact_id` = suresponses_fk_responder_c.`id`
	LEFT OUTER JOIN `contact_company_offices` suresponses_fk_responder_cco ON suresponses.`su_responder_contact_company_office_id` = suresponses_fk_responder_cco.`id`
	LEFT OUTER JOIN `contact_company_office_phone_numbers` suresponses_fk_responder_phone_ccopn ON suresponses.`su_responder_phone_contact_company_office_phone_number_id` = suresponses_fk_responder_phone_ccopn.`id`
	LEFT OUTER JOIN `contact_company_office_phone_numbers` suresponses_fk_responder_fax_ccopn ON suresponses.`su_responder_fax_contact_company_office_phone_number_id` = suresponses_fk_responder_fax_ccopn.`id`
	LEFT OUTER JOIN `contact_phone_numbers` suresponses_fk_responder_c_mobile_cpn ON suresponses.`su_responder_contact_mobile_phone_number_id` = suresponses_fk_responder_c_mobile_cpn.`id`
WHERE suresponses.`id` = ?
";
		$arrValues = array($submittal_response_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$submittal_response_id = $row['id'];
			$submittalResponse = self::instantiateOrm($database, 'SubmittalResponse', $row, null, $submittal_response_id);
			/* @var $submittalResponse SubmittalResponse */
			$submittalResponse->convertPropertiesToData();

			if (isset($row['submittal_id'])) {
				$submittal_id = $row['submittal_id'];
				$row['suresponses_fk_su__id'] = $submittal_id;
				$submittal = self::instantiateOrm($database, 'Submittal', $row, null, $submittal_id, 'suresponses_fk_su__');
				/* @var $submittal Submittal */
				$submittal->convertPropertiesToData();
			} else {
				$submittal = false;
			}
			$submittalResponse->setSubmittal($submittal);

			if (isset($row['submittal_response_type_id'])) {
				$submittal_response_type_id = $row['submittal_response_type_id'];
				$row['suresponses_fk_surt__id'] = $submittal_response_type_id;
				$submittalResponseType = self::instantiateOrm($database, 'SubmittalResponseType', $row, null, $submittal_response_type_id, 'suresponses_fk_surt__');
				/* @var $submittalResponseType SubmittalResponseType */
				$submittalResponseType->convertPropertiesToData();
			} else {
				$submittalResponseType = false;
			}
			$submittalResponse->setSubmittalResponseType($submittalResponseType);

			if (isset($row['su_responder_contact_id'])) {
				$su_responder_contact_id = $row['su_responder_contact_id'];
				$row['suresponses_fk_responder_c__id'] = $su_responder_contact_id;
				$suResponderContact = self::instantiateOrm($database, 'Contact', $row, null, $su_responder_contact_id, 'suresponses_fk_responder_c__');
				/* @var $suResponderContact Contact */
				$suResponderContact->convertPropertiesToData();
			} else {
				$suResponderContact = false;
			}
			$submittalResponse->setSuResponderContact($suResponderContact);

			if (isset($row['su_responder_contact_company_office_id'])) {
				$su_responder_contact_company_office_id = $row['su_responder_contact_company_office_id'];
				$row['suresponses_fk_responder_cco__id'] = $su_responder_contact_company_office_id;
				$suResponderContactCompanyOffice = self::instantiateOrm($database, 'ContactCompanyOffice', $row, null, $su_responder_contact_company_office_id, 'suresponses_fk_responder_cco__');
				/* @var $suResponderContactCompanyOffice ContactCompanyOffice */
				$suResponderContactCompanyOffice->convertPropertiesToData();
			} else {
				$suResponderContactCompanyOffice = false;
			}
			$submittalResponse->setSuResponderContactCompanyOffice($suResponderContactCompanyOffice);

			if (isset($row['su_responder_phone_contact_company_office_phone_number_id'])) {
				$su_responder_phone_contact_company_office_phone_number_id = $row['su_responder_phone_contact_company_office_phone_number_id'];
				$row['suresponses_fk_responder_phone_ccopn__id'] = $su_responder_phone_contact_company_office_phone_number_id;
				$suResponderPhoneContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $su_responder_phone_contact_company_office_phone_number_id, 'suresponses_fk_responder_phone_ccopn__');
				/* @var $suResponderPhoneContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$suResponderPhoneContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$suResponderPhoneContactCompanyOfficePhoneNumber = false;
			}
			$submittalResponse->setSuResponderPhoneContactCompanyOfficePhoneNumber($suResponderPhoneContactCompanyOfficePhoneNumber);

			if (isset($row['su_responder_fax_contact_company_office_phone_number_id'])) {
				$su_responder_fax_contact_company_office_phone_number_id = $row['su_responder_fax_contact_company_office_phone_number_id'];
				$row['suresponses_fk_responder_fax_ccopn__id'] = $su_responder_fax_contact_company_office_phone_number_id;
				$suResponderFaxContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $su_responder_fax_contact_company_office_phone_number_id, 'suresponses_fk_responder_fax_ccopn__');
				/* @var $suResponderFaxContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$suResponderFaxContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$suResponderFaxContactCompanyOfficePhoneNumber = false;
			}
			$submittalResponse->setSuResponderFaxContactCompanyOfficePhoneNumber($suResponderFaxContactCompanyOfficePhoneNumber);

			if (isset($row['su_responder_contact_mobile_phone_number_id'])) {
				$su_responder_contact_mobile_phone_number_id = $row['su_responder_contact_mobile_phone_number_id'];
				$row['suresponses_fk_responder_c_mobile_cpn__id'] = $su_responder_contact_mobile_phone_number_id;
				$suResponderContactMobilePhoneNumber = self::instantiateOrm($database, 'ContactPhoneNumber', $row, null, $su_responder_contact_mobile_phone_number_id, 'suresponses_fk_responder_c_mobile_cpn__');
				/* @var $suResponderContactMobilePhoneNumber ContactPhoneNumber */
				$suResponderContactMobilePhoneNumber->convertPropertiesToData();
			} else {
				$suResponderContactMobilePhoneNumber = false;
			}
			$submittalResponse->setSuResponderContactMobilePhoneNumber($suResponderContactMobilePhoneNumber);

			return $submittalResponse;
		} else {
			return false;
		}
	}

	// Finders: Find By Unique Index
	/**
	 * Find by unique index `unique_submittal_response` (`submittal_id`,`submittal_response_sequence_number`) comment 'One Submittal can have many Responses'.
	 *
	 * @param string $database
	 * @param int $submittal_id
	 * @param int $submittal_response_sequence_number
	 * @return mixed (single ORM object | false)
	 */
	public static function findBySubmittalIdAndSubmittalResponseSequenceNumber($database, $submittal_id, $submittal_response_sequence_number)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	suresponses.*

FROM `submittal_responses` suresponses
WHERE suresponses.`submittal_id` = ?
AND suresponses.`submittal_response_sequence_number` = ?
";
		$arrValues = array($submittal_id, $submittal_response_sequence_number);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if ($row && !empty($row)) {
			$submittal_response_id = $row['id'];
			$submittalResponse = self::instantiateOrm($database, 'SubmittalResponse', $row, null, $submittal_response_id);
			/* @var $submittalResponse SubmittalResponse */
			return $submittalResponse;
		} else {
			return false;
		}
	}

	// Loaders: Load By pk List (list of auto int ids or other non auto int pk list)
	/**
	 * Load zero or more records by an id list (array of auto int primary keys).
	 *
	 * @param string $database
	 * @param array $arrSubmittalResponseIds
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubmittalResponsesByArrSubmittalResponseIds($database, $arrSubmittalResponseIds, Input $options=null)
	{
		if (empty($arrSubmittalResponseIds)) {
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
		// ORDER BY `id` ASC, `submittal_id` ASC, `submittal_response_sequence_number` ASC, `submittal_response_type_id` ASC, `su_responder_contact_id` ASC, `su_responder_contact_company_office_id` ASC, `su_responder_phone_contact_company_office_phone_number_id` ASC, `su_responder_fax_contact_company_office_phone_number_id` ASC, `su_responder_contact_mobile_phone_number_id` ASC, `submittal_response_title` ASC, `submittal_response` ASC, `modified` ASC, `created` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubmittalResponse = new SubmittalResponse($database);
			$sqlOrderByColumns = $tmpSubmittalResponse->constructSqlOrderByColumns($arrOrderByAttributes);

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

		foreach ($arrSubmittalResponseIds as $k => $submittal_response_id) {
			$submittal_response_id = (int) $submittal_response_id;
			$arrSubmittalResponseIds[$k] = $db->escape($submittal_response_id);
		}
		$csvSubmittalResponseIds = join(',', $arrSubmittalResponseIds);

		$query =
"
SELECT

	suresponses.*

FROM `submittal_responses` suresponses
WHERE suresponses.`id` IN ($csvSubmittalResponseIds){$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		$arrSubmittalResponsesByCsvSubmittalResponseIds = array();
		while ($row = $db->fetch()) {
			$submittal_response_id = $row['id'];
			$submittalResponse = self::instantiateOrm($database, 'SubmittalResponse', $row, null, $submittal_response_id);
			/* @var $submittalResponse SubmittalResponse */
			$submittalResponse->convertPropertiesToData();

			$arrSubmittalResponsesByCsvSubmittalResponseIds[$submittal_response_id] = $submittalResponse;
		}

		$db->free_result();

		return $arrSubmittalResponsesByCsvSubmittalResponseIds;
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `submittal_responses_fk_su` foreign key (`submittal_id`) references `submittals` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $submittal_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubmittalResponsesBySubmittalId($database, $submittal_id, Input $options=null)
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
			self::$_arrSubmittalResponsesBySubmittalId = null;
		}

		$arrSubmittalResponsesBySubmittalId = self::$_arrSubmittalResponsesBySubmittalId;
		if (isset($arrSubmittalResponsesBySubmittalId) && !empty($arrSubmittalResponsesBySubmittalId)) {
			return $arrSubmittalResponsesBySubmittalId;
		}

		$submittal_id = (int) $submittal_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `submittal_id` ASC, `submittal_response_sequence_number` ASC, `submittal_response_type_id` ASC, `su_responder_contact_id` ASC, `su_responder_contact_company_office_id` ASC, `su_responder_phone_contact_company_office_phone_number_id` ASC, `su_responder_fax_contact_company_office_phone_number_id` ASC, `su_responder_contact_mobile_phone_number_id` ASC, `submittal_response_title` ASC, `submittal_response` ASC, `modified` ASC, `created` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubmittalResponse = new SubmittalResponse($database);
			$sqlOrderByColumns = $tmpSubmittalResponse->constructSqlOrderByColumns($arrOrderByAttributes);

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

	suresponses_fk_su.`id` AS 'suresponses_fk_su__submittal_id',
	suresponses_fk_su.`project_id` AS 'suresponses_fk_su__project_id',
	suresponses_fk_su.`su_sequence_number` AS 'suresponses_fk_su__su_sequence_number',
	suresponses_fk_su.`submittal_type_id` AS 'suresponses_fk_su__submittal_type_id',
	suresponses_fk_su.`submittal_status_id` AS 'suresponses_fk_su__submittal_status_id',
	suresponses_fk_su.`submittal_priority_id` AS 'suresponses_fk_su__submittal_priority_id',
	suresponses_fk_su.`submittal_distribution_method_id` AS 'suresponses_fk_su__submittal_distribution_method_id',
	suresponses_fk_su.`su_file_manager_file_id` AS 'suresponses_fk_su__su_file_manager_file_id',
	suresponses_fk_su.`su_cost_code_id` AS 'suresponses_fk_su__su_cost_code_id',
	suresponses_fk_su.`su_creator_contact_id` AS 'suresponses_fk_su__su_creator_contact_id',
	suresponses_fk_su.`su_creator_contact_company_office_id` AS 'suresponses_fk_su__su_creator_contact_company_office_id',
	suresponses_fk_su.`su_creator_phone_contact_company_office_phone_number_id` AS 'suresponses_fk_su__su_creator_phone_contact_company_office_phone_number_id',
	suresponses_fk_su.`su_creator_fax_contact_company_office_phone_number_id` AS 'suresponses_fk_su__su_creator_fax_contact_company_office_phone_number_id',
	suresponses_fk_su.`su_creator_contact_mobile_phone_number_id` AS 'suresponses_fk_su__su_creator_contact_mobile_phone_number_id',
	suresponses_fk_su.`su_recipient_contact_id` AS 'suresponses_fk_su__su_recipient_contact_id',
	suresponses_fk_su.`su_recipient_contact_company_office_id` AS 'suresponses_fk_su__su_recipient_contact_company_office_id',
	suresponses_fk_su.`su_recipient_phone_contact_company_office_phone_number_id` AS 'suresponses_fk_su__su_recipient_phone_contact_company_office_phone_number_id',
	suresponses_fk_su.`su_recipient_fax_contact_company_office_phone_number_id` AS 'suresponses_fk_su__su_recipient_fax_contact_company_office_phone_number_id',
	suresponses_fk_su.`su_recipient_contact_mobile_phone_number_id` AS 'suresponses_fk_su__su_recipient_contact_mobile_phone_number_id',
	suresponses_fk_su.`su_initiator_contact_id` AS 'suresponses_fk_su__su_initiator_contact_id',
	suresponses_fk_su.`su_initiator_contact_company_office_id` AS 'suresponses_fk_su__su_initiator_contact_company_office_id',
	suresponses_fk_su.`su_initiator_phone_contact_company_office_phone_number_id` AS 'suresponses_fk_su__su_initiator_phone_contact_company_office_phone_number_id',
	suresponses_fk_su.`su_initiator_fax_contact_company_office_phone_number_id` AS 'suresponses_fk_su__su_initiator_fax_contact_company_office_phone_number_id',
	suresponses_fk_su.`su_initiator_contact_mobile_phone_number_id` AS 'suresponses_fk_su__su_initiator_contact_mobile_phone_number_id',
	suresponses_fk_su.`su_title` AS 'suresponses_fk_su__su_title',
	suresponses_fk_su.`su_plan_page_reference` AS 'suresponses_fk_su__su_plan_page_reference',
	suresponses_fk_su.`su_statement` AS 'suresponses_fk_su__su_statement',
	suresponses_fk_su.`created` AS 'suresponses_fk_su__created',
	suresponses_fk_su.`su_due_date` AS 'suresponses_fk_su__su_due_date',
	suresponses_fk_su.`su_closed_date` AS 'suresponses_fk_su__su_closed_date',

	suresponses_fk_surt.`id` AS 'suresponses_fk_surt__submittal_response_type_id',
	suresponses_fk_surt.`submittal_response_type` AS 'suresponses_fk_surt__submittal_response_type',
	suresponses_fk_surt.`disabled_flag` AS 'suresponses_fk_surt__disabled_flag',

	suresponses_fk_responder_c.`id` AS 'suresponses_fk_responder_c__contact_id',
	suresponses_fk_responder_c.`user_company_id` AS 'suresponses_fk_responder_c__user_company_id',
	suresponses_fk_responder_c.`user_id` AS 'suresponses_fk_responder_c__user_id',
	suresponses_fk_responder_c.`contact_company_id` AS 'suresponses_fk_responder_c__contact_company_id',
	suresponses_fk_responder_c.`email` AS 'suresponses_fk_responder_c__email',
	suresponses_fk_responder_c.`name_prefix` AS 'suresponses_fk_responder_c__name_prefix',
	suresponses_fk_responder_c.`first_name` AS 'suresponses_fk_responder_c__first_name',
	suresponses_fk_responder_c.`additional_name` AS 'suresponses_fk_responder_c__additional_name',
	suresponses_fk_responder_c.`middle_name` AS 'suresponses_fk_responder_c__middle_name',
	suresponses_fk_responder_c.`last_name` AS 'suresponses_fk_responder_c__last_name',
	suresponses_fk_responder_c.`name_suffix` AS 'suresponses_fk_responder_c__name_suffix',
	suresponses_fk_responder_c.`title` AS 'suresponses_fk_responder_c__title',
	suresponses_fk_responder_c.`vendor_flag` AS 'suresponses_fk_responder_c__vendor_flag',
	suresponses_fk_responder_c.`is_archive` AS 'suresponses_fk_responder_c__is_archive',

	suresponses_fk_responder_cco.`id` AS 'suresponses_fk_responder_cco__contact_company_office_id',
	suresponses_fk_responder_cco.`contact_company_id` AS 'suresponses_fk_responder_cco__contact_company_id',
	suresponses_fk_responder_cco.`office_nickname` AS 'suresponses_fk_responder_cco__office_nickname',
	suresponses_fk_responder_cco.`address_line_1` AS 'suresponses_fk_responder_cco__address_line_1',
	suresponses_fk_responder_cco.`address_line_2` AS 'suresponses_fk_responder_cco__address_line_2',
	suresponses_fk_responder_cco.`address_line_3` AS 'suresponses_fk_responder_cco__address_line_3',
	suresponses_fk_responder_cco.`address_line_4` AS 'suresponses_fk_responder_cco__address_line_4',
	suresponses_fk_responder_cco.`address_city` AS 'suresponses_fk_responder_cco__address_city',
	suresponses_fk_responder_cco.`address_county` AS 'suresponses_fk_responder_cco__address_county',
	suresponses_fk_responder_cco.`address_state_or_region` AS 'suresponses_fk_responder_cco__address_state_or_region',
	suresponses_fk_responder_cco.`address_postal_code` AS 'suresponses_fk_responder_cco__address_postal_code',
	suresponses_fk_responder_cco.`address_postal_code_extension` AS 'suresponses_fk_responder_cco__address_postal_code_extension',
	suresponses_fk_responder_cco.`address_country` AS 'suresponses_fk_responder_cco__address_country',
	suresponses_fk_responder_cco.`head_quarters_flag` AS 'suresponses_fk_responder_cco__head_quarters_flag',
	suresponses_fk_responder_cco.`address_validated_by_user_flag` AS 'suresponses_fk_responder_cco__address_validated_by_user_flag',
	suresponses_fk_responder_cco.`address_validated_by_web_service_flag` AS 'suresponses_fk_responder_cco__address_validated_by_web_service_flag',
	suresponses_fk_responder_cco.`address_validation_by_web_service_error_flag` AS 'suresponses_fk_responder_cco__address_validation_by_web_service_error_flag',

	suresponses_fk_responder_phone_ccopn.`id` AS 'suresponses_fk_responder_phone_ccopn__contact_company_office_phone_number_id',
	suresponses_fk_responder_phone_ccopn.`contact_company_office_id` AS 'suresponses_fk_responder_phone_ccopn__contact_company_office_id',
	suresponses_fk_responder_phone_ccopn.`phone_number_type_id` AS 'suresponses_fk_responder_phone_ccopn__phone_number_type_id',
	suresponses_fk_responder_phone_ccopn.`country_code` AS 'suresponses_fk_responder_phone_ccopn__country_code',
	suresponses_fk_responder_phone_ccopn.`area_code` AS 'suresponses_fk_responder_phone_ccopn__area_code',
	suresponses_fk_responder_phone_ccopn.`prefix` AS 'suresponses_fk_responder_phone_ccopn__prefix',
	suresponses_fk_responder_phone_ccopn.`number` AS 'suresponses_fk_responder_phone_ccopn__number',
	suresponses_fk_responder_phone_ccopn.`extension` AS 'suresponses_fk_responder_phone_ccopn__extension',
	suresponses_fk_responder_phone_ccopn.`itu` AS 'suresponses_fk_responder_phone_ccopn__itu',

	suresponses_fk_responder_fax_ccopn.`id` AS 'suresponses_fk_responder_fax_ccopn__contact_company_office_phone_number_id',
	suresponses_fk_responder_fax_ccopn.`contact_company_office_id` AS 'suresponses_fk_responder_fax_ccopn__contact_company_office_id',
	suresponses_fk_responder_fax_ccopn.`phone_number_type_id` AS 'suresponses_fk_responder_fax_ccopn__phone_number_type_id',
	suresponses_fk_responder_fax_ccopn.`country_code` AS 'suresponses_fk_responder_fax_ccopn__country_code',
	suresponses_fk_responder_fax_ccopn.`area_code` AS 'suresponses_fk_responder_fax_ccopn__area_code',
	suresponses_fk_responder_fax_ccopn.`prefix` AS 'suresponses_fk_responder_fax_ccopn__prefix',
	suresponses_fk_responder_fax_ccopn.`number` AS 'suresponses_fk_responder_fax_ccopn__number',
	suresponses_fk_responder_fax_ccopn.`extension` AS 'suresponses_fk_responder_fax_ccopn__extension',
	suresponses_fk_responder_fax_ccopn.`itu` AS 'suresponses_fk_responder_fax_ccopn__itu',

	suresponses_fk_responder_c_mobile_cpn.`id` AS 'suresponses_fk_responder_c_mobile_cpn__contact_phone_number_id',
	suresponses_fk_responder_c_mobile_cpn.`contact_id` AS 'suresponses_fk_responder_c_mobile_cpn__contact_id',
	suresponses_fk_responder_c_mobile_cpn.`phone_number_type_id` AS 'suresponses_fk_responder_c_mobile_cpn__phone_number_type_id',
	suresponses_fk_responder_c_mobile_cpn.`country_code` AS 'suresponses_fk_responder_c_mobile_cpn__country_code',
	suresponses_fk_responder_c_mobile_cpn.`area_code` AS 'suresponses_fk_responder_c_mobile_cpn__area_code',
	suresponses_fk_responder_c_mobile_cpn.`prefix` AS 'suresponses_fk_responder_c_mobile_cpn__prefix',
	suresponses_fk_responder_c_mobile_cpn.`number` AS 'suresponses_fk_responder_c_mobile_cpn__number',
	suresponses_fk_responder_c_mobile_cpn.`extension` AS 'suresponses_fk_responder_c_mobile_cpn__extension',
	suresponses_fk_responder_c_mobile_cpn.`itu` AS 'suresponses_fk_responder_c_mobile_cpn__itu',

	suresponses.*

FROM `submittal_responses` suresponses
	INNER JOIN `submittals` suresponses_fk_su ON suresponses.`submittal_id` = suresponses_fk_su.`id`
	INNER JOIN `submittal_response_types` suresponses_fk_surt ON suresponses.`submittal_response_type_id` = suresponses_fk_surt.`id`
	INNER JOIN `contacts` suresponses_fk_responder_c ON suresponses.`su_responder_contact_id` = suresponses_fk_responder_c.`id`
	LEFT OUTER JOIN `contact_company_offices` suresponses_fk_responder_cco ON suresponses.`su_responder_contact_company_office_id` = suresponses_fk_responder_cco.`id`
	LEFT OUTER JOIN `contact_company_office_phone_numbers` suresponses_fk_responder_phone_ccopn ON suresponses.`su_responder_phone_contact_company_office_phone_number_id` = suresponses_fk_responder_phone_ccopn.`id`
	LEFT OUTER JOIN `contact_company_office_phone_numbers` suresponses_fk_responder_fax_ccopn ON suresponses.`su_responder_fax_contact_company_office_phone_number_id` = suresponses_fk_responder_fax_ccopn.`id`
	LEFT OUTER JOIN `contact_phone_numbers` suresponses_fk_responder_c_mobile_cpn ON suresponses.`su_responder_contact_mobile_phone_number_id` = suresponses_fk_responder_c_mobile_cpn.`id`
WHERE suresponses.`submittal_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `submittal_id` ASC, `submittal_response_sequence_number` ASC, `submittal_response_type_id` ASC, `su_responder_contact_id` ASC, `su_responder_contact_company_office_id` ASC, `su_responder_phone_contact_company_office_phone_number_id` ASC, `su_responder_fax_contact_company_office_phone_number_id` ASC, `su_responder_contact_mobile_phone_number_id` ASC, `submittal_response_title` ASC, `submittal_response` ASC, `modified` ASC, `created` ASC
		$arrValues = array($submittal_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubmittalResponsesBySubmittalId = array();
		while ($row = $db->fetch()) {
			$submittal_response_id = $row['id'];
			$submittalResponse = self::instantiateOrm($database, 'SubmittalResponse', $row, null, $submittal_response_id);
			/* @var $submittalResponse SubmittalResponse */
			$submittalResponse->convertPropertiesToData();

			if (isset($row['submittal_id'])) {
				$submittal_id = $row['submittal_id'];
				$row['suresponses_fk_su__id'] = $submittal_id;
				$submittal = self::instantiateOrm($database, 'Submittal', $row, null, $submittal_id, 'suresponses_fk_su__');
				/* @var $submittal Submittal */
				$submittal->convertPropertiesToData();
			} else {
				$submittal = false;
			}
			$submittalResponse->setSubmittal($submittal);

			if (isset($row['submittal_response_type_id'])) {
				$submittal_response_type_id = $row['submittal_response_type_id'];
				$row['suresponses_fk_surt__id'] = $submittal_response_type_id;
				$submittalResponseType = self::instantiateOrm($database, 'SubmittalResponseType', $row, null, $submittal_response_type_id, 'suresponses_fk_surt__');
				/* @var $submittalResponseType SubmittalResponseType */
				$submittalResponseType->convertPropertiesToData();
			} else {
				$submittalResponseType = false;
			}
			$submittalResponse->setSubmittalResponseType($submittalResponseType);

			if (isset($row['su_responder_contact_id'])) {
				$su_responder_contact_id = $row['su_responder_contact_id'];
				$row['suresponses_fk_responder_c__id'] = $su_responder_contact_id;
				$suResponderContact = self::instantiateOrm($database, 'Contact', $row, null, $su_responder_contact_id, 'suresponses_fk_responder_c__');
				/* @var $suResponderContact Contact */
				$suResponderContact->convertPropertiesToData();
			} else {
				$suResponderContact = false;
			}
			$submittalResponse->setSuResponderContact($suResponderContact);

			if (isset($row['su_responder_contact_company_office_id'])) {
				$su_responder_contact_company_office_id = $row['su_responder_contact_company_office_id'];
				$row['suresponses_fk_responder_cco__id'] = $su_responder_contact_company_office_id;
				$suResponderContactCompanyOffice = self::instantiateOrm($database, 'ContactCompanyOffice', $row, null, $su_responder_contact_company_office_id, 'suresponses_fk_responder_cco__');
				/* @var $suResponderContactCompanyOffice ContactCompanyOffice */
				$suResponderContactCompanyOffice->convertPropertiesToData();
			} else {
				$suResponderContactCompanyOffice = false;
			}
			$submittalResponse->setSuResponderContactCompanyOffice($suResponderContactCompanyOffice);

			if (isset($row['su_responder_phone_contact_company_office_phone_number_id'])) {
				$su_responder_phone_contact_company_office_phone_number_id = $row['su_responder_phone_contact_company_office_phone_number_id'];
				$row['suresponses_fk_responder_phone_ccopn__id'] = $su_responder_phone_contact_company_office_phone_number_id;
				$suResponderPhoneContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $su_responder_phone_contact_company_office_phone_number_id, 'suresponses_fk_responder_phone_ccopn__');
				/* @var $suResponderPhoneContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$suResponderPhoneContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$suResponderPhoneContactCompanyOfficePhoneNumber = false;
			}
			$submittalResponse->setSuResponderPhoneContactCompanyOfficePhoneNumber($suResponderPhoneContactCompanyOfficePhoneNumber);

			if (isset($row['su_responder_fax_contact_company_office_phone_number_id'])) {
				$su_responder_fax_contact_company_office_phone_number_id = $row['su_responder_fax_contact_company_office_phone_number_id'];
				$row['suresponses_fk_responder_fax_ccopn__id'] = $su_responder_fax_contact_company_office_phone_number_id;
				$suResponderFaxContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $su_responder_fax_contact_company_office_phone_number_id, 'suresponses_fk_responder_fax_ccopn__');
				/* @var $suResponderFaxContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$suResponderFaxContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$suResponderFaxContactCompanyOfficePhoneNumber = false;
			}
			$submittalResponse->setSuResponderFaxContactCompanyOfficePhoneNumber($suResponderFaxContactCompanyOfficePhoneNumber);

			if (isset($row['su_responder_contact_mobile_phone_number_id'])) {
				$su_responder_contact_mobile_phone_number_id = $row['su_responder_contact_mobile_phone_number_id'];
				$row['suresponses_fk_responder_c_mobile_cpn__id'] = $su_responder_contact_mobile_phone_number_id;
				$suResponderContactMobilePhoneNumber = self::instantiateOrm($database, 'ContactPhoneNumber', $row, null, $su_responder_contact_mobile_phone_number_id, 'suresponses_fk_responder_c_mobile_cpn__');
				/* @var $suResponderContactMobilePhoneNumber ContactPhoneNumber */
				$suResponderContactMobilePhoneNumber->convertPropertiesToData();
			} else {
				$suResponderContactMobilePhoneNumber = false;
			}
			$submittalResponse->setSuResponderContactMobilePhoneNumber($suResponderContactMobilePhoneNumber);

			$arrSubmittalResponsesBySubmittalId[$submittal_response_id] = $submittalResponse;
		}

		$db->free_result();

		self::$_arrSubmittalResponsesBySubmittalId = $arrSubmittalResponsesBySubmittalId;

		return $arrSubmittalResponsesBySubmittalId;
	}

	/**
	 * Load by constraint `submittal_responses_fk_surt` foreign key (`submittal_response_type_id`) references `submittal_response_types` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $submittal_response_type_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubmittalResponsesBySubmittalResponseTypeId($database, $submittal_response_type_id, Input $options=null)
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
			self::$_arrSubmittalResponsesBySubmittalResponseTypeId = null;
		}

		$arrSubmittalResponsesBySubmittalResponseTypeId = self::$_arrSubmittalResponsesBySubmittalResponseTypeId;
		if (isset($arrSubmittalResponsesBySubmittalResponseTypeId) && !empty($arrSubmittalResponsesBySubmittalResponseTypeId)) {
			return $arrSubmittalResponsesBySubmittalResponseTypeId;
		}

		$submittal_response_type_id = (int) $submittal_response_type_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `submittal_id` ASC, `submittal_response_sequence_number` ASC, `submittal_response_type_id` ASC, `su_responder_contact_id` ASC, `su_responder_contact_company_office_id` ASC, `su_responder_phone_contact_company_office_phone_number_id` ASC, `su_responder_fax_contact_company_office_phone_number_id` ASC, `su_responder_contact_mobile_phone_number_id` ASC, `submittal_response_title` ASC, `submittal_response` ASC, `modified` ASC, `created` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubmittalResponse = new SubmittalResponse($database);
			$sqlOrderByColumns = $tmpSubmittalResponse->constructSqlOrderByColumns($arrOrderByAttributes);

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
	suresponses.*

FROM `submittal_responses` suresponses
WHERE suresponses.`submittal_response_type_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `submittal_id` ASC, `submittal_response_sequence_number` ASC, `submittal_response_type_id` ASC, `su_responder_contact_id` ASC, `su_responder_contact_company_office_id` ASC, `su_responder_phone_contact_company_office_phone_number_id` ASC, `su_responder_fax_contact_company_office_phone_number_id` ASC, `su_responder_contact_mobile_phone_number_id` ASC, `submittal_response_title` ASC, `submittal_response` ASC, `modified` ASC, `created` ASC
		$arrValues = array($submittal_response_type_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubmittalResponsesBySubmittalResponseTypeId = array();
		while ($row = $db->fetch()) {
			$submittal_response_id = $row['id'];
			$submittalResponse = self::instantiateOrm($database, 'SubmittalResponse', $row, null, $submittal_response_id);
			/* @var $submittalResponse SubmittalResponse */
			$arrSubmittalResponsesBySubmittalResponseTypeId[$submittal_response_id] = $submittalResponse;
		}

		$db->free_result();

		self::$_arrSubmittalResponsesBySubmittalResponseTypeId = $arrSubmittalResponsesBySubmittalResponseTypeId;

		return $arrSubmittalResponsesBySubmittalResponseTypeId;
	}

	/**
	 * Load by constraint `submittal_responses_fk_responder_c` foreign key (`su_responder_contact_id`) references `contacts` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $su_responder_contact_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubmittalResponsesBySuResponderContactId($database, $su_responder_contact_id, Input $options=null)
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
			self::$_arrSubmittalResponsesBySuResponderContactId = null;
		}

		$arrSubmittalResponsesBySuResponderContactId = self::$_arrSubmittalResponsesBySuResponderContactId;
		if (isset($arrSubmittalResponsesBySuResponderContactId) && !empty($arrSubmittalResponsesBySuResponderContactId)) {
			return $arrSubmittalResponsesBySuResponderContactId;
		}

		$su_responder_contact_id = (int) $su_responder_contact_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `submittal_id` ASC, `submittal_response_sequence_number` ASC, `submittal_response_type_id` ASC, `su_responder_contact_id` ASC, `su_responder_contact_company_office_id` ASC, `su_responder_phone_contact_company_office_phone_number_id` ASC, `su_responder_fax_contact_company_office_phone_number_id` ASC, `su_responder_contact_mobile_phone_number_id` ASC, `submittal_response_title` ASC, `submittal_response` ASC, `modified` ASC, `created` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubmittalResponse = new SubmittalResponse($database);
			$sqlOrderByColumns = $tmpSubmittalResponse->constructSqlOrderByColumns($arrOrderByAttributes);

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
	suresponses.*

FROM `submittal_responses` suresponses
WHERE suresponses.`su_responder_contact_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `submittal_id` ASC, `submittal_response_sequence_number` ASC, `submittal_response_type_id` ASC, `su_responder_contact_id` ASC, `su_responder_contact_company_office_id` ASC, `su_responder_phone_contact_company_office_phone_number_id` ASC, `su_responder_fax_contact_company_office_phone_number_id` ASC, `su_responder_contact_mobile_phone_number_id` ASC, `submittal_response_title` ASC, `submittal_response` ASC, `modified` ASC, `created` ASC
		$arrValues = array($su_responder_contact_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubmittalResponsesBySuResponderContactId = array();
		while ($row = $db->fetch()) {
			$submittal_response_id = $row['id'];
			$submittalResponse = self::instantiateOrm($database, 'SubmittalResponse', $row, null, $submittal_response_id);
			/* @var $submittalResponse SubmittalResponse */
			$arrSubmittalResponsesBySuResponderContactId[$submittal_response_id] = $submittalResponse;
		}

		$db->free_result();

		self::$_arrSubmittalResponsesBySuResponderContactId = $arrSubmittalResponsesBySuResponderContactId;

		return $arrSubmittalResponsesBySuResponderContactId;
	}

	/**
	 * Load by constraint `submittal_responses_fk_responder_cco` foreign key (`su_responder_contact_company_office_id`) references `contact_company_offices` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $su_responder_contact_company_office_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubmittalResponsesBySuResponderContactCompanyOfficeId($database, $su_responder_contact_company_office_id, Input $options=null)
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
			self::$_arrSubmittalResponsesBySuResponderContactCompanyOfficeId = null;
		}

		$arrSubmittalResponsesBySuResponderContactCompanyOfficeId = self::$_arrSubmittalResponsesBySuResponderContactCompanyOfficeId;
		if (isset($arrSubmittalResponsesBySuResponderContactCompanyOfficeId) && !empty($arrSubmittalResponsesBySuResponderContactCompanyOfficeId)) {
			return $arrSubmittalResponsesBySuResponderContactCompanyOfficeId;
		}

		$su_responder_contact_company_office_id = (int) $su_responder_contact_company_office_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `submittal_id` ASC, `submittal_response_sequence_number` ASC, `submittal_response_type_id` ASC, `su_responder_contact_id` ASC, `su_responder_contact_company_office_id` ASC, `su_responder_phone_contact_company_office_phone_number_id` ASC, `su_responder_fax_contact_company_office_phone_number_id` ASC, `su_responder_contact_mobile_phone_number_id` ASC, `submittal_response_title` ASC, `submittal_response` ASC, `modified` ASC, `created` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubmittalResponse = new SubmittalResponse($database);
			$sqlOrderByColumns = $tmpSubmittalResponse->constructSqlOrderByColumns($arrOrderByAttributes);

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
	suresponses.*

FROM `submittal_responses` suresponses
WHERE suresponses.`su_responder_contact_company_office_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `submittal_id` ASC, `submittal_response_sequence_number` ASC, `submittal_response_type_id` ASC, `su_responder_contact_id` ASC, `su_responder_contact_company_office_id` ASC, `su_responder_phone_contact_company_office_phone_number_id` ASC, `su_responder_fax_contact_company_office_phone_number_id` ASC, `su_responder_contact_mobile_phone_number_id` ASC, `submittal_response_title` ASC, `submittal_response` ASC, `modified` ASC, `created` ASC
		$arrValues = array($su_responder_contact_company_office_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubmittalResponsesBySuResponderContactCompanyOfficeId = array();
		while ($row = $db->fetch()) {
			$submittal_response_id = $row['id'];
			$submittalResponse = self::instantiateOrm($database, 'SubmittalResponse', $row, null, $submittal_response_id);
			/* @var $submittalResponse SubmittalResponse */
			$arrSubmittalResponsesBySuResponderContactCompanyOfficeId[$submittal_response_id] = $submittalResponse;
		}

		$db->free_result();

		self::$_arrSubmittalResponsesBySuResponderContactCompanyOfficeId = $arrSubmittalResponsesBySuResponderContactCompanyOfficeId;

		return $arrSubmittalResponsesBySuResponderContactCompanyOfficeId;
	}

	/**
	 * Load by constraint `submittal_responses_fk_responder_phone_ccopn` foreign key (`su_responder_phone_contact_company_office_phone_number_id`) references `contact_company_office_phone_numbers` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $su_responder_phone_contact_company_office_phone_number_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubmittalResponsesBySuResponderPhoneContactCompanyOfficePhoneNumberId($database, $su_responder_phone_contact_company_office_phone_number_id, Input $options=null)
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
			self::$_arrSubmittalResponsesBySuResponderPhoneContactCompanyOfficePhoneNumberId = null;
		}

		$arrSubmittalResponsesBySuResponderPhoneContactCompanyOfficePhoneNumberId = self::$_arrSubmittalResponsesBySuResponderPhoneContactCompanyOfficePhoneNumberId;
		if (isset($arrSubmittalResponsesBySuResponderPhoneContactCompanyOfficePhoneNumberId) && !empty($arrSubmittalResponsesBySuResponderPhoneContactCompanyOfficePhoneNumberId)) {
			return $arrSubmittalResponsesBySuResponderPhoneContactCompanyOfficePhoneNumberId;
		}

		$su_responder_phone_contact_company_office_phone_number_id = (int) $su_responder_phone_contact_company_office_phone_number_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `submittal_id` ASC, `submittal_response_sequence_number` ASC, `submittal_response_type_id` ASC, `su_responder_contact_id` ASC, `su_responder_contact_company_office_id` ASC, `su_responder_phone_contact_company_office_phone_number_id` ASC, `su_responder_fax_contact_company_office_phone_number_id` ASC, `su_responder_contact_mobile_phone_number_id` ASC, `submittal_response_title` ASC, `submittal_response` ASC, `modified` ASC, `created` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubmittalResponse = new SubmittalResponse($database);
			$sqlOrderByColumns = $tmpSubmittalResponse->constructSqlOrderByColumns($arrOrderByAttributes);

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
	suresponses.*

FROM `submittal_responses` suresponses
WHERE suresponses.`su_responder_phone_contact_company_office_phone_number_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `submittal_id` ASC, `submittal_response_sequence_number` ASC, `submittal_response_type_id` ASC, `su_responder_contact_id` ASC, `su_responder_contact_company_office_id` ASC, `su_responder_phone_contact_company_office_phone_number_id` ASC, `su_responder_fax_contact_company_office_phone_number_id` ASC, `su_responder_contact_mobile_phone_number_id` ASC, `submittal_response_title` ASC, `submittal_response` ASC, `modified` ASC, `created` ASC
		$arrValues = array($su_responder_phone_contact_company_office_phone_number_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubmittalResponsesBySuResponderPhoneContactCompanyOfficePhoneNumberId = array();
		while ($row = $db->fetch()) {
			$submittal_response_id = $row['id'];
			$submittalResponse = self::instantiateOrm($database, 'SubmittalResponse', $row, null, $submittal_response_id);
			/* @var $submittalResponse SubmittalResponse */
			$arrSubmittalResponsesBySuResponderPhoneContactCompanyOfficePhoneNumberId[$submittal_response_id] = $submittalResponse;
		}

		$db->free_result();

		self::$_arrSubmittalResponsesBySuResponderPhoneContactCompanyOfficePhoneNumberId = $arrSubmittalResponsesBySuResponderPhoneContactCompanyOfficePhoneNumberId;

		return $arrSubmittalResponsesBySuResponderPhoneContactCompanyOfficePhoneNumberId;
	}

	/**
	 * Load by constraint `submittal_responses_fk_responder_fax_ccopn` foreign key (`su_responder_fax_contact_company_office_phone_number_id`) references `contact_company_office_phone_numbers` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $su_responder_fax_contact_company_office_phone_number_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubmittalResponsesBySuResponderFaxContactCompanyOfficePhoneNumberId($database, $su_responder_fax_contact_company_office_phone_number_id, Input $options=null)
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
			self::$_arrSubmittalResponsesBySuResponderFaxContactCompanyOfficePhoneNumberId = null;
		}

		$arrSubmittalResponsesBySuResponderFaxContactCompanyOfficePhoneNumberId = self::$_arrSubmittalResponsesBySuResponderFaxContactCompanyOfficePhoneNumberId;
		if (isset($arrSubmittalResponsesBySuResponderFaxContactCompanyOfficePhoneNumberId) && !empty($arrSubmittalResponsesBySuResponderFaxContactCompanyOfficePhoneNumberId)) {
			return $arrSubmittalResponsesBySuResponderFaxContactCompanyOfficePhoneNumberId;
		}

		$su_responder_fax_contact_company_office_phone_number_id = (int) $su_responder_fax_contact_company_office_phone_number_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `submittal_id` ASC, `submittal_response_sequence_number` ASC, `submittal_response_type_id` ASC, `su_responder_contact_id` ASC, `su_responder_contact_company_office_id` ASC, `su_responder_phone_contact_company_office_phone_number_id` ASC, `su_responder_fax_contact_company_office_phone_number_id` ASC, `su_responder_contact_mobile_phone_number_id` ASC, `submittal_response_title` ASC, `submittal_response` ASC, `modified` ASC, `created` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubmittalResponse = new SubmittalResponse($database);
			$sqlOrderByColumns = $tmpSubmittalResponse->constructSqlOrderByColumns($arrOrderByAttributes);

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
	suresponses.*

FROM `submittal_responses` suresponses
WHERE suresponses.`su_responder_fax_contact_company_office_phone_number_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `submittal_id` ASC, `submittal_response_sequence_number` ASC, `submittal_response_type_id` ASC, `su_responder_contact_id` ASC, `su_responder_contact_company_office_id` ASC, `su_responder_phone_contact_company_office_phone_number_id` ASC, `su_responder_fax_contact_company_office_phone_number_id` ASC, `su_responder_contact_mobile_phone_number_id` ASC, `submittal_response_title` ASC, `submittal_response` ASC, `modified` ASC, `created` ASC
		$arrValues = array($su_responder_fax_contact_company_office_phone_number_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubmittalResponsesBySuResponderFaxContactCompanyOfficePhoneNumberId = array();
		while ($row = $db->fetch()) {
			$submittal_response_id = $row['id'];
			$submittalResponse = self::instantiateOrm($database, 'SubmittalResponse', $row, null, $submittal_response_id);
			/* @var $submittalResponse SubmittalResponse */
			$arrSubmittalResponsesBySuResponderFaxContactCompanyOfficePhoneNumberId[$submittal_response_id] = $submittalResponse;
		}

		$db->free_result();

		self::$_arrSubmittalResponsesBySuResponderFaxContactCompanyOfficePhoneNumberId = $arrSubmittalResponsesBySuResponderFaxContactCompanyOfficePhoneNumberId;

		return $arrSubmittalResponsesBySuResponderFaxContactCompanyOfficePhoneNumberId;
	}

	/**
	 * Load by constraint `submittal_responses_fk_responder_c_mobile_cpn` foreign key (`su_responder_contact_mobile_phone_number_id`) references `contact_phone_numbers` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $su_responder_contact_mobile_phone_number_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubmittalResponsesBySuResponderContactMobilePhoneNumberId($database, $su_responder_contact_mobile_phone_number_id, Input $options=null)
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
			self::$_arrSubmittalResponsesBySuResponderContactMobilePhoneNumberId = null;
		}

		$arrSubmittalResponsesBySuResponderContactMobilePhoneNumberId = self::$_arrSubmittalResponsesBySuResponderContactMobilePhoneNumberId;
		if (isset($arrSubmittalResponsesBySuResponderContactMobilePhoneNumberId) && !empty($arrSubmittalResponsesBySuResponderContactMobilePhoneNumberId)) {
			return $arrSubmittalResponsesBySuResponderContactMobilePhoneNumberId;
		}

		$su_responder_contact_mobile_phone_number_id = (int) $su_responder_contact_mobile_phone_number_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `submittal_id` ASC, `submittal_response_sequence_number` ASC, `submittal_response_type_id` ASC, `su_responder_contact_id` ASC, `su_responder_contact_company_office_id` ASC, `su_responder_phone_contact_company_office_phone_number_id` ASC, `su_responder_fax_contact_company_office_phone_number_id` ASC, `su_responder_contact_mobile_phone_number_id` ASC, `submittal_response_title` ASC, `submittal_response` ASC, `modified` ASC, `created` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubmittalResponse = new SubmittalResponse($database);
			$sqlOrderByColumns = $tmpSubmittalResponse->constructSqlOrderByColumns($arrOrderByAttributes);

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
	suresponses.*

FROM `submittal_responses` suresponses
WHERE suresponses.`su_responder_contact_mobile_phone_number_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `submittal_id` ASC, `submittal_response_sequence_number` ASC, `submittal_response_type_id` ASC, `su_responder_contact_id` ASC, `su_responder_contact_company_office_id` ASC, `su_responder_phone_contact_company_office_phone_number_id` ASC, `su_responder_fax_contact_company_office_phone_number_id` ASC, `su_responder_contact_mobile_phone_number_id` ASC, `submittal_response_title` ASC, `submittal_response` ASC, `modified` ASC, `created` ASC
		$arrValues = array($su_responder_contact_mobile_phone_number_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubmittalResponsesBySuResponderContactMobilePhoneNumberId = array();
		while ($row = $db->fetch()) {
			$submittal_response_id = $row['id'];
			$submittalResponse = self::instantiateOrm($database, 'SubmittalResponse', $row, null, $submittal_response_id);
			/* @var $submittalResponse SubmittalResponse */
			$arrSubmittalResponsesBySuResponderContactMobilePhoneNumberId[$submittal_response_id] = $submittalResponse;
		}

		$db->free_result();

		self::$_arrSubmittalResponsesBySuResponderContactMobilePhoneNumberId = $arrSubmittalResponsesBySuResponderContactMobilePhoneNumberId;

		return $arrSubmittalResponsesBySuResponderContactMobilePhoneNumberId;
	}

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all submittal_responses records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllSubmittalResponses($database, Input $options=null)
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
			self::$_arrAllSubmittalResponses = null;
		}

		$arrAllSubmittalResponses = self::$_arrAllSubmittalResponses;
		if (isset($arrAllSubmittalResponses) && !empty($arrAllSubmittalResponses)) {
			return $arrAllSubmittalResponses;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `submittal_id` ASC, `submittal_response_sequence_number` ASC, `submittal_response_type_id` ASC, `su_responder_contact_id` ASC, `su_responder_contact_company_office_id` ASC, `su_responder_phone_contact_company_office_phone_number_id` ASC, `su_responder_fax_contact_company_office_phone_number_id` ASC, `su_responder_contact_mobile_phone_number_id` ASC, `submittal_response_title` ASC, `submittal_response` ASC, `modified` ASC, `created` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubmittalResponse = new SubmittalResponse($database);
			$sqlOrderByColumns = $tmpSubmittalResponse->constructSqlOrderByColumns($arrOrderByAttributes);

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
	suresponses.*

FROM `submittal_responses` suresponses{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `submittal_id` ASC, `submittal_response_sequence_number` ASC, `submittal_response_type_id` ASC, `su_responder_contact_id` ASC, `su_responder_contact_company_office_id` ASC, `su_responder_phone_contact_company_office_phone_number_id` ASC, `su_responder_fax_contact_company_office_phone_number_id` ASC, `su_responder_contact_mobile_phone_number_id` ASC, `submittal_response_title` ASC, `submittal_response` ASC, `modified` ASC, `created` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllSubmittalResponses = array();
		while ($row = $db->fetch()) {
			$submittal_response_id = $row['id'];
			$submittalResponse = self::instantiateOrm($database, 'SubmittalResponse', $row, null, $submittal_response_id);
			/* @var $submittalResponse SubmittalResponse */
			$arrAllSubmittalResponses[$submittal_response_id] = $submittalResponse;
		}

		$db->free_result();

		self::$_arrAllSubmittalResponses = $arrAllSubmittalResponses;

		return $arrAllSubmittalResponses;
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
INTO `submittal_responses`
(`submittal_id`, `submittal_response_sequence_number`, `submittal_response_type_id`, `su_responder_contact_id`, `su_responder_contact_company_office_id`, `su_responder_phone_contact_company_office_phone_number_id`, `su_responder_fax_contact_company_office_phone_number_id`, `su_responder_contact_mobile_phone_number_id`, `submittal_response_title`, `submittal_response`, `modified`, `created`)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
ON DUPLICATE KEY UPDATE `submittal_response_type_id` = ?, `su_responder_contact_id` = ?, `su_responder_contact_company_office_id` = ?, `su_responder_phone_contact_company_office_phone_number_id` = ?, `su_responder_fax_contact_company_office_phone_number_id` = ?, `su_responder_contact_mobile_phone_number_id` = ?, `submittal_response_title` = ?, `submittal_response` = ?, `modified` = ?, `created` = ?
";
		$arrValues = array($this->submittal_id, $this->submittal_response_sequence_number, $this->submittal_response_type_id, $this->su_responder_contact_id, $this->su_responder_contact_company_office_id, $this->su_responder_phone_contact_company_office_phone_number_id, $this->su_responder_fax_contact_company_office_phone_number_id, $this->su_responder_contact_mobile_phone_number_id, $this->submittal_response_title, $this->submittal_response, $this->modified, $this->created, $this->submittal_response_type_id, $this->su_responder_contact_id, $this->su_responder_contact_company_office_id, $this->su_responder_phone_contact_company_office_phone_number_id, $this->su_responder_fax_contact_company_office_phone_number_id, $this->su_responder_contact_mobile_phone_number_id, $this->submittal_response_title, $this->submittal_response, $this->modified, $this->created);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$submittal_response_id = $db->insertId;
		$db->free_result();

		return $submittal_response_id;
	}

	// Save: insert ignore

	/**
	 * Find next_submittal_response_sequence_number value.
	 *
	 * @param string $database
	 * @param int $submittal_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findNextSubmittalResponseSequenceNumber($database, $submittal_id)
	{
		$next_submittal_response_sequence_number = 1;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT MAX(su.submittal_response_sequence_number) AS 'max_submittal_response_sequence_number'
FROM `submittal_responses` su
WHERE su.`submittal_id` = ?
";
		$arrValues = array($submittal_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$max_submittal_response_sequence_number = $row['max_submittal_response_sequence_number'];
			$next_submittal_response_sequence_number = $max_submittal_response_sequence_number + 1;
		}

		return $next_submittal_response_sequence_number;
	}
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

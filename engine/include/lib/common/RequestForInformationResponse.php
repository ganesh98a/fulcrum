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
 * RequestForInformationResponse.
 *
 * @category   Framework
 * @package    RequestForInformationResponse
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class RequestForInformationResponse extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'RequestForInformationResponse';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'request_for_information_responses';

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
	 * unique index `unique_request_for_information_response` (`request_for_information_id`,`request_for_information_response_sequence_number`) comment 'One RFI can have many Responses'
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_request_for_information_response' => array(
			'request_for_information_id' => 'int',
			'request_for_information_response_sequence_number' => 'int'
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
		'id' => 'request_for_information_response_id',

		'request_for_information_id' => 'request_for_information_id',
		'request_for_information_response_sequence_number' => 'request_for_information_response_sequence_number',

		'request_for_information_response_type_id' => 'request_for_information_response_type_id',
		'rfi_responder_contact_id' => 'rfi_responder_contact_id',
		'rfi_responder_contact_company_office_id' => 'rfi_responder_contact_company_office_id',
		'rfi_responder_phone_contact_company_office_phone_number_id' => 'rfi_responder_phone_contact_company_office_phone_number_id',
		'rfi_responder_fax_contact_company_office_phone_number_id' => 'rfi_responder_fax_contact_company_office_phone_number_id',
		'rfi_responder_contact_mobile_phone_number_id' => 'rfi_responder_contact_mobile_phone_number_id',

		'request_for_information_response_title' => 'request_for_information_response_title',
		'request_for_information_response' => 'request_for_information_response',
		'modified' => 'modified',
		'created' => 'created'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $request_for_information_response_id;

	public $request_for_information_id;
	public $request_for_information_response_sequence_number;

	public $request_for_information_response_type_id;
	public $rfi_responder_contact_id;
	public $rfi_responder_contact_company_office_id;
	public $rfi_responder_phone_contact_company_office_phone_number_id;
	public $rfi_responder_fax_contact_company_office_phone_number_id;
	public $rfi_responder_contact_mobile_phone_number_id;

	public $request_for_information_response_title;
	public $request_for_information_response;
	public $modified;
	public $created;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties
	public $escaped_request_for_information_response_title;
	public $escaped_request_for_information_response;

	// HTML ENTITY ENCODED NL2BR ORM string properties
	public $escaped_request_for_information_response_title_nl2br;
	public $escaped_request_for_information_response_nl2br;

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)
	protected static $_arrRequestForInformationResponsesByRequestForInformationId;
	protected static $_arrRequestForInformationResponsesByRequestForInformationResponseTypeId;
	protected static $_arrRequestForInformationResponsesByRfiResponderContactId;
	protected static $_arrRequestForInformationResponsesByRfiResponderContactCompanyOfficeId;
	protected static $_arrRequestForInformationResponsesByRfiResponderPhoneContactCompanyOfficePhoneNumberId;
	protected static $_arrRequestForInformationResponsesByRfiResponderFaxContactCompanyOfficePhoneNumberId;
	protected static $_arrRequestForInformationResponsesByRfiResponderContactMobilePhoneNumberId;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllRequestForInformationResponses;

	// Foreign Key Objects
	private $_requestForInformation;
	private $_requestForInformationResponseType;
	private $_rfiResponderContact;
	private $_rfiResponderContactCompanyOffice;
	private $_rfiResponderPhoneContactCompanyOfficePhoneNumber;
	private $_rfiResponderFaxContactCompanyOfficePhoneNumber;
	private $_rfiResponderContactMobilePhoneNumber;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='request_for_information_responses')
	{
		parent::__construct($table);
		$this->setDatabase($database);
	}

	// Foreign Key Object Accessor Methods
	public function getRequestForInformation()
	{
		if (isset($this->_requestForInformation)) {
			return $this->_requestForInformation;
		} else {
			return null;
		}
	}

	public function setRequestForInformation($requestForInformation)
	{
		$this->_requestForInformation = $requestForInformation;
	}

	public function getRequestForInformationResponseType()
	{
		if (isset($this->_requestForInformationResponseType)) {
			return $this->_requestForInformationResponseType;
		} else {
			return null;
		}
	}

	public function setRequestForInformationResponseType($requestForInformationResponseType)
	{
		$this->_requestForInformationResponseType = $requestForInformationResponseType;
	}

	public function getRfiResponderContact()
	{
		if (isset($this->_rfiResponderContact)) {
			return $this->_rfiResponderContact;
		} else {
			return null;
		}
	}

	public function setRfiResponderContact($rfiResponderContact)
	{
		$this->_rfiResponderContact = $rfiResponderContact;
	}

	public function getRfiResponderContactCompanyOffice()
	{
		if (isset($this->_rfiResponderContactCompanyOffice)) {
			return $this->_rfiResponderContactCompanyOffice;
		} else {
			return null;
		}
	}

	public function setRfiResponderContactCompanyOffice($rfiResponderContactCompanyOffice)
	{
		$this->_rfiResponderContactCompanyOffice = $rfiResponderContactCompanyOffice;
	}

	public function getRfiResponderPhoneContactCompanyOfficePhoneNumber()
	{
		if (isset($this->_rfiResponderPhoneContactCompanyOfficePhoneNumber)) {
			return $this->_rfiResponderPhoneContactCompanyOfficePhoneNumber;
		} else {
			return null;
		}
	}

	public function setRfiResponderPhoneContactCompanyOfficePhoneNumber($rfiResponderPhoneContactCompanyOfficePhoneNumber)
	{
		$this->_rfiResponderPhoneContactCompanyOfficePhoneNumber = $rfiResponderPhoneContactCompanyOfficePhoneNumber;
	}

	public function getRfiResponderFaxContactCompanyOfficePhoneNumber()
	{
		if (isset($this->_rfiResponderFaxContactCompanyOfficePhoneNumber)) {
			return $this->_rfiResponderFaxContactCompanyOfficePhoneNumber;
		} else {
			return null;
		}
	}

	public function setRfiResponderFaxContactCompanyOfficePhoneNumber($rfiResponderFaxContactCompanyOfficePhoneNumber)
	{
		$this->_rfiResponderFaxContactCompanyOfficePhoneNumber = $rfiResponderFaxContactCompanyOfficePhoneNumber;
	}

	public function getRfiResponderContactMobilePhoneNumber()
	{
		if (isset($this->_rfiResponderContactMobilePhoneNumber)) {
			return $this->_rfiResponderContactMobilePhoneNumber;
		} else {
			return null;
		}
	}

	public function setRfiResponderContactMobilePhoneNumber($rfiResponderContactMobilePhoneNumber)
	{
		$this->_rfiResponderContactMobilePhoneNumber = $rfiResponderContactMobilePhoneNumber;
	}

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)
	public static function getArrRequestForInformationResponsesByRequestForInformationId()
	{
		if (isset(self::$_arrRequestForInformationResponsesByRequestForInformationId)) {
			return self::$_arrRequestForInformationResponsesByRequestForInformationId;
		} else {
			return null;
		}
	}

	public static function setArrRequestForInformationResponsesByRequestForInformationId($arrRequestForInformationResponsesByRequestForInformationId)
	{
		self::$_arrRequestForInformationResponsesByRequestForInformationId = $arrRequestForInformationResponsesByRequestForInformationId;
	}

	public static function getArrRequestForInformationResponsesByRequestForInformationResponseTypeId()
	{
		if (isset(self::$_arrRequestForInformationResponsesByRequestForInformationResponseTypeId)) {
			return self::$_arrRequestForInformationResponsesByRequestForInformationResponseTypeId;
		} else {
			return null;
		}
	}

	public static function setArrRequestForInformationResponsesByRequestForInformationResponseTypeId($arrRequestForInformationResponsesByRequestForInformationResponseTypeId)
	{
		self::$_arrRequestForInformationResponsesByRequestForInformationResponseTypeId = $arrRequestForInformationResponsesByRequestForInformationResponseTypeId;
	}

	public static function getArrRequestForInformationResponsesByRfiResponderContactId()
	{
		if (isset(self::$_arrRequestForInformationResponsesByRfiResponderContactId)) {
			return self::$_arrRequestForInformationResponsesByRfiResponderContactId;
		} else {
			return null;
		}
	}

	public static function setArrRequestForInformationResponsesByRfiResponderContactId($arrRequestForInformationResponsesByRfiResponderContactId)
	{
		self::$_arrRequestForInformationResponsesByRfiResponderContactId = $arrRequestForInformationResponsesByRfiResponderContactId;
	}

	public static function getArrRequestForInformationResponsesByRfiResponderContactCompanyOfficeId()
	{
		if (isset(self::$_arrRequestForInformationResponsesByRfiResponderContactCompanyOfficeId)) {
			return self::$_arrRequestForInformationResponsesByRfiResponderContactCompanyOfficeId;
		} else {
			return null;
		}
	}

	public static function setArrRequestForInformationResponsesByRfiResponderContactCompanyOfficeId($arrRequestForInformationResponsesByRfiResponderContactCompanyOfficeId)
	{
		self::$_arrRequestForInformationResponsesByRfiResponderContactCompanyOfficeId = $arrRequestForInformationResponsesByRfiResponderContactCompanyOfficeId;
	}

	public static function getArrRequestForInformationResponsesByRfiResponderPhoneContactCompanyOfficePhoneNumberId()
	{
		if (isset(self::$_arrRequestForInformationResponsesByRfiResponderPhoneContactCompanyOfficePhoneNumberId)) {
			return self::$_arrRequestForInformationResponsesByRfiResponderPhoneContactCompanyOfficePhoneNumberId;
		} else {
			return null;
		}
	}

	public static function setArrRequestForInformationResponsesByRfiResponderPhoneContactCompanyOfficePhoneNumberId($arrRequestForInformationResponsesByRfiResponderPhoneContactCompanyOfficePhoneNumberId)
	{
		self::$_arrRequestForInformationResponsesByRfiResponderPhoneContactCompanyOfficePhoneNumberId = $arrRequestForInformationResponsesByRfiResponderPhoneContactCompanyOfficePhoneNumberId;
	}

	public static function getArrRequestForInformationResponsesByRfiResponderFaxContactCompanyOfficePhoneNumberId()
	{
		if (isset(self::$_arrRequestForInformationResponsesByRfiResponderFaxContactCompanyOfficePhoneNumberId)) {
			return self::$_arrRequestForInformationResponsesByRfiResponderFaxContactCompanyOfficePhoneNumberId;
		} else {
			return null;
		}
	}

	public static function setArrRequestForInformationResponsesByRfiResponderFaxContactCompanyOfficePhoneNumberId($arrRequestForInformationResponsesByRfiResponderFaxContactCompanyOfficePhoneNumberId)
	{
		self::$_arrRequestForInformationResponsesByRfiResponderFaxContactCompanyOfficePhoneNumberId = $arrRequestForInformationResponsesByRfiResponderFaxContactCompanyOfficePhoneNumberId;
	}

	public static function getArrRequestForInformationResponsesByRfiResponderContactMobilePhoneNumberId()
	{
		if (isset(self::$_arrRequestForInformationResponsesByRfiResponderContactMobilePhoneNumberId)) {
			return self::$_arrRequestForInformationResponsesByRfiResponderContactMobilePhoneNumberId;
		} else {
			return null;
		}
	}

	public static function setArrRequestForInformationResponsesByRfiResponderContactMobilePhoneNumberId($arrRequestForInformationResponsesByRfiResponderContactMobilePhoneNumberId)
	{
		self::$_arrRequestForInformationResponsesByRfiResponderContactMobilePhoneNumberId = $arrRequestForInformationResponsesByRfiResponderContactMobilePhoneNumberId;
	}

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllRequestForInformationResponses()
	{
		if (isset(self::$_arrAllRequestForInformationResponses)) {
			return self::$_arrAllRequestForInformationResponses;
		} else {
			return null;
		}
	}

	public static function setArrAllRequestForInformationResponses($arrAllRequestForInformationResponses)
	{
		self::$_arrAllRequestForInformationResponses = $arrAllRequestForInformationResponses;
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
	 * @param int $request_for_information_response_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findById($database, $request_for_information_response_id,$table='request_for_information_responses', $module='RequestForInformationResponse')
	{
		$requestForInformationResponse = parent::findById($database, $request_for_information_response_id, $table, $module);

		return $requestForInformationResponse;
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Similar to FindById, but with SQL as starter code for more complex joins.
	 *
	 * @param string $database
	 * @param int $request_for_information_response_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findRequestForInformationResponseByIdExtended($database, $request_for_information_response_id)
	{
		$request_for_information_response_id = (int) $request_for_information_response_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	rfiresponses_fk_rfi.`id` AS 'rfiresponses_fk_rfi__request_for_information_id',
	rfiresponses_fk_rfi.`project_id` AS 'rfiresponses_fk_rfi__project_id',
	rfiresponses_fk_rfi.`rfi_sequence_number` AS 'rfiresponses_fk_rfi__rfi_sequence_number',
	rfiresponses_fk_rfi.`request_for_information_type_id` AS 'rfiresponses_fk_rfi__request_for_information_type_id',
	rfiresponses_fk_rfi.`request_for_information_status_id` AS 'rfiresponses_fk_rfi__request_for_information_status_id',
	rfiresponses_fk_rfi.`request_for_information_priority_id` AS 'rfiresponses_fk_rfi__request_for_information_priority_id',
	rfiresponses_fk_rfi.`rfi_file_manager_file_id` AS 'rfiresponses_fk_rfi__rfi_file_manager_file_id',
	rfiresponses_fk_rfi.`rfi_cost_code_id` AS 'rfiresponses_fk_rfi__rfi_cost_code_id',
	rfiresponses_fk_rfi.`rfi_creator_contact_id` AS 'rfiresponses_fk_rfi__rfi_creator_contact_id',
	rfiresponses_fk_rfi.`rfi_creator_contact_company_office_id` AS 'rfiresponses_fk_rfi__rfi_creator_contact_company_office_id',
	rfiresponses_fk_rfi.`rfi_creator_phone_contact_company_office_phone_number_id` AS 'rfiresponses_fk_rfi__rfi_creator_phone_contact_company_office_phone_number_id',
	rfiresponses_fk_rfi.`rfi_creator_fax_contact_company_office_phone_number_id` AS 'rfiresponses_fk_rfi__rfi_creator_fax_contact_company_office_phone_number_id',
	rfiresponses_fk_rfi.`rfi_creator_contact_mobile_phone_number_id` AS 'rfiresponses_fk_rfi__rfi_creator_contact_mobile_phone_number_id',
	rfiresponses_fk_rfi.`rfi_recipient_contact_id` AS 'rfiresponses_fk_rfi__rfi_recipient_contact_id',
	rfiresponses_fk_rfi.`rfi_recipient_contact_company_office_id` AS 'rfiresponses_fk_rfi__rfi_recipient_contact_company_office_id',
	rfiresponses_fk_rfi.`rfi_recipient_phone_contact_company_office_phone_number_id` AS 'rfiresponses_fk_rfi__rfi_recipient_phone_contact_company_office_phone_number_id',
	rfiresponses_fk_rfi.`rfi_recipient_fax_contact_company_office_phone_number_id` AS 'rfiresponses_fk_rfi__rfi_recipient_fax_contact_company_office_phone_number_id',
	rfiresponses_fk_rfi.`rfi_recipient_contact_mobile_phone_number_id` AS 'rfiresponses_fk_rfi__rfi_recipient_contact_mobile_phone_number_id',
	rfiresponses_fk_rfi.`rfi_initiator_contact_id` AS 'rfiresponses_fk_rfi__rfi_initiator_contact_id',
	rfiresponses_fk_rfi.`rfi_initiator_contact_company_office_id` AS 'rfiresponses_fk_rfi__rfi_initiator_contact_company_office_id',
	rfiresponses_fk_rfi.`rfi_initiator_phone_contact_company_office_phone_number_id` AS 'rfiresponses_fk_rfi__rfi_initiator_phone_contact_company_office_phone_number_id',
	rfiresponses_fk_rfi.`rfi_initiator_fax_contact_company_office_phone_number_id` AS 'rfiresponses_fk_rfi__rfi_initiator_fax_contact_company_office_phone_number_id',
	rfiresponses_fk_rfi.`rfi_initiator_contact_mobile_phone_number_id` AS 'rfiresponses_fk_rfi__rfi_initiator_contact_mobile_phone_number_id',
	rfiresponses_fk_rfi.`rfi_title` AS 'rfiresponses_fk_rfi__rfi_title',
	rfiresponses_fk_rfi.`rfi_plan_page_reference` AS 'rfiresponses_fk_rfi__rfi_plan_page_reference',
	rfiresponses_fk_rfi.`rfi_statement` AS 'rfiresponses_fk_rfi__rfi_statement',
	rfiresponses_fk_rfi.`created` AS 'rfiresponses_fk_rfi__created',
	rfiresponses_fk_rfi.`rfi_due_date` AS 'rfiresponses_fk_rfi__rfi_due_date',
	rfiresponses_fk_rfi.`rfi_closed_date` AS 'rfiresponses_fk_rfi__rfi_closed_date',

	rfiresponses_fk_rfirt.`id` AS 'rfiresponses_fk_rfirt__request_for_information_response_type_id',
	rfiresponses_fk_rfirt.`request_for_information_response_type` AS 'rfiresponses_fk_rfirt__request_for_information_response_type',
	rfiresponses_fk_rfirt.`disabled_flag` AS 'rfiresponses_fk_rfirt__disabled_flag',

	rfiresponses_fk_responder_c.`id` AS 'rfiresponses_fk_responder_c__contact_id',
	rfiresponses_fk_responder_c.`user_company_id` AS 'rfiresponses_fk_responder_c__user_company_id',
	rfiresponses_fk_responder_c.`user_id` AS 'rfiresponses_fk_responder_c__user_id',
	rfiresponses_fk_responder_c.`contact_company_id` AS 'rfiresponses_fk_responder_c__contact_company_id',
	rfiresponses_fk_responder_c.`email` AS 'rfiresponses_fk_responder_c__email',
	rfiresponses_fk_responder_c.`name_prefix` AS 'rfiresponses_fk_responder_c__name_prefix',
	rfiresponses_fk_responder_c.`first_name` AS 'rfiresponses_fk_responder_c__first_name',
	rfiresponses_fk_responder_c.`additional_name` AS 'rfiresponses_fk_responder_c__additional_name',
	rfiresponses_fk_responder_c.`middle_name` AS 'rfiresponses_fk_responder_c__middle_name',
	rfiresponses_fk_responder_c.`last_name` AS 'rfiresponses_fk_responder_c__last_name',
	rfiresponses_fk_responder_c.`name_suffix` AS 'rfiresponses_fk_responder_c__name_suffix',
	rfiresponses_fk_responder_c.`title` AS 'rfiresponses_fk_responder_c__title',
	rfiresponses_fk_responder_c.`vendor_flag` AS 'rfiresponses_fk_responder_c__vendor_flag',

	rfiresponses_fk_responder_cco.`id` AS 'rfiresponses_fk_responder_cco__contact_company_office_id',
	rfiresponses_fk_responder_cco.`contact_company_id` AS 'rfiresponses_fk_responder_cco__contact_company_id',
	rfiresponses_fk_responder_cco.`office_nickname` AS 'rfiresponses_fk_responder_cco__office_nickname',
	rfiresponses_fk_responder_cco.`address_line_1` AS 'rfiresponses_fk_responder_cco__address_line_1',
	rfiresponses_fk_responder_cco.`address_line_2` AS 'rfiresponses_fk_responder_cco__address_line_2',
	rfiresponses_fk_responder_cco.`address_line_3` AS 'rfiresponses_fk_responder_cco__address_line_3',
	rfiresponses_fk_responder_cco.`address_line_4` AS 'rfiresponses_fk_responder_cco__address_line_4',
	rfiresponses_fk_responder_cco.`address_city` AS 'rfiresponses_fk_responder_cco__address_city',
	rfiresponses_fk_responder_cco.`address_county` AS 'rfiresponses_fk_responder_cco__address_county',
	rfiresponses_fk_responder_cco.`address_state_or_region` AS 'rfiresponses_fk_responder_cco__address_state_or_region',
	rfiresponses_fk_responder_cco.`address_postal_code` AS 'rfiresponses_fk_responder_cco__address_postal_code',
	rfiresponses_fk_responder_cco.`address_postal_code_extension` AS 'rfiresponses_fk_responder_cco__address_postal_code_extension',
	rfiresponses_fk_responder_cco.`address_country` AS 'rfiresponses_fk_responder_cco__address_country',
	rfiresponses_fk_responder_cco.`head_quarters_flag` AS 'rfiresponses_fk_responder_cco__head_quarters_flag',
	rfiresponses_fk_responder_cco.`address_validated_by_user_flag` AS 'rfiresponses_fk_responder_cco__address_validated_by_user_flag',
	rfiresponses_fk_responder_cco.`address_validated_by_web_service_flag` AS 'rfiresponses_fk_responder_cco__address_validated_by_web_service_flag',
	rfiresponses_fk_responder_cco.`address_validation_by_web_service_error_flag` AS 'rfiresponses_fk_responder_cco__address_validation_by_web_service_error_flag',

	rfiresponses_fk_responder_phone_ccopn.`id` AS 'rfiresponses_fk_responder_phone_ccopn__contact_company_office_phone_number_id',
	rfiresponses_fk_responder_phone_ccopn.`contact_company_office_id` AS 'rfiresponses_fk_responder_phone_ccopn__contact_company_office_id',
	rfiresponses_fk_responder_phone_ccopn.`phone_number_type_id` AS 'rfiresponses_fk_responder_phone_ccopn__phone_number_type_id',
	rfiresponses_fk_responder_phone_ccopn.`country_code` AS 'rfiresponses_fk_responder_phone_ccopn__country_code',
	rfiresponses_fk_responder_phone_ccopn.`area_code` AS 'rfiresponses_fk_responder_phone_ccopn__area_code',
	rfiresponses_fk_responder_phone_ccopn.`prefix` AS 'rfiresponses_fk_responder_phone_ccopn__prefix',
	rfiresponses_fk_responder_phone_ccopn.`number` AS 'rfiresponses_fk_responder_phone_ccopn__number',
	rfiresponses_fk_responder_phone_ccopn.`extension` AS 'rfiresponses_fk_responder_phone_ccopn__extension',
	rfiresponses_fk_responder_phone_ccopn.`itu` AS 'rfiresponses_fk_responder_phone_ccopn__itu',

	rfiresponses_fk_responder_fax_ccopn.`id` AS 'rfiresponses_fk_responder_fax_ccopn__contact_company_office_phone_number_id',
	rfiresponses_fk_responder_fax_ccopn.`contact_company_office_id` AS 'rfiresponses_fk_responder_fax_ccopn__contact_company_office_id',
	rfiresponses_fk_responder_fax_ccopn.`phone_number_type_id` AS 'rfiresponses_fk_responder_fax_ccopn__phone_number_type_id',
	rfiresponses_fk_responder_fax_ccopn.`country_code` AS 'rfiresponses_fk_responder_fax_ccopn__country_code',
	rfiresponses_fk_responder_fax_ccopn.`area_code` AS 'rfiresponses_fk_responder_fax_ccopn__area_code',
	rfiresponses_fk_responder_fax_ccopn.`prefix` AS 'rfiresponses_fk_responder_fax_ccopn__prefix',
	rfiresponses_fk_responder_fax_ccopn.`number` AS 'rfiresponses_fk_responder_fax_ccopn__number',
	rfiresponses_fk_responder_fax_ccopn.`extension` AS 'rfiresponses_fk_responder_fax_ccopn__extension',
	rfiresponses_fk_responder_fax_ccopn.`itu` AS 'rfiresponses_fk_responder_fax_ccopn__itu',

	rfiresponses_fk_responder_c_mobile_cpn.`id` AS 'rfiresponses_fk_responder_c_mobile_cpn__contact_phone_number_id',
	rfiresponses_fk_responder_c_mobile_cpn.`contact_id` AS 'rfiresponses_fk_responder_c_mobile_cpn__contact_id',
	rfiresponses_fk_responder_c_mobile_cpn.`phone_number_type_id` AS 'rfiresponses_fk_responder_c_mobile_cpn__phone_number_type_id',
	rfiresponses_fk_responder_c_mobile_cpn.`country_code` AS 'rfiresponses_fk_responder_c_mobile_cpn__country_code',
	rfiresponses_fk_responder_c_mobile_cpn.`area_code` AS 'rfiresponses_fk_responder_c_mobile_cpn__area_code',
	rfiresponses_fk_responder_c_mobile_cpn.`prefix` AS 'rfiresponses_fk_responder_c_mobile_cpn__prefix',
	rfiresponses_fk_responder_c_mobile_cpn.`number` AS 'rfiresponses_fk_responder_c_mobile_cpn__number',
	rfiresponses_fk_responder_c_mobile_cpn.`extension` AS 'rfiresponses_fk_responder_c_mobile_cpn__extension',
	rfiresponses_fk_responder_c_mobile_cpn.`itu` AS 'rfiresponses_fk_responder_c_mobile_cpn__itu',

	rfiresponses.*

FROM `request_for_information_responses` rfiresponses
	INNER JOIN `requests_for_information` rfiresponses_fk_rfi ON rfiresponses.`request_for_information_id` = rfiresponses_fk_rfi.`id`
	INNER JOIN `request_for_information_response_types` rfiresponses_fk_rfirt ON rfiresponses.`request_for_information_response_type_id` = rfiresponses_fk_rfirt.`id`
	INNER JOIN `contacts` rfiresponses_fk_responder_c ON rfiresponses.`rfi_responder_contact_id` = rfiresponses_fk_responder_c.`id`
	LEFT OUTER JOIN `contact_company_offices` rfiresponses_fk_responder_cco ON rfiresponses.`rfi_responder_contact_company_office_id` = rfiresponses_fk_responder_cco.`id`
	LEFT OUTER JOIN `contact_company_office_phone_numbers` rfiresponses_fk_responder_phone_ccopn ON rfiresponses.`rfi_responder_phone_contact_company_office_phone_number_id` = rfiresponses_fk_responder_phone_ccopn.`id`
	LEFT OUTER JOIN `contact_company_office_phone_numbers` rfiresponses_fk_responder_fax_ccopn ON rfiresponses.`rfi_responder_fax_contact_company_office_phone_number_id` = rfiresponses_fk_responder_fax_ccopn.`id`
	LEFT OUTER JOIN `contact_phone_numbers` rfiresponses_fk_responder_c_mobile_cpn ON rfiresponses.`rfi_responder_contact_mobile_phone_number_id` = rfiresponses_fk_responder_c_mobile_cpn.`id`
WHERE rfiresponses.`id` = ?
";
		$arrValues = array($request_for_information_response_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$request_for_information_response_id = $row['id'];
			$requestForInformationResponse = self::instantiateOrm($database, 'RequestForInformationResponse', $row, null, $request_for_information_response_id);
			/* @var $requestForInformationResponse RequestForInformationResponse */
			$requestForInformationResponse->convertPropertiesToData();

			if (isset($row['request_for_information_id'])) {
				$request_for_information_id = $row['request_for_information_id'];
				$row['rfiresponses_fk_rfi__id'] = $request_for_information_id;
				$requestForInformation = self::instantiateOrm($database, 'RequestForInformation', $row, null, $request_for_information_id, 'rfiresponses_fk_rfi__');
				/* @var $requestForInformation RequestForInformation */
				$requestForInformation->convertPropertiesToData();
			} else {
				$requestForInformation = false;
			}
			$requestForInformationResponse->setRequestForInformation($requestForInformation);

			if (isset($row['request_for_information_response_type_id'])) {
				$request_for_information_response_type_id = $row['request_for_information_response_type_id'];
				$row['rfiresponses_fk_rfirt__id'] = $request_for_information_response_type_id;
				$requestForInformationResponseType = self::instantiateOrm($database, 'RequestForInformationResponseType', $row, null, $request_for_information_response_type_id, 'rfiresponses_fk_rfirt__');
				/* @var $requestForInformationResponseType RequestForInformationResponseType */
				$requestForInformationResponseType->convertPropertiesToData();
			} else {
				$requestForInformationResponseType = false;
			}
			$requestForInformationResponse->setRequestForInformationResponseType($requestForInformationResponseType);

			if (isset($row['rfi_responder_contact_id'])) {
				$rfi_responder_contact_id = $row['rfi_responder_contact_id'];
				$row['rfiresponses_fk_responder_c__id'] = $rfi_responder_contact_id;
				$rfiResponderContact = self::instantiateOrm($database, 'Contact', $row, null, $rfi_responder_contact_id, 'rfiresponses_fk_responder_c__');
				/* @var $rfiResponderContact Contact */
				$rfiResponderContact->convertPropertiesToData();
			} else {
				$rfiResponderContact = false;
			}
			$requestForInformationResponse->setRfiResponderContact($rfiResponderContact);

			if (isset($row['rfi_responder_contact_company_office_id'])) {
				$rfi_responder_contact_company_office_id = $row['rfi_responder_contact_company_office_id'];
				$row['rfiresponses_fk_responder_cco__id'] = $rfi_responder_contact_company_office_id;
				$rfiResponderContactCompanyOffice = self::instantiateOrm($database, 'ContactCompanyOffice', $row, null, $rfi_responder_contact_company_office_id, 'rfiresponses_fk_responder_cco__');
				/* @var $rfiResponderContactCompanyOffice ContactCompanyOffice */
				$rfiResponderContactCompanyOffice->convertPropertiesToData();
			} else {
				$rfiResponderContactCompanyOffice = false;
			}
			$requestForInformationResponse->setRfiResponderContactCompanyOffice($rfiResponderContactCompanyOffice);

			if (isset($row['rfi_responder_phone_contact_company_office_phone_number_id'])) {
				$rfi_responder_phone_contact_company_office_phone_number_id = $row['rfi_responder_phone_contact_company_office_phone_number_id'];
				$row['rfiresponses_fk_responder_phone_ccopn__id'] = $rfi_responder_phone_contact_company_office_phone_number_id;
				$rfiResponderPhoneContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $rfi_responder_phone_contact_company_office_phone_number_id, 'rfiresponses_fk_responder_phone_ccopn__');
				/* @var $rfiResponderPhoneContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$rfiResponderPhoneContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$rfiResponderPhoneContactCompanyOfficePhoneNumber = false;
			}
			$requestForInformationResponse->setRfiResponderPhoneContactCompanyOfficePhoneNumber($rfiResponderPhoneContactCompanyOfficePhoneNumber);

			if (isset($row['rfi_responder_fax_contact_company_office_phone_number_id'])) {
				$rfi_responder_fax_contact_company_office_phone_number_id = $row['rfi_responder_fax_contact_company_office_phone_number_id'];
				$row['rfiresponses_fk_responder_fax_ccopn__id'] = $rfi_responder_fax_contact_company_office_phone_number_id;
				$rfiResponderFaxContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $rfi_responder_fax_contact_company_office_phone_number_id, 'rfiresponses_fk_responder_fax_ccopn__');
				/* @var $rfiResponderFaxContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$rfiResponderFaxContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$rfiResponderFaxContactCompanyOfficePhoneNumber = false;
			}
			$requestForInformationResponse->setRfiResponderFaxContactCompanyOfficePhoneNumber($rfiResponderFaxContactCompanyOfficePhoneNumber);

			if (isset($row['rfi_responder_contact_mobile_phone_number_id'])) {
				$rfi_responder_contact_mobile_phone_number_id = $row['rfi_responder_contact_mobile_phone_number_id'];
				$row['rfiresponses_fk_responder_c_mobile_cpn__id'] = $rfi_responder_contact_mobile_phone_number_id;
				$rfiResponderContactMobilePhoneNumber = self::instantiateOrm($database, 'ContactPhoneNumber', $row, null, $rfi_responder_contact_mobile_phone_number_id, 'rfiresponses_fk_responder_c_mobile_cpn__');
				/* @var $rfiResponderContactMobilePhoneNumber ContactPhoneNumber */
				$rfiResponderContactMobilePhoneNumber->convertPropertiesToData();
			} else {
				$rfiResponderContactMobilePhoneNumber = false;
			}
			$requestForInformationResponse->setRfiResponderContactMobilePhoneNumber($rfiResponderContactMobilePhoneNumber);

			return $requestForInformationResponse;
		} else {
			return false;
		}
	}

	// Finders: Find By Unique Index
	/**
	 * Find by unique index `unique_request_for_information_response` (`request_for_information_id`,`request_for_information_response_sequence_number`) comment 'One RFI can have many Responses'.
	 *
	 * @param string $database
	 * @param int $request_for_information_id
	 * @param int $request_for_information_response_sequence_number
	 * @return mixed (single ORM object | false)
	 */
	public static function findByRequestForInformationIdAndRequestForInformationResponseSequenceNumber($database, $request_for_information_id, $request_for_information_response_sequence_number)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	rfiresponses.*

FROM `request_for_information_responses` rfiresponses
WHERE rfiresponses.`request_for_information_id` = ?
AND rfiresponses.`request_for_information_response_sequence_number` = ?
";
		$arrValues = array($request_for_information_id, $request_for_information_response_sequence_number);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if ($row && !empty($row)) {
			$request_for_information_response_id = $row['id'];
			$requestForInformationResponse = self::instantiateOrm($database, 'RequestForInformationResponse', $row, null, $request_for_information_response_id);
			/* @var $requestForInformationResponse RequestForInformationResponse */
			return $requestForInformationResponse;
		} else {
			return false;
		}
	}

	// Loaders: Load By pk List (list of auto int ids or other non auto int pk list)
	/**
	 * Load zero or more records by an id list (array of auto int primary keys).
	 *
	 * @param string $database
	 * @param array $arrRequestForInformationResponseIds
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadRequestForInformationResponsesByArrRequestForInformationResponseIds($database, $arrRequestForInformationResponseIds, Input $options=null)
	{
		if (empty($arrRequestForInformationResponseIds)) {
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
		// ORDER BY `id` ASC, `request_for_information_id` ASC, `request_for_information_response_sequence_number` ASC, `request_for_information_response_type_id` ASC, `rfi_responder_contact_id` ASC, `rfi_responder_contact_company_office_id` ASC, `rfi_responder_phone_contact_company_office_phone_number_id` ASC, `rfi_responder_fax_contact_company_office_phone_number_id` ASC, `rfi_responder_contact_mobile_phone_number_id` ASC, `request_for_information_response_title` ASC, `request_for_information_response` ASC, `modified` ASC, `created` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpRequestForInformationResponse = new RequestForInformationResponse($database);
			$sqlOrderByColumns = $tmpRequestForInformationResponse->constructSqlOrderByColumns($arrOrderByAttributes);

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

		foreach ($arrRequestForInformationResponseIds as $k => $request_for_information_response_id) {
			$request_for_information_response_id = (int) $request_for_information_response_id;
			$arrRequestForInformationResponseIds[$k] = $db->escape($request_for_information_response_id);
		}
		$csvRequestForInformationResponseIds = join(',', $arrRequestForInformationResponseIds);

		$query =
"
SELECT

	rfiresponses.*

FROM `request_for_information_responses` rfiresponses
WHERE rfiresponses.`id` IN ($csvRequestForInformationResponseIds){$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		$arrRequestForInformationResponsesByCsvRequestForInformationResponseIds = array();
		while ($row = $db->fetch()) {
			$request_for_information_response_id = $row['id'];
			$requestForInformationResponse = self::instantiateOrm($database, 'RequestForInformationResponse', $row, null, $request_for_information_response_id);
			/* @var $requestForInformationResponse RequestForInformationResponse */
			$requestForInformationResponse->convertPropertiesToData();

			$arrRequestForInformationResponsesByCsvRequestForInformationResponseIds[$request_for_information_response_id] = $requestForInformationResponse;
		}

		$db->free_result();

		return $arrRequestForInformationResponsesByCsvRequestForInformationResponseIds;
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `request_for_information_responses_fk_rfi` foreign key (`request_for_information_id`) references `requests_for_information` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $request_for_information_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadRequestForInformationResponsesByRequestForInformationId($database, $request_for_information_id, Input $options=null)
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
			self::$_arrRequestForInformationResponsesByRequestForInformationId = null;
		}

		$arrRequestForInformationResponsesByRequestForInformationId = self::$_arrRequestForInformationResponsesByRequestForInformationId;
		if (isset($arrRequestForInformationResponsesByRequestForInformationId) && !empty($arrRequestForInformationResponsesByRequestForInformationId)) {
			return $arrRequestForInformationResponsesByRequestForInformationId;
		}

		$request_for_information_id = (int) $request_for_information_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `request_for_information_id` ASC, `request_for_information_response_sequence_number` ASC, `request_for_information_response_type_id` ASC, `rfi_responder_contact_id` ASC, `rfi_responder_contact_company_office_id` ASC, `rfi_responder_phone_contact_company_office_phone_number_id` ASC, `rfi_responder_fax_contact_company_office_phone_number_id` ASC, `rfi_responder_contact_mobile_phone_number_id` ASC, `request_for_information_response_title` ASC, `request_for_information_response` ASC, `modified` ASC, `created` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpRequestForInformationResponse = new RequestForInformationResponse($database);
			$sqlOrderByColumns = $tmpRequestForInformationResponse->constructSqlOrderByColumns($arrOrderByAttributes);

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

	rfiresponses_fk_rfi.`id` AS 'rfiresponses_fk_rfi__request_for_information_id',
	rfiresponses_fk_rfi.`project_id` AS 'rfiresponses_fk_rfi__project_id',
	rfiresponses_fk_rfi.`rfi_sequence_number` AS 'rfiresponses_fk_rfi__rfi_sequence_number',
	rfiresponses_fk_rfi.`request_for_information_type_id` AS 'rfiresponses_fk_rfi__request_for_information_type_id',
	rfiresponses_fk_rfi.`request_for_information_status_id` AS 'rfiresponses_fk_rfi__request_for_information_status_id',
	rfiresponses_fk_rfi.`request_for_information_priority_id` AS 'rfiresponses_fk_rfi__request_for_information_priority_id',
	rfiresponses_fk_rfi.`rfi_file_manager_file_id` AS 'rfiresponses_fk_rfi__rfi_file_manager_file_id',
	rfiresponses_fk_rfi.`rfi_cost_code_id` AS 'rfiresponses_fk_rfi__rfi_cost_code_id',
	rfiresponses_fk_rfi.`rfi_creator_contact_id` AS 'rfiresponses_fk_rfi__rfi_creator_contact_id',
	rfiresponses_fk_rfi.`rfi_creator_contact_company_office_id` AS 'rfiresponses_fk_rfi__rfi_creator_contact_company_office_id',
	rfiresponses_fk_rfi.`rfi_creator_phone_contact_company_office_phone_number_id` AS 'rfiresponses_fk_rfi__rfi_creator_phone_contact_company_office_phone_number_id',
	rfiresponses_fk_rfi.`rfi_creator_fax_contact_company_office_phone_number_id` AS 'rfiresponses_fk_rfi__rfi_creator_fax_contact_company_office_phone_number_id',
	rfiresponses_fk_rfi.`rfi_creator_contact_mobile_phone_number_id` AS 'rfiresponses_fk_rfi__rfi_creator_contact_mobile_phone_number_id',
	rfiresponses_fk_rfi.`rfi_recipient_contact_id` AS 'rfiresponses_fk_rfi__rfi_recipient_contact_id',
	rfiresponses_fk_rfi.`rfi_recipient_contact_company_office_id` AS 'rfiresponses_fk_rfi__rfi_recipient_contact_company_office_id',
	rfiresponses_fk_rfi.`rfi_recipient_phone_contact_company_office_phone_number_id` AS 'rfiresponses_fk_rfi__rfi_recipient_phone_contact_company_office_phone_number_id',
	rfiresponses_fk_rfi.`rfi_recipient_fax_contact_company_office_phone_number_id` AS 'rfiresponses_fk_rfi__rfi_recipient_fax_contact_company_office_phone_number_id',
	rfiresponses_fk_rfi.`rfi_recipient_contact_mobile_phone_number_id` AS 'rfiresponses_fk_rfi__rfi_recipient_contact_mobile_phone_number_id',
	rfiresponses_fk_rfi.`rfi_initiator_contact_id` AS 'rfiresponses_fk_rfi__rfi_initiator_contact_id',
	rfiresponses_fk_rfi.`rfi_initiator_contact_company_office_id` AS 'rfiresponses_fk_rfi__rfi_initiator_contact_company_office_id',
	rfiresponses_fk_rfi.`rfi_initiator_phone_contact_company_office_phone_number_id` AS 'rfiresponses_fk_rfi__rfi_initiator_phone_contact_company_office_phone_number_id',
	rfiresponses_fk_rfi.`rfi_initiator_fax_contact_company_office_phone_number_id` AS 'rfiresponses_fk_rfi__rfi_initiator_fax_contact_company_office_phone_number_id',
	rfiresponses_fk_rfi.`rfi_initiator_contact_mobile_phone_number_id` AS 'rfiresponses_fk_rfi__rfi_initiator_contact_mobile_phone_number_id',
	rfiresponses_fk_rfi.`rfi_title` AS 'rfiresponses_fk_rfi__rfi_title',
	rfiresponses_fk_rfi.`rfi_plan_page_reference` AS 'rfiresponses_fk_rfi__rfi_plan_page_reference',
	rfiresponses_fk_rfi.`rfi_statement` AS 'rfiresponses_fk_rfi__rfi_statement',
	rfiresponses_fk_rfi.`created` AS 'rfiresponses_fk_rfi__created',
	rfiresponses_fk_rfi.`rfi_due_date` AS 'rfiresponses_fk_rfi__rfi_due_date',
	rfiresponses_fk_rfi.`rfi_closed_date` AS 'rfiresponses_fk_rfi__rfi_closed_date',

	rfiresponses_fk_rfirt.`id` AS 'rfiresponses_fk_rfirt__request_for_information_response_type_id',
	rfiresponses_fk_rfirt.`request_for_information_response_type` AS 'rfiresponses_fk_rfirt__request_for_information_response_type',
	rfiresponses_fk_rfirt.`disabled_flag` AS 'rfiresponses_fk_rfirt__disabled_flag',

	rfiresponses_fk_responder_c.`id` AS 'rfiresponses_fk_responder_c__contact_id',
	rfiresponses_fk_responder_c.`user_company_id` AS 'rfiresponses_fk_responder_c__user_company_id',
	rfiresponses_fk_responder_c.`user_id` AS 'rfiresponses_fk_responder_c__user_id',
	rfiresponses_fk_responder_c.`contact_company_id` AS 'rfiresponses_fk_responder_c__contact_company_id',
	rfiresponses_fk_responder_c.`email` AS 'rfiresponses_fk_responder_c__email',
	rfiresponses_fk_responder_c.`name_prefix` AS 'rfiresponses_fk_responder_c__name_prefix',
	rfiresponses_fk_responder_c.`first_name` AS 'rfiresponses_fk_responder_c__first_name',
	rfiresponses_fk_responder_c.`additional_name` AS 'rfiresponses_fk_responder_c__additional_name',
	rfiresponses_fk_responder_c.`middle_name` AS 'rfiresponses_fk_responder_c__middle_name',
	rfiresponses_fk_responder_c.`last_name` AS 'rfiresponses_fk_responder_c__last_name',
	rfiresponses_fk_responder_c.`name_suffix` AS 'rfiresponses_fk_responder_c__name_suffix',
	rfiresponses_fk_responder_c.`title` AS 'rfiresponses_fk_responder_c__title',
	rfiresponses_fk_responder_c.`vendor_flag` AS 'rfiresponses_fk_responder_c__vendor_flag',
	rfiresponses_fk_responder_c.`is_archive` AS 'rfiresponses_fk_responder_c__is_archive',

	rfiresponses_fk_responder_cco.`id` AS 'rfiresponses_fk_responder_cco__contact_company_office_id',
	rfiresponses_fk_responder_cco.`contact_company_id` AS 'rfiresponses_fk_responder_cco__contact_company_id',
	rfiresponses_fk_responder_cco.`office_nickname` AS 'rfiresponses_fk_responder_cco__office_nickname',
	rfiresponses_fk_responder_cco.`address_line_1` AS 'rfiresponses_fk_responder_cco__address_line_1',
	rfiresponses_fk_responder_cco.`address_line_2` AS 'rfiresponses_fk_responder_cco__address_line_2',
	rfiresponses_fk_responder_cco.`address_line_3` AS 'rfiresponses_fk_responder_cco__address_line_3',
	rfiresponses_fk_responder_cco.`address_line_4` AS 'rfiresponses_fk_responder_cco__address_line_4',
	rfiresponses_fk_responder_cco.`address_city` AS 'rfiresponses_fk_responder_cco__address_city',
	rfiresponses_fk_responder_cco.`address_county` AS 'rfiresponses_fk_responder_cco__address_county',
	rfiresponses_fk_responder_cco.`address_state_or_region` AS 'rfiresponses_fk_responder_cco__address_state_or_region',
	rfiresponses_fk_responder_cco.`address_postal_code` AS 'rfiresponses_fk_responder_cco__address_postal_code',
	rfiresponses_fk_responder_cco.`address_postal_code_extension` AS 'rfiresponses_fk_responder_cco__address_postal_code_extension',
	rfiresponses_fk_responder_cco.`address_country` AS 'rfiresponses_fk_responder_cco__address_country',
	rfiresponses_fk_responder_cco.`head_quarters_flag` AS 'rfiresponses_fk_responder_cco__head_quarters_flag',
	rfiresponses_fk_responder_cco.`address_validated_by_user_flag` AS 'rfiresponses_fk_responder_cco__address_validated_by_user_flag',
	rfiresponses_fk_responder_cco.`address_validated_by_web_service_flag` AS 'rfiresponses_fk_responder_cco__address_validated_by_web_service_flag',
	rfiresponses_fk_responder_cco.`address_validation_by_web_service_error_flag` AS 'rfiresponses_fk_responder_cco__address_validation_by_web_service_error_flag',

	rfiresponses_fk_responder_phone_ccopn.`id` AS 'rfiresponses_fk_responder_phone_ccopn__contact_company_office_phone_number_id',
	rfiresponses_fk_responder_phone_ccopn.`contact_company_office_id` AS 'rfiresponses_fk_responder_phone_ccopn__contact_company_office_id',
	rfiresponses_fk_responder_phone_ccopn.`phone_number_type_id` AS 'rfiresponses_fk_responder_phone_ccopn__phone_number_type_id',
	rfiresponses_fk_responder_phone_ccopn.`country_code` AS 'rfiresponses_fk_responder_phone_ccopn__country_code',
	rfiresponses_fk_responder_phone_ccopn.`area_code` AS 'rfiresponses_fk_responder_phone_ccopn__area_code',
	rfiresponses_fk_responder_phone_ccopn.`prefix` AS 'rfiresponses_fk_responder_phone_ccopn__prefix',
	rfiresponses_fk_responder_phone_ccopn.`number` AS 'rfiresponses_fk_responder_phone_ccopn__number',
	rfiresponses_fk_responder_phone_ccopn.`extension` AS 'rfiresponses_fk_responder_phone_ccopn__extension',
	rfiresponses_fk_responder_phone_ccopn.`itu` AS 'rfiresponses_fk_responder_phone_ccopn__itu',

	rfiresponses_fk_responder_fax_ccopn.`id` AS 'rfiresponses_fk_responder_fax_ccopn__contact_company_office_phone_number_id',
	rfiresponses_fk_responder_fax_ccopn.`contact_company_office_id` AS 'rfiresponses_fk_responder_fax_ccopn__contact_company_office_id',
	rfiresponses_fk_responder_fax_ccopn.`phone_number_type_id` AS 'rfiresponses_fk_responder_fax_ccopn__phone_number_type_id',
	rfiresponses_fk_responder_fax_ccopn.`country_code` AS 'rfiresponses_fk_responder_fax_ccopn__country_code',
	rfiresponses_fk_responder_fax_ccopn.`area_code` AS 'rfiresponses_fk_responder_fax_ccopn__area_code',
	rfiresponses_fk_responder_fax_ccopn.`prefix` AS 'rfiresponses_fk_responder_fax_ccopn__prefix',
	rfiresponses_fk_responder_fax_ccopn.`number` AS 'rfiresponses_fk_responder_fax_ccopn__number',
	rfiresponses_fk_responder_fax_ccopn.`extension` AS 'rfiresponses_fk_responder_fax_ccopn__extension',
	rfiresponses_fk_responder_fax_ccopn.`itu` AS 'rfiresponses_fk_responder_fax_ccopn__itu',

	rfiresponses_fk_responder_c_mobile_cpn.`id` AS 'rfiresponses_fk_responder_c_mobile_cpn__contact_phone_number_id',
	rfiresponses_fk_responder_c_mobile_cpn.`contact_id` AS 'rfiresponses_fk_responder_c_mobile_cpn__contact_id',
	rfiresponses_fk_responder_c_mobile_cpn.`phone_number_type_id` AS 'rfiresponses_fk_responder_c_mobile_cpn__phone_number_type_id',
	rfiresponses_fk_responder_c_mobile_cpn.`country_code` AS 'rfiresponses_fk_responder_c_mobile_cpn__country_code',
	rfiresponses_fk_responder_c_mobile_cpn.`area_code` AS 'rfiresponses_fk_responder_c_mobile_cpn__area_code',
	rfiresponses_fk_responder_c_mobile_cpn.`prefix` AS 'rfiresponses_fk_responder_c_mobile_cpn__prefix',
	rfiresponses_fk_responder_c_mobile_cpn.`number` AS 'rfiresponses_fk_responder_c_mobile_cpn__number',
	rfiresponses_fk_responder_c_mobile_cpn.`extension` AS 'rfiresponses_fk_responder_c_mobile_cpn__extension',
	rfiresponses_fk_responder_c_mobile_cpn.`itu` AS 'rfiresponses_fk_responder_c_mobile_cpn__itu',

	rfiresponses.*

FROM `request_for_information_responses` rfiresponses
	INNER JOIN `requests_for_information` rfiresponses_fk_rfi ON rfiresponses.`request_for_information_id` = rfiresponses_fk_rfi.`id`
	INNER JOIN `request_for_information_response_types` rfiresponses_fk_rfirt ON rfiresponses.`request_for_information_response_type_id` = rfiresponses_fk_rfirt.`id`
	INNER JOIN `contacts` rfiresponses_fk_responder_c ON rfiresponses.`rfi_responder_contact_id` = rfiresponses_fk_responder_c.`id`
	LEFT OUTER JOIN `contact_company_offices` rfiresponses_fk_responder_cco ON rfiresponses.`rfi_responder_contact_company_office_id` = rfiresponses_fk_responder_cco.`id`
	LEFT OUTER JOIN `contact_company_office_phone_numbers` rfiresponses_fk_responder_phone_ccopn ON rfiresponses.`rfi_responder_phone_contact_company_office_phone_number_id` = rfiresponses_fk_responder_phone_ccopn.`id`
	LEFT OUTER JOIN `contact_company_office_phone_numbers` rfiresponses_fk_responder_fax_ccopn ON rfiresponses.`rfi_responder_fax_contact_company_office_phone_number_id` = rfiresponses_fk_responder_fax_ccopn.`id`
	LEFT OUTER JOIN `contact_phone_numbers` rfiresponses_fk_responder_c_mobile_cpn ON rfiresponses.`rfi_responder_contact_mobile_phone_number_id` = rfiresponses_fk_responder_c_mobile_cpn.`id`
WHERE rfiresponses.`request_for_information_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `request_for_information_id` ASC, `request_for_information_response_sequence_number` ASC, `request_for_information_response_type_id` ASC, `rfi_responder_contact_id` ASC, `rfi_responder_contact_company_office_id` ASC, `rfi_responder_phone_contact_company_office_phone_number_id` ASC, `rfi_responder_fax_contact_company_office_phone_number_id` ASC, `rfi_responder_contact_mobile_phone_number_id` ASC, `request_for_information_response_title` ASC, `request_for_information_response` ASC, `modified` ASC, `created` ASC
		$arrValues = array($request_for_information_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrRequestForInformationResponsesByRequestForInformationId = array();
		while ($row = $db->fetch()) {
			$request_for_information_response_id = $row['id'];
			$requestForInformationResponse = self::instantiateOrm($database, 'RequestForInformationResponse', $row, null, $request_for_information_response_id);
			/* @var $requestForInformationResponse RequestForInformationResponse */
			$requestForInformationResponse->convertPropertiesToData();

			if (isset($row['request_for_information_id'])) {
				$request_for_information_id = $row['request_for_information_id'];
				$row['rfiresponses_fk_rfi__id'] = $request_for_information_id;
				$requestForInformation = self::instantiateOrm($database, 'RequestForInformation', $row, null, $request_for_information_id, 'rfiresponses_fk_rfi__');
				/* @var $requestForInformation RequestForInformation */
				$requestForInformation->convertPropertiesToData();
			} else {
				$requestForInformation = false;
			}
			$requestForInformationResponse->setRequestForInformation($requestForInformation);

			if (isset($row['request_for_information_response_type_id'])) {
				$request_for_information_response_type_id = $row['request_for_information_response_type_id'];
				$row['rfiresponses_fk_rfirt__id'] = $request_for_information_response_type_id;
				$requestForInformationResponseType = self::instantiateOrm($database, 'RequestForInformationResponseType', $row, null, $request_for_information_response_type_id, 'rfiresponses_fk_rfirt__');
				/* @var $requestForInformationResponseType RequestForInformationResponseType */
				$requestForInformationResponseType->convertPropertiesToData();
			} else {
				$requestForInformationResponseType = false;
			}
			$requestForInformationResponse->setRequestForInformationResponseType($requestForInformationResponseType);

			if (isset($row['rfi_responder_contact_id'])) {
				$rfi_responder_contact_id = $row['rfi_responder_contact_id'];
				$row['rfiresponses_fk_responder_c__id'] = $rfi_responder_contact_id;
				$rfiResponderContact = self::instantiateOrm($database, 'Contact', $row, null, $rfi_responder_contact_id, 'rfiresponses_fk_responder_c__');
				/* @var $rfiResponderContact Contact */
				$rfiResponderContact->convertPropertiesToData();
			} else {
				$rfiResponderContact = false;
			}
			$requestForInformationResponse->setRfiResponderContact($rfiResponderContact);

			if (isset($row['rfi_responder_contact_company_office_id'])) {
				$rfi_responder_contact_company_office_id = $row['rfi_responder_contact_company_office_id'];
				$row['rfiresponses_fk_responder_cco__id'] = $rfi_responder_contact_company_office_id;
				$rfiResponderContactCompanyOffice = self::instantiateOrm($database, 'ContactCompanyOffice', $row, null, $rfi_responder_contact_company_office_id, 'rfiresponses_fk_responder_cco__');
				/* @var $rfiResponderContactCompanyOffice ContactCompanyOffice */
				$rfiResponderContactCompanyOffice->convertPropertiesToData();
			} else {
				$rfiResponderContactCompanyOffice = false;
			}
			$requestForInformationResponse->setRfiResponderContactCompanyOffice($rfiResponderContactCompanyOffice);

			if (isset($row['rfi_responder_phone_contact_company_office_phone_number_id'])) {
				$rfi_responder_phone_contact_company_office_phone_number_id = $row['rfi_responder_phone_contact_company_office_phone_number_id'];
				$row['rfiresponses_fk_responder_phone_ccopn__id'] = $rfi_responder_phone_contact_company_office_phone_number_id;
				$rfiResponderPhoneContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $rfi_responder_phone_contact_company_office_phone_number_id, 'rfiresponses_fk_responder_phone_ccopn__');
				/* @var $rfiResponderPhoneContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$rfiResponderPhoneContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$rfiResponderPhoneContactCompanyOfficePhoneNumber = false;
			}
			$requestForInformationResponse->setRfiResponderPhoneContactCompanyOfficePhoneNumber($rfiResponderPhoneContactCompanyOfficePhoneNumber);

			if (isset($row['rfi_responder_fax_contact_company_office_phone_number_id'])) {
				$rfi_responder_fax_contact_company_office_phone_number_id = $row['rfi_responder_fax_contact_company_office_phone_number_id'];
				$row['rfiresponses_fk_responder_fax_ccopn__id'] = $rfi_responder_fax_contact_company_office_phone_number_id;
				$rfiResponderFaxContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $rfi_responder_fax_contact_company_office_phone_number_id, 'rfiresponses_fk_responder_fax_ccopn__');
				/* @var $rfiResponderFaxContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$rfiResponderFaxContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$rfiResponderFaxContactCompanyOfficePhoneNumber = false;
			}
			$requestForInformationResponse->setRfiResponderFaxContactCompanyOfficePhoneNumber($rfiResponderFaxContactCompanyOfficePhoneNumber);

			if (isset($row['rfi_responder_contact_mobile_phone_number_id'])) {
				$rfi_responder_contact_mobile_phone_number_id = $row['rfi_responder_contact_mobile_phone_number_id'];
				$row['rfiresponses_fk_responder_c_mobile_cpn__id'] = $rfi_responder_contact_mobile_phone_number_id;
				$rfiResponderContactMobilePhoneNumber = self::instantiateOrm($database, 'ContactPhoneNumber', $row, null, $rfi_responder_contact_mobile_phone_number_id, 'rfiresponses_fk_responder_c_mobile_cpn__');
				/* @var $rfiResponderContactMobilePhoneNumber ContactPhoneNumber */
				$rfiResponderContactMobilePhoneNumber->convertPropertiesToData();
			} else {
				$rfiResponderContactMobilePhoneNumber = false;
			}
			$requestForInformationResponse->setRfiResponderContactMobilePhoneNumber($rfiResponderContactMobilePhoneNumber);

			$arrRequestForInformationResponsesByRequestForInformationId[$request_for_information_response_id] = $requestForInformationResponse;
		}

		$db->free_result();

		self::$_arrRequestForInformationResponsesByRequestForInformationId = $arrRequestForInformationResponsesByRequestForInformationId;

		return $arrRequestForInformationResponsesByRequestForInformationId;
	}

	/**
	 * Load by constraint `request_for_information_responses_fk_rfirt` foreign key (`request_for_information_response_type_id`) references `request_for_information_response_types` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $request_for_information_response_type_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadRequestForInformationResponsesByRequestForInformationResponseTypeId($database, $request_for_information_response_type_id, Input $options=null)
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
			self::$_arrRequestForInformationResponsesByRequestForInformationResponseTypeId = null;
		}

		$arrRequestForInformationResponsesByRequestForInformationResponseTypeId = self::$_arrRequestForInformationResponsesByRequestForInformationResponseTypeId;
		if (isset($arrRequestForInformationResponsesByRequestForInformationResponseTypeId) && !empty($arrRequestForInformationResponsesByRequestForInformationResponseTypeId)) {
			return $arrRequestForInformationResponsesByRequestForInformationResponseTypeId;
		}

		$request_for_information_response_type_id = (int) $request_for_information_response_type_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `request_for_information_id` ASC, `request_for_information_response_sequence_number` ASC, `request_for_information_response_type_id` ASC, `rfi_responder_contact_id` ASC, `rfi_responder_contact_company_office_id` ASC, `rfi_responder_phone_contact_company_office_phone_number_id` ASC, `rfi_responder_fax_contact_company_office_phone_number_id` ASC, `rfi_responder_contact_mobile_phone_number_id` ASC, `request_for_information_response_title` ASC, `request_for_information_response` ASC, `modified` ASC, `created` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpRequestForInformationResponse = new RequestForInformationResponse($database);
			$sqlOrderByColumns = $tmpRequestForInformationResponse->constructSqlOrderByColumns($arrOrderByAttributes);

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
	rfiresponses.*

FROM `request_for_information_responses` rfiresponses
WHERE rfiresponses.`request_for_information_response_type_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `request_for_information_id` ASC, `request_for_information_response_sequence_number` ASC, `request_for_information_response_type_id` ASC, `rfi_responder_contact_id` ASC, `rfi_responder_contact_company_office_id` ASC, `rfi_responder_phone_contact_company_office_phone_number_id` ASC, `rfi_responder_fax_contact_company_office_phone_number_id` ASC, `rfi_responder_contact_mobile_phone_number_id` ASC, `request_for_information_response_title` ASC, `request_for_information_response` ASC, `modified` ASC, `created` ASC
		$arrValues = array($request_for_information_response_type_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrRequestForInformationResponsesByRequestForInformationResponseTypeId = array();
		while ($row = $db->fetch()) {
			$request_for_information_response_id = $row['id'];
			$requestForInformationResponse = self::instantiateOrm($database, 'RequestForInformationResponse', $row, null, $request_for_information_response_id);
			/* @var $requestForInformationResponse RequestForInformationResponse */
			$arrRequestForInformationResponsesByRequestForInformationResponseTypeId[$request_for_information_response_id] = $requestForInformationResponse;
		}

		$db->free_result();

		self::$_arrRequestForInformationResponsesByRequestForInformationResponseTypeId = $arrRequestForInformationResponsesByRequestForInformationResponseTypeId;

		return $arrRequestForInformationResponsesByRequestForInformationResponseTypeId;
	}

	/**
	 * Load by constraint `request_for_information_responses_fk_responder_c` foreign key (`rfi_responder_contact_id`) references `contacts` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $rfi_responder_contact_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadRequestForInformationResponsesByRfiResponderContactId($database, $rfi_responder_contact_id, Input $options=null)
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
			self::$_arrRequestForInformationResponsesByRfiResponderContactId = null;
		}

		$arrRequestForInformationResponsesByRfiResponderContactId = self::$_arrRequestForInformationResponsesByRfiResponderContactId;
		if (isset($arrRequestForInformationResponsesByRfiResponderContactId) && !empty($arrRequestForInformationResponsesByRfiResponderContactId)) {
			return $arrRequestForInformationResponsesByRfiResponderContactId;
		}

		$rfi_responder_contact_id = (int) $rfi_responder_contact_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `request_for_information_id` ASC, `request_for_information_response_sequence_number` ASC, `request_for_information_response_type_id` ASC, `rfi_responder_contact_id` ASC, `rfi_responder_contact_company_office_id` ASC, `rfi_responder_phone_contact_company_office_phone_number_id` ASC, `rfi_responder_fax_contact_company_office_phone_number_id` ASC, `rfi_responder_contact_mobile_phone_number_id` ASC, `request_for_information_response_title` ASC, `request_for_information_response` ASC, `modified` ASC, `created` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpRequestForInformationResponse = new RequestForInformationResponse($database);
			$sqlOrderByColumns = $tmpRequestForInformationResponse->constructSqlOrderByColumns($arrOrderByAttributes);

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
	rfiresponses.*

FROM `request_for_information_responses` rfiresponses
WHERE rfiresponses.`rfi_responder_contact_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `request_for_information_id` ASC, `request_for_information_response_sequence_number` ASC, `request_for_information_response_type_id` ASC, `rfi_responder_contact_id` ASC, `rfi_responder_contact_company_office_id` ASC, `rfi_responder_phone_contact_company_office_phone_number_id` ASC, `rfi_responder_fax_contact_company_office_phone_number_id` ASC, `rfi_responder_contact_mobile_phone_number_id` ASC, `request_for_information_response_title` ASC, `request_for_information_response` ASC, `modified` ASC, `created` ASC
		$arrValues = array($rfi_responder_contact_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrRequestForInformationResponsesByRfiResponderContactId = array();
		while ($row = $db->fetch()) {
			$request_for_information_response_id = $row['id'];
			$requestForInformationResponse = self::instantiateOrm($database, 'RequestForInformationResponse', $row, null, $request_for_information_response_id);
			/* @var $requestForInformationResponse RequestForInformationResponse */
			$arrRequestForInformationResponsesByRfiResponderContactId[$request_for_information_response_id] = $requestForInformationResponse;
		}

		$db->free_result();

		self::$_arrRequestForInformationResponsesByRfiResponderContactId = $arrRequestForInformationResponsesByRfiResponderContactId;

		return $arrRequestForInformationResponsesByRfiResponderContactId;
	}

	/**
	 * Load by constraint `request_for_information_responses_fk_responder_cco` foreign key (`rfi_responder_contact_company_office_id`) references `contact_company_offices` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $rfi_responder_contact_company_office_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadRequestForInformationResponsesByRfiResponderContactCompanyOfficeId($database, $rfi_responder_contact_company_office_id, Input $options=null)
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
			self::$_arrRequestForInformationResponsesByRfiResponderContactCompanyOfficeId = null;
		}

		$arrRequestForInformationResponsesByRfiResponderContactCompanyOfficeId = self::$_arrRequestForInformationResponsesByRfiResponderContactCompanyOfficeId;
		if (isset($arrRequestForInformationResponsesByRfiResponderContactCompanyOfficeId) && !empty($arrRequestForInformationResponsesByRfiResponderContactCompanyOfficeId)) {
			return $arrRequestForInformationResponsesByRfiResponderContactCompanyOfficeId;
		}

		$rfi_responder_contact_company_office_id = (int) $rfi_responder_contact_company_office_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `request_for_information_id` ASC, `request_for_information_response_sequence_number` ASC, `request_for_information_response_type_id` ASC, `rfi_responder_contact_id` ASC, `rfi_responder_contact_company_office_id` ASC, `rfi_responder_phone_contact_company_office_phone_number_id` ASC, `rfi_responder_fax_contact_company_office_phone_number_id` ASC, `rfi_responder_contact_mobile_phone_number_id` ASC, `request_for_information_response_title` ASC, `request_for_information_response` ASC, `modified` ASC, `created` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpRequestForInformationResponse = new RequestForInformationResponse($database);
			$sqlOrderByColumns = $tmpRequestForInformationResponse->constructSqlOrderByColumns($arrOrderByAttributes);

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
	rfiresponses.*

FROM `request_for_information_responses` rfiresponses
WHERE rfiresponses.`rfi_responder_contact_company_office_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `request_for_information_id` ASC, `request_for_information_response_sequence_number` ASC, `request_for_information_response_type_id` ASC, `rfi_responder_contact_id` ASC, `rfi_responder_contact_company_office_id` ASC, `rfi_responder_phone_contact_company_office_phone_number_id` ASC, `rfi_responder_fax_contact_company_office_phone_number_id` ASC, `rfi_responder_contact_mobile_phone_number_id` ASC, `request_for_information_response_title` ASC, `request_for_information_response` ASC, `modified` ASC, `created` ASC
		$arrValues = array($rfi_responder_contact_company_office_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrRequestForInformationResponsesByRfiResponderContactCompanyOfficeId = array();
		while ($row = $db->fetch()) {
			$request_for_information_response_id = $row['id'];
			$requestForInformationResponse = self::instantiateOrm($database, 'RequestForInformationResponse', $row, null, $request_for_information_response_id);
			/* @var $requestForInformationResponse RequestForInformationResponse */
			$arrRequestForInformationResponsesByRfiResponderContactCompanyOfficeId[$request_for_information_response_id] = $requestForInformationResponse;
		}

		$db->free_result();

		self::$_arrRequestForInformationResponsesByRfiResponderContactCompanyOfficeId = $arrRequestForInformationResponsesByRfiResponderContactCompanyOfficeId;

		return $arrRequestForInformationResponsesByRfiResponderContactCompanyOfficeId;
	}

	/**
	 * Load by constraint `request_for_information_responses_fk_responder_phone_ccopn` foreign key (`rfi_responder_phone_contact_company_office_phone_number_id`) references `contact_company_office_phone_numbers` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $rfi_responder_phone_contact_company_office_phone_number_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadRequestForInformationResponsesByRfiResponderPhoneContactCompanyOfficePhoneNumberId($database, $rfi_responder_phone_contact_company_office_phone_number_id, Input $options=null)
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
			self::$_arrRequestForInformationResponsesByRfiResponderPhoneContactCompanyOfficePhoneNumberId = null;
		}

		$arrRequestForInformationResponsesByRfiResponderPhoneContactCompanyOfficePhoneNumberId = self::$_arrRequestForInformationResponsesByRfiResponderPhoneContactCompanyOfficePhoneNumberId;
		if (isset($arrRequestForInformationResponsesByRfiResponderPhoneContactCompanyOfficePhoneNumberId) && !empty($arrRequestForInformationResponsesByRfiResponderPhoneContactCompanyOfficePhoneNumberId)) {
			return $arrRequestForInformationResponsesByRfiResponderPhoneContactCompanyOfficePhoneNumberId;
		}

		$rfi_responder_phone_contact_company_office_phone_number_id = (int) $rfi_responder_phone_contact_company_office_phone_number_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `request_for_information_id` ASC, `request_for_information_response_sequence_number` ASC, `request_for_information_response_type_id` ASC, `rfi_responder_contact_id` ASC, `rfi_responder_contact_company_office_id` ASC, `rfi_responder_phone_contact_company_office_phone_number_id` ASC, `rfi_responder_fax_contact_company_office_phone_number_id` ASC, `rfi_responder_contact_mobile_phone_number_id` ASC, `request_for_information_response_title` ASC, `request_for_information_response` ASC, `modified` ASC, `created` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpRequestForInformationResponse = new RequestForInformationResponse($database);
			$sqlOrderByColumns = $tmpRequestForInformationResponse->constructSqlOrderByColumns($arrOrderByAttributes);

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
	rfiresponses.*

FROM `request_for_information_responses` rfiresponses
WHERE rfiresponses.`rfi_responder_phone_contact_company_office_phone_number_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `request_for_information_id` ASC, `request_for_information_response_sequence_number` ASC, `request_for_information_response_type_id` ASC, `rfi_responder_contact_id` ASC, `rfi_responder_contact_company_office_id` ASC, `rfi_responder_phone_contact_company_office_phone_number_id` ASC, `rfi_responder_fax_contact_company_office_phone_number_id` ASC, `rfi_responder_contact_mobile_phone_number_id` ASC, `request_for_information_response_title` ASC, `request_for_information_response` ASC, `modified` ASC, `created` ASC
		$arrValues = array($rfi_responder_phone_contact_company_office_phone_number_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrRequestForInformationResponsesByRfiResponderPhoneContactCompanyOfficePhoneNumberId = array();
		while ($row = $db->fetch()) {
			$request_for_information_response_id = $row['id'];
			$requestForInformationResponse = self::instantiateOrm($database, 'RequestForInformationResponse', $row, null, $request_for_information_response_id);
			/* @var $requestForInformationResponse RequestForInformationResponse */
			$arrRequestForInformationResponsesByRfiResponderPhoneContactCompanyOfficePhoneNumberId[$request_for_information_response_id] = $requestForInformationResponse;
		}

		$db->free_result();

		self::$_arrRequestForInformationResponsesByRfiResponderPhoneContactCompanyOfficePhoneNumberId = $arrRequestForInformationResponsesByRfiResponderPhoneContactCompanyOfficePhoneNumberId;

		return $arrRequestForInformationResponsesByRfiResponderPhoneContactCompanyOfficePhoneNumberId;
	}

	/**
	 * Load by constraint `request_for_information_responses_fk_responder_fax_ccopn` foreign key (`rfi_responder_fax_contact_company_office_phone_number_id`) references `contact_company_office_phone_numbers` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $rfi_responder_fax_contact_company_office_phone_number_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadRequestForInformationResponsesByRfiResponderFaxContactCompanyOfficePhoneNumberId($database, $rfi_responder_fax_contact_company_office_phone_number_id, Input $options=null)
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
			self::$_arrRequestForInformationResponsesByRfiResponderFaxContactCompanyOfficePhoneNumberId = null;
		}

		$arrRequestForInformationResponsesByRfiResponderFaxContactCompanyOfficePhoneNumberId = self::$_arrRequestForInformationResponsesByRfiResponderFaxContactCompanyOfficePhoneNumberId;
		if (isset($arrRequestForInformationResponsesByRfiResponderFaxContactCompanyOfficePhoneNumberId) && !empty($arrRequestForInformationResponsesByRfiResponderFaxContactCompanyOfficePhoneNumberId)) {
			return $arrRequestForInformationResponsesByRfiResponderFaxContactCompanyOfficePhoneNumberId;
		}

		$rfi_responder_fax_contact_company_office_phone_number_id = (int) $rfi_responder_fax_contact_company_office_phone_number_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `request_for_information_id` ASC, `request_for_information_response_sequence_number` ASC, `request_for_information_response_type_id` ASC, `rfi_responder_contact_id` ASC, `rfi_responder_contact_company_office_id` ASC, `rfi_responder_phone_contact_company_office_phone_number_id` ASC, `rfi_responder_fax_contact_company_office_phone_number_id` ASC, `rfi_responder_contact_mobile_phone_number_id` ASC, `request_for_information_response_title` ASC, `request_for_information_response` ASC, `modified` ASC, `created` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpRequestForInformationResponse = new RequestForInformationResponse($database);
			$sqlOrderByColumns = $tmpRequestForInformationResponse->constructSqlOrderByColumns($arrOrderByAttributes);

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
	rfiresponses.*

FROM `request_for_information_responses` rfiresponses
WHERE rfiresponses.`rfi_responder_fax_contact_company_office_phone_number_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `request_for_information_id` ASC, `request_for_information_response_sequence_number` ASC, `request_for_information_response_type_id` ASC, `rfi_responder_contact_id` ASC, `rfi_responder_contact_company_office_id` ASC, `rfi_responder_phone_contact_company_office_phone_number_id` ASC, `rfi_responder_fax_contact_company_office_phone_number_id` ASC, `rfi_responder_contact_mobile_phone_number_id` ASC, `request_for_information_response_title` ASC, `request_for_information_response` ASC, `modified` ASC, `created` ASC
		$arrValues = array($rfi_responder_fax_contact_company_office_phone_number_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrRequestForInformationResponsesByRfiResponderFaxContactCompanyOfficePhoneNumberId = array();
		while ($row = $db->fetch()) {
			$request_for_information_response_id = $row['id'];
			$requestForInformationResponse = self::instantiateOrm($database, 'RequestForInformationResponse', $row, null, $request_for_information_response_id);
			/* @var $requestForInformationResponse RequestForInformationResponse */
			$arrRequestForInformationResponsesByRfiResponderFaxContactCompanyOfficePhoneNumberId[$request_for_information_response_id] = $requestForInformationResponse;
		}

		$db->free_result();

		self::$_arrRequestForInformationResponsesByRfiResponderFaxContactCompanyOfficePhoneNumberId = $arrRequestForInformationResponsesByRfiResponderFaxContactCompanyOfficePhoneNumberId;

		return $arrRequestForInformationResponsesByRfiResponderFaxContactCompanyOfficePhoneNumberId;
	}

	/**
	 * Load by constraint `request_for_information_responses_fk_responder_c_mobile_cpn` foreign key (`rfi_responder_contact_mobile_phone_number_id`) references `contact_phone_numbers` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $rfi_responder_contact_mobile_phone_number_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadRequestForInformationResponsesByRfiResponderContactMobilePhoneNumberId($database, $rfi_responder_contact_mobile_phone_number_id, Input $options=null)
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
			self::$_arrRequestForInformationResponsesByRfiResponderContactMobilePhoneNumberId = null;
		}

		$arrRequestForInformationResponsesByRfiResponderContactMobilePhoneNumberId = self::$_arrRequestForInformationResponsesByRfiResponderContactMobilePhoneNumberId;
		if (isset($arrRequestForInformationResponsesByRfiResponderContactMobilePhoneNumberId) && !empty($arrRequestForInformationResponsesByRfiResponderContactMobilePhoneNumberId)) {
			return $arrRequestForInformationResponsesByRfiResponderContactMobilePhoneNumberId;
		}

		$rfi_responder_contact_mobile_phone_number_id = (int) $rfi_responder_contact_mobile_phone_number_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `request_for_information_id` ASC, `request_for_information_response_sequence_number` ASC, `request_for_information_response_type_id` ASC, `rfi_responder_contact_id` ASC, `rfi_responder_contact_company_office_id` ASC, `rfi_responder_phone_contact_company_office_phone_number_id` ASC, `rfi_responder_fax_contact_company_office_phone_number_id` ASC, `rfi_responder_contact_mobile_phone_number_id` ASC, `request_for_information_response_title` ASC, `request_for_information_response` ASC, `modified` ASC, `created` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpRequestForInformationResponse = new RequestForInformationResponse($database);
			$sqlOrderByColumns = $tmpRequestForInformationResponse->constructSqlOrderByColumns($arrOrderByAttributes);

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
	rfiresponses.*

FROM `request_for_information_responses` rfiresponses
WHERE rfiresponses.`rfi_responder_contact_mobile_phone_number_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `request_for_information_id` ASC, `request_for_information_response_sequence_number` ASC, `request_for_information_response_type_id` ASC, `rfi_responder_contact_id` ASC, `rfi_responder_contact_company_office_id` ASC, `rfi_responder_phone_contact_company_office_phone_number_id` ASC, `rfi_responder_fax_contact_company_office_phone_number_id` ASC, `rfi_responder_contact_mobile_phone_number_id` ASC, `request_for_information_response_title` ASC, `request_for_information_response` ASC, `modified` ASC, `created` ASC
		$arrValues = array($rfi_responder_contact_mobile_phone_number_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrRequestForInformationResponsesByRfiResponderContactMobilePhoneNumberId = array();
		while ($row = $db->fetch()) {
			$request_for_information_response_id = $row['id'];
			$requestForInformationResponse = self::instantiateOrm($database, 'RequestForInformationResponse', $row, null, $request_for_information_response_id);
			/* @var $requestForInformationResponse RequestForInformationResponse */
			$arrRequestForInformationResponsesByRfiResponderContactMobilePhoneNumberId[$request_for_information_response_id] = $requestForInformationResponse;
		}

		$db->free_result();

		self::$_arrRequestForInformationResponsesByRfiResponderContactMobilePhoneNumberId = $arrRequestForInformationResponsesByRfiResponderContactMobilePhoneNumberId;

		return $arrRequestForInformationResponsesByRfiResponderContactMobilePhoneNumberId;
	}

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all request_for_information_responses records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllRequestForInformationResponses($database, Input $options=null)
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
			self::$_arrAllRequestForInformationResponses = null;
		}

		$arrAllRequestForInformationResponses = self::$_arrAllRequestForInformationResponses;
		if (isset($arrAllRequestForInformationResponses) && !empty($arrAllRequestForInformationResponses)) {
			return $arrAllRequestForInformationResponses;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `request_for_information_id` ASC, `request_for_information_response_sequence_number` ASC, `request_for_information_response_type_id` ASC, `rfi_responder_contact_id` ASC, `rfi_responder_contact_company_office_id` ASC, `rfi_responder_phone_contact_company_office_phone_number_id` ASC, `rfi_responder_fax_contact_company_office_phone_number_id` ASC, `rfi_responder_contact_mobile_phone_number_id` ASC, `request_for_information_response_title` ASC, `request_for_information_response` ASC, `modified` ASC, `created` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpRequestForInformationResponse = new RequestForInformationResponse($database);
			$sqlOrderByColumns = $tmpRequestForInformationResponse->constructSqlOrderByColumns($arrOrderByAttributes);

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
	rfiresponses.*

FROM `request_for_information_responses` rfiresponses{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `request_for_information_id` ASC, `request_for_information_response_sequence_number` ASC, `request_for_information_response_type_id` ASC, `rfi_responder_contact_id` ASC, `rfi_responder_contact_company_office_id` ASC, `rfi_responder_phone_contact_company_office_phone_number_id` ASC, `rfi_responder_fax_contact_company_office_phone_number_id` ASC, `rfi_responder_contact_mobile_phone_number_id` ASC, `request_for_information_response_title` ASC, `request_for_information_response` ASC, `modified` ASC, `created` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllRequestForInformationResponses = array();
		while ($row = $db->fetch()) {
			$request_for_information_response_id = $row['id'];
			$requestForInformationResponse = self::instantiateOrm($database, 'RequestForInformationResponse', $row, null, $request_for_information_response_id);
			/* @var $requestForInformationResponse RequestForInformationResponse */
			$arrAllRequestForInformationResponses[$request_for_information_response_id] = $requestForInformationResponse;
		}

		$db->free_result();

		self::$_arrAllRequestForInformationResponses = $arrAllRequestForInformationResponses;

		return $arrAllRequestForInformationResponses;
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
INTO `request_for_information_responses`
(`request_for_information_id`, `request_for_information_response_sequence_number`, `request_for_information_response_type_id`, `rfi_responder_contact_id`, `rfi_responder_contact_company_office_id`, `rfi_responder_phone_contact_company_office_phone_number_id`, `rfi_responder_fax_contact_company_office_phone_number_id`, `rfi_responder_contact_mobile_phone_number_id`, `request_for_information_response_title`, `request_for_information_response`, `modified`, `created`)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
ON DUPLICATE KEY UPDATE `request_for_information_response_type_id` = ?, `rfi_responder_contact_id` = ?, `rfi_responder_contact_company_office_id` = ?, `rfi_responder_phone_contact_company_office_phone_number_id` = ?, `rfi_responder_fax_contact_company_office_phone_number_id` = ?, `rfi_responder_contact_mobile_phone_number_id` = ?, `request_for_information_response_title` = ?, `request_for_information_response` = ?, `modified` = ?, `created` = ?
";
		$arrValues = array($this->request_for_information_id, $this->request_for_information_response_sequence_number, $this->request_for_information_response_type_id, $this->rfi_responder_contact_id, $this->rfi_responder_contact_company_office_id, $this->rfi_responder_phone_contact_company_office_phone_number_id, $this->rfi_responder_fax_contact_company_office_phone_number_id, $this->rfi_responder_contact_mobile_phone_number_id, $this->request_for_information_response_title, $this->request_for_information_response, $this->modified, $this->created, $this->request_for_information_response_type_id, $this->rfi_responder_contact_id, $this->rfi_responder_contact_company_office_id, $this->rfi_responder_phone_contact_company_office_phone_number_id, $this->rfi_responder_fax_contact_company_office_phone_number_id, $this->rfi_responder_contact_mobile_phone_number_id, $this->request_for_information_response_title, $this->request_for_information_response, $this->modified, $this->created);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$request_for_information_response_id = $db->insertId;
		$db->free_result();

		return $request_for_information_response_id;
	}

	// Save: insert ignore

	/**
	 * Find next_request_for_information_response_sequence_number value.
	 *
	 * @param string $database
	 * @param int $request_for_information_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findNextRequestForInformationResponseSequenceNumber($database, $request_for_information_id)
	{
		$next_request_for_information_response_sequence_number = 1;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT MAX(rfi.request_for_information_response_sequence_number) AS 'max_request_for_information_response_sequence_number'
FROM `request_for_information_responses` rfi
WHERE rfi.`request_for_information_id` = ?
";
		$arrValues = array($request_for_information_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$max_request_for_information_response_sequence_number = $row['max_request_for_information_response_sequence_number'];
			$next_request_for_information_response_sequence_number = $max_request_for_information_response_sequence_number + 1;
		}

		return $next_request_for_information_response_sequence_number;
	}
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

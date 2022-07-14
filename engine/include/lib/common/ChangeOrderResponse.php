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
 * ChangeOrderResponse.
 *
 * @category   Framework
 * @package    ChangeOrderResponse
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class ChangeOrderResponse extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'ChangeOrderResponse';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'change_order_responses';

	/**
	 * Singular version of the table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_tableNameSingular = 'change_order_response';

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
	 * unique index `unique_change_order_response` (`change_order_id`,`change_order_response_sequence_number`) comment 'One CO can have many Responses'
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_change_order_response' => array(
			'change_order_id' => 'int',
			'change_order_response_sequence_number' => 'int'
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
		'id' => 'change_order_response_id',

		'change_order_id' => 'change_order_id',
		'change_order_response_sequence_number' => 'change_order_response_sequence_number',

		'change_order_response_type_id' => 'change_order_response_type_id',
		'co_responder_contact_id' => 'co_responder_contact_id',
		'co_responder_contact_company_office_id' => 'co_responder_contact_company_office_id',
		'co_responder_phone_contact_company_office_phone_number_id' => 'co_responder_phone_contact_company_office_phone_number_id',
		'co_responder_fax_contact_company_office_phone_number_id' => 'co_responder_fax_contact_company_office_phone_number_id',
		'co_responder_contact_mobile_phone_number_id' => 'co_responder_contact_mobile_phone_number_id',

		'change_order_response_title' => 'change_order_response_title',
		'change_order_response' => 'change_order_response',
		'modified' => 'modified',
		'created' => 'created'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $change_order_response_id;

	public $change_order_id;
	public $change_order_response_sequence_number;

	public $change_order_response_type_id;
	public $co_responder_contact_id;
	public $co_responder_contact_company_office_id;
	public $co_responder_phone_contact_company_office_phone_number_id;
	public $co_responder_fax_contact_company_office_phone_number_id;
	public $co_responder_contact_mobile_phone_number_id;

	public $change_order_response_title;
	public $change_order_response;
	public $modified;
	public $created;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties
	public $escaped_change_order_response_title;
	public $escaped_change_order_response;

	// HTML ENTITY ENCODED NL2BR ORM string properties
	public $escaped_change_order_response_title_nl2br;
	public $escaped_change_order_response_nl2br;

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)
	protected static $_arrChangeOrderResponsesByChangeOrderId;
	protected static $_arrChangeOrderResponsesByChangeOrderResponseTypeId;
	protected static $_arrChangeOrderResponsesByCoResponderContactId;
	protected static $_arrChangeOrderResponsesByCoResponderContactCompanyOfficeId;
	protected static $_arrChangeOrderResponsesByCoResponderPhoneContactCompanyOfficePhoneNumberId;
	protected static $_arrChangeOrderResponsesByCoResponderFaxContactCompanyOfficePhoneNumberId;
	protected static $_arrChangeOrderResponsesByCoResponderContactMobilePhoneNumberId;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllChangeOrderResponses;

	// Foreign Key Objects
	private $_changeOrder;
	private $_changeOrderResponseType;
	private $_coResponderContact;
	private $_coResponderContactCompanyOffice;
	private $_coResponderPhoneContactCompanyOfficePhoneNumber;
	private $_coResponderFaxContactCompanyOfficePhoneNumber;
	private $_coResponderContactMobilePhoneNumber;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='change_order_responses')
	{
		parent::__construct($table);
		$this->setDatabase($database);
	}

	// Foreign Key Object Accessor Methods
	public function getChangeOrder()
	{
		if (isset($this->_changeOrder)) {
			return $this->_changeOrder;
		} else {
			return null;
		}
	}

	public function setChangeOrder($changeOrder)
	{
		$this->_changeOrder = $changeOrder;
	}

	public function getChangeOrderResponseType()
	{
		if (isset($this->_changeOrderResponseType)) {
			return $this->_changeOrderResponseType;
		} else {
			return null;
		}
	}

	public function setChangeOrderResponseType($changeOrderResponseType)
	{
		$this->_changeOrderResponseType = $changeOrderResponseType;
	}

	public function getCoResponderContact()
	{
		if (isset($this->_coResponderContact)) {
			return $this->_coResponderContact;
		} else {
			return null;
		}
	}

	public function setCoResponderContact($coResponderContact)
	{
		$this->_coResponderContact = $coResponderContact;
	}

	public function getCoResponderContactCompanyOffice()
	{
		if (isset($this->_coResponderContactCompanyOffice)) {
			return $this->_coResponderContactCompanyOffice;
		} else {
			return null;
		}
	}

	public function setCoResponderContactCompanyOffice($coResponderContactCompanyOffice)
	{
		$this->_coResponderContactCompanyOffice = $coResponderContactCompanyOffice;
	}

	public function getCoResponderPhoneContactCompanyOfficePhoneNumber()
	{
		if (isset($this->_coResponderPhoneContactCompanyOfficePhoneNumber)) {
			return $this->_coResponderPhoneContactCompanyOfficePhoneNumber;
		} else {
			return null;
		}
	}

	public function setCoResponderPhoneContactCompanyOfficePhoneNumber($coResponderPhoneContactCompanyOfficePhoneNumber)
	{
		$this->_coResponderPhoneContactCompanyOfficePhoneNumber = $coResponderPhoneContactCompanyOfficePhoneNumber;
	}

	public function getCoResponderFaxContactCompanyOfficePhoneNumber()
	{
		if (isset($this->_coResponderFaxContactCompanyOfficePhoneNumber)) {
			return $this->_coResponderFaxContactCompanyOfficePhoneNumber;
		} else {
			return null;
		}
	}

	public function setCoResponderFaxContactCompanyOfficePhoneNumber($coResponderFaxContactCompanyOfficePhoneNumber)
	{
		$this->_coResponderFaxContactCompanyOfficePhoneNumber = $coResponderFaxContactCompanyOfficePhoneNumber;
	}

	public function getCoResponderContactMobilePhoneNumber()
	{
		if (isset($this->_coResponderContactMobilePhoneNumber)) {
			return $this->_coResponderContactMobilePhoneNumber;
		} else {
			return null;
		}
	}

	public function setCoResponderContactMobilePhoneNumber($coResponderContactMobilePhoneNumber)
	{
		$this->_coResponderContactMobilePhoneNumber = $coResponderContactMobilePhoneNumber;
	}

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)
	public static function getArrChangeOrderResponsesByChangeOrderId()
	{
		if (isset(self::$_arrChangeOrderResponsesByChangeOrderId)) {
			return self::$_arrChangeOrderResponsesByChangeOrderId;
		} else {
			return null;
		}
	}

	public static function setArrChangeOrderResponsesByChangeOrderId($arrChangeOrderResponsesByChangeOrderId)
	{
		self::$_arrChangeOrderResponsesByChangeOrderId = $arrChangeOrderResponsesByChangeOrderId;
	}

	public static function getArrChangeOrderResponsesByChangeOrderResponseTypeId()
	{
		if (isset(self::$_arrChangeOrderResponsesByChangeOrderResponseTypeId)) {
			return self::$_arrChangeOrderResponsesByChangeOrderResponseTypeId;
		} else {
			return null;
		}
	}

	public static function setArrChangeOrderResponsesByChangeOrderResponseTypeId($arrChangeOrderResponsesByChangeOrderResponseTypeId)
	{
		self::$_arrChangeOrderResponsesByChangeOrderResponseTypeId = $arrChangeOrderResponsesByChangeOrderResponseTypeId;
	}

	public static function getArrChangeOrderResponsesByCoResponderContactId()
	{
		if (isset(self::$_arrChangeOrderResponsesByCoResponderContactId)) {
			return self::$_arrChangeOrderResponsesByCoResponderContactId;
		} else {
			return null;
		}
	}

	public static function setArrChangeOrderResponsesByCoResponderContactId($arrChangeOrderResponsesByCoResponderContactId)
	{
		self::$_arrChangeOrderResponsesByCoResponderContactId = $arrChangeOrderResponsesByCoResponderContactId;
	}

	public static function getArrChangeOrderResponsesByCoResponderContactCompanyOfficeId()
	{
		if (isset(self::$_arrChangeOrderResponsesByCoResponderContactCompanyOfficeId)) {
			return self::$_arrChangeOrderResponsesByCoResponderContactCompanyOfficeId;
		} else {
			return null;
		}
	}

	public static function setArrChangeOrderResponsesByCoResponderContactCompanyOfficeId($arrChangeOrderResponsesByCoResponderContactCompanyOfficeId)
	{
		self::$_arrChangeOrderResponsesByCoResponderContactCompanyOfficeId = $arrChangeOrderResponsesByCoResponderContactCompanyOfficeId;
	}

	public static function getArrChangeOrderResponsesByCoResponderPhoneContactCompanyOfficePhoneNumberId()
	{
		if (isset(self::$_arrChangeOrderResponsesByCoResponderPhoneContactCompanyOfficePhoneNumberId)) {
			return self::$_arrChangeOrderResponsesByCoResponderPhoneContactCompanyOfficePhoneNumberId;
		} else {
			return null;
		}
	}

	public static function setArrChangeOrderResponsesByCoResponderPhoneContactCompanyOfficePhoneNumberId($arrChangeOrderResponsesByCoResponderPhoneContactCompanyOfficePhoneNumberId)
	{
		self::$_arrChangeOrderResponsesByCoResponderPhoneContactCompanyOfficePhoneNumberId = $arrChangeOrderResponsesByCoResponderPhoneContactCompanyOfficePhoneNumberId;
	}

	public static function getArrChangeOrderResponsesByCoResponderFaxContactCompanyOfficePhoneNumberId()
	{
		if (isset(self::$_arrChangeOrderResponsesByCoResponderFaxContactCompanyOfficePhoneNumberId)) {
			return self::$_arrChangeOrderResponsesByCoResponderFaxContactCompanyOfficePhoneNumberId;
		} else {
			return null;
		}
	}

	public static function setArrChangeOrderResponsesByCoResponderFaxContactCompanyOfficePhoneNumberId($arrChangeOrderResponsesByCoResponderFaxContactCompanyOfficePhoneNumberId)
	{
		self::$_arrChangeOrderResponsesByCoResponderFaxContactCompanyOfficePhoneNumberId = $arrChangeOrderResponsesByCoResponderFaxContactCompanyOfficePhoneNumberId;
	}

	public static function getArrChangeOrderResponsesByCoResponderContactMobilePhoneNumberId()
	{
		if (isset(self::$_arrChangeOrderResponsesByCoResponderContactMobilePhoneNumberId)) {
			return self::$_arrChangeOrderResponsesByCoResponderContactMobilePhoneNumberId;
		} else {
			return null;
		}
	}

	public static function setArrChangeOrderResponsesByCoResponderContactMobilePhoneNumberId($arrChangeOrderResponsesByCoResponderContactMobilePhoneNumberId)
	{
		self::$_arrChangeOrderResponsesByCoResponderContactMobilePhoneNumberId = $arrChangeOrderResponsesByCoResponderContactMobilePhoneNumberId;
	}

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllChangeOrderResponses()
	{
		if (isset(self::$_arrAllChangeOrderResponses)) {
			return self::$_arrAllChangeOrderResponses;
		} else {
			return null;
		}
	}

	public static function setArrAllChangeOrderResponses($arrAllChangeOrderResponses)
	{
		self::$_arrAllChangeOrderResponses = $arrAllChangeOrderResponses;
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
	 * @param int $change_order_response_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findById($database, $change_order_response_id, $table='change_order_responses', $module='ChangeOrderResponse')
	{
		$changeOrderResponse = parent::findById($database, $change_order_response_id, $table, $module);

		return $changeOrderResponse;
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Similar to FindById, but with SQL as starter code for more complex joins.
	 *
	 * @param string $database
	 * @param int $change_order_response_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findChangeOrderResponseByIdExtended($database, $change_order_response_id)
	{
		$change_order_response_id = (int) $change_order_response_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	coresponses_fk_co.`id` AS 'coresponses_fk_co__change_order_id',
	coresponses_fk_co.`project_id` AS 'coresponses_fk_co__project_id',
	coresponses_fk_co.`co_sequence_number` AS 'coresponses_fk_co__co_sequence_number',
	coresponses_fk_co.`co_custom_sequence_number` AS 'coresponses_fk_co__co_custom_sequence_number',
	coresponses_fk_co.`co_scheduled_value` AS 'coresponses_fk_co__co_scheduled_value',
	coresponses_fk_co.`co_delay_days` AS 'coresponses_fk_co__co_delay_days',
	coresponses_fk_co.`change_order_type_id` AS 'coresponses_fk_co__change_order_type_id',
	coresponses_fk_co.`change_order_status_id` AS 'coresponses_fk_co__change_order_status_id',
	coresponses_fk_co.`change_order_priority_id` AS 'coresponses_fk_co__change_order_priority_id',
	coresponses_fk_co.`co_file_manager_file_id` AS 'coresponses_fk_co__co_file_manager_file_id',
	coresponses_fk_co.`co_cost_code_id` AS 'coresponses_fk_co__co_cost_code_id',
	coresponses_fk_co.`co_creator_contact_id` AS 'coresponses_fk_co__co_creator_contact_id',
	coresponses_fk_co.`co_creator_contact_company_office_id` AS 'coresponses_fk_co__co_creator_contact_company_office_id',
	coresponses_fk_co.`co_creator_phone_contact_company_office_phone_number_id` AS 'coresponses_fk_co__co_creator_phone_contact_company_office_phone_number_id',
	coresponses_fk_co.`co_creator_fax_contact_company_office_phone_number_id` AS 'coresponses_fk_co__co_creator_fax_contact_company_office_phone_number_id',
	coresponses_fk_co.`co_creator_contact_mobile_phone_number_id` AS 'coresponses_fk_co__co_creator_contact_mobile_phone_number_id',
	coresponses_fk_co.`co_recipient_contact_id` AS 'coresponses_fk_co__co_recipient_contact_id',
	coresponses_fk_co.`co_recipient_contact_company_office_id` AS 'coresponses_fk_co__co_recipient_contact_company_office_id',
	coresponses_fk_co.`co_recipient_phone_contact_company_office_phone_number_id` AS 'coresponses_fk_co__co_recipient_phone_contact_company_office_phone_number_id',
	coresponses_fk_co.`co_recipient_fax_contact_company_office_phone_number_id` AS 'coresponses_fk_co__co_recipient_fax_contact_company_office_phone_number_id',
	coresponses_fk_co.`co_recipient_contact_mobile_phone_number_id` AS 'coresponses_fk_co__co_recipient_contact_mobile_phone_number_id',
	coresponses_fk_co.`co_initiator_contact_id` AS 'coresponses_fk_co__co_initiator_contact_id',
	coresponses_fk_co.`co_initiator_contact_company_office_id` AS 'coresponses_fk_co__co_initiator_contact_company_office_id',
	coresponses_fk_co.`co_initiator_phone_contact_company_office_phone_number_id` AS 'coresponses_fk_co__co_initiator_phone_contact_company_office_phone_number_id',
	coresponses_fk_co.`co_initiator_fax_contact_company_office_phone_number_id` AS 'coresponses_fk_co__co_initiator_fax_contact_company_office_phone_number_id',
	coresponses_fk_co.`co_initiator_contact_mobile_phone_number_id` AS 'coresponses_fk_co__co_initiator_contact_mobile_phone_number_id',
	coresponses_fk_co.`co_title` AS 'coresponses_fk_co__co_title',
	coresponses_fk_co.`co_plan_page_reference` AS 'coresponses_fk_co__co_plan_page_reference',
	coresponses_fk_co.`co_statement` AS 'coresponses_fk_co__co_statement',
	coresponses_fk_co.`created` AS 'coresponses_fk_co__created',
	coresponses_fk_co.`co_revised_project_completion_date` AS 'coresponses_fk_co__co_revised_project_completion_date',
	coresponses_fk_co.`co_closed_date` AS 'coresponses_fk_co__co_closed_date',

	coresponses_fk_cort.`id` AS 'coresponses_fk_cort__change_order_response_type_id',
	coresponses_fk_cort.`change_order_response_type` AS 'coresponses_fk_cort__change_order_response_type',
	coresponses_fk_cort.`disabled_flag` AS 'coresponses_fk_cort__disabled_flag',

	coresponses_fk_responder_c.`id` AS 'coresponses_fk_responder_c__contact_id',
	coresponses_fk_responder_c.`user_company_id` AS 'coresponses_fk_responder_c__user_company_id',
	coresponses_fk_responder_c.`user_id` AS 'coresponses_fk_responder_c__user_id',
	coresponses_fk_responder_c.`contact_company_id` AS 'coresponses_fk_responder_c__contact_company_id',
	coresponses_fk_responder_c.`email` AS 'coresponses_fk_responder_c__email',
	coresponses_fk_responder_c.`name_prefix` AS 'coresponses_fk_responder_c__name_prefix',
	coresponses_fk_responder_c.`first_name` AS 'coresponses_fk_responder_c__first_name',
	coresponses_fk_responder_c.`additional_name` AS 'coresponses_fk_responder_c__additional_name',
	coresponses_fk_responder_c.`middle_name` AS 'coresponses_fk_responder_c__middle_name',
	coresponses_fk_responder_c.`last_name` AS 'coresponses_fk_responder_c__last_name',
	coresponses_fk_responder_c.`name_suffix` AS 'coresponses_fk_responder_c__name_suffix',
	coresponses_fk_responder_c.`title` AS 'coresponses_fk_responder_c__title',
	coresponses_fk_responder_c.`vendor_flag` AS 'coresponses_fk_responder_c__vendor_flag',

	coresponses_fk_responder_cco.`id` AS 'coresponses_fk_responder_cco__contact_company_office_id',
	coresponses_fk_responder_cco.`contact_company_id` AS 'coresponses_fk_responder_cco__contact_company_id',
	coresponses_fk_responder_cco.`office_nickname` AS 'coresponses_fk_responder_cco__office_nickname',
	coresponses_fk_responder_cco.`address_line_1` AS 'coresponses_fk_responder_cco__address_line_1',
	coresponses_fk_responder_cco.`address_line_2` AS 'coresponses_fk_responder_cco__address_line_2',
	coresponses_fk_responder_cco.`address_line_3` AS 'coresponses_fk_responder_cco__address_line_3',
	coresponses_fk_responder_cco.`address_line_4` AS 'coresponses_fk_responder_cco__address_line_4',
	coresponses_fk_responder_cco.`address_city` AS 'coresponses_fk_responder_cco__address_city',
	coresponses_fk_responder_cco.`address_county` AS 'coresponses_fk_responder_cco__address_county',
	coresponses_fk_responder_cco.`address_state_or_region` AS 'coresponses_fk_responder_cco__address_state_or_region',
	coresponses_fk_responder_cco.`address_postal_code` AS 'coresponses_fk_responder_cco__address_postal_code',
	coresponses_fk_responder_cco.`address_postal_code_extension` AS 'coresponses_fk_responder_cco__address_postal_code_extension',
	coresponses_fk_responder_cco.`address_country` AS 'coresponses_fk_responder_cco__address_country',
	coresponses_fk_responder_cco.`head_quarters_flag` AS 'coresponses_fk_responder_cco__head_quarters_flag',
	coresponses_fk_responder_cco.`address_validated_by_user_flag` AS 'coresponses_fk_responder_cco__address_validated_by_user_flag',
	coresponses_fk_responder_cco.`address_validated_by_web_service_flag` AS 'coresponses_fk_responder_cco__address_validated_by_web_service_flag',
	coresponses_fk_responder_cco.`address_validation_by_web_service_error_flag` AS 'coresponses_fk_responder_cco__address_validation_by_web_service_error_flag',

	coresponses_fk_responder_phone_ccopn.`id` AS 'coresponses_fk_responder_phone_ccopn__contact_company_office_phone_number_id',
	coresponses_fk_responder_phone_ccopn.`contact_company_office_id` AS 'coresponses_fk_responder_phone_ccopn__contact_company_office_id',
	coresponses_fk_responder_phone_ccopn.`phone_number_type_id` AS 'coresponses_fk_responder_phone_ccopn__phone_number_type_id',
	coresponses_fk_responder_phone_ccopn.`country_code` AS 'coresponses_fk_responder_phone_ccopn__country_code',
	coresponses_fk_responder_phone_ccopn.`area_code` AS 'coresponses_fk_responder_phone_ccopn__area_code',
	coresponses_fk_responder_phone_ccopn.`prefix` AS 'coresponses_fk_responder_phone_ccopn__prefix',
	coresponses_fk_responder_phone_ccopn.`number` AS 'coresponses_fk_responder_phone_ccopn__number',
	coresponses_fk_responder_phone_ccopn.`extension` AS 'coresponses_fk_responder_phone_ccopn__extension',
	coresponses_fk_responder_phone_ccopn.`itu` AS 'coresponses_fk_responder_phone_ccopn__itu',

	coresponses_fk_responder_fax_ccopn.`id` AS 'coresponses_fk_responder_fax_ccopn__contact_company_office_phone_number_id',
	coresponses_fk_responder_fax_ccopn.`contact_company_office_id` AS 'coresponses_fk_responder_fax_ccopn__contact_company_office_id',
	coresponses_fk_responder_fax_ccopn.`phone_number_type_id` AS 'coresponses_fk_responder_fax_ccopn__phone_number_type_id',
	coresponses_fk_responder_fax_ccopn.`country_code` AS 'coresponses_fk_responder_fax_ccopn__country_code',
	coresponses_fk_responder_fax_ccopn.`area_code` AS 'coresponses_fk_responder_fax_ccopn__area_code',
	coresponses_fk_responder_fax_ccopn.`prefix` AS 'coresponses_fk_responder_fax_ccopn__prefix',
	coresponses_fk_responder_fax_ccopn.`number` AS 'coresponses_fk_responder_fax_ccopn__number',
	coresponses_fk_responder_fax_ccopn.`extension` AS 'coresponses_fk_responder_fax_ccopn__extension',
	coresponses_fk_responder_fax_ccopn.`itu` AS 'coresponses_fk_responder_fax_ccopn__itu',

	coresponses_fk_responder_c_mobile_cpn.`id` AS 'coresponses_fk_responder_c_mobile_cpn__contact_phone_number_id',
	coresponses_fk_responder_c_mobile_cpn.`contact_id` AS 'coresponses_fk_responder_c_mobile_cpn__contact_id',
	coresponses_fk_responder_c_mobile_cpn.`phone_number_type_id` AS 'coresponses_fk_responder_c_mobile_cpn__phone_number_type_id',
	coresponses_fk_responder_c_mobile_cpn.`country_code` AS 'coresponses_fk_responder_c_mobile_cpn__country_code',
	coresponses_fk_responder_c_mobile_cpn.`area_code` AS 'coresponses_fk_responder_c_mobile_cpn__area_code',
	coresponses_fk_responder_c_mobile_cpn.`prefix` AS 'coresponses_fk_responder_c_mobile_cpn__prefix',
	coresponses_fk_responder_c_mobile_cpn.`number` AS 'coresponses_fk_responder_c_mobile_cpn__number',
	coresponses_fk_responder_c_mobile_cpn.`extension` AS 'coresponses_fk_responder_c_mobile_cpn__extension',
	coresponses_fk_responder_c_mobile_cpn.`itu` AS 'coresponses_fk_responder_c_mobile_cpn__itu',

	coresponses.*

FROM `change_order_responses` coresponses
	INNER JOIN `change_orders` coresponses_fk_co ON coresponses.`change_order_id` = coresponses_fk_co.`id`
	INNER JOIN `change_order_response_types` coresponses_fk_cort ON coresponses.`change_order_response_type_id` = coresponses_fk_cort.`id`
	INNER JOIN `contacts` coresponses_fk_responder_c ON coresponses.`co_responder_contact_id` = coresponses_fk_responder_c.`id`
	LEFT OUTER JOIN `contact_company_offices` coresponses_fk_responder_cco ON coresponses.`co_responder_contact_company_office_id` = coresponses_fk_responder_cco.`id`
	LEFT OUTER JOIN `contact_company_office_phone_numbers` coresponses_fk_responder_phone_ccopn ON coresponses.`co_responder_phone_contact_company_office_phone_number_id` = coresponses_fk_responder_phone_ccopn.`id`
	LEFT OUTER JOIN `contact_company_office_phone_numbers` coresponses_fk_responder_fax_ccopn ON coresponses.`co_responder_fax_contact_company_office_phone_number_id` = coresponses_fk_responder_fax_ccopn.`id`
	LEFT OUTER JOIN `contact_phone_numbers` coresponses_fk_responder_c_mobile_cpn ON coresponses.`co_responder_contact_mobile_phone_number_id` = coresponses_fk_responder_c_mobile_cpn.`id`
WHERE coresponses.`id` = ?
";
		$arrValues = array($change_order_response_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$change_order_response_id = $row['id'];
			$changeOrderResponse = self::instantiateOrm($database, 'ChangeOrderResponse', $row, null, $change_order_response_id);
			/* @var $changeOrderResponse ChangeOrderResponse */
			$changeOrderResponse->convertPropertiesToData();

			if (isset($row['change_order_id'])) {
				$change_order_id = $row['change_order_id'];
				$row['coresponses_fk_co__id'] = $change_order_id;
				$changeOrder = self::instantiateOrm($database, 'ChangeOrder', $row, null, $change_order_id, 'coresponses_fk_co__');
				/* @var $changeOrder ChangeOrder */
				$changeOrder->convertPropertiesToData();
			} else {
				$changeOrder = false;
			}
			$changeOrderResponse->setChangeOrder($changeOrder);

			if (isset($row['change_order_response_type_id'])) {
				$change_order_response_type_id = $row['change_order_response_type_id'];
				$row['coresponses_fk_cort__id'] = $change_order_response_type_id;
				$changeOrderResponseType = self::instantiateOrm($database, 'ChangeOrderResponseType', $row, null, $change_order_response_type_id, 'coresponses_fk_cort__');
				/* @var $changeOrderResponseType ChangeOrderResponseType */
				$changeOrderResponseType->convertPropertiesToData();
			} else {
				$changeOrderResponseType = false;
			}
			$changeOrderResponse->setChangeOrderResponseType($changeOrderResponseType);

			if (isset($row['co_responder_contact_id'])) {
				$co_responder_contact_id = $row['co_responder_contact_id'];
				$row['coresponses_fk_responder_c__id'] = $co_responder_contact_id;
				$coResponderContact = self::instantiateOrm($database, 'Contact', $row, null, $co_responder_contact_id, 'coresponses_fk_responder_c__');
				/* @var $coResponderContact Contact */
				$coResponderContact->convertPropertiesToData();
			} else {
				$coResponderContact = false;
			}
			$changeOrderResponse->setCoResponderContact($coResponderContact);

			if (isset($row['co_responder_contact_company_office_id'])) {
				$co_responder_contact_company_office_id = $row['co_responder_contact_company_office_id'];
				$row['coresponses_fk_responder_cco__id'] = $co_responder_contact_company_office_id;
				$coResponderContactCompanyOffice = self::instantiateOrm($database, 'ContactCompanyOffice', $row, null, $co_responder_contact_company_office_id, 'coresponses_fk_responder_cco__');
				/* @var $coResponderContactCompanyOffice ContactCompanyOffice */
				$coResponderContactCompanyOffice->convertPropertiesToData();
			} else {
				$coResponderContactCompanyOffice = false;
			}
			$changeOrderResponse->setCoResponderContactCompanyOffice($coResponderContactCompanyOffice);

			if (isset($row['co_responder_phone_contact_company_office_phone_number_id'])) {
				$co_responder_phone_contact_company_office_phone_number_id = $row['co_responder_phone_contact_company_office_phone_number_id'];
				$row['coresponses_fk_responder_phone_ccopn__id'] = $co_responder_phone_contact_company_office_phone_number_id;
				$coResponderPhoneContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $co_responder_phone_contact_company_office_phone_number_id, 'coresponses_fk_responder_phone_ccopn__');
				/* @var $coResponderPhoneContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$coResponderPhoneContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$coResponderPhoneContactCompanyOfficePhoneNumber = false;
			}
			$changeOrderResponse->setCoResponderPhoneContactCompanyOfficePhoneNumber($coResponderPhoneContactCompanyOfficePhoneNumber);

			if (isset($row['co_responder_fax_contact_company_office_phone_number_id'])) {
				$co_responder_fax_contact_company_office_phone_number_id = $row['co_responder_fax_contact_company_office_phone_number_id'];
				$row['coresponses_fk_responder_fax_ccopn__id'] = $co_responder_fax_contact_company_office_phone_number_id;
				$coResponderFaxContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $co_responder_fax_contact_company_office_phone_number_id, 'coresponses_fk_responder_fax_ccopn__');
				/* @var $coResponderFaxContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$coResponderFaxContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$coResponderFaxContactCompanyOfficePhoneNumber = false;
			}
			$changeOrderResponse->setCoResponderFaxContactCompanyOfficePhoneNumber($coResponderFaxContactCompanyOfficePhoneNumber);

			if (isset($row['co_responder_contact_mobile_phone_number_id'])) {
				$co_responder_contact_mobile_phone_number_id = $row['co_responder_contact_mobile_phone_number_id'];
				$row['coresponses_fk_responder_c_mobile_cpn__id'] = $co_responder_contact_mobile_phone_number_id;
				$coResponderContactMobilePhoneNumber = self::instantiateOrm($database, 'ContactPhoneNumber', $row, null, $co_responder_contact_mobile_phone_number_id, 'coresponses_fk_responder_c_mobile_cpn__');
				/* @var $coResponderContactMobilePhoneNumber ContactPhoneNumber */
				$coResponderContactMobilePhoneNumber->convertPropertiesToData();
			} else {
				$coResponderContactMobilePhoneNumber = false;
			}
			$changeOrderResponse->setCoResponderContactMobilePhoneNumber($coResponderContactMobilePhoneNumber);

			return $changeOrderResponse;
		} else {
			return false;
		}
	}

	// Finders: Find By Unique Index
	/**
	 * Find by unique index `unique_change_order_response` (`change_order_id`,`change_order_response_sequence_number`) comment 'One CO can have many Responses'.
	 *
	 * @param string $database
	 * @param int $change_order_id
	 * @param int $change_order_response_sequence_number
	 * @return mixed (single ORM object | false)
	 */
	public static function findByChangeOrderIdAndChangeOrderResponseSequenceNumber($database, $change_order_id, $change_order_response_sequence_number)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	coresponses.*

FROM `change_order_responses` coresponses
WHERE coresponses.`change_order_id` = ?
AND coresponses.`change_order_response_sequence_number` = ?
";
		$arrValues = array($change_order_id, $change_order_response_sequence_number);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if ($row && !empty($row)) {
			$change_order_response_id = $row['id'];
			$changeOrderResponse = self::instantiateOrm($database, 'ChangeOrderResponse', $row, null, $change_order_response_id);
			/* @var $changeOrderResponse ChangeOrderResponse */
			return $changeOrderResponse;
		} else {
			return false;
		}
	}

	// Loaders: Load By pk List (list of auto int ids or other non auto int pk list)
	/**
	 * Load zero or more records by an id list (array of auto int primary keys).
	 *
	 * @param string $database
	 * @param array $arrChangeOrderResponseIds
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadChangeOrderResponsesByArrChangeOrderResponseIds($database, $arrChangeOrderResponseIds, Input $options=null)
	{
		if (empty($arrChangeOrderResponseIds)) {
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
		// ORDER BY `id` ASC, `change_order_id` ASC, `change_order_response_sequence_number` ASC, `change_order_response_type_id` ASC, `co_responder_contact_id` ASC, `co_responder_contact_company_office_id` ASC, `co_responder_phone_contact_company_office_phone_number_id` ASC, `co_responder_fax_contact_company_office_phone_number_id` ASC, `co_responder_contact_mobile_phone_number_id` ASC, `change_order_response_title` ASC, `change_order_response` ASC, `modified` ASC, `created` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpChangeOrderResponse = new ChangeOrderResponse($database);
			$sqlOrderByColumns = $tmpChangeOrderResponse->constructSqlOrderByColumns($arrOrderByAttributes);

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

		foreach ($arrChangeOrderResponseIds as $k => $change_order_response_id) {
			$change_order_response_id = (int) $change_order_response_id;
			$arrChangeOrderResponseIds[$k] = $db->escape($change_order_response_id);
		}
		$csvChangeOrderResponseIds = join(',', $arrChangeOrderResponseIds);

		$query =
"
SELECT

	coresponses.*

FROM `change_order_responses` coresponses
WHERE coresponses.`id` IN ($csvChangeOrderResponseIds){$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		$arrChangeOrderResponsesByCsvChangeOrderResponseIds = array();
		while ($row = $db->fetch()) {
			$change_order_response_id = $row['id'];
			$changeOrderResponse = self::instantiateOrm($database, 'ChangeOrderResponse', $row, null, $change_order_response_id);
			/* @var $changeOrderResponse ChangeOrderResponse */
			$changeOrderResponse->convertPropertiesToData();

			$arrChangeOrderResponsesByCsvChangeOrderResponseIds[$change_order_response_id] = $changeOrderResponse;
		}

		$db->free_result();

		return $arrChangeOrderResponsesByCsvChangeOrderResponseIds;
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `change_order_responses_fk_co` foreign key (`change_order_id`) references `change_orders` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $change_order_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadChangeOrderResponsesByChangeOrderId($database, $change_order_id, Input $options=null)
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
			self::$_arrChangeOrderResponsesByChangeOrderId = null;
		}

		$arrChangeOrderResponsesByChangeOrderId = self::$_arrChangeOrderResponsesByChangeOrderId;
		if (isset($arrChangeOrderResponsesByChangeOrderId) && !empty($arrChangeOrderResponsesByChangeOrderId)) {
			return $arrChangeOrderResponsesByChangeOrderId;
		}

		$change_order_id = (int) $change_order_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `change_order_id` ASC, `change_order_response_sequence_number` ASC, `change_order_response_type_id` ASC, `co_responder_contact_id` ASC, `co_responder_contact_company_office_id` ASC, `co_responder_phone_contact_company_office_phone_number_id` ASC, `co_responder_fax_contact_company_office_phone_number_id` ASC, `co_responder_contact_mobile_phone_number_id` ASC, `change_order_response_title` ASC, `change_order_response` ASC, `modified` ASC, `created` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpChangeOrderResponse = new ChangeOrderResponse($database);
			$sqlOrderByColumns = $tmpChangeOrderResponse->constructSqlOrderByColumns($arrOrderByAttributes);

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
	coresponses.*

FROM `change_order_responses` coresponses
WHERE coresponses.`change_order_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `change_order_id` ASC, `change_order_response_sequence_number` ASC, `change_order_response_type_id` ASC, `co_responder_contact_id` ASC, `co_responder_contact_company_office_id` ASC, `co_responder_phone_contact_company_office_phone_number_id` ASC, `co_responder_fax_contact_company_office_phone_number_id` ASC, `co_responder_contact_mobile_phone_number_id` ASC, `change_order_response_title` ASC, `change_order_response` ASC, `modified` ASC, `created` ASC
		$arrValues = array($change_order_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrChangeOrderResponsesByChangeOrderId = array();
		while ($row = $db->fetch()) {
			$change_order_response_id = $row['id'];
			$changeOrderResponse = self::instantiateOrm($database, 'ChangeOrderResponse', $row, null, $change_order_response_id);
			/* @var $changeOrderResponse ChangeOrderResponse */
			$arrChangeOrderResponsesByChangeOrderId[$change_order_response_id] = $changeOrderResponse;
		}

		$db->free_result();

		self::$_arrChangeOrderResponsesByChangeOrderId = $arrChangeOrderResponsesByChangeOrderId;

		return $arrChangeOrderResponsesByChangeOrderId;
	}

	/**
	 * Load by constraint `change_order_responses_fk_cort` foreign key (`change_order_response_type_id`) references `change_order_response_types` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $change_order_response_type_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadChangeOrderResponsesByChangeOrderResponseTypeId($database, $change_order_response_type_id, Input $options=null)
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
			self::$_arrChangeOrderResponsesByChangeOrderResponseTypeId = null;
		}

		$arrChangeOrderResponsesByChangeOrderResponseTypeId = self::$_arrChangeOrderResponsesByChangeOrderResponseTypeId;
		if (isset($arrChangeOrderResponsesByChangeOrderResponseTypeId) && !empty($arrChangeOrderResponsesByChangeOrderResponseTypeId)) {
			return $arrChangeOrderResponsesByChangeOrderResponseTypeId;
		}

		$change_order_response_type_id = (int) $change_order_response_type_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `change_order_id` ASC, `change_order_response_sequence_number` ASC, `change_order_response_type_id` ASC, `co_responder_contact_id` ASC, `co_responder_contact_company_office_id` ASC, `co_responder_phone_contact_company_office_phone_number_id` ASC, `co_responder_fax_contact_company_office_phone_number_id` ASC, `co_responder_contact_mobile_phone_number_id` ASC, `change_order_response_title` ASC, `change_order_response` ASC, `modified` ASC, `created` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpChangeOrderResponse = new ChangeOrderResponse($database);
			$sqlOrderByColumns = $tmpChangeOrderResponse->constructSqlOrderByColumns($arrOrderByAttributes);

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
	coresponses.*

FROM `change_order_responses` coresponses
WHERE coresponses.`change_order_response_type_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `change_order_id` ASC, `change_order_response_sequence_number` ASC, `change_order_response_type_id` ASC, `co_responder_contact_id` ASC, `co_responder_contact_company_office_id` ASC, `co_responder_phone_contact_company_office_phone_number_id` ASC, `co_responder_fax_contact_company_office_phone_number_id` ASC, `co_responder_contact_mobile_phone_number_id` ASC, `change_order_response_title` ASC, `change_order_response` ASC, `modified` ASC, `created` ASC
		$arrValues = array($change_order_response_type_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrChangeOrderResponsesByChangeOrderResponseTypeId = array();
		while ($row = $db->fetch()) {
			$change_order_response_id = $row['id'];
			$changeOrderResponse = self::instantiateOrm($database, 'ChangeOrderResponse', $row, null, $change_order_response_id);
			/* @var $changeOrderResponse ChangeOrderResponse */
			$arrChangeOrderResponsesByChangeOrderResponseTypeId[$change_order_response_id] = $changeOrderResponse;
		}

		$db->free_result();

		self::$_arrChangeOrderResponsesByChangeOrderResponseTypeId = $arrChangeOrderResponsesByChangeOrderResponseTypeId;

		return $arrChangeOrderResponsesByChangeOrderResponseTypeId;
	}

	/**
	 * Load by constraint `change_order_responses_fk_responder_c` foreign key (`co_responder_contact_id`) references `contacts` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $co_responder_contact_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadChangeOrderResponsesByCoResponderContactId($database, $co_responder_contact_id, Input $options=null)
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
			self::$_arrChangeOrderResponsesByCoResponderContactId = null;
		}

		$arrChangeOrderResponsesByCoResponderContactId = self::$_arrChangeOrderResponsesByCoResponderContactId;
		if (isset($arrChangeOrderResponsesByCoResponderContactId) && !empty($arrChangeOrderResponsesByCoResponderContactId)) {
			return $arrChangeOrderResponsesByCoResponderContactId;
		}

		$co_responder_contact_id = (int) $co_responder_contact_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `change_order_id` ASC, `change_order_response_sequence_number` ASC, `change_order_response_type_id` ASC, `co_responder_contact_id` ASC, `co_responder_contact_company_office_id` ASC, `co_responder_phone_contact_company_office_phone_number_id` ASC, `co_responder_fax_contact_company_office_phone_number_id` ASC, `co_responder_contact_mobile_phone_number_id` ASC, `change_order_response_title` ASC, `change_order_response` ASC, `modified` ASC, `created` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpChangeOrderResponse = new ChangeOrderResponse($database);
			$sqlOrderByColumns = $tmpChangeOrderResponse->constructSqlOrderByColumns($arrOrderByAttributes);

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
	coresponses.*

FROM `change_order_responses` coresponses
WHERE coresponses.`co_responder_contact_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `change_order_id` ASC, `change_order_response_sequence_number` ASC, `change_order_response_type_id` ASC, `co_responder_contact_id` ASC, `co_responder_contact_company_office_id` ASC, `co_responder_phone_contact_company_office_phone_number_id` ASC, `co_responder_fax_contact_company_office_phone_number_id` ASC, `co_responder_contact_mobile_phone_number_id` ASC, `change_order_response_title` ASC, `change_order_response` ASC, `modified` ASC, `created` ASC
		$arrValues = array($co_responder_contact_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrChangeOrderResponsesByCoResponderContactId = array();
		while ($row = $db->fetch()) {
			$change_order_response_id = $row['id'];
			$changeOrderResponse = self::instantiateOrm($database, 'ChangeOrderResponse', $row, null, $change_order_response_id);
			/* @var $changeOrderResponse ChangeOrderResponse */
			$arrChangeOrderResponsesByCoResponderContactId[$change_order_response_id] = $changeOrderResponse;
		}

		$db->free_result();

		self::$_arrChangeOrderResponsesByCoResponderContactId = $arrChangeOrderResponsesByCoResponderContactId;

		return $arrChangeOrderResponsesByCoResponderContactId;
	}

	/**
	 * Load by constraint `change_order_responses_fk_responder_cco` foreign key (`co_responder_contact_company_office_id`) references `contact_company_offices` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $co_responder_contact_company_office_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadChangeOrderResponsesByCoResponderContactCompanyOfficeId($database, $co_responder_contact_company_office_id, Input $options=null)
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
			self::$_arrChangeOrderResponsesByCoResponderContactCompanyOfficeId = null;
		}

		$arrChangeOrderResponsesByCoResponderContactCompanyOfficeId = self::$_arrChangeOrderResponsesByCoResponderContactCompanyOfficeId;
		if (isset($arrChangeOrderResponsesByCoResponderContactCompanyOfficeId) && !empty($arrChangeOrderResponsesByCoResponderContactCompanyOfficeId)) {
			return $arrChangeOrderResponsesByCoResponderContactCompanyOfficeId;
		}

		$co_responder_contact_company_office_id = (int) $co_responder_contact_company_office_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `change_order_id` ASC, `change_order_response_sequence_number` ASC, `change_order_response_type_id` ASC, `co_responder_contact_id` ASC, `co_responder_contact_company_office_id` ASC, `co_responder_phone_contact_company_office_phone_number_id` ASC, `co_responder_fax_contact_company_office_phone_number_id` ASC, `co_responder_contact_mobile_phone_number_id` ASC, `change_order_response_title` ASC, `change_order_response` ASC, `modified` ASC, `created` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpChangeOrderResponse = new ChangeOrderResponse($database);
			$sqlOrderByColumns = $tmpChangeOrderResponse->constructSqlOrderByColumns($arrOrderByAttributes);

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
	coresponses.*

FROM `change_order_responses` coresponses
WHERE coresponses.`co_responder_contact_company_office_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `change_order_id` ASC, `change_order_response_sequence_number` ASC, `change_order_response_type_id` ASC, `co_responder_contact_id` ASC, `co_responder_contact_company_office_id` ASC, `co_responder_phone_contact_company_office_phone_number_id` ASC, `co_responder_fax_contact_company_office_phone_number_id` ASC, `co_responder_contact_mobile_phone_number_id` ASC, `change_order_response_title` ASC, `change_order_response` ASC, `modified` ASC, `created` ASC
		$arrValues = array($co_responder_contact_company_office_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrChangeOrderResponsesByCoResponderContactCompanyOfficeId = array();
		while ($row = $db->fetch()) {
			$change_order_response_id = $row['id'];
			$changeOrderResponse = self::instantiateOrm($database, 'ChangeOrderResponse', $row, null, $change_order_response_id);
			/* @var $changeOrderResponse ChangeOrderResponse */
			$arrChangeOrderResponsesByCoResponderContactCompanyOfficeId[$change_order_response_id] = $changeOrderResponse;
		}

		$db->free_result();

		self::$_arrChangeOrderResponsesByCoResponderContactCompanyOfficeId = $arrChangeOrderResponsesByCoResponderContactCompanyOfficeId;

		return $arrChangeOrderResponsesByCoResponderContactCompanyOfficeId;
	}

	/**
	 * Load by constraint `change_order_responses_fk_responder_phone_ccopn` foreign key (`co_responder_phone_contact_company_office_phone_number_id`) references `contact_company_office_phone_numbers` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $co_responder_phone_contact_company_office_phone_number_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadChangeOrderResponsesByCoResponderPhoneContactCompanyOfficePhoneNumberId($database, $co_responder_phone_contact_company_office_phone_number_id, Input $options=null)
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
			self::$_arrChangeOrderResponsesByCoResponderPhoneContactCompanyOfficePhoneNumberId = null;
		}

		$arrChangeOrderResponsesByCoResponderPhoneContactCompanyOfficePhoneNumberId = self::$_arrChangeOrderResponsesByCoResponderPhoneContactCompanyOfficePhoneNumberId;
		if (isset($arrChangeOrderResponsesByCoResponderPhoneContactCompanyOfficePhoneNumberId) && !empty($arrChangeOrderResponsesByCoResponderPhoneContactCompanyOfficePhoneNumberId)) {
			return $arrChangeOrderResponsesByCoResponderPhoneContactCompanyOfficePhoneNumberId;
		}

		$co_responder_phone_contact_company_office_phone_number_id = (int) $co_responder_phone_contact_company_office_phone_number_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `change_order_id` ASC, `change_order_response_sequence_number` ASC, `change_order_response_type_id` ASC, `co_responder_contact_id` ASC, `co_responder_contact_company_office_id` ASC, `co_responder_phone_contact_company_office_phone_number_id` ASC, `co_responder_fax_contact_company_office_phone_number_id` ASC, `co_responder_contact_mobile_phone_number_id` ASC, `change_order_response_title` ASC, `change_order_response` ASC, `modified` ASC, `created` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpChangeOrderResponse = new ChangeOrderResponse($database);
			$sqlOrderByColumns = $tmpChangeOrderResponse->constructSqlOrderByColumns($arrOrderByAttributes);

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
	coresponses.*

FROM `change_order_responses` coresponses
WHERE coresponses.`co_responder_phone_contact_company_office_phone_number_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `change_order_id` ASC, `change_order_response_sequence_number` ASC, `change_order_response_type_id` ASC, `co_responder_contact_id` ASC, `co_responder_contact_company_office_id` ASC, `co_responder_phone_contact_company_office_phone_number_id` ASC, `co_responder_fax_contact_company_office_phone_number_id` ASC, `co_responder_contact_mobile_phone_number_id` ASC, `change_order_response_title` ASC, `change_order_response` ASC, `modified` ASC, `created` ASC
		$arrValues = array($co_responder_phone_contact_company_office_phone_number_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrChangeOrderResponsesByCoResponderPhoneContactCompanyOfficePhoneNumberId = array();
		while ($row = $db->fetch()) {
			$change_order_response_id = $row['id'];
			$changeOrderResponse = self::instantiateOrm($database, 'ChangeOrderResponse', $row, null, $change_order_response_id);
			/* @var $changeOrderResponse ChangeOrderResponse */
			$arrChangeOrderResponsesByCoResponderPhoneContactCompanyOfficePhoneNumberId[$change_order_response_id] = $changeOrderResponse;
		}

		$db->free_result();

		self::$_arrChangeOrderResponsesByCoResponderPhoneContactCompanyOfficePhoneNumberId = $arrChangeOrderResponsesByCoResponderPhoneContactCompanyOfficePhoneNumberId;

		return $arrChangeOrderResponsesByCoResponderPhoneContactCompanyOfficePhoneNumberId;
	}

	/**
	 * Load by constraint `change_order_responses_fk_responder_fax_ccopn` foreign key (`co_responder_fax_contact_company_office_phone_number_id`) references `contact_company_office_phone_numbers` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $co_responder_fax_contact_company_office_phone_number_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadChangeOrderResponsesByCoResponderFaxContactCompanyOfficePhoneNumberId($database, $co_responder_fax_contact_company_office_phone_number_id, Input $options=null)
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
			self::$_arrChangeOrderResponsesByCoResponderFaxContactCompanyOfficePhoneNumberId = null;
		}

		$arrChangeOrderResponsesByCoResponderFaxContactCompanyOfficePhoneNumberId = self::$_arrChangeOrderResponsesByCoResponderFaxContactCompanyOfficePhoneNumberId;
		if (isset($arrChangeOrderResponsesByCoResponderFaxContactCompanyOfficePhoneNumberId) && !empty($arrChangeOrderResponsesByCoResponderFaxContactCompanyOfficePhoneNumberId)) {
			return $arrChangeOrderResponsesByCoResponderFaxContactCompanyOfficePhoneNumberId;
		}

		$co_responder_fax_contact_company_office_phone_number_id = (int) $co_responder_fax_contact_company_office_phone_number_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `change_order_id` ASC, `change_order_response_sequence_number` ASC, `change_order_response_type_id` ASC, `co_responder_contact_id` ASC, `co_responder_contact_company_office_id` ASC, `co_responder_phone_contact_company_office_phone_number_id` ASC, `co_responder_fax_contact_company_office_phone_number_id` ASC, `co_responder_contact_mobile_phone_number_id` ASC, `change_order_response_title` ASC, `change_order_response` ASC, `modified` ASC, `created` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpChangeOrderResponse = new ChangeOrderResponse($database);
			$sqlOrderByColumns = $tmpChangeOrderResponse->constructSqlOrderByColumns($arrOrderByAttributes);

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
	coresponses.*

FROM `change_order_responses` coresponses
WHERE coresponses.`co_responder_fax_contact_company_office_phone_number_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `change_order_id` ASC, `change_order_response_sequence_number` ASC, `change_order_response_type_id` ASC, `co_responder_contact_id` ASC, `co_responder_contact_company_office_id` ASC, `co_responder_phone_contact_company_office_phone_number_id` ASC, `co_responder_fax_contact_company_office_phone_number_id` ASC, `co_responder_contact_mobile_phone_number_id` ASC, `change_order_response_title` ASC, `change_order_response` ASC, `modified` ASC, `created` ASC
		$arrValues = array($co_responder_fax_contact_company_office_phone_number_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrChangeOrderResponsesByCoResponderFaxContactCompanyOfficePhoneNumberId = array();
		while ($row = $db->fetch()) {
			$change_order_response_id = $row['id'];
			$changeOrderResponse = self::instantiateOrm($database, 'ChangeOrderResponse', $row, null, $change_order_response_id);
			/* @var $changeOrderResponse ChangeOrderResponse */
			$arrChangeOrderResponsesByCoResponderFaxContactCompanyOfficePhoneNumberId[$change_order_response_id] = $changeOrderResponse;
		}

		$db->free_result();

		self::$_arrChangeOrderResponsesByCoResponderFaxContactCompanyOfficePhoneNumberId = $arrChangeOrderResponsesByCoResponderFaxContactCompanyOfficePhoneNumberId;

		return $arrChangeOrderResponsesByCoResponderFaxContactCompanyOfficePhoneNumberId;
	}

	/**
	 * Load by constraint `change_order_responses_fk_responder_c_mobile_cpn` foreign key (`co_responder_contact_mobile_phone_number_id`) references `contact_phone_numbers` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $co_responder_contact_mobile_phone_number_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadChangeOrderResponsesByCoResponderContactMobilePhoneNumberId($database, $co_responder_contact_mobile_phone_number_id, Input $options=null)
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
			self::$_arrChangeOrderResponsesByCoResponderContactMobilePhoneNumberId = null;
		}

		$arrChangeOrderResponsesByCoResponderContactMobilePhoneNumberId = self::$_arrChangeOrderResponsesByCoResponderContactMobilePhoneNumberId;
		if (isset($arrChangeOrderResponsesByCoResponderContactMobilePhoneNumberId) && !empty($arrChangeOrderResponsesByCoResponderContactMobilePhoneNumberId)) {
			return $arrChangeOrderResponsesByCoResponderContactMobilePhoneNumberId;
		}

		$co_responder_contact_mobile_phone_number_id = (int) $co_responder_contact_mobile_phone_number_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `change_order_id` ASC, `change_order_response_sequence_number` ASC, `change_order_response_type_id` ASC, `co_responder_contact_id` ASC, `co_responder_contact_company_office_id` ASC, `co_responder_phone_contact_company_office_phone_number_id` ASC, `co_responder_fax_contact_company_office_phone_number_id` ASC, `co_responder_contact_mobile_phone_number_id` ASC, `change_order_response_title` ASC, `change_order_response` ASC, `modified` ASC, `created` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpChangeOrderResponse = new ChangeOrderResponse($database);
			$sqlOrderByColumns = $tmpChangeOrderResponse->constructSqlOrderByColumns($arrOrderByAttributes);

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
	coresponses.*

FROM `change_order_responses` coresponses
WHERE coresponses.`co_responder_contact_mobile_phone_number_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `change_order_id` ASC, `change_order_response_sequence_number` ASC, `change_order_response_type_id` ASC, `co_responder_contact_id` ASC, `co_responder_contact_company_office_id` ASC, `co_responder_phone_contact_company_office_phone_number_id` ASC, `co_responder_fax_contact_company_office_phone_number_id` ASC, `co_responder_contact_mobile_phone_number_id` ASC, `change_order_response_title` ASC, `change_order_response` ASC, `modified` ASC, `created` ASC
		$arrValues = array($co_responder_contact_mobile_phone_number_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrChangeOrderResponsesByCoResponderContactMobilePhoneNumberId = array();
		while ($row = $db->fetch()) {
			$change_order_response_id = $row['id'];
			$changeOrderResponse = self::instantiateOrm($database, 'ChangeOrderResponse', $row, null, $change_order_response_id);
			/* @var $changeOrderResponse ChangeOrderResponse */
			$arrChangeOrderResponsesByCoResponderContactMobilePhoneNumberId[$change_order_response_id] = $changeOrderResponse;
		}

		$db->free_result();

		self::$_arrChangeOrderResponsesByCoResponderContactMobilePhoneNumberId = $arrChangeOrderResponsesByCoResponderContactMobilePhoneNumberId;

		return $arrChangeOrderResponsesByCoResponderContactMobilePhoneNumberId;
	}

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all change_order_responses records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllChangeOrderResponses($database, Input $options=null)
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
			self::$_arrAllChangeOrderResponses = null;
		}

		$arrAllChangeOrderResponses = self::$_arrAllChangeOrderResponses;
		if (isset($arrAllChangeOrderResponses) && !empty($arrAllChangeOrderResponses)) {
			return $arrAllChangeOrderResponses;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `change_order_id` ASC, `change_order_response_sequence_number` ASC, `change_order_response_type_id` ASC, `co_responder_contact_id` ASC, `co_responder_contact_company_office_id` ASC, `co_responder_phone_contact_company_office_phone_number_id` ASC, `co_responder_fax_contact_company_office_phone_number_id` ASC, `co_responder_contact_mobile_phone_number_id` ASC, `change_order_response_title` ASC, `change_order_response` ASC, `modified` ASC, `created` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpChangeOrderResponse = new ChangeOrderResponse($database);
			$sqlOrderByColumns = $tmpChangeOrderResponse->constructSqlOrderByColumns($arrOrderByAttributes);

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
	coresponses.*

FROM `change_order_responses` coresponses{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `change_order_id` ASC, `change_order_response_sequence_number` ASC, `change_order_response_type_id` ASC, `co_responder_contact_id` ASC, `co_responder_contact_company_office_id` ASC, `co_responder_phone_contact_company_office_phone_number_id` ASC, `co_responder_fax_contact_company_office_phone_number_id` ASC, `co_responder_contact_mobile_phone_number_id` ASC, `change_order_response_title` ASC, `change_order_response` ASC, `modified` ASC, `created` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllChangeOrderResponses = array();
		while ($row = $db->fetch()) {
			$change_order_response_id = $row['id'];
			$changeOrderResponse = self::instantiateOrm($database, 'ChangeOrderResponse', $row, null, $change_order_response_id);
			/* @var $changeOrderResponse ChangeOrderResponse */
			$arrAllChangeOrderResponses[$change_order_response_id] = $changeOrderResponse;
		}

		$db->free_result();

		self::$_arrAllChangeOrderResponses = $arrAllChangeOrderResponses;

		return $arrAllChangeOrderResponses;
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
INTO `change_order_responses`
(`change_order_id`, `change_order_response_sequence_number`, `change_order_response_type_id`, `co_responder_contact_id`, `co_responder_contact_company_office_id`, `co_responder_phone_contact_company_office_phone_number_id`, `co_responder_fax_contact_company_office_phone_number_id`, `co_responder_contact_mobile_phone_number_id`, `change_order_response_title`, `change_order_response`, `modified`, `created`)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
ON DUPLICATE KEY UPDATE `change_order_response_type_id` = ?, `co_responder_contact_id` = ?, `co_responder_contact_company_office_id` = ?, `co_responder_phone_contact_company_office_phone_number_id` = ?, `co_responder_fax_contact_company_office_phone_number_id` = ?, `co_responder_contact_mobile_phone_number_id` = ?, `change_order_response_title` = ?, `change_order_response` = ?, `modified` = ?, `created` = ?
";
		$arrValues = array($this->change_order_id, $this->change_order_response_sequence_number, $this->change_order_response_type_id, $this->co_responder_contact_id, $this->co_responder_contact_company_office_id, $this->co_responder_phone_contact_company_office_phone_number_id, $this->co_responder_fax_contact_company_office_phone_number_id, $this->co_responder_contact_mobile_phone_number_id, $this->change_order_response_title, $this->change_order_response, $this->modified, $this->created, $this->change_order_response_type_id, $this->co_responder_contact_id, $this->co_responder_contact_company_office_id, $this->co_responder_phone_contact_company_office_phone_number_id, $this->co_responder_fax_contact_company_office_phone_number_id, $this->co_responder_contact_mobile_phone_number_id, $this->change_order_response_title, $this->change_order_response, $this->modified, $this->created);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$change_order_response_id = $db->insertId;
		$db->free_result();

		return $change_order_response_id;
	}

	// Save: insert ignore
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

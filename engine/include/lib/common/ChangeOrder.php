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
 * ChangeOrder.
 *
 * @category   Framework
 * @package    ChangeOrder
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');
require_once('lib/common/DrawItems.php');
class ChangeOrder extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'ChangeOrder';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'change_orders';

	/**
	 * Singular version of the table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_tableNameSingular = 'change_order';

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
	 * unique index `unique_co` (`project_id`,`co_sequence_number`) comment 'One Project can have many COs with a sequence number.'
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_co' => array(
			'project_id' => 'int',
			'co_sequence_number' => 'int'
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
		'id' => 'change_order_id',

		'project_id' => 'project_id',
		'contracting_entity_id' => 'contracting_entity_id',
		'co_sequence_number' => 'co_sequence_number',
		'co_type_prefix' => 'co_type_prefix',

		'co_custom_sequence_number' => 'co_custom_sequence_number',
		'co_scheduled_value' => 'co_scheduled_value',
		'co_delay_days' => 'co_delay_days',
		'change_order_type_id' => 'change_order_type_id',
		'change_order_status_id' => 'change_order_status_id',
		'change_order_priority_id' => 'change_order_priority_id',
		'co_file_manager_file_id' => 'co_file_manager_file_id',
		'co_cost_code_id' => 'co_cost_code_id',
		'co_creator_contact_id' => 'co_creator_contact_id',
		'co_creator_contact_company_office_id' => 'co_creator_contact_company_office_id',
		'co_creator_phone_contact_company_office_phone_number_id' => 'co_creator_phone_contact_company_office_phone_number_id',
		'co_creator_fax_contact_company_office_phone_number_id' => 'co_creator_fax_contact_company_office_phone_number_id',
		'co_creator_contact_mobile_phone_number_id' => 'co_creator_contact_mobile_phone_number_id',
		'co_recipient_contact_id' => 'co_recipient_contact_id',
		'co_recipient_contact_company_office_id' => 'co_recipient_contact_company_office_id',
		'co_recipient_phone_contact_company_office_phone_number_id' => 'co_recipient_phone_contact_company_office_phone_number_id',
		'co_recipient_fax_contact_company_office_phone_number_id' => 'co_recipient_fax_contact_company_office_phone_number_id',
		'co_recipient_contact_mobile_phone_number_id' => 'co_recipient_contact_mobile_phone_number_id',
		'co_initiator_contact_id' => 'co_initiator_contact_id',
		'co_initiator_contact_company_office_id' => 'co_initiator_contact_company_office_id',
		'co_initiator_phone_contact_company_office_phone_number_id' => 'co_initiator_phone_contact_company_office_phone_number_id',
		'co_initiator_fax_contact_company_office_phone_number_id' => 'co_initiator_fax_contact_company_office_phone_number_id',
		'co_initiator_contact_mobile_phone_number_id' => 'co_initiator_contact_mobile_phone_number_id',

		'co_signator_contact_id' => 'co_signator_contact_id',
		'co_title' => 'co_title',
		'co_plan_page_reference' => 'co_plan_page_reference',
		'co_statement' => 'co_statement',
		'created' => 'created',
		'co_revised_project_completion_date' => 'co_revised_project_completion_date',
		'co_closed_date' => 'co_closed_date',
		'co_submitted_date' => 'co_submitted_date',
		'co_approved_date' => 'co_approved_date',
		'COR_created' => 'COR_created',

		'co_subtotal' => 'co_subtotal',
		'co_genper' => 'co_genper',
		'co_gentotal' => 'co_gentotal',
		'co_buildper' => 'co_buildper',
		'co_buildtotal' => 'co_buildtotal',
		'co_insuranceper' => 'co_insuranceper',
		'co_insurancetotal' => 'co_insurancetotal',
		'co_total' => 'co_total'


	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $change_order_id;

	public $project_id;
	public $contracting_entity_id;
	public $co_sequence_number;
	public $co_type_prefix;

	public $co_custom_sequence_number;
	public $co_scheduled_value;
	public $co_delay_days;
	public $change_order_type_id;
	public $change_order_status_id;
	public $change_order_priority_id;
	public $co_file_manager_file_id;
	public $co_cost_code_id;
	public $co_creator_contact_id;
	public $co_creator_contact_company_office_id;
	public $co_creator_phone_contact_company_office_phone_number_id;
	public $co_creator_fax_contact_company_office_phone_number_id;
	public $co_creator_contact_mobile_phone_number_id;
	public $co_recipient_contact_id;
	public $co_recipient_contact_company_office_id;
	public $co_recipient_phone_contact_company_office_phone_number_id;
	public $co_recipient_fax_contact_company_office_phone_number_id;
	public $co_recipient_contact_mobile_phone_number_id;
	public $co_initiator_contact_id;
	public $co_initiator_contact_company_office_id;
	public $co_initiator_phone_contact_company_office_phone_number_id;
	public $co_initiator_fax_contact_company_office_phone_number_id;
	public $co_initiator_contact_mobile_phone_number_id;

	public $co_signator_contact_id;
	public $co_title;
	public $co_plan_page_reference;
	public $co_statement;
	public $created;
	public $co_revised_project_completion_date;
	public $co_closed_date;
	public $co_submitted_date;
	public $co_approved_date;
	public $COR_created;

	public $co_subtotal;
	public $co_genper;
	public $co_gentotal;
	public $co_buildper;
	public $co_buildtotal;
	public $co_insuranceper;
	public $co_insurancetotal;
	public $co_total;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties
	public $escaped_co_custom_sequence_number;
	public $escaped_co_title;
	public $escaped_co_plan_page_reference;
	public $escaped_co_statement;

	// HTML ENTITY ENCODED NL2BR ORM string properties
	public $escaped_co_custom_sequence_number_nl2br;
	public $escaped_co_title_nl2br;
	public $escaped_co_plan_page_reference_nl2br;
	public $escaped_co_statement_nl2br;

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)
	protected static $_arrChangeOrdersByProjectId;
	protected static $_arrChangeOrdersByChangeOrderTypeId;
	protected static $_arrChangeOrdersByChangeOrderStatusId;
	protected static $_arrChangeOrdersByChangeOrderPriorityId;
	protected static $_arrChangeOrdersByCoFileManagerFileId;
	protected static $_arrChangeOrdersByCoCostCodeId;
	protected static $_arrChangeOrdersByCoCreatorContactId;
	protected static $_arrChangeOrdersByCoCreatorContactCompanyOfficeId;
	protected static $_arrChangeOrdersByCoCreatorPhoneContactCompanyOfficePhoneNumberId;
	protected static $_arrChangeOrdersByCoCreatorFaxContactCompanyOfficePhoneNumberId;
	protected static $_arrChangeOrdersByCoCreatorContactMobilePhoneNumberId;
	protected static $_arrChangeOrdersByCoRecipientContactId;
	protected static $_arrChangeOrdersByCoRecipientContactCompanyOfficeId;
	protected static $_arrChangeOrdersByCoRecipientPhoneContactCompanyOfficePhoneNumberId;
	protected static $_arrChangeOrdersByCoRecipientFaxContactCompanyOfficePhoneNumberId;
	protected static $_arrChangeOrdersByCoRecipientContactMobilePhoneNumberId;
	protected static $_arrChangeOrdersByCoInitiatorContactId;
	protected static $_arrChangeOrdersByCoInitiatorContactCompanyOfficeId;
	protected static $_arrChangeOrdersByCoInitiatorPhoneContactCompanyOfficePhoneNumberId;
	protected static $_arrChangeOrdersByCoInitiatorFaxContactCompanyOfficePhoneNumberId;
	protected static $_arrChangeOrdersByCoInitiatorContactMobilePhoneNumberId;
	protected static $_arrChangeOrderCostCodeById;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllChangeOrders;

	// Foreign Key Objects
	private $_project;
	private $_changeOrderType;
	private $_changeOrderStatus;
	private $_changeOrderPriority;
	private $_coFileManagerFile;
	private $_coCostCode;
	private $_coCreatorContact;
	private $_coCreatorContactCompanyOffice;
	private $_coCreatorPhoneContactCompanyOfficePhoneNumber;
	private $_coCreatorFaxContactCompanyOfficePhoneNumber;
	private $_coCreatorContactMobilePhoneNumber;
	private $_coRecipientContact;
	private $_coRecipientContactCompanyOffice;
	private $_coRecipientPhoneContactCompanyOfficePhoneNumber;
	private $_coRecipientFaxContactCompanyOfficePhoneNumber;
	private $_coRecipientContactMobilePhoneNumber;
	private $_coInitiatorContact;
	private $_coInitiatorContactCompanyOffice;
	private $_coInitiatorPhoneContactCompanyOfficePhoneNumber;
	private $_coInitiatorFaxContactCompanyOfficePhoneNumber;
	private $_coInitiatorContactMobilePhoneNumber;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='change_orders')
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

	public function getChangeOrderType()
	{
		if (isset($this->_changeOrderType)) {
			return $this->_changeOrderType;
		} else {
			return null;
		}
	}

	public function setChangeOrderType($changeOrderType)
	{
		$this->_changeOrderType = $changeOrderType;
	}

	public function getChangeOrderStatus()
	{
		if (isset($this->_changeOrderStatus)) {
			return $this->_changeOrderStatus;
		} else {
			return null;
		}
	}

	public function setChangeOrderStatus($changeOrderStatus)
	{
		$this->_changeOrderStatus = $changeOrderStatus;
	}

	public function getChangeOrderPriority()
	{
		if (isset($this->_changeOrderPriority)) {
			return $this->_changeOrderPriority;
		} else {
			return null;
		}
	}

	public function setChangeOrderPriority($changeOrderPriority)
	{
		$this->_changeOrderPriority = $changeOrderPriority;
	}

	public function getCoFileManagerFile()
	{
		if (isset($this->_coFileManagerFile)) {
			return $this->_coFileManagerFile;
		} else {
			return null;
		}
	}

	public function setCoFileManagerFile($coFileManagerFile)
	{
		$this->_coFileManagerFile = $coFileManagerFile;
	}

	public function getCoCostCode()
	{
		if (isset($this->_coCostCode)) {
			return $this->_coCostCode;
		} else {
			return null;
		}
	}

	public function setCoCostCode($coCostCode)
	{
		$this->_coCostCode = $coCostCode;
	}

	public function getCoCreatorContact()
	{
		if (isset($this->_coCreatorContact)) {
			return $this->_coCreatorContact;
		} else {
			return null;
		}
	}

	public function setCoCreatorContact($coCreatorContact)
	{
		$this->_coCreatorContact = $coCreatorContact;
	}

	public function getCoCreatorContactCompanyOffice()
	{
		if (isset($this->_coCreatorContactCompanyOffice)) {
			return $this->_coCreatorContactCompanyOffice;
		} else {
			return null;
		}
	}

	public function setCoCreatorContactCompanyOffice($coCreatorContactCompanyOffice)
	{
		$this->_coCreatorContactCompanyOffice = $coCreatorContactCompanyOffice;
	}

	public function getCoCreatorPhoneContactCompanyOfficePhoneNumber()
	{
		if (isset($this->_coCreatorPhoneContactCompanyOfficePhoneNumber)) {
			return $this->_coCreatorPhoneContactCompanyOfficePhoneNumber;
		} else {
			return null;
		}
	}

	public function setCoCreatorPhoneContactCompanyOfficePhoneNumber($coCreatorPhoneContactCompanyOfficePhoneNumber)
	{
		$this->_coCreatorPhoneContactCompanyOfficePhoneNumber = $coCreatorPhoneContactCompanyOfficePhoneNumber;
	}

	public function getCoCreatorFaxContactCompanyOfficePhoneNumber()
	{
		if (isset($this->_coCreatorFaxContactCompanyOfficePhoneNumber)) {
			return $this->_coCreatorFaxContactCompanyOfficePhoneNumber;
		} else {
			return null;
		}
	}

	public function setCoCreatorFaxContactCompanyOfficePhoneNumber($coCreatorFaxContactCompanyOfficePhoneNumber)
	{
		$this->_coCreatorFaxContactCompanyOfficePhoneNumber = $coCreatorFaxContactCompanyOfficePhoneNumber;
	}

	public function getCoCreatorContactMobilePhoneNumber()
	{
		if (isset($this->_coCreatorContactMobilePhoneNumber)) {
			return $this->_coCreatorContactMobilePhoneNumber;
		} else {
			return null;
		}
	}

	public function setCoCreatorContactMobilePhoneNumber($coCreatorContactMobilePhoneNumber)
	{
		$this->_coCreatorContactMobilePhoneNumber = $coCreatorContactMobilePhoneNumber;
	}

	public function getCoRecipientContact()
	{
		if (isset($this->_coRecipientContact)) {
			return $this->_coRecipientContact;
		} else {
			return null;
		}
	}

	public function setCoRecipientContact($coRecipientContact)
	{
		$this->_coRecipientContact = $coRecipientContact;
	}

	public function getCoRecipientContactCompanyOffice()
	{
		if (isset($this->_coRecipientContactCompanyOffice)) {
			return $this->_coRecipientContactCompanyOffice;
		} else {
			return null;
		}
	}

	public function setCoRecipientContactCompanyOffice($coRecipientContactCompanyOffice)
	{
		$this->_coRecipientContactCompanyOffice = $coRecipientContactCompanyOffice;
	}

	public function getCoRecipientPhoneContactCompanyOfficePhoneNumber()
	{
		if (isset($this->_coRecipientPhoneContactCompanyOfficePhoneNumber)) {
			return $this->_coRecipientPhoneContactCompanyOfficePhoneNumber;
		} else {
			return null;
		}
	}

	public function setCoRecipientPhoneContactCompanyOfficePhoneNumber($coRecipientPhoneContactCompanyOfficePhoneNumber)
	{
		$this->_coRecipientPhoneContactCompanyOfficePhoneNumber = $coRecipientPhoneContactCompanyOfficePhoneNumber;
	}

	public function getCoRecipientFaxContactCompanyOfficePhoneNumber()
	{
		if (isset($this->_coRecipientFaxContactCompanyOfficePhoneNumber)) {
			return $this->_coRecipientFaxContactCompanyOfficePhoneNumber;
		} else {
			return null;
		}
	}

	public function setCoRecipientFaxContactCompanyOfficePhoneNumber($coRecipientFaxContactCompanyOfficePhoneNumber)
	{
		$this->_coRecipientFaxContactCompanyOfficePhoneNumber = $coRecipientFaxContactCompanyOfficePhoneNumber;
	}

	public function getCoRecipientContactMobilePhoneNumber()
	{
		if (isset($this->_coRecipientContactMobilePhoneNumber)) {
			return $this->_coRecipientContactMobilePhoneNumber;
		} else {
			return null;
		}
	}

	public function setCoRecipientContactMobilePhoneNumber($coRecipientContactMobilePhoneNumber)
	{
		$this->_coRecipientContactMobilePhoneNumber = $coRecipientContactMobilePhoneNumber;
	}

	public function getCoInitiatorContact()
	{
		if (isset($this->_coInitiatorContact)) {
			return $this->_coInitiatorContact;
		} else {
			return null;
		}
	}

	public function setCoInitiatorContact($coInitiatorContact)
	{
		$this->_coInitiatorContact = $coInitiatorContact;
	}

	public function getCoInitiatorContactCompanyOffice()
	{
		if (isset($this->_coInitiatorContactCompanyOffice)) {
			return $this->_coInitiatorContactCompanyOffice;
		} else {
			return null;
		}
	}

	public function setCoInitiatorContactCompanyOffice($coInitiatorContactCompanyOffice)
	{
		$this->_coInitiatorContactCompanyOffice = $coInitiatorContactCompanyOffice;
	}

	public function getCoInitiatorPhoneContactCompanyOfficePhoneNumber()
	{
		if (isset($this->_coInitiatorPhoneContactCompanyOfficePhoneNumber)) {
			return $this->_coInitiatorPhoneContactCompanyOfficePhoneNumber;
		} else {
			return null;
		}
	}

	public function setCoInitiatorPhoneContactCompanyOfficePhoneNumber($coInitiatorPhoneContactCompanyOfficePhoneNumber)
	{
		$this->_coInitiatorPhoneContactCompanyOfficePhoneNumber = $coInitiatorPhoneContactCompanyOfficePhoneNumber;
	}

	public function getCoInitiatorFaxContactCompanyOfficePhoneNumber()
	{
		if (isset($this->_coInitiatorFaxContactCompanyOfficePhoneNumber)) {
			return $this->_coInitiatorFaxContactCompanyOfficePhoneNumber;
		} else {
			return null;
		}
	}

	public function setCoInitiatorFaxContactCompanyOfficePhoneNumber($coInitiatorFaxContactCompanyOfficePhoneNumber)
	{
		$this->_coInitiatorFaxContactCompanyOfficePhoneNumber = $coInitiatorFaxContactCompanyOfficePhoneNumber;
	}

	public function getCoInitiatorContactMobilePhoneNumber()
	{
		if (isset($this->_coInitiatorContactMobilePhoneNumber)) {
			return $this->_coInitiatorContactMobilePhoneNumber;
		} else {
			return null;
		}
	}

	public function setCoInitiatorContactMobilePhoneNumber($coInitiatorContactMobilePhoneNumber)
	{
		$this->_coInitiatorContactMobilePhoneNumber = $coInitiatorContactMobilePhoneNumber;
	}

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)
	public static function getArrChangeOrdersByProjectId()
	{
		if (isset(self::$_arrChangeOrdersByProjectId)) {
			return self::$_arrChangeOrdersByProjectId;
		} else {
			return null;
		}
	}

	public static function setArrChangeOrdersByProjectId($arrChangeOrdersByProjectId)
	{
		self::$_arrChangeOrdersByProjectId = $arrChangeOrdersByProjectId;
	}

	public static function getArrChangeOrdersByChangeOrderTypeId()
	{
		if (isset(self::$_arrChangeOrdersByChangeOrderTypeId)) {
			return self::$_arrChangeOrdersByChangeOrderTypeId;
		} else {
			return null;
		}
	}

	public static function setArrChangeOrdersByChangeOrderTypeId($arrChangeOrdersByChangeOrderTypeId)
	{
		self::$_arrChangeOrdersByChangeOrderTypeId = $arrChangeOrdersByChangeOrderTypeId;
	}

	public static function getArrChangeOrdersByChangeOrderStatusId()
	{
		if (isset(self::$_arrChangeOrdersByChangeOrderStatusId)) {
			return self::$_arrChangeOrdersByChangeOrderStatusId;
		} else {
			return null;
		}
	}

	public static function setArrChangeOrdersByChangeOrderStatusId($arrChangeOrdersByChangeOrderStatusId)
	{
		self::$_arrChangeOrdersByChangeOrderStatusId = $arrChangeOrdersByChangeOrderStatusId;
	}

	public static function getArrChangeOrdersByChangeOrderPriorityId()
	{
		if (isset(self::$_arrChangeOrdersByChangeOrderPriorityId)) {
			return self::$_arrChangeOrdersByChangeOrderPriorityId;
		} else {
			return null;
		}
	}

	public static function setArrChangeOrdersByChangeOrderPriorityId($arrChangeOrdersByChangeOrderPriorityId)
	{
		self::$_arrChangeOrdersByChangeOrderPriorityId = $arrChangeOrdersByChangeOrderPriorityId;
	}

	public static function getArrChangeOrdersByCoFileManagerFileId()
	{
		if (isset(self::$_arrChangeOrdersByCoFileManagerFileId)) {
			return self::$_arrChangeOrdersByCoFileManagerFileId;
		} else {
			return null;
		}
	}

	public static function setArrChangeOrdersByCoFileManagerFileId($arrChangeOrdersByCoFileManagerFileId)
	{
		self::$_arrChangeOrdersByCoFileManagerFileId = $arrChangeOrdersByCoFileManagerFileId;
	}

	public static function getArrChangeOrdersByCoCostCodeId()
	{
		if (isset(self::$_arrChangeOrdersByCoCostCodeId)) {
			return self::$_arrChangeOrdersByCoCostCodeId;
		} else {
			return null;
		}
	}

	public static function setArrChangeOrdersByCoCostCodeId($arrChangeOrdersByCoCostCodeId)
	{
		self::$_arrChangeOrdersByCoCostCodeId = $arrChangeOrdersByCoCostCodeId;
	}

	public static function getArrChangeOrdersByCoCreatorContactId()
	{
		if (isset(self::$_arrChangeOrdersByCoCreatorContactId)) {
			return self::$_arrChangeOrdersByCoCreatorContactId;
		} else {
			return null;
		}
	}

	public static function setArrChangeOrdersByCoCreatorContactId($arrChangeOrdersByCoCreatorContactId)
	{
		self::$_arrChangeOrdersByCoCreatorContactId = $arrChangeOrdersByCoCreatorContactId;
	}

	public static function getArrChangeOrdersByCoCreatorContactCompanyOfficeId()
	{
		if (isset(self::$_arrChangeOrdersByCoCreatorContactCompanyOfficeId)) {
			return self::$_arrChangeOrdersByCoCreatorContactCompanyOfficeId;
		} else {
			return null;
		}
	}

	public static function setArrChangeOrdersByCoCreatorContactCompanyOfficeId($arrChangeOrdersByCoCreatorContactCompanyOfficeId)
	{
		self::$_arrChangeOrdersByCoCreatorContactCompanyOfficeId = $arrChangeOrdersByCoCreatorContactCompanyOfficeId;
	}

	public static function getArrChangeOrdersByCoCreatorPhoneContactCompanyOfficePhoneNumberId()
	{
		if (isset(self::$_arrChangeOrdersByCoCreatorPhoneContactCompanyOfficePhoneNumberId)) {
			return self::$_arrChangeOrdersByCoCreatorPhoneContactCompanyOfficePhoneNumberId;
		} else {
			return null;
		}
	}

	public static function setArrChangeOrdersByCoCreatorPhoneContactCompanyOfficePhoneNumberId($arrChangeOrdersByCoCreatorPhoneContactCompanyOfficePhoneNumberId)
	{
		self::$_arrChangeOrdersByCoCreatorPhoneContactCompanyOfficePhoneNumberId = $arrChangeOrdersByCoCreatorPhoneContactCompanyOfficePhoneNumberId;
	}

	public static function getArrChangeOrdersByCoCreatorFaxContactCompanyOfficePhoneNumberId()
	{
		if (isset(self::$_arrChangeOrdersByCoCreatorFaxContactCompanyOfficePhoneNumberId)) {
			return self::$_arrChangeOrdersByCoCreatorFaxContactCompanyOfficePhoneNumberId;
		} else {
			return null;
		}
	}

	public static function setArrChangeOrdersByCoCreatorFaxContactCompanyOfficePhoneNumberId($arrChangeOrdersByCoCreatorFaxContactCompanyOfficePhoneNumberId)
	{
		self::$_arrChangeOrdersByCoCreatorFaxContactCompanyOfficePhoneNumberId = $arrChangeOrdersByCoCreatorFaxContactCompanyOfficePhoneNumberId;
	}

	public static function getArrChangeOrdersByCoCreatorContactMobilePhoneNumberId()
	{
		if (isset(self::$_arrChangeOrdersByCoCreatorContactMobilePhoneNumberId)) {
			return self::$_arrChangeOrdersByCoCreatorContactMobilePhoneNumberId;
		} else {
			return null;
		}
	}

	public static function setArrChangeOrdersByCoCreatorContactMobilePhoneNumberId($arrChangeOrdersByCoCreatorContactMobilePhoneNumberId)
	{
		self::$_arrChangeOrdersByCoCreatorContactMobilePhoneNumberId = $arrChangeOrdersByCoCreatorContactMobilePhoneNumberId;
	}

	public static function getArrChangeOrdersByCoRecipientContactId()
	{
		if (isset(self::$_arrChangeOrdersByCoRecipientContactId)) {
			return self::$_arrChangeOrdersByCoRecipientContactId;
		} else {
			return null;
		}
	}

	public static function setArrChangeOrdersByCoRecipientContactId($arrChangeOrdersByCoRecipientContactId)
	{
		self::$_arrChangeOrdersByCoRecipientContactId = $arrChangeOrdersByCoRecipientContactId;
	}

	public static function getArrChangeOrdersByCoRecipientContactCompanyOfficeId()
	{
		if (isset(self::$_arrChangeOrdersByCoRecipientContactCompanyOfficeId)) {
			return self::$_arrChangeOrdersByCoRecipientContactCompanyOfficeId;
		} else {
			return null;
		}
	}

	public static function setArrChangeOrdersByCoRecipientContactCompanyOfficeId($arrChangeOrdersByCoRecipientContactCompanyOfficeId)
	{
		self::$_arrChangeOrdersByCoRecipientContactCompanyOfficeId = $arrChangeOrdersByCoRecipientContactCompanyOfficeId;
	}

	public static function getArrChangeOrdersByCoRecipientPhoneContactCompanyOfficePhoneNumberId()
	{
		if (isset(self::$_arrChangeOrdersByCoRecipientPhoneContactCompanyOfficePhoneNumberId)) {
			return self::$_arrChangeOrdersByCoRecipientPhoneContactCompanyOfficePhoneNumberId;
		} else {
			return null;
		}
	}

	public static function setArrChangeOrdersByCoRecipientPhoneContactCompanyOfficePhoneNumberId($arrChangeOrdersByCoRecipientPhoneContactCompanyOfficePhoneNumberId)
	{
		self::$_arrChangeOrdersByCoRecipientPhoneContactCompanyOfficePhoneNumberId = $arrChangeOrdersByCoRecipientPhoneContactCompanyOfficePhoneNumberId;
	}

	public static function getArrChangeOrdersByCoRecipientFaxContactCompanyOfficePhoneNumberId()
	{
		if (isset(self::$_arrChangeOrdersByCoRecipientFaxContactCompanyOfficePhoneNumberId)) {
			return self::$_arrChangeOrdersByCoRecipientFaxContactCompanyOfficePhoneNumberId;
		} else {
			return null;
		}
	}

	public static function setArrChangeOrdersByCoRecipientFaxContactCompanyOfficePhoneNumberId($arrChangeOrdersByCoRecipientFaxContactCompanyOfficePhoneNumberId)
	{
		self::$_arrChangeOrdersByCoRecipientFaxContactCompanyOfficePhoneNumberId = $arrChangeOrdersByCoRecipientFaxContactCompanyOfficePhoneNumberId;
	}

	public static function getArrChangeOrdersByCoRecipientContactMobilePhoneNumberId()
	{
		if (isset(self::$_arrChangeOrdersByCoRecipientContactMobilePhoneNumberId)) {
			return self::$_arrChangeOrdersByCoRecipientContactMobilePhoneNumberId;
		} else {
			return null;
		}
	}

	public static function setArrChangeOrdersByCoRecipientContactMobilePhoneNumberId($arrChangeOrdersByCoRecipientContactMobilePhoneNumberId)
	{
		self::$_arrChangeOrdersByCoRecipientContactMobilePhoneNumberId = $arrChangeOrdersByCoRecipientContactMobilePhoneNumberId;
	}

	public static function getArrChangeOrdersByCoInitiatorContactId()
	{
		if (isset(self::$_arrChangeOrdersByCoInitiatorContactId)) {
			return self::$_arrChangeOrdersByCoInitiatorContactId;
		} else {
			return null;
		}
	}

	public static function setArrChangeOrdersByCoInitiatorContactId($arrChangeOrdersByCoInitiatorContactId)
	{
		self::$_arrChangeOrdersByCoInitiatorContactId = $arrChangeOrdersByCoInitiatorContactId;
	}

	public static function getArrChangeOrdersByCoInitiatorContactCompanyOfficeId()
	{
		if (isset(self::$_arrChangeOrdersByCoInitiatorContactCompanyOfficeId)) {
			return self::$_arrChangeOrdersByCoInitiatorContactCompanyOfficeId;
		} else {
			return null;
		}
	}

	public static function setArrChangeOrdersByCoInitiatorContactCompanyOfficeId($arrChangeOrdersByCoInitiatorContactCompanyOfficeId)
	{
		self::$_arrChangeOrdersByCoInitiatorContactCompanyOfficeId = $arrChangeOrdersByCoInitiatorContactCompanyOfficeId;
	}

	public static function getArrChangeOrdersByCoInitiatorPhoneContactCompanyOfficePhoneNumberId()
	{
		if (isset(self::$_arrChangeOrdersByCoInitiatorPhoneContactCompanyOfficePhoneNumberId)) {
			return self::$_arrChangeOrdersByCoInitiatorPhoneContactCompanyOfficePhoneNumberId;
		} else {
			return null;
		}
	}

	public static function setArrChangeOrdersByCoInitiatorPhoneContactCompanyOfficePhoneNumberId($arrChangeOrdersByCoInitiatorPhoneContactCompanyOfficePhoneNumberId)
	{
		self::$_arrChangeOrdersByCoInitiatorPhoneContactCompanyOfficePhoneNumberId = $arrChangeOrdersByCoInitiatorPhoneContactCompanyOfficePhoneNumberId;
	}

	public static function getArrChangeOrdersByCoInitiatorFaxContactCompanyOfficePhoneNumberId()
	{
		if (isset(self::$_arrChangeOrdersByCoInitiatorFaxContactCompanyOfficePhoneNumberId)) {
			return self::$_arrChangeOrdersByCoInitiatorFaxContactCompanyOfficePhoneNumberId;
		} else {
			return null;
		}
	}

	public static function setArrChangeOrdersByCoInitiatorFaxContactCompanyOfficePhoneNumberId($arrChangeOrdersByCoInitiatorFaxContactCompanyOfficePhoneNumberId)
	{
		self::$_arrChangeOrdersByCoInitiatorFaxContactCompanyOfficePhoneNumberId = $arrChangeOrdersByCoInitiatorFaxContactCompanyOfficePhoneNumberId;
	}

	public static function getArrChangeOrdersByCoInitiatorContactMobilePhoneNumberId()
	{
		if (isset(self::$_arrChangeOrdersByCoInitiatorContactMobilePhoneNumberId)) {
			return self::$_arrChangeOrdersByCoInitiatorContactMobilePhoneNumberId;
		} else {
			return null;
		}
	}

	public static function setArrChangeOrdersByCoInitiatorContactMobilePhoneNumberId($arrChangeOrdersByCoInitiatorContactMobilePhoneNumberId)
	{
		self::$_arrChangeOrdersByCoInitiatorContactMobilePhoneNumberId = $arrChangeOrdersByCoInitiatorContactMobilePhoneNumberId;
	}

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllChangeOrders()
	{
		if (isset(self::$_arrAllChangeOrders)) {
			return self::$_arrAllChangeOrders;
		} else {
			return null;
		}
	}

	public static function setArrAllChangeOrders($arrAllChangeOrders)
	{
		self::$_arrAllChangeOrders = $arrAllChangeOrders;
	}

	// Finder: Find By pk (a single auto int id or a single non auto int pk)
	/**
	 * PHP < 5.3.0
	 *
	 * @param string $database
	 * @param int $change_order_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findById($database, $change_order_id, $table='change_orders', $module='ChangeOrder')
	{
		$changeOrder = parent::findById($database, $change_order_id, $table, $module);

		return $changeOrder;
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Similar to FindById, but with SQL as starter code for more complex joins.
	 *
	 * @param string $database
	 * @param int $change_order_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findChangeOrderByIdExtended($database, $change_order_id)
	{
		$change_order_id = (int) $change_order_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	co_fk_p.`id` AS 'co_fk_p__project_id',
	co_fk_p.`project_type_id` AS 'co_fk_p__project_type_id',
	co_fk_p.`user_company_id` AS 'co_fk_p__user_company_id',
	co_fk_p.`user_custom_project_id` AS 'co_fk_p__user_custom_project_id',
	co_fk_p.`project_name` AS 'co_fk_p__project_name',
	co_fk_p.`project_owner_name` AS 'co_fk_p__project_owner_name',
	co_fk_p.`latitude` AS 'co_fk_p__latitude',
	co_fk_p.`longitude` AS 'co_fk_p__longitude',
	co_fk_p.`address_line_1` AS 'co_fk_p__address_line_1',
	co_fk_p.`address_line_2` AS 'co_fk_p__address_line_2',
	co_fk_p.`address_line_3` AS 'co_fk_p__address_line_3',
	co_fk_p.`address_line_4` AS 'co_fk_p__address_line_4',
	co_fk_p.`address_city` AS 'co_fk_p__address_city',
	co_fk_p.`address_county` AS 'co_fk_p__address_county',
	co_fk_p.`address_state_or_region` AS 'co_fk_p__address_state_or_region',
	co_fk_p.`address_postal_code` AS 'co_fk_p__address_postal_code',
	co_fk_p.`address_postal_code_extension` AS 'co_fk_p__address_postal_code_extension',
	co_fk_p.`address_country` AS 'co_fk_p__address_country',
	co_fk_p.`building_count` AS 'co_fk_p__building_count',
	co_fk_p.`unit_count` AS 'co_fk_p__unit_count',
	co_fk_p.`gross_square_footage` AS 'co_fk_p__gross_square_footage',
	co_fk_p.`net_rentable_square_footage` AS 'co_fk_p__net_rentable_square_footage',
	co_fk_p.`is_active_flag` AS 'co_fk_p__is_active_flag',
	co_fk_p.`public_plans_flag` AS 'co_fk_p__public_plans_flag',
	co_fk_p.`prevailing_wage_flag` AS 'co_fk_p__prevailing_wage_flag',
	co_fk_p.`city_business_license_required_flag` AS 'co_fk_p__city_business_license_required_flag',
	co_fk_p.`is_internal_flag` AS 'co_fk_p__is_internal_flag',
	co_fk_p.`project_contract_date` AS 'co_fk_p__project_contract_date',
	co_fk_p.`project_start_date` AS 'co_fk_p__project_start_date',
	co_fk_p.`project_completed_date` AS 'co_fk_p__project_completed_date',
	co_fk_p.`sort_order` AS 'co_fk_p__sort_order',

	co_fk_cot.`id` AS 'co_fk_cot__change_order_type_id',
	co_fk_cot.`change_order_type` AS 'co_fk_cot__change_order_type',
	co_fk_cot.`disabled_flag` AS 'co_fk_cot__disabled_flag',

	co_fk_cos.`id` AS 'co_fk_cos__change_order_status_id',
	co_fk_cos.`change_order_status` AS 'co_fk_cos__change_order_status',
	co_fk_cos.`disabled_flag` AS 'co_fk_cos__disabled_flag',

	co_fk_cop.`id` AS 'co_fk_cop__change_order_priority_id',
	co_fk_cop.`change_order_priority` AS 'co_fk_cop__change_order_priority',
	co_fk_cop.`disabled_flag` AS 'co_fk_cop__disabled_flag',

	co_fk_fmfiles.`id` AS 'co_fk_fmfiles__file_manager_file_id',
	co_fk_fmfiles.`user_company_id` AS 'co_fk_fmfiles__user_company_id',
	co_fk_fmfiles.`contact_id` AS 'co_fk_fmfiles__contact_id',
	co_fk_fmfiles.`project_id` AS 'co_fk_fmfiles__project_id',
	co_fk_fmfiles.`file_manager_folder_id` AS 'co_fk_fmfiles__file_manager_folder_id',
	co_fk_fmfiles.`file_location_id` AS 'co_fk_fmfiles__file_location_id',
	co_fk_fmfiles.`virtual_file_name` AS 'co_fk_fmfiles__virtual_file_name',
	co_fk_fmfiles.`version_number` AS 'co_fk_fmfiles__version_number',
	co_fk_fmfiles.`virtual_file_name_sha1` AS 'co_fk_fmfiles__virtual_file_name_sha1',
	co_fk_fmfiles.`virtual_file_mime_type` AS 'co_fk_fmfiles__virtual_file_mime_type',
	co_fk_fmfiles.`modified` AS 'co_fk_fmfiles__modified',
	co_fk_fmfiles.`created` AS 'co_fk_fmfiles__created',
	co_fk_fmfiles.`deleted_flag` AS 'co_fk_fmfiles__deleted_flag',
	co_fk_fmfiles.`directly_deleted_flag` AS 'co_fk_fmfiles__directly_deleted_flag',

	co_fk_codes.`id` AS 'co_fk_codes__cost_code_id',
	co_fk_codes.`cost_code_division_id` AS 'co_fk_codes__cost_code_division_id',
	co_fk_codes.`cost_code` AS 'co_fk_codes__cost_code',
	co_fk_codes.`cost_code_description` AS 'co_fk_codes__cost_code_description',
	co_fk_codes.`cost_code_description_abbreviation` AS 'co_fk_codes__cost_code_description_abbreviation',
	co_fk_codes.`sort_order` AS 'co_fk_codes__sort_order',
	co_fk_codes.`disabled_flag` AS 'co_fk_codes__disabled_flag',

	co_fk_creator_c.`id` AS 'co_fk_creator_c__contact_id',
	co_fk_creator_c.`user_company_id` AS 'co_fk_creator_c__user_company_id',
	co_fk_creator_c.`user_id` AS 'co_fk_creator_c__user_id',
	co_fk_creator_c.`contact_company_id` AS 'co_fk_creator_c__contact_company_id',
	co_fk_creator_c.`email` AS 'co_fk_creator_c__email',
	co_fk_creator_c.`name_prefix` AS 'co_fk_creator_c__name_prefix',
	co_fk_creator_c.`first_name` AS 'co_fk_creator_c__first_name',
	co_fk_creator_c.`additional_name` AS 'co_fk_creator_c__additional_name',
	co_fk_creator_c.`middle_name` AS 'co_fk_creator_c__middle_name',
	co_fk_creator_c.`last_name` AS 'co_fk_creator_c__last_name',
	co_fk_creator_c.`name_suffix` AS 'co_fk_creator_c__name_suffix',
	co_fk_creator_c.`title` AS 'co_fk_creator_c__title',
	co_fk_creator_c.`vendor_flag` AS 'co_fk_creator_c__vendor_flag',

	co_fk_creator_cco.`id` AS 'co_fk_creator_cco__contact_company_office_id',
	co_fk_creator_cco.`contact_company_id` AS 'co_fk_creator_cco__contact_company_id',
	co_fk_creator_cco.`office_nickname` AS 'co_fk_creator_cco__office_nickname',
	co_fk_creator_cco.`address_line_1` AS 'co_fk_creator_cco__address_line_1',
	co_fk_creator_cco.`address_line_2` AS 'co_fk_creator_cco__address_line_2',
	co_fk_creator_cco.`address_line_3` AS 'co_fk_creator_cco__address_line_3',
	co_fk_creator_cco.`address_line_4` AS 'co_fk_creator_cco__address_line_4',
	co_fk_creator_cco.`address_city` AS 'co_fk_creator_cco__address_city',
	co_fk_creator_cco.`address_county` AS 'co_fk_creator_cco__address_county',
	co_fk_creator_cco.`address_state_or_region` AS 'co_fk_creator_cco__address_state_or_region',
	co_fk_creator_cco.`address_postal_code` AS 'co_fk_creator_cco__address_postal_code',
	co_fk_creator_cco.`address_postal_code_extension` AS 'co_fk_creator_cco__address_postal_code_extension',
	co_fk_creator_cco.`address_country` AS 'co_fk_creator_cco__address_country',
	co_fk_creator_cco.`head_quarters_flag` AS 'co_fk_creator_cco__head_quarters_flag',
	co_fk_creator_cco.`address_validated_by_user_flag` AS 'co_fk_creator_cco__address_validated_by_user_flag',
	co_fk_creator_cco.`address_validated_by_web_service_flag` AS 'co_fk_creator_cco__address_validated_by_web_service_flag',
	co_fk_creator_cco.`address_validation_by_web_service_error_flag` AS 'co_fk_creator_cco__address_validation_by_web_service_error_flag',

	co_fk_creator_phone_ccopn.`id` AS 'co_fk_creator_phone_ccopn__contact_company_office_phone_number_id',
	co_fk_creator_phone_ccopn.`contact_company_office_id` AS 'co_fk_creator_phone_ccopn__contact_company_office_id',
	co_fk_creator_phone_ccopn.`phone_number_type_id` AS 'co_fk_creator_phone_ccopn__phone_number_type_id',
	co_fk_creator_phone_ccopn.`country_code` AS 'co_fk_creator_phone_ccopn__country_code',
	co_fk_creator_phone_ccopn.`area_code` AS 'co_fk_creator_phone_ccopn__area_code',
	co_fk_creator_phone_ccopn.`prefix` AS 'co_fk_creator_phone_ccopn__prefix',
	co_fk_creator_phone_ccopn.`number` AS 'co_fk_creator_phone_ccopn__number',
	co_fk_creator_phone_ccopn.`extension` AS 'co_fk_creator_phone_ccopn__extension',
	co_fk_creator_phone_ccopn.`itu` AS 'co_fk_creator_phone_ccopn__itu',

	co_fk_creator_fax_ccopn.`id` AS 'co_fk_creator_fax_ccopn__contact_company_office_phone_number_id',
	co_fk_creator_fax_ccopn.`contact_company_office_id` AS 'co_fk_creator_fax_ccopn__contact_company_office_id',
	co_fk_creator_fax_ccopn.`phone_number_type_id` AS 'co_fk_creator_fax_ccopn__phone_number_type_id',
	co_fk_creator_fax_ccopn.`country_code` AS 'co_fk_creator_fax_ccopn__country_code',
	co_fk_creator_fax_ccopn.`area_code` AS 'co_fk_creator_fax_ccopn__area_code',
	co_fk_creator_fax_ccopn.`prefix` AS 'co_fk_creator_fax_ccopn__prefix',
	co_fk_creator_fax_ccopn.`number` AS 'co_fk_creator_fax_ccopn__number',
	co_fk_creator_fax_ccopn.`extension` AS 'co_fk_creator_fax_ccopn__extension',
	co_fk_creator_fax_ccopn.`itu` AS 'co_fk_creator_fax_ccopn__itu',

	co_fk_creator_c_mobile_cpn.`id` AS 'co_fk_creator_c_mobile_cpn__contact_phone_number_id',
	co_fk_creator_c_mobile_cpn.`contact_id` AS 'co_fk_creator_c_mobile_cpn__contact_id',
	co_fk_creator_c_mobile_cpn.`phone_number_type_id` AS 'co_fk_creator_c_mobile_cpn__phone_number_type_id',
	co_fk_creator_c_mobile_cpn.`country_code` AS 'co_fk_creator_c_mobile_cpn__country_code',
	co_fk_creator_c_mobile_cpn.`area_code` AS 'co_fk_creator_c_mobile_cpn__area_code',
	co_fk_creator_c_mobile_cpn.`prefix` AS 'co_fk_creator_c_mobile_cpn__prefix',
	co_fk_creator_c_mobile_cpn.`number` AS 'co_fk_creator_c_mobile_cpn__number',
	co_fk_creator_c_mobile_cpn.`extension` AS 'co_fk_creator_c_mobile_cpn__extension',
	co_fk_creator_c_mobile_cpn.`itu` AS 'co_fk_creator_c_mobile_cpn__itu',

	co_fk_recipient_c.`id` AS 'co_fk_recipient_c__contact_id',
	co_fk_recipient_c.`user_company_id` AS 'co_fk_recipient_c__user_company_id',
	co_fk_recipient_c.`user_id` AS 'co_fk_recipient_c__user_id',
	co_fk_recipient_c.`contact_company_id` AS 'co_fk_recipient_c__contact_company_id',
	co_fk_recipient_c.`email` AS 'co_fk_recipient_c__email',
	co_fk_recipient_c.`name_prefix` AS 'co_fk_recipient_c__name_prefix',
	co_fk_recipient_c.`first_name` AS 'co_fk_recipient_c__first_name',
	co_fk_recipient_c.`additional_name` AS 'co_fk_recipient_c__additional_name',
	co_fk_recipient_c.`middle_name` AS 'co_fk_recipient_c__middle_name',
	co_fk_recipient_c.`last_name` AS 'co_fk_recipient_c__last_name',
	co_fk_recipient_c.`name_suffix` AS 'co_fk_recipient_c__name_suffix',
	co_fk_recipient_c.`title` AS 'co_fk_recipient_c__title',
	co_fk_recipient_c.`vendor_flag` AS 'co_fk_recipient_c__vendor_flag',

	co_fk_recipient_cco.`id` AS 'co_fk_recipient_cco__contact_company_office_id',
	co_fk_recipient_cco.`contact_company_id` AS 'co_fk_recipient_cco__contact_company_id',
	co_fk_recipient_cco.`office_nickname` AS 'co_fk_recipient_cco__office_nickname',
	co_fk_recipient_cco.`address_line_1` AS 'co_fk_recipient_cco__address_line_1',
	co_fk_recipient_cco.`address_line_2` AS 'co_fk_recipient_cco__address_line_2',
	co_fk_recipient_cco.`address_line_3` AS 'co_fk_recipient_cco__address_line_3',
	co_fk_recipient_cco.`address_line_4` AS 'co_fk_recipient_cco__address_line_4',
	co_fk_recipient_cco.`address_city` AS 'co_fk_recipient_cco__address_city',
	co_fk_recipient_cco.`address_county` AS 'co_fk_recipient_cco__address_county',
	co_fk_recipient_cco.`address_state_or_region` AS 'co_fk_recipient_cco__address_state_or_region',
	co_fk_recipient_cco.`address_postal_code` AS 'co_fk_recipient_cco__address_postal_code',
	co_fk_recipient_cco.`address_postal_code_extension` AS 'co_fk_recipient_cco__address_postal_code_extension',
	co_fk_recipient_cco.`address_country` AS 'co_fk_recipient_cco__address_country',
	co_fk_recipient_cco.`head_quarters_flag` AS 'co_fk_recipient_cco__head_quarters_flag',
	co_fk_recipient_cco.`address_validated_by_user_flag` AS 'co_fk_recipient_cco__address_validated_by_user_flag',
	co_fk_recipient_cco.`address_validated_by_web_service_flag` AS 'co_fk_recipient_cco__address_validated_by_web_service_flag',
	co_fk_recipient_cco.`address_validation_by_web_service_error_flag` AS 'co_fk_recipient_cco__address_validation_by_web_service_error_flag',

	co_fk_recipient_phone_ccopn.`id` AS 'co_fk_recipient_phone_ccopn__contact_company_office_phone_number_id',
	co_fk_recipient_phone_ccopn.`contact_company_office_id` AS 'co_fk_recipient_phone_ccopn__contact_company_office_id',
	co_fk_recipient_phone_ccopn.`phone_number_type_id` AS 'co_fk_recipient_phone_ccopn__phone_number_type_id',
	co_fk_recipient_phone_ccopn.`country_code` AS 'co_fk_recipient_phone_ccopn__country_code',
	co_fk_recipient_phone_ccopn.`area_code` AS 'co_fk_recipient_phone_ccopn__area_code',
	co_fk_recipient_phone_ccopn.`prefix` AS 'co_fk_recipient_phone_ccopn__prefix',
	co_fk_recipient_phone_ccopn.`number` AS 'co_fk_recipient_phone_ccopn__number',
	co_fk_recipient_phone_ccopn.`extension` AS 'co_fk_recipient_phone_ccopn__extension',
	co_fk_recipient_phone_ccopn.`itu` AS 'co_fk_recipient_phone_ccopn__itu',

	co_fk_recipient_fax_ccopn.`id` AS 'co_fk_recipient_fax_ccopn__contact_company_office_phone_number_id',
	co_fk_recipient_fax_ccopn.`contact_company_office_id` AS 'co_fk_recipient_fax_ccopn__contact_company_office_id',
	co_fk_recipient_fax_ccopn.`phone_number_type_id` AS 'co_fk_recipient_fax_ccopn__phone_number_type_id',
	co_fk_recipient_fax_ccopn.`country_code` AS 'co_fk_recipient_fax_ccopn__country_code',
	co_fk_recipient_fax_ccopn.`area_code` AS 'co_fk_recipient_fax_ccopn__area_code',
	co_fk_recipient_fax_ccopn.`prefix` AS 'co_fk_recipient_fax_ccopn__prefix',
	co_fk_recipient_fax_ccopn.`number` AS 'co_fk_recipient_fax_ccopn__number',
	co_fk_recipient_fax_ccopn.`extension` AS 'co_fk_recipient_fax_ccopn__extension',
	co_fk_recipient_fax_ccopn.`itu` AS 'co_fk_recipient_fax_ccopn__itu',

	co_fk_recipient_c_mobile_cpn.`id` AS 'co_fk_recipient_c_mobile_cpn__contact_phone_number_id',
	co_fk_recipient_c_mobile_cpn.`contact_id` AS 'co_fk_recipient_c_mobile_cpn__contact_id',
	co_fk_recipient_c_mobile_cpn.`phone_number_type_id` AS 'co_fk_recipient_c_mobile_cpn__phone_number_type_id',
	co_fk_recipient_c_mobile_cpn.`country_code` AS 'co_fk_recipient_c_mobile_cpn__country_code',
	co_fk_recipient_c_mobile_cpn.`area_code` AS 'co_fk_recipient_c_mobile_cpn__area_code',
	co_fk_recipient_c_mobile_cpn.`prefix` AS 'co_fk_recipient_c_mobile_cpn__prefix',
	co_fk_recipient_c_mobile_cpn.`number` AS 'co_fk_recipient_c_mobile_cpn__number',
	co_fk_recipient_c_mobile_cpn.`extension` AS 'co_fk_recipient_c_mobile_cpn__extension',
	co_fk_recipient_c_mobile_cpn.`itu` AS 'co_fk_recipient_c_mobile_cpn__itu',

	co_fk_initiator_c.`id` AS 'co_fk_initiator_c__contact_id',
	co_fk_initiator_c.`user_company_id` AS 'co_fk_initiator_c__user_company_id',
	co_fk_initiator_c.`user_id` AS 'co_fk_initiator_c__user_id',
	co_fk_initiator_c.`contact_company_id` AS 'co_fk_initiator_c__contact_company_id',
	co_fk_initiator_c.`email` AS 'co_fk_initiator_c__email',
	co_fk_initiator_c.`name_prefix` AS 'co_fk_initiator_c__name_prefix',
	co_fk_initiator_c.`first_name` AS 'co_fk_initiator_c__first_name',
	co_fk_initiator_c.`additional_name` AS 'co_fk_initiator_c__additional_name',
	co_fk_initiator_c.`middle_name` AS 'co_fk_initiator_c__middle_name',
	co_fk_initiator_c.`last_name` AS 'co_fk_initiator_c__last_name',
	co_fk_initiator_c.`name_suffix` AS 'co_fk_initiator_c__name_suffix',
	co_fk_initiator_c.`title` AS 'co_fk_initiator_c__title',
	co_fk_initiator_c.`vendor_flag` AS 'co_fk_initiator_c__vendor_flag',

	co_fk_initiator_cco.`id` AS 'co_fk_initiator_cco__contact_company_office_id',
	co_fk_initiator_cco.`contact_company_id` AS 'co_fk_initiator_cco__contact_company_id',
	co_fk_initiator_cco.`office_nickname` AS 'co_fk_initiator_cco__office_nickname',
	co_fk_initiator_cco.`address_line_1` AS 'co_fk_initiator_cco__address_line_1',
	co_fk_initiator_cco.`address_line_2` AS 'co_fk_initiator_cco__address_line_2',
	co_fk_initiator_cco.`address_line_3` AS 'co_fk_initiator_cco__address_line_3',
	co_fk_initiator_cco.`address_line_4` AS 'co_fk_initiator_cco__address_line_4',
	co_fk_initiator_cco.`address_city` AS 'co_fk_initiator_cco__address_city',
	co_fk_initiator_cco.`address_county` AS 'co_fk_initiator_cco__address_county',
	co_fk_initiator_cco.`address_state_or_region` AS 'co_fk_initiator_cco__address_state_or_region',
	co_fk_initiator_cco.`address_postal_code` AS 'co_fk_initiator_cco__address_postal_code',
	co_fk_initiator_cco.`address_postal_code_extension` AS 'co_fk_initiator_cco__address_postal_code_extension',
	co_fk_initiator_cco.`address_country` AS 'co_fk_initiator_cco__address_country',
	co_fk_initiator_cco.`head_quarters_flag` AS 'co_fk_initiator_cco__head_quarters_flag',
	co_fk_initiator_cco.`address_validated_by_user_flag` AS 'co_fk_initiator_cco__address_validated_by_user_flag',
	co_fk_initiator_cco.`address_validated_by_web_service_flag` AS 'co_fk_initiator_cco__address_validated_by_web_service_flag',
	co_fk_initiator_cco.`address_validation_by_web_service_error_flag` AS 'co_fk_initiator_cco__address_validation_by_web_service_error_flag',

	co_fk_initiator_phone_ccopn.`id` AS 'co_fk_initiator_phone_ccopn__contact_company_office_phone_number_id',
	co_fk_initiator_phone_ccopn.`contact_company_office_id` AS 'co_fk_initiator_phone_ccopn__contact_company_office_id',
	co_fk_initiator_phone_ccopn.`phone_number_type_id` AS 'co_fk_initiator_phone_ccopn__phone_number_type_id',
	co_fk_initiator_phone_ccopn.`country_code` AS 'co_fk_initiator_phone_ccopn__country_code',
	co_fk_initiator_phone_ccopn.`area_code` AS 'co_fk_initiator_phone_ccopn__area_code',
	co_fk_initiator_phone_ccopn.`prefix` AS 'co_fk_initiator_phone_ccopn__prefix',
	co_fk_initiator_phone_ccopn.`number` AS 'co_fk_initiator_phone_ccopn__number',
	co_fk_initiator_phone_ccopn.`extension` AS 'co_fk_initiator_phone_ccopn__extension',
	co_fk_initiator_phone_ccopn.`itu` AS 'co_fk_initiator_phone_ccopn__itu',

	co_fk_initiator_fax_ccopn.`id` AS 'co_fk_initiator_fax_ccopn__contact_company_office_phone_number_id',
	co_fk_initiator_fax_ccopn.`contact_company_office_id` AS 'co_fk_initiator_fax_ccopn__contact_company_office_id',
	co_fk_initiator_fax_ccopn.`phone_number_type_id` AS 'co_fk_initiator_fax_ccopn__phone_number_type_id',
	co_fk_initiator_fax_ccopn.`country_code` AS 'co_fk_initiator_fax_ccopn__country_code',
	co_fk_initiator_fax_ccopn.`area_code` AS 'co_fk_initiator_fax_ccopn__area_code',
	co_fk_initiator_fax_ccopn.`prefix` AS 'co_fk_initiator_fax_ccopn__prefix',
	co_fk_initiator_fax_ccopn.`number` AS 'co_fk_initiator_fax_ccopn__number',
	co_fk_initiator_fax_ccopn.`extension` AS 'co_fk_initiator_fax_ccopn__extension',
	co_fk_initiator_fax_ccopn.`itu` AS 'co_fk_initiator_fax_ccopn__itu',

	co_fk_initiator_c_mobile_cpn.`id` AS 'co_fk_initiator_c_mobile_cpn__contact_phone_number_id',
	co_fk_initiator_c_mobile_cpn.`contact_id` AS 'co_fk_initiator_c_mobile_cpn__contact_id',
	co_fk_initiator_c_mobile_cpn.`phone_number_type_id` AS 'co_fk_initiator_c_mobile_cpn__phone_number_type_id',
	co_fk_initiator_c_mobile_cpn.`country_code` AS 'co_fk_initiator_c_mobile_cpn__country_code',
	co_fk_initiator_c_mobile_cpn.`area_code` AS 'co_fk_initiator_c_mobile_cpn__area_code',
	co_fk_initiator_c_mobile_cpn.`prefix` AS 'co_fk_initiator_c_mobile_cpn__prefix',
	co_fk_initiator_c_mobile_cpn.`number` AS 'co_fk_initiator_c_mobile_cpn__number',
	co_fk_initiator_c_mobile_cpn.`extension` AS 'co_fk_initiator_c_mobile_cpn__extension',
	co_fk_initiator_c_mobile_cpn.`itu` AS 'co_fk_initiator_c_mobile_cpn__itu',

	co_fk_codes__fk_ccd.`id` AS 'co_fk_codes__fk_ccd__cost_code_division_id',
	co_fk_codes__fk_ccd.`user_company_id` AS 'co_fk_codes__fk_ccd__user_company_id',
	co_fk_codes__fk_ccd.`cost_code_type_id` AS 'co_fk_codes__fk_ccd__cost_code_type_id',
	co_fk_codes__fk_ccd.`division_number` AS 'co_fk_codes__fk_ccd__division_number',
	co_fk_codes__fk_ccd.`division_code_heading` AS 'co_fk_codes__fk_ccd__division_code_heading',
	co_fk_codes__fk_ccd.`division` AS 'co_fk_codes__fk_ccd__division',
	co_fk_codes__fk_ccd.`division_abbreviation` AS 'co_fk_codes__fk_ccd__division_abbreviation',
	co_fk_codes__fk_ccd.`sort_order` AS 'co_fk_codes__fk_ccd__sort_order',
	co_fk_codes__fk_ccd.`disabled_flag` AS 'co_fk_codes__fk_ccd__disabled_flag',

	co_fk_creator_c__fk_cc.`id` AS 'co_fk_creator_c__fk_cc__contact_company_id',
	co_fk_creator_c__fk_cc.`user_user_company_id` AS 'co_fk_creator_c__fk_cc__user_user_company_id',
	co_fk_creator_c__fk_cc.`contact_user_company_id` AS 'co_fk_creator_c__fk_cc__contact_user_company_id',
	co_fk_creator_c__fk_cc.`company` AS 'co_fk_creator_c__fk_cc__company',
	co_fk_creator_c__fk_cc.`primary_phone_number` AS 'co_fk_creator_c__fk_cc__primary_phone_number',
	co_fk_creator_c__fk_cc.`employer_identification_number` AS 'co_fk_creator_c__fk_cc__employer_identification_number',
	co_fk_creator_c__fk_cc.`construction_license_number` AS 'co_fk_creator_c__fk_cc__construction_license_number',
	co_fk_creator_c__fk_cc.`construction_license_number_expiration_date` AS 'co_fk_creator_c__fk_cc__construction_license_number_expiration_date',
	co_fk_creator_c__fk_cc.`vendor_flag` AS 'co_fk_creator_c__fk_cc__vendor_flag',

	co_fk_recipient_c_fk_cc.`id` AS 'co_fk_recipient_c_fk_cc__contact_company_id',
	co_fk_recipient_c_fk_cc.`user_user_company_id` AS 'co_fk_recipient_c_fk_cc__user_user_company_id',
	co_fk_recipient_c_fk_cc.`contact_user_company_id` AS 'co_fk_recipient_c_fk_cc__contact_user_company_id',
	co_fk_recipient_c_fk_cc.`company` AS 'co_fk_recipient_c_fk_cc__company',
	co_fk_recipient_c_fk_cc.`primary_phone_number` AS 'co_fk_recipient_c_fk_cc__primary_phone_number',
	co_fk_recipient_c_fk_cc.`employer_identification_number` AS 'co_fk_recipient_c_fk_cc__employer_identification_number',
	co_fk_recipient_c_fk_cc.`construction_license_number` AS 'co_fk_recipient_c_fk_cc__construction_license_number',
	co_fk_recipient_c_fk_cc.`construction_license_number_expiration_date` AS 'co_fk_recipient_c_fk_cc__construction_license_number_expiration_date',
	co_fk_recipient_c_fk_cc.`vendor_flag` AS 'co_fk_recipient_c_fk_cc__vendor_flag',

	co_fk_initiator_c__fk_cc.`id` AS 'co_fk_initiator_c__fk_cc__contact_company_id',
	co_fk_initiator_c__fk_cc.`user_user_company_id` AS 'co_fk_initiator_c__fk_cc__user_user_company_id',
	co_fk_initiator_c__fk_cc.`contact_user_company_id` AS 'co_fk_initiator_c__fk_cc__contact_user_company_id',
	co_fk_initiator_c__fk_cc.`company` AS 'co_fk_initiator_c__fk_cc__company',
	co_fk_initiator_c__fk_cc.`primary_phone_number` AS 'co_fk_initiator_c__fk_cc__primary_phone_number',
	co_fk_initiator_c__fk_cc.`employer_identification_number` AS 'co_fk_initiator_c__fk_cc__employer_identification_number',
	co_fk_initiator_c__fk_cc.`construction_license_number` AS 'co_fk_initiator_c__fk_cc__construction_license_number',
	co_fk_initiator_c__fk_cc.`construction_license_number_expiration_date` AS 'co_fk_initiator_c__fk_cc__construction_license_number_expiration_date',
	co_fk_initiator_c__fk_cc.`vendor_flag` AS 'co_fk_initiator_c__fk_cc__vendor_flag',

	co.*

FROM `change_orders` co
	INNER JOIN `projects` co_fk_p ON co.`project_id` = co_fk_p.`id`
	INNER JOIN `change_order_types` co_fk_cot ON co.`change_order_type_id` = co_fk_cot.`id`
	INNER JOIN `change_order_statuses` co_fk_cos ON co.`change_order_status_id` = co_fk_cos.`id`
	LEFT OUTER JOIN `change_order_priorities` co_fk_cop ON co.`change_order_priority_id` = co_fk_cop.`id`
	LEFT OUTER JOIN `file_manager_files` co_fk_fmfiles ON co.`co_file_manager_file_id` = co_fk_fmfiles.`id`
	LEFT OUTER JOIN `cost_codes` co_fk_codes ON co.`co_cost_code_id` = co_fk_codes.`id`
	INNER JOIN `contacts` co_fk_creator_c ON co.`co_creator_contact_id` = co_fk_creator_c.`id`
	LEFT OUTER JOIN `contact_company_offices` co_fk_creator_cco ON co.`co_creator_contact_company_office_id` = co_fk_creator_cco.`id`
	LEFT OUTER JOIN `contact_company_office_phone_numbers` co_fk_creator_phone_ccopn ON co.`co_creator_phone_contact_company_office_phone_number_id` = co_fk_creator_phone_ccopn.`id`
	LEFT OUTER JOIN `contact_company_office_phone_numbers` co_fk_creator_fax_ccopn ON co.`co_creator_fax_contact_company_office_phone_number_id` = co_fk_creator_fax_ccopn.`id`
	LEFT OUTER JOIN `contact_phone_numbers` co_fk_creator_c_mobile_cpn ON co.`co_creator_contact_mobile_phone_number_id` = co_fk_creator_c_mobile_cpn.`id`
	LEFT OUTER JOIN `contacts` co_fk_recipient_c ON co.`co_recipient_contact_id` = co_fk_recipient_c.`id`
	LEFT OUTER JOIN `contact_company_offices` co_fk_recipient_cco ON co.`co_recipient_contact_company_office_id` = co_fk_recipient_cco.`id`
	LEFT OUTER JOIN `contact_company_office_phone_numbers` co_fk_recipient_phone_ccopn ON co.`co_recipient_phone_contact_company_office_phone_number_id` = co_fk_recipient_phone_ccopn.`id`
	LEFT OUTER JOIN `contact_company_office_phone_numbers` co_fk_recipient_fax_ccopn ON co.`co_recipient_fax_contact_company_office_phone_number_id` = co_fk_recipient_fax_ccopn.`id`
	LEFT OUTER JOIN `contact_phone_numbers` co_fk_recipient_c_mobile_cpn ON co.`co_recipient_contact_mobile_phone_number_id` = co_fk_recipient_c_mobile_cpn.`id`
	LEFT OUTER JOIN `contacts` co_fk_initiator_c ON co.`co_initiator_contact_id` = co_fk_initiator_c.`id`
	LEFT OUTER JOIN `contact_company_offices` co_fk_initiator_cco ON co.`co_initiator_contact_company_office_id` = co_fk_initiator_cco.`id`
	LEFT OUTER JOIN `contact_company_office_phone_numbers` co_fk_initiator_phone_ccopn ON co.`co_initiator_phone_contact_company_office_phone_number_id` = co_fk_initiator_phone_ccopn.`id`
	LEFT OUTER JOIN `contact_company_office_phone_numbers` co_fk_initiator_fax_ccopn ON co.`co_initiator_fax_contact_company_office_phone_number_id` = co_fk_initiator_fax_ccopn.`id`
	LEFT OUTER JOIN `contact_phone_numbers` co_fk_initiator_c_mobile_cpn ON co.`co_initiator_contact_mobile_phone_number_id` = co_fk_initiator_c_mobile_cpn.`id`

	LEFT OUTER JOIN `cost_code_divisions` co_fk_codes__fk_ccd ON co_fk_codes.`cost_code_division_id` = co_fk_codes__fk_ccd.`id`

	INNER JOIN `contact_companies` co_fk_creator_c__fk_cc ON co_fk_creator_c.`contact_company_id` = co_fk_creator_c__fk_cc.`id`
	LEFT OUTER JOIN `contact_companies` co_fk_recipient_c_fk_cc ON co_fk_recipient_c.`contact_company_id` = co_fk_recipient_c_fk_cc.`id`
	LEFT OUTER JOIN `contact_companies` co_fk_initiator_c__fk_cc ON co_fk_initiator_c.`contact_company_id` = co_fk_initiator_c__fk_cc.`id`

WHERE co.`id` = ?
";
		$arrValues = array($change_order_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$change_order_id = $row['id'];
			$changeOrder = self::instantiateOrm($database, 'ChangeOrder', $row, null, $change_order_id);
			/* @var $changeOrder ChangeOrder */
			$changeOrder->convertPropertiesToData();

			if (isset($row['project_id'])) {
				$project_id = $row['project_id'];
				$row['co_fk_p__id'] = $project_id;
				$project = self::instantiateOrm($database, 'Project', $row, null, $project_id, 'co_fk_p__');
				/* @var $project Project */
				$project->convertPropertiesToData();
			} else {
				$project = false;
			}
			$changeOrder->setProject($project);

			if (isset($row['change_order_type_id'])) {
				$change_order_type_id = $row['change_order_type_id'];
				$row['co_fk_cot__id'] = $change_order_type_id;
				$changeOrderType = self::instantiateOrm($database, 'ChangeOrderType', $row, null, $change_order_type_id, 'co_fk_cot__');
				/* @var $changeOrderType ChangeOrderType */
				$changeOrderType->convertPropertiesToData();
			} else {
				$changeOrderType = false;
			}
			$changeOrder->setChangeOrderType($changeOrderType);

			if (isset($row['change_order_status_id'])) {
				$change_order_status_id = $row['change_order_status_id'];
				$row['co_fk_cos__id'] = $change_order_status_id;
				$changeOrderStatus = self::instantiateOrm($database, 'ChangeOrderStatus', $row, null, $change_order_status_id, 'co_fk_cos__');
				/* @var $changeOrderStatus ChangeOrderStatus */
				$changeOrderStatus->convertPropertiesToData();
			} else {
				$changeOrderStatus = false;
			}
			$changeOrder->setChangeOrderStatus($changeOrderStatus);

			if (isset($row['change_order_priority_id'])) {
				$change_order_priority_id = $row['change_order_priority_id'];
				$row['co_fk_cop__id'] = $change_order_priority_id;
				$changeOrderPriority = self::instantiateOrm($database, 'ChangeOrderPriority', $row, null, $change_order_priority_id, 'co_fk_cop__');
				/* @var $changeOrderPriority ChangeOrderPriority */
				$changeOrderPriority->convertPropertiesToData();
			} else {
				$changeOrderPriority = false;
			}
			$changeOrder->setChangeOrderPriority($changeOrderPriority);

			if (isset($row['co_file_manager_file_id'])) {
				$co_file_manager_file_id = $row['co_file_manager_file_id'];
				$row['co_fk_fmfiles__id'] = $co_file_manager_file_id;
				$coFileManagerFile = self::instantiateOrm($database, 'FileManagerFile', $row, null, $co_file_manager_file_id, 'co_fk_fmfiles__');
				/* @var $coFileManagerFile FileManagerFile */
				$coFileManagerFile->convertPropertiesToData();
			} else {
				$coFileManagerFile = false;
			}
			$changeOrder->setCoFileManagerFile($coFileManagerFile);

			if (isset($row['co_cost_code_id'])) {
				$co_cost_code_id = $row['co_cost_code_id'];
				$row['co_fk_codes__id'] = $co_cost_code_id;
				$coCostCode = self::instantiateOrm($database, 'CostCode', $row, null, $co_cost_code_id, 'co_fk_codes__');
				/* @var $coCostCode CostCode */
				$coCostCode->convertPropertiesToData();
			} else {
				$coCostCode = false;
			}
			$changeOrder->setCoCostCode($coCostCode);

			if (isset($row['co_creator_contact_id'])) {
				$co_creator_contact_id = $row['co_creator_contact_id'];
				$row['co_fk_creator_c__id'] = $co_creator_contact_id;
				$coCreatorContact = self::instantiateOrm($database, 'Contact', $row, null, $co_creator_contact_id, 'co_fk_creator_c__');
				/* @var $coCreatorContact Contact */
				$coCreatorContact->convertPropertiesToData();
			} else {
				$coCreatorContact = false;
			}
			$changeOrder->setCoCreatorContact($coCreatorContact);

			if (isset($row['co_creator_contact_company_office_id'])) {
				$co_creator_contact_company_office_id = $row['co_creator_contact_company_office_id'];
				$row['co_fk_creator_cco__id'] = $co_creator_contact_company_office_id;
				$coCreatorContactCompanyOffice = self::instantiateOrm($database, 'ContactCompanyOffice', $row, null, $co_creator_contact_company_office_id, 'co_fk_creator_cco__');
				/* @var $coCreatorContactCompanyOffice ContactCompanyOffice */
				$coCreatorContactCompanyOffice->convertPropertiesToData();
			} else {
				$coCreatorContactCompanyOffice = false;
			}
			$changeOrder->setCoCreatorContactCompanyOffice($coCreatorContactCompanyOffice);

			if (isset($row['co_creator_phone_contact_company_office_phone_number_id'])) {
				$co_creator_phone_contact_company_office_phone_number_id = $row['co_creator_phone_contact_company_office_phone_number_id'];
				$row['co_fk_creator_phone_ccopn__id'] = $co_creator_phone_contact_company_office_phone_number_id;
				$coCreatorPhoneContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $co_creator_phone_contact_company_office_phone_number_id, 'co_fk_creator_phone_ccopn__');
				/* @var $coCreatorPhoneContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$coCreatorPhoneContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$coCreatorPhoneContactCompanyOfficePhoneNumber = false;
			}
			$changeOrder->setCoCreatorPhoneContactCompanyOfficePhoneNumber($coCreatorPhoneContactCompanyOfficePhoneNumber);

			if (isset($row['co_creator_fax_contact_company_office_phone_number_id'])) {
				$co_creator_fax_contact_company_office_phone_number_id = $row['co_creator_fax_contact_company_office_phone_number_id'];
				$row['co_fk_creator_fax_ccopn__id'] = $co_creator_fax_contact_company_office_phone_number_id;
				$coCreatorFaxContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $co_creator_fax_contact_company_office_phone_number_id, 'co_fk_creator_fax_ccopn__');
				/* @var $coCreatorFaxContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$coCreatorFaxContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$coCreatorFaxContactCompanyOfficePhoneNumber = false;
			}
			$changeOrder->setCoCreatorFaxContactCompanyOfficePhoneNumber($coCreatorFaxContactCompanyOfficePhoneNumber);

			if (isset($row['co_creator_contact_mobile_phone_number_id'])) {
				$co_creator_contact_mobile_phone_number_id = $row['co_creator_contact_mobile_phone_number_id'];
				$row['co_fk_creator_c_mobile_cpn__id'] = $co_creator_contact_mobile_phone_number_id;
				$coCreatorContactMobilePhoneNumber = self::instantiateOrm($database, 'ContactPhoneNumber', $row, null, $co_creator_contact_mobile_phone_number_id, 'co_fk_creator_c_mobile_cpn__');
				/* @var $coCreatorContactMobilePhoneNumber ContactPhoneNumber */
				$coCreatorContactMobilePhoneNumber->convertPropertiesToData();
			} else {
				$coCreatorContactMobilePhoneNumber = false;
			}
			$changeOrder->setCoCreatorContactMobilePhoneNumber($coCreatorContactMobilePhoneNumber);

			if (isset($row['co_recipient_contact_id'])) {
				$co_recipient_contact_id = $row['co_recipient_contact_id'];
				$row['co_fk_recipient_c__id'] = $co_recipient_contact_id;
				$coRecipientContact = self::instantiateOrm($database, 'Contact', $row, null, $co_recipient_contact_id, 'co_fk_recipient_c__');
				/* @var $coRecipientContact Contact */
				$coRecipientContact->convertPropertiesToData();
			} else {
				$coRecipientContact = false;
			}
			$changeOrder->setCoRecipientContact($coRecipientContact);

			if (isset($row['co_recipient_contact_company_office_id'])) {
				$co_recipient_contact_company_office_id = $row['co_recipient_contact_company_office_id'];
				$row['co_fk_recipient_cco__id'] = $co_recipient_contact_company_office_id;
				$coRecipientContactCompanyOffice = self::instantiateOrm($database, 'ContactCompanyOffice', $row, null, $co_recipient_contact_company_office_id, 'co_fk_recipient_cco__');
				/* @var $coRecipientContactCompanyOffice ContactCompanyOffice */
				$coRecipientContactCompanyOffice->convertPropertiesToData();
			} else {
				$coRecipientContactCompanyOffice = false;
			}
			$changeOrder->setCoRecipientContactCompanyOffice($coRecipientContactCompanyOffice);

			if (isset($row['co_recipient_phone_contact_company_office_phone_number_id'])) {
				$co_recipient_phone_contact_company_office_phone_number_id = $row['co_recipient_phone_contact_company_office_phone_number_id'];
				$row['co_fk_recipient_phone_ccopn__id'] = $co_recipient_phone_contact_company_office_phone_number_id;
				$coRecipientPhoneContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $co_recipient_phone_contact_company_office_phone_number_id, 'co_fk_recipient_phone_ccopn__');
				/* @var $coRecipientPhoneContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$coRecipientPhoneContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$coRecipientPhoneContactCompanyOfficePhoneNumber = false;
			}
			$changeOrder->setCoRecipientPhoneContactCompanyOfficePhoneNumber($coRecipientPhoneContactCompanyOfficePhoneNumber);

			if (isset($row['co_recipient_fax_contact_company_office_phone_number_id'])) {
				$co_recipient_fax_contact_company_office_phone_number_id = $row['co_recipient_fax_contact_company_office_phone_number_id'];
				$row['co_fk_recipient_fax_ccopn__id'] = $co_recipient_fax_contact_company_office_phone_number_id;
				$coRecipientFaxContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $co_recipient_fax_contact_company_office_phone_number_id, 'co_fk_recipient_fax_ccopn__');
				/* @var $coRecipientFaxContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$coRecipientFaxContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$coRecipientFaxContactCompanyOfficePhoneNumber = false;
			}
			$changeOrder->setCoRecipientFaxContactCompanyOfficePhoneNumber($coRecipientFaxContactCompanyOfficePhoneNumber);

			if (isset($row['co_recipient_contact_mobile_phone_number_id'])) {
				$co_recipient_contact_mobile_phone_number_id = $row['co_recipient_contact_mobile_phone_number_id'];
				$row['co_fk_recipient_c_mobile_cpn__id'] = $co_recipient_contact_mobile_phone_number_id;
				$coRecipientContactMobilePhoneNumber = self::instantiateOrm($database, 'ContactPhoneNumber', $row, null, $co_recipient_contact_mobile_phone_number_id, 'co_fk_recipient_c_mobile_cpn__');
				/* @var $coRecipientContactMobilePhoneNumber ContactPhoneNumber */
				$coRecipientContactMobilePhoneNumber->convertPropertiesToData();
			} else {
				$coRecipientContactMobilePhoneNumber = false;
			}
			$changeOrder->setCoRecipientContactMobilePhoneNumber($coRecipientContactMobilePhoneNumber);

			if (isset($row['co_initiator_contact_id'])) {
				$co_initiator_contact_id = $row['co_initiator_contact_id'];
				$row['co_fk_initiator_c__id'] = $co_initiator_contact_id;
				$coInitiatorContact = self::instantiateOrm($database, 'Contact', $row, null, $co_initiator_contact_id, 'co_fk_initiator_c__');
				/* @var $coInitiatorContact Contact */
				$coInitiatorContact->convertPropertiesToData();
			} else {
				$coInitiatorContact = false;
			}
			$changeOrder->setCoInitiatorContact($coInitiatorContact);

			if (isset($row['co_initiator_contact_company_office_id'])) {
				$co_initiator_contact_company_office_id = $row['co_initiator_contact_company_office_id'];
				$row['co_fk_initiator_cco__id'] = $co_initiator_contact_company_office_id;
				$coInitiatorContactCompanyOffice = self::instantiateOrm($database, 'ContactCompanyOffice', $row, null, $co_initiator_contact_company_office_id, 'co_fk_initiator_cco__');
				/* @var $coInitiatorContactCompanyOffice ContactCompanyOffice */
				$coInitiatorContactCompanyOffice->convertPropertiesToData();
			} else {
				$coInitiatorContactCompanyOffice = false;
			}
			$changeOrder->setCoInitiatorContactCompanyOffice($coInitiatorContactCompanyOffice);

			if (isset($row['co_initiator_phone_contact_company_office_phone_number_id'])) {
				$co_initiator_phone_contact_company_office_phone_number_id = $row['co_initiator_phone_contact_company_office_phone_number_id'];
				$row['co_fk_initiator_phone_ccopn__id'] = $co_initiator_phone_contact_company_office_phone_number_id;
				$coInitiatorPhoneContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $co_initiator_phone_contact_company_office_phone_number_id, 'co_fk_initiator_phone_ccopn__');
				/* @var $coInitiatorPhoneContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$coInitiatorPhoneContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$coInitiatorPhoneContactCompanyOfficePhoneNumber = false;
			}
			$changeOrder->setCoInitiatorPhoneContactCompanyOfficePhoneNumber($coInitiatorPhoneContactCompanyOfficePhoneNumber);

			if (isset($row['co_initiator_fax_contact_company_office_phone_number_id'])) {
				$co_initiator_fax_contact_company_office_phone_number_id = $row['co_initiator_fax_contact_company_office_phone_number_id'];
				$row['co_fk_initiator_fax_ccopn__id'] = $co_initiator_fax_contact_company_office_phone_number_id;
				$coInitiatorFaxContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $co_initiator_fax_contact_company_office_phone_number_id, 'co_fk_initiator_fax_ccopn__');
				/* @var $coInitiatorFaxContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$coInitiatorFaxContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$coInitiatorFaxContactCompanyOfficePhoneNumber = false;
			}
			$changeOrder->setCoInitiatorFaxContactCompanyOfficePhoneNumber($coInitiatorFaxContactCompanyOfficePhoneNumber);

			if (isset($row['co_initiator_contact_mobile_phone_number_id'])) {
				$co_initiator_contact_mobile_phone_number_id = $row['co_initiator_contact_mobile_phone_number_id'];
				$row['co_fk_initiator_c_mobile_cpn__id'] = $co_initiator_contact_mobile_phone_number_id;
				$coInitiatorContactMobilePhoneNumber = self::instantiateOrm($database, 'ContactPhoneNumber', $row, null, $co_initiator_contact_mobile_phone_number_id, 'co_fk_initiator_c_mobile_cpn__');
				/* @var $coInitiatorContactMobilePhoneNumber ContactPhoneNumber */
				$coInitiatorContactMobilePhoneNumber->convertPropertiesToData();
			} else {
				$coInitiatorContactMobilePhoneNumber = false;
			}
			$changeOrder->setCoInitiatorContactMobilePhoneNumber($coInitiatorContactMobilePhoneNumber);

			// Extra: Change Order Cost Code - Cost Code Division
			if (isset($row['co_fk_codes__fk_ccd__cost_code_division_id'])) {
				$cost_code_division_id = $row['co_fk_codes__fk_ccd__cost_code_division_id'];
				$row['co_fk_codes__fk_ccd__id'] = $cost_code_division_id;
				$coCostCodeDivision = self::instantiateOrm($database, 'CostCodeDivision', $row, null, $cost_code_division_id, 'co_fk_codes__fk_ccd__');
				/* @var $coCostCodeDivision CostCodeDivision */
				$coCostCodeDivision->convertPropertiesToData();
			} else {
				$coCostCodeDivision = false;
			}
			if ($coCostCode) {
				$coCostCode->setCostCodeDivision($coCostCodeDivision);
			}

			// Extra: Change Order Creator - Contact Company
			if (isset($row['co_fk_creator_c__fk_cc__contact_company_id'])) {
				$co_creator_contact_company_id = $row['co_fk_creator_c__fk_cc__contact_company_id'];
				$row['co_fk_creator_c__fk_cc__id'] = $co_creator_contact_company_id;
				$coCreatorContactCompany = self::instantiateOrm($database, 'ContactCompany', $row, null, $co_creator_contact_company_id, 'co_fk_creator_c__fk_cc__');
				/* @var $coCreatorContactCompany ContactCompany */
				$coCreatorContactCompany->convertPropertiesToData();
			} else {
				$coCreatorContactCompany = false;
			}
			if ($coCreatorContact) {
				$coCreatorContact->setContactCompany($coCreatorContactCompany);
			}

			// Extra: Change Order Recipient - Contact Company
			if (isset($row['co_fk_recipient_c_fk_cc__contact_company_id'])) {
				$co_recipient_contact_company_id = $row['co_fk_recipient_c_fk_cc__contact_company_id'];
				$row['co_fk_recipient_c_fk_cc__id'] = $co_recipient_contact_company_id;
				$coRecipientContactCompany = self::instantiateOrm($database, 'ContactCompany', $row, null, $co_recipient_contact_company_id, 'co_fk_recipient_c_fk_cc__');
				/* @var $coRecipientContactCompany ContactCompany */
				$coRecipientContactCompany->convertPropertiesToData();
			} else {
				$coRecipientContactCompany = false;
			}
			if ($coRecipientContact) {
				$coRecipientContact->setContactCompany($coRecipientContactCompany);
			}

			// Extra: Change Order Initiator - Contact Company
			if (isset($row['co_fk_initiator_c_fk_cc__contact_company_id'])) {
				$co_initiator_contact_company_id = $row['co_fk_initiator_c_fk_cc__contact_company_id'];
				$row['co_fk_initiator_c_fk_cc__id'] = $co_initiator_contact_company_id;
				$coInitiatorContactCompany = self::instantiateOrm($database, 'ContactCompany', $row, null, $co_initiator_contact_company_id, 'co_fk_initiator_c_fk_cc__');
				/* @var $coInitiatorContactCompany ContactCompany */
				$coInitiatorContactCompany->convertPropertiesToData();
			} else {
				$coInitiatorContactCompany = false;
			}
			if ($coInitiatorContact) {
				$coInitiatorContact->setContactCompany($coInitiatorContactCompany);
			}

			return $changeOrder;
		} else {
			return false;
		}
	}

	// Finders: Find By Unique Index
	/**
	 * Find by unique index `unique_co` (`project_id`,`co_sequence_number`) comment 'One Project can have many COs with a sequence number.'.
	 *
	 * @param string $database
	 * @param int $project_id
	 * @param int $co_sequence_number
	 * @return mixed (single ORM object | false)
	 */
	public static function findByProjectIdAndCoSequenceNumber($database, $project_id, $co_sequence_number)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	co.*

FROM `change_orders` co
WHERE co.`project_id` = ?
AND co.`co_sequence_number` = ?
";
		$arrValues = array($project_id, $co_sequence_number);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if ($row && !empty($row)) {
			$change_order_id = $row['id'];
			$changeOrder = self::instantiateOrm($database, 'ChangeOrder', $row, null, $change_order_id);
			/* @var $changeOrder ChangeOrder */
			return $changeOrder;
		} else {
			return false;
		}
	}

	// Loaders: Load By pk List (list of auto int ids or other non auto int pk list)
	/**
	 * Load zero or more records by an id list (array of auto int primary keys).
	 *
	 * @param string $database
	 * @param array $arrChangeOrderIds
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadChangeOrdersByArrChangeOrderIds($database, $arrChangeOrderIds, Input $options=null)
	{
		if (empty($arrChangeOrderIds)) {
			return array();
		}

		if (isset($options)) {
			$arrOrderByAttributes = $options->arrOrderByAttributes;
			$limit = $options->limit;
			$offset = $options->offset;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpChangeOrder = new ChangeOrder($database);
			$sqlOrderByColumns = $tmpChangeOrder->constructSqlOrderByColumns($arrOrderByAttributes);

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

		foreach ($arrChangeOrderIds as $k => $change_order_id) {
			$change_order_id = (int) $change_order_id;
			$arrChangeOrderIds[$k] = $db->escape($change_order_id);
		}
		$csvChangeOrderIds = join(',', $arrChangeOrderIds);

		$query =
"
SELECT

	co.*

FROM `change_orders` co
WHERE co.`id` IN ($csvChangeOrderIds){$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		$arrChangeOrdersByCsvChangeOrderIds = array();
		while ($row = $db->fetch()) {
			$change_order_id = $row['id'];
			$changeOrder = self::instantiateOrm($database, 'ChangeOrder', $row, null, $change_order_id);
			/* @var $changeOrder ChangeOrder */
			$changeOrder->convertPropertiesToData();

			$arrChangeOrdersByCsvChangeOrderIds[$change_order_id] = $changeOrder;
		}

		$db->free_result();

		return $arrChangeOrdersByCsvChangeOrderIds;
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `change_orders_fk_p` foreign key (`project_id`) references `projects` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $project_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadChangeOrdersByProjectId($database, $project_id, Input $options=null)
	{
		$change_order_type_id = false;
		$change_order_status_id =false;
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

			if (isset($options->change_order_type_id) && !empty($options->change_order_type_id)) {
				$change_order_type_id = $options->change_order_type_id;
			}
			if (isset($options->change_order_status_id) && !empty($options->change_order_status_id)) {
				$change_order_status_id = $options->change_order_status_id;
			}
		}

		if ($forceLoadFlag) {
			self::$_arrChangeOrdersByProjectId = null;
		}

		$arrChangeOrdersByProjectId = self::$_arrChangeOrdersByProjectId;
		if (isset($arrChangeOrdersByProjectId) && !empty($arrChangeOrdersByProjectId)) {
			return $arrChangeOrdersByProjectId;
		}

		$project_id = (int) $project_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$sqlFilter = '';
		if ($change_order_type_id) {
			$escaped_change_order_type_id = $db->escape($change_order_type_id);
			$sqlFilter = "\nAND co.`change_order_type_id` = $escaped_change_order_type_id";
		}
		if($change_order_status_id){
			$escaped_change_order_status = $db->escape($change_order_status_id);
			$sqlFilter .= "\nAND co.`change_order_status_id` = $escaped_change_order_status";
		}

		
		$sqlOrderBy = '';
		$selSort = "";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$sqlOrderBy = "\nORDER BY $arrOrderByAttributes";
		}else
		{
			$selSort = ", (co.co_custom_sequence_number = ' ') boolnull,(co.co_custom_sequence_number = '-') boolDash, (co.co_custom_sequence_number = '0') boolZero, (co.co_custom_sequence_number+0 > 0) boolNum";
			$sqlOrderBy = "\nORDER BY boolnull ASC , boolDash DESC, boolZero DESC, boolNum DESC, (co_custom_sequence_number+0), co_custom_sequence_number, CAST(SUBSTR(co_type_prefix , 5, LENGTH(co_type_prefix)) AS UNSIGNED) DESC";
			// $sqlOrderBy = "\nORDER BY  if(co.`co_custom_sequence_number` = '' or co.`co_custom_sequence_number` is null,1,0), co.`co_custom_sequence_number` ASC,CAST(SUBSTR(co_type_prefix , 5, LENGTH(co_type_prefix)) AS UNSIGNED) DESC" ;
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

	co_fk_p.`id` AS 'co_fk_p__project_id',
	co_fk_p.`project_type_id` AS 'co_fk_p__project_type_id',
	co_fk_p.`user_company_id` AS 'co_fk_p__user_company_id',
	co_fk_p.`user_custom_project_id` AS 'co_fk_p__user_custom_project_id',
	co_fk_p.`project_name` AS 'co_fk_p__project_name',
	co_fk_p.`project_owner_name` AS 'co_fk_p__project_owner_name',
	co_fk_p.`latitude` AS 'co_fk_p__latitude',
	co_fk_p.`longitude` AS 'co_fk_p__longitude',
	co_fk_p.`address_line_1` AS 'co_fk_p__address_line_1',
	co_fk_p.`address_line_2` AS 'co_fk_p__address_line_2',
	co_fk_p.`address_line_3` AS 'co_fk_p__address_line_3',
	co_fk_p.`address_line_4` AS 'co_fk_p__address_line_4',
	co_fk_p.`address_city` AS 'co_fk_p__address_city',
	co_fk_p.`address_county` AS 'co_fk_p__address_county',
	co_fk_p.`address_state_or_region` AS 'co_fk_p__address_state_or_region',
	co_fk_p.`address_postal_code` AS 'co_fk_p__address_postal_code',
	co_fk_p.`address_postal_code_extension` AS 'co_fk_p__address_postal_code_extension',
	co_fk_p.`address_country` AS 'co_fk_p__address_country',
	co_fk_p.`building_count` AS 'co_fk_p__building_count',
	co_fk_p.`unit_count` AS 'co_fk_p__unit_count',
	co_fk_p.`gross_square_footage` AS 'co_fk_p__gross_square_footage',
	co_fk_p.`net_rentable_square_footage` AS 'co_fk_p__net_rentable_square_footage',
	co_fk_p.`is_active_flag` AS 'co_fk_p__is_active_flag',
	co_fk_p.`public_plans_flag` AS 'co_fk_p__public_plans_flag',
	co_fk_p.`prevailing_wage_flag` AS 'co_fk_p__prevailing_wage_flag',
	co_fk_p.`city_business_license_required_flag` AS 'co_fk_p__city_business_license_required_flag',
	co_fk_p.`is_internal_flag` AS 'co_fk_p__is_internal_flag',
	co_fk_p.`project_contract_date` AS 'co_fk_p__project_contract_date',
	co_fk_p.`project_start_date` AS 'co_fk_p__project_start_date',
	co_fk_p.`project_completed_date` AS 'co_fk_p__project_completed_date',
	co_fk_p.`sort_order` AS 'co_fk_p__sort_order',

	co_fk_cot.`id` AS 'co_fk_cot__change_order_type_id',
	co_fk_cot.`change_order_type` AS 'co_fk_cot__change_order_type',
	co_fk_cot.`disabled_flag` AS 'co_fk_cot__disabled_flag',

	co_fk_cos.`id` AS 'co_fk_cos__change_order_status_id',
	co_fk_cos.`change_order_status` AS 'co_fk_cos__change_order_status',
	co_fk_cos.`disabled_flag` AS 'co_fk_cos__disabled_flag',

	co_fk_cop.`id` AS 'co_fk_cop__change_order_priority_id',
	co_fk_cop.`change_order_priority` AS 'co_fk_cop__change_order_priority',
	co_fk_cop.`disabled_flag` AS 'co_fk_cop__disabled_flag',

	co_fk_fmfiles.`id` AS 'co_fk_fmfiles__file_manager_file_id',
	co_fk_fmfiles.`user_company_id` AS 'co_fk_fmfiles__user_company_id',
	co_fk_fmfiles.`contact_id` AS 'co_fk_fmfiles__contact_id',
	co_fk_fmfiles.`project_id` AS 'co_fk_fmfiles__project_id',
	co_fk_fmfiles.`file_manager_folder_id` AS 'co_fk_fmfiles__file_manager_folder_id',
	co_fk_fmfiles.`file_location_id` AS 'co_fk_fmfiles__file_location_id',
	co_fk_fmfiles.`virtual_file_name` AS 'co_fk_fmfiles__virtual_file_name',
	co_fk_fmfiles.`version_number` AS 'co_fk_fmfiles__version_number',
	co_fk_fmfiles.`virtual_file_name_sha1` AS 'co_fk_fmfiles__virtual_file_name_sha1',
	co_fk_fmfiles.`virtual_file_mime_type` AS 'co_fk_fmfiles__virtual_file_mime_type',
	co_fk_fmfiles.`modified` AS 'co_fk_fmfiles__modified',
	co_fk_fmfiles.`created` AS 'co_fk_fmfiles__created',
	co_fk_fmfiles.`deleted_flag` AS 'co_fk_fmfiles__deleted_flag',
	co_fk_fmfiles.`directly_deleted_flag` AS 'co_fk_fmfiles__directly_deleted_flag',

	co_fk_codes.`id` AS 'co_fk_codes__cost_code_id',
	co_fk_codes.`cost_code_division_id` AS 'co_fk_codes__cost_code_division_id',
	co_fk_codes.`cost_code` AS 'co_fk_codes__cost_code',
	co_fk_codes.`cost_code_description` AS 'co_fk_codes__cost_code_description',
	co_fk_codes.`cost_code_description_abbreviation` AS 'co_fk_codes__cost_code_description_abbreviation',
	co_fk_codes.`sort_order` AS 'co_fk_codes__sort_order',
	co_fk_codes.`disabled_flag` AS 'co_fk_codes__disabled_flag',

	co_fk_creator_c.`id` AS 'co_fk_creator_c__contact_id',
	co_fk_creator_c.`user_company_id` AS 'co_fk_creator_c__user_company_id',
	co_fk_creator_c.`user_id` AS 'co_fk_creator_c__user_id',
	co_fk_creator_c.`contact_company_id` AS 'co_fk_creator_c__contact_company_id',
	co_fk_creator_c.`email` AS 'co_fk_creator_c__email',
	co_fk_creator_c.`name_prefix` AS 'co_fk_creator_c__name_prefix',
	co_fk_creator_c.`first_name` AS 'co_fk_creator_c__first_name',
	co_fk_creator_c.`additional_name` AS 'co_fk_creator_c__additional_name',
	co_fk_creator_c.`middle_name` AS 'co_fk_creator_c__middle_name',
	co_fk_creator_c.`last_name` AS 'co_fk_creator_c__last_name',
	co_fk_creator_c.`name_suffix` AS 'co_fk_creator_c__name_suffix',
	co_fk_creator_c.`title` AS 'co_fk_creator_c__title',
	co_fk_creator_c.`vendor_flag` AS 'co_fk_creator_c__vendor_flag',

	co_fk_creator_cco.`id` AS 'co_fk_creator_cco__contact_company_office_id',
	co_fk_creator_cco.`contact_company_id` AS 'co_fk_creator_cco__contact_company_id',
	co_fk_creator_cco.`office_nickname` AS 'co_fk_creator_cco__office_nickname',
	co_fk_creator_cco.`address_line_1` AS 'co_fk_creator_cco__address_line_1',
	co_fk_creator_cco.`address_line_2` AS 'co_fk_creator_cco__address_line_2',
	co_fk_creator_cco.`address_line_3` AS 'co_fk_creator_cco__address_line_3',
	co_fk_creator_cco.`address_line_4` AS 'co_fk_creator_cco__address_line_4',
	co_fk_creator_cco.`address_city` AS 'co_fk_creator_cco__address_city',
	co_fk_creator_cco.`address_county` AS 'co_fk_creator_cco__address_county',
	co_fk_creator_cco.`address_state_or_region` AS 'co_fk_creator_cco__address_state_or_region',
	co_fk_creator_cco.`address_postal_code` AS 'co_fk_creator_cco__address_postal_code',
	co_fk_creator_cco.`address_postal_code_extension` AS 'co_fk_creator_cco__address_postal_code_extension',
	co_fk_creator_cco.`address_country` AS 'co_fk_creator_cco__address_country',
	co_fk_creator_cco.`head_quarters_flag` AS 'co_fk_creator_cco__head_quarters_flag',
	co_fk_creator_cco.`address_validated_by_user_flag` AS 'co_fk_creator_cco__address_validated_by_user_flag',
	co_fk_creator_cco.`address_validated_by_web_service_flag` AS 'co_fk_creator_cco__address_validated_by_web_service_flag',
	co_fk_creator_cco.`address_validation_by_web_service_error_flag` AS 'co_fk_creator_cco__address_validation_by_web_service_error_flag',

	co_fk_creator_phone_ccopn.`id` AS 'co_fk_creator_phone_ccopn__contact_company_office_phone_number_id',
	co_fk_creator_phone_ccopn.`contact_company_office_id` AS 'co_fk_creator_phone_ccopn__contact_company_office_id',
	co_fk_creator_phone_ccopn.`phone_number_type_id` AS 'co_fk_creator_phone_ccopn__phone_number_type_id',
	co_fk_creator_phone_ccopn.`country_code` AS 'co_fk_creator_phone_ccopn__country_code',
	co_fk_creator_phone_ccopn.`area_code` AS 'co_fk_creator_phone_ccopn__area_code',
	co_fk_creator_phone_ccopn.`prefix` AS 'co_fk_creator_phone_ccopn__prefix',
	co_fk_creator_phone_ccopn.`number` AS 'co_fk_creator_phone_ccopn__number',
	co_fk_creator_phone_ccopn.`extension` AS 'co_fk_creator_phone_ccopn__extension',
	co_fk_creator_phone_ccopn.`itu` AS 'co_fk_creator_phone_ccopn__itu',

	co_fk_creator_fax_ccopn.`id` AS 'co_fk_creator_fax_ccopn__contact_company_office_phone_number_id',
	co_fk_creator_fax_ccopn.`contact_company_office_id` AS 'co_fk_creator_fax_ccopn__contact_company_office_id',
	co_fk_creator_fax_ccopn.`phone_number_type_id` AS 'co_fk_creator_fax_ccopn__phone_number_type_id',
	co_fk_creator_fax_ccopn.`country_code` AS 'co_fk_creator_fax_ccopn__country_code',
	co_fk_creator_fax_ccopn.`area_code` AS 'co_fk_creator_fax_ccopn__area_code',
	co_fk_creator_fax_ccopn.`prefix` AS 'co_fk_creator_fax_ccopn__prefix',
	co_fk_creator_fax_ccopn.`number` AS 'co_fk_creator_fax_ccopn__number',
	co_fk_creator_fax_ccopn.`extension` AS 'co_fk_creator_fax_ccopn__extension',
	co_fk_creator_fax_ccopn.`itu` AS 'co_fk_creator_fax_ccopn__itu',

	co_fk_creator_c_mobile_cpn.`id` AS 'co_fk_creator_c_mobile_cpn__contact_phone_number_id',
	co_fk_creator_c_mobile_cpn.`contact_id` AS 'co_fk_creator_c_mobile_cpn__contact_id',
	co_fk_creator_c_mobile_cpn.`phone_number_type_id` AS 'co_fk_creator_c_mobile_cpn__phone_number_type_id',
	co_fk_creator_c_mobile_cpn.`country_code` AS 'co_fk_creator_c_mobile_cpn__country_code',
	co_fk_creator_c_mobile_cpn.`area_code` AS 'co_fk_creator_c_mobile_cpn__area_code',
	co_fk_creator_c_mobile_cpn.`prefix` AS 'co_fk_creator_c_mobile_cpn__prefix',
	co_fk_creator_c_mobile_cpn.`number` AS 'co_fk_creator_c_mobile_cpn__number',
	co_fk_creator_c_mobile_cpn.`extension` AS 'co_fk_creator_c_mobile_cpn__extension',
	co_fk_creator_c_mobile_cpn.`itu` AS 'co_fk_creator_c_mobile_cpn__itu',

	co_fk_recipient_c.`id` AS 'co_fk_recipient_c__contact_id',
	co_fk_recipient_c.`user_company_id` AS 'co_fk_recipient_c__user_company_id',
	co_fk_recipient_c.`user_id` AS 'co_fk_recipient_c__user_id',
	co_fk_recipient_c.`contact_company_id` AS 'co_fk_recipient_c__contact_company_id',
	co_fk_recipient_c.`email` AS 'co_fk_recipient_c__email',
	co_fk_recipient_c.`name_prefix` AS 'co_fk_recipient_c__name_prefix',
	co_fk_recipient_c.`first_name` AS 'co_fk_recipient_c__first_name',
	co_fk_recipient_c.`additional_name` AS 'co_fk_recipient_c__additional_name',
	co_fk_recipient_c.`middle_name` AS 'co_fk_recipient_c__middle_name',
	co_fk_recipient_c.`last_name` AS 'co_fk_recipient_c__last_name',
	co_fk_recipient_c.`name_suffix` AS 'co_fk_recipient_c__name_suffix',
	co_fk_recipient_c.`title` AS 'co_fk_recipient_c__title',
	co_fk_recipient_c.`vendor_flag` AS 'co_fk_recipient_c__vendor_flag',

	co_fk_recipient_cco.`id` AS 'co_fk_recipient_cco__contact_company_office_id',
	co_fk_recipient_cco.`contact_company_id` AS 'co_fk_recipient_cco__contact_company_id',
	co_fk_recipient_cco.`office_nickname` AS 'co_fk_recipient_cco__office_nickname',
	co_fk_recipient_cco.`address_line_1` AS 'co_fk_recipient_cco__address_line_1',
	co_fk_recipient_cco.`address_line_2` AS 'co_fk_recipient_cco__address_line_2',
	co_fk_recipient_cco.`address_line_3` AS 'co_fk_recipient_cco__address_line_3',
	co_fk_recipient_cco.`address_line_4` AS 'co_fk_recipient_cco__address_line_4',
	co_fk_recipient_cco.`address_city` AS 'co_fk_recipient_cco__address_city',
	co_fk_recipient_cco.`address_county` AS 'co_fk_recipient_cco__address_county',
	co_fk_recipient_cco.`address_state_or_region` AS 'co_fk_recipient_cco__address_state_or_region',
	co_fk_recipient_cco.`address_postal_code` AS 'co_fk_recipient_cco__address_postal_code',
	co_fk_recipient_cco.`address_postal_code_extension` AS 'co_fk_recipient_cco__address_postal_code_extension',
	co_fk_recipient_cco.`address_country` AS 'co_fk_recipient_cco__address_country',
	co_fk_recipient_cco.`head_quarters_flag` AS 'co_fk_recipient_cco__head_quarters_flag',
	co_fk_recipient_cco.`address_validated_by_user_flag` AS 'co_fk_recipient_cco__address_validated_by_user_flag',
	co_fk_recipient_cco.`address_validated_by_web_service_flag` AS 'co_fk_recipient_cco__address_validated_by_web_service_flag',
	co_fk_recipient_cco.`address_validation_by_web_service_error_flag` AS 'co_fk_recipient_cco__address_validation_by_web_service_error_flag',

	co_fk_recipient_phone_ccopn.`id` AS 'co_fk_recipient_phone_ccopn__contact_company_office_phone_number_id',
	co_fk_recipient_phone_ccopn.`contact_company_office_id` AS 'co_fk_recipient_phone_ccopn__contact_company_office_id',
	co_fk_recipient_phone_ccopn.`phone_number_type_id` AS 'co_fk_recipient_phone_ccopn__phone_number_type_id',
	co_fk_recipient_phone_ccopn.`country_code` AS 'co_fk_recipient_phone_ccopn__country_code',
	co_fk_recipient_phone_ccopn.`area_code` AS 'co_fk_recipient_phone_ccopn__area_code',
	co_fk_recipient_phone_ccopn.`prefix` AS 'co_fk_recipient_phone_ccopn__prefix',
	co_fk_recipient_phone_ccopn.`number` AS 'co_fk_recipient_phone_ccopn__number',
	co_fk_recipient_phone_ccopn.`extension` AS 'co_fk_recipient_phone_ccopn__extension',
	co_fk_recipient_phone_ccopn.`itu` AS 'co_fk_recipient_phone_ccopn__itu',

	co_fk_recipient_fax_ccopn.`id` AS 'co_fk_recipient_fax_ccopn__contact_company_office_phone_number_id',
	co_fk_recipient_fax_ccopn.`contact_company_office_id` AS 'co_fk_recipient_fax_ccopn__contact_company_office_id',
	co_fk_recipient_fax_ccopn.`phone_number_type_id` AS 'co_fk_recipient_fax_ccopn__phone_number_type_id',
	co_fk_recipient_fax_ccopn.`country_code` AS 'co_fk_recipient_fax_ccopn__country_code',
	co_fk_recipient_fax_ccopn.`area_code` AS 'co_fk_recipient_fax_ccopn__area_code',
	co_fk_recipient_fax_ccopn.`prefix` AS 'co_fk_recipient_fax_ccopn__prefix',
	co_fk_recipient_fax_ccopn.`number` AS 'co_fk_recipient_fax_ccopn__number',
	co_fk_recipient_fax_ccopn.`extension` AS 'co_fk_recipient_fax_ccopn__extension',
	co_fk_recipient_fax_ccopn.`itu` AS 'co_fk_recipient_fax_ccopn__itu',

	co_fk_recipient_c_mobile_cpn.`id` AS 'co_fk_recipient_c_mobile_cpn__contact_phone_number_id',
	co_fk_recipient_c_mobile_cpn.`contact_id` AS 'co_fk_recipient_c_mobile_cpn__contact_id',
	co_fk_recipient_c_mobile_cpn.`phone_number_type_id` AS 'co_fk_recipient_c_mobile_cpn__phone_number_type_id',
	co_fk_recipient_c_mobile_cpn.`country_code` AS 'co_fk_recipient_c_mobile_cpn__country_code',
	co_fk_recipient_c_mobile_cpn.`area_code` AS 'co_fk_recipient_c_mobile_cpn__area_code',
	co_fk_recipient_c_mobile_cpn.`prefix` AS 'co_fk_recipient_c_mobile_cpn__prefix',
	co_fk_recipient_c_mobile_cpn.`number` AS 'co_fk_recipient_c_mobile_cpn__number',
	co_fk_recipient_c_mobile_cpn.`extension` AS 'co_fk_recipient_c_mobile_cpn__extension',
	co_fk_recipient_c_mobile_cpn.`itu` AS 'co_fk_recipient_c_mobile_cpn__itu',

	co_fk_initiator_c.`id` AS 'co_fk_initiator_c__contact_id',
	co_fk_initiator_c.`user_company_id` AS 'co_fk_initiator_c__user_company_id',
	co_fk_initiator_c.`user_id` AS 'co_fk_initiator_c__user_id',
	co_fk_initiator_c.`contact_company_id` AS 'co_fk_initiator_c__contact_company_id',
	co_fk_initiator_c.`email` AS 'co_fk_initiator_c__email',
	co_fk_initiator_c.`name_prefix` AS 'co_fk_initiator_c__name_prefix',
	co_fk_initiator_c.`first_name` AS 'co_fk_initiator_c__first_name',
	co_fk_initiator_c.`additional_name` AS 'co_fk_initiator_c__additional_name',
	co_fk_initiator_c.`middle_name` AS 'co_fk_initiator_c__middle_name',
	co_fk_initiator_c.`last_name` AS 'co_fk_initiator_c__last_name',
	co_fk_initiator_c.`name_suffix` AS 'co_fk_initiator_c__name_suffix',
	co_fk_initiator_c.`title` AS 'co_fk_initiator_c__title',
	co_fk_initiator_c.`vendor_flag` AS 'co_fk_initiator_c__vendor_flag',

	co_fk_initiator_cco.`id` AS 'co_fk_initiator_cco__contact_company_office_id',
	co_fk_initiator_cco.`contact_company_id` AS 'co_fk_initiator_cco__contact_company_id',
	co_fk_initiator_cco.`office_nickname` AS 'co_fk_initiator_cco__office_nickname',
	co_fk_initiator_cco.`address_line_1` AS 'co_fk_initiator_cco__address_line_1',
	co_fk_initiator_cco.`address_line_2` AS 'co_fk_initiator_cco__address_line_2',
	co_fk_initiator_cco.`address_line_3` AS 'co_fk_initiator_cco__address_line_3',
	co_fk_initiator_cco.`address_line_4` AS 'co_fk_initiator_cco__address_line_4',
	co_fk_initiator_cco.`address_city` AS 'co_fk_initiator_cco__address_city',
	co_fk_initiator_cco.`address_county` AS 'co_fk_initiator_cco__address_county',
	co_fk_initiator_cco.`address_state_or_region` AS 'co_fk_initiator_cco__address_state_or_region',
	co_fk_initiator_cco.`address_postal_code` AS 'co_fk_initiator_cco__address_postal_code',
	co_fk_initiator_cco.`address_postal_code_extension` AS 'co_fk_initiator_cco__address_postal_code_extension',
	co_fk_initiator_cco.`address_country` AS 'co_fk_initiator_cco__address_country',
	co_fk_initiator_cco.`head_quarters_flag` AS 'co_fk_initiator_cco__head_quarters_flag',
	co_fk_initiator_cco.`address_validated_by_user_flag` AS 'co_fk_initiator_cco__address_validated_by_user_flag',
	co_fk_initiator_cco.`address_validated_by_web_service_flag` AS 'co_fk_initiator_cco__address_validated_by_web_service_flag',
	co_fk_initiator_cco.`address_validation_by_web_service_error_flag` AS 'co_fk_initiator_cco__address_validation_by_web_service_error_flag',

	co_fk_initiator_phone_ccopn.`id` AS 'co_fk_initiator_phone_ccopn__contact_company_office_phone_number_id',
	co_fk_initiator_phone_ccopn.`contact_company_office_id` AS 'co_fk_initiator_phone_ccopn__contact_company_office_id',
	co_fk_initiator_phone_ccopn.`phone_number_type_id` AS 'co_fk_initiator_phone_ccopn__phone_number_type_id',
	co_fk_initiator_phone_ccopn.`country_code` AS 'co_fk_initiator_phone_ccopn__country_code',
	co_fk_initiator_phone_ccopn.`area_code` AS 'co_fk_initiator_phone_ccopn__area_code',
	co_fk_initiator_phone_ccopn.`prefix` AS 'co_fk_initiator_phone_ccopn__prefix',
	co_fk_initiator_phone_ccopn.`number` AS 'co_fk_initiator_phone_ccopn__number',
	co_fk_initiator_phone_ccopn.`extension` AS 'co_fk_initiator_phone_ccopn__extension',
	co_fk_initiator_phone_ccopn.`itu` AS 'co_fk_initiator_phone_ccopn__itu',

	co_fk_initiator_fax_ccopn.`id` AS 'co_fk_initiator_fax_ccopn__contact_company_office_phone_number_id',
	co_fk_initiator_fax_ccopn.`contact_company_office_id` AS 'co_fk_initiator_fax_ccopn__contact_company_office_id',
	co_fk_initiator_fax_ccopn.`phone_number_type_id` AS 'co_fk_initiator_fax_ccopn__phone_number_type_id',
	co_fk_initiator_fax_ccopn.`country_code` AS 'co_fk_initiator_fax_ccopn__country_code',
	co_fk_initiator_fax_ccopn.`area_code` AS 'co_fk_initiator_fax_ccopn__area_code',
	co_fk_initiator_fax_ccopn.`prefix` AS 'co_fk_initiator_fax_ccopn__prefix',
	co_fk_initiator_fax_ccopn.`number` AS 'co_fk_initiator_fax_ccopn__number',
	co_fk_initiator_fax_ccopn.`extension` AS 'co_fk_initiator_fax_ccopn__extension',
	co_fk_initiator_fax_ccopn.`itu` AS 'co_fk_initiator_fax_ccopn__itu',

	co_fk_initiator_c_mobile_cpn.`id` AS 'co_fk_initiator_c_mobile_cpn__contact_phone_number_id',
	co_fk_initiator_c_mobile_cpn.`contact_id` AS 'co_fk_initiator_c_mobile_cpn__contact_id',
	co_fk_initiator_c_mobile_cpn.`phone_number_type_id` AS 'co_fk_initiator_c_mobile_cpn__phone_number_type_id',
	co_fk_initiator_c_mobile_cpn.`country_code` AS 'co_fk_initiator_c_mobile_cpn__country_code',
	co_fk_initiator_c_mobile_cpn.`area_code` AS 'co_fk_initiator_c_mobile_cpn__area_code',
	co_fk_initiator_c_mobile_cpn.`prefix` AS 'co_fk_initiator_c_mobile_cpn__prefix',
	co_fk_initiator_c_mobile_cpn.`number` AS 'co_fk_initiator_c_mobile_cpn__number',
	co_fk_initiator_c_mobile_cpn.`extension` AS 'co_fk_initiator_c_mobile_cpn__extension',
	co_fk_initiator_c_mobile_cpn.`itu` AS 'co_fk_initiator_c_mobile_cpn__itu',

	co.* $selSort

FROM `change_orders` co
	INNER JOIN `projects` co_fk_p ON co.`project_id` = co_fk_p.`id`
	INNER JOIN `change_order_types` co_fk_cot ON co.`change_order_type_id` = co_fk_cot.`id`
	INNER JOIN `change_order_statuses` co_fk_cos ON co.`change_order_status_id` = co_fk_cos.`id`
	LEFT OUTER JOIN `change_order_priorities` co_fk_cop ON co.`change_order_priority_id` = co_fk_cop.`id`
	LEFT OUTER JOIN `file_manager_files` co_fk_fmfiles ON co.`co_file_manager_file_id` = co_fk_fmfiles.`id`
	LEFT OUTER JOIN `cost_codes` co_fk_codes ON co.`co_cost_code_id` = co_fk_codes.`id`
	INNER JOIN `contacts` co_fk_creator_c ON co.`co_creator_contact_id` = co_fk_creator_c.`id`
	LEFT OUTER JOIN `contact_company_offices` co_fk_creator_cco ON co.`co_creator_contact_company_office_id` = co_fk_creator_cco.`id`
	LEFT OUTER JOIN `contact_company_office_phone_numbers` co_fk_creator_phone_ccopn ON co.`co_creator_phone_contact_company_office_phone_number_id` = co_fk_creator_phone_ccopn.`id`
	LEFT OUTER JOIN `contact_company_office_phone_numbers` co_fk_creator_fax_ccopn ON co.`co_creator_fax_contact_company_office_phone_number_id` = co_fk_creator_fax_ccopn.`id`
	LEFT OUTER JOIN `contact_phone_numbers` co_fk_creator_c_mobile_cpn ON co.`co_creator_contact_mobile_phone_number_id` = co_fk_creator_c_mobile_cpn.`id`
	LEFT OUTER JOIN `contacts` co_fk_recipient_c ON co.`co_recipient_contact_id` = co_fk_recipient_c.`id`
	LEFT OUTER JOIN `contact_company_offices` co_fk_recipient_cco ON co.`co_recipient_contact_company_office_id` = co_fk_recipient_cco.`id`
	LEFT OUTER JOIN `contact_company_office_phone_numbers` co_fk_recipient_phone_ccopn ON co.`co_recipient_phone_contact_company_office_phone_number_id` = co_fk_recipient_phone_ccopn.`id`
	LEFT OUTER JOIN `contact_company_office_phone_numbers` co_fk_recipient_fax_ccopn ON co.`co_recipient_fax_contact_company_office_phone_number_id` = co_fk_recipient_fax_ccopn.`id`
	LEFT OUTER JOIN `contact_phone_numbers` co_fk_recipient_c_mobile_cpn ON co.`co_recipient_contact_mobile_phone_number_id` = co_fk_recipient_c_mobile_cpn.`id`
	LEFT OUTER JOIN `contacts` co_fk_initiator_c ON co.`co_initiator_contact_id` = co_fk_initiator_c.`id`
	LEFT OUTER JOIN `contact_company_offices` co_fk_initiator_cco ON co.`co_initiator_contact_company_office_id` = co_fk_initiator_cco.`id`
	LEFT OUTER JOIN `contact_company_office_phone_numbers` co_fk_initiator_phone_ccopn ON co.`co_initiator_phone_contact_company_office_phone_number_id` = co_fk_initiator_phone_ccopn.`id`
	LEFT OUTER JOIN `contact_company_office_phone_numbers` co_fk_initiator_fax_ccopn ON co.`co_initiator_fax_contact_company_office_phone_number_id` = co_fk_initiator_fax_ccopn.`id`
	LEFT OUTER JOIN `contact_phone_numbers` co_fk_initiator_c_mobile_cpn ON co.`co_initiator_contact_mobile_phone_number_id` = co_fk_initiator_c_mobile_cpn.`id`
WHERE co.`project_id` = ?{$sqlFilter}{$sqlOrderBy}{$sqlLimit}
";

		$arrValues = array($project_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrChangeOrdersByProjectId = array();
		while ($row = $db->fetch()) {
			$change_order_id = $row['id'];
			$changeOrder = self::instantiateOrm($database, 'ChangeOrder', $row, null, $change_order_id);
			/* @var $changeOrder ChangeOrder */
			$changeOrder->convertPropertiesToData();

			if (isset($row['project_id'])) {
				$project_id = $row['project_id'];
				$row['co_fk_p__id'] = $project_id;
				$project = self::instantiateOrm($database, 'Project', $row, null, $project_id, 'co_fk_p__');
				/* @var $project Project */
				$project->convertPropertiesToData();
			} else {
				$project = false;
			}
			$changeOrder->setProject($project);

			if (isset($row['change_order_type_id'])) {
				$change_order_type_id = $row['change_order_type_id'];
				$row['co_fk_cot__id'] = $change_order_type_id;
				$changeOrderType = self::instantiateOrm($database, 'ChangeOrderType', $row, null, $change_order_type_id, 'co_fk_cot__');
				/* @var $changeOrderType ChangeOrderType */
				$changeOrderType->convertPropertiesToData();
			} else {
				$changeOrderType = false;
			}
			$changeOrder->setChangeOrderType($changeOrderType);

			if (isset($row['change_order_status_id'])) {
				$change_order_status_id = $row['change_order_status_id'];
				$row['co_fk_cos__id'] = $change_order_status_id;
				$changeOrderStatus = self::instantiateOrm($database, 'ChangeOrderStatus', $row, null, $change_order_status_id, 'co_fk_cos__');
				/* @var $changeOrderStatus ChangeOrderStatus */
				$changeOrderStatus->convertPropertiesToData();
			} else {
				$changeOrderStatus = false;
			}
			$changeOrder->setChangeOrderStatus($changeOrderStatus);

			if (isset($row['change_order_priority_id'])) {
				$change_order_priority_id = $row['change_order_priority_id'];
				$row['co_fk_cop__id'] = $change_order_priority_id;
				$changeOrderPriority = self::instantiateOrm($database, 'ChangeOrderPriority', $row, null, $change_order_priority_id, 'co_fk_cop__');
				/* @var $changeOrderPriority ChangeOrderPriority */
				$changeOrderPriority->convertPropertiesToData();
			} else {
				$changeOrderPriority = false;
			}
			$changeOrder->setChangeOrderPriority($changeOrderPriority);

			if (isset($row['co_file_manager_file_id'])) {
				$co_file_manager_file_id = $row['co_file_manager_file_id'];
				$row['co_fk_fmfiles__id'] = $co_file_manager_file_id;
				$coFileManagerFile = self::instantiateOrm($database, 'FileManagerFile', $row, null, $co_file_manager_file_id, 'co_fk_fmfiles__');
				/* @var $coFileManagerFile FileManagerFile */
				$coFileManagerFile->convertPropertiesToData();
			} else {
				$coFileManagerFile = false;
			}
			$changeOrder->setCoFileManagerFile($coFileManagerFile);

			if (isset($row['co_cost_code_id'])) {
				$co_cost_code_id = $row['co_cost_code_id'];
				$row['co_fk_codes__id'] = $co_cost_code_id;
				$coCostCode = self::instantiateOrm($database, 'CostCode', $row, null, $co_cost_code_id, 'co_fk_codes__');
				/* @var $coCostCode CostCode */
				$coCostCode->convertPropertiesToData();
			} else {
				$coCostCode = false;
			}
			$changeOrder->setCoCostCode($coCostCode);

			if (isset($row['co_creator_contact_id'])) {
				$co_creator_contact_id = $row['co_creator_contact_id'];
				$row['co_fk_creator_c__id'] = $co_creator_contact_id;
				$coCreatorContact = self::instantiateOrm($database, 'Contact', $row, null, $co_creator_contact_id, 'co_fk_creator_c__');
				/* @var $coCreatorContact Contact */
				$coCreatorContact->convertPropertiesToData();
			} else {
				$coCreatorContact = false;
			}
			$changeOrder->setCoCreatorContact($coCreatorContact);

			if (isset($row['co_creator_contact_company_office_id'])) {
				$co_creator_contact_company_office_id = $row['co_creator_contact_company_office_id'];
				$row['co_fk_creator_cco__id'] = $co_creator_contact_company_office_id;
				$coCreatorContactCompanyOffice = self::instantiateOrm($database, 'ContactCompanyOffice', $row, null, $co_creator_contact_company_office_id, 'co_fk_creator_cco__');
				/* @var $coCreatorContactCompanyOffice ContactCompanyOffice */
				$coCreatorContactCompanyOffice->convertPropertiesToData();
			} else {
				$coCreatorContactCompanyOffice = false;
			}
			$changeOrder->setCoCreatorContactCompanyOffice($coCreatorContactCompanyOffice);

			if (isset($row['co_creator_phone_contact_company_office_phone_number_id'])) {
				$co_creator_phone_contact_company_office_phone_number_id = $row['co_creator_phone_contact_company_office_phone_number_id'];
				$row['co_fk_creator_phone_ccopn__id'] = $co_creator_phone_contact_company_office_phone_number_id;
				$coCreatorPhoneContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $co_creator_phone_contact_company_office_phone_number_id, 'co_fk_creator_phone_ccopn__');
				/* @var $coCreatorPhoneContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$coCreatorPhoneContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$coCreatorPhoneContactCompanyOfficePhoneNumber = false;
			}
			$changeOrder->setCoCreatorPhoneContactCompanyOfficePhoneNumber($coCreatorPhoneContactCompanyOfficePhoneNumber);

			if (isset($row['co_creator_fax_contact_company_office_phone_number_id'])) {
				$co_creator_fax_contact_company_office_phone_number_id = $row['co_creator_fax_contact_company_office_phone_number_id'];
				$row['co_fk_creator_fax_ccopn__id'] = $co_creator_fax_contact_company_office_phone_number_id;
				$coCreatorFaxContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $co_creator_fax_contact_company_office_phone_number_id, 'co_fk_creator_fax_ccopn__');
				/* @var $coCreatorFaxContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$coCreatorFaxContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$coCreatorFaxContactCompanyOfficePhoneNumber = false;
			}
			$changeOrder->setCoCreatorFaxContactCompanyOfficePhoneNumber($coCreatorFaxContactCompanyOfficePhoneNumber);

			if (isset($row['co_creator_contact_mobile_phone_number_id'])) {
				$co_creator_contact_mobile_phone_number_id = $row['co_creator_contact_mobile_phone_number_id'];
				$row['co_fk_creator_c_mobile_cpn__id'] = $co_creator_contact_mobile_phone_number_id;
				$coCreatorContactMobilePhoneNumber = self::instantiateOrm($database, 'ContactPhoneNumber', $row, null, $co_creator_contact_mobile_phone_number_id, 'co_fk_creator_c_mobile_cpn__');
				/* @var $coCreatorContactMobilePhoneNumber ContactPhoneNumber */
				$coCreatorContactMobilePhoneNumber->convertPropertiesToData();
			} else {
				$coCreatorContactMobilePhoneNumber = false;
			}
			$changeOrder->setCoCreatorContactMobilePhoneNumber($coCreatorContactMobilePhoneNumber);

			if (isset($row['co_recipient_contact_id'])) {
				$co_recipient_contact_id = $row['co_recipient_contact_id'];
				$row['co_fk_recipient_c__id'] = $co_recipient_contact_id;
				$coRecipientContact = self::instantiateOrm($database, 'Contact', $row, null, $co_recipient_contact_id, 'co_fk_recipient_c__');
				/* @var $coRecipientContact Contact */
				$coRecipientContact->convertPropertiesToData();
			} else {
				$coRecipientContact = false;
			}
			$changeOrder->setCoRecipientContact($coRecipientContact);

			if (isset($row['co_recipient_contact_company_office_id'])) {
				$co_recipient_contact_company_office_id = $row['co_recipient_contact_company_office_id'];
				$row['co_fk_recipient_cco__id'] = $co_recipient_contact_company_office_id;
				$coRecipientContactCompanyOffice = self::instantiateOrm($database, 'ContactCompanyOffice', $row, null, $co_recipient_contact_company_office_id, 'co_fk_recipient_cco__');
				/* @var $coRecipientContactCompanyOffice ContactCompanyOffice */
				$coRecipientContactCompanyOffice->convertPropertiesToData();
			} else {
				$coRecipientContactCompanyOffice = false;
			}
			$changeOrder->setCoRecipientContactCompanyOffice($coRecipientContactCompanyOffice);

			if (isset($row['co_recipient_phone_contact_company_office_phone_number_id'])) {
				$co_recipient_phone_contact_company_office_phone_number_id = $row['co_recipient_phone_contact_company_office_phone_number_id'];
				$row['co_fk_recipient_phone_ccopn__id'] = $co_recipient_phone_contact_company_office_phone_number_id;
				$coRecipientPhoneContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $co_recipient_phone_contact_company_office_phone_number_id, 'co_fk_recipient_phone_ccopn__');
				/* @var $coRecipientPhoneContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$coRecipientPhoneContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$coRecipientPhoneContactCompanyOfficePhoneNumber = false;
			}
			$changeOrder->setCoRecipientPhoneContactCompanyOfficePhoneNumber($coRecipientPhoneContactCompanyOfficePhoneNumber);

			if (isset($row['co_recipient_fax_contact_company_office_phone_number_id'])) {
				$co_recipient_fax_contact_company_office_phone_number_id = $row['co_recipient_fax_contact_company_office_phone_number_id'];
				$row['co_fk_recipient_fax_ccopn__id'] = $co_recipient_fax_contact_company_office_phone_number_id;
				$coRecipientFaxContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $co_recipient_fax_contact_company_office_phone_number_id, 'co_fk_recipient_fax_ccopn__');
				/* @var $coRecipientFaxContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$coRecipientFaxContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$coRecipientFaxContactCompanyOfficePhoneNumber = false;
			}
			$changeOrder->setCoRecipientFaxContactCompanyOfficePhoneNumber($coRecipientFaxContactCompanyOfficePhoneNumber);

			if (isset($row['co_recipient_contact_mobile_phone_number_id'])) {
				$co_recipient_contact_mobile_phone_number_id = $row['co_recipient_contact_mobile_phone_number_id'];
				$row['co_fk_recipient_c_mobile_cpn__id'] = $co_recipient_contact_mobile_phone_number_id;
				$coRecipientContactMobilePhoneNumber = self::instantiateOrm($database, 'ContactPhoneNumber', $row, null, $co_recipient_contact_mobile_phone_number_id, 'co_fk_recipient_c_mobile_cpn__');
				/* @var $coRecipientContactMobilePhoneNumber ContactPhoneNumber */
				$coRecipientContactMobilePhoneNumber->convertPropertiesToData();
			} else {
				$coRecipientContactMobilePhoneNumber = false;
			}
			$changeOrder->setCoRecipientContactMobilePhoneNumber($coRecipientContactMobilePhoneNumber);

			if (isset($row['co_initiator_contact_id'])) {
				$co_initiator_contact_id = $row['co_initiator_contact_id'];
				$row['co_fk_initiator_c__id'] = $co_initiator_contact_id;
				$coInitiatorContact = self::instantiateOrm($database, 'Contact', $row, null, $co_initiator_contact_id, 'co_fk_initiator_c__');
				/* @var $coInitiatorContact Contact */
				$coInitiatorContact->convertPropertiesToData();
			} else {
				$coInitiatorContact = false;
			}
			$changeOrder->setCoInitiatorContact($coInitiatorContact);

			if (isset($row['co_initiator_contact_company_office_id'])) {
				$co_initiator_contact_company_office_id = $row['co_initiator_contact_company_office_id'];
				$row['co_fk_initiator_cco__id'] = $co_initiator_contact_company_office_id;
				$coInitiatorContactCompanyOffice = self::instantiateOrm($database, 'ContactCompanyOffice', $row, null, $co_initiator_contact_company_office_id, 'co_fk_initiator_cco__');
				/* @var $coInitiatorContactCompanyOffice ContactCompanyOffice */
				$coInitiatorContactCompanyOffice->convertPropertiesToData();
			} else {
				$coInitiatorContactCompanyOffice = false;
			}
			$changeOrder->setCoInitiatorContactCompanyOffice($coInitiatorContactCompanyOffice);

			if (isset($row['co_initiator_phone_contact_company_office_phone_number_id'])) {
				$co_initiator_phone_contact_company_office_phone_number_id = $row['co_initiator_phone_contact_company_office_phone_number_id'];
				$row['co_fk_initiator_phone_ccopn__id'] = $co_initiator_phone_contact_company_office_phone_number_id;
				$coInitiatorPhoneContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $co_initiator_phone_contact_company_office_phone_number_id, 'co_fk_initiator_phone_ccopn__');
				/* @var $coInitiatorPhoneContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$coInitiatorPhoneContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$coInitiatorPhoneContactCompanyOfficePhoneNumber = false;
			}
			$changeOrder->setCoInitiatorPhoneContactCompanyOfficePhoneNumber($coInitiatorPhoneContactCompanyOfficePhoneNumber);

			if (isset($row['co_initiator_fax_contact_company_office_phone_number_id'])) {
				$co_initiator_fax_contact_company_office_phone_number_id = $row['co_initiator_fax_contact_company_office_phone_number_id'];
				$row['co_fk_initiator_fax_ccopn__id'] = $co_initiator_fax_contact_company_office_phone_number_id;
				$coInitiatorFaxContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $co_initiator_fax_contact_company_office_phone_number_id, 'co_fk_initiator_fax_ccopn__');
				/* @var $coInitiatorFaxContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$coInitiatorFaxContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$coInitiatorFaxContactCompanyOfficePhoneNumber = false;
			}
			$changeOrder->setCoInitiatorFaxContactCompanyOfficePhoneNumber($coInitiatorFaxContactCompanyOfficePhoneNumber);

			if (isset($row['co_initiator_contact_mobile_phone_number_id'])) {
				$co_initiator_contact_mobile_phone_number_id = $row['co_initiator_contact_mobile_phone_number_id'];
				$row['co_fk_initiator_c_mobile_cpn__id'] = $co_initiator_contact_mobile_phone_number_id;
				$coInitiatorContactMobilePhoneNumber = self::instantiateOrm($database, 'ContactPhoneNumber', $row, null, $co_initiator_contact_mobile_phone_number_id, 'co_fk_initiator_c_mobile_cpn__');
				/* @var $coInitiatorContactMobilePhoneNumber ContactPhoneNumber */
				$coInitiatorContactMobilePhoneNumber->convertPropertiesToData();
			} else {
				$coInitiatorContactMobilePhoneNumber = false;
			}
			$changeOrder->setCoInitiatorContactMobilePhoneNumber($coInitiatorContactMobilePhoneNumber);

			$arrChangeOrdersByProjectId[$change_order_id] = $changeOrder;
		}

		$db->free_result();

		self::$_arrChangeOrdersByProjectId = $arrChangeOrdersByProjectId;

		return $arrChangeOrdersByProjectId;
	}
/**
	 * Load by constraint `change_orders_fk_p` foreign key (`project_id`) references `projects` (`id`) on delete cascade on update cascade.for Report Job status
	 *
	 * @param string $database
	 * @param int $project_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadChangeOrdersByProjectIdPotential($database, $project_id, $new_begindate, $enddate,Input $options=null, $checkRtype)
	{
		$change_order_type_id = false;
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

			if (isset($options->change_order_type_id) && !empty($options->change_order_type_id)) {
				$change_order_type_id = $options->change_order_type_id;
			}
		}
		if($change_order_type_id != ''){
			$whereIn = "and co.change_order_type_id IN(".$change_order_type_id.")";
		}else{
			if($checkRtype != 'CO')
				$whereIn = "and co.change_order_type_id IN(1)";
			else
				$whereIn = "";
		}

		if ($forceLoadFlag) {
			self::$_arrChangeOrdersByProjectId = null;
		}

		$arrChangeOrdersByProjectId = self::$_arrChangeOrdersByProjectId;
		if (isset($arrChangeOrdersByProjectId) && !empty($arrChangeOrdersByProjectId)) {
			return $arrChangeOrdersByProjectId;
		}

		$project_id = (int) $project_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$sqlFilter = '';
		if ($change_order_type_id) {
			$escaped_change_order_type_id = $db->escape($change_order_type_id);
			// $sqlFilter = "\nAND co.`change_order_type_id` = $escaped_change_order_type_id";
		}

	
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$sqlOrderBy = "\nORDER BY $arrOrderByAttributes";
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

	co_fk_p.`id` AS 'co_fk_p__project_id',
	co_fk_p.`project_type_id` AS 'co_fk_p__project_type_id',
	co_fk_p.`user_company_id` AS 'co_fk_p__user_company_id',
	co_fk_p.`user_custom_project_id` AS 'co_fk_p__user_custom_project_id',
	co_fk_p.`project_name` AS 'co_fk_p__project_name',
	co_fk_p.`project_owner_name` AS 'co_fk_p__project_owner_name',
	co_fk_p.`latitude` AS 'co_fk_p__latitude',
	co_fk_p.`longitude` AS 'co_fk_p__longitude',
	co_fk_p.`address_line_1` AS 'co_fk_p__address_line_1',
	co_fk_p.`address_line_2` AS 'co_fk_p__address_line_2',
	co_fk_p.`address_line_3` AS 'co_fk_p__address_line_3',
	co_fk_p.`address_line_4` AS 'co_fk_p__address_line_4',
	co_fk_p.`address_city` AS 'co_fk_p__address_city',
	co_fk_p.`address_county` AS 'co_fk_p__address_county',
	co_fk_p.`address_state_or_region` AS 'co_fk_p__address_state_or_region',
	co_fk_p.`address_postal_code` AS 'co_fk_p__address_postal_code',
	co_fk_p.`address_postal_code_extension` AS 'co_fk_p__address_postal_code_extension',
	co_fk_p.`address_country` AS 'co_fk_p__address_country',
	co_fk_p.`building_count` AS 'co_fk_p__building_count',
	co_fk_p.`unit_count` AS 'co_fk_p__unit_count',
	co_fk_p.`gross_square_footage` AS 'co_fk_p__gross_square_footage',
	co_fk_p.`net_rentable_square_footage` AS 'co_fk_p__net_rentable_square_footage',
	co_fk_p.`is_active_flag` AS 'co_fk_p__is_active_flag',
	co_fk_p.`public_plans_flag` AS 'co_fk_p__public_plans_flag',
	co_fk_p.`prevailing_wage_flag` AS 'co_fk_p__prevailing_wage_flag',
	co_fk_p.`city_business_license_required_flag` AS 'co_fk_p__city_business_license_required_flag',
	co_fk_p.`is_internal_flag` AS 'co_fk_p__is_internal_flag',
	co_fk_p.`project_contract_date` AS 'co_fk_p__project_contract_date',
	co_fk_p.`project_start_date` AS 'co_fk_p__project_start_date',
	co_fk_p.`project_completed_date` AS 'co_fk_p__project_completed_date',
	co_fk_p.`sort_order` AS 'co_fk_p__sort_order',

	co_fk_cot.`id` AS 'co_fk_cot__change_order_type_id',
	co_fk_cot.`change_order_type` AS 'co_fk_cot__change_order_type',
	co_fk_cot.`disabled_flag` AS 'co_fk_cot__disabled_flag',

	co_fk_cos.`id` AS 'co_fk_cos__change_order_status_id',
	co_fk_cos.`change_order_status` AS 'co_fk_cos__change_order_status',
	co_fk_cos.`disabled_flag` AS 'co_fk_cos__disabled_flag',

	co_fk_cop.`id` AS 'co_fk_cop__change_order_priority_id',
	co_fk_cop.`change_order_priority` AS 'co_fk_cop__change_order_priority',
	co_fk_cop.`disabled_flag` AS 'co_fk_cop__disabled_flag',

	co_fk_fmfiles.`id` AS 'co_fk_fmfiles__file_manager_file_id',
	co_fk_fmfiles.`user_company_id` AS 'co_fk_fmfiles__user_company_id',
	co_fk_fmfiles.`contact_id` AS 'co_fk_fmfiles__contact_id',
	co_fk_fmfiles.`project_id` AS 'co_fk_fmfiles__project_id',
	co_fk_fmfiles.`file_manager_folder_id` AS 'co_fk_fmfiles__file_manager_folder_id',
	co_fk_fmfiles.`file_location_id` AS 'co_fk_fmfiles__file_location_id',
	co_fk_fmfiles.`virtual_file_name` AS 'co_fk_fmfiles__virtual_file_name',
	co_fk_fmfiles.`version_number` AS 'co_fk_fmfiles__version_number',
	co_fk_fmfiles.`virtual_file_name_sha1` AS 'co_fk_fmfiles__virtual_file_name_sha1',
	co_fk_fmfiles.`virtual_file_mime_type` AS 'co_fk_fmfiles__virtual_file_mime_type',
	co_fk_fmfiles.`modified` AS 'co_fk_fmfiles__modified',
	co_fk_fmfiles.`created` AS 'co_fk_fmfiles__created',
	co_fk_fmfiles.`deleted_flag` AS 'co_fk_fmfiles__deleted_flag',
	co_fk_fmfiles.`directly_deleted_flag` AS 'co_fk_fmfiles__directly_deleted_flag',

	co_fk_codes.`id` AS 'co_fk_codes__cost_code_id',
	co_fk_codes.`cost_code_division_id` AS 'co_fk_codes__cost_code_division_id',
	co_fk_codes.`cost_code` AS 'co_fk_codes__cost_code',
	co_fk_codes.`cost_code_description` AS 'co_fk_codes__cost_code_description',
	co_fk_codes.`cost_code_description_abbreviation` AS 'co_fk_codes__cost_code_description_abbreviation',
	co_fk_codes.`sort_order` AS 'co_fk_codes__sort_order',
	co_fk_codes.`disabled_flag` AS 'co_fk_codes__disabled_flag',

	co_fk_creator_c.`id` AS 'co_fk_creator_c__contact_id',
	co_fk_creator_c.`user_company_id` AS 'co_fk_creator_c__user_company_id',
	co_fk_creator_c.`user_id` AS 'co_fk_creator_c__user_id',
	co_fk_creator_c.`contact_company_id` AS 'co_fk_creator_c__contact_company_id',
	co_fk_creator_c.`email` AS 'co_fk_creator_c__email',
	co_fk_creator_c.`name_prefix` AS 'co_fk_creator_c__name_prefix',
	co_fk_creator_c.`first_name` AS 'co_fk_creator_c__first_name',
	co_fk_creator_c.`additional_name` AS 'co_fk_creator_c__additional_name',
	co_fk_creator_c.`middle_name` AS 'co_fk_creator_c__middle_name',
	co_fk_creator_c.`last_name` AS 'co_fk_creator_c__last_name',
	co_fk_creator_c.`name_suffix` AS 'co_fk_creator_c__name_suffix',
	co_fk_creator_c.`title` AS 'co_fk_creator_c__title',
	co_fk_creator_c.`vendor_flag` AS 'co_fk_creator_c__vendor_flag',

	co_fk_creator_cco.`id` AS 'co_fk_creator_cco__contact_company_office_id',
	co_fk_creator_cco.`contact_company_id` AS 'co_fk_creator_cco__contact_company_id',
	co_fk_creator_cco.`office_nickname` AS 'co_fk_creator_cco__office_nickname',
	co_fk_creator_cco.`address_line_1` AS 'co_fk_creator_cco__address_line_1',
	co_fk_creator_cco.`address_line_2` AS 'co_fk_creator_cco__address_line_2',
	co_fk_creator_cco.`address_line_3` AS 'co_fk_creator_cco__address_line_3',
	co_fk_creator_cco.`address_line_4` AS 'co_fk_creator_cco__address_line_4',
	co_fk_creator_cco.`address_city` AS 'co_fk_creator_cco__address_city',
	co_fk_creator_cco.`address_county` AS 'co_fk_creator_cco__address_county',
	co_fk_creator_cco.`address_state_or_region` AS 'co_fk_creator_cco__address_state_or_region',
	co_fk_creator_cco.`address_postal_code` AS 'co_fk_creator_cco__address_postal_code',
	co_fk_creator_cco.`address_postal_code_extension` AS 'co_fk_creator_cco__address_postal_code_extension',
	co_fk_creator_cco.`address_country` AS 'co_fk_creator_cco__address_country',
	co_fk_creator_cco.`head_quarters_flag` AS 'co_fk_creator_cco__head_quarters_flag',
	co_fk_creator_cco.`address_validated_by_user_flag` AS 'co_fk_creator_cco__address_validated_by_user_flag',
	co_fk_creator_cco.`address_validated_by_web_service_flag` AS 'co_fk_creator_cco__address_validated_by_web_service_flag',
	co_fk_creator_cco.`address_validation_by_web_service_error_flag` AS 'co_fk_creator_cco__address_validation_by_web_service_error_flag',

	co_fk_creator_phone_ccopn.`id` AS 'co_fk_creator_phone_ccopn__contact_company_office_phone_number_id',
	co_fk_creator_phone_ccopn.`contact_company_office_id` AS 'co_fk_creator_phone_ccopn__contact_company_office_id',
	co_fk_creator_phone_ccopn.`phone_number_type_id` AS 'co_fk_creator_phone_ccopn__phone_number_type_id',
	co_fk_creator_phone_ccopn.`country_code` AS 'co_fk_creator_phone_ccopn__country_code',
	co_fk_creator_phone_ccopn.`area_code` AS 'co_fk_creator_phone_ccopn__area_code',
	co_fk_creator_phone_ccopn.`prefix` AS 'co_fk_creator_phone_ccopn__prefix',
	co_fk_creator_phone_ccopn.`number` AS 'co_fk_creator_phone_ccopn__number',
	co_fk_creator_phone_ccopn.`extension` AS 'co_fk_creator_phone_ccopn__extension',
	co_fk_creator_phone_ccopn.`itu` AS 'co_fk_creator_phone_ccopn__itu',

	co_fk_creator_fax_ccopn.`id` AS 'co_fk_creator_fax_ccopn__contact_company_office_phone_number_id',
	co_fk_creator_fax_ccopn.`contact_company_office_id` AS 'co_fk_creator_fax_ccopn__contact_company_office_id',
	co_fk_creator_fax_ccopn.`phone_number_type_id` AS 'co_fk_creator_fax_ccopn__phone_number_type_id',
	co_fk_creator_fax_ccopn.`country_code` AS 'co_fk_creator_fax_ccopn__country_code',
	co_fk_creator_fax_ccopn.`area_code` AS 'co_fk_creator_fax_ccopn__area_code',
	co_fk_creator_fax_ccopn.`prefix` AS 'co_fk_creator_fax_ccopn__prefix',
	co_fk_creator_fax_ccopn.`number` AS 'co_fk_creator_fax_ccopn__number',
	co_fk_creator_fax_ccopn.`extension` AS 'co_fk_creator_fax_ccopn__extension',
	co_fk_creator_fax_ccopn.`itu` AS 'co_fk_creator_fax_ccopn__itu',

	co_fk_creator_c_mobile_cpn.`id` AS 'co_fk_creator_c_mobile_cpn__contact_phone_number_id',
	co_fk_creator_c_mobile_cpn.`contact_id` AS 'co_fk_creator_c_mobile_cpn__contact_id',
	co_fk_creator_c_mobile_cpn.`phone_number_type_id` AS 'co_fk_creator_c_mobile_cpn__phone_number_type_id',
	co_fk_creator_c_mobile_cpn.`country_code` AS 'co_fk_creator_c_mobile_cpn__country_code',
	co_fk_creator_c_mobile_cpn.`area_code` AS 'co_fk_creator_c_mobile_cpn__area_code',
	co_fk_creator_c_mobile_cpn.`prefix` AS 'co_fk_creator_c_mobile_cpn__prefix',
	co_fk_creator_c_mobile_cpn.`number` AS 'co_fk_creator_c_mobile_cpn__number',
	co_fk_creator_c_mobile_cpn.`extension` AS 'co_fk_creator_c_mobile_cpn__extension',
	co_fk_creator_c_mobile_cpn.`itu` AS 'co_fk_creator_c_mobile_cpn__itu',

	co_fk_recipient_c.`id` AS 'co_fk_recipient_c__contact_id',
	co_fk_recipient_c.`user_company_id` AS 'co_fk_recipient_c__user_company_id',
	co_fk_recipient_c.`user_id` AS 'co_fk_recipient_c__user_id',
	co_fk_recipient_c.`contact_company_id` AS 'co_fk_recipient_c__contact_company_id',
	co_fk_recipient_c.`email` AS 'co_fk_recipient_c__email',
	co_fk_recipient_c.`name_prefix` AS 'co_fk_recipient_c__name_prefix',
	co_fk_recipient_c.`first_name` AS 'co_fk_recipient_c__first_name',
	co_fk_recipient_c.`additional_name` AS 'co_fk_recipient_c__additional_name',
	co_fk_recipient_c.`middle_name` AS 'co_fk_recipient_c__middle_name',
	co_fk_recipient_c.`last_name` AS 'co_fk_recipient_c__last_name',
	co_fk_recipient_c.`name_suffix` AS 'co_fk_recipient_c__name_suffix',
	co_fk_recipient_c.`title` AS 'co_fk_recipient_c__title',
	co_fk_recipient_c.`vendor_flag` AS 'co_fk_recipient_c__vendor_flag',

	co_fk_recipient_cco.`id` AS 'co_fk_recipient_cco__contact_company_office_id',
	co_fk_recipient_cco.`contact_company_id` AS 'co_fk_recipient_cco__contact_company_id',
	co_fk_recipient_cco.`office_nickname` AS 'co_fk_recipient_cco__office_nickname',
	co_fk_recipient_cco.`address_line_1` AS 'co_fk_recipient_cco__address_line_1',
	co_fk_recipient_cco.`address_line_2` AS 'co_fk_recipient_cco__address_line_2',
	co_fk_recipient_cco.`address_line_3` AS 'co_fk_recipient_cco__address_line_3',
	co_fk_recipient_cco.`address_line_4` AS 'co_fk_recipient_cco__address_line_4',
	co_fk_recipient_cco.`address_city` AS 'co_fk_recipient_cco__address_city',
	co_fk_recipient_cco.`address_county` AS 'co_fk_recipient_cco__address_county',
	co_fk_recipient_cco.`address_state_or_region` AS 'co_fk_recipient_cco__address_state_or_region',
	co_fk_recipient_cco.`address_postal_code` AS 'co_fk_recipient_cco__address_postal_code',
	co_fk_recipient_cco.`address_postal_code_extension` AS 'co_fk_recipient_cco__address_postal_code_extension',
	co_fk_recipient_cco.`address_country` AS 'co_fk_recipient_cco__address_country',
	co_fk_recipient_cco.`head_quarters_flag` AS 'co_fk_recipient_cco__head_quarters_flag',
	co_fk_recipient_cco.`address_validated_by_user_flag` AS 'co_fk_recipient_cco__address_validated_by_user_flag',
	co_fk_recipient_cco.`address_validated_by_web_service_flag` AS 'co_fk_recipient_cco__address_validated_by_web_service_flag',
	co_fk_recipient_cco.`address_validation_by_web_service_error_flag` AS 'co_fk_recipient_cco__address_validation_by_web_service_error_flag',

	co_fk_recipient_phone_ccopn.`id` AS 'co_fk_recipient_phone_ccopn__contact_company_office_phone_number_id',
	co_fk_recipient_phone_ccopn.`contact_company_office_id` AS 'co_fk_recipient_phone_ccopn__contact_company_office_id',
	co_fk_recipient_phone_ccopn.`phone_number_type_id` AS 'co_fk_recipient_phone_ccopn__phone_number_type_id',
	co_fk_recipient_phone_ccopn.`country_code` AS 'co_fk_recipient_phone_ccopn__country_code',
	co_fk_recipient_phone_ccopn.`area_code` AS 'co_fk_recipient_phone_ccopn__area_code',
	co_fk_recipient_phone_ccopn.`prefix` AS 'co_fk_recipient_phone_ccopn__prefix',
	co_fk_recipient_phone_ccopn.`number` AS 'co_fk_recipient_phone_ccopn__number',
	co_fk_recipient_phone_ccopn.`extension` AS 'co_fk_recipient_phone_ccopn__extension',
	co_fk_recipient_phone_ccopn.`itu` AS 'co_fk_recipient_phone_ccopn__itu',

	co_fk_recipient_fax_ccopn.`id` AS 'co_fk_recipient_fax_ccopn__contact_company_office_phone_number_id',
	co_fk_recipient_fax_ccopn.`contact_company_office_id` AS 'co_fk_recipient_fax_ccopn__contact_company_office_id',
	co_fk_recipient_fax_ccopn.`phone_number_type_id` AS 'co_fk_recipient_fax_ccopn__phone_number_type_id',
	co_fk_recipient_fax_ccopn.`country_code` AS 'co_fk_recipient_fax_ccopn__country_code',
	co_fk_recipient_fax_ccopn.`area_code` AS 'co_fk_recipient_fax_ccopn__area_code',
	co_fk_recipient_fax_ccopn.`prefix` AS 'co_fk_recipient_fax_ccopn__prefix',
	co_fk_recipient_fax_ccopn.`number` AS 'co_fk_recipient_fax_ccopn__number',
	co_fk_recipient_fax_ccopn.`extension` AS 'co_fk_recipient_fax_ccopn__extension',
	co_fk_recipient_fax_ccopn.`itu` AS 'co_fk_recipient_fax_ccopn__itu',

	co_fk_recipient_c_mobile_cpn.`id` AS 'co_fk_recipient_c_mobile_cpn__contact_phone_number_id',
	co_fk_recipient_c_mobile_cpn.`contact_id` AS 'co_fk_recipient_c_mobile_cpn__contact_id',
	co_fk_recipient_c_mobile_cpn.`phone_number_type_id` AS 'co_fk_recipient_c_mobile_cpn__phone_number_type_id',
	co_fk_recipient_c_mobile_cpn.`country_code` AS 'co_fk_recipient_c_mobile_cpn__country_code',
	co_fk_recipient_c_mobile_cpn.`area_code` AS 'co_fk_recipient_c_mobile_cpn__area_code',
	co_fk_recipient_c_mobile_cpn.`prefix` AS 'co_fk_recipient_c_mobile_cpn__prefix',
	co_fk_recipient_c_mobile_cpn.`number` AS 'co_fk_recipient_c_mobile_cpn__number',
	co_fk_recipient_c_mobile_cpn.`extension` AS 'co_fk_recipient_c_mobile_cpn__extension',
	co_fk_recipient_c_mobile_cpn.`itu` AS 'co_fk_recipient_c_mobile_cpn__itu',

	co_fk_initiator_c.`id` AS 'co_fk_initiator_c__contact_id',
	co_fk_initiator_c.`user_company_id` AS 'co_fk_initiator_c__user_company_id',
	co_fk_initiator_c.`user_id` AS 'co_fk_initiator_c__user_id',
	co_fk_initiator_c.`contact_company_id` AS 'co_fk_initiator_c__contact_company_id',
	co_fk_initiator_c.`email` AS 'co_fk_initiator_c__email',
	co_fk_initiator_c.`name_prefix` AS 'co_fk_initiator_c__name_prefix',
	co_fk_initiator_c.`first_name` AS 'co_fk_initiator_c__first_name',
	co_fk_initiator_c.`additional_name` AS 'co_fk_initiator_c__additional_name',
	co_fk_initiator_c.`middle_name` AS 'co_fk_initiator_c__middle_name',
	co_fk_initiator_c.`last_name` AS 'co_fk_initiator_c__last_name',
	co_fk_initiator_c.`name_suffix` AS 'co_fk_initiator_c__name_suffix',
	co_fk_initiator_c.`title` AS 'co_fk_initiator_c__title',
	co_fk_initiator_c.`vendor_flag` AS 'co_fk_initiator_c__vendor_flag',

	co_fk_initiator_cco.`id` AS 'co_fk_initiator_cco__contact_company_office_id',
	co_fk_initiator_cco.`contact_company_id` AS 'co_fk_initiator_cco__contact_company_id',
	co_fk_initiator_cco.`office_nickname` AS 'co_fk_initiator_cco__office_nickname',
	co_fk_initiator_cco.`address_line_1` AS 'co_fk_initiator_cco__address_line_1',
	co_fk_initiator_cco.`address_line_2` AS 'co_fk_initiator_cco__address_line_2',
	co_fk_initiator_cco.`address_line_3` AS 'co_fk_initiator_cco__address_line_3',
	co_fk_initiator_cco.`address_line_4` AS 'co_fk_initiator_cco__address_line_4',
	co_fk_initiator_cco.`address_city` AS 'co_fk_initiator_cco__address_city',
	co_fk_initiator_cco.`address_county` AS 'co_fk_initiator_cco__address_county',
	co_fk_initiator_cco.`address_state_or_region` AS 'co_fk_initiator_cco__address_state_or_region',
	co_fk_initiator_cco.`address_postal_code` AS 'co_fk_initiator_cco__address_postal_code',
	co_fk_initiator_cco.`address_postal_code_extension` AS 'co_fk_initiator_cco__address_postal_code_extension',
	co_fk_initiator_cco.`address_country` AS 'co_fk_initiator_cco__address_country',
	co_fk_initiator_cco.`head_quarters_flag` AS 'co_fk_initiator_cco__head_quarters_flag',
	co_fk_initiator_cco.`address_validated_by_user_flag` AS 'co_fk_initiator_cco__address_validated_by_user_flag',
	co_fk_initiator_cco.`address_validated_by_web_service_flag` AS 'co_fk_initiator_cco__address_validated_by_web_service_flag',
	co_fk_initiator_cco.`address_validation_by_web_service_error_flag` AS 'co_fk_initiator_cco__address_validation_by_web_service_error_flag',

	co_fk_initiator_phone_ccopn.`id` AS 'co_fk_initiator_phone_ccopn__contact_company_office_phone_number_id',
	co_fk_initiator_phone_ccopn.`contact_company_office_id` AS 'co_fk_initiator_phone_ccopn__contact_company_office_id',
	co_fk_initiator_phone_ccopn.`phone_number_type_id` AS 'co_fk_initiator_phone_ccopn__phone_number_type_id',
	co_fk_initiator_phone_ccopn.`country_code` AS 'co_fk_initiator_phone_ccopn__country_code',
	co_fk_initiator_phone_ccopn.`area_code` AS 'co_fk_initiator_phone_ccopn__area_code',
	co_fk_initiator_phone_ccopn.`prefix` AS 'co_fk_initiator_phone_ccopn__prefix',
	co_fk_initiator_phone_ccopn.`number` AS 'co_fk_initiator_phone_ccopn__number',
	co_fk_initiator_phone_ccopn.`extension` AS 'co_fk_initiator_phone_ccopn__extension',
	co_fk_initiator_phone_ccopn.`itu` AS 'co_fk_initiator_phone_ccopn__itu',

	co_fk_initiator_fax_ccopn.`id` AS 'co_fk_initiator_fax_ccopn__contact_company_office_phone_number_id',
	co_fk_initiator_fax_ccopn.`contact_company_office_id` AS 'co_fk_initiator_fax_ccopn__contact_company_office_id',
	co_fk_initiator_fax_ccopn.`phone_number_type_id` AS 'co_fk_initiator_fax_ccopn__phone_number_type_id',
	co_fk_initiator_fax_ccopn.`country_code` AS 'co_fk_initiator_fax_ccopn__country_code',
	co_fk_initiator_fax_ccopn.`area_code` AS 'co_fk_initiator_fax_ccopn__area_code',
	co_fk_initiator_fax_ccopn.`prefix` AS 'co_fk_initiator_fax_ccopn__prefix',
	co_fk_initiator_fax_ccopn.`number` AS 'co_fk_initiator_fax_ccopn__number',
	co_fk_initiator_fax_ccopn.`extension` AS 'co_fk_initiator_fax_ccopn__extension',
	co_fk_initiator_fax_ccopn.`itu` AS 'co_fk_initiator_fax_ccopn__itu',

	co_fk_initiator_c_mobile_cpn.`id` AS 'co_fk_initiator_c_mobile_cpn__contact_phone_number_id',
	co_fk_initiator_c_mobile_cpn.`contact_id` AS 'co_fk_initiator_c_mobile_cpn__contact_id',
	co_fk_initiator_c_mobile_cpn.`phone_number_type_id` AS 'co_fk_initiator_c_mobile_cpn__phone_number_type_id',
	co_fk_initiator_c_mobile_cpn.`country_code` AS 'co_fk_initiator_c_mobile_cpn__country_code',
	co_fk_initiator_c_mobile_cpn.`area_code` AS 'co_fk_initiator_c_mobile_cpn__area_code',
	co_fk_initiator_c_mobile_cpn.`prefix` AS 'co_fk_initiator_c_mobile_cpn__prefix',
	co_fk_initiator_c_mobile_cpn.`number` AS 'co_fk_initiator_c_mobile_cpn__number',
	co_fk_initiator_c_mobile_cpn.`extension` AS 'co_fk_initiator_c_mobile_cpn__extension',
	co_fk_initiator_c_mobile_cpn.`itu` AS 'co_fk_initiator_c_mobile_cpn__itu',

	co.*

FROM `change_orders` co
	INNER JOIN `projects` co_fk_p ON co.`project_id` = co_fk_p.`id`
	INNER JOIN `change_order_types` co_fk_cot ON co.`change_order_type_id` = co_fk_cot.`id`
	INNER JOIN `change_order_statuses` co_fk_cos ON co.`change_order_status_id` = co_fk_cos.`id`
	LEFT OUTER JOIN `change_order_priorities` co_fk_cop ON co.`change_order_priority_id` = co_fk_cop.`id`
	LEFT OUTER JOIN `file_manager_files` co_fk_fmfiles ON co.`co_file_manager_file_id` = co_fk_fmfiles.`id`
	LEFT OUTER JOIN `cost_codes` co_fk_codes ON co.`co_cost_code_id` = co_fk_codes.`id`
	INNER JOIN `contacts` co_fk_creator_c ON co.`co_creator_contact_id` = co_fk_creator_c.`id`
	LEFT OUTER JOIN `contact_company_offices` co_fk_creator_cco ON co.`co_creator_contact_company_office_id` = co_fk_creator_cco.`id`
	LEFT OUTER JOIN `contact_company_office_phone_numbers` co_fk_creator_phone_ccopn ON co.`co_creator_phone_contact_company_office_phone_number_id` = co_fk_creator_phone_ccopn.`id`
	LEFT OUTER JOIN `contact_company_office_phone_numbers` co_fk_creator_fax_ccopn ON co.`co_creator_fax_contact_company_office_phone_number_id` = co_fk_creator_fax_ccopn.`id`
	LEFT OUTER JOIN `contact_phone_numbers` co_fk_creator_c_mobile_cpn ON co.`co_creator_contact_mobile_phone_number_id` = co_fk_creator_c_mobile_cpn.`id`
	LEFT OUTER JOIN `contacts` co_fk_recipient_c ON co.`co_recipient_contact_id` = co_fk_recipient_c.`id`
	LEFT OUTER JOIN `contact_company_offices` co_fk_recipient_cco ON co.`co_recipient_contact_company_office_id` = co_fk_recipient_cco.`id`
	LEFT OUTER JOIN `contact_company_office_phone_numbers` co_fk_recipient_phone_ccopn ON co.`co_recipient_phone_contact_company_office_phone_number_id` = co_fk_recipient_phone_ccopn.`id`
	LEFT OUTER JOIN `contact_company_office_phone_numbers` co_fk_recipient_fax_ccopn ON co.`co_recipient_fax_contact_company_office_phone_number_id` = co_fk_recipient_fax_ccopn.`id`
	LEFT OUTER JOIN `contact_phone_numbers` co_fk_recipient_c_mobile_cpn ON co.`co_recipient_contact_mobile_phone_number_id` = co_fk_recipient_c_mobile_cpn.`id`
	LEFT OUTER JOIN `contacts` co_fk_initiator_c ON co.`co_initiator_contact_id` = co_fk_initiator_c.`id`
	LEFT OUTER JOIN `contact_company_offices` co_fk_initiator_cco ON co.`co_initiator_contact_company_office_id` = co_fk_initiator_cco.`id`
	LEFT OUTER JOIN `contact_company_office_phone_numbers` co_fk_initiator_phone_ccopn ON co.`co_initiator_phone_contact_company_office_phone_number_id` = co_fk_initiator_phone_ccopn.`id`
	LEFT OUTER JOIN `contact_company_office_phone_numbers` co_fk_initiator_fax_ccopn ON co.`co_initiator_fax_contact_company_office_phone_number_id` = co_fk_initiator_fax_ccopn.`id`
	LEFT OUTER JOIN `contact_phone_numbers` co_fk_initiator_c_mobile_cpn ON co.`co_initiator_contact_mobile_phone_number_id` = co_fk_initiator_c_mobile_cpn.`id`
WHERE co.`project_id` = ? $whereIn and date(co.created) BETWEEN '$new_begindate' AND '$enddate' {$sqlFilter}{$sqlOrderBy}{$sqlLimit}
";

		$arrValues = array($project_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrChangeOrdersByProjectId = array();
		while ($row = $db->fetch()) {
			$change_order_id = $row['id'];
			$changeOrder = self::instantiateOrm($database, 'ChangeOrder', $row, null, $change_order_id);
			/* @var $changeOrder ChangeOrder */
			$changeOrder->convertPropertiesToData();

			if (isset($row['project_id'])) {
				$project_id = $row['project_id'];
				$row['co_fk_p__id'] = $project_id;
				$project = self::instantiateOrm($database, 'Project', $row, null, $project_id, 'co_fk_p__');
				/* @var $project Project */
				$project->convertPropertiesToData();
			} else {
				$project = false;
			}
			$changeOrder->setProject($project);

			if (isset($row['change_order_type_id'])) {
				$change_order_type_id = $row['change_order_type_id'];
				$row['co_fk_cot__id'] = $change_order_type_id;
				$changeOrderType = self::instantiateOrm($database, 'ChangeOrderType', $row, null, $change_order_type_id, 'co_fk_cot__');
				/* @var $changeOrderType ChangeOrderType */
				$changeOrderType->convertPropertiesToData();
			} else {
				$changeOrderType = false;
			}
			$changeOrder->setChangeOrderType($changeOrderType);

			if (isset($row['change_order_status_id'])) {
				$change_order_status_id = $row['change_order_status_id'];
				$row['co_fk_cos__id'] = $change_order_status_id;
				$changeOrderStatus = self::instantiateOrm($database, 'ChangeOrderStatus', $row, null, $change_order_status_id, 'co_fk_cos__');
				/* @var $changeOrderStatus ChangeOrderStatus */
				$changeOrderStatus->convertPropertiesToData();
			} else {
				$changeOrderStatus = false;
			}
			$changeOrder->setChangeOrderStatus($changeOrderStatus);

			if (isset($row['change_order_priority_id'])) {
				$change_order_priority_id = $row['change_order_priority_id'];
				$row['co_fk_cop__id'] = $change_order_priority_id;
				$changeOrderPriority = self::instantiateOrm($database, 'ChangeOrderPriority', $row, null, $change_order_priority_id, 'co_fk_cop__');
				/* @var $changeOrderPriority ChangeOrderPriority */
				$changeOrderPriority->convertPropertiesToData();
			} else {
				$changeOrderPriority = false;
			}
			$changeOrder->setChangeOrderPriority($changeOrderPriority);

			if (isset($row['co_file_manager_file_id'])) {
				$co_file_manager_file_id = $row['co_file_manager_file_id'];
				$row['co_fk_fmfiles__id'] = $co_file_manager_file_id;
				$coFileManagerFile = self::instantiateOrm($database, 'FileManagerFile', $row, null, $co_file_manager_file_id, 'co_fk_fmfiles__');
				/* @var $coFileManagerFile FileManagerFile */
				$coFileManagerFile->convertPropertiesToData();
			} else {
				$coFileManagerFile = false;
			}
			$changeOrder->setCoFileManagerFile($coFileManagerFile);

			if (isset($row['co_cost_code_id'])) {
				$co_cost_code_id = $row['co_cost_code_id'];
				$row['co_fk_codes__id'] = $co_cost_code_id;
				$coCostCode = self::instantiateOrm($database, 'CostCode', $row, null, $co_cost_code_id, 'co_fk_codes__');
				/* @var $coCostCode CostCode */
				$coCostCode->convertPropertiesToData();
			} else {
				$coCostCode = false;
			}
			$changeOrder->setCoCostCode($coCostCode);

			if (isset($row['co_creator_contact_id'])) {
				$co_creator_contact_id = $row['co_creator_contact_id'];
				$row['co_fk_creator_c__id'] = $co_creator_contact_id;
				$coCreatorContact = self::instantiateOrm($database, 'Contact', $row, null, $co_creator_contact_id, 'co_fk_creator_c__');
				/* @var $coCreatorContact Contact */
				$coCreatorContact->convertPropertiesToData();
			} else {
				$coCreatorContact = false;
			}
			$changeOrder->setCoCreatorContact($coCreatorContact);

			if (isset($row['co_creator_contact_company_office_id'])) {
				$co_creator_contact_company_office_id = $row['co_creator_contact_company_office_id'];
				$row['co_fk_creator_cco__id'] = $co_creator_contact_company_office_id;
				$coCreatorContactCompanyOffice = self::instantiateOrm($database, 'ContactCompanyOffice', $row, null, $co_creator_contact_company_office_id, 'co_fk_creator_cco__');
				/* @var $coCreatorContactCompanyOffice ContactCompanyOffice */
				$coCreatorContactCompanyOffice->convertPropertiesToData();
			} else {
				$coCreatorContactCompanyOffice = false;
			}
			$changeOrder->setCoCreatorContactCompanyOffice($coCreatorContactCompanyOffice);

			if (isset($row['co_creator_phone_contact_company_office_phone_number_id'])) {
				$co_creator_phone_contact_company_office_phone_number_id = $row['co_creator_phone_contact_company_office_phone_number_id'];
				$row['co_fk_creator_phone_ccopn__id'] = $co_creator_phone_contact_company_office_phone_number_id;
				$coCreatorPhoneContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $co_creator_phone_contact_company_office_phone_number_id, 'co_fk_creator_phone_ccopn__');
				/* @var $coCreatorPhoneContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$coCreatorPhoneContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$coCreatorPhoneContactCompanyOfficePhoneNumber = false;
			}
			$changeOrder->setCoCreatorPhoneContactCompanyOfficePhoneNumber($coCreatorPhoneContactCompanyOfficePhoneNumber);

			if (isset($row['co_creator_fax_contact_company_office_phone_number_id'])) {
				$co_creator_fax_contact_company_office_phone_number_id = $row['co_creator_fax_contact_company_office_phone_number_id'];
				$row['co_fk_creator_fax_ccopn__id'] = $co_creator_fax_contact_company_office_phone_number_id;
				$coCreatorFaxContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $co_creator_fax_contact_company_office_phone_number_id, 'co_fk_creator_fax_ccopn__');
				/* @var $coCreatorFaxContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$coCreatorFaxContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$coCreatorFaxContactCompanyOfficePhoneNumber = false;
			}
			$changeOrder->setCoCreatorFaxContactCompanyOfficePhoneNumber($coCreatorFaxContactCompanyOfficePhoneNumber);

			if (isset($row['co_creator_contact_mobile_phone_number_id'])) {
				$co_creator_contact_mobile_phone_number_id = $row['co_creator_contact_mobile_phone_number_id'];
				$row['co_fk_creator_c_mobile_cpn__id'] = $co_creator_contact_mobile_phone_number_id;
				$coCreatorContactMobilePhoneNumber = self::instantiateOrm($database, 'ContactPhoneNumber', $row, null, $co_creator_contact_mobile_phone_number_id, 'co_fk_creator_c_mobile_cpn__');
				/* @var $coCreatorContactMobilePhoneNumber ContactPhoneNumber */
				$coCreatorContactMobilePhoneNumber->convertPropertiesToData();
			} else {
				$coCreatorContactMobilePhoneNumber = false;
			}
			$changeOrder->setCoCreatorContactMobilePhoneNumber($coCreatorContactMobilePhoneNumber);

			if (isset($row['co_recipient_contact_id'])) {
				$co_recipient_contact_id = $row['co_recipient_contact_id'];
				$row['co_fk_recipient_c__id'] = $co_recipient_contact_id;
				$coRecipientContact = self::instantiateOrm($database, 'Contact', $row, null, $co_recipient_contact_id, 'co_fk_recipient_c__');
				/* @var $coRecipientContact Contact */
				$coRecipientContact->convertPropertiesToData();
			} else {
				$coRecipientContact = false;
			}
			$changeOrder->setCoRecipientContact($coRecipientContact);

			if (isset($row['co_recipient_contact_company_office_id'])) {
				$co_recipient_contact_company_office_id = $row['co_recipient_contact_company_office_id'];
				$row['co_fk_recipient_cco__id'] = $co_recipient_contact_company_office_id;
				$coRecipientContactCompanyOffice = self::instantiateOrm($database, 'ContactCompanyOffice', $row, null, $co_recipient_contact_company_office_id, 'co_fk_recipient_cco__');
				/* @var $coRecipientContactCompanyOffice ContactCompanyOffice */
				$coRecipientContactCompanyOffice->convertPropertiesToData();
			} else {
				$coRecipientContactCompanyOffice = false;
			}
			$changeOrder->setCoRecipientContactCompanyOffice($coRecipientContactCompanyOffice);

			if (isset($row['co_recipient_phone_contact_company_office_phone_number_id'])) {
				$co_recipient_phone_contact_company_office_phone_number_id = $row['co_recipient_phone_contact_company_office_phone_number_id'];
				$row['co_fk_recipient_phone_ccopn__id'] = $co_recipient_phone_contact_company_office_phone_number_id;
				$coRecipientPhoneContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $co_recipient_phone_contact_company_office_phone_number_id, 'co_fk_recipient_phone_ccopn__');
				/* @var $coRecipientPhoneContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$coRecipientPhoneContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$coRecipientPhoneContactCompanyOfficePhoneNumber = false;
			}
			$changeOrder->setCoRecipientPhoneContactCompanyOfficePhoneNumber($coRecipientPhoneContactCompanyOfficePhoneNumber);

			if (isset($row['co_recipient_fax_contact_company_office_phone_number_id'])) {
				$co_recipient_fax_contact_company_office_phone_number_id = $row['co_recipient_fax_contact_company_office_phone_number_id'];
				$row['co_fk_recipient_fax_ccopn__id'] = $co_recipient_fax_contact_company_office_phone_number_id;
				$coRecipientFaxContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $co_recipient_fax_contact_company_office_phone_number_id, 'co_fk_recipient_fax_ccopn__');
				/* @var $coRecipientFaxContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$coRecipientFaxContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$coRecipientFaxContactCompanyOfficePhoneNumber = false;
			}
			$changeOrder->setCoRecipientFaxContactCompanyOfficePhoneNumber($coRecipientFaxContactCompanyOfficePhoneNumber);

			if (isset($row['co_recipient_contact_mobile_phone_number_id'])) {
				$co_recipient_contact_mobile_phone_number_id = $row['co_recipient_contact_mobile_phone_number_id'];
				$row['co_fk_recipient_c_mobile_cpn__id'] = $co_recipient_contact_mobile_phone_number_id;
				$coRecipientContactMobilePhoneNumber = self::instantiateOrm($database, 'ContactPhoneNumber', $row, null, $co_recipient_contact_mobile_phone_number_id, 'co_fk_recipient_c_mobile_cpn__');
				/* @var $coRecipientContactMobilePhoneNumber ContactPhoneNumber */
				$coRecipientContactMobilePhoneNumber->convertPropertiesToData();
			} else {
				$coRecipientContactMobilePhoneNumber = false;
			}
			$changeOrder->setCoRecipientContactMobilePhoneNumber($coRecipientContactMobilePhoneNumber);

			if (isset($row['co_initiator_contact_id'])) {
				$co_initiator_contact_id = $row['co_initiator_contact_id'];
				$row['co_fk_initiator_c__id'] = $co_initiator_contact_id;
				$coInitiatorContact = self::instantiateOrm($database, 'Contact', $row, null, $co_initiator_contact_id, 'co_fk_initiator_c__');
				/* @var $coInitiatorContact Contact */
				$coInitiatorContact->convertPropertiesToData();
			} else {
				$coInitiatorContact = false;
			}
			$changeOrder->setCoInitiatorContact($coInitiatorContact);

			if (isset($row['co_initiator_contact_company_office_id'])) {
				$co_initiator_contact_company_office_id = $row['co_initiator_contact_company_office_id'];
				$row['co_fk_initiator_cco__id'] = $co_initiator_contact_company_office_id;
				$coInitiatorContactCompanyOffice = self::instantiateOrm($database, 'ContactCompanyOffice', $row, null, $co_initiator_contact_company_office_id, 'co_fk_initiator_cco__');
				/* @var $coInitiatorContactCompanyOffice ContactCompanyOffice */
				$coInitiatorContactCompanyOffice->convertPropertiesToData();
			} else {
				$coInitiatorContactCompanyOffice = false;
			}
			$changeOrder->setCoInitiatorContactCompanyOffice($coInitiatorContactCompanyOffice);

			if (isset($row['co_initiator_phone_contact_company_office_phone_number_id'])) {
				$co_initiator_phone_contact_company_office_phone_number_id = $row['co_initiator_phone_contact_company_office_phone_number_id'];
				$row['co_fk_initiator_phone_ccopn__id'] = $co_initiator_phone_contact_company_office_phone_number_id;
				$coInitiatorPhoneContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $co_initiator_phone_contact_company_office_phone_number_id, 'co_fk_initiator_phone_ccopn__');
				/* @var $coInitiatorPhoneContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$coInitiatorPhoneContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$coInitiatorPhoneContactCompanyOfficePhoneNumber = false;
			}
			$changeOrder->setCoInitiatorPhoneContactCompanyOfficePhoneNumber($coInitiatorPhoneContactCompanyOfficePhoneNumber);

			if (isset($row['co_initiator_fax_contact_company_office_phone_number_id'])) {
				$co_initiator_fax_contact_company_office_phone_number_id = $row['co_initiator_fax_contact_company_office_phone_number_id'];
				$row['co_fk_initiator_fax_ccopn__id'] = $co_initiator_fax_contact_company_office_phone_number_id;
				$coInitiatorFaxContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $co_initiator_fax_contact_company_office_phone_number_id, 'co_fk_initiator_fax_ccopn__');
				/* @var $coInitiatorFaxContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$coInitiatorFaxContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$coInitiatorFaxContactCompanyOfficePhoneNumber = false;
			}
			$changeOrder->setCoInitiatorFaxContactCompanyOfficePhoneNumber($coInitiatorFaxContactCompanyOfficePhoneNumber);

			if (isset($row['co_initiator_contact_mobile_phone_number_id'])) {
				$co_initiator_contact_mobile_phone_number_id = $row['co_initiator_contact_mobile_phone_number_id'];
				$row['co_fk_initiator_c_mobile_cpn__id'] = $co_initiator_contact_mobile_phone_number_id;
				$coInitiatorContactMobilePhoneNumber = self::instantiateOrm($database, 'ContactPhoneNumber', $row, null, $co_initiator_contact_mobile_phone_number_id, 'co_fk_initiator_c_mobile_cpn__');
				/* @var $coInitiatorContactMobilePhoneNumber ContactPhoneNumber */
				$coInitiatorContactMobilePhoneNumber->convertPropertiesToData();
			} else {
				$coInitiatorContactMobilePhoneNumber = false;
			}
			$changeOrder->setCoInitiatorContactMobilePhoneNumber($coInitiatorContactMobilePhoneNumber);

			$arrChangeOrdersByProjectId[$change_order_id] = $changeOrder;
		}

		$db->free_result();

		self::$_arrChangeOrdersByProjectId = $arrChangeOrdersByProjectId;

		return $arrChangeOrdersByProjectId;
	}
	/**
	 * Load by constraint `change_orders_fk_cot` foreign key (`change_order_type_id`) references `change_order_types` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $change_order_type_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadChangeOrdersByChangeOrderTypeId($database, $change_order_type_id, Input $options=null)
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
			self::$_arrChangeOrdersByChangeOrderTypeId = null;
		}

		$arrChangeOrdersByChangeOrderTypeId = self::$_arrChangeOrdersByChangeOrderTypeId;
		if (isset($arrChangeOrdersByChangeOrderTypeId) && !empty($arrChangeOrdersByChangeOrderTypeId)) {
			return $arrChangeOrdersByChangeOrderTypeId;
		}

		$change_order_type_id = (int) $change_order_type_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpChangeOrder = new ChangeOrder($database);
			$sqlOrderByColumns = $tmpChangeOrder->constructSqlOrderByColumns($arrOrderByAttributes);

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
	co.*

FROM `change_orders` co
WHERE co.`change_order_type_id` = ?{$sqlOrderBy}{$sqlLimit}
";

		$arrValues = array($change_order_type_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrChangeOrdersByChangeOrderTypeId = array();
		while ($row = $db->fetch()) {
			$change_order_id = $row['id'];
			$changeOrder = self::instantiateOrm($database, 'ChangeOrder', $row, null, $change_order_id);
			/* @var $changeOrder ChangeOrder */
			$arrChangeOrdersByChangeOrderTypeId[$change_order_id] = $changeOrder;
		}

		$db->free_result();

		self::$_arrChangeOrdersByChangeOrderTypeId = $arrChangeOrdersByChangeOrderTypeId;

		return $arrChangeOrdersByChangeOrderTypeId;
	}

	/**
	 * Load by constraint `change_orders_fk_cos` foreign key (`change_order_status_id`) references `change_order_statuses` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $change_order_status_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadChangeOrdersByChangeOrderStatusId($database, $change_order_status_id, Input $options=null)
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
			self::$_arrChangeOrdersByChangeOrderStatusId = null;
		}

		$arrChangeOrdersByChangeOrderStatusId = self::$_arrChangeOrdersByChangeOrderStatusId;
		if (isset($arrChangeOrdersByChangeOrderStatusId) && !empty($arrChangeOrdersByChangeOrderStatusId)) {
			return $arrChangeOrdersByChangeOrderStatusId;
		}

		$change_order_status_id = (int) $change_order_status_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

	
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpChangeOrder = new ChangeOrder($database);
			$sqlOrderByColumns = $tmpChangeOrder->constructSqlOrderByColumns($arrOrderByAttributes);

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
	co.*

FROM `change_orders` co
WHERE co.`change_order_status_id` = ?{$sqlOrderBy}{$sqlLimit}
";

		$arrValues = array($change_order_status_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrChangeOrdersByChangeOrderStatusId = array();
		while ($row = $db->fetch()) {
			$change_order_id = $row['id'];
			$changeOrder = self::instantiateOrm($database, 'ChangeOrder', $row, null, $change_order_id);
			/* @var $changeOrder ChangeOrder */
			$arrChangeOrdersByChangeOrderStatusId[$change_order_id] = $changeOrder;
		}

		$db->free_result();

		self::$_arrChangeOrdersByChangeOrderStatusId = $arrChangeOrdersByChangeOrderStatusId;

		return $arrChangeOrdersByChangeOrderStatusId;
	}

	/**
	 * Load by constraint `change_orders_fk_cop` foreign key (`change_order_priority_id`) references `change_order_priorities` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $change_order_priority_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadChangeOrdersByChangeOrderPriorityId($database, $change_order_priority_id, Input $options=null)
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
			self::$_arrChangeOrdersByChangeOrderPriorityId = null;
		}

		$arrChangeOrdersByChangeOrderPriorityId = self::$_arrChangeOrdersByChangeOrderPriorityId;
		if (isset($arrChangeOrdersByChangeOrderPriorityId) && !empty($arrChangeOrdersByChangeOrderPriorityId)) {
			return $arrChangeOrdersByChangeOrderPriorityId;
		}

		$change_order_priority_id = (int) $change_order_priority_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpChangeOrder = new ChangeOrder($database);
			$sqlOrderByColumns = $tmpChangeOrder->constructSqlOrderByColumns($arrOrderByAttributes);

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
	co.*

FROM `change_orders` co
WHERE co.`change_order_priority_id` = ?{$sqlOrderBy}{$sqlLimit}
";

		$arrValues = array($change_order_priority_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrChangeOrdersByChangeOrderPriorityId = array();
		while ($row = $db->fetch()) {
			$change_order_id = $row['id'];
			$changeOrder = self::instantiateOrm($database, 'ChangeOrder', $row, null, $change_order_id);
			/* @var $changeOrder ChangeOrder */
			$arrChangeOrdersByChangeOrderPriorityId[$change_order_id] = $changeOrder;
		}

		$db->free_result();

		self::$_arrChangeOrdersByChangeOrderPriorityId = $arrChangeOrdersByChangeOrderPriorityId;

		return $arrChangeOrdersByChangeOrderPriorityId;
	}

	/**
	 * Load by constraint `change_orders_fk_fmfiles` foreign key (`co_file_manager_file_id`) references `file_manager_files` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $co_file_manager_file_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadChangeOrdersByCoFileManagerFileId($database, $co_file_manager_file_id, Input $options=null)
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
			self::$_arrChangeOrdersByCoFileManagerFileId = null;
		}

		$arrChangeOrdersByCoFileManagerFileId = self::$_arrChangeOrdersByCoFileManagerFileId;
		if (isset($arrChangeOrdersByCoFileManagerFileId) && !empty($arrChangeOrdersByCoFileManagerFileId)) {
			return $arrChangeOrdersByCoFileManagerFileId;
		}

		$co_file_manager_file_id = (int) $co_file_manager_file_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpChangeOrder = new ChangeOrder($database);
			$sqlOrderByColumns = $tmpChangeOrder->constructSqlOrderByColumns($arrOrderByAttributes);

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
	co.*

FROM `change_orders` co
WHERE co.`co_file_manager_file_id` = ?{$sqlOrderBy}{$sqlLimit}
";

		$arrValues = array($co_file_manager_file_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrChangeOrdersByCoFileManagerFileId = array();
		while ($row = $db->fetch()) {
			$change_order_id = $row['id'];
			$changeOrder = self::instantiateOrm($database, 'ChangeOrder', $row, null, $change_order_id);
			/* @var $changeOrder ChangeOrder */
			$arrChangeOrdersByCoFileManagerFileId[$change_order_id] = $changeOrder;
		}

		$db->free_result();

		self::$_arrChangeOrdersByCoFileManagerFileId = $arrChangeOrdersByCoFileManagerFileId;

		return $arrChangeOrdersByCoFileManagerFileId;
	}

	/**
	 * Load by constraint `change_orders_fk_codes` foreign key (`co_cost_code_id`) references `cost_codes` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $co_cost_code_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadChangeOrdersByCoCostCodeId($database, $co_cost_code_id, Input $options=null)
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
			self::$_arrChangeOrdersByCoCostCodeId = null;
		}

		$arrChangeOrdersByCoCostCodeId = self::$_arrChangeOrdersByCoCostCodeId;
		if (isset($arrChangeOrdersByCoCostCodeId) && !empty($arrChangeOrdersByCoCostCodeId)) {
			return $arrChangeOrdersByCoCostCodeId;
		}

		$co_cost_code_id = (int) $co_cost_code_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */


		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpChangeOrder = new ChangeOrder($database);
			$sqlOrderByColumns = $tmpChangeOrder->constructSqlOrderByColumns($arrOrderByAttributes);

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
	co.*

FROM `change_orders` co
WHERE co.`co_cost_code_id` = ?{$sqlOrderBy}{$sqlLimit}
";

		$arrValues = array($co_cost_code_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrChangeOrdersByCoCostCodeId = array();
		while ($row = $db->fetch()) {
			$change_order_id = $row['id'];
			$changeOrder = self::instantiateOrm($database, 'ChangeOrder', $row, null, $change_order_id);
			/* @var $changeOrder ChangeOrder */
			$arrChangeOrdersByCoCostCodeId[$change_order_id] = $changeOrder;
		}

		$db->free_result();

		self::$_arrChangeOrdersByCoCostCodeId = $arrChangeOrdersByCoCostCodeId;

		return $arrChangeOrdersByCoCostCodeId;
	}

	/**
	 * Load by constraint `change_orders_fk_creator_c` foreign key (`co_creator_contact_id`) references `contacts` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $co_creator_contact_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadChangeOrdersByCoCreatorContactId($database, $co_creator_contact_id, Input $options=null)
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
			self::$_arrChangeOrdersByCoCreatorContactId = null;
		}

		$arrChangeOrdersByCoCreatorContactId = self::$_arrChangeOrdersByCoCreatorContactId;
		if (isset($arrChangeOrdersByCoCreatorContactId) && !empty($arrChangeOrdersByCoCreatorContactId)) {
			return $arrChangeOrdersByCoCreatorContactId;
		}

		$co_creator_contact_id = (int) $co_creator_contact_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpChangeOrder = new ChangeOrder($database);
			$sqlOrderByColumns = $tmpChangeOrder->constructSqlOrderByColumns($arrOrderByAttributes);

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
	co.*

FROM `change_orders` co
WHERE co.`co_creator_contact_id` = ?{$sqlOrderBy}{$sqlLimit}
";

		$arrValues = array($co_creator_contact_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrChangeOrdersByCoCreatorContactId = array();
		while ($row = $db->fetch()) {
			$change_order_id = $row['id'];
			$changeOrder = self::instantiateOrm($database, 'ChangeOrder', $row, null, $change_order_id);
			/* @var $changeOrder ChangeOrder */
			$arrChangeOrdersByCoCreatorContactId[$change_order_id] = $changeOrder;
		}

		$db->free_result();

		self::$_arrChangeOrdersByCoCreatorContactId = $arrChangeOrdersByCoCreatorContactId;

		return $arrChangeOrdersByCoCreatorContactId;
	}

	/**
	 * Load by constraint `change_orders_fk_creator_cco` foreign key (`co_creator_contact_company_office_id`) references `contact_company_offices` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $co_creator_contact_company_office_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadChangeOrdersByCoCreatorContactCompanyOfficeId($database, $co_creator_contact_company_office_id, Input $options=null)
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
			self::$_arrChangeOrdersByCoCreatorContactCompanyOfficeId = null;
		}

		$arrChangeOrdersByCoCreatorContactCompanyOfficeId = self::$_arrChangeOrdersByCoCreatorContactCompanyOfficeId;
		if (isset($arrChangeOrdersByCoCreatorContactCompanyOfficeId) && !empty($arrChangeOrdersByCoCreatorContactCompanyOfficeId)) {
			return $arrChangeOrdersByCoCreatorContactCompanyOfficeId;
		}

		$co_creator_contact_company_office_id = (int) $co_creator_contact_company_office_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */


		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpChangeOrder = new ChangeOrder($database);
			$sqlOrderByColumns = $tmpChangeOrder->constructSqlOrderByColumns($arrOrderByAttributes);

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
	co.*

FROM `change_orders` co
WHERE co.`co_creator_contact_company_office_id` = ?{$sqlOrderBy}{$sqlLimit}
";

		$arrValues = array($co_creator_contact_company_office_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrChangeOrdersByCoCreatorContactCompanyOfficeId = array();
		while ($row = $db->fetch()) {
			$change_order_id = $row['id'];
			$changeOrder = self::instantiateOrm($database, 'ChangeOrder', $row, null, $change_order_id);
			/* @var $changeOrder ChangeOrder */
			$arrChangeOrdersByCoCreatorContactCompanyOfficeId[$change_order_id] = $changeOrder;
		}

		$db->free_result();

		self::$_arrChangeOrdersByCoCreatorContactCompanyOfficeId = $arrChangeOrdersByCoCreatorContactCompanyOfficeId;

		return $arrChangeOrdersByCoCreatorContactCompanyOfficeId;
	}

	/**
	 * Load by constraint `change_orders_fk_creator_phone_ccopn` foreign key (`co_creator_phone_contact_company_office_phone_number_id`) references `contact_company_office_phone_numbers` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $co_creator_phone_contact_company_office_phone_number_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadChangeOrdersByCoCreatorPhoneContactCompanyOfficePhoneNumberId($database, $co_creator_phone_contact_company_office_phone_number_id, Input $options=null)
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
			self::$_arrChangeOrdersByCoCreatorPhoneContactCompanyOfficePhoneNumberId = null;
		}

		$arrChangeOrdersByCoCreatorPhoneContactCompanyOfficePhoneNumberId = self::$_arrChangeOrdersByCoCreatorPhoneContactCompanyOfficePhoneNumberId;
		if (isset($arrChangeOrdersByCoCreatorPhoneContactCompanyOfficePhoneNumberId) && !empty($arrChangeOrdersByCoCreatorPhoneContactCompanyOfficePhoneNumberId)) {
			return $arrChangeOrdersByCoCreatorPhoneContactCompanyOfficePhoneNumberId;
		}

		$co_creator_phone_contact_company_office_phone_number_id = (int) $co_creator_phone_contact_company_office_phone_number_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpChangeOrder = new ChangeOrder($database);
			$sqlOrderByColumns = $tmpChangeOrder->constructSqlOrderByColumns($arrOrderByAttributes);

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
	co.*

FROM `change_orders` co
WHERE co.`co_creator_phone_contact_company_office_phone_number_id` = ?{$sqlOrderBy}{$sqlLimit}
";

		$arrValues = array($co_creator_phone_contact_company_office_phone_number_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrChangeOrdersByCoCreatorPhoneContactCompanyOfficePhoneNumberId = array();
		while ($row = $db->fetch()) {
			$change_order_id = $row['id'];
			$changeOrder = self::instantiateOrm($database, 'ChangeOrder', $row, null, $change_order_id);
			/* @var $changeOrder ChangeOrder */
			$arrChangeOrdersByCoCreatorPhoneContactCompanyOfficePhoneNumberId[$change_order_id] = $changeOrder;
		}

		$db->free_result();

		self::$_arrChangeOrdersByCoCreatorPhoneContactCompanyOfficePhoneNumberId = $arrChangeOrdersByCoCreatorPhoneContactCompanyOfficePhoneNumberId;

		return $arrChangeOrdersByCoCreatorPhoneContactCompanyOfficePhoneNumberId;
	}

	/**
	 * Load by constraint `change_orders_fk_creator_fax_ccopn` foreign key (`co_creator_fax_contact_company_office_phone_number_id`) references `contact_company_office_phone_numbers` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $co_creator_fax_contact_company_office_phone_number_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadChangeOrdersByCoCreatorFaxContactCompanyOfficePhoneNumberId($database, $co_creator_fax_contact_company_office_phone_number_id, Input $options=null)
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
			self::$_arrChangeOrdersByCoCreatorFaxContactCompanyOfficePhoneNumberId = null;
		}

		$arrChangeOrdersByCoCreatorFaxContactCompanyOfficePhoneNumberId = self::$_arrChangeOrdersByCoCreatorFaxContactCompanyOfficePhoneNumberId;
		if (isset($arrChangeOrdersByCoCreatorFaxContactCompanyOfficePhoneNumberId) && !empty($arrChangeOrdersByCoCreatorFaxContactCompanyOfficePhoneNumberId)) {
			return $arrChangeOrdersByCoCreatorFaxContactCompanyOfficePhoneNumberId;
		}

		$co_creator_fax_contact_company_office_phone_number_id = (int) $co_creator_fax_contact_company_office_phone_number_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */


		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpChangeOrder = new ChangeOrder($database);
			$sqlOrderByColumns = $tmpChangeOrder->constructSqlOrderByColumns($arrOrderByAttributes);

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
	co.*

FROM `change_orders` co
WHERE co.`co_creator_fax_contact_company_office_phone_number_id` = ?{$sqlOrderBy}{$sqlLimit}
";

		$arrValues = array($co_creator_fax_contact_company_office_phone_number_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrChangeOrdersByCoCreatorFaxContactCompanyOfficePhoneNumberId = array();
		while ($row = $db->fetch()) {
			$change_order_id = $row['id'];
			$changeOrder = self::instantiateOrm($database, 'ChangeOrder', $row, null, $change_order_id);
			/* @var $changeOrder ChangeOrder */
			$arrChangeOrdersByCoCreatorFaxContactCompanyOfficePhoneNumberId[$change_order_id] = $changeOrder;
		}

		$db->free_result();

		self::$_arrChangeOrdersByCoCreatorFaxContactCompanyOfficePhoneNumberId = $arrChangeOrdersByCoCreatorFaxContactCompanyOfficePhoneNumberId;

		return $arrChangeOrdersByCoCreatorFaxContactCompanyOfficePhoneNumberId;
	}

	/**
	 * Load by constraint `change_orders_fk_creator_c_mobile_cpn` foreign key (`co_creator_contact_mobile_phone_number_id`) references `contact_phone_numbers` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $co_creator_contact_mobile_phone_number_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadChangeOrdersByCoCreatorContactMobilePhoneNumberId($database, $co_creator_contact_mobile_phone_number_id, Input $options=null)
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
			self::$_arrChangeOrdersByCoCreatorContactMobilePhoneNumberId = null;
		}

		$arrChangeOrdersByCoCreatorContactMobilePhoneNumberId = self::$_arrChangeOrdersByCoCreatorContactMobilePhoneNumberId;
		if (isset($arrChangeOrdersByCoCreatorContactMobilePhoneNumberId) && !empty($arrChangeOrdersByCoCreatorContactMobilePhoneNumberId)) {
			return $arrChangeOrdersByCoCreatorContactMobilePhoneNumberId;
		}

		$co_creator_contact_mobile_phone_number_id = (int) $co_creator_contact_mobile_phone_number_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpChangeOrder = new ChangeOrder($database);
			$sqlOrderByColumns = $tmpChangeOrder->constructSqlOrderByColumns($arrOrderByAttributes);

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
	co.*

FROM `change_orders` co
WHERE co.`co_creator_contact_mobile_phone_number_id` = ?{$sqlOrderBy}{$sqlLimit}
";

		$arrValues = array($co_creator_contact_mobile_phone_number_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrChangeOrdersByCoCreatorContactMobilePhoneNumberId = array();
		while ($row = $db->fetch()) {
			$change_order_id = $row['id'];
			$changeOrder = self::instantiateOrm($database, 'ChangeOrder', $row, null, $change_order_id);
			/* @var $changeOrder ChangeOrder */
			$arrChangeOrdersByCoCreatorContactMobilePhoneNumberId[$change_order_id] = $changeOrder;
		}

		$db->free_result();

		self::$_arrChangeOrdersByCoCreatorContactMobilePhoneNumberId = $arrChangeOrdersByCoCreatorContactMobilePhoneNumberId;

		return $arrChangeOrdersByCoCreatorContactMobilePhoneNumberId;
	}

	/**
	 * Load by constraint `change_orders_fk_recipient_c` foreign key (`co_recipient_contact_id`) references `contacts` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $co_recipient_contact_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadChangeOrdersByCoRecipientContactId($database, $co_recipient_contact_id, Input $options=null)
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
			self::$_arrChangeOrdersByCoRecipientContactId = null;
		}

		$arrChangeOrdersByCoRecipientContactId = self::$_arrChangeOrdersByCoRecipientContactId;
		if (isset($arrChangeOrdersByCoRecipientContactId) && !empty($arrChangeOrdersByCoRecipientContactId)) {
			return $arrChangeOrdersByCoRecipientContactId;
		}

		$co_recipient_contact_id = (int) $co_recipient_contact_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpChangeOrder = new ChangeOrder($database);
			$sqlOrderByColumns = $tmpChangeOrder->constructSqlOrderByColumns($arrOrderByAttributes);

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
	co.*

FROM `change_orders` co
WHERE co.`co_recipient_contact_id` = ?{$sqlOrderBy}{$sqlLimit}
";

		$arrValues = array($co_recipient_contact_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrChangeOrdersByCoRecipientContactId = array();
		while ($row = $db->fetch()) {
			$change_order_id = $row['id'];
			$changeOrder = self::instantiateOrm($database, 'ChangeOrder', $row, null, $change_order_id);
			/* @var $changeOrder ChangeOrder */
			$arrChangeOrdersByCoRecipientContactId[$change_order_id] = $changeOrder;
		}

		$db->free_result();

		self::$_arrChangeOrdersByCoRecipientContactId = $arrChangeOrdersByCoRecipientContactId;

		return $arrChangeOrdersByCoRecipientContactId;
	}

	/**
	 * Load by constraint `change_orders_fk_recipient_cco` foreign key (`co_recipient_contact_company_office_id`) references `contact_company_offices` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $co_recipient_contact_company_office_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadChangeOrdersByCoRecipientContactCompanyOfficeId($database, $co_recipient_contact_company_office_id, Input $options=null)
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
			self::$_arrChangeOrdersByCoRecipientContactCompanyOfficeId = null;
		}

		$arrChangeOrdersByCoRecipientContactCompanyOfficeId = self::$_arrChangeOrdersByCoRecipientContactCompanyOfficeId;
		if (isset($arrChangeOrdersByCoRecipientContactCompanyOfficeId) && !empty($arrChangeOrdersByCoRecipientContactCompanyOfficeId)) {
			return $arrChangeOrdersByCoRecipientContactCompanyOfficeId;
		}

		$co_recipient_contact_company_office_id = (int) $co_recipient_contact_company_office_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

	
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpChangeOrder = new ChangeOrder($database);
			$sqlOrderByColumns = $tmpChangeOrder->constructSqlOrderByColumns($arrOrderByAttributes);

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
	co.*

FROM `change_orders` co
WHERE co.`co_recipient_contact_company_office_id` = ?{$sqlOrderBy}{$sqlLimit}
";

		$arrValues = array($co_recipient_contact_company_office_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrChangeOrdersByCoRecipientContactCompanyOfficeId = array();
		while ($row = $db->fetch()) {
			$change_order_id = $row['id'];
			$changeOrder = self::instantiateOrm($database, 'ChangeOrder', $row, null, $change_order_id);
			/* @var $changeOrder ChangeOrder */
			$arrChangeOrdersByCoRecipientContactCompanyOfficeId[$change_order_id] = $changeOrder;
		}

		$db->free_result();

		self::$_arrChangeOrdersByCoRecipientContactCompanyOfficeId = $arrChangeOrdersByCoRecipientContactCompanyOfficeId;

		return $arrChangeOrdersByCoRecipientContactCompanyOfficeId;
	}

	/**
	 * Load by constraint `change_orders_fk_recipient_phone_ccopn` foreign key (`co_recipient_phone_contact_company_office_phone_number_id`) references `contact_company_office_phone_numbers` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $co_recipient_phone_contact_company_office_phone_number_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadChangeOrdersByCoRecipientPhoneContactCompanyOfficePhoneNumberId($database, $co_recipient_phone_contact_company_office_phone_number_id, Input $options=null)
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
			self::$_arrChangeOrdersByCoRecipientPhoneContactCompanyOfficePhoneNumberId = null;
		}

		$arrChangeOrdersByCoRecipientPhoneContactCompanyOfficePhoneNumberId = self::$_arrChangeOrdersByCoRecipientPhoneContactCompanyOfficePhoneNumberId;
		if (isset($arrChangeOrdersByCoRecipientPhoneContactCompanyOfficePhoneNumberId) && !empty($arrChangeOrdersByCoRecipientPhoneContactCompanyOfficePhoneNumberId)) {
			return $arrChangeOrdersByCoRecipientPhoneContactCompanyOfficePhoneNumberId;
		}

		$co_recipient_phone_contact_company_office_phone_number_id = (int) $co_recipient_phone_contact_company_office_phone_number_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpChangeOrder = new ChangeOrder($database);
			$sqlOrderByColumns = $tmpChangeOrder->constructSqlOrderByColumns($arrOrderByAttributes);

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
	co.*

FROM `change_orders` co
WHERE co.`co_recipient_phone_contact_company_office_phone_number_id` = ?{$sqlOrderBy}{$sqlLimit}
";

		$arrValues = array($co_recipient_phone_contact_company_office_phone_number_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrChangeOrdersByCoRecipientPhoneContactCompanyOfficePhoneNumberId = array();
		while ($row = $db->fetch()) {
			$change_order_id = $row['id'];
			$changeOrder = self::instantiateOrm($database, 'ChangeOrder', $row, null, $change_order_id);
			/* @var $changeOrder ChangeOrder */
			$arrChangeOrdersByCoRecipientPhoneContactCompanyOfficePhoneNumberId[$change_order_id] = $changeOrder;
		}

		$db->free_result();

		self::$_arrChangeOrdersByCoRecipientPhoneContactCompanyOfficePhoneNumberId = $arrChangeOrdersByCoRecipientPhoneContactCompanyOfficePhoneNumberId;

		return $arrChangeOrdersByCoRecipientPhoneContactCompanyOfficePhoneNumberId;
	}

	/**
	 * Load by constraint `change_orders_fk_recipient_fax_ccopn` foreign key (`co_recipient_fax_contact_company_office_phone_number_id`) references `contact_company_office_phone_numbers` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $co_recipient_fax_contact_company_office_phone_number_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadChangeOrdersByCoRecipientFaxContactCompanyOfficePhoneNumberId($database, $co_recipient_fax_contact_company_office_phone_number_id, Input $options=null)
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
			self::$_arrChangeOrdersByCoRecipientFaxContactCompanyOfficePhoneNumberId = null;
		}

		$arrChangeOrdersByCoRecipientFaxContactCompanyOfficePhoneNumberId = self::$_arrChangeOrdersByCoRecipientFaxContactCompanyOfficePhoneNumberId;
		if (isset($arrChangeOrdersByCoRecipientFaxContactCompanyOfficePhoneNumberId) && !empty($arrChangeOrdersByCoRecipientFaxContactCompanyOfficePhoneNumberId)) {
			return $arrChangeOrdersByCoRecipientFaxContactCompanyOfficePhoneNumberId;
		}

		$co_recipient_fax_contact_company_office_phone_number_id = (int) $co_recipient_fax_contact_company_office_phone_number_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

	
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpChangeOrder = new ChangeOrder($database);
			$sqlOrderByColumns = $tmpChangeOrder->constructSqlOrderByColumns($arrOrderByAttributes);

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
	co.*

FROM `change_orders` co
WHERE co.`co_recipient_fax_contact_company_office_phone_number_id` = ?{$sqlOrderBy}{$sqlLimit}
";

		$arrValues = array($co_recipient_fax_contact_company_office_phone_number_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrChangeOrdersByCoRecipientFaxContactCompanyOfficePhoneNumberId = array();
		while ($row = $db->fetch()) {
			$change_order_id = $row['id'];
			$changeOrder = self::instantiateOrm($database, 'ChangeOrder', $row, null, $change_order_id);
			/* @var $changeOrder ChangeOrder */
			$arrChangeOrdersByCoRecipientFaxContactCompanyOfficePhoneNumberId[$change_order_id] = $changeOrder;
		}

		$db->free_result();

		self::$_arrChangeOrdersByCoRecipientFaxContactCompanyOfficePhoneNumberId = $arrChangeOrdersByCoRecipientFaxContactCompanyOfficePhoneNumberId;

		return $arrChangeOrdersByCoRecipientFaxContactCompanyOfficePhoneNumberId;
	}

	/**
	 * Load by constraint `change_orders_fk_recipient_c_mobile_cpn` foreign key (`co_recipient_contact_mobile_phone_number_id`) references `contact_phone_numbers` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $co_recipient_contact_mobile_phone_number_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadChangeOrdersByCoRecipientContactMobilePhoneNumberId($database, $co_recipient_contact_mobile_phone_number_id, Input $options=null)
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
			self::$_arrChangeOrdersByCoRecipientContactMobilePhoneNumberId = null;
		}

		$arrChangeOrdersByCoRecipientContactMobilePhoneNumberId = self::$_arrChangeOrdersByCoRecipientContactMobilePhoneNumberId;
		if (isset($arrChangeOrdersByCoRecipientContactMobilePhoneNumberId) && !empty($arrChangeOrdersByCoRecipientContactMobilePhoneNumberId)) {
			return $arrChangeOrdersByCoRecipientContactMobilePhoneNumberId;
		}

		$co_recipient_contact_mobile_phone_number_id = (int) $co_recipient_contact_mobile_phone_number_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpChangeOrder = new ChangeOrder($database);
			$sqlOrderByColumns = $tmpChangeOrder->constructSqlOrderByColumns($arrOrderByAttributes);

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
	co.*

FROM `change_orders` co
WHERE co.`co_recipient_contact_mobile_phone_number_id` = ?{$sqlOrderBy}{$sqlLimit}
";

		$arrValues = array($co_recipient_contact_mobile_phone_number_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrChangeOrdersByCoRecipientContactMobilePhoneNumberId = array();
		while ($row = $db->fetch()) {
			$change_order_id = $row['id'];
			$changeOrder = self::instantiateOrm($database, 'ChangeOrder', $row, null, $change_order_id);
			/* @var $changeOrder ChangeOrder */
			$arrChangeOrdersByCoRecipientContactMobilePhoneNumberId[$change_order_id] = $changeOrder;
		}

		$db->free_result();

		self::$_arrChangeOrdersByCoRecipientContactMobilePhoneNumberId = $arrChangeOrdersByCoRecipientContactMobilePhoneNumberId;

		return $arrChangeOrdersByCoRecipientContactMobilePhoneNumberId;
	}

	/**
	 * Load by constraint `change_orders_fk_initiator_c` foreign key (`co_initiator_contact_id`) references `contacts` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $co_initiator_contact_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadChangeOrdersByCoInitiatorContactId($database, $co_initiator_contact_id, Input $options=null)
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
			self::$_arrChangeOrdersByCoInitiatorContactId = null;
		}

		$arrChangeOrdersByCoInitiatorContactId = self::$_arrChangeOrdersByCoInitiatorContactId;
		if (isset($arrChangeOrdersByCoInitiatorContactId) && !empty($arrChangeOrdersByCoInitiatorContactId)) {
			return $arrChangeOrdersByCoInitiatorContactId;
		}

		$co_initiator_contact_id = (int) $co_initiator_contact_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpChangeOrder = new ChangeOrder($database);
			$sqlOrderByColumns = $tmpChangeOrder->constructSqlOrderByColumns($arrOrderByAttributes);

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
	co.*

FROM `change_orders` co
WHERE co.`co_initiator_contact_id` = ?{$sqlOrderBy}{$sqlLimit}
";

		$arrValues = array($co_initiator_contact_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrChangeOrdersByCoInitiatorContactId = array();
		while ($row = $db->fetch()) {
			$change_order_id = $row['id'];
			$changeOrder = self::instantiateOrm($database, 'ChangeOrder', $row, null, $change_order_id);
			/* @var $changeOrder ChangeOrder */
			$arrChangeOrdersByCoInitiatorContactId[$change_order_id] = $changeOrder;
		}

		$db->free_result();

		self::$_arrChangeOrdersByCoInitiatorContactId = $arrChangeOrdersByCoInitiatorContactId;

		return $arrChangeOrdersByCoInitiatorContactId;
	}

	/**
	 * Load by constraint `change_orders_fk_initiator_cco` foreign key (`co_initiator_contact_company_office_id`) references `contact_company_offices` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $co_initiator_contact_company_office_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadChangeOrdersByCoInitiatorContactCompanyOfficeId($database, $co_initiator_contact_company_office_id, Input $options=null)
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
			self::$_arrChangeOrdersByCoInitiatorContactCompanyOfficeId = null;
		}

		$arrChangeOrdersByCoInitiatorContactCompanyOfficeId = self::$_arrChangeOrdersByCoInitiatorContactCompanyOfficeId;
		if (isset($arrChangeOrdersByCoInitiatorContactCompanyOfficeId) && !empty($arrChangeOrdersByCoInitiatorContactCompanyOfficeId)) {
			return $arrChangeOrdersByCoInitiatorContactCompanyOfficeId;
		}

		$co_initiator_contact_company_office_id = (int) $co_initiator_contact_company_office_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpChangeOrder = new ChangeOrder($database);
			$sqlOrderByColumns = $tmpChangeOrder->constructSqlOrderByColumns($arrOrderByAttributes);

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
	co.*

FROM `change_orders` co
WHERE co.`co_initiator_contact_company_office_id` = ?{$sqlOrderBy}{$sqlLimit}
";

		$arrValues = array($co_initiator_contact_company_office_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrChangeOrdersByCoInitiatorContactCompanyOfficeId = array();
		while ($row = $db->fetch()) {
			$change_order_id = $row['id'];
			$changeOrder = self::instantiateOrm($database, 'ChangeOrder', $row, null, $change_order_id);
			/* @var $changeOrder ChangeOrder */
			$arrChangeOrdersByCoInitiatorContactCompanyOfficeId[$change_order_id] = $changeOrder;
		}

		$db->free_result();

		self::$_arrChangeOrdersByCoInitiatorContactCompanyOfficeId = $arrChangeOrdersByCoInitiatorContactCompanyOfficeId;

		return $arrChangeOrdersByCoInitiatorContactCompanyOfficeId;
	}

	/**
	 * Load by constraint `change_orders_fk_initiator_phone_ccopn` foreign key (`co_initiator_phone_contact_company_office_phone_number_id`) references `contact_company_office_phone_numbers` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $co_initiator_phone_contact_company_office_phone_number_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadChangeOrdersByCoInitiatorPhoneContactCompanyOfficePhoneNumberId($database, $co_initiator_phone_contact_company_office_phone_number_id, Input $options=null)
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
			self::$_arrChangeOrdersByCoInitiatorPhoneContactCompanyOfficePhoneNumberId = null;
		}

		$arrChangeOrdersByCoInitiatorPhoneContactCompanyOfficePhoneNumberId = self::$_arrChangeOrdersByCoInitiatorPhoneContactCompanyOfficePhoneNumberId;
		if (isset($arrChangeOrdersByCoInitiatorPhoneContactCompanyOfficePhoneNumberId) && !empty($arrChangeOrdersByCoInitiatorPhoneContactCompanyOfficePhoneNumberId)) {
			return $arrChangeOrdersByCoInitiatorPhoneContactCompanyOfficePhoneNumberId;
		}

		$co_initiator_phone_contact_company_office_phone_number_id = (int) $co_initiator_phone_contact_company_office_phone_number_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpChangeOrder = new ChangeOrder($database);
			$sqlOrderByColumns = $tmpChangeOrder->constructSqlOrderByColumns($arrOrderByAttributes);

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
	co.*

FROM `change_orders` co
WHERE co.`co_initiator_phone_contact_company_office_phone_number_id` = ?{$sqlOrderBy}{$sqlLimit}
";

		$arrValues = array($co_initiator_phone_contact_company_office_phone_number_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrChangeOrdersByCoInitiatorPhoneContactCompanyOfficePhoneNumberId = array();
		while ($row = $db->fetch()) {
			$change_order_id = $row['id'];
			$changeOrder = self::instantiateOrm($database, 'ChangeOrder', $row, null, $change_order_id);
			/* @var $changeOrder ChangeOrder */
			$arrChangeOrdersByCoInitiatorPhoneContactCompanyOfficePhoneNumberId[$change_order_id] = $changeOrder;
		}

		$db->free_result();

		self::$_arrChangeOrdersByCoInitiatorPhoneContactCompanyOfficePhoneNumberId = $arrChangeOrdersByCoInitiatorPhoneContactCompanyOfficePhoneNumberId;

		return $arrChangeOrdersByCoInitiatorPhoneContactCompanyOfficePhoneNumberId;
	}

	/**
	 * Load by constraint `change_orders_fk_initiator_fax_ccopn` foreign key (`co_initiator_fax_contact_company_office_phone_number_id`) references `contact_company_office_phone_numbers` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $co_initiator_fax_contact_company_office_phone_number_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadChangeOrdersByCoInitiatorFaxContactCompanyOfficePhoneNumberId($database, $co_initiator_fax_contact_company_office_phone_number_id, Input $options=null)
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
			self::$_arrChangeOrdersByCoInitiatorFaxContactCompanyOfficePhoneNumberId = null;
		}

		$arrChangeOrdersByCoInitiatorFaxContactCompanyOfficePhoneNumberId = self::$_arrChangeOrdersByCoInitiatorFaxContactCompanyOfficePhoneNumberId;
		if (isset($arrChangeOrdersByCoInitiatorFaxContactCompanyOfficePhoneNumberId) && !empty($arrChangeOrdersByCoInitiatorFaxContactCompanyOfficePhoneNumberId)) {
			return $arrChangeOrdersByCoInitiatorFaxContactCompanyOfficePhoneNumberId;
		}

		$co_initiator_fax_contact_company_office_phone_number_id = (int) $co_initiator_fax_contact_company_office_phone_number_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpChangeOrder = new ChangeOrder($database);
			$sqlOrderByColumns = $tmpChangeOrder->constructSqlOrderByColumns($arrOrderByAttributes);

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
	co.*

FROM `change_orders` co
WHERE co.`co_initiator_fax_contact_company_office_phone_number_id` = ?{$sqlOrderBy}{$sqlLimit}
";

		$arrValues = array($co_initiator_fax_contact_company_office_phone_number_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrChangeOrdersByCoInitiatorFaxContactCompanyOfficePhoneNumberId = array();
		while ($row = $db->fetch()) {
			$change_order_id = $row['id'];
			$changeOrder = self::instantiateOrm($database, 'ChangeOrder', $row, null, $change_order_id);
			/* @var $changeOrder ChangeOrder */
			$arrChangeOrdersByCoInitiatorFaxContactCompanyOfficePhoneNumberId[$change_order_id] = $changeOrder;
		}

		$db->free_result();

		self::$_arrChangeOrdersByCoInitiatorFaxContactCompanyOfficePhoneNumberId = $arrChangeOrdersByCoInitiatorFaxContactCompanyOfficePhoneNumberId;

		return $arrChangeOrdersByCoInitiatorFaxContactCompanyOfficePhoneNumberId;
	}

	/**
	 * Load by constraint `change_orders_fk_initiator_c_mobile_cpn` foreign key (`co_initiator_contact_mobile_phone_number_id`) references `contact_phone_numbers` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $co_initiator_contact_mobile_phone_number_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadChangeOrdersByCoInitiatorContactMobilePhoneNumberId($database, $co_initiator_contact_mobile_phone_number_id, Input $options=null)
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
			self::$_arrChangeOrdersByCoInitiatorContactMobilePhoneNumberId = null;
		}

		$arrChangeOrdersByCoInitiatorContactMobilePhoneNumberId = self::$_arrChangeOrdersByCoInitiatorContactMobilePhoneNumberId;
		if (isset($arrChangeOrdersByCoInitiatorContactMobilePhoneNumberId) && !empty($arrChangeOrdersByCoInitiatorContactMobilePhoneNumberId)) {
			return $arrChangeOrdersByCoInitiatorContactMobilePhoneNumberId;
		}

		$co_initiator_contact_mobile_phone_number_id = (int) $co_initiator_contact_mobile_phone_number_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpChangeOrder = new ChangeOrder($database);
			$sqlOrderByColumns = $tmpChangeOrder->constructSqlOrderByColumns($arrOrderByAttributes);

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
	co.*

FROM `change_orders` co
WHERE co.`co_initiator_contact_mobile_phone_number_id` = ?{$sqlOrderBy}{$sqlLimit}
";

		$arrValues = array($co_initiator_contact_mobile_phone_number_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrChangeOrdersByCoInitiatorContactMobilePhoneNumberId = array();
		while ($row = $db->fetch()) {
			$change_order_id = $row['id'];
			$changeOrder = self::instantiateOrm($database, 'ChangeOrder', $row, null, $change_order_id);
			/* @var $changeOrder ChangeOrder */
			$arrChangeOrdersByCoInitiatorContactMobilePhoneNumberId[$change_order_id] = $changeOrder;
		}

		$db->free_result();

		self::$_arrChangeOrdersByCoInitiatorContactMobilePhoneNumberId = $arrChangeOrdersByCoInitiatorContactMobilePhoneNumberId;

		return $arrChangeOrdersByCoInitiatorContactMobilePhoneNumberId;
	}

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all change_orders records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllChangeOrders($database, Input $options=null)
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
			self::$_arrAllChangeOrders = null;
		}

		$arrAllChangeOrders = self::$_arrAllChangeOrders;
		if (isset($arrAllChangeOrders) && !empty($arrAllChangeOrders)) {
			return $arrAllChangeOrders;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

	
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpChangeOrder = new ChangeOrder($database);
			$sqlOrderByColumns = $tmpChangeOrder->constructSqlOrderByColumns($arrOrderByAttributes);

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
	co.*

FROM `change_orders` co{$sqlOrderBy}{$sqlLimit}
";

		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllChangeOrders = array();
		while ($row = $db->fetch()) {
			$change_order_id = $row['id'];
			$changeOrder = self::instantiateOrm($database, 'ChangeOrder', $row, null, $change_order_id);
			/* @var $changeOrder ChangeOrder */
			$arrAllChangeOrders[$change_order_id] = $changeOrder;
		}

		$db->free_result();

		self::$_arrAllChangeOrders = $arrAllChangeOrders;

		return $arrAllChangeOrders;
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
INTO `change_orders`
(`project_id`,`contracting_entity_id`, `co_sequence_number`,`co_type_prefix`, `co_custom_sequence_number`, `co_scheduled_value`, `co_delay_days`, `change_order_type_id`, `change_order_status_id`, `change_order_priority_id`, `co_file_manager_file_id`, `co_cost_code_id`, `co_creator_contact_id`, `co_creator_contact_company_office_id`, `co_creator_phone_contact_company_office_phone_number_id`, `co_creator_fax_contact_company_office_phone_number_id`, `co_creator_contact_mobile_phone_number_id`, `co_recipient_contact_id`, `co_recipient_contact_company_office_id`, `co_recipient_phone_contact_company_office_phone_number_id`, `co_recipient_fax_contact_company_office_phone_number_id`, `co_recipient_contact_mobile_phone_number_id`, `co_initiator_contact_id`, `co_initiator_contact_company_office_id`, `co_initiator_phone_contact_company_office_phone_number_id`, `co_initiator_fax_contact_company_office_phone_number_id`, `co_initiator_contact_mobile_phone_number_id`,`co_signator_contact_id`, `co_title`, `co_plan_page_reference`, `co_statement`, `created`, `co_revised_project_completion_date`, `co_closed_date`,`co_submitted_date`,`co_approved_date`,`COR_created`,`co_subtotal`,`co_genper`,`co_gentotal`,`co_buildper`,`co_buildtotal`,`co_insuranceper`,`co_insurancetotal`,`co_total`)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
ON DUPLICATE KEY UPDATE `co_custom_sequence_number` = ?,`co_type_prefix` = ?, `co_scheduled_value` = ?, `co_delay_days` = ?, `change_order_type_id` = ?, `change_order_status_id` = ?, `change_order_priority_id` = ?, `co_file_manager_file_id` = ?, `co_cost_code_id` = ?, `co_creator_contact_id` = ?, `co_creator_contact_company_office_id` = ?, `co_creator_phone_contact_company_office_phone_number_id` = ?, `co_creator_fax_contact_company_office_phone_number_id` = ?, `co_creator_contact_mobile_phone_number_id` = ?, `co_recipient_contact_id` = ?, `co_recipient_contact_company_office_id` = ?, `co_recipient_phone_contact_company_office_phone_number_id` = ?, `co_recipient_fax_contact_company_office_phone_number_id` = ?, `co_recipient_contact_mobile_phone_number_id` = ?, `co_initiator_contact_id` = ?, `co_initiator_contact_company_office_id` = ?, `co_initiator_phone_contact_company_office_phone_number_id` = ?, `co_initiator_fax_contact_company_office_phone_number_id` = ?, `co_initiator_contact_mobile_phone_number_id` = ?,`co_signator_contact_id` = ?,  `co_title` = ?, `co_plan_page_reference` = ?, `co_statement` = ?, `created` = ?, `co_revised_project_completion_date` = ?, `co_closed_date` = ?, `co_submitted_date` = ?, `co_approved_date` = ?,`COR_created` = ?, `co_subtotal` = ?,`co_genper` =?,`co_gentotal` =?, `co_buildper` =? ,`co_buildtotal` =? ,`co_insuranceper` =? ,`co_insurancetotal` =? ,`co_total` =?
";
		$arrValues = array($this->project_id,$this->contracting_entity_id, $this->co_sequence_number,$this->co_type_prefix, $this->co_custom_sequence_number, $this->co_scheduled_value, $this->co_delay_days, $this->change_order_type_id, $this->change_order_status_id, $this->change_order_priority_id, $this->co_file_manager_file_id, $this->co_cost_code_id, $this->co_creator_contact_id, $this->co_creator_contact_company_office_id, $this->co_creator_phone_contact_company_office_phone_number_id, $this->co_creator_fax_contact_company_office_phone_number_id, $this->co_creator_contact_mobile_phone_number_id, $this->co_recipient_contact_id, $this->co_recipient_contact_company_office_id, $this->co_recipient_phone_contact_company_office_phone_number_id, $this->co_recipient_fax_contact_company_office_phone_number_id, $this->co_recipient_contact_mobile_phone_number_id, $this->co_initiator_contact_id, $this->co_initiator_contact_company_office_id, $this->co_initiator_phone_contact_company_office_phone_number_id, $this->co_initiator_fax_contact_company_office_phone_number_id, $this->co_initiator_contact_mobile_phone_number_id,$this->co_signator_contact_id, $this->co_title, $this->co_plan_page_reference, $this->co_statement, $this->created, $this->co_revised_project_completion_date, $this->co_closed_date, $this->co_submitted_date, $this->co_approved_date,$this->COR_created, $this->co_custom_sequence_number, $this->co_scheduled_value, $this->co_delay_days, $this->change_order_type_id, $this->change_order_status_id, $this->change_order_priority_id, $this->co_file_manager_file_id, $this->co_cost_code_id, $this->co_creator_contact_id, $this->co_creator_contact_company_office_id, $this->co_creator_phone_contact_company_office_phone_number_id, $this->co_creator_fax_contact_company_office_phone_number_id, $this->co_creator_contact_mobile_phone_number_id, $this->co_recipient_contact_id, $this->co_recipient_contact_company_office_id, $this->co_recipient_phone_contact_company_office_phone_number_id, $this->co_recipient_fax_contact_company_office_phone_number_id, $this->co_recipient_contact_mobile_phone_number_id, $this->co_initiator_contact_id, $this->co_initiator_contact_company_office_id, $this->co_initiator_phone_contact_company_office_phone_number_id, $this->co_initiator_fax_contact_company_office_phone_number_id, $this->co_initiator_contact_mobile_phone_number_id,$this->co_signator_contact_id, $this->co_title, $this->co_plan_page_reference, $this->co_statement, $this->created, $this->co_revised_project_completion_date, $this->co_closed_date, $this->co_submitted_date, $this->co_approved_date,$this->COR_created, $this->co_subtotal, $this->co_genper, $this->co_gentotal, $this->co_buildper, $this->co_buildtotal, $this->co_insuranceper, $this->co_insurancetotal, $this->co_total);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$change_order_id = $db->insertId;
		$db->free_result();

		return $change_order_id;
	}

	// Save: insert ignore

	/**
	 * Count by constraint `change_orders_fk_p` foreign key (`project_id`) references `projects` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $project_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadChangeOrdersCountByProjectId($database, $project_id, Input $options=null)
	{
		$change_order_type_id = false;
		$change_order_status_id= false;
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

			if (isset($options->change_order_type_id) && !empty($options->change_order_type_id)) {
				$change_order_type_id = $options->change_order_type_id;
			}
			
			if (isset($options->change_order_status_id) && !empty($options->change_order_status_id)) {
				$change_order_status_id = $options->change_order_status_id;
			}
		}

		$project_id = (int) $project_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$sqlFilter = '';
		if ($change_order_type_id) {
			$escaped_change_order_type_id = $db->escape($change_order_type_id);
			$sqlFilter = "\nAND co.`change_order_type_id` = $escaped_change_order_type_id";
		}
		if($change_order_status_id){
			$escaped_change_order_status = $db->escape($change_order_status_id);
			$sqlFilter .= "\nAND co.`change_order_status_id` = $escaped_change_order_status";
		}

		$query =
"
SELECT count(*)
FROM `change_orders` co
WHERE co.`project_id` = ?{$sqlFilter}
";

		$arrValues = array($project_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		$total = (int) $row['count(*)'];

		return $total;
	}

	/**
	 * Find next_co_sequence_number value.
	 *
	 * @param string $database
	 * @param int $project_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findNextChangeOrderSequenceNumber($database, $project_id)
	{
		$next_co_sequence_number = 1;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT MAX(co.co_sequence_number) AS 'max_co_sequence_number'
FROM `change_orders` co
WHERE co.`project_id` = ?
";
		$arrValues = array($project_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$max_co_sequence_number = $row['max_co_sequence_number'];
			$next_co_sequence_number = $max_co_sequence_number + 1;
		}

		return $next_co_sequence_number;
	}
	/**
		 * Load by constraint `change_orders_fk_p` foreign key (`project_id`) references `projects` (`id`) on delete cascade on update cascade.for Report Job status
		 *
		 * @param string $database
		 * @param int $project_id
		 * @param mixed (Input $options object | null)
		 * @return mixed (array ORM List | empty array)
		 */
		public static function loadPotentialChangeOrdersByProjectId($database, $project_id, $new_begindate, $enddate,Input $options=null, $checkRtype)
		{
			$change_order_type_id = false;
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

				if (isset($options->change_order_type_id) && !empty($options->change_order_type_id)) {
					$change_order_type_id = $options->change_order_type_id;
				}
			}
			if($change_order_type_id != ''){
				$whereIn = "and co.change_order_type_id IN(".$change_order_type_id.")";
			}else{
				if($checkRtype != 'CO')
					$whereIn = "and co.change_order_type_id IN(1)";
				else
					$whereIn = "";
			}

			if(!empty($options->coshowreject) && $options->coshowreject =='true'){
				$whereStatus = "";
			}else{
				$whereStatus = "AND co_fk_cos.`change_order_status` !='Rejected '";
			}

			if(isset($options) && isset($options->change_order_status_id) != ''){
				$change_order_status_id = implode(',',$options->change_order_status_id);
				$whereStatusIn = "and co.change_order_status_id IN(".$change_order_status_id.")";
			}else{
				$whereStatusIn = "";
			}

			if ($forceLoadFlag) {
				self::$_arrChangeOrdersByProjectId = null;
			}

			$arrChangeOrdersByProjectId = self::$_arrChangeOrdersByProjectId;
			if (isset($arrChangeOrdersByProjectId) && !empty($arrChangeOrdersByProjectId)) {
				return $arrChangeOrdersByProjectId;
			}

			$project_id = (int) $project_id;

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$sqlFilter = '';
			if ($change_order_type_id) {
				$escaped_change_order_type_id = $db->escape($change_order_type_id);
				// $sqlFilter = "\nAND co.`change_order_type_id` = $escaped_change_order_type_id";
			}

			$sqlOrderBy = '';
			$selSort = '';
			if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
				$selSort = ", (co.co_custom_sequence_number = ' ') boolnull,(co.co_custom_sequence_number = '-') boolDash, (co.co_custom_sequence_number = '0') boolZero, (co.co_custom_sequence_number+0 > 0) boolNum";
				$sqlOrderBy = "\nORDER BY $arrOrderByAttributes";
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

		co_fk_p.`id` AS 'co_fk_p__project_id',
		co_fk_p.`project_type_id` AS 'co_fk_p__project_type_id',
		co_fk_p.`user_company_id` AS 'co_fk_p__user_company_id',
		co_fk_p.`user_custom_project_id` AS 'co_fk_p__user_custom_project_id',
		co_fk_p.`project_name` AS 'co_fk_p__project_name',
		co_fk_p.`project_owner_name` AS 'co_fk_p__project_owner_name',
		co_fk_p.`latitude` AS 'co_fk_p__latitude',
		co_fk_p.`longitude` AS 'co_fk_p__longitude',
		co_fk_p.`address_line_1` AS 'co_fk_p__address_line_1',
		co_fk_p.`address_line_2` AS 'co_fk_p__address_line_2',
		co_fk_p.`address_line_3` AS 'co_fk_p__address_line_3',
		co_fk_p.`address_line_4` AS 'co_fk_p__address_line_4',
		co_fk_p.`address_city` AS 'co_fk_p__address_city',
		co_fk_p.`address_county` AS 'co_fk_p__address_county',
		co_fk_p.`address_state_or_region` AS 'co_fk_p__address_state_or_region',
		co_fk_p.`address_postal_code` AS 'co_fk_p__address_postal_code',
		co_fk_p.`address_postal_code_extension` AS 'co_fk_p__address_postal_code_extension',
		co_fk_p.`address_country` AS 'co_fk_p__address_country',
		co_fk_p.`building_count` AS 'co_fk_p__building_count',
		co_fk_p.`unit_count` AS 'co_fk_p__unit_count',
		co_fk_p.`gross_square_footage` AS 'co_fk_p__gross_square_footage',
		co_fk_p.`net_rentable_square_footage` AS 'co_fk_p__net_rentable_square_footage',
		co_fk_p.`is_active_flag` AS 'co_fk_p__is_active_flag',
		co_fk_p.`public_plans_flag` AS 'co_fk_p__public_plans_flag',
		co_fk_p.`prevailing_wage_flag` AS 'co_fk_p__prevailing_wage_flag',
		co_fk_p.`city_business_license_required_flag` AS 'co_fk_p__city_business_license_required_flag',
		co_fk_p.`is_internal_flag` AS 'co_fk_p__is_internal_flag',
		co_fk_p.`project_contract_date` AS 'co_fk_p__project_contract_date',
		co_fk_p.`project_start_date` AS 'co_fk_p__project_start_date',
		co_fk_p.`project_completed_date` AS 'co_fk_p__project_completed_date',
		co_fk_p.`sort_order` AS 'co_fk_p__sort_order',

		co_fk_cot.`id` AS 'co_fk_cot__change_order_type_id',
		co_fk_cot.`change_order_type` AS 'co_fk_cot__change_order_type',
		co_fk_cot.`disabled_flag` AS 'co_fk_cot__disabled_flag',

		co_fk_cos.`id` AS 'co_fk_cos__change_order_status_id',
		co_fk_cos.`change_order_status` AS 'co_fk_cos__change_order_status',
		co_fk_cos.`disabled_flag` AS 'co_fk_cos__disabled_flag',

		co_fk_cop.`id` AS 'co_fk_cop__change_order_priority_id',
		co_fk_cop.`change_order_priority` AS 'co_fk_cop__change_order_priority',
		co_fk_cop.`disabled_flag` AS 'co_fk_cop__disabled_flag',

		co_fk_fmfiles.`id` AS 'co_fk_fmfiles__file_manager_file_id',
		co_fk_fmfiles.`user_company_id` AS 'co_fk_fmfiles__user_company_id',
		co_fk_fmfiles.`contact_id` AS 'co_fk_fmfiles__contact_id',
		co_fk_fmfiles.`project_id` AS 'co_fk_fmfiles__project_id',
		co_fk_fmfiles.`file_manager_folder_id` AS 'co_fk_fmfiles__file_manager_folder_id',
		co_fk_fmfiles.`file_location_id` AS 'co_fk_fmfiles__file_location_id',
		co_fk_fmfiles.`virtual_file_name` AS 'co_fk_fmfiles__virtual_file_name',
		co_fk_fmfiles.`version_number` AS 'co_fk_fmfiles__version_number',
		co_fk_fmfiles.`virtual_file_name_sha1` AS 'co_fk_fmfiles__virtual_file_name_sha1',
		co_fk_fmfiles.`virtual_file_mime_type` AS 'co_fk_fmfiles__virtual_file_mime_type',
		co_fk_fmfiles.`modified` AS 'co_fk_fmfiles__modified',
		co_fk_fmfiles.`created` AS 'co_fk_fmfiles__created',
		co_fk_fmfiles.`deleted_flag` AS 'co_fk_fmfiles__deleted_flag',
		co_fk_fmfiles.`directly_deleted_flag` AS 'co_fk_fmfiles__directly_deleted_flag',

		co_fk_codes.`id` AS 'co_fk_codes__cost_code_id',
		co_fk_codes.`cost_code_division_id` AS 'co_fk_codes__cost_code_division_id',
		co_fk_codes.`cost_code` AS 'co_fk_codes__cost_code',
		co_fk_codes.`cost_code_description` AS 'co_fk_codes__cost_code_description',
		co_fk_codes.`cost_code_description_abbreviation` AS 'co_fk_codes__cost_code_description_abbreviation',
		co_fk_codes.`sort_order` AS 'co_fk_codes__sort_order',
		co_fk_codes.`disabled_flag` AS 'co_fk_codes__disabled_flag',

		co_fk_creator_c.`id` AS 'co_fk_creator_c__contact_id',
		co_fk_creator_c.`user_company_id` AS 'co_fk_creator_c__user_company_id',
		co_fk_creator_c.`user_id` AS 'co_fk_creator_c__user_id',
		co_fk_creator_c.`contact_company_id` AS 'co_fk_creator_c__contact_company_id',
		co_fk_creator_c.`email` AS 'co_fk_creator_c__email',
		co_fk_creator_c.`name_prefix` AS 'co_fk_creator_c__name_prefix',
		co_fk_creator_c.`first_name` AS 'co_fk_creator_c__first_name',
		co_fk_creator_c.`additional_name` AS 'co_fk_creator_c__additional_name',
		co_fk_creator_c.`middle_name` AS 'co_fk_creator_c__middle_name',
		co_fk_creator_c.`last_name` AS 'co_fk_creator_c__last_name',
		co_fk_creator_c.`name_suffix` AS 'co_fk_creator_c__name_suffix',
		co_fk_creator_c.`title` AS 'co_fk_creator_c__title',
		co_fk_creator_c.`vendor_flag` AS 'co_fk_creator_c__vendor_flag',

		co_fk_creator_cco.`id` AS 'co_fk_creator_cco__contact_company_office_id',
		co_fk_creator_cco.`contact_company_id` AS 'co_fk_creator_cco__contact_company_id',
		co_fk_creator_cco.`office_nickname` AS 'co_fk_creator_cco__office_nickname',
		co_fk_creator_cco.`address_line_1` AS 'co_fk_creator_cco__address_line_1',
		co_fk_creator_cco.`address_line_2` AS 'co_fk_creator_cco__address_line_2',
		co_fk_creator_cco.`address_line_3` AS 'co_fk_creator_cco__address_line_3',
		co_fk_creator_cco.`address_line_4` AS 'co_fk_creator_cco__address_line_4',
		co_fk_creator_cco.`address_city` AS 'co_fk_creator_cco__address_city',
		co_fk_creator_cco.`address_county` AS 'co_fk_creator_cco__address_county',
		co_fk_creator_cco.`address_state_or_region` AS 'co_fk_creator_cco__address_state_or_region',
		co_fk_creator_cco.`address_postal_code` AS 'co_fk_creator_cco__address_postal_code',
		co_fk_creator_cco.`address_postal_code_extension` AS 'co_fk_creator_cco__address_postal_code_extension',
		co_fk_creator_cco.`address_country` AS 'co_fk_creator_cco__address_country',
		co_fk_creator_cco.`head_quarters_flag` AS 'co_fk_creator_cco__head_quarters_flag',
		co_fk_creator_cco.`address_validated_by_user_flag` AS 'co_fk_creator_cco__address_validated_by_user_flag',
		co_fk_creator_cco.`address_validated_by_web_service_flag` AS 'co_fk_creator_cco__address_validated_by_web_service_flag',
		co_fk_creator_cco.`address_validation_by_web_service_error_flag` AS 'co_fk_creator_cco__address_validation_by_web_service_error_flag',

		co_fk_creator_phone_ccopn.`id` AS 'co_fk_creator_phone_ccopn__contact_company_office_phone_number_id',
		co_fk_creator_phone_ccopn.`contact_company_office_id` AS 'co_fk_creator_phone_ccopn__contact_company_office_id',
		co_fk_creator_phone_ccopn.`phone_number_type_id` AS 'co_fk_creator_phone_ccopn__phone_number_type_id',
		co_fk_creator_phone_ccopn.`country_code` AS 'co_fk_creator_phone_ccopn__country_code',
		co_fk_creator_phone_ccopn.`area_code` AS 'co_fk_creator_phone_ccopn__area_code',
		co_fk_creator_phone_ccopn.`prefix` AS 'co_fk_creator_phone_ccopn__prefix',
		co_fk_creator_phone_ccopn.`number` AS 'co_fk_creator_phone_ccopn__number',
		co_fk_creator_phone_ccopn.`extension` AS 'co_fk_creator_phone_ccopn__extension',
		co_fk_creator_phone_ccopn.`itu` AS 'co_fk_creator_phone_ccopn__itu',

		co_fk_creator_fax_ccopn.`id` AS 'co_fk_creator_fax_ccopn__contact_company_office_phone_number_id',
		co_fk_creator_fax_ccopn.`contact_company_office_id` AS 'co_fk_creator_fax_ccopn__contact_company_office_id',
		co_fk_creator_fax_ccopn.`phone_number_type_id` AS 'co_fk_creator_fax_ccopn__phone_number_type_id',
		co_fk_creator_fax_ccopn.`country_code` AS 'co_fk_creator_fax_ccopn__country_code',
		co_fk_creator_fax_ccopn.`area_code` AS 'co_fk_creator_fax_ccopn__area_code',
		co_fk_creator_fax_ccopn.`prefix` AS 'co_fk_creator_fax_ccopn__prefix',
		co_fk_creator_fax_ccopn.`number` AS 'co_fk_creator_fax_ccopn__number',
		co_fk_creator_fax_ccopn.`extension` AS 'co_fk_creator_fax_ccopn__extension',
		co_fk_creator_fax_ccopn.`itu` AS 'co_fk_creator_fax_ccopn__itu',

		co_fk_creator_c_mobile_cpn.`id` AS 'co_fk_creator_c_mobile_cpn__contact_phone_number_id',
		co_fk_creator_c_mobile_cpn.`contact_id` AS 'co_fk_creator_c_mobile_cpn__contact_id',
		co_fk_creator_c_mobile_cpn.`phone_number_type_id` AS 'co_fk_creator_c_mobile_cpn__phone_number_type_id',
		co_fk_creator_c_mobile_cpn.`country_code` AS 'co_fk_creator_c_mobile_cpn__country_code',
		co_fk_creator_c_mobile_cpn.`area_code` AS 'co_fk_creator_c_mobile_cpn__area_code',
		co_fk_creator_c_mobile_cpn.`prefix` AS 'co_fk_creator_c_mobile_cpn__prefix',
		co_fk_creator_c_mobile_cpn.`number` AS 'co_fk_creator_c_mobile_cpn__number',
		co_fk_creator_c_mobile_cpn.`extension` AS 'co_fk_creator_c_mobile_cpn__extension',
		co_fk_creator_c_mobile_cpn.`itu` AS 'co_fk_creator_c_mobile_cpn__itu',

		co_fk_recipient_c.`id` AS 'co_fk_recipient_c__contact_id',
		co_fk_recipient_c.`user_company_id` AS 'co_fk_recipient_c__user_company_id',
		co_fk_recipient_c.`user_id` AS 'co_fk_recipient_c__user_id',
		co_fk_recipient_c.`contact_company_id` AS 'co_fk_recipient_c__contact_company_id',
		co_fk_recipient_c.`email` AS 'co_fk_recipient_c__email',
		co_fk_recipient_c.`name_prefix` AS 'co_fk_recipient_c__name_prefix',
		co_fk_recipient_c.`first_name` AS 'co_fk_recipient_c__first_name',
		co_fk_recipient_c.`additional_name` AS 'co_fk_recipient_c__additional_name',
		co_fk_recipient_c.`middle_name` AS 'co_fk_recipient_c__middle_name',
		co_fk_recipient_c.`last_name` AS 'co_fk_recipient_c__last_name',
		co_fk_recipient_c.`name_suffix` AS 'co_fk_recipient_c__name_suffix',
		co_fk_recipient_c.`title` AS 'co_fk_recipient_c__title',
		co_fk_recipient_c.`vendor_flag` AS 'co_fk_recipient_c__vendor_flag',

		co_fk_recipient_cco.`id` AS 'co_fk_recipient_cco__contact_company_office_id',
		co_fk_recipient_cco.`contact_company_id` AS 'co_fk_recipient_cco__contact_company_id',
		co_fk_recipient_cco.`office_nickname` AS 'co_fk_recipient_cco__office_nickname',
		co_fk_recipient_cco.`address_line_1` AS 'co_fk_recipient_cco__address_line_1',
		co_fk_recipient_cco.`address_line_2` AS 'co_fk_recipient_cco__address_line_2',
		co_fk_recipient_cco.`address_line_3` AS 'co_fk_recipient_cco__address_line_3',
		co_fk_recipient_cco.`address_line_4` AS 'co_fk_recipient_cco__address_line_4',
		co_fk_recipient_cco.`address_city` AS 'co_fk_recipient_cco__address_city',
		co_fk_recipient_cco.`address_county` AS 'co_fk_recipient_cco__address_county',
		co_fk_recipient_cco.`address_state_or_region` AS 'co_fk_recipient_cco__address_state_or_region',
		co_fk_recipient_cco.`address_postal_code` AS 'co_fk_recipient_cco__address_postal_code',
		co_fk_recipient_cco.`address_postal_code_extension` AS 'co_fk_recipient_cco__address_postal_code_extension',
		co_fk_recipient_cco.`address_country` AS 'co_fk_recipient_cco__address_country',
		co_fk_recipient_cco.`head_quarters_flag` AS 'co_fk_recipient_cco__head_quarters_flag',
		co_fk_recipient_cco.`address_validated_by_user_flag` AS 'co_fk_recipient_cco__address_validated_by_user_flag',
		co_fk_recipient_cco.`address_validated_by_web_service_flag` AS 'co_fk_recipient_cco__address_validated_by_web_service_flag',
		co_fk_recipient_cco.`address_validation_by_web_service_error_flag` AS 'co_fk_recipient_cco__address_validation_by_web_service_error_flag',

		co_fk_recipient_phone_ccopn.`id` AS 'co_fk_recipient_phone_ccopn__contact_company_office_phone_number_id',
		co_fk_recipient_phone_ccopn.`contact_company_office_id` AS 'co_fk_recipient_phone_ccopn__contact_company_office_id',
		co_fk_recipient_phone_ccopn.`phone_number_type_id` AS 'co_fk_recipient_phone_ccopn__phone_number_type_id',
		co_fk_recipient_phone_ccopn.`country_code` AS 'co_fk_recipient_phone_ccopn__country_code',
		co_fk_recipient_phone_ccopn.`area_code` AS 'co_fk_recipient_phone_ccopn__area_code',
		co_fk_recipient_phone_ccopn.`prefix` AS 'co_fk_recipient_phone_ccopn__prefix',
		co_fk_recipient_phone_ccopn.`number` AS 'co_fk_recipient_phone_ccopn__number',
		co_fk_recipient_phone_ccopn.`extension` AS 'co_fk_recipient_phone_ccopn__extension',
		co_fk_recipient_phone_ccopn.`itu` AS 'co_fk_recipient_phone_ccopn__itu',

		co_fk_recipient_fax_ccopn.`id` AS 'co_fk_recipient_fax_ccopn__contact_company_office_phone_number_id',
		co_fk_recipient_fax_ccopn.`contact_company_office_id` AS 'co_fk_recipient_fax_ccopn__contact_company_office_id',
		co_fk_recipient_fax_ccopn.`phone_number_type_id` AS 'co_fk_recipient_fax_ccopn__phone_number_type_id',
		co_fk_recipient_fax_ccopn.`country_code` AS 'co_fk_recipient_fax_ccopn__country_code',
		co_fk_recipient_fax_ccopn.`area_code` AS 'co_fk_recipient_fax_ccopn__area_code',
		co_fk_recipient_fax_ccopn.`prefix` AS 'co_fk_recipient_fax_ccopn__prefix',
		co_fk_recipient_fax_ccopn.`number` AS 'co_fk_recipient_fax_ccopn__number',
		co_fk_recipient_fax_ccopn.`extension` AS 'co_fk_recipient_fax_ccopn__extension',
		co_fk_recipient_fax_ccopn.`itu` AS 'co_fk_recipient_fax_ccopn__itu',

		co_fk_recipient_c_mobile_cpn.`id` AS 'co_fk_recipient_c_mobile_cpn__contact_phone_number_id',
		co_fk_recipient_c_mobile_cpn.`contact_id` AS 'co_fk_recipient_c_mobile_cpn__contact_id',
		co_fk_recipient_c_mobile_cpn.`phone_number_type_id` AS 'co_fk_recipient_c_mobile_cpn__phone_number_type_id',
		co_fk_recipient_c_mobile_cpn.`country_code` AS 'co_fk_recipient_c_mobile_cpn__country_code',
		co_fk_recipient_c_mobile_cpn.`area_code` AS 'co_fk_recipient_c_mobile_cpn__area_code',
		co_fk_recipient_c_mobile_cpn.`prefix` AS 'co_fk_recipient_c_mobile_cpn__prefix',
		co_fk_recipient_c_mobile_cpn.`number` AS 'co_fk_recipient_c_mobile_cpn__number',
		co_fk_recipient_c_mobile_cpn.`extension` AS 'co_fk_recipient_c_mobile_cpn__extension',
		co_fk_recipient_c_mobile_cpn.`itu` AS 'co_fk_recipient_c_mobile_cpn__itu',

		co_fk_initiator_c.`id` AS 'co_fk_initiator_c__contact_id',
		co_fk_initiator_c.`user_company_id` AS 'co_fk_initiator_c__user_company_id',
		co_fk_initiator_c.`user_id` AS 'co_fk_initiator_c__user_id',
		co_fk_initiator_c.`contact_company_id` AS 'co_fk_initiator_c__contact_company_id',
		co_fk_initiator_c.`email` AS 'co_fk_initiator_c__email',
		co_fk_initiator_c.`name_prefix` AS 'co_fk_initiator_c__name_prefix',
		co_fk_initiator_c.`first_name` AS 'co_fk_initiator_c__first_name',
		co_fk_initiator_c.`additional_name` AS 'co_fk_initiator_c__additional_name',
		co_fk_initiator_c.`middle_name` AS 'co_fk_initiator_c__middle_name',
		co_fk_initiator_c.`last_name` AS 'co_fk_initiator_c__last_name',
		co_fk_initiator_c.`name_suffix` AS 'co_fk_initiator_c__name_suffix',
		co_fk_initiator_c.`title` AS 'co_fk_initiator_c__title',
		co_fk_initiator_c.`vendor_flag` AS 'co_fk_initiator_c__vendor_flag',

		co_fk_initiator_cco.`id` AS 'co_fk_initiator_cco__contact_company_office_id',
		co_fk_initiator_cco.`contact_company_id` AS 'co_fk_initiator_cco__contact_company_id',
		co_fk_initiator_cco.`office_nickname` AS 'co_fk_initiator_cco__office_nickname',
		co_fk_initiator_cco.`address_line_1` AS 'co_fk_initiator_cco__address_line_1',
		co_fk_initiator_cco.`address_line_2` AS 'co_fk_initiator_cco__address_line_2',
		co_fk_initiator_cco.`address_line_3` AS 'co_fk_initiator_cco__address_line_3',
		co_fk_initiator_cco.`address_line_4` AS 'co_fk_initiator_cco__address_line_4',
		co_fk_initiator_cco.`address_city` AS 'co_fk_initiator_cco__address_city',
		co_fk_initiator_cco.`address_county` AS 'co_fk_initiator_cco__address_county',
		co_fk_initiator_cco.`address_state_or_region` AS 'co_fk_initiator_cco__address_state_or_region',
		co_fk_initiator_cco.`address_postal_code` AS 'co_fk_initiator_cco__address_postal_code',
		co_fk_initiator_cco.`address_postal_code_extension` AS 'co_fk_initiator_cco__address_postal_code_extension',
		co_fk_initiator_cco.`address_country` AS 'co_fk_initiator_cco__address_country',
		co_fk_initiator_cco.`head_quarters_flag` AS 'co_fk_initiator_cco__head_quarters_flag',
		co_fk_initiator_cco.`address_validated_by_user_flag` AS 'co_fk_initiator_cco__address_validated_by_user_flag',
		co_fk_initiator_cco.`address_validated_by_web_service_flag` AS 'co_fk_initiator_cco__address_validated_by_web_service_flag',
		co_fk_initiator_cco.`address_validation_by_web_service_error_flag` AS 'co_fk_initiator_cco__address_validation_by_web_service_error_flag',

		co_fk_initiator_phone_ccopn.`id` AS 'co_fk_initiator_phone_ccopn__contact_company_office_phone_number_id',
		co_fk_initiator_phone_ccopn.`contact_company_office_id` AS 'co_fk_initiator_phone_ccopn__contact_company_office_id',
		co_fk_initiator_phone_ccopn.`phone_number_type_id` AS 'co_fk_initiator_phone_ccopn__phone_number_type_id',
		co_fk_initiator_phone_ccopn.`country_code` AS 'co_fk_initiator_phone_ccopn__country_code',
		co_fk_initiator_phone_ccopn.`area_code` AS 'co_fk_initiator_phone_ccopn__area_code',
		co_fk_initiator_phone_ccopn.`prefix` AS 'co_fk_initiator_phone_ccopn__prefix',
		co_fk_initiator_phone_ccopn.`number` AS 'co_fk_initiator_phone_ccopn__number',
		co_fk_initiator_phone_ccopn.`extension` AS 'co_fk_initiator_phone_ccopn__extension',
		co_fk_initiator_phone_ccopn.`itu` AS 'co_fk_initiator_phone_ccopn__itu',

		co_fk_initiator_fax_ccopn.`id` AS 'co_fk_initiator_fax_ccopn__contact_company_office_phone_number_id',
		co_fk_initiator_fax_ccopn.`contact_company_office_id` AS 'co_fk_initiator_fax_ccopn__contact_company_office_id',
		co_fk_initiator_fax_ccopn.`phone_number_type_id` AS 'co_fk_initiator_fax_ccopn__phone_number_type_id',
		co_fk_initiator_fax_ccopn.`country_code` AS 'co_fk_initiator_fax_ccopn__country_code',
		co_fk_initiator_fax_ccopn.`area_code` AS 'co_fk_initiator_fax_ccopn__area_code',
		co_fk_initiator_fax_ccopn.`prefix` AS 'co_fk_initiator_fax_ccopn__prefix',
		co_fk_initiator_fax_ccopn.`number` AS 'co_fk_initiator_fax_ccopn__number',
		co_fk_initiator_fax_ccopn.`extension` AS 'co_fk_initiator_fax_ccopn__extension',
		co_fk_initiator_fax_ccopn.`itu` AS 'co_fk_initiator_fax_ccopn__itu',

		co_fk_initiator_c_mobile_cpn.`id` AS 'co_fk_initiator_c_mobile_cpn__contact_phone_number_id',
		co_fk_initiator_c_mobile_cpn.`contact_id` AS 'co_fk_initiator_c_mobile_cpn__contact_id',
		co_fk_initiator_c_mobile_cpn.`phone_number_type_id` AS 'co_fk_initiator_c_mobile_cpn__phone_number_type_id',
		co_fk_initiator_c_mobile_cpn.`country_code` AS 'co_fk_initiator_c_mobile_cpn__country_code',
		co_fk_initiator_c_mobile_cpn.`area_code` AS 'co_fk_initiator_c_mobile_cpn__area_code',
		co_fk_initiator_c_mobile_cpn.`prefix` AS 'co_fk_initiator_c_mobile_cpn__prefix',
		co_fk_initiator_c_mobile_cpn.`number` AS 'co_fk_initiator_c_mobile_cpn__number',
		co_fk_initiator_c_mobile_cpn.`extension` AS 'co_fk_initiator_c_mobile_cpn__extension',
		co_fk_initiator_c_mobile_cpn.`itu` AS 'co_fk_initiator_c_mobile_cpn__itu',

		co.* $selSort

		FROM `change_orders` co
		INNER JOIN `projects` co_fk_p ON co.`project_id` = co_fk_p.`id`
		INNER JOIN `change_order_types` co_fk_cot ON co.`change_order_type_id` = co_fk_cot.`id`
		INNER JOIN `change_order_statuses` co_fk_cos ON co.`change_order_status_id` = co_fk_cos.`id`
		LEFT OUTER JOIN `change_order_priorities` co_fk_cop ON co.`change_order_priority_id` = co_fk_cop.`id`
		LEFT OUTER JOIN `file_manager_files` co_fk_fmfiles ON co.`co_file_manager_file_id` = co_fk_fmfiles.`id`
		LEFT OUTER JOIN `cost_codes` co_fk_codes ON co.`co_cost_code_id` = co_fk_codes.`id`
		INNER JOIN `contacts` co_fk_creator_c ON co.`co_creator_contact_id` = co_fk_creator_c.`id`
		LEFT OUTER JOIN `contact_company_offices` co_fk_creator_cco ON co.`co_creator_contact_company_office_id` = co_fk_creator_cco.`id`
		LEFT OUTER JOIN `contact_company_office_phone_numbers` co_fk_creator_phone_ccopn ON co.`co_creator_phone_contact_company_office_phone_number_id` = co_fk_creator_phone_ccopn.`id`
		LEFT OUTER JOIN `contact_company_office_phone_numbers` co_fk_creator_fax_ccopn ON co.`co_creator_fax_contact_company_office_phone_number_id` = co_fk_creator_fax_ccopn.`id`
		LEFT OUTER JOIN `contact_phone_numbers` co_fk_creator_c_mobile_cpn ON co.`co_creator_contact_mobile_phone_number_id` = co_fk_creator_c_mobile_cpn.`id`
		LEFT OUTER JOIN `contacts` co_fk_recipient_c ON co.`co_recipient_contact_id` = co_fk_recipient_c.`id`
		LEFT OUTER JOIN `contact_company_offices` co_fk_recipient_cco ON co.`co_recipient_contact_company_office_id` = co_fk_recipient_cco.`id`
		LEFT OUTER JOIN `contact_company_office_phone_numbers` co_fk_recipient_phone_ccopn ON co.`co_recipient_phone_contact_company_office_phone_number_id` = co_fk_recipient_phone_ccopn.`id`
		LEFT OUTER JOIN `contact_company_office_phone_numbers` co_fk_recipient_fax_ccopn ON co.`co_recipient_fax_contact_company_office_phone_number_id` = co_fk_recipient_fax_ccopn.`id`
		LEFT OUTER JOIN `contact_phone_numbers` co_fk_recipient_c_mobile_cpn ON co.`co_recipient_contact_mobile_phone_number_id` = co_fk_recipient_c_mobile_cpn.`id`
		LEFT OUTER JOIN `contacts` co_fk_initiator_c ON co.`co_initiator_contact_id` = co_fk_initiator_c.`id`
		LEFT OUTER JOIN `contact_company_offices` co_fk_initiator_cco ON co.`co_initiator_contact_company_office_id` = co_fk_initiator_cco.`id`
		LEFT OUTER JOIN `contact_company_office_phone_numbers` co_fk_initiator_phone_ccopn ON co.`co_initiator_phone_contact_company_office_phone_number_id` = co_fk_initiator_phone_ccopn.`id`
		LEFT OUTER JOIN `contact_company_office_phone_numbers` co_fk_initiator_fax_ccopn ON co.`co_initiator_fax_contact_company_office_phone_number_id` = co_fk_initiator_fax_ccopn.`id`
		LEFT OUTER JOIN `contact_phone_numbers` co_fk_initiator_c_mobile_cpn ON co.`co_initiator_contact_mobile_phone_number_id` = co_fk_initiator_c_mobile_cpn.`id`
	WHERE co.`project_id` = ? $whereIn $whereStatusIn $whereStatus and date(co.created) BETWEEN '$new_begindate' AND '$enddate' {$sqlFilter}{$sqlOrderBy}{$sqlLimit}
	";
	
			$arrValues = array($project_id);
			$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

			$arrChangeOrdersByProjectId = array();
			while ($row = $db->fetch()) {
				$change_order_id = $row['id'];
				$changeOrder = self::instantiateOrm($database, 'ChangeOrder', $row, null, $change_order_id);
				/* @var $changeOrder ChangeOrder */
				$changeOrder->convertPropertiesToData();

				if (isset($row['project_id'])) {
					$project_id = $row['project_id'];
					$row['co_fk_p__id'] = $project_id;
					$project = self::instantiateOrm($database, 'Project', $row, null, $project_id, 'co_fk_p__');
					/* @var $project Project */
					$project->convertPropertiesToData();
				} else {
					$project = false;
				}
				$changeOrder->setProject($project);

				if (isset($row['change_order_type_id'])) {
					$change_order_type_id = $row['change_order_type_id'];
					$row['co_fk_cot__id'] = $change_order_type_id;
					$changeOrderType = self::instantiateOrm($database, 'ChangeOrderType', $row, null, $change_order_type_id, 'co_fk_cot__');
					/* @var $changeOrderType ChangeOrderType */
					$changeOrderType->convertPropertiesToData();
				} else {
					$changeOrderType = false;
				}
				$changeOrder->setChangeOrderType($changeOrderType);

				if (isset($row['change_order_status_id'])) {
					$change_order_status_id = $row['change_order_status_id'];
					$row['co_fk_cos__id'] = $change_order_status_id;
					$changeOrderStatus = self::instantiateOrm($database, 'ChangeOrderStatus', $row, null, $change_order_status_id, 'co_fk_cos__');
					/* @var $changeOrderStatus ChangeOrderStatus */
					$changeOrderStatus->convertPropertiesToData();
				} else {
					$changeOrderStatus = false;
				}
				$changeOrder->setChangeOrderStatus($changeOrderStatus);

				if (isset($row['change_order_priority_id'])) {
					$change_order_priority_id = $row['change_order_priority_id'];
					$row['co_fk_cop__id'] = $change_order_priority_id;
					$changeOrderPriority = self::instantiateOrm($database, 'ChangeOrderPriority', $row, null, $change_order_priority_id, 'co_fk_cop__');
					/* @var $changeOrderPriority ChangeOrderPriority */
					$changeOrderPriority->convertPropertiesToData();
				} else {
					$changeOrderPriority = false;
				}
				$changeOrder->setChangeOrderPriority($changeOrderPriority);

				if (isset($row['co_file_manager_file_id'])) {
					$co_file_manager_file_id = $row['co_file_manager_file_id'];
					$row['co_fk_fmfiles__id'] = $co_file_manager_file_id;
					$coFileManagerFile = self::instantiateOrm($database, 'FileManagerFile', $row, null, $co_file_manager_file_id, 'co_fk_fmfiles__');
					/* @var $coFileManagerFile FileManagerFile */
					$coFileManagerFile->convertPropertiesToData();
				} else {
					$coFileManagerFile = false;
				}
				$changeOrder->setCoFileManagerFile($coFileManagerFile);

				if (isset($row['co_cost_code_id'])) {
					$co_cost_code_id = $row['co_cost_code_id'];
					$row['co_fk_codes__id'] = $co_cost_code_id;
					$coCostCode = self::instantiateOrm($database, 'CostCode', $row, null, $co_cost_code_id, 'co_fk_codes__');
					/* @var $coCostCode CostCode */
					$coCostCode->convertPropertiesToData();
				} else {
					$coCostCode = false;
				}
				$changeOrder->setCoCostCode($coCostCode);

				if (isset($row['co_creator_contact_id'])) {
					$co_creator_contact_id = $row['co_creator_contact_id'];
					$row['co_fk_creator_c__id'] = $co_creator_contact_id;
					$coCreatorContact = self::instantiateOrm($database, 'Contact', $row, null, $co_creator_contact_id, 'co_fk_creator_c__');
					/* @var $coCreatorContact Contact */
					$coCreatorContact->convertPropertiesToData();
				} else {
					$coCreatorContact = false;
				}
				$changeOrder->setCoCreatorContact($coCreatorContact);

				if (isset($row['co_creator_contact_company_office_id'])) {
					$co_creator_contact_company_office_id = $row['co_creator_contact_company_office_id'];
					$row['co_fk_creator_cco__id'] = $co_creator_contact_company_office_id;
					$coCreatorContactCompanyOffice = self::instantiateOrm($database, 'ContactCompanyOffice', $row, null, $co_creator_contact_company_office_id, 'co_fk_creator_cco__');
					/* @var $coCreatorContactCompanyOffice ContactCompanyOffice */
					$coCreatorContactCompanyOffice->convertPropertiesToData();
				} else {
					$coCreatorContactCompanyOffice = false;
				}
				$changeOrder->setCoCreatorContactCompanyOffice($coCreatorContactCompanyOffice);

				if (isset($row['co_creator_phone_contact_company_office_phone_number_id'])) {
					$co_creator_phone_contact_company_office_phone_number_id = $row['co_creator_phone_contact_company_office_phone_number_id'];
					$row['co_fk_creator_phone_ccopn__id'] = $co_creator_phone_contact_company_office_phone_number_id;
					$coCreatorPhoneContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $co_creator_phone_contact_company_office_phone_number_id, 'co_fk_creator_phone_ccopn__');
					/* @var $coCreatorPhoneContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
					$coCreatorPhoneContactCompanyOfficePhoneNumber->convertPropertiesToData();
				} else {
					$coCreatorPhoneContactCompanyOfficePhoneNumber = false;
				}
				$changeOrder->setCoCreatorPhoneContactCompanyOfficePhoneNumber($coCreatorPhoneContactCompanyOfficePhoneNumber);

				if (isset($row['co_creator_fax_contact_company_office_phone_number_id'])) {
					$co_creator_fax_contact_company_office_phone_number_id = $row['co_creator_fax_contact_company_office_phone_number_id'];
					$row['co_fk_creator_fax_ccopn__id'] = $co_creator_fax_contact_company_office_phone_number_id;
					$coCreatorFaxContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $co_creator_fax_contact_company_office_phone_number_id, 'co_fk_creator_fax_ccopn__');
					/* @var $coCreatorFaxContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
					$coCreatorFaxContactCompanyOfficePhoneNumber->convertPropertiesToData();
				} else {
					$coCreatorFaxContactCompanyOfficePhoneNumber = false;
				}
				$changeOrder->setCoCreatorFaxContactCompanyOfficePhoneNumber($coCreatorFaxContactCompanyOfficePhoneNumber);

				if (isset($row['co_creator_contact_mobile_phone_number_id'])) {
					$co_creator_contact_mobile_phone_number_id = $row['co_creator_contact_mobile_phone_number_id'];
					$row['co_fk_creator_c_mobile_cpn__id'] = $co_creator_contact_mobile_phone_number_id;
					$coCreatorContactMobilePhoneNumber = self::instantiateOrm($database, 'ContactPhoneNumber', $row, null, $co_creator_contact_mobile_phone_number_id, 'co_fk_creator_c_mobile_cpn__');
					/* @var $coCreatorContactMobilePhoneNumber ContactPhoneNumber */
					$coCreatorContactMobilePhoneNumber->convertPropertiesToData();
				} else {
					$coCreatorContactMobilePhoneNumber = false;
				}
				$changeOrder->setCoCreatorContactMobilePhoneNumber($coCreatorContactMobilePhoneNumber);

				if (isset($row['co_recipient_contact_id'])) {
					$co_recipient_contact_id = $row['co_recipient_contact_id'];
					$row['co_fk_recipient_c__id'] = $co_recipient_contact_id;
					$coRecipientContact = self::instantiateOrm($database, 'Contact', $row, null, $co_recipient_contact_id, 'co_fk_recipient_c__');
					/* @var $coRecipientContact Contact */
					$coRecipientContact->convertPropertiesToData();
				} else {
					$coRecipientContact = false;
				}
				$changeOrder->setCoRecipientContact($coRecipientContact);

				if (isset($row['co_recipient_contact_company_office_id'])) {
					$co_recipient_contact_company_office_id = $row['co_recipient_contact_company_office_id'];
					$row['co_fk_recipient_cco__id'] = $co_recipient_contact_company_office_id;
					$coRecipientContactCompanyOffice = self::instantiateOrm($database, 'ContactCompanyOffice', $row, null, $co_recipient_contact_company_office_id, 'co_fk_recipient_cco__');
					/* @var $coRecipientContactCompanyOffice ContactCompanyOffice */
					$coRecipientContactCompanyOffice->convertPropertiesToData();
				} else {
					$coRecipientContactCompanyOffice = false;
				}
				$changeOrder->setCoRecipientContactCompanyOffice($coRecipientContactCompanyOffice);

				if (isset($row['co_recipient_phone_contact_company_office_phone_number_id'])) {
					$co_recipient_phone_contact_company_office_phone_number_id = $row['co_recipient_phone_contact_company_office_phone_number_id'];
					$row['co_fk_recipient_phone_ccopn__id'] = $co_recipient_phone_contact_company_office_phone_number_id;
					$coRecipientPhoneContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $co_recipient_phone_contact_company_office_phone_number_id, 'co_fk_recipient_phone_ccopn__');
					/* @var $coRecipientPhoneContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
					$coRecipientPhoneContactCompanyOfficePhoneNumber->convertPropertiesToData();
				} else {
					$coRecipientPhoneContactCompanyOfficePhoneNumber = false;
				}
				$changeOrder->setCoRecipientPhoneContactCompanyOfficePhoneNumber($coRecipientPhoneContactCompanyOfficePhoneNumber);

				if (isset($row['co_recipient_fax_contact_company_office_phone_number_id'])) {
					$co_recipient_fax_contact_company_office_phone_number_id = $row['co_recipient_fax_contact_company_office_phone_number_id'];
					$row['co_fk_recipient_fax_ccopn__id'] = $co_recipient_fax_contact_company_office_phone_number_id;
					$coRecipientFaxContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $co_recipient_fax_contact_company_office_phone_number_id, 'co_fk_recipient_fax_ccopn__');
					/* @var $coRecipientFaxContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
					$coRecipientFaxContactCompanyOfficePhoneNumber->convertPropertiesToData();
				} else {
					$coRecipientFaxContactCompanyOfficePhoneNumber = false;
				}
				$changeOrder->setCoRecipientFaxContactCompanyOfficePhoneNumber($coRecipientFaxContactCompanyOfficePhoneNumber);

				if (isset($row['co_recipient_contact_mobile_phone_number_id'])) {
					$co_recipient_contact_mobile_phone_number_id = $row['co_recipient_contact_mobile_phone_number_id'];
					$row['co_fk_recipient_c_mobile_cpn__id'] = $co_recipient_contact_mobile_phone_number_id;
					$coRecipientContactMobilePhoneNumber = self::instantiateOrm($database, 'ContactPhoneNumber', $row, null, $co_recipient_contact_mobile_phone_number_id, 'co_fk_recipient_c_mobile_cpn__');
					/* @var $coRecipientContactMobilePhoneNumber ContactPhoneNumber */
					$coRecipientContactMobilePhoneNumber->convertPropertiesToData();
				} else {
					$coRecipientContactMobilePhoneNumber = false;
				}
				$changeOrder->setCoRecipientContactMobilePhoneNumber($coRecipientContactMobilePhoneNumber);

				if (isset($row['co_initiator_contact_id'])) {
					$co_initiator_contact_id = $row['co_initiator_contact_id'];
					$row['co_fk_initiator_c__id'] = $co_initiator_contact_id;
					$coInitiatorContact = self::instantiateOrm($database, 'Contact', $row, null, $co_initiator_contact_id, 'co_fk_initiator_c__');
					/* @var $coInitiatorContact Contact */
					$coInitiatorContact->convertPropertiesToData();
				} else {
					$coInitiatorContact = false;
				}
				$changeOrder->setCoInitiatorContact($coInitiatorContact);

				if (isset($row['co_initiator_contact_company_office_id'])) {
					$co_initiator_contact_company_office_id = $row['co_initiator_contact_company_office_id'];
					$row['co_fk_initiator_cco__id'] = $co_initiator_contact_company_office_id;
					$coInitiatorContactCompanyOffice = self::instantiateOrm($database, 'ContactCompanyOffice', $row, null, $co_initiator_contact_company_office_id, 'co_fk_initiator_cco__');
					/* @var $coInitiatorContactCompanyOffice ContactCompanyOffice */
					$coInitiatorContactCompanyOffice->convertPropertiesToData();
				} else {
					$coInitiatorContactCompanyOffice = false;
				}
				$changeOrder->setCoInitiatorContactCompanyOffice($coInitiatorContactCompanyOffice);

				if (isset($row['co_initiator_phone_contact_company_office_phone_number_id'])) {
					$co_initiator_phone_contact_company_office_phone_number_id = $row['co_initiator_phone_contact_company_office_phone_number_id'];
					$row['co_fk_initiator_phone_ccopn__id'] = $co_initiator_phone_contact_company_office_phone_number_id;
					$coInitiatorPhoneContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $co_initiator_phone_contact_company_office_phone_number_id, 'co_fk_initiator_phone_ccopn__');
					/* @var $coInitiatorPhoneContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
					$coInitiatorPhoneContactCompanyOfficePhoneNumber->convertPropertiesToData();
				} else {
					$coInitiatorPhoneContactCompanyOfficePhoneNumber = false;
				}
				$changeOrder->setCoInitiatorPhoneContactCompanyOfficePhoneNumber($coInitiatorPhoneContactCompanyOfficePhoneNumber);

				if (isset($row['co_initiator_fax_contact_company_office_phone_number_id'])) {
					$co_initiator_fax_contact_company_office_phone_number_id = $row['co_initiator_fax_contact_company_office_phone_number_id'];
					$row['co_fk_initiator_fax_ccopn__id'] = $co_initiator_fax_contact_company_office_phone_number_id;
					$coInitiatorFaxContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $co_initiator_fax_contact_company_office_phone_number_id, 'co_fk_initiator_fax_ccopn__');
					/* @var $coInitiatorFaxContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
					$coInitiatorFaxContactCompanyOfficePhoneNumber->convertPropertiesToData();
				} else {
					$coInitiatorFaxContactCompanyOfficePhoneNumber = false;
				}
				$changeOrder->setCoInitiatorFaxContactCompanyOfficePhoneNumber($coInitiatorFaxContactCompanyOfficePhoneNumber);

				if (isset($row['co_initiator_contact_mobile_phone_number_id'])) {
					$co_initiator_contact_mobile_phone_number_id = $row['co_initiator_contact_mobile_phone_number_id'];
					$row['co_fk_initiator_c_mobile_cpn__id'] = $co_initiator_contact_mobile_phone_number_id;
					$coInitiatorContactMobilePhoneNumber = self::instantiateOrm($database, 'ContactPhoneNumber', $row, null, $co_initiator_contact_mobile_phone_number_id, 'co_fk_initiator_c_mobile_cpn__');
					/* @var $coInitiatorContactMobilePhoneNumber ContactPhoneNumber */
					$coInitiatorContactMobilePhoneNumber->convertPropertiesToData();
				} else {
					$coInitiatorContactMobilePhoneNumber = false;
				}
				$changeOrder->setCoInitiatorContactMobilePhoneNumber($coInitiatorContactMobilePhoneNumber);

				$arrChangeOrdersByProjectId[$change_order_id] = $changeOrder;
			}

			$db->free_result();

			self::$_arrChangeOrdersByProjectId = $arrChangeOrdersByProjectId;

			return $arrChangeOrdersByProjectId;
		}
		// Loaders: Load By Foreign Key
		/**
		 * Load by constraint `change_orders_fk_p` foreign key (`project_id`) references `projects` (`id`) on delete cascade on update cascade.
		 *
		 * @param string $database
		 * @param int $project_id
		 * @param mixed (Input $options object | null)
		 * @return mixed (array ORM List | empty array)
		 */
		public static function loadAllChangeOrdersByProjectId($database, $project_id, Input $options=null)
		{
			$change_order_type_id = false;
			$change_order_status_id =false;
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

				if (isset($options->change_order_type_id) && !empty($options->change_order_type_id)) {
					$change_order_type_id = $options->change_order_type_id;
				}
				if (isset($options->change_order_status_id) && !empty($options->change_order_status_id)) {
					$change_order_status_id = $options->change_order_status_id;
				}
			}

			if($change_order_status_id != ''){
				$change_order_status_id = implode(',',$change_order_status_id);
				$whereStatusIn = "and co.change_order_status_id IN(".$change_order_status_id.")";
			}else{
				$whereStatusIn = "";
			}
			if(!empty($options->showreject) && $options->showreject =='true'){
				$whereStatus = "";
			}else{
				$whereStatus = "AND co_fk_cos.`change_order_status` !='Rejected '";
			}
			

			if ($forceLoadFlag) {
				self::$_arrChangeOrdersByProjectId = null;
			}

			$arrChangeOrdersByProjectId = self::$_arrChangeOrdersByProjectId;
			if (isset($arrChangeOrdersByProjectId) && !empty($arrChangeOrdersByProjectId)) {
				return $arrChangeOrdersByProjectId;
			}

			$project_id = (int) $project_id;

			$db = DBI::getInstance($database);
			/* @var $db DBI_mysqli */

			$sqlFilter = '';
			if ($change_order_type_id) {
				$escaped_change_order_type_id = $db->escape($change_order_type_id);
				$sqlFilter = "\nAND co.`change_order_type_id` = $escaped_change_order_type_id";
			}

		
			$sqlOrderBy = '';
			$selSort = '';
			if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
				$selSort = ", (co.co_custom_sequence_number = ' ') boolnull,(co.co_custom_sequence_number = '-') boolDash, (co.co_custom_sequence_number = '0') boolZero, (co.co_custom_sequence_number+0 > 0) boolNum";
				$sqlOrderBy = "\nORDER BY $arrOrderByAttributes";
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

		co_fk_p.`id` AS 'co_fk_p__project_id',
		co_fk_p.`project_type_id` AS 'co_fk_p__project_type_id',
		co_fk_p.`user_company_id` AS 'co_fk_p__user_company_id',
		co_fk_p.`user_custom_project_id` AS 'co_fk_p__user_custom_project_id',
		co_fk_p.`project_name` AS 'co_fk_p__project_name',
		co_fk_p.`project_owner_name` AS 'co_fk_p__project_owner_name',
		co_fk_p.`latitude` AS 'co_fk_p__latitude',
		co_fk_p.`longitude` AS 'co_fk_p__longitude',
		co_fk_p.`address_line_1` AS 'co_fk_p__address_line_1',
		co_fk_p.`address_line_2` AS 'co_fk_p__address_line_2',
		co_fk_p.`address_line_3` AS 'co_fk_p__address_line_3',
		co_fk_p.`address_line_4` AS 'co_fk_p__address_line_4',
		co_fk_p.`address_city` AS 'co_fk_p__address_city',
		co_fk_p.`address_county` AS 'co_fk_p__address_county',
		co_fk_p.`address_state_or_region` AS 'co_fk_p__address_state_or_region',
		co_fk_p.`address_postal_code` AS 'co_fk_p__address_postal_code',
		co_fk_p.`address_postal_code_extension` AS 'co_fk_p__address_postal_code_extension',
		co_fk_p.`address_country` AS 'co_fk_p__address_country',
		co_fk_p.`building_count` AS 'co_fk_p__building_count',
		co_fk_p.`unit_count` AS 'co_fk_p__unit_count',
		co_fk_p.`gross_square_footage` AS 'co_fk_p__gross_square_footage',
		co_fk_p.`net_rentable_square_footage` AS 'co_fk_p__net_rentable_square_footage',
		co_fk_p.`is_active_flag` AS 'co_fk_p__is_active_flag',
		co_fk_p.`public_plans_flag` AS 'co_fk_p__public_plans_flag',
		co_fk_p.`prevailing_wage_flag` AS 'co_fk_p__prevailing_wage_flag',
		co_fk_p.`city_business_license_required_flag` AS 'co_fk_p__city_business_license_required_flag',
		co_fk_p.`is_internal_flag` AS 'co_fk_p__is_internal_flag',
		co_fk_p.`project_contract_date` AS 'co_fk_p__project_contract_date',
		co_fk_p.`project_start_date` AS 'co_fk_p__project_start_date',
		co_fk_p.`project_completed_date` AS 'co_fk_p__project_completed_date',
		co_fk_p.`sort_order` AS 'co_fk_p__sort_order',

		co_fk_cot.`id` AS 'co_fk_cot__change_order_type_id',
		co_fk_cot.`change_order_type` AS 'co_fk_cot__change_order_type',
		co_fk_cot.`disabled_flag` AS 'co_fk_cot__disabled_flag',

		co_fk_cos.`id` AS 'co_fk_cos__change_order_status_id',
		co_fk_cos.`change_order_status` AS 'co_fk_cos__change_order_status',
		co_fk_cos.`disabled_flag` AS 'co_fk_cos__disabled_flag',

		co_fk_cop.`id` AS 'co_fk_cop__change_order_priority_id',
		co_fk_cop.`change_order_priority` AS 'co_fk_cop__change_order_priority',
		co_fk_cop.`disabled_flag` AS 'co_fk_cop__disabled_flag',

		co_fk_fmfiles.`id` AS 'co_fk_fmfiles__file_manager_file_id',
		co_fk_fmfiles.`user_company_id` AS 'co_fk_fmfiles__user_company_id',
		co_fk_fmfiles.`contact_id` AS 'co_fk_fmfiles__contact_id',
		co_fk_fmfiles.`project_id` AS 'co_fk_fmfiles__project_id',
		co_fk_fmfiles.`file_manager_folder_id` AS 'co_fk_fmfiles__file_manager_folder_id',
		co_fk_fmfiles.`file_location_id` AS 'co_fk_fmfiles__file_location_id',
		co_fk_fmfiles.`virtual_file_name` AS 'co_fk_fmfiles__virtual_file_name',
		co_fk_fmfiles.`version_number` AS 'co_fk_fmfiles__version_number',
		co_fk_fmfiles.`virtual_file_name_sha1` AS 'co_fk_fmfiles__virtual_file_name_sha1',
		co_fk_fmfiles.`virtual_file_mime_type` AS 'co_fk_fmfiles__virtual_file_mime_type',
		co_fk_fmfiles.`modified` AS 'co_fk_fmfiles__modified',
		co_fk_fmfiles.`created` AS 'co_fk_fmfiles__created',
		co_fk_fmfiles.`deleted_flag` AS 'co_fk_fmfiles__deleted_flag',
		co_fk_fmfiles.`directly_deleted_flag` AS 'co_fk_fmfiles__directly_deleted_flag',

		co_fk_codes.`id` AS 'co_fk_codes__cost_code_id',
		co_fk_codes.`cost_code_division_id` AS 'co_fk_codes__cost_code_division_id',
		co_fk_codes.`cost_code` AS 'co_fk_codes__cost_code',
		co_fk_codes.`cost_code_description` AS 'co_fk_codes__cost_code_description',
		co_fk_codes.`cost_code_description_abbreviation` AS 'co_fk_codes__cost_code_description_abbreviation',
		co_fk_codes.`sort_order` AS 'co_fk_codes__sort_order',
		co_fk_codes.`disabled_flag` AS 'co_fk_codes__disabled_flag',

		co_fk_creator_c.`id` AS 'co_fk_creator_c__contact_id',
		co_fk_creator_c.`user_company_id` AS 'co_fk_creator_c__user_company_id',
		co_fk_creator_c.`user_id` AS 'co_fk_creator_c__user_id',
		co_fk_creator_c.`contact_company_id` AS 'co_fk_creator_c__contact_company_id',
		co_fk_creator_c.`email` AS 'co_fk_creator_c__email',
		co_fk_creator_c.`name_prefix` AS 'co_fk_creator_c__name_prefix',
		co_fk_creator_c.`first_name` AS 'co_fk_creator_c__first_name',
		co_fk_creator_c.`additional_name` AS 'co_fk_creator_c__additional_name',
		co_fk_creator_c.`middle_name` AS 'co_fk_creator_c__middle_name',
		co_fk_creator_c.`last_name` AS 'co_fk_creator_c__last_name',
		co_fk_creator_c.`name_suffix` AS 'co_fk_creator_c__name_suffix',
		co_fk_creator_c.`title` AS 'co_fk_creator_c__title',
		co_fk_creator_c.`vendor_flag` AS 'co_fk_creator_c__vendor_flag',

		co_fk_creator_cco.`id` AS 'co_fk_creator_cco__contact_company_office_id',
		co_fk_creator_cco.`contact_company_id` AS 'co_fk_creator_cco__contact_company_id',
		co_fk_creator_cco.`office_nickname` AS 'co_fk_creator_cco__office_nickname',
		co_fk_creator_cco.`address_line_1` AS 'co_fk_creator_cco__address_line_1',
		co_fk_creator_cco.`address_line_2` AS 'co_fk_creator_cco__address_line_2',
		co_fk_creator_cco.`address_line_3` AS 'co_fk_creator_cco__address_line_3',
		co_fk_creator_cco.`address_line_4` AS 'co_fk_creator_cco__address_line_4',
		co_fk_creator_cco.`address_city` AS 'co_fk_creator_cco__address_city',
		co_fk_creator_cco.`address_county` AS 'co_fk_creator_cco__address_county',
		co_fk_creator_cco.`address_state_or_region` AS 'co_fk_creator_cco__address_state_or_region',
		co_fk_creator_cco.`address_postal_code` AS 'co_fk_creator_cco__address_postal_code',
		co_fk_creator_cco.`address_postal_code_extension` AS 'co_fk_creator_cco__address_postal_code_extension',
		co_fk_creator_cco.`address_country` AS 'co_fk_creator_cco__address_country',
		co_fk_creator_cco.`head_quarters_flag` AS 'co_fk_creator_cco__head_quarters_flag',
		co_fk_creator_cco.`address_validated_by_user_flag` AS 'co_fk_creator_cco__address_validated_by_user_flag',
		co_fk_creator_cco.`address_validated_by_web_service_flag` AS 'co_fk_creator_cco__address_validated_by_web_service_flag',
		co_fk_creator_cco.`address_validation_by_web_service_error_flag` AS 'co_fk_creator_cco__address_validation_by_web_service_error_flag',

		co_fk_creator_phone_ccopn.`id` AS 'co_fk_creator_phone_ccopn__contact_company_office_phone_number_id',
		co_fk_creator_phone_ccopn.`contact_company_office_id` AS 'co_fk_creator_phone_ccopn__contact_company_office_id',
		co_fk_creator_phone_ccopn.`phone_number_type_id` AS 'co_fk_creator_phone_ccopn__phone_number_type_id',
		co_fk_creator_phone_ccopn.`country_code` AS 'co_fk_creator_phone_ccopn__country_code',
		co_fk_creator_phone_ccopn.`area_code` AS 'co_fk_creator_phone_ccopn__area_code',
		co_fk_creator_phone_ccopn.`prefix` AS 'co_fk_creator_phone_ccopn__prefix',
		co_fk_creator_phone_ccopn.`number` AS 'co_fk_creator_phone_ccopn__number',
		co_fk_creator_phone_ccopn.`extension` AS 'co_fk_creator_phone_ccopn__extension',
		co_fk_creator_phone_ccopn.`itu` AS 'co_fk_creator_phone_ccopn__itu',

		co_fk_creator_fax_ccopn.`id` AS 'co_fk_creator_fax_ccopn__contact_company_office_phone_number_id',
		co_fk_creator_fax_ccopn.`contact_company_office_id` AS 'co_fk_creator_fax_ccopn__contact_company_office_id',
		co_fk_creator_fax_ccopn.`phone_number_type_id` AS 'co_fk_creator_fax_ccopn__phone_number_type_id',
		co_fk_creator_fax_ccopn.`country_code` AS 'co_fk_creator_fax_ccopn__country_code',
		co_fk_creator_fax_ccopn.`area_code` AS 'co_fk_creator_fax_ccopn__area_code',
		co_fk_creator_fax_ccopn.`prefix` AS 'co_fk_creator_fax_ccopn__prefix',
		co_fk_creator_fax_ccopn.`number` AS 'co_fk_creator_fax_ccopn__number',
		co_fk_creator_fax_ccopn.`extension` AS 'co_fk_creator_fax_ccopn__extension',
		co_fk_creator_fax_ccopn.`itu` AS 'co_fk_creator_fax_ccopn__itu',

		co_fk_creator_c_mobile_cpn.`id` AS 'co_fk_creator_c_mobile_cpn__contact_phone_number_id',
		co_fk_creator_c_mobile_cpn.`contact_id` AS 'co_fk_creator_c_mobile_cpn__contact_id',
		co_fk_creator_c_mobile_cpn.`phone_number_type_id` AS 'co_fk_creator_c_mobile_cpn__phone_number_type_id',
		co_fk_creator_c_mobile_cpn.`country_code` AS 'co_fk_creator_c_mobile_cpn__country_code',
		co_fk_creator_c_mobile_cpn.`area_code` AS 'co_fk_creator_c_mobile_cpn__area_code',
		co_fk_creator_c_mobile_cpn.`prefix` AS 'co_fk_creator_c_mobile_cpn__prefix',
		co_fk_creator_c_mobile_cpn.`number` AS 'co_fk_creator_c_mobile_cpn__number',
		co_fk_creator_c_mobile_cpn.`extension` AS 'co_fk_creator_c_mobile_cpn__extension',
		co_fk_creator_c_mobile_cpn.`itu` AS 'co_fk_creator_c_mobile_cpn__itu',

		co_fk_recipient_c.`id` AS 'co_fk_recipient_c__contact_id',
		co_fk_recipient_c.`user_company_id` AS 'co_fk_recipient_c__user_company_id',
		co_fk_recipient_c.`user_id` AS 'co_fk_recipient_c__user_id',
		co_fk_recipient_c.`contact_company_id` AS 'co_fk_recipient_c__contact_company_id',
		co_fk_recipient_c.`email` AS 'co_fk_recipient_c__email',
		co_fk_recipient_c.`name_prefix` AS 'co_fk_recipient_c__name_prefix',
		co_fk_recipient_c.`first_name` AS 'co_fk_recipient_c__first_name',
		co_fk_recipient_c.`additional_name` AS 'co_fk_recipient_c__additional_name',
		co_fk_recipient_c.`middle_name` AS 'co_fk_recipient_c__middle_name',
		co_fk_recipient_c.`last_name` AS 'co_fk_recipient_c__last_name',
		co_fk_recipient_c.`name_suffix` AS 'co_fk_recipient_c__name_suffix',
		co_fk_recipient_c.`title` AS 'co_fk_recipient_c__title',
		co_fk_recipient_c.`vendor_flag` AS 'co_fk_recipient_c__vendor_flag',

		co_fk_recipient_cco.`id` AS 'co_fk_recipient_cco__contact_company_office_id',
		co_fk_recipient_cco.`contact_company_id` AS 'co_fk_recipient_cco__contact_company_id',
		co_fk_recipient_cco.`office_nickname` AS 'co_fk_recipient_cco__office_nickname',
		co_fk_recipient_cco.`address_line_1` AS 'co_fk_recipient_cco__address_line_1',
		co_fk_recipient_cco.`address_line_2` AS 'co_fk_recipient_cco__address_line_2',
		co_fk_recipient_cco.`address_line_3` AS 'co_fk_recipient_cco__address_line_3',
		co_fk_recipient_cco.`address_line_4` AS 'co_fk_recipient_cco__address_line_4',
		co_fk_recipient_cco.`address_city` AS 'co_fk_recipient_cco__address_city',
		co_fk_recipient_cco.`address_county` AS 'co_fk_recipient_cco__address_county',
		co_fk_recipient_cco.`address_state_or_region` AS 'co_fk_recipient_cco__address_state_or_region',
		co_fk_recipient_cco.`address_postal_code` AS 'co_fk_recipient_cco__address_postal_code',
		co_fk_recipient_cco.`address_postal_code_extension` AS 'co_fk_recipient_cco__address_postal_code_extension',
		co_fk_recipient_cco.`address_country` AS 'co_fk_recipient_cco__address_country',
		co_fk_recipient_cco.`head_quarters_flag` AS 'co_fk_recipient_cco__head_quarters_flag',
		co_fk_recipient_cco.`address_validated_by_user_flag` AS 'co_fk_recipient_cco__address_validated_by_user_flag',
		co_fk_recipient_cco.`address_validated_by_web_service_flag` AS 'co_fk_recipient_cco__address_validated_by_web_service_flag',
		co_fk_recipient_cco.`address_validation_by_web_service_error_flag` AS 'co_fk_recipient_cco__address_validation_by_web_service_error_flag',

		co_fk_recipient_phone_ccopn.`id` AS 'co_fk_recipient_phone_ccopn__contact_company_office_phone_number_id',
		co_fk_recipient_phone_ccopn.`contact_company_office_id` AS 'co_fk_recipient_phone_ccopn__contact_company_office_id',
		co_fk_recipient_phone_ccopn.`phone_number_type_id` AS 'co_fk_recipient_phone_ccopn__phone_number_type_id',
		co_fk_recipient_phone_ccopn.`country_code` AS 'co_fk_recipient_phone_ccopn__country_code',
		co_fk_recipient_phone_ccopn.`area_code` AS 'co_fk_recipient_phone_ccopn__area_code',
		co_fk_recipient_phone_ccopn.`prefix` AS 'co_fk_recipient_phone_ccopn__prefix',
		co_fk_recipient_phone_ccopn.`number` AS 'co_fk_recipient_phone_ccopn__number',
		co_fk_recipient_phone_ccopn.`extension` AS 'co_fk_recipient_phone_ccopn__extension',
		co_fk_recipient_phone_ccopn.`itu` AS 'co_fk_recipient_phone_ccopn__itu',

		co_fk_recipient_fax_ccopn.`id` AS 'co_fk_recipient_fax_ccopn__contact_company_office_phone_number_id',
		co_fk_recipient_fax_ccopn.`contact_company_office_id` AS 'co_fk_recipient_fax_ccopn__contact_company_office_id',
		co_fk_recipient_fax_ccopn.`phone_number_type_id` AS 'co_fk_recipient_fax_ccopn__phone_number_type_id',
		co_fk_recipient_fax_ccopn.`country_code` AS 'co_fk_recipient_fax_ccopn__country_code',
		co_fk_recipient_fax_ccopn.`area_code` AS 'co_fk_recipient_fax_ccopn__area_code',
		co_fk_recipient_fax_ccopn.`prefix` AS 'co_fk_recipient_fax_ccopn__prefix',
		co_fk_recipient_fax_ccopn.`number` AS 'co_fk_recipient_fax_ccopn__number',
		co_fk_recipient_fax_ccopn.`extension` AS 'co_fk_recipient_fax_ccopn__extension',
		co_fk_recipient_fax_ccopn.`itu` AS 'co_fk_recipient_fax_ccopn__itu',

		co_fk_recipient_c_mobile_cpn.`id` AS 'co_fk_recipient_c_mobile_cpn__contact_phone_number_id',
		co_fk_recipient_c_mobile_cpn.`contact_id` AS 'co_fk_recipient_c_mobile_cpn__contact_id',
		co_fk_recipient_c_mobile_cpn.`phone_number_type_id` AS 'co_fk_recipient_c_mobile_cpn__phone_number_type_id',
		co_fk_recipient_c_mobile_cpn.`country_code` AS 'co_fk_recipient_c_mobile_cpn__country_code',
		co_fk_recipient_c_mobile_cpn.`area_code` AS 'co_fk_recipient_c_mobile_cpn__area_code',
		co_fk_recipient_c_mobile_cpn.`prefix` AS 'co_fk_recipient_c_mobile_cpn__prefix',
		co_fk_recipient_c_mobile_cpn.`number` AS 'co_fk_recipient_c_mobile_cpn__number',
		co_fk_recipient_c_mobile_cpn.`extension` AS 'co_fk_recipient_c_mobile_cpn__extension',
		co_fk_recipient_c_mobile_cpn.`itu` AS 'co_fk_recipient_c_mobile_cpn__itu',

		co_fk_initiator_c.`id` AS 'co_fk_initiator_c__contact_id',
		co_fk_initiator_c.`user_company_id` AS 'co_fk_initiator_c__user_company_id',
		co_fk_initiator_c.`user_id` AS 'co_fk_initiator_c__user_id',
		co_fk_initiator_c.`contact_company_id` AS 'co_fk_initiator_c__contact_company_id',
		co_fk_initiator_c.`email` AS 'co_fk_initiator_c__email',
		co_fk_initiator_c.`name_prefix` AS 'co_fk_initiator_c__name_prefix',
		co_fk_initiator_c.`first_name` AS 'co_fk_initiator_c__first_name',
		co_fk_initiator_c.`additional_name` AS 'co_fk_initiator_c__additional_name',
		co_fk_initiator_c.`middle_name` AS 'co_fk_initiator_c__middle_name',
		co_fk_initiator_c.`last_name` AS 'co_fk_initiator_c__last_name',
		co_fk_initiator_c.`name_suffix` AS 'co_fk_initiator_c__name_suffix',
		co_fk_initiator_c.`title` AS 'co_fk_initiator_c__title',
		co_fk_initiator_c.`vendor_flag` AS 'co_fk_initiator_c__vendor_flag',

		co_fk_initiator_cco.`id` AS 'co_fk_initiator_cco__contact_company_office_id',
		co_fk_initiator_cco.`contact_company_id` AS 'co_fk_initiator_cco__contact_company_id',
		co_fk_initiator_cco.`office_nickname` AS 'co_fk_initiator_cco__office_nickname',
		co_fk_initiator_cco.`address_line_1` AS 'co_fk_initiator_cco__address_line_1',
		co_fk_initiator_cco.`address_line_2` AS 'co_fk_initiator_cco__address_line_2',
		co_fk_initiator_cco.`address_line_3` AS 'co_fk_initiator_cco__address_line_3',
		co_fk_initiator_cco.`address_line_4` AS 'co_fk_initiator_cco__address_line_4',
		co_fk_initiator_cco.`address_city` AS 'co_fk_initiator_cco__address_city',
		co_fk_initiator_cco.`address_county` AS 'co_fk_initiator_cco__address_county',
		co_fk_initiator_cco.`address_state_or_region` AS 'co_fk_initiator_cco__address_state_or_region',
		co_fk_initiator_cco.`address_postal_code` AS 'co_fk_initiator_cco__address_postal_code',
		co_fk_initiator_cco.`address_postal_code_extension` AS 'co_fk_initiator_cco__address_postal_code_extension',
		co_fk_initiator_cco.`address_country` AS 'co_fk_initiator_cco__address_country',
		co_fk_initiator_cco.`head_quarters_flag` AS 'co_fk_initiator_cco__head_quarters_flag',
		co_fk_initiator_cco.`address_validated_by_user_flag` AS 'co_fk_initiator_cco__address_validated_by_user_flag',
		co_fk_initiator_cco.`address_validated_by_web_service_flag` AS 'co_fk_initiator_cco__address_validated_by_web_service_flag',
		co_fk_initiator_cco.`address_validation_by_web_service_error_flag` AS 'co_fk_initiator_cco__address_validation_by_web_service_error_flag',

		co_fk_initiator_phone_ccopn.`id` AS 'co_fk_initiator_phone_ccopn__contact_company_office_phone_number_id',
		co_fk_initiator_phone_ccopn.`contact_company_office_id` AS 'co_fk_initiator_phone_ccopn__contact_company_office_id',
		co_fk_initiator_phone_ccopn.`phone_number_type_id` AS 'co_fk_initiator_phone_ccopn__phone_number_type_id',
		co_fk_initiator_phone_ccopn.`country_code` AS 'co_fk_initiator_phone_ccopn__country_code',
		co_fk_initiator_phone_ccopn.`area_code` AS 'co_fk_initiator_phone_ccopn__area_code',
		co_fk_initiator_phone_ccopn.`prefix` AS 'co_fk_initiator_phone_ccopn__prefix',
		co_fk_initiator_phone_ccopn.`number` AS 'co_fk_initiator_phone_ccopn__number',
		co_fk_initiator_phone_ccopn.`extension` AS 'co_fk_initiator_phone_ccopn__extension',
		co_fk_initiator_phone_ccopn.`itu` AS 'co_fk_initiator_phone_ccopn__itu',

		co_fk_initiator_fax_ccopn.`id` AS 'co_fk_initiator_fax_ccopn__contact_company_office_phone_number_id',
		co_fk_initiator_fax_ccopn.`contact_company_office_id` AS 'co_fk_initiator_fax_ccopn__contact_company_office_id',
		co_fk_initiator_fax_ccopn.`phone_number_type_id` AS 'co_fk_initiator_fax_ccopn__phone_number_type_id',
		co_fk_initiator_fax_ccopn.`country_code` AS 'co_fk_initiator_fax_ccopn__country_code',
		co_fk_initiator_fax_ccopn.`area_code` AS 'co_fk_initiator_fax_ccopn__area_code',
		co_fk_initiator_fax_ccopn.`prefix` AS 'co_fk_initiator_fax_ccopn__prefix',
		co_fk_initiator_fax_ccopn.`number` AS 'co_fk_initiator_fax_ccopn__number',
		co_fk_initiator_fax_ccopn.`extension` AS 'co_fk_initiator_fax_ccopn__extension',
		co_fk_initiator_fax_ccopn.`itu` AS 'co_fk_initiator_fax_ccopn__itu',

		co_fk_initiator_c_mobile_cpn.`id` AS 'co_fk_initiator_c_mobile_cpn__contact_phone_number_id',
		co_fk_initiator_c_mobile_cpn.`contact_id` AS 'co_fk_initiator_c_mobile_cpn__contact_id',
		co_fk_initiator_c_mobile_cpn.`phone_number_type_id` AS 'co_fk_initiator_c_mobile_cpn__phone_number_type_id',
		co_fk_initiator_c_mobile_cpn.`country_code` AS 'co_fk_initiator_c_mobile_cpn__country_code',
		co_fk_initiator_c_mobile_cpn.`area_code` AS 'co_fk_initiator_c_mobile_cpn__area_code',
		co_fk_initiator_c_mobile_cpn.`prefix` AS 'co_fk_initiator_c_mobile_cpn__prefix',
		co_fk_initiator_c_mobile_cpn.`number` AS 'co_fk_initiator_c_mobile_cpn__number',
		co_fk_initiator_c_mobile_cpn.`extension` AS 'co_fk_initiator_c_mobile_cpn__extension',
		co_fk_initiator_c_mobile_cpn.`itu` AS 'co_fk_initiator_c_mobile_cpn__itu',

		co.* $selSort

		FROM `change_orders` co
		INNER JOIN `projects` co_fk_p ON co.`project_id` = co_fk_p.`id`
		INNER JOIN `change_order_types` co_fk_cot ON co.`change_order_type_id` = co_fk_cot.`id`
		INNER JOIN `change_order_statuses` co_fk_cos ON co.`change_order_status_id` = co_fk_cos.`id`
		LEFT OUTER JOIN `change_order_priorities` co_fk_cop ON co.`change_order_priority_id` = co_fk_cop.`id`
		LEFT OUTER JOIN `file_manager_files` co_fk_fmfiles ON co.`co_file_manager_file_id` = co_fk_fmfiles.`id`
		LEFT OUTER JOIN `cost_codes` co_fk_codes ON co.`co_cost_code_id` = co_fk_codes.`id`
		INNER JOIN `contacts` co_fk_creator_c ON co.`co_creator_contact_id` = co_fk_creator_c.`id`
		LEFT OUTER JOIN `contact_company_offices` co_fk_creator_cco ON co.`co_creator_contact_company_office_id` = co_fk_creator_cco.`id`
		LEFT OUTER JOIN `contact_company_office_phone_numbers` co_fk_creator_phone_ccopn ON co.`co_creator_phone_contact_company_office_phone_number_id` = co_fk_creator_phone_ccopn.`id`
		LEFT OUTER JOIN `contact_company_office_phone_numbers` co_fk_creator_fax_ccopn ON co.`co_creator_fax_contact_company_office_phone_number_id` = co_fk_creator_fax_ccopn.`id`
		LEFT OUTER JOIN `contact_phone_numbers` co_fk_creator_c_mobile_cpn ON co.`co_creator_contact_mobile_phone_number_id` = co_fk_creator_c_mobile_cpn.`id`
		LEFT OUTER JOIN `contacts` co_fk_recipient_c ON co.`co_recipient_contact_id` = co_fk_recipient_c.`id`
		LEFT OUTER JOIN `contact_company_offices` co_fk_recipient_cco ON co.`co_recipient_contact_company_office_id` = co_fk_recipient_cco.`id`
		LEFT OUTER JOIN `contact_company_office_phone_numbers` co_fk_recipient_phone_ccopn ON co.`co_recipient_phone_contact_company_office_phone_number_id` = co_fk_recipient_phone_ccopn.`id`
		LEFT OUTER JOIN `contact_company_office_phone_numbers` co_fk_recipient_fax_ccopn ON co.`co_recipient_fax_contact_company_office_phone_number_id` = co_fk_recipient_fax_ccopn.`id`
		LEFT OUTER JOIN `contact_phone_numbers` co_fk_recipient_c_mobile_cpn ON co.`co_recipient_contact_mobile_phone_number_id` = co_fk_recipient_c_mobile_cpn.`id`
		LEFT OUTER JOIN `contacts` co_fk_initiator_c ON co.`co_initiator_contact_id` = co_fk_initiator_c.`id`
		LEFT OUTER JOIN `contact_company_offices` co_fk_initiator_cco ON co.`co_initiator_contact_company_office_id` = co_fk_initiator_cco.`id`
		LEFT OUTER JOIN `contact_company_office_phone_numbers` co_fk_initiator_phone_ccopn ON co.`co_initiator_phone_contact_company_office_phone_number_id` = co_fk_initiator_phone_ccopn.`id`
		LEFT OUTER JOIN `contact_company_office_phone_numbers` co_fk_initiator_fax_ccopn ON co.`co_initiator_fax_contact_company_office_phone_number_id` = co_fk_initiator_fax_ccopn.`id`
		LEFT OUTER JOIN `contact_phone_numbers` co_fk_initiator_c_mobile_cpn ON co.`co_initiator_contact_mobile_phone_number_id` = co_fk_initiator_c_mobile_cpn.`id`
		WHERE co.`project_id` = ? $whereStatusIn $whereStatus {$sqlFilter}{$sqlOrderBy}{$sqlLimit}
		";
		
			$arrValues = array($project_id);
			$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

			$arrChangeOrdersByProjectId = array();
			while ($row = $db->fetch()) {
				$change_order_id = $row['id'];
				$changeOrder = self::instantiateOrm($database, 'ChangeOrder', $row, null, $change_order_id);
				/* @var $changeOrder ChangeOrder */
				$changeOrder->convertPropertiesToData();

				if (isset($row['project_id'])) {
					$project_id = $row['project_id'];
					$row['co_fk_p__id'] = $project_id;
					$project = self::instantiateOrm($database, 'Project', $row, null, $project_id, 'co_fk_p__');
					/* @var $project Project */
					$project->convertPropertiesToData();
				} else {
					$project = false;
				}
				$changeOrder->setProject($project);

				if (isset($row['change_order_type_id'])) {
					$change_order_type_id = $row['change_order_type_id'];
					$row['co_fk_cot__id'] = $change_order_type_id;
					$changeOrderType = self::instantiateOrm($database, 'ChangeOrderType', $row, null, $change_order_type_id, 'co_fk_cot__');
					/* @var $changeOrderType ChangeOrderType */
					$changeOrderType->convertPropertiesToData();
				} else {
					$changeOrderType = false;
				}
				$changeOrder->setChangeOrderType($changeOrderType);

				if (isset($row['change_order_status_id'])) {
					$change_order_status_id = $row['change_order_status_id'];
					$row['co_fk_cos__id'] = $change_order_status_id;
					$changeOrderStatus = self::instantiateOrm($database, 'ChangeOrderStatus', $row, null, $change_order_status_id, 'co_fk_cos__');
					/* @var $changeOrderStatus ChangeOrderStatus */
					$changeOrderStatus->convertPropertiesToData();
				} else {
					$changeOrderStatus = false;
				}
				$changeOrder->setChangeOrderStatus($changeOrderStatus);

				if (isset($row['change_order_priority_id'])) {
					$change_order_priority_id = $row['change_order_priority_id'];
					$row['co_fk_cop__id'] = $change_order_priority_id;
					$changeOrderPriority = self::instantiateOrm($database, 'ChangeOrderPriority', $row, null, $change_order_priority_id, 'co_fk_cop__');
					/* @var $changeOrderPriority ChangeOrderPriority */
					$changeOrderPriority->convertPropertiesToData();
				} else {
					$changeOrderPriority = false;
				}
				$changeOrder->setChangeOrderPriority($changeOrderPriority);

				if (isset($row['co_file_manager_file_id'])) {
					$co_file_manager_file_id = $row['co_file_manager_file_id'];
					$row['co_fk_fmfiles__id'] = $co_file_manager_file_id;
					$coFileManagerFile = self::instantiateOrm($database, 'FileManagerFile', $row, null, $co_file_manager_file_id, 'co_fk_fmfiles__');
					/* @var $coFileManagerFile FileManagerFile */
					$coFileManagerFile->convertPropertiesToData();
				} else {
					$coFileManagerFile = false;
				}
				$changeOrder->setCoFileManagerFile($coFileManagerFile);

				if (isset($row['co_cost_code_id'])) {
					$co_cost_code_id = $row['co_cost_code_id'];
					$row['co_fk_codes__id'] = $co_cost_code_id;
					$coCostCode = self::instantiateOrm($database, 'CostCode', $row, null, $co_cost_code_id, 'co_fk_codes__');
					/* @var $coCostCode CostCode */
					$coCostCode->convertPropertiesToData();
				} else {
					$coCostCode = false;
				}
				$changeOrder->setCoCostCode($coCostCode);

				if (isset($row['co_creator_contact_id'])) {
					$co_creator_contact_id = $row['co_creator_contact_id'];
					$row['co_fk_creator_c__id'] = $co_creator_contact_id;
					$coCreatorContact = self::instantiateOrm($database, 'Contact', $row, null, $co_creator_contact_id, 'co_fk_creator_c__');
					/* @var $coCreatorContact Contact */
					$coCreatorContact->convertPropertiesToData();
				} else {
					$coCreatorContact = false;
				}
				$changeOrder->setCoCreatorContact($coCreatorContact);

				if (isset($row['co_creator_contact_company_office_id'])) {
					$co_creator_contact_company_office_id = $row['co_creator_contact_company_office_id'];
					$row['co_fk_creator_cco__id'] = $co_creator_contact_company_office_id;
					$coCreatorContactCompanyOffice = self::instantiateOrm($database, 'ContactCompanyOffice', $row, null, $co_creator_contact_company_office_id, 'co_fk_creator_cco__');
					/* @var $coCreatorContactCompanyOffice ContactCompanyOffice */
					$coCreatorContactCompanyOffice->convertPropertiesToData();
				} else {
					$coCreatorContactCompanyOffice = false;
				}
				$changeOrder->setCoCreatorContactCompanyOffice($coCreatorContactCompanyOffice);

				if (isset($row['co_creator_phone_contact_company_office_phone_number_id'])) {
					$co_creator_phone_contact_company_office_phone_number_id = $row['co_creator_phone_contact_company_office_phone_number_id'];
					$row['co_fk_creator_phone_ccopn__id'] = $co_creator_phone_contact_company_office_phone_number_id;
					$coCreatorPhoneContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $co_creator_phone_contact_company_office_phone_number_id, 'co_fk_creator_phone_ccopn__');
					/* @var $coCreatorPhoneContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
					$coCreatorPhoneContactCompanyOfficePhoneNumber->convertPropertiesToData();
				} else {
					$coCreatorPhoneContactCompanyOfficePhoneNumber = false;
				}
				$changeOrder->setCoCreatorPhoneContactCompanyOfficePhoneNumber($coCreatorPhoneContactCompanyOfficePhoneNumber);

				if (isset($row['co_creator_fax_contact_company_office_phone_number_id'])) {
					$co_creator_fax_contact_company_office_phone_number_id = $row['co_creator_fax_contact_company_office_phone_number_id'];
					$row['co_fk_creator_fax_ccopn__id'] = $co_creator_fax_contact_company_office_phone_number_id;
					$coCreatorFaxContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $co_creator_fax_contact_company_office_phone_number_id, 'co_fk_creator_fax_ccopn__');
					/* @var $coCreatorFaxContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
					$coCreatorFaxContactCompanyOfficePhoneNumber->convertPropertiesToData();
				} else {
					$coCreatorFaxContactCompanyOfficePhoneNumber = false;
				}
				$changeOrder->setCoCreatorFaxContactCompanyOfficePhoneNumber($coCreatorFaxContactCompanyOfficePhoneNumber);

				if (isset($row['co_creator_contact_mobile_phone_number_id'])) {
					$co_creator_contact_mobile_phone_number_id = $row['co_creator_contact_mobile_phone_number_id'];
					$row['co_fk_creator_c_mobile_cpn__id'] = $co_creator_contact_mobile_phone_number_id;
					$coCreatorContactMobilePhoneNumber = self::instantiateOrm($database, 'ContactPhoneNumber', $row, null, $co_creator_contact_mobile_phone_number_id, 'co_fk_creator_c_mobile_cpn__');
					/* @var $coCreatorContactMobilePhoneNumber ContactPhoneNumber */
					$coCreatorContactMobilePhoneNumber->convertPropertiesToData();
				} else {
					$coCreatorContactMobilePhoneNumber = false;
				}
				$changeOrder->setCoCreatorContactMobilePhoneNumber($coCreatorContactMobilePhoneNumber);

				if (isset($row['co_recipient_contact_id'])) {
					$co_recipient_contact_id = $row['co_recipient_contact_id'];
					$row['co_fk_recipient_c__id'] = $co_recipient_contact_id;
					$coRecipientContact = self::instantiateOrm($database, 'Contact', $row, null, $co_recipient_contact_id, 'co_fk_recipient_c__');
					/* @var $coRecipientContact Contact */
					$coRecipientContact->convertPropertiesToData();
				} else {
					$coRecipientContact = false;
				}
				$changeOrder->setCoRecipientContact($coRecipientContact);

				if (isset($row['co_recipient_contact_company_office_id'])) {
					$co_recipient_contact_company_office_id = $row['co_recipient_contact_company_office_id'];
					$row['co_fk_recipient_cco__id'] = $co_recipient_contact_company_office_id;
					$coRecipientContactCompanyOffice = self::instantiateOrm($database, 'ContactCompanyOffice', $row, null, $co_recipient_contact_company_office_id, 'co_fk_recipient_cco__');
					/* @var $coRecipientContactCompanyOffice ContactCompanyOffice */
					$coRecipientContactCompanyOffice->convertPropertiesToData();
				} else {
					$coRecipientContactCompanyOffice = false;
				}
				$changeOrder->setCoRecipientContactCompanyOffice($coRecipientContactCompanyOffice);

				if (isset($row['co_recipient_phone_contact_company_office_phone_number_id'])) {
					$co_recipient_phone_contact_company_office_phone_number_id = $row['co_recipient_phone_contact_company_office_phone_number_id'];
					$row['co_fk_recipient_phone_ccopn__id'] = $co_recipient_phone_contact_company_office_phone_number_id;
					$coRecipientPhoneContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $co_recipient_phone_contact_company_office_phone_number_id, 'co_fk_recipient_phone_ccopn__');
					/* @var $coRecipientPhoneContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
					$coRecipientPhoneContactCompanyOfficePhoneNumber->convertPropertiesToData();
				} else {
					$coRecipientPhoneContactCompanyOfficePhoneNumber = false;
				}
				$changeOrder->setCoRecipientPhoneContactCompanyOfficePhoneNumber($coRecipientPhoneContactCompanyOfficePhoneNumber);

				if (isset($row['co_recipient_fax_contact_company_office_phone_number_id'])) {
					$co_recipient_fax_contact_company_office_phone_number_id = $row['co_recipient_fax_contact_company_office_phone_number_id'];
					$row['co_fk_recipient_fax_ccopn__id'] = $co_recipient_fax_contact_company_office_phone_number_id;
					$coRecipientFaxContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $co_recipient_fax_contact_company_office_phone_number_id, 'co_fk_recipient_fax_ccopn__');
					/* @var $coRecipientFaxContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
					$coRecipientFaxContactCompanyOfficePhoneNumber->convertPropertiesToData();
				} else {
					$coRecipientFaxContactCompanyOfficePhoneNumber = false;
				}
				$changeOrder->setCoRecipientFaxContactCompanyOfficePhoneNumber($coRecipientFaxContactCompanyOfficePhoneNumber);

				if (isset($row['co_recipient_contact_mobile_phone_number_id'])) {
					$co_recipient_contact_mobile_phone_number_id = $row['co_recipient_contact_mobile_phone_number_id'];
					$row['co_fk_recipient_c_mobile_cpn__id'] = $co_recipient_contact_mobile_phone_number_id;
					$coRecipientContactMobilePhoneNumber = self::instantiateOrm($database, 'ContactPhoneNumber', $row, null, $co_recipient_contact_mobile_phone_number_id, 'co_fk_recipient_c_mobile_cpn__');
					/* @var $coRecipientContactMobilePhoneNumber ContactPhoneNumber */
					$coRecipientContactMobilePhoneNumber->convertPropertiesToData();
				} else {
					$coRecipientContactMobilePhoneNumber = false;
				}
				$changeOrder->setCoRecipientContactMobilePhoneNumber($coRecipientContactMobilePhoneNumber);

				if (isset($row['co_initiator_contact_id'])) {
					$co_initiator_contact_id = $row['co_initiator_contact_id'];
					$row['co_fk_initiator_c__id'] = $co_initiator_contact_id;
					$coInitiatorContact = self::instantiateOrm($database, 'Contact', $row, null, $co_initiator_contact_id, 'co_fk_initiator_c__');
					/* @var $coInitiatorContact Contact */
					$coInitiatorContact->convertPropertiesToData();
				} else {
					$coInitiatorContact = false;
				}
				$changeOrder->setCoInitiatorContact($coInitiatorContact);

				if (isset($row['co_initiator_contact_company_office_id'])) {
					$co_initiator_contact_company_office_id = $row['co_initiator_contact_company_office_id'];
					$row['co_fk_initiator_cco__id'] = $co_initiator_contact_company_office_id;
					$coInitiatorContactCompanyOffice = self::instantiateOrm($database, 'ContactCompanyOffice', $row, null, $co_initiator_contact_company_office_id, 'co_fk_initiator_cco__');
					/* @var $coInitiatorContactCompanyOffice ContactCompanyOffice */
					$coInitiatorContactCompanyOffice->convertPropertiesToData();
				} else {
					$coInitiatorContactCompanyOffice = false;
				}
				$changeOrder->setCoInitiatorContactCompanyOffice($coInitiatorContactCompanyOffice);

				if (isset($row['co_initiator_phone_contact_company_office_phone_number_id'])) {
					$co_initiator_phone_contact_company_office_phone_number_id = $row['co_initiator_phone_contact_company_office_phone_number_id'];
					$row['co_fk_initiator_phone_ccopn__id'] = $co_initiator_phone_contact_company_office_phone_number_id;
					$coInitiatorPhoneContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $co_initiator_phone_contact_company_office_phone_number_id, 'co_fk_initiator_phone_ccopn__');
					/* @var $coInitiatorPhoneContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
					$coInitiatorPhoneContactCompanyOfficePhoneNumber->convertPropertiesToData();
				} else {
					$coInitiatorPhoneContactCompanyOfficePhoneNumber = false;
				}
				$changeOrder->setCoInitiatorPhoneContactCompanyOfficePhoneNumber($coInitiatorPhoneContactCompanyOfficePhoneNumber);

				if (isset($row['co_initiator_fax_contact_company_office_phone_number_id'])) {
					$co_initiator_fax_contact_company_office_phone_number_id = $row['co_initiator_fax_contact_company_office_phone_number_id'];
					$row['co_fk_initiator_fax_ccopn__id'] = $co_initiator_fax_contact_company_office_phone_number_id;
					$coInitiatorFaxContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $co_initiator_fax_contact_company_office_phone_number_id, 'co_fk_initiator_fax_ccopn__');
					/* @var $coInitiatorFaxContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
					$coInitiatorFaxContactCompanyOfficePhoneNumber->convertPropertiesToData();
				} else {
					$coInitiatorFaxContactCompanyOfficePhoneNumber = false;
				}
				$changeOrder->setCoInitiatorFaxContactCompanyOfficePhoneNumber($coInitiatorFaxContactCompanyOfficePhoneNumber);

				if (isset($row['co_initiator_contact_mobile_phone_number_id'])) {
					$co_initiator_contact_mobile_phone_number_id = $row['co_initiator_contact_mobile_phone_number_id'];
					$row['co_fk_initiator_c_mobile_cpn__id'] = $co_initiator_contact_mobile_phone_number_id;
					$coInitiatorContactMobilePhoneNumber = self::instantiateOrm($database, 'ContactPhoneNumber', $row, null, $co_initiator_contact_mobile_phone_number_id, 'co_fk_initiator_c_mobile_cpn__');
					/* @var $coInitiatorContactMobilePhoneNumber ContactPhoneNumber */
					$coInitiatorContactMobilePhoneNumber->convertPropertiesToData();
				} else {
					$coInitiatorContactMobilePhoneNumber = false;
				}
				$changeOrder->setCoInitiatorContactMobilePhoneNumber($coInitiatorContactMobilePhoneNumber);

				$arrChangeOrdersByProjectId[$change_order_id] = $changeOrder;
			}

			$db->free_result();

			self::$_arrChangeOrdersByProjectId = $arrChangeOrdersByProjectId;

			return $arrChangeOrdersByProjectId;
		}

	/**
	 * Load by costcode_id  and project_id for cost anaysis breakdown
	 *
	 * @param string $database
	 * @param int $cost_code_reference_id and $project_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSumOfCostCodeBreakDownByProjectIdAndCostCodeId($database, $costcode_id, $project_id, Input $options=null)
	{
		$forceLoadFlag = false;
		
		$costcode_id = intVal($costcode_id);
		$project_id = intVal($project_id);
		$co_approved_status_id = 2;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$sqlOrderBy = '';

		$query =
"
SELECT 
co.*,
cocb.`id` AS 'cocb_id',
SUM(cocb.`cost`) AS 'cocb_cost'
FROM `change_orders` AS co
INNER JOIN `change_order_cost_break` AS cocb ON cocb.`change_order_id` = co.`id` AND cocb.`cost_code_reference_id` = ?
WHERE co.`project_id` = ?
AND co.`change_order_status_id` = ?
And co.`change_order_type_id` = ?
GROUP BY cocb.`change_order_id`
ORDER BY `id` DESC
";

		$arrValues = array($costcode_id, $project_id, $co_approved_status_id,'2');
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrChangeOrderCostCodeById = array();
		$totalBreakdownAmount = 0;
		$totalCount = 0;
		while ($row = $db->fetch()) {
			$change_order_id = $row['id'];
			$cocb_cost = $row['cocb_cost'];
			$totalBreakdownAmount = $totalBreakdownAmount + floatVal($cocb_cost);
			// $changeOrder = self::instantiateOrm($database, 'ChangeOrder', $row, null, $change_order_id);
			/* @var $changeOrder ChangeOrder */
			$arrChangeOrderCostCodeById[$change_order_id] = $row;
			$totalCount++;
		}

		$db->free_result();

		$arrChangeOrderCostCodeById['totalCount'] = $totalCount;
		$arrChangeOrderCostCodeById['totalBreakdownAmount'] = $totalBreakdownAmount;

		return $arrChangeOrderCostCodeById;
	}

	/**
	 * Load by costcode_id  and project_id for cost anaysis breakdown
	 *
	 * @param string $database
	 * @param int $cost_code_reference_id and $project_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadCostCodeBreakDownByProjectIdAndCostCodeId($database, $costcode_id, $project_id, Input $options=null)
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
			self::$_arrChangeOrderCostCodeById = null;
		}

		$arrChangeOrderCostCodeById = self::$_arrChangeOrderCostCodeById;
		if (isset($arrChangeOrderCostCodeById) && !empty($arrChangeOrderCostCodeById)) {
			return $arrChangeOrderCostCodeById;
		}

		$costcode_id = intVal($costcode_id);
		$project_id = intVal($project_id);
		$co_approved_status_id = 2;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpChangeOrder = new ChangeOrder($database);
			$sqlOrderByColumns = $tmpChangeOrder->constructSqlOrderByColumns($arrOrderByAttributes);

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
co.*,
cocb.`id` AS 'cocb_id',
cocb.`description` AS 'cocb_description',
cocb.`cost` AS 'cocb_cost'
FROM `change_orders` AS co
INNER JOIN `change_order_cost_break` AS cocb ON cocb.`change_order_id` = co.`id` AND cocb.`cost_code_reference_id` = ?
WHERE co.`project_id` = ?
AND co.`change_order_status_id` = ?
AND co.`change_order_type_id`=?
ORDER BY `id` DESC
";

		$arrValues = array($costcode_id, $project_id, $co_approved_status_id,2);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrChangeOrderCostCodeById = array();
		while ($row = $db->fetch()) {
			$change_order_id = $row['id'];
			$costbreakid =$row['cocb_id'];
			// $changeOrder = self::instantiateOrm($database, 'ChangeOrder', $row, null, $change_order_id);
			/* @var $changeOrder ChangeOrder */
			$arrChangeOrderCostCodeById[$costbreakid] = $row;
		}

		$db->free_result();

		self::$_arrChangeOrderCostCodeById = $arrChangeOrderCostCodeById;

		return $arrChangeOrderCostCodeById;
	}
	// To get a reallocation in both draws and change order based on costcode and projectId
	public static function ReallocationInDrawsAndCOByCostCode($database,$costCodeid,$projectId)
	{
		$drawReallocation = DrawItems::costcodeReallocated($database,$costCodeid,$projectId);
		$COReallocationChangeOrder= self::loadSumOfCostCodeBreakDownByProjectIdAndCostCodeId($database, $costCodeid,$projectId);
		$totalReallocation = $drawReallocation['total']+$COReallocationChangeOrder['totalBreakdownAmount'];
		return $totalReallocation;
	}

	// To get the cost code against the cost break down
	public static function getcostBreakCostCodeId($database,$change_order_id)
	{
		$db = DBI::getInstance($database);

		$query ="SELECT * FROM `change_order_cost_break` where change_order_id =? ";

		$arrValues = array($change_order_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$costdata = array();
		while($row = $db->fetch())
		{
			$costdata[] = $row;
		}
		$db->free_result();
		return $costdata;
	}
	// To check oco value is same as draw oco value
	public static function getDrawOverValStatus($database,$project_id,$change_order_id){

		$db = DBI::getInstance($database);

		$query1 = "SELECT di.`id` as draw_item_id FROM `draws` AS dr 
					LEFT JOIN `draw_items` di ON dr.`id`=di.`draw_id` 
					WHERE dr.`project_id` = ?
					AND dr.`is_deleted_flag` = 'N'
					AND di.`change_order_id` = ? 
					ORDER BY dr.`id` DESC LIMIT 1";
		$arrValues1 = array($project_id,$change_order_id);
		$db->execute($query1, $arrValues1, MYSQLI_USE_RESULT);	
		$row1 = $db->fetch();	
		$draw_item_id = $row1['draw_item_id'];
		$db->free_result();		

		$query ="
		SELECT SUM(`current_app`) AS current_app
		FROM `draws` draw
		LEFT JOIN `draw_items` di ON draw.`id`=di.`draw_id` AND draw.`is_deleted_flag` = 'N'
		WHERE draw.`project_id`= ?
		AND `change_order_id` = ?
		AND di.`id`!= ? ";

		$arrValues = array($project_id,$change_order_id,$draw_item_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);	
		$row = $db->fetch();
		$db->free_result();	

		$amount = $row['current_app'];
		if ($amount == '' || $amount == '0.00') {
			$status = 0;
		}else{
			$status = 1;
		}
		return $status;
	}
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

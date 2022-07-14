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
 * RequestForInformation.
 *
 * @category   Framework
 * @package    RequestForInformation
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class RequestForInformation extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'RequestForInformation';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'requests_for_information';

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
	 * unique index `unique_rfi` (`project_id`,`rfi_sequence_number`) comment 'One Project can have many RFIs with a sequence number.'
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_rfi' => array(
			'project_id' => 'int',
			'rfi_sequence_number' => 'int'
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
		'id' => 'request_for_information_id',

		'project_id' => 'project_id',
		'contracting_entity_id' => 'contracting_entity_id',
		'rfi_sequence_number' => 'rfi_sequence_number',

		'request_for_information_type_id' => 'request_for_information_type_id',
		'request_for_information_status_id' => 'request_for_information_status_id',
		'request_for_information_priority_id' => 'request_for_information_priority_id',
		'rfi_file_manager_file_id' => 'rfi_file_manager_file_id',
		'rfi_cost_code_id' => 'rfi_cost_code_id',
		'rfi_creator_contact_id' => 'rfi_creator_contact_id',
		'rfi_creator_contact_company_office_id' => 'rfi_creator_contact_company_office_id',
		'rfi_creator_phone_contact_company_office_phone_number_id' => 'rfi_creator_phone_contact_company_office_phone_number_id',
		'rfi_creator_fax_contact_company_office_phone_number_id' => 'rfi_creator_fax_contact_company_office_phone_number_id',
		'rfi_creator_contact_mobile_phone_number_id' => 'rfi_creator_contact_mobile_phone_number_id',
		'rfi_recipient_contact_id' => 'rfi_recipient_contact_id',
		'rfi_recipient_contact_company_office_id' => 'rfi_recipient_contact_company_office_id',
		'rfi_recipient_phone_contact_company_office_phone_number_id' => 'rfi_recipient_phone_contact_company_office_phone_number_id',
		'rfi_recipient_fax_contact_company_office_phone_number_id' => 'rfi_recipient_fax_contact_company_office_phone_number_id',
		'rfi_recipient_contact_mobile_phone_number_id' => 'rfi_recipient_contact_mobile_phone_number_id',
		'rfi_initiator_contact_id' => 'rfi_initiator_contact_id',
		'rfi_initiator_contact_company_office_id' => 'rfi_initiator_contact_company_office_id',
		'rfi_initiator_phone_contact_company_office_phone_number_id' => 'rfi_initiator_phone_contact_company_office_phone_number_id',
		'rfi_initiator_fax_contact_company_office_phone_number_id' => 'rfi_initiator_fax_contact_company_office_phone_number_id',
		'rfi_initiator_contact_mobile_phone_number_id' => 'rfi_initiator_contact_mobile_phone_number_id',

		'rfi_title' => 'rfi_title',
		'rfi_plan_page_reference' => 'rfi_plan_page_reference',
		'rfi_statement' => 'rfi_statement',
		'tag_ids' =>'tag_ids',
		'created' => 'created',
		'rfi_due_date' => 'rfi_due_date',
		'rfi_closed_date' => 'rfi_closed_date'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $request_for_information_id;

	public $project_id;
	public $rfi_sequence_number;

	public $request_for_information_type_id;
	public $request_for_information_status_id;
	public $request_for_information_priority_id;
	public $rfi_file_manager_file_id;
	public $rfi_cost_code_id;
	public $rfi_creator_contact_id;
	public $rfi_creator_contact_company_office_id;
	public $rfi_creator_phone_contact_company_office_phone_number_id;
	public $rfi_creator_fax_contact_company_office_phone_number_id;
	public $rfi_creator_contact_mobile_phone_number_id;
	public $rfi_recipient_contact_id;
	public $rfi_recipient_contact_company_office_id;
	public $rfi_recipient_phone_contact_company_office_phone_number_id;
	public $rfi_recipient_fax_contact_company_office_phone_number_id;
	public $rfi_recipient_contact_mobile_phone_number_id;
	public $rfi_initiator_contact_id;
	public $rfi_initiator_contact_company_office_id;
	public $rfi_initiator_phone_contact_company_office_phone_number_id;
	public $rfi_initiator_fax_contact_company_office_phone_number_id;
	public $rfi_initiator_contact_mobile_phone_number_id;

	public $rfi_title;
	public $rfi_plan_page_reference;
	public $rfi_statement;
	public $created;
	public $rfi_due_date;
	public $rfi_closed_date;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties
	public $escaped_rfi_title;
	public $escaped_rfi_plan_page_reference;
	public $escaped_rfi_statement;

	// HTML ENTITY ENCODED NL2BR ORM string properties
	public $escaped_rfi_title_nl2br;
	public $escaped_rfi_plan_page_reference_nl2br;
	public $escaped_rfi_statement_nl2br;

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)
	protected static $_arrRequestsForInformationByProjectId;
	protected static $_arrRequestsForInformationByRequestForInformationTypeId;
	protected static $_arrRequestsForInformationByRequestForInformationStatusId;
	protected static $_arrRequestsForInformationByRequestForInformationPriorityId;
	protected static $_arrRequestsForInformationByRfiFileManagerFileId;
	protected static $_arrRequestsForInformationByRfiCostCodeId;
	protected static $_arrRequestsForInformationByRfiCreatorContactId;
	protected static $_arrRequestsForInformationByRfiCreatorContactCompanyOfficeId;
	protected static $_arrRequestsForInformationByRfiCreatorPhoneContactCompanyOfficePhoneNumberId;
	protected static $_arrRequestsForInformationByRfiCreatorFaxContactCompanyOfficePhoneNumberId;
	protected static $_arrRequestsForInformationByRfiCreatorContactMobilePhoneNumberId;
	protected static $_arrRequestsForInformationByRfiRecipientContactId;
	protected static $_arrRequestsForInformationByRfiRecipientContactCompanyOfficeId;
	protected static $_arrRequestsForInformationByRfiRecipientPhoneContactCompanyOfficePhoneNumberId;
	protected static $_arrRequestsForInformationByRfiRecipientFaxContactCompanyOfficePhoneNumberId;
	protected static $_arrRequestsForInformationByRfiRecipientContactMobilePhoneNumberId;
	protected static $_arrRequestsForInformationByRfiInitiatorContactId;
	protected static $_arrRequestsForInformationByRfiInitiatorContactCompanyOfficeId;
	protected static $_arrRequestsForInformationByRfiInitiatorPhoneContactCompanyOfficePhoneNumberId;
	protected static $_arrRequestsForInformationByRfiInitiatorFaxContactCompanyOfficePhoneNumberId;
	protected static $_arrRequestsForInformationByRfiInitiatorContactMobilePhoneNumberId;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllRequestsForInformation;

	// Foreign Key Objects
	private $_project;
	private $_requestForInformationType;
	private $_requestForInformationStatus;
	private $_requestForInformationPriority;
	private $_rfiFileManagerFile;
	private $_rfiCostCode;
	private $_rfiCreatorContact;
	private $_rfiCreatorContactCompanyOffice;
	private $_rfiCreatorPhoneContactCompanyOfficePhoneNumber;
	private $_rfiCreatorFaxContactCompanyOfficePhoneNumber;
	private $_rfiCreatorContactMobilePhoneNumber;
	private $_rfiRecipientContact;
	private $_rfiRecipientContactCompanyOffice;
	private $_rfiRecipientPhoneContactCompanyOfficePhoneNumber;
	private $_rfiRecipientFaxContactCompanyOfficePhoneNumber;
	private $_rfiRecipientContactMobilePhoneNumber;
	private $_rfiInitiatorContact;
	private $_rfiInitiatorContactCompanyOffice;
	private $_rfiInitiatorPhoneContactCompanyOfficePhoneNumber;
	private $_rfiInitiatorFaxContactCompanyOfficePhoneNumber;
	private $_rfiInitiatorContactMobilePhoneNumber;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='requests_for_information')
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

	public function getRequestForInformationType()
	{
		if (isset($this->_requestForInformationType)) {
			return $this->_requestForInformationType;
		} else {
			return null;
		}
	}

	public function setRequestForInformationType($requestForInformationType)
	{
		$this->_requestForInformationType = $requestForInformationType;
	}

	public function getRequestForInformationStatus()
	{
		if (isset($this->_requestForInformationStatus)) {
			return $this->_requestForInformationStatus;
		} else {
			return null;
		}
	}

	public function setRequestForInformationStatus($requestForInformationStatus)
	{
		$this->_requestForInformationStatus = $requestForInformationStatus;
	}

	public function getRequestForInformationPriority()
	{
		if (isset($this->_requestForInformationPriority)) {
			return $this->_requestForInformationPriority;
		} else {
			return null;
		}
	}

	public function setRequestForInformationPriority($requestForInformationPriority)
	{
		$this->_requestForInformationPriority = $requestForInformationPriority;
	}

	public function getRfiFileManagerFile()
	{
		if (isset($this->_rfiFileManagerFile)) {
			return $this->_rfiFileManagerFile;
		} else {
			return null;
		}
	}

	public function setRfiFileManagerFile($rfiFileManagerFile)
	{
		$this->_rfiFileManagerFile = $rfiFileManagerFile;
	}

	public function getRfiCostCode()
	{
		if (isset($this->_rfiCostCode)) {
			return $this->_rfiCostCode;
		} else {
			return null;
		}
	}

	public function setRfiCostCode($rfiCostCode)
	{
		$this->_rfiCostCode = $rfiCostCode;
	}

	public function getRfiCreatorContact()
	{
		if (isset($this->_rfiCreatorContact)) {
			return $this->_rfiCreatorContact;
		} else {
			return null;
		}
	}

	public function setRfiCreatorContact($rfiCreatorContact)
	{
		$this->_rfiCreatorContact = $rfiCreatorContact;
	}

	public function getRfiCreatorContactCompanyOffice()
	{
		if (isset($this->_rfiCreatorContactCompanyOffice)) {
			return $this->_rfiCreatorContactCompanyOffice;
		} else {
			return null;
		}
	}

	public function setRfiCreatorContactCompanyOffice($rfiCreatorContactCompanyOffice)
	{
		$this->_rfiCreatorContactCompanyOffice = $rfiCreatorContactCompanyOffice;
	}

	public function getRfiCreatorPhoneContactCompanyOfficePhoneNumber()
	{
		if (isset($this->_rfiCreatorPhoneContactCompanyOfficePhoneNumber)) {
			return $this->_rfiCreatorPhoneContactCompanyOfficePhoneNumber;
		} else {
			return null;
		}
	}

	public function setRfiCreatorPhoneContactCompanyOfficePhoneNumber($rfiCreatorPhoneContactCompanyOfficePhoneNumber)
	{
		$this->_rfiCreatorPhoneContactCompanyOfficePhoneNumber = $rfiCreatorPhoneContactCompanyOfficePhoneNumber;
	}

	public function getRfiCreatorFaxContactCompanyOfficePhoneNumber()
	{
		if (isset($this->_rfiCreatorFaxContactCompanyOfficePhoneNumber)) {
			return $this->_rfiCreatorFaxContactCompanyOfficePhoneNumber;
		} else {
			return null;
		}
	}

	public function setRfiCreatorFaxContactCompanyOfficePhoneNumber($rfiCreatorFaxContactCompanyOfficePhoneNumber)
	{
		$this->_rfiCreatorFaxContactCompanyOfficePhoneNumber = $rfiCreatorFaxContactCompanyOfficePhoneNumber;
	}

	public function getRfiCreatorContactMobilePhoneNumber()
	{
		if (isset($this->_rfiCreatorContactMobilePhoneNumber)) {
			return $this->_rfiCreatorContactMobilePhoneNumber;
		} else {
			return null;
		}
	}

	public function setRfiCreatorContactMobilePhoneNumber($rfiCreatorContactMobilePhoneNumber)
	{
		$this->_rfiCreatorContactMobilePhoneNumber = $rfiCreatorContactMobilePhoneNumber;
	}

	public function getRfiRecipientContact()
	{
		if (isset($this->_rfiRecipientContact)) {
			return $this->_rfiRecipientContact;
		} else {
			return null;
		}
	}

	public function setRfiRecipientContact($rfiRecipientContact)
	{
		$this->_rfiRecipientContact = $rfiRecipientContact;
	}

	public function getRfiRecipientContactCompanyOffice()
	{
		if (isset($this->_rfiRecipientContactCompanyOffice)) {
			return $this->_rfiRecipientContactCompanyOffice;
		} else {
			return null;
		}
	}

	public function setRfiRecipientContactCompanyOffice($rfiRecipientContactCompanyOffice)
	{
		$this->_rfiRecipientContactCompanyOffice = $rfiRecipientContactCompanyOffice;
	}

	public function getRfiRecipientPhoneContactCompanyOfficePhoneNumber()
	{
		if (isset($this->_rfiRecipientPhoneContactCompanyOfficePhoneNumber)) {
			return $this->_rfiRecipientPhoneContactCompanyOfficePhoneNumber;
		} else {
			return null;
		}
	}

	public function setRfiRecipientPhoneContactCompanyOfficePhoneNumber($rfiRecipientPhoneContactCompanyOfficePhoneNumber)
	{
		$this->_rfiRecipientPhoneContactCompanyOfficePhoneNumber = $rfiRecipientPhoneContactCompanyOfficePhoneNumber;
	}

	public function getRfiRecipientFaxContactCompanyOfficePhoneNumber()
	{
		if (isset($this->_rfiRecipientFaxContactCompanyOfficePhoneNumber)) {
			return $this->_rfiRecipientFaxContactCompanyOfficePhoneNumber;
		} else {
			return null;
		}
	}

	public function setRfiRecipientFaxContactCompanyOfficePhoneNumber($rfiRecipientFaxContactCompanyOfficePhoneNumber)
	{
		$this->_rfiRecipientFaxContactCompanyOfficePhoneNumber = $rfiRecipientFaxContactCompanyOfficePhoneNumber;
	}

	public function getRfiRecipientContactMobilePhoneNumber()
	{
		if (isset($this->_rfiRecipientContactMobilePhoneNumber)) {
			return $this->_rfiRecipientContactMobilePhoneNumber;
		} else {
			return null;
		}
	}

	public function setRfiRecipientContactMobilePhoneNumber($rfiRecipientContactMobilePhoneNumber)
	{
		$this->_rfiRecipientContactMobilePhoneNumber = $rfiRecipientContactMobilePhoneNumber;
	}

	public function getRfiInitiatorContact()
	{
		if (isset($this->_rfiInitiatorContact)) {
			return $this->_rfiInitiatorContact;
		} else {
			return null;
		}
	}

	public function setRfiInitiatorContact($rfiInitiatorContact)
	{
		$this->_rfiInitiatorContact = $rfiInitiatorContact;
	}

	public function getRfiInitiatorContactCompanyOffice()
	{
		if (isset($this->_rfiInitiatorContactCompanyOffice)) {
			return $this->_rfiInitiatorContactCompanyOffice;
		} else {
			return null;
		}
	}

	public function setRfiInitiatorContactCompanyOffice($rfiInitiatorContactCompanyOffice)
	{
		$this->_rfiInitiatorContactCompanyOffice = $rfiInitiatorContactCompanyOffice;
	}

	public function getRfiInitiatorPhoneContactCompanyOfficePhoneNumber()
	{
		if (isset($this->_rfiInitiatorPhoneContactCompanyOfficePhoneNumber)) {
			return $this->_rfiInitiatorPhoneContactCompanyOfficePhoneNumber;
		} else {
			return null;
		}
	}

	public function setRfiInitiatorPhoneContactCompanyOfficePhoneNumber($rfiInitiatorPhoneContactCompanyOfficePhoneNumber)
	{
		$this->_rfiInitiatorPhoneContactCompanyOfficePhoneNumber = $rfiInitiatorPhoneContactCompanyOfficePhoneNumber;
	}

	public function getRfiInitiatorFaxContactCompanyOfficePhoneNumber()
	{
		if (isset($this->_rfiInitiatorFaxContactCompanyOfficePhoneNumber)) {
			return $this->_rfiInitiatorFaxContactCompanyOfficePhoneNumber;
		} else {
			return null;
		}
	}

	public function setRfiInitiatorFaxContactCompanyOfficePhoneNumber($rfiInitiatorFaxContactCompanyOfficePhoneNumber)
	{
		$this->_rfiInitiatorFaxContactCompanyOfficePhoneNumber = $rfiInitiatorFaxContactCompanyOfficePhoneNumber;
	}

	public function getRfiInitiatorContactMobilePhoneNumber()
	{
		if (isset($this->_rfiInitiatorContactMobilePhoneNumber)) {
			return $this->_rfiInitiatorContactMobilePhoneNumber;
		} else {
			return null;
		}
	}

	public function setRfiInitiatorContactMobilePhoneNumber($rfiInitiatorContactMobilePhoneNumber)
	{
		$this->_rfiInitiatorContactMobilePhoneNumber = $rfiInitiatorContactMobilePhoneNumber;
	}

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)
	public static function getArrRequestsForInformationByProjectId()
	{
		if (isset(self::$_arrRequestsForInformationByProjectId)) {
			return self::$_arrRequestsForInformationByProjectId;
		} else {
			return null;
		}
	}

	public static function setArrRequestsForInformationByProjectId($arrRequestsForInformationByProjectId)
	{
		self::$_arrRequestsForInformationByProjectId = $arrRequestsForInformationByProjectId;
	}

	public static function getArrRequestsForInformationByRequestForInformationTypeId()
	{
		if (isset(self::$_arrRequestsForInformationByRequestForInformationTypeId)) {
			return self::$_arrRequestsForInformationByRequestForInformationTypeId;
		} else {
			return null;
		}
	}

	public static function setArrRequestsForInformationByRequestForInformationTypeId($arrRequestsForInformationByRequestForInformationTypeId)
	{
		self::$_arrRequestsForInformationByRequestForInformationTypeId = $arrRequestsForInformationByRequestForInformationTypeId;
	}

	public static function getArrRequestsForInformationByRequestForInformationStatusId()
	{
		if (isset(self::$_arrRequestsForInformationByRequestForInformationStatusId)) {
			return self::$_arrRequestsForInformationByRequestForInformationStatusId;
		} else {
			return null;
		}
	}

	public static function setArrRequestsForInformationByRequestForInformationStatusId($arrRequestsForInformationByRequestForInformationStatusId)
	{
		self::$_arrRequestsForInformationByRequestForInformationStatusId = $arrRequestsForInformationByRequestForInformationStatusId;
	}

	public static function getArrRequestsForInformationByRequestForInformationPriorityId()
	{
		if (isset(self::$_arrRequestsForInformationByRequestForInformationPriorityId)) {
			return self::$_arrRequestsForInformationByRequestForInformationPriorityId;
		} else {
			return null;
		}
	}

	public static function setArrRequestsForInformationByRequestForInformationPriorityId($arrRequestsForInformationByRequestForInformationPriorityId)
	{
		self::$_arrRequestsForInformationByRequestForInformationPriorityId = $arrRequestsForInformationByRequestForInformationPriorityId;
	}

	public static function getArrRequestsForInformationByRfiFileManagerFileId()
	{
		if (isset(self::$_arrRequestsForInformationByRfiFileManagerFileId)) {
			return self::$_arrRequestsForInformationByRfiFileManagerFileId;
		} else {
			return null;
		}
	}

	public static function setArrRequestsForInformationByRfiFileManagerFileId($arrRequestsForInformationByRfiFileManagerFileId)
	{
		self::$_arrRequestsForInformationByRfiFileManagerFileId = $arrRequestsForInformationByRfiFileManagerFileId;
	}

	public static function getArrRequestsForInformationByRfiCostCodeId()
	{
		if (isset(self::$_arrRequestsForInformationByRfiCostCodeId)) {
			return self::$_arrRequestsForInformationByRfiCostCodeId;
		} else {
			return null;
		}
	}

	public static function setArrRequestsForInformationByRfiCostCodeId($arrRequestsForInformationByRfiCostCodeId)
	{
		self::$_arrRequestsForInformationByRfiCostCodeId = $arrRequestsForInformationByRfiCostCodeId;
	}

	public static function getArrRequestsForInformationByRfiCreatorContactId()
	{
		if (isset(self::$_arrRequestsForInformationByRfiCreatorContactId)) {
			return self::$_arrRequestsForInformationByRfiCreatorContactId;
		} else {
			return null;
		}
	}

	public static function setArrRequestsForInformationByRfiCreatorContactId($arrRequestsForInformationByRfiCreatorContactId)
	{
		self::$_arrRequestsForInformationByRfiCreatorContactId = $arrRequestsForInformationByRfiCreatorContactId;
	}

	public static function getArrRequestsForInformationByRfiCreatorContactCompanyOfficeId()
	{
		if (isset(self::$_arrRequestsForInformationByRfiCreatorContactCompanyOfficeId)) {
			return self::$_arrRequestsForInformationByRfiCreatorContactCompanyOfficeId;
		} else {
			return null;
		}
	}

	public static function setArrRequestsForInformationByRfiCreatorContactCompanyOfficeId($arrRequestsForInformationByRfiCreatorContactCompanyOfficeId)
	{
		self::$_arrRequestsForInformationByRfiCreatorContactCompanyOfficeId = $arrRequestsForInformationByRfiCreatorContactCompanyOfficeId;
	}

	public static function getArrRequestsForInformationByRfiCreatorPhoneContactCompanyOfficePhoneNumberId()
	{
		if (isset(self::$_arrRequestsForInformationByRfiCreatorPhoneContactCompanyOfficePhoneNumberId)) {
			return self::$_arrRequestsForInformationByRfiCreatorPhoneContactCompanyOfficePhoneNumberId;
		} else {
			return null;
		}
	}

	public static function setArrRequestsForInformationByRfiCreatorPhoneContactCompanyOfficePhoneNumberId($arrRequestsForInformationByRfiCreatorPhoneContactCompanyOfficePhoneNumberId)
	{
		self::$_arrRequestsForInformationByRfiCreatorPhoneContactCompanyOfficePhoneNumberId = $arrRequestsForInformationByRfiCreatorPhoneContactCompanyOfficePhoneNumberId;
	}

	public static function getArrRequestsForInformationByRfiCreatorFaxContactCompanyOfficePhoneNumberId()
	{
		if (isset(self::$_arrRequestsForInformationByRfiCreatorFaxContactCompanyOfficePhoneNumberId)) {
			return self::$_arrRequestsForInformationByRfiCreatorFaxContactCompanyOfficePhoneNumberId;
		} else {
			return null;
		}
	}

	public static function setArrRequestsForInformationByRfiCreatorFaxContactCompanyOfficePhoneNumberId($arrRequestsForInformationByRfiCreatorFaxContactCompanyOfficePhoneNumberId)
	{
		self::$_arrRequestsForInformationByRfiCreatorFaxContactCompanyOfficePhoneNumberId = $arrRequestsForInformationByRfiCreatorFaxContactCompanyOfficePhoneNumberId;
	}

	public static function getArrRequestsForInformationByRfiCreatorContactMobilePhoneNumberId()
	{
		if (isset(self::$_arrRequestsForInformationByRfiCreatorContactMobilePhoneNumberId)) {
			return self::$_arrRequestsForInformationByRfiCreatorContactMobilePhoneNumberId;
		} else {
			return null;
		}
	}

	public static function setArrRequestsForInformationByRfiCreatorContactMobilePhoneNumberId($arrRequestsForInformationByRfiCreatorContactMobilePhoneNumberId)
	{
		self::$_arrRequestsForInformationByRfiCreatorContactMobilePhoneNumberId = $arrRequestsForInformationByRfiCreatorContactMobilePhoneNumberId;
	}

	public static function getArrRequestsForInformationByRfiRecipientContactId()
	{
		if (isset(self::$_arrRequestsForInformationByRfiRecipientContactId)) {
			return self::$_arrRequestsForInformationByRfiRecipientContactId;
		} else {
			return null;
		}
	}

	public static function setArrRequestsForInformationByRfiRecipientContactId($arrRequestsForInformationByRfiRecipientContactId)
	{
		self::$_arrRequestsForInformationByRfiRecipientContactId = $arrRequestsForInformationByRfiRecipientContactId;
	}

	public static function getArrRequestsForInformationByRfiRecipientContactCompanyOfficeId()
	{
		if (isset(self::$_arrRequestsForInformationByRfiRecipientContactCompanyOfficeId)) {
			return self::$_arrRequestsForInformationByRfiRecipientContactCompanyOfficeId;
		} else {
			return null;
		}
	}

	public static function setArrRequestsForInformationByRfiRecipientContactCompanyOfficeId($arrRequestsForInformationByRfiRecipientContactCompanyOfficeId)
	{
		self::$_arrRequestsForInformationByRfiRecipientContactCompanyOfficeId = $arrRequestsForInformationByRfiRecipientContactCompanyOfficeId;
	}

	public static function getArrRequestsForInformationByRfiRecipientPhoneContactCompanyOfficePhoneNumberId()
	{
		if (isset(self::$_arrRequestsForInformationByRfiRecipientPhoneContactCompanyOfficePhoneNumberId)) {
			return self::$_arrRequestsForInformationByRfiRecipientPhoneContactCompanyOfficePhoneNumberId;
		} else {
			return null;
		}
	}

	public static function setArrRequestsForInformationByRfiRecipientPhoneContactCompanyOfficePhoneNumberId($arrRequestsForInformationByRfiRecipientPhoneContactCompanyOfficePhoneNumberId)
	{
		self::$_arrRequestsForInformationByRfiRecipientPhoneContactCompanyOfficePhoneNumberId = $arrRequestsForInformationByRfiRecipientPhoneContactCompanyOfficePhoneNumberId;
	}

	public static function getArrRequestsForInformationByRfiRecipientFaxContactCompanyOfficePhoneNumberId()
	{
		if (isset(self::$_arrRequestsForInformationByRfiRecipientFaxContactCompanyOfficePhoneNumberId)) {
			return self::$_arrRequestsForInformationByRfiRecipientFaxContactCompanyOfficePhoneNumberId;
		} else {
			return null;
		}
	}

	public static function setArrRequestsForInformationByRfiRecipientFaxContactCompanyOfficePhoneNumberId($arrRequestsForInformationByRfiRecipientFaxContactCompanyOfficePhoneNumberId)
	{
		self::$_arrRequestsForInformationByRfiRecipientFaxContactCompanyOfficePhoneNumberId = $arrRequestsForInformationByRfiRecipientFaxContactCompanyOfficePhoneNumberId;
	}

	public static function getArrRequestsForInformationByRfiRecipientContactMobilePhoneNumberId()
	{
		if (isset(self::$_arrRequestsForInformationByRfiRecipientContactMobilePhoneNumberId)) {
			return self::$_arrRequestsForInformationByRfiRecipientContactMobilePhoneNumberId;
		} else {
			return null;
		}
	}

	public static function setArrRequestsForInformationByRfiRecipientContactMobilePhoneNumberId($arrRequestsForInformationByRfiRecipientContactMobilePhoneNumberId)
	{
		self::$_arrRequestsForInformationByRfiRecipientContactMobilePhoneNumberId = $arrRequestsForInformationByRfiRecipientContactMobilePhoneNumberId;
	}

	public static function getArrRequestsForInformationByRfiInitiatorContactId()
	{
		if (isset(self::$_arrRequestsForInformationByRfiInitiatorContactId)) {
			return self::$_arrRequestsForInformationByRfiInitiatorContactId;
		} else {
			return null;
		}
	}

	public static function setArrRequestsForInformationByRfiInitiatorContactId($arrRequestsForInformationByRfiInitiatorContactId)
	{
		self::$_arrRequestsForInformationByRfiInitiatorContactId = $arrRequestsForInformationByRfiInitiatorContactId;
	}

	public static function getArrRequestsForInformationByRfiInitiatorContactCompanyOfficeId()
	{
		if (isset(self::$_arrRequestsForInformationByRfiInitiatorContactCompanyOfficeId)) {
			return self::$_arrRequestsForInformationByRfiInitiatorContactCompanyOfficeId;
		} else {
			return null;
		}
	}

	public static function setArrRequestsForInformationByRfiInitiatorContactCompanyOfficeId($arrRequestsForInformationByRfiInitiatorContactCompanyOfficeId)
	{
		self::$_arrRequestsForInformationByRfiInitiatorContactCompanyOfficeId = $arrRequestsForInformationByRfiInitiatorContactCompanyOfficeId;
	}

	public static function getArrRequestsForInformationByRfiInitiatorPhoneContactCompanyOfficePhoneNumberId()
	{
		if (isset(self::$_arrRequestsForInformationByRfiInitiatorPhoneContactCompanyOfficePhoneNumberId)) {
			return self::$_arrRequestsForInformationByRfiInitiatorPhoneContactCompanyOfficePhoneNumberId;
		} else {
			return null;
		}
	}

	public static function setArrRequestsForInformationByRfiInitiatorPhoneContactCompanyOfficePhoneNumberId($arrRequestsForInformationByRfiInitiatorPhoneContactCompanyOfficePhoneNumberId)
	{
		self::$_arrRequestsForInformationByRfiInitiatorPhoneContactCompanyOfficePhoneNumberId = $arrRequestsForInformationByRfiInitiatorPhoneContactCompanyOfficePhoneNumberId;
	}

	public static function getArrRequestsForInformationByRfiInitiatorFaxContactCompanyOfficePhoneNumberId()
	{
		if (isset(self::$_arrRequestsForInformationByRfiInitiatorFaxContactCompanyOfficePhoneNumberId)) {
			return self::$_arrRequestsForInformationByRfiInitiatorFaxContactCompanyOfficePhoneNumberId;
		} else {
			return null;
		}
	}

	public static function setArrRequestsForInformationByRfiInitiatorFaxContactCompanyOfficePhoneNumberId($arrRequestsForInformationByRfiInitiatorFaxContactCompanyOfficePhoneNumberId)
	{
		self::$_arrRequestsForInformationByRfiInitiatorFaxContactCompanyOfficePhoneNumberId = $arrRequestsForInformationByRfiInitiatorFaxContactCompanyOfficePhoneNumberId;
	}

	public static function getArrRequestsForInformationByRfiInitiatorContactMobilePhoneNumberId()
	{
		if (isset(self::$_arrRequestsForInformationByRfiInitiatorContactMobilePhoneNumberId)) {
			return self::$_arrRequestsForInformationByRfiInitiatorContactMobilePhoneNumberId;
		} else {
			return null;
		}
	}

	public static function setArrRequestsForInformationByRfiInitiatorContactMobilePhoneNumberId($arrRequestsForInformationByRfiInitiatorContactMobilePhoneNumberId)
	{
		self::$_arrRequestsForInformationByRfiInitiatorContactMobilePhoneNumberId = $arrRequestsForInformationByRfiInitiatorContactMobilePhoneNumberId;
	}

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllRequestsForInformation()
	{
		if (isset(self::$_arrAllRequestsForInformation)) {
			return self::$_arrAllRequestsForInformation;
		} else {
			return null;
		}
	}

	public static function setArrAllRequestsForInformation($arrAllRequestsForInformation)
	{
		self::$_arrAllRequestsForInformation = $arrAllRequestsForInformation;
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
	 * @param int $request_for_information_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findById($database, $request_for_information_id,$table='requests_for_information', $module='RequestForInformation')
	{
		$requestForInformation = parent::findById($database, $request_for_information_id, $table, $module);

		return $requestForInformation;
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Similar to FindById, but with SQL as starter code for more complex joins.
	 *
	 * @param string $database
	 * @param int $request_for_information_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findRequestForInformationByIdExtended($database, $request_for_information_id)
	{
		$request_for_information_id = (int) $request_for_information_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	rfi_fk_p.`id` AS 'rfi_fk_p__project_id',
	rfi_fk_p.`project_type_id` AS 'rfi_fk_p__project_type_id',
	rfi_fk_p.`user_company_id` AS 'rfi_fk_p__user_company_id',
	rfi_fk_p.`user_custom_project_id` AS 'rfi_fk_p__user_custom_project_id',
	rfi_fk_p.`project_name` AS 'rfi_fk_p__project_name',
	rfi_fk_p.`project_owner_name` AS 'rfi_fk_p__project_owner_name',
	rfi_fk_p.`latitude` AS 'rfi_fk_p__latitude',
	rfi_fk_p.`longitude` AS 'rfi_fk_p__longitude',
	rfi_fk_p.`address_line_1` AS 'rfi_fk_p__address_line_1',
	rfi_fk_p.`address_line_2` AS 'rfi_fk_p__address_line_2',
	rfi_fk_p.`address_line_3` AS 'rfi_fk_p__address_line_3',
	rfi_fk_p.`address_line_4` AS 'rfi_fk_p__address_line_4',
	rfi_fk_p.`address_city` AS 'rfi_fk_p__address_city',
	rfi_fk_p.`address_county` AS 'rfi_fk_p__address_county',
	rfi_fk_p.`address_state_or_region` AS 'rfi_fk_p__address_state_or_region',
	rfi_fk_p.`address_postal_code` AS 'rfi_fk_p__address_postal_code',
	rfi_fk_p.`address_postal_code_extension` AS 'rfi_fk_p__address_postal_code_extension',
	rfi_fk_p.`address_country` AS 'rfi_fk_p__address_country',
	rfi_fk_p.`building_count` AS 'rfi_fk_p__building_count',
	rfi_fk_p.`unit_count` AS 'rfi_fk_p__unit_count',
	rfi_fk_p.`gross_square_footage` AS 'rfi_fk_p__gross_square_footage',
	rfi_fk_p.`net_rentable_square_footage` AS 'rfi_fk_p__net_rentable_square_footage',
	rfi_fk_p.`is_active_flag` AS 'rfi_fk_p__is_active_flag',
	rfi_fk_p.`public_plans_flag` AS 'rfi_fk_p__public_plans_flag',
	rfi_fk_p.`prevailing_wage_flag` AS 'rfi_fk_p__prevailing_wage_flag',
	rfi_fk_p.`city_business_license_required_flag` AS 'rfi_fk_p__city_business_license_required_flag',
	rfi_fk_p.`is_internal_flag` AS 'rfi_fk_p__is_internal_flag',
	rfi_fk_p.`project_contract_date` AS 'rfi_fk_p__project_contract_date',
	rfi_fk_p.`project_start_date` AS 'rfi_fk_p__project_start_date',
	rfi_fk_p.`project_completed_date` AS 'rfi_fk_p__project_completed_date',
	rfi_fk_p.`sort_order` AS 'rfi_fk_p__sort_order',

	rfi_fk_rfit.`id` AS 'rfi_fk_rfit__request_for_information_type_id',
	rfi_fk_rfit.`request_for_information_type` AS 'rfi_fk_rfit__request_for_information_type',
	rfi_fk_rfit.`disabled_flag` AS 'rfi_fk_rfit__disabled_flag',

	rfi_fk_rfis.`id` AS 'rfi_fk_rfis__request_for_information_status_id',
	rfi_fk_rfis.`request_for_information_status` AS 'rfi_fk_rfis__request_for_information_status',
	rfi_fk_rfis.`disabled_flag` AS 'rfi_fk_rfis__disabled_flag',

	rfi_fk_rfip.`id` AS 'rfi_fk_rfip__request_for_information_priority_id',
	rfi_fk_rfip.`request_for_information_priority` AS 'rfi_fk_rfip__request_for_information_priority',
	rfi_fk_rfip.`disabled_flag` AS 'rfi_fk_rfip__disabled_flag',

	rfi_fk_fmfiles.`id` AS 'rfi_fk_fmfiles__file_manager_file_id',
	rfi_fk_fmfiles.`user_company_id` AS 'rfi_fk_fmfiles__user_company_id',
	rfi_fk_fmfiles.`contact_id` AS 'rfi_fk_fmfiles__contact_id',
	rfi_fk_fmfiles.`project_id` AS 'rfi_fk_fmfiles__project_id',
	rfi_fk_fmfiles.`file_manager_folder_id` AS 'rfi_fk_fmfiles__file_manager_folder_id',
	rfi_fk_fmfiles.`file_location_id` AS 'rfi_fk_fmfiles__file_location_id',
	rfi_fk_fmfiles.`virtual_file_name` AS 'rfi_fk_fmfiles__virtual_file_name',
	rfi_fk_fmfiles.`version_number` AS 'rfi_fk_fmfiles__version_number',
	rfi_fk_fmfiles.`virtual_file_name_sha1` AS 'rfi_fk_fmfiles__virtual_file_name_sha1',
	rfi_fk_fmfiles.`virtual_file_mime_type` AS 'rfi_fk_fmfiles__virtual_file_mime_type',
	rfi_fk_fmfiles.`modified` AS 'rfi_fk_fmfiles__modified',
	rfi_fk_fmfiles.`created` AS 'rfi_fk_fmfiles__created',
	rfi_fk_fmfiles.`deleted_flag` AS 'rfi_fk_fmfiles__deleted_flag',
	rfi_fk_fmfiles.`directly_deleted_flag` AS 'rfi_fk_fmfiles__directly_deleted_flag',

	rfi_fk_codes.`id` AS 'rfi_fk_codes__cost_code_id',
	rfi_fk_codes.`cost_code_division_id` AS 'rfi_fk_codes__cost_code_division_id',
	rfi_fk_codes.`cost_code` AS 'rfi_fk_codes__cost_code',
	rfi_fk_codes.`cost_code_description` AS 'rfi_fk_codes__cost_code_description',
	rfi_fk_codes.`cost_code_description_abbreviation` AS 'rfi_fk_codes__cost_code_description_abbreviation',
	rfi_fk_codes.`sort_order` AS 'rfi_fk_codes__sort_order',
	rfi_fk_codes.`disabled_flag` AS 'rfi_fk_codes__disabled_flag',

	rfi_fk_creator_c.`id` AS 'rfi_fk_creator_c__contact_id',
	rfi_fk_creator_c.`user_company_id` AS 'rfi_fk_creator_c__user_company_id',
	rfi_fk_creator_c.`user_id` AS 'rfi_fk_creator_c__user_id',
	rfi_fk_creator_c.`contact_company_id` AS 'rfi_fk_creator_c__contact_company_id',
	rfi_fk_creator_c.`email` AS 'rfi_fk_creator_c__email',
	rfi_fk_creator_c.`name_prefix` AS 'rfi_fk_creator_c__name_prefix',
	rfi_fk_creator_c.`first_name` AS 'rfi_fk_creator_c__first_name',
	rfi_fk_creator_c.`additional_name` AS 'rfi_fk_creator_c__additional_name',
	rfi_fk_creator_c.`middle_name` AS 'rfi_fk_creator_c__middle_name',
	rfi_fk_creator_c.`last_name` AS 'rfi_fk_creator_c__last_name',
	rfi_fk_creator_c.`name_suffix` AS 'rfi_fk_creator_c__name_suffix',
	rfi_fk_creator_c.`title` AS 'rfi_fk_creator_c__title',
	rfi_fk_creator_c.`vendor_flag` AS 'rfi_fk_creator_c__vendor_flag',
	rfi_fk_creator_c.`is_archive` AS 'rfi_fk_creator_c__is_archive',

	rfi_fk_creator_cco.`id` AS 'rfi_fk_creator_cco__contact_company_office_id',
	rfi_fk_creator_cco.`contact_company_id` AS 'rfi_fk_creator_cco__contact_company_id',
	rfi_fk_creator_cco.`office_nickname` AS 'rfi_fk_creator_cco__office_nickname',
	rfi_fk_creator_cco.`address_line_1` AS 'rfi_fk_creator_cco__address_line_1',
	rfi_fk_creator_cco.`address_line_2` AS 'rfi_fk_creator_cco__address_line_2',
	rfi_fk_creator_cco.`address_line_3` AS 'rfi_fk_creator_cco__address_line_3',
	rfi_fk_creator_cco.`address_line_4` AS 'rfi_fk_creator_cco__address_line_4',
	rfi_fk_creator_cco.`address_city` AS 'rfi_fk_creator_cco__address_city',
	rfi_fk_creator_cco.`address_county` AS 'rfi_fk_creator_cco__address_county',
	rfi_fk_creator_cco.`address_state_or_region` AS 'rfi_fk_creator_cco__address_state_or_region',
	rfi_fk_creator_cco.`address_postal_code` AS 'rfi_fk_creator_cco__address_postal_code',
	rfi_fk_creator_cco.`address_postal_code_extension` AS 'rfi_fk_creator_cco__address_postal_code_extension',
	rfi_fk_creator_cco.`address_country` AS 'rfi_fk_creator_cco__address_country',
	rfi_fk_creator_cco.`head_quarters_flag` AS 'rfi_fk_creator_cco__head_quarters_flag',
	rfi_fk_creator_cco.`address_validated_by_user_flag` AS 'rfi_fk_creator_cco__address_validated_by_user_flag',
	rfi_fk_creator_cco.`address_validated_by_web_service_flag` AS 'rfi_fk_creator_cco__address_validated_by_web_service_flag',
	rfi_fk_creator_cco.`address_validation_by_web_service_error_flag` AS 'rfi_fk_creator_cco__address_validation_by_web_service_error_flag',

	rfi_fk_creator_phone_ccopn.`id` AS 'rfi_fk_creator_phone_ccopn__contact_company_office_phone_number_id',
	rfi_fk_creator_phone_ccopn.`contact_company_office_id` AS 'rfi_fk_creator_phone_ccopn__contact_company_office_id',
	rfi_fk_creator_phone_ccopn.`phone_number_type_id` AS 'rfi_fk_creator_phone_ccopn__phone_number_type_id',
	rfi_fk_creator_phone_ccopn.`country_code` AS 'rfi_fk_creator_phone_ccopn__country_code',
	rfi_fk_creator_phone_ccopn.`area_code` AS 'rfi_fk_creator_phone_ccopn__area_code',
	rfi_fk_creator_phone_ccopn.`prefix` AS 'rfi_fk_creator_phone_ccopn__prefix',
	rfi_fk_creator_phone_ccopn.`number` AS 'rfi_fk_creator_phone_ccopn__number',
	rfi_fk_creator_phone_ccopn.`extension` AS 'rfi_fk_creator_phone_ccopn__extension',
	rfi_fk_creator_phone_ccopn.`itu` AS 'rfi_fk_creator_phone_ccopn__itu',

	rfi_fk_creator_fax_ccopn.`id` AS 'rfi_fk_creator_fax_ccopn__contact_company_office_phone_number_id',
	rfi_fk_creator_fax_ccopn.`contact_company_office_id` AS 'rfi_fk_creator_fax_ccopn__contact_company_office_id',
	rfi_fk_creator_fax_ccopn.`phone_number_type_id` AS 'rfi_fk_creator_fax_ccopn__phone_number_type_id',
	rfi_fk_creator_fax_ccopn.`country_code` AS 'rfi_fk_creator_fax_ccopn__country_code',
	rfi_fk_creator_fax_ccopn.`area_code` AS 'rfi_fk_creator_fax_ccopn__area_code',
	rfi_fk_creator_fax_ccopn.`prefix` AS 'rfi_fk_creator_fax_ccopn__prefix',
	rfi_fk_creator_fax_ccopn.`number` AS 'rfi_fk_creator_fax_ccopn__number',
	rfi_fk_creator_fax_ccopn.`extension` AS 'rfi_fk_creator_fax_ccopn__extension',
	rfi_fk_creator_fax_ccopn.`itu` AS 'rfi_fk_creator_fax_ccopn__itu',

	rfi_fk_creator_c_mobile_cpn.`id` AS 'rfi_fk_creator_c_mobile_cpn__contact_phone_number_id',
	rfi_fk_creator_c_mobile_cpn.`contact_id` AS 'rfi_fk_creator_c_mobile_cpn__contact_id',
	rfi_fk_creator_c_mobile_cpn.`phone_number_type_id` AS 'rfi_fk_creator_c_mobile_cpn__phone_number_type_id',
	rfi_fk_creator_c_mobile_cpn.`country_code` AS 'rfi_fk_creator_c_mobile_cpn__country_code',
	rfi_fk_creator_c_mobile_cpn.`area_code` AS 'rfi_fk_creator_c_mobile_cpn__area_code',
	rfi_fk_creator_c_mobile_cpn.`prefix` AS 'rfi_fk_creator_c_mobile_cpn__prefix',
	rfi_fk_creator_c_mobile_cpn.`number` AS 'rfi_fk_creator_c_mobile_cpn__number',
	rfi_fk_creator_c_mobile_cpn.`extension` AS 'rfi_fk_creator_c_mobile_cpn__extension',
	rfi_fk_creator_c_mobile_cpn.`itu` AS 'rfi_fk_creator_c_mobile_cpn__itu',

	rfi_fk_recipient_c.`id` AS 'rfi_fk_recipient_c__contact_id',
	rfi_fk_recipient_c.`user_company_id` AS 'rfi_fk_recipient_c__user_company_id',
	rfi_fk_recipient_c.`user_id` AS 'rfi_fk_recipient_c__user_id',
	rfi_fk_recipient_c.`contact_company_id` AS 'rfi_fk_recipient_c__contact_company_id',
	rfi_fk_recipient_c.`email` AS 'rfi_fk_recipient_c__email',
	rfi_fk_recipient_c.`name_prefix` AS 'rfi_fk_recipient_c__name_prefix',
	rfi_fk_recipient_c.`first_name` AS 'rfi_fk_recipient_c__first_name',
	rfi_fk_recipient_c.`additional_name` AS 'rfi_fk_recipient_c__additional_name',
	rfi_fk_recipient_c.`middle_name` AS 'rfi_fk_recipient_c__middle_name',
	rfi_fk_recipient_c.`last_name` AS 'rfi_fk_recipient_c__last_name',
	rfi_fk_recipient_c.`name_suffix` AS 'rfi_fk_recipient_c__name_suffix',
	rfi_fk_recipient_c.`title` AS 'rfi_fk_recipient_c__title',
	rfi_fk_recipient_c.`vendor_flag` AS 'rfi_fk_recipient_c__vendor_flag',
	rfi_fk_recipient_c.`is_archive` AS 'rfi_fk_recipient_c__is_archive',

	rfi_fk_recipient_cco.`id` AS 'rfi_fk_recipient_cco__contact_company_office_id',
	rfi_fk_recipient_cco.`contact_company_id` AS 'rfi_fk_recipient_cco__contact_company_id',
	rfi_fk_recipient_cco.`office_nickname` AS 'rfi_fk_recipient_cco__office_nickname',
	rfi_fk_recipient_cco.`address_line_1` AS 'rfi_fk_recipient_cco__address_line_1',
	rfi_fk_recipient_cco.`address_line_2` AS 'rfi_fk_recipient_cco__address_line_2',
	rfi_fk_recipient_cco.`address_line_3` AS 'rfi_fk_recipient_cco__address_line_3',
	rfi_fk_recipient_cco.`address_line_4` AS 'rfi_fk_recipient_cco__address_line_4',
	rfi_fk_recipient_cco.`address_city` AS 'rfi_fk_recipient_cco__address_city',
	rfi_fk_recipient_cco.`address_county` AS 'rfi_fk_recipient_cco__address_county',
	rfi_fk_recipient_cco.`address_state_or_region` AS 'rfi_fk_recipient_cco__address_state_or_region',
	rfi_fk_recipient_cco.`address_postal_code` AS 'rfi_fk_recipient_cco__address_postal_code',
	rfi_fk_recipient_cco.`address_postal_code_extension` AS 'rfi_fk_recipient_cco__address_postal_code_extension',
	rfi_fk_recipient_cco.`address_country` AS 'rfi_fk_recipient_cco__address_country',
	rfi_fk_recipient_cco.`head_quarters_flag` AS 'rfi_fk_recipient_cco__head_quarters_flag',
	rfi_fk_recipient_cco.`address_validated_by_user_flag` AS 'rfi_fk_recipient_cco__address_validated_by_user_flag',
	rfi_fk_recipient_cco.`address_validated_by_web_service_flag` AS 'rfi_fk_recipient_cco__address_validated_by_web_service_flag',
	rfi_fk_recipient_cco.`address_validation_by_web_service_error_flag` AS 'rfi_fk_recipient_cco__address_validation_by_web_service_error_flag',

	rfi_fk_recipient_phone_ccopn.`id` AS 'rfi_fk_recipient_phone_ccopn__contact_company_office_phone_number_id',
	rfi_fk_recipient_phone_ccopn.`contact_company_office_id` AS 'rfi_fk_recipient_phone_ccopn__contact_company_office_id',
	rfi_fk_recipient_phone_ccopn.`phone_number_type_id` AS 'rfi_fk_recipient_phone_ccopn__phone_number_type_id',
	rfi_fk_recipient_phone_ccopn.`country_code` AS 'rfi_fk_recipient_phone_ccopn__country_code',
	rfi_fk_recipient_phone_ccopn.`area_code` AS 'rfi_fk_recipient_phone_ccopn__area_code',
	rfi_fk_recipient_phone_ccopn.`prefix` AS 'rfi_fk_recipient_phone_ccopn__prefix',
	rfi_fk_recipient_phone_ccopn.`number` AS 'rfi_fk_recipient_phone_ccopn__number',
	rfi_fk_recipient_phone_ccopn.`extension` AS 'rfi_fk_recipient_phone_ccopn__extension',
	rfi_fk_recipient_phone_ccopn.`itu` AS 'rfi_fk_recipient_phone_ccopn__itu',

	rfi_fk_recipient_fax_ccopn.`id` AS 'rfi_fk_recipient_fax_ccopn__contact_company_office_phone_number_id',
	rfi_fk_recipient_fax_ccopn.`contact_company_office_id` AS 'rfi_fk_recipient_fax_ccopn__contact_company_office_id',
	rfi_fk_recipient_fax_ccopn.`phone_number_type_id` AS 'rfi_fk_recipient_fax_ccopn__phone_number_type_id',
	rfi_fk_recipient_fax_ccopn.`country_code` AS 'rfi_fk_recipient_fax_ccopn__country_code',
	rfi_fk_recipient_fax_ccopn.`area_code` AS 'rfi_fk_recipient_fax_ccopn__area_code',
	rfi_fk_recipient_fax_ccopn.`prefix` AS 'rfi_fk_recipient_fax_ccopn__prefix',
	rfi_fk_recipient_fax_ccopn.`number` AS 'rfi_fk_recipient_fax_ccopn__number',
	rfi_fk_recipient_fax_ccopn.`extension` AS 'rfi_fk_recipient_fax_ccopn__extension',
	rfi_fk_recipient_fax_ccopn.`itu` AS 'rfi_fk_recipient_fax_ccopn__itu',

	rfi_fk_recipient_c_mobile_cpn.`id` AS 'rfi_fk_recipient_c_mobile_cpn__contact_phone_number_id',
	rfi_fk_recipient_c_mobile_cpn.`contact_id` AS 'rfi_fk_recipient_c_mobile_cpn__contact_id',
	rfi_fk_recipient_c_mobile_cpn.`phone_number_type_id` AS 'rfi_fk_recipient_c_mobile_cpn__phone_number_type_id',
	rfi_fk_recipient_c_mobile_cpn.`country_code` AS 'rfi_fk_recipient_c_mobile_cpn__country_code',
	rfi_fk_recipient_c_mobile_cpn.`area_code` AS 'rfi_fk_recipient_c_mobile_cpn__area_code',
	rfi_fk_recipient_c_mobile_cpn.`prefix` AS 'rfi_fk_recipient_c_mobile_cpn__prefix',
	rfi_fk_recipient_c_mobile_cpn.`number` AS 'rfi_fk_recipient_c_mobile_cpn__number',
	rfi_fk_recipient_c_mobile_cpn.`extension` AS 'rfi_fk_recipient_c_mobile_cpn__extension',
	rfi_fk_recipient_c_mobile_cpn.`itu` AS 'rfi_fk_recipient_c_mobile_cpn__itu',

	rfi_fk_initiator_c.`id` AS 'rfi_fk_initiator_c__contact_id',
	rfi_fk_initiator_c.`user_company_id` AS 'rfi_fk_initiator_c__user_company_id',
	rfi_fk_initiator_c.`user_id` AS 'rfi_fk_initiator_c__user_id',
	rfi_fk_initiator_c.`contact_company_id` AS 'rfi_fk_initiator_c__contact_company_id',
	rfi_fk_initiator_c.`email` AS 'rfi_fk_initiator_c__email',
	rfi_fk_initiator_c.`name_prefix` AS 'rfi_fk_initiator_c__name_prefix',
	rfi_fk_initiator_c.`first_name` AS 'rfi_fk_initiator_c__first_name',
	rfi_fk_initiator_c.`additional_name` AS 'rfi_fk_initiator_c__additional_name',
	rfi_fk_initiator_c.`middle_name` AS 'rfi_fk_initiator_c__middle_name',
	rfi_fk_initiator_c.`last_name` AS 'rfi_fk_initiator_c__last_name',
	rfi_fk_initiator_c.`name_suffix` AS 'rfi_fk_initiator_c__name_suffix',
	rfi_fk_initiator_c.`title` AS 'rfi_fk_initiator_c__title',
	rfi_fk_initiator_c.`vendor_flag` AS 'rfi_fk_initiator_c__vendor_flag',
	rfi_fk_initiator_c.`is_archive` AS 'rfi_fk_initiator_c__is_archive',

	rfi_fk_initiator_cco.`id` AS 'rfi_fk_initiator_cco__contact_company_office_id',
	rfi_fk_initiator_cco.`contact_company_id` AS 'rfi_fk_initiator_cco__contact_company_id',
	rfi_fk_initiator_cco.`office_nickname` AS 'rfi_fk_initiator_cco__office_nickname',
	rfi_fk_initiator_cco.`address_line_1` AS 'rfi_fk_initiator_cco__address_line_1',
	rfi_fk_initiator_cco.`address_line_2` AS 'rfi_fk_initiator_cco__address_line_2',
	rfi_fk_initiator_cco.`address_line_3` AS 'rfi_fk_initiator_cco__address_line_3',
	rfi_fk_initiator_cco.`address_line_4` AS 'rfi_fk_initiator_cco__address_line_4',
	rfi_fk_initiator_cco.`address_city` AS 'rfi_fk_initiator_cco__address_city',
	rfi_fk_initiator_cco.`address_county` AS 'rfi_fk_initiator_cco__address_county',
	rfi_fk_initiator_cco.`address_state_or_region` AS 'rfi_fk_initiator_cco__address_state_or_region',
	rfi_fk_initiator_cco.`address_postal_code` AS 'rfi_fk_initiator_cco__address_postal_code',
	rfi_fk_initiator_cco.`address_postal_code_extension` AS 'rfi_fk_initiator_cco__address_postal_code_extension',
	rfi_fk_initiator_cco.`address_country` AS 'rfi_fk_initiator_cco__address_country',
	rfi_fk_initiator_cco.`head_quarters_flag` AS 'rfi_fk_initiator_cco__head_quarters_flag',
	rfi_fk_initiator_cco.`address_validated_by_user_flag` AS 'rfi_fk_initiator_cco__address_validated_by_user_flag',
	rfi_fk_initiator_cco.`address_validated_by_web_service_flag` AS 'rfi_fk_initiator_cco__address_validated_by_web_service_flag',
	rfi_fk_initiator_cco.`address_validation_by_web_service_error_flag` AS 'rfi_fk_initiator_cco__address_validation_by_web_service_error_flag',

	rfi_fk_initiator_phone_ccopn.`id` AS 'rfi_fk_initiator_phone_ccopn__contact_company_office_phone_number_id',
	rfi_fk_initiator_phone_ccopn.`contact_company_office_id` AS 'rfi_fk_initiator_phone_ccopn__contact_company_office_id',
	rfi_fk_initiator_phone_ccopn.`phone_number_type_id` AS 'rfi_fk_initiator_phone_ccopn__phone_number_type_id',
	rfi_fk_initiator_phone_ccopn.`country_code` AS 'rfi_fk_initiator_phone_ccopn__country_code',
	rfi_fk_initiator_phone_ccopn.`area_code` AS 'rfi_fk_initiator_phone_ccopn__area_code',
	rfi_fk_initiator_phone_ccopn.`prefix` AS 'rfi_fk_initiator_phone_ccopn__prefix',
	rfi_fk_initiator_phone_ccopn.`number` AS 'rfi_fk_initiator_phone_ccopn__number',
	rfi_fk_initiator_phone_ccopn.`extension` AS 'rfi_fk_initiator_phone_ccopn__extension',
	rfi_fk_initiator_phone_ccopn.`itu` AS 'rfi_fk_initiator_phone_ccopn__itu',

	rfi_fk_initiator_fax_ccopn.`id` AS 'rfi_fk_initiator_fax_ccopn__contact_company_office_phone_number_id',
	rfi_fk_initiator_fax_ccopn.`contact_company_office_id` AS 'rfi_fk_initiator_fax_ccopn__contact_company_office_id',
	rfi_fk_initiator_fax_ccopn.`phone_number_type_id` AS 'rfi_fk_initiator_fax_ccopn__phone_number_type_id',
	rfi_fk_initiator_fax_ccopn.`country_code` AS 'rfi_fk_initiator_fax_ccopn__country_code',
	rfi_fk_initiator_fax_ccopn.`area_code` AS 'rfi_fk_initiator_fax_ccopn__area_code',
	rfi_fk_initiator_fax_ccopn.`prefix` AS 'rfi_fk_initiator_fax_ccopn__prefix',
	rfi_fk_initiator_fax_ccopn.`number` AS 'rfi_fk_initiator_fax_ccopn__number',
	rfi_fk_initiator_fax_ccopn.`extension` AS 'rfi_fk_initiator_fax_ccopn__extension',
	rfi_fk_initiator_fax_ccopn.`itu` AS 'rfi_fk_initiator_fax_ccopn__itu',

	rfi_fk_initiator_c_mobile_cpn.`id` AS 'rfi_fk_initiator_c_mobile_cpn__contact_phone_number_id',
	rfi_fk_initiator_c_mobile_cpn.`contact_id` AS 'rfi_fk_initiator_c_mobile_cpn__contact_id',
	rfi_fk_initiator_c_mobile_cpn.`phone_number_type_id` AS 'rfi_fk_initiator_c_mobile_cpn__phone_number_type_id',
	rfi_fk_initiator_c_mobile_cpn.`country_code` AS 'rfi_fk_initiator_c_mobile_cpn__country_code',
	rfi_fk_initiator_c_mobile_cpn.`area_code` AS 'rfi_fk_initiator_c_mobile_cpn__area_code',
	rfi_fk_initiator_c_mobile_cpn.`prefix` AS 'rfi_fk_initiator_c_mobile_cpn__prefix',
	rfi_fk_initiator_c_mobile_cpn.`number` AS 'rfi_fk_initiator_c_mobile_cpn__number',
	rfi_fk_initiator_c_mobile_cpn.`extension` AS 'rfi_fk_initiator_c_mobile_cpn__extension',
	rfi_fk_initiator_c_mobile_cpn.`itu` AS 'rfi_fk_initiator_c_mobile_cpn__itu',

	rfi_fk_codes__fk_ccd.`id` AS 'rfi_fk_codes__fk_ccd__cost_code_division_id',
	rfi_fk_codes__fk_ccd.`user_company_id` AS 'rfi_fk_codes__fk_ccd__user_company_id',
	rfi_fk_codes__fk_ccd.`cost_code_type_id` AS 'rfi_fk_codes__fk_ccd__cost_code_type_id',
	rfi_fk_codes__fk_ccd.`division_number` AS 'rfi_fk_codes__fk_ccd__division_number',
	rfi_fk_codes__fk_ccd.`division_code_heading` AS 'rfi_fk_codes__fk_ccd__division_code_heading',
	rfi_fk_codes__fk_ccd.`division` AS 'rfi_fk_codes__fk_ccd__division',
	rfi_fk_codes__fk_ccd.`division_abbreviation` AS 'rfi_fk_codes__fk_ccd__division_abbreviation',
	rfi_fk_codes__fk_ccd.`sort_order` AS 'rfi_fk_codes__fk_ccd__sort_order',
	rfi_fk_codes__fk_ccd.`disabled_flag` AS 'rfi_fk_codes__fk_ccd__disabled_flag',

	rfi_fk_creator_c__fk_cc.`id` AS 'rfi_fk_creator_c__fk_cc__contact_company_id',
	rfi_fk_creator_c__fk_cc.`user_user_company_id` AS 'rfi_fk_creator_c__fk_cc__user_user_company_id',
	rfi_fk_creator_c__fk_cc.`contact_user_company_id` AS 'rfi_fk_creator_c__fk_cc__contact_user_company_id',
	rfi_fk_creator_c__fk_cc.`company` AS 'rfi_fk_creator_c__fk_cc__company',
	rfi_fk_creator_c__fk_cc.`primary_phone_number` AS 'rfi_fk_creator_c__fk_cc__primary_phone_number',
	rfi_fk_creator_c__fk_cc.`employer_identification_number` AS 'rfi_fk_creator_c__fk_cc__employer_identification_number',
	rfi_fk_creator_c__fk_cc.`construction_license_number` AS 'rfi_fk_creator_c__fk_cc__construction_license_number',
	rfi_fk_creator_c__fk_cc.`construction_license_number_expiration_date` AS 'rfi_fk_creator_c__fk_cc__construction_license_number_expiration_date',
	rfi_fk_creator_c__fk_cc.`vendor_flag` AS 'rfi_fk_creator_c__fk_cc__vendor_flag',

	rfi_fk_recipient_c_fk_cc.`id` AS 'rfi_fk_recipient_c_fk_cc__contact_company_id',
	rfi_fk_recipient_c_fk_cc.`user_user_company_id` AS 'rfi_fk_recipient_c_fk_cc__user_user_company_id',
	rfi_fk_recipient_c_fk_cc.`contact_user_company_id` AS 'rfi_fk_recipient_c_fk_cc__contact_user_company_id',
	rfi_fk_recipient_c_fk_cc.`company` AS 'rfi_fk_recipient_c_fk_cc__company',
	rfi_fk_recipient_c_fk_cc.`primary_phone_number` AS 'rfi_fk_recipient_c_fk_cc__primary_phone_number',
	rfi_fk_recipient_c_fk_cc.`employer_identification_number` AS 'rfi_fk_recipient_c_fk_cc__employer_identification_number',
	rfi_fk_recipient_c_fk_cc.`construction_license_number` AS 'rfi_fk_recipient_c_fk_cc__construction_license_number',
	rfi_fk_recipient_c_fk_cc.`construction_license_number_expiration_date` AS 'rfi_fk_recipient_c_fk_cc__construction_license_number_expiration_date',
	rfi_fk_recipient_c_fk_cc.`vendor_flag` AS 'rfi_fk_recipient_c_fk_cc__vendor_flag',

	rfi_fk_initiator_c__fk_cc.`id` AS 'rfi_fk_initiator_c__fk_cc__contact_company_id',
	rfi_fk_initiator_c__fk_cc.`user_user_company_id` AS 'rfi_fk_initiator_c__fk_cc__user_user_company_id',
	rfi_fk_initiator_c__fk_cc.`contact_user_company_id` AS 'rfi_fk_initiator_c__fk_cc__contact_user_company_id',
	rfi_fk_initiator_c__fk_cc.`company` AS 'rfi_fk_initiator_c__fk_cc__company',
	rfi_fk_initiator_c__fk_cc.`primary_phone_number` AS 'rfi_fk_initiator_c__fk_cc__primary_phone_number',
	rfi_fk_initiator_c__fk_cc.`employer_identification_number` AS 'rfi_fk_initiator_c__fk_cc__employer_identification_number',
	rfi_fk_initiator_c__fk_cc.`construction_license_number` AS 'rfi_fk_initiator_c__fk_cc__construction_license_number',
	rfi_fk_initiator_c__fk_cc.`construction_license_number_expiration_date` AS 'rfi_fk_initiator_c__fk_cc__construction_license_number_expiration_date',
	rfi_fk_initiator_c__fk_cc.`vendor_flag` AS 'rfi_fk_initiator_c__fk_cc__vendor_flag',

	rfi.*

FROM `requests_for_information` rfi
	INNER JOIN `projects` rfi_fk_p ON rfi.`project_id` = rfi_fk_p.`id`
	INNER JOIN `request_for_information_types` rfi_fk_rfit ON rfi.`request_for_information_type_id` = rfi_fk_rfit.`id`
	INNER JOIN `request_for_information_statuses` rfi_fk_rfis ON rfi.`request_for_information_status_id` = rfi_fk_rfis.`id`
	INNER JOIN `request_for_information_priorities` rfi_fk_rfip ON rfi.`request_for_information_priority_id` = rfi_fk_rfip.`id`
	LEFT OUTER JOIN `file_manager_files` rfi_fk_fmfiles ON rfi.`rfi_file_manager_file_id` = rfi_fk_fmfiles.`id`
	LEFT OUTER JOIN `cost_codes` rfi_fk_codes ON rfi.`rfi_cost_code_id` = rfi_fk_codes.`id`
	INNER JOIN `contacts` rfi_fk_creator_c ON rfi.`rfi_creator_contact_id` = rfi_fk_creator_c.`id`
	LEFT OUTER JOIN `contact_company_offices` rfi_fk_creator_cco ON rfi.`rfi_creator_contact_company_office_id` = rfi_fk_creator_cco.`id`
	LEFT OUTER JOIN `contact_company_office_phone_numbers` rfi_fk_creator_phone_ccopn ON rfi.`rfi_creator_phone_contact_company_office_phone_number_id` = rfi_fk_creator_phone_ccopn.`id`
	LEFT OUTER JOIN `contact_company_office_phone_numbers` rfi_fk_creator_fax_ccopn ON rfi.`rfi_creator_fax_contact_company_office_phone_number_id` = rfi_fk_creator_fax_ccopn.`id`
	LEFT OUTER JOIN `contact_phone_numbers` rfi_fk_creator_c_mobile_cpn ON rfi.`rfi_creator_contact_mobile_phone_number_id` = rfi_fk_creator_c_mobile_cpn.`id`
	LEFT OUTER JOIN `contacts` rfi_fk_recipient_c ON rfi.`rfi_recipient_contact_id` = rfi_fk_recipient_c.`id`
	LEFT OUTER JOIN `contact_company_offices` rfi_fk_recipient_cco ON rfi.`rfi_recipient_contact_company_office_id` = rfi_fk_recipient_cco.`id`
	LEFT OUTER JOIN `contact_company_office_phone_numbers` rfi_fk_recipient_phone_ccopn ON rfi.`rfi_recipient_phone_contact_company_office_phone_number_id` = rfi_fk_recipient_phone_ccopn.`id`
	LEFT OUTER JOIN `contact_company_office_phone_numbers` rfi_fk_recipient_fax_ccopn ON rfi.`rfi_recipient_fax_contact_company_office_phone_number_id` = rfi_fk_recipient_fax_ccopn.`id`
	LEFT OUTER JOIN `contact_phone_numbers` rfi_fk_recipient_c_mobile_cpn ON rfi.`rfi_recipient_contact_mobile_phone_number_id` = rfi_fk_recipient_c_mobile_cpn.`id`
	LEFT OUTER JOIN `contacts` rfi_fk_initiator_c ON rfi.`rfi_initiator_contact_id` = rfi_fk_initiator_c.`id`
	LEFT OUTER JOIN `contact_company_offices` rfi_fk_initiator_cco ON rfi.`rfi_initiator_contact_company_office_id` = rfi_fk_initiator_cco.`id`
	LEFT OUTER JOIN `contact_company_office_phone_numbers` rfi_fk_initiator_phone_ccopn ON rfi.`rfi_initiator_phone_contact_company_office_phone_number_id` = rfi_fk_initiator_phone_ccopn.`id`
	LEFT OUTER JOIN `contact_company_office_phone_numbers` rfi_fk_initiator_fax_ccopn ON rfi.`rfi_initiator_fax_contact_company_office_phone_number_id` = rfi_fk_initiator_fax_ccopn.`id`
	LEFT OUTER JOIN `contact_phone_numbers` rfi_fk_initiator_c_mobile_cpn ON rfi.`rfi_initiator_contact_mobile_phone_number_id` = rfi_fk_initiator_c_mobile_cpn.`id`

	LEFT OUTER JOIN `cost_code_divisions` rfi_fk_codes__fk_ccd ON rfi_fk_codes.`cost_code_division_id` = rfi_fk_codes__fk_ccd.`id`

	INNER JOIN `contact_companies` rfi_fk_creator_c__fk_cc ON rfi_fk_creator_c.`contact_company_id` = rfi_fk_creator_c__fk_cc.`id`
	LEFT OUTER JOIN `contact_companies` rfi_fk_recipient_c_fk_cc ON rfi_fk_recipient_c.`contact_company_id` = rfi_fk_recipient_c_fk_cc.`id`
	LEFT OUTER JOIN `contact_companies` rfi_fk_initiator_c__fk_cc ON rfi_fk_initiator_c.`contact_company_id` = rfi_fk_initiator_c__fk_cc.`id`

WHERE rfi.`id` = ?
";
		$arrValues = array($request_for_information_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$request_for_information_id = $row['id'];
			$requestForInformation = self::instantiateOrm($database, 'RequestForInformation', $row, null, $request_for_information_id);
			/* @var $requestForInformation RequestForInformation */
			$requestForInformation->convertPropertiesToData();

			if (isset($row['project_id'])) {
				$project_id = $row['project_id'];
				$row['rfi_fk_p__id'] = $project_id;
				$project = self::instantiateOrm($database, 'Project', $row, null, $project_id, 'rfi_fk_p__');
				/* @var $project Project */
				$project->convertPropertiesToData();
			} else {
				$project = false;
			}
			$requestForInformation->setProject($project);

			if (isset($row['request_for_information_type_id'])) {
				$request_for_information_type_id = $row['request_for_information_type_id'];
				$row['rfi_fk_rfit__id'] = $request_for_information_type_id;
				$requestForInformationType = self::instantiateOrm($database, 'RequestForInformationType', $row, null, $request_for_information_type_id, 'rfi_fk_rfit__');
				/* @var $requestForInformationType RequestForInformationType */
				$requestForInformationType->convertPropertiesToData();
			} else {
				$requestForInformationType = false;
			}
			$requestForInformation->setRequestForInformationType($requestForInformationType);

			if (isset($row['request_for_information_status_id'])) {
				$request_for_information_status_id = $row['request_for_information_status_id'];
				$row['rfi_fk_rfis__id'] = $request_for_information_status_id;
				$requestForInformationStatus = self::instantiateOrm($database, 'RequestForInformationStatus', $row, null, $request_for_information_status_id, 'rfi_fk_rfis__');
				/* @var $requestForInformationStatus RequestForInformationStatus */
				$requestForInformationStatus->convertPropertiesToData();
			} else {
				$requestForInformationStatus = false;
			}
			$requestForInformation->setRequestForInformationStatus($requestForInformationStatus);

			if (isset($row['request_for_information_priority_id'])) {
				$request_for_information_priority_id = $row['request_for_information_priority_id'];
				$row['rfi_fk_rfip__id'] = $request_for_information_priority_id;
				$requestForInformationPriority = self::instantiateOrm($database, 'RequestForInformationPriority', $row, null, $request_for_information_priority_id, 'rfi_fk_rfip__');
				/* @var $requestForInformationPriority RequestForInformationPriority */
				$requestForInformationPriority->convertPropertiesToData();
			} else {
				$requestForInformationPriority = false;
			}
			$requestForInformation->setRequestForInformationPriority($requestForInformationPriority);

			if (isset($row['rfi_file_manager_file_id'])) {
				$rfi_file_manager_file_id = $row['rfi_file_manager_file_id'];
				$row['rfi_fk_fmfiles__id'] = $rfi_file_manager_file_id;
				$rfiFileManagerFile = self::instantiateOrm($database, 'FileManagerFile', $row, null, $rfi_file_manager_file_id, 'rfi_fk_fmfiles__');
				/* @var $rfiFileManagerFile FileManagerFile */
				$rfiFileManagerFile->convertPropertiesToData();
			} else {
				$rfiFileManagerFile = false;
			}
			$requestForInformation->setRfiFileManagerFile($rfiFileManagerFile);

			if (isset($row['rfi_cost_code_id'])) {
				$rfi_cost_code_id = $row['rfi_cost_code_id'];
				$row['rfi_fk_codes__id'] = $rfi_cost_code_id;
				$rfiCostCode = self::instantiateOrm($database, 'CostCode', $row, null, $rfi_cost_code_id, 'rfi_fk_codes__');
				/* @var $rfiCostCode CostCode */
				$rfiCostCode->convertPropertiesToData();
			} else {
				$rfiCostCode = false;
			}
			$requestForInformation->setRfiCostCode($rfiCostCode);

			if (isset($row['rfi_creator_contact_id'])) {
				$rfi_creator_contact_id = $row['rfi_creator_contact_id'];
				$row['rfi_fk_creator_c__id'] = $rfi_creator_contact_id;
				$rfiCreatorContact = self::instantiateOrm($database, 'Contact', $row, null, $rfi_creator_contact_id, 'rfi_fk_creator_c__');
				/* @var $rfiCreatorContact Contact */
				$rfiCreatorContact->convertPropertiesToData();
			} else {
				$rfiCreatorContact = false;
			}
			$requestForInformation->setRfiCreatorContact($rfiCreatorContact);

			if (isset($row['rfi_creator_contact_company_office_id'])) {
				$rfi_creator_contact_company_office_id = $row['rfi_creator_contact_company_office_id'];
				$row['rfi_fk_creator_cco__id'] = $rfi_creator_contact_company_office_id;
				$rfiCreatorContactCompanyOffice = self::instantiateOrm($database, 'ContactCompanyOffice', $row, null, $rfi_creator_contact_company_office_id, 'rfi_fk_creator_cco__');
				/* @var $rfiCreatorContactCompanyOffice ContactCompanyOffice */
				$rfiCreatorContactCompanyOffice->convertPropertiesToData();
			} else {
				$rfiCreatorContactCompanyOffice = false;
			}
			$requestForInformation->setRfiCreatorContactCompanyOffice($rfiCreatorContactCompanyOffice);

			if (isset($row['rfi_creator_phone_contact_company_office_phone_number_id'])) {
				$rfi_creator_phone_contact_company_office_phone_number_id = $row['rfi_creator_phone_contact_company_office_phone_number_id'];
				$row['rfi_fk_creator_phone_ccopn__id'] = $rfi_creator_phone_contact_company_office_phone_number_id;
				$rfiCreatorPhoneContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $rfi_creator_phone_contact_company_office_phone_number_id, 'rfi_fk_creator_phone_ccopn__');
				/* @var $rfiCreatorPhoneContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$rfiCreatorPhoneContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$rfiCreatorPhoneContactCompanyOfficePhoneNumber = false;
			}
			$requestForInformation->setRfiCreatorPhoneContactCompanyOfficePhoneNumber($rfiCreatorPhoneContactCompanyOfficePhoneNumber);

			if (isset($row['rfi_creator_fax_contact_company_office_phone_number_id'])) {
				$rfi_creator_fax_contact_company_office_phone_number_id = $row['rfi_creator_fax_contact_company_office_phone_number_id'];
				$row['rfi_fk_creator_fax_ccopn__id'] = $rfi_creator_fax_contact_company_office_phone_number_id;
				$rfiCreatorFaxContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $rfi_creator_fax_contact_company_office_phone_number_id, 'rfi_fk_creator_fax_ccopn__');
				/* @var $rfiCreatorFaxContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$rfiCreatorFaxContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$rfiCreatorFaxContactCompanyOfficePhoneNumber = false;
			}
			$requestForInformation->setRfiCreatorFaxContactCompanyOfficePhoneNumber($rfiCreatorFaxContactCompanyOfficePhoneNumber);

			if (isset($row['rfi_creator_contact_mobile_phone_number_id'])) {
				$rfi_creator_contact_mobile_phone_number_id = $row['rfi_creator_contact_mobile_phone_number_id'];
				$row['rfi_fk_creator_c_mobile_cpn__id'] = $rfi_creator_contact_mobile_phone_number_id;
				$rfiCreatorContactMobilePhoneNumber = self::instantiateOrm($database, 'ContactPhoneNumber', $row, null, $rfi_creator_contact_mobile_phone_number_id, 'rfi_fk_creator_c_mobile_cpn__');
				/* @var $rfiCreatorContactMobilePhoneNumber ContactPhoneNumber */
				$rfiCreatorContactMobilePhoneNumber->convertPropertiesToData();
			} else {
				$rfiCreatorContactMobilePhoneNumber = false;
			}
			$requestForInformation->setRfiCreatorContactMobilePhoneNumber($rfiCreatorContactMobilePhoneNumber);

			if (isset($row['rfi_recipient_contact_id'])) {
				$rfi_recipient_contact_id = $row['rfi_recipient_contact_id'];
				$row['rfi_fk_recipient_c__id'] = $rfi_recipient_contact_id;
				$rfiRecipientContact = self::instantiateOrm($database, 'Contact', $row, null, $rfi_recipient_contact_id, 'rfi_fk_recipient_c__');
				/* @var $rfiRecipientContact Contact */
				$rfiRecipientContact->convertPropertiesToData();
			} else {
				$rfiRecipientContact = false;
			}
			$requestForInformation->setRfiRecipientContact($rfiRecipientContact);

			if (isset($row['rfi_recipient_contact_company_office_id'])) {
				$rfi_recipient_contact_company_office_id = $row['rfi_recipient_contact_company_office_id'];
				$row['rfi_fk_recipient_cco__id'] = $rfi_recipient_contact_company_office_id;
				$rfiRecipientContactCompanyOffice = self::instantiateOrm($database, 'ContactCompanyOffice', $row, null, $rfi_recipient_contact_company_office_id, 'rfi_fk_recipient_cco__');
				/* @var $rfiRecipientContactCompanyOffice ContactCompanyOffice */
				$rfiRecipientContactCompanyOffice->convertPropertiesToData();
			} else {
				$rfiRecipientContactCompanyOffice = false;
			}
			$requestForInformation->setRfiRecipientContactCompanyOffice($rfiRecipientContactCompanyOffice);

			if (isset($row['rfi_recipient_phone_contact_company_office_phone_number_id'])) {
				$rfi_recipient_phone_contact_company_office_phone_number_id = $row['rfi_recipient_phone_contact_company_office_phone_number_id'];
				$row['rfi_fk_recipient_phone_ccopn__id'] = $rfi_recipient_phone_contact_company_office_phone_number_id;
				$rfiRecipientPhoneContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $rfi_recipient_phone_contact_company_office_phone_number_id, 'rfi_fk_recipient_phone_ccopn__');
				/* @var $rfiRecipientPhoneContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$rfiRecipientPhoneContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$rfiRecipientPhoneContactCompanyOfficePhoneNumber = false;
			}
			$requestForInformation->setRfiRecipientPhoneContactCompanyOfficePhoneNumber($rfiRecipientPhoneContactCompanyOfficePhoneNumber);

			if (isset($row['rfi_recipient_fax_contact_company_office_phone_number_id'])) {
				$rfi_recipient_fax_contact_company_office_phone_number_id = $row['rfi_recipient_fax_contact_company_office_phone_number_id'];
				$row['rfi_fk_recipient_fax_ccopn__id'] = $rfi_recipient_fax_contact_company_office_phone_number_id;
				$rfiRecipientFaxContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $rfi_recipient_fax_contact_company_office_phone_number_id, 'rfi_fk_recipient_fax_ccopn__');
				/* @var $rfiRecipientFaxContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$rfiRecipientFaxContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$rfiRecipientFaxContactCompanyOfficePhoneNumber = false;
			}
			$requestForInformation->setRfiRecipientFaxContactCompanyOfficePhoneNumber($rfiRecipientFaxContactCompanyOfficePhoneNumber);

			if (isset($row['rfi_recipient_contact_mobile_phone_number_id'])) {
				$rfi_recipient_contact_mobile_phone_number_id = $row['rfi_recipient_contact_mobile_phone_number_id'];
				$row['rfi_fk_recipient_c_mobile_cpn__id'] = $rfi_recipient_contact_mobile_phone_number_id;
				$rfiRecipientContactMobilePhoneNumber = self::instantiateOrm($database, 'ContactPhoneNumber', $row, null, $rfi_recipient_contact_mobile_phone_number_id, 'rfi_fk_recipient_c_mobile_cpn__');
				/* @var $rfiRecipientContactMobilePhoneNumber ContactPhoneNumber */
				$rfiRecipientContactMobilePhoneNumber->convertPropertiesToData();
			} else {
				$rfiRecipientContactMobilePhoneNumber = false;
			}
			$requestForInformation->setRfiRecipientContactMobilePhoneNumber($rfiRecipientContactMobilePhoneNumber);

			if (isset($row['rfi_initiator_contact_id'])) {
				$rfi_initiator_contact_id = $row['rfi_initiator_contact_id'];
				$row['rfi_fk_initiator_c__id'] = $rfi_initiator_contact_id;
				$rfiInitiatorContact = self::instantiateOrm($database, 'Contact', $row, null, $rfi_initiator_contact_id, 'rfi_fk_initiator_c__');
				/* @var $rfiInitiatorContact Contact */
				$rfiInitiatorContact->convertPropertiesToData();
			} else {
				$rfiInitiatorContact = false;
			}
			$requestForInformation->setRfiInitiatorContact($rfiInitiatorContact);

			if (isset($row['rfi_initiator_contact_company_office_id'])) {
				$rfi_initiator_contact_company_office_id = $row['rfi_initiator_contact_company_office_id'];
				$row['rfi_fk_initiator_cco__id'] = $rfi_initiator_contact_company_office_id;
				$rfiInitiatorContactCompanyOffice = self::instantiateOrm($database, 'ContactCompanyOffice', $row, null, $rfi_initiator_contact_company_office_id, 'rfi_fk_initiator_cco__');
				/* @var $rfiInitiatorContactCompanyOffice ContactCompanyOffice */
				$rfiInitiatorContactCompanyOffice->convertPropertiesToData();
			} else {
				$rfiInitiatorContactCompanyOffice = false;
			}
			$requestForInformation->setRfiInitiatorContactCompanyOffice($rfiInitiatorContactCompanyOffice);

			if (isset($row['rfi_initiator_phone_contact_company_office_phone_number_id'])) {
				$rfi_initiator_phone_contact_company_office_phone_number_id = $row['rfi_initiator_phone_contact_company_office_phone_number_id'];
				$row['rfi_fk_initiator_phone_ccopn__id'] = $rfi_initiator_phone_contact_company_office_phone_number_id;
				$rfiInitiatorPhoneContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $rfi_initiator_phone_contact_company_office_phone_number_id, 'rfi_fk_initiator_phone_ccopn__');
				/* @var $rfiInitiatorPhoneContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$rfiInitiatorPhoneContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$rfiInitiatorPhoneContactCompanyOfficePhoneNumber = false;
			}
			$requestForInformation->setRfiInitiatorPhoneContactCompanyOfficePhoneNumber($rfiInitiatorPhoneContactCompanyOfficePhoneNumber);

			if (isset($row['rfi_initiator_fax_contact_company_office_phone_number_id'])) {
				$rfi_initiator_fax_contact_company_office_phone_number_id = $row['rfi_initiator_fax_contact_company_office_phone_number_id'];
				$row['rfi_fk_initiator_fax_ccopn__id'] = $rfi_initiator_fax_contact_company_office_phone_number_id;
				$rfiInitiatorFaxContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $rfi_initiator_fax_contact_company_office_phone_number_id, 'rfi_fk_initiator_fax_ccopn__');
				/* @var $rfiInitiatorFaxContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$rfiInitiatorFaxContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$rfiInitiatorFaxContactCompanyOfficePhoneNumber = false;
			}
			$requestForInformation->setRfiInitiatorFaxContactCompanyOfficePhoneNumber($rfiInitiatorFaxContactCompanyOfficePhoneNumber);

			if (isset($row['rfi_initiator_contact_mobile_phone_number_id'])) {
				$rfi_initiator_contact_mobile_phone_number_id = $row['rfi_initiator_contact_mobile_phone_number_id'];
				$row['rfi_fk_initiator_c_mobile_cpn__id'] = $rfi_initiator_contact_mobile_phone_number_id;
				$rfiInitiatorContactMobilePhoneNumber = self::instantiateOrm($database, 'ContactPhoneNumber', $row, null, $rfi_initiator_contact_mobile_phone_number_id, 'rfi_fk_initiator_c_mobile_cpn__');
				/* @var $rfiInitiatorContactMobilePhoneNumber ContactPhoneNumber */
				$rfiInitiatorContactMobilePhoneNumber->convertPropertiesToData();
			} else {
				$rfiInitiatorContactMobilePhoneNumber = false;
			}
			$requestForInformation->setRfiInitiatorContactMobilePhoneNumber($rfiInitiatorContactMobilePhoneNumber);

			// Extra: RFI Cost Code - Cost Code Division
			if (isset($row['rfi_fk_codes__fk_ccd__cost_code_division_id'])) {
				$cost_code_division_id = $row['rfi_fk_codes__fk_ccd__cost_code_division_id'];
				$row['rfi_fk_codes__fk_ccd__id'] = $cost_code_division_id;
				$rfiCostCodeDivision = self::instantiateOrm($database, 'CostCodeDivision', $row, null, $cost_code_division_id, 'rfi_fk_codes__fk_ccd__');
				/* @var $rfiCostCodeDivision CostCodeDivision */
				$rfiCostCodeDivision->convertPropertiesToData();
			} else {
				$rfiCostCodeDivision = false;
			}
			if ($rfiCostCode) {
				$rfiCostCode->setCostCodeDivision($rfiCostCodeDivision);
			}

			// Extra: RFI Creator - Contact Company
			if (isset($row['rfi_fk_creator_c__fk_cc__contact_company_id'])) {
				$rfi_creator_contact_company_id = $row['rfi_fk_creator_c__fk_cc__contact_company_id'];
				$row['rfi_fk_creator_c__fk_cc__id'] = $rfi_creator_contact_company_id;
				$rfiCreatorContactCompany = self::instantiateOrm($database, 'ContactCompany', $row, null, $rfi_creator_contact_company_id, 'rfi_fk_creator_c__fk_cc__');
				/* @var $rfiCreatorContactCompany ContactCompany */
				$rfiCreatorContactCompany->convertPropertiesToData();
			} else {
				$rfiCreatorContactCompany = false;
			}
			if ($rfiCreatorContact) {
				$rfiCreatorContact->setContactCompany($rfiCreatorContactCompany);
			}

			// Extra: RFI Recipient - Contact Company
			if (isset($row['rfi_fk_recipient_c_fk_cc__contact_company_id'])) {
				$rfi_recipient_contact_company_id = $row['rfi_fk_recipient_c_fk_cc__contact_company_id'];
				$row['rfi_fk_recipient_c_fk_cc__id'] = $rfi_recipient_contact_company_id;
				$rfiRecipientContactCompany = self::instantiateOrm($database, 'ContactCompany', $row, null, $rfi_recipient_contact_company_id, 'rfi_fk_recipient_c_fk_cc__');
				/* @var $rfiRecipientContactCompany ContactCompany */
				$rfiRecipientContactCompany->convertPropertiesToData();
			} else {
				$rfiRecipientContactCompany = false;
			}
			if ($rfiRecipientContact) {
				$rfiRecipientContact->setContactCompany($rfiRecipientContactCompany);
			}

			// Extra: RFI Initiator - Contact Company
			if (isset($row['rfi_fk_initiator_c_fk_cc__contact_company_id'])) {
				$rfi_initiator_contact_company_id = $row['rfi_fk_initiator_c_fk_cc__contact_company_id'];
				$row['rfi_fk_initiator_c_fk_cc__id'] = $rfi_initiator_contact_company_id;
				$rfiInitiatorContactCompany = self::instantiateOrm($database, 'ContactCompany', $row, null, $rfi_initiator_contact_company_id, 'rfi_fk_initiator_c_fk_cc__');
				/* @var $rfiInitiatorContactCompany ContactCompany */
				$rfiInitiatorContactCompany->convertPropertiesToData();
			} else {
				$rfiInitiatorContactCompany = false;
			}
			if ($rfiInitiatorContact) {
				$rfiInitiatorContact->setContactCompany($rfiInitiatorContactCompany);
			}

			return $requestForInformation;
		} else {
			return false;
		}
	}

	// Finders: Find By Unique Index
	/**
	 * Find by unique index `unique_rfi` (`project_id`,`rfi_sequence_number`) comment 'One Project can have many RFIs with a sequence number.'.
	 *
	 * @param string $database
	 * @param int $project_id
	 * @param int $rfi_sequence_number
	 * @return mixed (single ORM object | false)
	 */
	public static function findByProjectIdAndRfiSequenceNumber($database, $project_id, $rfi_sequence_number)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	rfi.*

FROM `requests_for_information` rfi
WHERE rfi.`project_id` = ?
AND rfi.`rfi_sequence_number` = ?
";
		$arrValues = array($project_id, $rfi_sequence_number);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if ($row && !empty($row)) {
			$request_for_information_id = $row['id'];
			$requestForInformation = self::instantiateOrm($database, 'RequestForInformation', $row, null, $request_for_information_id);
			/* @var $requestForInformation RequestForInformation */
			return $requestForInformation;
		} else {
			return false;
		}
	}

	// Loaders: Load By pk List (list of auto int ids or other non auto int pk list)
	/**
	 * Load zero or more records by an id list (array of auto int primary keys).
	 *
	 * @param string $database
	 * @param array $arrRequestForInformationIds
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadRequestsForInformationByArrRequestForInformationIds($database, $arrRequestForInformationIds, Input $options=null)
	{
		if (empty($arrRequestForInformationIds)) {
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
		// ORDER BY `id` ASC, `project_id` ASC, `rfi_sequence_number` ASC, `request_for_information_type_id` ASC, `request_for_information_status_id` ASC, `request_for_information_priority_id` ASC, `rfi_file_manager_file_id` ASC, `rfi_cost_code_id` ASC, `rfi_creator_contact_id` ASC, `rfi_creator_contact_company_office_id` ASC, `rfi_creator_phone_contact_company_office_phone_number_id` ASC, `rfi_creator_fax_contact_company_office_phone_number_id` ASC, `rfi_creator_contact_mobile_phone_number_id` ASC, `rfi_recipient_contact_id` ASC, `rfi_recipient_contact_company_office_id` ASC, `rfi_recipient_phone_contact_company_office_phone_number_id` ASC, `rfi_recipient_fax_contact_company_office_phone_number_id` ASC, `rfi_recipient_contact_mobile_phone_number_id` ASC, `rfi_initiator_contact_id` ASC, `rfi_initiator_contact_company_office_id` ASC, `rfi_initiator_phone_contact_company_office_phone_number_id` ASC, `rfi_initiator_fax_contact_company_office_phone_number_id` ASC, `rfi_initiator_contact_mobile_phone_number_id` ASC, `rfi_title` ASC, `rfi_plan_page_reference` ASC, `rfi_statement` ASC, `created` ASC, `rfi_due_date` ASC, `rfi_closed_date` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpRequestForInformation = new RequestForInformation($database);
			$sqlOrderByColumns = $tmpRequestForInformation->constructSqlOrderByColumns($arrOrderByAttributes);

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

		foreach ($arrRequestForInformationIds as $k => $request_for_information_id) {
			$request_for_information_id = (int) $request_for_information_id;
			$arrRequestForInformationIds[$k] = $db->escape($request_for_information_id);
		}
		$csvRequestForInformationIds = join(',', $arrRequestForInformationIds);

		$query =
"
SELECT

	rfi.*

FROM `requests_for_information` rfi
WHERE rfi.`id` IN ($csvRequestForInformationIds){$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		$arrRequestsForInformationByCsvRequestForInformationIds = array();
		while ($row = $db->fetch()) {
			$request_for_information_id = $row['id'];
			$requestForInformation = self::instantiateOrm($database, 'RequestForInformation', $row, null, $request_for_information_id);
			/* @var $requestForInformation RequestForInformation */
			$requestForInformation->convertPropertiesToData();

			$arrRequestsForInformationByCsvRequestForInformationIds[$request_for_information_id] = $requestForInformation;
		}

		$db->free_result();

		return $arrRequestsForInformationByCsvRequestForInformationIds;
	}

	// Count open Rfi
	public static function countOpenRfi($database, $project_id)
	{
		$db = DBI::getInstance($database);
		$query =
"
SELECT
	count(*) as count

FROM `requests_for_information` rfi
WHERE rfi.`project_id` = ? AND rfi.`request_for_information_status_id` = 2
";
		$arrValues = array($project_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$count = $row['count'];
		$db->free_result();
		return $count;
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `requests_for_information_fk_p` foreign key (`project_id`) references `projects` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $project_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadRequestsForInformationByProjectId($database, $project_id, Input $options=null)
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
			self::$_arrRequestsForInformationByProjectId = null;
		}

		$arrRequestsForInformationByProjectId = self::$_arrRequestsForInformationByProjectId;
		if (isset($arrRequestsForInformationByProjectId) && !empty($arrRequestsForInformationByProjectId)) {
			return $arrRequestsForInformationByProjectId;
		}

		$project_id = (int) $project_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `rfi_sequence_number` ASC, `request_for_information_type_id` ASC, `request_for_information_status_id` ASC, `request_for_information_priority_id` ASC, `rfi_file_manager_file_id` ASC, `rfi_cost_code_id` ASC, `rfi_creator_contact_id` ASC, `rfi_creator_contact_company_office_id` ASC, `rfi_creator_phone_contact_company_office_phone_number_id` ASC, `rfi_creator_fax_contact_company_office_phone_number_id` ASC, `rfi_creator_contact_mobile_phone_number_id` ASC, `rfi_recipient_contact_id` ASC, `rfi_recipient_contact_company_office_id` ASC, `rfi_recipient_phone_contact_company_office_phone_number_id` ASC, `rfi_recipient_fax_contact_company_office_phone_number_id` ASC, `rfi_recipient_contact_mobile_phone_number_id` ASC, `rfi_initiator_contact_id` ASC, `rfi_initiator_contact_company_office_id` ASC, `rfi_initiator_phone_contact_company_office_phone_number_id` ASC, `rfi_initiator_fax_contact_company_office_phone_number_id` ASC, `rfi_initiator_contact_mobile_phone_number_id` ASC, `rfi_title` ASC, `rfi_plan_page_reference` ASC, `rfi_statement` ASC, `created` ASC, `rfi_due_date` ASC, `rfi_closed_date` ASC
		$sqlOrderBy = "\nORDER BY `created` DESC, `rfi_sequence_number` DESC, `request_for_information_priority_id` ASC, `request_for_information_type_id` ASC, `request_for_information_status_id` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpRequestForInformation = new RequestForInformation($database);
			$sqlOrderByColumns = $tmpRequestForInformation->constructSqlOrderByColumns($arrOrderByAttributes);

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

	rfi_fk_p.`id` AS 'rfi_fk_p__project_id',
	rfi_fk_p.`project_type_id` AS 'rfi_fk_p__project_type_id',
	rfi_fk_p.`user_company_id` AS 'rfi_fk_p__user_company_id',
	rfi_fk_p.`user_custom_project_id` AS 'rfi_fk_p__user_custom_project_id',
	rfi_fk_p.`project_name` AS 'rfi_fk_p__project_name',
	rfi_fk_p.`project_owner_name` AS 'rfi_fk_p__project_owner_name',
	rfi_fk_p.`latitude` AS 'rfi_fk_p__latitude',
	rfi_fk_p.`longitude` AS 'rfi_fk_p__longitude',
	rfi_fk_p.`address_line_1` AS 'rfi_fk_p__address_line_1',
	rfi_fk_p.`address_line_2` AS 'rfi_fk_p__address_line_2',
	rfi_fk_p.`address_line_3` AS 'rfi_fk_p__address_line_3',
	rfi_fk_p.`address_line_4` AS 'rfi_fk_p__address_line_4',
	rfi_fk_p.`address_city` AS 'rfi_fk_p__address_city',
	rfi_fk_p.`address_county` AS 'rfi_fk_p__address_county',
	rfi_fk_p.`address_state_or_region` AS 'rfi_fk_p__address_state_or_region',
	rfi_fk_p.`address_postal_code` AS 'rfi_fk_p__address_postal_code',
	rfi_fk_p.`address_postal_code_extension` AS 'rfi_fk_p__address_postal_code_extension',
	rfi_fk_p.`address_country` AS 'rfi_fk_p__address_country',
	rfi_fk_p.`building_count` AS 'rfi_fk_p__building_count',
	rfi_fk_p.`unit_count` AS 'rfi_fk_p__unit_count',
	rfi_fk_p.`gross_square_footage` AS 'rfi_fk_p__gross_square_footage',
	rfi_fk_p.`net_rentable_square_footage` AS 'rfi_fk_p__net_rentable_square_footage',
	rfi_fk_p.`is_active_flag` AS 'rfi_fk_p__is_active_flag',
	rfi_fk_p.`public_plans_flag` AS 'rfi_fk_p__public_plans_flag',
	rfi_fk_p.`prevailing_wage_flag` AS 'rfi_fk_p__prevailing_wage_flag',
	rfi_fk_p.`city_business_license_required_flag` AS 'rfi_fk_p__city_business_license_required_flag',
	rfi_fk_p.`is_internal_flag` AS 'rfi_fk_p__is_internal_flag',
	rfi_fk_p.`project_contract_date` AS 'rfi_fk_p__project_contract_date',
	rfi_fk_p.`project_start_date` AS 'rfi_fk_p__project_start_date',
	rfi_fk_p.`project_completed_date` AS 'rfi_fk_p__project_completed_date',
	rfi_fk_p.`sort_order` AS 'rfi_fk_p__sort_order',

	rfi_fk_rfit.`id` AS 'rfi_fk_rfit__request_for_information_type_id',
	rfi_fk_rfit.`request_for_information_type` AS 'rfi_fk_rfit__request_for_information_type',
	rfi_fk_rfit.`disabled_flag` AS 'rfi_fk_rfit__disabled_flag',

	rfi_fk_rfis.`id` AS 'rfi_fk_rfis__request_for_information_status_id',
	rfi_fk_rfis.`request_for_information_status` AS 'rfi_fk_rfis__request_for_information_status',
	rfi_fk_rfis.`disabled_flag` AS 'rfi_fk_rfis__disabled_flag',

	rfi_fk_rfip.`id` AS 'rfi_fk_rfip__request_for_information_priority_id',
	rfi_fk_rfip.`request_for_information_priority` AS 'rfi_fk_rfip__request_for_information_priority',
	rfi_fk_rfip.`disabled_flag` AS 'rfi_fk_rfip__disabled_flag',

	rfi_fk_fmfiles.`id` AS 'rfi_fk_fmfiles__file_manager_file_id',
	rfi_fk_fmfiles.`user_company_id` AS 'rfi_fk_fmfiles__user_company_id',
	rfi_fk_fmfiles.`contact_id` AS 'rfi_fk_fmfiles__contact_id',
	rfi_fk_fmfiles.`project_id` AS 'rfi_fk_fmfiles__project_id',
	rfi_fk_fmfiles.`file_manager_folder_id` AS 'rfi_fk_fmfiles__file_manager_folder_id',
	rfi_fk_fmfiles.`file_location_id` AS 'rfi_fk_fmfiles__file_location_id',
	rfi_fk_fmfiles.`virtual_file_name` AS 'rfi_fk_fmfiles__virtual_file_name',
	rfi_fk_fmfiles.`version_number` AS 'rfi_fk_fmfiles__version_number',
	rfi_fk_fmfiles.`virtual_file_name_sha1` AS 'rfi_fk_fmfiles__virtual_file_name_sha1',
	rfi_fk_fmfiles.`virtual_file_mime_type` AS 'rfi_fk_fmfiles__virtual_file_mime_type',
	rfi_fk_fmfiles.`modified` AS 'rfi_fk_fmfiles__modified',
	rfi_fk_fmfiles.`created` AS 'rfi_fk_fmfiles__created',
	rfi_fk_fmfiles.`deleted_flag` AS 'rfi_fk_fmfiles__deleted_flag',
	rfi_fk_fmfiles.`directly_deleted_flag` AS 'rfi_fk_fmfiles__directly_deleted_flag',

	rfi_fk_codes.`id` AS 'rfi_fk_codes__cost_code_id',
	rfi_fk_codes.`cost_code_division_id` AS 'rfi_fk_codes__cost_code_division_id',
	rfi_fk_codes.`cost_code` AS 'rfi_fk_codes__cost_code',
	rfi_fk_codes.`cost_code_description` AS 'rfi_fk_codes__cost_code_description',
	rfi_fk_codes.`cost_code_description_abbreviation` AS 'rfi_fk_codes__cost_code_description_abbreviation',
	rfi_fk_codes.`sort_order` AS 'rfi_fk_codes__sort_order',
	rfi_fk_codes.`disabled_flag` AS 'rfi_fk_codes__disabled_flag',

	rfi_fk_creator_c.`id` AS 'rfi_fk_creator_c__contact_id',
	rfi_fk_creator_c.`user_company_id` AS 'rfi_fk_creator_c__user_company_id',
	rfi_fk_creator_c.`user_id` AS 'rfi_fk_creator_c__user_id',
	rfi_fk_creator_c.`contact_company_id` AS 'rfi_fk_creator_c__contact_company_id',
	rfi_fk_creator_c.`email` AS 'rfi_fk_creator_c__email',
	rfi_fk_creator_c.`name_prefix` AS 'rfi_fk_creator_c__name_prefix',
	rfi_fk_creator_c.`first_name` AS 'rfi_fk_creator_c__first_name',
	rfi_fk_creator_c.`additional_name` AS 'rfi_fk_creator_c__additional_name',
	rfi_fk_creator_c.`middle_name` AS 'rfi_fk_creator_c__middle_name',
	rfi_fk_creator_c.`last_name` AS 'rfi_fk_creator_c__last_name',
	rfi_fk_creator_c.`name_suffix` AS 'rfi_fk_creator_c__name_suffix',
	rfi_fk_creator_c.`title` AS 'rfi_fk_creator_c__title',
	rfi_fk_creator_c.`vendor_flag` AS 'rfi_fk_creator_c__vendor_flag',
	rfi_fk_creator_c.`is_archive` AS 'rfi_fk_creator_c__is_archive',

	rfi_fk_creator_cco.`id` AS 'rfi_fk_creator_cco__contact_company_office_id',
	rfi_fk_creator_cco.`contact_company_id` AS 'rfi_fk_creator_cco__contact_company_id',
	rfi_fk_creator_cco.`office_nickname` AS 'rfi_fk_creator_cco__office_nickname',
	rfi_fk_creator_cco.`address_line_1` AS 'rfi_fk_creator_cco__address_line_1',
	rfi_fk_creator_cco.`address_line_2` AS 'rfi_fk_creator_cco__address_line_2',
	rfi_fk_creator_cco.`address_line_3` AS 'rfi_fk_creator_cco__address_line_3',
	rfi_fk_creator_cco.`address_line_4` AS 'rfi_fk_creator_cco__address_line_4',
	rfi_fk_creator_cco.`address_city` AS 'rfi_fk_creator_cco__address_city',
	rfi_fk_creator_cco.`address_county` AS 'rfi_fk_creator_cco__address_county',
	rfi_fk_creator_cco.`address_state_or_region` AS 'rfi_fk_creator_cco__address_state_or_region',
	rfi_fk_creator_cco.`address_postal_code` AS 'rfi_fk_creator_cco__address_postal_code',
	rfi_fk_creator_cco.`address_postal_code_extension` AS 'rfi_fk_creator_cco__address_postal_code_extension',
	rfi_fk_creator_cco.`address_country` AS 'rfi_fk_creator_cco__address_country',
	rfi_fk_creator_cco.`head_quarters_flag` AS 'rfi_fk_creator_cco__head_quarters_flag',
	rfi_fk_creator_cco.`address_validated_by_user_flag` AS 'rfi_fk_creator_cco__address_validated_by_user_flag',
	rfi_fk_creator_cco.`address_validated_by_web_service_flag` AS 'rfi_fk_creator_cco__address_validated_by_web_service_flag',
	rfi_fk_creator_cco.`address_validation_by_web_service_error_flag` AS 'rfi_fk_creator_cco__address_validation_by_web_service_error_flag',

	rfi_fk_creator_phone_ccopn.`id` AS 'rfi_fk_creator_phone_ccopn__contact_company_office_phone_number_id',
	rfi_fk_creator_phone_ccopn.`contact_company_office_id` AS 'rfi_fk_creator_phone_ccopn__contact_company_office_id',
	rfi_fk_creator_phone_ccopn.`phone_number_type_id` AS 'rfi_fk_creator_phone_ccopn__phone_number_type_id',
	rfi_fk_creator_phone_ccopn.`country_code` AS 'rfi_fk_creator_phone_ccopn__country_code',
	rfi_fk_creator_phone_ccopn.`area_code` AS 'rfi_fk_creator_phone_ccopn__area_code',
	rfi_fk_creator_phone_ccopn.`prefix` AS 'rfi_fk_creator_phone_ccopn__prefix',
	rfi_fk_creator_phone_ccopn.`number` AS 'rfi_fk_creator_phone_ccopn__number',
	rfi_fk_creator_phone_ccopn.`extension` AS 'rfi_fk_creator_phone_ccopn__extension',
	rfi_fk_creator_phone_ccopn.`itu` AS 'rfi_fk_creator_phone_ccopn__itu',

	rfi_fk_creator_fax_ccopn.`id` AS 'rfi_fk_creator_fax_ccopn__contact_company_office_phone_number_id',
	rfi_fk_creator_fax_ccopn.`contact_company_office_id` AS 'rfi_fk_creator_fax_ccopn__contact_company_office_id',
	rfi_fk_creator_fax_ccopn.`phone_number_type_id` AS 'rfi_fk_creator_fax_ccopn__phone_number_type_id',
	rfi_fk_creator_fax_ccopn.`country_code` AS 'rfi_fk_creator_fax_ccopn__country_code',
	rfi_fk_creator_fax_ccopn.`area_code` AS 'rfi_fk_creator_fax_ccopn__area_code',
	rfi_fk_creator_fax_ccopn.`prefix` AS 'rfi_fk_creator_fax_ccopn__prefix',
	rfi_fk_creator_fax_ccopn.`number` AS 'rfi_fk_creator_fax_ccopn__number',
	rfi_fk_creator_fax_ccopn.`extension` AS 'rfi_fk_creator_fax_ccopn__extension',
	rfi_fk_creator_fax_ccopn.`itu` AS 'rfi_fk_creator_fax_ccopn__itu',

	rfi_fk_creator_c_mobile_cpn.`id` AS 'rfi_fk_creator_c_mobile_cpn__contact_phone_number_id',
	rfi_fk_creator_c_mobile_cpn.`contact_id` AS 'rfi_fk_creator_c_mobile_cpn__contact_id',
	rfi_fk_creator_c_mobile_cpn.`phone_number_type_id` AS 'rfi_fk_creator_c_mobile_cpn__phone_number_type_id',
	rfi_fk_creator_c_mobile_cpn.`country_code` AS 'rfi_fk_creator_c_mobile_cpn__country_code',
	rfi_fk_creator_c_mobile_cpn.`area_code` AS 'rfi_fk_creator_c_mobile_cpn__area_code',
	rfi_fk_creator_c_mobile_cpn.`prefix` AS 'rfi_fk_creator_c_mobile_cpn__prefix',
	rfi_fk_creator_c_mobile_cpn.`number` AS 'rfi_fk_creator_c_mobile_cpn__number',
	rfi_fk_creator_c_mobile_cpn.`extension` AS 'rfi_fk_creator_c_mobile_cpn__extension',
	rfi_fk_creator_c_mobile_cpn.`itu` AS 'rfi_fk_creator_c_mobile_cpn__itu',

	rfi_fk_recipient_c.`id` AS 'rfi_fk_recipient_c__contact_id',
	rfi_fk_recipient_c.`user_company_id` AS 'rfi_fk_recipient_c__user_company_id',
	rfi_fk_recipient_c.`user_id` AS 'rfi_fk_recipient_c__user_id',
	rfi_fk_recipient_c.`contact_company_id` AS 'rfi_fk_recipient_c__contact_company_id',
	rfi_fk_recipient_c.`email` AS 'rfi_fk_recipient_c__email',
	rfi_fk_recipient_c.`name_prefix` AS 'rfi_fk_recipient_c__name_prefix',
	rfi_fk_recipient_c.`first_name` AS 'rfi_fk_recipient_c__first_name',
	rfi_fk_recipient_c.`additional_name` AS 'rfi_fk_recipient_c__additional_name',
	rfi_fk_recipient_c.`middle_name` AS 'rfi_fk_recipient_c__middle_name',
	rfi_fk_recipient_c.`last_name` AS 'rfi_fk_recipient_c__last_name',
	rfi_fk_recipient_c.`name_suffix` AS 'rfi_fk_recipient_c__name_suffix',
	rfi_fk_recipient_c.`title` AS 'rfi_fk_recipient_c__title',
	rfi_fk_recipient_c.`vendor_flag` AS 'rfi_fk_recipient_c__vendor_flag',
	rfi_fk_recipient_c.`is_archive` AS 'rfi_fk_recipient_c__is_archive',

	rfi_fk_recipient_cco.`id` AS 'rfi_fk_recipient_cco__contact_company_office_id',
	rfi_fk_recipient_cco.`contact_company_id` AS 'rfi_fk_recipient_cco__contact_company_id',
	rfi_fk_recipient_cco.`office_nickname` AS 'rfi_fk_recipient_cco__office_nickname',
	rfi_fk_recipient_cco.`address_line_1` AS 'rfi_fk_recipient_cco__address_line_1',
	rfi_fk_recipient_cco.`address_line_2` AS 'rfi_fk_recipient_cco__address_line_2',
	rfi_fk_recipient_cco.`address_line_3` AS 'rfi_fk_recipient_cco__address_line_3',
	rfi_fk_recipient_cco.`address_line_4` AS 'rfi_fk_recipient_cco__address_line_4',
	rfi_fk_recipient_cco.`address_city` AS 'rfi_fk_recipient_cco__address_city',
	rfi_fk_recipient_cco.`address_county` AS 'rfi_fk_recipient_cco__address_county',
	rfi_fk_recipient_cco.`address_state_or_region` AS 'rfi_fk_recipient_cco__address_state_or_region',
	rfi_fk_recipient_cco.`address_postal_code` AS 'rfi_fk_recipient_cco__address_postal_code',
	rfi_fk_recipient_cco.`address_postal_code_extension` AS 'rfi_fk_recipient_cco__address_postal_code_extension',
	rfi_fk_recipient_cco.`address_country` AS 'rfi_fk_recipient_cco__address_country',
	rfi_fk_recipient_cco.`head_quarters_flag` AS 'rfi_fk_recipient_cco__head_quarters_flag',
	rfi_fk_recipient_cco.`address_validated_by_user_flag` AS 'rfi_fk_recipient_cco__address_validated_by_user_flag',
	rfi_fk_recipient_cco.`address_validated_by_web_service_flag` AS 'rfi_fk_recipient_cco__address_validated_by_web_service_flag',
	rfi_fk_recipient_cco.`address_validation_by_web_service_error_flag` AS 'rfi_fk_recipient_cco__address_validation_by_web_service_error_flag',

	rfi_fk_recipient_phone_ccopn.`id` AS 'rfi_fk_recipient_phone_ccopn__contact_company_office_phone_number_id',
	rfi_fk_recipient_phone_ccopn.`contact_company_office_id` AS 'rfi_fk_recipient_phone_ccopn__contact_company_office_id',
	rfi_fk_recipient_phone_ccopn.`phone_number_type_id` AS 'rfi_fk_recipient_phone_ccopn__phone_number_type_id',
	rfi_fk_recipient_phone_ccopn.`country_code` AS 'rfi_fk_recipient_phone_ccopn__country_code',
	rfi_fk_recipient_phone_ccopn.`area_code` AS 'rfi_fk_recipient_phone_ccopn__area_code',
	rfi_fk_recipient_phone_ccopn.`prefix` AS 'rfi_fk_recipient_phone_ccopn__prefix',
	rfi_fk_recipient_phone_ccopn.`number` AS 'rfi_fk_recipient_phone_ccopn__number',
	rfi_fk_recipient_phone_ccopn.`extension` AS 'rfi_fk_recipient_phone_ccopn__extension',
	rfi_fk_recipient_phone_ccopn.`itu` AS 'rfi_fk_recipient_phone_ccopn__itu',

	rfi_fk_recipient_fax_ccopn.`id` AS 'rfi_fk_recipient_fax_ccopn__contact_company_office_phone_number_id',
	rfi_fk_recipient_fax_ccopn.`contact_company_office_id` AS 'rfi_fk_recipient_fax_ccopn__contact_company_office_id',
	rfi_fk_recipient_fax_ccopn.`phone_number_type_id` AS 'rfi_fk_recipient_fax_ccopn__phone_number_type_id',
	rfi_fk_recipient_fax_ccopn.`country_code` AS 'rfi_fk_recipient_fax_ccopn__country_code',
	rfi_fk_recipient_fax_ccopn.`area_code` AS 'rfi_fk_recipient_fax_ccopn__area_code',
	rfi_fk_recipient_fax_ccopn.`prefix` AS 'rfi_fk_recipient_fax_ccopn__prefix',
	rfi_fk_recipient_fax_ccopn.`number` AS 'rfi_fk_recipient_fax_ccopn__number',
	rfi_fk_recipient_fax_ccopn.`extension` AS 'rfi_fk_recipient_fax_ccopn__extension',
	rfi_fk_recipient_fax_ccopn.`itu` AS 'rfi_fk_recipient_fax_ccopn__itu',

	rfi_fk_recipient_c_mobile_cpn.`id` AS 'rfi_fk_recipient_c_mobile_cpn__contact_phone_number_id',
	rfi_fk_recipient_c_mobile_cpn.`contact_id` AS 'rfi_fk_recipient_c_mobile_cpn__contact_id',
	rfi_fk_recipient_c_mobile_cpn.`phone_number_type_id` AS 'rfi_fk_recipient_c_mobile_cpn__phone_number_type_id',
	rfi_fk_recipient_c_mobile_cpn.`country_code` AS 'rfi_fk_recipient_c_mobile_cpn__country_code',
	rfi_fk_recipient_c_mobile_cpn.`area_code` AS 'rfi_fk_recipient_c_mobile_cpn__area_code',
	rfi_fk_recipient_c_mobile_cpn.`prefix` AS 'rfi_fk_recipient_c_mobile_cpn__prefix',
	rfi_fk_recipient_c_mobile_cpn.`number` AS 'rfi_fk_recipient_c_mobile_cpn__number',
	rfi_fk_recipient_c_mobile_cpn.`extension` AS 'rfi_fk_recipient_c_mobile_cpn__extension',
	rfi_fk_recipient_c_mobile_cpn.`itu` AS 'rfi_fk_recipient_c_mobile_cpn__itu',

	rfi_fk_initiator_c.`id` AS 'rfi_fk_initiator_c__contact_id',
	rfi_fk_initiator_c.`user_company_id` AS 'rfi_fk_initiator_c__user_company_id',
	rfi_fk_initiator_c.`user_id` AS 'rfi_fk_initiator_c__user_id',
	rfi_fk_initiator_c.`contact_company_id` AS 'rfi_fk_initiator_c__contact_company_id',
	rfi_fk_initiator_c.`email` AS 'rfi_fk_initiator_c__email',
	rfi_fk_initiator_c.`name_prefix` AS 'rfi_fk_initiator_c__name_prefix',
	rfi_fk_initiator_c.`first_name` AS 'rfi_fk_initiator_c__first_name',
	rfi_fk_initiator_c.`additional_name` AS 'rfi_fk_initiator_c__additional_name',
	rfi_fk_initiator_c.`middle_name` AS 'rfi_fk_initiator_c__middle_name',
	rfi_fk_initiator_c.`last_name` AS 'rfi_fk_initiator_c__last_name',
	rfi_fk_initiator_c.`name_suffix` AS 'rfi_fk_initiator_c__name_suffix',
	rfi_fk_initiator_c.`title` AS 'rfi_fk_initiator_c__title',
	rfi_fk_initiator_c.`vendor_flag` AS 'rfi_fk_initiator_c__vendor_flag',
	rfi_fk_initiator_c.`is_archive` AS 'rfi_fk_initiator_c__is_archive',

	rfi_fk_initiator_cco.`id` AS 'rfi_fk_initiator_cco__contact_company_office_id',
	rfi_fk_initiator_cco.`contact_company_id` AS 'rfi_fk_initiator_cco__contact_company_id',
	rfi_fk_initiator_cco.`office_nickname` AS 'rfi_fk_initiator_cco__office_nickname',
	rfi_fk_initiator_cco.`address_line_1` AS 'rfi_fk_initiator_cco__address_line_1',
	rfi_fk_initiator_cco.`address_line_2` AS 'rfi_fk_initiator_cco__address_line_2',
	rfi_fk_initiator_cco.`address_line_3` AS 'rfi_fk_initiator_cco__address_line_3',
	rfi_fk_initiator_cco.`address_line_4` AS 'rfi_fk_initiator_cco__address_line_4',
	rfi_fk_initiator_cco.`address_city` AS 'rfi_fk_initiator_cco__address_city',
	rfi_fk_initiator_cco.`address_county` AS 'rfi_fk_initiator_cco__address_county',
	rfi_fk_initiator_cco.`address_state_or_region` AS 'rfi_fk_initiator_cco__address_state_or_region',
	rfi_fk_initiator_cco.`address_postal_code` AS 'rfi_fk_initiator_cco__address_postal_code',
	rfi_fk_initiator_cco.`address_postal_code_extension` AS 'rfi_fk_initiator_cco__address_postal_code_extension',
	rfi_fk_initiator_cco.`address_country` AS 'rfi_fk_initiator_cco__address_country',
	rfi_fk_initiator_cco.`head_quarters_flag` AS 'rfi_fk_initiator_cco__head_quarters_flag',
	rfi_fk_initiator_cco.`address_validated_by_user_flag` AS 'rfi_fk_initiator_cco__address_validated_by_user_flag',
	rfi_fk_initiator_cco.`address_validated_by_web_service_flag` AS 'rfi_fk_initiator_cco__address_validated_by_web_service_flag',
	rfi_fk_initiator_cco.`address_validation_by_web_service_error_flag` AS 'rfi_fk_initiator_cco__address_validation_by_web_service_error_flag',

	rfi_fk_initiator_phone_ccopn.`id` AS 'rfi_fk_initiator_phone_ccopn__contact_company_office_phone_number_id',
	rfi_fk_initiator_phone_ccopn.`contact_company_office_id` AS 'rfi_fk_initiator_phone_ccopn__contact_company_office_id',
	rfi_fk_initiator_phone_ccopn.`phone_number_type_id` AS 'rfi_fk_initiator_phone_ccopn__phone_number_type_id',
	rfi_fk_initiator_phone_ccopn.`country_code` AS 'rfi_fk_initiator_phone_ccopn__country_code',
	rfi_fk_initiator_phone_ccopn.`area_code` AS 'rfi_fk_initiator_phone_ccopn__area_code',
	rfi_fk_initiator_phone_ccopn.`prefix` AS 'rfi_fk_initiator_phone_ccopn__prefix',
	rfi_fk_initiator_phone_ccopn.`number` AS 'rfi_fk_initiator_phone_ccopn__number',
	rfi_fk_initiator_phone_ccopn.`extension` AS 'rfi_fk_initiator_phone_ccopn__extension',
	rfi_fk_initiator_phone_ccopn.`itu` AS 'rfi_fk_initiator_phone_ccopn__itu',

	rfi_fk_initiator_fax_ccopn.`id` AS 'rfi_fk_initiator_fax_ccopn__contact_company_office_phone_number_id',
	rfi_fk_initiator_fax_ccopn.`contact_company_office_id` AS 'rfi_fk_initiator_fax_ccopn__contact_company_office_id',
	rfi_fk_initiator_fax_ccopn.`phone_number_type_id` AS 'rfi_fk_initiator_fax_ccopn__phone_number_type_id',
	rfi_fk_initiator_fax_ccopn.`country_code` AS 'rfi_fk_initiator_fax_ccopn__country_code',
	rfi_fk_initiator_fax_ccopn.`area_code` AS 'rfi_fk_initiator_fax_ccopn__area_code',
	rfi_fk_initiator_fax_ccopn.`prefix` AS 'rfi_fk_initiator_fax_ccopn__prefix',
	rfi_fk_initiator_fax_ccopn.`number` AS 'rfi_fk_initiator_fax_ccopn__number',
	rfi_fk_initiator_fax_ccopn.`extension` AS 'rfi_fk_initiator_fax_ccopn__extension',
	rfi_fk_initiator_fax_ccopn.`itu` AS 'rfi_fk_initiator_fax_ccopn__itu',

	rfi_fk_initiator_c_mobile_cpn.`id` AS 'rfi_fk_initiator_c_mobile_cpn__contact_phone_number_id',
	rfi_fk_initiator_c_mobile_cpn.`contact_id` AS 'rfi_fk_initiator_c_mobile_cpn__contact_id',
	rfi_fk_initiator_c_mobile_cpn.`phone_number_type_id` AS 'rfi_fk_initiator_c_mobile_cpn__phone_number_type_id',
	rfi_fk_initiator_c_mobile_cpn.`country_code` AS 'rfi_fk_initiator_c_mobile_cpn__country_code',
	rfi_fk_initiator_c_mobile_cpn.`area_code` AS 'rfi_fk_initiator_c_mobile_cpn__area_code',
	rfi_fk_initiator_c_mobile_cpn.`prefix` AS 'rfi_fk_initiator_c_mobile_cpn__prefix',
	rfi_fk_initiator_c_mobile_cpn.`number` AS 'rfi_fk_initiator_c_mobile_cpn__number',
	rfi_fk_initiator_c_mobile_cpn.`extension` AS 'rfi_fk_initiator_c_mobile_cpn__extension',
	rfi_fk_initiator_c_mobile_cpn.`itu` AS 'rfi_fk_initiator_c_mobile_cpn__itu',

	rfi.*

FROM `requests_for_information` rfi
	INNER JOIN `projects` rfi_fk_p ON rfi.`project_id` = rfi_fk_p.`id`
	INNER JOIN `request_for_information_types` rfi_fk_rfit ON rfi.`request_for_information_type_id` = rfi_fk_rfit.`id`
	INNER JOIN `request_for_information_statuses` rfi_fk_rfis ON rfi.`request_for_information_status_id` = rfi_fk_rfis.`id`
	INNER JOIN `request_for_information_priorities` rfi_fk_rfip ON rfi.`request_for_information_priority_id` = rfi_fk_rfip.`id`
	LEFT OUTER JOIN `file_manager_files` rfi_fk_fmfiles ON rfi.`rfi_file_manager_file_id` = rfi_fk_fmfiles.`id`
	LEFT OUTER JOIN `cost_codes` rfi_fk_codes ON rfi.`rfi_cost_code_id` = rfi_fk_codes.`id`
	INNER JOIN `contacts` rfi_fk_creator_c ON rfi.`rfi_creator_contact_id` = rfi_fk_creator_c.`id`
	LEFT OUTER JOIN `contact_company_offices` rfi_fk_creator_cco ON rfi.`rfi_creator_contact_company_office_id` = rfi_fk_creator_cco.`id`
	LEFT OUTER JOIN `contact_company_office_phone_numbers` rfi_fk_creator_phone_ccopn ON rfi.`rfi_creator_phone_contact_company_office_phone_number_id` = rfi_fk_creator_phone_ccopn.`id`
	LEFT OUTER JOIN `contact_company_office_phone_numbers` rfi_fk_creator_fax_ccopn ON rfi.`rfi_creator_fax_contact_company_office_phone_number_id` = rfi_fk_creator_fax_ccopn.`id`
	LEFT OUTER JOIN `contact_phone_numbers` rfi_fk_creator_c_mobile_cpn ON rfi.`rfi_creator_contact_mobile_phone_number_id` = rfi_fk_creator_c_mobile_cpn.`id`
	LEFT OUTER JOIN `contacts` rfi_fk_recipient_c ON rfi.`rfi_recipient_contact_id` = rfi_fk_recipient_c.`id`
	LEFT OUTER JOIN `contact_company_offices` rfi_fk_recipient_cco ON rfi.`rfi_recipient_contact_company_office_id` = rfi_fk_recipient_cco.`id`
	LEFT OUTER JOIN `contact_company_office_phone_numbers` rfi_fk_recipient_phone_ccopn ON rfi.`rfi_recipient_phone_contact_company_office_phone_number_id` = rfi_fk_recipient_phone_ccopn.`id`
	LEFT OUTER JOIN `contact_company_office_phone_numbers` rfi_fk_recipient_fax_ccopn ON rfi.`rfi_recipient_fax_contact_company_office_phone_number_id` = rfi_fk_recipient_fax_ccopn.`id`
	LEFT OUTER JOIN `contact_phone_numbers` rfi_fk_recipient_c_mobile_cpn ON rfi.`rfi_recipient_contact_mobile_phone_number_id` = rfi_fk_recipient_c_mobile_cpn.`id`
	LEFT OUTER JOIN `contacts` rfi_fk_initiator_c ON rfi.`rfi_initiator_contact_id` = rfi_fk_initiator_c.`id`
	LEFT OUTER JOIN `contact_company_offices` rfi_fk_initiator_cco ON rfi.`rfi_initiator_contact_company_office_id` = rfi_fk_initiator_cco.`id`
	LEFT OUTER JOIN `contact_company_office_phone_numbers` rfi_fk_initiator_phone_ccopn ON rfi.`rfi_initiator_phone_contact_company_office_phone_number_id` = rfi_fk_initiator_phone_ccopn.`id`
	LEFT OUTER JOIN `contact_company_office_phone_numbers` rfi_fk_initiator_fax_ccopn ON rfi.`rfi_initiator_fax_contact_company_office_phone_number_id` = rfi_fk_initiator_fax_ccopn.`id`
	LEFT OUTER JOIN `contact_phone_numbers` rfi_fk_initiator_c_mobile_cpn ON rfi.`rfi_initiator_contact_mobile_phone_number_id` = rfi_fk_initiator_c_mobile_cpn.`id`
WHERE rfi.`project_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `rfi_sequence_number` ASC, `request_for_information_type_id` ASC, `request_for_information_status_id` ASC, `request_for_information_priority_id` ASC, `rfi_file_manager_file_id` ASC, `rfi_cost_code_id` ASC, `rfi_creator_contact_id` ASC, `rfi_creator_contact_company_office_id` ASC, `rfi_creator_phone_contact_company_office_phone_number_id` ASC, `rfi_creator_fax_contact_company_office_phone_number_id` ASC, `rfi_creator_contact_mobile_phone_number_id` ASC, `rfi_recipient_contact_id` ASC, `rfi_recipient_contact_company_office_id` ASC, `rfi_recipient_phone_contact_company_office_phone_number_id` ASC, `rfi_recipient_fax_contact_company_office_phone_number_id` ASC, `rfi_recipient_contact_mobile_phone_number_id` ASC, `rfi_initiator_contact_id` ASC, `rfi_initiator_contact_company_office_id` ASC, `rfi_initiator_phone_contact_company_office_phone_number_id` ASC, `rfi_initiator_fax_contact_company_office_phone_number_id` ASC, `rfi_initiator_contact_mobile_phone_number_id` ASC, `rfi_title` ASC, `rfi_plan_page_reference` ASC, `rfi_statement` ASC, `created` ASC, `rfi_due_date` ASC, `rfi_closed_date` ASC
		$arrValues = array($project_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrRequestsForInformationByProjectId = array();
		while ($row = $db->fetch()) {
			$request_for_information_id = $row['id'];
			$requestForInformation = self::instantiateOrm($database, 'RequestForInformation', $row, null, $request_for_information_id);
			/* @var $requestForInformation RequestForInformation */
			$requestForInformation->convertPropertiesToData();

			if (isset($row['project_id'])) {
				$project_id = $row['project_id'];
				$row['rfi_fk_p__id'] = $project_id;
				$project = self::instantiateOrm($database, 'Project', $row, null, $project_id, 'rfi_fk_p__');
				/* @var $project Project */
				$project->convertPropertiesToData();
			} else {
				$project = false;
			}
			$requestForInformation->setProject($project);

			if (isset($row['request_for_information_type_id'])) {
				$request_for_information_type_id = $row['request_for_information_type_id'];
				$row['rfi_fk_rfit__id'] = $request_for_information_type_id;
				$requestForInformationType = self::instantiateOrm($database, 'RequestForInformationType', $row, null, $request_for_information_type_id, 'rfi_fk_rfit__');
				/* @var $requestForInformationType RequestForInformationType */
				$requestForInformationType->convertPropertiesToData();
			} else {
				$requestForInformationType = false;
			}
			$requestForInformation->setRequestForInformationType($requestForInformationType);

			if (isset($row['request_for_information_status_id'])) {
				$request_for_information_status_id = $row['request_for_information_status_id'];
				$row['rfi_fk_rfis__id'] = $request_for_information_status_id;
				$requestForInformationStatus = self::instantiateOrm($database, 'RequestForInformationStatus', $row, null, $request_for_information_status_id, 'rfi_fk_rfis__');
				/* @var $requestForInformationStatus RequestForInformationStatus */
				$requestForInformationStatus->convertPropertiesToData();
			} else {
				$requestForInformationStatus = false;
			}
			$requestForInformation->setRequestForInformationStatus($requestForInformationStatus);

			if (isset($row['request_for_information_priority_id'])) {
				$request_for_information_priority_id = $row['request_for_information_priority_id'];
				$row['rfi_fk_rfip__id'] = $request_for_information_priority_id;
				$requestForInformationPriority = self::instantiateOrm($database, 'RequestForInformationPriority', $row, null, $request_for_information_priority_id, 'rfi_fk_rfip__');
				/* @var $requestForInformationPriority RequestForInformationPriority */
				$requestForInformationPriority->convertPropertiesToData();
			} else {
				$requestForInformationPriority = false;
			}
			$requestForInformation->setRequestForInformationPriority($requestForInformationPriority);

			if (isset($row['rfi_file_manager_file_id'])) {
				$rfi_file_manager_file_id = $row['rfi_file_manager_file_id'];
				$row['rfi_fk_fmfiles__id'] = $rfi_file_manager_file_id;
				$rfiFileManagerFile = self::instantiateOrm($database, 'FileManagerFile', $row, null, $rfi_file_manager_file_id, 'rfi_fk_fmfiles__');
				/* @var $rfiFileManagerFile FileManagerFile */
				$rfiFileManagerFile->convertPropertiesToData();
			} else {
				$rfiFileManagerFile = false;
			}
			$requestForInformation->setRfiFileManagerFile($rfiFileManagerFile);

			if (isset($row['rfi_cost_code_id'])) {
				$rfi_cost_code_id = $row['rfi_cost_code_id'];
				$row['rfi_fk_codes__id'] = $rfi_cost_code_id;
				$rfiCostCode = self::instantiateOrm($database, 'CostCode', $row, null, $rfi_cost_code_id, 'rfi_fk_codes__');
				/* @var $rfiCostCode CostCode */
				$rfiCostCode->convertPropertiesToData();
			} else {
				$rfiCostCode = false;
			}
			$requestForInformation->setRfiCostCode($rfiCostCode);

			if (isset($row['rfi_creator_contact_id'])) {
				$rfi_creator_contact_id = $row['rfi_creator_contact_id'];
				$row['rfi_fk_creator_c__id'] = $rfi_creator_contact_id;
				$rfiCreatorContact = self::instantiateOrm($database, 'Contact', $row, null, $rfi_creator_contact_id, 'rfi_fk_creator_c__');
				/* @var $rfiCreatorContact Contact */
				$rfiCreatorContact->convertPropertiesToData();
			} else {
				$rfiCreatorContact = false;
			}
			$requestForInformation->setRfiCreatorContact($rfiCreatorContact);

			if (isset($row['rfi_creator_contact_company_office_id'])) {
				$rfi_creator_contact_company_office_id = $row['rfi_creator_contact_company_office_id'];
				$row['rfi_fk_creator_cco__id'] = $rfi_creator_contact_company_office_id;
				$rfiCreatorContactCompanyOffice = self::instantiateOrm($database, 'ContactCompanyOffice', $row, null, $rfi_creator_contact_company_office_id, 'rfi_fk_creator_cco__');
				/* @var $rfiCreatorContactCompanyOffice ContactCompanyOffice */
				$rfiCreatorContactCompanyOffice->convertPropertiesToData();
			} else {
				$rfiCreatorContactCompanyOffice = false;
			}
			$requestForInformation->setRfiCreatorContactCompanyOffice($rfiCreatorContactCompanyOffice);

			if (isset($row['rfi_creator_phone_contact_company_office_phone_number_id'])) {
				$rfi_creator_phone_contact_company_office_phone_number_id = $row['rfi_creator_phone_contact_company_office_phone_number_id'];
				$row['rfi_fk_creator_phone_ccopn__id'] = $rfi_creator_phone_contact_company_office_phone_number_id;
				$rfiCreatorPhoneContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $rfi_creator_phone_contact_company_office_phone_number_id, 'rfi_fk_creator_phone_ccopn__');
				/* @var $rfiCreatorPhoneContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$rfiCreatorPhoneContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$rfiCreatorPhoneContactCompanyOfficePhoneNumber = false;
			}
			$requestForInformation->setRfiCreatorPhoneContactCompanyOfficePhoneNumber($rfiCreatorPhoneContactCompanyOfficePhoneNumber);

			if (isset($row['rfi_creator_fax_contact_company_office_phone_number_id'])) {
				$rfi_creator_fax_contact_company_office_phone_number_id = $row['rfi_creator_fax_contact_company_office_phone_number_id'];
				$row['rfi_fk_creator_fax_ccopn__id'] = $rfi_creator_fax_contact_company_office_phone_number_id;
				$rfiCreatorFaxContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $rfi_creator_fax_contact_company_office_phone_number_id, 'rfi_fk_creator_fax_ccopn__');
				/* @var $rfiCreatorFaxContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$rfiCreatorFaxContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$rfiCreatorFaxContactCompanyOfficePhoneNumber = false;
			}
			$requestForInformation->setRfiCreatorFaxContactCompanyOfficePhoneNumber($rfiCreatorFaxContactCompanyOfficePhoneNumber);

			if (isset($row['rfi_creator_contact_mobile_phone_number_id'])) {
				$rfi_creator_contact_mobile_phone_number_id = $row['rfi_creator_contact_mobile_phone_number_id'];
				$row['rfi_fk_creator_c_mobile_cpn__id'] = $rfi_creator_contact_mobile_phone_number_id;
				$rfiCreatorContactMobilePhoneNumber = self::instantiateOrm($database, 'ContactPhoneNumber', $row, null, $rfi_creator_contact_mobile_phone_number_id, 'rfi_fk_creator_c_mobile_cpn__');
				/* @var $rfiCreatorContactMobilePhoneNumber ContactPhoneNumber */
				$rfiCreatorContactMobilePhoneNumber->convertPropertiesToData();
			} else {
				$rfiCreatorContactMobilePhoneNumber = false;
			}
			$requestForInformation->setRfiCreatorContactMobilePhoneNumber($rfiCreatorContactMobilePhoneNumber);

			if (isset($row['rfi_recipient_contact_id'])) {
				$rfi_recipient_contact_id = $row['rfi_recipient_contact_id'];
				$row['rfi_fk_recipient_c__id'] = $rfi_recipient_contact_id;
				$rfiRecipientContact = self::instantiateOrm($database, 'Contact', $row, null, $rfi_recipient_contact_id, 'rfi_fk_recipient_c__');
				/* @var $rfiRecipientContact Contact */
				$rfiRecipientContact->convertPropertiesToData();
			} else {
				$rfiRecipientContact = false;
			}
			$requestForInformation->setRfiRecipientContact($rfiRecipientContact);

			if (isset($row['rfi_recipient_contact_company_office_id'])) {
				$rfi_recipient_contact_company_office_id = $row['rfi_recipient_contact_company_office_id'];
				$row['rfi_fk_recipient_cco__id'] = $rfi_recipient_contact_company_office_id;
				$rfiRecipientContactCompanyOffice = self::instantiateOrm($database, 'ContactCompanyOffice', $row, null, $rfi_recipient_contact_company_office_id, 'rfi_fk_recipient_cco__');
				/* @var $rfiRecipientContactCompanyOffice ContactCompanyOffice */
				$rfiRecipientContactCompanyOffice->convertPropertiesToData();
			} else {
				$rfiRecipientContactCompanyOffice = false;
			}
			$requestForInformation->setRfiRecipientContactCompanyOffice($rfiRecipientContactCompanyOffice);

			if (isset($row['rfi_recipient_phone_contact_company_office_phone_number_id'])) {
				$rfi_recipient_phone_contact_company_office_phone_number_id = $row['rfi_recipient_phone_contact_company_office_phone_number_id'];
				$row['rfi_fk_recipient_phone_ccopn__id'] = $rfi_recipient_phone_contact_company_office_phone_number_id;
				$rfiRecipientPhoneContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $rfi_recipient_phone_contact_company_office_phone_number_id, 'rfi_fk_recipient_phone_ccopn__');
				/* @var $rfiRecipientPhoneContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$rfiRecipientPhoneContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$rfiRecipientPhoneContactCompanyOfficePhoneNumber = false;
			}
			$requestForInformation->setRfiRecipientPhoneContactCompanyOfficePhoneNumber($rfiRecipientPhoneContactCompanyOfficePhoneNumber);

			if (isset($row['rfi_recipient_fax_contact_company_office_phone_number_id'])) {
				$rfi_recipient_fax_contact_company_office_phone_number_id = $row['rfi_recipient_fax_contact_company_office_phone_number_id'];
				$row['rfi_fk_recipient_fax_ccopn__id'] = $rfi_recipient_fax_contact_company_office_phone_number_id;
				$rfiRecipientFaxContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $rfi_recipient_fax_contact_company_office_phone_number_id, 'rfi_fk_recipient_fax_ccopn__');
				/* @var $rfiRecipientFaxContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$rfiRecipientFaxContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$rfiRecipientFaxContactCompanyOfficePhoneNumber = false;
			}
			$requestForInformation->setRfiRecipientFaxContactCompanyOfficePhoneNumber($rfiRecipientFaxContactCompanyOfficePhoneNumber);

			if (isset($row['rfi_recipient_contact_mobile_phone_number_id'])) {
				$rfi_recipient_contact_mobile_phone_number_id = $row['rfi_recipient_contact_mobile_phone_number_id'];
				$row['rfi_fk_recipient_c_mobile_cpn__id'] = $rfi_recipient_contact_mobile_phone_number_id;
				$rfiRecipientContactMobilePhoneNumber = self::instantiateOrm($database, 'ContactPhoneNumber', $row, null, $rfi_recipient_contact_mobile_phone_number_id, 'rfi_fk_recipient_c_mobile_cpn__');
				/* @var $rfiRecipientContactMobilePhoneNumber ContactPhoneNumber */
				$rfiRecipientContactMobilePhoneNumber->convertPropertiesToData();
			} else {
				$rfiRecipientContactMobilePhoneNumber = false;
			}
			$requestForInformation->setRfiRecipientContactMobilePhoneNumber($rfiRecipientContactMobilePhoneNumber);

			if (isset($row['rfi_initiator_contact_id'])) {
				$rfi_initiator_contact_id = $row['rfi_initiator_contact_id'];
				$row['rfi_fk_initiator_c__id'] = $rfi_initiator_contact_id;
				$rfiInitiatorContact = self::instantiateOrm($database, 'Contact', $row, null, $rfi_initiator_contact_id, 'rfi_fk_initiator_c__');
				/* @var $rfiInitiatorContact Contact */
				$rfiInitiatorContact->convertPropertiesToData();
			} else {
				$rfiInitiatorContact = false;
			}
			$requestForInformation->setRfiInitiatorContact($rfiInitiatorContact);

			if (isset($row['rfi_initiator_contact_company_office_id'])) {
				$rfi_initiator_contact_company_office_id = $row['rfi_initiator_contact_company_office_id'];
				$row['rfi_fk_initiator_cco__id'] = $rfi_initiator_contact_company_office_id;
				$rfiInitiatorContactCompanyOffice = self::instantiateOrm($database, 'ContactCompanyOffice', $row, null, $rfi_initiator_contact_company_office_id, 'rfi_fk_initiator_cco__');
				/* @var $rfiInitiatorContactCompanyOffice ContactCompanyOffice */
				$rfiInitiatorContactCompanyOffice->convertPropertiesToData();
			} else {
				$rfiInitiatorContactCompanyOffice = false;
			}
			$requestForInformation->setRfiInitiatorContactCompanyOffice($rfiInitiatorContactCompanyOffice);

			if (isset($row['rfi_initiator_phone_contact_company_office_phone_number_id'])) {
				$rfi_initiator_phone_contact_company_office_phone_number_id = $row['rfi_initiator_phone_contact_company_office_phone_number_id'];
				$row['rfi_fk_initiator_phone_ccopn__id'] = $rfi_initiator_phone_contact_company_office_phone_number_id;
				$rfiInitiatorPhoneContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $rfi_initiator_phone_contact_company_office_phone_number_id, 'rfi_fk_initiator_phone_ccopn__');
				/* @var $rfiInitiatorPhoneContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$rfiInitiatorPhoneContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$rfiInitiatorPhoneContactCompanyOfficePhoneNumber = false;
			}
			$requestForInformation->setRfiInitiatorPhoneContactCompanyOfficePhoneNumber($rfiInitiatorPhoneContactCompanyOfficePhoneNumber);

			if (isset($row['rfi_initiator_fax_contact_company_office_phone_number_id'])) {
				$rfi_initiator_fax_contact_company_office_phone_number_id = $row['rfi_initiator_fax_contact_company_office_phone_number_id'];
				$row['rfi_fk_initiator_fax_ccopn__id'] = $rfi_initiator_fax_contact_company_office_phone_number_id;
				$rfiInitiatorFaxContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $rfi_initiator_fax_contact_company_office_phone_number_id, 'rfi_fk_initiator_fax_ccopn__');
				/* @var $rfiInitiatorFaxContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$rfiInitiatorFaxContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$rfiInitiatorFaxContactCompanyOfficePhoneNumber = false;
			}
			$requestForInformation->setRfiInitiatorFaxContactCompanyOfficePhoneNumber($rfiInitiatorFaxContactCompanyOfficePhoneNumber);

			if (isset($row['rfi_initiator_contact_mobile_phone_number_id'])) {
				$rfi_initiator_contact_mobile_phone_number_id = $row['rfi_initiator_contact_mobile_phone_number_id'];
				$row['rfi_fk_initiator_c_mobile_cpn__id'] = $rfi_initiator_contact_mobile_phone_number_id;
				$rfiInitiatorContactMobilePhoneNumber = self::instantiateOrm($database, 'ContactPhoneNumber', $row, null, $rfi_initiator_contact_mobile_phone_number_id, 'rfi_fk_initiator_c_mobile_cpn__');
				/* @var $rfiInitiatorContactMobilePhoneNumber ContactPhoneNumber */
				$rfiInitiatorContactMobilePhoneNumber->convertPropertiesToData();
			} else {
				$rfiInitiatorContactMobilePhoneNumber = false;
			}
			$requestForInformation->setRfiInitiatorContactMobilePhoneNumber($rfiInitiatorContactMobilePhoneNumber);

			$arrRequestsForInformationByProjectId[$request_for_information_id] = $requestForInformation;
		}

		$db->free_result();

		self::$_arrRequestsForInformationByProjectId = $arrRequestsForInformationByProjectId;

		return $arrRequestsForInformationByProjectId;
	}
	// Loaders: Load By Foreign Key
	/** For Mobile Api
	 * Load by constraint `requests_for_information_fk_p` foreign key (`project_id`) references `projects` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $project_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadRequestsForInformationByProjectIdLoadAPI($database, $project_id, Input $options=null, $order, $where)
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
			self::$_arrRequestsForInformationByProjectId = null;
		}

		$arrRequestsForInformationByProjectId = self::$_arrRequestsForInformationByProjectId;
		if (isset($arrRequestsForInformationByProjectId) && !empty($arrRequestsForInformationByProjectId)) {
			return $arrRequestsForInformationByProjectId;
		}

		$project_id = (int) $project_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `rfi_sequence_number` ASC, `request_for_information_type_id` ASC, `request_for_information_status_id` ASC, `request_for_information_priority_id` ASC, `rfi_file_manager_file_id` ASC, `rfi_cost_code_id` ASC, `rfi_creator_contact_id` ASC, `rfi_creator_contact_company_office_id` ASC, `rfi_creator_phone_contact_company_office_phone_number_id` ASC, `rfi_creator_fax_contact_company_office_phone_number_id` ASC, `rfi_creator_contact_mobile_phone_number_id` ASC, `rfi_recipient_contact_id` ASC, `rfi_recipient_contact_company_office_id` ASC, `rfi_recipient_phone_contact_company_office_phone_number_id` ASC, `rfi_recipient_fax_contact_company_office_phone_number_id` ASC, `rfi_recipient_contact_mobile_phone_number_id` ASC, `rfi_initiator_contact_id` ASC, `rfi_initiator_contact_company_office_id` ASC, `rfi_initiator_phone_contact_company_office_phone_number_id` ASC, `rfi_initiator_fax_contact_company_office_phone_number_id` ASC, `rfi_initiator_contact_mobile_phone_number_id` ASC, `rfi_title` ASC, `rfi_plan_page_reference` ASC, `rfi_statement` ASC, `created` ASC, `rfi_due_date` ASC, `rfi_closed_date` ASC
		$sqlOrderBy = "\nORDER BY `created` DESC, `rfi_sequence_number` DESC, `request_for_information_priority_id` ASC, `request_for_information_type_id` ASC, `request_for_information_status_id` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpRequestForInformation = new RequestForInformation($database);
			$sqlOrderByColumns = $tmpRequestForInformation->constructSqlOrderByColumns($arrOrderByAttributes);

			if (!empty($sqlOrderByColumns)) {
				$sqlOrderBy = "\nORDER BY $sqlOrderByColumns";
			}
		}
		if($order != '' && $order!= null){
			$sqlOrderBy = "\nORDER BY rfi_title $order";
		}
		if($where != '' && $where!= null){
			$where = "AND rfi_fk_rfis.`request_for_information_status` = '$where'";
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

	rfi_fk_p.`id` AS 'rfi_fk_p__project_id',
	rfi_fk_p.`project_type_id` AS 'rfi_fk_p__project_type_id',
	rfi_fk_p.`user_company_id` AS 'rfi_fk_p__user_company_id',
	rfi_fk_p.`user_custom_project_id` AS 'rfi_fk_p__user_custom_project_id',
	rfi_fk_p.`project_name` AS 'rfi_fk_p__project_name',
	rfi_fk_p.`project_owner_name` AS 'rfi_fk_p__project_owner_name',
	rfi_fk_p.`latitude` AS 'rfi_fk_p__latitude',
	rfi_fk_p.`longitude` AS 'rfi_fk_p__longitude',
	rfi_fk_p.`address_line_1` AS 'rfi_fk_p__address_line_1',
	rfi_fk_p.`address_line_2` AS 'rfi_fk_p__address_line_2',
	rfi_fk_p.`address_line_3` AS 'rfi_fk_p__address_line_3',
	rfi_fk_p.`address_line_4` AS 'rfi_fk_p__address_line_4',
	rfi_fk_p.`address_city` AS 'rfi_fk_p__address_city',
	rfi_fk_p.`address_county` AS 'rfi_fk_p__address_county',
	rfi_fk_p.`address_state_or_region` AS 'rfi_fk_p__address_state_or_region',
	rfi_fk_p.`address_postal_code` AS 'rfi_fk_p__address_postal_code',
	rfi_fk_p.`address_postal_code_extension` AS 'rfi_fk_p__address_postal_code_extension',
	rfi_fk_p.`address_country` AS 'rfi_fk_p__address_country',
	rfi_fk_p.`building_count` AS 'rfi_fk_p__building_count',
	rfi_fk_p.`unit_count` AS 'rfi_fk_p__unit_count',
	rfi_fk_p.`gross_square_footage` AS 'rfi_fk_p__gross_square_footage',
	rfi_fk_p.`net_rentable_square_footage` AS 'rfi_fk_p__net_rentable_square_footage',
	rfi_fk_p.`is_active_flag` AS 'rfi_fk_p__is_active_flag',
	rfi_fk_p.`public_plans_flag` AS 'rfi_fk_p__public_plans_flag',
	rfi_fk_p.`prevailing_wage_flag` AS 'rfi_fk_p__prevailing_wage_flag',
	rfi_fk_p.`city_business_license_required_flag` AS 'rfi_fk_p__city_business_license_required_flag',
	rfi_fk_p.`is_internal_flag` AS 'rfi_fk_p__is_internal_flag',
	rfi_fk_p.`project_contract_date` AS 'rfi_fk_p__project_contract_date',
	rfi_fk_p.`project_start_date` AS 'rfi_fk_p__project_start_date',
	rfi_fk_p.`project_completed_date` AS 'rfi_fk_p__project_completed_date',
	rfi_fk_p.`sort_order` AS 'rfi_fk_p__sort_order',

	rfi_fk_rfit.`id` AS 'rfi_fk_rfit__request_for_information_type_id',
	rfi_fk_rfit.`request_for_information_type` AS 'rfi_fk_rfit__request_for_information_type',
	rfi_fk_rfit.`disabled_flag` AS 'rfi_fk_rfit__disabled_flag',

	rfi_fk_rfis.`id` AS 'rfi_fk_rfis__request_for_information_status_id',
	rfi_fk_rfis.`request_for_information_status` AS 'rfi_fk_rfis__request_for_information_status',
	rfi_fk_rfis.`disabled_flag` AS 'rfi_fk_rfis__disabled_flag',

	rfi_fk_rfip.`id` AS 'rfi_fk_rfip__request_for_information_priority_id',
	rfi_fk_rfip.`request_for_information_priority` AS 'rfi_fk_rfip__request_for_information_priority',
	rfi_fk_rfip.`disabled_flag` AS 'rfi_fk_rfip__disabled_flag',

	rfi_fk_fmfiles.`id` AS 'rfi_fk_fmfiles__file_manager_file_id',
	rfi_fk_fmfiles.`user_company_id` AS 'rfi_fk_fmfiles__user_company_id',
	rfi_fk_fmfiles.`contact_id` AS 'rfi_fk_fmfiles__contact_id',
	rfi_fk_fmfiles.`project_id` AS 'rfi_fk_fmfiles__project_id',
	rfi_fk_fmfiles.`file_manager_folder_id` AS 'rfi_fk_fmfiles__file_manager_folder_id',
	rfi_fk_fmfiles.`file_location_id` AS 'rfi_fk_fmfiles__file_location_id',
	rfi_fk_fmfiles.`virtual_file_name` AS 'rfi_fk_fmfiles__virtual_file_name',
	rfi_fk_fmfiles.`version_number` AS 'rfi_fk_fmfiles__version_number',
	rfi_fk_fmfiles.`virtual_file_name_sha1` AS 'rfi_fk_fmfiles__virtual_file_name_sha1',
	rfi_fk_fmfiles.`virtual_file_mime_type` AS 'rfi_fk_fmfiles__virtual_file_mime_type',
	rfi_fk_fmfiles.`modified` AS 'rfi_fk_fmfiles__modified',
	rfi_fk_fmfiles.`created` AS 'rfi_fk_fmfiles__created',
	rfi_fk_fmfiles.`deleted_flag` AS 'rfi_fk_fmfiles__deleted_flag',
	rfi_fk_fmfiles.`directly_deleted_flag` AS 'rfi_fk_fmfiles__directly_deleted_flag',

	rfi_fk_codes.`id` AS 'rfi_fk_codes__cost_code_id',
	rfi_fk_codes.`cost_code_division_id` AS 'rfi_fk_codes__cost_code_division_id',
	rfi_fk_codes.`cost_code` AS 'rfi_fk_codes__cost_code',
	rfi_fk_codes.`cost_code_description` AS 'rfi_fk_codes__cost_code_description',
	rfi_fk_codes.`cost_code_description_abbreviation` AS 'rfi_fk_codes__cost_code_description_abbreviation',
	rfi_fk_codes.`sort_order` AS 'rfi_fk_codes__sort_order',
	rfi_fk_codes.`disabled_flag` AS 'rfi_fk_codes__disabled_flag',

	rfi_fk_creator_c.`id` AS 'rfi_fk_creator_c__contact_id',
	rfi_fk_creator_c.`user_company_id` AS 'rfi_fk_creator_c__user_company_id',
	rfi_fk_creator_c.`user_id` AS 'rfi_fk_creator_c__user_id',
	rfi_fk_creator_c.`contact_company_id` AS 'rfi_fk_creator_c__contact_company_id',
	rfi_fk_creator_c.`email` AS 'rfi_fk_creator_c__email',
	rfi_fk_creator_c.`name_prefix` AS 'rfi_fk_creator_c__name_prefix',
	rfi_fk_creator_c.`first_name` AS 'rfi_fk_creator_c__first_name',
	rfi_fk_creator_c.`additional_name` AS 'rfi_fk_creator_c__additional_name',
	rfi_fk_creator_c.`middle_name` AS 'rfi_fk_creator_c__middle_name',
	rfi_fk_creator_c.`last_name` AS 'rfi_fk_creator_c__last_name',
	rfi_fk_creator_c.`name_suffix` AS 'rfi_fk_creator_c__name_suffix',
	rfi_fk_creator_c.`title` AS 'rfi_fk_creator_c__title',
	rfi_fk_creator_c.`vendor_flag` AS 'rfi_fk_creator_c__vendor_flag',

	rfi_fk_creator_cco.`id` AS 'rfi_fk_creator_cco__contact_company_office_id',
	rfi_fk_creator_cco.`contact_company_id` AS 'rfi_fk_creator_cco__contact_company_id',
	rfi_fk_creator_cco.`office_nickname` AS 'rfi_fk_creator_cco__office_nickname',
	rfi_fk_creator_cco.`address_line_1` AS 'rfi_fk_creator_cco__address_line_1',
	rfi_fk_creator_cco.`address_line_2` AS 'rfi_fk_creator_cco__address_line_2',
	rfi_fk_creator_cco.`address_line_3` AS 'rfi_fk_creator_cco__address_line_3',
	rfi_fk_creator_cco.`address_line_4` AS 'rfi_fk_creator_cco__address_line_4',
	rfi_fk_creator_cco.`address_city` AS 'rfi_fk_creator_cco__address_city',
	rfi_fk_creator_cco.`address_county` AS 'rfi_fk_creator_cco__address_county',
	rfi_fk_creator_cco.`address_state_or_region` AS 'rfi_fk_creator_cco__address_state_or_region',
	rfi_fk_creator_cco.`address_postal_code` AS 'rfi_fk_creator_cco__address_postal_code',
	rfi_fk_creator_cco.`address_postal_code_extension` AS 'rfi_fk_creator_cco__address_postal_code_extension',
	rfi_fk_creator_cco.`address_country` AS 'rfi_fk_creator_cco__address_country',
	rfi_fk_creator_cco.`head_quarters_flag` AS 'rfi_fk_creator_cco__head_quarters_flag',
	rfi_fk_creator_cco.`address_validated_by_user_flag` AS 'rfi_fk_creator_cco__address_validated_by_user_flag',
	rfi_fk_creator_cco.`address_validated_by_web_service_flag` AS 'rfi_fk_creator_cco__address_validated_by_web_service_flag',
	rfi_fk_creator_cco.`address_validation_by_web_service_error_flag` AS 'rfi_fk_creator_cco__address_validation_by_web_service_error_flag',

	rfi_fk_creator_phone_ccopn.`id` AS 'rfi_fk_creator_phone_ccopn__contact_company_office_phone_number_id',
	rfi_fk_creator_phone_ccopn.`contact_company_office_id` AS 'rfi_fk_creator_phone_ccopn__contact_company_office_id',
	rfi_fk_creator_phone_ccopn.`phone_number_type_id` AS 'rfi_fk_creator_phone_ccopn__phone_number_type_id',
	rfi_fk_creator_phone_ccopn.`country_code` AS 'rfi_fk_creator_phone_ccopn__country_code',
	rfi_fk_creator_phone_ccopn.`area_code` AS 'rfi_fk_creator_phone_ccopn__area_code',
	rfi_fk_creator_phone_ccopn.`prefix` AS 'rfi_fk_creator_phone_ccopn__prefix',
	rfi_fk_creator_phone_ccopn.`number` AS 'rfi_fk_creator_phone_ccopn__number',
	rfi_fk_creator_phone_ccopn.`extension` AS 'rfi_fk_creator_phone_ccopn__extension',
	rfi_fk_creator_phone_ccopn.`itu` AS 'rfi_fk_creator_phone_ccopn__itu',

	rfi_fk_creator_fax_ccopn.`id` AS 'rfi_fk_creator_fax_ccopn__contact_company_office_phone_number_id',
	rfi_fk_creator_fax_ccopn.`contact_company_office_id` AS 'rfi_fk_creator_fax_ccopn__contact_company_office_id',
	rfi_fk_creator_fax_ccopn.`phone_number_type_id` AS 'rfi_fk_creator_fax_ccopn__phone_number_type_id',
	rfi_fk_creator_fax_ccopn.`country_code` AS 'rfi_fk_creator_fax_ccopn__country_code',
	rfi_fk_creator_fax_ccopn.`area_code` AS 'rfi_fk_creator_fax_ccopn__area_code',
	rfi_fk_creator_fax_ccopn.`prefix` AS 'rfi_fk_creator_fax_ccopn__prefix',
	rfi_fk_creator_fax_ccopn.`number` AS 'rfi_fk_creator_fax_ccopn__number',
	rfi_fk_creator_fax_ccopn.`extension` AS 'rfi_fk_creator_fax_ccopn__extension',
	rfi_fk_creator_fax_ccopn.`itu` AS 'rfi_fk_creator_fax_ccopn__itu',

	rfi_fk_creator_c_mobile_cpn.`id` AS 'rfi_fk_creator_c_mobile_cpn__contact_phone_number_id',
	rfi_fk_creator_c_mobile_cpn.`contact_id` AS 'rfi_fk_creator_c_mobile_cpn__contact_id',
	rfi_fk_creator_c_mobile_cpn.`phone_number_type_id` AS 'rfi_fk_creator_c_mobile_cpn__phone_number_type_id',
	rfi_fk_creator_c_mobile_cpn.`country_code` AS 'rfi_fk_creator_c_mobile_cpn__country_code',
	rfi_fk_creator_c_mobile_cpn.`area_code` AS 'rfi_fk_creator_c_mobile_cpn__area_code',
	rfi_fk_creator_c_mobile_cpn.`prefix` AS 'rfi_fk_creator_c_mobile_cpn__prefix',
	rfi_fk_creator_c_mobile_cpn.`number` AS 'rfi_fk_creator_c_mobile_cpn__number',
	rfi_fk_creator_c_mobile_cpn.`extension` AS 'rfi_fk_creator_c_mobile_cpn__extension',
	rfi_fk_creator_c_mobile_cpn.`itu` AS 'rfi_fk_creator_c_mobile_cpn__itu',

	rfi_fk_recipient_c.`id` AS 'rfi_fk_recipient_c__contact_id',
	rfi_fk_recipient_c.`user_company_id` AS 'rfi_fk_recipient_c__user_company_id',
	rfi_fk_recipient_c.`user_id` AS 'rfi_fk_recipient_c__user_id',
	rfi_fk_recipient_c.`contact_company_id` AS 'rfi_fk_recipient_c__contact_company_id',
	rfi_fk_recipient_c.`email` AS 'rfi_fk_recipient_c__email',
	rfi_fk_recipient_c.`name_prefix` AS 'rfi_fk_recipient_c__name_prefix',
	rfi_fk_recipient_c.`first_name` AS 'rfi_fk_recipient_c__first_name',
	rfi_fk_recipient_c.`additional_name` AS 'rfi_fk_recipient_c__additional_name',
	rfi_fk_recipient_c.`middle_name` AS 'rfi_fk_recipient_c__middle_name',
	rfi_fk_recipient_c.`last_name` AS 'rfi_fk_recipient_c__last_name',
	rfi_fk_recipient_c.`name_suffix` AS 'rfi_fk_recipient_c__name_suffix',
	rfi_fk_recipient_c.`title` AS 'rfi_fk_recipient_c__title',
	rfi_fk_recipient_c.`vendor_flag` AS 'rfi_fk_recipient_c__vendor_flag',

	rfi_fk_recipient_cco.`id` AS 'rfi_fk_recipient_cco__contact_company_office_id',
	rfi_fk_recipient_cco.`contact_company_id` AS 'rfi_fk_recipient_cco__contact_company_id',
	rfi_fk_recipient_cco.`office_nickname` AS 'rfi_fk_recipient_cco__office_nickname',
	rfi_fk_recipient_cco.`address_line_1` AS 'rfi_fk_recipient_cco__address_line_1',
	rfi_fk_recipient_cco.`address_line_2` AS 'rfi_fk_recipient_cco__address_line_2',
	rfi_fk_recipient_cco.`address_line_3` AS 'rfi_fk_recipient_cco__address_line_3',
	rfi_fk_recipient_cco.`address_line_4` AS 'rfi_fk_recipient_cco__address_line_4',
	rfi_fk_recipient_cco.`address_city` AS 'rfi_fk_recipient_cco__address_city',
	rfi_fk_recipient_cco.`address_county` AS 'rfi_fk_recipient_cco__address_county',
	rfi_fk_recipient_cco.`address_state_or_region` AS 'rfi_fk_recipient_cco__address_state_or_region',
	rfi_fk_recipient_cco.`address_postal_code` AS 'rfi_fk_recipient_cco__address_postal_code',
	rfi_fk_recipient_cco.`address_postal_code_extension` AS 'rfi_fk_recipient_cco__address_postal_code_extension',
	rfi_fk_recipient_cco.`address_country` AS 'rfi_fk_recipient_cco__address_country',
	rfi_fk_recipient_cco.`head_quarters_flag` AS 'rfi_fk_recipient_cco__head_quarters_flag',
	rfi_fk_recipient_cco.`address_validated_by_user_flag` AS 'rfi_fk_recipient_cco__address_validated_by_user_flag',
	rfi_fk_recipient_cco.`address_validated_by_web_service_flag` AS 'rfi_fk_recipient_cco__address_validated_by_web_service_flag',
	rfi_fk_recipient_cco.`address_validation_by_web_service_error_flag` AS 'rfi_fk_recipient_cco__address_validation_by_web_service_error_flag',

	rfi_fk_recipient_phone_ccopn.`id` AS 'rfi_fk_recipient_phone_ccopn__contact_company_office_phone_number_id',
	rfi_fk_recipient_phone_ccopn.`contact_company_office_id` AS 'rfi_fk_recipient_phone_ccopn__contact_company_office_id',
	rfi_fk_recipient_phone_ccopn.`phone_number_type_id` AS 'rfi_fk_recipient_phone_ccopn__phone_number_type_id',
	rfi_fk_recipient_phone_ccopn.`country_code` AS 'rfi_fk_recipient_phone_ccopn__country_code',
	rfi_fk_recipient_phone_ccopn.`area_code` AS 'rfi_fk_recipient_phone_ccopn__area_code',
	rfi_fk_recipient_phone_ccopn.`prefix` AS 'rfi_fk_recipient_phone_ccopn__prefix',
	rfi_fk_recipient_phone_ccopn.`number` AS 'rfi_fk_recipient_phone_ccopn__number',
	rfi_fk_recipient_phone_ccopn.`extension` AS 'rfi_fk_recipient_phone_ccopn__extension',
	rfi_fk_recipient_phone_ccopn.`itu` AS 'rfi_fk_recipient_phone_ccopn__itu',

	rfi_fk_recipient_fax_ccopn.`id` AS 'rfi_fk_recipient_fax_ccopn__contact_company_office_phone_number_id',
	rfi_fk_recipient_fax_ccopn.`contact_company_office_id` AS 'rfi_fk_recipient_fax_ccopn__contact_company_office_id',
	rfi_fk_recipient_fax_ccopn.`phone_number_type_id` AS 'rfi_fk_recipient_fax_ccopn__phone_number_type_id',
	rfi_fk_recipient_fax_ccopn.`country_code` AS 'rfi_fk_recipient_fax_ccopn__country_code',
	rfi_fk_recipient_fax_ccopn.`area_code` AS 'rfi_fk_recipient_fax_ccopn__area_code',
	rfi_fk_recipient_fax_ccopn.`prefix` AS 'rfi_fk_recipient_fax_ccopn__prefix',
	rfi_fk_recipient_fax_ccopn.`number` AS 'rfi_fk_recipient_fax_ccopn__number',
	rfi_fk_recipient_fax_ccopn.`extension` AS 'rfi_fk_recipient_fax_ccopn__extension',
	rfi_fk_recipient_fax_ccopn.`itu` AS 'rfi_fk_recipient_fax_ccopn__itu',

	rfi_fk_recipient_c_mobile_cpn.`id` AS 'rfi_fk_recipient_c_mobile_cpn__contact_phone_number_id',
	rfi_fk_recipient_c_mobile_cpn.`contact_id` AS 'rfi_fk_recipient_c_mobile_cpn__contact_id',
	rfi_fk_recipient_c_mobile_cpn.`phone_number_type_id` AS 'rfi_fk_recipient_c_mobile_cpn__phone_number_type_id',
	rfi_fk_recipient_c_mobile_cpn.`country_code` AS 'rfi_fk_recipient_c_mobile_cpn__country_code',
	rfi_fk_recipient_c_mobile_cpn.`area_code` AS 'rfi_fk_recipient_c_mobile_cpn__area_code',
	rfi_fk_recipient_c_mobile_cpn.`prefix` AS 'rfi_fk_recipient_c_mobile_cpn__prefix',
	rfi_fk_recipient_c_mobile_cpn.`number` AS 'rfi_fk_recipient_c_mobile_cpn__number',
	rfi_fk_recipient_c_mobile_cpn.`extension` AS 'rfi_fk_recipient_c_mobile_cpn__extension',
	rfi_fk_recipient_c_mobile_cpn.`itu` AS 'rfi_fk_recipient_c_mobile_cpn__itu',

	rfi_fk_initiator_c.`id` AS 'rfi_fk_initiator_c__contact_id',
	rfi_fk_initiator_c.`user_company_id` AS 'rfi_fk_initiator_c__user_company_id',
	rfi_fk_initiator_c.`user_id` AS 'rfi_fk_initiator_c__user_id',
	rfi_fk_initiator_c.`contact_company_id` AS 'rfi_fk_initiator_c__contact_company_id',
	rfi_fk_initiator_c.`email` AS 'rfi_fk_initiator_c__email',
	rfi_fk_initiator_c.`name_prefix` AS 'rfi_fk_initiator_c__name_prefix',
	rfi_fk_initiator_c.`first_name` AS 'rfi_fk_initiator_c__first_name',
	rfi_fk_initiator_c.`additional_name` AS 'rfi_fk_initiator_c__additional_name',
	rfi_fk_initiator_c.`middle_name` AS 'rfi_fk_initiator_c__middle_name',
	rfi_fk_initiator_c.`last_name` AS 'rfi_fk_initiator_c__last_name',
	rfi_fk_initiator_c.`name_suffix` AS 'rfi_fk_initiator_c__name_suffix',
	rfi_fk_initiator_c.`title` AS 'rfi_fk_initiator_c__title',
	rfi_fk_initiator_c.`vendor_flag` AS 'rfi_fk_initiator_c__vendor_flag',

	rfi_fk_initiator_cco.`id` AS 'rfi_fk_initiator_cco__contact_company_office_id',
	rfi_fk_initiator_cco.`contact_company_id` AS 'rfi_fk_initiator_cco__contact_company_id',
	rfi_fk_initiator_cco.`office_nickname` AS 'rfi_fk_initiator_cco__office_nickname',
	rfi_fk_initiator_cco.`address_line_1` AS 'rfi_fk_initiator_cco__address_line_1',
	rfi_fk_initiator_cco.`address_line_2` AS 'rfi_fk_initiator_cco__address_line_2',
	rfi_fk_initiator_cco.`address_line_3` AS 'rfi_fk_initiator_cco__address_line_3',
	rfi_fk_initiator_cco.`address_line_4` AS 'rfi_fk_initiator_cco__address_line_4',
	rfi_fk_initiator_cco.`address_city` AS 'rfi_fk_initiator_cco__address_city',
	rfi_fk_initiator_cco.`address_county` AS 'rfi_fk_initiator_cco__address_county',
	rfi_fk_initiator_cco.`address_state_or_region` AS 'rfi_fk_initiator_cco__address_state_or_region',
	rfi_fk_initiator_cco.`address_postal_code` AS 'rfi_fk_initiator_cco__address_postal_code',
	rfi_fk_initiator_cco.`address_postal_code_extension` AS 'rfi_fk_initiator_cco__address_postal_code_extension',
	rfi_fk_initiator_cco.`address_country` AS 'rfi_fk_initiator_cco__address_country',
	rfi_fk_initiator_cco.`head_quarters_flag` AS 'rfi_fk_initiator_cco__head_quarters_flag',
	rfi_fk_initiator_cco.`address_validated_by_user_flag` AS 'rfi_fk_initiator_cco__address_validated_by_user_flag',
	rfi_fk_initiator_cco.`address_validated_by_web_service_flag` AS 'rfi_fk_initiator_cco__address_validated_by_web_service_flag',
	rfi_fk_initiator_cco.`address_validation_by_web_service_error_flag` AS 'rfi_fk_initiator_cco__address_validation_by_web_service_error_flag',

	rfi_fk_initiator_phone_ccopn.`id` AS 'rfi_fk_initiator_phone_ccopn__contact_company_office_phone_number_id',
	rfi_fk_initiator_phone_ccopn.`contact_company_office_id` AS 'rfi_fk_initiator_phone_ccopn__contact_company_office_id',
	rfi_fk_initiator_phone_ccopn.`phone_number_type_id` AS 'rfi_fk_initiator_phone_ccopn__phone_number_type_id',
	rfi_fk_initiator_phone_ccopn.`country_code` AS 'rfi_fk_initiator_phone_ccopn__country_code',
	rfi_fk_initiator_phone_ccopn.`area_code` AS 'rfi_fk_initiator_phone_ccopn__area_code',
	rfi_fk_initiator_phone_ccopn.`prefix` AS 'rfi_fk_initiator_phone_ccopn__prefix',
	rfi_fk_initiator_phone_ccopn.`number` AS 'rfi_fk_initiator_phone_ccopn__number',
	rfi_fk_initiator_phone_ccopn.`extension` AS 'rfi_fk_initiator_phone_ccopn__extension',
	rfi_fk_initiator_phone_ccopn.`itu` AS 'rfi_fk_initiator_phone_ccopn__itu',

	rfi_fk_initiator_fax_ccopn.`id` AS 'rfi_fk_initiator_fax_ccopn__contact_company_office_phone_number_id',
	rfi_fk_initiator_fax_ccopn.`contact_company_office_id` AS 'rfi_fk_initiator_fax_ccopn__contact_company_office_id',
	rfi_fk_initiator_fax_ccopn.`phone_number_type_id` AS 'rfi_fk_initiator_fax_ccopn__phone_number_type_id',
	rfi_fk_initiator_fax_ccopn.`country_code` AS 'rfi_fk_initiator_fax_ccopn__country_code',
	rfi_fk_initiator_fax_ccopn.`area_code` AS 'rfi_fk_initiator_fax_ccopn__area_code',
	rfi_fk_initiator_fax_ccopn.`prefix` AS 'rfi_fk_initiator_fax_ccopn__prefix',
	rfi_fk_initiator_fax_ccopn.`number` AS 'rfi_fk_initiator_fax_ccopn__number',
	rfi_fk_initiator_fax_ccopn.`extension` AS 'rfi_fk_initiator_fax_ccopn__extension',
	rfi_fk_initiator_fax_ccopn.`itu` AS 'rfi_fk_initiator_fax_ccopn__itu',

	rfi_fk_initiator_c_mobile_cpn.`id` AS 'rfi_fk_initiator_c_mobile_cpn__contact_phone_number_id',
	rfi_fk_initiator_c_mobile_cpn.`contact_id` AS 'rfi_fk_initiator_c_mobile_cpn__contact_id',
	rfi_fk_initiator_c_mobile_cpn.`phone_number_type_id` AS 'rfi_fk_initiator_c_mobile_cpn__phone_number_type_id',
	rfi_fk_initiator_c_mobile_cpn.`country_code` AS 'rfi_fk_initiator_c_mobile_cpn__country_code',
	rfi_fk_initiator_c_mobile_cpn.`area_code` AS 'rfi_fk_initiator_c_mobile_cpn__area_code',
	rfi_fk_initiator_c_mobile_cpn.`prefix` AS 'rfi_fk_initiator_c_mobile_cpn__prefix',
	rfi_fk_initiator_c_mobile_cpn.`number` AS 'rfi_fk_initiator_c_mobile_cpn__number',
	rfi_fk_initiator_c_mobile_cpn.`extension` AS 'rfi_fk_initiator_c_mobile_cpn__extension',
	rfi_fk_initiator_c_mobile_cpn.`itu` AS 'rfi_fk_initiator_c_mobile_cpn__itu',

	rfi.*

FROM `requests_for_information` rfi
	INNER JOIN `projects` rfi_fk_p ON rfi.`project_id` = rfi_fk_p.`id`
	INNER JOIN `request_for_information_types` rfi_fk_rfit ON rfi.`request_for_information_type_id` = rfi_fk_rfit.`id`
	INNER JOIN `request_for_information_statuses` rfi_fk_rfis ON rfi.`request_for_information_status_id` = rfi_fk_rfis.`id`
	INNER JOIN `request_for_information_priorities` rfi_fk_rfip ON rfi.`request_for_information_priority_id` = rfi_fk_rfip.`id`
	LEFT OUTER JOIN `file_manager_files` rfi_fk_fmfiles ON rfi.`rfi_file_manager_file_id` = rfi_fk_fmfiles.`id`
	LEFT OUTER JOIN `cost_codes` rfi_fk_codes ON rfi.`rfi_cost_code_id` = rfi_fk_codes.`id`
	INNER JOIN `contacts` rfi_fk_creator_c ON rfi.`rfi_creator_contact_id` = rfi_fk_creator_c.`id`
	LEFT OUTER JOIN `contact_company_offices` rfi_fk_creator_cco ON rfi.`rfi_creator_contact_company_office_id` = rfi_fk_creator_cco.`id`
	LEFT OUTER JOIN `contact_company_office_phone_numbers` rfi_fk_creator_phone_ccopn ON rfi.`rfi_creator_phone_contact_company_office_phone_number_id` = rfi_fk_creator_phone_ccopn.`id`
	LEFT OUTER JOIN `contact_company_office_phone_numbers` rfi_fk_creator_fax_ccopn ON rfi.`rfi_creator_fax_contact_company_office_phone_number_id` = rfi_fk_creator_fax_ccopn.`id`
	LEFT OUTER JOIN `contact_phone_numbers` rfi_fk_creator_c_mobile_cpn ON rfi.`rfi_creator_contact_mobile_phone_number_id` = rfi_fk_creator_c_mobile_cpn.`id`
	LEFT OUTER JOIN `contacts` rfi_fk_recipient_c ON rfi.`rfi_recipient_contact_id` = rfi_fk_recipient_c.`id`
	LEFT OUTER JOIN `contact_company_offices` rfi_fk_recipient_cco ON rfi.`rfi_recipient_contact_company_office_id` = rfi_fk_recipient_cco.`id`
	LEFT OUTER JOIN `contact_company_office_phone_numbers` rfi_fk_recipient_phone_ccopn ON rfi.`rfi_recipient_phone_contact_company_office_phone_number_id` = rfi_fk_recipient_phone_ccopn.`id`
	LEFT OUTER JOIN `contact_company_office_phone_numbers` rfi_fk_recipient_fax_ccopn ON rfi.`rfi_recipient_fax_contact_company_office_phone_number_id` = rfi_fk_recipient_fax_ccopn.`id`
	LEFT OUTER JOIN `contact_phone_numbers` rfi_fk_recipient_c_mobile_cpn ON rfi.`rfi_recipient_contact_mobile_phone_number_id` = rfi_fk_recipient_c_mobile_cpn.`id`
	LEFT OUTER JOIN `contacts` rfi_fk_initiator_c ON rfi.`rfi_initiator_contact_id` = rfi_fk_initiator_c.`id`
	LEFT OUTER JOIN `contact_company_offices` rfi_fk_initiator_cco ON rfi.`rfi_initiator_contact_company_office_id` = rfi_fk_initiator_cco.`id`
	LEFT OUTER JOIN `contact_company_office_phone_numbers` rfi_fk_initiator_phone_ccopn ON rfi.`rfi_initiator_phone_contact_company_office_phone_number_id` = rfi_fk_initiator_phone_ccopn.`id`
	LEFT OUTER JOIN `contact_company_office_phone_numbers` rfi_fk_initiator_fax_ccopn ON rfi.`rfi_initiator_fax_contact_company_office_phone_number_id` = rfi_fk_initiator_fax_ccopn.`id`
	LEFT OUTER JOIN `contact_phone_numbers` rfi_fk_initiator_c_mobile_cpn ON rfi.`rfi_initiator_contact_mobile_phone_number_id` = rfi_fk_initiator_c_mobile_cpn.`id`
WHERE rfi.`project_id` = ? {$where}{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `rfi_sequence_number` ASC, `request_for_information_type_id` ASC, `request_for_information_status_id` ASC, `request_for_information_priority_id` ASC, `rfi_file_manager_file_id` ASC, `rfi_cost_code_id` ASC, `rfi_creator_contact_id` ASC, `rfi_creator_contact_company_office_id` ASC, `rfi_creator_phone_contact_company_office_phone_number_id` ASC, `rfi_creator_fax_contact_company_office_phone_number_id` ASC, `rfi_creator_contact_mobile_phone_number_id` ASC, `rfi_recipient_contact_id` ASC, `rfi_recipient_contact_company_office_id` ASC, `rfi_recipient_phone_contact_company_office_phone_number_id` ASC, `rfi_recipient_fax_contact_company_office_phone_number_id` ASC, `rfi_recipient_contact_mobile_phone_number_id` ASC, `rfi_initiator_contact_id` ASC, `rfi_initiator_contact_company_office_id` ASC, `rfi_initiator_phone_contact_company_office_phone_number_id` ASC, `rfi_initiator_fax_contact_company_office_phone_number_id` ASC, `rfi_initiator_contact_mobile_phone_number_id` ASC, `rfi_title` ASC, `rfi_plan_page_reference` ASC, `rfi_statement` ASC, `created` ASC, `rfi_due_date` ASC, `rfi_closed_date` ASC
		$arrValues = array($project_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrRequestsForInformationByProjectId = array();
		while ($row = $db->fetch()) {
			$request_for_information_id = $row['id'];
			$requestForInformation = self::instantiateOrm($database, 'RequestForInformation', $row, null, $request_for_information_id);
			/* @var $requestForInformation RequestForInformation */
			$requestForInformation->convertPropertiesToData();

			if (isset($row['project_id'])) {
				$project_id = $row['project_id'];
				$row['rfi_fk_p__id'] = $project_id;
				$project = self::instantiateOrm($database, 'Project', $row, null, $project_id, 'rfi_fk_p__');
				/* @var $project Project */
				$project->convertPropertiesToData();
			} else {
				$project = false;
			}
			$requestForInformation->setProject($project);

			if (isset($row['request_for_information_type_id'])) {
				$request_for_information_type_id = $row['request_for_information_type_id'];
				$row['rfi_fk_rfit__id'] = $request_for_information_type_id;
				$requestForInformationType = self::instantiateOrm($database, 'RequestForInformationType', $row, null, $request_for_information_type_id, 'rfi_fk_rfit__');
				/* @var $requestForInformationType RequestForInformationType */
				$requestForInformationType->convertPropertiesToData();
			} else {
				$requestForInformationType = false;
			}
			$requestForInformation->setRequestForInformationType($requestForInformationType);

			if (isset($row['request_for_information_status_id'])) {
				$request_for_information_status_id = $row['request_for_information_status_id'];
				$row['rfi_fk_rfis__id'] = $request_for_information_status_id;
				$requestForInformationStatus = self::instantiateOrm($database, 'RequestForInformationStatus', $row, null, $request_for_information_status_id, 'rfi_fk_rfis__');
				/* @var $requestForInformationStatus RequestForInformationStatus */
				$requestForInformationStatus->convertPropertiesToData();
			} else {
				$requestForInformationStatus = false;
			}
			$requestForInformation->setRequestForInformationStatus($requestForInformationStatus);

			if (isset($row['request_for_information_priority_id'])) {
				$request_for_information_priority_id = $row['request_for_information_priority_id'];
				$row['rfi_fk_rfip__id'] = $request_for_information_priority_id;
				$requestForInformationPriority = self::instantiateOrm($database, 'RequestForInformationPriority', $row, null, $request_for_information_priority_id, 'rfi_fk_rfip__');
				/* @var $requestForInformationPriority RequestForInformationPriority */
				$requestForInformationPriority->convertPropertiesToData();
			} else {
				$requestForInformationPriority = false;
			}
			$requestForInformation->setRequestForInformationPriority($requestForInformationPriority);

			if (isset($row['rfi_file_manager_file_id'])) {
				$rfi_file_manager_file_id = $row['rfi_file_manager_file_id'];
				$row['rfi_fk_fmfiles__id'] = $rfi_file_manager_file_id;
				$rfiFileManagerFile = self::instantiateOrm($database, 'FileManagerFile', $row, null, $rfi_file_manager_file_id, 'rfi_fk_fmfiles__');
				/* @var $rfiFileManagerFile FileManagerFile */
				$rfiFileManagerFile->convertPropertiesToData();
			} else {
				$rfiFileManagerFile = false;
			}
			$requestForInformation->setRfiFileManagerFile($rfiFileManagerFile);

			if (isset($row['rfi_cost_code_id'])) {
				$rfi_cost_code_id = $row['rfi_cost_code_id'];
				$row['rfi_fk_codes__id'] = $rfi_cost_code_id;
				$rfiCostCode = self::instantiateOrm($database, 'CostCode', $row, null, $rfi_cost_code_id, 'rfi_fk_codes__');
				/* @var $rfiCostCode CostCode */
				$rfiCostCode->convertPropertiesToData();
			} else {
				$rfiCostCode = false;
			}
			$requestForInformation->setRfiCostCode($rfiCostCode);

			if (isset($row['rfi_creator_contact_id'])) {
				$rfi_creator_contact_id = $row['rfi_creator_contact_id'];
				$row['rfi_fk_creator_c__id'] = $rfi_creator_contact_id;
				$rfiCreatorContact = self::instantiateOrm($database, 'Contact', $row, null, $rfi_creator_contact_id, 'rfi_fk_creator_c__');
				/* @var $rfiCreatorContact Contact */
				$rfiCreatorContact->convertPropertiesToData();
			} else {
				$rfiCreatorContact = false;
			}
			$requestForInformation->setRfiCreatorContact($rfiCreatorContact);

			if (isset($row['rfi_creator_contact_company_office_id'])) {
				$rfi_creator_contact_company_office_id = $row['rfi_creator_contact_company_office_id'];
				$row['rfi_fk_creator_cco__id'] = $rfi_creator_contact_company_office_id;
				$rfiCreatorContactCompanyOffice = self::instantiateOrm($database, 'ContactCompanyOffice', $row, null, $rfi_creator_contact_company_office_id, 'rfi_fk_creator_cco__');
				/* @var $rfiCreatorContactCompanyOffice ContactCompanyOffice */
				$rfiCreatorContactCompanyOffice->convertPropertiesToData();
			} else {
				$rfiCreatorContactCompanyOffice = false;
			}
			$requestForInformation->setRfiCreatorContactCompanyOffice($rfiCreatorContactCompanyOffice);

			if (isset($row['rfi_creator_phone_contact_company_office_phone_number_id'])) {
				$rfi_creator_phone_contact_company_office_phone_number_id = $row['rfi_creator_phone_contact_company_office_phone_number_id'];
				$row['rfi_fk_creator_phone_ccopn__id'] = $rfi_creator_phone_contact_company_office_phone_number_id;
				$rfiCreatorPhoneContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $rfi_creator_phone_contact_company_office_phone_number_id, 'rfi_fk_creator_phone_ccopn__');
				/* @var $rfiCreatorPhoneContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$rfiCreatorPhoneContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$rfiCreatorPhoneContactCompanyOfficePhoneNumber = false;
			}
			$requestForInformation->setRfiCreatorPhoneContactCompanyOfficePhoneNumber($rfiCreatorPhoneContactCompanyOfficePhoneNumber);

			if (isset($row['rfi_creator_fax_contact_company_office_phone_number_id'])) {
				$rfi_creator_fax_contact_company_office_phone_number_id = $row['rfi_creator_fax_contact_company_office_phone_number_id'];
				$row['rfi_fk_creator_fax_ccopn__id'] = $rfi_creator_fax_contact_company_office_phone_number_id;
				$rfiCreatorFaxContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $rfi_creator_fax_contact_company_office_phone_number_id, 'rfi_fk_creator_fax_ccopn__');
				/* @var $rfiCreatorFaxContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$rfiCreatorFaxContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$rfiCreatorFaxContactCompanyOfficePhoneNumber = false;
			}
			$requestForInformation->setRfiCreatorFaxContactCompanyOfficePhoneNumber($rfiCreatorFaxContactCompanyOfficePhoneNumber);

			if (isset($row['rfi_creator_contact_mobile_phone_number_id'])) {
				$rfi_creator_contact_mobile_phone_number_id = $row['rfi_creator_contact_mobile_phone_number_id'];
				$row['rfi_fk_creator_c_mobile_cpn__id'] = $rfi_creator_contact_mobile_phone_number_id;
				$rfiCreatorContactMobilePhoneNumber = self::instantiateOrm($database, 'ContactPhoneNumber', $row, null, $rfi_creator_contact_mobile_phone_number_id, 'rfi_fk_creator_c_mobile_cpn__');
				/* @var $rfiCreatorContactMobilePhoneNumber ContactPhoneNumber */
				$rfiCreatorContactMobilePhoneNumber->convertPropertiesToData();
			} else {
				$rfiCreatorContactMobilePhoneNumber = false;
			}
			$requestForInformation->setRfiCreatorContactMobilePhoneNumber($rfiCreatorContactMobilePhoneNumber);

			if (isset($row['rfi_recipient_contact_id'])) {
				$rfi_recipient_contact_id = $row['rfi_recipient_contact_id'];
				$row['rfi_fk_recipient_c__id'] = $rfi_recipient_contact_id;
				$rfiRecipientContact = self::instantiateOrm($database, 'Contact', $row, null, $rfi_recipient_contact_id, 'rfi_fk_recipient_c__');
				/* @var $rfiRecipientContact Contact */
				$rfiRecipientContact->convertPropertiesToData();
			} else {
				$rfiRecipientContact = false;
			}
			$requestForInformation->setRfiRecipientContact($rfiRecipientContact);

			if (isset($row['rfi_recipient_contact_company_office_id'])) {
				$rfi_recipient_contact_company_office_id = $row['rfi_recipient_contact_company_office_id'];
				$row['rfi_fk_recipient_cco__id'] = $rfi_recipient_contact_company_office_id;
				$rfiRecipientContactCompanyOffice = self::instantiateOrm($database, 'ContactCompanyOffice', $row, null, $rfi_recipient_contact_company_office_id, 'rfi_fk_recipient_cco__');
				/* @var $rfiRecipientContactCompanyOffice ContactCompanyOffice */
				$rfiRecipientContactCompanyOffice->convertPropertiesToData();
			} else {
				$rfiRecipientContactCompanyOffice = false;
			}
			$requestForInformation->setRfiRecipientContactCompanyOffice($rfiRecipientContactCompanyOffice);

			if (isset($row['rfi_recipient_phone_contact_company_office_phone_number_id'])) {
				$rfi_recipient_phone_contact_company_office_phone_number_id = $row['rfi_recipient_phone_contact_company_office_phone_number_id'];
				$row['rfi_fk_recipient_phone_ccopn__id'] = $rfi_recipient_phone_contact_company_office_phone_number_id;
				$rfiRecipientPhoneContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $rfi_recipient_phone_contact_company_office_phone_number_id, 'rfi_fk_recipient_phone_ccopn__');
				/* @var $rfiRecipientPhoneContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$rfiRecipientPhoneContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$rfiRecipientPhoneContactCompanyOfficePhoneNumber = false;
			}
			$requestForInformation->setRfiRecipientPhoneContactCompanyOfficePhoneNumber($rfiRecipientPhoneContactCompanyOfficePhoneNumber);

			if (isset($row['rfi_recipient_fax_contact_company_office_phone_number_id'])) {
				$rfi_recipient_fax_contact_company_office_phone_number_id = $row['rfi_recipient_fax_contact_company_office_phone_number_id'];
				$row['rfi_fk_recipient_fax_ccopn__id'] = $rfi_recipient_fax_contact_company_office_phone_number_id;
				$rfiRecipientFaxContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $rfi_recipient_fax_contact_company_office_phone_number_id, 'rfi_fk_recipient_fax_ccopn__');
				/* @var $rfiRecipientFaxContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$rfiRecipientFaxContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$rfiRecipientFaxContactCompanyOfficePhoneNumber = false;
			}
			$requestForInformation->setRfiRecipientFaxContactCompanyOfficePhoneNumber($rfiRecipientFaxContactCompanyOfficePhoneNumber);

			if (isset($row['rfi_recipient_contact_mobile_phone_number_id'])) {
				$rfi_recipient_contact_mobile_phone_number_id = $row['rfi_recipient_contact_mobile_phone_number_id'];
				$row['rfi_fk_recipient_c_mobile_cpn__id'] = $rfi_recipient_contact_mobile_phone_number_id;
				$rfiRecipientContactMobilePhoneNumber = self::instantiateOrm($database, 'ContactPhoneNumber', $row, null, $rfi_recipient_contact_mobile_phone_number_id, 'rfi_fk_recipient_c_mobile_cpn__');
				/* @var $rfiRecipientContactMobilePhoneNumber ContactPhoneNumber */
				$rfiRecipientContactMobilePhoneNumber->convertPropertiesToData();
			} else {
				$rfiRecipientContactMobilePhoneNumber = false;
			}
			$requestForInformation->setRfiRecipientContactMobilePhoneNumber($rfiRecipientContactMobilePhoneNumber);

			if (isset($row['rfi_initiator_contact_id'])) {
				$rfi_initiator_contact_id = $row['rfi_initiator_contact_id'];
				$row['rfi_fk_initiator_c__id'] = $rfi_initiator_contact_id;
				$rfiInitiatorContact = self::instantiateOrm($database, 'Contact', $row, null, $rfi_initiator_contact_id, 'rfi_fk_initiator_c__');
				/* @var $rfiInitiatorContact Contact */
				$rfiInitiatorContact->convertPropertiesToData();
			} else {
				$rfiInitiatorContact = false;
			}
			$requestForInformation->setRfiInitiatorContact($rfiInitiatorContact);

			if (isset($row['rfi_initiator_contact_company_office_id'])) {
				$rfi_initiator_contact_company_office_id = $row['rfi_initiator_contact_company_office_id'];
				$row['rfi_fk_initiator_cco__id'] = $rfi_initiator_contact_company_office_id;
				$rfiInitiatorContactCompanyOffice = self::instantiateOrm($database, 'ContactCompanyOffice', $row, null, $rfi_initiator_contact_company_office_id, 'rfi_fk_initiator_cco__');
				/* @var $rfiInitiatorContactCompanyOffice ContactCompanyOffice */
				$rfiInitiatorContactCompanyOffice->convertPropertiesToData();
			} else {
				$rfiInitiatorContactCompanyOffice = false;
			}
			$requestForInformation->setRfiInitiatorContactCompanyOffice($rfiInitiatorContactCompanyOffice);

			if (isset($row['rfi_initiator_phone_contact_company_office_phone_number_id'])) {
				$rfi_initiator_phone_contact_company_office_phone_number_id = $row['rfi_initiator_phone_contact_company_office_phone_number_id'];
				$row['rfi_fk_initiator_phone_ccopn__id'] = $rfi_initiator_phone_contact_company_office_phone_number_id;
				$rfiInitiatorPhoneContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $rfi_initiator_phone_contact_company_office_phone_number_id, 'rfi_fk_initiator_phone_ccopn__');
				/* @var $rfiInitiatorPhoneContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$rfiInitiatorPhoneContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$rfiInitiatorPhoneContactCompanyOfficePhoneNumber = false;
			}
			$requestForInformation->setRfiInitiatorPhoneContactCompanyOfficePhoneNumber($rfiInitiatorPhoneContactCompanyOfficePhoneNumber);

			if (isset($row['rfi_initiator_fax_contact_company_office_phone_number_id'])) {
				$rfi_initiator_fax_contact_company_office_phone_number_id = $row['rfi_initiator_fax_contact_company_office_phone_number_id'];
				$row['rfi_fk_initiator_fax_ccopn__id'] = $rfi_initiator_fax_contact_company_office_phone_number_id;
				$rfiInitiatorFaxContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $rfi_initiator_fax_contact_company_office_phone_number_id, 'rfi_fk_initiator_fax_ccopn__');
				/* @var $rfiInitiatorFaxContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$rfiInitiatorFaxContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$rfiInitiatorFaxContactCompanyOfficePhoneNumber = false;
			}
			$requestForInformation->setRfiInitiatorFaxContactCompanyOfficePhoneNumber($rfiInitiatorFaxContactCompanyOfficePhoneNumber);

			if (isset($row['rfi_initiator_contact_mobile_phone_number_id'])) {
				$rfi_initiator_contact_mobile_phone_number_id = $row['rfi_initiator_contact_mobile_phone_number_id'];
				$row['rfi_fk_initiator_c_mobile_cpn__id'] = $rfi_initiator_contact_mobile_phone_number_id;
				$rfiInitiatorContactMobilePhoneNumber = self::instantiateOrm($database, 'ContactPhoneNumber', $row, null, $rfi_initiator_contact_mobile_phone_number_id, 'rfi_fk_initiator_c_mobile_cpn__');
				/* @var $rfiInitiatorContactMobilePhoneNumber ContactPhoneNumber */
				$rfiInitiatorContactMobilePhoneNumber->convertPropertiesToData();
			} else {
				$rfiInitiatorContactMobilePhoneNumber = false;
			}
			$requestForInformation->setRfiInitiatorContactMobilePhoneNumber($rfiInitiatorContactMobilePhoneNumber);

			$arrRequestsForInformationByProjectId[$request_for_information_id] = $requestForInformation;
		}

		$db->free_result();

		self::$_arrRequestsForInformationByProjectId = $arrRequestsForInformationByProjectId;

		return $arrRequestsForInformationByProjectId;
	}
// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `requests_for_information_fk_p` foreign key (`project_id`) references `projects` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $project_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadRequestsForInformationByDate($database, $project_id, Input $options=null,$new_begindate,$enddate)
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
			self::$_arrRequestsForInformationByProjectId = null;
		}

		$arrRequestsForInformationByProjectId = self::$_arrRequestsForInformationByProjectId;
		if (isset($arrRequestsForInformationByProjectId) && !empty($arrRequestsForInformationByProjectId)) {
			return $arrRequestsForInformationByProjectId;
		}

		$project_id = (int) $project_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `rfi_sequence_number` ASC, `request_for_information_type_id` ASC, `request_for_information_status_id` ASC, `request_for_information_priority_id` ASC, `rfi_file_manager_file_id` ASC, `rfi_cost_code_id` ASC, `rfi_creator_contact_id` ASC, `rfi_creator_contact_company_office_id` ASC, `rfi_creator_phone_contact_company_office_phone_number_id` ASC, `rfi_creator_fax_contact_company_office_phone_number_id` ASC, `rfi_creator_contact_mobile_phone_number_id` ASC, `rfi_recipient_contact_id` ASC, `rfi_recipient_contact_company_office_id` ASC, `rfi_recipient_phone_contact_company_office_phone_number_id` ASC, `rfi_recipient_fax_contact_company_office_phone_number_id` ASC, `rfi_recipient_contact_mobile_phone_number_id` ASC, `rfi_initiator_contact_id` ASC, `rfi_initiator_contact_company_office_id` ASC, `rfi_initiator_phone_contact_company_office_phone_number_id` ASC, `rfi_initiator_fax_contact_company_office_phone_number_id` ASC, `rfi_initiator_contact_mobile_phone_number_id` ASC, `rfi_title` ASC, `rfi_plan_page_reference` ASC, `rfi_statement` ASC, `created` ASC, `rfi_due_date` ASC, `rfi_closed_date` ASC
		$sqlOrderBy = "\nORDER BY `created` DESC, `rfi_sequence_number` DESC, `request_for_information_priority_id` ASC, `request_for_information_type_id` ASC, `request_for_information_status_id` ASC";

		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpRequestForInformation = new RequestForInformation($database);
			$sqlOrderByColumns = $tmpRequestForInformation->constructSqlOrderByColumns($arrOrderByAttributes);
				
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

	rfi_fk_p.`id` AS 'rfi_fk_p__project_id',
	rfi_fk_p.`project_type_id` AS 'rfi_fk_p__project_type_id',
	rfi_fk_p.`user_company_id` AS 'rfi_fk_p__user_company_id',
	rfi_fk_p.`user_custom_project_id` AS 'rfi_fk_p__user_custom_project_id',
	rfi_fk_p.`project_name` AS 'rfi_fk_p__project_name',
	rfi_fk_p.`project_owner_name` AS 'rfi_fk_p__project_owner_name',
	rfi_fk_p.`latitude` AS 'rfi_fk_p__latitude',
	rfi_fk_p.`longitude` AS 'rfi_fk_p__longitude',
	rfi_fk_p.`address_line_1` AS 'rfi_fk_p__address_line_1',
	rfi_fk_p.`address_line_2` AS 'rfi_fk_p__address_line_2',
	rfi_fk_p.`address_line_3` AS 'rfi_fk_p__address_line_3',
	rfi_fk_p.`address_line_4` AS 'rfi_fk_p__address_line_4',
	rfi_fk_p.`address_city` AS 'rfi_fk_p__address_city',
	rfi_fk_p.`address_county` AS 'rfi_fk_p__address_county',
	rfi_fk_p.`address_state_or_region` AS 'rfi_fk_p__address_state_or_region',
	rfi_fk_p.`address_postal_code` AS 'rfi_fk_p__address_postal_code',
	rfi_fk_p.`address_postal_code_extension` AS 'rfi_fk_p__address_postal_code_extension',
	rfi_fk_p.`address_country` AS 'rfi_fk_p__address_country',
	rfi_fk_p.`building_count` AS 'rfi_fk_p__building_count',
	rfi_fk_p.`unit_count` AS 'rfi_fk_p__unit_count',
	rfi_fk_p.`gross_square_footage` AS 'rfi_fk_p__gross_square_footage',
	rfi_fk_p.`net_rentable_square_footage` AS 'rfi_fk_p__net_rentable_square_footage',
	rfi_fk_p.`is_active_flag` AS 'rfi_fk_p__is_active_flag',
	rfi_fk_p.`public_plans_flag` AS 'rfi_fk_p__public_plans_flag',
	rfi_fk_p.`prevailing_wage_flag` AS 'rfi_fk_p__prevailing_wage_flag',
	rfi_fk_p.`city_business_license_required_flag` AS 'rfi_fk_p__city_business_license_required_flag',
	rfi_fk_p.`is_internal_flag` AS 'rfi_fk_p__is_internal_flag',
	rfi_fk_p.`project_contract_date` AS 'rfi_fk_p__project_contract_date',
	rfi_fk_p.`project_start_date` AS 'rfi_fk_p__project_start_date',
	rfi_fk_p.`project_completed_date` AS 'rfi_fk_p__project_completed_date',
	rfi_fk_p.`sort_order` AS 'rfi_fk_p__sort_order',

	rfi_fk_rfit.`id` AS 'rfi_fk_rfit__request_for_information_type_id',
	rfi_fk_rfit.`request_for_information_type` AS 'rfi_fk_rfit__request_for_information_type',
	rfi_fk_rfit.`disabled_flag` AS 'rfi_fk_rfit__disabled_flag',

	rfi_fk_rfis.`id` AS 'rfi_fk_rfis__request_for_information_status_id',
	rfi_fk_rfis.`request_for_information_status` AS 'rfi_fk_rfis__request_for_information_status',
	rfi_fk_rfis.`disabled_flag` AS 'rfi_fk_rfis__disabled_flag',

	rfi_fk_rfip.`id` AS 'rfi_fk_rfip__request_for_information_priority_id',
	rfi_fk_rfip.`request_for_information_priority` AS 'rfi_fk_rfip__request_for_information_priority',
	rfi_fk_rfip.`disabled_flag` AS 'rfi_fk_rfip__disabled_flag',

	rfi_fk_fmfiles.`id` AS 'rfi_fk_fmfiles__file_manager_file_id',
	rfi_fk_fmfiles.`user_company_id` AS 'rfi_fk_fmfiles__user_company_id',
	rfi_fk_fmfiles.`contact_id` AS 'rfi_fk_fmfiles__contact_id',
	rfi_fk_fmfiles.`project_id` AS 'rfi_fk_fmfiles__project_id',
	rfi_fk_fmfiles.`file_manager_folder_id` AS 'rfi_fk_fmfiles__file_manager_folder_id',
	rfi_fk_fmfiles.`file_location_id` AS 'rfi_fk_fmfiles__file_location_id',
	rfi_fk_fmfiles.`virtual_file_name` AS 'rfi_fk_fmfiles__virtual_file_name',
	rfi_fk_fmfiles.`version_number` AS 'rfi_fk_fmfiles__version_number',
	rfi_fk_fmfiles.`virtual_file_name_sha1` AS 'rfi_fk_fmfiles__virtual_file_name_sha1',
	rfi_fk_fmfiles.`virtual_file_mime_type` AS 'rfi_fk_fmfiles__virtual_file_mime_type',
	rfi_fk_fmfiles.`modified` AS 'rfi_fk_fmfiles__modified',
	rfi_fk_fmfiles.`created` AS 'rfi_fk_fmfiles__created',
	rfi_fk_fmfiles.`deleted_flag` AS 'rfi_fk_fmfiles__deleted_flag',
	rfi_fk_fmfiles.`directly_deleted_flag` AS 'rfi_fk_fmfiles__directly_deleted_flag',

	rfi_fk_codes.`id` AS 'rfi_fk_codes__cost_code_id',
	rfi_fk_codes.`cost_code_division_id` AS 'rfi_fk_codes__cost_code_division_id',
	rfi_fk_codes.`cost_code` AS 'rfi_fk_codes__cost_code',
	rfi_fk_codes.`cost_code_description` AS 'rfi_fk_codes__cost_code_description',
	rfi_fk_codes.`cost_code_description_abbreviation` AS 'rfi_fk_codes__cost_code_description_abbreviation',
	rfi_fk_codes.`sort_order` AS 'rfi_fk_codes__sort_order',
	rfi_fk_codes.`disabled_flag` AS 'rfi_fk_codes__disabled_flag',

	rfi_fk_creator_c.`id` AS 'rfi_fk_creator_c__contact_id',
	rfi_fk_creator_c.`user_company_id` AS 'rfi_fk_creator_c__user_company_id',
	rfi_fk_creator_c.`user_id` AS 'rfi_fk_creator_c__user_id',
	rfi_fk_creator_c.`contact_company_id` AS 'rfi_fk_creator_c__contact_company_id',
	rfi_fk_creator_c.`email` AS 'rfi_fk_creator_c__email',
	rfi_fk_creator_c.`name_prefix` AS 'rfi_fk_creator_c__name_prefix',
	rfi_fk_creator_c.`first_name` AS 'rfi_fk_creator_c__first_name',
	rfi_fk_creator_c.`additional_name` AS 'rfi_fk_creator_c__additional_name',
	rfi_fk_creator_c.`middle_name` AS 'rfi_fk_creator_c__middle_name',
	rfi_fk_creator_c.`last_name` AS 'rfi_fk_creator_c__last_name',
	rfi_fk_creator_c.`name_suffix` AS 'rfi_fk_creator_c__name_suffix',
	rfi_fk_creator_c.`title` AS 'rfi_fk_creator_c__title',
	rfi_fk_creator_c.`vendor_flag` AS 'rfi_fk_creator_c__vendor_flag',

	rfi_fk_creator_cco.`id` AS 'rfi_fk_creator_cco__contact_company_office_id',
	rfi_fk_creator_cco.`contact_company_id` AS 'rfi_fk_creator_cco__contact_company_id',
	rfi_fk_creator_cco.`office_nickname` AS 'rfi_fk_creator_cco__office_nickname',
	rfi_fk_creator_cco.`address_line_1` AS 'rfi_fk_creator_cco__address_line_1',
	rfi_fk_creator_cco.`address_line_2` AS 'rfi_fk_creator_cco__address_line_2',
	rfi_fk_creator_cco.`address_line_3` AS 'rfi_fk_creator_cco__address_line_3',
	rfi_fk_creator_cco.`address_line_4` AS 'rfi_fk_creator_cco__address_line_4',
	rfi_fk_creator_cco.`address_city` AS 'rfi_fk_creator_cco__address_city',
	rfi_fk_creator_cco.`address_county` AS 'rfi_fk_creator_cco__address_county',
	rfi_fk_creator_cco.`address_state_or_region` AS 'rfi_fk_creator_cco__address_state_or_region',
	rfi_fk_creator_cco.`address_postal_code` AS 'rfi_fk_creator_cco__address_postal_code',
	rfi_fk_creator_cco.`address_postal_code_extension` AS 'rfi_fk_creator_cco__address_postal_code_extension',
	rfi_fk_creator_cco.`address_country` AS 'rfi_fk_creator_cco__address_country',
	rfi_fk_creator_cco.`head_quarters_flag` AS 'rfi_fk_creator_cco__head_quarters_flag',
	rfi_fk_creator_cco.`address_validated_by_user_flag` AS 'rfi_fk_creator_cco__address_validated_by_user_flag',
	rfi_fk_creator_cco.`address_validated_by_web_service_flag` AS 'rfi_fk_creator_cco__address_validated_by_web_service_flag',
	rfi_fk_creator_cco.`address_validation_by_web_service_error_flag` AS 'rfi_fk_creator_cco__address_validation_by_web_service_error_flag',

	rfi_fk_creator_phone_ccopn.`id` AS 'rfi_fk_creator_phone_ccopn__contact_company_office_phone_number_id',
	rfi_fk_creator_phone_ccopn.`contact_company_office_id` AS 'rfi_fk_creator_phone_ccopn__contact_company_office_id',
	rfi_fk_creator_phone_ccopn.`phone_number_type_id` AS 'rfi_fk_creator_phone_ccopn__phone_number_type_id',
	rfi_fk_creator_phone_ccopn.`country_code` AS 'rfi_fk_creator_phone_ccopn__country_code',
	rfi_fk_creator_phone_ccopn.`area_code` AS 'rfi_fk_creator_phone_ccopn__area_code',
	rfi_fk_creator_phone_ccopn.`prefix` AS 'rfi_fk_creator_phone_ccopn__prefix',
	rfi_fk_creator_phone_ccopn.`number` AS 'rfi_fk_creator_phone_ccopn__number',
	rfi_fk_creator_phone_ccopn.`extension` AS 'rfi_fk_creator_phone_ccopn__extension',
	rfi_fk_creator_phone_ccopn.`itu` AS 'rfi_fk_creator_phone_ccopn__itu',

	rfi_fk_creator_fax_ccopn.`id` AS 'rfi_fk_creator_fax_ccopn__contact_company_office_phone_number_id',
	rfi_fk_creator_fax_ccopn.`contact_company_office_id` AS 'rfi_fk_creator_fax_ccopn__contact_company_office_id',
	rfi_fk_creator_fax_ccopn.`phone_number_type_id` AS 'rfi_fk_creator_fax_ccopn__phone_number_type_id',
	rfi_fk_creator_fax_ccopn.`country_code` AS 'rfi_fk_creator_fax_ccopn__country_code',
	rfi_fk_creator_fax_ccopn.`area_code` AS 'rfi_fk_creator_fax_ccopn__area_code',
	rfi_fk_creator_fax_ccopn.`prefix` AS 'rfi_fk_creator_fax_ccopn__prefix',
	rfi_fk_creator_fax_ccopn.`number` AS 'rfi_fk_creator_fax_ccopn__number',
	rfi_fk_creator_fax_ccopn.`extension` AS 'rfi_fk_creator_fax_ccopn__extension',
	rfi_fk_creator_fax_ccopn.`itu` AS 'rfi_fk_creator_fax_ccopn__itu',

	rfi_fk_creator_c_mobile_cpn.`id` AS 'rfi_fk_creator_c_mobile_cpn__contact_phone_number_id',
	rfi_fk_creator_c_mobile_cpn.`contact_id` AS 'rfi_fk_creator_c_mobile_cpn__contact_id',
	rfi_fk_creator_c_mobile_cpn.`phone_number_type_id` AS 'rfi_fk_creator_c_mobile_cpn__phone_number_type_id',
	rfi_fk_creator_c_mobile_cpn.`country_code` AS 'rfi_fk_creator_c_mobile_cpn__country_code',
	rfi_fk_creator_c_mobile_cpn.`area_code` AS 'rfi_fk_creator_c_mobile_cpn__area_code',
	rfi_fk_creator_c_mobile_cpn.`prefix` AS 'rfi_fk_creator_c_mobile_cpn__prefix',
	rfi_fk_creator_c_mobile_cpn.`number` AS 'rfi_fk_creator_c_mobile_cpn__number',
	rfi_fk_creator_c_mobile_cpn.`extension` AS 'rfi_fk_creator_c_mobile_cpn__extension',
	rfi_fk_creator_c_mobile_cpn.`itu` AS 'rfi_fk_creator_c_mobile_cpn__itu',

	rfi_fk_recipient_c.`id` AS 'rfi_fk_recipient_c__contact_id',
	rfi_fk_recipient_c.`user_company_id` AS 'rfi_fk_recipient_c__user_company_id',
	rfi_fk_recipient_c.`user_id` AS 'rfi_fk_recipient_c__user_id',
	rfi_fk_recipient_c.`contact_company_id` AS 'rfi_fk_recipient_c__contact_company_id',
	rfi_fk_recipient_c.`email` AS 'rfi_fk_recipient_c__email',
	rfi_fk_recipient_c.`name_prefix` AS 'rfi_fk_recipient_c__name_prefix',
	rfi_fk_recipient_c.`first_name` AS 'rfi_fk_recipient_c__first_name',
	rfi_fk_recipient_c.`additional_name` AS 'rfi_fk_recipient_c__additional_name',
	rfi_fk_recipient_c.`middle_name` AS 'rfi_fk_recipient_c__middle_name',
	rfi_fk_recipient_c.`last_name` AS 'rfi_fk_recipient_c__last_name',
	rfi_fk_recipient_c.`name_suffix` AS 'rfi_fk_recipient_c__name_suffix',
	rfi_fk_recipient_c.`title` AS 'rfi_fk_recipient_c__title',
	rfi_fk_recipient_c.`vendor_flag` AS 'rfi_fk_recipient_c__vendor_flag',

	rfi_fk_recipient_cco.`id` AS 'rfi_fk_recipient_cco__contact_company_office_id',
	rfi_fk_recipient_cco.`contact_company_id` AS 'rfi_fk_recipient_cco__contact_company_id',
	rfi_fk_recipient_cco.`office_nickname` AS 'rfi_fk_recipient_cco__office_nickname',
	rfi_fk_recipient_cco.`address_line_1` AS 'rfi_fk_recipient_cco__address_line_1',
	rfi_fk_recipient_cco.`address_line_2` AS 'rfi_fk_recipient_cco__address_line_2',
	rfi_fk_recipient_cco.`address_line_3` AS 'rfi_fk_recipient_cco__address_line_3',
	rfi_fk_recipient_cco.`address_line_4` AS 'rfi_fk_recipient_cco__address_line_4',
	rfi_fk_recipient_cco.`address_city` AS 'rfi_fk_recipient_cco__address_city',
	rfi_fk_recipient_cco.`address_county` AS 'rfi_fk_recipient_cco__address_county',
	rfi_fk_recipient_cco.`address_state_or_region` AS 'rfi_fk_recipient_cco__address_state_or_region',
	rfi_fk_recipient_cco.`address_postal_code` AS 'rfi_fk_recipient_cco__address_postal_code',
	rfi_fk_recipient_cco.`address_postal_code_extension` AS 'rfi_fk_recipient_cco__address_postal_code_extension',
	rfi_fk_recipient_cco.`address_country` AS 'rfi_fk_recipient_cco__address_country',
	rfi_fk_recipient_cco.`head_quarters_flag` AS 'rfi_fk_recipient_cco__head_quarters_flag',
	rfi_fk_recipient_cco.`address_validated_by_user_flag` AS 'rfi_fk_recipient_cco__address_validated_by_user_flag',
	rfi_fk_recipient_cco.`address_validated_by_web_service_flag` AS 'rfi_fk_recipient_cco__address_validated_by_web_service_flag',
	rfi_fk_recipient_cco.`address_validation_by_web_service_error_flag` AS 'rfi_fk_recipient_cco__address_validation_by_web_service_error_flag',

	rfi_fk_recipient_phone_ccopn.`id` AS 'rfi_fk_recipient_phone_ccopn__contact_company_office_phone_number_id',
	rfi_fk_recipient_phone_ccopn.`contact_company_office_id` AS 'rfi_fk_recipient_phone_ccopn__contact_company_office_id',
	rfi_fk_recipient_phone_ccopn.`phone_number_type_id` AS 'rfi_fk_recipient_phone_ccopn__phone_number_type_id',
	rfi_fk_recipient_phone_ccopn.`country_code` AS 'rfi_fk_recipient_phone_ccopn__country_code',
	rfi_fk_recipient_phone_ccopn.`area_code` AS 'rfi_fk_recipient_phone_ccopn__area_code',
	rfi_fk_recipient_phone_ccopn.`prefix` AS 'rfi_fk_recipient_phone_ccopn__prefix',
	rfi_fk_recipient_phone_ccopn.`number` AS 'rfi_fk_recipient_phone_ccopn__number',
	rfi_fk_recipient_phone_ccopn.`extension` AS 'rfi_fk_recipient_phone_ccopn__extension',
	rfi_fk_recipient_phone_ccopn.`itu` AS 'rfi_fk_recipient_phone_ccopn__itu',

	rfi_fk_recipient_fax_ccopn.`id` AS 'rfi_fk_recipient_fax_ccopn__contact_company_office_phone_number_id',
	rfi_fk_recipient_fax_ccopn.`contact_company_office_id` AS 'rfi_fk_recipient_fax_ccopn__contact_company_office_id',
	rfi_fk_recipient_fax_ccopn.`phone_number_type_id` AS 'rfi_fk_recipient_fax_ccopn__phone_number_type_id',
	rfi_fk_recipient_fax_ccopn.`country_code` AS 'rfi_fk_recipient_fax_ccopn__country_code',
	rfi_fk_recipient_fax_ccopn.`area_code` AS 'rfi_fk_recipient_fax_ccopn__area_code',
	rfi_fk_recipient_fax_ccopn.`prefix` AS 'rfi_fk_recipient_fax_ccopn__prefix',
	rfi_fk_recipient_fax_ccopn.`number` AS 'rfi_fk_recipient_fax_ccopn__number',
	rfi_fk_recipient_fax_ccopn.`extension` AS 'rfi_fk_recipient_fax_ccopn__extension',
	rfi_fk_recipient_fax_ccopn.`itu` AS 'rfi_fk_recipient_fax_ccopn__itu',

	rfi_fk_recipient_c_mobile_cpn.`id` AS 'rfi_fk_recipient_c_mobile_cpn__contact_phone_number_id',
	rfi_fk_recipient_c_mobile_cpn.`contact_id` AS 'rfi_fk_recipient_c_mobile_cpn__contact_id',
	rfi_fk_recipient_c_mobile_cpn.`phone_number_type_id` AS 'rfi_fk_recipient_c_mobile_cpn__phone_number_type_id',
	rfi_fk_recipient_c_mobile_cpn.`country_code` AS 'rfi_fk_recipient_c_mobile_cpn__country_code',
	rfi_fk_recipient_c_mobile_cpn.`area_code` AS 'rfi_fk_recipient_c_mobile_cpn__area_code',
	rfi_fk_recipient_c_mobile_cpn.`prefix` AS 'rfi_fk_recipient_c_mobile_cpn__prefix',
	rfi_fk_recipient_c_mobile_cpn.`number` AS 'rfi_fk_recipient_c_mobile_cpn__number',
	rfi_fk_recipient_c_mobile_cpn.`extension` AS 'rfi_fk_recipient_c_mobile_cpn__extension',
	rfi_fk_recipient_c_mobile_cpn.`itu` AS 'rfi_fk_recipient_c_mobile_cpn__itu',

	rfi_fk_initiator_c.`id` AS 'rfi_fk_initiator_c__contact_id',
	rfi_fk_initiator_c.`user_company_id` AS 'rfi_fk_initiator_c__user_company_id',
	rfi_fk_initiator_c.`user_id` AS 'rfi_fk_initiator_c__user_id',
	rfi_fk_initiator_c.`contact_company_id` AS 'rfi_fk_initiator_c__contact_company_id',
	rfi_fk_initiator_c.`email` AS 'rfi_fk_initiator_c__email',
	rfi_fk_initiator_c.`name_prefix` AS 'rfi_fk_initiator_c__name_prefix',
	rfi_fk_initiator_c.`first_name` AS 'rfi_fk_initiator_c__first_name',
	rfi_fk_initiator_c.`additional_name` AS 'rfi_fk_initiator_c__additional_name',
	rfi_fk_initiator_c.`middle_name` AS 'rfi_fk_initiator_c__middle_name',
	rfi_fk_initiator_c.`last_name` AS 'rfi_fk_initiator_c__last_name',
	rfi_fk_initiator_c.`name_suffix` AS 'rfi_fk_initiator_c__name_suffix',
	rfi_fk_initiator_c.`title` AS 'rfi_fk_initiator_c__title',
	rfi_fk_initiator_c.`vendor_flag` AS 'rfi_fk_initiator_c__vendor_flag',

	rfi_fk_initiator_cco.`id` AS 'rfi_fk_initiator_cco__contact_company_office_id',
	rfi_fk_initiator_cco.`contact_company_id` AS 'rfi_fk_initiator_cco__contact_company_id',
	rfi_fk_initiator_cco.`office_nickname` AS 'rfi_fk_initiator_cco__office_nickname',
	rfi_fk_initiator_cco.`address_line_1` AS 'rfi_fk_initiator_cco__address_line_1',
	rfi_fk_initiator_cco.`address_line_2` AS 'rfi_fk_initiator_cco__address_line_2',
	rfi_fk_initiator_cco.`address_line_3` AS 'rfi_fk_initiator_cco__address_line_3',
	rfi_fk_initiator_cco.`address_line_4` AS 'rfi_fk_initiator_cco__address_line_4',
	rfi_fk_initiator_cco.`address_city` AS 'rfi_fk_initiator_cco__address_city',
	rfi_fk_initiator_cco.`address_county` AS 'rfi_fk_initiator_cco__address_county',
	rfi_fk_initiator_cco.`address_state_or_region` AS 'rfi_fk_initiator_cco__address_state_or_region',
	rfi_fk_initiator_cco.`address_postal_code` AS 'rfi_fk_initiator_cco__address_postal_code',
	rfi_fk_initiator_cco.`address_postal_code_extension` AS 'rfi_fk_initiator_cco__address_postal_code_extension',
	rfi_fk_initiator_cco.`address_country` AS 'rfi_fk_initiator_cco__address_country',
	rfi_fk_initiator_cco.`head_quarters_flag` AS 'rfi_fk_initiator_cco__head_quarters_flag',
	rfi_fk_initiator_cco.`address_validated_by_user_flag` AS 'rfi_fk_initiator_cco__address_validated_by_user_flag',
	rfi_fk_initiator_cco.`address_validated_by_web_service_flag` AS 'rfi_fk_initiator_cco__address_validated_by_web_service_flag',
	rfi_fk_initiator_cco.`address_validation_by_web_service_error_flag` AS 'rfi_fk_initiator_cco__address_validation_by_web_service_error_flag',

	rfi_fk_initiator_phone_ccopn.`id` AS 'rfi_fk_initiator_phone_ccopn__contact_company_office_phone_number_id',
	rfi_fk_initiator_phone_ccopn.`contact_company_office_id` AS 'rfi_fk_initiator_phone_ccopn__contact_company_office_id',
	rfi_fk_initiator_phone_ccopn.`phone_number_type_id` AS 'rfi_fk_initiator_phone_ccopn__phone_number_type_id',
	rfi_fk_initiator_phone_ccopn.`country_code` AS 'rfi_fk_initiator_phone_ccopn__country_code',
	rfi_fk_initiator_phone_ccopn.`area_code` AS 'rfi_fk_initiator_phone_ccopn__area_code',
	rfi_fk_initiator_phone_ccopn.`prefix` AS 'rfi_fk_initiator_phone_ccopn__prefix',
	rfi_fk_initiator_phone_ccopn.`number` AS 'rfi_fk_initiator_phone_ccopn__number',
	rfi_fk_initiator_phone_ccopn.`extension` AS 'rfi_fk_initiator_phone_ccopn__extension',
	rfi_fk_initiator_phone_ccopn.`itu` AS 'rfi_fk_initiator_phone_ccopn__itu',

	rfi_fk_initiator_fax_ccopn.`id` AS 'rfi_fk_initiator_fax_ccopn__contact_company_office_phone_number_id',
	rfi_fk_initiator_fax_ccopn.`contact_company_office_id` AS 'rfi_fk_initiator_fax_ccopn__contact_company_office_id',
	rfi_fk_initiator_fax_ccopn.`phone_number_type_id` AS 'rfi_fk_initiator_fax_ccopn__phone_number_type_id',
	rfi_fk_initiator_fax_ccopn.`country_code` AS 'rfi_fk_initiator_fax_ccopn__country_code',
	rfi_fk_initiator_fax_ccopn.`area_code` AS 'rfi_fk_initiator_fax_ccopn__area_code',
	rfi_fk_initiator_fax_ccopn.`prefix` AS 'rfi_fk_initiator_fax_ccopn__prefix',
	rfi_fk_initiator_fax_ccopn.`number` AS 'rfi_fk_initiator_fax_ccopn__number',
	rfi_fk_initiator_fax_ccopn.`extension` AS 'rfi_fk_initiator_fax_ccopn__extension',
	rfi_fk_initiator_fax_ccopn.`itu` AS 'rfi_fk_initiator_fax_ccopn__itu',

	rfi_fk_initiator_c_mobile_cpn.`id` AS 'rfi_fk_initiator_c_mobile_cpn__contact_phone_number_id',
	rfi_fk_initiator_c_mobile_cpn.`contact_id` AS 'rfi_fk_initiator_c_mobile_cpn__contact_id',
	rfi_fk_initiator_c_mobile_cpn.`phone_number_type_id` AS 'rfi_fk_initiator_c_mobile_cpn__phone_number_type_id',
	rfi_fk_initiator_c_mobile_cpn.`country_code` AS 'rfi_fk_initiator_c_mobile_cpn__country_code',
	rfi_fk_initiator_c_mobile_cpn.`area_code` AS 'rfi_fk_initiator_c_mobile_cpn__area_code',
	rfi_fk_initiator_c_mobile_cpn.`prefix` AS 'rfi_fk_initiator_c_mobile_cpn__prefix',
	rfi_fk_initiator_c_mobile_cpn.`number` AS 'rfi_fk_initiator_c_mobile_cpn__number',
	rfi_fk_initiator_c_mobile_cpn.`extension` AS 'rfi_fk_initiator_c_mobile_cpn__extension',
	rfi_fk_initiator_c_mobile_cpn.`itu` AS 'rfi_fk_initiator_c_mobile_cpn__itu',

	rfi.*

FROM `requests_for_information` rfi
	INNER JOIN `projects` rfi_fk_p ON rfi.`project_id` = rfi_fk_p.`id`
	INNER JOIN `request_for_information_types` rfi_fk_rfit ON rfi.`request_for_information_type_id` = rfi_fk_rfit.`id`
	INNER JOIN `request_for_information_statuses` rfi_fk_rfis ON rfi.`request_for_information_status_id` = rfi_fk_rfis.`id`
	INNER JOIN `request_for_information_priorities` rfi_fk_rfip ON rfi.`request_for_information_priority_id` = rfi_fk_rfip.`id`
	LEFT OUTER JOIN `file_manager_files` rfi_fk_fmfiles ON rfi.`rfi_file_manager_file_id` = rfi_fk_fmfiles.`id`
	LEFT OUTER JOIN `cost_codes` rfi_fk_codes ON rfi.`rfi_cost_code_id` = rfi_fk_codes.`id`
	INNER JOIN `contacts` rfi_fk_creator_c ON rfi.`rfi_creator_contact_id` = rfi_fk_creator_c.`id`
	LEFT OUTER JOIN `contact_company_offices` rfi_fk_creator_cco ON rfi.`rfi_creator_contact_company_office_id` = rfi_fk_creator_cco.`id`
	LEFT OUTER JOIN `contact_company_office_phone_numbers` rfi_fk_creator_phone_ccopn ON rfi.`rfi_creator_phone_contact_company_office_phone_number_id` = rfi_fk_creator_phone_ccopn.`id`
	LEFT OUTER JOIN `contact_company_office_phone_numbers` rfi_fk_creator_fax_ccopn ON rfi.`rfi_creator_fax_contact_company_office_phone_number_id` = rfi_fk_creator_fax_ccopn.`id`
	LEFT OUTER JOIN `contact_phone_numbers` rfi_fk_creator_c_mobile_cpn ON rfi.`rfi_creator_contact_mobile_phone_number_id` = rfi_fk_creator_c_mobile_cpn.`id`
	LEFT OUTER JOIN `contacts` rfi_fk_recipient_c ON rfi.`rfi_recipient_contact_id` = rfi_fk_recipient_c.`id`
	LEFT OUTER JOIN `contact_company_offices` rfi_fk_recipient_cco ON rfi.`rfi_recipient_contact_company_office_id` = rfi_fk_recipient_cco.`id`
	LEFT OUTER JOIN `contact_company_office_phone_numbers` rfi_fk_recipient_phone_ccopn ON rfi.`rfi_recipient_phone_contact_company_office_phone_number_id` = rfi_fk_recipient_phone_ccopn.`id`
	LEFT OUTER JOIN `contact_company_office_phone_numbers` rfi_fk_recipient_fax_ccopn ON rfi.`rfi_recipient_fax_contact_company_office_phone_number_id` = rfi_fk_recipient_fax_ccopn.`id`
	LEFT OUTER JOIN `contact_phone_numbers` rfi_fk_recipient_c_mobile_cpn ON rfi.`rfi_recipient_contact_mobile_phone_number_id` = rfi_fk_recipient_c_mobile_cpn.`id`
	LEFT OUTER JOIN `contacts` rfi_fk_initiator_c ON rfi.`rfi_initiator_contact_id` = rfi_fk_initiator_c.`id`
	LEFT OUTER JOIN `contact_company_offices` rfi_fk_initiator_cco ON rfi.`rfi_initiator_contact_company_office_id` = rfi_fk_initiator_cco.`id`
	LEFT OUTER JOIN `contact_company_office_phone_numbers` rfi_fk_initiator_phone_ccopn ON rfi.`rfi_initiator_phone_contact_company_office_phone_number_id` = rfi_fk_initiator_phone_ccopn.`id`
	LEFT OUTER JOIN `contact_company_office_phone_numbers` rfi_fk_initiator_fax_ccopn ON rfi.`rfi_initiator_fax_contact_company_office_phone_number_id` = rfi_fk_initiator_fax_ccopn.`id`
	LEFT OUTER JOIN `contact_phone_numbers` rfi_fk_initiator_c_mobile_cpn ON rfi.`rfi_initiator_contact_mobile_phone_number_id` = rfi_fk_initiator_c_mobile_cpn.`id`
WHERE rfi.`project_id` = ? and date(rfi.created) between '$new_begindate'  and '$enddate'{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `rfi_sequence_number` ASC, `request_for_information_type_id` ASC, `request_for_information_status_id` ASC, `request_for_information_priority_id` ASC, `rfi_file_manager_file_id` ASC, `rfi_cost_code_id` ASC, `rfi_creator_contact_id` ASC, `rfi_creator_contact_company_office_id` ASC, `rfi_creator_phone_contact_company_office_phone_number_id` ASC, `rfi_creator_fax_contact_company_office_phone_number_id` ASC, `rfi_creator_contact_mobile_phone_number_id` ASC, `rfi_recipient_contact_id` ASC, `rfi_recipient_contact_company_office_id` ASC, `rfi_recipient_phone_contact_company_office_phone_number_id` ASC, `rfi_recipient_fax_contact_company_office_phone_number_id` ASC, `rfi_recipient_contact_mobile_phone_number_id` ASC, `rfi_initiator_contact_id` ASC, `rfi_initiator_contact_company_office_id` ASC, `rfi_initiator_phone_contact_company_office_phone_number_id` ASC, `rfi_initiator_fax_contact_company_office_phone_number_id` ASC, `rfi_initiator_contact_mobile_phone_number_id` ASC, `rfi_title` ASC, `rfi_plan_page_reference` ASC, `rfi_statement` ASC, `created` ASC, `rfi_due_date` ASC, `rfi_closed_date` ASC
		$arrValues = array($project_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrRequestsForInformationByProjectId = array();
		while ($row = $db->fetch()) {
			$request_for_information_id = $row['id'];
			$requestForInformation = self::instantiateOrm($database, 'RequestForInformation', $row, null, $request_for_information_id);
			/* @var $requestForInformation RequestForInformation */
			$requestForInformation->convertPropertiesToData();

			if (isset($row['project_id'])) {
				$project_id = $row['project_id'];
				$row['rfi_fk_p__id'] = $project_id;
				$project = self::instantiateOrm($database, 'Project', $row, null, $project_id, 'rfi_fk_p__');
				/* @var $project Project */
				$project->convertPropertiesToData();
			} else {
				$project = false;
			}
			$requestForInformation->setProject($project);

			if (isset($row['request_for_information_type_id'])) {
				$request_for_information_type_id = $row['request_for_information_type_id'];
				$row['rfi_fk_rfit__id'] = $request_for_information_type_id;
				$requestForInformationType = self::instantiateOrm($database, 'RequestForInformationType', $row, null, $request_for_information_type_id, 'rfi_fk_rfit__');
				/* @var $requestForInformationType RequestForInformationType */
				$requestForInformationType->convertPropertiesToData();
			} else {
				$requestForInformationType = false;
			}
			$requestForInformation->setRequestForInformationType($requestForInformationType);

			if (isset($row['request_for_information_status_id'])) {
				$request_for_information_status_id = $row['request_for_information_status_id'];
				$row['rfi_fk_rfis__id'] = $request_for_information_status_id;
				$requestForInformationStatus = self::instantiateOrm($database, 'RequestForInformationStatus', $row, null, $request_for_information_status_id, 'rfi_fk_rfis__');
				/* @var $requestForInformationStatus RequestForInformationStatus */
				$requestForInformationStatus->convertPropertiesToData();
			} else {
				$requestForInformationStatus = false;
			}
			$requestForInformation->setRequestForInformationStatus($requestForInformationStatus);

			if (isset($row['request_for_information_priority_id'])) {
				$request_for_information_priority_id = $row['request_for_information_priority_id'];
				$row['rfi_fk_rfip__id'] = $request_for_information_priority_id;
				$requestForInformationPriority = self::instantiateOrm($database, 'RequestForInformationPriority', $row, null, $request_for_information_priority_id, 'rfi_fk_rfip__');
				/* @var $requestForInformationPriority RequestForInformationPriority */
				$requestForInformationPriority->convertPropertiesToData();
			} else {
				$requestForInformationPriority = false;
			}
			$requestForInformation->setRequestForInformationPriority($requestForInformationPriority);

			if (isset($row['rfi_file_manager_file_id'])) {
				$rfi_file_manager_file_id = $row['rfi_file_manager_file_id'];
				$row['rfi_fk_fmfiles__id'] = $rfi_file_manager_file_id;
				$rfiFileManagerFile = self::instantiateOrm($database, 'FileManagerFile', $row, null, $rfi_file_manager_file_id, 'rfi_fk_fmfiles__');
				/* @var $rfiFileManagerFile FileManagerFile */
				$rfiFileManagerFile->convertPropertiesToData();
			} else {
				$rfiFileManagerFile = false;
			}
			$requestForInformation->setRfiFileManagerFile($rfiFileManagerFile);

			if (isset($row['rfi_cost_code_id'])) {
				$rfi_cost_code_id = $row['rfi_cost_code_id'];
				$row['rfi_fk_codes__id'] = $rfi_cost_code_id;
				$rfiCostCode = self::instantiateOrm($database, 'CostCode', $row, null, $rfi_cost_code_id, 'rfi_fk_codes__');
				/* @var $rfiCostCode CostCode */
				$rfiCostCode->convertPropertiesToData();
			} else {
				$rfiCostCode = false;
			}
			$requestForInformation->setRfiCostCode($rfiCostCode);

			if (isset($row['rfi_creator_contact_id'])) {
				$rfi_creator_contact_id = $row['rfi_creator_contact_id'];
				$row['rfi_fk_creator_c__id'] = $rfi_creator_contact_id;
				$rfiCreatorContact = self::instantiateOrm($database, 'Contact', $row, null, $rfi_creator_contact_id, 'rfi_fk_creator_c__');
				/* @var $rfiCreatorContact Contact */
				$rfiCreatorContact->convertPropertiesToData();
			} else {
				$rfiCreatorContact = false;
			}
			$requestForInformation->setRfiCreatorContact($rfiCreatorContact);

			if (isset($row['rfi_creator_contact_company_office_id'])) {
				$rfi_creator_contact_company_office_id = $row['rfi_creator_contact_company_office_id'];
				$row['rfi_fk_creator_cco__id'] = $rfi_creator_contact_company_office_id;
				$rfiCreatorContactCompanyOffice = self::instantiateOrm($database, 'ContactCompanyOffice', $row, null, $rfi_creator_contact_company_office_id, 'rfi_fk_creator_cco__');
				/* @var $rfiCreatorContactCompanyOffice ContactCompanyOffice */
				$rfiCreatorContactCompanyOffice->convertPropertiesToData();
			} else {
				$rfiCreatorContactCompanyOffice = false;
			}
			$requestForInformation->setRfiCreatorContactCompanyOffice($rfiCreatorContactCompanyOffice);

			if (isset($row['rfi_creator_phone_contact_company_office_phone_number_id'])) {
				$rfi_creator_phone_contact_company_office_phone_number_id = $row['rfi_creator_phone_contact_company_office_phone_number_id'];
				$row['rfi_fk_creator_phone_ccopn__id'] = $rfi_creator_phone_contact_company_office_phone_number_id;
				$rfiCreatorPhoneContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $rfi_creator_phone_contact_company_office_phone_number_id, 'rfi_fk_creator_phone_ccopn__');
				/* @var $rfiCreatorPhoneContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$rfiCreatorPhoneContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$rfiCreatorPhoneContactCompanyOfficePhoneNumber = false;
			}
			$requestForInformation->setRfiCreatorPhoneContactCompanyOfficePhoneNumber($rfiCreatorPhoneContactCompanyOfficePhoneNumber);

			if (isset($row['rfi_creator_fax_contact_company_office_phone_number_id'])) {
				$rfi_creator_fax_contact_company_office_phone_number_id = $row['rfi_creator_fax_contact_company_office_phone_number_id'];
				$row['rfi_fk_creator_fax_ccopn__id'] = $rfi_creator_fax_contact_company_office_phone_number_id;
				$rfiCreatorFaxContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $rfi_creator_fax_contact_company_office_phone_number_id, 'rfi_fk_creator_fax_ccopn__');
				/* @var $rfiCreatorFaxContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$rfiCreatorFaxContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$rfiCreatorFaxContactCompanyOfficePhoneNumber = false;
			}
			$requestForInformation->setRfiCreatorFaxContactCompanyOfficePhoneNumber($rfiCreatorFaxContactCompanyOfficePhoneNumber);

			if (isset($row['rfi_creator_contact_mobile_phone_number_id'])) {
				$rfi_creator_contact_mobile_phone_number_id = $row['rfi_creator_contact_mobile_phone_number_id'];
				$row['rfi_fk_creator_c_mobile_cpn__id'] = $rfi_creator_contact_mobile_phone_number_id;
				$rfiCreatorContactMobilePhoneNumber = self::instantiateOrm($database, 'ContactPhoneNumber', $row, null, $rfi_creator_contact_mobile_phone_number_id, 'rfi_fk_creator_c_mobile_cpn__');
				/* @var $rfiCreatorContactMobilePhoneNumber ContactPhoneNumber */
				$rfiCreatorContactMobilePhoneNumber->convertPropertiesToData();
			} else {
				$rfiCreatorContactMobilePhoneNumber = false;
			}
			$requestForInformation->setRfiCreatorContactMobilePhoneNumber($rfiCreatorContactMobilePhoneNumber);

			if (isset($row['rfi_recipient_contact_id'])) {
				$rfi_recipient_contact_id = $row['rfi_recipient_contact_id'];
				$row['rfi_fk_recipient_c__id'] = $rfi_recipient_contact_id;
				$rfiRecipientContact = self::instantiateOrm($database, 'Contact', $row, null, $rfi_recipient_contact_id, 'rfi_fk_recipient_c__');
				/* @var $rfiRecipientContact Contact */
				$rfiRecipientContact->convertPropertiesToData();
			} else {
				$rfiRecipientContact = false;
			}
			$requestForInformation->setRfiRecipientContact($rfiRecipientContact);

			if (isset($row['rfi_recipient_contact_company_office_id'])) {
				$rfi_recipient_contact_company_office_id = $row['rfi_recipient_contact_company_office_id'];
				$row['rfi_fk_recipient_cco__id'] = $rfi_recipient_contact_company_office_id;
				$rfiRecipientContactCompanyOffice = self::instantiateOrm($database, 'ContactCompanyOffice', $row, null, $rfi_recipient_contact_company_office_id, 'rfi_fk_recipient_cco__');
				/* @var $rfiRecipientContactCompanyOffice ContactCompanyOffice */
				$rfiRecipientContactCompanyOffice->convertPropertiesToData();
			} else {
				$rfiRecipientContactCompanyOffice = false;
			}
			$requestForInformation->setRfiRecipientContactCompanyOffice($rfiRecipientContactCompanyOffice);

			if (isset($row['rfi_recipient_phone_contact_company_office_phone_number_id'])) {
				$rfi_recipient_phone_contact_company_office_phone_number_id = $row['rfi_recipient_phone_contact_company_office_phone_number_id'];
				$row['rfi_fk_recipient_phone_ccopn__id'] = $rfi_recipient_phone_contact_company_office_phone_number_id;
				$rfiRecipientPhoneContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $rfi_recipient_phone_contact_company_office_phone_number_id, 'rfi_fk_recipient_phone_ccopn__');
				/* @var $rfiRecipientPhoneContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$rfiRecipientPhoneContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$rfiRecipientPhoneContactCompanyOfficePhoneNumber = false;
			}
			$requestForInformation->setRfiRecipientPhoneContactCompanyOfficePhoneNumber($rfiRecipientPhoneContactCompanyOfficePhoneNumber);

			if (isset($row['rfi_recipient_fax_contact_company_office_phone_number_id'])) {
				$rfi_recipient_fax_contact_company_office_phone_number_id = $row['rfi_recipient_fax_contact_company_office_phone_number_id'];
				$row['rfi_fk_recipient_fax_ccopn__id'] = $rfi_recipient_fax_contact_company_office_phone_number_id;
				$rfiRecipientFaxContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $rfi_recipient_fax_contact_company_office_phone_number_id, 'rfi_fk_recipient_fax_ccopn__');
				/* @var $rfiRecipientFaxContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$rfiRecipientFaxContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$rfiRecipientFaxContactCompanyOfficePhoneNumber = false;
			}
			$requestForInformation->setRfiRecipientFaxContactCompanyOfficePhoneNumber($rfiRecipientFaxContactCompanyOfficePhoneNumber);

			if (isset($row['rfi_recipient_contact_mobile_phone_number_id'])) {
				$rfi_recipient_contact_mobile_phone_number_id = $row['rfi_recipient_contact_mobile_phone_number_id'];
				$row['rfi_fk_recipient_c_mobile_cpn__id'] = $rfi_recipient_contact_mobile_phone_number_id;
				$rfiRecipientContactMobilePhoneNumber = self::instantiateOrm($database, 'ContactPhoneNumber', $row, null, $rfi_recipient_contact_mobile_phone_number_id, 'rfi_fk_recipient_c_mobile_cpn__');
				/* @var $rfiRecipientContactMobilePhoneNumber ContactPhoneNumber */
				$rfiRecipientContactMobilePhoneNumber->convertPropertiesToData();
			} else {
				$rfiRecipientContactMobilePhoneNumber = false;
			}
			$requestForInformation->setRfiRecipientContactMobilePhoneNumber($rfiRecipientContactMobilePhoneNumber);

			if (isset($row['rfi_initiator_contact_id'])) {
				$rfi_initiator_contact_id = $row['rfi_initiator_contact_id'];
				$row['rfi_fk_initiator_c__id'] = $rfi_initiator_contact_id;
				$rfiInitiatorContact = self::instantiateOrm($database, 'Contact', $row, null, $rfi_initiator_contact_id, 'rfi_fk_initiator_c__');
				/* @var $rfiInitiatorContact Contact */
				$rfiInitiatorContact->convertPropertiesToData();
			} else {
				$rfiInitiatorContact = false;
			}
			$requestForInformation->setRfiInitiatorContact($rfiInitiatorContact);

			if (isset($row['rfi_initiator_contact_company_office_id'])) {
				$rfi_initiator_contact_company_office_id = $row['rfi_initiator_contact_company_office_id'];
				$row['rfi_fk_initiator_cco__id'] = $rfi_initiator_contact_company_office_id;
				$rfiInitiatorContactCompanyOffice = self::instantiateOrm($database, 'ContactCompanyOffice', $row, null, $rfi_initiator_contact_company_office_id, 'rfi_fk_initiator_cco__');
				/* @var $rfiInitiatorContactCompanyOffice ContactCompanyOffice */
				$rfiInitiatorContactCompanyOffice->convertPropertiesToData();
			} else {
				$rfiInitiatorContactCompanyOffice = false;
			}
			$requestForInformation->setRfiInitiatorContactCompanyOffice($rfiInitiatorContactCompanyOffice);

			if (isset($row['rfi_initiator_phone_contact_company_office_phone_number_id'])) {
				$rfi_initiator_phone_contact_company_office_phone_number_id = $row['rfi_initiator_phone_contact_company_office_phone_number_id'];
				$row['rfi_fk_initiator_phone_ccopn__id'] = $rfi_initiator_phone_contact_company_office_phone_number_id;
				$rfiInitiatorPhoneContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $rfi_initiator_phone_contact_company_office_phone_number_id, 'rfi_fk_initiator_phone_ccopn__');
				/* @var $rfiInitiatorPhoneContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$rfiInitiatorPhoneContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$rfiInitiatorPhoneContactCompanyOfficePhoneNumber = false;
			}
			$requestForInformation->setRfiInitiatorPhoneContactCompanyOfficePhoneNumber($rfiInitiatorPhoneContactCompanyOfficePhoneNumber);

			if (isset($row['rfi_initiator_fax_contact_company_office_phone_number_id'])) {
				$rfi_initiator_fax_contact_company_office_phone_number_id = $row['rfi_initiator_fax_contact_company_office_phone_number_id'];
				$row['rfi_fk_initiator_fax_ccopn__id'] = $rfi_initiator_fax_contact_company_office_phone_number_id;
				$rfiInitiatorFaxContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $rfi_initiator_fax_contact_company_office_phone_number_id, 'rfi_fk_initiator_fax_ccopn__');
				/* @var $rfiInitiatorFaxContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$rfiInitiatorFaxContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$rfiInitiatorFaxContactCompanyOfficePhoneNumber = false;
			}
			$requestForInformation->setRfiInitiatorFaxContactCompanyOfficePhoneNumber($rfiInitiatorFaxContactCompanyOfficePhoneNumber);

			if (isset($row['rfi_initiator_contact_mobile_phone_number_id'])) {
				$rfi_initiator_contact_mobile_phone_number_id = $row['rfi_initiator_contact_mobile_phone_number_id'];
				$row['rfi_fk_initiator_c_mobile_cpn__id'] = $rfi_initiator_contact_mobile_phone_number_id;
				$rfiInitiatorContactMobilePhoneNumber = self::instantiateOrm($database, 'ContactPhoneNumber', $row, null, $rfi_initiator_contact_mobile_phone_number_id, 'rfi_fk_initiator_c_mobile_cpn__');
				/* @var $rfiInitiatorContactMobilePhoneNumber ContactPhoneNumber */
				$rfiInitiatorContactMobilePhoneNumber->convertPropertiesToData();
			} else {
				$rfiInitiatorContactMobilePhoneNumber = false;
			}
			$requestForInformation->setRfiInitiatorContactMobilePhoneNumber($rfiInitiatorContactMobilePhoneNumber);

			$arrRequestsForInformationByProjectId[$request_for_information_id] = $requestForInformation;
		}

		$db->free_result();

		self::$_arrRequestsForInformationByProjectId = $arrRequestsForInformationByProjectId;

		return $arrRequestsForInformationByProjectId;
	}
	// Loaders: Load By Foreign Key for report meeting
	/**
	 * Load by constraint `requests_for_information_fk_p` foreign key (`project_id`) references `projects` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $project_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadRequestsForInformationByIdIn($database, $project_id, Input $options=null, $WhereIn)
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
			self::$_arrRequestsForInformationByProjectId = null;
		}

		$arrRequestsForInformationByProjectId = self::$_arrRequestsForInformationByProjectId;
		if (isset($arrRequestsForInformationByProjectId) && !empty($arrRequestsForInformationByProjectId)) {
			return $arrRequestsForInformationByProjectId;
		}

		$project_id = (int) $project_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `rfi_sequence_number` ASC, `request_for_information_type_id` ASC, `request_for_information_status_id` ASC, `request_for_information_priority_id` ASC, `rfi_file_manager_file_id` ASC, `rfi_cost_code_id` ASC, `rfi_creator_contact_id` ASC, `rfi_creator_contact_company_office_id` ASC, `rfi_creator_phone_contact_company_office_phone_number_id` ASC, `rfi_creator_fax_contact_company_office_phone_number_id` ASC, `rfi_creator_contact_mobile_phone_number_id` ASC, `rfi_recipient_contact_id` ASC, `rfi_recipient_contact_company_office_id` ASC, `rfi_recipient_phone_contact_company_office_phone_number_id` ASC, `rfi_recipient_fax_contact_company_office_phone_number_id` ASC, `rfi_recipient_contact_mobile_phone_number_id` ASC, `rfi_initiator_contact_id` ASC, `rfi_initiator_contact_company_office_id` ASC, `rfi_initiator_phone_contact_company_office_phone_number_id` ASC, `rfi_initiator_fax_contact_company_office_phone_number_id` ASC, `rfi_initiator_contact_mobile_phone_number_id` ASC, `rfi_title` ASC, `rfi_plan_page_reference` ASC, `rfi_statement` ASC, `created` ASC, `rfi_due_date` ASC, `rfi_closed_date` ASC
		$sqlOrderBy = "\nORDER BY `created` DESC, `rfi_sequence_number` DESC, `request_for_information_priority_id` ASC, `request_for_information_type_id` ASC, `request_for_information_status_id` ASC";

		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpRequestForInformation = new RequestForInformation($database);
			$sqlOrderByColumns = $tmpRequestForInformation->constructSqlOrderByColumns($arrOrderByAttributes);
				
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

	rfi_fk_p.`id` AS 'rfi_fk_p__project_id',
	rfi_fk_p.`project_type_id` AS 'rfi_fk_p__project_type_id',
	rfi_fk_p.`user_company_id` AS 'rfi_fk_p__user_company_id',
	rfi_fk_p.`user_custom_project_id` AS 'rfi_fk_p__user_custom_project_id',
	rfi_fk_p.`project_name` AS 'rfi_fk_p__project_name',
	rfi_fk_p.`project_owner_name` AS 'rfi_fk_p__project_owner_name',
	rfi_fk_p.`latitude` AS 'rfi_fk_p__latitude',
	rfi_fk_p.`longitude` AS 'rfi_fk_p__longitude',
	rfi_fk_p.`address_line_1` AS 'rfi_fk_p__address_line_1',
	rfi_fk_p.`address_line_2` AS 'rfi_fk_p__address_line_2',
	rfi_fk_p.`address_line_3` AS 'rfi_fk_p__address_line_3',
	rfi_fk_p.`address_line_4` AS 'rfi_fk_p__address_line_4',
	rfi_fk_p.`address_city` AS 'rfi_fk_p__address_city',
	rfi_fk_p.`address_county` AS 'rfi_fk_p__address_county',
	rfi_fk_p.`address_state_or_region` AS 'rfi_fk_p__address_state_or_region',
	rfi_fk_p.`address_postal_code` AS 'rfi_fk_p__address_postal_code',
	rfi_fk_p.`address_postal_code_extension` AS 'rfi_fk_p__address_postal_code_extension',
	rfi_fk_p.`address_country` AS 'rfi_fk_p__address_country',
	rfi_fk_p.`building_count` AS 'rfi_fk_p__building_count',
	rfi_fk_p.`unit_count` AS 'rfi_fk_p__unit_count',
	rfi_fk_p.`gross_square_footage` AS 'rfi_fk_p__gross_square_footage',
	rfi_fk_p.`net_rentable_square_footage` AS 'rfi_fk_p__net_rentable_square_footage',
	rfi_fk_p.`is_active_flag` AS 'rfi_fk_p__is_active_flag',
	rfi_fk_p.`public_plans_flag` AS 'rfi_fk_p__public_plans_flag',
	rfi_fk_p.`prevailing_wage_flag` AS 'rfi_fk_p__prevailing_wage_flag',
	rfi_fk_p.`city_business_license_required_flag` AS 'rfi_fk_p__city_business_license_required_flag',
	rfi_fk_p.`is_internal_flag` AS 'rfi_fk_p__is_internal_flag',
	rfi_fk_p.`project_contract_date` AS 'rfi_fk_p__project_contract_date',
	rfi_fk_p.`project_start_date` AS 'rfi_fk_p__project_start_date',
	rfi_fk_p.`project_completed_date` AS 'rfi_fk_p__project_completed_date',
	rfi_fk_p.`sort_order` AS 'rfi_fk_p__sort_order',

	rfi_fk_rfit.`id` AS 'rfi_fk_rfit__request_for_information_type_id',
	rfi_fk_rfit.`request_for_information_type` AS 'rfi_fk_rfit__request_for_information_type',
	rfi_fk_rfit.`disabled_flag` AS 'rfi_fk_rfit__disabled_flag',

	rfi_fk_rfis.`id` AS 'rfi_fk_rfis__request_for_information_status_id',
	rfi_fk_rfis.`request_for_information_status` AS 'rfi_fk_rfis__request_for_information_status',
	rfi_fk_rfis.`disabled_flag` AS 'rfi_fk_rfis__disabled_flag',

	rfi_fk_rfip.`id` AS 'rfi_fk_rfip__request_for_information_priority_id',
	rfi_fk_rfip.`request_for_information_priority` AS 'rfi_fk_rfip__request_for_information_priority',
	rfi_fk_rfip.`disabled_flag` AS 'rfi_fk_rfip__disabled_flag',

	rfi_fk_fmfiles.`id` AS 'rfi_fk_fmfiles__file_manager_file_id',
	rfi_fk_fmfiles.`user_company_id` AS 'rfi_fk_fmfiles__user_company_id',
	rfi_fk_fmfiles.`contact_id` AS 'rfi_fk_fmfiles__contact_id',
	rfi_fk_fmfiles.`project_id` AS 'rfi_fk_fmfiles__project_id',
	rfi_fk_fmfiles.`file_manager_folder_id` AS 'rfi_fk_fmfiles__file_manager_folder_id',
	rfi_fk_fmfiles.`file_location_id` AS 'rfi_fk_fmfiles__file_location_id',
	rfi_fk_fmfiles.`virtual_file_name` AS 'rfi_fk_fmfiles__virtual_file_name',
	rfi_fk_fmfiles.`version_number` AS 'rfi_fk_fmfiles__version_number',
	rfi_fk_fmfiles.`virtual_file_name_sha1` AS 'rfi_fk_fmfiles__virtual_file_name_sha1',
	rfi_fk_fmfiles.`virtual_file_mime_type` AS 'rfi_fk_fmfiles__virtual_file_mime_type',
	rfi_fk_fmfiles.`modified` AS 'rfi_fk_fmfiles__modified',
	rfi_fk_fmfiles.`created` AS 'rfi_fk_fmfiles__created',
	rfi_fk_fmfiles.`deleted_flag` AS 'rfi_fk_fmfiles__deleted_flag',
	rfi_fk_fmfiles.`directly_deleted_flag` AS 'rfi_fk_fmfiles__directly_deleted_flag',

	rfi_fk_codes.`id` AS 'rfi_fk_codes__cost_code_id',
	rfi_fk_codes.`cost_code_division_id` AS 'rfi_fk_codes__cost_code_division_id',
	rfi_fk_codes.`cost_code` AS 'rfi_fk_codes__cost_code',
	rfi_fk_codes.`cost_code_description` AS 'rfi_fk_codes__cost_code_description',
	rfi_fk_codes.`cost_code_description_abbreviation` AS 'rfi_fk_codes__cost_code_description_abbreviation',
	rfi_fk_codes.`sort_order` AS 'rfi_fk_codes__sort_order',
	rfi_fk_codes.`disabled_flag` AS 'rfi_fk_codes__disabled_flag',

	rfi_fk_creator_c.`id` AS 'rfi_fk_creator_c__contact_id',
	rfi_fk_creator_c.`user_company_id` AS 'rfi_fk_creator_c__user_company_id',
	rfi_fk_creator_c.`user_id` AS 'rfi_fk_creator_c__user_id',
	rfi_fk_creator_c.`contact_company_id` AS 'rfi_fk_creator_c__contact_company_id',
	rfi_fk_creator_c.`email` AS 'rfi_fk_creator_c__email',
	rfi_fk_creator_c.`name_prefix` AS 'rfi_fk_creator_c__name_prefix',
	rfi_fk_creator_c.`first_name` AS 'rfi_fk_creator_c__first_name',
	rfi_fk_creator_c.`additional_name` AS 'rfi_fk_creator_c__additional_name',
	rfi_fk_creator_c.`middle_name` AS 'rfi_fk_creator_c__middle_name',
	rfi_fk_creator_c.`last_name` AS 'rfi_fk_creator_c__last_name',
	rfi_fk_creator_c.`name_suffix` AS 'rfi_fk_creator_c__name_suffix',
	rfi_fk_creator_c.`title` AS 'rfi_fk_creator_c__title',
	rfi_fk_creator_c.`vendor_flag` AS 'rfi_fk_creator_c__vendor_flag',
	rfi_fk_creator_c.`is_archive` AS 'rfi_fk_creator_c__is_archive',

	rfi_fk_creator_cco.`id` AS 'rfi_fk_creator_cco__contact_company_office_id',
	rfi_fk_creator_cco.`contact_company_id` AS 'rfi_fk_creator_cco__contact_company_id',
	rfi_fk_creator_cco.`office_nickname` AS 'rfi_fk_creator_cco__office_nickname',
	rfi_fk_creator_cco.`address_line_1` AS 'rfi_fk_creator_cco__address_line_1',
	rfi_fk_creator_cco.`address_line_2` AS 'rfi_fk_creator_cco__address_line_2',
	rfi_fk_creator_cco.`address_line_3` AS 'rfi_fk_creator_cco__address_line_3',
	rfi_fk_creator_cco.`address_line_4` AS 'rfi_fk_creator_cco__address_line_4',
	rfi_fk_creator_cco.`address_city` AS 'rfi_fk_creator_cco__address_city',
	rfi_fk_creator_cco.`address_county` AS 'rfi_fk_creator_cco__address_county',
	rfi_fk_creator_cco.`address_state_or_region` AS 'rfi_fk_creator_cco__address_state_or_region',
	rfi_fk_creator_cco.`address_postal_code` AS 'rfi_fk_creator_cco__address_postal_code',
	rfi_fk_creator_cco.`address_postal_code_extension` AS 'rfi_fk_creator_cco__address_postal_code_extension',
	rfi_fk_creator_cco.`address_country` AS 'rfi_fk_creator_cco__address_country',
	rfi_fk_creator_cco.`head_quarters_flag` AS 'rfi_fk_creator_cco__head_quarters_flag',
	rfi_fk_creator_cco.`address_validated_by_user_flag` AS 'rfi_fk_creator_cco__address_validated_by_user_flag',
	rfi_fk_creator_cco.`address_validated_by_web_service_flag` AS 'rfi_fk_creator_cco__address_validated_by_web_service_flag',
	rfi_fk_creator_cco.`address_validation_by_web_service_error_flag` AS 'rfi_fk_creator_cco__address_validation_by_web_service_error_flag',

	rfi_fk_creator_phone_ccopn.`id` AS 'rfi_fk_creator_phone_ccopn__contact_company_office_phone_number_id',
	rfi_fk_creator_phone_ccopn.`contact_company_office_id` AS 'rfi_fk_creator_phone_ccopn__contact_company_office_id',
	rfi_fk_creator_phone_ccopn.`phone_number_type_id` AS 'rfi_fk_creator_phone_ccopn__phone_number_type_id',
	rfi_fk_creator_phone_ccopn.`country_code` AS 'rfi_fk_creator_phone_ccopn__country_code',
	rfi_fk_creator_phone_ccopn.`area_code` AS 'rfi_fk_creator_phone_ccopn__area_code',
	rfi_fk_creator_phone_ccopn.`prefix` AS 'rfi_fk_creator_phone_ccopn__prefix',
	rfi_fk_creator_phone_ccopn.`number` AS 'rfi_fk_creator_phone_ccopn__number',
	rfi_fk_creator_phone_ccopn.`extension` AS 'rfi_fk_creator_phone_ccopn__extension',
	rfi_fk_creator_phone_ccopn.`itu` AS 'rfi_fk_creator_phone_ccopn__itu',

	rfi_fk_creator_fax_ccopn.`id` AS 'rfi_fk_creator_fax_ccopn__contact_company_office_phone_number_id',
	rfi_fk_creator_fax_ccopn.`contact_company_office_id` AS 'rfi_fk_creator_fax_ccopn__contact_company_office_id',
	rfi_fk_creator_fax_ccopn.`phone_number_type_id` AS 'rfi_fk_creator_fax_ccopn__phone_number_type_id',
	rfi_fk_creator_fax_ccopn.`country_code` AS 'rfi_fk_creator_fax_ccopn__country_code',
	rfi_fk_creator_fax_ccopn.`area_code` AS 'rfi_fk_creator_fax_ccopn__area_code',
	rfi_fk_creator_fax_ccopn.`prefix` AS 'rfi_fk_creator_fax_ccopn__prefix',
	rfi_fk_creator_fax_ccopn.`number` AS 'rfi_fk_creator_fax_ccopn__number',
	rfi_fk_creator_fax_ccopn.`extension` AS 'rfi_fk_creator_fax_ccopn__extension',
	rfi_fk_creator_fax_ccopn.`itu` AS 'rfi_fk_creator_fax_ccopn__itu',

	rfi_fk_creator_c_mobile_cpn.`id` AS 'rfi_fk_creator_c_mobile_cpn__contact_phone_number_id',
	rfi_fk_creator_c_mobile_cpn.`contact_id` AS 'rfi_fk_creator_c_mobile_cpn__contact_id',
	rfi_fk_creator_c_mobile_cpn.`phone_number_type_id` AS 'rfi_fk_creator_c_mobile_cpn__phone_number_type_id',
	rfi_fk_creator_c_mobile_cpn.`country_code` AS 'rfi_fk_creator_c_mobile_cpn__country_code',
	rfi_fk_creator_c_mobile_cpn.`area_code` AS 'rfi_fk_creator_c_mobile_cpn__area_code',
	rfi_fk_creator_c_mobile_cpn.`prefix` AS 'rfi_fk_creator_c_mobile_cpn__prefix',
	rfi_fk_creator_c_mobile_cpn.`number` AS 'rfi_fk_creator_c_mobile_cpn__number',
	rfi_fk_creator_c_mobile_cpn.`extension` AS 'rfi_fk_creator_c_mobile_cpn__extension',
	rfi_fk_creator_c_mobile_cpn.`itu` AS 'rfi_fk_creator_c_mobile_cpn__itu',

	rfi_fk_recipient_c.`id` AS 'rfi_fk_recipient_c__contact_id',
	rfi_fk_recipient_c.`user_company_id` AS 'rfi_fk_recipient_c__user_company_id',
	rfi_fk_recipient_c.`user_id` AS 'rfi_fk_recipient_c__user_id',
	rfi_fk_recipient_c.`contact_company_id` AS 'rfi_fk_recipient_c__contact_company_id',
	rfi_fk_recipient_c.`email` AS 'rfi_fk_recipient_c__email',
	rfi_fk_recipient_c.`name_prefix` AS 'rfi_fk_recipient_c__name_prefix',
	rfi_fk_recipient_c.`first_name` AS 'rfi_fk_recipient_c__first_name',
	rfi_fk_recipient_c.`additional_name` AS 'rfi_fk_recipient_c__additional_name',
	rfi_fk_recipient_c.`middle_name` AS 'rfi_fk_recipient_c__middle_name',
	rfi_fk_recipient_c.`last_name` AS 'rfi_fk_recipient_c__last_name',
	rfi_fk_recipient_c.`name_suffix` AS 'rfi_fk_recipient_c__name_suffix',
	rfi_fk_recipient_c.`title` AS 'rfi_fk_recipient_c__title',
	rfi_fk_recipient_c.`vendor_flag` AS 'rfi_fk_recipient_c__vendor_flag',
	rfi_fk_recipient_c.`is_archive` AS 'rfi_fk_recipient_c__is_archive',

	rfi_fk_recipient_cco.`id` AS 'rfi_fk_recipient_cco__contact_company_office_id',
	rfi_fk_recipient_cco.`contact_company_id` AS 'rfi_fk_recipient_cco__contact_company_id',
	rfi_fk_recipient_cco.`office_nickname` AS 'rfi_fk_recipient_cco__office_nickname',
	rfi_fk_recipient_cco.`address_line_1` AS 'rfi_fk_recipient_cco__address_line_1',
	rfi_fk_recipient_cco.`address_line_2` AS 'rfi_fk_recipient_cco__address_line_2',
	rfi_fk_recipient_cco.`address_line_3` AS 'rfi_fk_recipient_cco__address_line_3',
	rfi_fk_recipient_cco.`address_line_4` AS 'rfi_fk_recipient_cco__address_line_4',
	rfi_fk_recipient_cco.`address_city` AS 'rfi_fk_recipient_cco__address_city',
	rfi_fk_recipient_cco.`address_county` AS 'rfi_fk_recipient_cco__address_county',
	rfi_fk_recipient_cco.`address_state_or_region` AS 'rfi_fk_recipient_cco__address_state_or_region',
	rfi_fk_recipient_cco.`address_postal_code` AS 'rfi_fk_recipient_cco__address_postal_code',
	rfi_fk_recipient_cco.`address_postal_code_extension` AS 'rfi_fk_recipient_cco__address_postal_code_extension',
	rfi_fk_recipient_cco.`address_country` AS 'rfi_fk_recipient_cco__address_country',
	rfi_fk_recipient_cco.`head_quarters_flag` AS 'rfi_fk_recipient_cco__head_quarters_flag',
	rfi_fk_recipient_cco.`address_validated_by_user_flag` AS 'rfi_fk_recipient_cco__address_validated_by_user_flag',
	rfi_fk_recipient_cco.`address_validated_by_web_service_flag` AS 'rfi_fk_recipient_cco__address_validated_by_web_service_flag',
	rfi_fk_recipient_cco.`address_validation_by_web_service_error_flag` AS 'rfi_fk_recipient_cco__address_validation_by_web_service_error_flag',

	rfi_fk_recipient_phone_ccopn.`id` AS 'rfi_fk_recipient_phone_ccopn__contact_company_office_phone_number_id',
	rfi_fk_recipient_phone_ccopn.`contact_company_office_id` AS 'rfi_fk_recipient_phone_ccopn__contact_company_office_id',
	rfi_fk_recipient_phone_ccopn.`phone_number_type_id` AS 'rfi_fk_recipient_phone_ccopn__phone_number_type_id',
	rfi_fk_recipient_phone_ccopn.`country_code` AS 'rfi_fk_recipient_phone_ccopn__country_code',
	rfi_fk_recipient_phone_ccopn.`area_code` AS 'rfi_fk_recipient_phone_ccopn__area_code',
	rfi_fk_recipient_phone_ccopn.`prefix` AS 'rfi_fk_recipient_phone_ccopn__prefix',
	rfi_fk_recipient_phone_ccopn.`number` AS 'rfi_fk_recipient_phone_ccopn__number',
	rfi_fk_recipient_phone_ccopn.`extension` AS 'rfi_fk_recipient_phone_ccopn__extension',
	rfi_fk_recipient_phone_ccopn.`itu` AS 'rfi_fk_recipient_phone_ccopn__itu',

	rfi_fk_recipient_fax_ccopn.`id` AS 'rfi_fk_recipient_fax_ccopn__contact_company_office_phone_number_id',
	rfi_fk_recipient_fax_ccopn.`contact_company_office_id` AS 'rfi_fk_recipient_fax_ccopn__contact_company_office_id',
	rfi_fk_recipient_fax_ccopn.`phone_number_type_id` AS 'rfi_fk_recipient_fax_ccopn__phone_number_type_id',
	rfi_fk_recipient_fax_ccopn.`country_code` AS 'rfi_fk_recipient_fax_ccopn__country_code',
	rfi_fk_recipient_fax_ccopn.`area_code` AS 'rfi_fk_recipient_fax_ccopn__area_code',
	rfi_fk_recipient_fax_ccopn.`prefix` AS 'rfi_fk_recipient_fax_ccopn__prefix',
	rfi_fk_recipient_fax_ccopn.`number` AS 'rfi_fk_recipient_fax_ccopn__number',
	rfi_fk_recipient_fax_ccopn.`extension` AS 'rfi_fk_recipient_fax_ccopn__extension',
	rfi_fk_recipient_fax_ccopn.`itu` AS 'rfi_fk_recipient_fax_ccopn__itu',

	rfi_fk_recipient_c_mobile_cpn.`id` AS 'rfi_fk_recipient_c_mobile_cpn__contact_phone_number_id',
	rfi_fk_recipient_c_mobile_cpn.`contact_id` AS 'rfi_fk_recipient_c_mobile_cpn__contact_id',
	rfi_fk_recipient_c_mobile_cpn.`phone_number_type_id` AS 'rfi_fk_recipient_c_mobile_cpn__phone_number_type_id',
	rfi_fk_recipient_c_mobile_cpn.`country_code` AS 'rfi_fk_recipient_c_mobile_cpn__country_code',
	rfi_fk_recipient_c_mobile_cpn.`area_code` AS 'rfi_fk_recipient_c_mobile_cpn__area_code',
	rfi_fk_recipient_c_mobile_cpn.`prefix` AS 'rfi_fk_recipient_c_mobile_cpn__prefix',
	rfi_fk_recipient_c_mobile_cpn.`number` AS 'rfi_fk_recipient_c_mobile_cpn__number',
	rfi_fk_recipient_c_mobile_cpn.`extension` AS 'rfi_fk_recipient_c_mobile_cpn__extension',
	rfi_fk_recipient_c_mobile_cpn.`itu` AS 'rfi_fk_recipient_c_mobile_cpn__itu',

	rfi_fk_initiator_c.`id` AS 'rfi_fk_initiator_c__contact_id',
	rfi_fk_initiator_c.`user_company_id` AS 'rfi_fk_initiator_c__user_company_id',
	rfi_fk_initiator_c.`user_id` AS 'rfi_fk_initiator_c__user_id',
	rfi_fk_initiator_c.`contact_company_id` AS 'rfi_fk_initiator_c__contact_company_id',
	rfi_fk_initiator_c.`email` AS 'rfi_fk_initiator_c__email',
	rfi_fk_initiator_c.`name_prefix` AS 'rfi_fk_initiator_c__name_prefix',
	rfi_fk_initiator_c.`first_name` AS 'rfi_fk_initiator_c__first_name',
	rfi_fk_initiator_c.`additional_name` AS 'rfi_fk_initiator_c__additional_name',
	rfi_fk_initiator_c.`middle_name` AS 'rfi_fk_initiator_c__middle_name',
	rfi_fk_initiator_c.`last_name` AS 'rfi_fk_initiator_c__last_name',
	rfi_fk_initiator_c.`name_suffix` AS 'rfi_fk_initiator_c__name_suffix',
	rfi_fk_initiator_c.`title` AS 'rfi_fk_initiator_c__title',
	rfi_fk_initiator_c.`vendor_flag` AS 'rfi_fk_initiator_c__vendor_flag',
	rfi_fk_initiator_c.`is_archive` AS 'rfi_fk_initiator_c__is_archive',

	rfi_fk_initiator_cco.`id` AS 'rfi_fk_initiator_cco__contact_company_office_id',
	rfi_fk_initiator_cco.`contact_company_id` AS 'rfi_fk_initiator_cco__contact_company_id',
	rfi_fk_initiator_cco.`office_nickname` AS 'rfi_fk_initiator_cco__office_nickname',
	rfi_fk_initiator_cco.`address_line_1` AS 'rfi_fk_initiator_cco__address_line_1',
	rfi_fk_initiator_cco.`address_line_2` AS 'rfi_fk_initiator_cco__address_line_2',
	rfi_fk_initiator_cco.`address_line_3` AS 'rfi_fk_initiator_cco__address_line_3',
	rfi_fk_initiator_cco.`address_line_4` AS 'rfi_fk_initiator_cco__address_line_4',
	rfi_fk_initiator_cco.`address_city` AS 'rfi_fk_initiator_cco__address_city',
	rfi_fk_initiator_cco.`address_county` AS 'rfi_fk_initiator_cco__address_county',
	rfi_fk_initiator_cco.`address_state_or_region` AS 'rfi_fk_initiator_cco__address_state_or_region',
	rfi_fk_initiator_cco.`address_postal_code` AS 'rfi_fk_initiator_cco__address_postal_code',
	rfi_fk_initiator_cco.`address_postal_code_extension` AS 'rfi_fk_initiator_cco__address_postal_code_extension',
	rfi_fk_initiator_cco.`address_country` AS 'rfi_fk_initiator_cco__address_country',
	rfi_fk_initiator_cco.`head_quarters_flag` AS 'rfi_fk_initiator_cco__head_quarters_flag',
	rfi_fk_initiator_cco.`address_validated_by_user_flag` AS 'rfi_fk_initiator_cco__address_validated_by_user_flag',
	rfi_fk_initiator_cco.`address_validated_by_web_service_flag` AS 'rfi_fk_initiator_cco__address_validated_by_web_service_flag',
	rfi_fk_initiator_cco.`address_validation_by_web_service_error_flag` AS 'rfi_fk_initiator_cco__address_validation_by_web_service_error_flag',

	rfi_fk_initiator_phone_ccopn.`id` AS 'rfi_fk_initiator_phone_ccopn__contact_company_office_phone_number_id',
	rfi_fk_initiator_phone_ccopn.`contact_company_office_id` AS 'rfi_fk_initiator_phone_ccopn__contact_company_office_id',
	rfi_fk_initiator_phone_ccopn.`phone_number_type_id` AS 'rfi_fk_initiator_phone_ccopn__phone_number_type_id',
	rfi_fk_initiator_phone_ccopn.`country_code` AS 'rfi_fk_initiator_phone_ccopn__country_code',
	rfi_fk_initiator_phone_ccopn.`area_code` AS 'rfi_fk_initiator_phone_ccopn__area_code',
	rfi_fk_initiator_phone_ccopn.`prefix` AS 'rfi_fk_initiator_phone_ccopn__prefix',
	rfi_fk_initiator_phone_ccopn.`number` AS 'rfi_fk_initiator_phone_ccopn__number',
	rfi_fk_initiator_phone_ccopn.`extension` AS 'rfi_fk_initiator_phone_ccopn__extension',
	rfi_fk_initiator_phone_ccopn.`itu` AS 'rfi_fk_initiator_phone_ccopn__itu',

	rfi_fk_initiator_fax_ccopn.`id` AS 'rfi_fk_initiator_fax_ccopn__contact_company_office_phone_number_id',
	rfi_fk_initiator_fax_ccopn.`contact_company_office_id` AS 'rfi_fk_initiator_fax_ccopn__contact_company_office_id',
	rfi_fk_initiator_fax_ccopn.`phone_number_type_id` AS 'rfi_fk_initiator_fax_ccopn__phone_number_type_id',
	rfi_fk_initiator_fax_ccopn.`country_code` AS 'rfi_fk_initiator_fax_ccopn__country_code',
	rfi_fk_initiator_fax_ccopn.`area_code` AS 'rfi_fk_initiator_fax_ccopn__area_code',
	rfi_fk_initiator_fax_ccopn.`prefix` AS 'rfi_fk_initiator_fax_ccopn__prefix',
	rfi_fk_initiator_fax_ccopn.`number` AS 'rfi_fk_initiator_fax_ccopn__number',
	rfi_fk_initiator_fax_ccopn.`extension` AS 'rfi_fk_initiator_fax_ccopn__extension',
	rfi_fk_initiator_fax_ccopn.`itu` AS 'rfi_fk_initiator_fax_ccopn__itu',

	rfi_fk_initiator_c_mobile_cpn.`id` AS 'rfi_fk_initiator_c_mobile_cpn__contact_phone_number_id',
	rfi_fk_initiator_c_mobile_cpn.`contact_id` AS 'rfi_fk_initiator_c_mobile_cpn__contact_id',
	rfi_fk_initiator_c_mobile_cpn.`phone_number_type_id` AS 'rfi_fk_initiator_c_mobile_cpn__phone_number_type_id',
	rfi_fk_initiator_c_mobile_cpn.`country_code` AS 'rfi_fk_initiator_c_mobile_cpn__country_code',
	rfi_fk_initiator_c_mobile_cpn.`area_code` AS 'rfi_fk_initiator_c_mobile_cpn__area_code',
	rfi_fk_initiator_c_mobile_cpn.`prefix` AS 'rfi_fk_initiator_c_mobile_cpn__prefix',
	rfi_fk_initiator_c_mobile_cpn.`number` AS 'rfi_fk_initiator_c_mobile_cpn__number',
	rfi_fk_initiator_c_mobile_cpn.`extension` AS 'rfi_fk_initiator_c_mobile_cpn__extension',
	rfi_fk_initiator_c_mobile_cpn.`itu` AS 'rfi_fk_initiator_c_mobile_cpn__itu',

	rfi.*

FROM `requests_for_information` rfi
	INNER JOIN `projects` rfi_fk_p ON rfi.`project_id` = rfi_fk_p.`id`
	INNER JOIN `request_for_information_types` rfi_fk_rfit ON rfi.`request_for_information_type_id` = rfi_fk_rfit.`id`
	INNER JOIN `request_for_information_statuses` rfi_fk_rfis ON rfi.`request_for_information_status_id` = rfi_fk_rfis.`id`
	INNER JOIN `request_for_information_priorities` rfi_fk_rfip ON rfi.`request_for_information_priority_id` = rfi_fk_rfip.`id`
	LEFT OUTER JOIN `file_manager_files` rfi_fk_fmfiles ON rfi.`rfi_file_manager_file_id` = rfi_fk_fmfiles.`id`
	LEFT OUTER JOIN `cost_codes` rfi_fk_codes ON rfi.`rfi_cost_code_id` = rfi_fk_codes.`id`
	INNER JOIN `contacts` rfi_fk_creator_c ON rfi.`rfi_creator_contact_id` = rfi_fk_creator_c.`id`
	LEFT OUTER JOIN `contact_company_offices` rfi_fk_creator_cco ON rfi.`rfi_creator_contact_company_office_id` = rfi_fk_creator_cco.`id`
	LEFT OUTER JOIN `contact_company_office_phone_numbers` rfi_fk_creator_phone_ccopn ON rfi.`rfi_creator_phone_contact_company_office_phone_number_id` = rfi_fk_creator_phone_ccopn.`id`
	LEFT OUTER JOIN `contact_company_office_phone_numbers` rfi_fk_creator_fax_ccopn ON rfi.`rfi_creator_fax_contact_company_office_phone_number_id` = rfi_fk_creator_fax_ccopn.`id`
	LEFT OUTER JOIN `contact_phone_numbers` rfi_fk_creator_c_mobile_cpn ON rfi.`rfi_creator_contact_mobile_phone_number_id` = rfi_fk_creator_c_mobile_cpn.`id`
	LEFT OUTER JOIN `contacts` rfi_fk_recipient_c ON rfi.`rfi_recipient_contact_id` = rfi_fk_recipient_c.`id`
	LEFT OUTER JOIN `contact_company_offices` rfi_fk_recipient_cco ON rfi.`rfi_recipient_contact_company_office_id` = rfi_fk_recipient_cco.`id`
	LEFT OUTER JOIN `contact_company_office_phone_numbers` rfi_fk_recipient_phone_ccopn ON rfi.`rfi_recipient_phone_contact_company_office_phone_number_id` = rfi_fk_recipient_phone_ccopn.`id`
	LEFT OUTER JOIN `contact_company_office_phone_numbers` rfi_fk_recipient_fax_ccopn ON rfi.`rfi_recipient_fax_contact_company_office_phone_number_id` = rfi_fk_recipient_fax_ccopn.`id`
	LEFT OUTER JOIN `contact_phone_numbers` rfi_fk_recipient_c_mobile_cpn ON rfi.`rfi_recipient_contact_mobile_phone_number_id` = rfi_fk_recipient_c_mobile_cpn.`id`
	LEFT OUTER JOIN `contacts` rfi_fk_initiator_c ON rfi.`rfi_initiator_contact_id` = rfi_fk_initiator_c.`id`
	LEFT OUTER JOIN `contact_company_offices` rfi_fk_initiator_cco ON rfi.`rfi_initiator_contact_company_office_id` = rfi_fk_initiator_cco.`id`
	LEFT OUTER JOIN `contact_company_office_phone_numbers` rfi_fk_initiator_phone_ccopn ON rfi.`rfi_initiator_phone_contact_company_office_phone_number_id` = rfi_fk_initiator_phone_ccopn.`id`
	LEFT OUTER JOIN `contact_company_office_phone_numbers` rfi_fk_initiator_fax_ccopn ON rfi.`rfi_initiator_fax_contact_company_office_phone_number_id` = rfi_fk_initiator_fax_ccopn.`id`
	LEFT OUTER JOIN `contact_phone_numbers` rfi_fk_initiator_c_mobile_cpn ON rfi.`rfi_initiator_contact_mobile_phone_number_id` = rfi_fk_initiator_c_mobile_cpn.`id`
WHERE rfi.`project_id` = ? and rfi.id IN($WhereIn) {$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array($project_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrRequestsForInformationByProjectId = array();
		while ($row = $db->fetch()) {
			$request_for_information_id = $row['id'];
			$requestForInformation = self::instantiateOrm($database, 'RequestForInformation', $row, null, $request_for_information_id);
			/* @var $requestForInformation RequestForInformation */
			$requestForInformation->convertPropertiesToData();

			if (isset($row['project_id'])) {
				$project_id = $row['project_id'];
				$row['rfi_fk_p__id'] = $project_id;
				$project = self::instantiateOrm($database, 'Project', $row, null, $project_id, 'rfi_fk_p__');
				/* @var $project Project */
				$project->convertPropertiesToData();
			} else {
				$project = false;
			}
			$requestForInformation->setProject($project);

			if (isset($row['request_for_information_type_id'])) {
				$request_for_information_type_id = $row['request_for_information_type_id'];
				$row['rfi_fk_rfit__id'] = $request_for_information_type_id;
				$requestForInformationType = self::instantiateOrm($database, 'RequestForInformationType', $row, null, $request_for_information_type_id, 'rfi_fk_rfit__');
				/* @var $requestForInformationType RequestForInformationType */
				$requestForInformationType->convertPropertiesToData();
			} else {
				$requestForInformationType = false;
			}
			$requestForInformation->setRequestForInformationType($requestForInformationType);

			if (isset($row['request_for_information_status_id'])) {
				$request_for_information_status_id = $row['request_for_information_status_id'];
				$row['rfi_fk_rfis__id'] = $request_for_information_status_id;
				$requestForInformationStatus = self::instantiateOrm($database, 'RequestForInformationStatus', $row, null, $request_for_information_status_id, 'rfi_fk_rfis__');
				/* @var $requestForInformationStatus RequestForInformationStatus */
				$requestForInformationStatus->convertPropertiesToData();
			} else {
				$requestForInformationStatus = false;
			}
			$requestForInformation->setRequestForInformationStatus($requestForInformationStatus);

			if (isset($row['request_for_information_priority_id'])) {
				$request_for_information_priority_id = $row['request_for_information_priority_id'];
				$row['rfi_fk_rfip__id'] = $request_for_information_priority_id;
				$requestForInformationPriority = self::instantiateOrm($database, 'RequestForInformationPriority', $row, null, $request_for_information_priority_id, 'rfi_fk_rfip__');
				/* @var $requestForInformationPriority RequestForInformationPriority */
				$requestForInformationPriority->convertPropertiesToData();
			} else {
				$requestForInformationPriority = false;
			}
			$requestForInformation->setRequestForInformationPriority($requestForInformationPriority);

			if (isset($row['rfi_file_manager_file_id'])) {
				$rfi_file_manager_file_id = $row['rfi_file_manager_file_id'];
				$row['rfi_fk_fmfiles__id'] = $rfi_file_manager_file_id;
				$rfiFileManagerFile = self::instantiateOrm($database, 'FileManagerFile', $row, null, $rfi_file_manager_file_id, 'rfi_fk_fmfiles__');
				/* @var $rfiFileManagerFile FileManagerFile */
				$rfiFileManagerFile->convertPropertiesToData();
			} else {
				$rfiFileManagerFile = false;
			}
			$requestForInformation->setRfiFileManagerFile($rfiFileManagerFile);

			if (isset($row['rfi_cost_code_id'])) {
				$rfi_cost_code_id = $row['rfi_cost_code_id'];
				$row['rfi_fk_codes__id'] = $rfi_cost_code_id;
				$rfiCostCode = self::instantiateOrm($database, 'CostCode', $row, null, $rfi_cost_code_id, 'rfi_fk_codes__');
				/* @var $rfiCostCode CostCode */
				$rfiCostCode->convertPropertiesToData();
			} else {
				$rfiCostCode = false;
			}
			$requestForInformation->setRfiCostCode($rfiCostCode);

			if (isset($row['rfi_creator_contact_id'])) {
				$rfi_creator_contact_id = $row['rfi_creator_contact_id'];
				$row['rfi_fk_creator_c__id'] = $rfi_creator_contact_id;
				$rfiCreatorContact = self::instantiateOrm($database, 'Contact', $row, null, $rfi_creator_contact_id, 'rfi_fk_creator_c__');
				/* @var $rfiCreatorContact Contact */
				$rfiCreatorContact->convertPropertiesToData();
			} else {
				$rfiCreatorContact = false;
			}
			$requestForInformation->setRfiCreatorContact($rfiCreatorContact);

			if (isset($row['rfi_creator_contact_company_office_id'])) {
				$rfi_creator_contact_company_office_id = $row['rfi_creator_contact_company_office_id'];
				$row['rfi_fk_creator_cco__id'] = $rfi_creator_contact_company_office_id;
				$rfiCreatorContactCompanyOffice = self::instantiateOrm($database, 'ContactCompanyOffice', $row, null, $rfi_creator_contact_company_office_id, 'rfi_fk_creator_cco__');
				/* @var $rfiCreatorContactCompanyOffice ContactCompanyOffice */
				$rfiCreatorContactCompanyOffice->convertPropertiesToData();
			} else {
				$rfiCreatorContactCompanyOffice = false;
			}
			$requestForInformation->setRfiCreatorContactCompanyOffice($rfiCreatorContactCompanyOffice);

			if (isset($row['rfi_creator_phone_contact_company_office_phone_number_id'])) {
				$rfi_creator_phone_contact_company_office_phone_number_id = $row['rfi_creator_phone_contact_company_office_phone_number_id'];
				$row['rfi_fk_creator_phone_ccopn__id'] = $rfi_creator_phone_contact_company_office_phone_number_id;
				$rfiCreatorPhoneContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $rfi_creator_phone_contact_company_office_phone_number_id, 'rfi_fk_creator_phone_ccopn__');
				/* @var $rfiCreatorPhoneContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$rfiCreatorPhoneContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$rfiCreatorPhoneContactCompanyOfficePhoneNumber = false;
			}
			$requestForInformation->setRfiCreatorPhoneContactCompanyOfficePhoneNumber($rfiCreatorPhoneContactCompanyOfficePhoneNumber);

			if (isset($row['rfi_creator_fax_contact_company_office_phone_number_id'])) {
				$rfi_creator_fax_contact_company_office_phone_number_id = $row['rfi_creator_fax_contact_company_office_phone_number_id'];
				$row['rfi_fk_creator_fax_ccopn__id'] = $rfi_creator_fax_contact_company_office_phone_number_id;
				$rfiCreatorFaxContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $rfi_creator_fax_contact_company_office_phone_number_id, 'rfi_fk_creator_fax_ccopn__');
				/* @var $rfiCreatorFaxContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$rfiCreatorFaxContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$rfiCreatorFaxContactCompanyOfficePhoneNumber = false;
			}
			$requestForInformation->setRfiCreatorFaxContactCompanyOfficePhoneNumber($rfiCreatorFaxContactCompanyOfficePhoneNumber);

			if (isset($row['rfi_creator_contact_mobile_phone_number_id'])) {
				$rfi_creator_contact_mobile_phone_number_id = $row['rfi_creator_contact_mobile_phone_number_id'];
				$row['rfi_fk_creator_c_mobile_cpn__id'] = $rfi_creator_contact_mobile_phone_number_id;
				$rfiCreatorContactMobilePhoneNumber = self::instantiateOrm($database, 'ContactPhoneNumber', $row, null, $rfi_creator_contact_mobile_phone_number_id, 'rfi_fk_creator_c_mobile_cpn__');
				/* @var $rfiCreatorContactMobilePhoneNumber ContactPhoneNumber */
				$rfiCreatorContactMobilePhoneNumber->convertPropertiesToData();
			} else {
				$rfiCreatorContactMobilePhoneNumber = false;
			}
			$requestForInformation->setRfiCreatorContactMobilePhoneNumber($rfiCreatorContactMobilePhoneNumber);

			if (isset($row['rfi_recipient_contact_id'])) {
				$rfi_recipient_contact_id = $row['rfi_recipient_contact_id'];
				$row['rfi_fk_recipient_c__id'] = $rfi_recipient_contact_id;
				$rfiRecipientContact = self::instantiateOrm($database, 'Contact', $row, null, $rfi_recipient_contact_id, 'rfi_fk_recipient_c__');
				/* @var $rfiRecipientContact Contact */
				$rfiRecipientContact->convertPropertiesToData();
			} else {
				$rfiRecipientContact = false;
			}
			$requestForInformation->setRfiRecipientContact($rfiRecipientContact);

			if (isset($row['rfi_recipient_contact_company_office_id'])) {
				$rfi_recipient_contact_company_office_id = $row['rfi_recipient_contact_company_office_id'];
				$row['rfi_fk_recipient_cco__id'] = $rfi_recipient_contact_company_office_id;
				$rfiRecipientContactCompanyOffice = self::instantiateOrm($database, 'ContactCompanyOffice', $row, null, $rfi_recipient_contact_company_office_id, 'rfi_fk_recipient_cco__');
				/* @var $rfiRecipientContactCompanyOffice ContactCompanyOffice */
				$rfiRecipientContactCompanyOffice->convertPropertiesToData();
			} else {
				$rfiRecipientContactCompanyOffice = false;
			}
			$requestForInformation->setRfiRecipientContactCompanyOffice($rfiRecipientContactCompanyOffice);

			if (isset($row['rfi_recipient_phone_contact_company_office_phone_number_id'])) {
				$rfi_recipient_phone_contact_company_office_phone_number_id = $row['rfi_recipient_phone_contact_company_office_phone_number_id'];
				$row['rfi_fk_recipient_phone_ccopn__id'] = $rfi_recipient_phone_contact_company_office_phone_number_id;
				$rfiRecipientPhoneContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $rfi_recipient_phone_contact_company_office_phone_number_id, 'rfi_fk_recipient_phone_ccopn__');
				/* @var $rfiRecipientPhoneContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$rfiRecipientPhoneContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$rfiRecipientPhoneContactCompanyOfficePhoneNumber = false;
			}
			$requestForInformation->setRfiRecipientPhoneContactCompanyOfficePhoneNumber($rfiRecipientPhoneContactCompanyOfficePhoneNumber);

			if (isset($row['rfi_recipient_fax_contact_company_office_phone_number_id'])) {
				$rfi_recipient_fax_contact_company_office_phone_number_id = $row['rfi_recipient_fax_contact_company_office_phone_number_id'];
				$row['rfi_fk_recipient_fax_ccopn__id'] = $rfi_recipient_fax_contact_company_office_phone_number_id;
				$rfiRecipientFaxContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $rfi_recipient_fax_contact_company_office_phone_number_id, 'rfi_fk_recipient_fax_ccopn__');
				/* @var $rfiRecipientFaxContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$rfiRecipientFaxContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$rfiRecipientFaxContactCompanyOfficePhoneNumber = false;
			}
			$requestForInformation->setRfiRecipientFaxContactCompanyOfficePhoneNumber($rfiRecipientFaxContactCompanyOfficePhoneNumber);

			if (isset($row['rfi_recipient_contact_mobile_phone_number_id'])) {
				$rfi_recipient_contact_mobile_phone_number_id = $row['rfi_recipient_contact_mobile_phone_number_id'];
				$row['rfi_fk_recipient_c_mobile_cpn__id'] = $rfi_recipient_contact_mobile_phone_number_id;
				$rfiRecipientContactMobilePhoneNumber = self::instantiateOrm($database, 'ContactPhoneNumber', $row, null, $rfi_recipient_contact_mobile_phone_number_id, 'rfi_fk_recipient_c_mobile_cpn__');
				/* @var $rfiRecipientContactMobilePhoneNumber ContactPhoneNumber */
				$rfiRecipientContactMobilePhoneNumber->convertPropertiesToData();
			} else {
				$rfiRecipientContactMobilePhoneNumber = false;
			}
			$requestForInformation->setRfiRecipientContactMobilePhoneNumber($rfiRecipientContactMobilePhoneNumber);

			if (isset($row['rfi_initiator_contact_id'])) {
				$rfi_initiator_contact_id = $row['rfi_initiator_contact_id'];
				$row['rfi_fk_initiator_c__id'] = $rfi_initiator_contact_id;
				$rfiInitiatorContact = self::instantiateOrm($database, 'Contact', $row, null, $rfi_initiator_contact_id, 'rfi_fk_initiator_c__');
				/* @var $rfiInitiatorContact Contact */
				$rfiInitiatorContact->convertPropertiesToData();
			} else {
				$rfiInitiatorContact = false;
			}
			$requestForInformation->setRfiInitiatorContact($rfiInitiatorContact);

			if (isset($row['rfi_initiator_contact_company_office_id'])) {
				$rfi_initiator_contact_company_office_id = $row['rfi_initiator_contact_company_office_id'];
				$row['rfi_fk_initiator_cco__id'] = $rfi_initiator_contact_company_office_id;
				$rfiInitiatorContactCompanyOffice = self::instantiateOrm($database, 'ContactCompanyOffice', $row, null, $rfi_initiator_contact_company_office_id, 'rfi_fk_initiator_cco__');
				/* @var $rfiInitiatorContactCompanyOffice ContactCompanyOffice */
				$rfiInitiatorContactCompanyOffice->convertPropertiesToData();
			} else {
				$rfiInitiatorContactCompanyOffice = false;
			}
			$requestForInformation->setRfiInitiatorContactCompanyOffice($rfiInitiatorContactCompanyOffice);

			if (isset($row['rfi_initiator_phone_contact_company_office_phone_number_id'])) {
				$rfi_initiator_phone_contact_company_office_phone_number_id = $row['rfi_initiator_phone_contact_company_office_phone_number_id'];
				$row['rfi_fk_initiator_phone_ccopn__id'] = $rfi_initiator_phone_contact_company_office_phone_number_id;
				$rfiInitiatorPhoneContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $rfi_initiator_phone_contact_company_office_phone_number_id, 'rfi_fk_initiator_phone_ccopn__');
				/* @var $rfiInitiatorPhoneContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$rfiInitiatorPhoneContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$rfiInitiatorPhoneContactCompanyOfficePhoneNumber = false;
			}
			$requestForInformation->setRfiInitiatorPhoneContactCompanyOfficePhoneNumber($rfiInitiatorPhoneContactCompanyOfficePhoneNumber);

			if (isset($row['rfi_initiator_fax_contact_company_office_phone_number_id'])) {
				$rfi_initiator_fax_contact_company_office_phone_number_id = $row['rfi_initiator_fax_contact_company_office_phone_number_id'];
				$row['rfi_fk_initiator_fax_ccopn__id'] = $rfi_initiator_fax_contact_company_office_phone_number_id;
				$rfiInitiatorFaxContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $rfi_initiator_fax_contact_company_office_phone_number_id, 'rfi_fk_initiator_fax_ccopn__');
				/* @var $rfiInitiatorFaxContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$rfiInitiatorFaxContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$rfiInitiatorFaxContactCompanyOfficePhoneNumber = false;
			}
			$requestForInformation->setRfiInitiatorFaxContactCompanyOfficePhoneNumber($rfiInitiatorFaxContactCompanyOfficePhoneNumber);

			if (isset($row['rfi_initiator_contact_mobile_phone_number_id'])) {
				$rfi_initiator_contact_mobile_phone_number_id = $row['rfi_initiator_contact_mobile_phone_number_id'];
				$row['rfi_fk_initiator_c_mobile_cpn__id'] = $rfi_initiator_contact_mobile_phone_number_id;
				$rfiInitiatorContactMobilePhoneNumber = self::instantiateOrm($database, 'ContactPhoneNumber', $row, null, $rfi_initiator_contact_mobile_phone_number_id, 'rfi_fk_initiator_c_mobile_cpn__');
				/* @var $rfiInitiatorContactMobilePhoneNumber ContactPhoneNumber */
				$rfiInitiatorContactMobilePhoneNumber->convertPropertiesToData();
			} else {
				$rfiInitiatorContactMobilePhoneNumber = false;
			}
			$requestForInformation->setRfiInitiatorContactMobilePhoneNumber($rfiInitiatorContactMobilePhoneNumber);

			$arrRequestsForInformationByProjectId[$request_for_information_id] = $requestForInformation;
		}

		$db->free_result();

		self::$_arrRequestsForInformationByProjectId = $arrRequestsForInformationByProjectId;

		return $arrRequestsForInformationByProjectId;
	}
//Get the rfi data for Report modul Report By ID
	public static function loadRequestsForInformationByProjectIdReport($database, $project_id, Input $options=null, $new_begindate, $enddate, $typepost)
	{
		$forceLoadFlag = false;
		$whereCause = '';
		$whereFlag = false;
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

			if($options->whereFlag) {
				$whereFlag = $options->whereFlag;
				$whereCause = $options->whereStatusCause;
			}
		}

		if ($forceLoadFlag) {
			self::$_arrRequestsForInformationByProjectId = null;
		}

		$arrRequestsForInformationByProjectId = self::$_arrRequestsForInformationByProjectId;
		if (isset($arrRequestsForInformationByProjectId) && !empty($arrRequestsForInformationByProjectId)) {
			return $arrRequestsForInformationByProjectId;
		}

		$project_id = (int) $project_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `rfi_sequence_number` ASC, `request_for_information_type_id` ASC, `request_for_information_status_id` ASC, `request_for_information_priority_id` ASC, `rfi_file_manager_file_id` ASC, `rfi_cost_code_id` ASC, `rfi_creator_contact_id` ASC, `rfi_creator_contact_company_office_id` ASC, `rfi_creator_phone_contact_company_office_phone_number_id` ASC, `rfi_creator_fax_contact_company_office_phone_number_id` ASC, `rfi_creator_contact_mobile_phone_number_id` ASC, `rfi_recipient_contact_id` ASC, `rfi_recipient_contact_company_office_id` ASC, `rfi_recipient_phone_contact_company_office_phone_number_id` ASC, `rfi_recipient_fax_contact_company_office_phone_number_id` ASC, `rfi_recipient_contact_mobile_phone_number_id` ASC, `rfi_initiator_contact_id` ASC, `rfi_initiator_contact_company_office_id` ASC, `rfi_initiator_phone_contact_company_office_phone_number_id` ASC, `rfi_initiator_fax_contact_company_office_phone_number_id` ASC, `rfi_initiator_contact_mobile_phone_number_id` ASC, `rfi_title` ASC, `rfi_plan_page_reference` ASC, `rfi_statement` ASC, `created` ASC, `rfi_due_date` ASC, `rfi_closed_date` ASC
		$sqlOrderBy = "\nORDER BY `created` DESC, `rfi_sequence_number` DESC, `request_for_information_priority_id` ASC, `request_for_information_type_id` ASC, `request_for_information_status_id` ASC";

		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpRequestForInformation = new RequestForInformation($database);
			$sqlOrderByColumns = $tmpRequestForInformation->constructSqlOrderByColumns($arrOrderByAttributes);
				
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
		/*SQ Fix*/
		/*if($typepost=='RFI Report - QA')
			$queryJoin='LEFT';
		else*/
			$queryJoin='LEFT';
		if($typepost=='RFI Report - QA - Open'){
			$queryStatus='AND request_for_information_status_id = 2';
		}else{
			$queryStatus='';
		}
		$query =
"
SELECT

	rfi_fk_p.`id` AS 'rfi_fk_p__project_id',
	rfi_fk_p.`project_type_id` AS 'rfi_fk_p__project_type_id',
	rfi_fk_p.`user_company_id` AS 'rfi_fk_p__user_company_id',
	rfi_fk_p.`user_custom_project_id` AS 'rfi_fk_p__user_custom_project_id',
	rfi_fk_p.`project_name` AS 'rfi_fk_p__project_name',
	rfi_fk_p.`project_owner_name` AS 'rfi_fk_p__project_owner_name',
	rfi_fk_p.`latitude` AS 'rfi_fk_p__latitude',
	rfi_fk_p.`longitude` AS 'rfi_fk_p__longitude',
	rfi_fk_p.`address_line_1` AS 'rfi_fk_p__address_line_1',
	rfi_fk_p.`address_line_2` AS 'rfi_fk_p__address_line_2',
	rfi_fk_p.`address_line_3` AS 'rfi_fk_p__address_line_3',
	rfi_fk_p.`address_line_4` AS 'rfi_fk_p__address_line_4',
	rfi_fk_p.`address_city` AS 'rfi_fk_p__address_city',
	rfi_fk_p.`address_county` AS 'rfi_fk_p__address_county',
	rfi_fk_p.`address_state_or_region` AS 'rfi_fk_p__address_state_or_region',
	rfi_fk_p.`address_postal_code` AS 'rfi_fk_p__address_postal_code',
	rfi_fk_p.`address_postal_code_extension` AS 'rfi_fk_p__address_postal_code_extension',
	rfi_fk_p.`address_country` AS 'rfi_fk_p__address_country',
	rfi_fk_p.`building_count` AS 'rfi_fk_p__building_count',
	rfi_fk_p.`unit_count` AS 'rfi_fk_p__unit_count',
	rfi_fk_p.`gross_square_footage` AS 'rfi_fk_p__gross_square_footage',
	rfi_fk_p.`net_rentable_square_footage` AS 'rfi_fk_p__net_rentable_square_footage',
	rfi_fk_p.`is_active_flag` AS 'rfi_fk_p__is_active_flag',
	rfi_fk_p.`public_plans_flag` AS 'rfi_fk_p__public_plans_flag',
	rfi_fk_p.`prevailing_wage_flag` AS 'rfi_fk_p__prevailing_wage_flag',
	rfi_fk_p.`city_business_license_required_flag` AS 'rfi_fk_p__city_business_license_required_flag',
	rfi_fk_p.`is_internal_flag` AS 'rfi_fk_p__is_internal_flag',
	rfi_fk_p.`project_contract_date` AS 'rfi_fk_p__project_contract_date',
	rfi_fk_p.`project_start_date` AS 'rfi_fk_p__project_start_date',
	rfi_fk_p.`project_completed_date` AS 'rfi_fk_p__project_completed_date',
	rfi_fk_p.`sort_order` AS 'rfi_fk_p__sort_order',

	rfi_fk_rfit.`id` AS 'rfi_fk_rfit__request_for_information_type_id',
	rfi_fk_rfit.`request_for_information_type` AS 'rfi_fk_rfit__request_for_information_type',
	rfi_fk_rfit.`disabled_flag` AS 'rfi_fk_rfit__disabled_flag',

	rfi_fk_rfis.`id` AS 'rfi_fk_rfis__request_for_information_status_id',
	rfi_fk_rfis.`request_for_information_status` AS 'rfi_fk_rfis__request_for_information_status',
	rfi_fk_rfis.`disabled_flag` AS 'rfi_fk_rfis__disabled_flag',

	rfi_fk_rfip.`id` AS 'rfi_fk_rfip__request_for_information_priority_id',
	rfi_fk_rfip.`request_for_information_priority` AS 'rfi_fk_rfip__request_for_information_priority',
	rfi_fk_rfip.`disabled_flag` AS 'rfi_fk_rfip__disabled_flag',

	rfi_fk_fmfiles.`id` AS 'rfi_fk_fmfiles__file_manager_file_id',
	rfi_fk_fmfiles.`user_company_id` AS 'rfi_fk_fmfiles__user_company_id',
	rfi_fk_fmfiles.`contact_id` AS 'rfi_fk_fmfiles__contact_id',
	rfi_fk_fmfiles.`project_id` AS 'rfi_fk_fmfiles__project_id',
	rfi_fk_fmfiles.`file_manager_folder_id` AS 'rfi_fk_fmfiles__file_manager_folder_id',
	rfi_fk_fmfiles.`file_location_id` AS 'rfi_fk_fmfiles__file_location_id',
	rfi_fk_fmfiles.`virtual_file_name` AS 'rfi_fk_fmfiles__virtual_file_name',
	rfi_fk_fmfiles.`version_number` AS 'rfi_fk_fmfiles__version_number',
	rfi_fk_fmfiles.`virtual_file_name_sha1` AS 'rfi_fk_fmfiles__virtual_file_name_sha1',
	rfi_fk_fmfiles.`virtual_file_mime_type` AS 'rfi_fk_fmfiles__virtual_file_mime_type',
	rfi_fk_fmfiles.`modified` AS 'rfi_fk_fmfiles__modified',
	rfi_fk_fmfiles.`created` AS 'rfi_fk_fmfiles__created',
	rfi_fk_fmfiles.`deleted_flag` AS 'rfi_fk_fmfiles__deleted_flag',
	rfi_fk_fmfiles.`directly_deleted_flag` AS 'rfi_fk_fmfiles__directly_deleted_flag',

	rfi_fk_codes.`id` AS 'rfi_fk_codes__cost_code_id',
	rfi_fk_codes.`cost_code_division_id` AS 'rfi_fk_codes__cost_code_division_id',
	rfi_fk_codes.`cost_code` AS 'rfi_fk_codes__cost_code',
	rfi_fk_codes.`cost_code_description` AS 'rfi_fk_codes__cost_code_description',
	rfi_fk_codes.`cost_code_description_abbreviation` AS 'rfi_fk_codes__cost_code_description_abbreviation',
	rfi_fk_codes.`sort_order` AS 'rfi_fk_codes__sort_order',
	rfi_fk_codes.`disabled_flag` AS 'rfi_fk_codes__disabled_flag',

	rfi_fk_creator_c.`id` AS 'rfi_fk_creator_c__contact_id',
	rfi_fk_creator_c.`user_company_id` AS 'rfi_fk_creator_c__user_company_id',
	rfi_fk_creator_c.`user_id` AS 'rfi_fk_creator_c__user_id',
	rfi_fk_creator_c.`contact_company_id` AS 'rfi_fk_creator_c__contact_company_id',
	rfi_fk_creator_c.`email` AS 'rfi_fk_creator_c__email',
	rfi_fk_creator_c.`name_prefix` AS 'rfi_fk_creator_c__name_prefix',
	rfi_fk_creator_c.`first_name` AS 'rfi_fk_creator_c__first_name',
	rfi_fk_creator_c.`additional_name` AS 'rfi_fk_creator_c__additional_name',
	rfi_fk_creator_c.`middle_name` AS 'rfi_fk_creator_c__middle_name',
	rfi_fk_creator_c.`last_name` AS 'rfi_fk_creator_c__last_name',
	rfi_fk_creator_c.`name_suffix` AS 'rfi_fk_creator_c__name_suffix',
	rfi_fk_creator_c.`title` AS 'rfi_fk_creator_c__title',
	rfi_fk_creator_c.`vendor_flag` AS 'rfi_fk_creator_c__vendor_flag',

	rfi_fk_creator_cco.`id` AS 'rfi_fk_creator_cco__contact_company_office_id',
	rfi_fk_creator_cco.`contact_company_id` AS 'rfi_fk_creator_cco__contact_company_id',
	rfi_fk_creator_cco.`office_nickname` AS 'rfi_fk_creator_cco__office_nickname',
	rfi_fk_creator_cco.`address_line_1` AS 'rfi_fk_creator_cco__address_line_1',
	rfi_fk_creator_cco.`address_line_2` AS 'rfi_fk_creator_cco__address_line_2',
	rfi_fk_creator_cco.`address_line_3` AS 'rfi_fk_creator_cco__address_line_3',
	rfi_fk_creator_cco.`address_line_4` AS 'rfi_fk_creator_cco__address_line_4',
	rfi_fk_creator_cco.`address_city` AS 'rfi_fk_creator_cco__address_city',
	rfi_fk_creator_cco.`address_county` AS 'rfi_fk_creator_cco__address_county',
	rfi_fk_creator_cco.`address_state_or_region` AS 'rfi_fk_creator_cco__address_state_or_region',
	rfi_fk_creator_cco.`address_postal_code` AS 'rfi_fk_creator_cco__address_postal_code',
	rfi_fk_creator_cco.`address_postal_code_extension` AS 'rfi_fk_creator_cco__address_postal_code_extension',
	rfi_fk_creator_cco.`address_country` AS 'rfi_fk_creator_cco__address_country',
	rfi_fk_creator_cco.`head_quarters_flag` AS 'rfi_fk_creator_cco__head_quarters_flag',
	rfi_fk_creator_cco.`address_validated_by_user_flag` AS 'rfi_fk_creator_cco__address_validated_by_user_flag',
	rfi_fk_creator_cco.`address_validated_by_web_service_flag` AS 'rfi_fk_creator_cco__address_validated_by_web_service_flag',
	rfi_fk_creator_cco.`address_validation_by_web_service_error_flag` AS 'rfi_fk_creator_cco__address_validation_by_web_service_error_flag',

	rfi_fk_creator_phone_ccopn.`id` AS 'rfi_fk_creator_phone_ccopn__contact_company_office_phone_number_id',
	rfi_fk_creator_phone_ccopn.`contact_company_office_id` AS 'rfi_fk_creator_phone_ccopn__contact_company_office_id',
	rfi_fk_creator_phone_ccopn.`phone_number_type_id` AS 'rfi_fk_creator_phone_ccopn__phone_number_type_id',
	rfi_fk_creator_phone_ccopn.`country_code` AS 'rfi_fk_creator_phone_ccopn__country_code',
	rfi_fk_creator_phone_ccopn.`area_code` AS 'rfi_fk_creator_phone_ccopn__area_code',
	rfi_fk_creator_phone_ccopn.`prefix` AS 'rfi_fk_creator_phone_ccopn__prefix',
	rfi_fk_creator_phone_ccopn.`number` AS 'rfi_fk_creator_phone_ccopn__number',
	rfi_fk_creator_phone_ccopn.`extension` AS 'rfi_fk_creator_phone_ccopn__extension',
	rfi_fk_creator_phone_ccopn.`itu` AS 'rfi_fk_creator_phone_ccopn__itu',

	rfi_fk_creator_fax_ccopn.`id` AS 'rfi_fk_creator_fax_ccopn__contact_company_office_phone_number_id',
	rfi_fk_creator_fax_ccopn.`contact_company_office_id` AS 'rfi_fk_creator_fax_ccopn__contact_company_office_id',
	rfi_fk_creator_fax_ccopn.`phone_number_type_id` AS 'rfi_fk_creator_fax_ccopn__phone_number_type_id',
	rfi_fk_creator_fax_ccopn.`country_code` AS 'rfi_fk_creator_fax_ccopn__country_code',
	rfi_fk_creator_fax_ccopn.`area_code` AS 'rfi_fk_creator_fax_ccopn__area_code',
	rfi_fk_creator_fax_ccopn.`prefix` AS 'rfi_fk_creator_fax_ccopn__prefix',
	rfi_fk_creator_fax_ccopn.`number` AS 'rfi_fk_creator_fax_ccopn__number',
	rfi_fk_creator_fax_ccopn.`extension` AS 'rfi_fk_creator_fax_ccopn__extension',
	rfi_fk_creator_fax_ccopn.`itu` AS 'rfi_fk_creator_fax_ccopn__itu',

	rfi_fk_creator_c_mobile_cpn.`id` AS 'rfi_fk_creator_c_mobile_cpn__contact_phone_number_id',
	rfi_fk_creator_c_mobile_cpn.`contact_id` AS 'rfi_fk_creator_c_mobile_cpn__contact_id',
	rfi_fk_creator_c_mobile_cpn.`phone_number_type_id` AS 'rfi_fk_creator_c_mobile_cpn__phone_number_type_id',
	rfi_fk_creator_c_mobile_cpn.`country_code` AS 'rfi_fk_creator_c_mobile_cpn__country_code',
	rfi_fk_creator_c_mobile_cpn.`area_code` AS 'rfi_fk_creator_c_mobile_cpn__area_code',
	rfi_fk_creator_c_mobile_cpn.`prefix` AS 'rfi_fk_creator_c_mobile_cpn__prefix',
	rfi_fk_creator_c_mobile_cpn.`number` AS 'rfi_fk_creator_c_mobile_cpn__number',
	rfi_fk_creator_c_mobile_cpn.`extension` AS 'rfi_fk_creator_c_mobile_cpn__extension',
	rfi_fk_creator_c_mobile_cpn.`itu` AS 'rfi_fk_creator_c_mobile_cpn__itu',

	rfi_fk_recipient_c.`id` AS 'rfi_fk_recipient_c__contact_id',
	rfi_fk_recipient_c.`user_company_id` AS 'rfi_fk_recipient_c__user_company_id',
	rfi_fk_recipient_c.`user_id` AS 'rfi_fk_recipient_c__user_id',
	rfi_fk_recipient_c.`contact_company_id` AS 'rfi_fk_recipient_c__contact_company_id',
	rfi_fk_recipient_c.`email` AS 'rfi_fk_recipient_c__email',
	rfi_fk_recipient_c.`name_prefix` AS 'rfi_fk_recipient_c__name_prefix',
	rfi_fk_recipient_c.`first_name` AS 'rfi_fk_recipient_c__first_name',
	rfi_fk_recipient_c.`additional_name` AS 'rfi_fk_recipient_c__additional_name',
	rfi_fk_recipient_c.`middle_name` AS 'rfi_fk_recipient_c__middle_name',
	rfi_fk_recipient_c.`last_name` AS 'rfi_fk_recipient_c__last_name',
	rfi_fk_recipient_c.`name_suffix` AS 'rfi_fk_recipient_c__name_suffix',
	rfi_fk_recipient_c.`title` AS 'rfi_fk_recipient_c__title',
	rfi_fk_recipient_c.`vendor_flag` AS 'rfi_fk_recipient_c__vendor_flag',

	rfi_fk_recipient_cco.`id` AS 'rfi_fk_recipient_cco__contact_company_office_id',
	rfi_fk_recipient_cco.`contact_company_id` AS 'rfi_fk_recipient_cco__contact_company_id',
	rfi_fk_recipient_cco.`office_nickname` AS 'rfi_fk_recipient_cco__office_nickname',
	rfi_fk_recipient_cco.`address_line_1` AS 'rfi_fk_recipient_cco__address_line_1',
	rfi_fk_recipient_cco.`address_line_2` AS 'rfi_fk_recipient_cco__address_line_2',
	rfi_fk_recipient_cco.`address_line_3` AS 'rfi_fk_recipient_cco__address_line_3',
	rfi_fk_recipient_cco.`address_line_4` AS 'rfi_fk_recipient_cco__address_line_4',
	rfi_fk_recipient_cco.`address_city` AS 'rfi_fk_recipient_cco__address_city',
	rfi_fk_recipient_cco.`address_county` AS 'rfi_fk_recipient_cco__address_county',
	rfi_fk_recipient_cco.`address_state_or_region` AS 'rfi_fk_recipient_cco__address_state_or_region',
	rfi_fk_recipient_cco.`address_postal_code` AS 'rfi_fk_recipient_cco__address_postal_code',
	rfi_fk_recipient_cco.`address_postal_code_extension` AS 'rfi_fk_recipient_cco__address_postal_code_extension',
	rfi_fk_recipient_cco.`address_country` AS 'rfi_fk_recipient_cco__address_country',
	rfi_fk_recipient_cco.`head_quarters_flag` AS 'rfi_fk_recipient_cco__head_quarters_flag',
	rfi_fk_recipient_cco.`address_validated_by_user_flag` AS 'rfi_fk_recipient_cco__address_validated_by_user_flag',
	rfi_fk_recipient_cco.`address_validated_by_web_service_flag` AS 'rfi_fk_recipient_cco__address_validated_by_web_service_flag',
	rfi_fk_recipient_cco.`address_validation_by_web_service_error_flag` AS 'rfi_fk_recipient_cco__address_validation_by_web_service_error_flag',

	rfi_fk_recipient_phone_ccopn.`id` AS 'rfi_fk_recipient_phone_ccopn__contact_company_office_phone_number_id',
	rfi_fk_recipient_phone_ccopn.`contact_company_office_id` AS 'rfi_fk_recipient_phone_ccopn__contact_company_office_id',
	rfi_fk_recipient_phone_ccopn.`phone_number_type_id` AS 'rfi_fk_recipient_phone_ccopn__phone_number_type_id',
	rfi_fk_recipient_phone_ccopn.`country_code` AS 'rfi_fk_recipient_phone_ccopn__country_code',
	rfi_fk_recipient_phone_ccopn.`area_code` AS 'rfi_fk_recipient_phone_ccopn__area_code',
	rfi_fk_recipient_phone_ccopn.`prefix` AS 'rfi_fk_recipient_phone_ccopn__prefix',
	rfi_fk_recipient_phone_ccopn.`number` AS 'rfi_fk_recipient_phone_ccopn__number',
	rfi_fk_recipient_phone_ccopn.`extension` AS 'rfi_fk_recipient_phone_ccopn__extension',
	rfi_fk_recipient_phone_ccopn.`itu` AS 'rfi_fk_recipient_phone_ccopn__itu',

	rfi_fk_recipient_fax_ccopn.`id` AS 'rfi_fk_recipient_fax_ccopn__contact_company_office_phone_number_id',
	rfi_fk_recipient_fax_ccopn.`contact_company_office_id` AS 'rfi_fk_recipient_fax_ccopn__contact_company_office_id',
	rfi_fk_recipient_fax_ccopn.`phone_number_type_id` AS 'rfi_fk_recipient_fax_ccopn__phone_number_type_id',
	rfi_fk_recipient_fax_ccopn.`country_code` AS 'rfi_fk_recipient_fax_ccopn__country_code',
	rfi_fk_recipient_fax_ccopn.`area_code` AS 'rfi_fk_recipient_fax_ccopn__area_code',
	rfi_fk_recipient_fax_ccopn.`prefix` AS 'rfi_fk_recipient_fax_ccopn__prefix',
	rfi_fk_recipient_fax_ccopn.`number` AS 'rfi_fk_recipient_fax_ccopn__number',
	rfi_fk_recipient_fax_ccopn.`extension` AS 'rfi_fk_recipient_fax_ccopn__extension',
	rfi_fk_recipient_fax_ccopn.`itu` AS 'rfi_fk_recipient_fax_ccopn__itu',

	rfi_fk_recipient_c_mobile_cpn.`id` AS 'rfi_fk_recipient_c_mobile_cpn__contact_phone_number_id',
	rfi_fk_recipient_c_mobile_cpn.`contact_id` AS 'rfi_fk_recipient_c_mobile_cpn__contact_id',
	rfi_fk_recipient_c_mobile_cpn.`phone_number_type_id` AS 'rfi_fk_recipient_c_mobile_cpn__phone_number_type_id',
	rfi_fk_recipient_c_mobile_cpn.`country_code` AS 'rfi_fk_recipient_c_mobile_cpn__country_code',
	rfi_fk_recipient_c_mobile_cpn.`area_code` AS 'rfi_fk_recipient_c_mobile_cpn__area_code',
	rfi_fk_recipient_c_mobile_cpn.`prefix` AS 'rfi_fk_recipient_c_mobile_cpn__prefix',
	rfi_fk_recipient_c_mobile_cpn.`number` AS 'rfi_fk_recipient_c_mobile_cpn__number',
	rfi_fk_recipient_c_mobile_cpn.`extension` AS 'rfi_fk_recipient_c_mobile_cpn__extension',
	rfi_fk_recipient_c_mobile_cpn.`itu` AS 'rfi_fk_recipient_c_mobile_cpn__itu',

	rfi_fk_initiator_c.`id` AS 'rfi_fk_initiator_c__contact_id',
	rfi_fk_initiator_c.`user_company_id` AS 'rfi_fk_initiator_c__user_company_id',
	rfi_fk_initiator_c.`user_id` AS 'rfi_fk_initiator_c__user_id',
	rfi_fk_initiator_c.`contact_company_id` AS 'rfi_fk_initiator_c__contact_company_id',
	rfi_fk_initiator_c.`email` AS 'rfi_fk_initiator_c__email',
	rfi_fk_initiator_c.`name_prefix` AS 'rfi_fk_initiator_c__name_prefix',
	rfi_fk_initiator_c.`first_name` AS 'rfi_fk_initiator_c__first_name',
	rfi_fk_initiator_c.`additional_name` AS 'rfi_fk_initiator_c__additional_name',
	rfi_fk_initiator_c.`middle_name` AS 'rfi_fk_initiator_c__middle_name',
	rfi_fk_initiator_c.`last_name` AS 'rfi_fk_initiator_c__last_name',
	rfi_fk_initiator_c.`name_suffix` AS 'rfi_fk_initiator_c__name_suffix',
	rfi_fk_initiator_c.`title` AS 'rfi_fk_initiator_c__title',
	rfi_fk_initiator_c.`vendor_flag` AS 'rfi_fk_initiator_c__vendor_flag',

	rfi_fk_initiator_cco.`id` AS 'rfi_fk_initiator_cco__contact_company_office_id',
	rfi_fk_initiator_cco.`contact_company_id` AS 'rfi_fk_initiator_cco__contact_company_id',
	rfi_fk_initiator_cco.`office_nickname` AS 'rfi_fk_initiator_cco__office_nickname',
	rfi_fk_initiator_cco.`address_line_1` AS 'rfi_fk_initiator_cco__address_line_1',
	rfi_fk_initiator_cco.`address_line_2` AS 'rfi_fk_initiator_cco__address_line_2',
	rfi_fk_initiator_cco.`address_line_3` AS 'rfi_fk_initiator_cco__address_line_3',
	rfi_fk_initiator_cco.`address_line_4` AS 'rfi_fk_initiator_cco__address_line_4',
	rfi_fk_initiator_cco.`address_city` AS 'rfi_fk_initiator_cco__address_city',
	rfi_fk_initiator_cco.`address_county` AS 'rfi_fk_initiator_cco__address_county',
	rfi_fk_initiator_cco.`address_state_or_region` AS 'rfi_fk_initiator_cco__address_state_or_region',
	rfi_fk_initiator_cco.`address_postal_code` AS 'rfi_fk_initiator_cco__address_postal_code',
	rfi_fk_initiator_cco.`address_postal_code_extension` AS 'rfi_fk_initiator_cco__address_postal_code_extension',
	rfi_fk_initiator_cco.`address_country` AS 'rfi_fk_initiator_cco__address_country',
	rfi_fk_initiator_cco.`head_quarters_flag` AS 'rfi_fk_initiator_cco__head_quarters_flag',
	rfi_fk_initiator_cco.`address_validated_by_user_flag` AS 'rfi_fk_initiator_cco__address_validated_by_user_flag',
	rfi_fk_initiator_cco.`address_validated_by_web_service_flag` AS 'rfi_fk_initiator_cco__address_validated_by_web_service_flag',
	rfi_fk_initiator_cco.`address_validation_by_web_service_error_flag` AS 'rfi_fk_initiator_cco__address_validation_by_web_service_error_flag',

	rfi_fk_initiator_phone_ccopn.`id` AS 'rfi_fk_initiator_phone_ccopn__contact_company_office_phone_number_id',
	rfi_fk_initiator_phone_ccopn.`contact_company_office_id` AS 'rfi_fk_initiator_phone_ccopn__contact_company_office_id',
	rfi_fk_initiator_phone_ccopn.`phone_number_type_id` AS 'rfi_fk_initiator_phone_ccopn__phone_number_type_id',
	rfi_fk_initiator_phone_ccopn.`country_code` AS 'rfi_fk_initiator_phone_ccopn__country_code',
	rfi_fk_initiator_phone_ccopn.`area_code` AS 'rfi_fk_initiator_phone_ccopn__area_code',
	rfi_fk_initiator_phone_ccopn.`prefix` AS 'rfi_fk_initiator_phone_ccopn__prefix',
	rfi_fk_initiator_phone_ccopn.`number` AS 'rfi_fk_initiator_phone_ccopn__number',
	rfi_fk_initiator_phone_ccopn.`extension` AS 'rfi_fk_initiator_phone_ccopn__extension',
	rfi_fk_initiator_phone_ccopn.`itu` AS 'rfi_fk_initiator_phone_ccopn__itu',

	rfi_fk_initiator_fax_ccopn.`id` AS 'rfi_fk_initiator_fax_ccopn__contact_company_office_phone_number_id',
	rfi_fk_initiator_fax_ccopn.`contact_company_office_id` AS 'rfi_fk_initiator_fax_ccopn__contact_company_office_id',
	rfi_fk_initiator_fax_ccopn.`phone_number_type_id` AS 'rfi_fk_initiator_fax_ccopn__phone_number_type_id',
	rfi_fk_initiator_fax_ccopn.`country_code` AS 'rfi_fk_initiator_fax_ccopn__country_code',
	rfi_fk_initiator_fax_ccopn.`area_code` AS 'rfi_fk_initiator_fax_ccopn__area_code',
	rfi_fk_initiator_fax_ccopn.`prefix` AS 'rfi_fk_initiator_fax_ccopn__prefix',
	rfi_fk_initiator_fax_ccopn.`number` AS 'rfi_fk_initiator_fax_ccopn__number',
	rfi_fk_initiator_fax_ccopn.`extension` AS 'rfi_fk_initiator_fax_ccopn__extension',
	rfi_fk_initiator_fax_ccopn.`itu` AS 'rfi_fk_initiator_fax_ccopn__itu',

	rfi_fk_initiator_c_mobile_cpn.`id` AS 'rfi_fk_initiator_c_mobile_cpn__contact_phone_number_id',
	rfi_fk_initiator_c_mobile_cpn.`contact_id` AS 'rfi_fk_initiator_c_mobile_cpn__contact_id',
	rfi_fk_initiator_c_mobile_cpn.`phone_number_type_id` AS 'rfi_fk_initiator_c_mobile_cpn__phone_number_type_id',
	rfi_fk_initiator_c_mobile_cpn.`country_code` AS 'rfi_fk_initiator_c_mobile_cpn__country_code',
	rfi_fk_initiator_c_mobile_cpn.`area_code` AS 'rfi_fk_initiator_c_mobile_cpn__area_code',
	rfi_fk_initiator_c_mobile_cpn.`prefix` AS 'rfi_fk_initiator_c_mobile_cpn__prefix',
	rfi_fk_initiator_c_mobile_cpn.`number` AS 'rfi_fk_initiator_c_mobile_cpn__number',
	rfi_fk_initiator_c_mobile_cpn.`extension` AS 'rfi_fk_initiator_c_mobile_cpn__extension',
	rfi_fk_initiator_c_mobile_cpn.`itu` AS 'rfi_fk_initiator_c_mobile_cpn__itu',
	rfi_rs.modified AS res_modified_date, rfi_rs.request_for_information_response AS response_text,
	rfi.*

FROM `requests_for_information` rfi
	{$queryJoin} JOIN `request_for_information_responses` rfi_rs ON rfi.id = rfi_rs.request_for_information_id 
	INNER JOIN `projects` rfi_fk_p ON rfi.`project_id` = rfi_fk_p.`id`
	INNER JOIN `request_for_information_types` rfi_fk_rfit ON rfi.`request_for_information_type_id` = rfi_fk_rfit.`id`
	INNER JOIN `request_for_information_statuses` rfi_fk_rfis ON rfi.`request_for_information_status_id` = rfi_fk_rfis.`id`
	INNER JOIN `request_for_information_priorities` rfi_fk_rfip ON rfi.`request_for_information_priority_id` = rfi_fk_rfip.`id`
	LEFT OUTER JOIN `file_manager_files` rfi_fk_fmfiles ON rfi.`rfi_file_manager_file_id` = rfi_fk_fmfiles.`id`
	LEFT OUTER JOIN `cost_codes` rfi_fk_codes ON rfi.`rfi_cost_code_id` = rfi_fk_codes.`id`
	INNER JOIN `contacts` rfi_fk_creator_c ON rfi.`rfi_creator_contact_id` = rfi_fk_creator_c.`id`
	LEFT OUTER JOIN `contact_company_offices` rfi_fk_creator_cco ON rfi.`rfi_creator_contact_company_office_id` = rfi_fk_creator_cco.`id`
	LEFT OUTER JOIN `contact_company_office_phone_numbers` rfi_fk_creator_phone_ccopn ON rfi.`rfi_creator_phone_contact_company_office_phone_number_id` = rfi_fk_creator_phone_ccopn.`id`
	LEFT OUTER JOIN `contact_company_office_phone_numbers` rfi_fk_creator_fax_ccopn ON rfi.`rfi_creator_fax_contact_company_office_phone_number_id` = rfi_fk_creator_fax_ccopn.`id`
	LEFT OUTER JOIN `contact_phone_numbers` rfi_fk_creator_c_mobile_cpn ON rfi.`rfi_creator_contact_mobile_phone_number_id` = rfi_fk_creator_c_mobile_cpn.`id`
	LEFT OUTER JOIN `contacts` rfi_fk_recipient_c ON rfi.`rfi_recipient_contact_id` = rfi_fk_recipient_c.`id`
	LEFT OUTER JOIN `contact_company_offices` rfi_fk_recipient_cco ON rfi.`rfi_recipient_contact_company_office_id` = rfi_fk_recipient_cco.`id`
	LEFT OUTER JOIN `contact_company_office_phone_numbers` rfi_fk_recipient_phone_ccopn ON rfi.`rfi_recipient_phone_contact_company_office_phone_number_id` = rfi_fk_recipient_phone_ccopn.`id`
	LEFT OUTER JOIN `contact_company_office_phone_numbers` rfi_fk_recipient_fax_ccopn ON rfi.`rfi_recipient_fax_contact_company_office_phone_number_id` = rfi_fk_recipient_fax_ccopn.`id`
	LEFT OUTER JOIN `contact_phone_numbers` rfi_fk_recipient_c_mobile_cpn ON rfi.`rfi_recipient_contact_mobile_phone_number_id` = rfi_fk_recipient_c_mobile_cpn.`id`
	LEFT OUTER JOIN `contacts` rfi_fk_initiator_c ON rfi.`rfi_initiator_contact_id` = rfi_fk_initiator_c.`id`
	LEFT OUTER JOIN `contact_company_offices` rfi_fk_initiator_cco ON rfi.`rfi_initiator_contact_company_office_id` = rfi_fk_initiator_cco.`id`
	LEFT OUTER JOIN `contact_company_office_phone_numbers` rfi_fk_initiator_phone_ccopn ON rfi.`rfi_initiator_phone_contact_company_office_phone_number_id` = rfi_fk_initiator_phone_ccopn.`id`
	LEFT OUTER JOIN `contact_company_office_phone_numbers` rfi_fk_initiator_fax_ccopn ON rfi.`rfi_initiator_fax_contact_company_office_phone_number_id` = rfi_fk_initiator_fax_ccopn.`id`
	LEFT OUTER JOIN `contact_phone_numbers` rfi_fk_initiator_c_mobile_cpn ON rfi.`rfi_initiator_contact_mobile_phone_number_id` = rfi_fk_initiator_c_mobile_cpn.`id`
WHERE rfi.`project_id` = ? {$whereCause} {$queryStatus} AND date(rfi.created) BETWEEN '$new_begindate' AND '$enddate' {$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `rfi_sequence_number` ASC, `request_for_information_type_id` ASC, `request_for_information_status_id` ASC, `request_for_information_priority_id` ASC, `rfi_file_manager_file_id` ASC, `rfi_cost_code_id` ASC, `rfi_creator_contact_id` ASC, `rfi_creator_contact_company_office_id` ASC, `rfi_creator_phone_contact_company_office_phone_number_id` ASC, `rfi_creator_fax_contact_company_office_phone_number_id` ASC, `rfi_creator_contact_mobile_phone_number_id` ASC, `rfi_recipient_contact_id` ASC, `rfi_recipient_contact_company_office_id` ASC, `rfi_recipient_phone_contact_company_office_phone_number_id` ASC, `rfi_recipient_fax_contact_company_office_phone_number_id` ASC, `rfi_recipient_contact_mobile_phone_number_id` ASC, `rfi_initiator_contact_id` ASC, `rfi_initiator_contact_company_office_id` ASC, `rfi_initiator_phone_contact_company_office_phone_number_id` ASC, `rfi_initiator_fax_contact_company_office_phone_number_id` ASC, `rfi_initiator_contact_mobile_phone_number_id` ASC, `rfi_title` ASC, `rfi_plan_page_reference` ASC, `rfi_statement` ASC, `created` ASC, `rfi_due_date` ASC, `rfi_closed_date` ASC
		$arrValues = array($project_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrRequestsForInformationByProjectId = array();
		$index=0;
		while ($row = $db->fetch()) {
			$request_for_information_id = $row['id'];
			$requestForInformation = self::instantiateOrm($database, 'RequestForInformation', $row, null, $request_for_information_id);
			/* @var $requestForInformation RequestForInformation */
			$requestForInformation->convertPropertiesToData();

			if (isset($row['project_id'])) {
				$project_id = $row['project_id'];
				$row['rfi_fk_p__id'] = $project_id;
				$project = self::instantiateOrm($database, 'Project', $row, null, $project_id, 'rfi_fk_p__');
				/* @var $project Project */
				$project->convertPropertiesToData();
			} else {
				$project = false;
			}
			$requestForInformation->setProject($project);

			if (isset($row['request_for_information_type_id'])) {
				$request_for_information_type_id = $row['request_for_information_type_id'];
				$row['rfi_fk_rfit__id'] = $request_for_information_type_id;
				$requestForInformationType = self::instantiateOrm($database, 'RequestForInformationType', $row, null, $request_for_information_type_id, 'rfi_fk_rfit__');
				/* @var $requestForInformationType RequestForInformationType */
				$requestForInformationType->convertPropertiesToData();
			} else {
				$requestForInformationType = false;
			}
			$requestForInformation->setRequestForInformationType($requestForInformationType);

			if (isset($row['request_for_information_status_id'])) {
				$request_for_information_status_id = $row['request_for_information_status_id'];
				$row['rfi_fk_rfis__id'] = $request_for_information_status_id;
				$requestForInformationStatus = self::instantiateOrm($database, 'RequestForInformationStatus', $row, null, $request_for_information_status_id, 'rfi_fk_rfis__');
				/* @var $requestForInformationStatus RequestForInformationStatus */
				$requestForInformationStatus->convertPropertiesToData();
			} else {
				$requestForInformationStatus = false;
			}
			$requestForInformation->setRequestForInformationStatus($requestForInformationStatus);

			if (isset($row['request_for_information_priority_id'])) {
				$request_for_information_priority_id = $row['request_for_information_priority_id'];
				$row['rfi_fk_rfip__id'] = $request_for_information_priority_id;
				$requestForInformationPriority = self::instantiateOrm($database, 'RequestForInformationPriority', $row, null, $request_for_information_priority_id, 'rfi_fk_rfip__');
				/* @var $requestForInformationPriority RequestForInformationPriority */
				$requestForInformationPriority->convertPropertiesToData();
			} else {
				$requestForInformationPriority = false;
			}
			$requestForInformation->setRequestForInformationPriority($requestForInformationPriority);
			$requestForInformation['response_text']=$row['response_text'];
			$requestForInformation['response_Date']=$row['res_modified_date'];
		// if (isset($row['response_text'])) {
		// 		$response_text = $row['response_text'];
		// 		$row['response_text'] = $response_text;
		// 		$requestForInformationResponse = self::instantiateOrm($database, 'ResponseText', $row, null, $response_text, 'rfi_fk_res__');
		// 		/* @var $requestForInformationPriority RequestForInformationPriority */
		// 		$requestForInformationResponse->convertPropertiesToData();
		// 	} else {
		// 		$requestForInformationResponse = false;
		// 	}

			if (isset($row['rfi_file_manager_file_id'])) {
				$rfi_file_manager_file_id = $row['rfi_file_manager_file_id'];
				$row['rfi_fk_fmfiles__id'] = $rfi_file_manager_file_id;
				$rfiFileManagerFile = self::instantiateOrm($database, 'FileManagerFile', $row, null, $rfi_file_manager_file_id, 'rfi_fk_fmfiles__');
				/* @var $rfiFileManagerFile FileManagerFile */
				$rfiFileManagerFile->convertPropertiesToData();
			} else {
				$rfiFileManagerFile = false;
			}
			$requestForInformation->setRfiFileManagerFile($rfiFileManagerFile);

			if (isset($row['rfi_cost_code_id'])) {
				$rfi_cost_code_id = $row['rfi_cost_code_id'];
				$row['rfi_fk_codes__id'] = $rfi_cost_code_id;
				$rfiCostCode = self::instantiateOrm($database, 'CostCode', $row, null, $rfi_cost_code_id, 'rfi_fk_codes__');
				/* @var $rfiCostCode CostCode */
				$rfiCostCode->convertPropertiesToData();
			} else {
				$rfiCostCode = false;
			}
			$requestForInformation->setRfiCostCode($rfiCostCode);

			if (isset($row['rfi_creator_contact_id'])) {
				$rfi_creator_contact_id = $row['rfi_creator_contact_id'];
				$row['rfi_fk_creator_c__id'] = $rfi_creator_contact_id;
				$rfiCreatorContact = self::instantiateOrm($database, 'Contact', $row, null, $rfi_creator_contact_id, 'rfi_fk_creator_c__');
				/* @var $rfiCreatorContact Contact */
				$rfiCreatorContact->convertPropertiesToData();
			} else {
				$rfiCreatorContact = false;
			}
			$requestForInformation->setRfiCreatorContact($rfiCreatorContact);

			if (isset($row['rfi_creator_contact_company_office_id'])) {
				$rfi_creator_contact_company_office_id = $row['rfi_creator_contact_company_office_id'];
				$row['rfi_fk_creator_cco__id'] = $rfi_creator_contact_company_office_id;
				$rfiCreatorContactCompanyOffice = self::instantiateOrm($database, 'ContactCompanyOffice', $row, null, $rfi_creator_contact_company_office_id, 'rfi_fk_creator_cco__');
				/* @var $rfiCreatorContactCompanyOffice ContactCompanyOffice */
				$rfiCreatorContactCompanyOffice->convertPropertiesToData();
			} else {
				$rfiCreatorContactCompanyOffice = false;
			}
			$requestForInformation->setRfiCreatorContactCompanyOffice($rfiCreatorContactCompanyOffice);

			if (isset($row['rfi_creator_phone_contact_company_office_phone_number_id'])) {
				$rfi_creator_phone_contact_company_office_phone_number_id = $row['rfi_creator_phone_contact_company_office_phone_number_id'];
				$row['rfi_fk_creator_phone_ccopn__id'] = $rfi_creator_phone_contact_company_office_phone_number_id;
				$rfiCreatorPhoneContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $rfi_creator_phone_contact_company_office_phone_number_id, 'rfi_fk_creator_phone_ccopn__');
				/* @var $rfiCreatorPhoneContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$rfiCreatorPhoneContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$rfiCreatorPhoneContactCompanyOfficePhoneNumber = false;
			}
			$requestForInformation->setRfiCreatorPhoneContactCompanyOfficePhoneNumber($rfiCreatorPhoneContactCompanyOfficePhoneNumber);

			if (isset($row['rfi_creator_fax_contact_company_office_phone_number_id'])) {
				$rfi_creator_fax_contact_company_office_phone_number_id = $row['rfi_creator_fax_contact_company_office_phone_number_id'];
				$row['rfi_fk_creator_fax_ccopn__id'] = $rfi_creator_fax_contact_company_office_phone_number_id;
				$rfiCreatorFaxContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $rfi_creator_fax_contact_company_office_phone_number_id, 'rfi_fk_creator_fax_ccopn__');
				/* @var $rfiCreatorFaxContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$rfiCreatorFaxContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$rfiCreatorFaxContactCompanyOfficePhoneNumber = false;
			}
			$requestForInformation->setRfiCreatorFaxContactCompanyOfficePhoneNumber($rfiCreatorFaxContactCompanyOfficePhoneNumber);

			if (isset($row['rfi_creator_contact_mobile_phone_number_id'])) {
				$rfi_creator_contact_mobile_phone_number_id = $row['rfi_creator_contact_mobile_phone_number_id'];
				$row['rfi_fk_creator_c_mobile_cpn__id'] = $rfi_creator_contact_mobile_phone_number_id;
				$rfiCreatorContactMobilePhoneNumber = self::instantiateOrm($database, 'ContactPhoneNumber', $row, null, $rfi_creator_contact_mobile_phone_number_id, 'rfi_fk_creator_c_mobile_cpn__');
				/* @var $rfiCreatorContactMobilePhoneNumber ContactPhoneNumber */
				$rfiCreatorContactMobilePhoneNumber->convertPropertiesToData();
			} else {
				$rfiCreatorContactMobilePhoneNumber = false;
			}
			$requestForInformation->setRfiCreatorContactMobilePhoneNumber($rfiCreatorContactMobilePhoneNumber);

			if (isset($row['rfi_recipient_contact_id'])) {
				$rfi_recipient_contact_id = $row['rfi_recipient_contact_id'];
				$row['rfi_fk_recipient_c__id'] = $rfi_recipient_contact_id;
				$rfiRecipientContact = self::instantiateOrm($database, 'Contact', $row, null, $rfi_recipient_contact_id, 'rfi_fk_recipient_c__');
				/* @var $rfiRecipientContact Contact */
				$rfiRecipientContact->convertPropertiesToData();
			} else {
				$rfiRecipientContact = false;
			}
			$requestForInformation->setRfiRecipientContact($rfiRecipientContact);

			if (isset($row['rfi_recipient_contact_company_office_id'])) {
				$rfi_recipient_contact_company_office_id = $row['rfi_recipient_contact_company_office_id'];
				$row['rfi_fk_recipient_cco__id'] = $rfi_recipient_contact_company_office_id;
				$rfiRecipientContactCompanyOffice = self::instantiateOrm($database, 'ContactCompanyOffice', $row, null, $rfi_recipient_contact_company_office_id, 'rfi_fk_recipient_cco__');
				/* @var $rfiRecipientContactCompanyOffice ContactCompanyOffice */
				$rfiRecipientContactCompanyOffice->convertPropertiesToData();
			} else {
				$rfiRecipientContactCompanyOffice = false;
			}
			$requestForInformation->setRfiRecipientContactCompanyOffice($rfiRecipientContactCompanyOffice);

			if (isset($row['rfi_recipient_phone_contact_company_office_phone_number_id'])) {
				$rfi_recipient_phone_contact_company_office_phone_number_id = $row['rfi_recipient_phone_contact_company_office_phone_number_id'];
				$row['rfi_fk_recipient_phone_ccopn__id'] = $rfi_recipient_phone_contact_company_office_phone_number_id;
				$rfiRecipientPhoneContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $rfi_recipient_phone_contact_company_office_phone_number_id, 'rfi_fk_recipient_phone_ccopn__');
				/* @var $rfiRecipientPhoneContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$rfiRecipientPhoneContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$rfiRecipientPhoneContactCompanyOfficePhoneNumber = false;
			}
			$requestForInformation->setRfiRecipientPhoneContactCompanyOfficePhoneNumber($rfiRecipientPhoneContactCompanyOfficePhoneNumber);

			if (isset($row['rfi_recipient_fax_contact_company_office_phone_number_id'])) {
				$rfi_recipient_fax_contact_company_office_phone_number_id = $row['rfi_recipient_fax_contact_company_office_phone_number_id'];
				$row['rfi_fk_recipient_fax_ccopn__id'] = $rfi_recipient_fax_contact_company_office_phone_number_id;
				$rfiRecipientFaxContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $rfi_recipient_fax_contact_company_office_phone_number_id, 'rfi_fk_recipient_fax_ccopn__');
				/* @var $rfiRecipientFaxContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$rfiRecipientFaxContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$rfiRecipientFaxContactCompanyOfficePhoneNumber = false;
			}
			$requestForInformation->setRfiRecipientFaxContactCompanyOfficePhoneNumber($rfiRecipientFaxContactCompanyOfficePhoneNumber);

			if (isset($row['rfi_recipient_contact_mobile_phone_number_id'])) {
				$rfi_recipient_contact_mobile_phone_number_id = $row['rfi_recipient_contact_mobile_phone_number_id'];
				$row['rfi_fk_recipient_c_mobile_cpn__id'] = $rfi_recipient_contact_mobile_phone_number_id;
				$rfiRecipientContactMobilePhoneNumber = self::instantiateOrm($database, 'ContactPhoneNumber', $row, null, $rfi_recipient_contact_mobile_phone_number_id, 'rfi_fk_recipient_c_mobile_cpn__');
				/* @var $rfiRecipientContactMobilePhoneNumber ContactPhoneNumber */
				$rfiRecipientContactMobilePhoneNumber->convertPropertiesToData();
			} else {
				$rfiRecipientContactMobilePhoneNumber = false;
			}
			$requestForInformation->setRfiRecipientContactMobilePhoneNumber($rfiRecipientContactMobilePhoneNumber);

			if (isset($row['rfi_initiator_contact_id'])) {
				$rfi_initiator_contact_id = $row['rfi_initiator_contact_id'];
				$row['rfi_fk_initiator_c__id'] = $rfi_initiator_contact_id;
				$rfiInitiatorContact = self::instantiateOrm($database, 'Contact', $row, null, $rfi_initiator_contact_id, 'rfi_fk_initiator_c__');
				/* @var $rfiInitiatorContact Contact */
				$rfiInitiatorContact->convertPropertiesToData();
			} else {
				$rfiInitiatorContact = false;
			}
			$requestForInformation->setRfiInitiatorContact($rfiInitiatorContact);

			if (isset($row['rfi_initiator_contact_company_office_id'])) {
				$rfi_initiator_contact_company_office_id = $row['rfi_initiator_contact_company_office_id'];
				$row['rfi_fk_initiator_cco__id'] = $rfi_initiator_contact_company_office_id;
				$rfiInitiatorContactCompanyOffice = self::instantiateOrm($database, 'ContactCompanyOffice', $row, null, $rfi_initiator_contact_company_office_id, 'rfi_fk_initiator_cco__');
				/* @var $rfiInitiatorContactCompanyOffice ContactCompanyOffice */
				$rfiInitiatorContactCompanyOffice->convertPropertiesToData();
			} else {
				$rfiInitiatorContactCompanyOffice = false;
			}
			$requestForInformation->setRfiInitiatorContactCompanyOffice($rfiInitiatorContactCompanyOffice);

			if (isset($row['rfi_initiator_phone_contact_company_office_phone_number_id'])) {
				$rfi_initiator_phone_contact_company_office_phone_number_id = $row['rfi_initiator_phone_contact_company_office_phone_number_id'];
				$row['rfi_fk_initiator_phone_ccopn__id'] = $rfi_initiator_phone_contact_company_office_phone_number_id;
				$rfiInitiatorPhoneContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $rfi_initiator_phone_contact_company_office_phone_number_id, 'rfi_fk_initiator_phone_ccopn__');
				/* @var $rfiInitiatorPhoneContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$rfiInitiatorPhoneContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$rfiInitiatorPhoneContactCompanyOfficePhoneNumber = false;
			}
			$requestForInformation->setRfiInitiatorPhoneContactCompanyOfficePhoneNumber($rfiInitiatorPhoneContactCompanyOfficePhoneNumber);

			if (isset($row['rfi_initiator_fax_contact_company_office_phone_number_id'])) {
				$rfi_initiator_fax_contact_company_office_phone_number_id = $row['rfi_initiator_fax_contact_company_office_phone_number_id'];
				$row['rfi_fk_initiator_fax_ccopn__id'] = $rfi_initiator_fax_contact_company_office_phone_number_id;
				$rfiInitiatorFaxContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $rfi_initiator_fax_contact_company_office_phone_number_id, 'rfi_fk_initiator_fax_ccopn__');
				/* @var $rfiInitiatorFaxContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$rfiInitiatorFaxContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$rfiInitiatorFaxContactCompanyOfficePhoneNumber = false;
			}
			$requestForInformation->setRfiInitiatorFaxContactCompanyOfficePhoneNumber($rfiInitiatorFaxContactCompanyOfficePhoneNumber);

			if (isset($row['rfi_initiator_contact_mobile_phone_number_id'])) {
				$rfi_initiator_contact_mobile_phone_number_id = $row['rfi_initiator_contact_mobile_phone_number_id'];
				$row['rfi_fk_initiator_c_mobile_cpn__id'] = $rfi_initiator_contact_mobile_phone_number_id;
				$rfiInitiatorContactMobilePhoneNumber = self::instantiateOrm($database, 'ContactPhoneNumber', $row, null, $rfi_initiator_contact_mobile_phone_number_id, 'rfi_fk_initiator_c_mobile_cpn__');
				/* @var $rfiInitiatorContactMobilePhoneNumber ContactPhoneNumber */
				$rfiInitiatorContactMobilePhoneNumber->convertPropertiesToData();
			} else {
				$rfiInitiatorContactMobilePhoneNumber = false;
			}
			$requestForInformation->setRfiInitiatorContactMobilePhoneNumber($rfiInitiatorContactMobilePhoneNumber);
			if($typepost=='RFI Report - by ID')
			$arrRequestsForInformationByProjectId[$request_for_information_id] = $requestForInformation;
		
			if($typepost=='RFI Report - QA' || $typepost=='RFI Report - QA - Open')
			$arrRequestsForInformationByProjectId[$index] = $requestForInformation;

			// $arrRequestsForInformationByProjectId[$index] = $requestForInformation;
			$index++;
		}

		$db->free_result();

		// self::$_arrRequestsForInformationByProjectId = $arrRequestsForInformationByProjectId;

		return $arrRequestsForInformationByProjectId;
	}
	//Get the Open rfi data for Report modul Report By ID for jobstatus report
	public static function loadOpenRequestsForInformationByProjectIdReport($database, $project_id, Input $options=null, $new_begindate, $enddate, $typepost)
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
			self::$_arrRequestsForInformationByProjectId = null;
		}

		$arrRequestsForInformationByProjectId = self::$_arrRequestsForInformationByProjectId;
		if (isset($arrRequestsForInformationByProjectId) && !empty($arrRequestsForInformationByProjectId)) {
			return $arrRequestsForInformationByProjectId;
		}

		$project_id = (int) $project_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `rfi_sequence_number` ASC, `request_for_information_type_id` ASC, `request_for_information_status_id` ASC, `request_for_information_priority_id` ASC, `rfi_file_manager_file_id` ASC, `rfi_cost_code_id` ASC, `rfi_creator_contact_id` ASC, `rfi_creator_contact_company_office_id` ASC, `rfi_creator_phone_contact_company_office_phone_number_id` ASC, `rfi_creator_fax_contact_company_office_phone_number_id` ASC, `rfi_creator_contact_mobile_phone_number_id` ASC, `rfi_recipient_contact_id` ASC, `rfi_recipient_contact_company_office_id` ASC, `rfi_recipient_phone_contact_company_office_phone_number_id` ASC, `rfi_recipient_fax_contact_company_office_phone_number_id` ASC, `rfi_recipient_contact_mobile_phone_number_id` ASC, `rfi_initiator_contact_id` ASC, `rfi_initiator_contact_company_office_id` ASC, `rfi_initiator_phone_contact_company_office_phone_number_id` ASC, `rfi_initiator_fax_contact_company_office_phone_number_id` ASC, `rfi_initiator_contact_mobile_phone_number_id` ASC, `rfi_title` ASC, `rfi_plan_page_reference` ASC, `rfi_statement` ASC, `created` ASC, `rfi_due_date` ASC, `rfi_closed_date` ASC
		$sqlOrderBy = "\nORDER BY `created` DESC, `rfi_sequence_number` DESC, `request_for_information_priority_id` ASC, `request_for_information_type_id` ASC, `request_for_information_status_id` ASC";

		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpRequestForInformation = new RequestForInformation($database);
			$sqlOrderByColumns = $tmpRequestForInformation->constructSqlOrderByColumns($arrOrderByAttributes);
				
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
			$queryJoin='LEFT';
			$queryStatus='AND request_for_information_status_id = 2';
		
		$query =
"
SELECT

	rfi_fk_p.`id` AS 'rfi_fk_p__project_id',
	rfi_fk_p.`project_type_id` AS 'rfi_fk_p__project_type_id',
	rfi_fk_p.`user_company_id` AS 'rfi_fk_p__user_company_id',
	rfi_fk_p.`user_custom_project_id` AS 'rfi_fk_p__user_custom_project_id',
	rfi_fk_p.`project_name` AS 'rfi_fk_p__project_name',
	rfi_fk_p.`project_owner_name` AS 'rfi_fk_p__project_owner_name',
	rfi_fk_p.`latitude` AS 'rfi_fk_p__latitude',
	rfi_fk_p.`longitude` AS 'rfi_fk_p__longitude',
	rfi_fk_p.`address_line_1` AS 'rfi_fk_p__address_line_1',
	rfi_fk_p.`address_line_2` AS 'rfi_fk_p__address_line_2',
	rfi_fk_p.`address_line_3` AS 'rfi_fk_p__address_line_3',
	rfi_fk_p.`address_line_4` AS 'rfi_fk_p__address_line_4',
	rfi_fk_p.`address_city` AS 'rfi_fk_p__address_city',
	rfi_fk_p.`address_county` AS 'rfi_fk_p__address_county',
	rfi_fk_p.`address_state_or_region` AS 'rfi_fk_p__address_state_or_region',
	rfi_fk_p.`address_postal_code` AS 'rfi_fk_p__address_postal_code',
	rfi_fk_p.`address_postal_code_extension` AS 'rfi_fk_p__address_postal_code_extension',
	rfi_fk_p.`address_country` AS 'rfi_fk_p__address_country',
	rfi_fk_p.`building_count` AS 'rfi_fk_p__building_count',
	rfi_fk_p.`unit_count` AS 'rfi_fk_p__unit_count',
	rfi_fk_p.`gross_square_footage` AS 'rfi_fk_p__gross_square_footage',
	rfi_fk_p.`net_rentable_square_footage` AS 'rfi_fk_p__net_rentable_square_footage',
	rfi_fk_p.`is_active_flag` AS 'rfi_fk_p__is_active_flag',
	rfi_fk_p.`public_plans_flag` AS 'rfi_fk_p__public_plans_flag',
	rfi_fk_p.`prevailing_wage_flag` AS 'rfi_fk_p__prevailing_wage_flag',
	rfi_fk_p.`city_business_license_required_flag` AS 'rfi_fk_p__city_business_license_required_flag',
	rfi_fk_p.`is_internal_flag` AS 'rfi_fk_p__is_internal_flag',
	rfi_fk_p.`project_contract_date` AS 'rfi_fk_p__project_contract_date',
	rfi_fk_p.`project_start_date` AS 'rfi_fk_p__project_start_date',
	rfi_fk_p.`project_completed_date` AS 'rfi_fk_p__project_completed_date',
	rfi_fk_p.`sort_order` AS 'rfi_fk_p__sort_order',

	rfi_fk_rfit.`id` AS 'rfi_fk_rfit__request_for_information_type_id',
	rfi_fk_rfit.`request_for_information_type` AS 'rfi_fk_rfit__request_for_information_type',
	rfi_fk_rfit.`disabled_flag` AS 'rfi_fk_rfit__disabled_flag',

	rfi_fk_rfis.`id` AS 'rfi_fk_rfis__request_for_information_status_id',
	rfi_fk_rfis.`request_for_information_status` AS 'rfi_fk_rfis__request_for_information_status',
	rfi_fk_rfis.`disabled_flag` AS 'rfi_fk_rfis__disabled_flag',

	rfi_fk_rfip.`id` AS 'rfi_fk_rfip__request_for_information_priority_id',
	rfi_fk_rfip.`request_for_information_priority` AS 'rfi_fk_rfip__request_for_information_priority',
	rfi_fk_rfip.`disabled_flag` AS 'rfi_fk_rfip__disabled_flag',

	rfi_fk_fmfiles.`id` AS 'rfi_fk_fmfiles__file_manager_file_id',
	rfi_fk_fmfiles.`user_company_id` AS 'rfi_fk_fmfiles__user_company_id',
	rfi_fk_fmfiles.`contact_id` AS 'rfi_fk_fmfiles__contact_id',
	rfi_fk_fmfiles.`project_id` AS 'rfi_fk_fmfiles__project_id',
	rfi_fk_fmfiles.`file_manager_folder_id` AS 'rfi_fk_fmfiles__file_manager_folder_id',
	rfi_fk_fmfiles.`file_location_id` AS 'rfi_fk_fmfiles__file_location_id',
	rfi_fk_fmfiles.`virtual_file_name` AS 'rfi_fk_fmfiles__virtual_file_name',
	rfi_fk_fmfiles.`version_number` AS 'rfi_fk_fmfiles__version_number',
	rfi_fk_fmfiles.`virtual_file_name_sha1` AS 'rfi_fk_fmfiles__virtual_file_name_sha1',
	rfi_fk_fmfiles.`virtual_file_mime_type` AS 'rfi_fk_fmfiles__virtual_file_mime_type',
	rfi_fk_fmfiles.`modified` AS 'rfi_fk_fmfiles__modified',
	rfi_fk_fmfiles.`created` AS 'rfi_fk_fmfiles__created',
	rfi_fk_fmfiles.`deleted_flag` AS 'rfi_fk_fmfiles__deleted_flag',
	rfi_fk_fmfiles.`directly_deleted_flag` AS 'rfi_fk_fmfiles__directly_deleted_flag',

	rfi_fk_codes.`id` AS 'rfi_fk_codes__cost_code_id',
	rfi_fk_codes.`cost_code_division_id` AS 'rfi_fk_codes__cost_code_division_id',
	rfi_fk_codes.`cost_code` AS 'rfi_fk_codes__cost_code',
	rfi_fk_codes.`cost_code_description` AS 'rfi_fk_codes__cost_code_description',
	rfi_fk_codes.`cost_code_description_abbreviation` AS 'rfi_fk_codes__cost_code_description_abbreviation',
	rfi_fk_codes.`sort_order` AS 'rfi_fk_codes__sort_order',
	rfi_fk_codes.`disabled_flag` AS 'rfi_fk_codes__disabled_flag',

	rfi_fk_creator_c.`id` AS 'rfi_fk_creator_c__contact_id',
	rfi_fk_creator_c.`user_company_id` AS 'rfi_fk_creator_c__user_company_id',
	rfi_fk_creator_c.`user_id` AS 'rfi_fk_creator_c__user_id',
	rfi_fk_creator_c.`contact_company_id` AS 'rfi_fk_creator_c__contact_company_id',
	rfi_fk_creator_c.`email` AS 'rfi_fk_creator_c__email',
	rfi_fk_creator_c.`name_prefix` AS 'rfi_fk_creator_c__name_prefix',
	rfi_fk_creator_c.`first_name` AS 'rfi_fk_creator_c__first_name',
	rfi_fk_creator_c.`additional_name` AS 'rfi_fk_creator_c__additional_name',
	rfi_fk_creator_c.`middle_name` AS 'rfi_fk_creator_c__middle_name',
	rfi_fk_creator_c.`last_name` AS 'rfi_fk_creator_c__last_name',
	rfi_fk_creator_c.`name_suffix` AS 'rfi_fk_creator_c__name_suffix',
	rfi_fk_creator_c.`title` AS 'rfi_fk_creator_c__title',
	rfi_fk_creator_c.`vendor_flag` AS 'rfi_fk_creator_c__vendor_flag',

	rfi_fk_creator_cco.`id` AS 'rfi_fk_creator_cco__contact_company_office_id',
	rfi_fk_creator_cco.`contact_company_id` AS 'rfi_fk_creator_cco__contact_company_id',
	rfi_fk_creator_cco.`office_nickname` AS 'rfi_fk_creator_cco__office_nickname',
	rfi_fk_creator_cco.`address_line_1` AS 'rfi_fk_creator_cco__address_line_1',
	rfi_fk_creator_cco.`address_line_2` AS 'rfi_fk_creator_cco__address_line_2',
	rfi_fk_creator_cco.`address_line_3` AS 'rfi_fk_creator_cco__address_line_3',
	rfi_fk_creator_cco.`address_line_4` AS 'rfi_fk_creator_cco__address_line_4',
	rfi_fk_creator_cco.`address_city` AS 'rfi_fk_creator_cco__address_city',
	rfi_fk_creator_cco.`address_county` AS 'rfi_fk_creator_cco__address_county',
	rfi_fk_creator_cco.`address_state_or_region` AS 'rfi_fk_creator_cco__address_state_or_region',
	rfi_fk_creator_cco.`address_postal_code` AS 'rfi_fk_creator_cco__address_postal_code',
	rfi_fk_creator_cco.`address_postal_code_extension` AS 'rfi_fk_creator_cco__address_postal_code_extension',
	rfi_fk_creator_cco.`address_country` AS 'rfi_fk_creator_cco__address_country',
	rfi_fk_creator_cco.`head_quarters_flag` AS 'rfi_fk_creator_cco__head_quarters_flag',
	rfi_fk_creator_cco.`address_validated_by_user_flag` AS 'rfi_fk_creator_cco__address_validated_by_user_flag',
	rfi_fk_creator_cco.`address_validated_by_web_service_flag` AS 'rfi_fk_creator_cco__address_validated_by_web_service_flag',
	rfi_fk_creator_cco.`address_validation_by_web_service_error_flag` AS 'rfi_fk_creator_cco__address_validation_by_web_service_error_flag',

	rfi_fk_creator_phone_ccopn.`id` AS 'rfi_fk_creator_phone_ccopn__contact_company_office_phone_number_id',
	rfi_fk_creator_phone_ccopn.`contact_company_office_id` AS 'rfi_fk_creator_phone_ccopn__contact_company_office_id',
	rfi_fk_creator_phone_ccopn.`phone_number_type_id` AS 'rfi_fk_creator_phone_ccopn__phone_number_type_id',
	rfi_fk_creator_phone_ccopn.`country_code` AS 'rfi_fk_creator_phone_ccopn__country_code',
	rfi_fk_creator_phone_ccopn.`area_code` AS 'rfi_fk_creator_phone_ccopn__area_code',
	rfi_fk_creator_phone_ccopn.`prefix` AS 'rfi_fk_creator_phone_ccopn__prefix',
	rfi_fk_creator_phone_ccopn.`number` AS 'rfi_fk_creator_phone_ccopn__number',
	rfi_fk_creator_phone_ccopn.`extension` AS 'rfi_fk_creator_phone_ccopn__extension',
	rfi_fk_creator_phone_ccopn.`itu` AS 'rfi_fk_creator_phone_ccopn__itu',

	rfi_fk_creator_fax_ccopn.`id` AS 'rfi_fk_creator_fax_ccopn__contact_company_office_phone_number_id',
	rfi_fk_creator_fax_ccopn.`contact_company_office_id` AS 'rfi_fk_creator_fax_ccopn__contact_company_office_id',
	rfi_fk_creator_fax_ccopn.`phone_number_type_id` AS 'rfi_fk_creator_fax_ccopn__phone_number_type_id',
	rfi_fk_creator_fax_ccopn.`country_code` AS 'rfi_fk_creator_fax_ccopn__country_code',
	rfi_fk_creator_fax_ccopn.`area_code` AS 'rfi_fk_creator_fax_ccopn__area_code',
	rfi_fk_creator_fax_ccopn.`prefix` AS 'rfi_fk_creator_fax_ccopn__prefix',
	rfi_fk_creator_fax_ccopn.`number` AS 'rfi_fk_creator_fax_ccopn__number',
	rfi_fk_creator_fax_ccopn.`extension` AS 'rfi_fk_creator_fax_ccopn__extension',
	rfi_fk_creator_fax_ccopn.`itu` AS 'rfi_fk_creator_fax_ccopn__itu',

	rfi_fk_creator_c_mobile_cpn.`id` AS 'rfi_fk_creator_c_mobile_cpn__contact_phone_number_id',
	rfi_fk_creator_c_mobile_cpn.`contact_id` AS 'rfi_fk_creator_c_mobile_cpn__contact_id',
	rfi_fk_creator_c_mobile_cpn.`phone_number_type_id` AS 'rfi_fk_creator_c_mobile_cpn__phone_number_type_id',
	rfi_fk_creator_c_mobile_cpn.`country_code` AS 'rfi_fk_creator_c_mobile_cpn__country_code',
	rfi_fk_creator_c_mobile_cpn.`area_code` AS 'rfi_fk_creator_c_mobile_cpn__area_code',
	rfi_fk_creator_c_mobile_cpn.`prefix` AS 'rfi_fk_creator_c_mobile_cpn__prefix',
	rfi_fk_creator_c_mobile_cpn.`number` AS 'rfi_fk_creator_c_mobile_cpn__number',
	rfi_fk_creator_c_mobile_cpn.`extension` AS 'rfi_fk_creator_c_mobile_cpn__extension',
	rfi_fk_creator_c_mobile_cpn.`itu` AS 'rfi_fk_creator_c_mobile_cpn__itu',

	rfi_fk_recipient_c.`id` AS 'rfi_fk_recipient_c__contact_id',
	rfi_fk_recipient_c.`user_company_id` AS 'rfi_fk_recipient_c__user_company_id',
	rfi_fk_recipient_c.`user_id` AS 'rfi_fk_recipient_c__user_id',
	rfi_fk_recipient_c.`contact_company_id` AS 'rfi_fk_recipient_c__contact_company_id',
	rfi_fk_recipient_c.`email` AS 'rfi_fk_recipient_c__email',
	rfi_fk_recipient_c.`name_prefix` AS 'rfi_fk_recipient_c__name_prefix',
	rfi_fk_recipient_c.`first_name` AS 'rfi_fk_recipient_c__first_name',
	rfi_fk_recipient_c.`additional_name` AS 'rfi_fk_recipient_c__additional_name',
	rfi_fk_recipient_c.`middle_name` AS 'rfi_fk_recipient_c__middle_name',
	rfi_fk_recipient_c.`last_name` AS 'rfi_fk_recipient_c__last_name',
	rfi_fk_recipient_c.`name_suffix` AS 'rfi_fk_recipient_c__name_suffix',
	rfi_fk_recipient_c.`title` AS 'rfi_fk_recipient_c__title',
	rfi_fk_recipient_c.`vendor_flag` AS 'rfi_fk_recipient_c__vendor_flag',

	rfi_fk_recipient_cco.`id` AS 'rfi_fk_recipient_cco__contact_company_office_id',
	rfi_fk_recipient_cco.`contact_company_id` AS 'rfi_fk_recipient_cco__contact_company_id',
	rfi_fk_recipient_cco.`office_nickname` AS 'rfi_fk_recipient_cco__office_nickname',
	rfi_fk_recipient_cco.`address_line_1` AS 'rfi_fk_recipient_cco__address_line_1',
	rfi_fk_recipient_cco.`address_line_2` AS 'rfi_fk_recipient_cco__address_line_2',
	rfi_fk_recipient_cco.`address_line_3` AS 'rfi_fk_recipient_cco__address_line_3',
	rfi_fk_recipient_cco.`address_line_4` AS 'rfi_fk_recipient_cco__address_line_4',
	rfi_fk_recipient_cco.`address_city` AS 'rfi_fk_recipient_cco__address_city',
	rfi_fk_recipient_cco.`address_county` AS 'rfi_fk_recipient_cco__address_county',
	rfi_fk_recipient_cco.`address_state_or_region` AS 'rfi_fk_recipient_cco__address_state_or_region',
	rfi_fk_recipient_cco.`address_postal_code` AS 'rfi_fk_recipient_cco__address_postal_code',
	rfi_fk_recipient_cco.`address_postal_code_extension` AS 'rfi_fk_recipient_cco__address_postal_code_extension',
	rfi_fk_recipient_cco.`address_country` AS 'rfi_fk_recipient_cco__address_country',
	rfi_fk_recipient_cco.`head_quarters_flag` AS 'rfi_fk_recipient_cco__head_quarters_flag',
	rfi_fk_recipient_cco.`address_validated_by_user_flag` AS 'rfi_fk_recipient_cco__address_validated_by_user_flag',
	rfi_fk_recipient_cco.`address_validated_by_web_service_flag` AS 'rfi_fk_recipient_cco__address_validated_by_web_service_flag',
	rfi_fk_recipient_cco.`address_validation_by_web_service_error_flag` AS 'rfi_fk_recipient_cco__address_validation_by_web_service_error_flag',

	rfi_fk_recipient_phone_ccopn.`id` AS 'rfi_fk_recipient_phone_ccopn__contact_company_office_phone_number_id',
	rfi_fk_recipient_phone_ccopn.`contact_company_office_id` AS 'rfi_fk_recipient_phone_ccopn__contact_company_office_id',
	rfi_fk_recipient_phone_ccopn.`phone_number_type_id` AS 'rfi_fk_recipient_phone_ccopn__phone_number_type_id',
	rfi_fk_recipient_phone_ccopn.`country_code` AS 'rfi_fk_recipient_phone_ccopn__country_code',
	rfi_fk_recipient_phone_ccopn.`area_code` AS 'rfi_fk_recipient_phone_ccopn__area_code',
	rfi_fk_recipient_phone_ccopn.`prefix` AS 'rfi_fk_recipient_phone_ccopn__prefix',
	rfi_fk_recipient_phone_ccopn.`number` AS 'rfi_fk_recipient_phone_ccopn__number',
	rfi_fk_recipient_phone_ccopn.`extension` AS 'rfi_fk_recipient_phone_ccopn__extension',
	rfi_fk_recipient_phone_ccopn.`itu` AS 'rfi_fk_recipient_phone_ccopn__itu',

	rfi_fk_recipient_fax_ccopn.`id` AS 'rfi_fk_recipient_fax_ccopn__contact_company_office_phone_number_id',
	rfi_fk_recipient_fax_ccopn.`contact_company_office_id` AS 'rfi_fk_recipient_fax_ccopn__contact_company_office_id',
	rfi_fk_recipient_fax_ccopn.`phone_number_type_id` AS 'rfi_fk_recipient_fax_ccopn__phone_number_type_id',
	rfi_fk_recipient_fax_ccopn.`country_code` AS 'rfi_fk_recipient_fax_ccopn__country_code',
	rfi_fk_recipient_fax_ccopn.`area_code` AS 'rfi_fk_recipient_fax_ccopn__area_code',
	rfi_fk_recipient_fax_ccopn.`prefix` AS 'rfi_fk_recipient_fax_ccopn__prefix',
	rfi_fk_recipient_fax_ccopn.`number` AS 'rfi_fk_recipient_fax_ccopn__number',
	rfi_fk_recipient_fax_ccopn.`extension` AS 'rfi_fk_recipient_fax_ccopn__extension',
	rfi_fk_recipient_fax_ccopn.`itu` AS 'rfi_fk_recipient_fax_ccopn__itu',

	rfi_fk_recipient_c_mobile_cpn.`id` AS 'rfi_fk_recipient_c_mobile_cpn__contact_phone_number_id',
	rfi_fk_recipient_c_mobile_cpn.`contact_id` AS 'rfi_fk_recipient_c_mobile_cpn__contact_id',
	rfi_fk_recipient_c_mobile_cpn.`phone_number_type_id` AS 'rfi_fk_recipient_c_mobile_cpn__phone_number_type_id',
	rfi_fk_recipient_c_mobile_cpn.`country_code` AS 'rfi_fk_recipient_c_mobile_cpn__country_code',
	rfi_fk_recipient_c_mobile_cpn.`area_code` AS 'rfi_fk_recipient_c_mobile_cpn__area_code',
	rfi_fk_recipient_c_mobile_cpn.`prefix` AS 'rfi_fk_recipient_c_mobile_cpn__prefix',
	rfi_fk_recipient_c_mobile_cpn.`number` AS 'rfi_fk_recipient_c_mobile_cpn__number',
	rfi_fk_recipient_c_mobile_cpn.`extension` AS 'rfi_fk_recipient_c_mobile_cpn__extension',
	rfi_fk_recipient_c_mobile_cpn.`itu` AS 'rfi_fk_recipient_c_mobile_cpn__itu',

	rfi_fk_initiator_c.`id` AS 'rfi_fk_initiator_c__contact_id',
	rfi_fk_initiator_c.`user_company_id` AS 'rfi_fk_initiator_c__user_company_id',
	rfi_fk_initiator_c.`user_id` AS 'rfi_fk_initiator_c__user_id',
	rfi_fk_initiator_c.`contact_company_id` AS 'rfi_fk_initiator_c__contact_company_id',
	rfi_fk_initiator_c.`email` AS 'rfi_fk_initiator_c__email',
	rfi_fk_initiator_c.`name_prefix` AS 'rfi_fk_initiator_c__name_prefix',
	rfi_fk_initiator_c.`first_name` AS 'rfi_fk_initiator_c__first_name',
	rfi_fk_initiator_c.`additional_name` AS 'rfi_fk_initiator_c__additional_name',
	rfi_fk_initiator_c.`middle_name` AS 'rfi_fk_initiator_c__middle_name',
	rfi_fk_initiator_c.`last_name` AS 'rfi_fk_initiator_c__last_name',
	rfi_fk_initiator_c.`name_suffix` AS 'rfi_fk_initiator_c__name_suffix',
	rfi_fk_initiator_c.`title` AS 'rfi_fk_initiator_c__title',
	rfi_fk_initiator_c.`vendor_flag` AS 'rfi_fk_initiator_c__vendor_flag',

	rfi_fk_initiator_cco.`id` AS 'rfi_fk_initiator_cco__contact_company_office_id',
	rfi_fk_initiator_cco.`contact_company_id` AS 'rfi_fk_initiator_cco__contact_company_id',
	rfi_fk_initiator_cco.`office_nickname` AS 'rfi_fk_initiator_cco__office_nickname',
	rfi_fk_initiator_cco.`address_line_1` AS 'rfi_fk_initiator_cco__address_line_1',
	rfi_fk_initiator_cco.`address_line_2` AS 'rfi_fk_initiator_cco__address_line_2',
	rfi_fk_initiator_cco.`address_line_3` AS 'rfi_fk_initiator_cco__address_line_3',
	rfi_fk_initiator_cco.`address_line_4` AS 'rfi_fk_initiator_cco__address_line_4',
	rfi_fk_initiator_cco.`address_city` AS 'rfi_fk_initiator_cco__address_city',
	rfi_fk_initiator_cco.`address_county` AS 'rfi_fk_initiator_cco__address_county',
	rfi_fk_initiator_cco.`address_state_or_region` AS 'rfi_fk_initiator_cco__address_state_or_region',
	rfi_fk_initiator_cco.`address_postal_code` AS 'rfi_fk_initiator_cco__address_postal_code',
	rfi_fk_initiator_cco.`address_postal_code_extension` AS 'rfi_fk_initiator_cco__address_postal_code_extension',
	rfi_fk_initiator_cco.`address_country` AS 'rfi_fk_initiator_cco__address_country',
	rfi_fk_initiator_cco.`head_quarters_flag` AS 'rfi_fk_initiator_cco__head_quarters_flag',
	rfi_fk_initiator_cco.`address_validated_by_user_flag` AS 'rfi_fk_initiator_cco__address_validated_by_user_flag',
	rfi_fk_initiator_cco.`address_validated_by_web_service_flag` AS 'rfi_fk_initiator_cco__address_validated_by_web_service_flag',
	rfi_fk_initiator_cco.`address_validation_by_web_service_error_flag` AS 'rfi_fk_initiator_cco__address_validation_by_web_service_error_flag',

	rfi_fk_initiator_phone_ccopn.`id` AS 'rfi_fk_initiator_phone_ccopn__contact_company_office_phone_number_id',
	rfi_fk_initiator_phone_ccopn.`contact_company_office_id` AS 'rfi_fk_initiator_phone_ccopn__contact_company_office_id',
	rfi_fk_initiator_phone_ccopn.`phone_number_type_id` AS 'rfi_fk_initiator_phone_ccopn__phone_number_type_id',
	rfi_fk_initiator_phone_ccopn.`country_code` AS 'rfi_fk_initiator_phone_ccopn__country_code',
	rfi_fk_initiator_phone_ccopn.`area_code` AS 'rfi_fk_initiator_phone_ccopn__area_code',
	rfi_fk_initiator_phone_ccopn.`prefix` AS 'rfi_fk_initiator_phone_ccopn__prefix',
	rfi_fk_initiator_phone_ccopn.`number` AS 'rfi_fk_initiator_phone_ccopn__number',
	rfi_fk_initiator_phone_ccopn.`extension` AS 'rfi_fk_initiator_phone_ccopn__extension',
	rfi_fk_initiator_phone_ccopn.`itu` AS 'rfi_fk_initiator_phone_ccopn__itu',

	rfi_fk_initiator_fax_ccopn.`id` AS 'rfi_fk_initiator_fax_ccopn__contact_company_office_phone_number_id',
	rfi_fk_initiator_fax_ccopn.`contact_company_office_id` AS 'rfi_fk_initiator_fax_ccopn__contact_company_office_id',
	rfi_fk_initiator_fax_ccopn.`phone_number_type_id` AS 'rfi_fk_initiator_fax_ccopn__phone_number_type_id',
	rfi_fk_initiator_fax_ccopn.`country_code` AS 'rfi_fk_initiator_fax_ccopn__country_code',
	rfi_fk_initiator_fax_ccopn.`area_code` AS 'rfi_fk_initiator_fax_ccopn__area_code',
	rfi_fk_initiator_fax_ccopn.`prefix` AS 'rfi_fk_initiator_fax_ccopn__prefix',
	rfi_fk_initiator_fax_ccopn.`number` AS 'rfi_fk_initiator_fax_ccopn__number',
	rfi_fk_initiator_fax_ccopn.`extension` AS 'rfi_fk_initiator_fax_ccopn__extension',
	rfi_fk_initiator_fax_ccopn.`itu` AS 'rfi_fk_initiator_fax_ccopn__itu',

	rfi_fk_initiator_c_mobile_cpn.`id` AS 'rfi_fk_initiator_c_mobile_cpn__contact_phone_number_id',
	rfi_fk_initiator_c_mobile_cpn.`contact_id` AS 'rfi_fk_initiator_c_mobile_cpn__contact_id',
	rfi_fk_initiator_c_mobile_cpn.`phone_number_type_id` AS 'rfi_fk_initiator_c_mobile_cpn__phone_number_type_id',
	rfi_fk_initiator_c_mobile_cpn.`country_code` AS 'rfi_fk_initiator_c_mobile_cpn__country_code',
	rfi_fk_initiator_c_mobile_cpn.`area_code` AS 'rfi_fk_initiator_c_mobile_cpn__area_code',
	rfi_fk_initiator_c_mobile_cpn.`prefix` AS 'rfi_fk_initiator_c_mobile_cpn__prefix',
	rfi_fk_initiator_c_mobile_cpn.`number` AS 'rfi_fk_initiator_c_mobile_cpn__number',
	rfi_fk_initiator_c_mobile_cpn.`extension` AS 'rfi_fk_initiator_c_mobile_cpn__extension',
	rfi_fk_initiator_c_mobile_cpn.`itu` AS 'rfi_fk_initiator_c_mobile_cpn__itu',
	rfi_rs.modified AS res_modified_date, rfi_rs.request_for_information_response AS response_text,
	rfi.*

FROM `requests_for_information` rfi
	{$queryJoin} JOIN `request_for_information_responses` rfi_rs ON rfi.id = rfi_rs.request_for_information_id 
	INNER JOIN `projects` rfi_fk_p ON rfi.`project_id` = rfi_fk_p.`id`
	INNER JOIN `request_for_information_types` rfi_fk_rfit ON rfi.`request_for_information_type_id` = rfi_fk_rfit.`id`
	INNER JOIN `request_for_information_statuses` rfi_fk_rfis ON rfi.`request_for_information_status_id` = rfi_fk_rfis.`id`
	INNER JOIN `request_for_information_priorities` rfi_fk_rfip ON rfi.`request_for_information_priority_id` = rfi_fk_rfip.`id`
	LEFT OUTER JOIN `file_manager_files` rfi_fk_fmfiles ON rfi.`rfi_file_manager_file_id` = rfi_fk_fmfiles.`id`
	LEFT OUTER JOIN `cost_codes` rfi_fk_codes ON rfi.`rfi_cost_code_id` = rfi_fk_codes.`id`
	INNER JOIN `contacts` rfi_fk_creator_c ON rfi.`rfi_creator_contact_id` = rfi_fk_creator_c.`id`
	LEFT OUTER JOIN `contact_company_offices` rfi_fk_creator_cco ON rfi.`rfi_creator_contact_company_office_id` = rfi_fk_creator_cco.`id`
	LEFT OUTER JOIN `contact_company_office_phone_numbers` rfi_fk_creator_phone_ccopn ON rfi.`rfi_creator_phone_contact_company_office_phone_number_id` = rfi_fk_creator_phone_ccopn.`id`
	LEFT OUTER JOIN `contact_company_office_phone_numbers` rfi_fk_creator_fax_ccopn ON rfi.`rfi_creator_fax_contact_company_office_phone_number_id` = rfi_fk_creator_fax_ccopn.`id`
	LEFT OUTER JOIN `contact_phone_numbers` rfi_fk_creator_c_mobile_cpn ON rfi.`rfi_creator_contact_mobile_phone_number_id` = rfi_fk_creator_c_mobile_cpn.`id`
	LEFT OUTER JOIN `contacts` rfi_fk_recipient_c ON rfi.`rfi_recipient_contact_id` = rfi_fk_recipient_c.`id`
	LEFT OUTER JOIN `contact_company_offices` rfi_fk_recipient_cco ON rfi.`rfi_recipient_contact_company_office_id` = rfi_fk_recipient_cco.`id`
	LEFT OUTER JOIN `contact_company_office_phone_numbers` rfi_fk_recipient_phone_ccopn ON rfi.`rfi_recipient_phone_contact_company_office_phone_number_id` = rfi_fk_recipient_phone_ccopn.`id`
	LEFT OUTER JOIN `contact_company_office_phone_numbers` rfi_fk_recipient_fax_ccopn ON rfi.`rfi_recipient_fax_contact_company_office_phone_number_id` = rfi_fk_recipient_fax_ccopn.`id`
	LEFT OUTER JOIN `contact_phone_numbers` rfi_fk_recipient_c_mobile_cpn ON rfi.`rfi_recipient_contact_mobile_phone_number_id` = rfi_fk_recipient_c_mobile_cpn.`id`
	LEFT OUTER JOIN `contacts` rfi_fk_initiator_c ON rfi.`rfi_initiator_contact_id` = rfi_fk_initiator_c.`id`
	LEFT OUTER JOIN `contact_company_offices` rfi_fk_initiator_cco ON rfi.`rfi_initiator_contact_company_office_id` = rfi_fk_initiator_cco.`id`
	LEFT OUTER JOIN `contact_company_office_phone_numbers` rfi_fk_initiator_phone_ccopn ON rfi.`rfi_initiator_phone_contact_company_office_phone_number_id` = rfi_fk_initiator_phone_ccopn.`id`
	LEFT OUTER JOIN `contact_company_office_phone_numbers` rfi_fk_initiator_fax_ccopn ON rfi.`rfi_initiator_fax_contact_company_office_phone_number_id` = rfi_fk_initiator_fax_ccopn.`id`
	LEFT OUTER JOIN `contact_phone_numbers` rfi_fk_initiator_c_mobile_cpn ON rfi.`rfi_initiator_contact_mobile_phone_number_id` = rfi_fk_initiator_c_mobile_cpn.`id`
WHERE rfi.`project_id` = ? {$queryStatus} AND date(rfi.created) BETWEEN '$new_begindate' AND '$enddate' {$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `rfi_sequence_number` ASC, `request_for_information_type_id` ASC, `request_for_information_status_id` ASC, `request_for_information_priority_id` ASC, `rfi_file_manager_file_id` ASC, `rfi_cost_code_id` ASC, `rfi_creator_contact_id` ASC, `rfi_creator_contact_company_office_id` ASC, `rfi_creator_phone_contact_company_office_phone_number_id` ASC, `rfi_creator_fax_contact_company_office_phone_number_id` ASC, `rfi_creator_contact_mobile_phone_number_id` ASC, `rfi_recipient_contact_id` ASC, `rfi_recipient_contact_company_office_id` ASC, `rfi_recipient_phone_contact_company_office_phone_number_id` ASC, `rfi_recipient_fax_contact_company_office_phone_number_id` ASC, `rfi_recipient_contact_mobile_phone_number_id` ASC, `rfi_initiator_contact_id` ASC, `rfi_initiator_contact_company_office_id` ASC, `rfi_initiator_phone_contact_company_office_phone_number_id` ASC, `rfi_initiator_fax_contact_company_office_phone_number_id` ASC, `rfi_initiator_contact_mobile_phone_number_id` ASC, `rfi_title` ASC, `rfi_plan_page_reference` ASC, `rfi_statement` ASC, `created` ASC, `rfi_due_date` ASC, `rfi_closed_date` ASC
		$arrValues = array($project_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrRequestsForInformationByProjectId = array();
		$index=0;
		while ($row = $db->fetch()) {
			$request_for_information_id = $row['id'];
			$requestForInformation = self::instantiateOrm($database, 'RequestForInformation', $row, null, $request_for_information_id);
			/* @var $requestForInformation RequestForInformation */
			$requestForInformation->convertPropertiesToData();

			if (isset($row['project_id'])) {
				$project_id = $row['project_id'];
				$row['rfi_fk_p__id'] = $project_id;
				$project = self::instantiateOrm($database, 'Project', $row, null, $project_id, 'rfi_fk_p__');
				/* @var $project Project */
				$project->convertPropertiesToData();
			} else {
				$project = false;
			}
			$requestForInformation->setProject($project);

			if (isset($row['request_for_information_type_id'])) {
				$request_for_information_type_id = $row['request_for_information_type_id'];
				$row['rfi_fk_rfit__id'] = $request_for_information_type_id;
				$requestForInformationType = self::instantiateOrm($database, 'RequestForInformationType', $row, null, $request_for_information_type_id, 'rfi_fk_rfit__');
				/* @var $requestForInformationType RequestForInformationType */
				$requestForInformationType->convertPropertiesToData();
			} else {
				$requestForInformationType = false;
			}
			$requestForInformation->setRequestForInformationType($requestForInformationType);

			if (isset($row['request_for_information_status_id'])) {
				$request_for_information_status_id = $row['request_for_information_status_id'];
				$row['rfi_fk_rfis__id'] = $request_for_information_status_id;
				$requestForInformationStatus = self::instantiateOrm($database, 'RequestForInformationStatus', $row, null, $request_for_information_status_id, 'rfi_fk_rfis__');
				/* @var $requestForInformationStatus RequestForInformationStatus */
				$requestForInformationStatus->convertPropertiesToData();
			} else {
				$requestForInformationStatus = false;
			}
			$requestForInformation->setRequestForInformationStatus($requestForInformationStatus);

			if (isset($row['request_for_information_priority_id'])) {
				$request_for_information_priority_id = $row['request_for_information_priority_id'];
				$row['rfi_fk_rfip__id'] = $request_for_information_priority_id;
				$requestForInformationPriority = self::instantiateOrm($database, 'RequestForInformationPriority', $row, null, $request_for_information_priority_id, 'rfi_fk_rfip__');
				/* @var $requestForInformationPriority RequestForInformationPriority */
				$requestForInformationPriority->convertPropertiesToData();
			} else {
				$requestForInformationPriority = false;
			}
			$requestForInformation->setRequestForInformationPriority($requestForInformationPriority);
			$requestForInformation['response_text']=$row['response_text'];
			$requestForInformation['response_Date']=$row['res_modified_date'];
		// if (isset($row['response_text'])) {
		// 		$response_text = $row['response_text'];
		// 		$row['response_text'] = $response_text;
		// 		$requestForInformationResponse = self::instantiateOrm($database, 'ResponseText', $row, null, $response_text, 'rfi_fk_res__');
		// 		/* @var $requestForInformationPriority RequestForInformationPriority */
		// 		$requestForInformationResponse->convertPropertiesToData();
		// 	} else {
		// 		$requestForInformationResponse = false;
		// 	}

			if (isset($row['rfi_file_manager_file_id'])) {
				$rfi_file_manager_file_id = $row['rfi_file_manager_file_id'];
				$row['rfi_fk_fmfiles__id'] = $rfi_file_manager_file_id;
				$rfiFileManagerFile = self::instantiateOrm($database, 'FileManagerFile', $row, null, $rfi_file_manager_file_id, 'rfi_fk_fmfiles__');
				/* @var $rfiFileManagerFile FileManagerFile */
				$rfiFileManagerFile->convertPropertiesToData();
			} else {
				$rfiFileManagerFile = false;
			}
			$requestForInformation->setRfiFileManagerFile($rfiFileManagerFile);

			if (isset($row['rfi_cost_code_id'])) {
				$rfi_cost_code_id = $row['rfi_cost_code_id'];
				$row['rfi_fk_codes__id'] = $rfi_cost_code_id;
				$rfiCostCode = self::instantiateOrm($database, 'CostCode', $row, null, $rfi_cost_code_id, 'rfi_fk_codes__');
				/* @var $rfiCostCode CostCode */
				$rfiCostCode->convertPropertiesToData();
			} else {
				$rfiCostCode = false;
			}
			$requestForInformation->setRfiCostCode($rfiCostCode);

			if (isset($row['rfi_creator_contact_id'])) {
				$rfi_creator_contact_id = $row['rfi_creator_contact_id'];
				$row['rfi_fk_creator_c__id'] = $rfi_creator_contact_id;
				$rfiCreatorContact = self::instantiateOrm($database, 'Contact', $row, null, $rfi_creator_contact_id, 'rfi_fk_creator_c__');
				/* @var $rfiCreatorContact Contact */
				$rfiCreatorContact->convertPropertiesToData();
			} else {
				$rfiCreatorContact = false;
			}
			$requestForInformation->setRfiCreatorContact($rfiCreatorContact);

			if (isset($row['rfi_creator_contact_company_office_id'])) {
				$rfi_creator_contact_company_office_id = $row['rfi_creator_contact_company_office_id'];
				$row['rfi_fk_creator_cco__id'] = $rfi_creator_contact_company_office_id;
				$rfiCreatorContactCompanyOffice = self::instantiateOrm($database, 'ContactCompanyOffice', $row, null, $rfi_creator_contact_company_office_id, 'rfi_fk_creator_cco__');
				/* @var $rfiCreatorContactCompanyOffice ContactCompanyOffice */
				$rfiCreatorContactCompanyOffice->convertPropertiesToData();
			} else {
				$rfiCreatorContactCompanyOffice = false;
			}
			$requestForInformation->setRfiCreatorContactCompanyOffice($rfiCreatorContactCompanyOffice);

			if (isset($row['rfi_creator_phone_contact_company_office_phone_number_id'])) {
				$rfi_creator_phone_contact_company_office_phone_number_id = $row['rfi_creator_phone_contact_company_office_phone_number_id'];
				$row['rfi_fk_creator_phone_ccopn__id'] = $rfi_creator_phone_contact_company_office_phone_number_id;
				$rfiCreatorPhoneContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $rfi_creator_phone_contact_company_office_phone_number_id, 'rfi_fk_creator_phone_ccopn__');
				/* @var $rfiCreatorPhoneContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$rfiCreatorPhoneContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$rfiCreatorPhoneContactCompanyOfficePhoneNumber = false;
			}
			$requestForInformation->setRfiCreatorPhoneContactCompanyOfficePhoneNumber($rfiCreatorPhoneContactCompanyOfficePhoneNumber);

			if (isset($row['rfi_creator_fax_contact_company_office_phone_number_id'])) {
				$rfi_creator_fax_contact_company_office_phone_number_id = $row['rfi_creator_fax_contact_company_office_phone_number_id'];
				$row['rfi_fk_creator_fax_ccopn__id'] = $rfi_creator_fax_contact_company_office_phone_number_id;
				$rfiCreatorFaxContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $rfi_creator_fax_contact_company_office_phone_number_id, 'rfi_fk_creator_fax_ccopn__');
				/* @var $rfiCreatorFaxContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$rfiCreatorFaxContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$rfiCreatorFaxContactCompanyOfficePhoneNumber = false;
			}
			$requestForInformation->setRfiCreatorFaxContactCompanyOfficePhoneNumber($rfiCreatorFaxContactCompanyOfficePhoneNumber);

			if (isset($row['rfi_creator_contact_mobile_phone_number_id'])) {
				$rfi_creator_contact_mobile_phone_number_id = $row['rfi_creator_contact_mobile_phone_number_id'];
				$row['rfi_fk_creator_c_mobile_cpn__id'] = $rfi_creator_contact_mobile_phone_number_id;
				$rfiCreatorContactMobilePhoneNumber = self::instantiateOrm($database, 'ContactPhoneNumber', $row, null, $rfi_creator_contact_mobile_phone_number_id, 'rfi_fk_creator_c_mobile_cpn__');
				/* @var $rfiCreatorContactMobilePhoneNumber ContactPhoneNumber */
				$rfiCreatorContactMobilePhoneNumber->convertPropertiesToData();
			} else {
				$rfiCreatorContactMobilePhoneNumber = false;
			}
			$requestForInformation->setRfiCreatorContactMobilePhoneNumber($rfiCreatorContactMobilePhoneNumber);

			if (isset($row['rfi_recipient_contact_id'])) {
				$rfi_recipient_contact_id = $row['rfi_recipient_contact_id'];
				$row['rfi_fk_recipient_c__id'] = $rfi_recipient_contact_id;
				$rfiRecipientContact = self::instantiateOrm($database, 'Contact', $row, null, $rfi_recipient_contact_id, 'rfi_fk_recipient_c__');
				/* @var $rfiRecipientContact Contact */
				$rfiRecipientContact->convertPropertiesToData();
			} else {
				$rfiRecipientContact = false;
			}
			$requestForInformation->setRfiRecipientContact($rfiRecipientContact);

			if (isset($row['rfi_recipient_contact_company_office_id'])) {
				$rfi_recipient_contact_company_office_id = $row['rfi_recipient_contact_company_office_id'];
				$row['rfi_fk_recipient_cco__id'] = $rfi_recipient_contact_company_office_id;
				$rfiRecipientContactCompanyOffice = self::instantiateOrm($database, 'ContactCompanyOffice', $row, null, $rfi_recipient_contact_company_office_id, 'rfi_fk_recipient_cco__');
				/* @var $rfiRecipientContactCompanyOffice ContactCompanyOffice */
				$rfiRecipientContactCompanyOffice->convertPropertiesToData();
			} else {
				$rfiRecipientContactCompanyOffice = false;
			}
			$requestForInformation->setRfiRecipientContactCompanyOffice($rfiRecipientContactCompanyOffice);

			if (isset($row['rfi_recipient_phone_contact_company_office_phone_number_id'])) {
				$rfi_recipient_phone_contact_company_office_phone_number_id = $row['rfi_recipient_phone_contact_company_office_phone_number_id'];
				$row['rfi_fk_recipient_phone_ccopn__id'] = $rfi_recipient_phone_contact_company_office_phone_number_id;
				$rfiRecipientPhoneContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $rfi_recipient_phone_contact_company_office_phone_number_id, 'rfi_fk_recipient_phone_ccopn__');
				/* @var $rfiRecipientPhoneContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$rfiRecipientPhoneContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$rfiRecipientPhoneContactCompanyOfficePhoneNumber = false;
			}
			$requestForInformation->setRfiRecipientPhoneContactCompanyOfficePhoneNumber($rfiRecipientPhoneContactCompanyOfficePhoneNumber);

			if (isset($row['rfi_recipient_fax_contact_company_office_phone_number_id'])) {
				$rfi_recipient_fax_contact_company_office_phone_number_id = $row['rfi_recipient_fax_contact_company_office_phone_number_id'];
				$row['rfi_fk_recipient_fax_ccopn__id'] = $rfi_recipient_fax_contact_company_office_phone_number_id;
				$rfiRecipientFaxContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $rfi_recipient_fax_contact_company_office_phone_number_id, 'rfi_fk_recipient_fax_ccopn__');
				/* @var $rfiRecipientFaxContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$rfiRecipientFaxContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$rfiRecipientFaxContactCompanyOfficePhoneNumber = false;
			}
			$requestForInformation->setRfiRecipientFaxContactCompanyOfficePhoneNumber($rfiRecipientFaxContactCompanyOfficePhoneNumber);

			if (isset($row['rfi_recipient_contact_mobile_phone_number_id'])) {
				$rfi_recipient_contact_mobile_phone_number_id = $row['rfi_recipient_contact_mobile_phone_number_id'];
				$row['rfi_fk_recipient_c_mobile_cpn__id'] = $rfi_recipient_contact_mobile_phone_number_id;
				$rfiRecipientContactMobilePhoneNumber = self::instantiateOrm($database, 'ContactPhoneNumber', $row, null, $rfi_recipient_contact_mobile_phone_number_id, 'rfi_fk_recipient_c_mobile_cpn__');
				/* @var $rfiRecipientContactMobilePhoneNumber ContactPhoneNumber */
				$rfiRecipientContactMobilePhoneNumber->convertPropertiesToData();
			} else {
				$rfiRecipientContactMobilePhoneNumber = false;
			}
			$requestForInformation->setRfiRecipientContactMobilePhoneNumber($rfiRecipientContactMobilePhoneNumber);

			if (isset($row['rfi_initiator_contact_id'])) {
				$rfi_initiator_contact_id = $row['rfi_initiator_contact_id'];
				$row['rfi_fk_initiator_c__id'] = $rfi_initiator_contact_id;
				$rfiInitiatorContact = self::instantiateOrm($database, 'Contact', $row, null, $rfi_initiator_contact_id, 'rfi_fk_initiator_c__');
				/* @var $rfiInitiatorContact Contact */
				$rfiInitiatorContact->convertPropertiesToData();
			} else {
				$rfiInitiatorContact = false;
			}
			$requestForInformation->setRfiInitiatorContact($rfiInitiatorContact);

			if (isset($row['rfi_initiator_contact_company_office_id'])) {
				$rfi_initiator_contact_company_office_id = $row['rfi_initiator_contact_company_office_id'];
				$row['rfi_fk_initiator_cco__id'] = $rfi_initiator_contact_company_office_id;
				$rfiInitiatorContactCompanyOffice = self::instantiateOrm($database, 'ContactCompanyOffice', $row, null, $rfi_initiator_contact_company_office_id, 'rfi_fk_initiator_cco__');
				/* @var $rfiInitiatorContactCompanyOffice ContactCompanyOffice */
				$rfiInitiatorContactCompanyOffice->convertPropertiesToData();
			} else {
				$rfiInitiatorContactCompanyOffice = false;
			}
			$requestForInformation->setRfiInitiatorContactCompanyOffice($rfiInitiatorContactCompanyOffice);

			if (isset($row['rfi_initiator_phone_contact_company_office_phone_number_id'])) {
				$rfi_initiator_phone_contact_company_office_phone_number_id = $row['rfi_initiator_phone_contact_company_office_phone_number_id'];
				$row['rfi_fk_initiator_phone_ccopn__id'] = $rfi_initiator_phone_contact_company_office_phone_number_id;
				$rfiInitiatorPhoneContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $rfi_initiator_phone_contact_company_office_phone_number_id, 'rfi_fk_initiator_phone_ccopn__');
				/* @var $rfiInitiatorPhoneContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$rfiInitiatorPhoneContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$rfiInitiatorPhoneContactCompanyOfficePhoneNumber = false;
			}
			$requestForInformation->setRfiInitiatorPhoneContactCompanyOfficePhoneNumber($rfiInitiatorPhoneContactCompanyOfficePhoneNumber);

			if (isset($row['rfi_initiator_fax_contact_company_office_phone_number_id'])) {
				$rfi_initiator_fax_contact_company_office_phone_number_id = $row['rfi_initiator_fax_contact_company_office_phone_number_id'];
				$row['rfi_fk_initiator_fax_ccopn__id'] = $rfi_initiator_fax_contact_company_office_phone_number_id;
				$rfiInitiatorFaxContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $rfi_initiator_fax_contact_company_office_phone_number_id, 'rfi_fk_initiator_fax_ccopn__');
				/* @var $rfiInitiatorFaxContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$rfiInitiatorFaxContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$rfiInitiatorFaxContactCompanyOfficePhoneNumber = false;
			}
			$requestForInformation->setRfiInitiatorFaxContactCompanyOfficePhoneNumber($rfiInitiatorFaxContactCompanyOfficePhoneNumber);

			if (isset($row['rfi_initiator_contact_mobile_phone_number_id'])) {
				$rfi_initiator_contact_mobile_phone_number_id = $row['rfi_initiator_contact_mobile_phone_number_id'];
				$row['rfi_fk_initiator_c_mobile_cpn__id'] = $rfi_initiator_contact_mobile_phone_number_id;
				$rfiInitiatorContactMobilePhoneNumber = self::instantiateOrm($database, 'ContactPhoneNumber', $row, null, $rfi_initiator_contact_mobile_phone_number_id, 'rfi_fk_initiator_c_mobile_cpn__');
				/* @var $rfiInitiatorContactMobilePhoneNumber ContactPhoneNumber */
				$rfiInitiatorContactMobilePhoneNumber->convertPropertiesToData();
			} else {
				$rfiInitiatorContactMobilePhoneNumber = false;
			}
			$requestForInformation->setRfiInitiatorContactMobilePhoneNumber($rfiInitiatorContactMobilePhoneNumber);

			$arrRequestsForInformationByProjectId[$request_for_information_id] = $requestForInformation;
		
			// $arrRequestsForInformationByProjectId[$index] = $requestForInformation;
			$index++;
		}

		$db->free_result();

		// self::$_arrRequestsForInformationByProjectId = $arrRequestsForInformationByProjectId;

		return $arrRequestsForInformationByProjectId;
	}
	/**
	 * Load by constraint `requests_for_information_fk_rfit` foreign key (`request_for_information_type_id`) references `request_for_information_types` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $request_for_information_type_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadRequestsForInformationByRequestForInformationTypeId($database, $request_for_information_type_id, Input $options=null)
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
			self::$_arrRequestsForInformationByRequestForInformationTypeId = null;
		}

		$arrRequestsForInformationByRequestForInformationTypeId = self::$_arrRequestsForInformationByRequestForInformationTypeId;
		if (isset($arrRequestsForInformationByRequestForInformationTypeId) && !empty($arrRequestsForInformationByRequestForInformationTypeId)) {
			return $arrRequestsForInformationByRequestForInformationTypeId;
		}

		$request_for_information_type_id = (int) $request_for_information_type_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `rfi_sequence_number` ASC, `request_for_information_type_id` ASC, `request_for_information_status_id` ASC, `request_for_information_priority_id` ASC, `rfi_file_manager_file_id` ASC, `rfi_cost_code_id` ASC, `rfi_creator_contact_id` ASC, `rfi_creator_contact_company_office_id` ASC, `rfi_creator_phone_contact_company_office_phone_number_id` ASC, `rfi_creator_fax_contact_company_office_phone_number_id` ASC, `rfi_creator_contact_mobile_phone_number_id` ASC, `rfi_recipient_contact_id` ASC, `rfi_recipient_contact_company_office_id` ASC, `rfi_recipient_phone_contact_company_office_phone_number_id` ASC, `rfi_recipient_fax_contact_company_office_phone_number_id` ASC, `rfi_recipient_contact_mobile_phone_number_id` ASC, `rfi_initiator_contact_id` ASC, `rfi_initiator_contact_company_office_id` ASC, `rfi_initiator_phone_contact_company_office_phone_number_id` ASC, `rfi_initiator_fax_contact_company_office_phone_number_id` ASC, `rfi_initiator_contact_mobile_phone_number_id` ASC, `rfi_title` ASC, `rfi_plan_page_reference` ASC, `rfi_statement` ASC, `created` ASC, `rfi_due_date` ASC, `rfi_closed_date` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpRequestForInformation = new RequestForInformation($database);
			$sqlOrderByColumns = $tmpRequestForInformation->constructSqlOrderByColumns($arrOrderByAttributes);

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
	rfi.*

FROM `requests_for_information` rfi
WHERE rfi.`request_for_information_type_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `rfi_sequence_number` ASC, `request_for_information_type_id` ASC, `request_for_information_status_id` ASC, `request_for_information_priority_id` ASC, `rfi_file_manager_file_id` ASC, `rfi_cost_code_id` ASC, `rfi_creator_contact_id` ASC, `rfi_creator_contact_company_office_id` ASC, `rfi_creator_phone_contact_company_office_phone_number_id` ASC, `rfi_creator_fax_contact_company_office_phone_number_id` ASC, `rfi_creator_contact_mobile_phone_number_id` ASC, `rfi_recipient_contact_id` ASC, `rfi_recipient_contact_company_office_id` ASC, `rfi_recipient_phone_contact_company_office_phone_number_id` ASC, `rfi_recipient_fax_contact_company_office_phone_number_id` ASC, `rfi_recipient_contact_mobile_phone_number_id` ASC, `rfi_initiator_contact_id` ASC, `rfi_initiator_contact_company_office_id` ASC, `rfi_initiator_phone_contact_company_office_phone_number_id` ASC, `rfi_initiator_fax_contact_company_office_phone_number_id` ASC, `rfi_initiator_contact_mobile_phone_number_id` ASC, `rfi_title` ASC, `rfi_plan_page_reference` ASC, `rfi_statement` ASC, `created` ASC, `rfi_due_date` ASC, `rfi_closed_date` ASC
		$arrValues = array($request_for_information_type_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrRequestsForInformationByRequestForInformationTypeId = array();
		while ($row = $db->fetch()) {
			$request_for_information_id = $row['id'];
			$requestForInformation = self::instantiateOrm($database, 'RequestForInformation', $row, null, $request_for_information_id);
			/* @var $requestForInformation RequestForInformation */
			$arrRequestsForInformationByRequestForInformationTypeId[$request_for_information_id] = $requestForInformation;
		}

		$db->free_result();

		self::$_arrRequestsForInformationByRequestForInformationTypeId = $arrRequestsForInformationByRequestForInformationTypeId;

		return $arrRequestsForInformationByRequestForInformationTypeId;
	}

	/**
	 * Load by constraint `requests_for_information_fk_rfis` foreign key (`request_for_information_status_id`) references `request_for_information_statuses` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $request_for_information_status_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadRequestsForInformationByRequestForInformationStatusId($database, $request_for_information_status_id, Input $options=null)
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
			self::$_arrRequestsForInformationByRequestForInformationStatusId = null;
		}

		$arrRequestsForInformationByRequestForInformationStatusId = self::$_arrRequestsForInformationByRequestForInformationStatusId;
		if (isset($arrRequestsForInformationByRequestForInformationStatusId) && !empty($arrRequestsForInformationByRequestForInformationStatusId)) {
			return $arrRequestsForInformationByRequestForInformationStatusId;
		}

		$request_for_information_status_id = (int) $request_for_information_status_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `rfi_sequence_number` ASC, `request_for_information_type_id` ASC, `request_for_information_status_id` ASC, `request_for_information_priority_id` ASC, `rfi_file_manager_file_id` ASC, `rfi_cost_code_id` ASC, `rfi_creator_contact_id` ASC, `rfi_creator_contact_company_office_id` ASC, `rfi_creator_phone_contact_company_office_phone_number_id` ASC, `rfi_creator_fax_contact_company_office_phone_number_id` ASC, `rfi_creator_contact_mobile_phone_number_id` ASC, `rfi_recipient_contact_id` ASC, `rfi_recipient_contact_company_office_id` ASC, `rfi_recipient_phone_contact_company_office_phone_number_id` ASC, `rfi_recipient_fax_contact_company_office_phone_number_id` ASC, `rfi_recipient_contact_mobile_phone_number_id` ASC, `rfi_initiator_contact_id` ASC, `rfi_initiator_contact_company_office_id` ASC, `rfi_initiator_phone_contact_company_office_phone_number_id` ASC, `rfi_initiator_fax_contact_company_office_phone_number_id` ASC, `rfi_initiator_contact_mobile_phone_number_id` ASC, `rfi_title` ASC, `rfi_plan_page_reference` ASC, `rfi_statement` ASC, `created` ASC, `rfi_due_date` ASC, `rfi_closed_date` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpRequestForInformation = new RequestForInformation($database);
			$sqlOrderByColumns = $tmpRequestForInformation->constructSqlOrderByColumns($arrOrderByAttributes);

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
	rfi.*

FROM `requests_for_information` rfi
WHERE rfi.`request_for_information_status_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `rfi_sequence_number` ASC, `request_for_information_type_id` ASC, `request_for_information_status_id` ASC, `request_for_information_priority_id` ASC, `rfi_file_manager_file_id` ASC, `rfi_cost_code_id` ASC, `rfi_creator_contact_id` ASC, `rfi_creator_contact_company_office_id` ASC, `rfi_creator_phone_contact_company_office_phone_number_id` ASC, `rfi_creator_fax_contact_company_office_phone_number_id` ASC, `rfi_creator_contact_mobile_phone_number_id` ASC, `rfi_recipient_contact_id` ASC, `rfi_recipient_contact_company_office_id` ASC, `rfi_recipient_phone_contact_company_office_phone_number_id` ASC, `rfi_recipient_fax_contact_company_office_phone_number_id` ASC, `rfi_recipient_contact_mobile_phone_number_id` ASC, `rfi_initiator_contact_id` ASC, `rfi_initiator_contact_company_office_id` ASC, `rfi_initiator_phone_contact_company_office_phone_number_id` ASC, `rfi_initiator_fax_contact_company_office_phone_number_id` ASC, `rfi_initiator_contact_mobile_phone_number_id` ASC, `rfi_title` ASC, `rfi_plan_page_reference` ASC, `rfi_statement` ASC, `created` ASC, `rfi_due_date` ASC, `rfi_closed_date` ASC
		$arrValues = array($request_for_information_status_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrRequestsForInformationByRequestForInformationStatusId = array();
		while ($row = $db->fetch()) {
			$request_for_information_id = $row['id'];
			$requestForInformation = self::instantiateOrm($database, 'RequestForInformation', $row, null, $request_for_information_id);
			/* @var $requestForInformation RequestForInformation */
			$arrRequestsForInformationByRequestForInformationStatusId[$request_for_information_id] = $requestForInformation;
		}

		$db->free_result();

		self::$_arrRequestsForInformationByRequestForInformationStatusId = $arrRequestsForInformationByRequestForInformationStatusId;

		return $arrRequestsForInformationByRequestForInformationStatusId;
	}

	/**
	 * Load by constraint `requests_for_information_fk_rfip` foreign key (`request_for_information_priority_id`) references `request_for_information_priorities` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $request_for_information_priority_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadRequestsForInformationByRequestForInformationPriorityId($database, $request_for_information_priority_id, Input $options=null)
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
			self::$_arrRequestsForInformationByRequestForInformationPriorityId = null;
		}

		$arrRequestsForInformationByRequestForInformationPriorityId = self::$_arrRequestsForInformationByRequestForInformationPriorityId;
		if (isset($arrRequestsForInformationByRequestForInformationPriorityId) && !empty($arrRequestsForInformationByRequestForInformationPriorityId)) {
			return $arrRequestsForInformationByRequestForInformationPriorityId;
		}

		$request_for_information_priority_id = (int) $request_for_information_priority_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `rfi_sequence_number` ASC, `request_for_information_type_id` ASC, `request_for_information_status_id` ASC, `request_for_information_priority_id` ASC, `rfi_file_manager_file_id` ASC, `rfi_cost_code_id` ASC, `rfi_creator_contact_id` ASC, `rfi_creator_contact_company_office_id` ASC, `rfi_creator_phone_contact_company_office_phone_number_id` ASC, `rfi_creator_fax_contact_company_office_phone_number_id` ASC, `rfi_creator_contact_mobile_phone_number_id` ASC, `rfi_recipient_contact_id` ASC, `rfi_recipient_contact_company_office_id` ASC, `rfi_recipient_phone_contact_company_office_phone_number_id` ASC, `rfi_recipient_fax_contact_company_office_phone_number_id` ASC, `rfi_recipient_contact_mobile_phone_number_id` ASC, `rfi_initiator_contact_id` ASC, `rfi_initiator_contact_company_office_id` ASC, `rfi_initiator_phone_contact_company_office_phone_number_id` ASC, `rfi_initiator_fax_contact_company_office_phone_number_id` ASC, `rfi_initiator_contact_mobile_phone_number_id` ASC, `rfi_title` ASC, `rfi_plan_page_reference` ASC, `rfi_statement` ASC, `created` ASC, `rfi_due_date` ASC, `rfi_closed_date` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpRequestForInformation = new RequestForInformation($database);
			$sqlOrderByColumns = $tmpRequestForInformation->constructSqlOrderByColumns($arrOrderByAttributes);

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
	rfi.*

FROM `requests_for_information` rfi
WHERE rfi.`request_for_information_priority_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `rfi_sequence_number` ASC, `request_for_information_type_id` ASC, `request_for_information_status_id` ASC, `request_for_information_priority_id` ASC, `rfi_file_manager_file_id` ASC, `rfi_cost_code_id` ASC, `rfi_creator_contact_id` ASC, `rfi_creator_contact_company_office_id` ASC, `rfi_creator_phone_contact_company_office_phone_number_id` ASC, `rfi_creator_fax_contact_company_office_phone_number_id` ASC, `rfi_creator_contact_mobile_phone_number_id` ASC, `rfi_recipient_contact_id` ASC, `rfi_recipient_contact_company_office_id` ASC, `rfi_recipient_phone_contact_company_office_phone_number_id` ASC, `rfi_recipient_fax_contact_company_office_phone_number_id` ASC, `rfi_recipient_contact_mobile_phone_number_id` ASC, `rfi_initiator_contact_id` ASC, `rfi_initiator_contact_company_office_id` ASC, `rfi_initiator_phone_contact_company_office_phone_number_id` ASC, `rfi_initiator_fax_contact_company_office_phone_number_id` ASC, `rfi_initiator_contact_mobile_phone_number_id` ASC, `rfi_title` ASC, `rfi_plan_page_reference` ASC, `rfi_statement` ASC, `created` ASC, `rfi_due_date` ASC, `rfi_closed_date` ASC
		$arrValues = array($request_for_information_priority_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrRequestsForInformationByRequestForInformationPriorityId = array();
		while ($row = $db->fetch()) {
			$request_for_information_id = $row['id'];
			$requestForInformation = self::instantiateOrm($database, 'RequestForInformation', $row, null, $request_for_information_id);
			/* @var $requestForInformation RequestForInformation */
			$arrRequestsForInformationByRequestForInformationPriorityId[$request_for_information_id] = $requestForInformation;
		}

		$db->free_result();

		self::$_arrRequestsForInformationByRequestForInformationPriorityId = $arrRequestsForInformationByRequestForInformationPriorityId;

		return $arrRequestsForInformationByRequestForInformationPriorityId;
	}

	/**
	 * Load by constraint `requests_for_information_fk_fmfiles` foreign key (`rfi_file_manager_file_id`) references `file_manager_files` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $rfi_file_manager_file_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadRequestsForInformationByRfiFileManagerFileId($database, $rfi_file_manager_file_id, Input $options=null)
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
			self::$_arrRequestsForInformationByRfiFileManagerFileId = null;
		}

		$arrRequestsForInformationByRfiFileManagerFileId = self::$_arrRequestsForInformationByRfiFileManagerFileId;
		if (isset($arrRequestsForInformationByRfiFileManagerFileId) && !empty($arrRequestsForInformationByRfiFileManagerFileId)) {
			return $arrRequestsForInformationByRfiFileManagerFileId;
		}

		$rfi_file_manager_file_id = (int) $rfi_file_manager_file_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `rfi_sequence_number` ASC, `request_for_information_type_id` ASC, `request_for_information_status_id` ASC, `request_for_information_priority_id` ASC, `rfi_file_manager_file_id` ASC, `rfi_cost_code_id` ASC, `rfi_creator_contact_id` ASC, `rfi_creator_contact_company_office_id` ASC, `rfi_creator_phone_contact_company_office_phone_number_id` ASC, `rfi_creator_fax_contact_company_office_phone_number_id` ASC, `rfi_creator_contact_mobile_phone_number_id` ASC, `rfi_recipient_contact_id` ASC, `rfi_recipient_contact_company_office_id` ASC, `rfi_recipient_phone_contact_company_office_phone_number_id` ASC, `rfi_recipient_fax_contact_company_office_phone_number_id` ASC, `rfi_recipient_contact_mobile_phone_number_id` ASC, `rfi_initiator_contact_id` ASC, `rfi_initiator_contact_company_office_id` ASC, `rfi_initiator_phone_contact_company_office_phone_number_id` ASC, `rfi_initiator_fax_contact_company_office_phone_number_id` ASC, `rfi_initiator_contact_mobile_phone_number_id` ASC, `rfi_title` ASC, `rfi_plan_page_reference` ASC, `rfi_statement` ASC, `created` ASC, `rfi_due_date` ASC, `rfi_closed_date` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpRequestForInformation = new RequestForInformation($database);
			$sqlOrderByColumns = $tmpRequestForInformation->constructSqlOrderByColumns($arrOrderByAttributes);

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
	rfi.*

FROM `requests_for_information` rfi
WHERE rfi.`rfi_file_manager_file_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `rfi_sequence_number` ASC, `request_for_information_type_id` ASC, `request_for_information_status_id` ASC, `request_for_information_priority_id` ASC, `rfi_file_manager_file_id` ASC, `rfi_cost_code_id` ASC, `rfi_creator_contact_id` ASC, `rfi_creator_contact_company_office_id` ASC, `rfi_creator_phone_contact_company_office_phone_number_id` ASC, `rfi_creator_fax_contact_company_office_phone_number_id` ASC, `rfi_creator_contact_mobile_phone_number_id` ASC, `rfi_recipient_contact_id` ASC, `rfi_recipient_contact_company_office_id` ASC, `rfi_recipient_phone_contact_company_office_phone_number_id` ASC, `rfi_recipient_fax_contact_company_office_phone_number_id` ASC, `rfi_recipient_contact_mobile_phone_number_id` ASC, `rfi_initiator_contact_id` ASC, `rfi_initiator_contact_company_office_id` ASC, `rfi_initiator_phone_contact_company_office_phone_number_id` ASC, `rfi_initiator_fax_contact_company_office_phone_number_id` ASC, `rfi_initiator_contact_mobile_phone_number_id` ASC, `rfi_title` ASC, `rfi_plan_page_reference` ASC, `rfi_statement` ASC, `created` ASC, `rfi_due_date` ASC, `rfi_closed_date` ASC
		$arrValues = array($rfi_file_manager_file_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrRequestsForInformationByRfiFileManagerFileId = array();
		while ($row = $db->fetch()) {
			$request_for_information_id = $row['id'];
			$requestForInformation = self::instantiateOrm($database, 'RequestForInformation', $row, null, $request_for_information_id);
			/* @var $requestForInformation RequestForInformation */
			$arrRequestsForInformationByRfiFileManagerFileId[$request_for_information_id] = $requestForInformation;
		}

		$db->free_result();

		self::$_arrRequestsForInformationByRfiFileManagerFileId = $arrRequestsForInformationByRfiFileManagerFileId;

		return $arrRequestsForInformationByRfiFileManagerFileId;
	}

	/**
	 * Load by constraint `requests_for_information_fk_codes` foreign key (`rfi_cost_code_id`) references `cost_codes` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $rfi_cost_code_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadRequestsForInformationByRfiCostCodeId($database, $rfi_cost_code_id, Input $options=null)
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
			self::$_arrRequestsForInformationByRfiCostCodeId = null;
		}

		$arrRequestsForInformationByRfiCostCodeId = self::$_arrRequestsForInformationByRfiCostCodeId;
		if (isset($arrRequestsForInformationByRfiCostCodeId) && !empty($arrRequestsForInformationByRfiCostCodeId)) {
			return $arrRequestsForInformationByRfiCostCodeId;
		}

		$rfi_cost_code_id = (int) $rfi_cost_code_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `rfi_sequence_number` ASC, `request_for_information_type_id` ASC, `request_for_information_status_id` ASC, `request_for_information_priority_id` ASC, `rfi_file_manager_file_id` ASC, `rfi_cost_code_id` ASC, `rfi_creator_contact_id` ASC, `rfi_creator_contact_company_office_id` ASC, `rfi_creator_phone_contact_company_office_phone_number_id` ASC, `rfi_creator_fax_contact_company_office_phone_number_id` ASC, `rfi_creator_contact_mobile_phone_number_id` ASC, `rfi_recipient_contact_id` ASC, `rfi_recipient_contact_company_office_id` ASC, `rfi_recipient_phone_contact_company_office_phone_number_id` ASC, `rfi_recipient_fax_contact_company_office_phone_number_id` ASC, `rfi_recipient_contact_mobile_phone_number_id` ASC, `rfi_initiator_contact_id` ASC, `rfi_initiator_contact_company_office_id` ASC, `rfi_initiator_phone_contact_company_office_phone_number_id` ASC, `rfi_initiator_fax_contact_company_office_phone_number_id` ASC, `rfi_initiator_contact_mobile_phone_number_id` ASC, `rfi_title` ASC, `rfi_plan_page_reference` ASC, `rfi_statement` ASC, `created` ASC, `rfi_due_date` ASC, `rfi_closed_date` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpRequestForInformation = new RequestForInformation($database);
			$sqlOrderByColumns = $tmpRequestForInformation->constructSqlOrderByColumns($arrOrderByAttributes);

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
	rfi.*

FROM `requests_for_information` rfi
WHERE rfi.`rfi_cost_code_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `rfi_sequence_number` ASC, `request_for_information_type_id` ASC, `request_for_information_status_id` ASC, `request_for_information_priority_id` ASC, `rfi_file_manager_file_id` ASC, `rfi_cost_code_id` ASC, `rfi_creator_contact_id` ASC, `rfi_creator_contact_company_office_id` ASC, `rfi_creator_phone_contact_company_office_phone_number_id` ASC, `rfi_creator_fax_contact_company_office_phone_number_id` ASC, `rfi_creator_contact_mobile_phone_number_id` ASC, `rfi_recipient_contact_id` ASC, `rfi_recipient_contact_company_office_id` ASC, `rfi_recipient_phone_contact_company_office_phone_number_id` ASC, `rfi_recipient_fax_contact_company_office_phone_number_id` ASC, `rfi_recipient_contact_mobile_phone_number_id` ASC, `rfi_initiator_contact_id` ASC, `rfi_initiator_contact_company_office_id` ASC, `rfi_initiator_phone_contact_company_office_phone_number_id` ASC, `rfi_initiator_fax_contact_company_office_phone_number_id` ASC, `rfi_initiator_contact_mobile_phone_number_id` ASC, `rfi_title` ASC, `rfi_plan_page_reference` ASC, `rfi_statement` ASC, `created` ASC, `rfi_due_date` ASC, `rfi_closed_date` ASC
		$arrValues = array($rfi_cost_code_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrRequestsForInformationByRfiCostCodeId = array();
		while ($row = $db->fetch()) {
			$request_for_information_id = $row['id'];
			$requestForInformation = self::instantiateOrm($database, 'RequestForInformation', $row, null, $request_for_information_id);
			/* @var $requestForInformation RequestForInformation */
			$arrRequestsForInformationByRfiCostCodeId[$request_for_information_id] = $requestForInformation;
		}

		$db->free_result();

		self::$_arrRequestsForInformationByRfiCostCodeId = $arrRequestsForInformationByRfiCostCodeId;

		return $arrRequestsForInformationByRfiCostCodeId;
	}

	/**
	 * Load by constraint `requests_for_information_fk_creator_c` foreign key (`rfi_creator_contact_id`) references `contacts` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $rfi_creator_contact_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadRequestsForInformationByRfiCreatorContactId($database, $rfi_creator_contact_id, Input $options=null)
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
			self::$_arrRequestsForInformationByRfiCreatorContactId = null;
		}

		$arrRequestsForInformationByRfiCreatorContactId = self::$_arrRequestsForInformationByRfiCreatorContactId;
		if (isset($arrRequestsForInformationByRfiCreatorContactId) && !empty($arrRequestsForInformationByRfiCreatorContactId)) {
			return $arrRequestsForInformationByRfiCreatorContactId;
		}

		$rfi_creator_contact_id = (int) $rfi_creator_contact_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `rfi_sequence_number` ASC, `request_for_information_type_id` ASC, `request_for_information_status_id` ASC, `request_for_information_priority_id` ASC, `rfi_file_manager_file_id` ASC, `rfi_cost_code_id` ASC, `rfi_creator_contact_id` ASC, `rfi_creator_contact_company_office_id` ASC, `rfi_creator_phone_contact_company_office_phone_number_id` ASC, `rfi_creator_fax_contact_company_office_phone_number_id` ASC, `rfi_creator_contact_mobile_phone_number_id` ASC, `rfi_recipient_contact_id` ASC, `rfi_recipient_contact_company_office_id` ASC, `rfi_recipient_phone_contact_company_office_phone_number_id` ASC, `rfi_recipient_fax_contact_company_office_phone_number_id` ASC, `rfi_recipient_contact_mobile_phone_number_id` ASC, `rfi_initiator_contact_id` ASC, `rfi_initiator_contact_company_office_id` ASC, `rfi_initiator_phone_contact_company_office_phone_number_id` ASC, `rfi_initiator_fax_contact_company_office_phone_number_id` ASC, `rfi_initiator_contact_mobile_phone_number_id` ASC, `rfi_title` ASC, `rfi_plan_page_reference` ASC, `rfi_statement` ASC, `created` ASC, `rfi_due_date` ASC, `rfi_closed_date` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpRequestForInformation = new RequestForInformation($database);
			$sqlOrderByColumns = $tmpRequestForInformation->constructSqlOrderByColumns($arrOrderByAttributes);

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
	rfi.*

FROM `requests_for_information` rfi
WHERE rfi.`rfi_creator_contact_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `rfi_sequence_number` ASC, `request_for_information_type_id` ASC, `request_for_information_status_id` ASC, `request_for_information_priority_id` ASC, `rfi_file_manager_file_id` ASC, `rfi_cost_code_id` ASC, `rfi_creator_contact_id` ASC, `rfi_creator_contact_company_office_id` ASC, `rfi_creator_phone_contact_company_office_phone_number_id` ASC, `rfi_creator_fax_contact_company_office_phone_number_id` ASC, `rfi_creator_contact_mobile_phone_number_id` ASC, `rfi_recipient_contact_id` ASC, `rfi_recipient_contact_company_office_id` ASC, `rfi_recipient_phone_contact_company_office_phone_number_id` ASC, `rfi_recipient_fax_contact_company_office_phone_number_id` ASC, `rfi_recipient_contact_mobile_phone_number_id` ASC, `rfi_initiator_contact_id` ASC, `rfi_initiator_contact_company_office_id` ASC, `rfi_initiator_phone_contact_company_office_phone_number_id` ASC, `rfi_initiator_fax_contact_company_office_phone_number_id` ASC, `rfi_initiator_contact_mobile_phone_number_id` ASC, `rfi_title` ASC, `rfi_plan_page_reference` ASC, `rfi_statement` ASC, `created` ASC, `rfi_due_date` ASC, `rfi_closed_date` ASC
		$arrValues = array($rfi_creator_contact_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrRequestsForInformationByRfiCreatorContactId = array();
		while ($row = $db->fetch()) {
			$request_for_information_id = $row['id'];
			$requestForInformation = self::instantiateOrm($database, 'RequestForInformation', $row, null, $request_for_information_id);
			/* @var $requestForInformation RequestForInformation */
			$arrRequestsForInformationByRfiCreatorContactId[$request_for_information_id] = $requestForInformation;
		}

		$db->free_result();

		self::$_arrRequestsForInformationByRfiCreatorContactId = $arrRequestsForInformationByRfiCreatorContactId;

		return $arrRequestsForInformationByRfiCreatorContactId;
	}

	/**
	 * Load by constraint `requests_for_information_fk_creator_cco` foreign key (`rfi_creator_contact_company_office_id`) references `contact_company_offices` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $rfi_creator_contact_company_office_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadRequestsForInformationByRfiCreatorContactCompanyOfficeId($database, $rfi_creator_contact_company_office_id, Input $options=null)
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
			self::$_arrRequestsForInformationByRfiCreatorContactCompanyOfficeId = null;
		}

		$arrRequestsForInformationByRfiCreatorContactCompanyOfficeId = self::$_arrRequestsForInformationByRfiCreatorContactCompanyOfficeId;
		if (isset($arrRequestsForInformationByRfiCreatorContactCompanyOfficeId) && !empty($arrRequestsForInformationByRfiCreatorContactCompanyOfficeId)) {
			return $arrRequestsForInformationByRfiCreatorContactCompanyOfficeId;
		}

		$rfi_creator_contact_company_office_id = (int) $rfi_creator_contact_company_office_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `rfi_sequence_number` ASC, `request_for_information_type_id` ASC, `request_for_information_status_id` ASC, `request_for_information_priority_id` ASC, `rfi_file_manager_file_id` ASC, `rfi_cost_code_id` ASC, `rfi_creator_contact_id` ASC, `rfi_creator_contact_company_office_id` ASC, `rfi_creator_phone_contact_company_office_phone_number_id` ASC, `rfi_creator_fax_contact_company_office_phone_number_id` ASC, `rfi_creator_contact_mobile_phone_number_id` ASC, `rfi_recipient_contact_id` ASC, `rfi_recipient_contact_company_office_id` ASC, `rfi_recipient_phone_contact_company_office_phone_number_id` ASC, `rfi_recipient_fax_contact_company_office_phone_number_id` ASC, `rfi_recipient_contact_mobile_phone_number_id` ASC, `rfi_initiator_contact_id` ASC, `rfi_initiator_contact_company_office_id` ASC, `rfi_initiator_phone_contact_company_office_phone_number_id` ASC, `rfi_initiator_fax_contact_company_office_phone_number_id` ASC, `rfi_initiator_contact_mobile_phone_number_id` ASC, `rfi_title` ASC, `rfi_plan_page_reference` ASC, `rfi_statement` ASC, `created` ASC, `rfi_due_date` ASC, `rfi_closed_date` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpRequestForInformation = new RequestForInformation($database);
			$sqlOrderByColumns = $tmpRequestForInformation->constructSqlOrderByColumns($arrOrderByAttributes);

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
	rfi.*

FROM `requests_for_information` rfi
WHERE rfi.`rfi_creator_contact_company_office_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `rfi_sequence_number` ASC, `request_for_information_type_id` ASC, `request_for_information_status_id` ASC, `request_for_information_priority_id` ASC, `rfi_file_manager_file_id` ASC, `rfi_cost_code_id` ASC, `rfi_creator_contact_id` ASC, `rfi_creator_contact_company_office_id` ASC, `rfi_creator_phone_contact_company_office_phone_number_id` ASC, `rfi_creator_fax_contact_company_office_phone_number_id` ASC, `rfi_creator_contact_mobile_phone_number_id` ASC, `rfi_recipient_contact_id` ASC, `rfi_recipient_contact_company_office_id` ASC, `rfi_recipient_phone_contact_company_office_phone_number_id` ASC, `rfi_recipient_fax_contact_company_office_phone_number_id` ASC, `rfi_recipient_contact_mobile_phone_number_id` ASC, `rfi_initiator_contact_id` ASC, `rfi_initiator_contact_company_office_id` ASC, `rfi_initiator_phone_contact_company_office_phone_number_id` ASC, `rfi_initiator_fax_contact_company_office_phone_number_id` ASC, `rfi_initiator_contact_mobile_phone_number_id` ASC, `rfi_title` ASC, `rfi_plan_page_reference` ASC, `rfi_statement` ASC, `created` ASC, `rfi_due_date` ASC, `rfi_closed_date` ASC
		$arrValues = array($rfi_creator_contact_company_office_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrRequestsForInformationByRfiCreatorContactCompanyOfficeId = array();
		while ($row = $db->fetch()) {
			$request_for_information_id = $row['id'];
			$requestForInformation = self::instantiateOrm($database, 'RequestForInformation', $row, null, $request_for_information_id);
			/* @var $requestForInformation RequestForInformation */
			$arrRequestsForInformationByRfiCreatorContactCompanyOfficeId[$request_for_information_id] = $requestForInformation;
		}

		$db->free_result();

		self::$_arrRequestsForInformationByRfiCreatorContactCompanyOfficeId = $arrRequestsForInformationByRfiCreatorContactCompanyOfficeId;

		return $arrRequestsForInformationByRfiCreatorContactCompanyOfficeId;
	}

	/**
	 * Load by constraint `requests_for_information_fk_creator_phone_ccopn` foreign key (`rfi_creator_phone_contact_company_office_phone_number_id`) references `contact_company_office_phone_numbers` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $rfi_creator_phone_contact_company_office_phone_number_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadRequestsForInformationByRfiCreatorPhoneContactCompanyOfficePhoneNumberId($database, $rfi_creator_phone_contact_company_office_phone_number_id, Input $options=null)
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
			self::$_arrRequestsForInformationByRfiCreatorPhoneContactCompanyOfficePhoneNumberId = null;
		}

		$arrRequestsForInformationByRfiCreatorPhoneContactCompanyOfficePhoneNumberId = self::$_arrRequestsForInformationByRfiCreatorPhoneContactCompanyOfficePhoneNumberId;
		if (isset($arrRequestsForInformationByRfiCreatorPhoneContactCompanyOfficePhoneNumberId) && !empty($arrRequestsForInformationByRfiCreatorPhoneContactCompanyOfficePhoneNumberId)) {
			return $arrRequestsForInformationByRfiCreatorPhoneContactCompanyOfficePhoneNumberId;
		}

		$rfi_creator_phone_contact_company_office_phone_number_id = (int) $rfi_creator_phone_contact_company_office_phone_number_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `rfi_sequence_number` ASC, `request_for_information_type_id` ASC, `request_for_information_status_id` ASC, `request_for_information_priority_id` ASC, `rfi_file_manager_file_id` ASC, `rfi_cost_code_id` ASC, `rfi_creator_contact_id` ASC, `rfi_creator_contact_company_office_id` ASC, `rfi_creator_phone_contact_company_office_phone_number_id` ASC, `rfi_creator_fax_contact_company_office_phone_number_id` ASC, `rfi_creator_contact_mobile_phone_number_id` ASC, `rfi_recipient_contact_id` ASC, `rfi_recipient_contact_company_office_id` ASC, `rfi_recipient_phone_contact_company_office_phone_number_id` ASC, `rfi_recipient_fax_contact_company_office_phone_number_id` ASC, `rfi_recipient_contact_mobile_phone_number_id` ASC, `rfi_initiator_contact_id` ASC, `rfi_initiator_contact_company_office_id` ASC, `rfi_initiator_phone_contact_company_office_phone_number_id` ASC, `rfi_initiator_fax_contact_company_office_phone_number_id` ASC, `rfi_initiator_contact_mobile_phone_number_id` ASC, `rfi_title` ASC, `rfi_plan_page_reference` ASC, `rfi_statement` ASC, `created` ASC, `rfi_due_date` ASC, `rfi_closed_date` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpRequestForInformation = new RequestForInformation($database);
			$sqlOrderByColumns = $tmpRequestForInformation->constructSqlOrderByColumns($arrOrderByAttributes);

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
	rfi.*

FROM `requests_for_information` rfi
WHERE rfi.`rfi_creator_phone_contact_company_office_phone_number_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `rfi_sequence_number` ASC, `request_for_information_type_id` ASC, `request_for_information_status_id` ASC, `request_for_information_priority_id` ASC, `rfi_file_manager_file_id` ASC, `rfi_cost_code_id` ASC, `rfi_creator_contact_id` ASC, `rfi_creator_contact_company_office_id` ASC, `rfi_creator_phone_contact_company_office_phone_number_id` ASC, `rfi_creator_fax_contact_company_office_phone_number_id` ASC, `rfi_creator_contact_mobile_phone_number_id` ASC, `rfi_recipient_contact_id` ASC, `rfi_recipient_contact_company_office_id` ASC, `rfi_recipient_phone_contact_company_office_phone_number_id` ASC, `rfi_recipient_fax_contact_company_office_phone_number_id` ASC, `rfi_recipient_contact_mobile_phone_number_id` ASC, `rfi_initiator_contact_id` ASC, `rfi_initiator_contact_company_office_id` ASC, `rfi_initiator_phone_contact_company_office_phone_number_id` ASC, `rfi_initiator_fax_contact_company_office_phone_number_id` ASC, `rfi_initiator_contact_mobile_phone_number_id` ASC, `rfi_title` ASC, `rfi_plan_page_reference` ASC, `rfi_statement` ASC, `created` ASC, `rfi_due_date` ASC, `rfi_closed_date` ASC
		$arrValues = array($rfi_creator_phone_contact_company_office_phone_number_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrRequestsForInformationByRfiCreatorPhoneContactCompanyOfficePhoneNumberId = array();
		while ($row = $db->fetch()) {
			$request_for_information_id = $row['id'];
			$requestForInformation = self::instantiateOrm($database, 'RequestForInformation', $row, null, $request_for_information_id);
			/* @var $requestForInformation RequestForInformation */
			$arrRequestsForInformationByRfiCreatorPhoneContactCompanyOfficePhoneNumberId[$request_for_information_id] = $requestForInformation;
		}

		$db->free_result();

		self::$_arrRequestsForInformationByRfiCreatorPhoneContactCompanyOfficePhoneNumberId = $arrRequestsForInformationByRfiCreatorPhoneContactCompanyOfficePhoneNumberId;

		return $arrRequestsForInformationByRfiCreatorPhoneContactCompanyOfficePhoneNumberId;
	}

	/**
	 * Load by constraint `requests_for_information_fk_creator_fax_ccopn` foreign key (`rfi_creator_fax_contact_company_office_phone_number_id`) references `contact_company_office_phone_numbers` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $rfi_creator_fax_contact_company_office_phone_number_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadRequestsForInformationByRfiCreatorFaxContactCompanyOfficePhoneNumberId($database, $rfi_creator_fax_contact_company_office_phone_number_id, Input $options=null)
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
			self::$_arrRequestsForInformationByRfiCreatorFaxContactCompanyOfficePhoneNumberId = null;
		}

		$arrRequestsForInformationByRfiCreatorFaxContactCompanyOfficePhoneNumberId = self::$_arrRequestsForInformationByRfiCreatorFaxContactCompanyOfficePhoneNumberId;
		if (isset($arrRequestsForInformationByRfiCreatorFaxContactCompanyOfficePhoneNumberId) && !empty($arrRequestsForInformationByRfiCreatorFaxContactCompanyOfficePhoneNumberId)) {
			return $arrRequestsForInformationByRfiCreatorFaxContactCompanyOfficePhoneNumberId;
		}

		$rfi_creator_fax_contact_company_office_phone_number_id = (int) $rfi_creator_fax_contact_company_office_phone_number_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `rfi_sequence_number` ASC, `request_for_information_type_id` ASC, `request_for_information_status_id` ASC, `request_for_information_priority_id` ASC, `rfi_file_manager_file_id` ASC, `rfi_cost_code_id` ASC, `rfi_creator_contact_id` ASC, `rfi_creator_contact_company_office_id` ASC, `rfi_creator_phone_contact_company_office_phone_number_id` ASC, `rfi_creator_fax_contact_company_office_phone_number_id` ASC, `rfi_creator_contact_mobile_phone_number_id` ASC, `rfi_recipient_contact_id` ASC, `rfi_recipient_contact_company_office_id` ASC, `rfi_recipient_phone_contact_company_office_phone_number_id` ASC, `rfi_recipient_fax_contact_company_office_phone_number_id` ASC, `rfi_recipient_contact_mobile_phone_number_id` ASC, `rfi_initiator_contact_id` ASC, `rfi_initiator_contact_company_office_id` ASC, `rfi_initiator_phone_contact_company_office_phone_number_id` ASC, `rfi_initiator_fax_contact_company_office_phone_number_id` ASC, `rfi_initiator_contact_mobile_phone_number_id` ASC, `rfi_title` ASC, `rfi_plan_page_reference` ASC, `rfi_statement` ASC, `created` ASC, `rfi_due_date` ASC, `rfi_closed_date` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpRequestForInformation = new RequestForInformation($database);
			$sqlOrderByColumns = $tmpRequestForInformation->constructSqlOrderByColumns($arrOrderByAttributes);

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
	rfi.*

FROM `requests_for_information` rfi
WHERE rfi.`rfi_creator_fax_contact_company_office_phone_number_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `rfi_sequence_number` ASC, `request_for_information_type_id` ASC, `request_for_information_status_id` ASC, `request_for_information_priority_id` ASC, `rfi_file_manager_file_id` ASC, `rfi_cost_code_id` ASC, `rfi_creator_contact_id` ASC, `rfi_creator_contact_company_office_id` ASC, `rfi_creator_phone_contact_company_office_phone_number_id` ASC, `rfi_creator_fax_contact_company_office_phone_number_id` ASC, `rfi_creator_contact_mobile_phone_number_id` ASC, `rfi_recipient_contact_id` ASC, `rfi_recipient_contact_company_office_id` ASC, `rfi_recipient_phone_contact_company_office_phone_number_id` ASC, `rfi_recipient_fax_contact_company_office_phone_number_id` ASC, `rfi_recipient_contact_mobile_phone_number_id` ASC, `rfi_initiator_contact_id` ASC, `rfi_initiator_contact_company_office_id` ASC, `rfi_initiator_phone_contact_company_office_phone_number_id` ASC, `rfi_initiator_fax_contact_company_office_phone_number_id` ASC, `rfi_initiator_contact_mobile_phone_number_id` ASC, `rfi_title` ASC, `rfi_plan_page_reference` ASC, `rfi_statement` ASC, `created` ASC, `rfi_due_date` ASC, `rfi_closed_date` ASC
		$arrValues = array($rfi_creator_fax_contact_company_office_phone_number_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrRequestsForInformationByRfiCreatorFaxContactCompanyOfficePhoneNumberId = array();
		while ($row = $db->fetch()) {
			$request_for_information_id = $row['id'];
			$requestForInformation = self::instantiateOrm($database, 'RequestForInformation', $row, null, $request_for_information_id);
			/* @var $requestForInformation RequestForInformation */
			$arrRequestsForInformationByRfiCreatorFaxContactCompanyOfficePhoneNumberId[$request_for_information_id] = $requestForInformation;
		}

		$db->free_result();

		self::$_arrRequestsForInformationByRfiCreatorFaxContactCompanyOfficePhoneNumberId = $arrRequestsForInformationByRfiCreatorFaxContactCompanyOfficePhoneNumberId;

		return $arrRequestsForInformationByRfiCreatorFaxContactCompanyOfficePhoneNumberId;
	}

	/**
	 * Load by constraint `requests_for_information_fk_creator_c_mobile_cpn` foreign key (`rfi_creator_contact_mobile_phone_number_id`) references `contact_phone_numbers` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $rfi_creator_contact_mobile_phone_number_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadRequestsForInformationByRfiCreatorContactMobilePhoneNumberId($database, $rfi_creator_contact_mobile_phone_number_id, Input $options=null)
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
			self::$_arrRequestsForInformationByRfiCreatorContactMobilePhoneNumberId = null;
		}

		$arrRequestsForInformationByRfiCreatorContactMobilePhoneNumberId = self::$_arrRequestsForInformationByRfiCreatorContactMobilePhoneNumberId;
		if (isset($arrRequestsForInformationByRfiCreatorContactMobilePhoneNumberId) && !empty($arrRequestsForInformationByRfiCreatorContactMobilePhoneNumberId)) {
			return $arrRequestsForInformationByRfiCreatorContactMobilePhoneNumberId;
		}

		$rfi_creator_contact_mobile_phone_number_id = (int) $rfi_creator_contact_mobile_phone_number_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `rfi_sequence_number` ASC, `request_for_information_type_id` ASC, `request_for_information_status_id` ASC, `request_for_information_priority_id` ASC, `rfi_file_manager_file_id` ASC, `rfi_cost_code_id` ASC, `rfi_creator_contact_id` ASC, `rfi_creator_contact_company_office_id` ASC, `rfi_creator_phone_contact_company_office_phone_number_id` ASC, `rfi_creator_fax_contact_company_office_phone_number_id` ASC, `rfi_creator_contact_mobile_phone_number_id` ASC, `rfi_recipient_contact_id` ASC, `rfi_recipient_contact_company_office_id` ASC, `rfi_recipient_phone_contact_company_office_phone_number_id` ASC, `rfi_recipient_fax_contact_company_office_phone_number_id` ASC, `rfi_recipient_contact_mobile_phone_number_id` ASC, `rfi_initiator_contact_id` ASC, `rfi_initiator_contact_company_office_id` ASC, `rfi_initiator_phone_contact_company_office_phone_number_id` ASC, `rfi_initiator_fax_contact_company_office_phone_number_id` ASC, `rfi_initiator_contact_mobile_phone_number_id` ASC, `rfi_title` ASC, `rfi_plan_page_reference` ASC, `rfi_statement` ASC, `created` ASC, `rfi_due_date` ASC, `rfi_closed_date` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpRequestForInformation = new RequestForInformation($database);
			$sqlOrderByColumns = $tmpRequestForInformation->constructSqlOrderByColumns($arrOrderByAttributes);

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
	rfi.*

FROM `requests_for_information` rfi
WHERE rfi.`rfi_creator_contact_mobile_phone_number_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `rfi_sequence_number` ASC, `request_for_information_type_id` ASC, `request_for_information_status_id` ASC, `request_for_information_priority_id` ASC, `rfi_file_manager_file_id` ASC, `rfi_cost_code_id` ASC, `rfi_creator_contact_id` ASC, `rfi_creator_contact_company_office_id` ASC, `rfi_creator_phone_contact_company_office_phone_number_id` ASC, `rfi_creator_fax_contact_company_office_phone_number_id` ASC, `rfi_creator_contact_mobile_phone_number_id` ASC, `rfi_recipient_contact_id` ASC, `rfi_recipient_contact_company_office_id` ASC, `rfi_recipient_phone_contact_company_office_phone_number_id` ASC, `rfi_recipient_fax_contact_company_office_phone_number_id` ASC, `rfi_recipient_contact_mobile_phone_number_id` ASC, `rfi_initiator_contact_id` ASC, `rfi_initiator_contact_company_office_id` ASC, `rfi_initiator_phone_contact_company_office_phone_number_id` ASC, `rfi_initiator_fax_contact_company_office_phone_number_id` ASC, `rfi_initiator_contact_mobile_phone_number_id` ASC, `rfi_title` ASC, `rfi_plan_page_reference` ASC, `rfi_statement` ASC, `created` ASC, `rfi_due_date` ASC, `rfi_closed_date` ASC
		$arrValues = array($rfi_creator_contact_mobile_phone_number_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrRequestsForInformationByRfiCreatorContactMobilePhoneNumberId = array();
		while ($row = $db->fetch()) {
			$request_for_information_id = $row['id'];
			$requestForInformation = self::instantiateOrm($database, 'RequestForInformation', $row, null, $request_for_information_id);
			/* @var $requestForInformation RequestForInformation */
			$arrRequestsForInformationByRfiCreatorContactMobilePhoneNumberId[$request_for_information_id] = $requestForInformation;
		}

		$db->free_result();

		self::$_arrRequestsForInformationByRfiCreatorContactMobilePhoneNumberId = $arrRequestsForInformationByRfiCreatorContactMobilePhoneNumberId;

		return $arrRequestsForInformationByRfiCreatorContactMobilePhoneNumberId;
	}

	/**
	 * Load by constraint `requests_for_information_fk_recipient_c` foreign key (`rfi_recipient_contact_id`) references `contacts` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $rfi_recipient_contact_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadRequestsForInformationByRfiRecipientContactId($database, $rfi_recipient_contact_id, Input $options=null)
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
			self::$_arrRequestsForInformationByRfiRecipientContactId = null;
		}

		$arrRequestsForInformationByRfiRecipientContactId = self::$_arrRequestsForInformationByRfiRecipientContactId;
		if (isset($arrRequestsForInformationByRfiRecipientContactId) && !empty($arrRequestsForInformationByRfiRecipientContactId)) {
			return $arrRequestsForInformationByRfiRecipientContactId;
		}

		$rfi_recipient_contact_id = (int) $rfi_recipient_contact_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `rfi_sequence_number` ASC, `request_for_information_type_id` ASC, `request_for_information_status_id` ASC, `request_for_information_priority_id` ASC, `rfi_file_manager_file_id` ASC, `rfi_cost_code_id` ASC, `rfi_creator_contact_id` ASC, `rfi_creator_contact_company_office_id` ASC, `rfi_creator_phone_contact_company_office_phone_number_id` ASC, `rfi_creator_fax_contact_company_office_phone_number_id` ASC, `rfi_creator_contact_mobile_phone_number_id` ASC, `rfi_recipient_contact_id` ASC, `rfi_recipient_contact_company_office_id` ASC, `rfi_recipient_phone_contact_company_office_phone_number_id` ASC, `rfi_recipient_fax_contact_company_office_phone_number_id` ASC, `rfi_recipient_contact_mobile_phone_number_id` ASC, `rfi_initiator_contact_id` ASC, `rfi_initiator_contact_company_office_id` ASC, `rfi_initiator_phone_contact_company_office_phone_number_id` ASC, `rfi_initiator_fax_contact_company_office_phone_number_id` ASC, `rfi_initiator_contact_mobile_phone_number_id` ASC, `rfi_title` ASC, `rfi_plan_page_reference` ASC, `rfi_statement` ASC, `created` ASC, `rfi_due_date` ASC, `rfi_closed_date` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpRequestForInformation = new RequestForInformation($database);
			$sqlOrderByColumns = $tmpRequestForInformation->constructSqlOrderByColumns($arrOrderByAttributes);

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
	rfi.*

FROM `requests_for_information` rfi
WHERE rfi.`rfi_recipient_contact_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `rfi_sequence_number` ASC, `request_for_information_type_id` ASC, `request_for_information_status_id` ASC, `request_for_information_priority_id` ASC, `rfi_file_manager_file_id` ASC, `rfi_cost_code_id` ASC, `rfi_creator_contact_id` ASC, `rfi_creator_contact_company_office_id` ASC, `rfi_creator_phone_contact_company_office_phone_number_id` ASC, `rfi_creator_fax_contact_company_office_phone_number_id` ASC, `rfi_creator_contact_mobile_phone_number_id` ASC, `rfi_recipient_contact_id` ASC, `rfi_recipient_contact_company_office_id` ASC, `rfi_recipient_phone_contact_company_office_phone_number_id` ASC, `rfi_recipient_fax_contact_company_office_phone_number_id` ASC, `rfi_recipient_contact_mobile_phone_number_id` ASC, `rfi_initiator_contact_id` ASC, `rfi_initiator_contact_company_office_id` ASC, `rfi_initiator_phone_contact_company_office_phone_number_id` ASC, `rfi_initiator_fax_contact_company_office_phone_number_id` ASC, `rfi_initiator_contact_mobile_phone_number_id` ASC, `rfi_title` ASC, `rfi_plan_page_reference` ASC, `rfi_statement` ASC, `created` ASC, `rfi_due_date` ASC, `rfi_closed_date` ASC
		$arrValues = array($rfi_recipient_contact_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrRequestsForInformationByRfiRecipientContactId = array();
		while ($row = $db->fetch()) {
			$request_for_information_id = $row['id'];
			$requestForInformation = self::instantiateOrm($database, 'RequestForInformation', $row, null, $request_for_information_id);
			/* @var $requestForInformation RequestForInformation */
			$arrRequestsForInformationByRfiRecipientContactId[$request_for_information_id] = $requestForInformation;
		}

		$db->free_result();

		self::$_arrRequestsForInformationByRfiRecipientContactId = $arrRequestsForInformationByRfiRecipientContactId;

		return $arrRequestsForInformationByRfiRecipientContactId;
	}

	/**
	 * Load by constraint `requests_for_information_fk_recipient_cco` foreign key (`rfi_recipient_contact_company_office_id`) references `contact_company_offices` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $rfi_recipient_contact_company_office_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadRequestsForInformationByRfiRecipientContactCompanyOfficeId($database, $rfi_recipient_contact_company_office_id, Input $options=null)
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
			self::$_arrRequestsForInformationByRfiRecipientContactCompanyOfficeId = null;
		}

		$arrRequestsForInformationByRfiRecipientContactCompanyOfficeId = self::$_arrRequestsForInformationByRfiRecipientContactCompanyOfficeId;
		if (isset($arrRequestsForInformationByRfiRecipientContactCompanyOfficeId) && !empty($arrRequestsForInformationByRfiRecipientContactCompanyOfficeId)) {
			return $arrRequestsForInformationByRfiRecipientContactCompanyOfficeId;
		}

		$rfi_recipient_contact_company_office_id = (int) $rfi_recipient_contact_company_office_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `rfi_sequence_number` ASC, `request_for_information_type_id` ASC, `request_for_information_status_id` ASC, `request_for_information_priority_id` ASC, `rfi_file_manager_file_id` ASC, `rfi_cost_code_id` ASC, `rfi_creator_contact_id` ASC, `rfi_creator_contact_company_office_id` ASC, `rfi_creator_phone_contact_company_office_phone_number_id` ASC, `rfi_creator_fax_contact_company_office_phone_number_id` ASC, `rfi_creator_contact_mobile_phone_number_id` ASC, `rfi_recipient_contact_id` ASC, `rfi_recipient_contact_company_office_id` ASC, `rfi_recipient_phone_contact_company_office_phone_number_id` ASC, `rfi_recipient_fax_contact_company_office_phone_number_id` ASC, `rfi_recipient_contact_mobile_phone_number_id` ASC, `rfi_initiator_contact_id` ASC, `rfi_initiator_contact_company_office_id` ASC, `rfi_initiator_phone_contact_company_office_phone_number_id` ASC, `rfi_initiator_fax_contact_company_office_phone_number_id` ASC, `rfi_initiator_contact_mobile_phone_number_id` ASC, `rfi_title` ASC, `rfi_plan_page_reference` ASC, `rfi_statement` ASC, `created` ASC, `rfi_due_date` ASC, `rfi_closed_date` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpRequestForInformation = new RequestForInformation($database);
			$sqlOrderByColumns = $tmpRequestForInformation->constructSqlOrderByColumns($arrOrderByAttributes);

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
	rfi.*

FROM `requests_for_information` rfi
WHERE rfi.`rfi_recipient_contact_company_office_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `rfi_sequence_number` ASC, `request_for_information_type_id` ASC, `request_for_information_status_id` ASC, `request_for_information_priority_id` ASC, `rfi_file_manager_file_id` ASC, `rfi_cost_code_id` ASC, `rfi_creator_contact_id` ASC, `rfi_creator_contact_company_office_id` ASC, `rfi_creator_phone_contact_company_office_phone_number_id` ASC, `rfi_creator_fax_contact_company_office_phone_number_id` ASC, `rfi_creator_contact_mobile_phone_number_id` ASC, `rfi_recipient_contact_id` ASC, `rfi_recipient_contact_company_office_id` ASC, `rfi_recipient_phone_contact_company_office_phone_number_id` ASC, `rfi_recipient_fax_contact_company_office_phone_number_id` ASC, `rfi_recipient_contact_mobile_phone_number_id` ASC, `rfi_initiator_contact_id` ASC, `rfi_initiator_contact_company_office_id` ASC, `rfi_initiator_phone_contact_company_office_phone_number_id` ASC, `rfi_initiator_fax_contact_company_office_phone_number_id` ASC, `rfi_initiator_contact_mobile_phone_number_id` ASC, `rfi_title` ASC, `rfi_plan_page_reference` ASC, `rfi_statement` ASC, `created` ASC, `rfi_due_date` ASC, `rfi_closed_date` ASC
		$arrValues = array($rfi_recipient_contact_company_office_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrRequestsForInformationByRfiRecipientContactCompanyOfficeId = array();
		while ($row = $db->fetch()) {
			$request_for_information_id = $row['id'];
			$requestForInformation = self::instantiateOrm($database, 'RequestForInformation', $row, null, $request_for_information_id);
			/* @var $requestForInformation RequestForInformation */
			$arrRequestsForInformationByRfiRecipientContactCompanyOfficeId[$request_for_information_id] = $requestForInformation;
		}

		$db->free_result();

		self::$_arrRequestsForInformationByRfiRecipientContactCompanyOfficeId = $arrRequestsForInformationByRfiRecipientContactCompanyOfficeId;

		return $arrRequestsForInformationByRfiRecipientContactCompanyOfficeId;
	}

	/**
	 * Load by constraint `requests_for_information_fk_recipient_phone_ccopn` foreign key (`rfi_recipient_phone_contact_company_office_phone_number_id`) references `contact_company_office_phone_numbers` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $rfi_recipient_phone_contact_company_office_phone_number_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadRequestsForInformationByRfiRecipientPhoneContactCompanyOfficePhoneNumberId($database, $rfi_recipient_phone_contact_company_office_phone_number_id, Input $options=null)
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
			self::$_arrRequestsForInformationByRfiRecipientPhoneContactCompanyOfficePhoneNumberId = null;
		}

		$arrRequestsForInformationByRfiRecipientPhoneContactCompanyOfficePhoneNumberId = self::$_arrRequestsForInformationByRfiRecipientPhoneContactCompanyOfficePhoneNumberId;
		if (isset($arrRequestsForInformationByRfiRecipientPhoneContactCompanyOfficePhoneNumberId) && !empty($arrRequestsForInformationByRfiRecipientPhoneContactCompanyOfficePhoneNumberId)) {
			return $arrRequestsForInformationByRfiRecipientPhoneContactCompanyOfficePhoneNumberId;
		}

		$rfi_recipient_phone_contact_company_office_phone_number_id = (int) $rfi_recipient_phone_contact_company_office_phone_number_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `rfi_sequence_number` ASC, `request_for_information_type_id` ASC, `request_for_information_status_id` ASC, `request_for_information_priority_id` ASC, `rfi_file_manager_file_id` ASC, `rfi_cost_code_id` ASC, `rfi_creator_contact_id` ASC, `rfi_creator_contact_company_office_id` ASC, `rfi_creator_phone_contact_company_office_phone_number_id` ASC, `rfi_creator_fax_contact_company_office_phone_number_id` ASC, `rfi_creator_contact_mobile_phone_number_id` ASC, `rfi_recipient_contact_id` ASC, `rfi_recipient_contact_company_office_id` ASC, `rfi_recipient_phone_contact_company_office_phone_number_id` ASC, `rfi_recipient_fax_contact_company_office_phone_number_id` ASC, `rfi_recipient_contact_mobile_phone_number_id` ASC, `rfi_initiator_contact_id` ASC, `rfi_initiator_contact_company_office_id` ASC, `rfi_initiator_phone_contact_company_office_phone_number_id` ASC, `rfi_initiator_fax_contact_company_office_phone_number_id` ASC, `rfi_initiator_contact_mobile_phone_number_id` ASC, `rfi_title` ASC, `rfi_plan_page_reference` ASC, `rfi_statement` ASC, `created` ASC, `rfi_due_date` ASC, `rfi_closed_date` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpRequestForInformation = new RequestForInformation($database);
			$sqlOrderByColumns = $tmpRequestForInformation->constructSqlOrderByColumns($arrOrderByAttributes);

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
	rfi.*

FROM `requests_for_information` rfi
WHERE rfi.`rfi_recipient_phone_contact_company_office_phone_number_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `rfi_sequence_number` ASC, `request_for_information_type_id` ASC, `request_for_information_status_id` ASC, `request_for_information_priority_id` ASC, `rfi_file_manager_file_id` ASC, `rfi_cost_code_id` ASC, `rfi_creator_contact_id` ASC, `rfi_creator_contact_company_office_id` ASC, `rfi_creator_phone_contact_company_office_phone_number_id` ASC, `rfi_creator_fax_contact_company_office_phone_number_id` ASC, `rfi_creator_contact_mobile_phone_number_id` ASC, `rfi_recipient_contact_id` ASC, `rfi_recipient_contact_company_office_id` ASC, `rfi_recipient_phone_contact_company_office_phone_number_id` ASC, `rfi_recipient_fax_contact_company_office_phone_number_id` ASC, `rfi_recipient_contact_mobile_phone_number_id` ASC, `rfi_initiator_contact_id` ASC, `rfi_initiator_contact_company_office_id` ASC, `rfi_initiator_phone_contact_company_office_phone_number_id` ASC, `rfi_initiator_fax_contact_company_office_phone_number_id` ASC, `rfi_initiator_contact_mobile_phone_number_id` ASC, `rfi_title` ASC, `rfi_plan_page_reference` ASC, `rfi_statement` ASC, `created` ASC, `rfi_due_date` ASC, `rfi_closed_date` ASC
		$arrValues = array($rfi_recipient_phone_contact_company_office_phone_number_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrRequestsForInformationByRfiRecipientPhoneContactCompanyOfficePhoneNumberId = array();
		while ($row = $db->fetch()) {
			$request_for_information_id = $row['id'];
			$requestForInformation = self::instantiateOrm($database, 'RequestForInformation', $row, null, $request_for_information_id);
			/* @var $requestForInformation RequestForInformation */
			$arrRequestsForInformationByRfiRecipientPhoneContactCompanyOfficePhoneNumberId[$request_for_information_id] = $requestForInformation;
		}

		$db->free_result();

		self::$_arrRequestsForInformationByRfiRecipientPhoneContactCompanyOfficePhoneNumberId = $arrRequestsForInformationByRfiRecipientPhoneContactCompanyOfficePhoneNumberId;

		return $arrRequestsForInformationByRfiRecipientPhoneContactCompanyOfficePhoneNumberId;
	}

	/**
	 * Load by constraint `requests_for_information_fk_recipient_fax_ccopn` foreign key (`rfi_recipient_fax_contact_company_office_phone_number_id`) references `contact_company_office_phone_numbers` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $rfi_recipient_fax_contact_company_office_phone_number_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadRequestsForInformationByRfiRecipientFaxContactCompanyOfficePhoneNumberId($database, $rfi_recipient_fax_contact_company_office_phone_number_id, Input $options=null)
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
			self::$_arrRequestsForInformationByRfiRecipientFaxContactCompanyOfficePhoneNumberId = null;
		}

		$arrRequestsForInformationByRfiRecipientFaxContactCompanyOfficePhoneNumberId = self::$_arrRequestsForInformationByRfiRecipientFaxContactCompanyOfficePhoneNumberId;
		if (isset($arrRequestsForInformationByRfiRecipientFaxContactCompanyOfficePhoneNumberId) && !empty($arrRequestsForInformationByRfiRecipientFaxContactCompanyOfficePhoneNumberId)) {
			return $arrRequestsForInformationByRfiRecipientFaxContactCompanyOfficePhoneNumberId;
		}

		$rfi_recipient_fax_contact_company_office_phone_number_id = (int) $rfi_recipient_fax_contact_company_office_phone_number_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `rfi_sequence_number` ASC, `request_for_information_type_id` ASC, `request_for_information_status_id` ASC, `request_for_information_priority_id` ASC, `rfi_file_manager_file_id` ASC, `rfi_cost_code_id` ASC, `rfi_creator_contact_id` ASC, `rfi_creator_contact_company_office_id` ASC, `rfi_creator_phone_contact_company_office_phone_number_id` ASC, `rfi_creator_fax_contact_company_office_phone_number_id` ASC, `rfi_creator_contact_mobile_phone_number_id` ASC, `rfi_recipient_contact_id` ASC, `rfi_recipient_contact_company_office_id` ASC, `rfi_recipient_phone_contact_company_office_phone_number_id` ASC, `rfi_recipient_fax_contact_company_office_phone_number_id` ASC, `rfi_recipient_contact_mobile_phone_number_id` ASC, `rfi_initiator_contact_id` ASC, `rfi_initiator_contact_company_office_id` ASC, `rfi_initiator_phone_contact_company_office_phone_number_id` ASC, `rfi_initiator_fax_contact_company_office_phone_number_id` ASC, `rfi_initiator_contact_mobile_phone_number_id` ASC, `rfi_title` ASC, `rfi_plan_page_reference` ASC, `rfi_statement` ASC, `created` ASC, `rfi_due_date` ASC, `rfi_closed_date` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpRequestForInformation = new RequestForInformation($database);
			$sqlOrderByColumns = $tmpRequestForInformation->constructSqlOrderByColumns($arrOrderByAttributes);

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
	rfi.*

FROM `requests_for_information` rfi
WHERE rfi.`rfi_recipient_fax_contact_company_office_phone_number_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `rfi_sequence_number` ASC, `request_for_information_type_id` ASC, `request_for_information_status_id` ASC, `request_for_information_priority_id` ASC, `rfi_file_manager_file_id` ASC, `rfi_cost_code_id` ASC, `rfi_creator_contact_id` ASC, `rfi_creator_contact_company_office_id` ASC, `rfi_creator_phone_contact_company_office_phone_number_id` ASC, `rfi_creator_fax_contact_company_office_phone_number_id` ASC, `rfi_creator_contact_mobile_phone_number_id` ASC, `rfi_recipient_contact_id` ASC, `rfi_recipient_contact_company_office_id` ASC, `rfi_recipient_phone_contact_company_office_phone_number_id` ASC, `rfi_recipient_fax_contact_company_office_phone_number_id` ASC, `rfi_recipient_contact_mobile_phone_number_id` ASC, `rfi_initiator_contact_id` ASC, `rfi_initiator_contact_company_office_id` ASC, `rfi_initiator_phone_contact_company_office_phone_number_id` ASC, `rfi_initiator_fax_contact_company_office_phone_number_id` ASC, `rfi_initiator_contact_mobile_phone_number_id` ASC, `rfi_title` ASC, `rfi_plan_page_reference` ASC, `rfi_statement` ASC, `created` ASC, `rfi_due_date` ASC, `rfi_closed_date` ASC
		$arrValues = array($rfi_recipient_fax_contact_company_office_phone_number_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrRequestsForInformationByRfiRecipientFaxContactCompanyOfficePhoneNumberId = array();
		while ($row = $db->fetch()) {
			$request_for_information_id = $row['id'];
			$requestForInformation = self::instantiateOrm($database, 'RequestForInformation', $row, null, $request_for_information_id);
			/* @var $requestForInformation RequestForInformation */
			$arrRequestsForInformationByRfiRecipientFaxContactCompanyOfficePhoneNumberId[$request_for_information_id] = $requestForInformation;
		}

		$db->free_result();

		self::$_arrRequestsForInformationByRfiRecipientFaxContactCompanyOfficePhoneNumberId = $arrRequestsForInformationByRfiRecipientFaxContactCompanyOfficePhoneNumberId;

		return $arrRequestsForInformationByRfiRecipientFaxContactCompanyOfficePhoneNumberId;
	}

	/**
	 * Load by constraint `requests_for_information_fk_recipient_c_mobile_cpn` foreign key (`rfi_recipient_contact_mobile_phone_number_id`) references `contact_phone_numbers` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $rfi_recipient_contact_mobile_phone_number_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadRequestsForInformationByRfiRecipientContactMobilePhoneNumberId($database, $rfi_recipient_contact_mobile_phone_number_id, Input $options=null)
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
			self::$_arrRequestsForInformationByRfiRecipientContactMobilePhoneNumberId = null;
		}

		$arrRequestsForInformationByRfiRecipientContactMobilePhoneNumberId = self::$_arrRequestsForInformationByRfiRecipientContactMobilePhoneNumberId;
		if (isset($arrRequestsForInformationByRfiRecipientContactMobilePhoneNumberId) && !empty($arrRequestsForInformationByRfiRecipientContactMobilePhoneNumberId)) {
			return $arrRequestsForInformationByRfiRecipientContactMobilePhoneNumberId;
		}

		$rfi_recipient_contact_mobile_phone_number_id = (int) $rfi_recipient_contact_mobile_phone_number_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `rfi_sequence_number` ASC, `request_for_information_type_id` ASC, `request_for_information_status_id` ASC, `request_for_information_priority_id` ASC, `rfi_file_manager_file_id` ASC, `rfi_cost_code_id` ASC, `rfi_creator_contact_id` ASC, `rfi_creator_contact_company_office_id` ASC, `rfi_creator_phone_contact_company_office_phone_number_id` ASC, `rfi_creator_fax_contact_company_office_phone_number_id` ASC, `rfi_creator_contact_mobile_phone_number_id` ASC, `rfi_recipient_contact_id` ASC, `rfi_recipient_contact_company_office_id` ASC, `rfi_recipient_phone_contact_company_office_phone_number_id` ASC, `rfi_recipient_fax_contact_company_office_phone_number_id` ASC, `rfi_recipient_contact_mobile_phone_number_id` ASC, `rfi_initiator_contact_id` ASC, `rfi_initiator_contact_company_office_id` ASC, `rfi_initiator_phone_contact_company_office_phone_number_id` ASC, `rfi_initiator_fax_contact_company_office_phone_number_id` ASC, `rfi_initiator_contact_mobile_phone_number_id` ASC, `rfi_title` ASC, `rfi_plan_page_reference` ASC, `rfi_statement` ASC, `created` ASC, `rfi_due_date` ASC, `rfi_closed_date` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpRequestForInformation = new RequestForInformation($database);
			$sqlOrderByColumns = $tmpRequestForInformation->constructSqlOrderByColumns($arrOrderByAttributes);

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
	rfi.*

FROM `requests_for_information` rfi
WHERE rfi.`rfi_recipient_contact_mobile_phone_number_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `rfi_sequence_number` ASC, `request_for_information_type_id` ASC, `request_for_information_status_id` ASC, `request_for_information_priority_id` ASC, `rfi_file_manager_file_id` ASC, `rfi_cost_code_id` ASC, `rfi_creator_contact_id` ASC, `rfi_creator_contact_company_office_id` ASC, `rfi_creator_phone_contact_company_office_phone_number_id` ASC, `rfi_creator_fax_contact_company_office_phone_number_id` ASC, `rfi_creator_contact_mobile_phone_number_id` ASC, `rfi_recipient_contact_id` ASC, `rfi_recipient_contact_company_office_id` ASC, `rfi_recipient_phone_contact_company_office_phone_number_id` ASC, `rfi_recipient_fax_contact_company_office_phone_number_id` ASC, `rfi_recipient_contact_mobile_phone_number_id` ASC, `rfi_initiator_contact_id` ASC, `rfi_initiator_contact_company_office_id` ASC, `rfi_initiator_phone_contact_company_office_phone_number_id` ASC, `rfi_initiator_fax_contact_company_office_phone_number_id` ASC, `rfi_initiator_contact_mobile_phone_number_id` ASC, `rfi_title` ASC, `rfi_plan_page_reference` ASC, `rfi_statement` ASC, `created` ASC, `rfi_due_date` ASC, `rfi_closed_date` ASC
		$arrValues = array($rfi_recipient_contact_mobile_phone_number_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrRequestsForInformationByRfiRecipientContactMobilePhoneNumberId = array();
		while ($row = $db->fetch()) {
			$request_for_information_id = $row['id'];
			$requestForInformation = self::instantiateOrm($database, 'RequestForInformation', $row, null, $request_for_information_id);
			/* @var $requestForInformation RequestForInformation */
			$arrRequestsForInformationByRfiRecipientContactMobilePhoneNumberId[$request_for_information_id] = $requestForInformation;
		}

		$db->free_result();

		self::$_arrRequestsForInformationByRfiRecipientContactMobilePhoneNumberId = $arrRequestsForInformationByRfiRecipientContactMobilePhoneNumberId;

		return $arrRequestsForInformationByRfiRecipientContactMobilePhoneNumberId;
	}

	/**
	 * Load by constraint `requests_for_information_fk_initiator_c` foreign key (`rfi_initiator_contact_id`) references `contacts` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $rfi_initiator_contact_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadRequestsForInformationByRfiInitiatorContactId($database, $rfi_initiator_contact_id, Input $options=null)
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
			self::$_arrRequestsForInformationByRfiInitiatorContactId = null;
		}

		$arrRequestsForInformationByRfiInitiatorContactId = self::$_arrRequestsForInformationByRfiInitiatorContactId;
		if (isset($arrRequestsForInformationByRfiInitiatorContactId) && !empty($arrRequestsForInformationByRfiInitiatorContactId)) {
			return $arrRequestsForInformationByRfiInitiatorContactId;
		}

		$rfi_initiator_contact_id = (int) $rfi_initiator_contact_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `rfi_sequence_number` ASC, `request_for_information_type_id` ASC, `request_for_information_status_id` ASC, `request_for_information_priority_id` ASC, `rfi_file_manager_file_id` ASC, `rfi_cost_code_id` ASC, `rfi_creator_contact_id` ASC, `rfi_creator_contact_company_office_id` ASC, `rfi_creator_phone_contact_company_office_phone_number_id` ASC, `rfi_creator_fax_contact_company_office_phone_number_id` ASC, `rfi_creator_contact_mobile_phone_number_id` ASC, `rfi_recipient_contact_id` ASC, `rfi_recipient_contact_company_office_id` ASC, `rfi_recipient_phone_contact_company_office_phone_number_id` ASC, `rfi_recipient_fax_contact_company_office_phone_number_id` ASC, `rfi_recipient_contact_mobile_phone_number_id` ASC, `rfi_initiator_contact_id` ASC, `rfi_initiator_contact_company_office_id` ASC, `rfi_initiator_phone_contact_company_office_phone_number_id` ASC, `rfi_initiator_fax_contact_company_office_phone_number_id` ASC, `rfi_initiator_contact_mobile_phone_number_id` ASC, `rfi_title` ASC, `rfi_plan_page_reference` ASC, `rfi_statement` ASC, `created` ASC, `rfi_due_date` ASC, `rfi_closed_date` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpRequestForInformation = new RequestForInformation($database);
			$sqlOrderByColumns = $tmpRequestForInformation->constructSqlOrderByColumns($arrOrderByAttributes);

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
	rfi.*

FROM `requests_for_information` rfi
WHERE rfi.`rfi_initiator_contact_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `rfi_sequence_number` ASC, `request_for_information_type_id` ASC, `request_for_information_status_id` ASC, `request_for_information_priority_id` ASC, `rfi_file_manager_file_id` ASC, `rfi_cost_code_id` ASC, `rfi_creator_contact_id` ASC, `rfi_creator_contact_company_office_id` ASC, `rfi_creator_phone_contact_company_office_phone_number_id` ASC, `rfi_creator_fax_contact_company_office_phone_number_id` ASC, `rfi_creator_contact_mobile_phone_number_id` ASC, `rfi_recipient_contact_id` ASC, `rfi_recipient_contact_company_office_id` ASC, `rfi_recipient_phone_contact_company_office_phone_number_id` ASC, `rfi_recipient_fax_contact_company_office_phone_number_id` ASC, `rfi_recipient_contact_mobile_phone_number_id` ASC, `rfi_initiator_contact_id` ASC, `rfi_initiator_contact_company_office_id` ASC, `rfi_initiator_phone_contact_company_office_phone_number_id` ASC, `rfi_initiator_fax_contact_company_office_phone_number_id` ASC, `rfi_initiator_contact_mobile_phone_number_id` ASC, `rfi_title` ASC, `rfi_plan_page_reference` ASC, `rfi_statement` ASC, `created` ASC, `rfi_due_date` ASC, `rfi_closed_date` ASC
		$arrValues = array($rfi_initiator_contact_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrRequestsForInformationByRfiInitiatorContactId = array();
		while ($row = $db->fetch()) {
			$request_for_information_id = $row['id'];
			$requestForInformation = self::instantiateOrm($database, 'RequestForInformation', $row, null, $request_for_information_id);
			/* @var $requestForInformation RequestForInformation */
			$arrRequestsForInformationByRfiInitiatorContactId[$request_for_information_id] = $requestForInformation;
		}

		$db->free_result();

		self::$_arrRequestsForInformationByRfiInitiatorContactId = $arrRequestsForInformationByRfiInitiatorContactId;

		return $arrRequestsForInformationByRfiInitiatorContactId;
	}

	/**
	 * Load by constraint `requests_for_information_fk_initiator_cco` foreign key (`rfi_initiator_contact_company_office_id`) references `contact_company_offices` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $rfi_initiator_contact_company_office_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadRequestsForInformationByRfiInitiatorContactCompanyOfficeId($database, $rfi_initiator_contact_company_office_id, Input $options=null)
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
			self::$_arrRequestsForInformationByRfiInitiatorContactCompanyOfficeId = null;
		}

		$arrRequestsForInformationByRfiInitiatorContactCompanyOfficeId = self::$_arrRequestsForInformationByRfiInitiatorContactCompanyOfficeId;
		if (isset($arrRequestsForInformationByRfiInitiatorContactCompanyOfficeId) && !empty($arrRequestsForInformationByRfiInitiatorContactCompanyOfficeId)) {
			return $arrRequestsForInformationByRfiInitiatorContactCompanyOfficeId;
		}

		$rfi_initiator_contact_company_office_id = (int) $rfi_initiator_contact_company_office_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `rfi_sequence_number` ASC, `request_for_information_type_id` ASC, `request_for_information_status_id` ASC, `request_for_information_priority_id` ASC, `rfi_file_manager_file_id` ASC, `rfi_cost_code_id` ASC, `rfi_creator_contact_id` ASC, `rfi_creator_contact_company_office_id` ASC, `rfi_creator_phone_contact_company_office_phone_number_id` ASC, `rfi_creator_fax_contact_company_office_phone_number_id` ASC, `rfi_creator_contact_mobile_phone_number_id` ASC, `rfi_recipient_contact_id` ASC, `rfi_recipient_contact_company_office_id` ASC, `rfi_recipient_phone_contact_company_office_phone_number_id` ASC, `rfi_recipient_fax_contact_company_office_phone_number_id` ASC, `rfi_recipient_contact_mobile_phone_number_id` ASC, `rfi_initiator_contact_id` ASC, `rfi_initiator_contact_company_office_id` ASC, `rfi_initiator_phone_contact_company_office_phone_number_id` ASC, `rfi_initiator_fax_contact_company_office_phone_number_id` ASC, `rfi_initiator_contact_mobile_phone_number_id` ASC, `rfi_title` ASC, `rfi_plan_page_reference` ASC, `rfi_statement` ASC, `created` ASC, `rfi_due_date` ASC, `rfi_closed_date` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpRequestForInformation = new RequestForInformation($database);
			$sqlOrderByColumns = $tmpRequestForInformation->constructSqlOrderByColumns($arrOrderByAttributes);

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
	rfi.*

FROM `requests_for_information` rfi
WHERE rfi.`rfi_initiator_contact_company_office_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `rfi_sequence_number` ASC, `request_for_information_type_id` ASC, `request_for_information_status_id` ASC, `request_for_information_priority_id` ASC, `rfi_file_manager_file_id` ASC, `rfi_cost_code_id` ASC, `rfi_creator_contact_id` ASC, `rfi_creator_contact_company_office_id` ASC, `rfi_creator_phone_contact_company_office_phone_number_id` ASC, `rfi_creator_fax_contact_company_office_phone_number_id` ASC, `rfi_creator_contact_mobile_phone_number_id` ASC, `rfi_recipient_contact_id` ASC, `rfi_recipient_contact_company_office_id` ASC, `rfi_recipient_phone_contact_company_office_phone_number_id` ASC, `rfi_recipient_fax_contact_company_office_phone_number_id` ASC, `rfi_recipient_contact_mobile_phone_number_id` ASC, `rfi_initiator_contact_id` ASC, `rfi_initiator_contact_company_office_id` ASC, `rfi_initiator_phone_contact_company_office_phone_number_id` ASC, `rfi_initiator_fax_contact_company_office_phone_number_id` ASC, `rfi_initiator_contact_mobile_phone_number_id` ASC, `rfi_title` ASC, `rfi_plan_page_reference` ASC, `rfi_statement` ASC, `created` ASC, `rfi_due_date` ASC, `rfi_closed_date` ASC
		$arrValues = array($rfi_initiator_contact_company_office_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrRequestsForInformationByRfiInitiatorContactCompanyOfficeId = array();
		while ($row = $db->fetch()) {
			$request_for_information_id = $row['id'];
			$requestForInformation = self::instantiateOrm($database, 'RequestForInformation', $row, null, $request_for_information_id);
			/* @var $requestForInformation RequestForInformation */
			$arrRequestsForInformationByRfiInitiatorContactCompanyOfficeId[$request_for_information_id] = $requestForInformation;
		}

		$db->free_result();

		self::$_arrRequestsForInformationByRfiInitiatorContactCompanyOfficeId = $arrRequestsForInformationByRfiInitiatorContactCompanyOfficeId;

		return $arrRequestsForInformationByRfiInitiatorContactCompanyOfficeId;
	}

	/**
	 * Load by constraint `requests_for_information_fk_initiator_phone_ccopn` foreign key (`rfi_initiator_phone_contact_company_office_phone_number_id`) references `contact_company_office_phone_numbers` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $rfi_initiator_phone_contact_company_office_phone_number_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadRequestsForInformationByRfiInitiatorPhoneContactCompanyOfficePhoneNumberId($database, $rfi_initiator_phone_contact_company_office_phone_number_id, Input $options=null)
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
			self::$_arrRequestsForInformationByRfiInitiatorPhoneContactCompanyOfficePhoneNumberId = null;
		}

		$arrRequestsForInformationByRfiInitiatorPhoneContactCompanyOfficePhoneNumberId = self::$_arrRequestsForInformationByRfiInitiatorPhoneContactCompanyOfficePhoneNumberId;
		if (isset($arrRequestsForInformationByRfiInitiatorPhoneContactCompanyOfficePhoneNumberId) && !empty($arrRequestsForInformationByRfiInitiatorPhoneContactCompanyOfficePhoneNumberId)) {
			return $arrRequestsForInformationByRfiInitiatorPhoneContactCompanyOfficePhoneNumberId;
		}

		$rfi_initiator_phone_contact_company_office_phone_number_id = (int) $rfi_initiator_phone_contact_company_office_phone_number_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `rfi_sequence_number` ASC, `request_for_information_type_id` ASC, `request_for_information_status_id` ASC, `request_for_information_priority_id` ASC, `rfi_file_manager_file_id` ASC, `rfi_cost_code_id` ASC, `rfi_creator_contact_id` ASC, `rfi_creator_contact_company_office_id` ASC, `rfi_creator_phone_contact_company_office_phone_number_id` ASC, `rfi_creator_fax_contact_company_office_phone_number_id` ASC, `rfi_creator_contact_mobile_phone_number_id` ASC, `rfi_recipient_contact_id` ASC, `rfi_recipient_contact_company_office_id` ASC, `rfi_recipient_phone_contact_company_office_phone_number_id` ASC, `rfi_recipient_fax_contact_company_office_phone_number_id` ASC, `rfi_recipient_contact_mobile_phone_number_id` ASC, `rfi_initiator_contact_id` ASC, `rfi_initiator_contact_company_office_id` ASC, `rfi_initiator_phone_contact_company_office_phone_number_id` ASC, `rfi_initiator_fax_contact_company_office_phone_number_id` ASC, `rfi_initiator_contact_mobile_phone_number_id` ASC, `rfi_title` ASC, `rfi_plan_page_reference` ASC, `rfi_statement` ASC, `created` ASC, `rfi_due_date` ASC, `rfi_closed_date` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpRequestForInformation = new RequestForInformation($database);
			$sqlOrderByColumns = $tmpRequestForInformation->constructSqlOrderByColumns($arrOrderByAttributes);

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
	rfi.*

FROM `requests_for_information` rfi
WHERE rfi.`rfi_initiator_phone_contact_company_office_phone_number_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `rfi_sequence_number` ASC, `request_for_information_type_id` ASC, `request_for_information_status_id` ASC, `request_for_information_priority_id` ASC, `rfi_file_manager_file_id` ASC, `rfi_cost_code_id` ASC, `rfi_creator_contact_id` ASC, `rfi_creator_contact_company_office_id` ASC, `rfi_creator_phone_contact_company_office_phone_number_id` ASC, `rfi_creator_fax_contact_company_office_phone_number_id` ASC, `rfi_creator_contact_mobile_phone_number_id` ASC, `rfi_recipient_contact_id` ASC, `rfi_recipient_contact_company_office_id` ASC, `rfi_recipient_phone_contact_company_office_phone_number_id` ASC, `rfi_recipient_fax_contact_company_office_phone_number_id` ASC, `rfi_recipient_contact_mobile_phone_number_id` ASC, `rfi_initiator_contact_id` ASC, `rfi_initiator_contact_company_office_id` ASC, `rfi_initiator_phone_contact_company_office_phone_number_id` ASC, `rfi_initiator_fax_contact_company_office_phone_number_id` ASC, `rfi_initiator_contact_mobile_phone_number_id` ASC, `rfi_title` ASC, `rfi_plan_page_reference` ASC, `rfi_statement` ASC, `created` ASC, `rfi_due_date` ASC, `rfi_closed_date` ASC
		$arrValues = array($rfi_initiator_phone_contact_company_office_phone_number_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrRequestsForInformationByRfiInitiatorPhoneContactCompanyOfficePhoneNumberId = array();
		while ($row = $db->fetch()) {
			$request_for_information_id = $row['id'];
			$requestForInformation = self::instantiateOrm($database, 'RequestForInformation', $row, null, $request_for_information_id);
			/* @var $requestForInformation RequestForInformation */
			$arrRequestsForInformationByRfiInitiatorPhoneContactCompanyOfficePhoneNumberId[$request_for_information_id] = $requestForInformation;
		}

		$db->free_result();

		self::$_arrRequestsForInformationByRfiInitiatorPhoneContactCompanyOfficePhoneNumberId = $arrRequestsForInformationByRfiInitiatorPhoneContactCompanyOfficePhoneNumberId;

		return $arrRequestsForInformationByRfiInitiatorPhoneContactCompanyOfficePhoneNumberId;
	}

	/**
	 * Load by constraint `requests_for_information_fk_initiator_fax_ccopn` foreign key (`rfi_initiator_fax_contact_company_office_phone_number_id`) references `contact_company_office_phone_numbers` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $rfi_initiator_fax_contact_company_office_phone_number_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadRequestsForInformationByRfiInitiatorFaxContactCompanyOfficePhoneNumberId($database, $rfi_initiator_fax_contact_company_office_phone_number_id, Input $options=null)
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
			self::$_arrRequestsForInformationByRfiInitiatorFaxContactCompanyOfficePhoneNumberId = null;
		}

		$arrRequestsForInformationByRfiInitiatorFaxContactCompanyOfficePhoneNumberId = self::$_arrRequestsForInformationByRfiInitiatorFaxContactCompanyOfficePhoneNumberId;
		if (isset($arrRequestsForInformationByRfiInitiatorFaxContactCompanyOfficePhoneNumberId) && !empty($arrRequestsForInformationByRfiInitiatorFaxContactCompanyOfficePhoneNumberId)) {
			return $arrRequestsForInformationByRfiInitiatorFaxContactCompanyOfficePhoneNumberId;
		}

		$rfi_initiator_fax_contact_company_office_phone_number_id = (int) $rfi_initiator_fax_contact_company_office_phone_number_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `rfi_sequence_number` ASC, `request_for_information_type_id` ASC, `request_for_information_status_id` ASC, `request_for_information_priority_id` ASC, `rfi_file_manager_file_id` ASC, `rfi_cost_code_id` ASC, `rfi_creator_contact_id` ASC, `rfi_creator_contact_company_office_id` ASC, `rfi_creator_phone_contact_company_office_phone_number_id` ASC, `rfi_creator_fax_contact_company_office_phone_number_id` ASC, `rfi_creator_contact_mobile_phone_number_id` ASC, `rfi_recipient_contact_id` ASC, `rfi_recipient_contact_company_office_id` ASC, `rfi_recipient_phone_contact_company_office_phone_number_id` ASC, `rfi_recipient_fax_contact_company_office_phone_number_id` ASC, `rfi_recipient_contact_mobile_phone_number_id` ASC, `rfi_initiator_contact_id` ASC, `rfi_initiator_contact_company_office_id` ASC, `rfi_initiator_phone_contact_company_office_phone_number_id` ASC, `rfi_initiator_fax_contact_company_office_phone_number_id` ASC, `rfi_initiator_contact_mobile_phone_number_id` ASC, `rfi_title` ASC, `rfi_plan_page_reference` ASC, `rfi_statement` ASC, `created` ASC, `rfi_due_date` ASC, `rfi_closed_date` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpRequestForInformation = new RequestForInformation($database);
			$sqlOrderByColumns = $tmpRequestForInformation->constructSqlOrderByColumns($arrOrderByAttributes);

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
	rfi.*

FROM `requests_for_information` rfi
WHERE rfi.`rfi_initiator_fax_contact_company_office_phone_number_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `rfi_sequence_number` ASC, `request_for_information_type_id` ASC, `request_for_information_status_id` ASC, `request_for_information_priority_id` ASC, `rfi_file_manager_file_id` ASC, `rfi_cost_code_id` ASC, `rfi_creator_contact_id` ASC, `rfi_creator_contact_company_office_id` ASC, `rfi_creator_phone_contact_company_office_phone_number_id` ASC, `rfi_creator_fax_contact_company_office_phone_number_id` ASC, `rfi_creator_contact_mobile_phone_number_id` ASC, `rfi_recipient_contact_id` ASC, `rfi_recipient_contact_company_office_id` ASC, `rfi_recipient_phone_contact_company_office_phone_number_id` ASC, `rfi_recipient_fax_contact_company_office_phone_number_id` ASC, `rfi_recipient_contact_mobile_phone_number_id` ASC, `rfi_initiator_contact_id` ASC, `rfi_initiator_contact_company_office_id` ASC, `rfi_initiator_phone_contact_company_office_phone_number_id` ASC, `rfi_initiator_fax_contact_company_office_phone_number_id` ASC, `rfi_initiator_contact_mobile_phone_number_id` ASC, `rfi_title` ASC, `rfi_plan_page_reference` ASC, `rfi_statement` ASC, `created` ASC, `rfi_due_date` ASC, `rfi_closed_date` ASC
		$arrValues = array($rfi_initiator_fax_contact_company_office_phone_number_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrRequestsForInformationByRfiInitiatorFaxContactCompanyOfficePhoneNumberId = array();
		while ($row = $db->fetch()) {
			$request_for_information_id = $row['id'];
			$requestForInformation = self::instantiateOrm($database, 'RequestForInformation', $row, null, $request_for_information_id);
			/* @var $requestForInformation RequestForInformation */
			$arrRequestsForInformationByRfiInitiatorFaxContactCompanyOfficePhoneNumberId[$request_for_information_id] = $requestForInformation;
		}

		$db->free_result();

		self::$_arrRequestsForInformationByRfiInitiatorFaxContactCompanyOfficePhoneNumberId = $arrRequestsForInformationByRfiInitiatorFaxContactCompanyOfficePhoneNumberId;

		return $arrRequestsForInformationByRfiInitiatorFaxContactCompanyOfficePhoneNumberId;
	}

	/**
	 * Load by constraint `requests_for_information_fk_initiator_c_mobile_cpn` foreign key (`rfi_initiator_contact_mobile_phone_number_id`) references `contact_phone_numbers` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $rfi_initiator_contact_mobile_phone_number_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadRequestsForInformationByRfiInitiatorContactMobilePhoneNumberId($database, $rfi_initiator_contact_mobile_phone_number_id, Input $options=null)
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
			self::$_arrRequestsForInformationByRfiInitiatorContactMobilePhoneNumberId = null;
		}

		$arrRequestsForInformationByRfiInitiatorContactMobilePhoneNumberId = self::$_arrRequestsForInformationByRfiInitiatorContactMobilePhoneNumberId;
		if (isset($arrRequestsForInformationByRfiInitiatorContactMobilePhoneNumberId) && !empty($arrRequestsForInformationByRfiInitiatorContactMobilePhoneNumberId)) {
			return $arrRequestsForInformationByRfiInitiatorContactMobilePhoneNumberId;
		}

		$rfi_initiator_contact_mobile_phone_number_id = (int) $rfi_initiator_contact_mobile_phone_number_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `rfi_sequence_number` ASC, `request_for_information_type_id` ASC, `request_for_information_status_id` ASC, `request_for_information_priority_id` ASC, `rfi_file_manager_file_id` ASC, `rfi_cost_code_id` ASC, `rfi_creator_contact_id` ASC, `rfi_creator_contact_company_office_id` ASC, `rfi_creator_phone_contact_company_office_phone_number_id` ASC, `rfi_creator_fax_contact_company_office_phone_number_id` ASC, `rfi_creator_contact_mobile_phone_number_id` ASC, `rfi_recipient_contact_id` ASC, `rfi_recipient_contact_company_office_id` ASC, `rfi_recipient_phone_contact_company_office_phone_number_id` ASC, `rfi_recipient_fax_contact_company_office_phone_number_id` ASC, `rfi_recipient_contact_mobile_phone_number_id` ASC, `rfi_initiator_contact_id` ASC, `rfi_initiator_contact_company_office_id` ASC, `rfi_initiator_phone_contact_company_office_phone_number_id` ASC, `rfi_initiator_fax_contact_company_office_phone_number_id` ASC, `rfi_initiator_contact_mobile_phone_number_id` ASC, `rfi_title` ASC, `rfi_plan_page_reference` ASC, `rfi_statement` ASC, `created` ASC, `rfi_due_date` ASC, `rfi_closed_date` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpRequestForInformation = new RequestForInformation($database);
			$sqlOrderByColumns = $tmpRequestForInformation->constructSqlOrderByColumns($arrOrderByAttributes);

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
	rfi.*

FROM `requests_for_information` rfi
WHERE rfi.`rfi_initiator_contact_mobile_phone_number_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `rfi_sequence_number` ASC, `request_for_information_type_id` ASC, `request_for_information_status_id` ASC, `request_for_information_priority_id` ASC, `rfi_file_manager_file_id` ASC, `rfi_cost_code_id` ASC, `rfi_creator_contact_id` ASC, `rfi_creator_contact_company_office_id` ASC, `rfi_creator_phone_contact_company_office_phone_number_id` ASC, `rfi_creator_fax_contact_company_office_phone_number_id` ASC, `rfi_creator_contact_mobile_phone_number_id` ASC, `rfi_recipient_contact_id` ASC, `rfi_recipient_contact_company_office_id` ASC, `rfi_recipient_phone_contact_company_office_phone_number_id` ASC, `rfi_recipient_fax_contact_company_office_phone_number_id` ASC, `rfi_recipient_contact_mobile_phone_number_id` ASC, `rfi_initiator_contact_id` ASC, `rfi_initiator_contact_company_office_id` ASC, `rfi_initiator_phone_contact_company_office_phone_number_id` ASC, `rfi_initiator_fax_contact_company_office_phone_number_id` ASC, `rfi_initiator_contact_mobile_phone_number_id` ASC, `rfi_title` ASC, `rfi_plan_page_reference` ASC, `rfi_statement` ASC, `created` ASC, `rfi_due_date` ASC, `rfi_closed_date` ASC
		$arrValues = array($rfi_initiator_contact_mobile_phone_number_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrRequestsForInformationByRfiInitiatorContactMobilePhoneNumberId = array();
		while ($row = $db->fetch()) {
			$request_for_information_id = $row['id'];
			$requestForInformation = self::instantiateOrm($database, 'RequestForInformation', $row, null, $request_for_information_id);
			/* @var $requestForInformation RequestForInformation */
			$arrRequestsForInformationByRfiInitiatorContactMobilePhoneNumberId[$request_for_information_id] = $requestForInformation;
		}

		$db->free_result();

		self::$_arrRequestsForInformationByRfiInitiatorContactMobilePhoneNumberId = $arrRequestsForInformationByRfiInitiatorContactMobilePhoneNumberId;

		return $arrRequestsForInformationByRfiInitiatorContactMobilePhoneNumberId;
	}

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all requests_for_information records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllRequestsForInformation($database, Input $options=null)
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
			self::$_arrAllRequestsForInformation = null;
		}

		$arrAllRequestsForInformation = self::$_arrAllRequestsForInformation;
		if (isset($arrAllRequestsForInformation) && !empty($arrAllRequestsForInformation)) {
			return $arrAllRequestsForInformation;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `rfi_sequence_number` ASC, `request_for_information_type_id` ASC, `request_for_information_status_id` ASC, `request_for_information_priority_id` ASC, `rfi_file_manager_file_id` ASC, `rfi_cost_code_id` ASC, `rfi_creator_contact_id` ASC, `rfi_creator_contact_company_office_id` ASC, `rfi_creator_phone_contact_company_office_phone_number_id` ASC, `rfi_creator_fax_contact_company_office_phone_number_id` ASC, `rfi_creator_contact_mobile_phone_number_id` ASC, `rfi_recipient_contact_id` ASC, `rfi_recipient_contact_company_office_id` ASC, `rfi_recipient_phone_contact_company_office_phone_number_id` ASC, `rfi_recipient_fax_contact_company_office_phone_number_id` ASC, `rfi_recipient_contact_mobile_phone_number_id` ASC, `rfi_initiator_contact_id` ASC, `rfi_initiator_contact_company_office_id` ASC, `rfi_initiator_phone_contact_company_office_phone_number_id` ASC, `rfi_initiator_fax_contact_company_office_phone_number_id` ASC, `rfi_initiator_contact_mobile_phone_number_id` ASC, `rfi_title` ASC, `rfi_plan_page_reference` ASC, `rfi_statement` ASC, `created` ASC, `rfi_due_date` ASC, `rfi_closed_date` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpRequestForInformation = new RequestForInformation($database);
			$sqlOrderByColumns = $tmpRequestForInformation->constructSqlOrderByColumns($arrOrderByAttributes);

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
	rfi.*

FROM `requests_for_information` rfi{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `rfi_sequence_number` ASC, `request_for_information_type_id` ASC, `request_for_information_status_id` ASC, `request_for_information_priority_id` ASC, `rfi_file_manager_file_id` ASC, `rfi_cost_code_id` ASC, `rfi_creator_contact_id` ASC, `rfi_creator_contact_company_office_id` ASC, `rfi_creator_phone_contact_company_office_phone_number_id` ASC, `rfi_creator_fax_contact_company_office_phone_number_id` ASC, `rfi_creator_contact_mobile_phone_number_id` ASC, `rfi_recipient_contact_id` ASC, `rfi_recipient_contact_company_office_id` ASC, `rfi_recipient_phone_contact_company_office_phone_number_id` ASC, `rfi_recipient_fax_contact_company_office_phone_number_id` ASC, `rfi_recipient_contact_mobile_phone_number_id` ASC, `rfi_initiator_contact_id` ASC, `rfi_initiator_contact_company_office_id` ASC, `rfi_initiator_phone_contact_company_office_phone_number_id` ASC, `rfi_initiator_fax_contact_company_office_phone_number_id` ASC, `rfi_initiator_contact_mobile_phone_number_id` ASC, `rfi_title` ASC, `rfi_plan_page_reference` ASC, `rfi_statement` ASC, `created` ASC, `rfi_due_date` ASC, `rfi_closed_date` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllRequestsForInformation = array();
		while ($row = $db->fetch()) {
			$request_for_information_id = $row['id'];
			$requestForInformation = self::instantiateOrm($database, 'RequestForInformation', $row, null, $request_for_information_id);
			/* @var $requestForInformation RequestForInformation */
			$arrAllRequestsForInformation[$request_for_information_id] = $requestForInformation;
		}

		$db->free_result();

		self::$_arrAllRequestsForInformation = $arrAllRequestsForInformation;

		return $arrAllRequestsForInformation;
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
INTO `requests_for_information`
(`project_id`,`contracting_entity_id`, `rfi_sequence_number`, `request_for_information_type_id`, `request_for_information_status_id`, `request_for_information_priority_id`, `rfi_file_manager_file_id`, `rfi_cost_code_id`, `rfi_creator_contact_id`, `rfi_creator_contact_company_office_id`, `rfi_creator_phone_contact_company_office_phone_number_id`, `rfi_creator_fax_contact_company_office_phone_number_id`, `rfi_creator_contact_mobile_phone_number_id`, `rfi_recipient_contact_id`, `rfi_recipient_contact_company_office_id`, `rfi_recipient_phone_contact_company_office_phone_number_id`, `rfi_recipient_fax_contact_company_office_phone_number_id`, `rfi_recipient_contact_mobile_phone_number_id`, `rfi_initiator_contact_id`, `rfi_initiator_contact_company_office_id`, `rfi_initiator_phone_contact_company_office_phone_number_id`, `rfi_initiator_fax_contact_company_office_phone_number_id`, `rfi_initiator_contact_mobile_phone_number_id`, `rfi_title`, `rfi_plan_page_reference`, `rfi_statement`,`tag_ids`, `created`, `rfi_due_date`, `rfi_closed_date`)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
ON DUPLICATE KEY UPDATE `request_for_information_type_id` = ?,`contracting_entity_id` =?, `request_for_information_status_id` = ?, `request_for_information_priority_id` = ?, `rfi_file_manager_file_id` = ?, `rfi_cost_code_id` = ?, `rfi_creator_contact_id` = ?, `rfi_creator_contact_company_office_id` = ?, `rfi_creator_phone_contact_company_office_phone_number_id` = ?, `rfi_creator_fax_contact_company_office_phone_number_id` = ?, `rfi_creator_contact_mobile_phone_number_id` = ?, `rfi_recipient_contact_id` = ?, `rfi_recipient_contact_company_office_id` = ?, `rfi_recipient_phone_contact_company_office_phone_number_id` = ?, `rfi_recipient_fax_contact_company_office_phone_number_id` = ?, `rfi_recipient_contact_mobile_phone_number_id` = ?, `rfi_initiator_contact_id` = ?, `rfi_initiator_contact_company_office_id` = ?, `rfi_initiator_phone_contact_company_office_phone_number_id` = ?, `rfi_initiator_fax_contact_company_office_phone_number_id` = ?, `rfi_initiator_contact_mobile_phone_number_id` = ?, `rfi_title` = ?, `rfi_plan_page_reference` = ?, `rfi_statement` = ?,`tag_ids` =?, `created` = ?, `rfi_due_date` = ?, `rfi_closed_date` = ?
";
		$arrValues = array($this->project_id, $this->contracting_entity_id, $this->rfi_sequence_number, $this->request_for_information_type_id, $this->request_for_information_status_id, $this->request_for_information_priority_id, $this->rfi_file_manager_file_id, $this->rfi_cost_code_id, $this->rfi_creator_contact_id, $this->rfi_creator_contact_company_office_id, $this->rfi_creator_phone_contact_company_office_phone_number_id, $this->rfi_creator_fax_contact_company_office_phone_number_id, $this->rfi_creator_contact_mobile_phone_number_id, $this->rfi_recipient_contact_id, $this->rfi_recipient_contact_company_office_id, $this->rfi_recipient_phone_contact_company_office_phone_number_id, $this->rfi_recipient_fax_contact_company_office_phone_number_id, $this->rfi_recipient_contact_mobile_phone_number_id, $this->rfi_initiator_contact_id, $this->rfi_initiator_contact_company_office_id, $this->rfi_initiator_phone_contact_company_office_phone_number_id, $this->rfi_initiator_fax_contact_company_office_phone_number_id, $this->rfi_initiator_contact_mobile_phone_number_id, $this->rfi_title, $this->rfi_plan_page_reference, $this->rfi_statement,$this->tag_ids, $this->created, $this->rfi_due_date, $this->rfi_closed_date, $this->request_for_information_type_id, $this->request_for_information_status_id, $this->request_for_information_priority_id, $this->rfi_file_manager_file_id, $this->rfi_cost_code_id, $this->rfi_creator_contact_id, $this->rfi_creator_contact_company_office_id, $this->rfi_creator_phone_contact_company_office_phone_number_id, $this->rfi_creator_fax_contact_company_office_phone_number_id, $this->rfi_creator_contact_mobile_phone_number_id, $this->rfi_recipient_contact_id, $this->rfi_recipient_contact_company_office_id, $this->rfi_recipient_phone_contact_company_office_phone_number_id, $this->rfi_recipient_fax_contact_company_office_phone_number_id, $this->rfi_recipient_contact_mobile_phone_number_id, $this->rfi_initiator_contact_id, $this->rfi_initiator_contact_company_office_id, $this->rfi_initiator_phone_contact_company_office_phone_number_id, $this->rfi_initiator_fax_contact_company_office_phone_number_id, $this->rfi_initiator_contact_mobile_phone_number_id, $this->rfi_title, $this->rfi_plan_page_reference, $this->rfi_statement, $this->tag_ids,$this->created, $this->rfi_due_date, $this->rfi_closed_date);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$request_for_information_id = $db->insertId;
		$db->free_result();

		return $request_for_information_id;
	}

	// Save: insert ignore

	/**
	 * Find next_rfi_sequence_number value.
	 *
	 * @param string $database
	 * @param int $project_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findNextRFISequenceNumber($database, $project_id)
	{
		$next_rfi_sequence_number = 1;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT MAX(rfi.rfi_sequence_number) AS 'max_rfi_sequence_number'
FROM `requests_for_information` rfi
WHERE rfi.`project_id` = ?
";
		$arrValues = array($project_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$max_rfi_sequence_number = $row['max_rfi_sequence_number'];
			$next_rfi_sequence_number = $max_rfi_sequence_number + 1;
		}

		return $next_rfi_sequence_number;
	}

	public static function RequestForInformationProject($database,$request_for_information_id)
	{
			$db = DBI::getInstance($database);
		    $query = "SELECT p.project_name, uc.company, rfi.* 
FROM `requests_for_information` rfi
INNER JOIN `projects` p ON `p`.`id` = rfi.`project_id`
Inner Join `user_companies` uc ON uc.id = `p`.`user_company_id`
WHERE rfi.id= ?
";

		$arrValues = array($request_for_information_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		return $row;


	}

	// Loaders: Load All Records
	/**
	 * Load all requests_for_information records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllRequestsForInformationForTaskSummaryApi($database, $project_id, $user_id, $userRole, $projManager, Input $options=null)
	{
		$forceLoadFlag = false;
		$fromCase="`requests_for_information` rfi";
		$selectCase = "
		rfi.*
		";
		$arrValues = array();
		$whereConAdd= "rfi.`project_id` = ?";
		$arrValues[] = $project_id;
		$returnType = '';
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
			self::$_arrAllRequestsForInformation = null;
		}

		$arrAllRequestsForInformation = self::$_arrAllRequestsForInformation;
		if (isset($arrAllRequestsForInformation) && !empty($arrAllRequestsForInformation)) {
			return $arrAllRequestsForInformation;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */
		$db->free_result();
		$sqlOrderBy = "\nORDER BY";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpRequestForInformation = new RequestForInformation($database);
			$sqlOrderByColumns = $tmpRequestForInformation->constructSqlOrderByColumns($arrOrderByAttributes);

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

		// where condition with user
		$userBased = $options->userBased;
		if($userBased) {
			$whereConAdd .= " AND c.`user_id` = ?";
			$fromCase = "
			`contacts` as c
			INNER JOIN `requests_for_information` as rfi
				ON rfi.`rfi_recipient_contact_id` = c.`id` 
			";
			$arrValues[] = $user_id;
			$selectCase = "
			rfi.*,
			c.`id` AS 'c__contact_id',
			c.`user_company_id` AS 'c__user_company_id',
			c.`user_id` AS 'c__user_id',
			c.`contact_company_id` AS 'c__contact_company_id',
			c.`email` AS 'c__email',
			c.`name_prefix` AS 'c__name_prefix',
			c.`first_name` AS 'c__first_name',
			c.`additional_name` AS 'c__additional_name',
			c.`middle_name` AS 'c__middle_name',
			c.`last_name` AS 'c__last_name',
			c.`name_suffix` AS 'c__name_suffix',
			c.`title` AS 'c__title',
			c.`vendor_flag` AS 'c__vendor_flag'
			";
		}
		// where due date by format
		$dateDifferBW = $options->dateDifferBW;
		if($dateDifferBW) {
			$dateDifferFormatType = $options->dateDifferFormatType;
			$filter_completed_date = null;
			if ($options->filter_completed_date) {
				$filter_completed_date = $options->filter_completed_date;	
			}
			switch($dateDifferFormatType) {
				// 0 - 7 days without completed
				case 1:
				$mindueDate = date('Y-m-d');
				$maxDueDate	= date('Y-m-d', strtotime('+7 days'));
				$compDate = '0000-00-00 00:00:00';
				$whereConAdd .= " AND date(rfi.`rfi_due_date`) >= ? AND date(rfi.`rfi_due_date`) <= ? AND ( rfi.`rfi_closed_date` IS NULL )";
				$arrValues[] = $mindueDate;
				$arrValues[] = $maxDueDate;
				$sqlOrderBy .= $sqlOrderBy != "\nORDER BY" ? ',' : '';
				$sqlOrderBy .= ' rfi.`rfi_due_date` IS NULL ASC, rfi.`rfi_due_date` ASC';
				break;
				// 7 - 15 days without completed
				case 2:
				$mindueDate = date('Y-m-d', strtotime('+8 days'));
				$maxDueDate	= date('Y-m-d', strtotime('+15 days'));
				$compDate = '0000-00-00 00:00:00';
				$whereConAdd .= " AND date(rfi.`rfi_due_date`) > ? AND date(rfi.`rfi_due_date`) <= ? AND (  rfi.`rfi_closed_date` IS NULL )";
				$arrValues[] = $mindueDate;
				$arrValues[] = $maxDueDate;
				$sqlOrderBy .= $sqlOrderBy != "\nORDER BY" ? ',' : '';
				$sqlOrderBy .= ' rfi.`rfi_due_date` IS NULL ASC, rfi.`rfi_due_date` ASC';
				break;
				// overdue without completed
				case 3:
				$mindueDate = date('Y-m-d');
				$maxDueDate	= date('Y-m-d', strtotime('+0 days'));
				$compDate = '0000-00-00 00:00:00';
				$whereConAdd .= " AND date(rfi.`rfi_due_date`) < ? AND (  rfi.`rfi_closed_date` IS NULL )";
				$arrValues[] = $mindueDate;
				$sqlOrderBy .= $sqlOrderBy != "\nORDER BY" ? ',' : '';
				$sqlOrderBy .= ' rfi.`rfi_due_date` IS NULL ASC, rfi.`rfi_due_date` ASC';
				break;
				// TBD without completed
				case 4:
				$mindueDate = '0000-00-00 00:00:00';
				$compDate = '0000-00-00 00:00:00';
				$whereConAdd .= " AND ( rfi.`rfi_due_date` IS NULL OR rfi.`rfi_due_date` = ? ) AND ( rfi.`rfi_closed_date` IS NULL )";
				$arrValues[] = $mindueDate;
				$sqlOrderBy .= $sqlOrderBy != "\nORDER BY" ? ',' : '';
				$sqlOrderBy .= ' rfi.`rfi_due_date` IS NULL ASC, rfi.`rfi_due_date` ASC';
				break;
				// completed
				case 5:
				$compDate = '0000-00-00 00:00:00';
				if ($filter_completed_date) {
					$whereConAdd .= " AND date(rfi.`rfi_closed_date`) = ? ";
					$arrValues[] = $filter_completed_date;
				} else {
					$whereConAdd .= " AND ( rfi.`rfi_closed_date` IS NOT NULL  )";
				}
				$sqlOrderBy .= $sqlOrderBy != "\nORDER BY" ? ',' : '';
				$sqlOrderBy .= ' rfi.`rfi_closed_date` DESC';
				break;
				// all without completed
				default:
				$compDate = '0000-00-00 00:00:00';
				$whereConAdd .= " AND ( rfi.`rfi_closed_date` IS NULL )";
				$sqlOrderBy .= $sqlOrderBy != "\nORDER BY" ? ',' : '';
				$sqlOrderBy .= ' rfi.`rfi_due_date` IS NULL ASC, rfi.`rfi_due_date` ASC';
				break;
			}
		}
		// return type count
		$returnType = $options->returnType;
		if($returnType == 'Count') {
			$selectCase = "count(rfi.`id`) as total";
		}

		if($returnType != 'Count' && !$userBased) {
			$fromCase = "
			`contacts` as c
			INNER JOIN `requests_for_information` as rfi
				ON rfi.`rfi_recipient_contact_id` = c.`id` 
			";
			$selectCase = "
			rfi.*,
			c.`id` AS 'c__contact_id',
			c.`user_company_id` AS 'c__user_company_id',
			c.`user_id` AS 'c__user_id',
			c.`contact_company_id` AS 'c__contact_company_id',
			c.`email` AS 'c__email',
			c.`name_prefix` AS 'c__name_prefix',
			c.`first_name` AS 'c__first_name',
			c.`additional_name` AS 'c__additional_name',
			c.`middle_name` AS 'c__middle_name',
			c.`last_name` AS 'c__last_name',
			c.`name_suffix` AS 'c__name_suffix',
			c.`title` AS 'c__title',
			c.`vendor_flag` AS 'c__vendor_flag'
			";
		}

		$query =
"
SELECT
	{$selectCase}
FROM {$fromCase}
WHERE {$whereConAdd}
{$sqlOrderBy}{$sqlLimit}
";
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrAllRequestsForInformation = array();
		if($returnType == '') {
			while ($row = $db->fetch()) {
				$request_for_information_id = $row['id'];
				$requestForInformation = self::instantiateOrm($database, 'RequestForInformation', $row, null, $request_for_information_id);
				if (isset($row['rfi_recipient_contact_id'])) {
					$rfi_recipient_contact_id = $row['rfi_recipient_contact_id'];
					$row['c__id'] = $rfi_recipient_contact_id;
					$rfiRecipientContact = self::instantiateOrm($database, 'Contact', $row, null, $rfi_recipient_contact_id, 'c__');
					/* @var $rfiRecipientContact Contact */
					$rfiRecipientContact->convertPropertiesToData();
					$recipient = array($rfiRecipientContact->getContactFullNameHtmlEscaped());
				} else {
					$rfiRecipientContact = false;
					$recipient = null;
				}
				/* @var $requestForInformation RequestForInformation */
				$arrAllRequestsForInformation[$request_for_information_id]['item_title'] = $requestForInformation->rfi_title;
				$arrAllRequestsForInformation[$request_for_information_id]['item_id'] = $requestForInformation->request_for_information_id;
				// due date convert
				if ($requestForInformation->rfi_due_date != '0000-00-00' && $requestForInformation->rfi_due_date != Null) {
					$arrAllRequestsForInformation[$request_for_information_id]['item_due_date'] = date('m/d/Y', strtotime($requestForInformation->rfi_due_date));
				} else {
					$arrAllRequestsForInformation[$request_for_information_id]['item_due_date'] = '-';
				}
				// closed date convert
				if ($requestForInformation->rfi_closed_date != '0000-00-00' && $requestForInformation->rfi_closed_date != Null) {
					$arrAllRequestsForInformation[$request_for_information_id]['item_completed_date'] = date('m/d/Y', strtotime($requestForInformation->rfi_closed_date));
				} else {
					$arrAllRequestsForInformation[$request_for_information_id]['item_completed_date'] = '-';
				}
				if (!$userBased) {
					$arrAllRequestsForInformation[$request_for_information_id]['item_assignees'] = $recipient;
				} else {
					$arrAllRequestsForInformation[$request_for_information_id]['item_assignees'] = null;
				}
				// check date format type
				$date_format_type = 0;
				if ($arrAllRequestsForInformation[$request_for_information_id]['item_due_date'] != '-') {
					$due_date_str = strtotime(date('Y-m-d',strtotime($arrAllRequestsForInformation[$request_for_information_id]['item_due_date'])));
					$cur_date_str = strtotime(date('Y-m-d'));
					$seven_date_str = strtotime(date('Y-m-d', strtotime('+7 days')));
					$eight_date_str = strtotime(date('Y-m-d', strtotime('+8 days')));
					$fifteen_date_str = strtotime(date('Y-m-d', strtotime('+15 days')));
					if ($due_date_str <= $seven_date_str) {
						$date_format_type = 1;
					}
					if ($due_date_str >= $eight_date_str && $due_date_str <= $fifteen_date_str) {
						$date_format_type = 2;
					}
					if ($due_date_str < $cur_date_str) {
						$date_format_type = 3;
					}
				}
				$arrAllRequestsForInformation[$request_for_information_id]['date_format_type'] = $date_format_type;
			}
		} else {
			$row = $db->fetch();
			return $row;
		}
		$db->free_result();

		self::$_arrAllRequestsForInformation = $arrAllRequestsForInformation;

		return $arrAllRequestsForInformation;
	}


	// rfi array for task summary
	public static function loadDiscussionItemsByProjectUserId($database, $project_id, $user_id,$userRole, $projManager, Input $options=null){

		$project_id = (int) $project_id;
		$user_id = (int) $user_id;

		$db = DBI::getInstance($database);

		$sqlOrderBy = "\nORDER BY rfi.`id` DESC";
		if(!empty($options['sort_task'])){
			$sqlOrderBy = $options['sort_task'];
		}

		$groupby = 'GROUP BY rfinot.`id`';
		$sqlcond = array();

		if(!empty($userRole) && !empty($projManager)){
			$sqlcond[] = "rfi.`project_id` = ?";
			$arrValues = array($project_id);
		}else if(!empty($userRole) && ($userRole =='user' || $userRole == 'admin')){
			$sqlcond[] = "rfi.`project_id` = ? ";

			$sqlcond[] = " 	( 
								`rfi`.`rfi_recipient_contact_id` = ? 
							OR 
								`rfi`.`id` IN (
									SELECT `rfin`.`request_for_information_id` FROM 
										`request_for_information_notifications` `rfin` 
									INNER JOIN request_for_information_recipients as `rfir` 
										ON `rfir`.`request_for_information_notification_id` = `rfin`.`id` 
									WHERE `rfir`.`rfi_additional_recipient_contact_id` = ? AND `rfir`.`smtp_recipient_header_type` = ? 
								) 
							)";
			$arrValues = array($project_id, $user_id, $user_id, 'To');
		}

		if(!empty($options['conditions'])){

			if(!empty($options['conditions']['assigned_to'])){

				$contactquery = "SELECT `contacts`.`id`,`contacts`.`user_id`,`contacts`.`email`,`contacts`.`first_name`,`contacts`.`last_name` FROM  `contacts`  WHERE `contacts`.`email` LIKE ?
				OR  `contacts`.`first_name` LIKE ? OR  `contacts`.`last_name` LIKE ?";

				$arr_contValues = array('%'.$options['conditions']['assigned_to'].'%','%'.$options['conditions']['assigned_to'].'%','%'.$options['conditions']['assigned_to'].'%');
				$db->execute($contactquery, $arr_contValues, MYSQLI_USE_RESULT);

				$user_id_arr = array();
				while($cont_row = $db->fetch()){
					$user_id_arr[] = $cont_row['id'];
				}
				if(!empty($user_id_arr)){
					$sqlcond[] = " con.`id` IN (".implode(',',$user_id_arr).")"; 
				}
				$db->free_result();
			}

			if(!empty($options['conditions']['task'])){
				$sqlcond[] = "rfi.`rfi_title` LIKE ?";
				$arrValues[] =  '%'.$options['conditions']['task'].'%';
			}

			if(!empty($options['conditions']['due_date'])){
				$sqlcond[] = "rfi.`rfi_due_date` = ?";
				$due_date = DateTime::createFromFormat("m/d/Y" , $options['conditions']['due_date']);
				$arrValues[] =  $due_date->format('Y-m-d');
			}

			if(!empty($options['conditions']['discussion'])){
				$sqlcond[] = "rfi.`rfi_statement` LIKE ?";
				$arrValues[] =  '%'.$options['conditions']['discussion'].'%';
			}

			if(!empty($options['conditions']['complete_date']) && $options['conditions']['complete_date'] =='uncomplete'){
				$arrValues[] = '4';
				$sqlcond[] = "rfi.`request_for_information_status_id` = ?";
			}else{
				$arrValues[] = '2';
				$sqlcond[] = "rfi.`request_for_information_status_id` = ?";
			}

		}else{
			$arrValues[] = '2';
			$sqlcond[] = "rfi.`request_for_information_status_id` = ?";
		}
		if(!empty($sqlcond)){
			$sqlcond = implode(' AND ', $sqlcond);
		}

		$query = "SELECT rfi.*,GROUP_CONCAT(con.`id`) as ac_id
				FROM `requests_for_information` rfi
				INNER JOIN `request_for_information_notifications` rfinot ON rfinot.`request_for_information_id` = rfi.`id`
				INNER JOIN request_for_information_recipients rfirl ON rfirl.`request_for_information_notification_id` = rfinot.`id` 
				INNER JOIN `contacts` con ON `rfirl`.rfi_additional_recipient_contact_id = `con`.id 
				WHERE  rfirl.`smtp_recipient_header_type` = 'To' {$groupby} {$sqlOrderBy}";		

		
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrDiscussionItemsByMeetingId = array();
		while($row = $db->fetch()){
			$arrDiscussionItemsByMeetingId[] = $row;
		}
		$db->free_result();
		return $arrDiscussionItemsByMeetingId;
	}
	/**
	 * Load by constraint `requests_for_information_fk_rfis` foreign key (`request_for_information_status`) references `request_for_information_statuses` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $request_for_information_status_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadRequestsForInformationByRequestForInformationStatusAndProjectId($database, $project_id, $request_for_information_status, Input $options=null)
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
			self::$_arrRequestsForInformationByRequestForInformationStatusId = null;
		}

		$arrRequestsForInformationByRequestForInformationStatusId = self::$_arrRequestsForInformationByRequestForInformationStatusId;
		if (isset($arrRequestsForInformationByRequestForInformationStatusId) && !empty($arrRequestsForInformationByRequestForInformationStatusId)) {
			return $arrRequestsForInformationByRequestForInformationStatusId;
		}

		$project_id = (int) $project_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpRequestForInformation = new RequestForInformation($database);
			$sqlOrderByColumns = $tmpRequestForInformation->constructSqlOrderByColumns($arrOrderByAttributes);

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
	rfi.*

FROM `requests_for_information` rfi 
INNER JOIN `request_for_information_statuses` AS rfis ON rfi.`request_for_information_status_id` = rfis.`id`
WHERE rfis.`request_for_information_status` = ? AND rfi.`project_id` = ?
{$sqlOrderBy}{$sqlLimit}
";

		$arrValues = array($request_for_information_status, $project_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrRequestsForInformationByRequestForInformationStatusId = array();
		while ($row = $db->fetch()) {
			$request_for_information_id = $row['id'];
			$request_for_information_title = $row['rfi_title'];
			// $requestForInformation = self::instantiateOrm($database, 'RequestForInformation', $row, null, $request_for_information_id);
			/* @var $requestForInformation RequestForInformation */
			$arrRequestsForInformationByRequestForInformationStatusId[$request_for_information_id]['id'] = $request_for_information_id;
			$arrRequestsForInformationByRequestForInformationStatusId[$request_for_information_id]['name'] = $request_for_information_title;
			$arrRequestsForInformationByRequestForInformationStatusId[$request_for_information_id]['checked'] = false;
		}

		$db->free_result();

		return $arrRequestsForInformationByRequestForInformationStatusId;
	}
	// To get the recipient list of previous RFI id
	public static function getpreviousrecpientList($database,$project_id){

		$db = DBI::getInstance($database);
		$query =" SELECT id from requests_for_information where project_id =? and rfi_sequence_number =( SELECT max(rfi_sequence_number) as max FROM `requests_for_information` WHERE project_id =? )";
		$arrValues = array($project_id,$project_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$rfi_id =$row['id'];
		$db->free_result();
		return $rfi_id;

	}
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

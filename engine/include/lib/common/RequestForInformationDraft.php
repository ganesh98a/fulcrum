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
 * RequestForInformationDraft.
 *
 * @category   Framework
 * @package    RequestForInformationDraft
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class RequestForInformationDraft extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'RequestForInformationDraft';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'request_for_information_drafts';

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
	 * No Unique Indexes, Just a Primary Key
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_request_for_information_draft_via_primary_key' => array(
			'request_for_information_draft_id' => 'int'
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
		'id' => 'request_for_information_draft_id',

		'project_id' => 'project_id',
		'request_for_information_type_id' => 'request_for_information_type_id',
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
		'tag_ids' => 'tag_ids',
		'rfi_due_date' => 'rfi_due_date'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $request_for_information_draft_id;

	public $project_id;
	public $request_for_information_type_id;
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
	public $tag_ids;
	public $rfi_due_date;

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
	protected static $_arrRequestForInformationDraftsByProjectId;
	protected static $_arrRequestForInformationDraftsByRequestForInformationTypeId;
	protected static $_arrRequestForInformationDraftsByRequestForInformationPriorityId;
	protected static $_arrRequestForInformationDraftsByRfiFileManagerFileId;
	protected static $_arrRequestForInformationDraftsByRfiCostCodeId;
	protected static $_arrRequestForInformationDraftsByRfiCreatorContactId;
	protected static $_arrRequestForInformationDraftsByRfiCreatorContactCompanyOfficeId;
	protected static $_arrRequestForInformationDraftsByRfiCreatorPhoneContactCompanyOfficePhoneNumberId;
	protected static $_arrRequestForInformationDraftsByRfiCreatorFaxContactCompanyOfficePhoneNumberId;
	protected static $_arrRequestForInformationDraftsByRfiCreatorContactMobilePhoneNumberId;
	protected static $_arrRequestForInformationDraftsByRfiRecipientContactId;
	protected static $_arrRequestForInformationDraftsByRfiRecipientContactCompanyOfficeId;
	protected static $_arrRequestForInformationDraftsByRfiRecipientPhoneContactCompanyOfficePhoneNumberId;
	protected static $_arrRequestForInformationDraftsByRfiRecipientFaxContactCompanyOfficePhoneNumberId;
	protected static $_arrRequestForInformationDraftsByRfiRecipientContactMobilePhoneNumberId;
	protected static $_arrRequestForInformationDraftsByRfiInitiatorContactId;
	protected static $_arrRequestForInformationDraftsByRfiInitiatorContactCompanyOfficeId;
	protected static $_arrRequestForInformationDraftsByRfiInitiatorPhoneContactCompanyOfficePhoneNumberId;
	protected static $_arrRequestForInformationDraftsByRfiInitiatorFaxContactCompanyOfficePhoneNumberId;
	protected static $_arrRequestForInformationDraftsByRfiInitiatorContactMobilePhoneNumberId;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllRequestForInformationDrafts;

	// Foreign Key Objects
	private $_project;
	private $_requestForInformationType;
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
	public function __construct($database, $table='request_for_information_drafts')
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
	public static function getArrRequestForInformationDraftsByProjectId()
	{
		if (isset(self::$_arrRequestForInformationDraftsByProjectId)) {
			return self::$_arrRequestForInformationDraftsByProjectId;
		} else {
			return null;
		}
	}

	public static function setArrRequestForInformationDraftsByProjectId($arrRequestForInformationDraftsByProjectId)
	{
		self::$_arrRequestForInformationDraftsByProjectId = $arrRequestForInformationDraftsByProjectId;
	}

	public static function getArrRequestForInformationDraftsByRequestForInformationTypeId()
	{
		if (isset(self::$_arrRequestForInformationDraftsByRequestForInformationTypeId)) {
			return self::$_arrRequestForInformationDraftsByRequestForInformationTypeId;
		} else {
			return null;
		}
	}

	public static function setArrRequestForInformationDraftsByRequestForInformationTypeId($arrRequestForInformationDraftsByRequestForInformationTypeId)
	{
		self::$_arrRequestForInformationDraftsByRequestForInformationTypeId = $arrRequestForInformationDraftsByRequestForInformationTypeId;
	}

	public static function getArrRequestForInformationDraftsByRequestForInformationPriorityId()
	{
		if (isset(self::$_arrRequestForInformationDraftsByRequestForInformationPriorityId)) {
			return self::$_arrRequestForInformationDraftsByRequestForInformationPriorityId;
		} else {
			return null;
		}
	}

	public static function setArrRequestForInformationDraftsByRequestForInformationPriorityId($arrRequestForInformationDraftsByRequestForInformationPriorityId)
	{
		self::$_arrRequestForInformationDraftsByRequestForInformationPriorityId = $arrRequestForInformationDraftsByRequestForInformationPriorityId;
	}

	public static function getArrRequestForInformationDraftsByRfiFileManagerFileId()
	{
		if (isset(self::$_arrRequestForInformationDraftsByRfiFileManagerFileId)) {
			return self::$_arrRequestForInformationDraftsByRfiFileManagerFileId;
		} else {
			return null;
		}
	}

	public static function setArrRequestForInformationDraftsByRfiFileManagerFileId($arrRequestForInformationDraftsByRfiFileManagerFileId)
	{
		self::$_arrRequestForInformationDraftsByRfiFileManagerFileId = $arrRequestForInformationDraftsByRfiFileManagerFileId;
	}

	public static function getArrRequestForInformationDraftsByRfiCostCodeId()
	{
		if (isset(self::$_arrRequestForInformationDraftsByRfiCostCodeId)) {
			return self::$_arrRequestForInformationDraftsByRfiCostCodeId;
		} else {
			return null;
		}
	}

	public static function setArrRequestForInformationDraftsByRfiCostCodeId($arrRequestForInformationDraftsByRfiCostCodeId)
	{
		self::$_arrRequestForInformationDraftsByRfiCostCodeId = $arrRequestForInformationDraftsByRfiCostCodeId;
	}

	public static function getArrRequestForInformationDraftsByRfiCreatorContactId()
	{
		if (isset(self::$_arrRequestForInformationDraftsByRfiCreatorContactId)) {
			return self::$_arrRequestForInformationDraftsByRfiCreatorContactId;
		} else {
			return null;
		}
	}

	public static function setArrRequestForInformationDraftsByRfiCreatorContactId($arrRequestForInformationDraftsByRfiCreatorContactId)
	{
		self::$_arrRequestForInformationDraftsByRfiCreatorContactId = $arrRequestForInformationDraftsByRfiCreatorContactId;
	}

	public static function getArrRequestForInformationDraftsByRfiCreatorContactCompanyOfficeId()
	{
		if (isset(self::$_arrRequestForInformationDraftsByRfiCreatorContactCompanyOfficeId)) {
			return self::$_arrRequestForInformationDraftsByRfiCreatorContactCompanyOfficeId;
		} else {
			return null;
		}
	}

	public static function setArrRequestForInformationDraftsByRfiCreatorContactCompanyOfficeId($arrRequestForInformationDraftsByRfiCreatorContactCompanyOfficeId)
	{
		self::$_arrRequestForInformationDraftsByRfiCreatorContactCompanyOfficeId = $arrRequestForInformationDraftsByRfiCreatorContactCompanyOfficeId;
	}

	public static function getArrRequestForInformationDraftsByRfiCreatorPhoneContactCompanyOfficePhoneNumberId()
	{
		if (isset(self::$_arrRequestForInformationDraftsByRfiCreatorPhoneContactCompanyOfficePhoneNumberId)) {
			return self::$_arrRequestForInformationDraftsByRfiCreatorPhoneContactCompanyOfficePhoneNumberId;
		} else {
			return null;
		}
	}

	public static function setArrRequestForInformationDraftsByRfiCreatorPhoneContactCompanyOfficePhoneNumberId($arrRequestForInformationDraftsByRfiCreatorPhoneContactCompanyOfficePhoneNumberId)
	{
		self::$_arrRequestForInformationDraftsByRfiCreatorPhoneContactCompanyOfficePhoneNumberId = $arrRequestForInformationDraftsByRfiCreatorPhoneContactCompanyOfficePhoneNumberId;
	}

	public static function getArrRequestForInformationDraftsByRfiCreatorFaxContactCompanyOfficePhoneNumberId()
	{
		if (isset(self::$_arrRequestForInformationDraftsByRfiCreatorFaxContactCompanyOfficePhoneNumberId)) {
			return self::$_arrRequestForInformationDraftsByRfiCreatorFaxContactCompanyOfficePhoneNumberId;
		} else {
			return null;
		}
	}

	public static function setArrRequestForInformationDraftsByRfiCreatorFaxContactCompanyOfficePhoneNumberId($arrRequestForInformationDraftsByRfiCreatorFaxContactCompanyOfficePhoneNumberId)
	{
		self::$_arrRequestForInformationDraftsByRfiCreatorFaxContactCompanyOfficePhoneNumberId = $arrRequestForInformationDraftsByRfiCreatorFaxContactCompanyOfficePhoneNumberId;
	}

	public static function getArrRequestForInformationDraftsByRfiCreatorContactMobilePhoneNumberId()
	{
		if (isset(self::$_arrRequestForInformationDraftsByRfiCreatorContactMobilePhoneNumberId)) {
			return self::$_arrRequestForInformationDraftsByRfiCreatorContactMobilePhoneNumberId;
		} else {
			return null;
		}
	}

	public static function setArrRequestForInformationDraftsByRfiCreatorContactMobilePhoneNumberId($arrRequestForInformationDraftsByRfiCreatorContactMobilePhoneNumberId)
	{
		self::$_arrRequestForInformationDraftsByRfiCreatorContactMobilePhoneNumberId = $arrRequestForInformationDraftsByRfiCreatorContactMobilePhoneNumberId;
	}

	public static function getArrRequestForInformationDraftsByRfiRecipientContactId()
	{
		if (isset(self::$_arrRequestForInformationDraftsByRfiRecipientContactId)) {
			return self::$_arrRequestForInformationDraftsByRfiRecipientContactId;
		} else {
			return null;
		}
	}

	public static function setArrRequestForInformationDraftsByRfiRecipientContactId($arrRequestForInformationDraftsByRfiRecipientContactId)
	{
		self::$_arrRequestForInformationDraftsByRfiRecipientContactId = $arrRequestForInformationDraftsByRfiRecipientContactId;
	}

	public static function getArrRequestForInformationDraftsByRfiRecipientContactCompanyOfficeId()
	{
		if (isset(self::$_arrRequestForInformationDraftsByRfiRecipientContactCompanyOfficeId)) {
			return self::$_arrRequestForInformationDraftsByRfiRecipientContactCompanyOfficeId;
		} else {
			return null;
		}
	}

	public static function setArrRequestForInformationDraftsByRfiRecipientContactCompanyOfficeId($arrRequestForInformationDraftsByRfiRecipientContactCompanyOfficeId)
	{
		self::$_arrRequestForInformationDraftsByRfiRecipientContactCompanyOfficeId = $arrRequestForInformationDraftsByRfiRecipientContactCompanyOfficeId;
	}

	public static function getArrRequestForInformationDraftsByRfiRecipientPhoneContactCompanyOfficePhoneNumberId()
	{
		if (isset(self::$_arrRequestForInformationDraftsByRfiRecipientPhoneContactCompanyOfficePhoneNumberId)) {
			return self::$_arrRequestForInformationDraftsByRfiRecipientPhoneContactCompanyOfficePhoneNumberId;
		} else {
			return null;
		}
	}

	public static function setArrRequestForInformationDraftsByRfiRecipientPhoneContactCompanyOfficePhoneNumberId($arrRequestForInformationDraftsByRfiRecipientPhoneContactCompanyOfficePhoneNumberId)
	{
		self::$_arrRequestForInformationDraftsByRfiRecipientPhoneContactCompanyOfficePhoneNumberId = $arrRequestForInformationDraftsByRfiRecipientPhoneContactCompanyOfficePhoneNumberId;
	}

	public static function getArrRequestForInformationDraftsByRfiRecipientFaxContactCompanyOfficePhoneNumberId()
	{
		if (isset(self::$_arrRequestForInformationDraftsByRfiRecipientFaxContactCompanyOfficePhoneNumberId)) {
			return self::$_arrRequestForInformationDraftsByRfiRecipientFaxContactCompanyOfficePhoneNumberId;
		} else {
			return null;
		}
	}

	public static function setArrRequestForInformationDraftsByRfiRecipientFaxContactCompanyOfficePhoneNumberId($arrRequestForInformationDraftsByRfiRecipientFaxContactCompanyOfficePhoneNumberId)
	{
		self::$_arrRequestForInformationDraftsByRfiRecipientFaxContactCompanyOfficePhoneNumberId = $arrRequestForInformationDraftsByRfiRecipientFaxContactCompanyOfficePhoneNumberId;
	}

	public static function getArrRequestForInformationDraftsByRfiRecipientContactMobilePhoneNumberId()
	{
		if (isset(self::$_arrRequestForInformationDraftsByRfiRecipientContactMobilePhoneNumberId)) {
			return self::$_arrRequestForInformationDraftsByRfiRecipientContactMobilePhoneNumberId;
		} else {
			return null;
		}
	}

	public static function setArrRequestForInformationDraftsByRfiRecipientContactMobilePhoneNumberId($arrRequestForInformationDraftsByRfiRecipientContactMobilePhoneNumberId)
	{
		self::$_arrRequestForInformationDraftsByRfiRecipientContactMobilePhoneNumberId = $arrRequestForInformationDraftsByRfiRecipientContactMobilePhoneNumberId;
	}

	public static function getArrRequestForInformationDraftsByRfiInitiatorContactId()
	{
		if (isset(self::$_arrRequestForInformationDraftsByRfiInitiatorContactId)) {
			return self::$_arrRequestForInformationDraftsByRfiInitiatorContactId;
		} else {
			return null;
		}
	}

	public static function setArrRequestForInformationDraftsByRfiInitiatorContactId($arrRequestForInformationDraftsByRfiInitiatorContactId)
	{
		self::$_arrRequestForInformationDraftsByRfiInitiatorContactId = $arrRequestForInformationDraftsByRfiInitiatorContactId;
	}

	public static function getArrRequestForInformationDraftsByRfiInitiatorContactCompanyOfficeId()
	{
		if (isset(self::$_arrRequestForInformationDraftsByRfiInitiatorContactCompanyOfficeId)) {
			return self::$_arrRequestForInformationDraftsByRfiInitiatorContactCompanyOfficeId;
		} else {
			return null;
		}
	}

	public static function setArrRequestForInformationDraftsByRfiInitiatorContactCompanyOfficeId($arrRequestForInformationDraftsByRfiInitiatorContactCompanyOfficeId)
	{
		self::$_arrRequestForInformationDraftsByRfiInitiatorContactCompanyOfficeId = $arrRequestForInformationDraftsByRfiInitiatorContactCompanyOfficeId;
	}

	public static function getArrRequestForInformationDraftsByRfiInitiatorPhoneContactCompanyOfficePhoneNumberId()
	{
		if (isset(self::$_arrRequestForInformationDraftsByRfiInitiatorPhoneContactCompanyOfficePhoneNumberId)) {
			return self::$_arrRequestForInformationDraftsByRfiInitiatorPhoneContactCompanyOfficePhoneNumberId;
		} else {
			return null;
		}
	}

	public static function setArrRequestForInformationDraftsByRfiInitiatorPhoneContactCompanyOfficePhoneNumberId($arrRequestForInformationDraftsByRfiInitiatorPhoneContactCompanyOfficePhoneNumberId)
	{
		self::$_arrRequestForInformationDraftsByRfiInitiatorPhoneContactCompanyOfficePhoneNumberId = $arrRequestForInformationDraftsByRfiInitiatorPhoneContactCompanyOfficePhoneNumberId;
	}

	public static function getArrRequestForInformationDraftsByRfiInitiatorFaxContactCompanyOfficePhoneNumberId()
	{
		if (isset(self::$_arrRequestForInformationDraftsByRfiInitiatorFaxContactCompanyOfficePhoneNumberId)) {
			return self::$_arrRequestForInformationDraftsByRfiInitiatorFaxContactCompanyOfficePhoneNumberId;
		} else {
			return null;
		}
	}

	public static function setArrRequestForInformationDraftsByRfiInitiatorFaxContactCompanyOfficePhoneNumberId($arrRequestForInformationDraftsByRfiInitiatorFaxContactCompanyOfficePhoneNumberId)
	{
		self::$_arrRequestForInformationDraftsByRfiInitiatorFaxContactCompanyOfficePhoneNumberId = $arrRequestForInformationDraftsByRfiInitiatorFaxContactCompanyOfficePhoneNumberId;
	}

	public static function getArrRequestForInformationDraftsByRfiInitiatorContactMobilePhoneNumberId()
	{
		if (isset(self::$_arrRequestForInformationDraftsByRfiInitiatorContactMobilePhoneNumberId)) {
			return self::$_arrRequestForInformationDraftsByRfiInitiatorContactMobilePhoneNumberId;
		} else {
			return null;
		}
	}

	public static function setArrRequestForInformationDraftsByRfiInitiatorContactMobilePhoneNumberId($arrRequestForInformationDraftsByRfiInitiatorContactMobilePhoneNumberId)
	{
		self::$_arrRequestForInformationDraftsByRfiInitiatorContactMobilePhoneNumberId = $arrRequestForInformationDraftsByRfiInitiatorContactMobilePhoneNumberId;
	}

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllRequestForInformationDrafts()
	{
		if (isset(self::$_arrAllRequestForInformationDrafts)) {
			return self::$_arrAllRequestForInformationDrafts;
		} else {
			return null;
		}
	}

	public static function setArrAllRequestForInformationDrafts($arrAllRequestForInformationDrafts)
	{
		self::$_arrAllRequestForInformationDrafts = $arrAllRequestForInformationDrafts;
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
	 * @param int $request_for_information_draft_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findById($database, $request_for_information_draft_id,$table='request_for_information_drafts', $module='RequestForInformationDraft')
	{
		$requestForInformationDraft = parent::findById($database, $request_for_information_draft_id,$table, $module);

		return $requestForInformationDraft;
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Similar to FindById, but with SQL as starter code for more complex joins.
	 *
	 * @param string $database
	 * @param int $request_for_information_draft_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findRequestForInformationDraftByIdExtended($database, $request_for_information_draft_id)
	{
		$request_for_information_draft_id = (int) $request_for_information_draft_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	rfid_fk_p.`id` AS 'rfid_fk_p__project_id',
	rfid_fk_p.`project_type_id` AS 'rfid_fk_p__project_type_id',
	rfid_fk_p.`user_company_id` AS 'rfid_fk_p__user_company_id',
	rfid_fk_p.`user_custom_project_id` AS 'rfid_fk_p__user_custom_project_id',
	rfid_fk_p.`project_name` AS 'rfid_fk_p__project_name',
	rfid_fk_p.`project_owner_name` AS 'rfid_fk_p__project_owner_name',
	rfid_fk_p.`latitude` AS 'rfid_fk_p__latitude',
	rfid_fk_p.`longitude` AS 'rfid_fk_p__longitude',
	rfid_fk_p.`address_line_1` AS 'rfid_fk_p__address_line_1',
	rfid_fk_p.`address_line_2` AS 'rfid_fk_p__address_line_2',
	rfid_fk_p.`address_line_3` AS 'rfid_fk_p__address_line_3',
	rfid_fk_p.`address_line_4` AS 'rfid_fk_p__address_line_4',
	rfid_fk_p.`address_city` AS 'rfid_fk_p__address_city',
	rfid_fk_p.`address_county` AS 'rfid_fk_p__address_county',
	rfid_fk_p.`address_state_or_region` AS 'rfid_fk_p__address_state_or_region',
	rfid_fk_p.`address_postal_code` AS 'rfid_fk_p__address_postal_code',
	rfid_fk_p.`address_postal_code_extension` AS 'rfid_fk_p__address_postal_code_extension',
	rfid_fk_p.`address_country` AS 'rfid_fk_p__address_country',
	rfid_fk_p.`building_count` AS 'rfid_fk_p__building_count',
	rfid_fk_p.`unit_count` AS 'rfid_fk_p__unit_count',
	rfid_fk_p.`gross_square_footage` AS 'rfid_fk_p__gross_square_footage',
	rfid_fk_p.`net_rentable_square_footage` AS 'rfid_fk_p__net_rentable_square_footage',
	rfid_fk_p.`is_active_flag` AS 'rfid_fk_p__is_active_flag',
	rfid_fk_p.`public_plans_flag` AS 'rfid_fk_p__public_plans_flag',
	rfid_fk_p.`prevailing_wage_flag` AS 'rfid_fk_p__prevailing_wage_flag',
	rfid_fk_p.`city_business_license_required_flag` AS 'rfid_fk_p__city_business_license_required_flag',
	rfid_fk_p.`is_internal_flag` AS 'rfid_fk_p__is_internal_flag',
	rfid_fk_p.`project_contract_date` AS 'rfid_fk_p__project_contract_date',
	rfid_fk_p.`project_start_date` AS 'rfid_fk_p__project_start_date',
	rfid_fk_p.`project_completed_date` AS 'rfid_fk_p__project_completed_date',
	rfid_fk_p.`sort_order` AS 'rfid_fk_p__sort_order',

	rfid_fk_rfit.`id` AS 'rfid_fk_rfit__request_for_information_type_id',
	rfid_fk_rfit.`request_for_information_type` AS 'rfid_fk_rfit__request_for_information_type',
	rfid_fk_rfit.`disabled_flag` AS 'rfid_fk_rfit__disabled_flag',

	rfid_fk_rfip.`id` AS 'rfid_fk_rfip__request_for_information_priority_id',
	rfid_fk_rfip.`request_for_information_priority` AS 'rfid_fk_rfip__request_for_information_priority',
	rfid_fk_rfip.`disabled_flag` AS 'rfid_fk_rfip__disabled_flag',

	rfid_fk_fmfiles.`id` AS 'rfid_fk_fmfiles__file_manager_file_id',
	rfid_fk_fmfiles.`user_company_id` AS 'rfid_fk_fmfiles__user_company_id',
	rfid_fk_fmfiles.`contact_id` AS 'rfid_fk_fmfiles__contact_id',
	rfid_fk_fmfiles.`project_id` AS 'rfid_fk_fmfiles__project_id',
	rfid_fk_fmfiles.`file_manager_folder_id` AS 'rfid_fk_fmfiles__file_manager_folder_id',
	rfid_fk_fmfiles.`file_location_id` AS 'rfid_fk_fmfiles__file_location_id',
	rfid_fk_fmfiles.`virtual_file_name` AS 'rfid_fk_fmfiles__virtual_file_name',
	rfid_fk_fmfiles.`version_number` AS 'rfid_fk_fmfiles__version_number',
	rfid_fk_fmfiles.`virtual_file_name_sha1` AS 'rfid_fk_fmfiles__virtual_file_name_sha1',
	rfid_fk_fmfiles.`virtual_file_mime_type` AS 'rfid_fk_fmfiles__virtual_file_mime_type',
	rfid_fk_fmfiles.`modified` AS 'rfid_fk_fmfiles__modified',
	rfid_fk_fmfiles.`created` AS 'rfid_fk_fmfiles__created',
	rfid_fk_fmfiles.`deleted_flag` AS 'rfid_fk_fmfiles__deleted_flag',
	rfid_fk_fmfiles.`directly_deleted_flag` AS 'rfid_fk_fmfiles__directly_deleted_flag',

	rfid_fk_codes.`id` AS 'rfid_fk_codes__cost_code_id',
	rfid_fk_codes.`cost_code_division_id` AS 'rfid_fk_codes__cost_code_division_id',
	rfid_fk_codes.`cost_code` AS 'rfid_fk_codes__cost_code',
	rfid_fk_codes.`cost_code_description` AS 'rfid_fk_codes__cost_code_description',
	rfid_fk_codes.`cost_code_description_abbreviation` AS 'rfid_fk_codes__cost_code_description_abbreviation',
	rfid_fk_codes.`sort_order` AS 'rfid_fk_codes__sort_order',
	rfid_fk_codes.`disabled_flag` AS 'rfid_fk_codes__disabled_flag',

	rfid_fk_creator_c.`id` AS 'rfid_fk_creator_c__contact_id',
	rfid_fk_creator_c.`user_company_id` AS 'rfid_fk_creator_c__user_company_id',
	rfid_fk_creator_c.`user_id` AS 'rfid_fk_creator_c__user_id',
	rfid_fk_creator_c.`contact_company_id` AS 'rfid_fk_creator_c__contact_company_id',
	rfid_fk_creator_c.`email` AS 'rfid_fk_creator_c__email',
	rfid_fk_creator_c.`name_prefix` AS 'rfid_fk_creator_c__name_prefix',
	rfid_fk_creator_c.`first_name` AS 'rfid_fk_creator_c__first_name',
	rfid_fk_creator_c.`additional_name` AS 'rfid_fk_creator_c__additional_name',
	rfid_fk_creator_c.`middle_name` AS 'rfid_fk_creator_c__middle_name',
	rfid_fk_creator_c.`last_name` AS 'rfid_fk_creator_c__last_name',
	rfid_fk_creator_c.`name_suffix` AS 'rfid_fk_creator_c__name_suffix',
	rfid_fk_creator_c.`title` AS 'rfid_fk_creator_c__title',
	rfid_fk_creator_c.`vendor_flag` AS 'rfid_fk_creator_c__vendor_flag',

	rfid_fk_creator_cco.`id` AS 'rfid_fk_creator_cco__contact_company_office_id',
	rfid_fk_creator_cco.`contact_company_id` AS 'rfid_fk_creator_cco__contact_company_id',
	rfid_fk_creator_cco.`office_nickname` AS 'rfid_fk_creator_cco__office_nickname',
	rfid_fk_creator_cco.`address_line_1` AS 'rfid_fk_creator_cco__address_line_1',
	rfid_fk_creator_cco.`address_line_2` AS 'rfid_fk_creator_cco__address_line_2',
	rfid_fk_creator_cco.`address_line_3` AS 'rfid_fk_creator_cco__address_line_3',
	rfid_fk_creator_cco.`address_line_4` AS 'rfid_fk_creator_cco__address_line_4',
	rfid_fk_creator_cco.`address_city` AS 'rfid_fk_creator_cco__address_city',
	rfid_fk_creator_cco.`address_county` AS 'rfid_fk_creator_cco__address_county',
	rfid_fk_creator_cco.`address_state_or_region` AS 'rfid_fk_creator_cco__address_state_or_region',
	rfid_fk_creator_cco.`address_postal_code` AS 'rfid_fk_creator_cco__address_postal_code',
	rfid_fk_creator_cco.`address_postal_code_extension` AS 'rfid_fk_creator_cco__address_postal_code_extension',
	rfid_fk_creator_cco.`address_country` AS 'rfid_fk_creator_cco__address_country',
	rfid_fk_creator_cco.`head_quarters_flag` AS 'rfid_fk_creator_cco__head_quarters_flag',
	rfid_fk_creator_cco.`address_validated_by_user_flag` AS 'rfid_fk_creator_cco__address_validated_by_user_flag',
	rfid_fk_creator_cco.`address_validated_by_web_service_flag` AS 'rfid_fk_creator_cco__address_validated_by_web_service_flag',
	rfid_fk_creator_cco.`address_validation_by_web_service_error_flag` AS 'rfid_fk_creator_cco__address_validation_by_web_service_error_flag',

	rfid_fk_creator_phone_ccopn.`id` AS 'rfid_fk_creator_phone_ccopn__contact_company_office_phone_number_id',
	rfid_fk_creator_phone_ccopn.`contact_company_office_id` AS 'rfid_fk_creator_phone_ccopn__contact_company_office_id',
	rfid_fk_creator_phone_ccopn.`phone_number_type_id` AS 'rfid_fk_creator_phone_ccopn__phone_number_type_id',
	rfid_fk_creator_phone_ccopn.`country_code` AS 'rfid_fk_creator_phone_ccopn__country_code',
	rfid_fk_creator_phone_ccopn.`area_code` AS 'rfid_fk_creator_phone_ccopn__area_code',
	rfid_fk_creator_phone_ccopn.`prefix` AS 'rfid_fk_creator_phone_ccopn__prefix',
	rfid_fk_creator_phone_ccopn.`number` AS 'rfid_fk_creator_phone_ccopn__number',
	rfid_fk_creator_phone_ccopn.`extension` AS 'rfid_fk_creator_phone_ccopn__extension',
	rfid_fk_creator_phone_ccopn.`itu` AS 'rfid_fk_creator_phone_ccopn__itu',

	rfid_fk_creator_fax_ccopn.`id` AS 'rfid_fk_creator_fax_ccopn__contact_company_office_phone_number_id',
	rfid_fk_creator_fax_ccopn.`contact_company_office_id` AS 'rfid_fk_creator_fax_ccopn__contact_company_office_id',
	rfid_fk_creator_fax_ccopn.`phone_number_type_id` AS 'rfid_fk_creator_fax_ccopn__phone_number_type_id',
	rfid_fk_creator_fax_ccopn.`country_code` AS 'rfid_fk_creator_fax_ccopn__country_code',
	rfid_fk_creator_fax_ccopn.`area_code` AS 'rfid_fk_creator_fax_ccopn__area_code',
	rfid_fk_creator_fax_ccopn.`prefix` AS 'rfid_fk_creator_fax_ccopn__prefix',
	rfid_fk_creator_fax_ccopn.`number` AS 'rfid_fk_creator_fax_ccopn__number',
	rfid_fk_creator_fax_ccopn.`extension` AS 'rfid_fk_creator_fax_ccopn__extension',
	rfid_fk_creator_fax_ccopn.`itu` AS 'rfid_fk_creator_fax_ccopn__itu',

	rfid_fk_creator_c_mobile_cpn.`id` AS 'rfid_fk_creator_c_mobile_cpn__contact_phone_number_id',
	rfid_fk_creator_c_mobile_cpn.`contact_id` AS 'rfid_fk_creator_c_mobile_cpn__contact_id',
	rfid_fk_creator_c_mobile_cpn.`phone_number_type_id` AS 'rfid_fk_creator_c_mobile_cpn__phone_number_type_id',
	rfid_fk_creator_c_mobile_cpn.`country_code` AS 'rfid_fk_creator_c_mobile_cpn__country_code',
	rfid_fk_creator_c_mobile_cpn.`area_code` AS 'rfid_fk_creator_c_mobile_cpn__area_code',
	rfid_fk_creator_c_mobile_cpn.`prefix` AS 'rfid_fk_creator_c_mobile_cpn__prefix',
	rfid_fk_creator_c_mobile_cpn.`number` AS 'rfid_fk_creator_c_mobile_cpn__number',
	rfid_fk_creator_c_mobile_cpn.`extension` AS 'rfid_fk_creator_c_mobile_cpn__extension',
	rfid_fk_creator_c_mobile_cpn.`itu` AS 'rfid_fk_creator_c_mobile_cpn__itu',

	rfid_fk_recipient_c.`id` AS 'rfid_fk_recipient_c__contact_id',
	rfid_fk_recipient_c.`user_company_id` AS 'rfid_fk_recipient_c__user_company_id',
	rfid_fk_recipient_c.`user_id` AS 'rfid_fk_recipient_c__user_id',
	rfid_fk_recipient_c.`contact_company_id` AS 'rfid_fk_recipient_c__contact_company_id',
	rfid_fk_recipient_c.`email` AS 'rfid_fk_recipient_c__email',
	rfid_fk_recipient_c.`name_prefix` AS 'rfid_fk_recipient_c__name_prefix',
	rfid_fk_recipient_c.`first_name` AS 'rfid_fk_recipient_c__first_name',
	rfid_fk_recipient_c.`additional_name` AS 'rfid_fk_recipient_c__additional_name',
	rfid_fk_recipient_c.`middle_name` AS 'rfid_fk_recipient_c__middle_name',
	rfid_fk_recipient_c.`last_name` AS 'rfid_fk_recipient_c__last_name',
	rfid_fk_recipient_c.`name_suffix` AS 'rfid_fk_recipient_c__name_suffix',
	rfid_fk_recipient_c.`title` AS 'rfid_fk_recipient_c__title',
	rfid_fk_recipient_c.`vendor_flag` AS 'rfid_fk_recipient_c__vendor_flag',

	rfid_fk_recipient_cco.`id` AS 'rfid_fk_recipient_cco__contact_company_office_id',
	rfid_fk_recipient_cco.`contact_company_id` AS 'rfid_fk_recipient_cco__contact_company_id',
	rfid_fk_recipient_cco.`office_nickname` AS 'rfid_fk_recipient_cco__office_nickname',
	rfid_fk_recipient_cco.`address_line_1` AS 'rfid_fk_recipient_cco__address_line_1',
	rfid_fk_recipient_cco.`address_line_2` AS 'rfid_fk_recipient_cco__address_line_2',
	rfid_fk_recipient_cco.`address_line_3` AS 'rfid_fk_recipient_cco__address_line_3',
	rfid_fk_recipient_cco.`address_line_4` AS 'rfid_fk_recipient_cco__address_line_4',
	rfid_fk_recipient_cco.`address_city` AS 'rfid_fk_recipient_cco__address_city',
	rfid_fk_recipient_cco.`address_county` AS 'rfid_fk_recipient_cco__address_county',
	rfid_fk_recipient_cco.`address_state_or_region` AS 'rfid_fk_recipient_cco__address_state_or_region',
	rfid_fk_recipient_cco.`address_postal_code` AS 'rfid_fk_recipient_cco__address_postal_code',
	rfid_fk_recipient_cco.`address_postal_code_extension` AS 'rfid_fk_recipient_cco__address_postal_code_extension',
	rfid_fk_recipient_cco.`address_country` AS 'rfid_fk_recipient_cco__address_country',
	rfid_fk_recipient_cco.`head_quarters_flag` AS 'rfid_fk_recipient_cco__head_quarters_flag',
	rfid_fk_recipient_cco.`address_validated_by_user_flag` AS 'rfid_fk_recipient_cco__address_validated_by_user_flag',
	rfid_fk_recipient_cco.`address_validated_by_web_service_flag` AS 'rfid_fk_recipient_cco__address_validated_by_web_service_flag',
	rfid_fk_recipient_cco.`address_validation_by_web_service_error_flag` AS 'rfid_fk_recipient_cco__address_validation_by_web_service_error_flag',

	rfid_fk_recipient_phone_ccopn.`id` AS 'rfid_fk_recipient_phone_ccopn__contact_company_office_phone_number_id',
	rfid_fk_recipient_phone_ccopn.`contact_company_office_id` AS 'rfid_fk_recipient_phone_ccopn__contact_company_office_id',
	rfid_fk_recipient_phone_ccopn.`phone_number_type_id` AS 'rfid_fk_recipient_phone_ccopn__phone_number_type_id',
	rfid_fk_recipient_phone_ccopn.`country_code` AS 'rfid_fk_recipient_phone_ccopn__country_code',
	rfid_fk_recipient_phone_ccopn.`area_code` AS 'rfid_fk_recipient_phone_ccopn__area_code',
	rfid_fk_recipient_phone_ccopn.`prefix` AS 'rfid_fk_recipient_phone_ccopn__prefix',
	rfid_fk_recipient_phone_ccopn.`number` AS 'rfid_fk_recipient_phone_ccopn__number',
	rfid_fk_recipient_phone_ccopn.`extension` AS 'rfid_fk_recipient_phone_ccopn__extension',
	rfid_fk_recipient_phone_ccopn.`itu` AS 'rfid_fk_recipient_phone_ccopn__itu',

	rfid_fk_recipient_fax_ccopn.`id` AS 'rfid_fk_recipient_fax_ccopn__contact_company_office_phone_number_id',
	rfid_fk_recipient_fax_ccopn.`contact_company_office_id` AS 'rfid_fk_recipient_fax_ccopn__contact_company_office_id',
	rfid_fk_recipient_fax_ccopn.`phone_number_type_id` AS 'rfid_fk_recipient_fax_ccopn__phone_number_type_id',
	rfid_fk_recipient_fax_ccopn.`country_code` AS 'rfid_fk_recipient_fax_ccopn__country_code',
	rfid_fk_recipient_fax_ccopn.`area_code` AS 'rfid_fk_recipient_fax_ccopn__area_code',
	rfid_fk_recipient_fax_ccopn.`prefix` AS 'rfid_fk_recipient_fax_ccopn__prefix',
	rfid_fk_recipient_fax_ccopn.`number` AS 'rfid_fk_recipient_fax_ccopn__number',
	rfid_fk_recipient_fax_ccopn.`extension` AS 'rfid_fk_recipient_fax_ccopn__extension',
	rfid_fk_recipient_fax_ccopn.`itu` AS 'rfid_fk_recipient_fax_ccopn__itu',

	rfid_fk_recipient_c_mobile_cpn.`id` AS 'rfid_fk_recipient_c_mobile_cpn__contact_phone_number_id',
	rfid_fk_recipient_c_mobile_cpn.`contact_id` AS 'rfid_fk_recipient_c_mobile_cpn__contact_id',
	rfid_fk_recipient_c_mobile_cpn.`phone_number_type_id` AS 'rfid_fk_recipient_c_mobile_cpn__phone_number_type_id',
	rfid_fk_recipient_c_mobile_cpn.`country_code` AS 'rfid_fk_recipient_c_mobile_cpn__country_code',
	rfid_fk_recipient_c_mobile_cpn.`area_code` AS 'rfid_fk_recipient_c_mobile_cpn__area_code',
	rfid_fk_recipient_c_mobile_cpn.`prefix` AS 'rfid_fk_recipient_c_mobile_cpn__prefix',
	rfid_fk_recipient_c_mobile_cpn.`number` AS 'rfid_fk_recipient_c_mobile_cpn__number',
	rfid_fk_recipient_c_mobile_cpn.`extension` AS 'rfid_fk_recipient_c_mobile_cpn__extension',
	rfid_fk_recipient_c_mobile_cpn.`itu` AS 'rfid_fk_recipient_c_mobile_cpn__itu',

	rfid_fk_initiator_c.`id` AS 'rfid_fk_initiator_c__contact_id',
	rfid_fk_initiator_c.`user_company_id` AS 'rfid_fk_initiator_c__user_company_id',
	rfid_fk_initiator_c.`user_id` AS 'rfid_fk_initiator_c__user_id',
	rfid_fk_initiator_c.`contact_company_id` AS 'rfid_fk_initiator_c__contact_company_id',
	rfid_fk_initiator_c.`email` AS 'rfid_fk_initiator_c__email',
	rfid_fk_initiator_c.`name_prefix` AS 'rfid_fk_initiator_c__name_prefix',
	rfid_fk_initiator_c.`first_name` AS 'rfid_fk_initiator_c__first_name',
	rfid_fk_initiator_c.`additional_name` AS 'rfid_fk_initiator_c__additional_name',
	rfid_fk_initiator_c.`middle_name` AS 'rfid_fk_initiator_c__middle_name',
	rfid_fk_initiator_c.`last_name` AS 'rfid_fk_initiator_c__last_name',
	rfid_fk_initiator_c.`name_suffix` AS 'rfid_fk_initiator_c__name_suffix',
	rfid_fk_initiator_c.`title` AS 'rfid_fk_initiator_c__title',
	rfid_fk_initiator_c.`vendor_flag` AS 'rfid_fk_initiator_c__vendor_flag',

	rfid_fk_initiator_cco.`id` AS 'rfid_fk_initiator_cco__contact_company_office_id',
	rfid_fk_initiator_cco.`contact_company_id` AS 'rfid_fk_initiator_cco__contact_company_id',
	rfid_fk_initiator_cco.`office_nickname` AS 'rfid_fk_initiator_cco__office_nickname',
	rfid_fk_initiator_cco.`address_line_1` AS 'rfid_fk_initiator_cco__address_line_1',
	rfid_fk_initiator_cco.`address_line_2` AS 'rfid_fk_initiator_cco__address_line_2',
	rfid_fk_initiator_cco.`address_line_3` AS 'rfid_fk_initiator_cco__address_line_3',
	rfid_fk_initiator_cco.`address_line_4` AS 'rfid_fk_initiator_cco__address_line_4',
	rfid_fk_initiator_cco.`address_city` AS 'rfid_fk_initiator_cco__address_city',
	rfid_fk_initiator_cco.`address_county` AS 'rfid_fk_initiator_cco__address_county',
	rfid_fk_initiator_cco.`address_state_or_region` AS 'rfid_fk_initiator_cco__address_state_or_region',
	rfid_fk_initiator_cco.`address_postal_code` AS 'rfid_fk_initiator_cco__address_postal_code',
	rfid_fk_initiator_cco.`address_postal_code_extension` AS 'rfid_fk_initiator_cco__address_postal_code_extension',
	rfid_fk_initiator_cco.`address_country` AS 'rfid_fk_initiator_cco__address_country',
	rfid_fk_initiator_cco.`head_quarters_flag` AS 'rfid_fk_initiator_cco__head_quarters_flag',
	rfid_fk_initiator_cco.`address_validated_by_user_flag` AS 'rfid_fk_initiator_cco__address_validated_by_user_flag',
	rfid_fk_initiator_cco.`address_validated_by_web_service_flag` AS 'rfid_fk_initiator_cco__address_validated_by_web_service_flag',
	rfid_fk_initiator_cco.`address_validation_by_web_service_error_flag` AS 'rfid_fk_initiator_cco__address_validation_by_web_service_error_flag',

	rfid_fk_initiator_phone_ccopn.`id` AS 'rfid_fk_initiator_phone_ccopn__contact_company_office_phone_number_id',
	rfid_fk_initiator_phone_ccopn.`contact_company_office_id` AS 'rfid_fk_initiator_phone_ccopn__contact_company_office_id',
	rfid_fk_initiator_phone_ccopn.`phone_number_type_id` AS 'rfid_fk_initiator_phone_ccopn__phone_number_type_id',
	rfid_fk_initiator_phone_ccopn.`country_code` AS 'rfid_fk_initiator_phone_ccopn__country_code',
	rfid_fk_initiator_phone_ccopn.`area_code` AS 'rfid_fk_initiator_phone_ccopn__area_code',
	rfid_fk_initiator_phone_ccopn.`prefix` AS 'rfid_fk_initiator_phone_ccopn__prefix',
	rfid_fk_initiator_phone_ccopn.`number` AS 'rfid_fk_initiator_phone_ccopn__number',
	rfid_fk_initiator_phone_ccopn.`extension` AS 'rfid_fk_initiator_phone_ccopn__extension',
	rfid_fk_initiator_phone_ccopn.`itu` AS 'rfid_fk_initiator_phone_ccopn__itu',

	rfid_fk_initiator_fax_ccopn.`id` AS 'rfid_fk_initiator_fax_ccopn__contact_company_office_phone_number_id',
	rfid_fk_initiator_fax_ccopn.`contact_company_office_id` AS 'rfid_fk_initiator_fax_ccopn__contact_company_office_id',
	rfid_fk_initiator_fax_ccopn.`phone_number_type_id` AS 'rfid_fk_initiator_fax_ccopn__phone_number_type_id',
	rfid_fk_initiator_fax_ccopn.`country_code` AS 'rfid_fk_initiator_fax_ccopn__country_code',
	rfid_fk_initiator_fax_ccopn.`area_code` AS 'rfid_fk_initiator_fax_ccopn__area_code',
	rfid_fk_initiator_fax_ccopn.`prefix` AS 'rfid_fk_initiator_fax_ccopn__prefix',
	rfid_fk_initiator_fax_ccopn.`number` AS 'rfid_fk_initiator_fax_ccopn__number',
	rfid_fk_initiator_fax_ccopn.`extension` AS 'rfid_fk_initiator_fax_ccopn__extension',
	rfid_fk_initiator_fax_ccopn.`itu` AS 'rfid_fk_initiator_fax_ccopn__itu',

	rfid_fk_initiator_c_mobile_cpn.`id` AS 'rfid_fk_initiator_c_mobile_cpn__contact_phone_number_id',
	rfid_fk_initiator_c_mobile_cpn.`contact_id` AS 'rfid_fk_initiator_c_mobile_cpn__contact_id',
	rfid_fk_initiator_c_mobile_cpn.`phone_number_type_id` AS 'rfid_fk_initiator_c_mobile_cpn__phone_number_type_id',
	rfid_fk_initiator_c_mobile_cpn.`country_code` AS 'rfid_fk_initiator_c_mobile_cpn__country_code',
	rfid_fk_initiator_c_mobile_cpn.`area_code` AS 'rfid_fk_initiator_c_mobile_cpn__area_code',
	rfid_fk_initiator_c_mobile_cpn.`prefix` AS 'rfid_fk_initiator_c_mobile_cpn__prefix',
	rfid_fk_initiator_c_mobile_cpn.`number` AS 'rfid_fk_initiator_c_mobile_cpn__number',
	rfid_fk_initiator_c_mobile_cpn.`extension` AS 'rfid_fk_initiator_c_mobile_cpn__extension',
	rfid_fk_initiator_c_mobile_cpn.`itu` AS 'rfid_fk_initiator_c_mobile_cpn__itu',

	rfid.*

FROM `request_for_information_drafts` rfid
	INNER JOIN `projects` rfid_fk_p ON rfid.`project_id` = rfid_fk_p.`id`
	INNER JOIN `request_for_information_types` rfid_fk_rfit ON rfid.`request_for_information_type_id` = rfid_fk_rfit.`id`
	INNER JOIN `request_for_information_priorities` rfid_fk_rfip ON rfid.`request_for_information_priority_id` = rfid_fk_rfip.`id`
	LEFT OUTER JOIN `file_manager_files` rfid_fk_fmfiles ON rfid.`rfi_file_manager_file_id` = rfid_fk_fmfiles.`id`
	LEFT OUTER JOIN `cost_codes` rfid_fk_codes ON rfid.`rfi_cost_code_id` = rfid_fk_codes.`id`
	INNER JOIN `contacts` rfid_fk_creator_c ON rfid.`rfi_creator_contact_id` = rfid_fk_creator_c.`id`
	LEFT OUTER JOIN `contact_company_offices` rfid_fk_creator_cco ON rfid.`rfi_creator_contact_company_office_id` = rfid_fk_creator_cco.`id`
	LEFT OUTER JOIN `contact_company_office_phone_numbers` rfid_fk_creator_phone_ccopn ON rfid.`rfi_creator_phone_contact_company_office_phone_number_id` = rfid_fk_creator_phone_ccopn.`id`
	LEFT OUTER JOIN `contact_company_office_phone_numbers` rfid_fk_creator_fax_ccopn ON rfid.`rfi_creator_fax_contact_company_office_phone_number_id` = rfid_fk_creator_fax_ccopn.`id`
	LEFT OUTER JOIN `contact_phone_numbers` rfid_fk_creator_c_mobile_cpn ON rfid.`rfi_creator_contact_mobile_phone_number_id` = rfid_fk_creator_c_mobile_cpn.`id`
	LEFT OUTER JOIN `contacts` rfid_fk_recipient_c ON rfid.`rfi_recipient_contact_id` = rfid_fk_recipient_c.`id`
	LEFT OUTER JOIN `contact_company_offices` rfid_fk_recipient_cco ON rfid.`rfi_recipient_contact_company_office_id` = rfid_fk_recipient_cco.`id`
	LEFT OUTER JOIN `contact_company_office_phone_numbers` rfid_fk_recipient_phone_ccopn ON rfid.`rfi_recipient_phone_contact_company_office_phone_number_id` = rfid_fk_recipient_phone_ccopn.`id`
	LEFT OUTER JOIN `contact_company_office_phone_numbers` rfid_fk_recipient_fax_ccopn ON rfid.`rfi_recipient_fax_contact_company_office_phone_number_id` = rfid_fk_recipient_fax_ccopn.`id`
	LEFT OUTER JOIN `contact_phone_numbers` rfid_fk_recipient_c_mobile_cpn ON rfid.`rfi_recipient_contact_mobile_phone_number_id` = rfid_fk_recipient_c_mobile_cpn.`id`
	LEFT OUTER JOIN `contacts` rfid_fk_initiator_c ON rfid.`rfi_initiator_contact_id` = rfid_fk_initiator_c.`id`
	LEFT OUTER JOIN `contact_company_offices` rfid_fk_initiator_cco ON rfid.`rfi_initiator_contact_company_office_id` = rfid_fk_initiator_cco.`id`
	LEFT OUTER JOIN `contact_company_office_phone_numbers` rfid_fk_initiator_phone_ccopn ON rfid.`rfi_initiator_phone_contact_company_office_phone_number_id` = rfid_fk_initiator_phone_ccopn.`id`
	LEFT OUTER JOIN `contact_company_office_phone_numbers` rfid_fk_initiator_fax_ccopn ON rfid.`rfi_initiator_fax_contact_company_office_phone_number_id` = rfid_fk_initiator_fax_ccopn.`id`
	LEFT OUTER JOIN `contact_phone_numbers` rfid_fk_initiator_c_mobile_cpn ON rfid.`rfi_initiator_contact_mobile_phone_number_id` = rfid_fk_initiator_c_mobile_cpn.`id`
WHERE rfid.`id` = ?
";
		$arrValues = array($request_for_information_draft_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$request_for_information_draft_id = $row['id'];
			$requestForInformationDraft = self::instantiateOrm($database, 'RequestForInformationDraft', $row, null, $request_for_information_draft_id);
			/* @var $requestForInformationDraft RequestForInformationDraft */
			$requestForInformationDraft->convertPropertiesToData();

			if (isset($row['project_id'])) {
				$project_id = $row['project_id'];
				$row['rfid_fk_p__id'] = $project_id;
				$project = self::instantiateOrm($database, 'Project', $row, null, $project_id, 'rfid_fk_p__');
				/* @var $project Project */
				$project->convertPropertiesToData();
			} else {
				$project = false;
			}
			$requestForInformationDraft->setProject($project);

			if (isset($row['request_for_information_type_id'])) {
				$request_for_information_type_id = $row['request_for_information_type_id'];
				$row['rfid_fk_rfit__id'] = $request_for_information_type_id;
				$requestForInformationType = self::instantiateOrm($database, 'RequestForInformationType', $row, null, $request_for_information_type_id, 'rfid_fk_rfit__');
				/* @var $requestForInformationType RequestForInformationType */
				$requestForInformationType->convertPropertiesToData();
			} else {
				$requestForInformationType = false;
			}
			$requestForInformationDraft->setRequestForInformationType($requestForInformationType);

			if (isset($row['request_for_information_priority_id'])) {
				$request_for_information_priority_id = $row['request_for_information_priority_id'];
				$row['rfid_fk_rfip__id'] = $request_for_information_priority_id;
				$requestForInformationPriority = self::instantiateOrm($database, 'RequestForInformationPriority', $row, null, $request_for_information_priority_id, 'rfid_fk_rfip__');
				/* @var $requestForInformationPriority RequestForInformationPriority */
				$requestForInformationPriority->convertPropertiesToData();
			} else {
				$requestForInformationPriority = false;
			}
			$requestForInformationDraft->setRequestForInformationPriority($requestForInformationPriority);

			if (isset($row['rfi_file_manager_file_id'])) {
				$rfi_file_manager_file_id = $row['rfi_file_manager_file_id'];
				$row['rfid_fk_fmfiles__id'] = $rfi_file_manager_file_id;
				$rfiFileManagerFile = self::instantiateOrm($database, 'FileManagerFile', $row, null, $rfi_file_manager_file_id, 'rfid_fk_fmfiles__');
				/* @var $rfiFileManagerFile FileManagerFile */
				$rfiFileManagerFile->convertPropertiesToData();
			} else {
				$rfiFileManagerFile = false;
			}
			$requestForInformationDraft->setRfiFileManagerFile($rfiFileManagerFile);

			if (isset($row['rfi_cost_code_id'])) {
				$rfi_cost_code_id = $row['rfi_cost_code_id'];
				$row['rfid_fk_codes__id'] = $rfi_cost_code_id;
				$rfiCostCode = self::instantiateOrm($database, 'CostCode', $row, null, $rfi_cost_code_id, 'rfid_fk_codes__');
				/* @var $rfiCostCode CostCode */
				$rfiCostCode->convertPropertiesToData();
			} else {
				$rfiCostCode = false;
			}
			$requestForInformationDraft->setRfiCostCode($rfiCostCode);

			if (isset($row['rfi_creator_contact_id'])) {
				$rfi_creator_contact_id = $row['rfi_creator_contact_id'];
				$row['rfid_fk_creator_c__id'] = $rfi_creator_contact_id;
				$rfiCreatorContact = self::instantiateOrm($database, 'Contact', $row, null, $rfi_creator_contact_id, 'rfid_fk_creator_c__');
				/* @var $rfiCreatorContact Contact */
				$rfiCreatorContact->convertPropertiesToData();
			} else {
				$rfiCreatorContact = false;
			}
			$requestForInformationDraft->setRfiCreatorContact($rfiCreatorContact);

			if (isset($row['rfi_creator_contact_company_office_id'])) {
				$rfi_creator_contact_company_office_id = $row['rfi_creator_contact_company_office_id'];
				$row['rfid_fk_creator_cco__id'] = $rfi_creator_contact_company_office_id;
				$rfiCreatorContactCompanyOffice = self::instantiateOrm($database, 'ContactCompanyOffice', $row, null, $rfi_creator_contact_company_office_id, 'rfid_fk_creator_cco__');
				/* @var $rfiCreatorContactCompanyOffice ContactCompanyOffice */
				$rfiCreatorContactCompanyOffice->convertPropertiesToData();
			} else {
				$rfiCreatorContactCompanyOffice = false;
			}
			$requestForInformationDraft->setRfiCreatorContactCompanyOffice($rfiCreatorContactCompanyOffice);

			if (isset($row['rfi_creator_phone_contact_company_office_phone_number_id'])) {
				$rfi_creator_phone_contact_company_office_phone_number_id = $row['rfi_creator_phone_contact_company_office_phone_number_id'];
				$row['rfid_fk_creator_phone_ccopn__id'] = $rfi_creator_phone_contact_company_office_phone_number_id;
				$rfiCreatorPhoneContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $rfi_creator_phone_contact_company_office_phone_number_id, 'rfid_fk_creator_phone_ccopn__');
				/* @var $rfiCreatorPhoneContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$rfiCreatorPhoneContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$rfiCreatorPhoneContactCompanyOfficePhoneNumber = false;
			}
			$requestForInformationDraft->setRfiCreatorPhoneContactCompanyOfficePhoneNumber($rfiCreatorPhoneContactCompanyOfficePhoneNumber);

			if (isset($row['rfi_creator_fax_contact_company_office_phone_number_id'])) {
				$rfi_creator_fax_contact_company_office_phone_number_id = $row['rfi_creator_fax_contact_company_office_phone_number_id'];
				$row['rfid_fk_creator_fax_ccopn__id'] = $rfi_creator_fax_contact_company_office_phone_number_id;
				$rfiCreatorFaxContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $rfi_creator_fax_contact_company_office_phone_number_id, 'rfid_fk_creator_fax_ccopn__');
				/* @var $rfiCreatorFaxContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$rfiCreatorFaxContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$rfiCreatorFaxContactCompanyOfficePhoneNumber = false;
			}
			$requestForInformationDraft->setRfiCreatorFaxContactCompanyOfficePhoneNumber($rfiCreatorFaxContactCompanyOfficePhoneNumber);

			if (isset($row['rfi_creator_contact_mobile_phone_number_id'])) {
				$rfi_creator_contact_mobile_phone_number_id = $row['rfi_creator_contact_mobile_phone_number_id'];
				$row['rfid_fk_creator_c_mobile_cpn__id'] = $rfi_creator_contact_mobile_phone_number_id;
				$rfiCreatorContactMobilePhoneNumber = self::instantiateOrm($database, 'ContactPhoneNumber', $row, null, $rfi_creator_contact_mobile_phone_number_id, 'rfid_fk_creator_c_mobile_cpn__');
				/* @var $rfiCreatorContactMobilePhoneNumber ContactPhoneNumber */
				$rfiCreatorContactMobilePhoneNumber->convertPropertiesToData();
			} else {
				$rfiCreatorContactMobilePhoneNumber = false;
			}
			$requestForInformationDraft->setRfiCreatorContactMobilePhoneNumber($rfiCreatorContactMobilePhoneNumber);

			if (isset($row['rfi_recipient_contact_id'])) {
				$rfi_recipient_contact_id = $row['rfi_recipient_contact_id'];
				$row['rfid_fk_recipient_c__id'] = $rfi_recipient_contact_id;
				$rfiRecipientContact = self::instantiateOrm($database, 'Contact', $row, null, $rfi_recipient_contact_id, 'rfid_fk_recipient_c__');
				/* @var $rfiRecipientContact Contact */
				$rfiRecipientContact->convertPropertiesToData();
			} else {
				$rfiRecipientContact = false;
			}
			$requestForInformationDraft->setRfiRecipientContact($rfiRecipientContact);

			if (isset($row['rfi_recipient_contact_company_office_id'])) {
				$rfi_recipient_contact_company_office_id = $row['rfi_recipient_contact_company_office_id'];
				$row['rfid_fk_recipient_cco__id'] = $rfi_recipient_contact_company_office_id;
				$rfiRecipientContactCompanyOffice = self::instantiateOrm($database, 'ContactCompanyOffice', $row, null, $rfi_recipient_contact_company_office_id, 'rfid_fk_recipient_cco__');
				/* @var $rfiRecipientContactCompanyOffice ContactCompanyOffice */
				$rfiRecipientContactCompanyOffice->convertPropertiesToData();
			} else {
				$rfiRecipientContactCompanyOffice = false;
			}
			$requestForInformationDraft->setRfiRecipientContactCompanyOffice($rfiRecipientContactCompanyOffice);

			if (isset($row['rfi_recipient_phone_contact_company_office_phone_number_id'])) {
				$rfi_recipient_phone_contact_company_office_phone_number_id = $row['rfi_recipient_phone_contact_company_office_phone_number_id'];
				$row['rfid_fk_recipient_phone_ccopn__id'] = $rfi_recipient_phone_contact_company_office_phone_number_id;
				$rfiRecipientPhoneContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $rfi_recipient_phone_contact_company_office_phone_number_id, 'rfid_fk_recipient_phone_ccopn__');
				/* @var $rfiRecipientPhoneContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$rfiRecipientPhoneContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$rfiRecipientPhoneContactCompanyOfficePhoneNumber = false;
			}
			$requestForInformationDraft->setRfiRecipientPhoneContactCompanyOfficePhoneNumber($rfiRecipientPhoneContactCompanyOfficePhoneNumber);

			if (isset($row['rfi_recipient_fax_contact_company_office_phone_number_id'])) {
				$rfi_recipient_fax_contact_company_office_phone_number_id = $row['rfi_recipient_fax_contact_company_office_phone_number_id'];
				$row['rfid_fk_recipient_fax_ccopn__id'] = $rfi_recipient_fax_contact_company_office_phone_number_id;
				$rfiRecipientFaxContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $rfi_recipient_fax_contact_company_office_phone_number_id, 'rfid_fk_recipient_fax_ccopn__');
				/* @var $rfiRecipientFaxContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$rfiRecipientFaxContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$rfiRecipientFaxContactCompanyOfficePhoneNumber = false;
			}
			$requestForInformationDraft->setRfiRecipientFaxContactCompanyOfficePhoneNumber($rfiRecipientFaxContactCompanyOfficePhoneNumber);

			if (isset($row['rfi_recipient_contact_mobile_phone_number_id'])) {
				$rfi_recipient_contact_mobile_phone_number_id = $row['rfi_recipient_contact_mobile_phone_number_id'];
				$row['rfid_fk_recipient_c_mobile_cpn__id'] = $rfi_recipient_contact_mobile_phone_number_id;
				$rfiRecipientContactMobilePhoneNumber = self::instantiateOrm($database, 'ContactPhoneNumber', $row, null, $rfi_recipient_contact_mobile_phone_number_id, 'rfid_fk_recipient_c_mobile_cpn__');
				/* @var $rfiRecipientContactMobilePhoneNumber ContactPhoneNumber */
				$rfiRecipientContactMobilePhoneNumber->convertPropertiesToData();
			} else {
				$rfiRecipientContactMobilePhoneNumber = false;
			}
			$requestForInformationDraft->setRfiRecipientContactMobilePhoneNumber($rfiRecipientContactMobilePhoneNumber);

			if (isset($row['rfi_initiator_contact_id'])) {
				$rfi_initiator_contact_id = $row['rfi_initiator_contact_id'];
				$row['rfid_fk_initiator_c__id'] = $rfi_initiator_contact_id;
				$rfiInitiatorContact = self::instantiateOrm($database, 'Contact', $row, null, $rfi_initiator_contact_id, 'rfid_fk_initiator_c__');
				/* @var $rfiInitiatorContact Contact */
				$rfiInitiatorContact->convertPropertiesToData();
			} else {
				$rfiInitiatorContact = false;
			}
			$requestForInformationDraft->setRfiInitiatorContact($rfiInitiatorContact);

			if (isset($row['rfi_initiator_contact_company_office_id'])) {
				$rfi_initiator_contact_company_office_id = $row['rfi_initiator_contact_company_office_id'];
				$row['rfid_fk_initiator_cco__id'] = $rfi_initiator_contact_company_office_id;
				$rfiInitiatorContactCompanyOffice = self::instantiateOrm($database, 'ContactCompanyOffice', $row, null, $rfi_initiator_contact_company_office_id, 'rfid_fk_initiator_cco__');
				/* @var $rfiInitiatorContactCompanyOffice ContactCompanyOffice */
				$rfiInitiatorContactCompanyOffice->convertPropertiesToData();
			} else {
				$rfiInitiatorContactCompanyOffice = false;
			}
			$requestForInformationDraft->setRfiInitiatorContactCompanyOffice($rfiInitiatorContactCompanyOffice);

			if (isset($row['rfi_initiator_phone_contact_company_office_phone_number_id'])) {
				$rfi_initiator_phone_contact_company_office_phone_number_id = $row['rfi_initiator_phone_contact_company_office_phone_number_id'];
				$row['rfid_fk_initiator_phone_ccopn__id'] = $rfi_initiator_phone_contact_company_office_phone_number_id;
				$rfiInitiatorPhoneContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $rfi_initiator_phone_contact_company_office_phone_number_id, 'rfid_fk_initiator_phone_ccopn__');
				/* @var $rfiInitiatorPhoneContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$rfiInitiatorPhoneContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$rfiInitiatorPhoneContactCompanyOfficePhoneNumber = false;
			}
			$requestForInformationDraft->setRfiInitiatorPhoneContactCompanyOfficePhoneNumber($rfiInitiatorPhoneContactCompanyOfficePhoneNumber);

			if (isset($row['rfi_initiator_fax_contact_company_office_phone_number_id'])) {
				$rfi_initiator_fax_contact_company_office_phone_number_id = $row['rfi_initiator_fax_contact_company_office_phone_number_id'];
				$row['rfid_fk_initiator_fax_ccopn__id'] = $rfi_initiator_fax_contact_company_office_phone_number_id;
				$rfiInitiatorFaxContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $rfi_initiator_fax_contact_company_office_phone_number_id, 'rfid_fk_initiator_fax_ccopn__');
				/* @var $rfiInitiatorFaxContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$rfiInitiatorFaxContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$rfiInitiatorFaxContactCompanyOfficePhoneNumber = false;
			}
			$requestForInformationDraft->setRfiInitiatorFaxContactCompanyOfficePhoneNumber($rfiInitiatorFaxContactCompanyOfficePhoneNumber);

			if (isset($row['rfi_initiator_contact_mobile_phone_number_id'])) {
				$rfi_initiator_contact_mobile_phone_number_id = $row['rfi_initiator_contact_mobile_phone_number_id'];
				$row['rfid_fk_initiator_c_mobile_cpn__id'] = $rfi_initiator_contact_mobile_phone_number_id;
				$rfiInitiatorContactMobilePhoneNumber = self::instantiateOrm($database, 'ContactPhoneNumber', $row, null, $rfi_initiator_contact_mobile_phone_number_id, 'rfid_fk_initiator_c_mobile_cpn__');
				/* @var $rfiInitiatorContactMobilePhoneNumber ContactPhoneNumber */
				$rfiInitiatorContactMobilePhoneNumber->convertPropertiesToData();
			} else {
				$rfiInitiatorContactMobilePhoneNumber = false;
			}
			$requestForInformationDraft->setRfiInitiatorContactMobilePhoneNumber($rfiInitiatorContactMobilePhoneNumber);

			return $requestForInformationDraft;
		} else {
			return false;
		}
	}

	// Finders: Find By Unique Index

	// Loaders: Load By pk List (list of auto int ids or other non auto int pk list)
	/**
	 * Load zero or more records by an id list (array of auto int primary keys).
	 *
	 * @param string $database
	 * @param array $arrRequestForInformationDraftIds
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadRequestForInformationDraftsByArrRequestForInformationDraftIds($database, $arrRequestForInformationDraftIds, Input $options=null)
	{
		if (empty($arrRequestForInformationDraftIds)) {
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
		// ORDER BY `id` ASC, `project_id` ASC, `request_for_information_type_id` ASC, `request_for_information_priority_id` ASC, `rfi_file_manager_file_id` ASC, `rfi_cost_code_id` ASC, `rfi_creator_contact_id` ASC, `rfi_creator_contact_company_office_id` ASC, `rfi_creator_phone_contact_company_office_phone_number_id` ASC, `rfi_creator_fax_contact_company_office_phone_number_id` ASC, `rfi_creator_contact_mobile_phone_number_id` ASC, `rfi_recipient_contact_id` ASC, `rfi_recipient_contact_company_office_id` ASC, `rfi_recipient_phone_contact_company_office_phone_number_id` ASC, `rfi_recipient_fax_contact_company_office_phone_number_id` ASC, `rfi_recipient_contact_mobile_phone_number_id` ASC, `rfi_initiator_contact_id` ASC, `rfi_initiator_contact_company_office_id` ASC, `rfi_initiator_phone_contact_company_office_phone_number_id` ASC, `rfi_initiator_fax_contact_company_office_phone_number_id` ASC, `rfi_initiator_contact_mobile_phone_number_id` ASC, `rfi_title` ASC, `rfi_plan_page_reference` ASC, `rfi_statement` ASC, `rfi_due_date` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpRequestForInformationDraft = new RequestForInformationDraft($database);
			$sqlOrderByColumns = $tmpRequestForInformationDraft->constructSqlOrderByColumns($arrOrderByAttributes);

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

		foreach ($arrRequestForInformationDraftIds as $k => $request_for_information_draft_id) {
			$request_for_information_draft_id = (int) $request_for_information_draft_id;
			$arrRequestForInformationDraftIds[$k] = $db->escape($request_for_information_draft_id);
		}
		$csvRequestForInformationDraftIds = join(',', $arrRequestForInformationDraftIds);

		$query =
"
SELECT

	rfid.*

FROM `request_for_information_drafts` rfid
WHERE rfid.`id` IN ($csvRequestForInformationDraftIds){$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		$arrRequestForInformationDraftsByCsvRequestForInformationDraftIds = array();
		while ($row = $db->fetch()) {
			$request_for_information_draft_id = $row['id'];
			$requestForInformationDraft = self::instantiateOrm($database, 'RequestForInformationDraft', $row, null, $request_for_information_draft_id);
			/* @var $requestForInformationDraft RequestForInformationDraft */
			$requestForInformationDraft->convertPropertiesToData();

			$arrRequestForInformationDraftsByCsvRequestForInformationDraftIds[$request_for_information_draft_id] = $requestForInformationDraft;
		}

		$db->free_result();

		return $arrRequestForInformationDraftsByCsvRequestForInformationDraftIds;
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `request_for_information_drafts_fk_p` foreign key (`project_id`) references `projects` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $project_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadRequestForInformationDraftsByProjectId($database, $project_id, Input $options=null)
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
			self::$_arrRequestForInformationDraftsByProjectId = null;
		}

		$arrRequestForInformationDraftsByProjectId = self::$_arrRequestForInformationDraftsByProjectId;
		if (isset($arrRequestForInformationDraftsByProjectId) && !empty($arrRequestForInformationDraftsByProjectId)) {
			return $arrRequestForInformationDraftsByProjectId;
		}

		$project_id = (int) $project_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `request_for_information_type_id` ASC, `request_for_information_priority_id` ASC, `rfi_file_manager_file_id` ASC, `rfi_cost_code_id` ASC, `rfi_creator_contact_id` ASC, `rfi_creator_contact_company_office_id` ASC, `rfi_creator_phone_contact_company_office_phone_number_id` ASC, `rfi_creator_fax_contact_company_office_phone_number_id` ASC, `rfi_creator_contact_mobile_phone_number_id` ASC, `rfi_recipient_contact_id` ASC, `rfi_recipient_contact_company_office_id` ASC, `rfi_recipient_phone_contact_company_office_phone_number_id` ASC, `rfi_recipient_fax_contact_company_office_phone_number_id` ASC, `rfi_recipient_contact_mobile_phone_number_id` ASC, `rfi_initiator_contact_id` ASC, `rfi_initiator_contact_company_office_id` ASC, `rfi_initiator_phone_contact_company_office_phone_number_id` ASC, `rfi_initiator_fax_contact_company_office_phone_number_id` ASC, `rfi_initiator_contact_mobile_phone_number_id` ASC, `rfi_title` ASC, `rfi_plan_page_reference` ASC, `rfi_statement` ASC, `rfi_due_date` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpRequestForInformationDraft = new RequestForInformationDraft($database);
			$sqlOrderByColumns = $tmpRequestForInformationDraft->constructSqlOrderByColumns($arrOrderByAttributes);

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
	rfid.*

FROM `request_for_information_drafts` rfid
WHERE rfid.`project_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `request_for_information_type_id` ASC, `request_for_information_priority_id` ASC, `rfi_file_manager_file_id` ASC, `rfi_cost_code_id` ASC, `rfi_creator_contact_id` ASC, `rfi_creator_contact_company_office_id` ASC, `rfi_creator_phone_contact_company_office_phone_number_id` ASC, `rfi_creator_fax_contact_company_office_phone_number_id` ASC, `rfi_creator_contact_mobile_phone_number_id` ASC, `rfi_recipient_contact_id` ASC, `rfi_recipient_contact_company_office_id` ASC, `rfi_recipient_phone_contact_company_office_phone_number_id` ASC, `rfi_recipient_fax_contact_company_office_phone_number_id` ASC, `rfi_recipient_contact_mobile_phone_number_id` ASC, `rfi_initiator_contact_id` ASC, `rfi_initiator_contact_company_office_id` ASC, `rfi_initiator_phone_contact_company_office_phone_number_id` ASC, `rfi_initiator_fax_contact_company_office_phone_number_id` ASC, `rfi_initiator_contact_mobile_phone_number_id` ASC, `rfi_title` ASC, `rfi_plan_page_reference` ASC, `rfi_statement` ASC, `rfi_due_date` ASC
		$arrValues = array($project_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrRequestForInformationDraftsByProjectId = array();
		while ($row = $db->fetch()) {
			$request_for_information_draft_id = $row['id'];
			$requestForInformationDraft = self::instantiateOrm($database, 'RequestForInformationDraft', $row, null, $request_for_information_draft_id);
			/* @var $requestForInformationDraft RequestForInformationDraft */
			$arrRequestForInformationDraftsByProjectId[$request_for_information_draft_id] = $requestForInformationDraft;
		}

		$db->free_result();

		self::$_arrRequestForInformationDraftsByProjectId = $arrRequestForInformationDraftsByProjectId;

		return $arrRequestForInformationDraftsByProjectId;
	}

	/**
	 * Load by constraint `request_for_information_drafts_fk_rfit` foreign key (`request_for_information_type_id`) references `request_for_information_types` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $request_for_information_type_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadRequestForInformationDraftsByRequestForInformationTypeId($database, $request_for_information_type_id, Input $options=null)
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
			self::$_arrRequestForInformationDraftsByRequestForInformationTypeId = null;
		}

		$arrRequestForInformationDraftsByRequestForInformationTypeId = self::$_arrRequestForInformationDraftsByRequestForInformationTypeId;
		if (isset($arrRequestForInformationDraftsByRequestForInformationTypeId) && !empty($arrRequestForInformationDraftsByRequestForInformationTypeId)) {
			return $arrRequestForInformationDraftsByRequestForInformationTypeId;
		}

		$request_for_information_type_id = (int) $request_for_information_type_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `request_for_information_type_id` ASC, `request_for_information_priority_id` ASC, `rfi_file_manager_file_id` ASC, `rfi_cost_code_id` ASC, `rfi_creator_contact_id` ASC, `rfi_creator_contact_company_office_id` ASC, `rfi_creator_phone_contact_company_office_phone_number_id` ASC, `rfi_creator_fax_contact_company_office_phone_number_id` ASC, `rfi_creator_contact_mobile_phone_number_id` ASC, `rfi_recipient_contact_id` ASC, `rfi_recipient_contact_company_office_id` ASC, `rfi_recipient_phone_contact_company_office_phone_number_id` ASC, `rfi_recipient_fax_contact_company_office_phone_number_id` ASC, `rfi_recipient_contact_mobile_phone_number_id` ASC, `rfi_initiator_contact_id` ASC, `rfi_initiator_contact_company_office_id` ASC, `rfi_initiator_phone_contact_company_office_phone_number_id` ASC, `rfi_initiator_fax_contact_company_office_phone_number_id` ASC, `rfi_initiator_contact_mobile_phone_number_id` ASC, `rfi_title` ASC, `rfi_plan_page_reference` ASC, `rfi_statement` ASC, `rfi_due_date` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpRequestForInformationDraft = new RequestForInformationDraft($database);
			$sqlOrderByColumns = $tmpRequestForInformationDraft->constructSqlOrderByColumns($arrOrderByAttributes);

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
	rfid.*

FROM `request_for_information_drafts` rfid
WHERE rfid.`request_for_information_type_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `request_for_information_type_id` ASC, `request_for_information_priority_id` ASC, `rfi_file_manager_file_id` ASC, `rfi_cost_code_id` ASC, `rfi_creator_contact_id` ASC, `rfi_creator_contact_company_office_id` ASC, `rfi_creator_phone_contact_company_office_phone_number_id` ASC, `rfi_creator_fax_contact_company_office_phone_number_id` ASC, `rfi_creator_contact_mobile_phone_number_id` ASC, `rfi_recipient_contact_id` ASC, `rfi_recipient_contact_company_office_id` ASC, `rfi_recipient_phone_contact_company_office_phone_number_id` ASC, `rfi_recipient_fax_contact_company_office_phone_number_id` ASC, `rfi_recipient_contact_mobile_phone_number_id` ASC, `rfi_initiator_contact_id` ASC, `rfi_initiator_contact_company_office_id` ASC, `rfi_initiator_phone_contact_company_office_phone_number_id` ASC, `rfi_initiator_fax_contact_company_office_phone_number_id` ASC, `rfi_initiator_contact_mobile_phone_number_id` ASC, `rfi_title` ASC, `rfi_plan_page_reference` ASC, `rfi_statement` ASC, `rfi_due_date` ASC
		$arrValues = array($request_for_information_type_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrRequestForInformationDraftsByRequestForInformationTypeId = array();
		while ($row = $db->fetch()) {
			$request_for_information_draft_id = $row['id'];
			$requestForInformationDraft = self::instantiateOrm($database, 'RequestForInformationDraft', $row, null, $request_for_information_draft_id);
			/* @var $requestForInformationDraft RequestForInformationDraft */
			$arrRequestForInformationDraftsByRequestForInformationTypeId[$request_for_information_draft_id] = $requestForInformationDraft;
		}

		$db->free_result();

		self::$_arrRequestForInformationDraftsByRequestForInformationTypeId = $arrRequestForInformationDraftsByRequestForInformationTypeId;

		return $arrRequestForInformationDraftsByRequestForInformationTypeId;
	}

	/**
	 * Load by constraint `request_for_information_drafts_fk_rfip` foreign key (`request_for_information_priority_id`) references `request_for_information_priorities` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $request_for_information_priority_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadRequestForInformationDraftsByRequestForInformationPriorityId($database, $request_for_information_priority_id, Input $options=null)
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
			self::$_arrRequestForInformationDraftsByRequestForInformationPriorityId = null;
		}

		$arrRequestForInformationDraftsByRequestForInformationPriorityId = self::$_arrRequestForInformationDraftsByRequestForInformationPriorityId;
		if (isset($arrRequestForInformationDraftsByRequestForInformationPriorityId) && !empty($arrRequestForInformationDraftsByRequestForInformationPriorityId)) {
			return $arrRequestForInformationDraftsByRequestForInformationPriorityId;
		}

		$request_for_information_priority_id = (int) $request_for_information_priority_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `request_for_information_type_id` ASC, `request_for_information_priority_id` ASC, `rfi_file_manager_file_id` ASC, `rfi_cost_code_id` ASC, `rfi_creator_contact_id` ASC, `rfi_creator_contact_company_office_id` ASC, `rfi_creator_phone_contact_company_office_phone_number_id` ASC, `rfi_creator_fax_contact_company_office_phone_number_id` ASC, `rfi_creator_contact_mobile_phone_number_id` ASC, `rfi_recipient_contact_id` ASC, `rfi_recipient_contact_company_office_id` ASC, `rfi_recipient_phone_contact_company_office_phone_number_id` ASC, `rfi_recipient_fax_contact_company_office_phone_number_id` ASC, `rfi_recipient_contact_mobile_phone_number_id` ASC, `rfi_initiator_contact_id` ASC, `rfi_initiator_contact_company_office_id` ASC, `rfi_initiator_phone_contact_company_office_phone_number_id` ASC, `rfi_initiator_fax_contact_company_office_phone_number_id` ASC, `rfi_initiator_contact_mobile_phone_number_id` ASC, `rfi_title` ASC, `rfi_plan_page_reference` ASC, `rfi_statement` ASC, `rfi_due_date` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpRequestForInformationDraft = new RequestForInformationDraft($database);
			$sqlOrderByColumns = $tmpRequestForInformationDraft->constructSqlOrderByColumns($arrOrderByAttributes);

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
	rfid.*

FROM `request_for_information_drafts` rfid
WHERE rfid.`request_for_information_priority_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `request_for_information_type_id` ASC, `request_for_information_priority_id` ASC, `rfi_file_manager_file_id` ASC, `rfi_cost_code_id` ASC, `rfi_creator_contact_id` ASC, `rfi_creator_contact_company_office_id` ASC, `rfi_creator_phone_contact_company_office_phone_number_id` ASC, `rfi_creator_fax_contact_company_office_phone_number_id` ASC, `rfi_creator_contact_mobile_phone_number_id` ASC, `rfi_recipient_contact_id` ASC, `rfi_recipient_contact_company_office_id` ASC, `rfi_recipient_phone_contact_company_office_phone_number_id` ASC, `rfi_recipient_fax_contact_company_office_phone_number_id` ASC, `rfi_recipient_contact_mobile_phone_number_id` ASC, `rfi_initiator_contact_id` ASC, `rfi_initiator_contact_company_office_id` ASC, `rfi_initiator_phone_contact_company_office_phone_number_id` ASC, `rfi_initiator_fax_contact_company_office_phone_number_id` ASC, `rfi_initiator_contact_mobile_phone_number_id` ASC, `rfi_title` ASC, `rfi_plan_page_reference` ASC, `rfi_statement` ASC, `rfi_due_date` ASC
		$arrValues = array($request_for_information_priority_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrRequestForInformationDraftsByRequestForInformationPriorityId = array();
		while ($row = $db->fetch()) {
			$request_for_information_draft_id = $row['id'];
			$requestForInformationDraft = self::instantiateOrm($database, 'RequestForInformationDraft', $row, null, $request_for_information_draft_id);
			/* @var $requestForInformationDraft RequestForInformationDraft */
			$arrRequestForInformationDraftsByRequestForInformationPriorityId[$request_for_information_draft_id] = $requestForInformationDraft;
		}

		$db->free_result();

		self::$_arrRequestForInformationDraftsByRequestForInformationPriorityId = $arrRequestForInformationDraftsByRequestForInformationPriorityId;

		return $arrRequestForInformationDraftsByRequestForInformationPriorityId;
	}

	/**
	 * Load by constraint `request_for_information_drafts_fk_fmfiles` foreign key (`rfi_file_manager_file_id`) references `file_manager_files` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $rfi_file_manager_file_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadRequestForInformationDraftsByRfiFileManagerFileId($database, $rfi_file_manager_file_id, Input $options=null)
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
			self::$_arrRequestForInformationDraftsByRfiFileManagerFileId = null;
		}

		$arrRequestForInformationDraftsByRfiFileManagerFileId = self::$_arrRequestForInformationDraftsByRfiFileManagerFileId;
		if (isset($arrRequestForInformationDraftsByRfiFileManagerFileId) && !empty($arrRequestForInformationDraftsByRfiFileManagerFileId)) {
			return $arrRequestForInformationDraftsByRfiFileManagerFileId;
		}

		$rfi_file_manager_file_id = (int) $rfi_file_manager_file_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `request_for_information_type_id` ASC, `request_for_information_priority_id` ASC, `rfi_file_manager_file_id` ASC, `rfi_cost_code_id` ASC, `rfi_creator_contact_id` ASC, `rfi_creator_contact_company_office_id` ASC, `rfi_creator_phone_contact_company_office_phone_number_id` ASC, `rfi_creator_fax_contact_company_office_phone_number_id` ASC, `rfi_creator_contact_mobile_phone_number_id` ASC, `rfi_recipient_contact_id` ASC, `rfi_recipient_contact_company_office_id` ASC, `rfi_recipient_phone_contact_company_office_phone_number_id` ASC, `rfi_recipient_fax_contact_company_office_phone_number_id` ASC, `rfi_recipient_contact_mobile_phone_number_id` ASC, `rfi_initiator_contact_id` ASC, `rfi_initiator_contact_company_office_id` ASC, `rfi_initiator_phone_contact_company_office_phone_number_id` ASC, `rfi_initiator_fax_contact_company_office_phone_number_id` ASC, `rfi_initiator_contact_mobile_phone_number_id` ASC, `rfi_title` ASC, `rfi_plan_page_reference` ASC, `rfi_statement` ASC, `rfi_due_date` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpRequestForInformationDraft = new RequestForInformationDraft($database);
			$sqlOrderByColumns = $tmpRequestForInformationDraft->constructSqlOrderByColumns($arrOrderByAttributes);

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
	rfid.*

FROM `request_for_information_drafts` rfid
WHERE rfid.`rfi_file_manager_file_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `request_for_information_type_id` ASC, `request_for_information_priority_id` ASC, `rfi_file_manager_file_id` ASC, `rfi_cost_code_id` ASC, `rfi_creator_contact_id` ASC, `rfi_creator_contact_company_office_id` ASC, `rfi_creator_phone_contact_company_office_phone_number_id` ASC, `rfi_creator_fax_contact_company_office_phone_number_id` ASC, `rfi_creator_contact_mobile_phone_number_id` ASC, `rfi_recipient_contact_id` ASC, `rfi_recipient_contact_company_office_id` ASC, `rfi_recipient_phone_contact_company_office_phone_number_id` ASC, `rfi_recipient_fax_contact_company_office_phone_number_id` ASC, `rfi_recipient_contact_mobile_phone_number_id` ASC, `rfi_initiator_contact_id` ASC, `rfi_initiator_contact_company_office_id` ASC, `rfi_initiator_phone_contact_company_office_phone_number_id` ASC, `rfi_initiator_fax_contact_company_office_phone_number_id` ASC, `rfi_initiator_contact_mobile_phone_number_id` ASC, `rfi_title` ASC, `rfi_plan_page_reference` ASC, `rfi_statement` ASC, `rfi_due_date` ASC
		$arrValues = array($rfi_file_manager_file_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrRequestForInformationDraftsByRfiFileManagerFileId = array();
		while ($row = $db->fetch()) {
			$request_for_information_draft_id = $row['id'];
			$requestForInformationDraft = self::instantiateOrm($database, 'RequestForInformationDraft', $row, null, $request_for_information_draft_id);
			/* @var $requestForInformationDraft RequestForInformationDraft */
			$arrRequestForInformationDraftsByRfiFileManagerFileId[$request_for_information_draft_id] = $requestForInformationDraft;
		}

		$db->free_result();

		self::$_arrRequestForInformationDraftsByRfiFileManagerFileId = $arrRequestForInformationDraftsByRfiFileManagerFileId;

		return $arrRequestForInformationDraftsByRfiFileManagerFileId;
	}

	/**
	 * Load by constraint `request_for_information_drafts_fk_codes` foreign key (`rfi_cost_code_id`) references `cost_codes` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $rfi_cost_code_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadRequestForInformationDraftsByRfiCostCodeId($database, $rfi_cost_code_id, Input $options=null)
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
			self::$_arrRequestForInformationDraftsByRfiCostCodeId = null;
		}

		$arrRequestForInformationDraftsByRfiCostCodeId = self::$_arrRequestForInformationDraftsByRfiCostCodeId;
		if (isset($arrRequestForInformationDraftsByRfiCostCodeId) && !empty($arrRequestForInformationDraftsByRfiCostCodeId)) {
			return $arrRequestForInformationDraftsByRfiCostCodeId;
		}

		$rfi_cost_code_id = (int) $rfi_cost_code_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `request_for_information_type_id` ASC, `request_for_information_priority_id` ASC, `rfi_file_manager_file_id` ASC, `rfi_cost_code_id` ASC, `rfi_creator_contact_id` ASC, `rfi_creator_contact_company_office_id` ASC, `rfi_creator_phone_contact_company_office_phone_number_id` ASC, `rfi_creator_fax_contact_company_office_phone_number_id` ASC, `rfi_creator_contact_mobile_phone_number_id` ASC, `rfi_recipient_contact_id` ASC, `rfi_recipient_contact_company_office_id` ASC, `rfi_recipient_phone_contact_company_office_phone_number_id` ASC, `rfi_recipient_fax_contact_company_office_phone_number_id` ASC, `rfi_recipient_contact_mobile_phone_number_id` ASC, `rfi_initiator_contact_id` ASC, `rfi_initiator_contact_company_office_id` ASC, `rfi_initiator_phone_contact_company_office_phone_number_id` ASC, `rfi_initiator_fax_contact_company_office_phone_number_id` ASC, `rfi_initiator_contact_mobile_phone_number_id` ASC, `rfi_title` ASC, `rfi_plan_page_reference` ASC, `rfi_statement` ASC, `rfi_due_date` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpRequestForInformationDraft = new RequestForInformationDraft($database);
			$sqlOrderByColumns = $tmpRequestForInformationDraft->constructSqlOrderByColumns($arrOrderByAttributes);

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
	rfid.*

FROM `request_for_information_drafts` rfid
WHERE rfid.`rfi_cost_code_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `request_for_information_type_id` ASC, `request_for_information_priority_id` ASC, `rfi_file_manager_file_id` ASC, `rfi_cost_code_id` ASC, `rfi_creator_contact_id` ASC, `rfi_creator_contact_company_office_id` ASC, `rfi_creator_phone_contact_company_office_phone_number_id` ASC, `rfi_creator_fax_contact_company_office_phone_number_id` ASC, `rfi_creator_contact_mobile_phone_number_id` ASC, `rfi_recipient_contact_id` ASC, `rfi_recipient_contact_company_office_id` ASC, `rfi_recipient_phone_contact_company_office_phone_number_id` ASC, `rfi_recipient_fax_contact_company_office_phone_number_id` ASC, `rfi_recipient_contact_mobile_phone_number_id` ASC, `rfi_initiator_contact_id` ASC, `rfi_initiator_contact_company_office_id` ASC, `rfi_initiator_phone_contact_company_office_phone_number_id` ASC, `rfi_initiator_fax_contact_company_office_phone_number_id` ASC, `rfi_initiator_contact_mobile_phone_number_id` ASC, `rfi_title` ASC, `rfi_plan_page_reference` ASC, `rfi_statement` ASC, `rfi_due_date` ASC
		$arrValues = array($rfi_cost_code_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrRequestForInformationDraftsByRfiCostCodeId = array();
		while ($row = $db->fetch()) {
			$request_for_information_draft_id = $row['id'];
			$requestForInformationDraft = self::instantiateOrm($database, 'RequestForInformationDraft', $row, null, $request_for_information_draft_id);
			/* @var $requestForInformationDraft RequestForInformationDraft */
			$arrRequestForInformationDraftsByRfiCostCodeId[$request_for_information_draft_id] = $requestForInformationDraft;
		}

		$db->free_result();

		self::$_arrRequestForInformationDraftsByRfiCostCodeId = $arrRequestForInformationDraftsByRfiCostCodeId;

		return $arrRequestForInformationDraftsByRfiCostCodeId;
	}

	/**
	 * Load by constraint `request_for_information_drafts_fk_creator_c` foreign key (`rfi_creator_contact_id`) references `contacts` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $rfi_creator_contact_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadRequestForInformationDraftsByRfiCreatorContactId($database, $rfi_creator_contact_id, Input $options=null)
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
			self::$_arrRequestForInformationDraftsByRfiCreatorContactId = null;
		}

		$arrRequestForInformationDraftsByRfiCreatorContactId = self::$_arrRequestForInformationDraftsByRfiCreatorContactId;
		if (isset($arrRequestForInformationDraftsByRfiCreatorContactId) && !empty($arrRequestForInformationDraftsByRfiCreatorContactId)) {
			return $arrRequestForInformationDraftsByRfiCreatorContactId;
		}

		$rfi_creator_contact_id = (int) $rfi_creator_contact_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `request_for_information_type_id` ASC, `request_for_information_priority_id` ASC, `rfi_file_manager_file_id` ASC, `rfi_cost_code_id` ASC, `rfi_creator_contact_id` ASC, `rfi_creator_contact_company_office_id` ASC, `rfi_creator_phone_contact_company_office_phone_number_id` ASC, `rfi_creator_fax_contact_company_office_phone_number_id` ASC, `rfi_creator_contact_mobile_phone_number_id` ASC, `rfi_recipient_contact_id` ASC, `rfi_recipient_contact_company_office_id` ASC, `rfi_recipient_phone_contact_company_office_phone_number_id` ASC, `rfi_recipient_fax_contact_company_office_phone_number_id` ASC, `rfi_recipient_contact_mobile_phone_number_id` ASC, `rfi_initiator_contact_id` ASC, `rfi_initiator_contact_company_office_id` ASC, `rfi_initiator_phone_contact_company_office_phone_number_id` ASC, `rfi_initiator_fax_contact_company_office_phone_number_id` ASC, `rfi_initiator_contact_mobile_phone_number_id` ASC, `rfi_title` ASC, `rfi_plan_page_reference` ASC, `rfi_statement` ASC, `rfi_due_date` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpRequestForInformationDraft = new RequestForInformationDraft($database);
			$sqlOrderByColumns = $tmpRequestForInformationDraft->constructSqlOrderByColumns($arrOrderByAttributes);

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
	rfid.*

FROM `request_for_information_drafts` rfid
WHERE rfid.`rfi_creator_contact_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `request_for_information_type_id` ASC, `request_for_information_priority_id` ASC, `rfi_file_manager_file_id` ASC, `rfi_cost_code_id` ASC, `rfi_creator_contact_id` ASC, `rfi_creator_contact_company_office_id` ASC, `rfi_creator_phone_contact_company_office_phone_number_id` ASC, `rfi_creator_fax_contact_company_office_phone_number_id` ASC, `rfi_creator_contact_mobile_phone_number_id` ASC, `rfi_recipient_contact_id` ASC, `rfi_recipient_contact_company_office_id` ASC, `rfi_recipient_phone_contact_company_office_phone_number_id` ASC, `rfi_recipient_fax_contact_company_office_phone_number_id` ASC, `rfi_recipient_contact_mobile_phone_number_id` ASC, `rfi_initiator_contact_id` ASC, `rfi_initiator_contact_company_office_id` ASC, `rfi_initiator_phone_contact_company_office_phone_number_id` ASC, `rfi_initiator_fax_contact_company_office_phone_number_id` ASC, `rfi_initiator_contact_mobile_phone_number_id` ASC, `rfi_title` ASC, `rfi_plan_page_reference` ASC, `rfi_statement` ASC, `rfi_due_date` ASC
		$arrValues = array($rfi_creator_contact_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrRequestForInformationDraftsByRfiCreatorContactId = array();
		while ($row = $db->fetch()) {
			$request_for_information_draft_id = $row['id'];
			$requestForInformationDraft = self::instantiateOrm($database, 'RequestForInformationDraft', $row, null, $request_for_information_draft_id);
			/* @var $requestForInformationDraft RequestForInformationDraft */
			$arrRequestForInformationDraftsByRfiCreatorContactId[$request_for_information_draft_id] = $requestForInformationDraft;
		}

		$db->free_result();

		self::$_arrRequestForInformationDraftsByRfiCreatorContactId = $arrRequestForInformationDraftsByRfiCreatorContactId;

		return $arrRequestForInformationDraftsByRfiCreatorContactId;
	}

	/**
	 * Load by constraint `request_for_information_drafts_fk_creator_cco` foreign key (`rfi_creator_contact_company_office_id`) references `contact_company_offices` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $rfi_creator_contact_company_office_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadRequestForInformationDraftsByRfiCreatorContactCompanyOfficeId($database, $rfi_creator_contact_company_office_id, Input $options=null)
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
			self::$_arrRequestForInformationDraftsByRfiCreatorContactCompanyOfficeId = null;
		}

		$arrRequestForInformationDraftsByRfiCreatorContactCompanyOfficeId = self::$_arrRequestForInformationDraftsByRfiCreatorContactCompanyOfficeId;
		if (isset($arrRequestForInformationDraftsByRfiCreatorContactCompanyOfficeId) && !empty($arrRequestForInformationDraftsByRfiCreatorContactCompanyOfficeId)) {
			return $arrRequestForInformationDraftsByRfiCreatorContactCompanyOfficeId;
		}

		$rfi_creator_contact_company_office_id = (int) $rfi_creator_contact_company_office_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `request_for_information_type_id` ASC, `request_for_information_priority_id` ASC, `rfi_file_manager_file_id` ASC, `rfi_cost_code_id` ASC, `rfi_creator_contact_id` ASC, `rfi_creator_contact_company_office_id` ASC, `rfi_creator_phone_contact_company_office_phone_number_id` ASC, `rfi_creator_fax_contact_company_office_phone_number_id` ASC, `rfi_creator_contact_mobile_phone_number_id` ASC, `rfi_recipient_contact_id` ASC, `rfi_recipient_contact_company_office_id` ASC, `rfi_recipient_phone_contact_company_office_phone_number_id` ASC, `rfi_recipient_fax_contact_company_office_phone_number_id` ASC, `rfi_recipient_contact_mobile_phone_number_id` ASC, `rfi_initiator_contact_id` ASC, `rfi_initiator_contact_company_office_id` ASC, `rfi_initiator_phone_contact_company_office_phone_number_id` ASC, `rfi_initiator_fax_contact_company_office_phone_number_id` ASC, `rfi_initiator_contact_mobile_phone_number_id` ASC, `rfi_title` ASC, `rfi_plan_page_reference` ASC, `rfi_statement` ASC, `rfi_due_date` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpRequestForInformationDraft = new RequestForInformationDraft($database);
			$sqlOrderByColumns = $tmpRequestForInformationDraft->constructSqlOrderByColumns($arrOrderByAttributes);

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
	rfid.*

FROM `request_for_information_drafts` rfid
WHERE rfid.`rfi_creator_contact_company_office_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `request_for_information_type_id` ASC, `request_for_information_priority_id` ASC, `rfi_file_manager_file_id` ASC, `rfi_cost_code_id` ASC, `rfi_creator_contact_id` ASC, `rfi_creator_contact_company_office_id` ASC, `rfi_creator_phone_contact_company_office_phone_number_id` ASC, `rfi_creator_fax_contact_company_office_phone_number_id` ASC, `rfi_creator_contact_mobile_phone_number_id` ASC, `rfi_recipient_contact_id` ASC, `rfi_recipient_contact_company_office_id` ASC, `rfi_recipient_phone_contact_company_office_phone_number_id` ASC, `rfi_recipient_fax_contact_company_office_phone_number_id` ASC, `rfi_recipient_contact_mobile_phone_number_id` ASC, `rfi_initiator_contact_id` ASC, `rfi_initiator_contact_company_office_id` ASC, `rfi_initiator_phone_contact_company_office_phone_number_id` ASC, `rfi_initiator_fax_contact_company_office_phone_number_id` ASC, `rfi_initiator_contact_mobile_phone_number_id` ASC, `rfi_title` ASC, `rfi_plan_page_reference` ASC, `rfi_statement` ASC, `rfi_due_date` ASC
		$arrValues = array($rfi_creator_contact_company_office_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrRequestForInformationDraftsByRfiCreatorContactCompanyOfficeId = array();
		while ($row = $db->fetch()) {
			$request_for_information_draft_id = $row['id'];
			$requestForInformationDraft = self::instantiateOrm($database, 'RequestForInformationDraft', $row, null, $request_for_information_draft_id);
			/* @var $requestForInformationDraft RequestForInformationDraft */
			$arrRequestForInformationDraftsByRfiCreatorContactCompanyOfficeId[$request_for_information_draft_id] = $requestForInformationDraft;
		}

		$db->free_result();

		self::$_arrRequestForInformationDraftsByRfiCreatorContactCompanyOfficeId = $arrRequestForInformationDraftsByRfiCreatorContactCompanyOfficeId;

		return $arrRequestForInformationDraftsByRfiCreatorContactCompanyOfficeId;
	}

	/**
	 * Load by constraint `request_for_information_drafts_fk_creator_phone_ccopn` foreign key (`rfi_creator_phone_contact_company_office_phone_number_id`) references `contact_company_office_phone_numbers` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $rfi_creator_phone_contact_company_office_phone_number_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadRequestForInformationDraftsByRfiCreatorPhoneContactCompanyOfficePhoneNumberId($database, $rfi_creator_phone_contact_company_office_phone_number_id, Input $options=null)
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
			self::$_arrRequestForInformationDraftsByRfiCreatorPhoneContactCompanyOfficePhoneNumberId = null;
		}

		$arrRequestForInformationDraftsByRfiCreatorPhoneContactCompanyOfficePhoneNumberId = self::$_arrRequestForInformationDraftsByRfiCreatorPhoneContactCompanyOfficePhoneNumberId;
		if (isset($arrRequestForInformationDraftsByRfiCreatorPhoneContactCompanyOfficePhoneNumberId) && !empty($arrRequestForInformationDraftsByRfiCreatorPhoneContactCompanyOfficePhoneNumberId)) {
			return $arrRequestForInformationDraftsByRfiCreatorPhoneContactCompanyOfficePhoneNumberId;
		}

		$rfi_creator_phone_contact_company_office_phone_number_id = (int) $rfi_creator_phone_contact_company_office_phone_number_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `request_for_information_type_id` ASC, `request_for_information_priority_id` ASC, `rfi_file_manager_file_id` ASC, `rfi_cost_code_id` ASC, `rfi_creator_contact_id` ASC, `rfi_creator_contact_company_office_id` ASC, `rfi_creator_phone_contact_company_office_phone_number_id` ASC, `rfi_creator_fax_contact_company_office_phone_number_id` ASC, `rfi_creator_contact_mobile_phone_number_id` ASC, `rfi_recipient_contact_id` ASC, `rfi_recipient_contact_company_office_id` ASC, `rfi_recipient_phone_contact_company_office_phone_number_id` ASC, `rfi_recipient_fax_contact_company_office_phone_number_id` ASC, `rfi_recipient_contact_mobile_phone_number_id` ASC, `rfi_initiator_contact_id` ASC, `rfi_initiator_contact_company_office_id` ASC, `rfi_initiator_phone_contact_company_office_phone_number_id` ASC, `rfi_initiator_fax_contact_company_office_phone_number_id` ASC, `rfi_initiator_contact_mobile_phone_number_id` ASC, `rfi_title` ASC, `rfi_plan_page_reference` ASC, `rfi_statement` ASC, `rfi_due_date` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpRequestForInformationDraft = new RequestForInformationDraft($database);
			$sqlOrderByColumns = $tmpRequestForInformationDraft->constructSqlOrderByColumns($arrOrderByAttributes);

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
	rfid.*

FROM `request_for_information_drafts` rfid
WHERE rfid.`rfi_creator_phone_contact_company_office_phone_number_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `request_for_information_type_id` ASC, `request_for_information_priority_id` ASC, `rfi_file_manager_file_id` ASC, `rfi_cost_code_id` ASC, `rfi_creator_contact_id` ASC, `rfi_creator_contact_company_office_id` ASC, `rfi_creator_phone_contact_company_office_phone_number_id` ASC, `rfi_creator_fax_contact_company_office_phone_number_id` ASC, `rfi_creator_contact_mobile_phone_number_id` ASC, `rfi_recipient_contact_id` ASC, `rfi_recipient_contact_company_office_id` ASC, `rfi_recipient_phone_contact_company_office_phone_number_id` ASC, `rfi_recipient_fax_contact_company_office_phone_number_id` ASC, `rfi_recipient_contact_mobile_phone_number_id` ASC, `rfi_initiator_contact_id` ASC, `rfi_initiator_contact_company_office_id` ASC, `rfi_initiator_phone_contact_company_office_phone_number_id` ASC, `rfi_initiator_fax_contact_company_office_phone_number_id` ASC, `rfi_initiator_contact_mobile_phone_number_id` ASC, `rfi_title` ASC, `rfi_plan_page_reference` ASC, `rfi_statement` ASC, `rfi_due_date` ASC
		$arrValues = array($rfi_creator_phone_contact_company_office_phone_number_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrRequestForInformationDraftsByRfiCreatorPhoneContactCompanyOfficePhoneNumberId = array();
		while ($row = $db->fetch()) {
			$request_for_information_draft_id = $row['id'];
			$requestForInformationDraft = self::instantiateOrm($database, 'RequestForInformationDraft', $row, null, $request_for_information_draft_id);
			/* @var $requestForInformationDraft RequestForInformationDraft */
			$arrRequestForInformationDraftsByRfiCreatorPhoneContactCompanyOfficePhoneNumberId[$request_for_information_draft_id] = $requestForInformationDraft;
		}

		$db->free_result();

		self::$_arrRequestForInformationDraftsByRfiCreatorPhoneContactCompanyOfficePhoneNumberId = $arrRequestForInformationDraftsByRfiCreatorPhoneContactCompanyOfficePhoneNumberId;

		return $arrRequestForInformationDraftsByRfiCreatorPhoneContactCompanyOfficePhoneNumberId;
	}

	/**
	 * Load by constraint `request_for_information_drafts_fk_creator_fax_ccopn` foreign key (`rfi_creator_fax_contact_company_office_phone_number_id`) references `contact_company_office_phone_numbers` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $rfi_creator_fax_contact_company_office_phone_number_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadRequestForInformationDraftsByRfiCreatorFaxContactCompanyOfficePhoneNumberId($database, $rfi_creator_fax_contact_company_office_phone_number_id, Input $options=null)
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
			self::$_arrRequestForInformationDraftsByRfiCreatorFaxContactCompanyOfficePhoneNumberId = null;
		}

		$arrRequestForInformationDraftsByRfiCreatorFaxContactCompanyOfficePhoneNumberId = self::$_arrRequestForInformationDraftsByRfiCreatorFaxContactCompanyOfficePhoneNumberId;
		if (isset($arrRequestForInformationDraftsByRfiCreatorFaxContactCompanyOfficePhoneNumberId) && !empty($arrRequestForInformationDraftsByRfiCreatorFaxContactCompanyOfficePhoneNumberId)) {
			return $arrRequestForInformationDraftsByRfiCreatorFaxContactCompanyOfficePhoneNumberId;
		}

		$rfi_creator_fax_contact_company_office_phone_number_id = (int) $rfi_creator_fax_contact_company_office_phone_number_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `request_for_information_type_id` ASC, `request_for_information_priority_id` ASC, `rfi_file_manager_file_id` ASC, `rfi_cost_code_id` ASC, `rfi_creator_contact_id` ASC, `rfi_creator_contact_company_office_id` ASC, `rfi_creator_phone_contact_company_office_phone_number_id` ASC, `rfi_creator_fax_contact_company_office_phone_number_id` ASC, `rfi_creator_contact_mobile_phone_number_id` ASC, `rfi_recipient_contact_id` ASC, `rfi_recipient_contact_company_office_id` ASC, `rfi_recipient_phone_contact_company_office_phone_number_id` ASC, `rfi_recipient_fax_contact_company_office_phone_number_id` ASC, `rfi_recipient_contact_mobile_phone_number_id` ASC, `rfi_initiator_contact_id` ASC, `rfi_initiator_contact_company_office_id` ASC, `rfi_initiator_phone_contact_company_office_phone_number_id` ASC, `rfi_initiator_fax_contact_company_office_phone_number_id` ASC, `rfi_initiator_contact_mobile_phone_number_id` ASC, `rfi_title` ASC, `rfi_plan_page_reference` ASC, `rfi_statement` ASC, `rfi_due_date` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpRequestForInformationDraft = new RequestForInformationDraft($database);
			$sqlOrderByColumns = $tmpRequestForInformationDraft->constructSqlOrderByColumns($arrOrderByAttributes);

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
	rfid.*

FROM `request_for_information_drafts` rfid
WHERE rfid.`rfi_creator_fax_contact_company_office_phone_number_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `request_for_information_type_id` ASC, `request_for_information_priority_id` ASC, `rfi_file_manager_file_id` ASC, `rfi_cost_code_id` ASC, `rfi_creator_contact_id` ASC, `rfi_creator_contact_company_office_id` ASC, `rfi_creator_phone_contact_company_office_phone_number_id` ASC, `rfi_creator_fax_contact_company_office_phone_number_id` ASC, `rfi_creator_contact_mobile_phone_number_id` ASC, `rfi_recipient_contact_id` ASC, `rfi_recipient_contact_company_office_id` ASC, `rfi_recipient_phone_contact_company_office_phone_number_id` ASC, `rfi_recipient_fax_contact_company_office_phone_number_id` ASC, `rfi_recipient_contact_mobile_phone_number_id` ASC, `rfi_initiator_contact_id` ASC, `rfi_initiator_contact_company_office_id` ASC, `rfi_initiator_phone_contact_company_office_phone_number_id` ASC, `rfi_initiator_fax_contact_company_office_phone_number_id` ASC, `rfi_initiator_contact_mobile_phone_number_id` ASC, `rfi_title` ASC, `rfi_plan_page_reference` ASC, `rfi_statement` ASC, `rfi_due_date` ASC
		$arrValues = array($rfi_creator_fax_contact_company_office_phone_number_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrRequestForInformationDraftsByRfiCreatorFaxContactCompanyOfficePhoneNumberId = array();
		while ($row = $db->fetch()) {
			$request_for_information_draft_id = $row['id'];
			$requestForInformationDraft = self::instantiateOrm($database, 'RequestForInformationDraft', $row, null, $request_for_information_draft_id);
			/* @var $requestForInformationDraft RequestForInformationDraft */
			$arrRequestForInformationDraftsByRfiCreatorFaxContactCompanyOfficePhoneNumberId[$request_for_information_draft_id] = $requestForInformationDraft;
		}

		$db->free_result();

		self::$_arrRequestForInformationDraftsByRfiCreatorFaxContactCompanyOfficePhoneNumberId = $arrRequestForInformationDraftsByRfiCreatorFaxContactCompanyOfficePhoneNumberId;

		return $arrRequestForInformationDraftsByRfiCreatorFaxContactCompanyOfficePhoneNumberId;
	}

	/**
	 * Load by constraint `request_for_information_drafts_fk_creator_c_mobile_cpn` foreign key (`rfi_creator_contact_mobile_phone_number_id`) references `contact_phone_numbers` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $rfi_creator_contact_mobile_phone_number_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadRequestForInformationDraftsByRfiCreatorContactMobilePhoneNumberId($database, $rfi_creator_contact_mobile_phone_number_id, Input $options=null)
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
			self::$_arrRequestForInformationDraftsByRfiCreatorContactMobilePhoneNumberId = null;
		}

		$arrRequestForInformationDraftsByRfiCreatorContactMobilePhoneNumberId = self::$_arrRequestForInformationDraftsByRfiCreatorContactMobilePhoneNumberId;
		if (isset($arrRequestForInformationDraftsByRfiCreatorContactMobilePhoneNumberId) && !empty($arrRequestForInformationDraftsByRfiCreatorContactMobilePhoneNumberId)) {
			return $arrRequestForInformationDraftsByRfiCreatorContactMobilePhoneNumberId;
		}

		$rfi_creator_contact_mobile_phone_number_id = (int) $rfi_creator_contact_mobile_phone_number_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `request_for_information_type_id` ASC, `request_for_information_priority_id` ASC, `rfi_file_manager_file_id` ASC, `rfi_cost_code_id` ASC, `rfi_creator_contact_id` ASC, `rfi_creator_contact_company_office_id` ASC, `rfi_creator_phone_contact_company_office_phone_number_id` ASC, `rfi_creator_fax_contact_company_office_phone_number_id` ASC, `rfi_creator_contact_mobile_phone_number_id` ASC, `rfi_recipient_contact_id` ASC, `rfi_recipient_contact_company_office_id` ASC, `rfi_recipient_phone_contact_company_office_phone_number_id` ASC, `rfi_recipient_fax_contact_company_office_phone_number_id` ASC, `rfi_recipient_contact_mobile_phone_number_id` ASC, `rfi_initiator_contact_id` ASC, `rfi_initiator_contact_company_office_id` ASC, `rfi_initiator_phone_contact_company_office_phone_number_id` ASC, `rfi_initiator_fax_contact_company_office_phone_number_id` ASC, `rfi_initiator_contact_mobile_phone_number_id` ASC, `rfi_title` ASC, `rfi_plan_page_reference` ASC, `rfi_statement` ASC, `rfi_due_date` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpRequestForInformationDraft = new RequestForInformationDraft($database);
			$sqlOrderByColumns = $tmpRequestForInformationDraft->constructSqlOrderByColumns($arrOrderByAttributes);

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
	rfid.*

FROM `request_for_information_drafts` rfid
WHERE rfid.`rfi_creator_contact_mobile_phone_number_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `request_for_information_type_id` ASC, `request_for_information_priority_id` ASC, `rfi_file_manager_file_id` ASC, `rfi_cost_code_id` ASC, `rfi_creator_contact_id` ASC, `rfi_creator_contact_company_office_id` ASC, `rfi_creator_phone_contact_company_office_phone_number_id` ASC, `rfi_creator_fax_contact_company_office_phone_number_id` ASC, `rfi_creator_contact_mobile_phone_number_id` ASC, `rfi_recipient_contact_id` ASC, `rfi_recipient_contact_company_office_id` ASC, `rfi_recipient_phone_contact_company_office_phone_number_id` ASC, `rfi_recipient_fax_contact_company_office_phone_number_id` ASC, `rfi_recipient_contact_mobile_phone_number_id` ASC, `rfi_initiator_contact_id` ASC, `rfi_initiator_contact_company_office_id` ASC, `rfi_initiator_phone_contact_company_office_phone_number_id` ASC, `rfi_initiator_fax_contact_company_office_phone_number_id` ASC, `rfi_initiator_contact_mobile_phone_number_id` ASC, `rfi_title` ASC, `rfi_plan_page_reference` ASC, `rfi_statement` ASC, `rfi_due_date` ASC
		$arrValues = array($rfi_creator_contact_mobile_phone_number_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrRequestForInformationDraftsByRfiCreatorContactMobilePhoneNumberId = array();
		while ($row = $db->fetch()) {
			$request_for_information_draft_id = $row['id'];
			$requestForInformationDraft = self::instantiateOrm($database, 'RequestForInformationDraft', $row, null, $request_for_information_draft_id);
			/* @var $requestForInformationDraft RequestForInformationDraft */
			$arrRequestForInformationDraftsByRfiCreatorContactMobilePhoneNumberId[$request_for_information_draft_id] = $requestForInformationDraft;
		}

		$db->free_result();

		self::$_arrRequestForInformationDraftsByRfiCreatorContactMobilePhoneNumberId = $arrRequestForInformationDraftsByRfiCreatorContactMobilePhoneNumberId;

		return $arrRequestForInformationDraftsByRfiCreatorContactMobilePhoneNumberId;
	}

	/**
	 * Load by constraint `request_for_information_drafts_fk_recipient_c` foreign key (`rfi_recipient_contact_id`) references `contacts` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $rfi_recipient_contact_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadRequestForInformationDraftsByRfiRecipientContactId($database, $rfi_recipient_contact_id, Input $options=null)
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
			self::$_arrRequestForInformationDraftsByRfiRecipientContactId = null;
		}

		$arrRequestForInformationDraftsByRfiRecipientContactId = self::$_arrRequestForInformationDraftsByRfiRecipientContactId;
		if (isset($arrRequestForInformationDraftsByRfiRecipientContactId) && !empty($arrRequestForInformationDraftsByRfiRecipientContactId)) {
			return $arrRequestForInformationDraftsByRfiRecipientContactId;
		}

		$rfi_recipient_contact_id = (int) $rfi_recipient_contact_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `request_for_information_type_id` ASC, `request_for_information_priority_id` ASC, `rfi_file_manager_file_id` ASC, `rfi_cost_code_id` ASC, `rfi_creator_contact_id` ASC, `rfi_creator_contact_company_office_id` ASC, `rfi_creator_phone_contact_company_office_phone_number_id` ASC, `rfi_creator_fax_contact_company_office_phone_number_id` ASC, `rfi_creator_contact_mobile_phone_number_id` ASC, `rfi_recipient_contact_id` ASC, `rfi_recipient_contact_company_office_id` ASC, `rfi_recipient_phone_contact_company_office_phone_number_id` ASC, `rfi_recipient_fax_contact_company_office_phone_number_id` ASC, `rfi_recipient_contact_mobile_phone_number_id` ASC, `rfi_initiator_contact_id` ASC, `rfi_initiator_contact_company_office_id` ASC, `rfi_initiator_phone_contact_company_office_phone_number_id` ASC, `rfi_initiator_fax_contact_company_office_phone_number_id` ASC, `rfi_initiator_contact_mobile_phone_number_id` ASC, `rfi_title` ASC, `rfi_plan_page_reference` ASC, `rfi_statement` ASC, `rfi_due_date` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpRequestForInformationDraft = new RequestForInformationDraft($database);
			$sqlOrderByColumns = $tmpRequestForInformationDraft->constructSqlOrderByColumns($arrOrderByAttributes);

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
	rfid.*

FROM `request_for_information_drafts` rfid
WHERE rfid.`rfi_recipient_contact_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `request_for_information_type_id` ASC, `request_for_information_priority_id` ASC, `rfi_file_manager_file_id` ASC, `rfi_cost_code_id` ASC, `rfi_creator_contact_id` ASC, `rfi_creator_contact_company_office_id` ASC, `rfi_creator_phone_contact_company_office_phone_number_id` ASC, `rfi_creator_fax_contact_company_office_phone_number_id` ASC, `rfi_creator_contact_mobile_phone_number_id` ASC, `rfi_recipient_contact_id` ASC, `rfi_recipient_contact_company_office_id` ASC, `rfi_recipient_phone_contact_company_office_phone_number_id` ASC, `rfi_recipient_fax_contact_company_office_phone_number_id` ASC, `rfi_recipient_contact_mobile_phone_number_id` ASC, `rfi_initiator_contact_id` ASC, `rfi_initiator_contact_company_office_id` ASC, `rfi_initiator_phone_contact_company_office_phone_number_id` ASC, `rfi_initiator_fax_contact_company_office_phone_number_id` ASC, `rfi_initiator_contact_mobile_phone_number_id` ASC, `rfi_title` ASC, `rfi_plan_page_reference` ASC, `rfi_statement` ASC, `rfi_due_date` ASC
		$arrValues = array($rfi_recipient_contact_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrRequestForInformationDraftsByRfiRecipientContactId = array();
		while ($row = $db->fetch()) {
			$request_for_information_draft_id = $row['id'];
			$requestForInformationDraft = self::instantiateOrm($database, 'RequestForInformationDraft', $row, null, $request_for_information_draft_id);
			/* @var $requestForInformationDraft RequestForInformationDraft */
			$arrRequestForInformationDraftsByRfiRecipientContactId[$request_for_information_draft_id] = $requestForInformationDraft;
		}

		$db->free_result();

		self::$_arrRequestForInformationDraftsByRfiRecipientContactId = $arrRequestForInformationDraftsByRfiRecipientContactId;

		return $arrRequestForInformationDraftsByRfiRecipientContactId;
	}

	/**
	 * Load by constraint `request_for_information_drafts_fk_recipient_cco` foreign key (`rfi_recipient_contact_company_office_id`) references `contact_company_offices` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $rfi_recipient_contact_company_office_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadRequestForInformationDraftsByRfiRecipientContactCompanyOfficeId($database, $rfi_recipient_contact_company_office_id, Input $options=null)
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
			self::$_arrRequestForInformationDraftsByRfiRecipientContactCompanyOfficeId = null;
		}

		$arrRequestForInformationDraftsByRfiRecipientContactCompanyOfficeId = self::$_arrRequestForInformationDraftsByRfiRecipientContactCompanyOfficeId;
		if (isset($arrRequestForInformationDraftsByRfiRecipientContactCompanyOfficeId) && !empty($arrRequestForInformationDraftsByRfiRecipientContactCompanyOfficeId)) {
			return $arrRequestForInformationDraftsByRfiRecipientContactCompanyOfficeId;
		}

		$rfi_recipient_contact_company_office_id = (int) $rfi_recipient_contact_company_office_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `request_for_information_type_id` ASC, `request_for_information_priority_id` ASC, `rfi_file_manager_file_id` ASC, `rfi_cost_code_id` ASC, `rfi_creator_contact_id` ASC, `rfi_creator_contact_company_office_id` ASC, `rfi_creator_phone_contact_company_office_phone_number_id` ASC, `rfi_creator_fax_contact_company_office_phone_number_id` ASC, `rfi_creator_contact_mobile_phone_number_id` ASC, `rfi_recipient_contact_id` ASC, `rfi_recipient_contact_company_office_id` ASC, `rfi_recipient_phone_contact_company_office_phone_number_id` ASC, `rfi_recipient_fax_contact_company_office_phone_number_id` ASC, `rfi_recipient_contact_mobile_phone_number_id` ASC, `rfi_initiator_contact_id` ASC, `rfi_initiator_contact_company_office_id` ASC, `rfi_initiator_phone_contact_company_office_phone_number_id` ASC, `rfi_initiator_fax_contact_company_office_phone_number_id` ASC, `rfi_initiator_contact_mobile_phone_number_id` ASC, `rfi_title` ASC, `rfi_plan_page_reference` ASC, `rfi_statement` ASC, `rfi_due_date` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpRequestForInformationDraft = new RequestForInformationDraft($database);
			$sqlOrderByColumns = $tmpRequestForInformationDraft->constructSqlOrderByColumns($arrOrderByAttributes);

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
	rfid.*

FROM `request_for_information_drafts` rfid
WHERE rfid.`rfi_recipient_contact_company_office_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `request_for_information_type_id` ASC, `request_for_information_priority_id` ASC, `rfi_file_manager_file_id` ASC, `rfi_cost_code_id` ASC, `rfi_creator_contact_id` ASC, `rfi_creator_contact_company_office_id` ASC, `rfi_creator_phone_contact_company_office_phone_number_id` ASC, `rfi_creator_fax_contact_company_office_phone_number_id` ASC, `rfi_creator_contact_mobile_phone_number_id` ASC, `rfi_recipient_contact_id` ASC, `rfi_recipient_contact_company_office_id` ASC, `rfi_recipient_phone_contact_company_office_phone_number_id` ASC, `rfi_recipient_fax_contact_company_office_phone_number_id` ASC, `rfi_recipient_contact_mobile_phone_number_id` ASC, `rfi_initiator_contact_id` ASC, `rfi_initiator_contact_company_office_id` ASC, `rfi_initiator_phone_contact_company_office_phone_number_id` ASC, `rfi_initiator_fax_contact_company_office_phone_number_id` ASC, `rfi_initiator_contact_mobile_phone_number_id` ASC, `rfi_title` ASC, `rfi_plan_page_reference` ASC, `rfi_statement` ASC, `rfi_due_date` ASC
		$arrValues = array($rfi_recipient_contact_company_office_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrRequestForInformationDraftsByRfiRecipientContactCompanyOfficeId = array();
		while ($row = $db->fetch()) {
			$request_for_information_draft_id = $row['id'];
			$requestForInformationDraft = self::instantiateOrm($database, 'RequestForInformationDraft', $row, null, $request_for_information_draft_id);
			/* @var $requestForInformationDraft RequestForInformationDraft */
			$arrRequestForInformationDraftsByRfiRecipientContactCompanyOfficeId[$request_for_information_draft_id] = $requestForInformationDraft;
		}

		$db->free_result();

		self::$_arrRequestForInformationDraftsByRfiRecipientContactCompanyOfficeId = $arrRequestForInformationDraftsByRfiRecipientContactCompanyOfficeId;

		return $arrRequestForInformationDraftsByRfiRecipientContactCompanyOfficeId;
	}

	/**
	 * Load by constraint `request_for_information_drafts_fk_recipient_phone_ccopn` foreign key (`rfi_recipient_phone_contact_company_office_phone_number_id`) references `contact_company_office_phone_numbers` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $rfi_recipient_phone_contact_company_office_phone_number_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadRequestForInformationDraftsByRfiRecipientPhoneContactCompanyOfficePhoneNumberId($database, $rfi_recipient_phone_contact_company_office_phone_number_id, Input $options=null)
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
			self::$_arrRequestForInformationDraftsByRfiRecipientPhoneContactCompanyOfficePhoneNumberId = null;
		}

		$arrRequestForInformationDraftsByRfiRecipientPhoneContactCompanyOfficePhoneNumberId = self::$_arrRequestForInformationDraftsByRfiRecipientPhoneContactCompanyOfficePhoneNumberId;
		if (isset($arrRequestForInformationDraftsByRfiRecipientPhoneContactCompanyOfficePhoneNumberId) && !empty($arrRequestForInformationDraftsByRfiRecipientPhoneContactCompanyOfficePhoneNumberId)) {
			return $arrRequestForInformationDraftsByRfiRecipientPhoneContactCompanyOfficePhoneNumberId;
		}

		$rfi_recipient_phone_contact_company_office_phone_number_id = (int) $rfi_recipient_phone_contact_company_office_phone_number_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `request_for_information_type_id` ASC, `request_for_information_priority_id` ASC, `rfi_file_manager_file_id` ASC, `rfi_cost_code_id` ASC, `rfi_creator_contact_id` ASC, `rfi_creator_contact_company_office_id` ASC, `rfi_creator_phone_contact_company_office_phone_number_id` ASC, `rfi_creator_fax_contact_company_office_phone_number_id` ASC, `rfi_creator_contact_mobile_phone_number_id` ASC, `rfi_recipient_contact_id` ASC, `rfi_recipient_contact_company_office_id` ASC, `rfi_recipient_phone_contact_company_office_phone_number_id` ASC, `rfi_recipient_fax_contact_company_office_phone_number_id` ASC, `rfi_recipient_contact_mobile_phone_number_id` ASC, `rfi_initiator_contact_id` ASC, `rfi_initiator_contact_company_office_id` ASC, `rfi_initiator_phone_contact_company_office_phone_number_id` ASC, `rfi_initiator_fax_contact_company_office_phone_number_id` ASC, `rfi_initiator_contact_mobile_phone_number_id` ASC, `rfi_title` ASC, `rfi_plan_page_reference` ASC, `rfi_statement` ASC, `rfi_due_date` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpRequestForInformationDraft = new RequestForInformationDraft($database);
			$sqlOrderByColumns = $tmpRequestForInformationDraft->constructSqlOrderByColumns($arrOrderByAttributes);

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
	rfid.*

FROM `request_for_information_drafts` rfid
WHERE rfid.`rfi_recipient_phone_contact_company_office_phone_number_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `request_for_information_type_id` ASC, `request_for_information_priority_id` ASC, `rfi_file_manager_file_id` ASC, `rfi_cost_code_id` ASC, `rfi_creator_contact_id` ASC, `rfi_creator_contact_company_office_id` ASC, `rfi_creator_phone_contact_company_office_phone_number_id` ASC, `rfi_creator_fax_contact_company_office_phone_number_id` ASC, `rfi_creator_contact_mobile_phone_number_id` ASC, `rfi_recipient_contact_id` ASC, `rfi_recipient_contact_company_office_id` ASC, `rfi_recipient_phone_contact_company_office_phone_number_id` ASC, `rfi_recipient_fax_contact_company_office_phone_number_id` ASC, `rfi_recipient_contact_mobile_phone_number_id` ASC, `rfi_initiator_contact_id` ASC, `rfi_initiator_contact_company_office_id` ASC, `rfi_initiator_phone_contact_company_office_phone_number_id` ASC, `rfi_initiator_fax_contact_company_office_phone_number_id` ASC, `rfi_initiator_contact_mobile_phone_number_id` ASC, `rfi_title` ASC, `rfi_plan_page_reference` ASC, `rfi_statement` ASC, `rfi_due_date` ASC
		$arrValues = array($rfi_recipient_phone_contact_company_office_phone_number_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrRequestForInformationDraftsByRfiRecipientPhoneContactCompanyOfficePhoneNumberId = array();
		while ($row = $db->fetch()) {
			$request_for_information_draft_id = $row['id'];
			$requestForInformationDraft = self::instantiateOrm($database, 'RequestForInformationDraft', $row, null, $request_for_information_draft_id);
			/* @var $requestForInformationDraft RequestForInformationDraft */
			$arrRequestForInformationDraftsByRfiRecipientPhoneContactCompanyOfficePhoneNumberId[$request_for_information_draft_id] = $requestForInformationDraft;
		}

		$db->free_result();

		self::$_arrRequestForInformationDraftsByRfiRecipientPhoneContactCompanyOfficePhoneNumberId = $arrRequestForInformationDraftsByRfiRecipientPhoneContactCompanyOfficePhoneNumberId;

		return $arrRequestForInformationDraftsByRfiRecipientPhoneContactCompanyOfficePhoneNumberId;
	}

	/**
	 * Load by constraint `request_for_information_drafts_fk_recipient_fax_ccopn` foreign key (`rfi_recipient_fax_contact_company_office_phone_number_id`) references `contact_company_office_phone_numbers` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $rfi_recipient_fax_contact_company_office_phone_number_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadRequestForInformationDraftsByRfiRecipientFaxContactCompanyOfficePhoneNumberId($database, $rfi_recipient_fax_contact_company_office_phone_number_id, Input $options=null)
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
			self::$_arrRequestForInformationDraftsByRfiRecipientFaxContactCompanyOfficePhoneNumberId = null;
		}

		$arrRequestForInformationDraftsByRfiRecipientFaxContactCompanyOfficePhoneNumberId = self::$_arrRequestForInformationDraftsByRfiRecipientFaxContactCompanyOfficePhoneNumberId;
		if (isset($arrRequestForInformationDraftsByRfiRecipientFaxContactCompanyOfficePhoneNumberId) && !empty($arrRequestForInformationDraftsByRfiRecipientFaxContactCompanyOfficePhoneNumberId)) {
			return $arrRequestForInformationDraftsByRfiRecipientFaxContactCompanyOfficePhoneNumberId;
		}

		$rfi_recipient_fax_contact_company_office_phone_number_id = (int) $rfi_recipient_fax_contact_company_office_phone_number_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `request_for_information_type_id` ASC, `request_for_information_priority_id` ASC, `rfi_file_manager_file_id` ASC, `rfi_cost_code_id` ASC, `rfi_creator_contact_id` ASC, `rfi_creator_contact_company_office_id` ASC, `rfi_creator_phone_contact_company_office_phone_number_id` ASC, `rfi_creator_fax_contact_company_office_phone_number_id` ASC, `rfi_creator_contact_mobile_phone_number_id` ASC, `rfi_recipient_contact_id` ASC, `rfi_recipient_contact_company_office_id` ASC, `rfi_recipient_phone_contact_company_office_phone_number_id` ASC, `rfi_recipient_fax_contact_company_office_phone_number_id` ASC, `rfi_recipient_contact_mobile_phone_number_id` ASC, `rfi_initiator_contact_id` ASC, `rfi_initiator_contact_company_office_id` ASC, `rfi_initiator_phone_contact_company_office_phone_number_id` ASC, `rfi_initiator_fax_contact_company_office_phone_number_id` ASC, `rfi_initiator_contact_mobile_phone_number_id` ASC, `rfi_title` ASC, `rfi_plan_page_reference` ASC, `rfi_statement` ASC, `rfi_due_date` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpRequestForInformationDraft = new RequestForInformationDraft($database);
			$sqlOrderByColumns = $tmpRequestForInformationDraft->constructSqlOrderByColumns($arrOrderByAttributes);

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
	rfid.*

FROM `request_for_information_drafts` rfid
WHERE rfid.`rfi_recipient_fax_contact_company_office_phone_number_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `request_for_information_type_id` ASC, `request_for_information_priority_id` ASC, `rfi_file_manager_file_id` ASC, `rfi_cost_code_id` ASC, `rfi_creator_contact_id` ASC, `rfi_creator_contact_company_office_id` ASC, `rfi_creator_phone_contact_company_office_phone_number_id` ASC, `rfi_creator_fax_contact_company_office_phone_number_id` ASC, `rfi_creator_contact_mobile_phone_number_id` ASC, `rfi_recipient_contact_id` ASC, `rfi_recipient_contact_company_office_id` ASC, `rfi_recipient_phone_contact_company_office_phone_number_id` ASC, `rfi_recipient_fax_contact_company_office_phone_number_id` ASC, `rfi_recipient_contact_mobile_phone_number_id` ASC, `rfi_initiator_contact_id` ASC, `rfi_initiator_contact_company_office_id` ASC, `rfi_initiator_phone_contact_company_office_phone_number_id` ASC, `rfi_initiator_fax_contact_company_office_phone_number_id` ASC, `rfi_initiator_contact_mobile_phone_number_id` ASC, `rfi_title` ASC, `rfi_plan_page_reference` ASC, `rfi_statement` ASC, `rfi_due_date` ASC
		$arrValues = array($rfi_recipient_fax_contact_company_office_phone_number_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrRequestForInformationDraftsByRfiRecipientFaxContactCompanyOfficePhoneNumberId = array();
		while ($row = $db->fetch()) {
			$request_for_information_draft_id = $row['id'];
			$requestForInformationDraft = self::instantiateOrm($database, 'RequestForInformationDraft', $row, null, $request_for_information_draft_id);
			/* @var $requestForInformationDraft RequestForInformationDraft */
			$arrRequestForInformationDraftsByRfiRecipientFaxContactCompanyOfficePhoneNumberId[$request_for_information_draft_id] = $requestForInformationDraft;
		}

		$db->free_result();

		self::$_arrRequestForInformationDraftsByRfiRecipientFaxContactCompanyOfficePhoneNumberId = $arrRequestForInformationDraftsByRfiRecipientFaxContactCompanyOfficePhoneNumberId;

		return $arrRequestForInformationDraftsByRfiRecipientFaxContactCompanyOfficePhoneNumberId;
	}

	/**
	 * Load by constraint `request_for_information_drafts_fk_recipient_c_mobile_cpn` foreign key (`rfi_recipient_contact_mobile_phone_number_id`) references `contact_phone_numbers` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $rfi_recipient_contact_mobile_phone_number_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadRequestForInformationDraftsByRfiRecipientContactMobilePhoneNumberId($database, $rfi_recipient_contact_mobile_phone_number_id, Input $options=null)
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
			self::$_arrRequestForInformationDraftsByRfiRecipientContactMobilePhoneNumberId = null;
		}

		$arrRequestForInformationDraftsByRfiRecipientContactMobilePhoneNumberId = self::$_arrRequestForInformationDraftsByRfiRecipientContactMobilePhoneNumberId;
		if (isset($arrRequestForInformationDraftsByRfiRecipientContactMobilePhoneNumberId) && !empty($arrRequestForInformationDraftsByRfiRecipientContactMobilePhoneNumberId)) {
			return $arrRequestForInformationDraftsByRfiRecipientContactMobilePhoneNumberId;
		}

		$rfi_recipient_contact_mobile_phone_number_id = (int) $rfi_recipient_contact_mobile_phone_number_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `request_for_information_type_id` ASC, `request_for_information_priority_id` ASC, `rfi_file_manager_file_id` ASC, `rfi_cost_code_id` ASC, `rfi_creator_contact_id` ASC, `rfi_creator_contact_company_office_id` ASC, `rfi_creator_phone_contact_company_office_phone_number_id` ASC, `rfi_creator_fax_contact_company_office_phone_number_id` ASC, `rfi_creator_contact_mobile_phone_number_id` ASC, `rfi_recipient_contact_id` ASC, `rfi_recipient_contact_company_office_id` ASC, `rfi_recipient_phone_contact_company_office_phone_number_id` ASC, `rfi_recipient_fax_contact_company_office_phone_number_id` ASC, `rfi_recipient_contact_mobile_phone_number_id` ASC, `rfi_initiator_contact_id` ASC, `rfi_initiator_contact_company_office_id` ASC, `rfi_initiator_phone_contact_company_office_phone_number_id` ASC, `rfi_initiator_fax_contact_company_office_phone_number_id` ASC, `rfi_initiator_contact_mobile_phone_number_id` ASC, `rfi_title` ASC, `rfi_plan_page_reference` ASC, `rfi_statement` ASC, `rfi_due_date` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpRequestForInformationDraft = new RequestForInformationDraft($database);
			$sqlOrderByColumns = $tmpRequestForInformationDraft->constructSqlOrderByColumns($arrOrderByAttributes);

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
	rfid.*

FROM `request_for_information_drafts` rfid
WHERE rfid.`rfi_recipient_contact_mobile_phone_number_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `request_for_information_type_id` ASC, `request_for_information_priority_id` ASC, `rfi_file_manager_file_id` ASC, `rfi_cost_code_id` ASC, `rfi_creator_contact_id` ASC, `rfi_creator_contact_company_office_id` ASC, `rfi_creator_phone_contact_company_office_phone_number_id` ASC, `rfi_creator_fax_contact_company_office_phone_number_id` ASC, `rfi_creator_contact_mobile_phone_number_id` ASC, `rfi_recipient_contact_id` ASC, `rfi_recipient_contact_company_office_id` ASC, `rfi_recipient_phone_contact_company_office_phone_number_id` ASC, `rfi_recipient_fax_contact_company_office_phone_number_id` ASC, `rfi_recipient_contact_mobile_phone_number_id` ASC, `rfi_initiator_contact_id` ASC, `rfi_initiator_contact_company_office_id` ASC, `rfi_initiator_phone_contact_company_office_phone_number_id` ASC, `rfi_initiator_fax_contact_company_office_phone_number_id` ASC, `rfi_initiator_contact_mobile_phone_number_id` ASC, `rfi_title` ASC, `rfi_plan_page_reference` ASC, `rfi_statement` ASC, `rfi_due_date` ASC
		$arrValues = array($rfi_recipient_contact_mobile_phone_number_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrRequestForInformationDraftsByRfiRecipientContactMobilePhoneNumberId = array();
		while ($row = $db->fetch()) {
			$request_for_information_draft_id = $row['id'];
			$requestForInformationDraft = self::instantiateOrm($database, 'RequestForInformationDraft', $row, null, $request_for_information_draft_id);
			/* @var $requestForInformationDraft RequestForInformationDraft */
			$arrRequestForInformationDraftsByRfiRecipientContactMobilePhoneNumberId[$request_for_information_draft_id] = $requestForInformationDraft;
		}

		$db->free_result();

		self::$_arrRequestForInformationDraftsByRfiRecipientContactMobilePhoneNumberId = $arrRequestForInformationDraftsByRfiRecipientContactMobilePhoneNumberId;

		return $arrRequestForInformationDraftsByRfiRecipientContactMobilePhoneNumberId;
	}

	/**
	 * Load by constraint `request_for_information_drafts_fk_initiator_c` foreign key (`rfi_initiator_contact_id`) references `contacts` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $rfi_initiator_contact_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadRequestForInformationDraftsByRfiInitiatorContactId($database, $rfi_initiator_contact_id, Input $options=null)
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
			self::$_arrRequestForInformationDraftsByRfiInitiatorContactId = null;
		}

		$arrRequestForInformationDraftsByRfiInitiatorContactId = self::$_arrRequestForInformationDraftsByRfiInitiatorContactId;
		if (isset($arrRequestForInformationDraftsByRfiInitiatorContactId) && !empty($arrRequestForInformationDraftsByRfiInitiatorContactId)) {
			return $arrRequestForInformationDraftsByRfiInitiatorContactId;
		}

		$rfi_initiator_contact_id = (int) $rfi_initiator_contact_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `request_for_information_type_id` ASC, `request_for_information_priority_id` ASC, `rfi_file_manager_file_id` ASC, `rfi_cost_code_id` ASC, `rfi_creator_contact_id` ASC, `rfi_creator_contact_company_office_id` ASC, `rfi_creator_phone_contact_company_office_phone_number_id` ASC, `rfi_creator_fax_contact_company_office_phone_number_id` ASC, `rfi_creator_contact_mobile_phone_number_id` ASC, `rfi_recipient_contact_id` ASC, `rfi_recipient_contact_company_office_id` ASC, `rfi_recipient_phone_contact_company_office_phone_number_id` ASC, `rfi_recipient_fax_contact_company_office_phone_number_id` ASC, `rfi_recipient_contact_mobile_phone_number_id` ASC, `rfi_initiator_contact_id` ASC, `rfi_initiator_contact_company_office_id` ASC, `rfi_initiator_phone_contact_company_office_phone_number_id` ASC, `rfi_initiator_fax_contact_company_office_phone_number_id` ASC, `rfi_initiator_contact_mobile_phone_number_id` ASC, `rfi_title` ASC, `rfi_plan_page_reference` ASC, `rfi_statement` ASC, `rfi_due_date` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpRequestForInformationDraft = new RequestForInformationDraft($database);
			$sqlOrderByColumns = $tmpRequestForInformationDraft->constructSqlOrderByColumns($arrOrderByAttributes);

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
	rfid.*

FROM `request_for_information_drafts` rfid
WHERE rfid.`rfi_initiator_contact_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `request_for_information_type_id` ASC, `request_for_information_priority_id` ASC, `rfi_file_manager_file_id` ASC, `rfi_cost_code_id` ASC, `rfi_creator_contact_id` ASC, `rfi_creator_contact_company_office_id` ASC, `rfi_creator_phone_contact_company_office_phone_number_id` ASC, `rfi_creator_fax_contact_company_office_phone_number_id` ASC, `rfi_creator_contact_mobile_phone_number_id` ASC, `rfi_recipient_contact_id` ASC, `rfi_recipient_contact_company_office_id` ASC, `rfi_recipient_phone_contact_company_office_phone_number_id` ASC, `rfi_recipient_fax_contact_company_office_phone_number_id` ASC, `rfi_recipient_contact_mobile_phone_number_id` ASC, `rfi_initiator_contact_id` ASC, `rfi_initiator_contact_company_office_id` ASC, `rfi_initiator_phone_contact_company_office_phone_number_id` ASC, `rfi_initiator_fax_contact_company_office_phone_number_id` ASC, `rfi_initiator_contact_mobile_phone_number_id` ASC, `rfi_title` ASC, `rfi_plan_page_reference` ASC, `rfi_statement` ASC, `rfi_due_date` ASC
		$arrValues = array($rfi_initiator_contact_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrRequestForInformationDraftsByRfiInitiatorContactId = array();
		while ($row = $db->fetch()) {
			$request_for_information_draft_id = $row['id'];
			$requestForInformationDraft = self::instantiateOrm($database, 'RequestForInformationDraft', $row, null, $request_for_information_draft_id);
			/* @var $requestForInformationDraft RequestForInformationDraft */
			$arrRequestForInformationDraftsByRfiInitiatorContactId[$request_for_information_draft_id] = $requestForInformationDraft;
		}

		$db->free_result();

		self::$_arrRequestForInformationDraftsByRfiInitiatorContactId = $arrRequestForInformationDraftsByRfiInitiatorContactId;

		return $arrRequestForInformationDraftsByRfiInitiatorContactId;
	}

	/**
	 * Load by constraint `request_for_information_drafts_fk_initiator_cco` foreign key (`rfi_initiator_contact_company_office_id`) references `contact_company_offices` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $rfi_initiator_contact_company_office_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadRequestForInformationDraftsByRfiInitiatorContactCompanyOfficeId($database, $rfi_initiator_contact_company_office_id, Input $options=null)
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
			self::$_arrRequestForInformationDraftsByRfiInitiatorContactCompanyOfficeId = null;
		}

		$arrRequestForInformationDraftsByRfiInitiatorContactCompanyOfficeId = self::$_arrRequestForInformationDraftsByRfiInitiatorContactCompanyOfficeId;
		if (isset($arrRequestForInformationDraftsByRfiInitiatorContactCompanyOfficeId) && !empty($arrRequestForInformationDraftsByRfiInitiatorContactCompanyOfficeId)) {
			return $arrRequestForInformationDraftsByRfiInitiatorContactCompanyOfficeId;
		}

		$rfi_initiator_contact_company_office_id = (int) $rfi_initiator_contact_company_office_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `request_for_information_type_id` ASC, `request_for_information_priority_id` ASC, `rfi_file_manager_file_id` ASC, `rfi_cost_code_id` ASC, `rfi_creator_contact_id` ASC, `rfi_creator_contact_company_office_id` ASC, `rfi_creator_phone_contact_company_office_phone_number_id` ASC, `rfi_creator_fax_contact_company_office_phone_number_id` ASC, `rfi_creator_contact_mobile_phone_number_id` ASC, `rfi_recipient_contact_id` ASC, `rfi_recipient_contact_company_office_id` ASC, `rfi_recipient_phone_contact_company_office_phone_number_id` ASC, `rfi_recipient_fax_contact_company_office_phone_number_id` ASC, `rfi_recipient_contact_mobile_phone_number_id` ASC, `rfi_initiator_contact_id` ASC, `rfi_initiator_contact_company_office_id` ASC, `rfi_initiator_phone_contact_company_office_phone_number_id` ASC, `rfi_initiator_fax_contact_company_office_phone_number_id` ASC, `rfi_initiator_contact_mobile_phone_number_id` ASC, `rfi_title` ASC, `rfi_plan_page_reference` ASC, `rfi_statement` ASC, `rfi_due_date` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpRequestForInformationDraft = new RequestForInformationDraft($database);
			$sqlOrderByColumns = $tmpRequestForInformationDraft->constructSqlOrderByColumns($arrOrderByAttributes);

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
	rfid.*

FROM `request_for_information_drafts` rfid
WHERE rfid.`rfi_initiator_contact_company_office_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `request_for_information_type_id` ASC, `request_for_information_priority_id` ASC, `rfi_file_manager_file_id` ASC, `rfi_cost_code_id` ASC, `rfi_creator_contact_id` ASC, `rfi_creator_contact_company_office_id` ASC, `rfi_creator_phone_contact_company_office_phone_number_id` ASC, `rfi_creator_fax_contact_company_office_phone_number_id` ASC, `rfi_creator_contact_mobile_phone_number_id` ASC, `rfi_recipient_contact_id` ASC, `rfi_recipient_contact_company_office_id` ASC, `rfi_recipient_phone_contact_company_office_phone_number_id` ASC, `rfi_recipient_fax_contact_company_office_phone_number_id` ASC, `rfi_recipient_contact_mobile_phone_number_id` ASC, `rfi_initiator_contact_id` ASC, `rfi_initiator_contact_company_office_id` ASC, `rfi_initiator_phone_contact_company_office_phone_number_id` ASC, `rfi_initiator_fax_contact_company_office_phone_number_id` ASC, `rfi_initiator_contact_mobile_phone_number_id` ASC, `rfi_title` ASC, `rfi_plan_page_reference` ASC, `rfi_statement` ASC, `rfi_due_date` ASC
		$arrValues = array($rfi_initiator_contact_company_office_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrRequestForInformationDraftsByRfiInitiatorContactCompanyOfficeId = array();
		while ($row = $db->fetch()) {
			$request_for_information_draft_id = $row['id'];
			$requestForInformationDraft = self::instantiateOrm($database, 'RequestForInformationDraft', $row, null, $request_for_information_draft_id);
			/* @var $requestForInformationDraft RequestForInformationDraft */
			$arrRequestForInformationDraftsByRfiInitiatorContactCompanyOfficeId[$request_for_information_draft_id] = $requestForInformationDraft;
		}

		$db->free_result();

		self::$_arrRequestForInformationDraftsByRfiInitiatorContactCompanyOfficeId = $arrRequestForInformationDraftsByRfiInitiatorContactCompanyOfficeId;

		return $arrRequestForInformationDraftsByRfiInitiatorContactCompanyOfficeId;
	}

	/**
	 * Load by constraint `request_for_information_drafts_fk_initiator_phone_ccopn` foreign key (`rfi_initiator_phone_contact_company_office_phone_number_id`) references `contact_company_office_phone_numbers` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $rfi_initiator_phone_contact_company_office_phone_number_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadRequestForInformationDraftsByRfiInitiatorPhoneContactCompanyOfficePhoneNumberId($database, $rfi_initiator_phone_contact_company_office_phone_number_id, Input $options=null)
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
			self::$_arrRequestForInformationDraftsByRfiInitiatorPhoneContactCompanyOfficePhoneNumberId = null;
		}

		$arrRequestForInformationDraftsByRfiInitiatorPhoneContactCompanyOfficePhoneNumberId = self::$_arrRequestForInformationDraftsByRfiInitiatorPhoneContactCompanyOfficePhoneNumberId;
		if (isset($arrRequestForInformationDraftsByRfiInitiatorPhoneContactCompanyOfficePhoneNumberId) && !empty($arrRequestForInformationDraftsByRfiInitiatorPhoneContactCompanyOfficePhoneNumberId)) {
			return $arrRequestForInformationDraftsByRfiInitiatorPhoneContactCompanyOfficePhoneNumberId;
		}

		$rfi_initiator_phone_contact_company_office_phone_number_id = (int) $rfi_initiator_phone_contact_company_office_phone_number_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `request_for_information_type_id` ASC, `request_for_information_priority_id` ASC, `rfi_file_manager_file_id` ASC, `rfi_cost_code_id` ASC, `rfi_creator_contact_id` ASC, `rfi_creator_contact_company_office_id` ASC, `rfi_creator_phone_contact_company_office_phone_number_id` ASC, `rfi_creator_fax_contact_company_office_phone_number_id` ASC, `rfi_creator_contact_mobile_phone_number_id` ASC, `rfi_recipient_contact_id` ASC, `rfi_recipient_contact_company_office_id` ASC, `rfi_recipient_phone_contact_company_office_phone_number_id` ASC, `rfi_recipient_fax_contact_company_office_phone_number_id` ASC, `rfi_recipient_contact_mobile_phone_number_id` ASC, `rfi_initiator_contact_id` ASC, `rfi_initiator_contact_company_office_id` ASC, `rfi_initiator_phone_contact_company_office_phone_number_id` ASC, `rfi_initiator_fax_contact_company_office_phone_number_id` ASC, `rfi_initiator_contact_mobile_phone_number_id` ASC, `rfi_title` ASC, `rfi_plan_page_reference` ASC, `rfi_statement` ASC, `rfi_due_date` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpRequestForInformationDraft = new RequestForInformationDraft($database);
			$sqlOrderByColumns = $tmpRequestForInformationDraft->constructSqlOrderByColumns($arrOrderByAttributes);

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
	rfid.*

FROM `request_for_information_drafts` rfid
WHERE rfid.`rfi_initiator_phone_contact_company_office_phone_number_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `request_for_information_type_id` ASC, `request_for_information_priority_id` ASC, `rfi_file_manager_file_id` ASC, `rfi_cost_code_id` ASC, `rfi_creator_contact_id` ASC, `rfi_creator_contact_company_office_id` ASC, `rfi_creator_phone_contact_company_office_phone_number_id` ASC, `rfi_creator_fax_contact_company_office_phone_number_id` ASC, `rfi_creator_contact_mobile_phone_number_id` ASC, `rfi_recipient_contact_id` ASC, `rfi_recipient_contact_company_office_id` ASC, `rfi_recipient_phone_contact_company_office_phone_number_id` ASC, `rfi_recipient_fax_contact_company_office_phone_number_id` ASC, `rfi_recipient_contact_mobile_phone_number_id` ASC, `rfi_initiator_contact_id` ASC, `rfi_initiator_contact_company_office_id` ASC, `rfi_initiator_phone_contact_company_office_phone_number_id` ASC, `rfi_initiator_fax_contact_company_office_phone_number_id` ASC, `rfi_initiator_contact_mobile_phone_number_id` ASC, `rfi_title` ASC, `rfi_plan_page_reference` ASC, `rfi_statement` ASC, `rfi_due_date` ASC
		$arrValues = array($rfi_initiator_phone_contact_company_office_phone_number_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrRequestForInformationDraftsByRfiInitiatorPhoneContactCompanyOfficePhoneNumberId = array();
		while ($row = $db->fetch()) {
			$request_for_information_draft_id = $row['id'];
			$requestForInformationDraft = self::instantiateOrm($database, 'RequestForInformationDraft', $row, null, $request_for_information_draft_id);
			/* @var $requestForInformationDraft RequestForInformationDraft */
			$arrRequestForInformationDraftsByRfiInitiatorPhoneContactCompanyOfficePhoneNumberId[$request_for_information_draft_id] = $requestForInformationDraft;
		}

		$db->free_result();

		self::$_arrRequestForInformationDraftsByRfiInitiatorPhoneContactCompanyOfficePhoneNumberId = $arrRequestForInformationDraftsByRfiInitiatorPhoneContactCompanyOfficePhoneNumberId;

		return $arrRequestForInformationDraftsByRfiInitiatorPhoneContactCompanyOfficePhoneNumberId;
	}

	/**
	 * Load by constraint `request_for_information_drafts_fk_initiator_fax_ccopn` foreign key (`rfi_initiator_fax_contact_company_office_phone_number_id`) references `contact_company_office_phone_numbers` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $rfi_initiator_fax_contact_company_office_phone_number_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadRequestForInformationDraftsByRfiInitiatorFaxContactCompanyOfficePhoneNumberId($database, $rfi_initiator_fax_contact_company_office_phone_number_id, Input $options=null)
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
			self::$_arrRequestForInformationDraftsByRfiInitiatorFaxContactCompanyOfficePhoneNumberId = null;
		}

		$arrRequestForInformationDraftsByRfiInitiatorFaxContactCompanyOfficePhoneNumberId = self::$_arrRequestForInformationDraftsByRfiInitiatorFaxContactCompanyOfficePhoneNumberId;
		if (isset($arrRequestForInformationDraftsByRfiInitiatorFaxContactCompanyOfficePhoneNumberId) && !empty($arrRequestForInformationDraftsByRfiInitiatorFaxContactCompanyOfficePhoneNumberId)) {
			return $arrRequestForInformationDraftsByRfiInitiatorFaxContactCompanyOfficePhoneNumberId;
		}

		$rfi_initiator_fax_contact_company_office_phone_number_id = (int) $rfi_initiator_fax_contact_company_office_phone_number_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `request_for_information_type_id` ASC, `request_for_information_priority_id` ASC, `rfi_file_manager_file_id` ASC, `rfi_cost_code_id` ASC, `rfi_creator_contact_id` ASC, `rfi_creator_contact_company_office_id` ASC, `rfi_creator_phone_contact_company_office_phone_number_id` ASC, `rfi_creator_fax_contact_company_office_phone_number_id` ASC, `rfi_creator_contact_mobile_phone_number_id` ASC, `rfi_recipient_contact_id` ASC, `rfi_recipient_contact_company_office_id` ASC, `rfi_recipient_phone_contact_company_office_phone_number_id` ASC, `rfi_recipient_fax_contact_company_office_phone_number_id` ASC, `rfi_recipient_contact_mobile_phone_number_id` ASC, `rfi_initiator_contact_id` ASC, `rfi_initiator_contact_company_office_id` ASC, `rfi_initiator_phone_contact_company_office_phone_number_id` ASC, `rfi_initiator_fax_contact_company_office_phone_number_id` ASC, `rfi_initiator_contact_mobile_phone_number_id` ASC, `rfi_title` ASC, `rfi_plan_page_reference` ASC, `rfi_statement` ASC, `rfi_due_date` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpRequestForInformationDraft = new RequestForInformationDraft($database);
			$sqlOrderByColumns = $tmpRequestForInformationDraft->constructSqlOrderByColumns($arrOrderByAttributes);

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
	rfid.*

FROM `request_for_information_drafts` rfid
WHERE rfid.`rfi_initiator_fax_contact_company_office_phone_number_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `request_for_information_type_id` ASC, `request_for_information_priority_id` ASC, `rfi_file_manager_file_id` ASC, `rfi_cost_code_id` ASC, `rfi_creator_contact_id` ASC, `rfi_creator_contact_company_office_id` ASC, `rfi_creator_phone_contact_company_office_phone_number_id` ASC, `rfi_creator_fax_contact_company_office_phone_number_id` ASC, `rfi_creator_contact_mobile_phone_number_id` ASC, `rfi_recipient_contact_id` ASC, `rfi_recipient_contact_company_office_id` ASC, `rfi_recipient_phone_contact_company_office_phone_number_id` ASC, `rfi_recipient_fax_contact_company_office_phone_number_id` ASC, `rfi_recipient_contact_mobile_phone_number_id` ASC, `rfi_initiator_contact_id` ASC, `rfi_initiator_contact_company_office_id` ASC, `rfi_initiator_phone_contact_company_office_phone_number_id` ASC, `rfi_initiator_fax_contact_company_office_phone_number_id` ASC, `rfi_initiator_contact_mobile_phone_number_id` ASC, `rfi_title` ASC, `rfi_plan_page_reference` ASC, `rfi_statement` ASC, `rfi_due_date` ASC
		$arrValues = array($rfi_initiator_fax_contact_company_office_phone_number_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrRequestForInformationDraftsByRfiInitiatorFaxContactCompanyOfficePhoneNumberId = array();
		while ($row = $db->fetch()) {
			$request_for_information_draft_id = $row['id'];
			$requestForInformationDraft = self::instantiateOrm($database, 'RequestForInformationDraft', $row, null, $request_for_information_draft_id);
			/* @var $requestForInformationDraft RequestForInformationDraft */
			$arrRequestForInformationDraftsByRfiInitiatorFaxContactCompanyOfficePhoneNumberId[$request_for_information_draft_id] = $requestForInformationDraft;
		}

		$db->free_result();

		self::$_arrRequestForInformationDraftsByRfiInitiatorFaxContactCompanyOfficePhoneNumberId = $arrRequestForInformationDraftsByRfiInitiatorFaxContactCompanyOfficePhoneNumberId;

		return $arrRequestForInformationDraftsByRfiInitiatorFaxContactCompanyOfficePhoneNumberId;
	}

	/**
	 * Load by constraint `request_for_information_drafts_fk_initiator_c_mobile_cpn` foreign key (`rfi_initiator_contact_mobile_phone_number_id`) references `contact_phone_numbers` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $rfi_initiator_contact_mobile_phone_number_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadRequestForInformationDraftsByRfiInitiatorContactMobilePhoneNumberId($database, $rfi_initiator_contact_mobile_phone_number_id, Input $options=null)
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
			self::$_arrRequestForInformationDraftsByRfiInitiatorContactMobilePhoneNumberId = null;
		}

		$arrRequestForInformationDraftsByRfiInitiatorContactMobilePhoneNumberId = self::$_arrRequestForInformationDraftsByRfiInitiatorContactMobilePhoneNumberId;
		if (isset($arrRequestForInformationDraftsByRfiInitiatorContactMobilePhoneNumberId) && !empty($arrRequestForInformationDraftsByRfiInitiatorContactMobilePhoneNumberId)) {
			return $arrRequestForInformationDraftsByRfiInitiatorContactMobilePhoneNumberId;
		}

		$rfi_initiator_contact_mobile_phone_number_id = (int) $rfi_initiator_contact_mobile_phone_number_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `request_for_information_type_id` ASC, `request_for_information_priority_id` ASC, `rfi_file_manager_file_id` ASC, `rfi_cost_code_id` ASC, `rfi_creator_contact_id` ASC, `rfi_creator_contact_company_office_id` ASC, `rfi_creator_phone_contact_company_office_phone_number_id` ASC, `rfi_creator_fax_contact_company_office_phone_number_id` ASC, `rfi_creator_contact_mobile_phone_number_id` ASC, `rfi_recipient_contact_id` ASC, `rfi_recipient_contact_company_office_id` ASC, `rfi_recipient_phone_contact_company_office_phone_number_id` ASC, `rfi_recipient_fax_contact_company_office_phone_number_id` ASC, `rfi_recipient_contact_mobile_phone_number_id` ASC, `rfi_initiator_contact_id` ASC, `rfi_initiator_contact_company_office_id` ASC, `rfi_initiator_phone_contact_company_office_phone_number_id` ASC, `rfi_initiator_fax_contact_company_office_phone_number_id` ASC, `rfi_initiator_contact_mobile_phone_number_id` ASC, `rfi_title` ASC, `rfi_plan_page_reference` ASC, `rfi_statement` ASC, `rfi_due_date` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpRequestForInformationDraft = new RequestForInformationDraft($database);
			$sqlOrderByColumns = $tmpRequestForInformationDraft->constructSqlOrderByColumns($arrOrderByAttributes);

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
	rfid.*

FROM `request_for_information_drafts` rfid
WHERE rfid.`rfi_initiator_contact_mobile_phone_number_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `request_for_information_type_id` ASC, `request_for_information_priority_id` ASC, `rfi_file_manager_file_id` ASC, `rfi_cost_code_id` ASC, `rfi_creator_contact_id` ASC, `rfi_creator_contact_company_office_id` ASC, `rfi_creator_phone_contact_company_office_phone_number_id` ASC, `rfi_creator_fax_contact_company_office_phone_number_id` ASC, `rfi_creator_contact_mobile_phone_number_id` ASC, `rfi_recipient_contact_id` ASC, `rfi_recipient_contact_company_office_id` ASC, `rfi_recipient_phone_contact_company_office_phone_number_id` ASC, `rfi_recipient_fax_contact_company_office_phone_number_id` ASC, `rfi_recipient_contact_mobile_phone_number_id` ASC, `rfi_initiator_contact_id` ASC, `rfi_initiator_contact_company_office_id` ASC, `rfi_initiator_phone_contact_company_office_phone_number_id` ASC, `rfi_initiator_fax_contact_company_office_phone_number_id` ASC, `rfi_initiator_contact_mobile_phone_number_id` ASC, `rfi_title` ASC, `rfi_plan_page_reference` ASC, `rfi_statement` ASC, `rfi_due_date` ASC
		$arrValues = array($rfi_initiator_contact_mobile_phone_number_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrRequestForInformationDraftsByRfiInitiatorContactMobilePhoneNumberId = array();
		while ($row = $db->fetch()) {
			$request_for_information_draft_id = $row['id'];
			$requestForInformationDraft = self::instantiateOrm($database, 'RequestForInformationDraft', $row, null, $request_for_information_draft_id);
			/* @var $requestForInformationDraft RequestForInformationDraft */
			$arrRequestForInformationDraftsByRfiInitiatorContactMobilePhoneNumberId[$request_for_information_draft_id] = $requestForInformationDraft;
		}

		$db->free_result();

		self::$_arrRequestForInformationDraftsByRfiInitiatorContactMobilePhoneNumberId = $arrRequestForInformationDraftsByRfiInitiatorContactMobilePhoneNumberId;

		return $arrRequestForInformationDraftsByRfiInitiatorContactMobilePhoneNumberId;
	}

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all request_for_information_drafts records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllRequestForInformationDrafts($database, Input $options=null)
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
			self::$_arrAllRequestForInformationDrafts = null;
		}

		$arrAllRequestForInformationDrafts = self::$_arrAllRequestForInformationDrafts;
		if (isset($arrAllRequestForInformationDrafts) && !empty($arrAllRequestForInformationDrafts)) {
			return $arrAllRequestForInformationDrafts;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `request_for_information_type_id` ASC, `request_for_information_priority_id` ASC, `rfi_file_manager_file_id` ASC, `rfi_cost_code_id` ASC, `rfi_creator_contact_id` ASC, `rfi_creator_contact_company_office_id` ASC, `rfi_creator_phone_contact_company_office_phone_number_id` ASC, `rfi_creator_fax_contact_company_office_phone_number_id` ASC, `rfi_creator_contact_mobile_phone_number_id` ASC, `rfi_recipient_contact_id` ASC, `rfi_recipient_contact_company_office_id` ASC, `rfi_recipient_phone_contact_company_office_phone_number_id` ASC, `rfi_recipient_fax_contact_company_office_phone_number_id` ASC, `rfi_recipient_contact_mobile_phone_number_id` ASC, `rfi_initiator_contact_id` ASC, `rfi_initiator_contact_company_office_id` ASC, `rfi_initiator_phone_contact_company_office_phone_number_id` ASC, `rfi_initiator_fax_contact_company_office_phone_number_id` ASC, `rfi_initiator_contact_mobile_phone_number_id` ASC, `rfi_title` ASC, `rfi_plan_page_reference` ASC, `rfi_statement` ASC, `rfi_due_date` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpRequestForInformationDraft = new RequestForInformationDraft($database);
			$sqlOrderByColumns = $tmpRequestForInformationDraft->constructSqlOrderByColumns($arrOrderByAttributes);

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
	rfid.*

FROM `request_for_information_drafts` rfid{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `request_for_information_type_id` ASC, `request_for_information_priority_id` ASC, `rfi_file_manager_file_id` ASC, `rfi_cost_code_id` ASC, `rfi_creator_contact_id` ASC, `rfi_creator_contact_company_office_id` ASC, `rfi_creator_phone_contact_company_office_phone_number_id` ASC, `rfi_creator_fax_contact_company_office_phone_number_id` ASC, `rfi_creator_contact_mobile_phone_number_id` ASC, `rfi_recipient_contact_id` ASC, `rfi_recipient_contact_company_office_id` ASC, `rfi_recipient_phone_contact_company_office_phone_number_id` ASC, `rfi_recipient_fax_contact_company_office_phone_number_id` ASC, `rfi_recipient_contact_mobile_phone_number_id` ASC, `rfi_initiator_contact_id` ASC, `rfi_initiator_contact_company_office_id` ASC, `rfi_initiator_phone_contact_company_office_phone_number_id` ASC, `rfi_initiator_fax_contact_company_office_phone_number_id` ASC, `rfi_initiator_contact_mobile_phone_number_id` ASC, `rfi_title` ASC, `rfi_plan_page_reference` ASC, `rfi_statement` ASC, `rfi_due_date` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllRequestForInformationDrafts = array();
		while ($row = $db->fetch()) {
			$request_for_information_draft_id = $row['id'];
			$requestForInformationDraft = self::instantiateOrm($database, 'RequestForInformationDraft', $row, null, $request_for_information_draft_id);
			/* @var $requestForInformationDraft RequestForInformationDraft */
			$arrAllRequestForInformationDrafts[$request_for_information_draft_id] = $requestForInformationDraft;
		}

		$db->free_result();

		self::$_arrAllRequestForInformationDrafts = $arrAllRequestForInformationDrafts;

		return $arrAllRequestForInformationDrafts;
	}

	// Save: insert on duplicate key update

	// Save: insert ignore
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

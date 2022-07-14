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
 * ChangeOrderDraft.
 *
 * @category   Framework
 * @package    ChangeOrderDraft
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class ChangeOrderDraft extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'ChangeOrderDraft';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'change_order_drafts';

	/**
	 * Singular version of the table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_tableNameSingular = 'change_order_draft';

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
		'unique_change_order_draft_via_primary_key' => array(
			'change_order_draft_id' => 'int'
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
		'id' => 'change_order_draft_id',

		'project_id' => 'project_id',
		'change_order_type_id' => 'change_order_type_id',
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

		'co_title' => 'co_title',
		'co_plan_page_reference' => 'co_plan_page_reference',
		'co_statement' => 'co_statement',
		'co_revised_project_completion_date' => 'co_revised_project_completion_date'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $change_order_draft_id;

	public $project_id;
	public $change_order_type_id;
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

	public $co_title;
	public $co_plan_page_reference;
	public $co_statement;
	public $co_revised_project_completion_date;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties
	public $escaped_co_title;
	public $escaped_co_plan_page_reference;
	public $escaped_co_statement;

	// HTML ENTITY ENCODED NL2BR ORM string properties
	public $escaped_co_title_nl2br;
	public $escaped_co_plan_page_reference_nl2br;
	public $escaped_co_statement_nl2br;

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)
	protected static $_arrChangeOrderDraftsByProjectId;
	protected static $_arrChangeOrderDraftsByChangeOrderTypeId;
	protected static $_arrChangeOrderDraftsByChangeOrderPriorityId;
	protected static $_arrChangeOrderDraftsByCoFileManagerFileId;
	protected static $_arrChangeOrderDraftsByCoCostCodeId;
	protected static $_arrChangeOrderDraftsByCoCreatorContactId;
	protected static $_arrChangeOrderDraftsByCoCreatorContactCompanyOfficeId;
	protected static $_arrChangeOrderDraftsByCoCreatorPhoneContactCompanyOfficePhoneNumberId;
	protected static $_arrChangeOrderDraftsByCoCreatorFaxContactCompanyOfficePhoneNumberId;
	protected static $_arrChangeOrderDraftsByCoCreatorContactMobilePhoneNumberId;
	protected static $_arrChangeOrderDraftsByCoRecipientContactId;
	protected static $_arrChangeOrderDraftsByCoRecipientContactCompanyOfficeId;
	protected static $_arrChangeOrderDraftsByCoRecipientPhoneContactCompanyOfficePhoneNumberId;
	protected static $_arrChangeOrderDraftsByCoRecipientFaxContactCompanyOfficePhoneNumberId;
	protected static $_arrChangeOrderDraftsByCoRecipientContactMobilePhoneNumberId;
	protected static $_arrChangeOrderDraftsByCoInitiatorContactId;
	protected static $_arrChangeOrderDraftsByCoInitiatorContactCompanyOfficeId;
	protected static $_arrChangeOrderDraftsByCoInitiatorPhoneContactCompanyOfficePhoneNumberId;
	protected static $_arrChangeOrderDraftsByCoInitiatorFaxContactCompanyOfficePhoneNumberId;
	protected static $_arrChangeOrderDraftsByCoInitiatorContactMobilePhoneNumberId;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllChangeOrderDrafts;

	// Foreign Key Objects
	private $_project;
	private $_changeOrderType;
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
	public function __construct($database, $table='change_order_drafts')
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
	public static function getArrChangeOrderDraftsByProjectId()
	{
		if (isset(self::$_arrChangeOrderDraftsByProjectId)) {
			return self::$_arrChangeOrderDraftsByProjectId;
		} else {
			return null;
		}
	}

	public static function setArrChangeOrderDraftsByProjectId($arrChangeOrderDraftsByProjectId)
	{
		self::$_arrChangeOrderDraftsByProjectId = $arrChangeOrderDraftsByProjectId;
	}

	public static function getArrChangeOrderDraftsByChangeOrderTypeId()
	{
		if (isset(self::$_arrChangeOrderDraftsByChangeOrderTypeId)) {
			return self::$_arrChangeOrderDraftsByChangeOrderTypeId;
		} else {
			return null;
		}
	}

	public static function setArrChangeOrderDraftsByChangeOrderTypeId($arrChangeOrderDraftsByChangeOrderTypeId)
	{
		self::$_arrChangeOrderDraftsByChangeOrderTypeId = $arrChangeOrderDraftsByChangeOrderTypeId;
	}

	public static function getArrChangeOrderDraftsByChangeOrderPriorityId()
	{
		if (isset(self::$_arrChangeOrderDraftsByChangeOrderPriorityId)) {
			return self::$_arrChangeOrderDraftsByChangeOrderPriorityId;
		} else {
			return null;
		}
	}

	public static function setArrChangeOrderDraftsByChangeOrderPriorityId($arrChangeOrderDraftsByChangeOrderPriorityId)
	{
		self::$_arrChangeOrderDraftsByChangeOrderPriorityId = $arrChangeOrderDraftsByChangeOrderPriorityId;
	}

	public static function getArrChangeOrderDraftsByCoFileManagerFileId()
	{
		if (isset(self::$_arrChangeOrderDraftsByCoFileManagerFileId)) {
			return self::$_arrChangeOrderDraftsByCoFileManagerFileId;
		} else {
			return null;
		}
	}

	public static function setArrChangeOrderDraftsByCoFileManagerFileId($arrChangeOrderDraftsByCoFileManagerFileId)
	{
		self::$_arrChangeOrderDraftsByCoFileManagerFileId = $arrChangeOrderDraftsByCoFileManagerFileId;
	}

	public static function getArrChangeOrderDraftsByCoCostCodeId()
	{
		if (isset(self::$_arrChangeOrderDraftsByCoCostCodeId)) {
			return self::$_arrChangeOrderDraftsByCoCostCodeId;
		} else {
			return null;
		}
	}

	public static function setArrChangeOrderDraftsByCoCostCodeId($arrChangeOrderDraftsByCoCostCodeId)
	{
		self::$_arrChangeOrderDraftsByCoCostCodeId = $arrChangeOrderDraftsByCoCostCodeId;
	}

	public static function getArrChangeOrderDraftsByCoCreatorContactId()
	{
		if (isset(self::$_arrChangeOrderDraftsByCoCreatorContactId)) {
			return self::$_arrChangeOrderDraftsByCoCreatorContactId;
		} else {
			return null;
		}
	}

	public static function setArrChangeOrderDraftsByCoCreatorContactId($arrChangeOrderDraftsByCoCreatorContactId)
	{
		self::$_arrChangeOrderDraftsByCoCreatorContactId = $arrChangeOrderDraftsByCoCreatorContactId;
	}

	public static function getArrChangeOrderDraftsByCoCreatorContactCompanyOfficeId()
	{
		if (isset(self::$_arrChangeOrderDraftsByCoCreatorContactCompanyOfficeId)) {
			return self::$_arrChangeOrderDraftsByCoCreatorContactCompanyOfficeId;
		} else {
			return null;
		}
	}

	public static function setArrChangeOrderDraftsByCoCreatorContactCompanyOfficeId($arrChangeOrderDraftsByCoCreatorContactCompanyOfficeId)
	{
		self::$_arrChangeOrderDraftsByCoCreatorContactCompanyOfficeId = $arrChangeOrderDraftsByCoCreatorContactCompanyOfficeId;
	}

	public static function getArrChangeOrderDraftsByCoCreatorPhoneContactCompanyOfficePhoneNumberId()
	{
		if (isset(self::$_arrChangeOrderDraftsByCoCreatorPhoneContactCompanyOfficePhoneNumberId)) {
			return self::$_arrChangeOrderDraftsByCoCreatorPhoneContactCompanyOfficePhoneNumberId;
		} else {
			return null;
		}
	}

	public static function setArrChangeOrderDraftsByCoCreatorPhoneContactCompanyOfficePhoneNumberId($arrChangeOrderDraftsByCoCreatorPhoneContactCompanyOfficePhoneNumberId)
	{
		self::$_arrChangeOrderDraftsByCoCreatorPhoneContactCompanyOfficePhoneNumberId = $arrChangeOrderDraftsByCoCreatorPhoneContactCompanyOfficePhoneNumberId;
	}

	public static function getArrChangeOrderDraftsByCoCreatorFaxContactCompanyOfficePhoneNumberId()
	{
		if (isset(self::$_arrChangeOrderDraftsByCoCreatorFaxContactCompanyOfficePhoneNumberId)) {
			return self::$_arrChangeOrderDraftsByCoCreatorFaxContactCompanyOfficePhoneNumberId;
		} else {
			return null;
		}
	}

	public static function setArrChangeOrderDraftsByCoCreatorFaxContactCompanyOfficePhoneNumberId($arrChangeOrderDraftsByCoCreatorFaxContactCompanyOfficePhoneNumberId)
	{
		self::$_arrChangeOrderDraftsByCoCreatorFaxContactCompanyOfficePhoneNumberId = $arrChangeOrderDraftsByCoCreatorFaxContactCompanyOfficePhoneNumberId;
	}

	public static function getArrChangeOrderDraftsByCoCreatorContactMobilePhoneNumberId()
	{
		if (isset(self::$_arrChangeOrderDraftsByCoCreatorContactMobilePhoneNumberId)) {
			return self::$_arrChangeOrderDraftsByCoCreatorContactMobilePhoneNumberId;
		} else {
			return null;
		}
	}

	public static function setArrChangeOrderDraftsByCoCreatorContactMobilePhoneNumberId($arrChangeOrderDraftsByCoCreatorContactMobilePhoneNumberId)
	{
		self::$_arrChangeOrderDraftsByCoCreatorContactMobilePhoneNumberId = $arrChangeOrderDraftsByCoCreatorContactMobilePhoneNumberId;
	}

	public static function getArrChangeOrderDraftsByCoRecipientContactId()
	{
		if (isset(self::$_arrChangeOrderDraftsByCoRecipientContactId)) {
			return self::$_arrChangeOrderDraftsByCoRecipientContactId;
		} else {
			return null;
		}
	}

	public static function setArrChangeOrderDraftsByCoRecipientContactId($arrChangeOrderDraftsByCoRecipientContactId)
	{
		self::$_arrChangeOrderDraftsByCoRecipientContactId = $arrChangeOrderDraftsByCoRecipientContactId;
	}

	public static function getArrChangeOrderDraftsByCoRecipientContactCompanyOfficeId()
	{
		if (isset(self::$_arrChangeOrderDraftsByCoRecipientContactCompanyOfficeId)) {
			return self::$_arrChangeOrderDraftsByCoRecipientContactCompanyOfficeId;
		} else {
			return null;
		}
	}

	public static function setArrChangeOrderDraftsByCoRecipientContactCompanyOfficeId($arrChangeOrderDraftsByCoRecipientContactCompanyOfficeId)
	{
		self::$_arrChangeOrderDraftsByCoRecipientContactCompanyOfficeId = $arrChangeOrderDraftsByCoRecipientContactCompanyOfficeId;
	}

	public static function getArrChangeOrderDraftsByCoRecipientPhoneContactCompanyOfficePhoneNumberId()
	{
		if (isset(self::$_arrChangeOrderDraftsByCoRecipientPhoneContactCompanyOfficePhoneNumberId)) {
			return self::$_arrChangeOrderDraftsByCoRecipientPhoneContactCompanyOfficePhoneNumberId;
		} else {
			return null;
		}
	}

	public static function setArrChangeOrderDraftsByCoRecipientPhoneContactCompanyOfficePhoneNumberId($arrChangeOrderDraftsByCoRecipientPhoneContactCompanyOfficePhoneNumberId)
	{
		self::$_arrChangeOrderDraftsByCoRecipientPhoneContactCompanyOfficePhoneNumberId = $arrChangeOrderDraftsByCoRecipientPhoneContactCompanyOfficePhoneNumberId;
	}

	public static function getArrChangeOrderDraftsByCoRecipientFaxContactCompanyOfficePhoneNumberId()
	{
		if (isset(self::$_arrChangeOrderDraftsByCoRecipientFaxContactCompanyOfficePhoneNumberId)) {
			return self::$_arrChangeOrderDraftsByCoRecipientFaxContactCompanyOfficePhoneNumberId;
		} else {
			return null;
		}
	}

	public static function setArrChangeOrderDraftsByCoRecipientFaxContactCompanyOfficePhoneNumberId($arrChangeOrderDraftsByCoRecipientFaxContactCompanyOfficePhoneNumberId)
	{
		self::$_arrChangeOrderDraftsByCoRecipientFaxContactCompanyOfficePhoneNumberId = $arrChangeOrderDraftsByCoRecipientFaxContactCompanyOfficePhoneNumberId;
	}

	public static function getArrChangeOrderDraftsByCoRecipientContactMobilePhoneNumberId()
	{
		if (isset(self::$_arrChangeOrderDraftsByCoRecipientContactMobilePhoneNumberId)) {
			return self::$_arrChangeOrderDraftsByCoRecipientContactMobilePhoneNumberId;
		} else {
			return null;
		}
	}

	public static function setArrChangeOrderDraftsByCoRecipientContactMobilePhoneNumberId($arrChangeOrderDraftsByCoRecipientContactMobilePhoneNumberId)
	{
		self::$_arrChangeOrderDraftsByCoRecipientContactMobilePhoneNumberId = $arrChangeOrderDraftsByCoRecipientContactMobilePhoneNumberId;
	}

	public static function getArrChangeOrderDraftsByCoInitiatorContactId()
	{
		if (isset(self::$_arrChangeOrderDraftsByCoInitiatorContactId)) {
			return self::$_arrChangeOrderDraftsByCoInitiatorContactId;
		} else {
			return null;
		}
	}

	public static function setArrChangeOrderDraftsByCoInitiatorContactId($arrChangeOrderDraftsByCoInitiatorContactId)
	{
		self::$_arrChangeOrderDraftsByCoInitiatorContactId = $arrChangeOrderDraftsByCoInitiatorContactId;
	}

	public static function getArrChangeOrderDraftsByCoInitiatorContactCompanyOfficeId()
	{
		if (isset(self::$_arrChangeOrderDraftsByCoInitiatorContactCompanyOfficeId)) {
			return self::$_arrChangeOrderDraftsByCoInitiatorContactCompanyOfficeId;
		} else {
			return null;
		}
	}

	public static function setArrChangeOrderDraftsByCoInitiatorContactCompanyOfficeId($arrChangeOrderDraftsByCoInitiatorContactCompanyOfficeId)
	{
		self::$_arrChangeOrderDraftsByCoInitiatorContactCompanyOfficeId = $arrChangeOrderDraftsByCoInitiatorContactCompanyOfficeId;
	}

	public static function getArrChangeOrderDraftsByCoInitiatorPhoneContactCompanyOfficePhoneNumberId()
	{
		if (isset(self::$_arrChangeOrderDraftsByCoInitiatorPhoneContactCompanyOfficePhoneNumberId)) {
			return self::$_arrChangeOrderDraftsByCoInitiatorPhoneContactCompanyOfficePhoneNumberId;
		} else {
			return null;
		}
	}

	public static function setArrChangeOrderDraftsByCoInitiatorPhoneContactCompanyOfficePhoneNumberId($arrChangeOrderDraftsByCoInitiatorPhoneContactCompanyOfficePhoneNumberId)
	{
		self::$_arrChangeOrderDraftsByCoInitiatorPhoneContactCompanyOfficePhoneNumberId = $arrChangeOrderDraftsByCoInitiatorPhoneContactCompanyOfficePhoneNumberId;
	}

	public static function getArrChangeOrderDraftsByCoInitiatorFaxContactCompanyOfficePhoneNumberId()
	{
		if (isset(self::$_arrChangeOrderDraftsByCoInitiatorFaxContactCompanyOfficePhoneNumberId)) {
			return self::$_arrChangeOrderDraftsByCoInitiatorFaxContactCompanyOfficePhoneNumberId;
		} else {
			return null;
		}
	}

	public static function setArrChangeOrderDraftsByCoInitiatorFaxContactCompanyOfficePhoneNumberId($arrChangeOrderDraftsByCoInitiatorFaxContactCompanyOfficePhoneNumberId)
	{
		self::$_arrChangeOrderDraftsByCoInitiatorFaxContactCompanyOfficePhoneNumberId = $arrChangeOrderDraftsByCoInitiatorFaxContactCompanyOfficePhoneNumberId;
	}

	public static function getArrChangeOrderDraftsByCoInitiatorContactMobilePhoneNumberId()
	{
		if (isset(self::$_arrChangeOrderDraftsByCoInitiatorContactMobilePhoneNumberId)) {
			return self::$_arrChangeOrderDraftsByCoInitiatorContactMobilePhoneNumberId;
		} else {
			return null;
		}
	}

	public static function setArrChangeOrderDraftsByCoInitiatorContactMobilePhoneNumberId($arrChangeOrderDraftsByCoInitiatorContactMobilePhoneNumberId)
	{
		self::$_arrChangeOrderDraftsByCoInitiatorContactMobilePhoneNumberId = $arrChangeOrderDraftsByCoInitiatorContactMobilePhoneNumberId;
	}

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllChangeOrderDrafts()
	{
		if (isset(self::$_arrAllChangeOrderDrafts)) {
			return self::$_arrAllChangeOrderDrafts;
		} else {
			return null;
		}
	}

	public static function setArrAllChangeOrderDrafts($arrAllChangeOrderDrafts)
	{
		self::$_arrAllChangeOrderDrafts = $arrAllChangeOrderDrafts;
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
	 * @param int $change_order_draft_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findById($database, $change_order_draft_id, $table='change_order_drafts', $module='ChangeOrderDraft')
	{
		$changeOrderDraft = parent::findById($database, $change_order_draft_id, $table, $module);

		return $changeOrderDraft;
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Similar to FindById, but with SQL as starter code for more complex joins.
	 *
	 * @param string $database
	 * @param int $change_order_draft_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findChangeOrderDraftByIdExtended($database, $change_order_draft_id)
	{
		$change_order_draft_id = (int) $change_order_draft_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	cod_fk_p.`id` AS 'cod_fk_p__project_id',
	cod_fk_p.`project_type_id` AS 'cod_fk_p__project_type_id',
	cod_fk_p.`user_company_id` AS 'cod_fk_p__user_company_id',
	cod_fk_p.`user_custom_project_id` AS 'cod_fk_p__user_custom_project_id',
	cod_fk_p.`project_name` AS 'cod_fk_p__project_name',
	cod_fk_p.`project_owner_name` AS 'cod_fk_p__project_owner_name',
	cod_fk_p.`latitude` AS 'cod_fk_p__latitude',
	cod_fk_p.`longitude` AS 'cod_fk_p__longitude',
	cod_fk_p.`address_line_1` AS 'cod_fk_p__address_line_1',
	cod_fk_p.`address_line_2` AS 'cod_fk_p__address_line_2',
	cod_fk_p.`address_line_3` AS 'cod_fk_p__address_line_3',
	cod_fk_p.`address_line_4` AS 'cod_fk_p__address_line_4',
	cod_fk_p.`address_city` AS 'cod_fk_p__address_city',
	cod_fk_p.`address_county` AS 'cod_fk_p__address_county',
	cod_fk_p.`address_state_or_region` AS 'cod_fk_p__address_state_or_region',
	cod_fk_p.`address_postal_code` AS 'cod_fk_p__address_postal_code',
	cod_fk_p.`address_postal_code_extension` AS 'cod_fk_p__address_postal_code_extension',
	cod_fk_p.`address_country` AS 'cod_fk_p__address_country',
	cod_fk_p.`building_count` AS 'cod_fk_p__building_count',
	cod_fk_p.`unit_count` AS 'cod_fk_p__unit_count',
	cod_fk_p.`gross_square_footage` AS 'cod_fk_p__gross_square_footage',
	cod_fk_p.`net_rentable_square_footage` AS 'cod_fk_p__net_rentable_square_footage',
	cod_fk_p.`is_active_flag` AS 'cod_fk_p__is_active_flag',
	cod_fk_p.`public_plans_flag` AS 'cod_fk_p__public_plans_flag',
	cod_fk_p.`prevailing_wage_flag` AS 'cod_fk_p__prevailing_wage_flag',
	cod_fk_p.`city_business_license_required_flag` AS 'cod_fk_p__city_business_license_required_flag',
	cod_fk_p.`is_internal_flag` AS 'cod_fk_p__is_internal_flag',
	cod_fk_p.`project_contract_date` AS 'cod_fk_p__project_contract_date',
	cod_fk_p.`project_start_date` AS 'cod_fk_p__project_start_date',
	cod_fk_p.`project_completed_date` AS 'cod_fk_p__project_completed_date',
	cod_fk_p.`sort_order` AS 'cod_fk_p__sort_order',

	cod_fk_cot.`id` AS 'cod_fk_cot__change_order_type_id',
	cod_fk_cot.`change_order_type` AS 'cod_fk_cot__change_order_type',
	cod_fk_cot.`disabled_flag` AS 'cod_fk_cot__disabled_flag',

	cod_fk_cop.`id` AS 'cod_fk_cop__change_order_priority_id',
	cod_fk_cop.`change_order_priority` AS 'cod_fk_cop__change_order_priority',
	cod_fk_cop.`disabled_flag` AS 'cod_fk_cop__disabled_flag',

	cod_fk_fmfiles.`id` AS 'cod_fk_fmfiles__file_manager_file_id',
	cod_fk_fmfiles.`user_company_id` AS 'cod_fk_fmfiles__user_company_id',
	cod_fk_fmfiles.`contact_id` AS 'cod_fk_fmfiles__contact_id',
	cod_fk_fmfiles.`project_id` AS 'cod_fk_fmfiles__project_id',
	cod_fk_fmfiles.`file_manager_folder_id` AS 'cod_fk_fmfiles__file_manager_folder_id',
	cod_fk_fmfiles.`file_location_id` AS 'cod_fk_fmfiles__file_location_id',
	cod_fk_fmfiles.`virtual_file_name` AS 'cod_fk_fmfiles__virtual_file_name',
	cod_fk_fmfiles.`version_number` AS 'cod_fk_fmfiles__version_number',
	cod_fk_fmfiles.`virtual_file_name_sha1` AS 'cod_fk_fmfiles__virtual_file_name_sha1',
	cod_fk_fmfiles.`virtual_file_mime_type` AS 'cod_fk_fmfiles__virtual_file_mime_type',
	cod_fk_fmfiles.`modified` AS 'cod_fk_fmfiles__modified',
	cod_fk_fmfiles.`created` AS 'cod_fk_fmfiles__created',
	cod_fk_fmfiles.`deleted_flag` AS 'cod_fk_fmfiles__deleted_flag',
	cod_fk_fmfiles.`directly_deleted_flag` AS 'cod_fk_fmfiles__directly_deleted_flag',

	cod_fk_codes.`id` AS 'cod_fk_codes__cost_code_id',
	cod_fk_codes.`cost_code_division_id` AS 'cod_fk_codes__cost_code_division_id',
	cod_fk_codes.`cost_code` AS 'cod_fk_codes__cost_code',
	cod_fk_codes.`cost_code_description` AS 'cod_fk_codes__cost_code_description',
	cod_fk_codes.`cost_code_description_abbreviation` AS 'cod_fk_codes__cost_code_description_abbreviation',
	cod_fk_codes.`sort_order` AS 'cod_fk_codes__sort_order',
	cod_fk_codes.`disabled_flag` AS 'cod_fk_codes__disabled_flag',

	cod_fk_creator_c.`id` AS 'cod_fk_creator_c__contact_id',
	cod_fk_creator_c.`user_company_id` AS 'cod_fk_creator_c__user_company_id',
	cod_fk_creator_c.`user_id` AS 'cod_fk_creator_c__user_id',
	cod_fk_creator_c.`contact_company_id` AS 'cod_fk_creator_c__contact_company_id',
	cod_fk_creator_c.`email` AS 'cod_fk_creator_c__email',
	cod_fk_creator_c.`name_prefix` AS 'cod_fk_creator_c__name_prefix',
	cod_fk_creator_c.`first_name` AS 'cod_fk_creator_c__first_name',
	cod_fk_creator_c.`additional_name` AS 'cod_fk_creator_c__additional_name',
	cod_fk_creator_c.`middle_name` AS 'cod_fk_creator_c__middle_name',
	cod_fk_creator_c.`last_name` AS 'cod_fk_creator_c__last_name',
	cod_fk_creator_c.`name_suffix` AS 'cod_fk_creator_c__name_suffix',
	cod_fk_creator_c.`title` AS 'cod_fk_creator_c__title',
	cod_fk_creator_c.`vendor_flag` AS 'cod_fk_creator_c__vendor_flag',

	cod_fk_creator_cco.`id` AS 'cod_fk_creator_cco__contact_company_office_id',
	cod_fk_creator_cco.`contact_company_id` AS 'cod_fk_creator_cco__contact_company_id',
	cod_fk_creator_cco.`office_nickname` AS 'cod_fk_creator_cco__office_nickname',
	cod_fk_creator_cco.`address_line_1` AS 'cod_fk_creator_cco__address_line_1',
	cod_fk_creator_cco.`address_line_2` AS 'cod_fk_creator_cco__address_line_2',
	cod_fk_creator_cco.`address_line_3` AS 'cod_fk_creator_cco__address_line_3',
	cod_fk_creator_cco.`address_line_4` AS 'cod_fk_creator_cco__address_line_4',
	cod_fk_creator_cco.`address_city` AS 'cod_fk_creator_cco__address_city',
	cod_fk_creator_cco.`address_county` AS 'cod_fk_creator_cco__address_county',
	cod_fk_creator_cco.`address_state_or_region` AS 'cod_fk_creator_cco__address_state_or_region',
	cod_fk_creator_cco.`address_postal_code` AS 'cod_fk_creator_cco__address_postal_code',
	cod_fk_creator_cco.`address_postal_code_extension` AS 'cod_fk_creator_cco__address_postal_code_extension',
	cod_fk_creator_cco.`address_country` AS 'cod_fk_creator_cco__address_country',
	cod_fk_creator_cco.`head_quarters_flag` AS 'cod_fk_creator_cco__head_quarters_flag',
	cod_fk_creator_cco.`address_validated_by_user_flag` AS 'cod_fk_creator_cco__address_validated_by_user_flag',
	cod_fk_creator_cco.`address_validated_by_web_service_flag` AS 'cod_fk_creator_cco__address_validated_by_web_service_flag',
	cod_fk_creator_cco.`address_validation_by_web_service_error_flag` AS 'cod_fk_creator_cco__address_validation_by_web_service_error_flag',

	cod_fk_creator_phone_ccopn.`id` AS 'cod_fk_creator_phone_ccopn__contact_company_office_phone_number_id',
	cod_fk_creator_phone_ccopn.`contact_company_office_id` AS 'cod_fk_creator_phone_ccopn__contact_company_office_id',
	cod_fk_creator_phone_ccopn.`phone_number_type_id` AS 'cod_fk_creator_phone_ccopn__phone_number_type_id',
	cod_fk_creator_phone_ccopn.`country_code` AS 'cod_fk_creator_phone_ccopn__country_code',
	cod_fk_creator_phone_ccopn.`area_code` AS 'cod_fk_creator_phone_ccopn__area_code',
	cod_fk_creator_phone_ccopn.`prefix` AS 'cod_fk_creator_phone_ccopn__prefix',
	cod_fk_creator_phone_ccopn.`number` AS 'cod_fk_creator_phone_ccopn__number',
	cod_fk_creator_phone_ccopn.`extension` AS 'cod_fk_creator_phone_ccopn__extension',
	cod_fk_creator_phone_ccopn.`itu` AS 'cod_fk_creator_phone_ccopn__itu',

	cod_fk_creator_fax_ccopn.`id` AS 'cod_fk_creator_fax_ccopn__contact_company_office_phone_number_id',
	cod_fk_creator_fax_ccopn.`contact_company_office_id` AS 'cod_fk_creator_fax_ccopn__contact_company_office_id',
	cod_fk_creator_fax_ccopn.`phone_number_type_id` AS 'cod_fk_creator_fax_ccopn__phone_number_type_id',
	cod_fk_creator_fax_ccopn.`country_code` AS 'cod_fk_creator_fax_ccopn__country_code',
	cod_fk_creator_fax_ccopn.`area_code` AS 'cod_fk_creator_fax_ccopn__area_code',
	cod_fk_creator_fax_ccopn.`prefix` AS 'cod_fk_creator_fax_ccopn__prefix',
	cod_fk_creator_fax_ccopn.`number` AS 'cod_fk_creator_fax_ccopn__number',
	cod_fk_creator_fax_ccopn.`extension` AS 'cod_fk_creator_fax_ccopn__extension',
	cod_fk_creator_fax_ccopn.`itu` AS 'cod_fk_creator_fax_ccopn__itu',

	cod_fk_creator_c_mobile_cpn.`id` AS 'cod_fk_creator_c_mobile_cpn__contact_phone_number_id',
	cod_fk_creator_c_mobile_cpn.`contact_id` AS 'cod_fk_creator_c_mobile_cpn__contact_id',
	cod_fk_creator_c_mobile_cpn.`phone_number_type_id` AS 'cod_fk_creator_c_mobile_cpn__phone_number_type_id',
	cod_fk_creator_c_mobile_cpn.`country_code` AS 'cod_fk_creator_c_mobile_cpn__country_code',
	cod_fk_creator_c_mobile_cpn.`area_code` AS 'cod_fk_creator_c_mobile_cpn__area_code',
	cod_fk_creator_c_mobile_cpn.`prefix` AS 'cod_fk_creator_c_mobile_cpn__prefix',
	cod_fk_creator_c_mobile_cpn.`number` AS 'cod_fk_creator_c_mobile_cpn__number',
	cod_fk_creator_c_mobile_cpn.`extension` AS 'cod_fk_creator_c_mobile_cpn__extension',
	cod_fk_creator_c_mobile_cpn.`itu` AS 'cod_fk_creator_c_mobile_cpn__itu',

	cod_fk_recipient_c.`id` AS 'cod_fk_recipient_c__contact_id',
	cod_fk_recipient_c.`user_company_id` AS 'cod_fk_recipient_c__user_company_id',
	cod_fk_recipient_c.`user_id` AS 'cod_fk_recipient_c__user_id',
	cod_fk_recipient_c.`contact_company_id` AS 'cod_fk_recipient_c__contact_company_id',
	cod_fk_recipient_c.`email` AS 'cod_fk_recipient_c__email',
	cod_fk_recipient_c.`name_prefix` AS 'cod_fk_recipient_c__name_prefix',
	cod_fk_recipient_c.`first_name` AS 'cod_fk_recipient_c__first_name',
	cod_fk_recipient_c.`additional_name` AS 'cod_fk_recipient_c__additional_name',
	cod_fk_recipient_c.`middle_name` AS 'cod_fk_recipient_c__middle_name',
	cod_fk_recipient_c.`last_name` AS 'cod_fk_recipient_c__last_name',
	cod_fk_recipient_c.`name_suffix` AS 'cod_fk_recipient_c__name_suffix',
	cod_fk_recipient_c.`title` AS 'cod_fk_recipient_c__title',
	cod_fk_recipient_c.`vendor_flag` AS 'cod_fk_recipient_c__vendor_flag',

	cod_fk_recipient_cco.`id` AS 'cod_fk_recipient_cco__contact_company_office_id',
	cod_fk_recipient_cco.`contact_company_id` AS 'cod_fk_recipient_cco__contact_company_id',
	cod_fk_recipient_cco.`office_nickname` AS 'cod_fk_recipient_cco__office_nickname',
	cod_fk_recipient_cco.`address_line_1` AS 'cod_fk_recipient_cco__address_line_1',
	cod_fk_recipient_cco.`address_line_2` AS 'cod_fk_recipient_cco__address_line_2',
	cod_fk_recipient_cco.`address_line_3` AS 'cod_fk_recipient_cco__address_line_3',
	cod_fk_recipient_cco.`address_line_4` AS 'cod_fk_recipient_cco__address_line_4',
	cod_fk_recipient_cco.`address_city` AS 'cod_fk_recipient_cco__address_city',
	cod_fk_recipient_cco.`address_county` AS 'cod_fk_recipient_cco__address_county',
	cod_fk_recipient_cco.`address_state_or_region` AS 'cod_fk_recipient_cco__address_state_or_region',
	cod_fk_recipient_cco.`address_postal_code` AS 'cod_fk_recipient_cco__address_postal_code',
	cod_fk_recipient_cco.`address_postal_code_extension` AS 'cod_fk_recipient_cco__address_postal_code_extension',
	cod_fk_recipient_cco.`address_country` AS 'cod_fk_recipient_cco__address_country',
	cod_fk_recipient_cco.`head_quarters_flag` AS 'cod_fk_recipient_cco__head_quarters_flag',
	cod_fk_recipient_cco.`address_validated_by_user_flag` AS 'cod_fk_recipient_cco__address_validated_by_user_flag',
	cod_fk_recipient_cco.`address_validated_by_web_service_flag` AS 'cod_fk_recipient_cco__address_validated_by_web_service_flag',
	cod_fk_recipient_cco.`address_validation_by_web_service_error_flag` AS 'cod_fk_recipient_cco__address_validation_by_web_service_error_flag',

	cod_fk_recipient_phone_ccopn.`id` AS 'cod_fk_recipient_phone_ccopn__contact_company_office_phone_number_id',
	cod_fk_recipient_phone_ccopn.`contact_company_office_id` AS 'cod_fk_recipient_phone_ccopn__contact_company_office_id',
	cod_fk_recipient_phone_ccopn.`phone_number_type_id` AS 'cod_fk_recipient_phone_ccopn__phone_number_type_id',
	cod_fk_recipient_phone_ccopn.`country_code` AS 'cod_fk_recipient_phone_ccopn__country_code',
	cod_fk_recipient_phone_ccopn.`area_code` AS 'cod_fk_recipient_phone_ccopn__area_code',
	cod_fk_recipient_phone_ccopn.`prefix` AS 'cod_fk_recipient_phone_ccopn__prefix',
	cod_fk_recipient_phone_ccopn.`number` AS 'cod_fk_recipient_phone_ccopn__number',
	cod_fk_recipient_phone_ccopn.`extension` AS 'cod_fk_recipient_phone_ccopn__extension',
	cod_fk_recipient_phone_ccopn.`itu` AS 'cod_fk_recipient_phone_ccopn__itu',

	cod_fk_recipient_fax_ccopn.`id` AS 'cod_fk_recipient_fax_ccopn__contact_company_office_phone_number_id',
	cod_fk_recipient_fax_ccopn.`contact_company_office_id` AS 'cod_fk_recipient_fax_ccopn__contact_company_office_id',
	cod_fk_recipient_fax_ccopn.`phone_number_type_id` AS 'cod_fk_recipient_fax_ccopn__phone_number_type_id',
	cod_fk_recipient_fax_ccopn.`country_code` AS 'cod_fk_recipient_fax_ccopn__country_code',
	cod_fk_recipient_fax_ccopn.`area_code` AS 'cod_fk_recipient_fax_ccopn__area_code',
	cod_fk_recipient_fax_ccopn.`prefix` AS 'cod_fk_recipient_fax_ccopn__prefix',
	cod_fk_recipient_fax_ccopn.`number` AS 'cod_fk_recipient_fax_ccopn__number',
	cod_fk_recipient_fax_ccopn.`extension` AS 'cod_fk_recipient_fax_ccopn__extension',
	cod_fk_recipient_fax_ccopn.`itu` AS 'cod_fk_recipient_fax_ccopn__itu',

	cod_fk_recipient_c_mobile_cpn.`id` AS 'cod_fk_recipient_c_mobile_cpn__contact_phone_number_id',
	cod_fk_recipient_c_mobile_cpn.`contact_id` AS 'cod_fk_recipient_c_mobile_cpn__contact_id',
	cod_fk_recipient_c_mobile_cpn.`phone_number_type_id` AS 'cod_fk_recipient_c_mobile_cpn__phone_number_type_id',
	cod_fk_recipient_c_mobile_cpn.`country_code` AS 'cod_fk_recipient_c_mobile_cpn__country_code',
	cod_fk_recipient_c_mobile_cpn.`area_code` AS 'cod_fk_recipient_c_mobile_cpn__area_code',
	cod_fk_recipient_c_mobile_cpn.`prefix` AS 'cod_fk_recipient_c_mobile_cpn__prefix',
	cod_fk_recipient_c_mobile_cpn.`number` AS 'cod_fk_recipient_c_mobile_cpn__number',
	cod_fk_recipient_c_mobile_cpn.`extension` AS 'cod_fk_recipient_c_mobile_cpn__extension',
	cod_fk_recipient_c_mobile_cpn.`itu` AS 'cod_fk_recipient_c_mobile_cpn__itu',

	cod_fk_initiator_c.`id` AS 'cod_fk_initiator_c__contact_id',
	cod_fk_initiator_c.`user_company_id` AS 'cod_fk_initiator_c__user_company_id',
	cod_fk_initiator_c.`user_id` AS 'cod_fk_initiator_c__user_id',
	cod_fk_initiator_c.`contact_company_id` AS 'cod_fk_initiator_c__contact_company_id',
	cod_fk_initiator_c.`email` AS 'cod_fk_initiator_c__email',
	cod_fk_initiator_c.`name_prefix` AS 'cod_fk_initiator_c__name_prefix',
	cod_fk_initiator_c.`first_name` AS 'cod_fk_initiator_c__first_name',
	cod_fk_initiator_c.`additional_name` AS 'cod_fk_initiator_c__additional_name',
	cod_fk_initiator_c.`middle_name` AS 'cod_fk_initiator_c__middle_name',
	cod_fk_initiator_c.`last_name` AS 'cod_fk_initiator_c__last_name',
	cod_fk_initiator_c.`name_suffix` AS 'cod_fk_initiator_c__name_suffix',
	cod_fk_initiator_c.`title` AS 'cod_fk_initiator_c__title',
	cod_fk_initiator_c.`vendor_flag` AS 'cod_fk_initiator_c__vendor_flag',

	cod_fk_initiator_cco.`id` AS 'cod_fk_initiator_cco__contact_company_office_id',
	cod_fk_initiator_cco.`contact_company_id` AS 'cod_fk_initiator_cco__contact_company_id',
	cod_fk_initiator_cco.`office_nickname` AS 'cod_fk_initiator_cco__office_nickname',
	cod_fk_initiator_cco.`address_line_1` AS 'cod_fk_initiator_cco__address_line_1',
	cod_fk_initiator_cco.`address_line_2` AS 'cod_fk_initiator_cco__address_line_2',
	cod_fk_initiator_cco.`address_line_3` AS 'cod_fk_initiator_cco__address_line_3',
	cod_fk_initiator_cco.`address_line_4` AS 'cod_fk_initiator_cco__address_line_4',
	cod_fk_initiator_cco.`address_city` AS 'cod_fk_initiator_cco__address_city',
	cod_fk_initiator_cco.`address_county` AS 'cod_fk_initiator_cco__address_county',
	cod_fk_initiator_cco.`address_state_or_region` AS 'cod_fk_initiator_cco__address_state_or_region',
	cod_fk_initiator_cco.`address_postal_code` AS 'cod_fk_initiator_cco__address_postal_code',
	cod_fk_initiator_cco.`address_postal_code_extension` AS 'cod_fk_initiator_cco__address_postal_code_extension',
	cod_fk_initiator_cco.`address_country` AS 'cod_fk_initiator_cco__address_country',
	cod_fk_initiator_cco.`head_quarters_flag` AS 'cod_fk_initiator_cco__head_quarters_flag',
	cod_fk_initiator_cco.`address_validated_by_user_flag` AS 'cod_fk_initiator_cco__address_validated_by_user_flag',
	cod_fk_initiator_cco.`address_validated_by_web_service_flag` AS 'cod_fk_initiator_cco__address_validated_by_web_service_flag',
	cod_fk_initiator_cco.`address_validation_by_web_service_error_flag` AS 'cod_fk_initiator_cco__address_validation_by_web_service_error_flag',

	cod_fk_initiator_phone_ccopn.`id` AS 'cod_fk_initiator_phone_ccopn__contact_company_office_phone_number_id',
	cod_fk_initiator_phone_ccopn.`contact_company_office_id` AS 'cod_fk_initiator_phone_ccopn__contact_company_office_id',
	cod_fk_initiator_phone_ccopn.`phone_number_type_id` AS 'cod_fk_initiator_phone_ccopn__phone_number_type_id',
	cod_fk_initiator_phone_ccopn.`country_code` AS 'cod_fk_initiator_phone_ccopn__country_code',
	cod_fk_initiator_phone_ccopn.`area_code` AS 'cod_fk_initiator_phone_ccopn__area_code',
	cod_fk_initiator_phone_ccopn.`prefix` AS 'cod_fk_initiator_phone_ccopn__prefix',
	cod_fk_initiator_phone_ccopn.`number` AS 'cod_fk_initiator_phone_ccopn__number',
	cod_fk_initiator_phone_ccopn.`extension` AS 'cod_fk_initiator_phone_ccopn__extension',
	cod_fk_initiator_phone_ccopn.`itu` AS 'cod_fk_initiator_phone_ccopn__itu',

	cod_fk_initiator_fax_ccopn.`id` AS 'cod_fk_initiator_fax_ccopn__contact_company_office_phone_number_id',
	cod_fk_initiator_fax_ccopn.`contact_company_office_id` AS 'cod_fk_initiator_fax_ccopn__contact_company_office_id',
	cod_fk_initiator_fax_ccopn.`phone_number_type_id` AS 'cod_fk_initiator_fax_ccopn__phone_number_type_id',
	cod_fk_initiator_fax_ccopn.`country_code` AS 'cod_fk_initiator_fax_ccopn__country_code',
	cod_fk_initiator_fax_ccopn.`area_code` AS 'cod_fk_initiator_fax_ccopn__area_code',
	cod_fk_initiator_fax_ccopn.`prefix` AS 'cod_fk_initiator_fax_ccopn__prefix',
	cod_fk_initiator_fax_ccopn.`number` AS 'cod_fk_initiator_fax_ccopn__number',
	cod_fk_initiator_fax_ccopn.`extension` AS 'cod_fk_initiator_fax_ccopn__extension',
	cod_fk_initiator_fax_ccopn.`itu` AS 'cod_fk_initiator_fax_ccopn__itu',

	cod_fk_initiator_c_mobile_cpn.`id` AS 'cod_fk_initiator_c_mobile_cpn__contact_phone_number_id',
	cod_fk_initiator_c_mobile_cpn.`contact_id` AS 'cod_fk_initiator_c_mobile_cpn__contact_id',
	cod_fk_initiator_c_mobile_cpn.`phone_number_type_id` AS 'cod_fk_initiator_c_mobile_cpn__phone_number_type_id',
	cod_fk_initiator_c_mobile_cpn.`country_code` AS 'cod_fk_initiator_c_mobile_cpn__country_code',
	cod_fk_initiator_c_mobile_cpn.`area_code` AS 'cod_fk_initiator_c_mobile_cpn__area_code',
	cod_fk_initiator_c_mobile_cpn.`prefix` AS 'cod_fk_initiator_c_mobile_cpn__prefix',
	cod_fk_initiator_c_mobile_cpn.`number` AS 'cod_fk_initiator_c_mobile_cpn__number',
	cod_fk_initiator_c_mobile_cpn.`extension` AS 'cod_fk_initiator_c_mobile_cpn__extension',
	cod_fk_initiator_c_mobile_cpn.`itu` AS 'cod_fk_initiator_c_mobile_cpn__itu',

	cod.*

FROM `change_order_drafts` cod
	INNER JOIN `projects` cod_fk_p ON cod.`project_id` = cod_fk_p.`id`
	INNER JOIN `change_order_types` cod_fk_cot ON cod.`change_order_type_id` = cod_fk_cot.`id`
	LEFT OUTER JOIN `change_order_priorities` cod_fk_cop ON cod.`change_order_priority_id` = cod_fk_cop.`id`
	LEFT OUTER JOIN `file_manager_files` cod_fk_fmfiles ON cod.`co_file_manager_file_id` = cod_fk_fmfiles.`id`
	LEFT OUTER JOIN `cost_codes` cod_fk_codes ON cod.`co_cost_code_id` = cod_fk_codes.`id`
	INNER JOIN `contacts` cod_fk_creator_c ON cod.`co_creator_contact_id` = cod_fk_creator_c.`id`
	LEFT OUTER JOIN `contact_company_offices` cod_fk_creator_cco ON cod.`co_creator_contact_company_office_id` = cod_fk_creator_cco.`id`
	LEFT OUTER JOIN `contact_company_office_phone_numbers` cod_fk_creator_phone_ccopn ON cod.`co_creator_phone_contact_company_office_phone_number_id` = cod_fk_creator_phone_ccopn.`id`
	LEFT OUTER JOIN `contact_company_office_phone_numbers` cod_fk_creator_fax_ccopn ON cod.`co_creator_fax_contact_company_office_phone_number_id` = cod_fk_creator_fax_ccopn.`id`
	LEFT OUTER JOIN `contact_phone_numbers` cod_fk_creator_c_mobile_cpn ON cod.`co_creator_contact_mobile_phone_number_id` = cod_fk_creator_c_mobile_cpn.`id`
	LEFT OUTER JOIN `contacts` cod_fk_recipient_c ON cod.`co_recipient_contact_id` = cod_fk_recipient_c.`id`
	LEFT OUTER JOIN `contact_company_offices` cod_fk_recipient_cco ON cod.`co_recipient_contact_company_office_id` = cod_fk_recipient_cco.`id`
	LEFT OUTER JOIN `contact_company_office_phone_numbers` cod_fk_recipient_phone_ccopn ON cod.`co_recipient_phone_contact_company_office_phone_number_id` = cod_fk_recipient_phone_ccopn.`id`
	LEFT OUTER JOIN `contact_company_office_phone_numbers` cod_fk_recipient_fax_ccopn ON cod.`co_recipient_fax_contact_company_office_phone_number_id` = cod_fk_recipient_fax_ccopn.`id`
	LEFT OUTER JOIN `contact_phone_numbers` cod_fk_recipient_c_mobile_cpn ON cod.`co_recipient_contact_mobile_phone_number_id` = cod_fk_recipient_c_mobile_cpn.`id`
	LEFT OUTER JOIN `contacts` cod_fk_initiator_c ON cod.`co_initiator_contact_id` = cod_fk_initiator_c.`id`
	LEFT OUTER JOIN `contact_company_offices` cod_fk_initiator_cco ON cod.`co_initiator_contact_company_office_id` = cod_fk_initiator_cco.`id`
	LEFT OUTER JOIN `contact_company_office_phone_numbers` cod_fk_initiator_phone_ccopn ON cod.`co_initiator_phone_contact_company_office_phone_number_id` = cod_fk_initiator_phone_ccopn.`id`
	LEFT OUTER JOIN `contact_company_office_phone_numbers` cod_fk_initiator_fax_ccopn ON cod.`co_initiator_fax_contact_company_office_phone_number_id` = cod_fk_initiator_fax_ccopn.`id`
	LEFT OUTER JOIN `contact_phone_numbers` cod_fk_initiator_c_mobile_cpn ON cod.`co_initiator_contact_mobile_phone_number_id` = cod_fk_initiator_c_mobile_cpn.`id`
WHERE cod.`id` = ?
";
		$arrValues = array($change_order_draft_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$change_order_draft_id = $row['id'];
			$changeOrderDraft = self::instantiateOrm($database, 'ChangeOrderDraft', $row, null, $change_order_draft_id);
			/* @var $changeOrderDraft ChangeOrderDraft */
			$changeOrderDraft->convertPropertiesToData();

			if (isset($row['project_id'])) {
				$project_id = $row['project_id'];
				$row['cod_fk_p__id'] = $project_id;
				$project = self::instantiateOrm($database, 'Project', $row, null, $project_id, 'cod_fk_p__');
				/* @var $project Project */
				$project->convertPropertiesToData();
			} else {
				$project = false;
			}
			$changeOrderDraft->setProject($project);

			if (isset($row['change_order_type_id'])) {
				$change_order_type_id = $row['change_order_type_id'];
				$row['cod_fk_cot__id'] = $change_order_type_id;
				$changeOrderType = self::instantiateOrm($database, 'ChangeOrderType', $row, null, $change_order_type_id, 'cod_fk_cot__');
				/* @var $changeOrderType ChangeOrderType */
				$changeOrderType->convertPropertiesToData();
			} else {
				$changeOrderType = false;
			}
			$changeOrderDraft->setChangeOrderType($changeOrderType);

			if (isset($row['change_order_priority_id'])) {
				$change_order_priority_id = $row['change_order_priority_id'];
				$row['cod_fk_cop__id'] = $change_order_priority_id;
				$changeOrderPriority = self::instantiateOrm($database, 'ChangeOrderPriority', $row, null, $change_order_priority_id, 'cod_fk_cop__');
				/* @var $changeOrderPriority ChangeOrderPriority */
				$changeOrderPriority->convertPropertiesToData();
			} else {
				$changeOrderPriority = false;
			}
			$changeOrderDraft->setChangeOrderPriority($changeOrderPriority);

			if (isset($row['co_file_manager_file_id'])) {
				$co_file_manager_file_id = $row['co_file_manager_file_id'];
				$row['cod_fk_fmfiles__id'] = $co_file_manager_file_id;
				$coFileManagerFile = self::instantiateOrm($database, 'FileManagerFile', $row, null, $co_file_manager_file_id, 'cod_fk_fmfiles__');
				/* @var $coFileManagerFile FileManagerFile */
				$coFileManagerFile->convertPropertiesToData();
			} else {
				$coFileManagerFile = false;
			}
			$changeOrderDraft->setCoFileManagerFile($coFileManagerFile);

			if (isset($row['co_cost_code_id'])) {
				$co_cost_code_id = $row['co_cost_code_id'];
				$row['cod_fk_codes__id'] = $co_cost_code_id;
				$coCostCode = self::instantiateOrm($database, 'CostCode', $row, null, $co_cost_code_id, 'cod_fk_codes__');
				/* @var $coCostCode CostCode */
				$coCostCode->convertPropertiesToData();
			} else {
				$coCostCode = false;
			}
			$changeOrderDraft->setCoCostCode($coCostCode);

			if (isset($row['co_creator_contact_id'])) {
				$co_creator_contact_id = $row['co_creator_contact_id'];
				$row['cod_fk_creator_c__id'] = $co_creator_contact_id;
				$coCreatorContact = self::instantiateOrm($database, 'Contact', $row, null, $co_creator_contact_id, 'cod_fk_creator_c__');
				/* @var $coCreatorContact Contact */
				$coCreatorContact->convertPropertiesToData();
			} else {
				$coCreatorContact = false;
			}
			$changeOrderDraft->setCoCreatorContact($coCreatorContact);

			if (isset($row['co_creator_contact_company_office_id'])) {
				$co_creator_contact_company_office_id = $row['co_creator_contact_company_office_id'];
				$row['cod_fk_creator_cco__id'] = $co_creator_contact_company_office_id;
				$coCreatorContactCompanyOffice = self::instantiateOrm($database, 'ContactCompanyOffice', $row, null, $co_creator_contact_company_office_id, 'cod_fk_creator_cco__');
				/* @var $coCreatorContactCompanyOffice ContactCompanyOffice */
				$coCreatorContactCompanyOffice->convertPropertiesToData();
			} else {
				$coCreatorContactCompanyOffice = false;
			}
			$changeOrderDraft->setCoCreatorContactCompanyOffice($coCreatorContactCompanyOffice);

			if (isset($row['co_creator_phone_contact_company_office_phone_number_id'])) {
				$co_creator_phone_contact_company_office_phone_number_id = $row['co_creator_phone_contact_company_office_phone_number_id'];
				$row['cod_fk_creator_phone_ccopn__id'] = $co_creator_phone_contact_company_office_phone_number_id;
				$coCreatorPhoneContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $co_creator_phone_contact_company_office_phone_number_id, 'cod_fk_creator_phone_ccopn__');
				/* @var $coCreatorPhoneContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$coCreatorPhoneContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$coCreatorPhoneContactCompanyOfficePhoneNumber = false;
			}
			$changeOrderDraft->setCoCreatorPhoneContactCompanyOfficePhoneNumber($coCreatorPhoneContactCompanyOfficePhoneNumber);

			if (isset($row['co_creator_fax_contact_company_office_phone_number_id'])) {
				$co_creator_fax_contact_company_office_phone_number_id = $row['co_creator_fax_contact_company_office_phone_number_id'];
				$row['cod_fk_creator_fax_ccopn__id'] = $co_creator_fax_contact_company_office_phone_number_id;
				$coCreatorFaxContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $co_creator_fax_contact_company_office_phone_number_id, 'cod_fk_creator_fax_ccopn__');
				/* @var $coCreatorFaxContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$coCreatorFaxContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$coCreatorFaxContactCompanyOfficePhoneNumber = false;
			}
			$changeOrderDraft->setCoCreatorFaxContactCompanyOfficePhoneNumber($coCreatorFaxContactCompanyOfficePhoneNumber);

			if (isset($row['co_creator_contact_mobile_phone_number_id'])) {
				$co_creator_contact_mobile_phone_number_id = $row['co_creator_contact_mobile_phone_number_id'];
				$row['cod_fk_creator_c_mobile_cpn__id'] = $co_creator_contact_mobile_phone_number_id;
				$coCreatorContactMobilePhoneNumber = self::instantiateOrm($database, 'ContactPhoneNumber', $row, null, $co_creator_contact_mobile_phone_number_id, 'cod_fk_creator_c_mobile_cpn__');
				/* @var $coCreatorContactMobilePhoneNumber ContactPhoneNumber */
				$coCreatorContactMobilePhoneNumber->convertPropertiesToData();
			} else {
				$coCreatorContactMobilePhoneNumber = false;
			}
			$changeOrderDraft->setCoCreatorContactMobilePhoneNumber($coCreatorContactMobilePhoneNumber);

			if (isset($row['co_recipient_contact_id'])) {
				$co_recipient_contact_id = $row['co_recipient_contact_id'];
				$row['cod_fk_recipient_c__id'] = $co_recipient_contact_id;
				$coRecipientContact = self::instantiateOrm($database, 'Contact', $row, null, $co_recipient_contact_id, 'cod_fk_recipient_c__');
				/* @var $coRecipientContact Contact */
				$coRecipientContact->convertPropertiesToData();
			} else {
				$coRecipientContact = false;
			}
			$changeOrderDraft->setCoRecipientContact($coRecipientContact);

			if (isset($row['co_recipient_contact_company_office_id'])) {
				$co_recipient_contact_company_office_id = $row['co_recipient_contact_company_office_id'];
				$row['cod_fk_recipient_cco__id'] = $co_recipient_contact_company_office_id;
				$coRecipientContactCompanyOffice = self::instantiateOrm($database, 'ContactCompanyOffice', $row, null, $co_recipient_contact_company_office_id, 'cod_fk_recipient_cco__');
				/* @var $coRecipientContactCompanyOffice ContactCompanyOffice */
				$coRecipientContactCompanyOffice->convertPropertiesToData();
			} else {
				$coRecipientContactCompanyOffice = false;
			}
			$changeOrderDraft->setCoRecipientContactCompanyOffice($coRecipientContactCompanyOffice);

			if (isset($row['co_recipient_phone_contact_company_office_phone_number_id'])) {
				$co_recipient_phone_contact_company_office_phone_number_id = $row['co_recipient_phone_contact_company_office_phone_number_id'];
				$row['cod_fk_recipient_phone_ccopn__id'] = $co_recipient_phone_contact_company_office_phone_number_id;
				$coRecipientPhoneContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $co_recipient_phone_contact_company_office_phone_number_id, 'cod_fk_recipient_phone_ccopn__');
				/* @var $coRecipientPhoneContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$coRecipientPhoneContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$coRecipientPhoneContactCompanyOfficePhoneNumber = false;
			}
			$changeOrderDraft->setCoRecipientPhoneContactCompanyOfficePhoneNumber($coRecipientPhoneContactCompanyOfficePhoneNumber);

			if (isset($row['co_recipient_fax_contact_company_office_phone_number_id'])) {
				$co_recipient_fax_contact_company_office_phone_number_id = $row['co_recipient_fax_contact_company_office_phone_number_id'];
				$row['cod_fk_recipient_fax_ccopn__id'] = $co_recipient_fax_contact_company_office_phone_number_id;
				$coRecipientFaxContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $co_recipient_fax_contact_company_office_phone_number_id, 'cod_fk_recipient_fax_ccopn__');
				/* @var $coRecipientFaxContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$coRecipientFaxContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$coRecipientFaxContactCompanyOfficePhoneNumber = false;
			}
			$changeOrderDraft->setCoRecipientFaxContactCompanyOfficePhoneNumber($coRecipientFaxContactCompanyOfficePhoneNumber);

			if (isset($row['co_recipient_contact_mobile_phone_number_id'])) {
				$co_recipient_contact_mobile_phone_number_id = $row['co_recipient_contact_mobile_phone_number_id'];
				$row['cod_fk_recipient_c_mobile_cpn__id'] = $co_recipient_contact_mobile_phone_number_id;
				$coRecipientContactMobilePhoneNumber = self::instantiateOrm($database, 'ContactPhoneNumber', $row, null, $co_recipient_contact_mobile_phone_number_id, 'cod_fk_recipient_c_mobile_cpn__');
				/* @var $coRecipientContactMobilePhoneNumber ContactPhoneNumber */
				$coRecipientContactMobilePhoneNumber->convertPropertiesToData();
			} else {
				$coRecipientContactMobilePhoneNumber = false;
			}
			$changeOrderDraft->setCoRecipientContactMobilePhoneNumber($coRecipientContactMobilePhoneNumber);

			if (isset($row['co_initiator_contact_id'])) {
				$co_initiator_contact_id = $row['co_initiator_contact_id'];
				$row['cod_fk_initiator_c__id'] = $co_initiator_contact_id;
				$coInitiatorContact = self::instantiateOrm($database, 'Contact', $row, null, $co_initiator_contact_id, 'cod_fk_initiator_c__');
				/* @var $coInitiatorContact Contact */
				$coInitiatorContact->convertPropertiesToData();
			} else {
				$coInitiatorContact = false;
			}
			$changeOrderDraft->setCoInitiatorContact($coInitiatorContact);

			if (isset($row['co_initiator_contact_company_office_id'])) {
				$co_initiator_contact_company_office_id = $row['co_initiator_contact_company_office_id'];
				$row['cod_fk_initiator_cco__id'] = $co_initiator_contact_company_office_id;
				$coInitiatorContactCompanyOffice = self::instantiateOrm($database, 'ContactCompanyOffice', $row, null, $co_initiator_contact_company_office_id, 'cod_fk_initiator_cco__');
				/* @var $coInitiatorContactCompanyOffice ContactCompanyOffice */
				$coInitiatorContactCompanyOffice->convertPropertiesToData();
			} else {
				$coInitiatorContactCompanyOffice = false;
			}
			$changeOrderDraft->setCoInitiatorContactCompanyOffice($coInitiatorContactCompanyOffice);

			if (isset($row['co_initiator_phone_contact_company_office_phone_number_id'])) {
				$co_initiator_phone_contact_company_office_phone_number_id = $row['co_initiator_phone_contact_company_office_phone_number_id'];
				$row['cod_fk_initiator_phone_ccopn__id'] = $co_initiator_phone_contact_company_office_phone_number_id;
				$coInitiatorPhoneContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $co_initiator_phone_contact_company_office_phone_number_id, 'cod_fk_initiator_phone_ccopn__');
				/* @var $coInitiatorPhoneContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$coInitiatorPhoneContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$coInitiatorPhoneContactCompanyOfficePhoneNumber = false;
			}
			$changeOrderDraft->setCoInitiatorPhoneContactCompanyOfficePhoneNumber($coInitiatorPhoneContactCompanyOfficePhoneNumber);

			if (isset($row['co_initiator_fax_contact_company_office_phone_number_id'])) {
				$co_initiator_fax_contact_company_office_phone_number_id = $row['co_initiator_fax_contact_company_office_phone_number_id'];
				$row['cod_fk_initiator_fax_ccopn__id'] = $co_initiator_fax_contact_company_office_phone_number_id;
				$coInitiatorFaxContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $co_initiator_fax_contact_company_office_phone_number_id, 'cod_fk_initiator_fax_ccopn__');
				/* @var $coInitiatorFaxContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$coInitiatorFaxContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$coInitiatorFaxContactCompanyOfficePhoneNumber = false;
			}
			$changeOrderDraft->setCoInitiatorFaxContactCompanyOfficePhoneNumber($coInitiatorFaxContactCompanyOfficePhoneNumber);

			if (isset($row['co_initiator_contact_mobile_phone_number_id'])) {
				$co_initiator_contact_mobile_phone_number_id = $row['co_initiator_contact_mobile_phone_number_id'];
				$row['cod_fk_initiator_c_mobile_cpn__id'] = $co_initiator_contact_mobile_phone_number_id;
				$coInitiatorContactMobilePhoneNumber = self::instantiateOrm($database, 'ContactPhoneNumber', $row, null, $co_initiator_contact_mobile_phone_number_id, 'cod_fk_initiator_c_mobile_cpn__');
				/* @var $coInitiatorContactMobilePhoneNumber ContactPhoneNumber */
				$coInitiatorContactMobilePhoneNumber->convertPropertiesToData();
			} else {
				$coInitiatorContactMobilePhoneNumber = false;
			}
			$changeOrderDraft->setCoInitiatorContactMobilePhoneNumber($coInitiatorContactMobilePhoneNumber);

			return $changeOrderDraft;
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
	 * @param array $arrChangeOrderDraftIds
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadChangeOrderDraftsByArrChangeOrderDraftIds($database, $arrChangeOrderDraftIds, Input $options=null)
	{
		if (empty($arrChangeOrderDraftIds)) {
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
		// ORDER BY `id` ASC, `project_id` ASC, `change_order_type_id` ASC, `change_order_priority_id` ASC, `co_file_manager_file_id` ASC, `co_cost_code_id` ASC, `co_creator_contact_id` ASC, `co_creator_contact_company_office_id` ASC, `co_creator_phone_contact_company_office_phone_number_id` ASC, `co_creator_fax_contact_company_office_phone_number_id` ASC, `co_creator_contact_mobile_phone_number_id` ASC, `co_recipient_contact_id` ASC, `co_recipient_contact_company_office_id` ASC, `co_recipient_phone_contact_company_office_phone_number_id` ASC, `co_recipient_fax_contact_company_office_phone_number_id` ASC, `co_recipient_contact_mobile_phone_number_id` ASC, `co_initiator_contact_id` ASC, `co_initiator_contact_company_office_id` ASC, `co_initiator_phone_contact_company_office_phone_number_id` ASC, `co_initiator_fax_contact_company_office_phone_number_id` ASC, `co_initiator_contact_mobile_phone_number_id` ASC, `co_title` ASC, `co_plan_page_reference` ASC, `co_statement` ASC, `co_revised_project_completion_date` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpChangeOrderDraft = new ChangeOrderDraft($database);
			$sqlOrderByColumns = $tmpChangeOrderDraft->constructSqlOrderByColumns($arrOrderByAttributes);

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

		foreach ($arrChangeOrderDraftIds as $k => $change_order_draft_id) {
			$change_order_draft_id = (int) $change_order_draft_id;
			$arrChangeOrderDraftIds[$k] = $db->escape($change_order_draft_id);
		}
		$csvChangeOrderDraftIds = join(',', $arrChangeOrderDraftIds);

		$query =
"
SELECT

	cod.*

FROM `change_order_drafts` cod
WHERE cod.`id` IN ($csvChangeOrderDraftIds){$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		$arrChangeOrderDraftsByCsvChangeOrderDraftIds = array();
		while ($row = $db->fetch()) {
			$change_order_draft_id = $row['id'];
			$changeOrderDraft = self::instantiateOrm($database, 'ChangeOrderDraft', $row, null, $change_order_draft_id);
			/* @var $changeOrderDraft ChangeOrderDraft */
			$changeOrderDraft->convertPropertiesToData();

			$arrChangeOrderDraftsByCsvChangeOrderDraftIds[$change_order_draft_id] = $changeOrderDraft;
		}

		$db->free_result();

		return $arrChangeOrderDraftsByCsvChangeOrderDraftIds;
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `change_order_drafts_fk_p` foreign key (`project_id`) references `projects` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $project_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadChangeOrderDraftsByProjectId($database, $project_id, Input $options=null)
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
			self::$_arrChangeOrderDraftsByProjectId = null;
		}

		$arrChangeOrderDraftsByProjectId = self::$_arrChangeOrderDraftsByProjectId;
		if (isset($arrChangeOrderDraftsByProjectId) && !empty($arrChangeOrderDraftsByProjectId)) {
			return $arrChangeOrderDraftsByProjectId;
		}

		$project_id = (int) $project_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `change_order_type_id` ASC, `change_order_priority_id` ASC, `co_file_manager_file_id` ASC, `co_cost_code_id` ASC, `co_creator_contact_id` ASC, `co_creator_contact_company_office_id` ASC, `co_creator_phone_contact_company_office_phone_number_id` ASC, `co_creator_fax_contact_company_office_phone_number_id` ASC, `co_creator_contact_mobile_phone_number_id` ASC, `co_recipient_contact_id` ASC, `co_recipient_contact_company_office_id` ASC, `co_recipient_phone_contact_company_office_phone_number_id` ASC, `co_recipient_fax_contact_company_office_phone_number_id` ASC, `co_recipient_contact_mobile_phone_number_id` ASC, `co_initiator_contact_id` ASC, `co_initiator_contact_company_office_id` ASC, `co_initiator_phone_contact_company_office_phone_number_id` ASC, `co_initiator_fax_contact_company_office_phone_number_id` ASC, `co_initiator_contact_mobile_phone_number_id` ASC, `co_title` ASC, `co_plan_page_reference` ASC, `co_statement` ASC, `co_revised_project_completion_date` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpChangeOrderDraft = new ChangeOrderDraft($database);
			$sqlOrderByColumns = $tmpChangeOrderDraft->constructSqlOrderByColumns($arrOrderByAttributes);

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
	cod.*

FROM `change_order_drafts` cod
WHERE cod.`project_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `change_order_type_id` ASC, `change_order_priority_id` ASC, `co_file_manager_file_id` ASC, `co_cost_code_id` ASC, `co_creator_contact_id` ASC, `co_creator_contact_company_office_id` ASC, `co_creator_phone_contact_company_office_phone_number_id` ASC, `co_creator_fax_contact_company_office_phone_number_id` ASC, `co_creator_contact_mobile_phone_number_id` ASC, `co_recipient_contact_id` ASC, `co_recipient_contact_company_office_id` ASC, `co_recipient_phone_contact_company_office_phone_number_id` ASC, `co_recipient_fax_contact_company_office_phone_number_id` ASC, `co_recipient_contact_mobile_phone_number_id` ASC, `co_initiator_contact_id` ASC, `co_initiator_contact_company_office_id` ASC, `co_initiator_phone_contact_company_office_phone_number_id` ASC, `co_initiator_fax_contact_company_office_phone_number_id` ASC, `co_initiator_contact_mobile_phone_number_id` ASC, `co_title` ASC, `co_plan_page_reference` ASC, `co_statement` ASC, `co_revised_project_completion_date` ASC
		$arrValues = array($project_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrChangeOrderDraftsByProjectId = array();
		while ($row = $db->fetch()) {
			$change_order_draft_id = $row['id'];
			$changeOrderDraft = self::instantiateOrm($database, 'ChangeOrderDraft', $row, null, $change_order_draft_id);
			/* @var $changeOrderDraft ChangeOrderDraft */
			$arrChangeOrderDraftsByProjectId[$change_order_draft_id] = $changeOrderDraft;
		}

		$db->free_result();

		self::$_arrChangeOrderDraftsByProjectId = $arrChangeOrderDraftsByProjectId;

		return $arrChangeOrderDraftsByProjectId;
	}

	/**
	 * Load by constraint `change_order_drafts_fk_cot` foreign key (`change_order_type_id`) references `change_order_types` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $change_order_type_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadChangeOrderDraftsByChangeOrderTypeId($database, $change_order_type_id, Input $options=null)
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
			self::$_arrChangeOrderDraftsByChangeOrderTypeId = null;
		}

		$arrChangeOrderDraftsByChangeOrderTypeId = self::$_arrChangeOrderDraftsByChangeOrderTypeId;
		if (isset($arrChangeOrderDraftsByChangeOrderTypeId) && !empty($arrChangeOrderDraftsByChangeOrderTypeId)) {
			return $arrChangeOrderDraftsByChangeOrderTypeId;
		}

		$change_order_type_id = (int) $change_order_type_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `change_order_type_id` ASC, `change_order_priority_id` ASC, `co_file_manager_file_id` ASC, `co_cost_code_id` ASC, `co_creator_contact_id` ASC, `co_creator_contact_company_office_id` ASC, `co_creator_phone_contact_company_office_phone_number_id` ASC, `co_creator_fax_contact_company_office_phone_number_id` ASC, `co_creator_contact_mobile_phone_number_id` ASC, `co_recipient_contact_id` ASC, `co_recipient_contact_company_office_id` ASC, `co_recipient_phone_contact_company_office_phone_number_id` ASC, `co_recipient_fax_contact_company_office_phone_number_id` ASC, `co_recipient_contact_mobile_phone_number_id` ASC, `co_initiator_contact_id` ASC, `co_initiator_contact_company_office_id` ASC, `co_initiator_phone_contact_company_office_phone_number_id` ASC, `co_initiator_fax_contact_company_office_phone_number_id` ASC, `co_initiator_contact_mobile_phone_number_id` ASC, `co_title` ASC, `co_plan_page_reference` ASC, `co_statement` ASC, `co_revised_project_completion_date` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpChangeOrderDraft = new ChangeOrderDraft($database);
			$sqlOrderByColumns = $tmpChangeOrderDraft->constructSqlOrderByColumns($arrOrderByAttributes);

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
	cod.*

FROM `change_order_drafts` cod
WHERE cod.`change_order_type_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `change_order_type_id` ASC, `change_order_priority_id` ASC, `co_file_manager_file_id` ASC, `co_cost_code_id` ASC, `co_creator_contact_id` ASC, `co_creator_contact_company_office_id` ASC, `co_creator_phone_contact_company_office_phone_number_id` ASC, `co_creator_fax_contact_company_office_phone_number_id` ASC, `co_creator_contact_mobile_phone_number_id` ASC, `co_recipient_contact_id` ASC, `co_recipient_contact_company_office_id` ASC, `co_recipient_phone_contact_company_office_phone_number_id` ASC, `co_recipient_fax_contact_company_office_phone_number_id` ASC, `co_recipient_contact_mobile_phone_number_id` ASC, `co_initiator_contact_id` ASC, `co_initiator_contact_company_office_id` ASC, `co_initiator_phone_contact_company_office_phone_number_id` ASC, `co_initiator_fax_contact_company_office_phone_number_id` ASC, `co_initiator_contact_mobile_phone_number_id` ASC, `co_title` ASC, `co_plan_page_reference` ASC, `co_statement` ASC, `co_revised_project_completion_date` ASC
		$arrValues = array($change_order_type_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrChangeOrderDraftsByChangeOrderTypeId = array();
		while ($row = $db->fetch()) {
			$change_order_draft_id = $row['id'];
			$changeOrderDraft = self::instantiateOrm($database, 'ChangeOrderDraft', $row, null, $change_order_draft_id);
			/* @var $changeOrderDraft ChangeOrderDraft */
			$arrChangeOrderDraftsByChangeOrderTypeId[$change_order_draft_id] = $changeOrderDraft;
		}

		$db->free_result();

		self::$_arrChangeOrderDraftsByChangeOrderTypeId = $arrChangeOrderDraftsByChangeOrderTypeId;

		return $arrChangeOrderDraftsByChangeOrderTypeId;
	}

	/**
	 * Load by constraint `change_order_drafts_fk_cop` foreign key (`change_order_priority_id`) references `change_order_priorities` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $change_order_priority_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadChangeOrderDraftsByChangeOrderPriorityId($database, $change_order_priority_id, Input $options=null)
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
			self::$_arrChangeOrderDraftsByChangeOrderPriorityId = null;
		}

		$arrChangeOrderDraftsByChangeOrderPriorityId = self::$_arrChangeOrderDraftsByChangeOrderPriorityId;
		if (isset($arrChangeOrderDraftsByChangeOrderPriorityId) && !empty($arrChangeOrderDraftsByChangeOrderPriorityId)) {
			return $arrChangeOrderDraftsByChangeOrderPriorityId;
		}

		$change_order_priority_id = (int) $change_order_priority_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `change_order_type_id` ASC, `change_order_priority_id` ASC, `co_file_manager_file_id` ASC, `co_cost_code_id` ASC, `co_creator_contact_id` ASC, `co_creator_contact_company_office_id` ASC, `co_creator_phone_contact_company_office_phone_number_id` ASC, `co_creator_fax_contact_company_office_phone_number_id` ASC, `co_creator_contact_mobile_phone_number_id` ASC, `co_recipient_contact_id` ASC, `co_recipient_contact_company_office_id` ASC, `co_recipient_phone_contact_company_office_phone_number_id` ASC, `co_recipient_fax_contact_company_office_phone_number_id` ASC, `co_recipient_contact_mobile_phone_number_id` ASC, `co_initiator_contact_id` ASC, `co_initiator_contact_company_office_id` ASC, `co_initiator_phone_contact_company_office_phone_number_id` ASC, `co_initiator_fax_contact_company_office_phone_number_id` ASC, `co_initiator_contact_mobile_phone_number_id` ASC, `co_title` ASC, `co_plan_page_reference` ASC, `co_statement` ASC, `co_revised_project_completion_date` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpChangeOrderDraft = new ChangeOrderDraft($database);
			$sqlOrderByColumns = $tmpChangeOrderDraft->constructSqlOrderByColumns($arrOrderByAttributes);

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
	cod.*

FROM `change_order_drafts` cod
WHERE cod.`change_order_priority_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `change_order_type_id` ASC, `change_order_priority_id` ASC, `co_file_manager_file_id` ASC, `co_cost_code_id` ASC, `co_creator_contact_id` ASC, `co_creator_contact_company_office_id` ASC, `co_creator_phone_contact_company_office_phone_number_id` ASC, `co_creator_fax_contact_company_office_phone_number_id` ASC, `co_creator_contact_mobile_phone_number_id` ASC, `co_recipient_contact_id` ASC, `co_recipient_contact_company_office_id` ASC, `co_recipient_phone_contact_company_office_phone_number_id` ASC, `co_recipient_fax_contact_company_office_phone_number_id` ASC, `co_recipient_contact_mobile_phone_number_id` ASC, `co_initiator_contact_id` ASC, `co_initiator_contact_company_office_id` ASC, `co_initiator_phone_contact_company_office_phone_number_id` ASC, `co_initiator_fax_contact_company_office_phone_number_id` ASC, `co_initiator_contact_mobile_phone_number_id` ASC, `co_title` ASC, `co_plan_page_reference` ASC, `co_statement` ASC, `co_revised_project_completion_date` ASC
		$arrValues = array($change_order_priority_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrChangeOrderDraftsByChangeOrderPriorityId = array();
		while ($row = $db->fetch()) {
			$change_order_draft_id = $row['id'];
			$changeOrderDraft = self::instantiateOrm($database, 'ChangeOrderDraft', $row, null, $change_order_draft_id);
			/* @var $changeOrderDraft ChangeOrderDraft */
			$arrChangeOrderDraftsByChangeOrderPriorityId[$change_order_draft_id] = $changeOrderDraft;
		}

		$db->free_result();

		self::$_arrChangeOrderDraftsByChangeOrderPriorityId = $arrChangeOrderDraftsByChangeOrderPriorityId;

		return $arrChangeOrderDraftsByChangeOrderPriorityId;
	}

	/**
	 * Load by constraint `change_order_drafts_fk_fmfiles` foreign key (`co_file_manager_file_id`) references `file_manager_files` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $co_file_manager_file_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadChangeOrderDraftsByCoFileManagerFileId($database, $co_file_manager_file_id, Input $options=null)
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
			self::$_arrChangeOrderDraftsByCoFileManagerFileId = null;
		}

		$arrChangeOrderDraftsByCoFileManagerFileId = self::$_arrChangeOrderDraftsByCoFileManagerFileId;
		if (isset($arrChangeOrderDraftsByCoFileManagerFileId) && !empty($arrChangeOrderDraftsByCoFileManagerFileId)) {
			return $arrChangeOrderDraftsByCoFileManagerFileId;
		}

		$co_file_manager_file_id = (int) $co_file_manager_file_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `change_order_type_id` ASC, `change_order_priority_id` ASC, `co_file_manager_file_id` ASC, `co_cost_code_id` ASC, `co_creator_contact_id` ASC, `co_creator_contact_company_office_id` ASC, `co_creator_phone_contact_company_office_phone_number_id` ASC, `co_creator_fax_contact_company_office_phone_number_id` ASC, `co_creator_contact_mobile_phone_number_id` ASC, `co_recipient_contact_id` ASC, `co_recipient_contact_company_office_id` ASC, `co_recipient_phone_contact_company_office_phone_number_id` ASC, `co_recipient_fax_contact_company_office_phone_number_id` ASC, `co_recipient_contact_mobile_phone_number_id` ASC, `co_initiator_contact_id` ASC, `co_initiator_contact_company_office_id` ASC, `co_initiator_phone_contact_company_office_phone_number_id` ASC, `co_initiator_fax_contact_company_office_phone_number_id` ASC, `co_initiator_contact_mobile_phone_number_id` ASC, `co_title` ASC, `co_plan_page_reference` ASC, `co_statement` ASC, `co_revised_project_completion_date` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpChangeOrderDraft = new ChangeOrderDraft($database);
			$sqlOrderByColumns = $tmpChangeOrderDraft->constructSqlOrderByColumns($arrOrderByAttributes);

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
	cod.*

FROM `change_order_drafts` cod
WHERE cod.`co_file_manager_file_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `change_order_type_id` ASC, `change_order_priority_id` ASC, `co_file_manager_file_id` ASC, `co_cost_code_id` ASC, `co_creator_contact_id` ASC, `co_creator_contact_company_office_id` ASC, `co_creator_phone_contact_company_office_phone_number_id` ASC, `co_creator_fax_contact_company_office_phone_number_id` ASC, `co_creator_contact_mobile_phone_number_id` ASC, `co_recipient_contact_id` ASC, `co_recipient_contact_company_office_id` ASC, `co_recipient_phone_contact_company_office_phone_number_id` ASC, `co_recipient_fax_contact_company_office_phone_number_id` ASC, `co_recipient_contact_mobile_phone_number_id` ASC, `co_initiator_contact_id` ASC, `co_initiator_contact_company_office_id` ASC, `co_initiator_phone_contact_company_office_phone_number_id` ASC, `co_initiator_fax_contact_company_office_phone_number_id` ASC, `co_initiator_contact_mobile_phone_number_id` ASC, `co_title` ASC, `co_plan_page_reference` ASC, `co_statement` ASC, `co_revised_project_completion_date` ASC
		$arrValues = array($co_file_manager_file_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrChangeOrderDraftsByCoFileManagerFileId = array();
		while ($row = $db->fetch()) {
			$change_order_draft_id = $row['id'];
			$changeOrderDraft = self::instantiateOrm($database, 'ChangeOrderDraft', $row, null, $change_order_draft_id);
			/* @var $changeOrderDraft ChangeOrderDraft */
			$arrChangeOrderDraftsByCoFileManagerFileId[$change_order_draft_id] = $changeOrderDraft;
		}

		$db->free_result();

		self::$_arrChangeOrderDraftsByCoFileManagerFileId = $arrChangeOrderDraftsByCoFileManagerFileId;

		return $arrChangeOrderDraftsByCoFileManagerFileId;
	}

	/**
	 * Load by constraint `change_order_drafts_fk_codes` foreign key (`co_cost_code_id`) references `cost_codes` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $co_cost_code_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadChangeOrderDraftsByCoCostCodeId($database, $co_cost_code_id, Input $options=null)
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
			self::$_arrChangeOrderDraftsByCoCostCodeId = null;
		}

		$arrChangeOrderDraftsByCoCostCodeId = self::$_arrChangeOrderDraftsByCoCostCodeId;
		if (isset($arrChangeOrderDraftsByCoCostCodeId) && !empty($arrChangeOrderDraftsByCoCostCodeId)) {
			return $arrChangeOrderDraftsByCoCostCodeId;
		}

		$co_cost_code_id = (int) $co_cost_code_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `change_order_type_id` ASC, `change_order_priority_id` ASC, `co_file_manager_file_id` ASC, `co_cost_code_id` ASC, `co_creator_contact_id` ASC, `co_creator_contact_company_office_id` ASC, `co_creator_phone_contact_company_office_phone_number_id` ASC, `co_creator_fax_contact_company_office_phone_number_id` ASC, `co_creator_contact_mobile_phone_number_id` ASC, `co_recipient_contact_id` ASC, `co_recipient_contact_company_office_id` ASC, `co_recipient_phone_contact_company_office_phone_number_id` ASC, `co_recipient_fax_contact_company_office_phone_number_id` ASC, `co_recipient_contact_mobile_phone_number_id` ASC, `co_initiator_contact_id` ASC, `co_initiator_contact_company_office_id` ASC, `co_initiator_phone_contact_company_office_phone_number_id` ASC, `co_initiator_fax_contact_company_office_phone_number_id` ASC, `co_initiator_contact_mobile_phone_number_id` ASC, `co_title` ASC, `co_plan_page_reference` ASC, `co_statement` ASC, `co_revised_project_completion_date` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpChangeOrderDraft = new ChangeOrderDraft($database);
			$sqlOrderByColumns = $tmpChangeOrderDraft->constructSqlOrderByColumns($arrOrderByAttributes);

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
	cod.*

FROM `change_order_drafts` cod
WHERE cod.`co_cost_code_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `change_order_type_id` ASC, `change_order_priority_id` ASC, `co_file_manager_file_id` ASC, `co_cost_code_id` ASC, `co_creator_contact_id` ASC, `co_creator_contact_company_office_id` ASC, `co_creator_phone_contact_company_office_phone_number_id` ASC, `co_creator_fax_contact_company_office_phone_number_id` ASC, `co_creator_contact_mobile_phone_number_id` ASC, `co_recipient_contact_id` ASC, `co_recipient_contact_company_office_id` ASC, `co_recipient_phone_contact_company_office_phone_number_id` ASC, `co_recipient_fax_contact_company_office_phone_number_id` ASC, `co_recipient_contact_mobile_phone_number_id` ASC, `co_initiator_contact_id` ASC, `co_initiator_contact_company_office_id` ASC, `co_initiator_phone_contact_company_office_phone_number_id` ASC, `co_initiator_fax_contact_company_office_phone_number_id` ASC, `co_initiator_contact_mobile_phone_number_id` ASC, `co_title` ASC, `co_plan_page_reference` ASC, `co_statement` ASC, `co_revised_project_completion_date` ASC
		$arrValues = array($co_cost_code_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrChangeOrderDraftsByCoCostCodeId = array();
		while ($row = $db->fetch()) {
			$change_order_draft_id = $row['id'];
			$changeOrderDraft = self::instantiateOrm($database, 'ChangeOrderDraft', $row, null, $change_order_draft_id);
			/* @var $changeOrderDraft ChangeOrderDraft */
			$arrChangeOrderDraftsByCoCostCodeId[$change_order_draft_id] = $changeOrderDraft;
		}

		$db->free_result();

		self::$_arrChangeOrderDraftsByCoCostCodeId = $arrChangeOrderDraftsByCoCostCodeId;

		return $arrChangeOrderDraftsByCoCostCodeId;
	}

	/**
	 * Load by constraint `change_order_drafts_fk_creator_c` foreign key (`co_creator_contact_id`) references `contacts` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $co_creator_contact_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadChangeOrderDraftsByCoCreatorContactId($database, $co_creator_contact_id, Input $options=null)
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
			self::$_arrChangeOrderDraftsByCoCreatorContactId = null;
		}

		$arrChangeOrderDraftsByCoCreatorContactId = self::$_arrChangeOrderDraftsByCoCreatorContactId;
		if (isset($arrChangeOrderDraftsByCoCreatorContactId) && !empty($arrChangeOrderDraftsByCoCreatorContactId)) {
			return $arrChangeOrderDraftsByCoCreatorContactId;
		}

		$co_creator_contact_id = (int) $co_creator_contact_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `change_order_type_id` ASC, `change_order_priority_id` ASC, `co_file_manager_file_id` ASC, `co_cost_code_id` ASC, `co_creator_contact_id` ASC, `co_creator_contact_company_office_id` ASC, `co_creator_phone_contact_company_office_phone_number_id` ASC, `co_creator_fax_contact_company_office_phone_number_id` ASC, `co_creator_contact_mobile_phone_number_id` ASC, `co_recipient_contact_id` ASC, `co_recipient_contact_company_office_id` ASC, `co_recipient_phone_contact_company_office_phone_number_id` ASC, `co_recipient_fax_contact_company_office_phone_number_id` ASC, `co_recipient_contact_mobile_phone_number_id` ASC, `co_initiator_contact_id` ASC, `co_initiator_contact_company_office_id` ASC, `co_initiator_phone_contact_company_office_phone_number_id` ASC, `co_initiator_fax_contact_company_office_phone_number_id` ASC, `co_initiator_contact_mobile_phone_number_id` ASC, `co_title` ASC, `co_plan_page_reference` ASC, `co_statement` ASC, `co_revised_project_completion_date` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpChangeOrderDraft = new ChangeOrderDraft($database);
			$sqlOrderByColumns = $tmpChangeOrderDraft->constructSqlOrderByColumns($arrOrderByAttributes);

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
	cod.*

FROM `change_order_drafts` cod
WHERE cod.`co_creator_contact_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `change_order_type_id` ASC, `change_order_priority_id` ASC, `co_file_manager_file_id` ASC, `co_cost_code_id` ASC, `co_creator_contact_id` ASC, `co_creator_contact_company_office_id` ASC, `co_creator_phone_contact_company_office_phone_number_id` ASC, `co_creator_fax_contact_company_office_phone_number_id` ASC, `co_creator_contact_mobile_phone_number_id` ASC, `co_recipient_contact_id` ASC, `co_recipient_contact_company_office_id` ASC, `co_recipient_phone_contact_company_office_phone_number_id` ASC, `co_recipient_fax_contact_company_office_phone_number_id` ASC, `co_recipient_contact_mobile_phone_number_id` ASC, `co_initiator_contact_id` ASC, `co_initiator_contact_company_office_id` ASC, `co_initiator_phone_contact_company_office_phone_number_id` ASC, `co_initiator_fax_contact_company_office_phone_number_id` ASC, `co_initiator_contact_mobile_phone_number_id` ASC, `co_title` ASC, `co_plan_page_reference` ASC, `co_statement` ASC, `co_revised_project_completion_date` ASC
		$arrValues = array($co_creator_contact_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrChangeOrderDraftsByCoCreatorContactId = array();
		while ($row = $db->fetch()) {
			$change_order_draft_id = $row['id'];
			$changeOrderDraft = self::instantiateOrm($database, 'ChangeOrderDraft', $row, null, $change_order_draft_id);
			/* @var $changeOrderDraft ChangeOrderDraft */
			$arrChangeOrderDraftsByCoCreatorContactId[$change_order_draft_id] = $changeOrderDraft;
		}

		$db->free_result();

		self::$_arrChangeOrderDraftsByCoCreatorContactId = $arrChangeOrderDraftsByCoCreatorContactId;

		return $arrChangeOrderDraftsByCoCreatorContactId;
	}

	/**
	 * Load by constraint `change_order_drafts_fk_creator_cco` foreign key (`co_creator_contact_company_office_id`) references `contact_company_offices` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $co_creator_contact_company_office_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadChangeOrderDraftsByCoCreatorContactCompanyOfficeId($database, $co_creator_contact_company_office_id, Input $options=null)
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
			self::$_arrChangeOrderDraftsByCoCreatorContactCompanyOfficeId = null;
		}

		$arrChangeOrderDraftsByCoCreatorContactCompanyOfficeId = self::$_arrChangeOrderDraftsByCoCreatorContactCompanyOfficeId;
		if (isset($arrChangeOrderDraftsByCoCreatorContactCompanyOfficeId) && !empty($arrChangeOrderDraftsByCoCreatorContactCompanyOfficeId)) {
			return $arrChangeOrderDraftsByCoCreatorContactCompanyOfficeId;
		}

		$co_creator_contact_company_office_id = (int) $co_creator_contact_company_office_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `change_order_type_id` ASC, `change_order_priority_id` ASC, `co_file_manager_file_id` ASC, `co_cost_code_id` ASC, `co_creator_contact_id` ASC, `co_creator_contact_company_office_id` ASC, `co_creator_phone_contact_company_office_phone_number_id` ASC, `co_creator_fax_contact_company_office_phone_number_id` ASC, `co_creator_contact_mobile_phone_number_id` ASC, `co_recipient_contact_id` ASC, `co_recipient_contact_company_office_id` ASC, `co_recipient_phone_contact_company_office_phone_number_id` ASC, `co_recipient_fax_contact_company_office_phone_number_id` ASC, `co_recipient_contact_mobile_phone_number_id` ASC, `co_initiator_contact_id` ASC, `co_initiator_contact_company_office_id` ASC, `co_initiator_phone_contact_company_office_phone_number_id` ASC, `co_initiator_fax_contact_company_office_phone_number_id` ASC, `co_initiator_contact_mobile_phone_number_id` ASC, `co_title` ASC, `co_plan_page_reference` ASC, `co_statement` ASC, `co_revised_project_completion_date` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpChangeOrderDraft = new ChangeOrderDraft($database);
			$sqlOrderByColumns = $tmpChangeOrderDraft->constructSqlOrderByColumns($arrOrderByAttributes);

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
	cod.*

FROM `change_order_drafts` cod
WHERE cod.`co_creator_contact_company_office_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `change_order_type_id` ASC, `change_order_priority_id` ASC, `co_file_manager_file_id` ASC, `co_cost_code_id` ASC, `co_creator_contact_id` ASC, `co_creator_contact_company_office_id` ASC, `co_creator_phone_contact_company_office_phone_number_id` ASC, `co_creator_fax_contact_company_office_phone_number_id` ASC, `co_creator_contact_mobile_phone_number_id` ASC, `co_recipient_contact_id` ASC, `co_recipient_contact_company_office_id` ASC, `co_recipient_phone_contact_company_office_phone_number_id` ASC, `co_recipient_fax_contact_company_office_phone_number_id` ASC, `co_recipient_contact_mobile_phone_number_id` ASC, `co_initiator_contact_id` ASC, `co_initiator_contact_company_office_id` ASC, `co_initiator_phone_contact_company_office_phone_number_id` ASC, `co_initiator_fax_contact_company_office_phone_number_id` ASC, `co_initiator_contact_mobile_phone_number_id` ASC, `co_title` ASC, `co_plan_page_reference` ASC, `co_statement` ASC, `co_revised_project_completion_date` ASC
		$arrValues = array($co_creator_contact_company_office_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrChangeOrderDraftsByCoCreatorContactCompanyOfficeId = array();
		while ($row = $db->fetch()) {
			$change_order_draft_id = $row['id'];
			$changeOrderDraft = self::instantiateOrm($database, 'ChangeOrderDraft', $row, null, $change_order_draft_id);
			/* @var $changeOrderDraft ChangeOrderDraft */
			$arrChangeOrderDraftsByCoCreatorContactCompanyOfficeId[$change_order_draft_id] = $changeOrderDraft;
		}

		$db->free_result();

		self::$_arrChangeOrderDraftsByCoCreatorContactCompanyOfficeId = $arrChangeOrderDraftsByCoCreatorContactCompanyOfficeId;

		return $arrChangeOrderDraftsByCoCreatorContactCompanyOfficeId;
	}

	/**
	 * Load by constraint `change_order_drafts_fk_creator_phone_ccopn` foreign key (`co_creator_phone_contact_company_office_phone_number_id`) references `contact_company_office_phone_numbers` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $co_creator_phone_contact_company_office_phone_number_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadChangeOrderDraftsByCoCreatorPhoneContactCompanyOfficePhoneNumberId($database, $co_creator_phone_contact_company_office_phone_number_id, Input $options=null)
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
			self::$_arrChangeOrderDraftsByCoCreatorPhoneContactCompanyOfficePhoneNumberId = null;
		}

		$arrChangeOrderDraftsByCoCreatorPhoneContactCompanyOfficePhoneNumberId = self::$_arrChangeOrderDraftsByCoCreatorPhoneContactCompanyOfficePhoneNumberId;
		if (isset($arrChangeOrderDraftsByCoCreatorPhoneContactCompanyOfficePhoneNumberId) && !empty($arrChangeOrderDraftsByCoCreatorPhoneContactCompanyOfficePhoneNumberId)) {
			return $arrChangeOrderDraftsByCoCreatorPhoneContactCompanyOfficePhoneNumberId;
		}

		$co_creator_phone_contact_company_office_phone_number_id = (int) $co_creator_phone_contact_company_office_phone_number_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `change_order_type_id` ASC, `change_order_priority_id` ASC, `co_file_manager_file_id` ASC, `co_cost_code_id` ASC, `co_creator_contact_id` ASC, `co_creator_contact_company_office_id` ASC, `co_creator_phone_contact_company_office_phone_number_id` ASC, `co_creator_fax_contact_company_office_phone_number_id` ASC, `co_creator_contact_mobile_phone_number_id` ASC, `co_recipient_contact_id` ASC, `co_recipient_contact_company_office_id` ASC, `co_recipient_phone_contact_company_office_phone_number_id` ASC, `co_recipient_fax_contact_company_office_phone_number_id` ASC, `co_recipient_contact_mobile_phone_number_id` ASC, `co_initiator_contact_id` ASC, `co_initiator_contact_company_office_id` ASC, `co_initiator_phone_contact_company_office_phone_number_id` ASC, `co_initiator_fax_contact_company_office_phone_number_id` ASC, `co_initiator_contact_mobile_phone_number_id` ASC, `co_title` ASC, `co_plan_page_reference` ASC, `co_statement` ASC, `co_revised_project_completion_date` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpChangeOrderDraft = new ChangeOrderDraft($database);
			$sqlOrderByColumns = $tmpChangeOrderDraft->constructSqlOrderByColumns($arrOrderByAttributes);

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
	cod.*

FROM `change_order_drafts` cod
WHERE cod.`co_creator_phone_contact_company_office_phone_number_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `change_order_type_id` ASC, `change_order_priority_id` ASC, `co_file_manager_file_id` ASC, `co_cost_code_id` ASC, `co_creator_contact_id` ASC, `co_creator_contact_company_office_id` ASC, `co_creator_phone_contact_company_office_phone_number_id` ASC, `co_creator_fax_contact_company_office_phone_number_id` ASC, `co_creator_contact_mobile_phone_number_id` ASC, `co_recipient_contact_id` ASC, `co_recipient_contact_company_office_id` ASC, `co_recipient_phone_contact_company_office_phone_number_id` ASC, `co_recipient_fax_contact_company_office_phone_number_id` ASC, `co_recipient_contact_mobile_phone_number_id` ASC, `co_initiator_contact_id` ASC, `co_initiator_contact_company_office_id` ASC, `co_initiator_phone_contact_company_office_phone_number_id` ASC, `co_initiator_fax_contact_company_office_phone_number_id` ASC, `co_initiator_contact_mobile_phone_number_id` ASC, `co_title` ASC, `co_plan_page_reference` ASC, `co_statement` ASC, `co_revised_project_completion_date` ASC
		$arrValues = array($co_creator_phone_contact_company_office_phone_number_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrChangeOrderDraftsByCoCreatorPhoneContactCompanyOfficePhoneNumberId = array();
		while ($row = $db->fetch()) {
			$change_order_draft_id = $row['id'];
			$changeOrderDraft = self::instantiateOrm($database, 'ChangeOrderDraft', $row, null, $change_order_draft_id);
			/* @var $changeOrderDraft ChangeOrderDraft */
			$arrChangeOrderDraftsByCoCreatorPhoneContactCompanyOfficePhoneNumberId[$change_order_draft_id] = $changeOrderDraft;
		}

		$db->free_result();

		self::$_arrChangeOrderDraftsByCoCreatorPhoneContactCompanyOfficePhoneNumberId = $arrChangeOrderDraftsByCoCreatorPhoneContactCompanyOfficePhoneNumberId;

		return $arrChangeOrderDraftsByCoCreatorPhoneContactCompanyOfficePhoneNumberId;
	}

	/**
	 * Load by constraint `change_order_drafts_fk_creator_fax_ccopn` foreign key (`co_creator_fax_contact_company_office_phone_number_id`) references `contact_company_office_phone_numbers` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $co_creator_fax_contact_company_office_phone_number_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadChangeOrderDraftsByCoCreatorFaxContactCompanyOfficePhoneNumberId($database, $co_creator_fax_contact_company_office_phone_number_id, Input $options=null)
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
			self::$_arrChangeOrderDraftsByCoCreatorFaxContactCompanyOfficePhoneNumberId = null;
		}

		$arrChangeOrderDraftsByCoCreatorFaxContactCompanyOfficePhoneNumberId = self::$_arrChangeOrderDraftsByCoCreatorFaxContactCompanyOfficePhoneNumberId;
		if (isset($arrChangeOrderDraftsByCoCreatorFaxContactCompanyOfficePhoneNumberId) && !empty($arrChangeOrderDraftsByCoCreatorFaxContactCompanyOfficePhoneNumberId)) {
			return $arrChangeOrderDraftsByCoCreatorFaxContactCompanyOfficePhoneNumberId;
		}

		$co_creator_fax_contact_company_office_phone_number_id = (int) $co_creator_fax_contact_company_office_phone_number_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `change_order_type_id` ASC, `change_order_priority_id` ASC, `co_file_manager_file_id` ASC, `co_cost_code_id` ASC, `co_creator_contact_id` ASC, `co_creator_contact_company_office_id` ASC, `co_creator_phone_contact_company_office_phone_number_id` ASC, `co_creator_fax_contact_company_office_phone_number_id` ASC, `co_creator_contact_mobile_phone_number_id` ASC, `co_recipient_contact_id` ASC, `co_recipient_contact_company_office_id` ASC, `co_recipient_phone_contact_company_office_phone_number_id` ASC, `co_recipient_fax_contact_company_office_phone_number_id` ASC, `co_recipient_contact_mobile_phone_number_id` ASC, `co_initiator_contact_id` ASC, `co_initiator_contact_company_office_id` ASC, `co_initiator_phone_contact_company_office_phone_number_id` ASC, `co_initiator_fax_contact_company_office_phone_number_id` ASC, `co_initiator_contact_mobile_phone_number_id` ASC, `co_title` ASC, `co_plan_page_reference` ASC, `co_statement` ASC, `co_revised_project_completion_date` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpChangeOrderDraft = new ChangeOrderDraft($database);
			$sqlOrderByColumns = $tmpChangeOrderDraft->constructSqlOrderByColumns($arrOrderByAttributes);

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
	cod.*

FROM `change_order_drafts` cod
WHERE cod.`co_creator_fax_contact_company_office_phone_number_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `change_order_type_id` ASC, `change_order_priority_id` ASC, `co_file_manager_file_id` ASC, `co_cost_code_id` ASC, `co_creator_contact_id` ASC, `co_creator_contact_company_office_id` ASC, `co_creator_phone_contact_company_office_phone_number_id` ASC, `co_creator_fax_contact_company_office_phone_number_id` ASC, `co_creator_contact_mobile_phone_number_id` ASC, `co_recipient_contact_id` ASC, `co_recipient_contact_company_office_id` ASC, `co_recipient_phone_contact_company_office_phone_number_id` ASC, `co_recipient_fax_contact_company_office_phone_number_id` ASC, `co_recipient_contact_mobile_phone_number_id` ASC, `co_initiator_contact_id` ASC, `co_initiator_contact_company_office_id` ASC, `co_initiator_phone_contact_company_office_phone_number_id` ASC, `co_initiator_fax_contact_company_office_phone_number_id` ASC, `co_initiator_contact_mobile_phone_number_id` ASC, `co_title` ASC, `co_plan_page_reference` ASC, `co_statement` ASC, `co_revised_project_completion_date` ASC
		$arrValues = array($co_creator_fax_contact_company_office_phone_number_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrChangeOrderDraftsByCoCreatorFaxContactCompanyOfficePhoneNumberId = array();
		while ($row = $db->fetch()) {
			$change_order_draft_id = $row['id'];
			$changeOrderDraft = self::instantiateOrm($database, 'ChangeOrderDraft', $row, null, $change_order_draft_id);
			/* @var $changeOrderDraft ChangeOrderDraft */
			$arrChangeOrderDraftsByCoCreatorFaxContactCompanyOfficePhoneNumberId[$change_order_draft_id] = $changeOrderDraft;
		}

		$db->free_result();

		self::$_arrChangeOrderDraftsByCoCreatorFaxContactCompanyOfficePhoneNumberId = $arrChangeOrderDraftsByCoCreatorFaxContactCompanyOfficePhoneNumberId;

		return $arrChangeOrderDraftsByCoCreatorFaxContactCompanyOfficePhoneNumberId;
	}

	/**
	 * Load by constraint `change_order_drafts_fk_creator_c_mobile_cpn` foreign key (`co_creator_contact_mobile_phone_number_id`) references `contact_phone_numbers` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $co_creator_contact_mobile_phone_number_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadChangeOrderDraftsByCoCreatorContactMobilePhoneNumberId($database, $co_creator_contact_mobile_phone_number_id, Input $options=null)
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
			self::$_arrChangeOrderDraftsByCoCreatorContactMobilePhoneNumberId = null;
		}

		$arrChangeOrderDraftsByCoCreatorContactMobilePhoneNumberId = self::$_arrChangeOrderDraftsByCoCreatorContactMobilePhoneNumberId;
		if (isset($arrChangeOrderDraftsByCoCreatorContactMobilePhoneNumberId) && !empty($arrChangeOrderDraftsByCoCreatorContactMobilePhoneNumberId)) {
			return $arrChangeOrderDraftsByCoCreatorContactMobilePhoneNumberId;
		}

		$co_creator_contact_mobile_phone_number_id = (int) $co_creator_contact_mobile_phone_number_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `change_order_type_id` ASC, `change_order_priority_id` ASC, `co_file_manager_file_id` ASC, `co_cost_code_id` ASC, `co_creator_contact_id` ASC, `co_creator_contact_company_office_id` ASC, `co_creator_phone_contact_company_office_phone_number_id` ASC, `co_creator_fax_contact_company_office_phone_number_id` ASC, `co_creator_contact_mobile_phone_number_id` ASC, `co_recipient_contact_id` ASC, `co_recipient_contact_company_office_id` ASC, `co_recipient_phone_contact_company_office_phone_number_id` ASC, `co_recipient_fax_contact_company_office_phone_number_id` ASC, `co_recipient_contact_mobile_phone_number_id` ASC, `co_initiator_contact_id` ASC, `co_initiator_contact_company_office_id` ASC, `co_initiator_phone_contact_company_office_phone_number_id` ASC, `co_initiator_fax_contact_company_office_phone_number_id` ASC, `co_initiator_contact_mobile_phone_number_id` ASC, `co_title` ASC, `co_plan_page_reference` ASC, `co_statement` ASC, `co_revised_project_completion_date` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpChangeOrderDraft = new ChangeOrderDraft($database);
			$sqlOrderByColumns = $tmpChangeOrderDraft->constructSqlOrderByColumns($arrOrderByAttributes);

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
	cod.*

FROM `change_order_drafts` cod
WHERE cod.`co_creator_contact_mobile_phone_number_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `change_order_type_id` ASC, `change_order_priority_id` ASC, `co_file_manager_file_id` ASC, `co_cost_code_id` ASC, `co_creator_contact_id` ASC, `co_creator_contact_company_office_id` ASC, `co_creator_phone_contact_company_office_phone_number_id` ASC, `co_creator_fax_contact_company_office_phone_number_id` ASC, `co_creator_contact_mobile_phone_number_id` ASC, `co_recipient_contact_id` ASC, `co_recipient_contact_company_office_id` ASC, `co_recipient_phone_contact_company_office_phone_number_id` ASC, `co_recipient_fax_contact_company_office_phone_number_id` ASC, `co_recipient_contact_mobile_phone_number_id` ASC, `co_initiator_contact_id` ASC, `co_initiator_contact_company_office_id` ASC, `co_initiator_phone_contact_company_office_phone_number_id` ASC, `co_initiator_fax_contact_company_office_phone_number_id` ASC, `co_initiator_contact_mobile_phone_number_id` ASC, `co_title` ASC, `co_plan_page_reference` ASC, `co_statement` ASC, `co_revised_project_completion_date` ASC
		$arrValues = array($co_creator_contact_mobile_phone_number_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrChangeOrderDraftsByCoCreatorContactMobilePhoneNumberId = array();
		while ($row = $db->fetch()) {
			$change_order_draft_id = $row['id'];
			$changeOrderDraft = self::instantiateOrm($database, 'ChangeOrderDraft', $row, null, $change_order_draft_id);
			/* @var $changeOrderDraft ChangeOrderDraft */
			$arrChangeOrderDraftsByCoCreatorContactMobilePhoneNumberId[$change_order_draft_id] = $changeOrderDraft;
		}

		$db->free_result();

		self::$_arrChangeOrderDraftsByCoCreatorContactMobilePhoneNumberId = $arrChangeOrderDraftsByCoCreatorContactMobilePhoneNumberId;

		return $arrChangeOrderDraftsByCoCreatorContactMobilePhoneNumberId;
	}

	/**
	 * Load by constraint `change_order_drafts_fk_recipient_c` foreign key (`co_recipient_contact_id`) references `contacts` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $co_recipient_contact_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadChangeOrderDraftsByCoRecipientContactId($database, $co_recipient_contact_id, Input $options=null)
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
			self::$_arrChangeOrderDraftsByCoRecipientContactId = null;
		}

		$arrChangeOrderDraftsByCoRecipientContactId = self::$_arrChangeOrderDraftsByCoRecipientContactId;
		if (isset($arrChangeOrderDraftsByCoRecipientContactId) && !empty($arrChangeOrderDraftsByCoRecipientContactId)) {
			return $arrChangeOrderDraftsByCoRecipientContactId;
		}

		$co_recipient_contact_id = (int) $co_recipient_contact_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `change_order_type_id` ASC, `change_order_priority_id` ASC, `co_file_manager_file_id` ASC, `co_cost_code_id` ASC, `co_creator_contact_id` ASC, `co_creator_contact_company_office_id` ASC, `co_creator_phone_contact_company_office_phone_number_id` ASC, `co_creator_fax_contact_company_office_phone_number_id` ASC, `co_creator_contact_mobile_phone_number_id` ASC, `co_recipient_contact_id` ASC, `co_recipient_contact_company_office_id` ASC, `co_recipient_phone_contact_company_office_phone_number_id` ASC, `co_recipient_fax_contact_company_office_phone_number_id` ASC, `co_recipient_contact_mobile_phone_number_id` ASC, `co_initiator_contact_id` ASC, `co_initiator_contact_company_office_id` ASC, `co_initiator_phone_contact_company_office_phone_number_id` ASC, `co_initiator_fax_contact_company_office_phone_number_id` ASC, `co_initiator_contact_mobile_phone_number_id` ASC, `co_title` ASC, `co_plan_page_reference` ASC, `co_statement` ASC, `co_revised_project_completion_date` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpChangeOrderDraft = new ChangeOrderDraft($database);
			$sqlOrderByColumns = $tmpChangeOrderDraft->constructSqlOrderByColumns($arrOrderByAttributes);

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
	cod.*

FROM `change_order_drafts` cod
WHERE cod.`co_recipient_contact_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `change_order_type_id` ASC, `change_order_priority_id` ASC, `co_file_manager_file_id` ASC, `co_cost_code_id` ASC, `co_creator_contact_id` ASC, `co_creator_contact_company_office_id` ASC, `co_creator_phone_contact_company_office_phone_number_id` ASC, `co_creator_fax_contact_company_office_phone_number_id` ASC, `co_creator_contact_mobile_phone_number_id` ASC, `co_recipient_contact_id` ASC, `co_recipient_contact_company_office_id` ASC, `co_recipient_phone_contact_company_office_phone_number_id` ASC, `co_recipient_fax_contact_company_office_phone_number_id` ASC, `co_recipient_contact_mobile_phone_number_id` ASC, `co_initiator_contact_id` ASC, `co_initiator_contact_company_office_id` ASC, `co_initiator_phone_contact_company_office_phone_number_id` ASC, `co_initiator_fax_contact_company_office_phone_number_id` ASC, `co_initiator_contact_mobile_phone_number_id` ASC, `co_title` ASC, `co_plan_page_reference` ASC, `co_statement` ASC, `co_revised_project_completion_date` ASC
		$arrValues = array($co_recipient_contact_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrChangeOrderDraftsByCoRecipientContactId = array();
		while ($row = $db->fetch()) {
			$change_order_draft_id = $row['id'];
			$changeOrderDraft = self::instantiateOrm($database, 'ChangeOrderDraft', $row, null, $change_order_draft_id);
			/* @var $changeOrderDraft ChangeOrderDraft */
			$arrChangeOrderDraftsByCoRecipientContactId[$change_order_draft_id] = $changeOrderDraft;
		}

		$db->free_result();

		self::$_arrChangeOrderDraftsByCoRecipientContactId = $arrChangeOrderDraftsByCoRecipientContactId;

		return $arrChangeOrderDraftsByCoRecipientContactId;
	}

	/**
	 * Load by constraint `change_order_drafts_fk_recipient_cco` foreign key (`co_recipient_contact_company_office_id`) references `contact_company_offices` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $co_recipient_contact_company_office_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadChangeOrderDraftsByCoRecipientContactCompanyOfficeId($database, $co_recipient_contact_company_office_id, Input $options=null)
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
			self::$_arrChangeOrderDraftsByCoRecipientContactCompanyOfficeId = null;
		}

		$arrChangeOrderDraftsByCoRecipientContactCompanyOfficeId = self::$_arrChangeOrderDraftsByCoRecipientContactCompanyOfficeId;
		if (isset($arrChangeOrderDraftsByCoRecipientContactCompanyOfficeId) && !empty($arrChangeOrderDraftsByCoRecipientContactCompanyOfficeId)) {
			return $arrChangeOrderDraftsByCoRecipientContactCompanyOfficeId;
		}

		$co_recipient_contact_company_office_id = (int) $co_recipient_contact_company_office_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `change_order_type_id` ASC, `change_order_priority_id` ASC, `co_file_manager_file_id` ASC, `co_cost_code_id` ASC, `co_creator_contact_id` ASC, `co_creator_contact_company_office_id` ASC, `co_creator_phone_contact_company_office_phone_number_id` ASC, `co_creator_fax_contact_company_office_phone_number_id` ASC, `co_creator_contact_mobile_phone_number_id` ASC, `co_recipient_contact_id` ASC, `co_recipient_contact_company_office_id` ASC, `co_recipient_phone_contact_company_office_phone_number_id` ASC, `co_recipient_fax_contact_company_office_phone_number_id` ASC, `co_recipient_contact_mobile_phone_number_id` ASC, `co_initiator_contact_id` ASC, `co_initiator_contact_company_office_id` ASC, `co_initiator_phone_contact_company_office_phone_number_id` ASC, `co_initiator_fax_contact_company_office_phone_number_id` ASC, `co_initiator_contact_mobile_phone_number_id` ASC, `co_title` ASC, `co_plan_page_reference` ASC, `co_statement` ASC, `co_revised_project_completion_date` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpChangeOrderDraft = new ChangeOrderDraft($database);
			$sqlOrderByColumns = $tmpChangeOrderDraft->constructSqlOrderByColumns($arrOrderByAttributes);

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
	cod.*

FROM `change_order_drafts` cod
WHERE cod.`co_recipient_contact_company_office_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `change_order_type_id` ASC, `change_order_priority_id` ASC, `co_file_manager_file_id` ASC, `co_cost_code_id` ASC, `co_creator_contact_id` ASC, `co_creator_contact_company_office_id` ASC, `co_creator_phone_contact_company_office_phone_number_id` ASC, `co_creator_fax_contact_company_office_phone_number_id` ASC, `co_creator_contact_mobile_phone_number_id` ASC, `co_recipient_contact_id` ASC, `co_recipient_contact_company_office_id` ASC, `co_recipient_phone_contact_company_office_phone_number_id` ASC, `co_recipient_fax_contact_company_office_phone_number_id` ASC, `co_recipient_contact_mobile_phone_number_id` ASC, `co_initiator_contact_id` ASC, `co_initiator_contact_company_office_id` ASC, `co_initiator_phone_contact_company_office_phone_number_id` ASC, `co_initiator_fax_contact_company_office_phone_number_id` ASC, `co_initiator_contact_mobile_phone_number_id` ASC, `co_title` ASC, `co_plan_page_reference` ASC, `co_statement` ASC, `co_revised_project_completion_date` ASC
		$arrValues = array($co_recipient_contact_company_office_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrChangeOrderDraftsByCoRecipientContactCompanyOfficeId = array();
		while ($row = $db->fetch()) {
			$change_order_draft_id = $row['id'];
			$changeOrderDraft = self::instantiateOrm($database, 'ChangeOrderDraft', $row, null, $change_order_draft_id);
			/* @var $changeOrderDraft ChangeOrderDraft */
			$arrChangeOrderDraftsByCoRecipientContactCompanyOfficeId[$change_order_draft_id] = $changeOrderDraft;
		}

		$db->free_result();

		self::$_arrChangeOrderDraftsByCoRecipientContactCompanyOfficeId = $arrChangeOrderDraftsByCoRecipientContactCompanyOfficeId;

		return $arrChangeOrderDraftsByCoRecipientContactCompanyOfficeId;
	}

	/**
	 * Load by constraint `change_order_drafts_fk_recipient_phone_ccopn` foreign key (`co_recipient_phone_contact_company_office_phone_number_id`) references `contact_company_office_phone_numbers` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $co_recipient_phone_contact_company_office_phone_number_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadChangeOrderDraftsByCoRecipientPhoneContactCompanyOfficePhoneNumberId($database, $co_recipient_phone_contact_company_office_phone_number_id, Input $options=null)
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
			self::$_arrChangeOrderDraftsByCoRecipientPhoneContactCompanyOfficePhoneNumberId = null;
		}

		$arrChangeOrderDraftsByCoRecipientPhoneContactCompanyOfficePhoneNumberId = self::$_arrChangeOrderDraftsByCoRecipientPhoneContactCompanyOfficePhoneNumberId;
		if (isset($arrChangeOrderDraftsByCoRecipientPhoneContactCompanyOfficePhoneNumberId) && !empty($arrChangeOrderDraftsByCoRecipientPhoneContactCompanyOfficePhoneNumberId)) {
			return $arrChangeOrderDraftsByCoRecipientPhoneContactCompanyOfficePhoneNumberId;
		}

		$co_recipient_phone_contact_company_office_phone_number_id = (int) $co_recipient_phone_contact_company_office_phone_number_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `change_order_type_id` ASC, `change_order_priority_id` ASC, `co_file_manager_file_id` ASC, `co_cost_code_id` ASC, `co_creator_contact_id` ASC, `co_creator_contact_company_office_id` ASC, `co_creator_phone_contact_company_office_phone_number_id` ASC, `co_creator_fax_contact_company_office_phone_number_id` ASC, `co_creator_contact_mobile_phone_number_id` ASC, `co_recipient_contact_id` ASC, `co_recipient_contact_company_office_id` ASC, `co_recipient_phone_contact_company_office_phone_number_id` ASC, `co_recipient_fax_contact_company_office_phone_number_id` ASC, `co_recipient_contact_mobile_phone_number_id` ASC, `co_initiator_contact_id` ASC, `co_initiator_contact_company_office_id` ASC, `co_initiator_phone_contact_company_office_phone_number_id` ASC, `co_initiator_fax_contact_company_office_phone_number_id` ASC, `co_initiator_contact_mobile_phone_number_id` ASC, `co_title` ASC, `co_plan_page_reference` ASC, `co_statement` ASC, `co_revised_project_completion_date` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpChangeOrderDraft = new ChangeOrderDraft($database);
			$sqlOrderByColumns = $tmpChangeOrderDraft->constructSqlOrderByColumns($arrOrderByAttributes);

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
	cod.*

FROM `change_order_drafts` cod
WHERE cod.`co_recipient_phone_contact_company_office_phone_number_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `change_order_type_id` ASC, `change_order_priority_id` ASC, `co_file_manager_file_id` ASC, `co_cost_code_id` ASC, `co_creator_contact_id` ASC, `co_creator_contact_company_office_id` ASC, `co_creator_phone_contact_company_office_phone_number_id` ASC, `co_creator_fax_contact_company_office_phone_number_id` ASC, `co_creator_contact_mobile_phone_number_id` ASC, `co_recipient_contact_id` ASC, `co_recipient_contact_company_office_id` ASC, `co_recipient_phone_contact_company_office_phone_number_id` ASC, `co_recipient_fax_contact_company_office_phone_number_id` ASC, `co_recipient_contact_mobile_phone_number_id` ASC, `co_initiator_contact_id` ASC, `co_initiator_contact_company_office_id` ASC, `co_initiator_phone_contact_company_office_phone_number_id` ASC, `co_initiator_fax_contact_company_office_phone_number_id` ASC, `co_initiator_contact_mobile_phone_number_id` ASC, `co_title` ASC, `co_plan_page_reference` ASC, `co_statement` ASC, `co_revised_project_completion_date` ASC
		$arrValues = array($co_recipient_phone_contact_company_office_phone_number_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrChangeOrderDraftsByCoRecipientPhoneContactCompanyOfficePhoneNumberId = array();
		while ($row = $db->fetch()) {
			$change_order_draft_id = $row['id'];
			$changeOrderDraft = self::instantiateOrm($database, 'ChangeOrderDraft', $row, null, $change_order_draft_id);
			/* @var $changeOrderDraft ChangeOrderDraft */
			$arrChangeOrderDraftsByCoRecipientPhoneContactCompanyOfficePhoneNumberId[$change_order_draft_id] = $changeOrderDraft;
		}

		$db->free_result();

		self::$_arrChangeOrderDraftsByCoRecipientPhoneContactCompanyOfficePhoneNumberId = $arrChangeOrderDraftsByCoRecipientPhoneContactCompanyOfficePhoneNumberId;

		return $arrChangeOrderDraftsByCoRecipientPhoneContactCompanyOfficePhoneNumberId;
	}

	/**
	 * Load by constraint `change_order_drafts_fk_recipient_fax_ccopn` foreign key (`co_recipient_fax_contact_company_office_phone_number_id`) references `contact_company_office_phone_numbers` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $co_recipient_fax_contact_company_office_phone_number_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadChangeOrderDraftsByCoRecipientFaxContactCompanyOfficePhoneNumberId($database, $co_recipient_fax_contact_company_office_phone_number_id, Input $options=null)
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
			self::$_arrChangeOrderDraftsByCoRecipientFaxContactCompanyOfficePhoneNumberId = null;
		}

		$arrChangeOrderDraftsByCoRecipientFaxContactCompanyOfficePhoneNumberId = self::$_arrChangeOrderDraftsByCoRecipientFaxContactCompanyOfficePhoneNumberId;
		if (isset($arrChangeOrderDraftsByCoRecipientFaxContactCompanyOfficePhoneNumberId) && !empty($arrChangeOrderDraftsByCoRecipientFaxContactCompanyOfficePhoneNumberId)) {
			return $arrChangeOrderDraftsByCoRecipientFaxContactCompanyOfficePhoneNumberId;
		}

		$co_recipient_fax_contact_company_office_phone_number_id = (int) $co_recipient_fax_contact_company_office_phone_number_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `change_order_type_id` ASC, `change_order_priority_id` ASC, `co_file_manager_file_id` ASC, `co_cost_code_id` ASC, `co_creator_contact_id` ASC, `co_creator_contact_company_office_id` ASC, `co_creator_phone_contact_company_office_phone_number_id` ASC, `co_creator_fax_contact_company_office_phone_number_id` ASC, `co_creator_contact_mobile_phone_number_id` ASC, `co_recipient_contact_id` ASC, `co_recipient_contact_company_office_id` ASC, `co_recipient_phone_contact_company_office_phone_number_id` ASC, `co_recipient_fax_contact_company_office_phone_number_id` ASC, `co_recipient_contact_mobile_phone_number_id` ASC, `co_initiator_contact_id` ASC, `co_initiator_contact_company_office_id` ASC, `co_initiator_phone_contact_company_office_phone_number_id` ASC, `co_initiator_fax_contact_company_office_phone_number_id` ASC, `co_initiator_contact_mobile_phone_number_id` ASC, `co_title` ASC, `co_plan_page_reference` ASC, `co_statement` ASC, `co_revised_project_completion_date` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpChangeOrderDraft = new ChangeOrderDraft($database);
			$sqlOrderByColumns = $tmpChangeOrderDraft->constructSqlOrderByColumns($arrOrderByAttributes);

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
	cod.*

FROM `change_order_drafts` cod
WHERE cod.`co_recipient_fax_contact_company_office_phone_number_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `change_order_type_id` ASC, `change_order_priority_id` ASC, `co_file_manager_file_id` ASC, `co_cost_code_id` ASC, `co_creator_contact_id` ASC, `co_creator_contact_company_office_id` ASC, `co_creator_phone_contact_company_office_phone_number_id` ASC, `co_creator_fax_contact_company_office_phone_number_id` ASC, `co_creator_contact_mobile_phone_number_id` ASC, `co_recipient_contact_id` ASC, `co_recipient_contact_company_office_id` ASC, `co_recipient_phone_contact_company_office_phone_number_id` ASC, `co_recipient_fax_contact_company_office_phone_number_id` ASC, `co_recipient_contact_mobile_phone_number_id` ASC, `co_initiator_contact_id` ASC, `co_initiator_contact_company_office_id` ASC, `co_initiator_phone_contact_company_office_phone_number_id` ASC, `co_initiator_fax_contact_company_office_phone_number_id` ASC, `co_initiator_contact_mobile_phone_number_id` ASC, `co_title` ASC, `co_plan_page_reference` ASC, `co_statement` ASC, `co_revised_project_completion_date` ASC
		$arrValues = array($co_recipient_fax_contact_company_office_phone_number_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrChangeOrderDraftsByCoRecipientFaxContactCompanyOfficePhoneNumberId = array();
		while ($row = $db->fetch()) {
			$change_order_draft_id = $row['id'];
			$changeOrderDraft = self::instantiateOrm($database, 'ChangeOrderDraft', $row, null, $change_order_draft_id);
			/* @var $changeOrderDraft ChangeOrderDraft */
			$arrChangeOrderDraftsByCoRecipientFaxContactCompanyOfficePhoneNumberId[$change_order_draft_id] = $changeOrderDraft;
		}

		$db->free_result();

		self::$_arrChangeOrderDraftsByCoRecipientFaxContactCompanyOfficePhoneNumberId = $arrChangeOrderDraftsByCoRecipientFaxContactCompanyOfficePhoneNumberId;

		return $arrChangeOrderDraftsByCoRecipientFaxContactCompanyOfficePhoneNumberId;
	}

	/**
	 * Load by constraint `change_order_drafts_fk_recipient_c_mobile_cpn` foreign key (`co_recipient_contact_mobile_phone_number_id`) references `contact_phone_numbers` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $co_recipient_contact_mobile_phone_number_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadChangeOrderDraftsByCoRecipientContactMobilePhoneNumberId($database, $co_recipient_contact_mobile_phone_number_id, Input $options=null)
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
			self::$_arrChangeOrderDraftsByCoRecipientContactMobilePhoneNumberId = null;
		}

		$arrChangeOrderDraftsByCoRecipientContactMobilePhoneNumberId = self::$_arrChangeOrderDraftsByCoRecipientContactMobilePhoneNumberId;
		if (isset($arrChangeOrderDraftsByCoRecipientContactMobilePhoneNumberId) && !empty($arrChangeOrderDraftsByCoRecipientContactMobilePhoneNumberId)) {
			return $arrChangeOrderDraftsByCoRecipientContactMobilePhoneNumberId;
		}

		$co_recipient_contact_mobile_phone_number_id = (int) $co_recipient_contact_mobile_phone_number_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `change_order_type_id` ASC, `change_order_priority_id` ASC, `co_file_manager_file_id` ASC, `co_cost_code_id` ASC, `co_creator_contact_id` ASC, `co_creator_contact_company_office_id` ASC, `co_creator_phone_contact_company_office_phone_number_id` ASC, `co_creator_fax_contact_company_office_phone_number_id` ASC, `co_creator_contact_mobile_phone_number_id` ASC, `co_recipient_contact_id` ASC, `co_recipient_contact_company_office_id` ASC, `co_recipient_phone_contact_company_office_phone_number_id` ASC, `co_recipient_fax_contact_company_office_phone_number_id` ASC, `co_recipient_contact_mobile_phone_number_id` ASC, `co_initiator_contact_id` ASC, `co_initiator_contact_company_office_id` ASC, `co_initiator_phone_contact_company_office_phone_number_id` ASC, `co_initiator_fax_contact_company_office_phone_number_id` ASC, `co_initiator_contact_mobile_phone_number_id` ASC, `co_title` ASC, `co_plan_page_reference` ASC, `co_statement` ASC, `co_revised_project_completion_date` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpChangeOrderDraft = new ChangeOrderDraft($database);
			$sqlOrderByColumns = $tmpChangeOrderDraft->constructSqlOrderByColumns($arrOrderByAttributes);

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
	cod.*

FROM `change_order_drafts` cod
WHERE cod.`co_recipient_contact_mobile_phone_number_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `change_order_type_id` ASC, `change_order_priority_id` ASC, `co_file_manager_file_id` ASC, `co_cost_code_id` ASC, `co_creator_contact_id` ASC, `co_creator_contact_company_office_id` ASC, `co_creator_phone_contact_company_office_phone_number_id` ASC, `co_creator_fax_contact_company_office_phone_number_id` ASC, `co_creator_contact_mobile_phone_number_id` ASC, `co_recipient_contact_id` ASC, `co_recipient_contact_company_office_id` ASC, `co_recipient_phone_contact_company_office_phone_number_id` ASC, `co_recipient_fax_contact_company_office_phone_number_id` ASC, `co_recipient_contact_mobile_phone_number_id` ASC, `co_initiator_contact_id` ASC, `co_initiator_contact_company_office_id` ASC, `co_initiator_phone_contact_company_office_phone_number_id` ASC, `co_initiator_fax_contact_company_office_phone_number_id` ASC, `co_initiator_contact_mobile_phone_number_id` ASC, `co_title` ASC, `co_plan_page_reference` ASC, `co_statement` ASC, `co_revised_project_completion_date` ASC
		$arrValues = array($co_recipient_contact_mobile_phone_number_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrChangeOrderDraftsByCoRecipientContactMobilePhoneNumberId = array();
		while ($row = $db->fetch()) {
			$change_order_draft_id = $row['id'];
			$changeOrderDraft = self::instantiateOrm($database, 'ChangeOrderDraft', $row, null, $change_order_draft_id);
			/* @var $changeOrderDraft ChangeOrderDraft */
			$arrChangeOrderDraftsByCoRecipientContactMobilePhoneNumberId[$change_order_draft_id] = $changeOrderDraft;
		}

		$db->free_result();

		self::$_arrChangeOrderDraftsByCoRecipientContactMobilePhoneNumberId = $arrChangeOrderDraftsByCoRecipientContactMobilePhoneNumberId;

		return $arrChangeOrderDraftsByCoRecipientContactMobilePhoneNumberId;
	}

	/**
	 * Load by constraint `change_order_drafts_fk_initiator_c` foreign key (`co_initiator_contact_id`) references `contacts` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $co_initiator_contact_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadChangeOrderDraftsByCoInitiatorContactId($database, $co_initiator_contact_id, Input $options=null)
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
			self::$_arrChangeOrderDraftsByCoInitiatorContactId = null;
		}

		$arrChangeOrderDraftsByCoInitiatorContactId = self::$_arrChangeOrderDraftsByCoInitiatorContactId;
		if (isset($arrChangeOrderDraftsByCoInitiatorContactId) && !empty($arrChangeOrderDraftsByCoInitiatorContactId)) {
			return $arrChangeOrderDraftsByCoInitiatorContactId;
		}

		$co_initiator_contact_id = (int) $co_initiator_contact_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `change_order_type_id` ASC, `change_order_priority_id` ASC, `co_file_manager_file_id` ASC, `co_cost_code_id` ASC, `co_creator_contact_id` ASC, `co_creator_contact_company_office_id` ASC, `co_creator_phone_contact_company_office_phone_number_id` ASC, `co_creator_fax_contact_company_office_phone_number_id` ASC, `co_creator_contact_mobile_phone_number_id` ASC, `co_recipient_contact_id` ASC, `co_recipient_contact_company_office_id` ASC, `co_recipient_phone_contact_company_office_phone_number_id` ASC, `co_recipient_fax_contact_company_office_phone_number_id` ASC, `co_recipient_contact_mobile_phone_number_id` ASC, `co_initiator_contact_id` ASC, `co_initiator_contact_company_office_id` ASC, `co_initiator_phone_contact_company_office_phone_number_id` ASC, `co_initiator_fax_contact_company_office_phone_number_id` ASC, `co_initiator_contact_mobile_phone_number_id` ASC, `co_title` ASC, `co_plan_page_reference` ASC, `co_statement` ASC, `co_revised_project_completion_date` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpChangeOrderDraft = new ChangeOrderDraft($database);
			$sqlOrderByColumns = $tmpChangeOrderDraft->constructSqlOrderByColumns($arrOrderByAttributes);

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
	cod.*

FROM `change_order_drafts` cod
WHERE cod.`co_initiator_contact_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `change_order_type_id` ASC, `change_order_priority_id` ASC, `co_file_manager_file_id` ASC, `co_cost_code_id` ASC, `co_creator_contact_id` ASC, `co_creator_contact_company_office_id` ASC, `co_creator_phone_contact_company_office_phone_number_id` ASC, `co_creator_fax_contact_company_office_phone_number_id` ASC, `co_creator_contact_mobile_phone_number_id` ASC, `co_recipient_contact_id` ASC, `co_recipient_contact_company_office_id` ASC, `co_recipient_phone_contact_company_office_phone_number_id` ASC, `co_recipient_fax_contact_company_office_phone_number_id` ASC, `co_recipient_contact_mobile_phone_number_id` ASC, `co_initiator_contact_id` ASC, `co_initiator_contact_company_office_id` ASC, `co_initiator_phone_contact_company_office_phone_number_id` ASC, `co_initiator_fax_contact_company_office_phone_number_id` ASC, `co_initiator_contact_mobile_phone_number_id` ASC, `co_title` ASC, `co_plan_page_reference` ASC, `co_statement` ASC, `co_revised_project_completion_date` ASC
		$arrValues = array($co_initiator_contact_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrChangeOrderDraftsByCoInitiatorContactId = array();
		while ($row = $db->fetch()) {
			$change_order_draft_id = $row['id'];
			$changeOrderDraft = self::instantiateOrm($database, 'ChangeOrderDraft', $row, null, $change_order_draft_id);
			/* @var $changeOrderDraft ChangeOrderDraft */
			$arrChangeOrderDraftsByCoInitiatorContactId[$change_order_draft_id] = $changeOrderDraft;
		}

		$db->free_result();

		self::$_arrChangeOrderDraftsByCoInitiatorContactId = $arrChangeOrderDraftsByCoInitiatorContactId;

		return $arrChangeOrderDraftsByCoInitiatorContactId;
	}

	/**
	 * Load by constraint `change_order_drafts_fk_initiator_cco` foreign key (`co_initiator_contact_company_office_id`) references `contact_company_offices` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $co_initiator_contact_company_office_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadChangeOrderDraftsByCoInitiatorContactCompanyOfficeId($database, $co_initiator_contact_company_office_id, Input $options=null)
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
			self::$_arrChangeOrderDraftsByCoInitiatorContactCompanyOfficeId = null;
		}

		$arrChangeOrderDraftsByCoInitiatorContactCompanyOfficeId = self::$_arrChangeOrderDraftsByCoInitiatorContactCompanyOfficeId;
		if (isset($arrChangeOrderDraftsByCoInitiatorContactCompanyOfficeId) && !empty($arrChangeOrderDraftsByCoInitiatorContactCompanyOfficeId)) {
			return $arrChangeOrderDraftsByCoInitiatorContactCompanyOfficeId;
		}

		$co_initiator_contact_company_office_id = (int) $co_initiator_contact_company_office_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `change_order_type_id` ASC, `change_order_priority_id` ASC, `co_file_manager_file_id` ASC, `co_cost_code_id` ASC, `co_creator_contact_id` ASC, `co_creator_contact_company_office_id` ASC, `co_creator_phone_contact_company_office_phone_number_id` ASC, `co_creator_fax_contact_company_office_phone_number_id` ASC, `co_creator_contact_mobile_phone_number_id` ASC, `co_recipient_contact_id` ASC, `co_recipient_contact_company_office_id` ASC, `co_recipient_phone_contact_company_office_phone_number_id` ASC, `co_recipient_fax_contact_company_office_phone_number_id` ASC, `co_recipient_contact_mobile_phone_number_id` ASC, `co_initiator_contact_id` ASC, `co_initiator_contact_company_office_id` ASC, `co_initiator_phone_contact_company_office_phone_number_id` ASC, `co_initiator_fax_contact_company_office_phone_number_id` ASC, `co_initiator_contact_mobile_phone_number_id` ASC, `co_title` ASC, `co_plan_page_reference` ASC, `co_statement` ASC, `co_revised_project_completion_date` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpChangeOrderDraft = new ChangeOrderDraft($database);
			$sqlOrderByColumns = $tmpChangeOrderDraft->constructSqlOrderByColumns($arrOrderByAttributes);

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
	cod.*

FROM `change_order_drafts` cod
WHERE cod.`co_initiator_contact_company_office_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `change_order_type_id` ASC, `change_order_priority_id` ASC, `co_file_manager_file_id` ASC, `co_cost_code_id` ASC, `co_creator_contact_id` ASC, `co_creator_contact_company_office_id` ASC, `co_creator_phone_contact_company_office_phone_number_id` ASC, `co_creator_fax_contact_company_office_phone_number_id` ASC, `co_creator_contact_mobile_phone_number_id` ASC, `co_recipient_contact_id` ASC, `co_recipient_contact_company_office_id` ASC, `co_recipient_phone_contact_company_office_phone_number_id` ASC, `co_recipient_fax_contact_company_office_phone_number_id` ASC, `co_recipient_contact_mobile_phone_number_id` ASC, `co_initiator_contact_id` ASC, `co_initiator_contact_company_office_id` ASC, `co_initiator_phone_contact_company_office_phone_number_id` ASC, `co_initiator_fax_contact_company_office_phone_number_id` ASC, `co_initiator_contact_mobile_phone_number_id` ASC, `co_title` ASC, `co_plan_page_reference` ASC, `co_statement` ASC, `co_revised_project_completion_date` ASC
		$arrValues = array($co_initiator_contact_company_office_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrChangeOrderDraftsByCoInitiatorContactCompanyOfficeId = array();
		while ($row = $db->fetch()) {
			$change_order_draft_id = $row['id'];
			$changeOrderDraft = self::instantiateOrm($database, 'ChangeOrderDraft', $row, null, $change_order_draft_id);
			/* @var $changeOrderDraft ChangeOrderDraft */
			$arrChangeOrderDraftsByCoInitiatorContactCompanyOfficeId[$change_order_draft_id] = $changeOrderDraft;
		}

		$db->free_result();

		self::$_arrChangeOrderDraftsByCoInitiatorContactCompanyOfficeId = $arrChangeOrderDraftsByCoInitiatorContactCompanyOfficeId;

		return $arrChangeOrderDraftsByCoInitiatorContactCompanyOfficeId;
	}

	/**
	 * Load by constraint `change_order_drafts_fk_initiator_phone_ccopn` foreign key (`co_initiator_phone_contact_company_office_phone_number_id`) references `contact_company_office_phone_numbers` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $co_initiator_phone_contact_company_office_phone_number_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadChangeOrderDraftsByCoInitiatorPhoneContactCompanyOfficePhoneNumberId($database, $co_initiator_phone_contact_company_office_phone_number_id, Input $options=null)
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
			self::$_arrChangeOrderDraftsByCoInitiatorPhoneContactCompanyOfficePhoneNumberId = null;
		}

		$arrChangeOrderDraftsByCoInitiatorPhoneContactCompanyOfficePhoneNumberId = self::$_arrChangeOrderDraftsByCoInitiatorPhoneContactCompanyOfficePhoneNumberId;
		if (isset($arrChangeOrderDraftsByCoInitiatorPhoneContactCompanyOfficePhoneNumberId) && !empty($arrChangeOrderDraftsByCoInitiatorPhoneContactCompanyOfficePhoneNumberId)) {
			return $arrChangeOrderDraftsByCoInitiatorPhoneContactCompanyOfficePhoneNumberId;
		}

		$co_initiator_phone_contact_company_office_phone_number_id = (int) $co_initiator_phone_contact_company_office_phone_number_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `change_order_type_id` ASC, `change_order_priority_id` ASC, `co_file_manager_file_id` ASC, `co_cost_code_id` ASC, `co_creator_contact_id` ASC, `co_creator_contact_company_office_id` ASC, `co_creator_phone_contact_company_office_phone_number_id` ASC, `co_creator_fax_contact_company_office_phone_number_id` ASC, `co_creator_contact_mobile_phone_number_id` ASC, `co_recipient_contact_id` ASC, `co_recipient_contact_company_office_id` ASC, `co_recipient_phone_contact_company_office_phone_number_id` ASC, `co_recipient_fax_contact_company_office_phone_number_id` ASC, `co_recipient_contact_mobile_phone_number_id` ASC, `co_initiator_contact_id` ASC, `co_initiator_contact_company_office_id` ASC, `co_initiator_phone_contact_company_office_phone_number_id` ASC, `co_initiator_fax_contact_company_office_phone_number_id` ASC, `co_initiator_contact_mobile_phone_number_id` ASC, `co_title` ASC, `co_plan_page_reference` ASC, `co_statement` ASC, `co_revised_project_completion_date` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpChangeOrderDraft = new ChangeOrderDraft($database);
			$sqlOrderByColumns = $tmpChangeOrderDraft->constructSqlOrderByColumns($arrOrderByAttributes);

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
	cod.*

FROM `change_order_drafts` cod
WHERE cod.`co_initiator_phone_contact_company_office_phone_number_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `change_order_type_id` ASC, `change_order_priority_id` ASC, `co_file_manager_file_id` ASC, `co_cost_code_id` ASC, `co_creator_contact_id` ASC, `co_creator_contact_company_office_id` ASC, `co_creator_phone_contact_company_office_phone_number_id` ASC, `co_creator_fax_contact_company_office_phone_number_id` ASC, `co_creator_contact_mobile_phone_number_id` ASC, `co_recipient_contact_id` ASC, `co_recipient_contact_company_office_id` ASC, `co_recipient_phone_contact_company_office_phone_number_id` ASC, `co_recipient_fax_contact_company_office_phone_number_id` ASC, `co_recipient_contact_mobile_phone_number_id` ASC, `co_initiator_contact_id` ASC, `co_initiator_contact_company_office_id` ASC, `co_initiator_phone_contact_company_office_phone_number_id` ASC, `co_initiator_fax_contact_company_office_phone_number_id` ASC, `co_initiator_contact_mobile_phone_number_id` ASC, `co_title` ASC, `co_plan_page_reference` ASC, `co_statement` ASC, `co_revised_project_completion_date` ASC
		$arrValues = array($co_initiator_phone_contact_company_office_phone_number_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrChangeOrderDraftsByCoInitiatorPhoneContactCompanyOfficePhoneNumberId = array();
		while ($row = $db->fetch()) {
			$change_order_draft_id = $row['id'];
			$changeOrderDraft = self::instantiateOrm($database, 'ChangeOrderDraft', $row, null, $change_order_draft_id);
			/* @var $changeOrderDraft ChangeOrderDraft */
			$arrChangeOrderDraftsByCoInitiatorPhoneContactCompanyOfficePhoneNumberId[$change_order_draft_id] = $changeOrderDraft;
		}

		$db->free_result();

		self::$_arrChangeOrderDraftsByCoInitiatorPhoneContactCompanyOfficePhoneNumberId = $arrChangeOrderDraftsByCoInitiatorPhoneContactCompanyOfficePhoneNumberId;

		return $arrChangeOrderDraftsByCoInitiatorPhoneContactCompanyOfficePhoneNumberId;
	}

	/**
	 * Load by constraint `change_order_drafts_fk_initiator_fax_ccopn` foreign key (`co_initiator_fax_contact_company_office_phone_number_id`) references `contact_company_office_phone_numbers` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $co_initiator_fax_contact_company_office_phone_number_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadChangeOrderDraftsByCoInitiatorFaxContactCompanyOfficePhoneNumberId($database, $co_initiator_fax_contact_company_office_phone_number_id, Input $options=null)
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
			self::$_arrChangeOrderDraftsByCoInitiatorFaxContactCompanyOfficePhoneNumberId = null;
		}

		$arrChangeOrderDraftsByCoInitiatorFaxContactCompanyOfficePhoneNumberId = self::$_arrChangeOrderDraftsByCoInitiatorFaxContactCompanyOfficePhoneNumberId;
		if (isset($arrChangeOrderDraftsByCoInitiatorFaxContactCompanyOfficePhoneNumberId) && !empty($arrChangeOrderDraftsByCoInitiatorFaxContactCompanyOfficePhoneNumberId)) {
			return $arrChangeOrderDraftsByCoInitiatorFaxContactCompanyOfficePhoneNumberId;
		}

		$co_initiator_fax_contact_company_office_phone_number_id = (int) $co_initiator_fax_contact_company_office_phone_number_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `change_order_type_id` ASC, `change_order_priority_id` ASC, `co_file_manager_file_id` ASC, `co_cost_code_id` ASC, `co_creator_contact_id` ASC, `co_creator_contact_company_office_id` ASC, `co_creator_phone_contact_company_office_phone_number_id` ASC, `co_creator_fax_contact_company_office_phone_number_id` ASC, `co_creator_contact_mobile_phone_number_id` ASC, `co_recipient_contact_id` ASC, `co_recipient_contact_company_office_id` ASC, `co_recipient_phone_contact_company_office_phone_number_id` ASC, `co_recipient_fax_contact_company_office_phone_number_id` ASC, `co_recipient_contact_mobile_phone_number_id` ASC, `co_initiator_contact_id` ASC, `co_initiator_contact_company_office_id` ASC, `co_initiator_phone_contact_company_office_phone_number_id` ASC, `co_initiator_fax_contact_company_office_phone_number_id` ASC, `co_initiator_contact_mobile_phone_number_id` ASC, `co_title` ASC, `co_plan_page_reference` ASC, `co_statement` ASC, `co_revised_project_completion_date` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpChangeOrderDraft = new ChangeOrderDraft($database);
			$sqlOrderByColumns = $tmpChangeOrderDraft->constructSqlOrderByColumns($arrOrderByAttributes);

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
	cod.*

FROM `change_order_drafts` cod
WHERE cod.`co_initiator_fax_contact_company_office_phone_number_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `change_order_type_id` ASC, `change_order_priority_id` ASC, `co_file_manager_file_id` ASC, `co_cost_code_id` ASC, `co_creator_contact_id` ASC, `co_creator_contact_company_office_id` ASC, `co_creator_phone_contact_company_office_phone_number_id` ASC, `co_creator_fax_contact_company_office_phone_number_id` ASC, `co_creator_contact_mobile_phone_number_id` ASC, `co_recipient_contact_id` ASC, `co_recipient_contact_company_office_id` ASC, `co_recipient_phone_contact_company_office_phone_number_id` ASC, `co_recipient_fax_contact_company_office_phone_number_id` ASC, `co_recipient_contact_mobile_phone_number_id` ASC, `co_initiator_contact_id` ASC, `co_initiator_contact_company_office_id` ASC, `co_initiator_phone_contact_company_office_phone_number_id` ASC, `co_initiator_fax_contact_company_office_phone_number_id` ASC, `co_initiator_contact_mobile_phone_number_id` ASC, `co_title` ASC, `co_plan_page_reference` ASC, `co_statement` ASC, `co_revised_project_completion_date` ASC
		$arrValues = array($co_initiator_fax_contact_company_office_phone_number_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrChangeOrderDraftsByCoInitiatorFaxContactCompanyOfficePhoneNumberId = array();
		while ($row = $db->fetch()) {
			$change_order_draft_id = $row['id'];
			$changeOrderDraft = self::instantiateOrm($database, 'ChangeOrderDraft', $row, null, $change_order_draft_id);
			/* @var $changeOrderDraft ChangeOrderDraft */
			$arrChangeOrderDraftsByCoInitiatorFaxContactCompanyOfficePhoneNumberId[$change_order_draft_id] = $changeOrderDraft;
		}

		$db->free_result();

		self::$_arrChangeOrderDraftsByCoInitiatorFaxContactCompanyOfficePhoneNumberId = $arrChangeOrderDraftsByCoInitiatorFaxContactCompanyOfficePhoneNumberId;

		return $arrChangeOrderDraftsByCoInitiatorFaxContactCompanyOfficePhoneNumberId;
	}

	/**
	 * Load by constraint `change_order_drafts_fk_initiator_c_mobile_cpn` foreign key (`co_initiator_contact_mobile_phone_number_id`) references `contact_phone_numbers` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $co_initiator_contact_mobile_phone_number_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadChangeOrderDraftsByCoInitiatorContactMobilePhoneNumberId($database, $co_initiator_contact_mobile_phone_number_id, Input $options=null)
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
			self::$_arrChangeOrderDraftsByCoInitiatorContactMobilePhoneNumberId = null;
		}

		$arrChangeOrderDraftsByCoInitiatorContactMobilePhoneNumberId = self::$_arrChangeOrderDraftsByCoInitiatorContactMobilePhoneNumberId;
		if (isset($arrChangeOrderDraftsByCoInitiatorContactMobilePhoneNumberId) && !empty($arrChangeOrderDraftsByCoInitiatorContactMobilePhoneNumberId)) {
			return $arrChangeOrderDraftsByCoInitiatorContactMobilePhoneNumberId;
		}

		$co_initiator_contact_mobile_phone_number_id = (int) $co_initiator_contact_mobile_phone_number_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `change_order_type_id` ASC, `change_order_priority_id` ASC, `co_file_manager_file_id` ASC, `co_cost_code_id` ASC, `co_creator_contact_id` ASC, `co_creator_contact_company_office_id` ASC, `co_creator_phone_contact_company_office_phone_number_id` ASC, `co_creator_fax_contact_company_office_phone_number_id` ASC, `co_creator_contact_mobile_phone_number_id` ASC, `co_recipient_contact_id` ASC, `co_recipient_contact_company_office_id` ASC, `co_recipient_phone_contact_company_office_phone_number_id` ASC, `co_recipient_fax_contact_company_office_phone_number_id` ASC, `co_recipient_contact_mobile_phone_number_id` ASC, `co_initiator_contact_id` ASC, `co_initiator_contact_company_office_id` ASC, `co_initiator_phone_contact_company_office_phone_number_id` ASC, `co_initiator_fax_contact_company_office_phone_number_id` ASC, `co_initiator_contact_mobile_phone_number_id` ASC, `co_title` ASC, `co_plan_page_reference` ASC, `co_statement` ASC, `co_revised_project_completion_date` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpChangeOrderDraft = new ChangeOrderDraft($database);
			$sqlOrderByColumns = $tmpChangeOrderDraft->constructSqlOrderByColumns($arrOrderByAttributes);

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
	cod.*

FROM `change_order_drafts` cod
WHERE cod.`co_initiator_contact_mobile_phone_number_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `change_order_type_id` ASC, `change_order_priority_id` ASC, `co_file_manager_file_id` ASC, `co_cost_code_id` ASC, `co_creator_contact_id` ASC, `co_creator_contact_company_office_id` ASC, `co_creator_phone_contact_company_office_phone_number_id` ASC, `co_creator_fax_contact_company_office_phone_number_id` ASC, `co_creator_contact_mobile_phone_number_id` ASC, `co_recipient_contact_id` ASC, `co_recipient_contact_company_office_id` ASC, `co_recipient_phone_contact_company_office_phone_number_id` ASC, `co_recipient_fax_contact_company_office_phone_number_id` ASC, `co_recipient_contact_mobile_phone_number_id` ASC, `co_initiator_contact_id` ASC, `co_initiator_contact_company_office_id` ASC, `co_initiator_phone_contact_company_office_phone_number_id` ASC, `co_initiator_fax_contact_company_office_phone_number_id` ASC, `co_initiator_contact_mobile_phone_number_id` ASC, `co_title` ASC, `co_plan_page_reference` ASC, `co_statement` ASC, `co_revised_project_completion_date` ASC
		$arrValues = array($co_initiator_contact_mobile_phone_number_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrChangeOrderDraftsByCoInitiatorContactMobilePhoneNumberId = array();
		while ($row = $db->fetch()) {
			$change_order_draft_id = $row['id'];
			$changeOrderDraft = self::instantiateOrm($database, 'ChangeOrderDraft', $row, null, $change_order_draft_id);
			/* @var $changeOrderDraft ChangeOrderDraft */
			$arrChangeOrderDraftsByCoInitiatorContactMobilePhoneNumberId[$change_order_draft_id] = $changeOrderDraft;
		}

		$db->free_result();

		self::$_arrChangeOrderDraftsByCoInitiatorContactMobilePhoneNumberId = $arrChangeOrderDraftsByCoInitiatorContactMobilePhoneNumberId;

		return $arrChangeOrderDraftsByCoInitiatorContactMobilePhoneNumberId;
	}

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all change_order_drafts records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllChangeOrderDrafts($database, Input $options=null)
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
			self::$_arrAllChangeOrderDrafts = null;
		}

		$arrAllChangeOrderDrafts = self::$_arrAllChangeOrderDrafts;
		if (isset($arrAllChangeOrderDrafts) && !empty($arrAllChangeOrderDrafts)) {
			return $arrAllChangeOrderDrafts;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `change_order_type_id` ASC, `change_order_priority_id` ASC, `co_file_manager_file_id` ASC, `co_cost_code_id` ASC, `co_creator_contact_id` ASC, `co_creator_contact_company_office_id` ASC, `co_creator_phone_contact_company_office_phone_number_id` ASC, `co_creator_fax_contact_company_office_phone_number_id` ASC, `co_creator_contact_mobile_phone_number_id` ASC, `co_recipient_contact_id` ASC, `co_recipient_contact_company_office_id` ASC, `co_recipient_phone_contact_company_office_phone_number_id` ASC, `co_recipient_fax_contact_company_office_phone_number_id` ASC, `co_recipient_contact_mobile_phone_number_id` ASC, `co_initiator_contact_id` ASC, `co_initiator_contact_company_office_id` ASC, `co_initiator_phone_contact_company_office_phone_number_id` ASC, `co_initiator_fax_contact_company_office_phone_number_id` ASC, `co_initiator_contact_mobile_phone_number_id` ASC, `co_title` ASC, `co_plan_page_reference` ASC, `co_statement` ASC, `co_revised_project_completion_date` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpChangeOrderDraft = new ChangeOrderDraft($database);
			$sqlOrderByColumns = $tmpChangeOrderDraft->constructSqlOrderByColumns($arrOrderByAttributes);

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
	cod.*

FROM `change_order_drafts` cod{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `change_order_type_id` ASC, `change_order_priority_id` ASC, `co_file_manager_file_id` ASC, `co_cost_code_id` ASC, `co_creator_contact_id` ASC, `co_creator_contact_company_office_id` ASC, `co_creator_phone_contact_company_office_phone_number_id` ASC, `co_creator_fax_contact_company_office_phone_number_id` ASC, `co_creator_contact_mobile_phone_number_id` ASC, `co_recipient_contact_id` ASC, `co_recipient_contact_company_office_id` ASC, `co_recipient_phone_contact_company_office_phone_number_id` ASC, `co_recipient_fax_contact_company_office_phone_number_id` ASC, `co_recipient_contact_mobile_phone_number_id` ASC, `co_initiator_contact_id` ASC, `co_initiator_contact_company_office_id` ASC, `co_initiator_phone_contact_company_office_phone_number_id` ASC, `co_initiator_fax_contact_company_office_phone_number_id` ASC, `co_initiator_contact_mobile_phone_number_id` ASC, `co_title` ASC, `co_plan_page_reference` ASC, `co_statement` ASC, `co_revised_project_completion_date` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllChangeOrderDrafts = array();
		while ($row = $db->fetch()) {
			$change_order_draft_id = $row['id'];
			$changeOrderDraft = self::instantiateOrm($database, 'ChangeOrderDraft', $row, null, $change_order_draft_id);
			/* @var $changeOrderDraft ChangeOrderDraft */
			$arrAllChangeOrderDrafts[$change_order_draft_id] = $changeOrderDraft;
		}

		$db->free_result();

		self::$_arrAllChangeOrderDrafts = $arrAllChangeOrderDrafts;

		return $arrAllChangeOrderDrafts;
	}

	// Save: insert on duplicate key update

	// Save: insert ignore
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

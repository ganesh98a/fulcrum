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
 * Submittal.
 *
 * @category   Framework
 * @package    Submittal
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class SubmittalRegistry extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'SubmittalRegistry';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'submittal_registry';

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
	 * unique index `unique_su` (`project_id`,`su_sequence_number`) comment 'One Project can have many Submittals with a sequence number.'
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_su' => array(
			'project_id' => 'int',
			'su_sequence_number' => 'int'
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
		'id' => 'submittal_id',

		'project_id' => 'project_id',
		'contracting_entity_id' => 'contracting_entity_id',
		'su_sequence_number' => 'su_sequence_number',
		'su_spec_no' =>'su_spec_no',
		'submittal_type_id' => 'submittal_type_id',
		'submittal_status_id' => 'submittal_status_id',
		'submittal_priority_id' => 'submittal_priority_id',
		'submittal_distribution_method_id' => 'submittal_distribution_method_id',
		'su_file_manager_file_id' => 'su_file_manager_file_id',
		'su_cost_code_id' => 'su_cost_code_id',
		'su_creator_contact_id' => 'su_creator_contact_id',
		'su_creator_contact_company_office_id' => 'su_creator_contact_company_office_id',
		'su_creator_phone_contact_company_office_phone_number_id' => 'su_creator_phone_contact_company_office_phone_number_id',
		'su_creator_fax_contact_company_office_phone_number_id' => 'su_creator_fax_contact_company_office_phone_number_id',
		'su_creator_contact_mobile_phone_number_id' => 'su_creator_contact_mobile_phone_number_id',
		'su_recipient_contact_id' => 'su_recipient_contact_id',
		'su_recipient_contact_company_office_id' => 'su_recipient_contact_company_office_id',
		'su_recipient_phone_contact_company_office_phone_number_id' => 'su_recipient_phone_contact_company_office_phone_number_id',
		'su_recipient_fax_contact_company_office_phone_number_id' => 'su_recipient_fax_contact_company_office_phone_number_id',
		'su_recipient_contact_mobile_phone_number_id' => 'su_recipient_contact_mobile_phone_number_id',
		'su_initiator_contact_id' => 'su_initiator_contact_id',
		'su_initiator_contact_company_office_id' => 'su_initiator_contact_company_office_id',
		'su_initiator_phone_contact_company_office_phone_number_id' => 'su_initiator_phone_contact_company_office_phone_number_id',
		'su_initiator_fax_contact_company_office_phone_number_id' => 'su_initiator_fax_contact_company_office_phone_number_id',
		'su_initiator_contact_mobile_phone_number_id' => 'su_initiator_contact_mobile_phone_number_id',

		'su_title' => 'su_title',
		'su_plan_page_reference' => 'su_plan_page_reference',
		'su_statement' => 'su_statement',
		'tag_ids' =>'tag_ids',
		'created' => 'created',
		'su_due_date' => 'su_due_date',
		'su_closed_date' => 'su_closed_date'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $submittal_id;

	public $project_id;
	public $su_sequence_number;
	public $su_spec_no;

	public $submittal_type_id;
	public $submittal_status_id;
	public $submittal_priority_id;
	public $submittal_distribution_method_id;
	public $su_file_manager_file_id;
	public $su_cost_code_id;
	public $su_creator_contact_id;
	public $su_creator_contact_company_office_id;
	public $su_creator_phone_contact_company_office_phone_number_id;
	public $su_creator_fax_contact_company_office_phone_number_id;
	public $su_creator_contact_mobile_phone_number_id;
	public $su_recipient_contact_id;
	public $su_recipient_contact_company_office_id;
	public $su_recipient_phone_contact_company_office_phone_number_id;
	public $su_recipient_fax_contact_company_office_phone_number_id;
	public $su_recipient_contact_mobile_phone_number_id;
	public $su_initiator_contact_id;
	public $su_initiator_contact_company_office_id;
	public $su_initiator_phone_contact_company_office_phone_number_id;
	public $su_initiator_fax_contact_company_office_phone_number_id;
	public $su_initiator_contact_mobile_phone_number_id;

	public $su_title;
	public $su_plan_page_reference;
	public $su_statement;
	public $tag_ids;
	public $created;
	public $su_due_date;
	public $su_closed_date;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties
	public $escaped_su_title;
	public $escaped_su_plan_page_reference;
	public $escaped_su_statement;

	// HTML ENTITY ENCODED NL2BR ORM string properties
	public $escaped_su_title_nl2br;
	public $escaped_su_plan_page_reference_nl2br;
	public $escaped_su_statement_nl2br;

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)
	protected static $_arrSubmittalsByProjectId;
	protected static $_arrSubmittalsBySubmittalTypeId;
	protected static $_arrSubmittalsBySubmittalStatusId;
	protected static $_arrSubmittalsBySubmittalPriorityId;
	protected static $_arrSubmittalsBySubmittalDistributionMethodId;
	protected static $_arrSubmittalsBySuFileManagerFileId;
	protected static $_arrSubmittalsBySuCostCodeId;
	protected static $_arrSubmittalsBySuCreatorContactId;
	protected static $_arrSubmittalsBySuCreatorContactCompanyOfficeId;
	protected static $_arrSubmittalsBySuCreatorPhoneContactCompanyOfficePhoneNumberId;
	protected static $_arrSubmittalsBySuCreatorFaxContactCompanyOfficePhoneNumberId;
	protected static $_arrSubmittalsBySuCreatorContactMobilePhoneNumberId;
	protected static $_arrSubmittalsBySuRecipientContactId;
	protected static $_arrSubmittalsBySuRecipientContactCompanyOfficeId;
	protected static $_arrSubmittalsBySuRecipientPhoneContactCompanyOfficePhoneNumberId;
	protected static $_arrSubmittalsBySuRecipientFaxContactCompanyOfficePhoneNumberId;
	protected static $_arrSubmittalsBySuRecipientContactMobilePhoneNumberId;
	protected static $_arrSubmittalsBySuInitiatorContactId;
	protected static $_arrSubmittalsBySuInitiatorContactCompanyOfficeId;
	protected static $_arrSubmittalsBySuInitiatorPhoneContactCompanyOfficePhoneNumberId;
	protected static $_arrSubmittalsBySuInitiatorFaxContactCompanyOfficePhoneNumberId;
	protected static $_arrSubmittalsBySuInitiatorContactMobilePhoneNumberId;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllSubmittals;

	// Foreign Key Objects
	private $_project;
	private $_submittalType;
	private $_submittalStatus;
	private $_submittalPriority;
	private $_submittalDistributionMethod;
	private $_suFileManagerFile;
	private $_suCostCode;
	private $_suCreatorContact;
	private $_suCreatorContactCompanyOffice;
	private $_suCreatorPhoneContactCompanyOfficePhoneNumber;
	private $_suCreatorFaxContactCompanyOfficePhoneNumber;
	private $_suCreatorContactMobilePhoneNumber;
	private $_suRecipientContact;
	private $_suRecipientContactCompanyOffice;
	private $_suRecipientPhoneContactCompanyOfficePhoneNumber;
	private $_suRecipientFaxContactCompanyOfficePhoneNumber;
	private $_suRecipientContactMobilePhoneNumber;
	private $_suInitiatorContact;
	private $_suInitiatorContactCompanyOffice;
	private $_suInitiatorPhoneContactCompanyOfficePhoneNumber;
	private $_suInitiatorFaxContactCompanyOfficePhoneNumber;
	private $_suInitiatorContactMobilePhoneNumber;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='submittal_registry')
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

	public function getSubmittalType()
	{
		if (isset($this->_submittalType)) {
			return $this->_submittalType;
		} else {
			return null;
		}
	}

	public function setSubmittalType($submittalType)
	{
		$this->_submittalType = $submittalType;
	}

	public function getSubmittalStatus()
	{
		if (isset($this->_submittalStatus)) {
			return $this->_submittalStatus;
		} else {
			return null;
		}
	}

	public function setSubmittalStatus($submittalStatus)
	{
		$this->_submittalStatus = $submittalStatus;
	}

	public function getSubmittalPriority()
	{
		if (isset($this->_submittalPriority)) {
			return $this->_submittalPriority;
		} else {
			return null;
		}
	}

	public function setSubmittalPriority($submittalPriority)
	{
		$this->_submittalPriority = $submittalPriority;
	}

	public function getSubmittalDistributionMethod()
	{
		if (isset($this->_submittalDistributionMethod)) {
			return $this->_submittalDistributionMethod;
		} else {
			return null;
		}
	}

	public function setSubmittalDistributionMethod($submittalDistributionMethod)
	{
		$this->_submittalDistributionMethod = $submittalDistributionMethod;
	}

	public function getSuFileManagerFile()
	{
		if (isset($this->_suFileManagerFile)) {
			return $this->_suFileManagerFile;
		} else {
			return null;
		}
	}

	public function setSuFileManagerFile($suFileManagerFile)
	{
		$this->_suFileManagerFile = $suFileManagerFile;
	}

	public function getSuCostCode()
	{
		if (isset($this->_suCostCode)) {
			return $this->_suCostCode;
		} else {
			return null;
		}
	}

	public function setSuCostCode($suCostCode)
	{
		$this->_suCostCode = $suCostCode;
	}

	public function getSuCreatorContact()
	{
		if (isset($this->_suCreatorContact)) {
			return $this->_suCreatorContact;
		} else {
			return null;
		}
	}

	public function setSuCreatorContact($suCreatorContact)
	{
		$this->_suCreatorContact = $suCreatorContact;
	}

	public function getSuCreatorContactCompanyOffice()
	{
		if (isset($this->_suCreatorContactCompanyOffice)) {
			return $this->_suCreatorContactCompanyOffice;
		} else {
			return null;
		}
	}

	public function setSuCreatorContactCompanyOffice($suCreatorContactCompanyOffice)
	{
		$this->_suCreatorContactCompanyOffice = $suCreatorContactCompanyOffice;
	}

	public function getSuCreatorPhoneContactCompanyOfficePhoneNumber()
	{
		if (isset($this->_suCreatorPhoneContactCompanyOfficePhoneNumber)) {
			return $this->_suCreatorPhoneContactCompanyOfficePhoneNumber;
		} else {
			return null;
		}
	}

	public function setSuCreatorPhoneContactCompanyOfficePhoneNumber($suCreatorPhoneContactCompanyOfficePhoneNumber)
	{
		$this->_suCreatorPhoneContactCompanyOfficePhoneNumber = $suCreatorPhoneContactCompanyOfficePhoneNumber;
	}

	public function getSuCreatorFaxContactCompanyOfficePhoneNumber()
	{
		if (isset($this->_suCreatorFaxContactCompanyOfficePhoneNumber)) {
			return $this->_suCreatorFaxContactCompanyOfficePhoneNumber;
		} else {
			return null;
		}
	}

	public function setSuCreatorFaxContactCompanyOfficePhoneNumber($suCreatorFaxContactCompanyOfficePhoneNumber)
	{
		$this->_suCreatorFaxContactCompanyOfficePhoneNumber = $suCreatorFaxContactCompanyOfficePhoneNumber;
	}

	public function getSuCreatorContactMobilePhoneNumber()
	{
		if (isset($this->_suCreatorContactMobilePhoneNumber)) {
			return $this->_suCreatorContactMobilePhoneNumber;
		} else {
			return null;
		}
	}

	public function setSuCreatorContactMobilePhoneNumber($suCreatorContactMobilePhoneNumber)
	{
		$this->_suCreatorContactMobilePhoneNumber = $suCreatorContactMobilePhoneNumber;
	}

	public function getSuRecipientContact()
	{
		if (isset($this->_suRecipientContact)) {
			return $this->_suRecipientContact;
		} else {
			return null;
		}
	}

	public function setSuRecipientContact($suRecipientContact)
	{
		$this->_suRecipientContact = $suRecipientContact;
	}

	public function getSuRecipientContactCompanyOffice()
	{
		if (isset($this->_suRecipientContactCompanyOffice)) {
			return $this->_suRecipientContactCompanyOffice;
		} else {
			return null;
		}
	}

	public function setSuRecipientContactCompanyOffice($suRecipientContactCompanyOffice)
	{
		$this->_suRecipientContactCompanyOffice = $suRecipientContactCompanyOffice;
	}

	public function getSuRecipientPhoneContactCompanyOfficePhoneNumber()
	{
		if (isset($this->_suRecipientPhoneContactCompanyOfficePhoneNumber)) {
			return $this->_suRecipientPhoneContactCompanyOfficePhoneNumber;
		} else {
			return null;
		}
	}

	public function setSuRecipientPhoneContactCompanyOfficePhoneNumber($suRecipientPhoneContactCompanyOfficePhoneNumber)
	{
		$this->_suRecipientPhoneContactCompanyOfficePhoneNumber = $suRecipientPhoneContactCompanyOfficePhoneNumber;
	}

	public function getSuRecipientFaxContactCompanyOfficePhoneNumber()
	{
		if (isset($this->_suRecipientFaxContactCompanyOfficePhoneNumber)) {
			return $this->_suRecipientFaxContactCompanyOfficePhoneNumber;
		} else {
			return null;
		}
	}

	public function setSuRecipientFaxContactCompanyOfficePhoneNumber($suRecipientFaxContactCompanyOfficePhoneNumber)
	{
		$this->_suRecipientFaxContactCompanyOfficePhoneNumber = $suRecipientFaxContactCompanyOfficePhoneNumber;
	}

	public function getSuRecipientContactMobilePhoneNumber()
	{
		if (isset($this->_suRecipientContactMobilePhoneNumber)) {
			return $this->_suRecipientContactMobilePhoneNumber;
		} else {
			return null;
		}
	}

	public function setSuRecipientContactMobilePhoneNumber($suRecipientContactMobilePhoneNumber)
	{
		$this->_suRecipientContactMobilePhoneNumber = $suRecipientContactMobilePhoneNumber;
	}

	public function getSuInitiatorContact()
	{
		if (isset($this->_suInitiatorContact)) {
			return $this->_suInitiatorContact;
		} else {
			return null;
		}
	}

	public function setSuInitiatorContact($suInitiatorContact)
	{
		$this->_suInitiatorContact = $suInitiatorContact;
	}

	public function getSuInitiatorContactCompanyOffice()
	{
		if (isset($this->_suInitiatorContactCompanyOffice)) {
			return $this->_suInitiatorContactCompanyOffice;
		} else {
			return null;
		}
	}

	public function setSuInitiatorContactCompanyOffice($suInitiatorContactCompanyOffice)
	{
		$this->_suInitiatorContactCompanyOffice = $suInitiatorContactCompanyOffice;
	}

	public function getSuInitiatorPhoneContactCompanyOfficePhoneNumber()
	{
		if (isset($this->_suInitiatorPhoneContactCompanyOfficePhoneNumber)) {
			return $this->_suInitiatorPhoneContactCompanyOfficePhoneNumber;
		} else {
			return null;
		}
	}

	public function setSuInitiatorPhoneContactCompanyOfficePhoneNumber($suInitiatorPhoneContactCompanyOfficePhoneNumber)
	{
		$this->_suInitiatorPhoneContactCompanyOfficePhoneNumber = $suInitiatorPhoneContactCompanyOfficePhoneNumber;
	}

	public function getSuInitiatorFaxContactCompanyOfficePhoneNumber()
	{
		if (isset($this->_suInitiatorFaxContactCompanyOfficePhoneNumber)) {
			return $this->_suInitiatorFaxContactCompanyOfficePhoneNumber;
		} else {
			return null;
		}
	}

	public function setSuInitiatorFaxContactCompanyOfficePhoneNumber($suInitiatorFaxContactCompanyOfficePhoneNumber)
	{
		$this->_suInitiatorFaxContactCompanyOfficePhoneNumber = $suInitiatorFaxContactCompanyOfficePhoneNumber;
	}

	public function getSuInitiatorContactMobilePhoneNumber()
	{
		if (isset($this->_suInitiatorContactMobilePhoneNumber)) {
			return $this->_suInitiatorContactMobilePhoneNumber;
		} else {
			return null;
		}
	}

	public function setSuInitiatorContactMobilePhoneNumber($suInitiatorContactMobilePhoneNumber)
	{
		$this->_suInitiatorContactMobilePhoneNumber = $suInitiatorContactMobilePhoneNumber;
	}

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)
	public static function getArrSubmittalsByProjectId()
	{
		if (isset(self::$_arrSubmittalsByProjectId)) {
			return self::$_arrSubmittalsByProjectId;
		} else {
			return null;
		}
	}

	public static function setArrSubmittalsByProjectId($arrSubmittalsByProjectId)
	{
		self::$_arrSubmittalsByProjectId = $arrSubmittalsByProjectId;
	}

	public static function getArrSubmittalsBySubmittalTypeId()
	{
		if (isset(self::$_arrSubmittalsBySubmittalTypeId)) {
			return self::$_arrSubmittalsBySubmittalTypeId;
		} else {
			return null;
		}
	}

	public static function setArrSubmittalsBySubmittalTypeId($arrSubmittalsBySubmittalTypeId)
	{
		self::$_arrSubmittalsBySubmittalTypeId = $arrSubmittalsBySubmittalTypeId;
	}

	public static function getArrSubmittalsBySubmittalStatusId()
	{
		if (isset(self::$_arrSubmittalsBySubmittalStatusId)) {
			return self::$_arrSubmittalsBySubmittalStatusId;
		} else {
			return null;
		}
	}

	public static function setArrSubmittalsBySubmittalStatusId($arrSubmittalsBySubmittalStatusId)
	{
		self::$_arrSubmittalsBySubmittalStatusId = $arrSubmittalsBySubmittalStatusId;
	}

	public static function getArrSubmittalsBySubmittalPriorityId()
	{
		if (isset(self::$_arrSubmittalsBySubmittalPriorityId)) {
			return self::$_arrSubmittalsBySubmittalPriorityId;
		} else {
			return null;
		}
	}

	public static function setArrSubmittalsBySubmittalPriorityId($arrSubmittalsBySubmittalPriorityId)
	{
		self::$_arrSubmittalsBySubmittalPriorityId = $arrSubmittalsBySubmittalPriorityId;
	}

	public static function getArrSubmittalsBySubmittalDistributionMethodId()
	{
		if (isset(self::$_arrSubmittalsBySubmittalDistributionMethodId)) {
			return self::$_arrSubmittalsBySubmittalDistributionMethodId;
		} else {
			return null;
		}
	}

	public static function setArrSubmittalsBySubmittalDistributionMethodId($arrSubmittalsBySubmittalDistributionMethodId)
	{
		self::$_arrSubmittalsBySubmittalDistributionMethodId = $arrSubmittalsBySubmittalDistributionMethodId;
	}

	public static function getArrSubmittalsBySuFileManagerFileId()
	{
		if (isset(self::$_arrSubmittalsBySuFileManagerFileId)) {
			return self::$_arrSubmittalsBySuFileManagerFileId;
		} else {
			return null;
		}
	}

	public static function setArrSubmittalsBySuFileManagerFileId($arrSubmittalsBySuFileManagerFileId)
	{
		self::$_arrSubmittalsBySuFileManagerFileId = $arrSubmittalsBySuFileManagerFileId;
	}

	public static function getArrSubmittalsBySuCostCodeId()
	{
		if (isset(self::$_arrSubmittalsBySuCostCodeId)) {
			return self::$_arrSubmittalsBySuCostCodeId;
		} else {
			return null;
		}
	}

	public static function setArrSubmittalsBySuCostCodeId($arrSubmittalsBySuCostCodeId)
	{
		self::$_arrSubmittalsBySuCostCodeId = $arrSubmittalsBySuCostCodeId;
	}

	public static function getArrSubmittalsBySuCreatorContactId()
	{
		if (isset(self::$_arrSubmittalsBySuCreatorContactId)) {
			return self::$_arrSubmittalsBySuCreatorContactId;
		} else {
			return null;
		}
	}

	public static function setArrSubmittalsBySuCreatorContactId($arrSubmittalsBySuCreatorContactId)
	{
		self::$_arrSubmittalsBySuCreatorContactId = $arrSubmittalsBySuCreatorContactId;
	}

	public static function getArrSubmittalsBySuCreatorContactCompanyOfficeId()
	{
		if (isset(self::$_arrSubmittalsBySuCreatorContactCompanyOfficeId)) {
			return self::$_arrSubmittalsBySuCreatorContactCompanyOfficeId;
		} else {
			return null;
		}
	}

	public static function setArrSubmittalsBySuCreatorContactCompanyOfficeId($arrSubmittalsBySuCreatorContactCompanyOfficeId)
	{
		self::$_arrSubmittalsBySuCreatorContactCompanyOfficeId = $arrSubmittalsBySuCreatorContactCompanyOfficeId;
	}

	public static function getArrSubmittalsBySuCreatorPhoneContactCompanyOfficePhoneNumberId()
	{
		if (isset(self::$_arrSubmittalsBySuCreatorPhoneContactCompanyOfficePhoneNumberId)) {
			return self::$_arrSubmittalsBySuCreatorPhoneContactCompanyOfficePhoneNumberId;
		} else {
			return null;
		}
	}

	public static function setArrSubmittalsBySuCreatorPhoneContactCompanyOfficePhoneNumberId($arrSubmittalsBySuCreatorPhoneContactCompanyOfficePhoneNumberId)
	{
		self::$_arrSubmittalsBySuCreatorPhoneContactCompanyOfficePhoneNumberId = $arrSubmittalsBySuCreatorPhoneContactCompanyOfficePhoneNumberId;
	}

	public static function getArrSubmittalsBySuCreatorFaxContactCompanyOfficePhoneNumberId()
	{
		if (isset(self::$_arrSubmittalsBySuCreatorFaxContactCompanyOfficePhoneNumberId)) {
			return self::$_arrSubmittalsBySuCreatorFaxContactCompanyOfficePhoneNumberId;
		} else {
			return null;
		}
	}

	public static function setArrSubmittalsBySuCreatorFaxContactCompanyOfficePhoneNumberId($arrSubmittalsBySuCreatorFaxContactCompanyOfficePhoneNumberId)
	{
		self::$_arrSubmittalsBySuCreatorFaxContactCompanyOfficePhoneNumberId = $arrSubmittalsBySuCreatorFaxContactCompanyOfficePhoneNumberId;
	}

	public static function getArrSubmittalsBySuCreatorContactMobilePhoneNumberId()
	{
		if (isset(self::$_arrSubmittalsBySuCreatorContactMobilePhoneNumberId)) {
			return self::$_arrSubmittalsBySuCreatorContactMobilePhoneNumberId;
		} else {
			return null;
		}
	}

	public static function setArrSubmittalsBySuCreatorContactMobilePhoneNumberId($arrSubmittalsBySuCreatorContactMobilePhoneNumberId)
	{
		self::$_arrSubmittalsBySuCreatorContactMobilePhoneNumberId = $arrSubmittalsBySuCreatorContactMobilePhoneNumberId;
	}

	public static function getArrSubmittalsBySuRecipientContactId()
	{
		if (isset(self::$_arrSubmittalsBySuRecipientContactId)) {
			return self::$_arrSubmittalsBySuRecipientContactId;
		} else {
			return null;
		}
	}

	public static function setArrSubmittalsBySuRecipientContactId($arrSubmittalsBySuRecipientContactId)
	{
		self::$_arrSubmittalsBySuRecipientContactId = $arrSubmittalsBySuRecipientContactId;
	}

	public static function getArrSubmittalsBySuRecipientContactCompanyOfficeId()
	{
		if (isset(self::$_arrSubmittalsBySuRecipientContactCompanyOfficeId)) {
			return self::$_arrSubmittalsBySuRecipientContactCompanyOfficeId;
		} else {
			return null;
		}
	}

	public static function setArrSubmittalsBySuRecipientContactCompanyOfficeId($arrSubmittalsBySuRecipientContactCompanyOfficeId)
	{
		self::$_arrSubmittalsBySuRecipientContactCompanyOfficeId = $arrSubmittalsBySuRecipientContactCompanyOfficeId;
	}

	public static function getArrSubmittalsBySuRecipientPhoneContactCompanyOfficePhoneNumberId()
	{
		if (isset(self::$_arrSubmittalsBySuRecipientPhoneContactCompanyOfficePhoneNumberId)) {
			return self::$_arrSubmittalsBySuRecipientPhoneContactCompanyOfficePhoneNumberId;
		} else {
			return null;
		}
	}

	public static function setArrSubmittalsBySuRecipientPhoneContactCompanyOfficePhoneNumberId($arrSubmittalsBySuRecipientPhoneContactCompanyOfficePhoneNumberId)
	{
		self::$_arrSubmittalsBySuRecipientPhoneContactCompanyOfficePhoneNumberId = $arrSubmittalsBySuRecipientPhoneContactCompanyOfficePhoneNumberId;
	}

	public static function getArrSubmittalsBySuRecipientFaxContactCompanyOfficePhoneNumberId()
	{
		if (isset(self::$_arrSubmittalsBySuRecipientFaxContactCompanyOfficePhoneNumberId)) {
			return self::$_arrSubmittalsBySuRecipientFaxContactCompanyOfficePhoneNumberId;
		} else {
			return null;
		}
	}

	public static function setArrSubmittalsBySuRecipientFaxContactCompanyOfficePhoneNumberId($arrSubmittalsBySuRecipientFaxContactCompanyOfficePhoneNumberId)
	{
		self::$_arrSubmittalsBySuRecipientFaxContactCompanyOfficePhoneNumberId = $arrSubmittalsBySuRecipientFaxContactCompanyOfficePhoneNumberId;
	}

	public static function getArrSubmittalsBySuRecipientContactMobilePhoneNumberId()
	{
		if (isset(self::$_arrSubmittalsBySuRecipientContactMobilePhoneNumberId)) {
			return self::$_arrSubmittalsBySuRecipientContactMobilePhoneNumberId;
		} else {
			return null;
		}
	}

	public static function setArrSubmittalsBySuRecipientContactMobilePhoneNumberId($arrSubmittalsBySuRecipientContactMobilePhoneNumberId)
	{
		self::$_arrSubmittalsBySuRecipientContactMobilePhoneNumberId = $arrSubmittalsBySuRecipientContactMobilePhoneNumberId;
	}

	public static function getArrSubmittalsBySuInitiatorContactId()
	{
		if (isset(self::$_arrSubmittalsBySuInitiatorContactId)) {
			return self::$_arrSubmittalsBySuInitiatorContactId;
		} else {
			return null;
		}
	}

	public static function setArrSubmittalsBySuInitiatorContactId($arrSubmittalsBySuInitiatorContactId)
	{
		self::$_arrSubmittalsBySuInitiatorContactId = $arrSubmittalsBySuInitiatorContactId;
	}

	public static function getArrSubmittalsBySuInitiatorContactCompanyOfficeId()
	{
		if (isset(self::$_arrSubmittalsBySuInitiatorContactCompanyOfficeId)) {
			return self::$_arrSubmittalsBySuInitiatorContactCompanyOfficeId;
		} else {
			return null;
		}
	}

	public static function setArrSubmittalsBySuInitiatorContactCompanyOfficeId($arrSubmittalsBySuInitiatorContactCompanyOfficeId)
	{
		self::$_arrSubmittalsBySuInitiatorContactCompanyOfficeId = $arrSubmittalsBySuInitiatorContactCompanyOfficeId;
	}

	public static function getArrSubmittalsBySuInitiatorPhoneContactCompanyOfficePhoneNumberId()
	{
		if (isset(self::$_arrSubmittalsBySuInitiatorPhoneContactCompanyOfficePhoneNumberId)) {
			return self::$_arrSubmittalsBySuInitiatorPhoneContactCompanyOfficePhoneNumberId;
		} else {
			return null;
		}
	}

	public static function setArrSubmittalsBySuInitiatorPhoneContactCompanyOfficePhoneNumberId($arrSubmittalsBySuInitiatorPhoneContactCompanyOfficePhoneNumberId)
	{
		self::$_arrSubmittalsBySuInitiatorPhoneContactCompanyOfficePhoneNumberId = $arrSubmittalsBySuInitiatorPhoneContactCompanyOfficePhoneNumberId;
	}

	public static function getArrSubmittalsBySuInitiatorFaxContactCompanyOfficePhoneNumberId()
	{
		if (isset(self::$_arrSubmittalsBySuInitiatorFaxContactCompanyOfficePhoneNumberId)) {
			return self::$_arrSubmittalsBySuInitiatorFaxContactCompanyOfficePhoneNumberId;
		} else {
			return null;
		}
	}

	public static function setArrSubmittalsBySuInitiatorFaxContactCompanyOfficePhoneNumberId($arrSubmittalsBySuInitiatorFaxContactCompanyOfficePhoneNumberId)
	{
		self::$_arrSubmittalsBySuInitiatorFaxContactCompanyOfficePhoneNumberId = $arrSubmittalsBySuInitiatorFaxContactCompanyOfficePhoneNumberId;
	}

	public static function getArrSubmittalsBySuInitiatorContactMobilePhoneNumberId()
	{
		if (isset(self::$_arrSubmittalsBySuInitiatorContactMobilePhoneNumberId)) {
			return self::$_arrSubmittalsBySuInitiatorContactMobilePhoneNumberId;
		} else {
			return null;
		}
	}

	public static function setArrSubmittalsBySuInitiatorContactMobilePhoneNumberId($arrSubmittalsBySuInitiatorContactMobilePhoneNumberId)
	{
		self::$_arrSubmittalsBySuInitiatorContactMobilePhoneNumberId = $arrSubmittalsBySuInitiatorContactMobilePhoneNumberId;
	}

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllSubmittals()
	{
		if (isset(self::$_arrAllSubmittals)) {
			return self::$_arrAllSubmittals;
		} else {
			return null;
		}
	}

	public static function setArrAllSubmittals($arrAllSubmittals)
	{
		self::$_arrAllSubmittals = $arrAllSubmittals;
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
	 * @param int $submittal_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findById($database, $submittal_id,$table='submittal_registry', $module='SubmittalRegistry')
	{
		$submittal = parent::findById($database, $submittal_id,$table, $module);

		return $submittal;
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Similar to FindById, but with SQL as starter code for more complex joins.
	 *
	 * @param string $database
	 * @param int $submittal_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findSubmittalByIdExtended($database, $submittal_id)
	{
		$submittal_id = (int) $submittal_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	su_fk_p.`id` AS 'su_fk_p__project_id',
	su_fk_p.`project_type_id` AS 'su_fk_p__project_type_id',
	su_fk_p.`user_company_id` AS 'su_fk_p__user_company_id',
	su_fk_p.`user_custom_project_id` AS 'su_fk_p__user_custom_project_id',
	su_fk_p.`project_name` AS 'su_fk_p__project_name',
	su_fk_p.`project_owner_name` AS 'su_fk_p__project_owner_name',
	su_fk_p.`latitude` AS 'su_fk_p__latitude',
	su_fk_p.`longitude` AS 'su_fk_p__longitude',
	su_fk_p.`address_line_1` AS 'su_fk_p__address_line_1',
	su_fk_p.`address_line_2` AS 'su_fk_p__address_line_2',
	su_fk_p.`address_line_3` AS 'su_fk_p__address_line_3',
	su_fk_p.`address_line_4` AS 'su_fk_p__address_line_4',
	su_fk_p.`address_city` AS 'su_fk_p__address_city',
	su_fk_p.`address_county` AS 'su_fk_p__address_county',
	su_fk_p.`address_state_or_region` AS 'su_fk_p__address_state_or_region',
	su_fk_p.`address_postal_code` AS 'su_fk_p__address_postal_code',
	su_fk_p.`address_postal_code_extension` AS 'su_fk_p__address_postal_code_extension',
	su_fk_p.`address_country` AS 'su_fk_p__address_country',
	su_fk_p.`building_count` AS 'su_fk_p__building_count',
	su_fk_p.`unit_count` AS 'su_fk_p__unit_count',
	su_fk_p.`gross_square_footage` AS 'su_fk_p__gross_square_footage',
	su_fk_p.`net_rentable_square_footage` AS 'su_fk_p__net_rentable_square_footage',
	su_fk_p.`is_active_flag` AS 'su_fk_p__is_active_flag',
	su_fk_p.`public_plans_flag` AS 'su_fk_p__public_plans_flag',
	su_fk_p.`prevailing_wage_flag` AS 'su_fk_p__prevailing_wage_flag',
	su_fk_p.`city_business_license_required_flag` AS 'su_fk_p__city_business_license_required_flag',
	su_fk_p.`is_internal_flag` AS 'su_fk_p__is_internal_flag',
	su_fk_p.`project_contract_date` AS 'su_fk_p__project_contract_date',
	su_fk_p.`project_start_date` AS 'su_fk_p__project_start_date',
	su_fk_p.`project_completed_date` AS 'su_fk_p__project_completed_date',
	su_fk_p.`sort_order` AS 'su_fk_p__sort_order',

	su_fk_sut.`id` AS 'su_fk_sut__submittal_type_id',
	su_fk_sut.`submittal_type` AS 'su_fk_sut__submittal_type',
	su_fk_sut.`disabled_flag` AS 'su_fk_sut__disabled_flag',

	su_fk_sus.`id` AS 'su_fk_sus__submittal_status_id',
	su_fk_sus.`submittal_status` AS 'su_fk_sus__submittal_status',
	su_fk_sus.`disabled_flag` AS 'su_fk_sus__disabled_flag',

	su_fk_sup.`id` AS 'su_fk_sup__submittal_priority_id',
	su_fk_sup.`submittal_priority` AS 'su_fk_sup__submittal_priority',
	su_fk_sup.`disabled_flag` AS 'su_fk_sup__disabled_flag',

	su_fk_sudm.`id` AS 'su_fk_sudm__submittal_distribution_method_id',
	su_fk_sudm.`submittal_distribution_method` AS 'su_fk_sudm__submittal_distribution_method',
	su_fk_sudm.`disabled_flag` AS 'su_fk_sudm__disabled_flag',

	su_fk_fmfiles.`id` AS 'su_fk_fmfiles__file_manager_file_id',
	su_fk_fmfiles.`user_company_id` AS 'su_fk_fmfiles__user_company_id',
	su_fk_fmfiles.`contact_id` AS 'su_fk_fmfiles__contact_id',
	su_fk_fmfiles.`project_id` AS 'su_fk_fmfiles__project_id',
	su_fk_fmfiles.`file_manager_folder_id` AS 'su_fk_fmfiles__file_manager_folder_id',
	su_fk_fmfiles.`file_location_id` AS 'su_fk_fmfiles__file_location_id',
	su_fk_fmfiles.`virtual_file_name` AS 'su_fk_fmfiles__virtual_file_name',
	su_fk_fmfiles.`version_number` AS 'su_fk_fmfiles__version_number',
	su_fk_fmfiles.`virtual_file_name_sha1` AS 'su_fk_fmfiles__virtual_file_name_sha1',
	su_fk_fmfiles.`virtual_file_mime_type` AS 'su_fk_fmfiles__virtual_file_mime_type',
	su_fk_fmfiles.`modified` AS 'su_fk_fmfiles__modified',
	su_fk_fmfiles.`created` AS 'su_fk_fmfiles__created',
	su_fk_fmfiles.`deleted_flag` AS 'su_fk_fmfiles__deleted_flag',
	su_fk_fmfiles.`directly_deleted_flag` AS 'su_fk_fmfiles__directly_deleted_flag',

	su_fk_codes.`id` AS 'su_fk_codes__cost_code_id',
	su_fk_codes.`cost_code_division_id` AS 'su_fk_codes__cost_code_division_id',
	su_fk_codes.`cost_code` AS 'su_fk_codes__cost_code',
	su_fk_codes.`cost_code_description` AS 'su_fk_codes__cost_code_description',
	su_fk_codes.`cost_code_description_abbreviation` AS 'su_fk_codes__cost_code_description_abbreviation',
	su_fk_codes.`sort_order` AS 'su_fk_codes__sort_order',
	su_fk_codes.`disabled_flag` AS 'su_fk_codes__disabled_flag',

	su_fk_creator_c.`id` AS 'su_fk_creator_c__contact_id',
	su_fk_creator_c.`user_company_id` AS 'su_fk_creator_c__user_company_id',
	su_fk_creator_c.`user_id` AS 'su_fk_creator_c__user_id',
	su_fk_creator_c.`contact_company_id` AS 'su_fk_creator_c__contact_company_id',
	su_fk_creator_c.`email` AS 'su_fk_creator_c__email',
	su_fk_creator_c.`name_prefix` AS 'su_fk_creator_c__name_prefix',
	su_fk_creator_c.`first_name` AS 'su_fk_creator_c__first_name',
	su_fk_creator_c.`additional_name` AS 'su_fk_creator_c__additional_name',
	su_fk_creator_c.`middle_name` AS 'su_fk_creator_c__middle_name',
	su_fk_creator_c.`last_name` AS 'su_fk_creator_c__last_name',
	su_fk_creator_c.`name_suffix` AS 'su_fk_creator_c__name_suffix',
	su_fk_creator_c.`title` AS 'su_fk_creator_c__title',
	su_fk_creator_c.`vendor_flag` AS 'su_fk_creator_c__vendor_flag',
	su_fk_creator_c.`is_archive` AS 'su_fk_creator_c__is_archive',

	su_fk_creator_cco.`id` AS 'su_fk_creator_cco__contact_company_office_id',
	su_fk_creator_cco.`contact_company_id` AS 'su_fk_creator_cco__contact_company_id',
	su_fk_creator_cco.`office_nickname` AS 'su_fk_creator_cco__office_nickname',
	su_fk_creator_cco.`address_line_1` AS 'su_fk_creator_cco__address_line_1',
	su_fk_creator_cco.`address_line_2` AS 'su_fk_creator_cco__address_line_2',
	su_fk_creator_cco.`address_line_3` AS 'su_fk_creator_cco__address_line_3',
	su_fk_creator_cco.`address_line_4` AS 'su_fk_creator_cco__address_line_4',
	su_fk_creator_cco.`address_city` AS 'su_fk_creator_cco__address_city',
	su_fk_creator_cco.`address_county` AS 'su_fk_creator_cco__address_county',
	su_fk_creator_cco.`address_state_or_region` AS 'su_fk_creator_cco__address_state_or_region',
	su_fk_creator_cco.`address_postal_code` AS 'su_fk_creator_cco__address_postal_code',
	su_fk_creator_cco.`address_postal_code_extension` AS 'su_fk_creator_cco__address_postal_code_extension',
	su_fk_creator_cco.`address_country` AS 'su_fk_creator_cco__address_country',
	su_fk_creator_cco.`head_quarters_flag` AS 'su_fk_creator_cco__head_quarters_flag',
	su_fk_creator_cco.`address_validated_by_user_flag` AS 'su_fk_creator_cco__address_validated_by_user_flag',
	su_fk_creator_cco.`address_validated_by_web_service_flag` AS 'su_fk_creator_cco__address_validated_by_web_service_flag',
	su_fk_creator_cco.`address_validation_by_web_service_error_flag` AS 'su_fk_creator_cco__address_validation_by_web_service_error_flag',

	su_fk_creator_phone_ccopn.`id` AS 'su_fk_creator_phone_ccopn__contact_company_office_phone_number_id',
	su_fk_creator_phone_ccopn.`contact_company_office_id` AS 'su_fk_creator_phone_ccopn__contact_company_office_id',
	su_fk_creator_phone_ccopn.`phone_number_type_id` AS 'su_fk_creator_phone_ccopn__phone_number_type_id',
	su_fk_creator_phone_ccopn.`country_code` AS 'su_fk_creator_phone_ccopn__country_code',
	su_fk_creator_phone_ccopn.`area_code` AS 'su_fk_creator_phone_ccopn__area_code',
	su_fk_creator_phone_ccopn.`prefix` AS 'su_fk_creator_phone_ccopn__prefix',
	su_fk_creator_phone_ccopn.`number` AS 'su_fk_creator_phone_ccopn__number',
	su_fk_creator_phone_ccopn.`extension` AS 'su_fk_creator_phone_ccopn__extension',
	su_fk_creator_phone_ccopn.`itu` AS 'su_fk_creator_phone_ccopn__itu',

	su_fk_creator_fax_ccopn.`id` AS 'su_fk_creator_fax_ccopn__contact_company_office_phone_number_id',
	su_fk_creator_fax_ccopn.`contact_company_office_id` AS 'su_fk_creator_fax_ccopn__contact_company_office_id',
	su_fk_creator_fax_ccopn.`phone_number_type_id` AS 'su_fk_creator_fax_ccopn__phone_number_type_id',
	su_fk_creator_fax_ccopn.`country_code` AS 'su_fk_creator_fax_ccopn__country_code',
	su_fk_creator_fax_ccopn.`area_code` AS 'su_fk_creator_fax_ccopn__area_code',
	su_fk_creator_fax_ccopn.`prefix` AS 'su_fk_creator_fax_ccopn__prefix',
	su_fk_creator_fax_ccopn.`number` AS 'su_fk_creator_fax_ccopn__number',
	su_fk_creator_fax_ccopn.`extension` AS 'su_fk_creator_fax_ccopn__extension',
	su_fk_creator_fax_ccopn.`itu` AS 'su_fk_creator_fax_ccopn__itu',

	su_fk_creator_c_mobile_cpn.`id` AS 'su_fk_creator_c_mobile_cpn__contact_phone_number_id',
	su_fk_creator_c_mobile_cpn.`contact_id` AS 'su_fk_creator_c_mobile_cpn__contact_id',
	su_fk_creator_c_mobile_cpn.`phone_number_type_id` AS 'su_fk_creator_c_mobile_cpn__phone_number_type_id',
	su_fk_creator_c_mobile_cpn.`country_code` AS 'su_fk_creator_c_mobile_cpn__country_code',
	su_fk_creator_c_mobile_cpn.`area_code` AS 'su_fk_creator_c_mobile_cpn__area_code',
	su_fk_creator_c_mobile_cpn.`prefix` AS 'su_fk_creator_c_mobile_cpn__prefix',
	su_fk_creator_c_mobile_cpn.`number` AS 'su_fk_creator_c_mobile_cpn__number',
	su_fk_creator_c_mobile_cpn.`extension` AS 'su_fk_creator_c_mobile_cpn__extension',
	su_fk_creator_c_mobile_cpn.`itu` AS 'su_fk_creator_c_mobile_cpn__itu',

	su_fk_recipient_c.`id` AS 'su_fk_recipient_c__contact_id',
	su_fk_recipient_c.`user_company_id` AS 'su_fk_recipient_c__user_company_id',
	su_fk_recipient_c.`user_id` AS 'su_fk_recipient_c__user_id',
	su_fk_recipient_c.`contact_company_id` AS 'su_fk_recipient_c__contact_company_id',
	su_fk_recipient_c.`email` AS 'su_fk_recipient_c__email',
	su_fk_recipient_c.`name_prefix` AS 'su_fk_recipient_c__name_prefix',
	su_fk_recipient_c.`first_name` AS 'su_fk_recipient_c__first_name',
	su_fk_recipient_c.`additional_name` AS 'su_fk_recipient_c__additional_name',
	su_fk_recipient_c.`middle_name` AS 'su_fk_recipient_c__middle_name',
	su_fk_recipient_c.`last_name` AS 'su_fk_recipient_c__last_name',
	su_fk_recipient_c.`name_suffix` AS 'su_fk_recipient_c__name_suffix',
	su_fk_recipient_c.`title` AS 'su_fk_recipient_c__title',
	su_fk_recipient_c.`vendor_flag` AS 'su_fk_recipient_c__vendor_flag',
	su_fk_recipient_c.`is_archive` AS 'su_fk_recipient_c__is_archive',

	su_fk_recipient_cco.`id` AS 'su_fk_recipient_cco__contact_company_office_id',
	su_fk_recipient_cco.`contact_company_id` AS 'su_fk_recipient_cco__contact_company_id',
	su_fk_recipient_cco.`office_nickname` AS 'su_fk_recipient_cco__office_nickname',
	su_fk_recipient_cco.`address_line_1` AS 'su_fk_recipient_cco__address_line_1',
	su_fk_recipient_cco.`address_line_2` AS 'su_fk_recipient_cco__address_line_2',
	su_fk_recipient_cco.`address_line_3` AS 'su_fk_recipient_cco__address_line_3',
	su_fk_recipient_cco.`address_line_4` AS 'su_fk_recipient_cco__address_line_4',
	su_fk_recipient_cco.`address_city` AS 'su_fk_recipient_cco__address_city',
	su_fk_recipient_cco.`address_county` AS 'su_fk_recipient_cco__address_county',
	su_fk_recipient_cco.`address_state_or_region` AS 'su_fk_recipient_cco__address_state_or_region',
	su_fk_recipient_cco.`address_postal_code` AS 'su_fk_recipient_cco__address_postal_code',
	su_fk_recipient_cco.`address_postal_code_extension` AS 'su_fk_recipient_cco__address_postal_code_extension',
	su_fk_recipient_cco.`address_country` AS 'su_fk_recipient_cco__address_country',
	su_fk_recipient_cco.`head_quarters_flag` AS 'su_fk_recipient_cco__head_quarters_flag',
	su_fk_recipient_cco.`address_validated_by_user_flag` AS 'su_fk_recipient_cco__address_validated_by_user_flag',
	su_fk_recipient_cco.`address_validated_by_web_service_flag` AS 'su_fk_recipient_cco__address_validated_by_web_service_flag',
	su_fk_recipient_cco.`address_validation_by_web_service_error_flag` AS 'su_fk_recipient_cco__address_validation_by_web_service_error_flag',

	su_fk_recipient_phone_ccopn.`id` AS 'su_fk_recipient_phone_ccopn__contact_company_office_phone_number_id',
	su_fk_recipient_phone_ccopn.`contact_company_office_id` AS 'su_fk_recipient_phone_ccopn__contact_company_office_id',
	su_fk_recipient_phone_ccopn.`phone_number_type_id` AS 'su_fk_recipient_phone_ccopn__phone_number_type_id',
	su_fk_recipient_phone_ccopn.`country_code` AS 'su_fk_recipient_phone_ccopn__country_code',
	su_fk_recipient_phone_ccopn.`area_code` AS 'su_fk_recipient_phone_ccopn__area_code',
	su_fk_recipient_phone_ccopn.`prefix` AS 'su_fk_recipient_phone_ccopn__prefix',
	su_fk_recipient_phone_ccopn.`number` AS 'su_fk_recipient_phone_ccopn__number',
	su_fk_recipient_phone_ccopn.`extension` AS 'su_fk_recipient_phone_ccopn__extension',
	su_fk_recipient_phone_ccopn.`itu` AS 'su_fk_recipient_phone_ccopn__itu',

	su_fk_recipient_fax_ccopn.`id` AS 'su_fk_recipient_fax_ccopn__contact_company_office_phone_number_id',
	su_fk_recipient_fax_ccopn.`contact_company_office_id` AS 'su_fk_recipient_fax_ccopn__contact_company_office_id',
	su_fk_recipient_fax_ccopn.`phone_number_type_id` AS 'su_fk_recipient_fax_ccopn__phone_number_type_id',
	su_fk_recipient_fax_ccopn.`country_code` AS 'su_fk_recipient_fax_ccopn__country_code',
	su_fk_recipient_fax_ccopn.`area_code` AS 'su_fk_recipient_fax_ccopn__area_code',
	su_fk_recipient_fax_ccopn.`prefix` AS 'su_fk_recipient_fax_ccopn__prefix',
	su_fk_recipient_fax_ccopn.`number` AS 'su_fk_recipient_fax_ccopn__number',
	su_fk_recipient_fax_ccopn.`extension` AS 'su_fk_recipient_fax_ccopn__extension',
	su_fk_recipient_fax_ccopn.`itu` AS 'su_fk_recipient_fax_ccopn__itu',

	su_fk_recipient_c_mobile_cpn.`id` AS 'su_fk_recipient_c_mobile_cpn__contact_phone_number_id',
	su_fk_recipient_c_mobile_cpn.`contact_id` AS 'su_fk_recipient_c_mobile_cpn__contact_id',
	su_fk_recipient_c_mobile_cpn.`phone_number_type_id` AS 'su_fk_recipient_c_mobile_cpn__phone_number_type_id',
	su_fk_recipient_c_mobile_cpn.`country_code` AS 'su_fk_recipient_c_mobile_cpn__country_code',
	su_fk_recipient_c_mobile_cpn.`area_code` AS 'su_fk_recipient_c_mobile_cpn__area_code',
	su_fk_recipient_c_mobile_cpn.`prefix` AS 'su_fk_recipient_c_mobile_cpn__prefix',
	su_fk_recipient_c_mobile_cpn.`number` AS 'su_fk_recipient_c_mobile_cpn__number',
	su_fk_recipient_c_mobile_cpn.`extension` AS 'su_fk_recipient_c_mobile_cpn__extension',
	su_fk_recipient_c_mobile_cpn.`itu` AS 'su_fk_recipient_c_mobile_cpn__itu',

	su_fk_initiator_c.`id` AS 'su_fk_initiator_c__contact_id',
	su_fk_initiator_c.`user_company_id` AS 'su_fk_initiator_c__user_company_id',
	su_fk_initiator_c.`user_id` AS 'su_fk_initiator_c__user_id',
	su_fk_initiator_c.`contact_company_id` AS 'su_fk_initiator_c__contact_company_id',
	su_fk_initiator_c.`email` AS 'su_fk_initiator_c__email',
	su_fk_initiator_c.`name_prefix` AS 'su_fk_initiator_c__name_prefix',
	su_fk_initiator_c.`first_name` AS 'su_fk_initiator_c__first_name',
	su_fk_initiator_c.`additional_name` AS 'su_fk_initiator_c__additional_name',
	su_fk_initiator_c.`middle_name` AS 'su_fk_initiator_c__middle_name',
	su_fk_initiator_c.`last_name` AS 'su_fk_initiator_c__last_name',
	su_fk_initiator_c.`name_suffix` AS 'su_fk_initiator_c__name_suffix',
	su_fk_initiator_c.`title` AS 'su_fk_initiator_c__title',
	su_fk_initiator_c.`vendor_flag` AS 'su_fk_initiator_c__vendor_flag',
	su_fk_initiator_c.`is_archive` AS 'su_fk_initiator_c__is_archive',

	su_fk_initiator_cco.`id` AS 'su_fk_initiator_cco__contact_company_office_id',
	su_fk_initiator_cco.`contact_company_id` AS 'su_fk_initiator_cco__contact_company_id',
	su_fk_initiator_cco.`office_nickname` AS 'su_fk_initiator_cco__office_nickname',
	su_fk_initiator_cco.`address_line_1` AS 'su_fk_initiator_cco__address_line_1',
	su_fk_initiator_cco.`address_line_2` AS 'su_fk_initiator_cco__address_line_2',
	su_fk_initiator_cco.`address_line_3` AS 'su_fk_initiator_cco__address_line_3',
	su_fk_initiator_cco.`address_line_4` AS 'su_fk_initiator_cco__address_line_4',
	su_fk_initiator_cco.`address_city` AS 'su_fk_initiator_cco__address_city',
	su_fk_initiator_cco.`address_county` AS 'su_fk_initiator_cco__address_county',
	su_fk_initiator_cco.`address_state_or_region` AS 'su_fk_initiator_cco__address_state_or_region',
	su_fk_initiator_cco.`address_postal_code` AS 'su_fk_initiator_cco__address_postal_code',
	su_fk_initiator_cco.`address_postal_code_extension` AS 'su_fk_initiator_cco__address_postal_code_extension',
	su_fk_initiator_cco.`address_country` AS 'su_fk_initiator_cco__address_country',
	su_fk_initiator_cco.`head_quarters_flag` AS 'su_fk_initiator_cco__head_quarters_flag',
	su_fk_initiator_cco.`address_validated_by_user_flag` AS 'su_fk_initiator_cco__address_validated_by_user_flag',
	su_fk_initiator_cco.`address_validated_by_web_service_flag` AS 'su_fk_initiator_cco__address_validated_by_web_service_flag',
	su_fk_initiator_cco.`address_validation_by_web_service_error_flag` AS 'su_fk_initiator_cco__address_validation_by_web_service_error_flag',

	su_fk_initiator_phone_ccopn.`id` AS 'su_fk_initiator_phone_ccopn__contact_company_office_phone_number_id',
	su_fk_initiator_phone_ccopn.`contact_company_office_id` AS 'su_fk_initiator_phone_ccopn__contact_company_office_id',
	su_fk_initiator_phone_ccopn.`phone_number_type_id` AS 'su_fk_initiator_phone_ccopn__phone_number_type_id',
	su_fk_initiator_phone_ccopn.`country_code` AS 'su_fk_initiator_phone_ccopn__country_code',
	su_fk_initiator_phone_ccopn.`area_code` AS 'su_fk_initiator_phone_ccopn__area_code',
	su_fk_initiator_phone_ccopn.`prefix` AS 'su_fk_initiator_phone_ccopn__prefix',
	su_fk_initiator_phone_ccopn.`number` AS 'su_fk_initiator_phone_ccopn__number',
	su_fk_initiator_phone_ccopn.`extension` AS 'su_fk_initiator_phone_ccopn__extension',
	su_fk_initiator_phone_ccopn.`itu` AS 'su_fk_initiator_phone_ccopn__itu',

	su_fk_initiator_fax_ccopn.`id` AS 'su_fk_initiator_fax_ccopn__contact_company_office_phone_number_id',
	su_fk_initiator_fax_ccopn.`contact_company_office_id` AS 'su_fk_initiator_fax_ccopn__contact_company_office_id',
	su_fk_initiator_fax_ccopn.`phone_number_type_id` AS 'su_fk_initiator_fax_ccopn__phone_number_type_id',
	su_fk_initiator_fax_ccopn.`country_code` AS 'su_fk_initiator_fax_ccopn__country_code',
	su_fk_initiator_fax_ccopn.`area_code` AS 'su_fk_initiator_fax_ccopn__area_code',
	su_fk_initiator_fax_ccopn.`prefix` AS 'su_fk_initiator_fax_ccopn__prefix',
	su_fk_initiator_fax_ccopn.`number` AS 'su_fk_initiator_fax_ccopn__number',
	su_fk_initiator_fax_ccopn.`extension` AS 'su_fk_initiator_fax_ccopn__extension',
	su_fk_initiator_fax_ccopn.`itu` AS 'su_fk_initiator_fax_ccopn__itu',

	su_fk_initiator_c_mobile_cpn.`id` AS 'su_fk_initiator_c_mobile_cpn__contact_phone_number_id',
	su_fk_initiator_c_mobile_cpn.`contact_id` AS 'su_fk_initiator_c_mobile_cpn__contact_id',
	su_fk_initiator_c_mobile_cpn.`phone_number_type_id` AS 'su_fk_initiator_c_mobile_cpn__phone_number_type_id',
	su_fk_initiator_c_mobile_cpn.`country_code` AS 'su_fk_initiator_c_mobile_cpn__country_code',
	su_fk_initiator_c_mobile_cpn.`area_code` AS 'su_fk_initiator_c_mobile_cpn__area_code',
	su_fk_initiator_c_mobile_cpn.`prefix` AS 'su_fk_initiator_c_mobile_cpn__prefix',
	su_fk_initiator_c_mobile_cpn.`number` AS 'su_fk_initiator_c_mobile_cpn__number',
	su_fk_initiator_c_mobile_cpn.`extension` AS 'su_fk_initiator_c_mobile_cpn__extension',
	su_fk_initiator_c_mobile_cpn.`itu` AS 'su_fk_initiator_c_mobile_cpn__itu',

	su_fk_codes__fk_ccd.`id` AS 'su_fk_codes__fk_ccd__cost_code_division_id',
	su_fk_codes__fk_ccd.`user_company_id` AS 'su_fk_codes__fk_ccd__user_company_id',
	su_fk_codes__fk_ccd.`cost_code_type_id` AS 'su_fk_codes__fk_ccd__cost_code_type_id',
	su_fk_codes__fk_ccd.`division_number` AS 'su_fk_codes__fk_ccd__division_number',
	su_fk_codes__fk_ccd.`division_code_heading` AS 'su_fk_codes__fk_ccd__division_code_heading',
	su_fk_codes__fk_ccd.`division` AS 'su_fk_codes__fk_ccd__division',
	su_fk_codes__fk_ccd.`division_abbreviation` AS 'su_fk_codes__fk_ccd__division_abbreviation',
	su_fk_codes__fk_ccd.`sort_order` AS 'su_fk_codes__fk_ccd__sort_order',
	su_fk_codes__fk_ccd.`disabled_flag` AS 'su_fk_codes__fk_ccd__disabled_flag',

	su_fk_creator_c__fk_cc.`id` AS 'su_fk_creator_c__fk_cc__contact_company_id',
	su_fk_creator_c__fk_cc.`user_user_company_id` AS 'su_fk_creator_c__fk_cc__user_user_company_id',
	su_fk_creator_c__fk_cc.`contact_user_company_id` AS 'su_fk_creator_c__fk_cc__contact_user_company_id',
	su_fk_creator_c__fk_cc.`company` AS 'su_fk_creator_c__fk_cc__company',
	su_fk_creator_c__fk_cc.`primary_phone_number` AS 'su_fk_creator_c__fk_cc__primary_phone_number',
	su_fk_creator_c__fk_cc.`employer_identification_number` AS 'su_fk_creator_c__fk_cc__employer_identification_number',
	su_fk_creator_c__fk_cc.`construction_license_number` AS 'su_fk_creator_c__fk_cc__construction_license_number',
	su_fk_creator_c__fk_cc.`construction_license_number_expiration_date` AS 'su_fk_creator_c__fk_cc__construction_license_number_expiration_date',
	su_fk_creator_c__fk_cc.`vendor_flag` AS 'su_fk_creator_c__fk_cc__vendor_flag',

	su_fk_recipient_c_fk_cc.`id` AS 'su_fk_recipient_c_fk_cc__contact_company_id',
	su_fk_recipient_c_fk_cc.`user_user_company_id` AS 'su_fk_recipient_c_fk_cc__user_user_company_id',
	su_fk_recipient_c_fk_cc.`contact_user_company_id` AS 'su_fk_recipient_c_fk_cc__contact_user_company_id',
	su_fk_recipient_c_fk_cc.`company` AS 'su_fk_recipient_c_fk_cc__company',
	su_fk_recipient_c_fk_cc.`primary_phone_number` AS 'su_fk_recipient_c_fk_cc__primary_phone_number',
	su_fk_recipient_c_fk_cc.`employer_identification_number` AS 'su_fk_recipient_c_fk_cc__employer_identification_number',
	su_fk_recipient_c_fk_cc.`construction_license_number` AS 'su_fk_recipient_c_fk_cc__construction_license_number',
	su_fk_recipient_c_fk_cc.`construction_license_number_expiration_date` AS 'su_fk_recipient_c_fk_cc__construction_license_number_expiration_date',
	su_fk_recipient_c_fk_cc.`vendor_flag` AS 'su_fk_recipient_c_fk_cc__vendor_flag',

	su_fk_initiator_c__fk_cc.`id` AS 'su_fk_initiator_c__fk_cc__contact_company_id',
	su_fk_initiator_c__fk_cc.`user_user_company_id` AS 'su_fk_initiator_c__fk_cc__user_user_company_id',
	su_fk_initiator_c__fk_cc.`contact_user_company_id` AS 'su_fk_initiator_c__fk_cc__contact_user_company_id',
	su_fk_initiator_c__fk_cc.`company` AS 'su_fk_initiator_c__fk_cc__company',
	su_fk_initiator_c__fk_cc.`primary_phone_number` AS 'su_fk_initiator_c__fk_cc__primary_phone_number',
	su_fk_initiator_c__fk_cc.`employer_identification_number` AS 'su_fk_initiator_c__fk_cc__employer_identification_number',
	su_fk_initiator_c__fk_cc.`construction_license_number` AS 'su_fk_initiator_c__fk_cc__construction_license_number',
	su_fk_initiator_c__fk_cc.`construction_license_number_expiration_date` AS 'su_fk_initiator_c__fk_cc__construction_license_number_expiration_date',
	su_fk_initiator_c__fk_cc.`vendor_flag` AS 'su_fk_initiator_c__fk_cc__vendor_flag',

	su.*

FROM `submittals` su
	INNER JOIN `projects` su_fk_p ON su.`project_id` = su_fk_p.`id`
	INNER JOIN `submittal_types` su_fk_sut ON su.`submittal_type_id` = su_fk_sut.`id`
	INNER JOIN `submittal_statuses` su_fk_sus ON su.`submittal_status_id` = su_fk_sus.`id`
	INNER JOIN `submittal_priorities` su_fk_sup ON su.`submittal_priority_id` = su_fk_sup.`id`
	INNER JOIN `submittal_distribution_methods` su_fk_sudm ON su.`submittal_distribution_method_id` = su_fk_sudm.`id`
	LEFT OUTER JOIN `file_manager_files` su_fk_fmfiles ON su.`su_file_manager_file_id` = su_fk_fmfiles.`id`
	LEFT OUTER JOIN `cost_codes` su_fk_codes ON su.`su_cost_code_id` = su_fk_codes.`id`
	INNER JOIN `contacts` su_fk_creator_c ON su.`su_creator_contact_id` = su_fk_creator_c.`id`
	LEFT OUTER JOIN `contact_company_offices` su_fk_creator_cco ON su.`su_creator_contact_company_office_id` = su_fk_creator_cco.`id`
	LEFT OUTER JOIN `contact_company_office_phone_numbers` su_fk_creator_phone_ccopn ON su.`su_creator_phone_contact_company_office_phone_number_id` = su_fk_creator_phone_ccopn.`id`
	LEFT OUTER JOIN `contact_company_office_phone_numbers` su_fk_creator_fax_ccopn ON su.`su_creator_fax_contact_company_office_phone_number_id` = su_fk_creator_fax_ccopn.`id`
	LEFT OUTER JOIN `contact_phone_numbers` su_fk_creator_c_mobile_cpn ON su.`su_creator_contact_mobile_phone_number_id` = su_fk_creator_c_mobile_cpn.`id`
	LEFT OUTER JOIN `contacts` su_fk_recipient_c ON su.`su_recipient_contact_id` = su_fk_recipient_c.`id`
	LEFT OUTER JOIN `contact_company_offices` su_fk_recipient_cco ON su.`su_recipient_contact_company_office_id` = su_fk_recipient_cco.`id`
	LEFT OUTER JOIN `contact_company_office_phone_numbers` su_fk_recipient_phone_ccopn ON su.`su_recipient_phone_contact_company_office_phone_number_id` = su_fk_recipient_phone_ccopn.`id`
	LEFT OUTER JOIN `contact_company_office_phone_numbers` su_fk_recipient_fax_ccopn ON su.`su_recipient_fax_contact_company_office_phone_number_id` = su_fk_recipient_fax_ccopn.`id`
	LEFT OUTER JOIN `contact_phone_numbers` su_fk_recipient_c_mobile_cpn ON su.`su_recipient_contact_mobile_phone_number_id` = su_fk_recipient_c_mobile_cpn.`id`
	LEFT OUTER JOIN `contacts` su_fk_initiator_c ON su.`su_initiator_contact_id` = su_fk_initiator_c.`id`
	LEFT OUTER JOIN `contact_company_offices` su_fk_initiator_cco ON su.`su_initiator_contact_company_office_id` = su_fk_initiator_cco.`id`
	LEFT OUTER JOIN `contact_company_office_phone_numbers` su_fk_initiator_phone_ccopn ON su.`su_initiator_phone_contact_company_office_phone_number_id` = su_fk_initiator_phone_ccopn.`id`
	LEFT OUTER JOIN `contact_company_office_phone_numbers` su_fk_initiator_fax_ccopn ON su.`su_initiator_fax_contact_company_office_phone_number_id` = su_fk_initiator_fax_ccopn.`id`
	LEFT OUTER JOIN `contact_phone_numbers` su_fk_initiator_c_mobile_cpn ON su.`su_initiator_contact_mobile_phone_number_id` = su_fk_initiator_c_mobile_cpn.`id`

	LEFT OUTER JOIN `cost_code_divisions` su_fk_codes__fk_ccd ON su_fk_codes.`cost_code_division_id` = su_fk_codes__fk_ccd.`id`

	INNER JOIN `contact_companies` su_fk_creator_c__fk_cc ON su_fk_creator_c.`contact_company_id` = su_fk_creator_c__fk_cc.`id`
	LEFT OUTER JOIN `contact_companies` su_fk_recipient_c_fk_cc ON su_fk_recipient_c.`contact_company_id` = su_fk_recipient_c_fk_cc.`id`
	LEFT OUTER JOIN `contact_companies` su_fk_initiator_c__fk_cc ON su_fk_initiator_c.`contact_company_id` = su_fk_initiator_c__fk_cc.`id`

WHERE su.`id` = ?
";
		$arrValues = array($submittal_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$submittal_id = $row['id'];
			$submittal = self::instantiateOrm($database, 'Submittal', $row, null, $submittal_id);
			/* @var $submittal Submittal */
			$submittal->convertPropertiesToData();

			if (isset($row['project_id'])) {
				$project_id = $row['project_id'];
				$row['su_fk_p__id'] = $project_id;
				$project = self::instantiateOrm($database, 'Project', $row, null, $project_id, 'su_fk_p__');
				/* @var $project Project */
				$project->convertPropertiesToData();
			} else {
				$project = false;
			}
			$submittal->setProject($project);

			if (isset($row['submittal_type_id'])) {
				$submittal_type_id = $row['submittal_type_id'];
				$row['su_fk_sut__id'] = $submittal_type_id;
				$submittalType = self::instantiateOrm($database, 'SubmittalType', $row, null, $submittal_type_id, 'su_fk_sut__');
				/* @var $submittalType SubmittalType */
				$submittalType->convertPropertiesToData();
			} else {
				$submittalType = false;
			}
			$submittal->setSubmittalType($submittalType);

			if (isset($row['submittal_status_id'])) {
				$submittal_status_id = $row['submittal_status_id'];
				$row['su_fk_sus__id'] = $submittal_status_id;
				$submittalStatus = self::instantiateOrm($database, 'SubmittalStatus', $row, null, $submittal_status_id, 'su_fk_sus__');
				/* @var $submittalStatus SubmittalStatus */
				$submittalStatus->convertPropertiesToData();
			} else {
				$submittalStatus = false;
			}
			$submittal->setSubmittalStatus($submittalStatus);

			if (isset($row['submittal_priority_id'])) {
				$submittal_priority_id = $row['submittal_priority_id'];
				$row['su_fk_sup__id'] = $submittal_priority_id;
				$submittalPriority = self::instantiateOrm($database, 'SubmittalPriority', $row, null, $submittal_priority_id, 'su_fk_sup__');
				/* @var $submittalPriority SubmittalPriority */
				$submittalPriority->convertPropertiesToData();
			} else {
				$submittalPriority = false;
			}
			$submittal->setSubmittalPriority($submittalPriority);

			if (isset($row['submittal_distribution_method_id'])) {
				$submittal_distribution_method_id = $row['submittal_distribution_method_id'];
				$row['su_fk_sudm__id'] = $submittal_distribution_method_id;
				$submittalDistributionMethod = self::instantiateOrm($database, 'SubmittalDistributionMethod', $row, null, $submittal_distribution_method_id, 'su_fk_sudm__');
				/* @var $submittalDistributionMethod SubmittalDistributionMethod */
				$submittalDistributionMethod->convertPropertiesToData();
			} else {
				$submittalDistributionMethod = false;
			}
			$submittal->setSubmittalDistributionMethod($submittalDistributionMethod);

			if (isset($row['su_file_manager_file_id'])) {
				$su_file_manager_file_id = $row['su_file_manager_file_id'];
				$row['su_fk_fmfiles__id'] = $su_file_manager_file_id;
				$suFileManagerFile = self::instantiateOrm($database, 'FileManagerFile', $row, null, $su_file_manager_file_id, 'su_fk_fmfiles__');
				/* @var $suFileManagerFile FileManagerFile */
				$suFileManagerFile->convertPropertiesToData();
			} else {
				$suFileManagerFile = false;
			}
			$submittal->setSuFileManagerFile($suFileManagerFile);

			if (isset($row['su_cost_code_id'])) {
				$su_cost_code_id = $row['su_cost_code_id'];
				$row['su_fk_codes__id'] = $su_cost_code_id;
				$suCostCode = self::instantiateOrm($database, 'CostCode', $row, null, $su_cost_code_id, 'su_fk_codes__');
				/* @var $suCostCode CostCode */
				$suCostCode->convertPropertiesToData();
			} else {
				$suCostCode = false;
			}
			$submittal->setSuCostCode($suCostCode);

			if (isset($row['su_creator_contact_id'])) {
				$su_creator_contact_id = $row['su_creator_contact_id'];
				$row['su_fk_creator_c__id'] = $su_creator_contact_id;
				$suCreatorContact = self::instantiateOrm($database, 'Contact', $row, null, $su_creator_contact_id, 'su_fk_creator_c__');
				/* @var $suCreatorContact Contact */
				$suCreatorContact->convertPropertiesToData();
			} else {
				$suCreatorContact = false;
			}
			$submittal->setSuCreatorContact($suCreatorContact);

			if (isset($row['su_creator_contact_company_office_id'])) {
				$su_creator_contact_company_office_id = $row['su_creator_contact_company_office_id'];
				$row['su_fk_creator_cco__id'] = $su_creator_contact_company_office_id;
				$suCreatorContactCompanyOffice = self::instantiateOrm($database, 'ContactCompanyOffice', $row, null, $su_creator_contact_company_office_id, 'su_fk_creator_cco__');
				/* @var $suCreatorContactCompanyOffice ContactCompanyOffice */
				$suCreatorContactCompanyOffice->convertPropertiesToData();
			} else {
				$suCreatorContactCompanyOffice = false;
			}
			$submittal->setSuCreatorContactCompanyOffice($suCreatorContactCompanyOffice);

			if (isset($row['su_creator_phone_contact_company_office_phone_number_id'])) {
				$su_creator_phone_contact_company_office_phone_number_id = $row['su_creator_phone_contact_company_office_phone_number_id'];
				$row['su_fk_creator_phone_ccopn__id'] = $su_creator_phone_contact_company_office_phone_number_id;
				$suCreatorPhoneContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $su_creator_phone_contact_company_office_phone_number_id, 'su_fk_creator_phone_ccopn__');
				/* @var $suCreatorPhoneContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$suCreatorPhoneContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$suCreatorPhoneContactCompanyOfficePhoneNumber = false;
			}
			$submittal->setSuCreatorPhoneContactCompanyOfficePhoneNumber($suCreatorPhoneContactCompanyOfficePhoneNumber);

			if (isset($row['su_creator_fax_contact_company_office_phone_number_id'])) {
				$su_creator_fax_contact_company_office_phone_number_id = $row['su_creator_fax_contact_company_office_phone_number_id'];
				$row['su_fk_creator_fax_ccopn__id'] = $su_creator_fax_contact_company_office_phone_number_id;
				$suCreatorFaxContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $su_creator_fax_contact_company_office_phone_number_id, 'su_fk_creator_fax_ccopn__');
				/* @var $suCreatorFaxContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$suCreatorFaxContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$suCreatorFaxContactCompanyOfficePhoneNumber = false;
			}
			$submittal->setSuCreatorFaxContactCompanyOfficePhoneNumber($suCreatorFaxContactCompanyOfficePhoneNumber);

			if (isset($row['su_creator_contact_mobile_phone_number_id'])) {
				$su_creator_contact_mobile_phone_number_id = $row['su_creator_contact_mobile_phone_number_id'];
				$row['su_fk_creator_c_mobile_cpn__id'] = $su_creator_contact_mobile_phone_number_id;
				$suCreatorContactMobilePhoneNumber = self::instantiateOrm($database, 'ContactPhoneNumber', $row, null, $su_creator_contact_mobile_phone_number_id, 'su_fk_creator_c_mobile_cpn__');
				/* @var $suCreatorContactMobilePhoneNumber ContactPhoneNumber */
				$suCreatorContactMobilePhoneNumber->convertPropertiesToData();
			} else {
				$suCreatorContactMobilePhoneNumber = false;
			}
			$submittal->setSuCreatorContactMobilePhoneNumber($suCreatorContactMobilePhoneNumber);

			if (isset($row['su_recipient_contact_id'])) {
				$su_recipient_contact_id = $row['su_recipient_contact_id'];
				$row['su_fk_recipient_c__id'] = $su_recipient_contact_id;
				$suRecipientContact = self::instantiateOrm($database, 'Contact', $row, null, $su_recipient_contact_id, 'su_fk_recipient_c__');
				/* @var $suRecipientContact Contact */
				$suRecipientContact->convertPropertiesToData();
			} else {
				$suRecipientContact = false;
			}
			$submittal->setSuRecipientContact($suRecipientContact);

			if (isset($row['su_recipient_contact_company_office_id'])) {
				$su_recipient_contact_company_office_id = $row['su_recipient_contact_company_office_id'];
				$row['su_fk_recipient_cco__id'] = $su_recipient_contact_company_office_id;
				$suRecipientContactCompanyOffice = self::instantiateOrm($database, 'ContactCompanyOffice', $row, null, $su_recipient_contact_company_office_id, 'su_fk_recipient_cco__');
				/* @var $suRecipientContactCompanyOffice ContactCompanyOffice */
				$suRecipientContactCompanyOffice->convertPropertiesToData();
			} else {
				$suRecipientContactCompanyOffice = false;
			}
			$submittal->setSuRecipientContactCompanyOffice($suRecipientContactCompanyOffice);

			if (isset($row['su_recipient_phone_contact_company_office_phone_number_id'])) {
				$su_recipient_phone_contact_company_office_phone_number_id = $row['su_recipient_phone_contact_company_office_phone_number_id'];
				$row['su_fk_recipient_phone_ccopn__id'] = $su_recipient_phone_contact_company_office_phone_number_id;
				$suRecipientPhoneContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $su_recipient_phone_contact_company_office_phone_number_id, 'su_fk_recipient_phone_ccopn__');
				/* @var $suRecipientPhoneContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$suRecipientPhoneContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$suRecipientPhoneContactCompanyOfficePhoneNumber = false;
			}
			$submittal->setSuRecipientPhoneContactCompanyOfficePhoneNumber($suRecipientPhoneContactCompanyOfficePhoneNumber);

			if (isset($row['su_recipient_fax_contact_company_office_phone_number_id'])) {
				$su_recipient_fax_contact_company_office_phone_number_id = $row['su_recipient_fax_contact_company_office_phone_number_id'];
				$row['su_fk_recipient_fax_ccopn__id'] = $su_recipient_fax_contact_company_office_phone_number_id;
				$suRecipientFaxContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $su_recipient_fax_contact_company_office_phone_number_id, 'su_fk_recipient_fax_ccopn__');
				/* @var $suRecipientFaxContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$suRecipientFaxContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$suRecipientFaxContactCompanyOfficePhoneNumber = false;
			}
			$submittal->setSuRecipientFaxContactCompanyOfficePhoneNumber($suRecipientFaxContactCompanyOfficePhoneNumber);

			if (isset($row['su_recipient_contact_mobile_phone_number_id'])) {
				$su_recipient_contact_mobile_phone_number_id = $row['su_recipient_contact_mobile_phone_number_id'];
				$row['su_fk_recipient_c_mobile_cpn__id'] = $su_recipient_contact_mobile_phone_number_id;
				$suRecipientContactMobilePhoneNumber = self::instantiateOrm($database, 'ContactPhoneNumber', $row, null, $su_recipient_contact_mobile_phone_number_id, 'su_fk_recipient_c_mobile_cpn__');
				/* @var $suRecipientContactMobilePhoneNumber ContactPhoneNumber */
				$suRecipientContactMobilePhoneNumber->convertPropertiesToData();
			} else {
				$suRecipientContactMobilePhoneNumber = false;
			}
			$submittal->setSuRecipientContactMobilePhoneNumber($suRecipientContactMobilePhoneNumber);

			if (isset($row['su_initiator_contact_id'])) {
				$su_initiator_contact_id = $row['su_initiator_contact_id'];
				$row['su_fk_initiator_c__id'] = $su_initiator_contact_id;
				$suInitiatorContact = self::instantiateOrm($database, 'Contact', $row, null, $su_initiator_contact_id, 'su_fk_initiator_c__');
				/* @var $suInitiatorContact Contact */
				$suInitiatorContact->convertPropertiesToData();
			} else {
				$suInitiatorContact = false;
			}
			$submittal->setSuInitiatorContact($suInitiatorContact);

			if (isset($row['su_initiator_contact_company_office_id'])) {
				$su_initiator_contact_company_office_id = $row['su_initiator_contact_company_office_id'];
				$row['su_fk_initiator_cco__id'] = $su_initiator_contact_company_office_id;
				$suInitiatorContactCompanyOffice = self::instantiateOrm($database, 'ContactCompanyOffice', $row, null, $su_initiator_contact_company_office_id, 'su_fk_initiator_cco__');
				/* @var $suInitiatorContactCompanyOffice ContactCompanyOffice */
				$suInitiatorContactCompanyOffice->convertPropertiesToData();
			} else {
				$suInitiatorContactCompanyOffice = false;
			}
			$submittal->setSuInitiatorContactCompanyOffice($suInitiatorContactCompanyOffice);

			if (isset($row['su_initiator_phone_contact_company_office_phone_number_id'])) {
				$su_initiator_phone_contact_company_office_phone_number_id = $row['su_initiator_phone_contact_company_office_phone_number_id'];
				$row['su_fk_initiator_phone_ccopn__id'] = $su_initiator_phone_contact_company_office_phone_number_id;
				$suInitiatorPhoneContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $su_initiator_phone_contact_company_office_phone_number_id, 'su_fk_initiator_phone_ccopn__');
				/* @var $suInitiatorPhoneContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$suInitiatorPhoneContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$suInitiatorPhoneContactCompanyOfficePhoneNumber = false;
			}
			$submittal->setSuInitiatorPhoneContactCompanyOfficePhoneNumber($suInitiatorPhoneContactCompanyOfficePhoneNumber);

			if (isset($row['su_initiator_fax_contact_company_office_phone_number_id'])) {
				$su_initiator_fax_contact_company_office_phone_number_id = $row['su_initiator_fax_contact_company_office_phone_number_id'];
				$row['su_fk_initiator_fax_ccopn__id'] = $su_initiator_fax_contact_company_office_phone_number_id;
				$suInitiatorFaxContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $su_initiator_fax_contact_company_office_phone_number_id, 'su_fk_initiator_fax_ccopn__');
				/* @var $suInitiatorFaxContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$suInitiatorFaxContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$suInitiatorFaxContactCompanyOfficePhoneNumber = false;
			}
			$submittal->setSuInitiatorFaxContactCompanyOfficePhoneNumber($suInitiatorFaxContactCompanyOfficePhoneNumber);

			if (isset($row['su_initiator_contact_mobile_phone_number_id'])) {
				$su_initiator_contact_mobile_phone_number_id = $row['su_initiator_contact_mobile_phone_number_id'];
				$row['su_fk_initiator_c_mobile_cpn__id'] = $su_initiator_contact_mobile_phone_number_id;
				$suInitiatorContactMobilePhoneNumber = self::instantiateOrm($database, 'ContactPhoneNumber', $row, null, $su_initiator_contact_mobile_phone_number_id, 'su_fk_initiator_c_mobile_cpn__');
				/* @var $suInitiatorContactMobilePhoneNumber ContactPhoneNumber */
				$suInitiatorContactMobilePhoneNumber->convertPropertiesToData();
			} else {
				$suInitiatorContactMobilePhoneNumber = false;
			}
			$submittal->setSuInitiatorContactMobilePhoneNumber($suInitiatorContactMobilePhoneNumber);

			// Extra: Submittal Cost Code - Cost Code Division
			if (isset($row['su_fk_codes__fk_ccd__cost_code_division_id'])) {
				$cost_code_division_id = $row['su_fk_codes__fk_ccd__cost_code_division_id'];
				$row['su_fk_codes__fk_ccd__id'] = $cost_code_division_id;
				$suCostCodeDivision = self::instantiateOrm($database, 'CostCodeDivision', $row, null, $cost_code_division_id, 'su_fk_codes__fk_ccd__');
				/* @var $suCostCodeDivision CostCodeDivision */
				$suCostCodeDivision->convertPropertiesToData();
			} else {
				$suCostCodeDivision = false;
			}
			if ($suCostCode) {
				$suCostCode->setCostCodeDivision($suCostCodeDivision);
			}

			// Extra: Submittal Creator - Contact Company
			if (isset($row['su_fk_creator_c__fk_cc__contact_company_id'])) {
				$su_creator_contact_company_id = $row['su_fk_creator_c__fk_cc__contact_company_id'];
				$row['su_fk_creator_c__fk_cc__id'] = $su_creator_contact_company_id;
				$suCreatorContactCompany = self::instantiateOrm($database, 'ContactCompany', $row, null, $su_creator_contact_company_id, 'su_fk_creator_c__fk_cc__');
				/* @var $suCreatorContactCompany ContactCompany */
				$suCreatorContactCompany->convertPropertiesToData();
			} else {
				$suCreatorContactCompany = false;
			}
			if ($suCreatorContact) {
				$suCreatorContact->setContactCompany($suCreatorContactCompany);
			}

			// Extra: Submittal Recipient - Contact Company
			if (isset($row['su_fk_recipient_c_fk_cc__contact_company_id'])) {
				$su_recipient_contact_company_id = $row['su_fk_recipient_c_fk_cc__contact_company_id'];
				$row['su_fk_recipient_c_fk_cc__id'] = $su_recipient_contact_company_id;
				$suRecipientContactCompany = self::instantiateOrm($database, 'ContactCompany', $row, null, $su_recipient_contact_company_id, 'su_fk_recipient_c_fk_cc__');
				/* @var $suRecipientContactCompany ContactCompany */
				$suRecipientContactCompany->convertPropertiesToData();
			} else {
				$suRecipientContactCompany = false;
			}
			if ($suRecipientContact) {
				$suRecipientContact->setContactCompany($suRecipientContactCompany);
			}

			// Extra: Submittal Initiator - Contact Company
			if (isset($row['su_fk_initiator_c_fk_cc__contact_company_id'])) {
				$su_initiator_contact_company_id = $row['su_fk_initiator_c_fk_cc__contact_company_id'];
				$row['su_fk_initiator_c_fk_cc__id'] = $su_initiator_contact_company_id;
				$suInitiatorContactCompany = self::instantiateOrm($database, 'ContactCompany', $row, null, $su_initiator_contact_company_id, 'su_fk_initiator_c_fk_cc__');
				/* @var $suInitiatorContactCompany ContactCompany */
				$suInitiatorContactCompany->convertPropertiesToData();
			} else {
				$suInitiatorContactCompany = false;
			}
			if ($suInitiatorContact) {
				$suInitiatorContact->setContactCompany($suInitiatorContactCompany);
			}

			return $submittal;
		} else {
			return false;
		}
	}

	// Finders: Find By Unique Index
	/**
	 * Find by unique index `unique_su` (`project_id`,`su_sequence_number`) comment 'One Project can have many Submittals with a sequence number.'.
	 *
	 * @param string $database
	 * @param int $project_id
	 * @param int $su_sequence_number
	 * @return mixed (single ORM object | false)
	 */
	public static function findByProjectIdAndSuSequenceNumber($database, $project_id, $su_sequence_number)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	su.*

FROM `submittals` su
WHERE su.`project_id` = ?
AND su.`su_sequence_number` = ?
";
		$arrValues = array($project_id, $su_sequence_number);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if ($row && !empty($row)) {
			$submittal_id = $row['id'];
			$submittal = self::instantiateOrm($database, 'Submittal', $row, null, $submittal_id);
			/* @var $submittal Submittal */
			return $submittal;
		} else {
			return false;
		}
	}

	// Loaders: Load By pk List (list of auto int ids or other non auto int pk list)
	/**
	 * Load zero or more records by an id list (array of auto int primary keys).
	 *
	 * @param string $database
	 * @param array $arrSubmittalIds
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubmittalsByArrSubmittalIds($database, $arrSubmittalIds, Input $options=null)
	{
		if (empty($arrSubmittalIds)) {
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
		// ORDER BY `id` ASC, `project_id` ASC, `su_sequence_number` ASC, `submittal_type_id` ASC, `submittal_status_id` ASC, `submittal_priority_id` ASC, `su_file_manager_file_id` ASC, `su_cost_code_id` ASC, `su_creator_contact_id` ASC, `su_creator_contact_company_office_id` ASC, `su_creator_phone_contact_company_office_phone_number_id` ASC, `su_creator_fax_contact_company_office_phone_number_id` ASC, `su_creator_contact_mobile_phone_number_id` ASC, `su_recipient_contact_id` ASC, `su_recipient_contact_company_office_id` ASC, `su_recipient_phone_contact_company_office_phone_number_id` ASC, `su_recipient_fax_contact_company_office_phone_number_id` ASC, `su_recipient_contact_mobile_phone_number_id` ASC, `su_initiator_contact_id` ASC, `su_initiator_contact_company_office_id` ASC, `su_initiator_phone_contact_company_office_phone_number_id` ASC, `su_initiator_fax_contact_company_office_phone_number_id` ASC, `su_initiator_contact_mobile_phone_number_id` ASC, `su_title` ASC, `su_plan_page_reference` ASC, `su_statement` ASC, `created` ASC, `su_due_date` ASC, `su_closed_date` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubmittal = new Submittal($database);
			$sqlOrderByColumns = $tmpSubmittal->constructSqlOrderByColumns($arrOrderByAttributes);

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

		foreach ($arrSubmittalIds as $k => $submittal_id) {
			$submittal_id = (int) $submittal_id;
			$arrSubmittalIds[$k] = $db->escape($submittal_id);
		}
		$csvSubmittalIds = join(',', $arrSubmittalIds);

		$query =
"
SELECT

	su.*

FROM `submittals` su
WHERE su.`id` IN ($csvSubmittalIds){$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		$arrSubmittalsByCsvSubmittalIds = array();
		while ($row = $db->fetch()) {
			$submittal_id = $row['id'];
			$submittal = self::instantiateOrm($database, 'Submittal', $row, null, $submittal_id);
			/* @var $submittal Submittal */
			$submittal->convertPropertiesToData();

			$arrSubmittalsByCsvSubmittalIds[$submittal_id] = $submittal;
		}

		$db->free_result();

		return $arrSubmittalsByCsvSubmittalIds;
	}
// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `submittals_fk_p` foreign key (`project_id`) references `projects` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $project_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubmittalsByProjectIdAndDate($database, $project_id, Input $options=null,$new_begindate,$Endate)
	{
		
		$forceLoadFlag = false;
		$whereCause = '';
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

			if ($options->whereFlag && $options->whereQuery) {
				$whereCause = $options->whereQuery;
			}
		}

		if ($forceLoadFlag) {
			self::$_arrSubmittalsByProjectId = null;
		}

		$arrSubmittalsByProjectId = self::$_arrSubmittalsByProjectId;
		if (isset($arrSubmittalsByProjectId) && !empty($arrSubmittalsByProjectId)) {
			return $arrSubmittalsByProjectId;
		}

		$project_id = (int) $project_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

	
		$sqlOrderBy = "\nORDER BY `created` DESC, `su_sequence_number` DESC, `submittal_priority_id` ASC, `submittal_type_id` ASC, `submittal_status_id` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubmittal = new Submittal($database);
			$sqlOrderByColumns = $tmpSubmittal->constructSqlOrderByColumns($arrOrderByAttributes);

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

		$query="
		SELECT su_fk_sut.`submittal_type` AS 'su_fk_sut__submittal_type', su_fk_sut.`disabled_flag` AS 'su_fk_sut__disabled_flag', su_fk_sus.`id` AS 'su_fk_sus__submittal_status_id', su_fk_sus.`submittal_status` AS 'su_fk_sus__submittal_status', su_fk_sus.`disabled_flag` AS 'su_fk_sus__disabled_flag', su_fk_sup.`id` AS 'su_fk_sup__submittal_priority_id', su_fk_sup.`submittal_priority` AS 'su_fk_sup__submittal_priority', su_fk_sup.`disabled_flag` AS 'su_fk_sup__disabled_flag', su_fk_sudm.`id` AS 'su_fk_sudm__submittal_distribution_method_id', su_fk_sudm.`submittal_distribution_method` AS 'su_fk_sudm__submittal_distribution_method', su_fk_sudm.`disabled_flag` AS 'su_fk_sudm__disabled_flag',su_fk_recipient_c.`id` AS 'su_fk_recipient_c__contact_id', su_fk_recipient_c.`user_company_id` AS 'su_fk_recipient_c__user_company_id', su_fk_recipient_c.`user_id` AS 'su_fk_recipient_c__user_id', su_fk_recipient_c.`contact_company_id` AS 'su_fk_recipient_c__contact_company_id', su_fk_recipient_c.`email` AS 'su_fk_recipient_c__email', su_fk_recipient_c.`name_prefix` AS 'su_fk_recipient_c__name_prefix', su_fk_recipient_c.`first_name` AS 'su_fk_recipient_c__first_name', su_fk_recipient_c.`additional_name` AS 'su_fk_recipient_c__additional_name', su_fk_recipient_c.`middle_name` AS 'su_fk_recipient_c__middle_name', su_fk_recipient_c.`last_name` AS 'su_fk_recipient_c__last_name', su_fk_recipient_c.`name_suffix` AS 'su_fk_recipient_c__name_suffix', su_fk_recipient_c.`title` AS 'su_fk_recipient_c__title', su_fk_recipient_c.`vendor_flag` AS 'su_fk_recipient_c__vendor_flag',        su.*
		FROM `submittals` su
		INNER JOIN `submittal_types` su_fk_sut ON su.`submittal_type_id` = su_fk_sut.`id`
		INNER JOIN `submittal_statuses` su_fk_sus ON su.`submittal_status_id` = su_fk_sus.`id`
		INNER JOIN `submittal_priorities` su_fk_sup ON su.`submittal_priority_id` = su_fk_sup.`id`
		INNER JOIN `submittal_distribution_methods` su_fk_sudm ON su.`submittal_distribution_method_id` = su_fk_sudm.`id`
		LEFT OUTER JOIN `contacts` su_fk_recipient_c ON su.`su_recipient_contact_id` = su_fk_recipient_c.`id`
		WHERE su.`project_id` = ? 
		AND date(su.created) BETWEEN '$new_begindate' AND '$Endate'
		{$whereCause}
		{$sqlOrderBy}{$sqlLimit}";

		$arrValues = array($project_id);

		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubmittalsByProjectId = array();
		while ($row = $db->fetch()) {
			$submittal_id = $row['id'];
			$submittal = self::instantiateOrm($database, 'Submittal', $row, null, $submittal_id);
			/* @var $submittal Submittal */
			$submittal->convertPropertiesToData();

			if (isset($row['project_id'])) {
				$project_id = $row['project_id'];
				$row['su_fk_p__id'] = $project_id;
				$project = self::instantiateOrm($database, 'Project', $row, null, $project_id, 'su_fk_p__');
				/* @var $project Project */
				$project->convertPropertiesToData();
			} else {
				$project = false;
			}
			$submittal->setProject($project);

			if (isset($row['submittal_type_id'])) {
				$submittal_type_id = $row['submittal_type_id'];
				$row['su_fk_sut__id'] = $submittal_type_id;
				$submittalType = self::instantiateOrm($database, 'SubmittalType', $row, null, $submittal_type_id, 'su_fk_sut__');
				/* @var $submittalType SubmittalType */
				$submittalType->convertPropertiesToData();
			} else {
				$submittalType = false;
			}
			$submittal->setSubmittalType($submittalType);

			if (isset($row['submittal_status_id'])) {
				$submittal_status_id = $row['submittal_status_id'];
				$row['su_fk_sus__id'] = $submittal_status_id;
				$submittalStatus = self::instantiateOrm($database, 'SubmittalStatus', $row, null, $submittal_status_id, 'su_fk_sus__');
				/* @var $submittalStatus SubmittalStatus */
				$submittalStatus->convertPropertiesToData();
			} else {
				$submittalStatus = false;
			}
			$submittal->setSubmittalStatus($submittalStatus);

			if (isset($row['submittal_priority_id'])) {
				$submittal_priority_id = $row['submittal_priority_id'];
				$row['su_fk_sup__id'] = $submittal_priority_id;
				$submittalPriority = self::instantiateOrm($database, 'SubmittalPriority', $row, null, $submittal_priority_id, 'su_fk_sup__');
				/* @var $submittalPriority SubmittalPriority */
				$submittalPriority->convertPropertiesToData();
			} else {
				$submittalPriority = false;
			}
			$submittal->setSubmittalPriority($submittalPriority);

			if (isset($row['submittal_distribution_method_id'])) {
				$submittal_distribution_method_id = $row['submittal_distribution_method_id'];
				$row['su_fk_sudm__id'] = $submittal_distribution_method_id;
				$submittalDistributionMethod = self::instantiateOrm($database, 'SubmittalDistributionMethod', $row, null, $submittal_distribution_method_id, 'su_fk_sudm__');
				/* @var $submittalDistributionMethod SubmittalDistributionMethod */
				$submittalDistributionMethod->convertPropertiesToData();
			} else {
				$submittalDistributionMethod = false;
			}
			$submittal->setSubmittalDistributionMethod($submittalDistributionMethod);

			if (isset($row['su_file_manager_file_id'])) {
				$su_file_manager_file_id = $row['su_file_manager_file_id'];
				$row['su_fk_fmfiles__id'] = $su_file_manager_file_id;
				$suFileManagerFile = self::instantiateOrm($database, 'FileManagerFile', $row, null, $su_file_manager_file_id, 'su_fk_fmfiles__');
				/* @var $suFileManagerFile FileManagerFile */
				$suFileManagerFile->convertPropertiesToData();
			} else {
				$suFileManagerFile = false;
			}
			$submittal->setSuFileManagerFile($suFileManagerFile);

			if (isset($row['su_cost_code_id'])) {
				$su_cost_code_id = $row['su_cost_code_id'];
				$row['su_fk_codes__id'] = $su_cost_code_id;
				$suCostCode = self::instantiateOrm($database, 'CostCode', $row, null, $su_cost_code_id, 'su_fk_codes__');
				/* @var $suCostCode CostCode */
				$suCostCode->convertPropertiesToData();
			} else {
				$suCostCode = false;
			}
			$submittal->setSuCostCode($suCostCode);

			if (isset($row['su_creator_contact_id'])) {
				$su_creator_contact_id = $row['su_creator_contact_id'];
				$row['su_fk_creator_c__id'] = $su_creator_contact_id;
				$suCreatorContact = self::instantiateOrm($database, 'Contact', $row, null, $su_creator_contact_id, 'su_fk_creator_c__');
				/* @var $suCreatorContact Contact */
				$suCreatorContact->convertPropertiesToData();
			} else {
				$suCreatorContact = false;
			}
			$submittal->setSuCreatorContact($suCreatorContact);

			if (isset($row['su_creator_contact_company_office_id'])) {
				$su_creator_contact_company_office_id = $row['su_creator_contact_company_office_id'];
				$row['su_fk_creator_cco__id'] = $su_creator_contact_company_office_id;
				$suCreatorContactCompanyOffice = self::instantiateOrm($database, 'ContactCompanyOffice', $row, null, $su_creator_contact_company_office_id, 'su_fk_creator_cco__');
				/* @var $suCreatorContactCompanyOffice ContactCompanyOffice */
				$suCreatorContactCompanyOffice->convertPropertiesToData();
			} else {
				$suCreatorContactCompanyOffice = false;
			}
			$submittal->setSuCreatorContactCompanyOffice($suCreatorContactCompanyOffice);

			if (isset($row['su_creator_phone_contact_company_office_phone_number_id'])) {
				$su_creator_phone_contact_company_office_phone_number_id = $row['su_creator_phone_contact_company_office_phone_number_id'];
				$row['su_fk_creator_phone_ccopn__id'] = $su_creator_phone_contact_company_office_phone_number_id;
				$suCreatorPhoneContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $su_creator_phone_contact_company_office_phone_number_id, 'su_fk_creator_phone_ccopn__');
				/* @var $suCreatorPhoneContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$suCreatorPhoneContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$suCreatorPhoneContactCompanyOfficePhoneNumber = false;
			}
			$submittal->setSuCreatorPhoneContactCompanyOfficePhoneNumber($suCreatorPhoneContactCompanyOfficePhoneNumber);

			if (isset($row['su_creator_fax_contact_company_office_phone_number_id'])) {
				$su_creator_fax_contact_company_office_phone_number_id = $row['su_creator_fax_contact_company_office_phone_number_id'];
				$row['su_fk_creator_fax_ccopn__id'] = $su_creator_fax_contact_company_office_phone_number_id;
				$suCreatorFaxContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $su_creator_fax_contact_company_office_phone_number_id, 'su_fk_creator_fax_ccopn__');
				/* @var $suCreatorFaxContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$suCreatorFaxContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$suCreatorFaxContactCompanyOfficePhoneNumber = false;
			}
			$submittal->setSuCreatorFaxContactCompanyOfficePhoneNumber($suCreatorFaxContactCompanyOfficePhoneNumber);

			if (isset($row['su_creator_contact_mobile_phone_number_id'])) {
				$su_creator_contact_mobile_phone_number_id = $row['su_creator_contact_mobile_phone_number_id'];
				$row['su_fk_creator_c_mobile_cpn__id'] = $su_creator_contact_mobile_phone_number_id;
				$suCreatorContactMobilePhoneNumber = self::instantiateOrm($database, 'ContactPhoneNumber', $row, null, $su_creator_contact_mobile_phone_number_id, 'su_fk_creator_c_mobile_cpn__');
				/* @var $suCreatorContactMobilePhoneNumber ContactPhoneNumber */
				$suCreatorContactMobilePhoneNumber->convertPropertiesToData();
			} else {
				$suCreatorContactMobilePhoneNumber = false;
			}
			$submittal->setSuCreatorContactMobilePhoneNumber($suCreatorContactMobilePhoneNumber);

			if (isset($row['su_recipient_contact_id'])) {
				$su_recipient_contact_id = $row['su_recipient_contact_id'];
				$row['su_fk_recipient_c__id'] = $su_recipient_contact_id;
				$suRecipientContact = self::instantiateOrm($database, 'Contact', $row, null, $su_recipient_contact_id, 'su_fk_recipient_c__');
				/* @var $suRecipientContact Contact */
				$suRecipientContact->convertPropertiesToData();
			} else {
				$suRecipientContact = false;
			}
			$submittal->setSuRecipientContact($suRecipientContact);

			if (isset($row['su_recipient_contact_company_office_id'])) {
				$su_recipient_contact_company_office_id = $row['su_recipient_contact_company_office_id'];
				$row['su_fk_recipient_cco__id'] = $su_recipient_contact_company_office_id;
				$suRecipientContactCompanyOffice = self::instantiateOrm($database, 'ContactCompanyOffice', $row, null, $su_recipient_contact_company_office_id, 'su_fk_recipient_cco__');
				/* @var $suRecipientContactCompanyOffice ContactCompanyOffice */
				$suRecipientContactCompanyOffice->convertPropertiesToData();
			} else {
				$suRecipientContactCompanyOffice = false;
			}
			$submittal->setSuRecipientContactCompanyOffice($suRecipientContactCompanyOffice);

			if (isset($row['su_recipient_phone_contact_company_office_phone_number_id'])) {
				$su_recipient_phone_contact_company_office_phone_number_id = $row['su_recipient_phone_contact_company_office_phone_number_id'];
				$row['su_fk_recipient_phone_ccopn__id'] = $su_recipient_phone_contact_company_office_phone_number_id;
				$suRecipientPhoneContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $su_recipient_phone_contact_company_office_phone_number_id, 'su_fk_recipient_phone_ccopn__');
				/* @var $suRecipientPhoneContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$suRecipientPhoneContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$suRecipientPhoneContactCompanyOfficePhoneNumber = false;
			}
			$submittal->setSuRecipientPhoneContactCompanyOfficePhoneNumber($suRecipientPhoneContactCompanyOfficePhoneNumber);

			if (isset($row['su_recipient_fax_contact_company_office_phone_number_id'])) {
				$su_recipient_fax_contact_company_office_phone_number_id = $row['su_recipient_fax_contact_company_office_phone_number_id'];
				$row['su_fk_recipient_fax_ccopn__id'] = $su_recipient_fax_contact_company_office_phone_number_id;
				$suRecipientFaxContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $su_recipient_fax_contact_company_office_phone_number_id, 'su_fk_recipient_fax_ccopn__');
				/* @var $suRecipientFaxContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$suRecipientFaxContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$suRecipientFaxContactCompanyOfficePhoneNumber = false;
			}
			$submittal->setSuRecipientFaxContactCompanyOfficePhoneNumber($suRecipientFaxContactCompanyOfficePhoneNumber);

			if (isset($row['su_recipient_contact_mobile_phone_number_id'])) {
				$su_recipient_contact_mobile_phone_number_id = $row['su_recipient_contact_mobile_phone_number_id'];
				$row['su_fk_recipient_c_mobile_cpn__id'] = $su_recipient_contact_mobile_phone_number_id;
				$suRecipientContactMobilePhoneNumber = self::instantiateOrm($database, 'ContactPhoneNumber', $row, null, $su_recipient_contact_mobile_phone_number_id, 'su_fk_recipient_c_mobile_cpn__');
				/* @var $suRecipientContactMobilePhoneNumber ContactPhoneNumber */
				$suRecipientContactMobilePhoneNumber->convertPropertiesToData();
			} else {
				$suRecipientContactMobilePhoneNumber = false;
			}
			$submittal->setSuRecipientContactMobilePhoneNumber($suRecipientContactMobilePhoneNumber);

			if (isset($row['su_initiator_contact_id'])) {
				$su_initiator_contact_id = $row['su_initiator_contact_id'];
				$row['su_fk_initiator_c__id'] = $su_initiator_contact_id;
				$suInitiatorContact = self::instantiateOrm($database, 'Contact', $row, null, $su_initiator_contact_id, 'su_fk_initiator_c__');
				/* @var $suInitiatorContact Contact */
				$suInitiatorContact->convertPropertiesToData();
			} else {
				$suInitiatorContact = false;
			}
			$submittal->setSuInitiatorContact($suInitiatorContact);

			if (isset($row['su_initiator_contact_company_office_id'])) {
				$su_initiator_contact_company_office_id = $row['su_initiator_contact_company_office_id'];
				$row['su_fk_initiator_cco__id'] = $su_initiator_contact_company_office_id;
				$suInitiatorContactCompanyOffice = self::instantiateOrm($database, 'ContactCompanyOffice', $row, null, $su_initiator_contact_company_office_id, 'su_fk_initiator_cco__');
				/* @var $suInitiatorContactCompanyOffice ContactCompanyOffice */
				$suInitiatorContactCompanyOffice->convertPropertiesToData();
			} else {
				$suInitiatorContactCompanyOffice = false;
			}
			$submittal->setSuInitiatorContactCompanyOffice($suInitiatorContactCompanyOffice);

			if (isset($row['su_initiator_phone_contact_company_office_phone_number_id'])) {
				$su_initiator_phone_contact_company_office_phone_number_id = $row['su_initiator_phone_contact_company_office_phone_number_id'];
				$row['su_fk_initiator_phone_ccopn__id'] = $su_initiator_phone_contact_company_office_phone_number_id;
				$suInitiatorPhoneContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $su_initiator_phone_contact_company_office_phone_number_id, 'su_fk_initiator_phone_ccopn__');
				/* @var $suInitiatorPhoneContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$suInitiatorPhoneContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$suInitiatorPhoneContactCompanyOfficePhoneNumber = false;
			}
			$submittal->setSuInitiatorPhoneContactCompanyOfficePhoneNumber($suInitiatorPhoneContactCompanyOfficePhoneNumber);

			if (isset($row['su_initiator_fax_contact_company_office_phone_number_id'])) {
				$su_initiator_fax_contact_company_office_phone_number_id = $row['su_initiator_fax_contact_company_office_phone_number_id'];
				$row['su_fk_initiator_fax_ccopn__id'] = $su_initiator_fax_contact_company_office_phone_number_id;
				$suInitiatorFaxContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $su_initiator_fax_contact_company_office_phone_number_id, 'su_fk_initiator_fax_ccopn__');
				/* @var $suInitiatorFaxContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$suInitiatorFaxContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$suInitiatorFaxContactCompanyOfficePhoneNumber = false;
			}
			$submittal->setSuInitiatorFaxContactCompanyOfficePhoneNumber($suInitiatorFaxContactCompanyOfficePhoneNumber);

			if (isset($row['su_initiator_contact_mobile_phone_number_id'])) {
				$su_initiator_contact_mobile_phone_number_id = $row['su_initiator_contact_mobile_phone_number_id'];
				$row['su_fk_initiator_c_mobile_cpn__id'] = $su_initiator_contact_mobile_phone_number_id;
				$suInitiatorContactMobilePhoneNumber = self::instantiateOrm($database, 'ContactPhoneNumber', $row, null, $su_initiator_contact_mobile_phone_number_id, 'su_fk_initiator_c_mobile_cpn__');
				/* @var $suInitiatorContactMobilePhoneNumber ContactPhoneNumber */
				$suInitiatorContactMobilePhoneNumber->convertPropertiesToData();
			} else {
				$suInitiatorContactMobilePhoneNumber = false;
			}
			$submittal->setSuInitiatorContactMobilePhoneNumber($suInitiatorContactMobilePhoneNumber);

			$arrSubmittalsByProjectId[$submittal_id] = $submittal;
		}

		$db->free_result();

		self::$_arrSubmittalsByProjectId = $arrSubmittalsByProjectId;

		return $arrSubmittalsByProjectId;
	}
	/**
	 * Load by constraint `submittals_fk_p` foreign key (`project_id`) references `projects` (`id`) on delete cascade on update cascade.For Report jobstatus
	 *
	 * @param string $database
	 * @param int $project_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubmittalsByProjectIdAndIdIn($database, $project_id, Input $options=null, $WhereIn)
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
			self::$_arrSubmittalsByProjectId = null;
		}

		$arrSubmittalsByProjectId = self::$_arrSubmittalsByProjectId;
		if (isset($arrSubmittalsByProjectId) && !empty($arrSubmittalsByProjectId)) {
			return $arrSubmittalsByProjectId;
		}

		$project_id = (int) $project_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

	
		$sqlOrderBy = "\nORDER BY `created` DESC, `su_sequence_number` DESC, `submittal_priority_id` ASC, `submittal_type_id` ASC, `submittal_status_id` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubmittal = new Submittal($database);
			$sqlOrderByColumns = $tmpSubmittal->constructSqlOrderByColumns($arrOrderByAttributes);

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
		$db->free_result();
		$query=" SELECT su_fk_sut.`submittal_type` AS 'su_fk_sut__submittal_type', su_fk_sut.`disabled_flag` AS 'su_fk_sut__disabled_flag', su_fk_sus.`id` AS 'su_fk_sus__submittal_status_id', su_fk_sus.`submittal_status` AS 'su_fk_sus__submittal_status', su_fk_sus.`disabled_flag` AS 'su_fk_sus__disabled_flag', su_fk_sup.`id` AS 'su_fk_sup__submittal_priority_id', su_fk_sup.`submittal_priority` AS 'su_fk_sup__submittal_priority', su_fk_sup.`disabled_flag` AS 'su_fk_sup__disabled_flag', su_fk_sudm.`id` AS 'su_fk_sudm__submittal_distribution_method_id', su_fk_sudm.`submittal_distribution_method` AS 'su_fk_sudm__submittal_distribution_method', su_fk_sudm.`disabled_flag` AS 'su_fk_sudm__disabled_flag',su_fk_recipient_c.`id` AS 'su_fk_recipient_c__contact_id', su_fk_recipient_c.`user_company_id` AS 'su_fk_recipient_c__user_company_id', su_fk_recipient_c.`user_id` AS 'su_fk_recipient_c__user_id', su_fk_recipient_c.`contact_company_id` AS 'su_fk_recipient_c__contact_company_id', su_fk_recipient_c.`email` AS 'su_fk_recipient_c__email', su_fk_recipient_c.`name_prefix` AS 'su_fk_recipient_c__name_prefix', su_fk_recipient_c.`first_name` AS 'su_fk_recipient_c__first_name', su_fk_recipient_c.`additional_name` AS 'su_fk_recipient_c__additional_name', su_fk_recipient_c.`middle_name` AS 'su_fk_recipient_c__middle_name', su_fk_recipient_c.`last_name` AS 'su_fk_recipient_c__last_name', su_fk_recipient_c.`name_suffix` AS 'su_fk_recipient_c__name_suffix', su_fk_recipient_c.`title` AS 'su_fk_recipient_c__title', su_fk_recipient_c.`vendor_flag` AS 'su_fk_recipient_c__vendor_flag',su_fk_recipient_c.`is_archive` AS 'su_fk_recipient_c__is_archive',        su.* FROM `submittals` su  INNER JOIN `submittal_types` su_fk_sut ON su.`submittal_type_id` = su_fk_sut.`id` INNER JOIN `submittal_statuses` su_fk_sus ON su.`submittal_status_id` = su_fk_sus.`id` INNER JOIN `submittal_priorities` su_fk_sup ON su.`submittal_priority_id` = su_fk_sup.`id` INNER JOIN `submittal_distribution_methods` su_fk_sudm ON su.`submittal_distribution_method_id` = su_fk_sudm.`id` LEFT OUTER JOIN `contacts` su_fk_recipient_c ON su.`su_recipient_contact_id` = su_fk_recipient_c.`id`  WHERE su.`project_id` = ? and su.`submittal_status_id` = 5 and su.id IN($WhereIn) {$sqlOrderBy}{$sqlLimit}";

		$arrValues = array($project_id);

		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubmittalsByProjectId = array();
		while ($row = $db->fetch()) {
			$submittal_id = $row['id'];
			$submittal = self::instantiateOrm($database, 'Submittal', $row, null, $submittal_id);
			/* @var $submittal Submittal */
			$submittal->convertPropertiesToData();

			if (isset($row['project_id'])) {
				$project_id = $row['project_id'];
				$row['su_fk_p__id'] = $project_id;
				$project = self::instantiateOrm($database, 'Project', $row, null, $project_id, 'su_fk_p__');
				/* @var $project Project */
				$project->convertPropertiesToData();
			} else {
				$project = false;
			}
			$submittal->setProject($project);

			if (isset($row['submittal_type_id'])) {
				$submittal_type_id = $row['submittal_type_id'];
				$row['su_fk_sut__id'] = $submittal_type_id;
				$submittalType = self::instantiateOrm($database, 'SubmittalType', $row, null, $submittal_type_id, 'su_fk_sut__');
				/* @var $submittalType SubmittalType */
				$submittalType->convertPropertiesToData();
			} else {
				$submittalType = false;
			}
			$submittal->setSubmittalType($submittalType);

			if (isset($row['submittal_status_id'])) {
				$submittal_status_id = $row['submittal_status_id'];
				$row['su_fk_sus__id'] = $submittal_status_id;
				$submittalStatus = self::instantiateOrm($database, 'SubmittalStatus', $row, null, $submittal_status_id, 'su_fk_sus__');
				/* @var $submittalStatus SubmittalStatus */
				$submittalStatus->convertPropertiesToData();
			} else {
				$submittalStatus = false;
			}
			$submittal->setSubmittalStatus($submittalStatus);

			if (isset($row['submittal_priority_id'])) {
				$submittal_priority_id = $row['submittal_priority_id'];
				$row['su_fk_sup__id'] = $submittal_priority_id;
				$submittalPriority = self::instantiateOrm($database, 'SubmittalPriority', $row, null, $submittal_priority_id, 'su_fk_sup__');
				/* @var $submittalPriority SubmittalPriority */
				$submittalPriority->convertPropertiesToData();
			} else {
				$submittalPriority = false;
			}
			$submittal->setSubmittalPriority($submittalPriority);

			if (isset($row['submittal_distribution_method_id'])) {
				$submittal_distribution_method_id = $row['submittal_distribution_method_id'];
				$row['su_fk_sudm__id'] = $submittal_distribution_method_id;
				$submittalDistributionMethod = self::instantiateOrm($database, 'SubmittalDistributionMethod', $row, null, $submittal_distribution_method_id, 'su_fk_sudm__');
				/* @var $submittalDistributionMethod SubmittalDistributionMethod */
				$submittalDistributionMethod->convertPropertiesToData();
			} else {
				$submittalDistributionMethod = false;
			}
			$submittal->setSubmittalDistributionMethod($submittalDistributionMethod);

			if (isset($row['su_file_manager_file_id'])) {
				$su_file_manager_file_id = $row['su_file_manager_file_id'];
				$row['su_fk_fmfiles__id'] = $su_file_manager_file_id;
				$suFileManagerFile = self::instantiateOrm($database, 'FileManagerFile', $row, null, $su_file_manager_file_id, 'su_fk_fmfiles__');
				/* @var $suFileManagerFile FileManagerFile */
				$suFileManagerFile->convertPropertiesToData();
			} else {
				$suFileManagerFile = false;
			}
			$submittal->setSuFileManagerFile($suFileManagerFile);

			if (isset($row['su_cost_code_id'])) {
				$su_cost_code_id = $row['su_cost_code_id'];
				$row['su_fk_codes__id'] = $su_cost_code_id;
				$suCostCode = self::instantiateOrm($database, 'CostCode', $row, null, $su_cost_code_id, 'su_fk_codes__');
				/* @var $suCostCode CostCode */
				$suCostCode->convertPropertiesToData();
			} else {
				$suCostCode = false;
			}
			$submittal->setSuCostCode($suCostCode);

			if (isset($row['su_creator_contact_id'])) {
				$su_creator_contact_id = $row['su_creator_contact_id'];
				$row['su_fk_creator_c__id'] = $su_creator_contact_id;
				$suCreatorContact = self::instantiateOrm($database, 'Contact', $row, null, $su_creator_contact_id, 'su_fk_creator_c__');
				/* @var $suCreatorContact Contact */
				$suCreatorContact->convertPropertiesToData();
			} else {
				$suCreatorContact = false;
			}
			$submittal->setSuCreatorContact($suCreatorContact);

			if (isset($row['su_creator_contact_company_office_id'])) {
				$su_creator_contact_company_office_id = $row['su_creator_contact_company_office_id'];
				$row['su_fk_creator_cco__id'] = $su_creator_contact_company_office_id;
				$suCreatorContactCompanyOffice = self::instantiateOrm($database, 'ContactCompanyOffice', $row, null, $su_creator_contact_company_office_id, 'su_fk_creator_cco__');
				/* @var $suCreatorContactCompanyOffice ContactCompanyOffice */
				$suCreatorContactCompanyOffice->convertPropertiesToData();
			} else {
				$suCreatorContactCompanyOffice = false;
			}
			$submittal->setSuCreatorContactCompanyOffice($suCreatorContactCompanyOffice);

			if (isset($row['su_creator_phone_contact_company_office_phone_number_id'])) {
				$su_creator_phone_contact_company_office_phone_number_id = $row['su_creator_phone_contact_company_office_phone_number_id'];
				$row['su_fk_creator_phone_ccopn__id'] = $su_creator_phone_contact_company_office_phone_number_id;
				$suCreatorPhoneContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $su_creator_phone_contact_company_office_phone_number_id, 'su_fk_creator_phone_ccopn__');
				/* @var $suCreatorPhoneContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$suCreatorPhoneContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$suCreatorPhoneContactCompanyOfficePhoneNumber = false;
			}
			$submittal->setSuCreatorPhoneContactCompanyOfficePhoneNumber($suCreatorPhoneContactCompanyOfficePhoneNumber);

			if (isset($row['su_creator_fax_contact_company_office_phone_number_id'])) {
				$su_creator_fax_contact_company_office_phone_number_id = $row['su_creator_fax_contact_company_office_phone_number_id'];
				$row['su_fk_creator_fax_ccopn__id'] = $su_creator_fax_contact_company_office_phone_number_id;
				$suCreatorFaxContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $su_creator_fax_contact_company_office_phone_number_id, 'su_fk_creator_fax_ccopn__');
				/* @var $suCreatorFaxContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$suCreatorFaxContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$suCreatorFaxContactCompanyOfficePhoneNumber = false;
			}
			$submittal->setSuCreatorFaxContactCompanyOfficePhoneNumber($suCreatorFaxContactCompanyOfficePhoneNumber);

			if (isset($row['su_creator_contact_mobile_phone_number_id'])) {
				$su_creator_contact_mobile_phone_number_id = $row['su_creator_contact_mobile_phone_number_id'];
				$row['su_fk_creator_c_mobile_cpn__id'] = $su_creator_contact_mobile_phone_number_id;
				$suCreatorContactMobilePhoneNumber = self::instantiateOrm($database, 'ContactPhoneNumber', $row, null, $su_creator_contact_mobile_phone_number_id, 'su_fk_creator_c_mobile_cpn__');
				/* @var $suCreatorContactMobilePhoneNumber ContactPhoneNumber */
				$suCreatorContactMobilePhoneNumber->convertPropertiesToData();
			} else {
				$suCreatorContactMobilePhoneNumber = false;
			}
			$submittal->setSuCreatorContactMobilePhoneNumber($suCreatorContactMobilePhoneNumber);

			if (isset($row['su_recipient_contact_id'])) {
				$su_recipient_contact_id = $row['su_recipient_contact_id'];
				$row['su_fk_recipient_c__id'] = $su_recipient_contact_id;
				$suRecipientContact = self::instantiateOrm($database, 'Contact', $row, null, $su_recipient_contact_id, 'su_fk_recipient_c__');
				/* @var $suRecipientContact Contact */
				$suRecipientContact->convertPropertiesToData();
			} else {
				$suRecipientContact = false;
			}
			$submittal->setSuRecipientContact($suRecipientContact);

			if (isset($row['su_recipient_contact_company_office_id'])) {
				$su_recipient_contact_company_office_id = $row['su_recipient_contact_company_office_id'];
				$row['su_fk_recipient_cco__id'] = $su_recipient_contact_company_office_id;
				$suRecipientContactCompanyOffice = self::instantiateOrm($database, 'ContactCompanyOffice', $row, null, $su_recipient_contact_company_office_id, 'su_fk_recipient_cco__');
				/* @var $suRecipientContactCompanyOffice ContactCompanyOffice */
				$suRecipientContactCompanyOffice->convertPropertiesToData();
			} else {
				$suRecipientContactCompanyOffice = false;
			}
			$submittal->setSuRecipientContactCompanyOffice($suRecipientContactCompanyOffice);

			if (isset($row['su_recipient_phone_contact_company_office_phone_number_id'])) {
				$su_recipient_phone_contact_company_office_phone_number_id = $row['su_recipient_phone_contact_company_office_phone_number_id'];
				$row['su_fk_recipient_phone_ccopn__id'] = $su_recipient_phone_contact_company_office_phone_number_id;
				$suRecipientPhoneContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $su_recipient_phone_contact_company_office_phone_number_id, 'su_fk_recipient_phone_ccopn__');
				/* @var $suRecipientPhoneContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$suRecipientPhoneContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$suRecipientPhoneContactCompanyOfficePhoneNumber = false;
			}
			$submittal->setSuRecipientPhoneContactCompanyOfficePhoneNumber($suRecipientPhoneContactCompanyOfficePhoneNumber);

			if (isset($row['su_recipient_fax_contact_company_office_phone_number_id'])) {
				$su_recipient_fax_contact_company_office_phone_number_id = $row['su_recipient_fax_contact_company_office_phone_number_id'];
				$row['su_fk_recipient_fax_ccopn__id'] = $su_recipient_fax_contact_company_office_phone_number_id;
				$suRecipientFaxContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $su_recipient_fax_contact_company_office_phone_number_id, 'su_fk_recipient_fax_ccopn__');
				/* @var $suRecipientFaxContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$suRecipientFaxContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$suRecipientFaxContactCompanyOfficePhoneNumber = false;
			}
			$submittal->setSuRecipientFaxContactCompanyOfficePhoneNumber($suRecipientFaxContactCompanyOfficePhoneNumber);

			if (isset($row['su_recipient_contact_mobile_phone_number_id'])) {
				$su_recipient_contact_mobile_phone_number_id = $row['su_recipient_contact_mobile_phone_number_id'];
				$row['su_fk_recipient_c_mobile_cpn__id'] = $su_recipient_contact_mobile_phone_number_id;
				$suRecipientContactMobilePhoneNumber = self::instantiateOrm($database, 'ContactPhoneNumber', $row, null, $su_recipient_contact_mobile_phone_number_id, 'su_fk_recipient_c_mobile_cpn__');
				/* @var $suRecipientContactMobilePhoneNumber ContactPhoneNumber */
				$suRecipientContactMobilePhoneNumber->convertPropertiesToData();
			} else {
				$suRecipientContactMobilePhoneNumber = false;
			}
			$submittal->setSuRecipientContactMobilePhoneNumber($suRecipientContactMobilePhoneNumber);

			if (isset($row['su_initiator_contact_id'])) {
				$su_initiator_contact_id = $row['su_initiator_contact_id'];
				$row['su_fk_initiator_c__id'] = $su_initiator_contact_id;
				$suInitiatorContact = self::instantiateOrm($database, 'Contact', $row, null, $su_initiator_contact_id, 'su_fk_initiator_c__');
				/* @var $suInitiatorContact Contact */
				$suInitiatorContact->convertPropertiesToData();
			} else {
				$suInitiatorContact = false;
			}
			$submittal->setSuInitiatorContact($suInitiatorContact);

			if (isset($row['su_initiator_contact_company_office_id'])) {
				$su_initiator_contact_company_office_id = $row['su_initiator_contact_company_office_id'];
				$row['su_fk_initiator_cco__id'] = $su_initiator_contact_company_office_id;
				$suInitiatorContactCompanyOffice = self::instantiateOrm($database, 'ContactCompanyOffice', $row, null, $su_initiator_contact_company_office_id, 'su_fk_initiator_cco__');
				/* @var $suInitiatorContactCompanyOffice ContactCompanyOffice */
				$suInitiatorContactCompanyOffice->convertPropertiesToData();
			} else {
				$suInitiatorContactCompanyOffice = false;
			}
			$submittal->setSuInitiatorContactCompanyOffice($suInitiatorContactCompanyOffice);

			if (isset($row['su_initiator_phone_contact_company_office_phone_number_id'])) {
				$su_initiator_phone_contact_company_office_phone_number_id = $row['su_initiator_phone_contact_company_office_phone_number_id'];
				$row['su_fk_initiator_phone_ccopn__id'] = $su_initiator_phone_contact_company_office_phone_number_id;
				$suInitiatorPhoneContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $su_initiator_phone_contact_company_office_phone_number_id, 'su_fk_initiator_phone_ccopn__');
				/* @var $suInitiatorPhoneContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$suInitiatorPhoneContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$suInitiatorPhoneContactCompanyOfficePhoneNumber = false;
			}
			$submittal->setSuInitiatorPhoneContactCompanyOfficePhoneNumber($suInitiatorPhoneContactCompanyOfficePhoneNumber);

			if (isset($row['su_initiator_fax_contact_company_office_phone_number_id'])) {
				$su_initiator_fax_contact_company_office_phone_number_id = $row['su_initiator_fax_contact_company_office_phone_number_id'];
				$row['su_fk_initiator_fax_ccopn__id'] = $su_initiator_fax_contact_company_office_phone_number_id;
				$suInitiatorFaxContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $su_initiator_fax_contact_company_office_phone_number_id, 'su_fk_initiator_fax_ccopn__');
				/* @var $suInitiatorFaxContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$suInitiatorFaxContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$suInitiatorFaxContactCompanyOfficePhoneNumber = false;
			}
			$submittal->setSuInitiatorFaxContactCompanyOfficePhoneNumber($suInitiatorFaxContactCompanyOfficePhoneNumber);

			if (isset($row['su_initiator_contact_mobile_phone_number_id'])) {
				$su_initiator_contact_mobile_phone_number_id = $row['su_initiator_contact_mobile_phone_number_id'];
				$row['su_fk_initiator_c_mobile_cpn__id'] = $su_initiator_contact_mobile_phone_number_id;
				$suInitiatorContactMobilePhoneNumber = self::instantiateOrm($database, 'ContactPhoneNumber', $row, null, $su_initiator_contact_mobile_phone_number_id, 'su_fk_initiator_c_mobile_cpn__');
				/* @var $suInitiatorContactMobilePhoneNumber ContactPhoneNumber */
				$suInitiatorContactMobilePhoneNumber->convertPropertiesToData();
			} else {
				$suInitiatorContactMobilePhoneNumber = false;
			}
			$submittal->setSuInitiatorContactMobilePhoneNumber($suInitiatorContactMobilePhoneNumber);

			$arrSubmittalsByProjectId[$submittal_id] = $submittal;
		}

		$db->free_result();

		self::$_arrSubmittalsByProjectId = $arrSubmittalsByProjectId;

		return $arrSubmittalsByProjectId;
	}
	/**
	 * Load by constraint `submittals_fk_p` foreign key (`project_id`) references `projects` (`id`) on delete cascade on update cascade.For Report jobstatus
	 *
	 * @param string $database
	 * @param int $project_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubmittalsByProjectIdAndDateOpen($database, $project_id, Input $options=null,$new_begindate,$Endate)
	{
		
		$forceLoadFlag = false;
		$whereCause = '';
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

			if ($options->whereFlag && $options->whereQuery) {
				$whereCause = $options->whereQuery;
			}
		}

		if ($forceLoadFlag) {
			self::$_arrSubmittalsByProjectId = null;
		}

		$arrSubmittalsByProjectId = self::$_arrSubmittalsByProjectId;
		if (isset($arrSubmittalsByProjectId) && !empty($arrSubmittalsByProjectId)) {
			return $arrSubmittalsByProjectId;
		}

		$project_id = (int) $project_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

	
		$sqlOrderBy = "\nORDER BY `created` DESC, `su_sequence_number` DESC, `submittal_priority_id` ASC, `submittal_type_id` ASC, `submittal_status_id` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubmittal = new Submittal($database);
			$sqlOrderByColumns = $tmpSubmittal->constructSqlOrderByColumns($arrOrderByAttributes);

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

		$query=" SELECT su_fk_sut.`submittal_type` AS 'su_fk_sut__submittal_type', su_fk_sut.`disabled_flag` AS 'su_fk_sut__disabled_flag', su_fk_sus.`id` AS 'su_fk_sus__submittal_status_id', su_fk_sus.`submittal_status` AS 'su_fk_sus__submittal_status', su_fk_sus.`disabled_flag` AS 'su_fk_sus__disabled_flag', su_fk_sup.`id` AS 'su_fk_sup__submittal_priority_id', su_fk_sup.`submittal_priority` AS 'su_fk_sup__submittal_priority', su_fk_sup.`disabled_flag` AS 'su_fk_sup__disabled_flag', su_fk_sudm.`id` AS 'su_fk_sudm__submittal_distribution_method_id', su_fk_sudm.`submittal_distribution_method` AS 'su_fk_sudm__submittal_distribution_method', su_fk_sudm.`disabled_flag` AS 'su_fk_sudm__disabled_flag',su_fk_recipient_c.`id` AS 'su_fk_recipient_c__contact_id', su_fk_recipient_c.`user_company_id` AS 'su_fk_recipient_c__user_company_id', su_fk_recipient_c.`user_id` AS 'su_fk_recipient_c__user_id', su_fk_recipient_c.`contact_company_id` AS 'su_fk_recipient_c__contact_company_id', su_fk_recipient_c.`email` AS 'su_fk_recipient_c__email', su_fk_recipient_c.`name_prefix` AS 'su_fk_recipient_c__name_prefix', su_fk_recipient_c.`first_name` AS 'su_fk_recipient_c__first_name', su_fk_recipient_c.`additional_name` AS 'su_fk_recipient_c__additional_name', su_fk_recipient_c.`middle_name` AS 'su_fk_recipient_c__middle_name', su_fk_recipient_c.`last_name` AS 'su_fk_recipient_c__last_name', su_fk_recipient_c.`name_suffix` AS 'su_fk_recipient_c__name_suffix', su_fk_recipient_c.`title` AS 'su_fk_recipient_c__title', su_fk_recipient_c.`vendor_flag` AS 'su_fk_recipient_c__vendor_flag',        su.* FROM `submittals` su  INNER JOIN `submittal_types` su_fk_sut ON su.`submittal_type_id` = su_fk_sut.`id` INNER JOIN `submittal_statuses` su_fk_sus ON su.`submittal_status_id` = su_fk_sus.`id` INNER JOIN `submittal_priorities` su_fk_sup ON su.`submittal_priority_id` = su_fk_sup.`id` INNER JOIN `submittal_distribution_methods` su_fk_sudm ON su.`submittal_distribution_method_id` = su_fk_sudm.`id` LEFT OUTER JOIN `contacts` su_fk_recipient_c ON su.`su_recipient_contact_id` = su_fk_recipient_c.`id`  WHERE su.`project_id` = ? and su.`submittal_status_id` = 5 and date(su.created) between '$new_begindate' and '$Endate' {$whereCause} {$sqlOrderBy}{$sqlLimit}";

		$arrValues = array($project_id);

		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubmittalsByProjectId = array();
		while ($row = $db->fetch()) {
			$submittal_id = $row['id'];
			$submittal = self::instantiateOrm($database, 'Submittal', $row, null, $submittal_id);
			/* @var $submittal Submittal */
			$submittal->convertPropertiesToData();

			if (isset($row['project_id'])) {
				$project_id = $row['project_id'];
				$row['su_fk_p__id'] = $project_id;
				$project = self::instantiateOrm($database, 'Project', $row, null, $project_id, 'su_fk_p__');
				/* @var $project Project */
				$project->convertPropertiesToData();
			} else {
				$project = false;
			}
			$submittal->setProject($project);

			if (isset($row['submittal_type_id'])) {
				$submittal_type_id = $row['submittal_type_id'];
				$row['su_fk_sut__id'] = $submittal_type_id;
				$submittalType = self::instantiateOrm($database, 'SubmittalType', $row, null, $submittal_type_id, 'su_fk_sut__');
				/* @var $submittalType SubmittalType */
				$submittalType->convertPropertiesToData();
			} else {
				$submittalType = false;
			}
			$submittal->setSubmittalType($submittalType);

			if (isset($row['submittal_status_id'])) {
				$submittal_status_id = $row['submittal_status_id'];
				$row['su_fk_sus__id'] = $submittal_status_id;
				$submittalStatus = self::instantiateOrm($database, 'SubmittalStatus', $row, null, $submittal_status_id, 'su_fk_sus__');
				/* @var $submittalStatus SubmittalStatus */
				$submittalStatus->convertPropertiesToData();
			} else {
				$submittalStatus = false;
			}
			$submittal->setSubmittalStatus($submittalStatus);

			if (isset($row['submittal_priority_id'])) {
				$submittal_priority_id = $row['submittal_priority_id'];
				$row['su_fk_sup__id'] = $submittal_priority_id;
				$submittalPriority = self::instantiateOrm($database, 'SubmittalPriority', $row, null, $submittal_priority_id, 'su_fk_sup__');
				/* @var $submittalPriority SubmittalPriority */
				$submittalPriority->convertPropertiesToData();
			} else {
				$submittalPriority = false;
			}
			$submittal->setSubmittalPriority($submittalPriority);

			if (isset($row['submittal_distribution_method_id'])) {
				$submittal_distribution_method_id = $row['submittal_distribution_method_id'];
				$row['su_fk_sudm__id'] = $submittal_distribution_method_id;
				$submittalDistributionMethod = self::instantiateOrm($database, 'SubmittalDistributionMethod', $row, null, $submittal_distribution_method_id, 'su_fk_sudm__');
				/* @var $submittalDistributionMethod SubmittalDistributionMethod */
				$submittalDistributionMethod->convertPropertiesToData();
			} else {
				$submittalDistributionMethod = false;
			}
			$submittal->setSubmittalDistributionMethod($submittalDistributionMethod);

			if (isset($row['su_file_manager_file_id'])) {
				$su_file_manager_file_id = $row['su_file_manager_file_id'];
				$row['su_fk_fmfiles__id'] = $su_file_manager_file_id;
				$suFileManagerFile = self::instantiateOrm($database, 'FileManagerFile', $row, null, $su_file_manager_file_id, 'su_fk_fmfiles__');
				/* @var $suFileManagerFile FileManagerFile */
				$suFileManagerFile->convertPropertiesToData();
			} else {
				$suFileManagerFile = false;
			}
			$submittal->setSuFileManagerFile($suFileManagerFile);

			if (isset($row['su_cost_code_id'])) {
				$su_cost_code_id = $row['su_cost_code_id'];
				$row['su_fk_codes__id'] = $su_cost_code_id;
				$suCostCode = self::instantiateOrm($database, 'CostCode', $row, null, $su_cost_code_id, 'su_fk_codes__');
				/* @var $suCostCode CostCode */
				$suCostCode->convertPropertiesToData();
			} else {
				$suCostCode = false;
			}
			$submittal->setSuCostCode($suCostCode);

			if (isset($row['su_creator_contact_id'])) {
				$su_creator_contact_id = $row['su_creator_contact_id'];
				$row['su_fk_creator_c__id'] = $su_creator_contact_id;
				$suCreatorContact = self::instantiateOrm($database, 'Contact', $row, null, $su_creator_contact_id, 'su_fk_creator_c__');
				/* @var $suCreatorContact Contact */
				$suCreatorContact->convertPropertiesToData();
			} else {
				$suCreatorContact = false;
			}
			$submittal->setSuCreatorContact($suCreatorContact);

			if (isset($row['su_creator_contact_company_office_id'])) {
				$su_creator_contact_company_office_id = $row['su_creator_contact_company_office_id'];
				$row['su_fk_creator_cco__id'] = $su_creator_contact_company_office_id;
				$suCreatorContactCompanyOffice = self::instantiateOrm($database, 'ContactCompanyOffice', $row, null, $su_creator_contact_company_office_id, 'su_fk_creator_cco__');
				/* @var $suCreatorContactCompanyOffice ContactCompanyOffice */
				$suCreatorContactCompanyOffice->convertPropertiesToData();
			} else {
				$suCreatorContactCompanyOffice = false;
			}
			$submittal->setSuCreatorContactCompanyOffice($suCreatorContactCompanyOffice);

			if (isset($row['su_creator_phone_contact_company_office_phone_number_id'])) {
				$su_creator_phone_contact_company_office_phone_number_id = $row['su_creator_phone_contact_company_office_phone_number_id'];
				$row['su_fk_creator_phone_ccopn__id'] = $su_creator_phone_contact_company_office_phone_number_id;
				$suCreatorPhoneContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $su_creator_phone_contact_company_office_phone_number_id, 'su_fk_creator_phone_ccopn__');
				/* @var $suCreatorPhoneContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$suCreatorPhoneContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$suCreatorPhoneContactCompanyOfficePhoneNumber = false;
			}
			$submittal->setSuCreatorPhoneContactCompanyOfficePhoneNumber($suCreatorPhoneContactCompanyOfficePhoneNumber);

			if (isset($row['su_creator_fax_contact_company_office_phone_number_id'])) {
				$su_creator_fax_contact_company_office_phone_number_id = $row['su_creator_fax_contact_company_office_phone_number_id'];
				$row['su_fk_creator_fax_ccopn__id'] = $su_creator_fax_contact_company_office_phone_number_id;
				$suCreatorFaxContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $su_creator_fax_contact_company_office_phone_number_id, 'su_fk_creator_fax_ccopn__');
				/* @var $suCreatorFaxContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$suCreatorFaxContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$suCreatorFaxContactCompanyOfficePhoneNumber = false;
			}
			$submittal->setSuCreatorFaxContactCompanyOfficePhoneNumber($suCreatorFaxContactCompanyOfficePhoneNumber);

			if (isset($row['su_creator_contact_mobile_phone_number_id'])) {
				$su_creator_contact_mobile_phone_number_id = $row['su_creator_contact_mobile_phone_number_id'];
				$row['su_fk_creator_c_mobile_cpn__id'] = $su_creator_contact_mobile_phone_number_id;
				$suCreatorContactMobilePhoneNumber = self::instantiateOrm($database, 'ContactPhoneNumber', $row, null, $su_creator_contact_mobile_phone_number_id, 'su_fk_creator_c_mobile_cpn__');
				/* @var $suCreatorContactMobilePhoneNumber ContactPhoneNumber */
				$suCreatorContactMobilePhoneNumber->convertPropertiesToData();
			} else {
				$suCreatorContactMobilePhoneNumber = false;
			}
			$submittal->setSuCreatorContactMobilePhoneNumber($suCreatorContactMobilePhoneNumber);

			if (isset($row['su_recipient_contact_id'])) {
				$su_recipient_contact_id = $row['su_recipient_contact_id'];
				$row['su_fk_recipient_c__id'] = $su_recipient_contact_id;
				$suRecipientContact = self::instantiateOrm($database, 'Contact', $row, null, $su_recipient_contact_id, 'su_fk_recipient_c__');
				/* @var $suRecipientContact Contact */
				$suRecipientContact->convertPropertiesToData();
			} else {
				$suRecipientContact = false;
			}
			$submittal->setSuRecipientContact($suRecipientContact);

			if (isset($row['su_recipient_contact_company_office_id'])) {
				$su_recipient_contact_company_office_id = $row['su_recipient_contact_company_office_id'];
				$row['su_fk_recipient_cco__id'] = $su_recipient_contact_company_office_id;
				$suRecipientContactCompanyOffice = self::instantiateOrm($database, 'ContactCompanyOffice', $row, null, $su_recipient_contact_company_office_id, 'su_fk_recipient_cco__');
				/* @var $suRecipientContactCompanyOffice ContactCompanyOffice */
				$suRecipientContactCompanyOffice->convertPropertiesToData();
			} else {
				$suRecipientContactCompanyOffice = false;
			}
			$submittal->setSuRecipientContactCompanyOffice($suRecipientContactCompanyOffice);

			if (isset($row['su_recipient_phone_contact_company_office_phone_number_id'])) {
				$su_recipient_phone_contact_company_office_phone_number_id = $row['su_recipient_phone_contact_company_office_phone_number_id'];
				$row['su_fk_recipient_phone_ccopn__id'] = $su_recipient_phone_contact_company_office_phone_number_id;
				$suRecipientPhoneContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $su_recipient_phone_contact_company_office_phone_number_id, 'su_fk_recipient_phone_ccopn__');
				/* @var $suRecipientPhoneContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$suRecipientPhoneContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$suRecipientPhoneContactCompanyOfficePhoneNumber = false;
			}
			$submittal->setSuRecipientPhoneContactCompanyOfficePhoneNumber($suRecipientPhoneContactCompanyOfficePhoneNumber);

			if (isset($row['su_recipient_fax_contact_company_office_phone_number_id'])) {
				$su_recipient_fax_contact_company_office_phone_number_id = $row['su_recipient_fax_contact_company_office_phone_number_id'];
				$row['su_fk_recipient_fax_ccopn__id'] = $su_recipient_fax_contact_company_office_phone_number_id;
				$suRecipientFaxContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $su_recipient_fax_contact_company_office_phone_number_id, 'su_fk_recipient_fax_ccopn__');
				/* @var $suRecipientFaxContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$suRecipientFaxContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$suRecipientFaxContactCompanyOfficePhoneNumber = false;
			}
			$submittal->setSuRecipientFaxContactCompanyOfficePhoneNumber($suRecipientFaxContactCompanyOfficePhoneNumber);

			if (isset($row['su_recipient_contact_mobile_phone_number_id'])) {
				$su_recipient_contact_mobile_phone_number_id = $row['su_recipient_contact_mobile_phone_number_id'];
				$row['su_fk_recipient_c_mobile_cpn__id'] = $su_recipient_contact_mobile_phone_number_id;
				$suRecipientContactMobilePhoneNumber = self::instantiateOrm($database, 'ContactPhoneNumber', $row, null, $su_recipient_contact_mobile_phone_number_id, 'su_fk_recipient_c_mobile_cpn__');
				/* @var $suRecipientContactMobilePhoneNumber ContactPhoneNumber */
				$suRecipientContactMobilePhoneNumber->convertPropertiesToData();
			} else {
				$suRecipientContactMobilePhoneNumber = false;
			}
			$submittal->setSuRecipientContactMobilePhoneNumber($suRecipientContactMobilePhoneNumber);

			if (isset($row['su_initiator_contact_id'])) {
				$su_initiator_contact_id = $row['su_initiator_contact_id'];
				$row['su_fk_initiator_c__id'] = $su_initiator_contact_id;
				$suInitiatorContact = self::instantiateOrm($database, 'Contact', $row, null, $su_initiator_contact_id, 'su_fk_initiator_c__');
				/* @var $suInitiatorContact Contact */
				$suInitiatorContact->convertPropertiesToData();
			} else {
				$suInitiatorContact = false;
			}
			$submittal->setSuInitiatorContact($suInitiatorContact);

			if (isset($row['su_initiator_contact_company_office_id'])) {
				$su_initiator_contact_company_office_id = $row['su_initiator_contact_company_office_id'];
				$row['su_fk_initiator_cco__id'] = $su_initiator_contact_company_office_id;
				$suInitiatorContactCompanyOffice = self::instantiateOrm($database, 'ContactCompanyOffice', $row, null, $su_initiator_contact_company_office_id, 'su_fk_initiator_cco__');
				/* @var $suInitiatorContactCompanyOffice ContactCompanyOffice */
				$suInitiatorContactCompanyOffice->convertPropertiesToData();
			} else {
				$suInitiatorContactCompanyOffice = false;
			}
			$submittal->setSuInitiatorContactCompanyOffice($suInitiatorContactCompanyOffice);

			if (isset($row['su_initiator_phone_contact_company_office_phone_number_id'])) {
				$su_initiator_phone_contact_company_office_phone_number_id = $row['su_initiator_phone_contact_company_office_phone_number_id'];
				$row['su_fk_initiator_phone_ccopn__id'] = $su_initiator_phone_contact_company_office_phone_number_id;
				$suInitiatorPhoneContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $su_initiator_phone_contact_company_office_phone_number_id, 'su_fk_initiator_phone_ccopn__');
				/* @var $suInitiatorPhoneContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$suInitiatorPhoneContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$suInitiatorPhoneContactCompanyOfficePhoneNumber = false;
			}
			$submittal->setSuInitiatorPhoneContactCompanyOfficePhoneNumber($suInitiatorPhoneContactCompanyOfficePhoneNumber);

			if (isset($row['su_initiator_fax_contact_company_office_phone_number_id'])) {
				$su_initiator_fax_contact_company_office_phone_number_id = $row['su_initiator_fax_contact_company_office_phone_number_id'];
				$row['su_fk_initiator_fax_ccopn__id'] = $su_initiator_fax_contact_company_office_phone_number_id;
				$suInitiatorFaxContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $su_initiator_fax_contact_company_office_phone_number_id, 'su_fk_initiator_fax_ccopn__');
				/* @var $suInitiatorFaxContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$suInitiatorFaxContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$suInitiatorFaxContactCompanyOfficePhoneNumber = false;
			}
			$submittal->setSuInitiatorFaxContactCompanyOfficePhoneNumber($suInitiatorFaxContactCompanyOfficePhoneNumber);

			if (isset($row['su_initiator_contact_mobile_phone_number_id'])) {
				$su_initiator_contact_mobile_phone_number_id = $row['su_initiator_contact_mobile_phone_number_id'];
				$row['su_fk_initiator_c_mobile_cpn__id'] = $su_initiator_contact_mobile_phone_number_id;
				$suInitiatorContactMobilePhoneNumber = self::instantiateOrm($database, 'ContactPhoneNumber', $row, null, $su_initiator_contact_mobile_phone_number_id, 'su_fk_initiator_c_mobile_cpn__');
				/* @var $suInitiatorContactMobilePhoneNumber ContactPhoneNumber */
				$suInitiatorContactMobilePhoneNumber->convertPropertiesToData();
			} else {
				$suInitiatorContactMobilePhoneNumber = false;
			}
			$submittal->setSuInitiatorContactMobilePhoneNumber($suInitiatorContactMobilePhoneNumber);

			$arrSubmittalsByProjectId[$submittal_id] = $submittal;
		}

		$db->free_result();

		self::$_arrSubmittalsByProjectId = $arrSubmittalsByProjectId;

		return $arrSubmittalsByProjectId;
	}
	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `submittals_fk_p` foreign key (`project_id`) references `projects` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $project_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubmittalsByProjectIdAndCostCode($database, $project_id, Input $options=null,$new_begindate,$Endate)
	{
		
		$forceLoadFlag = false;
		$whereCause = '';
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

			if ($options->whereFlag && $options->whereQuery) {
				$whereCause = $options->whereQuery;
			}
		}

		if ($forceLoadFlag) {
			self::$_arrSubmittalsByProjectId = null;
		}

		$arrSubmittalsByProjectId = self::$_arrSubmittalsByProjectId;
		if (isset($arrSubmittalsByProjectId) && !empty($arrSubmittalsByProjectId)) {
			return $arrSubmittalsByProjectId;
		}

		$project_id = (int) $project_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

	
		$sqlOrderBy = "\nORDER BY `su_cost_code_id` ASC,`created` DESC, `su_sequence_number` DESC, `submittal_priority_id` ASC, `submittal_type_id` ASC, `submittal_status_id` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubmittal = new Submittal($database);
			$sqlOrderByColumns = $tmpSubmittal->constructSqlOrderByColumns($arrOrderByAttributes);

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

		$query=" SELECT su_fk_sut.`submittal_type` AS 'su_fk_sut__submittal_type', su_fk_sut.`disabled_flag` AS 'su_fk_sut__disabled_flag', su_fk_sus.`id` AS 'su_fk_sus__submittal_status_id', su_fk_sus.`submittal_status` AS 'su_fk_sus__submittal_status', su_fk_sus.`disabled_flag` AS 'su_fk_sus__disabled_flag', su_fk_sup.`id` AS 'su_fk_sup__submittal_priority_id', su_fk_sup.`submittal_priority` AS 'su_fk_sup__submittal_priority', su_fk_sup.`disabled_flag` AS 'su_fk_sup__disabled_flag', su_fk_sudm.`id` AS 'su_fk_sudm__submittal_distribution_method_id', su_fk_sudm.`submittal_distribution_method` AS 'su_fk_sudm__submittal_distribution_method', su_fk_sudm.`disabled_flag` AS 'su_fk_sudm__disabled_flag',su_fk_recipient_c.`id` AS 'su_fk_recipient_c__contact_id', su_fk_recipient_c.`user_company_id` AS 'su_fk_recipient_c__user_company_id', su_fk_recipient_c.`user_id` AS 'su_fk_recipient_c__user_id', su_fk_recipient_c.`contact_company_id` AS 'su_fk_recipient_c__contact_company_id', su_fk_recipient_c.`email` AS 'su_fk_recipient_c__email', su_fk_recipient_c.`name_prefix` AS 'su_fk_recipient_c__name_prefix', su_fk_recipient_c.`first_name` AS 'su_fk_recipient_c__first_name', su_fk_recipient_c.`additional_name` AS 'su_fk_recipient_c__additional_name', su_fk_recipient_c.`middle_name` AS 'su_fk_recipient_c__middle_name', su_fk_recipient_c.`last_name` AS 'su_fk_recipient_c__last_name', su_fk_recipient_c.`name_suffix` AS 'su_fk_recipient_c__name_suffix', su_fk_recipient_c.`title` AS 'su_fk_recipient_c__title', su_fk_recipient_c.`vendor_flag` AS 'su_fk_recipient_c__vendor_flag', su_fk_codes.`id` AS 'su_fk_codes__cost_code_id',
		su_fk_codes.`cost_code_division_id` AS 'su_fk_codes__cost_code_division_id',
	su_fk_codes.`cost_code` AS 'su_fk_codes__cost_code',
	su_fk_codes.`cost_code_description` AS 'su_fk_codes__cost_code_description',su_fk_codes.`cost_code_description_abbreviation` AS 'su_fk_codes__cost_code_description_abbreviation',su_fk_codes.`sort_order` AS 'su_fk_codes__sort_order',su_fk_codes.`disabled_flag` AS 'su_fk_codes__disabled_flag',       su.* FROM `submittals` su  INNER JOIN `submittal_types` su_fk_sut ON su.`submittal_type_id` = su_fk_sut.`id` INNER JOIN `submittal_statuses` su_fk_sus ON su.`submittal_status_id` = su_fk_sus.`id` INNER JOIN `submittal_priorities` su_fk_sup ON su.`submittal_priority_id` = su_fk_sup.`id` INNER JOIN `submittal_distribution_methods` su_fk_sudm ON su.`submittal_distribution_method_id` = su_fk_sudm.`id` LEFT OUTER JOIN `contacts` su_fk_recipient_c ON su.`su_recipient_contact_id` = su_fk_recipient_c.`id` LEFT OUTER JOIN `cost_codes` su_fk_codes ON su.`su_cost_code_id` = su_fk_codes.`id` WHERE su.`project_id` = ? and date(su.created) between '$new_begindate' and '$Endate' {$whereCause} {$sqlOrderBy}{$sqlLimit}";

		$arrValues = array($project_id);

		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubmittalsByProjectId = array();
		while ($row = $db->fetch()) {
			$submittal_id = $row['id'];
			$submittal = self::instantiateOrm($database, 'Submittal', $row, null, $submittal_id);
			/* @var $submittal Submittal */
			$submittal->convertPropertiesToData();

			if (isset($row['project_id'])) {
				$project_id = $row['project_id'];
				$row['su_fk_p__id'] = $project_id;
				$project = self::instantiateOrm($database, 'Project', $row, null, $project_id, 'su_fk_p__');
				/* @var $project Project */
				$project->convertPropertiesToData();
			} else {
				$project = false;
			}
			$submittal->setProject($project);

			if (isset($row['submittal_type_id'])) {
				$submittal_type_id = $row['submittal_type_id'];
				$row['su_fk_sut__id'] = $submittal_type_id;
				$submittalType = self::instantiateOrm($database, 'SubmittalType', $row, null, $submittal_type_id, 'su_fk_sut__');
				/* @var $submittalType SubmittalType */
				$submittalType->convertPropertiesToData();
			} else {
				$submittalType = false;
			}
			$submittal->setSubmittalType($submittalType);

			if (isset($row['submittal_status_id'])) {
				$submittal_status_id = $row['submittal_status_id'];
				$row['su_fk_sus__id'] = $submittal_status_id;
				$submittalStatus = self::instantiateOrm($database, 'SubmittalStatus', $row, null, $submittal_status_id, 'su_fk_sus__');
				/* @var $submittalStatus SubmittalStatus */
				$submittalStatus->convertPropertiesToData();
			} else {
				$submittalStatus = false;
			}
			$submittal->setSubmittalStatus($submittalStatus);

			if (isset($row['submittal_priority_id'])) {
				$submittal_priority_id = $row['submittal_priority_id'];
				$row['su_fk_sup__id'] = $submittal_priority_id;
				$submittalPriority = self::instantiateOrm($database, 'SubmittalPriority', $row, null, $submittal_priority_id, 'su_fk_sup__');
				/* @var $submittalPriority SubmittalPriority */
				$submittalPriority->convertPropertiesToData();
			} else {
				$submittalPriority = false;
			}
			$submittal->setSubmittalPriority($submittalPriority);

			if (isset($row['submittal_distribution_method_id'])) {
				$submittal_distribution_method_id = $row['submittal_distribution_method_id'];
				$row['su_fk_sudm__id'] = $submittal_distribution_method_id;
				$submittalDistributionMethod = self::instantiateOrm($database, 'SubmittalDistributionMethod', $row, null, $submittal_distribution_method_id, 'su_fk_sudm__');
				/* @var $submittalDistributionMethod SubmittalDistributionMethod */
				$submittalDistributionMethod->convertPropertiesToData();
			} else {
				$submittalDistributionMethod = false;
			}
			$submittal->setSubmittalDistributionMethod($submittalDistributionMethod);

			if (isset($row['su_file_manager_file_id'])) {
				$su_file_manager_file_id = $row['su_file_manager_file_id'];
				$row['su_fk_fmfiles__id'] = $su_file_manager_file_id;
				$suFileManagerFile = self::instantiateOrm($database, 'FileManagerFile', $row, null, $su_file_manager_file_id, 'su_fk_fmfiles__');
				/* @var $suFileManagerFile FileManagerFile */
				$suFileManagerFile->convertPropertiesToData();
			} else {
				$suFileManagerFile = false;
			}
			$submittal->setSuFileManagerFile($suFileManagerFile);

			if (isset($row['su_cost_code_id'])) {
				$su_cost_code_id = $row['su_cost_code_id'];
				$row['su_fk_codes__id'] = $su_cost_code_id;
				$suCostCode = self::instantiateOrm($database, 'CostCode', $row, null, $su_cost_code_id, 'su_fk_codes__');
				/* @var $suCostCode CostCode */
				$suCostCode->convertPropertiesToData();
			} else {
				$suCostCode = false;
			}
			$submittal->setSuCostCode($suCostCode);

			if (isset($row['su_creator_contact_id'])) {
				$su_creator_contact_id = $row['su_creator_contact_id'];
				$row['su_fk_creator_c__id'] = $su_creator_contact_id;
				$suCreatorContact = self::instantiateOrm($database, 'Contact', $row, null, $su_creator_contact_id, 'su_fk_creator_c__');
				/* @var $suCreatorContact Contact */
				$suCreatorContact->convertPropertiesToData();
			} else {
				$suCreatorContact = false;
			}
			$submittal->setSuCreatorContact($suCreatorContact);

			if (isset($row['su_creator_contact_company_office_id'])) {
				$su_creator_contact_company_office_id = $row['su_creator_contact_company_office_id'];
				$row['su_fk_creator_cco__id'] = $su_creator_contact_company_office_id;
				$suCreatorContactCompanyOffice = self::instantiateOrm($database, 'ContactCompanyOffice', $row, null, $su_creator_contact_company_office_id, 'su_fk_creator_cco__');
				/* @var $suCreatorContactCompanyOffice ContactCompanyOffice */
				$suCreatorContactCompanyOffice->convertPropertiesToData();
			} else {
				$suCreatorContactCompanyOffice = false;
			}
			$submittal->setSuCreatorContactCompanyOffice($suCreatorContactCompanyOffice);

			if (isset($row['su_creator_phone_contact_company_office_phone_number_id'])) {
				$su_creator_phone_contact_company_office_phone_number_id = $row['su_creator_phone_contact_company_office_phone_number_id'];
				$row['su_fk_creator_phone_ccopn__id'] = $su_creator_phone_contact_company_office_phone_number_id;
				$suCreatorPhoneContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $su_creator_phone_contact_company_office_phone_number_id, 'su_fk_creator_phone_ccopn__');
				/* @var $suCreatorPhoneContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$suCreatorPhoneContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$suCreatorPhoneContactCompanyOfficePhoneNumber = false;
			}
			$submittal->setSuCreatorPhoneContactCompanyOfficePhoneNumber($suCreatorPhoneContactCompanyOfficePhoneNumber);

			if (isset($row['su_creator_fax_contact_company_office_phone_number_id'])) {
				$su_creator_fax_contact_company_office_phone_number_id = $row['su_creator_fax_contact_company_office_phone_number_id'];
				$row['su_fk_creator_fax_ccopn__id'] = $su_creator_fax_contact_company_office_phone_number_id;
				$suCreatorFaxContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $su_creator_fax_contact_company_office_phone_number_id, 'su_fk_creator_fax_ccopn__');
				/* @var $suCreatorFaxContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$suCreatorFaxContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$suCreatorFaxContactCompanyOfficePhoneNumber = false;
			}
			$submittal->setSuCreatorFaxContactCompanyOfficePhoneNumber($suCreatorFaxContactCompanyOfficePhoneNumber);

			if (isset($row['su_creator_contact_mobile_phone_number_id'])) {
				$su_creator_contact_mobile_phone_number_id = $row['su_creator_contact_mobile_phone_number_id'];
				$row['su_fk_creator_c_mobile_cpn__id'] = $su_creator_contact_mobile_phone_number_id;
				$suCreatorContactMobilePhoneNumber = self::instantiateOrm($database, 'ContactPhoneNumber', $row, null, $su_creator_contact_mobile_phone_number_id, 'su_fk_creator_c_mobile_cpn__');
				/* @var $suCreatorContactMobilePhoneNumber ContactPhoneNumber */
				$suCreatorContactMobilePhoneNumber->convertPropertiesToData();
			} else {
				$suCreatorContactMobilePhoneNumber = false;
			}
			$submittal->setSuCreatorContactMobilePhoneNumber($suCreatorContactMobilePhoneNumber);

			if (isset($row['su_recipient_contact_id'])) {
				$su_recipient_contact_id = $row['su_recipient_contact_id'];
				$row['su_fk_recipient_c__id'] = $su_recipient_contact_id;
				$suRecipientContact = self::instantiateOrm($database, 'Contact', $row, null, $su_recipient_contact_id, 'su_fk_recipient_c__');
				/* @var $suRecipientContact Contact */
				$suRecipientContact->convertPropertiesToData();
			} else {
				$suRecipientContact = false;
			}
			$submittal->setSuRecipientContact($suRecipientContact);

			if (isset($row['su_recipient_contact_company_office_id'])) {
				$su_recipient_contact_company_office_id = $row['su_recipient_contact_company_office_id'];
				$row['su_fk_recipient_cco__id'] = $su_recipient_contact_company_office_id;
				$suRecipientContactCompanyOffice = self::instantiateOrm($database, 'ContactCompanyOffice', $row, null, $su_recipient_contact_company_office_id, 'su_fk_recipient_cco__');
				/* @var $suRecipientContactCompanyOffice ContactCompanyOffice */
				$suRecipientContactCompanyOffice->convertPropertiesToData();
			} else {
				$suRecipientContactCompanyOffice = false;
			}
			$submittal->setSuRecipientContactCompanyOffice($suRecipientContactCompanyOffice);

			if (isset($row['su_recipient_phone_contact_company_office_phone_number_id'])) {
				$su_recipient_phone_contact_company_office_phone_number_id = $row['su_recipient_phone_contact_company_office_phone_number_id'];
				$row['su_fk_recipient_phone_ccopn__id'] = $su_recipient_phone_contact_company_office_phone_number_id;
				$suRecipientPhoneContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $su_recipient_phone_contact_company_office_phone_number_id, 'su_fk_recipient_phone_ccopn__');
				/* @var $suRecipientPhoneContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$suRecipientPhoneContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$suRecipientPhoneContactCompanyOfficePhoneNumber = false;
			}
			$submittal->setSuRecipientPhoneContactCompanyOfficePhoneNumber($suRecipientPhoneContactCompanyOfficePhoneNumber);

			if (isset($row['su_recipient_fax_contact_company_office_phone_number_id'])) {
				$su_recipient_fax_contact_company_office_phone_number_id = $row['su_recipient_fax_contact_company_office_phone_number_id'];
				$row['su_fk_recipient_fax_ccopn__id'] = $su_recipient_fax_contact_company_office_phone_number_id;
				$suRecipientFaxContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $su_recipient_fax_contact_company_office_phone_number_id, 'su_fk_recipient_fax_ccopn__');
				/* @var $suRecipientFaxContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$suRecipientFaxContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$suRecipientFaxContactCompanyOfficePhoneNumber = false;
			}
			$submittal->setSuRecipientFaxContactCompanyOfficePhoneNumber($suRecipientFaxContactCompanyOfficePhoneNumber);

			if (isset($row['su_recipient_contact_mobile_phone_number_id'])) {
				$su_recipient_contact_mobile_phone_number_id = $row['su_recipient_contact_mobile_phone_number_id'];
				$row['su_fk_recipient_c_mobile_cpn__id'] = $su_recipient_contact_mobile_phone_number_id;
				$suRecipientContactMobilePhoneNumber = self::instantiateOrm($database, 'ContactPhoneNumber', $row, null, $su_recipient_contact_mobile_phone_number_id, 'su_fk_recipient_c_mobile_cpn__');
				/* @var $suRecipientContactMobilePhoneNumber ContactPhoneNumber */
				$suRecipientContactMobilePhoneNumber->convertPropertiesToData();
			} else {
				$suRecipientContactMobilePhoneNumber = false;
			}
			$submittal->setSuRecipientContactMobilePhoneNumber($suRecipientContactMobilePhoneNumber);

			if (isset($row['su_initiator_contact_id'])) {
				$su_initiator_contact_id = $row['su_initiator_contact_id'];
				$row['su_fk_initiator_c__id'] = $su_initiator_contact_id;
				$suInitiatorContact = self::instantiateOrm($database, 'Contact', $row, null, $su_initiator_contact_id, 'su_fk_initiator_c__');
				/* @var $suInitiatorContact Contact */
				$suInitiatorContact->convertPropertiesToData();
			} else {
				$suInitiatorContact = false;
			}
			$submittal->setSuInitiatorContact($suInitiatorContact);

			if (isset($row['su_initiator_contact_company_office_id'])) {
				$su_initiator_contact_company_office_id = $row['su_initiator_contact_company_office_id'];
				$row['su_fk_initiator_cco__id'] = $su_initiator_contact_company_office_id;
				$suInitiatorContactCompanyOffice = self::instantiateOrm($database, 'ContactCompanyOffice', $row, null, $su_initiator_contact_company_office_id, 'su_fk_initiator_cco__');
				/* @var $suInitiatorContactCompanyOffice ContactCompanyOffice */
				$suInitiatorContactCompanyOffice->convertPropertiesToData();
			} else {
				$suInitiatorContactCompanyOffice = false;
			}
			$submittal->setSuInitiatorContactCompanyOffice($suInitiatorContactCompanyOffice);

			if (isset($row['su_initiator_phone_contact_company_office_phone_number_id'])) {
				$su_initiator_phone_contact_company_office_phone_number_id = $row['su_initiator_phone_contact_company_office_phone_number_id'];
				$row['su_fk_initiator_phone_ccopn__id'] = $su_initiator_phone_contact_company_office_phone_number_id;
				$suInitiatorPhoneContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $su_initiator_phone_contact_company_office_phone_number_id, 'su_fk_initiator_phone_ccopn__');
				/* @var $suInitiatorPhoneContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$suInitiatorPhoneContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$suInitiatorPhoneContactCompanyOfficePhoneNumber = false;
			}
			$submittal->setSuInitiatorPhoneContactCompanyOfficePhoneNumber($suInitiatorPhoneContactCompanyOfficePhoneNumber);

			if (isset($row['su_initiator_fax_contact_company_office_phone_number_id'])) {
				$su_initiator_fax_contact_company_office_phone_number_id = $row['su_initiator_fax_contact_company_office_phone_number_id'];
				$row['su_fk_initiator_fax_ccopn__id'] = $su_initiator_fax_contact_company_office_phone_number_id;
				$suInitiatorFaxContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $su_initiator_fax_contact_company_office_phone_number_id, 'su_fk_initiator_fax_ccopn__');
				/* @var $suInitiatorFaxContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$suInitiatorFaxContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$suInitiatorFaxContactCompanyOfficePhoneNumber = false;
			}
			$submittal->setSuInitiatorFaxContactCompanyOfficePhoneNumber($suInitiatorFaxContactCompanyOfficePhoneNumber);

			if (isset($row['su_initiator_contact_mobile_phone_number_id'])) {
				$su_initiator_contact_mobile_phone_number_id = $row['su_initiator_contact_mobile_phone_number_id'];
				$row['su_fk_initiator_c_mobile_cpn__id'] = $su_initiator_contact_mobile_phone_number_id;
				$suInitiatorContactMobilePhoneNumber = self::instantiateOrm($database, 'ContactPhoneNumber', $row, null, $su_initiator_contact_mobile_phone_number_id, 'su_fk_initiator_c_mobile_cpn__');
				/* @var $suInitiatorContactMobilePhoneNumber ContactPhoneNumber */
				$suInitiatorContactMobilePhoneNumber->convertPropertiesToData();
			} else {
				$suInitiatorContactMobilePhoneNumber = false;
			}
			$submittal->setSuInitiatorContactMobilePhoneNumber($suInitiatorContactMobilePhoneNumber);

			$arrSubmittalsByProjectId[$submittal_id] = $submittal;
		}

		$db->free_result();

		self::$_arrSubmittalsByProjectId = $arrSubmittalsByProjectId;

		return $arrSubmittalsByProjectId;
	}
	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `submittals_fk_p` foreign key (`project_id`) references `projects` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $project_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubmittalsByProjectIdAndStatus($database, $project_id, Input $options=null,$new_begindate,$Endate)
	{
		
		$forceLoadFlag = false;
		$whereCause = '';
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

			if ($options->whereFlag && $options->whereQuery) {
				$whereCause = $options->whereQuery;
			}
		}

		if ($forceLoadFlag) {
			self::$_arrSubmittalsByProjectId = null;
		}

		$arrSubmittalsByProjectId = self::$_arrSubmittalsByProjectId;
		if (isset($arrSubmittalsByProjectId) && !empty($arrSubmittalsByProjectId)) {
			return $arrSubmittalsByProjectId;
		}

		$project_id = (int) $project_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

	
		$sqlOrderBy = "\nORDER BY `submittal_status_id` ASC,`created` DESC, `su_sequence_number` DESC,  `submittal_type_id` ASC, `submittal_priority_id` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubmittal = new Submittal($database);
			$sqlOrderByColumns = $tmpSubmittal->constructSqlOrderByColumns($arrOrderByAttributes);

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

		 $query=" SELECT su_fk_sut.`submittal_type` AS 'su_fk_sut__submittal_type', su_fk_sut.`disabled_flag` AS 'su_fk_sut__disabled_flag', su_fk_sus.`id` AS 'su_fk_sus__submittal_status_id', su_fk_sus.`submittal_status` AS 'su_fk_sus__submittal_status', su_fk_sus.`disabled_flag` AS 'su_fk_sus__disabled_flag', su_fk_sup.`id` AS 'su_fk_sup__submittal_priority_id', su_fk_sup.`submittal_priority` AS 'su_fk_sup__submittal_priority', su_fk_sup.`disabled_flag` AS 'su_fk_sup__disabled_flag', su_fk_sudm.`id` AS 'su_fk_sudm__submittal_distribution_method_id', su_fk_sudm.`submittal_distribution_method` AS 'su_fk_sudm__submittal_distribution_method', su_fk_sudm.`disabled_flag` AS 'su_fk_sudm__disabled_flag',su_fk_recipient_c.`id` AS 'su_fk_recipient_c__contact_id', su_fk_recipient_c.`user_company_id` AS 'su_fk_recipient_c__user_company_id', su_fk_recipient_c.`user_id` AS 'su_fk_recipient_c__user_id', su_fk_recipient_c.`contact_company_id` AS 'su_fk_recipient_c__contact_company_id', su_fk_recipient_c.`email` AS 'su_fk_recipient_c__email', su_fk_recipient_c.`name_prefix` AS 'su_fk_recipient_c__name_prefix', su_fk_recipient_c.`first_name` AS 'su_fk_recipient_c__first_name', su_fk_recipient_c.`additional_name` AS 'su_fk_recipient_c__additional_name', su_fk_recipient_c.`middle_name` AS 'su_fk_recipient_c__middle_name', su_fk_recipient_c.`last_name` AS 'su_fk_recipient_c__last_name', su_fk_recipient_c.`name_suffix` AS 'su_fk_recipient_c__name_suffix', su_fk_recipient_c.`title` AS 'su_fk_recipient_c__title', su_fk_recipient_c.`vendor_flag` AS 'su_fk_recipient_c__vendor_flag',        su.* FROM `submittals` su  INNER JOIN `submittal_types` su_fk_sut ON su.`submittal_type_id` = su_fk_sut.`id` INNER JOIN `submittal_statuses` su_fk_sus ON su.`submittal_status_id` = su_fk_sus.`id` INNER JOIN `submittal_priorities` su_fk_sup ON su.`submittal_priority_id` = su_fk_sup.`id` INNER JOIN `submittal_distribution_methods` su_fk_sudm ON su.`submittal_distribution_method_id` = su_fk_sudm.`id` LEFT OUTER JOIN `contacts` su_fk_recipient_c ON su.`su_recipient_contact_id` = su_fk_recipient_c.`id`  WHERE su.`project_id` = ? and date(su.created) between '$new_begindate' and '$Endate' {$whereCause} {$sqlOrderBy}{$sqlLimit}";

		$arrValues = array($project_id);

		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubmittalsByProjectId = array();
		while ($row = $db->fetch()) {
			$submittal_id = $row['id'];
			$submittal = self::instantiateOrm($database, 'Submittal', $row, null, $submittal_id);
			/* @var $submittal Submittal */
			$submittal->convertPropertiesToData();

			if (isset($row['project_id'])) {
				$project_id = $row['project_id'];
				$row['su_fk_p__id'] = $project_id;
				$project = self::instantiateOrm($database, 'Project', $row, null, $project_id, 'su_fk_p__');
				/* @var $project Project */
				$project->convertPropertiesToData();
			} else {
				$project = false;
			}
			$submittal->setProject($project);

			if (isset($row['submittal_type_id'])) {
				$submittal_type_id = $row['submittal_type_id'];
				$row['su_fk_sut__id'] = $submittal_type_id;
				$submittalType = self::instantiateOrm($database, 'SubmittalType', $row, null, $submittal_type_id, 'su_fk_sut__');
				/* @var $submittalType SubmittalType */
				$submittalType->convertPropertiesToData();
			} else {
				$submittalType = false;
			}
			$submittal->setSubmittalType($submittalType);

			if (isset($row['submittal_status_id'])) {
				$submittal_status_id = $row['submittal_status_id'];
				$row['su_fk_sus__id'] = $submittal_status_id;
				$submittalStatus = self::instantiateOrm($database, 'SubmittalStatus', $row, null, $submittal_status_id, 'su_fk_sus__');
				/* @var $submittalStatus SubmittalStatus */
				$submittalStatus->convertPropertiesToData();
			} else {
				$submittalStatus = false;
			}
			$submittal->setSubmittalStatus($submittalStatus);

			if (isset($row['submittal_priority_id'])) {
				$submittal_priority_id = $row['submittal_priority_id'];
				$row['su_fk_sup__id'] = $submittal_priority_id;
				$submittalPriority = self::instantiateOrm($database, 'SubmittalPriority', $row, null, $submittal_priority_id, 'su_fk_sup__');
				/* @var $submittalPriority SubmittalPriority */
				$submittalPriority->convertPropertiesToData();
			} else {
				$submittalPriority = false;
			}
			$submittal->setSubmittalPriority($submittalPriority);

			if (isset($row['submittal_distribution_method_id'])) {
				$submittal_distribution_method_id = $row['submittal_distribution_method_id'];
				$row['su_fk_sudm__id'] = $submittal_distribution_method_id;
				$submittalDistributionMethod = self::instantiateOrm($database, 'SubmittalDistributionMethod', $row, null, $submittal_distribution_method_id, 'su_fk_sudm__');
				/* @var $submittalDistributionMethod SubmittalDistributionMethod */
				$submittalDistributionMethod->convertPropertiesToData();
			} else {
				$submittalDistributionMethod = false;
			}
			$submittal->setSubmittalDistributionMethod($submittalDistributionMethod);

			if (isset($row['su_file_manager_file_id'])) {
				$su_file_manager_file_id = $row['su_file_manager_file_id'];
				$row['su_fk_fmfiles__id'] = $su_file_manager_file_id;
				$suFileManagerFile = self::instantiateOrm($database, 'FileManagerFile', $row, null, $su_file_manager_file_id, 'su_fk_fmfiles__');
				/* @var $suFileManagerFile FileManagerFile */
				$suFileManagerFile->convertPropertiesToData();
			} else {
				$suFileManagerFile = false;
			}
			$submittal->setSuFileManagerFile($suFileManagerFile);

			if (isset($row['su_cost_code_id'])) {
				$su_cost_code_id = $row['su_cost_code_id'];
				$row['su_fk_codes__id'] = $su_cost_code_id;
				$suCostCode = self::instantiateOrm($database, 'CostCode', $row, null, $su_cost_code_id, 'su_fk_codes__');
				/* @var $suCostCode CostCode */
				$suCostCode->convertPropertiesToData();
			} else {
				$suCostCode = false;
			}
			$submittal->setSuCostCode($suCostCode);

			if (isset($row['su_creator_contact_id'])) {
				$su_creator_contact_id = $row['su_creator_contact_id'];
				$row['su_fk_creator_c__id'] = $su_creator_contact_id;
				$suCreatorContact = self::instantiateOrm($database, 'Contact', $row, null, $su_creator_contact_id, 'su_fk_creator_c__');
				/* @var $suCreatorContact Contact */
				$suCreatorContact->convertPropertiesToData();
			} else {
				$suCreatorContact = false;
			}
			$submittal->setSuCreatorContact($suCreatorContact);

			if (isset($row['su_creator_contact_company_office_id'])) {
				$su_creator_contact_company_office_id = $row['su_creator_contact_company_office_id'];
				$row['su_fk_creator_cco__id'] = $su_creator_contact_company_office_id;
				$suCreatorContactCompanyOffice = self::instantiateOrm($database, 'ContactCompanyOffice', $row, null, $su_creator_contact_company_office_id, 'su_fk_creator_cco__');
				/* @var $suCreatorContactCompanyOffice ContactCompanyOffice */
				$suCreatorContactCompanyOffice->convertPropertiesToData();
			} else {
				$suCreatorContactCompanyOffice = false;
			}
			$submittal->setSuCreatorContactCompanyOffice($suCreatorContactCompanyOffice);

			if (isset($row['su_creator_phone_contact_company_office_phone_number_id'])) {
				$su_creator_phone_contact_company_office_phone_number_id = $row['su_creator_phone_contact_company_office_phone_number_id'];
				$row['su_fk_creator_phone_ccopn__id'] = $su_creator_phone_contact_company_office_phone_number_id;
				$suCreatorPhoneContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $su_creator_phone_contact_company_office_phone_number_id, 'su_fk_creator_phone_ccopn__');
				/* @var $suCreatorPhoneContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$suCreatorPhoneContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$suCreatorPhoneContactCompanyOfficePhoneNumber = false;
			}
			$submittal->setSuCreatorPhoneContactCompanyOfficePhoneNumber($suCreatorPhoneContactCompanyOfficePhoneNumber);

			if (isset($row['su_creator_fax_contact_company_office_phone_number_id'])) {
				$su_creator_fax_contact_company_office_phone_number_id = $row['su_creator_fax_contact_company_office_phone_number_id'];
				$row['su_fk_creator_fax_ccopn__id'] = $su_creator_fax_contact_company_office_phone_number_id;
				$suCreatorFaxContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $su_creator_fax_contact_company_office_phone_number_id, 'su_fk_creator_fax_ccopn__');
				/* @var $suCreatorFaxContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$suCreatorFaxContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$suCreatorFaxContactCompanyOfficePhoneNumber = false;
			}
			$submittal->setSuCreatorFaxContactCompanyOfficePhoneNumber($suCreatorFaxContactCompanyOfficePhoneNumber);

			if (isset($row['su_creator_contact_mobile_phone_number_id'])) {
				$su_creator_contact_mobile_phone_number_id = $row['su_creator_contact_mobile_phone_number_id'];
				$row['su_fk_creator_c_mobile_cpn__id'] = $su_creator_contact_mobile_phone_number_id;
				$suCreatorContactMobilePhoneNumber = self::instantiateOrm($database, 'ContactPhoneNumber', $row, null, $su_creator_contact_mobile_phone_number_id, 'su_fk_creator_c_mobile_cpn__');
				/* @var $suCreatorContactMobilePhoneNumber ContactPhoneNumber */
				$suCreatorContactMobilePhoneNumber->convertPropertiesToData();
			} else {
				$suCreatorContactMobilePhoneNumber = false;
			}
			$submittal->setSuCreatorContactMobilePhoneNumber($suCreatorContactMobilePhoneNumber);

			if (isset($row['su_recipient_contact_id'])) {
				$su_recipient_contact_id = $row['su_recipient_contact_id'];
				$row['su_fk_recipient_c__id'] = $su_recipient_contact_id;
				$suRecipientContact = self::instantiateOrm($database, 'Contact', $row, null, $su_recipient_contact_id, 'su_fk_recipient_c__');
				/* @var $suRecipientContact Contact */
				$suRecipientContact->convertPropertiesToData();
			} else {
				$suRecipientContact = false;
			}
			$submittal->setSuRecipientContact($suRecipientContact);

			if (isset($row['su_recipient_contact_company_office_id'])) {
				$su_recipient_contact_company_office_id = $row['su_recipient_contact_company_office_id'];
				$row['su_fk_recipient_cco__id'] = $su_recipient_contact_company_office_id;
				$suRecipientContactCompanyOffice = self::instantiateOrm($database, 'ContactCompanyOffice', $row, null, $su_recipient_contact_company_office_id, 'su_fk_recipient_cco__');
				/* @var $suRecipientContactCompanyOffice ContactCompanyOffice */
				$suRecipientContactCompanyOffice->convertPropertiesToData();
			} else {
				$suRecipientContactCompanyOffice = false;
			}
			$submittal->setSuRecipientContactCompanyOffice($suRecipientContactCompanyOffice);

			if (isset($row['su_recipient_phone_contact_company_office_phone_number_id'])) {
				$su_recipient_phone_contact_company_office_phone_number_id = $row['su_recipient_phone_contact_company_office_phone_number_id'];
				$row['su_fk_recipient_phone_ccopn__id'] = $su_recipient_phone_contact_company_office_phone_number_id;
				$suRecipientPhoneContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $su_recipient_phone_contact_company_office_phone_number_id, 'su_fk_recipient_phone_ccopn__');
				/* @var $suRecipientPhoneContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$suRecipientPhoneContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$suRecipientPhoneContactCompanyOfficePhoneNumber = false;
			}
			$submittal->setSuRecipientPhoneContactCompanyOfficePhoneNumber($suRecipientPhoneContactCompanyOfficePhoneNumber);

			if (isset($row['su_recipient_fax_contact_company_office_phone_number_id'])) {
				$su_recipient_fax_contact_company_office_phone_number_id = $row['su_recipient_fax_contact_company_office_phone_number_id'];
				$row['su_fk_recipient_fax_ccopn__id'] = $su_recipient_fax_contact_company_office_phone_number_id;
				$suRecipientFaxContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $su_recipient_fax_contact_company_office_phone_number_id, 'su_fk_recipient_fax_ccopn__');
				/* @var $suRecipientFaxContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$suRecipientFaxContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$suRecipientFaxContactCompanyOfficePhoneNumber = false;
			}
			$submittal->setSuRecipientFaxContactCompanyOfficePhoneNumber($suRecipientFaxContactCompanyOfficePhoneNumber);

			if (isset($row['su_recipient_contact_mobile_phone_number_id'])) {
				$su_recipient_contact_mobile_phone_number_id = $row['su_recipient_contact_mobile_phone_number_id'];
				$row['su_fk_recipient_c_mobile_cpn__id'] = $su_recipient_contact_mobile_phone_number_id;
				$suRecipientContactMobilePhoneNumber = self::instantiateOrm($database, 'ContactPhoneNumber', $row, null, $su_recipient_contact_mobile_phone_number_id, 'su_fk_recipient_c_mobile_cpn__');
				/* @var $suRecipientContactMobilePhoneNumber ContactPhoneNumber */
				$suRecipientContactMobilePhoneNumber->convertPropertiesToData();
			} else {
				$suRecipientContactMobilePhoneNumber = false;
			}
			$submittal->setSuRecipientContactMobilePhoneNumber($suRecipientContactMobilePhoneNumber);

			if (isset($row['su_initiator_contact_id'])) {
				$su_initiator_contact_id = $row['su_initiator_contact_id'];
				$row['su_fk_initiator_c__id'] = $su_initiator_contact_id;
				$suInitiatorContact = self::instantiateOrm($database, 'Contact', $row, null, $su_initiator_contact_id, 'su_fk_initiator_c__');
				/* @var $suInitiatorContact Contact */
				$suInitiatorContact->convertPropertiesToData();
			} else {
				$suInitiatorContact = false;
			}
			$submittal->setSuInitiatorContact($suInitiatorContact);

			if (isset($row['su_initiator_contact_company_office_id'])) {
				$su_initiator_contact_company_office_id = $row['su_initiator_contact_company_office_id'];
				$row['su_fk_initiator_cco__id'] = $su_initiator_contact_company_office_id;
				$suInitiatorContactCompanyOffice = self::instantiateOrm($database, 'ContactCompanyOffice', $row, null, $su_initiator_contact_company_office_id, 'su_fk_initiator_cco__');
				/* @var $suInitiatorContactCompanyOffice ContactCompanyOffice */
				$suInitiatorContactCompanyOffice->convertPropertiesToData();
			} else {
				$suInitiatorContactCompanyOffice = false;
			}
			$submittal->setSuInitiatorContactCompanyOffice($suInitiatorContactCompanyOffice);

			if (isset($row['su_initiator_phone_contact_company_office_phone_number_id'])) {
				$su_initiator_phone_contact_company_office_phone_number_id = $row['su_initiator_phone_contact_company_office_phone_number_id'];
				$row['su_fk_initiator_phone_ccopn__id'] = $su_initiator_phone_contact_company_office_phone_number_id;
				$suInitiatorPhoneContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $su_initiator_phone_contact_company_office_phone_number_id, 'su_fk_initiator_phone_ccopn__');
				/* @var $suInitiatorPhoneContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$suInitiatorPhoneContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$suInitiatorPhoneContactCompanyOfficePhoneNumber = false;
			}
			$submittal->setSuInitiatorPhoneContactCompanyOfficePhoneNumber($suInitiatorPhoneContactCompanyOfficePhoneNumber);

			if (isset($row['su_initiator_fax_contact_company_office_phone_number_id'])) {
				$su_initiator_fax_contact_company_office_phone_number_id = $row['su_initiator_fax_contact_company_office_phone_number_id'];
				$row['su_fk_initiator_fax_ccopn__id'] = $su_initiator_fax_contact_company_office_phone_number_id;
				$suInitiatorFaxContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $su_initiator_fax_contact_company_office_phone_number_id, 'su_fk_initiator_fax_ccopn__');
				/* @var $suInitiatorFaxContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$suInitiatorFaxContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$suInitiatorFaxContactCompanyOfficePhoneNumber = false;
			}
			$submittal->setSuInitiatorFaxContactCompanyOfficePhoneNumber($suInitiatorFaxContactCompanyOfficePhoneNumber);

			if (isset($row['su_initiator_contact_mobile_phone_number_id'])) {
				$su_initiator_contact_mobile_phone_number_id = $row['su_initiator_contact_mobile_phone_number_id'];
				$row['su_fk_initiator_c_mobile_cpn__id'] = $su_initiator_contact_mobile_phone_number_id;
				$suInitiatorContactMobilePhoneNumber = self::instantiateOrm($database, 'ContactPhoneNumber', $row, null, $su_initiator_contact_mobile_phone_number_id, 'su_fk_initiator_c_mobile_cpn__');
				/* @var $suInitiatorContactMobilePhoneNumber ContactPhoneNumber */
				$suInitiatorContactMobilePhoneNumber->convertPropertiesToData();
			} else {
				$suInitiatorContactMobilePhoneNumber = false;
			}
			$submittal->setSuInitiatorContactMobilePhoneNumber($suInitiatorContactMobilePhoneNumber);

			$arrSubmittalsByProjectId[$submittal_id] = $submittal;
		}

		$db->free_result();

		self::$_arrSubmittalsByProjectId = $arrSubmittalsByProjectId;

		return $arrSubmittalsByProjectId;
	}
	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `submittals_fk_p` foreign key (`project_id`) references `projects` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $project_id
	 */
	// To get the submittal list for grid
	public static function loadSubmittalsDatasforProjectId($database,$project_id)
	{
		$sqlOrderBy = "\nORDER BY s.`created` DESC, s.`su_sequence_number` DESC, s.`submittal_priority_id` ASC, s.`submittal_type_id` ASC, s.`submittal_status_id` ASC";
		
		$db = DBI::getInstance($database);
		$query = "SELECT cs.cost_code , ss.submittal_status,sp.submittal_priority,
		con.`id` as con_contact_id, con.`user_company_id` as  con_user_company_id, con.`user_id` as con_user_id, con.`contact_company_id` as con_contact_company_id, con.`email` as con_email, con.`name_prefix` as con_name_prefix, con.`first_name` as con_first_name, con.`additional_name` as con_additional_name, con.`middle_name` as con_middle_name, con.`last_name` as con_last_name, con.`name_suffix` as con_name_suffix, con.`title` as con_title, con.`vendor_flag` as con_vendor_flag, con.`is_archive` as con_is_archive,

		s.* FROM `submittals` as s 
		Left outer join cost_codes as cs ON s.`su_cost_code_id` = cs.`id` 
		inner join `submittal_priorities` as sp on s.submittal_priority_id = sp.id
		inner join `submittal_statuses` as ss on s.submittal_status_id = ss.id
		inner join `contacts` as con on s.su_recipient_contact_id = con.`id`
		where s.project_id =? {$sqlOrderBy} ";
		$arrValues = array($project_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubmittalsByProjectId = array();
		while ($row = $db->fetch()) {
			$subid =$row['id'];
			$arrSubmittalsByProjectId[$subid] =$row;
		}
		$db->free_result();
		return $arrSubmittalsByProjectId;
		
	}
	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `submittals_fk_p` foreign key (`project_id`) references `projects` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $project_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubmittalsByProjectId($database, $project_id, Input $options=null)
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
			self::$_arrSubmittalsByProjectId = null;
		}

		$arrSubmittalsByProjectId = self::$_arrSubmittalsByProjectId;
		if (isset($arrSubmittalsByProjectId) && !empty($arrSubmittalsByProjectId)) {
			return $arrSubmittalsByProjectId;
		}

		$project_id = (int) $project_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `su_sequence_number` ASC, `submittal_type_id` ASC, `submittal_status_id` ASC, `submittal_priority_id` ASC, `su_file_manager_file_id` ASC, `su_cost_code_id` ASC, `su_creator_contact_id` ASC, `su_creator_contact_company_office_id` ASC, `su_creator_phone_contact_company_office_phone_number_id` ASC, `su_creator_fax_contact_company_office_phone_number_id` ASC, `su_creator_contact_mobile_phone_number_id` ASC, `su_recipient_contact_id` ASC, `su_recipient_contact_company_office_id` ASC, `su_recipient_phone_contact_company_office_phone_number_id` ASC, `su_recipient_fax_contact_company_office_phone_number_id` ASC, `su_recipient_contact_mobile_phone_number_id` ASC, `su_initiator_contact_id` ASC, `su_initiator_contact_company_office_id` ASC, `su_initiator_phone_contact_company_office_phone_number_id` ASC, `su_initiator_fax_contact_company_office_phone_number_id` ASC, `su_initiator_contact_mobile_phone_number_id` ASC, `su_title` ASC, `su_plan_page_reference` ASC, `su_statement` ASC, `created` ASC, `su_due_date` ASC, `su_closed_date` ASC
		$sqlOrderBy = "\nORDER BY `created` DESC, `su_sequence_number` DESC, `submittal_priority_id` ASC, `submittal_type_id` ASC, `submittal_status_id` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubmittal = new Submittal($database);
			$sqlOrderByColumns = $tmpSubmittal->constructSqlOrderByColumns($arrOrderByAttributes);

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

	su_fk_p.`id` AS 'su_fk_p__project_id',
	su_fk_p.`project_type_id` AS 'su_fk_p__project_type_id',
	su_fk_p.`user_company_id` AS 'su_fk_p__user_company_id',
	su_fk_p.`user_custom_project_id` AS 'su_fk_p__user_custom_project_id',
	su_fk_p.`project_name` AS 'su_fk_p__project_name',
	su_fk_p.`project_owner_name` AS 'su_fk_p__project_owner_name',
	su_fk_p.`latitude` AS 'su_fk_p__latitude',
	su_fk_p.`longitude` AS 'su_fk_p__longitude',
	su_fk_p.`address_line_1` AS 'su_fk_p__address_line_1',
	su_fk_p.`address_line_2` AS 'su_fk_p__address_line_2',
	su_fk_p.`address_line_3` AS 'su_fk_p__address_line_3',
	su_fk_p.`address_line_4` AS 'su_fk_p__address_line_4',
	su_fk_p.`address_city` AS 'su_fk_p__address_city',
	su_fk_p.`address_county` AS 'su_fk_p__address_county',
	su_fk_p.`address_state_or_region` AS 'su_fk_p__address_state_or_region',
	su_fk_p.`address_postal_code` AS 'su_fk_p__address_postal_code',
	su_fk_p.`address_postal_code_extension` AS 'su_fk_p__address_postal_code_extension',
	su_fk_p.`address_country` AS 'su_fk_p__address_country',
	su_fk_p.`building_count` AS 'su_fk_p__building_count',
	su_fk_p.`unit_count` AS 'su_fk_p__unit_count',
	su_fk_p.`gross_square_footage` AS 'su_fk_p__gross_square_footage',
	su_fk_p.`net_rentable_square_footage` AS 'su_fk_p__net_rentable_square_footage',
	su_fk_p.`is_active_flag` AS 'su_fk_p__is_active_flag',
	su_fk_p.`public_plans_flag` AS 'su_fk_p__public_plans_flag',
	su_fk_p.`prevailing_wage_flag` AS 'su_fk_p__prevailing_wage_flag',
	su_fk_p.`city_business_license_required_flag` AS 'su_fk_p__city_business_license_required_flag',
	su_fk_p.`is_internal_flag` AS 'su_fk_p__is_internal_flag',
	su_fk_p.`project_contract_date` AS 'su_fk_p__project_contract_date',
	su_fk_p.`project_start_date` AS 'su_fk_p__project_start_date',
	su_fk_p.`project_completed_date` AS 'su_fk_p__project_completed_date',
	su_fk_p.`sort_order` AS 'su_fk_p__sort_order',

	su_fk_sut.`id` AS 'su_fk_sut__submittal_type_id',
	su_fk_sut.`submittal_type` AS 'su_fk_sut__submittal_type',
	su_fk_sut.`disabled_flag` AS 'su_fk_sut__disabled_flag',

	su_fk_sus.`id` AS 'su_fk_sus__submittal_status_id',
	su_fk_sus.`submittal_status` AS 'su_fk_sus__submittal_status',
	su_fk_sus.`disabled_flag` AS 'su_fk_sus__disabled_flag',

	su_fk_sup.`id` AS 'su_fk_sup__submittal_priority_id',
	su_fk_sup.`submittal_priority` AS 'su_fk_sup__submittal_priority',
	su_fk_sup.`disabled_flag` AS 'su_fk_sup__disabled_flag',

	su_fk_sudm.`id` AS 'su_fk_sudm__submittal_distribution_method_id',
	su_fk_sudm.`submittal_distribution_method` AS 'su_fk_sudm__submittal_distribution_method',
	su_fk_sudm.`disabled_flag` AS 'su_fk_sudm__disabled_flag',

	su_fk_fmfiles.`id` AS 'su_fk_fmfiles__file_manager_file_id',
	su_fk_fmfiles.`user_company_id` AS 'su_fk_fmfiles__user_company_id',
	su_fk_fmfiles.`contact_id` AS 'su_fk_fmfiles__contact_id',
	su_fk_fmfiles.`project_id` AS 'su_fk_fmfiles__project_id',
	su_fk_fmfiles.`file_manager_folder_id` AS 'su_fk_fmfiles__file_manager_folder_id',
	su_fk_fmfiles.`file_location_id` AS 'su_fk_fmfiles__file_location_id',
	su_fk_fmfiles.`virtual_file_name` AS 'su_fk_fmfiles__virtual_file_name',
	su_fk_fmfiles.`version_number` AS 'su_fk_fmfiles__version_number',
	su_fk_fmfiles.`virtual_file_name_sha1` AS 'su_fk_fmfiles__virtual_file_name_sha1',
	su_fk_fmfiles.`virtual_file_mime_type` AS 'su_fk_fmfiles__virtual_file_mime_type',
	su_fk_fmfiles.`modified` AS 'su_fk_fmfiles__modified',
	su_fk_fmfiles.`created` AS 'su_fk_fmfiles__created',
	su_fk_fmfiles.`deleted_flag` AS 'su_fk_fmfiles__deleted_flag',
	su_fk_fmfiles.`directly_deleted_flag` AS 'su_fk_fmfiles__directly_deleted_flag',

	su_fk_codes.`id` AS 'su_fk_codes__cost_code_id',
	su_fk_codes.`cost_code_division_id` AS 'su_fk_codes__cost_code_division_id',
	su_fk_codes.`cost_code` AS 'su_fk_codes__cost_code',
	su_fk_codes.`cost_code_description` AS 'su_fk_codes__cost_code_description',
	su_fk_codes.`cost_code_description_abbreviation` AS 'su_fk_codes__cost_code_description_abbreviation',
	su_fk_codes.`sort_order` AS 'su_fk_codes__sort_order',
	su_fk_codes.`disabled_flag` AS 'su_fk_codes__disabled_flag',

	su_fk_creator_c.`id` AS 'su_fk_creator_c__contact_id',
	su_fk_creator_c.`user_company_id` AS 'su_fk_creator_c__user_company_id',
	su_fk_creator_c.`user_id` AS 'su_fk_creator_c__user_id',
	su_fk_creator_c.`contact_company_id` AS 'su_fk_creator_c__contact_company_id',
	su_fk_creator_c.`email` AS 'su_fk_creator_c__email',
	su_fk_creator_c.`name_prefix` AS 'su_fk_creator_c__name_prefix',
	su_fk_creator_c.`first_name` AS 'su_fk_creator_c__first_name',
	su_fk_creator_c.`additional_name` AS 'su_fk_creator_c__additional_name',
	su_fk_creator_c.`middle_name` AS 'su_fk_creator_c__middle_name',
	su_fk_creator_c.`last_name` AS 'su_fk_creator_c__last_name',
	su_fk_creator_c.`name_suffix` AS 'su_fk_creator_c__name_suffix',
	su_fk_creator_c.`title` AS 'su_fk_creator_c__title',
	su_fk_creator_c.`vendor_flag` AS 'su_fk_creator_c__vendor_flag',
	su_fk_creator_c.`is_archive` AS 'su_fk_creator_c__is_archive',

	su_fk_creator_cco.`id` AS 'su_fk_creator_cco__contact_company_office_id',
	su_fk_creator_cco.`contact_company_id` AS 'su_fk_creator_cco__contact_company_id',
	su_fk_creator_cco.`office_nickname` AS 'su_fk_creator_cco__office_nickname',
	su_fk_creator_cco.`address_line_1` AS 'su_fk_creator_cco__address_line_1',
	su_fk_creator_cco.`address_line_2` AS 'su_fk_creator_cco__address_line_2',
	su_fk_creator_cco.`address_line_3` AS 'su_fk_creator_cco__address_line_3',
	su_fk_creator_cco.`address_line_4` AS 'su_fk_creator_cco__address_line_4',
	su_fk_creator_cco.`address_city` AS 'su_fk_creator_cco__address_city',
	su_fk_creator_cco.`address_county` AS 'su_fk_creator_cco__address_county',
	su_fk_creator_cco.`address_state_or_region` AS 'su_fk_creator_cco__address_state_or_region',
	su_fk_creator_cco.`address_postal_code` AS 'su_fk_creator_cco__address_postal_code',
	su_fk_creator_cco.`address_postal_code_extension` AS 'su_fk_creator_cco__address_postal_code_extension',
	su_fk_creator_cco.`address_country` AS 'su_fk_creator_cco__address_country',
	su_fk_creator_cco.`head_quarters_flag` AS 'su_fk_creator_cco__head_quarters_flag',
	su_fk_creator_cco.`address_validated_by_user_flag` AS 'su_fk_creator_cco__address_validated_by_user_flag',
	su_fk_creator_cco.`address_validated_by_web_service_flag` AS 'su_fk_creator_cco__address_validated_by_web_service_flag',
	su_fk_creator_cco.`address_validation_by_web_service_error_flag` AS 'su_fk_creator_cco__address_validation_by_web_service_error_flag',

	su_fk_creator_phone_ccopn.`id` AS 'su_fk_creator_phone_ccopn__contact_company_office_phone_number_id',
	su_fk_creator_phone_ccopn.`contact_company_office_id` AS 'su_fk_creator_phone_ccopn__contact_company_office_id',
	su_fk_creator_phone_ccopn.`phone_number_type_id` AS 'su_fk_creator_phone_ccopn__phone_number_type_id',
	su_fk_creator_phone_ccopn.`country_code` AS 'su_fk_creator_phone_ccopn__country_code',
	su_fk_creator_phone_ccopn.`area_code` AS 'su_fk_creator_phone_ccopn__area_code',
	su_fk_creator_phone_ccopn.`prefix` AS 'su_fk_creator_phone_ccopn__prefix',
	su_fk_creator_phone_ccopn.`number` AS 'su_fk_creator_phone_ccopn__number',
	su_fk_creator_phone_ccopn.`extension` AS 'su_fk_creator_phone_ccopn__extension',
	su_fk_creator_phone_ccopn.`itu` AS 'su_fk_creator_phone_ccopn__itu',

	su_fk_creator_fax_ccopn.`id` AS 'su_fk_creator_fax_ccopn__contact_company_office_phone_number_id',
	su_fk_creator_fax_ccopn.`contact_company_office_id` AS 'su_fk_creator_fax_ccopn__contact_company_office_id',
	su_fk_creator_fax_ccopn.`phone_number_type_id` AS 'su_fk_creator_fax_ccopn__phone_number_type_id',
	su_fk_creator_fax_ccopn.`country_code` AS 'su_fk_creator_fax_ccopn__country_code',
	su_fk_creator_fax_ccopn.`area_code` AS 'su_fk_creator_fax_ccopn__area_code',
	su_fk_creator_fax_ccopn.`prefix` AS 'su_fk_creator_fax_ccopn__prefix',
	su_fk_creator_fax_ccopn.`number` AS 'su_fk_creator_fax_ccopn__number',
	su_fk_creator_fax_ccopn.`extension` AS 'su_fk_creator_fax_ccopn__extension',
	su_fk_creator_fax_ccopn.`itu` AS 'su_fk_creator_fax_ccopn__itu',

	su_fk_creator_c_mobile_cpn.`id` AS 'su_fk_creator_c_mobile_cpn__contact_phone_number_id',
	su_fk_creator_c_mobile_cpn.`contact_id` AS 'su_fk_creator_c_mobile_cpn__contact_id',
	su_fk_creator_c_mobile_cpn.`phone_number_type_id` AS 'su_fk_creator_c_mobile_cpn__phone_number_type_id',
	su_fk_creator_c_mobile_cpn.`country_code` AS 'su_fk_creator_c_mobile_cpn__country_code',
	su_fk_creator_c_mobile_cpn.`area_code` AS 'su_fk_creator_c_mobile_cpn__area_code',
	su_fk_creator_c_mobile_cpn.`prefix` AS 'su_fk_creator_c_mobile_cpn__prefix',
	su_fk_creator_c_mobile_cpn.`number` AS 'su_fk_creator_c_mobile_cpn__number',
	su_fk_creator_c_mobile_cpn.`extension` AS 'su_fk_creator_c_mobile_cpn__extension',
	su_fk_creator_c_mobile_cpn.`itu` AS 'su_fk_creator_c_mobile_cpn__itu',

	su_fk_recipient_c.`id` AS 'su_fk_recipient_c__contact_id',
	su_fk_recipient_c.`user_company_id` AS 'su_fk_recipient_c__user_company_id',
	su_fk_recipient_c.`user_id` AS 'su_fk_recipient_c__user_id',
	su_fk_recipient_c.`contact_company_id` AS 'su_fk_recipient_c__contact_company_id',
	su_fk_recipient_c.`email` AS 'su_fk_recipient_c__email',
	su_fk_recipient_c.`name_prefix` AS 'su_fk_recipient_c__name_prefix',
	su_fk_recipient_c.`first_name` AS 'su_fk_recipient_c__first_name',
	su_fk_recipient_c.`additional_name` AS 'su_fk_recipient_c__additional_name',
	su_fk_recipient_c.`middle_name` AS 'su_fk_recipient_c__middle_name',
	su_fk_recipient_c.`last_name` AS 'su_fk_recipient_c__last_name',
	su_fk_recipient_c.`name_suffix` AS 'su_fk_recipient_c__name_suffix',
	su_fk_recipient_c.`title` AS 'su_fk_recipient_c__title',
	su_fk_recipient_c.`vendor_flag` AS 'su_fk_recipient_c__vendor_flag',
	su_fk_recipient_c.`is_archive` AS 'su_fk_recipient_c__is_archive',

	su_fk_recipient_cco.`id` AS 'su_fk_recipient_cco__contact_company_office_id',
	su_fk_recipient_cco.`contact_company_id` AS 'su_fk_recipient_cco__contact_company_id',
	su_fk_recipient_cco.`office_nickname` AS 'su_fk_recipient_cco__office_nickname',
	su_fk_recipient_cco.`address_line_1` AS 'su_fk_recipient_cco__address_line_1',
	su_fk_recipient_cco.`address_line_2` AS 'su_fk_recipient_cco__address_line_2',
	su_fk_recipient_cco.`address_line_3` AS 'su_fk_recipient_cco__address_line_3',
	su_fk_recipient_cco.`address_line_4` AS 'su_fk_recipient_cco__address_line_4',
	su_fk_recipient_cco.`address_city` AS 'su_fk_recipient_cco__address_city',
	su_fk_recipient_cco.`address_county` AS 'su_fk_recipient_cco__address_county',
	su_fk_recipient_cco.`address_state_or_region` AS 'su_fk_recipient_cco__address_state_or_region',
	su_fk_recipient_cco.`address_postal_code` AS 'su_fk_recipient_cco__address_postal_code',
	su_fk_recipient_cco.`address_postal_code_extension` AS 'su_fk_recipient_cco__address_postal_code_extension',
	su_fk_recipient_cco.`address_country` AS 'su_fk_recipient_cco__address_country',
	su_fk_recipient_cco.`head_quarters_flag` AS 'su_fk_recipient_cco__head_quarters_flag',
	su_fk_recipient_cco.`address_validated_by_user_flag` AS 'su_fk_recipient_cco__address_validated_by_user_flag',
	su_fk_recipient_cco.`address_validated_by_web_service_flag` AS 'su_fk_recipient_cco__address_validated_by_web_service_flag',
	su_fk_recipient_cco.`address_validation_by_web_service_error_flag` AS 'su_fk_recipient_cco__address_validation_by_web_service_error_flag',

	su_fk_recipient_phone_ccopn.`id` AS 'su_fk_recipient_phone_ccopn__contact_company_office_phone_number_id',
	su_fk_recipient_phone_ccopn.`contact_company_office_id` AS 'su_fk_recipient_phone_ccopn__contact_company_office_id',
	su_fk_recipient_phone_ccopn.`phone_number_type_id` AS 'su_fk_recipient_phone_ccopn__phone_number_type_id',
	su_fk_recipient_phone_ccopn.`country_code` AS 'su_fk_recipient_phone_ccopn__country_code',
	su_fk_recipient_phone_ccopn.`area_code` AS 'su_fk_recipient_phone_ccopn__area_code',
	su_fk_recipient_phone_ccopn.`prefix` AS 'su_fk_recipient_phone_ccopn__prefix',
	su_fk_recipient_phone_ccopn.`number` AS 'su_fk_recipient_phone_ccopn__number',
	su_fk_recipient_phone_ccopn.`extension` AS 'su_fk_recipient_phone_ccopn__extension',
	su_fk_recipient_phone_ccopn.`itu` AS 'su_fk_recipient_phone_ccopn__itu',

	su_fk_recipient_fax_ccopn.`id` AS 'su_fk_recipient_fax_ccopn__contact_company_office_phone_number_id',
	su_fk_recipient_fax_ccopn.`contact_company_office_id` AS 'su_fk_recipient_fax_ccopn__contact_company_office_id',
	su_fk_recipient_fax_ccopn.`phone_number_type_id` AS 'su_fk_recipient_fax_ccopn__phone_number_type_id',
	su_fk_recipient_fax_ccopn.`country_code` AS 'su_fk_recipient_fax_ccopn__country_code',
	su_fk_recipient_fax_ccopn.`area_code` AS 'su_fk_recipient_fax_ccopn__area_code',
	su_fk_recipient_fax_ccopn.`prefix` AS 'su_fk_recipient_fax_ccopn__prefix',
	su_fk_recipient_fax_ccopn.`number` AS 'su_fk_recipient_fax_ccopn__number',
	su_fk_recipient_fax_ccopn.`extension` AS 'su_fk_recipient_fax_ccopn__extension',
	su_fk_recipient_fax_ccopn.`itu` AS 'su_fk_recipient_fax_ccopn__itu',

	su_fk_recipient_c_mobile_cpn.`id` AS 'su_fk_recipient_c_mobile_cpn__contact_phone_number_id',
	su_fk_recipient_c_mobile_cpn.`contact_id` AS 'su_fk_recipient_c_mobile_cpn__contact_id',
	su_fk_recipient_c_mobile_cpn.`phone_number_type_id` AS 'su_fk_recipient_c_mobile_cpn__phone_number_type_id',
	su_fk_recipient_c_mobile_cpn.`country_code` AS 'su_fk_recipient_c_mobile_cpn__country_code',
	su_fk_recipient_c_mobile_cpn.`area_code` AS 'su_fk_recipient_c_mobile_cpn__area_code',
	su_fk_recipient_c_mobile_cpn.`prefix` AS 'su_fk_recipient_c_mobile_cpn__prefix',
	su_fk_recipient_c_mobile_cpn.`number` AS 'su_fk_recipient_c_mobile_cpn__number',
	su_fk_recipient_c_mobile_cpn.`extension` AS 'su_fk_recipient_c_mobile_cpn__extension',
	su_fk_recipient_c_mobile_cpn.`itu` AS 'su_fk_recipient_c_mobile_cpn__itu',

	su_fk_initiator_c.`id` AS 'su_fk_initiator_c__contact_id',
	su_fk_initiator_c.`user_company_id` AS 'su_fk_initiator_c__user_company_id',
	su_fk_initiator_c.`user_id` AS 'su_fk_initiator_c__user_id',
	su_fk_initiator_c.`contact_company_id` AS 'su_fk_initiator_c__contact_company_id',
	su_fk_initiator_c.`email` AS 'su_fk_initiator_c__email',
	su_fk_initiator_c.`name_prefix` AS 'su_fk_initiator_c__name_prefix',
	su_fk_initiator_c.`first_name` AS 'su_fk_initiator_c__first_name',
	su_fk_initiator_c.`additional_name` AS 'su_fk_initiator_c__additional_name',
	su_fk_initiator_c.`middle_name` AS 'su_fk_initiator_c__middle_name',
	su_fk_initiator_c.`last_name` AS 'su_fk_initiator_c__last_name',
	su_fk_initiator_c.`name_suffix` AS 'su_fk_initiator_c__name_suffix',
	su_fk_initiator_c.`title` AS 'su_fk_initiator_c__title',
	su_fk_initiator_c.`vendor_flag` AS 'su_fk_initiator_c__vendor_flag',
	su_fk_initiator_c.`is_archive` AS 'su_fk_initiator_c__is_archive',

	su_fk_initiator_cco.`id` AS 'su_fk_initiator_cco__contact_company_office_id',
	su_fk_initiator_cco.`contact_company_id` AS 'su_fk_initiator_cco__contact_company_id',
	su_fk_initiator_cco.`office_nickname` AS 'su_fk_initiator_cco__office_nickname',
	su_fk_initiator_cco.`address_line_1` AS 'su_fk_initiator_cco__address_line_1',
	su_fk_initiator_cco.`address_line_2` AS 'su_fk_initiator_cco__address_line_2',
	su_fk_initiator_cco.`address_line_3` AS 'su_fk_initiator_cco__address_line_3',
	su_fk_initiator_cco.`address_line_4` AS 'su_fk_initiator_cco__address_line_4',
	su_fk_initiator_cco.`address_city` AS 'su_fk_initiator_cco__address_city',
	su_fk_initiator_cco.`address_county` AS 'su_fk_initiator_cco__address_county',
	su_fk_initiator_cco.`address_state_or_region` AS 'su_fk_initiator_cco__address_state_or_region',
	su_fk_initiator_cco.`address_postal_code` AS 'su_fk_initiator_cco__address_postal_code',
	su_fk_initiator_cco.`address_postal_code_extension` AS 'su_fk_initiator_cco__address_postal_code_extension',
	su_fk_initiator_cco.`address_country` AS 'su_fk_initiator_cco__address_country',
	su_fk_initiator_cco.`head_quarters_flag` AS 'su_fk_initiator_cco__head_quarters_flag',
	su_fk_initiator_cco.`address_validated_by_user_flag` AS 'su_fk_initiator_cco__address_validated_by_user_flag',
	su_fk_initiator_cco.`address_validated_by_web_service_flag` AS 'su_fk_initiator_cco__address_validated_by_web_service_flag',
	su_fk_initiator_cco.`address_validation_by_web_service_error_flag` AS 'su_fk_initiator_cco__address_validation_by_web_service_error_flag',

	su_fk_initiator_phone_ccopn.`id` AS 'su_fk_initiator_phone_ccopn__contact_company_office_phone_number_id',
	su_fk_initiator_phone_ccopn.`contact_company_office_id` AS 'su_fk_initiator_phone_ccopn__contact_company_office_id',
	su_fk_initiator_phone_ccopn.`phone_number_type_id` AS 'su_fk_initiator_phone_ccopn__phone_number_type_id',
	su_fk_initiator_phone_ccopn.`country_code` AS 'su_fk_initiator_phone_ccopn__country_code',
	su_fk_initiator_phone_ccopn.`area_code` AS 'su_fk_initiator_phone_ccopn__area_code',
	su_fk_initiator_phone_ccopn.`prefix` AS 'su_fk_initiator_phone_ccopn__prefix',
	su_fk_initiator_phone_ccopn.`number` AS 'su_fk_initiator_phone_ccopn__number',
	su_fk_initiator_phone_ccopn.`extension` AS 'su_fk_initiator_phone_ccopn__extension',
	su_fk_initiator_phone_ccopn.`itu` AS 'su_fk_initiator_phone_ccopn__itu',

	su_fk_initiator_fax_ccopn.`id` AS 'su_fk_initiator_fax_ccopn__contact_company_office_phone_number_id',
	su_fk_initiator_fax_ccopn.`contact_company_office_id` AS 'su_fk_initiator_fax_ccopn__contact_company_office_id',
	su_fk_initiator_fax_ccopn.`phone_number_type_id` AS 'su_fk_initiator_fax_ccopn__phone_number_type_id',
	su_fk_initiator_fax_ccopn.`country_code` AS 'su_fk_initiator_fax_ccopn__country_code',
	su_fk_initiator_fax_ccopn.`area_code` AS 'su_fk_initiator_fax_ccopn__area_code',
	su_fk_initiator_fax_ccopn.`prefix` AS 'su_fk_initiator_fax_ccopn__prefix',
	su_fk_initiator_fax_ccopn.`number` AS 'su_fk_initiator_fax_ccopn__number',
	su_fk_initiator_fax_ccopn.`extension` AS 'su_fk_initiator_fax_ccopn__extension',
	su_fk_initiator_fax_ccopn.`itu` AS 'su_fk_initiator_fax_ccopn__itu',

	su_fk_initiator_c_mobile_cpn.`id` AS 'su_fk_initiator_c_mobile_cpn__contact_phone_number_id',
	su_fk_initiator_c_mobile_cpn.`contact_id` AS 'su_fk_initiator_c_mobile_cpn__contact_id',
	su_fk_initiator_c_mobile_cpn.`phone_number_type_id` AS 'su_fk_initiator_c_mobile_cpn__phone_number_type_id',
	su_fk_initiator_c_mobile_cpn.`country_code` AS 'su_fk_initiator_c_mobile_cpn__country_code',
	su_fk_initiator_c_mobile_cpn.`area_code` AS 'su_fk_initiator_c_mobile_cpn__area_code',
	su_fk_initiator_c_mobile_cpn.`prefix` AS 'su_fk_initiator_c_mobile_cpn__prefix',
	su_fk_initiator_c_mobile_cpn.`number` AS 'su_fk_initiator_c_mobile_cpn__number',
	su_fk_initiator_c_mobile_cpn.`extension` AS 'su_fk_initiator_c_mobile_cpn__extension',
	su_fk_initiator_c_mobile_cpn.`itu` AS 'su_fk_initiator_c_mobile_cpn__itu',

	su.*

FROM `submittals` su
	INNER JOIN `projects` su_fk_p ON su.`project_id` = su_fk_p.`id`
	INNER JOIN `submittal_types` su_fk_sut ON su.`submittal_type_id` = su_fk_sut.`id`
	INNER JOIN `submittal_statuses` su_fk_sus ON su.`submittal_status_id` = su_fk_sus.`id`
	INNER JOIN `submittal_priorities` su_fk_sup ON su.`submittal_priority_id` = su_fk_sup.`id`
	INNER JOIN `submittal_distribution_methods` su_fk_sudm ON su.`submittal_distribution_method_id` = su_fk_sudm.`id`
	LEFT OUTER JOIN `file_manager_files` su_fk_fmfiles ON su.`su_file_manager_file_id` = su_fk_fmfiles.`id`
	LEFT OUTER JOIN `cost_codes` su_fk_codes ON su.`su_cost_code_id` = su_fk_codes.`id`
	INNER JOIN `contacts` su_fk_creator_c ON su.`su_creator_contact_id` = su_fk_creator_c.`id`
	LEFT OUTER JOIN `contact_company_offices` su_fk_creator_cco ON su.`su_creator_contact_company_office_id` = su_fk_creator_cco.`id`
	LEFT OUTER JOIN `contact_company_office_phone_numbers` su_fk_creator_phone_ccopn ON su.`su_creator_phone_contact_company_office_phone_number_id` = su_fk_creator_phone_ccopn.`id`
	LEFT OUTER JOIN `contact_company_office_phone_numbers` su_fk_creator_fax_ccopn ON su.`su_creator_fax_contact_company_office_phone_number_id` = su_fk_creator_fax_ccopn.`id`
	LEFT OUTER JOIN `contact_phone_numbers` su_fk_creator_c_mobile_cpn ON su.`su_creator_contact_mobile_phone_number_id` = su_fk_creator_c_mobile_cpn.`id`
	LEFT OUTER JOIN `contacts` su_fk_recipient_c ON su.`su_recipient_contact_id` = su_fk_recipient_c.`id`
	LEFT OUTER JOIN `contact_company_offices` su_fk_recipient_cco ON su.`su_recipient_contact_company_office_id` = su_fk_recipient_cco.`id`
	LEFT OUTER JOIN `contact_company_office_phone_numbers` su_fk_recipient_phone_ccopn ON su.`su_recipient_phone_contact_company_office_phone_number_id` = su_fk_recipient_phone_ccopn.`id`
	LEFT OUTER JOIN `contact_company_office_phone_numbers` su_fk_recipient_fax_ccopn ON su.`su_recipient_fax_contact_company_office_phone_number_id` = su_fk_recipient_fax_ccopn.`id`
	LEFT OUTER JOIN `contact_phone_numbers` su_fk_recipient_c_mobile_cpn ON su.`su_recipient_contact_mobile_phone_number_id` = su_fk_recipient_c_mobile_cpn.`id`
	LEFT OUTER JOIN `contacts` su_fk_initiator_c ON su.`su_initiator_contact_id` = su_fk_initiator_c.`id`
	LEFT OUTER JOIN `contact_company_offices` su_fk_initiator_cco ON su.`su_initiator_contact_company_office_id` = su_fk_initiator_cco.`id`
	LEFT OUTER JOIN `contact_company_office_phone_numbers` su_fk_initiator_phone_ccopn ON su.`su_initiator_phone_contact_company_office_phone_number_id` = su_fk_initiator_phone_ccopn.`id`
	LEFT OUTER JOIN `contact_company_office_phone_numbers` su_fk_initiator_fax_ccopn ON su.`su_initiator_fax_contact_company_office_phone_number_id` = su_fk_initiator_fax_ccopn.`id`
	LEFT OUTER JOIN `contact_phone_numbers` su_fk_initiator_c_mobile_cpn ON su.`su_initiator_contact_mobile_phone_number_id` = su_fk_initiator_c_mobile_cpn.`id`
WHERE su.`project_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `su_sequence_number` ASC, `submittal_type_id` ASC, `submittal_status_id` ASC, `submittal_priority_id` ASC, `su_file_manager_file_id` ASC, `su_cost_code_id` ASC, `su_creator_contact_id` ASC, `su_creator_contact_company_office_id` ASC, `su_creator_phone_contact_company_office_phone_number_id` ASC, `su_creator_fax_contact_company_office_phone_number_id` ASC, `su_creator_contact_mobile_phone_number_id` ASC, `su_recipient_contact_id` ASC, `su_recipient_contact_company_office_id` ASC, `su_recipient_phone_contact_company_office_phone_number_id` ASC, `su_recipient_fax_contact_company_office_phone_number_id` ASC, `su_recipient_contact_mobile_phone_number_id` ASC, `su_initiator_contact_id` ASC, `su_initiator_contact_company_office_id` ASC, `su_initiator_phone_contact_company_office_phone_number_id` ASC, `su_initiator_fax_contact_company_office_phone_number_id` ASC, `su_initiator_contact_mobile_phone_number_id` ASC, `su_title` ASC, `su_plan_page_reference` ASC, `su_statement` ASC, `created` ASC, `su_due_date` ASC, `su_closed_date` ASC
		$arrValues = array($project_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubmittalsByProjectId = array();
		while ($row = $db->fetch()) {
			$submittal_id = $row['id'];
			$submittal = self::instantiateOrm($database, 'Submittal', $row, null, $submittal_id);
			/* @var $submittal Submittal */
			$submittal->convertPropertiesToData();

			if (isset($row['project_id'])) {
				$project_id = $row['project_id'];
				$row['su_fk_p__id'] = $project_id;
				$project = self::instantiateOrm($database, 'Project', $row, null, $project_id, 'su_fk_p__');
				/* @var $project Project */
				$project->convertPropertiesToData();
			} else {
				$project = false;
			}
			$submittal->setProject($project);

			if (isset($row['submittal_type_id'])) {
				$submittal_type_id = $row['submittal_type_id'];
				$row['su_fk_sut__id'] = $submittal_type_id;
				$submittalType = self::instantiateOrm($database, 'SubmittalType', $row, null, $submittal_type_id, 'su_fk_sut__');
				/* @var $submittalType SubmittalType */
				$submittalType->convertPropertiesToData();
			} else {
				$submittalType = false;
			}
			$submittal->setSubmittalType($submittalType);

			if (isset($row['submittal_status_id'])) {
				$submittal_status_id = $row['submittal_status_id'];
				$row['su_fk_sus__id'] = $submittal_status_id;
				$submittalStatus = self::instantiateOrm($database, 'SubmittalStatus', $row, null, $submittal_status_id, 'su_fk_sus__');
				/* @var $submittalStatus SubmittalStatus */
				$submittalStatus->convertPropertiesToData();
			} else {
				$submittalStatus = false;
			}
			$submittal->setSubmittalStatus($submittalStatus);

			if (isset($row['submittal_priority_id'])) {
				$submittal_priority_id = $row['submittal_priority_id'];
				$row['su_fk_sup__id'] = $submittal_priority_id;
				$submittalPriority = self::instantiateOrm($database, 'SubmittalPriority', $row, null, $submittal_priority_id, 'su_fk_sup__');
				/* @var $submittalPriority SubmittalPriority */
				$submittalPriority->convertPropertiesToData();
			} else {
				$submittalPriority = false;
			}
			$submittal->setSubmittalPriority($submittalPriority);

			if (isset($row['submittal_distribution_method_id'])) {
				$submittal_distribution_method_id = $row['submittal_distribution_method_id'];
				$row['su_fk_sudm__id'] = $submittal_distribution_method_id;
				$submittalDistributionMethod = self::instantiateOrm($database, 'SubmittalDistributionMethod', $row, null, $submittal_distribution_method_id, 'su_fk_sudm__');
				/* @var $submittalDistributionMethod SubmittalDistributionMethod */
				$submittalDistributionMethod->convertPropertiesToData();
			} else {
				$submittalDistributionMethod = false;
			}
			$submittal->setSubmittalDistributionMethod($submittalDistributionMethod);

			if (isset($row['su_file_manager_file_id'])) {
				$su_file_manager_file_id = $row['su_file_manager_file_id'];
				$row['su_fk_fmfiles__id'] = $su_file_manager_file_id;
				$suFileManagerFile = self::instantiateOrm($database, 'FileManagerFile', $row, null, $su_file_manager_file_id, 'su_fk_fmfiles__');
				/* @var $suFileManagerFile FileManagerFile */
				$suFileManagerFile->convertPropertiesToData();
			} else {
				$suFileManagerFile = false;
			}
			$submittal->setSuFileManagerFile($suFileManagerFile);

			if (isset($row['su_cost_code_id'])) {
				$su_cost_code_id = $row['su_cost_code_id'];
				$row['su_fk_codes__id'] = $su_cost_code_id;
				$suCostCode = self::instantiateOrm($database, 'CostCode', $row, null, $su_cost_code_id, 'su_fk_codes__');
				/* @var $suCostCode CostCode */
				$suCostCode->convertPropertiesToData();
			} else {
				$suCostCode = false;
			}
			$submittal->setSuCostCode($suCostCode);

			if (isset($row['su_creator_contact_id'])) {
				$su_creator_contact_id = $row['su_creator_contact_id'];
				$row['su_fk_creator_c__id'] = $su_creator_contact_id;
				$suCreatorContact = self::instantiateOrm($database, 'Contact', $row, null, $su_creator_contact_id, 'su_fk_creator_c__');
				/* @var $suCreatorContact Contact */
				$suCreatorContact->convertPropertiesToData();
			} else {
				$suCreatorContact = false;
			}
			$submittal->setSuCreatorContact($suCreatorContact);

			if (isset($row['su_creator_contact_company_office_id'])) {
				$su_creator_contact_company_office_id = $row['su_creator_contact_company_office_id'];
				$row['su_fk_creator_cco__id'] = $su_creator_contact_company_office_id;
				$suCreatorContactCompanyOffice = self::instantiateOrm($database, 'ContactCompanyOffice', $row, null, $su_creator_contact_company_office_id, 'su_fk_creator_cco__');
				/* @var $suCreatorContactCompanyOffice ContactCompanyOffice */
				$suCreatorContactCompanyOffice->convertPropertiesToData();
			} else {
				$suCreatorContactCompanyOffice = false;
			}
			$submittal->setSuCreatorContactCompanyOffice($suCreatorContactCompanyOffice);

			if (isset($row['su_creator_phone_contact_company_office_phone_number_id'])) {
				$su_creator_phone_contact_company_office_phone_number_id = $row['su_creator_phone_contact_company_office_phone_number_id'];
				$row['su_fk_creator_phone_ccopn__id'] = $su_creator_phone_contact_company_office_phone_number_id;
				$suCreatorPhoneContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $su_creator_phone_contact_company_office_phone_number_id, 'su_fk_creator_phone_ccopn__');
				/* @var $suCreatorPhoneContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$suCreatorPhoneContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$suCreatorPhoneContactCompanyOfficePhoneNumber = false;
			}
			$submittal->setSuCreatorPhoneContactCompanyOfficePhoneNumber($suCreatorPhoneContactCompanyOfficePhoneNumber);

			if (isset($row['su_creator_fax_contact_company_office_phone_number_id'])) {
				$su_creator_fax_contact_company_office_phone_number_id = $row['su_creator_fax_contact_company_office_phone_number_id'];
				$row['su_fk_creator_fax_ccopn__id'] = $su_creator_fax_contact_company_office_phone_number_id;
				$suCreatorFaxContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $su_creator_fax_contact_company_office_phone_number_id, 'su_fk_creator_fax_ccopn__');
				/* @var $suCreatorFaxContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$suCreatorFaxContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$suCreatorFaxContactCompanyOfficePhoneNumber = false;
			}
			$submittal->setSuCreatorFaxContactCompanyOfficePhoneNumber($suCreatorFaxContactCompanyOfficePhoneNumber);

			if (isset($row['su_creator_contact_mobile_phone_number_id'])) {
				$su_creator_contact_mobile_phone_number_id = $row['su_creator_contact_mobile_phone_number_id'];
				$row['su_fk_creator_c_mobile_cpn__id'] = $su_creator_contact_mobile_phone_number_id;
				$suCreatorContactMobilePhoneNumber = self::instantiateOrm($database, 'ContactPhoneNumber', $row, null, $su_creator_contact_mobile_phone_number_id, 'su_fk_creator_c_mobile_cpn__');
				/* @var $suCreatorContactMobilePhoneNumber ContactPhoneNumber */
				$suCreatorContactMobilePhoneNumber->convertPropertiesToData();
			} else {
				$suCreatorContactMobilePhoneNumber = false;
			}
			$submittal->setSuCreatorContactMobilePhoneNumber($suCreatorContactMobilePhoneNumber);

			if (isset($row['su_recipient_contact_id'])) {
				$su_recipient_contact_id = $row['su_recipient_contact_id'];
				$row['su_fk_recipient_c__id'] = $su_recipient_contact_id;
				$suRecipientContact = self::instantiateOrm($database, 'Contact', $row, null, $su_recipient_contact_id, 'su_fk_recipient_c__');
				/* @var $suRecipientContact Contact */
				$suRecipientContact->convertPropertiesToData();
			} else {
				$suRecipientContact = false;
			}
			$submittal->setSuRecipientContact($suRecipientContact);

			if (isset($row['su_recipient_contact_company_office_id'])) {
				$su_recipient_contact_company_office_id = $row['su_recipient_contact_company_office_id'];
				$row['su_fk_recipient_cco__id'] = $su_recipient_contact_company_office_id;
				$suRecipientContactCompanyOffice = self::instantiateOrm($database, 'ContactCompanyOffice', $row, null, $su_recipient_contact_company_office_id, 'su_fk_recipient_cco__');
				/* @var $suRecipientContactCompanyOffice ContactCompanyOffice */
				$suRecipientContactCompanyOffice->convertPropertiesToData();
			} else {
				$suRecipientContactCompanyOffice = false;
			}
			$submittal->setSuRecipientContactCompanyOffice($suRecipientContactCompanyOffice);

			if (isset($row['su_recipient_phone_contact_company_office_phone_number_id'])) {
				$su_recipient_phone_contact_company_office_phone_number_id = $row['su_recipient_phone_contact_company_office_phone_number_id'];
				$row['su_fk_recipient_phone_ccopn__id'] = $su_recipient_phone_contact_company_office_phone_number_id;
				$suRecipientPhoneContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $su_recipient_phone_contact_company_office_phone_number_id, 'su_fk_recipient_phone_ccopn__');
				/* @var $suRecipientPhoneContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$suRecipientPhoneContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$suRecipientPhoneContactCompanyOfficePhoneNumber = false;
			}
			$submittal->setSuRecipientPhoneContactCompanyOfficePhoneNumber($suRecipientPhoneContactCompanyOfficePhoneNumber);

			if (isset($row['su_recipient_fax_contact_company_office_phone_number_id'])) {
				$su_recipient_fax_contact_company_office_phone_number_id = $row['su_recipient_fax_contact_company_office_phone_number_id'];
				$row['su_fk_recipient_fax_ccopn__id'] = $su_recipient_fax_contact_company_office_phone_number_id;
				$suRecipientFaxContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $su_recipient_fax_contact_company_office_phone_number_id, 'su_fk_recipient_fax_ccopn__');
				/* @var $suRecipientFaxContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$suRecipientFaxContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$suRecipientFaxContactCompanyOfficePhoneNumber = false;
			}
			$submittal->setSuRecipientFaxContactCompanyOfficePhoneNumber($suRecipientFaxContactCompanyOfficePhoneNumber);

			if (isset($row['su_recipient_contact_mobile_phone_number_id'])) {
				$su_recipient_contact_mobile_phone_number_id = $row['su_recipient_contact_mobile_phone_number_id'];
				$row['su_fk_recipient_c_mobile_cpn__id'] = $su_recipient_contact_mobile_phone_number_id;
				$suRecipientContactMobilePhoneNumber = self::instantiateOrm($database, 'ContactPhoneNumber', $row, null, $su_recipient_contact_mobile_phone_number_id, 'su_fk_recipient_c_mobile_cpn__');
				/* @var $suRecipientContactMobilePhoneNumber ContactPhoneNumber */
				$suRecipientContactMobilePhoneNumber->convertPropertiesToData();
			} else {
				$suRecipientContactMobilePhoneNumber = false;
			}
			$submittal->setSuRecipientContactMobilePhoneNumber($suRecipientContactMobilePhoneNumber);

			if (isset($row['su_initiator_contact_id'])) {
				$su_initiator_contact_id = $row['su_initiator_contact_id'];
				$row['su_fk_initiator_c__id'] = $su_initiator_contact_id;
				$suInitiatorContact = self::instantiateOrm($database, 'Contact', $row, null, $su_initiator_contact_id, 'su_fk_initiator_c__');
				/* @var $suInitiatorContact Contact */
				$suInitiatorContact->convertPropertiesToData();
			} else {
				$suInitiatorContact = false;
			}
			$submittal->setSuInitiatorContact($suInitiatorContact);

			if (isset($row['su_initiator_contact_company_office_id'])) {
				$su_initiator_contact_company_office_id = $row['su_initiator_contact_company_office_id'];
				$row['su_fk_initiator_cco__id'] = $su_initiator_contact_company_office_id;
				$suInitiatorContactCompanyOffice = self::instantiateOrm($database, 'ContactCompanyOffice', $row, null, $su_initiator_contact_company_office_id, 'su_fk_initiator_cco__');
				/* @var $suInitiatorContactCompanyOffice ContactCompanyOffice */
				$suInitiatorContactCompanyOffice->convertPropertiesToData();
			} else {
				$suInitiatorContactCompanyOffice = false;
			}
			$submittal->setSuInitiatorContactCompanyOffice($suInitiatorContactCompanyOffice);

			if (isset($row['su_initiator_phone_contact_company_office_phone_number_id'])) {
				$su_initiator_phone_contact_company_office_phone_number_id = $row['su_initiator_phone_contact_company_office_phone_number_id'];
				$row['su_fk_initiator_phone_ccopn__id'] = $su_initiator_phone_contact_company_office_phone_number_id;
				$suInitiatorPhoneContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $su_initiator_phone_contact_company_office_phone_number_id, 'su_fk_initiator_phone_ccopn__');
				/* @var $suInitiatorPhoneContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$suInitiatorPhoneContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$suInitiatorPhoneContactCompanyOfficePhoneNumber = false;
			}
			$submittal->setSuInitiatorPhoneContactCompanyOfficePhoneNumber($suInitiatorPhoneContactCompanyOfficePhoneNumber);

			if (isset($row['su_initiator_fax_contact_company_office_phone_number_id'])) {
				$su_initiator_fax_contact_company_office_phone_number_id = $row['su_initiator_fax_contact_company_office_phone_number_id'];
				$row['su_fk_initiator_fax_ccopn__id'] = $su_initiator_fax_contact_company_office_phone_number_id;
				$suInitiatorFaxContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $su_initiator_fax_contact_company_office_phone_number_id, 'su_fk_initiator_fax_ccopn__');
				/* @var $suInitiatorFaxContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$suInitiatorFaxContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$suInitiatorFaxContactCompanyOfficePhoneNumber = false;
			}
			$submittal->setSuInitiatorFaxContactCompanyOfficePhoneNumber($suInitiatorFaxContactCompanyOfficePhoneNumber);

			if (isset($row['su_initiator_contact_mobile_phone_number_id'])) {
				$su_initiator_contact_mobile_phone_number_id = $row['su_initiator_contact_mobile_phone_number_id'];
				$row['su_fk_initiator_c_mobile_cpn__id'] = $su_initiator_contact_mobile_phone_number_id;
				$suInitiatorContactMobilePhoneNumber = self::instantiateOrm($database, 'ContactPhoneNumber', $row, null, $su_initiator_contact_mobile_phone_number_id, 'su_fk_initiator_c_mobile_cpn__');
				/* @var $suInitiatorContactMobilePhoneNumber ContactPhoneNumber */
				$suInitiatorContactMobilePhoneNumber->convertPropertiesToData();
			} else {
				$suInitiatorContactMobilePhoneNumber = false;
			}
			$submittal->setSuInitiatorContactMobilePhoneNumber($suInitiatorContactMobilePhoneNumber);

			$arrSubmittalsByProjectId[$submittal_id] = $submittal;
		}

		$db->free_result();

		self::$_arrSubmittalsByProjectId = $arrSubmittalsByProjectId;

		return $arrSubmittalsByProjectId;
	}
	// Loaders: Load By Foreign Key
	/** This function call from API
	 * Load by constraint `submittals_fk_p` foreign key (`project_id`) references `projects` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $project_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubmittalsByProjectIdUsingApi($database, $project_id, Input $options=null, $orderby, $where)
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
			self::$_arrSubmittalsByProjectId = null;
		}

		$arrSubmittalsByProjectId = self::$_arrSubmittalsByProjectId;
		if (isset($arrSubmittalsByProjectId) && !empty($arrSubmittalsByProjectId)) {
			return $arrSubmittalsByProjectId;
		}

		$project_id = (int) $project_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `su_sequence_number` ASC, `submittal_type_id` ASC, `submittal_status_id` ASC, `submittal_priority_id` ASC, `su_file_manager_file_id` ASC, `su_cost_code_id` ASC, `su_creator_contact_id` ASC, `su_creator_contact_company_office_id` ASC, `su_creator_phone_contact_company_office_phone_number_id` ASC, `su_creator_fax_contact_company_office_phone_number_id` ASC, `su_creator_contact_mobile_phone_number_id` ASC, `su_recipient_contact_id` ASC, `su_recipient_contact_company_office_id` ASC, `su_recipient_phone_contact_company_office_phone_number_id` ASC, `su_recipient_fax_contact_company_office_phone_number_id` ASC, `su_recipient_contact_mobile_phone_number_id` ASC, `su_initiator_contact_id` ASC, `su_initiator_contact_company_office_id` ASC, `su_initiator_phone_contact_company_office_phone_number_id` ASC, `su_initiator_fax_contact_company_office_phone_number_id` ASC, `su_initiator_contact_mobile_phone_number_id` ASC, `su_title` ASC, `su_plan_page_reference` ASC, `su_statement` ASC, `created` ASC, `su_due_date` ASC, `su_closed_date` ASC
		// $sqlOrderBy = "\nORDER BY `created` DESC, `su_sequence_number` DESC, `submittal_priority_id` ASC, `submittal_type_id` ASC, `submittal_status_id` ASC";
		// $sqlOrderBy = "\nORDER BY -su_fk_initiator_ccs__company IS NULL ASC, -su_fk_code_division__division_number IS NULL ASC, -su_fk_codes__cost_code IS NULL ASC ";
		$sqlOrderBy = "\nORDER BY su_fk_initiator_ccs.`company` IS NULL ASC,su_fk_initiator_ccs.`company` ASC, concat_costcode IS NULL ASC, concat_costcode ASC, su_fk_initiator_ccs.`company` ASC ";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubmittal = new Submittal($database);
			$sqlOrderByColumns = $tmpSubmittal->constructSqlOrderByColumns($arrOrderByAttributes);

			if (!empty($sqlOrderByColumns)) {
				$sqlOrderBy = "\nORDER BY $sqlOrderByColumns";
			}
		}
		if($orderby!='' && $orderby!=null){
			$sqlOrderBy = $orderby;
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
	CONCAT(su_fk_code_division.`division_number`,su_fk_codes.`cost_code`) AS 'concat_costcode',

	su_fk_p.`id` AS 'su_fk_p__project_id',
	su_fk_p.`project_type_id` AS 'su_fk_p__project_type_id',
	su_fk_p.`user_company_id` AS 'su_fk_p__user_company_id',
	su_fk_p.`user_custom_project_id` AS 'su_fk_p__user_custom_project_id',
	su_fk_p.`project_name` AS 'su_fk_p__project_name',
	su_fk_p.`project_owner_name` AS 'su_fk_p__project_owner_name',
	su_fk_p.`latitude` AS 'su_fk_p__latitude',
	su_fk_p.`longitude` AS 'su_fk_p__longitude',
	su_fk_p.`address_line_1` AS 'su_fk_p__address_line_1',
	su_fk_p.`address_line_2` AS 'su_fk_p__address_line_2',
	su_fk_p.`address_line_3` AS 'su_fk_p__address_line_3',
	su_fk_p.`address_line_4` AS 'su_fk_p__address_line_4',
	su_fk_p.`address_city` AS 'su_fk_p__address_city',
	su_fk_p.`address_county` AS 'su_fk_p__address_county',
	su_fk_p.`address_state_or_region` AS 'su_fk_p__address_state_or_region',
	su_fk_p.`address_postal_code` AS 'su_fk_p__address_postal_code',
	su_fk_p.`address_postal_code_extension` AS 'su_fk_p__address_postal_code_extension',
	su_fk_p.`address_country` AS 'su_fk_p__address_country',
	su_fk_p.`building_count` AS 'su_fk_p__building_count',
	su_fk_p.`unit_count` AS 'su_fk_p__unit_count',
	su_fk_p.`gross_square_footage` AS 'su_fk_p__gross_square_footage',
	su_fk_p.`net_rentable_square_footage` AS 'su_fk_p__net_rentable_square_footage',
	su_fk_p.`is_active_flag` AS 'su_fk_p__is_active_flag',
	su_fk_p.`public_plans_flag` AS 'su_fk_p__public_plans_flag',
	su_fk_p.`prevailing_wage_flag` AS 'su_fk_p__prevailing_wage_flag',
	su_fk_p.`city_business_license_required_flag` AS 'su_fk_p__city_business_license_required_flag',
	su_fk_p.`is_internal_flag` AS 'su_fk_p__is_internal_flag',
	su_fk_p.`project_contract_date` AS 'su_fk_p__project_contract_date',
	su_fk_p.`project_start_date` AS 'su_fk_p__project_start_date',
	su_fk_p.`project_completed_date` AS 'su_fk_p__project_completed_date',
	su_fk_p.`sort_order` AS 'su_fk_p__sort_order',

	su_fk_sut.`id` AS 'su_fk_sut__submittal_type_id',
	su_fk_sut.`submittal_type` AS 'su_fk_sut__submittal_type',
	su_fk_sut.`disabled_flag` AS 'su_fk_sut__disabled_flag',

	su_fk_sus.`id` AS 'su_fk_sus__submittal_status_id',
	su_fk_sus.`submittal_status` AS 'su_fk_sus__submittal_status',
	su_fk_sus.`disabled_flag` AS 'su_fk_sus__disabled_flag',

	su_fk_sup.`id` AS 'su_fk_sup__submittal_priority_id',
	su_fk_sup.`submittal_priority` AS 'su_fk_sup__submittal_priority',
	su_fk_sup.`disabled_flag` AS 'su_fk_sup__disabled_flag',

	su_fk_sudm.`id` AS 'su_fk_sudm__submittal_distribution_method_id',
	su_fk_sudm.`submittal_distribution_method` AS 'su_fk_sudm__submittal_distribution_method',
	su_fk_sudm.`disabled_flag` AS 'su_fk_sudm__disabled_flag',

	su_fk_fmfiles.`id` AS 'su_fk_fmfiles__file_manager_file_id',
	su_fk_fmfiles.`user_company_id` AS 'su_fk_fmfiles__user_company_id',
	su_fk_fmfiles.`contact_id` AS 'su_fk_fmfiles__contact_id',
	su_fk_fmfiles.`project_id` AS 'su_fk_fmfiles__project_id',
	su_fk_fmfiles.`file_manager_folder_id` AS 'su_fk_fmfiles__file_manager_folder_id',
	su_fk_fmfiles.`file_location_id` AS 'su_fk_fmfiles__file_location_id',
	su_fk_fmfiles.`virtual_file_name` AS 'su_fk_fmfiles__virtual_file_name',
	su_fk_fmfiles.`version_number` AS 'su_fk_fmfiles__version_number',
	su_fk_fmfiles.`virtual_file_name_sha1` AS 'su_fk_fmfiles__virtual_file_name_sha1',
	su_fk_fmfiles.`virtual_file_mime_type` AS 'su_fk_fmfiles__virtual_file_mime_type',
	su_fk_fmfiles.`modified` AS 'su_fk_fmfiles__modified',
	su_fk_fmfiles.`created` AS 'su_fk_fmfiles__created',
	su_fk_fmfiles.`deleted_flag` AS 'su_fk_fmfiles__deleted_flag',
	su_fk_fmfiles.`directly_deleted_flag` AS 'su_fk_fmfiles__directly_deleted_flag',

	su_fk_codes.`id` AS 'su_fk_codes__cost_code_id',
	su_fk_codes.`cost_code_division_id` AS 'su_fk_codes__cost_code_division_id',
	su_fk_codes.`cost_code` AS 'su_fk_codes__cost_code',
	su_fk_codes.`cost_code_description` AS 'su_fk_codes__cost_code_description',
	su_fk_codes.`cost_code_description_abbreviation` AS 'su_fk_codes__cost_code_description_abbreviation',
	su_fk_codes.`sort_order` AS 'su_fk_codes__sort_order',
	su_fk_codes.`disabled_flag` AS 'su_fk_codes__disabled_flag',

	su_fk_code_division.`division_number` AS 'su_fk_code_division__division_number',

	su_fk_creator_c.`id` AS 'su_fk_creator_c__contact_id',
	su_fk_creator_c.`user_company_id` AS 'su_fk_creator_c__user_company_id',
	su_fk_creator_c.`user_id` AS 'su_fk_creator_c__user_id',
	su_fk_creator_c.`contact_company_id` AS 'su_fk_creator_c__contact_company_id',
	su_fk_creator_c.`email` AS 'su_fk_creator_c__email',
	su_fk_creator_c.`name_prefix` AS 'su_fk_creator_c__name_prefix',
	su_fk_creator_c.`first_name` AS 'su_fk_creator_c__first_name',
	su_fk_creator_c.`additional_name` AS 'su_fk_creator_c__additional_name',
	su_fk_creator_c.`middle_name` AS 'su_fk_creator_c__middle_name',
	su_fk_creator_c.`last_name` AS 'su_fk_creator_c__last_name',
	su_fk_creator_c.`name_suffix` AS 'su_fk_creator_c__name_suffix',
	su_fk_creator_c.`title` AS 'su_fk_creator_c__title',
	su_fk_creator_c.`vendor_flag` AS 'su_fk_creator_c__vendor_flag',

	su_fk_recipient_c.`id` AS 'su_fk_recipient_c__contact_id',
	su_fk_recipient_c.`user_company_id` AS 'su_fk_recipient_c__user_company_id',
	su_fk_recipient_c.`user_id` AS 'su_fk_recipient_c__user_id',
	su_fk_recipient_c.`contact_company_id` AS 'su_fk_recipient_c__contact_company_id',
	su_fk_recipient_c.`email` AS 'su_fk_recipient_c__email',
	su_fk_recipient_c.`name_prefix` AS 'su_fk_recipient_c__name_prefix',
	su_fk_recipient_c.`first_name` AS 'su_fk_recipient_c__first_name',
	su_fk_recipient_c.`additional_name` AS 'su_fk_recipient_c__additional_name',
	su_fk_recipient_c.`middle_name` AS 'su_fk_recipient_c__middle_name',
	su_fk_recipient_c.`last_name` AS 'su_fk_recipient_c__last_name',
	su_fk_recipient_c.`name_suffix` AS 'su_fk_recipient_c__name_suffix',
	su_fk_recipient_c.`title` AS 'su_fk_recipient_c__title',
	su_fk_recipient_c.`vendor_flag` AS 'su_fk_recipient_c__vendor_flag',

	su_fk_initiator_c.`id` AS 'su_fk_initiator_c__contact_id',
	su_fk_initiator_c.`user_company_id` AS 'su_fk_initiator_c__user_company_id',
	su_fk_initiator_c.`user_id` AS 'su_fk_initiator_c__user_id',
	su_fk_initiator_c.`contact_company_id` AS 'su_fk_initiator_c__contact_company_id',
	su_fk_initiator_c.`email` AS 'su_fk_initiator_c__email',
	su_fk_initiator_c.`name_prefix` AS 'su_fk_initiator_c__name_prefix',
	su_fk_initiator_c.`first_name` AS 'su_fk_initiator_c__first_name',
	su_fk_initiator_c.`additional_name` AS 'su_fk_initiator_c__additional_name',
	su_fk_initiator_c.`middle_name` AS 'su_fk_initiator_c__middle_name',
	su_fk_initiator_c.`last_name` AS 'su_fk_initiator_c__last_name',
	su_fk_initiator_c.`name_suffix` AS 'su_fk_initiator_c__name_suffix',
	su_fk_initiator_c.`title` AS 'su_fk_initiator_c__title',
	su_fk_initiator_c.`vendor_flag` AS 'su_fk_initiator_c__vendor_flag',

	su_fk_initiator_ccs.`company` AS 'su_fk_initiator_ccs__company',

	su_fk_initiator_cco.`id` AS 'su_fk_initiator_cco__contact_company_office_id',
	su_fk_initiator_cco.`contact_company_id` AS 'su_fk_initiator_cco__contact_company_id',
	su_fk_initiator_cco.`office_nickname` AS 'su_fk_initiator_cco__office_nickname',
	su_fk_initiator_cco.`address_line_1` AS 'su_fk_initiator_cco__address_line_1',
	su_fk_initiator_cco.`address_line_2` AS 'su_fk_initiator_cco__address_line_2',
	su_fk_initiator_cco.`address_line_3` AS 'su_fk_initiator_cco__address_line_3',
	su_fk_initiator_cco.`address_line_4` AS 'su_fk_initiator_cco__address_line_4',
	su_fk_initiator_cco.`address_city` AS 'su_fk_initiator_cco__address_city',
	su_fk_initiator_cco.`address_county` AS 'su_fk_initiator_cco__address_county',
	su_fk_initiator_cco.`address_state_or_region` AS 'su_fk_initiator_cco__address_state_or_region',
	su_fk_initiator_cco.`address_postal_code` AS 'su_fk_initiator_cco__address_postal_code',
	su_fk_initiator_cco.`address_postal_code_extension` AS 'su_fk_initiator_cco__address_postal_code_extension',
	su_fk_initiator_cco.`address_country` AS 'su_fk_initiator_cco__address_country',
	su_fk_initiator_cco.`head_quarters_flag` AS 'su_fk_initiator_cco__head_quarters_flag',
	su_fk_initiator_cco.`address_validated_by_user_flag` AS 'su_fk_initiator_cco__address_validated_by_user_flag',
	su_fk_initiator_cco.`address_validated_by_web_service_flag` AS 'su_fk_initiator_cco__address_validated_by_web_service_flag',
	su_fk_initiator_cco.`address_validation_by_web_service_error_flag` AS 'su_fk_initiator_cco__address_validation_by_web_service_error_flag',

	su.*

FROM `submittals` su
	INNER JOIN `projects` su_fk_p ON su.`project_id` = su_fk_p.`id`
	INNER JOIN `submittal_types` su_fk_sut ON su.`submittal_type_id` = su_fk_sut.`id`
	INNER JOIN `submittal_statuses` su_fk_sus ON su.`submittal_status_id` = su_fk_sus.`id`
	INNER JOIN `submittal_priorities` su_fk_sup ON su.`submittal_priority_id` = su_fk_sup.`id`
	INNER JOIN `submittal_distribution_methods` su_fk_sudm ON su.`submittal_distribution_method_id` = su_fk_sudm.`id`
	LEFT OUTER JOIN `file_manager_files` su_fk_fmfiles ON su.`su_file_manager_file_id` = su_fk_fmfiles.`id`
	LEFT OUTER JOIN `cost_codes` su_fk_codes ON su.`su_cost_code_id` = su_fk_codes.`id`
	LEFT OUTER JOIN `cost_code_divisions` su_fk_code_division ON su_fk_codes.`cost_code_division_id` = su_fk_code_division.`id`
	INNER JOIN `contacts` su_fk_creator_c ON su.`su_creator_contact_id` = su_fk_creator_c.`id`
	LEFT OUTER JOIN `contacts` su_fk_recipient_c ON su.`su_recipient_contact_id` = su_fk_recipient_c.`id`
	
	LEFT OUTER JOIN `contacts` su_fk_initiator_c ON su.`su_initiator_contact_id` = su_fk_initiator_c.`id`
	LEFT OUTER JOIN `contact_companies` su_fk_initiator_ccs ON su_fk_initiator_c.`contact_company_id` = su_fk_initiator_ccs.`id`
	LEFT OUTER JOIN `contact_company_offices` su_fk_initiator_cco ON su.`su_initiator_contact_company_office_id` = su_fk_initiator_cco.`id`

WHERE su.`project_id` = ? {$where}{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `su_sequence_number` ASC, `submittal_type_id` ASC, `submittal_status_id` ASC, `submittal_priority_id` ASC, `su_file_manager_file_id` ASC, `su_cost_code_id` ASC, `su_creator_contact_id` ASC, `su_creator_contact_company_office_id` ASC, `su_creator_phone_contact_company_office_phone_number_id` ASC, `su_creator_fax_contact_company_office_phone_number_id` ASC, `su_creator_contact_mobile_phone_number_id` ASC, `su_recipient_contact_id` ASC, `su_recipient_contact_company_office_id` ASC, `su_recipient_phone_contact_company_office_phone_number_id` ASC, `su_recipient_fax_contact_company_office_phone_number_id` ASC, `su_recipient_contact_mobile_phone_number_id` ASC, `su_initiator_contact_id` ASC, `su_initiator_contact_company_office_id` ASC, `su_initiator_phone_contact_company_office_phone_number_id` ASC, `su_initiator_fax_contact_company_office_phone_number_id` ASC, `su_initiator_contact_mobile_phone_number_id` ASC, `su_title` ASC, `su_plan_page_reference` ASC, `su_statement` ASC, `created` ASC, `su_due_date` ASC, `su_closed_date` ASC
		$arrValues = array($project_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubmittalsByProjectId = array();
		while ($row = $db->fetch()) {
			$submittal_id = $row['id'];
			$submittal = self::instantiateOrm($database, 'Submittal', $row, null, $submittal_id);
			/* @var $submittal Submittal */
			$submittal->convertPropertiesToData();

			if (isset($row['project_id'])) {
				$project_id = $row['project_id'];
				$row['su_fk_p__id'] = $project_id;
				$project = self::instantiateOrm($database, 'Project', $row, null, $project_id, 'su_fk_p__');
				/* @var $project Project */
				$project->convertPropertiesToData();
			} else {
				$project = false;
			}
			$submittal->setProject($project);

			if (isset($row['submittal_type_id'])) {
				$submittal_type_id = $row['submittal_type_id'];
				$row['su_fk_sut__id'] = $submittal_type_id;
				$submittalType = self::instantiateOrm($database, 'SubmittalType', $row, null, $submittal_type_id, 'su_fk_sut__');
				/* @var $submittalType SubmittalType */
				$submittalType->convertPropertiesToData();
			} else {
				$submittalType = false;
			}
			$submittal->setSubmittalType($submittalType);

			if (isset($row['submittal_status_id'])) {
				$submittal_status_id = $row['submittal_status_id'];
				$row['su_fk_sus__id'] = $submittal_status_id;
				$submittalStatus = self::instantiateOrm($database, 'SubmittalStatus', $row, null, $submittal_status_id, 'su_fk_sus__');
				/* @var $submittalStatus SubmittalStatus */
				$submittalStatus->convertPropertiesToData();
			} else {
				$submittalStatus = false;
			}
			$submittal->setSubmittalStatus($submittalStatus);

			if (isset($row['submittal_priority_id'])) {
				$submittal_priority_id = $row['submittal_priority_id'];
				$row['su_fk_sup__id'] = $submittal_priority_id;
				$submittalPriority = self::instantiateOrm($database, 'SubmittalPriority', $row, null, $submittal_priority_id, 'su_fk_sup__');
				/* @var $submittalPriority SubmittalPriority */
				$submittalPriority->convertPropertiesToData();
			} else {
				$submittalPriority = false;
			}
			$submittal->setSubmittalPriority($submittalPriority);

			if (isset($row['submittal_distribution_method_id'])) {
				$submittal_distribution_method_id = $row['submittal_distribution_method_id'];
				$row['su_fk_sudm__id'] = $submittal_distribution_method_id;
				$submittalDistributionMethod = self::instantiateOrm($database, 'SubmittalDistributionMethod', $row, null, $submittal_distribution_method_id, 'su_fk_sudm__');
				/* @var $submittalDistributionMethod SubmittalDistributionMethod */
				$submittalDistributionMethod->convertPropertiesToData();
			} else {
				$submittalDistributionMethod = false;
			}
			$submittal->setSubmittalDistributionMethod($submittalDistributionMethod);

			if (isset($row['su_file_manager_file_id'])) {
				$su_file_manager_file_id = $row['su_file_manager_file_id'];
				$row['su_fk_fmfiles__id'] = $su_file_manager_file_id;
				$suFileManagerFile = self::instantiateOrm($database, 'FileManagerFile', $row, null, $su_file_manager_file_id, 'su_fk_fmfiles__');
				/* @var $suFileManagerFile FileManagerFile */
				$suFileManagerFile->convertPropertiesToData();
			} else {
				$suFileManagerFile = false;
			}
			$submittal->setSuFileManagerFile($suFileManagerFile);

			if (isset($row['su_cost_code_id'])) {
				$su_cost_code_id = $row['su_cost_code_id'];
				$row['su_fk_codes__id'] = $su_cost_code_id;
				$suCostCode = self::instantiateOrm($database, 'CostCode', $row, null, $su_cost_code_id, 'su_fk_codes__');
				/* @var $suCostCode CostCode */
				$suCostCode->convertPropertiesToData();
			} else {
				$suCostCode = false;
			}
			$submittal->setSuCostCode($suCostCode);

			if (isset($row['su_creator_contact_id'])) {
				$su_creator_contact_id = $row['su_creator_contact_id'];
				$row['su_fk_creator_c__id'] = $su_creator_contact_id;
				$suCreatorContact = self::instantiateOrm($database, 'Contact', $row, null, $su_creator_contact_id, 'su_fk_creator_c__');
				/* @var $suCreatorContact Contact */
				$suCreatorContact->convertPropertiesToData();
			} else {
				$suCreatorContact = false;
			}
			$submittal->setSuCreatorContact($suCreatorContact);

			if (isset($row['su_creator_contact_company_office_id'])) {
				$su_creator_contact_company_office_id = $row['su_creator_contact_company_office_id'];
				$row['su_fk_creator_cco__id'] = $su_creator_contact_company_office_id;
				$suCreatorContactCompanyOffice = self::instantiateOrm($database, 'ContactCompanyOffice', $row, null, $su_creator_contact_company_office_id, 'su_fk_creator_cco__');
				/* @var $suCreatorContactCompanyOffice ContactCompanyOffice */
				$suCreatorContactCompanyOffice->convertPropertiesToData();
			} else {
				$suCreatorContactCompanyOffice = false;
			}
			$submittal->setSuCreatorContactCompanyOffice($suCreatorContactCompanyOffice);

			if (isset($row['su_creator_phone_contact_company_office_phone_number_id'])) {
				$su_creator_phone_contact_company_office_phone_number_id = $row['su_creator_phone_contact_company_office_phone_number_id'];
				$row['su_fk_creator_phone_ccopn__id'] = $su_creator_phone_contact_company_office_phone_number_id;
				$suCreatorPhoneContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $su_creator_phone_contact_company_office_phone_number_id, 'su_fk_creator_phone_ccopn__');
				/* @var $suCreatorPhoneContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$suCreatorPhoneContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$suCreatorPhoneContactCompanyOfficePhoneNumber = false;
			}
			$submittal->setSuCreatorPhoneContactCompanyOfficePhoneNumber($suCreatorPhoneContactCompanyOfficePhoneNumber);

			if (isset($row['su_creator_fax_contact_company_office_phone_number_id'])) {
				$su_creator_fax_contact_company_office_phone_number_id = $row['su_creator_fax_contact_company_office_phone_number_id'];
				$row['su_fk_creator_fax_ccopn__id'] = $su_creator_fax_contact_company_office_phone_number_id;
				$suCreatorFaxContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $su_creator_fax_contact_company_office_phone_number_id, 'su_fk_creator_fax_ccopn__');
				/* @var $suCreatorFaxContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$suCreatorFaxContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$suCreatorFaxContactCompanyOfficePhoneNumber = false;
			}
			$submittal->setSuCreatorFaxContactCompanyOfficePhoneNumber($suCreatorFaxContactCompanyOfficePhoneNumber);

			if (isset($row['su_creator_contact_mobile_phone_number_id'])) {
				$su_creator_contact_mobile_phone_number_id = $row['su_creator_contact_mobile_phone_number_id'];
				$row['su_fk_creator_c_mobile_cpn__id'] = $su_creator_contact_mobile_phone_number_id;
				$suCreatorContactMobilePhoneNumber = self::instantiateOrm($database, 'ContactPhoneNumber', $row, null, $su_creator_contact_mobile_phone_number_id, 'su_fk_creator_c_mobile_cpn__');
				/* @var $suCreatorContactMobilePhoneNumber ContactPhoneNumber */
				$suCreatorContactMobilePhoneNumber->convertPropertiesToData();
			} else {
				$suCreatorContactMobilePhoneNumber = false;
			}
			$submittal->setSuCreatorContactMobilePhoneNumber($suCreatorContactMobilePhoneNumber);

			if (isset($row['su_recipient_contact_id'])) {
				$su_recipient_contact_id = $row['su_recipient_contact_id'];
				$row['su_fk_recipient_c__id'] = $su_recipient_contact_id;
				$suRecipientContact = self::instantiateOrm($database, 'Contact', $row, null, $su_recipient_contact_id, 'su_fk_recipient_c__');
				/* @var $suRecipientContact Contact */
				$suRecipientContact->convertPropertiesToData();
			} else {
				$suRecipientContact = false;
			}
			$submittal->setSuRecipientContact($suRecipientContact);

			if (isset($row['su_recipient_contact_company_office_id'])) {
				$su_recipient_contact_company_office_id = $row['su_recipient_contact_company_office_id'];
				$row['su_fk_recipient_cco__id'] = $su_recipient_contact_company_office_id;
				$suRecipientContactCompanyOffice = self::instantiateOrm($database, 'ContactCompanyOffice', $row, null, $su_recipient_contact_company_office_id, 'su_fk_recipient_cco__');
				/* @var $suRecipientContactCompanyOffice ContactCompanyOffice */
				$suRecipientContactCompanyOffice->convertPropertiesToData();
			} else {
				$suRecipientContactCompanyOffice = false;
			}
			$submittal->setSuRecipientContactCompanyOffice($suRecipientContactCompanyOffice);

			if (isset($row['su_recipient_phone_contact_company_office_phone_number_id'])) {
				$su_recipient_phone_contact_company_office_phone_number_id = $row['su_recipient_phone_contact_company_office_phone_number_id'];
				$row['su_fk_recipient_phone_ccopn__id'] = $su_recipient_phone_contact_company_office_phone_number_id;
				$suRecipientPhoneContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $su_recipient_phone_contact_company_office_phone_number_id, 'su_fk_recipient_phone_ccopn__');
				/* @var $suRecipientPhoneContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$suRecipientPhoneContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$suRecipientPhoneContactCompanyOfficePhoneNumber = false;
			}
			$submittal->setSuRecipientPhoneContactCompanyOfficePhoneNumber($suRecipientPhoneContactCompanyOfficePhoneNumber);

			if (isset($row['su_recipient_fax_contact_company_office_phone_number_id'])) {
				$su_recipient_fax_contact_company_office_phone_number_id = $row['su_recipient_fax_contact_company_office_phone_number_id'];
				$row['su_fk_recipient_fax_ccopn__id'] = $su_recipient_fax_contact_company_office_phone_number_id;
				$suRecipientFaxContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $su_recipient_fax_contact_company_office_phone_number_id, 'su_fk_recipient_fax_ccopn__');
				/* @var $suRecipientFaxContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$suRecipientFaxContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$suRecipientFaxContactCompanyOfficePhoneNumber = false;
			}
			$submittal->setSuRecipientFaxContactCompanyOfficePhoneNumber($suRecipientFaxContactCompanyOfficePhoneNumber);

			if (isset($row['su_recipient_contact_mobile_phone_number_id'])) {
				$su_recipient_contact_mobile_phone_number_id = $row['su_recipient_contact_mobile_phone_number_id'];
				$row['su_fk_recipient_c_mobile_cpn__id'] = $su_recipient_contact_mobile_phone_number_id;
				$suRecipientContactMobilePhoneNumber = self::instantiateOrm($database, 'ContactPhoneNumber', $row, null, $su_recipient_contact_mobile_phone_number_id, 'su_fk_recipient_c_mobile_cpn__');
				/* @var $suRecipientContactMobilePhoneNumber ContactPhoneNumber */
				$suRecipientContactMobilePhoneNumber->convertPropertiesToData();
			} else {
				$suRecipientContactMobilePhoneNumber = false;
			}
			$submittal->setSuRecipientContactMobilePhoneNumber($suRecipientContactMobilePhoneNumber);

			if (isset($row['su_initiator_contact_id'])) {
				$su_initiator_contact_id = $row['su_initiator_contact_id'];
				$row['su_fk_initiator_c__id'] = $su_initiator_contact_id;
				$suInitiatorContact = self::instantiateOrm($database, 'Contact', $row, null, $su_initiator_contact_id, 'su_fk_initiator_c__');
				/* @var $suInitiatorContact Contact */
				$suInitiatorContact->convertPropertiesToData();
			} else {
				$suInitiatorContact = false;
			}
			$submittal->setSuInitiatorContact($suInitiatorContact);

			if (isset($row['su_initiator_contact_company_office_id'])) {
				$su_initiator_contact_company_office_id = $row['su_initiator_contact_company_office_id'];
				$row['su_fk_initiator_cco__id'] = $su_initiator_contact_company_office_id;
				$suInitiatorContactCompanyOffice = self::instantiateOrm($database, 'ContactCompanyOffice', $row, null, $su_initiator_contact_company_office_id, 'su_fk_initiator_cco__');
				/* @var $suInitiatorContactCompanyOffice ContactCompanyOffice */
				$suInitiatorContactCompanyOffice->convertPropertiesToData();
			} else {
				$suInitiatorContactCompanyOffice = false;
			}
			$submittal->setSuInitiatorContactCompanyOffice($suInitiatorContactCompanyOffice);

			if (isset($row['su_initiator_phone_contact_company_office_phone_number_id'])) {
				$su_initiator_phone_contact_company_office_phone_number_id = $row['su_initiator_phone_contact_company_office_phone_number_id'];
				$row['su_fk_initiator_phone_ccopn__id'] = $su_initiator_phone_contact_company_office_phone_number_id;
				$suInitiatorPhoneContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $su_initiator_phone_contact_company_office_phone_number_id, 'su_fk_initiator_phone_ccopn__');
				/* @var $suInitiatorPhoneContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$suInitiatorPhoneContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$suInitiatorPhoneContactCompanyOfficePhoneNumber = false;
			}
			$submittal->setSuInitiatorPhoneContactCompanyOfficePhoneNumber($suInitiatorPhoneContactCompanyOfficePhoneNumber);

			if (isset($row['su_initiator_fax_contact_company_office_phone_number_id'])) {
				$su_initiator_fax_contact_company_office_phone_number_id = $row['su_initiator_fax_contact_company_office_phone_number_id'];
				$row['su_fk_initiator_fax_ccopn__id'] = $su_initiator_fax_contact_company_office_phone_number_id;
				$suInitiatorFaxContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $su_initiator_fax_contact_company_office_phone_number_id, 'su_fk_initiator_fax_ccopn__');
				/* @var $suInitiatorFaxContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$suInitiatorFaxContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$suInitiatorFaxContactCompanyOfficePhoneNumber = false;
			}
			$submittal->setSuInitiatorFaxContactCompanyOfficePhoneNumber($suInitiatorFaxContactCompanyOfficePhoneNumber);

			if (isset($row['su_initiator_contact_mobile_phone_number_id'])) {
				$su_initiator_contact_mobile_phone_number_id = $row['su_initiator_contact_mobile_phone_number_id'];
				$row['su_fk_initiator_c_mobile_cpn__id'] = $su_initiator_contact_mobile_phone_number_id;
				$suInitiatorContactMobilePhoneNumber = self::instantiateOrm($database, 'ContactPhoneNumber', $row, null, $su_initiator_contact_mobile_phone_number_id, 'su_fk_initiator_c_mobile_cpn__');
				/* @var $suInitiatorContactMobilePhoneNumber ContactPhoneNumber */
				$suInitiatorContactMobilePhoneNumber->convertPropertiesToData();
			} else {
				$suInitiatorContactMobilePhoneNumber = false;
			}
			$submittal->setSuInitiatorContactMobilePhoneNumber($suInitiatorContactMobilePhoneNumber);

			$arrSubmittalsByProjectId[$submittal_id] = $submittal;
		}

		$db->free_result();

		self::$_arrSubmittalsByProjectId = $arrSubmittalsByProjectId;

		return $arrSubmittalsByProjectId;
	}
	/**
	 * Load by constraint `submittals_fk_sut` foreign key (`submittal_type_id`) references `submittal_types` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $submittal_type_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubmittalsBySubmittalTypeId($database, $submittal_type_id, Input $options=null)
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
			self::$_arrSubmittalsBySubmittalTypeId = null;
		}

		$arrSubmittalsBySubmittalTypeId = self::$_arrSubmittalsBySubmittalTypeId;
		if (isset($arrSubmittalsBySubmittalTypeId) && !empty($arrSubmittalsBySubmittalTypeId)) {
			return $arrSubmittalsBySubmittalTypeId;
		}

		$submittal_type_id = (int) $submittal_type_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `su_sequence_number` ASC, `submittal_type_id` ASC, `submittal_status_id` ASC, `submittal_priority_id` ASC, `submittal_distribution_method_id` ASC, `su_file_manager_file_id` ASC, `su_cost_code_id` ASC, `su_creator_contact_id` ASC, `su_creator_contact_company_office_id` ASC, `su_creator_phone_contact_company_office_phone_number_id` ASC, `su_creator_fax_contact_company_office_phone_number_id` ASC, `su_creator_contact_mobile_phone_number_id` ASC, `su_recipient_contact_id` ASC, `su_recipient_contact_company_office_id` ASC, `su_recipient_phone_contact_company_office_phone_number_id` ASC, `su_recipient_fax_contact_company_office_phone_number_id` ASC, `su_recipient_contact_mobile_phone_number_id` ASC, `su_initiator_contact_id` ASC, `su_initiator_contact_company_office_id` ASC, `su_initiator_phone_contact_company_office_phone_number_id` ASC, `su_initiator_fax_contact_company_office_phone_number_id` ASC, `su_initiator_contact_mobile_phone_number_id` ASC, `su_title` ASC, `su_plan_page_reference` ASC, `su_statement` ASC, `created` ASC, `su_due_date` ASC, `su_closed_date` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubmittal = new Submittal($database);
			$sqlOrderByColumns = $tmpSubmittal->constructSqlOrderByColumns($arrOrderByAttributes);

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
	su.*

FROM `submittals` su
WHERE su.`submittal_type_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `su_sequence_number` ASC, `submittal_type_id` ASC, `submittal_status_id` ASC, `submittal_priority_id` ASC, `submittal_distribution_method_id` ASC, `su_file_manager_file_id` ASC, `su_cost_code_id` ASC, `su_creator_contact_id` ASC, `su_creator_contact_company_office_id` ASC, `su_creator_phone_contact_company_office_phone_number_id` ASC, `su_creator_fax_contact_company_office_phone_number_id` ASC, `su_creator_contact_mobile_phone_number_id` ASC, `su_recipient_contact_id` ASC, `su_recipient_contact_company_office_id` ASC, `su_recipient_phone_contact_company_office_phone_number_id` ASC, `su_recipient_fax_contact_company_office_phone_number_id` ASC, `su_recipient_contact_mobile_phone_number_id` ASC, `su_initiator_contact_id` ASC, `su_initiator_contact_company_office_id` ASC, `su_initiator_phone_contact_company_office_phone_number_id` ASC, `su_initiator_fax_contact_company_office_phone_number_id` ASC, `su_initiator_contact_mobile_phone_number_id` ASC, `su_title` ASC, `su_plan_page_reference` ASC, `su_statement` ASC, `created` ASC, `su_due_date` ASC, `su_closed_date` ASC
		$arrValues = array($submittal_type_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubmittalsBySubmittalTypeId = array();
		while ($row = $db->fetch()) {
			$submittal_id = $row['id'];
			$submittal = self::instantiateOrm($database, 'Submittal', $row, null, $submittal_id);
			/* @var $submittal Submittal */
			$arrSubmittalsBySubmittalTypeId[$submittal_id] = $submittal;
		}

		$db->free_result();

		self::$_arrSubmittalsBySubmittalTypeId = $arrSubmittalsBySubmittalTypeId;

		return $arrSubmittalsBySubmittalTypeId;
	}

	/**
	 * Load by constraint `submittals_fk_sus` foreign key (`submittal_status_id`) references `submittal_statuses` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $submittal_status_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubmittalsBySubmittalStatusId($database, $submittal_status_id, Input $options=null)
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
			self::$_arrSubmittalsBySubmittalStatusId = null;
		}

		$arrSubmittalsBySubmittalStatusId = self::$_arrSubmittalsBySubmittalStatusId;
		if (isset($arrSubmittalsBySubmittalStatusId) && !empty($arrSubmittalsBySubmittalStatusId)) {
			return $arrSubmittalsBySubmittalStatusId;
		}

		$submittal_status_id = (int) $submittal_status_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `su_sequence_number` ASC, `submittal_type_id` ASC, `submittal_status_id` ASC, `submittal_priority_id` ASC, `submittal_distribution_method_id` ASC, `su_file_manager_file_id` ASC, `su_cost_code_id` ASC, `su_creator_contact_id` ASC, `su_creator_contact_company_office_id` ASC, `su_creator_phone_contact_company_office_phone_number_id` ASC, `su_creator_fax_contact_company_office_phone_number_id` ASC, `su_creator_contact_mobile_phone_number_id` ASC, `su_recipient_contact_id` ASC, `su_recipient_contact_company_office_id` ASC, `su_recipient_phone_contact_company_office_phone_number_id` ASC, `su_recipient_fax_contact_company_office_phone_number_id` ASC, `su_recipient_contact_mobile_phone_number_id` ASC, `su_initiator_contact_id` ASC, `su_initiator_contact_company_office_id` ASC, `su_initiator_phone_contact_company_office_phone_number_id` ASC, `su_initiator_fax_contact_company_office_phone_number_id` ASC, `su_initiator_contact_mobile_phone_number_id` ASC, `su_title` ASC, `su_plan_page_reference` ASC, `su_statement` ASC, `created` ASC, `su_due_date` ASC, `su_closed_date` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubmittal = new Submittal($database);
			$sqlOrderByColumns = $tmpSubmittal->constructSqlOrderByColumns($arrOrderByAttributes);

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
	su.*

FROM `submittals` su
WHERE su.`submittal_status_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `su_sequence_number` ASC, `submittal_type_id` ASC, `submittal_status_id` ASC, `submittal_priority_id` ASC, `submittal_distribution_method_id` ASC, `su_file_manager_file_id` ASC, `su_cost_code_id` ASC, `su_creator_contact_id` ASC, `su_creator_contact_company_office_id` ASC, `su_creator_phone_contact_company_office_phone_number_id` ASC, `su_creator_fax_contact_company_office_phone_number_id` ASC, `su_creator_contact_mobile_phone_number_id` ASC, `su_recipient_contact_id` ASC, `su_recipient_contact_company_office_id` ASC, `su_recipient_phone_contact_company_office_phone_number_id` ASC, `su_recipient_fax_contact_company_office_phone_number_id` ASC, `su_recipient_contact_mobile_phone_number_id` ASC, `su_initiator_contact_id` ASC, `su_initiator_contact_company_office_id` ASC, `su_initiator_phone_contact_company_office_phone_number_id` ASC, `su_initiator_fax_contact_company_office_phone_number_id` ASC, `su_initiator_contact_mobile_phone_number_id` ASC, `su_title` ASC, `su_plan_page_reference` ASC, `su_statement` ASC, `created` ASC, `su_due_date` ASC, `su_closed_date` ASC
		$arrValues = array($submittal_status_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubmittalsBySubmittalStatusId = array();
		while ($row = $db->fetch()) {
			$submittal_id = $row['id'];
			$submittal = self::instantiateOrm($database, 'Submittal', $row, null, $submittal_id);
			/* @var $submittal Submittal */
			$arrSubmittalsBySubmittalStatusId[$submittal_id] = $submittal;
		}

		$db->free_result();

		self::$_arrSubmittalsBySubmittalStatusId = $arrSubmittalsBySubmittalStatusId;

		return $arrSubmittalsBySubmittalStatusId;
	}

	/**
	 * Load by constraint `submittals_fk_sup` foreign key (`submittal_priority_id`) references `submittal_priorities` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $submittal_priority_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubmittalsBySubmittalPriorityId($database, $submittal_priority_id, Input $options=null)
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
			self::$_arrSubmittalsBySubmittalPriorityId = null;
		}

		$arrSubmittalsBySubmittalPriorityId = self::$_arrSubmittalsBySubmittalPriorityId;
		if (isset($arrSubmittalsBySubmittalPriorityId) && !empty($arrSubmittalsBySubmittalPriorityId)) {
			return $arrSubmittalsBySubmittalPriorityId;
		}

		$submittal_priority_id = (int) $submittal_priority_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `su_sequence_number` ASC, `submittal_type_id` ASC, `submittal_status_id` ASC, `submittal_priority_id` ASC, `submittal_distribution_method_id` ASC, `su_file_manager_file_id` ASC, `su_cost_code_id` ASC, `su_creator_contact_id` ASC, `su_creator_contact_company_office_id` ASC, `su_creator_phone_contact_company_office_phone_number_id` ASC, `su_creator_fax_contact_company_office_phone_number_id` ASC, `su_creator_contact_mobile_phone_number_id` ASC, `su_recipient_contact_id` ASC, `su_recipient_contact_company_office_id` ASC, `su_recipient_phone_contact_company_office_phone_number_id` ASC, `su_recipient_fax_contact_company_office_phone_number_id` ASC, `su_recipient_contact_mobile_phone_number_id` ASC, `su_initiator_contact_id` ASC, `su_initiator_contact_company_office_id` ASC, `su_initiator_phone_contact_company_office_phone_number_id` ASC, `su_initiator_fax_contact_company_office_phone_number_id` ASC, `su_initiator_contact_mobile_phone_number_id` ASC, `su_title` ASC, `su_plan_page_reference` ASC, `su_statement` ASC, `created` ASC, `su_due_date` ASC, `su_closed_date` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubmittal = new Submittal($database);
			$sqlOrderByColumns = $tmpSubmittal->constructSqlOrderByColumns($arrOrderByAttributes);

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
	su.*

FROM `submittals` su
WHERE su.`submittal_priority_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `su_sequence_number` ASC, `submittal_type_id` ASC, `submittal_status_id` ASC, `submittal_priority_id` ASC, `submittal_distribution_method_id` ASC, `su_file_manager_file_id` ASC, `su_cost_code_id` ASC, `su_creator_contact_id` ASC, `su_creator_contact_company_office_id` ASC, `su_creator_phone_contact_company_office_phone_number_id` ASC, `su_creator_fax_contact_company_office_phone_number_id` ASC, `su_creator_contact_mobile_phone_number_id` ASC, `su_recipient_contact_id` ASC, `su_recipient_contact_company_office_id` ASC, `su_recipient_phone_contact_company_office_phone_number_id` ASC, `su_recipient_fax_contact_company_office_phone_number_id` ASC, `su_recipient_contact_mobile_phone_number_id` ASC, `su_initiator_contact_id` ASC, `su_initiator_contact_company_office_id` ASC, `su_initiator_phone_contact_company_office_phone_number_id` ASC, `su_initiator_fax_contact_company_office_phone_number_id` ASC, `su_initiator_contact_mobile_phone_number_id` ASC, `su_title` ASC, `su_plan_page_reference` ASC, `su_statement` ASC, `created` ASC, `su_due_date` ASC, `su_closed_date` ASC
		$arrValues = array($submittal_priority_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubmittalsBySubmittalPriorityId = array();
		while ($row = $db->fetch()) {
			$submittal_id = $row['id'];
			$submittal = self::instantiateOrm($database, 'Submittal', $row, null, $submittal_id);
			/* @var $submittal Submittal */
			$arrSubmittalsBySubmittalPriorityId[$submittal_id] = $submittal;
		}

		$db->free_result();

		self::$_arrSubmittalsBySubmittalPriorityId = $arrSubmittalsBySubmittalPriorityId;

		return $arrSubmittalsBySubmittalPriorityId;
	}

	/**
	 * Load by constraint `submittals_fk_sudm` foreign key (`submittal_distribution_method_id`) references `submittal_distribution_methods` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $submittal_distribution_method_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubmittalsBySubmittalDistributionMethodId($database, $submittal_distribution_method_id, Input $options=null)
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
			self::$_arrSubmittalsBySubmittalDistributionMethodId = null;
		}

		$arrSubmittalsBySubmittalDistributionMethodId = self::$_arrSubmittalsBySubmittalDistributionMethodId;
		if (isset($arrSubmittalsBySubmittalDistributionMethodId) && !empty($arrSubmittalsBySubmittalDistributionMethodId)) {
			return $arrSubmittalsBySubmittalDistributionMethodId;
		}

		$submittal_distribution_method_id = (int) $submittal_distribution_method_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `su_sequence_number` ASC, `submittal_type_id` ASC, `submittal_status_id` ASC, `submittal_priority_id` ASC, `submittal_distribution_method_id` ASC, `su_file_manager_file_id` ASC, `su_cost_code_id` ASC, `su_creator_contact_id` ASC, `su_creator_contact_company_office_id` ASC, `su_creator_phone_contact_company_office_phone_number_id` ASC, `su_creator_fax_contact_company_office_phone_number_id` ASC, `su_creator_contact_mobile_phone_number_id` ASC, `su_recipient_contact_id` ASC, `su_recipient_contact_company_office_id` ASC, `su_recipient_phone_contact_company_office_phone_number_id` ASC, `su_recipient_fax_contact_company_office_phone_number_id` ASC, `su_recipient_contact_mobile_phone_number_id` ASC, `su_initiator_contact_id` ASC, `su_initiator_contact_company_office_id` ASC, `su_initiator_phone_contact_company_office_phone_number_id` ASC, `su_initiator_fax_contact_company_office_phone_number_id` ASC, `su_initiator_contact_mobile_phone_number_id` ASC, `su_title` ASC, `su_plan_page_reference` ASC, `su_statement` ASC, `created` ASC, `su_due_date` ASC, `su_closed_date` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubmittal = new Submittal($database);
			$sqlOrderByColumns = $tmpSubmittal->constructSqlOrderByColumns($arrOrderByAttributes);

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
	su.*

FROM `submittals` su
WHERE su.`submittal_distribution_method_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `su_sequence_number` ASC, `submittal_type_id` ASC, `submittal_status_id` ASC, `submittal_priority_id` ASC, `submittal_distribution_method_id` ASC, `su_file_manager_file_id` ASC, `su_cost_code_id` ASC, `su_creator_contact_id` ASC, `su_creator_contact_company_office_id` ASC, `su_creator_phone_contact_company_office_phone_number_id` ASC, `su_creator_fax_contact_company_office_phone_number_id` ASC, `su_creator_contact_mobile_phone_number_id` ASC, `su_recipient_contact_id` ASC, `su_recipient_contact_company_office_id` ASC, `su_recipient_phone_contact_company_office_phone_number_id` ASC, `su_recipient_fax_contact_company_office_phone_number_id` ASC, `su_recipient_contact_mobile_phone_number_id` ASC, `su_initiator_contact_id` ASC, `su_initiator_contact_company_office_id` ASC, `su_initiator_phone_contact_company_office_phone_number_id` ASC, `su_initiator_fax_contact_company_office_phone_number_id` ASC, `su_initiator_contact_mobile_phone_number_id` ASC, `su_title` ASC, `su_plan_page_reference` ASC, `su_statement` ASC, `created` ASC, `su_due_date` ASC, `su_closed_date` ASC
		$arrValues = array($submittal_distribution_method_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubmittalsBySubmittalDistributionMethodId = array();
		while ($row = $db->fetch()) {
			$submittal_id = $row['id'];
			$submittal = self::instantiateOrm($database, 'Submittal', $row, null, $submittal_id);
			/* @var $submittal Submittal */
			$arrSubmittalsBySubmittalDistributionMethodId[$submittal_id] = $submittal;
		}

		$db->free_result();

		self::$_arrSubmittalsBySubmittalDistributionMethodId = $arrSubmittalsBySubmittalDistributionMethodId;

		return $arrSubmittalsBySubmittalDistributionMethodId;
	}

	/**
	 * Load by constraint `submittals_fk_fmfiles` foreign key (`su_file_manager_file_id`) references `file_manager_files` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $su_file_manager_file_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubmittalsBySuFileManagerFileId($database, $su_file_manager_file_id, Input $options=null)
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
			self::$_arrSubmittalsBySuFileManagerFileId = null;
		}

		$arrSubmittalsBySuFileManagerFileId = self::$_arrSubmittalsBySuFileManagerFileId;
		if (isset($arrSubmittalsBySuFileManagerFileId) && !empty($arrSubmittalsBySuFileManagerFileId)) {
			return $arrSubmittalsBySuFileManagerFileId;
		}

		$su_file_manager_file_id = (int) $su_file_manager_file_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `su_sequence_number` ASC, `submittal_type_id` ASC, `submittal_status_id` ASC, `submittal_priority_id` ASC, `submittal_distribution_method_id` ASC, `su_file_manager_file_id` ASC, `su_cost_code_id` ASC, `su_creator_contact_id` ASC, `su_creator_contact_company_office_id` ASC, `su_creator_phone_contact_company_office_phone_number_id` ASC, `su_creator_fax_contact_company_office_phone_number_id` ASC, `su_creator_contact_mobile_phone_number_id` ASC, `su_recipient_contact_id` ASC, `su_recipient_contact_company_office_id` ASC, `su_recipient_phone_contact_company_office_phone_number_id` ASC, `su_recipient_fax_contact_company_office_phone_number_id` ASC, `su_recipient_contact_mobile_phone_number_id` ASC, `su_initiator_contact_id` ASC, `su_initiator_contact_company_office_id` ASC, `su_initiator_phone_contact_company_office_phone_number_id` ASC, `su_initiator_fax_contact_company_office_phone_number_id` ASC, `su_initiator_contact_mobile_phone_number_id` ASC, `su_title` ASC, `su_plan_page_reference` ASC, `su_statement` ASC, `created` ASC, `su_due_date` ASC, `su_closed_date` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubmittal = new Submittal($database);
			$sqlOrderByColumns = $tmpSubmittal->constructSqlOrderByColumns($arrOrderByAttributes);

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
	su.*

FROM `submittals` su
WHERE su.`su_file_manager_file_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `su_sequence_number` ASC, `submittal_type_id` ASC, `submittal_status_id` ASC, `submittal_priority_id` ASC, `submittal_distribution_method_id` ASC, `su_file_manager_file_id` ASC, `su_cost_code_id` ASC, `su_creator_contact_id` ASC, `su_creator_contact_company_office_id` ASC, `su_creator_phone_contact_company_office_phone_number_id` ASC, `su_creator_fax_contact_company_office_phone_number_id` ASC, `su_creator_contact_mobile_phone_number_id` ASC, `su_recipient_contact_id` ASC, `su_recipient_contact_company_office_id` ASC, `su_recipient_phone_contact_company_office_phone_number_id` ASC, `su_recipient_fax_contact_company_office_phone_number_id` ASC, `su_recipient_contact_mobile_phone_number_id` ASC, `su_initiator_contact_id` ASC, `su_initiator_contact_company_office_id` ASC, `su_initiator_phone_contact_company_office_phone_number_id` ASC, `su_initiator_fax_contact_company_office_phone_number_id` ASC, `su_initiator_contact_mobile_phone_number_id` ASC, `su_title` ASC, `su_plan_page_reference` ASC, `su_statement` ASC, `created` ASC, `su_due_date` ASC, `su_closed_date` ASC
		$arrValues = array($su_file_manager_file_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubmittalsBySuFileManagerFileId = array();
		while ($row = $db->fetch()) {
			$submittal_id = $row['id'];
			$submittal = self::instantiateOrm($database, 'Submittal', $row, null, $submittal_id);
			/* @var $submittal Submittal */
			$arrSubmittalsBySuFileManagerFileId[$submittal_id] = $submittal;
		}

		$db->free_result();

		self::$_arrSubmittalsBySuFileManagerFileId = $arrSubmittalsBySuFileManagerFileId;

		return $arrSubmittalsBySuFileManagerFileId;
	}

	/**
	 * Load by constraint `submittals_fk_codes` foreign key (`su_cost_code_id`) references `cost_codes` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $su_cost_code_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubmittalsBySuCostCodeId($database, $su_cost_code_id, Input $options=null)
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
			self::$_arrSubmittalsBySuCostCodeId = null;
		}

		$arrSubmittalsBySuCostCodeId = self::$_arrSubmittalsBySuCostCodeId;
		if (isset($arrSubmittalsBySuCostCodeId) && !empty($arrSubmittalsBySuCostCodeId)) {
			return $arrSubmittalsBySuCostCodeId;
		}

		$su_cost_code_id = (int) $su_cost_code_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `su_sequence_number` ASC, `submittal_type_id` ASC, `submittal_status_id` ASC, `submittal_priority_id` ASC, `submittal_distribution_method_id` ASC, `su_file_manager_file_id` ASC, `su_cost_code_id` ASC, `su_creator_contact_id` ASC, `su_creator_contact_company_office_id` ASC, `su_creator_phone_contact_company_office_phone_number_id` ASC, `su_creator_fax_contact_company_office_phone_number_id` ASC, `su_creator_contact_mobile_phone_number_id` ASC, `su_recipient_contact_id` ASC, `su_recipient_contact_company_office_id` ASC, `su_recipient_phone_contact_company_office_phone_number_id` ASC, `su_recipient_fax_contact_company_office_phone_number_id` ASC, `su_recipient_contact_mobile_phone_number_id` ASC, `su_initiator_contact_id` ASC, `su_initiator_contact_company_office_id` ASC, `su_initiator_phone_contact_company_office_phone_number_id` ASC, `su_initiator_fax_contact_company_office_phone_number_id` ASC, `su_initiator_contact_mobile_phone_number_id` ASC, `su_title` ASC, `su_plan_page_reference` ASC, `su_statement` ASC, `created` ASC, `su_due_date` ASC, `su_closed_date` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubmittal = new Submittal($database);
			$sqlOrderByColumns = $tmpSubmittal->constructSqlOrderByColumns($arrOrderByAttributes);

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
	su.*

FROM `submittals` su
WHERE su.`su_cost_code_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `su_sequence_number` ASC, `submittal_type_id` ASC, `submittal_status_id` ASC, `submittal_priority_id` ASC, `submittal_distribution_method_id` ASC, `su_file_manager_file_id` ASC, `su_cost_code_id` ASC, `su_creator_contact_id` ASC, `su_creator_contact_company_office_id` ASC, `su_creator_phone_contact_company_office_phone_number_id` ASC, `su_creator_fax_contact_company_office_phone_number_id` ASC, `su_creator_contact_mobile_phone_number_id` ASC, `su_recipient_contact_id` ASC, `su_recipient_contact_company_office_id` ASC, `su_recipient_phone_contact_company_office_phone_number_id` ASC, `su_recipient_fax_contact_company_office_phone_number_id` ASC, `su_recipient_contact_mobile_phone_number_id` ASC, `su_initiator_contact_id` ASC, `su_initiator_contact_company_office_id` ASC, `su_initiator_phone_contact_company_office_phone_number_id` ASC, `su_initiator_fax_contact_company_office_phone_number_id` ASC, `su_initiator_contact_mobile_phone_number_id` ASC, `su_title` ASC, `su_plan_page_reference` ASC, `su_statement` ASC, `created` ASC, `su_due_date` ASC, `su_closed_date` ASC
		$arrValues = array($su_cost_code_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubmittalsBySuCostCodeId = array();
		while ($row = $db->fetch()) {
			$submittal_id = $row['id'];
			$submittal = self::instantiateOrm($database, 'Submittal', $row, null, $submittal_id);
			/* @var $submittal Submittal */
			$arrSubmittalsBySuCostCodeId[$submittal_id] = $submittal;
		}

		$db->free_result();

		self::$_arrSubmittalsBySuCostCodeId = $arrSubmittalsBySuCostCodeId;

		return $arrSubmittalsBySuCostCodeId;
	}

	/**
	 * Load by constraint `submittals_fk_creator_c` foreign key (`su_creator_contact_id`) references `contacts` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $su_creator_contact_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubmittalsBySuCreatorContactId($database, $su_creator_contact_id, Input $options=null)
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
			self::$_arrSubmittalsBySuCreatorContactId = null;
		}

		$arrSubmittalsBySuCreatorContactId = self::$_arrSubmittalsBySuCreatorContactId;
		if (isset($arrSubmittalsBySuCreatorContactId) && !empty($arrSubmittalsBySuCreatorContactId)) {
			return $arrSubmittalsBySuCreatorContactId;
		}

		$su_creator_contact_id = (int) $su_creator_contact_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `su_sequence_number` ASC, `submittal_type_id` ASC, `submittal_status_id` ASC, `submittal_priority_id` ASC, `submittal_distribution_method_id` ASC, `su_file_manager_file_id` ASC, `su_cost_code_id` ASC, `su_creator_contact_id` ASC, `su_creator_contact_company_office_id` ASC, `su_creator_phone_contact_company_office_phone_number_id` ASC, `su_creator_fax_contact_company_office_phone_number_id` ASC, `su_creator_contact_mobile_phone_number_id` ASC, `su_recipient_contact_id` ASC, `su_recipient_contact_company_office_id` ASC, `su_recipient_phone_contact_company_office_phone_number_id` ASC, `su_recipient_fax_contact_company_office_phone_number_id` ASC, `su_recipient_contact_mobile_phone_number_id` ASC, `su_initiator_contact_id` ASC, `su_initiator_contact_company_office_id` ASC, `su_initiator_phone_contact_company_office_phone_number_id` ASC, `su_initiator_fax_contact_company_office_phone_number_id` ASC, `su_initiator_contact_mobile_phone_number_id` ASC, `su_title` ASC, `su_plan_page_reference` ASC, `su_statement` ASC, `created` ASC, `su_due_date` ASC, `su_closed_date` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubmittal = new Submittal($database);
			$sqlOrderByColumns = $tmpSubmittal->constructSqlOrderByColumns($arrOrderByAttributes);

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
	su.*

FROM `submittals` su
WHERE su.`su_creator_contact_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `su_sequence_number` ASC, `submittal_type_id` ASC, `submittal_status_id` ASC, `submittal_priority_id` ASC, `submittal_distribution_method_id` ASC, `su_file_manager_file_id` ASC, `su_cost_code_id` ASC, `su_creator_contact_id` ASC, `su_creator_contact_company_office_id` ASC, `su_creator_phone_contact_company_office_phone_number_id` ASC, `su_creator_fax_contact_company_office_phone_number_id` ASC, `su_creator_contact_mobile_phone_number_id` ASC, `su_recipient_contact_id` ASC, `su_recipient_contact_company_office_id` ASC, `su_recipient_phone_contact_company_office_phone_number_id` ASC, `su_recipient_fax_contact_company_office_phone_number_id` ASC, `su_recipient_contact_mobile_phone_number_id` ASC, `su_initiator_contact_id` ASC, `su_initiator_contact_company_office_id` ASC, `su_initiator_phone_contact_company_office_phone_number_id` ASC, `su_initiator_fax_contact_company_office_phone_number_id` ASC, `su_initiator_contact_mobile_phone_number_id` ASC, `su_title` ASC, `su_plan_page_reference` ASC, `su_statement` ASC, `created` ASC, `su_due_date` ASC, `su_closed_date` ASC
		$arrValues = array($su_creator_contact_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubmittalsBySuCreatorContactId = array();
		while ($row = $db->fetch()) {
			$submittal_id = $row['id'];
			$submittal = self::instantiateOrm($database, 'Submittal', $row, null, $submittal_id);
			/* @var $submittal Submittal */
			$arrSubmittalsBySuCreatorContactId[$submittal_id] = $submittal;
		}

		$db->free_result();

		self::$_arrSubmittalsBySuCreatorContactId = $arrSubmittalsBySuCreatorContactId;

		return $arrSubmittalsBySuCreatorContactId;
	}

	/**
	 * Load by constraint `submittals_fk_creator_cco` foreign key (`su_creator_contact_company_office_id`) references `contact_company_offices` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $su_creator_contact_company_office_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubmittalsBySuCreatorContactCompanyOfficeId($database, $su_creator_contact_company_office_id, Input $options=null)
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
			self::$_arrSubmittalsBySuCreatorContactCompanyOfficeId = null;
		}

		$arrSubmittalsBySuCreatorContactCompanyOfficeId = self::$_arrSubmittalsBySuCreatorContactCompanyOfficeId;
		if (isset($arrSubmittalsBySuCreatorContactCompanyOfficeId) && !empty($arrSubmittalsBySuCreatorContactCompanyOfficeId)) {
			return $arrSubmittalsBySuCreatorContactCompanyOfficeId;
		}

		$su_creator_contact_company_office_id = (int) $su_creator_contact_company_office_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `su_sequence_number` ASC, `submittal_type_id` ASC, `submittal_status_id` ASC, `submittal_priority_id` ASC, `submittal_distribution_method_id` ASC, `su_file_manager_file_id` ASC, `su_cost_code_id` ASC, `su_creator_contact_id` ASC, `su_creator_contact_company_office_id` ASC, `su_creator_phone_contact_company_office_phone_number_id` ASC, `su_creator_fax_contact_company_office_phone_number_id` ASC, `su_creator_contact_mobile_phone_number_id` ASC, `su_recipient_contact_id` ASC, `su_recipient_contact_company_office_id` ASC, `su_recipient_phone_contact_company_office_phone_number_id` ASC, `su_recipient_fax_contact_company_office_phone_number_id` ASC, `su_recipient_contact_mobile_phone_number_id` ASC, `su_initiator_contact_id` ASC, `su_initiator_contact_company_office_id` ASC, `su_initiator_phone_contact_company_office_phone_number_id` ASC, `su_initiator_fax_contact_company_office_phone_number_id` ASC, `su_initiator_contact_mobile_phone_number_id` ASC, `su_title` ASC, `su_plan_page_reference` ASC, `su_statement` ASC, `created` ASC, `su_due_date` ASC, `su_closed_date` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubmittal = new Submittal($database);
			$sqlOrderByColumns = $tmpSubmittal->constructSqlOrderByColumns($arrOrderByAttributes);

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
	su.*

FROM `submittals` su
WHERE su.`su_creator_contact_company_office_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `su_sequence_number` ASC, `submittal_type_id` ASC, `submittal_status_id` ASC, `submittal_priority_id` ASC, `submittal_distribution_method_id` ASC, `su_file_manager_file_id` ASC, `su_cost_code_id` ASC, `su_creator_contact_id` ASC, `su_creator_contact_company_office_id` ASC, `su_creator_phone_contact_company_office_phone_number_id` ASC, `su_creator_fax_contact_company_office_phone_number_id` ASC, `su_creator_contact_mobile_phone_number_id` ASC, `su_recipient_contact_id` ASC, `su_recipient_contact_company_office_id` ASC, `su_recipient_phone_contact_company_office_phone_number_id` ASC, `su_recipient_fax_contact_company_office_phone_number_id` ASC, `su_recipient_contact_mobile_phone_number_id` ASC, `su_initiator_contact_id` ASC, `su_initiator_contact_company_office_id` ASC, `su_initiator_phone_contact_company_office_phone_number_id` ASC, `su_initiator_fax_contact_company_office_phone_number_id` ASC, `su_initiator_contact_mobile_phone_number_id` ASC, `su_title` ASC, `su_plan_page_reference` ASC, `su_statement` ASC, `created` ASC, `su_due_date` ASC, `su_closed_date` ASC
		$arrValues = array($su_creator_contact_company_office_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubmittalsBySuCreatorContactCompanyOfficeId = array();
		while ($row = $db->fetch()) {
			$submittal_id = $row['id'];
			$submittal = self::instantiateOrm($database, 'Submittal', $row, null, $submittal_id);
			/* @var $submittal Submittal */
			$arrSubmittalsBySuCreatorContactCompanyOfficeId[$submittal_id] = $submittal;
		}

		$db->free_result();

		self::$_arrSubmittalsBySuCreatorContactCompanyOfficeId = $arrSubmittalsBySuCreatorContactCompanyOfficeId;

		return $arrSubmittalsBySuCreatorContactCompanyOfficeId;
	}

	/**
	 * Load by constraint `submittals_fk_creator_phone_ccopn` foreign key (`su_creator_phone_contact_company_office_phone_number_id`) references `contact_company_office_phone_numbers` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $su_creator_phone_contact_company_office_phone_number_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubmittalsBySuCreatorPhoneContactCompanyOfficePhoneNumberId($database, $su_creator_phone_contact_company_office_phone_number_id, Input $options=null)
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
			self::$_arrSubmittalsBySuCreatorPhoneContactCompanyOfficePhoneNumberId = null;
		}

		$arrSubmittalsBySuCreatorPhoneContactCompanyOfficePhoneNumberId = self::$_arrSubmittalsBySuCreatorPhoneContactCompanyOfficePhoneNumberId;
		if (isset($arrSubmittalsBySuCreatorPhoneContactCompanyOfficePhoneNumberId) && !empty($arrSubmittalsBySuCreatorPhoneContactCompanyOfficePhoneNumberId)) {
			return $arrSubmittalsBySuCreatorPhoneContactCompanyOfficePhoneNumberId;
		}

		$su_creator_phone_contact_company_office_phone_number_id = (int) $su_creator_phone_contact_company_office_phone_number_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `su_sequence_number` ASC, `submittal_type_id` ASC, `submittal_status_id` ASC, `submittal_priority_id` ASC, `submittal_distribution_method_id` ASC, `su_file_manager_file_id` ASC, `su_cost_code_id` ASC, `su_creator_contact_id` ASC, `su_creator_contact_company_office_id` ASC, `su_creator_phone_contact_company_office_phone_number_id` ASC, `su_creator_fax_contact_company_office_phone_number_id` ASC, `su_creator_contact_mobile_phone_number_id` ASC, `su_recipient_contact_id` ASC, `su_recipient_contact_company_office_id` ASC, `su_recipient_phone_contact_company_office_phone_number_id` ASC, `su_recipient_fax_contact_company_office_phone_number_id` ASC, `su_recipient_contact_mobile_phone_number_id` ASC, `su_initiator_contact_id` ASC, `su_initiator_contact_company_office_id` ASC, `su_initiator_phone_contact_company_office_phone_number_id` ASC, `su_initiator_fax_contact_company_office_phone_number_id` ASC, `su_initiator_contact_mobile_phone_number_id` ASC, `su_title` ASC, `su_plan_page_reference` ASC, `su_statement` ASC, `created` ASC, `su_due_date` ASC, `su_closed_date` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubmittal = new Submittal($database);
			$sqlOrderByColumns = $tmpSubmittal->constructSqlOrderByColumns($arrOrderByAttributes);

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
	su.*

FROM `submittals` su
WHERE su.`su_creator_phone_contact_company_office_phone_number_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `su_sequence_number` ASC, `submittal_type_id` ASC, `submittal_status_id` ASC, `submittal_priority_id` ASC, `submittal_distribution_method_id` ASC, `su_file_manager_file_id` ASC, `su_cost_code_id` ASC, `su_creator_contact_id` ASC, `su_creator_contact_company_office_id` ASC, `su_creator_phone_contact_company_office_phone_number_id` ASC, `su_creator_fax_contact_company_office_phone_number_id` ASC, `su_creator_contact_mobile_phone_number_id` ASC, `su_recipient_contact_id` ASC, `su_recipient_contact_company_office_id` ASC, `su_recipient_phone_contact_company_office_phone_number_id` ASC, `su_recipient_fax_contact_company_office_phone_number_id` ASC, `su_recipient_contact_mobile_phone_number_id` ASC, `su_initiator_contact_id` ASC, `su_initiator_contact_company_office_id` ASC, `su_initiator_phone_contact_company_office_phone_number_id` ASC, `su_initiator_fax_contact_company_office_phone_number_id` ASC, `su_initiator_contact_mobile_phone_number_id` ASC, `su_title` ASC, `su_plan_page_reference` ASC, `su_statement` ASC, `created` ASC, `su_due_date` ASC, `su_closed_date` ASC
		$arrValues = array($su_creator_phone_contact_company_office_phone_number_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubmittalsBySuCreatorPhoneContactCompanyOfficePhoneNumberId = array();
		while ($row = $db->fetch()) {
			$submittal_id = $row['id'];
			$submittal = self::instantiateOrm($database, 'Submittal', $row, null, $submittal_id);
			/* @var $submittal Submittal */
			$arrSubmittalsBySuCreatorPhoneContactCompanyOfficePhoneNumberId[$submittal_id] = $submittal;
		}

		$db->free_result();

		self::$_arrSubmittalsBySuCreatorPhoneContactCompanyOfficePhoneNumberId = $arrSubmittalsBySuCreatorPhoneContactCompanyOfficePhoneNumberId;

		return $arrSubmittalsBySuCreatorPhoneContactCompanyOfficePhoneNumberId;
	}

	/**
	 * Load by constraint `submittals_fk_creator_fax_ccopn` foreign key (`su_creator_fax_contact_company_office_phone_number_id`) references `contact_company_office_phone_numbers` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $su_creator_fax_contact_company_office_phone_number_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubmittalsBySuCreatorFaxContactCompanyOfficePhoneNumberId($database, $su_creator_fax_contact_company_office_phone_number_id, Input $options=null)
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
			self::$_arrSubmittalsBySuCreatorFaxContactCompanyOfficePhoneNumberId = null;
		}

		$arrSubmittalsBySuCreatorFaxContactCompanyOfficePhoneNumberId = self::$_arrSubmittalsBySuCreatorFaxContactCompanyOfficePhoneNumberId;
		if (isset($arrSubmittalsBySuCreatorFaxContactCompanyOfficePhoneNumberId) && !empty($arrSubmittalsBySuCreatorFaxContactCompanyOfficePhoneNumberId)) {
			return $arrSubmittalsBySuCreatorFaxContactCompanyOfficePhoneNumberId;
		}

		$su_creator_fax_contact_company_office_phone_number_id = (int) $su_creator_fax_contact_company_office_phone_number_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `su_sequence_number` ASC, `submittal_type_id` ASC, `submittal_status_id` ASC, `submittal_priority_id` ASC, `submittal_distribution_method_id` ASC, `su_file_manager_file_id` ASC, `su_cost_code_id` ASC, `su_creator_contact_id` ASC, `su_creator_contact_company_office_id` ASC, `su_creator_phone_contact_company_office_phone_number_id` ASC, `su_creator_fax_contact_company_office_phone_number_id` ASC, `su_creator_contact_mobile_phone_number_id` ASC, `su_recipient_contact_id` ASC, `su_recipient_contact_company_office_id` ASC, `su_recipient_phone_contact_company_office_phone_number_id` ASC, `su_recipient_fax_contact_company_office_phone_number_id` ASC, `su_recipient_contact_mobile_phone_number_id` ASC, `su_initiator_contact_id` ASC, `su_initiator_contact_company_office_id` ASC, `su_initiator_phone_contact_company_office_phone_number_id` ASC, `su_initiator_fax_contact_company_office_phone_number_id` ASC, `su_initiator_contact_mobile_phone_number_id` ASC, `su_title` ASC, `su_plan_page_reference` ASC, `su_statement` ASC, `created` ASC, `su_due_date` ASC, `su_closed_date` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubmittal = new Submittal($database);
			$sqlOrderByColumns = $tmpSubmittal->constructSqlOrderByColumns($arrOrderByAttributes);

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
	su.*

FROM `submittals` su
WHERE su.`su_creator_fax_contact_company_office_phone_number_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `su_sequence_number` ASC, `submittal_type_id` ASC, `submittal_status_id` ASC, `submittal_priority_id` ASC, `submittal_distribution_method_id` ASC, `su_file_manager_file_id` ASC, `su_cost_code_id` ASC, `su_creator_contact_id` ASC, `su_creator_contact_company_office_id` ASC, `su_creator_phone_contact_company_office_phone_number_id` ASC, `su_creator_fax_contact_company_office_phone_number_id` ASC, `su_creator_contact_mobile_phone_number_id` ASC, `su_recipient_contact_id` ASC, `su_recipient_contact_company_office_id` ASC, `su_recipient_phone_contact_company_office_phone_number_id` ASC, `su_recipient_fax_contact_company_office_phone_number_id` ASC, `su_recipient_contact_mobile_phone_number_id` ASC, `su_initiator_contact_id` ASC, `su_initiator_contact_company_office_id` ASC, `su_initiator_phone_contact_company_office_phone_number_id` ASC, `su_initiator_fax_contact_company_office_phone_number_id` ASC, `su_initiator_contact_mobile_phone_number_id` ASC, `su_title` ASC, `su_plan_page_reference` ASC, `su_statement` ASC, `created` ASC, `su_due_date` ASC, `su_closed_date` ASC
		$arrValues = array($su_creator_fax_contact_company_office_phone_number_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubmittalsBySuCreatorFaxContactCompanyOfficePhoneNumberId = array();
		while ($row = $db->fetch()) {
			$submittal_id = $row['id'];
			$submittal = self::instantiateOrm($database, 'Submittal', $row, null, $submittal_id);
			/* @var $submittal Submittal */
			$arrSubmittalsBySuCreatorFaxContactCompanyOfficePhoneNumberId[$submittal_id] = $submittal;
		}

		$db->free_result();

		self::$_arrSubmittalsBySuCreatorFaxContactCompanyOfficePhoneNumberId = $arrSubmittalsBySuCreatorFaxContactCompanyOfficePhoneNumberId;

		return $arrSubmittalsBySuCreatorFaxContactCompanyOfficePhoneNumberId;
	}

	/**
	 * Load by constraint `submittals_fk_creator_c_mobile_cpn` foreign key (`su_creator_contact_mobile_phone_number_id`) references `contact_phone_numbers` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $su_creator_contact_mobile_phone_number_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubmittalsBySuCreatorContactMobilePhoneNumberId($database, $su_creator_contact_mobile_phone_number_id, Input $options=null)
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
			self::$_arrSubmittalsBySuCreatorContactMobilePhoneNumberId = null;
		}

		$arrSubmittalsBySuCreatorContactMobilePhoneNumberId = self::$_arrSubmittalsBySuCreatorContactMobilePhoneNumberId;
		if (isset($arrSubmittalsBySuCreatorContactMobilePhoneNumberId) && !empty($arrSubmittalsBySuCreatorContactMobilePhoneNumberId)) {
			return $arrSubmittalsBySuCreatorContactMobilePhoneNumberId;
		}

		$su_creator_contact_mobile_phone_number_id = (int) $su_creator_contact_mobile_phone_number_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `su_sequence_number` ASC, `submittal_type_id` ASC, `submittal_status_id` ASC, `submittal_priority_id` ASC, `submittal_distribution_method_id` ASC, `su_file_manager_file_id` ASC, `su_cost_code_id` ASC, `su_creator_contact_id` ASC, `su_creator_contact_company_office_id` ASC, `su_creator_phone_contact_company_office_phone_number_id` ASC, `su_creator_fax_contact_company_office_phone_number_id` ASC, `su_creator_contact_mobile_phone_number_id` ASC, `su_recipient_contact_id` ASC, `su_recipient_contact_company_office_id` ASC, `su_recipient_phone_contact_company_office_phone_number_id` ASC, `su_recipient_fax_contact_company_office_phone_number_id` ASC, `su_recipient_contact_mobile_phone_number_id` ASC, `su_initiator_contact_id` ASC, `su_initiator_contact_company_office_id` ASC, `su_initiator_phone_contact_company_office_phone_number_id` ASC, `su_initiator_fax_contact_company_office_phone_number_id` ASC, `su_initiator_contact_mobile_phone_number_id` ASC, `su_title` ASC, `su_plan_page_reference` ASC, `su_statement` ASC, `created` ASC, `su_due_date` ASC, `su_closed_date` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubmittal = new Submittal($database);
			$sqlOrderByColumns = $tmpSubmittal->constructSqlOrderByColumns($arrOrderByAttributes);

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
	su.*

FROM `submittals` su
WHERE su.`su_creator_contact_mobile_phone_number_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `su_sequence_number` ASC, `submittal_type_id` ASC, `submittal_status_id` ASC, `submittal_priority_id` ASC, `submittal_distribution_method_id` ASC, `su_file_manager_file_id` ASC, `su_cost_code_id` ASC, `su_creator_contact_id` ASC, `su_creator_contact_company_office_id` ASC, `su_creator_phone_contact_company_office_phone_number_id` ASC, `su_creator_fax_contact_company_office_phone_number_id` ASC, `su_creator_contact_mobile_phone_number_id` ASC, `su_recipient_contact_id` ASC, `su_recipient_contact_company_office_id` ASC, `su_recipient_phone_contact_company_office_phone_number_id` ASC, `su_recipient_fax_contact_company_office_phone_number_id` ASC, `su_recipient_contact_mobile_phone_number_id` ASC, `su_initiator_contact_id` ASC, `su_initiator_contact_company_office_id` ASC, `su_initiator_phone_contact_company_office_phone_number_id` ASC, `su_initiator_fax_contact_company_office_phone_number_id` ASC, `su_initiator_contact_mobile_phone_number_id` ASC, `su_title` ASC, `su_plan_page_reference` ASC, `su_statement` ASC, `created` ASC, `su_due_date` ASC, `su_closed_date` ASC
		$arrValues = array($su_creator_contact_mobile_phone_number_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubmittalsBySuCreatorContactMobilePhoneNumberId = array();
		while ($row = $db->fetch()) {
			$submittal_id = $row['id'];
			$submittal = self::instantiateOrm($database, 'Submittal', $row, null, $submittal_id);
			/* @var $submittal Submittal */
			$arrSubmittalsBySuCreatorContactMobilePhoneNumberId[$submittal_id] = $submittal;
		}

		$db->free_result();

		self::$_arrSubmittalsBySuCreatorContactMobilePhoneNumberId = $arrSubmittalsBySuCreatorContactMobilePhoneNumberId;

		return $arrSubmittalsBySuCreatorContactMobilePhoneNumberId;
	}

	/**
	 * Load by constraint `submittals_fk_recipient_c` foreign key (`su_recipient_contact_id`) references `contacts` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $su_recipient_contact_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubmittalsBySuRecipientContactId($database, $su_recipient_contact_id, Input $options=null)
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
			self::$_arrSubmittalsBySuRecipientContactId = null;
		}

		$arrSubmittalsBySuRecipientContactId = self::$_arrSubmittalsBySuRecipientContactId;
		if (isset($arrSubmittalsBySuRecipientContactId) && !empty($arrSubmittalsBySuRecipientContactId)) {
			return $arrSubmittalsBySuRecipientContactId;
		}

		$su_recipient_contact_id = (int) $su_recipient_contact_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `su_sequence_number` ASC, `submittal_type_id` ASC, `submittal_status_id` ASC, `submittal_priority_id` ASC, `submittal_distribution_method_id` ASC, `su_file_manager_file_id` ASC, `su_cost_code_id` ASC, `su_creator_contact_id` ASC, `su_creator_contact_company_office_id` ASC, `su_creator_phone_contact_company_office_phone_number_id` ASC, `su_creator_fax_contact_company_office_phone_number_id` ASC, `su_creator_contact_mobile_phone_number_id` ASC, `su_recipient_contact_id` ASC, `su_recipient_contact_company_office_id` ASC, `su_recipient_phone_contact_company_office_phone_number_id` ASC, `su_recipient_fax_contact_company_office_phone_number_id` ASC, `su_recipient_contact_mobile_phone_number_id` ASC, `su_initiator_contact_id` ASC, `su_initiator_contact_company_office_id` ASC, `su_initiator_phone_contact_company_office_phone_number_id` ASC, `su_initiator_fax_contact_company_office_phone_number_id` ASC, `su_initiator_contact_mobile_phone_number_id` ASC, `su_title` ASC, `su_plan_page_reference` ASC, `su_statement` ASC, `created` ASC, `su_due_date` ASC, `su_closed_date` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubmittal = new Submittal($database);
			$sqlOrderByColumns = $tmpSubmittal->constructSqlOrderByColumns($arrOrderByAttributes);

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
	su.*

FROM `submittals` su
WHERE su.`su_recipient_contact_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `su_sequence_number` ASC, `submittal_type_id` ASC, `submittal_status_id` ASC, `submittal_priority_id` ASC, `submittal_distribution_method_id` ASC, `su_file_manager_file_id` ASC, `su_cost_code_id` ASC, `su_creator_contact_id` ASC, `su_creator_contact_company_office_id` ASC, `su_creator_phone_contact_company_office_phone_number_id` ASC, `su_creator_fax_contact_company_office_phone_number_id` ASC, `su_creator_contact_mobile_phone_number_id` ASC, `su_recipient_contact_id` ASC, `su_recipient_contact_company_office_id` ASC, `su_recipient_phone_contact_company_office_phone_number_id` ASC, `su_recipient_fax_contact_company_office_phone_number_id` ASC, `su_recipient_contact_mobile_phone_number_id` ASC, `su_initiator_contact_id` ASC, `su_initiator_contact_company_office_id` ASC, `su_initiator_phone_contact_company_office_phone_number_id` ASC, `su_initiator_fax_contact_company_office_phone_number_id` ASC, `su_initiator_contact_mobile_phone_number_id` ASC, `su_title` ASC, `su_plan_page_reference` ASC, `su_statement` ASC, `created` ASC, `su_due_date` ASC, `su_closed_date` ASC
		$arrValues = array($su_recipient_contact_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubmittalsBySuRecipientContactId = array();
		while ($row = $db->fetch()) {
			$submittal_id = $row['id'];
			$submittal = self::instantiateOrm($database, 'Submittal', $row, null, $submittal_id);
			/* @var $submittal Submittal */
			$arrSubmittalsBySuRecipientContactId[$submittal_id] = $submittal;
		}

		$db->free_result();

		self::$_arrSubmittalsBySuRecipientContactId = $arrSubmittalsBySuRecipientContactId;

		return $arrSubmittalsBySuRecipientContactId;
	}

	/**
	 * Load by constraint `submittals_fk_recipient_cco` foreign key (`su_recipient_contact_company_office_id`) references `contact_company_offices` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $su_recipient_contact_company_office_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubmittalsBySuRecipientContactCompanyOfficeId($database, $su_recipient_contact_company_office_id, Input $options=null)
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
			self::$_arrSubmittalsBySuRecipientContactCompanyOfficeId = null;
		}

		$arrSubmittalsBySuRecipientContactCompanyOfficeId = self::$_arrSubmittalsBySuRecipientContactCompanyOfficeId;
		if (isset($arrSubmittalsBySuRecipientContactCompanyOfficeId) && !empty($arrSubmittalsBySuRecipientContactCompanyOfficeId)) {
			return $arrSubmittalsBySuRecipientContactCompanyOfficeId;
		}

		$su_recipient_contact_company_office_id = (int) $su_recipient_contact_company_office_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `su_sequence_number` ASC, `submittal_type_id` ASC, `submittal_status_id` ASC, `submittal_priority_id` ASC, `submittal_distribution_method_id` ASC, `su_file_manager_file_id` ASC, `su_cost_code_id` ASC, `su_creator_contact_id` ASC, `su_creator_contact_company_office_id` ASC, `su_creator_phone_contact_company_office_phone_number_id` ASC, `su_creator_fax_contact_company_office_phone_number_id` ASC, `su_creator_contact_mobile_phone_number_id` ASC, `su_recipient_contact_id` ASC, `su_recipient_contact_company_office_id` ASC, `su_recipient_phone_contact_company_office_phone_number_id` ASC, `su_recipient_fax_contact_company_office_phone_number_id` ASC, `su_recipient_contact_mobile_phone_number_id` ASC, `su_initiator_contact_id` ASC, `su_initiator_contact_company_office_id` ASC, `su_initiator_phone_contact_company_office_phone_number_id` ASC, `su_initiator_fax_contact_company_office_phone_number_id` ASC, `su_initiator_contact_mobile_phone_number_id` ASC, `su_title` ASC, `su_plan_page_reference` ASC, `su_statement` ASC, `created` ASC, `su_due_date` ASC, `su_closed_date` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubmittal = new Submittal($database);
			$sqlOrderByColumns = $tmpSubmittal->constructSqlOrderByColumns($arrOrderByAttributes);

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
	su.*

FROM `submittals` su
WHERE su.`su_recipient_contact_company_office_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `su_sequence_number` ASC, `submittal_type_id` ASC, `submittal_status_id` ASC, `submittal_priority_id` ASC, `submittal_distribution_method_id` ASC, `su_file_manager_file_id` ASC, `su_cost_code_id` ASC, `su_creator_contact_id` ASC, `su_creator_contact_company_office_id` ASC, `su_creator_phone_contact_company_office_phone_number_id` ASC, `su_creator_fax_contact_company_office_phone_number_id` ASC, `su_creator_contact_mobile_phone_number_id` ASC, `su_recipient_contact_id` ASC, `su_recipient_contact_company_office_id` ASC, `su_recipient_phone_contact_company_office_phone_number_id` ASC, `su_recipient_fax_contact_company_office_phone_number_id` ASC, `su_recipient_contact_mobile_phone_number_id` ASC, `su_initiator_contact_id` ASC, `su_initiator_contact_company_office_id` ASC, `su_initiator_phone_contact_company_office_phone_number_id` ASC, `su_initiator_fax_contact_company_office_phone_number_id` ASC, `su_initiator_contact_mobile_phone_number_id` ASC, `su_title` ASC, `su_plan_page_reference` ASC, `su_statement` ASC, `created` ASC, `su_due_date` ASC, `su_closed_date` ASC
		$arrValues = array($su_recipient_contact_company_office_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubmittalsBySuRecipientContactCompanyOfficeId = array();
		while ($row = $db->fetch()) {
			$submittal_id = $row['id'];
			$submittal = self::instantiateOrm($database, 'Submittal', $row, null, $submittal_id);
			/* @var $submittal Submittal */
			$arrSubmittalsBySuRecipientContactCompanyOfficeId[$submittal_id] = $submittal;
		}

		$db->free_result();

		self::$_arrSubmittalsBySuRecipientContactCompanyOfficeId = $arrSubmittalsBySuRecipientContactCompanyOfficeId;

		return $arrSubmittalsBySuRecipientContactCompanyOfficeId;
	}

	/**
	 * Load by constraint `submittals_fk_recipient_phone_ccopn` foreign key (`su_recipient_phone_contact_company_office_phone_number_id`) references `contact_company_office_phone_numbers` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $su_recipient_phone_contact_company_office_phone_number_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubmittalsBySuRecipientPhoneContactCompanyOfficePhoneNumberId($database, $su_recipient_phone_contact_company_office_phone_number_id, Input $options=null)
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
			self::$_arrSubmittalsBySuRecipientPhoneContactCompanyOfficePhoneNumberId = null;
		}

		$arrSubmittalsBySuRecipientPhoneContactCompanyOfficePhoneNumberId = self::$_arrSubmittalsBySuRecipientPhoneContactCompanyOfficePhoneNumberId;
		if (isset($arrSubmittalsBySuRecipientPhoneContactCompanyOfficePhoneNumberId) && !empty($arrSubmittalsBySuRecipientPhoneContactCompanyOfficePhoneNumberId)) {
			return $arrSubmittalsBySuRecipientPhoneContactCompanyOfficePhoneNumberId;
		}

		$su_recipient_phone_contact_company_office_phone_number_id = (int) $su_recipient_phone_contact_company_office_phone_number_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `su_sequence_number` ASC, `submittal_type_id` ASC, `submittal_status_id` ASC, `submittal_priority_id` ASC, `submittal_distribution_method_id` ASC, `su_file_manager_file_id` ASC, `su_cost_code_id` ASC, `su_creator_contact_id` ASC, `su_creator_contact_company_office_id` ASC, `su_creator_phone_contact_company_office_phone_number_id` ASC, `su_creator_fax_contact_company_office_phone_number_id` ASC, `su_creator_contact_mobile_phone_number_id` ASC, `su_recipient_contact_id` ASC, `su_recipient_contact_company_office_id` ASC, `su_recipient_phone_contact_company_office_phone_number_id` ASC, `su_recipient_fax_contact_company_office_phone_number_id` ASC, `su_recipient_contact_mobile_phone_number_id` ASC, `su_initiator_contact_id` ASC, `su_initiator_contact_company_office_id` ASC, `su_initiator_phone_contact_company_office_phone_number_id` ASC, `su_initiator_fax_contact_company_office_phone_number_id` ASC, `su_initiator_contact_mobile_phone_number_id` ASC, `su_title` ASC, `su_plan_page_reference` ASC, `su_statement` ASC, `created` ASC, `su_due_date` ASC, `su_closed_date` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubmittal = new Submittal($database);
			$sqlOrderByColumns = $tmpSubmittal->constructSqlOrderByColumns($arrOrderByAttributes);

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
	su.*

FROM `submittals` su
WHERE su.`su_recipient_phone_contact_company_office_phone_number_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `su_sequence_number` ASC, `submittal_type_id` ASC, `submittal_status_id` ASC, `submittal_priority_id` ASC, `submittal_distribution_method_id` ASC, `su_file_manager_file_id` ASC, `su_cost_code_id` ASC, `su_creator_contact_id` ASC, `su_creator_contact_company_office_id` ASC, `su_creator_phone_contact_company_office_phone_number_id` ASC, `su_creator_fax_contact_company_office_phone_number_id` ASC, `su_creator_contact_mobile_phone_number_id` ASC, `su_recipient_contact_id` ASC, `su_recipient_contact_company_office_id` ASC, `su_recipient_phone_contact_company_office_phone_number_id` ASC, `su_recipient_fax_contact_company_office_phone_number_id` ASC, `su_recipient_contact_mobile_phone_number_id` ASC, `su_initiator_contact_id` ASC, `su_initiator_contact_company_office_id` ASC, `su_initiator_phone_contact_company_office_phone_number_id` ASC, `su_initiator_fax_contact_company_office_phone_number_id` ASC, `su_initiator_contact_mobile_phone_number_id` ASC, `su_title` ASC, `su_plan_page_reference` ASC, `su_statement` ASC, `created` ASC, `su_due_date` ASC, `su_closed_date` ASC
		$arrValues = array($su_recipient_phone_contact_company_office_phone_number_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubmittalsBySuRecipientPhoneContactCompanyOfficePhoneNumberId = array();
		while ($row = $db->fetch()) {
			$submittal_id = $row['id'];
			$submittal = self::instantiateOrm($database, 'Submittal', $row, null, $submittal_id);
			/* @var $submittal Submittal */
			$arrSubmittalsBySuRecipientPhoneContactCompanyOfficePhoneNumberId[$submittal_id] = $submittal;
		}

		$db->free_result();

		self::$_arrSubmittalsBySuRecipientPhoneContactCompanyOfficePhoneNumberId = $arrSubmittalsBySuRecipientPhoneContactCompanyOfficePhoneNumberId;

		return $arrSubmittalsBySuRecipientPhoneContactCompanyOfficePhoneNumberId;
	}

	/**
	 * Load by constraint `submittals_fk_recipient_fax_ccopn` foreign key (`su_recipient_fax_contact_company_office_phone_number_id`) references `contact_company_office_phone_numbers` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $su_recipient_fax_contact_company_office_phone_number_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubmittalsBySuRecipientFaxContactCompanyOfficePhoneNumberId($database, $su_recipient_fax_contact_company_office_phone_number_id, Input $options=null)
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
			self::$_arrSubmittalsBySuRecipientFaxContactCompanyOfficePhoneNumberId = null;
		}

		$arrSubmittalsBySuRecipientFaxContactCompanyOfficePhoneNumberId = self::$_arrSubmittalsBySuRecipientFaxContactCompanyOfficePhoneNumberId;
		if (isset($arrSubmittalsBySuRecipientFaxContactCompanyOfficePhoneNumberId) && !empty($arrSubmittalsBySuRecipientFaxContactCompanyOfficePhoneNumberId)) {
			return $arrSubmittalsBySuRecipientFaxContactCompanyOfficePhoneNumberId;
		}

		$su_recipient_fax_contact_company_office_phone_number_id = (int) $su_recipient_fax_contact_company_office_phone_number_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `su_sequence_number` ASC, `submittal_type_id` ASC, `submittal_status_id` ASC, `submittal_priority_id` ASC, `submittal_distribution_method_id` ASC, `su_file_manager_file_id` ASC, `su_cost_code_id` ASC, `su_creator_contact_id` ASC, `su_creator_contact_company_office_id` ASC, `su_creator_phone_contact_company_office_phone_number_id` ASC, `su_creator_fax_contact_company_office_phone_number_id` ASC, `su_creator_contact_mobile_phone_number_id` ASC, `su_recipient_contact_id` ASC, `su_recipient_contact_company_office_id` ASC, `su_recipient_phone_contact_company_office_phone_number_id` ASC, `su_recipient_fax_contact_company_office_phone_number_id` ASC, `su_recipient_contact_mobile_phone_number_id` ASC, `su_initiator_contact_id` ASC, `su_initiator_contact_company_office_id` ASC, `su_initiator_phone_contact_company_office_phone_number_id` ASC, `su_initiator_fax_contact_company_office_phone_number_id` ASC, `su_initiator_contact_mobile_phone_number_id` ASC, `su_title` ASC, `su_plan_page_reference` ASC, `su_statement` ASC, `created` ASC, `su_due_date` ASC, `su_closed_date` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubmittal = new Submittal($database);
			$sqlOrderByColumns = $tmpSubmittal->constructSqlOrderByColumns($arrOrderByAttributes);

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
	su.*

FROM `submittals` su
WHERE su.`su_recipient_fax_contact_company_office_phone_number_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `su_sequence_number` ASC, `submittal_type_id` ASC, `submittal_status_id` ASC, `submittal_priority_id` ASC, `submittal_distribution_method_id` ASC, `su_file_manager_file_id` ASC, `su_cost_code_id` ASC, `su_creator_contact_id` ASC, `su_creator_contact_company_office_id` ASC, `su_creator_phone_contact_company_office_phone_number_id` ASC, `su_creator_fax_contact_company_office_phone_number_id` ASC, `su_creator_contact_mobile_phone_number_id` ASC, `su_recipient_contact_id` ASC, `su_recipient_contact_company_office_id` ASC, `su_recipient_phone_contact_company_office_phone_number_id` ASC, `su_recipient_fax_contact_company_office_phone_number_id` ASC, `su_recipient_contact_mobile_phone_number_id` ASC, `su_initiator_contact_id` ASC, `su_initiator_contact_company_office_id` ASC, `su_initiator_phone_contact_company_office_phone_number_id` ASC, `su_initiator_fax_contact_company_office_phone_number_id` ASC, `su_initiator_contact_mobile_phone_number_id` ASC, `su_title` ASC, `su_plan_page_reference` ASC, `su_statement` ASC, `created` ASC, `su_due_date` ASC, `su_closed_date` ASC
		$arrValues = array($su_recipient_fax_contact_company_office_phone_number_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubmittalsBySuRecipientFaxContactCompanyOfficePhoneNumberId = array();
		while ($row = $db->fetch()) {
			$submittal_id = $row['id'];
			$submittal = self::instantiateOrm($database, 'Submittal', $row, null, $submittal_id);
			/* @var $submittal Submittal */
			$arrSubmittalsBySuRecipientFaxContactCompanyOfficePhoneNumberId[$submittal_id] = $submittal;
		}

		$db->free_result();

		self::$_arrSubmittalsBySuRecipientFaxContactCompanyOfficePhoneNumberId = $arrSubmittalsBySuRecipientFaxContactCompanyOfficePhoneNumberId;

		return $arrSubmittalsBySuRecipientFaxContactCompanyOfficePhoneNumberId;
	}

	/**
	 * Load by constraint `submittals_fk_recipient_c_mobile_cpn` foreign key (`su_recipient_contact_mobile_phone_number_id`) references `contact_phone_numbers` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $su_recipient_contact_mobile_phone_number_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubmittalsBySuRecipientContactMobilePhoneNumberId($database, $su_recipient_contact_mobile_phone_number_id, Input $options=null)
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
			self::$_arrSubmittalsBySuRecipientContactMobilePhoneNumberId = null;
		}

		$arrSubmittalsBySuRecipientContactMobilePhoneNumberId = self::$_arrSubmittalsBySuRecipientContactMobilePhoneNumberId;
		if (isset($arrSubmittalsBySuRecipientContactMobilePhoneNumberId) && !empty($arrSubmittalsBySuRecipientContactMobilePhoneNumberId)) {
			return $arrSubmittalsBySuRecipientContactMobilePhoneNumberId;
		}

		$su_recipient_contact_mobile_phone_number_id = (int) $su_recipient_contact_mobile_phone_number_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `su_sequence_number` ASC, `submittal_type_id` ASC, `submittal_status_id` ASC, `submittal_priority_id` ASC, `submittal_distribution_method_id` ASC, `su_file_manager_file_id` ASC, `su_cost_code_id` ASC, `su_creator_contact_id` ASC, `su_creator_contact_company_office_id` ASC, `su_creator_phone_contact_company_office_phone_number_id` ASC, `su_creator_fax_contact_company_office_phone_number_id` ASC, `su_creator_contact_mobile_phone_number_id` ASC, `su_recipient_contact_id` ASC, `su_recipient_contact_company_office_id` ASC, `su_recipient_phone_contact_company_office_phone_number_id` ASC, `su_recipient_fax_contact_company_office_phone_number_id` ASC, `su_recipient_contact_mobile_phone_number_id` ASC, `su_initiator_contact_id` ASC, `su_initiator_contact_company_office_id` ASC, `su_initiator_phone_contact_company_office_phone_number_id` ASC, `su_initiator_fax_contact_company_office_phone_number_id` ASC, `su_initiator_contact_mobile_phone_number_id` ASC, `su_title` ASC, `su_plan_page_reference` ASC, `su_statement` ASC, `created` ASC, `su_due_date` ASC, `su_closed_date` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubmittal = new Submittal($database);
			$sqlOrderByColumns = $tmpSubmittal->constructSqlOrderByColumns($arrOrderByAttributes);

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
	su.*

FROM `submittals` su
WHERE su.`su_recipient_contact_mobile_phone_number_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `su_sequence_number` ASC, `submittal_type_id` ASC, `submittal_status_id` ASC, `submittal_priority_id` ASC, `submittal_distribution_method_id` ASC, `su_file_manager_file_id` ASC, `su_cost_code_id` ASC, `su_creator_contact_id` ASC, `su_creator_contact_company_office_id` ASC, `su_creator_phone_contact_company_office_phone_number_id` ASC, `su_creator_fax_contact_company_office_phone_number_id` ASC, `su_creator_contact_mobile_phone_number_id` ASC, `su_recipient_contact_id` ASC, `su_recipient_contact_company_office_id` ASC, `su_recipient_phone_contact_company_office_phone_number_id` ASC, `su_recipient_fax_contact_company_office_phone_number_id` ASC, `su_recipient_contact_mobile_phone_number_id` ASC, `su_initiator_contact_id` ASC, `su_initiator_contact_company_office_id` ASC, `su_initiator_phone_contact_company_office_phone_number_id` ASC, `su_initiator_fax_contact_company_office_phone_number_id` ASC, `su_initiator_contact_mobile_phone_number_id` ASC, `su_title` ASC, `su_plan_page_reference` ASC, `su_statement` ASC, `created` ASC, `su_due_date` ASC, `su_closed_date` ASC
		$arrValues = array($su_recipient_contact_mobile_phone_number_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubmittalsBySuRecipientContactMobilePhoneNumberId = array();
		while ($row = $db->fetch()) {
			$submittal_id = $row['id'];
			$submittal = self::instantiateOrm($database, 'Submittal', $row, null, $submittal_id);
			/* @var $submittal Submittal */
			$arrSubmittalsBySuRecipientContactMobilePhoneNumberId[$submittal_id] = $submittal;
		}

		$db->free_result();

		self::$_arrSubmittalsBySuRecipientContactMobilePhoneNumberId = $arrSubmittalsBySuRecipientContactMobilePhoneNumberId;

		return $arrSubmittalsBySuRecipientContactMobilePhoneNumberId;
	}

	/**
	 * Load by constraint `submittals_fk_initiator_c` foreign key (`su_initiator_contact_id`) references `contacts` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $su_initiator_contact_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubmittalsBySuInitiatorContactId($database, $su_initiator_contact_id, Input $options=null)
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
			self::$_arrSubmittalsBySuInitiatorContactId = null;
		}

		$arrSubmittalsBySuInitiatorContactId = self::$_arrSubmittalsBySuInitiatorContactId;
		if (isset($arrSubmittalsBySuInitiatorContactId) && !empty($arrSubmittalsBySuInitiatorContactId)) {
			return $arrSubmittalsBySuInitiatorContactId;
		}

		$su_initiator_contact_id = (int) $su_initiator_contact_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `su_sequence_number` ASC, `submittal_type_id` ASC, `submittal_status_id` ASC, `submittal_priority_id` ASC, `submittal_distribution_method_id` ASC, `su_file_manager_file_id` ASC, `su_cost_code_id` ASC, `su_creator_contact_id` ASC, `su_creator_contact_company_office_id` ASC, `su_creator_phone_contact_company_office_phone_number_id` ASC, `su_creator_fax_contact_company_office_phone_number_id` ASC, `su_creator_contact_mobile_phone_number_id` ASC, `su_recipient_contact_id` ASC, `su_recipient_contact_company_office_id` ASC, `su_recipient_phone_contact_company_office_phone_number_id` ASC, `su_recipient_fax_contact_company_office_phone_number_id` ASC, `su_recipient_contact_mobile_phone_number_id` ASC, `su_initiator_contact_id` ASC, `su_initiator_contact_company_office_id` ASC, `su_initiator_phone_contact_company_office_phone_number_id` ASC, `su_initiator_fax_contact_company_office_phone_number_id` ASC, `su_initiator_contact_mobile_phone_number_id` ASC, `su_title` ASC, `su_plan_page_reference` ASC, `su_statement` ASC, `created` ASC, `su_due_date` ASC, `su_closed_date` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubmittal = new Submittal($database);
			$sqlOrderByColumns = $tmpSubmittal->constructSqlOrderByColumns($arrOrderByAttributes);

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
	su.*

FROM `submittals` su
WHERE su.`su_initiator_contact_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `su_sequence_number` ASC, `submittal_type_id` ASC, `submittal_status_id` ASC, `submittal_priority_id` ASC, `submittal_distribution_method_id` ASC, `su_file_manager_file_id` ASC, `su_cost_code_id` ASC, `su_creator_contact_id` ASC, `su_creator_contact_company_office_id` ASC, `su_creator_phone_contact_company_office_phone_number_id` ASC, `su_creator_fax_contact_company_office_phone_number_id` ASC, `su_creator_contact_mobile_phone_number_id` ASC, `su_recipient_contact_id` ASC, `su_recipient_contact_company_office_id` ASC, `su_recipient_phone_contact_company_office_phone_number_id` ASC, `su_recipient_fax_contact_company_office_phone_number_id` ASC, `su_recipient_contact_mobile_phone_number_id` ASC, `su_initiator_contact_id` ASC, `su_initiator_contact_company_office_id` ASC, `su_initiator_phone_contact_company_office_phone_number_id` ASC, `su_initiator_fax_contact_company_office_phone_number_id` ASC, `su_initiator_contact_mobile_phone_number_id` ASC, `su_title` ASC, `su_plan_page_reference` ASC, `su_statement` ASC, `created` ASC, `su_due_date` ASC, `su_closed_date` ASC
		$arrValues = array($su_initiator_contact_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubmittalsBySuInitiatorContactId = array();
		while ($row = $db->fetch()) {
			$submittal_id = $row['id'];
			$submittal = self::instantiateOrm($database, 'Submittal', $row, null, $submittal_id);
			/* @var $submittal Submittal */
			$arrSubmittalsBySuInitiatorContactId[$submittal_id] = $submittal;
		}

		$db->free_result();

		self::$_arrSubmittalsBySuInitiatorContactId = $arrSubmittalsBySuInitiatorContactId;

		return $arrSubmittalsBySuInitiatorContactId;
	}

	/**
	 * Load by constraint `submittals_fk_initiator_cco` foreign key (`su_initiator_contact_company_office_id`) references `contact_company_offices` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $su_initiator_contact_company_office_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubmittalsBySuInitiatorContactCompanyOfficeId($database, $su_initiator_contact_company_office_id, Input $options=null)
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
			self::$_arrSubmittalsBySuInitiatorContactCompanyOfficeId = null;
		}

		$arrSubmittalsBySuInitiatorContactCompanyOfficeId = self::$_arrSubmittalsBySuInitiatorContactCompanyOfficeId;
		if (isset($arrSubmittalsBySuInitiatorContactCompanyOfficeId) && !empty($arrSubmittalsBySuInitiatorContactCompanyOfficeId)) {
			return $arrSubmittalsBySuInitiatorContactCompanyOfficeId;
		}

		$su_initiator_contact_company_office_id = (int) $su_initiator_contact_company_office_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `su_sequence_number` ASC, `submittal_type_id` ASC, `submittal_status_id` ASC, `submittal_priority_id` ASC, `submittal_distribution_method_id` ASC, `su_file_manager_file_id` ASC, `su_cost_code_id` ASC, `su_creator_contact_id` ASC, `su_creator_contact_company_office_id` ASC, `su_creator_phone_contact_company_office_phone_number_id` ASC, `su_creator_fax_contact_company_office_phone_number_id` ASC, `su_creator_contact_mobile_phone_number_id` ASC, `su_recipient_contact_id` ASC, `su_recipient_contact_company_office_id` ASC, `su_recipient_phone_contact_company_office_phone_number_id` ASC, `su_recipient_fax_contact_company_office_phone_number_id` ASC, `su_recipient_contact_mobile_phone_number_id` ASC, `su_initiator_contact_id` ASC, `su_initiator_contact_company_office_id` ASC, `su_initiator_phone_contact_company_office_phone_number_id` ASC, `su_initiator_fax_contact_company_office_phone_number_id` ASC, `su_initiator_contact_mobile_phone_number_id` ASC, `su_title` ASC, `su_plan_page_reference` ASC, `su_statement` ASC, `created` ASC, `su_due_date` ASC, `su_closed_date` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubmittal = new Submittal($database);
			$sqlOrderByColumns = $tmpSubmittal->constructSqlOrderByColumns($arrOrderByAttributes);

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
	su.*

FROM `submittals` su
WHERE su.`su_initiator_contact_company_office_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `su_sequence_number` ASC, `submittal_type_id` ASC, `submittal_status_id` ASC, `submittal_priority_id` ASC, `submittal_distribution_method_id` ASC, `su_file_manager_file_id` ASC, `su_cost_code_id` ASC, `su_creator_contact_id` ASC, `su_creator_contact_company_office_id` ASC, `su_creator_phone_contact_company_office_phone_number_id` ASC, `su_creator_fax_contact_company_office_phone_number_id` ASC, `su_creator_contact_mobile_phone_number_id` ASC, `su_recipient_contact_id` ASC, `su_recipient_contact_company_office_id` ASC, `su_recipient_phone_contact_company_office_phone_number_id` ASC, `su_recipient_fax_contact_company_office_phone_number_id` ASC, `su_recipient_contact_mobile_phone_number_id` ASC, `su_initiator_contact_id` ASC, `su_initiator_contact_company_office_id` ASC, `su_initiator_phone_contact_company_office_phone_number_id` ASC, `su_initiator_fax_contact_company_office_phone_number_id` ASC, `su_initiator_contact_mobile_phone_number_id` ASC, `su_title` ASC, `su_plan_page_reference` ASC, `su_statement` ASC, `created` ASC, `su_due_date` ASC, `su_closed_date` ASC
		$arrValues = array($su_initiator_contact_company_office_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubmittalsBySuInitiatorContactCompanyOfficeId = array();
		while ($row = $db->fetch()) {
			$submittal_id = $row['id'];
			$submittal = self::instantiateOrm($database, 'Submittal', $row, null, $submittal_id);
			/* @var $submittal Submittal */
			$arrSubmittalsBySuInitiatorContactCompanyOfficeId[$submittal_id] = $submittal;
		}

		$db->free_result();

		self::$_arrSubmittalsBySuInitiatorContactCompanyOfficeId = $arrSubmittalsBySuInitiatorContactCompanyOfficeId;

		return $arrSubmittalsBySuInitiatorContactCompanyOfficeId;
	}

	/**
	 * Load by constraint `submittals_fk_initiator_phone_ccopn` foreign key (`su_initiator_phone_contact_company_office_phone_number_id`) references `contact_company_office_phone_numbers` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $su_initiator_phone_contact_company_office_phone_number_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubmittalsBySuInitiatorPhoneContactCompanyOfficePhoneNumberId($database, $su_initiator_phone_contact_company_office_phone_number_id, Input $options=null)
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
			self::$_arrSubmittalsBySuInitiatorPhoneContactCompanyOfficePhoneNumberId = null;
		}

		$arrSubmittalsBySuInitiatorPhoneContactCompanyOfficePhoneNumberId = self::$_arrSubmittalsBySuInitiatorPhoneContactCompanyOfficePhoneNumberId;
		if (isset($arrSubmittalsBySuInitiatorPhoneContactCompanyOfficePhoneNumberId) && !empty($arrSubmittalsBySuInitiatorPhoneContactCompanyOfficePhoneNumberId)) {
			return $arrSubmittalsBySuInitiatorPhoneContactCompanyOfficePhoneNumberId;
		}

		$su_initiator_phone_contact_company_office_phone_number_id = (int) $su_initiator_phone_contact_company_office_phone_number_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `su_sequence_number` ASC, `submittal_type_id` ASC, `submittal_status_id` ASC, `submittal_priority_id` ASC, `submittal_distribution_method_id` ASC, `su_file_manager_file_id` ASC, `su_cost_code_id` ASC, `su_creator_contact_id` ASC, `su_creator_contact_company_office_id` ASC, `su_creator_phone_contact_company_office_phone_number_id` ASC, `su_creator_fax_contact_company_office_phone_number_id` ASC, `su_creator_contact_mobile_phone_number_id` ASC, `su_recipient_contact_id` ASC, `su_recipient_contact_company_office_id` ASC, `su_recipient_phone_contact_company_office_phone_number_id` ASC, `su_recipient_fax_contact_company_office_phone_number_id` ASC, `su_recipient_contact_mobile_phone_number_id` ASC, `su_initiator_contact_id` ASC, `su_initiator_contact_company_office_id` ASC, `su_initiator_phone_contact_company_office_phone_number_id` ASC, `su_initiator_fax_contact_company_office_phone_number_id` ASC, `su_initiator_contact_mobile_phone_number_id` ASC, `su_title` ASC, `su_plan_page_reference` ASC, `su_statement` ASC, `created` ASC, `su_due_date` ASC, `su_closed_date` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubmittal = new Submittal($database);
			$sqlOrderByColumns = $tmpSubmittal->constructSqlOrderByColumns($arrOrderByAttributes);

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
	su.*

FROM `submittals` su
WHERE su.`su_initiator_phone_contact_company_office_phone_number_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `su_sequence_number` ASC, `submittal_type_id` ASC, `submittal_status_id` ASC, `submittal_priority_id` ASC, `submittal_distribution_method_id` ASC, `su_file_manager_file_id` ASC, `su_cost_code_id` ASC, `su_creator_contact_id` ASC, `su_creator_contact_company_office_id` ASC, `su_creator_phone_contact_company_office_phone_number_id` ASC, `su_creator_fax_contact_company_office_phone_number_id` ASC, `su_creator_contact_mobile_phone_number_id` ASC, `su_recipient_contact_id` ASC, `su_recipient_contact_company_office_id` ASC, `su_recipient_phone_contact_company_office_phone_number_id` ASC, `su_recipient_fax_contact_company_office_phone_number_id` ASC, `su_recipient_contact_mobile_phone_number_id` ASC, `su_initiator_contact_id` ASC, `su_initiator_contact_company_office_id` ASC, `su_initiator_phone_contact_company_office_phone_number_id` ASC, `su_initiator_fax_contact_company_office_phone_number_id` ASC, `su_initiator_contact_mobile_phone_number_id` ASC, `su_title` ASC, `su_plan_page_reference` ASC, `su_statement` ASC, `created` ASC, `su_due_date` ASC, `su_closed_date` ASC
		$arrValues = array($su_initiator_phone_contact_company_office_phone_number_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubmittalsBySuInitiatorPhoneContactCompanyOfficePhoneNumberId = array();
		while ($row = $db->fetch()) {
			$submittal_id = $row['id'];
			$submittal = self::instantiateOrm($database, 'Submittal', $row, null, $submittal_id);
			/* @var $submittal Submittal */
			$arrSubmittalsBySuInitiatorPhoneContactCompanyOfficePhoneNumberId[$submittal_id] = $submittal;
		}

		$db->free_result();

		self::$_arrSubmittalsBySuInitiatorPhoneContactCompanyOfficePhoneNumberId = $arrSubmittalsBySuInitiatorPhoneContactCompanyOfficePhoneNumberId;

		return $arrSubmittalsBySuInitiatorPhoneContactCompanyOfficePhoneNumberId;
	}

	/**
	 * Load by constraint `submittals_fk_initiator_fax_ccopn` foreign key (`su_initiator_fax_contact_company_office_phone_number_id`) references `contact_company_office_phone_numbers` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $su_initiator_fax_contact_company_office_phone_number_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubmittalsBySuInitiatorFaxContactCompanyOfficePhoneNumberId($database, $su_initiator_fax_contact_company_office_phone_number_id, Input $options=null)
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
			self::$_arrSubmittalsBySuInitiatorFaxContactCompanyOfficePhoneNumberId = null;
		}

		$arrSubmittalsBySuInitiatorFaxContactCompanyOfficePhoneNumberId = self::$_arrSubmittalsBySuInitiatorFaxContactCompanyOfficePhoneNumberId;
		if (isset($arrSubmittalsBySuInitiatorFaxContactCompanyOfficePhoneNumberId) && !empty($arrSubmittalsBySuInitiatorFaxContactCompanyOfficePhoneNumberId)) {
			return $arrSubmittalsBySuInitiatorFaxContactCompanyOfficePhoneNumberId;
		}

		$su_initiator_fax_contact_company_office_phone_number_id = (int) $su_initiator_fax_contact_company_office_phone_number_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `su_sequence_number` ASC, `submittal_type_id` ASC, `submittal_status_id` ASC, `submittal_priority_id` ASC, `submittal_distribution_method_id` ASC, `su_file_manager_file_id` ASC, `su_cost_code_id` ASC, `su_creator_contact_id` ASC, `su_creator_contact_company_office_id` ASC, `su_creator_phone_contact_company_office_phone_number_id` ASC, `su_creator_fax_contact_company_office_phone_number_id` ASC, `su_creator_contact_mobile_phone_number_id` ASC, `su_recipient_contact_id` ASC, `su_recipient_contact_company_office_id` ASC, `su_recipient_phone_contact_company_office_phone_number_id` ASC, `su_recipient_fax_contact_company_office_phone_number_id` ASC, `su_recipient_contact_mobile_phone_number_id` ASC, `su_initiator_contact_id` ASC, `su_initiator_contact_company_office_id` ASC, `su_initiator_phone_contact_company_office_phone_number_id` ASC, `su_initiator_fax_contact_company_office_phone_number_id` ASC, `su_initiator_contact_mobile_phone_number_id` ASC, `su_title` ASC, `su_plan_page_reference` ASC, `su_statement` ASC, `created` ASC, `su_due_date` ASC, `su_closed_date` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubmittal = new Submittal($database);
			$sqlOrderByColumns = $tmpSubmittal->constructSqlOrderByColumns($arrOrderByAttributes);

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
	su.*

FROM `submittals` su
WHERE su.`su_initiator_fax_contact_company_office_phone_number_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `su_sequence_number` ASC, `submittal_type_id` ASC, `submittal_status_id` ASC, `submittal_priority_id` ASC, `submittal_distribution_method_id` ASC, `su_file_manager_file_id` ASC, `su_cost_code_id` ASC, `su_creator_contact_id` ASC, `su_creator_contact_company_office_id` ASC, `su_creator_phone_contact_company_office_phone_number_id` ASC, `su_creator_fax_contact_company_office_phone_number_id` ASC, `su_creator_contact_mobile_phone_number_id` ASC, `su_recipient_contact_id` ASC, `su_recipient_contact_company_office_id` ASC, `su_recipient_phone_contact_company_office_phone_number_id` ASC, `su_recipient_fax_contact_company_office_phone_number_id` ASC, `su_recipient_contact_mobile_phone_number_id` ASC, `su_initiator_contact_id` ASC, `su_initiator_contact_company_office_id` ASC, `su_initiator_phone_contact_company_office_phone_number_id` ASC, `su_initiator_fax_contact_company_office_phone_number_id` ASC, `su_initiator_contact_mobile_phone_number_id` ASC, `su_title` ASC, `su_plan_page_reference` ASC, `su_statement` ASC, `created` ASC, `su_due_date` ASC, `su_closed_date` ASC
		$arrValues = array($su_initiator_fax_contact_company_office_phone_number_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubmittalsBySuInitiatorFaxContactCompanyOfficePhoneNumberId = array();
		while ($row = $db->fetch()) {
			$submittal_id = $row['id'];
			$submittal = self::instantiateOrm($database, 'Submittal', $row, null, $submittal_id);
			/* @var $submittal Submittal */
			$arrSubmittalsBySuInitiatorFaxContactCompanyOfficePhoneNumberId[$submittal_id] = $submittal;
		}

		$db->free_result();

		self::$_arrSubmittalsBySuInitiatorFaxContactCompanyOfficePhoneNumberId = $arrSubmittalsBySuInitiatorFaxContactCompanyOfficePhoneNumberId;

		return $arrSubmittalsBySuInitiatorFaxContactCompanyOfficePhoneNumberId;
	}

	/**
	 * Load by constraint `submittals_fk_initiator_c_mobile_cpn` foreign key (`su_initiator_contact_mobile_phone_number_id`) references `contact_phone_numbers` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $su_initiator_contact_mobile_phone_number_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubmittalsBySuInitiatorContactMobilePhoneNumberId($database, $su_initiator_contact_mobile_phone_number_id, Input $options=null)
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
			self::$_arrSubmittalsBySuInitiatorContactMobilePhoneNumberId = null;
		}

		$arrSubmittalsBySuInitiatorContactMobilePhoneNumberId = self::$_arrSubmittalsBySuInitiatorContactMobilePhoneNumberId;
		if (isset($arrSubmittalsBySuInitiatorContactMobilePhoneNumberId) && !empty($arrSubmittalsBySuInitiatorContactMobilePhoneNumberId)) {
			return $arrSubmittalsBySuInitiatorContactMobilePhoneNumberId;
		}

		$su_initiator_contact_mobile_phone_number_id = (int) $su_initiator_contact_mobile_phone_number_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `su_sequence_number` ASC, `submittal_type_id` ASC, `submittal_status_id` ASC, `submittal_priority_id` ASC, `submittal_distribution_method_id` ASC, `su_file_manager_file_id` ASC, `su_cost_code_id` ASC, `su_creator_contact_id` ASC, `su_creator_contact_company_office_id` ASC, `su_creator_phone_contact_company_office_phone_number_id` ASC, `su_creator_fax_contact_company_office_phone_number_id` ASC, `su_creator_contact_mobile_phone_number_id` ASC, `su_recipient_contact_id` ASC, `su_recipient_contact_company_office_id` ASC, `su_recipient_phone_contact_company_office_phone_number_id` ASC, `su_recipient_fax_contact_company_office_phone_number_id` ASC, `su_recipient_contact_mobile_phone_number_id` ASC, `su_initiator_contact_id` ASC, `su_initiator_contact_company_office_id` ASC, `su_initiator_phone_contact_company_office_phone_number_id` ASC, `su_initiator_fax_contact_company_office_phone_number_id` ASC, `su_initiator_contact_mobile_phone_number_id` ASC, `su_title` ASC, `su_plan_page_reference` ASC, `su_statement` ASC, `created` ASC, `su_due_date` ASC, `su_closed_date` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubmittal = new Submittal($database);
			$sqlOrderByColumns = $tmpSubmittal->constructSqlOrderByColumns($arrOrderByAttributes);

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
	su.*

FROM `submittals` su
WHERE su.`su_initiator_contact_mobile_phone_number_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `su_sequence_number` ASC, `submittal_type_id` ASC, `submittal_status_id` ASC, `submittal_priority_id` ASC, `submittal_distribution_method_id` ASC, `su_file_manager_file_id` ASC, `su_cost_code_id` ASC, `su_creator_contact_id` ASC, `su_creator_contact_company_office_id` ASC, `su_creator_phone_contact_company_office_phone_number_id` ASC, `su_creator_fax_contact_company_office_phone_number_id` ASC, `su_creator_contact_mobile_phone_number_id` ASC, `su_recipient_contact_id` ASC, `su_recipient_contact_company_office_id` ASC, `su_recipient_phone_contact_company_office_phone_number_id` ASC, `su_recipient_fax_contact_company_office_phone_number_id` ASC, `su_recipient_contact_mobile_phone_number_id` ASC, `su_initiator_contact_id` ASC, `su_initiator_contact_company_office_id` ASC, `su_initiator_phone_contact_company_office_phone_number_id` ASC, `su_initiator_fax_contact_company_office_phone_number_id` ASC, `su_initiator_contact_mobile_phone_number_id` ASC, `su_title` ASC, `su_plan_page_reference` ASC, `su_statement` ASC, `created` ASC, `su_due_date` ASC, `su_closed_date` ASC
		$arrValues = array($su_initiator_contact_mobile_phone_number_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubmittalsBySuInitiatorContactMobilePhoneNumberId = array();
		while ($row = $db->fetch()) {
			$submittal_id = $row['id'];
			$submittal = self::instantiateOrm($database, 'Submittal', $row, null, $submittal_id);
			/* @var $submittal Submittal */
			$arrSubmittalsBySuInitiatorContactMobilePhoneNumberId[$submittal_id] = $submittal;
		}

		$db->free_result();

		self::$_arrSubmittalsBySuInitiatorContactMobilePhoneNumberId = $arrSubmittalsBySuInitiatorContactMobilePhoneNumberId;

		return $arrSubmittalsBySuInitiatorContactMobilePhoneNumberId;
	}

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all submittals records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllSubmittals($database, Input $options=null)
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
			self::$_arrAllSubmittals = null;
		}

		$arrAllSubmittals = self::$_arrAllSubmittals;
		if (isset($arrAllSubmittals) && !empty($arrAllSubmittals)) {
			return $arrAllSubmittals;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `su_sequence_number` ASC, `submittal_type_id` ASC, `submittal_status_id` ASC, `submittal_priority_id` ASC, `submittal_distribution_method_id` ASC, `su_file_manager_file_id` ASC, `su_cost_code_id` ASC, `su_creator_contact_id` ASC, `su_creator_contact_company_office_id` ASC, `su_creator_phone_contact_company_office_phone_number_id` ASC, `su_creator_fax_contact_company_office_phone_number_id` ASC, `su_creator_contact_mobile_phone_number_id` ASC, `su_recipient_contact_id` ASC, `su_recipient_contact_company_office_id` ASC, `su_recipient_phone_contact_company_office_phone_number_id` ASC, `su_recipient_fax_contact_company_office_phone_number_id` ASC, `su_recipient_contact_mobile_phone_number_id` ASC, `su_initiator_contact_id` ASC, `su_initiator_contact_company_office_id` ASC, `su_initiator_phone_contact_company_office_phone_number_id` ASC, `su_initiator_fax_contact_company_office_phone_number_id` ASC, `su_initiator_contact_mobile_phone_number_id` ASC, `su_title` ASC, `su_plan_page_reference` ASC, `su_statement` ASC, `created` ASC, `su_due_date` ASC, `su_closed_date` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubmittal = new Submittal($database);
			$sqlOrderByColumns = $tmpSubmittal->constructSqlOrderByColumns($arrOrderByAttributes);

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
	su.*

FROM `submittals` su{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `su_sequence_number` ASC, `submittal_type_id` ASC, `submittal_status_id` ASC, `submittal_priority_id` ASC, `submittal_distribution_method_id` ASC, `su_file_manager_file_id` ASC, `su_cost_code_id` ASC, `su_creator_contact_id` ASC, `su_creator_contact_company_office_id` ASC, `su_creator_phone_contact_company_office_phone_number_id` ASC, `su_creator_fax_contact_company_office_phone_number_id` ASC, `su_creator_contact_mobile_phone_number_id` ASC, `su_recipient_contact_id` ASC, `su_recipient_contact_company_office_id` ASC, `su_recipient_phone_contact_company_office_phone_number_id` ASC, `su_recipient_fax_contact_company_office_phone_number_id` ASC, `su_recipient_contact_mobile_phone_number_id` ASC, `su_initiator_contact_id` ASC, `su_initiator_contact_company_office_id` ASC, `su_initiator_phone_contact_company_office_phone_number_id` ASC, `su_initiator_fax_contact_company_office_phone_number_id` ASC, `su_initiator_contact_mobile_phone_number_id` ASC, `su_title` ASC, `su_plan_page_reference` ASC, `su_statement` ASC, `created` ASC, `su_due_date` ASC, `su_closed_date` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllSubmittals = array();
		while ($row = $db->fetch()) {
			$submittal_id = $row['id'];
			$submittal = self::instantiateOrm($database, 'Submittal', $row, null, $submittal_id);
			/* @var $submittal Submittal */
			$arrAllSubmittals[$submittal_id] = $submittal;
		}

		$db->free_result();

		self::$_arrAllSubmittals = $arrAllSubmittals;

		return $arrAllSubmittals;
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
INTO `submittals`
(`project_id`,`contracting_entity_id`, `su_sequence_number`,`su_spec_no`, `submittal_type_id`, `submittal_status_id`, `submittal_priority_id`, `submittal_distribution_method_id`, `su_file_manager_file_id`, `su_cost_code_id`, `su_creator_contact_id`, `su_creator_contact_company_office_id`, `su_creator_phone_contact_company_office_phone_number_id`, `su_creator_fax_contact_company_office_phone_number_id`, `su_creator_contact_mobile_phone_number_id`, `su_recipient_contact_id`, `su_recipient_contact_company_office_id`, `su_recipient_phone_contact_company_office_phone_number_id`, `su_recipient_fax_contact_company_office_phone_number_id`, `su_recipient_contact_mobile_phone_number_id`, `su_initiator_contact_id`, `su_initiator_contact_company_office_id`, `su_initiator_phone_contact_company_office_phone_number_id`, `su_initiator_fax_contact_company_office_phone_number_id`, `su_initiator_contact_mobile_phone_number_id`, `su_title`, `su_plan_page_reference`, `su_statement`,`tag_ids`, `created`, `su_due_date`, `su_closed_date`)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
ON DUPLICATE KEY UPDATE `submittal_type_id` = ?,`contracting_entity_id` =?,`su_spec_no`=? `submittal_status_id` = ?, `submittal_priority_id` = ?, `submittal_distribution_method_id` = ?, `su_file_manager_file_id` = ?, `su_cost_code_id` = ?, `su_creator_contact_id` = ?, `su_creator_contact_company_office_id` = ?, `su_creator_phone_contact_company_office_phone_number_id` = ?, `su_creator_fax_contact_company_office_phone_number_id` = ?, `su_creator_contact_mobile_phone_number_id` = ?, `su_recipient_contact_id` = ?, `su_recipient_contact_company_office_id` = ?, `su_recipient_phone_contact_company_office_phone_number_id` = ?, `su_recipient_fax_contact_company_office_phone_number_id` = ?, `su_recipient_contact_mobile_phone_number_id` = ?, `su_initiator_contact_id` = ?, `su_initiator_contact_company_office_id` = ?, `su_initiator_phone_contact_company_office_phone_number_id` = ?, `su_initiator_fax_contact_company_office_phone_number_id` = ?, `su_initiator_contact_mobile_phone_number_id` = ?, `su_title` = ?, `su_plan_page_reference` = ?, `su_statement` = ?,`tag_ids`=?, `created` = ?, `su_due_date` = ?, `su_closed_date` = ?
";
		$arrValues = array($this->project_id,$this->contracting_entity_id, $this->su_sequence_number,$this->su_spec_no, $this->submittal_type_id, $this->submittal_status_id, $this->submittal_priority_id, $this->submittal_distribution_method_id, $this->su_file_manager_file_id, $this->su_cost_code_id, $this->su_creator_contact_id, $this->su_creator_contact_company_office_id, $this->su_creator_phone_contact_company_office_phone_number_id, $this->su_creator_fax_contact_company_office_phone_number_id, $this->su_creator_contact_mobile_phone_number_id, $this->su_recipient_contact_id, $this->su_recipient_contact_company_office_id, $this->su_recipient_phone_contact_company_office_phone_number_id, $this->su_recipient_fax_contact_company_office_phone_number_id, $this->su_recipient_contact_mobile_phone_number_id, $this->su_initiator_contact_id, $this->su_initiator_contact_company_office_id, $this->su_initiator_phone_contact_company_office_phone_number_id, $this->su_initiator_fax_contact_company_office_phone_number_id, $this->su_initiator_contact_mobile_phone_number_id, $this->su_title, $this->su_plan_page_reference, $this->su_statement, $this->tag_ids,$this->created, $this->su_due_date, $this->su_closed_date, $this->submittal_type_id,$this->contracting_entity_id,$this->su_spec_no, $this->submittal_status_id, $this->submittal_priority_id, $this->submittal_distribution_method_id, $this->su_file_manager_file_id, $this->su_cost_code_id, $this->su_creator_contact_id, $this->su_creator_contact_company_office_id, $this->su_creator_phone_contact_company_office_phone_number_id, $this->su_creator_fax_contact_company_office_phone_number_id, $this->su_creator_contact_mobile_phone_number_id, $this->su_recipient_contact_id, $this->su_recipient_contact_company_office_id, $this->su_recipient_phone_contact_company_office_phone_number_id, $this->su_recipient_fax_contact_company_office_phone_number_id, $this->su_recipient_contact_mobile_phone_number_id, $this->su_initiator_contact_id, $this->su_initiator_contact_company_office_id, $this->su_initiator_phone_contact_company_office_phone_number_id, $this->su_initiator_fax_contact_company_office_phone_number_id, $this->su_initiator_contact_mobile_phone_number_id, $this->su_title, $this->su_plan_page_reference, $this->su_statement, $this->tag_ids,$this->created, $this->su_due_date, $this->su_closed_date);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$submittal_id = $db->insertId;
		$db->free_result();

		return $submittal_id;
	}

	// Save: insert ignore

	/**
	 * Find next_su_sequence_number value.
	 *
	 * @param string $database
	 * @param int $project_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findNextSubmittalSequenceNumber($database, $project_id)
	{
		$next_su_sequence_number = 1;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT MAX(su.su_sequence_number) AS 'max_su_sequence_number'
FROM `submittal_registry` su
WHERE su.`project_id` = ?
";
		$arrValues = array($project_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$max_su_sequence_number = $row['max_su_sequence_number'];
			$next_su_sequence_number = $max_su_sequence_number + 1;
		}

		return $next_su_sequence_number;
	}
	// Loaders: Load All Records
	/**
	 * Load all requests_for_information records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllSubmittalsForTaskSummaryApi($database, $project_id, $user_id, $userRole, $projManager, Input $options=null)
	{
		$forceLoadFlag = false;
		$fromCase="`submittals` su";
		$selectCase = "
		su.*
		";
		$arrValues = array();
		$whereConAdd= "su.`project_id` = ?";
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
			self::$_arrAllSubmittals = null;
		}

		$arrAllSubmittals = self::$_arrAllSubmittals;
		if (isset($arrAllSubmittals) && !empty($arrAllSubmittals)) {
			return $arrAllSubmittals;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */
		$db->free_result();
		$sqlOrderBy = "\nORDER BY";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubmittal = new Submittal($database);
			$sqlOrderByColumns = $tmpSubmittal->constructSqlOrderByColumns($arrOrderByAttributes);

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
			INNER JOIN `submittals` as su
				ON su.`su_recipient_contact_id` = c.`id` 
			";
			$arrValues[] = $user_id;
			$selectCase = "
			su.*,
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
				$whereConAdd .= " AND date(su.`su_due_date`) >= ? AND date(su.`su_due_date`) <= ? AND ( su.`su_closed_date` IS NULL )";
				$arrValues[] = $mindueDate;
				$arrValues[] = $maxDueDate;
				$sqlOrderBy .= $sqlOrderBy != "\nORDER BY" ? ',' : '';
				$sqlOrderBy .= ' su.`su_due_date` IS NULL ASC, su.`su_due_date` ASC';
				break;
				// 7 - 15 days without completed
				case 2:
				$mindueDate = date('Y-m-d', strtotime('+8 days'));
				$maxDueDate	= date('Y-m-d', strtotime('+15 days'));
				$compDate = '0000-00-00 00:00:00';
				$whereConAdd .= " AND date(su.`su_due_date`) > ? AND date(su.`su_due_date`) <= ? AND (  su.`su_closed_date` IS NULL )";
				$arrValues[] = $mindueDate;
				$arrValues[] = $maxDueDate;
				$sqlOrderBy .= $sqlOrderBy != "\nORDER BY" ? ',' : '';
				$sqlOrderBy .= ' su.`su_due_date` IS NULL ASC, su.`su_due_date` ASC';
				break;
				// overdue without completed
				case 3:
				$mindueDate = date('Y-m-d');
				$maxDueDate	= date('Y-m-d', strtotime('+0 days'));
				$compDate = '0000-00-00 00:00:00';
				$whereConAdd .= " AND date(su.`su_due_date`) < ? AND (  su.`su_closed_date` IS NULL )";
				$arrValues[] = $mindueDate;
				$sqlOrderBy .= $sqlOrderBy != "\nORDER BY" ? ',' : '';
				$sqlOrderBy .= ' su.`su_due_date` IS NULL ASC, su.`su_due_date` ASC';
				break;
				// TBD without completed
				case 4:
				$mindueDate = '0000-00-00 00:00:00';
				$compDate = '0000-00-00 00:00:00';
				$whereConAdd .= " AND ( su.`su_due_date` IS NULL OR su.`su_due_date` = ? ) AND ( su.`su_closed_date` IS NULL )";
				$arrValues[] = $mindueDate;
				$sqlOrderBy .= $sqlOrderBy != "\nORDER BY" ? ',' : '';
				$sqlOrderBy .= ' su.`su_due_date` IS NULL ASC, su.`su_due_date` ASC';
				break;
				// completed
				case 5:
				$compDate = '0000-00-00 00:00:00';
				if ($filter_completed_date) {
					$whereConAdd .= " AND date(su.`su_closed_date`) = ? ";
					$arrValues[] = $filter_completed_date;
				} else {
					$whereConAdd .= " AND ( su.`su_closed_date` IS NOT NULL  )";
				}
				$sqlOrderBy .= $sqlOrderBy != "\nORDER BY" ? ',' : '';
				$sqlOrderBy .= ' su.`su_closed_date` DESC';
				break;
				// all without completed
				default:
				$compDate = '0000-00-00 00:00:00';
				$whereConAdd .= " AND ( su.`su_closed_date` IS NULL )";
				$sqlOrderBy .= $sqlOrderBy != "\nORDER BY" ? ',' : '';
				$sqlOrderBy .= ' su.`su_due_date` IS NULL ASC, su.`su_due_date` ASC';
				break;
			}
		}
		// return type count
		$returnType = $options->returnType;
		if($returnType == 'Count') {
			$selectCase = "count(su.`id`) as total";
		}

		if($returnType != 'Count' && !$userBased) {
			$fromCase = "
			`contacts` as c
			INNER JOIN `submittals` as su
				ON su.`su_recipient_contact_id` = c.`id` 
			";
			$selectCase = "
			su.*,
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
		// print_r($arrValues);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrAllSubmittals = array();
		if($returnType == '') {
			while ($row = $db->fetch()) {
				$submittal_id = $row['id'];
				$submittal = self::instantiateOrm($database, 'Submittal', $row, null, $submittal_id);
				if (isset($row['su_recipient_contact_id'])) {
					$su_recipient_contact_id = $row['su_recipient_contact_id'];
					$row['c__id'] = $su_recipient_contact_id;
					$suRecipientContact = self::instantiateOrm($database, 'Contact', $row, null, $su_recipient_contact_id, 'c__');
					/* @var $suRecipientContact Contact */
					$suRecipientContact->convertPropertiesToData();
					$recipient = array($suRecipientContact->getContactFullName());
				} else {
					$suRecipientContact = false;
					$recipient = null;
				}
				/* @var $submittal submittal */
				$arrAllSubmittals[$submittal_id]['item_title'] = $submittal->su_title;
				$arrAllSubmittals[$submittal_id]['item_id'] = $submittal->submittal_id;
				// due date convert
				if ($submittal->su_due_date != '0000-00-00' && $submittal->su_due_date != Null) {
					$arrAllSubmittals[$submittal_id]['item_due_date'] = date('m/d/Y', strtotime($submittal->su_due_date));
				} else {
					$arrAllSubmittals[$submittal_id]['item_due_date'] = '-';
				}
				// closed date convert
				if ($submittal->su_closed_date != '0000-00-00' && $submittal->su_closed_date != Null) {
					$arrAllSubmittals[$submittal_id]['item_completed_date'] = date('m/d/Y', strtotime($submittal->su_closed_date));
				} else {
					$arrAllSubmittals[$submittal_id]['item_completed_date'] = '-';
				}
				if (!$userBased) {
					$arrAllSubmittals[$submittal_id]['item_assignees'] = $recipient;
				} else {
					$arrAllSubmittals[$submittal_id]['item_assignees'] = null;
				}
				// check date format type
				$date_format_type = 0;
				if ($arrAllSubmittals[$submittal_id]['item_due_date'] != '-') {
					$due_date_str = strtotime(date('Y-m-d',strtotime($arrAllSubmittals[$submittal_id]['item_due_date'])));
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
				$arrAllSubmittals[$submittal_id]['date_format_type'] = $date_format_type;
			}
		} else {
			$row = $db->fetch();
			return $row;
		}
		$db->free_result();

		self::$_arrAllSubmittals = $arrAllSubmittals;

		return $arrAllSubmittals;
	}
	public static function submittalProject($database,$submittal_id)
	{
			$db = DBI::getInstance($database);
		    $query = "SELECT p.project_name, uc.company, su.* 
FROM `submittals` su
INNER JOIN `projects` p ON `p`.`id` = su.`project_id`
Inner Join `user_companies` uc ON uc.id = `p`.`user_company_id`
WHERE su.id= ?
";

		$arrValues = array($submittal_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		return $row;


	}

// submittals array for task summary

public static function loadDiscussionItemsByProjectUserId($database, $project_id, $user_id,$userRole, $projManager, Input $options=null){

		$project_id = (int) $project_id;
		$user_id = (int) $user_id;

		$db = DBI::getInstance($database);

		$sqlOrderBy = "\nORDER BY su.`id` DESC";
		if(!empty($options['sort_task'])){
			$sqlOrderBy = $options['sort_task'];
		}

		$groupby = 'GROUP BY sunot.`id`';
		$sqlcond = array();

		if(!empty($userRole) && !empty($projManager)){
			$sqlcond[] = "su.`project_id` = ?";
			$arrValues = array($project_id);
		}else if(!empty($userRole) && ($userRole =='user' || $userRole == 'admin')){
			$sqlcond[] = "su.`project_id` = ? ";

			$sqlcond[] = "( 
								`su`.`su_recipient_contact_id` = ? 
							OR 
								`su`.`id` IN (
									SELECT `subn`.`submittal_id` 
								FROM `submittal_notifications` `subn` 
									INNER JOIN `submittal_recipients` `subr` 
								ON 	`subn`.`id` = `subr`.`submittal_notification_id` 
									WHERE `subr`.`su_additional_recipient_contact_id` = ? AND `subr`.`smtp_recipient_header_type` = ? 
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
				$sqlcond[] = "su.`su_title` LIKE ?";
				$arrValues[] =  '%'.$options['conditions']['task'].'%';
			}

			if(!empty($options['conditions']['due_date'])){
				$sqlcond[] = "su.`su_due_date` = ?";
				$due_date = DateTime::createFromFormat("m/d/Y" , $options['conditions']['due_date']);
				$arrValues[] =  $due_date->format('Y-m-d');
			}

			if(!empty($options['conditions']['discussion'])){
				$sqlcond[] = "su.`su_statement` LIKE ?";
				$arrValues[] =  '%'.$options['conditions']['discussion'].'%';
			}

			if(!empty($options['conditions']['complete_date']) && $options['conditions']['complete_date'] =='uncomplete'){
				$sqlcond[] = "su.`submittal_status_id` IN (2,3)";
			}else{
				$sqlcond[] = "su.`submittal_status_id` IN (4,5,7)";
			}

		}else{
			$sqlcond[] = "su.`submittal_status_id` IN (4,5,7)";
		}

		if(!empty($sqlcond)){
			$sqlcond = implode(' AND ', $sqlcond);
		}

	 $query =
"
SELECT su.*,GROUP_CONCAT(con.`id`) as ac_id
FROM `submittals` su
INNER JOIN `submittal_notifications` sunot ON sunot.`submittal_id` = su.`id`
INNER JOIN `submittal_recipients` surl ON surl.`submittal_notification_id` = sunot.`id`
INNER JOIN `contacts` con ON `surl`.su_additional_recipient_contact_id = `con`.id 
WHERE {$sqlcond} AND surl.`smtp_recipient_header_type` = 'To' {$groupby} {$sqlOrderBy}
";

// print_r($arrValues);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrDiscussionItemsByMeetingId = array();
		while($row = $db->fetch()){
			$arrDiscussionItemsByMeetingId[] = $row;
		}
		$db->free_result();
		return $arrDiscussionItemsByMeetingId;
	}

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all submittals records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllOpenSubmittalsByOpenStatusAndProjectId($database, $project_id, $submittals_status, Input $options=null)
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
			self::$_arrAllSubmittals = null;
		}

		$arrAllSubmittals = self::$_arrAllSubmittals;
		if (isset($arrAllSubmittals) && !empty($arrAllSubmittals)) {
			return $arrAllSubmittals;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubmittal = new Submittal($database);
			$sqlOrderByColumns = $tmpSubmittal->constructSqlOrderByColumns($arrOrderByAttributes);

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
	su.*
FROM `submittals` su
INNER JOIN submittal_statuses AS sus ON su.`submittal_status_id` = sus.`id` 
WHERE sus.`submittal_status`= ? and su.`project_id` = ?
{$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array($submittals_status, $project_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrAllSubmittals = array();
		while ($row = $db->fetch()) {
			$submittal_id = $row['id'];
			$submittal_title = $row['su_title'];
			// $submittal = self::instantiateOrm($database, 'Submittal', $row, null, $submittal_id);
			/* @var $submittal Submittal */
			$arrAllSubmittals[$submittal_id]['id'] = $submittal_id;
			$arrAllSubmittals[$submittal_id]['name'] = $submittal_title;
			$arrAllSubmittals[$submittal_id]['checked'] = false;
		}

		$db->free_result();

		// self::$_arrAllSubmittals = $arrAllSubmittals;

		return $arrAllSubmittals;
	}
	public static function getpreviousrecpientList($database,$project_id){

		$db = DBI::getInstance($database);
		$query =" SELECT id from submittals where project_id =? and su_sequence_number =( SELECT max(su_sequence_number) as max FROM `submittals` WHERE project_id =? )";
		$arrValues = array($project_id,$project_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$submittal_id =$row['id'];
		$db->free_result();
		return $submittal_id;

	}
	 

}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

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
 * SubmittalDraft.
 *
 * @category   Framework
 * @package    SubmittalDraft
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class SubmittalDraft extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'SubmittalDraft';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'submittal_drafts';

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
		'unique_submittal_draft_via_primary_key' => array(
			'submittal_draft_id' => 'int'
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
		'id' => 'submittal_draft_id',

		'project_id' => 'project_id',
		'su_spec_no' =>'su_spec_no',
		'submittal_type_id' => 'submittal_type_id',
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
		'tag_ids' => 'tag_ids',
		'su_due_date' => 'su_due_date'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $submittal_draft_id;

	public $project_id;
	public $su_spec_no;
	public $submittal_type_id;
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
	public $su_due_date;

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
	protected static $_arrSubmittalDraftsByProjectId;
	protected static $_arrSubmittalDraftsBySubmittalTypeId;
	protected static $_arrSubmittalDraftsBySubmittalPriorityId;
	protected static $_arrSubmittalDraftsBySubmittalDistributionMethodId;
	protected static $_arrSubmittalDraftsBySuFileManagerFileId;
	protected static $_arrSubmittalDraftsBySuCostCodeId;
	protected static $_arrSubmittalDraftsBySuCreatorContactId;
	protected static $_arrSubmittalDraftsBySuCreatorContactCompanyOfficeId;
	protected static $_arrSubmittalDraftsBySuCreatorPhoneContactCompanyOfficePhoneNumberId;
	protected static $_arrSubmittalDraftsBySuCreatorFaxContactCompanyOfficePhoneNumberId;
	protected static $_arrSubmittalDraftsBySuCreatorContactMobilePhoneNumberId;
	protected static $_arrSubmittalDraftsBySuRecipientContactId;
	protected static $_arrSubmittalDraftsBySuRecipientContactCompanyOfficeId;
	protected static $_arrSubmittalDraftsBySuRecipientPhoneContactCompanyOfficePhoneNumberId;
	protected static $_arrSubmittalDraftsBySuRecipientFaxContactCompanyOfficePhoneNumberId;
	protected static $_arrSubmittalDraftsBySuRecipientContactMobilePhoneNumberId;
	protected static $_arrSubmittalDraftsBySuInitiatorContactId;
	protected static $_arrSubmittalDraftsBySuInitiatorContactCompanyOfficeId;
	protected static $_arrSubmittalDraftsBySuInitiatorPhoneContactCompanyOfficePhoneNumberId;
	protected static $_arrSubmittalDraftsBySuInitiatorFaxContactCompanyOfficePhoneNumberId;
	protected static $_arrSubmittalDraftsBySuInitiatorContactMobilePhoneNumberId;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllSubmittalDrafts;

	// Foreign Key Objects
	private $_project;
	private $_submittalType;
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
	public function __construct($database, $table='submittal_drafts')
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
	public static function getArrSubmittalDraftsByProjectId()
	{
		if (isset(self::$_arrSubmittalDraftsByProjectId)) {
			return self::$_arrSubmittalDraftsByProjectId;
		} else {
			return null;
		}
	}

	public static function setArrSubmittalDraftsByProjectId($arrSubmittalDraftsByProjectId)
	{
		self::$_arrSubmittalDraftsByProjectId = $arrSubmittalDraftsByProjectId;
	}

	public static function getArrSubmittalDraftsBySubmittalTypeId()
	{
		if (isset(self::$_arrSubmittalDraftsBySubmittalTypeId)) {
			return self::$_arrSubmittalDraftsBySubmittalTypeId;
		} else {
			return null;
		}
	}

	public static function setArrSubmittalDraftsBySubmittalTypeId($arrSubmittalDraftsBySubmittalTypeId)
	{
		self::$_arrSubmittalDraftsBySubmittalTypeId = $arrSubmittalDraftsBySubmittalTypeId;
	}

	public static function getArrSubmittalDraftsBySubmittalPriorityId()
	{
		if (isset(self::$_arrSubmittalDraftsBySubmittalPriorityId)) {
			return self::$_arrSubmittalDraftsBySubmittalPriorityId;
		} else {
			return null;
		}
	}

	public static function setArrSubmittalDraftsBySubmittalPriorityId($arrSubmittalDraftsBySubmittalPriorityId)
	{
		self::$_arrSubmittalDraftsBySubmittalPriorityId = $arrSubmittalDraftsBySubmittalPriorityId;
	}

	public static function getArrSubmittalDraftsBySubmittalDistributionMethodId()
	{
		if (isset(self::$_arrSubmittalDraftsBySubmittalDistributionMethodId)) {
			return self::$_arrSubmittalDraftsBySubmittalDistributionMethodId;
		} else {
			return null;
		}
	}

	public static function setArrSubmittalDraftsBySubmittalDistributionMethodId($arrSubmittalDraftsBySubmittalDistributionMethodId)
	{
		self::$_arrSubmittalDraftsBySubmittalDistributionMethodId = $arrSubmittalDraftsBySubmittalDistributionMethodId;
	}

	public static function getArrSubmittalDraftsBySuFileManagerFileId()
	{
		if (isset(self::$_arrSubmittalDraftsBySuFileManagerFileId)) {
			return self::$_arrSubmittalDraftsBySuFileManagerFileId;
		} else {
			return null;
		}
	}

	public static function setArrSubmittalDraftsBySuFileManagerFileId($arrSubmittalDraftsBySuFileManagerFileId)
	{
		self::$_arrSubmittalDraftsBySuFileManagerFileId = $arrSubmittalDraftsBySuFileManagerFileId;
	}

	public static function getArrSubmittalDraftsBySuCostCodeId()
	{
		if (isset(self::$_arrSubmittalDraftsBySuCostCodeId)) {
			return self::$_arrSubmittalDraftsBySuCostCodeId;
		} else {
			return null;
		}
	}

	public static function setArrSubmittalDraftsBySuCostCodeId($arrSubmittalDraftsBySuCostCodeId)
	{
		self::$_arrSubmittalDraftsBySuCostCodeId = $arrSubmittalDraftsBySuCostCodeId;
	}

	public static function getArrSubmittalDraftsBySuCreatorContactId()
	{
		if (isset(self::$_arrSubmittalDraftsBySuCreatorContactId)) {
			return self::$_arrSubmittalDraftsBySuCreatorContactId;
		} else {
			return null;
		}
	}

	public static function setArrSubmittalDraftsBySuCreatorContactId($arrSubmittalDraftsBySuCreatorContactId)
	{
		self::$_arrSubmittalDraftsBySuCreatorContactId = $arrSubmittalDraftsBySuCreatorContactId;
	}

	public static function getArrSubmittalDraftsBySuCreatorContactCompanyOfficeId()
	{
		if (isset(self::$_arrSubmittalDraftsBySuCreatorContactCompanyOfficeId)) {
			return self::$_arrSubmittalDraftsBySuCreatorContactCompanyOfficeId;
		} else {
			return null;
		}
	}

	public static function setArrSubmittalDraftsBySuCreatorContactCompanyOfficeId($arrSubmittalDraftsBySuCreatorContactCompanyOfficeId)
	{
		self::$_arrSubmittalDraftsBySuCreatorContactCompanyOfficeId = $arrSubmittalDraftsBySuCreatorContactCompanyOfficeId;
	}

	public static function getArrSubmittalDraftsBySuCreatorPhoneContactCompanyOfficePhoneNumberId()
	{
		if (isset(self::$_arrSubmittalDraftsBySuCreatorPhoneContactCompanyOfficePhoneNumberId)) {
			return self::$_arrSubmittalDraftsBySuCreatorPhoneContactCompanyOfficePhoneNumberId;
		} else {
			return null;
		}
	}

	public static function setArrSubmittalDraftsBySuCreatorPhoneContactCompanyOfficePhoneNumberId($arrSubmittalDraftsBySuCreatorPhoneContactCompanyOfficePhoneNumberId)
	{
		self::$_arrSubmittalDraftsBySuCreatorPhoneContactCompanyOfficePhoneNumberId = $arrSubmittalDraftsBySuCreatorPhoneContactCompanyOfficePhoneNumberId;
	}

	public static function getArrSubmittalDraftsBySuCreatorFaxContactCompanyOfficePhoneNumberId()
	{
		if (isset(self::$_arrSubmittalDraftsBySuCreatorFaxContactCompanyOfficePhoneNumberId)) {
			return self::$_arrSubmittalDraftsBySuCreatorFaxContactCompanyOfficePhoneNumberId;
		} else {
			return null;
		}
	}

	public static function setArrSubmittalDraftsBySuCreatorFaxContactCompanyOfficePhoneNumberId($arrSubmittalDraftsBySuCreatorFaxContactCompanyOfficePhoneNumberId)
	{
		self::$_arrSubmittalDraftsBySuCreatorFaxContactCompanyOfficePhoneNumberId = $arrSubmittalDraftsBySuCreatorFaxContactCompanyOfficePhoneNumberId;
	}

	public static function getArrSubmittalDraftsBySuCreatorContactMobilePhoneNumberId()
	{
		if (isset(self::$_arrSubmittalDraftsBySuCreatorContactMobilePhoneNumberId)) {
			return self::$_arrSubmittalDraftsBySuCreatorContactMobilePhoneNumberId;
		} else {
			return null;
		}
	}

	public static function setArrSubmittalDraftsBySuCreatorContactMobilePhoneNumberId($arrSubmittalDraftsBySuCreatorContactMobilePhoneNumberId)
	{
		self::$_arrSubmittalDraftsBySuCreatorContactMobilePhoneNumberId = $arrSubmittalDraftsBySuCreatorContactMobilePhoneNumberId;
	}

	public static function getArrSubmittalDraftsBySuRecipientContactId()
	{
		if (isset(self::$_arrSubmittalDraftsBySuRecipientContactId)) {
			return self::$_arrSubmittalDraftsBySuRecipientContactId;
		} else {
			return null;
		}
	}

	public static function setArrSubmittalDraftsBySuRecipientContactId($arrSubmittalDraftsBySuRecipientContactId)
	{
		self::$_arrSubmittalDraftsBySuRecipientContactId = $arrSubmittalDraftsBySuRecipientContactId;
	}

	public static function getArrSubmittalDraftsBySuRecipientContactCompanyOfficeId()
	{
		if (isset(self::$_arrSubmittalDraftsBySuRecipientContactCompanyOfficeId)) {
			return self::$_arrSubmittalDraftsBySuRecipientContactCompanyOfficeId;
		} else {
			return null;
		}
	}

	public static function setArrSubmittalDraftsBySuRecipientContactCompanyOfficeId($arrSubmittalDraftsBySuRecipientContactCompanyOfficeId)
	{
		self::$_arrSubmittalDraftsBySuRecipientContactCompanyOfficeId = $arrSubmittalDraftsBySuRecipientContactCompanyOfficeId;
	}

	public static function getArrSubmittalDraftsBySuRecipientPhoneContactCompanyOfficePhoneNumberId()
	{
		if (isset(self::$_arrSubmittalDraftsBySuRecipientPhoneContactCompanyOfficePhoneNumberId)) {
			return self::$_arrSubmittalDraftsBySuRecipientPhoneContactCompanyOfficePhoneNumberId;
		} else {
			return null;
		}
	}

	public static function setArrSubmittalDraftsBySuRecipientPhoneContactCompanyOfficePhoneNumberId($arrSubmittalDraftsBySuRecipientPhoneContactCompanyOfficePhoneNumberId)
	{
		self::$_arrSubmittalDraftsBySuRecipientPhoneContactCompanyOfficePhoneNumberId = $arrSubmittalDraftsBySuRecipientPhoneContactCompanyOfficePhoneNumberId;
	}

	public static function getArrSubmittalDraftsBySuRecipientFaxContactCompanyOfficePhoneNumberId()
	{
		if (isset(self::$_arrSubmittalDraftsBySuRecipientFaxContactCompanyOfficePhoneNumberId)) {
			return self::$_arrSubmittalDraftsBySuRecipientFaxContactCompanyOfficePhoneNumberId;
		} else {
			return null;
		}
	}

	public static function setArrSubmittalDraftsBySuRecipientFaxContactCompanyOfficePhoneNumberId($arrSubmittalDraftsBySuRecipientFaxContactCompanyOfficePhoneNumberId)
	{
		self::$_arrSubmittalDraftsBySuRecipientFaxContactCompanyOfficePhoneNumberId = $arrSubmittalDraftsBySuRecipientFaxContactCompanyOfficePhoneNumberId;
	}

	public static function getArrSubmittalDraftsBySuRecipientContactMobilePhoneNumberId()
	{
		if (isset(self::$_arrSubmittalDraftsBySuRecipientContactMobilePhoneNumberId)) {
			return self::$_arrSubmittalDraftsBySuRecipientContactMobilePhoneNumberId;
		} else {
			return null;
		}
	}

	public static function setArrSubmittalDraftsBySuRecipientContactMobilePhoneNumberId($arrSubmittalDraftsBySuRecipientContactMobilePhoneNumberId)
	{
		self::$_arrSubmittalDraftsBySuRecipientContactMobilePhoneNumberId = $arrSubmittalDraftsBySuRecipientContactMobilePhoneNumberId;
	}

	public static function getArrSubmittalDraftsBySuInitiatorContactId()
	{
		if (isset(self::$_arrSubmittalDraftsBySuInitiatorContactId)) {
			return self::$_arrSubmittalDraftsBySuInitiatorContactId;
		} else {
			return null;
		}
	}

	public static function setArrSubmittalDraftsBySuInitiatorContactId($arrSubmittalDraftsBySuInitiatorContactId)
	{
		self::$_arrSubmittalDraftsBySuInitiatorContactId = $arrSubmittalDraftsBySuInitiatorContactId;
	}

	public static function getArrSubmittalDraftsBySuInitiatorContactCompanyOfficeId()
	{
		if (isset(self::$_arrSubmittalDraftsBySuInitiatorContactCompanyOfficeId)) {
			return self::$_arrSubmittalDraftsBySuInitiatorContactCompanyOfficeId;
		} else {
			return null;
		}
	}

	public static function setArrSubmittalDraftsBySuInitiatorContactCompanyOfficeId($arrSubmittalDraftsBySuInitiatorContactCompanyOfficeId)
	{
		self::$_arrSubmittalDraftsBySuInitiatorContactCompanyOfficeId = $arrSubmittalDraftsBySuInitiatorContactCompanyOfficeId;
	}

	public static function getArrSubmittalDraftsBySuInitiatorPhoneContactCompanyOfficePhoneNumberId()
	{
		if (isset(self::$_arrSubmittalDraftsBySuInitiatorPhoneContactCompanyOfficePhoneNumberId)) {
			return self::$_arrSubmittalDraftsBySuInitiatorPhoneContactCompanyOfficePhoneNumberId;
		} else {
			return null;
		}
	}

	public static function setArrSubmittalDraftsBySuInitiatorPhoneContactCompanyOfficePhoneNumberId($arrSubmittalDraftsBySuInitiatorPhoneContactCompanyOfficePhoneNumberId)
	{
		self::$_arrSubmittalDraftsBySuInitiatorPhoneContactCompanyOfficePhoneNumberId = $arrSubmittalDraftsBySuInitiatorPhoneContactCompanyOfficePhoneNumberId;
	}

	public static function getArrSubmittalDraftsBySuInitiatorFaxContactCompanyOfficePhoneNumberId()
	{
		if (isset(self::$_arrSubmittalDraftsBySuInitiatorFaxContactCompanyOfficePhoneNumberId)) {
			return self::$_arrSubmittalDraftsBySuInitiatorFaxContactCompanyOfficePhoneNumberId;
		} else {
			return null;
		}
	}

	public static function setArrSubmittalDraftsBySuInitiatorFaxContactCompanyOfficePhoneNumberId($arrSubmittalDraftsBySuInitiatorFaxContactCompanyOfficePhoneNumberId)
	{
		self::$_arrSubmittalDraftsBySuInitiatorFaxContactCompanyOfficePhoneNumberId = $arrSubmittalDraftsBySuInitiatorFaxContactCompanyOfficePhoneNumberId;
	}

	public static function getArrSubmittalDraftsBySuInitiatorContactMobilePhoneNumberId()
	{
		if (isset(self::$_arrSubmittalDraftsBySuInitiatorContactMobilePhoneNumberId)) {
			return self::$_arrSubmittalDraftsBySuInitiatorContactMobilePhoneNumberId;
		} else {
			return null;
		}
	}

	public static function setArrSubmittalDraftsBySuInitiatorContactMobilePhoneNumberId($arrSubmittalDraftsBySuInitiatorContactMobilePhoneNumberId)
	{
		self::$_arrSubmittalDraftsBySuInitiatorContactMobilePhoneNumberId = $arrSubmittalDraftsBySuInitiatorContactMobilePhoneNumberId;
	}

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllSubmittalDrafts()
	{
		if (isset(self::$_arrAllSubmittalDrafts)) {
			return self::$_arrAllSubmittalDrafts;
		} else {
			return null;
		}
	}

	public static function setArrAllSubmittalDrafts($arrAllSubmittalDrafts)
	{
		self::$_arrAllSubmittalDrafts = $arrAllSubmittalDrafts;
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
	 * @param int $submittal_draft_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findById($database, $submittal_draft_id,$table='submittal_drafts', $module='SubmittalDraft')
	{
		$submittalDraft = parent::findById($database, $submittal_draft_id, $table, $module);

		return $submittalDraft;
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Similar to FindById, but with SQL as starter code for more complex joins.
	 *
	 * @param string $database
	 * @param int $submittal_draft_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findSubmittalDraftByIdExtended($database, $submittal_draft_id)
	{
		$submittal_draft_id = (int) $submittal_draft_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	sud_fk_p.`id` AS 'sud_fk_p__project_id',
	sud_fk_p.`project_type_id` AS 'sud_fk_p__project_type_id',
	sud_fk_p.`user_company_id` AS 'sud_fk_p__user_company_id',
	sud_fk_p.`user_custom_project_id` AS 'sud_fk_p__user_custom_project_id',
	sud_fk_p.`project_name` AS 'sud_fk_p__project_name',
	sud_fk_p.`project_owner_name` AS 'sud_fk_p__project_owner_name',
	sud_fk_p.`latitude` AS 'sud_fk_p__latitude',
	sud_fk_p.`longitude` AS 'sud_fk_p__longitude',
	sud_fk_p.`address_line_1` AS 'sud_fk_p__address_line_1',
	sud_fk_p.`address_line_2` AS 'sud_fk_p__address_line_2',
	sud_fk_p.`address_line_3` AS 'sud_fk_p__address_line_3',
	sud_fk_p.`address_line_4` AS 'sud_fk_p__address_line_4',
	sud_fk_p.`address_city` AS 'sud_fk_p__address_city',
	sud_fk_p.`address_county` AS 'sud_fk_p__address_county',
	sud_fk_p.`address_state_or_region` AS 'sud_fk_p__address_state_or_region',
	sud_fk_p.`address_postal_code` AS 'sud_fk_p__address_postal_code',
	sud_fk_p.`address_postal_code_extension` AS 'sud_fk_p__address_postal_code_extension',
	sud_fk_p.`address_country` AS 'sud_fk_p__address_country',
	sud_fk_p.`building_count` AS 'sud_fk_p__building_count',
	sud_fk_p.`unit_count` AS 'sud_fk_p__unit_count',
	sud_fk_p.`gross_square_footage` AS 'sud_fk_p__gross_square_footage',
	sud_fk_p.`net_rentable_square_footage` AS 'sud_fk_p__net_rentable_square_footage',
	sud_fk_p.`is_active_flag` AS 'sud_fk_p__is_active_flag',
	sud_fk_p.`public_plans_flag` AS 'sud_fk_p__public_plans_flag',
	sud_fk_p.`prevailing_wage_flag` AS 'sud_fk_p__prevailing_wage_flag',
	sud_fk_p.`city_business_license_required_flag` AS 'sud_fk_p__city_business_license_required_flag',
	sud_fk_p.`is_internal_flag` AS 'sud_fk_p__is_internal_flag',
	sud_fk_p.`project_contract_date` AS 'sud_fk_p__project_contract_date',
	sud_fk_p.`project_start_date` AS 'sud_fk_p__project_start_date',
	sud_fk_p.`project_completed_date` AS 'sud_fk_p__project_completed_date',
	sud_fk_p.`sort_order` AS 'sud_fk_p__sort_order',

	sud_fk_sut.`id` AS 'sud_fk_sut__submittal_type_id',
	sud_fk_sut.`submittal_type` AS 'sud_fk_sut__submittal_type',
	sud_fk_sut.`disabled_flag` AS 'sud_fk_sut__disabled_flag',

	sud_fk_sup.`id` AS 'sud_fk_sup__submittal_priority_id',
	sud_fk_sup.`submittal_priority` AS 'sud_fk_sup__submittal_priority',
	sud_fk_sup.`disabled_flag` AS 'sud_fk_sup__disabled_flag',

	sud_fk_sudm.`id` AS 'sud_fk_sudm__submittal_distribution_method_id',
	sud_fk_sudm.`submittal_distribution_method` AS 'sud_fk_sudm__submittal_distribution_method',
	sud_fk_sudm.`disabled_flag` AS 'sud_fk_sudm__disabled_flag',

	sud_fk_fmfiles.`id` AS 'sud_fk_fmfiles__file_manager_file_id',
	sud_fk_fmfiles.`user_company_id` AS 'sud_fk_fmfiles__user_company_id',
	sud_fk_fmfiles.`contact_id` AS 'sud_fk_fmfiles__contact_id',
	sud_fk_fmfiles.`project_id` AS 'sud_fk_fmfiles__project_id',
	sud_fk_fmfiles.`file_manager_folder_id` AS 'sud_fk_fmfiles__file_manager_folder_id',
	sud_fk_fmfiles.`file_location_id` AS 'sud_fk_fmfiles__file_location_id',
	sud_fk_fmfiles.`virtual_file_name` AS 'sud_fk_fmfiles__virtual_file_name',
	sud_fk_fmfiles.`version_number` AS 'sud_fk_fmfiles__version_number',
	sud_fk_fmfiles.`virtual_file_name_sha1` AS 'sud_fk_fmfiles__virtual_file_name_sha1',
	sud_fk_fmfiles.`virtual_file_mime_type` AS 'sud_fk_fmfiles__virtual_file_mime_type',
	sud_fk_fmfiles.`modified` AS 'sud_fk_fmfiles__modified',
	sud_fk_fmfiles.`created` AS 'sud_fk_fmfiles__created',
	sud_fk_fmfiles.`deleted_flag` AS 'sud_fk_fmfiles__deleted_flag',
	sud_fk_fmfiles.`directly_deleted_flag` AS 'sud_fk_fmfiles__directly_deleted_flag',

	sud_fk_codes.`id` AS 'sud_fk_codes__cost_code_id',
	sud_fk_codes.`cost_code_division_id` AS 'sud_fk_codes__cost_code_division_id',
	sud_fk_codes.`cost_code` AS 'sud_fk_codes__cost_code',
	sud_fk_codes.`cost_code_description` AS 'sud_fk_codes__cost_code_description',
	sud_fk_codes.`cost_code_description_abbreviation` AS 'sud_fk_codes__cost_code_description_abbreviation',
	sud_fk_codes.`sort_order` AS 'sud_fk_codes__sort_order',
	sud_fk_codes.`disabled_flag` AS 'sud_fk_codes__disabled_flag',

	sud_fk_creator_c.`id` AS 'sud_fk_creator_c__contact_id',
	sud_fk_creator_c.`user_company_id` AS 'sud_fk_creator_c__user_company_id',
	sud_fk_creator_c.`user_id` AS 'sud_fk_creator_c__user_id',
	sud_fk_creator_c.`contact_company_id` AS 'sud_fk_creator_c__contact_company_id',
	sud_fk_creator_c.`email` AS 'sud_fk_creator_c__email',
	sud_fk_creator_c.`name_prefix` AS 'sud_fk_creator_c__name_prefix',
	sud_fk_creator_c.`first_name` AS 'sud_fk_creator_c__first_name',
	sud_fk_creator_c.`additional_name` AS 'sud_fk_creator_c__additional_name',
	sud_fk_creator_c.`middle_name` AS 'sud_fk_creator_c__middle_name',
	sud_fk_creator_c.`last_name` AS 'sud_fk_creator_c__last_name',
	sud_fk_creator_c.`name_suffix` AS 'sud_fk_creator_c__name_suffix',
	sud_fk_creator_c.`title` AS 'sud_fk_creator_c__title',
	sud_fk_creator_c.`vendor_flag` AS 'sud_fk_creator_c__vendor_flag',

	sud_fk_creator_cco.`id` AS 'sud_fk_creator_cco__contact_company_office_id',
	sud_fk_creator_cco.`contact_company_id` AS 'sud_fk_creator_cco__contact_company_id',
	sud_fk_creator_cco.`office_nickname` AS 'sud_fk_creator_cco__office_nickname',
	sud_fk_creator_cco.`address_line_1` AS 'sud_fk_creator_cco__address_line_1',
	sud_fk_creator_cco.`address_line_2` AS 'sud_fk_creator_cco__address_line_2',
	sud_fk_creator_cco.`address_line_3` AS 'sud_fk_creator_cco__address_line_3',
	sud_fk_creator_cco.`address_line_4` AS 'sud_fk_creator_cco__address_line_4',
	sud_fk_creator_cco.`address_city` AS 'sud_fk_creator_cco__address_city',
	sud_fk_creator_cco.`address_county` AS 'sud_fk_creator_cco__address_county',
	sud_fk_creator_cco.`address_state_or_region` AS 'sud_fk_creator_cco__address_state_or_region',
	sud_fk_creator_cco.`address_postal_code` AS 'sud_fk_creator_cco__address_postal_code',
	sud_fk_creator_cco.`address_postal_code_extension` AS 'sud_fk_creator_cco__address_postal_code_extension',
	sud_fk_creator_cco.`address_country` AS 'sud_fk_creator_cco__address_country',
	sud_fk_creator_cco.`head_quarters_flag` AS 'sud_fk_creator_cco__head_quarters_flag',
	sud_fk_creator_cco.`address_validated_by_user_flag` AS 'sud_fk_creator_cco__address_validated_by_user_flag',
	sud_fk_creator_cco.`address_validated_by_web_service_flag` AS 'sud_fk_creator_cco__address_validated_by_web_service_flag',
	sud_fk_creator_cco.`address_validation_by_web_service_error_flag` AS 'sud_fk_creator_cco__address_validation_by_web_service_error_flag',

	sud_fk_creator_phone_ccopn.`id` AS 'sud_fk_creator_phone_ccopn__contact_company_office_phone_number_id',
	sud_fk_creator_phone_ccopn.`contact_company_office_id` AS 'sud_fk_creator_phone_ccopn__contact_company_office_id',
	sud_fk_creator_phone_ccopn.`phone_number_type_id` AS 'sud_fk_creator_phone_ccopn__phone_number_type_id',
	sud_fk_creator_phone_ccopn.`country_code` AS 'sud_fk_creator_phone_ccopn__country_code',
	sud_fk_creator_phone_ccopn.`area_code` AS 'sud_fk_creator_phone_ccopn__area_code',
	sud_fk_creator_phone_ccopn.`prefix` AS 'sud_fk_creator_phone_ccopn__prefix',
	sud_fk_creator_phone_ccopn.`number` AS 'sud_fk_creator_phone_ccopn__number',
	sud_fk_creator_phone_ccopn.`extension` AS 'sud_fk_creator_phone_ccopn__extension',
	sud_fk_creator_phone_ccopn.`itu` AS 'sud_fk_creator_phone_ccopn__itu',

	sud_fk_creator_fax_ccopn.`id` AS 'sud_fk_creator_fax_ccopn__contact_company_office_phone_number_id',
	sud_fk_creator_fax_ccopn.`contact_company_office_id` AS 'sud_fk_creator_fax_ccopn__contact_company_office_id',
	sud_fk_creator_fax_ccopn.`phone_number_type_id` AS 'sud_fk_creator_fax_ccopn__phone_number_type_id',
	sud_fk_creator_fax_ccopn.`country_code` AS 'sud_fk_creator_fax_ccopn__country_code',
	sud_fk_creator_fax_ccopn.`area_code` AS 'sud_fk_creator_fax_ccopn__area_code',
	sud_fk_creator_fax_ccopn.`prefix` AS 'sud_fk_creator_fax_ccopn__prefix',
	sud_fk_creator_fax_ccopn.`number` AS 'sud_fk_creator_fax_ccopn__number',
	sud_fk_creator_fax_ccopn.`extension` AS 'sud_fk_creator_fax_ccopn__extension',
	sud_fk_creator_fax_ccopn.`itu` AS 'sud_fk_creator_fax_ccopn__itu',

	sud_fk_creator_c_mobile_cpn.`id` AS 'sud_fk_creator_c_mobile_cpn__contact_phone_number_id',
	sud_fk_creator_c_mobile_cpn.`contact_id` AS 'sud_fk_creator_c_mobile_cpn__contact_id',
	sud_fk_creator_c_mobile_cpn.`phone_number_type_id` AS 'sud_fk_creator_c_mobile_cpn__phone_number_type_id',
	sud_fk_creator_c_mobile_cpn.`country_code` AS 'sud_fk_creator_c_mobile_cpn__country_code',
	sud_fk_creator_c_mobile_cpn.`area_code` AS 'sud_fk_creator_c_mobile_cpn__area_code',
	sud_fk_creator_c_mobile_cpn.`prefix` AS 'sud_fk_creator_c_mobile_cpn__prefix',
	sud_fk_creator_c_mobile_cpn.`number` AS 'sud_fk_creator_c_mobile_cpn__number',
	sud_fk_creator_c_mobile_cpn.`extension` AS 'sud_fk_creator_c_mobile_cpn__extension',
	sud_fk_creator_c_mobile_cpn.`itu` AS 'sud_fk_creator_c_mobile_cpn__itu',

	sud_fk_recipient_c.`id` AS 'sud_fk_recipient_c__contact_id',
	sud_fk_recipient_c.`user_company_id` AS 'sud_fk_recipient_c__user_company_id',
	sud_fk_recipient_c.`user_id` AS 'sud_fk_recipient_c__user_id',
	sud_fk_recipient_c.`contact_company_id` AS 'sud_fk_recipient_c__contact_company_id',
	sud_fk_recipient_c.`email` AS 'sud_fk_recipient_c__email',
	sud_fk_recipient_c.`name_prefix` AS 'sud_fk_recipient_c__name_prefix',
	sud_fk_recipient_c.`first_name` AS 'sud_fk_recipient_c__first_name',
	sud_fk_recipient_c.`additional_name` AS 'sud_fk_recipient_c__additional_name',
	sud_fk_recipient_c.`middle_name` AS 'sud_fk_recipient_c__middle_name',
	sud_fk_recipient_c.`last_name` AS 'sud_fk_recipient_c__last_name',
	sud_fk_recipient_c.`name_suffix` AS 'sud_fk_recipient_c__name_suffix',
	sud_fk_recipient_c.`title` AS 'sud_fk_recipient_c__title',
	sud_fk_recipient_c.`vendor_flag` AS 'sud_fk_recipient_c__vendor_flag',

	sud_fk_recipient_cco.`id` AS 'sud_fk_recipient_cco__contact_company_office_id',
	sud_fk_recipient_cco.`contact_company_id` AS 'sud_fk_recipient_cco__contact_company_id',
	sud_fk_recipient_cco.`office_nickname` AS 'sud_fk_recipient_cco__office_nickname',
	sud_fk_recipient_cco.`address_line_1` AS 'sud_fk_recipient_cco__address_line_1',
	sud_fk_recipient_cco.`address_line_2` AS 'sud_fk_recipient_cco__address_line_2',
	sud_fk_recipient_cco.`address_line_3` AS 'sud_fk_recipient_cco__address_line_3',
	sud_fk_recipient_cco.`address_line_4` AS 'sud_fk_recipient_cco__address_line_4',
	sud_fk_recipient_cco.`address_city` AS 'sud_fk_recipient_cco__address_city',
	sud_fk_recipient_cco.`address_county` AS 'sud_fk_recipient_cco__address_county',
	sud_fk_recipient_cco.`address_state_or_region` AS 'sud_fk_recipient_cco__address_state_or_region',
	sud_fk_recipient_cco.`address_postal_code` AS 'sud_fk_recipient_cco__address_postal_code',
	sud_fk_recipient_cco.`address_postal_code_extension` AS 'sud_fk_recipient_cco__address_postal_code_extension',
	sud_fk_recipient_cco.`address_country` AS 'sud_fk_recipient_cco__address_country',
	sud_fk_recipient_cco.`head_quarters_flag` AS 'sud_fk_recipient_cco__head_quarters_flag',
	sud_fk_recipient_cco.`address_validated_by_user_flag` AS 'sud_fk_recipient_cco__address_validated_by_user_flag',
	sud_fk_recipient_cco.`address_validated_by_web_service_flag` AS 'sud_fk_recipient_cco__address_validated_by_web_service_flag',
	sud_fk_recipient_cco.`address_validation_by_web_service_error_flag` AS 'sud_fk_recipient_cco__address_validation_by_web_service_error_flag',

	sud_fk_recipient_phone_ccopn.`id` AS 'sud_fk_recipient_phone_ccopn__contact_company_office_phone_number_id',
	sud_fk_recipient_phone_ccopn.`contact_company_office_id` AS 'sud_fk_recipient_phone_ccopn__contact_company_office_id',
	sud_fk_recipient_phone_ccopn.`phone_number_type_id` AS 'sud_fk_recipient_phone_ccopn__phone_number_type_id',
	sud_fk_recipient_phone_ccopn.`country_code` AS 'sud_fk_recipient_phone_ccopn__country_code',
	sud_fk_recipient_phone_ccopn.`area_code` AS 'sud_fk_recipient_phone_ccopn__area_code',
	sud_fk_recipient_phone_ccopn.`prefix` AS 'sud_fk_recipient_phone_ccopn__prefix',
	sud_fk_recipient_phone_ccopn.`number` AS 'sud_fk_recipient_phone_ccopn__number',
	sud_fk_recipient_phone_ccopn.`extension` AS 'sud_fk_recipient_phone_ccopn__extension',
	sud_fk_recipient_phone_ccopn.`itu` AS 'sud_fk_recipient_phone_ccopn__itu',

	sud_fk_recipient_fax_ccopn.`id` AS 'sud_fk_recipient_fax_ccopn__contact_company_office_phone_number_id',
	sud_fk_recipient_fax_ccopn.`contact_company_office_id` AS 'sud_fk_recipient_fax_ccopn__contact_company_office_id',
	sud_fk_recipient_fax_ccopn.`phone_number_type_id` AS 'sud_fk_recipient_fax_ccopn__phone_number_type_id',
	sud_fk_recipient_fax_ccopn.`country_code` AS 'sud_fk_recipient_fax_ccopn__country_code',
	sud_fk_recipient_fax_ccopn.`area_code` AS 'sud_fk_recipient_fax_ccopn__area_code',
	sud_fk_recipient_fax_ccopn.`prefix` AS 'sud_fk_recipient_fax_ccopn__prefix',
	sud_fk_recipient_fax_ccopn.`number` AS 'sud_fk_recipient_fax_ccopn__number',
	sud_fk_recipient_fax_ccopn.`extension` AS 'sud_fk_recipient_fax_ccopn__extension',
	sud_fk_recipient_fax_ccopn.`itu` AS 'sud_fk_recipient_fax_ccopn__itu',

	sud_fk_recipient_c_mobile_cpn.`id` AS 'sud_fk_recipient_c_mobile_cpn__contact_phone_number_id',
	sud_fk_recipient_c_mobile_cpn.`contact_id` AS 'sud_fk_recipient_c_mobile_cpn__contact_id',
	sud_fk_recipient_c_mobile_cpn.`phone_number_type_id` AS 'sud_fk_recipient_c_mobile_cpn__phone_number_type_id',
	sud_fk_recipient_c_mobile_cpn.`country_code` AS 'sud_fk_recipient_c_mobile_cpn__country_code',
	sud_fk_recipient_c_mobile_cpn.`area_code` AS 'sud_fk_recipient_c_mobile_cpn__area_code',
	sud_fk_recipient_c_mobile_cpn.`prefix` AS 'sud_fk_recipient_c_mobile_cpn__prefix',
	sud_fk_recipient_c_mobile_cpn.`number` AS 'sud_fk_recipient_c_mobile_cpn__number',
	sud_fk_recipient_c_mobile_cpn.`extension` AS 'sud_fk_recipient_c_mobile_cpn__extension',
	sud_fk_recipient_c_mobile_cpn.`itu` AS 'sud_fk_recipient_c_mobile_cpn__itu',

	sud_fk_initiator_c.`id` AS 'sud_fk_initiator_c__contact_id',
	sud_fk_initiator_c.`user_company_id` AS 'sud_fk_initiator_c__user_company_id',
	sud_fk_initiator_c.`user_id` AS 'sud_fk_initiator_c__user_id',
	sud_fk_initiator_c.`contact_company_id` AS 'sud_fk_initiator_c__contact_company_id',
	sud_fk_initiator_c.`email` AS 'sud_fk_initiator_c__email',
	sud_fk_initiator_c.`name_prefix` AS 'sud_fk_initiator_c__name_prefix',
	sud_fk_initiator_c.`first_name` AS 'sud_fk_initiator_c__first_name',
	sud_fk_initiator_c.`additional_name` AS 'sud_fk_initiator_c__additional_name',
	sud_fk_initiator_c.`middle_name` AS 'sud_fk_initiator_c__middle_name',
	sud_fk_initiator_c.`last_name` AS 'sud_fk_initiator_c__last_name',
	sud_fk_initiator_c.`name_suffix` AS 'sud_fk_initiator_c__name_suffix',
	sud_fk_initiator_c.`title` AS 'sud_fk_initiator_c__title',
	sud_fk_initiator_c.`vendor_flag` AS 'sud_fk_initiator_c__vendor_flag',

	sud_fk_initiator_cco.`id` AS 'sud_fk_initiator_cco__contact_company_office_id',
	sud_fk_initiator_cco.`contact_company_id` AS 'sud_fk_initiator_cco__contact_company_id',
	sud_fk_initiator_cco.`office_nickname` AS 'sud_fk_initiator_cco__office_nickname',
	sud_fk_initiator_cco.`address_line_1` AS 'sud_fk_initiator_cco__address_line_1',
	sud_fk_initiator_cco.`address_line_2` AS 'sud_fk_initiator_cco__address_line_2',
	sud_fk_initiator_cco.`address_line_3` AS 'sud_fk_initiator_cco__address_line_3',
	sud_fk_initiator_cco.`address_line_4` AS 'sud_fk_initiator_cco__address_line_4',
	sud_fk_initiator_cco.`address_city` AS 'sud_fk_initiator_cco__address_city',
	sud_fk_initiator_cco.`address_county` AS 'sud_fk_initiator_cco__address_county',
	sud_fk_initiator_cco.`address_state_or_region` AS 'sud_fk_initiator_cco__address_state_or_region',
	sud_fk_initiator_cco.`address_postal_code` AS 'sud_fk_initiator_cco__address_postal_code',
	sud_fk_initiator_cco.`address_postal_code_extension` AS 'sud_fk_initiator_cco__address_postal_code_extension',
	sud_fk_initiator_cco.`address_country` AS 'sud_fk_initiator_cco__address_country',
	sud_fk_initiator_cco.`head_quarters_flag` AS 'sud_fk_initiator_cco__head_quarters_flag',
	sud_fk_initiator_cco.`address_validated_by_user_flag` AS 'sud_fk_initiator_cco__address_validated_by_user_flag',
	sud_fk_initiator_cco.`address_validated_by_web_service_flag` AS 'sud_fk_initiator_cco__address_validated_by_web_service_flag',
	sud_fk_initiator_cco.`address_validation_by_web_service_error_flag` AS 'sud_fk_initiator_cco__address_validation_by_web_service_error_flag',

	sud_fk_initiator_phone_ccopn.`id` AS 'sud_fk_initiator_phone_ccopn__contact_company_office_phone_number_id',
	sud_fk_initiator_phone_ccopn.`contact_company_office_id` AS 'sud_fk_initiator_phone_ccopn__contact_company_office_id',
	sud_fk_initiator_phone_ccopn.`phone_number_type_id` AS 'sud_fk_initiator_phone_ccopn__phone_number_type_id',
	sud_fk_initiator_phone_ccopn.`country_code` AS 'sud_fk_initiator_phone_ccopn__country_code',
	sud_fk_initiator_phone_ccopn.`area_code` AS 'sud_fk_initiator_phone_ccopn__area_code',
	sud_fk_initiator_phone_ccopn.`prefix` AS 'sud_fk_initiator_phone_ccopn__prefix',
	sud_fk_initiator_phone_ccopn.`number` AS 'sud_fk_initiator_phone_ccopn__number',
	sud_fk_initiator_phone_ccopn.`extension` AS 'sud_fk_initiator_phone_ccopn__extension',
	sud_fk_initiator_phone_ccopn.`itu` AS 'sud_fk_initiator_phone_ccopn__itu',

	sud_fk_initiator_fax_ccopn.`id` AS 'sud_fk_initiator_fax_ccopn__contact_company_office_phone_number_id',
	sud_fk_initiator_fax_ccopn.`contact_company_office_id` AS 'sud_fk_initiator_fax_ccopn__contact_company_office_id',
	sud_fk_initiator_fax_ccopn.`phone_number_type_id` AS 'sud_fk_initiator_fax_ccopn__phone_number_type_id',
	sud_fk_initiator_fax_ccopn.`country_code` AS 'sud_fk_initiator_fax_ccopn__country_code',
	sud_fk_initiator_fax_ccopn.`area_code` AS 'sud_fk_initiator_fax_ccopn__area_code',
	sud_fk_initiator_fax_ccopn.`prefix` AS 'sud_fk_initiator_fax_ccopn__prefix',
	sud_fk_initiator_fax_ccopn.`number` AS 'sud_fk_initiator_fax_ccopn__number',
	sud_fk_initiator_fax_ccopn.`extension` AS 'sud_fk_initiator_fax_ccopn__extension',
	sud_fk_initiator_fax_ccopn.`itu` AS 'sud_fk_initiator_fax_ccopn__itu',

	sud_fk_initiator_c_mobile_cpn.`id` AS 'sud_fk_initiator_c_mobile_cpn__contact_phone_number_id',
	sud_fk_initiator_c_mobile_cpn.`contact_id` AS 'sud_fk_initiator_c_mobile_cpn__contact_id',
	sud_fk_initiator_c_mobile_cpn.`phone_number_type_id` AS 'sud_fk_initiator_c_mobile_cpn__phone_number_type_id',
	sud_fk_initiator_c_mobile_cpn.`country_code` AS 'sud_fk_initiator_c_mobile_cpn__country_code',
	sud_fk_initiator_c_mobile_cpn.`area_code` AS 'sud_fk_initiator_c_mobile_cpn__area_code',
	sud_fk_initiator_c_mobile_cpn.`prefix` AS 'sud_fk_initiator_c_mobile_cpn__prefix',
	sud_fk_initiator_c_mobile_cpn.`number` AS 'sud_fk_initiator_c_mobile_cpn__number',
	sud_fk_initiator_c_mobile_cpn.`extension` AS 'sud_fk_initiator_c_mobile_cpn__extension',
	sud_fk_initiator_c_mobile_cpn.`itu` AS 'sud_fk_initiator_c_mobile_cpn__itu',

	sud.*

FROM `submittal_drafts` sud
	INNER JOIN `projects` sud_fk_p ON sud.`project_id` = sud_fk_p.`id`
	INNER JOIN `submittal_types` sud_fk_sut ON sud.`submittal_type_id` = sud_fk_sut.`id`
	INNER JOIN `submittal_priorities` sud_fk_sup ON sud.`submittal_priority_id` = sud_fk_sup.`id`
	INNER JOIN `submittal_distribution_methods` sud_fk_sudm ON sud.`submittal_distribution_method_id` = sud_fk_sudm.`id`
	LEFT OUTER JOIN `file_manager_files` sud_fk_fmfiles ON sud.`su_file_manager_file_id` = sud_fk_fmfiles.`id`
	LEFT OUTER JOIN `cost_codes` sud_fk_codes ON sud.`su_cost_code_id` = sud_fk_codes.`id`
	INNER JOIN `contacts` sud_fk_creator_c ON sud.`su_creator_contact_id` = sud_fk_creator_c.`id`
	LEFT OUTER JOIN `contact_company_offices` sud_fk_creator_cco ON sud.`su_creator_contact_company_office_id` = sud_fk_creator_cco.`id`
	LEFT OUTER JOIN `contact_company_office_phone_numbers` sud_fk_creator_phone_ccopn ON sud.`su_creator_phone_contact_company_office_phone_number_id` = sud_fk_creator_phone_ccopn.`id`
	LEFT OUTER JOIN `contact_company_office_phone_numbers` sud_fk_creator_fax_ccopn ON sud.`su_creator_fax_contact_company_office_phone_number_id` = sud_fk_creator_fax_ccopn.`id`
	LEFT OUTER JOIN `contact_phone_numbers` sud_fk_creator_c_mobile_cpn ON sud.`su_creator_contact_mobile_phone_number_id` = sud_fk_creator_c_mobile_cpn.`id`
	LEFT OUTER JOIN `contacts` sud_fk_recipient_c ON sud.`su_recipient_contact_id` = sud_fk_recipient_c.`id`
	LEFT OUTER JOIN `contact_company_offices` sud_fk_recipient_cco ON sud.`su_recipient_contact_company_office_id` = sud_fk_recipient_cco.`id`
	LEFT OUTER JOIN `contact_company_office_phone_numbers` sud_fk_recipient_phone_ccopn ON sud.`su_recipient_phone_contact_company_office_phone_number_id` = sud_fk_recipient_phone_ccopn.`id`
	LEFT OUTER JOIN `contact_company_office_phone_numbers` sud_fk_recipient_fax_ccopn ON sud.`su_recipient_fax_contact_company_office_phone_number_id` = sud_fk_recipient_fax_ccopn.`id`
	LEFT OUTER JOIN `contact_phone_numbers` sud_fk_recipient_c_mobile_cpn ON sud.`su_recipient_contact_mobile_phone_number_id` = sud_fk_recipient_c_mobile_cpn.`id`
	LEFT OUTER JOIN `contacts` sud_fk_initiator_c ON sud.`su_initiator_contact_id` = sud_fk_initiator_c.`id`
	LEFT OUTER JOIN `contact_company_offices` sud_fk_initiator_cco ON sud.`su_initiator_contact_company_office_id` = sud_fk_initiator_cco.`id`
	LEFT OUTER JOIN `contact_company_office_phone_numbers` sud_fk_initiator_phone_ccopn ON sud.`su_initiator_phone_contact_company_office_phone_number_id` = sud_fk_initiator_phone_ccopn.`id`
	LEFT OUTER JOIN `contact_company_office_phone_numbers` sud_fk_initiator_fax_ccopn ON sud.`su_initiator_fax_contact_company_office_phone_number_id` = sud_fk_initiator_fax_ccopn.`id`
	LEFT OUTER JOIN `contact_phone_numbers` sud_fk_initiator_c_mobile_cpn ON sud.`su_initiator_contact_mobile_phone_number_id` = sud_fk_initiator_c_mobile_cpn.`id`
WHERE sud.`id` = ?
";
		$arrValues = array($submittal_draft_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$submittal_draft_id = $row['id'];
			$submittalDraft = self::instantiateOrm($database, 'SubmittalDraft', $row, null, $submittal_draft_id);
			/* @var $submittalDraft SubmittalDraft */
			$submittalDraft->convertPropertiesToData();

			if (isset($row['project_id'])) {
				$project_id = $row['project_id'];
				$row['sud_fk_p__id'] = $project_id;
				$project = self::instantiateOrm($database, 'Project', $row, null, $project_id, 'sud_fk_p__');
				/* @var $project Project */
				$project->convertPropertiesToData();
			} else {
				$project = false;
			}
			$submittalDraft->setProject($project);

			if (isset($row['submittal_type_id'])) {
				$submittal_type_id = $row['submittal_type_id'];
				$row['sud_fk_sut__id'] = $submittal_type_id;
				$submittalType = self::instantiateOrm($database, 'SubmittalType', $row, null, $submittal_type_id, 'sud_fk_sut__');
				/* @var $submittalType SubmittalType */
				$submittalType->convertPropertiesToData();
			} else {
				$submittalType = false;
			}
			$submittalDraft->setSubmittalType($submittalType);

			if (isset($row['submittal_priority_id'])) {
				$submittal_priority_id = $row['submittal_priority_id'];
				$row['sud_fk_sup__id'] = $submittal_priority_id;
				$submittalPriority = self::instantiateOrm($database, 'SubmittalPriority', $row, null, $submittal_priority_id, 'sud_fk_sup__');
				/* @var $submittalPriority SubmittalPriority */
				$submittalPriority->convertPropertiesToData();
			} else {
				$submittalPriority = false;
			}
			$submittalDraft->setSubmittalPriority($submittalPriority);

			if (isset($row['submittal_distribution_method_id'])) {
				$submittal_distribution_method_id = $row['submittal_distribution_method_id'];
				$row['sud_fk_sudm__id'] = $submittal_distribution_method_id;
				$submittalDistributionMethod = self::instantiateOrm($database, 'SubmittalDistributionMethod', $row, null, $submittal_distribution_method_id, 'sud_fk_sudm__');
				/* @var $submittalDistributionMethod SubmittalDistributionMethod */
				$submittalDistributionMethod->convertPropertiesToData();
			} else {
				$submittalDistributionMethod = false;
			}
			$submittalDraft->setSubmittalDistributionMethod($submittalDistributionMethod);

			if (isset($row['su_file_manager_file_id'])) {
				$su_file_manager_file_id = $row['su_file_manager_file_id'];
				$row['sud_fk_fmfiles__id'] = $su_file_manager_file_id;
				$suFileManagerFile = self::instantiateOrm($database, 'FileManagerFile', $row, null, $su_file_manager_file_id, 'sud_fk_fmfiles__');
				/* @var $suFileManagerFile FileManagerFile */
				$suFileManagerFile->convertPropertiesToData();
			} else {
				$suFileManagerFile = false;
			}
			$submittalDraft->setSuFileManagerFile($suFileManagerFile);

			if (isset($row['su_cost_code_id'])) {
				$su_cost_code_id = $row['su_cost_code_id'];
				$row['sud_fk_codes__id'] = $su_cost_code_id;
				$suCostCode = self::instantiateOrm($database, 'CostCode', $row, null, $su_cost_code_id, 'sud_fk_codes__');
				/* @var $suCostCode CostCode */
				$suCostCode->convertPropertiesToData();
			} else {
				$suCostCode = false;
			}
			$submittalDraft->setSuCostCode($suCostCode);

			if (isset($row['su_creator_contact_id'])) {
				$su_creator_contact_id = $row['su_creator_contact_id'];
				$row['sud_fk_creator_c__id'] = $su_creator_contact_id;
				$suCreatorContact = self::instantiateOrm($database, 'Contact', $row, null, $su_creator_contact_id, 'sud_fk_creator_c__');
				/* @var $suCreatorContact Contact */
				$suCreatorContact->convertPropertiesToData();
			} else {
				$suCreatorContact = false;
			}
			$submittalDraft->setSuCreatorContact($suCreatorContact);

			if (isset($row['su_creator_contact_company_office_id'])) {
				$su_creator_contact_company_office_id = $row['su_creator_contact_company_office_id'];
				$row['sud_fk_creator_cco__id'] = $su_creator_contact_company_office_id;
				$suCreatorContactCompanyOffice = self::instantiateOrm($database, 'ContactCompanyOffice', $row, null, $su_creator_contact_company_office_id, 'sud_fk_creator_cco__');
				/* @var $suCreatorContactCompanyOffice ContactCompanyOffice */
				$suCreatorContactCompanyOffice->convertPropertiesToData();
			} else {
				$suCreatorContactCompanyOffice = false;
			}
			$submittalDraft->setSuCreatorContactCompanyOffice($suCreatorContactCompanyOffice);

			if (isset($row['su_creator_phone_contact_company_office_phone_number_id'])) {
				$su_creator_phone_contact_company_office_phone_number_id = $row['su_creator_phone_contact_company_office_phone_number_id'];
				$row['sud_fk_creator_phone_ccopn__id'] = $su_creator_phone_contact_company_office_phone_number_id;
				$suCreatorPhoneContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $su_creator_phone_contact_company_office_phone_number_id, 'sud_fk_creator_phone_ccopn__');
				/* @var $suCreatorPhoneContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$suCreatorPhoneContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$suCreatorPhoneContactCompanyOfficePhoneNumber = false;
			}
			$submittalDraft->setSuCreatorPhoneContactCompanyOfficePhoneNumber($suCreatorPhoneContactCompanyOfficePhoneNumber);

			if (isset($row['su_creator_fax_contact_company_office_phone_number_id'])) {
				$su_creator_fax_contact_company_office_phone_number_id = $row['su_creator_fax_contact_company_office_phone_number_id'];
				$row['sud_fk_creator_fax_ccopn__id'] = $su_creator_fax_contact_company_office_phone_number_id;
				$suCreatorFaxContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $su_creator_fax_contact_company_office_phone_number_id, 'sud_fk_creator_fax_ccopn__');
				/* @var $suCreatorFaxContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$suCreatorFaxContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$suCreatorFaxContactCompanyOfficePhoneNumber = false;
			}
			$submittalDraft->setSuCreatorFaxContactCompanyOfficePhoneNumber($suCreatorFaxContactCompanyOfficePhoneNumber);

			if (isset($row['su_creator_contact_mobile_phone_number_id'])) {
				$su_creator_contact_mobile_phone_number_id = $row['su_creator_contact_mobile_phone_number_id'];
				$row['sud_fk_creator_c_mobile_cpn__id'] = $su_creator_contact_mobile_phone_number_id;
				$suCreatorContactMobilePhoneNumber = self::instantiateOrm($database, 'ContactPhoneNumber', $row, null, $su_creator_contact_mobile_phone_number_id, 'sud_fk_creator_c_mobile_cpn__');
				/* @var $suCreatorContactMobilePhoneNumber ContactPhoneNumber */
				$suCreatorContactMobilePhoneNumber->convertPropertiesToData();
			} else {
				$suCreatorContactMobilePhoneNumber = false;
			}
			$submittalDraft->setSuCreatorContactMobilePhoneNumber($suCreatorContactMobilePhoneNumber);

			if (isset($row['su_recipient_contact_id'])) {
				$su_recipient_contact_id = $row['su_recipient_contact_id'];
				$row['sud_fk_recipient_c__id'] = $su_recipient_contact_id;
				$suRecipientContact = self::instantiateOrm($database, 'Contact', $row, null, $su_recipient_contact_id, 'sud_fk_recipient_c__');
				/* @var $suRecipientContact Contact */
				$suRecipientContact->convertPropertiesToData();
			} else {
				$suRecipientContact = false;
			}
			$submittalDraft->setSuRecipientContact($suRecipientContact);

			if (isset($row['su_recipient_contact_company_office_id'])) {
				$su_recipient_contact_company_office_id = $row['su_recipient_contact_company_office_id'];
				$row['sud_fk_recipient_cco__id'] = $su_recipient_contact_company_office_id;
				$suRecipientContactCompanyOffice = self::instantiateOrm($database, 'ContactCompanyOffice', $row, null, $su_recipient_contact_company_office_id, 'sud_fk_recipient_cco__');
				/* @var $suRecipientContactCompanyOffice ContactCompanyOffice */
				$suRecipientContactCompanyOffice->convertPropertiesToData();
			} else {
				$suRecipientContactCompanyOffice = false;
			}
			$submittalDraft->setSuRecipientContactCompanyOffice($suRecipientContactCompanyOffice);

			if (isset($row['su_recipient_phone_contact_company_office_phone_number_id'])) {
				$su_recipient_phone_contact_company_office_phone_number_id = $row['su_recipient_phone_contact_company_office_phone_number_id'];
				$row['sud_fk_recipient_phone_ccopn__id'] = $su_recipient_phone_contact_company_office_phone_number_id;
				$suRecipientPhoneContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $su_recipient_phone_contact_company_office_phone_number_id, 'sud_fk_recipient_phone_ccopn__');
				/* @var $suRecipientPhoneContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$suRecipientPhoneContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$suRecipientPhoneContactCompanyOfficePhoneNumber = false;
			}
			$submittalDraft->setSuRecipientPhoneContactCompanyOfficePhoneNumber($suRecipientPhoneContactCompanyOfficePhoneNumber);

			if (isset($row['su_recipient_fax_contact_company_office_phone_number_id'])) {
				$su_recipient_fax_contact_company_office_phone_number_id = $row['su_recipient_fax_contact_company_office_phone_number_id'];
				$row['sud_fk_recipient_fax_ccopn__id'] = $su_recipient_fax_contact_company_office_phone_number_id;
				$suRecipientFaxContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $su_recipient_fax_contact_company_office_phone_number_id, 'sud_fk_recipient_fax_ccopn__');
				/* @var $suRecipientFaxContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$suRecipientFaxContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$suRecipientFaxContactCompanyOfficePhoneNumber = false;
			}
			$submittalDraft->setSuRecipientFaxContactCompanyOfficePhoneNumber($suRecipientFaxContactCompanyOfficePhoneNumber);

			if (isset($row['su_recipient_contact_mobile_phone_number_id'])) {
				$su_recipient_contact_mobile_phone_number_id = $row['su_recipient_contact_mobile_phone_number_id'];
				$row['sud_fk_recipient_c_mobile_cpn__id'] = $su_recipient_contact_mobile_phone_number_id;
				$suRecipientContactMobilePhoneNumber = self::instantiateOrm($database, 'ContactPhoneNumber', $row, null, $su_recipient_contact_mobile_phone_number_id, 'sud_fk_recipient_c_mobile_cpn__');
				/* @var $suRecipientContactMobilePhoneNumber ContactPhoneNumber */
				$suRecipientContactMobilePhoneNumber->convertPropertiesToData();
			} else {
				$suRecipientContactMobilePhoneNumber = false;
			}
			$submittalDraft->setSuRecipientContactMobilePhoneNumber($suRecipientContactMobilePhoneNumber);

			if (isset($row['su_initiator_contact_id'])) {
				$su_initiator_contact_id = $row['su_initiator_contact_id'];
				$row['sud_fk_initiator_c__id'] = $su_initiator_contact_id;
				$suInitiatorContact = self::instantiateOrm($database, 'Contact', $row, null, $su_initiator_contact_id, 'sud_fk_initiator_c__');
				/* @var $suInitiatorContact Contact */
				$suInitiatorContact->convertPropertiesToData();
			} else {
				$suInitiatorContact = false;
			}
			$submittalDraft->setSuInitiatorContact($suInitiatorContact);

			if (isset($row['su_initiator_contact_company_office_id'])) {
				$su_initiator_contact_company_office_id = $row['su_initiator_contact_company_office_id'];
				$row['sud_fk_initiator_cco__id'] = $su_initiator_contact_company_office_id;
				$suInitiatorContactCompanyOffice = self::instantiateOrm($database, 'ContactCompanyOffice', $row, null, $su_initiator_contact_company_office_id, 'sud_fk_initiator_cco__');
				/* @var $suInitiatorContactCompanyOffice ContactCompanyOffice */
				$suInitiatorContactCompanyOffice->convertPropertiesToData();
			} else {
				$suInitiatorContactCompanyOffice = false;
			}
			$submittalDraft->setSuInitiatorContactCompanyOffice($suInitiatorContactCompanyOffice);

			if (isset($row['su_initiator_phone_contact_company_office_phone_number_id'])) {
				$su_initiator_phone_contact_company_office_phone_number_id = $row['su_initiator_phone_contact_company_office_phone_number_id'];
				$row['sud_fk_initiator_phone_ccopn__id'] = $su_initiator_phone_contact_company_office_phone_number_id;
				$suInitiatorPhoneContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $su_initiator_phone_contact_company_office_phone_number_id, 'sud_fk_initiator_phone_ccopn__');
				/* @var $suInitiatorPhoneContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$suInitiatorPhoneContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$suInitiatorPhoneContactCompanyOfficePhoneNumber = false;
			}
			$submittalDraft->setSuInitiatorPhoneContactCompanyOfficePhoneNumber($suInitiatorPhoneContactCompanyOfficePhoneNumber);

			if (isset($row['su_initiator_fax_contact_company_office_phone_number_id'])) {
				$su_initiator_fax_contact_company_office_phone_number_id = $row['su_initiator_fax_contact_company_office_phone_number_id'];
				$row['sud_fk_initiator_fax_ccopn__id'] = $su_initiator_fax_contact_company_office_phone_number_id;
				$suInitiatorFaxContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $su_initiator_fax_contact_company_office_phone_number_id, 'sud_fk_initiator_fax_ccopn__');
				/* @var $suInitiatorFaxContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$suInitiatorFaxContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$suInitiatorFaxContactCompanyOfficePhoneNumber = false;
			}
			$submittalDraft->setSuInitiatorFaxContactCompanyOfficePhoneNumber($suInitiatorFaxContactCompanyOfficePhoneNumber);

			if (isset($row['su_initiator_contact_mobile_phone_number_id'])) {
				$su_initiator_contact_mobile_phone_number_id = $row['su_initiator_contact_mobile_phone_number_id'];
				$row['sud_fk_initiator_c_mobile_cpn__id'] = $su_initiator_contact_mobile_phone_number_id;
				$suInitiatorContactMobilePhoneNumber = self::instantiateOrm($database, 'ContactPhoneNumber', $row, null, $su_initiator_contact_mobile_phone_number_id, 'sud_fk_initiator_c_mobile_cpn__');
				/* @var $suInitiatorContactMobilePhoneNumber ContactPhoneNumber */
				$suInitiatorContactMobilePhoneNumber->convertPropertiesToData();
			} else {
				$suInitiatorContactMobilePhoneNumber = false;
			}
			$submittalDraft->setSuInitiatorContactMobilePhoneNumber($suInitiatorContactMobilePhoneNumber);

			return $submittalDraft;
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
	 * @param array $arrSubmittalDraftIds
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubmittalDraftsByArrSubmittalDraftIds($database, $arrSubmittalDraftIds, Input $options=null)
	{
		if (empty($arrSubmittalDraftIds)) {
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
		// ORDER BY `id` ASC, `project_id` ASC, `submittal_type_id` ASC, `submittal_priority_id` ASC, `submittal_distribution_method_id` ASC, `su_file_manager_file_id` ASC, `su_cost_code_id` ASC, `su_creator_contact_id` ASC, `su_creator_contact_company_office_id` ASC, `su_creator_phone_contact_company_office_phone_number_id` ASC, `su_creator_fax_contact_company_office_phone_number_id` ASC, `su_creator_contact_mobile_phone_number_id` ASC, `su_recipient_contact_id` ASC, `su_recipient_contact_company_office_id` ASC, `su_recipient_phone_contact_company_office_phone_number_id` ASC, `su_recipient_fax_contact_company_office_phone_number_id` ASC, `su_recipient_contact_mobile_phone_number_id` ASC, `su_initiator_contact_id` ASC, `su_initiator_contact_company_office_id` ASC, `su_initiator_phone_contact_company_office_phone_number_id` ASC, `su_initiator_fax_contact_company_office_phone_number_id` ASC, `su_initiator_contact_mobile_phone_number_id` ASC, `su_title` ASC, `su_plan_page_reference` ASC, `su_statement` ASC, `su_due_date` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubmittalDraft = new SubmittalDraft($database);
			$sqlOrderByColumns = $tmpSubmittalDraft->constructSqlOrderByColumns($arrOrderByAttributes);

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

		foreach ($arrSubmittalDraftIds as $k => $submittal_draft_id) {
			$submittal_draft_id = (int) $submittal_draft_id;
			$arrSubmittalDraftIds[$k] = $db->escape($submittal_draft_id);
		}
		$csvSubmittalDraftIds = join(',', $arrSubmittalDraftIds);

		$query =
"
SELECT

	sud.*

FROM `submittal_drafts` sud
WHERE sud.`id` IN ($csvSubmittalDraftIds){$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		$arrSubmittalDraftsByCsvSubmittalDraftIds = array();
		while ($row = $db->fetch()) {
			$submittal_draft_id = $row['id'];
			$submittalDraft = self::instantiateOrm($database, 'SubmittalDraft', $row, null, $submittal_draft_id);
			/* @var $submittalDraft SubmittalDraft */
			$submittalDraft->convertPropertiesToData();

			$arrSubmittalDraftsByCsvSubmittalDraftIds[$submittal_draft_id] = $submittalDraft;
		}

		$db->free_result();

		return $arrSubmittalDraftsByCsvSubmittalDraftIds;
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `submittal_drafts_fk_p` foreign key (`project_id`) references `projects` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $project_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubmittalDraftsByProjectId($database, $project_id, Input $options=null)
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
			self::$_arrSubmittalDraftsByProjectId = null;
		}

		$arrSubmittalDraftsByProjectId = self::$_arrSubmittalDraftsByProjectId;
		if (isset($arrSubmittalDraftsByProjectId) && !empty($arrSubmittalDraftsByProjectId)) {
			return $arrSubmittalDraftsByProjectId;
		}

		$project_id = (int) $project_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `submittal_type_id` ASC, `submittal_priority_id` ASC, `submittal_distribution_method_id` ASC, `su_file_manager_file_id` ASC, `su_cost_code_id` ASC, `su_creator_contact_id` ASC, `su_creator_contact_company_office_id` ASC, `su_creator_phone_contact_company_office_phone_number_id` ASC, `su_creator_fax_contact_company_office_phone_number_id` ASC, `su_creator_contact_mobile_phone_number_id` ASC, `su_recipient_contact_id` ASC, `su_recipient_contact_company_office_id` ASC, `su_recipient_phone_contact_company_office_phone_number_id` ASC, `su_recipient_fax_contact_company_office_phone_number_id` ASC, `su_recipient_contact_mobile_phone_number_id` ASC, `su_initiator_contact_id` ASC, `su_initiator_contact_company_office_id` ASC, `su_initiator_phone_contact_company_office_phone_number_id` ASC, `su_initiator_fax_contact_company_office_phone_number_id` ASC, `su_initiator_contact_mobile_phone_number_id` ASC, `su_title` ASC, `su_plan_page_reference` ASC, `su_statement` ASC, `su_due_date` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubmittalDraft = new SubmittalDraft($database);
			$sqlOrderByColumns = $tmpSubmittalDraft->constructSqlOrderByColumns($arrOrderByAttributes);

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
	sud.*

FROM `submittal_drafts` sud
WHERE sud.`project_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `submittal_type_id` ASC, `submittal_priority_id` ASC, `submittal_distribution_method_id` ASC, `su_file_manager_file_id` ASC, `su_cost_code_id` ASC, `su_creator_contact_id` ASC, `su_creator_contact_company_office_id` ASC, `su_creator_phone_contact_company_office_phone_number_id` ASC, `su_creator_fax_contact_company_office_phone_number_id` ASC, `su_creator_contact_mobile_phone_number_id` ASC, `su_recipient_contact_id` ASC, `su_recipient_contact_company_office_id` ASC, `su_recipient_phone_contact_company_office_phone_number_id` ASC, `su_recipient_fax_contact_company_office_phone_number_id` ASC, `su_recipient_contact_mobile_phone_number_id` ASC, `su_initiator_contact_id` ASC, `su_initiator_contact_company_office_id` ASC, `su_initiator_phone_contact_company_office_phone_number_id` ASC, `su_initiator_fax_contact_company_office_phone_number_id` ASC, `su_initiator_contact_mobile_phone_number_id` ASC, `su_title` ASC, `su_plan_page_reference` ASC, `su_statement` ASC, `su_due_date` ASC
		$arrValues = array($project_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubmittalDraftsByProjectId = array();
		while ($row = $db->fetch()) {
			$submittal_draft_id = $row['id'];
			$submittalDraft = self::instantiateOrm($database, 'SubmittalDraft', $row, null, $submittal_draft_id);
			/* @var $submittalDraft SubmittalDraft */
			$arrSubmittalDraftsByProjectId[$submittal_draft_id] = $submittalDraft;
		}

		$db->free_result();

		self::$_arrSubmittalDraftsByProjectId = $arrSubmittalDraftsByProjectId;

		return $arrSubmittalDraftsByProjectId;
	}

	/**
	 * Load by constraint `submittal_drafts_fk_sut` foreign key (`submittal_type_id`) references `submittal_types` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $submittal_type_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubmittalDraftsBySubmittalTypeId($database, $submittal_type_id, Input $options=null)
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
			self::$_arrSubmittalDraftsBySubmittalTypeId = null;
		}

		$arrSubmittalDraftsBySubmittalTypeId = self::$_arrSubmittalDraftsBySubmittalTypeId;
		if (isset($arrSubmittalDraftsBySubmittalTypeId) && !empty($arrSubmittalDraftsBySubmittalTypeId)) {
			return $arrSubmittalDraftsBySubmittalTypeId;
		}

		$submittal_type_id = (int) $submittal_type_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `submittal_type_id` ASC, `submittal_priority_id` ASC, `submittal_distribution_method_id` ASC, `su_file_manager_file_id` ASC, `su_cost_code_id` ASC, `su_creator_contact_id` ASC, `su_creator_contact_company_office_id` ASC, `su_creator_phone_contact_company_office_phone_number_id` ASC, `su_creator_fax_contact_company_office_phone_number_id` ASC, `su_creator_contact_mobile_phone_number_id` ASC, `su_recipient_contact_id` ASC, `su_recipient_contact_company_office_id` ASC, `su_recipient_phone_contact_company_office_phone_number_id` ASC, `su_recipient_fax_contact_company_office_phone_number_id` ASC, `su_recipient_contact_mobile_phone_number_id` ASC, `su_initiator_contact_id` ASC, `su_initiator_contact_company_office_id` ASC, `su_initiator_phone_contact_company_office_phone_number_id` ASC, `su_initiator_fax_contact_company_office_phone_number_id` ASC, `su_initiator_contact_mobile_phone_number_id` ASC, `su_title` ASC, `su_plan_page_reference` ASC, `su_statement` ASC, `su_due_date` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubmittalDraft = new SubmittalDraft($database);
			$sqlOrderByColumns = $tmpSubmittalDraft->constructSqlOrderByColumns($arrOrderByAttributes);

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
	sud.*

FROM `submittal_drafts` sud
WHERE sud.`submittal_type_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `submittal_type_id` ASC, `submittal_priority_id` ASC, `submittal_distribution_method_id` ASC, `su_file_manager_file_id` ASC, `su_cost_code_id` ASC, `su_creator_contact_id` ASC, `su_creator_contact_company_office_id` ASC, `su_creator_phone_contact_company_office_phone_number_id` ASC, `su_creator_fax_contact_company_office_phone_number_id` ASC, `su_creator_contact_mobile_phone_number_id` ASC, `su_recipient_contact_id` ASC, `su_recipient_contact_company_office_id` ASC, `su_recipient_phone_contact_company_office_phone_number_id` ASC, `su_recipient_fax_contact_company_office_phone_number_id` ASC, `su_recipient_contact_mobile_phone_number_id` ASC, `su_initiator_contact_id` ASC, `su_initiator_contact_company_office_id` ASC, `su_initiator_phone_contact_company_office_phone_number_id` ASC, `su_initiator_fax_contact_company_office_phone_number_id` ASC, `su_initiator_contact_mobile_phone_number_id` ASC, `su_title` ASC, `su_plan_page_reference` ASC, `su_statement` ASC, `su_due_date` ASC
		$arrValues = array($submittal_type_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubmittalDraftsBySubmittalTypeId = array();
		while ($row = $db->fetch()) {
			$submittal_draft_id = $row['id'];
			$submittalDraft = self::instantiateOrm($database, 'SubmittalDraft', $row, null, $submittal_draft_id);
			/* @var $submittalDraft SubmittalDraft */
			$arrSubmittalDraftsBySubmittalTypeId[$submittal_draft_id] = $submittalDraft;
		}

		$db->free_result();

		self::$_arrSubmittalDraftsBySubmittalTypeId = $arrSubmittalDraftsBySubmittalTypeId;

		return $arrSubmittalDraftsBySubmittalTypeId;
	}

	/**
	 * Load by constraint `submittal_drafts_fk_sup` foreign key (`submittal_priority_id`) references `submittal_priorities` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $submittal_priority_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubmittalDraftsBySubmittalPriorityId($database, $submittal_priority_id, Input $options=null)
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
			self::$_arrSubmittalDraftsBySubmittalPriorityId = null;
		}

		$arrSubmittalDraftsBySubmittalPriorityId = self::$_arrSubmittalDraftsBySubmittalPriorityId;
		if (isset($arrSubmittalDraftsBySubmittalPriorityId) && !empty($arrSubmittalDraftsBySubmittalPriorityId)) {
			return $arrSubmittalDraftsBySubmittalPriorityId;
		}

		$submittal_priority_id = (int) $submittal_priority_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `submittal_type_id` ASC, `submittal_priority_id` ASC, `submittal_distribution_method_id` ASC, `su_file_manager_file_id` ASC, `su_cost_code_id` ASC, `su_creator_contact_id` ASC, `su_creator_contact_company_office_id` ASC, `su_creator_phone_contact_company_office_phone_number_id` ASC, `su_creator_fax_contact_company_office_phone_number_id` ASC, `su_creator_contact_mobile_phone_number_id` ASC, `su_recipient_contact_id` ASC, `su_recipient_contact_company_office_id` ASC, `su_recipient_phone_contact_company_office_phone_number_id` ASC, `su_recipient_fax_contact_company_office_phone_number_id` ASC, `su_recipient_contact_mobile_phone_number_id` ASC, `su_initiator_contact_id` ASC, `su_initiator_contact_company_office_id` ASC, `su_initiator_phone_contact_company_office_phone_number_id` ASC, `su_initiator_fax_contact_company_office_phone_number_id` ASC, `su_initiator_contact_mobile_phone_number_id` ASC, `su_title` ASC, `su_plan_page_reference` ASC, `su_statement` ASC, `su_due_date` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubmittalDraft = new SubmittalDraft($database);
			$sqlOrderByColumns = $tmpSubmittalDraft->constructSqlOrderByColumns($arrOrderByAttributes);

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
	sud.*

FROM `submittal_drafts` sud
WHERE sud.`submittal_priority_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `submittal_type_id` ASC, `submittal_priority_id` ASC, `submittal_distribution_method_id` ASC, `su_file_manager_file_id` ASC, `su_cost_code_id` ASC, `su_creator_contact_id` ASC, `su_creator_contact_company_office_id` ASC, `su_creator_phone_contact_company_office_phone_number_id` ASC, `su_creator_fax_contact_company_office_phone_number_id` ASC, `su_creator_contact_mobile_phone_number_id` ASC, `su_recipient_contact_id` ASC, `su_recipient_contact_company_office_id` ASC, `su_recipient_phone_contact_company_office_phone_number_id` ASC, `su_recipient_fax_contact_company_office_phone_number_id` ASC, `su_recipient_contact_mobile_phone_number_id` ASC, `su_initiator_contact_id` ASC, `su_initiator_contact_company_office_id` ASC, `su_initiator_phone_contact_company_office_phone_number_id` ASC, `su_initiator_fax_contact_company_office_phone_number_id` ASC, `su_initiator_contact_mobile_phone_number_id` ASC, `su_title` ASC, `su_plan_page_reference` ASC, `su_statement` ASC, `su_due_date` ASC
		$arrValues = array($submittal_priority_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubmittalDraftsBySubmittalPriorityId = array();
		while ($row = $db->fetch()) {
			$submittal_draft_id = $row['id'];
			$submittalDraft = self::instantiateOrm($database, 'SubmittalDraft', $row, null, $submittal_draft_id);
			/* @var $submittalDraft SubmittalDraft */
			$arrSubmittalDraftsBySubmittalPriorityId[$submittal_draft_id] = $submittalDraft;
		}

		$db->free_result();

		self::$_arrSubmittalDraftsBySubmittalPriorityId = $arrSubmittalDraftsBySubmittalPriorityId;

		return $arrSubmittalDraftsBySubmittalPriorityId;
	}

	/**
	 * Load by constraint `submittal_drafts_fk_sudm` foreign key (`submittal_distribution_method_id`) references `submittal_distribution_methods` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $submittal_distribution_method_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubmittalDraftsBySubmittalDistributionMethodId($database, $submittal_distribution_method_id, Input $options=null)
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
			self::$_arrSubmittalDraftsBySubmittalDistributionMethodId = null;
		}

		$arrSubmittalDraftsBySubmittalDistributionMethodId = self::$_arrSubmittalDraftsBySubmittalDistributionMethodId;
		if (isset($arrSubmittalDraftsBySubmittalDistributionMethodId) && !empty($arrSubmittalDraftsBySubmittalDistributionMethodId)) {
			return $arrSubmittalDraftsBySubmittalDistributionMethodId;
		}

		$submittal_distribution_method_id = (int) $submittal_distribution_method_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `submittal_type_id` ASC, `submittal_priority_id` ASC, `submittal_distribution_method_id` ASC, `su_file_manager_file_id` ASC, `su_cost_code_id` ASC, `su_creator_contact_id` ASC, `su_creator_contact_company_office_id` ASC, `su_creator_phone_contact_company_office_phone_number_id` ASC, `su_creator_fax_contact_company_office_phone_number_id` ASC, `su_creator_contact_mobile_phone_number_id` ASC, `su_recipient_contact_id` ASC, `su_recipient_contact_company_office_id` ASC, `su_recipient_phone_contact_company_office_phone_number_id` ASC, `su_recipient_fax_contact_company_office_phone_number_id` ASC, `su_recipient_contact_mobile_phone_number_id` ASC, `su_initiator_contact_id` ASC, `su_initiator_contact_company_office_id` ASC, `su_initiator_phone_contact_company_office_phone_number_id` ASC, `su_initiator_fax_contact_company_office_phone_number_id` ASC, `su_initiator_contact_mobile_phone_number_id` ASC, `su_title` ASC, `su_plan_page_reference` ASC, `su_statement` ASC, `su_due_date` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubmittalDraft = new SubmittalDraft($database);
			$sqlOrderByColumns = $tmpSubmittalDraft->constructSqlOrderByColumns($arrOrderByAttributes);

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
	sud.*

FROM `submittal_drafts` sud
WHERE sud.`submittal_distribution_method_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `submittal_type_id` ASC, `submittal_priority_id` ASC, `submittal_distribution_method_id` ASC, `su_file_manager_file_id` ASC, `su_cost_code_id` ASC, `su_creator_contact_id` ASC, `su_creator_contact_company_office_id` ASC, `su_creator_phone_contact_company_office_phone_number_id` ASC, `su_creator_fax_contact_company_office_phone_number_id` ASC, `su_creator_contact_mobile_phone_number_id` ASC, `su_recipient_contact_id` ASC, `su_recipient_contact_company_office_id` ASC, `su_recipient_phone_contact_company_office_phone_number_id` ASC, `su_recipient_fax_contact_company_office_phone_number_id` ASC, `su_recipient_contact_mobile_phone_number_id` ASC, `su_initiator_contact_id` ASC, `su_initiator_contact_company_office_id` ASC, `su_initiator_phone_contact_company_office_phone_number_id` ASC, `su_initiator_fax_contact_company_office_phone_number_id` ASC, `su_initiator_contact_mobile_phone_number_id` ASC, `su_title` ASC, `su_plan_page_reference` ASC, `su_statement` ASC, `su_due_date` ASC
		$arrValues = array($submittal_distribution_method_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubmittalDraftsBySubmittalDistributionMethodId = array();
		while ($row = $db->fetch()) {
			$submittal_draft_id = $row['id'];
			$submittalDraft = self::instantiateOrm($database, 'SubmittalDraft', $row, null, $submittal_draft_id);
			/* @var $submittalDraft SubmittalDraft */
			$arrSubmittalDraftsBySubmittalDistributionMethodId[$submittal_draft_id] = $submittalDraft;
		}

		$db->free_result();

		self::$_arrSubmittalDraftsBySubmittalDistributionMethodId = $arrSubmittalDraftsBySubmittalDistributionMethodId;

		return $arrSubmittalDraftsBySubmittalDistributionMethodId;
	}

	/**
	 * Load by constraint `submittal_drafts_fk_fmfiles` foreign key (`su_file_manager_file_id`) references `file_manager_files` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $su_file_manager_file_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubmittalDraftsBySuFileManagerFileId($database, $su_file_manager_file_id, Input $options=null)
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
			self::$_arrSubmittalDraftsBySuFileManagerFileId = null;
		}

		$arrSubmittalDraftsBySuFileManagerFileId = self::$_arrSubmittalDraftsBySuFileManagerFileId;
		if (isset($arrSubmittalDraftsBySuFileManagerFileId) && !empty($arrSubmittalDraftsBySuFileManagerFileId)) {
			return $arrSubmittalDraftsBySuFileManagerFileId;
		}

		$su_file_manager_file_id = (int) $su_file_manager_file_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `submittal_type_id` ASC, `submittal_priority_id` ASC, `submittal_distribution_method_id` ASC, `su_file_manager_file_id` ASC, `su_cost_code_id` ASC, `su_creator_contact_id` ASC, `su_creator_contact_company_office_id` ASC, `su_creator_phone_contact_company_office_phone_number_id` ASC, `su_creator_fax_contact_company_office_phone_number_id` ASC, `su_creator_contact_mobile_phone_number_id` ASC, `su_recipient_contact_id` ASC, `su_recipient_contact_company_office_id` ASC, `su_recipient_phone_contact_company_office_phone_number_id` ASC, `su_recipient_fax_contact_company_office_phone_number_id` ASC, `su_recipient_contact_mobile_phone_number_id` ASC, `su_initiator_contact_id` ASC, `su_initiator_contact_company_office_id` ASC, `su_initiator_phone_contact_company_office_phone_number_id` ASC, `su_initiator_fax_contact_company_office_phone_number_id` ASC, `su_initiator_contact_mobile_phone_number_id` ASC, `su_title` ASC, `su_plan_page_reference` ASC, `su_statement` ASC, `su_due_date` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubmittalDraft = new SubmittalDraft($database);
			$sqlOrderByColumns = $tmpSubmittalDraft->constructSqlOrderByColumns($arrOrderByAttributes);

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
	sud.*

FROM `submittal_drafts` sud
WHERE sud.`su_file_manager_file_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `submittal_type_id` ASC, `submittal_priority_id` ASC, `submittal_distribution_method_id` ASC, `su_file_manager_file_id` ASC, `su_cost_code_id` ASC, `su_creator_contact_id` ASC, `su_creator_contact_company_office_id` ASC, `su_creator_phone_contact_company_office_phone_number_id` ASC, `su_creator_fax_contact_company_office_phone_number_id` ASC, `su_creator_contact_mobile_phone_number_id` ASC, `su_recipient_contact_id` ASC, `su_recipient_contact_company_office_id` ASC, `su_recipient_phone_contact_company_office_phone_number_id` ASC, `su_recipient_fax_contact_company_office_phone_number_id` ASC, `su_recipient_contact_mobile_phone_number_id` ASC, `su_initiator_contact_id` ASC, `su_initiator_contact_company_office_id` ASC, `su_initiator_phone_contact_company_office_phone_number_id` ASC, `su_initiator_fax_contact_company_office_phone_number_id` ASC, `su_initiator_contact_mobile_phone_number_id` ASC, `su_title` ASC, `su_plan_page_reference` ASC, `su_statement` ASC, `su_due_date` ASC
		$arrValues = array($su_file_manager_file_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubmittalDraftsBySuFileManagerFileId = array();
		while ($row = $db->fetch()) {
			$submittal_draft_id = $row['id'];
			$submittalDraft = self::instantiateOrm($database, 'SubmittalDraft', $row, null, $submittal_draft_id);
			/* @var $submittalDraft SubmittalDraft */
			$arrSubmittalDraftsBySuFileManagerFileId[$submittal_draft_id] = $submittalDraft;
		}

		$db->free_result();

		self::$_arrSubmittalDraftsBySuFileManagerFileId = $arrSubmittalDraftsBySuFileManagerFileId;

		return $arrSubmittalDraftsBySuFileManagerFileId;
	}

	/**
	 * Load by constraint `submittal_drafts_fk_codes` foreign key (`su_cost_code_id`) references `cost_codes` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $su_cost_code_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubmittalDraftsBySuCostCodeId($database, $su_cost_code_id, Input $options=null)
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
			self::$_arrSubmittalDraftsBySuCostCodeId = null;
		}

		$arrSubmittalDraftsBySuCostCodeId = self::$_arrSubmittalDraftsBySuCostCodeId;
		if (isset($arrSubmittalDraftsBySuCostCodeId) && !empty($arrSubmittalDraftsBySuCostCodeId)) {
			return $arrSubmittalDraftsBySuCostCodeId;
		}

		$su_cost_code_id = (int) $su_cost_code_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `submittal_type_id` ASC, `submittal_priority_id` ASC, `submittal_distribution_method_id` ASC, `su_file_manager_file_id` ASC, `su_cost_code_id` ASC, `su_creator_contact_id` ASC, `su_creator_contact_company_office_id` ASC, `su_creator_phone_contact_company_office_phone_number_id` ASC, `su_creator_fax_contact_company_office_phone_number_id` ASC, `su_creator_contact_mobile_phone_number_id` ASC, `su_recipient_contact_id` ASC, `su_recipient_contact_company_office_id` ASC, `su_recipient_phone_contact_company_office_phone_number_id` ASC, `su_recipient_fax_contact_company_office_phone_number_id` ASC, `su_recipient_contact_mobile_phone_number_id` ASC, `su_initiator_contact_id` ASC, `su_initiator_contact_company_office_id` ASC, `su_initiator_phone_contact_company_office_phone_number_id` ASC, `su_initiator_fax_contact_company_office_phone_number_id` ASC, `su_initiator_contact_mobile_phone_number_id` ASC, `su_title` ASC, `su_plan_page_reference` ASC, `su_statement` ASC, `su_due_date` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubmittalDraft = new SubmittalDraft($database);
			$sqlOrderByColumns = $tmpSubmittalDraft->constructSqlOrderByColumns($arrOrderByAttributes);

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
	sud.*

FROM `submittal_drafts` sud
WHERE sud.`su_cost_code_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `submittal_type_id` ASC, `submittal_priority_id` ASC, `submittal_distribution_method_id` ASC, `su_file_manager_file_id` ASC, `su_cost_code_id` ASC, `su_creator_contact_id` ASC, `su_creator_contact_company_office_id` ASC, `su_creator_phone_contact_company_office_phone_number_id` ASC, `su_creator_fax_contact_company_office_phone_number_id` ASC, `su_creator_contact_mobile_phone_number_id` ASC, `su_recipient_contact_id` ASC, `su_recipient_contact_company_office_id` ASC, `su_recipient_phone_contact_company_office_phone_number_id` ASC, `su_recipient_fax_contact_company_office_phone_number_id` ASC, `su_recipient_contact_mobile_phone_number_id` ASC, `su_initiator_contact_id` ASC, `su_initiator_contact_company_office_id` ASC, `su_initiator_phone_contact_company_office_phone_number_id` ASC, `su_initiator_fax_contact_company_office_phone_number_id` ASC, `su_initiator_contact_mobile_phone_number_id` ASC, `su_title` ASC, `su_plan_page_reference` ASC, `su_statement` ASC, `su_due_date` ASC
		$arrValues = array($su_cost_code_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubmittalDraftsBySuCostCodeId = array();
		while ($row = $db->fetch()) {
			$submittal_draft_id = $row['id'];
			$submittalDraft = self::instantiateOrm($database, 'SubmittalDraft', $row, null, $submittal_draft_id);
			/* @var $submittalDraft SubmittalDraft */
			$arrSubmittalDraftsBySuCostCodeId[$submittal_draft_id] = $submittalDraft;
		}

		$db->free_result();

		self::$_arrSubmittalDraftsBySuCostCodeId = $arrSubmittalDraftsBySuCostCodeId;

		return $arrSubmittalDraftsBySuCostCodeId;
	}

	/**
	 * Load by constraint `submittal_drafts_fk_creator_c` foreign key (`su_creator_contact_id`) references `contacts` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $su_creator_contact_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubmittalDraftsBySuCreatorContactId($database, $su_creator_contact_id, Input $options=null)
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
			self::$_arrSubmittalDraftsBySuCreatorContactId = null;
		}

		$arrSubmittalDraftsBySuCreatorContactId = self::$_arrSubmittalDraftsBySuCreatorContactId;
		if (isset($arrSubmittalDraftsBySuCreatorContactId) && !empty($arrSubmittalDraftsBySuCreatorContactId)) {
			return $arrSubmittalDraftsBySuCreatorContactId;
		}

		$su_creator_contact_id = (int) $su_creator_contact_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `submittal_type_id` ASC, `submittal_priority_id` ASC, `submittal_distribution_method_id` ASC, `su_file_manager_file_id` ASC, `su_cost_code_id` ASC, `su_creator_contact_id` ASC, `su_creator_contact_company_office_id` ASC, `su_creator_phone_contact_company_office_phone_number_id` ASC, `su_creator_fax_contact_company_office_phone_number_id` ASC, `su_creator_contact_mobile_phone_number_id` ASC, `su_recipient_contact_id` ASC, `su_recipient_contact_company_office_id` ASC, `su_recipient_phone_contact_company_office_phone_number_id` ASC, `su_recipient_fax_contact_company_office_phone_number_id` ASC, `su_recipient_contact_mobile_phone_number_id` ASC, `su_initiator_contact_id` ASC, `su_initiator_contact_company_office_id` ASC, `su_initiator_phone_contact_company_office_phone_number_id` ASC, `su_initiator_fax_contact_company_office_phone_number_id` ASC, `su_initiator_contact_mobile_phone_number_id` ASC, `su_title` ASC, `su_plan_page_reference` ASC, `su_statement` ASC, `su_due_date` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubmittalDraft = new SubmittalDraft($database);
			$sqlOrderByColumns = $tmpSubmittalDraft->constructSqlOrderByColumns($arrOrderByAttributes);

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
	sud.*

FROM `submittal_drafts` sud
WHERE sud.`su_creator_contact_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `submittal_type_id` ASC, `submittal_priority_id` ASC, `submittal_distribution_method_id` ASC, `su_file_manager_file_id` ASC, `su_cost_code_id` ASC, `su_creator_contact_id` ASC, `su_creator_contact_company_office_id` ASC, `su_creator_phone_contact_company_office_phone_number_id` ASC, `su_creator_fax_contact_company_office_phone_number_id` ASC, `su_creator_contact_mobile_phone_number_id` ASC, `su_recipient_contact_id` ASC, `su_recipient_contact_company_office_id` ASC, `su_recipient_phone_contact_company_office_phone_number_id` ASC, `su_recipient_fax_contact_company_office_phone_number_id` ASC, `su_recipient_contact_mobile_phone_number_id` ASC, `su_initiator_contact_id` ASC, `su_initiator_contact_company_office_id` ASC, `su_initiator_phone_contact_company_office_phone_number_id` ASC, `su_initiator_fax_contact_company_office_phone_number_id` ASC, `su_initiator_contact_mobile_phone_number_id` ASC, `su_title` ASC, `su_plan_page_reference` ASC, `su_statement` ASC, `su_due_date` ASC
		$arrValues = array($su_creator_contact_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubmittalDraftsBySuCreatorContactId = array();
		while ($row = $db->fetch()) {
			$submittal_draft_id = $row['id'];
			$submittalDraft = self::instantiateOrm($database, 'SubmittalDraft', $row, null, $submittal_draft_id);
			/* @var $submittalDraft SubmittalDraft */
			$arrSubmittalDraftsBySuCreatorContactId[$submittal_draft_id] = $submittalDraft;
		}

		$db->free_result();

		self::$_arrSubmittalDraftsBySuCreatorContactId = $arrSubmittalDraftsBySuCreatorContactId;

		return $arrSubmittalDraftsBySuCreatorContactId;
	}

	/**
	 * Load by constraint `submittal_drafts_fk_creator_cco` foreign key (`su_creator_contact_company_office_id`) references `contact_company_offices` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $su_creator_contact_company_office_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubmittalDraftsBySuCreatorContactCompanyOfficeId($database, $su_creator_contact_company_office_id, Input $options=null)
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
			self::$_arrSubmittalDraftsBySuCreatorContactCompanyOfficeId = null;
		}

		$arrSubmittalDraftsBySuCreatorContactCompanyOfficeId = self::$_arrSubmittalDraftsBySuCreatorContactCompanyOfficeId;
		if (isset($arrSubmittalDraftsBySuCreatorContactCompanyOfficeId) && !empty($arrSubmittalDraftsBySuCreatorContactCompanyOfficeId)) {
			return $arrSubmittalDraftsBySuCreatorContactCompanyOfficeId;
		}

		$su_creator_contact_company_office_id = (int) $su_creator_contact_company_office_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `submittal_type_id` ASC, `submittal_priority_id` ASC, `submittal_distribution_method_id` ASC, `su_file_manager_file_id` ASC, `su_cost_code_id` ASC, `su_creator_contact_id` ASC, `su_creator_contact_company_office_id` ASC, `su_creator_phone_contact_company_office_phone_number_id` ASC, `su_creator_fax_contact_company_office_phone_number_id` ASC, `su_creator_contact_mobile_phone_number_id` ASC, `su_recipient_contact_id` ASC, `su_recipient_contact_company_office_id` ASC, `su_recipient_phone_contact_company_office_phone_number_id` ASC, `su_recipient_fax_contact_company_office_phone_number_id` ASC, `su_recipient_contact_mobile_phone_number_id` ASC, `su_initiator_contact_id` ASC, `su_initiator_contact_company_office_id` ASC, `su_initiator_phone_contact_company_office_phone_number_id` ASC, `su_initiator_fax_contact_company_office_phone_number_id` ASC, `su_initiator_contact_mobile_phone_number_id` ASC, `su_title` ASC, `su_plan_page_reference` ASC, `su_statement` ASC, `su_due_date` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubmittalDraft = new SubmittalDraft($database);
			$sqlOrderByColumns = $tmpSubmittalDraft->constructSqlOrderByColumns($arrOrderByAttributes);

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
	sud.*

FROM `submittal_drafts` sud
WHERE sud.`su_creator_contact_company_office_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `submittal_type_id` ASC, `submittal_priority_id` ASC, `submittal_distribution_method_id` ASC, `su_file_manager_file_id` ASC, `su_cost_code_id` ASC, `su_creator_contact_id` ASC, `su_creator_contact_company_office_id` ASC, `su_creator_phone_contact_company_office_phone_number_id` ASC, `su_creator_fax_contact_company_office_phone_number_id` ASC, `su_creator_contact_mobile_phone_number_id` ASC, `su_recipient_contact_id` ASC, `su_recipient_contact_company_office_id` ASC, `su_recipient_phone_contact_company_office_phone_number_id` ASC, `su_recipient_fax_contact_company_office_phone_number_id` ASC, `su_recipient_contact_mobile_phone_number_id` ASC, `su_initiator_contact_id` ASC, `su_initiator_contact_company_office_id` ASC, `su_initiator_phone_contact_company_office_phone_number_id` ASC, `su_initiator_fax_contact_company_office_phone_number_id` ASC, `su_initiator_contact_mobile_phone_number_id` ASC, `su_title` ASC, `su_plan_page_reference` ASC, `su_statement` ASC, `su_due_date` ASC
		$arrValues = array($su_creator_contact_company_office_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubmittalDraftsBySuCreatorContactCompanyOfficeId = array();
		while ($row = $db->fetch()) {
			$submittal_draft_id = $row['id'];
			$submittalDraft = self::instantiateOrm($database, 'SubmittalDraft', $row, null, $submittal_draft_id);
			/* @var $submittalDraft SubmittalDraft */
			$arrSubmittalDraftsBySuCreatorContactCompanyOfficeId[$submittal_draft_id] = $submittalDraft;
		}

		$db->free_result();

		self::$_arrSubmittalDraftsBySuCreatorContactCompanyOfficeId = $arrSubmittalDraftsBySuCreatorContactCompanyOfficeId;

		return $arrSubmittalDraftsBySuCreatorContactCompanyOfficeId;
	}

	/**
	 * Load by constraint `submittal_drafts_fk_creator_phone_ccopn` foreign key (`su_creator_phone_contact_company_office_phone_number_id`) references `contact_company_office_phone_numbers` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $su_creator_phone_contact_company_office_phone_number_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubmittalDraftsBySuCreatorPhoneContactCompanyOfficePhoneNumberId($database, $su_creator_phone_contact_company_office_phone_number_id, Input $options=null)
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
			self::$_arrSubmittalDraftsBySuCreatorPhoneContactCompanyOfficePhoneNumberId = null;
		}

		$arrSubmittalDraftsBySuCreatorPhoneContactCompanyOfficePhoneNumberId = self::$_arrSubmittalDraftsBySuCreatorPhoneContactCompanyOfficePhoneNumberId;
		if (isset($arrSubmittalDraftsBySuCreatorPhoneContactCompanyOfficePhoneNumberId) && !empty($arrSubmittalDraftsBySuCreatorPhoneContactCompanyOfficePhoneNumberId)) {
			return $arrSubmittalDraftsBySuCreatorPhoneContactCompanyOfficePhoneNumberId;
		}

		$su_creator_phone_contact_company_office_phone_number_id = (int) $su_creator_phone_contact_company_office_phone_number_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `submittal_type_id` ASC, `submittal_priority_id` ASC, `submittal_distribution_method_id` ASC, `su_file_manager_file_id` ASC, `su_cost_code_id` ASC, `su_creator_contact_id` ASC, `su_creator_contact_company_office_id` ASC, `su_creator_phone_contact_company_office_phone_number_id` ASC, `su_creator_fax_contact_company_office_phone_number_id` ASC, `su_creator_contact_mobile_phone_number_id` ASC, `su_recipient_contact_id` ASC, `su_recipient_contact_company_office_id` ASC, `su_recipient_phone_contact_company_office_phone_number_id` ASC, `su_recipient_fax_contact_company_office_phone_number_id` ASC, `su_recipient_contact_mobile_phone_number_id` ASC, `su_initiator_contact_id` ASC, `su_initiator_contact_company_office_id` ASC, `su_initiator_phone_contact_company_office_phone_number_id` ASC, `su_initiator_fax_contact_company_office_phone_number_id` ASC, `su_initiator_contact_mobile_phone_number_id` ASC, `su_title` ASC, `su_plan_page_reference` ASC, `su_statement` ASC, `su_due_date` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubmittalDraft = new SubmittalDraft($database);
			$sqlOrderByColumns = $tmpSubmittalDraft->constructSqlOrderByColumns($arrOrderByAttributes);

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
	sud.*

FROM `submittal_drafts` sud
WHERE sud.`su_creator_phone_contact_company_office_phone_number_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `submittal_type_id` ASC, `submittal_priority_id` ASC, `submittal_distribution_method_id` ASC, `su_file_manager_file_id` ASC, `su_cost_code_id` ASC, `su_creator_contact_id` ASC, `su_creator_contact_company_office_id` ASC, `su_creator_phone_contact_company_office_phone_number_id` ASC, `su_creator_fax_contact_company_office_phone_number_id` ASC, `su_creator_contact_mobile_phone_number_id` ASC, `su_recipient_contact_id` ASC, `su_recipient_contact_company_office_id` ASC, `su_recipient_phone_contact_company_office_phone_number_id` ASC, `su_recipient_fax_contact_company_office_phone_number_id` ASC, `su_recipient_contact_mobile_phone_number_id` ASC, `su_initiator_contact_id` ASC, `su_initiator_contact_company_office_id` ASC, `su_initiator_phone_contact_company_office_phone_number_id` ASC, `su_initiator_fax_contact_company_office_phone_number_id` ASC, `su_initiator_contact_mobile_phone_number_id` ASC, `su_title` ASC, `su_plan_page_reference` ASC, `su_statement` ASC, `su_due_date` ASC
		$arrValues = array($su_creator_phone_contact_company_office_phone_number_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubmittalDraftsBySuCreatorPhoneContactCompanyOfficePhoneNumberId = array();
		while ($row = $db->fetch()) {
			$submittal_draft_id = $row['id'];
			$submittalDraft = self::instantiateOrm($database, 'SubmittalDraft', $row, null, $submittal_draft_id);
			/* @var $submittalDraft SubmittalDraft */
			$arrSubmittalDraftsBySuCreatorPhoneContactCompanyOfficePhoneNumberId[$submittal_draft_id] = $submittalDraft;
		}

		$db->free_result();

		self::$_arrSubmittalDraftsBySuCreatorPhoneContactCompanyOfficePhoneNumberId = $arrSubmittalDraftsBySuCreatorPhoneContactCompanyOfficePhoneNumberId;

		return $arrSubmittalDraftsBySuCreatorPhoneContactCompanyOfficePhoneNumberId;
	}

	/**
	 * Load by constraint `submittal_drafts_fk_creator_fax_ccopn` foreign key (`su_creator_fax_contact_company_office_phone_number_id`) references `contact_company_office_phone_numbers` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $su_creator_fax_contact_company_office_phone_number_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubmittalDraftsBySuCreatorFaxContactCompanyOfficePhoneNumberId($database, $su_creator_fax_contact_company_office_phone_number_id, Input $options=null)
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
			self::$_arrSubmittalDraftsBySuCreatorFaxContactCompanyOfficePhoneNumberId = null;
		}

		$arrSubmittalDraftsBySuCreatorFaxContactCompanyOfficePhoneNumberId = self::$_arrSubmittalDraftsBySuCreatorFaxContactCompanyOfficePhoneNumberId;
		if (isset($arrSubmittalDraftsBySuCreatorFaxContactCompanyOfficePhoneNumberId) && !empty($arrSubmittalDraftsBySuCreatorFaxContactCompanyOfficePhoneNumberId)) {
			return $arrSubmittalDraftsBySuCreatorFaxContactCompanyOfficePhoneNumberId;
		}

		$su_creator_fax_contact_company_office_phone_number_id = (int) $su_creator_fax_contact_company_office_phone_number_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `submittal_type_id` ASC, `submittal_priority_id` ASC, `submittal_distribution_method_id` ASC, `su_file_manager_file_id` ASC, `su_cost_code_id` ASC, `su_creator_contact_id` ASC, `su_creator_contact_company_office_id` ASC, `su_creator_phone_contact_company_office_phone_number_id` ASC, `su_creator_fax_contact_company_office_phone_number_id` ASC, `su_creator_contact_mobile_phone_number_id` ASC, `su_recipient_contact_id` ASC, `su_recipient_contact_company_office_id` ASC, `su_recipient_phone_contact_company_office_phone_number_id` ASC, `su_recipient_fax_contact_company_office_phone_number_id` ASC, `su_recipient_contact_mobile_phone_number_id` ASC, `su_initiator_contact_id` ASC, `su_initiator_contact_company_office_id` ASC, `su_initiator_phone_contact_company_office_phone_number_id` ASC, `su_initiator_fax_contact_company_office_phone_number_id` ASC, `su_initiator_contact_mobile_phone_number_id` ASC, `su_title` ASC, `su_plan_page_reference` ASC, `su_statement` ASC, `su_due_date` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubmittalDraft = new SubmittalDraft($database);
			$sqlOrderByColumns = $tmpSubmittalDraft->constructSqlOrderByColumns($arrOrderByAttributes);

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
	sud.*

FROM `submittal_drafts` sud
WHERE sud.`su_creator_fax_contact_company_office_phone_number_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `submittal_type_id` ASC, `submittal_priority_id` ASC, `submittal_distribution_method_id` ASC, `su_file_manager_file_id` ASC, `su_cost_code_id` ASC, `su_creator_contact_id` ASC, `su_creator_contact_company_office_id` ASC, `su_creator_phone_contact_company_office_phone_number_id` ASC, `su_creator_fax_contact_company_office_phone_number_id` ASC, `su_creator_contact_mobile_phone_number_id` ASC, `su_recipient_contact_id` ASC, `su_recipient_contact_company_office_id` ASC, `su_recipient_phone_contact_company_office_phone_number_id` ASC, `su_recipient_fax_contact_company_office_phone_number_id` ASC, `su_recipient_contact_mobile_phone_number_id` ASC, `su_initiator_contact_id` ASC, `su_initiator_contact_company_office_id` ASC, `su_initiator_phone_contact_company_office_phone_number_id` ASC, `su_initiator_fax_contact_company_office_phone_number_id` ASC, `su_initiator_contact_mobile_phone_number_id` ASC, `su_title` ASC, `su_plan_page_reference` ASC, `su_statement` ASC, `su_due_date` ASC
		$arrValues = array($su_creator_fax_contact_company_office_phone_number_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubmittalDraftsBySuCreatorFaxContactCompanyOfficePhoneNumberId = array();
		while ($row = $db->fetch()) {
			$submittal_draft_id = $row['id'];
			$submittalDraft = self::instantiateOrm($database, 'SubmittalDraft', $row, null, $submittal_draft_id);
			/* @var $submittalDraft SubmittalDraft */
			$arrSubmittalDraftsBySuCreatorFaxContactCompanyOfficePhoneNumberId[$submittal_draft_id] = $submittalDraft;
		}

		$db->free_result();

		self::$_arrSubmittalDraftsBySuCreatorFaxContactCompanyOfficePhoneNumberId = $arrSubmittalDraftsBySuCreatorFaxContactCompanyOfficePhoneNumberId;

		return $arrSubmittalDraftsBySuCreatorFaxContactCompanyOfficePhoneNumberId;
	}

	/**
	 * Load by constraint `submittal_drafts_fk_creator_c_mobile_cpn` foreign key (`su_creator_contact_mobile_phone_number_id`) references `contact_phone_numbers` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $su_creator_contact_mobile_phone_number_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubmittalDraftsBySuCreatorContactMobilePhoneNumberId($database, $su_creator_contact_mobile_phone_number_id, Input $options=null)
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
			self::$_arrSubmittalDraftsBySuCreatorContactMobilePhoneNumberId = null;
		}

		$arrSubmittalDraftsBySuCreatorContactMobilePhoneNumberId = self::$_arrSubmittalDraftsBySuCreatorContactMobilePhoneNumberId;
		if (isset($arrSubmittalDraftsBySuCreatorContactMobilePhoneNumberId) && !empty($arrSubmittalDraftsBySuCreatorContactMobilePhoneNumberId)) {
			return $arrSubmittalDraftsBySuCreatorContactMobilePhoneNumberId;
		}

		$su_creator_contact_mobile_phone_number_id = (int) $su_creator_contact_mobile_phone_number_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `submittal_type_id` ASC, `submittal_priority_id` ASC, `submittal_distribution_method_id` ASC, `su_file_manager_file_id` ASC, `su_cost_code_id` ASC, `su_creator_contact_id` ASC, `su_creator_contact_company_office_id` ASC, `su_creator_phone_contact_company_office_phone_number_id` ASC, `su_creator_fax_contact_company_office_phone_number_id` ASC, `su_creator_contact_mobile_phone_number_id` ASC, `su_recipient_contact_id` ASC, `su_recipient_contact_company_office_id` ASC, `su_recipient_phone_contact_company_office_phone_number_id` ASC, `su_recipient_fax_contact_company_office_phone_number_id` ASC, `su_recipient_contact_mobile_phone_number_id` ASC, `su_initiator_contact_id` ASC, `su_initiator_contact_company_office_id` ASC, `su_initiator_phone_contact_company_office_phone_number_id` ASC, `su_initiator_fax_contact_company_office_phone_number_id` ASC, `su_initiator_contact_mobile_phone_number_id` ASC, `su_title` ASC, `su_plan_page_reference` ASC, `su_statement` ASC, `su_due_date` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubmittalDraft = new SubmittalDraft($database);
			$sqlOrderByColumns = $tmpSubmittalDraft->constructSqlOrderByColumns($arrOrderByAttributes);

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
	sud.*

FROM `submittal_drafts` sud
WHERE sud.`su_creator_contact_mobile_phone_number_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `submittal_type_id` ASC, `submittal_priority_id` ASC, `submittal_distribution_method_id` ASC, `su_file_manager_file_id` ASC, `su_cost_code_id` ASC, `su_creator_contact_id` ASC, `su_creator_contact_company_office_id` ASC, `su_creator_phone_contact_company_office_phone_number_id` ASC, `su_creator_fax_contact_company_office_phone_number_id` ASC, `su_creator_contact_mobile_phone_number_id` ASC, `su_recipient_contact_id` ASC, `su_recipient_contact_company_office_id` ASC, `su_recipient_phone_contact_company_office_phone_number_id` ASC, `su_recipient_fax_contact_company_office_phone_number_id` ASC, `su_recipient_contact_mobile_phone_number_id` ASC, `su_initiator_contact_id` ASC, `su_initiator_contact_company_office_id` ASC, `su_initiator_phone_contact_company_office_phone_number_id` ASC, `su_initiator_fax_contact_company_office_phone_number_id` ASC, `su_initiator_contact_mobile_phone_number_id` ASC, `su_title` ASC, `su_plan_page_reference` ASC, `su_statement` ASC, `su_due_date` ASC
		$arrValues = array($su_creator_contact_mobile_phone_number_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubmittalDraftsBySuCreatorContactMobilePhoneNumberId = array();
		while ($row = $db->fetch()) {
			$submittal_draft_id = $row['id'];
			$submittalDraft = self::instantiateOrm($database, 'SubmittalDraft', $row, null, $submittal_draft_id);
			/* @var $submittalDraft SubmittalDraft */
			$arrSubmittalDraftsBySuCreatorContactMobilePhoneNumberId[$submittal_draft_id] = $submittalDraft;
		}

		$db->free_result();

		self::$_arrSubmittalDraftsBySuCreatorContactMobilePhoneNumberId = $arrSubmittalDraftsBySuCreatorContactMobilePhoneNumberId;

		return $arrSubmittalDraftsBySuCreatorContactMobilePhoneNumberId;
	}

	/**
	 * Load by constraint `submittal_drafts_fk_recipient_c` foreign key (`su_recipient_contact_id`) references `contacts` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $su_recipient_contact_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubmittalDraftsBySuRecipientContactId($database, $su_recipient_contact_id, Input $options=null)
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
			self::$_arrSubmittalDraftsBySuRecipientContactId = null;
		}

		$arrSubmittalDraftsBySuRecipientContactId = self::$_arrSubmittalDraftsBySuRecipientContactId;
		if (isset($arrSubmittalDraftsBySuRecipientContactId) && !empty($arrSubmittalDraftsBySuRecipientContactId)) {
			return $arrSubmittalDraftsBySuRecipientContactId;
		}

		$su_recipient_contact_id = (int) $su_recipient_contact_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `submittal_type_id` ASC, `submittal_priority_id` ASC, `submittal_distribution_method_id` ASC, `su_file_manager_file_id` ASC, `su_cost_code_id` ASC, `su_creator_contact_id` ASC, `su_creator_contact_company_office_id` ASC, `su_creator_phone_contact_company_office_phone_number_id` ASC, `su_creator_fax_contact_company_office_phone_number_id` ASC, `su_creator_contact_mobile_phone_number_id` ASC, `su_recipient_contact_id` ASC, `su_recipient_contact_company_office_id` ASC, `su_recipient_phone_contact_company_office_phone_number_id` ASC, `su_recipient_fax_contact_company_office_phone_number_id` ASC, `su_recipient_contact_mobile_phone_number_id` ASC, `su_initiator_contact_id` ASC, `su_initiator_contact_company_office_id` ASC, `su_initiator_phone_contact_company_office_phone_number_id` ASC, `su_initiator_fax_contact_company_office_phone_number_id` ASC, `su_initiator_contact_mobile_phone_number_id` ASC, `su_title` ASC, `su_plan_page_reference` ASC, `su_statement` ASC, `su_due_date` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubmittalDraft = new SubmittalDraft($database);
			$sqlOrderByColumns = $tmpSubmittalDraft->constructSqlOrderByColumns($arrOrderByAttributes);

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
	sud.*

FROM `submittal_drafts` sud
WHERE sud.`su_recipient_contact_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `submittal_type_id` ASC, `submittal_priority_id` ASC, `submittal_distribution_method_id` ASC, `su_file_manager_file_id` ASC, `su_cost_code_id` ASC, `su_creator_contact_id` ASC, `su_creator_contact_company_office_id` ASC, `su_creator_phone_contact_company_office_phone_number_id` ASC, `su_creator_fax_contact_company_office_phone_number_id` ASC, `su_creator_contact_mobile_phone_number_id` ASC, `su_recipient_contact_id` ASC, `su_recipient_contact_company_office_id` ASC, `su_recipient_phone_contact_company_office_phone_number_id` ASC, `su_recipient_fax_contact_company_office_phone_number_id` ASC, `su_recipient_contact_mobile_phone_number_id` ASC, `su_initiator_contact_id` ASC, `su_initiator_contact_company_office_id` ASC, `su_initiator_phone_contact_company_office_phone_number_id` ASC, `su_initiator_fax_contact_company_office_phone_number_id` ASC, `su_initiator_contact_mobile_phone_number_id` ASC, `su_title` ASC, `su_plan_page_reference` ASC, `su_statement` ASC, `su_due_date` ASC
		$arrValues = array($su_recipient_contact_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubmittalDraftsBySuRecipientContactId = array();
		while ($row = $db->fetch()) {
			$submittal_draft_id = $row['id'];
			$submittalDraft = self::instantiateOrm($database, 'SubmittalDraft', $row, null, $submittal_draft_id);
			/* @var $submittalDraft SubmittalDraft */
			$arrSubmittalDraftsBySuRecipientContactId[$submittal_draft_id] = $submittalDraft;
		}

		$db->free_result();

		self::$_arrSubmittalDraftsBySuRecipientContactId = $arrSubmittalDraftsBySuRecipientContactId;

		return $arrSubmittalDraftsBySuRecipientContactId;
	}

	/**
	 * Load by constraint `submittal_drafts_fk_recipient_cco` foreign key (`su_recipient_contact_company_office_id`) references `contact_company_offices` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $su_recipient_contact_company_office_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubmittalDraftsBySuRecipientContactCompanyOfficeId($database, $su_recipient_contact_company_office_id, Input $options=null)
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
			self::$_arrSubmittalDraftsBySuRecipientContactCompanyOfficeId = null;
		}

		$arrSubmittalDraftsBySuRecipientContactCompanyOfficeId = self::$_arrSubmittalDraftsBySuRecipientContactCompanyOfficeId;
		if (isset($arrSubmittalDraftsBySuRecipientContactCompanyOfficeId) && !empty($arrSubmittalDraftsBySuRecipientContactCompanyOfficeId)) {
			return $arrSubmittalDraftsBySuRecipientContactCompanyOfficeId;
		}

		$su_recipient_contact_company_office_id = (int) $su_recipient_contact_company_office_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `submittal_type_id` ASC, `submittal_priority_id` ASC, `submittal_distribution_method_id` ASC, `su_file_manager_file_id` ASC, `su_cost_code_id` ASC, `su_creator_contact_id` ASC, `su_creator_contact_company_office_id` ASC, `su_creator_phone_contact_company_office_phone_number_id` ASC, `su_creator_fax_contact_company_office_phone_number_id` ASC, `su_creator_contact_mobile_phone_number_id` ASC, `su_recipient_contact_id` ASC, `su_recipient_contact_company_office_id` ASC, `su_recipient_phone_contact_company_office_phone_number_id` ASC, `su_recipient_fax_contact_company_office_phone_number_id` ASC, `su_recipient_contact_mobile_phone_number_id` ASC, `su_initiator_contact_id` ASC, `su_initiator_contact_company_office_id` ASC, `su_initiator_phone_contact_company_office_phone_number_id` ASC, `su_initiator_fax_contact_company_office_phone_number_id` ASC, `su_initiator_contact_mobile_phone_number_id` ASC, `su_title` ASC, `su_plan_page_reference` ASC, `su_statement` ASC, `su_due_date` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubmittalDraft = new SubmittalDraft($database);
			$sqlOrderByColumns = $tmpSubmittalDraft->constructSqlOrderByColumns($arrOrderByAttributes);

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
	sud.*

FROM `submittal_drafts` sud
WHERE sud.`su_recipient_contact_company_office_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `submittal_type_id` ASC, `submittal_priority_id` ASC, `submittal_distribution_method_id` ASC, `su_file_manager_file_id` ASC, `su_cost_code_id` ASC, `su_creator_contact_id` ASC, `su_creator_contact_company_office_id` ASC, `su_creator_phone_contact_company_office_phone_number_id` ASC, `su_creator_fax_contact_company_office_phone_number_id` ASC, `su_creator_contact_mobile_phone_number_id` ASC, `su_recipient_contact_id` ASC, `su_recipient_contact_company_office_id` ASC, `su_recipient_phone_contact_company_office_phone_number_id` ASC, `su_recipient_fax_contact_company_office_phone_number_id` ASC, `su_recipient_contact_mobile_phone_number_id` ASC, `su_initiator_contact_id` ASC, `su_initiator_contact_company_office_id` ASC, `su_initiator_phone_contact_company_office_phone_number_id` ASC, `su_initiator_fax_contact_company_office_phone_number_id` ASC, `su_initiator_contact_mobile_phone_number_id` ASC, `su_title` ASC, `su_plan_page_reference` ASC, `su_statement` ASC, `su_due_date` ASC
		$arrValues = array($su_recipient_contact_company_office_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubmittalDraftsBySuRecipientContactCompanyOfficeId = array();
		while ($row = $db->fetch()) {
			$submittal_draft_id = $row['id'];
			$submittalDraft = self::instantiateOrm($database, 'SubmittalDraft', $row, null, $submittal_draft_id);
			/* @var $submittalDraft SubmittalDraft */
			$arrSubmittalDraftsBySuRecipientContactCompanyOfficeId[$submittal_draft_id] = $submittalDraft;
		}

		$db->free_result();

		self::$_arrSubmittalDraftsBySuRecipientContactCompanyOfficeId = $arrSubmittalDraftsBySuRecipientContactCompanyOfficeId;

		return $arrSubmittalDraftsBySuRecipientContactCompanyOfficeId;
	}

	/**
	 * Load by constraint `submittal_drafts_fk_recipient_phone_ccopn` foreign key (`su_recipient_phone_contact_company_office_phone_number_id`) references `contact_company_office_phone_numbers` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $su_recipient_phone_contact_company_office_phone_number_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubmittalDraftsBySuRecipientPhoneContactCompanyOfficePhoneNumberId($database, $su_recipient_phone_contact_company_office_phone_number_id, Input $options=null)
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
			self::$_arrSubmittalDraftsBySuRecipientPhoneContactCompanyOfficePhoneNumberId = null;
		}

		$arrSubmittalDraftsBySuRecipientPhoneContactCompanyOfficePhoneNumberId = self::$_arrSubmittalDraftsBySuRecipientPhoneContactCompanyOfficePhoneNumberId;
		if (isset($arrSubmittalDraftsBySuRecipientPhoneContactCompanyOfficePhoneNumberId) && !empty($arrSubmittalDraftsBySuRecipientPhoneContactCompanyOfficePhoneNumberId)) {
			return $arrSubmittalDraftsBySuRecipientPhoneContactCompanyOfficePhoneNumberId;
		}

		$su_recipient_phone_contact_company_office_phone_number_id = (int) $su_recipient_phone_contact_company_office_phone_number_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `submittal_type_id` ASC, `submittal_priority_id` ASC, `submittal_distribution_method_id` ASC, `su_file_manager_file_id` ASC, `su_cost_code_id` ASC, `su_creator_contact_id` ASC, `su_creator_contact_company_office_id` ASC, `su_creator_phone_contact_company_office_phone_number_id` ASC, `su_creator_fax_contact_company_office_phone_number_id` ASC, `su_creator_contact_mobile_phone_number_id` ASC, `su_recipient_contact_id` ASC, `su_recipient_contact_company_office_id` ASC, `su_recipient_phone_contact_company_office_phone_number_id` ASC, `su_recipient_fax_contact_company_office_phone_number_id` ASC, `su_recipient_contact_mobile_phone_number_id` ASC, `su_initiator_contact_id` ASC, `su_initiator_contact_company_office_id` ASC, `su_initiator_phone_contact_company_office_phone_number_id` ASC, `su_initiator_fax_contact_company_office_phone_number_id` ASC, `su_initiator_contact_mobile_phone_number_id` ASC, `su_title` ASC, `su_plan_page_reference` ASC, `su_statement` ASC, `su_due_date` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubmittalDraft = new SubmittalDraft($database);
			$sqlOrderByColumns = $tmpSubmittalDraft->constructSqlOrderByColumns($arrOrderByAttributes);

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
	sud.*

FROM `submittal_drafts` sud
WHERE sud.`su_recipient_phone_contact_company_office_phone_number_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `submittal_type_id` ASC, `submittal_priority_id` ASC, `submittal_distribution_method_id` ASC, `su_file_manager_file_id` ASC, `su_cost_code_id` ASC, `su_creator_contact_id` ASC, `su_creator_contact_company_office_id` ASC, `su_creator_phone_contact_company_office_phone_number_id` ASC, `su_creator_fax_contact_company_office_phone_number_id` ASC, `su_creator_contact_mobile_phone_number_id` ASC, `su_recipient_contact_id` ASC, `su_recipient_contact_company_office_id` ASC, `su_recipient_phone_contact_company_office_phone_number_id` ASC, `su_recipient_fax_contact_company_office_phone_number_id` ASC, `su_recipient_contact_mobile_phone_number_id` ASC, `su_initiator_contact_id` ASC, `su_initiator_contact_company_office_id` ASC, `su_initiator_phone_contact_company_office_phone_number_id` ASC, `su_initiator_fax_contact_company_office_phone_number_id` ASC, `su_initiator_contact_mobile_phone_number_id` ASC, `su_title` ASC, `su_plan_page_reference` ASC, `su_statement` ASC, `su_due_date` ASC
		$arrValues = array($su_recipient_phone_contact_company_office_phone_number_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubmittalDraftsBySuRecipientPhoneContactCompanyOfficePhoneNumberId = array();
		while ($row = $db->fetch()) {
			$submittal_draft_id = $row['id'];
			$submittalDraft = self::instantiateOrm($database, 'SubmittalDraft', $row, null, $submittal_draft_id);
			/* @var $submittalDraft SubmittalDraft */
			$arrSubmittalDraftsBySuRecipientPhoneContactCompanyOfficePhoneNumberId[$submittal_draft_id] = $submittalDraft;
		}

		$db->free_result();

		self::$_arrSubmittalDraftsBySuRecipientPhoneContactCompanyOfficePhoneNumberId = $arrSubmittalDraftsBySuRecipientPhoneContactCompanyOfficePhoneNumberId;

		return $arrSubmittalDraftsBySuRecipientPhoneContactCompanyOfficePhoneNumberId;
	}

	/**
	 * Load by constraint `submittal_drafts_fk_recipient_fax_ccopn` foreign key (`su_recipient_fax_contact_company_office_phone_number_id`) references `contact_company_office_phone_numbers` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $su_recipient_fax_contact_company_office_phone_number_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubmittalDraftsBySuRecipientFaxContactCompanyOfficePhoneNumberId($database, $su_recipient_fax_contact_company_office_phone_number_id, Input $options=null)
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
			self::$_arrSubmittalDraftsBySuRecipientFaxContactCompanyOfficePhoneNumberId = null;
		}

		$arrSubmittalDraftsBySuRecipientFaxContactCompanyOfficePhoneNumberId = self::$_arrSubmittalDraftsBySuRecipientFaxContactCompanyOfficePhoneNumberId;
		if (isset($arrSubmittalDraftsBySuRecipientFaxContactCompanyOfficePhoneNumberId) && !empty($arrSubmittalDraftsBySuRecipientFaxContactCompanyOfficePhoneNumberId)) {
			return $arrSubmittalDraftsBySuRecipientFaxContactCompanyOfficePhoneNumberId;
		}

		$su_recipient_fax_contact_company_office_phone_number_id = (int) $su_recipient_fax_contact_company_office_phone_number_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `submittal_type_id` ASC, `submittal_priority_id` ASC, `submittal_distribution_method_id` ASC, `su_file_manager_file_id` ASC, `su_cost_code_id` ASC, `su_creator_contact_id` ASC, `su_creator_contact_company_office_id` ASC, `su_creator_phone_contact_company_office_phone_number_id` ASC, `su_creator_fax_contact_company_office_phone_number_id` ASC, `su_creator_contact_mobile_phone_number_id` ASC, `su_recipient_contact_id` ASC, `su_recipient_contact_company_office_id` ASC, `su_recipient_phone_contact_company_office_phone_number_id` ASC, `su_recipient_fax_contact_company_office_phone_number_id` ASC, `su_recipient_contact_mobile_phone_number_id` ASC, `su_initiator_contact_id` ASC, `su_initiator_contact_company_office_id` ASC, `su_initiator_phone_contact_company_office_phone_number_id` ASC, `su_initiator_fax_contact_company_office_phone_number_id` ASC, `su_initiator_contact_mobile_phone_number_id` ASC, `su_title` ASC, `su_plan_page_reference` ASC, `su_statement` ASC, `su_due_date` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubmittalDraft = new SubmittalDraft($database);
			$sqlOrderByColumns = $tmpSubmittalDraft->constructSqlOrderByColumns($arrOrderByAttributes);

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
	sud.*

FROM `submittal_drafts` sud
WHERE sud.`su_recipient_fax_contact_company_office_phone_number_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `submittal_type_id` ASC, `submittal_priority_id` ASC, `submittal_distribution_method_id` ASC, `su_file_manager_file_id` ASC, `su_cost_code_id` ASC, `su_creator_contact_id` ASC, `su_creator_contact_company_office_id` ASC, `su_creator_phone_contact_company_office_phone_number_id` ASC, `su_creator_fax_contact_company_office_phone_number_id` ASC, `su_creator_contact_mobile_phone_number_id` ASC, `su_recipient_contact_id` ASC, `su_recipient_contact_company_office_id` ASC, `su_recipient_phone_contact_company_office_phone_number_id` ASC, `su_recipient_fax_contact_company_office_phone_number_id` ASC, `su_recipient_contact_mobile_phone_number_id` ASC, `su_initiator_contact_id` ASC, `su_initiator_contact_company_office_id` ASC, `su_initiator_phone_contact_company_office_phone_number_id` ASC, `su_initiator_fax_contact_company_office_phone_number_id` ASC, `su_initiator_contact_mobile_phone_number_id` ASC, `su_title` ASC, `su_plan_page_reference` ASC, `su_statement` ASC, `su_due_date` ASC
		$arrValues = array($su_recipient_fax_contact_company_office_phone_number_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubmittalDraftsBySuRecipientFaxContactCompanyOfficePhoneNumberId = array();
		while ($row = $db->fetch()) {
			$submittal_draft_id = $row['id'];
			$submittalDraft = self::instantiateOrm($database, 'SubmittalDraft', $row, null, $submittal_draft_id);
			/* @var $submittalDraft SubmittalDraft */
			$arrSubmittalDraftsBySuRecipientFaxContactCompanyOfficePhoneNumberId[$submittal_draft_id] = $submittalDraft;
		}

		$db->free_result();

		self::$_arrSubmittalDraftsBySuRecipientFaxContactCompanyOfficePhoneNumberId = $arrSubmittalDraftsBySuRecipientFaxContactCompanyOfficePhoneNumberId;

		return $arrSubmittalDraftsBySuRecipientFaxContactCompanyOfficePhoneNumberId;
	}

	/**
	 * Load by constraint `submittal_drafts_fk_recipient_c_mobile_cpn` foreign key (`su_recipient_contact_mobile_phone_number_id`) references `contact_phone_numbers` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $su_recipient_contact_mobile_phone_number_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubmittalDraftsBySuRecipientContactMobilePhoneNumberId($database, $su_recipient_contact_mobile_phone_number_id, Input $options=null)
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
			self::$_arrSubmittalDraftsBySuRecipientContactMobilePhoneNumberId = null;
		}

		$arrSubmittalDraftsBySuRecipientContactMobilePhoneNumberId = self::$_arrSubmittalDraftsBySuRecipientContactMobilePhoneNumberId;
		if (isset($arrSubmittalDraftsBySuRecipientContactMobilePhoneNumberId) && !empty($arrSubmittalDraftsBySuRecipientContactMobilePhoneNumberId)) {
			return $arrSubmittalDraftsBySuRecipientContactMobilePhoneNumberId;
		}

		$su_recipient_contact_mobile_phone_number_id = (int) $su_recipient_contact_mobile_phone_number_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `submittal_type_id` ASC, `submittal_priority_id` ASC, `submittal_distribution_method_id` ASC, `su_file_manager_file_id` ASC, `su_cost_code_id` ASC, `su_creator_contact_id` ASC, `su_creator_contact_company_office_id` ASC, `su_creator_phone_contact_company_office_phone_number_id` ASC, `su_creator_fax_contact_company_office_phone_number_id` ASC, `su_creator_contact_mobile_phone_number_id` ASC, `su_recipient_contact_id` ASC, `su_recipient_contact_company_office_id` ASC, `su_recipient_phone_contact_company_office_phone_number_id` ASC, `su_recipient_fax_contact_company_office_phone_number_id` ASC, `su_recipient_contact_mobile_phone_number_id` ASC, `su_initiator_contact_id` ASC, `su_initiator_contact_company_office_id` ASC, `su_initiator_phone_contact_company_office_phone_number_id` ASC, `su_initiator_fax_contact_company_office_phone_number_id` ASC, `su_initiator_contact_mobile_phone_number_id` ASC, `su_title` ASC, `su_plan_page_reference` ASC, `su_statement` ASC, `su_due_date` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubmittalDraft = new SubmittalDraft($database);
			$sqlOrderByColumns = $tmpSubmittalDraft->constructSqlOrderByColumns($arrOrderByAttributes);

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
	sud.*

FROM `submittal_drafts` sud
WHERE sud.`su_recipient_contact_mobile_phone_number_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `submittal_type_id` ASC, `submittal_priority_id` ASC, `submittal_distribution_method_id` ASC, `su_file_manager_file_id` ASC, `su_cost_code_id` ASC, `su_creator_contact_id` ASC, `su_creator_contact_company_office_id` ASC, `su_creator_phone_contact_company_office_phone_number_id` ASC, `su_creator_fax_contact_company_office_phone_number_id` ASC, `su_creator_contact_mobile_phone_number_id` ASC, `su_recipient_contact_id` ASC, `su_recipient_contact_company_office_id` ASC, `su_recipient_phone_contact_company_office_phone_number_id` ASC, `su_recipient_fax_contact_company_office_phone_number_id` ASC, `su_recipient_contact_mobile_phone_number_id` ASC, `su_initiator_contact_id` ASC, `su_initiator_contact_company_office_id` ASC, `su_initiator_phone_contact_company_office_phone_number_id` ASC, `su_initiator_fax_contact_company_office_phone_number_id` ASC, `su_initiator_contact_mobile_phone_number_id` ASC, `su_title` ASC, `su_plan_page_reference` ASC, `su_statement` ASC, `su_due_date` ASC
		$arrValues = array($su_recipient_contact_mobile_phone_number_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubmittalDraftsBySuRecipientContactMobilePhoneNumberId = array();
		while ($row = $db->fetch()) {
			$submittal_draft_id = $row['id'];
			$submittalDraft = self::instantiateOrm($database, 'SubmittalDraft', $row, null, $submittal_draft_id);
			/* @var $submittalDraft SubmittalDraft */
			$arrSubmittalDraftsBySuRecipientContactMobilePhoneNumberId[$submittal_draft_id] = $submittalDraft;
		}

		$db->free_result();

		self::$_arrSubmittalDraftsBySuRecipientContactMobilePhoneNumberId = $arrSubmittalDraftsBySuRecipientContactMobilePhoneNumberId;

		return $arrSubmittalDraftsBySuRecipientContactMobilePhoneNumberId;
	}

	/**
	 * Load by constraint `submittal_drafts_fk_initiator_c` foreign key (`su_initiator_contact_id`) references `contacts` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $su_initiator_contact_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubmittalDraftsBySuInitiatorContactId($database, $su_initiator_contact_id, Input $options=null)
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
			self::$_arrSubmittalDraftsBySuInitiatorContactId = null;
		}

		$arrSubmittalDraftsBySuInitiatorContactId = self::$_arrSubmittalDraftsBySuInitiatorContactId;
		if (isset($arrSubmittalDraftsBySuInitiatorContactId) && !empty($arrSubmittalDraftsBySuInitiatorContactId)) {
			return $arrSubmittalDraftsBySuInitiatorContactId;
		}

		$su_initiator_contact_id = (int) $su_initiator_contact_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `submittal_type_id` ASC, `submittal_priority_id` ASC, `submittal_distribution_method_id` ASC, `su_file_manager_file_id` ASC, `su_cost_code_id` ASC, `su_creator_contact_id` ASC, `su_creator_contact_company_office_id` ASC, `su_creator_phone_contact_company_office_phone_number_id` ASC, `su_creator_fax_contact_company_office_phone_number_id` ASC, `su_creator_contact_mobile_phone_number_id` ASC, `su_recipient_contact_id` ASC, `su_recipient_contact_company_office_id` ASC, `su_recipient_phone_contact_company_office_phone_number_id` ASC, `su_recipient_fax_contact_company_office_phone_number_id` ASC, `su_recipient_contact_mobile_phone_number_id` ASC, `su_initiator_contact_id` ASC, `su_initiator_contact_company_office_id` ASC, `su_initiator_phone_contact_company_office_phone_number_id` ASC, `su_initiator_fax_contact_company_office_phone_number_id` ASC, `su_initiator_contact_mobile_phone_number_id` ASC, `su_title` ASC, `su_plan_page_reference` ASC, `su_statement` ASC, `su_due_date` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubmittalDraft = new SubmittalDraft($database);
			$sqlOrderByColumns = $tmpSubmittalDraft->constructSqlOrderByColumns($arrOrderByAttributes);

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
	sud.*

FROM `submittal_drafts` sud
WHERE sud.`su_initiator_contact_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `submittal_type_id` ASC, `submittal_priority_id` ASC, `submittal_distribution_method_id` ASC, `su_file_manager_file_id` ASC, `su_cost_code_id` ASC, `su_creator_contact_id` ASC, `su_creator_contact_company_office_id` ASC, `su_creator_phone_contact_company_office_phone_number_id` ASC, `su_creator_fax_contact_company_office_phone_number_id` ASC, `su_creator_contact_mobile_phone_number_id` ASC, `su_recipient_contact_id` ASC, `su_recipient_contact_company_office_id` ASC, `su_recipient_phone_contact_company_office_phone_number_id` ASC, `su_recipient_fax_contact_company_office_phone_number_id` ASC, `su_recipient_contact_mobile_phone_number_id` ASC, `su_initiator_contact_id` ASC, `su_initiator_contact_company_office_id` ASC, `su_initiator_phone_contact_company_office_phone_number_id` ASC, `su_initiator_fax_contact_company_office_phone_number_id` ASC, `su_initiator_contact_mobile_phone_number_id` ASC, `su_title` ASC, `su_plan_page_reference` ASC, `su_statement` ASC, `su_due_date` ASC
		$arrValues = array($su_initiator_contact_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubmittalDraftsBySuInitiatorContactId = array();
		while ($row = $db->fetch()) {
			$submittal_draft_id = $row['id'];
			$submittalDraft = self::instantiateOrm($database, 'SubmittalDraft', $row, null, $submittal_draft_id);
			/* @var $submittalDraft SubmittalDraft */
			$arrSubmittalDraftsBySuInitiatorContactId[$submittal_draft_id] = $submittalDraft;
		}

		$db->free_result();

		self::$_arrSubmittalDraftsBySuInitiatorContactId = $arrSubmittalDraftsBySuInitiatorContactId;

		return $arrSubmittalDraftsBySuInitiatorContactId;
	}

	/**
	 * Load by constraint `submittal_drafts_fk_initiator_cco` foreign key (`su_initiator_contact_company_office_id`) references `contact_company_offices` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $su_initiator_contact_company_office_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubmittalDraftsBySuInitiatorContactCompanyOfficeId($database, $su_initiator_contact_company_office_id, Input $options=null)
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
			self::$_arrSubmittalDraftsBySuInitiatorContactCompanyOfficeId = null;
		}

		$arrSubmittalDraftsBySuInitiatorContactCompanyOfficeId = self::$_arrSubmittalDraftsBySuInitiatorContactCompanyOfficeId;
		if (isset($arrSubmittalDraftsBySuInitiatorContactCompanyOfficeId) && !empty($arrSubmittalDraftsBySuInitiatorContactCompanyOfficeId)) {
			return $arrSubmittalDraftsBySuInitiatorContactCompanyOfficeId;
		}

		$su_initiator_contact_company_office_id = (int) $su_initiator_contact_company_office_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `submittal_type_id` ASC, `submittal_priority_id` ASC, `submittal_distribution_method_id` ASC, `su_file_manager_file_id` ASC, `su_cost_code_id` ASC, `su_creator_contact_id` ASC, `su_creator_contact_company_office_id` ASC, `su_creator_phone_contact_company_office_phone_number_id` ASC, `su_creator_fax_contact_company_office_phone_number_id` ASC, `su_creator_contact_mobile_phone_number_id` ASC, `su_recipient_contact_id` ASC, `su_recipient_contact_company_office_id` ASC, `su_recipient_phone_contact_company_office_phone_number_id` ASC, `su_recipient_fax_contact_company_office_phone_number_id` ASC, `su_recipient_contact_mobile_phone_number_id` ASC, `su_initiator_contact_id` ASC, `su_initiator_contact_company_office_id` ASC, `su_initiator_phone_contact_company_office_phone_number_id` ASC, `su_initiator_fax_contact_company_office_phone_number_id` ASC, `su_initiator_contact_mobile_phone_number_id` ASC, `su_title` ASC, `su_plan_page_reference` ASC, `su_statement` ASC, `su_due_date` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubmittalDraft = new SubmittalDraft($database);
			$sqlOrderByColumns = $tmpSubmittalDraft->constructSqlOrderByColumns($arrOrderByAttributes);

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
	sud.*

FROM `submittal_drafts` sud
WHERE sud.`su_initiator_contact_company_office_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `submittal_type_id` ASC, `submittal_priority_id` ASC, `submittal_distribution_method_id` ASC, `su_file_manager_file_id` ASC, `su_cost_code_id` ASC, `su_creator_contact_id` ASC, `su_creator_contact_company_office_id` ASC, `su_creator_phone_contact_company_office_phone_number_id` ASC, `su_creator_fax_contact_company_office_phone_number_id` ASC, `su_creator_contact_mobile_phone_number_id` ASC, `su_recipient_contact_id` ASC, `su_recipient_contact_company_office_id` ASC, `su_recipient_phone_contact_company_office_phone_number_id` ASC, `su_recipient_fax_contact_company_office_phone_number_id` ASC, `su_recipient_contact_mobile_phone_number_id` ASC, `su_initiator_contact_id` ASC, `su_initiator_contact_company_office_id` ASC, `su_initiator_phone_contact_company_office_phone_number_id` ASC, `su_initiator_fax_contact_company_office_phone_number_id` ASC, `su_initiator_contact_mobile_phone_number_id` ASC, `su_title` ASC, `su_plan_page_reference` ASC, `su_statement` ASC, `su_due_date` ASC
		$arrValues = array($su_initiator_contact_company_office_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubmittalDraftsBySuInitiatorContactCompanyOfficeId = array();
		while ($row = $db->fetch()) {
			$submittal_draft_id = $row['id'];
			$submittalDraft = self::instantiateOrm($database, 'SubmittalDraft', $row, null, $submittal_draft_id);
			/* @var $submittalDraft SubmittalDraft */
			$arrSubmittalDraftsBySuInitiatorContactCompanyOfficeId[$submittal_draft_id] = $submittalDraft;
		}

		$db->free_result();

		self::$_arrSubmittalDraftsBySuInitiatorContactCompanyOfficeId = $arrSubmittalDraftsBySuInitiatorContactCompanyOfficeId;

		return $arrSubmittalDraftsBySuInitiatorContactCompanyOfficeId;
	}

	/**
	 * Load by constraint `submittal_drafts_fk_initiator_phone_ccopn` foreign key (`su_initiator_phone_contact_company_office_phone_number_id`) references `contact_company_office_phone_numbers` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $su_initiator_phone_contact_company_office_phone_number_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubmittalDraftsBySuInitiatorPhoneContactCompanyOfficePhoneNumberId($database, $su_initiator_phone_contact_company_office_phone_number_id, Input $options=null)
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
			self::$_arrSubmittalDraftsBySuInitiatorPhoneContactCompanyOfficePhoneNumberId = null;
		}

		$arrSubmittalDraftsBySuInitiatorPhoneContactCompanyOfficePhoneNumberId = self::$_arrSubmittalDraftsBySuInitiatorPhoneContactCompanyOfficePhoneNumberId;
		if (isset($arrSubmittalDraftsBySuInitiatorPhoneContactCompanyOfficePhoneNumberId) && !empty($arrSubmittalDraftsBySuInitiatorPhoneContactCompanyOfficePhoneNumberId)) {
			return $arrSubmittalDraftsBySuInitiatorPhoneContactCompanyOfficePhoneNumberId;
		}

		$su_initiator_phone_contact_company_office_phone_number_id = (int) $su_initiator_phone_contact_company_office_phone_number_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `submittal_type_id` ASC, `submittal_priority_id` ASC, `submittal_distribution_method_id` ASC, `su_file_manager_file_id` ASC, `su_cost_code_id` ASC, `su_creator_contact_id` ASC, `su_creator_contact_company_office_id` ASC, `su_creator_phone_contact_company_office_phone_number_id` ASC, `su_creator_fax_contact_company_office_phone_number_id` ASC, `su_creator_contact_mobile_phone_number_id` ASC, `su_recipient_contact_id` ASC, `su_recipient_contact_company_office_id` ASC, `su_recipient_phone_contact_company_office_phone_number_id` ASC, `su_recipient_fax_contact_company_office_phone_number_id` ASC, `su_recipient_contact_mobile_phone_number_id` ASC, `su_initiator_contact_id` ASC, `su_initiator_contact_company_office_id` ASC, `su_initiator_phone_contact_company_office_phone_number_id` ASC, `su_initiator_fax_contact_company_office_phone_number_id` ASC, `su_initiator_contact_mobile_phone_number_id` ASC, `su_title` ASC, `su_plan_page_reference` ASC, `su_statement` ASC, `su_due_date` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubmittalDraft = new SubmittalDraft($database);
			$sqlOrderByColumns = $tmpSubmittalDraft->constructSqlOrderByColumns($arrOrderByAttributes);

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
	sud.*

FROM `submittal_drafts` sud
WHERE sud.`su_initiator_phone_contact_company_office_phone_number_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `submittal_type_id` ASC, `submittal_priority_id` ASC, `submittal_distribution_method_id` ASC, `su_file_manager_file_id` ASC, `su_cost_code_id` ASC, `su_creator_contact_id` ASC, `su_creator_contact_company_office_id` ASC, `su_creator_phone_contact_company_office_phone_number_id` ASC, `su_creator_fax_contact_company_office_phone_number_id` ASC, `su_creator_contact_mobile_phone_number_id` ASC, `su_recipient_contact_id` ASC, `su_recipient_contact_company_office_id` ASC, `su_recipient_phone_contact_company_office_phone_number_id` ASC, `su_recipient_fax_contact_company_office_phone_number_id` ASC, `su_recipient_contact_mobile_phone_number_id` ASC, `su_initiator_contact_id` ASC, `su_initiator_contact_company_office_id` ASC, `su_initiator_phone_contact_company_office_phone_number_id` ASC, `su_initiator_fax_contact_company_office_phone_number_id` ASC, `su_initiator_contact_mobile_phone_number_id` ASC, `su_title` ASC, `su_plan_page_reference` ASC, `su_statement` ASC, `su_due_date` ASC
		$arrValues = array($su_initiator_phone_contact_company_office_phone_number_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubmittalDraftsBySuInitiatorPhoneContactCompanyOfficePhoneNumberId = array();
		while ($row = $db->fetch()) {
			$submittal_draft_id = $row['id'];
			$submittalDraft = self::instantiateOrm($database, 'SubmittalDraft', $row, null, $submittal_draft_id);
			/* @var $submittalDraft SubmittalDraft */
			$arrSubmittalDraftsBySuInitiatorPhoneContactCompanyOfficePhoneNumberId[$submittal_draft_id] = $submittalDraft;
		}

		$db->free_result();

		self::$_arrSubmittalDraftsBySuInitiatorPhoneContactCompanyOfficePhoneNumberId = $arrSubmittalDraftsBySuInitiatorPhoneContactCompanyOfficePhoneNumberId;

		return $arrSubmittalDraftsBySuInitiatorPhoneContactCompanyOfficePhoneNumberId;
	}

	/**
	 * Load by constraint `submittal_drafts_fk_initiator_fax_ccopn` foreign key (`su_initiator_fax_contact_company_office_phone_number_id`) references `contact_company_office_phone_numbers` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $su_initiator_fax_contact_company_office_phone_number_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubmittalDraftsBySuInitiatorFaxContactCompanyOfficePhoneNumberId($database, $su_initiator_fax_contact_company_office_phone_number_id, Input $options=null)
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
			self::$_arrSubmittalDraftsBySuInitiatorFaxContactCompanyOfficePhoneNumberId = null;
		}

		$arrSubmittalDraftsBySuInitiatorFaxContactCompanyOfficePhoneNumberId = self::$_arrSubmittalDraftsBySuInitiatorFaxContactCompanyOfficePhoneNumberId;
		if (isset($arrSubmittalDraftsBySuInitiatorFaxContactCompanyOfficePhoneNumberId) && !empty($arrSubmittalDraftsBySuInitiatorFaxContactCompanyOfficePhoneNumberId)) {
			return $arrSubmittalDraftsBySuInitiatorFaxContactCompanyOfficePhoneNumberId;
		}

		$su_initiator_fax_contact_company_office_phone_number_id = (int) $su_initiator_fax_contact_company_office_phone_number_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `submittal_type_id` ASC, `submittal_priority_id` ASC, `submittal_distribution_method_id` ASC, `su_file_manager_file_id` ASC, `su_cost_code_id` ASC, `su_creator_contact_id` ASC, `su_creator_contact_company_office_id` ASC, `su_creator_phone_contact_company_office_phone_number_id` ASC, `su_creator_fax_contact_company_office_phone_number_id` ASC, `su_creator_contact_mobile_phone_number_id` ASC, `su_recipient_contact_id` ASC, `su_recipient_contact_company_office_id` ASC, `su_recipient_phone_contact_company_office_phone_number_id` ASC, `su_recipient_fax_contact_company_office_phone_number_id` ASC, `su_recipient_contact_mobile_phone_number_id` ASC, `su_initiator_contact_id` ASC, `su_initiator_contact_company_office_id` ASC, `su_initiator_phone_contact_company_office_phone_number_id` ASC, `su_initiator_fax_contact_company_office_phone_number_id` ASC, `su_initiator_contact_mobile_phone_number_id` ASC, `su_title` ASC, `su_plan_page_reference` ASC, `su_statement` ASC, `su_due_date` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubmittalDraft = new SubmittalDraft($database);
			$sqlOrderByColumns = $tmpSubmittalDraft->constructSqlOrderByColumns($arrOrderByAttributes);

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
	sud.*

FROM `submittal_drafts` sud
WHERE sud.`su_initiator_fax_contact_company_office_phone_number_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `submittal_type_id` ASC, `submittal_priority_id` ASC, `submittal_distribution_method_id` ASC, `su_file_manager_file_id` ASC, `su_cost_code_id` ASC, `su_creator_contact_id` ASC, `su_creator_contact_company_office_id` ASC, `su_creator_phone_contact_company_office_phone_number_id` ASC, `su_creator_fax_contact_company_office_phone_number_id` ASC, `su_creator_contact_mobile_phone_number_id` ASC, `su_recipient_contact_id` ASC, `su_recipient_contact_company_office_id` ASC, `su_recipient_phone_contact_company_office_phone_number_id` ASC, `su_recipient_fax_contact_company_office_phone_number_id` ASC, `su_recipient_contact_mobile_phone_number_id` ASC, `su_initiator_contact_id` ASC, `su_initiator_contact_company_office_id` ASC, `su_initiator_phone_contact_company_office_phone_number_id` ASC, `su_initiator_fax_contact_company_office_phone_number_id` ASC, `su_initiator_contact_mobile_phone_number_id` ASC, `su_title` ASC, `su_plan_page_reference` ASC, `su_statement` ASC, `su_due_date` ASC
		$arrValues = array($su_initiator_fax_contact_company_office_phone_number_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubmittalDraftsBySuInitiatorFaxContactCompanyOfficePhoneNumberId = array();
		while ($row = $db->fetch()) {
			$submittal_draft_id = $row['id'];
			$submittalDraft = self::instantiateOrm($database, 'SubmittalDraft', $row, null, $submittal_draft_id);
			/* @var $submittalDraft SubmittalDraft */
			$arrSubmittalDraftsBySuInitiatorFaxContactCompanyOfficePhoneNumberId[$submittal_draft_id] = $submittalDraft;
		}

		$db->free_result();

		self::$_arrSubmittalDraftsBySuInitiatorFaxContactCompanyOfficePhoneNumberId = $arrSubmittalDraftsBySuInitiatorFaxContactCompanyOfficePhoneNumberId;

		return $arrSubmittalDraftsBySuInitiatorFaxContactCompanyOfficePhoneNumberId;
	}

	/**
	 * Load by constraint `submittal_drafts_fk_initiator_c_mobile_cpn` foreign key (`su_initiator_contact_mobile_phone_number_id`) references `contact_phone_numbers` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $su_initiator_contact_mobile_phone_number_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubmittalDraftsBySuInitiatorContactMobilePhoneNumberId($database, $su_initiator_contact_mobile_phone_number_id, Input $options=null)
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
			self::$_arrSubmittalDraftsBySuInitiatorContactMobilePhoneNumberId = null;
		}

		$arrSubmittalDraftsBySuInitiatorContactMobilePhoneNumberId = self::$_arrSubmittalDraftsBySuInitiatorContactMobilePhoneNumberId;
		if (isset($arrSubmittalDraftsBySuInitiatorContactMobilePhoneNumberId) && !empty($arrSubmittalDraftsBySuInitiatorContactMobilePhoneNumberId)) {
			return $arrSubmittalDraftsBySuInitiatorContactMobilePhoneNumberId;
		}

		$su_initiator_contact_mobile_phone_number_id = (int) $su_initiator_contact_mobile_phone_number_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `submittal_type_id` ASC, `submittal_priority_id` ASC, `submittal_distribution_method_id` ASC, `su_file_manager_file_id` ASC, `su_cost_code_id` ASC, `su_creator_contact_id` ASC, `su_creator_contact_company_office_id` ASC, `su_creator_phone_contact_company_office_phone_number_id` ASC, `su_creator_fax_contact_company_office_phone_number_id` ASC, `su_creator_contact_mobile_phone_number_id` ASC, `su_recipient_contact_id` ASC, `su_recipient_contact_company_office_id` ASC, `su_recipient_phone_contact_company_office_phone_number_id` ASC, `su_recipient_fax_contact_company_office_phone_number_id` ASC, `su_recipient_contact_mobile_phone_number_id` ASC, `su_initiator_contact_id` ASC, `su_initiator_contact_company_office_id` ASC, `su_initiator_phone_contact_company_office_phone_number_id` ASC, `su_initiator_fax_contact_company_office_phone_number_id` ASC, `su_initiator_contact_mobile_phone_number_id` ASC, `su_title` ASC, `su_plan_page_reference` ASC, `su_statement` ASC, `su_due_date` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubmittalDraft = new SubmittalDraft($database);
			$sqlOrderByColumns = $tmpSubmittalDraft->constructSqlOrderByColumns($arrOrderByAttributes);

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
	sud.*

FROM `submittal_drafts` sud
WHERE sud.`su_initiator_contact_mobile_phone_number_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `submittal_type_id` ASC, `submittal_priority_id` ASC, `submittal_distribution_method_id` ASC, `su_file_manager_file_id` ASC, `su_cost_code_id` ASC, `su_creator_contact_id` ASC, `su_creator_contact_company_office_id` ASC, `su_creator_phone_contact_company_office_phone_number_id` ASC, `su_creator_fax_contact_company_office_phone_number_id` ASC, `su_creator_contact_mobile_phone_number_id` ASC, `su_recipient_contact_id` ASC, `su_recipient_contact_company_office_id` ASC, `su_recipient_phone_contact_company_office_phone_number_id` ASC, `su_recipient_fax_contact_company_office_phone_number_id` ASC, `su_recipient_contact_mobile_phone_number_id` ASC, `su_initiator_contact_id` ASC, `su_initiator_contact_company_office_id` ASC, `su_initiator_phone_contact_company_office_phone_number_id` ASC, `su_initiator_fax_contact_company_office_phone_number_id` ASC, `su_initiator_contact_mobile_phone_number_id` ASC, `su_title` ASC, `su_plan_page_reference` ASC, `su_statement` ASC, `su_due_date` ASC
		$arrValues = array($su_initiator_contact_mobile_phone_number_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubmittalDraftsBySuInitiatorContactMobilePhoneNumberId = array();
		while ($row = $db->fetch()) {
			$submittal_draft_id = $row['id'];
			$submittalDraft = self::instantiateOrm($database, 'SubmittalDraft', $row, null, $submittal_draft_id);
			/* @var $submittalDraft SubmittalDraft */
			$arrSubmittalDraftsBySuInitiatorContactMobilePhoneNumberId[$submittal_draft_id] = $submittalDraft;
		}

		$db->free_result();

		self::$_arrSubmittalDraftsBySuInitiatorContactMobilePhoneNumberId = $arrSubmittalDraftsBySuInitiatorContactMobilePhoneNumberId;

		return $arrSubmittalDraftsBySuInitiatorContactMobilePhoneNumberId;
	}

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all submittal_drafts records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllSubmittalDrafts($database, Input $options=null)
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
			self::$_arrAllSubmittalDrafts = null;
		}

		$arrAllSubmittalDrafts = self::$_arrAllSubmittalDrafts;
		if (isset($arrAllSubmittalDrafts) && !empty($arrAllSubmittalDrafts)) {
			return $arrAllSubmittalDrafts;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `project_id` ASC, `submittal_type_id` ASC, `submittal_priority_id` ASC, `submittal_distribution_method_id` ASC, `su_file_manager_file_id` ASC, `su_cost_code_id` ASC, `su_creator_contact_id` ASC, `su_creator_contact_company_office_id` ASC, `su_creator_phone_contact_company_office_phone_number_id` ASC, `su_creator_fax_contact_company_office_phone_number_id` ASC, `su_creator_contact_mobile_phone_number_id` ASC, `su_recipient_contact_id` ASC, `su_recipient_contact_company_office_id` ASC, `su_recipient_phone_contact_company_office_phone_number_id` ASC, `su_recipient_fax_contact_company_office_phone_number_id` ASC, `su_recipient_contact_mobile_phone_number_id` ASC, `su_initiator_contact_id` ASC, `su_initiator_contact_company_office_id` ASC, `su_initiator_phone_contact_company_office_phone_number_id` ASC, `su_initiator_fax_contact_company_office_phone_number_id` ASC, `su_initiator_contact_mobile_phone_number_id` ASC, `su_title` ASC, `su_plan_page_reference` ASC, `su_statement` ASC, `su_due_date` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubmittalDraft = new SubmittalDraft($database);
			$sqlOrderByColumns = $tmpSubmittalDraft->constructSqlOrderByColumns($arrOrderByAttributes);

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
	sud.*

FROM `submittal_drafts` sud{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `project_id` ASC, `submittal_type_id` ASC, `submittal_priority_id` ASC, `submittal_distribution_method_id` ASC, `su_file_manager_file_id` ASC, `su_cost_code_id` ASC, `su_creator_contact_id` ASC, `su_creator_contact_company_office_id` ASC, `su_creator_phone_contact_company_office_phone_number_id` ASC, `su_creator_fax_contact_company_office_phone_number_id` ASC, `su_creator_contact_mobile_phone_number_id` ASC, `su_recipient_contact_id` ASC, `su_recipient_contact_company_office_id` ASC, `su_recipient_phone_contact_company_office_phone_number_id` ASC, `su_recipient_fax_contact_company_office_phone_number_id` ASC, `su_recipient_contact_mobile_phone_number_id` ASC, `su_initiator_contact_id` ASC, `su_initiator_contact_company_office_id` ASC, `su_initiator_phone_contact_company_office_phone_number_id` ASC, `su_initiator_fax_contact_company_office_phone_number_id` ASC, `su_initiator_contact_mobile_phone_number_id` ASC, `su_title` ASC, `su_plan_page_reference` ASC, `su_statement` ASC, `su_due_date` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllSubmittalDrafts = array();
		while ($row = $db->fetch()) {
			$submittal_draft_id = $row['id'];
			$submittalDraft = self::instantiateOrm($database, 'SubmittalDraft', $row, null, $submittal_draft_id);
			/* @var $submittalDraft SubmittalDraft */
			$arrAllSubmittalDrafts[$submittal_draft_id] = $submittalDraft;
		}

		$db->free_result();

		self::$_arrAllSubmittalDrafts = $arrAllSubmittalDrafts;

		return $arrAllSubmittalDrafts;
	}

	// Save: insert on duplicate key update

	// Save: insert ignore
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

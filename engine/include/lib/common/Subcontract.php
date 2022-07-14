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
 * Subcontract.
 *
 * @category   Framework
 * @package    Subcontract
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class Subcontract extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'Subcontract';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'subcontracts';

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
	 * unique index `unique_subcontract` (`gc_budget_line_item_id`,`subcontract_sequence_number`) comment 'One Cost Code can have many subcontracts for a project'
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_subcontract' => array(
			'gc_budget_line_item_id' => 'int',
			'subcontract_sequence_number' => 'int'
		)
	);

	/**
	 * Required attributes list for "Creation" of a new record.
	 *
	 * Key - database attribute/field
	 * Value - object property
	 *
	 * @var array
	 */
	protected $arrRequiredAttributes = array(
		'gc_budget_line_item_id' => 'gc_budget_line_item_id',
		'subcontract_sequence_number' => 'subcontract_sequence_number',
		'subcontractor_bid_id' => 'subcontractor_bid_id',
		'subcontract_template_id' => 'subcontract_template_id',
		'vendor_id' => 'vendor_id',
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
		'id' => 'subcontract_id',

		'gc_budget_line_item_id' => 'gc_budget_line_item_id',
		'subcontract_sequence_number' => 'subcontract_sequence_number',

		'subcontractor_bid_id' => 'subcontractor_bid_id',
		'subcontract_template_id' => 'subcontract_template_id',
		'subcontract_gc_contact_company_office_id' => 'subcontract_gc_contact_company_office_id',
		'subcontract_gc_phone_contact_company_office_phone_number_id' => 'subcontract_gc_phone_contact_company_office_phone_number_id',
		'subcontract_gc_fax_contact_company_office_phone_number_id' => 'subcontract_gc_fax_contact_company_office_phone_number_id',
		'subcontract_gc_contact_id' => 'subcontract_gc_contact_id',
		'gc_signatory' => 'gc_signatory',
		'subcontract_gc_contact_mobile_phone_number_id' => 'subcontract_gc_contact_mobile_phone_number_id',
		'vendor_id' => 'vendor_id',
		'subcontract_vendor_contact_company_office_id' => 'subcontract_vendor_contact_company_office_id',
		'subcontract_vendor_phone_contact_company_office_phone_number_id' => 'subcontract_vendor_phone_contact_company_office_phone_number_id',
		'subcontract_vendor_fax_contact_company_office_phone_number_id' => 'subcontract_vendor_fax_contact_company_office_phone_number_id',
		'subcontract_vendor_contact_id' => 'subcontract_vendor_contact_id',
		'vendor_signatory' => 'vendor_signatory',
		'subcontract_vendor_contact_mobile_phone_number_id' => 'subcontract_vendor_contact_mobile_phone_number_id',
		'unsigned_subcontract_file_manager_file_id' => 'unsigned_subcontract_file_manager_file_id',
		'signed_subcontract_file_manager_file_id' => 'signed_subcontract_file_manager_file_id',

		'subcontract_forecasted_value' => 'subcontract_forecasted_value',
		'subcontract_actual_value' => 'subcontract_actual_value',
		'subcontract_retention_percentage' => 'subcontract_retention_percentage',
		'subcontract_issued_date' => 'subcontract_issued_date',
		'subcontract_target_execution_date' => 'subcontract_target_execution_date',
		'subcontract_execution_date' => 'subcontract_execution_date',
		'subcontract_mailed_date' => 'subcontract_mailed_date',
		'general_insurance_file_id' =>'general_insurance_file_id',
		'worker_file_id'=>'worker_file_id',
		'car_insurance_file_id' => 'car_insurance_file_id',
		'city_license_file_id'=>'city_license_file_id',
		'general_insurance_date_expiry' =>'general_insurance_date_expiry',
		'worker_date_expiry' =>'worker_date_expiry',
		'car_insurance_date_expiry' => 'car_insurance_date_expiry',
		'city_license_date_expiry'=>'city_license_date_expiry',
		'send_back_date'=>'send_back_date',
		'send_back'=>'send_back',
		'active_flag' => 'active_flag',
		'is_dcr_flag' => 'is_dcr_flag'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $subcontract_id;

	public $gc_budget_line_item_id;
	public $subcontract_sequence_number;

	public $subcontractor_bid_id;
	public $subcontract_template_id;
	public $subcontract_gc_contact_company_office_id;
	public $subcontract_gc_phone_contact_company_office_phone_number_id;
	public $subcontract_gc_fax_contact_company_office_phone_number_id;
	public $subcontract_gc_contact_id;
	public $gc_signatory;
	public $subcontract_gc_contact_mobile_phone_number_id;
	public $vendor_id;
	public $subcontract_vendor_contact_company_office_id;
	public $subcontract_vendor_phone_contact_company_office_phone_number_id;
	public $subcontract_vendor_fax_contact_company_office_phone_number_id;
	public $subcontract_vendor_contact_id;
	public $vendor_signatory;
	public $subcontract_vendor_contact_mobile_phone_number_id;
	public $unsigned_subcontract_file_manager_file_id;
	public $signed_subcontract_file_manager_file_id;

	public $subcontract_forecasted_value;
	public $subcontract_actual_value;
	public $subcontract_retention_percentage;
	public $subcontract_issued_date;
	public $subcontract_target_execution_date;
	public $subcontract_execution_date;
	public $subcontract_mailed_date;
	public $general_insurance_file_id;
	public $worker_file_id;
	public $car_insurance_file_id;
	public $city_license_file_id;
	public $general_insurance_date_expiry;
	public $worker_date_expiry;
	public $car_insurance_date_expiry;
	public $city_license_date_expiry;

	public $send_back_date;
	public $send_back;

	public $active_flag;
	public $is_dcr_flag;

	// Other Properties
	//protected $_otherPropertyHere;
	public $subcontract_type;
	protected $_formattedSubcontractTargetExecutionDate;

	// HTML ENTITY ENCODED ORM string properties

	// HTML ENTITY ENCODED NL2BR ORM string properties

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)
	protected static $_arrSubcontractsByGcBudgetLineItemId;
	protected static $_arrSubcontractsBySubcontractorBidId;
	protected static $_arrSubcontractsBySubcontractTemplateId;
	protected static $_arrSubcontractsBySubcontractGcContactCompanyOfficeId;
	protected static $_arrSubcontractsBySubcontractGcPhoneContactCompanyOfficePhoneNumberId;
	protected static $_arrSubcontractsBySubcontractGcFaxContactCompanyOfficePhoneNumberId;
	protected static $_arrSubcontractsBySubcontractGcContactId;
	protected static $_arrSubcontractsBySubcontractGcContactMobilePhoneNumberId;
	protected static $_arrSubcontractsByVendorId;
	protected static $_arrSubcontractsBySubcontractVendorContactCompanyOfficeId;
	protected static $_arrSubcontractsBySubcontractVendorPhoneContactCompanyOfficePhoneNumberId;
	protected static $_arrSubcontractsBySubcontractVendorFaxContactCompanyOfficePhoneNumberId;
	protected static $_arrSubcontractsBySubcontractVendorContactId;
	protected static $_arrSubcontractsBySubcontractVendorContactMobilePhoneNumberId;
	protected static $_arrSubcontractsByUnsignedSubcontractFileManagerFileId;
	protected static $_arrSubcontractsBySignedSubcontractFileManagerFileId;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllSubcontracts;
	protected static $_arrSubcontractsByProjectId;

	// Foreign Key Objects
	private $_gcBudgetLineItem;
	private $_subcontractorBid;
	private $_subcontractTemplate;
	private $_subcontractGcContactCompanyOffice;
	private $_subcontractGcPhoneContactCompanyOfficePhoneNumber;
	private $_subcontractGcFaxContactCompanyOfficePhoneNumber;
	private $_subcontractGcContact;
	private $_subcontractGcContactMobilePhoneNumber;
	private $_vendor;
	private $_subcontractVendorContactCompanyOffice;
	private $_subcontractVendorPhoneContactCompanyOfficePhoneNumber;
	private $_subcontractVendorFaxContactCompanyOfficePhoneNumber;
	private $_subcontractVendorContact;
	private $_subcontractVendorContactMobilePhoneNumber;
	private $_unsignedSubcontractFileManagerFile;
	private $_signedSubcontractFileManagerFile;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='subcontracts')
	{
		parent::__construct($table);
		$this->setDatabase($database);
	}

	// Foreign Key Object Accessor Methods
	public function getGcBudgetLineItem()
	{
		if (isset($this->_gcBudgetLineItem)) {
			return $this->_gcBudgetLineItem;
		} else {
			return null;
		}
	}

	public function setGcBudgetLineItem($gcBudgetLineItem)
	{
		$this->_gcBudgetLineItem = $gcBudgetLineItem;
	}

	public function getSubcontractorBid()
	{
		if (isset($this->_subcontractorBid)) {
			return $this->_subcontractorBid;
		} else {
			return null;
		}
	}

	public function setSubcontractorBid($subcontractorBid)
	{
		$this->_subcontractorBid = $subcontractorBid;
	}

	public function getSubcontractTemplate()
	{
		if (isset($this->_subcontractTemplate)) {
			return $this->_subcontractTemplate;
		} else {
			return null;
		}
	}

	public function setSubcontractTemplate($subcontractTemplate)
	{
		$this->_subcontractTemplate = $subcontractTemplate;
	}

	public function getSubcontractGcContactCompanyOffice()
	{
		if (isset($this->_subcontractGcContactCompanyOffice)) {
			return $this->_subcontractGcContactCompanyOffice;
		} else {
			return null;
		}
	}

	public function setSubcontractGcContactCompanyOffice($subcontractGcContactCompanyOffice)
	{
		$this->_subcontractGcContactCompanyOffice = $subcontractGcContactCompanyOffice;
	}

	public function getSubcontractGcPhoneContactCompanyOfficePhoneNumber()
	{
		if (isset($this->_subcontractGcPhoneContactCompanyOfficePhoneNumber)) {
			return $this->_subcontractGcPhoneContactCompanyOfficePhoneNumber;
		} else {
			return null;
		}
	}

	public function setSubcontractGcPhoneContactCompanyOfficePhoneNumber($subcontractGcPhoneContactCompanyOfficePhoneNumber)
	{
		$this->_subcontractGcPhoneContactCompanyOfficePhoneNumber = $subcontractGcPhoneContactCompanyOfficePhoneNumber;
	}

	public function getSubcontractGcFaxContactCompanyOfficePhoneNumber()
	{
		if (isset($this->_subcontractGcFaxContactCompanyOfficePhoneNumber)) {
			return $this->_subcontractGcFaxContactCompanyOfficePhoneNumber;
		} else {
			return null;
		}
	}

	public function setSubcontractGcFaxContactCompanyOfficePhoneNumber($subcontractGcFaxContactCompanyOfficePhoneNumber)
	{
		$this->_subcontractGcFaxContactCompanyOfficePhoneNumber = $subcontractGcFaxContactCompanyOfficePhoneNumber;
	}

	public function getSubcontractGcContact()
	{
		if (isset($this->_subcontractGcContact)) {
			return $this->_subcontractGcContact;
		} else {
			return null;
		}
	}

	public function setSubcontractGcContact($subcontractGcContact)
	{
		$this->_subcontractGcContact = $subcontractGcContact;
	}

	public function getSubcontractGcContactMobilePhoneNumber()
	{
		if (isset($this->_subcontractGcContactMobilePhoneNumber)) {
			return $this->_subcontractGcContactMobilePhoneNumber;
		} else {
			return null;
		}
	}

	public function setSubcontractGcContactMobilePhoneNumber($subcontractGcContactMobilePhoneNumber)
	{
		$this->_subcontractGcContactMobilePhoneNumber = $subcontractGcContactMobilePhoneNumber;
	}

	public function getVendor()
	{
		if (isset($this->_vendor)) {
			return $this->_vendor;
		} else {
			return null;
		}
	}

	public function setVendor($vendor)
	{
		$this->_vendor = $vendor;
	}

	public function getSubcontractVendorContactCompanyOffice()
	{
		if (isset($this->_subcontractVendorContactCompanyOffice)) {
			return $this->_subcontractVendorContactCompanyOffice;
		} else {
			return null;
		}
	}

	public function setSubcontractVendorContactCompanyOffice($subcontractVendorContactCompanyOffice)
	{
		$this->_subcontractVendorContactCompanyOffice = $subcontractVendorContactCompanyOffice;
	}

	public function getSubcontractVendorPhoneContactCompanyOfficePhoneNumber()
	{
		if (isset($this->_subcontractVendorPhoneContactCompanyOfficePhoneNumber)) {
			return $this->_subcontractVendorPhoneContactCompanyOfficePhoneNumber;
		} else {
			return null;
		}
	}

	public function setSubcontractVendorPhoneContactCompanyOfficePhoneNumber($subcontractVendorPhoneContactCompanyOfficePhoneNumber)
	{
		$this->_subcontractVendorPhoneContactCompanyOfficePhoneNumber = $subcontractVendorPhoneContactCompanyOfficePhoneNumber;
	}

	public function getSubcontractVendorFaxContactCompanyOfficePhoneNumber()
	{
		if (isset($this->_subcontractVendorFaxContactCompanyOfficePhoneNumber)) {
			return $this->_subcontractVendorFaxContactCompanyOfficePhoneNumber;
		} else {
			return null;
		}
	}

	public function setSubcontractVendorFaxContactCompanyOfficePhoneNumber($subcontractVendorFaxContactCompanyOfficePhoneNumber)
	{
		$this->_subcontractVendorFaxContactCompanyOfficePhoneNumber = $subcontractVendorFaxContactCompanyOfficePhoneNumber;
	}

	public function getSubcontractVendorContact()
	{
		if (isset($this->_subcontractVendorContact)) {
			return $this->_subcontractVendorContact;
		} else {
			return null;
		}
	}

	public function setSubcontractVendorContact($subcontractVendorContact)
	{
		$this->_subcontractVendorContact = $subcontractVendorContact;
	}

	public function getSubcontractVendorContactMobilePhoneNumber()
	{
		if (isset($this->_subcontractVendorContactMobilePhoneNumber)) {
			return $this->_subcontractVendorContactMobilePhoneNumber;
		} else {
			return null;
		}
	}

	public function setSubcontractVendorContactMobilePhoneNumber($subcontractVendorContactMobilePhoneNumber)
	{
		$this->_subcontractVendorContactMobilePhoneNumber = $subcontractVendorContactMobilePhoneNumber;
	}

	public function getUnsignedSubcontractFileManagerFile()
	{
		if (isset($this->_unsignedSubcontractFileManagerFile)) {
			return $this->_unsignedSubcontractFileManagerFile;
		} else {
			return null;
		}
	}

	public function setUnsignedSubcontractFileManagerFile($unsignedSubcontractFileManagerFile)
	{
		$this->_unsignedSubcontractFileManagerFile = $unsignedSubcontractFileManagerFile;
	}

	public function getSignedSubcontractFileManagerFile()
	{
		if (isset($this->_signedSubcontractFileManagerFile)) {
			return $this->_signedSubcontractFileManagerFile;
		} else {
			return null;
		}
	}

	public function setSignedSubcontractFileManagerFile($signedSubcontractFileManagerFile)
	{
		$this->_signedSubcontractFileManagerFile = $signedSubcontractFileManagerFile;
	}

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)
	public static function getArrSubcontractsByGcBudgetLineItemId()
	{
		if (isset(self::$_arrSubcontractsByGcBudgetLineItemId)) {
			return self::$_arrSubcontractsByGcBudgetLineItemId;
		} else {
			return null;
		}
	}

	public static function setArrSubcontractsByGcBudgetLineItemId($arrSubcontractsByGcBudgetLineItemId)
	{
		self::$_arrSubcontractsByGcBudgetLineItemId = $arrSubcontractsByGcBudgetLineItemId;
	}

	public static function getArrSubcontractsBySubcontractorBidId()
	{
		if (isset(self::$_arrSubcontractsBySubcontractorBidId)) {
			return self::$_arrSubcontractsBySubcontractorBidId;
		} else {
			return null;
		}
	}

	public static function setArrSubcontractsBySubcontractorBidId($arrSubcontractsBySubcontractorBidId)
	{
		self::$_arrSubcontractsBySubcontractorBidId = $arrSubcontractsBySubcontractorBidId;
	}

	public static function getArrSubcontractsBySubcontractTemplateId()
	{
		if (isset(self::$_arrSubcontractsBySubcontractTemplateId)) {
			return self::$_arrSubcontractsBySubcontractTemplateId;
		} else {
			return null;
		}
	}

	public static function setArrSubcontractsBySubcontractTemplateId($arrSubcontractsBySubcontractTemplateId)
	{
		self::$_arrSubcontractsBySubcontractTemplateId = $arrSubcontractsBySubcontractTemplateId;
	}

	public static function getArrSubcontractsBySubcontractGcContactCompanyOfficeId()
	{
		if (isset(self::$_arrSubcontractsBySubcontractGcContactCompanyOfficeId)) {
			return self::$_arrSubcontractsBySubcontractGcContactCompanyOfficeId;
		} else {
			return null;
		}
	}

	public static function setArrSubcontractsBySubcontractGcContactCompanyOfficeId($arrSubcontractsBySubcontractGcContactCompanyOfficeId)
	{
		self::$_arrSubcontractsBySubcontractGcContactCompanyOfficeId = $arrSubcontractsBySubcontractGcContactCompanyOfficeId;
	}

	public static function getArrSubcontractsBySubcontractGcPhoneContactCompanyOfficePhoneNumberId()
	{
		if (isset(self::$_arrSubcontractsBySubcontractGcPhoneContactCompanyOfficePhoneNumberId)) {
			return self::$_arrSubcontractsBySubcontractGcPhoneContactCompanyOfficePhoneNumberId;
		} else {
			return null;
		}
	}

	public static function setArrSubcontractsBySubcontractGcPhoneContactCompanyOfficePhoneNumberId($arrSubcontractsBySubcontractGcPhoneContactCompanyOfficePhoneNumberId)
	{
		self::$_arrSubcontractsBySubcontractGcPhoneContactCompanyOfficePhoneNumberId = $arrSubcontractsBySubcontractGcPhoneContactCompanyOfficePhoneNumberId;
	}

	public static function getArrSubcontractsBySubcontractGcFaxContactCompanyOfficePhoneNumberId()
	{
		if (isset(self::$_arrSubcontractsBySubcontractGcFaxContactCompanyOfficePhoneNumberId)) {
			return self::$_arrSubcontractsBySubcontractGcFaxContactCompanyOfficePhoneNumberId;
		} else {
			return null;
		}
	}

	public static function setArrSubcontractsBySubcontractGcFaxContactCompanyOfficePhoneNumberId($arrSubcontractsBySubcontractGcFaxContactCompanyOfficePhoneNumberId)
	{
		self::$_arrSubcontractsBySubcontractGcFaxContactCompanyOfficePhoneNumberId = $arrSubcontractsBySubcontractGcFaxContactCompanyOfficePhoneNumberId;
	}

	public static function getArrSubcontractsBySubcontractGcContactId()
	{
		if (isset(self::$_arrSubcontractsBySubcontractGcContactId)) {
			return self::$_arrSubcontractsBySubcontractGcContactId;
		} else {
			return null;
		}
	}

	public static function setArrSubcontractsBySubcontractGcContactId($arrSubcontractsBySubcontractGcContactId)
	{
		self::$_arrSubcontractsBySubcontractGcContactId = $arrSubcontractsBySubcontractGcContactId;
	}

	public static function getArrSubcontractsBySubcontractGcContactMobilePhoneNumberId()
	{
		if (isset(self::$_arrSubcontractsBySubcontractGcContactMobilePhoneNumberId)) {
			return self::$_arrSubcontractsBySubcontractGcContactMobilePhoneNumberId;
		} else {
			return null;
		}
	}

	public static function setArrSubcontractsBySubcontractGcContactMobilePhoneNumberId($arrSubcontractsBySubcontractGcContactMobilePhoneNumberId)
	{
		self::$_arrSubcontractsBySubcontractGcContactMobilePhoneNumberId = $arrSubcontractsBySubcontractGcContactMobilePhoneNumberId;
	}

	public static function getArrSubcontractsByVendorId()
	{
		if (isset(self::$_arrSubcontractsByVendorId)) {
			return self::$_arrSubcontractsByVendorId;
		} else {
			return null;
		}
	}

	public static function setArrSubcontractsByVendorId($arrSubcontractsByVendorId)
	{
		self::$_arrSubcontractsByVendorId = $arrSubcontractsByVendorId;
	}

	public static function getArrSubcontractsBySubcontractVendorContactCompanyOfficeId()
	{
		if (isset(self::$_arrSubcontractsBySubcontractVendorContactCompanyOfficeId)) {
			return self::$_arrSubcontractsBySubcontractVendorContactCompanyOfficeId;
		} else {
			return null;
		}
	}

	public static function setArrSubcontractsBySubcontractVendorContactCompanyOfficeId($arrSubcontractsBySubcontractVendorContactCompanyOfficeId)
	{
		self::$_arrSubcontractsBySubcontractVendorContactCompanyOfficeId = $arrSubcontractsBySubcontractVendorContactCompanyOfficeId;
	}

	public static function getArrSubcontractsBySubcontractVendorPhoneContactCompanyOfficePhoneNumberId()
	{
		if (isset(self::$_arrSubcontractsBySubcontractVendorPhoneContactCompanyOfficePhoneNumberId)) {
			return self::$_arrSubcontractsBySubcontractVendorPhoneContactCompanyOfficePhoneNumberId;
		} else {
			return null;
		}
	}

	public static function setArrSubcontractsBySubcontractVendorPhoneContactCompanyOfficePhoneNumberId($arrSubcontractsBySubcontractVendorPhoneContactCompanyOfficePhoneNumberId)
	{
		self::$_arrSubcontractsBySubcontractVendorPhoneContactCompanyOfficePhoneNumberId = $arrSubcontractsBySubcontractVendorPhoneContactCompanyOfficePhoneNumberId;
	}

	public static function getArrSubcontractsBySubcontractVendorFaxContactCompanyOfficePhoneNumberId()
	{
		if (isset(self::$_arrSubcontractsBySubcontractVendorFaxContactCompanyOfficePhoneNumberId)) {
			return self::$_arrSubcontractsBySubcontractVendorFaxContactCompanyOfficePhoneNumberId;
		} else {
			return null;
		}
	}

	public static function setArrSubcontractsBySubcontractVendorFaxContactCompanyOfficePhoneNumberId($arrSubcontractsBySubcontractVendorFaxContactCompanyOfficePhoneNumberId)
	{
		self::$_arrSubcontractsBySubcontractVendorFaxContactCompanyOfficePhoneNumberId = $arrSubcontractsBySubcontractVendorFaxContactCompanyOfficePhoneNumberId;
	}

	public static function getArrSubcontractsBySubcontractVendorContactId()
	{
		if (isset(self::$_arrSubcontractsBySubcontractVendorContactId)) {
			return self::$_arrSubcontractsBySubcontractVendorContactId;
		} else {
			return null;
		}
	}

	public static function setArrSubcontractsBySubcontractVendorContactId($arrSubcontractsBySubcontractVendorContactId)
	{
		self::$_arrSubcontractsBySubcontractVendorContactId = $arrSubcontractsBySubcontractVendorContactId;
	}

	public static function getArrSubcontractsBySubcontractVendorContactMobilePhoneNumberId()
	{
		if (isset(self::$_arrSubcontractsBySubcontractVendorContactMobilePhoneNumberId)) {
			return self::$_arrSubcontractsBySubcontractVendorContactMobilePhoneNumberId;
		} else {
			return null;
		}
	}

	public static function setArrSubcontractsBySubcontractVendorContactMobilePhoneNumberId($arrSubcontractsBySubcontractVendorContactMobilePhoneNumberId)
	{
		self::$_arrSubcontractsBySubcontractVendorContactMobilePhoneNumberId = $arrSubcontractsBySubcontractVendorContactMobilePhoneNumberId;
	}

	public static function getArrSubcontractsByUnsignedSubcontractFileManagerFileId()
	{
		if (isset(self::$_arrSubcontractsByUnsignedSubcontractFileManagerFileId)) {
			return self::$_arrSubcontractsByUnsignedSubcontractFileManagerFileId;
		} else {
			return null;
		}
	}

	public static function setArrSubcontractsByUnsignedSubcontractFileManagerFileId($arrSubcontractsByUnsignedSubcontractFileManagerFileId)
	{
		self::$_arrSubcontractsByUnsignedSubcontractFileManagerFileId = $arrSubcontractsByUnsignedSubcontractFileManagerFileId;
	}

	public static function getArrSubcontractsBySignedSubcontractFileManagerFileId()
	{
		if (isset(self::$_arrSubcontractsBySignedSubcontractFileManagerFileId)) {
			return self::$_arrSubcontractsBySignedSubcontractFileManagerFileId;
		} else {
			return null;
		}
	}

	public static function setArrSubcontractsBySignedSubcontractFileManagerFileId($arrSubcontractsBySignedSubcontractFileManagerFileId)
	{
		self::$_arrSubcontractsBySignedSubcontractFileManagerFileId = $arrSubcontractsBySignedSubcontractFileManagerFileId;
	}

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllSubcontracts()
	{
		if (isset(self::$_arrAllSubcontracts)) {
			return self::$_arrAllSubcontracts;
		} else {
			return null;
		}
	}

	public static function setArrAllSubcontracts($arrAllSubcontracts)
	{
		self::$_arrAllSubcontracts = $arrAllSubcontracts;
	}

	public static function getArrSubcontractsByProjectId()
	{
		if (isset(self::$_arrSubcontractsByProjectId)) {
			return self::$_arrSubcontractsByProjectId;
		} else {
			return null;
		}
	}

	public static function setArrSubcontractsByProjectId($arrSubcontractsByProjectId)
	{
		self::$_arrSubcontractsByProjectId = $arrSubcontractsByProjectId;
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

	public function deriveFormattedSubcontractTargetExecutionDate()
	{
		$subcontract_target_execution_date = $this->subcontract_target_execution_date;

		if (isset($subcontract_target_execution_date) && !empty($subcontract_target_execution_date) && ($subcontract_target_execution_date != '0000-00-00')) {
			$unixTimestamp = strtotime($subcontract_target_execution_date);
			$formattedSubcontractTargetExecutionDate = date('m/d/Y', $unixTimestamp);
		} else {
			$formattedSubcontractTargetExecutionDate = '';
		}

		$this->_formattedSubcontractTargetExecutionDate = $formattedSubcontractTargetExecutionDate;

		return $formattedSubcontractTargetExecutionDate;
	}

	public function deriveFormattedSubcontractExecutionDate()
	{
		$subcontract_execution_date = $this->subcontract_execution_date;

		if (isset($subcontract_execution_date) && !empty($subcontract_execution_date) && ($subcontract_execution_date != '0000-00-00')) {
			$unixTimestamp = strtotime($subcontract_execution_date);
			$formattedSubcontractExecutionDate = date('m/d/y', $unixTimestamp);
		} else {
			$formattedSubcontractExecutionDate = '';
		}

		$this->_formattedSubcontractExecutionDate = $formattedSubcontractExecutionDate;

		return $formattedSubcontractExecutionDate;
	}
	
	//To get General Insurance date expiry
	public function deriveFormattedgeneralinsurancedateEXP()
	{
		$general_insurance_date_expiry = $this->general_insurance_date_expiry;

		if (isset($general_insurance_date_expiry) && !empty($general_insurance_date_expiry) && ($general_insurance_date_expiry != '0000-00-00')) {
			$unixTimestamp = strtotime($general_insurance_date_expiry);
			$formattedgeneralinsurancedateexp = date('m/d/y', $unixTimestamp);
		} else {
			$formattedgeneralinsurancedateexp = '';
		}

		$this->formattedgeneralinsurancedateexp = $formattedgeneralinsurancedateexp;

		return $formattedgeneralinsurancedateexp;
	}
	
	//To get Worker Insurance date expiry
	public function deriveFormattedworkerdateEXP()
	{
		$worker_date_expiry = $this->worker_date_expiry;

		if (isset($worker_date_expiry) && !empty($worker_date_expiry) && ($worker_date_expiry != '0000-00-00')) {
			$unixTimestamp = strtotime($worker_date_expiry);
			$formattedworkerdateEXP = date('m/d/y', $unixTimestamp);
		} else {
			$formattedworkerdateEXP = '';
		}

		$this->formattedworkerdateEXP = $formattedworkerdateEXP;

		return $formattedworkerdateEXP;
	}
	
	
	//To get car Insurance date expiry
	public function deriveFormattedcarinsurancedateEXP()
	{
		$car_insurance_date_expiry  = $this->car_insurance_date_expiry;

		if (isset($car_insurance_date_expiry) && !empty($car_insurance_date_expiry) && ($car_insurance_date_expiry != '0000-00-00')) {
			$unixTimestamp = strtotime($car_insurance_date_expiry);
			$formattedcarinsurancedateEXP = date('m/d/y', $unixTimestamp);
		} else {
			$formattedcarinsurancedateEXP = '';
		}

		$this->formattedcarinsurancedateEXP = $formattedcarinsurancedateEXP;

		return $formattedcarinsurancedateEXP;
	}
	
	//To get City License date expiry
	public function deriveFormattedcitylicensedateEXP()
	{
		$city_license_date_expiry  = $this->city_license_date_expiry;

		if (isset($city_license_date_expiry) && !empty($city_license_date_expiry) && ($city_license_date_expiry != '0000-00-00')) {
			$unixTimestamp = strtotime($city_license_date_expiry);
			$formattedcitylicensedateEXP = date('m/d/y', $unixTimestamp);
		} else {
			$formattedcitylicensedateEXP = '';
		}

		$this->formattedcitylicensedateEXP = $formattedcitylicensedateEXP;

		return $formattedcitylicensedateEXP;
	}
	//To get send back executed date
	public function deriveFormattedsendbackdate()
	{
		$send_back_date  = $this->send_back_date;

		if (isset($send_back_date) && !empty($send_back_date) && ($send_back_date != '0000-00-00')) {
			$unixTimestamp = strtotime($send_back_date);
			$Formattedsendbackdate = date('m/d/y', $unixTimestamp);
		} else {
			$Formattedsendbackdate = '';
		}

		$this->Formattedsendbackdate = $Formattedsendbackdate;

		return $Formattedsendbackdate;
	}
	public function deriveFormattedSubcontractMailedDate()
	{
		$subcontract_mailed_date = $this->subcontract_mailed_date;

		if (isset($subcontract_mailed_date) && !empty($subcontract_mailed_date) && ($subcontract_mailed_date != '0000-00-00')) {
			$unixTimestamp = strtotime($subcontract_mailed_date);
			$formattedSubcontractmailedDate = date('m/d/y', $unixTimestamp);
		} else {
			$formattedSubcontractmailedDate = '';
		}

		$this->_formattedSubcontractmailedDate = $formattedSubcontractmailedDate;

		return $formattedSubcontractmailedDate;
	}
public function deriveFormattedSubcontractTargetDate()
	{
		$subcontract_target_date = $this->subcontract_target_execution_date;

		if (isset($subcontract_target_date) && !empty($subcontract_target_date) && ($subcontract_target_date != '0000-00-00')) {
			$unixTimestamp = strtotime($subcontract_target_date);
			$formattedsubcontractTargetDate = date('m/d/y', $unixTimestamp);
		} else {
			$formattedsubcontractTargetDate = '';
		}

		$this->_formattedsubcontractTargetDate = $formattedsubcontractTargetDate;

		return $formattedsubcontractTargetDate;
	}

	public function getFormattedSubcontractTargetExecutionDate()
	{
		$formattedSubcontractTargetExecutionDate = $this->_formattedSubcontractTargetExecutionDate;

		if (!isset($this->_formattedSubcontractTargetExecutionDate)) {
			$formattedSubcontractTargetExecutionDate = $this->deriveFormattedSubcontractTargetExecutionDate();
		}

		return $formattedSubcontractTargetExecutionDate;
	}

	// Finder: Find By pk (a single auto int id or a single non auto int pk)
	/**
	 * PHP < 5.3.0
	 *
	 * @param string $database
	 * @param int $subcontract_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findById($database, $subcontract_id,$table='subcontracts', $module='Subcontract')
	{
		$subcontract = parent::findById($database, $subcontract_id,$table, $module);

		return $subcontract;
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Similar to FindById, but with SQL as starter code for more complex joins.
	 *
	 * @param string $database
	 * @param int $subcontract_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findSubcontractByIdExtended($database, $subcontract_id)
	{
		$subcontract_id = (int) $subcontract_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	s_fk_gbli.`id` AS 's_fk_gbli__gc_budget_line_item_id',
	s_fk_gbli.`user_company_id` AS 's_fk_gbli__user_company_id',
	s_fk_gbli.`project_id` AS 's_fk_gbli__project_id',
	s_fk_gbli.`cost_code_id` AS 's_fk_gbli__cost_code_id',
	s_fk_gbli.`modified` AS 's_fk_gbli__modified',
	s_fk_gbli.`prime_contract_scheduled_value` AS 's_fk_gbli__prime_contract_scheduled_value',
	s_fk_gbli.`forecasted_expenses` AS 's_fk_gbli__forecasted_expenses',
	s_fk_gbli.`created` AS 's_fk_gbli__created',
	s_fk_gbli.`sort_order` AS 's_fk_gbli__sort_order',
	s_fk_gbli.`disabled_flag` AS 's_fk_gbli__disabled_flag',

	s_fk_sb.`id` AS 's_fk_sb__subcontractor_bid_id',
	s_fk_sb.`gc_budget_line_item_id` AS 's_fk_sb__gc_budget_line_item_id',
	s_fk_sb.`subcontractor_contact_id` AS 's_fk_sb__subcontractor_contact_id',
	s_fk_sb.`subcontractor_bid_status_id` AS 's_fk_sb__subcontractor_bid_status_id',
	s_fk_sb.`sort_order` AS 's_fk_sb__sort_order',

	s_fk_st.`id` AS 's_fk_st__subcontract_template_id',
	s_fk_st.`user_company_id` AS 's_fk_st__user_company_id',
	s_fk_st.`subcontract_type_id` AS 's_fk_st__subcontract_type_id',
	s_fk_st.`subcontract_template_name` AS 's_fk_st__subcontract_template_name',
	s_fk_st.`sort_order` AS 's_fk_st__sort_order',
	s_fk_st.`disabled_flag` AS 's_fk_st__disabled_flag',

	s_fk_gc_cco.`id` AS 's_fk_gc_cco__contact_company_office_id',
	s_fk_gc_cco.`contact_company_id` AS 's_fk_gc_cco__contact_company_id',
	s_fk_gc_cco.`office_nickname` AS 's_fk_gc_cco__office_nickname',
	s_fk_gc_cco.`address_line_1` AS 's_fk_gc_cco__address_line_1',
	s_fk_gc_cco.`address_line_2` AS 's_fk_gc_cco__address_line_2',
	s_fk_gc_cco.`address_line_3` AS 's_fk_gc_cco__address_line_3',
	s_fk_gc_cco.`address_line_4` AS 's_fk_gc_cco__address_line_4',
	s_fk_gc_cco.`address_city` AS 's_fk_gc_cco__address_city',
	s_fk_gc_cco.`address_county` AS 's_fk_gc_cco__address_county',
	s_fk_gc_cco.`address_state_or_region` AS 's_fk_gc_cco__address_state_or_region',
	s_fk_gc_cco.`address_postal_code` AS 's_fk_gc_cco__address_postal_code',
	s_fk_gc_cco.`address_postal_code_extension` AS 's_fk_gc_cco__address_postal_code_extension',
	s_fk_gc_cco.`address_country` AS 's_fk_gc_cco__address_country',
	s_fk_gc_cco.`head_quarters_flag` AS 's_fk_gc_cco__head_quarters_flag',
	s_fk_gc_cco.`address_validated_by_user_flag` AS 's_fk_gc_cco__address_validated_by_user_flag',
	s_fk_gc_cco.`address_validated_by_web_service_flag` AS 's_fk_gc_cco__address_validated_by_web_service_flag',
	s_fk_gc_cco.`address_validation_by_web_service_error_flag` AS 's_fk_gc_cco__address_validation_by_web_service_error_flag',

	s_fk_gc_phone_ccopn.`id` AS 's_fk_gc_phone_ccopn__contact_company_office_phone_number_id',
	s_fk_gc_phone_ccopn.`contact_company_office_id` AS 's_fk_gc_phone_ccopn__contact_company_office_id',
	s_fk_gc_phone_ccopn.`phone_number_type_id` AS 's_fk_gc_phone_ccopn__phone_number_type_id',
	s_fk_gc_phone_ccopn.`country_code` AS 's_fk_gc_phone_ccopn__country_code',
	s_fk_gc_phone_ccopn.`area_code` AS 's_fk_gc_phone_ccopn__area_code',
	s_fk_gc_phone_ccopn.`prefix` AS 's_fk_gc_phone_ccopn__prefix',
	s_fk_gc_phone_ccopn.`number` AS 's_fk_gc_phone_ccopn__number',
	s_fk_gc_phone_ccopn.`extension` AS 's_fk_gc_phone_ccopn__extension',
	s_fk_gc_phone_ccopn.`itu` AS 's_fk_gc_phone_ccopn__itu',

	s_fk_gc_fax_ccopn.`id` AS 's_fk_gc_fax_ccopn__contact_company_office_phone_number_id',
	s_fk_gc_fax_ccopn.`contact_company_office_id` AS 's_fk_gc_fax_ccopn__contact_company_office_id',
	s_fk_gc_fax_ccopn.`phone_number_type_id` AS 's_fk_gc_fax_ccopn__phone_number_type_id',
	s_fk_gc_fax_ccopn.`country_code` AS 's_fk_gc_fax_ccopn__country_code',
	s_fk_gc_fax_ccopn.`area_code` AS 's_fk_gc_fax_ccopn__area_code',
	s_fk_gc_fax_ccopn.`prefix` AS 's_fk_gc_fax_ccopn__prefix',
	s_fk_gc_fax_ccopn.`number` AS 's_fk_gc_fax_ccopn__number',
	s_fk_gc_fax_ccopn.`extension` AS 's_fk_gc_fax_ccopn__extension',
	s_fk_gc_fax_ccopn.`itu` AS 's_fk_gc_fax_ccopn__itu',

	s_fk_gc_c.`id` AS 's_fk_gc_c__contact_id',
	s_fk_gc_c.`user_company_id` AS 's_fk_gc_c__user_company_id',
	s_fk_gc_c.`user_id` AS 's_fk_gc_c__user_id',
	s_fk_gc_c.`contact_company_id` AS 's_fk_gc_c__contact_company_id',
	s_fk_gc_c.`email` AS 's_fk_gc_c__email',
	s_fk_gc_c.`name_prefix` AS 's_fk_gc_c__name_prefix',
	s_fk_gc_c.`first_name` AS 's_fk_gc_c__first_name',
	s_fk_gc_c.`additional_name` AS 's_fk_gc_c__additional_name',
	s_fk_gc_c.`middle_name` AS 's_fk_gc_c__middle_name',
	s_fk_gc_c.`last_name` AS 's_fk_gc_c__last_name',
	s_fk_gc_c.`name_suffix` AS 's_fk_gc_c__name_suffix',
	s_fk_gc_c.`title` AS 's_fk_gc_c__title',
	s_fk_gc_c.`vendor_flag` AS 's_fk_gc_c__vendor_flag',

	s_fk_gc_c_mobile_cpn.`id` AS 's_fk_gc_c_mobile_cpn__contact_phone_number_id',
	s_fk_gc_c_mobile_cpn.`contact_id` AS 's_fk_gc_c_mobile_cpn__contact_id',
	s_fk_gc_c_mobile_cpn.`phone_number_type_id` AS 's_fk_gc_c_mobile_cpn__phone_number_type_id',
	s_fk_gc_c_mobile_cpn.`country_code` AS 's_fk_gc_c_mobile_cpn__country_code',
	s_fk_gc_c_mobile_cpn.`area_code` AS 's_fk_gc_c_mobile_cpn__area_code',
	s_fk_gc_c_mobile_cpn.`prefix` AS 's_fk_gc_c_mobile_cpn__prefix',
	s_fk_gc_c_mobile_cpn.`number` AS 's_fk_gc_c_mobile_cpn__number',
	s_fk_gc_c_mobile_cpn.`extension` AS 's_fk_gc_c_mobile_cpn__extension',
	s_fk_gc_c_mobile_cpn.`itu` AS 's_fk_gc_c_mobile_cpn__itu',

	s_fk_v.`id` AS 's_fk_v__vendor_id',
	s_fk_v.`vendor_contact_company_id` AS 's_fk_v__vendor_contact_company_id',
	s_fk_v.`vendor_contact_company_office_id` AS 's_fk_v__vendor_contact_company_office_id',
	s_fk_v.`vendor_contact_id` AS 's_fk_v__vendor_contact_id',
	s_fk_v.`vendor_contact_address_id` AS 's_fk_v__vendor_contact_address_id',
	s_fk_v.`w9_file_manager_file_id` AS 's_fk_v__w9_file_manager_file_id',
	s_fk_v.`taxpayer_identification_number_id` AS 's_fk_v__taxpayer_identification_number_id',
	s_fk_v.`disabled_flag` AS 's_fk_v__disabled_flag',

	s_fk_v_cco.`id` AS 's_fk_v_cco__contact_company_office_id',
	s_fk_v_cco.`contact_company_id` AS 's_fk_v_cco__contact_company_id',
	s_fk_v_cco.`office_nickname` AS 's_fk_v_cco__office_nickname',
	s_fk_v_cco.`address_line_1` AS 's_fk_v_cco__address_line_1',
	s_fk_v_cco.`address_line_2` AS 's_fk_v_cco__address_line_2',
	s_fk_v_cco.`address_line_3` AS 's_fk_v_cco__address_line_3',
	s_fk_v_cco.`address_line_4` AS 's_fk_v_cco__address_line_4',
	s_fk_v_cco.`address_city` AS 's_fk_v_cco__address_city',
	s_fk_v_cco.`address_county` AS 's_fk_v_cco__address_county',
	s_fk_v_cco.`address_state_or_region` AS 's_fk_v_cco__address_state_or_region',
	s_fk_v_cco.`address_postal_code` AS 's_fk_v_cco__address_postal_code',
	s_fk_v_cco.`address_postal_code_extension` AS 's_fk_v_cco__address_postal_code_extension',
	s_fk_v_cco.`address_country` AS 's_fk_v_cco__address_country',
	s_fk_v_cco.`head_quarters_flag` AS 's_fk_v_cco__head_quarters_flag',
	s_fk_v_cco.`address_validated_by_user_flag` AS 's_fk_v_cco__address_validated_by_user_flag',
	s_fk_v_cco.`address_validated_by_web_service_flag` AS 's_fk_v_cco__address_validated_by_web_service_flag',
	s_fk_v_cco.`address_validation_by_web_service_error_flag` AS 's_fk_v_cco__address_validation_by_web_service_error_flag',

	s_fk_v_phone_ccopn.`id` AS 's_fk_v_phone_ccopn__contact_company_office_phone_number_id',
	s_fk_v_phone_ccopn.`contact_company_office_id` AS 's_fk_v_phone_ccopn__contact_company_office_id',
	s_fk_v_phone_ccopn.`phone_number_type_id` AS 's_fk_v_phone_ccopn__phone_number_type_id',
	s_fk_v_phone_ccopn.`country_code` AS 's_fk_v_phone_ccopn__country_code',
	s_fk_v_phone_ccopn.`area_code` AS 's_fk_v_phone_ccopn__area_code',
	s_fk_v_phone_ccopn.`prefix` AS 's_fk_v_phone_ccopn__prefix',
	s_fk_v_phone_ccopn.`number` AS 's_fk_v_phone_ccopn__number',
	s_fk_v_phone_ccopn.`extension` AS 's_fk_v_phone_ccopn__extension',
	s_fk_v_phone_ccopn.`itu` AS 's_fk_v_phone_ccopn__itu',

	s_fk_v_fax_ccopn.`id` AS 's_fk_v_fax_ccopn__contact_company_office_phone_number_id',
	s_fk_v_fax_ccopn.`contact_company_office_id` AS 's_fk_v_fax_ccopn__contact_company_office_id',
	s_fk_v_fax_ccopn.`phone_number_type_id` AS 's_fk_v_fax_ccopn__phone_number_type_id',
	s_fk_v_fax_ccopn.`country_code` AS 's_fk_v_fax_ccopn__country_code',
	s_fk_v_fax_ccopn.`area_code` AS 's_fk_v_fax_ccopn__area_code',
	s_fk_v_fax_ccopn.`prefix` AS 's_fk_v_fax_ccopn__prefix',
	s_fk_v_fax_ccopn.`number` AS 's_fk_v_fax_ccopn__number',
	s_fk_v_fax_ccopn.`extension` AS 's_fk_v_fax_ccopn__extension',
	s_fk_v_fax_ccopn.`itu` AS 's_fk_v_fax_ccopn__itu',

	s_fk_v_c.`id` AS 's_fk_v_c__contact_id',
	s_fk_v_c.`user_company_id` AS 's_fk_v_c__user_company_id',
	s_fk_v_c.`user_id` AS 's_fk_v_c__user_id',
	s_fk_v_c.`contact_company_id` AS 's_fk_v_c__contact_company_id',
	s_fk_v_c.`email` AS 's_fk_v_c__email',
	s_fk_v_c.`name_prefix` AS 's_fk_v_c__name_prefix',
	s_fk_v_c.`first_name` AS 's_fk_v_c__first_name',
	s_fk_v_c.`additional_name` AS 's_fk_v_c__additional_name',
	s_fk_v_c.`middle_name` AS 's_fk_v_c__middle_name',
	s_fk_v_c.`last_name` AS 's_fk_v_c__last_name',
	s_fk_v_c.`name_suffix` AS 's_fk_v_c__name_suffix',
	s_fk_v_c.`title` AS 's_fk_v_c__title',
	s_fk_v_c.`vendor_flag` AS 's_fk_v_c__vendor_flag',

	s_fk_v_c_mobile_cpn.`id` AS 's_fk_v_c_mobile_cpn__contact_phone_number_id',
	s_fk_v_c_mobile_cpn.`contact_id` AS 's_fk_v_c_mobile_cpn__contact_id',
	s_fk_v_c_mobile_cpn.`phone_number_type_id` AS 's_fk_v_c_mobile_cpn__phone_number_type_id',
	s_fk_v_c_mobile_cpn.`country_code` AS 's_fk_v_c_mobile_cpn__country_code',
	s_fk_v_c_mobile_cpn.`area_code` AS 's_fk_v_c_mobile_cpn__area_code',
	s_fk_v_c_mobile_cpn.`prefix` AS 's_fk_v_c_mobile_cpn__prefix',
	s_fk_v_c_mobile_cpn.`number` AS 's_fk_v_c_mobile_cpn__number',
	s_fk_v_c_mobile_cpn.`extension` AS 's_fk_v_c_mobile_cpn__extension',
	s_fk_v_c_mobile_cpn.`itu` AS 's_fk_v_c_mobile_cpn__itu',

	s_fk_unsigned_s_fmfiles.`id` AS 's_fk_unsigned_s_fmfiles__file_manager_file_id',
	s_fk_unsigned_s_fmfiles.`user_company_id` AS 's_fk_unsigned_s_fmfiles__user_company_id',
	s_fk_unsigned_s_fmfiles.`contact_id` AS 's_fk_unsigned_s_fmfiles__contact_id',
	s_fk_unsigned_s_fmfiles.`project_id` AS 's_fk_unsigned_s_fmfiles__project_id',
	s_fk_unsigned_s_fmfiles.`file_manager_folder_id` AS 's_fk_unsigned_s_fmfiles__file_manager_folder_id',
	s_fk_unsigned_s_fmfiles.`file_location_id` AS 's_fk_unsigned_s_fmfiles__file_location_id',
	s_fk_unsigned_s_fmfiles.`virtual_file_name` AS 's_fk_unsigned_s_fmfiles__virtual_file_name',
	s_fk_unsigned_s_fmfiles.`version_number` AS 's_fk_unsigned_s_fmfiles__version_number',
	s_fk_unsigned_s_fmfiles.`virtual_file_name_sha1` AS 's_fk_unsigned_s_fmfiles__virtual_file_name_sha1',
	s_fk_unsigned_s_fmfiles.`virtual_file_mime_type` AS 's_fk_unsigned_s_fmfiles__virtual_file_mime_type',
	s_fk_unsigned_s_fmfiles.`modified` AS 's_fk_unsigned_s_fmfiles__modified',
	s_fk_unsigned_s_fmfiles.`created` AS 's_fk_unsigned_s_fmfiles__created',
	s_fk_unsigned_s_fmfiles.`deleted_flag` AS 's_fk_unsigned_s_fmfiles__deleted_flag',
	s_fk_unsigned_s_fmfiles.`directly_deleted_flag` AS 's_fk_unsigned_s_fmfiles__directly_deleted_flag',

	s_fk_signed_s_fmfiles.`id` AS 's_fk_signed_s_fmfiles__file_manager_file_id',
	s_fk_signed_s_fmfiles.`user_company_id` AS 's_fk_signed_s_fmfiles__user_company_id',
	s_fk_signed_s_fmfiles.`contact_id` AS 's_fk_signed_s_fmfiles__contact_id',
	s_fk_signed_s_fmfiles.`project_id` AS 's_fk_signed_s_fmfiles__project_id',
	s_fk_signed_s_fmfiles.`file_manager_folder_id` AS 's_fk_signed_s_fmfiles__file_manager_folder_id',
	s_fk_signed_s_fmfiles.`file_location_id` AS 's_fk_signed_s_fmfiles__file_location_id',
	s_fk_signed_s_fmfiles.`virtual_file_name` AS 's_fk_signed_s_fmfiles__virtual_file_name',
	s_fk_signed_s_fmfiles.`version_number` AS 's_fk_signed_s_fmfiles__version_number',
	s_fk_signed_s_fmfiles.`virtual_file_name_sha1` AS 's_fk_signed_s_fmfiles__virtual_file_name_sha1',
	s_fk_signed_s_fmfiles.`virtual_file_mime_type` AS 's_fk_signed_s_fmfiles__virtual_file_mime_type',
	s_fk_signed_s_fmfiles.`modified` AS 's_fk_signed_s_fmfiles__modified',
	s_fk_signed_s_fmfiles.`created` AS 's_fk_signed_s_fmfiles__created',
	s_fk_signed_s_fmfiles.`deleted_flag` AS 's_fk_signed_s_fmfiles__deleted_flag',
	s_fk_signed_s_fmfiles.`directly_deleted_flag` AS 's_fk_signed_s_fmfiles__directly_deleted_flag',

	s_fk_v__fk_cc.`id` AS 's_fk_v__fk_cc__contact_company_id',
	s_fk_v__fk_cc.`user_user_company_id` AS 's_fk_v__fk_cc__user_user_company_id',
	s_fk_v__fk_cc.`contact_user_company_id` AS 's_fk_v__fk_cc__contact_user_company_id',
	s_fk_v__fk_cc.`company` AS 's_fk_v__fk_cc__company',
	s_fk_v__fk_cc.`primary_phone_number` AS 's_fk_v__fk_cc__primary_phone_number',
	s_fk_v__fk_cc.`employer_identification_number` AS 's_fk_v__fk_cc__employer_identification_number',
	s_fk_v__fk_cc.`construction_license_number` AS 's_fk_v__fk_cc__construction_license_number',
	s_fk_v__fk_cc.`construction_license_number_expiration_date` AS 's_fk_v__fk_cc__construction_license_number_expiration_date',
	s_fk_v__fk_cc.`vendor_flag` AS 's_fk_v__fk_cc__vendor_flag',

	s.*,

	sctype.subcontract_type

FROM `subcontracts` s
	INNER JOIN `gc_budget_line_items` s_fk_gbli ON s.`gc_budget_line_item_id` = s_fk_gbli.`id`
	LEFT OUTER JOIN `subcontractor_bids` s_fk_sb ON s.`subcontractor_bid_id` = s_fk_sb.`id`
	INNER JOIN `subcontract_templates` s_fk_st ON s.`subcontract_template_id` = s_fk_st.`id`
	LEFT OUTER JOIN `contact_company_offices` s_fk_gc_cco ON s.`subcontract_gc_contact_company_office_id` = s_fk_gc_cco.`id`
	LEFT OUTER JOIN `contact_company_office_phone_numbers` s_fk_gc_phone_ccopn ON s.`subcontract_gc_phone_contact_company_office_phone_number_id` = s_fk_gc_phone_ccopn.`id`
	LEFT OUTER JOIN `contact_company_office_phone_numbers` s_fk_gc_fax_ccopn ON s.`subcontract_gc_fax_contact_company_office_phone_number_id` = s_fk_gc_fax_ccopn.`id`
	LEFT OUTER JOIN `contacts` s_fk_gc_c ON s.`subcontract_gc_contact_id` = s_fk_gc_c.`id`
	LEFT OUTER JOIN `contact_phone_numbers` s_fk_gc_c_mobile_cpn ON s.`subcontract_gc_contact_mobile_phone_number_id` = s_fk_gc_c_mobile_cpn.`id`
	INNER JOIN `vendors` s_fk_v ON s.`vendor_id` = s_fk_v.`id`
	LEFT OUTER JOIN `contact_company_offices` s_fk_v_cco ON s.`subcontract_vendor_contact_company_office_id` = s_fk_v_cco.`id`
	LEFT OUTER JOIN `contact_company_office_phone_numbers` s_fk_v_phone_ccopn ON s.`subcontract_vendor_phone_contact_company_office_phone_number_id` = s_fk_v_phone_ccopn.`id`
	LEFT OUTER JOIN `contact_company_office_phone_numbers` s_fk_v_fax_ccopn ON s.`subcontract_vendor_fax_contact_company_office_phone_number_id` = s_fk_v_fax_ccopn.`id`
	LEFT OUTER JOIN `contacts` s_fk_v_c ON s.`subcontract_vendor_contact_id` = s_fk_v_c.`id`
	LEFT OUTER JOIN `contact_phone_numbers` s_fk_v_c_mobile_cpn ON s.`subcontract_vendor_contact_mobile_phone_number_id` = s_fk_v_c_mobile_cpn.`id`
	LEFT OUTER JOIN `file_manager_files` s_fk_unsigned_s_fmfiles ON s.`unsigned_subcontract_file_manager_file_id` = s_fk_unsigned_s_fmfiles.`id`
	LEFT OUTER JOIN `file_manager_files` s_fk_signed_s_fmfiles ON s.`signed_subcontract_file_manager_file_id` = s_fk_signed_s_fmfiles.`id`

	INNER JOIN `contact_companies` s_fk_v__fk_cc ON s_fk_v.`vendor_contact_company_id` = s_fk_v__fk_cc.`id`
	INNER JOIN subcontract_types sctype ON s_fk_st.subcontract_type_id = sctype.`id`

WHERE s.`id` = ?
";
		$arrValues = array($subcontract_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$subcontract_id = $row['id'];
			$subcontract = self::instantiateOrm($database, 'Subcontract', $row, null, $subcontract_id);
			/* @var $subcontract Subcontract */
			$subcontract->convertPropertiesToData();

			if (isset($row['gc_budget_line_item_id'])) {
				$gc_budget_line_item_id = $row['gc_budget_line_item_id'];
				$row['s_fk_gbli__id'] = $gc_budget_line_item_id;
				$gcBudgetLineItem = self::instantiateOrm($database, 'GcBudgetLineItem', $row, null, $gc_budget_line_item_id, 's_fk_gbli__');
				/* @var $gcBudgetLineItem GcBudgetLineItem */
				$gcBudgetLineItem->convertPropertiesToData();
			} else {
				$gcBudgetLineItem = false;
			}
			$subcontract->setGcBudgetLineItem($gcBudgetLineItem);

			if (isset($row['subcontractor_bid_id'])) {
				$subcontractor_bid_id = $row['subcontractor_bid_id'];
				$row['s_fk_sb__id'] = $subcontractor_bid_id;
				$subcontractorBid = self::instantiateOrm($database, 'SubcontractorBid', $row, null, $subcontractor_bid_id, 's_fk_sb__');
				/* @var $subcontractorBid SubcontractorBid */
				$subcontractorBid->convertPropertiesToData();
			} else {
				$subcontractorBid = false;
			}
			$subcontract->setSubcontractorBid($subcontractorBid);

			if (isset($row['subcontract_template_id'])) {
				$subcontract_template_id = $row['subcontract_template_id'];
				$row['s_fk_st__id'] = $subcontract_template_id;
				$subcontractTemplate = self::instantiateOrm($database, 'SubcontractTemplate', $row, null, $subcontract_template_id, 's_fk_st__');
				/* @var $subcontractTemplate SubcontractTemplate */
				$subcontractTemplate->convertPropertiesToData();
			} else {
				$subcontractTemplate = false;
			}
			$subcontract->setSubcontractTemplate($subcontractTemplate);

			if (isset($row['subcontract_gc_contact_company_office_id'])) {
				$subcontract_gc_contact_company_office_id = $row['subcontract_gc_contact_company_office_id'];
				$row['s_fk_gc_cco__id'] = $subcontract_gc_contact_company_office_id;
				$subcontractGcContactCompanyOffice = self::instantiateOrm($database, 'ContactCompanyOffice', $row, null, $subcontract_gc_contact_company_office_id, 's_fk_gc_cco__');
				/* @var $subcontractGcContactCompanyOffice ContactCompanyOffice */
				$subcontractGcContactCompanyOffice->convertPropertiesToData();
			} else {
				$subcontractGcContactCompanyOffice = false;
			}
			$subcontract->setSubcontractGcContactCompanyOffice($subcontractGcContactCompanyOffice);

			if (isset($row['subcontract_gc_phone_contact_company_office_phone_number_id'])) {
				$subcontract_gc_phone_contact_company_office_phone_number_id = $row['subcontract_gc_phone_contact_company_office_phone_number_id'];
				$row['s_fk_gc_phone_ccopn__id'] = $subcontract_gc_phone_contact_company_office_phone_number_id;
				$subcontractGcPhoneContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $subcontract_gc_phone_contact_company_office_phone_number_id, 's_fk_gc_phone_ccopn__');
				/* @var $subcontractGcPhoneContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$subcontractGcPhoneContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$subcontractGcPhoneContactCompanyOfficePhoneNumber = false;
			}
			$subcontract->setSubcontractGcPhoneContactCompanyOfficePhoneNumber($subcontractGcPhoneContactCompanyOfficePhoneNumber);

			if (isset($row['subcontract_gc_fax_contact_company_office_phone_number_id'])) {
				$subcontract_gc_fax_contact_company_office_phone_number_id = $row['subcontract_gc_fax_contact_company_office_phone_number_id'];
				$row['s_fk_gc_fax_ccopn__id'] = $subcontract_gc_fax_contact_company_office_phone_number_id;
				$subcontractGcFaxContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $subcontract_gc_fax_contact_company_office_phone_number_id, 's_fk_gc_fax_ccopn__');
				/* @var $subcontractGcFaxContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$subcontractGcFaxContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$subcontractGcFaxContactCompanyOfficePhoneNumber = false;
			}
			$subcontract->setSubcontractGcFaxContactCompanyOfficePhoneNumber($subcontractGcFaxContactCompanyOfficePhoneNumber);

			if (isset($row['subcontract_gc_contact_id'])) {
				$subcontract_gc_contact_id = $row['subcontract_gc_contact_id'];
				$row['s_fk_gc_c__id'] = $subcontract_gc_contact_id;
				$subcontractGcContact = self::instantiateOrm($database, 'Contact', $row, null, $subcontract_gc_contact_id, 's_fk_gc_c__');
				/* @var $subcontractGcContact Contact */
				$subcontractGcContact->convertPropertiesToData();
			} else {
				$subcontractGcContact = false;
			}
			$subcontract->setSubcontractGcContact($subcontractGcContact);

			if (isset($row['subcontract_gc_contact_mobile_phone_number_id'])) {
				$subcontract_gc_contact_mobile_phone_number_id = $row['subcontract_gc_contact_mobile_phone_number_id'];
				$row['s_fk_gc_c_mobile_cpn__id'] = $subcontract_gc_contact_mobile_phone_number_id;
				$subcontractGcContactMobilePhoneNumber = self::instantiateOrm($database, 'ContactPhoneNumber', $row, null, $subcontract_gc_contact_mobile_phone_number_id, 's_fk_gc_c_mobile_cpn__');
				/* @var $subcontractGcContactMobilePhoneNumber ContactPhoneNumber */
				$subcontractGcContactMobilePhoneNumber->convertPropertiesToData();
			} else {
				$subcontractGcContactMobilePhoneNumber = false;
			}
			$subcontract->setSubcontractGcContactMobilePhoneNumber($subcontractGcContactMobilePhoneNumber);

			if (isset($row['vendor_id'])) {
				$vendor_id = $row['vendor_id'];
				$row['s_fk_v__id'] = $vendor_id;
				$vendor = self::instantiateOrm($database, 'Vendor', $row, null, $vendor_id, 's_fk_v__');
				/* @var $vendor Vendor */
				$vendor->convertPropertiesToData();
			} else {
				$vendor = false;
			}
			$subcontract->setVendor($vendor);

			if (isset($row['subcontract_vendor_contact_company_office_id'])) {
				$subcontract_vendor_contact_company_office_id = $row['subcontract_vendor_contact_company_office_id'];
				$row['s_fk_v_cco__id'] = $subcontract_vendor_contact_company_office_id;
				$subcontractVendorContactCompanyOffice = self::instantiateOrm($database, 'ContactCompanyOffice', $row, null, $subcontract_vendor_contact_company_office_id, 's_fk_v_cco__');
				/* @var $subcontractVendorContactCompanyOffice ContactCompanyOffice */
				$subcontractVendorContactCompanyOffice->convertPropertiesToData();
			} else {
				$subcontractVendorContactCompanyOffice = false;
			}
			$subcontract->setSubcontractVendorContactCompanyOffice($subcontractVendorContactCompanyOffice);

			if (isset($row['subcontract_vendor_phone_contact_company_office_phone_number_id'])) {
				$subcontract_vendor_phone_contact_company_office_phone_number_id = $row['subcontract_vendor_phone_contact_company_office_phone_number_id'];
				$row['s_fk_v_phone_ccopn__id'] = $subcontract_vendor_phone_contact_company_office_phone_number_id;
				$subcontractVendorPhoneContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $subcontract_vendor_phone_contact_company_office_phone_number_id, 's_fk_v_phone_ccopn__');
				/* @var $subcontractVendorPhoneContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$subcontractVendorPhoneContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$subcontractVendorPhoneContactCompanyOfficePhoneNumber = false;
			}
			$subcontract->setSubcontractVendorPhoneContactCompanyOfficePhoneNumber($subcontractVendorPhoneContactCompanyOfficePhoneNumber);

			if (isset($row['subcontract_vendor_fax_contact_company_office_phone_number_id'])) {
				$subcontract_vendor_fax_contact_company_office_phone_number_id = $row['subcontract_vendor_fax_contact_company_office_phone_number_id'];
				$row['s_fk_v_fax_ccopn__id'] = $subcontract_vendor_fax_contact_company_office_phone_number_id;
				$subcontractVendorFaxContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $subcontract_vendor_fax_contact_company_office_phone_number_id, 's_fk_v_fax_ccopn__');
				/* @var $subcontractVendorFaxContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$subcontractVendorFaxContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$subcontractVendorFaxContactCompanyOfficePhoneNumber = false;
			}
			$subcontract->setSubcontractVendorFaxContactCompanyOfficePhoneNumber($subcontractVendorFaxContactCompanyOfficePhoneNumber);

			if (isset($row['subcontract_vendor_contact_id'])) {
				$subcontract_vendor_contact_id = $row['subcontract_vendor_contact_id'];
				$row['s_fk_v_c__id'] = $subcontract_vendor_contact_id;
				$subcontractVendorContact = self::instantiateOrm($database, 'Contact', $row, null, $subcontract_vendor_contact_id, 's_fk_v_c__');
				/* @var $subcontractVendorContact Contact */
				$subcontractVendorContact->convertPropertiesToData();
			} else {
				$subcontractVendorContact = false;
			}
			$subcontract->setSubcontractVendorContact($subcontractVendorContact);

			if (isset($row['subcontract_vendor_contact_mobile_phone_number_id'])) {
				$subcontract_vendor_contact_mobile_phone_number_id = $row['subcontract_vendor_contact_mobile_phone_number_id'];
				$row['s_fk_v_c_mobile_cpn__id'] = $subcontract_vendor_contact_mobile_phone_number_id;
				$subcontractVendorContactMobilePhoneNumber = self::instantiateOrm($database, 'ContactPhoneNumber', $row, null, $subcontract_vendor_contact_mobile_phone_number_id, 's_fk_v_c_mobile_cpn__');
				/* @var $subcontractVendorContactMobilePhoneNumber ContactPhoneNumber */
				$subcontractVendorContactMobilePhoneNumber->convertPropertiesToData();
			} else {
				$subcontractVendorContactMobilePhoneNumber = false;
			}
			$subcontract->setSubcontractVendorContactMobilePhoneNumber($subcontractVendorContactMobilePhoneNumber);

			if (isset($row['unsigned_subcontract_file_manager_file_id'])) {
				$unsigned_subcontract_file_manager_file_id = $row['unsigned_subcontract_file_manager_file_id'];
				$row['s_fk_unsigned_s_fmfiles__id'] = $unsigned_subcontract_file_manager_file_id;
				$unsignedSubcontractFileManagerFile = self::instantiateOrm($database, 'FileManagerFile', $row, null, $unsigned_subcontract_file_manager_file_id, 's_fk_unsigned_s_fmfiles__');
				/* @var $unsignedSubcontractFileManagerFile FileManagerFile */
				$unsignedSubcontractFileManagerFile->convertPropertiesToData();
			} else {
				$unsignedSubcontractFileManagerFile = false;
			}
			$subcontract->setUnsignedSubcontractFileManagerFile($unsignedSubcontractFileManagerFile);

			if (isset($row['signed_subcontract_file_manager_file_id'])) {
				$signed_subcontract_file_manager_file_id = $row['signed_subcontract_file_manager_file_id'];
				$row['s_fk_signed_s_fmfiles__id'] = $signed_subcontract_file_manager_file_id;
				$signedSubcontractFileManagerFile = self::instantiateOrm($database, 'FileManagerFile', $row, null, $signed_subcontract_file_manager_file_id, 's_fk_signed_s_fmfiles__');
				/* @var $signedSubcontractFileManagerFile FileManagerFile */
				$signedSubcontractFileManagerFile->convertPropertiesToData();
			} else {
				$signedSubcontractFileManagerFile = false;
			}
			$subcontract->setSignedSubcontractFileManagerFile($signedSubcontractFileManagerFile);

			if (isset($row['s_fk_v__fk_cc__contact_company_id'])) {
				$vendor_contact_company_id = $row['s_fk_v__fk_cc__contact_company_id'];
				$row['s_fk_v__fk_cc__id'] = $vendor_contact_company_id;
				$vendorContactCompany = self::instantiateOrm($database, 'ContactCompany', $row, null, $vendor_contact_company_id, 's_fk_v__fk_cc__');
				/* @var $vendorContactCompany ContactCompany */
				$vendorContactCompany->convertPropertiesToData();
			} else {
				$vendorContactCompany = false;
			}

			if ($vendor) {
				$vendor->setVendorContactCompany($vendorContactCompany);
				$vendor->setVendorContactCompanyOffice($subcontractVendorContactCompanyOffice);
				$vendor->setVendorContact($subcontractVendorContact);
				//$vendor->setContactAddress($subcontractVendorPhoneContactCompanyOfficePhoneNumber);
			}

			// Additional attributes
			$subcontract_type = $row['subcontract_type'];
			$subcontract->subcontract_type = $subcontract_type;

			return $subcontract;
		} else {
			return false;
		}
	}

	// Finders: Find By Unique Index
	/**
	 * Find by unique index `unique_subcontract` (`gc_budget_line_item_id`,`subcontract_sequence_number`) comment 'One Cost Code can have many subcontracts for a project'.
	 *
	 * @param string $database
	 * @param int $gc_budget_line_item_id
	 * @param int $subcontract_sequence_number
	 * @return mixed (single ORM object | false)
	 */
	public static function findByGcBudgetLineItemIdAndSubcontractSequenceNumber($database, $gc_budget_line_item_id, $subcontract_sequence_number)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	s.*

FROM `subcontracts` s
WHERE s.`gc_budget_line_item_id` = ?
AND s.`subcontract_sequence_number` = ?
";
		$arrValues = array($gc_budget_line_item_id, $subcontract_sequence_number);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if ($row && !empty($row)) {
			$subcontract_id = $row['id'];
			$subcontract = self::instantiateOrm($database, 'Subcontract', $row, null, $subcontract_id);
			/* @var $subcontract Subcontract */
			return $subcontract;
		} else {
			return false;
		}
	}

	// Loaders: Load By pk List (list of auto int ids or other non auto int pk list)
	/**
	 * Load zero or more records by an id list (array of auto int primary keys).
	 *
	 * @param string $database
	 * @param array $arrSubcontractIds
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubcontractsByArrSubcontractIds($database, $arrSubcontractIds, Input $options=null)
	{
		if (empty($arrSubcontractIds)) {
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
		// ORDER BY `id` ASC, `gc_budget_line_item_id` ASC, `subcontract_sequence_number` ASC, `subcontractor_bid_id` ASC, `subcontract_template_id` ASC, `subcontract_gc_contact_company_office_id` ASC, `subcontract_gc_phone_contact_company_office_phone_number_id` ASC, `subcontract_gc_fax_contact_company_office_phone_number_id` ASC, `subcontract_gc_contact_id` ASC, `subcontract_gc_contact_mobile_phone_number_id` ASC, `vendor_id` ASC, `subcontract_vendor_contact_company_office_id` ASC, `subcontract_vendor_phone_contact_company_office_phone_number_id` ASC, `subcontract_vendor_fax_contact_company_office_phone_number_id` ASC, `subcontract_vendor_contact_id` ASC, `subcontract_vendor_contact_mobile_phone_number_id` ASC, `unsigned_subcontract_file_manager_file_id` ASC, `signed_subcontract_file_manager_file_id` ASC, `subcontract_forecasted_value` ASC, `subcontract_actual_value` ASC, `subcontract_retention_percentage` ASC, `subcontract_issued_date` ASC, `subcontract_target_execution_date` ASC, `subcontract_execution_date` ASC, `active_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubcontract = new Subcontract($database);
			$sqlOrderByColumns = $tmpSubcontract->constructSqlOrderByColumns($arrOrderByAttributes);

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

		foreach ($arrSubcontractIds as $k => $subcontract_id) {
			$subcontract_id = (int) $subcontract_id;
			$arrSubcontractIds[$k] = $db->escape($subcontract_id);
		}
		$csvSubcontractIds = join(',', $arrSubcontractIds);

		$query =
"
SELECT

	s.*

FROM `subcontracts` s
WHERE s.`id` IN ($csvSubcontractIds){$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		$arrSubcontractsByCsvSubcontractIds = array();
		while ($row = $db->fetch()) {
			$subcontract_id = $row['id'];
			$subcontract = self::instantiateOrm($database, 'Subcontract', $row, null, $subcontract_id);
			/* @var $subcontract Subcontract */
			$subcontract->convertPropertiesToData();

			$arrSubcontractsByCsvSubcontractIds[$subcontract_id] = $subcontract;
		}

		$db->free_result();

		return $arrSubcontractsByCsvSubcontractIds;
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `subcontracts_fk_gbli` foreign key (`gc_budget_line_item_id`) references `gc_budget_line_items` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $gc_budget_line_item_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubcontractsByGcBudgetLineItemId($database, $gc_budget_line_item_id, Input $options=null)
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
			self::$_arrSubcontractsByGcBudgetLineItemId = null;
		}

		$arrSubcontractsByGcBudgetLineItemId = self::$_arrSubcontractsByGcBudgetLineItemId;
		if (isset($arrSubcontractsByGcBudgetLineItemId) && !empty($arrSubcontractsByGcBudgetLineItemId)) {
			return $arrSubcontractsByGcBudgetLineItemId;
		}

		$gc_budget_line_item_id = (int) $gc_budget_line_item_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `gc_budget_line_item_id` ASC, `subcontract_sequence_number` ASC, `subcontractor_bid_id` ASC, `subcontract_template_id` ASC, `subcontract_gc_contact_company_office_id` ASC, `subcontract_gc_phone_contact_company_office_phone_number_id` ASC, `subcontract_gc_fax_contact_company_office_phone_number_id` ASC, `subcontract_gc_contact_id` ASC, `subcontract_gc_contact_mobile_phone_number_id` ASC, `vendor_id` ASC, `subcontract_vendor_contact_company_office_id` ASC, `subcontract_vendor_phone_contact_company_office_phone_number_id` ASC, `subcontract_vendor_fax_contact_company_office_phone_number_id` ASC, `subcontract_vendor_contact_id` ASC, `subcontract_vendor_contact_mobile_phone_number_id` ASC, `unsigned_subcontract_file_manager_file_id` ASC, `signed_subcontract_file_manager_file_id` ASC, `subcontract_forecasted_value` ASC, `subcontract_actual_value` ASC, `subcontract_retention_percentage` ASC, `subcontract_issued_date` ASC, `subcontract_target_execution_date` ASC, `subcontract_execution_date` ASC, `active_flag` ASC
		$sqlOrderBy = "\nORDER BY s.`subcontract_sequence_number` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubcontract = new Subcontract($database);
			$sqlOrderByColumns = $tmpSubcontract->constructSqlOrderByColumns($arrOrderByAttributes);

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
		
		   $query =
"
SELECT

	s_fk_gbli.`id` AS 's_fk_gbli__gc_budget_line_item_id',
	s_fk_gbli.`user_company_id` AS 's_fk_gbli__user_company_id',
	s_fk_gbli.`project_id` AS 's_fk_gbli__project_id',
	s_fk_gbli.`cost_code_id` AS 's_fk_gbli__cost_code_id',
	s_fk_gbli.`modified` AS 's_fk_gbli__modified',
	s_fk_gbli.`prime_contract_scheduled_value` AS 's_fk_gbli__prime_contract_scheduled_value',
	s_fk_gbli.`forecasted_expenses` AS 's_fk_gbli__forecasted_expenses',
	s_fk_gbli.`created` AS 's_fk_gbli__created',
	s_fk_gbli.`sort_order` AS 's_fk_gbli__sort_order',
	s_fk_gbli.`disabled_flag` AS 's_fk_gbli__disabled_flag',

	s_fk_sb.`id` AS 's_fk_sb__subcontractor_bid_id',
	s_fk_sb.`gc_budget_line_item_id` AS 's_fk_sb__gc_budget_line_item_id',
	s_fk_sb.`subcontractor_contact_id` AS 's_fk_sb__subcontractor_contact_id',
	s_fk_sb.`subcontractor_bid_status_id` AS 's_fk_sb__subcontractor_bid_status_id',
	s_fk_sb.`sort_order` AS 's_fk_sb__sort_order',

	s_fk_st.`id` AS 's_fk_st__subcontract_template_id',
	s_fk_st.`user_company_id` AS 's_fk_st__user_company_id',
	s_fk_st.`subcontract_type_id` AS 's_fk_st__subcontract_type_id',
	s_fk_st.`subcontract_template_name` AS 's_fk_st__subcontract_template_name',
	s_fk_st.`sort_order` AS 's_fk_st__sort_order',
	s_fk_st.`disabled_flag` AS 's_fk_st__disabled_flag',

	s_fk_gc_cco.`id` AS 's_fk_gc_cco__contact_company_office_id',
	s_fk_gc_cco.`contact_company_id` AS 's_fk_gc_cco__contact_company_id',
	s_fk_gc_cco.`office_nickname` AS 's_fk_gc_cco__office_nickname',
	s_fk_gc_cco.`address_line_1` AS 's_fk_gc_cco__address_line_1',
	s_fk_gc_cco.`address_line_2` AS 's_fk_gc_cco__address_line_2',
	s_fk_gc_cco.`address_line_3` AS 's_fk_gc_cco__address_line_3',
	s_fk_gc_cco.`address_line_4` AS 's_fk_gc_cco__address_line_4',
	s_fk_gc_cco.`address_city` AS 's_fk_gc_cco__address_city',
	s_fk_gc_cco.`address_county` AS 's_fk_gc_cco__address_county',
	s_fk_gc_cco.`address_state_or_region` AS 's_fk_gc_cco__address_state_or_region',
	s_fk_gc_cco.`address_postal_code` AS 's_fk_gc_cco__address_postal_code',
	s_fk_gc_cco.`address_postal_code_extension` AS 's_fk_gc_cco__address_postal_code_extension',
	s_fk_gc_cco.`address_country` AS 's_fk_gc_cco__address_country',
	s_fk_gc_cco.`head_quarters_flag` AS 's_fk_gc_cco__head_quarters_flag',
	s_fk_gc_cco.`address_validated_by_user_flag` AS 's_fk_gc_cco__address_validated_by_user_flag',
	s_fk_gc_cco.`address_validated_by_web_service_flag` AS 's_fk_gc_cco__address_validated_by_web_service_flag',
	s_fk_gc_cco.`address_validation_by_web_service_error_flag` AS 's_fk_gc_cco__address_validation_by_web_service_error_flag',

	s_fk_gc_phone_ccopn.`id` AS 's_fk_gc_phone_ccopn__contact_company_office_phone_number_id',
	s_fk_gc_phone_ccopn.`contact_company_office_id` AS 's_fk_gc_phone_ccopn__contact_company_office_id',
	s_fk_gc_phone_ccopn.`phone_number_type_id` AS 's_fk_gc_phone_ccopn__phone_number_type_id',
	s_fk_gc_phone_ccopn.`country_code` AS 's_fk_gc_phone_ccopn__country_code',
	s_fk_gc_phone_ccopn.`area_code` AS 's_fk_gc_phone_ccopn__area_code',
	s_fk_gc_phone_ccopn.`prefix` AS 's_fk_gc_phone_ccopn__prefix',
	s_fk_gc_phone_ccopn.`number` AS 's_fk_gc_phone_ccopn__number',
	s_fk_gc_phone_ccopn.`extension` AS 's_fk_gc_phone_ccopn__extension',
	s_fk_gc_phone_ccopn.`itu` AS 's_fk_gc_phone_ccopn__itu',

	s_fk_gc_fax_ccopn.`id` AS 's_fk_gc_fax_ccopn__contact_company_office_phone_number_id',
	s_fk_gc_fax_ccopn.`contact_company_office_id` AS 's_fk_gc_fax_ccopn__contact_company_office_id',
	s_fk_gc_fax_ccopn.`phone_number_type_id` AS 's_fk_gc_fax_ccopn__phone_number_type_id',
	s_fk_gc_fax_ccopn.`country_code` AS 's_fk_gc_fax_ccopn__country_code',
	s_fk_gc_fax_ccopn.`area_code` AS 's_fk_gc_fax_ccopn__area_code',
	s_fk_gc_fax_ccopn.`prefix` AS 's_fk_gc_fax_ccopn__prefix',
	s_fk_gc_fax_ccopn.`number` AS 's_fk_gc_fax_ccopn__number',
	s_fk_gc_fax_ccopn.`extension` AS 's_fk_gc_fax_ccopn__extension',
	s_fk_gc_fax_ccopn.`itu` AS 's_fk_gc_fax_ccopn__itu',

	s_fk_gc_c.`id` AS 's_fk_gc_c__contact_id',
	s_fk_gc_c.`user_company_id` AS 's_fk_gc_c__user_company_id',
	s_fk_gc_c.`user_id` AS 's_fk_gc_c__user_id',
	s_fk_gc_c.`contact_company_id` AS 's_fk_gc_c__contact_company_id',
	s_fk_gc_c.`email` AS 's_fk_gc_c__email',
	s_fk_gc_c.`name_prefix` AS 's_fk_gc_c__name_prefix',
	s_fk_gc_c.`first_name` AS 's_fk_gc_c__first_name',
	s_fk_gc_c.`additional_name` AS 's_fk_gc_c__additional_name',
	s_fk_gc_c.`middle_name` AS 's_fk_gc_c__middle_name',
	s_fk_gc_c.`last_name` AS 's_fk_gc_c__last_name',
	s_fk_gc_c.`name_suffix` AS 's_fk_gc_c__name_suffix',
	s_fk_gc_c.`title` AS 's_fk_gc_c__title',
	s_fk_gc_c.`vendor_flag` AS 's_fk_gc_c__vendor_flag',

	s_fk_gc_c_mobile_cpn.`id` AS 's_fk_gc_c_mobile_cpn__contact_phone_number_id',
	s_fk_gc_c_mobile_cpn.`contact_id` AS 's_fk_gc_c_mobile_cpn__contact_id',
	s_fk_gc_c_mobile_cpn.`phone_number_type_id` AS 's_fk_gc_c_mobile_cpn__phone_number_type_id',
	s_fk_gc_c_mobile_cpn.`country_code` AS 's_fk_gc_c_mobile_cpn__country_code',
	s_fk_gc_c_mobile_cpn.`area_code` AS 's_fk_gc_c_mobile_cpn__area_code',
	s_fk_gc_c_mobile_cpn.`prefix` AS 's_fk_gc_c_mobile_cpn__prefix',
	s_fk_gc_c_mobile_cpn.`number` AS 's_fk_gc_c_mobile_cpn__number',
	s_fk_gc_c_mobile_cpn.`extension` AS 's_fk_gc_c_mobile_cpn__extension',
	s_fk_gc_c_mobile_cpn.`itu` AS 's_fk_gc_c_mobile_cpn__itu',

	s_fk_v.`id` AS 's_fk_v__vendor_id',
	s_fk_v.`vendor_contact_company_id` AS 's_fk_v__vendor_contact_company_id',
	s_fk_v.`vendor_contact_company_office_id` AS 's_fk_v__vendor_contact_company_office_id',
	s_fk_v.`vendor_contact_id` AS 's_fk_v__vendor_contact_id',
	s_fk_v.`vendor_contact_address_id` AS 's_fk_v__vendor_contact_address_id',
	s_fk_v.`w9_file_manager_file_id` AS 's_fk_v__w9_file_manager_file_id',
	s_fk_v.`taxpayer_identification_number_id` AS 's_fk_v__taxpayer_identification_number_id',
	s_fk_v.`disabled_flag` AS 's_fk_v__disabled_flag',

	s_fk_v_cco.`id` AS 's_fk_v_cco__contact_company_office_id',
	s_fk_v_cco.`contact_company_id` AS 's_fk_v_cco__contact_company_id',
	s_fk_v_cco.`office_nickname` AS 's_fk_v_cco__office_nickname',
	s_fk_v_cco.`address_line_1` AS 's_fk_v_cco__address_line_1',
	s_fk_v_cco.`address_line_2` AS 's_fk_v_cco__address_line_2',
	s_fk_v_cco.`address_line_3` AS 's_fk_v_cco__address_line_3',
	s_fk_v_cco.`address_line_4` AS 's_fk_v_cco__address_line_4',
	s_fk_v_cco.`address_city` AS 's_fk_v_cco__address_city',
	s_fk_v_cco.`address_county` AS 's_fk_v_cco__address_county',
	s_fk_v_cco.`address_state_or_region` AS 's_fk_v_cco__address_state_or_region',
	s_fk_v_cco.`address_postal_code` AS 's_fk_v_cco__address_postal_code',
	s_fk_v_cco.`address_postal_code_extension` AS 's_fk_v_cco__address_postal_code_extension',
	s_fk_v_cco.`address_country` AS 's_fk_v_cco__address_country',
	s_fk_v_cco.`head_quarters_flag` AS 's_fk_v_cco__head_quarters_flag',
	s_fk_v_cco.`address_validated_by_user_flag` AS 's_fk_v_cco__address_validated_by_user_flag',
	s_fk_v_cco.`address_validated_by_web_service_flag` AS 's_fk_v_cco__address_validated_by_web_service_flag',
	s_fk_v_cco.`address_validation_by_web_service_error_flag` AS 's_fk_v_cco__address_validation_by_web_service_error_flag',

	s_fk_v_phone_ccopn.`id` AS 's_fk_v_phone_ccopn__contact_company_office_phone_number_id',
	s_fk_v_phone_ccopn.`contact_company_office_id` AS 's_fk_v_phone_ccopn__contact_company_office_id',
	s_fk_v_phone_ccopn.`phone_number_type_id` AS 's_fk_v_phone_ccopn__phone_number_type_id',
	s_fk_v_phone_ccopn.`country_code` AS 's_fk_v_phone_ccopn__country_code',
	s_fk_v_phone_ccopn.`area_code` AS 's_fk_v_phone_ccopn__area_code',
	s_fk_v_phone_ccopn.`prefix` AS 's_fk_v_phone_ccopn__prefix',
	s_fk_v_phone_ccopn.`number` AS 's_fk_v_phone_ccopn__number',
	s_fk_v_phone_ccopn.`extension` AS 's_fk_v_phone_ccopn__extension',
	s_fk_v_phone_ccopn.`itu` AS 's_fk_v_phone_ccopn__itu',

	s_fk_v_fax_ccopn.`id` AS 's_fk_v_fax_ccopn__contact_company_office_phone_number_id',
	s_fk_v_fax_ccopn.`contact_company_office_id` AS 's_fk_v_fax_ccopn__contact_company_office_id',
	s_fk_v_fax_ccopn.`phone_number_type_id` AS 's_fk_v_fax_ccopn__phone_number_type_id',
	s_fk_v_fax_ccopn.`country_code` AS 's_fk_v_fax_ccopn__country_code',
	s_fk_v_fax_ccopn.`area_code` AS 's_fk_v_fax_ccopn__area_code',
	s_fk_v_fax_ccopn.`prefix` AS 's_fk_v_fax_ccopn__prefix',
	s_fk_v_fax_ccopn.`number` AS 's_fk_v_fax_ccopn__number',
	s_fk_v_fax_ccopn.`extension` AS 's_fk_v_fax_ccopn__extension',
	s_fk_v_fax_ccopn.`itu` AS 's_fk_v_fax_ccopn__itu',

	s_fk_v_c.`id` AS 's_fk_v_c__contact_id',
	s_fk_v_c.`user_company_id` AS 's_fk_v_c__user_company_id',
	s_fk_v_c.`user_id` AS 's_fk_v_c__user_id',
	s_fk_v_c.`contact_company_id` AS 's_fk_v_c__contact_company_id',
	s_fk_v_c.`email` AS 's_fk_v_c__email',
	s_fk_v_c.`name_prefix` AS 's_fk_v_c__name_prefix',
	s_fk_v_c.`first_name` AS 's_fk_v_c__first_name',
	s_fk_v_c.`additional_name` AS 's_fk_v_c__additional_name',
	s_fk_v_c.`middle_name` AS 's_fk_v_c__middle_name',
	s_fk_v_c.`last_name` AS 's_fk_v_c__last_name',
	s_fk_v_c.`name_suffix` AS 's_fk_v_c__name_suffix',
	s_fk_v_c.`title` AS 's_fk_v_c__title',
	s_fk_v_c.`vendor_flag` AS 's_fk_v_c__vendor_flag',

	s_fk_v_c_mobile_cpn.`id` AS 's_fk_v_c_mobile_cpn__contact_phone_number_id',
	s_fk_v_c_mobile_cpn.`contact_id` AS 's_fk_v_c_mobile_cpn__contact_id',
	s_fk_v_c_mobile_cpn.`phone_number_type_id` AS 's_fk_v_c_mobile_cpn__phone_number_type_id',
	s_fk_v_c_mobile_cpn.`country_code` AS 's_fk_v_c_mobile_cpn__country_code',
	s_fk_v_c_mobile_cpn.`area_code` AS 's_fk_v_c_mobile_cpn__area_code',
	s_fk_v_c_mobile_cpn.`prefix` AS 's_fk_v_c_mobile_cpn__prefix',
	s_fk_v_c_mobile_cpn.`number` AS 's_fk_v_c_mobile_cpn__number',
	s_fk_v_c_mobile_cpn.`extension` AS 's_fk_v_c_mobile_cpn__extension',
	s_fk_v_c_mobile_cpn.`itu` AS 's_fk_v_c_mobile_cpn__itu',

	s_fk_unsigned_s_fmfiles.`id` AS 's_fk_unsigned_s_fmfiles__file_manager_file_id',
	s_fk_unsigned_s_fmfiles.`user_company_id` AS 's_fk_unsigned_s_fmfiles__user_company_id',
	s_fk_unsigned_s_fmfiles.`contact_id` AS 's_fk_unsigned_s_fmfiles__contact_id',
	s_fk_unsigned_s_fmfiles.`project_id` AS 's_fk_unsigned_s_fmfiles__project_id',
	s_fk_unsigned_s_fmfiles.`file_manager_folder_id` AS 's_fk_unsigned_s_fmfiles__file_manager_folder_id',
	s_fk_unsigned_s_fmfiles.`file_location_id` AS 's_fk_unsigned_s_fmfiles__file_location_id',
	s_fk_unsigned_s_fmfiles.`virtual_file_name` AS 's_fk_unsigned_s_fmfiles__virtual_file_name',
	s_fk_unsigned_s_fmfiles.`version_number` AS 's_fk_unsigned_s_fmfiles__version_number',
	s_fk_unsigned_s_fmfiles.`virtual_file_name_sha1` AS 's_fk_unsigned_s_fmfiles__virtual_file_name_sha1',
	s_fk_unsigned_s_fmfiles.`virtual_file_mime_type` AS 's_fk_unsigned_s_fmfiles__virtual_file_mime_type',
	s_fk_unsigned_s_fmfiles.`modified` AS 's_fk_unsigned_s_fmfiles__modified',
	s_fk_unsigned_s_fmfiles.`created` AS 's_fk_unsigned_s_fmfiles__created',
	s_fk_unsigned_s_fmfiles.`deleted_flag` AS 's_fk_unsigned_s_fmfiles__deleted_flag',
	s_fk_unsigned_s_fmfiles.`directly_deleted_flag` AS 's_fk_unsigned_s_fmfiles__directly_deleted_flag',

	s_fk_signed_s_fmfiles.`id` AS 's_fk_signed_s_fmfiles__file_manager_file_id',
	s_fk_signed_s_fmfiles.`user_company_id` AS 's_fk_signed_s_fmfiles__user_company_id',
	s_fk_signed_s_fmfiles.`contact_id` AS 's_fk_signed_s_fmfiles__contact_id',
	s_fk_signed_s_fmfiles.`project_id` AS 's_fk_signed_s_fmfiles__project_id',
	s_fk_signed_s_fmfiles.`file_manager_folder_id` AS 's_fk_signed_s_fmfiles__file_manager_folder_id',
	s_fk_signed_s_fmfiles.`file_location_id` AS 's_fk_signed_s_fmfiles__file_location_id',
	s_fk_signed_s_fmfiles.`virtual_file_name` AS 's_fk_signed_s_fmfiles__virtual_file_name',
	s_fk_signed_s_fmfiles.`version_number` AS 's_fk_signed_s_fmfiles__version_number',
	s_fk_signed_s_fmfiles.`virtual_file_name_sha1` AS 's_fk_signed_s_fmfiles__virtual_file_name_sha1',
	s_fk_signed_s_fmfiles.`virtual_file_mime_type` AS 's_fk_signed_s_fmfiles__virtual_file_mime_type',
	s_fk_signed_s_fmfiles.`modified` AS 's_fk_signed_s_fmfiles__modified',
	s_fk_signed_s_fmfiles.`created` AS 's_fk_signed_s_fmfiles__created',
	s_fk_signed_s_fmfiles.`deleted_flag` AS 's_fk_signed_s_fmfiles__deleted_flag',
	s_fk_signed_s_fmfiles.`directly_deleted_flag` AS 's_fk_signed_s_fmfiles__directly_deleted_flag',

	s_fk_v__fk_cc.`id` AS 's_fk_v__fk_cc__contact_company_id',
	s_fk_v__fk_cc.`user_user_company_id` AS 's_fk_v__fk_cc__user_user_company_id',
	s_fk_v__fk_cc.`contact_user_company_id` AS 's_fk_v__fk_cc__contact_user_company_id',
	s_fk_v__fk_cc.`company` AS 's_fk_v__fk_cc__company',
	s_fk_v__fk_cc.`primary_phone_number` AS 's_fk_v__fk_cc__primary_phone_number',
	s_fk_v__fk_cc.`employer_identification_number` AS 's_fk_v__fk_cc__employer_identification_number',
	s_fk_v__fk_cc.`construction_license_number` AS 's_fk_v__fk_cc__construction_license_number',
	s_fk_v__fk_cc.`construction_license_number_expiration_date` AS 's_fk_v__fk_cc__construction_license_number_expiration_date',
	s_fk_v__fk_cc.`vendor_flag` AS 's_fk_v__fk_cc__vendor_flag',

	s.*,

	sctype.subcontract_type

FROM `subcontracts` s
	INNER JOIN `gc_budget_line_items` s_fk_gbli ON s.`gc_budget_line_item_id` = s_fk_gbli.`id`
	LEFT OUTER JOIN `subcontractor_bids` s_fk_sb ON s.`subcontractor_bid_id` = s_fk_sb.`id`
	INNER JOIN `subcontract_templates` s_fk_st ON s.`subcontract_template_id` = s_fk_st.`id`
	LEFT OUTER JOIN `contact_company_offices` s_fk_gc_cco ON s.`subcontract_gc_contact_company_office_id` = s_fk_gc_cco.`id`
	LEFT OUTER JOIN `contact_company_office_phone_numbers` s_fk_gc_phone_ccopn ON s.`subcontract_gc_phone_contact_company_office_phone_number_id` = s_fk_gc_phone_ccopn.`id`
	LEFT OUTER JOIN `contact_company_office_phone_numbers` s_fk_gc_fax_ccopn ON s.`subcontract_gc_fax_contact_company_office_phone_number_id` = s_fk_gc_fax_ccopn.`id`
	LEFT OUTER JOIN `contacts` s_fk_gc_c ON s.`subcontract_gc_contact_id` = s_fk_gc_c.`id`
	LEFT OUTER JOIN `contact_phone_numbers` s_fk_gc_c_mobile_cpn ON s.`subcontract_gc_contact_mobile_phone_number_id` = s_fk_gc_c_mobile_cpn.`id`
	INNER JOIN `vendors` s_fk_v ON s.`vendor_id` = s_fk_v.`id`
	LEFT OUTER JOIN `contact_company_offices` s_fk_v_cco ON s.`subcontract_vendor_contact_company_office_id` = s_fk_v_cco.`id`
	LEFT OUTER JOIN `contact_company_office_phone_numbers` s_fk_v_phone_ccopn ON s.`subcontract_vendor_phone_contact_company_office_phone_number_id` = s_fk_v_phone_ccopn.`id`
	LEFT OUTER JOIN `contact_company_office_phone_numbers` s_fk_v_fax_ccopn ON s.`subcontract_vendor_fax_contact_company_office_phone_number_id` = s_fk_v_fax_ccopn.`id`
	LEFT OUTER JOIN `contacts` s_fk_v_c ON s.`subcontract_vendor_contact_id` = s_fk_v_c.`id`
	LEFT OUTER JOIN `contact_phone_numbers` s_fk_v_c_mobile_cpn ON s.`subcontract_vendor_contact_mobile_phone_number_id` = s_fk_v_c_mobile_cpn.`id`
	LEFT OUTER JOIN `file_manager_files` s_fk_unsigned_s_fmfiles ON s.`unsigned_subcontract_file_manager_file_id` = s_fk_unsigned_s_fmfiles.`id`
	LEFT OUTER JOIN `file_manager_files` s_fk_signed_s_fmfiles ON s.`signed_subcontract_file_manager_file_id` = s_fk_signed_s_fmfiles.`id`

	INNER JOIN `contact_companies` s_fk_v__fk_cc ON s_fk_v.`vendor_contact_company_id` = s_fk_v__fk_cc.`id`
	INNER JOIN subcontract_types sctype ON s_fk_st.subcontract_type_id = sctype.`id`

WHERE s.`gc_budget_line_item_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `gc_budget_line_item_id` ASC, `subcontract_sequence_number` ASC, `subcontractor_bid_id` ASC, `subcontract_template_id` ASC, `subcontract_gc_contact_company_office_id` ASC, `subcontract_gc_phone_contact_company_office_phone_number_id` ASC, `subcontract_gc_fax_contact_company_office_phone_number_id` ASC, `subcontract_gc_contact_id` ASC, `subcontract_gc_contact_mobile_phone_number_id` ASC, `vendor_id` ASC, `subcontract_vendor_contact_company_office_id` ASC, `subcontract_vendor_phone_contact_company_office_phone_number_id` ASC, `subcontract_vendor_fax_contact_company_office_phone_number_id` ASC, `subcontract_vendor_contact_id` ASC, `subcontract_vendor_contact_mobile_phone_number_id` ASC, `unsigned_subcontract_file_manager_file_id` ASC, `signed_subcontract_file_manager_file_id` ASC, `subcontract_forecasted_value` ASC, `subcontract_actual_value` ASC, `subcontract_retention_percentage` ASC, `subcontract_issued_date` ASC, `subcontract_target_execution_date` ASC, `subcontract_execution_date` ASC, `active_flag` ASC
		$arrValues = array($gc_budget_line_item_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubcontractsByGcBudgetLineItemId = array();
		while ($row = $db->fetch()) {
			$subcontract_id = $row['id'];
			$subcontract = self::instantiateOrm($database, 'Subcontract', $row, null, $subcontract_id);
			/* @var $subcontract Subcontract */
			$subcontract->convertPropertiesToData();

			if (isset($row['gc_budget_line_item_id'])) {
				$gc_budget_line_item_id = $row['gc_budget_line_item_id'];
				$row['s_fk_gbli__id'] = $gc_budget_line_item_id;
				$gcBudgetLineItem = self::instantiateOrm($database, 'GcBudgetLineItem', $row, null, $gc_budget_line_item_id, 's_fk_gbli__');
				/* @var $gcBudgetLineItem GcBudgetLineItem */
				$gcBudgetLineItem->convertPropertiesToData();
			} else {
				$gcBudgetLineItem = false;
			}
			$subcontract->setGcBudgetLineItem($gcBudgetLineItem);

			if (isset($row['subcontractor_bid_id'])) {
				$subcontractor_bid_id = $row['subcontractor_bid_id'];
				$row['s_fk_sb__id'] = $subcontractor_bid_id;
				$subcontractorBid = self::instantiateOrm($database, 'SubcontractorBid', $row, null, $subcontractor_bid_id, 's_fk_sb__');
				/* @var $subcontractorBid SubcontractorBid */
				$subcontractorBid->convertPropertiesToData();
			} else {
				$subcontractorBid = false;
			}
			$subcontract->setSubcontractorBid($subcontractorBid);

			if (isset($row['subcontract_template_id'])) {
				$subcontract_template_id = $row['subcontract_template_id'];
				$row['s_fk_st__id'] = $subcontract_template_id;
				$subcontractTemplate = self::instantiateOrm($database, 'SubcontractTemplate', $row, null, $subcontract_template_id, 's_fk_st__');
				/* @var $subcontractTemplate SubcontractTemplate */
				$subcontractTemplate->convertPropertiesToData();
			} else {
				$subcontractTemplate = false;
			}
			$subcontract->setSubcontractTemplate($subcontractTemplate);

			if (isset($row['subcontract_gc_contact_company_office_id'])) {
				$subcontract_gc_contact_company_office_id = $row['subcontract_gc_contact_company_office_id'];
				$row['s_fk_gc_cco__id'] = $subcontract_gc_contact_company_office_id;
				$subcontractGcContactCompanyOffice = self::instantiateOrm($database, 'ContactCompanyOffice', $row, null, $subcontract_gc_contact_company_office_id, 's_fk_gc_cco__');
				/* @var $subcontractGcContactCompanyOffice ContactCompanyOffice */
				$subcontractGcContactCompanyOffice->convertPropertiesToData();
			} else {
				$subcontractGcContactCompanyOffice = false;
			}
			$subcontract->setSubcontractGcContactCompanyOffice($subcontractGcContactCompanyOffice);

			if (isset($row['subcontract_gc_phone_contact_company_office_phone_number_id'])) {
				$subcontract_gc_phone_contact_company_office_phone_number_id = $row['subcontract_gc_phone_contact_company_office_phone_number_id'];
				$row['s_fk_gc_phone_ccopn__id'] = $subcontract_gc_phone_contact_company_office_phone_number_id;
				$subcontractGcPhoneContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $subcontract_gc_phone_contact_company_office_phone_number_id, 's_fk_gc_phone_ccopn__');
				/* @var $subcontractGcPhoneContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$subcontractGcPhoneContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$subcontractGcPhoneContactCompanyOfficePhoneNumber = false;
			}
			$subcontract->setSubcontractGcPhoneContactCompanyOfficePhoneNumber($subcontractGcPhoneContactCompanyOfficePhoneNumber);

			if (isset($row['subcontract_gc_fax_contact_company_office_phone_number_id'])) {
				$subcontract_gc_fax_contact_company_office_phone_number_id = $row['subcontract_gc_fax_contact_company_office_phone_number_id'];
				$row['s_fk_gc_fax_ccopn__id'] = $subcontract_gc_fax_contact_company_office_phone_number_id;
				$subcontractGcFaxContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $subcontract_gc_fax_contact_company_office_phone_number_id, 's_fk_gc_fax_ccopn__');
				/* @var $subcontractGcFaxContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$subcontractGcFaxContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$subcontractGcFaxContactCompanyOfficePhoneNumber = false;
			}
			$subcontract->setSubcontractGcFaxContactCompanyOfficePhoneNumber($subcontractGcFaxContactCompanyOfficePhoneNumber);

			if (isset($row['subcontract_gc_contact_id'])) {
				$subcontract_gc_contact_id = $row['subcontract_gc_contact_id'];
				$row['s_fk_gc_c__id'] = $subcontract_gc_contact_id;
				$subcontractGcContact = self::instantiateOrm($database, 'Contact', $row, null, $subcontract_gc_contact_id, 's_fk_gc_c__');
				/* @var $subcontractGcContact Contact */
				$subcontractGcContact->convertPropertiesToData();
			} else {
				$subcontractGcContact = false;
			}
			$subcontract->setSubcontractGcContact($subcontractGcContact);

			if (isset($row['subcontract_gc_contact_mobile_phone_number_id'])) {
				$subcontract_gc_contact_mobile_phone_number_id = $row['subcontract_gc_contact_mobile_phone_number_id'];
				$row['s_fk_gc_c_mobile_cpn__id'] = $subcontract_gc_contact_mobile_phone_number_id;
				$subcontractGcContactMobilePhoneNumber = self::instantiateOrm($database, 'ContactPhoneNumber', $row, null, $subcontract_gc_contact_mobile_phone_number_id, 's_fk_gc_c_mobile_cpn__');
				/* @var $subcontractGcContactMobilePhoneNumber ContactPhoneNumber */
				$subcontractGcContactMobilePhoneNumber->convertPropertiesToData();
			} else {
				$subcontractGcContactMobilePhoneNumber = false;
			}
			$subcontract->setSubcontractGcContactMobilePhoneNumber($subcontractGcContactMobilePhoneNumber);

			if (isset($row['vendor_id'])) {
				$vendor_id = $row['vendor_id'];
				$row['s_fk_v__id'] = $vendor_id;
				$vendor = self::instantiateOrm($database, 'Vendor', $row, null, $vendor_id, 's_fk_v__');
				/* @var $vendor Vendor */
				$vendor->convertPropertiesToData();
			} else {
				$vendor = false;
			}
			$subcontract->setVendor($vendor);

			if (isset($row['subcontract_vendor_contact_company_office_id'])) {
				$subcontract_vendor_contact_company_office_id = $row['subcontract_vendor_contact_company_office_id'];
				$row['s_fk_v_cco__id'] = $subcontract_vendor_contact_company_office_id;
				$subcontractVendorContactCompanyOffice = self::instantiateOrm($database, 'ContactCompanyOffice', $row, null, $subcontract_vendor_contact_company_office_id, 's_fk_v_cco__');
				/* @var $subcontractVendorContactCompanyOffice ContactCompanyOffice */
				$subcontractVendorContactCompanyOffice->convertPropertiesToData();
			} else {
				$subcontractVendorContactCompanyOffice = false;
			}
			$subcontract->setSubcontractVendorContactCompanyOffice($subcontractVendorContactCompanyOffice);

			if (isset($row['subcontract_vendor_phone_contact_company_office_phone_number_id'])) {
				$subcontract_vendor_phone_contact_company_office_phone_number_id = $row['subcontract_vendor_phone_contact_company_office_phone_number_id'];
				$row['s_fk_v_phone_ccopn__id'] = $subcontract_vendor_phone_contact_company_office_phone_number_id;
				$subcontractVendorPhoneContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $subcontract_vendor_phone_contact_company_office_phone_number_id, 's_fk_v_phone_ccopn__');
				/* @var $subcontractVendorPhoneContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$subcontractVendorPhoneContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$subcontractVendorPhoneContactCompanyOfficePhoneNumber = false;
			}
			$subcontract->setSubcontractVendorPhoneContactCompanyOfficePhoneNumber($subcontractVendorPhoneContactCompanyOfficePhoneNumber);

			if (isset($row['subcontract_vendor_fax_contact_company_office_phone_number_id'])) {
				$subcontract_vendor_fax_contact_company_office_phone_number_id = $row['subcontract_vendor_fax_contact_company_office_phone_number_id'];
				$row['s_fk_v_fax_ccopn__id'] = $subcontract_vendor_fax_contact_company_office_phone_number_id;
				$subcontractVendorFaxContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $subcontract_vendor_fax_contact_company_office_phone_number_id, 's_fk_v_fax_ccopn__');
				/* @var $subcontractVendorFaxContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$subcontractVendorFaxContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$subcontractVendorFaxContactCompanyOfficePhoneNumber = false;
			}
			$subcontract->setSubcontractVendorFaxContactCompanyOfficePhoneNumber($subcontractVendorFaxContactCompanyOfficePhoneNumber);

			if (isset($row['subcontract_vendor_contact_id'])) {
				$subcontract_vendor_contact_id = $row['subcontract_vendor_contact_id'];
				$row['s_fk_v_c__id'] = $subcontract_vendor_contact_id;
				$subcontractVendorContact = self::instantiateOrm($database, 'Contact', $row, null, $subcontract_vendor_contact_id, 's_fk_v_c__');
				/* @var $subcontractVendorContact Contact */
				$subcontractVendorContact->convertPropertiesToData();
			} else {
				$subcontractVendorContact = false;
			}
			$subcontract->setSubcontractVendorContact($subcontractVendorContact);

			if (isset($row['subcontract_vendor_contact_mobile_phone_number_id'])) {
				$subcontract_vendor_contact_mobile_phone_number_id = $row['subcontract_vendor_contact_mobile_phone_number_id'];
				$row['s_fk_v_c_mobile_cpn__id'] = $subcontract_vendor_contact_mobile_phone_number_id;
				$subcontractVendorContactMobilePhoneNumber = self::instantiateOrm($database, 'ContactPhoneNumber', $row, null, $subcontract_vendor_contact_mobile_phone_number_id, 's_fk_v_c_mobile_cpn__');
				/* @var $subcontractVendorContactMobilePhoneNumber ContactPhoneNumber */
				$subcontractVendorContactMobilePhoneNumber->convertPropertiesToData();
			} else {
				$subcontractVendorContactMobilePhoneNumber = false;
			}
			$subcontract->setSubcontractVendorContactMobilePhoneNumber($subcontractVendorContactMobilePhoneNumber);

			if (isset($row['unsigned_subcontract_file_manager_file_id'])) {
				$unsigned_subcontract_file_manager_file_id = $row['unsigned_subcontract_file_manager_file_id'];
				$row['s_fk_unsigned_s_fmfiles__id'] = $unsigned_subcontract_file_manager_file_id;
				$unsignedSubcontractFileManagerFile = self::instantiateOrm($database, 'FileManagerFile', $row, null, $unsigned_subcontract_file_manager_file_id, 's_fk_unsigned_s_fmfiles__');
				/* @var $unsignedSubcontractFileManagerFile FileManagerFile */
				$unsignedSubcontractFileManagerFile->convertPropertiesToData();
			} else {
				$unsignedSubcontractFileManagerFile = false;
			}
			$subcontract->setUnsignedSubcontractFileManagerFile($unsignedSubcontractFileManagerFile);

			if (isset($row['signed_subcontract_file_manager_file_id'])) {
				$signed_subcontract_file_manager_file_id = $row['signed_subcontract_file_manager_file_id'];
				$row['s_fk_signed_s_fmfiles__id'] = $signed_subcontract_file_manager_file_id;
				$signedSubcontractFileManagerFile = self::instantiateOrm($database, 'FileManagerFile', $row, null, $signed_subcontract_file_manager_file_id, 's_fk_signed_s_fmfiles__');
				/* @var $signedSubcontractFileManagerFile FileManagerFile */
				$signedSubcontractFileManagerFile->convertPropertiesToData();
			} else {
				$signedSubcontractFileManagerFile = false;
			}
			$subcontract->setSignedSubcontractFileManagerFile($signedSubcontractFileManagerFile);

			if (isset($row['s_fk_v__fk_cc__contact_company_id'])) {
				$vendor_contact_company_id = $row['s_fk_v__fk_cc__contact_company_id'];
				$row['s_fk_v__fk_cc__id'] = $vendor_contact_company_id;
				$vendorContactCompany = self::instantiateOrm($database, 'ContactCompany', $row, null, $vendor_contact_company_id, 's_fk_v__fk_cc__');
				/* @var $vendorContactCompany ContactCompany */
				$vendorContactCompany->convertPropertiesToData();
			} else {
				$vendorContactCompany = false;
			}

			if ($vendor) {
				$vendor->setVendorContactCompany($vendorContactCompany);
				$vendor->setVendorContactCompanyOffice($subcontractVendorContactCompanyOffice);
				$vendor->setVendorContact($subcontractVendorContact);
				//$vendor->setContactAddress($subcontractVendorPhoneContactCompanyOfficePhoneNumber);
			}

			// Additional attributes
			$subcontract_type = $row['subcontract_type'];
			$subcontract->subcontract_type = $subcontract_type;

			$arrSubcontractsByGcBudgetLineItemId[$subcontract_id] = $subcontract;
		}

		$db->free_result();

		self::$_arrSubcontractsByGcBudgetLineItemId = $arrSubcontractsByGcBudgetLineItemId;

		return $arrSubcontractsByGcBudgetLineItemId;
	}

	/**
	 * Load by constraint `subcontracts_fk_sb` foreign key (`subcontractor_bid_id`) references `subcontractor_bids` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $subcontractor_bid_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubcontractsBySubcontractorBidId($database, $subcontractor_bid_id, Input $options=null)
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
			self::$_arrSubcontractsBySubcontractorBidId = null;
		}

		$arrSubcontractsBySubcontractorBidId = self::$_arrSubcontractsBySubcontractorBidId;
		if (isset($arrSubcontractsBySubcontractorBidId) && !empty($arrSubcontractsBySubcontractorBidId)) {
			return $arrSubcontractsBySubcontractorBidId;
		}

		$subcontractor_bid_id = (int) $subcontractor_bid_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `gc_budget_line_item_id` ASC, `subcontract_sequence_number` ASC, `subcontractor_bid_id` ASC, `subcontract_template_id` ASC, `subcontract_gc_contact_company_office_id` ASC, `subcontract_gc_phone_contact_company_office_phone_number_id` ASC, `subcontract_gc_fax_contact_company_office_phone_number_id` ASC, `subcontract_gc_contact_id` ASC, `subcontract_gc_contact_mobile_phone_number_id` ASC, `vendor_id` ASC, `subcontract_vendor_contact_company_office_id` ASC, `subcontract_vendor_phone_contact_company_office_phone_number_id` ASC, `subcontract_vendor_fax_contact_company_office_phone_number_id` ASC, `subcontract_vendor_contact_id` ASC, `subcontract_vendor_contact_mobile_phone_number_id` ASC, `unsigned_subcontract_file_manager_file_id` ASC, `signed_subcontract_file_manager_file_id` ASC, `subcontract_forecasted_value` ASC, `subcontract_actual_value` ASC, `subcontract_retention_percentage` ASC, `subcontract_issued_date` ASC, `subcontract_target_execution_date` ASC, `subcontract_execution_date` ASC, `active_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubcontract = new Subcontract($database);
			$sqlOrderByColumns = $tmpSubcontract->constructSqlOrderByColumns($arrOrderByAttributes);

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
	s.*

FROM `subcontracts` s
WHERE s.`subcontractor_bid_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `gc_budget_line_item_id` ASC, `subcontract_sequence_number` ASC, `subcontractor_bid_id` ASC, `subcontract_template_id` ASC, `subcontract_gc_contact_company_office_id` ASC, `subcontract_gc_phone_contact_company_office_phone_number_id` ASC, `subcontract_gc_fax_contact_company_office_phone_number_id` ASC, `subcontract_gc_contact_id` ASC, `subcontract_gc_contact_mobile_phone_number_id` ASC, `vendor_id` ASC, `subcontract_vendor_contact_company_office_id` ASC, `subcontract_vendor_phone_contact_company_office_phone_number_id` ASC, `subcontract_vendor_fax_contact_company_office_phone_number_id` ASC, `subcontract_vendor_contact_id` ASC, `subcontract_vendor_contact_mobile_phone_number_id` ASC, `unsigned_subcontract_file_manager_file_id` ASC, `signed_subcontract_file_manager_file_id` ASC, `subcontract_forecasted_value` ASC, `subcontract_actual_value` ASC, `subcontract_retention_percentage` ASC, `subcontract_issued_date` ASC, `subcontract_target_execution_date` ASC, `subcontract_execution_date` ASC, `active_flag` ASC
		$arrValues = array($subcontractor_bid_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubcontractsBySubcontractorBidId = array();
		while ($row = $db->fetch()) {
			$subcontract_id = $row['id'];
			$subcontract = self::instantiateOrm($database, 'Subcontract', $row, null, $subcontract_id);
			/* @var $subcontract Subcontract */
			$arrSubcontractsBySubcontractorBidId[$subcontract_id] = $subcontract;
		}

		$db->free_result();

		self::$_arrSubcontractsBySubcontractorBidId = $arrSubcontractsBySubcontractorBidId;

		return $arrSubcontractsBySubcontractorBidId;
	}

	/**
	 * Load by constraint `subcontracts_fk_st` foreign key (`subcontract_template_id`) references `subcontract_templates` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $subcontract_template_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubcontractsBySubcontractTemplateId($database, $subcontract_template_id, Input $options=null)
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
			self::$_arrSubcontractsBySubcontractTemplateId = null;
		}

		$arrSubcontractsBySubcontractTemplateId = self::$_arrSubcontractsBySubcontractTemplateId;
		if (isset($arrSubcontractsBySubcontractTemplateId) && !empty($arrSubcontractsBySubcontractTemplateId)) {
			return $arrSubcontractsBySubcontractTemplateId;
		}

		$subcontract_template_id = (int) $subcontract_template_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `gc_budget_line_item_id` ASC, `subcontract_sequence_number` ASC, `subcontractor_bid_id` ASC, `subcontract_template_id` ASC, `subcontract_gc_contact_company_office_id` ASC, `subcontract_gc_phone_contact_company_office_phone_number_id` ASC, `subcontract_gc_fax_contact_company_office_phone_number_id` ASC, `subcontract_gc_contact_id` ASC, `subcontract_gc_contact_mobile_phone_number_id` ASC, `vendor_id` ASC, `subcontract_vendor_contact_company_office_id` ASC, `subcontract_vendor_phone_contact_company_office_phone_number_id` ASC, `subcontract_vendor_fax_contact_company_office_phone_number_id` ASC, `subcontract_vendor_contact_id` ASC, `subcontract_vendor_contact_mobile_phone_number_id` ASC, `unsigned_subcontract_file_manager_file_id` ASC, `signed_subcontract_file_manager_file_id` ASC, `subcontract_forecasted_value` ASC, `subcontract_actual_value` ASC, `subcontract_retention_percentage` ASC, `subcontract_issued_date` ASC, `subcontract_target_execution_date` ASC, `subcontract_execution_date` ASC, `active_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubcontract = new Subcontract($database);
			$sqlOrderByColumns = $tmpSubcontract->constructSqlOrderByColumns($arrOrderByAttributes);

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
	s.*

FROM `subcontracts` s
WHERE s.`subcontract_template_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `gc_budget_line_item_id` ASC, `subcontract_sequence_number` ASC, `subcontractor_bid_id` ASC, `subcontract_template_id` ASC, `subcontract_gc_contact_company_office_id` ASC, `subcontract_gc_phone_contact_company_office_phone_number_id` ASC, `subcontract_gc_fax_contact_company_office_phone_number_id` ASC, `subcontract_gc_contact_id` ASC, `subcontract_gc_contact_mobile_phone_number_id` ASC, `vendor_id` ASC, `subcontract_vendor_contact_company_office_id` ASC, `subcontract_vendor_phone_contact_company_office_phone_number_id` ASC, `subcontract_vendor_fax_contact_company_office_phone_number_id` ASC, `subcontract_vendor_contact_id` ASC, `subcontract_vendor_contact_mobile_phone_number_id` ASC, `unsigned_subcontract_file_manager_file_id` ASC, `signed_subcontract_file_manager_file_id` ASC, `subcontract_forecasted_value` ASC, `subcontract_actual_value` ASC, `subcontract_retention_percentage` ASC, `subcontract_issued_date` ASC, `subcontract_target_execution_date` ASC, `subcontract_execution_date` ASC, `active_flag` ASC
		$arrValues = array($subcontract_template_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubcontractsBySubcontractTemplateId = array();
		while ($row = $db->fetch()) {
			$subcontract_id = $row['id'];
			$subcontract = self::instantiateOrm($database, 'Subcontract', $row, null, $subcontract_id);
			/* @var $subcontract Subcontract */
			$arrSubcontractsBySubcontractTemplateId[$subcontract_id] = $subcontract;
		}

		$db->free_result();

		self::$_arrSubcontractsBySubcontractTemplateId = $arrSubcontractsBySubcontractTemplateId;

		return $arrSubcontractsBySubcontractTemplateId;
	}

	/**
	 * Load by constraint `subcontracts_fk_gc_cco` foreign key (`subcontract_gc_contact_company_office_id`) references `contact_company_offices` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $subcontract_gc_contact_company_office_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubcontractsBySubcontractGcContactCompanyOfficeId($database, $subcontract_gc_contact_company_office_id, Input $options=null)
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
			self::$_arrSubcontractsBySubcontractGcContactCompanyOfficeId = null;
		}

		$arrSubcontractsBySubcontractGcContactCompanyOfficeId = self::$_arrSubcontractsBySubcontractGcContactCompanyOfficeId;
		if (isset($arrSubcontractsBySubcontractGcContactCompanyOfficeId) && !empty($arrSubcontractsBySubcontractGcContactCompanyOfficeId)) {
			return $arrSubcontractsBySubcontractGcContactCompanyOfficeId;
		}

		$subcontract_gc_contact_company_office_id = (int) $subcontract_gc_contact_company_office_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `gc_budget_line_item_id` ASC, `subcontract_sequence_number` ASC, `subcontractor_bid_id` ASC, `subcontract_template_id` ASC, `subcontract_gc_contact_company_office_id` ASC, `subcontract_gc_phone_contact_company_office_phone_number_id` ASC, `subcontract_gc_fax_contact_company_office_phone_number_id` ASC, `subcontract_gc_contact_id` ASC, `subcontract_gc_contact_mobile_phone_number_id` ASC, `vendor_id` ASC, `subcontract_vendor_contact_company_office_id` ASC, `subcontract_vendor_phone_contact_company_office_phone_number_id` ASC, `subcontract_vendor_fax_contact_company_office_phone_number_id` ASC, `subcontract_vendor_contact_id` ASC, `subcontract_vendor_contact_mobile_phone_number_id` ASC, `unsigned_subcontract_file_manager_file_id` ASC, `signed_subcontract_file_manager_file_id` ASC, `subcontract_forecasted_value` ASC, `subcontract_actual_value` ASC, `subcontract_retention_percentage` ASC, `subcontract_issued_date` ASC, `subcontract_target_execution_date` ASC, `subcontract_execution_date` ASC, `active_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubcontract = new Subcontract($database);
			$sqlOrderByColumns = $tmpSubcontract->constructSqlOrderByColumns($arrOrderByAttributes);

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
	s.*

FROM `subcontracts` s
WHERE s.`subcontract_gc_contact_company_office_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `gc_budget_line_item_id` ASC, `subcontract_sequence_number` ASC, `subcontractor_bid_id` ASC, `subcontract_template_id` ASC, `subcontract_gc_contact_company_office_id` ASC, `subcontract_gc_phone_contact_company_office_phone_number_id` ASC, `subcontract_gc_fax_contact_company_office_phone_number_id` ASC, `subcontract_gc_contact_id` ASC, `subcontract_gc_contact_mobile_phone_number_id` ASC, `vendor_id` ASC, `subcontract_vendor_contact_company_office_id` ASC, `subcontract_vendor_phone_contact_company_office_phone_number_id` ASC, `subcontract_vendor_fax_contact_company_office_phone_number_id` ASC, `subcontract_vendor_contact_id` ASC, `subcontract_vendor_contact_mobile_phone_number_id` ASC, `unsigned_subcontract_file_manager_file_id` ASC, `signed_subcontract_file_manager_file_id` ASC, `subcontract_forecasted_value` ASC, `subcontract_actual_value` ASC, `subcontract_retention_percentage` ASC, `subcontract_issued_date` ASC, `subcontract_target_execution_date` ASC, `subcontract_execution_date` ASC, `active_flag` ASC
		$arrValues = array($subcontract_gc_contact_company_office_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubcontractsBySubcontractGcContactCompanyOfficeId = array();
		while ($row = $db->fetch()) {
			$subcontract_id = $row['id'];
			$subcontract = self::instantiateOrm($database, 'Subcontract', $row, null, $subcontract_id);
			/* @var $subcontract Subcontract */
			$arrSubcontractsBySubcontractGcContactCompanyOfficeId[$subcontract_id] = $subcontract;
		}

		$db->free_result();

		self::$_arrSubcontractsBySubcontractGcContactCompanyOfficeId = $arrSubcontractsBySubcontractGcContactCompanyOfficeId;

		return $arrSubcontractsBySubcontractGcContactCompanyOfficeId;
	}

	/**
	 * Load by constraint `subcontracts_fk_gc_phone_ccopn` foreign key (`subcontract_gc_phone_contact_company_office_phone_number_id`) references `contact_company_office_phone_numbers` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $subcontract_gc_phone_contact_company_office_phone_number_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubcontractsBySubcontractGcPhoneContactCompanyOfficePhoneNumberId($database, $subcontract_gc_phone_contact_company_office_phone_number_id, Input $options=null)
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
			self::$_arrSubcontractsBySubcontractGcPhoneContactCompanyOfficePhoneNumberId = null;
		}

		$arrSubcontractsBySubcontractGcPhoneContactCompanyOfficePhoneNumberId = self::$_arrSubcontractsBySubcontractGcPhoneContactCompanyOfficePhoneNumberId;
		if (isset($arrSubcontractsBySubcontractGcPhoneContactCompanyOfficePhoneNumberId) && !empty($arrSubcontractsBySubcontractGcPhoneContactCompanyOfficePhoneNumberId)) {
			return $arrSubcontractsBySubcontractGcPhoneContactCompanyOfficePhoneNumberId;
		}

		$subcontract_gc_phone_contact_company_office_phone_number_id = (int) $subcontract_gc_phone_contact_company_office_phone_number_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `gc_budget_line_item_id` ASC, `subcontract_sequence_number` ASC, `subcontractor_bid_id` ASC, `subcontract_template_id` ASC, `subcontract_gc_contact_company_office_id` ASC, `subcontract_gc_phone_contact_company_office_phone_number_id` ASC, `subcontract_gc_fax_contact_company_office_phone_number_id` ASC, `subcontract_gc_contact_id` ASC, `subcontract_gc_contact_mobile_phone_number_id` ASC, `vendor_id` ASC, `subcontract_vendor_contact_company_office_id` ASC, `subcontract_vendor_phone_contact_company_office_phone_number_id` ASC, `subcontract_vendor_fax_contact_company_office_phone_number_id` ASC, `subcontract_vendor_contact_id` ASC, `subcontract_vendor_contact_mobile_phone_number_id` ASC, `unsigned_subcontract_file_manager_file_id` ASC, `signed_subcontract_file_manager_file_id` ASC, `subcontract_forecasted_value` ASC, `subcontract_actual_value` ASC, `subcontract_retention_percentage` ASC, `subcontract_issued_date` ASC, `subcontract_target_execution_date` ASC, `subcontract_execution_date` ASC, `active_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubcontract = new Subcontract($database);
			$sqlOrderByColumns = $tmpSubcontract->constructSqlOrderByColumns($arrOrderByAttributes);

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
	s.*

FROM `subcontracts` s
WHERE s.`subcontract_gc_phone_contact_company_office_phone_number_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `gc_budget_line_item_id` ASC, `subcontract_sequence_number` ASC, `subcontractor_bid_id` ASC, `subcontract_template_id` ASC, `subcontract_gc_contact_company_office_id` ASC, `subcontract_gc_phone_contact_company_office_phone_number_id` ASC, `subcontract_gc_fax_contact_company_office_phone_number_id` ASC, `subcontract_gc_contact_id` ASC, `subcontract_gc_contact_mobile_phone_number_id` ASC, `vendor_id` ASC, `subcontract_vendor_contact_company_office_id` ASC, `subcontract_vendor_phone_contact_company_office_phone_number_id` ASC, `subcontract_vendor_fax_contact_company_office_phone_number_id` ASC, `subcontract_vendor_contact_id` ASC, `subcontract_vendor_contact_mobile_phone_number_id` ASC, `unsigned_subcontract_file_manager_file_id` ASC, `signed_subcontract_file_manager_file_id` ASC, `subcontract_forecasted_value` ASC, `subcontract_actual_value` ASC, `subcontract_retention_percentage` ASC, `subcontract_issued_date` ASC, `subcontract_target_execution_date` ASC, `subcontract_execution_date` ASC, `active_flag` ASC
		$arrValues = array($subcontract_gc_phone_contact_company_office_phone_number_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubcontractsBySubcontractGcPhoneContactCompanyOfficePhoneNumberId = array();
		while ($row = $db->fetch()) {
			$subcontract_id = $row['id'];
			$subcontract = self::instantiateOrm($database, 'Subcontract', $row, null, $subcontract_id);
			/* @var $subcontract Subcontract */
			$arrSubcontractsBySubcontractGcPhoneContactCompanyOfficePhoneNumberId[$subcontract_id] = $subcontract;
		}

		$db->free_result();

		self::$_arrSubcontractsBySubcontractGcPhoneContactCompanyOfficePhoneNumberId = $arrSubcontractsBySubcontractGcPhoneContactCompanyOfficePhoneNumberId;

		return $arrSubcontractsBySubcontractGcPhoneContactCompanyOfficePhoneNumberId;
	}

	/**
	 * Load by constraint `subcontracts_fk_gc_fax_ccopn` foreign key (`subcontract_gc_fax_contact_company_office_phone_number_id`) references `contact_company_office_phone_numbers` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $subcontract_gc_fax_contact_company_office_phone_number_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubcontractsBySubcontractGcFaxContactCompanyOfficePhoneNumberId($database, $subcontract_gc_fax_contact_company_office_phone_number_id, Input $options=null)
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
			self::$_arrSubcontractsBySubcontractGcFaxContactCompanyOfficePhoneNumberId = null;
		}

		$arrSubcontractsBySubcontractGcFaxContactCompanyOfficePhoneNumberId = self::$_arrSubcontractsBySubcontractGcFaxContactCompanyOfficePhoneNumberId;
		if (isset($arrSubcontractsBySubcontractGcFaxContactCompanyOfficePhoneNumberId) && !empty($arrSubcontractsBySubcontractGcFaxContactCompanyOfficePhoneNumberId)) {
			return $arrSubcontractsBySubcontractGcFaxContactCompanyOfficePhoneNumberId;
		}

		$subcontract_gc_fax_contact_company_office_phone_number_id = (int) $subcontract_gc_fax_contact_company_office_phone_number_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `gc_budget_line_item_id` ASC, `subcontract_sequence_number` ASC, `subcontractor_bid_id` ASC, `subcontract_template_id` ASC, `subcontract_gc_contact_company_office_id` ASC, `subcontract_gc_phone_contact_company_office_phone_number_id` ASC, `subcontract_gc_fax_contact_company_office_phone_number_id` ASC, `subcontract_gc_contact_id` ASC, `subcontract_gc_contact_mobile_phone_number_id` ASC, `vendor_id` ASC, `subcontract_vendor_contact_company_office_id` ASC, `subcontract_vendor_phone_contact_company_office_phone_number_id` ASC, `subcontract_vendor_fax_contact_company_office_phone_number_id` ASC, `subcontract_vendor_contact_id` ASC, `subcontract_vendor_contact_mobile_phone_number_id` ASC, `unsigned_subcontract_file_manager_file_id` ASC, `signed_subcontract_file_manager_file_id` ASC, `subcontract_forecasted_value` ASC, `subcontract_actual_value` ASC, `subcontract_retention_percentage` ASC, `subcontract_issued_date` ASC, `subcontract_target_execution_date` ASC, `subcontract_execution_date` ASC, `active_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubcontract = new Subcontract($database);
			$sqlOrderByColumns = $tmpSubcontract->constructSqlOrderByColumns($arrOrderByAttributes);

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
	s.*

FROM `subcontracts` s
WHERE s.`subcontract_gc_fax_contact_company_office_phone_number_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `gc_budget_line_item_id` ASC, `subcontract_sequence_number` ASC, `subcontractor_bid_id` ASC, `subcontract_template_id` ASC, `subcontract_gc_contact_company_office_id` ASC, `subcontract_gc_phone_contact_company_office_phone_number_id` ASC, `subcontract_gc_fax_contact_company_office_phone_number_id` ASC, `subcontract_gc_contact_id` ASC, `subcontract_gc_contact_mobile_phone_number_id` ASC, `vendor_id` ASC, `subcontract_vendor_contact_company_office_id` ASC, `subcontract_vendor_phone_contact_company_office_phone_number_id` ASC, `subcontract_vendor_fax_contact_company_office_phone_number_id` ASC, `subcontract_vendor_contact_id` ASC, `subcontract_vendor_contact_mobile_phone_number_id` ASC, `unsigned_subcontract_file_manager_file_id` ASC, `signed_subcontract_file_manager_file_id` ASC, `subcontract_forecasted_value` ASC, `subcontract_actual_value` ASC, `subcontract_retention_percentage` ASC, `subcontract_issued_date` ASC, `subcontract_target_execution_date` ASC, `subcontract_execution_date` ASC, `active_flag` ASC
		$arrValues = array($subcontract_gc_fax_contact_company_office_phone_number_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubcontractsBySubcontractGcFaxContactCompanyOfficePhoneNumberId = array();
		while ($row = $db->fetch()) {
			$subcontract_id = $row['id'];
			$subcontract = self::instantiateOrm($database, 'Subcontract', $row, null, $subcontract_id);
			/* @var $subcontract Subcontract */
			$arrSubcontractsBySubcontractGcFaxContactCompanyOfficePhoneNumberId[$subcontract_id] = $subcontract;
		}

		$db->free_result();

		self::$_arrSubcontractsBySubcontractGcFaxContactCompanyOfficePhoneNumberId = $arrSubcontractsBySubcontractGcFaxContactCompanyOfficePhoneNumberId;

		return $arrSubcontractsBySubcontractGcFaxContactCompanyOfficePhoneNumberId;
	}

	/**
	 * Load by constraint `subcontracts_fk_gc_c` foreign key (`subcontract_gc_contact_id`) references `contacts` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $subcontract_gc_contact_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubcontractsBySubcontractGcContactId($database, $subcontract_gc_contact_id, Input $options=null)
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
			self::$_arrSubcontractsBySubcontractGcContactId = null;
		}

		$arrSubcontractsBySubcontractGcContactId = self::$_arrSubcontractsBySubcontractGcContactId;
		if (isset($arrSubcontractsBySubcontractGcContactId) && !empty($arrSubcontractsBySubcontractGcContactId)) {
			return $arrSubcontractsBySubcontractGcContactId;
		}

		$subcontract_gc_contact_id = (int) $subcontract_gc_contact_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `gc_budget_line_item_id` ASC, `subcontract_sequence_number` ASC, `subcontractor_bid_id` ASC, `subcontract_template_id` ASC, `subcontract_gc_contact_company_office_id` ASC, `subcontract_gc_phone_contact_company_office_phone_number_id` ASC, `subcontract_gc_fax_contact_company_office_phone_number_id` ASC, `subcontract_gc_contact_id` ASC, `subcontract_gc_contact_mobile_phone_number_id` ASC, `vendor_id` ASC, `subcontract_vendor_contact_company_office_id` ASC, `subcontract_vendor_phone_contact_company_office_phone_number_id` ASC, `subcontract_vendor_fax_contact_company_office_phone_number_id` ASC, `subcontract_vendor_contact_id` ASC, `subcontract_vendor_contact_mobile_phone_number_id` ASC, `unsigned_subcontract_file_manager_file_id` ASC, `signed_subcontract_file_manager_file_id` ASC, `subcontract_forecasted_value` ASC, `subcontract_actual_value` ASC, `subcontract_retention_percentage` ASC, `subcontract_issued_date` ASC, `subcontract_target_execution_date` ASC, `subcontract_execution_date` ASC, `active_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubcontract = new Subcontract($database);
			$sqlOrderByColumns = $tmpSubcontract->constructSqlOrderByColumns($arrOrderByAttributes);

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
	s.*

FROM `subcontracts` s
WHERE s.`subcontract_gc_contact_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `gc_budget_line_item_id` ASC, `subcontract_sequence_number` ASC, `subcontractor_bid_id` ASC, `subcontract_template_id` ASC, `subcontract_gc_contact_company_office_id` ASC, `subcontract_gc_phone_contact_company_office_phone_number_id` ASC, `subcontract_gc_fax_contact_company_office_phone_number_id` ASC, `subcontract_gc_contact_id` ASC, `subcontract_gc_contact_mobile_phone_number_id` ASC, `vendor_id` ASC, `subcontract_vendor_contact_company_office_id` ASC, `subcontract_vendor_phone_contact_company_office_phone_number_id` ASC, `subcontract_vendor_fax_contact_company_office_phone_number_id` ASC, `subcontract_vendor_contact_id` ASC, `subcontract_vendor_contact_mobile_phone_number_id` ASC, `unsigned_subcontract_file_manager_file_id` ASC, `signed_subcontract_file_manager_file_id` ASC, `subcontract_forecasted_value` ASC, `subcontract_actual_value` ASC, `subcontract_retention_percentage` ASC, `subcontract_issued_date` ASC, `subcontract_target_execution_date` ASC, `subcontract_execution_date` ASC, `active_flag` ASC
		$arrValues = array($subcontract_gc_contact_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubcontractsBySubcontractGcContactId = array();
		while ($row = $db->fetch()) {
			$subcontract_id = $row['id'];
			$subcontract = self::instantiateOrm($database, 'Subcontract', $row, null, $subcontract_id);
			/* @var $subcontract Subcontract */
			$arrSubcontractsBySubcontractGcContactId[$subcontract_id] = $subcontract;
		}

		$db->free_result();

		self::$_arrSubcontractsBySubcontractGcContactId = $arrSubcontractsBySubcontractGcContactId;

		return $arrSubcontractsBySubcontractGcContactId;
	}

	/**
	 * Load by constraint `subcontracts_fk_gc_c_mobile_cpn` foreign key (`subcontract_gc_contact_mobile_phone_number_id`) references `contact_phone_numbers` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $subcontract_gc_contact_mobile_phone_number_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubcontractsBySubcontractGcContactMobilePhoneNumberId($database, $subcontract_gc_contact_mobile_phone_number_id, Input $options=null)
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
			self::$_arrSubcontractsBySubcontractGcContactMobilePhoneNumberId = null;
		}

		$arrSubcontractsBySubcontractGcContactMobilePhoneNumberId = self::$_arrSubcontractsBySubcontractGcContactMobilePhoneNumberId;
		if (isset($arrSubcontractsBySubcontractGcContactMobilePhoneNumberId) && !empty($arrSubcontractsBySubcontractGcContactMobilePhoneNumberId)) {
			return $arrSubcontractsBySubcontractGcContactMobilePhoneNumberId;
		}

		$subcontract_gc_contact_mobile_phone_number_id = (int) $subcontract_gc_contact_mobile_phone_number_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `gc_budget_line_item_id` ASC, `subcontract_sequence_number` ASC, `subcontractor_bid_id` ASC, `subcontract_template_id` ASC, `subcontract_gc_contact_company_office_id` ASC, `subcontract_gc_phone_contact_company_office_phone_number_id` ASC, `subcontract_gc_fax_contact_company_office_phone_number_id` ASC, `subcontract_gc_contact_id` ASC, `subcontract_gc_contact_mobile_phone_number_id` ASC, `vendor_id` ASC, `subcontract_vendor_contact_company_office_id` ASC, `subcontract_vendor_phone_contact_company_office_phone_number_id` ASC, `subcontract_vendor_fax_contact_company_office_phone_number_id` ASC, `subcontract_vendor_contact_id` ASC, `subcontract_vendor_contact_mobile_phone_number_id` ASC, `unsigned_subcontract_file_manager_file_id` ASC, `signed_subcontract_file_manager_file_id` ASC, `subcontract_forecasted_value` ASC, `subcontract_actual_value` ASC, `subcontract_retention_percentage` ASC, `subcontract_issued_date` ASC, `subcontract_target_execution_date` ASC, `subcontract_execution_date` ASC, `active_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubcontract = new Subcontract($database);
			$sqlOrderByColumns = $tmpSubcontract->constructSqlOrderByColumns($arrOrderByAttributes);

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
	s.*

FROM `subcontracts` s
WHERE s.`subcontract_gc_contact_mobile_phone_number_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `gc_budget_line_item_id` ASC, `subcontract_sequence_number` ASC, `subcontractor_bid_id` ASC, `subcontract_template_id` ASC, `subcontract_gc_contact_company_office_id` ASC, `subcontract_gc_phone_contact_company_office_phone_number_id` ASC, `subcontract_gc_fax_contact_company_office_phone_number_id` ASC, `subcontract_gc_contact_id` ASC, `subcontract_gc_contact_mobile_phone_number_id` ASC, `vendor_id` ASC, `subcontract_vendor_contact_company_office_id` ASC, `subcontract_vendor_phone_contact_company_office_phone_number_id` ASC, `subcontract_vendor_fax_contact_company_office_phone_number_id` ASC, `subcontract_vendor_contact_id` ASC, `subcontract_vendor_contact_mobile_phone_number_id` ASC, `unsigned_subcontract_file_manager_file_id` ASC, `signed_subcontract_file_manager_file_id` ASC, `subcontract_forecasted_value` ASC, `subcontract_actual_value` ASC, `subcontract_retention_percentage` ASC, `subcontract_issued_date` ASC, `subcontract_target_execution_date` ASC, `subcontract_execution_date` ASC, `active_flag` ASC
		$arrValues = array($subcontract_gc_contact_mobile_phone_number_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubcontractsBySubcontractGcContactMobilePhoneNumberId = array();
		while ($row = $db->fetch()) {
			$subcontract_id = $row['id'];
			$subcontract = self::instantiateOrm($database, 'Subcontract', $row, null, $subcontract_id);
			/* @var $subcontract Subcontract */
			$arrSubcontractsBySubcontractGcContactMobilePhoneNumberId[$subcontract_id] = $subcontract;
		}

		$db->free_result();

		self::$_arrSubcontractsBySubcontractGcContactMobilePhoneNumberId = $arrSubcontractsBySubcontractGcContactMobilePhoneNumberId;

		return $arrSubcontractsBySubcontractGcContactMobilePhoneNumberId;
	}

	/**
	 * Load by constraint `subcontracts_fk_v` foreign key (`vendor_id`) references `vendors` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $vendor_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubcontractsByVendorId($database, $vendor_id, Input $options=null)
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
			self::$_arrSubcontractsByVendorId = null;
		}

		$arrSubcontractsByVendorId = self::$_arrSubcontractsByVendorId;
		if (isset($arrSubcontractsByVendorId) && !empty($arrSubcontractsByVendorId)) {
			return $arrSubcontractsByVendorId;
		}

		$vendor_id = (int) $vendor_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `gc_budget_line_item_id` ASC, `subcontract_sequence_number` ASC, `subcontractor_bid_id` ASC, `subcontract_template_id` ASC, `subcontract_gc_contact_company_office_id` ASC, `subcontract_gc_phone_contact_company_office_phone_number_id` ASC, `subcontract_gc_fax_contact_company_office_phone_number_id` ASC, `subcontract_gc_contact_id` ASC, `subcontract_gc_contact_mobile_phone_number_id` ASC, `vendor_id` ASC, `subcontract_vendor_contact_company_office_id` ASC, `subcontract_vendor_phone_contact_company_office_phone_number_id` ASC, `subcontract_vendor_fax_contact_company_office_phone_number_id` ASC, `subcontract_vendor_contact_id` ASC, `subcontract_vendor_contact_mobile_phone_number_id` ASC, `unsigned_subcontract_file_manager_file_id` ASC, `signed_subcontract_file_manager_file_id` ASC, `subcontract_forecasted_value` ASC, `subcontract_actual_value` ASC, `subcontract_retention_percentage` ASC, `subcontract_issued_date` ASC, `subcontract_target_execution_date` ASC, `subcontract_execution_date` ASC, `active_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubcontract = new Subcontract($database);
			$sqlOrderByColumns = $tmpSubcontract->constructSqlOrderByColumns($arrOrderByAttributes);

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
	s.*

FROM `subcontracts` s
WHERE s.`vendor_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `gc_budget_line_item_id` ASC, `subcontract_sequence_number` ASC, `subcontractor_bid_id` ASC, `subcontract_template_id` ASC, `subcontract_gc_contact_company_office_id` ASC, `subcontract_gc_phone_contact_company_office_phone_number_id` ASC, `subcontract_gc_fax_contact_company_office_phone_number_id` ASC, `subcontract_gc_contact_id` ASC, `subcontract_gc_contact_mobile_phone_number_id` ASC, `vendor_id` ASC, `subcontract_vendor_contact_company_office_id` ASC, `subcontract_vendor_phone_contact_company_office_phone_number_id` ASC, `subcontract_vendor_fax_contact_company_office_phone_number_id` ASC, `subcontract_vendor_contact_id` ASC, `subcontract_vendor_contact_mobile_phone_number_id` ASC, `unsigned_subcontract_file_manager_file_id` ASC, `signed_subcontract_file_manager_file_id` ASC, `subcontract_forecasted_value` ASC, `subcontract_actual_value` ASC, `subcontract_retention_percentage` ASC, `subcontract_issued_date` ASC, `subcontract_target_execution_date` ASC, `subcontract_execution_date` ASC, `active_flag` ASC
		$arrValues = array($vendor_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubcontractsByVendorId = array();
		while ($row = $db->fetch()) {
			$subcontract_id = $row['id'];
			$subcontract = self::instantiateOrm($database, 'Subcontract', $row, null, $subcontract_id);
			/* @var $subcontract Subcontract */
			$arrSubcontractsByVendorId[$subcontract_id] = $subcontract;
		}

		$db->free_result();

		self::$_arrSubcontractsByVendorId = $arrSubcontractsByVendorId;

		return $arrSubcontractsByVendorId;
	}

	/**
	 * Load by constraint `subcontracts_fk_v_cco` foreign key (`subcontract_vendor_contact_company_office_id`) references `contact_company_offices` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $subcontract_vendor_contact_company_office_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubcontractsBySubcontractVendorContactCompanyOfficeId($database, $subcontract_vendor_contact_company_office_id, Input $options=null)
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
			self::$_arrSubcontractsBySubcontractVendorContactCompanyOfficeId = null;
		}

		$arrSubcontractsBySubcontractVendorContactCompanyOfficeId = self::$_arrSubcontractsBySubcontractVendorContactCompanyOfficeId;
		if (isset($arrSubcontractsBySubcontractVendorContactCompanyOfficeId) && !empty($arrSubcontractsBySubcontractVendorContactCompanyOfficeId)) {
			return $arrSubcontractsBySubcontractVendorContactCompanyOfficeId;
		}

		$subcontract_vendor_contact_company_office_id = (int) $subcontract_vendor_contact_company_office_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `gc_budget_line_item_id` ASC, `subcontract_sequence_number` ASC, `subcontractor_bid_id` ASC, `subcontract_template_id` ASC, `subcontract_gc_contact_company_office_id` ASC, `subcontract_gc_phone_contact_company_office_phone_number_id` ASC, `subcontract_gc_fax_contact_company_office_phone_number_id` ASC, `subcontract_gc_contact_id` ASC, `subcontract_gc_contact_mobile_phone_number_id` ASC, `vendor_id` ASC, `subcontract_vendor_contact_company_office_id` ASC, `subcontract_vendor_phone_contact_company_office_phone_number_id` ASC, `subcontract_vendor_fax_contact_company_office_phone_number_id` ASC, `subcontract_vendor_contact_id` ASC, `subcontract_vendor_contact_mobile_phone_number_id` ASC, `unsigned_subcontract_file_manager_file_id` ASC, `signed_subcontract_file_manager_file_id` ASC, `subcontract_forecasted_value` ASC, `subcontract_actual_value` ASC, `subcontract_retention_percentage` ASC, `subcontract_issued_date` ASC, `subcontract_target_execution_date` ASC, `subcontract_execution_date` ASC, `active_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubcontract = new Subcontract($database);
			$sqlOrderByColumns = $tmpSubcontract->constructSqlOrderByColumns($arrOrderByAttributes);

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
	s.*

FROM `subcontracts` s
WHERE s.`subcontract_vendor_contact_company_office_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `gc_budget_line_item_id` ASC, `subcontract_sequence_number` ASC, `subcontractor_bid_id` ASC, `subcontract_template_id` ASC, `subcontract_gc_contact_company_office_id` ASC, `subcontract_gc_phone_contact_company_office_phone_number_id` ASC, `subcontract_gc_fax_contact_company_office_phone_number_id` ASC, `subcontract_gc_contact_id` ASC, `subcontract_gc_contact_mobile_phone_number_id` ASC, `vendor_id` ASC, `subcontract_vendor_contact_company_office_id` ASC, `subcontract_vendor_phone_contact_company_office_phone_number_id` ASC, `subcontract_vendor_fax_contact_company_office_phone_number_id` ASC, `subcontract_vendor_contact_id` ASC, `subcontract_vendor_contact_mobile_phone_number_id` ASC, `unsigned_subcontract_file_manager_file_id` ASC, `signed_subcontract_file_manager_file_id` ASC, `subcontract_forecasted_value` ASC, `subcontract_actual_value` ASC, `subcontract_retention_percentage` ASC, `subcontract_issued_date` ASC, `subcontract_target_execution_date` ASC, `subcontract_execution_date` ASC, `active_flag` ASC
		$arrValues = array($subcontract_vendor_contact_company_office_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubcontractsBySubcontractVendorContactCompanyOfficeId = array();
		while ($row = $db->fetch()) {
			$subcontract_id = $row['id'];
			$subcontract = self::instantiateOrm($database, 'Subcontract', $row, null, $subcontract_id);
			/* @var $subcontract Subcontract */
			$arrSubcontractsBySubcontractVendorContactCompanyOfficeId[$subcontract_id] = $subcontract;
		}

		$db->free_result();

		self::$_arrSubcontractsBySubcontractVendorContactCompanyOfficeId = $arrSubcontractsBySubcontractVendorContactCompanyOfficeId;

		return $arrSubcontractsBySubcontractVendorContactCompanyOfficeId;
	}

	/**
	 * Load by constraint `subcontracts_fk_v_phone_ccopn` foreign key (`subcontract_vendor_phone_contact_company_office_phone_number_id`) references `contact_company_office_phone_numbers` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $subcontract_vendor_phone_contact_company_office_phone_number_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubcontractsBySubcontractVendorPhoneContactCompanyOfficePhoneNumberId($database, $subcontract_vendor_phone_contact_company_office_phone_number_id, Input $options=null)
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
			self::$_arrSubcontractsBySubcontractVendorPhoneContactCompanyOfficePhoneNumberId = null;
		}

		$arrSubcontractsBySubcontractVendorPhoneContactCompanyOfficePhoneNumberId = self::$_arrSubcontractsBySubcontractVendorPhoneContactCompanyOfficePhoneNumberId;
		if (isset($arrSubcontractsBySubcontractVendorPhoneContactCompanyOfficePhoneNumberId) && !empty($arrSubcontractsBySubcontractVendorPhoneContactCompanyOfficePhoneNumberId)) {
			return $arrSubcontractsBySubcontractVendorPhoneContactCompanyOfficePhoneNumberId;
		}

		$subcontract_vendor_phone_contact_company_office_phone_number_id = (int) $subcontract_vendor_phone_contact_company_office_phone_number_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `gc_budget_line_item_id` ASC, `subcontract_sequence_number` ASC, `subcontractor_bid_id` ASC, `subcontract_template_id` ASC, `subcontract_gc_contact_company_office_id` ASC, `subcontract_gc_phone_contact_company_office_phone_number_id` ASC, `subcontract_gc_fax_contact_company_office_phone_number_id` ASC, `subcontract_gc_contact_id` ASC, `subcontract_gc_contact_mobile_phone_number_id` ASC, `vendor_id` ASC, `subcontract_vendor_contact_company_office_id` ASC, `subcontract_vendor_phone_contact_company_office_phone_number_id` ASC, `subcontract_vendor_fax_contact_company_office_phone_number_id` ASC, `subcontract_vendor_contact_id` ASC, `subcontract_vendor_contact_mobile_phone_number_id` ASC, `unsigned_subcontract_file_manager_file_id` ASC, `signed_subcontract_file_manager_file_id` ASC, `subcontract_forecasted_value` ASC, `subcontract_actual_value` ASC, `subcontract_retention_percentage` ASC, `subcontract_issued_date` ASC, `subcontract_target_execution_date` ASC, `subcontract_execution_date` ASC, `active_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubcontract = new Subcontract($database);
			$sqlOrderByColumns = $tmpSubcontract->constructSqlOrderByColumns($arrOrderByAttributes);

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
	s.*

FROM `subcontracts` s
WHERE s.`subcontract_vendor_phone_contact_company_office_phone_number_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `gc_budget_line_item_id` ASC, `subcontract_sequence_number` ASC, `subcontractor_bid_id` ASC, `subcontract_template_id` ASC, `subcontract_gc_contact_company_office_id` ASC, `subcontract_gc_phone_contact_company_office_phone_number_id` ASC, `subcontract_gc_fax_contact_company_office_phone_number_id` ASC, `subcontract_gc_contact_id` ASC, `subcontract_gc_contact_mobile_phone_number_id` ASC, `vendor_id` ASC, `subcontract_vendor_contact_company_office_id` ASC, `subcontract_vendor_phone_contact_company_office_phone_number_id` ASC, `subcontract_vendor_fax_contact_company_office_phone_number_id` ASC, `subcontract_vendor_contact_id` ASC, `subcontract_vendor_contact_mobile_phone_number_id` ASC, `unsigned_subcontract_file_manager_file_id` ASC, `signed_subcontract_file_manager_file_id` ASC, `subcontract_forecasted_value` ASC, `subcontract_actual_value` ASC, `subcontract_retention_percentage` ASC, `subcontract_issued_date` ASC, `subcontract_target_execution_date` ASC, `subcontract_execution_date` ASC, `active_flag` ASC
		$arrValues = array($subcontract_vendor_phone_contact_company_office_phone_number_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubcontractsBySubcontractVendorPhoneContactCompanyOfficePhoneNumberId = array();
		while ($row = $db->fetch()) {
			$subcontract_id = $row['id'];
			$subcontract = self::instantiateOrm($database, 'Subcontract', $row, null, $subcontract_id);
			/* @var $subcontract Subcontract */
			$arrSubcontractsBySubcontractVendorPhoneContactCompanyOfficePhoneNumberId[$subcontract_id] = $subcontract;
		}

		$db->free_result();

		self::$_arrSubcontractsBySubcontractVendorPhoneContactCompanyOfficePhoneNumberId = $arrSubcontractsBySubcontractVendorPhoneContactCompanyOfficePhoneNumberId;

		return $arrSubcontractsBySubcontractVendorPhoneContactCompanyOfficePhoneNumberId;
	}

	/**
	 * Load by constraint `subcontracts_fk_v_fax_ccopn` foreign key (`subcontract_vendor_fax_contact_company_office_phone_number_id`) references `contact_company_office_phone_numbers` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $subcontract_vendor_fax_contact_company_office_phone_number_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubcontractsBySubcontractVendorFaxContactCompanyOfficePhoneNumberId($database, $subcontract_vendor_fax_contact_company_office_phone_number_id, Input $options=null)
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
			self::$_arrSubcontractsBySubcontractVendorFaxContactCompanyOfficePhoneNumberId = null;
		}

		$arrSubcontractsBySubcontractVendorFaxContactCompanyOfficePhoneNumberId = self::$_arrSubcontractsBySubcontractVendorFaxContactCompanyOfficePhoneNumberId;
		if (isset($arrSubcontractsBySubcontractVendorFaxContactCompanyOfficePhoneNumberId) && !empty($arrSubcontractsBySubcontractVendorFaxContactCompanyOfficePhoneNumberId)) {
			return $arrSubcontractsBySubcontractVendorFaxContactCompanyOfficePhoneNumberId;
		}

		$subcontract_vendor_fax_contact_company_office_phone_number_id = (int) $subcontract_vendor_fax_contact_company_office_phone_number_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `gc_budget_line_item_id` ASC, `subcontract_sequence_number` ASC, `subcontractor_bid_id` ASC, `subcontract_template_id` ASC, `subcontract_gc_contact_company_office_id` ASC, `subcontract_gc_phone_contact_company_office_phone_number_id` ASC, `subcontract_gc_fax_contact_company_office_phone_number_id` ASC, `subcontract_gc_contact_id` ASC, `subcontract_gc_contact_mobile_phone_number_id` ASC, `vendor_id` ASC, `subcontract_vendor_contact_company_office_id` ASC, `subcontract_vendor_phone_contact_company_office_phone_number_id` ASC, `subcontract_vendor_fax_contact_company_office_phone_number_id` ASC, `subcontract_vendor_contact_id` ASC, `subcontract_vendor_contact_mobile_phone_number_id` ASC, `unsigned_subcontract_file_manager_file_id` ASC, `signed_subcontract_file_manager_file_id` ASC, `subcontract_forecasted_value` ASC, `subcontract_actual_value` ASC, `subcontract_retention_percentage` ASC, `subcontract_issued_date` ASC, `subcontract_target_execution_date` ASC, `subcontract_execution_date` ASC, `active_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubcontract = new Subcontract($database);
			$sqlOrderByColumns = $tmpSubcontract->constructSqlOrderByColumns($arrOrderByAttributes);

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
	s.*

FROM `subcontracts` s
WHERE s.`subcontract_vendor_fax_contact_company_office_phone_number_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `gc_budget_line_item_id` ASC, `subcontract_sequence_number` ASC, `subcontractor_bid_id` ASC, `subcontract_template_id` ASC, `subcontract_gc_contact_company_office_id` ASC, `subcontract_gc_phone_contact_company_office_phone_number_id` ASC, `subcontract_gc_fax_contact_company_office_phone_number_id` ASC, `subcontract_gc_contact_id` ASC, `subcontract_gc_contact_mobile_phone_number_id` ASC, `vendor_id` ASC, `subcontract_vendor_contact_company_office_id` ASC, `subcontract_vendor_phone_contact_company_office_phone_number_id` ASC, `subcontract_vendor_fax_contact_company_office_phone_number_id` ASC, `subcontract_vendor_contact_id` ASC, `subcontract_vendor_contact_mobile_phone_number_id` ASC, `unsigned_subcontract_file_manager_file_id` ASC, `signed_subcontract_file_manager_file_id` ASC, `subcontract_forecasted_value` ASC, `subcontract_actual_value` ASC, `subcontract_retention_percentage` ASC, `subcontract_issued_date` ASC, `subcontract_target_execution_date` ASC, `subcontract_execution_date` ASC, `active_flag` ASC
		$arrValues = array($subcontract_vendor_fax_contact_company_office_phone_number_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubcontractsBySubcontractVendorFaxContactCompanyOfficePhoneNumberId = array();
		while ($row = $db->fetch()) {
			$subcontract_id = $row['id'];
			$subcontract = self::instantiateOrm($database, 'Subcontract', $row, null, $subcontract_id);
			/* @var $subcontract Subcontract */
			$arrSubcontractsBySubcontractVendorFaxContactCompanyOfficePhoneNumberId[$subcontract_id] = $subcontract;
		}

		$db->free_result();

		self::$_arrSubcontractsBySubcontractVendorFaxContactCompanyOfficePhoneNumberId = $arrSubcontractsBySubcontractVendorFaxContactCompanyOfficePhoneNumberId;

		return $arrSubcontractsBySubcontractVendorFaxContactCompanyOfficePhoneNumberId;
	}

	/**
	 * Load by constraint `subcontracts_fk_v_c` foreign key (`subcontract_vendor_contact_id`) references `contacts` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $subcontract_vendor_contact_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubcontractsBySubcontractVendorContactId($database, $subcontract_vendor_contact_id, Input $options=null)
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
			self::$_arrSubcontractsBySubcontractVendorContactId = null;
		}

		$arrSubcontractsBySubcontractVendorContactId = self::$_arrSubcontractsBySubcontractVendorContactId;
		if (isset($arrSubcontractsBySubcontractVendorContactId) && !empty($arrSubcontractsBySubcontractVendorContactId)) {
			return $arrSubcontractsBySubcontractVendorContactId;
		}

		$subcontract_vendor_contact_id = (int) $subcontract_vendor_contact_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `gc_budget_line_item_id` ASC, `subcontract_sequence_number` ASC, `subcontractor_bid_id` ASC, `subcontract_template_id` ASC, `subcontract_gc_contact_company_office_id` ASC, `subcontract_gc_phone_contact_company_office_phone_number_id` ASC, `subcontract_gc_fax_contact_company_office_phone_number_id` ASC, `subcontract_gc_contact_id` ASC, `subcontract_gc_contact_mobile_phone_number_id` ASC, `vendor_id` ASC, `subcontract_vendor_contact_company_office_id` ASC, `subcontract_vendor_phone_contact_company_office_phone_number_id` ASC, `subcontract_vendor_fax_contact_company_office_phone_number_id` ASC, `subcontract_vendor_contact_id` ASC, `subcontract_vendor_contact_mobile_phone_number_id` ASC, `unsigned_subcontract_file_manager_file_id` ASC, `signed_subcontract_file_manager_file_id` ASC, `subcontract_forecasted_value` ASC, `subcontract_actual_value` ASC, `subcontract_retention_percentage` ASC, `subcontract_issued_date` ASC, `subcontract_target_execution_date` ASC, `subcontract_execution_date` ASC, `active_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubcontract = new Subcontract($database);
			$sqlOrderByColumns = $tmpSubcontract->constructSqlOrderByColumns($arrOrderByAttributes);

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
	s.*

FROM `subcontracts` s
WHERE s.`subcontract_vendor_contact_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `gc_budget_line_item_id` ASC, `subcontract_sequence_number` ASC, `subcontractor_bid_id` ASC, `subcontract_template_id` ASC, `subcontract_gc_contact_company_office_id` ASC, `subcontract_gc_phone_contact_company_office_phone_number_id` ASC, `subcontract_gc_fax_contact_company_office_phone_number_id` ASC, `subcontract_gc_contact_id` ASC, `subcontract_gc_contact_mobile_phone_number_id` ASC, `vendor_id` ASC, `subcontract_vendor_contact_company_office_id` ASC, `subcontract_vendor_phone_contact_company_office_phone_number_id` ASC, `subcontract_vendor_fax_contact_company_office_phone_number_id` ASC, `subcontract_vendor_contact_id` ASC, `subcontract_vendor_contact_mobile_phone_number_id` ASC, `unsigned_subcontract_file_manager_file_id` ASC, `signed_subcontract_file_manager_file_id` ASC, `subcontract_forecasted_value` ASC, `subcontract_actual_value` ASC, `subcontract_retention_percentage` ASC, `subcontract_issued_date` ASC, `subcontract_target_execution_date` ASC, `subcontract_execution_date` ASC, `active_flag` ASC
		$arrValues = array($subcontract_vendor_contact_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubcontractsBySubcontractVendorContactId = array();
		while ($row = $db->fetch()) {
			$subcontract_id = $row['id'];
			$subcontract = self::instantiateOrm($database, 'Subcontract', $row, null, $subcontract_id);
			/* @var $subcontract Subcontract */
			$arrSubcontractsBySubcontractVendorContactId[$subcontract_id] = $subcontract;
		}

		$db->free_result();

		self::$_arrSubcontractsBySubcontractVendorContactId = $arrSubcontractsBySubcontractVendorContactId;

		return $arrSubcontractsBySubcontractVendorContactId;
	}

	/**
	 * Load by constraint `subcontracts_fk_v_c_mobile_cpn` foreign key (`subcontract_vendor_contact_mobile_phone_number_id`) references `contact_phone_numbers` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $subcontract_vendor_contact_mobile_phone_number_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubcontractsBySubcontractVendorContactMobilePhoneNumberId($database, $subcontract_vendor_contact_mobile_phone_number_id, Input $options=null)
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
			self::$_arrSubcontractsBySubcontractVendorContactMobilePhoneNumberId = null;
		}

		$arrSubcontractsBySubcontractVendorContactMobilePhoneNumberId = self::$_arrSubcontractsBySubcontractVendorContactMobilePhoneNumberId;
		if (isset($arrSubcontractsBySubcontractVendorContactMobilePhoneNumberId) && !empty($arrSubcontractsBySubcontractVendorContactMobilePhoneNumberId)) {
			return $arrSubcontractsBySubcontractVendorContactMobilePhoneNumberId;
		}

		$subcontract_vendor_contact_mobile_phone_number_id = (int) $subcontract_vendor_contact_mobile_phone_number_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `gc_budget_line_item_id` ASC, `subcontract_sequence_number` ASC, `subcontractor_bid_id` ASC, `subcontract_template_id` ASC, `subcontract_gc_contact_company_office_id` ASC, `subcontract_gc_phone_contact_company_office_phone_number_id` ASC, `subcontract_gc_fax_contact_company_office_phone_number_id` ASC, `subcontract_gc_contact_id` ASC, `subcontract_gc_contact_mobile_phone_number_id` ASC, `vendor_id` ASC, `subcontract_vendor_contact_company_office_id` ASC, `subcontract_vendor_phone_contact_company_office_phone_number_id` ASC, `subcontract_vendor_fax_contact_company_office_phone_number_id` ASC, `subcontract_vendor_contact_id` ASC, `subcontract_vendor_contact_mobile_phone_number_id` ASC, `unsigned_subcontract_file_manager_file_id` ASC, `signed_subcontract_file_manager_file_id` ASC, `subcontract_forecasted_value` ASC, `subcontract_actual_value` ASC, `subcontract_retention_percentage` ASC, `subcontract_issued_date` ASC, `subcontract_target_execution_date` ASC, `subcontract_execution_date` ASC, `active_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubcontract = new Subcontract($database);
			$sqlOrderByColumns = $tmpSubcontract->constructSqlOrderByColumns($arrOrderByAttributes);

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
	s.*

FROM `subcontracts` s
WHERE s.`subcontract_vendor_contact_mobile_phone_number_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `gc_budget_line_item_id` ASC, `subcontract_sequence_number` ASC, `subcontractor_bid_id` ASC, `subcontract_template_id` ASC, `subcontract_gc_contact_company_office_id` ASC, `subcontract_gc_phone_contact_company_office_phone_number_id` ASC, `subcontract_gc_fax_contact_company_office_phone_number_id` ASC, `subcontract_gc_contact_id` ASC, `subcontract_gc_contact_mobile_phone_number_id` ASC, `vendor_id` ASC, `subcontract_vendor_contact_company_office_id` ASC, `subcontract_vendor_phone_contact_company_office_phone_number_id` ASC, `subcontract_vendor_fax_contact_company_office_phone_number_id` ASC, `subcontract_vendor_contact_id` ASC, `subcontract_vendor_contact_mobile_phone_number_id` ASC, `unsigned_subcontract_file_manager_file_id` ASC, `signed_subcontract_file_manager_file_id` ASC, `subcontract_forecasted_value` ASC, `subcontract_actual_value` ASC, `subcontract_retention_percentage` ASC, `subcontract_issued_date` ASC, `subcontract_target_execution_date` ASC, `subcontract_execution_date` ASC, `active_flag` ASC
		$arrValues = array($subcontract_vendor_contact_mobile_phone_number_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubcontractsBySubcontractVendorContactMobilePhoneNumberId = array();
		while ($row = $db->fetch()) {
			$subcontract_id = $row['id'];
			$subcontract = self::instantiateOrm($database, 'Subcontract', $row, null, $subcontract_id);
			/* @var $subcontract Subcontract */
			$arrSubcontractsBySubcontractVendorContactMobilePhoneNumberId[$subcontract_id] = $subcontract;
		}

		$db->free_result();

		self::$_arrSubcontractsBySubcontractVendorContactMobilePhoneNumberId = $arrSubcontractsBySubcontractVendorContactMobilePhoneNumberId;

		return $arrSubcontractsBySubcontractVendorContactMobilePhoneNumberId;
	}

	/**
	 * Load by constraint `subcontracts_fk_unsigned_s_fmfiles` foreign key (`unsigned_subcontract_file_manager_file_id`) references `file_manager_files` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $unsigned_subcontract_file_manager_file_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubcontractsByUnsignedSubcontractFileManagerFileId($database, $unsigned_subcontract_file_manager_file_id, Input $options=null)
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
			self::$_arrSubcontractsByUnsignedSubcontractFileManagerFileId = null;
		}

		$arrSubcontractsByUnsignedSubcontractFileManagerFileId = self::$_arrSubcontractsByUnsignedSubcontractFileManagerFileId;
		if (isset($arrSubcontractsByUnsignedSubcontractFileManagerFileId) && !empty($arrSubcontractsByUnsignedSubcontractFileManagerFileId)) {
			return $arrSubcontractsByUnsignedSubcontractFileManagerFileId;
		}

		$unsigned_subcontract_file_manager_file_id = (int) $unsigned_subcontract_file_manager_file_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `gc_budget_line_item_id` ASC, `subcontract_sequence_number` ASC, `subcontractor_bid_id` ASC, `subcontract_template_id` ASC, `subcontract_gc_contact_company_office_id` ASC, `subcontract_gc_phone_contact_company_office_phone_number_id` ASC, `subcontract_gc_fax_contact_company_office_phone_number_id` ASC, `subcontract_gc_contact_id` ASC, `subcontract_gc_contact_mobile_phone_number_id` ASC, `vendor_id` ASC, `subcontract_vendor_contact_company_office_id` ASC, `subcontract_vendor_phone_contact_company_office_phone_number_id` ASC, `subcontract_vendor_fax_contact_company_office_phone_number_id` ASC, `subcontract_vendor_contact_id` ASC, `subcontract_vendor_contact_mobile_phone_number_id` ASC, `unsigned_subcontract_file_manager_file_id` ASC, `signed_subcontract_file_manager_file_id` ASC, `subcontract_forecasted_value` ASC, `subcontract_actual_value` ASC, `subcontract_retention_percentage` ASC, `subcontract_issued_date` ASC, `subcontract_target_execution_date` ASC, `subcontract_execution_date` ASC, `active_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubcontract = new Subcontract($database);
			$sqlOrderByColumns = $tmpSubcontract->constructSqlOrderByColumns($arrOrderByAttributes);

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
	s.*

FROM `subcontracts` s
WHERE s.`unsigned_subcontract_file_manager_file_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `gc_budget_line_item_id` ASC, `subcontract_sequence_number` ASC, `subcontractor_bid_id` ASC, `subcontract_template_id` ASC, `subcontract_gc_contact_company_office_id` ASC, `subcontract_gc_phone_contact_company_office_phone_number_id` ASC, `subcontract_gc_fax_contact_company_office_phone_number_id` ASC, `subcontract_gc_contact_id` ASC, `subcontract_gc_contact_mobile_phone_number_id` ASC, `vendor_id` ASC, `subcontract_vendor_contact_company_office_id` ASC, `subcontract_vendor_phone_contact_company_office_phone_number_id` ASC, `subcontract_vendor_fax_contact_company_office_phone_number_id` ASC, `subcontract_vendor_contact_id` ASC, `subcontract_vendor_contact_mobile_phone_number_id` ASC, `unsigned_subcontract_file_manager_file_id` ASC, `signed_subcontract_file_manager_file_id` ASC, `subcontract_forecasted_value` ASC, `subcontract_actual_value` ASC, `subcontract_retention_percentage` ASC, `subcontract_issued_date` ASC, `subcontract_target_execution_date` ASC, `subcontract_execution_date` ASC, `active_flag` ASC
		$arrValues = array($unsigned_subcontract_file_manager_file_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubcontractsByUnsignedSubcontractFileManagerFileId = array();
		while ($row = $db->fetch()) {
			$subcontract_id = $row['id'];
			$subcontract = self::instantiateOrm($database, 'Subcontract', $row, null, $subcontract_id);
			/* @var $subcontract Subcontract */
			$arrSubcontractsByUnsignedSubcontractFileManagerFileId[$subcontract_id] = $subcontract;
		}

		$db->free_result();

		self::$_arrSubcontractsByUnsignedSubcontractFileManagerFileId = $arrSubcontractsByUnsignedSubcontractFileManagerFileId;

		return $arrSubcontractsByUnsignedSubcontractFileManagerFileId;
	}

	/**
	 * Load by constraint `subcontracts_fk_signed_s_fmfiles` foreign key (`signed_subcontract_file_manager_file_id`) references `file_manager_files` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $signed_subcontract_file_manager_file_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubcontractsBySignedSubcontractFileManagerFileId($database, $signed_subcontract_file_manager_file_id, Input $options=null)
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
			self::$_arrSubcontractsBySignedSubcontractFileManagerFileId = null;
		}

		$arrSubcontractsBySignedSubcontractFileManagerFileId = self::$_arrSubcontractsBySignedSubcontractFileManagerFileId;
		if (isset($arrSubcontractsBySignedSubcontractFileManagerFileId) && !empty($arrSubcontractsBySignedSubcontractFileManagerFileId)) {
			return $arrSubcontractsBySignedSubcontractFileManagerFileId;
		}

		$signed_subcontract_file_manager_file_id = (int) $signed_subcontract_file_manager_file_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `gc_budget_line_item_id` ASC, `subcontract_sequence_number` ASC, `subcontractor_bid_id` ASC, `subcontract_template_id` ASC, `subcontract_gc_contact_company_office_id` ASC, `subcontract_gc_phone_contact_company_office_phone_number_id` ASC, `subcontract_gc_fax_contact_company_office_phone_number_id` ASC, `subcontract_gc_contact_id` ASC, `subcontract_gc_contact_mobile_phone_number_id` ASC, `vendor_id` ASC, `subcontract_vendor_contact_company_office_id` ASC, `subcontract_vendor_phone_contact_company_office_phone_number_id` ASC, `subcontract_vendor_fax_contact_company_office_phone_number_id` ASC, `subcontract_vendor_contact_id` ASC, `subcontract_vendor_contact_mobile_phone_number_id` ASC, `unsigned_subcontract_file_manager_file_id` ASC, `signed_subcontract_file_manager_file_id` ASC, `subcontract_forecasted_value` ASC, `subcontract_actual_value` ASC, `subcontract_retention_percentage` ASC, `subcontract_issued_date` ASC, `subcontract_target_execution_date` ASC, `subcontract_execution_date` ASC, `active_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubcontract = new Subcontract($database);
			$sqlOrderByColumns = $tmpSubcontract->constructSqlOrderByColumns($arrOrderByAttributes);

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
	s.*

FROM `subcontracts` s
WHERE s.`signed_subcontract_file_manager_file_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `gc_budget_line_item_id` ASC, `subcontract_sequence_number` ASC, `subcontractor_bid_id` ASC, `subcontract_template_id` ASC, `subcontract_gc_contact_company_office_id` ASC, `subcontract_gc_phone_contact_company_office_phone_number_id` ASC, `subcontract_gc_fax_contact_company_office_phone_number_id` ASC, `subcontract_gc_contact_id` ASC, `subcontract_gc_contact_mobile_phone_number_id` ASC, `vendor_id` ASC, `subcontract_vendor_contact_company_office_id` ASC, `subcontract_vendor_phone_contact_company_office_phone_number_id` ASC, `subcontract_vendor_fax_contact_company_office_phone_number_id` ASC, `subcontract_vendor_contact_id` ASC, `subcontract_vendor_contact_mobile_phone_number_id` ASC, `unsigned_subcontract_file_manager_file_id` ASC, `signed_subcontract_file_manager_file_id` ASC, `subcontract_forecasted_value` ASC, `subcontract_actual_value` ASC, `subcontract_retention_percentage` ASC, `subcontract_issued_date` ASC, `subcontract_target_execution_date` ASC, `subcontract_execution_date` ASC, `active_flag` ASC
		$arrValues = array($signed_subcontract_file_manager_file_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubcontractsBySignedSubcontractFileManagerFileId = array();
		while ($row = $db->fetch()) {
			$subcontract_id = $row['id'];
			$subcontract = self::instantiateOrm($database, 'Subcontract', $row, null, $subcontract_id);
			/* @var $subcontract Subcontract */
			$arrSubcontractsBySignedSubcontractFileManagerFileId[$subcontract_id] = $subcontract;
		}

		$db->free_result();

		self::$_arrSubcontractsBySignedSubcontractFileManagerFileId = $arrSubcontractsBySignedSubcontractFileManagerFileId;

		return $arrSubcontractsBySignedSubcontractFileManagerFileId;
	}

	public static function getsignatoryId($database,$subcontract_id,$field)
	{
		$db = DBI::getInstance($database);
		$query1="SELECT $field from subcontracts WHERE id = ? ";
		$arrValues = array($subcontract_id);
		$db->execute($query1, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$subcontract_signid = $row[$field];
		$db->free_result();
		return $subcontract_signid;
	}

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all subcontracts records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllSubcontracts($database, Input $options=null)
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
			self::$_arrAllSubcontracts = null;
		}

		$arrAllSubcontracts = self::$_arrAllSubcontracts;
		if (isset($arrAllSubcontracts) && !empty($arrAllSubcontracts)) {
			return $arrAllSubcontracts;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `gc_budget_line_item_id` ASC, `subcontract_sequence_number` ASC, `subcontractor_bid_id` ASC, `subcontract_template_id` ASC, `subcontract_gc_contact_company_office_id` ASC, `subcontract_gc_phone_contact_company_office_phone_number_id` ASC, `subcontract_gc_fax_contact_company_office_phone_number_id` ASC, `subcontract_gc_contact_id` ASC, `subcontract_gc_contact_mobile_phone_number_id` ASC, `vendor_id` ASC, `subcontract_vendor_contact_company_office_id` ASC, `subcontract_vendor_phone_contact_company_office_phone_number_id` ASC, `subcontract_vendor_fax_contact_company_office_phone_number_id` ASC, `subcontract_vendor_contact_id` ASC, `subcontract_vendor_contact_mobile_phone_number_id` ASC, `unsigned_subcontract_file_manager_file_id` ASC, `signed_subcontract_file_manager_file_id` ASC, `subcontract_forecasted_value` ASC, `subcontract_actual_value` ASC, `subcontract_retention_percentage` ASC, `subcontract_issued_date` ASC, `subcontract_target_execution_date` ASC, `subcontract_execution_date` ASC, `active_flag` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubcontract = new Subcontract($database);
			$sqlOrderByColumns = $tmpSubcontract->constructSqlOrderByColumns($arrOrderByAttributes);

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
	s.*

FROM `subcontracts` s{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `gc_budget_line_item_id` ASC, `subcontract_sequence_number` ASC, `subcontractor_bid_id` ASC, `subcontract_template_id` ASC, `subcontract_gc_contact_company_office_id` ASC, `subcontract_gc_phone_contact_company_office_phone_number_id` ASC, `subcontract_gc_fax_contact_company_office_phone_number_id` ASC, `subcontract_gc_contact_id` ASC, `subcontract_gc_contact_mobile_phone_number_id` ASC, `vendor_id` ASC, `subcontract_vendor_contact_company_office_id` ASC, `subcontract_vendor_phone_contact_company_office_phone_number_id` ASC, `subcontract_vendor_fax_contact_company_office_phone_number_id` ASC, `subcontract_vendor_contact_id` ASC, `subcontract_vendor_contact_mobile_phone_number_id` ASC, `unsigned_subcontract_file_manager_file_id` ASC, `signed_subcontract_file_manager_file_id` ASC, `subcontract_forecasted_value` ASC, `subcontract_actual_value` ASC, `subcontract_retention_percentage` ASC, `subcontract_issued_date` ASC, `subcontract_target_execution_date` ASC, `subcontract_execution_date` ASC, `active_flag` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllSubcontracts = array();
		while ($row = $db->fetch()) {
			$subcontract_id = $row['id'];
			$subcontract = self::instantiateOrm($database, 'Subcontract', $row, null, $subcontract_id);
			/* @var $subcontract Subcontract */
			$arrAllSubcontracts[$subcontract_id] = $subcontract;
		}

		$db->free_result();

		self::$_arrAllSubcontracts = $arrAllSubcontracts;

		return $arrAllSubcontracts;
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
INTO `subcontracts`
(`gc_budget_line_item_id`, `subcontract_sequence_number`, `subcontractor_bid_id`, `subcontract_template_id`, `subcontract_gc_contact_company_office_id`, `subcontract_gc_phone_contact_company_office_phone_number_id`, `subcontract_gc_fax_contact_company_office_phone_number_id`, `subcontract_gc_contact_id`,`gc_signatory`, `subcontract_gc_contact_mobile_phone_number_id`, `vendor_id`, `subcontract_vendor_contact_company_office_id`, `subcontract_vendor_phone_contact_company_office_phone_number_id`, `subcontract_vendor_fax_contact_company_office_phone_number_id`, `subcontract_vendor_contact_id`,`vendor_signatory`, `subcontract_vendor_contact_mobile_phone_number_id`, `unsigned_subcontract_file_manager_file_id`, `signed_subcontract_file_manager_file_id`, `subcontract_forecasted_value`, `subcontract_actual_value`, `subcontract_retention_percentage`, `subcontract_issued_date`, `subcontract_target_execution_date`, `subcontract_execution_date`, `subcontract_mailed_date`,`general_insurance_file_id`,`worker_file_id`,`car_insurance_file_id`,`city_license_file_id`,`general_insurance_date_expiry`,`worker_date_expiry`,`car_insurance_date_expiry`,`city_license_date_expiry`,`send_back_date`,`send_back`, `active_flag`)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,?)
ON DUPLICATE KEY UPDATE `subcontractor_bid_id` = ?, `subcontract_template_id` = ?, `subcontract_gc_contact_company_office_id` = ?, `subcontract_gc_phone_contact_company_office_phone_number_id` = ?, `subcontract_gc_fax_contact_company_office_phone_number_id` = ?, `subcontract_gc_contact_id` = ?, `gc_signatory` = ?, `subcontract_gc_contact_mobile_phone_number_id` = ?, `vendor_id` = ?, `subcontract_vendor_contact_company_office_id` = ?, `subcontract_vendor_phone_contact_company_office_phone_number_id` = ?, `subcontract_vendor_fax_contact_company_office_phone_number_id` = ?, `subcontract_vendor_contact_id` = ?,`vendor_signatory` = ?, `subcontract_vendor_contact_mobile_phone_number_id` = ?, `unsigned_subcontract_file_manager_file_id` = ?, `signed_subcontract_file_manager_file_id` = ?, `subcontract_forecasted_value` = ?, `subcontract_actual_value` = ?, `subcontract_retention_percentage` = ?, `subcontract_issued_date` = ?, `subcontract_target_execution_date` = ?, `subcontract_execution_date` = ?, `subcontract_mailed_date` = ?,`general_insurance_file_id`=?,`worker_file_id`=?,`car_insurance_file_id`=?,`city_license_file_id`=?,`general_insurance_date_expiry`=?,`worker_date_expiry`=?,`car_insurance_date_expiry`=?,`city_license_date_expiry`=?,`send_back_date`=?,`send_back`=?, `active_flag` = ?
";
		$arrValues = array($this->gc_budget_line_item_id, $this->subcontract_sequence_number, $this->subcontractor_bid_id, $this->subcontract_template_id, $this->subcontract_gc_contact_company_office_id, $this->subcontract_gc_phone_contact_company_office_phone_number_id, $this->subcontract_gc_fax_contact_company_office_phone_number_id, $this->subcontract_gc_contact_id,$this->gc_signatory, $this->subcontract_gc_contact_mobile_phone_number_id, $this->vendor_id, $this->subcontract_vendor_contact_company_office_id, $this->subcontract_vendor_phone_contact_company_office_phone_number_id, $this->subcontract_vendor_fax_contact_company_office_phone_number_id, $this->subcontract_vendor_contact_id, $this->vendor_signatory, $this->subcontract_vendor_contact_mobile_phone_number_id, $this->unsigned_subcontract_file_manager_file_id, $this->signed_subcontract_file_manager_file_id, $this->subcontract_forecasted_value, $this->subcontract_actual_value, $this->subcontract_retention_percentage, $this->subcontract_issued_date, $this->subcontract_target_execution_date, $this->subcontract_execution_date, $this->active_flag, $this->subcontractor_bid_id, $this->subcontract_template_id, $this->subcontract_gc_contact_company_office_id, $this->subcontract_gc_phone_contact_company_office_phone_number_id, $this->subcontract_gc_fax_contact_company_office_phone_number_id, $this->subcontract_gc_contact_id,$this->gc_signatory, $this->subcontract_gc_contact_mobile_phone_number_id, $this->vendor_id, $this->subcontract_vendor_contact_company_office_id, $this->subcontract_vendor_phone_contact_company_office_phone_number_id, $this->subcontract_vendor_fax_contact_company_office_phone_number_id, $this->subcontract_vendor_contact_id,$this->vendor_signatory, $this->subcontract_vendor_contact_mobile_phone_number_id, $this->unsigned_subcontract_file_manager_file_id, $this->signed_subcontract_file_manager_file_id, $this->subcontract_forecasted_value, $this->subcontract_actual_value, $this->subcontract_retention_percentage, $this->subcontract_issued_date, $this->subcontract_target_execution_date, $this->subcontract_execution_date, $this->subcontract_mailed_date, $this->general_insurance_file_id,$this->worker_file_id, $this->car_insurance_file_id,$this->city_license_file_id,$this->general_insurance_date_expiry,$this->worker_date_expiry,$this->car_insurance_date_expiry,$this->city_license_date_expiry,$this->send_back_date,$this->send_back, $this->active_flag);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$subcontract_id = $db->insertId;
		$db->free_result();

		return $subcontract_id;
	}

	// Save: insert ignore

	/**
	 * Load by constraint `subcontracts_fk_gbli` foreign key (`gc_budget_line_item_id`) references `gc_budget_line_items` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $project_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubcontractsByProjectId($database, $project_id, Input $options=null, $isDCR=null)
	{
		$forceLoadFlag = false;
		if (isset($options)) {
			if(!empty($options->arrOrderByAttributes)){
				$arrOrderByAttributes = $options->arrOrderByAttributes;
			}
			if(!empty($options->limit)){
				$limit = $options->limit;
			}
			if(!empty($options->offset)){
				$offset = $options->offset;
			}

			// Avoid cache when using filters and limits
			if (isset($arrOrderByAttributes) || isset($limit) || isset($offset)) {
				$forceLoadFlag = true;
			} else if(!empty($options->forceLoadFlag)){
				$forceLoadFlag = $options->forceLoadFlag;
			}
		}

		if ($isDCR) {
			$isDcrCond = "AND s.`is_dcr_flag` = 'Y'";
		}else{
			$isDcrCond = '';
		}

		if ($forceLoadFlag) {
			self::$_arrSubcontractsByProjectId = null;
		}

		$arrSubcontractsByProjectId = self::$_arrSubcontractsByProjectId;
		if (isset($arrSubcontractsByProjectId) && !empty($arrSubcontractsByProjectId)) {
			return $arrSubcontractsByProjectId;
		}

		$project_id = (int) $project_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `gc_budget_line_item_id` ASC, `subcontract_sequence_number` ASC, `subcontractor_bid_id` ASC, `subcontract_template_id` ASC, `subcontract_gc_contact_company_office_id` ASC, `subcontract_gc_phone_contact_company_office_phone_number_id` ASC, `subcontract_gc_fax_contact_company_office_phone_number_id` ASC, `subcontract_gc_contact_id` ASC, `subcontract_gc_contact_mobile_phone_number_id` ASC, `vendor_id` ASC, `subcontract_vendor_contact_company_office_id` ASC, `subcontract_vendor_phone_contact_company_office_phone_number_id` ASC, `subcontract_vendor_fax_contact_company_office_phone_number_id` ASC, `subcontract_vendor_contact_id` ASC, `subcontract_vendor_contact_mobile_phone_number_id` ASC, `unsigned_subcontract_file_manager_file_id` ASC, `signed_subcontract_file_manager_file_id` ASC, `subcontract_forecasted_value` ASC, `subcontract_actual_value` ASC, `subcontract_retention_percentage` ASC, `subcontract_issued_date` ASC, `subcontract_target_execution_date` ASC, `subcontract_execution_date` ASC, `active_flag` ASC
		$sqlOrderBy = "\nORDER BY s_fk_v__fk_cc.`company` ASC, s.`subcontract_sequence_number` ASC, gbli_fk_codes__fk_ccd.`division_number` ASC, gbli_fk_codes.`cost_code` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubcontract = new Subcontract($database);
			$sqlOrderByColumns = $tmpSubcontract->constructSqlOrderByColumns($arrOrderByAttributes);

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

	s_fk_gbli.`id` AS 's_fk_gbli__gc_budget_line_item_id',
	s_fk_gbli.`user_company_id` AS 's_fk_gbli__user_company_id',
	s_fk_gbli.`project_id` AS 's_fk_gbli__project_id',
	s_fk_gbli.`cost_code_id` AS 's_fk_gbli__cost_code_id',
	s_fk_gbli.`modified` AS 's_fk_gbli__modified',
	s_fk_gbli.`prime_contract_scheduled_value` AS 's_fk_gbli__prime_contract_scheduled_value',
	s_fk_gbli.`forecasted_expenses` AS 's_fk_gbli__forecasted_expenses',
	s_fk_gbli.`created` AS 's_fk_gbli__created',
	s_fk_gbli.`sort_order` AS 's_fk_gbli__sort_order',
	s_fk_gbli.`disabled_flag` AS 's_fk_gbli__disabled_flag',

	s_fk_sb.`id` AS 's_fk_sb__subcontractor_bid_id',
	s_fk_sb.`gc_budget_line_item_id` AS 's_fk_sb__gc_budget_line_item_id',
	s_fk_sb.`subcontractor_contact_id` AS 's_fk_sb__subcontractor_contact_id',
	s_fk_sb.`subcontractor_bid_status_id` AS 's_fk_sb__subcontractor_bid_status_id',
	s_fk_sb.`sort_order` AS 's_fk_sb__sort_order',

	s_fk_st.`id` AS 's_fk_st__subcontract_template_id',
	s_fk_st.`user_company_id` AS 's_fk_st__user_company_id',
	s_fk_st.`subcontract_type_id` AS 's_fk_st__subcontract_type_id',
	s_fk_st.`subcontract_template_name` AS 's_fk_st__subcontract_template_name',
	s_fk_st.`sort_order` AS 's_fk_st__sort_order',
	s_fk_st.`disabled_flag` AS 's_fk_st__disabled_flag',

	s_fk_gc_cco.`id` AS 's_fk_gc_cco__contact_company_office_id',
	s_fk_gc_cco.`contact_company_id` AS 's_fk_gc_cco__contact_company_id',
	s_fk_gc_cco.`office_nickname` AS 's_fk_gc_cco__office_nickname',
	s_fk_gc_cco.`address_line_1` AS 's_fk_gc_cco__address_line_1',
	s_fk_gc_cco.`address_line_2` AS 's_fk_gc_cco__address_line_2',
	s_fk_gc_cco.`address_line_3` AS 's_fk_gc_cco__address_line_3',
	s_fk_gc_cco.`address_line_4` AS 's_fk_gc_cco__address_line_4',
	s_fk_gc_cco.`address_city` AS 's_fk_gc_cco__address_city',
	s_fk_gc_cco.`address_county` AS 's_fk_gc_cco__address_county',
	s_fk_gc_cco.`address_state_or_region` AS 's_fk_gc_cco__address_state_or_region',
	s_fk_gc_cco.`address_postal_code` AS 's_fk_gc_cco__address_postal_code',
	s_fk_gc_cco.`address_postal_code_extension` AS 's_fk_gc_cco__address_postal_code_extension',
	s_fk_gc_cco.`address_country` AS 's_fk_gc_cco__address_country',
	s_fk_gc_cco.`head_quarters_flag` AS 's_fk_gc_cco__head_quarters_flag',
	s_fk_gc_cco.`address_validated_by_user_flag` AS 's_fk_gc_cco__address_validated_by_user_flag',
	s_fk_gc_cco.`address_validated_by_web_service_flag` AS 's_fk_gc_cco__address_validated_by_web_service_flag',
	s_fk_gc_cco.`address_validation_by_web_service_error_flag` AS 's_fk_gc_cco__address_validation_by_web_service_error_flag',

	s_fk_gc_phone_ccopn.`id` AS 's_fk_gc_phone_ccopn__contact_company_office_phone_number_id',
	s_fk_gc_phone_ccopn.`contact_company_office_id` AS 's_fk_gc_phone_ccopn__contact_company_office_id',
	s_fk_gc_phone_ccopn.`phone_number_type_id` AS 's_fk_gc_phone_ccopn__phone_number_type_id',
	s_fk_gc_phone_ccopn.`country_code` AS 's_fk_gc_phone_ccopn__country_code',
	s_fk_gc_phone_ccopn.`area_code` AS 's_fk_gc_phone_ccopn__area_code',
	s_fk_gc_phone_ccopn.`prefix` AS 's_fk_gc_phone_ccopn__prefix',
	s_fk_gc_phone_ccopn.`number` AS 's_fk_gc_phone_ccopn__number',
	s_fk_gc_phone_ccopn.`extension` AS 's_fk_gc_phone_ccopn__extension',
	s_fk_gc_phone_ccopn.`itu` AS 's_fk_gc_phone_ccopn__itu',

	s_fk_gc_fax_ccopn.`id` AS 's_fk_gc_fax_ccopn__contact_company_office_phone_number_id',
	s_fk_gc_fax_ccopn.`contact_company_office_id` AS 's_fk_gc_fax_ccopn__contact_company_office_id',
	s_fk_gc_fax_ccopn.`phone_number_type_id` AS 's_fk_gc_fax_ccopn__phone_number_type_id',
	s_fk_gc_fax_ccopn.`country_code` AS 's_fk_gc_fax_ccopn__country_code',
	s_fk_gc_fax_ccopn.`area_code` AS 's_fk_gc_fax_ccopn__area_code',
	s_fk_gc_fax_ccopn.`prefix` AS 's_fk_gc_fax_ccopn__prefix',
	s_fk_gc_fax_ccopn.`number` AS 's_fk_gc_fax_ccopn__number',
	s_fk_gc_fax_ccopn.`extension` AS 's_fk_gc_fax_ccopn__extension',
	s_fk_gc_fax_ccopn.`itu` AS 's_fk_gc_fax_ccopn__itu',

	s_fk_gc_c.`id` AS 's_fk_gc_c__contact_id',
	s_fk_gc_c.`user_company_id` AS 's_fk_gc_c__user_company_id',
	s_fk_gc_c.`user_id` AS 's_fk_gc_c__user_id',
	s_fk_gc_c.`contact_company_id` AS 's_fk_gc_c__contact_company_id',
	s_fk_gc_c.`email` AS 's_fk_gc_c__email',
	s_fk_gc_c.`name_prefix` AS 's_fk_gc_c__name_prefix',
	s_fk_gc_c.`first_name` AS 's_fk_gc_c__first_name',
	s_fk_gc_c.`additional_name` AS 's_fk_gc_c__additional_name',
	s_fk_gc_c.`middle_name` AS 's_fk_gc_c__middle_name',
	s_fk_gc_c.`last_name` AS 's_fk_gc_c__last_name',
	s_fk_gc_c.`name_suffix` AS 's_fk_gc_c__name_suffix',
	s_fk_gc_c.`title` AS 's_fk_gc_c__title',
	s_fk_gc_c.`vendor_flag` AS 's_fk_gc_c__vendor_flag',

	s_fk_gc_c_mobile_cpn.`id` AS 's_fk_gc_c_mobile_cpn__contact_phone_number_id',
	s_fk_gc_c_mobile_cpn.`contact_id` AS 's_fk_gc_c_mobile_cpn__contact_id',
	s_fk_gc_c_mobile_cpn.`phone_number_type_id` AS 's_fk_gc_c_mobile_cpn__phone_number_type_id',
	s_fk_gc_c_mobile_cpn.`country_code` AS 's_fk_gc_c_mobile_cpn__country_code',
	s_fk_gc_c_mobile_cpn.`area_code` AS 's_fk_gc_c_mobile_cpn__area_code',
	s_fk_gc_c_mobile_cpn.`prefix` AS 's_fk_gc_c_mobile_cpn__prefix',
	s_fk_gc_c_mobile_cpn.`number` AS 's_fk_gc_c_mobile_cpn__number',
	s_fk_gc_c_mobile_cpn.`extension` AS 's_fk_gc_c_mobile_cpn__extension',
	s_fk_gc_c_mobile_cpn.`itu` AS 's_fk_gc_c_mobile_cpn__itu',

	s_fk_v.`id` AS 's_fk_v__vendor_id',
	s_fk_v.`vendor_contact_company_id` AS 's_fk_v__vendor_contact_company_id',
	s_fk_v.`vendor_contact_company_office_id` AS 's_fk_v__vendor_contact_company_office_id',
	s_fk_v.`vendor_contact_id` AS 's_fk_v__vendor_contact_id',
	s_fk_v.`vendor_contact_address_id` AS 's_fk_v__vendor_contact_address_id',
	s_fk_v.`w9_file_manager_file_id` AS 's_fk_v__w9_file_manager_file_id',
	s_fk_v.`taxpayer_identification_number_id` AS 's_fk_v__taxpayer_identification_number_id',
	s_fk_v.`disabled_flag` AS 's_fk_v__disabled_flag',

	s_fk_v_cco.`id` AS 's_fk_v_cco__contact_company_office_id',
	s_fk_v_cco.`contact_company_id` AS 's_fk_v_cco__contact_company_id',
	s_fk_v_cco.`office_nickname` AS 's_fk_v_cco__office_nickname',
	s_fk_v_cco.`address_line_1` AS 's_fk_v_cco__address_line_1',
	s_fk_v_cco.`address_line_2` AS 's_fk_v_cco__address_line_2',
	s_fk_v_cco.`address_line_3` AS 's_fk_v_cco__address_line_3',
	s_fk_v_cco.`address_line_4` AS 's_fk_v_cco__address_line_4',
	s_fk_v_cco.`address_city` AS 's_fk_v_cco__address_city',
	s_fk_v_cco.`address_county` AS 's_fk_v_cco__address_county',
	s_fk_v_cco.`address_state_or_region` AS 's_fk_v_cco__address_state_or_region',
	s_fk_v_cco.`address_postal_code` AS 's_fk_v_cco__address_postal_code',
	s_fk_v_cco.`address_postal_code_extension` AS 's_fk_v_cco__address_postal_code_extension',
	s_fk_v_cco.`address_country` AS 's_fk_v_cco__address_country',
	s_fk_v_cco.`head_quarters_flag` AS 's_fk_v_cco__head_quarters_flag',
	s_fk_v_cco.`address_validated_by_user_flag` AS 's_fk_v_cco__address_validated_by_user_flag',
	s_fk_v_cco.`address_validated_by_web_service_flag` AS 's_fk_v_cco__address_validated_by_web_service_flag',
	s_fk_v_cco.`address_validation_by_web_service_error_flag` AS 's_fk_v_cco__address_validation_by_web_service_error_flag',

	s_fk_v_phone_ccopn.`id` AS 's_fk_v_phone_ccopn__contact_company_office_phone_number_id',
	s_fk_v_phone_ccopn.`contact_company_office_id` AS 's_fk_v_phone_ccopn__contact_company_office_id',
	s_fk_v_phone_ccopn.`phone_number_type_id` AS 's_fk_v_phone_ccopn__phone_number_type_id',
	s_fk_v_phone_ccopn.`country_code` AS 's_fk_v_phone_ccopn__country_code',
	s_fk_v_phone_ccopn.`area_code` AS 's_fk_v_phone_ccopn__area_code',
	s_fk_v_phone_ccopn.`prefix` AS 's_fk_v_phone_ccopn__prefix',
	s_fk_v_phone_ccopn.`number` AS 's_fk_v_phone_ccopn__number',
	s_fk_v_phone_ccopn.`extension` AS 's_fk_v_phone_ccopn__extension',
	s_fk_v_phone_ccopn.`itu` AS 's_fk_v_phone_ccopn__itu',

	s_fk_v_fax_ccopn.`id` AS 's_fk_v_fax_ccopn__contact_company_office_phone_number_id',
	s_fk_v_fax_ccopn.`contact_company_office_id` AS 's_fk_v_fax_ccopn__contact_company_office_id',
	s_fk_v_fax_ccopn.`phone_number_type_id` AS 's_fk_v_fax_ccopn__phone_number_type_id',
	s_fk_v_fax_ccopn.`country_code` AS 's_fk_v_fax_ccopn__country_code',
	s_fk_v_fax_ccopn.`area_code` AS 's_fk_v_fax_ccopn__area_code',
	s_fk_v_fax_ccopn.`prefix` AS 's_fk_v_fax_ccopn__prefix',
	s_fk_v_fax_ccopn.`number` AS 's_fk_v_fax_ccopn__number',
	s_fk_v_fax_ccopn.`extension` AS 's_fk_v_fax_ccopn__extension',
	s_fk_v_fax_ccopn.`itu` AS 's_fk_v_fax_ccopn__itu',

	s_fk_v_c.`id` AS 's_fk_v_c__contact_id',
	s_fk_v_c.`user_company_id` AS 's_fk_v_c__user_company_id',
	s_fk_v_c.`user_id` AS 's_fk_v_c__user_id',
	s_fk_v_c.`contact_company_id` AS 's_fk_v_c__contact_company_id',
	s_fk_v_c.`email` AS 's_fk_v_c__email',
	s_fk_v_c.`name_prefix` AS 's_fk_v_c__name_prefix',
	s_fk_v_c.`first_name` AS 's_fk_v_c__first_name',
	s_fk_v_c.`additional_name` AS 's_fk_v_c__additional_name',
	s_fk_v_c.`middle_name` AS 's_fk_v_c__middle_name',
	s_fk_v_c.`last_name` AS 's_fk_v_c__last_name',
	s_fk_v_c.`name_suffix` AS 's_fk_v_c__name_suffix',
	s_fk_v_c.`title` AS 's_fk_v_c__title',
	s_fk_v_c.`vendor_flag` AS 's_fk_v_c__vendor_flag',

	s_fk_v_c_mobile_cpn.`id` AS 's_fk_v_c_mobile_cpn__contact_phone_number_id',
	s_fk_v_c_mobile_cpn.`contact_id` AS 's_fk_v_c_mobile_cpn__contact_id',
	s_fk_v_c_mobile_cpn.`phone_number_type_id` AS 's_fk_v_c_mobile_cpn__phone_number_type_id',
	s_fk_v_c_mobile_cpn.`country_code` AS 's_fk_v_c_mobile_cpn__country_code',
	s_fk_v_c_mobile_cpn.`area_code` AS 's_fk_v_c_mobile_cpn__area_code',
	s_fk_v_c_mobile_cpn.`prefix` AS 's_fk_v_c_mobile_cpn__prefix',
	s_fk_v_c_mobile_cpn.`number` AS 's_fk_v_c_mobile_cpn__number',
	s_fk_v_c_mobile_cpn.`extension` AS 's_fk_v_c_mobile_cpn__extension',
	s_fk_v_c_mobile_cpn.`itu` AS 's_fk_v_c_mobile_cpn__itu',

	s_fk_unsigned_s_fmfiles.`id` AS 's_fk_unsigned_s_fmfiles__file_manager_file_id',
	s_fk_unsigned_s_fmfiles.`user_company_id` AS 's_fk_unsigned_s_fmfiles__user_company_id',
	s_fk_unsigned_s_fmfiles.`contact_id` AS 's_fk_unsigned_s_fmfiles__contact_id',
	s_fk_unsigned_s_fmfiles.`project_id` AS 's_fk_unsigned_s_fmfiles__project_id',
	s_fk_unsigned_s_fmfiles.`file_manager_folder_id` AS 's_fk_unsigned_s_fmfiles__file_manager_folder_id',
	s_fk_unsigned_s_fmfiles.`file_location_id` AS 's_fk_unsigned_s_fmfiles__file_location_id',
	s_fk_unsigned_s_fmfiles.`virtual_file_name` AS 's_fk_unsigned_s_fmfiles__virtual_file_name',
	s_fk_unsigned_s_fmfiles.`version_number` AS 's_fk_unsigned_s_fmfiles__version_number',
	s_fk_unsigned_s_fmfiles.`virtual_file_name_sha1` AS 's_fk_unsigned_s_fmfiles__virtual_file_name_sha1',
	s_fk_unsigned_s_fmfiles.`virtual_file_mime_type` AS 's_fk_unsigned_s_fmfiles__virtual_file_mime_type',
	s_fk_unsigned_s_fmfiles.`modified` AS 's_fk_unsigned_s_fmfiles__modified',
	s_fk_unsigned_s_fmfiles.`created` AS 's_fk_unsigned_s_fmfiles__created',
	s_fk_unsigned_s_fmfiles.`deleted_flag` AS 's_fk_unsigned_s_fmfiles__deleted_flag',
	s_fk_unsigned_s_fmfiles.`directly_deleted_flag` AS 's_fk_unsigned_s_fmfiles__directly_deleted_flag',

	s_fk_signed_s_fmfiles.`id` AS 's_fk_signed_s_fmfiles__file_manager_file_id',
	s_fk_signed_s_fmfiles.`user_company_id` AS 's_fk_signed_s_fmfiles__user_company_id',
	s_fk_signed_s_fmfiles.`contact_id` AS 's_fk_signed_s_fmfiles__contact_id',
	s_fk_signed_s_fmfiles.`project_id` AS 's_fk_signed_s_fmfiles__project_id',
	s_fk_signed_s_fmfiles.`file_manager_folder_id` AS 's_fk_signed_s_fmfiles__file_manager_folder_id',
	s_fk_signed_s_fmfiles.`file_location_id` AS 's_fk_signed_s_fmfiles__file_location_id',
	s_fk_signed_s_fmfiles.`virtual_file_name` AS 's_fk_signed_s_fmfiles__virtual_file_name',
	s_fk_signed_s_fmfiles.`version_number` AS 's_fk_signed_s_fmfiles__version_number',
	s_fk_signed_s_fmfiles.`virtual_file_name_sha1` AS 's_fk_signed_s_fmfiles__virtual_file_name_sha1',
	s_fk_signed_s_fmfiles.`virtual_file_mime_type` AS 's_fk_signed_s_fmfiles__virtual_file_mime_type',
	s_fk_signed_s_fmfiles.`modified` AS 's_fk_signed_s_fmfiles__modified',
	s_fk_signed_s_fmfiles.`created` AS 's_fk_signed_s_fmfiles__created',
	s_fk_signed_s_fmfiles.`deleted_flag` AS 's_fk_signed_s_fmfiles__deleted_flag',
	s_fk_signed_s_fmfiles.`directly_deleted_flag` AS 's_fk_signed_s_fmfiles__directly_deleted_flag',

	s_fk_v__fk_cc.`id` AS 's_fk_v__fk_cc__contact_company_id',
	s_fk_v__fk_cc.`user_user_company_id` AS 's_fk_v__fk_cc__user_user_company_id',
	s_fk_v__fk_cc.`contact_user_company_id` AS 's_fk_v__fk_cc__contact_user_company_id',
	s_fk_v__fk_cc.`company` AS 's_fk_v__fk_cc__company',
	s_fk_v__fk_cc.`primary_phone_number` AS 's_fk_v__fk_cc__primary_phone_number',
	s_fk_v__fk_cc.`employer_identification_number` AS 's_fk_v__fk_cc__employer_identification_number',
	s_fk_v__fk_cc.`construction_license_number` AS 's_fk_v__fk_cc__construction_license_number',
	s_fk_v__fk_cc.`construction_license_number_expiration_date` AS 's_fk_v__fk_cc__construction_license_number_expiration_date',
	s_fk_v__fk_cc.`vendor_flag` AS 's_fk_v__fk_cc__vendor_flag',

	gbli_fk_codes.`id` AS 'gbli_fk_codes__cost_code_id',
	gbli_fk_codes.`cost_code_division_id` AS 'gbli_fk_codes__cost_code_division_id',
	gbli_fk_codes.`cost_code` AS 'gbli_fk_codes__cost_code',
	gbli_fk_codes.`cost_code_description` AS 'gbli_fk_codes__cost_code_description',
	gbli_fk_codes.`cost_code_description_abbreviation` AS 'gbli_fk_codes__cost_code_description_abbreviation',
	gbli_fk_codes.`sort_order` AS 'gbli_fk_codes__sort_order',
	gbli_fk_codes.`disabled_flag` AS 'gbli_fk_codes__disabled_flag',

	gbli_fk_codes__fk_ccd.`id` AS 'gbli_fk_codes__fk_ccd__cost_code_division_id',
	gbli_fk_codes__fk_ccd.`user_company_id` AS 'gbli_fk_codes__fk_ccd__user_company_id',
	gbli_fk_codes__fk_ccd.`cost_code_type_id` AS 'gbli_fk_codes__fk_ccd__cost_code_type_id',
	gbli_fk_codes__fk_ccd.`division_number` AS 'gbli_fk_codes__fk_ccd__division_number',
	gbli_fk_codes__fk_ccd.`division_code_heading` AS 'gbli_fk_codes__fk_ccd__division_code_heading',
	gbli_fk_codes__fk_ccd.`division` AS 'gbli_fk_codes__fk_ccd__division',
	gbli_fk_codes__fk_ccd.`division_abbreviation` AS 'gbli_fk_codes__fk_ccd__division_abbreviation',
	gbli_fk_codes__fk_ccd.`sort_order` AS 'gbli_fk_codes__fk_ccd__sort_order',
	gbli_fk_codes__fk_ccd.`disabled_flag` AS 'gbli_fk_codes__fk_ccd__disabled_flag',

	s.*,

	sctype.subcontract_type

FROM `subcontracts` s
	INNER JOIN `gc_budget_line_items` s_fk_gbli ON s.`gc_budget_line_item_id` = s_fk_gbli.`id`
	LEFT OUTER JOIN `subcontractor_bids` s_fk_sb ON s.`subcontractor_bid_id` = s_fk_sb.`id`
	INNER JOIN `subcontract_templates` s_fk_st ON s.`subcontract_template_id` = s_fk_st.`id`
	LEFT OUTER JOIN `contact_company_offices` s_fk_gc_cco ON s.`subcontract_gc_contact_company_office_id` = s_fk_gc_cco.`id`
	LEFT OUTER JOIN `contact_company_office_phone_numbers` s_fk_gc_phone_ccopn ON s.`subcontract_gc_phone_contact_company_office_phone_number_id` = s_fk_gc_phone_ccopn.`id`
	LEFT OUTER JOIN `contact_company_office_phone_numbers` s_fk_gc_fax_ccopn ON s.`subcontract_gc_fax_contact_company_office_phone_number_id` = s_fk_gc_fax_ccopn.`id`
	LEFT OUTER JOIN `contacts` s_fk_gc_c ON s.`subcontract_gc_contact_id` = s_fk_gc_c.`id`
	LEFT OUTER JOIN `contact_phone_numbers` s_fk_gc_c_mobile_cpn ON s.`subcontract_gc_contact_mobile_phone_number_id` = s_fk_gc_c_mobile_cpn.`id`
	INNER JOIN `vendors` s_fk_v ON s.`vendor_id` = s_fk_v.`id`
	LEFT OUTER JOIN `contact_company_offices` s_fk_v_cco ON s.`subcontract_vendor_contact_company_office_id` = s_fk_v_cco.`id`
	LEFT OUTER JOIN `contact_company_office_phone_numbers` s_fk_v_phone_ccopn ON s.`subcontract_vendor_phone_contact_company_office_phone_number_id` = s_fk_v_phone_ccopn.`id`
	LEFT OUTER JOIN `contact_company_office_phone_numbers` s_fk_v_fax_ccopn ON s.`subcontract_vendor_fax_contact_company_office_phone_number_id` = s_fk_v_fax_ccopn.`id`
	LEFT OUTER JOIN `contacts` s_fk_v_c ON s.`subcontract_vendor_contact_id` = s_fk_v_c.`id`
	LEFT OUTER JOIN `contact_phone_numbers` s_fk_v_c_mobile_cpn ON s.`subcontract_vendor_contact_mobile_phone_number_id` = s_fk_v_c_mobile_cpn.`id`
	LEFT OUTER JOIN `file_manager_files` s_fk_unsigned_s_fmfiles ON s.`unsigned_subcontract_file_manager_file_id` = s_fk_unsigned_s_fmfiles.`id`
	LEFT OUTER JOIN `file_manager_files` s_fk_signed_s_fmfiles ON s.`signed_subcontract_file_manager_file_id` = s_fk_signed_s_fmfiles.`id`

	INNER JOIN `contact_companies` s_fk_v__fk_cc ON s_fk_v.`vendor_contact_company_id` = s_fk_v__fk_cc.`id`
	INNER JOIN subcontract_types sctype ON s_fk_st.subcontract_type_id = sctype.`id`
	INNER JOIN projects p ON s_fk_gbli.project_id = p.`id`

	INNER JOIN `cost_codes` gbli_fk_codes ON s_fk_gbli.`cost_code_id` = gbli_fk_codes.`id`
	INNER JOIN `cost_code_divisions` gbli_fk_codes__fk_ccd ON gbli_fk_codes.`cost_code_division_id` = gbli_fk_codes__fk_ccd.`id`

WHERE p.`id` = ? $isDcrCond {$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `gc_budget_line_item_id` ASC, `subcontract_sequence_number` ASC, `subcontractor_bid_id` ASC, `subcontract_template_id` ASC, `subcontract_gc_contact_company_office_id` ASC, `subcontract_gc_phone_contact_company_office_phone_number_id` ASC, `subcontract_gc_fax_contact_company_office_phone_number_id` ASC, `subcontract_gc_contact_id` ASC, `subcontract_gc_contact_mobile_phone_number_id` ASC, `vendor_id` ASC, `subcontract_vendor_contact_company_office_id` ASC, `subcontract_vendor_phone_contact_company_office_phone_number_id` ASC, `subcontract_vendor_fax_contact_company_office_phone_number_id` ASC, `subcontract_vendor_contact_id` ASC, `subcontract_vendor_contact_mobile_phone_number_id` ASC, `unsigned_subcontract_file_manager_file_id` ASC, `signed_subcontract_file_manager_file_id` ASC, `subcontract_forecasted_value` ASC, `subcontract_actual_value` ASC, `subcontract_retention_percentage` ASC, `subcontract_issued_date` ASC, `subcontract_target_execution_date` ASC, `subcontract_execution_date` ASC, `active_flag` ASC
		$arrValues = array($project_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubcontractsByProjectId = array();
		while ($row = $db->fetch()) {
			$subcontract_id = $row['id'];
			$subcontract = self::instantiateOrm($database, 'Subcontract', $row, null, $subcontract_id);
			/* @var $subcontract Subcontract */
			$subcontract->convertPropertiesToData();

			if (isset($row['gc_budget_line_item_id'])) {
				$gc_budget_line_item_id = $row['gc_budget_line_item_id'];
				$row['s_fk_gbli__id'] = $gc_budget_line_item_id;
				$gcBudgetLineItem = self::instantiateOrm($database, 'GcBudgetLineItem', $row, null, $gc_budget_line_item_id, 's_fk_gbli__');
				/* @var $gcBudgetLineItem GcBudgetLineItem */
				$gcBudgetLineItem->convertPropertiesToData();
			} else {
				$gcBudgetLineItem = false;
			}
			$subcontract->setGcBudgetLineItem($gcBudgetLineItem);

			if (isset($row['subcontractor_bid_id'])) {
				$subcontractor_bid_id = $row['subcontractor_bid_id'];
				$row['s_fk_sb__id'] = $subcontractor_bid_id;
				$subcontractorBid = self::instantiateOrm($database, 'SubcontractorBid', $row, null, $subcontractor_bid_id, 's_fk_sb__');
				/* @var $subcontractorBid SubcontractorBid */
				$subcontractorBid->convertPropertiesToData();
			} else {
				$subcontractorBid = false;
			}
			$subcontract->setSubcontractorBid($subcontractorBid);

			if (isset($row['subcontract_template_id'])) {
				$subcontract_template_id = $row['subcontract_template_id'];
				$row['s_fk_st__id'] = $subcontract_template_id;
				$subcontractTemplate = self::instantiateOrm($database, 'SubcontractTemplate', $row, null, $subcontract_template_id, 's_fk_st__');
				/* @var $subcontractTemplate SubcontractTemplate */
				$subcontractTemplate->convertPropertiesToData();
			} else {
				$subcontractTemplate = false;
			}
			$subcontract->setSubcontractTemplate($subcontractTemplate);

			if (isset($row['subcontract_gc_contact_company_office_id'])) {
				$subcontract_gc_contact_company_office_id = $row['subcontract_gc_contact_company_office_id'];
				$row['s_fk_gc_cco__id'] = $subcontract_gc_contact_company_office_id;
				$subcontractGcContactCompanyOffice = self::instantiateOrm($database, 'ContactCompanyOffice', $row, null, $subcontract_gc_contact_company_office_id, 's_fk_gc_cco__');
				/* @var $subcontractGcContactCompanyOffice ContactCompanyOffice */
				$subcontractGcContactCompanyOffice->convertPropertiesToData();
			} else {
				$subcontractGcContactCompanyOffice = false;
			}
			$subcontract->setSubcontractGcContactCompanyOffice($subcontractGcContactCompanyOffice);

			if (isset($row['subcontract_gc_phone_contact_company_office_phone_number_id'])) {
				$subcontract_gc_phone_contact_company_office_phone_number_id = $row['subcontract_gc_phone_contact_company_office_phone_number_id'];
				$row['s_fk_gc_phone_ccopn__id'] = $subcontract_gc_phone_contact_company_office_phone_number_id;
				$subcontractGcPhoneContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $subcontract_gc_phone_contact_company_office_phone_number_id, 's_fk_gc_phone_ccopn__');
				/* @var $subcontractGcPhoneContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$subcontractGcPhoneContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$subcontractGcPhoneContactCompanyOfficePhoneNumber = false;
			}
			$subcontract->setSubcontractGcPhoneContactCompanyOfficePhoneNumber($subcontractGcPhoneContactCompanyOfficePhoneNumber);

			if (isset($row['subcontract_gc_fax_contact_company_office_phone_number_id'])) {
				$subcontract_gc_fax_contact_company_office_phone_number_id = $row['subcontract_gc_fax_contact_company_office_phone_number_id'];
				$row['s_fk_gc_fax_ccopn__id'] = $subcontract_gc_fax_contact_company_office_phone_number_id;
				$subcontractGcFaxContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $subcontract_gc_fax_contact_company_office_phone_number_id, 's_fk_gc_fax_ccopn__');
				/* @var $subcontractGcFaxContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$subcontractGcFaxContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$subcontractGcFaxContactCompanyOfficePhoneNumber = false;
			}
			$subcontract->setSubcontractGcFaxContactCompanyOfficePhoneNumber($subcontractGcFaxContactCompanyOfficePhoneNumber);

			if (isset($row['subcontract_gc_contact_id'])) {
				$subcontract_gc_contact_id = $row['subcontract_gc_contact_id'];
				$row['s_fk_gc_c__id'] = $subcontract_gc_contact_id;
				$subcontractGcContact = self::instantiateOrm($database, 'Contact', $row, null, $subcontract_gc_contact_id, 's_fk_gc_c__');
				/* @var $subcontractGcContact Contact */
				$subcontractGcContact->convertPropertiesToData();
			} else {
				$subcontractGcContact = false;
			}
			$subcontract->setSubcontractGcContact($subcontractGcContact);

			if (isset($row['subcontract_gc_contact_mobile_phone_number_id'])) {
				$subcontract_gc_contact_mobile_phone_number_id = $row['subcontract_gc_contact_mobile_phone_number_id'];
				$row['s_fk_gc_c_mobile_cpn__id'] = $subcontract_gc_contact_mobile_phone_number_id;
				$subcontractGcContactMobilePhoneNumber = self::instantiateOrm($database, 'ContactPhoneNumber', $row, null, $subcontract_gc_contact_mobile_phone_number_id, 's_fk_gc_c_mobile_cpn__');
				/* @var $subcontractGcContactMobilePhoneNumber ContactPhoneNumber */
				$subcontractGcContactMobilePhoneNumber->convertPropertiesToData();
			} else {
				$subcontractGcContactMobilePhoneNumber = false;
			}
			$subcontract->setSubcontractGcContactMobilePhoneNumber($subcontractGcContactMobilePhoneNumber);

			if (isset($row['vendor_id'])) {
				$vendor_id = $row['vendor_id'];
				$row['s_fk_v__id'] = $vendor_id;
				$vendor = self::instantiateOrm($database, 'Vendor', $row, null, $vendor_id, 's_fk_v__');
				/* @var $vendor Vendor */
				$vendor->convertPropertiesToData();
			} else {
				$vendor = false;
			}
			$subcontract->setVendor($vendor);

			if (isset($row['subcontract_vendor_contact_company_office_id'])) {
				$subcontract_vendor_contact_company_office_id = $row['subcontract_vendor_contact_company_office_id'];
				$row['s_fk_v_cco__id'] = $subcontract_vendor_contact_company_office_id;
				$subcontractVendorContactCompanyOffice = self::instantiateOrm($database, 'ContactCompanyOffice', $row, null, $subcontract_vendor_contact_company_office_id, 's_fk_v_cco__');
				/* @var $subcontractVendorContactCompanyOffice ContactCompanyOffice */
				$subcontractVendorContactCompanyOffice->convertPropertiesToData();
			} else {
				$subcontractVendorContactCompanyOffice = false;
			}
			$subcontract->setSubcontractVendorContactCompanyOffice($subcontractVendorContactCompanyOffice);

			if (isset($row['subcontract_vendor_phone_contact_company_office_phone_number_id'])) {
				$subcontract_vendor_phone_contact_company_office_phone_number_id = $row['subcontract_vendor_phone_contact_company_office_phone_number_id'];
				$row['s_fk_v_phone_ccopn__id'] = $subcontract_vendor_phone_contact_company_office_phone_number_id;
				$subcontractVendorPhoneContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $subcontract_vendor_phone_contact_company_office_phone_number_id, 's_fk_v_phone_ccopn__');
				/* @var $subcontractVendorPhoneContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$subcontractVendorPhoneContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$subcontractVendorPhoneContactCompanyOfficePhoneNumber = false;
			}
			$subcontract->setSubcontractVendorPhoneContactCompanyOfficePhoneNumber($subcontractVendorPhoneContactCompanyOfficePhoneNumber);

			if (isset($row['subcontract_vendor_fax_contact_company_office_phone_number_id'])) {
				$subcontract_vendor_fax_contact_company_office_phone_number_id = $row['subcontract_vendor_fax_contact_company_office_phone_number_id'];
				$row['s_fk_v_fax_ccopn__id'] = $subcontract_vendor_fax_contact_company_office_phone_number_id;
				$subcontractVendorFaxContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $subcontract_vendor_fax_contact_company_office_phone_number_id, 's_fk_v_fax_ccopn__');
				/* @var $subcontractVendorFaxContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$subcontractVendorFaxContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$subcontractVendorFaxContactCompanyOfficePhoneNumber = false;
			}
			$subcontract->setSubcontractVendorFaxContactCompanyOfficePhoneNumber($subcontractVendorFaxContactCompanyOfficePhoneNumber);

			if (isset($row['subcontract_vendor_contact_id'])) {
				$subcontract_vendor_contact_id = $row['subcontract_vendor_contact_id'];
				$row['s_fk_v_c__id'] = $subcontract_vendor_contact_id;
				$subcontractVendorContact = self::instantiateOrm($database, 'Contact', $row, null, $subcontract_vendor_contact_id, 's_fk_v_c__');
				/* @var $subcontractVendorContact Contact */
				$subcontractVendorContact->convertPropertiesToData();
			} else {
				$subcontractVendorContact = false;
			}
			$subcontract->setSubcontractVendorContact($subcontractVendorContact);

			if (isset($row['subcontract_vendor_contact_mobile_phone_number_id'])) {
				$subcontract_vendor_contact_mobile_phone_number_id = $row['subcontract_vendor_contact_mobile_phone_number_id'];
				$row['s_fk_v_c_mobile_cpn__id'] = $subcontract_vendor_contact_mobile_phone_number_id;
				$subcontractVendorContactMobilePhoneNumber = self::instantiateOrm($database, 'ContactPhoneNumber', $row, null, $subcontract_vendor_contact_mobile_phone_number_id, 's_fk_v_c_mobile_cpn__');
				/* @var $subcontractVendorContactMobilePhoneNumber ContactPhoneNumber */
				$subcontractVendorContactMobilePhoneNumber->convertPropertiesToData();
			} else {
				$subcontractVendorContactMobilePhoneNumber = false;
			}
			$subcontract->setSubcontractVendorContactMobilePhoneNumber($subcontractVendorContactMobilePhoneNumber);

			if (isset($row['unsigned_subcontract_file_manager_file_id'])) {
				$unsigned_subcontract_file_manager_file_id = $row['unsigned_subcontract_file_manager_file_id'];
				$row['s_fk_unsigned_s_fmfiles__id'] = $unsigned_subcontract_file_manager_file_id;
				$unsignedSubcontractFileManagerFile = self::instantiateOrm($database, 'FileManagerFile', $row, null, $unsigned_subcontract_file_manager_file_id, 's_fk_unsigned_s_fmfiles__');
				/* @var $unsignedSubcontractFileManagerFile FileManagerFile */
				$unsignedSubcontractFileManagerFile->convertPropertiesToData();
			} else {
				$unsignedSubcontractFileManagerFile = false;
			}
			$subcontract->setUnsignedSubcontractFileManagerFile($unsignedSubcontractFileManagerFile);

			if (isset($row['signed_subcontract_file_manager_file_id'])) {
				$signed_subcontract_file_manager_file_id = $row['signed_subcontract_file_manager_file_id'];
				$row['s_fk_signed_s_fmfiles__id'] = $signed_subcontract_file_manager_file_id;
				$signedSubcontractFileManagerFile = self::instantiateOrm($database, 'FileManagerFile', $row, null, $signed_subcontract_file_manager_file_id, 's_fk_signed_s_fmfiles__');
				/* @var $signedSubcontractFileManagerFile FileManagerFile */
				$signedSubcontractFileManagerFile->convertPropertiesToData();
			} else {
				$signedSubcontractFileManagerFile = false;
			}
			$subcontract->setSignedSubcontractFileManagerFile($signedSubcontractFileManagerFile);

			if (isset($row['s_fk_v__fk_cc__contact_company_id'])) {
				$vendor_contact_company_id = $row['s_fk_v__fk_cc__contact_company_id'];
				$row['s_fk_v__fk_cc__id'] = $vendor_contact_company_id;
				$vendorContactCompany = self::instantiateOrm($database, 'ContactCompany', $row, null, $vendor_contact_company_id, 's_fk_v__fk_cc__');
				/* @var $vendorContactCompany ContactCompany */
				$vendorContactCompany->convertPropertiesToData();
			} else {
				$vendorContactCompany = false;
			}

			if ($vendor) {
				$vendor->setVendorContactCompany($vendorContactCompany);
				$vendor->setVendorContactCompanyOffice($subcontractVendorContactCompanyOffice);
				$vendor->setVendorContact($subcontractVendorContact);
				//$vendor->setContactAddress($subcontractVendorPhoneContactCompanyOfficePhoneNumber);
			}

			if (isset($row['gbli_fk_codes__cost_code_id'])) {
				$cost_code_id = $row['gbli_fk_codes__cost_code_id'];
				$costCode = self::instantiateOrm($database, 'CostCode', $row, null, $cost_code_id, 'gbli_fk_codes__');
				/* @var $costCode CostCode */
				$costCode->convertPropertiesToData();
			} else {
				$costCode = false;
			}
			$gcBudgetLineItem->setCostCode($costCode);

			if (isset($row['gbli_fk_codes__fk_ccd__cost_code_division_id'])) {
				$cost_code_division_id = $row['gbli_fk_codes__fk_ccd__cost_code_division_id'];
				$costCodeDivision = self::instantiateOrm($database, 'CostCodeDivision', $row, null, $cost_code_division_id, 'gbli_fk_codes__fk_ccd__');
				/* @var $costCodeDivision CostCodeDivision */
				$costCodeDivision->convertPropertiesToData();
				if ($costCode) {
					$costCode->setCostCodeDivision($costCodeDivision);
				}
			} else {
				$costCodeDivision = false;
			}
			$gcBudgetLineItem->setCostCodeDivision($costCodeDivision);

			// Additional attributes
			$subcontract_type = $row['subcontract_type'];
			$subcontract->subcontract_type = $subcontract_type;

			$arrSubcontractsByProjectId[$subcontract_id] = $subcontract;
		}

		$db->free_result();

		self::$_arrSubcontractsByProjectId = $arrSubcontractsByProjectId;

		return $arrSubcontractsByProjectId;
	}

	/**
	 * Load by custom join against projects
	 *
	 * @param string $database
	 * @param int $gc_budget_line_item_id
	 * @return mixed (single ORM object | false)
	 */
	public static function loadCostCodesBySubcontractsByProjectId($database, $project_id)
	{
		$project_id = (int) $project_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */
		//To fetch the jobsite dalig log created date
		$today=date('Y-m-d');
		$que = "SELECT `id` FROM `jobsite_daily_logs` where `project_id`=$project_id and `jobsite_daily_log_created_date`='$today' ";
		$db->query($que);
		$row1 = $db->fetch();
		$daliy_log='';
		if($row1)
		{
			$daliy_log=$row1['id'];
		}
		$db->free_result();
		$query =
"
SELECT

	codes_fk_ccd.`id` AS 'codes_fk_ccd__cost_code_division_id',
	codes_fk_ccd.`user_company_id` AS 'codes_fk_ccd__user_company_id',
	codes_fk_ccd.`cost_code_type_id` AS 'codes_fk_ccd__cost_code_type_id',
	codes_fk_ccd.`division_number` AS 'codes_fk_ccd__division_number',
	codes_fk_ccd.`division_code_heading` AS 'codes_fk_ccd__division_code_heading',
	codes_fk_ccd.`division` AS 'codes_fk_ccd__division',
	codes_fk_ccd.`division_abbreviation` AS 'codes_fk_ccd__division_abbreviation',
	codes_fk_ccd.`sort_order` AS 'codes_fk_ccd__sort_order',
	codes_fk_ccd.`disabled_flag` AS 'codes_fk_ccd__disabled_flag',

	codes.*,
	s.`id` as 'subcontract_id'

FROM `cost_codes` codes
	INNER JOIN `cost_code_divisions` codes_fk_ccd ON codes.`cost_code_division_id` = codes_fk_ccd.`id`
	INNER JOIN `gc_budget_line_items` gbli ON codes.`id` = gbli.`cost_code_id`
	INNER JOIN `subcontracts` s ON gbli.`id` = s.`gc_budget_line_item_id`
	INNER JOIN `projects` p ON gbli.`project_id` = p.`id`
	INNER join `jobsite_man_power` m on m.`subcontract_id` =s.`id`

WHERE p.`id` = ? and m.`jobsite_daily_log_id` ='$daliy_log' and m.`number_of_people` > '0'
ORDER BY codes_fk_ccd.`division_number` ASC, codes.`cost_code` ASC
";
// LIMIT 10
		$arrValues = array($project_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrCostCodesBySubcontractsByProjectId = array();
		$arrCostCodeIdsBySubcontractIds = array();
		while ($row = $db->fetch()) {
			$cost_code_id = $row['id'];
			$subcontract_id = $row['subcontract_id'];

			$costCode = self::instantiateOrm($database, 'CostCode', $row);
			/* @var $costCode CostCode */
			$costCode->convertPropertiesToData();

			if (isset($row['cost_code_division_id'])) {
				$cost_code_division_id = $row['cost_code_division_id'];
				$row['codes_fk_ccd__id'] = $cost_code_division_id;
				$costCodeDivision = self::instantiateOrm($database, 'CostCodeDivision', $row, null, $cost_code_division_id, 'codes_fk_ccd__');
				/* @var $costCodeDivision CostCodeDivision */
				$costCodeDivision->convertPropertiesToData();
			} else {
				$costCodeDivision = false;
			}
			$costCode->setCostCodeDivision($costCodeDivision);

			$arrCostCodesBySubcontractsByProjectId[$cost_code_id] = $costCode;
			$arrCostCodeIdsBySubcontractIds[$subcontract_id][$cost_code_id] = 1;
		}

		$db->free_result();

		$arrReturn = array(
			'cost_codes_by_subcontracts_by_project_id' => $arrCostCodesBySubcontractsByProjectId,
			'cost_codes_by_subcontract_ids' => $arrCostCodeIdsBySubcontractIds,
		);

		return $arrReturn;
	}

	/**
	 * Find next_subcontract_sequence_number value.
	 *
	 * @param string $database
	 * @param int $user_company_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findNextSubcontractSequenceNumber($database, $gc_budget_line_item_id)
	{
		$next_subcontract_sequence_number = 1;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT MAX(s.subcontract_sequence_number) AS 'max_subcontract_sequence_number'
FROM `subcontracts` s
WHERE s.`gc_budget_line_item_id` = ?
";
		$arrValues = array($gc_budget_line_item_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$max_subcontract_sequence_number = $row['max_subcontract_sequence_number'];
			$next_subcontract_sequence_number = $max_subcontract_sequence_number + 1;
		}

		return $next_subcontract_sequence_number;
	}
	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `subcontracts_fk_gbli` foreign key (`gc_budget_line_item_id`) references `gc_budget_line_items` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $gc_budget_line_item_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubcontractsByGcBudgetLineItemIdWithDate($database, $gc_budget_line_item_id, Input $options=null,$startDate,$endDate, $whereCase = false)
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
			self::$_arrSubcontractsByGcBudgetLineItemId = null;
		}

		$arrSubcontractsByGcBudgetLineItemId = self::$_arrSubcontractsByGcBudgetLineItemId;
		if (isset($arrSubcontractsByGcBudgetLineItemId) && !empty($arrSubcontractsByGcBudgetLineItemId)) {
			return $arrSubcontractsByGcBudgetLineItemId;
		}

		$gc_budget_line_item_id = (int) $gc_budget_line_item_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `gc_budget_line_item_id` ASC, `subcontract_sequence_number` ASC, `subcontractor_bid_id` ASC, `subcontract_template_id` ASC, `subcontract_gc_contact_company_office_id` ASC, `subcontract_gc_phone_contact_company_office_phone_number_id` ASC, `subcontract_gc_fax_contact_company_office_phone_number_id` ASC, `subcontract_gc_contact_id` ASC, `subcontract_gc_contact_mobile_phone_number_id` ASC, `vendor_id` ASC, `subcontract_vendor_contact_company_office_id` ASC, `subcontract_vendor_phone_contact_company_office_phone_number_id` ASC, `subcontract_vendor_fax_contact_company_office_phone_number_id` ASC, `subcontract_vendor_contact_id` ASC, `subcontract_vendor_contact_mobile_phone_number_id` ASC, `unsigned_subcontract_file_manager_file_id` ASC, `signed_subcontract_file_manager_file_id` ASC, `subcontract_forecasted_value` ASC, `subcontract_actual_value` ASC, `subcontract_retention_percentage` ASC, `subcontract_issued_date` ASC, `subcontract_target_execution_date` ASC, `subcontract_execution_date` ASC, `active_flag` ASC
		$sqlOrderBy = "\nORDER BY s.`subcontract_sequence_number` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubcontract = new Subcontract($database);
			$sqlOrderByColumns = $tmpSubcontract->constructSqlOrderByColumns($arrOrderByAttributes);

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
		$whereDate = '';
		if($whereCase){
			$whereDate = "And (s.`subcontract_mailed_date` between '".$startDate."' and '".$endDate."' OR s.`subcontract_execution_date` between '".$startDate."' and '".$endDate."')";
		}

		 $query =
"
SELECT

	s_fk_gbli.`id` AS 's_fk_gbli__gc_budget_line_item_id',
	s_fk_gbli.`user_company_id` AS 's_fk_gbli__user_company_id',
	s_fk_gbli.`project_id` AS 's_fk_gbli__project_id',
	s_fk_gbli.`cost_code_id` AS 's_fk_gbli__cost_code_id',
	s_fk_gbli.`modified` AS 's_fk_gbli__modified',
	s_fk_gbli.`prime_contract_scheduled_value` AS 's_fk_gbli__prime_contract_scheduled_value',
	s_fk_gbli.`forecasted_expenses` AS 's_fk_gbli__forecasted_expenses',
	s_fk_gbli.`created` AS 's_fk_gbli__created',
	s_fk_gbli.`sort_order` AS 's_fk_gbli__sort_order',
	s_fk_gbli.`disabled_flag` AS 's_fk_gbli__disabled_flag',

	s_fk_sb.`id` AS 's_fk_sb__subcontractor_bid_id',
	s_fk_sb.`gc_budget_line_item_id` AS 's_fk_sb__gc_budget_line_item_id',
	s_fk_sb.`subcontractor_contact_id` AS 's_fk_sb__subcontractor_contact_id',
	s_fk_sb.`subcontractor_bid_status_id` AS 's_fk_sb__subcontractor_bid_status_id',
	s_fk_sb.`sort_order` AS 's_fk_sb__sort_order',

	s_fk_st.`id` AS 's_fk_st__subcontract_template_id',
	s_fk_st.`user_company_id` AS 's_fk_st__user_company_id',
	s_fk_st.`subcontract_type_id` AS 's_fk_st__subcontract_type_id',
	s_fk_st.`subcontract_template_name` AS 's_fk_st__subcontract_template_name',
	s_fk_st.`sort_order` AS 's_fk_st__sort_order',
	s_fk_st.`disabled_flag` AS 's_fk_st__disabled_flag',

	s_fk_gc_cco.`id` AS 's_fk_gc_cco__contact_company_office_id',
	s_fk_gc_cco.`contact_company_id` AS 's_fk_gc_cco__contact_company_id',
	s_fk_gc_cco.`office_nickname` AS 's_fk_gc_cco__office_nickname',
	s_fk_gc_cco.`address_line_1` AS 's_fk_gc_cco__address_line_1',
	s_fk_gc_cco.`address_line_2` AS 's_fk_gc_cco__address_line_2',
	s_fk_gc_cco.`address_line_3` AS 's_fk_gc_cco__address_line_3',
	s_fk_gc_cco.`address_line_4` AS 's_fk_gc_cco__address_line_4',
	s_fk_gc_cco.`address_city` AS 's_fk_gc_cco__address_city',
	s_fk_gc_cco.`address_county` AS 's_fk_gc_cco__address_county',
	s_fk_gc_cco.`address_state_or_region` AS 's_fk_gc_cco__address_state_or_region',
	s_fk_gc_cco.`address_postal_code` AS 's_fk_gc_cco__address_postal_code',
	s_fk_gc_cco.`address_postal_code_extension` AS 's_fk_gc_cco__address_postal_code_extension',
	s_fk_gc_cco.`address_country` AS 's_fk_gc_cco__address_country',
	s_fk_gc_cco.`head_quarters_flag` AS 's_fk_gc_cco__head_quarters_flag',
	s_fk_gc_cco.`address_validated_by_user_flag` AS 's_fk_gc_cco__address_validated_by_user_flag',
	s_fk_gc_cco.`address_validated_by_web_service_flag` AS 's_fk_gc_cco__address_validated_by_web_service_flag',
	s_fk_gc_cco.`address_validation_by_web_service_error_flag` AS 's_fk_gc_cco__address_validation_by_web_service_error_flag',

	s_fk_gc_phone_ccopn.`id` AS 's_fk_gc_phone_ccopn__contact_company_office_phone_number_id',
	s_fk_gc_phone_ccopn.`contact_company_office_id` AS 's_fk_gc_phone_ccopn__contact_company_office_id',
	s_fk_gc_phone_ccopn.`phone_number_type_id` AS 's_fk_gc_phone_ccopn__phone_number_type_id',
	s_fk_gc_phone_ccopn.`country_code` AS 's_fk_gc_phone_ccopn__country_code',
	s_fk_gc_phone_ccopn.`area_code` AS 's_fk_gc_phone_ccopn__area_code',
	s_fk_gc_phone_ccopn.`prefix` AS 's_fk_gc_phone_ccopn__prefix',
	s_fk_gc_phone_ccopn.`number` AS 's_fk_gc_phone_ccopn__number',
	s_fk_gc_phone_ccopn.`extension` AS 's_fk_gc_phone_ccopn__extension',
	s_fk_gc_phone_ccopn.`itu` AS 's_fk_gc_phone_ccopn__itu',

	s_fk_gc_fax_ccopn.`id` AS 's_fk_gc_fax_ccopn__contact_company_office_phone_number_id',
	s_fk_gc_fax_ccopn.`contact_company_office_id` AS 's_fk_gc_fax_ccopn__contact_company_office_id',
	s_fk_gc_fax_ccopn.`phone_number_type_id` AS 's_fk_gc_fax_ccopn__phone_number_type_id',
	s_fk_gc_fax_ccopn.`country_code` AS 's_fk_gc_fax_ccopn__country_code',
	s_fk_gc_fax_ccopn.`area_code` AS 's_fk_gc_fax_ccopn__area_code',
	s_fk_gc_fax_ccopn.`prefix` AS 's_fk_gc_fax_ccopn__prefix',
	s_fk_gc_fax_ccopn.`number` AS 's_fk_gc_fax_ccopn__number',
	s_fk_gc_fax_ccopn.`extension` AS 's_fk_gc_fax_ccopn__extension',
	s_fk_gc_fax_ccopn.`itu` AS 's_fk_gc_fax_ccopn__itu',

	s_fk_gc_c.`id` AS 's_fk_gc_c__contact_id',
	s_fk_gc_c.`user_company_id` AS 's_fk_gc_c__user_company_id',
	s_fk_gc_c.`user_id` AS 's_fk_gc_c__user_id',
	s_fk_gc_c.`contact_company_id` AS 's_fk_gc_c__contact_company_id',
	s_fk_gc_c.`email` AS 's_fk_gc_c__email',
	s_fk_gc_c.`name_prefix` AS 's_fk_gc_c__name_prefix',
	s_fk_gc_c.`first_name` AS 's_fk_gc_c__first_name',
	s_fk_gc_c.`additional_name` AS 's_fk_gc_c__additional_name',
	s_fk_gc_c.`middle_name` AS 's_fk_gc_c__middle_name',
	s_fk_gc_c.`last_name` AS 's_fk_gc_c__last_name',
	s_fk_gc_c.`name_suffix` AS 's_fk_gc_c__name_suffix',
	s_fk_gc_c.`title` AS 's_fk_gc_c__title',
	s_fk_gc_c.`vendor_flag` AS 's_fk_gc_c__vendor_flag',

	s_fk_gc_c_mobile_cpn.`id` AS 's_fk_gc_c_mobile_cpn__contact_phone_number_id',
	s_fk_gc_c_mobile_cpn.`contact_id` AS 's_fk_gc_c_mobile_cpn__contact_id',
	s_fk_gc_c_mobile_cpn.`phone_number_type_id` AS 's_fk_gc_c_mobile_cpn__phone_number_type_id',
	s_fk_gc_c_mobile_cpn.`country_code` AS 's_fk_gc_c_mobile_cpn__country_code',
	s_fk_gc_c_mobile_cpn.`area_code` AS 's_fk_gc_c_mobile_cpn__area_code',
	s_fk_gc_c_mobile_cpn.`prefix` AS 's_fk_gc_c_mobile_cpn__prefix',
	s_fk_gc_c_mobile_cpn.`number` AS 's_fk_gc_c_mobile_cpn__number',
	s_fk_gc_c_mobile_cpn.`extension` AS 's_fk_gc_c_mobile_cpn__extension',
	s_fk_gc_c_mobile_cpn.`itu` AS 's_fk_gc_c_mobile_cpn__itu',

	s_fk_v.`id` AS 's_fk_v__vendor_id',
	s_fk_v.`vendor_contact_company_id` AS 's_fk_v__vendor_contact_company_id',
	s_fk_v.`vendor_contact_company_office_id` AS 's_fk_v__vendor_contact_company_office_id',
	s_fk_v.`vendor_contact_id` AS 's_fk_v__vendor_contact_id',
	s_fk_v.`vendor_contact_address_id` AS 's_fk_v__vendor_contact_address_id',
	s_fk_v.`w9_file_manager_file_id` AS 's_fk_v__w9_file_manager_file_id',
	s_fk_v.`taxpayer_identification_number_id` AS 's_fk_v__taxpayer_identification_number_id',
	s_fk_v.`disabled_flag` AS 's_fk_v__disabled_flag',

	s_fk_v_cco.`id` AS 's_fk_v_cco__contact_company_office_id',
	s_fk_v_cco.`contact_company_id` AS 's_fk_v_cco__contact_company_id',
	s_fk_v_cco.`office_nickname` AS 's_fk_v_cco__office_nickname',
	s_fk_v_cco.`address_line_1` AS 's_fk_v_cco__address_line_1',
	s_fk_v_cco.`address_line_2` AS 's_fk_v_cco__address_line_2',
	s_fk_v_cco.`address_line_3` AS 's_fk_v_cco__address_line_3',
	s_fk_v_cco.`address_line_4` AS 's_fk_v_cco__address_line_4',
	s_fk_v_cco.`address_city` AS 's_fk_v_cco__address_city',
	s_fk_v_cco.`address_county` AS 's_fk_v_cco__address_county',
	s_fk_v_cco.`address_state_or_region` AS 's_fk_v_cco__address_state_or_region',
	s_fk_v_cco.`address_postal_code` AS 's_fk_v_cco__address_postal_code',
	s_fk_v_cco.`address_postal_code_extension` AS 's_fk_v_cco__address_postal_code_extension',
	s_fk_v_cco.`address_country` AS 's_fk_v_cco__address_country',
	s_fk_v_cco.`head_quarters_flag` AS 's_fk_v_cco__head_quarters_flag',
	s_fk_v_cco.`address_validated_by_user_flag` AS 's_fk_v_cco__address_validated_by_user_flag',
	s_fk_v_cco.`address_validated_by_web_service_flag` AS 's_fk_v_cco__address_validated_by_web_service_flag',
	s_fk_v_cco.`address_validation_by_web_service_error_flag` AS 's_fk_v_cco__address_validation_by_web_service_error_flag',

	s_fk_v_phone_ccopn.`id` AS 's_fk_v_phone_ccopn__contact_company_office_phone_number_id',
	s_fk_v_phone_ccopn.`contact_company_office_id` AS 's_fk_v_phone_ccopn__contact_company_office_id',
	s_fk_v_phone_ccopn.`phone_number_type_id` AS 's_fk_v_phone_ccopn__phone_number_type_id',
	s_fk_v_phone_ccopn.`country_code` AS 's_fk_v_phone_ccopn__country_code',
	s_fk_v_phone_ccopn.`area_code` AS 's_fk_v_phone_ccopn__area_code',
	s_fk_v_phone_ccopn.`prefix` AS 's_fk_v_phone_ccopn__prefix',
	s_fk_v_phone_ccopn.`number` AS 's_fk_v_phone_ccopn__number',
	s_fk_v_phone_ccopn.`extension` AS 's_fk_v_phone_ccopn__extension',
	s_fk_v_phone_ccopn.`itu` AS 's_fk_v_phone_ccopn__itu',

	s_fk_v_fax_ccopn.`id` AS 's_fk_v_fax_ccopn__contact_company_office_phone_number_id',
	s_fk_v_fax_ccopn.`contact_company_office_id` AS 's_fk_v_fax_ccopn__contact_company_office_id',
	s_fk_v_fax_ccopn.`phone_number_type_id` AS 's_fk_v_fax_ccopn__phone_number_type_id',
	s_fk_v_fax_ccopn.`country_code` AS 's_fk_v_fax_ccopn__country_code',
	s_fk_v_fax_ccopn.`area_code` AS 's_fk_v_fax_ccopn__area_code',
	s_fk_v_fax_ccopn.`prefix` AS 's_fk_v_fax_ccopn__prefix',
	s_fk_v_fax_ccopn.`number` AS 's_fk_v_fax_ccopn__number',
	s_fk_v_fax_ccopn.`extension` AS 's_fk_v_fax_ccopn__extension',
	s_fk_v_fax_ccopn.`itu` AS 's_fk_v_fax_ccopn__itu',

	s_fk_v_c.`id` AS 's_fk_v_c__contact_id',
	s_fk_v_c.`user_company_id` AS 's_fk_v_c__user_company_id',
	s_fk_v_c.`user_id` AS 's_fk_v_c__user_id',
	s_fk_v_c.`contact_company_id` AS 's_fk_v_c__contact_company_id',
	s_fk_v_c.`email` AS 's_fk_v_c__email',
	s_fk_v_c.`name_prefix` AS 's_fk_v_c__name_prefix',
	s_fk_v_c.`first_name` AS 's_fk_v_c__first_name',
	s_fk_v_c.`additional_name` AS 's_fk_v_c__additional_name',
	s_fk_v_c.`middle_name` AS 's_fk_v_c__middle_name',
	s_fk_v_c.`last_name` AS 's_fk_v_c__last_name',
	s_fk_v_c.`name_suffix` AS 's_fk_v_c__name_suffix',
	s_fk_v_c.`title` AS 's_fk_v_c__title',
	s_fk_v_c.`vendor_flag` AS 's_fk_v_c__vendor_flag',

	s_fk_v_c_mobile_cpn.`id` AS 's_fk_v_c_mobile_cpn__contact_phone_number_id',
	s_fk_v_c_mobile_cpn.`contact_id` AS 's_fk_v_c_mobile_cpn__contact_id',
	s_fk_v_c_mobile_cpn.`phone_number_type_id` AS 's_fk_v_c_mobile_cpn__phone_number_type_id',
	s_fk_v_c_mobile_cpn.`country_code` AS 's_fk_v_c_mobile_cpn__country_code',
	s_fk_v_c_mobile_cpn.`area_code` AS 's_fk_v_c_mobile_cpn__area_code',
	s_fk_v_c_mobile_cpn.`prefix` AS 's_fk_v_c_mobile_cpn__prefix',
	s_fk_v_c_mobile_cpn.`number` AS 's_fk_v_c_mobile_cpn__number',
	s_fk_v_c_mobile_cpn.`extension` AS 's_fk_v_c_mobile_cpn__extension',
	s_fk_v_c_mobile_cpn.`itu` AS 's_fk_v_c_mobile_cpn__itu',

	s_fk_unsigned_s_fmfiles.`id` AS 's_fk_unsigned_s_fmfiles__file_manager_file_id',
	s_fk_unsigned_s_fmfiles.`user_company_id` AS 's_fk_unsigned_s_fmfiles__user_company_id',
	s_fk_unsigned_s_fmfiles.`contact_id` AS 's_fk_unsigned_s_fmfiles__contact_id',
	s_fk_unsigned_s_fmfiles.`project_id` AS 's_fk_unsigned_s_fmfiles__project_id',
	s_fk_unsigned_s_fmfiles.`file_manager_folder_id` AS 's_fk_unsigned_s_fmfiles__file_manager_folder_id',
	s_fk_unsigned_s_fmfiles.`file_location_id` AS 's_fk_unsigned_s_fmfiles__file_location_id',
	s_fk_unsigned_s_fmfiles.`virtual_file_name` AS 's_fk_unsigned_s_fmfiles__virtual_file_name',
	s_fk_unsigned_s_fmfiles.`version_number` AS 's_fk_unsigned_s_fmfiles__version_number',
	s_fk_unsigned_s_fmfiles.`virtual_file_name_sha1` AS 's_fk_unsigned_s_fmfiles__virtual_file_name_sha1',
	s_fk_unsigned_s_fmfiles.`virtual_file_mime_type` AS 's_fk_unsigned_s_fmfiles__virtual_file_mime_type',
	s_fk_unsigned_s_fmfiles.`modified` AS 's_fk_unsigned_s_fmfiles__modified',
	s_fk_unsigned_s_fmfiles.`created` AS 's_fk_unsigned_s_fmfiles__created',
	s_fk_unsigned_s_fmfiles.`deleted_flag` AS 's_fk_unsigned_s_fmfiles__deleted_flag',
	s_fk_unsigned_s_fmfiles.`directly_deleted_flag` AS 's_fk_unsigned_s_fmfiles__directly_deleted_flag',

	s_fk_signed_s_fmfiles.`id` AS 's_fk_signed_s_fmfiles__file_manager_file_id',
	s_fk_signed_s_fmfiles.`user_company_id` AS 's_fk_signed_s_fmfiles__user_company_id',
	s_fk_signed_s_fmfiles.`contact_id` AS 's_fk_signed_s_fmfiles__contact_id',
	s_fk_signed_s_fmfiles.`project_id` AS 's_fk_signed_s_fmfiles__project_id',
	s_fk_signed_s_fmfiles.`file_manager_folder_id` AS 's_fk_signed_s_fmfiles__file_manager_folder_id',
	s_fk_signed_s_fmfiles.`file_location_id` AS 's_fk_signed_s_fmfiles__file_location_id',
	s_fk_signed_s_fmfiles.`virtual_file_name` AS 's_fk_signed_s_fmfiles__virtual_file_name',
	s_fk_signed_s_fmfiles.`version_number` AS 's_fk_signed_s_fmfiles__version_number',
	s_fk_signed_s_fmfiles.`virtual_file_name_sha1` AS 's_fk_signed_s_fmfiles__virtual_file_name_sha1',
	s_fk_signed_s_fmfiles.`virtual_file_mime_type` AS 's_fk_signed_s_fmfiles__virtual_file_mime_type',
	s_fk_signed_s_fmfiles.`modified` AS 's_fk_signed_s_fmfiles__modified',
	s_fk_signed_s_fmfiles.`created` AS 's_fk_signed_s_fmfiles__created',
	s_fk_signed_s_fmfiles.`deleted_flag` AS 's_fk_signed_s_fmfiles__deleted_flag',
	s_fk_signed_s_fmfiles.`directly_deleted_flag` AS 's_fk_signed_s_fmfiles__directly_deleted_flag',

	s_fk_v__fk_cc.`id` AS 's_fk_v__fk_cc__contact_company_id',
	s_fk_v__fk_cc.`user_user_company_id` AS 's_fk_v__fk_cc__user_user_company_id',
	s_fk_v__fk_cc.`contact_user_company_id` AS 's_fk_v__fk_cc__contact_user_company_id',
	s_fk_v__fk_cc.`company` AS 's_fk_v__fk_cc__company',
	s_fk_v__fk_cc.`primary_phone_number` AS 's_fk_v__fk_cc__primary_phone_number',
	s_fk_v__fk_cc.`employer_identification_number` AS 's_fk_v__fk_cc__employer_identification_number',
	s_fk_v__fk_cc.`construction_license_number` AS 's_fk_v__fk_cc__construction_license_number',
	s_fk_v__fk_cc.`construction_license_number_expiration_date` AS 's_fk_v__fk_cc__construction_license_number_expiration_date',
	s_fk_v__fk_cc.`vendor_flag` AS 's_fk_v__fk_cc__vendor_flag',

	s.*,

	sctype.subcontract_type

FROM `subcontracts` s
	INNER JOIN `gc_budget_line_items` s_fk_gbli ON s.`gc_budget_line_item_id` = s_fk_gbli.`id`
	LEFT OUTER JOIN `subcontractor_bids` s_fk_sb ON s.`subcontractor_bid_id` = s_fk_sb.`id`
	INNER JOIN `subcontract_templates` s_fk_st ON s.`subcontract_template_id` = s_fk_st.`id`
	LEFT OUTER JOIN `contact_company_offices` s_fk_gc_cco ON s.`subcontract_gc_contact_company_office_id` = s_fk_gc_cco.`id`
	LEFT OUTER JOIN `contact_company_office_phone_numbers` s_fk_gc_phone_ccopn ON s.`subcontract_gc_phone_contact_company_office_phone_number_id` = s_fk_gc_phone_ccopn.`id`
	LEFT OUTER JOIN `contact_company_office_phone_numbers` s_fk_gc_fax_ccopn ON s.`subcontract_gc_fax_contact_company_office_phone_number_id` = s_fk_gc_fax_ccopn.`id`
	LEFT OUTER JOIN `contacts` s_fk_gc_c ON s.`subcontract_gc_contact_id` = s_fk_gc_c.`id`
	LEFT OUTER JOIN `contact_phone_numbers` s_fk_gc_c_mobile_cpn ON s.`subcontract_gc_contact_mobile_phone_number_id` = s_fk_gc_c_mobile_cpn.`id`
	INNER JOIN `vendors` s_fk_v ON s.`vendor_id` = s_fk_v.`id`
	LEFT OUTER JOIN `contact_company_offices` s_fk_v_cco ON s.`subcontract_vendor_contact_company_office_id` = s_fk_v_cco.`id`
	LEFT OUTER JOIN `contact_company_office_phone_numbers` s_fk_v_phone_ccopn ON s.`subcontract_vendor_phone_contact_company_office_phone_number_id` = s_fk_v_phone_ccopn.`id`
	LEFT OUTER JOIN `contact_company_office_phone_numbers` s_fk_v_fax_ccopn ON s.`subcontract_vendor_fax_contact_company_office_phone_number_id` = s_fk_v_fax_ccopn.`id`
	LEFT OUTER JOIN `contacts` s_fk_v_c ON s.`subcontract_vendor_contact_id` = s_fk_v_c.`id`
	LEFT OUTER JOIN `contact_phone_numbers` s_fk_v_c_mobile_cpn ON s.`subcontract_vendor_contact_mobile_phone_number_id` = s_fk_v_c_mobile_cpn.`id`
	LEFT OUTER JOIN `file_manager_files` s_fk_unsigned_s_fmfiles ON s.`unsigned_subcontract_file_manager_file_id` = s_fk_unsigned_s_fmfiles.`id`
	LEFT OUTER JOIN `file_manager_files` s_fk_signed_s_fmfiles ON s.`signed_subcontract_file_manager_file_id` = s_fk_signed_s_fmfiles.`id`

	INNER JOIN `contact_companies` s_fk_v__fk_cc ON s_fk_v.`vendor_contact_company_id` = s_fk_v__fk_cc.`id`
	INNER JOIN subcontract_types sctype ON s_fk_st.subcontract_type_id = sctype.`id`

WHERE s.`gc_budget_line_item_id` = ? {$whereDate} {$sqlOrderBy}{$sqlLimit}
";
/*WHERE s.`gc_budget_line_item_id` = ?  and (s.`subcontract_mailed_date` between '".$startDate."' and '".$endDate."' OR s.`subcontract_execution_date` between '".$startDate."' and '".$endDate."'){$sqlOrderBy}{$sqlLimit}*/
// LIMIT 10
// ORDER BY `id` ASC, `gc_budget_line_item_id` ASC, `subcontract_sequence_number` ASC, `subcontractor_bid_id` ASC, `subcontract_template_id` ASC, `subcontract_gc_contact_company_office_id` ASC, `subcontract_gc_phone_contact_company_office_phone_number_id` ASC, `subcontract_gc_fax_contact_company_office_phone_number_id` ASC, `subcontract_gc_contact_id` ASC, `subcontract_gc_contact_mobile_phone_number_id` ASC, `vendor_id` ASC, `subcontract_vendor_contact_company_office_id` ASC, `subcontract_vendor_phone_contact_company_office_phone_number_id` ASC, `subcontract_vendor_fax_contact_company_office_phone_number_id` ASC, `subcontract_vendor_contact_id` ASC, `subcontract_vendor_contact_mobile_phone_number_id` ASC, `unsigned_subcontract_file_manager_file_id` ASC, `signed_subcontract_file_manager_file_id` ASC, `subcontract_forecasted_value` ASC, `subcontract_actual_value` ASC, `subcontract_retention_percentage` ASC, `subcontract_issued_date` ASC, `subcontract_target_execution_date` ASC, `subcontract_execution_date` ASC, `active_flag` ASC
		$arrValues = array($gc_budget_line_item_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubcontractsByGcBudgetLineItemId = array();
		while ($row = $db->fetch()) {
			$subcontract_id = $row['id'];
			$subcontract = self::instantiateOrm($database, 'Subcontract', $row, null, $subcontract_id);
			/* @var $subcontract Subcontract */
			$subcontract->convertPropertiesToData();

			if (isset($row['gc_budget_line_item_id'])) {
				$gc_budget_line_item_id = $row['gc_budget_line_item_id'];
				$row['s_fk_gbli__id'] = $gc_budget_line_item_id;
				$gcBudgetLineItem = self::instantiateOrm($database, 'GcBudgetLineItem', $row, null, $gc_budget_line_item_id, 's_fk_gbli__');
				/* @var $gcBudgetLineItem GcBudgetLineItem */
				$gcBudgetLineItem->convertPropertiesToData();
			} else {
				$gcBudgetLineItem = false;
			}
			$subcontract->setGcBudgetLineItem($gcBudgetLineItem);

			if (isset($row['subcontractor_bid_id'])) {
				$subcontractor_bid_id = $row['subcontractor_bid_id'];
				$row['s_fk_sb__id'] = $subcontractor_bid_id;
				$subcontractorBid = self::instantiateOrm($database, 'SubcontractorBid', $row, null, $subcontractor_bid_id, 's_fk_sb__');
				/* @var $subcontractorBid SubcontractorBid */
				$subcontractorBid->convertPropertiesToData();
			} else {
				$subcontractorBid = false;
			}
			$subcontract->setSubcontractorBid($subcontractorBid);

			if (isset($row['subcontract_template_id'])) {
				$subcontract_template_id = $row['subcontract_template_id'];
				$row['s_fk_st__id'] = $subcontract_template_id;
				$subcontractTemplate = self::instantiateOrm($database, 'SubcontractTemplate', $row, null, $subcontract_template_id, 's_fk_st__');
				/* @var $subcontractTemplate SubcontractTemplate */
				$subcontractTemplate->convertPropertiesToData();
			} else {
				$subcontractTemplate = false;
			}
			$subcontract->setSubcontractTemplate($subcontractTemplate);

			if (isset($row['subcontract_gc_contact_company_office_id'])) {
				$subcontract_gc_contact_company_office_id = $row['subcontract_gc_contact_company_office_id'];
				$row['s_fk_gc_cco__id'] = $subcontract_gc_contact_company_office_id;
				$subcontractGcContactCompanyOffice = self::instantiateOrm($database, 'ContactCompanyOffice', $row, null, $subcontract_gc_contact_company_office_id, 's_fk_gc_cco__');
				/* @var $subcontractGcContactCompanyOffice ContactCompanyOffice */
				$subcontractGcContactCompanyOffice->convertPropertiesToData();
			} else {
				$subcontractGcContactCompanyOffice = false;
			}
			$subcontract->setSubcontractGcContactCompanyOffice($subcontractGcContactCompanyOffice);

			if (isset($row['subcontract_gc_phone_contact_company_office_phone_number_id'])) {
				$subcontract_gc_phone_contact_company_office_phone_number_id = $row['subcontract_gc_phone_contact_company_office_phone_number_id'];
				$row['s_fk_gc_phone_ccopn__id'] = $subcontract_gc_phone_contact_company_office_phone_number_id;
				$subcontractGcPhoneContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $subcontract_gc_phone_contact_company_office_phone_number_id, 's_fk_gc_phone_ccopn__');
				/* @var $subcontractGcPhoneContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$subcontractGcPhoneContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$subcontractGcPhoneContactCompanyOfficePhoneNumber = false;
			}
			$subcontract->setSubcontractGcPhoneContactCompanyOfficePhoneNumber($subcontractGcPhoneContactCompanyOfficePhoneNumber);

			if (isset($row['subcontract_gc_fax_contact_company_office_phone_number_id'])) {
				$subcontract_gc_fax_contact_company_office_phone_number_id = $row['subcontract_gc_fax_contact_company_office_phone_number_id'];
				$row['s_fk_gc_fax_ccopn__id'] = $subcontract_gc_fax_contact_company_office_phone_number_id;
				$subcontractGcFaxContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $subcontract_gc_fax_contact_company_office_phone_number_id, 's_fk_gc_fax_ccopn__');
				/* @var $subcontractGcFaxContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$subcontractGcFaxContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$subcontractGcFaxContactCompanyOfficePhoneNumber = false;
			}
			$subcontract->setSubcontractGcFaxContactCompanyOfficePhoneNumber($subcontractGcFaxContactCompanyOfficePhoneNumber);

			if (isset($row['subcontract_gc_contact_id'])) {
				$subcontract_gc_contact_id = $row['subcontract_gc_contact_id'];
				$row['s_fk_gc_c__id'] = $subcontract_gc_contact_id;
				$subcontractGcContact = self::instantiateOrm($database, 'Contact', $row, null, $subcontract_gc_contact_id, 's_fk_gc_c__');
				/* @var $subcontractGcContact Contact */
				$subcontractGcContact->convertPropertiesToData();
			} else {
				$subcontractGcContact = false;
			}
			$subcontract->setSubcontractGcContact($subcontractGcContact);

			if (isset($row['subcontract_gc_contact_mobile_phone_number_id'])) {
				$subcontract_gc_contact_mobile_phone_number_id = $row['subcontract_gc_contact_mobile_phone_number_id'];
				$row['s_fk_gc_c_mobile_cpn__id'] = $subcontract_gc_contact_mobile_phone_number_id;
				$subcontractGcContactMobilePhoneNumber = self::instantiateOrm($database, 'ContactPhoneNumber', $row, null, $subcontract_gc_contact_mobile_phone_number_id, 's_fk_gc_c_mobile_cpn__');
				/* @var $subcontractGcContactMobilePhoneNumber ContactPhoneNumber */
				$subcontractGcContactMobilePhoneNumber->convertPropertiesToData();
			} else {
				$subcontractGcContactMobilePhoneNumber = false;
			}
			$subcontract->setSubcontractGcContactMobilePhoneNumber($subcontractGcContactMobilePhoneNumber);

			if (isset($row['vendor_id'])) {
				$vendor_id = $row['vendor_id'];
				$row['s_fk_v__id'] = $vendor_id;
				$vendor = self::instantiateOrm($database, 'Vendor', $row, null, $vendor_id, 's_fk_v__');
				/* @var $vendor Vendor */
				$vendor->convertPropertiesToData();
			} else {
				$vendor = false;
			}
			$subcontract->setVendor($vendor);

			if (isset($row['subcontract_vendor_contact_company_office_id'])) {
				$subcontract_vendor_contact_company_office_id = $row['subcontract_vendor_contact_company_office_id'];
				$row['s_fk_v_cco__id'] = $subcontract_vendor_contact_company_office_id;
				$subcontractVendorContactCompanyOffice = self::instantiateOrm($database, 'ContactCompanyOffice', $row, null, $subcontract_vendor_contact_company_office_id, 's_fk_v_cco__');
				/* @var $subcontractVendorContactCompanyOffice ContactCompanyOffice */
				$subcontractVendorContactCompanyOffice->convertPropertiesToData();
			} else {
				$subcontractVendorContactCompanyOffice = false;
			}
			$subcontract->setSubcontractVendorContactCompanyOffice($subcontractVendorContactCompanyOffice);

			if (isset($row['subcontract_vendor_phone_contact_company_office_phone_number_id'])) {
				$subcontract_vendor_phone_contact_company_office_phone_number_id = $row['subcontract_vendor_phone_contact_company_office_phone_number_id'];
				$row['s_fk_v_phone_ccopn__id'] = $subcontract_vendor_phone_contact_company_office_phone_number_id;
				$subcontractVendorPhoneContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $subcontract_vendor_phone_contact_company_office_phone_number_id, 's_fk_v_phone_ccopn__');
				/* @var $subcontractVendorPhoneContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$subcontractVendorPhoneContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$subcontractVendorPhoneContactCompanyOfficePhoneNumber = false;
			}
			$subcontract->setSubcontractVendorPhoneContactCompanyOfficePhoneNumber($subcontractVendorPhoneContactCompanyOfficePhoneNumber);

			if (isset($row['subcontract_vendor_fax_contact_company_office_phone_number_id'])) {
				$subcontract_vendor_fax_contact_company_office_phone_number_id = $row['subcontract_vendor_fax_contact_company_office_phone_number_id'];
				$row['s_fk_v_fax_ccopn__id'] = $subcontract_vendor_fax_contact_company_office_phone_number_id;
				$subcontractVendorFaxContactCompanyOfficePhoneNumber = self::instantiateOrm($database, 'ContactCompanyOfficePhoneNumber', $row, null, $subcontract_vendor_fax_contact_company_office_phone_number_id, 's_fk_v_fax_ccopn__');
				/* @var $subcontractVendorFaxContactCompanyOfficePhoneNumber ContactCompanyOfficePhoneNumber */
				$subcontractVendorFaxContactCompanyOfficePhoneNumber->convertPropertiesToData();
			} else {
				$subcontractVendorFaxContactCompanyOfficePhoneNumber = false;
			}
			$subcontract->setSubcontractVendorFaxContactCompanyOfficePhoneNumber($subcontractVendorFaxContactCompanyOfficePhoneNumber);

			if (isset($row['subcontract_vendor_contact_id'])) {
				$subcontract_vendor_contact_id = $row['subcontract_vendor_contact_id'];
				$row['s_fk_v_c__id'] = $subcontract_vendor_contact_id;
				$subcontractVendorContact = self::instantiateOrm($database, 'Contact', $row, null, $subcontract_vendor_contact_id, 's_fk_v_c__');
				/* @var $subcontractVendorContact Contact */
				$subcontractVendorContact->convertPropertiesToData();
			} else {
				$subcontractVendorContact = false;
			}
			$subcontract->setSubcontractVendorContact($subcontractVendorContact);

			if (isset($row['subcontract_vendor_contact_mobile_phone_number_id'])) {
				$subcontract_vendor_contact_mobile_phone_number_id = $row['subcontract_vendor_contact_mobile_phone_number_id'];
				$row['s_fk_v_c_mobile_cpn__id'] = $subcontract_vendor_contact_mobile_phone_number_id;
				$subcontractVendorContactMobilePhoneNumber = self::instantiateOrm($database, 'ContactPhoneNumber', $row, null, $subcontract_vendor_contact_mobile_phone_number_id, 's_fk_v_c_mobile_cpn__');
				/* @var $subcontractVendorContactMobilePhoneNumber ContactPhoneNumber */
				$subcontractVendorContactMobilePhoneNumber->convertPropertiesToData();
			} else {
				$subcontractVendorContactMobilePhoneNumber = false;
			}
			$subcontract->setSubcontractVendorContactMobilePhoneNumber($subcontractVendorContactMobilePhoneNumber);

			if (isset($row['unsigned_subcontract_file_manager_file_id'])) {
				$unsigned_subcontract_file_manager_file_id = $row['unsigned_subcontract_file_manager_file_id'];
				$row['s_fk_unsigned_s_fmfiles__id'] = $unsigned_subcontract_file_manager_file_id;
				$unsignedSubcontractFileManagerFile = self::instantiateOrm($database, 'FileManagerFile', $row, null, $unsigned_subcontract_file_manager_file_id, 's_fk_unsigned_s_fmfiles__');
				/* @var $unsignedSubcontractFileManagerFile FileManagerFile */
				$unsignedSubcontractFileManagerFile->convertPropertiesToData();
			} else {
				$unsignedSubcontractFileManagerFile = false;
			}
			$subcontract->setUnsignedSubcontractFileManagerFile($unsignedSubcontractFileManagerFile);

			if (isset($row['signed_subcontract_file_manager_file_id'])) {
				$signed_subcontract_file_manager_file_id = $row['signed_subcontract_file_manager_file_id'];
				$row['s_fk_signed_s_fmfiles__id'] = $signed_subcontract_file_manager_file_id;
				$signedSubcontractFileManagerFile = self::instantiateOrm($database, 'FileManagerFile', $row, null, $signed_subcontract_file_manager_file_id, 's_fk_signed_s_fmfiles__');
				/* @var $signedSubcontractFileManagerFile FileManagerFile */
				$signedSubcontractFileManagerFile->convertPropertiesToData();
			} else {
				$signedSubcontractFileManagerFile = false;
			}
			$subcontract->setSignedSubcontractFileManagerFile($signedSubcontractFileManagerFile);

			if (isset($row['s_fk_v__fk_cc__contact_company_id'])) {
				$vendor_contact_company_id = $row['s_fk_v__fk_cc__contact_company_id'];
				$row['s_fk_v__fk_cc__id'] = $vendor_contact_company_id;
				$vendorContactCompany = self::instantiateOrm($database, 'ContactCompany', $row, null, $vendor_contact_company_id, 's_fk_v__fk_cc__');
				/* @var $vendorContactCompany ContactCompany */
				$vendorContactCompany->convertPropertiesToData();
			} else {
				$vendorContactCompany = false;
			}

			if ($vendor) {
				$vendor->setVendorContactCompany($vendorContactCompany);
				$vendor->setVendorContactCompanyOffice($subcontractVendorContactCompanyOffice);
				$vendor->setVendorContact($subcontractVendorContact);
				//$vendor->setContactAddress($subcontractVendorPhoneContactCompanyOfficePhoneNumber);
			}

			// Additional attributes
			$subcontract_type = $row['subcontract_type'];
			$subcontract->subcontract_type = $subcontract_type;

			$arrSubcontractsByGcBudgetLineItemId[$subcontract_id] = $subcontract;
		}

		$db->free_result();

		self::$_arrSubcontractsByGcBudgetLineItemId = $arrSubcontractsByGcBudgetLineItemId;

	return $arrSubcontractsByGcBudgetLineItemId;
}

public static function loadCommittedSubcontractsByGcBudgetLineItemId($database, $gc_budget_line_item_id, $new_begindate, $enddate, Input $options=null)
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
		self::$_arrSubcontractsByGcBudgetLineItemId = null;
	}

	$arrSubcontractsByGcBudgetLineItemId = self::$_arrSubcontractsByGcBudgetLineItemId;
	if (isset($arrSubcontractsByGcBudgetLineItemId) && !empty($arrSubcontractsByGcBudgetLineItemId)) {
		return $arrSubcontractsByGcBudgetLineItemId;
	}

	$gc_budget_line_item_id = (int) $gc_budget_line_item_id;
	$startDate = date('Y-m-d',strtotime($new_begindate));
	$endDate = date('Y-m-d',strtotime($enddate));
	$db = DBI::getInstance($database);
	/* @var $db DBI_mysqli */

	// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
	$sqlOrderBy = "\nORDER BY s.`subcontract_sequence_number` ASC";
	if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
		$tmpSubcontract = new Subcontract($database);
		$sqlOrderByColumns = $tmpSubcontract->constructSqlOrderByColumns($arrOrderByAttributes);

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

	s_fk_v.`id` AS 's_fk_v__vendor_id',
	s_fk_v.`vendor_contact_company_id` AS 's_fk_v__vendor_contact_company_id',
	s_fk_v.`vendor_contact_company_office_id` AS 's_fk_v__vendor_contact_company_office_id',
	s_fk_v.`vendor_contact_id` AS 's_fk_v__vendor_contact_id',
	s_fk_v.`vendor_contact_address_id` AS 's_fk_v__vendor_contact_address_id',
	s_fk_v.`w9_file_manager_file_id` AS 's_fk_v__w9_file_manager_file_id',
	s_fk_v.`taxpayer_identification_number_id` AS 's_fk_v__taxpayer_identification_number_id',
	s_fk_v.`disabled_flag` AS 's_fk_v__disabled_flag',

	s_fk_v__fk_cc.`id` AS 's_fk_v__fk_cc__contact_company_id',
	s_fk_v__fk_cc.`user_user_company_id` AS 's_fk_v__fk_cc__user_user_company_id',
	s_fk_v__fk_cc.`contact_user_company_id` AS 's_fk_v__fk_cc__contact_user_company_id',
	s_fk_v__fk_cc.`company` AS 's_fk_v__fk_cc__company',
	s_fk_v__fk_cc.`primary_phone_number` AS 's_fk_v__fk_cc__primary_phone_number',
	s_fk_v__fk_cc.`employer_identification_number` AS 's_fk_v__fk_cc__employer_identification_number',
	s_fk_v__fk_cc.`construction_license_number` AS 's_fk_v__fk_cc__construction_license_number',
	s_fk_v__fk_cc.`construction_license_number_expiration_date` AS 's_fk_v__fk_cc__construction_license_number_expiration_date',
	s_fk_v__fk_cc.`vendor_flag` AS 's_fk_v__fk_cc__vendor_flag',
	
	s.*

	FROM `subcontracts` s
	INNER JOIN `vendors` s_fk_v ON s.`vendor_id` = s_fk_v.`id`
	INNER JOIN `contact_companies` s_fk_v__fk_cc ON s_fk_v.`vendor_contact_company_id` = s_fk_v__fk_cc.`id`
	WHERE s.`gc_budget_line_item_id` = ? 
	AND ((s.`subcontract_execution_date` BETWEEN ? AND ?) OR s.`subcontract_execution_date` = '0000-00-00')
	{$sqlOrderBy}{$sqlLimit}
	";
	$arrValues = array($gc_budget_line_item_id, $startDate, $endDate);
	// echo '<pre>';print_r($query);print_r($arrValues);exit;
	$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

	$arrSubcontractsByGcBudgetLineItemId = array();
	while ($row = $db->fetch()) {
		$subcontract_id = $row['id'];
		$subcontract = self::instantiateOrm($database, 'Subcontract', $row, null, $subcontract_id);
		/* @var $subcontract Subcontract */
		$subcontract->convertPropertiesToData();

		if (isset($row['vendor_id'])) {
			$vendor_id = $row['vendor_id'];
			$row['s_fk_v__id'] = $vendor_id;
			$vendor = self::instantiateOrm($database, 'Vendor', $row, null, $vendor_id, 's_fk_v__');
			/* @var $vendor Vendor */
			$vendor->convertPropertiesToData();
		} else {
			$vendor = false;
		}
		$subcontract->setVendor($vendor);

		if (isset($row['s_fk_v__fk_cc__contact_company_id'])) {
			$vendor_contact_company_id = $row['s_fk_v__fk_cc__contact_company_id'];
			$row['s_fk_v__fk_cc__id'] = $vendor_contact_company_id;
			$vendorContactCompany = self::instantiateOrm($database, 'ContactCompany', $row, null, $vendor_contact_company_id, 's_fk_v__fk_cc__');
			/* @var $vendorContactCompany ContactCompany */
			$vendorContactCompany->convertPropertiesToData();
		} else {
			$vendorContactCompany = false;
		}

		if ($vendor) {
			$vendor->setVendorContactCompany($vendorContactCompany);
			if(isset($subcontractVendorContact)&& !empty($subcontractVendorContact)) {
				$vendor->setVendorContact($subcontractVendorContact);
			}
			
		}

		// Additional attributes
		if(isset($row['subcontract_type']) && !empty($row['subcontract_type'])) {
			$subcontract_type = $row['subcontract_type'];
			$subcontract->subcontract_type = $subcontract_type;
		}

		$arrSubcontractsByGcBudgetLineItemId[$subcontract_id] = $subcontract;
	}

	$db->free_result();

	self::$_arrSubcontractsByGcBudgetLineItemId = $arrSubcontractsByGcBudgetLineItemId;
// echo '<pre>';print_r($arrSubcontractsByGcBudgetLineItemId);exit;
	return $arrSubcontractsByGcBudgetLineItemId;
}

public static function loadSubcontractorContact($database,$subcontractor_id)
{
	$arrvendor = self::subcontractvendorcompanyName($database,$subcontractor_id);
	$vendorid = $arrvendor['v__vendor_contact_company_id'];

	$db = DBI::getInstance($database);
	$query = "SELECT c_fk_cc.`id` AS 'c_fk_cc__contact_company_id',
	c_fk_cc.`user_user_company_id` AS 'c_fk_cc__user_user_company_id',
	c_fk_cc.`contact_user_company_id` AS 'c_fk_cc__contact_user_company_id',
	c_fk_cc.`company` AS 'c_fk_cc__company',
	c_fk_cc.`primary_phone_number` AS 'c_fk_cc__primary_phone_number',
	c_fk_cc.`employer_identification_number` AS 'c_fk_cc__employer_identification_number',
	c_fk_cc.`construction_license_number` AS 'c_fk_cc__construction_license_number',
	c_fk_cc.`construction_license_number_expiration_date` AS 'c_fk_cc__construction_license_number_expiration_date',
	c_fk_cc.`vendor_flag` AS 'c_fk_cc__vendor_flag',

	c.* FROM `contacts` c inner join `contact_companies` c_fk_cc on c.`contact_company_id` = c_fk_cc.`id`  WHERE c.`contact_company_id` = ? AND c.`is_archive` = 'N' ";
	$arrValues = array($vendorid);
	$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
	$arrContactTeamMembers = array();	
	while ($row = $db->fetch()) {

		$val = $row['id'];
		$arrContactTeamMembers[$val]=$row;
	}
			
	$db->free_result();
	return $arrContactTeamMembers;
		

}


public static function subcontractvendorcompanyName($database,$subcontractor_id)
{

	$db = DBI::getInstance($database);
	

	$query =
	"
	SELECT

	v.`id` AS 'v__vendor_id',
	v.`vendor_contact_company_id` AS 'v__vendor_contact_company_id',
	v.`vendor_contact_company_office_id` AS 'v__vendor_contact_company_office_id',
	v.`vendor_contact_id` AS 'v__vendor_contact_id',
	v.`vendor_contact_address_id` AS 'v__vendor_contact_address_id',
	v.`w9_file_manager_file_id` AS 'v__w9_file_manager_file_id',
	v.`taxpayer_identification_number_id` AS 'v__taxpayer_identification_number_id',
	v.`disabled_flag` AS 'v__disabled_flag',

	cc.`id` AS 'cc__contact_company_id',
	cc.`user_user_company_id` AS 'cc__user_user_company_id',
	cc.`contact_user_company_id` AS 'cc__contact_user_company_id',
	cc.`company` AS 'cc__company',
	cc.`primary_phone_number` AS 'cc__primary_phone_number',
	cc.`employer_identification_number` AS 'cc__employer_identification_number',
	cc.`construction_license_number` AS 'cc__construction_license_number',
	cc.`construction_license_number_expiration_date` AS 'cc__construction_license_number_expiration_date',
	cc.`vendor_flag` AS 'cc__vendor_flag',
	
	s.*

	FROM `subcontracts` s
	INNER JOIN `vendors` v ON s.`vendor_id` = v.`id`
	INNER JOIN `contact_companies` cc ON v.`vendor_contact_company_id` = cc.`id`
	WHERE s.`id` =?
	";
	$arrValues = array($subcontractor_id);
	$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
	$subcontractcompany =  $db->fetch();
	$db->free_result();
	return $subcontractcompany;
}


public static function loadCurrentSubcontractsByGcBudgetLineItemId($database, $gc_budget_line_item_id, Input $options=null){
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
		self::$_arrSubcontractsByGcBudgetLineItemId = null;
	}

	$arrSubcontractsByGcBudgetLineItemId = self::$_arrSubcontractsByGcBudgetLineItemId;
	if (isset($arrSubcontractsByGcBudgetLineItemId) && !empty($arrSubcontractsByGcBudgetLineItemId)) {
		return $arrSubcontractsByGcBudgetLineItemId;
	}

	$gc_budget_line_item_id = (int) $gc_budget_line_item_id;
	// $startDate = date('Y-m-d',strtotime($new_begindate));
	// $endDate = date('Y-m-d',strtotime($enddate));
	$db = DBI::getInstance($database);
	/* @var $db DBI_mysqli */

	// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
	$sqlOrderBy = "\nORDER BY s.`subcontract_sequence_number` ASC";
	if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
		$tmpSubcontract = new Subcontract($database);
		$sqlOrderByColumns = $tmpSubcontract->constructSqlOrderByColumns($arrOrderByAttributes);

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

	s_fk_v.`id` AS 's_fk_v__vendor_id',
	s_fk_v.`vendor_contact_company_id` AS 's_fk_v__vendor_contact_company_id',
	s_fk_v.`vendor_contact_company_office_id` AS 's_fk_v__vendor_contact_company_office_id',
	s_fk_v.`vendor_contact_id` AS 's_fk_v__vendor_contact_id',
	s_fk_v.`vendor_contact_address_id` AS 's_fk_v__vendor_contact_address_id',
	s_fk_v.`w9_file_manager_file_id` AS 's_fk_v__w9_file_manager_file_id',
	s_fk_v.`taxpayer_identification_number_id` AS 's_fk_v__taxpayer_identification_number_id',
	s_fk_v.`disabled_flag` AS 's_fk_v__disabled_flag',

	s_fk_v__fk_cc.`id` AS 's_fk_v__fk_cc__contact_company_id',
	s_fk_v__fk_cc.`user_user_company_id` AS 's_fk_v__fk_cc__user_user_company_id',
	s_fk_v__fk_cc.`contact_user_company_id` AS 's_fk_v__fk_cc__contact_user_company_id',
	s_fk_v__fk_cc.`company` AS 's_fk_v__fk_cc__company',
	s_fk_v__fk_cc.`primary_phone_number` AS 's_fk_v__fk_cc__primary_phone_number',
	s_fk_v__fk_cc.`employer_identification_number` AS 's_fk_v__fk_cc__employer_identification_number',
	s_fk_v__fk_cc.`construction_license_number` AS 's_fk_v__fk_cc__construction_license_number',
	s_fk_v__fk_cc.`construction_license_number_expiration_date` AS 's_fk_v__fk_cc__construction_license_number_expiration_date',
	s_fk_v__fk_cc.`vendor_flag` AS 's_fk_v__fk_cc__vendor_flag',

	s.*

	FROM `subcontracts` s
	INNER JOIN `vendors` s_fk_v ON s.`vendor_id` = s_fk_v.`id`
	INNER JOIN `contact_companies` s_fk_v__fk_cc ON s_fk_v.`vendor_contact_company_id` = s_fk_v__fk_cc.`id`
	WHERE s.`gc_budget_line_item_id` = ? {$sqlOrderBy}{$sqlLimit}
	";
	$arrValues = array($gc_budget_line_item_id);
	// echo '<pre>';print_r($query);print_r($arrValues);
	$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
  // print_r($db->fetch());
	$arrSubcontractsByGcBudgetLineItemId = array();
	while ($row = $db->fetch()) {
		$subcontract_id = $row['id'];
		$subcontract = self::instantiateOrm($database, 'Subcontract', $row, null, $subcontract_id);
		/* @var $subcontract Subcontract */
		$subcontract->convertPropertiesToData();

		if (isset($row['vendor_id'])) {
			$vendor_id = $row['vendor_id'];
			$row['s_fk_v__id'] = $vendor_id;
			$vendor = self::instantiateOrm($database, 'Vendor', $row, null, $vendor_id, 's_fk_v__');
			/* @var $vendor Vendor */
			$vendor->convertPropertiesToData();
		} else {
			$vendor = false;
		}
		$subcontract->setVendor($vendor);

		if (isset($row['s_fk_v__fk_cc__contact_company_id'])) {
			$vendor_contact_company_id = $row['s_fk_v__fk_cc__contact_company_id'];
			$row['s_fk_v__fk_cc__id'] = $vendor_contact_company_id;
			$vendorContactCompany = self::instantiateOrm($database, 'ContactCompany', $row, null, $vendor_contact_company_id, 's_fk_v__fk_cc__');
			/* @var $vendorContactCompany ContactCompany */
			$vendorContactCompany->convertPropertiesToData();
		} else {
			$vendorContactCompany = false;
		}

		if ($vendor) {
			$vendor->setVendorContactCompany($vendorContactCompany);
			if(isset($subcontractVendorContact)&& !empty($subcontractVendorContact)) {
				$vendor->setVendorContact($subcontractVendorContact);
			}
			
		}

		// Additional attributes
		if(isset($row['subcontract_type']) && !empty($row['subcontract_type'])) {
			$subcontract_type = $row['subcontract_type'];
			$subcontract->subcontract_type = $subcontract_type;
		}
		$arrSubcontractsByGcBudgetLineItemId[$subcontract_id] = $subcontract;
	}

	$db->free_result();

	self::$_arrSubcontractsByGcBudgetLineItemId = $arrSubcontractsByGcBudgetLineItemId;
	return $arrSubcontractsByGcBudgetLineItemId;
}
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

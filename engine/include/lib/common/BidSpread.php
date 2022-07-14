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
 * BidSpread.
 *
 * @category   Framework
 * @package    BidSpread
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

require_once('lib/common/CostCodeDividerForUserCompany.php');

class BidSpread extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'BidSpread';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'bid_spreads';

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
	 * unique index `unique_bid_spread` (`gc_budget_line_item_id`,`bid_spread_sequence_number`)
	 * unique index `unique_bid_spread_by_sha1` (`bid_spreadsheet_data_sha1`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_bid_spread' => array(
			'gc_budget_line_item_id' => 'int',
			'bid_spread_sequence_number' => 'int'
		),
		'unique_bid_spread_by_sha1' => array(
			'bid_spreadsheet_data_sha1' => 'string'
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
		'id' => 'bid_spread_id',

		'gc_budget_line_item_id' => 'gc_budget_line_item_id',
		'bid_spread_sequence_number' => 'bid_spread_sequence_number',
		'bid_spread_status_id' => 'bid_spread_status_id',
		'bid_spreadsheet_data_sha1' => 'bid_spreadsheet_data_sha1',

		'bid_spread_submitter_gc_project_manager_contact_id' => 'bid_spread_submitter_gc_project_manager_contact_id',
		'bid_spread_approver_gc_project_executive_contact_id' => 'bid_spread_approver_gc_project_executive_contact_id',
		'bid_spread_bid_total' => 'bid_spread_bid_total',
		'bid_spread_approved_value' => 'bid_spread_approved_value',
		'unsigned_bid_spread_pdf_file_manager_file_id' => 'unsigned_bid_spread_pdf_file_manager_file_id',
		'signed_bid_spread_pdf_file_manager_file_id' => 'signed_bid_spread_pdf_file_manager_file_id',
		'unsigned_bid_spread_xls_file_manager_file_id' => 'unsigned_bid_spread_xls_file_manager_file_id',
		'signed_bid_spread_xls_file_manager_file_id' => 'signed_bid_spread_xls_file_manager_file_id',

		'modified' => 'modified',
		'created' => 'created',
		'display_linked_cost_codes_flag' => 'display_linked_cost_codes_flag',
		'sort_order' => 'sort_order'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $bid_spread_id;

	public $gc_budget_line_item_id;
	public $bid_spread_sequence_number;
	public $bid_spread_status_id;
	public $bid_spreadsheet_data_sha1;

	public $bid_spread_submitter_gc_project_manager_contact_id;
	public $bid_spread_approver_gc_project_executive_contact_id;
	public $bid_spread_bid_total;
	public $bid_spread_approved_value;
	public $unsigned_bid_spread_pdf_file_manager_file_id;
	public $signed_bid_spread_pdf_file_manager_file_id;
	public $unsigned_bid_spread_xls_file_manager_file_id;
	public $signed_bid_spread_xls_file_manager_file_id;

	public $modified;
	public $created;
	public $display_linked_cost_codes_flag;
	public $sort_order;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties
	public $escaped_bid_spreadsheet_data_sha1;

	// HTML ENTITY ENCODED NL2BR ORM string properties
	public $escaped_bid_spreadsheet_data_sha1_nl2br;

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)
	protected static $_arrBidSpreadsByGcBudgetLineItemId;
	protected static $_arrBidSpreadsByBidSpreadStatusId;
	protected static $_arrBidSpreadsByBidSpreadSubmitterGcProjectManagerContactId;
	protected static $_arrBidSpreadsByBidSpreadApproverGcProjectExecutiveContactId;
	protected static $_arrBidSpreadsByUnsignedBidSpreadPdfFileManagerFileId;
	protected static $_arrBidSpreadsBySignedBidSpreadPdfFileManagerFileId;
	protected static $_arrBidSpreadsByUnsignedBidSpreadXlsFileManagerFileId;
	protected static $_arrBidSpreadsBySignedBidSpreadXlsFileManagerFileId;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllBidSpreads;

	// Foreign Key Objects
	private $_gcBudgetLineItem;
	private $_bidSpreadStatus;
	private $_bidSpreadSubmitterGcProjectManagerContact;
	private $_bidSpreadApproverGcProjectExecutiveContact;
	private $_unsignedBidSpreadPdfFileManagerFile;
	private $_signedBidSpreadPdfFileManagerFile;
	private $_unsignedBidSpreadXlsFileManagerFile;
	private $_signedBidSpreadXlsFileManagerFile;

	private $_unsignedBidSpreadPdfFileManagerFolder;
	private $_signedBidSpreadPdfFileManagerFolder;
	private $_unsignedBidSpreadXlsFileManagerFolder;
	private $_signedBidSpreadXlsFileManagerFolder;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='bid_spreads')
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

	public function getBidSpreadStatus()
	{
		if (isset($this->_bidSpreadStatus)) {
			return $this->_bidSpreadStatus;
		} else {
			return null;
		}
	}

	public function setBidSpreadStatus($bidSpreadStatus)
	{
		$this->_bidSpreadStatus = $bidSpreadStatus;
	}

	public function getBidSpreadSubmitterGcProjectManagerContact($database, $project_id, $user_id,$userRole, $projManager, Input $options=null){
		if (isset($this->_bidSpreadSubmitterGcProjectManagerContact)){
			return $this->_bidSpreadSubmitterGcProjectManagerContact;
		} else {
			return null;
		}
	}

	public function loadDiscussionItemsByProjectUserId($database, $project_id, $user_id,$userRole, $projManager, Input $options=null){
		$arrValues=[];

		$session = Zend_Registry::get('session');
		$user_company_id = $session->getUserCompanyId();
		$db = DBI::getInstance($database);

		//cost code divider
		$costCodeDividerType = CostCodeDividerForUserCompany::getCostCodeDividerForUserCompanyById($database, $user_company_id);

		$query ="SELECT `bs`.id,concat(`ccd`.`division_number`,'$costCodeDividerType',`cd`.`cost_code`) as short_cost_code,/*`p`.`project_name`,*/concat(`ct`.`first_name`,' ',`ct`.`last_name`) as pe_name,`bss`.`bid_spread_status`,`bs`.`modified` FROM `bid_spreads` as `bs` 
		INNER JOIN `gc_budget_line_items` as bli ON `bli`.`id` = `bs`.`gc_budget_line_item_id` 
		-- INNER JOIN `projects` as p ON `p`.`id` = `bli`.`project_id` 
		INNER JOIN `cost_codes` as cd on `cd`.`id` = `bli`.`cost_code_id` 
		INNER JOIN `contacts` as `ct` on `ct`.`id` = `bs`.`bid_spread_approver_gc_project_executive_contact_id` 
		INNER JOIN `bid_spread_statuses` as `bss` on `bss`.`id` = `bs`.`bid_spread_status_id` 
		INNER JOIN `cost_code_divisions` as `ccd` on `ccd`.`id` = `cd`.`cost_code_division_id` WHERE `bs`.`bid_spread_status_id` IN ('3','6') AND `bli`.`project_id` = '$project_id' ORDER BY `bs`.id DESC";
		
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrDiscussionItemsByMeetingId = array();
		while($row = $db->fetch()){
			$arrDiscussionItemsByMeetingId[] = $row;
		}
		return $arrDiscussionItemsByMeetingId;

	}
	public function setBidSpreadSubmitterGcProjectManagerContact($bidSpreadSubmitterGcProjectManagerContact)
	{
		$this->_bidSpreadSubmitterGcProjectManagerContact = $bidSpreadSubmitterGcProjectManagerContact;
	}

	public function getBidSpreadApproverGcProjectExecutiveContact()
	{
		if (isset($this->_bidSpreadApproverGcProjectExecutiveContact)) {
			return $this->_bidSpreadApproverGcProjectExecutiveContact;
		} else {
			return null;
		}
	}

	public function setBidSpreadApproverGcProjectExecutiveContact($bidSpreadApproverGcProjectExecutiveContact)
	{
		$this->_bidSpreadApproverGcProjectExecutiveContact = $bidSpreadApproverGcProjectExecutiveContact;
	}

	public function getUnsignedBidSpreadPdfFileManagerFile()
	{
		if (isset($this->_unsignedBidSpreadPdfFileManagerFile)) {
			return $this->_unsignedBidSpreadPdfFileManagerFile;
		} else {
			return null;
		}
	}

	public function setUnsignedBidSpreadPdfFileManagerFile($unsignedBidSpreadPdfFileManagerFile)
	{
		$this->_unsignedBidSpreadPdfFileManagerFile = $unsignedBidSpreadPdfFileManagerFile;
	}

	public function getSignedBidSpreadPdfFileManagerFile()
	{
		if (isset($this->_signedBidSpreadPdfFileManagerFile)) {
			return $this->_signedBidSpreadPdfFileManagerFile;
		} else {
			return null;
		}
	}

	public function setSignedBidSpreadPdfFileManagerFile($signedBidSpreadPdfFileManagerFile)
	{
		$this->_signedBidSpreadPdfFileManagerFile = $signedBidSpreadPdfFileManagerFile;
	}

	public function getUnsignedBidSpreadXlsFileManagerFile()
	{
		if (isset($this->_unsignedBidSpreadXlsFileManagerFile)) {
			return $this->_unsignedBidSpreadXlsFileManagerFile;
		} else {
			return null;
		}
	}

	public function setUnsignedBidSpreadXlsFileManagerFile($unsignedBidSpreadXlsFileManagerFile)
	{
		$this->_unsignedBidSpreadXlsFileManagerFile = $unsignedBidSpreadXlsFileManagerFile;
	}

	public function getSignedBidSpreadXlsFileManagerFile()
	{
		if (isset($this->_signedBidSpreadXlsFileManagerFile)) {
			return $this->_signedBidSpreadXlsFileManagerFile;
		} else {
			return null;
		}
	}

	public function setSignedBidSpreadXlsFileManagerFile($signedBidSpreadXlsFileManagerFile)
	{
		$this->_signedBidSpreadXlsFileManagerFile = $signedBidSpreadXlsFileManagerFile;
	}

	public function getUnsignedBidSpreadPdfFileManagerFolder()
	{
		if (isset($this->_unsignedBidSpreadPdfFileManagerFolder)) {
			return $this->_unsignedBidSpreadPdfFileManagerFolder;
		} else {
			return null;
		}
	}

	public function setUnsignedBidSpreadPdfFileManagerFolder($unsignedBidSpreadPdfFileManagerFolder)
	{
		$this->_unsignedBidSpreadPdfFileManagerFolder = $unsignedBidSpreadPdfFileManagerFolder;
	}

	public function getSignedBidSpreadPdfFileManagerFolder()
	{
		if (isset($this->_signedBidSpreadPdfFileManagerFolder)) {
			return $this->_signedBidSpreadPdfFileManagerFolder;
		} else {
			return null;
		}
	}

	public function setSignedBidSpreadPdfFileManagerFolder($signedBidSpreadPdfFileManagerFolder)
	{
		$this->_signedBidSpreadPdfFileManagerFolder = $signedBidSpreadPdfFileManagerFolder;
	}

	public function getUnsignedBidSpreadXlsFileManagerFolder()
	{
		if (isset($this->_unsignedBidSpreadXlsFileManagerFolder)) {
			return $this->_unsignedBidSpreadXlsFileManagerFolder;
		} else {
			return null;
		}
	}

	public function setUnsignedBidSpreadXlsFileManagerFolder($unsignedBidSpreadXlsFileManagerFolder)
	{
		$this->_unsignedBidSpreadXlsFileManagerFolder = $unsignedBidSpreadXlsFileManagerFolder;
	}

	public function getSignedBidSpreadXlsFileManagerFolder()
	{
		if (isset($this->_signedBidSpreadXlsFileManagerFolder)) {
			return $this->_signedBidSpreadXlsFileManagerFolder;
		} else {
			return null;
		}
	}

	public function setSignedBidSpreadXlsFileManagerFolder($signedBidSpreadXlsFileManagerFolder)
	{
		$this->_signedBidSpreadXlsFileManagerFolder = $signedBidSpreadXlsFileManagerFolder;
	}

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)
	public static function getArrBidSpreadsByGcBudgetLineItemId()
	{
		if (isset(self::$_arrBidSpreadsByGcBudgetLineItemId)) {
			return self::$_arrBidSpreadsByGcBudgetLineItemId;
		} else {
			return null;
		}
	}

	public static function setArrBidSpreadsByGcBudgetLineItemId($arrBidSpreadsByGcBudgetLineItemId)
	{
		self::$_arrBidSpreadsByGcBudgetLineItemId = $arrBidSpreadsByGcBudgetLineItemId;
	}

	public static function getArrBidSpreadsByBidSpreadStatusId()
	{
		if (isset(self::$_arrBidSpreadsByBidSpreadStatusId)) {
			return self::$_arrBidSpreadsByBidSpreadStatusId;
		} else {
			return null;
		}
	}

	public static function setArrBidSpreadsByBidSpreadStatusId($arrBidSpreadsByBidSpreadStatusId)
	{
		self::$_arrBidSpreadsByBidSpreadStatusId = $arrBidSpreadsByBidSpreadStatusId;
	}

	public static function getArrBidSpreadsByBidSpreadSubmitterGcProjectManagerContactId()
	{
		if (isset(self::$_arrBidSpreadsByBidSpreadSubmitterGcProjectManagerContactId)) {
			return self::$_arrBidSpreadsByBidSpreadSubmitterGcProjectManagerContactId;
		} else {
			return null;
		}
	}

	public static function setArrBidSpreadsByBidSpreadSubmitterGcProjectManagerContactId($arrBidSpreadsByBidSpreadSubmitterGcProjectManagerContactId)
	{
		self::$_arrBidSpreadsByBidSpreadSubmitterGcProjectManagerContactId = $arrBidSpreadsByBidSpreadSubmitterGcProjectManagerContactId;
	}

	public static function getArrBidSpreadsByBidSpreadApproverGcProjectExecutiveContactId()
	{
		if (isset(self::$_arrBidSpreadsByBidSpreadApproverGcProjectExecutiveContactId)) {
			return self::$_arrBidSpreadsByBidSpreadApproverGcProjectExecutiveContactId;
		} else {
			return null;
		}
	}

	public static function setArrBidSpreadsByBidSpreadApproverGcProjectExecutiveContactId($arrBidSpreadsByBidSpreadApproverGcProjectExecutiveContactId)
	{
		self::$_arrBidSpreadsByBidSpreadApproverGcProjectExecutiveContactId = $arrBidSpreadsByBidSpreadApproverGcProjectExecutiveContactId;
	}

	public static function getArrBidSpreadsByUnsignedBidSpreadPdfFileManagerFileId()
	{
		if (isset(self::$_arrBidSpreadsByUnsignedBidSpreadPdfFileManagerFileId)) {
			return self::$_arrBidSpreadsByUnsignedBidSpreadPdfFileManagerFileId;
		} else {
			return null;
		}
	}

	public static function setArrBidSpreadsByUnsignedBidSpreadPdfFileManagerFileId($arrBidSpreadsByUnsignedBidSpreadPdfFileManagerFileId)
	{
		self::$_arrBidSpreadsByUnsignedBidSpreadPdfFileManagerFileId = $arrBidSpreadsByUnsignedBidSpreadPdfFileManagerFileId;
	}

	public static function getArrBidSpreadsBySignedBidSpreadPdfFileManagerFileId()
	{
		if (isset(self::$_arrBidSpreadsBySignedBidSpreadPdfFileManagerFileId)) {
			return self::$_arrBidSpreadsBySignedBidSpreadPdfFileManagerFileId;
		} else {
			return null;
		}
	}

	public static function setArrBidSpreadsBySignedBidSpreadPdfFileManagerFileId($arrBidSpreadsBySignedBidSpreadPdfFileManagerFileId)
	{
		self::$_arrBidSpreadsBySignedBidSpreadPdfFileManagerFileId = $arrBidSpreadsBySignedBidSpreadPdfFileManagerFileId;
	}

	public static function getArrBidSpreadsByUnsignedBidSpreadXlsFileManagerFileId()
	{
		if (isset(self::$_arrBidSpreadsByUnsignedBidSpreadXlsFileManagerFileId)) {
			return self::$_arrBidSpreadsByUnsignedBidSpreadXlsFileManagerFileId;
		} else {
			return null;
		}
	}

	public static function setArrBidSpreadsByUnsignedBidSpreadXlsFileManagerFileId($arrBidSpreadsByUnsignedBidSpreadXlsFileManagerFileId)
	{
		self::$_arrBidSpreadsByUnsignedBidSpreadXlsFileManagerFileId = $arrBidSpreadsByUnsignedBidSpreadXlsFileManagerFileId;
	}

	public static function getArrBidSpreadsBySignedBidSpreadXlsFileManagerFileId()
	{
		if (isset(self::$_arrBidSpreadsBySignedBidSpreadXlsFileManagerFileId)) {
			return self::$_arrBidSpreadsBySignedBidSpreadXlsFileManagerFileId;
		} else {
			return null;
		}
	}

	public static function setArrBidSpreadsBySignedBidSpreadXlsFileManagerFileId($arrBidSpreadsBySignedBidSpreadXlsFileManagerFileId)
	{
		self::$_arrBidSpreadsBySignedBidSpreadXlsFileManagerFileId = $arrBidSpreadsBySignedBidSpreadXlsFileManagerFileId;
	}

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllBidSpreads()
	{
		if (isset(self::$_arrAllBidSpreads)) {
			return self::$_arrAllBidSpreads;
		} else {
			return null;
		}
	}

	public static function setArrAllBidSpreads($arrAllBidSpreads)
	{
		self::$_arrAllBidSpreads = $arrAllBidSpreads;
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
	 * @param int $bid_spread_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findById($database, $bid_spread_id, $table='bid_spreads', $module='BidSpread')
	{
		$bidSpread = parent::findById($database, $bid_spread_id, $table, $module);

		return $bidSpread;
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Similar to FindById, but with SQL as starter code for more complex joins.
	 *
	 * @param string $database
	 * @param int $bid_spread_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findBidSpreadByIdExtended($database, $bid_spread_id)
	{
		$bid_spread_id = (int) $bid_spread_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	bs_fk_gbli.`id` AS 'bs_fk_gbli__gc_budget_line_item_id',
	bs_fk_gbli.`user_company_id` AS 'bs_fk_gbli__user_company_id',
	bs_fk_gbli.`project_id` AS 'bs_fk_gbli__project_id',
	bs_fk_gbli.`cost_code_id` AS 'bs_fk_gbli__cost_code_id',
	bs_fk_gbli.`modified` AS 'bs_fk_gbli__modified',
	bs_fk_gbli.`prime_contract_scheduled_value` AS 'bs_fk_gbli__prime_contract_scheduled_value',
	bs_fk_gbli.`forecasted_expenses` AS 'bs_fk_gbli__forecasted_expenses',
	bs_fk_gbli.`created` AS 'bs_fk_gbli__created',
	bs_fk_gbli.`sort_order` AS 'bs_fk_gbli__sort_order',
	bs_fk_gbli.`disabled_flag` AS 'bs_fk_gbli__disabled_flag',

	bs_fk_bss.`id` AS 'bs_fk_bss__bid_spread_status_id',
	bs_fk_bss.`bid_spread_status` AS 'bs_fk_bss__bid_spread_status',
	bs_fk_bss.`bid_spread_status_action_label` AS 'bs_fk_bss__bid_spread_status_action_label',
	bs_fk_bss.`sort_order` AS 'bs_fk_bss__sort_order',

	bs_fk_submitter_gc_project_manager_c.`id` AS 'bs_fk_submitter_gc_project_manager_c__contact_id',
	bs_fk_submitter_gc_project_manager_c.`user_company_id` AS 'bs_fk_submitter_gc_project_manager_c__user_company_id',
	bs_fk_submitter_gc_project_manager_c.`user_id` AS 'bs_fk_submitter_gc_project_manager_c__user_id',
	bs_fk_submitter_gc_project_manager_c.`contact_company_id` AS 'bs_fk_submitter_gc_project_manager_c__contact_company_id',
	bs_fk_submitter_gc_project_manager_c.`email` AS 'bs_fk_submitter_gc_project_manager_c__email',
	bs_fk_submitter_gc_project_manager_c.`name_prefix` AS 'bs_fk_submitter_gc_project_manager_c__name_prefix',
	bs_fk_submitter_gc_project_manager_c.`first_name` AS 'bs_fk_submitter_gc_project_manager_c__first_name',
	bs_fk_submitter_gc_project_manager_c.`additional_name` AS 'bs_fk_submitter_gc_project_manager_c__additional_name',
	bs_fk_submitter_gc_project_manager_c.`middle_name` AS 'bs_fk_submitter_gc_project_manager_c__middle_name',
	bs_fk_submitter_gc_project_manager_c.`last_name` AS 'bs_fk_submitter_gc_project_manager_c__last_name',
	bs_fk_submitter_gc_project_manager_c.`name_suffix` AS 'bs_fk_submitter_gc_project_manager_c__name_suffix',
	bs_fk_submitter_gc_project_manager_c.`title` AS 'bs_fk_submitter_gc_project_manager_c__title',
	bs_fk_submitter_gc_project_manager_c.`vendor_flag` AS 'bs_fk_submitter_gc_project_manager_c__vendor_flag',

	bs_fk_approver_gc_project_executive_c.`id` AS 'bs_fk_approver_gc_project_executive_c__contact_id',
	bs_fk_approver_gc_project_executive_c.`user_company_id` AS 'bs_fk_approver_gc_project_executive_c__user_company_id',
	bs_fk_approver_gc_project_executive_c.`user_id` AS 'bs_fk_approver_gc_project_executive_c__user_id',
	bs_fk_approver_gc_project_executive_c.`contact_company_id` AS 'bs_fk_approver_gc_project_executive_c__contact_company_id',
	bs_fk_approver_gc_project_executive_c.`email` AS 'bs_fk_approver_gc_project_executive_c__email',
	bs_fk_approver_gc_project_executive_c.`name_prefix` AS 'bs_fk_approver_gc_project_executive_c__name_prefix',
	bs_fk_approver_gc_project_executive_c.`first_name` AS 'bs_fk_approver_gc_project_executive_c__first_name',
	bs_fk_approver_gc_project_executive_c.`additional_name` AS 'bs_fk_approver_gc_project_executive_c__additional_name',
	bs_fk_approver_gc_project_executive_c.`middle_name` AS 'bs_fk_approver_gc_project_executive_c__middle_name',
	bs_fk_approver_gc_project_executive_c.`last_name` AS 'bs_fk_approver_gc_project_executive_c__last_name',
	bs_fk_approver_gc_project_executive_c.`name_suffix` AS 'bs_fk_approver_gc_project_executive_c__name_suffix',
	bs_fk_approver_gc_project_executive_c.`title` AS 'bs_fk_approver_gc_project_executive_c__title',
	bs_fk_approver_gc_project_executive_c.`vendor_flag` AS 'bs_fk_approver_gc_project_executive_c__vendor_flag',

	bs_fk_unsigned_bs_pdf_fmfiles.`id` AS 'bs_fk_unsigned_bs_pdf_fmfiles__file_manager_file_id',
	bs_fk_unsigned_bs_pdf_fmfiles.`user_company_id` AS 'bs_fk_unsigned_bs_pdf_fmfiles__user_company_id',
	bs_fk_unsigned_bs_pdf_fmfiles.`contact_id` AS 'bs_fk_unsigned_bs_pdf_fmfiles__contact_id',
	bs_fk_unsigned_bs_pdf_fmfiles.`project_id` AS 'bs_fk_unsigned_bs_pdf_fmfiles__project_id',
	bs_fk_unsigned_bs_pdf_fmfiles.`file_manager_folder_id` AS 'bs_fk_unsigned_bs_pdf_fmfiles__file_manager_folder_id',
	bs_fk_unsigned_bs_pdf_fmfiles.`file_location_id` AS 'bs_fk_unsigned_bs_pdf_fmfiles__file_location_id',
	bs_fk_unsigned_bs_pdf_fmfiles.`virtual_file_name` AS 'bs_fk_unsigned_bs_pdf_fmfiles__virtual_file_name',
	bs_fk_unsigned_bs_pdf_fmfiles.`version_number` AS 'bs_fk_unsigned_bs_pdf_fmfiles__version_number',
	bs_fk_unsigned_bs_pdf_fmfiles.`virtual_file_name_sha1` AS 'bs_fk_unsigned_bs_pdf_fmfiles__virtual_file_name_sha1',
	bs_fk_unsigned_bs_pdf_fmfiles.`virtual_file_mime_type` AS 'bs_fk_unsigned_bs_pdf_fmfiles__virtual_file_mime_type',
	bs_fk_unsigned_bs_pdf_fmfiles.`modified` AS 'bs_fk_unsigned_bs_pdf_fmfiles__modified',
	bs_fk_unsigned_bs_pdf_fmfiles.`created` AS 'bs_fk_unsigned_bs_pdf_fmfiles__created',
	bs_fk_unsigned_bs_pdf_fmfiles.`deleted_flag` AS 'bs_fk_unsigned_bs_pdf_fmfiles__deleted_flag',
	bs_fk_unsigned_bs_pdf_fmfiles.`directly_deleted_flag` AS 'bs_fk_unsigned_bs_pdf_fmfiles__directly_deleted_flag',

	bs_fk_signed_bs_pdf_fmfiles.`id` AS 'bs_fk_signed_bs_pdf_fmfiles__file_manager_file_id',
	bs_fk_signed_bs_pdf_fmfiles.`user_company_id` AS 'bs_fk_signed_bs_pdf_fmfiles__user_company_id',
	bs_fk_signed_bs_pdf_fmfiles.`contact_id` AS 'bs_fk_signed_bs_pdf_fmfiles__contact_id',
	bs_fk_signed_bs_pdf_fmfiles.`project_id` AS 'bs_fk_signed_bs_pdf_fmfiles__project_id',
	bs_fk_signed_bs_pdf_fmfiles.`file_manager_folder_id` AS 'bs_fk_signed_bs_pdf_fmfiles__file_manager_folder_id',
	bs_fk_signed_bs_pdf_fmfiles.`file_location_id` AS 'bs_fk_signed_bs_pdf_fmfiles__file_location_id',
	bs_fk_signed_bs_pdf_fmfiles.`virtual_file_name` AS 'bs_fk_signed_bs_pdf_fmfiles__virtual_file_name',
	bs_fk_signed_bs_pdf_fmfiles.`version_number` AS 'bs_fk_signed_bs_pdf_fmfiles__version_number',
	bs_fk_signed_bs_pdf_fmfiles.`virtual_file_name_sha1` AS 'bs_fk_signed_bs_pdf_fmfiles__virtual_file_name_sha1',
	bs_fk_signed_bs_pdf_fmfiles.`virtual_file_mime_type` AS 'bs_fk_signed_bs_pdf_fmfiles__virtual_file_mime_type',
	bs_fk_signed_bs_pdf_fmfiles.`modified` AS 'bs_fk_signed_bs_pdf_fmfiles__modified',
	bs_fk_signed_bs_pdf_fmfiles.`created` AS 'bs_fk_signed_bs_pdf_fmfiles__created',
	bs_fk_signed_bs_pdf_fmfiles.`deleted_flag` AS 'bs_fk_signed_bs_pdf_fmfiles__deleted_flag',
	bs_fk_signed_bs_pdf_fmfiles.`directly_deleted_flag` AS 'bs_fk_signed_bs_pdf_fmfiles__directly_deleted_flag',

	bs_fk_unsigned_bs_xls_fmfiles.`id` AS 'bs_fk_unsigned_bs_xls_fmfiles__file_manager_file_id',
	bs_fk_unsigned_bs_xls_fmfiles.`user_company_id` AS 'bs_fk_unsigned_bs_xls_fmfiles__user_company_id',
	bs_fk_unsigned_bs_xls_fmfiles.`contact_id` AS 'bs_fk_unsigned_bs_xls_fmfiles__contact_id',
	bs_fk_unsigned_bs_xls_fmfiles.`project_id` AS 'bs_fk_unsigned_bs_xls_fmfiles__project_id',
	bs_fk_unsigned_bs_xls_fmfiles.`file_manager_folder_id` AS 'bs_fk_unsigned_bs_xls_fmfiles__file_manager_folder_id',
	bs_fk_unsigned_bs_xls_fmfiles.`file_location_id` AS 'bs_fk_unsigned_bs_xls_fmfiles__file_location_id',
	bs_fk_unsigned_bs_xls_fmfiles.`virtual_file_name` AS 'bs_fk_unsigned_bs_xls_fmfiles__virtual_file_name',
	bs_fk_unsigned_bs_xls_fmfiles.`version_number` AS 'bs_fk_unsigned_bs_xls_fmfiles__version_number',
	bs_fk_unsigned_bs_xls_fmfiles.`virtual_file_name_sha1` AS 'bs_fk_unsigned_bs_xls_fmfiles__virtual_file_name_sha1',
	bs_fk_unsigned_bs_xls_fmfiles.`virtual_file_mime_type` AS 'bs_fk_unsigned_bs_xls_fmfiles__virtual_file_mime_type',
	bs_fk_unsigned_bs_xls_fmfiles.`modified` AS 'bs_fk_unsigned_bs_xls_fmfiles__modified',
	bs_fk_unsigned_bs_xls_fmfiles.`created` AS 'bs_fk_unsigned_bs_xls_fmfiles__created',
	bs_fk_unsigned_bs_xls_fmfiles.`deleted_flag` AS 'bs_fk_unsigned_bs_xls_fmfiles__deleted_flag',
	bs_fk_unsigned_bs_xls_fmfiles.`directly_deleted_flag` AS 'bs_fk_unsigned_bs_xls_fmfiles__directly_deleted_flag',

	bs_fk_signed_bs_xls_fmfiles.`id` AS 'bs_fk_signed_bs_xls_fmfiles__file_manager_file_id',
	bs_fk_signed_bs_xls_fmfiles.`user_company_id` AS 'bs_fk_signed_bs_xls_fmfiles__user_company_id',
	bs_fk_signed_bs_xls_fmfiles.`contact_id` AS 'bs_fk_signed_bs_xls_fmfiles__contact_id',
	bs_fk_signed_bs_xls_fmfiles.`project_id` AS 'bs_fk_signed_bs_xls_fmfiles__project_id',
	bs_fk_signed_bs_xls_fmfiles.`file_manager_folder_id` AS 'bs_fk_signed_bs_xls_fmfiles__file_manager_folder_id',
	bs_fk_signed_bs_xls_fmfiles.`file_location_id` AS 'bs_fk_signed_bs_xls_fmfiles__file_location_id',
	bs_fk_signed_bs_xls_fmfiles.`virtual_file_name` AS 'bs_fk_signed_bs_xls_fmfiles__virtual_file_name',
	bs_fk_signed_bs_xls_fmfiles.`version_number` AS 'bs_fk_signed_bs_xls_fmfiles__version_number',
	bs_fk_signed_bs_xls_fmfiles.`virtual_file_name_sha1` AS 'bs_fk_signed_bs_xls_fmfiles__virtual_file_name_sha1',
	bs_fk_signed_bs_xls_fmfiles.`virtual_file_mime_type` AS 'bs_fk_signed_bs_xls_fmfiles__virtual_file_mime_type',
	bs_fk_signed_bs_xls_fmfiles.`modified` AS 'bs_fk_signed_bs_xls_fmfiles__modified',
	bs_fk_signed_bs_xls_fmfiles.`created` AS 'bs_fk_signed_bs_xls_fmfiles__created',
	bs_fk_signed_bs_xls_fmfiles.`deleted_flag` AS 'bs_fk_signed_bs_xls_fmfiles__deleted_flag',
	bs_fk_signed_bs_xls_fmfiles.`directly_deleted_flag` AS 'bs_fk_signed_bs_xls_fmfiles__directly_deleted_flag',

	bs_fk_unsigned_bs_pdf_fmfiles__fk_fmfolders.`id` AS 'bs_fk_unsigned_bs_pdf_fmfiles__fk_fmfolders__file_manager_folder_id',
	bs_fk_unsigned_bs_pdf_fmfiles__fk_fmfolders.`user_company_id` AS 'bs_fk_unsigned_bs_pdf_fmfiles__fk_fmfolders__user_company_id',
	bs_fk_unsigned_bs_pdf_fmfiles__fk_fmfolders.`contact_id` AS 'bs_fk_unsigned_bs_pdf_fmfiles__fk_fmfolders__contact_id',
	bs_fk_unsigned_bs_pdf_fmfiles__fk_fmfolders.`project_id` AS 'bs_fk_unsigned_bs_pdf_fmfiles__fk_fmfolders__project_id',
	bs_fk_unsigned_bs_pdf_fmfiles__fk_fmfolders.`virtual_file_path` AS 'bs_fk_unsigned_bs_pdf_fmfiles__fk_fmfolders__virtual_file_path',
	bs_fk_unsigned_bs_pdf_fmfiles__fk_fmfolders.`virtual_file_path_sha1` AS 'bs_fk_unsigned_bs_pdf_fmfiles__fk_fmfolders__virtual_file_path_sha1',
	bs_fk_unsigned_bs_pdf_fmfiles__fk_fmfolders.`modified` AS 'bs_fk_unsigned_bs_pdf_fmfiles__fk_fmfolders__modified',
	bs_fk_unsigned_bs_pdf_fmfiles__fk_fmfolders.`created` AS 'bs_fk_unsigned_bs_pdf_fmfiles__fk_fmfolders__created',
	bs_fk_unsigned_bs_pdf_fmfiles__fk_fmfolders.`deleted_flag` AS 'bs_fk_unsigned_bs_pdf_fmfiles__fk_fmfolders__deleted_flag',
	bs_fk_unsigned_bs_pdf_fmfiles__fk_fmfolders.`directly_deleted_flag` AS 'bs_fk_unsigned_bs_pdf_fmfiles__fk_fmfolders__directly_deleted_flag',

	bs_fk_signed_bs_pdf_fmfiles__fk_fmfolders.`id` AS 'bs_fk_signed_bs_pdf_fmfiles__fk_fmfolders__file_manager_folder_id',
	bs_fk_signed_bs_pdf_fmfiles__fk_fmfolders.`user_company_id` AS 'bs_fk_signed_bs_pdf_fmfiles__fk_fmfolders__user_company_id',
	bs_fk_signed_bs_pdf_fmfiles__fk_fmfolders.`contact_id` AS 'bs_fk_signed_bs_pdf_fmfiles__fk_fmfolders__contact_id',
	bs_fk_signed_bs_pdf_fmfiles__fk_fmfolders.`project_id` AS 'bs_fk_signed_bs_pdf_fmfiles__fk_fmfolders__project_id',
	bs_fk_signed_bs_pdf_fmfiles__fk_fmfolders.`virtual_file_path` AS 'bs_fk_signed_bs_pdf_fmfiles__fk_fmfolders__virtual_file_path',
	bs_fk_signed_bs_pdf_fmfiles__fk_fmfolders.`virtual_file_path_sha1` AS 'bs_fk_signed_bs_pdf_fmfiles__fk_fmfolders__virtual_file_path_sha1',
	bs_fk_signed_bs_pdf_fmfiles__fk_fmfolders.`modified` AS 'bs_fk_signed_bs_pdf_fmfiles__fk_fmfolders__modified',
	bs_fk_signed_bs_pdf_fmfiles__fk_fmfolders.`created` AS 'bs_fk_signed_bs_pdf_fmfiles__fk_fmfolders__created',
	bs_fk_signed_bs_pdf_fmfiles__fk_fmfolders.`deleted_flag` AS 'bs_fk_signed_bs_pdf_fmfiles__fk_fmfolders__deleted_flag',
	bs_fk_signed_bs_pdf_fmfiles__fk_fmfolders.`directly_deleted_flag` AS 'bs_fk_signed_bs_pdf_fmfiles__fk_fmfolders__directly_deleted_flag',

	bs_fk_unsigned_bs_xls_fmfiles__fk_fmfolders.`id` AS 'bs_fk_unsigned_bs_xls_fmfiles__fk_fmfolders__file_manager_folder_id',
	bs_fk_unsigned_bs_xls_fmfiles__fk_fmfolders.`user_company_id` AS 'bs_fk_unsigned_bs_xls_fmfiles__fk_fmfolders__user_company_id',
	bs_fk_unsigned_bs_xls_fmfiles__fk_fmfolders.`contact_id` AS 'bs_fk_unsigned_bs_xls_fmfiles__fk_fmfolders__contact_id',
	bs_fk_unsigned_bs_xls_fmfiles__fk_fmfolders.`project_id` AS 'bs_fk_unsigned_bs_xls_fmfiles__fk_fmfolders__project_id',
	bs_fk_unsigned_bs_xls_fmfiles__fk_fmfolders.`virtual_file_path` AS 'bs_fk_unsigned_bs_xls_fmfiles__fk_fmfolders__virtual_file_path',
	bs_fk_unsigned_bs_xls_fmfiles__fk_fmfolders.`virtual_file_path_sha1` AS 'bs_fk_unsigned_bs_xls_fmfiles__fk_fmfolders__virtual_file_path_sha1',
	bs_fk_unsigned_bs_xls_fmfiles__fk_fmfolders.`modified` AS 'bs_fk_unsigned_bs_xls_fmfiles__fk_fmfolders__modified',
	bs_fk_unsigned_bs_xls_fmfiles__fk_fmfolders.`created` AS 'bs_fk_unsigned_bs_xls_fmfiles__fk_fmfolders__created',
	bs_fk_unsigned_bs_xls_fmfiles__fk_fmfolders.`deleted_flag` AS 'bs_fk_unsigned_bs_xls_fmfiles__fk_fmfolders__deleted_flag',
	bs_fk_unsigned_bs_xls_fmfiles__fk_fmfolders.`directly_deleted_flag` AS 'bs_fk_unsigned_bs_xls_fmfiles__fk_fmfolders__directly_deleted_flag',

	bs_fk_signed_bs_xls_fmfiles__fk_fmfolders.`id` AS 'bs_fk_signed_bs_xls_fmfiles__fk_fmfolders__file_manager_folder_id',
	bs_fk_signed_bs_xls_fmfiles__fk_fmfolders.`user_company_id` AS 'bs_fk_signed_bs_xls_fmfiles__fk_fmfolders__user_company_id',
	bs_fk_signed_bs_xls_fmfiles__fk_fmfolders.`contact_id` AS 'bs_fk_signed_bs_xls_fmfiles__fk_fmfolders__contact_id',
	bs_fk_signed_bs_xls_fmfiles__fk_fmfolders.`project_id` AS 'bs_fk_signed_bs_xls_fmfiles__fk_fmfolders__project_id',
	bs_fk_signed_bs_xls_fmfiles__fk_fmfolders.`virtual_file_path` AS 'bs_fk_signed_bs_xls_fmfiles__fk_fmfolders__virtual_file_path',
	bs_fk_signed_bs_xls_fmfiles__fk_fmfolders.`virtual_file_path_sha1` AS 'bs_fk_signed_bs_xls_fmfiles__fk_fmfolders__virtual_file_path_sha1',
	bs_fk_signed_bs_xls_fmfiles__fk_fmfolders.`modified` AS 'bs_fk_signed_bs_xls_fmfiles__fk_fmfolders__modified',
	bs_fk_signed_bs_xls_fmfiles__fk_fmfolders.`created` AS 'bs_fk_signed_bs_xls_fmfiles__fk_fmfolders__created',
	bs_fk_signed_bs_xls_fmfiles__fk_fmfolders.`deleted_flag` AS 'bs_fk_signed_bs_xls_fmfiles__fk_fmfolders__deleted_flag',
	bs_fk_signed_bs_xls_fmfiles__fk_fmfolders.`directly_deleted_flag` AS 'bs_fk_signed_bs_xls_fmfiles__fk_fmfolders__directly_deleted_flag',

	bs.*

FROM `bid_spreads` bs
	INNER JOIN `gc_budget_line_items` bs_fk_gbli ON bs.`gc_budget_line_item_id` = bs_fk_gbli.`id`
	INNER JOIN `bid_spread_statuses` bs_fk_bss ON bs.`bid_spread_status_id` = bs_fk_bss.`id`
	LEFT OUTER JOIN `contacts` bs_fk_submitter_gc_project_manager_c ON bs.`bid_spread_submitter_gc_project_manager_contact_id` = bs_fk_submitter_gc_project_manager_c.`id`
	LEFT OUTER JOIN `contacts` bs_fk_approver_gc_project_executive_c ON bs.`bid_spread_approver_gc_project_executive_contact_id` = bs_fk_approver_gc_project_executive_c.`id`
	LEFT OUTER JOIN `file_manager_files` bs_fk_unsigned_bs_pdf_fmfiles ON bs.`unsigned_bid_spread_pdf_file_manager_file_id` = bs_fk_unsigned_bs_pdf_fmfiles.`id`
	LEFT OUTER JOIN `file_manager_files` bs_fk_signed_bs_pdf_fmfiles ON bs.`signed_bid_spread_pdf_file_manager_file_id` = bs_fk_signed_bs_pdf_fmfiles.`id`
	LEFT OUTER JOIN `file_manager_files` bs_fk_unsigned_bs_xls_fmfiles ON bs.`unsigned_bid_spread_xls_file_manager_file_id` = bs_fk_unsigned_bs_xls_fmfiles.`id`
	LEFT OUTER JOIN `file_manager_files` bs_fk_signed_bs_xls_fmfiles ON bs.`signed_bid_spread_xls_file_manager_file_id` = bs_fk_signed_bs_xls_fmfiles.`id`

	LEFT OUTER JOIN `file_manager_folders` bs_fk_unsigned_bs_pdf_fmfiles__fk_fmfolders ON bs_fk_unsigned_bs_pdf_fmfiles.`file_manager_folder_id` = bs_fk_unsigned_bs_pdf_fmfiles__fk_fmfolders.`id`
	LEFT OUTER JOIN `file_manager_folders` bs_fk_signed_bs_pdf_fmfiles__fk_fmfolders ON bs_fk_signed_bs_pdf_fmfiles.`file_manager_folder_id` = bs_fk_signed_bs_pdf_fmfiles__fk_fmfolders.`id`
	LEFT OUTER JOIN `file_manager_folders` bs_fk_unsigned_bs_xls_fmfiles__fk_fmfolders ON bs_fk_unsigned_bs_xls_fmfiles.`file_manager_folder_id` = bs_fk_unsigned_bs_xls_fmfiles__fk_fmfolders.`id`
	LEFT OUTER JOIN `file_manager_folders` bs_fk_signed_bs_xls_fmfiles__fk_fmfolders ON bs_fk_signed_bs_xls_fmfiles.`file_manager_folder_id` = bs_fk_signed_bs_xls_fmfiles__fk_fmfolders.`id`
WHERE bs.`id` = ?
";
		$arrValues = array($bid_spread_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$bid_spread_id = $row['id'];
			$bidSpread = self::instantiateOrm($database, 'BidSpread', $row, null, $bid_spread_id);
			/* @var $bidSpread BidSpread */
			$bidSpread->convertPropertiesToData();

			if (isset($row['gc_budget_line_item_id'])) {
				$gc_budget_line_item_id = $row['gc_budget_line_item_id'];
				$row['bs_fk_gbli__id'] = $gc_budget_line_item_id;
				$gcBudgetLineItem = self::instantiateOrm($database, 'GcBudgetLineItem', $row, null, $gc_budget_line_item_id, 'bs_fk_gbli__');
				/* @var $gcBudgetLineItem GcBudgetLineItem */
				$gcBudgetLineItem->convertPropertiesToData();
			} else {
				$gcBudgetLineItem = false;
			}
			$bidSpread->setGcBudgetLineItem($gcBudgetLineItem);

			if (isset($row['bid_spread_status_id'])) {
				$bid_spread_status_id = $row['bid_spread_status_id'];
				$row['bs_fk_bss__id'] = $bid_spread_status_id;
				$bidSpreadStatus = self::instantiateOrm($database, 'BidSpreadStatus', $row, null, $bid_spread_status_id, 'bs_fk_bss__');
				/* @var $bidSpreadStatus BidSpreadStatus */
				$bidSpreadStatus->convertPropertiesToData();
			} else {
				$bidSpreadStatus = false;
			}
			$bidSpread->setBidSpreadStatus($bidSpreadStatus);

			if (isset($row['bid_spread_submitter_gc_project_manager_contact_id'])) {
				$bid_spread_submitter_gc_project_manager_contact_id = $row['bid_spread_submitter_gc_project_manager_contact_id'];
				$row['bs_fk_submitter_gc_project_manager_c__id'] = $bid_spread_submitter_gc_project_manager_contact_id;
				$bidSpreadSubmitterGcProjectManagerContact = self::instantiateOrm($database, 'Contact', $row, null, $bid_spread_submitter_gc_project_manager_contact_id, 'bs_fk_submitter_gc_project_manager_c__');
				/* @var $bidSpreadSubmitterGcProjectManagerContact Contact */
				$bidSpreadSubmitterGcProjectManagerContact->convertPropertiesToData();
			} else {
				$bidSpreadSubmitterGcProjectManagerContact = false;
			}
			$bidSpread->setBidSpreadSubmitterGcProjectManagerContact($bidSpreadSubmitterGcProjectManagerContact);

			if (isset($row['bid_spread_approver_gc_project_executive_contact_id'])) {
				$bid_spread_approver_gc_project_executive_contact_id = $row['bid_spread_approver_gc_project_executive_contact_id'];
				$row['bs_fk_approver_gc_project_executive_c__id'] = $bid_spread_approver_gc_project_executive_contact_id;
				$bidSpreadApproverGcProjectExecutiveContact = self::instantiateOrm($database, 'Contact', $row, null, $bid_spread_approver_gc_project_executive_contact_id, 'bs_fk_approver_gc_project_executive_c__');
				/* @var $bidSpreadApproverGcProjectExecutiveContact Contact */
				$bidSpreadApproverGcProjectExecutiveContact->convertPropertiesToData();
			} else {
				$bidSpreadApproverGcProjectExecutiveContact = false;
			}
			$bidSpread->setBidSpreadApproverGcProjectExecutiveContact($bidSpreadApproverGcProjectExecutiveContact);

			// LEFT OUTER JOIN `file_manager_files` bs_fk_unsigned_bs_pdf_fmfiles ON bs.`unsigned_bid_spread_pdf_file_manager_file_id` = bs_fk_unsigned_bs_pdf_fmfiles.`id`
			if (isset($row['unsigned_bid_spread_pdf_file_manager_file_id'])) {
				$unsigned_bid_spread_pdf_file_manager_file_id = $row['unsigned_bid_spread_pdf_file_manager_file_id'];
				$row['bs_fk_unsigned_bs_pdf_fmfiles__id'] = $unsigned_bid_spread_pdf_file_manager_file_id;
				$unsignedBidSpreadPdfFileManagerFile = self::instantiateOrm($database, 'FileManagerFile', $row, null, $unsigned_bid_spread_pdf_file_manager_file_id, 'bs_fk_unsigned_bs_pdf_fmfiles__');
				/* @var $unsignedBidSpreadPdfFileManagerFile FileManagerFile */
				$unsignedBidSpreadPdfFileManagerFile->convertPropertiesToData();
			} else {
				$unsignedBidSpreadPdfFileManagerFile = false;
			}
			$bidSpread->setUnsignedBidSpreadPdfFileManagerFile($unsignedBidSpreadPdfFileManagerFile);

			// LEFT OUTER JOIN `file_manager_files` bs_fk_signed_bs_pdf_fmfiles ON bs.`signed_bid_spread_pdf_file_manager_file_id` = bs_fk_signed_bs_pdf_fmfiles.`id`
			if (isset($row['signed_bid_spread_pdf_file_manager_file_id'])) {
				$signed_bid_spread_pdf_file_manager_file_id = $row['signed_bid_spread_pdf_file_manager_file_id'];
				$row['bs_fk_signed_bs_pdf_fmfiles__id'] = $signed_bid_spread_pdf_file_manager_file_id;
				$signedBidSpreadPdfFileManagerFile = self::instantiateOrm($database, 'FileManagerFile', $row, null, $signed_bid_spread_pdf_file_manager_file_id, 'bs_fk_signed_bs_pdf_fmfiles__');
				/* @var $signedBidSpreadPdfFileManagerFile FileManagerFile */
				$signedBidSpreadPdfFileManagerFile->convertPropertiesToData();
			} else {
				$signedBidSpreadPdfFileManagerFile = false;
			}
			$bidSpread->setSignedBidSpreadPdfFileManagerFile($signedBidSpreadPdfFileManagerFile);

			// LEFT OUTER JOIN `file_manager_files` bs_fk_unsigned_bs_xls_fmfiles ON bs.`unsigned_bid_spread_xls_file_manager_file_id` = bs_fk_unsigned_bs_xls_fmfiles.`id`
			if (isset($row['unsigned_bid_spread_xls_file_manager_file_id'])) {
				$unsigned_bid_spread_xls_file_manager_file_id = $row['unsigned_bid_spread_xls_file_manager_file_id'];
				$row['bs_fk_unsigned_bs_xls_fmfiles__id'] = $unsigned_bid_spread_xls_file_manager_file_id;
				$unsignedBidSpreadXlsFileManagerFile = self::instantiateOrm($database, 'FileManagerFile', $row, null, $unsigned_bid_spread_xls_file_manager_file_id, 'bs_fk_unsigned_bs_xls_fmfiles__');
				/* @var $unsignedBidSpreadXlsFileManagerFile FileManagerFile */
				$unsignedBidSpreadXlsFileManagerFile->convertPropertiesToData();
			} else {
				$unsignedBidSpreadXlsFileManagerFile = false;
			}
			$bidSpread->setUnsignedBidSpreadXlsFileManagerFile($unsignedBidSpreadXlsFileManagerFile);

			// LEFT OUTER JOIN `file_manager_files` bs_fk_signed_bs_xls_fmfiles ON bs.`signed_bid_spread_xls_file_manager_file_id` = bs_fk_signed_bs_xls_fmfiles.`id`
			if (isset($row['signed_bid_spread_xls_file_manager_file_id'])) {
				$signed_bid_spread_xls_file_manager_file_id = $row['signed_bid_spread_xls_file_manager_file_id'];
				$row['bs_fk_signed_bs_xls_fmfiles__id'] = $signed_bid_spread_xls_file_manager_file_id;
				$signedBidSpreadXlsFileManagerFile = self::instantiateOrm($database, 'FileManagerFile', $row, null, $signed_bid_spread_xls_file_manager_file_id, 'bs_fk_signed_bs_xls_fmfiles__');
				/* @var $signedBidSpreadXlsFileManagerFile FileManagerFile */
				$signedBidSpreadXlsFileManagerFile->convertPropertiesToData();
			} else {
				$signedBidSpreadXlsFileManagerFile = false;
			}
			$bidSpread->setSignedBidSpreadXlsFileManagerFile($signedBidSpreadXlsFileManagerFile);

			// LEFT OUTER JOIN `file_manager_folders` bs_fk_unsigned_bs_pdf_fmfiles__fk_fmfolders ON bs_fk_unsigned_bs_pdf_fmfiles.`file_manager_folder_id` = bs_fk_unsigned_bs_pdf_fmfiles__fk_fmfolders.`id`
			if (isset($row['bs_fk_unsigned_bs_pdf_fmfiles__fk_fmfolders__file_manager_folder_id'])) {
				$file_manager_folder_id = $row['bs_fk_unsigned_bs_pdf_fmfiles__fk_fmfolders__file_manager_folder_id'];
				$row['bs_fk_unsigned_bs_pdf_fmfiles__fk_fmfolders__id'] = $file_manager_folder_id;
				$unsignedBidSpreadPdfFileManagerFolder = self::instantiateOrm($database, 'FileManagerFolder', $row, null, $file_manager_folder_id, 'bs_fk_unsigned_bs_pdf_fmfiles__fk_fmfolders__');
				/* @var $unsignedBidSpreadPdfFileManagerFolder FileManagerFolder */
				$unsignedBidSpreadPdfFileManagerFolder->convertPropertiesToData();
			} else {
				$unsignedBidSpreadPdfFileManagerFolder = false;
			}
			$bidSpread->setUnsignedBidSpreadPdfFileManagerFolder($unsignedBidSpreadPdfFileManagerFolder);

			// LEFT OUTER JOIN `file_manager_folders` bs_fk_signed_bs_pdf_fmfiles__fk_fmfolders ON bs_fk_signed_bs_pdf_fmfiles.`file_manager_folder_id` = bs_fk_signed_bs_pdf_fmfiles__fk_fmfolders.`id`
			if (isset($row['bs_fk_signed_bs_pdf_fmfiles__fk_fmfolders__file_manager_folder_id'])) {
				$file_manager_folder_id = $row['bs_fk_signed_bs_pdf_fmfiles__fk_fmfolders__file_manager_folder_id'];
				$row['bs_fk_signed_bs_pdf_fmfiles__fk_fmfolders__id'] = $file_manager_folder_id;
				$signedBidSpreadPdfFileManagerFolder = self::instantiateOrm($database, 'FileManagerFolder', $row, null, $file_manager_folder_id, 'bs_fk_signed_bs_pdf_fmfiles__fk_fmfolders__');
				/* @var $signedBidSpreadPdfFileManagerFolder FileManagerFolder */
				$signedBidSpreadPdfFileManagerFolder->convertPropertiesToData();
			} else {
				$signedBidSpreadPdfFileManagerFolder = false;
			}
			$bidSpread->setSignedBidSpreadPdfFileManagerFolder($signedBidSpreadPdfFileManagerFolder);

			// LEFT OUTER JOIN `file_manager_folders` bs_fk_unsigned_bs_xls_fmfiles__fk_fmfolders ON bs_fk_unsigned_bs_xls_fmfiles.`file_manager_folder_id` = bs_fk_unsigned_bs_xls_fmfiles__fk_fmfolders.`id`
			if (isset($row['bs_fk_unsigned_bs_xls_fmfiles__fk_fmfolders__file_manager_folder_id'])) {
				$file_manager_folder_id = $row['bs_fk_unsigned_bs_xls_fmfiles__fk_fmfolders__file_manager_folder_id'];
				$row['bs_fk_unsigned_bs_xls_fmfiles__fk_fmfolders__id'] = $file_manager_folder_id;
				$unsignedBidSpreadXlsFileManagerFolder = self::instantiateOrm($database, 'FileManagerFolder', $row, null, $file_manager_folder_id, 'bs_fk_unsigned_bs_xls_fmfiles__fk_fmfolders__');
				/* @var $unsignedBidSpreadXlsFileManagerFolder FileManagerFolder */
				$unsignedBidSpreadXlsFileManagerFolder->convertPropertiesToData();
			} else {
				$unsignedBidSpreadXlsFileManagerFolder = false;
			}
			$bidSpread->setUnsignedBidSpreadXlsFileManagerFolder($unsignedBidSpreadXlsFileManagerFolder);

			// LEFT OUTER JOIN `file_manager_folders` bs_fk_signed_bs_xls_fmfiles__fk_fmfolders ON bs_fk_signed_bs_xls_fmfiles.`file_manager_folder_id` = bs_fk_signed_bs_xls_fmfiles__fk_fmfolders.`id`
			if (isset($row['bs_fk_signed_bs_xls_fmfiles__fk_fmfolders__file_manager_folder_id'])) {
				$file_manager_folder_id = $row['bs_fk_signed_bs_xls_fmfiles__fk_fmfolders__file_manager_folder_id'];
				$row['bs_fk_signed_bs_xls_fmfiles__fk_fmfolders__id'] = $file_manager_folder_id;
				$signedBidSpreadXlsFileManagerFolder = self::instantiateOrm($database, 'FileManagerFolder', $row, null, $file_manager_folder_id, 'bs_fk_signed_bs_xls_fmfiles__fk_fmfolders__');
				/* @var $signedBidSpreadXlsFileManagerFolder FileManagerFolder */
				$signedBidSpreadXlsFileManagerFolder->convertPropertiesToData();
			} else {
				$signedBidSpreadXlsFileManagerFolder = false;
			}
			$bidSpread->setSignedBidSpreadXlsFileManagerFolder($signedBidSpreadXlsFileManagerFolder);

			return $bidSpread;
		} else {
			return false;
		}
	}

	// Finders: Find By Unique Index
	/**
	 * Find by unique index `unique_bid_spread` (`gc_budget_line_item_id`,`bid_spread_sequence_number`).
	 *
	 * @param string $database
	 * @param int $gc_budget_line_item_id
	 * @param int $bid_spread_sequence_number
	 * @return mixed (single ORM object | false)
	 */
	public static function findByGcBudgetLineItemIdAndBidSpreadSequenceNumber($database, $gc_budget_line_item_id, $bid_spread_sequence_number)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	bs.*

FROM `bid_spreads` bs
WHERE bs.`gc_budget_line_item_id` = ?
AND bs.`bid_spread_sequence_number` = ?
";
		$arrValues = array($gc_budget_line_item_id, $bid_spread_sequence_number);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if ($row && !empty($row)) {
			$bid_spread_id = $row['id'];
			$bidSpread = self::instantiateOrm($database, 'BidSpread', $row, null, $bid_spread_id);
			/* @var $bidSpread BidSpread */
			return $bidSpread;
		} else {
			return false;
		}
	}

	/**
	 * Find by unique index `unique_bid_spread_by_sha1` (`bid_spreadsheet_data_sha1`).
	 *
	 * @param string $database
	 * @param string $bid_spreadsheet_data_sha1
	 * @return mixed (single ORM object | false)
	 */
	public static function findByBidSpreadsheetDataSha1($database, $bid_spreadsheet_data_sha1)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	bs_fk_gbli.`id` AS 'bs_fk_gbli__gc_budget_line_item_id',
	bs_fk_gbli.`user_company_id` AS 'bs_fk_gbli__user_company_id',
	bs_fk_gbli.`project_id` AS 'bs_fk_gbli__project_id',
	bs_fk_gbli.`cost_code_id` AS 'bs_fk_gbli__cost_code_id',
	bs_fk_gbli.`modified` AS 'bs_fk_gbli__modified',
	bs_fk_gbli.`prime_contract_scheduled_value` AS 'bs_fk_gbli__prime_contract_scheduled_value',
	bs_fk_gbli.`forecasted_expenses` AS 'bs_fk_gbli__forecasted_expenses',
	bs_fk_gbli.`created` AS 'bs_fk_gbli__created',
	bs_fk_gbli.`sort_order` AS 'bs_fk_gbli__sort_order',
	bs_fk_gbli.`disabled_flag` AS 'bs_fk_gbli__disabled_flag',

	bs_fk_bss.`id` AS 'bs_fk_bss__bid_spread_status_id',
	bs_fk_bss.`bid_spread_status` AS 'bs_fk_bss__bid_spread_status',
	bs_fk_bss.`bid_spread_status_action_label` AS 'bs_fk_bss__bid_spread_status_action_label',
	bs_fk_bss.`sort_order` AS 'bs_fk_bss__sort_order',

	bs_fk_submitter_gc_project_manager_c.`id` AS 'bs_fk_submitter_gc_project_manager_c__contact_id',
	bs_fk_submitter_gc_project_manager_c.`user_company_id` AS 'bs_fk_submitter_gc_project_manager_c__user_company_id',
	bs_fk_submitter_gc_project_manager_c.`user_id` AS 'bs_fk_submitter_gc_project_manager_c__user_id',
	bs_fk_submitter_gc_project_manager_c.`contact_company_id` AS 'bs_fk_submitter_gc_project_manager_c__contact_company_id',
	bs_fk_submitter_gc_project_manager_c.`email` AS 'bs_fk_submitter_gc_project_manager_c__email',
	bs_fk_submitter_gc_project_manager_c.`name_prefix` AS 'bs_fk_submitter_gc_project_manager_c__name_prefix',
	bs_fk_submitter_gc_project_manager_c.`first_name` AS 'bs_fk_submitter_gc_project_manager_c__first_name',
	bs_fk_submitter_gc_project_manager_c.`additional_name` AS 'bs_fk_submitter_gc_project_manager_c__additional_name',
	bs_fk_submitter_gc_project_manager_c.`middle_name` AS 'bs_fk_submitter_gc_project_manager_c__middle_name',
	bs_fk_submitter_gc_project_manager_c.`last_name` AS 'bs_fk_submitter_gc_project_manager_c__last_name',
	bs_fk_submitter_gc_project_manager_c.`name_suffix` AS 'bs_fk_submitter_gc_project_manager_c__name_suffix',
	bs_fk_submitter_gc_project_manager_c.`title` AS 'bs_fk_submitter_gc_project_manager_c__title',
	bs_fk_submitter_gc_project_manager_c.`vendor_flag` AS 'bs_fk_submitter_gc_project_manager_c__vendor_flag',

	bs_fk_approver_gc_project_executive_c.`id` AS 'bs_fk_approver_gc_project_executive_c__contact_id',
	bs_fk_approver_gc_project_executive_c.`user_company_id` AS 'bs_fk_approver_gc_project_executive_c__user_company_id',
	bs_fk_approver_gc_project_executive_c.`user_id` AS 'bs_fk_approver_gc_project_executive_c__user_id',
	bs_fk_approver_gc_project_executive_c.`contact_company_id` AS 'bs_fk_approver_gc_project_executive_c__contact_company_id',
	bs_fk_approver_gc_project_executive_c.`email` AS 'bs_fk_approver_gc_project_executive_c__email',
	bs_fk_approver_gc_project_executive_c.`name_prefix` AS 'bs_fk_approver_gc_project_executive_c__name_prefix',
	bs_fk_approver_gc_project_executive_c.`first_name` AS 'bs_fk_approver_gc_project_executive_c__first_name',
	bs_fk_approver_gc_project_executive_c.`additional_name` AS 'bs_fk_approver_gc_project_executive_c__additional_name',
	bs_fk_approver_gc_project_executive_c.`middle_name` AS 'bs_fk_approver_gc_project_executive_c__middle_name',
	bs_fk_approver_gc_project_executive_c.`last_name` AS 'bs_fk_approver_gc_project_executive_c__last_name',
	bs_fk_approver_gc_project_executive_c.`name_suffix` AS 'bs_fk_approver_gc_project_executive_c__name_suffix',
	bs_fk_approver_gc_project_executive_c.`title` AS 'bs_fk_approver_gc_project_executive_c__title',
	bs_fk_approver_gc_project_executive_c.`vendor_flag` AS 'bs_fk_approver_gc_project_executive_c__vendor_flag',

	bs_fk_unsigned_bs_pdf_fmfiles.`id` AS 'bs_fk_unsigned_bs_pdf_fmfiles__file_manager_file_id',
	bs_fk_unsigned_bs_pdf_fmfiles.`user_company_id` AS 'bs_fk_unsigned_bs_pdf_fmfiles__user_company_id',
	bs_fk_unsigned_bs_pdf_fmfiles.`contact_id` AS 'bs_fk_unsigned_bs_pdf_fmfiles__contact_id',
	bs_fk_unsigned_bs_pdf_fmfiles.`project_id` AS 'bs_fk_unsigned_bs_pdf_fmfiles__project_id',
	bs_fk_unsigned_bs_pdf_fmfiles.`file_manager_folder_id` AS 'bs_fk_unsigned_bs_pdf_fmfiles__file_manager_folder_id',
	bs_fk_unsigned_bs_pdf_fmfiles.`file_location_id` AS 'bs_fk_unsigned_bs_pdf_fmfiles__file_location_id',
	bs_fk_unsigned_bs_pdf_fmfiles.`virtual_file_name` AS 'bs_fk_unsigned_bs_pdf_fmfiles__virtual_file_name',
	bs_fk_unsigned_bs_pdf_fmfiles.`version_number` AS 'bs_fk_unsigned_bs_pdf_fmfiles__version_number',
	bs_fk_unsigned_bs_pdf_fmfiles.`virtual_file_name_sha1` AS 'bs_fk_unsigned_bs_pdf_fmfiles__virtual_file_name_sha1',
	bs_fk_unsigned_bs_pdf_fmfiles.`virtual_file_mime_type` AS 'bs_fk_unsigned_bs_pdf_fmfiles__virtual_file_mime_type',
	bs_fk_unsigned_bs_pdf_fmfiles.`modified` AS 'bs_fk_unsigned_bs_pdf_fmfiles__modified',
	bs_fk_unsigned_bs_pdf_fmfiles.`created` AS 'bs_fk_unsigned_bs_pdf_fmfiles__created',
	bs_fk_unsigned_bs_pdf_fmfiles.`deleted_flag` AS 'bs_fk_unsigned_bs_pdf_fmfiles__deleted_flag',
	bs_fk_unsigned_bs_pdf_fmfiles.`directly_deleted_flag` AS 'bs_fk_unsigned_bs_pdf_fmfiles__directly_deleted_flag',

	bs_fk_signed_bs_pdf_fmfiles.`id` AS 'bs_fk_signed_bs_pdf_fmfiles__file_manager_file_id',
	bs_fk_signed_bs_pdf_fmfiles.`user_company_id` AS 'bs_fk_signed_bs_pdf_fmfiles__user_company_id',
	bs_fk_signed_bs_pdf_fmfiles.`contact_id` AS 'bs_fk_signed_bs_pdf_fmfiles__contact_id',
	bs_fk_signed_bs_pdf_fmfiles.`project_id` AS 'bs_fk_signed_bs_pdf_fmfiles__project_id',
	bs_fk_signed_bs_pdf_fmfiles.`file_manager_folder_id` AS 'bs_fk_signed_bs_pdf_fmfiles__file_manager_folder_id',
	bs_fk_signed_bs_pdf_fmfiles.`file_location_id` AS 'bs_fk_signed_bs_pdf_fmfiles__file_location_id',
	bs_fk_signed_bs_pdf_fmfiles.`virtual_file_name` AS 'bs_fk_signed_bs_pdf_fmfiles__virtual_file_name',
	bs_fk_signed_bs_pdf_fmfiles.`version_number` AS 'bs_fk_signed_bs_pdf_fmfiles__version_number',
	bs_fk_signed_bs_pdf_fmfiles.`virtual_file_name_sha1` AS 'bs_fk_signed_bs_pdf_fmfiles__virtual_file_name_sha1',
	bs_fk_signed_bs_pdf_fmfiles.`virtual_file_mime_type` AS 'bs_fk_signed_bs_pdf_fmfiles__virtual_file_mime_type',
	bs_fk_signed_bs_pdf_fmfiles.`modified` AS 'bs_fk_signed_bs_pdf_fmfiles__modified',
	bs_fk_signed_bs_pdf_fmfiles.`created` AS 'bs_fk_signed_bs_pdf_fmfiles__created',
	bs_fk_signed_bs_pdf_fmfiles.`deleted_flag` AS 'bs_fk_signed_bs_pdf_fmfiles__deleted_flag',
	bs_fk_signed_bs_pdf_fmfiles.`directly_deleted_flag` AS 'bs_fk_signed_bs_pdf_fmfiles__directly_deleted_flag',

	bs_fk_unsigned_bs_xls_fmfiles.`id` AS 'bs_fk_unsigned_bs_xls_fmfiles__file_manager_file_id',
	bs_fk_unsigned_bs_xls_fmfiles.`user_company_id` AS 'bs_fk_unsigned_bs_xls_fmfiles__user_company_id',
	bs_fk_unsigned_bs_xls_fmfiles.`contact_id` AS 'bs_fk_unsigned_bs_xls_fmfiles__contact_id',
	bs_fk_unsigned_bs_xls_fmfiles.`project_id` AS 'bs_fk_unsigned_bs_xls_fmfiles__project_id',
	bs_fk_unsigned_bs_xls_fmfiles.`file_manager_folder_id` AS 'bs_fk_unsigned_bs_xls_fmfiles__file_manager_folder_id',
	bs_fk_unsigned_bs_xls_fmfiles.`file_location_id` AS 'bs_fk_unsigned_bs_xls_fmfiles__file_location_id',
	bs_fk_unsigned_bs_xls_fmfiles.`virtual_file_name` AS 'bs_fk_unsigned_bs_xls_fmfiles__virtual_file_name',
	bs_fk_unsigned_bs_xls_fmfiles.`version_number` AS 'bs_fk_unsigned_bs_xls_fmfiles__version_number',
	bs_fk_unsigned_bs_xls_fmfiles.`virtual_file_name_sha1` AS 'bs_fk_unsigned_bs_xls_fmfiles__virtual_file_name_sha1',
	bs_fk_unsigned_bs_xls_fmfiles.`virtual_file_mime_type` AS 'bs_fk_unsigned_bs_xls_fmfiles__virtual_file_mime_type',
	bs_fk_unsigned_bs_xls_fmfiles.`modified` AS 'bs_fk_unsigned_bs_xls_fmfiles__modified',
	bs_fk_unsigned_bs_xls_fmfiles.`created` AS 'bs_fk_unsigned_bs_xls_fmfiles__created',
	bs_fk_unsigned_bs_xls_fmfiles.`deleted_flag` AS 'bs_fk_unsigned_bs_xls_fmfiles__deleted_flag',
	bs_fk_unsigned_bs_xls_fmfiles.`directly_deleted_flag` AS 'bs_fk_unsigned_bs_xls_fmfiles__directly_deleted_flag',

	bs_fk_signed_bs_xls_fmfiles.`id` AS 'bs_fk_signed_bs_xls_fmfiles__file_manager_file_id',
	bs_fk_signed_bs_xls_fmfiles.`user_company_id` AS 'bs_fk_signed_bs_xls_fmfiles__user_company_id',
	bs_fk_signed_bs_xls_fmfiles.`contact_id` AS 'bs_fk_signed_bs_xls_fmfiles__contact_id',
	bs_fk_signed_bs_xls_fmfiles.`project_id` AS 'bs_fk_signed_bs_xls_fmfiles__project_id',
	bs_fk_signed_bs_xls_fmfiles.`file_manager_folder_id` AS 'bs_fk_signed_bs_xls_fmfiles__file_manager_folder_id',
	bs_fk_signed_bs_xls_fmfiles.`file_location_id` AS 'bs_fk_signed_bs_xls_fmfiles__file_location_id',
	bs_fk_signed_bs_xls_fmfiles.`virtual_file_name` AS 'bs_fk_signed_bs_xls_fmfiles__virtual_file_name',
	bs_fk_signed_bs_xls_fmfiles.`version_number` AS 'bs_fk_signed_bs_xls_fmfiles__version_number',
	bs_fk_signed_bs_xls_fmfiles.`virtual_file_name_sha1` AS 'bs_fk_signed_bs_xls_fmfiles__virtual_file_name_sha1',
	bs_fk_signed_bs_xls_fmfiles.`virtual_file_mime_type` AS 'bs_fk_signed_bs_xls_fmfiles__virtual_file_mime_type',
	bs_fk_signed_bs_xls_fmfiles.`modified` AS 'bs_fk_signed_bs_xls_fmfiles__modified',
	bs_fk_signed_bs_xls_fmfiles.`created` AS 'bs_fk_signed_bs_xls_fmfiles__created',
	bs_fk_signed_bs_xls_fmfiles.`deleted_flag` AS 'bs_fk_signed_bs_xls_fmfiles__deleted_flag',
	bs_fk_signed_bs_xls_fmfiles.`directly_deleted_flag` AS 'bs_fk_signed_bs_xls_fmfiles__directly_deleted_flag',

	bs_fk_unsigned_bs_pdf_fmfiles__fk_fmfolders.`id` AS 'bs_fk_unsigned_bs_pdf_fmfiles__fk_fmfolders__file_manager_folder_id',
	bs_fk_unsigned_bs_pdf_fmfiles__fk_fmfolders.`user_company_id` AS 'bs_fk_unsigned_bs_pdf_fmfiles__fk_fmfolders__user_company_id',
	bs_fk_unsigned_bs_pdf_fmfiles__fk_fmfolders.`contact_id` AS 'bs_fk_unsigned_bs_pdf_fmfiles__fk_fmfolders__contact_id',
	bs_fk_unsigned_bs_pdf_fmfiles__fk_fmfolders.`project_id` AS 'bs_fk_unsigned_bs_pdf_fmfiles__fk_fmfolders__project_id',
	bs_fk_unsigned_bs_pdf_fmfiles__fk_fmfolders.`virtual_file_path` AS 'bs_fk_unsigned_bs_pdf_fmfiles__fk_fmfolders__virtual_file_path',
	bs_fk_unsigned_bs_pdf_fmfiles__fk_fmfolders.`virtual_file_path_sha1` AS 'bs_fk_unsigned_bs_pdf_fmfiles__fk_fmfolders__virtual_file_path_sha1',
	bs_fk_unsigned_bs_pdf_fmfiles__fk_fmfolders.`modified` AS 'bs_fk_unsigned_bs_pdf_fmfiles__fk_fmfolders__modified',
	bs_fk_unsigned_bs_pdf_fmfiles__fk_fmfolders.`created` AS 'bs_fk_unsigned_bs_pdf_fmfiles__fk_fmfolders__created',
	bs_fk_unsigned_bs_pdf_fmfiles__fk_fmfolders.`deleted_flag` AS 'bs_fk_unsigned_bs_pdf_fmfiles__fk_fmfolders__deleted_flag',
	bs_fk_unsigned_bs_pdf_fmfiles__fk_fmfolders.`directly_deleted_flag` AS 'bs_fk_unsigned_bs_pdf_fmfiles__fk_fmfolders__directly_deleted_flag',

	bs_fk_signed_bs_pdf_fmfiles__fk_fmfolders.`id` AS 'bs_fk_signed_bs_pdf_fmfiles__fk_fmfolders__file_manager_folder_id',
	bs_fk_signed_bs_pdf_fmfiles__fk_fmfolders.`user_company_id` AS 'bs_fk_signed_bs_pdf_fmfiles__fk_fmfolders__user_company_id',
	bs_fk_signed_bs_pdf_fmfiles__fk_fmfolders.`contact_id` AS 'bs_fk_signed_bs_pdf_fmfiles__fk_fmfolders__contact_id',
	bs_fk_signed_bs_pdf_fmfiles__fk_fmfolders.`project_id` AS 'bs_fk_signed_bs_pdf_fmfiles__fk_fmfolders__project_id',
	bs_fk_signed_bs_pdf_fmfiles__fk_fmfolders.`virtual_file_path` AS 'bs_fk_signed_bs_pdf_fmfiles__fk_fmfolders__virtual_file_path',
	bs_fk_signed_bs_pdf_fmfiles__fk_fmfolders.`virtual_file_path_sha1` AS 'bs_fk_signed_bs_pdf_fmfiles__fk_fmfolders__virtual_file_path_sha1',
	bs_fk_signed_bs_pdf_fmfiles__fk_fmfolders.`modified` AS 'bs_fk_signed_bs_pdf_fmfiles__fk_fmfolders__modified',
	bs_fk_signed_bs_pdf_fmfiles__fk_fmfolders.`created` AS 'bs_fk_signed_bs_pdf_fmfiles__fk_fmfolders__created',
	bs_fk_signed_bs_pdf_fmfiles__fk_fmfolders.`deleted_flag` AS 'bs_fk_signed_bs_pdf_fmfiles__fk_fmfolders__deleted_flag',
	bs_fk_signed_bs_pdf_fmfiles__fk_fmfolders.`directly_deleted_flag` AS 'bs_fk_signed_bs_pdf_fmfiles__fk_fmfolders__directly_deleted_flag',

	bs_fk_unsigned_bs_xls_fmfiles__fk_fmfolders.`id` AS 'bs_fk_unsigned_bs_xls_fmfiles__fk_fmfolders__file_manager_folder_id',
	bs_fk_unsigned_bs_xls_fmfiles__fk_fmfolders.`user_company_id` AS 'bs_fk_unsigned_bs_xls_fmfiles__fk_fmfolders__user_company_id',
	bs_fk_unsigned_bs_xls_fmfiles__fk_fmfolders.`contact_id` AS 'bs_fk_unsigned_bs_xls_fmfiles__fk_fmfolders__contact_id',
	bs_fk_unsigned_bs_xls_fmfiles__fk_fmfolders.`project_id` AS 'bs_fk_unsigned_bs_xls_fmfiles__fk_fmfolders__project_id',
	bs_fk_unsigned_bs_xls_fmfiles__fk_fmfolders.`virtual_file_path` AS 'bs_fk_unsigned_bs_xls_fmfiles__fk_fmfolders__virtual_file_path',
	bs_fk_unsigned_bs_xls_fmfiles__fk_fmfolders.`virtual_file_path_sha1` AS 'bs_fk_unsigned_bs_xls_fmfiles__fk_fmfolders__virtual_file_path_sha1',
	bs_fk_unsigned_bs_xls_fmfiles__fk_fmfolders.`modified` AS 'bs_fk_unsigned_bs_xls_fmfiles__fk_fmfolders__modified',
	bs_fk_unsigned_bs_xls_fmfiles__fk_fmfolders.`created` AS 'bs_fk_unsigned_bs_xls_fmfiles__fk_fmfolders__created',
	bs_fk_unsigned_bs_xls_fmfiles__fk_fmfolders.`deleted_flag` AS 'bs_fk_unsigned_bs_xls_fmfiles__fk_fmfolders__deleted_flag',
	bs_fk_unsigned_bs_xls_fmfiles__fk_fmfolders.`directly_deleted_flag` AS 'bs_fk_unsigned_bs_xls_fmfiles__fk_fmfolders__directly_deleted_flag',

	bs_fk_signed_bs_xls_fmfiles__fk_fmfolders.`id` AS 'bs_fk_signed_bs_xls_fmfiles__fk_fmfolders__file_manager_folder_id',
	bs_fk_signed_bs_xls_fmfiles__fk_fmfolders.`user_company_id` AS 'bs_fk_signed_bs_xls_fmfiles__fk_fmfolders__user_company_id',
	bs_fk_signed_bs_xls_fmfiles__fk_fmfolders.`contact_id` AS 'bs_fk_signed_bs_xls_fmfiles__fk_fmfolders__contact_id',
	bs_fk_signed_bs_xls_fmfiles__fk_fmfolders.`project_id` AS 'bs_fk_signed_bs_xls_fmfiles__fk_fmfolders__project_id',
	bs_fk_signed_bs_xls_fmfiles__fk_fmfolders.`virtual_file_path` AS 'bs_fk_signed_bs_xls_fmfiles__fk_fmfolders__virtual_file_path',
	bs_fk_signed_bs_xls_fmfiles__fk_fmfolders.`virtual_file_path_sha1` AS 'bs_fk_signed_bs_xls_fmfiles__fk_fmfolders__virtual_file_path_sha1',
	bs_fk_signed_bs_xls_fmfiles__fk_fmfolders.`modified` AS 'bs_fk_signed_bs_xls_fmfiles__fk_fmfolders__modified',
	bs_fk_signed_bs_xls_fmfiles__fk_fmfolders.`created` AS 'bs_fk_signed_bs_xls_fmfiles__fk_fmfolders__created',
	bs_fk_signed_bs_xls_fmfiles__fk_fmfolders.`deleted_flag` AS 'bs_fk_signed_bs_xls_fmfiles__fk_fmfolders__deleted_flag',
	bs_fk_signed_bs_xls_fmfiles__fk_fmfolders.`directly_deleted_flag` AS 'bs_fk_signed_bs_xls_fmfiles__fk_fmfolders__directly_deleted_flag',

	bs.*

FROM `bid_spreads` bs
	INNER JOIN `gc_budget_line_items` bs_fk_gbli ON bs.`gc_budget_line_item_id` = bs_fk_gbli.`id`
	INNER JOIN `bid_spread_statuses` bs_fk_bss ON bs.`bid_spread_status_id` = bs_fk_bss.`id`
	LEFT OUTER JOIN `contacts` bs_fk_submitter_gc_project_manager_c ON bs.`bid_spread_submitter_gc_project_manager_contact_id` = bs_fk_submitter_gc_project_manager_c.`id`
	LEFT OUTER JOIN `contacts` bs_fk_approver_gc_project_executive_c ON bs.`bid_spread_approver_gc_project_executive_contact_id` = bs_fk_approver_gc_project_executive_c.`id`
	LEFT OUTER JOIN `file_manager_files` bs_fk_unsigned_bs_pdf_fmfiles ON bs.`unsigned_bid_spread_pdf_file_manager_file_id` = bs_fk_unsigned_bs_pdf_fmfiles.`id`
	LEFT OUTER JOIN `file_manager_files` bs_fk_signed_bs_pdf_fmfiles ON bs.`signed_bid_spread_pdf_file_manager_file_id` = bs_fk_signed_bs_pdf_fmfiles.`id`
	LEFT OUTER JOIN `file_manager_files` bs_fk_unsigned_bs_xls_fmfiles ON bs.`unsigned_bid_spread_xls_file_manager_file_id` = bs_fk_unsigned_bs_xls_fmfiles.`id`
	LEFT OUTER JOIN `file_manager_files` bs_fk_signed_bs_xls_fmfiles ON bs.`signed_bid_spread_xls_file_manager_file_id` = bs_fk_signed_bs_xls_fmfiles.`id`

	LEFT OUTER JOIN `file_manager_folders` bs_fk_unsigned_bs_pdf_fmfiles__fk_fmfolders ON bs_fk_unsigned_bs_pdf_fmfiles.`file_manager_folder_id` = bs_fk_unsigned_bs_pdf_fmfiles__fk_fmfolders.`id`
	LEFT OUTER JOIN `file_manager_folders` bs_fk_signed_bs_pdf_fmfiles__fk_fmfolders ON bs_fk_signed_bs_pdf_fmfiles.`file_manager_folder_id` = bs_fk_signed_bs_pdf_fmfiles__fk_fmfolders.`id`
	LEFT OUTER JOIN `file_manager_folders` bs_fk_unsigned_bs_xls_fmfiles__fk_fmfolders ON bs_fk_unsigned_bs_xls_fmfiles.`file_manager_folder_id` = bs_fk_unsigned_bs_xls_fmfiles__fk_fmfolders.`id`
	LEFT OUTER JOIN `file_manager_folders` bs_fk_signed_bs_xls_fmfiles__fk_fmfolders ON bs_fk_signed_bs_xls_fmfiles.`file_manager_folder_id` = bs_fk_signed_bs_xls_fmfiles__fk_fmfolders.`id`
WHERE bs.`bid_spreadsheet_data_sha1` = ?
";
		$arrValues = array($bid_spreadsheet_data_sha1);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if ($row) {
			$bid_spread_id = $row['id'];
			$bidSpread = self::instantiateOrm($database, 'BidSpread', $row, null, $bid_spread_id);
			/* @var $bidSpread BidSpread */
			$bidSpread->convertPropertiesToData();

			if (isset($row['gc_budget_line_item_id'])) {
				$gc_budget_line_item_id = $row['gc_budget_line_item_id'];
				$row['bs_fk_gbli__id'] = $gc_budget_line_item_id;
				$gcBudgetLineItem = self::instantiateOrm($database, 'GcBudgetLineItem', $row, null, $gc_budget_line_item_id, 'bs_fk_gbli__');
				/* @var $gcBudgetLineItem GcBudgetLineItem */
				$gcBudgetLineItem->convertPropertiesToData();
			} else {
				$gcBudgetLineItem = false;
			}
			$bidSpread->setGcBudgetLineItem($gcBudgetLineItem);

			if (isset($row['bid_spread_status_id'])) {
				$bid_spread_status_id = $row['bid_spread_status_id'];
				$row['bs_fk_bss__id'] = $bid_spread_status_id;
				$bidSpreadStatus = self::instantiateOrm($database, 'BidSpreadStatus', $row, null, $bid_spread_status_id, 'bs_fk_bss__');
				/* @var $bidSpreadStatus BidSpreadStatus */
				$bidSpreadStatus->convertPropertiesToData();
			} else {
				$bidSpreadStatus = false;
			}
			$bidSpread->setBidSpreadStatus($bidSpreadStatus);

			if (isset($row['bid_spread_submitter_gc_project_manager_contact_id'])) {
				$bid_spread_submitter_gc_project_manager_contact_id = $row['bid_spread_submitter_gc_project_manager_contact_id'];
				$row['bs_fk_submitter_gc_project_manager_c__id'] = $bid_spread_submitter_gc_project_manager_contact_id;
				$bidSpreadSubmitterGcProjectManagerContact = self::instantiateOrm($database, 'Contact', $row, null, $bid_spread_submitter_gc_project_manager_contact_id, 'bs_fk_submitter_gc_project_manager_c__');
				/* @var $bidSpreadSubmitterGcProjectManagerContact Contact */
				$bidSpreadSubmitterGcProjectManagerContact->convertPropertiesToData();
			} else {
				$bidSpreadSubmitterGcProjectManagerContact = false;
			}
			$bidSpread->setBidSpreadSubmitterGcProjectManagerContact($bidSpreadSubmitterGcProjectManagerContact);

			if (isset($row['bid_spread_approver_gc_project_executive_contact_id'])) {
				$bid_spread_approver_gc_project_executive_contact_id = $row['bid_spread_approver_gc_project_executive_contact_id'];
				$row['bs_fk_approver_gc_project_executive_c__id'] = $bid_spread_approver_gc_project_executive_contact_id;
				$bidSpreadApproverGcProjectExecutiveContact = self::instantiateOrm($database, 'Contact', $row, null, $bid_spread_approver_gc_project_executive_contact_id, 'bs_fk_approver_gc_project_executive_c__');
				/* @var $bidSpreadApproverGcProjectExecutiveContact Contact */
				$bidSpreadApproverGcProjectExecutiveContact->convertPropertiesToData();
			} else {
				$bidSpreadApproverGcProjectExecutiveContact = false;
			}
			$bidSpread->setBidSpreadApproverGcProjectExecutiveContact($bidSpreadApproverGcProjectExecutiveContact);

			// LEFT OUTER JOIN `file_manager_files` bs_fk_unsigned_bs_pdf_fmfiles ON bs.`unsigned_bid_spread_pdf_file_manager_file_id` = bs_fk_unsigned_bs_pdf_fmfiles.`id`
			if (isset($row['unsigned_bid_spread_pdf_file_manager_file_id'])) {
				$unsigned_bid_spread_pdf_file_manager_file_id = $row['unsigned_bid_spread_pdf_file_manager_file_id'];
				$row['bs_fk_unsigned_bs_pdf_fmfiles__id'] = $unsigned_bid_spread_pdf_file_manager_file_id;
				$unsignedBidSpreadPdfFileManagerFile = self::instantiateOrm($database, 'FileManagerFile', $row, null, $unsigned_bid_spread_pdf_file_manager_file_id, 'bs_fk_unsigned_bs_pdf_fmfiles__');
				/* @var $unsignedBidSpreadPdfFileManagerFile FileManagerFile */
				$unsignedBidSpreadPdfFileManagerFile->convertPropertiesToData();
			} else {
				$unsignedBidSpreadPdfFileManagerFile = false;
			}
			$bidSpread->setUnsignedBidSpreadPdfFileManagerFile($unsignedBidSpreadPdfFileManagerFile);

			// LEFT OUTER JOIN `file_manager_files` bs_fk_signed_bs_pdf_fmfiles ON bs.`signed_bid_spread_pdf_file_manager_file_id` = bs_fk_signed_bs_pdf_fmfiles.`id`
			if (isset($row['signed_bid_spread_pdf_file_manager_file_id'])) {
				$signed_bid_spread_pdf_file_manager_file_id = $row['signed_bid_spread_pdf_file_manager_file_id'];
				$row['bs_fk_signed_bs_pdf_fmfiles__id'] = $signed_bid_spread_pdf_file_manager_file_id;
				$signedBidSpreadPdfFileManagerFile = self::instantiateOrm($database, 'FileManagerFile', $row, null, $signed_bid_spread_pdf_file_manager_file_id, 'bs_fk_signed_bs_pdf_fmfiles__');
				/* @var $signedBidSpreadPdfFileManagerFile FileManagerFile */
				$signedBidSpreadPdfFileManagerFile->convertPropertiesToData();
			} else {
				$signedBidSpreadPdfFileManagerFile = false;
			}
			$bidSpread->setSignedBidSpreadPdfFileManagerFile($signedBidSpreadPdfFileManagerFile);

			// LEFT OUTER JOIN `file_manager_files` bs_fk_unsigned_bs_xls_fmfiles ON bs.`unsigned_bid_spread_xls_file_manager_file_id` = bs_fk_unsigned_bs_xls_fmfiles.`id`
			if (isset($row['unsigned_bid_spread_xls_file_manager_file_id'])) {
				$unsigned_bid_spread_xls_file_manager_file_id = $row['unsigned_bid_spread_xls_file_manager_file_id'];
				$row['bs_fk_unsigned_bs_xls_fmfiles__id'] = $unsigned_bid_spread_xls_file_manager_file_id;
				$unsignedBidSpreadXlsFileManagerFile = self::instantiateOrm($database, 'FileManagerFile', $row, null, $unsigned_bid_spread_xls_file_manager_file_id, 'bs_fk_unsigned_bs_xls_fmfiles__');
				/* @var $unsignedBidSpreadXlsFileManagerFile FileManagerFile */
				$unsignedBidSpreadXlsFileManagerFile->convertPropertiesToData();
			} else {
				$unsignedBidSpreadXlsFileManagerFile = false;
			}
			$bidSpread->setUnsignedBidSpreadXlsFileManagerFile($unsignedBidSpreadXlsFileManagerFile);

			// LEFT OUTER JOIN `file_manager_files` bs_fk_signed_bs_xls_fmfiles ON bs.`signed_bid_spread_xls_file_manager_file_id` = bs_fk_signed_bs_xls_fmfiles.`id`
			if (isset($row['signed_bid_spread_xls_file_manager_file_id'])) {
				$signed_bid_spread_xls_file_manager_file_id = $row['signed_bid_spread_xls_file_manager_file_id'];
				$row['bs_fk_signed_bs_xls_fmfiles__id'] = $signed_bid_spread_xls_file_manager_file_id;
				$signedBidSpreadXlsFileManagerFile = self::instantiateOrm($database, 'FileManagerFile', $row, null, $signed_bid_spread_xls_file_manager_file_id, 'bs_fk_signed_bs_xls_fmfiles__');
				/* @var $signedBidSpreadXlsFileManagerFile FileManagerFile */
				$signedBidSpreadXlsFileManagerFile->convertPropertiesToData();
			} else {
				$signedBidSpreadXlsFileManagerFile = false;
			}
			$bidSpread->setSignedBidSpreadXlsFileManagerFile($signedBidSpreadXlsFileManagerFile);

			// LEFT OUTER JOIN `file_manager_folders` bs_fk_unsigned_bs_pdf_fmfiles__fk_fmfolders ON bs_fk_unsigned_bs_pdf_fmfiles.`file_manager_folder_id` = bs_fk_unsigned_bs_pdf_fmfiles__fk_fmfolders.`id`
			if (isset($row['bs_fk_unsigned_bs_pdf_fmfiles__fk_fmfolders__file_manager_folder_id'])) {
				$file_manager_folder_id = $row['bs_fk_unsigned_bs_pdf_fmfiles__fk_fmfolders__file_manager_folder_id'];
				$row['bs_fk_unsigned_bs_pdf_fmfiles__fk_fmfolders__id'] = $file_manager_folder_id;
				$unsignedBidSpreadPdfFileManagerFolder = self::instantiateOrm($database, 'FileManagerFolder', $row, null, $file_manager_folder_id, 'bs_fk_unsigned_bs_pdf_fmfiles__fk_fmfolders__');
				/* @var $unsignedBidSpreadPdfFileManagerFolder FileManagerFolder */
				$unsignedBidSpreadPdfFileManagerFolder->convertPropertiesToData();
			} else {
				$unsignedBidSpreadPdfFileManagerFolder = false;
			}
			$bidSpread->setUnsignedBidSpreadPdfFileManagerFolder($unsignedBidSpreadPdfFileManagerFolder);

			// LEFT OUTER JOIN `file_manager_folders` bs_fk_signed_bs_pdf_fmfiles__fk_fmfolders ON bs_fk_signed_bs_pdf_fmfiles.`file_manager_folder_id` = bs_fk_signed_bs_pdf_fmfiles__fk_fmfolders.`id`
			if (isset($row['bs_fk_signed_bs_pdf_fmfiles__fk_fmfolders__file_manager_folder_id'])) {
				$file_manager_folder_id = $row['bs_fk_signed_bs_pdf_fmfiles__fk_fmfolders__file_manager_folder_id'];
				$row['bs_fk_signed_bs_pdf_fmfiles__fk_fmfolders__id'] = $file_manager_folder_id;
				$signedBidSpreadPdfFileManagerFolder = self::instantiateOrm($database, 'FileManagerFolder', $row, null, $file_manager_folder_id, 'bs_fk_signed_bs_pdf_fmfiles__fk_fmfolders__');
				/* @var $signedBidSpreadPdfFileManagerFolder FileManagerFolder */
				$signedBidSpreadPdfFileManagerFolder->convertPropertiesToData();
			} else {
				$signedBidSpreadPdfFileManagerFolder = false;
			}
			$bidSpread->setSignedBidSpreadPdfFileManagerFolder($signedBidSpreadPdfFileManagerFolder);

			// LEFT OUTER JOIN `file_manager_folders` bs_fk_unsigned_bs_xls_fmfiles__fk_fmfolders ON bs_fk_unsigned_bs_xls_fmfiles.`file_manager_folder_id` = bs_fk_unsigned_bs_xls_fmfiles__fk_fmfolders.`id`
			if (isset($row['bs_fk_unsigned_bs_xls_fmfiles__fk_fmfolders__file_manager_folder_id'])) {
				$file_manager_folder_id = $row['bs_fk_unsigned_bs_xls_fmfiles__fk_fmfolders__file_manager_folder_id'];
				$row['bs_fk_unsigned_bs_xls_fmfiles__fk_fmfolders__id'] = $file_manager_folder_id;
				$unsignedBidSpreadXlsFileManagerFolder = self::instantiateOrm($database, 'FileManagerFolder', $row, null, $file_manager_folder_id, 'bs_fk_unsigned_bs_xls_fmfiles__fk_fmfolders__');
				/* @var $unsignedBidSpreadXlsFileManagerFolder FileManagerFolder */
				$unsignedBidSpreadXlsFileManagerFolder->convertPropertiesToData();
			} else {
				$unsignedBidSpreadXlsFileManagerFolder = false;
			}
			$bidSpread->setUnsignedBidSpreadXlsFileManagerFolder($unsignedBidSpreadXlsFileManagerFolder);

			// LEFT OUTER JOIN `file_manager_folders` bs_fk_signed_bs_xls_fmfiles__fk_fmfolders ON bs_fk_signed_bs_xls_fmfiles.`file_manager_folder_id` = bs_fk_signed_bs_xls_fmfiles__fk_fmfolders.`id`
			if (isset($row['bs_fk_signed_bs_xls_fmfiles__fk_fmfolders__file_manager_folder_id'])) {
				$file_manager_folder_id = $row['bs_fk_signed_bs_xls_fmfiles__fk_fmfolders__file_manager_folder_id'];
				$row['bs_fk_signed_bs_xls_fmfiles__fk_fmfolders__id'] = $file_manager_folder_id;
				$signedBidSpreadXlsFileManagerFolder = self::instantiateOrm($database, 'FileManagerFolder', $row, null, $file_manager_folder_id, 'bs_fk_signed_bs_xls_fmfiles__fk_fmfolders__');
				/* @var $signedBidSpreadXlsFileManagerFolder FileManagerFolder */
				$signedBidSpreadXlsFileManagerFolder->convertPropertiesToData();
			} else {
				$signedBidSpreadXlsFileManagerFolder = false;
			}
			$bidSpread->setSignedBidSpreadXlsFileManagerFolder($signedBidSpreadXlsFileManagerFolder);

			return $bidSpread;
		} else {
			return false;
		}
	}

	// Loaders: Load By pk List (list of auto int ids or other non auto int pk list)
	/**
	 * Load zero or more records by an id list (array of auto int primary keys).
	 *
	 * @param string $database
	 * @param array $arrBidSpreadIds
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadBidSpreadsByArrBidSpreadIds($database, $arrBidSpreadIds, Input $options=null)
	{
		if (empty($arrBidSpreadIds)) {
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
		// ORDER BY `id` ASC, `gc_budget_line_item_id` ASC, `bid_spread_sequence_number` ASC, `bid_spread_status_id` ASC, `bid_spreadsheet_data_sha1` ASC, `bid_spread_submitter_gc_project_manager_contact_id` ASC, `bid_spread_approver_gc_project_executive_contact_id` ASC, `bid_spread_bid_total` ASC, `bid_spread_approved_value` ASC, `unsigned_bid_spread_pdf_file_manager_file_id` ASC, `signed_bid_spread_pdf_file_manager_file_id` ASC, `unsigned_bid_spread_xls_file_manager_file_id` ASC, `signed_bid_spread_xls_file_manager_file_id` ASC, `modified` ASC, `created` ASC, `display_linked_cost_codes_flag` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY bs.`bid_spread_sequence_number` DESC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpBidSpread = new BidSpread($database);
			$sqlOrderByColumns = $tmpBidSpread->constructSqlOrderByColumns($arrOrderByAttributes);

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

		foreach ($arrBidSpreadIds as $k => $bid_spread_id) {
			$bid_spread_id = (int) $bid_spread_id;
			$arrBidSpreadIds[$k] = $db->escape($bid_spread_id);
		}
		$csvBidSpreadIds = join(',', $arrBidSpreadIds);

		$query =
"
SELECT

	bs.*

FROM `bid_spreads` bs
WHERE bs.`id` IN ($csvBidSpreadIds){$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		$arrBidSpreadsByCsvBidSpreadIds = array();
		while ($row = $db->fetch()) {
			$bid_spread_id = $row['id'];
			$bidSpread = self::instantiateOrm($database, 'BidSpread', $row, null, $bid_spread_id);
			/* @var $bidSpread BidSpread */
			$bidSpread->convertPropertiesToData();

			$arrBidSpreadsByCsvBidSpreadIds[$bid_spread_id] = $bidSpread;
		}

		$db->free_result();

		return $arrBidSpreadsByCsvBidSpreadIds;
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `bid_spreads_fk_gbli` foreign key (`gc_budget_line_item_id`) references `gc_budget_line_items` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $gc_budget_line_item_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadBidSpreadsByGcBudgetLineItemId($database, $gc_budget_line_item_id, Input $options=null)
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
			self::$_arrBidSpreadsByGcBudgetLineItemId = null;
		}

		$arrBidSpreadsByGcBudgetLineItemId = self::$_arrBidSpreadsByGcBudgetLineItemId;
		if (isset($arrBidSpreadsByGcBudgetLineItemId) && !empty($arrBidSpreadsByGcBudgetLineItemId)) {
			return $arrBidSpreadsByGcBudgetLineItemId;
		}

		$gc_budget_line_item_id = (int) $gc_budget_line_item_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `gc_budget_line_item_id` ASC, `bid_spread_sequence_number` ASC, `bid_spread_status_id` ASC, `bid_spreadsheet_data_sha1` ASC, `bid_spread_submitter_gc_project_manager_contact_id` ASC, `bid_spread_approver_gc_project_executive_contact_id` ASC, `bid_spread_bid_total` ASC, `bid_spread_approved_value` ASC, `unsigned_bid_spread_pdf_file_manager_file_id` ASC, `signed_bid_spread_pdf_file_manager_file_id` ASC, `unsigned_bid_spread_xls_file_manager_file_id` ASC, `signed_bid_spread_xls_file_manager_file_id` ASC, `modified` ASC, `created` ASC, `display_linked_cost_codes_flag` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY bs.`bid_spread_sequence_number` DESC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpBidSpread = new BidSpread($database);
			$sqlOrderByColumns = $tmpBidSpread->constructSqlOrderByColumns($arrOrderByAttributes);

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

	bs_fk_gbli.`id` AS 'bs_fk_gbli__gc_budget_line_item_id',
	bs_fk_gbli.`user_company_id` AS 'bs_fk_gbli__user_company_id',
	bs_fk_gbli.`project_id` AS 'bs_fk_gbli__project_id',
	bs_fk_gbli.`cost_code_id` AS 'bs_fk_gbli__cost_code_id',
	bs_fk_gbli.`modified` AS 'bs_fk_gbli__modified',
	bs_fk_gbli.`prime_contract_scheduled_value` AS 'bs_fk_gbli__prime_contract_scheduled_value',
	bs_fk_gbli.`forecasted_expenses` AS 'bs_fk_gbli__forecasted_expenses',
	bs_fk_gbli.`created` AS 'bs_fk_gbli__created',
	bs_fk_gbli.`sort_order` AS 'bs_fk_gbli__sort_order',
	bs_fk_gbli.`disabled_flag` AS 'bs_fk_gbli__disabled_flag',

	bs_fk_bss.`id` AS 'bs_fk_bss__bid_spread_status_id',
	bs_fk_bss.`bid_spread_status` AS 'bs_fk_bss__bid_spread_status',
	bs_fk_bss.`bid_spread_status_action_label` AS 'bs_fk_bss__bid_spread_status_action_label',
	bs_fk_bss.`sort_order` AS 'bs_fk_bss__sort_order',

	bs_fk_submitter_gc_project_manager_c.`id` AS 'bs_fk_submitter_gc_project_manager_c__contact_id',
	bs_fk_submitter_gc_project_manager_c.`user_company_id` AS 'bs_fk_submitter_gc_project_manager_c__user_company_id',
	bs_fk_submitter_gc_project_manager_c.`user_id` AS 'bs_fk_submitter_gc_project_manager_c__user_id',
	bs_fk_submitter_gc_project_manager_c.`contact_company_id` AS 'bs_fk_submitter_gc_project_manager_c__contact_company_id',
	bs_fk_submitter_gc_project_manager_c.`email` AS 'bs_fk_submitter_gc_project_manager_c__email',
	bs_fk_submitter_gc_project_manager_c.`name_prefix` AS 'bs_fk_submitter_gc_project_manager_c__name_prefix',
	bs_fk_submitter_gc_project_manager_c.`first_name` AS 'bs_fk_submitter_gc_project_manager_c__first_name',
	bs_fk_submitter_gc_project_manager_c.`additional_name` AS 'bs_fk_submitter_gc_project_manager_c__additional_name',
	bs_fk_submitter_gc_project_manager_c.`middle_name` AS 'bs_fk_submitter_gc_project_manager_c__middle_name',
	bs_fk_submitter_gc_project_manager_c.`last_name` AS 'bs_fk_submitter_gc_project_manager_c__last_name',
	bs_fk_submitter_gc_project_manager_c.`name_suffix` AS 'bs_fk_submitter_gc_project_manager_c__name_suffix',
	bs_fk_submitter_gc_project_manager_c.`title` AS 'bs_fk_submitter_gc_project_manager_c__title',
	bs_fk_submitter_gc_project_manager_c.`vendor_flag` AS 'bs_fk_submitter_gc_project_manager_c__vendor_flag',

	bs_fk_approver_gc_project_executive_c.`id` AS 'bs_fk_approver_gc_project_executive_c__contact_id',
	bs_fk_approver_gc_project_executive_c.`user_company_id` AS 'bs_fk_approver_gc_project_executive_c__user_company_id',
	bs_fk_approver_gc_project_executive_c.`user_id` AS 'bs_fk_approver_gc_project_executive_c__user_id',
	bs_fk_approver_gc_project_executive_c.`contact_company_id` AS 'bs_fk_approver_gc_project_executive_c__contact_company_id',
	bs_fk_approver_gc_project_executive_c.`email` AS 'bs_fk_approver_gc_project_executive_c__email',
	bs_fk_approver_gc_project_executive_c.`name_prefix` AS 'bs_fk_approver_gc_project_executive_c__name_prefix',
	bs_fk_approver_gc_project_executive_c.`first_name` AS 'bs_fk_approver_gc_project_executive_c__first_name',
	bs_fk_approver_gc_project_executive_c.`additional_name` AS 'bs_fk_approver_gc_project_executive_c__additional_name',
	bs_fk_approver_gc_project_executive_c.`middle_name` AS 'bs_fk_approver_gc_project_executive_c__middle_name',
	bs_fk_approver_gc_project_executive_c.`last_name` AS 'bs_fk_approver_gc_project_executive_c__last_name',
	bs_fk_approver_gc_project_executive_c.`name_suffix` AS 'bs_fk_approver_gc_project_executive_c__name_suffix',
	bs_fk_approver_gc_project_executive_c.`title` AS 'bs_fk_approver_gc_project_executive_c__title',
	bs_fk_approver_gc_project_executive_c.`vendor_flag` AS 'bs_fk_approver_gc_project_executive_c__vendor_flag',

	bs_fk_unsigned_bs_pdf_fmfiles.`id` AS 'bs_fk_unsigned_bs_pdf_fmfiles__file_manager_file_id',
	bs_fk_unsigned_bs_pdf_fmfiles.`user_company_id` AS 'bs_fk_unsigned_bs_pdf_fmfiles__user_company_id',
	bs_fk_unsigned_bs_pdf_fmfiles.`contact_id` AS 'bs_fk_unsigned_bs_pdf_fmfiles__contact_id',
	bs_fk_unsigned_bs_pdf_fmfiles.`project_id` AS 'bs_fk_unsigned_bs_pdf_fmfiles__project_id',
	bs_fk_unsigned_bs_pdf_fmfiles.`file_manager_folder_id` AS 'bs_fk_unsigned_bs_pdf_fmfiles__file_manager_folder_id',
	bs_fk_unsigned_bs_pdf_fmfiles.`file_location_id` AS 'bs_fk_unsigned_bs_pdf_fmfiles__file_location_id',
	bs_fk_unsigned_bs_pdf_fmfiles.`virtual_file_name` AS 'bs_fk_unsigned_bs_pdf_fmfiles__virtual_file_name',
	bs_fk_unsigned_bs_pdf_fmfiles.`version_number` AS 'bs_fk_unsigned_bs_pdf_fmfiles__version_number',
	bs_fk_unsigned_bs_pdf_fmfiles.`virtual_file_name_sha1` AS 'bs_fk_unsigned_bs_pdf_fmfiles__virtual_file_name_sha1',
	bs_fk_unsigned_bs_pdf_fmfiles.`virtual_file_mime_type` AS 'bs_fk_unsigned_bs_pdf_fmfiles__virtual_file_mime_type',
	bs_fk_unsigned_bs_pdf_fmfiles.`modified` AS 'bs_fk_unsigned_bs_pdf_fmfiles__modified',
	bs_fk_unsigned_bs_pdf_fmfiles.`created` AS 'bs_fk_unsigned_bs_pdf_fmfiles__created',
	bs_fk_unsigned_bs_pdf_fmfiles.`deleted_flag` AS 'bs_fk_unsigned_bs_pdf_fmfiles__deleted_flag',
	bs_fk_unsigned_bs_pdf_fmfiles.`directly_deleted_flag` AS 'bs_fk_unsigned_bs_pdf_fmfiles__directly_deleted_flag',

	bs_fk_signed_bs_pdf_fmfiles.`id` AS 'bs_fk_signed_bs_pdf_fmfiles__file_manager_file_id',
	bs_fk_signed_bs_pdf_fmfiles.`user_company_id` AS 'bs_fk_signed_bs_pdf_fmfiles__user_company_id',
	bs_fk_signed_bs_pdf_fmfiles.`contact_id` AS 'bs_fk_signed_bs_pdf_fmfiles__contact_id',
	bs_fk_signed_bs_pdf_fmfiles.`project_id` AS 'bs_fk_signed_bs_pdf_fmfiles__project_id',
	bs_fk_signed_bs_pdf_fmfiles.`file_manager_folder_id` AS 'bs_fk_signed_bs_pdf_fmfiles__file_manager_folder_id',
	bs_fk_signed_bs_pdf_fmfiles.`file_location_id` AS 'bs_fk_signed_bs_pdf_fmfiles__file_location_id',
	bs_fk_signed_bs_pdf_fmfiles.`virtual_file_name` AS 'bs_fk_signed_bs_pdf_fmfiles__virtual_file_name',
	bs_fk_signed_bs_pdf_fmfiles.`version_number` AS 'bs_fk_signed_bs_pdf_fmfiles__version_number',
	bs_fk_signed_bs_pdf_fmfiles.`virtual_file_name_sha1` AS 'bs_fk_signed_bs_pdf_fmfiles__virtual_file_name_sha1',
	bs_fk_signed_bs_pdf_fmfiles.`virtual_file_mime_type` AS 'bs_fk_signed_bs_pdf_fmfiles__virtual_file_mime_type',
	bs_fk_signed_bs_pdf_fmfiles.`modified` AS 'bs_fk_signed_bs_pdf_fmfiles__modified',
	bs_fk_signed_bs_pdf_fmfiles.`created` AS 'bs_fk_signed_bs_pdf_fmfiles__created',
	bs_fk_signed_bs_pdf_fmfiles.`deleted_flag` AS 'bs_fk_signed_bs_pdf_fmfiles__deleted_flag',
	bs_fk_signed_bs_pdf_fmfiles.`directly_deleted_flag` AS 'bs_fk_signed_bs_pdf_fmfiles__directly_deleted_flag',

	bs_fk_unsigned_bs_xls_fmfiles.`id` AS 'bs_fk_unsigned_bs_xls_fmfiles__file_manager_file_id',
	bs_fk_unsigned_bs_xls_fmfiles.`user_company_id` AS 'bs_fk_unsigned_bs_xls_fmfiles__user_company_id',
	bs_fk_unsigned_bs_xls_fmfiles.`contact_id` AS 'bs_fk_unsigned_bs_xls_fmfiles__contact_id',
	bs_fk_unsigned_bs_xls_fmfiles.`project_id` AS 'bs_fk_unsigned_bs_xls_fmfiles__project_id',
	bs_fk_unsigned_bs_xls_fmfiles.`file_manager_folder_id` AS 'bs_fk_unsigned_bs_xls_fmfiles__file_manager_folder_id',
	bs_fk_unsigned_bs_xls_fmfiles.`file_location_id` AS 'bs_fk_unsigned_bs_xls_fmfiles__file_location_id',
	bs_fk_unsigned_bs_xls_fmfiles.`virtual_file_name` AS 'bs_fk_unsigned_bs_xls_fmfiles__virtual_file_name',
	bs_fk_unsigned_bs_xls_fmfiles.`version_number` AS 'bs_fk_unsigned_bs_xls_fmfiles__version_number',
	bs_fk_unsigned_bs_xls_fmfiles.`virtual_file_name_sha1` AS 'bs_fk_unsigned_bs_xls_fmfiles__virtual_file_name_sha1',
	bs_fk_unsigned_bs_xls_fmfiles.`virtual_file_mime_type` AS 'bs_fk_unsigned_bs_xls_fmfiles__virtual_file_mime_type',
	bs_fk_unsigned_bs_xls_fmfiles.`modified` AS 'bs_fk_unsigned_bs_xls_fmfiles__modified',
	bs_fk_unsigned_bs_xls_fmfiles.`created` AS 'bs_fk_unsigned_bs_xls_fmfiles__created',
	bs_fk_unsigned_bs_xls_fmfiles.`deleted_flag` AS 'bs_fk_unsigned_bs_xls_fmfiles__deleted_flag',
	bs_fk_unsigned_bs_xls_fmfiles.`directly_deleted_flag` AS 'bs_fk_unsigned_bs_xls_fmfiles__directly_deleted_flag',

	bs_fk_signed_bs_xls_fmfiles.`id` AS 'bs_fk_signed_bs_xls_fmfiles__file_manager_file_id',
	bs_fk_signed_bs_xls_fmfiles.`user_company_id` AS 'bs_fk_signed_bs_xls_fmfiles__user_company_id',
	bs_fk_signed_bs_xls_fmfiles.`contact_id` AS 'bs_fk_signed_bs_xls_fmfiles__contact_id',
	bs_fk_signed_bs_xls_fmfiles.`project_id` AS 'bs_fk_signed_bs_xls_fmfiles__project_id',
	bs_fk_signed_bs_xls_fmfiles.`file_manager_folder_id` AS 'bs_fk_signed_bs_xls_fmfiles__file_manager_folder_id',
	bs_fk_signed_bs_xls_fmfiles.`file_location_id` AS 'bs_fk_signed_bs_xls_fmfiles__file_location_id',
	bs_fk_signed_bs_xls_fmfiles.`virtual_file_name` AS 'bs_fk_signed_bs_xls_fmfiles__virtual_file_name',
	bs_fk_signed_bs_xls_fmfiles.`version_number` AS 'bs_fk_signed_bs_xls_fmfiles__version_number',
	bs_fk_signed_bs_xls_fmfiles.`virtual_file_name_sha1` AS 'bs_fk_signed_bs_xls_fmfiles__virtual_file_name_sha1',
	bs_fk_signed_bs_xls_fmfiles.`virtual_file_mime_type` AS 'bs_fk_signed_bs_xls_fmfiles__virtual_file_mime_type',
	bs_fk_signed_bs_xls_fmfiles.`modified` AS 'bs_fk_signed_bs_xls_fmfiles__modified',
	bs_fk_signed_bs_xls_fmfiles.`created` AS 'bs_fk_signed_bs_xls_fmfiles__created',
	bs_fk_signed_bs_xls_fmfiles.`deleted_flag` AS 'bs_fk_signed_bs_xls_fmfiles__deleted_flag',
	bs_fk_signed_bs_xls_fmfiles.`directly_deleted_flag` AS 'bs_fk_signed_bs_xls_fmfiles__directly_deleted_flag',

	bs_fk_unsigned_bs_pdf_fmfiles__fk_fmfolders.`id` AS 'bs_fk_unsigned_bs_pdf_fmfiles__fk_fmfolders__file_manager_folder_id',
	bs_fk_unsigned_bs_pdf_fmfiles__fk_fmfolders.`user_company_id` AS 'bs_fk_unsigned_bs_pdf_fmfiles__fk_fmfolders__user_company_id',
	bs_fk_unsigned_bs_pdf_fmfiles__fk_fmfolders.`contact_id` AS 'bs_fk_unsigned_bs_pdf_fmfiles__fk_fmfolders__contact_id',
	bs_fk_unsigned_bs_pdf_fmfiles__fk_fmfolders.`project_id` AS 'bs_fk_unsigned_bs_pdf_fmfiles__fk_fmfolders__project_id',
	bs_fk_unsigned_bs_pdf_fmfiles__fk_fmfolders.`virtual_file_path` AS 'bs_fk_unsigned_bs_pdf_fmfiles__fk_fmfolders__virtual_file_path',
	bs_fk_unsigned_bs_pdf_fmfiles__fk_fmfolders.`virtual_file_path_sha1` AS 'bs_fk_unsigned_bs_pdf_fmfiles__fk_fmfolders__virtual_file_path_sha1',
	bs_fk_unsigned_bs_pdf_fmfiles__fk_fmfolders.`modified` AS 'bs_fk_unsigned_bs_pdf_fmfiles__fk_fmfolders__modified',
	bs_fk_unsigned_bs_pdf_fmfiles__fk_fmfolders.`created` AS 'bs_fk_unsigned_bs_pdf_fmfiles__fk_fmfolders__created',
	bs_fk_unsigned_bs_pdf_fmfiles__fk_fmfolders.`deleted_flag` AS 'bs_fk_unsigned_bs_pdf_fmfiles__fk_fmfolders__deleted_flag',
	bs_fk_unsigned_bs_pdf_fmfiles__fk_fmfolders.`directly_deleted_flag` AS 'bs_fk_unsigned_bs_pdf_fmfiles__fk_fmfolders__directly_deleted_flag',

	bs_fk_signed_bs_pdf_fmfiles__fk_fmfolders.`id` AS 'bs_fk_signed_bs_pdf_fmfiles__fk_fmfolders__file_manager_folder_id',
	bs_fk_signed_bs_pdf_fmfiles__fk_fmfolders.`user_company_id` AS 'bs_fk_signed_bs_pdf_fmfiles__fk_fmfolders__user_company_id',
	bs_fk_signed_bs_pdf_fmfiles__fk_fmfolders.`contact_id` AS 'bs_fk_signed_bs_pdf_fmfiles__fk_fmfolders__contact_id',
	bs_fk_signed_bs_pdf_fmfiles__fk_fmfolders.`project_id` AS 'bs_fk_signed_bs_pdf_fmfiles__fk_fmfolders__project_id',
	bs_fk_signed_bs_pdf_fmfiles__fk_fmfolders.`virtual_file_path` AS 'bs_fk_signed_bs_pdf_fmfiles__fk_fmfolders__virtual_file_path',
	bs_fk_signed_bs_pdf_fmfiles__fk_fmfolders.`virtual_file_path_sha1` AS 'bs_fk_signed_bs_pdf_fmfiles__fk_fmfolders__virtual_file_path_sha1',
	bs_fk_signed_bs_pdf_fmfiles__fk_fmfolders.`modified` AS 'bs_fk_signed_bs_pdf_fmfiles__fk_fmfolders__modified',
	bs_fk_signed_bs_pdf_fmfiles__fk_fmfolders.`created` AS 'bs_fk_signed_bs_pdf_fmfiles__fk_fmfolders__created',
	bs_fk_signed_bs_pdf_fmfiles__fk_fmfolders.`deleted_flag` AS 'bs_fk_signed_bs_pdf_fmfiles__fk_fmfolders__deleted_flag',
	bs_fk_signed_bs_pdf_fmfiles__fk_fmfolders.`directly_deleted_flag` AS 'bs_fk_signed_bs_pdf_fmfiles__fk_fmfolders__directly_deleted_flag',

	bs_fk_unsigned_bs_xls_fmfiles__fk_fmfolders.`id` AS 'bs_fk_unsigned_bs_xls_fmfiles__fk_fmfolders__file_manager_folder_id',
	bs_fk_unsigned_bs_xls_fmfiles__fk_fmfolders.`user_company_id` AS 'bs_fk_unsigned_bs_xls_fmfiles__fk_fmfolders__user_company_id',
	bs_fk_unsigned_bs_xls_fmfiles__fk_fmfolders.`contact_id` AS 'bs_fk_unsigned_bs_xls_fmfiles__fk_fmfolders__contact_id',
	bs_fk_unsigned_bs_xls_fmfiles__fk_fmfolders.`project_id` AS 'bs_fk_unsigned_bs_xls_fmfiles__fk_fmfolders__project_id',
	bs_fk_unsigned_bs_xls_fmfiles__fk_fmfolders.`virtual_file_path` AS 'bs_fk_unsigned_bs_xls_fmfiles__fk_fmfolders__virtual_file_path',
	bs_fk_unsigned_bs_xls_fmfiles__fk_fmfolders.`virtual_file_path_sha1` AS 'bs_fk_unsigned_bs_xls_fmfiles__fk_fmfolders__virtual_file_path_sha1',
	bs_fk_unsigned_bs_xls_fmfiles__fk_fmfolders.`modified` AS 'bs_fk_unsigned_bs_xls_fmfiles__fk_fmfolders__modified',
	bs_fk_unsigned_bs_xls_fmfiles__fk_fmfolders.`created` AS 'bs_fk_unsigned_bs_xls_fmfiles__fk_fmfolders__created',
	bs_fk_unsigned_bs_xls_fmfiles__fk_fmfolders.`deleted_flag` AS 'bs_fk_unsigned_bs_xls_fmfiles__fk_fmfolders__deleted_flag',
	bs_fk_unsigned_bs_xls_fmfiles__fk_fmfolders.`directly_deleted_flag` AS 'bs_fk_unsigned_bs_xls_fmfiles__fk_fmfolders__directly_deleted_flag',

	bs_fk_signed_bs_xls_fmfiles__fk_fmfolders.`id` AS 'bs_fk_signed_bs_xls_fmfiles__fk_fmfolders__file_manager_folder_id',
	bs_fk_signed_bs_xls_fmfiles__fk_fmfolders.`user_company_id` AS 'bs_fk_signed_bs_xls_fmfiles__fk_fmfolders__user_company_id',
	bs_fk_signed_bs_xls_fmfiles__fk_fmfolders.`contact_id` AS 'bs_fk_signed_bs_xls_fmfiles__fk_fmfolders__contact_id',
	bs_fk_signed_bs_xls_fmfiles__fk_fmfolders.`project_id` AS 'bs_fk_signed_bs_xls_fmfiles__fk_fmfolders__project_id',
	bs_fk_signed_bs_xls_fmfiles__fk_fmfolders.`virtual_file_path` AS 'bs_fk_signed_bs_xls_fmfiles__fk_fmfolders__virtual_file_path',
	bs_fk_signed_bs_xls_fmfiles__fk_fmfolders.`virtual_file_path_sha1` AS 'bs_fk_signed_bs_xls_fmfiles__fk_fmfolders__virtual_file_path_sha1',
	bs_fk_signed_bs_xls_fmfiles__fk_fmfolders.`modified` AS 'bs_fk_signed_bs_xls_fmfiles__fk_fmfolders__modified',
	bs_fk_signed_bs_xls_fmfiles__fk_fmfolders.`created` AS 'bs_fk_signed_bs_xls_fmfiles__fk_fmfolders__created',
	bs_fk_signed_bs_xls_fmfiles__fk_fmfolders.`deleted_flag` AS 'bs_fk_signed_bs_xls_fmfiles__fk_fmfolders__deleted_flag',
	bs_fk_signed_bs_xls_fmfiles__fk_fmfolders.`directly_deleted_flag` AS 'bs_fk_signed_bs_xls_fmfiles__fk_fmfolders__directly_deleted_flag',

	bs.*

FROM `bid_spreads` bs
	INNER JOIN `gc_budget_line_items` bs_fk_gbli ON bs.`gc_budget_line_item_id` = bs_fk_gbli.`id`
	INNER JOIN `bid_spread_statuses` bs_fk_bss ON bs.`bid_spread_status_id` = bs_fk_bss.`id`
	LEFT OUTER JOIN `contacts` bs_fk_submitter_gc_project_manager_c ON bs.`bid_spread_submitter_gc_project_manager_contact_id` = bs_fk_submitter_gc_project_manager_c.`id`
	LEFT OUTER JOIN `contacts` bs_fk_approver_gc_project_executive_c ON bs.`bid_spread_approver_gc_project_executive_contact_id` = bs_fk_approver_gc_project_executive_c.`id`
	LEFT OUTER JOIN `file_manager_files` bs_fk_unsigned_bs_pdf_fmfiles ON bs.`unsigned_bid_spread_pdf_file_manager_file_id` = bs_fk_unsigned_bs_pdf_fmfiles.`id`
	LEFT OUTER JOIN `file_manager_files` bs_fk_signed_bs_pdf_fmfiles ON bs.`signed_bid_spread_pdf_file_manager_file_id` = bs_fk_signed_bs_pdf_fmfiles.`id`
	LEFT OUTER JOIN `file_manager_files` bs_fk_unsigned_bs_xls_fmfiles ON bs.`unsigned_bid_spread_xls_file_manager_file_id` = bs_fk_unsigned_bs_xls_fmfiles.`id`
	LEFT OUTER JOIN `file_manager_files` bs_fk_signed_bs_xls_fmfiles ON bs.`signed_bid_spread_xls_file_manager_file_id` = bs_fk_signed_bs_xls_fmfiles.`id`

	LEFT OUTER JOIN `file_manager_folders` bs_fk_unsigned_bs_pdf_fmfiles__fk_fmfolders ON bs_fk_unsigned_bs_pdf_fmfiles.`file_manager_folder_id` = bs_fk_unsigned_bs_pdf_fmfiles__fk_fmfolders.`id`
	LEFT OUTER JOIN `file_manager_folders` bs_fk_signed_bs_pdf_fmfiles__fk_fmfolders ON bs_fk_signed_bs_pdf_fmfiles.`file_manager_folder_id` = bs_fk_signed_bs_pdf_fmfiles__fk_fmfolders.`id`
	LEFT OUTER JOIN `file_manager_folders` bs_fk_unsigned_bs_xls_fmfiles__fk_fmfolders ON bs_fk_unsigned_bs_xls_fmfiles.`file_manager_folder_id` = bs_fk_unsigned_bs_xls_fmfiles__fk_fmfolders.`id`
	LEFT OUTER JOIN `file_manager_folders` bs_fk_signed_bs_xls_fmfiles__fk_fmfolders ON bs_fk_signed_bs_xls_fmfiles.`file_manager_folder_id` = bs_fk_signed_bs_xls_fmfiles__fk_fmfolders.`id`
WHERE bs.`gc_budget_line_item_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `gc_budget_line_item_id` ASC, `bid_spread_sequence_number` ASC, `bid_spread_status_id` ASC, `bid_spreadsheet_data_sha1` ASC, `bid_spread_submitter_gc_project_manager_contact_id` ASC, `bid_spread_approver_gc_project_executive_contact_id` ASC, `bid_spread_bid_total` ASC, `bid_spread_approved_value` ASC, `unsigned_bid_spread_pdf_file_manager_file_id` ASC, `signed_bid_spread_pdf_file_manager_file_id` ASC, `unsigned_bid_spread_xls_file_manager_file_id` ASC, `signed_bid_spread_xls_file_manager_file_id` ASC, `modified` ASC, `created` ASC, `display_linked_cost_codes_flag` ASC, `sort_order` ASC
		$arrValues = array($gc_budget_line_item_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrBidSpreadsByGcBudgetLineItemId = array();
		while ($row = $db->fetch()) {
			$bid_spread_id = $row['id'];
			$bidSpread = self::instantiateOrm($database, 'BidSpread', $row, null, $bid_spread_id);
			/* @var $bidSpread BidSpread */
			$bidSpread->convertPropertiesToData();

			if (isset($row['gc_budget_line_item_id'])) {
				$gc_budget_line_item_id = $row['gc_budget_line_item_id'];
				$row['bs_fk_gbli__id'] = $gc_budget_line_item_id;
				$gcBudgetLineItem = self::instantiateOrm($database, 'GcBudgetLineItem', $row, null, $gc_budget_line_item_id, 'bs_fk_gbli__');
				/* @var $gcBudgetLineItem GcBudgetLineItem */
				$gcBudgetLineItem->convertPropertiesToData();
			} else {
				$gcBudgetLineItem = false;
			}
			$bidSpread->setGcBudgetLineItem($gcBudgetLineItem);

			if (isset($row['bid_spread_status_id'])) {
				$bid_spread_status_id = $row['bid_spread_status_id'];
				$row['bs_fk_bss__id'] = $bid_spread_status_id;
				$bidSpreadStatus = self::instantiateOrm($database, 'BidSpreadStatus', $row, null, $bid_spread_status_id, 'bs_fk_bss__');
				/* @var $bidSpreadStatus BidSpreadStatus */
				$bidSpreadStatus->convertPropertiesToData();
			} else {
				$bidSpreadStatus = false;
			}
			$bidSpread->setBidSpreadStatus($bidSpreadStatus);

			if (isset($row['bid_spread_submitter_gc_project_manager_contact_id'])) {
				$bid_spread_submitter_gc_project_manager_contact_id = $row['bid_spread_submitter_gc_project_manager_contact_id'];
				$row['bs_fk_submitter_gc_project_manager_c__id'] = $bid_spread_submitter_gc_project_manager_contact_id;
				$bidSpreadSubmitterGcProjectManagerContact = self::instantiateOrm($database, 'Contact', $row, null, $bid_spread_submitter_gc_project_manager_contact_id, 'bs_fk_submitter_gc_project_manager_c__');
				/* @var $bidSpreadSubmitterGcProjectManagerContact Contact */
				$bidSpreadSubmitterGcProjectManagerContact->convertPropertiesToData();
			} else {
				$bidSpreadSubmitterGcProjectManagerContact = false;
			}
			$bidSpread->setBidSpreadSubmitterGcProjectManagerContact($bidSpreadSubmitterGcProjectManagerContact);

			if (isset($row['bid_spread_approver_gc_project_executive_contact_id'])) {
				$bid_spread_approver_gc_project_executive_contact_id = $row['bid_spread_approver_gc_project_executive_contact_id'];
				$row['bs_fk_approver_gc_project_executive_c__id'] = $bid_spread_approver_gc_project_executive_contact_id;
				$bidSpreadApproverGcProjectExecutiveContact = self::instantiateOrm($database, 'Contact', $row, null, $bid_spread_approver_gc_project_executive_contact_id, 'bs_fk_approver_gc_project_executive_c__');
				/* @var $bidSpreadApproverGcProjectExecutiveContact Contact */
				$bidSpreadApproverGcProjectExecutiveContact->convertPropertiesToData();
			} else {
				$bidSpreadApproverGcProjectExecutiveContact = false;
			}
			$bidSpread->setBidSpreadApproverGcProjectExecutiveContact($bidSpreadApproverGcProjectExecutiveContact);

			// LEFT OUTER JOIN `file_manager_files` bs_fk_unsigned_bs_pdf_fmfiles ON bs.`unsigned_bid_spread_pdf_file_manager_file_id` = bs_fk_unsigned_bs_pdf_fmfiles.`id`
			if (isset($row['unsigned_bid_spread_pdf_file_manager_file_id'])) {
				$unsigned_bid_spread_pdf_file_manager_file_id = $row['unsigned_bid_spread_pdf_file_manager_file_id'];
				$row['bs_fk_unsigned_bs_pdf_fmfiles__id'] = $unsigned_bid_spread_pdf_file_manager_file_id;
				$unsignedBidSpreadPdfFileManagerFile = self::instantiateOrm($database, 'FileManagerFile', $row, null, $unsigned_bid_spread_pdf_file_manager_file_id, 'bs_fk_unsigned_bs_pdf_fmfiles__');
				/* @var $unsignedBidSpreadPdfFileManagerFile FileManagerFile */
				$unsignedBidSpreadPdfFileManagerFile->convertPropertiesToData();
			} else {
				$unsignedBidSpreadPdfFileManagerFile = false;
			}
			$bidSpread->setUnsignedBidSpreadPdfFileManagerFile($unsignedBidSpreadPdfFileManagerFile);

			// LEFT OUTER JOIN `file_manager_files` bs_fk_signed_bs_pdf_fmfiles ON bs.`signed_bid_spread_pdf_file_manager_file_id` = bs_fk_signed_bs_pdf_fmfiles.`id`
			if (isset($row['signed_bid_spread_pdf_file_manager_file_id'])) {
				$signed_bid_spread_pdf_file_manager_file_id = $row['signed_bid_spread_pdf_file_manager_file_id'];
				$row['bs_fk_signed_bs_pdf_fmfiles__id'] = $signed_bid_spread_pdf_file_manager_file_id;
				$signedBidSpreadPdfFileManagerFile = self::instantiateOrm($database, 'FileManagerFile', $row, null, $signed_bid_spread_pdf_file_manager_file_id, 'bs_fk_signed_bs_pdf_fmfiles__');
				/* @var $signedBidSpreadPdfFileManagerFile FileManagerFile */
				$signedBidSpreadPdfFileManagerFile->convertPropertiesToData();
			} else {
				$signedBidSpreadPdfFileManagerFile = false;
			}
			$bidSpread->setSignedBidSpreadPdfFileManagerFile($signedBidSpreadPdfFileManagerFile);

			// LEFT OUTER JOIN `file_manager_files` bs_fk_unsigned_bs_xls_fmfiles ON bs.`unsigned_bid_spread_xls_file_manager_file_id` = bs_fk_unsigned_bs_xls_fmfiles.`id`
			if (isset($row['unsigned_bid_spread_xls_file_manager_file_id'])) {
				$unsigned_bid_spread_xls_file_manager_file_id = $row['unsigned_bid_spread_xls_file_manager_file_id'];
				$row['bs_fk_unsigned_bs_xls_fmfiles__id'] = $unsigned_bid_spread_xls_file_manager_file_id;
				$unsignedBidSpreadXlsFileManagerFile = self::instantiateOrm($database, 'FileManagerFile', $row, null, $unsigned_bid_spread_xls_file_manager_file_id, 'bs_fk_unsigned_bs_xls_fmfiles__');
				/* @var $unsignedBidSpreadXlsFileManagerFile FileManagerFile */
				$unsignedBidSpreadXlsFileManagerFile->convertPropertiesToData();
			} else {
				$unsignedBidSpreadXlsFileManagerFile = false;
			}
			$bidSpread->setUnsignedBidSpreadXlsFileManagerFile($unsignedBidSpreadXlsFileManagerFile);

			// LEFT OUTER JOIN `file_manager_files` bs_fk_signed_bs_xls_fmfiles ON bs.`signed_bid_spread_xls_file_manager_file_id` = bs_fk_signed_bs_xls_fmfiles.`id`
			if (isset($row['signed_bid_spread_xls_file_manager_file_id'])) {
				$signed_bid_spread_xls_file_manager_file_id = $row['signed_bid_spread_xls_file_manager_file_id'];
				$row['bs_fk_signed_bs_xls_fmfiles__id'] = $signed_bid_spread_xls_file_manager_file_id;
				$signedBidSpreadXlsFileManagerFile = self::instantiateOrm($database, 'FileManagerFile', $row, null, $signed_bid_spread_xls_file_manager_file_id, 'bs_fk_signed_bs_xls_fmfiles__');
				/* @var $signedBidSpreadXlsFileManagerFile FileManagerFile */
				$signedBidSpreadXlsFileManagerFile->convertPropertiesToData();
			} else {
				$signedBidSpreadXlsFileManagerFile = false;
			}
			$bidSpread->setSignedBidSpreadXlsFileManagerFile($signedBidSpreadXlsFileManagerFile);

			// LEFT OUTER JOIN `file_manager_folders` bs_fk_unsigned_bs_pdf_fmfiles__fk_fmfolders ON bs_fk_unsigned_bs_pdf_fmfiles.`file_manager_folder_id` = bs_fk_unsigned_bs_pdf_fmfiles__fk_fmfolders.`id`
			if (isset($row['bs_fk_unsigned_bs_pdf_fmfiles__fk_fmfolders__file_manager_folder_id'])) {
				$file_manager_folder_id = $row['bs_fk_unsigned_bs_pdf_fmfiles__fk_fmfolders__file_manager_folder_id'];
				$row['bs_fk_unsigned_bs_pdf_fmfiles__fk_fmfolders__id'] = $file_manager_folder_id;
				$unsignedBidSpreadPdfFileManagerFolder = self::instantiateOrm($database, 'FileManagerFolder', $row, null, $file_manager_folder_id, 'bs_fk_unsigned_bs_pdf_fmfiles__fk_fmfolders__');
				/* @var $unsignedBidSpreadPdfFileManagerFolder FileManagerFolder */
				$unsignedBidSpreadPdfFileManagerFolder->convertPropertiesToData();
			} else {
				$unsignedBidSpreadPdfFileManagerFolder = false;
			}
			$bidSpread->setUnsignedBidSpreadPdfFileManagerFolder($unsignedBidSpreadPdfFileManagerFolder);

			// LEFT OUTER JOIN `file_manager_folders` bs_fk_signed_bs_pdf_fmfiles__fk_fmfolders ON bs_fk_signed_bs_pdf_fmfiles.`file_manager_folder_id` = bs_fk_signed_bs_pdf_fmfiles__fk_fmfolders.`id`
			if (isset($row['bs_fk_signed_bs_pdf_fmfiles__fk_fmfolders__file_manager_folder_id'])) {
				$file_manager_folder_id = $row['bs_fk_signed_bs_pdf_fmfiles__fk_fmfolders__file_manager_folder_id'];
				$row['bs_fk_signed_bs_pdf_fmfiles__fk_fmfolders__id'] = $file_manager_folder_id;
				$signedBidSpreadPdfFileManagerFolder = self::instantiateOrm($database, 'FileManagerFolder', $row, null, $file_manager_folder_id, 'bs_fk_signed_bs_pdf_fmfiles__fk_fmfolders__');
				/* @var $signedBidSpreadPdfFileManagerFolder FileManagerFolder */
				$signedBidSpreadPdfFileManagerFolder->convertPropertiesToData();
			} else {
				$signedBidSpreadPdfFileManagerFolder = false;
			}
			$bidSpread->setSignedBidSpreadPdfFileManagerFolder($signedBidSpreadPdfFileManagerFolder);

			// LEFT OUTER JOIN `file_manager_folders` bs_fk_unsigned_bs_xls_fmfiles__fk_fmfolders ON bs_fk_unsigned_bs_xls_fmfiles.`file_manager_folder_id` = bs_fk_unsigned_bs_xls_fmfiles__fk_fmfolders.`id`
			if (isset($row['bs_fk_unsigned_bs_xls_fmfiles__fk_fmfolders__file_manager_folder_id'])) {
				$file_manager_folder_id = $row['bs_fk_unsigned_bs_xls_fmfiles__fk_fmfolders__file_manager_folder_id'];
				$row['bs_fk_unsigned_bs_xls_fmfiles__fk_fmfolders__id'] = $file_manager_folder_id;
				$unsignedBidSpreadXlsFileManagerFolder = self::instantiateOrm($database, 'FileManagerFolder', $row, null, $file_manager_folder_id, 'bs_fk_unsigned_bs_xls_fmfiles__fk_fmfolders__');
				/* @var $unsignedBidSpreadXlsFileManagerFolder FileManagerFolder */
				$unsignedBidSpreadXlsFileManagerFolder->convertPropertiesToData();
			} else {
				$unsignedBidSpreadXlsFileManagerFolder = false;
			}
			$bidSpread->setUnsignedBidSpreadXlsFileManagerFolder($unsignedBidSpreadXlsFileManagerFolder);

			// LEFT OUTER JOIN `file_manager_folders` bs_fk_signed_bs_xls_fmfiles__fk_fmfolders ON bs_fk_signed_bs_xls_fmfiles.`file_manager_folder_id` = bs_fk_signed_bs_xls_fmfiles__fk_fmfolders.`id`
			if (isset($row['bs_fk_signed_bs_xls_fmfiles__fk_fmfolders__file_manager_folder_id'])) {
				$file_manager_folder_id = $row['bs_fk_signed_bs_xls_fmfiles__fk_fmfolders__file_manager_folder_id'];
				$row['bs_fk_signed_bs_xls_fmfiles__fk_fmfolders__id'] = $file_manager_folder_id;
				$signedBidSpreadXlsFileManagerFolder = self::instantiateOrm($database, 'FileManagerFolder', $row, null, $file_manager_folder_id, 'bs_fk_signed_bs_xls_fmfiles__fk_fmfolders__');
				/* @var $signedBidSpreadXlsFileManagerFolder FileManagerFolder */
				$signedBidSpreadXlsFileManagerFolder->convertPropertiesToData();
			} else {
				$signedBidSpreadXlsFileManagerFolder = false;
			}
			$bidSpread->setSignedBidSpreadXlsFileManagerFolder($signedBidSpreadXlsFileManagerFolder);

			$arrBidSpreadsByGcBudgetLineItemId[$bid_spread_id] = $bidSpread;
		}

		$db->free_result();

		self::$_arrBidSpreadsByGcBudgetLineItemId = $arrBidSpreadsByGcBudgetLineItemId;

		return $arrBidSpreadsByGcBudgetLineItemId;
	}

	/**
	 * Load by constraint `bid_spreads_fk_bss` foreign key (`bid_spread_status_id`) references `bid_spread_statuses` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $bid_spread_status_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadBidSpreadsByBidSpreadStatusId($database, $bid_spread_status_id, Input $options=null)
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
			self::$_arrBidSpreadsByBidSpreadStatusId = null;
		}

		$arrBidSpreadsByBidSpreadStatusId = self::$_arrBidSpreadsByBidSpreadStatusId;
		if (isset($arrBidSpreadsByBidSpreadStatusId) && !empty($arrBidSpreadsByBidSpreadStatusId)) {
			return $arrBidSpreadsByBidSpreadStatusId;
		}

		$bid_spread_status_id = (int) $bid_spread_status_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `gc_budget_line_item_id` ASC, `bid_spread_sequence_number` ASC, `bid_spread_status_id` ASC, `bid_spreadsheet_data_sha1` ASC, `bid_spread_submitter_gc_project_manager_contact_id` ASC, `bid_spread_approver_gc_project_executive_contact_id` ASC, `bid_spread_bid_total` ASC, `bid_spread_approved_value` ASC, `unsigned_bid_spread_pdf_file_manager_file_id` ASC, `signed_bid_spread_pdf_file_manager_file_id` ASC, `unsigned_bid_spread_xls_file_manager_file_id` ASC, `signed_bid_spread_xls_file_manager_file_id` ASC, `modified` ASC, `created` ASC, `display_linked_cost_codes_flag` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY bs.`bid_spread_sequence_number` DESC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpBidSpread = new BidSpread($database);
			$sqlOrderByColumns = $tmpBidSpread->constructSqlOrderByColumns($arrOrderByAttributes);

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
	bs.*

FROM `bid_spreads` bs
WHERE bs.`bid_spread_status_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `gc_budget_line_item_id` ASC, `bid_spread_sequence_number` ASC, `bid_spread_status_id` ASC, `bid_spreadsheet_data_sha1` ASC, `bid_spread_submitter_gc_project_manager_contact_id` ASC, `bid_spread_approver_gc_project_executive_contact_id` ASC, `bid_spread_bid_total` ASC, `bid_spread_approved_value` ASC, `unsigned_bid_spread_pdf_file_manager_file_id` ASC, `signed_bid_spread_pdf_file_manager_file_id` ASC, `unsigned_bid_spread_xls_file_manager_file_id` ASC, `signed_bid_spread_xls_file_manager_file_id` ASC, `modified` ASC, `created` ASC, `display_linked_cost_codes_flag` ASC, `sort_order` ASC
		$arrValues = array($bid_spread_status_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrBidSpreadsByBidSpreadStatusId = array();
		while ($row = $db->fetch()) {
			$bid_spread_id = $row['id'];
			$bidSpread = self::instantiateOrm($database, 'BidSpread', $row, null, $bid_spread_id);
			/* @var $bidSpread BidSpread */
			$arrBidSpreadsByBidSpreadStatusId[$bid_spread_id] = $bidSpread;
		}

		$db->free_result();

		self::$_arrBidSpreadsByBidSpreadStatusId = $arrBidSpreadsByBidSpreadStatusId;

		return $arrBidSpreadsByBidSpreadStatusId;
	}

	/**
	 * Load by constraint `bid_spreads_fk_submitter_gc_project_manager_c` foreign key (`bid_spread_submitter_gc_project_manager_contact_id`) references `contacts` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $bid_spread_submitter_gc_project_manager_contact_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadBidSpreadsByBidSpreadSubmitterGcProjectManagerContactId($database, $bid_spread_submitter_gc_project_manager_contact_id, Input $options=null)
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
			self::$_arrBidSpreadsByBidSpreadSubmitterGcProjectManagerContactId = null;
		}

		$arrBidSpreadsByBidSpreadSubmitterGcProjectManagerContactId = self::$_arrBidSpreadsByBidSpreadSubmitterGcProjectManagerContactId;
		if (isset($arrBidSpreadsByBidSpreadSubmitterGcProjectManagerContactId) && !empty($arrBidSpreadsByBidSpreadSubmitterGcProjectManagerContactId)) {
			return $arrBidSpreadsByBidSpreadSubmitterGcProjectManagerContactId;
		}

		$bid_spread_submitter_gc_project_manager_contact_id = (int) $bid_spread_submitter_gc_project_manager_contact_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `gc_budget_line_item_id` ASC, `bid_spread_sequence_number` ASC, `bid_spread_status_id` ASC, `bid_spreadsheet_data_sha1` ASC, `bid_spread_submitter_gc_project_manager_contact_id` ASC, `bid_spread_approver_gc_project_executive_contact_id` ASC, `bid_spread_bid_total` ASC, `bid_spread_approved_value` ASC, `unsigned_bid_spread_pdf_file_manager_file_id` ASC, `signed_bid_spread_pdf_file_manager_file_id` ASC, `unsigned_bid_spread_xls_file_manager_file_id` ASC, `signed_bid_spread_xls_file_manager_file_id` ASC, `modified` ASC, `created` ASC, `display_linked_cost_codes_flag` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY bs.`bid_spread_sequence_number` DESC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpBidSpread = new BidSpread($database);
			$sqlOrderByColumns = $tmpBidSpread->constructSqlOrderByColumns($arrOrderByAttributes);

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
	bs.*

FROM `bid_spreads` bs
WHERE bs.`bid_spread_submitter_gc_project_manager_contact_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `gc_budget_line_item_id` ASC, `bid_spread_sequence_number` ASC, `bid_spread_status_id` ASC, `bid_spreadsheet_data_sha1` ASC, `bid_spread_submitter_gc_project_manager_contact_id` ASC, `bid_spread_approver_gc_project_executive_contact_id` ASC, `bid_spread_bid_total` ASC, `bid_spread_approved_value` ASC, `unsigned_bid_spread_pdf_file_manager_file_id` ASC, `signed_bid_spread_pdf_file_manager_file_id` ASC, `unsigned_bid_spread_xls_file_manager_file_id` ASC, `signed_bid_spread_xls_file_manager_file_id` ASC, `modified` ASC, `created` ASC, `display_linked_cost_codes_flag` ASC, `sort_order` ASC
		$arrValues = array($bid_spread_submitter_gc_project_manager_contact_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrBidSpreadsByBidSpreadSubmitterGcProjectManagerContactId = array();
		while ($row = $db->fetch()) {
			$bid_spread_id = $row['id'];
			$bidSpread = self::instantiateOrm($database, 'BidSpread', $row, null, $bid_spread_id);
			/* @var $bidSpread BidSpread */
			$arrBidSpreadsByBidSpreadSubmitterGcProjectManagerContactId[$bid_spread_id] = $bidSpread;
		}

		$db->free_result();

		self::$_arrBidSpreadsByBidSpreadSubmitterGcProjectManagerContactId = $arrBidSpreadsByBidSpreadSubmitterGcProjectManagerContactId;

		return $arrBidSpreadsByBidSpreadSubmitterGcProjectManagerContactId;
	}

	/**
	 * Load by constraint `bid_spreads_fk_approver_gc_project_executive_c` foreign key (`bid_spread_approver_gc_project_executive_contact_id`) references `contacts` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $bid_spread_approver_gc_project_executive_contact_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadBidSpreadsByBidSpreadApproverGcProjectExecutiveContactId($database, $bid_spread_approver_gc_project_executive_contact_id, Input $options=null)
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
			self::$_arrBidSpreadsByBidSpreadApproverGcProjectExecutiveContactId = null;
		}

		$arrBidSpreadsByBidSpreadApproverGcProjectExecutiveContactId = self::$_arrBidSpreadsByBidSpreadApproverGcProjectExecutiveContactId;
		if (isset($arrBidSpreadsByBidSpreadApproverGcProjectExecutiveContactId) && !empty($arrBidSpreadsByBidSpreadApproverGcProjectExecutiveContactId)) {
			return $arrBidSpreadsByBidSpreadApproverGcProjectExecutiveContactId;
		}

		$bid_spread_approver_gc_project_executive_contact_id = (int) $bid_spread_approver_gc_project_executive_contact_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `gc_budget_line_item_id` ASC, `bid_spread_sequence_number` ASC, `bid_spread_status_id` ASC, `bid_spreadsheet_data_sha1` ASC, `bid_spread_submitter_gc_project_manager_contact_id` ASC, `bid_spread_approver_gc_project_executive_contact_id` ASC, `bid_spread_bid_total` ASC, `bid_spread_approved_value` ASC, `unsigned_bid_spread_pdf_file_manager_file_id` ASC, `signed_bid_spread_pdf_file_manager_file_id` ASC, `unsigned_bid_spread_xls_file_manager_file_id` ASC, `signed_bid_spread_xls_file_manager_file_id` ASC, `modified` ASC, `created` ASC, `display_linked_cost_codes_flag` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY bs.`bid_spread_sequence_number` DESC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpBidSpread = new BidSpread($database);
			$sqlOrderByColumns = $tmpBidSpread->constructSqlOrderByColumns($arrOrderByAttributes);

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
	bs.*

FROM `bid_spreads` bs
WHERE bs.`bid_spread_approver_gc_project_executive_contact_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `gc_budget_line_item_id` ASC, `bid_spread_sequence_number` ASC, `bid_spread_status_id` ASC, `bid_spreadsheet_data_sha1` ASC, `bid_spread_submitter_gc_project_manager_contact_id` ASC, `bid_spread_approver_gc_project_executive_contact_id` ASC, `bid_spread_bid_total` ASC, `bid_spread_approved_value` ASC, `unsigned_bid_spread_pdf_file_manager_file_id` ASC, `signed_bid_spread_pdf_file_manager_file_id` ASC, `unsigned_bid_spread_xls_file_manager_file_id` ASC, `signed_bid_spread_xls_file_manager_file_id` ASC, `modified` ASC, `created` ASC, `display_linked_cost_codes_flag` ASC, `sort_order` ASC
		$arrValues = array($bid_spread_approver_gc_project_executive_contact_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrBidSpreadsByBidSpreadApproverGcProjectExecutiveContactId = array();
		while ($row = $db->fetch()) {
			$bid_spread_id = $row['id'];
			$bidSpread = self::instantiateOrm($database, 'BidSpread', $row, null, $bid_spread_id);
			/* @var $bidSpread BidSpread */
			$arrBidSpreadsByBidSpreadApproverGcProjectExecutiveContactId[$bid_spread_id] = $bidSpread;
		}

		$db->free_result();

		self::$_arrBidSpreadsByBidSpreadApproverGcProjectExecutiveContactId = $arrBidSpreadsByBidSpreadApproverGcProjectExecutiveContactId;

		return $arrBidSpreadsByBidSpreadApproverGcProjectExecutiveContactId;
	}

	/**
	 * Load by constraint `bid_spreads_fk_unsigned_bs_pdf_fmfiles` foreign key (`unsigned_bid_spread_pdf_file_manager_file_id`) references `file_manager_files` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $unsigned_bid_spread_pdf_file_manager_file_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadBidSpreadsByUnsignedBidSpreadPdfFileManagerFileId($database, $unsigned_bid_spread_pdf_file_manager_file_id, Input $options=null)
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
			self::$_arrBidSpreadsByUnsignedBidSpreadPdfFileManagerFileId = null;
		}

		$arrBidSpreadsByUnsignedBidSpreadPdfFileManagerFileId = self::$_arrBidSpreadsByUnsignedBidSpreadPdfFileManagerFileId;
		if (isset($arrBidSpreadsByUnsignedBidSpreadPdfFileManagerFileId) && !empty($arrBidSpreadsByUnsignedBidSpreadPdfFileManagerFileId)) {
			return $arrBidSpreadsByUnsignedBidSpreadPdfFileManagerFileId;
		}

		$unsigned_bid_spread_pdf_file_manager_file_id = (int) $unsigned_bid_spread_pdf_file_manager_file_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `gc_budget_line_item_id` ASC, `bid_spread_sequence_number` ASC, `bid_spread_status_id` ASC, `bid_spreadsheet_data_sha1` ASC, `bid_spread_submitter_gc_project_manager_contact_id` ASC, `bid_spread_approver_gc_project_executive_contact_id` ASC, `bid_spread_bid_total` ASC, `bid_spread_approved_value` ASC, `unsigned_bid_spread_pdf_file_manager_file_id` ASC, `signed_bid_spread_pdf_file_manager_file_id` ASC, `unsigned_bid_spread_xls_file_manager_file_id` ASC, `signed_bid_spread_xls_file_manager_file_id` ASC, `modified` ASC, `created` ASC, `display_linked_cost_codes_flag` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY bs.`bid_spread_sequence_number` DESC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpBidSpread = new BidSpread($database);
			$sqlOrderByColumns = $tmpBidSpread->constructSqlOrderByColumns($arrOrderByAttributes);

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
	bs.*

FROM `bid_spreads` bs
WHERE bs.`unsigned_bid_spread_pdf_file_manager_file_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `gc_budget_line_item_id` ASC, `bid_spread_sequence_number` ASC, `bid_spread_status_id` ASC, `bid_spreadsheet_data_sha1` ASC, `bid_spread_submitter_gc_project_manager_contact_id` ASC, `bid_spread_approver_gc_project_executive_contact_id` ASC, `bid_spread_bid_total` ASC, `bid_spread_approved_value` ASC, `unsigned_bid_spread_pdf_file_manager_file_id` ASC, `signed_bid_spread_pdf_file_manager_file_id` ASC, `unsigned_bid_spread_xls_file_manager_file_id` ASC, `signed_bid_spread_xls_file_manager_file_id` ASC, `modified` ASC, `created` ASC, `display_linked_cost_codes_flag` ASC, `sort_order` ASC
		$arrValues = array($unsigned_bid_spread_pdf_file_manager_file_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrBidSpreadsByUnsignedBidSpreadPdfFileManagerFileId = array();
		while ($row = $db->fetch()) {
			$bid_spread_id = $row['id'];
			$bidSpread = self::instantiateOrm($database, 'BidSpread', $row, null, $bid_spread_id);
			/* @var $bidSpread BidSpread */
			$arrBidSpreadsByUnsignedBidSpreadPdfFileManagerFileId[$bid_spread_id] = $bidSpread;
		}

		$db->free_result();

		self::$_arrBidSpreadsByUnsignedBidSpreadPdfFileManagerFileId = $arrBidSpreadsByUnsignedBidSpreadPdfFileManagerFileId;

		return $arrBidSpreadsByUnsignedBidSpreadPdfFileManagerFileId;
	}

	/**
	 * Load by constraint `bid_spreads_fk_signed_bs_pdf_fmfiles` foreign key (`signed_bid_spread_pdf_file_manager_file_id`) references `file_manager_files` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $signed_bid_spread_pdf_file_manager_file_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadBidSpreadsBySignedBidSpreadPdfFileManagerFileId($database, $signed_bid_spread_pdf_file_manager_file_id, Input $options=null)
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
			self::$_arrBidSpreadsBySignedBidSpreadPdfFileManagerFileId = null;
		}

		$arrBidSpreadsBySignedBidSpreadPdfFileManagerFileId = self::$_arrBidSpreadsBySignedBidSpreadPdfFileManagerFileId;
		if (isset($arrBidSpreadsBySignedBidSpreadPdfFileManagerFileId) && !empty($arrBidSpreadsBySignedBidSpreadPdfFileManagerFileId)) {
			return $arrBidSpreadsBySignedBidSpreadPdfFileManagerFileId;
		}

		$signed_bid_spread_pdf_file_manager_file_id = (int) $signed_bid_spread_pdf_file_manager_file_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `gc_budget_line_item_id` ASC, `bid_spread_sequence_number` ASC, `bid_spread_status_id` ASC, `bid_spreadsheet_data_sha1` ASC, `bid_spread_submitter_gc_project_manager_contact_id` ASC, `bid_spread_approver_gc_project_executive_contact_id` ASC, `bid_spread_bid_total` ASC, `bid_spread_approved_value` ASC, `unsigned_bid_spread_pdf_file_manager_file_id` ASC, `signed_bid_spread_pdf_file_manager_file_id` ASC, `unsigned_bid_spread_xls_file_manager_file_id` ASC, `signed_bid_spread_xls_file_manager_file_id` ASC, `modified` ASC, `created` ASC, `display_linked_cost_codes_flag` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY bs.`bid_spread_sequence_number` DESC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpBidSpread = new BidSpread($database);
			$sqlOrderByColumns = $tmpBidSpread->constructSqlOrderByColumns($arrOrderByAttributes);

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
	bs.*

FROM `bid_spreads` bs
WHERE bs.`signed_bid_spread_pdf_file_manager_file_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `gc_budget_line_item_id` ASC, `bid_spread_sequence_number` ASC, `bid_spread_status_id` ASC, `bid_spreadsheet_data_sha1` ASC, `bid_spread_submitter_gc_project_manager_contact_id` ASC, `bid_spread_approver_gc_project_executive_contact_id` ASC, `bid_spread_bid_total` ASC, `bid_spread_approved_value` ASC, `unsigned_bid_spread_pdf_file_manager_file_id` ASC, `signed_bid_spread_pdf_file_manager_file_id` ASC, `unsigned_bid_spread_xls_file_manager_file_id` ASC, `signed_bid_spread_xls_file_manager_file_id` ASC, `modified` ASC, `created` ASC, `display_linked_cost_codes_flag` ASC, `sort_order` ASC
		$arrValues = array($signed_bid_spread_pdf_file_manager_file_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrBidSpreadsBySignedBidSpreadPdfFileManagerFileId = array();
		while ($row = $db->fetch()) {
			$bid_spread_id = $row['id'];
			$bidSpread = self::instantiateOrm($database, 'BidSpread', $row, null, $bid_spread_id);
			/* @var $bidSpread BidSpread */
			$arrBidSpreadsBySignedBidSpreadPdfFileManagerFileId[$bid_spread_id] = $bidSpread;
		}

		$db->free_result();

		self::$_arrBidSpreadsBySignedBidSpreadPdfFileManagerFileId = $arrBidSpreadsBySignedBidSpreadPdfFileManagerFileId;

		return $arrBidSpreadsBySignedBidSpreadPdfFileManagerFileId;
	}

	/**
	 * Load by constraint `bid_spreads_fk_unsigned_bs_xls_fmfiles` foreign key (`unsigned_bid_spread_xls_file_manager_file_id`) references `file_manager_files` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $unsigned_bid_spread_xls_file_manager_file_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadBidSpreadsByUnsignedBidSpreadXlsFileManagerFileId($database, $unsigned_bid_spread_xls_file_manager_file_id, Input $options=null)
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
			self::$_arrBidSpreadsByUnsignedBidSpreadXlsFileManagerFileId = null;
		}

		$arrBidSpreadsByUnsignedBidSpreadXlsFileManagerFileId = self::$_arrBidSpreadsByUnsignedBidSpreadXlsFileManagerFileId;
		if (isset($arrBidSpreadsByUnsignedBidSpreadXlsFileManagerFileId) && !empty($arrBidSpreadsByUnsignedBidSpreadXlsFileManagerFileId)) {
			return $arrBidSpreadsByUnsignedBidSpreadXlsFileManagerFileId;
		}

		$unsigned_bid_spread_xls_file_manager_file_id = (int) $unsigned_bid_spread_xls_file_manager_file_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `gc_budget_line_item_id` ASC, `bid_spread_sequence_number` ASC, `bid_spread_status_id` ASC, `bid_spreadsheet_data_sha1` ASC, `bid_spread_submitter_gc_project_manager_contact_id` ASC, `bid_spread_approver_gc_project_executive_contact_id` ASC, `bid_spread_bid_total` ASC, `bid_spread_approved_value` ASC, `unsigned_bid_spread_pdf_file_manager_file_id` ASC, `signed_bid_spread_pdf_file_manager_file_id` ASC, `unsigned_bid_spread_xls_file_manager_file_id` ASC, `signed_bid_spread_xls_file_manager_file_id` ASC, `modified` ASC, `created` ASC, `display_linked_cost_codes_flag` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY bs.`bid_spread_sequence_number` DESC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpBidSpread = new BidSpread($database);
			$sqlOrderByColumns = $tmpBidSpread->constructSqlOrderByColumns($arrOrderByAttributes);

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
	bs.*

FROM `bid_spreads` bs
WHERE bs.`unsigned_bid_spread_xls_file_manager_file_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `gc_budget_line_item_id` ASC, `bid_spread_sequence_number` ASC, `bid_spread_status_id` ASC, `bid_spreadsheet_data_sha1` ASC, `bid_spread_submitter_gc_project_manager_contact_id` ASC, `bid_spread_approver_gc_project_executive_contact_id` ASC, `bid_spread_bid_total` ASC, `bid_spread_approved_value` ASC, `unsigned_bid_spread_pdf_file_manager_file_id` ASC, `signed_bid_spread_pdf_file_manager_file_id` ASC, `unsigned_bid_spread_xls_file_manager_file_id` ASC, `signed_bid_spread_xls_file_manager_file_id` ASC, `modified` ASC, `created` ASC, `display_linked_cost_codes_flag` ASC, `sort_order` ASC
		$arrValues = array($unsigned_bid_spread_xls_file_manager_file_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrBidSpreadsByUnsignedBidSpreadXlsFileManagerFileId = array();
		while ($row = $db->fetch()) {
			$bid_spread_id = $row['id'];
			$bidSpread = self::instantiateOrm($database, 'BidSpread', $row, null, $bid_spread_id);
			/* @var $bidSpread BidSpread */
			$arrBidSpreadsByUnsignedBidSpreadXlsFileManagerFileId[$bid_spread_id] = $bidSpread;
		}

		$db->free_result();

		self::$_arrBidSpreadsByUnsignedBidSpreadXlsFileManagerFileId = $arrBidSpreadsByUnsignedBidSpreadXlsFileManagerFileId;

		return $arrBidSpreadsByUnsignedBidSpreadXlsFileManagerFileId;
	}

	/**
	 * Load by constraint `bid_spreads_fk_signed_bs_xls_fmfiles` foreign key (`signed_bid_spread_xls_file_manager_file_id`) references `file_manager_files` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $signed_bid_spread_xls_file_manager_file_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadBidSpreadsBySignedBidSpreadXlsFileManagerFileId($database, $signed_bid_spread_xls_file_manager_file_id, Input $options=null)
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
			self::$_arrBidSpreadsBySignedBidSpreadXlsFileManagerFileId = null;
		}

		$arrBidSpreadsBySignedBidSpreadXlsFileManagerFileId = self::$_arrBidSpreadsBySignedBidSpreadXlsFileManagerFileId;
		if (isset($arrBidSpreadsBySignedBidSpreadXlsFileManagerFileId) && !empty($arrBidSpreadsBySignedBidSpreadXlsFileManagerFileId)) {
			return $arrBidSpreadsBySignedBidSpreadXlsFileManagerFileId;
		}

		$signed_bid_spread_xls_file_manager_file_id = (int) $signed_bid_spread_xls_file_manager_file_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `gc_budget_line_item_id` ASC, `bid_spread_sequence_number` ASC, `bid_spread_status_id` ASC, `bid_spreadsheet_data_sha1` ASC, `bid_spread_submitter_gc_project_manager_contact_id` ASC, `bid_spread_approver_gc_project_executive_contact_id` ASC, `bid_spread_bid_total` ASC, `bid_spread_approved_value` ASC, `unsigned_bid_spread_pdf_file_manager_file_id` ASC, `signed_bid_spread_pdf_file_manager_file_id` ASC, `unsigned_bid_spread_xls_file_manager_file_id` ASC, `signed_bid_spread_xls_file_manager_file_id` ASC, `modified` ASC, `created` ASC, `display_linked_cost_codes_flag` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY bs.`bid_spread_sequence_number` DESC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpBidSpread = new BidSpread($database);
			$sqlOrderByColumns = $tmpBidSpread->constructSqlOrderByColumns($arrOrderByAttributes);

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
	bs.*

FROM `bid_spreads` bs
WHERE bs.`signed_bid_spread_xls_file_manager_file_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `gc_budget_line_item_id` ASC, `bid_spread_sequence_number` ASC, `bid_spread_status_id` ASC, `bid_spreadsheet_data_sha1` ASC, `bid_spread_submitter_gc_project_manager_contact_id` ASC, `bid_spread_approver_gc_project_executive_contact_id` ASC, `bid_spread_bid_total` ASC, `bid_spread_approved_value` ASC, `unsigned_bid_spread_pdf_file_manager_file_id` ASC, `signed_bid_spread_pdf_file_manager_file_id` ASC, `unsigned_bid_spread_xls_file_manager_file_id` ASC, `signed_bid_spread_xls_file_manager_file_id` ASC, `modified` ASC, `created` ASC, `display_linked_cost_codes_flag` ASC, `sort_order` ASC
		$arrValues = array($signed_bid_spread_xls_file_manager_file_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrBidSpreadsBySignedBidSpreadXlsFileManagerFileId = array();
		while ($row = $db->fetch()) {
			$bid_spread_id = $row['id'];
			$bidSpread = self::instantiateOrm($database, 'BidSpread', $row, null, $bid_spread_id);
			/* @var $bidSpread BidSpread */
			$arrBidSpreadsBySignedBidSpreadXlsFileManagerFileId[$bid_spread_id] = $bidSpread;
		}

		$db->free_result();

		self::$_arrBidSpreadsBySignedBidSpreadXlsFileManagerFileId = $arrBidSpreadsBySignedBidSpreadXlsFileManagerFileId;

		return $arrBidSpreadsBySignedBidSpreadXlsFileManagerFileId;
	}

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all bid_spreads records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllBidSpreads($database, Input $options=null)
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
			self::$_arrAllBidSpreads = null;
		}

		$arrAllBidSpreads = self::$_arrAllBidSpreads;
		if (isset($arrAllBidSpreads) && !empty($arrAllBidSpreads)) {
			return $arrAllBidSpreads;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `gc_budget_line_item_id` ASC, `bid_spread_sequence_number` ASC, `bid_spread_status_id` ASC, `bid_spreadsheet_data_sha1` ASC, `bid_spread_submitter_gc_project_manager_contact_id` ASC, `bid_spread_approver_gc_project_executive_contact_id` ASC, `bid_spread_bid_total` ASC, `bid_spread_approved_value` ASC, `unsigned_bid_spread_pdf_file_manager_file_id` ASC, `signed_bid_spread_pdf_file_manager_file_id` ASC, `unsigned_bid_spread_xls_file_manager_file_id` ASC, `signed_bid_spread_xls_file_manager_file_id` ASC, `modified` ASC, `created` ASC, `display_linked_cost_codes_flag` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY bs.`bid_spread_sequence_number` DESC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpBidSpread = new BidSpread($database);
			$sqlOrderByColumns = $tmpBidSpread->constructSqlOrderByColumns($arrOrderByAttributes);

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
	bs.*

FROM `bid_spreads` bs{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `gc_budget_line_item_id` ASC, `bid_spread_sequence_number` ASC, `bid_spread_status_id` ASC, `bid_spreadsheet_data_sha1` ASC, `bid_spread_submitter_gc_project_manager_contact_id` ASC, `bid_spread_approver_gc_project_executive_contact_id` ASC, `bid_spread_bid_total` ASC, `bid_spread_approved_value` ASC, `unsigned_bid_spread_pdf_file_manager_file_id` ASC, `signed_bid_spread_pdf_file_manager_file_id` ASC, `unsigned_bid_spread_xls_file_manager_file_id` ASC, `signed_bid_spread_xls_file_manager_file_id` ASC, `modified` ASC, `created` ASC, `display_linked_cost_codes_flag` ASC, `sort_order` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllBidSpreads = array();
		while ($row = $db->fetch()) {
			$bid_spread_id = $row['id'];
			$bidSpread = self::instantiateOrm($database, 'BidSpread', $row, null, $bid_spread_id);
			/* @var $bidSpread BidSpread */
			$arrAllBidSpreads[$bid_spread_id] = $bidSpread;
		}

		$db->free_result();

		self::$_arrAllBidSpreads = $arrAllBidSpreads;

		return $arrAllBidSpreads;
	}

	// Save: insert on duplicate key update

	// Save: insert ignore

	/**
	 * Find next_bid_spread_sequence_number value.
	 *
	 * @param string $database
	 * @param int $user_company_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findNextBidSpreadSequenceNumber($database, $gc_budget_line_item_id)
	{
		$next_bid_spread_sequence_number = 1;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT MAX(s.bid_spread_sequence_number) AS 'max_bid_spread_sequence_number'
FROM `bid_spreads` s
WHERE s.`gc_budget_line_item_id` = ?
";
		$arrValues = array($gc_budget_line_item_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$max_bid_spread_sequence_number = $row['max_bid_spread_sequence_number'];
			$next_bid_spread_sequence_number = $max_bid_spread_sequence_number + 1;
		}

		return $next_bid_spread_sequence_number;
	}

	public static function loadBidSpreadsByGcBudgetLineItemIdOrganizedByBidSpreadStatus($database, $gc_budget_line_item_id)
	{
		$options = new Input();
		$options->forceLoadFlag = true;
		$arrBidSpreadsByGcBudgetLineItemId = BidSpread::loadBidSpreadsByGcBudgetLineItemId($database, $gc_budget_line_item_id, $options);
		$arrBidSpreadsByGcBudgetLineItemId = array_reverse($arrBidSpreadsByGcBudgetLineItemId);

		$arrBidSpreadsByAnalysisInProcessStatus = array();
		$arrBidSpreadsBySubmittedForApprovalStatus = array();
		$arrBidSpreadsByApprovedStatus = array();
		$arrBidSpreadsByApprovedWithNoExceptionsStatus = array();
		$arrBidSpreadsByApprovedWithNotesStatus = array();
		$arrBidSpreadsByRejectedStatus = array();

		foreach ($arrBidSpreadsByGcBudgetLineItemId as $bid_spread_id => $bidSpread) {
			/* @var $bidSpread BidSpread */

			if (empty($bidSpread->bid_spreadsheet_data_sha1)) {
				// Continue since it is just a workflow "Spread" placeholder with no PDF
				continue;
			}

			$bidSpreadStatus = $bidSpread->getBidSpreadStatus();
			/* @var $bidSpreadStatus BidSpreadStatus */

			$bid_spread_status = $bidSpreadStatus->bid_spread_status;

			if ($bid_spread_status == 'Analysis In Process') {

				$arrBidSpreadsByAnalysisInProcessStatus[] = $bidSpread;

			} elseif ($bid_spread_status == 'Submitted for Approval') {

				$arrBidSpreadsBySubmittedForApprovalStatus[] = $bidSpread;

			} elseif ($bid_spread_status == 'Approved') {

				$arrBidSpreadsByApprovedStatus[] = $bidSpread;

			} elseif ($bid_spread_status == 'Approved with No Exceptions') {

				$arrBidSpreadsByApprovedWithNoExceptionsStatus[] = $bidSpread;

			} elseif ($bid_spread_status == 'Approved with Notes') {

				$arrBidSpreadsByApprovedWithNotesStatus[] = $bidSpread;

			} elseif ($bid_spread_status == 'Rejected') {

				$arrBidSpreadsByRejectedStatus[] = $bidSpread;

			}

		}

		$arrReturn = array(
			'arrBidSpreadsByAnalysisInProcessStatus' => $arrBidSpreadsByAnalysisInProcessStatus,
			'arrBidSpreadsBySubmittedForApprovalStatus' => $arrBidSpreadsBySubmittedForApprovalStatus,
			'arrBidSpreadsByApprovedStatus' => $arrBidSpreadsByApprovedStatus,
			'arrBidSpreadsByApprovedWithNoExceptionsStatus' => $arrBidSpreadsByApprovedWithNoExceptionsStatus,
			'arrBidSpreadsByApprovedWithNotesStatus' => $arrBidSpreadsByApprovedWithNotesStatus,
			'arrBidSpreadsByRejectedStatus' => $arrBidSpreadsByRejectedStatus,
		);

		return $arrReturn;
	}
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

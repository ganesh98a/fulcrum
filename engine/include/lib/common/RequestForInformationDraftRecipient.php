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
 * RequestForInformationDraftRecipient.
 *
 * @category   Framework
 * @package    RequestForInformationDraftRecipient
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class RequestForInformationDraftRecipient extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'RequestForInformationDraftRecipient';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'request_for_information_draft_recipients';

	/**
	 * primary key (`request_for_information_draft_id`,`rfi_additional_recipient_contact_id`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrPrimaryKey = array(
		'request_for_information_draft_id' => 'int',
		'rfi_additional_recipient_contact_id' => 'int'
	);

	/**
	 * No Unique Indexes, Just a Primary Key
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_request_for_information_draft_recipient_via_primary_key' => array(
			'request_for_information_draft_id' => 'int',
			'rfi_additional_recipient_contact_id' => 'int'
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
		'request_for_information_draft_id' => 'request_for_information_draft_id',
		'rfi_additional_recipient_contact_id' => 'rfi_additional_recipient_contact_id',
		'smtp_recipient_header_type' => 'smtp_recipient_header_type'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $request_for_information_draft_id;
	public $rfi_additional_recipient_contact_id;
	public $smtp_recipient_header_type;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties

	// HTML ENTITY ENCODED NL2BR ORM string properties

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)
	protected static $_arrRequestForInformationRecipientsByRequestForInformationDraftId;


	// Foreign Key Objects
	private $_requestForInformationDraft;
	private $_rfiAdditionalRecipientContact;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='request_for_information_draft_recipients')
	{
		parent::__construct($table);
		$this->setDatabase($database);
	}


	public function setRequestForInformationDraft($requestForInformationDraft)
	{
		$this->_requestForInformationDraft = $requestForInformationDraft;
	}


	public function setRfiAdditionalRecipientContact($rfiAdditionalRecipientContact)
	{
		$this->_rfiAdditionalRecipientContact = $rfiAdditionalRecipientContact;
	}


	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `request_for_information_draft_recipients_fk_rfin` foreign key (`request_for_information_draft_id`) references `request_for_information_drafts` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $request_for_information_draft_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadRequestForInformationRecipientsByRequestForInformationDraftId($database, $request_for_information_draft_id, Input $options=null)
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
			self::$_arrRequestForInformationRecipientsByRequestForInformationDraftId = null;
		}

		$arrRequestForInformationRecipientsByRequestForInformationDraftId = self::$_arrRequestForInformationRecipientsByRequestForInformationDraftId;
		if (isset($arrRequestForInformationRecipientsByRequestForInformationDraftId) && !empty($arrRequestForInformationRecipientsByRequestForInformationDraftId)) {
			return $arrRequestForInformationRecipientsByRequestForInformationDraftId;
		}

		$request_for_information_draft_id = (int) $request_for_information_draft_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `request_for_information_draft_id` ASC, `rfi_additional_recipient_contact_id` ASC, `smtp_recipient_header_type` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpRequestForInformationRecipient = new RequestForInformationRecipient($database);
			$sqlOrderByColumns = $tmpRequestForInformationRecipient->constructSqlOrderByColumns($arrOrderByAttributes);

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

	rfida_fk_rfid.`id` AS 'rfida_fk_rfid__request_for_information_draft_id',

	rfir_fk_c.`id` AS 'rfir_fk_c__contact_id',
	rfir_fk_c.`user_company_id` AS 'rfir_fk_c__user_company_id',
	rfir_fk_c.`user_id` AS 'rfir_fk_c__user_id',
	rfir_fk_c.`contact_company_id` AS 'rfir_fk_c__contact_company_id',
	rfir_fk_c.`email` AS 'rfir_fk_c__email',
	rfir_fk_c.`name_prefix` AS 'rfir_fk_c__name_prefix',
	rfir_fk_c.`first_name` AS 'rfir_fk_c__first_name',
	rfir_fk_c.`additional_name` AS 'rfir_fk_c__additional_name',
	rfir_fk_c.`middle_name` AS 'rfir_fk_c__middle_name',
	rfir_fk_c.`last_name` AS 'rfir_fk_c__last_name',
	rfir_fk_c.`name_suffix` AS 'rfir_fk_c__name_suffix',
	rfir_fk_c.`title` AS 'rfir_fk_c__title',
	rfir_fk_c.`vendor_flag` AS 'rfir_fk_c__vendor_flag',

		rfir.*

	FROM `request_for_information_draft_recipients` rfir
	INNER JOIN `request_for_information_drafts` rfida_fk_rfid ON rfir.`request_for_information_draft_id` = rfida_fk_rfid.`id`
	INNER JOIN `contacts` rfir_fk_c ON rfir.`rfi_additional_recipient_contact_id` = rfir_fk_c.`id`
	WHERE rfir.`request_for_information_draft_id` = ?{$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array($request_for_information_draft_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$arrRequestForInformationRecipientsByRequestForInformationDraftId = array();
		while ($row = $db->fetch()) {
			$requestForInformationRecipient = self::instantiateOrm($database, 'RequestForInformationRecipient', $row);
			/* @var $requestForInformationRecipient RequestForInformationRecipient */
			$requestForInformationRecipient->convertPropertiesToData();

			if (isset($row['request_for_information_draft_id'])) {
				$request_for_information_draft_id = $row['request_for_information_draft_id'];
				$row['rfida_fk_rfid__id'] = $request_for_information_draft_id;
				$RequestForInformationDraft = self::instantiateOrm($database, 'RequestForInformationDraft', $row, null, $request_for_information_draft_id, 'rfida_fk_rfid__');
				/* @var $RequestForInformationDraft RequestForInformationDraft */
				$RequestForInformationDraft->convertPropertiesToData();
			} else {
				$RequestForInformationDraft = false;
			}
			$requestForInformationRecipient->setRequestForInformationDraft($RequestForInformationDraft);

			if (isset($row['rfi_additional_recipient_contact_id'])) {
				$rfi_additional_recipient_contact_id = $row['rfi_additional_recipient_contact_id'];
				$row['rfir_fk_c__id'] = $rfi_additional_recipient_contact_id;
				$rfiAdditionalRecipientContact = self::instantiateOrm($database, 'Contact', $row, null, $rfi_additional_recipient_contact_id, 'rfir_fk_c__');
				/* @var $rfiAdditionalRecipientContact Contact */
				$rfiAdditionalRecipientContact->convertPropertiesToData();
			} else {
				$rfiAdditionalRecipientContact = false;
			}
			$requestForInformationRecipient->setRfiAdditionalRecipientContact($rfiAdditionalRecipientContact);

			$arrRequestForInformationRecipientsByRequestForInformationDraftId[] = $requestForInformationRecipient;
		}

		$db->free_result();

		self::$_arrRequestForInformationRecipientsByRequestForInformationDraftId = $arrRequestForInformationRecipientsByRequestForInformationDraftId;

		return $arrRequestForInformationRecipientsByRequestForInformationDraftId;
	}

    //delete recipients
	public static function deletRecipients($database,$request_for_information_draft_id){
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
		"
		DELETE FROM
		`request_for_information_draft_recipients`
		WHERE `request_for_information_draft_id` = ?
		";
		$arrValues = array($request_for_information_draft_id);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$db->free_result();
	}
	//save cc recipients
	public static function saveToRecipients($database, $request_for_information_draft_id, $rfi_to_recipient_contact_ids){
		$db = DBI::getInstance($database);
		$arrRfiRecipientIds = explode(',', $rfi_to_recipient_contact_ids);
		foreach ($arrRfiRecipientIds as $key => $value) {
		  $requestForInformationDraftRecipient = new RequestForInformationDraftRecipient($database);
		  $ccRecipient['request_for_information_draft_id'] = $request_for_information_draft_id;
		  $ccRecipient['rfi_additional_recipient_contact_id'] = $value;
		  $ccRecipient['smtp_recipient_header_type'] = 'To';
		  $requestForInformationDraftRecipient->setData($ccRecipient);
		  $requestForInformationDraftRecipient->convertDataToProperties();
		  $requestForInformationDraftRecipient->save();
		}
	}

    //save cc recipients
	public static function saveCcRecipients($database, $request_for_information_draft_id, $rfi_cc_recipient_contact_ids){
		$db = DBI::getInstance($database);
		$arrRfiRecipientIds = explode(',', $rfi_cc_recipient_contact_ids);
		foreach ($arrRfiRecipientIds as $key => $value) {
		  $requestForInformationDraftRecipient = new RequestForInformationDraftRecipient($database);
		  $ccRecipient['request_for_information_draft_id'] = $request_for_information_draft_id;
		  $ccRecipient['rfi_additional_recipient_contact_id'] = $value;
		  $ccRecipient['smtp_recipient_header_type'] = 'Cc';
		  $requestForInformationDraftRecipient->setData($ccRecipient);
		  $requestForInformationDraftRecipient->convertDataToProperties();
		  $requestForInformationDraftRecipient->save();
		}
	}

    //save bcc recipients
	public static function saveBccRecipients($database, $request_for_information_draft_id, $rfi_bcc_recipient_contact_ids){
		$db = DBI::getInstance($database);
		$arrRfiBccRecipientIds = explode(',', $rfi_bcc_recipient_contact_ids);
		foreach ($arrRfiBccRecipientIds as $key => $value) {
		  $requestForInformationDraftRecipient = new RequestForInformationDraftRecipient($database);
		  $bccRecipient['request_for_information_draft_id'] = $request_for_information_draft_id;
		  $bccRecipient['rfi_additional_recipient_contact_id'] = $value;
		  $bccRecipient['smtp_recipient_header_type'] = 'Bcc';
		  $requestForInformationDraftRecipient->setData($bccRecipient);
		  $requestForInformationDraftRecipient->convertDataToProperties();
		  $requestForInformationDraftRecipient->save();
		}
	}
	//To fetch the draft recipient list
	public static function loadDraftRecipients($database, $request_for_information_draft_id)
	{
		$db = DBI::getInstance($database);
		$query =
	"
	SELECT

	rfida_fk_rfid.`id` AS 'rfida_fk_rfid__request_for_information_draft_id',

	rfir_fk_c.`id` AS 'rfir_fk_c__contact_id',
	rfir_fk_c.`user_company_id` AS 'rfir_fk_c__user_company_id',
	rfir_fk_c.`user_id` AS 'rfir_fk_c__user_id',
	rfir_fk_c.`contact_company_id` AS 'rfir_fk_c__contact_company_id',
	rfir_fk_c.`email` AS 'rfir_fk_c__email',
	rfir_fk_c.`name_prefix` AS 'rfir_fk_c__name_prefix',
	rfir_fk_c.`first_name` AS 'rfir_fk_c__first_name',
	rfir_fk_c.`additional_name` AS 'rfir_fk_c__additional_name',
	rfir_fk_c.`middle_name` AS 'rfir_fk_c__middle_name',
	rfir_fk_c.`last_name` AS 'rfir_fk_c__last_name',
	rfir_fk_c.`name_suffix` AS 'rfir_fk_c__name_suffix',
	rfir_fk_c.`title` AS 'rfir_fk_c__title',
	rfir_fk_c.`vendor_flag` AS 'rfir_fk_c__vendor_flag',

		rfir.*

	FROM `request_for_information_draft_recipients` rfir
	INNER JOIN `request_for_information_drafts` rfida_fk_rfid ON rfir.`request_for_information_draft_id` = rfida_fk_rfid.`id`
	INNER JOIN `contacts` rfir_fk_c ON rfir.`rfi_additional_recipient_contact_id` = rfir_fk_c.`id`
	WHERE rfir.`request_for_information_draft_id` = ?{$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array($request_for_information_draft_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$arrRequestForInformationRecipientsByRequestForInformationDraftId = array();
		while ($row = $db->fetch()) {
			$arrRequestForInformationRecipientsByRequestForInformationDraftId[] =$row;
		}
		return $arrRequestForInformationRecipientsByRequestForInformationDraftId;
	}
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

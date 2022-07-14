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
 * SubmittalDraftRecipient.
 *
 * @category   Framework
 * @package    SubmittalDraftRecipient
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class SubmittalDraftRecipient extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'SubmittalDraftRecipient';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'submittal_draft_recipients';

	/**
	 * primary key (`submittal_draft_id`,`su_additional_recipient_contact_id`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrPrimaryKey = array(
		'submittal_draft_id' => 'int',
		'su_additional_recipient_contact_id' => 'int'
	);

	/**
	 * No Unique Indexes, Just a Primary Key
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_submittal_recipient_via_primary_key' => array(
			'submittal_draft_id' => 'int',
			'su_additional_recipient_contact_id' => 'int'
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
		'submittal_draft_id' => 'submittal_draft_id',
		'su_additional_recipient_contact_id' => 'su_additional_recipient_contact_id',
		'smtp_recipient_header_type' => 'smtp_recipient_header_type'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $submittal_draft_id;
	public $su_additional_recipient_contact_id;
	public $smtp_recipient_header_type;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties

	// HTML ENTITY ENCODED NL2BR ORM string properties

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)
	protected static $_arrSubmittalDraftRecipientsBySubmittalDraftId;
	protected static $_arrSubmittalDraftRecipientsBySuAdditionalRecipientContactId;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllSubmittalDraftRecipients;

	// Foreign Key Objects
	private $_submittalDraft;
	private $_suAdditionalRecipientContact;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='submittal_draft_recipients')
	{
		parent::__construct($table);
		$this->setDatabase($database);
	}

	// Foreign Key Object Accessor Methods
	public function getSubmittalDraft()
	{
		if (isset($this->_submittalDraft)) {
			return $this->_submittalDraft;
		} else {
			return null;
		}
	}

	public function setSubmittalDraft($submittalDraft)
	{
		$this->_submittalDraft = $submittalDraft;
	}

	public function getSuAdditionalRecipientContact()
	{
		if (isset($this->_suAdditionalRecipientContact)) {
			return $this->_suAdditionalRecipientContact;
		} else {
			return null;
		}
	}

	public function setSuAdditionalRecipientContact($suAdditionalRecipientContact)
	{
		$this->_suAdditionalRecipientContact = $suAdditionalRecipientContact;
	}


	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)
	public static function getArrSubmittalDraftRecipientsBySubmittalDraftId()
	{
		if (isset(self::$_arrSubmittalDraftRecipientsBySubmittalDraftId)) {
			return self::$_arrSubmittalDraftRecipientsBySubmittalDraftId;
		} else {
			return null;
		}
	}

	public static function setArrSubmittalDraftRecipientsBySubmittalDraftId($arrSubmittalDraftRecipientsBySubmittalDraftId)
	{
		self::$_arrSubmittalDraftRecipientsBySubmittalDraftId = $arrSubmittalDraftRecipientsBySubmittalDraftId;
	}

	public static function getArrSubmittalDraftRecipientsBySuAdditionalRecipientContactId()
	{
		if (isset(self::$_arrSubmittalDraftRecipientsBySuAdditionalRecipientContactId)) {
			return self::$_arrSubmittalDraftRecipientsBySuAdditionalRecipientContactId;
		} else {
			return null;
		}
	}

	public static function setArrSubmittalDraftRecipientsBySuAdditionalRecipientContactId($arrSubmittalDraftRecipientsBySuAdditionalRecipientContactId)
	{
		self::$_arrSubmittalDraftRecipientsBySuAdditionalRecipientContactId = $arrSubmittalDraftRecipientsBySuAdditionalRecipientContactId;
	}


	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllSubmittalDraftRecipients()
	{
		if (isset(self::$_arrAllSubmittalDraftRecipients)) {
			return self::$_arrAllSubmittalDraftRecipients;
		} else {
			return null;
		}
	}

	public static function setArrAllSubmittalDraftRecipients($arrAllSubmittalDraftRecipients)
	{
		self::$_arrAllSubmittalDraftRecipients = $arrAllSubmittalDraftRecipients;
	}

	

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `submittal_draft_recipients_fk_sun` foreign key (`submittal_draft_id`) references `submittal_drafts` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $submittal_draft_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubmittalDraftRecipientsBySubmittalDraftId($database, $submittal_draft_id, Input $options=null)
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
			self::$_arrSubmittalDraftRecipientsBySubmittalDraftId = null;
		}

		$arrSubmittalDraftRecipientsBySubmittalDraftId = self::$_arrSubmittalDraftRecipientsBySubmittalDraftId;
		if (isset($arrSubmittalDraftRecipientsBySubmittalDraftId) && !empty($arrSubmittalDraftRecipientsBySubmittalDraftId)) {
			return $arrSubmittalDraftRecipientsBySubmittalDraftId;
		}

		$submittal_draft_id = (int) $submittal_draft_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `submittal_draft_id` ASC, `su_additional_recipient_contact_id` ASC,  `smtp_recipient_header_type` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubmittalDraftRecipient = new SubmittalDraftRecipient($database);
			$sqlOrderByColumns = $tmpSubmittalDraftRecipient->constructSqlOrderByColumns($arrOrderByAttributes);

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

	suda_fk_sud.`id` AS 'suda_fk_sud__submittal_draft_id',

	sur_fk_c.`id` AS 'sur_fk_c__contact_id',
	sur_fk_c.`user_company_id` AS 'sur_fk_c__user_company_id',
	sur_fk_c.`user_id` AS 'sur_fk_c__user_id',
	sur_fk_c.`contact_company_id` AS 'sur_fk_c__contact_company_id',
	sur_fk_c.`email` AS 'sur_fk_c__email',
	sur_fk_c.`name_prefix` AS 'sur_fk_c__name_prefix',
	sur_fk_c.`first_name` AS 'sur_fk_c__first_name',
	sur_fk_c.`additional_name` AS 'sur_fk_c__additional_name',
	sur_fk_c.`middle_name` AS 'sur_fk_c__middle_name',
	sur_fk_c.`last_name` AS 'sur_fk_c__last_name',
	sur_fk_c.`name_suffix` AS 'sur_fk_c__name_suffix',
	sur_fk_c.`title` AS 'sur_fk_c__title',
	sur_fk_c.`vendor_flag` AS 'sur_fk_c__vendor_flag',

		sur.*

FROM `submittal_draft_recipients` sur
    INNER JOIN `submittal_drafts` suda_fk_sud ON sur.`submittal_draft_id` = suda_fk_sud.`id`
	INNER JOIN `contacts` sur_fk_c ON sur.`su_additional_recipient_contact_id` = sur_fk_c.`id`
WHERE sur.`submittal_draft_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `submittal_draft_id` ASC, `su_additional_recipient_contact_id` ASC,  `smtp_recipient_header_type` ASC
		$arrValues = array($submittal_draft_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubmittalDraftRecipientsBySubmittalDraftId = array();
		while ($row = $db->fetch()) {
			$submittalDraftRecipient = self::instantiateOrm($database, 'SubmittalDraftRecipient', $row);
			/* @var $submittalDraftRecipient SubmittalDraftRecipient */
			$submittalDraftRecipient->convertPropertiesToData();

			if (isset($row['submittal_draft_id'])) {
				$submittal_draft_id = $row['submittal_draft_id'];
				$row['suda_fk_sud__id'] = $submittal_draft_id;
				$submittalDraft = self::instantiateOrm($database, 'SubmittalDraftRecipient', $row, null, $submittal_draft_id, 'suda_fk_sud__');
				/* @var $submittalDraft SubmittalDraftRecipient */
				$submittalDraft->convertPropertiesToData();
			} else {
				$submittalDraft = false;
			}
			$submittalDraftRecipient->setSubmittalDraft($submittalDraft);

			if (isset($row['su_additional_recipient_contact_id'])) {
				$su_additional_recipient_contact_id = $row['su_additional_recipient_contact_id'];
				$row['sur_fk_c__id'] = $su_additional_recipient_contact_id;
				$suAdditionalRecipientContact = self::instantiateOrm($database, 'Contact', $row, null, $su_additional_recipient_contact_id, 'sur_fk_c__');
				/* @var $suAdditionalRecipientContact Contact */
				$suAdditionalRecipientContact->convertPropertiesToData();
			} else {
				$suAdditionalRecipientContact = false;
			}
			$submittalDraftRecipient->setSuAdditionalRecipientContact($suAdditionalRecipientContact);

			$arrSubmittalDraftRecipientsBySubmittalDraftId[] = $submittalDraftRecipient;
		}

		$db->free_result();

		self::$_arrSubmittalDraftRecipientsBySubmittalDraftId = $arrSubmittalDraftRecipientsBySubmittalDraftId;

		return $arrSubmittalDraftRecipientsBySubmittalDraftId;
	}


	//delete recipients
	public static function deletRecipients($database,$submittal_draft_id){
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
		"
		DELETE FROM
		`submittal_draft_recipients`
		WHERE `submittal_draft_id` = ?
		";
		$arrValues = array($submittal_draft_id);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$db->free_result();
	}
	 //save To recipients
	public static function saveToRecipients($database, $submittal_draft_id, $to_recipient_contact_ids){
		$db = DBI::getInstance($database);
		$arrSuRecipientIds = explode(',', $to_recipient_contact_ids);
		foreach ($arrSuRecipientIds as $key => $value) {
		  $submittalDraftRecipient = new SubmittalDraftRecipient($database);
		  $ccRecipient['submittal_draft_id'] = $submittal_draft_id;
		  $ccRecipient['su_additional_recipient_contact_id'] = $value;
		  $ccRecipient['smtp_recipient_header_type'] = 'To';
		  $submittalDraftRecipient->setData($ccRecipient);
		  $submittalDraftRecipient->convertDataToProperties();
		  $submittalDraftRecipient->save();
		}
	}
    //save cc recipients
	public static function saveCcRecipients($database, $submittal_draft_id, $cc_recipient_contact_ids){
		$db = DBI::getInstance($database);
		$arrSuRecipientIds = explode(',', $cc_recipient_contact_ids);
		foreach ($arrSuRecipientIds as $key => $value) {
		  $submittalDraftRecipient = new SubmittalDraftRecipient($database);
		  $ccRecipient['submittal_draft_id'] = $submittal_draft_id;
		  $ccRecipient['su_additional_recipient_contact_id'] = $value;
		  $ccRecipient['smtp_recipient_header_type'] = 'Cc';
		  $submittalDraftRecipient->setData($ccRecipient);
		  $submittalDraftRecipient->convertDataToProperties();
		  $submittalDraftRecipient->save();
		}
	}

    //save bcc recipients
	public static function saveBccRecipients($database, $submittal_draft_id, $bcc_recipient_contact_ids){
		$db = DBI::getInstance($database);
		$arrSuBccRecipientIds = explode(',', $bcc_recipient_contact_ids);
		foreach ($arrSuBccRecipientIds as $key => $value) {
		  $submittalDraftRecipient = new SubmittalDraftRecipient($database);
		  $bccRecipient['submittal_draft_id'] = $submittal_draft_id;
		  $bccRecipient['su_additional_recipient_contact_id'] = $value;
		  $bccRecipient['smtp_recipient_header_type'] = 'Bcc';
		  $submittalDraftRecipient->setData($bccRecipient);
		  $submittalDraftRecipient->convertDataToProperties();
		  $submittalDraftRecipient->save();
		}
	}

	//To fetch the draft recipient list
	public static function loadDraftRecipients($database,$submittal_draft_id)
	{
		$db = DBI::getInstance($database);

		$query = "SELECT
				suda_fk_sud.`id` AS 'suda_fk_sud__submittal_draft_id',
				sur_fk_c.`id` AS 'sur_fk_c__contact_id',
				sur_fk_c.`user_company_id` AS 'sur_fk_c__user_company_id',
				sur_fk_c.`user_id` AS 'sur_fk_c__user_id',
				sur_fk_c.`contact_company_id` AS 'sur_fk_c__contact_company_id',
				sur_fk_c.`email` AS 'sur_fk_c__email',
				sur_fk_c.`name_prefix` AS 'sur_fk_c__name_prefix',
				sur_fk_c.`first_name` AS 'sur_fk_c__first_name',
				sur_fk_c.`additional_name` AS 'sur_fk_c__additional_name',
				sur_fk_c.`middle_name` AS 'sur_fk_c__middle_name',
				sur_fk_c.`last_name` AS 'sur_fk_c__last_name',
				sur_fk_c.`name_suffix` AS 'sur_fk_c__name_suffix',
				sur_fk_c.`title` AS 'sur_fk_c__title',
				sur_fk_c.`vendor_flag` AS 'sur_fk_c__vendor_flag',
				sur.*
			FROM `submittal_draft_recipients` sur
			    INNER JOIN `submittal_drafts` suda_fk_sud ON sur.`submittal_draft_id` = suda_fk_sud.`id`
				INNER JOIN `contacts` sur_fk_c ON sur.`su_additional_recipient_contact_id` = sur_fk_c.`id`
			WHERE sur.`submittal_draft_id` = ?{$sqlOrderBy}{$sqlLimit}
			";

		$arrValues = array($submittal_draft_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubmittalDraftRecipientsBySubmittalDraftId = array();
		while ($row = $db->fetch()) {
			$arrSubmittalDraftRecipientsBySubmittalDraftId[] = $row;

	}
	return $arrSubmittalDraftRecipientsBySubmittalDraftId;
}
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

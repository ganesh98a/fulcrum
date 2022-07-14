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
 * RequestForInformationDraftAttachment.
 *
 * @category   Framework
 * @package    RequestForInformationDraftAttachment
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class RequestForInformationDraftAttachment extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'RequestForInformationDraftAttachment';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'request_for_information_draft_attachments';

	/**
	 * primary key (`request_for_information_draft_id`,`rfi_attachment_file_manager_file_id`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrPrimaryKey = array(
		'request_for_information_draft_id' => 'int',
		'rfi_attachment_file_manager_file_id' => 'int'
	);

	/**
	 * No Unique Indexes, Just a Primary Key
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_request_for_information_draft_attachment_via_primary_key' => array(
			'request_for_information_draft_id' => 'int',
			'rfi_attachment_file_manager_file_id' => 'int'
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
		'rfi_attachment_file_manager_file_id' => 'rfi_attachment_file_manager_file_id',

		'rfi_attachment_source_contact_id' => 'rfi_attachment_source_contact_id',

		'sort_order' => 'sort_order'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $request_for_information_draft_id;
	public $rfi_attachment_file_manager_file_id;

	public $rfi_attachment_source_contact_id;

	public $sort_order;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties

	// HTML ENTITY ENCODED NL2BR ORM string properties

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)
	protected static $_arrRequestForInformationDraftAttachmentsByRequestForInformationDraftId;
	protected static $_arrRequestForInformationDraftAttachmentsByRfiAttachmentFileManagerFileId;
	protected static $_arrRequestForInformationDraftAttachmentsByRfiAttachmentSourceContactId;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllRequestForInformationDraftAttachments;

	// Foreign Key Objects
	private $_requestForInformationDraft;
	private $_rfiAttachmentFileManagerFile;
	private $_rfiAttachmentSourceContact;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='request_for_information_draft_attachments')
	{
		parent::__construct($table);
		$this->setDatabase($database);
	}

	// Foreign Key Object Accessor Methods
	public function getRequestForInformationDraft()
	{
		if (isset($this->_requestForInformationDraft)) {
			return $this->_requestForInformationDraft;
		} else {
			return null;
		}
	}

	public function setRequestForInformationDraft($requestForInformationDraft)
	{
		$this->_requestForInformationDraft = $requestForInformationDraft;
	}

	public function getRfiAttachmentFileManagerFile()
	{
		if (isset($this->_rfiAttachmentFileManagerFile)) {
			return $this->_rfiAttachmentFileManagerFile;
		} else {
			return null;
		}
	}

	public function setRfiAttachmentFileManagerFile($rfiAttachmentFileManagerFile)
	{
		$this->_rfiAttachmentFileManagerFile = $rfiAttachmentFileManagerFile;
	}

	public function getRfiAttachmentSourceContact()
	{
		if (isset($this->_rfiAttachmentSourceContact)) {
			return $this->_rfiAttachmentSourceContact;
		} else {
			return null;
		}
	}

	public function setRfiAttachmentSourceContact($rfiAttachmentSourceContact)
	{
		$this->_rfiAttachmentSourceContact = $rfiAttachmentSourceContact;
	}

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)
	public static function getArrRequestForInformationDraftAttachmentsByRequestForInformationDraftId()
	{
		if (isset(self::$_arrRequestForInformationDraftAttachmentsByRequestForInformationDraftId)) {
			return self::$_arrRequestForInformationDraftAttachmentsByRequestForInformationDraftId;
		} else {
			return null;
		}
	}

	public static function setArrRequestForInformationDraftAttachmentsByRequestForInformationDraftId($arrRequestForInformationDraftAttachmentsByRequestForInformationDraftId)
	{
		self::$_arrRequestForInformationDraftAttachmentsByRequestForInformationDraftId = $arrRequestForInformationDraftAttachmentsByRequestForInformationDraftId;
	}

	public static function getArrRequestForInformationDraftAttachmentsByRfiAttachmentFileManagerFileId()
	{
		if (isset(self::$_arrRequestForInformationDraftAttachmentsByRfiAttachmentFileManagerFileId)) {
			return self::$_arrRequestForInformationDraftAttachmentsByRfiAttachmentFileManagerFileId;
		} else {
			return null;
		}
	}

	public static function setArrRequestForInformationDraftAttachmentsByRfiAttachmentFileManagerFileId($arrRequestForInformationDraftAttachmentsByRfiAttachmentFileManagerFileId)
	{
		self::$_arrRequestForInformationDraftAttachmentsByRfiAttachmentFileManagerFileId = $arrRequestForInformationDraftAttachmentsByRfiAttachmentFileManagerFileId;
	}

	public static function getArrRequestForInformationDraftAttachmentsByRfiAttachmentSourceContactId()
	{
		if (isset(self::$_arrRequestForInformationDraftAttachmentsByRfiAttachmentSourceContactId)) {
			return self::$_arrRequestForInformationDraftAttachmentsByRfiAttachmentSourceContactId;
		} else {
			return null;
		}
	}

	public static function setArrRequestForInformationDraftAttachmentsByRfiAttachmentSourceContactId($arrRequestForInformationDraftAttachmentsByRfiAttachmentSourceContactId)
	{
		self::$_arrRequestForInformationDraftAttachmentsByRfiAttachmentSourceContactId = $arrRequestForInformationDraftAttachmentsByRfiAttachmentSourceContactId;
	}

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllRequestForInformationDraftAttachments()
	{
		if (isset(self::$_arrAllRequestForInformationDraftAttachments)) {
			return self::$_arrAllRequestForInformationDraftAttachments;
		} else {
			return null;
		}
	}

	public static function setArrAllRequestForInformationDraftAttachments($arrAllRequestForInformationDraftAttachments)
	{
		self::$_arrAllRequestForInformationDraftAttachments = $arrAllRequestForInformationDraftAttachments;
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
	 * Find by primary key (`request_for_information_draft_id`,`rfi_attachment_file_manager_file_id`).
	 *
	 * @param string $database
	 * @param int $request_for_information_draft_id
	 * @param int $rfi_attachment_file_manager_file_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findByRequestForInformationDraftIdAndRfiAttachmentFileManagerFileId($database, $request_for_information_draft_id, $rfi_attachment_file_manager_file_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	rfida.*

FROM `request_for_information_draft_attachments` rfida
WHERE rfida.`request_for_information_draft_id` = ?
AND rfida.`rfi_attachment_file_manager_file_id` = ?
";
		$arrValues = array($request_for_information_draft_id, $rfi_attachment_file_manager_file_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row && !empty($row)) {
			$requestForInformationDraftAttachment = self::instantiateOrm($database, 'RequestForInformationDraftAttachment', $row);
			/* @var $requestForInformationDraftAttachment RequestForInformationDraftAttachment */
			return $requestForInformationDraftAttachment;
		} else {
			return false;
		}
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Find by primary key (`request_for_information_draft_id`,`rfi_attachment_file_manager_file_id`) Extended.
	 *
	 * @param string $database
	 * @param int $request_for_information_draft_id
	 * @param int $rfi_attachment_file_manager_file_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findByRequestForInformationDraftIdAndRfiAttachmentFileManagerFileIdExtended($database, $request_for_information_draft_id, $rfi_attachment_file_manager_file_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	rfida_fk_rfid.`id` AS 'rfida_fk_rfid__request_for_information_draft_id',
	rfida_fk_rfid.`project_id` AS 'rfida_fk_rfid__project_id',
	rfida_fk_rfid.`request_for_information_type_id` AS 'rfida_fk_rfid__request_for_information_type_id',
	rfida_fk_rfid.`request_for_information_priority_id` AS 'rfida_fk_rfid__request_for_information_priority_id',
	rfida_fk_rfid.`rfi_file_manager_file_id` AS 'rfida_fk_rfid__rfi_file_manager_file_id',
	rfida_fk_rfid.`rfi_cost_code_id` AS 'rfida_fk_rfid__rfi_cost_code_id',
	rfida_fk_rfid.`rfi_creator_contact_id` AS 'rfida_fk_rfid__rfi_creator_contact_id',
	rfida_fk_rfid.`rfi_creator_contact_company_office_id` AS 'rfida_fk_rfid__rfi_creator_contact_company_office_id',
	rfida_fk_rfid.`rfi_creator_phone_contact_company_office_phone_number_id` AS 'rfida_fk_rfid__rfi_creator_phone_contact_company_office_phone_number_id',
	rfida_fk_rfid.`rfi_creator_fax_contact_company_office_phone_number_id` AS 'rfida_fk_rfid__rfi_creator_fax_contact_company_office_phone_number_id',
	rfida_fk_rfid.`rfi_creator_contact_mobile_phone_number_id` AS 'rfida_fk_rfid__rfi_creator_contact_mobile_phone_number_id',
	rfida_fk_rfid.`rfi_recipient_contact_id` AS 'rfida_fk_rfid__rfi_recipient_contact_id',
	rfida_fk_rfid.`rfi_recipient_contact_company_office_id` AS 'rfida_fk_rfid__rfi_recipient_contact_company_office_id',
	rfida_fk_rfid.`rfi_recipient_phone_contact_company_office_phone_number_id` AS 'rfida_fk_rfid__rfi_recipient_phone_contact_company_office_phone_number_id',
	rfida_fk_rfid.`rfi_recipient_fax_contact_company_office_phone_number_id` AS 'rfida_fk_rfid__rfi_recipient_fax_contact_company_office_phone_number_id',
	rfida_fk_rfid.`rfi_recipient_contact_mobile_phone_number_id` AS 'rfida_fk_rfid__rfi_recipient_contact_mobile_phone_number_id',
	rfida_fk_rfid.`rfi_initiator_contact_id` AS 'rfida_fk_rfid__rfi_initiator_contact_id',
	rfida_fk_rfid.`rfi_initiator_contact_company_office_id` AS 'rfida_fk_rfid__rfi_initiator_contact_company_office_id',
	rfida_fk_rfid.`rfi_initiator_phone_contact_company_office_phone_number_id` AS 'rfida_fk_rfid__rfi_initiator_phone_contact_company_office_phone_number_id',
	rfida_fk_rfid.`rfi_initiator_fax_contact_company_office_phone_number_id` AS 'rfida_fk_rfid__rfi_initiator_fax_contact_company_office_phone_number_id',
	rfida_fk_rfid.`rfi_initiator_contact_mobile_phone_number_id` AS 'rfida_fk_rfid__rfi_initiator_contact_mobile_phone_number_id',
	rfida_fk_rfid.`rfi_title` AS 'rfida_fk_rfid__rfi_title',
	rfida_fk_rfid.`rfi_plan_page_reference` AS 'rfida_fk_rfid__rfi_plan_page_reference',
	rfida_fk_rfid.`rfi_statement` AS 'rfida_fk_rfid__rfi_statement',
	rfida_fk_rfid.`rfi_due_date` AS 'rfida_fk_rfid__rfi_due_date',

	rfida_fk_fmfiles.`id` AS 'rfida_fk_fmfiles__file_manager_file_id',
	rfida_fk_fmfiles.`user_company_id` AS 'rfida_fk_fmfiles__user_company_id',
	rfida_fk_fmfiles.`contact_id` AS 'rfida_fk_fmfiles__contact_id',
	rfida_fk_fmfiles.`project_id` AS 'rfida_fk_fmfiles__project_id',
	rfida_fk_fmfiles.`file_manager_folder_id` AS 'rfida_fk_fmfiles__file_manager_folder_id',
	rfida_fk_fmfiles.`file_location_id` AS 'rfida_fk_fmfiles__file_location_id',
	rfida_fk_fmfiles.`virtual_file_name` AS 'rfida_fk_fmfiles__virtual_file_name',
	rfida_fk_fmfiles.`version_number` AS 'rfida_fk_fmfiles__version_number',
	rfida_fk_fmfiles.`virtual_file_name_sha1` AS 'rfida_fk_fmfiles__virtual_file_name_sha1',
	rfida_fk_fmfiles.`virtual_file_mime_type` AS 'rfida_fk_fmfiles__virtual_file_mime_type',
	rfida_fk_fmfiles.`modified` AS 'rfida_fk_fmfiles__modified',
	rfida_fk_fmfiles.`created` AS 'rfida_fk_fmfiles__created',
	rfida_fk_fmfiles.`deleted_flag` AS 'rfida_fk_fmfiles__deleted_flag',
	rfida_fk_fmfiles.`directly_deleted_flag` AS 'rfida_fk_fmfiles__directly_deleted_flag',

	rfida_fk_rfida_source_c.`id` AS 'rfida_fk_rfida_source_c__contact_id',
	rfida_fk_rfida_source_c.`user_company_id` AS 'rfida_fk_rfida_source_c__user_company_id',
	rfida_fk_rfida_source_c.`user_id` AS 'rfida_fk_rfida_source_c__user_id',
	rfida_fk_rfida_source_c.`contact_company_id` AS 'rfida_fk_rfida_source_c__contact_company_id',
	rfida_fk_rfida_source_c.`email` AS 'rfida_fk_rfida_source_c__email',
	rfida_fk_rfida_source_c.`name_prefix` AS 'rfida_fk_rfida_source_c__name_prefix',
	rfida_fk_rfida_source_c.`first_name` AS 'rfida_fk_rfida_source_c__first_name',
	rfida_fk_rfida_source_c.`additional_name` AS 'rfida_fk_rfida_source_c__additional_name',
	rfida_fk_rfida_source_c.`middle_name` AS 'rfida_fk_rfida_source_c__middle_name',
	rfida_fk_rfida_source_c.`last_name` AS 'rfida_fk_rfida_source_c__last_name',
	rfida_fk_rfida_source_c.`name_suffix` AS 'rfida_fk_rfida_source_c__name_suffix',
	rfida_fk_rfida_source_c.`title` AS 'rfida_fk_rfida_source_c__title',
	rfida_fk_rfida_source_c.`vendor_flag` AS 'rfida_fk_rfida_source_c__vendor_flag',

	rfida.*

FROM `request_for_information_draft_attachments` rfida
	INNER JOIN `request_for_information_drafts` rfida_fk_rfid ON rfida.`request_for_information_draft_id` = rfida_fk_rfid.`id`
	INNER JOIN `file_manager_files` rfida_fk_fmfiles ON rfida.`rfi_attachment_file_manager_file_id` = rfida_fk_fmfiles.`id`
	INNER JOIN `contacts` rfida_fk_rfida_source_c ON rfida.`rfi_attachment_source_contact_id` = rfida_fk_rfida_source_c.`id`
WHERE rfida.`request_for_information_draft_id` = ?
AND rfida.`rfi_attachment_file_manager_file_id` = ?
";
		$arrValues = array($request_for_information_draft_id, $rfi_attachment_file_manager_file_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row && !empty($row)) {
			$requestForInformationDraftAttachment = self::instantiateOrm($database, 'RequestForInformationDraftAttachment', $row);
			/* @var $requestForInformationDraftAttachment RequestForInformationDraftAttachment */
			$requestForInformationDraftAttachment->convertPropertiesToData();

			if (isset($row['request_for_information_draft_id'])) {
				$request_for_information_draft_id = $row['request_for_information_draft_id'];
				$row['rfida_fk_rfid__id'] = $request_for_information_draft_id;
				$requestForInformationDraft = self::instantiateOrm($database, 'RequestForInformationDraft', $row, null, $request_for_information_draft_id, 'rfida_fk_rfid__');
				/* @var $requestForInformationDraft RequestForInformationDraft */
				$requestForInformationDraft->convertPropertiesToData();
			} else {
				$requestForInformationDraft = false;
			}
			$requestForInformationDraftAttachment->setRequestForInformationDraft($requestForInformationDraft);

			if (isset($row['rfi_attachment_file_manager_file_id'])) {
				$rfi_attachment_file_manager_file_id = $row['rfi_attachment_file_manager_file_id'];
				$row['rfida_fk_fmfiles__id'] = $rfi_attachment_file_manager_file_id;
				$rfiAttachmentFileManagerFile = self::instantiateOrm($database, 'FileManagerFile', $row, null, $rfi_attachment_file_manager_file_id, 'rfida_fk_fmfiles__');
				/* @var $rfiAttachmentFileManagerFile FileManagerFile */
				$rfiAttachmentFileManagerFile->convertPropertiesToData();
			} else {
				$rfiAttachmentFileManagerFile = false;
			}
			$requestForInformationDraftAttachment->setRfiAttachmentFileManagerFile($rfiAttachmentFileManagerFile);

			if (isset($row['rfi_attachment_source_contact_id'])) {
				$rfi_attachment_source_contact_id = $row['rfi_attachment_source_contact_id'];
				$row['rfida_fk_rfida_source_c__id'] = $rfi_attachment_source_contact_id;
				$rfiAttachmentSourceContact = self::instantiateOrm($database, 'Contact', $row, null, $rfi_attachment_source_contact_id, 'rfida_fk_rfida_source_c__');
				/* @var $rfiAttachmentSourceContact Contact */
				$rfiAttachmentSourceContact->convertPropertiesToData();
			} else {
				$rfiAttachmentSourceContact = false;
			}
			$requestForInformationDraftAttachment->setRfiAttachmentSourceContact($rfiAttachmentSourceContact);

			return $requestForInformationDraftAttachment;
		} else {
			return false;
		}
	}

	// Finders: Find By Unique Index

	// Loaders: Load By pk List (list of auto int ids or other non auto int pk list)
	/**
	 * Load zero or more records by a list of non auto int primary keys (array of primary keys).
	 *
	 * @param string $database
	 * @param array $arrRequestForInformationDraftIdAndRfiAttachmentFileManagerFileIdList
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadRequestForInformationDraftAttachmentsByArrRequestForInformationDraftIdAndRfiAttachmentFileManagerFileIdList($database, $arrRequestForInformationDraftIdAndRfiAttachmentFileManagerFileIdList, Input $options=null)
	{
		if (empty($arrRequestForInformationDraftIdAndRfiAttachmentFileManagerFileIdList)) {
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
		// ORDER BY `request_for_information_draft_id` ASC, `rfi_attachment_file_manager_file_id` ASC, `rfi_attachment_source_contact_id` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY rfida.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpRequestForInformationDraftAttachment = new RequestForInformationDraftAttachment($database);
			$sqlOrderByColumns = $tmpRequestForInformationDraftAttachment->constructSqlOrderByColumns($arrOrderByAttributes);

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

		$arrSqlWhere = array();
		foreach ($arrRequestForInformationDraftIdAndRfiAttachmentFileManagerFileIdList as $k => $arrTmp) {
			$tmpInnerAnd = '';
			$first = true;
			foreach ($arrTmp as $tmpPrimaryKeyAttribute => $tmpPrimaryKeyValue) {
				$tmpPrimaryKeyAttributeEscaped = $db->escape($tmpPrimaryKeyAttribute);
				$tmpPrimaryKeyValueEscaped = $db->escape($tmpPrimaryKeyValue);
				if ($first) {
					$first = false;
					$tmpInnerAnd = "`$tmpPrimaryKeyAttribute` = '$tmpPrimaryKeyValueEscaped'";
				} else {
					$tmpInnerAnd .= " AND `$tmpPrimaryKeyAttribute` = '$tmpPrimaryKeyValueEscaped'";
				}
			}
			$tmpInnerAnd = "($tmpInnerAnd)";
			$arrSqlWhere[] = $tmpInnerAnd;
		}
		if (count($arrRequestForInformationDraftIdAndRfiAttachmentFileManagerFileIdList) > 1) {
			$sqlWhere = join($arrSqlWhere, ' OR ');
			$sqlWhere = "WHERE ($sqlWhere)";
		} else {
			$sqlWhere = "WHERE $tmpInnerAnd";
		}

		$query =
"
SELECT

	rfida.*

FROM `request_for_information_draft_attachments` rfida
{$sqlWhere}{$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrRequestForInformationDraftAttachmentsByArrRequestForInformationDraftIdAndRfiAttachmentFileManagerFileIdList = array();
		while ($row = $db->fetch()) {
			$requestForInformationDraftAttachment = self::instantiateOrm($database, 'RequestForInformationDraftAttachment', $row);
			/* @var $requestForInformationDraftAttachment RequestForInformationDraftAttachment */
			$arrRequestForInformationDraftAttachmentsByArrRequestForInformationDraftIdAndRfiAttachmentFileManagerFileIdList[] = $requestForInformationDraftAttachment;
		}

		$db->free_result();

		return $arrRequestForInformationDraftAttachmentsByArrRequestForInformationDraftIdAndRfiAttachmentFileManagerFileIdList;
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `request_for_information_draft_attachments_fk_rfid` foreign key (`request_for_information_draft_id`) references `request_for_information_drafts` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $request_for_information_draft_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadRequestForInformationDraftAttachmentsByRequestForInformationDraftId($database, $request_for_information_draft_id, Input $options=null)
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
			self::$_arrRequestForInformationDraftAttachmentsByRequestForInformationDraftId = null;
		}

		$arrRequestForInformationDraftAttachmentsByRequestForInformationDraftId = self::$_arrRequestForInformationDraftAttachmentsByRequestForInformationDraftId;
		if (isset($arrRequestForInformationDraftAttachmentsByRequestForInformationDraftId) && !empty($arrRequestForInformationDraftAttachmentsByRequestForInformationDraftId)) {
			return $arrRequestForInformationDraftAttachmentsByRequestForInformationDraftId;
		}

		$request_for_information_draft_id = (int) $request_for_information_draft_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `request_for_information_draft_id` ASC, `rfi_attachment_file_manager_file_id` ASC, `rfi_attachment_source_contact_id` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY rfida.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpRequestForInformationDraftAttachment = new RequestForInformationDraftAttachment($database);
			$sqlOrderByColumns = $tmpRequestForInformationDraftAttachment->constructSqlOrderByColumns($arrOrderByAttributes);

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
	rfida.*

FROM `request_for_information_draft_attachments` rfida
WHERE rfida.`request_for_information_draft_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `request_for_information_draft_id` ASC, `rfi_attachment_file_manager_file_id` ASC, `rfi_attachment_source_contact_id` ASC, `sort_order` ASC
		$arrValues = array($request_for_information_draft_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrRequestForInformationDraftAttachmentsByRequestForInformationDraftId = array();
		while ($row = $db->fetch()) {
			$requestForInformationDraftAttachment = self::instantiateOrm($database, 'RequestForInformationDraftAttachment', $row);
			/* @var $requestForInformationDraftAttachment RequestForInformationDraftAttachment */
			$arrRequestForInformationDraftAttachmentsByRequestForInformationDraftId[] = $requestForInformationDraftAttachment;
		}

		$db->free_result();

		self::$_arrRequestForInformationDraftAttachmentsByRequestForInformationDraftId = $arrRequestForInformationDraftAttachmentsByRequestForInformationDraftId;

		return $arrRequestForInformationDraftAttachmentsByRequestForInformationDraftId;
	}

	/**
	 * Load by constraint `request_for_information_draft_attachments_fk_fmfiles` foreign key (`rfi_attachment_file_manager_file_id`) references `file_manager_files` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $rfi_attachment_file_manager_file_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadRequestForInformationDraftAttachmentsByRfiAttachmentFileManagerFileId($database, $rfi_attachment_file_manager_file_id, Input $options=null)
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
			self::$_arrRequestForInformationDraftAttachmentsByRfiAttachmentFileManagerFileId = null;
		}

		$arrRequestForInformationDraftAttachmentsByRfiAttachmentFileManagerFileId = self::$_arrRequestForInformationDraftAttachmentsByRfiAttachmentFileManagerFileId;
		if (isset($arrRequestForInformationDraftAttachmentsByRfiAttachmentFileManagerFileId) && !empty($arrRequestForInformationDraftAttachmentsByRfiAttachmentFileManagerFileId)) {
			return $arrRequestForInformationDraftAttachmentsByRfiAttachmentFileManagerFileId;
		}

		$rfi_attachment_file_manager_file_id = (int) $rfi_attachment_file_manager_file_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `request_for_information_draft_id` ASC, `rfi_attachment_file_manager_file_id` ASC, `rfi_attachment_source_contact_id` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY rfida.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpRequestForInformationDraftAttachment = new RequestForInformationDraftAttachment($database);
			$sqlOrderByColumns = $tmpRequestForInformationDraftAttachment->constructSqlOrderByColumns($arrOrderByAttributes);

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
	rfida.*

FROM `request_for_information_draft_attachments` rfida
WHERE rfida.`rfi_attachment_file_manager_file_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `request_for_information_draft_id` ASC, `rfi_attachment_file_manager_file_id` ASC, `rfi_attachment_source_contact_id` ASC, `sort_order` ASC
		$arrValues = array($rfi_attachment_file_manager_file_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrRequestForInformationDraftAttachmentsByRfiAttachmentFileManagerFileId = array();
		while ($row = $db->fetch()) {
			$requestForInformationDraftAttachment = self::instantiateOrm($database, 'RequestForInformationDraftAttachment', $row);
			/* @var $requestForInformationDraftAttachment RequestForInformationDraftAttachment */
			$arrRequestForInformationDraftAttachmentsByRfiAttachmentFileManagerFileId[] = $requestForInformationDraftAttachment;
		}

		$db->free_result();

		self::$_arrRequestForInformationDraftAttachmentsByRfiAttachmentFileManagerFileId = $arrRequestForInformationDraftAttachmentsByRfiAttachmentFileManagerFileId;

		return $arrRequestForInformationDraftAttachmentsByRfiAttachmentFileManagerFileId;
	}

	/**
	 * Load by constraint `request_for_information_draft_attachments_fk_rfida_source_c` foreign key (`rfi_attachment_source_contact_id`) references `contacts` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $rfi_attachment_source_contact_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadRequestForInformationDraftAttachmentsByRfiAttachmentSourceContactId($database, $rfi_attachment_source_contact_id, Input $options=null)
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
			self::$_arrRequestForInformationDraftAttachmentsByRfiAttachmentSourceContactId = null;
		}

		$arrRequestForInformationDraftAttachmentsByRfiAttachmentSourceContactId = self::$_arrRequestForInformationDraftAttachmentsByRfiAttachmentSourceContactId;
		if (isset($arrRequestForInformationDraftAttachmentsByRfiAttachmentSourceContactId) && !empty($arrRequestForInformationDraftAttachmentsByRfiAttachmentSourceContactId)) {
			return $arrRequestForInformationDraftAttachmentsByRfiAttachmentSourceContactId;
		}

		$rfi_attachment_source_contact_id = (int) $rfi_attachment_source_contact_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `request_for_information_draft_id` ASC, `rfi_attachment_file_manager_file_id` ASC, `rfi_attachment_source_contact_id` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY rfida.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpRequestForInformationDraftAttachment = new RequestForInformationDraftAttachment($database);
			$sqlOrderByColumns = $tmpRequestForInformationDraftAttachment->constructSqlOrderByColumns($arrOrderByAttributes);

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
	rfida.*

FROM `request_for_information_draft_attachments` rfida
WHERE rfida.`rfi_attachment_source_contact_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `request_for_information_draft_id` ASC, `rfi_attachment_file_manager_file_id` ASC, `rfi_attachment_source_contact_id` ASC, `sort_order` ASC
		$arrValues = array($rfi_attachment_source_contact_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrRequestForInformationDraftAttachmentsByRfiAttachmentSourceContactId = array();
		while ($row = $db->fetch()) {
			$requestForInformationDraftAttachment = self::instantiateOrm($database, 'RequestForInformationDraftAttachment', $row);
			/* @var $requestForInformationDraftAttachment RequestForInformationDraftAttachment */
			$arrRequestForInformationDraftAttachmentsByRfiAttachmentSourceContactId[] = $requestForInformationDraftAttachment;
		}

		$db->free_result();

		self::$_arrRequestForInformationDraftAttachmentsByRfiAttachmentSourceContactId = $arrRequestForInformationDraftAttachmentsByRfiAttachmentSourceContactId;

		return $arrRequestForInformationDraftAttachmentsByRfiAttachmentSourceContactId;
	}

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all request_for_information_draft_attachments records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllRequestForInformationDraftAttachments($database, Input $options=null)
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
			self::$_arrAllRequestForInformationDraftAttachments = null;
		}

		$arrAllRequestForInformationDraftAttachments = self::$_arrAllRequestForInformationDraftAttachments;
		if (isset($arrAllRequestForInformationDraftAttachments) && !empty($arrAllRequestForInformationDraftAttachments)) {
			return $arrAllRequestForInformationDraftAttachments;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `request_for_information_draft_id` ASC, `rfi_attachment_file_manager_file_id` ASC, `rfi_attachment_source_contact_id` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY rfida.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpRequestForInformationDraftAttachment = new RequestForInformationDraftAttachment($database);
			$sqlOrderByColumns = $tmpRequestForInformationDraftAttachment->constructSqlOrderByColumns($arrOrderByAttributes);

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
	rfida.*

FROM `request_for_information_draft_attachments` rfida{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `request_for_information_draft_id` ASC, `rfi_attachment_file_manager_file_id` ASC, `rfi_attachment_source_contact_id` ASC, `sort_order` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllRequestForInformationDraftAttachments = array();
		while ($row = $db->fetch()) {
			$requestForInformationDraftAttachment = self::instantiateOrm($database, 'RequestForInformationDraftAttachment', $row);
			/* @var $requestForInformationDraftAttachment RequestForInformationDraftAttachment */
			$arrAllRequestForInformationDraftAttachments[] = $requestForInformationDraftAttachment;
		}

		$db->free_result();

		self::$_arrAllRequestForInformationDraftAttachments = $arrAllRequestForInformationDraftAttachments;

		return $arrAllRequestForInformationDraftAttachments;
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
INTO `request_for_information_draft_attachments`
(`request_for_information_draft_id`, `rfi_attachment_file_manager_file_id`, `rfi_attachment_source_contact_id`, `sort_order`)
VALUES (?, ?, ?, ?)
ON DUPLICATE KEY UPDATE `rfi_attachment_source_contact_id` = ?, `sort_order` = ?
";
		$arrValues = array($this->request_for_information_draft_id, $this->rfi_attachment_file_manager_file_id, $this->rfi_attachment_source_contact_id, $this->sort_order, $this->rfi_attachment_source_contact_id, $this->sort_order);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$request_for_information_draft_attachment_id = $db->insertId;
		$db->free_result();

		return $request_for_information_draft_attachment_id;
	}

	// Save: insert ignore

	/**
	 * Find rfi_draft_attachment_sequence_number value.
	 *
	 * @param string $database
	 * @param int $request_for_information_draft_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findNextRFIDraftAttachmentSequenceNumber($database, $request_for_information_draft_id)
	{
		$next_rfi_draft_attachment_sequence_number = 1;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT MAX(rfida.rfi_draft_attachment_sequence_number) AS 'max_rfi_draft_attachment_sequence_number'
FROM `request_for_information_draft_attachments` rfida
WHERE rfia.`request_for_information_draft_id` = ?
";
		$arrValues = array($request_for_information_draft_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$max_rfi_draft_attachment_sequence_number = $row['max_rfi_draft_attachment_sequence_number'];
			$next_rfi_draft_attachment_sequence_number = $max_rfi_draft_attachment_sequence_number + 1;
		}

		return $next_rfi_draft_attachment_sequence_number;
	}
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

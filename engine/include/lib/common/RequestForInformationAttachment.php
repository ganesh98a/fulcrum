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
 * RequestForInformationAttachment.
 *
 * @category   Framework
 * @package    RequestForInformationAttachment
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class RequestForInformationAttachment extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'RequestForInformationAttachment';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'request_for_information_attachments';

	/**
	 * primary key (`request_for_information_id`,`rfi_attachment_file_manager_file_id`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrPrimaryKey = array(
		'request_for_information_id' => 'int',
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
		'unique_request_for_information_attachment_via_primary_key' => array(
			'request_for_information_id' => 'int',
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
		'request_for_information_id' => 'request_for_information_id',
		'rfi_attachment_file_manager_file_id' => 'rfi_attachment_file_manager_file_id',

		'rfi_attachment_source_contact_id' => 'rfi_attachment_source_contact_id',
		'is_added'=> 'is_added',
		'sort_order' => 'sort_order'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $request_for_information_id;
	public $rfi_attachment_file_manager_file_id;

	public $rfi_attachment_source_contact_id;
	public $is_added;
	public $sort_order;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties

	// HTML ENTITY ENCODED NL2BR ORM string properties

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)
	protected static $_arrRequestForInformationAttachmentsByRequestForInformationId;
	protected static $_arrRequestForInformationAttachmentsByRfiAttachmentFileManagerFileId;
	protected static $_arrRequestForInformationAttachmentsByRfiAttachmentSourceContactId;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllRequestForInformationAttachments;

	// Foreign Key Objects
	private $_requestForInformation;
	private $_rfiAttachmentFileManagerFile;
	private $_rfiAttachmentSourceContact;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='request_for_information_attachments')
	{
		parent::__construct($table);
		$this->setDatabase($database);
	}

	// Foreign Key Object Accessor Methods
	public function getRequestForInformation()
	{
		if (isset($this->_requestForInformation)) {
			return $this->_requestForInformation;
		} else {
			return null;
		}
	}

	public function setRequestForInformation($requestForInformation)
	{
		$this->_requestForInformation = $requestForInformation;
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
	public static function getArrRequestForInformationAttachmentsByRequestForInformationId()
	{
		if (isset(self::$_arrRequestForInformationAttachmentsByRequestForInformationId)) {
			return self::$_arrRequestForInformationAttachmentsByRequestForInformationId;
		} else {
			return null;
		}
	}

	public static function setArrRequestForInformationAttachmentsByRequestForInformationId($arrRequestForInformationAttachmentsByRequestForInformationId)
	{
		self::$_arrRequestForInformationAttachmentsByRequestForInformationId = $arrRequestForInformationAttachmentsByRequestForInformationId;
	}

	public static function getArrRequestForInformationAttachmentsByRfiAttachmentFileManagerFileId()
	{
		if (isset(self::$_arrRequestForInformationAttachmentsByRfiAttachmentFileManagerFileId)) {
			return self::$_arrRequestForInformationAttachmentsByRfiAttachmentFileManagerFileId;
		} else {
			return null;
		}
	}

	public static function setArrRequestForInformationAttachmentsByRfiAttachmentFileManagerFileId($arrRequestForInformationAttachmentsByRfiAttachmentFileManagerFileId)
	{
		self::$_arrRequestForInformationAttachmentsByRfiAttachmentFileManagerFileId = $arrRequestForInformationAttachmentsByRfiAttachmentFileManagerFileId;
	}

	public static function getArrRequestForInformationAttachmentsByRfiAttachmentSourceContactId()
	{
		if (isset(self::$_arrRequestForInformationAttachmentsByRfiAttachmentSourceContactId)) {
			return self::$_arrRequestForInformationAttachmentsByRfiAttachmentSourceContactId;
		} else {
			return null;
		}
	}

	public static function setArrRequestForInformationAttachmentsByRfiAttachmentSourceContactId($arrRequestForInformationAttachmentsByRfiAttachmentSourceContactId)
	{
		self::$_arrRequestForInformationAttachmentsByRfiAttachmentSourceContactId = $arrRequestForInformationAttachmentsByRfiAttachmentSourceContactId;
	}

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllRequestForInformationAttachments()
	{
		if (isset(self::$_arrAllRequestForInformationAttachments)) {
			return self::$_arrAllRequestForInformationAttachments;
		} else {
			return null;
		}
	}

	public static function setArrAllRequestForInformationAttachments($arrAllRequestForInformationAttachments)
	{
		self::$_arrAllRequestForInformationAttachments = $arrAllRequestForInformationAttachments;
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
	 * Find by primary key (`request_for_information_id`,`rfi_attachment_file_manager_file_id`).
	 *
	 * @param string $database
	 * @param int $request_for_information_id
	 * @param int $rfi_attachment_file_manager_file_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findByRequestForInformationIdAndRfiAttachmentFileManagerFileId($database, $request_for_information_id, $rfi_attachment_file_manager_file_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	rfia.*

FROM `request_for_information_attachments` rfia
WHERE rfia.`request_for_information_id` = ?
AND rfia.`rfi_attachment_file_manager_file_id` = ?
";
		$arrValues = array($request_for_information_id, $rfi_attachment_file_manager_file_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row && !empty($row)) {
			$requestForInformationAttachment = self::instantiateOrm($database, 'RequestForInformationAttachment', $row);
			/* @var $requestForInformationAttachment RequestForInformationAttachment */
			return $requestForInformationAttachment;
		} else {
			return false;
		}
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Find by primary key (`request_for_information_id`,`rfi_attachment_file_manager_file_id`) Extended.
	 *
	 * @param string $database
	 * @param int $request_for_information_id
	 * @param int $rfi_attachment_file_manager_file_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findByRequestForInformationIdAndRfiAttachmentFileManagerFileIdExtended($database, $request_for_information_id, $rfi_attachment_file_manager_file_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	rfia_fk_rfi.`id` AS 'rfia_fk_rfi__request_for_information_id',
	rfia_fk_rfi.`project_id` AS 'rfia_fk_rfi__project_id',
	rfia_fk_rfi.`rfi_sequence_number` AS 'rfia_fk_rfi__rfi_sequence_number',
	rfia_fk_rfi.`request_for_information_type_id` AS 'rfia_fk_rfi__request_for_information_type_id',
	rfia_fk_rfi.`request_for_information_status_id` AS 'rfia_fk_rfi__request_for_information_status_id',
	rfia_fk_rfi.`request_for_information_priority_id` AS 'rfia_fk_rfi__request_for_information_priority_id',
	rfia_fk_rfi.`rfi_file_manager_file_id` AS 'rfia_fk_rfi__rfi_file_manager_file_id',
	rfia_fk_rfi.`rfi_cost_code_id` AS 'rfia_fk_rfi__rfi_cost_code_id',
	rfia_fk_rfi.`rfi_creator_contact_id` AS 'rfia_fk_rfi__rfi_creator_contact_id',
	rfia_fk_rfi.`rfi_creator_contact_company_office_id` AS 'rfia_fk_rfi__rfi_creator_contact_company_office_id',
	rfia_fk_rfi.`rfi_creator_phone_contact_company_office_phone_number_id` AS 'rfia_fk_rfi__rfi_creator_phone_contact_company_office_phone_number_id',
	rfia_fk_rfi.`rfi_creator_fax_contact_company_office_phone_number_id` AS 'rfia_fk_rfi__rfi_creator_fax_contact_company_office_phone_number_id',
	rfia_fk_rfi.`rfi_creator_contact_mobile_phone_number_id` AS 'rfia_fk_rfi__rfi_creator_contact_mobile_phone_number_id',
	rfia_fk_rfi.`rfi_recipient_contact_id` AS 'rfia_fk_rfi__rfi_recipient_contact_id',
	rfia_fk_rfi.`rfi_recipient_contact_company_office_id` AS 'rfia_fk_rfi__rfi_recipient_contact_company_office_id',
	rfia_fk_rfi.`rfi_recipient_phone_contact_company_office_phone_number_id` AS 'rfia_fk_rfi__rfi_recipient_phone_contact_company_office_phone_number_id',
	rfia_fk_rfi.`rfi_recipient_fax_contact_company_office_phone_number_id` AS 'rfia_fk_rfi__rfi_recipient_fax_contact_company_office_phone_number_id',
	rfia_fk_rfi.`rfi_recipient_contact_mobile_phone_number_id` AS 'rfia_fk_rfi__rfi_recipient_contact_mobile_phone_number_id',
	rfia_fk_rfi.`rfi_initiator_contact_id` AS 'rfia_fk_rfi__rfi_initiator_contact_id',
	rfia_fk_rfi.`rfi_initiator_contact_company_office_id` AS 'rfia_fk_rfi__rfi_initiator_contact_company_office_id',
	rfia_fk_rfi.`rfi_initiator_phone_contact_company_office_phone_number_id` AS 'rfia_fk_rfi__rfi_initiator_phone_contact_company_office_phone_number_id',
	rfia_fk_rfi.`rfi_initiator_fax_contact_company_office_phone_number_id` AS 'rfia_fk_rfi__rfi_initiator_fax_contact_company_office_phone_number_id',
	rfia_fk_rfi.`rfi_initiator_contact_mobile_phone_number_id` AS 'rfia_fk_rfi__rfi_initiator_contact_mobile_phone_number_id',
	rfia_fk_rfi.`rfi_title` AS 'rfia_fk_rfi__rfi_title',
	rfia_fk_rfi.`rfi_plan_page_reference` AS 'rfia_fk_rfi__rfi_plan_page_reference',
	rfia_fk_rfi.`rfi_statement` AS 'rfia_fk_rfi__rfi_statement',
	rfia_fk_rfi.`created` AS 'rfia_fk_rfi__created',
	rfia_fk_rfi.`rfi_due_date` AS 'rfia_fk_rfi__rfi_due_date',
	rfia_fk_rfi.`rfi_closed_date` AS 'rfia_fk_rfi__rfi_closed_date',

	rfia_fk_fmfiles.`id` AS 'rfia_fk_fmfiles__file_manager_file_id',
	rfia_fk_fmfiles.`user_company_id` AS 'rfia_fk_fmfiles__user_company_id',
	rfia_fk_fmfiles.`contact_id` AS 'rfia_fk_fmfiles__contact_id',
	rfia_fk_fmfiles.`project_id` AS 'rfia_fk_fmfiles__project_id',
	rfia_fk_fmfiles.`file_manager_folder_id` AS 'rfia_fk_fmfiles__file_manager_folder_id',
	rfia_fk_fmfiles.`file_location_id` AS 'rfia_fk_fmfiles__file_location_id',
	rfia_fk_fmfiles.`virtual_file_name` AS 'rfia_fk_fmfiles__virtual_file_name',
	rfia_fk_fmfiles.`version_number` AS 'rfia_fk_fmfiles__version_number',
	rfia_fk_fmfiles.`virtual_file_name_sha1` AS 'rfia_fk_fmfiles__virtual_file_name_sha1',
	rfia_fk_fmfiles.`virtual_file_mime_type` AS 'rfia_fk_fmfiles__virtual_file_mime_type',
	rfia_fk_fmfiles.`modified` AS 'rfia_fk_fmfiles__modified',
	rfia_fk_fmfiles.`created` AS 'rfia_fk_fmfiles__created',
	rfia_fk_fmfiles.`deleted_flag` AS 'rfia_fk_fmfiles__deleted_flag',
	rfia_fk_fmfiles.`directly_deleted_flag` AS 'rfia_fk_fmfiles__directly_deleted_flag',

	rfia_fk_rfia_source_c.`id` AS 'rfia_fk_rfia_source_c__contact_id',
	rfia_fk_rfia_source_c.`user_company_id` AS 'rfia_fk_rfia_source_c__user_company_id',
	rfia_fk_rfia_source_c.`user_id` AS 'rfia_fk_rfia_source_c__user_id',
	rfia_fk_rfia_source_c.`contact_company_id` AS 'rfia_fk_rfia_source_c__contact_company_id',
	rfia_fk_rfia_source_c.`email` AS 'rfia_fk_rfia_source_c__email',
	rfia_fk_rfia_source_c.`name_prefix` AS 'rfia_fk_rfia_source_c__name_prefix',
	rfia_fk_rfia_source_c.`first_name` AS 'rfia_fk_rfia_source_c__first_name',
	rfia_fk_rfia_source_c.`additional_name` AS 'rfia_fk_rfia_source_c__additional_name',
	rfia_fk_rfia_source_c.`middle_name` AS 'rfia_fk_rfia_source_c__middle_name',
	rfia_fk_rfia_source_c.`last_name` AS 'rfia_fk_rfia_source_c__last_name',
	rfia_fk_rfia_source_c.`name_suffix` AS 'rfia_fk_rfia_source_c__name_suffix',
	rfia_fk_rfia_source_c.`title` AS 'rfia_fk_rfia_source_c__title',
	rfia_fk_rfia_source_c.`vendor_flag` AS 'rfia_fk_rfia_source_c__vendor_flag',

	rfia.*

FROM `request_for_information_attachments` rfia
	INNER JOIN `requests_for_information` rfia_fk_rfi ON rfia.`request_for_information_id` = rfia_fk_rfi.`id`
	INNER JOIN `file_manager_files` rfia_fk_fmfiles ON rfia.`rfi_attachment_file_manager_file_id` = rfia_fk_fmfiles.`id`
	INNER JOIN `contacts` rfia_fk_rfia_source_c ON rfia.`rfi_attachment_source_contact_id` = rfia_fk_rfia_source_c.`id`
WHERE rfia.`request_for_information_id` = ?
AND rfia.`rfi_attachment_file_manager_file_id` = ?
";
		$arrValues = array($request_for_information_id, $rfi_attachment_file_manager_file_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row && !empty($row)) {
			$requestForInformationAttachment = self::instantiateOrm($database, 'RequestForInformationAttachment', $row);
			/* @var $requestForInformationAttachment RequestForInformationAttachment */
			$requestForInformationAttachment->convertPropertiesToData();

			if (isset($row['request_for_information_id'])) {
				$request_for_information_id = $row['request_for_information_id'];
				$row['rfia_fk_rfi__id'] = $request_for_information_id;
				$requestForInformation = self::instantiateOrm($database, 'RequestForInformation', $row, null, $request_for_information_id, 'rfia_fk_rfi__');
				/* @var $requestForInformation RequestForInformation */
				$requestForInformation->convertPropertiesToData();
			} else {
				$requestForInformation = false;
			}
			$requestForInformationAttachment->setRequestForInformation($requestForInformation);

			if (isset($row['rfi_attachment_file_manager_file_id'])) {
				$rfi_attachment_file_manager_file_id = $row['rfi_attachment_file_manager_file_id'];
				$row['rfia_fk_fmfiles__id'] = $rfi_attachment_file_manager_file_id;
				$rfiAttachmentFileManagerFile = self::instantiateOrm($database, 'FileManagerFile', $row, null, $rfi_attachment_file_manager_file_id, 'rfia_fk_fmfiles__');
				/* @var $rfiAttachmentFileManagerFile FileManagerFile */
				$rfiAttachmentFileManagerFile->convertPropertiesToData();
			} else {
				$rfiAttachmentFileManagerFile = false;
			}
			$requestForInformationAttachment->setRfiAttachmentFileManagerFile($rfiAttachmentFileManagerFile);

			if (isset($row['rfi_attachment_source_contact_id'])) {
				$rfi_attachment_source_contact_id = $row['rfi_attachment_source_contact_id'];
				$row['rfia_fk_rfia_source_c__id'] = $rfi_attachment_source_contact_id;
				$rfiAttachmentSourceContact = self::instantiateOrm($database, 'Contact', $row, null, $rfi_attachment_source_contact_id, 'rfia_fk_rfia_source_c__');
				/* @var $rfiAttachmentSourceContact Contact */
				$rfiAttachmentSourceContact->convertPropertiesToData();
			} else {
				$rfiAttachmentSourceContact = false;
			}
			$requestForInformationAttachment->setRfiAttachmentSourceContact($rfiAttachmentSourceContact);

			return $requestForInformationAttachment;
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
	 * @param array $arrRequestForInformationIdAndRfiAttachmentFileManagerFileIdList
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadRequestForInformationAttachmentsByArrRequestForInformationIdAndRfiAttachmentFileManagerFileIdList($database, $arrRequestForInformationIdAndRfiAttachmentFileManagerFileIdList, Input $options=null)
	{
		if (empty($arrRequestForInformationIdAndRfiAttachmentFileManagerFileIdList)) {
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
		// ORDER BY `request_for_information_id` ASC, `rfi_attachment_file_manager_file_id` ASC, `rfi_attachment_source_contact_id` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY rfia.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpRequestForInformationAttachment = new RequestForInformationAttachment($database);
			$sqlOrderByColumns = $tmpRequestForInformationAttachment->constructSqlOrderByColumns($arrOrderByAttributes);

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
		foreach ($arrRequestForInformationIdAndRfiAttachmentFileManagerFileIdList as $k => $arrTmp) {
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
		if (count($arrRequestForInformationIdAndRfiAttachmentFileManagerFileIdList) > 1) {
			$sqlWhere = join($arrSqlWhere, ' OR ');
			$sqlWhere = "WHERE ($sqlWhere)";
		} else {
			$sqlWhere = "WHERE $tmpInnerAnd";
		}

		$query =
"
SELECT

	rfia.*

FROM `request_for_information_attachments` rfia
{$sqlWhere}{$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrRequestForInformationAttachmentsByArrRequestForInformationIdAndRfiAttachmentFileManagerFileIdList = array();
		while ($row = $db->fetch()) {
			$requestForInformationAttachment = self::instantiateOrm($database, 'RequestForInformationAttachment', $row);
			/* @var $requestForInformationAttachment RequestForInformationAttachment */
			$arrRequestForInformationAttachmentsByArrRequestForInformationIdAndRfiAttachmentFileManagerFileIdList[] = $requestForInformationAttachment;
		}

		$db->free_result();

		return $arrRequestForInformationAttachmentsByArrRequestForInformationIdAndRfiAttachmentFileManagerFileIdList;
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `request_for_information_attachments_fk_rfi` foreign key (`request_for_information_id`) references `requests_for_information` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $request_for_information_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadRequestForInformationAttachmentsByRequestForInformationId($database, $request_for_information_id, Input $options=null,$allData=null)
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
			self::$_arrRequestForInformationAttachmentsByRequestForInformationId = null;
		}

		$arrRequestForInformationAttachmentsByRequestForInformationId = self::$_arrRequestForInformationAttachmentsByRequestForInformationId;
		if (isset($arrRequestForInformationAttachmentsByRequestForInformationId) && !empty($arrRequestForInformationAttachmentsByRequestForInformationId)) {
			return $arrRequestForInformationAttachmentsByRequestForInformationId;
		}

		$request_for_information_id = (int) $request_for_information_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `request_for_information_id` ASC, `rfi_attachment_file_manager_file_id` ASC, `rfi_attachment_source_contact_id` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY rfia.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpRequestForInformationAttachment = new RequestForInformationAttachment($database);
			$sqlOrderByColumns = $tmpRequestForInformationAttachment->constructSqlOrderByColumns($arrOrderByAttributes);

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
		if($allData)
		{
			$filter="and rfia.`is_added`='y'";
		}else
		{
			$filter="";
		}

		$query =
"
SELECT

	rfia_fk_rfi.`id` AS 'rfia_fk_rfi__request_for_information_id',
	rfia_fk_rfi.`project_id` AS 'rfia_fk_rfi__project_id',
	rfia_fk_rfi.`rfi_sequence_number` AS 'rfia_fk_rfi__rfi_sequence_number',
	rfia_fk_rfi.`request_for_information_type_id` AS 'rfia_fk_rfi__request_for_information_type_id',
	rfia_fk_rfi.`request_for_information_status_id` AS 'rfia_fk_rfi__request_for_information_status_id',
	rfia_fk_rfi.`request_for_information_priority_id` AS 'rfia_fk_rfi__request_for_information_priority_id',
	rfia_fk_rfi.`rfi_file_manager_file_id` AS 'rfia_fk_rfi__rfi_file_manager_file_id',
	rfia_fk_rfi.`rfi_cost_code_id` AS 'rfia_fk_rfi__rfi_cost_code_id',
	rfia_fk_rfi.`rfi_creator_contact_id` AS 'rfia_fk_rfi__rfi_creator_contact_id',
	rfia_fk_rfi.`rfi_creator_contact_company_office_id` AS 'rfia_fk_rfi__rfi_creator_contact_company_office_id',
	rfia_fk_rfi.`rfi_creator_phone_contact_company_office_phone_number_id` AS 'rfia_fk_rfi__rfi_creator_phone_contact_company_office_phone_number_id',
	rfia_fk_rfi.`rfi_creator_fax_contact_company_office_phone_number_id` AS 'rfia_fk_rfi__rfi_creator_fax_contact_company_office_phone_number_id',
	rfia_fk_rfi.`rfi_creator_contact_mobile_phone_number_id` AS 'rfia_fk_rfi__rfi_creator_contact_mobile_phone_number_id',
	rfia_fk_rfi.`rfi_recipient_contact_id` AS 'rfia_fk_rfi__rfi_recipient_contact_id',
	rfia_fk_rfi.`rfi_recipient_contact_company_office_id` AS 'rfia_fk_rfi__rfi_recipient_contact_company_office_id',
	rfia_fk_rfi.`rfi_recipient_phone_contact_company_office_phone_number_id` AS 'rfia_fk_rfi__rfi_recipient_phone_contact_company_office_phone_number_id',
	rfia_fk_rfi.`rfi_recipient_fax_contact_company_office_phone_number_id` AS 'rfia_fk_rfi__rfi_recipient_fax_contact_company_office_phone_number_id',
	rfia_fk_rfi.`rfi_recipient_contact_mobile_phone_number_id` AS 'rfia_fk_rfi__rfi_recipient_contact_mobile_phone_number_id',
	rfia_fk_rfi.`rfi_initiator_contact_id` AS 'rfia_fk_rfi__rfi_initiator_contact_id',
	rfia_fk_rfi.`rfi_initiator_contact_company_office_id` AS 'rfia_fk_rfi__rfi_initiator_contact_company_office_id',
	rfia_fk_rfi.`rfi_initiator_phone_contact_company_office_phone_number_id` AS 'rfia_fk_rfi__rfi_initiator_phone_contact_company_office_phone_number_id',
	rfia_fk_rfi.`rfi_initiator_fax_contact_company_office_phone_number_id` AS 'rfia_fk_rfi__rfi_initiator_fax_contact_company_office_phone_number_id',
	rfia_fk_rfi.`rfi_initiator_contact_mobile_phone_number_id` AS 'rfia_fk_rfi__rfi_initiator_contact_mobile_phone_number_id',
	rfia_fk_rfi.`rfi_title` AS 'rfia_fk_rfi__rfi_title',
	rfia_fk_rfi.`rfi_plan_page_reference` AS 'rfia_fk_rfi__rfi_plan_page_reference',
	rfia_fk_rfi.`rfi_statement` AS 'rfia_fk_rfi__rfi_statement',
	rfia_fk_rfi.`created` AS 'rfia_fk_rfi__created',
	rfia_fk_rfi.`rfi_due_date` AS 'rfia_fk_rfi__rfi_due_date',
	rfia_fk_rfi.`rfi_closed_date` AS 'rfia_fk_rfi__rfi_closed_date',

	rfia_fk_fmfiles.`id` AS 'rfia_fk_fmfiles__file_manager_file_id',
	rfia_fk_fmfiles.`user_company_id` AS 'rfia_fk_fmfiles__user_company_id',
	rfia_fk_fmfiles.`contact_id` AS 'rfia_fk_fmfiles__contact_id',
	rfia_fk_fmfiles.`project_id` AS 'rfia_fk_fmfiles__project_id',
	rfia_fk_fmfiles.`file_manager_folder_id` AS 'rfia_fk_fmfiles__file_manager_folder_id',
	rfia_fk_fmfiles.`file_location_id` AS 'rfia_fk_fmfiles__file_location_id',
	rfia_fk_fmfiles.`virtual_file_name` AS 'rfia_fk_fmfiles__virtual_file_name',
	rfia_fk_fmfiles.`version_number` AS 'rfia_fk_fmfiles__version_number',
	rfia_fk_fmfiles.`virtual_file_name_sha1` AS 'rfia_fk_fmfiles__virtual_file_name_sha1',
	rfia_fk_fmfiles.`virtual_file_mime_type` AS 'rfia_fk_fmfiles__virtual_file_mime_type',
	rfia_fk_fmfiles.`modified` AS 'rfia_fk_fmfiles__modified',
	rfia_fk_fmfiles.`created` AS 'rfia_fk_fmfiles__created',
	rfia_fk_fmfiles.`deleted_flag` AS 'rfia_fk_fmfiles__deleted_flag',
	rfia_fk_fmfiles.`directly_deleted_flag` AS 'rfia_fk_fmfiles__directly_deleted_flag',

	rfia_fk_rfia_source_c.`id` AS 'rfia_fk_rfia_source_c__contact_id',
	rfia_fk_rfia_source_c.`user_company_id` AS 'rfia_fk_rfia_source_c__user_company_id',
	rfia_fk_rfia_source_c.`user_id` AS 'rfia_fk_rfia_source_c__user_id',
	rfia_fk_rfia_source_c.`contact_company_id` AS 'rfia_fk_rfia_source_c__contact_company_id',
	rfia_fk_rfia_source_c.`email` AS 'rfia_fk_rfia_source_c__email',
	rfia_fk_rfia_source_c.`name_prefix` AS 'rfia_fk_rfia_source_c__name_prefix',
	rfia_fk_rfia_source_c.`first_name` AS 'rfia_fk_rfia_source_c__first_name',
	rfia_fk_rfia_source_c.`additional_name` AS 'rfia_fk_rfia_source_c__additional_name',
	rfia_fk_rfia_source_c.`middle_name` AS 'rfia_fk_rfia_source_c__middle_name',
	rfia_fk_rfia_source_c.`last_name` AS 'rfia_fk_rfia_source_c__last_name',
	rfia_fk_rfia_source_c.`name_suffix` AS 'rfia_fk_rfia_source_c__name_suffix',
	rfia_fk_rfia_source_c.`title` AS 'rfia_fk_rfia_source_c__title',
	rfia_fk_rfia_source_c.`vendor_flag` AS 'rfia_fk_rfia_source_c__vendor_flag',

	rfia.*

FROM `request_for_information_attachments` rfia
	INNER JOIN `requests_for_information` rfia_fk_rfi ON rfia.`request_for_information_id` = rfia_fk_rfi.`id`
	INNER JOIN `file_manager_files` rfia_fk_fmfiles ON rfia.`rfi_attachment_file_manager_file_id` = rfia_fk_fmfiles.`id`
	INNER JOIN `contacts` rfia_fk_rfia_source_c ON rfia.`rfi_attachment_source_contact_id` = rfia_fk_rfia_source_c.`id`
WHERE rfia.`request_for_information_id` = ? {$filter} {$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `request_for_information_id` ASC, `rfi_attachment_file_manager_file_id` ASC, `rfi_attachment_source_contact_id` ASC, `sort_order` ASC
		$arrValues = array($request_for_information_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrRequestForInformationAttachmentsByRequestForInformationId = array();
		while ($row = $db->fetch()) {
			$requestForInformationAttachment = self::instantiateOrm($database, 'RequestForInformationAttachment', $row);
			/* @var $requestForInformationAttachment RequestForInformationAttachment */
			$requestForInformationAttachment->convertPropertiesToData();

			if (isset($row['request_for_information_id'])) {
				$request_for_information_id = $row['request_for_information_id'];
				$row['rfia_fk_rfi__id'] = $request_for_information_id;
				$requestForInformation = self::instantiateOrm($database, 'RequestForInformation', $row, null, $request_for_information_id, 'rfia_fk_rfi__');
				/* @var $requestForInformation RequestForInformation */
				$requestForInformation->convertPropertiesToData();
			} else {
				$requestForInformation = false;
			}
			$requestForInformationAttachment->setRequestForInformation($requestForInformation);

			if (isset($row['rfi_attachment_file_manager_file_id'])) {
				$rfi_attachment_file_manager_file_id = $row['rfi_attachment_file_manager_file_id'];
				$row['rfia_fk_fmfiles__id'] = $rfi_attachment_file_manager_file_id;
				$rfiAttachmentFileManagerFile = self::instantiateOrm($database, 'FileManagerFile', $row, null, $rfi_attachment_file_manager_file_id, 'rfia_fk_fmfiles__');
				/* @var $rfiAttachmentFileManagerFile FileManagerFile */
				$rfiAttachmentFileManagerFile->convertPropertiesToData();
			} else {
				$rfiAttachmentFileManagerFile = false;
			}
			$requestForInformationAttachment->setRfiAttachmentFileManagerFile($rfiAttachmentFileManagerFile);

			if (isset($row['rfi_attachment_source_contact_id'])) {
				$rfi_attachment_source_contact_id = $row['rfi_attachment_source_contact_id'];
				$row['rfia_fk_rfia_source_c__id'] = $rfi_attachment_source_contact_id;
				$rfiAttachmentSourceContact = self::instantiateOrm($database, 'Contact', $row, null, $rfi_attachment_source_contact_id, 'rfia_fk_rfia_source_c__');
				/* @var $rfiAttachmentSourceContact Contact */
				$rfiAttachmentSourceContact->convertPropertiesToData();
			} else {
				$rfiAttachmentSourceContact = false;
			}
			$requestForInformationAttachment->setRfiAttachmentSourceContact($rfiAttachmentSourceContact);

			$arrRequestForInformationAttachmentsByRequestForInformationId[] = $requestForInformationAttachment;
		}

		$db->free_result();

		self::$_arrRequestForInformationAttachmentsByRequestForInformationId = $arrRequestForInformationAttachmentsByRequestForInformationId;

		return $arrRequestForInformationAttachmentsByRequestForInformationId;
	}

	/**
	 * Load by constraint `request_for_information_attachments_fk_fmfiles` foreign key (`rfi_attachment_file_manager_file_id`) references `file_manager_files` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $rfi_attachment_file_manager_file_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadRequestForInformationAttachmentsByRfiAttachmentFileManagerFileId($database, $rfi_attachment_file_manager_file_id, Input $options=null)
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
			self::$_arrRequestForInformationAttachmentsByRfiAttachmentFileManagerFileId = null;
		}

		$arrRequestForInformationAttachmentsByRfiAttachmentFileManagerFileId = self::$_arrRequestForInformationAttachmentsByRfiAttachmentFileManagerFileId;
		if (isset($arrRequestForInformationAttachmentsByRfiAttachmentFileManagerFileId) && !empty($arrRequestForInformationAttachmentsByRfiAttachmentFileManagerFileId)) {
			return $arrRequestForInformationAttachmentsByRfiAttachmentFileManagerFileId;
		}

		$rfi_attachment_file_manager_file_id = (int) $rfi_attachment_file_manager_file_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `request_for_information_id` ASC, `rfi_attachment_file_manager_file_id` ASC, `rfi_attachment_source_contact_id` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY rfia.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpRequestForInformationAttachment = new RequestForInformationAttachment($database);
			$sqlOrderByColumns = $tmpRequestForInformationAttachment->constructSqlOrderByColumns($arrOrderByAttributes);

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
	rfia.*

FROM `request_for_information_attachments` rfia
WHERE rfia.`rfi_attachment_file_manager_file_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `request_for_information_id` ASC, `rfi_attachment_file_manager_file_id` ASC, `rfi_attachment_source_contact_id` ASC, `sort_order` ASC
		$arrValues = array($rfi_attachment_file_manager_file_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrRequestForInformationAttachmentsByRfiAttachmentFileManagerFileId = array();
		while ($row = $db->fetch()) {
			$requestForInformationAttachment = self::instantiateOrm($database, 'RequestForInformationAttachment', $row);
			/* @var $requestForInformationAttachment RequestForInformationAttachment */
			$arrRequestForInformationAttachmentsByRfiAttachmentFileManagerFileId[] = $requestForInformationAttachment;
		}

		$db->free_result();

		self::$_arrRequestForInformationAttachmentsByRfiAttachmentFileManagerFileId = $arrRequestForInformationAttachmentsByRfiAttachmentFileManagerFileId;

		return $arrRequestForInformationAttachmentsByRfiAttachmentFileManagerFileId;
	}

	/**
	 * Load by constraint `request_for_information_attachments_fk_rfia_source_c` foreign key (`rfi_attachment_source_contact_id`) references `contacts` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $rfi_attachment_source_contact_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadRequestForInformationAttachmentsByRfiAttachmentSourceContactId($database, $rfi_attachment_source_contact_id, Input $options=null)
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
			self::$_arrRequestForInformationAttachmentsByRfiAttachmentSourceContactId = null;
		}

		$arrRequestForInformationAttachmentsByRfiAttachmentSourceContactId = self::$_arrRequestForInformationAttachmentsByRfiAttachmentSourceContactId;
		if (isset($arrRequestForInformationAttachmentsByRfiAttachmentSourceContactId) && !empty($arrRequestForInformationAttachmentsByRfiAttachmentSourceContactId)) {
			return $arrRequestForInformationAttachmentsByRfiAttachmentSourceContactId;
		}

		$rfi_attachment_source_contact_id = (int) $rfi_attachment_source_contact_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `request_for_information_id` ASC, `rfi_attachment_file_manager_file_id` ASC, `rfi_attachment_source_contact_id` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY rfia.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpRequestForInformationAttachment = new RequestForInformationAttachment($database);
			$sqlOrderByColumns = $tmpRequestForInformationAttachment->constructSqlOrderByColumns($arrOrderByAttributes);

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
	rfia.*

FROM `request_for_information_attachments` rfia
WHERE rfia.`rfi_attachment_source_contact_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `request_for_information_id` ASC, `rfi_attachment_file_manager_file_id` ASC, `rfi_attachment_source_contact_id` ASC, `sort_order` ASC
		$arrValues = array($rfi_attachment_source_contact_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrRequestForInformationAttachmentsByRfiAttachmentSourceContactId = array();
		while ($row = $db->fetch()) {
			$requestForInformationAttachment = self::instantiateOrm($database, 'RequestForInformationAttachment', $row);
			/* @var $requestForInformationAttachment RequestForInformationAttachment */
			$arrRequestForInformationAttachmentsByRfiAttachmentSourceContactId[] = $requestForInformationAttachment;
		}

		$db->free_result();

		self::$_arrRequestForInformationAttachmentsByRfiAttachmentSourceContactId = $arrRequestForInformationAttachmentsByRfiAttachmentSourceContactId;

		return $arrRequestForInformationAttachmentsByRfiAttachmentSourceContactId;
	}

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all request_for_information_attachments records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllRequestForInformationAttachments($database, Input $options=null)
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
			self::$_arrAllRequestForInformationAttachments = null;
		}

		$arrAllRequestForInformationAttachments = self::$_arrAllRequestForInformationAttachments;
		if (isset($arrAllRequestForInformationAttachments) && !empty($arrAllRequestForInformationAttachments)) {
			return $arrAllRequestForInformationAttachments;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `request_for_information_id` ASC, `rfi_attachment_file_manager_file_id` ASC, `rfi_attachment_source_contact_id` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY rfia.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpRequestForInformationAttachment = new RequestForInformationAttachment($database);
			$sqlOrderByColumns = $tmpRequestForInformationAttachment->constructSqlOrderByColumns($arrOrderByAttributes);

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
	rfia.*

FROM `request_for_information_attachments` rfia{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `request_for_information_id` ASC, `rfi_attachment_file_manager_file_id` ASC, `rfi_attachment_source_contact_id` ASC, `sort_order` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllRequestForInformationAttachments = array();
		while ($row = $db->fetch()) {
			$requestForInformationAttachment = self::instantiateOrm($database, 'RequestForInformationAttachment', $row);
			/* @var $requestForInformationAttachment RequestForInformationAttachment */
			$arrAllRequestForInformationAttachments[] = $requestForInformationAttachment;
		}

		$db->free_result();

		self::$_arrAllRequestForInformationAttachments = $arrAllRequestForInformationAttachments;

		return $arrAllRequestForInformationAttachments;
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
INTO `request_for_information_attachments`
(`request_for_information_id`, `rfi_attachment_file_manager_file_id`, `rfi_attachment_source_contact_id`,`is_added`, `sort_order`)
VALUES (?, ?, ?, ? ,?)
ON DUPLICATE KEY UPDATE `rfi_attachment_source_contact_id` = ?,`is_added`=?, `sort_order` = ?
";
		$arrValues = array($this->request_for_information_id, $this->rfi_attachment_file_manager_file_id, $this->rfi_attachment_source_contact_id,$this->is_added, $this->sort_order, $this->rfi_attachment_source_contact_id,$this->is_added, $this->sort_order);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$request_for_information_attachment_id = $db->insertId;
		$db->free_result();

		return $request_for_information_attachment_id;
	}

	// Save: insert ignore

	/**
	 * Find rfi_attachment_sequence_number value.
	 *
	 * @param string $database
	 * @param int $request_for_information_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findNextRFIAttachmentSequenceNumber($database, $request_for_information_id)
	{
		$next_rfi_attachment_sequence_number = 1;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT MAX(rfia.rfi_attachment_sequence_number) AS 'max_rfi_attachment_sequence_number'
FROM `request_for_information_attachments` rfia
WHERE rfia.`request_for_information_id` = ?
";
		$arrValues = array($request_for_information_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$max_rfi_attachment_sequence_number = $row['max_rfi_attachment_sequence_number'];
			$next_rfi_attachment_sequence_number = $max_rfi_attachment_sequence_number + 1;
		}

		return $next_rfi_attachment_sequence_number;
	}
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

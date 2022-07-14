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
 * ChangeOrderDraftAttachment.
 *
 * @category   Framework
 * @package    ChangeOrderDraftAttachment
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class ChangeOrderDraftAttachment extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'ChangeOrderDraftAttachment';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'change_order_draft_attachments';

	/**
	 * Singular version of the table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_tableNameSingular = 'change_order_draft_attachment';

	/**
	 * primary key (`change_order_draft_id`,`co_attachment_file_manager_file_id`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrPrimaryKey = array(
		'change_order_draft_id' => 'int',
		'co_attachment_file_manager_file_id' => 'int'
	);

	/**
	 * No Unique Indexes, Just a Primary Key
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_change_order_draft_attachment_via_primary_key' => array(
			'change_order_draft_id' => 'int',
			'co_attachment_file_manager_file_id' => 'int'
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
		'change_order_draft_id' => 'change_order_draft_id',
		'co_attachment_file_manager_file_id' => 'co_attachment_file_manager_file_id',

		'co_attachment_source_contact_id' => 'co_attachment_source_contact_id',

		'sort_order' => 'sort_order'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $change_order_draft_id;
	public $co_attachment_file_manager_file_id;

	public $co_attachment_source_contact_id;

	public $sort_order;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties

	// HTML ENTITY ENCODED NL2BR ORM string properties

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)
	protected static $_arrChangeOrderDraftAttachmentsByChangeOrderDraftId;
	protected static $_arrChangeOrderDraftAttachmentsByCoAttachmentFileManagerFileId;
	protected static $_arrChangeOrderDraftAttachmentsByCoAttachmentSourceContactId;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllChangeOrderDraftAttachments;

	// Foreign Key Objects
	private $_changeOrderDraft;
	private $_coAttachmentFileManagerFile;
	private $_coAttachmentSourceContact;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='change_order_draft_attachments')
	{
		parent::__construct($table);
		$this->setDatabase($database);
	}

	// Foreign Key Object Accessor Methods
	public function getChangeOrderDraft()
	{
		if (isset($this->_changeOrderDraft)) {
			return $this->_changeOrderDraft;
		} else {
			return null;
		}
	}

	public function setChangeOrderDraft($changeOrderDraft)
	{
		$this->_changeOrderDraft = $changeOrderDraft;
	}

	public function getCoAttachmentFileManagerFile()
	{
		if (isset($this->_coAttachmentFileManagerFile)) {
			return $this->_coAttachmentFileManagerFile;
		} else {
			return null;
		}
	}

	public function setCoAttachmentFileManagerFile($coAttachmentFileManagerFile)
	{
		$this->_coAttachmentFileManagerFile = $coAttachmentFileManagerFile;
	}

	public function getCoAttachmentSourceContact()
	{
		if (isset($this->_coAttachmentSourceContact)) {
			return $this->_coAttachmentSourceContact;
		} else {
			return null;
		}
	}

	public function setCoAttachmentSourceContact($coAttachmentSourceContact)
	{
		$this->_coAttachmentSourceContact = $coAttachmentSourceContact;
	}

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)
	public static function getArrChangeOrderDraftAttachmentsByChangeOrderDraftId()
	{
		if (isset(self::$_arrChangeOrderDraftAttachmentsByChangeOrderDraftId)) {
			return self::$_arrChangeOrderDraftAttachmentsByChangeOrderDraftId;
		} else {
			return null;
		}
	}

	public static function setArrChangeOrderDraftAttachmentsByChangeOrderDraftId($arrChangeOrderDraftAttachmentsByChangeOrderDraftId)
	{
		self::$_arrChangeOrderDraftAttachmentsByChangeOrderDraftId = $arrChangeOrderDraftAttachmentsByChangeOrderDraftId;
	}

	public static function getArrChangeOrderDraftAttachmentsByCoAttachmentFileManagerFileId()
	{
		if (isset(self::$_arrChangeOrderDraftAttachmentsByCoAttachmentFileManagerFileId)) {
			return self::$_arrChangeOrderDraftAttachmentsByCoAttachmentFileManagerFileId;
		} else {
			return null;
		}
	}

	public static function setArrChangeOrderDraftAttachmentsByCoAttachmentFileManagerFileId($arrChangeOrderDraftAttachmentsByCoAttachmentFileManagerFileId)
	{
		self::$_arrChangeOrderDraftAttachmentsByCoAttachmentFileManagerFileId = $arrChangeOrderDraftAttachmentsByCoAttachmentFileManagerFileId;
	}

	public static function getArrChangeOrderDraftAttachmentsByCoAttachmentSourceContactId()
	{
		if (isset(self::$_arrChangeOrderDraftAttachmentsByCoAttachmentSourceContactId)) {
			return self::$_arrChangeOrderDraftAttachmentsByCoAttachmentSourceContactId;
		} else {
			return null;
		}
	}

	public static function setArrChangeOrderDraftAttachmentsByCoAttachmentSourceContactId($arrChangeOrderDraftAttachmentsByCoAttachmentSourceContactId)
	{
		self::$_arrChangeOrderDraftAttachmentsByCoAttachmentSourceContactId = $arrChangeOrderDraftAttachmentsByCoAttachmentSourceContactId;
	}

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllChangeOrderDraftAttachments()
	{
		if (isset(self::$_arrAllChangeOrderDraftAttachments)) {
			return self::$_arrAllChangeOrderDraftAttachments;
		} else {
			return null;
		}
	}

	public static function setArrAllChangeOrderDraftAttachments($arrAllChangeOrderDraftAttachments)
	{
		self::$_arrAllChangeOrderDraftAttachments = $arrAllChangeOrderDraftAttachments;
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
	 * Find by primary key (`change_order_draft_id`,`co_attachment_file_manager_file_id`).
	 *
	 * @param string $database
	 * @param int $change_order_draft_id
	 * @param int $co_attachment_file_manager_file_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findByChangeOrderDraftIdAndCoAttachmentFileManagerFileId($database, $change_order_draft_id, $co_attachment_file_manager_file_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	coda.*

FROM `change_order_draft_attachments` coda
WHERE coda.`change_order_draft_id` = ?
AND coda.`co_attachment_file_manager_file_id` = ?
";
		$arrValues = array($change_order_draft_id, $co_attachment_file_manager_file_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row && !empty($row)) {
			$changeOrderDraftAttachment = self::instantiateOrm($database, 'ChangeOrderDraftAttachment', $row);
			/* @var $changeOrderDraftAttachment ChangeOrderDraftAttachment */
			return $changeOrderDraftAttachment;
		} else {
			return false;
		}
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Find by primary key (`change_order_draft_id`,`co_attachment_file_manager_file_id`) Extended.
	 *
	 * @param string $database
	 * @param int $change_order_draft_id
	 * @param int $co_attachment_file_manager_file_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findByChangeOrderDraftIdAndCoAttachmentFileManagerFileIdExtended($database, $change_order_draft_id, $co_attachment_file_manager_file_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	coda_fk_cod.`id` AS 'coda_fk_cod__change_order_draft_id',
	coda_fk_cod.`project_id` AS 'coda_fk_cod__project_id',
	coda_fk_cod.`change_order_type_id` AS 'coda_fk_cod__change_order_type_id',
	coda_fk_cod.`change_order_priority_id` AS 'coda_fk_cod__change_order_priority_id',
	coda_fk_cod.`co_file_manager_file_id` AS 'coda_fk_cod__co_file_manager_file_id',
	coda_fk_cod.`co_cost_code_id` AS 'coda_fk_cod__co_cost_code_id',
	coda_fk_cod.`co_creator_contact_id` AS 'coda_fk_cod__co_creator_contact_id',
	coda_fk_cod.`co_creator_contact_company_office_id` AS 'coda_fk_cod__co_creator_contact_company_office_id',
	coda_fk_cod.`co_creator_phone_contact_company_office_phone_number_id` AS 'coda_fk_cod__co_creator_phone_contact_company_office_phone_number_id',
	coda_fk_cod.`co_creator_fax_contact_company_office_phone_number_id` AS 'coda_fk_cod__co_creator_fax_contact_company_office_phone_number_id',
	coda_fk_cod.`co_creator_contact_mobile_phone_number_id` AS 'coda_fk_cod__co_creator_contact_mobile_phone_number_id',
	coda_fk_cod.`co_recipient_contact_id` AS 'coda_fk_cod__co_recipient_contact_id',
	coda_fk_cod.`co_recipient_contact_company_office_id` AS 'coda_fk_cod__co_recipient_contact_company_office_id',
	coda_fk_cod.`co_recipient_phone_contact_company_office_phone_number_id` AS 'coda_fk_cod__co_recipient_phone_contact_company_office_phone_number_id',
	coda_fk_cod.`co_recipient_fax_contact_company_office_phone_number_id` AS 'coda_fk_cod__co_recipient_fax_contact_company_office_phone_number_id',
	coda_fk_cod.`co_recipient_contact_mobile_phone_number_id` AS 'coda_fk_cod__co_recipient_contact_mobile_phone_number_id',
	coda_fk_cod.`co_initiator_contact_id` AS 'coda_fk_cod__co_initiator_contact_id',
	coda_fk_cod.`co_initiator_contact_company_office_id` AS 'coda_fk_cod__co_initiator_contact_company_office_id',
	coda_fk_cod.`co_initiator_phone_contact_company_office_phone_number_id` AS 'coda_fk_cod__co_initiator_phone_contact_company_office_phone_number_id',
	coda_fk_cod.`co_initiator_fax_contact_company_office_phone_number_id` AS 'coda_fk_cod__co_initiator_fax_contact_company_office_phone_number_id',
	coda_fk_cod.`co_initiator_contact_mobile_phone_number_id` AS 'coda_fk_cod__co_initiator_contact_mobile_phone_number_id',
	coda_fk_cod.`co_title` AS 'coda_fk_cod__co_title',
	coda_fk_cod.`co_plan_page_reference` AS 'coda_fk_cod__co_plan_page_reference',
	coda_fk_cod.`co_statement` AS 'coda_fk_cod__co_statement',
	coda_fk_cod.`co_revised_project_completion_date` AS 'coda_fk_cod__co_revised_project_completion_date',

	coda_fk_fmfiles.`id` AS 'coda_fk_fmfiles__file_manager_file_id',
	coda_fk_fmfiles.`user_company_id` AS 'coda_fk_fmfiles__user_company_id',
	coda_fk_fmfiles.`contact_id` AS 'coda_fk_fmfiles__contact_id',
	coda_fk_fmfiles.`project_id` AS 'coda_fk_fmfiles__project_id',
	coda_fk_fmfiles.`file_manager_folder_id` AS 'coda_fk_fmfiles__file_manager_folder_id',
	coda_fk_fmfiles.`file_location_id` AS 'coda_fk_fmfiles__file_location_id',
	coda_fk_fmfiles.`virtual_file_name` AS 'coda_fk_fmfiles__virtual_file_name',
	coda_fk_fmfiles.`version_number` AS 'coda_fk_fmfiles__version_number',
	coda_fk_fmfiles.`virtual_file_name_sha1` AS 'coda_fk_fmfiles__virtual_file_name_sha1',
	coda_fk_fmfiles.`virtual_file_mime_type` AS 'coda_fk_fmfiles__virtual_file_mime_type',
	coda_fk_fmfiles.`modified` AS 'coda_fk_fmfiles__modified',
	coda_fk_fmfiles.`created` AS 'coda_fk_fmfiles__created',
	coda_fk_fmfiles.`deleted_flag` AS 'coda_fk_fmfiles__deleted_flag',
	coda_fk_fmfiles.`directly_deleted_flag` AS 'coda_fk_fmfiles__directly_deleted_flag',

	coda_fk_coda_source_c.`id` AS 'coda_fk_coda_source_c__contact_id',
	coda_fk_coda_source_c.`user_company_id` AS 'coda_fk_coda_source_c__user_company_id',
	coda_fk_coda_source_c.`user_id` AS 'coda_fk_coda_source_c__user_id',
	coda_fk_coda_source_c.`contact_company_id` AS 'coda_fk_coda_source_c__contact_company_id',
	coda_fk_coda_source_c.`email` AS 'coda_fk_coda_source_c__email',
	coda_fk_coda_source_c.`name_prefix` AS 'coda_fk_coda_source_c__name_prefix',
	coda_fk_coda_source_c.`first_name` AS 'coda_fk_coda_source_c__first_name',
	coda_fk_coda_source_c.`additional_name` AS 'coda_fk_coda_source_c__additional_name',
	coda_fk_coda_source_c.`middle_name` AS 'coda_fk_coda_source_c__middle_name',
	coda_fk_coda_source_c.`last_name` AS 'coda_fk_coda_source_c__last_name',
	coda_fk_coda_source_c.`name_suffix` AS 'coda_fk_coda_source_c__name_suffix',
	coda_fk_coda_source_c.`title` AS 'coda_fk_coda_source_c__title',
	coda_fk_coda_source_c.`vendor_flag` AS 'coda_fk_coda_source_c__vendor_flag',

	coda.*

FROM `change_order_draft_attachments` coda
	INNER JOIN `change_order_drafts` coda_fk_cod ON coda.`change_order_draft_id` = coda_fk_cod.`id`
	INNER JOIN `file_manager_files` coda_fk_fmfiles ON coda.`co_attachment_file_manager_file_id` = coda_fk_fmfiles.`id`
	INNER JOIN `contacts` coda_fk_coda_source_c ON coda.`co_attachment_source_contact_id` = coda_fk_coda_source_c.`id`
WHERE coda.`change_order_draft_id` = ?
AND coda.`co_attachment_file_manager_file_id` = ?
";
		$arrValues = array($change_order_draft_id, $co_attachment_file_manager_file_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row && !empty($row)) {
			$changeOrderDraftAttachment = self::instantiateOrm($database, 'ChangeOrderDraftAttachment', $row);
			/* @var $changeOrderDraftAttachment ChangeOrderDraftAttachment */
			$changeOrderDraftAttachment->convertPropertiesToData();

			if (isset($row['change_order_draft_id'])) {
				$change_order_draft_id = $row['change_order_draft_id'];
				$row['coda_fk_cod__id'] = $change_order_draft_id;
				$changeOrderDraft = self::instantiateOrm($database, 'ChangeOrderDraft', $row, null, $change_order_draft_id, 'coda_fk_cod__');
				/* @var $changeOrderDraft ChangeOrderDraft */
				$changeOrderDraft->convertPropertiesToData();
			} else {
				$changeOrderDraft = false;
			}
			$changeOrderDraftAttachment->setChangeOrderDraft($changeOrderDraft);

			if (isset($row['co_attachment_file_manager_file_id'])) {
				$co_attachment_file_manager_file_id = $row['co_attachment_file_manager_file_id'];
				$row['coda_fk_fmfiles__id'] = $co_attachment_file_manager_file_id;
				$coAttachmentFileManagerFile = self::instantiateOrm($database, 'FileManagerFile', $row, null, $co_attachment_file_manager_file_id, 'coda_fk_fmfiles__');
				/* @var $coAttachmentFileManagerFile FileManagerFile */
				$coAttachmentFileManagerFile->convertPropertiesToData();
			} else {
				$coAttachmentFileManagerFile = false;
			}
			$changeOrderDraftAttachment->setCoAttachmentFileManagerFile($coAttachmentFileManagerFile);

			if (isset($row['co_attachment_source_contact_id'])) {
				$co_attachment_source_contact_id = $row['co_attachment_source_contact_id'];
				$row['coda_fk_coda_source_c__id'] = $co_attachment_source_contact_id;
				$coAttachmentSourceContact = self::instantiateOrm($database, 'Contact', $row, null, $co_attachment_source_contact_id, 'coda_fk_coda_source_c__');
				/* @var $coAttachmentSourceContact Contact */
				$coAttachmentSourceContact->convertPropertiesToData();
			} else {
				$coAttachmentSourceContact = false;
			}
			$changeOrderDraftAttachment->setCoAttachmentSourceContact($coAttachmentSourceContact);

			return $changeOrderDraftAttachment;
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
	 * @param array $arrChangeOrderDraftIdAndCoAttachmentFileManagerFileIdList
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadChangeOrderDraftAttachmentsByArrChangeOrderDraftIdAndCoAttachmentFileManagerFileIdList($database, $arrChangeOrderDraftIdAndCoAttachmentFileManagerFileIdList, Input $options=null)
	{
		if (empty($arrChangeOrderDraftIdAndCoAttachmentFileManagerFileIdList)) {
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
		// ORDER BY `change_order_draft_id` ASC, `co_attachment_file_manager_file_id` ASC, `co_attachment_source_contact_id` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY coda.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpChangeOrderDraftAttachment = new ChangeOrderDraftAttachment($database);
			$sqlOrderByColumns = $tmpChangeOrderDraftAttachment->constructSqlOrderByColumns($arrOrderByAttributes);

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
		foreach ($arrChangeOrderDraftIdAndCoAttachmentFileManagerFileIdList as $k => $arrTmp) {
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
		if (count($arrChangeOrderDraftIdAndCoAttachmentFileManagerFileIdList) > 1) {
			$sqlWhere = join($arrSqlWhere, ' OR ');
			$sqlWhere = "WHERE ($sqlWhere)";
		} else {
			$sqlWhere = "WHERE $tmpInnerAnd";
		}

		$query =
"
SELECT

	coda.*

FROM `change_order_draft_attachments` coda
{$sqlWhere}{$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrChangeOrderDraftAttachmentsByArrChangeOrderDraftIdAndCoAttachmentFileManagerFileIdList = array();
		while ($row = $db->fetch()) {
			$changeOrderDraftAttachment = self::instantiateOrm($database, 'ChangeOrderDraftAttachment', $row);
			/* @var $changeOrderDraftAttachment ChangeOrderDraftAttachment */
			$arrChangeOrderDraftAttachmentsByArrChangeOrderDraftIdAndCoAttachmentFileManagerFileIdList[] = $changeOrderDraftAttachment;
		}

		$db->free_result();

		return $arrChangeOrderDraftAttachmentsByArrChangeOrderDraftIdAndCoAttachmentFileManagerFileIdList;
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `change_order_draft_attachments_fk_cod` foreign key (`change_order_draft_id`) references `change_order_drafts` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $change_order_draft_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadChangeOrderDraftAttachmentsByChangeOrderDraftId($database, $change_order_draft_id, Input $options=null)
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
			self::$_arrChangeOrderDraftAttachmentsByChangeOrderDraftId = null;
		}

		$arrChangeOrderDraftAttachmentsByChangeOrderDraftId = self::$_arrChangeOrderDraftAttachmentsByChangeOrderDraftId;
		if (isset($arrChangeOrderDraftAttachmentsByChangeOrderDraftId) && !empty($arrChangeOrderDraftAttachmentsByChangeOrderDraftId)) {
			return $arrChangeOrderDraftAttachmentsByChangeOrderDraftId;
		}

		$change_order_draft_id = (int) $change_order_draft_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `change_order_draft_id` ASC, `co_attachment_file_manager_file_id` ASC, `co_attachment_source_contact_id` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY coda.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpChangeOrderDraftAttachment = new ChangeOrderDraftAttachment($database);
			$sqlOrderByColumns = $tmpChangeOrderDraftAttachment->constructSqlOrderByColumns($arrOrderByAttributes);

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
	coda.*

FROM `change_order_draft_attachments` coda
WHERE coda.`change_order_draft_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `change_order_draft_id` ASC, `co_attachment_file_manager_file_id` ASC, `co_attachment_source_contact_id` ASC, `sort_order` ASC
		$arrValues = array($change_order_draft_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrChangeOrderDraftAttachmentsByChangeOrderDraftId = array();
		while ($row = $db->fetch()) {
			$changeOrderDraftAttachment = self::instantiateOrm($database, 'ChangeOrderDraftAttachment', $row);
			/* @var $changeOrderDraftAttachment ChangeOrderDraftAttachment */
			$arrChangeOrderDraftAttachmentsByChangeOrderDraftId[] = $changeOrderDraftAttachment;
		}

		$db->free_result();

		self::$_arrChangeOrderDraftAttachmentsByChangeOrderDraftId = $arrChangeOrderDraftAttachmentsByChangeOrderDraftId;

		return $arrChangeOrderDraftAttachmentsByChangeOrderDraftId;
	}

	/**
	 * Load by constraint `change_order_draft_attachments_fk_fmfiles` foreign key (`co_attachment_file_manager_file_id`) references `file_manager_files` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $co_attachment_file_manager_file_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadChangeOrderDraftAttachmentsByCoAttachmentFileManagerFileId($database, $co_attachment_file_manager_file_id, Input $options=null)
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
			self::$_arrChangeOrderDraftAttachmentsByCoAttachmentFileManagerFileId = null;
		}

		$arrChangeOrderDraftAttachmentsByCoAttachmentFileManagerFileId = self::$_arrChangeOrderDraftAttachmentsByCoAttachmentFileManagerFileId;
		if (isset($arrChangeOrderDraftAttachmentsByCoAttachmentFileManagerFileId) && !empty($arrChangeOrderDraftAttachmentsByCoAttachmentFileManagerFileId)) {
			return $arrChangeOrderDraftAttachmentsByCoAttachmentFileManagerFileId;
		}

		$co_attachment_file_manager_file_id = (int) $co_attachment_file_manager_file_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `change_order_draft_id` ASC, `co_attachment_file_manager_file_id` ASC, `co_attachment_source_contact_id` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY coda.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpChangeOrderDraftAttachment = new ChangeOrderDraftAttachment($database);
			$sqlOrderByColumns = $tmpChangeOrderDraftAttachment->constructSqlOrderByColumns($arrOrderByAttributes);

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
	coda.*

FROM `change_order_draft_attachments` coda
WHERE coda.`co_attachment_file_manager_file_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `change_order_draft_id` ASC, `co_attachment_file_manager_file_id` ASC, `co_attachment_source_contact_id` ASC, `sort_order` ASC
		$arrValues = array($co_attachment_file_manager_file_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrChangeOrderDraftAttachmentsByCoAttachmentFileManagerFileId = array();
		while ($row = $db->fetch()) {
			$changeOrderDraftAttachment = self::instantiateOrm($database, 'ChangeOrderDraftAttachment', $row);
			/* @var $changeOrderDraftAttachment ChangeOrderDraftAttachment */
			$arrChangeOrderDraftAttachmentsByCoAttachmentFileManagerFileId[] = $changeOrderDraftAttachment;
		}

		$db->free_result();

		self::$_arrChangeOrderDraftAttachmentsByCoAttachmentFileManagerFileId = $arrChangeOrderDraftAttachmentsByCoAttachmentFileManagerFileId;

		return $arrChangeOrderDraftAttachmentsByCoAttachmentFileManagerFileId;
	}

	/**
	 * Load by constraint `change_order_draft_attachments_fk_coda_source_c` foreign key (`co_attachment_source_contact_id`) references `contacts` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $co_attachment_source_contact_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadChangeOrderDraftAttachmentsByCoAttachmentSourceContactId($database, $co_attachment_source_contact_id, Input $options=null)
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
			self::$_arrChangeOrderDraftAttachmentsByCoAttachmentSourceContactId = null;
		}

		$arrChangeOrderDraftAttachmentsByCoAttachmentSourceContactId = self::$_arrChangeOrderDraftAttachmentsByCoAttachmentSourceContactId;
		if (isset($arrChangeOrderDraftAttachmentsByCoAttachmentSourceContactId) && !empty($arrChangeOrderDraftAttachmentsByCoAttachmentSourceContactId)) {
			return $arrChangeOrderDraftAttachmentsByCoAttachmentSourceContactId;
		}

		$co_attachment_source_contact_id = (int) $co_attachment_source_contact_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `change_order_draft_id` ASC, `co_attachment_file_manager_file_id` ASC, `co_attachment_source_contact_id` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY coda.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpChangeOrderDraftAttachment = new ChangeOrderDraftAttachment($database);
			$sqlOrderByColumns = $tmpChangeOrderDraftAttachment->constructSqlOrderByColumns($arrOrderByAttributes);

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
	coda.*

FROM `change_order_draft_attachments` coda
WHERE coda.`co_attachment_source_contact_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `change_order_draft_id` ASC, `co_attachment_file_manager_file_id` ASC, `co_attachment_source_contact_id` ASC, `sort_order` ASC
		$arrValues = array($co_attachment_source_contact_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrChangeOrderDraftAttachmentsByCoAttachmentSourceContactId = array();
		while ($row = $db->fetch()) {
			$changeOrderDraftAttachment = self::instantiateOrm($database, 'ChangeOrderDraftAttachment', $row);
			/* @var $changeOrderDraftAttachment ChangeOrderDraftAttachment */
			$arrChangeOrderDraftAttachmentsByCoAttachmentSourceContactId[] = $changeOrderDraftAttachment;
		}

		$db->free_result();

		self::$_arrChangeOrderDraftAttachmentsByCoAttachmentSourceContactId = $arrChangeOrderDraftAttachmentsByCoAttachmentSourceContactId;

		return $arrChangeOrderDraftAttachmentsByCoAttachmentSourceContactId;
	}

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all change_order_draft_attachments records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllChangeOrderDraftAttachments($database, Input $options=null)
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
			self::$_arrAllChangeOrderDraftAttachments = null;
		}

		$arrAllChangeOrderDraftAttachments = self::$_arrAllChangeOrderDraftAttachments;
		if (isset($arrAllChangeOrderDraftAttachments) && !empty($arrAllChangeOrderDraftAttachments)) {
			return $arrAllChangeOrderDraftAttachments;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `change_order_draft_id` ASC, `co_attachment_file_manager_file_id` ASC, `co_attachment_source_contact_id` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY coda.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpChangeOrderDraftAttachment = new ChangeOrderDraftAttachment($database);
			$sqlOrderByColumns = $tmpChangeOrderDraftAttachment->constructSqlOrderByColumns($arrOrderByAttributes);

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
	coda.*

FROM `change_order_draft_attachments` coda{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `change_order_draft_id` ASC, `co_attachment_file_manager_file_id` ASC, `co_attachment_source_contact_id` ASC, `sort_order` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllChangeOrderDraftAttachments = array();
		while ($row = $db->fetch()) {
			$changeOrderDraftAttachment = self::instantiateOrm($database, 'ChangeOrderDraftAttachment', $row);
			/* @var $changeOrderDraftAttachment ChangeOrderDraftAttachment */
			$arrAllChangeOrderDraftAttachments[] = $changeOrderDraftAttachment;
		}

		$db->free_result();

		self::$_arrAllChangeOrderDraftAttachments = $arrAllChangeOrderDraftAttachments;

		return $arrAllChangeOrderDraftAttachments;
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
INTO `change_order_draft_attachments`
(`change_order_draft_id`, `co_attachment_file_manager_file_id`, `co_attachment_source_contact_id`, `sort_order`)
VALUES (?, ?, ?, ?)
ON DUPLICATE KEY UPDATE `co_attachment_source_contact_id` = ?, `sort_order` = ?
";
		$arrValues = array($this->change_order_draft_id, $this->co_attachment_file_manager_file_id, $this->co_attachment_source_contact_id, $this->sort_order, $this->co_attachment_source_contact_id, $this->sort_order);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$change_order_draft_attachment_id = $db->insertId;
		$db->free_result();

		return $change_order_draft_attachment_id;
	}

	// Save: insert ignore
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

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
 * SubmittalDraftAttachment.
 *
 * @category   Framework
 * @package    SubmittalDraftAttachment
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class SubmittalDraftAttachment extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'SubmittalDraftAttachment';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'submittal_draft_attachments';

	/**
	 * primary key (`submittal_draft_id`,`su_attachment_file_manager_file_id`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrPrimaryKey = array(
		'submittal_draft_id' => 'int',
		'su_attachment_file_manager_file_id' => 'int'
	);

	/**
	 * No Unique Indexes, Just a Primary Key
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_submittal_draft_attachment_via_primary_key' => array(
			'submittal_draft_id' => 'int',
			'su_attachment_file_manager_file_id' => 'int'
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
		'su_attachment_file_manager_file_id' => 'su_attachment_file_manager_file_id',

		'su_attachment_source_contact_id' => 'su_attachment_source_contact_id',

		'sort_order' => 'sort_order'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $submittal_draft_id;
	public $su_attachment_file_manager_file_id;

	public $su_attachment_source_contact_id;

	public $sort_order;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties

	// HTML ENTITY ENCODED NL2BR ORM string properties

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)
	protected static $_arrSubmittalDraftAttachmentsBySubmittalDraftId;
	protected static $_arrSubmittalDraftAttachmentsBySuAttachmentFileManagerFileId;
	protected static $_arrSubmittalDraftAttachmentsBySuAttachmentSourceContactId;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllSubmittalDraftAttachments;

	// Foreign Key Objects
	private $_submittalDraft;
	private $_suAttachmentFileManagerFile;
	private $_suAttachmentSourceContact;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='submittal_draft_attachments')
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

	public function getSuAttachmentFileManagerFile()
	{
		if (isset($this->_suAttachmentFileManagerFile)) {
			return $this->_suAttachmentFileManagerFile;
		} else {
			return null;
		}
	}

	public function setSuAttachmentFileManagerFile($suAttachmentFileManagerFile)
	{
		$this->_suAttachmentFileManagerFile = $suAttachmentFileManagerFile;
	}

	public function getSuAttachmentSourceContact()
	{
		if (isset($this->_suAttachmentSourceContact)) {
			return $this->_suAttachmentSourceContact;
		} else {
			return null;
		}
	}

	public function setSuAttachmentSourceContact($suAttachmentSourceContact)
	{
		$this->_suAttachmentSourceContact = $suAttachmentSourceContact;
	}

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)
	public static function getArrSubmittalDraftAttachmentsBySubmittalDraftId()
	{
		if (isset(self::$_arrSubmittalDraftAttachmentsBySubmittalDraftId)) {
			return self::$_arrSubmittalDraftAttachmentsBySubmittalDraftId;
		} else {
			return null;
		}
	}

	public static function setArrSubmittalDraftAttachmentsBySubmittalDraftId($arrSubmittalDraftAttachmentsBySubmittalDraftId)
	{
		self::$_arrSubmittalDraftAttachmentsBySubmittalDraftId = $arrSubmittalDraftAttachmentsBySubmittalDraftId;
	}

	public static function getArrSubmittalDraftAttachmentsBySuAttachmentFileManagerFileId()
	{
		if (isset(self::$_arrSubmittalDraftAttachmentsBySuAttachmentFileManagerFileId)) {
			return self::$_arrSubmittalDraftAttachmentsBySuAttachmentFileManagerFileId;
		} else {
			return null;
		}
	}

	public static function setArrSubmittalDraftAttachmentsBySuAttachmentFileManagerFileId($arrSubmittalDraftAttachmentsBySuAttachmentFileManagerFileId)
	{
		self::$_arrSubmittalDraftAttachmentsBySuAttachmentFileManagerFileId = $arrSubmittalDraftAttachmentsBySuAttachmentFileManagerFileId;
	}

	public static function getArrSubmittalDraftAttachmentsBySuAttachmentSourceContactId()
	{
		if (isset(self::$_arrSubmittalDraftAttachmentsBySuAttachmentSourceContactId)) {
			return self::$_arrSubmittalDraftAttachmentsBySuAttachmentSourceContactId;
		} else {
			return null;
		}
	}

	public static function setArrSubmittalDraftAttachmentsBySuAttachmentSourceContactId($arrSubmittalDraftAttachmentsBySuAttachmentSourceContactId)
	{
		self::$_arrSubmittalDraftAttachmentsBySuAttachmentSourceContactId = $arrSubmittalDraftAttachmentsBySuAttachmentSourceContactId;
	}

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllSubmittalDraftAttachments()
	{
		if (isset(self::$_arrAllSubmittalDraftAttachments)) {
			return self::$_arrAllSubmittalDraftAttachments;
		} else {
			return null;
		}
	}

	public static function setArrAllSubmittalDraftAttachments($arrAllSubmittalDraftAttachments)
	{
		self::$_arrAllSubmittalDraftAttachments = $arrAllSubmittalDraftAttachments;
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
	 * Find by primary key (`submittal_draft_id`,`su_attachment_file_manager_file_id`).
	 *
	 * @param string $database
	 * @param int $submittal_draft_id
	 * @param int $su_attachment_file_manager_file_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findBySubmittalDraftIdAndSuAttachmentFileManagerFileId($database, $submittal_draft_id, $su_attachment_file_manager_file_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	suda.*

FROM `submittal_draft_attachments` suda
WHERE suda.`submittal_draft_id` = ?
AND suda.`su_attachment_file_manager_file_id` = ?
";
		$arrValues = array($submittal_draft_id, $su_attachment_file_manager_file_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row && !empty($row)) {
			$submittalDraftAttachment = self::instantiateOrm($database, 'SubmittalDraftAttachment', $row);
			/* @var $submittalDraftAttachment SubmittalDraftAttachment */
			return $submittalDraftAttachment;
		} else {
			return false;
		}
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Find by primary key (`submittal_draft_id`,`su_attachment_file_manager_file_id`) Extended.
	 *
	 * @param string $database
	 * @param int $submittal_draft_id
	 * @param int $su_attachment_file_manager_file_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findBySubmittalDraftIdAndSuAttachmentFileManagerFileIdExtended($database, $submittal_draft_id, $su_attachment_file_manager_file_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	suda_fk_sud.`id` AS 'suda_fk_sud__submittal_draft_id',
	suda_fk_sud.`project_id` AS 'suda_fk_sud__project_id',
	suda_fk_sud.`submittal_type_id` AS 'suda_fk_sud__submittal_type_id',
	suda_fk_sud.`submittal_priority_id` AS 'suda_fk_sud__submittal_priority_id',
	suda_fk_sud.`submittal_distribution_method_id` AS 'suda_fk_sud__submittal_distribution_method_id',
	suda_fk_sud.`su_file_manager_file_id` AS 'suda_fk_sud__su_file_manager_file_id',
	suda_fk_sud.`su_cost_code_id` AS 'suda_fk_sud__su_cost_code_id',
	suda_fk_sud.`su_creator_contact_id` AS 'suda_fk_sud__su_creator_contact_id',
	suda_fk_sud.`su_creator_contact_company_office_id` AS 'suda_fk_sud__su_creator_contact_company_office_id',
	suda_fk_sud.`su_creator_phone_contact_company_office_phone_number_id` AS 'suda_fk_sud__su_creator_phone_contact_company_office_phone_number_id',
	suda_fk_sud.`su_creator_fax_contact_company_office_phone_number_id` AS 'suda_fk_sud__su_creator_fax_contact_company_office_phone_number_id',
	suda_fk_sud.`su_creator_contact_mobile_phone_number_id` AS 'suda_fk_sud__su_creator_contact_mobile_phone_number_id',
	suda_fk_sud.`su_recipient_contact_id` AS 'suda_fk_sud__su_recipient_contact_id',
	suda_fk_sud.`su_recipient_contact_company_office_id` AS 'suda_fk_sud__su_recipient_contact_company_office_id',
	suda_fk_sud.`su_recipient_phone_contact_company_office_phone_number_id` AS 'suda_fk_sud__su_recipient_phone_contact_company_office_phone_number_id',
	suda_fk_sud.`su_recipient_fax_contact_company_office_phone_number_id` AS 'suda_fk_sud__su_recipient_fax_contact_company_office_phone_number_id',
	suda_fk_sud.`su_recipient_contact_mobile_phone_number_id` AS 'suda_fk_sud__su_recipient_contact_mobile_phone_number_id',
	suda_fk_sud.`su_initiator_contact_id` AS 'suda_fk_sud__su_initiator_contact_id',
	suda_fk_sud.`su_initiator_contact_company_office_id` AS 'suda_fk_sud__su_initiator_contact_company_office_id',
	suda_fk_sud.`su_initiator_phone_contact_company_office_phone_number_id` AS 'suda_fk_sud__su_initiator_phone_contact_company_office_phone_number_id',
	suda_fk_sud.`su_initiator_fax_contact_company_office_phone_number_id` AS 'suda_fk_sud__su_initiator_fax_contact_company_office_phone_number_id',
	suda_fk_sud.`su_initiator_contact_mobile_phone_number_id` AS 'suda_fk_sud__su_initiator_contact_mobile_phone_number_id',
	suda_fk_sud.`su_title` AS 'suda_fk_sud__su_title',
	suda_fk_sud.`su_plan_page_reference` AS 'suda_fk_sud__su_plan_page_reference',
	suda_fk_sud.`su_statement` AS 'suda_fk_sud__su_statement',
	suda_fk_sud.`su_due_date` AS 'suda_fk_sud__su_due_date',

	suda_fk_fmfiles.`id` AS 'suda_fk_fmfiles__file_manager_file_id',
	suda_fk_fmfiles.`user_company_id` AS 'suda_fk_fmfiles__user_company_id',
	suda_fk_fmfiles.`contact_id` AS 'suda_fk_fmfiles__contact_id',
	suda_fk_fmfiles.`project_id` AS 'suda_fk_fmfiles__project_id',
	suda_fk_fmfiles.`file_manager_folder_id` AS 'suda_fk_fmfiles__file_manager_folder_id',
	suda_fk_fmfiles.`file_location_id` AS 'suda_fk_fmfiles__file_location_id',
	suda_fk_fmfiles.`virtual_file_name` AS 'suda_fk_fmfiles__virtual_file_name',
	suda_fk_fmfiles.`version_number` AS 'suda_fk_fmfiles__version_number',
	suda_fk_fmfiles.`virtual_file_name_sha1` AS 'suda_fk_fmfiles__virtual_file_name_sha1',
	suda_fk_fmfiles.`virtual_file_mime_type` AS 'suda_fk_fmfiles__virtual_file_mime_type',
	suda_fk_fmfiles.`modified` AS 'suda_fk_fmfiles__modified',
	suda_fk_fmfiles.`created` AS 'suda_fk_fmfiles__created',
	suda_fk_fmfiles.`deleted_flag` AS 'suda_fk_fmfiles__deleted_flag',
	suda_fk_fmfiles.`directly_deleted_flag` AS 'suda_fk_fmfiles__directly_deleted_flag',

	suda_fk_suda_source_c.`id` AS 'suda_fk_suda_source_c__contact_id',
	suda_fk_suda_source_c.`user_company_id` AS 'suda_fk_suda_source_c__user_company_id',
	suda_fk_suda_source_c.`user_id` AS 'suda_fk_suda_source_c__user_id',
	suda_fk_suda_source_c.`contact_company_id` AS 'suda_fk_suda_source_c__contact_company_id',
	suda_fk_suda_source_c.`email` AS 'suda_fk_suda_source_c__email',
	suda_fk_suda_source_c.`name_prefix` AS 'suda_fk_suda_source_c__name_prefix',
	suda_fk_suda_source_c.`first_name` AS 'suda_fk_suda_source_c__first_name',
	suda_fk_suda_source_c.`additional_name` AS 'suda_fk_suda_source_c__additional_name',
	suda_fk_suda_source_c.`middle_name` AS 'suda_fk_suda_source_c__middle_name',
	suda_fk_suda_source_c.`last_name` AS 'suda_fk_suda_source_c__last_name',
	suda_fk_suda_source_c.`name_suffix` AS 'suda_fk_suda_source_c__name_suffix',
	suda_fk_suda_source_c.`title` AS 'suda_fk_suda_source_c__title',
	suda_fk_suda_source_c.`vendor_flag` AS 'suda_fk_suda_source_c__vendor_flag',

	suda.*

FROM `submittal_draft_attachments` suda
	INNER JOIN `submittal_drafts` suda_fk_sud ON suda.`submittal_draft_id` = suda_fk_sud.`id`
	INNER JOIN `file_manager_files` suda_fk_fmfiles ON suda.`su_attachment_file_manager_file_id` = suda_fk_fmfiles.`id`
	INNER JOIN `contacts` suda_fk_suda_source_c ON suda.`su_attachment_source_contact_id` = suda_fk_suda_source_c.`id`
WHERE suda.`submittal_draft_id` = ?
AND suda.`su_attachment_file_manager_file_id` = ?
";
		$arrValues = array($submittal_draft_id, $su_attachment_file_manager_file_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row && !empty($row)) {
			$submittalDraftAttachment = self::instantiateOrm($database, 'SubmittalDraftAttachment', $row);
			/* @var $submittalDraftAttachment SubmittalDraftAttachment */
			$submittalDraftAttachment->convertPropertiesToData();

			if (isset($row['submittal_draft_id'])) {
				$submittal_draft_id = $row['submittal_draft_id'];
				$row['suda_fk_sud__id'] = $submittal_draft_id;
				$submittalDraft = self::instantiateOrm($database, 'SubmittalDraft', $row, null, $submittal_draft_id, 'suda_fk_sud__');
				/* @var $submittalDraft SubmittalDraft */
				$submittalDraft->convertPropertiesToData();
			} else {
				$submittalDraft = false;
			}
			$submittalDraftAttachment->setSubmittalDraft($submittalDraft);

			if (isset($row['su_attachment_file_manager_file_id'])) {
				$su_attachment_file_manager_file_id = $row['su_attachment_file_manager_file_id'];
				$row['suda_fk_fmfiles__id'] = $su_attachment_file_manager_file_id;
				$suAttachmentFileManagerFile = self::instantiateOrm($database, 'FileManagerFile', $row, null, $su_attachment_file_manager_file_id, 'suda_fk_fmfiles__');
				/* @var $suAttachmentFileManagerFile FileManagerFile */
				$suAttachmentFileManagerFile->convertPropertiesToData();
			} else {
				$suAttachmentFileManagerFile = false;
			}
			$submittalDraftAttachment->setSuAttachmentFileManagerFile($suAttachmentFileManagerFile);

			if (isset($row['su_attachment_source_contact_id'])) {
				$su_attachment_source_contact_id = $row['su_attachment_source_contact_id'];
				$row['suda_fk_suda_source_c__id'] = $su_attachment_source_contact_id;
				$suAttachmentSourceContact = self::instantiateOrm($database, 'Contact', $row, null, $su_attachment_source_contact_id, 'suda_fk_suda_source_c__');
				/* @var $suAttachmentSourceContact Contact */
				$suAttachmentSourceContact->convertPropertiesToData();
			} else {
				$suAttachmentSourceContact = false;
			}
			$submittalDraftAttachment->setSuAttachmentSourceContact($suAttachmentSourceContact);

			return $submittalDraftAttachment;
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
	 * @param array $arrSubmittalDraftIdAndSuAttachmentFileManagerFileIdList
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubmittalDraftAttachmentsByArrSubmittalDraftIdAndSuAttachmentFileManagerFileIdList($database, $arrSubmittalDraftIdAndSuAttachmentFileManagerFileIdList, Input $options=null)
	{
		if (empty($arrSubmittalDraftIdAndSuAttachmentFileManagerFileIdList)) {
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
		// ORDER BY `submittal_draft_id` ASC, `su_attachment_file_manager_file_id` ASC, `su_attachment_source_contact_id` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY suda.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubmittalDraftAttachment = new SubmittalDraftAttachment($database);
			$sqlOrderByColumns = $tmpSubmittalDraftAttachment->constructSqlOrderByColumns($arrOrderByAttributes);

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
		foreach ($arrSubmittalDraftIdAndSuAttachmentFileManagerFileIdList as $k => $arrTmp) {
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
		if (count($arrSubmittalDraftIdAndSuAttachmentFileManagerFileIdList) > 1) {
			$sqlWhere = join($arrSqlWhere, ' OR ');
			$sqlWhere = "WHERE ($sqlWhere)";
		} else {
			$sqlWhere = "WHERE $tmpInnerAnd";
		}

		$query =
"
SELECT

	suda.*

FROM `submittal_draft_attachments` suda
{$sqlWhere}{$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubmittalDraftAttachmentsByArrSubmittalDraftIdAndSuAttachmentFileManagerFileIdList = array();
		while ($row = $db->fetch()) {
			$submittalDraftAttachment = self::instantiateOrm($database, 'SubmittalDraftAttachment', $row);
			/* @var $submittalDraftAttachment SubmittalDraftAttachment */
			$arrSubmittalDraftAttachmentsByArrSubmittalDraftIdAndSuAttachmentFileManagerFileIdList[] = $submittalDraftAttachment;
		}

		$db->free_result();

		return $arrSubmittalDraftAttachmentsByArrSubmittalDraftIdAndSuAttachmentFileManagerFileIdList;
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `submittal_draft_attachments_fk_sud` foreign key (`submittal_draft_id`) references `submittal_drafts` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $submittal_draft_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubmittalDraftAttachmentsBySubmittalDraftId($database, $submittal_draft_id, Input $options=null)
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
			self::$_arrSubmittalDraftAttachmentsBySubmittalDraftId = null;
		}

		$arrSubmittalDraftAttachmentsBySubmittalDraftId = self::$_arrSubmittalDraftAttachmentsBySubmittalDraftId;
		if (isset($arrSubmittalDraftAttachmentsBySubmittalDraftId) && !empty($arrSubmittalDraftAttachmentsBySubmittalDraftId)) {
			return $arrSubmittalDraftAttachmentsBySubmittalDraftId;
		}

		$submittal_draft_id = (int) $submittal_draft_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `submittal_draft_id` ASC, `su_attachment_file_manager_file_id` ASC, `su_attachment_source_contact_id` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY suda.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubmittalDraftAttachment = new SubmittalDraftAttachment($database);
			$sqlOrderByColumns = $tmpSubmittalDraftAttachment->constructSqlOrderByColumns($arrOrderByAttributes);

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
	suda.*

FROM `submittal_draft_attachments` suda
WHERE suda.`submittal_draft_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `submittal_draft_id` ASC, `su_attachment_file_manager_file_id` ASC, `su_attachment_source_contact_id` ASC, `sort_order` ASC
		$arrValues = array($submittal_draft_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubmittalDraftAttachmentsBySubmittalDraftId = array();
		while ($row = $db->fetch()) {
			$submittalDraftAttachment = self::instantiateOrm($database, 'SubmittalDraftAttachment', $row);
			/* @var $submittalDraftAttachment SubmittalDraftAttachment */
			$arrSubmittalDraftAttachmentsBySubmittalDraftId[] = $submittalDraftAttachment;
		}

		$db->free_result();

		self::$_arrSubmittalDraftAttachmentsBySubmittalDraftId = $arrSubmittalDraftAttachmentsBySubmittalDraftId;

		return $arrSubmittalDraftAttachmentsBySubmittalDraftId;
	}

	/**
	 * Load by constraint `submittal_draft_attachments_fk_fmfiles` foreign key (`su_attachment_file_manager_file_id`) references `file_manager_files` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $su_attachment_file_manager_file_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubmittalDraftAttachmentsBySuAttachmentFileManagerFileId($database, $su_attachment_file_manager_file_id, Input $options=null)
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
			self::$_arrSubmittalDraftAttachmentsBySuAttachmentFileManagerFileId = null;
		}

		$arrSubmittalDraftAttachmentsBySuAttachmentFileManagerFileId = self::$_arrSubmittalDraftAttachmentsBySuAttachmentFileManagerFileId;
		if (isset($arrSubmittalDraftAttachmentsBySuAttachmentFileManagerFileId) && !empty($arrSubmittalDraftAttachmentsBySuAttachmentFileManagerFileId)) {
			return $arrSubmittalDraftAttachmentsBySuAttachmentFileManagerFileId;
		}

		$su_attachment_file_manager_file_id = (int) $su_attachment_file_manager_file_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `submittal_draft_id` ASC, `su_attachment_file_manager_file_id` ASC, `su_attachment_source_contact_id` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY suda.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubmittalDraftAttachment = new SubmittalDraftAttachment($database);
			$sqlOrderByColumns = $tmpSubmittalDraftAttachment->constructSqlOrderByColumns($arrOrderByAttributes);

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
	suda.*

FROM `submittal_draft_attachments` suda
WHERE suda.`su_attachment_file_manager_file_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `submittal_draft_id` ASC, `su_attachment_file_manager_file_id` ASC, `su_attachment_source_contact_id` ASC, `sort_order` ASC
		$arrValues = array($su_attachment_file_manager_file_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubmittalDraftAttachmentsBySuAttachmentFileManagerFileId = array();
		while ($row = $db->fetch()) {
			$submittalDraftAttachment = self::instantiateOrm($database, 'SubmittalDraftAttachment', $row);
			/* @var $submittalDraftAttachment SubmittalDraftAttachment */
			$arrSubmittalDraftAttachmentsBySuAttachmentFileManagerFileId[] = $submittalDraftAttachment;
		}

		$db->free_result();

		self::$_arrSubmittalDraftAttachmentsBySuAttachmentFileManagerFileId = $arrSubmittalDraftAttachmentsBySuAttachmentFileManagerFileId;

		return $arrSubmittalDraftAttachmentsBySuAttachmentFileManagerFileId;
	}

	/**
	 * Load by constraint `submittal_draft_attachments_fk_suda_source_c` foreign key (`su_attachment_source_contact_id`) references `contacts` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $su_attachment_source_contact_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubmittalDraftAttachmentsBySuAttachmentSourceContactId($database, $su_attachment_source_contact_id, Input $options=null)
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
			self::$_arrSubmittalDraftAttachmentsBySuAttachmentSourceContactId = null;
		}

		$arrSubmittalDraftAttachmentsBySuAttachmentSourceContactId = self::$_arrSubmittalDraftAttachmentsBySuAttachmentSourceContactId;
		if (isset($arrSubmittalDraftAttachmentsBySuAttachmentSourceContactId) && !empty($arrSubmittalDraftAttachmentsBySuAttachmentSourceContactId)) {
			return $arrSubmittalDraftAttachmentsBySuAttachmentSourceContactId;
		}

		$su_attachment_source_contact_id = (int) $su_attachment_source_contact_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `submittal_draft_id` ASC, `su_attachment_file_manager_file_id` ASC, `su_attachment_source_contact_id` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY suda.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubmittalDraftAttachment = new SubmittalDraftAttachment($database);
			$sqlOrderByColumns = $tmpSubmittalDraftAttachment->constructSqlOrderByColumns($arrOrderByAttributes);

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
	suda.*

FROM `submittal_draft_attachments` suda
WHERE suda.`su_attachment_source_contact_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `submittal_draft_id` ASC, `su_attachment_file_manager_file_id` ASC, `su_attachment_source_contact_id` ASC, `sort_order` ASC
		$arrValues = array($su_attachment_source_contact_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubmittalDraftAttachmentsBySuAttachmentSourceContactId = array();
		while ($row = $db->fetch()) {
			$submittalDraftAttachment = self::instantiateOrm($database, 'SubmittalDraftAttachment', $row);
			/* @var $submittalDraftAttachment SubmittalDraftAttachment */
			$arrSubmittalDraftAttachmentsBySuAttachmentSourceContactId[] = $submittalDraftAttachment;
		}

		$db->free_result();

		self::$_arrSubmittalDraftAttachmentsBySuAttachmentSourceContactId = $arrSubmittalDraftAttachmentsBySuAttachmentSourceContactId;

		return $arrSubmittalDraftAttachmentsBySuAttachmentSourceContactId;
	}

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all submittal_draft_attachments records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllSubmittalDraftAttachments($database, Input $options=null)
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
			self::$_arrAllSubmittalDraftAttachments = null;
		}

		$arrAllSubmittalDraftAttachments = self::$_arrAllSubmittalDraftAttachments;
		if (isset($arrAllSubmittalDraftAttachments) && !empty($arrAllSubmittalDraftAttachments)) {
			return $arrAllSubmittalDraftAttachments;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `submittal_draft_id` ASC, `su_attachment_file_manager_file_id` ASC, `su_attachment_source_contact_id` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY suda.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubmittalDraftAttachment = new SubmittalDraftAttachment($database);
			$sqlOrderByColumns = $tmpSubmittalDraftAttachment->constructSqlOrderByColumns($arrOrderByAttributes);

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
	suda.*

FROM `submittal_draft_attachments` suda{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `submittal_draft_id` ASC, `su_attachment_file_manager_file_id` ASC, `su_attachment_source_contact_id` ASC, `sort_order` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllSubmittalDraftAttachments = array();
		while ($row = $db->fetch()) {
			$submittalDraftAttachment = self::instantiateOrm($database, 'SubmittalDraftAttachment', $row);
			/* @var $submittalDraftAttachment SubmittalDraftAttachment */
			$arrAllSubmittalDraftAttachments[] = $submittalDraftAttachment;
		}

		$db->free_result();

		self::$_arrAllSubmittalDraftAttachments = $arrAllSubmittalDraftAttachments;

		return $arrAllSubmittalDraftAttachments;
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
INTO `submittal_draft_attachments`
(`submittal_draft_id`, `su_attachment_file_manager_file_id`, `su_attachment_source_contact_id`, `sort_order`)
VALUES (?, ?, ?, ?)
ON DUPLICATE KEY UPDATE `su_attachment_source_contact_id` = ?, `sort_order` = ?
";
		$arrValues = array($this->submittal_draft_id, $this->su_attachment_file_manager_file_id, $this->su_attachment_source_contact_id, $this->sort_order, $this->su_attachment_source_contact_id, $this->sort_order);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$submittal_draft_attachment_id = $db->insertId;
		$db->free_result();

		return $submittal_draft_attachment_id;
	}

	// Save: insert ignore

	/**
	 * Find su_draft_attachment_sequence_number value.
	 *
	 * @param string $database
	 * @param int $submittal_draft_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findNextSubmittalDraftAttachmentSequenceNumber($database, $submittal_draft_id)
	{
		$next_su_draft_attachment_sequence_number = 1;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT MAX(suda.su_draft_attachment_sequence_number) AS 'max_su_draft_attachment_sequence_number'
FROM `submittal_draft_attachments` suda
WHERE sua.`submittal_draft_id` = ?
";
		$arrValues = array($submittal_draft_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$max_su_draft_attachment_sequence_number = $row['max_su_draft_attachment_sequence_number'];
			$next_su_draft_attachment_sequence_number = $max_su_draft_attachment_sequence_number + 1;
		}

		return $next_su_draft_attachment_sequence_number;
	}
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

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
 * SubmittalAttachment.
 *
 * @category   Framework
 * @package    SubmittalAttachment
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class SubmittalAttachment extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'SubmittalAttachment';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'submittal_attachments';

	/**
	 * primary key (`submittal_id`,`su_attachment_file_manager_file_id`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrPrimaryKey = array(
		'submittal_id' => 'int',
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
		'unique_submittal_attachment_via_primary_key' => array(
			'submittal_id' => 'int',
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
		'submittal_id' => 'submittal_id',
		'su_attachment_file_manager_file_id' => 'su_attachment_file_manager_file_id',

		'su_attachment_source_contact_id' => 'su_attachment_source_contact_id',
		'is_added' =>'is_added',
		'sort_order' => 'sort_order'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $submittal_id;
	public $su_attachment_file_manager_file_id;

	public $su_attachment_source_contact_id;
	public $is_added;
	public $sort_order;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties

	// HTML ENTITY ENCODED NL2BR ORM string properties

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)
	protected static $_arrSubmittalAttachmentsBySubmittalId;
	protected static $_arrSubmittalAttachmentsBySuAttachmentFileManagerFileId;
	protected static $_arrSubmittalAttachmentsBySuAttachmentSourceContactId;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllSubmittalAttachments;

	// Foreign Key Objects
	private $_submittal;
	private $_suAttachmentFileManagerFile;
	private $_suAttachmentSourceContact;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='submittal_attachments')
	{
		parent::__construct($table);
		$this->setDatabase($database);
	}

	// Foreign Key Object Accessor Methods
	public function getSubmittal()
	{
		if (isset($this->_submittal)) {
			return $this->_submittal;
		} else {
			return null;
		}
	}

	public function setSubmittal($submittal)
	{
		$this->_submittal = $submittal;
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
	public static function getArrSubmittalAttachmentsBySubmittalId()
	{
		if (isset(self::$_arrSubmittalAttachmentsBySubmittalId)) {
			return self::$_arrSubmittalAttachmentsBySubmittalId;
		} else {
			return null;
		}
	}

	public static function setArrSubmittalAttachmentsBySubmittalId($arrSubmittalAttachmentsBySubmittalId)
	{
		self::$_arrSubmittalAttachmentsBySubmittalId = $arrSubmittalAttachmentsBySubmittalId;
	}

	public static function getArrSubmittalAttachmentsBySuAttachmentFileManagerFileId()
	{
		if (isset(self::$_arrSubmittalAttachmentsBySuAttachmentFileManagerFileId)) {
			return self::$_arrSubmittalAttachmentsBySuAttachmentFileManagerFileId;
		} else {
			return null;
		}
	}

	public static function setArrSubmittalAttachmentsBySuAttachmentFileManagerFileId($arrSubmittalAttachmentsBySuAttachmentFileManagerFileId)
	{
		self::$_arrSubmittalAttachmentsBySuAttachmentFileManagerFileId = $arrSubmittalAttachmentsBySuAttachmentFileManagerFileId;
	}

	public static function getArrSubmittalAttachmentsBySuAttachmentSourceContactId()
	{
		if (isset(self::$_arrSubmittalAttachmentsBySuAttachmentSourceContactId)) {
			return self::$_arrSubmittalAttachmentsBySuAttachmentSourceContactId;
		} else {
			return null;
		}
	}

	public static function setArrSubmittalAttachmentsBySuAttachmentSourceContactId($arrSubmittalAttachmentsBySuAttachmentSourceContactId)
	{
		self::$_arrSubmittalAttachmentsBySuAttachmentSourceContactId = $arrSubmittalAttachmentsBySuAttachmentSourceContactId;
	}

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllSubmittalAttachments()
	{
		if (isset(self::$_arrAllSubmittalAttachments)) {
			return self::$_arrAllSubmittalAttachments;
		} else {
			return null;
		}
	}

	public static function setArrAllSubmittalAttachments($arrAllSubmittalAttachments)
	{
		self::$_arrAllSubmittalAttachments = $arrAllSubmittalAttachments;
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
	 * Find by primary key (`submittal_id`,`su_attachment_file_manager_file_id`).
	 *
	 * @param string $database
	 * @param int $submittal_id
	 * @param int $su_attachment_file_manager_file_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findBySubmittalIdAndSuAttachmentFileManagerFileId($database, $submittal_id, $su_attachment_file_manager_file_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	sua.*

FROM `submittal_attachments` sua
WHERE sua.`submittal_id` = ?
AND sua.`su_attachment_file_manager_file_id` = ?
";
		$arrValues = array($submittal_id, $su_attachment_file_manager_file_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row && !empty($row)) {
			$submittalAttachment = self::instantiateOrm($database, 'SubmittalAttachment', $row);
			/* @var $submittalAttachment SubmittalAttachment */
			return $submittalAttachment;
		} else {
			return false;
		}
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Find by primary key (`submittal_id`,`su_attachment_file_manager_file_id`) Extended.
	 *
	 * @param string $database
	 * @param int $submittal_id
	 * @param int $su_attachment_file_manager_file_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findBySubmittalIdAndSuAttachmentFileManagerFileIdExtended($database, $submittal_id, $su_attachment_file_manager_file_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	sua_fk_su.`id` AS 'sua_fk_su__submittal_id',
	sua_fk_su.`project_id` AS 'sua_fk_su__project_id',
	sua_fk_su.`su_sequence_number` AS 'sua_fk_su__su_sequence_number',
	sua_fk_su.`submittal_type_id` AS 'sua_fk_su__submittal_type_id',
	sua_fk_su.`submittal_status_id` AS 'sua_fk_su__submittal_status_id',
	sua_fk_su.`submittal_priority_id` AS 'sua_fk_su__submittal_priority_id',
	sua_fk_su.`submittal_distribution_method_id` AS 'sua_fk_su__submittal_distribution_method_id',
	sua_fk_su.`su_file_manager_file_id` AS 'sua_fk_su__su_file_manager_file_id',
	sua_fk_su.`su_cost_code_id` AS 'sua_fk_su__su_cost_code_id',
	sua_fk_su.`su_creator_contact_id` AS 'sua_fk_su__su_creator_contact_id',
	sua_fk_su.`su_creator_contact_company_office_id` AS 'sua_fk_su__su_creator_contact_company_office_id',
	sua_fk_su.`su_creator_phone_contact_company_office_phone_number_id` AS 'sua_fk_su__su_creator_phone_contact_company_office_phone_number_id',
	sua_fk_su.`su_creator_fax_contact_company_office_phone_number_id` AS 'sua_fk_su__su_creator_fax_contact_company_office_phone_number_id',
	sua_fk_su.`su_creator_contact_mobile_phone_number_id` AS 'sua_fk_su__su_creator_contact_mobile_phone_number_id',
	sua_fk_su.`su_recipient_contact_id` AS 'sua_fk_su__su_recipient_contact_id',
	sua_fk_su.`su_recipient_contact_company_office_id` AS 'sua_fk_su__su_recipient_contact_company_office_id',
	sua_fk_su.`su_recipient_phone_contact_company_office_phone_number_id` AS 'sua_fk_su__su_recipient_phone_contact_company_office_phone_number_id',
	sua_fk_su.`su_recipient_fax_contact_company_office_phone_number_id` AS 'sua_fk_su__su_recipient_fax_contact_company_office_phone_number_id',
	sua_fk_su.`su_recipient_contact_mobile_phone_number_id` AS 'sua_fk_su__su_recipient_contact_mobile_phone_number_id',
	sua_fk_su.`su_initiator_contact_id` AS 'sua_fk_su__su_initiator_contact_id',
	sua_fk_su.`su_initiator_contact_company_office_id` AS 'sua_fk_su__su_initiator_contact_company_office_id',
	sua_fk_su.`su_initiator_phone_contact_company_office_phone_number_id` AS 'sua_fk_su__su_initiator_phone_contact_company_office_phone_number_id',
	sua_fk_su.`su_initiator_fax_contact_company_office_phone_number_id` AS 'sua_fk_su__su_initiator_fax_contact_company_office_phone_number_id',
	sua_fk_su.`su_initiator_contact_mobile_phone_number_id` AS 'sua_fk_su__su_initiator_contact_mobile_phone_number_id',
	sua_fk_su.`su_title` AS 'sua_fk_su__su_title',
	sua_fk_su.`su_plan_page_reference` AS 'sua_fk_su__su_plan_page_reference',
	sua_fk_su.`su_statement` AS 'sua_fk_su__su_statement',
	sua_fk_su.`created` AS 'sua_fk_su__created',
	sua_fk_su.`su_due_date` AS 'sua_fk_su__su_due_date',
	sua_fk_su.`su_closed_date` AS 'sua_fk_su__su_closed_date',

	sua_fk_fmfiles.`id` AS 'sua_fk_fmfiles__file_manager_file_id',
	sua_fk_fmfiles.`user_company_id` AS 'sua_fk_fmfiles__user_company_id',
	sua_fk_fmfiles.`contact_id` AS 'sua_fk_fmfiles__contact_id',
	sua_fk_fmfiles.`project_id` AS 'sua_fk_fmfiles__project_id',
	sua_fk_fmfiles.`file_manager_folder_id` AS 'sua_fk_fmfiles__file_manager_folder_id',
	sua_fk_fmfiles.`file_location_id` AS 'sua_fk_fmfiles__file_location_id',
	sua_fk_fmfiles.`virtual_file_name` AS 'sua_fk_fmfiles__virtual_file_name',
	sua_fk_fmfiles.`version_number` AS 'sua_fk_fmfiles__version_number',
	sua_fk_fmfiles.`virtual_file_name_sha1` AS 'sua_fk_fmfiles__virtual_file_name_sha1',
	sua_fk_fmfiles.`virtual_file_mime_type` AS 'sua_fk_fmfiles__virtual_file_mime_type',
	sua_fk_fmfiles.`modified` AS 'sua_fk_fmfiles__modified',
	sua_fk_fmfiles.`created` AS 'sua_fk_fmfiles__created',
	sua_fk_fmfiles.`deleted_flag` AS 'sua_fk_fmfiles__deleted_flag',
	sua_fk_fmfiles.`directly_deleted_flag` AS 'sua_fk_fmfiles__directly_deleted_flag',

	sua_fk_sua_source_c.`id` AS 'sua_fk_sua_source_c__contact_id',
	sua_fk_sua_source_c.`user_company_id` AS 'sua_fk_sua_source_c__user_company_id',
	sua_fk_sua_source_c.`user_id` AS 'sua_fk_sua_source_c__user_id',
	sua_fk_sua_source_c.`contact_company_id` AS 'sua_fk_sua_source_c__contact_company_id',
	sua_fk_sua_source_c.`email` AS 'sua_fk_sua_source_c__email',
	sua_fk_sua_source_c.`name_prefix` AS 'sua_fk_sua_source_c__name_prefix',
	sua_fk_sua_source_c.`first_name` AS 'sua_fk_sua_source_c__first_name',
	sua_fk_sua_source_c.`additional_name` AS 'sua_fk_sua_source_c__additional_name',
	sua_fk_sua_source_c.`middle_name` AS 'sua_fk_sua_source_c__middle_name',
	sua_fk_sua_source_c.`last_name` AS 'sua_fk_sua_source_c__last_name',
	sua_fk_sua_source_c.`name_suffix` AS 'sua_fk_sua_source_c__name_suffix',
	sua_fk_sua_source_c.`title` AS 'sua_fk_sua_source_c__title',
	sua_fk_sua_source_c.`vendor_flag` AS 'sua_fk_sua_source_c__vendor_flag',

	sua.*

FROM `submittal_attachments` sua
	INNER JOIN `submittals` sua_fk_su ON sua.`submittal_id` = sua_fk_su.`id`
	INNER JOIN `file_manager_files` sua_fk_fmfiles ON sua.`su_attachment_file_manager_file_id` = sua_fk_fmfiles.`id`
	INNER JOIN `contacts` sua_fk_sua_source_c ON sua.`su_attachment_source_contact_id` = sua_fk_sua_source_c.`id`
WHERE sua.`submittal_id` = ?
AND sua.`su_attachment_file_manager_file_id` = ?
";
		$arrValues = array($submittal_id, $su_attachment_file_manager_file_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row && !empty($row)) {
			$submittalAttachment = self::instantiateOrm($database, 'SubmittalAttachment', $row);
			/* @var $submittalAttachment SubmittalAttachment */
			$submittalAttachment->convertPropertiesToData();

			if (isset($row['submittal_id'])) {
				$submittal_id = $row['submittal_id'];
				$row['sua_fk_su__id'] = $submittal_id;
				$submittal = self::instantiateOrm($database, 'Submittal', $row, null, $submittal_id, 'sua_fk_su__');
				/* @var $submittal Submittal */
				$submittal->convertPropertiesToData();
			} else {
				$submittal = false;
			}
			$submittalAttachment->setSubmittal($submittal);

			if (isset($row['su_attachment_file_manager_file_id'])) {
				$su_attachment_file_manager_file_id = $row['su_attachment_file_manager_file_id'];
				$row['sua_fk_fmfiles__id'] = $su_attachment_file_manager_file_id;
				$suAttachmentFileManagerFile = self::instantiateOrm($database, 'FileManagerFile', $row, null, $su_attachment_file_manager_file_id, 'sua_fk_fmfiles__');
				/* @var $suAttachmentFileManagerFile FileManagerFile */
				$suAttachmentFileManagerFile->convertPropertiesToData();
			} else {
				$suAttachmentFileManagerFile = false;
			}
			$submittalAttachment->setSuAttachmentFileManagerFile($suAttachmentFileManagerFile);

			if (isset($row['su_attachment_source_contact_id'])) {
				$su_attachment_source_contact_id = $row['su_attachment_source_contact_id'];
				$row['sua_fk_sua_source_c__id'] = $su_attachment_source_contact_id;
				$suAttachmentSourceContact = self::instantiateOrm($database, 'Contact', $row, null, $su_attachment_source_contact_id, 'sua_fk_sua_source_c__');
				/* @var $suAttachmentSourceContact Contact */
				$suAttachmentSourceContact->convertPropertiesToData();
			} else {
				$suAttachmentSourceContact = false;
			}
			$submittalAttachment->setSuAttachmentSourceContact($suAttachmentSourceContact);

			return $submittalAttachment;
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
	 * @param array $arrSubmittalIdAndSuAttachmentFileManagerFileIdList
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubmittalAttachmentsByArrSubmittalIdAndSuAttachmentFileManagerFileIdList($database, $arrSubmittalIdAndSuAttachmentFileManagerFileIdList, Input $options=null)
	{
		if (empty($arrSubmittalIdAndSuAttachmentFileManagerFileIdList)) {
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
		// ORDER BY `submittal_id` ASC, `su_attachment_file_manager_file_id` ASC, `su_attachment_source_contact_id` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY sua.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubmittalAttachment = new SubmittalAttachment($database);
			$sqlOrderByColumns = $tmpSubmittalAttachment->constructSqlOrderByColumns($arrOrderByAttributes);

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
		foreach ($arrSubmittalIdAndSuAttachmentFileManagerFileIdList as $k => $arrTmp) {
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
		if (count($arrSubmittalIdAndSuAttachmentFileManagerFileIdList) > 1) {
			$sqlWhere = join($arrSqlWhere, ' OR ');
			$sqlWhere = "WHERE ($sqlWhere)";
		} else {
			$sqlWhere = "WHERE $tmpInnerAnd";
		}

		$query =
"
SELECT

	sua.*

FROM `submittal_attachments` sua
{$sqlWhere}{$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubmittalAttachmentsByArrSubmittalIdAndSuAttachmentFileManagerFileIdList = array();
		while ($row = $db->fetch()) {
			$submittalAttachment = self::instantiateOrm($database, 'SubmittalAttachment', $row);
			/* @var $submittalAttachment SubmittalAttachment */
			$arrSubmittalAttachmentsByArrSubmittalIdAndSuAttachmentFileManagerFileIdList[] = $submittalAttachment;
		}

		$db->free_result();

		return $arrSubmittalAttachmentsByArrSubmittalIdAndSuAttachmentFileManagerFileIdList;
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `submittal_attachments_fk_su` foreign key (`submittal_id`) references `submittals` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $submittal_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubmittalAttachmentsBySubmittalId($database, $submittal_id, Input $options=null,$allData=null)
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
			self::$_arrSubmittalAttachmentsBySubmittalId = null;
		}

		$arrSubmittalAttachmentsBySubmittalId = self::$_arrSubmittalAttachmentsBySubmittalId;
		if (isset($arrSubmittalAttachmentsBySubmittalId) && !empty($arrSubmittalAttachmentsBySubmittalId)) {
			return $arrSubmittalAttachmentsBySubmittalId;
		}

		$submittal_id = (int) $submittal_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `submittal_id` ASC, `su_attachment_file_manager_file_id` ASC, `su_attachment_source_contact_id` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY sua.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubmittalAttachment = new SubmittalAttachment($database);
			$sqlOrderByColumns = $tmpSubmittalAttachment->constructSqlOrderByColumns($arrOrderByAttributes);

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
			$filter="and sua.`is_added`='y'";
		}else
		{
			$filter="";
		}
		$query =
"
SELECT

	sua_fk_su.`id` AS 'sua_fk_su__submittal_id',
	sua_fk_su.`project_id` AS 'sua_fk_su__project_id',
	sua_fk_su.`su_sequence_number` AS 'sua_fk_su__su_sequence_number',
	sua_fk_su.`submittal_type_id` AS 'sua_fk_su__submittal_type_id',
	sua_fk_su.`submittal_status_id` AS 'sua_fk_su__submittal_status_id',
	sua_fk_su.`submittal_priority_id` AS 'sua_fk_su__submittal_priority_id',
	sua_fk_su.`submittal_distribution_method_id` AS 'sua_fk_su__submittal_distribution_method_id',
	sua_fk_su.`su_file_manager_file_id` AS 'sua_fk_su__su_file_manager_file_id',
	sua_fk_su.`su_cost_code_id` AS 'sua_fk_su__su_cost_code_id',
	sua_fk_su.`su_creator_contact_id` AS 'sua_fk_su__su_creator_contact_id',
	sua_fk_su.`su_creator_contact_company_office_id` AS 'sua_fk_su__su_creator_contact_company_office_id',
	sua_fk_su.`su_creator_phone_contact_company_office_phone_number_id` AS 'sua_fk_su__su_creator_phone_contact_company_office_phone_number_id',
	sua_fk_su.`su_creator_fax_contact_company_office_phone_number_id` AS 'sua_fk_su__su_creator_fax_contact_company_office_phone_number_id',
	sua_fk_su.`su_creator_contact_mobile_phone_number_id` AS 'sua_fk_su__su_creator_contact_mobile_phone_number_id',
	sua_fk_su.`su_recipient_contact_id` AS 'sua_fk_su__su_recipient_contact_id',
	sua_fk_su.`su_recipient_contact_company_office_id` AS 'sua_fk_su__su_recipient_contact_company_office_id',
	sua_fk_su.`su_recipient_phone_contact_company_office_phone_number_id` AS 'sua_fk_su__su_recipient_phone_contact_company_office_phone_number_id',
	sua_fk_su.`su_recipient_fax_contact_company_office_phone_number_id` AS 'sua_fk_su__su_recipient_fax_contact_company_office_phone_number_id',
	sua_fk_su.`su_recipient_contact_mobile_phone_number_id` AS 'sua_fk_su__su_recipient_contact_mobile_phone_number_id',
	sua_fk_su.`su_initiator_contact_id` AS 'sua_fk_su__su_initiator_contact_id',
	sua_fk_su.`su_initiator_contact_company_office_id` AS 'sua_fk_su__su_initiator_contact_company_office_id',
	sua_fk_su.`su_initiator_phone_contact_company_office_phone_number_id` AS 'sua_fk_su__su_initiator_phone_contact_company_office_phone_number_id',
	sua_fk_su.`su_initiator_fax_contact_company_office_phone_number_id` AS 'sua_fk_su__su_initiator_fax_contact_company_office_phone_number_id',
	sua_fk_su.`su_initiator_contact_mobile_phone_number_id` AS 'sua_fk_su__su_initiator_contact_mobile_phone_number_id',
	sua_fk_su.`su_title` AS 'sua_fk_su__su_title',
	sua_fk_su.`su_plan_page_reference` AS 'sua_fk_su__su_plan_page_reference',
	sua_fk_su.`su_statement` AS 'sua_fk_su__su_statement',
	sua_fk_su.`created` AS 'sua_fk_su__created',
	sua_fk_su.`su_due_date` AS 'sua_fk_su__su_due_date',
	sua_fk_su.`su_closed_date` AS 'sua_fk_su__su_closed_date',

	sua_fk_fmfiles.`id` AS 'sua_fk_fmfiles__file_manager_file_id',
	sua_fk_fmfiles.`user_company_id` AS 'sua_fk_fmfiles__user_company_id',
	sua_fk_fmfiles.`contact_id` AS 'sua_fk_fmfiles__contact_id',
	sua_fk_fmfiles.`project_id` AS 'sua_fk_fmfiles__project_id',
	sua_fk_fmfiles.`file_manager_folder_id` AS 'sua_fk_fmfiles__file_manager_folder_id',
	sua_fk_fmfiles.`file_location_id` AS 'sua_fk_fmfiles__file_location_id',
	sua_fk_fmfiles.`virtual_file_name` AS 'sua_fk_fmfiles__virtual_file_name',
	sua_fk_fmfiles.`version_number` AS 'sua_fk_fmfiles__version_number',
	sua_fk_fmfiles.`virtual_file_name_sha1` AS 'sua_fk_fmfiles__virtual_file_name_sha1',
	sua_fk_fmfiles.`virtual_file_mime_type` AS 'sua_fk_fmfiles__virtual_file_mime_type',
	sua_fk_fmfiles.`modified` AS 'sua_fk_fmfiles__modified',
	sua_fk_fmfiles.`created` AS 'sua_fk_fmfiles__created',
	sua_fk_fmfiles.`deleted_flag` AS 'sua_fk_fmfiles__deleted_flag',
	sua_fk_fmfiles.`directly_deleted_flag` AS 'sua_fk_fmfiles__directly_deleted_flag',

	sua_fk_sua_source_c.`id` AS 'sua_fk_sua_source_c__contact_id',
	sua_fk_sua_source_c.`user_company_id` AS 'sua_fk_sua_source_c__user_company_id',
	sua_fk_sua_source_c.`user_id` AS 'sua_fk_sua_source_c__user_id',
	sua_fk_sua_source_c.`contact_company_id` AS 'sua_fk_sua_source_c__contact_company_id',
	sua_fk_sua_source_c.`email` AS 'sua_fk_sua_source_c__email',
	sua_fk_sua_source_c.`name_prefix` AS 'sua_fk_sua_source_c__name_prefix',
	sua_fk_sua_source_c.`first_name` AS 'sua_fk_sua_source_c__first_name',
	sua_fk_sua_source_c.`additional_name` AS 'sua_fk_sua_source_c__additional_name',
	sua_fk_sua_source_c.`middle_name` AS 'sua_fk_sua_source_c__middle_name',
	sua_fk_sua_source_c.`last_name` AS 'sua_fk_sua_source_c__last_name',
	sua_fk_sua_source_c.`name_suffix` AS 'sua_fk_sua_source_c__name_suffix',
	sua_fk_sua_source_c.`title` AS 'sua_fk_sua_source_c__title',
	sua_fk_sua_source_c.`vendor_flag` AS 'sua_fk_sua_source_c__vendor_flag',

	sua.*

FROM `submittal_attachments` sua
	INNER JOIN `submittals` sua_fk_su ON sua.`submittal_id` = sua_fk_su.`id`
	INNER JOIN `file_manager_files` sua_fk_fmfiles ON sua.`su_attachment_file_manager_file_id` = sua_fk_fmfiles.`id`
	INNER JOIN `contacts` sua_fk_sua_source_c ON sua.`su_attachment_source_contact_id` = sua_fk_sua_source_c.`id`
WHERE sua.`submittal_id` = ? {$filter} {$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `submittal_id` ASC, `su_attachment_file_manager_file_id` ASC, `su_attachment_source_contact_id` ASC, `sort_order` ASC
		$arrValues = array($submittal_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubmittalAttachmentsBySubmittalId = array();
		while ($row = $db->fetch()) {
			$submittalAttachment = self::instantiateOrm($database, 'SubmittalAttachment', $row);
			/* @var $submittalAttachment SubmittalAttachment */
			$submittalAttachment->convertPropertiesToData();

			if (isset($row['submittal_id'])) {
				$submittal_id = $row['submittal_id'];
				$row['sua_fk_su__id'] = $submittal_id;
				$submittal = self::instantiateOrm($database, 'Submittal', $row, null, $submittal_id, 'sua_fk_su__');
				/* @var $submittal Submittal */
				$submittal->convertPropertiesToData();
			} else {
				$submittal = false;
			}
			$submittalAttachment->setSubmittal($submittal);

			if (isset($row['su_attachment_file_manager_file_id'])) {
				$su_attachment_file_manager_file_id = $row['su_attachment_file_manager_file_id'];
				$row['sua_fk_fmfiles__id'] = $su_attachment_file_manager_file_id;
				$suAttachmentFileManagerFile = self::instantiateOrm($database, 'FileManagerFile', $row, null, $su_attachment_file_manager_file_id, 'sua_fk_fmfiles__');
				/* @var $suAttachmentFileManagerFile FileManagerFile */
				$suAttachmentFileManagerFile->convertPropertiesToData();
			} else {
				$suAttachmentFileManagerFile = false;
			}
			$submittalAttachment->setSuAttachmentFileManagerFile($suAttachmentFileManagerFile);

			if (isset($row['su_attachment_source_contact_id'])) {
				$su_attachment_source_contact_id = $row['su_attachment_source_contact_id'];
				$row['sua_fk_sua_source_c__id'] = $su_attachment_source_contact_id;
				$suAttachmentSourceContact = self::instantiateOrm($database, 'Contact', $row, null, $su_attachment_source_contact_id, 'sua_fk_sua_source_c__');
				/* @var $suAttachmentSourceContact Contact */
				$suAttachmentSourceContact->convertPropertiesToData();
			} else {
				$suAttachmentSourceContact = false;
			}
			$submittalAttachment->setSuAttachmentSourceContact($suAttachmentSourceContact);

			$arrSubmittalAttachmentsBySubmittalId[] = $submittalAttachment;
		}

		$db->free_result();

		self::$_arrSubmittalAttachmentsBySubmittalId = $arrSubmittalAttachmentsBySubmittalId;

		return $arrSubmittalAttachmentsBySubmittalId;
	}

	/**
	 * Load by constraint `submittal_attachments_fk_fmfiles` foreign key (`su_attachment_file_manager_file_id`) references `file_manager_files` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $su_attachment_file_manager_file_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubmittalAttachmentsBySuAttachmentFileManagerFileId($database, $su_attachment_file_manager_file_id, Input $options=null)
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
			self::$_arrSubmittalAttachmentsBySuAttachmentFileManagerFileId = null;
		}

		$arrSubmittalAttachmentsBySuAttachmentFileManagerFileId = self::$_arrSubmittalAttachmentsBySuAttachmentFileManagerFileId;
		if (isset($arrSubmittalAttachmentsBySuAttachmentFileManagerFileId) && !empty($arrSubmittalAttachmentsBySuAttachmentFileManagerFileId)) {
			return $arrSubmittalAttachmentsBySuAttachmentFileManagerFileId;
		}

		$su_attachment_file_manager_file_id = (int) $su_attachment_file_manager_file_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `submittal_id` ASC, `su_attachment_file_manager_file_id` ASC, `su_attachment_source_contact_id` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY sua.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubmittalAttachment = new SubmittalAttachment($database);
			$sqlOrderByColumns = $tmpSubmittalAttachment->constructSqlOrderByColumns($arrOrderByAttributes);

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
	sua.*

FROM `submittal_attachments` sua
WHERE sua.`su_attachment_file_manager_file_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `submittal_id` ASC, `su_attachment_file_manager_file_id` ASC, `su_attachment_source_contact_id` ASC, `sort_order` ASC
		$arrValues = array($su_attachment_file_manager_file_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubmittalAttachmentsBySuAttachmentFileManagerFileId = array();
		while ($row = $db->fetch()) {
			$submittalAttachment = self::instantiateOrm($database, 'SubmittalAttachment', $row);
			/* @var $submittalAttachment SubmittalAttachment */
			$arrSubmittalAttachmentsBySuAttachmentFileManagerFileId[] = $submittalAttachment;
		}

		$db->free_result();

		self::$_arrSubmittalAttachmentsBySuAttachmentFileManagerFileId = $arrSubmittalAttachmentsBySuAttachmentFileManagerFileId;

		return $arrSubmittalAttachmentsBySuAttachmentFileManagerFileId;
	}

	/**
	 * Load by constraint `submittal_attachments_fk_sua_source_c` foreign key (`su_attachment_source_contact_id`) references `contacts` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $su_attachment_source_contact_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubmittalAttachmentsBySuAttachmentSourceContactId($database, $su_attachment_source_contact_id, Input $options=null)
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
			self::$_arrSubmittalAttachmentsBySuAttachmentSourceContactId = null;
		}

		$arrSubmittalAttachmentsBySuAttachmentSourceContactId = self::$_arrSubmittalAttachmentsBySuAttachmentSourceContactId;
		if (isset($arrSubmittalAttachmentsBySuAttachmentSourceContactId) && !empty($arrSubmittalAttachmentsBySuAttachmentSourceContactId)) {
			return $arrSubmittalAttachmentsBySuAttachmentSourceContactId;
		}

		$su_attachment_source_contact_id = (int) $su_attachment_source_contact_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `submittal_id` ASC, `su_attachment_file_manager_file_id` ASC, `su_attachment_source_contact_id` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY sua.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubmittalAttachment = new SubmittalAttachment($database);
			$sqlOrderByColumns = $tmpSubmittalAttachment->constructSqlOrderByColumns($arrOrderByAttributes);

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
	sua.*

FROM `submittal_attachments` sua
WHERE sua.`su_attachment_source_contact_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `submittal_id` ASC, `su_attachment_file_manager_file_id` ASC, `su_attachment_source_contact_id` ASC, `sort_order` ASC
		$arrValues = array($su_attachment_source_contact_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubmittalAttachmentsBySuAttachmentSourceContactId = array();
		while ($row = $db->fetch()) {
			$submittalAttachment = self::instantiateOrm($database, 'SubmittalAttachment', $row);
			/* @var $submittalAttachment SubmittalAttachment */
			$arrSubmittalAttachmentsBySuAttachmentSourceContactId[] = $submittalAttachment;
		}

		$db->free_result();

		self::$_arrSubmittalAttachmentsBySuAttachmentSourceContactId = $arrSubmittalAttachmentsBySuAttachmentSourceContactId;

		return $arrSubmittalAttachmentsBySuAttachmentSourceContactId;
	}

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all submittal_attachments records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllSubmittalAttachments($database, Input $options=null)
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
			self::$_arrAllSubmittalAttachments = null;
		}

		$arrAllSubmittalAttachments = self::$_arrAllSubmittalAttachments;
		if (isset($arrAllSubmittalAttachments) && !empty($arrAllSubmittalAttachments)) {
			return $arrAllSubmittalAttachments;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `submittal_id` ASC, `su_attachment_file_manager_file_id` ASC, `su_attachment_source_contact_id` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY sua.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubmittalAttachment = new SubmittalAttachment($database);
			$sqlOrderByColumns = $tmpSubmittalAttachment->constructSqlOrderByColumns($arrOrderByAttributes);

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
	sua.*

FROM `submittal_attachments` sua{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `submittal_id` ASC, `su_attachment_file_manager_file_id` ASC, `su_attachment_source_contact_id` ASC, `sort_order` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllSubmittalAttachments = array();
		while ($row = $db->fetch()) {
			$submittalAttachment = self::instantiateOrm($database, 'SubmittalAttachment', $row);
			/* @var $submittalAttachment SubmittalAttachment */
			$arrAllSubmittalAttachments[] = $submittalAttachment;
		}

		$db->free_result();

		self::$_arrAllSubmittalAttachments = $arrAllSubmittalAttachments;

		return $arrAllSubmittalAttachments;
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
INTO `submittal_attachments`
(`submittal_id`, `su_attachment_file_manager_file_id`, `su_attachment_source_contact_id`,`is_added`, `sort_order`)
VALUES (?, ?, ?, ? ,?)
ON DUPLICATE KEY UPDATE `su_attachment_source_contact_id` = ?,`is_added` =?, `sort_order` = ?
";
		$arrValues = array($this->submittal_id, $this->su_attachment_file_manager_file_id, $this->su_attachment_source_contact_id,$this->is_added, $this->sort_order, $this->su_attachment_source_contact_id,$this->is_added, $this->sort_order);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$submittal_attachment_id = $db->insertId;
		$db->free_result();

		return $submittal_attachment_id;
	}

	// Save: insert ignore

	/**
	 * Find su_attachment_sequence_number value.
	 *
	 * @param string $database
	 * @param int $submittal_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findNextSubmittalAttachmentSequenceNumber($database, $submittal_id)
	{
		$next_su_attachment_sequence_number = 1;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT MAX(sua.su_attachment_sequence_number) AS 'max_su_attachment_sequence_number'
FROM `submittal_attachments` sua
WHERE sua.`submittal_id` = ?
";
		$arrValues = array($submittal_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$max_su_attachment_sequence_number = $row['max_su_attachment_sequence_number'];
			$next_su_attachment_sequence_number = $max_su_attachment_sequence_number + 1;
		}

		return $next_su_attachment_sequence_number;
	}
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

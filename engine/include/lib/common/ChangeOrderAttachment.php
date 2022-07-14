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
 * ChangeOrderAttachment.
 *
 * @category   Framework
 * @package    ChangeOrderAttachment
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class ChangeOrderAttachment extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'ChangeOrderAttachment';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'change_order_attachments';

	/**
	 * Singular version of the table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_tableNameSingular = 'change_order_attachment';

	/**
	 * primary key (`change_order_id`,`co_attachment_file_manager_file_id`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrPrimaryKey = array(
		'change_order_id' => 'int',
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
		'unique_change_order_attachment_via_primary_key' => array(
			'change_order_id' => 'int',
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
		'change_order_id' => 'change_order_id',
		'co_attachment_file_manager_file_id' => 'co_attachment_file_manager_file_id',

		'co_attachment_source_contact_id' => 'co_attachment_source_contact_id',

		'sort_order' => 'sort_order'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $change_order_id;
	public $co_attachment_file_manager_file_id;

	public $co_attachment_source_contact_id;

	public $sort_order;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties

	// HTML ENTITY ENCODED NL2BR ORM string properties

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)
	protected static $_arrChangeOrderAttachmentsByChangeOrderId;
	protected static $_arrChangeOrderAttachmentsByCoAttachmentFileManagerFileId;
	protected static $_arrChangeOrderAttachmentsByCoAttachmentSourceContactId;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllChangeOrderAttachments;

	// Foreign Key Objects
	private $_changeOrder;
	private $_coAttachmentFileManagerFile;
	private $_coAttachmentSourceContact;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='change_order_attachments')
	{
		parent::__construct($table);
		$this->setDatabase($database);
	}

	// Foreign Key Object Accessor Methods
	public function getChangeOrder()
	{
		if (isset($this->_changeOrder)) {
			return $this->_changeOrder;
		} else {
			return null;
		}
	}

	public function setChangeOrder($changeOrder)
	{
		$this->_changeOrder = $changeOrder;
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
	public static function getArrChangeOrderAttachmentsByChangeOrderId()
	{
		if (isset(self::$_arrChangeOrderAttachmentsByChangeOrderId)) {
			return self::$_arrChangeOrderAttachmentsByChangeOrderId;
		} else {
			return null;
		}
	}

	public static function setArrChangeOrderAttachmentsByChangeOrderId($arrChangeOrderAttachmentsByChangeOrderId)
	{
		self::$_arrChangeOrderAttachmentsByChangeOrderId = $arrChangeOrderAttachmentsByChangeOrderId;
	}

	public static function getArrChangeOrderAttachmentsByCoAttachmentFileManagerFileId()
	{
		if (isset(self::$_arrChangeOrderAttachmentsByCoAttachmentFileManagerFileId)) {
			return self::$_arrChangeOrderAttachmentsByCoAttachmentFileManagerFileId;
		} else {
			return null;
		}
	}

	public static function setArrChangeOrderAttachmentsByCoAttachmentFileManagerFileId($arrChangeOrderAttachmentsByCoAttachmentFileManagerFileId)
	{
		self::$_arrChangeOrderAttachmentsByCoAttachmentFileManagerFileId = $arrChangeOrderAttachmentsByCoAttachmentFileManagerFileId;
	}

	public static function getArrChangeOrderAttachmentsByCoAttachmentSourceContactId()
	{
		if (isset(self::$_arrChangeOrderAttachmentsByCoAttachmentSourceContactId)) {
			return self::$_arrChangeOrderAttachmentsByCoAttachmentSourceContactId;
		} else {
			return null;
		}
	}

	public static function setArrChangeOrderAttachmentsByCoAttachmentSourceContactId($arrChangeOrderAttachmentsByCoAttachmentSourceContactId)
	{
		self::$_arrChangeOrderAttachmentsByCoAttachmentSourceContactId = $arrChangeOrderAttachmentsByCoAttachmentSourceContactId;
	}

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllChangeOrderAttachments()
	{
		if (isset(self::$_arrAllChangeOrderAttachments)) {
			return self::$_arrAllChangeOrderAttachments;
		} else {
			return null;
		}
	}

	public static function setArrAllChangeOrderAttachments($arrAllChangeOrderAttachments)
	{
		self::$_arrAllChangeOrderAttachments = $arrAllChangeOrderAttachments;
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
	 * Find by primary key (`change_order_id`,`co_attachment_file_manager_file_id`).
	 *
	 * @param string $database
	 * @param int $change_order_id
	 * @param int $co_attachment_file_manager_file_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findByChangeOrderIdAndCoAttachmentFileManagerFileId($database, $change_order_id, $co_attachment_file_manager_file_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	coa.*

FROM `change_order_attachments` coa
WHERE coa.`change_order_id` = ?
AND coa.`co_attachment_file_manager_file_id` = ?
";
		$arrValues = array($change_order_id, $co_attachment_file_manager_file_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row && !empty($row)) {
			$changeOrderAttachment = self::instantiateOrm($database, 'ChangeOrderAttachment', $row);
			/* @var $changeOrderAttachment ChangeOrderAttachment */
			return $changeOrderAttachment;
		} else {
			return false;
		}
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Find by primary key (`change_order_id`,`co_attachment_file_manager_file_id`) Extended.
	 *
	 * @param string $database
	 * @param int $change_order_id
	 * @param int $co_attachment_file_manager_file_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findByChangeOrderIdAndCoAttachmentFileManagerFileIdExtended($database, $change_order_id, $co_attachment_file_manager_file_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	coa_fk_co.`id` AS 'coa_fk_co__change_order_id',
	coa_fk_co.`project_id` AS 'coa_fk_co__project_id',
	coa_fk_co.`co_sequence_number` AS 'coa_fk_co__co_sequence_number',
	coa_fk_co.`co_custom_sequence_number` AS 'coa_fk_co__co_custom_sequence_number',
	coa_fk_co.`co_scheduled_value` AS 'coa_fk_co__co_scheduled_value',
	coa_fk_co.`co_delay_days` AS 'coa_fk_co__co_delay_days',
	coa_fk_co.`change_order_type_id` AS 'coa_fk_co__change_order_type_id',
	coa_fk_co.`change_order_status_id` AS 'coa_fk_co__change_order_status_id',
	coa_fk_co.`change_order_priority_id` AS 'coa_fk_co__change_order_priority_id',
	coa_fk_co.`co_file_manager_file_id` AS 'coa_fk_co__co_file_manager_file_id',
	coa_fk_co.`co_cost_code_id` AS 'coa_fk_co__co_cost_code_id',
	coa_fk_co.`co_creator_contact_id` AS 'coa_fk_co__co_creator_contact_id',
	coa_fk_co.`co_creator_contact_company_office_id` AS 'coa_fk_co__co_creator_contact_company_office_id',
	coa_fk_co.`co_creator_phone_contact_company_office_phone_number_id` AS 'coa_fk_co__co_creator_phone_contact_company_office_phone_number_id',
	coa_fk_co.`co_creator_fax_contact_company_office_phone_number_id` AS 'coa_fk_co__co_creator_fax_contact_company_office_phone_number_id',
	coa_fk_co.`co_creator_contact_mobile_phone_number_id` AS 'coa_fk_co__co_creator_contact_mobile_phone_number_id',
	coa_fk_co.`co_recipient_contact_id` AS 'coa_fk_co__co_recipient_contact_id',
	coa_fk_co.`co_recipient_contact_company_office_id` AS 'coa_fk_co__co_recipient_contact_company_office_id',
	coa_fk_co.`co_recipient_phone_contact_company_office_phone_number_id` AS 'coa_fk_co__co_recipient_phone_contact_company_office_phone_number_id',
	coa_fk_co.`co_recipient_fax_contact_company_office_phone_number_id` AS 'coa_fk_co__co_recipient_fax_contact_company_office_phone_number_id',
	coa_fk_co.`co_recipient_contact_mobile_phone_number_id` AS 'coa_fk_co__co_recipient_contact_mobile_phone_number_id',
	coa_fk_co.`co_initiator_contact_id` AS 'coa_fk_co__co_initiator_contact_id',
	coa_fk_co.`co_initiator_contact_company_office_id` AS 'coa_fk_co__co_initiator_contact_company_office_id',
	coa_fk_co.`co_initiator_phone_contact_company_office_phone_number_id` AS 'coa_fk_co__co_initiator_phone_contact_company_office_phone_number_id',
	coa_fk_co.`co_initiator_fax_contact_company_office_phone_number_id` AS 'coa_fk_co__co_initiator_fax_contact_company_office_phone_number_id',
	coa_fk_co.`co_initiator_contact_mobile_phone_number_id` AS 'coa_fk_co__co_initiator_contact_mobile_phone_number_id',
	coa_fk_co.`co_title` AS 'coa_fk_co__co_title',
	coa_fk_co.`co_plan_page_reference` AS 'coa_fk_co__co_plan_page_reference',
	coa_fk_co.`co_statement` AS 'coa_fk_co__co_statement',
	coa_fk_co.`created` AS 'coa_fk_co__created',
	coa_fk_co.`co_revised_project_completion_date` AS 'coa_fk_co__co_revised_project_completion_date',
	coa_fk_co.`co_closed_date` AS 'coa_fk_co__co_closed_date',

	coa_fk_fmfiles.`id` AS 'coa_fk_fmfiles__file_manager_file_id',
	coa_fk_fmfiles.`user_company_id` AS 'coa_fk_fmfiles__user_company_id',
	coa_fk_fmfiles.`contact_id` AS 'coa_fk_fmfiles__contact_id',
	coa_fk_fmfiles.`project_id` AS 'coa_fk_fmfiles__project_id',
	coa_fk_fmfiles.`file_manager_folder_id` AS 'coa_fk_fmfiles__file_manager_folder_id',
	coa_fk_fmfiles.`file_location_id` AS 'coa_fk_fmfiles__file_location_id',
	coa_fk_fmfiles.`virtual_file_name` AS 'coa_fk_fmfiles__virtual_file_name',
	coa_fk_fmfiles.`version_number` AS 'coa_fk_fmfiles__version_number',
	coa_fk_fmfiles.`virtual_file_name_sha1` AS 'coa_fk_fmfiles__virtual_file_name_sha1',
	coa_fk_fmfiles.`virtual_file_mime_type` AS 'coa_fk_fmfiles__virtual_file_mime_type',
	coa_fk_fmfiles.`modified` AS 'coa_fk_fmfiles__modified',
	coa_fk_fmfiles.`created` AS 'coa_fk_fmfiles__created',
	coa_fk_fmfiles.`deleted_flag` AS 'coa_fk_fmfiles__deleted_flag',
	coa_fk_fmfiles.`directly_deleted_flag` AS 'coa_fk_fmfiles__directly_deleted_flag',

	coa_fk_coa_source_c.`id` AS 'coa_fk_coa_source_c__contact_id',
	coa_fk_coa_source_c.`user_company_id` AS 'coa_fk_coa_source_c__user_company_id',
	coa_fk_coa_source_c.`user_id` AS 'coa_fk_coa_source_c__user_id',
	coa_fk_coa_source_c.`contact_company_id` AS 'coa_fk_coa_source_c__contact_company_id',
	coa_fk_coa_source_c.`email` AS 'coa_fk_coa_source_c__email',
	coa_fk_coa_source_c.`name_prefix` AS 'coa_fk_coa_source_c__name_prefix',
	coa_fk_coa_source_c.`first_name` AS 'coa_fk_coa_source_c__first_name',
	coa_fk_coa_source_c.`additional_name` AS 'coa_fk_coa_source_c__additional_name',
	coa_fk_coa_source_c.`middle_name` AS 'coa_fk_coa_source_c__middle_name',
	coa_fk_coa_source_c.`last_name` AS 'coa_fk_coa_source_c__last_name',
	coa_fk_coa_source_c.`name_suffix` AS 'coa_fk_coa_source_c__name_suffix',
	coa_fk_coa_source_c.`title` AS 'coa_fk_coa_source_c__title',
	coa_fk_coa_source_c.`vendor_flag` AS 'coa_fk_coa_source_c__vendor_flag',

	coa.*

FROM `change_order_attachments` coa
	INNER JOIN `change_orders` coa_fk_co ON coa.`change_order_id` = coa_fk_co.`id`
	INNER JOIN `file_manager_files` coa_fk_fmfiles ON coa.`co_attachment_file_manager_file_id` = coa_fk_fmfiles.`id`
	INNER JOIN `contacts` coa_fk_coa_source_c ON coa.`co_attachment_source_contact_id` = coa_fk_coa_source_c.`id`
WHERE coa.`change_order_id` = ?
AND coa.`co_attachment_file_manager_file_id` = ?
";
		$arrValues = array($change_order_id, $co_attachment_file_manager_file_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row && !empty($row)) {
			$changeOrderAttachment = self::instantiateOrm($database, 'ChangeOrderAttachment', $row);
			/* @var $changeOrderAttachment ChangeOrderAttachment */
			$changeOrderAttachment->convertPropertiesToData();

			if (isset($row['change_order_id'])) {
				$change_order_id = $row['change_order_id'];
				$row['coa_fk_co__id'] = $change_order_id;
				$changeOrder = self::instantiateOrm($database, 'ChangeOrder', $row, null, $change_order_id, 'coa_fk_co__');
				/* @var $changeOrder ChangeOrder */
				$changeOrder->convertPropertiesToData();
			} else {
				$changeOrder = false;
			}
			$changeOrderAttachment->setChangeOrder($changeOrder);

			if (isset($row['co_attachment_file_manager_file_id'])) {
				$co_attachment_file_manager_file_id = $row['co_attachment_file_manager_file_id'];
				$row['coa_fk_fmfiles__id'] = $co_attachment_file_manager_file_id;
				$coAttachmentFileManagerFile = self::instantiateOrm($database, 'FileManagerFile', $row, null, $co_attachment_file_manager_file_id, 'coa_fk_fmfiles__');
				/* @var $coAttachmentFileManagerFile FileManagerFile */
				$coAttachmentFileManagerFile->convertPropertiesToData();
			} else {
				$coAttachmentFileManagerFile = false;
			}
			$changeOrderAttachment->setCoAttachmentFileManagerFile($coAttachmentFileManagerFile);

			if (isset($row['co_attachment_source_contact_id'])) {
				$co_attachment_source_contact_id = $row['co_attachment_source_contact_id'];
				$row['coa_fk_coa_source_c__id'] = $co_attachment_source_contact_id;
				$coAttachmentSourceContact = self::instantiateOrm($database, 'Contact', $row, null, $co_attachment_source_contact_id, 'coa_fk_coa_source_c__');
				/* @var $coAttachmentSourceContact Contact */
				$coAttachmentSourceContact->convertPropertiesToData();
			} else {
				$coAttachmentSourceContact = false;
			}
			$changeOrderAttachment->setCoAttachmentSourceContact($coAttachmentSourceContact);

			return $changeOrderAttachment;
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
	 * @param array $arrChangeOrderIdAndCoAttachmentFileManagerFileIdList
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadChangeOrderAttachmentsByArrChangeOrderIdAndCoAttachmentFileManagerFileIdList($database, $arrChangeOrderIdAndCoAttachmentFileManagerFileIdList, Input $options=null)
	{
		if (empty($arrChangeOrderIdAndCoAttachmentFileManagerFileIdList)) {
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
		// ORDER BY `change_order_id` ASC, `co_attachment_file_manager_file_id` ASC, `co_attachment_source_contact_id` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY coa.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpChangeOrderAttachment = new ChangeOrderAttachment($database);
			$sqlOrderByColumns = $tmpChangeOrderAttachment->constructSqlOrderByColumns($arrOrderByAttributes);

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
		foreach ($arrChangeOrderIdAndCoAttachmentFileManagerFileIdList as $k => $arrTmp) {
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
		if (count($arrChangeOrderIdAndCoAttachmentFileManagerFileIdList) > 1) {
			$sqlWhere = join($arrSqlWhere, ' OR ');
			$sqlWhere = "WHERE ($sqlWhere)";
		} else {
			$sqlWhere = "WHERE $tmpInnerAnd";
		}

		$query =
"
SELECT

	coa.*

FROM `change_order_attachments` coa
{$sqlWhere}{$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrChangeOrderAttachmentsByArrChangeOrderIdAndCoAttachmentFileManagerFileIdList = array();
		while ($row = $db->fetch()) {
			$changeOrderAttachment = self::instantiateOrm($database, 'ChangeOrderAttachment', $row);
			/* @var $changeOrderAttachment ChangeOrderAttachment */
			$arrChangeOrderAttachmentsByArrChangeOrderIdAndCoAttachmentFileManagerFileIdList[] = $changeOrderAttachment;
		}

		$db->free_result();

		return $arrChangeOrderAttachmentsByArrChangeOrderIdAndCoAttachmentFileManagerFileIdList;
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `change_order_attachments_fk_co` foreign key (`change_order_id`) references `change_orders` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $change_order_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadChangeOrderAttachmentsByChangeOrderId($database, $change_order_id, Input $options=null,$filter='')
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
			self::$_arrChangeOrderAttachmentsByChangeOrderId = null;
		}

		$arrChangeOrderAttachmentsByChangeOrderId = self::$_arrChangeOrderAttachmentsByChangeOrderId;
		if (isset($arrChangeOrderAttachmentsByChangeOrderId) && !empty($arrChangeOrderAttachmentsByChangeOrderId)) {
			return $arrChangeOrderAttachmentsByChangeOrderId;
		}

		$change_order_id = (int) $change_order_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `change_order_id` ASC, `co_attachment_file_manager_file_id` ASC, `co_attachment_source_contact_id` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY coa.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpChangeOrderAttachment = new ChangeOrderAttachment($database);
			$sqlOrderByColumns = $tmpChangeOrderAttachment->constructSqlOrderByColumns($arrOrderByAttributes);

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

		if($filter=='Y')
		{
			$sqlfilter ="and upload_execute='Y'";
		}else
		{
			$sqlfilter ="and upload_execute='N'";
		}

		$query =
"
SELECT
	coa.*

FROM `change_order_attachments` coa
WHERE coa.`change_order_id` = ? {$sqlfilter} {$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `change_order_id` ASC, `co_attachment_file_manager_file_id` ASC, `co_attachment_source_contact_id` ASC, `sort_order` ASC
		$arrValues = array($change_order_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrChangeOrderAttachmentsByChangeOrderId = array();
		while ($row = $db->fetch()) {
			$changeOrderAttachment = self::instantiateOrm($database, 'ChangeOrderAttachment', $row);
			/* @var $changeOrderAttachment ChangeOrderAttachment */
			$arrChangeOrderAttachmentsByChangeOrderId[] = $changeOrderAttachment;
		}

		$db->free_result();

		self::$_arrChangeOrderAttachmentsByChangeOrderId = $arrChangeOrderAttachmentsByChangeOrderId;

		return $arrChangeOrderAttachmentsByChangeOrderId;
	}

	/**
	 * Load by constraint `change_order_attachments_fk_fmfiles` foreign key (`co_attachment_file_manager_file_id`) references `file_manager_files` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $co_attachment_file_manager_file_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadChangeOrderAttachmentsByCoAttachmentFileManagerFileId($database, $co_attachment_file_manager_file_id, Input $options=null)
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
			self::$_arrChangeOrderAttachmentsByCoAttachmentFileManagerFileId = null;
		}

		$arrChangeOrderAttachmentsByCoAttachmentFileManagerFileId = self::$_arrChangeOrderAttachmentsByCoAttachmentFileManagerFileId;
		if (isset($arrChangeOrderAttachmentsByCoAttachmentFileManagerFileId) && !empty($arrChangeOrderAttachmentsByCoAttachmentFileManagerFileId)) {
			return $arrChangeOrderAttachmentsByCoAttachmentFileManagerFileId;
		}

		$co_attachment_file_manager_file_id = (int) $co_attachment_file_manager_file_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `change_order_id` ASC, `co_attachment_file_manager_file_id` ASC, `co_attachment_source_contact_id` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY coa.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpChangeOrderAttachment = new ChangeOrderAttachment($database);
			$sqlOrderByColumns = $tmpChangeOrderAttachment->constructSqlOrderByColumns($arrOrderByAttributes);

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
	coa.*

FROM `change_order_attachments` coa
WHERE coa.`co_attachment_file_manager_file_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `change_order_id` ASC, `co_attachment_file_manager_file_id` ASC, `co_attachment_source_contact_id` ASC, `sort_order` ASC
		$arrValues = array($co_attachment_file_manager_file_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrChangeOrderAttachmentsByCoAttachmentFileManagerFileId = array();
		while ($row = $db->fetch()) {
			$changeOrderAttachment = self::instantiateOrm($database, 'ChangeOrderAttachment', $row);
			/* @var $changeOrderAttachment ChangeOrderAttachment */
			$arrChangeOrderAttachmentsByCoAttachmentFileManagerFileId[] = $changeOrderAttachment;
		}

		$db->free_result();

		self::$_arrChangeOrderAttachmentsByCoAttachmentFileManagerFileId = $arrChangeOrderAttachmentsByCoAttachmentFileManagerFileId;

		return $arrChangeOrderAttachmentsByCoAttachmentFileManagerFileId;
	}

	/**
	 * Load by constraint `change_order_attachments_fk_coa_source_c` foreign key (`co_attachment_source_contact_id`) references `contacts` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $co_attachment_source_contact_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadChangeOrderAttachmentsByCoAttachmentSourceContactId($database, $co_attachment_source_contact_id, Input $options=null)
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
			self::$_arrChangeOrderAttachmentsByCoAttachmentSourceContactId = null;
		}

		$arrChangeOrderAttachmentsByCoAttachmentSourceContactId = self::$_arrChangeOrderAttachmentsByCoAttachmentSourceContactId;
		if (isset($arrChangeOrderAttachmentsByCoAttachmentSourceContactId) && !empty($arrChangeOrderAttachmentsByCoAttachmentSourceContactId)) {
			return $arrChangeOrderAttachmentsByCoAttachmentSourceContactId;
		}

		$co_attachment_source_contact_id = (int) $co_attachment_source_contact_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `change_order_id` ASC, `co_attachment_file_manager_file_id` ASC, `co_attachment_source_contact_id` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY coa.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpChangeOrderAttachment = new ChangeOrderAttachment($database);
			$sqlOrderByColumns = $tmpChangeOrderAttachment->constructSqlOrderByColumns($arrOrderByAttributes);

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
	coa.*

FROM `change_order_attachments` coa
WHERE coa.`co_attachment_source_contact_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `change_order_id` ASC, `co_attachment_file_manager_file_id` ASC, `co_attachment_source_contact_id` ASC, `sort_order` ASC
		$arrValues = array($co_attachment_source_contact_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrChangeOrderAttachmentsByCoAttachmentSourceContactId = array();
		while ($row = $db->fetch()) {
			$changeOrderAttachment = self::instantiateOrm($database, 'ChangeOrderAttachment', $row);
			/* @var $changeOrderAttachment ChangeOrderAttachment */
			$arrChangeOrderAttachmentsByCoAttachmentSourceContactId[] = $changeOrderAttachment;
		}

		$db->free_result();

		self::$_arrChangeOrderAttachmentsByCoAttachmentSourceContactId = $arrChangeOrderAttachmentsByCoAttachmentSourceContactId;

		return $arrChangeOrderAttachmentsByCoAttachmentSourceContactId;
	}

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all change_order_attachments records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllChangeOrderAttachments($database, Input $options=null)
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
			self::$_arrAllChangeOrderAttachments = null;
		}

		$arrAllChangeOrderAttachments = self::$_arrAllChangeOrderAttachments;
		if (isset($arrAllChangeOrderAttachments) && !empty($arrAllChangeOrderAttachments)) {
			return $arrAllChangeOrderAttachments;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `change_order_id` ASC, `co_attachment_file_manager_file_id` ASC, `co_attachment_source_contact_id` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY coa.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpChangeOrderAttachment = new ChangeOrderAttachment($database);
			$sqlOrderByColumns = $tmpChangeOrderAttachment->constructSqlOrderByColumns($arrOrderByAttributes);

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
	coa.*

FROM `change_order_attachments` coa{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `change_order_id` ASC, `co_attachment_file_manager_file_id` ASC, `co_attachment_source_contact_id` ASC, `sort_order` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllChangeOrderAttachments = array();
		while ($row = $db->fetch()) {
			$changeOrderAttachment = self::instantiateOrm($database, 'ChangeOrderAttachment', $row);
			/* @var $changeOrderAttachment ChangeOrderAttachment */
			$arrAllChangeOrderAttachments[] = $changeOrderAttachment;
		}

		$db->free_result();

		self::$_arrAllChangeOrderAttachments = $arrAllChangeOrderAttachments;

		return $arrAllChangeOrderAttachments;
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
INTO `change_order_attachments`
(`change_order_id`, `co_attachment_file_manager_file_id`, `co_attachment_source_contact_id`, `sort_order`)
VALUES (?, ?, ?, ?)
ON DUPLICATE KEY UPDATE `co_attachment_source_contact_id` = ?, `sort_order` = ?
";
		$arrValues = array($this->change_order_id, $this->co_attachment_file_manager_file_id, $this->co_attachment_source_contact_id, $this->sort_order, $this->co_attachment_source_contact_id, $this->sort_order);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$change_order_attachment_id = $db->insertId;
		$db->free_result();

		return $change_order_attachment_id;
	}

	// Save: insert ignore
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

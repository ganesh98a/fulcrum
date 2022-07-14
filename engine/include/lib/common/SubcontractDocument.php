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
 * SubcontractDocument.
 *
 * @category   Framework
 * @package    SubcontractDocument
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class SubcontractDocument extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'SubcontractDocument';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'subcontract_documents';

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
	 * unique index `unique_subcontract_document` (`subcontract_id`,`subcontract_item_template_id`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_subcontract_document' => array(
			'subcontract_id' => 'int',
			'subcontract_item_template_id' => 'int'
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
		'id' => 'subcontract_document_id',

		'subcontract_id' => 'subcontract_id',
		'subcontract_item_template_id' => 'subcontract_item_template_id',

		'unsigned_subcontract_document_file_manager_file_id' => 'unsigned_subcontract_document_file_manager_file_id',
		'signed_subcontract_document_file_manager_file_id' => 'signed_subcontract_document_file_manager_file_id',
		'gc_signatory' =>'gc_signatory',
		'vendor_signatory' =>'vendor_signatory',
		'auto_generated_flag' => 'auto_generated_flag',
		'disabled_flag' => 'disabled_flag',
		'sort_order' => 'sort_order'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $subcontract_document_id;

	public $subcontract_id;
	public $subcontract_item_template_id;

	public $unsigned_subcontract_document_file_manager_file_id;
	public $signed_subcontract_document_file_manager_file_id;
	public $gc_signatory;
	public $vendor_signatory;


	public $auto_generated_flag;
	public $disabled_flag;
	public $sort_order;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties

	// HTML ENTITY ENCODED NL2BR ORM string properties

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)
	protected static $_arrSubcontractDocumentsBySubcontractId;
	protected static $_arrSubcontractDocumentsBySubcontractItemTemplateId;
	protected static $_arrSubcontractDocumentsByUnsignedSubcontractDocumentFileManagerFileId;
	protected static $_arrSubcontractDocumentsBySignedSubcontractDocumentFileManagerFileId;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllSubcontractDocuments;

	// Foreign Key Objects
	private $_subcontract;
	private $_subcontractItemTemplate;
	private $_unsignedSubcontractDocumentFileManagerFile;
	private $_signedSubcontractDocumentFileManagerFile;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='subcontract_documents')
	{
		parent::__construct($table);
		$this->setDatabase($database);
	}

	// Foreign Key Object Accessor Methods
	public function getSubcontract()
	{
		if (isset($this->_subcontract)) {
			return $this->_subcontract;
		} else {
			return null;
		}
	}

	public function setSubcontract($subcontract)
	{
		$this->_subcontract = $subcontract;
	}

	public function getSubcontractItemTemplate()
	{
		if (isset($this->_subcontractItemTemplate)) {
			return $this->_subcontractItemTemplate;
		} else {
			return null;
		}
	}

	public function setSubcontractItemTemplate($subcontractItemTemplate)
	{
		$this->_subcontractItemTemplate = $subcontractItemTemplate;
	}

	public function getUnsignedSubcontractDocumentFileManagerFile()
	{
		if (isset($this->_unsignedSubcontractDocumentFileManagerFile)) {
			return $this->_unsignedSubcontractDocumentFileManagerFile;
		} else {
			return null;
		}
	}

	public function setUnsignedSubcontractDocumentFileManagerFile($unsignedSubcontractDocumentFileManagerFile)
	{
		$this->_unsignedSubcontractDocumentFileManagerFile = $unsignedSubcontractDocumentFileManagerFile;
	}

	public function getSignedSubcontractDocumentFileManagerFile()
	{
		if (isset($this->_signedSubcontractDocumentFileManagerFile)) {
			return $this->_signedSubcontractDocumentFileManagerFile;
		} else {
			return null;
		}
	}

	public function setSignedSubcontractDocumentFileManagerFile($signedSubcontractDocumentFileManagerFile)
	{
		$this->_signedSubcontractDocumentFileManagerFile = $signedSubcontractDocumentFileManagerFile;
	}

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)
	public static function getArrSubcontractDocumentsBySubcontractId()
	{
		if (isset(self::$_arrSubcontractDocumentsBySubcontractId)) {
			return self::$_arrSubcontractDocumentsBySubcontractId;
		} else {
			return null;
		}
	}

	public static function setArrSubcontractDocumentsBySubcontractId($arrSubcontractDocumentsBySubcontractId)
	{
		self::$_arrSubcontractDocumentsBySubcontractId = $arrSubcontractDocumentsBySubcontractId;
	}

	public static function getArrSubcontractDocumentsBySubcontractItemTemplateId()
	{
		if (isset(self::$_arrSubcontractDocumentsBySubcontractItemTemplateId)) {
			return self::$_arrSubcontractDocumentsBySubcontractItemTemplateId;
		} else {
			return null;
		}
	}

	public static function setArrSubcontractDocumentsBySubcontractItemTemplateId($arrSubcontractDocumentsBySubcontractItemTemplateId)
	{
		self::$_arrSubcontractDocumentsBySubcontractItemTemplateId = $arrSubcontractDocumentsBySubcontractItemTemplateId;
	}

	public static function getArrSubcontractDocumentsByUnsignedSubcontractDocumentFileManagerFileId()
	{
		if (isset(self::$_arrSubcontractDocumentsByUnsignedSubcontractDocumentFileManagerFileId)) {
			return self::$_arrSubcontractDocumentsByUnsignedSubcontractDocumentFileManagerFileId;
		} else {
			return null;
		}
	}

	public static function setArrSubcontractDocumentsByUnsignedSubcontractDocumentFileManagerFileId($arrSubcontractDocumentsByUnsignedSubcontractDocumentFileManagerFileId)
	{
		self::$_arrSubcontractDocumentsByUnsignedSubcontractDocumentFileManagerFileId = $arrSubcontractDocumentsByUnsignedSubcontractDocumentFileManagerFileId;
	}

	public static function getArrSubcontractDocumentsBySignedSubcontractDocumentFileManagerFileId()
	{
		if (isset(self::$_arrSubcontractDocumentsBySignedSubcontractDocumentFileManagerFileId)) {
			return self::$_arrSubcontractDocumentsBySignedSubcontractDocumentFileManagerFileId;
		} else {
			return null;
		}
	}

	public static function setArrSubcontractDocumentsBySignedSubcontractDocumentFileManagerFileId($arrSubcontractDocumentsBySignedSubcontractDocumentFileManagerFileId)
	{
		self::$_arrSubcontractDocumentsBySignedSubcontractDocumentFileManagerFileId = $arrSubcontractDocumentsBySignedSubcontractDocumentFileManagerFileId;
	}

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllSubcontractDocuments()
	{
		if (isset(self::$_arrAllSubcontractDocuments)) {
			return self::$_arrAllSubcontractDocuments;
		} else {
			return null;
		}
	}

	public static function setArrAllSubcontractDocuments($arrAllSubcontractDocuments)
	{
		self::$_arrAllSubcontractDocuments = $arrAllSubcontractDocuments;
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
	 * @param int $subcontract_document_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findById($database, $subcontract_document_id,$table='subcontract_documents', $module='SubcontractDocument')
	{
		$subcontractDocument = parent::findById($database, $subcontract_document_id,$table, $module);

		return $subcontractDocument;
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Similar to FindById, but with SQL as starter code for more complex joins.
	 *
	 * @param string $database
	 * @param int $subcontract_document_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findSubcontractDocumentByIdExtended($database, $subcontract_document_id)
	{
		$subcontract_document_id = (int) $subcontract_document_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	sd_fk_s.`id` AS 'sd_fk_s__subcontract_id',
	sd_fk_s.`gc_budget_line_item_id` AS 'sd_fk_s__gc_budget_line_item_id',
	sd_fk_s.`subcontract_sequence_number` AS 'sd_fk_s__subcontract_sequence_number',
	sd_fk_s.`subcontractor_bid_id` AS 'sd_fk_s__subcontractor_bid_id',
	sd_fk_s.`subcontract_template_id` AS 'sd_fk_s__subcontract_template_id',
	sd_fk_s.`subcontract_gc_contact_company_office_id` AS 'sd_fk_s__subcontract_gc_contact_company_office_id',
	sd_fk_s.`subcontract_gc_phone_contact_company_office_phone_number_id` AS 'sd_fk_s__subcontract_gc_phone_contact_company_office_phone_number_id',
	sd_fk_s.`subcontract_gc_fax_contact_company_office_phone_number_id` AS 'sd_fk_s__subcontract_gc_fax_contact_company_office_phone_number_id',
	sd_fk_s.`subcontract_gc_contact_id` AS 'sd_fk_s__subcontract_gc_contact_id',
	sd_fk_s.`subcontract_gc_contact_mobile_phone_number_id` AS 'sd_fk_s__subcontract_gc_contact_mobile_phone_number_id',
	sd_fk_s.`vendor_id` AS 'sd_fk_s__vendor_id',
	sd_fk_s.`subcontract_vendor_contact_company_office_id` AS 'sd_fk_s__subcontract_vendor_contact_company_office_id',
	sd_fk_s.`subcontract_vendor_phone_contact_company_office_phone_number_id` AS 'sd_fk_s__subcontract_vendor_phone_contact_company_office_phone_number_id',
	sd_fk_s.`subcontract_vendor_fax_contact_company_office_phone_number_id` AS 'sd_fk_s__subcontract_vendor_fax_contact_company_office_phone_number_id',
	sd_fk_s.`subcontract_vendor_contact_id` AS 'sd_fk_s__subcontract_vendor_contact_id',
	sd_fk_s.`subcontract_vendor_contact_mobile_phone_number_id` AS 'sd_fk_s__subcontract_vendor_contact_mobile_phone_number_id',
	sd_fk_s.`unsigned_subcontract_file_manager_file_id` AS 'sd_fk_s__unsigned_subcontract_file_manager_file_id',
	sd_fk_s.`signed_subcontract_file_manager_file_id` AS 'sd_fk_s__signed_subcontract_file_manager_file_id',
	sd_fk_s.`subcontract_forecasted_value` AS 'sd_fk_s__subcontract_forecasted_value',
	sd_fk_s.`subcontract_actual_value` AS 'sd_fk_s__subcontract_actual_value',
	sd_fk_s.`subcontract_retention_percentage` AS 'sd_fk_s__subcontract_retention_percentage',
	sd_fk_s.`subcontract_issued_date` AS 'sd_fk_s__subcontract_issued_date',
	sd_fk_s.`subcontract_target_execution_date` AS 'sd_fk_s__subcontract_target_execution_date',
	sd_fk_s.`subcontract_execution_date` AS 'sd_fk_s__subcontract_execution_date',
	sd_fk_s.`active_flag` AS 'sd_fk_s__active_flag',

	sd_fk_sit.`id` AS 'sd_fk_sit__subcontract_item_template_id',
	sd_fk_sit.`user_company_id` AS 'sd_fk_sit__user_company_id',
	sd_fk_sit.`file_manager_file_id` AS 'sd_fk_sit__file_manager_file_id',
	sd_fk_sit.`user_company_file_template_id` AS 'sd_fk_sit__user_company_file_template_id',
	sd_fk_sit.`subcontract_item` AS 'sd_fk_sit__subcontract_item',
	sd_fk_sit.`subcontract_item_abbreviation` AS 'sd_fk_sit__subcontract_item_abbreviation',
	sd_fk_sit.`subcontract_item_template_type` AS 'sd_fk_sit__subcontract_item_template_type',
	sd_fk_sit.`sort_order` AS 'sd_fk_sit__sort_order',
	sd_fk_sit.`disabled_flag` AS 'sd_fk_sit__disabled_flag',

	sd_fk_unsigned_sd_fmfiles.`id` AS 'sd_fk_unsigned_sd_fmfiles__file_manager_file_id',
	sd_fk_unsigned_sd_fmfiles.`user_company_id` AS 'sd_fk_unsigned_sd_fmfiles__user_company_id',
	sd_fk_unsigned_sd_fmfiles.`contact_id` AS 'sd_fk_unsigned_sd_fmfiles__contact_id',
	sd_fk_unsigned_sd_fmfiles.`project_id` AS 'sd_fk_unsigned_sd_fmfiles__project_id',
	sd_fk_unsigned_sd_fmfiles.`file_manager_folder_id` AS 'sd_fk_unsigned_sd_fmfiles__file_manager_folder_id',
	sd_fk_unsigned_sd_fmfiles.`file_location_id` AS 'sd_fk_unsigned_sd_fmfiles__file_location_id',
	sd_fk_unsigned_sd_fmfiles.`virtual_file_name` AS 'sd_fk_unsigned_sd_fmfiles__virtual_file_name',
	sd_fk_unsigned_sd_fmfiles.`version_number` AS 'sd_fk_unsigned_sd_fmfiles__version_number',
	sd_fk_unsigned_sd_fmfiles.`virtual_file_name_sha1` AS 'sd_fk_unsigned_sd_fmfiles__virtual_file_name_sha1',
	sd_fk_unsigned_sd_fmfiles.`virtual_file_mime_type` AS 'sd_fk_unsigned_sd_fmfiles__virtual_file_mime_type',
	sd_fk_unsigned_sd_fmfiles.`modified` AS 'sd_fk_unsigned_sd_fmfiles__modified',
	sd_fk_unsigned_sd_fmfiles.`created` AS 'sd_fk_unsigned_sd_fmfiles__created',
	sd_fk_unsigned_sd_fmfiles.`deleted_flag` AS 'sd_fk_unsigned_sd_fmfiles__deleted_flag',
	sd_fk_unsigned_sd_fmfiles.`directly_deleted_flag` AS 'sd_fk_unsigned_sd_fmfiles__directly_deleted_flag',

	sd_fk_signed_sd_fmfiles.`id` AS 'sd_fk_signed_sd_fmfiles__file_manager_file_id',
	sd_fk_signed_sd_fmfiles.`user_company_id` AS 'sd_fk_signed_sd_fmfiles__user_company_id',
	sd_fk_signed_sd_fmfiles.`contact_id` AS 'sd_fk_signed_sd_fmfiles__contact_id',
	sd_fk_signed_sd_fmfiles.`project_id` AS 'sd_fk_signed_sd_fmfiles__project_id',
	sd_fk_signed_sd_fmfiles.`file_manager_folder_id` AS 'sd_fk_signed_sd_fmfiles__file_manager_folder_id',
	sd_fk_signed_sd_fmfiles.`file_location_id` AS 'sd_fk_signed_sd_fmfiles__file_location_id',
	sd_fk_signed_sd_fmfiles.`virtual_file_name` AS 'sd_fk_signed_sd_fmfiles__virtual_file_name',
	sd_fk_signed_sd_fmfiles.`version_number` AS 'sd_fk_signed_sd_fmfiles__version_number',
	sd_fk_signed_sd_fmfiles.`virtual_file_name_sha1` AS 'sd_fk_signed_sd_fmfiles__virtual_file_name_sha1',
	sd_fk_signed_sd_fmfiles.`virtual_file_mime_type` AS 'sd_fk_signed_sd_fmfiles__virtual_file_mime_type',
	sd_fk_signed_sd_fmfiles.`modified` AS 'sd_fk_signed_sd_fmfiles__modified',
	sd_fk_signed_sd_fmfiles.`created` AS 'sd_fk_signed_sd_fmfiles__created',
	sd_fk_signed_sd_fmfiles.`deleted_flag` AS 'sd_fk_signed_sd_fmfiles__deleted_flag',
	sd_fk_signed_sd_fmfiles.`directly_deleted_flag` AS 'sd_fk_signed_sd_fmfiles__directly_deleted_flag',

	sd.*

FROM `subcontract_documents` sd
	INNER JOIN `subcontracts` sd_fk_s ON sd.`subcontract_id` = sd_fk_s.`id`
	INNER JOIN `subcontract_item_templates` sd_fk_sit ON sd.`subcontract_item_template_id` = sd_fk_sit.`id`
	LEFT OUTER JOIN `file_manager_files` sd_fk_unsigned_sd_fmfiles ON sd.`unsigned_subcontract_document_file_manager_file_id` = sd_fk_unsigned_sd_fmfiles.`id`
	LEFT OUTER JOIN `file_manager_files` sd_fk_signed_sd_fmfiles ON sd.`signed_subcontract_document_file_manager_file_id` = sd_fk_signed_sd_fmfiles.`id`
WHERE sd.`id` = ?
";
		$arrValues = array($subcontract_document_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$subcontract_document_id = $row['id'];
			$subcontractDocument = self::instantiateOrm($database, 'SubcontractDocument', $row, null, $subcontract_document_id);
			/* @var $subcontractDocument SubcontractDocument */
			$subcontractDocument->convertPropertiesToData();

			if (isset($row['subcontract_id'])) {
				$subcontract_id = $row['subcontract_id'];
				$row['sd_fk_s__id'] = $subcontract_id;
				$subcontract = self::instantiateOrm($database, 'Subcontract', $row, null, $subcontract_id, 'sd_fk_s__');
				/* @var $subcontract Subcontract */
				$subcontract->convertPropertiesToData();
			} else {
				$subcontract = false;
			}
			$subcontractDocument->setSubcontract($subcontract);

			if (isset($row['subcontract_item_template_id'])) {
				$subcontract_item_template_id = $row['subcontract_item_template_id'];
				$row['sd_fk_sit__id'] = $subcontract_item_template_id;
				$subcontractItemTemplate = self::instantiateOrm($database, 'SubcontractItemTemplate', $row, null, $subcontract_item_template_id, 'sd_fk_sit__');
				/* @var $subcontractItemTemplate SubcontractItemTemplate */
				$subcontractItemTemplate->convertPropertiesToData();
			} else {
				$subcontractItemTemplate = false;
			}
			$subcontractDocument->setSubcontractItemTemplate($subcontractItemTemplate);

			if (isset($row['unsigned_subcontract_document_file_manager_file_id'])) {
				$unsigned_subcontract_document_file_manager_file_id = $row['unsigned_subcontract_document_file_manager_file_id'];
				$row['sd_fk_unsigned_sd_fmfiles__id'] = $unsigned_subcontract_document_file_manager_file_id;
				$unsignedSubcontractDocumentFileManagerFile = self::instantiateOrm($database, 'FileManagerFile', $row, null, $unsigned_subcontract_document_file_manager_file_id, 'sd_fk_unsigned_sd_fmfiles__');
				/* @var $unsignedSubcontractDocumentFileManagerFile FileManagerFile */
				$unsignedSubcontractDocumentFileManagerFile->convertPropertiesToData();
			} else {
				$unsignedSubcontractDocumentFileManagerFile = false;
			}
			$subcontractDocument->setUnsignedSubcontractDocumentFileManagerFile($unsignedSubcontractDocumentFileManagerFile);

			if (isset($row['signed_subcontract_document_file_manager_file_id'])) {
				$signed_subcontract_document_file_manager_file_id = $row['signed_subcontract_document_file_manager_file_id'];
				$row['sd_fk_signed_sd_fmfiles__id'] = $signed_subcontract_document_file_manager_file_id;
				$signedSubcontractDocumentFileManagerFile = self::instantiateOrm($database, 'FileManagerFile', $row, null, $signed_subcontract_document_file_manager_file_id, 'sd_fk_signed_sd_fmfiles__');
				/* @var $signedSubcontractDocumentFileManagerFile FileManagerFile */
				$signedSubcontractDocumentFileManagerFile->convertPropertiesToData();
			} else {
				$signedSubcontractDocumentFileManagerFile = false;
			}
			$subcontractDocument->setSignedSubcontractDocumentFileManagerFile($signedSubcontractDocumentFileManagerFile);

			return $subcontractDocument;
		} else {
			return false;
		}
	}

	// Finders: Find By Unique Index
	/**
	 * Find by unique index `unique_subcontract_document` (`subcontract_id`,`subcontract_item_template_id`).
	 *
	 * @param string $database
	 * @param int $subcontract_id
	 * @param int $subcontract_item_template_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findBySubcontractIdAndSubcontractItemTemplateId($database, $subcontract_id, $subcontract_item_template_id)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	sd.*

FROM `subcontract_documents` sd
WHERE sd.`subcontract_id` = ?
AND sd.`subcontract_item_template_id` = ?
";
		$arrValues = array($subcontract_id, $subcontract_item_template_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if ($row && !empty($row)) {
			$subcontract_document_id = $row['id'];
			$subcontractDocument = self::instantiateOrm($database, 'SubcontractDocument', $row, null, $subcontract_document_id);
			/* @var $subcontractDocument SubcontractDocument */
			return $subcontractDocument;
		} else {
			return false;
		}
	}

	// Loaders: Load By pk List (list of auto int ids or other non auto int pk list)
	/**
	 * Load zero or more records by an id list (array of auto int primary keys).
	 *
	 * @param string $database
	 * @param array $arrSubcontractDocumentIds
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubcontractDocumentsByArrSubcontractDocumentIds($database, $arrSubcontractDocumentIds, Input $options=null)
	{
		if (empty($arrSubcontractDocumentIds)) {
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
		// ORDER BY `id` ASC, `subcontract_id` ASC, `subcontract_item_template_id` ASC, `unsigned_subcontract_document_file_manager_file_id` ASC, `signed_subcontract_document_file_manager_file_id` ASC, `auto_generated_flag` ASC, `disabled_flag` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY sd.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubcontractDocument = new SubcontractDocument($database);
			$sqlOrderByColumns = $tmpSubcontractDocument->constructSqlOrderByColumns($arrOrderByAttributes);

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

		foreach ($arrSubcontractDocumentIds as $k => $subcontract_document_id) {
			$subcontract_document_id = (int) $subcontract_document_id;
			$arrSubcontractDocumentIds[$k] = $db->escape($subcontract_document_id);
		}
		$csvSubcontractDocumentIds = join(',', $arrSubcontractDocumentIds);

		$query =
"
SELECT

	sd.*

FROM `subcontract_documents` sd
WHERE sd.`id` IN ($csvSubcontractDocumentIds){$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		$arrSubcontractDocumentsByCsvSubcontractDocumentIds = array();
		while ($row = $db->fetch()) {
			$subcontract_document_id = $row['id'];
			$subcontractDocument = self::instantiateOrm($database, 'SubcontractDocument', $row, null, $subcontract_document_id);
			/* @var $subcontractDocument SubcontractDocument */
			$subcontractDocument->convertPropertiesToData();

			$arrSubcontractDocumentsByCsvSubcontractDocumentIds[$subcontract_document_id] = $subcontractDocument;
		}

		$db->free_result();

		return $arrSubcontractDocumentsByCsvSubcontractDocumentIds;
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `subcontract_documents_fk_s` foreign key (`subcontract_id`) references `subcontracts` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $subcontract_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubcontractDocumentsBySubcontractId($database, $subcontract_id, Input $options=null,$filter=null)
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
			self::$_arrSubcontractDocumentsBySubcontractId = null;
		}

		$arrSubcontractDocumentsBySubcontractId = self::$_arrSubcontractDocumentsBySubcontractId;
		if (isset($arrSubcontractDocumentsBySubcontractId) && !empty($arrSubcontractDocumentsBySubcontractId)) {
			return $arrSubcontractDocumentsBySubcontractId;
		}

		$subcontract_id = (int) $subcontract_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `subcontract_id` ASC, `subcontract_item_template_id` ASC, `unsigned_subcontract_document_file_manager_file_id` ASC, `signed_subcontract_document_file_manager_file_id` ASC, `auto_generated_flag` ASC, `disabled_flag` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY sd.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubcontractDocument = new SubcontractDocument($database);
			$sqlOrderByColumns = $tmpSubcontractDocument->constructSqlOrderByColumns($arrOrderByAttributes);

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
		if($filter=='all')
		{
			$fil_doc="and sd.`subcontract_item_template_id`!='2'";
		}else if($filter=='cover')
		{
			$fil_doc="and sd.`subcontract_item_template_id`='2'";
		}else
		{
			$fil_doc="";
		}

		$query =
"
SELECT

	sd_fk_s.`id` AS 'sd_fk_s__subcontract_id',
	sd_fk_s.`gc_budget_line_item_id` AS 'sd_fk_s__gc_budget_line_item_id',
	sd_fk_s.`subcontract_sequence_number` AS 'sd_fk_s__subcontract_sequence_number',
	sd_fk_s.`subcontractor_bid_id` AS 'sd_fk_s__subcontractor_bid_id',
	sd_fk_s.`subcontract_template_id` AS 'sd_fk_s__subcontract_template_id',
	sd_fk_s.`subcontract_gc_contact_company_office_id` AS 'sd_fk_s__subcontract_gc_contact_company_office_id',
	sd_fk_s.`subcontract_gc_phone_contact_company_office_phone_number_id` AS 'sd_fk_s__subcontract_gc_phone_contact_company_office_phone_number_id',
	sd_fk_s.`subcontract_gc_fax_contact_company_office_phone_number_id` AS 'sd_fk_s__subcontract_gc_fax_contact_company_office_phone_number_id',
	sd_fk_s.`subcontract_gc_contact_id` AS 'sd_fk_s__subcontract_gc_contact_id',
	sd_fk_s.`subcontract_gc_contact_mobile_phone_number_id` AS 'sd_fk_s__subcontract_gc_contact_mobile_phone_number_id',
	sd_fk_s.`vendor_id` AS 'sd_fk_s__vendor_id',
	sd_fk_s.`subcontract_vendor_contact_company_office_id` AS 'sd_fk_s__subcontract_vendor_contact_company_office_id',
	sd_fk_s.`subcontract_vendor_phone_contact_company_office_phone_number_id` AS 'sd_fk_s__subcontract_vendor_phone_contact_company_office_phone_number_id',
	sd_fk_s.`subcontract_vendor_fax_contact_company_office_phone_number_id` AS 'sd_fk_s__subcontract_vendor_fax_contact_company_office_phone_number_id',
	sd_fk_s.`subcontract_vendor_contact_id` AS 'sd_fk_s__subcontract_vendor_contact_id',
	sd_fk_s.`subcontract_vendor_contact_mobile_phone_number_id` AS 'sd_fk_s__subcontract_vendor_contact_mobile_phone_number_id',
	sd_fk_s.`unsigned_subcontract_file_manager_file_id` AS 'sd_fk_s__unsigned_subcontract_file_manager_file_id',
	sd_fk_s.`signed_subcontract_file_manager_file_id` AS 'sd_fk_s__signed_subcontract_file_manager_file_id',
	sd_fk_s.`subcontract_forecasted_value` AS 'sd_fk_s__subcontract_forecasted_value',
	sd_fk_s.`subcontract_actual_value` AS 'sd_fk_s__subcontract_actual_value',
	sd_fk_s.`subcontract_retention_percentage` AS 'sd_fk_s__subcontract_retention_percentage',
	sd_fk_s.`subcontract_issued_date` AS 'sd_fk_s__subcontract_issued_date',
	sd_fk_s.`subcontract_target_execution_date` AS 'sd_fk_s__subcontract_target_execution_date',
	sd_fk_s.`subcontract_execution_date` AS 'sd_fk_s__subcontract_execution_date',
	sd_fk_s.`active_flag` AS 'sd_fk_s__active_flag',

	sd_fk_sit.`id` AS 'sd_fk_sit__subcontract_item_template_id',
	sd_fk_sit.`user_company_id` AS 'sd_fk_sit__user_company_id',
	sd_fk_sit.`file_manager_file_id` AS 'sd_fk_sit__file_manager_file_id',
	sd_fk_sit.`user_company_file_template_id` AS 'sd_fk_sit__user_company_file_template_id',
	sd_fk_sit.`subcontract_item` AS 'sd_fk_sit__subcontract_item',
	sd_fk_sit.`subcontract_item_abbreviation` AS 'sd_fk_sit__subcontract_item_abbreviation',
	sd_fk_sit.`subcontract_item_template_type` AS 'sd_fk_sit__subcontract_item_template_type',
	sd_fk_sit.`sort_order` AS 'sd_fk_sit__sort_order',
	sd_fk_sit.`is_trackable` AS 'sd_fk_sit__is_trackable',
	sd_fk_sit.`disabled_flag` AS 'sd_fk_sit__disabled_flag',

	sd_fk_unsigned_sd_fmfiles.`id` AS 'sd_fk_unsigned_sd_fmfiles__file_manager_file_id',
	sd_fk_unsigned_sd_fmfiles.`user_company_id` AS 'sd_fk_unsigned_sd_fmfiles__user_company_id',
	sd_fk_unsigned_sd_fmfiles.`contact_id` AS 'sd_fk_unsigned_sd_fmfiles__contact_id',
	sd_fk_unsigned_sd_fmfiles.`project_id` AS 'sd_fk_unsigned_sd_fmfiles__project_id',
	sd_fk_unsigned_sd_fmfiles.`file_manager_folder_id` AS 'sd_fk_unsigned_sd_fmfiles__file_manager_folder_id',
	sd_fk_unsigned_sd_fmfiles.`file_location_id` AS 'sd_fk_unsigned_sd_fmfiles__file_location_id',
	sd_fk_unsigned_sd_fmfiles.`virtual_file_name` AS 'sd_fk_unsigned_sd_fmfiles__virtual_file_name',
	sd_fk_unsigned_sd_fmfiles.`version_number` AS 'sd_fk_unsigned_sd_fmfiles__version_number',
	sd_fk_unsigned_sd_fmfiles.`virtual_file_name_sha1` AS 'sd_fk_unsigned_sd_fmfiles__virtual_file_name_sha1',
	sd_fk_unsigned_sd_fmfiles.`virtual_file_mime_type` AS 'sd_fk_unsigned_sd_fmfiles__virtual_file_mime_type',
	sd_fk_unsigned_sd_fmfiles.`modified` AS 'sd_fk_unsigned_sd_fmfiles__modified',
	sd_fk_unsigned_sd_fmfiles.`created` AS 'sd_fk_unsigned_sd_fmfiles__created',
	sd_fk_unsigned_sd_fmfiles.`deleted_flag` AS 'sd_fk_unsigned_sd_fmfiles__deleted_flag',
	sd_fk_unsigned_sd_fmfiles.`directly_deleted_flag` AS 'sd_fk_unsigned_sd_fmfiles__directly_deleted_flag',

	sd_fk_signed_sd_fmfiles.`id` AS 'sd_fk_signed_sd_fmfiles__file_manager_file_id',
	sd_fk_signed_sd_fmfiles.`user_company_id` AS 'sd_fk_signed_sd_fmfiles__user_company_id',
	sd_fk_signed_sd_fmfiles.`contact_id` AS 'sd_fk_signed_sd_fmfiles__contact_id',
	sd_fk_signed_sd_fmfiles.`project_id` AS 'sd_fk_signed_sd_fmfiles__project_id',
	sd_fk_signed_sd_fmfiles.`file_manager_folder_id` AS 'sd_fk_signed_sd_fmfiles__file_manager_folder_id',
	sd_fk_signed_sd_fmfiles.`file_location_id` AS 'sd_fk_signed_sd_fmfiles__file_location_id',
	sd_fk_signed_sd_fmfiles.`virtual_file_name` AS 'sd_fk_signed_sd_fmfiles__virtual_file_name',
	sd_fk_signed_sd_fmfiles.`version_number` AS 'sd_fk_signed_sd_fmfiles__version_number',
	sd_fk_signed_sd_fmfiles.`virtual_file_name_sha1` AS 'sd_fk_signed_sd_fmfiles__virtual_file_name_sha1',
	sd_fk_signed_sd_fmfiles.`virtual_file_mime_type` AS 'sd_fk_signed_sd_fmfiles__virtual_file_mime_type',
	sd_fk_signed_sd_fmfiles.`modified` AS 'sd_fk_signed_sd_fmfiles__modified',
	sd_fk_signed_sd_fmfiles.`created` AS 'sd_fk_signed_sd_fmfiles__created',
	sd_fk_signed_sd_fmfiles.`deleted_flag` AS 'sd_fk_signed_sd_fmfiles__deleted_flag',
	sd_fk_signed_sd_fmfiles.`directly_deleted_flag` AS 'sd_fk_signed_sd_fmfiles__directly_deleted_flag',

	sd.*

FROM `subcontract_documents` sd
	INNER JOIN `subcontracts` sd_fk_s ON sd.`subcontract_id` = sd_fk_s.`id`
	INNER JOIN `subcontract_item_templates` sd_fk_sit ON sd.`subcontract_item_template_id` = sd_fk_sit.`id`
	LEFT OUTER JOIN `file_manager_files` sd_fk_unsigned_sd_fmfiles ON sd.`unsigned_subcontract_document_file_manager_file_id` = sd_fk_unsigned_sd_fmfiles.`id`
	LEFT OUTER JOIN `file_manager_files` sd_fk_signed_sd_fmfiles ON sd.`signed_subcontract_document_file_manager_file_id` = sd_fk_signed_sd_fmfiles.`id`
WHERE sd.`subcontract_id` = ? {$fil_doc}{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `subcontract_id` ASC, `subcontract_item_template_id` ASC, `unsigned_subcontract_document_file_manager_file_id` ASC, `signed_subcontract_document_file_manager_file_id` ASC, `auto_generated_flag` ASC, `disabled_flag` ASC, `sort_order` ASC
		$arrValues = array($subcontract_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubcontractDocumentsBySubcontractId = array();
		while ($row = $db->fetch()) {
			$subcontract_document_id = $row['id'];
			$subcontractDocument = self::instantiateOrm($database, 'SubcontractDocument', $row, null, $subcontract_document_id);
			/* @var $subcontractDocument SubcontractDocument */
			$subcontractDocument->convertPropertiesToData();

			if (isset($row['subcontract_id'])) {
				$subcontract_id = $row['subcontract_id'];
				$row['sd_fk_s__id'] = $subcontract_id;
				$subcontract = self::instantiateOrm($database, 'Subcontract', $row, null, $subcontract_id, 'sd_fk_s__');
				/* @var $subcontract Subcontract */
				$subcontract->convertPropertiesToData();
			} else {
				$subcontract = false;
			}
			$subcontractDocument->setSubcontract($subcontract);

			if (isset($row['subcontract_item_template_id'])) {
				$subcontract_item_template_id = $row['subcontract_item_template_id'];
				$row['sd_fk_sit__id'] = $subcontract_item_template_id;
				$subcontractItemTemplate = self::instantiateOrm($database, 'SubcontractItemTemplate', $row, null, $subcontract_item_template_id, 'sd_fk_sit__');
				/* @var $subcontractItemTemplate SubcontractItemTemplate */
				$subcontractItemTemplate->convertPropertiesToData();
			} else {
				$subcontractItemTemplate = false;
			}
			$subcontractDocument->setSubcontractItemTemplate($subcontractItemTemplate);

			if (isset($row['unsigned_subcontract_document_file_manager_file_id'])) {
				$unsigned_subcontract_document_file_manager_file_id = $row['unsigned_subcontract_document_file_manager_file_id'];
				$row['sd_fk_unsigned_sd_fmfiles__id'] = $unsigned_subcontract_document_file_manager_file_id;
				$unsignedSubcontractDocumentFileManagerFile = self::instantiateOrm($database, 'FileManagerFile', $row, null, $unsigned_subcontract_document_file_manager_file_id, 'sd_fk_unsigned_sd_fmfiles__');
				/* @var $unsignedSubcontractDocumentFileManagerFile FileManagerFile */
				$unsignedSubcontractDocumentFileManagerFile->convertPropertiesToData();
			} else {
				$unsignedSubcontractDocumentFileManagerFile = false;
			}
			$subcontractDocument->setUnsignedSubcontractDocumentFileManagerFile($unsignedSubcontractDocumentFileManagerFile);

			if (isset($row['signed_subcontract_document_file_manager_file_id'])) {
				$signed_subcontract_document_file_manager_file_id = $row['signed_subcontract_document_file_manager_file_id'];
				$row['sd_fk_signed_sd_fmfiles__id'] = $signed_subcontract_document_file_manager_file_id;
				$signedSubcontractDocumentFileManagerFile = self::instantiateOrm($database, 'FileManagerFile', $row, null, $signed_subcontract_document_file_manager_file_id, 'sd_fk_signed_sd_fmfiles__');
				/* @var $signedSubcontractDocumentFileManagerFile FileManagerFile */
				$signedSubcontractDocumentFileManagerFile->convertPropertiesToData();
			} else {
				$signedSubcontractDocumentFileManagerFile = false;
			}
			$subcontractDocument->setSignedSubcontractDocumentFileManagerFile($signedSubcontractDocumentFileManagerFile);

			$arrSubcontractDocumentsBySubcontractId[$subcontract_document_id] = $subcontractDocument;
		}

		$db->free_result();

		self::$_arrSubcontractDocumentsBySubcontractId = $arrSubcontractDocumentsBySubcontractId;

		return $arrSubcontractDocumentsBySubcontractId;
	}

	/**
	 * Load by constraint `subcontract_documents_fk_sit` foreign key (`subcontract_item_template_id`) references `subcontract_item_templates` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $subcontract_item_template_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubcontractDocumentsBySubcontractItemTemplateId($database, $subcontract_item_template_id, Input $options=null)
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
			self::$_arrSubcontractDocumentsBySubcontractItemTemplateId = null;
		}

		$arrSubcontractDocumentsBySubcontractItemTemplateId = self::$_arrSubcontractDocumentsBySubcontractItemTemplateId;
		if (isset($arrSubcontractDocumentsBySubcontractItemTemplateId) && !empty($arrSubcontractDocumentsBySubcontractItemTemplateId)) {
			return $arrSubcontractDocumentsBySubcontractItemTemplateId;
		}

		$subcontract_item_template_id = (int) $subcontract_item_template_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `subcontract_id` ASC, `subcontract_item_template_id` ASC, `unsigned_subcontract_document_file_manager_file_id` ASC, `signed_subcontract_document_file_manager_file_id` ASC, `auto_generated_flag` ASC, `disabled_flag` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY sd.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubcontractDocument = new SubcontractDocument($database);
			$sqlOrderByColumns = $tmpSubcontractDocument->constructSqlOrderByColumns($arrOrderByAttributes);

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
	sd.*

FROM `subcontract_documents` sd
WHERE sd.`subcontract_item_template_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `subcontract_id` ASC, `subcontract_item_template_id` ASC, `unsigned_subcontract_document_file_manager_file_id` ASC, `signed_subcontract_document_file_manager_file_id` ASC, `auto_generated_flag` ASC, `disabled_flag` ASC, `sort_order` ASC
		$arrValues = array($subcontract_item_template_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubcontractDocumentsBySubcontractItemTemplateId = array();
		while ($row = $db->fetch()) {
			$subcontract_document_id = $row['id'];
			$subcontractDocument = self::instantiateOrm($database, 'SubcontractDocument', $row, null, $subcontract_document_id);
			/* @var $subcontractDocument SubcontractDocument */
			$arrSubcontractDocumentsBySubcontractItemTemplateId[$subcontract_document_id] = $subcontractDocument;
		}

		$db->free_result();

		self::$_arrSubcontractDocumentsBySubcontractItemTemplateId = $arrSubcontractDocumentsBySubcontractItemTemplateId;

		return $arrSubcontractDocumentsBySubcontractItemTemplateId;
	}

	/**
	 * Load by constraint `subcontract_documents_fk_unsigned_sd_fmfiles` foreign key (`unsigned_subcontract_document_file_manager_file_id`) references `file_manager_files` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $unsigned_subcontract_document_file_manager_file_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubcontractDocumentsByUnsignedSubcontractDocumentFileManagerFileId($database, $unsigned_subcontract_document_file_manager_file_id, Input $options=null)
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
			self::$_arrSubcontractDocumentsByUnsignedSubcontractDocumentFileManagerFileId = null;
		}

		$arrSubcontractDocumentsByUnsignedSubcontractDocumentFileManagerFileId = self::$_arrSubcontractDocumentsByUnsignedSubcontractDocumentFileManagerFileId;
		if (isset($arrSubcontractDocumentsByUnsignedSubcontractDocumentFileManagerFileId) && !empty($arrSubcontractDocumentsByUnsignedSubcontractDocumentFileManagerFileId)) {
			return $arrSubcontractDocumentsByUnsignedSubcontractDocumentFileManagerFileId;
		}

		$unsigned_subcontract_document_file_manager_file_id = (int) $unsigned_subcontract_document_file_manager_file_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `subcontract_id` ASC, `subcontract_item_template_id` ASC, `unsigned_subcontract_document_file_manager_file_id` ASC, `signed_subcontract_document_file_manager_file_id` ASC, `auto_generated_flag` ASC, `disabled_flag` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY sd.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubcontractDocument = new SubcontractDocument($database);
			$sqlOrderByColumns = $tmpSubcontractDocument->constructSqlOrderByColumns($arrOrderByAttributes);

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
	sd.*

FROM `subcontract_documents` sd
WHERE sd.`unsigned_subcontract_document_file_manager_file_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `subcontract_id` ASC, `subcontract_item_template_id` ASC, `unsigned_subcontract_document_file_manager_file_id` ASC, `signed_subcontract_document_file_manager_file_id` ASC, `auto_generated_flag` ASC, `disabled_flag` ASC, `sort_order` ASC
		$arrValues = array($unsigned_subcontract_document_file_manager_file_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubcontractDocumentsByUnsignedSubcontractDocumentFileManagerFileId = array();
		while ($row = $db->fetch()) {
			$subcontract_document_id = $row['id'];
			$subcontractDocument = self::instantiateOrm($database, 'SubcontractDocument', $row, null, $subcontract_document_id);
			/* @var $subcontractDocument SubcontractDocument */
			$arrSubcontractDocumentsByUnsignedSubcontractDocumentFileManagerFileId[$subcontract_document_id] = $subcontractDocument;
		}

		$db->free_result();

		self::$_arrSubcontractDocumentsByUnsignedSubcontractDocumentFileManagerFileId = $arrSubcontractDocumentsByUnsignedSubcontractDocumentFileManagerFileId;

		return $arrSubcontractDocumentsByUnsignedSubcontractDocumentFileManagerFileId;
	}

	/**
	 * Load by constraint `subcontract_documents_fk_signed_sd_fmfiles` foreign key (`signed_subcontract_document_file_manager_file_id`) references `file_manager_files` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $signed_subcontract_document_file_manager_file_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubcontractDocumentsBySignedSubcontractDocumentFileManagerFileId($database, $signed_subcontract_document_file_manager_file_id, Input $options=null)
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
			self::$_arrSubcontractDocumentsBySignedSubcontractDocumentFileManagerFileId = null;
		}

		$arrSubcontractDocumentsBySignedSubcontractDocumentFileManagerFileId = self::$_arrSubcontractDocumentsBySignedSubcontractDocumentFileManagerFileId;
		if (isset($arrSubcontractDocumentsBySignedSubcontractDocumentFileManagerFileId) && !empty($arrSubcontractDocumentsBySignedSubcontractDocumentFileManagerFileId)) {
			return $arrSubcontractDocumentsBySignedSubcontractDocumentFileManagerFileId;
		}

		$signed_subcontract_document_file_manager_file_id = (int) $signed_subcontract_document_file_manager_file_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `subcontract_id` ASC, `subcontract_item_template_id` ASC, `unsigned_subcontract_document_file_manager_file_id` ASC, `signed_subcontract_document_file_manager_file_id` ASC, `auto_generated_flag` ASC, `disabled_flag` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY sd.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubcontractDocument = new SubcontractDocument($database);
			$sqlOrderByColumns = $tmpSubcontractDocument->constructSqlOrderByColumns($arrOrderByAttributes);

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
	sd.*

FROM `subcontract_documents` sd
WHERE sd.`signed_subcontract_document_file_manager_file_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `subcontract_id` ASC, `subcontract_item_template_id` ASC, `unsigned_subcontract_document_file_manager_file_id` ASC, `signed_subcontract_document_file_manager_file_id` ASC, `auto_generated_flag` ASC, `disabled_flag` ASC, `sort_order` ASC
		$arrValues = array($signed_subcontract_document_file_manager_file_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubcontractDocumentsBySignedSubcontractDocumentFileManagerFileId = array();
		while ($row = $db->fetch()) {
			$subcontract_document_id = $row['id'];
			$subcontractDocument = self::instantiateOrm($database, 'SubcontractDocument', $row, null, $subcontract_document_id);
			/* @var $subcontractDocument SubcontractDocument */
			$arrSubcontractDocumentsBySignedSubcontractDocumentFileManagerFileId[$subcontract_document_id] = $subcontractDocument;
		}

		$db->free_result();

		self::$_arrSubcontractDocumentsBySignedSubcontractDocumentFileManagerFileId = $arrSubcontractDocumentsBySignedSubcontractDocumentFileManagerFileId;

		return $arrSubcontractDocumentsBySignedSubcontractDocumentFileManagerFileId;
	}

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all subcontract_documents records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllSubcontractDocuments($database, Input $options=null)
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
			self::$_arrAllSubcontractDocuments = null;
		}

		$arrAllSubcontractDocuments = self::$_arrAllSubcontractDocuments;
		if (isset($arrAllSubcontractDocuments) && !empty($arrAllSubcontractDocuments)) {
			return $arrAllSubcontractDocuments;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `subcontract_id` ASC, `subcontract_item_template_id` ASC, `unsigned_subcontract_document_file_manager_file_id` ASC, `signed_subcontract_document_file_manager_file_id` ASC, `auto_generated_flag` ASC, `disabled_flag` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY sd.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubcontractDocument = new SubcontractDocument($database);
			$sqlOrderByColumns = $tmpSubcontractDocument->constructSqlOrderByColumns($arrOrderByAttributes);

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
	sd.*

FROM `subcontract_documents` sd{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `subcontract_id` ASC, `subcontract_item_template_id` ASC, `unsigned_subcontract_document_file_manager_file_id` ASC, `signed_subcontract_document_file_manager_file_id` ASC, `auto_generated_flag` ASC, `disabled_flag` ASC, `sort_order` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllSubcontractDocuments = array();
		while ($row = $db->fetch()) {
			$subcontract_document_id = $row['id'];
			$subcontractDocument = self::instantiateOrm($database, 'SubcontractDocument', $row, null, $subcontract_document_id);
			/* @var $subcontractDocument SubcontractDocument */
			$arrAllSubcontractDocuments[$subcontract_document_id] = $subcontractDocument;
		}

		$db->free_result();

		self::$_arrAllSubcontractDocuments = $arrAllSubcontractDocuments;

		return $arrAllSubcontractDocuments;
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
INTO `subcontract_documents`
(`subcontract_id`, `subcontract_item_template_id`, `unsigned_subcontract_document_file_manager_file_id`, `signed_subcontract_document_file_manager_file_id`,`gc_signatory`,`vendor_signatory`, `auto_generated_flag`, `disabled_flag`, `sort_order`)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
ON DUPLICATE KEY UPDATE `unsigned_subcontract_document_file_manager_file_id` = ?, `signed_subcontract_document_file_manager_file_id` = ?, `auto_generated_flag` = ?, `disabled_flag` = ?, `sort_order` = ?
";
		$arrValues = array($this->subcontract_id, $this->subcontract_item_template_id, $this->unsigned_subcontract_document_file_manager_file_id, $this->signed_subcontract_document_file_manager_file_id,$this->gc_signatory,$this->vendor_signatory, $this->auto_generated_flag, $this->disabled_flag, $this->sort_order, $this->unsigned_subcontract_document_file_manager_file_id, $this->signed_subcontract_document_file_manager_file_id, $this->auto_generated_flag, $this->disabled_flag, $this->sort_order);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$subcontract_document_id = $db->insertId;
		$db->free_result();

		return $subcontract_document_id;
	}

	// Save: insert ignore

	/**
	 * @param string $database
	 * @param int $subcontract_id
	 * @return mixed (single ORM object | false)
	 */
	public static function loadSubcontractDocumentSortOrdersBySubcontractId($database, $subcontract_id, Input $options=null)
	{
		/*
		if ($forceLoadFlag) {
			self::$_arrSubcontractDocumentsBySubcontractId = null;
		}

		$arrSubcontractDocumentsBySubcontractId = self::$_arrSubcontractDocumentsBySubcontractId;
		if (isset($arrSubcontractDocumentsBySubcontractId) && !empty($arrSubcontractDocumentsBySubcontractId)) {
			return $arrSubcontractDocumentsBySubcontractId;
		}
		*/

		$subcontract_id = (int) $subcontract_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */
		$query =
"
SELECT
	sd.*,
	sd.`id` as subcontract_document_id
FROM `subcontract_documents` sd

WHERE sd.`subcontract_id` = ?
ORDER BY sd.`sort_order`
";
// LIMIT 10
// ORDER BY `id` ASC, `subcontract_id` ASC, `subcontract_item_template_id` ASC, `unsigned_subcontract_document_file_manager_file_id` ASC, `signed_subcontract_document_file_manager_file_id` ASC, `auto_generated_flag` ASC, `disabled_flag` ASC, `sort_order` ASC
		$arrValues = array($subcontract_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubcontractDocumentsBySubcontractId = array();
		while ($row = $db->fetch()) {
			unset($row['id']);

			$subcontract_document_id = $row['subcontract_document_id'];
			$sort_order = $row['sort_order'];

			$row['id'] = $subcontract_document_id;
			$subcontractDocument = self::instantiateOrm($database, 'SubcontractDocument', $row, null, $subcontract_document_id);
			$subcontractDocument->convertPropertiesToData();

			$arrSubcontractDocumentsBySubcontractId[$subcontract_document_id] = $subcontractDocument;
		}

		$db->free_result();

		//self::$_arrSubcontractDocumentsBySubcontractId = $arrSubcontractDocumentsBySubcontractId;

		return $arrSubcontractDocumentsBySubcontractId;
	}

	public static function setNaturalSortOrderOnSubcontractDocumentsBySubcontractId($database, $subcontract_id, $original_subcontract_document_id)
	{
		$subcontract_id = (int) $subcontract_id;
		$original_subcontract_document_id = (int) $original_subcontract_document_id;

		// Set natural sort order on all records first
		$arrSubcontractDocuments = SubcontractDocument::loadSubcontractDocumentSortOrdersBySubcontractId($database, $subcontract_id, true);
		$i = 0;
		foreach ($arrSubcontractDocuments as $subcontract_document_id => $subcontractDocument) {
			/* @var $subcontractDocument SubcontractDocument */

			$sort_order = $subcontractDocument->sort_order;
			if ($sort_order != $i) {
				$data = array('sort_order' => $i);
				$subcontractDocument->setData($data);
				$subcontractDocument->save();
			}

			// Get the original sort_order value after updating to sane values
			if ($subcontractDocument->subcontract_document_id == $original_subcontract_document_id) {
				$original_sort_order = $i;
			}

			$i++;
		}

		return $original_sort_order;
	}

	public static function checkEsignApply($database,$subcontract_id,$subcontract_item_template_id,$field)
	{
		$db = DBI::getInstance($database);
		$query1="SELECT $field from subcontract_documents WHERE subcontract_id = ? and subcontract_item_template_id = ? ";
        $arrValues = array($subcontract_id, $subcontract_item_template_id);
       	$db->execute($query1, $arrValues, MYSQLI_USE_RESULT);
       	$row = $db->fetch();
       	$esignField = $row[$field];
        $db->free_result();
        return $esignField;
	}

	public static function UpdatesignatorySubcontractDocument($database,$subcontract_id,$subcontract_item_template_id,$field,$colvalue)
	{
		$db = DBI::getInstance($database);
		$query1="SELECT id from subcontract_documents WHERE subcontract_id = ? and subcontract_item_template_id = ? ";
        $arrValues = array($subcontract_id, $subcontract_item_template_id);
       	$db->execute($query1, $arrValues, MYSQLI_USE_RESULT);
       	$row = $db->fetch();
       	$subcontract_document_id = $row['id'];
        $db->free_result();


		$query="UPDATE subcontract_documents SET $field=? WHERE id= ? ";
        $arrValues = array($colvalue, $subcontract_document_id);
       	$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
        $db->free_result();
	}

	public static function SubcontractDocumentcoverId($database,$subcontract_id,$subcontract_item_template_id)
	{
		$db = DBI::getInstance($database);
		$query1="SELECT id from subcontract_documents WHERE subcontract_id = ? and subcontract_item_template_id = ? ";
        $arrValues = array($subcontract_id, $subcontract_item_template_id);
       	$db->execute($query1, $arrValues, MYSQLI_USE_RESULT);
       	$row = $db->fetch();
       	$subcontract_document_id = $row['id'];
        $db->free_result();
        return $subcontract_document_id;
    }

	public function updateSortOrder($database, $new_sort_order)
	{
		$subcontract_id = $this->subcontract_id;
		$new_sort_order = (int) $new_sort_order;

		// @todo Conditionally update sort_order based on table meta-data
		$original_sort_order = SubcontractDocument::setNaturalSortOrderOnSubcontractDocumentsBySubcontractId($database, $subcontract_id, $this->subcontract_document_id);

		if ($new_sort_order > $original_sort_order) {
			$movedDown = true;
			$movedUp = false;
		} elseif ($new_sort_order < $original_sort_order) {
			$movedDown = false;
			$movedUp = true;
		} else {
			// Same sort_order
			// Default to Moved Down
			$movedDown = true;
			$movedUp = false;
		}

		$db = $this->getDb($database);
		/* @var $db DBI_mysqli */

		$db->begin();
		if ($movedDown) {
			$query =
"
UPDATE `subcontract_documents`
SET `sort_order` = (`sort_order`-1)
WHERE `subcontract_id` = ?
AND `sort_order` > ?
AND `sort_order` <= ?
";
			$arrValues = array($subcontract_id, $original_sort_order, $new_sort_order);
			$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
			$db->free_result();
		} elseif ($movedUp) {
			$query =
"
UPDATE `subcontract_documents`
SET `sort_order` = (`sort_order`+1)
WHERE `subcontract_id` = ?
AND `sort_order` < ?
AND `sort_order` >= ?
";
			$arrValues = array($subcontract_id, $original_sort_order, $new_sort_order);
			$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
			$db->free_result();
		}

		$db->commit();
	}
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

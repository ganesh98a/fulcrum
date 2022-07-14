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
 * SubcontractorBidDocument.
 *
 * @category   Framework
 * @package    SubcontractorBidDocument
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class SubcontractorBidDocument extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'SubcontractorBidDocument';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'subcontractor_bid_documents';

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
	 * unique index `unique_subcontractor_bid_document` (`subcontractor_bid_id`,`subcontractor_bid_document_type_id`,`subcontractor_bid_document_sequence_number`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_subcontractor_bid_document' => array(
			'subcontractor_bid_id' => 'int',
			'subcontractor_bid_document_type_id' => 'int',
			'subcontractor_bid_document_sequence_number' => 'int'
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
		'id' => 'subcontractor_bid_document_id',

		'subcontractor_bid_id' => 'subcontractor_bid_id',
		'subcontractor_bid_document_type_id' => 'subcontractor_bid_document_type_id',
		'subcontractor_bid_document_sequence_number' => 'subcontractor_bid_document_sequence_number',

		'subcontractor_bid_document_file_manager_file_id' => 'subcontractor_bid_document_file_manager_file_id',

		'subcontractor_bid_document_file_sha1' => 'subcontractor_bid_document_file_sha1',
		'created' => 'created',
		'sort_order' => 'sort_order'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $subcontractor_bid_document_id;

	public $subcontractor_bid_id;
	public $subcontractor_bid_document_type_id;
	public $subcontractor_bid_document_sequence_number;

	public $subcontractor_bid_document_file_manager_file_id;

	public $subcontractor_bid_document_file_sha1;
	public $created;
	public $sort_order;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties
	public $escaped_subcontractor_bid_document_file_sha1;

	// HTML ENTITY ENCODED NL2BR ORM string properties
	public $escaped_subcontractor_bid_document_file_sha1_nl2br;

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)
	protected static $_arrSubcontractorBidDocumentsBySubcontractorBidId;
	protected static $_arrSubcontractorBidDocumentsBySubcontractorBidDocumentTypeId;
	protected static $_arrSubcontractorBidDocumentsBySubcontractorBidDocumentFileManagerFileId;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)
	protected static $_arrSubcontractorBidDocumentsBySubcontractorBidDocumentFileSha1;

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllSubcontractorBidDocuments;

	// Foreign Key Objects
	private $_subcontractorBid;
	private $_subcontractorBidDocumentType;
	private $_subcontractorBidDocumentFileManagerFile;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='subcontractor_bid_documents')
	{
		parent::__construct($table);
		$this->setDatabase($database);
	}

	// Foreign Key Object Accessor Methods
	public function getSubcontractorBid()
	{
		if (isset($this->_subcontractorBid)) {
			return $this->_subcontractorBid;
		} else {
			return null;
		}
	}

	public function setSubcontractorBid($subcontractorBid)
	{
		$this->_subcontractorBid = $subcontractorBid;
	}

	public function getSubcontractorBidDocumentType()
	{
		if (isset($this->_subcontractorBidDocumentType)) {
			return $this->_subcontractorBidDocumentType;
		} else {
			return null;
		}
	}

	public function setSubcontractorBidDocumentType($subcontractorBidDocumentType)
	{
		$this->_subcontractorBidDocumentType = $subcontractorBidDocumentType;
	}

	public function getSubcontractorBidDocumentFileManagerFile()
	{
		if (isset($this->_subcontractorBidDocumentFileManagerFile)) {
			return $this->_subcontractorBidDocumentFileManagerFile;
		} else {
			return null;
		}
	}

	public function setSubcontractorBidDocumentFileManagerFile($subcontractorBidDocumentFileManagerFile)
	{
		$this->_subcontractorBidDocumentFileManagerFile = $subcontractorBidDocumentFileManagerFile;
	}

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)
	public static function getArrSubcontractorBidDocumentsBySubcontractorBidId()
	{
		if (isset(self::$_arrSubcontractorBidDocumentsBySubcontractorBidId)) {
			return self::$_arrSubcontractorBidDocumentsBySubcontractorBidId;
		} else {
			return null;
		}
	}

	public static function setArrSubcontractorBidDocumentsBySubcontractorBidId($arrSubcontractorBidDocumentsBySubcontractorBidId)
	{
		self::$_arrSubcontractorBidDocumentsBySubcontractorBidId = $arrSubcontractorBidDocumentsBySubcontractorBidId;
	}

	public static function getArrSubcontractorBidDocumentsBySubcontractorBidDocumentTypeId()
	{
		if (isset(self::$_arrSubcontractorBidDocumentsBySubcontractorBidDocumentTypeId)) {
			return self::$_arrSubcontractorBidDocumentsBySubcontractorBidDocumentTypeId;
		} else {
			return null;
		}
	}

	public static function setArrSubcontractorBidDocumentsBySubcontractorBidDocumentTypeId($arrSubcontractorBidDocumentsBySubcontractorBidDocumentTypeId)
	{
		self::$_arrSubcontractorBidDocumentsBySubcontractorBidDocumentTypeId = $arrSubcontractorBidDocumentsBySubcontractorBidDocumentTypeId;
	}

	public static function getArrSubcontractorBidDocumentsBySubcontractorBidDocumentFileManagerFileId()
	{
		if (isset(self::$_arrSubcontractorBidDocumentsBySubcontractorBidDocumentFileManagerFileId)) {
			return self::$_arrSubcontractorBidDocumentsBySubcontractorBidDocumentFileManagerFileId;
		} else {
			return null;
		}
	}

	public static function setArrSubcontractorBidDocumentsBySubcontractorBidDocumentFileManagerFileId($arrSubcontractorBidDocumentsBySubcontractorBidDocumentFileManagerFileId)
	{
		self::$_arrSubcontractorBidDocumentsBySubcontractorBidDocumentFileManagerFileId = $arrSubcontractorBidDocumentsBySubcontractorBidDocumentFileManagerFileId;
	}

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)
	public static function getArrSubcontractorBidDocumentsBySubcontractorBidDocumentFileSha1()
	{
		if (isset(self::$_arrSubcontractorBidDocumentsBySubcontractorBidDocumentFileSha1)) {
			return self::$_arrSubcontractorBidDocumentsBySubcontractorBidDocumentFileSha1;
		} else {
			return null;
		}
	}

	public static function setArrSubcontractorBidDocumentsBySubcontractorBidDocumentFileSha1($arrSubcontractorBidDocumentsBySubcontractorBidDocumentFileSha1)
	{
		self::$_arrSubcontractorBidDocumentsBySubcontractorBidDocumentFileSha1 = $arrSubcontractorBidDocumentsBySubcontractorBidDocumentFileSha1;
	}

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllSubcontractorBidDocuments()
	{
		if (isset(self::$_arrAllSubcontractorBidDocuments)) {
			return self::$_arrAllSubcontractorBidDocuments;
		} else {
			return null;
		}
	}

	public static function setArrAllSubcontractorBidDocuments($arrAllSubcontractorBidDocuments)
	{
		self::$_arrAllSubcontractorBidDocuments = $arrAllSubcontractorBidDocuments;
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
	 * @param int $subcontractor_bid_document_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findById($database, $subcontractor_bid_document_id,$table='subcontractor_bid_documents', $module='SubcontractorBidDocument')
	{
		$subcontractorBidDocument = parent::findById($database, $subcontractor_bid_document_id, $table, $module);

		return $subcontractorBidDocument;
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Similar to FindById, but with SQL as starter code for more complex joins.
	 *
	 * @param string $database
	 * @param int $subcontractor_bid_document_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findSubcontractorBidDocumentByIdExtended($database, $subcontractor_bid_document_id)
	{
		$subcontractor_bid_document_id = (int) $subcontractor_bid_document_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	sbd_fk_sb.`id` AS 'sbd_fk_sb__subcontractor_bid_id',
	sbd_fk_sb.`gc_budget_line_item_id` AS 'sbd_fk_sb__gc_budget_line_item_id',
	sbd_fk_sb.`subcontractor_contact_id` AS 'sbd_fk_sb__subcontractor_contact_id',
	sbd_fk_sb.`subcontractor_bid_status_id` AS 'sbd_fk_sb__subcontractor_bid_status_id',
	sbd_fk_sb.`sort_order` AS 'sbd_fk_sb__sort_order',

	sbd_fk_sbdt.`id` AS 'sbd_fk_sbdt__subcontractor_bid_document_type_id',
	sbd_fk_sbdt.`subcontractor_bid_document_type` AS 'sbd_fk_sbdt__subcontractor_bid_document_type',
	sbd_fk_sbdt.`subcontractor_bid_document_type_abbreviation` AS 'sbd_fk_sbdt__subcontractor_bid_document_type_abbreviation',
	sbd_fk_sbdt.`created` AS 'sbd_fk_sbdt__created',
	sbd_fk_sbdt.`sort_order` AS 'sbd_fk_sbdt__sort_order',

	sbd_fk_fmfiles.`id` AS 'sbd_fk_fmfiles__file_manager_file_id',
	sbd_fk_fmfiles.`user_company_id` AS 'sbd_fk_fmfiles__user_company_id',
	sbd_fk_fmfiles.`contact_id` AS 'sbd_fk_fmfiles__contact_id',
	sbd_fk_fmfiles.`project_id` AS 'sbd_fk_fmfiles__project_id',
	sbd_fk_fmfiles.`file_manager_folder_id` AS 'sbd_fk_fmfiles__file_manager_folder_id',
	sbd_fk_fmfiles.`file_location_id` AS 'sbd_fk_fmfiles__file_location_id',
	sbd_fk_fmfiles.`virtual_file_name` AS 'sbd_fk_fmfiles__virtual_file_name',
	sbd_fk_fmfiles.`version_number` AS 'sbd_fk_fmfiles__version_number',
	sbd_fk_fmfiles.`virtual_file_name_sha1` AS 'sbd_fk_fmfiles__virtual_file_name_sha1',
	sbd_fk_fmfiles.`virtual_file_mime_type` AS 'sbd_fk_fmfiles__virtual_file_mime_type',
	sbd_fk_fmfiles.`modified` AS 'sbd_fk_fmfiles__modified',
	sbd_fk_fmfiles.`created` AS 'sbd_fk_fmfiles__created',
	sbd_fk_fmfiles.`deleted_flag` AS 'sbd_fk_fmfiles__deleted_flag',
	sbd_fk_fmfiles.`directly_deleted_flag` AS 'sbd_fk_fmfiles__directly_deleted_flag',

	sbd.*

FROM `subcontractor_bid_documents` sbd
	INNER JOIN `subcontractor_bids` sbd_fk_sb ON sbd.`subcontractor_bid_id` = sbd_fk_sb.`id`
	INNER JOIN `subcontractor_bid_document_types` sbd_fk_sbdt ON sbd.`subcontractor_bid_document_type_id` = sbd_fk_sbdt.`id`
	LEFT OUTER JOIN `file_manager_files` sbd_fk_fmfiles ON sbd.`subcontractor_bid_document_file_manager_file_id` = sbd_fk_fmfiles.`id`
WHERE sbd.`id` = ?
";
		$arrValues = array($subcontractor_bid_document_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$subcontractor_bid_document_id = $row['id'];
			$subcontractorBidDocument = self::instantiateOrm($database, 'SubcontractorBidDocument', $row, null, $subcontractor_bid_document_id);
			/* @var $subcontractorBidDocument SubcontractorBidDocument */
			$subcontractorBidDocument->convertPropertiesToData();

			if (isset($row['subcontractor_bid_id'])) {
				$subcontractor_bid_id = $row['subcontractor_bid_id'];
				$row['sbd_fk_sb__id'] = $subcontractor_bid_id;
				$subcontractorBid = self::instantiateOrm($database, 'SubcontractorBid', $row, null, $subcontractor_bid_id, 'sbd_fk_sb__');
				/* @var $subcontractorBid SubcontractorBid */
				$subcontractorBid->convertPropertiesToData();
			} else {
				$subcontractorBid = false;
			}
			$subcontractorBidDocument->setSubcontractorBid($subcontractorBid);

			if (isset($row['subcontractor_bid_document_type_id'])) {
				$subcontractor_bid_document_type_id = $row['subcontractor_bid_document_type_id'];
				$row['sbd_fk_sbdt__id'] = $subcontractor_bid_document_type_id;
				$subcontractorBidDocumentType = self::instantiateOrm($database, 'SubcontractorBidDocumentType', $row, null, $subcontractor_bid_document_type_id, 'sbd_fk_sbdt__');
				/* @var $subcontractorBidDocumentType SubcontractorBidDocumentType */
				$subcontractorBidDocumentType->convertPropertiesToData();
			} else {
				$subcontractorBidDocumentType = false;
			}
			$subcontractorBidDocument->setSubcontractorBidDocumentType($subcontractorBidDocumentType);

			if (isset($row['subcontractor_bid_document_file_manager_file_id'])) {
				$subcontractor_bid_document_file_manager_file_id = $row['subcontractor_bid_document_file_manager_file_id'];
				$row['sbd_fk_fmfiles__id'] = $subcontractor_bid_document_file_manager_file_id;
				$subcontractorBidDocumentFileManagerFile = self::instantiateOrm($database, 'FileManagerFile', $row, null, $subcontractor_bid_document_file_manager_file_id, 'sbd_fk_fmfiles__');
				/* @var $subcontractorBidDocumentFileManagerFile FileManagerFile */
				$subcontractorBidDocumentFileManagerFile->convertPropertiesToData();
			} else {
				$subcontractorBidDocumentFileManagerFile = false;
			}
			$subcontractorBidDocument->setSubcontractorBidDocumentFileManagerFile($subcontractorBidDocumentFileManagerFile);

			return $subcontractorBidDocument;
		} else {
			return false;
		}
	}

	// Finders: Find By Unique Index
	/**
	 * Find by unique index `unique_subcontractor_bid_document` (`subcontractor_bid_id`,`subcontractor_bid_document_type_id`,`subcontractor_bid_document_sequence_number`).
	 *
	 * @param string $database
	 * @param int $subcontractor_bid_id
	 * @param int $subcontractor_bid_document_type_id
	 * @param int $subcontractor_bid_document_sequence_number
	 * @return mixed (single ORM object | false)
	 */
	public static function findBySubcontractorBidIdAndSubcontractorBidDocumentTypeIdAndSubcontractorBidDocumentSequenceNumber($database, $subcontractor_bid_id, $subcontractor_bid_document_type_id, $subcontractor_bid_document_sequence_number)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	sbd.*

FROM `subcontractor_bid_documents` sbd
WHERE sbd.`subcontractor_bid_id` = ?
AND sbd.`subcontractor_bid_document_type_id` = ?
AND sbd.`subcontractor_bid_document_sequence_number` = ?
";
		$arrValues = array($subcontractor_bid_id, $subcontractor_bid_document_type_id, $subcontractor_bid_document_sequence_number);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if ($row && !empty($row)) {
			$subcontractor_bid_document_id = $row['id'];
			$subcontractorBidDocument = self::instantiateOrm($database, 'SubcontractorBidDocument', $row, null, $subcontractor_bid_document_id);
			/* @var $subcontractorBidDocument SubcontractorBidDocument */
			return $subcontractorBidDocument;
		} else {
			return false;
		}
	}

	// Loaders: Load By pk List (list of auto int ids or other non auto int pk list)
	/**
	 * Load zero or more records by an id list (array of auto int primary keys).
	 *
	 * @param string $database
	 * @param array $arrSubcontractorBidDocumentIds
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubcontractorBidDocumentsByArrSubcontractorBidDocumentIds($database, $arrSubcontractorBidDocumentIds, Input $options=null)
	{
		if (empty($arrSubcontractorBidDocumentIds)) {
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
		// ORDER BY `id` ASC, `subcontractor_bid_id` ASC, `subcontractor_bid_document_type_id` ASC, `subcontractor_bid_document_sequence_number` ASC, `subcontractor_bid_document_file_manager_file_id` ASC, `subcontractor_bid_document_file_sha1` ASC, `created` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY sbd.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubcontractorBidDocument = new SubcontractorBidDocument($database);
			$sqlOrderByColumns = $tmpSubcontractorBidDocument->constructSqlOrderByColumns($arrOrderByAttributes);

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

		foreach ($arrSubcontractorBidDocumentIds as $k => $subcontractor_bid_document_id) {
			$subcontractor_bid_document_id = (int) $subcontractor_bid_document_id;
			$arrSubcontractorBidDocumentIds[$k] = $db->escape($subcontractor_bid_document_id);
		}
		$csvSubcontractorBidDocumentIds = join(',', $arrSubcontractorBidDocumentIds);

		$query =
"
SELECT

	sbd_fk_sb.`id` AS 'sbd_fk_sb__subcontractor_bid_id',
	sbd_fk_sb.`gc_budget_line_item_id` AS 'sbd_fk_sb__gc_budget_line_item_id',
	sbd_fk_sb.`subcontractor_contact_id` AS 'sbd_fk_sb__subcontractor_contact_id',
	sbd_fk_sb.`subcontractor_bid_status_id` AS 'sbd_fk_sb__subcontractor_bid_status_id',
	sbd_fk_sb.`sort_order` AS 'sbd_fk_sb__sort_order',

	sbd_fk_sbdt.`id` AS 'sbd_fk_sbdt__subcontractor_bid_document_type_id',
	sbd_fk_sbdt.`subcontractor_bid_document_type` AS 'sbd_fk_sbdt__subcontractor_bid_document_type',
	sbd_fk_sbdt.`subcontractor_bid_document_type_abbreviation` AS 'sbd_fk_sbdt__subcontractor_bid_document_type_abbreviation',
	sbd_fk_sbdt.`created` AS 'sbd_fk_sbdt__created',
	sbd_fk_sbdt.`sort_order` AS 'sbd_fk_sbdt__sort_order',

	sbd_fk_fmfiles.`id` AS 'sbd_fk_fmfiles__file_manager_file_id',
	sbd_fk_fmfiles.`user_company_id` AS 'sbd_fk_fmfiles__user_company_id',
	sbd_fk_fmfiles.`contact_id` AS 'sbd_fk_fmfiles__contact_id',
	sbd_fk_fmfiles.`project_id` AS 'sbd_fk_fmfiles__project_id',
	sbd_fk_fmfiles.`file_manager_folder_id` AS 'sbd_fk_fmfiles__file_manager_folder_id',
	sbd_fk_fmfiles.`file_location_id` AS 'sbd_fk_fmfiles__file_location_id',
	sbd_fk_fmfiles.`virtual_file_name` AS 'sbd_fk_fmfiles__virtual_file_name',
	sbd_fk_fmfiles.`version_number` AS 'sbd_fk_fmfiles__version_number',
	sbd_fk_fmfiles.`virtual_file_name_sha1` AS 'sbd_fk_fmfiles__virtual_file_name_sha1',
	sbd_fk_fmfiles.`virtual_file_mime_type` AS 'sbd_fk_fmfiles__virtual_file_mime_type',
	sbd_fk_fmfiles.`modified` AS 'sbd_fk_fmfiles__modified',
	sbd_fk_fmfiles.`created` AS 'sbd_fk_fmfiles__created',
	sbd_fk_fmfiles.`deleted_flag` AS 'sbd_fk_fmfiles__deleted_flag',
	sbd_fk_fmfiles.`directly_deleted_flag` AS 'sbd_fk_fmfiles__directly_deleted_flag',

	sbd.*

FROM `subcontractor_bid_documents` sbd
	INNER JOIN `subcontractor_bids` sbd_fk_sb ON sbd.`subcontractor_bid_id` = sbd_fk_sb.`id`
	INNER JOIN `subcontractor_bid_document_types` sbd_fk_sbdt ON sbd.`subcontractor_bid_document_type_id` = sbd_fk_sbdt.`id`
	LEFT OUTER JOIN `file_manager_files` sbd_fk_fmfiles ON sbd.`subcontractor_bid_document_file_manager_file_id` = sbd_fk_fmfiles.`id`
WHERE sbd.`id` IN ($csvSubcontractorBidDocumentIds){$sqlOrderBy}{$sqlLimit}
";

		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubcontractorBidDocumentsByCsvSubcontractorBidDocumentIds = array();
		while ($row = $db->fetch()) {
			$subcontractor_bid_document_id = $row['id'];
			$subcontractorBidDocument = self::instantiateOrm($database, 'SubcontractorBidDocument', $row, null, $subcontractor_bid_document_id);
			/* @var $subcontractorBidDocument SubcontractorBidDocument */
			$subcontractorBidDocument->convertPropertiesToData();

			if (isset($row['subcontractor_bid_id'])) {
				$subcontractor_bid_id = $row['subcontractor_bid_id'];
				$row['sbd_fk_sb__id'] = $subcontractor_bid_id;
				$subcontractorBid = self::instantiateOrm($database, 'SubcontractorBid', $row, null, $subcontractor_bid_id, 'sbd_fk_sb__');
				/* @var $subcontractorBid SubcontractorBid */
				$subcontractorBid->convertPropertiesToData();
			} else {
				$subcontractorBid = false;
			}
			$subcontractorBidDocument->setSubcontractorBid($subcontractorBid);

			if (isset($row['subcontractor_bid_document_type_id'])) {
				$subcontractor_bid_document_type_id = $row['subcontractor_bid_document_type_id'];
				$row['sbd_fk_sbdt__id'] = $subcontractor_bid_document_type_id;
				$subcontractorBidDocumentType = self::instantiateOrm($database, 'SubcontractorBidDocumentType', $row, null, $subcontractor_bid_document_type_id, 'sbd_fk_sbdt__');
				/* @var $subcontractorBidDocumentType SubcontractorBidDocumentType */
				$subcontractorBidDocumentType->convertPropertiesToData();
			} else {
				$subcontractorBidDocumentType = false;
			}
			$subcontractorBidDocument->setSubcontractorBidDocumentType($subcontractorBidDocumentType);

			if (isset($row['subcontractor_bid_document_file_manager_file_id'])) {
				$subcontractor_bid_document_file_manager_file_id = $row['subcontractor_bid_document_file_manager_file_id'];
				$row['sbd_fk_fmfiles__id'] = $subcontractor_bid_document_file_manager_file_id;
				$subcontractorBidDocumentFileManagerFile = self::instantiateOrm($database, 'FileManagerFile', $row, null, $subcontractor_bid_document_file_manager_file_id, 'sbd_fk_fmfiles__');
				/* @var $subcontractorBidDocumentFileManagerFile FileManagerFile */
				$subcontractorBidDocumentFileManagerFile->convertPropertiesToData();
			} else {
				$subcontractorBidDocumentFileManagerFile = false;
			}
			$subcontractorBidDocument->setSubcontractorBidDocumentFileManagerFile($subcontractorBidDocumentFileManagerFile);

			$arrSubcontractorBidDocumentsByCsvSubcontractorBidDocumentIds[$subcontractor_bid_document_id] = $subcontractorBidDocument;
		}

		$db->free_result();

		return $arrSubcontractorBidDocumentsByCsvSubcontractorBidDocumentIds;
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `subcontractor_bid_documents_fk_sb` foreign key (`subcontractor_bid_id`) references `subcontractor_bids` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $subcontractor_bid_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubcontractorBidDocumentsBySubcontractorBidId($database, $subcontractor_bid_id, Input $options=null)
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
			self::$_arrSubcontractorBidDocumentsBySubcontractorBidId = null;
		}

		$arrSubcontractorBidDocumentsBySubcontractorBidId = self::$_arrSubcontractorBidDocumentsBySubcontractorBidId;
		if (isset($arrSubcontractorBidDocumentsBySubcontractorBidId) && !empty($arrSubcontractorBidDocumentsBySubcontractorBidId)) {
			return $arrSubcontractorBidDocumentsBySubcontractorBidId;
		}

		$subcontractor_bid_id = (int) $subcontractor_bid_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `subcontractor_bid_id` ASC, `subcontractor_bid_document_type_id` ASC, `subcontractor_bid_document_sequence_number` ASC, `subcontractor_bid_document_file_manager_file_id` ASC, `subcontractor_bid_document_file_sha1` ASC, `created` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY sbd.`sort_order` ASC, sbd.`subcontractor_bid_document_sequence_number` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubcontractorBidDocument = new SubcontractorBidDocument($database);
			$sqlOrderByColumns = $tmpSubcontractorBidDocument->constructSqlOrderByColumns($arrOrderByAttributes);

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

		$sqlFilter = '';
		if (isset($arrSubcontractorBidDocumentIdIn) && !empty($arrSubcontractorBidDocumentIdIn)) {
			$in = join(',', $arrSubcontractorBidDocumentIdIn);
			$sqlFilter = "\nAND sbd_fk_sb.`id` IN ($in)";
		} else {
			$sqlFilter = '';
		}

		$query =
"
SELECT

	sbd_fk_sb.`id` AS 'sbd_fk_sb__subcontractor_bid_id',
	sbd_fk_sb.`gc_budget_line_item_id` AS 'sbd_fk_sb__gc_budget_line_item_id',
	sbd_fk_sb.`subcontractor_contact_id` AS 'sbd_fk_sb__subcontractor_contact_id',
	sbd_fk_sb.`subcontractor_bid_status_id` AS 'sbd_fk_sb__subcontractor_bid_status_id',
	sbd_fk_sb.`sort_order` AS 'sbd_fk_sb__sort_order',

	sbd_fk_sbdt.`id` AS 'sbd_fk_sbdt__subcontractor_bid_document_type_id',
	sbd_fk_sbdt.`subcontractor_bid_document_type` AS 'sbd_fk_sbdt__subcontractor_bid_document_type',
	sbd_fk_sbdt.`subcontractor_bid_document_type_abbreviation` AS 'sbd_fk_sbdt__subcontractor_bid_document_type_abbreviation',
	sbd_fk_sbdt.`created` AS 'sbd_fk_sbdt__created',
	sbd_fk_sbdt.`sort_order` AS 'sbd_fk_sbdt__sort_order',

	sbd_fk_fmfiles.`id` AS 'sbd_fk_fmfiles__file_manager_file_id',
	sbd_fk_fmfiles.`user_company_id` AS 'sbd_fk_fmfiles__user_company_id',
	sbd_fk_fmfiles.`contact_id` AS 'sbd_fk_fmfiles__contact_id',
	sbd_fk_fmfiles.`project_id` AS 'sbd_fk_fmfiles__project_id',
	sbd_fk_fmfiles.`file_manager_folder_id` AS 'sbd_fk_fmfiles__file_manager_folder_id',
	sbd_fk_fmfiles.`file_location_id` AS 'sbd_fk_fmfiles__file_location_id',
	sbd_fk_fmfiles.`virtual_file_name` AS 'sbd_fk_fmfiles__virtual_file_name',
	sbd_fk_fmfiles.`version_number` AS 'sbd_fk_fmfiles__version_number',
	sbd_fk_fmfiles.`virtual_file_name_sha1` AS 'sbd_fk_fmfiles__virtual_file_name_sha1',
	sbd_fk_fmfiles.`virtual_file_mime_type` AS 'sbd_fk_fmfiles__virtual_file_mime_type',
	sbd_fk_fmfiles.`modified` AS 'sbd_fk_fmfiles__modified',
	sbd_fk_fmfiles.`created` AS 'sbd_fk_fmfiles__created',
	sbd_fk_fmfiles.`deleted_flag` AS 'sbd_fk_fmfiles__deleted_flag',
	sbd_fk_fmfiles.`directly_deleted_flag` AS 'sbd_fk_fmfiles__directly_deleted_flag',

	sbd.*

FROM `subcontractor_bid_documents` sbd
	INNER JOIN `subcontractor_bids` sbd_fk_sb ON sbd.`subcontractor_bid_id` = sbd_fk_sb.`id`
	INNER JOIN `subcontractor_bid_document_types` sbd_fk_sbdt ON sbd.`subcontractor_bid_document_type_id` = sbd_fk_sbdt.`id`
	LEFT OUTER JOIN `file_manager_files` sbd_fk_fmfiles ON sbd.`subcontractor_bid_document_file_manager_file_id` = sbd_fk_fmfiles.`id`
WHERE sbd.`subcontractor_bid_id` = ?{$sqlFilter}{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `subcontractor_bid_id` ASC, `subcontractor_bid_document_type_id` ASC, `subcontractor_bid_document_sequence_number` ASC, `subcontractor_bid_document_file_manager_file_id` ASC, `subcontractor_bid_document_file_sha1` ASC, `created` ASC, `sort_order` ASC
		$arrValues = array($subcontractor_bid_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubcontractorBidDocumentsBySubcontractorBidId = array();
		while ($row = $db->fetch()) {
			$subcontractor_bid_document_id = $row['id'];
			$subcontractorBidDocument = self::instantiateOrm($database, 'SubcontractorBidDocument', $row, null, $subcontractor_bid_document_id);
			/* @var $subcontractorBidDocument SubcontractorBidDocument */
			$subcontractorBidDocument->convertPropertiesToData();

			if (isset($row['subcontractor_bid_id'])) {
				$subcontractor_bid_id = $row['subcontractor_bid_id'];
				$row['sbd_fk_sb__id'] = $subcontractor_bid_id;
				$subcontractorBid = self::instantiateOrm($database, 'SubcontractorBid', $row, null, $subcontractor_bid_id, 'sbd_fk_sb__');
				/* @var $subcontractorBid SubcontractorBid */
				$subcontractorBid->convertPropertiesToData();
			} else {
				$subcontractorBid = false;
			}
			$subcontractorBidDocument->setSubcontractorBid($subcontractorBid);

			if (isset($row['subcontractor_bid_document_type_id'])) {
				$subcontractor_bid_document_type_id = $row['subcontractor_bid_document_type_id'];
				$row['sbd_fk_sbdt__id'] = $subcontractor_bid_document_type_id;
				$subcontractorBidDocumentType = self::instantiateOrm($database, 'SubcontractorBidDocumentType', $row, null, $subcontractor_bid_document_type_id, 'sbd_fk_sbdt__');
				/* @var $subcontractorBidDocumentType SubcontractorBidDocumentType */
				$subcontractorBidDocumentType->convertPropertiesToData();
			} else {
				$subcontractorBidDocumentType = false;
			}
			$subcontractorBidDocument->setSubcontractorBidDocumentType($subcontractorBidDocumentType);

			if (isset($row['subcontractor_bid_document_file_manager_file_id'])) {
				$subcontractor_bid_document_file_manager_file_id = $row['subcontractor_bid_document_file_manager_file_id'];
				$row['sbd_fk_fmfiles__id'] = $subcontractor_bid_document_file_manager_file_id;
				$subcontractorBidDocumentFileManagerFile = self::instantiateOrm($database, 'FileManagerFile', $row, null, $subcontractor_bid_document_file_manager_file_id, 'sbd_fk_fmfiles__');
				/* @var $subcontractorBidDocumentFileManagerFile FileManagerFile */
				$subcontractorBidDocumentFileManagerFile->convertPropertiesToData();
			} else {
				$subcontractorBidDocumentFileManagerFile = false;
			}
			$subcontractorBidDocument->setSubcontractorBidDocumentFileManagerFile($subcontractorBidDocumentFileManagerFile);

			$arrSubcontractorBidDocumentsBySubcontractorBidId[$subcontractor_bid_document_id] = $subcontractorBidDocument;
		}

		$db->free_result();

		self::$_arrSubcontractorBidDocumentsBySubcontractorBidId = $arrSubcontractorBidDocumentsBySubcontractorBidId;

		return $arrSubcontractorBidDocumentsBySubcontractorBidId;
	}

	/**
	 * Load by constraint `subcontractor_bid_documents_fk_sbdt` foreign key (`subcontractor_bid_document_type_id`) references `subcontractor_bid_document_types` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $subcontractor_bid_document_type_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubcontractorBidDocumentsBySubcontractorBidDocumentTypeId($database, $subcontractor_bid_document_type_id, Input $options=null)
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
			self::$_arrSubcontractorBidDocumentsBySubcontractorBidDocumentTypeId = null;
		}

		$arrSubcontractorBidDocumentsBySubcontractorBidDocumentTypeId = self::$_arrSubcontractorBidDocumentsBySubcontractorBidDocumentTypeId;
		if (isset($arrSubcontractorBidDocumentsBySubcontractorBidDocumentTypeId) && !empty($arrSubcontractorBidDocumentsBySubcontractorBidDocumentTypeId)) {
			return $arrSubcontractorBidDocumentsBySubcontractorBidDocumentTypeId;
		}

		$subcontractor_bid_document_type_id = (int) $subcontractor_bid_document_type_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `subcontractor_bid_id` ASC, `subcontractor_bid_document_type_id` ASC, `subcontractor_bid_document_sequence_number` ASC, `subcontractor_bid_document_file_manager_file_id` ASC, `subcontractor_bid_document_file_sha1` ASC, `created` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY sbd.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubcontractorBidDocument = new SubcontractorBidDocument($database);
			$sqlOrderByColumns = $tmpSubcontractorBidDocument->constructSqlOrderByColumns($arrOrderByAttributes);

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
	sbd.*

FROM `subcontractor_bid_documents` sbd
WHERE sbd.`subcontractor_bid_document_type_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `subcontractor_bid_id` ASC, `subcontractor_bid_document_type_id` ASC, `subcontractor_bid_document_sequence_number` ASC, `subcontractor_bid_document_file_manager_file_id` ASC, `subcontractor_bid_document_file_sha1` ASC, `created` ASC, `sort_order` ASC
		$arrValues = array($subcontractor_bid_document_type_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubcontractorBidDocumentsBySubcontractorBidDocumentTypeId = array();
		while ($row = $db->fetch()) {
			$subcontractor_bid_document_id = $row['id'];
			$subcontractorBidDocument = self::instantiateOrm($database, 'SubcontractorBidDocument', $row, null, $subcontractor_bid_document_id);
			/* @var $subcontractorBidDocument SubcontractorBidDocument */
			$arrSubcontractorBidDocumentsBySubcontractorBidDocumentTypeId[$subcontractor_bid_document_id] = $subcontractorBidDocument;
		}

		$db->free_result();

		self::$_arrSubcontractorBidDocumentsBySubcontractorBidDocumentTypeId = $arrSubcontractorBidDocumentsBySubcontractorBidDocumentTypeId;

		return $arrSubcontractorBidDocumentsBySubcontractorBidDocumentTypeId;
	}

	/**
	 * Load by constraint `subcontractor_bid_documents_fk_fmfiles` foreign key (`subcontractor_bid_document_file_manager_file_id`) references `file_manager_files` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $subcontractor_bid_document_file_manager_file_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadSubcontractorBidDocumentsBySubcontractorBidDocumentFileManagerFileId($database, $subcontractor_bid_document_file_manager_file_id, Input $options=null)
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
			self::$_arrSubcontractorBidDocumentsBySubcontractorBidDocumentFileManagerFileId = null;
		}

		$arrSubcontractorBidDocumentsBySubcontractorBidDocumentFileManagerFileId = self::$_arrSubcontractorBidDocumentsBySubcontractorBidDocumentFileManagerFileId;
		if (isset($arrSubcontractorBidDocumentsBySubcontractorBidDocumentFileManagerFileId) && !empty($arrSubcontractorBidDocumentsBySubcontractorBidDocumentFileManagerFileId)) {
			return $arrSubcontractorBidDocumentsBySubcontractorBidDocumentFileManagerFileId;
		}

		$subcontractor_bid_document_file_manager_file_id = (int) $subcontractor_bid_document_file_manager_file_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `subcontractor_bid_id` ASC, `subcontractor_bid_document_type_id` ASC, `subcontractor_bid_document_sequence_number` ASC, `subcontractor_bid_document_file_manager_file_id` ASC, `subcontractor_bid_document_file_sha1` ASC, `created` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY sbd.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubcontractorBidDocument = new SubcontractorBidDocument($database);
			$sqlOrderByColumns = $tmpSubcontractorBidDocument->constructSqlOrderByColumns($arrOrderByAttributes);

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
	sbd.*

FROM `subcontractor_bid_documents` sbd
WHERE sbd.`subcontractor_bid_document_file_manager_file_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `subcontractor_bid_id` ASC, `subcontractor_bid_document_type_id` ASC, `subcontractor_bid_document_sequence_number` ASC, `subcontractor_bid_document_file_manager_file_id` ASC, `subcontractor_bid_document_file_sha1` ASC, `created` ASC, `sort_order` ASC
		$arrValues = array($subcontractor_bid_document_file_manager_file_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubcontractorBidDocumentsBySubcontractorBidDocumentFileManagerFileId = array();
		while ($row = $db->fetch()) {
			$subcontractor_bid_document_id = $row['id'];
			$subcontractorBidDocument = self::instantiateOrm($database, 'SubcontractorBidDocument', $row, null, $subcontractor_bid_document_id);
			/* @var $subcontractorBidDocument SubcontractorBidDocument */
			$arrSubcontractorBidDocumentsBySubcontractorBidDocumentFileManagerFileId[$subcontractor_bid_document_id] = $subcontractorBidDocument;
		}

		$db->free_result();

		self::$_arrSubcontractorBidDocumentsBySubcontractorBidDocumentFileManagerFileId = $arrSubcontractorBidDocumentsBySubcontractorBidDocumentFileManagerFileId;

		return $arrSubcontractorBidDocumentsBySubcontractorBidDocumentFileManagerFileId;
	}

	// Loaders: Load By index
	/**
	 * Load by key `subcontractor_bid_document_file_sha1` (`subcontractor_bid_document_file_sha1`).
	 *
	 * @param string $database
	 * @param string $subcontractor_bid_document_file_sha1
	 * @param mixed (Input $options object | null)
	 * @return mixed (single ORM object | false)
	 */
	public static function loadSubcontractorBidDocumentsBySubcontractorBidDocumentFileSha1($database, $subcontractor_bid_document_file_sha1, Input $options=null)
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
			self::$_arrSubcontractorBidDocumentsBySubcontractorBidDocumentFileSha1 = null;
		}

		$arrSubcontractorBidDocumentsBySubcontractorBidDocumentFileSha1 = self::$_arrSubcontractorBidDocumentsBySubcontractorBidDocumentFileSha1;
		if (isset($arrSubcontractorBidDocumentsBySubcontractorBidDocumentFileSha1) && !empty($arrSubcontractorBidDocumentsBySubcontractorBidDocumentFileSha1)) {
			return $arrSubcontractorBidDocumentsBySubcontractorBidDocumentFileSha1;
		}

		$subcontractor_bid_document_file_sha1 = (string) $subcontractor_bid_document_file_sha1;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `subcontractor_bid_id` ASC, `subcontractor_bid_document_type_id` ASC, `subcontractor_bid_document_sequence_number` ASC, `subcontractor_bid_document_file_manager_file_id` ASC, `subcontractor_bid_document_file_sha1` ASC, `created` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY sbd.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubcontractorBidDocument = new SubcontractorBidDocument($database);
			$sqlOrderByColumns = $tmpSubcontractorBidDocument->constructSqlOrderByColumns($arrOrderByAttributes);

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
	sbd.*

FROM `subcontractor_bid_documents` sbd
WHERE sbd.`subcontractor_bid_document_file_sha1` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `subcontractor_bid_id` ASC, `subcontractor_bid_document_type_id` ASC, `subcontractor_bid_document_sequence_number` ASC, `subcontractor_bid_document_file_manager_file_id` ASC, `subcontractor_bid_document_file_sha1` ASC, `created` ASC, `sort_order` ASC
		$arrValues = array($subcontractor_bid_document_file_sha1);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubcontractorBidDocumentsBySubcontractorBidDocumentFileSha1 = array();
		while ($row = $db->fetch()) {
			$subcontractor_bid_document_id = $row['id'];
			$subcontractorBidDocument = self::instantiateOrm($database, 'SubcontractorBidDocument', $row, null, $subcontractor_bid_document_id);
			/* @var $subcontractorBidDocument SubcontractorBidDocument */
			$arrSubcontractorBidDocumentsBySubcontractorBidDocumentFileSha1[$subcontractor_bid_document_id] = $subcontractorBidDocument;
		}

		$db->free_result();

		self::$_arrSubcontractorBidDocumentsBySubcontractorBidDocumentFileSha1 = $arrSubcontractorBidDocumentsBySubcontractorBidDocumentFileSha1;

		return $arrSubcontractorBidDocumentsBySubcontractorBidDocumentFileSha1;
	}

	// Loaders: Load By additionally indexed attribute
	public static function loadSubcontractorBidDocumentsBySubcontractorBidIdAndSubcontractorBidDocumentTypeId($database, $subcontractor_bid_id, $subcontractor_bid_document_type_id, Input $options=null)
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

		/*
		if ($forceLoadFlag) {
			self::$_arrSubcontractorBidDocumentsBySubcontractorBidIdAndSubcontractorBidDocumentTypeId = null;
		}

		$arrSubcontractorBidDocumentsBySubcontractorBidIdAndSubcontractorBidDocumentTypeId = self::$_arrSubcontractorBidDocumentsBySubcontractorBidIdAndSubcontractorBidDocumentTypeId;
		if (isset($arrSubcontractorBidDocumentsBySubcontractorBidIdAndSubcontractorBidDocumentTypeId) && !empty($arrSubcontractorBidDocumentsBySubcontractorBidIdAndSubcontractorBidDocumentTypeId)) {
			return $arrSubcontractorBidDocumentsBySubcontractorBidIdAndSubcontractorBidDocumentTypeId;
		}
		*/

		$subcontractor_bid_id = (int) $subcontractor_bid_id;
		$subcontractor_bid_document_type_id = (int) $subcontractor_bid_document_type_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `subcontractor_bid_id` ASC, `subcontractor_bid_document_type_id` ASC, `subcontractor_bid_document_sequence_number` ASC, `subcontractor_bid_document_file_manager_file_id` ASC, `subcontractor_bid_document_file_sha1` ASC, `created` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY sbd.`sort_order` ASC, sbd.`subcontractor_bid_document_sequence_number` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubcontractorBidDocument = new SubcontractorBidDocument($database);
			$sqlOrderByColumns = $tmpSubcontractorBidDocument->constructSqlOrderByColumns($arrOrderByAttributes);

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

	sbd_fk_sb.`id` AS 'sbd_fk_sb__subcontractor_bid_id',
	sbd_fk_sb.`gc_budget_line_item_id` AS 'sbd_fk_sb__gc_budget_line_item_id',
	sbd_fk_sb.`subcontractor_contact_id` AS 'sbd_fk_sb__subcontractor_contact_id',
	sbd_fk_sb.`subcontractor_bid_status_id` AS 'sbd_fk_sb__subcontractor_bid_status_id',
	sbd_fk_sb.`sort_order` AS 'sbd_fk_sb__sort_order',

	sbd_fk_sbdt.`id` AS 'sbd_fk_sbdt__subcontractor_bid_document_type_id',
	sbd_fk_sbdt.`subcontractor_bid_document_type` AS 'sbd_fk_sbdt__subcontractor_bid_document_type',
	sbd_fk_sbdt.`subcontractor_bid_document_type_abbreviation` AS 'sbd_fk_sbdt__subcontractor_bid_document_type_abbreviation',
	sbd_fk_sbdt.`created` AS 'sbd_fk_sbdt__created',
	sbd_fk_sbdt.`sort_order` AS 'sbd_fk_sbdt__sort_order',

	sbd_fk_fmfiles.`id` AS 'sbd_fk_fmfiles__file_manager_file_id',
	sbd_fk_fmfiles.`user_company_id` AS 'sbd_fk_fmfiles__user_company_id',
	sbd_fk_fmfiles.`contact_id` AS 'sbd_fk_fmfiles__contact_id',
	sbd_fk_fmfiles.`project_id` AS 'sbd_fk_fmfiles__project_id',
	sbd_fk_fmfiles.`file_manager_folder_id` AS 'sbd_fk_fmfiles__file_manager_folder_id',
	sbd_fk_fmfiles.`file_location_id` AS 'sbd_fk_fmfiles__file_location_id',
	sbd_fk_fmfiles.`virtual_file_name` AS 'sbd_fk_fmfiles__virtual_file_name',
	sbd_fk_fmfiles.`version_number` AS 'sbd_fk_fmfiles__version_number',
	sbd_fk_fmfiles.`virtual_file_name_sha1` AS 'sbd_fk_fmfiles__virtual_file_name_sha1',
	sbd_fk_fmfiles.`virtual_file_mime_type` AS 'sbd_fk_fmfiles__virtual_file_mime_type',
	sbd_fk_fmfiles.`modified` AS 'sbd_fk_fmfiles__modified',
	sbd_fk_fmfiles.`created` AS 'sbd_fk_fmfiles__created',
	sbd_fk_fmfiles.`deleted_flag` AS 'sbd_fk_fmfiles__deleted_flag',
	sbd_fk_fmfiles.`directly_deleted_flag` AS 'sbd_fk_fmfiles__directly_deleted_flag',

	sbd.*

FROM `subcontractor_bid_documents` sbd
	INNER JOIN `subcontractor_bids` sbd_fk_sb ON sbd.`subcontractor_bid_id` = sbd_fk_sb.`id`
	INNER JOIN `subcontractor_bid_document_types` sbd_fk_sbdt ON sbd.`subcontractor_bid_document_type_id` = sbd_fk_sbdt.`id`
	LEFT OUTER JOIN `file_manager_files` sbd_fk_fmfiles ON sbd.`subcontractor_bid_document_file_manager_file_id` = sbd_fk_fmfiles.`id`
WHERE sbd.`subcontractor_bid_id` = ?
AND sbd.`subcontractor_bid_document_type_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `subcontractor_bid_id` ASC, `subcontractor_bid_document_type_id` ASC, `subcontractor_bid_document_sequence_number` ASC, `subcontractor_bid_document_file_manager_file_id` ASC, `subcontractor_bid_document_file_sha1` ASC, `created` ASC, `sort_order` ASC
		$arrValues = array($subcontractor_bid_id, $subcontractor_bid_document_type_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubcontractorBidDocumentsBySubcontractorBidIdAndSubcontractorBidDocumentTypeId = array();
		while ($row = $db->fetch()) {
			$subcontractor_bid_document_id = $row['id'];
			$subcontractorBidDocument = self::instantiateOrm($database, 'SubcontractorBidDocument', $row, null, $subcontractor_bid_document_id);
			/* @var $subcontractorBidDocument SubcontractorBidDocument */
			$subcontractorBidDocument->convertPropertiesToData();

			if (isset($row['subcontractor_bid_id'])) {
				$subcontractor_bid_id = $row['subcontractor_bid_id'];
				$row['sbd_fk_sb__id'] = $subcontractor_bid_id;
				$subcontractorBid = self::instantiateOrm($database, 'SubcontractorBid', $row, null, $subcontractor_bid_id, 'sbd_fk_sb__');
				/* @var $subcontractorBid SubcontractorBid */
				$subcontractorBid->convertPropertiesToData();
			} else {
				$subcontractorBid = false;
			}
			$subcontractorBidDocument->setSubcontractorBid($subcontractorBid);

			if (isset($row['subcontractor_bid_document_type_id'])) {
				$subcontractor_bid_document_type_id = $row['subcontractor_bid_document_type_id'];
				$row['sbd_fk_sbdt__id'] = $subcontractor_bid_document_type_id;
				$subcontractorBidDocumentType = self::instantiateOrm($database, 'SubcontractorBidDocumentType', $row, null, $subcontractor_bid_document_type_id, 'sbd_fk_sbdt__');
				/* @var $subcontractorBidDocumentType SubcontractorBidDocumentType */
				$subcontractorBidDocumentType->convertPropertiesToData();
			} else {
				$subcontractorBidDocumentType = false;
			}
			$subcontractorBidDocument->setSubcontractorBidDocumentType($subcontractorBidDocumentType);

			if (isset($row['subcontractor_bid_document_file_manager_file_id'])) {
				$subcontractor_bid_document_file_manager_file_id = $row['subcontractor_bid_document_file_manager_file_id'];
				$row['sbd_fk_fmfiles__id'] = $subcontractor_bid_document_file_manager_file_id;
				$subcontractorBidDocumentFileManagerFile = self::instantiateOrm($database, 'FileManagerFile', $row, null, $subcontractor_bid_document_file_manager_file_id, 'sbd_fk_fmfiles__');
				/* @var $subcontractorBidDocumentFileManagerFile FileManagerFile */
				$subcontractorBidDocumentFileManagerFile->convertPropertiesToData();
			} else {
				$subcontractorBidDocumentFileManagerFile = false;
			}
			$subcontractorBidDocument->setSubcontractorBidDocumentFileManagerFile($subcontractorBidDocumentFileManagerFile);

			$arrSubcontractorBidDocumentsBySubcontractorBidIdAndSubcontractorBidDocumentTypeId[$subcontractor_bid_document_id] = $subcontractorBidDocument;
		}

		$db->free_result();

		return $arrSubcontractorBidDocumentsBySubcontractorBidIdAndSubcontractorBidDocumentTypeId;
	}

	// Loaders: Load All Records
	/**
	 * Load all subcontractor_bid_documents records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllSubcontractorBidDocuments($database, Input $options=null)
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
			self::$_arrAllSubcontractorBidDocuments = null;
		}

		$arrAllSubcontractorBidDocuments = self::$_arrAllSubcontractorBidDocuments;
		if (isset($arrAllSubcontractorBidDocuments) && !empty($arrAllSubcontractorBidDocuments)) {
			return $arrAllSubcontractorBidDocuments;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `subcontractor_bid_id` ASC, `subcontractor_bid_document_type_id` ASC, `subcontractor_bid_document_sequence_number` ASC, `subcontractor_bid_document_file_manager_file_id` ASC, `subcontractor_bid_document_file_sha1` ASC, `created` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY sbd.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubcontractorBidDocument = new SubcontractorBidDocument($database);
			$sqlOrderByColumns = $tmpSubcontractorBidDocument->constructSqlOrderByColumns($arrOrderByAttributes);

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
	sbd.*

FROM `subcontractor_bid_documents` sbd{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `subcontractor_bid_id` ASC, `subcontractor_bid_document_type_id` ASC, `subcontractor_bid_document_sequence_number` ASC, `subcontractor_bid_document_file_manager_file_id` ASC, `subcontractor_bid_document_file_sha1` ASC, `created` ASC, `sort_order` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllSubcontractorBidDocuments = array();
		while ($row = $db->fetch()) {
			$subcontractor_bid_document_id = $row['id'];
			$subcontractorBidDocument = self::instantiateOrm($database, 'SubcontractorBidDocument', $row, null, $subcontractor_bid_document_id);
			/* @var $subcontractorBidDocument SubcontractorBidDocument */
			$arrAllSubcontractorBidDocuments[$subcontractor_bid_document_id] = $subcontractorBidDocument;
		}

		$db->free_result();

		self::$_arrAllSubcontractorBidDocuments = $arrAllSubcontractorBidDocuments;

		return $arrAllSubcontractorBidDocuments;
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
INTO `subcontractor_bid_documents`
(`subcontractor_bid_id`, `subcontractor_bid_document_type_id`, `subcontractor_bid_document_sequence_number`, `subcontractor_bid_document_file_manager_file_id`, `subcontractor_bid_document_file_sha1`, `created`, `sort_order`)
VALUES (?, ?, ?, ?, ?, ?, ?)
ON DUPLICATE KEY UPDATE `subcontractor_bid_document_file_manager_file_id` = ?, `subcontractor_bid_document_file_sha1` = ?, `created` = ?, `sort_order` = ?
";
		$arrValues = array($this->subcontractor_bid_id, $this->subcontractor_bid_document_type_id, $this->subcontractor_bid_document_sequence_number, $this->subcontractor_bid_document_file_manager_file_id, $this->subcontractor_bid_document_file_sha1, $this->created, $this->sort_order, $this->subcontractor_bid_document_file_manager_file_id, $this->subcontractor_bid_document_file_sha1, $this->created, $this->sort_order);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$subcontractor_bid_document_id = $db->insertId;
		$db->free_result();

		return $subcontractor_bid_document_id;
	}

	// Save: insert ignore

	public static function findNextSubcontractorBidDocumentSequenceNumber($database, $subcontractor_bid_id, $subcontractor_bid_document_type_id)
	{
		$next_subcontractor_bid_document_sequence_number = 1;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT MAX(subcontractor_bid_document_sequence_number) AS 'max_subcontractor_bid_document_sequence_number'
FROM `subcontractor_bid_documents`
WHERE `subcontractor_bid_id` = ?
AND `subcontractor_bid_document_type_id` = ?
";
		$arrValues = array($subcontractor_bid_id, $subcontractor_bid_document_type_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$max_subcontractor_bid_document_sequence_number = $row['max_subcontractor_bid_document_sequence_number'];
			$next_subcontractor_bid_document_sequence_number = $max_subcontractor_bid_document_sequence_number + 1;
		}

		return $next_subcontractor_bid_document_sequence_number;
	}

	public static function loadSubcontractorBidDocumentsBySubcontractorBidIdGroupBySubcontractorBidDocumentType($database, $subcontractor_bid_id, Input $options=null)
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

		/*
		if ($forceLoadFlag) {
			self::$_arrSubcontractorBidDocumentsBySubcontractorBidIdGroupBySubcontractorBidDocumentType = null;
		}

		$arrSubcontractorBidDocumentsBySubcontractorBidIdGroupBySubcontractorBidDocumentType = self::$_arrSubcontractorBidDocumentsBySubcontractorBidIdGroupBySubcontractorBidDocumentType;
		if (isset($arrSubcontractorBidDocumentsBySubcontractorBidIdGroupBySubcontractorBidDocumentType) && !empty($arrSubcontractorBidDocumentsBySubcontractorBidIdGroupBySubcontractorBidDocumentType)) {
			return $arrSubcontractorBidDocumentsBySubcontractorBidIdGroupBySubcontractorBidDocumentType;
		}
		*/

		$subcontractor_bid_id = (int) $subcontractor_bid_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `subcontractor_bid_id` ASC, `subcontractor_bid_document_type_id` ASC, `subcontractor_bid_document_sequence_number` ASC, `subcontractor_bid_document_file_manager_file_id` ASC, `subcontractor_bid_document_file_sha1` ASC, `created` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY sbd.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpSubcontractorBidDocument = new SubcontractorBidDocument($database);
			$sqlOrderByColumns = $tmpSubcontractorBidDocument->constructSqlOrderByColumns($arrOrderByAttributes);

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

	sbd_fk_sbdt.`id` AS 'sbd_fk_sbdt__subcontractor_bid_document_type_id',
	sbd_fk_sbdt.`subcontractor_bid_document_type` AS 'sbd_fk_sbdt__subcontractor_bid_document_type',
	sbd_fk_sbdt.`subcontractor_bid_document_type_abbreviation` AS 'sbd_fk_sbdt__subcontractor_bid_document_type_abbreviation',
	sbd_fk_sbdt.`created` AS 'sbd_fk_sbdt__created',
	sbd_fk_sbdt.`sort_order` AS 'sbd_fk_sbdt__sort_order',

	sbd.*

FROM `subcontractor_bid_documents` sbd
	INNER JOIN `subcontractor_bid_document_types` sbd_fk_sbdt ON sbd.`subcontractor_bid_document_type_id` = sbd_fk_sbdt.`id`
WHERE sbd.`subcontractor_bid_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `subcontractor_bid_id` ASC, `subcontractor_bid_document_type_id` ASC, `subcontractor_bid_document_sequence_number` ASC, `subcontractor_bid_document_file_manager_file_id` ASC, `subcontractor_bid_document_file_sha1` ASC, `created` ASC, `sort_order` ASC
		$arrValues = array($subcontractor_bid_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrSubcontractorBidDocumentsBySubcontractorBidId = array();
		while ($row = $db->fetch()) {
			$subcontractor_bid_document_id = $row['id'];
			$subcontractor_bid_document_type = $row['sbd_fk_sbdt__subcontractor_bid_document_type'];
			$subcontractorBidDocument = self::instantiateOrm($database, 'SubcontractorBidDocument', $row, null, $subcontractor_bid_document_id);
			/* @var $subcontractorBidDocument SubcontractorBidDocument */
			$subcontractorBidDocument->convertPropertiesToData();

			if (isset($row['subcontractor_bid_document_type_id'])) {
				$subcontractor_bid_document_type_id = $row['subcontractor_bid_document_type_id'];
				$row['sbd_fk_sbdt__id'] = $subcontractor_bid_document_type_id;
				$subcontractorBidDocumentType = self::instantiateOrm($database, 'SubcontractorBidDocumentType', $row, null, $subcontractor_bid_document_type_id, 'sbd_fk_sbdt__');
				/* @var $subcontractorBidDocumentType SubcontractorBidDocumentType */
				$subcontractorBidDocumentType->convertPropertiesToData();
			} else {
				$subcontractorBidDocumentType = false;
			}
			$subcontractorBidDocument->setSubcontractorBidDocumentType($subcontractorBidDocumentType);

			$arrSubcontractorBidDocumentsBySubcontractorBidId[$subcontractor_bid_document_type][$subcontractor_bid_document_id] = $subcontractorBidDocument;
		}

		$db->free_result();

		//self::$_arrSubcontractorBidDocumentsBySubcontractorBidId = $arrSubcontractorBidDocumentsBySubcontractorBidId;

		return $arrSubcontractorBidDocumentsBySubcontractorBidId;
	}
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

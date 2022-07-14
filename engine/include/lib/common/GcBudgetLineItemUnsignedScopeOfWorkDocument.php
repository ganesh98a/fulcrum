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
 * GcBudgetLineItemUnsignedScopeOfWorkDocument.
 *
 * @category   Framework
 * @package    GcBudgetLineItemUnsignedScopeOfWorkDocument
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class GcBudgetLineItemUnsignedScopeOfWorkDocument extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'GcBudgetLineItemUnsignedScopeOfWorkDocument';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'gc_budget_line_item_unsigned_scope_of_work_documents';

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
	 * unique index `unique_gc_budget_line_item_unsigned_scope_of_work_documents` (`gc_budget_line_item_id`,`unsigned_scope_of_work_document_sequence_number`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_gc_budget_line_item_unsigned_scope_of_work_documents' => array(
			'gc_budget_line_item_id' => 'int',
			'unsigned_scope_of_work_document_sequence_number' => 'int'
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
		'id' => 'gc_budget_line_item_unsigned_scope_of_work_document_id',

		'gc_budget_line_item_id' => 'gc_budget_line_item_id',
		'unsigned_scope_of_work_document_sequence_number' => 'unsigned_scope_of_work_document_sequence_number',

		'unsigned_scope_of_work_document_file_manager_file_id' => 'unsigned_scope_of_work_document_file_manager_file_id',

		'unsigned_scope_of_work_document_file_sha1' => 'unsigned_scope_of_work_document_file_sha1',
		'created' => 'created',
		'sort_order' => 'sort_order'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $gc_budget_line_item_unsigned_scope_of_work_document_id;

	public $gc_budget_line_item_id;
	public $unsigned_scope_of_work_document_sequence_number;

	public $unsigned_scope_of_work_document_file_manager_file_id;

	public $unsigned_scope_of_work_document_file_sha1;
	public $created;
	public $sort_order;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties
	public $escaped_unsigned_scope_of_work_document_file_sha1;

	// HTML ENTITY ENCODED NL2BR ORM string properties
	public $escaped_unsigned_scope_of_work_document_file_sha1_nl2br;

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)
	protected static $_arrGcBudgetLineItemUnsignedScopeOfWorkDocumentsByGcBudgetLineItemId;
	protected static $_arrGcBudgetLineItemUnsignedScopeOfWorkDocumentsByUnsignedScopeOfWorkDocumentFileManagerFileId;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)
	protected static $_arrGcBudgetLineItemUnsignedScopeOfWorkDocumentsByUnsignedScopeOfWorkDocumentFileSha1;

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllGcBudgetLineItemUnsignedScopeOfWorkDocuments;

	// Foreign Key Objects
	private $_gcBudgetLineItem;
	private $_unsignedScopeOfWorkDocumentFileManagerFile;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='gc_budget_line_item_unsigned_scope_of_work_documents')
	{
		parent::__construct($table);
		$this->setDatabase($database);
	}

	// Foreign Key Object Accessor Methods
	public function getGcBudgetLineItem()
	{
		if (isset($this->_gcBudgetLineItem)) {
			return $this->_gcBudgetLineItem;
		} else {
			return null;
		}
	}

	public function setGcBudgetLineItem($gcBudgetLineItem)
	{
		$this->_gcBudgetLineItem = $gcBudgetLineItem;
	}

	public function getUnsignedScopeOfWorkDocumentFileManagerFile()
	{
		if (isset($this->_unsignedScopeOfWorkDocumentFileManagerFile)) {
			return $this->_unsignedScopeOfWorkDocumentFileManagerFile;
		} else {
			return null;
		}
	}

	public function setUnsignedScopeOfWorkDocumentFileManagerFile($unsignedScopeOfWorkDocumentFileManagerFile)
	{
		$this->_unsignedScopeOfWorkDocumentFileManagerFile = $unsignedScopeOfWorkDocumentFileManagerFile;
	}

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)
	public static function getArrGcBudgetLineItemUnsignedScopeOfWorkDocumentsByGcBudgetLineItemId()
	{
		if (isset(self::$_arrGcBudgetLineItemUnsignedScopeOfWorkDocumentsByGcBudgetLineItemId)) {
			return self::$_arrGcBudgetLineItemUnsignedScopeOfWorkDocumentsByGcBudgetLineItemId;
		} else {
			return null;
		}
	}

	public static function setArrGcBudgetLineItemUnsignedScopeOfWorkDocumentsByGcBudgetLineItemId($arrGcBudgetLineItemUnsignedScopeOfWorkDocumentsByGcBudgetLineItemId)
	{
		self::$_arrGcBudgetLineItemUnsignedScopeOfWorkDocumentsByGcBudgetLineItemId = $arrGcBudgetLineItemUnsignedScopeOfWorkDocumentsByGcBudgetLineItemId;
	}

	public static function getArrGcBudgetLineItemUnsignedScopeOfWorkDocumentsByUnsignedScopeOfWorkDocumentFileManagerFileId()
	{
		if (isset(self::$_arrGcBudgetLineItemUnsignedScopeOfWorkDocumentsByUnsignedScopeOfWorkDocumentFileManagerFileId)) {
			return self::$_arrGcBudgetLineItemUnsignedScopeOfWorkDocumentsByUnsignedScopeOfWorkDocumentFileManagerFileId;
		} else {
			return null;
		}
	}

	public static function setArrGcBudgetLineItemUnsignedScopeOfWorkDocumentsByUnsignedScopeOfWorkDocumentFileManagerFileId($arrGcBudgetLineItemUnsignedScopeOfWorkDocumentsByUnsignedScopeOfWorkDocumentFileManagerFileId)
	{
		self::$_arrGcBudgetLineItemUnsignedScopeOfWorkDocumentsByUnsignedScopeOfWorkDocumentFileManagerFileId = $arrGcBudgetLineItemUnsignedScopeOfWorkDocumentsByUnsignedScopeOfWorkDocumentFileManagerFileId;
	}

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)
	public static function getArrGcBudgetLineItemUnsignedScopeOfWorkDocumentsByUnsignedScopeOfWorkDocumentFileSha1()
	{
		if (isset(self::$_arrGcBudgetLineItemUnsignedScopeOfWorkDocumentsByUnsignedScopeOfWorkDocumentFileSha1)) {
			return self::$_arrGcBudgetLineItemUnsignedScopeOfWorkDocumentsByUnsignedScopeOfWorkDocumentFileSha1;
		} else {
			return null;
		}
	}

	public static function setArrGcBudgetLineItemUnsignedScopeOfWorkDocumentsByUnsignedScopeOfWorkDocumentFileSha1($arrGcBudgetLineItemUnsignedScopeOfWorkDocumentsByUnsignedScopeOfWorkDocumentFileSha1)
	{
		self::$_arrGcBudgetLineItemUnsignedScopeOfWorkDocumentsByUnsignedScopeOfWorkDocumentFileSha1 = $arrGcBudgetLineItemUnsignedScopeOfWorkDocumentsByUnsignedScopeOfWorkDocumentFileSha1;
	}

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllGcBudgetLineItemUnsignedScopeOfWorkDocuments()
	{
		if (isset(self::$_arrAllGcBudgetLineItemUnsignedScopeOfWorkDocuments)) {
			return self::$_arrAllGcBudgetLineItemUnsignedScopeOfWorkDocuments;
		} else {
			return null;
		}
	}

	public static function setArrAllGcBudgetLineItemUnsignedScopeOfWorkDocuments($arrAllGcBudgetLineItemUnsignedScopeOfWorkDocuments)
	{
		self::$_arrAllGcBudgetLineItemUnsignedScopeOfWorkDocuments = $arrAllGcBudgetLineItemUnsignedScopeOfWorkDocuments;
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
	 * @param int $gc_budget_line_item_unsigned_scope_of_work_document_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findById($database, $gc_budget_line_item_unsigned_scope_of_work_document_id, $table='gc_budget_line_item_unsigned_scope_of_work_documents', $module='GcBudgetLineItemUnsignedScopeOfWorkDocument')
	{
		$gcBudgetLineItemUnsignedScopeOfWorkDocument = parent::findById($database, $gc_budget_line_item_unsigned_scope_of_work_document_id, $table, $module);

		return $gcBudgetLineItemUnsignedScopeOfWorkDocument;
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Similar to FindById, but with SQL as starter code for more complex joins.
	 *
	 * @param string $database
	 * @param int $gc_budget_line_item_unsigned_scope_of_work_document_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findGcBudgetLineItemUnsignedScopeOfWorkDocumentByIdExtended($database, $gc_budget_line_item_unsigned_scope_of_work_document_id)
	{
		$gc_budget_line_item_unsigned_scope_of_work_document_id = (int) $gc_budget_line_item_unsigned_scope_of_work_document_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	gbliusowd_fk_gbli.`id` AS 'gbliusowd_fk_gbli__gc_budget_line_item_id',
	gbliusowd_fk_gbli.`user_company_id` AS 'gbliusowd_fk_gbli__user_company_id',
	gbliusowd_fk_gbli.`project_id` AS 'gbliusowd_fk_gbli__project_id',
	gbliusowd_fk_gbli.`cost_code_id` AS 'gbliusowd_fk_gbli__cost_code_id',
	gbliusowd_fk_gbli.`modified` AS 'gbliusowd_fk_gbli__modified',
	gbliusowd_fk_gbli.`prime_contract_scheduled_value` AS 'gbliusowd_fk_gbli__prime_contract_scheduled_value',
	gbliusowd_fk_gbli.`forecasted_expenses` AS 'gbliusowd_fk_gbli__forecasted_expenses',
	gbliusowd_fk_gbli.`created` AS 'gbliusowd_fk_gbli__created',
	gbliusowd_fk_gbli.`sort_order` AS 'gbliusowd_fk_gbli__sort_order',
	gbliusowd_fk_gbli.`disabled_flag` AS 'gbliusowd_fk_gbli__disabled_flag',

	gbliusowd_fk_fmfiles.`id` AS 'gbliusowd_fk_fmfiles__file_manager_file_id',
	gbliusowd_fk_fmfiles.`user_company_id` AS 'gbliusowd_fk_fmfiles__user_company_id',
	gbliusowd_fk_fmfiles.`contact_id` AS 'gbliusowd_fk_fmfiles__contact_id',
	gbliusowd_fk_fmfiles.`project_id` AS 'gbliusowd_fk_fmfiles__project_id',
	gbliusowd_fk_fmfiles.`file_manager_folder_id` AS 'gbliusowd_fk_fmfiles__file_manager_folder_id',
	gbliusowd_fk_fmfiles.`file_location_id` AS 'gbliusowd_fk_fmfiles__file_location_id',
	gbliusowd_fk_fmfiles.`virtual_file_name` AS 'gbliusowd_fk_fmfiles__virtual_file_name',
	gbliusowd_fk_fmfiles.`version_number` AS 'gbliusowd_fk_fmfiles__version_number',
	gbliusowd_fk_fmfiles.`virtual_file_name_sha1` AS 'gbliusowd_fk_fmfiles__virtual_file_name_sha1',
	gbliusowd_fk_fmfiles.`virtual_file_mime_type` AS 'gbliusowd_fk_fmfiles__virtual_file_mime_type',
	gbliusowd_fk_fmfiles.`modified` AS 'gbliusowd_fk_fmfiles__modified',
	gbliusowd_fk_fmfiles.`created` AS 'gbliusowd_fk_fmfiles__created',
	gbliusowd_fk_fmfiles.`deleted_flag` AS 'gbliusowd_fk_fmfiles__deleted_flag',
	gbliusowd_fk_fmfiles.`directly_deleted_flag` AS 'gbliusowd_fk_fmfiles__directly_deleted_flag',

	gbliusowd.*

FROM `gc_budget_line_item_unsigned_scope_of_work_documents` gbliusowd
	INNER JOIN `gc_budget_line_items` gbliusowd_fk_gbli ON gbliusowd.`gc_budget_line_item_id` = gbliusowd_fk_gbli.`id`
	LEFT OUTER JOIN `file_manager_files` gbliusowd_fk_fmfiles ON gbliusowd.`unsigned_scope_of_work_document_file_manager_file_id` = gbliusowd_fk_fmfiles.`id`
WHERE gbliusowd.`id` = ?
";
		$arrValues = array($gc_budget_line_item_unsigned_scope_of_work_document_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$gc_budget_line_item_unsigned_scope_of_work_document_id = $row['id'];
			$gcBudgetLineItemUnsignedScopeOfWorkDocument = self::instantiateOrm($database, 'GcBudgetLineItemUnsignedScopeOfWorkDocument', $row, null, $gc_budget_line_item_unsigned_scope_of_work_document_id);
			/* @var $gcBudgetLineItemUnsignedScopeOfWorkDocument GcBudgetLineItemUnsignedScopeOfWorkDocument */
			$gcBudgetLineItemUnsignedScopeOfWorkDocument->convertPropertiesToData();

			if (isset($row['gc_budget_line_item_id'])) {
				$gc_budget_line_item_id = $row['gc_budget_line_item_id'];
				$row['gbliusowd_fk_gbli__id'] = $gc_budget_line_item_id;
				$gcBudgetLineItem = self::instantiateOrm($database, 'GcBudgetLineItem', $row, null, $gc_budget_line_item_id, 'gbliusowd_fk_gbli__');
				/* @var $gcBudgetLineItem GcBudgetLineItem */
				$gcBudgetLineItem->convertPropertiesToData();
			} else {
				$gcBudgetLineItem = false;
			}
			$gcBudgetLineItemUnsignedScopeOfWorkDocument->setGcBudgetLineItem($gcBudgetLineItem);

			if (isset($row['unsigned_scope_of_work_document_file_manager_file_id'])) {
				$unsigned_scope_of_work_document_file_manager_file_id = $row['unsigned_scope_of_work_document_file_manager_file_id'];
				$row['gbliusowd_fk_fmfiles__id'] = $unsigned_scope_of_work_document_file_manager_file_id;
				$unsignedScopeOfWorkDocumentFileManagerFile = self::instantiateOrm($database, 'FileManagerFile', $row, null, $unsigned_scope_of_work_document_file_manager_file_id, 'gbliusowd_fk_fmfiles__');
				/* @var $unsignedScopeOfWorkDocumentFileManagerFile FileManagerFile */
				$unsignedScopeOfWorkDocumentFileManagerFile->convertPropertiesToData();
			} else {
				$unsignedScopeOfWorkDocumentFileManagerFile = false;
			}
			$gcBudgetLineItemUnsignedScopeOfWorkDocument->setUnsignedScopeOfWorkDocumentFileManagerFile($unsignedScopeOfWorkDocumentFileManagerFile);

			return $gcBudgetLineItemUnsignedScopeOfWorkDocument;
		} else {
			return false;
		}
	}

	// Finders: Find By Unique Index
	/**
	 * Find by unique index `unique_gc_budget_line_item_unsigned_scope_of_work_documents` (`gc_budget_line_item_id`,`unsigned_scope_of_work_document_sequence_number`).
	 *
	 * @param string $database
	 * @param int $gc_budget_line_item_id
	 * @param int $unsigned_scope_of_work_document_sequence_number
	 * @return mixed (single ORM object | false)
	 */
	public static function findByGcBudgetLineItemIdAndUnsignedScopeOfWorkDocumentSequenceNumber($database, $gc_budget_line_item_id, $unsigned_scope_of_work_document_sequence_number)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	gbliusowd.*

FROM `gc_budget_line_item_unsigned_scope_of_work_documents` gbliusowd
WHERE gbliusowd.`gc_budget_line_item_id` = ?
AND gbliusowd.`unsigned_scope_of_work_document_sequence_number` = ?
";
		$arrValues = array($gc_budget_line_item_id, $unsigned_scope_of_work_document_sequence_number);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if ($row && !empty($row)) {
			$gc_budget_line_item_unsigned_scope_of_work_document_id = $row['id'];
			$gcBudgetLineItemUnsignedScopeOfWorkDocument = self::instantiateOrm($database, 'GcBudgetLineItemUnsignedScopeOfWorkDocument', $row, null, $gc_budget_line_item_unsigned_scope_of_work_document_id);
			/* @var $gcBudgetLineItemUnsignedScopeOfWorkDocument GcBudgetLineItemUnsignedScopeOfWorkDocument */
			return $gcBudgetLineItemUnsignedScopeOfWorkDocument;
		} else {
			return false;
		}
	}

	// Loaders: Load By pk List (list of auto int ids or other non auto int pk list)
	/**
	 * Load zero or more records by an id list (array of auto int primary keys).
	 *
	 * @param string $database
	 * @param array $arrGcBudgetLineItemUnsignedScopeOfWorkDocumentIds
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadGcBudgetLineItemUnsignedScopeOfWorkDocumentsByArrGcBudgetLineItemUnsignedScopeOfWorkDocumentIds($database, $arrGcBudgetLineItemUnsignedScopeOfWorkDocumentIds, Input $options=null)
	{
		if (empty($arrGcBudgetLineItemUnsignedScopeOfWorkDocumentIds)) {
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
		// ORDER BY `id` ASC, `gc_budget_line_item_id` ASC, `unsigned_scope_of_work_document_sequence_number` ASC, `unsigned_scope_of_work_document_file_manager_file_id` ASC, `unsigned_scope_of_work_document_file_sha1` ASC, `created` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY gbliusowd.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpGcBudgetLineItemUnsignedScopeOfWorkDocument = new GcBudgetLineItemUnsignedScopeOfWorkDocument($database);
			$sqlOrderByColumns = $tmpGcBudgetLineItemUnsignedScopeOfWorkDocument->constructSqlOrderByColumns($arrOrderByAttributes);

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

		foreach ($arrGcBudgetLineItemUnsignedScopeOfWorkDocumentIds as $k => $gc_budget_line_item_unsigned_scope_of_work_document_id) {
			$gc_budget_line_item_unsigned_scope_of_work_document_id = (int) $gc_budget_line_item_unsigned_scope_of_work_document_id;
			$arrGcBudgetLineItemUnsignedScopeOfWorkDocumentIds[$k] = $db->escape($gc_budget_line_item_unsigned_scope_of_work_document_id);
		}
		$csvGcBudgetLineItemUnsignedScopeOfWorkDocumentIds = join(',', $arrGcBudgetLineItemUnsignedScopeOfWorkDocumentIds);

		$query =
"
SELECT

	gbliusowd_fk_gbli.`id` AS 'gbliusowd_fk_gbli__gc_budget_line_item_id',
	gbliusowd_fk_gbli.`user_company_id` AS 'gbliusowd_fk_gbli__user_company_id',
	gbliusowd_fk_gbli.`project_id` AS 'gbliusowd_fk_gbli__project_id',
	gbliusowd_fk_gbli.`cost_code_id` AS 'gbliusowd_fk_gbli__cost_code_id',
	gbliusowd_fk_gbli.`modified` AS 'gbliusowd_fk_gbli__modified',
	gbliusowd_fk_gbli.`prime_contract_scheduled_value` AS 'gbliusowd_fk_gbli__prime_contract_scheduled_value',
	gbliusowd_fk_gbli.`forecasted_expenses` AS 'gbliusowd_fk_gbli__forecasted_expenses',
	gbliusowd_fk_gbli.`created` AS 'gbliusowd_fk_gbli__created',
	gbliusowd_fk_gbli.`sort_order` AS 'gbliusowd_fk_gbli__sort_order',
	gbliusowd_fk_gbli.`disabled_flag` AS 'gbliusowd_fk_gbli__disabled_flag',

	gbliusowd_fk_fmfiles.`id` AS 'gbliusowd_fk_fmfiles__file_manager_file_id',
	gbliusowd_fk_fmfiles.`user_company_id` AS 'gbliusowd_fk_fmfiles__user_company_id',
	gbliusowd_fk_fmfiles.`contact_id` AS 'gbliusowd_fk_fmfiles__contact_id',
	gbliusowd_fk_fmfiles.`project_id` AS 'gbliusowd_fk_fmfiles__project_id',
	gbliusowd_fk_fmfiles.`file_manager_folder_id` AS 'gbliusowd_fk_fmfiles__file_manager_folder_id',
	gbliusowd_fk_fmfiles.`file_location_id` AS 'gbliusowd_fk_fmfiles__file_location_id',
	gbliusowd_fk_fmfiles.`virtual_file_name` AS 'gbliusowd_fk_fmfiles__virtual_file_name',
	gbliusowd_fk_fmfiles.`version_number` AS 'gbliusowd_fk_fmfiles__version_number',
	gbliusowd_fk_fmfiles.`virtual_file_name_sha1` AS 'gbliusowd_fk_fmfiles__virtual_file_name_sha1',
	gbliusowd_fk_fmfiles.`virtual_file_mime_type` AS 'gbliusowd_fk_fmfiles__virtual_file_mime_type',
	gbliusowd_fk_fmfiles.`modified` AS 'gbliusowd_fk_fmfiles__modified',
	gbliusowd_fk_fmfiles.`created` AS 'gbliusowd_fk_fmfiles__created',
	gbliusowd_fk_fmfiles.`deleted_flag` AS 'gbliusowd_fk_fmfiles__deleted_flag',
	gbliusowd_fk_fmfiles.`directly_deleted_flag` AS 'gbliusowd_fk_fmfiles__directly_deleted_flag',

	gbliusowd.*

FROM `gc_budget_line_item_unsigned_scope_of_work_documents` gbliusowd
	INNER JOIN `gc_budget_line_items` gbliusowd_fk_gbli ON gbliusowd.`gc_budget_line_item_id` = gbliusowd_fk_gbli.`id`
	LEFT OUTER JOIN `file_manager_files` gbliusowd_fk_fmfiles ON gbliusowd.`unsigned_scope_of_work_document_file_manager_file_id` = gbliusowd_fk_fmfiles.`id`
WHERE gbliusowd.`id` IN ($csvGcBudgetLineItemUnsignedScopeOfWorkDocumentIds){$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrGcBudgetLineItemUnsignedScopeOfWorkDocumentsByCsvGcBudgetLineItemUnsignedScopeOfWorkDocumentIds = array();
		while ($row = $db->fetch()) {
			$gc_budget_line_item_unsigned_scope_of_work_document_id = $row['id'];
			$gcBudgetLineItemUnsignedScopeOfWorkDocument = self::instantiateOrm($database, 'GcBudgetLineItemUnsignedScopeOfWorkDocument', $row, null, $gc_budget_line_item_unsigned_scope_of_work_document_id);
			/* @var $gcBudgetLineItemUnsignedScopeOfWorkDocument GcBudgetLineItemUnsignedScopeOfWorkDocument */
			$gcBudgetLineItemUnsignedScopeOfWorkDocument->convertPropertiesToData();

			if (isset($row['gc_budget_line_item_id'])) {
				$gc_budget_line_item_id = $row['gc_budget_line_item_id'];
				$row['gbliusowd_fk_gbli__id'] = $gc_budget_line_item_id;
				$gcBudgetLineItem = self::instantiateOrm($database, 'GcBudgetLineItem', $row, null, $gc_budget_line_item_id, 'gbliusowd_fk_gbli__');
				/* @var $gcBudgetLineItem GcBudgetLineItem */
				$gcBudgetLineItem->convertPropertiesToData();
			} else {
				$gcBudgetLineItem = false;
			}
			$gcBudgetLineItemUnsignedScopeOfWorkDocument->setGcBudgetLineItem($gcBudgetLineItem);

			if (isset($row['unsigned_scope_of_work_document_file_manager_file_id'])) {
				$unsigned_scope_of_work_document_file_manager_file_id = $row['unsigned_scope_of_work_document_file_manager_file_id'];
				$row['gbliusowd_fk_fmfiles__id'] = $unsigned_scope_of_work_document_file_manager_file_id;
				$unsignedScopeOfWorkDocumentFileManagerFile = self::instantiateOrm($database, 'FileManagerFile', $row, null, $unsigned_scope_of_work_document_file_manager_file_id, 'gbliusowd_fk_fmfiles__');
				/* @var $unsignedScopeOfWorkDocumentFileManagerFile FileManagerFile */
				$unsignedScopeOfWorkDocumentFileManagerFile->convertPropertiesToData();
			} else {
				$unsignedScopeOfWorkDocumentFileManagerFile = false;
			}
			$gcBudgetLineItemUnsignedScopeOfWorkDocument->setUnsignedScopeOfWorkDocumentFileManagerFile($unsignedScopeOfWorkDocumentFileManagerFile);

			$arrGcBudgetLineItemUnsignedScopeOfWorkDocumentsByCsvGcBudgetLineItemUnsignedScopeOfWorkDocumentIds[$gc_budget_line_item_unsigned_scope_of_work_document_id] = $gcBudgetLineItemUnsignedScopeOfWorkDocument;
		}

		$db->free_result();

		return $arrGcBudgetLineItemUnsignedScopeOfWorkDocumentsByCsvGcBudgetLineItemUnsignedScopeOfWorkDocumentIds;
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `gc_budget_line_item_unsigned_scope_of_work_documents_fk_gbli` foreign key (`gc_budget_line_item_id`) references `gc_budget_line_items` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $gc_budget_line_item_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadGcBudgetLineItemUnsignedScopeOfWorkDocumentsByGcBudgetLineItemId($database, $gc_budget_line_item_id, Input $options=null)
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
			self::$_arrGcBudgetLineItemUnsignedScopeOfWorkDocumentsByGcBudgetLineItemId = null;
		}

		$arrGcBudgetLineItemUnsignedScopeOfWorkDocumentsByGcBudgetLineItemId = self::$_arrGcBudgetLineItemUnsignedScopeOfWorkDocumentsByGcBudgetLineItemId;
		if (isset($arrGcBudgetLineItemUnsignedScopeOfWorkDocumentsByGcBudgetLineItemId) && !empty($arrGcBudgetLineItemUnsignedScopeOfWorkDocumentsByGcBudgetLineItemId)) {
			return $arrGcBudgetLineItemUnsignedScopeOfWorkDocumentsByGcBudgetLineItemId;
		}

		$gc_budget_line_item_id = (int) $gc_budget_line_item_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `gc_budget_line_item_id` ASC, `unsigned_scope_of_work_document_sequence_number` ASC, `unsigned_scope_of_work_document_file_manager_file_id` ASC, `unsigned_scope_of_work_document_file_sha1` ASC, `created` ASC, `sort_order` ASC
		//$sqlOrderBy = "\nORDER BY `unsigned_scope_of_work_document_sequence_number` DESC";
		$sqlOrderBy = "\nORDER BY `sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpGcBudgetLineItemUnsignedScopeOfWorkDocument = new GcBudgetLineItemUnsignedScopeOfWorkDocument($database);
			$sqlOrderByColumns = $tmpGcBudgetLineItemUnsignedScopeOfWorkDocument->constructSqlOrderByColumns($arrOrderByAttributes);

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

	gbliusowd_fk_gbli.`id` AS 'gbliusowd_fk_gbli__gc_budget_line_item_id',
	gbliusowd_fk_gbli.`user_company_id` AS 'gbliusowd_fk_gbli__user_company_id',
	gbliusowd_fk_gbli.`project_id` AS 'gbliusowd_fk_gbli__project_id',
	gbliusowd_fk_gbli.`cost_code_id` AS 'gbliusowd_fk_gbli__cost_code_id',
	gbliusowd_fk_gbli.`modified` AS 'gbliusowd_fk_gbli__modified',
	gbliusowd_fk_gbli.`prime_contract_scheduled_value` AS 'gbliusowd_fk_gbli__prime_contract_scheduled_value',
	gbliusowd_fk_gbli.`forecasted_expenses` AS 'gbliusowd_fk_gbli__forecasted_expenses',
	gbliusowd_fk_gbli.`created` AS 'gbliusowd_fk_gbli__created',
	gbliusowd_fk_gbli.`sort_order` AS 'gbliusowd_fk_gbli__sort_order',
	gbliusowd_fk_gbli.`disabled_flag` AS 'gbliusowd_fk_gbli__disabled_flag',

	gbliusowd_fk_fmfiles.`id` AS 'gbliusowd_fk_fmfiles__file_manager_file_id',
	gbliusowd_fk_fmfiles.`user_company_id` AS 'gbliusowd_fk_fmfiles__user_company_id',
	gbliusowd_fk_fmfiles.`contact_id` AS 'gbliusowd_fk_fmfiles__contact_id',
	gbliusowd_fk_fmfiles.`project_id` AS 'gbliusowd_fk_fmfiles__project_id',
	gbliusowd_fk_fmfiles.`file_manager_folder_id` AS 'gbliusowd_fk_fmfiles__file_manager_folder_id',
	gbliusowd_fk_fmfiles.`file_location_id` AS 'gbliusowd_fk_fmfiles__file_location_id',
	gbliusowd_fk_fmfiles.`virtual_file_name` AS 'gbliusowd_fk_fmfiles__virtual_file_name',
	gbliusowd_fk_fmfiles.`version_number` AS 'gbliusowd_fk_fmfiles__version_number',
	gbliusowd_fk_fmfiles.`virtual_file_name_sha1` AS 'gbliusowd_fk_fmfiles__virtual_file_name_sha1',
	gbliusowd_fk_fmfiles.`virtual_file_mime_type` AS 'gbliusowd_fk_fmfiles__virtual_file_mime_type',
	gbliusowd_fk_fmfiles.`modified` AS 'gbliusowd_fk_fmfiles__modified',
	gbliusowd_fk_fmfiles.`created` AS 'gbliusowd_fk_fmfiles__created',
	gbliusowd_fk_fmfiles.`deleted_flag` AS 'gbliusowd_fk_fmfiles__deleted_flag',
	gbliusowd_fk_fmfiles.`directly_deleted_flag` AS 'gbliusowd_fk_fmfiles__directly_deleted_flag',

	gbliusowd.*

FROM `gc_budget_line_item_unsigned_scope_of_work_documents` gbliusowd
	INNER JOIN `gc_budget_line_items` gbliusowd_fk_gbli ON gbliusowd.`gc_budget_line_item_id` = gbliusowd_fk_gbli.`id`
	LEFT OUTER JOIN `file_manager_files` gbliusowd_fk_fmfiles ON gbliusowd.`unsigned_scope_of_work_document_file_manager_file_id` = gbliusowd_fk_fmfiles.`id`
WHERE gbliusowd.`gc_budget_line_item_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `gc_budget_line_item_id` ASC, `unsigned_scope_of_work_document_sequence_number` ASC, `unsigned_scope_of_work_document_file_manager_file_id` ASC, `unsigned_scope_of_work_document_file_sha1` ASC, `created` ASC, `sort_order` ASC
		$arrValues = array($gc_budget_line_item_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrGcBudgetLineItemUnsignedScopeOfWorkDocumentsByGcBudgetLineItemId = array();
		while ($row = $db->fetch()) {
			$gc_budget_line_item_unsigned_scope_of_work_document_id = $row['id'];
			$gcBudgetLineItemUnsignedScopeOfWorkDocument = self::instantiateOrm($database, 'GcBudgetLineItemUnsignedScopeOfWorkDocument', $row, null, $gc_budget_line_item_unsigned_scope_of_work_document_id);
			/* @var $gcBudgetLineItemUnsignedScopeOfWorkDocument GcBudgetLineItemUnsignedScopeOfWorkDocument */
			$gcBudgetLineItemUnsignedScopeOfWorkDocument->convertPropertiesToData();

			if (isset($row['gc_budget_line_item_id'])) {
				$gc_budget_line_item_id = $row['gc_budget_line_item_id'];
				$row['gbliusowd_fk_gbli__id'] = $gc_budget_line_item_id;
				$gcBudgetLineItem = self::instantiateOrm($database, 'GcBudgetLineItem', $row, null, $gc_budget_line_item_id, 'gbliusowd_fk_gbli__');
				/* @var $gcBudgetLineItem GcBudgetLineItem */
				$gcBudgetLineItem->convertPropertiesToData();
			} else {
				$gcBudgetLineItem = false;
			}
			$gcBudgetLineItemUnsignedScopeOfWorkDocument->setGcBudgetLineItem($gcBudgetLineItem);

			if (isset($row['unsigned_scope_of_work_document_file_manager_file_id'])) {
				$unsigned_scope_of_work_document_file_manager_file_id = $row['unsigned_scope_of_work_document_file_manager_file_id'];
				$row['gbliusowd_fk_fmfiles__id'] = $unsigned_scope_of_work_document_file_manager_file_id;
				$unsignedScopeOfWorkDocumentFileManagerFile = self::instantiateOrm($database, 'FileManagerFile', $row, null, $unsigned_scope_of_work_document_file_manager_file_id, 'gbliusowd_fk_fmfiles__');
				/* @var $unsignedScopeOfWorkDocumentFileManagerFile FileManagerFile */
				$unsignedScopeOfWorkDocumentFileManagerFile->convertPropertiesToData();
			} else {
				$unsignedScopeOfWorkDocumentFileManagerFile = false;
			}
			$gcBudgetLineItemUnsignedScopeOfWorkDocument->setUnsignedScopeOfWorkDocumentFileManagerFile($unsignedScopeOfWorkDocumentFileManagerFile);

			$arrGcBudgetLineItemUnsignedScopeOfWorkDocumentsByGcBudgetLineItemId[$gc_budget_line_item_unsigned_scope_of_work_document_id] = $gcBudgetLineItemUnsignedScopeOfWorkDocument;
		}

		$db->free_result();

		self::$_arrGcBudgetLineItemUnsignedScopeOfWorkDocumentsByGcBudgetLineItemId = $arrGcBudgetLineItemUnsignedScopeOfWorkDocumentsByGcBudgetLineItemId;

		return $arrGcBudgetLineItemUnsignedScopeOfWorkDocumentsByGcBudgetLineItemId;
	}

	/**
	 * Load by constraint `gc_budget_line_item_unsigned_scope_of_work_documents_fk_fmfiles` foreign key (`unsigned_scope_of_work_document_file_manager_file_id`) references `file_manager_files` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $unsigned_scope_of_work_document_file_manager_file_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadGcBudgetLineItemUnsignedScopeOfWorkDocumentsByUnsignedScopeOfWorkDocumentFileManagerFileId($database, $unsigned_scope_of_work_document_file_manager_file_id, Input $options=null)
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
			self::$_arrGcBudgetLineItemUnsignedScopeOfWorkDocumentsByUnsignedScopeOfWorkDocumentFileManagerFileId = null;
		}

		$arrGcBudgetLineItemUnsignedScopeOfWorkDocumentsByUnsignedScopeOfWorkDocumentFileManagerFileId = self::$_arrGcBudgetLineItemUnsignedScopeOfWorkDocumentsByUnsignedScopeOfWorkDocumentFileManagerFileId;
		if (isset($arrGcBudgetLineItemUnsignedScopeOfWorkDocumentsByUnsignedScopeOfWorkDocumentFileManagerFileId) && !empty($arrGcBudgetLineItemUnsignedScopeOfWorkDocumentsByUnsignedScopeOfWorkDocumentFileManagerFileId)) {
			return $arrGcBudgetLineItemUnsignedScopeOfWorkDocumentsByUnsignedScopeOfWorkDocumentFileManagerFileId;
		}

		$unsigned_scope_of_work_document_file_manager_file_id = (int) $unsigned_scope_of_work_document_file_manager_file_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `gc_budget_line_item_id` ASC, `unsigned_scope_of_work_document_sequence_number` ASC, `unsigned_scope_of_work_document_file_manager_file_id` ASC, `unsigned_scope_of_work_document_file_sha1` ASC, `created` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY gbliusowd.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpGcBudgetLineItemUnsignedScopeOfWorkDocument = new GcBudgetLineItemUnsignedScopeOfWorkDocument($database);
			$sqlOrderByColumns = $tmpGcBudgetLineItemUnsignedScopeOfWorkDocument->constructSqlOrderByColumns($arrOrderByAttributes);

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
	gbliusowd.*

FROM `gc_budget_line_item_unsigned_scope_of_work_documents` gbliusowd
WHERE gbliusowd.`unsigned_scope_of_work_document_file_manager_file_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `gc_budget_line_item_id` ASC, `unsigned_scope_of_work_document_sequence_number` ASC, `unsigned_scope_of_work_document_file_manager_file_id` ASC, `unsigned_scope_of_work_document_file_sha1` ASC, `created` ASC, `sort_order` ASC
		$arrValues = array($unsigned_scope_of_work_document_file_manager_file_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrGcBudgetLineItemUnsignedScopeOfWorkDocumentsByUnsignedScopeOfWorkDocumentFileManagerFileId = array();
		while ($row = $db->fetch()) {
			$gc_budget_line_item_unsigned_scope_of_work_document_id = $row['id'];
			$gcBudgetLineItemUnsignedScopeOfWorkDocument = self::instantiateOrm($database, 'GcBudgetLineItemUnsignedScopeOfWorkDocument', $row, null, $gc_budget_line_item_unsigned_scope_of_work_document_id);
			/* @var $gcBudgetLineItemUnsignedScopeOfWorkDocument GcBudgetLineItemUnsignedScopeOfWorkDocument */
			$arrGcBudgetLineItemUnsignedScopeOfWorkDocumentsByUnsignedScopeOfWorkDocumentFileManagerFileId[$gc_budget_line_item_unsigned_scope_of_work_document_id] = $gcBudgetLineItemUnsignedScopeOfWorkDocument;
		}

		$db->free_result();

		self::$_arrGcBudgetLineItemUnsignedScopeOfWorkDocumentsByUnsignedScopeOfWorkDocumentFileManagerFileId = $arrGcBudgetLineItemUnsignedScopeOfWorkDocumentsByUnsignedScopeOfWorkDocumentFileManagerFileId;

		return $arrGcBudgetLineItemUnsignedScopeOfWorkDocumentsByUnsignedScopeOfWorkDocumentFileManagerFileId;
	}

	// Loaders: Load By index
	/**
	 * Load by key `unsigned_scope_of_work_document_file_sha1` (`unsigned_scope_of_work_document_file_sha1`).
	 *
	 * @param string $database
	 * @param string $unsigned_scope_of_work_document_file_sha1
	 * @param mixed (Input $options object | null)
	 * @return mixed (single ORM object | false)
	 */
	public static function loadGcBudgetLineItemUnsignedScopeOfWorkDocumentsByUnsignedScopeOfWorkDocumentFileSha1($database, $unsigned_scope_of_work_document_file_sha1, Input $options=null)
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
			self::$_arrGcBudgetLineItemUnsignedScopeOfWorkDocumentsByUnsignedScopeOfWorkDocumentFileSha1 = null;
		}

		$arrGcBudgetLineItemUnsignedScopeOfWorkDocumentsByUnsignedScopeOfWorkDocumentFileSha1 = self::$_arrGcBudgetLineItemUnsignedScopeOfWorkDocumentsByUnsignedScopeOfWorkDocumentFileSha1;
		if (isset($arrGcBudgetLineItemUnsignedScopeOfWorkDocumentsByUnsignedScopeOfWorkDocumentFileSha1) && !empty($arrGcBudgetLineItemUnsignedScopeOfWorkDocumentsByUnsignedScopeOfWorkDocumentFileSha1)) {
			return $arrGcBudgetLineItemUnsignedScopeOfWorkDocumentsByUnsignedScopeOfWorkDocumentFileSha1;
		}

		$unsigned_scope_of_work_document_file_sha1 = (string) $unsigned_scope_of_work_document_file_sha1;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `gc_budget_line_item_id` ASC, `unsigned_scope_of_work_document_sequence_number` ASC, `unsigned_scope_of_work_document_file_manager_file_id` ASC, `unsigned_scope_of_work_document_file_sha1` ASC, `created` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY gbliusowd.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpGcBudgetLineItemUnsignedScopeOfWorkDocument = new GcBudgetLineItemUnsignedScopeOfWorkDocument($database);
			$sqlOrderByColumns = $tmpGcBudgetLineItemUnsignedScopeOfWorkDocument->constructSqlOrderByColumns($arrOrderByAttributes);

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
	gbliusowd.*

FROM `gc_budget_line_item_unsigned_scope_of_work_documents` gbliusowd
WHERE gbliusowd.`unsigned_scope_of_work_document_file_sha1` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `gc_budget_line_item_id` ASC, `unsigned_scope_of_work_document_sequence_number` ASC, `unsigned_scope_of_work_document_file_manager_file_id` ASC, `unsigned_scope_of_work_document_file_sha1` ASC, `created` ASC, `sort_order` ASC
		$arrValues = array($unsigned_scope_of_work_document_file_sha1);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrGcBudgetLineItemUnsignedScopeOfWorkDocumentsByUnsignedScopeOfWorkDocumentFileSha1 = array();
		while ($row = $db->fetch()) {
			$gc_budget_line_item_unsigned_scope_of_work_document_id = $row['id'];
			$gcBudgetLineItemUnsignedScopeOfWorkDocument = self::instantiateOrm($database, 'GcBudgetLineItemUnsignedScopeOfWorkDocument', $row, null, $gc_budget_line_item_unsigned_scope_of_work_document_id);
			/* @var $gcBudgetLineItemUnsignedScopeOfWorkDocument GcBudgetLineItemUnsignedScopeOfWorkDocument */
			$arrGcBudgetLineItemUnsignedScopeOfWorkDocumentsByUnsignedScopeOfWorkDocumentFileSha1[$gc_budget_line_item_unsigned_scope_of_work_document_id] = $gcBudgetLineItemUnsignedScopeOfWorkDocument;
		}

		$db->free_result();

		self::$_arrGcBudgetLineItemUnsignedScopeOfWorkDocumentsByUnsignedScopeOfWorkDocumentFileSha1 = $arrGcBudgetLineItemUnsignedScopeOfWorkDocumentsByUnsignedScopeOfWorkDocumentFileSha1;

		return $arrGcBudgetLineItemUnsignedScopeOfWorkDocumentsByUnsignedScopeOfWorkDocumentFileSha1;
	}

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all gc_budget_line_item_unsigned_scope_of_work_documents records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllGcBudgetLineItemUnsignedScopeOfWorkDocuments($database, Input $options=null)
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
			self::$_arrAllGcBudgetLineItemUnsignedScopeOfWorkDocuments = null;
		}

		$arrAllGcBudgetLineItemUnsignedScopeOfWorkDocuments = self::$_arrAllGcBudgetLineItemUnsignedScopeOfWorkDocuments;
		if (isset($arrAllGcBudgetLineItemUnsignedScopeOfWorkDocuments) && !empty($arrAllGcBudgetLineItemUnsignedScopeOfWorkDocuments)) {
			return $arrAllGcBudgetLineItemUnsignedScopeOfWorkDocuments;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `gc_budget_line_item_id` ASC, `unsigned_scope_of_work_document_sequence_number` ASC, `unsigned_scope_of_work_document_file_manager_file_id` ASC, `unsigned_scope_of_work_document_file_sha1` ASC, `created` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY gbliusowd.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpGcBudgetLineItemUnsignedScopeOfWorkDocument = new GcBudgetLineItemUnsignedScopeOfWorkDocument($database);
			$sqlOrderByColumns = $tmpGcBudgetLineItemUnsignedScopeOfWorkDocument->constructSqlOrderByColumns($arrOrderByAttributes);

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
	gbliusowd.*

FROM `gc_budget_line_item_unsigned_scope_of_work_documents` gbliusowd{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `gc_budget_line_item_id` ASC, `unsigned_scope_of_work_document_sequence_number` ASC, `unsigned_scope_of_work_document_file_manager_file_id` ASC, `unsigned_scope_of_work_document_file_sha1` ASC, `created` ASC, `sort_order` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllGcBudgetLineItemUnsignedScopeOfWorkDocuments = array();
		while ($row = $db->fetch()) {
			$gc_budget_line_item_unsigned_scope_of_work_document_id = $row['id'];
			$gcBudgetLineItemUnsignedScopeOfWorkDocument = self::instantiateOrm($database, 'GcBudgetLineItemUnsignedScopeOfWorkDocument', $row, null, $gc_budget_line_item_unsigned_scope_of_work_document_id);
			/* @var $gcBudgetLineItemUnsignedScopeOfWorkDocument GcBudgetLineItemUnsignedScopeOfWorkDocument */
			$arrAllGcBudgetLineItemUnsignedScopeOfWorkDocuments[$gc_budget_line_item_unsigned_scope_of_work_document_id] = $gcBudgetLineItemUnsignedScopeOfWorkDocument;
		}

		$db->free_result();

		self::$_arrAllGcBudgetLineItemUnsignedScopeOfWorkDocuments = $arrAllGcBudgetLineItemUnsignedScopeOfWorkDocuments;

		return $arrAllGcBudgetLineItemUnsignedScopeOfWorkDocuments;
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
INTO `gc_budget_line_item_unsigned_scope_of_work_documents`
(`gc_budget_line_item_id`, `unsigned_scope_of_work_document_sequence_number`, `unsigned_scope_of_work_document_file_manager_file_id`, `unsigned_scope_of_work_document_file_sha1`, `created`, `sort_order`)
VALUES (?, ?, ?, ?, ?, ?)
ON DUPLICATE KEY UPDATE `unsigned_scope_of_work_document_file_manager_file_id` = ?, `unsigned_scope_of_work_document_file_sha1` = ?, `created` = ?, `sort_order` = ?
";
		$arrValues = array($this->gc_budget_line_item_id, $this->unsigned_scope_of_work_document_sequence_number, $this->unsigned_scope_of_work_document_file_manager_file_id, $this->unsigned_scope_of_work_document_file_sha1, $this->created, $this->sort_order, $this->unsigned_scope_of_work_document_file_manager_file_id, $this->unsigned_scope_of_work_document_file_sha1, $this->created, $this->sort_order);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$gc_budget_line_item_unsigned_scope_of_work_document_id = $db->insertId;
		$db->free_result();

		return $gc_budget_line_item_unsigned_scope_of_work_document_id;
	}

	// Save: insert ignore

	public static function findNextGcBudgetLineItemUnsignedScopeOfWorkDocumentSequenceNumber($database, $gc_budget_line_item_id)
	{
		$next_unsigned_scope_of_work_document_sequence_number = 1;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT MAX(`unsigned_scope_of_work_document_sequence_number`) AS 'max_unsigned_scope_of_work_document_sequence_number'
FROM `gc_budget_line_item_unsigned_scope_of_work_documents`
WHERE `gc_budget_line_item_id` = ?
";
		$arrValues = array($gc_budget_line_item_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$max_unsigned_scope_of_work_document_sequence_number = $row['max_unsigned_scope_of_work_document_sequence_number'];
			$next_unsigned_scope_of_work_document_sequence_number = $max_unsigned_scope_of_work_document_sequence_number + 1;
		}

		return $next_unsigned_scope_of_work_document_sequence_number;
	}
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

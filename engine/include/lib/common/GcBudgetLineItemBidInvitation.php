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
 * GcBudgetLineItemBidInvitation.
 *
 * @category   Framework
 * @package    GcBudgetLineItemBidInvitation
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class GcBudgetLineItemBidInvitation extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'GcBudgetLineItemBidInvitation';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'gc_budget_line_item_bid_invitations';

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
	 * unique index `unique_gc_budget_line_item_bid_invitations` (`gc_budget_line_item_id`,`gc_budget_line_item_bid_invitation_sequence_number`)
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_gc_budget_line_item_bid_invitations' => array(
			'gc_budget_line_item_id' => 'int',
			'gc_budget_line_item_bid_invitation_sequence_number' => 'int'
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
		'id' => 'gc_budget_line_item_bid_invitation_id',

		'gc_budget_line_item_id' => 'gc_budget_line_item_id',
		'gc_budget_line_item_bid_invitation_sequence_number' => 'gc_budget_line_item_bid_invitation_sequence_number',

		'gc_budget_line_item_bid_invitation_file_manager_file_id' => 'gc_budget_line_item_bid_invitation_file_manager_file_id',

		'gc_budget_line_item_bid_invitation_file_sha1' => 'gc_budget_line_item_bid_invitation_file_sha1',
		'created' => 'created',
		'sort_order' => 'sort_order'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $gc_budget_line_item_bid_invitation_id;

	public $gc_budget_line_item_id;
	public $gc_budget_line_item_bid_invitation_sequence_number;

	public $gc_budget_line_item_bid_invitation_file_manager_file_id;

	public $gc_budget_line_item_bid_invitation_file_sha1;
	public $created;
	public $sort_order;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties
	public $escaped_gc_budget_line_item_bid_invitation_file_sha1;

	// HTML ENTITY ENCODED NL2BR ORM string properties
	public $escaped_gc_budget_line_item_bid_invitation_file_sha1_nl2br;

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)
	protected static $_arrGcBudgetLineItemBidInvitationsByGcBudgetLineItemId;
	protected static $_arrGcBudgetLineItemBidInvitationsByGcBudgetLineItemBidInvitationFileManagerFileId;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)
	protected static $_arrGcBudgetLineItemBidInvitationsByGcBudgetLineItemBidInvitationFileSha1;

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllGcBudgetLineItemBidInvitations;

	// Foreign Key Objects
	private $_gcBudgetLineItem;
	private $_gcBudgetLineItemBidInvitationFileManagerFile;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='gc_budget_line_item_bid_invitations')
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

	public function getGcBudgetLineItemBidInvitationFileManagerFile()
	{
		if (isset($this->_gcBudgetLineItemBidInvitationFileManagerFile)) {
			return $this->_gcBudgetLineItemBidInvitationFileManagerFile;
		} else {
			return null;
		}
	}

	public function setGcBudgetLineItemBidInvitationFileManagerFile($gcBudgetLineItemBidInvitationFileManagerFile)
	{
		$this->_gcBudgetLineItemBidInvitationFileManagerFile = $gcBudgetLineItemBidInvitationFileManagerFile;
	}

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)
	public static function getArrGcBudgetLineItemBidInvitationsByGcBudgetLineItemId()
	{
		if (isset(self::$_arrGcBudgetLineItemBidInvitationsByGcBudgetLineItemId)) {
			return self::$_arrGcBudgetLineItemBidInvitationsByGcBudgetLineItemId;
		} else {
			return null;
		}
	}

	public static function setArrGcBudgetLineItemBidInvitationsByGcBudgetLineItemId($arrGcBudgetLineItemBidInvitationsByGcBudgetLineItemId)
	{
		self::$_arrGcBudgetLineItemBidInvitationsByGcBudgetLineItemId = $arrGcBudgetLineItemBidInvitationsByGcBudgetLineItemId;
	}

	public static function getArrGcBudgetLineItemBidInvitationsByGcBudgetLineItemBidInvitationFileManagerFileId()
	{
		if (isset(self::$_arrGcBudgetLineItemBidInvitationsByGcBudgetLineItemBidInvitationFileManagerFileId)) {
			return self::$_arrGcBudgetLineItemBidInvitationsByGcBudgetLineItemBidInvitationFileManagerFileId;
		} else {
			return null;
		}
	}

	public static function setArrGcBudgetLineItemBidInvitationsByGcBudgetLineItemBidInvitationFileManagerFileId($arrGcBudgetLineItemBidInvitationsByGcBudgetLineItemBidInvitationFileManagerFileId)
	{
		self::$_arrGcBudgetLineItemBidInvitationsByGcBudgetLineItemBidInvitationFileManagerFileId = $arrGcBudgetLineItemBidInvitationsByGcBudgetLineItemBidInvitationFileManagerFileId;
	}

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)
	public static function getArrGcBudgetLineItemBidInvitationsByGcBudgetLineItemBidInvitationFileSha1()
	{
		if (isset(self::$_arrGcBudgetLineItemBidInvitationsByGcBudgetLineItemBidInvitationFileSha1)) {
			return self::$_arrGcBudgetLineItemBidInvitationsByGcBudgetLineItemBidInvitationFileSha1;
		} else {
			return null;
		}
	}

	public static function setArrGcBudgetLineItemBidInvitationsByGcBudgetLineItemBidInvitationFileSha1($arrGcBudgetLineItemBidInvitationsByGcBudgetLineItemBidInvitationFileSha1)
	{
		self::$_arrGcBudgetLineItemBidInvitationsByGcBudgetLineItemBidInvitationFileSha1 = $arrGcBudgetLineItemBidInvitationsByGcBudgetLineItemBidInvitationFileSha1;
	}

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllGcBudgetLineItemBidInvitations()
	{
		if (isset(self::$_arrAllGcBudgetLineItemBidInvitations)) {
			return self::$_arrAllGcBudgetLineItemBidInvitations;
		} else {
			return null;
		}
	}

	public static function setArrAllGcBudgetLineItemBidInvitations($arrAllGcBudgetLineItemBidInvitations)
	{
		self::$_arrAllGcBudgetLineItemBidInvitations = $arrAllGcBudgetLineItemBidInvitations;
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
	 * @param int $gc_budget_line_item_bid_invitation_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findById($database, $gc_budget_line_item_bid_invitation_id, $table='gc_budget_line_item_bid_invitations', $module='GcBudgetLineItemBidInvitation')
	{
		$gcBudgetLineItemBidInvitation = parent::findById($database, $gc_budget_line_item_bid_invitation_id, $table, $module);

		return $gcBudgetLineItemBidInvitation;
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Similar to FindById, but with SQL as starter code for more complex joins.
	 *
	 * @param string $database
	 * @param int $gc_budget_line_item_bid_invitation_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findGcBudgetLineItemBidInvitationByIdExtended($database, $gc_budget_line_item_bid_invitation_id)
	{
		$gc_budget_line_item_bid_invitation_id = (int) $gc_budget_line_item_bid_invitation_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	gblibi_fk_gbli.`id` AS 'gblibi_fk_gbli__gc_budget_line_item_id',
	gblibi_fk_gbli.`user_company_id` AS 'gblibi_fk_gbli__user_company_id',
	gblibi_fk_gbli.`project_id` AS 'gblibi_fk_gbli__project_id',
	gblibi_fk_gbli.`cost_code_id` AS 'gblibi_fk_gbli__cost_code_id',
	gblibi_fk_gbli.`modified` AS 'gblibi_fk_gbli__modified',
	gblibi_fk_gbli.`prime_contract_scheduled_value` AS 'gblibi_fk_gbli__prime_contract_scheduled_value',
	gblibi_fk_gbli.`forecasted_expenses` AS 'gblibi_fk_gbli__forecasted_expenses',
	gblibi_fk_gbli.`created` AS 'gblibi_fk_gbli__created',
	gblibi_fk_gbli.`sort_order` AS 'gblibi_fk_gbli__sort_order',
	gblibi_fk_gbli.`disabled_flag` AS 'gblibi_fk_gbli__disabled_flag',

	gblibi_fk_fmfiles.`id` AS 'gblibi_fk_fmfiles__file_manager_file_id',
	gblibi_fk_fmfiles.`user_company_id` AS 'gblibi_fk_fmfiles__user_company_id',
	gblibi_fk_fmfiles.`contact_id` AS 'gblibi_fk_fmfiles__contact_id',
	gblibi_fk_fmfiles.`project_id` AS 'gblibi_fk_fmfiles__project_id',
	gblibi_fk_fmfiles.`file_manager_folder_id` AS 'gblibi_fk_fmfiles__file_manager_folder_id',
	gblibi_fk_fmfiles.`file_location_id` AS 'gblibi_fk_fmfiles__file_location_id',
	gblibi_fk_fmfiles.`virtual_file_name` AS 'gblibi_fk_fmfiles__virtual_file_name',
	gblibi_fk_fmfiles.`version_number` AS 'gblibi_fk_fmfiles__version_number',
	gblibi_fk_fmfiles.`virtual_file_name_sha1` AS 'gblibi_fk_fmfiles__virtual_file_name_sha1',
	gblibi_fk_fmfiles.`virtual_file_mime_type` AS 'gblibi_fk_fmfiles__virtual_file_mime_type',
	gblibi_fk_fmfiles.`modified` AS 'gblibi_fk_fmfiles__modified',
	gblibi_fk_fmfiles.`created` AS 'gblibi_fk_fmfiles__created',
	gblibi_fk_fmfiles.`deleted_flag` AS 'gblibi_fk_fmfiles__deleted_flag',
	gblibi_fk_fmfiles.`directly_deleted_flag` AS 'gblibi_fk_fmfiles__directly_deleted_flag',

	gblibi.*

FROM `gc_budget_line_item_bid_invitations` gblibi
	INNER JOIN `gc_budget_line_items` gblibi_fk_gbli ON gblibi.`gc_budget_line_item_id` = gblibi_fk_gbli.`id`
	LEFT OUTER JOIN `file_manager_files` gblibi_fk_fmfiles ON gblibi.`gc_budget_line_item_bid_invitation_file_manager_file_id` = gblibi_fk_fmfiles.`id`
WHERE gblibi.`id` = ?
";
		$arrValues = array($gc_budget_line_item_bid_invitation_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$gc_budget_line_item_bid_invitation_id = $row['id'];
			$gcBudgetLineItemBidInvitation = self::instantiateOrm($database, 'GcBudgetLineItemBidInvitation', $row, null, $gc_budget_line_item_bid_invitation_id);
			/* @var $gcBudgetLineItemBidInvitation GcBudgetLineItemBidInvitation */
			$gcBudgetLineItemBidInvitation->convertPropertiesToData();

			if (isset($row['gc_budget_line_item_id'])) {
				$gc_budget_line_item_id = $row['gc_budget_line_item_id'];
				$row['gblibi_fk_gbli__id'] = $gc_budget_line_item_id;
				$gcBudgetLineItem = self::instantiateOrm($database, 'GcBudgetLineItem', $row, null, $gc_budget_line_item_id, 'gblibi_fk_gbli__');
				/* @var $gcBudgetLineItem GcBudgetLineItem */
				$gcBudgetLineItem->convertPropertiesToData();
			} else {
				$gcBudgetLineItem = false;
			}
			$gcBudgetLineItemBidInvitation->setGcBudgetLineItem($gcBudgetLineItem);

			if (isset($row['gc_budget_line_item_bid_invitation_file_manager_file_id'])) {
				$gc_budget_line_item_bid_invitation_file_manager_file_id = $row['gc_budget_line_item_bid_invitation_file_manager_file_id'];
				$row['gblibi_fk_fmfiles__id'] = $gc_budget_line_item_bid_invitation_file_manager_file_id;
				$gcBudgetLineItemBidInvitationFileManagerFile = self::instantiateOrm($database, 'FileManagerFile', $row, null, $gc_budget_line_item_bid_invitation_file_manager_file_id, 'gblibi_fk_fmfiles__');
				/* @var $gcBudgetLineItemBidInvitationFileManagerFile FileManagerFile */
				$gcBudgetLineItemBidInvitationFileManagerFile->convertPropertiesToData();
			} else {
				$gcBudgetLineItemBidInvitationFileManagerFile = false;
			}
			$gcBudgetLineItemBidInvitation->setGcBudgetLineItemBidInvitationFileManagerFile($gcBudgetLineItemBidInvitationFileManagerFile);

			return $gcBudgetLineItemBidInvitation;
		} else {
			return false;
		}
	}

	// Finders: Find By Unique Index
	/**
	 * Find by unique index `unique_gc_budget_line_item_bid_invitations` (`gc_budget_line_item_id`,`gc_budget_line_item_bid_invitation_sequence_number`).
	 *
	 * @param string $database
	 * @param int $gc_budget_line_item_id
	 * @param int $gc_budget_line_item_bid_invitation_sequence_number
	 * @return mixed (single ORM object | false)
	 */
	public static function findByGcBudgetLineItemIdAndGcBudgetLineItemBidInvitationSequenceNumber($database, $gc_budget_line_item_id, $gc_budget_line_item_bid_invitation_sequence_number)
	{
		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT
	gblibi.*

FROM `gc_budget_line_item_bid_invitations` gblibi
WHERE gblibi.`gc_budget_line_item_id` = ?
AND gblibi.`gc_budget_line_item_bid_invitation_sequence_number` = ?
";
		$arrValues = array($gc_budget_line_item_id, $gc_budget_line_item_bid_invitation_sequence_number);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();
		if ($row && !empty($row)) {
			$gc_budget_line_item_bid_invitation_id = $row['id'];
			$gcBudgetLineItemBidInvitation = self::instantiateOrm($database, 'GcBudgetLineItemBidInvitation', $row, null, $gc_budget_line_item_bid_invitation_id);
			/* @var $gcBudgetLineItemBidInvitation GcBudgetLineItemBidInvitation */
			return $gcBudgetLineItemBidInvitation;
		} else {
			return false;
		}
	}

	// Loaders: Load By pk List (list of auto int ids or other non auto int pk list)
	/**
	 * Load zero or more records by an id list (array of auto int primary keys).
	 *
	 * @param string $database
	 * @param array $arrGcBudgetLineItemBidInvitationIds
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadGcBudgetLineItemBidInvitationsByArrGcBudgetLineItemBidInvitationIds($database, $arrGcBudgetLineItemBidInvitationIds, Input $options=null)
	{
		if (empty($arrGcBudgetLineItemBidInvitationIds)) {
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
		// ORDER BY `id` ASC, `gc_budget_line_item_id` ASC, `gc_budget_line_item_bid_invitation_sequence_number` ASC, `gc_budget_line_item_bid_invitation_file_manager_file_id` ASC, `gc_budget_line_item_bid_invitation_file_sha1` ASC, `created` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY gblibi.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpGcBudgetLineItemBidInvitation = new GcBudgetLineItemBidInvitation($database);
			$sqlOrderByColumns = $tmpGcBudgetLineItemBidInvitation->constructSqlOrderByColumns($arrOrderByAttributes);

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

		foreach ($arrGcBudgetLineItemBidInvitationIds as $k => $gc_budget_line_item_bid_invitation_id) {
			$gc_budget_line_item_bid_invitation_id = (int) $gc_budget_line_item_bid_invitation_id;
			$arrGcBudgetLineItemBidInvitationIds[$k] = $db->escape($gc_budget_line_item_bid_invitation_id);
		}
		$csvGcBudgetLineItemBidInvitationIds = join(',', $arrGcBudgetLineItemBidInvitationIds);

		$query =
"
SELECT

	gblibi_fk_gbli.`id` AS 'gblibi_fk_gbli__gc_budget_line_item_id',
	gblibi_fk_gbli.`user_company_id` AS 'gblibi_fk_gbli__user_company_id',
	gblibi_fk_gbli.`project_id` AS 'gblibi_fk_gbli__project_id',
	gblibi_fk_gbli.`cost_code_id` AS 'gblibi_fk_gbli__cost_code_id',
	gblibi_fk_gbli.`modified` AS 'gblibi_fk_gbli__modified',
	gblibi_fk_gbli.`prime_contract_scheduled_value` AS 'gblibi_fk_gbli__prime_contract_scheduled_value',
	gblibi_fk_gbli.`forecasted_expenses` AS 'gblibi_fk_gbli__forecasted_expenses',
	gblibi_fk_gbli.`created` AS 'gblibi_fk_gbli__created',
	gblibi_fk_gbli.`sort_order` AS 'gblibi_fk_gbli__sort_order',
	gblibi_fk_gbli.`disabled_flag` AS 'gblibi_fk_gbli__disabled_flag',

	gblibi_fk_fmfiles.`id` AS 'gblibi_fk_fmfiles__file_manager_file_id',
	gblibi_fk_fmfiles.`user_company_id` AS 'gblibi_fk_fmfiles__user_company_id',
	gblibi_fk_fmfiles.`contact_id` AS 'gblibi_fk_fmfiles__contact_id',
	gblibi_fk_fmfiles.`project_id` AS 'gblibi_fk_fmfiles__project_id',
	gblibi_fk_fmfiles.`file_manager_folder_id` AS 'gblibi_fk_fmfiles__file_manager_folder_id',
	gblibi_fk_fmfiles.`file_location_id` AS 'gblibi_fk_fmfiles__file_location_id',
	gblibi_fk_fmfiles.`virtual_file_name` AS 'gblibi_fk_fmfiles__virtual_file_name',
	gblibi_fk_fmfiles.`version_number` AS 'gblibi_fk_fmfiles__version_number',
	gblibi_fk_fmfiles.`virtual_file_name_sha1` AS 'gblibi_fk_fmfiles__virtual_file_name_sha1',
	gblibi_fk_fmfiles.`virtual_file_mime_type` AS 'gblibi_fk_fmfiles__virtual_file_mime_type',
	gblibi_fk_fmfiles.`modified` AS 'gblibi_fk_fmfiles__modified',
	gblibi_fk_fmfiles.`created` AS 'gblibi_fk_fmfiles__created',
	gblibi_fk_fmfiles.`deleted_flag` AS 'gblibi_fk_fmfiles__deleted_flag',
	gblibi_fk_fmfiles.`directly_deleted_flag` AS 'gblibi_fk_fmfiles__directly_deleted_flag',

	gblibi.*

FROM `gc_budget_line_item_bid_invitations` gblibi
	INNER JOIN `gc_budget_line_items` gblibi_fk_gbli ON gblibi.`gc_budget_line_item_id` = gblibi_fk_gbli.`id`
	LEFT OUTER JOIN `file_manager_files` gblibi_fk_fmfiles ON gblibi.`gc_budget_line_item_bid_invitation_file_manager_file_id` = gblibi_fk_fmfiles.`id`
WHERE gblibi.`id` IN ($csvGcBudgetLineItemBidInvitationIds){$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrGcBudgetLineItemBidInvitationsByCsvGcBudgetLineItemBidInvitationIds = array();
		while ($row = $db->fetch()) {
			$gc_budget_line_item_bid_invitation_id = $row['id'];
			$gcBudgetLineItemBidInvitation = self::instantiateOrm($database, 'GcBudgetLineItemBidInvitation', $row, null, $gc_budget_line_item_bid_invitation_id);
			/* @var $gcBudgetLineItemBidInvitation GcBudgetLineItemBidInvitation */
			$gcBudgetLineItemBidInvitation->convertPropertiesToData();

			if (isset($row['gc_budget_line_item_id'])) {
				$gc_budget_line_item_id = $row['gc_budget_line_item_id'];
				$row['gblibi_fk_gbli__id'] = $gc_budget_line_item_id;
				$gcBudgetLineItem = self::instantiateOrm($database, 'GcBudgetLineItem', $row, null, $gc_budget_line_item_id, 'gblibi_fk_gbli__');
				/* @var $gcBudgetLineItem GcBudgetLineItem */
				$gcBudgetLineItem->convertPropertiesToData();
			} else {
				$gcBudgetLineItem = false;
			}
			$gcBudgetLineItemBidInvitation->setGcBudgetLineItem($gcBudgetLineItem);

			if (isset($row['gc_budget_line_item_bid_invitation_file_manager_file_id'])) {
				$gc_budget_line_item_bid_invitation_file_manager_file_id = $row['gc_budget_line_item_bid_invitation_file_manager_file_id'];
				$row['gblibi_fk_fmfiles__id'] = $gc_budget_line_item_bid_invitation_file_manager_file_id;
				$gcBudgetLineItemBidInvitationFileManagerFile = self::instantiateOrm($database, 'FileManagerFile', $row, null, $gc_budget_line_item_bid_invitation_file_manager_file_id, 'gblibi_fk_fmfiles__');
				/* @var $gcBudgetLineItemBidInvitationFileManagerFile FileManagerFile */
				$gcBudgetLineItemBidInvitationFileManagerFile->convertPropertiesToData();
			} else {
				$gcBudgetLineItemBidInvitationFileManagerFile = false;
			}
			$gcBudgetLineItemBidInvitation->setGcBudgetLineItemBidInvitationFileManagerFile($gcBudgetLineItemBidInvitationFileManagerFile);

			$arrGcBudgetLineItemBidInvitationsByCsvGcBudgetLineItemBidInvitationIds[$gc_budget_line_item_bid_invitation_id] = $gcBudgetLineItemBidInvitation;
		}

		$db->free_result();

		return $arrGcBudgetLineItemBidInvitationsByCsvGcBudgetLineItemBidInvitationIds;
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `gc_budget_line_item_bid_invitations_fk_gbli` foreign key (`gc_budget_line_item_id`) references `gc_budget_line_items` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $gc_budget_line_item_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadGcBudgetLineItemBidInvitationsByGcBudgetLineItemId($database, $gc_budget_line_item_id, Input $options=null)
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
			self::$_arrGcBudgetLineItemBidInvitationsByGcBudgetLineItemId = null;
		}

		$arrGcBudgetLineItemBidInvitationsByGcBudgetLineItemId = self::$_arrGcBudgetLineItemBidInvitationsByGcBudgetLineItemId;
		if (isset($arrGcBudgetLineItemBidInvitationsByGcBudgetLineItemId) && !empty($arrGcBudgetLineItemBidInvitationsByGcBudgetLineItemId)) {
			return $arrGcBudgetLineItemBidInvitationsByGcBudgetLineItemId;
		}

		$gc_budget_line_item_id = (int) $gc_budget_line_item_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `gc_budget_line_item_id` ASC, `gc_budget_line_item_bid_invitation_sequence_number` ASC, `gc_budget_line_item_bid_invitation_file_manager_file_id` ASC, `gc_budget_line_item_bid_invitation_file_sha1` ASC, `created` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY gblibi.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpGcBudgetLineItemBidInvitation = new GcBudgetLineItemBidInvitation($database);
			$sqlOrderByColumns = $tmpGcBudgetLineItemBidInvitation->constructSqlOrderByColumns($arrOrderByAttributes);

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

	gblibi_fk_gbli.`id` AS 'gblibi_fk_gbli__gc_budget_line_item_id',
	gblibi_fk_gbli.`user_company_id` AS 'gblibi_fk_gbli__user_company_id',
	gblibi_fk_gbli.`project_id` AS 'gblibi_fk_gbli__project_id',
	gblibi_fk_gbli.`cost_code_id` AS 'gblibi_fk_gbli__cost_code_id',
	gblibi_fk_gbli.`modified` AS 'gblibi_fk_gbli__modified',
	gblibi_fk_gbli.`prime_contract_scheduled_value` AS 'gblibi_fk_gbli__prime_contract_scheduled_value',
	gblibi_fk_gbli.`forecasted_expenses` AS 'gblibi_fk_gbli__forecasted_expenses',
	gblibi_fk_gbli.`created` AS 'gblibi_fk_gbli__created',
	gblibi_fk_gbli.`sort_order` AS 'gblibi_fk_gbli__sort_order',
	gblibi_fk_gbli.`disabled_flag` AS 'gblibi_fk_gbli__disabled_flag',

	gblibi_fk_fmfiles.`id` AS 'gblibi_fk_fmfiles__file_manager_file_id',
	gblibi_fk_fmfiles.`user_company_id` AS 'gblibi_fk_fmfiles__user_company_id',
	gblibi_fk_fmfiles.`contact_id` AS 'gblibi_fk_fmfiles__contact_id',
	gblibi_fk_fmfiles.`project_id` AS 'gblibi_fk_fmfiles__project_id',
	gblibi_fk_fmfiles.`file_manager_folder_id` AS 'gblibi_fk_fmfiles__file_manager_folder_id',
	gblibi_fk_fmfiles.`file_location_id` AS 'gblibi_fk_fmfiles__file_location_id',
	gblibi_fk_fmfiles.`virtual_file_name` AS 'gblibi_fk_fmfiles__virtual_file_name',
	gblibi_fk_fmfiles.`version_number` AS 'gblibi_fk_fmfiles__version_number',
	gblibi_fk_fmfiles.`virtual_file_name_sha1` AS 'gblibi_fk_fmfiles__virtual_file_name_sha1',
	gblibi_fk_fmfiles.`virtual_file_mime_type` AS 'gblibi_fk_fmfiles__virtual_file_mime_type',
	gblibi_fk_fmfiles.`modified` AS 'gblibi_fk_fmfiles__modified',
	gblibi_fk_fmfiles.`created` AS 'gblibi_fk_fmfiles__created',
	gblibi_fk_fmfiles.`deleted_flag` AS 'gblibi_fk_fmfiles__deleted_flag',
	gblibi_fk_fmfiles.`directly_deleted_flag` AS 'gblibi_fk_fmfiles__directly_deleted_flag',

	gblibi.*

FROM `gc_budget_line_item_bid_invitations` gblibi
	INNER JOIN `gc_budget_line_items` gblibi_fk_gbli ON gblibi.`gc_budget_line_item_id` = gblibi_fk_gbli.`id`
	LEFT OUTER JOIN `file_manager_files` gblibi_fk_fmfiles ON gblibi.`gc_budget_line_item_bid_invitation_file_manager_file_id` = gblibi_fk_fmfiles.`id`
WHERE gblibi.`gc_budget_line_item_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `gc_budget_line_item_id` ASC, `gc_budget_line_item_bid_invitation_sequence_number` ASC, `gc_budget_line_item_bid_invitation_file_manager_file_id` ASC, `gc_budget_line_item_bid_invitation_file_sha1` ASC, `created` ASC, `sort_order` ASC
		$arrValues = array($gc_budget_line_item_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrGcBudgetLineItemBidInvitationsByGcBudgetLineItemId = array();
		while ($row = $db->fetch()) {
			$gc_budget_line_item_bid_invitation_id = $row['id'];
			$gcBudgetLineItemBidInvitation = self::instantiateOrm($database, 'GcBudgetLineItemBidInvitation', $row, null, $gc_budget_line_item_bid_invitation_id);
			/* @var $gcBudgetLineItemBidInvitation GcBudgetLineItemBidInvitation */
			$gcBudgetLineItemBidInvitation->convertPropertiesToData();

			if (isset($row['gc_budget_line_item_id'])) {
				$gc_budget_line_item_id = $row['gc_budget_line_item_id'];
				$row['gblibi_fk_gbli__id'] = $gc_budget_line_item_id;
				$gcBudgetLineItem = self::instantiateOrm($database, 'GcBudgetLineItem', $row, null, $gc_budget_line_item_id, 'gblibi_fk_gbli__');
				/* @var $gcBudgetLineItem GcBudgetLineItem */
				$gcBudgetLineItem->convertPropertiesToData();
			} else {
				$gcBudgetLineItem = false;
			}
			$gcBudgetLineItemBidInvitation->setGcBudgetLineItem($gcBudgetLineItem);

			if (isset($row['gc_budget_line_item_bid_invitation_file_manager_file_id'])) {
				$gc_budget_line_item_bid_invitation_file_manager_file_id = $row['gc_budget_line_item_bid_invitation_file_manager_file_id'];
				$row['gblibi_fk_fmfiles__id'] = $gc_budget_line_item_bid_invitation_file_manager_file_id;
				$gcBudgetLineItemBidInvitationFileManagerFile = self::instantiateOrm($database, 'FileManagerFile', $row, null, $gc_budget_line_item_bid_invitation_file_manager_file_id, 'gblibi_fk_fmfiles__');
				/* @var $gcBudgetLineItemBidInvitationFileManagerFile FileManagerFile */
				$gcBudgetLineItemBidInvitationFileManagerFile->convertPropertiesToData();
			} else {
				$gcBudgetLineItemBidInvitationFileManagerFile = false;
			}
			$gcBudgetLineItemBidInvitation->setGcBudgetLineItemBidInvitationFileManagerFile($gcBudgetLineItemBidInvitationFileManagerFile);

			/* @var $gcBudgetLineItemBidInvitation GcBudgetLineItemBidInvitation */
			$arrGcBudgetLineItemBidInvitationsByGcBudgetLineItemId[$gc_budget_line_item_bid_invitation_id] = $gcBudgetLineItemBidInvitation;
		}

		$db->free_result();

		self::$_arrGcBudgetLineItemBidInvitationsByGcBudgetLineItemId = $arrGcBudgetLineItemBidInvitationsByGcBudgetLineItemId;

		return $arrGcBudgetLineItemBidInvitationsByGcBudgetLineItemId;
	}

	/**
	 * Load by constraint `gc_budget_line_item_bid_invitations_fk_fmfiles` foreign key (`gc_budget_line_item_bid_invitation_file_manager_file_id`) references `file_manager_files` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $gc_budget_line_item_bid_invitation_file_manager_file_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadGcBudgetLineItemBidInvitationsByGcBudgetLineItemBidInvitationFileManagerFileId($database, $gc_budget_line_item_bid_invitation_file_manager_file_id, Input $options=null)
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
			self::$_arrGcBudgetLineItemBidInvitationsByGcBudgetLineItemBidInvitationFileManagerFileId = null;
		}

		$arrGcBudgetLineItemBidInvitationsByGcBudgetLineItemBidInvitationFileManagerFileId = self::$_arrGcBudgetLineItemBidInvitationsByGcBudgetLineItemBidInvitationFileManagerFileId;
		if (isset($arrGcBudgetLineItemBidInvitationsByGcBudgetLineItemBidInvitationFileManagerFileId) && !empty($arrGcBudgetLineItemBidInvitationsByGcBudgetLineItemBidInvitationFileManagerFileId)) {
			return $arrGcBudgetLineItemBidInvitationsByGcBudgetLineItemBidInvitationFileManagerFileId;
		}

		$gc_budget_line_item_bid_invitation_file_manager_file_id = (int) $gc_budget_line_item_bid_invitation_file_manager_file_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `gc_budget_line_item_id` ASC, `gc_budget_line_item_bid_invitation_sequence_number` ASC, `gc_budget_line_item_bid_invitation_file_manager_file_id` ASC, `gc_budget_line_item_bid_invitation_file_sha1` ASC, `created` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY gblibi.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpGcBudgetLineItemBidInvitation = new GcBudgetLineItemBidInvitation($database);
			$sqlOrderByColumns = $tmpGcBudgetLineItemBidInvitation->constructSqlOrderByColumns($arrOrderByAttributes);

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
	gblibi.*

FROM `gc_budget_line_item_bid_invitations` gblibi
WHERE gblibi.`gc_budget_line_item_bid_invitation_file_manager_file_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `gc_budget_line_item_id` ASC, `gc_budget_line_item_bid_invitation_sequence_number` ASC, `gc_budget_line_item_bid_invitation_file_manager_file_id` ASC, `gc_budget_line_item_bid_invitation_file_sha1` ASC, `created` ASC, `sort_order` ASC
		$arrValues = array($gc_budget_line_item_bid_invitation_file_manager_file_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrGcBudgetLineItemBidInvitationsByGcBudgetLineItemBidInvitationFileManagerFileId = array();
		while ($row = $db->fetch()) {
			$gc_budget_line_item_bid_invitation_id = $row['id'];
			$gcBudgetLineItemBidInvitation = self::instantiateOrm($database, 'GcBudgetLineItemBidInvitation', $row, null, $gc_budget_line_item_bid_invitation_id);
			/* @var $gcBudgetLineItemBidInvitation GcBudgetLineItemBidInvitation */
			$arrGcBudgetLineItemBidInvitationsByGcBudgetLineItemBidInvitationFileManagerFileId[$gc_budget_line_item_bid_invitation_id] = $gcBudgetLineItemBidInvitation;
		}

		$db->free_result();

		self::$_arrGcBudgetLineItemBidInvitationsByGcBudgetLineItemBidInvitationFileManagerFileId = $arrGcBudgetLineItemBidInvitationsByGcBudgetLineItemBidInvitationFileManagerFileId;

		return $arrGcBudgetLineItemBidInvitationsByGcBudgetLineItemBidInvitationFileManagerFileId;
	}

	// Loaders: Load By index
	/**
	 * Load by key `gc_budget_line_item_bid_invitation_file_sha1` (`gc_budget_line_item_bid_invitation_file_sha1`).
	 *
	 * @param string $database
	 * @param string $gc_budget_line_item_bid_invitation_file_sha1
	 * @param mixed (Input $options object | null)
	 * @return mixed (single ORM object | false)
	 */
	public static function loadGcBudgetLineItemBidInvitationsByGcBudgetLineItemBidInvitationFileSha1($database, $gc_budget_line_item_bid_invitation_file_sha1, Input $options=null)
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
			self::$_arrGcBudgetLineItemBidInvitationsByGcBudgetLineItemBidInvitationFileSha1 = null;
		}

		$arrGcBudgetLineItemBidInvitationsByGcBudgetLineItemBidInvitationFileSha1 = self::$_arrGcBudgetLineItemBidInvitationsByGcBudgetLineItemBidInvitationFileSha1;
		if (isset($arrGcBudgetLineItemBidInvitationsByGcBudgetLineItemBidInvitationFileSha1) && !empty($arrGcBudgetLineItemBidInvitationsByGcBudgetLineItemBidInvitationFileSha1)) {
			return $arrGcBudgetLineItemBidInvitationsByGcBudgetLineItemBidInvitationFileSha1;
		}

		$gc_budget_line_item_bid_invitation_file_sha1 = (string) $gc_budget_line_item_bid_invitation_file_sha1;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `gc_budget_line_item_id` ASC, `gc_budget_line_item_bid_invitation_sequence_number` ASC, `gc_budget_line_item_bid_invitation_file_manager_file_id` ASC, `gc_budget_line_item_bid_invitation_file_sha1` ASC, `created` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY gblibi.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpGcBudgetLineItemBidInvitation = new GcBudgetLineItemBidInvitation($database);
			$sqlOrderByColumns = $tmpGcBudgetLineItemBidInvitation->constructSqlOrderByColumns($arrOrderByAttributes);

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
	gblibi.*

FROM `gc_budget_line_item_bid_invitations` gblibi
WHERE gblibi.`gc_budget_line_item_bid_invitation_file_sha1` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `gc_budget_line_item_id` ASC, `gc_budget_line_item_bid_invitation_sequence_number` ASC, `gc_budget_line_item_bid_invitation_file_manager_file_id` ASC, `gc_budget_line_item_bid_invitation_file_sha1` ASC, `created` ASC, `sort_order` ASC
		$arrValues = array($gc_budget_line_item_bid_invitation_file_sha1);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrGcBudgetLineItemBidInvitationsByGcBudgetLineItemBidInvitationFileSha1 = array();
		while ($row = $db->fetch()) {
			$gc_budget_line_item_bid_invitation_id = $row['id'];
			$gcBudgetLineItemBidInvitation = self::instantiateOrm($database, 'GcBudgetLineItemBidInvitation', $row, null, $gc_budget_line_item_bid_invitation_id);
			/* @var $gcBudgetLineItemBidInvitation GcBudgetLineItemBidInvitation */
			$arrGcBudgetLineItemBidInvitationsByGcBudgetLineItemBidInvitationFileSha1[$gc_budget_line_item_bid_invitation_id] = $gcBudgetLineItemBidInvitation;
		}

		$db->free_result();

		self::$_arrGcBudgetLineItemBidInvitationsByGcBudgetLineItemBidInvitationFileSha1 = $arrGcBudgetLineItemBidInvitationsByGcBudgetLineItemBidInvitationFileSha1;

		return $arrGcBudgetLineItemBidInvitationsByGcBudgetLineItemBidInvitationFileSha1;
	}

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all gc_budget_line_item_bid_invitations records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllGcBudgetLineItemBidInvitations($database, Input $options=null)
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
			self::$_arrAllGcBudgetLineItemBidInvitations = null;
		}

		$arrAllGcBudgetLineItemBidInvitations = self::$_arrAllGcBudgetLineItemBidInvitations;
		if (isset($arrAllGcBudgetLineItemBidInvitations) && !empty($arrAllGcBudgetLineItemBidInvitations)) {
			return $arrAllGcBudgetLineItemBidInvitations;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `gc_budget_line_item_id` ASC, `gc_budget_line_item_bid_invitation_sequence_number` ASC, `gc_budget_line_item_bid_invitation_file_manager_file_id` ASC, `gc_budget_line_item_bid_invitation_file_sha1` ASC, `created` ASC, `sort_order` ASC
		$sqlOrderBy = "\nORDER BY gblibi.`sort_order` ASC";
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpGcBudgetLineItemBidInvitation = new GcBudgetLineItemBidInvitation($database);
			$sqlOrderByColumns = $tmpGcBudgetLineItemBidInvitation->constructSqlOrderByColumns($arrOrderByAttributes);

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
	gblibi.*

FROM `gc_budget_line_item_bid_invitations` gblibi{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `gc_budget_line_item_id` ASC, `gc_budget_line_item_bid_invitation_sequence_number` ASC, `gc_budget_line_item_bid_invitation_file_manager_file_id` ASC, `gc_budget_line_item_bid_invitation_file_sha1` ASC, `created` ASC, `sort_order` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllGcBudgetLineItemBidInvitations = array();
		while ($row = $db->fetch()) {
			$gc_budget_line_item_bid_invitation_id = $row['id'];
			$gcBudgetLineItemBidInvitation = self::instantiateOrm($database, 'GcBudgetLineItemBidInvitation', $row, null, $gc_budget_line_item_bid_invitation_id);
			/* @var $gcBudgetLineItemBidInvitation GcBudgetLineItemBidInvitation */
			$arrAllGcBudgetLineItemBidInvitations[$gc_budget_line_item_bid_invitation_id] = $gcBudgetLineItemBidInvitation;
		}

		$db->free_result();

		self::$_arrAllGcBudgetLineItemBidInvitations = $arrAllGcBudgetLineItemBidInvitations;

		return $arrAllGcBudgetLineItemBidInvitations;
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
INTO `gc_budget_line_item_bid_invitations`
(`gc_budget_line_item_id`, `gc_budget_line_item_bid_invitation_sequence_number`, `gc_budget_line_item_bid_invitation_file_manager_file_id`, `gc_budget_line_item_bid_invitation_file_sha1`, `created`, `sort_order`)
VALUES (?, ?, ?, ?, ?, ?)
ON DUPLICATE KEY UPDATE `gc_budget_line_item_bid_invitation_file_manager_file_id` = ?, `gc_budget_line_item_bid_invitation_file_sha1` = ?, `created` = ?, `sort_order` = ?
";
		$arrValues = array($this->gc_budget_line_item_id, $this->gc_budget_line_item_bid_invitation_sequence_number, $this->gc_budget_line_item_bid_invitation_file_manager_file_id, $this->gc_budget_line_item_bid_invitation_file_sha1, $this->created, $this->sort_order, $this->gc_budget_line_item_bid_invitation_file_manager_file_id, $this->gc_budget_line_item_bid_invitation_file_sha1, $this->created, $this->sort_order);
		$db->execute($query, $arrValues, MYSQLI_STORE_RESULT);
		$gc_budget_line_item_bid_invitation_id = $db->insertId;
		$db->free_result();

		return $gc_budget_line_item_bid_invitation_id;
	}

	// Save: insert ignore

	public static function findNextGcBudgetLineItemBidInvitationSequenceNumber($database, $gc_budget_line_item_id)
	{
		$next_gc_budget_line_item_bid_invitation_sequence_number = 1;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT MAX(`gc_budget_line_item_bid_invitation_sequence_number`) AS 'max_gc_budget_line_item_bid_invitation_sequence_number'
FROM `gc_budget_line_item_bid_invitations`
WHERE `gc_budget_line_item_id` = ?
";
		$arrValues = array($gc_budget_line_item_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$max_gc_budget_line_item_bid_invitation_sequence_number = $row['max_gc_budget_line_item_bid_invitation_sequence_number'];
			$next_gc_budget_line_item_bid_invitation_sequence_number = $max_gc_budget_line_item_bid_invitation_sequence_number + 1;
		}

		return $next_gc_budget_line_item_bid_invitation_sequence_number;
	}
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */

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
 * BidSpreadNote.
 *
 * @category   Framework
 * @package    BidSpreadNote
 */

/**
 * @see IntegratedMapper
 */
//require_once('lib/common/IntegratedMapper.php');

class BidSpreadNote extends IntegratedMapper
{
	/**
	 * Class name for use in deltifyAndSave().
	 */
	protected $_className = 'BidSpreadNote';

	/**
	 * Table name for this Integrated Mapper.
	 *
	 * @var string
	 */
	protected $_table = 'bid_spread_notes';

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
	 * No Unique Indexes, Just a Primary Key
	 *
	 * 'db_table_attribute' => 'type'
	 *
	 * @var array
	 */
	protected $_arrUniqueness = array(
		'unique_bid_spread_note_via_primary_key' => array(
			'bid_spread_note_id' => 'int'
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
		'id' => 'bid_spread_note_id',

		'bid_spread_id' => 'bid_spread_id',
		'created_by_contact_id' => 'created_by_contact_id',

		'bid_spread_note' => 'bid_spread_note',
		'created' => 'created'
	);

	// ORM properties (instance variables) derived from the Database table attributes (fields)
	public $bid_spread_note_id;

	public $bid_spread_id;
	public $created_by_contact_id;

	public $bid_spread_note;
	public $created;

	// Other Properties
	//protected $_otherPropertyHere;

	// HTML ENTITY ENCODED ORM string properties
	public $escaped_bid_spread_note;

	// HTML ENTITY ENCODED NL2BR ORM string properties
	public $escaped_bid_spread_note_nl2br;

	// Static Class Properties - Data Loaded By Foreign Key (0 or more records)
	protected static $_arrBidSpreadNotesByBidSpreadId;
	protected static $_arrBidSpreadNotesByCreatedByContactId;

	// Static Class Properties - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Properties - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Properties - Data Loaded Without A WHERE Clause (All Records)
	protected static $_arrAllBidSpreadNotes;

	// Foreign Key Objects
	private $_bidSpread;
	private $_createdByContact;

	/**
	 * Constructor
	 */
	public function __construct($database, $table='bid_spread_notes')
	{
		parent::__construct($table);
		$this->setDatabase($database);
	}

	// Foreign Key Object Accessor Methods
	public function getBidSpread()
	{
		if (isset($this->_bidSpread)) {
			return $this->_bidSpread;
		} else {
			return null;
		}
	}

	public function setBidSpread($bidSpread)
	{
		$this->_bidSpread = $bidSpread;
	}

	public function getCreatedByContact()
	{
		if (isset($this->_createdByContact)) {
			return $this->_createdByContact;
		} else {
			return null;
		}
	}

	public function setCreatedByContact($createdByContact)
	{
		$this->_createdByContact = $createdByContact;
	}

	// Static Class Property Accessor Methods - Data Loaded By Foreign Key (0 or more records)
	public static function getArrBidSpreadNotesByBidSpreadId()
	{
		if (isset(self::$_arrBidSpreadNotesByBidSpreadId)) {
			return self::$_arrBidSpreadNotesByBidSpreadId;
		} else {
			return null;
		}
	}

	public static function setArrBidSpreadNotesByBidSpreadId($arrBidSpreadNotesByBidSpreadId)
	{
		self::$_arrBidSpreadNotesByBidSpreadId = $arrBidSpreadNotesByBidSpreadId;
	}

	public static function getArrBidSpreadNotesByCreatedByContactId()
	{
		if (isset(self::$_arrBidSpreadNotesByCreatedByContactId)) {
			return self::$_arrBidSpreadNotesByCreatedByContactId;
		} else {
			return null;
		}
	}

	public static function setArrBidSpreadNotesByCreatedByContactId($arrBidSpreadNotesByCreatedByContactId)
	{
		self::$_arrBidSpreadNotesByCreatedByContactId = $arrBidSpreadNotesByCreatedByContactId;
	}

	// Static Class Property Accessor Methods - Data Loaded By Non-Unique Index That Is Not A Foreign Key (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded By An Additionally Indexed Attribute Via A Covering Index (0 or more records)

	// Static Class Property Accessor Methods - Data Loaded Without A WHERE Clause (All Records)
	public static function getArrAllBidSpreadNotes()
	{
		if (isset(self::$_arrAllBidSpreadNotes)) {
			return self::$_arrAllBidSpreadNotes;
		} else {
			return null;
		}
	}

	public static function setArrAllBidSpreadNotes($arrAllBidSpreadNotes)
	{
		self::$_arrAllBidSpreadNotes = $arrAllBidSpreadNotes;
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
	 * @param int $bid_spread_note_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findById($database, $bid_spread_note_id, $table='bid_spread_notes', $module='BidSpreadNote')
	{
		$bidSpreadNote = parent::findById($database, $bid_spread_note_id, $table, $module);

		return $bidSpreadNote;
	}

	// Extended Finder: Find By pk Extended (a single auto int id or a single non auto int pk)
	/**
	 * Similar to FindById, but with SQL as starter code for more complex joins.
	 *
	 * @param string $database
	 * @param int $bid_spread_note_id
	 * @return mixed (single ORM object | false)
	 */
	public static function findBidSpreadNoteByIdExtended($database, $bid_spread_note_id)
	{
		$bid_spread_note_id = (int) $bid_spread_note_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		$query =
"
SELECT

	bsn_fk_bs.`id` AS 'bsn_fk_bs__bid_spread_id',
	bsn_fk_bs.`gc_budget_line_item_id` AS 'bsn_fk_bs__gc_budget_line_item_id',
	bsn_fk_bs.`bid_spread_sequence_number` AS 'bsn_fk_bs__bid_spread_sequence_number',
	bsn_fk_bs.`bid_spread_status_id` AS 'bsn_fk_bs__bid_spread_status_id',
	bsn_fk_bs.`bid_spreadsheet_data_sha1` AS 'bsn_fk_bs__bid_spreadsheet_data_sha1',
	bsn_fk_bs.`bid_spread_submitter_gc_project_manager_contact_id` AS 'bsn_fk_bs__bid_spread_submitter_gc_project_manager_contact_id',
	bsn_fk_bs.`bid_spread_approver_gc_project_executive_contact_id` AS 'bsn_fk_bs__bid_spread_approver_gc_project_executive_contact_id',
	bsn_fk_bs.`bid_spread_bid_total` AS 'bsn_fk_bs__bid_spread_bid_total',
	bsn_fk_bs.`bid_spread_approved_value` AS 'bsn_fk_bs__bid_spread_approved_value',
	bsn_fk_bs.`unsigned_bid_spread_pdf_file_manager_file_id` AS 'bsn_fk_bs__unsigned_bid_spread_pdf_file_manager_file_id',
	bsn_fk_bs.`signed_bid_spread_pdf_file_manager_file_id` AS 'bsn_fk_bs__signed_bid_spread_pdf_file_manager_file_id',
	bsn_fk_bs.`unsigned_bid_spread_xls_file_manager_file_id` AS 'bsn_fk_bs__unsigned_bid_spread_xls_file_manager_file_id',
	bsn_fk_bs.`signed_bid_spread_xls_file_manager_file_id` AS 'bsn_fk_bs__signed_bid_spread_xls_file_manager_file_id',
	bsn_fk_bs.`modified` AS 'bsn_fk_bs__modified',
	bsn_fk_bs.`created` AS 'bsn_fk_bs__created',
	bsn_fk_bs.`display_linked_cost_codes_flag` AS 'bsn_fk_bs__display_linked_cost_codes_flag',
	bsn_fk_bs.`sort_order` AS 'bsn_fk_bs__sort_order',

	bsn_fk_created_by_c.`id` AS 'bsn_fk_created_by_c__contact_id',
	bsn_fk_created_by_c.`user_company_id` AS 'bsn_fk_created_by_c__user_company_id',
	bsn_fk_created_by_c.`user_id` AS 'bsn_fk_created_by_c__user_id',
	bsn_fk_created_by_c.`contact_company_id` AS 'bsn_fk_created_by_c__contact_company_id',
	bsn_fk_created_by_c.`email` AS 'bsn_fk_created_by_c__email',
	bsn_fk_created_by_c.`name_prefix` AS 'bsn_fk_created_by_c__name_prefix',
	bsn_fk_created_by_c.`first_name` AS 'bsn_fk_created_by_c__first_name',
	bsn_fk_created_by_c.`additional_name` AS 'bsn_fk_created_by_c__additional_name',
	bsn_fk_created_by_c.`middle_name` AS 'bsn_fk_created_by_c__middle_name',
	bsn_fk_created_by_c.`last_name` AS 'bsn_fk_created_by_c__last_name',
	bsn_fk_created_by_c.`name_suffix` AS 'bsn_fk_created_by_c__name_suffix',
	bsn_fk_created_by_c.`title` AS 'bsn_fk_created_by_c__title',
	bsn_fk_created_by_c.`vendor_flag` AS 'bsn_fk_created_by_c__vendor_flag',

	bsn.*

FROM `bid_spread_notes` bsn
	INNER JOIN `bid_spreads` bsn_fk_bs ON bsn.`bid_spread_id` = bsn_fk_bs.`id`
	LEFT OUTER JOIN `contacts` bsn_fk_created_by_c ON bsn.`created_by_contact_id` = bsn_fk_created_by_c.`id`
WHERE bsn.`id` = ?
";
		$arrValues = array($bid_spread_note_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		if ($row) {
			$bid_spread_note_id = $row['id'];
			$bidSpreadNote = self::instantiateOrm($database, 'BidSpreadNote', $row, null, $bid_spread_note_id);
			/* @var $bidSpreadNote BidSpreadNote */
			$bidSpreadNote->convertPropertiesToData();

			if (isset($row['bid_spread_id'])) {
				$bid_spread_id = $row['bid_spread_id'];
				$row['bsn_fk_bs__id'] = $bid_spread_id;
				$bidSpread = self::instantiateOrm($database, 'BidSpread', $row, null, $bid_spread_id, 'bsn_fk_bs__');
				/* @var $bidSpread BidSpread */
				$bidSpread->convertPropertiesToData();
			} else {
				$bidSpread = false;
			}
			$bidSpreadNote->setBidSpread($bidSpread);

			if (isset($row['created_by_contact_id'])) {
				$created_by_contact_id = $row['created_by_contact_id'];
				$row['bsn_fk_created_by_c__id'] = $created_by_contact_id;
				$createdByContact = self::instantiateOrm($database, 'Contact', $row, null, $created_by_contact_id, 'bsn_fk_created_by_c__');
				/* @var $createdByContact Contact */
				$createdByContact->convertPropertiesToData();
			} else {
				$createdByContact = false;
			}
			$bidSpreadNote->setCreatedByContact($createdByContact);

			return $bidSpreadNote;
		} else {
			return false;
		}
	}

	// Finders: Find By Unique Index

	// Loaders: Load By pk List (list of auto int ids or other non auto int pk list)
	/**
	 * Load zero or more records by an id list (array of auto int primary keys).
	 *
	 * @param string $database
	 * @param array $arrBidSpreadNoteIds
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadBidSpreadNotesByArrBidSpreadNoteIds($database, $arrBidSpreadNoteIds, Input $options=null)
	{
		if (empty($arrBidSpreadNoteIds)) {
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
		// ORDER BY `id` ASC, `bid_spread_id` ASC, `created_by_contact_id` ASC, `bid_spread_note` ASC, `created` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpBidSpreadNote = new BidSpreadNote($database);
			$sqlOrderByColumns = $tmpBidSpreadNote->constructSqlOrderByColumns($arrOrderByAttributes);

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

		foreach ($arrBidSpreadNoteIds as $k => $bid_spread_note_id) {
			$bid_spread_note_id = (int) $bid_spread_note_id;
			$arrBidSpreadNoteIds[$k] = $db->escape($bid_spread_note_id);
		}
		$csvBidSpreadNoteIds = join(',', $arrBidSpreadNoteIds);

		$query =
"
SELECT

	bsn.*

FROM `bid_spread_notes` bsn
WHERE bsn.`id` IN ($csvBidSpreadNoteIds){$sqlOrderBy}{$sqlLimit}
";
		$arrValues = array();
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);
		$row = $db->fetch();
		$db->free_result();

		$arrBidSpreadNotesByCsvBidSpreadNoteIds = array();
		while ($row = $db->fetch()) {
			$bid_spread_note_id = $row['id'];
			$bidSpreadNote = self::instantiateOrm($database, 'BidSpreadNote', $row, null, $bid_spread_note_id);
			/* @var $bidSpreadNote BidSpreadNote */
			$bidSpreadNote->convertPropertiesToData();

			$arrBidSpreadNotesByCsvBidSpreadNoteIds[$bid_spread_note_id] = $bidSpreadNote;
		}

		$db->free_result();

		return $arrBidSpreadNotesByCsvBidSpreadNoteIds;
	}

	// Loaders: Load By Foreign Key
	/**
	 * Load by constraint `bid_spread_notes_fk_bs` foreign key (`bid_spread_id`) references `bid_spreads` (`id`) on delete cascade on update cascade.
	 *
	 * @param string $database
	 * @param int $bid_spread_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadBidSpreadNotesByBidSpreadId($database, $bid_spread_id, Input $options=null)
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
			self::$_arrBidSpreadNotesByBidSpreadId = null;
		}

		$arrBidSpreadNotesByBidSpreadId = self::$_arrBidSpreadNotesByBidSpreadId;
		if (isset($arrBidSpreadNotesByBidSpreadId) && !empty($arrBidSpreadNotesByBidSpreadId)) {
			return $arrBidSpreadNotesByBidSpreadId;
		}

		$bid_spread_id = (int) $bid_spread_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `bid_spread_id` ASC, `created_by_contact_id` ASC, `bid_spread_note` ASC, `created` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpBidSpreadNote = new BidSpreadNote($database);
			$sqlOrderByColumns = $tmpBidSpreadNote->constructSqlOrderByColumns($arrOrderByAttributes);

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
	bsn.*

FROM `bid_spread_notes` bsn
WHERE bsn.`bid_spread_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `bid_spread_id` ASC, `created_by_contact_id` ASC, `bid_spread_note` ASC, `created` ASC
		$arrValues = array($bid_spread_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrBidSpreadNotesByBidSpreadId = array();
		while ($row = $db->fetch()) {
			$bid_spread_note_id = $row['id'];
			$bidSpreadNote = self::instantiateOrm($database, 'BidSpreadNote', $row, null, $bid_spread_note_id);
			/* @var $bidSpreadNote BidSpreadNote */
			$arrBidSpreadNotesByBidSpreadId[$bid_spread_note_id] = $bidSpreadNote;
		}

		$db->free_result();

		self::$_arrBidSpreadNotesByBidSpreadId = $arrBidSpreadNotesByBidSpreadId;

		return $arrBidSpreadNotesByBidSpreadId;
	}

	/**
	 * Load by constraint `bid_spread_notes_fk_created_by_c` foreign key (`created_by_contact_id`) references `contacts` (`id`) on delete restrict on update cascade.
	 *
	 * @param string $database
	 * @param int $created_by_contact_id
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadBidSpreadNotesByCreatedByContactId($database, $created_by_contact_id, Input $options=null)
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
			self::$_arrBidSpreadNotesByCreatedByContactId = null;
		}

		$arrBidSpreadNotesByCreatedByContactId = self::$_arrBidSpreadNotesByCreatedByContactId;
		if (isset($arrBidSpreadNotesByCreatedByContactId) && !empty($arrBidSpreadNotesByCreatedByContactId)) {
			return $arrBidSpreadNotesByCreatedByContactId;
		}

		$created_by_contact_id = (int) $created_by_contact_id;

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `bid_spread_id` ASC, `created_by_contact_id` ASC, `bid_spread_note` ASC, `created` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpBidSpreadNote = new BidSpreadNote($database);
			$sqlOrderByColumns = $tmpBidSpreadNote->constructSqlOrderByColumns($arrOrderByAttributes);

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
	bsn.*

FROM `bid_spread_notes` bsn
WHERE bsn.`created_by_contact_id` = ?{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `bid_spread_id` ASC, `created_by_contact_id` ASC, `bid_spread_note` ASC, `created` ASC
		$arrValues = array($created_by_contact_id);
		$db->execute($query, $arrValues, MYSQLI_USE_RESULT);

		$arrBidSpreadNotesByCreatedByContactId = array();
		while ($row = $db->fetch()) {
			$bid_spread_note_id = $row['id'];
			$bidSpreadNote = self::instantiateOrm($database, 'BidSpreadNote', $row, null, $bid_spread_note_id);
			/* @var $bidSpreadNote BidSpreadNote */
			$arrBidSpreadNotesByCreatedByContactId[$bid_spread_note_id] = $bidSpreadNote;
		}

		$db->free_result();

		self::$_arrBidSpreadNotesByCreatedByContactId = $arrBidSpreadNotesByCreatedByContactId;

		return $arrBidSpreadNotesByCreatedByContactId;
	}

	// Loaders: Load By index

	// Loaders: Load By additionally indexed attribute

	// Loaders: Load All Records
	/**
	 * Load all bid_spread_notes records.
	 *
	 * @param string $database
	 * @param mixed (Input $options object | null)
	 * @return mixed (array ORM List | empty array)
	 */
	public static function loadAllBidSpreadNotes($database, Input $options=null)
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
			self::$_arrAllBidSpreadNotes = null;
		}

		$arrAllBidSpreadNotes = self::$_arrAllBidSpreadNotes;
		if (isset($arrAllBidSpreadNotes) && !empty($arrAllBidSpreadNotes)) {
			return $arrAllBidSpreadNotes;
		}

		$db = DBI::getInstance($database);
		/* @var $db DBI_mysqli */

		// Possibly override or combine these lines of code if a custom order by clause is needed in conjunction with the dynamic inputs.
		// ORDER BY `id` ASC, `bid_spread_id` ASC, `created_by_contact_id` ASC, `bid_spread_note` ASC, `created` ASC
		$sqlOrderBy = '';
		if (isset($arrOrderByAttributes) && !empty($arrOrderByAttributes)) {
			$tmpBidSpreadNote = new BidSpreadNote($database);
			$sqlOrderByColumns = $tmpBidSpreadNote->constructSqlOrderByColumns($arrOrderByAttributes);

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
	bsn.*

FROM `bid_spread_notes` bsn{$sqlOrderBy}{$sqlLimit}
";
// LIMIT 10
// ORDER BY `id` ASC, `bid_spread_id` ASC, `created_by_contact_id` ASC, `bid_spread_note` ASC, `created` ASC
		$db->query($query, MYSQLI_USE_RESULT);

		$arrAllBidSpreadNotes = array();
		while ($row = $db->fetch()) {
			$bid_spread_note_id = $row['id'];
			$bidSpreadNote = self::instantiateOrm($database, 'BidSpreadNote', $row, null, $bid_spread_note_id);
			/* @var $bidSpreadNote BidSpreadNote */
			$arrAllBidSpreadNotes[$bid_spread_note_id] = $bidSpreadNote;
		}

		$db->free_result();

		self::$_arrAllBidSpreadNotes = $arrAllBidSpreadNotes;

		return $arrAllBidSpreadNotes;
	}

	// Save: insert on duplicate key update

	// Save: insert ignore
}

/**
 * Framework standard footer comments.
 *
 * No closing ?> tag to prevent the injection of whitespace.
 */
